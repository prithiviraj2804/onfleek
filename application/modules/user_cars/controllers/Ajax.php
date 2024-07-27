<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_cars/mdl_user_cars');
        $this->load->model('mechanic_service_category_items/mdl_mechanic_service_category_items'); 
        $this->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls');
        $this->load->model('mech_item_master/mdl_mech_item_master');
        $this->load->model('products/mdl_products');
        $this->load->model('clients/mdl_clients');
        $this->load->model('mech_vehicle_type/mdl_mech_vehicle_type');
         
    }
    
    public function save()
    {
    	$this->load->model('user_cars/mdl_user_cars');
        $car_list_id = $this->input->post('user_car_id');
          
		$db_array = array(
            'total_mileage' => $this->input->post('total_mileage'),
            'daily_mileage' => $this->input->post('daily_mileage'),
        );
				
        $this->mdl_user_cars->save($car_list_id, $db_array);
        $response = array(
            'success' => 1,
            'car_list_id' => $car_list_id,
        );

		echo json_encode($response);	
    } 

    public function create()
    {
        $this->load->model('user_cars/mdl_user_cars');
        
            $car_id = $this->input->post('car_id');
            $car_brand_id = $this->input->post('car_brand_id');
            $car_brand_model_id = $this->input->post('car_brand_model_id');
            $car_variant = $this->input->post('car_variant');

            $model_txt = $this->input->post('model_txt');
            $variant_txt = $this->input->post('variant_txt');
            
            if($this->input->post('is_model_text') == 'Y'){
                $data = array(
                    'brand_id' => $car_brand_id,
                    'model_name' => $model_txt,
                    'created_on' => date('Y-m-d H:m:s'),
                );
                    $check = $this->db->select('model_name')->from('mech_car_brand_models_details')->where('brand_id',$car_brand_id)->where('model_name',$model_txt)->get()->result();   
                    if (!empty($check)) {
                        $response = array(
                            'success' => 2,
                        );
                        echo json_encode($response);
                        exit();
                    }
                    $this->db->insert('mech_car_brand_models_details',$data);
                    $car_brand_model_id = $this->db->insert_id(); 
            }

            if($car_brand_model_id){
                if($this->input->post('is_variant_text') == 'Y'){
                    $variantdata = array(
                        'brand_id' => $car_brand_id,
                        'model_id' => $car_brand_model_id,
                        'variant_name' => $variant_txt,
                        'created_on' => date('Y-m-d H:m:s'),
                    );
                    $check = $this->db->select('variant_name')->from('mech_brand_model_variants')->where('brand_id',$car_brand_id)->where('model_id',$car_brand_model_id)->where('variant_name',$variant_txt)->get()->result();   
                    if (!empty($check)) {
                        $response = array(
                            'success' => 3,
                        );
                        echo json_encode($response);
                        exit();
                    }
                    $this->db->insert('mech_brand_model_variants',$variantdata);
                    $car_variant = $this->db->insert_id(); 
                }
            }
            $_POST['car_brand_model_id'] = $car_brand_model_id;
            $_POST['car_variant'] = $car_variant;

            if ($this->mdl_user_cars->run_validation()) {
                if($car_id){
                    $check = $this->db->select('car_reg_no')->from('mech_owner_car_list')->where('car_reg_no',$this->input->post('car_reg_no'))->where('status !=','2')->where_not_in('car_list_id',$car_id)->where_in('workshop_id',array(1,$this->session->userdata('work_shop_id')))->where_in('w_branch_id',array(1,$this->session->userdata('branch_id')))->get()->result();   
                    if (!empty($check)) {
                        $response = array(
                            'success' => 4,
                        );
                        echo json_encode($response);
                        exit();
                    }
                }else{
                $check = $this->db->select('car_reg_no')->from('mech_owner_car_list')->where('car_reg_no',$this->input->post('car_reg_no'))->where('status !=','2')->where_in('workshop_id',array(1,$this->session->userdata('work_shop_id')))->where_in('w_branch_id',array(1,$this->session->userdata('branch_id')))->get()->result();   
                if (!empty($check)) {
                    $response = array(
                        'success' => 4,
                    );
                    echo json_encode($response);
                    exit();
                }
            }    
            $user_car_id = $this->mdl_user_cars->save($car_id);
            $this->db->select('owner_id');
            $this->db->where('car_list_id', $user_car_id);
            $this->db->from('mech_owner_car_list');
            $owner_id = $this->db->get()->row()->owner_id;

            if(!empty($owner_id)){
                $customerCars = $this->get_customer_cars($owner_id);
            }else{
                $customerCars = array();
            }

            $this->db->select('cl.car_list_id,cl.car_model_year,cb.brand_name,cm.model_name,cv.variant_name,cl.car_reg_no');
            $this->db->from('mech_owner_car_list cl');
            $this->db->join('mech_car_brand_details cb', 'cb.brand_id=cl.car_brand_id', 'left');
            $this->db->join('mech_car_brand_models_details cm', 'cm.model_id=cl.car_brand_model_id', 'left');
            $this->db->join('mech_brand_model_variants cv', 'cv.brand_model_variant_id=cl.car_variant', 'left');
            $this->db->where('cl.car_list_id', $user_car_id);
            $query = $this->db->get();

            if ($query->num_rows() != 0) {
                $result = $query->result_array();
            } else {
                $result = array();
            }

            $response = array(
                'success' => 1,
                'user_car_details' => $result,
                'customerCars' => $customerCars,
            );

        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors(),
            );

        }

        echo json_encode($response);
    } 

	public function update_car_details()
    {
    	$this->load->model('user_cars/mdl_user_cars');
  		$car_list_id = $this->input->post('user_car_id');
		$db_array = array(
            'total_mileage' => $this->input->post('total_mileage'),
            'daily_mileage' => $this->input->post('daily_mileage'),
            'vin' => $this->input->post('vin'),
            'engine_oil_type' => $this->input->post('engine_oil_type'),
            'steering_type' => $this->input->post('steering_type'),
            'air_conditioning' => $this->input->post('air_conditioning'),
            'car_drive_type' => $this->input->post('car_drive_type'),
            'transmission_type' => $this->input->post('transmission_type'),
            'fuel_type' => $this->input->post('fuel_type')
        );
				
		$this->mdl_user_cars->save($car_list_id, $db_array);
		$response = array(
            'success' => 1
        );
		echo json_encode($response);	
    } 

    public function modal_add_car($customer_id, $model_from = NULL, $car_id = NULL, $entity_type = NULL)
    {
    	if($car_id){
    		$this->db->select('cl.*');
            $this->db->from('mech_owner_car_list cl');
            $this->db->where('cl.car_list_id', $car_id);
            $car_detail = $this->db->get()->row();
            $model_list = $this->db->get_where('mech_car_brand_models_details', array('status' => 1, 'brand_id' => $car_detail->car_brand_id))->result();
            $variant_list = $this->db->get_where('mech_brand_model_variants', array('status' => 1, 'brand_id' => $car_detail->car_brand_id, 'model_id' => $car_detail->car_brand_model_id))->result();
        } else {
            $car_detail = '';
            $model_list = array();
            $variant_list = array();
        }
        
        $model_type = $this->mdl_mech_vehicle_type->get()->result();
        $data = array(
            'model_type' => $model_type,
            'model_from' => $model_from,
            'entity_type' => $entity_type,
            'customer_id' => $customer_id,
            'car_id' => $car_id,
            'car_detail' => $car_detail,
            'car_brand_list' => $this->db->get_where('mech_car_brand_details', array('status' => 1))->result(),
            'car_model_list' => $model_list,
            'car_variant_list' => $variant_list,
        );

        $this->layout->load_view('user_cars/modal_add_car', $data);
    }

    public function modal_add_recommended_products($model_from = NULL,$invoice_id = NULL,$customer_id = NULL,$vehicle_id = NULL){

        $recommended_products = $this->mdl_user_cars->getRecommendedProducthistory($invoice_id);
        if(count($recommended_products) > 0){
            $recommended_products = $recommended_products;
        }else{
            $recommended_products = array();
        }

        $this->mdl_mech_item_master->where_in('mech_products.is_parent', ['N' ,'P']);
        $products = $this->mdl_mech_item_master->get()->result();

        $data = array(
            'model_from' => $model_from,
            'invoice_id' => $invoice_id,
            'customer_id' => $customer_id,
            'vehicle_id' => $vehicle_id,
            'recommended_products' => $recommended_products,
            'product_category_items' => $products,
        );
        $this->layout->load_view('user_cars/modal_add_recommended_products', $data);
    }

    public function modal_add_recommended_services($model_from = NULL,$invoice_id = NULL,$customer_id = NULL,$vehicle_id = NULL){

        $recommended_services = $this->mdl_user_cars->getRecommendedServicehistory($invoice_id);
        if(count($recommended_services) > 0){
            $recommended_services = $recommended_services;
        }else{
            $recommended_services = array();
        }
        $data = array(
            'model_from' => $model_from,
            'invoice_id' => $invoice_id,
            'customer_id' => $customer_id,
            'vehicle_id' => $vehicle_id,
            'recommended_services' => $recommended_services,
            'service_category_items' => $this->mdl_mech_service_item_dtls->get()->result(),
        );
        $this->layout->load_view('user_cars/modal_add_recommended_services', $data);

    }

    public function getRecommendedProducts(){

        $recomended_id = $this->input->post('recommended_id');
        if($recomended_id){
            $recommendedProduct = $this->mdl_user_cars->getRecommendedProduct($recomended_id);
        }else{
            $recommendedProduct = array();
        }
        $response = array(
            'success' => '1',
            'recommendedProduct' => $recommendedProduct,
            'product_category_items' =>$this->mdl_mech_item_master->where('product_type','P')->get()->result(),
            'recomended_products' => $this->mdl_user_cars->getRecommendedProducthistory($this->input->post('invoice_id')),
        );
        echo json_encode($response);

    }

    public function save_recommended_service(){

        $recomended_id = $this->mdl_user_cars->saveRecommendedServiceHistory($_REQUEST);
        if($recomended_id){
            $response = array(
                'success' => 1,
                'recomended_services' => $this->mdl_user_cars->getRecommendedServicehistory($this->input->post('invoice_id')),
            );
        }else{
            $response = array(
                'success' => 0,
                'recomended_services' => array(),
            );
        }
        echo json_encode($response);
        exit();

    }

    public function save_recommended_product(){

        $recomended_id = $this->mdl_user_cars->saveRecommendedProductHistory($_REQUEST);
        if($recomended_id){
            $response = array(
                'success' => 1,
                'recomended_products' => $this->mdl_user_cars->getRecommendedProducthistory($this->input->post('invoice_id')),
            );
        }else{
            $response = array(
                'success' => 0,
                'recomended_products' => array(),
            );
        }
        echo json_encode($response);
        exit();

    }

    public function getRecommendedService(){

        $recomended_id = $this->input->post('recommended_id');
        if($recomended_id){
            $recommendedService = $this->mdl_user_cars->getRecommendedService($recomended_id);
        }else{
            $recommendedService = array();
        }
        $response = array(
            'success' => '1',
            'recommendedService' => $recommendedService,
            'service_category_items' => $this->mdl_mech_service_item_dtls->get()->result(),
            'recomended_services' => $this->mdl_user_cars->getRecommendedServicehistory($this->input->post('invoice_id')),
        );
        echo json_encode($response);

    }

    public function get_recommended_product_list(){

        $recomended_products = $this->mdl_user_cars->getRecommendedProducthistory($this->input->post('invoice_id'));
        
        if(empty($recomended_products)){
            $recomended_products = array();
        }

        $response = array(
            'success' => '1',
            'recomended_products' => $recomended_products,
        );
        echo json_encode($response);
        exit();
    }

    public function get_recommended_service_list(){

        $recomended_services = $this->mdl_user_cars->getRecommendedServicehistory($this->input->post('invoice_id'));
        
        if(empty($recomended_services)){
            $recomended_services = array();
        }

        $response = array(
            'success' => '1',
            'recomended_services' => $recomended_services,
        );
        echo json_encode($response);
        exit();
    }

    public function delete_recommended_product(){
        
        if($this->input->post('recommended_id')){
            $recommendedProduct = $this->mdl_user_cars->deleteRecommendedProduct($this->input->post('recommended_id'));
        }else{
            $recommendedProduct = '';
        }
        $response = array(
            'success' => '1',
            'recommendedProduct' => $recommendedProduct,
            'recomended_products' => $this->mdl_user_cars->getRecommendedProducthistory($this->input->post('invoice_id')),
        );
        echo json_encode($response);

    }

    public function delete_recommended_service(){
        
        if($this->input->post('recommended_id')){
            $recommendedService = $this->mdl_user_cars->deleteRecommendedService($this->input->post('recommended_id'));
        }else{
            $recommendedService = '';
        }
        $response = array(
            'success' => '1',
            'recommendedService' => $recommendedService,
            'recomended_services' => $this->mdl_user_cars->getRecommendedServicehistory($this->input->post('invoice_id')),
        );
        echo json_encode($response);

    }

    public function get_brand_models()
    {
        $brand_id = $this->input->post('brand_id');
        $models_list = $this->db->get_where('mech_car_brand_models_details', array('status' => 1, 'brand_id' => $brand_id))->result();
        echo json_encode($models_list);
    }

    public function get_brand_model_variant()
    {
        $brand_id = $this->input->post('brand_id');
        $model_id = $this->input->post('model_id');
        $variants_list = $this->db->get_where('mech_brand_model_variants', array('status' => 1, 'brand_id' => $brand_id, 'model_id' => $model_id))->result();
        echo json_encode($variants_list);
    }

    public function delete_car_details()
    {
        return 'Delete';
    }

    public function get_customer_cars($cus_id = null)
    {
        if ($cus_id) {
            $customer_id = $cus_id;
        } else {
            $customer_id = $this->input->post('customer_id');
        }

        $this->db->select('*');
        $this->db->from('mech_owner_car_list');
        $this->db->join('mech_car_brand_details cb', 'cb.brand_id=mech_owner_car_list.car_brand_id', 'left');
        $this->db->join('mech_car_brand_models_details cm', 'cm.model_id=mech_owner_car_list.car_brand_model_id', 'left');
        $this->db->join('mech_brand_model_variants cv', 'cv.brand_model_variant_id=mech_owner_car_list.car_variant', 'left');
        $this->db->where('owner_id', $customer_id);
        $this->db->where('mech_owner_car_list.status', 1);
        $result = $this->db->get()->result();

        if (empty($cus_id) || $cus_id = '') {
            echo json_encode($result);
        } else {
            return $result;
        }
    }

    public function getCustomerCarsByName(){

        $client_name = explode("(", $this->input->post('customer_name'), 2);
        $clientName = $client_name[0];
        preg_match('#\((.*?)\)#', $this->input->post('customer_name'), $mobile_number);

        if($clientName){
            
            $this->mdl_clients->where('client_name',$clientName);
            if($mobile_number[1]){
                $this->mdl_clients->where_like('lient_contact_no', preg_replace('/\s+/', '', $mobile_number[1]));
            }
            $check = $this->mdl_clients->get()->result();

            $this->db->select('*');
            $this->db->from('mech_owner_car_list');
            $this->db->join('mech_car_brand_details cb', 'cb.brand_id=mech_owner_car_list.car_brand_id', 'left');
            $this->db->join('mech_car_brand_models_details cm', 'cm.model_id=mech_owner_car_list.car_brand_model_id', 'left');
            $this->db->join('mech_brand_model_variants cv', 'cv.brand_model_variant_id=mech_owner_car_list.car_variant', 'left');
            $this->db->where('owner_id', $check[0]->client_id);
            $this->db->where('mech_owner_car_list.status', 1);
            $user_cars = $this->db->get()->result();
            foreach ($user_cars as $user_cars_key => $userCars) {
                $model_list = $this->db->get_where('mech_car_brand_models_details', array('status' => 1, 'brand_id' => $userCars->car_brand_id))->result();
                $user_cars[$user_cars_key]->model_list = $model_list;
            }

            $response = array(
                'success' => 1,
                'user_cars' => $user_cars,
            );
        }else{
            $response = array(
                'success' => 0,
                'user_cars' => array(),
            );
        }

        echo json_encode($response);
        
    }
}