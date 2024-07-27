<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;
	
    public function create()
    {
        $this->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls');
        $this->load->model('mechanic_service_item_price_list/mdl_service_body_type_price_dtls');
        $this->load->model('mechanic_service_item_price_list/mdl_service_bmv_type_price_dtls');
        $serviceCostPriceList = json_decode($this->input->post('serviceCostPriceList'));
		$productCostPriceList = json_decode($this->input->post('productCostPriceList'));
        $action_from = ($this->input->post('action_from'))?$this->input->post('action_from'):'';
        $msim_id = $this->input->post('msim_id');
        $btn_submit = $this->input->post('btn_submit');
        
        $data = array();
        if(count($serviceCostPriceList) <= 0){
            $data['one'] = "serviceCostPriceList";
        }
        if(count($productCostPriceList) <= 0){
            $data['two'] = "productCostPriceList";
        }

        if(count($data) > 1){
            $response = array(
                'success' => 2,
                'validation_errors' => array(
                    'msg' => 'error',
                )
            );
            echo json_encode($response);
            exit;
        }

        if($this->mdl_mech_service_item_dtls->run_validation()){
            $msim_id = $this->mdl_mech_service_item_dtls->save($msim_id);
            if($this->session->userdata('service_cost_setup') == 1){
               if(count($serviceCostPriceList) > 0){
                   foreach($serviceCostPriceList as $service){
                        if(!empty($service->mvt_id)){
                            $service_array = array(
                                'msim_id' => $msim_id,
                                'mvt_id' => $service->mvt_id,
                                'vehicle_type_value' => $service->vehicle_type_value,
                                'default_cost' => $service->default_cost,
                                'estimated_hour' => $service->estimated_hour,
                                'estimated_cost' => $service->estimated_cost,
                            );
                            if(!empty($service->sct_id)){
                                $service_array['modified_by'] = $this->session->userdata('user_id');
                                $this->db->where('sct_id', $service->sct_id);
                                $service_id = $this->db->update('service_body_type_price_dtls', $service_array);
                            }else{
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
            }else if($this->session->userdata('service_cost_setup') == 2){
                if(count($productCostPriceList) > 0){
                    foreach ($productCostPriceList as $product) {
                        if(!empty($product->brand_id)){
                            $product_array = array(
                                'msim_id' =>$msim_id,
                                'brand_id' => $product->brand_id,
                                'model_id' => $product->model_id,
                                'variant_id' => $product->variant_id,
                                'fuel_type' => $product->fuel_type,
                                'estimated_hour' => $product->estimated_hour?$product->estimated_hour:0,
                                'estimated_cost' => $product->estimated_cost?$product->estimated_cost:0,
                            );
                            if(!empty($product->pct_id)){
                                $product_array['modified_by'] = $this->session->userdata('user_id');
                                $this->db->where('pct_id', $product->pct_id);
                                $product_id = $this->db->update('service_bmv_type_price_dtls', $product_array);
                            }else{
                                $product_array['created_on'] = date('Y-m-d H:i:s');
                                $product_array['created_by'] = $this->session->userdata('user_id');
                                $product_array['modified_by'] = $this->session->userdata('user_id');
                                $product_array['workshop_id'] = $this->session->userdata('work_shop_id');
                                $product_array['w_branch_id'] = $this->session->userdata('branch_id');
                                $product_id = $this->db->insert('service_bmv_type_price_dtls', $product_array);
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
            }

            $response = array(
                'success' => 1,
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


    public function get_filter_list(){
        $this->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls');
        $this->load->model('mechanic_service_item_price_list/mdl_service_bmv_type_price_dtls');
        
        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;
        if($this->input->post('service_item_name')){
            $this->mdl_mech_service_item_dtls->like('mech_service_item_dtls.service_item_name', trim($this->input->post('service_item_name')));
        }
        if($this->input->post('service_category_id')){
            $this->mdl_mech_service_item_dtls->where('mech_service_item_dtls.service_category_id', trim($this->input->post('service_category_id')));
        }

        $rowCount = $this->mdl_mech_service_item_dtls->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        
        if($this->input->post('service_item_name')){
            $this->mdl_mech_service_item_dtls->like('mech_service_item_dtls.service_item_name', trim($this->input->post('service_item_name')));
        }
        if($this->input->post('service_category_id')){
            $this->mdl_mech_service_item_dtls->where('mech_service_item_dtls.service_category_id', trim($this->input->post('service_category_id')));
        }

        $this->mdl_mech_service_item_dtls->limit($limit,$start);
        $mech_service_item_dtls = $this->mdl_mech_service_item_dtls->get()->result();
        if(count($mech_service_item_dtls) > 0){
            foreach($mech_service_item_dtls as $key => $serviceList){
                if($serviceList->service_cost_setup == 2 && $this->session->userdata('service_cost_setup') == 2){
                    $sbmv = $this->mdl_service_bmv_type_price_dtls->where('service_bmv_type_price_dtls.msim_id' , $serviceList->msim_id )->get()->result();
                    if(count($sbmv) > 0){
                        $mech_service_item_dtls[$key]->sbmv = $sbmv;
                    }else{
                        $mech_service_item_dtls[$key]->sbmv = array();
                    }
                }else{
                    $mech_service_item_dtls[$key]->sbmv = array();
                }
            }
        } 
        $response = array(
            'success' => 1,
            'mech_service_item_dtls' => $mech_service_item_dtls, 
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

        $this->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls');
        $response = $this->mdl_mech_service_item_dtls->getServiceItemList();

        echo json_encode($response);
        exit();
    }

    public function getServiceDetails(){
        $this->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls');
        $service = $this->mdl_mech_service_item_dtls->getServiceDetails();

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
}