<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Service_Package_Price_Dtls extends Response_Model
{

    public $table = 'mech_service_package_price_dtls';
    public $primary_key = 'mech_service_package_price_dtls.sp_price_id ';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mech_service_package_price_dtls.sp_price_id ,mech_service_package_price_dtls.workshop_id,
        mech_service_package_price_dtls.s_pack_id,mech_service_package_price_dtls.mvt_id,mech_service_package_price_dtls.service_cost,
        mech_service_package_price_dtls.estimated_hour,mech_vehicle_type.vehicle_type_name,mech_vehicle_type.vehicle_type_value', false);
    }

    public function default_join()
    {
        $this->db->join('mech_vehicle_type','mech_vehicle_type.mvt_id  = mech_service_package_price_dtls.mvt_id','left');
    }

    public function default_where()
    {
        $this->db->where('mech_service_package_price_dtls.status', "A");
    }

    public function validation_rules()
    {
        return array(
            's_pack_id' => array(
                'field' => 's_pack_id',
			),
            'mvt_id' => array(
                'field' => 'mvt_id',
            ),
            'service_cost' => array(
                'field' => 'service_cost',
            ),
            'estimated_hour' => array(
                'field' => 'estimated_hour',
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
        $db_array['created_on'] = date('Y-m-d H:m:s');
        return $db_array;
    }

	public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();		
        $id = parent::save($id, $db_array);
        return $id;
    }

}