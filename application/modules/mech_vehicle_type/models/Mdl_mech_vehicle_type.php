<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_mech_vehicle_type extends Response_Model
{
    public $table = 'mech_vehicle_type';
    public $primary_key = 'mech_vehicle_type.mvt_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    
    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mech_vehicle_type.mvt_id, mech_vehicle_type.workshop_id,
        mech_vehicle_type.vehicle_type_name, mech_vehicle_type.vehicle_type_value, mech_vehicle_type.type_checked,
        mech_vehicle_type.default_cost, mech_vehicle_type.status', false);
    }
    
	public function default_where(){
        $this->db->where_in('mech_vehicle_type.workshop_id' , array(1,$this->session->userdata('work_shop_id')));
        $this->db->where('mech_vehicle_type.status = "A"');
    }

    public function get_latest()
    {
        $this->db->order_by('mech_work_order_dtls.work_order_id', 'DESC');
        return $this;
    }

    public function validation_rules()
    {
        return array(
            'vehicle_type_name' => array(
                'field' => 'vehicle_type_name',
                'label' => trans('lable78'),
                'rules' => 'required'
            ),
            'vehicle_type_value' =>  array(
                'field' => 'vehicle_type_value',
                'label' => trans('lable877'),
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
		$db_array['workshop_id'] = $this->session->userdata('work_shop_id');
    	$db_array['created_by'] = $this->session->userdata('user_id');
    	$db_array['modified_by'] = $this->session->userdata('user_id');
        return $db_array;
    }

	public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();
        $id = parent::save($id, $db_array);
        return $id;
    }
		
}