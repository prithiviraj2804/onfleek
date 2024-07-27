<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mdl_Subproducts extends Response_Model
{
    public $table = 'product_bmv_type_price_dtls';
    public $primary_key = 'product_bmv_type_price_dtls.subpro_id';
    public $date_created_field = 'created_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS product_bmv_type_price_dtls.subpro_id,
        product_bmv_type_price_dtls.workshop_id,
        product_bmv_type_price_dtls.w_branch_id,
        product_bmv_type_price_dtls.product_id,
        product_bmv_type_price_dtls.subproductName,
        product_bmv_type_price_dtls.hsn_code,
        product_bmv_type_price_dtls.brand_id,
        product_bmv_type_price_dtls.model_id,
        product_bmv_type_price_dtls.variant_id,
        product_bmv_type_price_dtls.fuel_type,
        product_bmv_type_price_dtls.reorder_qty,
        product_bmv_type_price_dtls.cost_price,
        product_bmv_type_price_dtls.sale_price,
        cb.brand_name,cm.model_name,cv.variant_name', false);
    }

    public function default_join()
    {
        $this->db->join('mech_car_brand_details cb', 'cb.brand_id=product_bmv_type_price_dtls.brand_id', 'left');
        $this->db->join('mech_car_brand_models_details cm', 'cm.model_id=product_bmv_type_price_dtls.model_id', 'left');
		$this->db->join('mech_brand_model_variants cv', 'cv.brand_model_variant_id=product_bmv_type_price_dtls.variant_id', 'left');
    }

    public function default_where()
    {
        $this->db->where('product_bmv_type_price_dtls.workshop_id', $this->session->userdata('work_shop_id'));
		if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $this->db->where('product_bmv_type_price_dtls.w_branch_id', $this->session->userdata('branch_id'));
        }else if($this->session->userdata('user_type') == 6){
			$this->db->where_in('product_bmv_type_price_dtls.w_branch_id', $this->session->userdata('user_branch_id'));
        }
        $this->db->where('product_bmv_type_price_dtls.status', 'A');
    }

    public function validation_rules()
    {
        return array(
            'product_id' => array(
                'field' => 'product_id',
                'label' => trans('product_id'),
            ),
            'subproductName' => array(
                'field' => 'subproductName',
                'label' => trans('subproductName'),
                'rules' => '',
            ),
            'hsn_code' => array(
                'field' => 'hsn_code',
                'label' => trans('hsn_code'),
                'rules' => '',
            ),
            'brand_id' => array(
                'field' => 'brand_id',
                'label' => trans('brand_id'),
                'rules' => '',
            ),
            'model_id' => array(
                'field' => 'model_id',
                'label' => trans('model_id'),
                'rules' => '',
            ),
            'variant_id' => array(
                'field' => 'variant_id',
                'label' => trans('variant_id'),
                'rules' => 'required|trim',
            ),
            'fuel_type' => array(
                'field' => 'fuel_type',
                'label' => trans('fuel_type'),
                'rules' => '',
            ),
            'reorder_qty' => array(
                'field' => 'reorder_qty',
                'label' => trans('reorder_qty'),
                'rules' => '',
            ),
            'cost_price' => array(
                'field' => 'cost_price',
                'label' => trans('cost_price'),
                'rules' => '',
            ),
            'sale_price' => array(
                'field' => 'sale_price',
                'label' => trans('sale_price'),
                'rules' => '',
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
        return $db_array;
    }

    public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();
        $id = parent::save($id, $db_array);
        return $id;
    }
}