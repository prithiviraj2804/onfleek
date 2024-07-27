<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function create()
    {
        $this->load->model('products/mdl_products');
        $action_from = ($this->input->post('action_from'))?$this->input->post('action_from'):'';
        $product_id = $this->input->post('product_id');
        $productCostPriceList = json_decode($this->input->post('productCostPriceList'));
        $btn_submit = $this->input->post('btn_submit');
        
        if ($this->mdl_products->run_validation()) {
            $product_id = $this->mdl_products->save($product_id);
            if(count($productCostPriceList) > 0 && ($this->input->post('apply_for_all_bmv') == "N" || $this->input->post('apply_for_all_bmv') == " ")){
                foreach ($productCostPriceList as $product) {
                    if(!empty($product->brand_id)){
                        $product_array = array(
                            'parent_id' => $product_id,
                            'is_parent' => 'C',
                            'url_key' => $this->input->post('url_key')?$this->input->post('url_key'):NULL,
                            'product_name' => $product->subProductName?$product->subProductName:NULL,
                            'product_category_id' => $this->input->post('product_category_id')?$this->input->post('product_category_id'):NULL,
                            'unit_type' => $this->input->post('unit_type')?$this->input->post('unit_type'):NULL,
                            'product_type' => 'P',
                            'hsn_code' => $product->hsn_code?$product->hsn_code:NULL,
                            'brand_id' => $product->brand_id?$product->brand_id:NULL,
                            'model_id' => $product->model_id?$product->model_id:NULL,
                            'variant_id' => $product->variant_id?$product->variant_id:NULL,
                            'fuel_type' => $product->fuel_type?$product->fuel_type:NULL,
                            'reorder_quantity' => $product->reorder_qty?$product->reorder_qty:NULL,
                            'cost_price' => $product->cost_pr?$product->cost_pr:0,
                            'sale_price' => $product->sale_pr?$product->sale_pr:0,
                            'variant_id' => $product->variant_id?$product->variant_id:NULL,
                            'kilo_from' => $this->input->post('kilo_from')?$this->input->post('kilo_from'):NULL,
                            'kilo_to' => $this->input->post('kilo_to')?$this->input->post('kilo_to'):NULL,
                            'mon_from' => $this->input->post('mon_from')?$this->input->post('mon_from'):NULL,
                            'mon_to' => $this->input->post('mon_to')?$this->input->post('mon_to'):NULL,
                            'rack_no' => $this->input->post('rack_no')?$this->input->post('rack_no'):NULL,
                            'tax_percentage' => $this->input->post('tax_percentage')?$this->input->post('tax_percentage'):NULL,
                            'description' => $this->input->post('description')?$this->input->post('description'):NULL,
                        );
                        if(!empty($product->subpro_id)){
                            $product_array['modified_by'] = $this->session->userdata('user_id');
                            $this->mdl_products->save($product->subpro_id,$product_array);
                        }else{
                            $product_array['created_on'] = date('Y-m-d H:i:s');
                            $product_array['created_by'] = $this->session->userdata('user_id');
                            $product_array['modified_by'] = $this->session->userdata('user_id');
                            $product_array['workshop_id'] = $this->session->userdata('work_shop_id');
                            $product_array['w_branch_id'] = $this->session->userdata('branch_id');
                            $this->mdl_products->save(NULL,$product_array);
                        }
                    }else {
                        $this->load->library('form_validation');
                        $this->form_validation->set_rules('product_item', trans('product'), 'required');
                        $this->form_validation->run();
                        $response = array(
                            'success' => 0,
                            'validation_errors' => array(
                                'product_item' => form_error('product_item', '', ''),
                            )
                        );
                        echo json_encode($response);
                        exit;
                    }
                }
            }
            
            $response = array(
                'success' => 1,
                'product_id' => $product_id
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
        }
        
        echo json_encode($response);
    }
    
    public function modal_product_lookups()
    {
        $filter_product = $this->input->get('filter_product');
        $filter_family = $this->input->get('filter_family');
        $reset_table = $this->input->get('reset_table');

        $this->load->model('mdl_products');
        $this->load->model('families/mdl_families');

        if (!empty($filter_family)) {
            $this->mdl_products->by_family($filter_family);
        }

        if (!empty($filter_product)) {
            $this->mdl_products->by_product($filter_product);
        }

        $products = $this->mdl_products->get()->result();
        $families = $this->mdl_families->get()->result();

        $data = array(
            'products' => $products,
            'families' => $families,
            'filter_product' => $filter_product,
            'filter_family' => $filter_family,
        );

        if ($filter_product || $filter_family || $reset_table) {
            $this->layout->load_view('products/partial_product_table_modal', $data);
        } else {
            $this->layout->load_view('products/modal_product_lookups', $data);
        }
    }

    public function process_product_selections()
    {
        $this->load->model('mdl_products');

        $products = $this->mdl_products->where_in('product_id', $this->input->post('product_ids'))->get()->result();

        foreach ($products as $product) {
            $product->product_price = format_amount($product->product_price);
        }

        echo json_encode($products);
    }

    public function getProductItemList()
    {
        $this->load->model('mdl_products');
        $product = $this->mdl_products->getProductItemList();
        
        echo json_encode($product);
    }

    public function get_product_details()
    {
        $this->load->model('mdl_products');
        $product = $this->mdl_products->getProductDetails();

        if (!empty($product)) {
            $response = array(
                'success' => 1,
                'products' => $product
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
        }
        echo json_encode($response);
    }

	public function get_service_item_list(){
		$this -> load -> model('mdl_products');
		if($this->input->post('apply_for_all_bmv') == 'Y'){
		    $products = $this->mdl_products->where('mech_products.apply_for_all_bmv',$this->input->post('apply_for_all_bmv'))->get()-> result();
		}else{
		    $products = $this->mdl_products->where('mech_products.brand_id',$this->input->post('brand_id'))->where('mech_products.model_id',$this->input->post('model_id'))->get()-> result();
		}
		
		if($products){
			$response = array(
                'success' => 1,
                'products' => $products
            );
		}else{
			$this->load->helper('json_error');
			$response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
		}
		echo json_encode($response);
	}
    public function modal_add_reduce_stock($product_id = NULL,$action_type = NULL, $page = NULL)
    {
        $this->load->module('layout');
        $data = array(
            'product_id' => $product_id,
            'action_type' => $action_type,
            'page' => $page
        );
        $this->layout->load_view('products/modal_add_reduce_stock', $data);
    }
    public function save_stock()
    {
        $this->load->model('mdl_products');
        if ($this->mdl_products->run_validation('validation_rules_add_stock')) {
            $item_data = array(
                'product_id' => $this->input->post('product_id'),
                'stock_type' => $this->input->post('stock_type'),
                'quantity' => $this->input->post('quantity'),
                'price' => $this->input->post('price'),
                'stock_date' => $this->input->post('stock_date')?date_to_mysql($this->input->post('stock_date')):date('Y-m-d'),
                'description' => $this->input->post('note'),
                'action_type' => $this->input->post('action_type')
            );
            $status = $this->mdl_products->save_inventory($item_data);
            if($status == 'SUCCESS'){
                $response = array(
                    'success' => 1,
                    'validation_errors' => ''
                );
            }else{
                $this->load->helper('json_error');
                $response = array(
                    'success' => 0,
                    'validation_errors' => 'Error'
                );
            }
        }else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
        }
        echo json_encode($response);
    }

    public function get_product_list(){
        $this->load->model('products/mdl_products');
        $products_list = $this->mdl_products->get()->result();
        echo json_encode($products_list);
    }

    public function getUploadedImages(){
        $this->load->model('products/mdl_products');
        if($this->input->post('url_key')){
            $productImages = $this->mdl_products->getUploadedImages($this->input->post('url_key'));
            if(count($productImages) > 0){
                $response = array(
                    'success' => 1,
                    'productImages' => $productImages,
                    'msg' => '',
                );
            }else{
                $response = array(
                    'success' => 0,
                    'productImages' => '',
                    'msg' => 'No data Found',
                );
            }
        }else{
            $response = array(
                'success' => 0,
                'productImages' => '',
                'msg' => 'url-key not Found',
            );
        }
        
        echo json_encode($response);
        exit();
    }

    public function get_filter_list(){
        $this->load->model('products/mdl_products');
        $this->load->model('products/mdl_subproducts');
        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;
        if($this->input->post('product_name')){
            $this->mdl_products->like('mech_products.product_name', trim($this->input->post('product_name')));
        }
        if($this->input->post('product_category_id')){
            $this->mdl_products->where('mech_products.product_category_id', trim($this->input->post('product_category_id')));
        }
        $this->mdl_products->where_in('mech_products.is_parent', ['N' ,'P']);
        $rowCount = $this->mdl_products->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        if($this->input->post('product_name')){
            $this->mdl_products->like('mech_products.product_name', trim($this->input->post('product_name')));
        }
        if($this->input->post('product_category_id')){
            $this->mdl_products->where('mech_products.product_category_id', trim($this->input->post('product_category_id')));
        }
        $this->mdl_products->where_in('mech_products.is_parent', ['N' ,'P']);
        $this->mdl_products->limit($limit,$start);
        $products = $this->mdl_products->get()->result();           

        if(count($products) > 0){
			foreach($products as $key => $pro){
				if($pro->is_parent == "P"){
                    $subproducts = $this->mdl_products->where('mech_products.parent_id' , $pro->product_id)->get()->result();
					if(count($subproducts) > 0){
						$products[$key]->subproducts = $subproducts;
					}else{
                        $products[$key]->subproducts = array();
                    }
				}else{
                    $products[$key]->subproducts = array();
                }
			}
        }
        
        $response = array(
            'success' => 1,
            'products' => $products, 
            'createLinks' => $createLinks,
            'work_shop_id' => $this->session->userdata('work_shop_id'),
            'user_type' => $this->session->userdata('user_type'),
            'workshop_is_enabled_inventory' => $this->session->userdata('workshop_is_enabled_inventory'),
        );
        echo json_encode($response);
    }
}
