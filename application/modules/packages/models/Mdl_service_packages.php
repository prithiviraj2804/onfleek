<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Service_Packages extends Response_Model
{

    public $table = 'mech_service_packages';
    public $primary_key = 'mech_service_packages.service_package_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mech_service_packages.service_package_id,mech_service_packages.workshop_id,mech_service_packages.w_branch_id,mech_service_packages.service_package_name,
        mech_service_packages.model_type,mech_service_packages.offer_start_date,mech_service_packages.offer_end_date,mech_service_packages.brand_id,mech_service_packages.model_id,
        mech_service_packages.variant_id,mech_service_packages.apply_for_all_bmv,mech_service_packages.service_category_id,mech_service_packages.service_item_id,
        mech_service_packages.mech_price,mech_service_packages.user_price,mech_service_packages.product_id,mech_service_packages.service_package_description,
        mech_service_packages.service_product_total_price,mech_service_packages.status,mech_vehicle_type.vehicle_type_name,mechanic_service_category_list.category_name,mech_service_item_dtls.service_item_name,
        mech_car_brand_details.brand_name,mech_car_brand_models_details.model_name,mech_brand_model_variants.variant_name', false);
    }

    public function default_join()
    {
        $this->db->join('mech_vehicle_type','mech_vehicle_type.mvt_id = mech_service_packages.model_type', 'left');
        $this->db->join('mechanic_service_category_list','mechanic_service_category_list.service_cat_id = mech_service_packages.service_category_id', 'left');
        $this->db->join('mech_service_item_dtls','mech_service_item_dtls.service_category_id = mech_service_packages.service_item_id', 'left');
        $this->db->join('mech_car_brand_details', 'mech_car_brand_details.brand_id = mech_service_packages.brand_id', 'left');
		$this->db->join('mech_car_brand_models_details', 'mech_car_brand_models_details.model_id = mech_service_packages.model_id', 'left');
        $this->db->join('mech_brand_model_variants', 'mech_brand_model_variants.brand_model_variant_id = mech_service_packages.variant_id', 'left');


    }

    public function default_where()
    {
        $this->db->where('mech_service_packages.workshop_id', $this->session->userdata('work_shop_id'));
		if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $this->db->where('mech_service_packages.w_branch_id', $this->session->userdata('branch_id'));
            $this->db->where('mech_service_packages.created_by', $this->session->userdata('user_id'));
        }else if($this->session->userdata('user_type') == 6){
			$this->db->where_in('mech_service_packages.w_branch_id', $this->session->userdata('user_branch_id'));
        }
        $this->db->where('mech_service_packages.status = "A"');
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_service_packages.service_package_id', "desc");
    }

    public function validation_rules()
    {
        return array(
            'service_package_name' => array(
                'field' => 'service_package_name',
                'label' => trans('lable545'),
                'rules' => 'required'
            ),
            'model_type' => array(
                'field' => 'model_type',
                'label' => trans('lable78'),
                'rules' => 'required'
            ),
            'offer_start_date' => array(
                'field' => 'offer_start_date',
                'label' => trans('lable543'),
                'rules' => 'required'
            ),
            'offer_end_date' => array(
                'field' => 'offer_end_date',
                'label' => trans('lable542'),
                'rules' => 'required'
            ),
            'brand_id' => array(
                'field' => 'brand_id',
                'label' => trans('lable229'),
            ),
            'model_id' => array(
                'field' => 'model_id',
                'label' => trans('lable231'),
            ),
            'variant_id' => array(
                'field' => 'variant_id',
                'label' => trans('lable263')
            ),
            'apply_for_all_bmv' => array(
                'field' => 'apply_for_all_bmv',
                'label' => trans('lable228'),
            ),
            'service_category_id' => array(
                'field' => 'service_category_id',
                'label' => trans('lable239'),
                'rules' => 'required'
            ),
            'service_item_id' => array(
                'field' => 'service_item_id',
                'label' => trans('lable249'),
                'rules' => 'required'
            ),
            'mech_price' => array(
                'field' => 'mech_price',
                // 'label' => trans('mech_price'),
                // 'rules' => 'required'
            ),
            'user_price' => array(
                'field' => 'user_price',
                // 'label' => trans('user_price'),
                'rules' => 'required'
            ),
            // 'product_id' => array(
            //     'field' => 'product_id',
            //     'label' => trans('product_id'),
            // ),
            'service_package_description' => array(
                'field' => 'service_package_description',
                'label' => trans('lable177'),
            ),
            'service_product_total_price' => array(
                'field' => 'service_product_total_price',
                'label' => trans('lable268'),
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
        unset($db_array['offer_start_date']);
        unset($db_array['offer_end_date']);
        unset($db_array['product_id']);
        $db_array['product_id'] = implode(',', $this->input->post('product_id'));
        $db_array['offer_start_date'] = date_to_mysql($this->input->post('offer_start_date'));
    	$db_array['offer_end_date'] = date_to_mysql($this->input->post('offer_end_date'));
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