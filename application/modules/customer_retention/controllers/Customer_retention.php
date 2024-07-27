<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customer_retention extends Admin_Controller
{
  
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_customer_retention');
        $this->load->model('mdl_customer_retention_services');
        $this->load->model('clients/mdl_clients');
        $this->load->model('mech_invoices/mdl_mech_invoice');
        $this->load->model('mech_item_master/mdl_mech_item_master');
        $this->load->model('products/mdl_products');
        $this->load->model('user_cars/mdl_user_cars');
        $this->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls'); 
    }

    public function index($page = 0)
    {
        $limit = 15;
        if($this->input->post('expiry_from_date') && $this->input->post('expiry_to_date')){
            if($this->input->post('type') == "S"){
                $query = $this->mdl_customer_retention_services->get();
                $rowCount = $query->num_rows();
                $pagConfig = array(
                    'totalRows' => $rowCount,
                    'perPage' => $limit,
                    'link_func' => 'searchFilter'
                );
                $pagination = new Pagination($pagConfig);
                $createLinks = $pagination->createLinks();
                $this->mdl_customer_retention_services->limit($limit);
                $item_list = $this->mdl_customer_retention_services->get()->result();
            }else{
               
                $query = $this->mdl_customer_retention->get();
                $rowCount = $query->num_rows();
                $pagConfig = array(
                    'totalRows' => $rowCount,
                    'perPage' => $limit,
                    'link_func' => 'searchFilter'
                );
                $pagination = new Pagination($pagConfig);
                $createLinks = $pagination->createLinks();
                $this->mdl_customer_retention->limit($limit);
                $item_list = $this->mdl_customer_retention->get()->result();
            }
        }else{
            $item_list = array();
        }
        
        $this->layout->set(
            array(
                'list' => $item_list,
                'product_category_items' =>$this->mdl_mech_item_master->where('product_type','P')->get()->result(),
                'service_category_items'=>$this->mdl_mech_service_item_dtls->get()->result(),
                'createLinks' => $createLinks,
            )
        );
        $this->layout->buffer('content', 'customer_retention/index');
        $this->layout->render();
    }

    public function view($customer_id = NULL, $customer_car_id = NULL , $from_date = NULL , $to_date = NULL , $kilometer = NULL, $type = NULL){

        if($type == "S"){
            if($from_date && $to_date){
                $this->mdl_customer_retention_services->where("recommended_services.expiry_date BETWEEN '".$from_date."' and '".$to_date."'");
            }
            if($expiry_kilometer){
                $this->mdl_customer_retention_services->where("recommended_services.expiry_kilometer = '".trim($kilometer)."'");
            }
            $item_list = $this->mdl_customer_retention_services->get()->result();
        }else{
            if($from_date && $to_date){
                $this->mdl_customer_retention->where("mech_invoice_item.expiry_date BETWEEN '".$from_date."' and '".$to_date."'");
            }
            if($expiry_kilometer){
                $this->mdl_customer_retention->where("mech_invoice_item.expiry_kilometer = '".trim($kilometer)."'");
            }
            $item_list = $this->mdl_customer_retention->get()->result();
        }

        $this->layout->set(
            array(
                'list' => $item_list,
                'kilometer' => $kilometer,
                'from_date' => $from_date,
                'to_date' => $to_date,
                'customer_id' => $customer_id,
                'customer_car_id' => $customer_car_id,
                'type' => $type
            )
        );
        $this->layout->buffer('content', 'customer_retention/view');
        $this->layout->render();
    }
}