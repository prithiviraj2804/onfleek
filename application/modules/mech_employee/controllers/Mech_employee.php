<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mech_employee extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_mech_employee');
        $this->load->model('mdl_mech_employee_experience');
        $this->load->model('mdl_mech_custom_table');
        $this->load->model('employee_role/mdl_employee_role');
        $this->load->model('mech_bank_list/mdl_mech_bank_list');
        $this->load->model('settings/mdl_settings');
    }

    public function index($page = 0)
    {
        $limit = 15;
        $query = $this->mdl_mech_employee->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();
        $this->mdl_mech_employee->limit($limit);
        $employees = $this->mdl_mech_employee->get()->result();
        
        $employees_roles = $this->mdl_employee_role->where('mech_employee_role.status', 'A')->get()->result();

        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A'")->result();
        }else{
            $branch_list = array();
        }

        $this->layout->set(
            array(
                'employees' => $employees,
                'branch_list' => $branch_list,
                'shift_list'=> ($this->db->query('SELECT shift_id,shift_name FROM mech_shift')->result()),
                'name' => $this->input->post('employee_name')?$this->input->post('employee_name'):'',
                'branch_id' => $this->input->post('branch_id')?$this->input->post('branch_id'):'',
                'from_date' => $this->input->post('from_date')?$this->input->post('from_date'):'',
                'to_date' => $this->input->post('to_date')?$this->input->post('to_date'):'',
                'role_id' => $this->input->post('employee_role')?$this->input->post('employee_role'):'',
                'shift' => $this->input->post('shift')?$this->input->post('shift'):'',
                'employees_roles' => $employees_roles,
                'createLinks' => $createLinks
            )
        );

        $this->layout->buffer('content', 'mech_employee/index');
        $this->layout->render();
    }   

    public function form($id = null, $tab = null)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('mech_employee');
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_mech_employee->prep_form($id)) {
                show_404();
            }
            $this->mdl_mech_employee->set_form_value('is_update', true);
            $employee_skill_list = array();
            $this->db->select('skill_ids');
            $this->db->from('mech_employee');
            $this->db->where('employee_id', $id);
            $skill_ids = $this->db->get()->row()->skill_ids;

            if ($skill_ids) {
                $skill_id = explode(',', $skill_ids);
                if (count($skill_id) > 0) {
                    for ($i = 0; $i < count($skill_id); ++$i) {
                        $skill = $this->db->query('SELECT * FROM mech_automotive_skills WHERE skill_id = '.$skill_id[$i].'')->row();
                        array_push($employee_skill_list, $skill);
                    }
                }
            }

            $this->mdl_mech_employee_experience->where('mech_employee_experience.employee_id',$id);
            $employeeExperience = $this->mdl_mech_employee_experience->get()->result();
            if (count($employeeExperience) > 0) {
                $employee_experience_list = $employeeExperience;
            } else {
                $employee_experience_list = array();
            }

            if ($this->mdl_mech_employee->form_value('employee_country', true)) {
                $state_list = $this->mdl_settings->getStateList($this->mdl_mech_employee->form_value('employee_country', true));
            } else {
                $state_list = $this->db->query('SELECT * FROM mech_state_list')->result();
            }

            if ($this->mdl_mech_employee->form_value('employee_state', true)) {
                $city_list = $this->mdl_settings->getCityList($this->mdl_mech_employee->form_value('employee_state', true));
            } else {
                $city_list = $this->db->query('SELECT * FROM city_lookup')->result();
            }

            $employee_document_list = $this->db->select('*')->from('ip_uploads')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('w_branch_id', $this->session->userdata('branch_id'))->where('entity_id', $id)->where('entity_type', 'E')->get()->result();
            $employee_custom_list = $this->mdl_mech_custom_table->getEntityCustomList($id, 'E');
            $breadcrumb = "lable143";

            $this->db->select('shift');
            $this->db->from('mech_employee');
            $this->db->where('employee_id', $id);
            $employee_shift = $this->db->get()->row()->shift;
            $employee_user_id = $this->mdl_mech_employee->get_employee_user_id($id);
            if($employee_user_id){
                $this->db->select('permission_id,user_id,workshop_id,module_id,status');
                $this->db->from('mech_module_permission');
                $this->db->where('user_id' , $employee_user_id );
                $this->db->where('workshop_id' , $this->session->userdata('work_shop_id'));
                $permission_list = $this->db->get()->result();
            }else{
                $permission_list = array();
            }
           

        } else {
            $employee_shift = NULL;
            $breadcrumb = "lable142";
            $employee_skill_list = array();
            $employee_experience_list = array();
            $state_list = $this->db->query('SELECT * FROM mech_state_list')->result();
            $city_list = $this->db->query('SELECT * FROM city_lookup')->result();
            $employee_document_list = array();
            $employee_custom_list = array();
            $permission_list = array();
        }

        $employees_role = $this->mdl_employee_role->where('status', 'A')->get()->result();
        
        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A'")->result();
        }else{
            $branch_list = array();
        }

        if($this->session->userdata('plan_type') == 1){
            $this->db->select('mech_category_permission_dtls.*, mech_modules.module_label');
            $this->db->from('mech_category_permission_dtls');
            $this->db->join('mech_modules','mech_modules.module_id = mech_category_permission_dtls.module_id','left');
            $this->db->where('mech_category_permission_dtls.status','A');
            $this->db->where('mech_category_permission_dtls.category_type','1');
            $this->db->order_by('mech_category_permission_dtls.mcp_id','ASC');
            $mech_modules = $this->db->get()->result();
        }else if($this->session->userdata('plan_type') == 2){
            $this->db->select('mech_category_permission_dtls.*, mech_modules.module_label');
            $this->db->from('mech_category_permission_dtls');
            $this->db->join('mech_modules','mech_modules.module_id = mech_category_permission_dtls.module_id','left');
            $this->db->where('mech_category_permission_dtls.status','A');
            $this->db->where('mech_category_permission_dtls.category_type','2');
            $this->db->order_by('mech_category_permission_dtls.mcp_id','ASC');
            $mech_modules = $this->db->get()->result();
        }else if($this->session->userdata('plan_type') == 3){
            $this->db->select('mech_category_permission_dtls.*, mech_modules.module_label');
            $this->db->from('mech_category_permission_dtls');
            $this->db->join('mech_modules','mech_modules.module_id = mech_category_permission_dtls.module_id','left');
            $this->db->where('mech_category_permission_dtls.status','A');
            $this->db->where('mech_category_permission_dtls.category_type','3');
            $this->db->order_by('mech_category_permission_dtls.mcp_id','ASC');
            $mech_modules = $this->db->get()->result();
        }else{
            $mech_modules = array();
        }

        $invoice_group_number = $this->db->query("SELECT * FROM ip_invoice_groups where module_type = 'employee' AND workshop_id = '".$this->session->userdata('work_shop_id')."' ORDER BY invoice_group_id ASC LIMIT 1")->row();
        
        $this->layout->set('invoice_group_number', $invoice_group_number);

        $this->layout->set('employee_shift', $employee_shift);
        $this->layout->set('is_shift', $this->db->query("SELECT shift FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." ")->row()->shift);
        $this->layout->set('branch_list', $branch_list);
        $this->layout->set('shift_list', $this->db->query('SELECT * FROM mech_shift')->result());
        $this->layout->set('country_list', $this->db->query('SELECT * FROM country_lookup')->result());
        $this->layout->set('state_list', $state_list);
        $this->layout->set('city_list', $city_list);
        $this->layout->set('active_tab', $tab);
        $this->layout->set('breadcrumb', $breadcrumb);
        $this->layout->set('employees_role', $employees_role);
        $this->layout->set('employee_skill_list', $employee_skill_list);
        $this->layout->set('workshop_bank_list', $this->mdl_mech_bank_list->where('mech_workshop_bank_list.workshop_id', $this->session->userdata('work_shop_id'))->where('mech_workshop_bank_list.entity_id', $id)->where('mech_workshop_bank_list.module_type', 'E')->get()->result());
        $this->layout->set('employee_experience_list', $employee_experience_list);
        $this->layout->set('employee_document_list', $employee_document_list);
        $this->layout->set('employee_custom_list', $employee_custom_list);
        $this->layout->set('mech_modules' , $mech_modules);
        $this->layout->set('permission_list' , $permission_list);
        $this->layout->buffer('content', 'mech_employee/form');
        $this->layout->render();
    }

    public function delete()
    {
        $id = $this->input->post('id');
		$this->db->where('employee_id', $id);
        $this->db->update('mech_employee', array('employee_status'=>2));
        $this->db->where('emp_id', $id);
        $this->db->update('ip_users', array('user_active'=>2));
		$response = array(
            'success' => 1
        );
        echo json_encode($response);
    }

    public function deleteExperience()
    {
        $id = $this->input->post('id');
		$this->db->where('employee_experience_id', $id);
		$this->db->update('mech_employee_experience', array('status'=>2));
		$response = array(
            'success' => 1
        );
        echo json_encode($response);
    }

    public function checkEmployeeUserOrNot($id = null, $get_csrf_hash = null) {
         $id = $this->input->post('employee_id');
        $check = $this->db->select('emp_id')->from('ip_users')->where('emp_id',$id)->where_in('workshop_id',array(1,$this->session->userdata('work_shop_id')))->get()->result();   
        if(count($check) > 0){
            $response = array(
                'success' => 1
            );
        }else{
            $response = array(
                'success' => 0
            );
        }
        echo json_encode($response);
    }
    
    public function getDeleteUploadData(){
        
        $upload_id = $this->input->post('upload_id');
        $upload_type = $this->input->post('upload_type');
        $client_id = $this->input->post('employee_id');
        
        if($upload_type == 'D'){
            $this->db->where('upload_id', $upload_id);
            $this->db->where('client_id', $client_id);
            $this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
            $this->db->where('w_branch_id', $this->session->userdata('branch_id'));
            $this->db->delete('ip_uploads');
        }
        
        $result = $this->db->select('*')->from('ip_uploads')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('w_branch_id', $this->session->userdata('branch_id'))->where('entity_id', $client_id)->where('entity_type', 'E')->get()->result();
        
        $response = array(
            'success' => 1,
            'doclist' => $result
        );
        
        echo json_encode($response);
    }

    public function generate_pdf($employee_id, $stream = true, $employee_template = null)
    {
        $this->load->helper('pdf');
        generate_employee_pdf($employee_id, $stream, $employee_template, null);
    }
}