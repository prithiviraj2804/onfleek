<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mech_Quotes extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('mech_invoices/mdl_mech_invoice');
        $this->load->model('mech_invoice_groups/mdl_mech_invoice_groups');
        $this->load->model('mech_employee/mdl_mech_employee');
		$this->load->model('mdl_mech_quotes');
		$this->load->model('clients/mdl_clients');
		$this->load->model('user_quotes/mdl_user_quotes');
		$this->load->model('user_cars/mdl_user_cars'); 
        $this->load->model('users/mdl_users');
        $this->load->model('families/mdl_families'); 
        $this->load->model('mech_item_master/mdl_mech_item_master');  
        $this->load->model('product_brands/mdl_vendor_product_brand');
		// $this->load->model('products/mdl_products');   
        $this->load->model('user_address/mdl_user_address');
        $this->load->model('mechanic_service_category/mdl_mechanic_service_category_list');
        $this->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls');
		$this->load->model('mechanic_service_category_items/mdl_mechanic_service_category_items');   
		$this->load->model('workshop_branch/mdl_workshop_branch');  
		$this->load->model('mech_purchase/mdl_mech_purchase'); 
        $this->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');
        $this->load->model('workshop_branch/mdl_workshop_branch');
        $this->load->model('service_packages/mdl_service_package');
        $this->load->model('mech_tax/mdl_mech_tax');
		
	}

    public function index($page = 0)
    {

        $limit = 15;
        $query = $this->mdl_mech_quotes->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();
        $this->mdl_mech_quotes->limit($limit);
        $mech_quotes = $this->mdl_mech_quotes->get()->result();

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
                'mech_quotes' => $mech_quotes,
                'branch_list' => $branch_list,
                'customer_list' => $this->mdl_clients->where('client_active','A')->get()->result(),
                'createLinks' => $createLinks,
            )
        );

        $this->layout->buffer('content', 'mech_quotes/index');
        $this->layout->render();
    }

    public function create($quote_id = null)
    {
        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');

        $this->mdl_mech_purchase->where('mech_purchase.purchase_status != "D"');
        $this->mdl_mech_purchase->where('mech_purchase.status = "A"');
        $purchase_no_list = $this->mdl_mech_purchase->get()->result();

        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name,estimate_description FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name,estimate_description FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name,estimate_description FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name,estimate_description FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
        }else{
            $branch_list = array();
        }

    	if(!$quote_id){
            $quote = array();
            $service_list = array();
            $service_package_list = array();
	        $product_list = array();
            $product_ids = array();
            $customer_details = array();
            $user_cars = array();
            $refered_dtls = array();
            $address_dtls = array();
        } else {
            $this->mdl_mech_quotes->where('quote_id',$quote_id);
            $quote = $this->mdl_mech_quotes->get()->row();
	        $service_package_list = $this->mdl_mech_quotes->get_user_quote_service_package_item($quote_id, $quote->customer_id);
            $service_list = $this->mdl_mech_quotes->get_user_quote_service_item($quote_id, $quote->customer_id);
            $service_ids = $this->mdl_mech_quotes->get_user_quote_service_ids($quote_id, $quote->customer_id);
            
            $product_list = $this->mdl_mech_quotes->get_user_quote_product_item($quote_id, $quote->customer_id);
	        $product_ids = $this->mdl_mech_quotes->get_user_quote_product_ids($quote_id, $quote->customer_id);
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
            'is_shift' => ($this->db->query("SELECT shift FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." ")->row()->shift),
            'shift_list'=> $this->db->query('SELECT * FROM mech_shift')->result(),
            'is_product' => ($this->db->query("SELECT is_product FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND created_by = ".$this->session->userdata('user_id')." ")->row()->is_product),
            'quote_id' => $quote_id,
            'quotes_detail' => $quote,
            'branch_list' => $branch_list,
            'invoice_group' => $this->mdl_mech_invoice_groups->where('module_type','quote')->where('status' , 'A')->where('workshop_id' , $work_shop_id)->get()->result(),
            'purchase_no_list' =>$purchase_no_list,
            'service_list' => $service_list,
            'service_ids' => $service_ids,
            'service_package_list' => $service_package_list,
            'product_list' => $product_list,
            'product_ids' => $product_ids,
            'product_brand' => $this->mdl_vendor_product_brand->get()->result(),
            'user_cars' => $user_cars,
            'refered_dtls' => $refered_dtls,
            'address_dtls' => $address_dtls,
            'customer_list' => $this->mdl_clients->where('client_active','A')->get()->result(),
            'product_category_items' =>$this->mdl_mech_item_master->where('apply_for_all_bmv' , 'Y')->get()->result(),
            'families' => $this->mdl_families->get()->result(),
            'service_category_lists' => $this->mdl_mechanic_service_category_list->get()->result(),
            'service_category_list' => $this->mdl_mechanic_service_category_list->get()->result(),
            'reference_type' => $this->db->get_where('mech_reference_dtls', array('status' => 1))->result(),
            'employee_list' => $this->mdl_mech_employee->get()->result(),
            'service_category_items'=>$this->mdl_mech_service_item_dtls->get()->result(),
            'customer_details' => $customer_details,
            'getemployee' => $getemployee,
            'service_package' => $this->mdl_service_package->get()->result(),
            'gst_spare' => $this->mdl_mech_tax->where('tax_type','G')->where_in('workshop_id', array('1', $this->session->userdata('work_shop_id')))->get()->result(),
            'gst_service' => $this->mdl_mech_tax->where('tax_type','S')->where_in('workshop_id', array('1', $this->session->userdata('work_shop_id')))->get()->result(),
        )); 
		
        $this->layout->buffer('content', 'mech_quotes/create');
        $this->layout->render();
    }
	
    public function view($quote_id)
    {
		if(!$quote_id){
            exit();
        }
        
        $this->mdl_mech_quotes->where('quote_id', $quote_id);
        $quote = $this->mdl_mech_quotes->get()->row();
        if(!empty($quote)){
            if($quote->quote_date){
                $quote->quote_date = date_from_mysql($quote->quote_date);
            }
        }
        $this->layout->set(array(
            'is_product' => $this->db->query("SELECT is_product FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND created_by = ".$this->session->userdata('user_id')." ")->row()->is_product,
            'quote_id' => $quote_id,
            'quote_detail' => $quote,
            'service_list' => $this->mdl_mech_quotes->get_user_quote_service_item($quote_id, $quote->customer_id),
            'product_list' => $this->mdl_mech_quotes->get_user_quote_product_item($quote_id, $quote->customer_id),
            'service_category_items'=>$this->mdl_mech_service_item_dtls->get()->result(),
            'service_package_list' => $this->mdl_mech_quotes->get_user_quote_service_package_item($quote_id, $quote->customer_id),
            'product_category_items' =>$this->mdl_mech_item_master->where('apply_for_all_bmv' , 'Y')->get()->result(),
            'customer_details' => $this->mdl_clients->get_by_id($quote->customer_id),
        )); 
        $this->layout->buffer('content', 'mech_quotes/view');
        $this->layout->render();
    }

    public function convert_to_invoice($quote_id = NULL , $url_from = NULL)
    {

        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');
        
        if(empty($quote_id)) {
            redirect('mech_quotes');
        }

        $this->mdl_mech_quotes->where('quote_id', $quote_id);
        $quote_detail = $this->mdl_mech_quotes->get()->row();
        $service_items = $this->mdl_mech_quotes->get_user_quote_service_item($quote_id, $quote_detail->customer_id);
        $products_items = $this->mdl_mech_quotes->get_user_quote_product_item($quote_id, $quote_detail->customer_id);
        $service_package_items = $this->mdl_mech_quotes->get_user_quote_service_package_item($quote_id, $quote_detail->customer_id);
        
        $data = array(
            'invoice_category' => 'I', 
            'branch_id' => $quote_detail->branch_id?$quote_detail->branch_id:NULL,
            'work_from' => 'Q',
            'work_from_id' => $quote_id,
            'workshop_id' => $work_shop_id,
            'w_branch_id' => $quote_detail->branch_id?$quote_detail->branch_id:NULL,
            'invoice_date' => date('Y-m-d'),
            'customer_id' => $quote_detail->customer_id,
            'customer_car_id' => $quote_detail->customer_car_id,
            'user_address_id' => $quote_detail->user_address_id,
            'visit_type' => 'W',
            'current_odometer_reading' => $quote_detail->current_odometer_reading?$quote_detail->current_odometer_reading:'',
            'purchase_no' =>  $quote_detail->purchase_no?$quote_detail->purchase_no:'',
            'refered_by_type' => $quote_detail->refered_by_type,
            'refered_by_id' => $quote_detail->refered_by_id,
            
            'service_discountstate' => $quote_detail->service_discountstate?$quote_detail->service_discountstate:"",
            'service_user_total' => $quote_detail->service_user_total?$quote_detail->service_user_total:0,
            'service_mech_total' => $quote_detail->service_mech_total?$quote_detail->service_mech_total:0,
            'service_total_discount' => $quote_detail->service_total_discount?$quote_detail->service_total_discount:0,
            'service_total_discount_pct' => $quote_detail->service_total_discount_pct?$quote_detail->service_total_discount_pct:0,
            'service_total_taxable' => $quote_detail->service_total_taxable?$quote_detail->service_total_taxable:0,
            'service_total_gst_pct' => $quote_detail->service_total_gst_pct?$quote_detail->service_total_gst_pct:0,
            'service_total_gst' => $quote_detail->total_servie_gst_price?$quote_detail->total_servie_gst_price:0,
            'service_grand_total' => $quote_detail->total_service_amount?$quote_detail->total_service_amount:0,

            'packagediscountstate' => $quote_detail->packagediscountstate?$quote_detail->packagediscountstate:"",
            'service_package_user_total' => $quote_detail->service_package_user_total?$quote_detail->service_package_user_total:0,
            'service_package_mech_total' => $quote_detail->service_package_mech_total?$quote_detail->service_package_mech_total:0,
            'service_package_total_discount' => $quote_detail->service_package_total_discount?$quote_detail->service_package_total_discount:0,
            'service_package_total_discount_pct' => $quote_detail->service_package_total_discount_pct?$quote_detail->service_package_total_discount_pct:0,
            'service_package_total_taxable' => $quote_detail->service_package_total_taxable?$quote_detail->service_package_total_taxable:0,
            'service_package_total_gst_pct' => $quote_detail->service_package_total_gst_pct?$quote_detail->service_package_total_gst_pct:0,
            'service_package_total_gst' => $quote_detail->service_package_total_gst?$quote_detail->service_package_total_gst:0,
            'service_package_grand_total' => $quote_detail->service_package_grand_total?$quote_detail->service_package_grand_total:0,

            'parts_discountstate' => $quote_detail->parts_discountstate?$quote_detail->parts_discountstate:"",
            'product_user_total' => $quote_detail->product_user_total?$quote_detail->product_user_total:0,
            'product_mech_total' => $quote_detail->product_mech_total?$quote_detail->product_mech_total:0,
            'product_total_discount' => $quote_detail->product_total_discount?$quote_detail->product_total_discount:0,
            'product_total_taxable' => $quote_detail->product_total_taxable?$quote_detail->product_total_taxable:0,
            'product_total_gst' => $quote_detail->product_total_gst?$quote_detail->product_total_gst:0,
            'product_grand_total' => $quote_detail->product_grand_total?$quote_detail->product_grand_total:0,
            'total_taxable_amount' => $quote_detail->total_taxable_amount?$quote_detail->total_taxable_amount:0,
            'total_tax_amount' => $quote_detail->total_tax_amount?$quote_detail->total_tax_amount:0,
            'invoice_status' => 'D',
            'created_on' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id')
        );

        $invoice_id = $this->mdl_mech_invoice->save($invoice_id, $data);

        foreach (json_decode($service_items) as $service) {
            if($service->is_from == "quote_service"){
                if (!empty($service->item_id)) {
                    $service_array = array(
                        'quote_id'=>$quote_id,
                        'invoice_id' => $invoice_id,
                        'user_id'=> $quote_detail->customer_id,
                        'is_from'=>'invoice_service',
                        'service_item'=> $service->service_item,
                        'item_hsn' => $service->item_hsn,
                        'user_item_price'=> $service->user_item_price?$service->user_item_price:0,
                        'mech_item_price'=> $service->mech_item_price?$service->mech_item_price:0,
                        'item_discount'=> $service->item_discount?$service->item_discount:0,
                        'item_discount_price'=> $service->item_discount_price?$service->item_discount_price:0,
                        'igst_pct'=> $service->igst_pct?$service->igst_pct:0,
                        'igst_amount'=> $service->igst_amount?$service->igst_amount:0,
                        'cgst_pct'=> $service->cgst_pct?$service->cgst_pct:0,
                        'cgst_amount'=> $service->cgst_amount?$service->cgst_amount:0,
                        'sgst_pct'=> $service->sgst_pct?$service->sgst_pct:0,
                        'sgst_amount'=> $service->sgst_amount?$service->sgst_amount:0,
                        'warrentry_prd'=>$service->warrentry_prd,
                        'item_total_amount'=> $service->item_total_amount?$service->item_total_amount:0,
                        'created_on'=>date('Y-m-d H:i:s'),
                        'created_by'=>$this->session->userdata('user_id'),
                        'modified_by'=>$this->session->userdata('user_id'),
                        'workshop_id' => $this->session->userdata('work_shop_id'),
                        'w_branch_id' => $this->session->userdata('branch_id')
                    );
                    
                    $service_id = $this->db->insert('mech_invoice_item', $service_array);
                    
                }
            }
        }

        foreach (json_decode($service_package_items) as $service) {
            if($service->is_from == "quote_package"){
                if (!empty($service->item_id)) {
                    $service_package_array = array(
                        'quote_id' => $quote_id,
                        'invoice_id' => $invoice_id,
                        'user_id' => $quote_detail->customer_id,
                        'is_from' => 'invoice_package',
                        'service_item' => $service->service_item,
                        'item_hsn' => $service->item_hsn,
                        'employee_id' => $service->employee_id,
                        'user_item_price' => $service->user_item_price?$service->user_item_price:0,
                        'mech_item_price' => $service->mech_item_price?$service->mech_item_price:0,
                        'item_discount' => $service->item_discount?$service->item_discount:0,
                        'item_discount_price' => $service->item_discount_price?$service->item_discount_price:0,
                        'igst_pct' => $service->igst_pct?$service->igst_pct:0,
                        'igst_amount' => $service->igst_amount?$service->igst_amount:0,
                        'cgst_pct' => $service->cgst_pct?$service->cgst_pct:0,
                        'cgst_amount' => $service->cgst_amount?$service->cgst_amount:0,
                        'sgst_pct' => $service->sgst_pct?$service->sgst_pct:0,
                        'sgst_amount' => $service->sgst_amount?$service->sgst_amount:0,
                        'warrentry_prd' =>$service->warrentry_prd,
                        'item_total_amount' => $service->item_total_amount?$service->item_total_amount:0,
                        'created_on' =>date('Y-m-d H:i:s'),
                        'created_by' =>$this->session->userdata('user_id'),
                        'modified_by' =>$this->session->userdata('user_id'),
                        'workshop_id' => $this->session->userdata('work_shop_id'),
                        'w_branch_id' => $this->session->userdata('branch_id')
                    );
                    // print_r($service_package_array);
                    $service_package_id = $this->db->insert('mech_invoice_item', $service_package_array);
                    
                }
            }
        }

        $is_product = $this->db->query("SELECT is_product FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND created_by = ".$this->session->userdata('user_id')." ")->row()->is_product;
        if($is_product == "Y"){
            foreach (json_decode($products_items) as $product) {
                if($product->is_from == "quote_product"){
                    if(!empty($product->item_id)) {
                        $product_array = array(
                            'quote_id'=> $quote_id,
                            'invoice_id' => $invoice_id,
                            'user_id'=> $quote_detail->customer_id,
                            'is_from'=>'invoice_product',
                            'service_item'=>$product->service_item,
                            'user_item_price'=> $product->user_item_price?$product->user_item_price:0,
                            'mech_item_price'=> $product->mech_lbr_price?$product->mech_lbr_price:0,
                            'item_hsn' => $product->item_hsn,
                            'item_qty'=> $product->item_qty,
                            'item_amount' => $product->item_amount?$product->item_amount:0,
                            'item_discount'=> $product->item_discount?$product->item_discount:0,
                            'item_discount_price' => $service->item_discount_price?$service->item_discount_price:0,
                            'igst_pct'=> $product->igst_pct?$product->igst_pct:0,
                            'igst_amount'=> $product->igst_amount?$product->igst_amount:0,
                            'cgst_pct'=> $product->cgst_pct?$product->cgst_pct:0,
                            'cgst_amount'=> $product->cgst_amount?$product->cgst_amount:0,
                            'sgst_pct'=> $product->sgst_pct?$product->sgst_pct:0,
                            'sgst_amount'=> $product->sgst_amount?$product->sgst_amount:0,
                            'warrentry_prd'=> $product->warrentry_prd,
                            'item_total_amount'=> $product->item_total_amount?$product->item_total_amount:0,
                            'created_on'=>date('Y-m-d H:i:s'),
                            'created_by'=>$this->session->userdata('user_id'),
                            'modified_by'=>$this->session->userdata('user_id'),
                            'workshop_id' => $this->session->userdata('work_shop_id'),
                            'w_branch_id' => $this->session->userdata('branch_id')
                        );
                        $product_id = $this->db->insert('mech_invoice_item', $product_array);
                        
                        $inventory_data = array(
                            'product_id' => $product->service_item,
                            'stock_type' => 1,
                            'quantity' => $product->item_qty,
                            'price' => $product->user_item_price?$product->user_item_price:0,
                            'stock_date' => date('Y-m-d H:i:s'),
                            'description' => "Invoice stock",
                            'action_type' => 2
                        );
                        $status = $this->mdl_mech_item_master->save_inventory($inventory_data);
                    }
                }
            }
        }

        if(!empty($quote_detail->device_token)){
            $notification_mobile_data = array(
                "body" => "Hi ".$quote_detail->client_name.", Your Vehicle is ready to be picked up. ",
                "title" => "Vehicle Invoice Generated",
            );
            $data =  array(
                'notification_type'=>'offer',
                'post_title'=>'AC Service', 
                'post_desc'=>'Full AC Service at 1499 only'
            );
            $target = array($quote_detail->device_token);
            send_notification($data, $target, $notification_mobile_data);
        }
        
        redirect('mech_invoices/create/'.$invoice_id);
    }

	public function generate_pdf($quote_id, $stream = true, $quote_template = null)
    {
        $this->load->helper('pdf');
        generate_user_quote_pdf($quote_id, $stream, $quote_template, null);
    }
}
