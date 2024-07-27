<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mech_Pos_Invoices extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('mech_invoice_groups/mdl_mech_invoice_groups');
		$this->load->model('mdl_mech_pos_invoice');
		$this->load->model('clients/mdl_clients');
		$this->load->model('user_quotes/mdl_user_quotes');
		$this->load->model('user_cars/mdl_user_cars'); 
		$this->load->model('users/mdl_users');
        $this->load->model('mech_item_master/mdl_mech_item_master');
        $this->load->model('products/mdl_products');   
        $this->load->model('product_brands/mdl_vendor_product_brand');
        $this->load->model('user_address/mdl_user_address');
        $this->load->model('mechanic_service_category/mdl_mechanic_service_category_list');
        $this->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls');
        $this->load->model('mechanic_service_category_items/mdl_mechanic_service_category_items'); 
        $this->load->model('families/mdl_families');     
		$this->load->model('workshop_branch/mdl_workshop_branch');  
		$this->load->model('mech_purchase/mdl_mech_purchase'); 
        $this->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls'); 
        $this->load->model('payment_methods/mdl_payment_methods'); 
        $this->load->model('workshop_branch/mdl_workshop_branch');
        $this->load->model('mechanic_service_category/mdl_mechanic_service_category_list');
        $this->load->model('service_packages/mdl_service_package');
        $this->load->model('mech_tax/mdl_mech_tax');
	}

    public function index($page = 0)
    {

        $limit = 15;
        $query = $this->mdl_mech_pos_invoice->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();
        $this->mdl_mech_pos_invoice->limit($limit);
        $invoice_list = $this->mdl_mech_pos_invoice->get()->result();

        
        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
        }else{
            $branch_list = array();
        }

        $this->layout->set(
            array(
                'invoice_list' => $invoice_list,
                'branch_list' => $branch_list,
                'customer_list' => $this->mdl_clients->where('client_active','A')->get()->result(),
                'createLinks' => $createLinks,
                'is_product' => $this->db->query("SELECT is_product FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND created_by = ".$this->session->userdata('user_id')." ")->row()->is_product,
            )
        );

        $this->layout->buffer('content', 'mech_pos_invoices/index');
        $this->layout->render();
    }

    public function create($pos_invoice_id=null)
    {
       
        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');
        
        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
        }else{
            $branch_list = array();
        }

        $user_cars = array();
        $model_list = array();

    	if(!$pos_invoice_id){
            $pos_invoice = array();
            $service_list = array();
            $service_package_list = array();
            $product_list = array();
            $customer_name = NULL;
            $user_cars = $this->db->get_where('mech_car_brand_details', array('status' => 1))->result();
            foreach ($user_cars as $user_cars_key => $userCars) {
                $model_list = $this->db->get_where('mech_car_brand_models_details', array('status' => 1, 'brand_id' => $userCars->brand_id))->result();
                $user_cars[$user_cars_key]->model_list = $model_list;
            }
            $refered_dtls = array();
        } else {
            $this->mdl_mech_pos_invoice->where('invoice_id' , $pos_invoice_id);
            $pos_invoice = $this->mdl_mech_pos_invoice->get()->row();	
            $customer_name = $this->mdl_clients->get_customer_name($pos_invoice->customer_id);
            $user_cars = $this->mdl_user_cars->get_customer_cars_list($pos_invoice->customer_id);
            foreach ($user_cars as $user_cars_key => $userCars) {
                if($userCars->car_brand_id){
                    $model_list = $this->db->get_where('mech_car_brand_models_details', array('status' => 1, 'brand_id' => $userCars->car_brand_id))->result();
                    $user_cars[$user_cars_key]->model_list = $model_list;
                }
            }
            if(empty($user_cars)){
                $user_cars = $this->db->get_where('mech_car_brand_details', array('status' => 1))->result();
                foreach ($user_cars as $user_cars_key => $userCars) {
                    $model_list = $this->db->get_where('mech_car_brand_models_details', array('status' => 1, 'brand_id' => $userCars->brand_id))->result();
                    $user_cars[$user_cars_key]->model_list = $model_list;
                }
            }
            $pos_invoice->customer_car_id = $user_cars[0]->car_brand_model_id;
	        $service_list = $this->mdl_mech_pos_invoice->get_user_quote_service_item($pos_invoice_id, $pos_invoice->customer_id);
            $service_ids = $this->mdl_mech_pos_invoice->get_user_quote_service_ids($invoice_id, $invoice->customer_id);            
            $service_package_list = $this->mdl_mech_pos_invoice->get_user_quote_service_package_item($pos_invoice_id, $pos_invoice->customer_id);
            $product_list = $this->mdl_mech_pos_invoice->get_user_quote_product_item($pos_invoice_id, $pos_invoice->customer_id);
	        $product_ids = $this->mdl_mech_pos_invoice->get_user_quote_product_ids($invoice_id, $invoice->customer_id);
            if($pos_invoice->refered_by_type == 2){
                $refered_dtls = $this->db->get_where('mech_employee', array('mech_employee.employee_status' => 1, 'mech_employee.workshop_id' => $this->session->userdata('work_shop_id')))->result();
            }else if($pos_invoice->refered_by_type == 1){
                $refered_dtls = $this->mdl_clients->where('client_active','A')->get()->result();
            }else{
                $refered_dtls = array();
            }

        }
    
        $this->layout->set(array(
            'reference_type' => $this->db->get_where('mech_reference_dtls', array('status' => 1))->result(),
            'refered_dtls' => $refered_dtls,
            'is_shift' => ($this->db->query("SELECT shift FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." ")->row()->shift),
            'shift_list'=> $this->db->query('SELECT shift_id,shift_name FROM mech_shift')->result(),
            'is_product' => $this->db->query("SELECT is_product FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND created_by = ".$this->session->userdata('user_id')." ")->row()->is_product,
            'pos_invoice_id' => $pos_invoice_id,
            'invoice_detail' => $pos_invoice,
            'customer_name' => $customer_name,
            'branch_list' => $branch_list,
            'invoice_group' => $this->mdl_mech_invoice_groups->where('module_type','invoice')->where('status' , 'A')->where('workshop_id' , $work_shop_id)->get()->result(),
            'service_list' => $service_list,
            'service_package_list' => $service_package_list,
            'product_list' => $product_list,
            'product_brand' => $this->mdl_vendor_product_brand->get()->result(),
            'payment_methods' => $this->mdl_payment_methods->get()->result(),
            'user_cars' => $user_cars,
            'product_category_items' =>$this->mdl_mech_item_master->where('apply_for_all_bmv' , 'Y')->get()->result(),
            'service_category_lists' => $this->mdl_mechanic_service_category_list->get()->result(),
            'families' => $this->mdl_families->get()->result(),
            'employee_list' => $this->db->get_where('mech_reference_dtls', array('status' => 1))->result(),
            'service_category_items' => $this->mdl_mech_service_item_dtls->get()->result(),
            'bank_dtls' => $this->db->get_where('mech_workshop_bank_list', array('module_type' =>'B', 'w_branch_id'=>$branch_id, 'bank_status' => 'A'))->result(),
            'service_package' => $this->mdl_service_package->get()->result(),
            'gst_spare' => $this->mdl_mech_tax->where('tax_type','G')->where_in('workshop_id', array('1', $this->session->userdata('work_shop_id')))->get()->result(),
            'gst_service' => $this->mdl_mech_tax->where('tax_type','S')->where_in('workshop_id', array('1', $this->session->userdata('work_shop_id')))->get()->result(),
        )); 
		
        $this->layout->buffer('content', 'mech_pos_invoices/create');
        $this->layout->render();
    }
	
    public function view($pos_invoice_id)
    {
		if(!$pos_invoice_id){
            exit();
        }
           
        $this->mdl_mech_pos_invoice->where('invoice_id' , $pos_invoice_id);
        $pos_invoice = $this->mdl_mech_pos_invoice->get()->row();


        $this->layout->set(array(
            'is_product' => $this->db->query("SELECT is_product FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND created_by = ".$this->session->userdata('user_id')." ")->row()->is_product,
            'pos_invoice_id' => $pos_invoice_id,
            'invoice_detail' => $pos_invoice,
            'service_list' => $this->mdl_mech_pos_invoice->get_user_quote_service_item($pos_invoice_id, $invoice->customer_id),
            'service_package_list' => $this->mdl_mech_pos_invoice->get_user_quote_service_package_item($pos_invoice_id, $pos_invoice->customer_id),
            'product_list' => $this->mdl_mech_pos_invoice->get_user_quote_product_item($pos_invoice_id, $invoice->customer_id),
            'payment_methods' => $this->mdl_payment_methods->get()->result(),
            'service_category_items'=>$this->mdl_mech_service_item_dtls->get()->result(),
            'product_category_items' =>$this->mdl_mech_item_master->get()->result(),
            'customer_details' => $this->mdl_clients->get_by_id($invoice->customer_id),
            'bank_dtls' => $this->db->get_where('mech_workshop_bank_list', array('module_type' =>'B', 'w_branch_id'=>$branch_id, 'bank_status' => 'A'))->row(),
        )); 
        $this->layout->buffer('content', 'mech_pos_invoices/view');
        $this->layout->render();
    }

	public function generate_pdf($pos_invoice_id, $stream = true, $pos_invoice_template = null)
    {
        $this->load->helper('pdf');
        generate_user_pos_invoice_pdf($pos_invoice_id, $stream, $pos_invoice_template, null);
    }

    public function generate_thermal_pdf($pos_invoice_id, $stream = true, $pos_thermal_invoice_template = null)
    {
        $this->load->helper('pdf');
        generate_user_pos_thermal_invoice_pdf($pos_invoice_id, $stream, $pos_thermal_invoice_template, null);
    }
}
