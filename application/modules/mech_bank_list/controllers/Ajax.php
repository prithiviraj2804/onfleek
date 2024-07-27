<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function create()
    {
        $this->load->model('mech_bank_list/mdl_mech_bank_list');        

        if ($this->mdl_mech_bank_list->run_validation()) {
            $bank_id = $this->input->post('bank_id');
            $bank_id = $this->mdl_mech_bank_list->save($bank_id);

            if ($this->input->post('entity_id') != '' && $this->input->post('module_type') == 'S') {
                $bankList = $this->mdl_mech_bank_list->where('mech_workshop_bank_list.workshop_id', $this->session->userdata('work_shop_id'))->where('mech_workshop_bank_list.entity_id', $this->input->post('entity_id'))->where('mech_workshop_bank_list.module_type', 'S')->get()->result();
            } elseif ($this->input->post('entity_id') != '' && $this->input->post('module_type') == 'C') {
                $bankList = $this->mdl_mech_bank_list->where('mech_workshop_bank_list.workshop_id', $this->session->userdata('work_shop_id'))->where('mech_workshop_bank_list.entity_id', $this->input->post('entity_id'))->where('mech_workshop_bank_list.module_type', 'C')->get()->result();
            } else {
                $bankList = array();
            }
            $response = array(
                'success' => 1,
                'bankList' => $bankList,
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors(),
            );
        }

        echo json_encode($response);
    }

    public function model_add_bank($type, $bank_id = null, $entity_id = null)
    {
        $this->load->model('mech_bank_list/mdl_mech_bank_list');
        
        $this->load->module('layout');
        if ($bank_id != '' && $bank_id > 0) {
            $bank_details = $this->mdl_mech_bank_list->where('mech_workshop_bank_list.workshop_id', $this->session->userdata('work_shop_id'))->where('mech_workshop_bank_list.entity_id', $entity_id)->where('mech_workshop_bank_list.bank_id', $bank_id)->get()->row();
        } else {
            $bank_details = array();
        }

        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
        }else{
            $branch_list = array();
        }
        
        $data = array(
            'branch_list' => $branch_list,
            'entity_id' => $entity_id,
            'module_type' => $type,
            'bank_id' => $bank_id,
            'bank_details' => $bank_details
        );

        $this->layout->load_view('mech_bank_list/model_add_bank', $data);
    }

    public function delete()
    {
        $bank_id = $this->input->post('bank_id');
        $this->db->where('bank_id', $bank_id);
        $this->db->update('mech_workshop_bank_list', array('bank_status' => 'D'));
        $response = array(
                'success' => 1,
            );
        echo json_encode($response);
    }

    
    public function savetransaction(){ 
              
        $this->load->model('mech_bank_list/mdl_workshop_bank_trans_dtls');
        $deposit_id = $this->input->post('deposit_id')?$this->input->post('deposit_id'):NULL;

        if ($this->mdl_workshop_bank_trans_dtls->run_validation()) {
            
            $deposit_id = $this->mdl_workshop_bank_trans_dtls->save($deposit_id);
           
            if($deposit_id){
                $existing_amount = $this->input->post('existing_amount')?$this->input->post('existing_amount'):0;
                $amount = $this->input->post('amount')?$this->input->post('amount'):0;
                if($existing_amount != $amount){
                    $this->db->select('*');
                    $this->db->from('mech_workshop_bank_list');
                    $this->db->where('bank_id',$this->input->post('bank_id'));
                    $bankbalance = $this->db->get()->row();
    
                    if($existing_amount > $amount){
                        $grandtotal = $existing_amount - $amount;
                        $current_balance = $bankbalance->current_balance - $this->input->post('amount');
                    }else{
                        $grandtotal = $amount - $existing_amount;
                        $current_balance = $bankbalance->current_balance + $this->input->post('amount');
                    }
    
                    $updateAccountbalance = array(
                        'current_balance' => $current_balance,
                    );
                    
                    $this->db->where('bank_id',$this->input->post('bank_id'));
                    $bank_id = $this->db->update('mech_workshop_bank_list', $updateAccountbalance);
                }
            }

            $response = array(
                'success' => 1,
                'deposit_id' => $deposit_id,
            );

        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors(),
            );
        }

        echo json_encode($response);
    }

    public function get_filter_list(){

        $this->load->model('mech_bank_list/mdl_workshop_bank_trans_dtls');

        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;
        if($this->input->post('from_date')){
            $this->mdl_workshop_bank_trans_dtls->where('workshop_bank_trans_dtls.payment_date >=', date_to_mysql($this->input->post('from_date')));
        }
        if($this->input->post('to_date')){
            $this->mdl_workshop_bank_trans_dtls->where('workshop_bank_trans_dtls.payment_date <=', date_to_mysql($this->input->post('to_date')));
        }
        if($this->input->post('w_branch_id')){
            $this->mdl_workshop_bank_trans_dtls->where('workshop_bank_trans_dtls.w_branch_id', $this->input->post('w_branch_id'));
        }

        $rowCount = $this->mdl_workshop_bank_trans_dtls->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

         if($this->input->post('from_date')){
            $this->mdl_workshop_bank_trans_dtls->where('workshop_bank_trans_dtls.payment_date >=',date_to_mysql($this->input->post('from_date')));
        }
        if($this->input->post('to_date')){
            $this->mdl_workshop_bank_trans_dtls->where('workshop_bank_trans_dtls.payment_date <=', date_to_mysql($this->input->post('to_date')));
        }
        if($this->input->post('w_branch_id')){
            $this->mdl_workshop_bank_trans_dtls->where('workshop_bank_trans_dtls.w_branch_id', $this->input->post('w_branch_id'));
        }
        $this->mdl_workshop_bank_trans_dtls->limit($limit,$start);
        $transactions = $this->mdl_workshop_bank_trans_dtls->get()->result();           

        $response = array(
            'success' => 1,
            'transactions' => $transactions, 
            'createLinks' => $createLinks,
        );
        echo json_encode($response);
    }

    public function getUploadedImages(){
        $this->load->model('mech_bank_list/mdl_workshop_bank_trans_dtls');
        if($this->input->post('url_key')){
            $productImages = $this->mdl_workshop_bank_trans_dtls->getUploadedImages($this->input->post('url_key'));
            if(count($productImages) > 0){
                $response = array(
                    'success' => 1,
                    'productImages' => $productImages,
                    'msg' => '',
                );
            }else{
                $response = array(
                    'success' => 0,
                    'productImages' => '',
                    'msg' => 'No data Found',
                );
            }
        }else{
            $response = array(
                'success' => 0,
                'productImages' => '',
                'msg' => 'url-key not Found',
            );
        }
        
        echo json_encode($response);
        exit();
    }

}
