<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Class Mdl_employees.
 */
class Mdl_Mech_Employee_Experience extends Response_Model
{
    public $table = 'mech_employee_experience';
    public $primary_key = 'mech_employee_experience.employee_experience_id';
    public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mech_employee_experience.*,mech_employee_role.role_name,cl.name as country_name,msl.state_name,cil.city_name', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_employee_experience.employee_experience_id');
    }

    public function default_join()
    {
        $this->db->join('mech_employee_role', 'mech_employee_role.role_id = mech_employee_experience.previous_employee_role', 'left');
        // $this->db->join('mech_employee_experience', 'employee.employee_id = mech_employee_experience.employee_id', 'LEFT');
        $this->db->join('country_lookup cl', 'cl.id = mech_employee_experience.customer_country', 'left');
        $this->db->join('mech_state_list msl', 'msl.state_id = mech_employee_experience.customer_state', 'left');
        $this->db->join('city_lookup cil', 'cil.city_id = mech_employee_experience.customer_city', 'left');
    }

    public function default_where()
    {
        $this->db->where('mech_employee_experience.status', '1');
    }

    public function validation_rules()
    {
        return array(
            'employee_id' => array(
                'field' => 'employee_id',
                'rules' => 'required',
            ),
            'previous_employee_role' => array(
                'field' => 'previous_employee_role',
                'label' => trans('previous_employee_role'),
                'rules' => 'required',
            ),
            'company_name' => array(
                'field' => 'company_name',
                'label' => trans('company_name'),
                'rules' => 'required',
            ),
            'from' => array(
                'field' => 'from',
                'label' => trans('from'),
                'rules' => 'required',
            ),
            'to' => array(
                'field' => 'to',
                'label' => trans('to'),
                'rules' => 'required',
            ),
            'customer_street_1' => array(
                'field' => 'customer_street_1',
                'label' => trans('customer_street_1'),
            ),
            'customer_street_2' => array(
                'field' => 'customer_street_2',
                'label' => trans('customer_street_2'),
            ),
            'customer_country' => array(
                'field' => 'customer_country',
                'label' => trans('customer_country'),
            ),
            'customer_state' => array(
                'field' => 'customer_state',
                'label' => trans('customer_state'),
            ),
            'customer_city' => array(
                'field' => 'customer_city',
                'label' => trans('customer_city'),
            ),
            'customer_street_1' => array(
                'field' => 'customer_street_1',
                'label' => trans('customer_street_1'),
            ),
            'zip_code' => array(
                'field' => 'zip_code',
                'label' => trans('zip_code'),
                'rules' => 'required'
            ),
            'area' => array(
                'field' => 'area',
                'label' => trans('area'),
                'rules' => 'required'
            ),
            'description' => array(
                'field' => 'description',
                'label' => trans('description'),
            ),
            'status' => array(
                'field' => 'status',
                'label' => trans('status'),
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
        // unset($db_array['from']);
        // unset($db_array['to']);
        // print_r($_REQUEST);
        $db_array['from'] = $this->input->post('from')?date_to_mysql($this->input->post('from')):NULL;
        $db_array['to'] = $this->input->post('to')?date_to_mysql($this->input->post('to')):NULL;
        $db_array['created_by'] = $this->session->userdata('user_id');
        $db_array['modified_by'] = $this->session->userdata('user_id');
        /*
        if (!isset($db_array['employee_status'])) {
            $db_array['employee_status'] = 'A';
        }
        */
        return $db_array;
    }

    public function save($id = null, $db_array = null)
    {

        // print_r($db_array);
        $db_array = ($db_array) ? $db_array : $this->db_array();
        $id = parent::save($id, $db_array);
        return $id;
    }

    public function getEmployeeExperience($employee_id){


        $employeeExperience = $this->db->select('mech_employee_experience.*,mech_employee_role.role_name')->from('mech_employee_experience')->join('mech_employee_role', 'mech_employee_role.role_id = mech_employee_experience.previous_employee_role', 'left')->where('mech_employee_experience.status', '1')->where('mech_employee_experience.employee_id', $employee_id)->where('mech_employee_experience.customer_country')->where('mech_employee_experience.customer_state')->where('mech_employee_experience.customer_city')->where('mech_employee_experience.area')->where('mech_employee_experience.zip_code')->get()->result();
        
        if (count($employeeExperience) > 0) {
           
            $employee_experience_list = $employeeExperience;
        } else {
            $employee_experience_list = array();
        }
        return $employee_experience_list;

    }

}
