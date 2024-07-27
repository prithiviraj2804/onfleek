<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Service_Bmv_Type_Price_Dtls extends Response_Model
{
    public $table = 'service_bmv_type_price_dtls';
    public $primary_key = 'service_bmv_type_price_dtls.pct_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS 
        service_bmv_type_price_dtls.pct_id,
        service_bmv_type_price_dtls.workshop_id,
        service_bmv_type_price_dtls.w_branch_id,
        service_bmv_type_price_dtls.msim_id,
        service_bmv_type_price_dtls.brand_id,
        service_bmv_type_price_dtls.model_id,
        service_bmv_type_price_dtls.variant_id,
        service_bmv_type_price_dtls.fuel_type,
        service_bmv_type_price_dtls.estimated_hour,
        service_bmv_type_price_dtls.estimated_cost,
        service_bmv_type_price_dtls.status,
        cb.brand_name,cm.model_name,cv.variant_name', false);
    }


    public function default_join()
    {
        $this->db->join('mech_car_brand_details cb', 'cb.brand_id=service_bmv_type_price_dtls.brand_id', 'left');
        $this->db->join('mech_car_brand_models_details cm', 'cm.model_id=service_bmv_type_price_dtls.model_id', 'left');
		$this->db->join('mech_brand_model_variants cv', 'cv.brand_model_variant_id=service_bmv_type_price_dtls.variant_id', 'left');
    }

	public function default_where()
    {
        $this->db->where('service_bmv_type_price_dtls.workshop_id', $this->session->userdata('work_shop_id'));
        $this->db->where('service_bmv_type_price_dtls.status', 'A');
    }

    public function validation_rules()
    {
        return array(
        	'msim_id' => array(
                'field' => 'msim_id',
                // 'label' => trans('msim_id'),
                'rules' => 'required'
            ),
            'brand_id' => array(
                'field' => 'brand_id',
                'label' => trans('lable229'),
                'rules' => 'required'
            ),
            'model_id' => array(
                'field' => 'model_id',
                'label' => trans('lable231'),
                'rules' => 'required'
            ),
            'variant_id' => array(
                'field' => 'variant_id',
                'label' => trans('lable263')
            ),
            'fuel_type' => array(
                'field' => 'fuel_type',
                'label' => trans('lable132')
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