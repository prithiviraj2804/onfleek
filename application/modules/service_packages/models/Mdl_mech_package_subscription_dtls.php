<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Mech_Package_Subscription_Dtls extends Response_Model
{

    public $table = 'mech_package_subscription_dtls';
    public $primary_key = 'mech_package_subscription_dtls.ps_id ';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mech_package_subscription_dtls.ps_id ,mech_package_subscription_dtls.workshop_id,
        mech_package_subscription_dtls.s_pack_id,mech_package_subscription_dtls.body_type,mech_package_subscription_dtls.schedule_type,
        mech_package_subscription_dtls.price,mech_vehicle_type.vehicle_type_name,mech_vehicle_type.vehicle_type_value', false);
    }

    public function default_join()
    {
        $this->db->join('mech_vehicle_type','mech_vehicle_type.mvt_id  = mech_package_subscription_dtls.body_type','left');
    }

    public function default_where()
    {
        $this->db->where('mech_package_subscription_dtls.status', "A");
    }

    public function validation_rules()
    {
        return array(
            's_pack_id' => array(
                'field' => 's_pack_id',
			),
            'body_type' => array(
                'field' => 'body_type',
            ),
            'schedule_type' => array(
                'field' => 'schedule_type',
            ),
            'price' => array(
                'field' => 'price',
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