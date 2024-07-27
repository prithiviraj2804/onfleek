<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('clients/mdl_clients');
        $this->load->model('customer_retention/mdl_customer_retention');
        $this->load->model('customer_retention/mdl_customer_retention_services');
        $this->load->model('workshop_branch/mdl_workshop_branch');
        
    }

    public function getCustomerRetentionList(){

        if($this->input->post('type') == "S"){
            $invoices = $this->mdl_customer_retention_services->getCustomerRetentionlist();
        }else{
            $invoices = $this->mdl_customer_retention->getCustomerRetentionlist();
        }

        $company_details = $this->mdl_workshop_branch->get_company_branch_details();

        if(count($invoices) > 0){
            $response = array(
                'success' => 1,
                'invoices' => $invoices,
                'company_details' => $company_details
            );
        }else{
            $response = array(
                'success' => 0,
                'invoices' => array(),
                'company_details' => array(),
            );
        }

        echo json_encode($response);
        exit();
        
    }

    public function create_lead(){
        
        $lead_array = array(
            'workshop_id' => $this->session->userdata('work_shop_id'),
            'w_branch_id' => $this->session->userdata('branch_id'),
            'lead_date' => date('Y-m-d'),
            'reschedule_date' => date('Y-m-d'),
            'category_type' => 'L',
            'customer_id' =>  $this->input->post('customer_id'),
            'user_car_list_id' => $this->input->post('customer_car_id'),
            'lead_status' => 1,
            'created_by' => $this->session->userdata('user_id'),
            'modified_by' => $this->session->userdata('user_id'),
            'created_on' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('mech_leads', $lead_array);
        $ml_id = $this->db->insert_id();
        
        $recommended_ids = $this->input->post('recommended_ids');

        if(count($recommended_ids) > 0){
            $recommended_services_ids = array();
            $recommended_products_ids = array();
            for($i = 0; $i < count($recommended_ids); $i++){
                $this->db->select('recommended_service,category_type');
                $this->db->where('recommended_id',$recommended_ids[$i]);
                $this->db->from('recommended_services');
                $recommended_service = $this->db->get()->row();
                if($recommended_service->category_type == "S"){
                    array_push($recommended_services_ids,$recommended_service->recommended_service);
                }else if($recommended_service->category_type == "P"){
                    array_push($recommended_products_ids,$recommended_service->recommended_service);
                }
                $this->db->where('recommended_id', $recommended_ids[$i]);
		        $this->db->update('recommended_services', array('status'=>'D'));
            }

            //Recommended Products

            $product_result = array();
            for($i = 0; $i < count($recommended_products_ids); $i++){
                if (!in_array($recommended_products_ids[$i], $product_result, TRUE)) 
                { 
                    array_push($product_result,$recommended_products_ids[$i]);
                }
            }

            $recommed_product_items = array();
            if(count($product_result)>0){
                for($i = 0; $i < count($product_result); $i++){
                    $this->db->select('*');
                    $this->db->where('product_id',$product_result[$i]);
                    $this->db->from('mech_products');
                    $recommended_product = $this->db->get()->row();
                    array_push($recommed_product_items,$recommended_product);
                }
            }

            if(count($recommed_product_items)>0){
                foreach ($recommed_product_items as $product) {
                    $product_array = array(
                        'ml_id' => $ml_id,
                        'is_from' => 'lead_product',
                        'service_item' => $product->product_id,
                        'item_service_name' => $product->product_name?$product->product_name:NULL,
                        'user_item_price' => $product->sale_price?$product->sale_price:NULL,
                        'mech_item_price' => $product->cost_price?$product->cost_price:NULL,
                        'item_amount' => $product->sale_price?$product->sale_price:NULL,
                        'item_total_amount' => $product->sale_price?$product->sale_price:NULL,
                        'created_on' => date('Y-m-d H:i:s'),
                        'created_by' => $this->session->userdata('user_id'),
                        'modified_by' => $this->session->userdata('user_id'),
                        'workshop_id' => $this->session->userdata('work_shop_id'),
                        'w_branch_id' => $this->session->userdata('branch_id')
                    );
                    $product_id = $this->db->insert('mech_leads_items', $product_array);
                }
            } 

            // Recommended Services

            $service_result = array();
            for($i = 0; $i < count($recommended_services_ids); $i++){
                if (!in_array($recommended_services_ids[$i], $service_result, TRUE)) 
                { 
                    array_push($service_result,$recommended_services_ids[$i]);
                }
            }

            $recommed_service_items = array();
            if(count($service_result)>0){
                for($i = 0; $i < count($service_result); $i++){
                    $this->db->select('*');
                    $this->db->where('msim_id',$service_result[$i]);
                    $this->db->from('mech_service_item_dtls');
                    $recommended_service = $this->db->get()->row();
                    array_push($recommed_service_items,$recommended_service);
                }
            }

            if(count($recommed_service_items)>0){
                foreach ($recommed_service_items as $service) {
                    $service_array = array(
                        'ml_id' => $ml_id,
                        'is_from' => 'lead_service',
                        'service_item' => $service->sc_item_id,
                        'item_service_name' => $service->service_item_name?$service->service_item_name:NULL,
                        'created_on' => date('Y-m-d H:i:s'),
                        'created_by' => $this->session->userdata('user_id'),
                        'modified_by' => $this->session->userdata('user_id'),
                        'workshop_id' => $this->session->userdata('work_shop_id'),
                        'w_branch_id' => $this->session->userdata('branch_id')
                    );
                    $service_id = $this->db->insert('mech_leads_items', $service_array);
                }
            } 
        }

        if($ml_id){
            $response = array(
                'success' => 1,
                'ml_id' => $ml_id
            );
        }else{
            $response = array(
                'success' => 0,
                'ml_id' => ''
            );
        }
        echo json_encode($response);

    }

    public function create_appointment(){
        
        $lead_array = array(
            'workshop_id' => $this->session->userdata('work_shop_id'),
            'w_branch_id' => $this->session->userdata('branch_id'),
            'lead_date' => date('Y-m-d'),
            'reschedule_date' => date('Y-m-d'),
            'category_type' => 'A',
            'customer_id' =>  $this->input->post('customer_id'),
            'user_car_list_id' => $this->input->post('customer_car_id'),
            'lead_status' => 1,
            'created_by' => $this->session->userdata('user_id'),
            'modified_by' => $this->session->userdata('user_id'),
            'created_on' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('mech_leads', $lead_array);
        $ml_id = $this->db->insert_id();

        if($ml_id){
            $response = array(
                'success' => 1,
                'ml_id' => $ml_id
            );
        }else{
            $response = array(
                'success' => 0,
                'ml_id' => ''
            );
        }

        echo json_encode($response);
    }

    public function get_filter_list(){

        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;

        if($this->input->post('expiry_from_date') && $this->input->post('expiry_to_date')){
            if($this->input->post('type') == "S"){
                if($this->input->post('expiry_from_date')){
                    $this->mdl_customer_retention_services->where('recommended_services.expiry_date >=', date_to_mysql($this->input->post('expiry_from_date')));
                }
                if($this->input->post('expiry_to_date')){
                    $this->mdl_customer_retention_services->where('recommended_services.expiry_date <=', date_to_mysql($this->input->post('expiry_to_date')));
                }

                $rowCount = $this->mdl_customer_retention_services->get()->result();
                $rowCount = count($rowCount);
                $pagConfig = array(
                    'currentPage' => $start,
                    'totalRows' => $rowCount,
                    'perPage' => $limit,
                    'link_func' => 'searchFilter'
                );
                $pagination =  new Pagination($pagConfig);
                $createLinks = $pagination->createLinks();

                if($this->input->post('expiry_from_date')){
                    $this->mdl_customer_retention_services->where('recommended_services.expiry_date >=', date_to_mysql($this->input->post('expiry_from_date')));
                }
                if($this->input->post('expiry_to_date')){
                    $this->mdl_customer_retention_services->where('recommended_services.expiry_date <=', date_to_mysql($this->input->post('expiry_to_date')));
                }
                
                $this->mdl_customer_retention_services->limit($limit);
                $item_list = $this->mdl_customer_retention_services->get()->result();
            }else{
                if($this->input->post('expiry_from_date')){
                    $this->mdl_customer_retention_services->where('mech_invoice_item.expiry_date >=',date_to_mysql($this->input->post('expiry_from_date')));
                }
                if($this->input->post('expiry_to_date')){
                    $this->mdl_customer_retention_services->where('mech_invoice_item.expiry_date <=', date_to_mysql($this->input->post('expiry_to_date')));
                }
                if($this->input->post('expiry_kilometer')){
                    $this->mdl_customer_retention_services->where('mech_invoice_item.expiry_kilometer', $this->input->post('expiry_kilometer'));
                }

                $rowCount = $this->mdl_customer_retention->get()->result();
                $rowCount = count($rowCount);
                $pagConfig = array(
                    'currentPage' => $start,
                    'totalRows' => $rowCount,
                    'perPage' => $limit,
                    'link_func' => 'searchFilter'
                );
                $pagination =  new Pagination($pagConfig);
                $createLinks = $pagination->createLinks();

                if($this->input->post('expiry_from_date')){
                    $this->mdl_customer_retention_services->where('mech_invoice_item.expiry_date >=', date_to_mysql($this->input->post('expiry_from_date')));
                }
                if($this->input->post('expiry_to_date')){
                    $this->mdl_customer_retention_services->where('mech_invoice_item.expiry_date <=', date_to_mysql($this->input->post('expiry_to_date')));
                }
                if($this->input->post('expiry_kilometer')){
                    $this->mdl_customer_retention_services->where('mech_invoice_item.expiry_kilometer', $this->input->post('expiry_kilometer'));
                }
                
                $this->mdl_customer_retention->limit($limit);
                $item_list = $this->mdl_customer_retention->get()->result();
            }
        }else{
            $item_list = array();
        }

        $response = array(
            'success' => 1,
            'list' => $item_list, 
            'createLinks' => $createLinks,
            'work_shop_id' => $this->session->userdata('work_shop_id'),
            'user_type' => $this->session->userdata('user_type'),
            'workshop_is_enabled_inventory' => $this->session->userdata('workshop_is_enabled_inventory'),
        );
        echo json_encode($response);

    }

}