<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


class Mech_tax extends Admin_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_mech_tax');
    }

    public function transaction_list(){
        $limit = 15;
        $query = $this->mdl_workshop_bank_trans_dtls->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();
        $this->mdl_workshop_bank_trans_dtls->limit($limit);
        $transactions = $this->mdl_workshop_bank_trans_dtls->get()->result();


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

        $this->layout->set(
            array(
                'transactions' => $transactions,
                'branch_list' =>  $branch_list,
                'createLinks' => $createLinks
            )
        );
        $this->layout->buffer('content', 'mech_bank_list/transaction_list')->render();

    }

    public function create($deposit_id = NULL)
    {
        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');
        if($deposit_id){
            $transaction_details = $this->db->query("SELECT * FROM workshop_bank_trans_dtls WHERE deposit_id = ".$deposit_id." ")->row();
            $breadcrumb = "lable481";
        }else{
            $transaction_details = array();
            $breadcrumb = "lable480";
        }

        if($this->session->userdata('user_type') == 3){
            $this->mdl_mech_employee->where('mech_employee.workshop_id='.$work_shop_id.'');
        }elseif($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 || $this->session->userdata('user_type') == 6){
            $this->mdl_mech_employee->where('mech_employee.workshop_id='.$work_shop_id.' AND mech_employee.w_branch_id='.$branch_id.'');
        }
        $employee_list = $this->mdl_mech_employee->get()->result();

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

        $bank_list = $this->mdl_mech_bank_list->where('mech_workshop_bank_list.workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_workshop_bank_list.module_type',array('B','W'))->get()->result();

        $this->layout->set('is_shift', $this->db->query("SELECT shift FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." ")->row()->shift);
        $this->layout->set('shift_list', $this->db->query('SELECT shift_id,shift_name FROM mech_shift')->result());
        $this->layout->set(array(
            'deposit_id' => $deposit_id,
            'bank_list' => $bank_list,
        	'breadcrumb' => $breadcrumb,
            'branch_list' => $branch_list,
            'transaction_details' => $transaction_details,
            'employee_list' => $employee_list,
            'payment_methods' => $this->mdl_payment_methods->get()->result()
        ));

        $this->layout->buffer('content', 'mech_bank_list/create')->render();
    }

    public function delete()
    {
        $id = $this->input->post('id');
        
        $this->db->select('*');
        $this->db->from('workshop_bank_trans_dtls');
        $this->db->where('deposit_id',$this->input->post('id'));
        $transactionDetail = $this->db->get()->row();

        $this->db->select('*');
        $this->db->from('mech_workshop_bank_list');
        $this->db->where('bank_id',$transactionDetail->bank_id);
        $bankbalance = $this->db->get()->row();

        $current_balance = $bankbalance->current_balance - $transactionDetail->amount;

        $updateAccountbalance = array(
            'current_balance' => $current_balance,
        );

        $this->db->where('bank_id',$transactionDetail->bank_id);
        $bank_id = $this->db->update('mech_workshop_bank_list', $updateAccountbalance);

		$this->db->where('deposit_id', $id);
		$this->db->update('workshop_bank_trans_dtls', array('status'=>2));
		$response = array(
            'success' => 1
        );

		echo json_encode($response);
    }

}