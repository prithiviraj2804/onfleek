<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Spare_Quotes extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('mech_invoice_groups/mdl_mech_invoice_groups');
        $this->load->model('mech_employee/mdl_mech_employee');
		$this->load->model('mdl_spare_quotes');
		$this->load->model('clients/mdl_clients');
		$this->load->model('user_quotes/mdl_user_quotes');
		$this->load->model('user_cars/mdl_user_cars'); 
        $this->load->model('users/mdl_users');
        $this->load->model('families/mdl_families'); 
        $this->load->model('mech_item_master/mdl_mech_item_master');  
        $this->load->model('product_brands/mdl_vendor_product_brand');
        // $this->load->model('products/mdl_products');   
        $this->load->model('mech_car_brand_details/mdl_mech_car_brand_details');
        $this->load->model('mech_car_brand_models_details/mdl_mech_car_brand_models_details');
        $this->load->model('user_address/mdl_user_address'); 
		$this->load->model('workshop_branch/mdl_workshop_branch');  
		$this->load->model('mech_purchase/mdl_mech_purchase'); 
        $this->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');
        $this->load->model('workshop_branch/mdl_workshop_branch');
        $this->load->model('mech_tax/mdl_mech_tax');
		
	}

    public function index($page = 0)
    {

        $limit = 15;
        $query = $this->mdl_spare_quotes->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();
        $this->mdl_spare_quotes->limit($limit);
        $spare_quotes = $this->mdl_spare_quotes->get()->result();

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
                'is_product' => ($this->db->query("SELECT is_product FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND created_by = ".$this->session->userdata('user_id')." ")->row()->is_product),
                'spare_quotes' => $spare_quotes,
                'branch_list' => $branch_list,
                'customer_list' => $this->mdl_clients->where('client_active','A')->get()->result(),
                'createLinks' => $createLinks,
            )
        );

        $this->layout->buffer('content', 'spare_quotes/index');
        $this->layout->render();
    }

    public function create($quote_id = null)
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

    	if(!$quote_id){
            $quote = array();
	    $product_list = array();
            $product_ids = array();
            $customer_details = array();
            $user_cars = array();
            $refered_dtls = array();
            $address_dtls = array();
        } else {
            $this->mdl_spare_quotes->where('quote_id',$quote_id);
            $quote = $this->mdl_spare_quotes->get()->row();
            $product_list = $this->mdl_spare_quotes->get_user_quote_product_item($quote_id, $quote->customer_id);
            $product_ids = $this->mdl_spare_quotes->get_user_quote_product_ids($quote_id, $quote->customer_id);
            $customer_details = $this->mdl_clients->get_by_id($quote->customer_id);
            $user_cars = $this->mdl_user_cars->where('owner_id',$quote->customer_id)->get()->result();
            if($quote->refered_by_type == '2'){
                $refered_dtls = $this->db->get_where('mech_employee', array('mech_employee.employee_status' => 1, 'mech_employee.workshop_id' => $work_shop_id))->result();
            }elseif($quote->refered_by_type == '1'){
                $refered_dtls = $this->mdl_clients->where('client_active','A')->get()->result();
            }else{
                $refered_dtls  = array();
            }
            $address_dtls = $this->db->get_where('mech_user_address', array('status' => 1, 'user_id' => $quote->customer_id, 'workshop_id' => $work_shop_id))->result();
            $branch_details = $this->mdl_workshop_branch->where('w_branch_id',$quote->branch_id)->get()->row();
        }

        $getemployee = $this->mdl_mech_employee->get()->result();
       
        $this->layout->set(array(
            'quote_id' => $quote_id,
            'quotes_detail' => $quote,
            'branch_list' => $branch_list,
            'invoice_group' => $this->mdl_mech_invoice_groups->where('module_type','quote')->where('status' , 'A')->where('workshop_id' , $work_shop_id)->get()->result(),
            'product_list' => $product_list,
            'product_ids' => $product_ids,
            'car_brand_list' => $this->mdl_mech_car_brand_details->get()->result(),
			'product_brand' => $this->mdl_vendor_product_brand->get()->result(),
            'car_model_list' => $this->mdl_mech_car_brand_models_details->get()->result(),
            'car_variant_list' => $this->db->get_where('mech_brand_model_variants', array('status' => 1))->result(),
            'refered_dtls' => $refered_dtls,
            'address_dtls' => $address_dtls,
            'customer_list' => $this->mdl_clients->where('client_active','A')->get()->result(),
            'product_category_items' =>$this->mdl_mech_item_master->where('apply_for_all_bmv' , 'Y')->get()->result(),
            'families' => $this->mdl_families->get()->result(),
            'reference_type' => $this->db->get_where('mech_reference_dtls', array('status' => 1))->result(),
            'employee_list' => $this->mdl_mech_employee->get()->result(),
            'customer_details' => $customer_details,
            'getemployee' => $getemployee,
            'gst_spare' => $this->mdl_mech_tax->where('tax_type','G')->where_in('workshop_id', array('1', $this->session->userdata('work_shop_id')))->get()->result(),
        )); 
		
        $this->layout->buffer('content', 'spare_quotes/create');
        $this->layout->render();
    }
	
    public function view($quote_id)
    {
		if(!$quote_id){
            exit();
        }
        
        $this->mdl_spare_quotes->where('quote_id', $quote_id);
        $quote = $this->mdl_spare_quotes->get()->row();
        if(!empty($quote)){
            if($quote->quote_date){
                $quote->quote_date = date_from_mysql($quote->quote_date);
            }
        }
        $this->layout->set(array(
            'quote_id' => $quote_id,
            'quote_detail' => $quote,
            'product_list' => $this->mdl_spare_quotes->get_user_quote_product_item($quote_id, $quote->customer_id),
            'product_category_items' =>$this->mdl_mech_item_master->get()->result(),
            'customer_details' => $this->mdl_clients->get_by_id($quote->customer_id),
        )); 
        $this->layout->buffer('content', 'spare_quotes/view');
        $this->layout->render();
    }

	public function generate_pdf($quote_id, $stream = true, $quote_template = null)
    {
        $this->load->helper('pdf');
        generate_user_spare_quote_pdf($quote_id, $stream, $quote_template, null);
    }
}
