<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mech_Expense extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mech_invoice_groups/mdl_mech_invoice_groups');
        $this->load->model('mech_employee/mdl_mech_employee');
        $this->load->model('mech_expense/mdl_mech_expense');
        $this->load->model('payment_methods/mdl_payment_methods');
        $this->load->model('mech_bank_list/mdl_workshop_bank_trans_dtls');
        $this->load->model('workshop_branch/mdl_workshop_branch'); 

    }

    public function index($page = 0)
    {

        $limit = 15;
        $query = $this->mdl_mech_expense->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();
        $this->mdl_mech_expense->limit($limit);
        $expense_list = $this->mdl_mech_expense->get()->result();

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
                'expense_list' => $expense_list,
                'branch_list' => $branch_list,
                'expense_category_items' => $this->db->where('expense_category_type',1)->where_in('expense_category_type',array(1,$this->session->userdata('work_shop_id')))->from('mech_expense_categories')->get()->result(),
                'employee_list' => $this->mdl_mech_employee->get()->result(),
                'createLinks' => $createLinks
            )
        );

        $this->layout->buffer('content', 'mech_expense/index');
        $this->layout->render();
    }
    
 	public function create($expense_id = NULL)
    {
        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');

        if($expense_id){
            $this->mdl_mech_expense->where('expense_id',$expense_id);
            $expense_details = $this->mdl_mech_expense->get()->row();
            $this->mdl_workshop_bank_trans_dtls->where('entity_id', $expense_id);
            $this->mdl_workshop_bank_trans_dtls->where('entity_type','E');
            $bank_details = $this->mdl_workshop_bank_trans_dtls->get()->row();
            $deposit_id = $bank_details->deposit_id;
			$breadcrumb = "lable463";
        }else{
            $expense_details = (object) array();
            $breadcrumb = "lable462";
            $deposit_id = NULL;
        }
        
        $employee_list = $this->mdl_mech_employee->get()->result();


        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
            $bank_list = $this->db->query("SELECT bank_id,module_type,entity_id,workshop_id,w_branch_id,branch_id,account_holder_name,account_number,account_type,bank_name,bank_ifsc_Code,bank_branch,current_balance,is_default FROM mech_workshop_bank_list WHERE module_type IN ('W','B') ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
            $bank_list = $this->db->query("SELECT bank_id,module_type,entity_id,workshop_id,w_branch_id,branch_id,account_holder_name,account_number,account_type,bank_name,bank_ifsc_Code,bank_branch,current_balance,is_default FROM mech_workshop_bank_list WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND module_type IN ('W','B') ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
            $bank_list = $this->db->query("SELECT bank_id,module_type,entity_id,workshop_id,w_branch_id,branch_id,account_holder_name,account_number,account_type,bank_name,bank_ifsc_Code,bank_branch,current_balance,is_default FROM mech_workshop_bank_list WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND created_user_id = ".$this->session->userdata('user_id')." AND module_type IN ('W','B') ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
            $bank_list = $this->db->query("SELECT bank_id,module_type,entity_id,workshop_id,w_branch_id,branch_id,account_holder_name,account_number,account_type,bank_name,bank_ifsc_Code,bank_branch,current_balance,is_default FROM mech_workshop_bank_list WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND module_type IN ('W','B') ")->result();
        }else{
            $branch_list = array();
            $bank_list = array();
        }

        $this->layout->set(array(
            'is_shift' => ($this->db->query("SELECT shift FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." ")->row()->shift),
            'shift_list'=> $this->db->query('SELECT shift_id,shift_name FROM mech_shift')->result(),
            'deposit_id' => $deposit_id,
            'bank_list' => $bank_list,
        	'breadcrumb' => $breadcrumb,
            'expense_id' => $expense_id,
            'branch_list' => $branch_list,
            'bank_list' => $bank_list,
            'invoice_group' => $this->mdl_mech_invoice_groups->where('module_type','expense')->where('status' , 'A')->where('workshop_id' , $work_shop_id)->get()->result(),
            'expense_category_items' => $this->db->where('expense_category_type',1)->from('mech_expense_categories')->get()->result(),
            'expense_details' => $expense_details,
            'employee_list' => $employee_list,
            'payment_methods' => $this->mdl_payment_methods->get()->result()
        ));

        $this->layout->buffer('content', 'mech_expense/create');
        $this->layout->render();
    }

    public function view($expense_id = NULL, $status = NULL)
    {
        if(!$expense_id){
            exit();
        }
        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');
        $expense_details = $this->mdl_mech_expense->where('expense_id='.$expense_id.'')->get()->row();
        $expense_details->expensTypeName = $this->mdl_mech_expense->getExpenseTypeName($expense_details->expense_head_id);
        $expense_details->expensTypeName = $this->mdl_mech_expense->getExpenseTypeName($expense_details->expense_head_id);
        $expense_details->employee_name = $this->mdl_mech_employee->where('employee_id', $expense_details->action_emp_id)->where('employee_status', 1)->get()->row()->employee_name;
        $expense_details->payment_methods_name = $this->mdl_payment_methods->getPaymentMethodName($expense_details->payment_type_id);
    

        $this->layout->set(array(
            'expense_details' => $expense_details,
        ));
        
        $this->layout->buffer('content', 'mech_expense/view');
        $this->layout->render();
    }
    
    public function generate_pdf($expense_id, $stream = true, $expense_template = null)
    {
        $this->load->helper('pdf');
        generate_user_expense_pdf($expense_id, $stream, $expense_template, null);
    }

}