<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Service_Body_Type_Price_Dtls extends Response_Model
{
    public $table = 'service_body_type_price_dtls';
    public $primary_key = 'service_body_type_price_dtls.sct_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS 
        service_body_type_price_dtls.sct_id,
        service_body_type_price_dtls.workshop_id,
        service_body_type_price_dtls.w_branch_id,
        service_body_type_price_dtls.msim_id,
        service_body_type_price_dtls.mvt_id,
        service_body_type_price_dtls.vehicle_type_value,
        service_body_type_price_dtls.default_cost,
        service_body_type_price_dtls.estimated_hour,
        service_body_type_price_dtls.estimated_cost,
        service_body_type_price_dtls.status,
        mech_vehicle_type.vehicle_type_name', false);
    }

    public function default_join()
	{
	    $this->db->join('mech_vehicle_type', 'mech_vehicle_type.mvt_id = service_body_type_price_dtls.mvt_id', 'left');
    }
    
	public function default_where()
    {
        $this->db->where('service_body_type_price_dtls.workshop_id', $this->session->userdata('work_shop_id'));
        $this->db->where('service_body_type_price_dtls.status', 'A');
    }

    public function validation_rules()
    {
        return array(
        	'msim_id' => array(
                'field' => 'msim_id',
                // 'label' => trans('msim_id'),
                'rules' => 'required'
            ),
            'mvt_id' => array(
                'field' => 'mvt_id',
                'label' => trans('mvt_id'),
                'rules' => 'required'
            ),
            'vehicle_type_value' => array(
                'field' => 'vehicle_type_value',
                // 'label' => trans('vehicle_type_value'),
                // 'rules' => 'required'
            ),
            'default_cost' => array(
                'field' => 'default_cost',
                'label' => trans('default_cost')
            ),
            'estimated_hour' => array(
                'field' => 'estimated_hour',
                'label' => trans('lable878'),
                'rules' => 'required'
            ),
            'estimated_cost' => array(
                'field' => 'estimated_cost',
                'label' => trans('lable879'),
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
    	$db_array['w_branch_id'] = $this->session->userdata('branch_id');
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