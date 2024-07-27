<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mdl_Mech_Employee extends Response_Model
{
    public $table = 'mech_employee';
    public $primary_key = 'mech_employee.employee_id';
    public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mech_employee.employee_id,mech_employee.url_key,mech_employee.employee_name,
        mech_employee.employee_number,mech_employee.total_rewards_point,mech_employee.branch_id,
        mech_employee.user_branch_id,mech_employee.shift,mech_employee.employee_role,
        mech_employee.skill_ids,mech_employee.employee_experience,mech_employee.basic_salary,
        mech_employee.date_of_birth,mech_employee.date_of_joining,mech_employee.mobile_no,
        mech_employee.employee_street_1,mech_employee.employee_street_2,mech_employee.employee_city,
        mech_employee.employee_state,mech_employee.employee_country,mech_employee.employee_pincode,
        mech_employee.email_id,mech_employee.blood_group,mech_employee.physical_challange,mech_employee.employee_no,
        mech_employee.employee_account_checkbox,
        role.role_id,role.role_name,
        ms.shift_name,
        branc.display_board_name,
        cou.name as country_name, 
        st.state_name as st_name, 
        ar.city_name as cty_name', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_employee.employee_name');
    }

    public function default_join()
    {
        $this->db->join('mech_employee_role role', 'role.role_id = mech_employee.employee_role', 'LEFT');
        $this->db->join('city_lookup ar', 'ar.city_id=mech_employee.employee_city','LEFT');
        $this->db->join('mech_state_list st', 'st.state_id=mech_employee.employee_state', 'LEFT');
        $this->db->join('country_lookup cou', 'cou.id=mech_employee.employee_country', 'LEFT');
        $this->db->join('mech_shift ms', 'ms.shift_id=mech_employee.shift', 'LEFT');
        $this->db->join('workshop_branch_details branc', 'branc.w_branch_id = mech_employee.branch_id', 'LEFT');
    }

    public function default_where()
    {
        $this->db->where('mech_employee.workshop_id' , $this->session->userdata('work_shop_id'));
		if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $this->db->where('mech_employee.w_branch_id' , $this->session->userdata('branch_id'));
        }else if($this->session->userdata('user_type') == 6){
            $this->db->where_in('mech_employee.w_branch_id' , $this->session->userdata('user_branch_id'));
            //$this->db->where_not_in('mech_employee.employee_id' , $this->session->userdata('emp_id'));
		}
        $this->db->where('mech_employee.employee_status = 1');
    }

    public function validation_rules()
    {
        return array(
            'employee_name' => array(
                'field' => 'employee_name',
                'label' => trans('lable134'),
                'rules' => 'required',
            ),
            'employee_number' => array(
                'field' => 'employee_number',
                'label' => trans('lable148'),
            ),
            'branch_id' => array(
                'field' => 'branch_id',
                'label' => trans('lable51'),
                'rules' => 'required',
            ),
            'user_branch_id' => array(
                'field' => 'user_branch_id',
                'label' => trans('lable51'),
            ),
            'shift' => array(
                'field' => 'shift',
                'label' => trans('lable151'),
                //'rules' => 'required',
            ),
            'employee_role' => array(
                'field' => 'employee_role',
                'label' => trans('lable135'),
                'rules' => 'required',
            ),
            'skill_ids' => array(
                'field' => 'skill_ids',
                // 'label' => trans('skill_ids'),
            ),
            'employee_experience' => array(
                'field' => 'employee_experience',
                'label' => trans('lable156'),
                //'rules' => 'required|is_numeric',
            ),
            'date_of_birth' => array(
                'field' => 'date_of_birth',
                'label' => trans('lable153'),
                //'rules' => 'required',
            ),
            'date_of_joining' => array(
                'field' => 'date_of_joining',
                'label' => trans('lable154'),
                //'rules' => 'required',
            ),
            'basic_salary' => array(
                'field' => 'basic_salary',
                'label' => trans('lable155'),
            ),
            'mobile_no' => array(
                'field' => 'mobile_no',
                'label' => trans('lable137'),
               // 'rules' => 'required|is_numeric',
            ),
            'employee_street_1' => array(
                'field' => 'employee_street_1',
                'label' => trans('lable159'),
                //'rules' => 'required',
            ),
            'employee_street_2' => array(
                'field' => 'employee_street_2',
                'label' => trans('lable160'),
            ),
            'employee_city' => array(
                'field' => 'employee_city',
                'label' => trans('lable88'),
               // 'rules' => 'required',
            ),
            'employee_state' => array(
                'field' => 'employee_state',
                'label' => trans('lable87'),
               // 'rules' => 'required',
            ),
            'employee_country' => array(
                'field' => 'employee_country',
                'label' => trans('lable86'),
               // 'rules' => 'required',
            ),
            'employee_pincode' => array(
                'field' => 'employee_pincode',
                'label' => trans('lable89'),
                //'rules' => 'required|is_numeric',
            ),
            'customer_street_1' => array(
                'field' => 'customer_street_1',
                // 'label' => trans('customer_street_1'),
                //'rules' => 'required',
            ),
            'customer_street_2' => array(
                'field' => 'customer_street_2',
                // 'label' => trans('customer_street_2'),
            ),
            'customer_city' => array(
                'field' => 'customer_city',
                // 'label' => trans('customer_city'),
               // 'rules' => 'required',
            ),
            'customer_state' => array(
                'field' => 'customer_state',
                // 'label' => trans('customer_state'),
               // 'rules' => 'required',
            ),
            'customer_country' => array(
                'field' => 'customer_country',
                // 'label' => trans('customer_country'),
               // 'rules' => 'required',
            ),
            'zip_code' => array(
                'field' => 'zip_code',
                // 'label' => trans('zip_code'),
                //'rules' => 'required|is_numeric',
            ),
            'area' => array(
                'field' => 'area',
                // 'label' => trans('area'),
                //'rules' => 'required|is_numeric',
            ),
             
            'email_id' => array(
                'field' => 'email_id',
                'label' => trans('lable41'),
                //'rules' => 'required|valid_email',
            ),
            'blood_group' => array(
                'field' => 'blood_group',
                'label' => trans('lable157'),
            ),
            'physical_challange' => array(
                'field' => 'physical_challange',
                'label' => trans('lable158'),
               // 'rules' => 'required',
            ),
            'employee_no' => array(
                'field' => 'employee_no',
			),
            'url_key' => array(
                'field' => 'url_key',
                // 'label' => trans('url_key')
            ),
            '_mm_csrf' => array(
                'field' => '_mm_csrf',
            ),
        );
    }

    public function db_array()
    {
        $db_array = parent::db_array();
        unset($db_array['_mm_csrf']);
        $db_array['created_by'] = $this->session->userdata('user_id');
        $db_array['modified_by'] = $this->session->userdata('user_id');
        $db_array['workshop_id'] = $this->session->userdata('work_shop_id');
        $db_array['w_branch_id'] = $this->session->userdata('branch_id');
        /*
        if (!isset($db_array['employee_status'])) {
            $db_array['employee_status'] = 'A';
        }
        */
        return $db_array;
    }
    
    public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();
        $db_array['date_of_birth'] = $this->input->post('date_of_birth')?date_to_mysql($this->input->post('date_of_birth')):NULL;
        $db_array['date_of_joining'] = $this->input->post('date_of_joining')?date_to_mysql($this->input->post('date_of_joining')):NULL;
        $db_array['created_by'] = $this->session->userdata('user_id');
        $db_array['modified_by'] = $this->session->userdata('user_id');
        $db_array['workshop_id'] = $this->session->userdata('work_shop_id');
        $db_array['w_branch_id'] = $this->session->userdata('branch_id');
        $id = parent::save($id, $db_array);
        return $id;
    }   
    public function get_url_key()
    {
        $this->load->helper('string');
        return random_string('alnum', 15);
    }

    public function checkEmployeeEmailId(){
        $this->db->select('mech_employee.email_id');
        $this->db->from('mech_employee');
        $this->db->where('mech_employee.email_id' , $this->input->post('email_id'));
        $this->db->where('mech_employee.workshop_id' , $this->session->userdata('work_shop_id'));
        $this->db->where('mech_employee.employee_status' , 1);
        if($this->input->post('employee_id')){
            $this->db->where_not_in('mech_employee.employee_id' , $this->input->post('employee_id'));
        }
        return $this->db->get()->result();
    }

    public function checkEmployeeMobile(){
        $this->db->select('mech_employee.mobile_no');
        $this->db->from('mech_employee');
        $this->db->where('mech_employee.mobile_no' , $this->input->post('mobile_no'));
        $this->db->where('mech_employee.workshop_id' , $this->session->userdata('work_shop_id'));
        $this->db->where('mech_employee.employee_status' , 1);
        if($this->input->post('employee_id')){
            $this->db->where_not_in('mech_employee.employee_id' , $this->input->post('employee_id'));
        }
        return $this->db->get()->result();
    }

    public function checkemployeephone($mob_no){
        $this->db->select('mech_employee.mobile_no');
        $this->db->from('mech_employee');
        $this->db->where('mech_employee.mobile_no' , $mob_no);
        $this->db->where('mech_employee.workshop_id' , $this->session->userdata('work_shop_id'));
        $this->db->where('mech_employee.employee_status' , 1);
        return $this->db->get()->result();
    }

    public function checkemployeeemail($email){
        $this->db->select('mech_employee.email_id');
        $this->db->from('mech_employee');
        $this->db->where('mech_employee.email_id' , $email);
        $this->db->where('mech_employee.workshop_id' , $this->session->userdata('work_shop_id'));
        $this->db->where('mech_employee.employee_status' , 1);
        return $this->db->get()->result();
    }

    public function get_employee_name($employee_id)
	{
		$this->db->select("employee_name");	
		$this->db->from('mech_employee');
		$this->db->where('employee_id', $employee_id);
		return $this->db->get()->row()->employee_name;
    }

    public function get_employee_user_id($employee_id){
        $this->db->select("user_id");	
		$this->db->from('ip_users');
		$this->db->where('emp_id', $employee_id);
		return $this->db->get()->row()->user_id;
    }

    public function deactivateEmployeeUserAccount($employee_id){
        $this->db->where('emp_id', $employee_id);
        $this->db->update('ip_users' , array('user_active' => 0, 'is_new_user' => '' ));
        return true;
    }

    public function get_employee_role_id($employee_id){
        $this->db->select("user_type");	
		$this->db->from('ip_users');
		$this->db->where('emp_id', $employee_id);
		return $this->db->get()->row()->user_type;
    }

    public function getEmployeeSkills($employeeSkillIds){
        $employee_skill_list = array();
        if ($employeeSkillIds) {
            $skill_id = explode(',', $employeeSkillIds);
            if (count($skill_id) > 0) {
                for ($i = 0; $i < count($skill_id); ++$i) {
                    $skill = $this->db->query('SELECT * FROM mech_automotive_skills WHERE skill_id = '.$skill_id[$i].'')->row();
                    array_push($employee_skill_list, $skill);
                }
            }
        }
        return $employee_skill_list;
    }

}