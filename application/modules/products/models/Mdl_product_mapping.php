<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Class Mdl_Products.
 */
class Mdl_Product_Mapping extends Response_Model
{
    public $table = 'mech_product_map_detail';
    public $primary_key = 'mech_product_map_detail.product_map_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *,mech_product_map_detail.brand_id,mech_product_map_detail.reorder_quantity,mech_products.product_name,
        mech_product_map_detail.model_id,mech_product_map_detail.variant_id,cb.brand_name,cbm.model_name,cvm.variant_name', false);
    }

    public function default_join()
    {
        $this->db->join('mech_products', 'mech_products.product_id = mech_product_map_detail.product_id', 'left');
        $this->db->join('mech_car_brand_details cb', 'cb.brand_id = mech_product_map_detail.brand_id', 'left');
        $this->db->join('mech_car_brand_models_details cbm', 'cbm.model_id = mech_product_map_detail.model_id', 'left');
        $this->db->join('mech_brand_model_variants cvm', 'cvm.brand_model_variant_id = mech_product_map_detail.variant_id', 'left');
    }

    public function by_product($match)
    {
        $this->db->group_start();
        $this->db->like('mech_product_map_detail.product_sku', $match);
        $this->db->or_like('mech_product_map_detail.product_name', $match);
        $this->db->or_like('mech_product_map_detail.product_description', $match);
        $this->db->group_end();
    }

    public function default_where()
    {
        $this->db->where('mech_product_map_detail.workshop_id', $this->session->userdata('work_shop_id'));
		if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $this->db->where('mech_product_map_detail.w_branch_id', $this->session->userdata('branch_id'));
        }else if($this->session->userdata('user_type') == 6){
			$this->db->where_in('mech_product_map_detail.w_branch_id', $this->session->userdata('user_branch_id'));
        }
    }

    public function by_family($match)
    {
        $this->db->where('mech_product_map_detail.family_id', $match);
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'product_id' => array(
                'field' => 'product_id',
                'label' => trans('product_id'),
                'rules' => 'required|trim|strip_tags',
            ),
            'brand_id' => array(
                'field' => 'brand_id',
                'label' => trans('brand_id'),
                'rules' => 'required|trim|strip_tags',
            ),
            'model_id' => array(
                'field' => 'model_id',
                'label' => trans('model_id'),
                'rules' => 'required|trim|strip_tags',
            ),
            'variant_id' => array(
                'field' => 'variant_id',
                'label' => trans('variant_id'),
            ),
            'fuel_type' => array(
                'field' => 'fuel_type',
                'label' => trans('fuel_type'),
                'rules' => 'required|trim|strip_tags',
            ),
            'cost_price' => array(
                'field' => 'cost_price',
                'label' => trans('cost_price'),
            ),
            'sale_price' => array(
                'field' => 'sale_price',
                'label' => trans('sale_price'),
            ),
            'diff_amount' => array(
                'field' => 'diff_amount',
                'label' => trans('diff_amount'),
            ),
            'description' => array(
                'field' => 'description',
                'label' => trans('description'),
            ),
            //calc
            'cgst_percentage' => array(
                'field' => 'cgst_percentage',
                'label' => trans('cgst_percentage'),
                'rules' => 'numeric',
            ),
            'cgst_amount' => array(
                'field' => 'cgst_amount',
                'label' => trans('cgst_amount'),
                'rules' => 'numeric',
            ),
            'sgst_percentage' => array(
                'field' => 'sgst_percentage',
                'label' => trans('sgst_percentage'),
                'rules' => 'numeric',
            ),
            'sgst_amount' => array(
                'field' => 'sgst_amount',
                'label' => trans('sgst_amount'),
                'rules' => 'numeric',
            ),
            'igst_percentage' => array(
                'field' => 'igst_percentage',
                'label' => trans('igst_percentage'),
                'rules' => 'numeric',
            ),
            'igst_amount' => array(
                'field' => 'igst_amount',
                'label' => trans('igst_amount'),
                'rules' => 'numeric',
            ),
            'total_amount' => array(
                'field' => 'total_amount',
                'label' => trans('total_amount'),
                'rules' => 'numeric',
            ),
            'cess_percentage' => array(
                'field' => 'cess_percentage',
                'label' => trans('cess_percentage'),
                'rules' => 'numeric',
            ),
            'cess_amount' => array(
                'field' => 'cess_amount',
                'label' => trans('cess_amount'),
                'rules' => 'numeric',
            ),
            'reorder_quantity' => array(
                'field' => 'reorder_quantity',
                'label' => trans('reorder_quantity'),
                'rules' => '',
            ),
            '_mm_csrf' => array(
                'field' => '_mm_csrf',
            ),
        );
    }

    /**
     * @return array
     */
    public function db_array()
    {
        $db_array = parent::db_array();
        $db_array['workshop_id'] = $this->session->userdata('work_shop_id');
        $db_array['w_branch_id'] = $this->session->userdata('branch_id');

        //$db_array['tax_rate_id'] = (empty($db_array['tax_rate_id']) ? null : $db_array['tax_rate_id']);

        return $db_array;
    }

    public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();
        // Save the car
        $id = parent::save($id, $db_array);

        return $id;
    }

    public function get_product_name($product_map_id)
    {
        $this->db->select('product_name');
        $this->db->where('product_map_id', $product_map_id);
        $product = $this->db->get('mech_product_map_detail');

        if ($product->num_rows()) {
            $product_name = $product->row()->product_name;
        } else {
            $product_name = '-';
        }

        return $product_name;
    }
}
