<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Mdl_Employee_Role
 */
class Mdl_Employee_Role extends Response_Model
{
    public $table = 'mech_employee_role';
    public $primary_key = 'mech_employee_role.role_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mech_employee_role.role_id,mech_employee_role.role_name', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_employee_role.role_name');
    }
	public function default_where()
    {
        $this->db->where('mech_employee_role.workshop_id', $this->session->userdata('work_shop_id'));
        if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
			$this->db->where('w_branch_id', $this->session->userdata('branch_id'));
		}else if($this->session->userdata('user_type') == 6){
			$this->db->where_in('w_branch_id', $this->session->userdata('user_branch_id'));
		} 
		$this->db->where('mech_employee_role.status', 'A');
	}

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'role_name' => array(
                'field' => 'role_name',
                'label' => trans('lable205'),
                'rules' => 'required'
            ),
            '_mm_csrf' => array(
                'field' => '_mm_csrf'
            )
        );
    }
	public function db_array()
    {
        $db_array = parent::db_array();
		unset($db_array['_mm_csrf']);
        // $db_array['user_id'] = $this->session->userdata('user_id');
    	$db_array['created_by'] = $this->session->userdata('user_id');
		$db_array['modified_by'] = $this->session->userdata('user_id');
		$db_array['workshop_id'] = $this->session->userdata('work_shop_id');
    	$db_array['w_branch_id'] = $this->session->userdata('branch_id');
		$db_array['status'] = 'A' ;
        return $db_array;
    }
	public function get_employee_role_name($id)
	{
		$this->db->select("role_name");	
		$this->db->from('mech_employee_role');
		$this->db->where('role_id', $id);
		return $this->db->get()->row()->role_name;
	}

}
