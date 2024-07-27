<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('mech_item_master/mdl_mech_item_master');
        $this->load->model('mech_item_master/mdl_mech_product_price_list');
        $this->load->model('families/mdl_families');
        $this->load->model('mech_item_master/mdl_mech_service_master');
        $this->load->model('mech_item_master/mdl_mech_service_price_list');
		$this->load->model('mech_car_brand_details/mdl_mech_car_brand_details');
		$this->load->model('mech_car_brand_models_details/mdl_mech_car_brand_models_details');
        $this->load->model('units/mdl_units');
        $this->load->model('mech_car_brand_models_details/mdl_mech_car_brand_models_details'); 
        $this->load->model('product_brands/mdl_vendor_product_brand');
        $this->load->model('mech_invoices/mdl_mech_invoice');
        $this->load->model('spare_invoices/mdl_spare_invoice');
        $this->load->model('spare_quotes/mdl_spare_quotes');
        $this->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');
        $this->load->model('mech_purchase/mdl_mech_purchase');
        $this->load->model('mech_purchase_order/mdl_mech_purchase_order');
        $this->load->model('mech_quotes/mdl_mech_quotes');
        $this->load->model('service_packages/mdl_service_package');
        $this->load->model('mechanic_service_category/mdl_mechanic_service_category_list');
        $this->load->model('mechanic_service_item_price_list/mdl_service_body_type_price_dtls');
    }
    
    public function create()
    {


        $action_from = ($this->input->post('action_from'))?$this->input->post('action_from'):'';
        $product_id = $this->input->post('product_id');
        $product_name = $this->input->post('product_name');

        $productCostPriceList = json_decode($this->input->post('productCostPriceList'));
        $btn_submit = $this->input->post('btn_submit');
        
        if ($this->mdl_mech_item_master->run_validation()) {

            if ($this->input->post('product_id')) {
                $check = $this->db->select('product_name')->from('mech_products')->where('product_name',$this->input->post('product_name'))->where('status !=','D')->where('product_category_id',$this->input->post('product_category_id'))->where_in('workshop_id',array('1',$this->session->userdata('work_shop_id')))->where_in('w_branch_id',array('1',$this->session->userdata('branch_id')))->where_not_in('product_id',$this->input->post('product_id'))->get()->result();   
                if (!empty($check)) {
                    $response = array(
                        'success' => 2,
                    );
                    echo json_encode($response);
                    exit();
                }
            }else{
                $check = $this->db->select('product_name')->from('mech_products')->where('product_name',$this->input->post('product_name'))->where('status !=','D')->where('product_category_id',$this->input->post('product_category_id'))->where_in('workshop_id',array('1',$this->session->userdata('work_shop_id')))->where_in('w_branch_id',array('1',$this->session->userdata('branch_id')))->get()->result();   

                // $check = $this->db->get_where('mech_customer_category', array('customer_category_name' => $this->input->post('customer_category_name'),'workshop_id' => $this->session->userdata('work_shop_id'),'status !=' => 'D'))->result();
                if (!empty($check)) {
                    $response = array(
                        'success' => 2,
                    );
                    echo json_encode($response);
                    exit();
                }
            }

            $product_id = $this->mdl_mech_item_master->save($product_id);

            if(empty($this->input->post('product_id'))){
                $item_data = array(
                    'product_id' => $product_id,
                    'stock_type' => '3',
                    'quantity' => $this->input->post('current_stock'),
                    'price' => $this->input->post('cost_price'),
                    'stock_date' => date('Y-m-d'),
                    'description' => $this->input->post('note'),
                    'action_type' => 1,
                );
                $status = $this->mdl_mech_item_master->save_inventory($item_data);
            }

            if($product_id && $this->session->userdata('work_shop_id') != 1){
                $price_list = array(
                    'product_id' => $product_id,
                    // 'rack_no' => $this->input->post('rack_no'),
                    // 'reorder_quantity' => $this->input->post('reorder_quantity'),
                    'cost_price' => $this->input->post('cost_price'),
                    'mrp_price' => $this->input->post('mrp_price'),
                    'sale_price' => $this->input->post('sale_price')
                );
                if($this->input->post('mppl_id')){
                    $price_list['modified_by'] = $this->session->userdata('user_id');
                    $this->mdl_mech_product_price_list->save($this->input->post('mppl_id') , $price_list);
                }else{
                    $price_list['created_on'] = date('Y-m-d H:i:s');
                    $price_list['created_by'] = $this->session->userdata('user_id');
                    $price_list['modified_by'] = $this->session->userdata('user_id');
                    $price_list['workshop_id'] = $this->session->userdata('work_shop_id');
                    $price_list['w_branch_id'] = $this->session->userdata('branch_id');
                    $this->mdl_mech_product_price_list->save(NULL, $price_list);
                }
            }
            if(!empty($product_id) && count($productCostPriceList) > 0 && ($this->input->post('apply_for_all_bmv') != "Y" )){
                foreach ($productCostPriceList as $product) {
                    if(!empty($product->brand_id) || !empty($product->model_id) || !empty($product->variant_id) || !empty($product->fuel_type) || !empty($product->year) ){
                        $product_array = array(
                            'product_id' => $product_id,
                            'brand_id' => $product->brand_id?$product->brand_id:NULL,
                            'model_id' => $product->model_id?$product->model_id:NULL,
                            'variant_id' => $product->variant_id?$product->variant_id:NULL,
                            'fuel_type' => $product->fuel_type?$product->fuel_type:NULL,
                            'year' => $product->year?$product->year:NULL,
                        );
                        if(!empty($product->product_map_id)){
                            $this->db->where('product_map_id' , $product->product_map_id);
                            $this->db->update('mech_product_map_detail' , $product_array);
                        }else{
                            $this->db->insert('mech_product_map_detail' , $product_array);
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
                'btn_submit' => $btn_submit,
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

    public function getProductItemList()
    {
        $product = $this->mdl_mech_item_master->getProductItemList();
        echo json_encode($product);
    }

    public function getAdminProductItemList(){
        $product = $this->mdl_mech_item_master->getAdminProductItemList();
        echo json_encode($product);
    }

    public function get_product_details()
    {
        $product = $this->mdl_mech_item_master->getProductDetails();
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
    
    public function get_admin_product_details()
    {
        $product = $this->mdl_mech_item_master->getAdminProductDetails();
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
    
    public function modal_add_reduce_stock($product_id = NULL,$action_type = NULL,$purchase_price = NULL, $page = NULL)
    {
        $this->load->module('layout');
        $data = array(
            'product_id' => $product_id,
            'action_type' => $action_type,
            'purchase_price' => $purchase_price,
            'page' => $page
        );
        $this->layout->load_view('mech_item_master/modal_add_reduce_stock', $data);
    }

    public function save_stock()
    {
        if ($this->mdl_mech_item_master->run_validation('validation_rules_add_stock')) {
            $item_data = array(
                'product_id' => $this->input->post('product_id'),
                'stock_type' => $this->input->post('stock_type'),
                'quantity' => $this->input->post('quantity'),
                'price' => $this->input->post('price'),
                'stock_date' => $this->input->post('stock_date')?date_to_mysql($this->input->post('stock_date')):date('Y-m-d'),
                'description' => $this->input->post('note'),
                'action_type' => $this->input->post('action_type')
            );
            $status = $this->mdl_mech_item_master->save_inventory($item_data);
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
        $products_list = $this->mdl_mech_item_master->get()->result();
        echo json_encode($products_list);
    }

    public function getUploadedImages(){
        if($this->input->post('url_key')){
            $productImages = $this->mdl_mech_item_master->getUploadedImages($this->input->post('url_key'));
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

    public function get_product_filter_list(){

        $this->load->model('user_cars/mdl_user_cars');

        $user_car_list_id = $this->input->post('user_car_list_id');
        $customerCarDetail = $this->mdl_user_cars->where('car_list_id' , $user_car_list_id)->get()->row();
        $product_category_id  = $this->input->post('product_category_id');
        $customer_car_id = $this->input->post('customer_car_id');
        $customerCarDetail = $this->mdl_user_cars->where('car_list_id' , $customer_car_id)->get()->row();

        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;


        $this->mdl_mech_item_master->where_in('mech_products.workshop_id', array('1',$this->session->userdata('work_shop_id')));
        $this->mdl_mech_item_master->join('mech_product_map_detail', 'mech_product_map_detail.product_id = mech_products.product_id','left');
        if($customer_car_id){
            if($customerCarDetail->car_brand_id){
                $this->mdl_mech_item_master->where('mech_product_map_detail.brand_id' , $customerCarDetail->car_brand_id);
            }
            if($customerCarDetail->car_brand_model_id){
                $this->mdl_mech_item_master->where('mech_product_map_detail.model_id' , $customerCarDetail->car_brand_model_id);
            }
            if($customerCarDetail->car_variant){
                $this->mdl_mech_item_master->where('mech_product_map_detail.variant_id' , $customerCarDetail->car_variant);
            }
            if($customerCarDetail->fuel_type){
                $this->mdl_mech_item_master->where('mech_product_map_detail.fuel_type', $customerCarDetail->fuel_type);
            }
            if($customerCarDetail->car_model_year){
                $this->mdl_mech_item_master->where('mech_product_map_detail.year' , $customerCarDetail->car_model_year);
            }
        }else{
            if($this->input->post('brand_id') != '' && $this->input->post('brand_id') != 0){
                $this->mdl_mech_item_master->where('mech_product_map_detail.brand_id' , $this->input->post('brand_id'));
            }
            if($this->input->post('model_id') != '' && $this->input->post('model_id') != 0){
                $this->mdl_mech_item_master->where('mech_product_map_detail.model_id' , $this->input->post('model_id'));
            }
            if($this->input->post('variant_id') != '' && $this->input->post('variant_id') != 0){
                $this->mdl_mech_item_master->where('mech_product_map_detail.variant_id' , $this->input->post('variant_id'));
            }
            if($this->input->post('fuel_type')){
                $this->mdl_mech_item_master->where('mech_product_map_detail.fuel_type' , $this->input->post('fuel_type'));
            }
        }

        if($this->input->post('product_name')){
            $this->mdl_mech_item_master->where("`mech_products`.`product_name` LIKE '".$this->input->post('product_name')."%' ESCAPE '!'");
        }

        if($this->input->post('part_number')){
            $this->mdl_mech_item_master->like('mech_products.part_number', trim($this->input->post('part_number')));
        }

        if($this->input->post('product_category_id') != '' && $this->input->post('product_category_id') != 0){
            $this->mdl_mech_item_master->where('mech_products.product_category_id', trim($this->input->post('product_category_id')));
        }
        
        if($this->input->post('product_brand_id') != '' && $this->input->post('product_brand_id') != 0 ){
            $this->mdl_mech_item_master->where('mech_products.product_brand_id', $this->input->post('product_brand_id'));
        }

        if($this->input->post('rack_no')){
            $this->mdl_mech_item_master->like('mech_products.rack_no', trim($this->input->post('rack_no')));
        }

        if($this->input->post('popup_car_brand_id')){
            $this->mdl_mech_item_master->like('mech_product_map_detail.brand_id' , $this->input->post('popup_car_brand_id'));
        }
        if($this->input->post('popup_car_brand_model_id')){
            $this->mdl_mech_item_master->like('mech_product_map_detail.model_id' , $this->input->post('popup_car_brand_model_id'));
        }
        

        $rowCount = $this->mdl_mech_item_master->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        $this->mdl_mech_item_master->where_in('mech_products.workshop_id', array('1',$this->session->userdata('work_shop_id')));
        $this->mdl_mech_item_master->join('mech_product_map_detail', 'mech_product_map_detail.product_id = mech_products.product_id','left');
        if($customer_car_id){
            if($customerCarDetail->car_brand_id != '' && $customerCarDetail->car_brand_id != 0){
                $this->mdl_mech_item_master->where('mech_product_map_detail.brand_id' , $customerCarDetail->car_brand_id);
            }
            if($customerCarDetail->car_brand_model_id != '' && $customerCarDetail->car_brand_model_id != 0){
                $this->mdl_mech_item_master->where('mech_product_map_detail.model_id' , $customerCarDetail->car_brand_model_id);
            }
            if($customerCarDetail->car_variant != '' && $customerCarDetail->car_variant != 0){
                $this->mdl_mech_item_master->where('mech_product_map_detail.variant_id' , $customerCarDetail->car_variant);
            }
            if($customerCarDetail->fuel_type){
                $this->mdl_mech_item_master->where('mech_product_map_detail.fuel_type', $customerCarDetail->fuel_type);
            }
            if($customerCarDetail->car_model_year){
                $this->mdl_mech_item_master->where('mech_product_map_detail.year' , $customerCarDetail->car_model_year);
            }
        }else{
            if($this->input->post('brand_id') != '' && $this->input->post('brand_id') != 0){
                $this->mdl_mech_item_master->where('mech_product_map_detail.brand_id' , $this->input->post('brand_id'));
            }
            if($this->input->post('model_id') != '' && $this->input->post('model_id') != 0){
                $this->mdl_mech_item_master->where('mech_product_map_detail.model_id' , $this->input->post('model_id'));
            }
            if($this->input->post('variant_id') != '' && $this->input->post('variant_id') != 0){
                $this->mdl_mech_item_master->where('mech_product_map_detail.variant_id' , $this->input->post('variant_id'));
            }
            if($this->input->post('fuel_type')){
                $this->mdl_mech_item_master->where('mech_product_map_detail.fuel_type' , $this->input->post('fuel_type'));
            }
            
        }

        if($this->input->post('product_name')){
            $this->mdl_mech_item_master->where("`mech_products`.`product_name` LIKE '".$this->input->post('product_name')."%' ESCAPE '!'");
        }

        if($this->input->post('part_number')){
            $this->mdl_mech_item_master->like('mech_products.part_number', trim($this->input->post('part_number')));
        }

        if($this->input->post('product_category_id') != '' && $this->input->post('product_category_id') != 0){
            $this->mdl_mech_item_master->where('mech_products.product_category_id', trim($this->input->post('product_category_id')));
        }
        
        if($this->input->post('product_brand_id') != '' && $this->input->post('product_brand_id') != 0 ){
            $this->mdl_mech_item_master->where('mech_products.product_brand_id', $this->input->post('product_brand_id'));
        }

        if($this->input->post('rack_no')){
            $this->mdl_mech_item_master->like('mech_products.rack_no', trim($this->input->post('rack_no')));
        }
        if($this->input->post('popup_car_brand_id')){
            $this->mdl_mech_item_master->like('mech_product_map_detail.brand_id' , $this->input->post('popup_car_brand_id'));
        }
        if($this->input->post('popup_car_brand_model_id')){
            $this->mdl_mech_item_master->like('mech_product_map_detail.model_id' , $this->input->post('popup_car_brand_model_id'));
        }

        $this->mdl_mech_item_master->limit($limit,$start);
        $products = $this->mdl_mech_item_master->get()->result(); 

        if(count($products) > 0){
			foreach($products as $key => $pro){
				if($pro->apply_for_all_bmv != "Y"){
					$subproducts = $this->mdl_mech_item_master->getProductBrandDetails($pro->product_id);
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
        

        if($this->input->post('entity_type') == 'I'){
            $product_list = $this->mdl_mech_invoice->get_user_quote_product_item($this->input->post('entity_id'), $this->input->post('customer_id'));
        }else if($this->input->post('entity_type') == 'SI'){
            $product_list = $this->mdl_spare_invoice->get_user_quote_product_item($this->input->post('entity_id'), $this->input->post('customer_id'));
        }else if($this->input->post('entity_type') == 'J'){
            $product_list = $this->mdl_mech_work_order_dtls->get_user_quote_product_item($this->input->post('entity_id'), $this->input->post('customer_id'));
        }else if($this->input->post('entity_type') == 'P'){
            $product_list = $this->mdl_mech_purchase->get_purchase_product_item($this->input->post('entity_id'));
        }else if($this->input->post('entity_type') == 'PO'){
            $product_list = $this->mdl_mech_purchase_order->get_purchase_product_item($this->input->post('entity_id'), $this->input->post('customer_id'));
        }else if($this->input->post('entity_type') == 'Q'){
            $product_list = $this->mdl_mech_quotes->get_user_quote_product_item($this->input->post('entity_id'), $this->input->post('customer_id'));
        }else if($this->input->post('entity_type') == 'SQ'){
            $product_list = $this->mdl_spare_quotes->get_user_quote_product_item($this->input->post('entity_id'), $this->input->post('customer_id'));
        }else if($this->input->post('entity_type') == 'L'){
            $this->load->model('mech_leads/mdl_mech_leads');
            $product_list = $this->mdl_mech_leads->get_user_quote_product_item($this->input->post('entity_id'), $this->input->post('customer_id'));
        }else if($this->input->post('entity_type') == 'A'){
            $this->load->model('mech_appointments/mdl_mech_leads');
            $product_list = $this->mdl_mech_leads->get_user_quote_product_item($this->input->post('entity_id'), $this->input->post('customer_id'));
        }

        $response = array(
            'success' => 1,
            'product_list' => json_decode($product_list),
            'products' => $products, 
            'createLinks' => $createLinks,
            'work_shop_id' => $this->session->userdata('work_shop_id'),
            'user_type' => $this->session->userdata('user_type'),
            'workshop_is_enabled_inventory' => $this->session->userdata('workshop_is_enabled_inventory'),
        );
        echo json_encode($response);
    }

    public function get_selected_product_list(){

        if(count($this->input->post('yourArray')) > 0){
            if($this->input->post('yourArray')){
                $this->mdl_mech_item_master->where_in('mech_products.product_id', $this->input->post('yourArray'));
            }
            // $this->mdl_mech_item_master->limit($limit,$start);
            $products = $this->mdl_mech_item_master->get()->result();           
    
            if(count($products) > 0){
                foreach($products as $key => $pro){
                    if($pro->apply_for_all_bmv != "Y"){
                        $subproducts = $this->mdl_mech_item_master->getProductBrandDetails($pro->product_id);
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
        }else{
            $products = array();
        }
        

        $response = array(
            'success' => 1,
            'products' => $products
        );
        echo json_encode($response);

    }

    public function get_selected_service_list(){

        if(count($this->input->post('yourArray')) > 0){
            if($this->input->post('yourArray')){
                $this->mdl_mech_service_master->where_in('mech_service_item_dtls.msim_id', $this->input->post('yourArray'));
            }
            $services = $this->mdl_mech_service_master->get()->result();           

        }else{
            $services = array();
        }
        
        $response = array(
            'success' => 1,
            'services' => $services
        );
        echo json_encode($response);

    }

    public function create_service()
    {
        $action_from = ($this->input->post('action_from'))?$this->input->post('action_from'):'';
        $msim_id = $this->input->post('msim_id');
        $productCostPriceList = json_decode($this->input->post('productCostPriceList'));
        $serviceCostPriceList = json_decode($this->input->post('serviceCostPriceList'));
        $btn_submit = $this->input->post('btn_submit');
        
        if($this->mdl_mech_service_master->run_validation()){
            if ($this->input->post('msim_id')) {
                $check = $this->db->select('service_item_name')->from('mech_service_item_dtls')->where('service_item_name',$this->input->post('service_item_name'))->where('status !=','D')->where('service_category_id',$this->input->post('service_category_id'))->where_in('workshop_id',array(1,$this->session->userdata('work_shop_id')))->where_in('w_branch_id',array(1,$this->session->userdata('branch_id')))->where_not_in('msim_id',$this->input->post('msim_id'))->get()->result();   
                if (!empty($check)) {
                    $response = array(
                        'success' => 3,
                    );
                    echo json_encode($response);
                    exit();
                }
            }else{
                $check = $this->db->select('service_item_name')->from('mech_service_item_dtls')->where('service_item_name',$this->input->post('service_item_name'))->where('status !=','D')->where('service_category_id',$this->input->post('service_category_id'))->where_in('workshop_id',array(1,$this->session->userdata('work_shop_id')))->where_in('w_branch_id',array(1,$this->session->userdata('branch_id')))->get()->result();   

                // $check = $this->db->get_where('mech_customer_category', array('customer_category_name' => $this->input->post('customer_category_name'),'workshop_id' => $this->session->userdata('work_shop_id'),'status !=' => 'D'))->result();
                if (!empty($check)) {
                    $response = array(
                        'success' => 3,
                    );
                    echo json_encode($response);
                    exit();
                }
            }
            $msim_id = $this->mdl_mech_service_master->save($msim_id);

            if($msim_id){
                $service_price_list = array(
                    'msim_id' => $msim_id,
                    'estimated_cost' => $this->input->post('estimated_cost'),
                );
                if($this->input->post('msipl_id')){
                    $service_price_list['modified_by'] = $this->session->userdata('user_id');
                    $this->mdl_mech_service_price_list->save($this->input->post('msipl_id') , $service_price_list);
                }else{
                    $service_price_list['created_on'] = date('Y-m-d H:i:s');
                    $service_price_list['created_by'] = $this->session->userdata('user_id');
                    $service_price_list['modified_by'] = $this->session->userdata('user_id');
                    $service_price_list['workshop_id'] = $this->session->userdata('work_shop_id');
                    $service_price_list['w_branch_id'] = $this->session->userdata('branch_id');
                    $this->mdl_mech_service_price_list->save(NULL, $service_price_list);
                }
            }

            if(!empty($msim_id) && count($productCostPriceList) > 0 && ($this->input->post('apply_for_all_bmv') == "N" )){
                foreach ($productCostPriceList as $ser) {
                    if(!empty($ser->brand_id) || !empty($ser->model_id) || !empty($ser->variant_id) || !empty($ser->fuel_type) || !empty($ser->year) ){
                        $service_array = array(
                            'msim_id'           => $msim_id,
                            'workshop_id'       => $this->session->userdata('work_shop_id'),
                            'w_branch_id'       => $this->session->userdata('branch_id'),
                            'brand_id'          => $ser->brand_id?$ser->brand_id:NULL,
                            'model_id'          => $ser->model_id?$ser->model_id:NULL,
                            'variant_id'        => $ser->variant_id?$ser->variant_id:NULL,
                            'fuel_type'         => $ser->fuel_type?$ser->fuel_type:NULL,
                            'year'              => $ser->year?$ser->year:NULL,
                        );
                        if(!empty($ser->service_map_id )){
                            $this->db->where('service_map_id ' , $ser->service_map_id );
                            $this->db->update('mech_service_map_detail' , $service_array);
                        }else{
                            $this->db->insert('mech_service_map_detail' , $service_array);
                        }

                    }else {
                        $this->load->library('form_validation');
                        $this->form_validation->set_rules('service_item', trans('service'), 'required');
                        $this->form_validation->run();
                        $response = array(
                            'success' => 0,
                            'validation_errors' => array(
                                'service_item' => form_error('service_item', '', ''),
                            )
                        );
                        echo json_encode($response);
                        exit;
                    }
                }
            }

            if(!empty($msim_id) && count($serviceCostPriceList) > 0 && ($this->input->post('apply_for_all_bmv') == "S" )){
                // echo "i amherer";
                if(count($serviceCostPriceList) > 0){
                    // echo "i amherer hacker";
                    foreach($serviceCostPriceList as $service){
                        // echo "i amherer walker";
                         if(!empty($service->mvt_id)){
                             $service_array = array(
                                 'msim_id' => $msim_id,
                                 'mvt_id' => $service->mvt_id,
                                 'vehicle_type_value' => $service->vehicle_type_value,
                                 'default_cost' => $service->default_cost,
                                 'estimated_hour' => $service->estimated_hour,
                                 'estimated_cost' => $service->estimated_cost,
                             );
                            //  echo "esy==";
                             if(!empty($service->sct_id)){
                                //  echo "ikjnskcj==";
                                 $service_array['modified_by'] = $this->session->userdata('user_id');
                                 $this->db->where('sct_id', $service->sct_id);
                                 $service_id = $this->db->update('service_body_type_price_dtls', $service_array);
                             }else{
                                // echo "majhyahb==";s
                                 $service_array['created_on'] = date('Y-m-d H:i:s');
                                 $service_array['created_by'] = $this->session->userdata('user_id');
                                 $service_array['modified_by'] = $this->session->userdata('user_id');
                                 $service_array['workshop_id'] = $this->session->userdata('work_shop_id');
                                 $service_array['w_branch_id'] = $this->session->userdata('branch_id');
                                 $service_id = $this->db->insert('service_body_type_price_dtls', $service_array);
                             }
                         }else{
                             $this->load->library('form_validation');
                             $this->form_validation->set_rules('service_item', trans('service'), 'required');
                             $this->form_validation->run();
                             $response = array(
                                 'success' => 0,
                                 'validation_errors' => array(
                                     'service_item' => form_error('service_item', '', ''),
                                 )
                             );
                             echo json_encode($response);
                             exit;
                         }
                     }
                 }
            }

            $response = array(
                'success' => 1,
                'btn_submit' => $btn_submit,
                'msim_id' => $msim_id,
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
    
	public function get_service_details()
    {
    	
		$this->db->from('mechanic_service_item_mapping');
        $this->db->where('service_item_id', $this->input->post('service_ids'));
        if($this->input->post('car_brand_id')){
            $this->db->where('brand_id', $this->input->post('car_brand_id'));
        }
		//$this->db->where('model_id', $this->input->post('car_brand_model_id'));
        $service = $this->db->get()->row();

        if(empty($service)){
            $this->db->from('mechanic_service_item_mapping');
            $this->db->where('service_item_id', $this->input->post('service_ids'));
            $service = $this->db->get()->row();
        }
		
		if (!empty($service)){
            $response = array(
                'success' => 1,
                'services' => $service
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


    public function get_service_filter_list(){

        $this->load->model('mech_item_master/mdl_mech_service_master');
        // $this->load->model('mechanic_service_item_price_list/mdl_service_bmv_type_price_dtls');
        $this->mdl_mech_service_master->where_in('mech_service_item_dtls.workshop_id', array('1',$this->session->userdata('work_shop_id')));
        $this->mdl_mech_service_master->join('mech_service_map_detail', 'mech_service_map_detail.msim_id = mech_service_item_dtls.msim_id','left');

        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;
        if($this->input->post('service_item_name')){
            $this->mdl_mech_service_master->like('mech_service_item_dtls.service_item_name', trim($this->input->post('service_item_name')));
        }
        if($this->input->post('service_category_id')){
            $this->mdl_mech_service_master->where('mech_service_item_dtls.service_category_id', trim($this->input->post('service_category_id')));
        } 
        if($this->input->post('popup_car_brand_id')){
            $this->mdl_mech_service_master->like('mech_service_map_detail.brand_id' , $this->input->post('popup_car_brand_id'));
        }
        if($this->input->post('popup_car_brand_model_id')){
            $this->mdl_mech_service_master->like('mech_service_map_detail.model_id' , $this->input->post('popup_car_brand_model_id'));
        }

        $rowCount = $this->mdl_mech_service_master->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        $this->mdl_mech_service_master->where_in('mech_service_item_dtls.workshop_id', array('1',$this->session->userdata('work_shop_id')));
        $this->mdl_mech_service_master->join('mech_service_map_detail', 'mech_service_map_detail.msim_id = mech_service_item_dtls.msim_id','left');

        if($this->input->post('service_item_name')){
            $this->mdl_mech_service_master->like('mech_service_item_dtls.service_item_name', trim($this->input->post('service_item_name')));
        }
        if($this->input->post('service_category_id')){
            $this->mdl_mech_service_master->where('mech_service_item_dtls.service_category_id', trim($this->input->post('service_category_id')));
        }
        if($this->input->post('popup_car_brand_id')){
            $this->mdl_mech_service_master->like('mech_service_map_detail.brand_id' , $this->input->post('popup_car_brand_id'));
        }
        if($this->input->post('popup_car_brand_model_id')){
            $this->mdl_mech_service_master->like('mech_service_map_detail.model_id' , $this->input->post('popup_car_brand_model_id'));
        }

        $this->mdl_mech_service_master->limit($limit,$start);
        $mech_service_item_dtls = $this->mdl_mech_service_master->get()->result();

        if(count($mech_service_item_dtls) > 0){
			foreach($mech_service_item_dtls as $key => $pro){
				if($pro->apply_for_all_bmv == "N"){
					$subproducts = $this->mdl_mech_service_master->getServiceBrandDetails($pro->msim_id);
					if(count($subproducts) > 0){
						$mech_service_item_dtls[$key]->subproducts = $subproducts;
					}else{
						$mech_service_item_dtls[$key]->subproducts = array();
					}
				}else{
					$mech_service_item_dtls[$key]->subproducts = array();
				}
			}
		}

        if($this->input->post('entity_type') == 'SP'){
            $service_lists = $this->mdl_service_package->service_item_list($this->input->post('entity_id'));
        }else if($this->input->post('entity_type') == 'I'){
            $service_lists = $this->mdl_mech_invoice->get_user_quote_service_item($this->input->post('entity_id'));
        }else if($this->input->post('entity_type') == 'J'){
            $service_lists = $this->mdl_mech_work_order_dtls->get_user_quote_service_item($this->input->post('entity_id'));
        }else if($this->input->post('entity_type') == 'Q'){
            $service_lists = $this->mdl_mech_quotes->get_user_quote_service_item($this->input->post('entity_id'), $this->input->post('customer_id'));
        }else if($this->input->post('entity_type') == 'L'){
            $this->load->model('mech_leads/mdl_mech_leads');
            $service_lists = $this->mdl_mech_leads->get_user_quote_service_item($this->input->post('entity_id'), $this->input->post('customer_id'));
        }else if($this->input->post('entity_type') == 'A'){
            $this->load->model('mech_appointments/mdl_mech_leads');
            $service_lists = $this->mdl_mech_leads->get_user_quote_service_item($this->input->post('entity_id'), $this->input->post('customer_id'));
        }

        if($entity_type != 'SP'){
            $service_list = json_decode($service_lists);
        }else{
            $service_list = $service_lists;
        }   
        if(empty($service_list)){
            $service_list = array();
        }

        $response = array(
            'success' => 1,
            'mech_service_item_dtls' => $mech_service_item_dtls, 
            'service_list' => $service_list,
            'createLinks' => $createLinks,
        );
        echo json_encode($response);
    }

    public function modal_add_services(){

        $service_category_lists = $this->db->get_where('mechanic_service_category_list', array('category_type' => 1))->result();

        $this->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls');
        $this->load->model('mechanic_service_item_price_list/mdl_service_body_type_price_dtls');
        $this->load->model('mechanic_service_item_price_list/mdl_service_bmv_type_price_dtls');

        $this->mdl_mech_service_item_dtls->where('service_category_id', 1);
        $serviceListDetails = $this->mdl_mech_service_item_dtls->get()->result();

        if(count($serviceListDetails) > 0){
            foreach($serviceListDetails as $key => $serviceListe){
                $serviceList = $this->mdl_service_body_type_price_dtls->where('msim_id', $serviceListe->msim_id)->get()->result();
                $serviceListDetails[$key]->serviceList = $serviceList;
            }
        }

        $data = array(
            'serviceListDetails' => $serviceListDetails,
            'service_category_lists' => $service_category_lists,
        );

        $this->layout->load_view('mechanic_service_item_price_list/modal_add_services' , $data);
        
    }

    public function getServiceList(){

        $this->load->model('mech_item_master/mdl_mech_service_master');
        $response = $this->mdl_mech_service_master->getServiceItemList();

        echo json_encode($response);
        exit();
    }

    public function getServiceDetails(){
        $this->load->model('mech_item_master/mdl_mech_service_master');
        $service = $this->mdl_mech_service_master->getServiceDetails();

		if (!empty($service)){
            $response = array(
                'success' => 1,
                'services' => $service
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
        }
        echo json_encode($response);
        exit();
    }

    public function addproductmodal($existing_prod_ids = NULL, $entity_type = NULL, $entity_id = NULL , $customer_id = NULL){

        $limit = 15;
        $query = $this->mdl_mech_item_master->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
		$createLinks = $pagination->createLinks();
		$this->mdl_mech_item_master->limit($limit);
		$products = $this->mdl_mech_item_master->get()->result();
		
		if(count($products) > 0){
			foreach($products as $key => $pro){
				if($pro->apply_for_all_bmv != "Y"){
					$subproducts = $this->mdl_mech_item_master->getProductBrandDetails($pro->product_id);
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

        if($entity_type == 'I'){
            $product_list = $this->mdl_mech_invoice->get_user_quote_product_item($entity_id, $customer_id);
        }else if($entity_type == 'SI'){
            $product_list = $this->mdl_spare_invoice->get_user_quote_product_item($entity_id, $customer_id);
        }else if($entity_type == 'J'){
            $product_list = $this->mdl_mech_work_order_dtls->get_user_quote_product_item($entity_id, $customer_id);
        }else if($entity_type == 'P'){
            $product_list = $this->mdl_mech_purchase->get_purchase_product_item($entity_id);
         }else if($entity_type == 'PO'){
            $product_list = $this->mdl_mech_invoice->get_user_quote_product_item($entity_id, $customer_id);
        }else if($entity_type == 'Q'){
            $product_list = $this->mdl_mech_quotes->get_user_quote_product_item($entity_id, $customer_id);
        }else if($entity_type == 'SQ'){
            $product_list = $this->mdl_spare_quotes->get_user_quote_product_item($entity_id, $customer_id);
        }else if($entity_type == 'L'){
            $this->load->model('mech_leads/mdl_mech_leads');
            $product_list = $this->mdl_mech_leads->get_user_quote_product_item($entity_id, $customer_id);
        }else if($entity_type == 'A'){
            $this->load->model('mech_appointments/mdl_mech_leads');
            $product_list = $this->mdl_mech_leads->get_user_quote_product_item($entity_id, $customer_id);
        }

        $data = array(
            'entity_type' => $entity_type,
            'entity_id' => $entity_id,
            'customer_id' => $customer_id,
            'products' => $products,
            'product_list' => json_decode($product_list),
            'families' => $this->mdl_families->get()->result(),
            'product_brand' => $this->mdl_vendor_product_brand->get()->result(),
            'car_brand_list' => $this->mdl_mech_car_brand_details->get()->result(),
            'car_model_list' => $this->mdl_mech_car_brand_models_details->get()->result(),
            'car_variant_list' => $this->db->get_where('mech_brand_model_variants', array('status' => 1))->result(),
            'createLinks' => $createLinks,
            'existing_prod_ids' => $existing_prod_ids,
        );

        $this->layout->load_view('mech_item_master/modal_add_product', $data);
    }

    public function addservicemodal($existing_service_ids = NULL, $entity_type = NULL, $entity_id = NULL, $customer_id = NULL){
      
        $limit = 15;
        $query = $this->mdl_mech_service_master->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );

        $pagination = new Pagination($pagConfig);
		$createLinks = $pagination->createLinks();
		$this->mdl_mech_service_master->limit($limit);
		$services = $this->mdl_mech_service_master->get()->result();

        if(count($services) > 0){
			foreach($services as $key => $pro){
				if($pro->apply_for_all_bmv == "N"){
					$subproducts = $this->mdl_mech_service_master->getServiceBrandDetails($pro->msim_id);
					if(count($subproducts) > 0){
						$services[$key]->subproducts = $subproducts;
					}else{
						$services[$key]->subproducts = array();
					}
					$services[$key]->service_body_type_details = array();
				}else if($pro->apply_for_all_bmv == "S"){
					$subproducts = $this->mdl_service_body_type_price_dtls->where('msim_id' , $pro->msim_id)->get()->result();
					if(count($subproducts) > 0){
						$services[$key]->service_body_type_details = $subproducts;
					}else{
						$services[$key]->service_body_type_details = array();
					}
					$services[$key]->subproducts = array();
				}else{
					$services[$key]->subproducts = array();
					$services[$key]->service_body_type_details = array();
				}
			}
		}

        
        if($entity_type == 'SP'){
            $service_lists = $this->mdl_service_package->service_item_list($entity_id);
        }else if($entity_type == 'I'){
            $service_lists = $this->mdl_mech_invoice->get_user_quote_service_item($entity_id);
        }else if($entity_type == 'J'){
            $service_lists = $this->mdl_mech_work_order_dtls->get_user_quote_service_item($entity_id);
        }else if($entity_type == 'Q'){
            $service_lists = $this->mdl_mech_quotes->get_user_quote_service_item($entity_id, $customer_id);
        }else if($entity_type == 'L'){
            $this->load->model('mech_leads/mdl_mech_leads');
            $service_lists = $this->mdl_mech_leads->get_user_quote_service_item($entity_id, $customer_id);
        }else if($entity_type == 'A'){
            $this->load->model('mech_appointments/mdl_mech_leads');
            $service_lists = $this->mdl_mech_leads->get_user_quote_service_item($entity_id, $customer_id);
        }

        if($entity_type != 'SP'){
            $service_list = json_decode($service_lists);
        }else{
            $service_list = $service_lists;
        }   
        
        $data = array(
            'services' => $services,
            'service_cat' => $this->mdl_mechanic_service_category_list->get()->result(),
            'createLinks' => $createLinks,
            'existing_service_ids' => $existing_service_ids,
            'entity_type' =>$entity_type,
            'entity_id' => $entity_id,
            'service_list' => $service_list,
        );

        $this->layout->load_view('mech_item_master/modal_add_service', $data);
    }

}
