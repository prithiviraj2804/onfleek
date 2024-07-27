<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Email_bulk extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
       $this->load->model('mdl_email_bulk');
    }

    public function index($page = 0)
    {
        $limit = 15;
        $query = $this->mdl_email_bulk->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();
        $this->mdl_email_bulk->limit($limit);
        $bulkemail = $this->mdl_email_bulk->get()->result();

        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A'")->result();
        }else{
            $branch_list = array();
        }        

		$this->layout->set(
            array(
                'bulkemail' => $bulkemail,
                'branch_list' => $branch_list,
                'createLinks' => $createLinks,
                'bulkemaillist' => $this->mdl_email_bulk->get()->result(),
            )
        );

        $this->layout->buffer('content', 'email_bulk/index');
        $this->layout->render();
    }

    public function form($id = null)
    {
        if($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_email_bulk->prep_form($id)) {
                show_404();
            }
			$breadcrumb = "lable1146";
        }else{
        	$breadcrumb = "lable1146";
        }
 
        $customer_name_list = $this->db->query('SELECT * FROM mech_clients where client_active = "A" and client_email_id != " "  and workshop_id = '.$this->session->userdata('work_shop_id').' ORDER BY client_name ASC')->result();
 
		$this -> layout -> set(array(
            'breadcrumb' => $breadcrumb,
            'customer_name_list' => $customer_name_list,
        ));
            
        $this->layout->buffer('content', 'email_bulk/form');
        $this->layout->render();
    }
}

