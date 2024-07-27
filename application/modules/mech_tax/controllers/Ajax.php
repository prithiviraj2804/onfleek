<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('mech_tax/mdl_mech_tax');
    }

    public function create()
    {

        $tax_id = $this->input->post('tax_id');

        if ($this->mdl_mech_tax->run_validation()) {

            if ($this->input->post('tax_id')) {
                $check = $this->db->select('tax_name')->from('mech_tax')->where('tax_name',$this->input->post('tax_name'))->where('status !=','D')->where_in('workshop_id',array(1,$this->session->userdata('work_shop_id')))->where_not_in('tax_id',$this->input->post('tax_id'))->get()->result();   
                if (!empty($check)) {
                    $response = array(
                        'success' => 2,
                    );
                    echo json_encode($response);
                    exit();
                }
            }else{
                $check = $this->db->select('tax_name')->from('mech_tax')->where('tax_name',$this->input->post('tax_name'))->where('status !=','D')->where_in('workshop_id',array(1,$this->session->userdata('work_shop_id')))->get()->result();   
                if (!empty($check)) {
                    $response = array(
                        'success' => 2,
                    );
                    echo json_encode($response);
                    exit();
                }
            }
            
            $tax_id = $this->mdl_mech_tax->save($tax_id);

            if($tax_id){
                $response = array(
                    'success' => 1,
                    'tax_id' => $tax_id,
                    'tax_list' => $this->db->where('tax_id',$tax_id)->from('mech_tax')->get()->result(),
                );
            }else{
                $response = array(
                    'success' => 0,
                );
            }

        }else{
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
        }
        echo json_encode($response);
        exit();
    }

    public function model_add_tax($tax_id = null)
    {
        $this->load->module('layout');
        if ($tax_id != '' && $tax_id > 0) {
            $tax_list = $this->mdl_mech_tax->where('tax_id', $tax_id)->get()->row();
        } else {
            $tax_list = array();
        }
        
        $data = array(
            'tax_id' => $tax_id,
            'tax_list' => $tax_list
        );

        $this->layout->load_view('mech_tax/model_add_tax', $data);
    }

    public function delete()
    {
        $tax_id = $this->input->post('tax_id');
        $this->db->where('tax_id', $tax_id);
        $this->db->update('mech_tax', array('status' => 'D'));
        $response = array(
                'success' => 1,
            );
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

    public function gettaxDetails($tax_id = NULL){

        
        $tax_id = $this->input->post('tax_id');

        $tax_detail = $this->mdl_mech_tax->where('tax_id' , $tax_id)->get()->result();
        
        if(!empty($tax_detail)){
            $response = array(
                'success' => 1,
                'data' => $tax_detail,
            );
        }else{
            $response = array(
                'success' => 0,
                'data' => '',
            );
        }
        echo json_encode($response);
        exit();

    }
}
