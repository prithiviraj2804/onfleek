<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Mechanic_Service_Item_Price_List extends Response_Model
{
    public $table = 'mechanic_service_item_mapping';
    public $primary_key = 'mechanic_service_item_mapping.msim_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mechanic_service_item_mapping.workshop_id,mechanic_service_item_mapping.msim_id,mechanic_service_item_mapping.brand_id,mechanic_service_item_mapping.model_id,
        mechanic_service_item_mapping.variant_id,mechanic_service_item_mapping.model_type,mechanic_service_item_mapping.kilo_from,
        mechanic_service_item_mapping.kilo_to,mechanic_service_item_mapping.mon_from,mechanic_service_item_mapping.mon_to,
        mechanic_service_item_mapping.fuel_type,mechanic_service_item_mapping.apply_for_all_bmv,mechanic_service_item_mapping.service_category_id,
        mechanic_service_item_mapping.service_item_id,mechanic_service_item_mapping.price_type,mechanic_service_item_mapping.mech_price,
        mechanic_service_item_mapping.user_price,mechanic_service_item_mapping.product_id,
        mechanic_service_item_mapping.complete_service_description,mechanic_service_item_mapping.service_product_total_price,
        uad.category_name,item.service_item_name,brand.brand_name,model.model_name,cv.variant_name', false);
    }
	
	public function default_join()
	{
	    $this->db->join('mechanic_service_category_list uad', 'uad.service_cat_id = mechanic_service_item_mapping.service_category_id', 'left');
	    $this->db->join('mechanic_service_category_items item', 'item.sc_item_id = mechanic_service_item_mapping.service_item_id', 'left');
		$this->db->join('mech_car_brand_details brand', 'brand.brand_id=mechanic_service_item_mapping.brand_id', 'left');
		$this->db->join('mech_car_brand_models_details model', 'model.model_id=mechanic_service_item_mapping.model_id', 'left');
		$this->db->join('mech_brand_model_variants cv', 'cv.brand_model_variant_id=mechanic_service_item_mapping.variant_id', 'left');
	}
	
    public function default_order_by()
    {
        $this->db->order_by('mechanic_service_item_mapping.msim_id', "desc");
    }

	public function default_where()
    {

        $this->db->where('mechanic_service_item_mapping.workshop_id' , $this->session->userdata('work_shop_id'));
        $this->db->where('mechanic_service_item_mapping.status', 'A');
    }

    public function validation_rules()
    {
        return array(
        	'brand_id' => array(
                'field' => 'brand_id',
                'label' => trans('brand_id'),
                'rules' => 'required'
            ),
            'model_id' => array(
                'field' => 'model_id',
                'label' => trans('model_id'),
            ),
            'variant_id' => array(
                'field' => 'variant_id',
                'label' => trans('variant_id'),
            ),
            'model_type' => array(
                'field' => 'model_type',
                'label' => trans('model_type'),
                'rules' => ''
            ),
            'kilo_from' => array(
                'field' => 'kilo_from',
                'label' => trans('kilo_from'),
                'rules' => '',
            ),
            'kilo_to' => array(
                'field' => 'kilo_to',
                'label' => trans('kilo_to'),
                'rules' => '',
            ),
            'mon_from' => array(
                'field' => 'mon_from',
                'label' => trans('mon_from'),
                'rules' => '',
            ),
            'mon_to' => array(
                'field' => 'mon_to',
                'label' => trans('mon_to'),
                'rules' => '',
            ),
            'fuel_type' => array(
                'field' => 'fuel_type',
                'label' => trans('fuel_type'),
            ),
            'apply_for_all_bmv' => array(
                'field' => 'apply_for_all_bmv',
                'label' => trans('apply_for_all_bmv'),
                'rules' => '',
            ),
            'service_category_id' => array(
                'field' => 'service_category_id',
                'label' => trans('service_category_id'),
                'rules' => 'required'
            ),
             'service_item_id' => array(
                'field' => 'service_item_id',
                'label' => trans('service_item_id'),
                'rules' => 'required'
            ),
             'price_type' => array(
                'field' => 'price_type',
                'label' => trans('price_type'),
                'rules' => 'required'
            ),
            'mech_price' => array(
                'field' => 'mech_price',
                'label' => trans('mech_price'),
            ),
            'user_price' => array(
                'field' => 'user_price',
                'label' => trans('user_price'),
            ),
            'product_id' => array(
                'field' => 'product_id',
                'label' => trans('product_id'),
            ),
            'complete_service_description' => array(
                'field' => 'complete_service_description',
                'label' => trans('Description'),
            ),
            'service_product_total_price' => array(
                'field' => 'service_product_total_price',
                'label' => trans('Total Price'),
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
    	if($db_array['product_id'] != ''){
    	    $db_array['product_id'] = implode (",",$db_array['product_id']);
    	}else{
    	    $db_array['product_id'] = '';
    	}
		$db_array['complete_service_description'] = strip_tags($db_array['complete_service_description']);
		
        return $db_array;
    }

	public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();
        // Save the car
        $id = parent::save($id, $db_array);
        return $id;
    }
}
