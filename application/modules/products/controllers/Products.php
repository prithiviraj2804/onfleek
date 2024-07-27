<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Products extends Admin_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('mdl_products');
		$this->load->model('mdl_subproducts');
		$this->load->model('families/mdl_families');
		$this->load->model('units/mdl_units');
	}

	public function index($page = 0) {
		
		$limit = 15;
		$this->mdl_products->where_in('mech_products.is_parent', ['N' ,'P']);
        $query = $this->mdl_products->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
		$createLinks = $pagination->createLinks();
		$this->mdl_products->limit($limit);
		$this->mdl_products->where_in('mech_products.is_parent', ['N' ,'P']);
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

		$this->layout->set(
            array(
                'products' => $products,
                'families' => $this->mdl_families->get()->result(),
				'createLinks' => $createLinks,
            )
        );

		$this->layout->buffer('content', 'products/index');
		$this->layout->render();
	}

	public function form($id = null) {

		if ($id) {
			if (!$this->mdl_products->prep_form($id)) {
				show_404();
			}
			$this->mdl_products->set_form_value('is_update', true);
			$this->mdl_products->where('parent_id' , $id);
			$subproducts = $this->mdl_products->get()->result();
			if(count($subproducts) <= 0){
				$subproducts = array();
			}
			$uploadedImages = $this->mdl_products->getUploadedImages($this->mdl_products->form_value('url_key', true));
			$breadcrumb = "lable217";
		}else{
			$breadcrumb = "lable216";
			$uploadedImages = array();
			$subproducts = array();
		}

		$this->layout->set(array(
			'breadcrumb' => $breadcrumb,
			'subproducts' => $subproducts,
			'uploadedImages' => $uploadedImages,
			'families' => $this->mdl_families->get()->result(),
			'car_brand_list' => $this->db->get_where('mech_car_brand_details', array('status' => 1))->result(),
            'car_model_list' => $this->db->get_where('mech_car_brand_models_details', array('status' => 1))->result(),
            'car_variant_list' => $this->db->get_where('mech_brand_model_variants', array('status' => 1))->result(),
			'units' => $this->mdl_units->get()->result(), 
		));

		$this->layout->buffer('content', 'products/form');
		$this->layout->render();
	}

	public function delete($id=null) {

		$id = $this->input->post('id');
		$this->db->where('product_id', $id);
		$this->db->update('mech_products', array('status'=>'D'));
		$response = array(
            'success' => 1
        );
		echo json_encode($response);

	}

	public function view_inventory($product_id = NULL){
		$inventory_list = $this->db->select('inventory_id,workshop_id,w_branch_id,product_id,entity_id,stock_type,quantity,price,stock_date,description,action_type')->where('product_id',$product_id)->get('mech_inventory')->result();
		$product = $this->mdl_products->where('mech_products.product_id',$product_id)->get()->row();

		$this->layout->set(array(
			'inventory_list' => $inventory_list,
			'product' => $product
		));
		
		$this->layout->buffer('content', 'products/product_stock_history');
		$this->layout->render();
	}	

	public function deleteProductSubgroup(){
		$id = $this->input->post('id');
		$this->db->where('subpro_id', $id);
		$this->db->update('product_bmv_type_price_dtls', array('status'=>'D'));
		$response = array(
            'success' => 1
        );
        echo json_encode($response);
	}
}