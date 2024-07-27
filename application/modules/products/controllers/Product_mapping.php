<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Class Products.
 */
class Product_Mapping extends Admin_Controller
{
    /**
     * Products constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_product_mapping');
        $this->load->model('mdl_products');
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {
        $this->mdl_product_mapping->paginate(site_url('products/index'), $page);
        $products = $this->mdl_product_mapping->result();
        $this->layout->set('products', $products);
        $this->layout->buffer('content', 'products/mapping');
        $this->layout->render();
    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('products/product_mapping');
        }

        if ($this->mdl_product_mapping->run_validation()) {
            $this->mdl_product_mapping->save($id);
            redirect('products/product_mapping');
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_product_mapping->prep_form($id)) {
                show_404();
            }
            $breadcrumb = 'Create Product Mapping';
        } else {
            $breadcrumb = 'Edit Product Mapping';
        }

        $this->load->model('families/mdl_families');
        $this->load->model('units/mdl_units');
        $this->load->model('tax_rates/mdl_tax_rates');

        $this->load->model('mech_car_brand_details/mdl_mech_car_brand_details');
        $this->load->model('mech_car_brand_models_details/mdl_mech_car_brand_models_details');
        $this->load->model('mech_brand_model_variants/mdl_mech_brand_model_variants');
        $this->load->model('mechanic_service_category_items/mdl_mechanic_service_category_items');
        $this->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls');

        if ($id) {
            $product_mapping = $this->mdl_product_mapping->where('product_map_id', $id)->get()->row();
            $model_list = $this->db->get_where('mech_car_brand_models_details', array('status' => 1, 'brand_id' => $product_mapping->brand_id))->result();
            $variant_list = $this->db->get_where('mech_brand_model_variants', array('status' => 1, 'brand_id' => $product_mapping->brand_id, 'model_id' => $product_mapping->model_id))->result();
        } else {
            $car_detail = array();
            $model_list = array();
            $variant_list = array();
        }

        $this->layout->set(array(
            'breadcrumb' => $breadcrumb,
            'products' => $this->mdl_products->get()->result(),
            'mechanic_service_category_items' => $this->mdl_mech_service_item_dtls->get()->result(),
            'brand_list' => $this->mdl_mech_car_brand_details->get()->result(),
            'brand_models_list' => $model_list,
            'variants_list' => $variant_list,
            'units' => $this->mdl_units->get()->result(),
            'tax_rates' => $this->mdl_tax_rates->get()->result(),
            ));

        $this->layout->buffer('content', 'products/mapping_form');
        $this->layout->render();
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->mdl_product_mapping->delete($id);
        redirect('products/product_mapping');
    }
}
