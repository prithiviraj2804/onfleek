<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Spare_Invoices extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('mech_invoice_groups/mdl_mech_invoice_groups');
        $this->load->model('mech_employee/mdl_mech_employee');
		$this->load->model('mdl_spare_invoice');
        $this->load->model('clients/mdl_clients');
        $this->load->model('suppliers/mdl_suppliers');
		$this->load->model('user_quotes/mdl_user_quotes');
		$this->load->model('user_cars/mdl_user_cars'); 
		$this->load->model('users/mdl_users');
        $this->load->model('mech_item_master/mdl_mech_item_master'); 
        $this->load->model('products/mdl_products');  
        $this->load->model('mech_car_brand_details/mdl_mech_car_brand_details');
        $this->load->model('mech_car_brand_models_details/mdl_mech_car_brand_models_details'); 
        $this->load->model('product_brands/mdl_vendor_product_brand');
		$this->load->model('user_address/mdl_user_address'); 
        $this->load->model('families/mdl_families');   
		$this->load->model('workshop_branch/mdl_workshop_branch');  
		$this->load->model('mech_purchase/mdl_mech_purchase'); 
        $this->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls'); 
        $this->load->model('payment_methods/mdl_payment_methods'); 
        $this->load->model('workshop_branch/mdl_workshop_branch');
	}

    public function index($page = 0)
    {
       
        $limit = 15;
        $query = $this->mdl_spare_invoice->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();
        $this->mdl_spare_invoice->limit($limit);
        $mech_invoices = $this->mdl_spare_invoice->get()->result();
        
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
                'mech_invoices' => $mech_invoices,
                'branch_list' => $branch_list,
                'customer_list' => $this->mdl_clients->where('client_active','A')->get()->result(),
                'createLinks' => $createLinks
            )
        );

        $this->layout->buffer('content', 'spare_invoices/index');
        $this->layout->render();
    }

    public function create($invoice_id=null)
    {

        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');
        
        if($this->session->userdata('user_type') == 3){
            $this->mdl_mech_purchase->where('mech_purchase.workshop_id='.$work_shop_id.'');
        }elseif($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 || $this->session->userdata('user_type') == 6){
            $this->mdl_mech_purchase->where('mech_purchase.workshop_id='.$work_shop_id.' AND mech_purchase.w_branch_id='.$branch_id.' AND mech_purchase.created_by='.$this->session->userdata('user_id').'');
        }
        
        
        $this->mdl_mech_purchase->where('mech_purchase.purchase_status != "D"');
        $this->mdl_mech_purchase->where('mech_purchase.status = "A"');
        $purchase_no_list = $this->mdl_mech_purchase->get()->result();
        
        $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.status', 'A');
        $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.jobsheet_status', 'C');
        $work_order_no_list = $this->mdl_mech_work_order_dtls->get()->result();

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

        $rewards_amount = 0;
        $rewards_tax = NULL;
        $reward_detail = array();
        $applied_rewards = 'N';

    	if(!$invoice_id){
            $invoice = array();
            $product_list = array();
            $product_ids = array();
            $customer_details = array();
            $user_cars = array();
            $refered_dtls = array();
            $address_dtls = array();
            if(count($branch_list) <= 1){
                if($branch_list[0]->rewards == 'Y'){
                    $applied_rewards = 'Y';
                    $rewards_amount = $branch_list[0]->rewards_amount;
                    $rewards_tax = $branch_list[0]->rewards_tax;
                    $this->db->select("mrdlts_id,branch_id,applied_for,inclusive_exclusive,reward_type,reward_amount");	
                    $this->db->from('mech_rewards_dlts');
                    $this->db->where('branch_id', $branch_list[0]->w_branch_id);
                    $this->db->where('workshop_id', $work_shop_id);
                    $this->db->where('status', 'A');
                    $reward_detail = $this->db->get()->row();
                }
            }
        } else {
            
        	$this->mdl_spare_invoice->where('invoice_id' , $invoice_id);
            $invoice = $this->mdl_spare_invoice->get()->row();
            $product_list = $this->mdl_spare_invoice->get_user_quote_product_item($invoice_id, $invoice->customer_id);
            $product_ids = $this->mdl_spare_invoice->get_user_quote_product_ids($invoice_id, $invoice->customer_id);
            $customer_details = $this->mdl_clients->get_by_id($invoice->customer_id);
            if($invoice->refered_by_type == '2'){
                $refered_dtls = $this->db->get_where('mech_employee', array('mech_employee.employee_status' => 1, 'mech_employee.workshop_id' => $work_shop_id))->result();
            }elseif($invoice->refered_by_type == '1'){
                $refered_dtls = $this->mdl_clients->where('client_active','A')->get()->result();
            }elseif($invoice->refered_by_type == '3'){
                $refered_dtls = $this->mdl_suppliers->where('supplier_active','1')->get()->result();
            }else{
                $refered_dtls = array();
            }
            $address_dtls = $this->mdl_user_address->where('user_id',$invoice->customer_id)->where('workshop_id',$work_shop_id)->get()->result();
            
            $branch_details = $this->mdl_workshop_branch->where('w_branch_id',$invoice->branch_id)->get()->row();
            if($branch_details->rewards == 'Y'){
                $applied_rewards = 'Y';
                $rewards_amount = $branch_details->rewards_amount;
                $rewards_tax = $branch_details->rewards_tax;
                $this->db->select("mrdlts_id,branch_id,applied_for,inclusive_exclusive,reward_type,reward_amount");	
                $this->db->from('mech_rewards_dlts');
                $this->db->where('branch_id', $branch_details->w_branch_id);
                $this->db->where('workshop_id', $work_shop_id);
                $this->db->where('status', 'A');
                $reward_detail = $this->db->get()->row();
            }
        }


        // print_r($product_list);
        // exit();

        $this->layout->set(array(
            'is_shift' => ($this->db->query("SELECT shift FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." ")->row()->shift),
            'shift_list'=> $this->db->query('SELECT shift_id,shift_name FROM mech_shift')->result(),
            'is_product' => ($this->db->query("SELECT is_product FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND created_by = ".$this->session->userdata('user_id')." ")->row()->is_product),
            'invoice_id' => $invoice_id,
            'invoice_detail' => $invoice,
            'branch_list' => $branch_list,
            'invoice_group' => $this->mdl_mech_invoice_groups->where('module_type','invoice')->where('status' , 'A')->where('workshop_id' , $work_shop_id)->get()->result(),
            'purchase_no_list' =>$purchase_no_list,
            'work_order_no_list' => $work_order_no_list,
            'product_list' => $product_list,
            'product_ids' => $product_ids,
            'payment_methods' => $this->mdl_payment_methods->get()->result(),
            'refered_dtls' => $refered_dtls,
            'address_dtls' => $address_dtls,
            'customer_list' => $this->mdl_clients->where('client_active','A')->get()->result(),
            'product_category_items' =>$this->mdl_mech_item_master->where('apply_for_all_bmv' , 'Y')->get()->result(),
            'car_brand_list' => $this->mdl_mech_car_brand_details->get()->result(),
			'product_brand' => $this->mdl_vendor_product_brand->get()->result(),
            'car_model_list' => $this->mdl_mech_car_brand_models_details->get()->result(),
            'car_variant_list' => $this->db->get_where('mech_brand_model_variants', array('status' => 1))->result(),
            'families' => $this->mdl_families->get()->result(),
            'reference_type' => $this->db->get_where('mech_reference_dtls', array('status' => 1))->result(),
            'employee_list' => $this->mdl_mech_employee->get()->result(),
            'customer_details' => $customer_details,
            'reward_detail' => $reward_detail,
            'applied_rewards' => $applied_rewards,
            'rewards_amount' => $rewards_amount,
            'rewards_tax' => $rewards_tax,
            'bank_dtls' => $this->db->get_where('mech_workshop_bank_list', array('module_type' =>'B', 'w_branch_id'=>$branch_id, 'bank_status' => 'A'))->result(),
        )); 
		
        $this->layout->buffer('content', 'spare_invoices/create');
        $this->layout->render();
    }
	
    public function view($invoice_id)
    {
		if(!$invoice_id){
            exit();
        }
        $this->mdl_spare_invoice->where('invoice_id',$invoice_id);
        $invoice = $this->mdl_spare_invoice->get()->row();
        
        $this->layout->set(array(
            'is_product' => $this->db->query("SELECT is_product FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND created_by = ".$this->session->userdata('user_id')." ")->row()->is_product,
            'invoice_id' => $invoice_id,
            'invoice_detail' => $invoice,
            'product_list' => $this->mdl_spare_invoice->get_user_quote_product_item($invoice_id, $invoice->customer_id),
            'payment_methods' => $this->mdl_payment_methods->get()->result(),
            'product_category_items' =>$this->mdl_mech_item_master->get()->result(),
            'customer_details' => $this->mdl_clients->get_by_id($invoice->customer_id),
            'bank_dtls' => $this->db->get_where('mech_workshop_bank_list', array('module_type' =>'B', 'w_branch_id'=>$branch_id, 'bank_status' => 'A'))->row(),
        )); 
        $this->layout->buffer('content', 'spare_invoices/view');
        $this->layout->render();
    }

	public function generate_pdf($invoice_id, $stream = true, $invoice_template = null)
    {
        $this->load->helper('pdf');
        generate_spare_user_invoice_pdf($invoice_id, $stream, $invoice_template, null);
    }
}