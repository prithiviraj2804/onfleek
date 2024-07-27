<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mech_Appointments extends Admin_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mech_appointments/mdl_mech_leads');
        $this->load->model('user_cars/mdl_user_cars'); 
        $this->load->model('clients/mdl_clients');
        $this->load->model('mech_item_master/mdl_mech_item_master');     
        $this->load->model('user_address/mdl_user_address');  
        $this->load->model('products/mdl_products'); 
        $this->load->model('product_brands/mdl_vendor_product_brand');
        $this->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls'); 
        $this->load->model('mechanic_service_category/mdl_mechanic_service_category_list');
		$this->load->model('workshop_branch/mdl_workshop_branch');
		$this->load->model('mech_employee/mdl_mech_employee');
		$this->load->model('users/mdl_users');
        $this->load->model('mech_invoices/mdl_mech_invoice');
        $this->load->model('mech_invoice_groups/mdl_mech_invoice_groups');
        $this->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');
        $this->load->model('families/mdl_families');
        $this->load->model('service_packages/mdl_service_package');

    }

    public function index($page = 0)
    {
        // $mech_appointment_status = $this->db->get_where('mech_appointment_status', array('status' => "A"))->result();
        // foreach ($mech_appointment_status as $mech_appointment_status_key => $mech_appointment_status_lists){
        //     $mech_appointments = $this->mdl_mech_leads->where('lead_status',$mech_appointment_status_lists->mps_id)->order_by('reschedule_date','desc')->get()->result();
        //     if(count($mech_appointments) > 0){
        //         $mech_appointment_status[$mech_appointment_status_key]->mech_appointments = $mech_appointments;
        //     }
        // }

        // $this->layout->set(
        //     array(
        //         'mech_appointment_status' => $mech_appointment_status,
        //         'permission' => $this->mdl_users->user_module_permission(),
        //     )
        // );
        $limit = 15;
        $query = $this->mdl_mech_leads->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();
        $this->mdl_mech_leads->limit($limit);
        $mech_lead_status = $this->mdl_mech_leads->get()->result();

        $this->layout->set(
            array(
                'mech_lead_status_list' => $this->db->get_where('mech_appointment_status', array('status' => "A"))->result(),
                'mech_lead_source' => $this->db->get_where('mech_lead_source', array('status' => "A"))->result(),
                'mech_lead_status' => $mech_lead_status,
                'permission' => $this->mdl_users->user_module_permission(),
                'createLinks' => $createLinks,
                )
            );
        $this->layout->buffer('content', 'mech_appointments/index');
        $this->layout->render();
    }

    
    public function form($ml_id = NULL , $tab = NULL, $lead_status = NULL)
    {

        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');
        
        if ($this->input->post('btn_cancel')) {
            redirect('mech_appointments');
        }

        if($ml_id){
            if($lead_status == 5){
                $_POST['lead_status'] = 5;
            }
            $mech_leads = $this->mdl_mech_leads->where('ml_id',$ml_id)->get()->row();
            $user_cars = $this->mdl_user_cars->where('owner_id',$mech_leads->customer_id)->get()->result();
            $address_detail = $this->mdl_user_address->where('user_address_id', $mech_leads->user_address_id)->get()->row();
            $car_detail = $this->mdl_user_cars->where('car_list_id', $mech_leads->user_car_list_id)->get()->row();
            $address_dtls = $this->mdl_user_address->where('user_id' , $mech_leads->customer_id)->get()->result();
            $comments = $this->db->select('mech_comments.comment_id, mech_comments.workshop_id, mech_comments.w_branch_id, mech_comments.entity_id, mech_comments.entity_type, mech_comments.modified_employee_id,mech_comments.comments,mech_comments.reschedule,mech_comments.reschedule_date,mech_comments.created_on,mech_employee.employee_name')->from('mech_comments')->where('mech_comments.entity_id',$ml_id)->where('mech_comments.entity_type','A')->where('mech_comments.status','A')->join('mech_employee', 'mech_employee.employee_id = mech_comments.modified_employee_id')->order_by("mech_comments.comment_id","desc")->get()->result();
            // $service_items = $this->mdl_mech_leads->get_user_quote_service_item($ml_id, $mech_leads->customer_id);
            $service_package_list = $this->mdl_mech_leads->get_user_quote_service_package_item($ml_id, $mech_leads->customer_id);
            // $products_items = $this->mdl_mech_leads->get_user_quote_product_item($ml_id, $mech_leads->customer_id);
 
            $service_list = $this->mdl_mech_leads->get_user_quote_service_item($ml_id, $mech_leads->customer_id);
            $service_ids = $this->mdl_mech_leads->get_user_quote_service_ids($ml_id, $mech_leads->customer_id);

            $product_list = $this->mdl_mech_leads->get_user_quote_product_item($ml_id, $mech_leads->customer_id);
            $product_ids = $this->mdl_mech_leads->get_user_quote_product_ids($ml_id, $mech_leads->customer_id);

        }else{
           
            $mech_leads = array();
            $address_detail = array();
            $service_list = array();
            $service_package_list = array();
            $product_list = array();
            $product_ids = array();
            $service_items = array();
            $products_items = array();
            $car_detail = array();
            $user_cars = array();
            $address_dtls = array();
            $model_list = array();
            $variant_list = array();
            $comments = array();
        }
        
        $getemployee = $this->mdl_mech_employee->get()->result();

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

        $this->layout->set(array(
            'active_tab' => $tab,
            'is_product' => $this->db->query("SELECT is_product FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND created_by = ".$this->session->userdata('user_id')." ")->row()->is_product,
            'mech_leads' => $mech_leads,
            // 'service_list' => $service_items,
            'service_package_list' => $service_package_list,
            // 'product_list' => $products_items,
            'product_brand' => $this->mdl_vendor_product_brand->get()->result(),
            'issued_by' => $this->mdl_users->where('user_id',$this->session->userdata('user_id'))->get()->result(),
            'address_detail' => $address_detail,
            'customer_list' => $this->mdl_clients->where('client_active','A')->get()->result(),
            'branch_list' => $branch_list,
            'car_detail' => $car_detail,
            'car_model_list' => $model_list,
            'car_variant_list' => $variant_list,
            'user_cars' => $user_cars,
            'address_dtls' => $address_dtls,
            'comments' => $comments,
            'mech_lead_source' => $this->db->get_where('mech_lead_source', array('status' => "A"))->result(),
            'mech_appointment_status' => $this->db->get_where('mech_appointment_status', array('status' => "A"))->result(),
            'assigned_to' => $this->mdl_mech_employee->get()->result(),
            'invoice_group' => $this->mdl_mech_invoice_groups->where('module_type','appointment')->where('status' , 'A')->where('workshop_id' , $work_shop_id)->where('branch_id',$branch_id)->get()->row(),
            'model_type' => $this->db->get_where('mech_vehicle_type', array('status' => "A"))->result(),
            'car_brand_list' => $this->db->get_where('mech_car_brand_details', array('status' => 1))->result(),
            'service_category_items'=>$this->mdl_mech_service_item_dtls->get()->result(),
            'product_category_items' =>$this->mdl_mech_item_master->where('apply_for_all_bmv' , 'Y')->get()->result(),
            'families' => $this->mdl_families->get()->result(),
            'service_category_lists' => $this->mdl_mechanic_service_category_list->get()->result(),
            'permission' => $this->mdl_users->user_module_permission(),
            'getemployee' => $getemployee,
            'service_package' => $this->mdl_service_package->get()->result(),
            'product_list' => $product_list,
            'product_ids' => $product_ids,
            'service_list' => $service_list,
            'service_ids' => $service_ids,

        )); 

        $this->layout->buffer('content', 'mech_appointments/create');
        $this->layout->render();
    }

    public function view($ml_id=null, $lead_status = NULL){

        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');

        if($ml_id){
            if($lead_status == 5){
                $_POST['lead_status'] = 5;
            }
            $mech_leads = $this->mdl_mech_leads->where('ml_id' , $ml_id)->get()->row();
            $user_cars = $this->mdl_user_cars->where('owner_id',$mech_leads->customer_id)->get()->result();
            $address_detail = $this->mdl_user_address->where('user_address_id', $mech_leads->user_address_id)->get()->row();
            $car_detail = $this->mdl_user_cars->where('car_list_id', $mech_leads->user_car_list_id)->get()->row();
            $address_dtls = $this->mdl_user_address->where('mech_user_address.status', 1)->where('mech_user_address.user_id', $mech_leads->customer_id)->where('mech_user_address.workshop_id', $work_shop_id)->get()->result();
            $comments = $this->db->select('mech_comments.comment_id, mech_comments.workshop_id, mech_comments.w_branch_id, mech_comments.entity_id, mech_comments.entity_type, mech_comments.modified_employee_id,mech_comments.comments,mech_comments.reschedule,mech_comments.reschedule_date,mech_comments.created_on,mech_employee.employee_name')->from('mech_comments')->where('mech_comments.entity_id',$ml_id)->where('mech_comments.entity_type','A')->where('mech_comments.status','A')->join('mech_employee', 'mech_employee.employee_id = mech_comments.modified_employee_id')->order_by("mech_comments.comment_id","desc")->get()->result();
            $service_items = $this->mdl_mech_leads->get_user_quote_service_item($ml_id, $mech_leads->customer_id);
            $service_package_list = $this->mdl_mech_leads->get_user_quote_service_package_item($ml_id, $mech_leads->customer_id);
            $products_items = $this->mdl_mech_leads->get_user_quote_product_item($ml_id, $mech_leads->customer_id);

        }else{
            redirect('mech_leads/index');
        }

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
        
        $this->layout->set(array(
            //'active_tab' => $tab,
            'is_product' => $this->db->query("SELECT is_product FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND created_by = ".$this->session->userdata('user_id')." ")->row()->is_product,
            'mech_leads' => $mech_leads,
            'service_list' => $service_items,
            'product_list' => $products_items,
            'issued_by' => $this->mdl_users->where('user_id',$this->session->userdata('user_id'))->get()->result(),
            'address_detail' => $address_detail,
            'customer_list' => $this->mdl_clients->where('client_active','A')->get()->result(),
            'branch_list' => $branch_list,
            'car_detail' => $car_detail,
            //'car_model_list' => $model_list,
            //'car_variant_list' => $variant_list,
            'user_cars' => $user_cars,
            'address_dtls' => $address_dtls,
            'comments' => $comments,
            //'appointment' => $appointment,
            'mech_lead_source' => $this->db->get_where('mech_lead_source', array('status' => "A"))->result(),
            'mech_lead_status' => $this->db->get_where('mech_lead_status', array('status' => "A"))->result(),
            'assigned_to' => $this->mdl_mech_employee->get()->result(),
            'invoice_group' => $this->mdl_mech_invoice_groups->where('module_type','leads')->where('branch_id',$branch_id)->get()->row(),
            'model_type' => $this->db->get_where('mech_vehicle_type', array('status' => "A"))->result(),
            'car_brand_list' => $this->db->get_where('mech_car_brand_details', array('status' => 1))->result(),
            'service_category_items'=>$this->mdl_mech_service_item_dtls->get()->result(),
            'product_category_items' =>$this->mdl_mech_item_master->get()->result(),
            'service_package_list' => $service_package_list,

        )); 
        $this->layout->buffer('content', 'mech_appointments/view');
        $this->layout->render();
    }

    public function convert_to_invoice($ml_id = NULL , $url_from = NULL, $lead_status = NULL)
    {

        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');
        
        if(empty($ml_id)) {
            redirect('mech_appointments');
        }

        if($ml_id){
            if($lead_status == 5){
                $_POST['lead_status'] = 5;
            }
            $mech_leads = $this->mdl_mech_leads->where('ml_id' , $ml_id)->get()->row();
            $service_items = $this->mdl_mech_leads->get_user_quote_service_item($ml_id, $mech_leads->customer_id);
            $service_package_items = $this->mdl_mech_leads->get_user_quote_service_package_item($ml_id, $mech_leads->customer_id);
            $products_items = $this->mdl_mech_leads->get_user_quote_product_item($ml_id, $mech_leads->customer_id);
            $comments = $this->db->select('mech_comments.comment_id, mech_comments.workshop_id, mech_comments.w_branch_id, mech_comments.entity_id, mech_comments.entity_type, mech_comments.modified_employee_id,mech_comments.comments,mech_comments.reschedule,mech_comments.reschedule_date,mech_comments.created_on,mech_employee.employee_name')->from('mech_comments')->where('mech_comments.entity_id',$ml_id)->where('mech_comments.entity_type','A')->where('mech_comments.status','A')->join('mech_employee', 'mech_employee.employee_id = mech_comments.modified_employee_id')->order_by("mech_comments.comment_id","desc")->get()->result();
            $appointment = $this->db->get_where('mech_lead_appointment', array('status' => 'A','entity_type' => 'L','entity_id' => $ml_id))->result();

        }

        if($mech_leads->branch_id){
			$terms_condition = $this->db->select('invoice_description')->from('workshop_branch_details')->where('workshop_id ',$work_shop_id)->where('w_branch_id',$mech_leads->branch_id)->get()->row()->invoice_description;
		}
        
        $data = array(
            'invoice_category' => 'I', 
            'branch_id' => $mech_leads->branch_id?$mech_leads->branch_id:NULL,
            'work_from' => 'A',
            'work_from_id' => $ml_id,
            'workshop_id' => $work_shop_id,
            'w_branch_id' => $mech_leads->branch_id?$mech_leads->branch_id:NULL,
            'invoice_date' => date('Y-m-d'),
            'customer_id' => $mech_leads->customer_id,
            'customer_car_id' => $mech_leads->user_car_list_id,
            'user_address_id' => $mech_leads->user_address_id,
            'visit_type' => 'W',
            'refered_by_type' => $mech_leads->refered_by_type,
            'refered_by_id' => $mech_leads->refered_by_id,
            
            'service_discountstate' => $mech_leads->service_discountstate?$mech_leads->service_discountstate:"",
            'service_user_total' => $mech_leads->service_user_total?$mech_leads->service_user_total:0,
            'service_mech_total' => $mech_leads->service_mech_total?$mech_leads->service_mech_total:0,
            'service_total_discount' => $mech_leads->service_total_discount?$mech_leads->service_total_discount:0,
            'service_total_discount_pct' => $mech_leads->service_total_discount_pct?$mech_leads->service_total_discount_pct:0,
            'service_total_taxable' => $mech_leads->service_total_taxable?$mech_leads->service_total_taxable:0,
            'service_total_gst_pct' => $mech_leads->service_total_gst_pct?$mech_leads->service_total_gst_pct:0,
            'service_total_gst' => $mech_leads->total_servie_gst_price?$mech_leads->total_servie_gst_price:0,
            'service_grand_total' => $mech_leads->total_service_amount?$mech_leads->total_service_amount:0,

            'packagediscountstate' => $mech_leads->packagediscountstate?$mech_leads->packagediscountstate:"",
            'service_package_user_total' => $mech_leads->service_package_user_total?$mech_leads->service_package_user_total:0,
            'service_package_mech_total' => $mech_leads->service_package_mech_total?$mech_leads->service_package_mech_total:0,
            'service_package_total_discount' => $mech_leads->service_package_total_discount?$mech_leads->service_package_total_discount:0,
            'service_package_total_discount_pct' => $mech_leads->service_package_total_discount_pct?$mech_leads->service_package_total_discount_pct:0,
            'service_package_total_taxable' => $mech_leads->service_package_total_taxable?$mech_leads->service_package_total_taxable:0,
            'service_package_total_gst_pct' => $mech_leads->service_package_total_gst_pct?$mech_leads->service_package_total_gst_pct:0,
            'service_package_total_gst' => $mech_leads->service_package_total_gst?$mech_leads->service_package_total_gst:0,
            'service_package_grand_total' => $mech_leads->service_package_grand_total?$mech_leads->service_package_grand_total:0,

            'parts_discountstate' => $mech_leads->parts_discountstate?$mech_leads->parts_discountstate:"",
            'product_user_total' => $mech_leads->product_user_total?$mech_leads->product_user_total:0,
            'product_mech_total' => $mech_leads->product_mech_total?$mech_leads->product_mech_total:0,
            'product_total_discount' => $mech_leads->product_total_discount?$mech_leads->product_total_discount:0,
            'product_total_taxable' => $mech_leads->product_total_taxable?$mech_leads->product_total_taxable:0,
            'product_total_gst' => $mech_leads->product_total_gst?$mech_leads->product_total_gst:0,
            'product_grand_total' => $mech_leads->product_grand_total?$mech_leads->product_grand_total:0,
            'total_taxable_amount' => $mech_leads->total_taxable_amount?$mech_leads->total_taxable_amount:0,
            'total_tax_amount' => $mech_leads->total_tax_amount?$mech_leads->total_tax_amount:0,
            'invoice_status' => 'D',
            'created_on' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id')
        );

        $invoice_id = $this->mdl_mech_invoice->save($invoice_id, $data);

        foreach (json_decode($service_items) as $service) {
            if($service->is_from == "lead_service"){
                if (!empty($service->rs_item_id)) {
                    $service_array = array(
                        'quote_id'=>$quote_id,
                        'invoice_id' => $invoice_id,
                        'user_id'=> $mech_leads->customer_id,
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
            if($service->is_from == "lead_package"){
                if (!empty($service->rs_item_id)) {
                    $service_package_array = array(
                        'quote_id' => $quote_id,
                        'invoice_id' => $invoice_id,
                        'user_id' => $mech_leads->customer_id,
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
                    
                    $service_package_id = $this->db->insert('mech_invoice_item', $service_package_array);
                    
                }
            }
        }

        $is_product = $this->db->query("SELECT is_product FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND created_by = ".$this->session->userdata('user_id')." ")->row()->is_product;
        if($is_product == "Y"){
            foreach (json_decode($products_items) as $product) {
                if($product->is_from == "lead_product"){
                    if(!empty($product->rs_item_id)) {
                        $product_array = array(
                            'quote_id'=> $quote_id,
                            'invoice_id' => $invoice_id,
                            'user_id'=> $mech_leads->customer_id,
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

        if(!empty($mech_leads->device_token)){
            $notification_mobile_data = array(
                "body" => "Hi ".$mech_leads->client_name.", Your Vehicle is ready to be picked up. ",
                "title" => "Vehicle Invoice Generated",
            );
            $data =  array(
                'notification_type'=>'offer',
                'post_title'=>'AC Service', 
                'post_desc'=>'Full AC Service at 1499 only'
            );
            $target = array($mech_leads->device_token);
            send_notification($data, $target, $notification_mobile_data);
        }
        
        $this->db->set('lead_status',7);
        // $this->db->set('status','D');
        $this->db->where('ml_id', $ml_id);
        $this->db->update('mech_leads');
        redirect('mech_invoices/create/'.$invoice_id);
    }

    public function convert_to_jobcard($ml_id = NULL , $url_from = NULL, $lead_status = NULL){

        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');
        
        if(empty($ml_id)) {
            redirect('mech_appointments');
        }

        if($ml_id){
            if($lead_status == 5){
                $_POST['lead_status'] = 5;
            }
            $mech_leads = $this->mdl_mech_leads->where('ml_id' , $ml_id)->get()->row();
            $service_items = $this->mdl_mech_leads->get_user_quote_service_item($ml_id, $mech_leads->customer_id);
            $service_package_items = $this->mdl_mech_leads->get_user_quote_service_package_item($ml_id, $mech_leads->customer_id);
            $products_items = $this->mdl_mech_leads->get_user_quote_product_item($ml_id, $mech_leads->customer_id);
            $comments = $this->db->select('mech_comments.comment_id, mech_comments.workshop_id, mech_comments.w_branch_id, mech_comments.entity_id, mech_comments.entity_type, mech_comments.modified_employee_id,mech_comments.comments,mech_comments.reschedule,mech_comments.reschedule_date,mech_comments.created_on,mech_employee.employee_name')->from('mech_comments')->where('mech_comments.entity_id',$ml_id)->where('mech_comments.entity_type','A')->where('mech_comments.status','A')->join('mech_employee', 'mech_employee.employee_id = mech_comments.modified_employee_id')->order_by("mech_comments.comment_id","desc")->get()->result();
            $appointment = $this->db->get_where('mech_lead_appointment', array('status' => 'A','entity_type' => 'L','entity_id' => $ml_id))->result();
        }

        if($mech_leads->branch_id){
			$terms_condition = $this->db->select('job_description')->from('workshop_branch_details')->where('workshop_id ',$work_shop_id)->where('w_branch_id',$mech_leads->branch_id)->get()->row()->job_description;
		}
        
        $data = array(
            'branch_id' => $mech_leads->branch_id?$mech_leads->branch_id:NULL,
            'work_from' => 'A',
            'work_from_id' => $ml_id,
            'workshop_id' => $work_shop_id,
            'w_branch_id' => $mech_leads->branch_id?$mech_leads->branch_id:NULL,
            'customer_car_id' => $mech_leads->user_car_list_id,
            'customer_id' => $mech_leads->customer_id,
            'user_address_id' => $mech_leads->user_address_id,
            'issue_date' => date('Y-m-d'),
            'job_terms_condition' => $terms_condition,
            'refered_by_type' => $mech_leads->refered_by_type,
            'refered_by_id' => $mech_leads->refered_by_id,


            'service_discountstate' => $mech_leads->service_discountstate?$mech_leads->service_discountstate:"",
            'service_user_total' => $mech_leads->service_user_total?$mech_leads->service_user_total:0,
            'service_mech_total' => $mech_leads->service_mech_total?$mech_leads->service_mech_total:0,
            'service_total_discount' => $mech_leads->service_total_discount?$mech_leads->service_total_discount:0,
            'service_total_discount_pct' => $mech_leads->service_total_discount_pct?$mech_leads->service_total_discount_pct:0,
            'service_total_taxable' => $mech_leads->service_total_taxable?$mech_leads->service_total_taxable:0,
            'service_total_gst_pct' => $mech_leads->service_total_gst_pct?$mech_leads->service_total_gst_pct:0,
            'service_total_gst' => $mech_leads->total_servie_gst_price?$mech_leads->total_servie_gst_price:0,
            'service_grand_total' => $mech_leads->total_service_amount?$mech_leads->total_service_amount:0,

            'packagediscountstate' => $mech_leads->packagediscountstate?$mech_leads->packagediscountstate:"",
            'service_package_user_total' => $mech_leads->service_package_user_total?$mech_leads->service_package_user_total:0,
            'service_package_mech_total' => $mech_leads->service_package_mech_total?$mech_leads->service_package_mech_total:0,
            'service_package_total_discount' => $mech_leads->service_package_total_discount?$mech_leads->service_package_total_discount:0,
            'service_package_total_discount_pct' => $mech_leads->service_package_total_discount_pct?$mech_leads->service_package_total_discount_pct:0,
            'service_package_total_taxable' => $mech_leads->service_package_total_taxable?$mech_leads->service_package_total_taxable:0,
            'service_package_total_gst_pct' => $mech_leads->service_package_total_gst_pct?$mech_leads->service_package_total_gst_pct:0,
            'service_package_total_gst' => $mech_leads->service_package_total_gst?$mech_leads->service_package_total_gst:0,
            'service_package_grand_total' => $mech_leads->service_package_grand_total?$mech_leads->service_package_grand_total:0,

            'parts_discountstate' => $mech_leads->parts_discountstate?$mech_leads->parts_discountstate:"",
            'product_user_total' => $mech_leads->product_user_total?$mech_leads->product_user_total:0,
            'product_mech_total' => $mech_leads->product_mech_total?$mech_leads->product_mech_total:0,
            'product_total_discount' => $mech_leads->product_total_discount?$mech_leads->product_total_discount:0,
            'product_total_taxable' => $mech_leads->product_total_taxable?$mech_leads->product_total_taxable:0,
            'product_total_gst' => $mech_leads->product_total_gst?$mech_leads->product_total_gst:0,
            'product_grand_total' => $mech_leads->product_grand_total?$mech_leads->product_grand_total:0,
            'total_taxable_amount' => $mech_leads->total_taxable_amount?$mech_leads->total_taxable_amount:0,
            'total_tax_amount' => $mech_leads->total_tax_amount?$mech_leads->total_tax_amount:0,
            'overall_discount' => $mech_leads->overall_discount?$mech_leads->overall_discount:0,
            'created_on' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id')
        );
        $work_order_id = $this->mdl_mech_work_order_dtls->save($work_order_id,$data);

        foreach (json_decode($service_items) as $service) {
            if($service->is_from == "lead_service"){
                if (!empty($service->rs_item_id)) {
                    $service_array = array(
                        'work_order_id' => $work_order_id,            
                        'user_id' => $mech_leads->customer_id,
                        'user_car_id' => $mech_leads->user_car_list_id,
                        'is_from' => 'work_order_service',
                        'service_item' => $service->service_item,
                        'user_item_price' => $service->user_item_price?$service->user_item_price:0,
                        'mech_item_price' => $service->mech_item_price?$service->mech_item_price:0,
                        'item_discount' => $service->item_discount?$service->item_discount:0,
                        'item_discount_price' => $service->item_discount_price?$service->item_discount_price:0,
                        'igst_pct' => $service->igst_pct?$service->igst_pct:0,
                        'igst_amount' => $service->igst_amount?$service->igst_amount:0,
                        'item_total_amount' => $service->item_total_amount?$service->item_total_amount:0,
                        'created_on' => date('Y-m-d H:i:s'),
                        'created_by' => $this->session->userdata('user_id'),
                        'modified_by' => $this->session->userdata('user_id'),
                        'workshop_id' => $this->session->userdata('work_shop_id'),
                        'w_branch_id' => $this->session->userdata('branch_id')
                    );
                    $service_id = $this->db->insert('mech_work_order_service_items', $service_array);
                }
            }
        }

        foreach (json_decode($service_package_items) as $service) {
            if($service->is_from == "lead_package"){
                if (!empty($service->rs_item_id)) {
                    $service_package_array = array(
                        'work_order_id' => $work_order_id,            
                        'user_id' => $mech_leads->customer_id,
                        'user_car_id' => $mech_leads->user_car_list_id,
                        'employee_id' => $mech_leads->employee_id,
                        'is_from' => 'work_order_package',
                        'service_item' => $service->service_item,
                        'user_item_price' => $service->user_item_price?$service->user_item_price:0,
                        'mech_item_price' => $service->mech_item_price?$service->mech_item_price:0,
                        'item_discount' => $service->item_discount?$service->item_discount:0,
                        'item_discount_price' => $service->item_discount_price?$service->item_discount_price:0,
                        'igst_pct' => $service->igst_pct?$service->igst_pct:0,
                        'igst_amount' => $service->igst_amount?$service->igst_amount:0,
                        'igst_pct' => $service->igst_pct?$service->igst_pct:0,
                        'igst_amount' => $service->igst_amount?$service->igst_amount:0,
                        'item_total_amount' => $service->item_total_amount?$service->item_total_amount:0,
                        'created_on' => date('Y-m-d H:i:s'),
                        'created_by' => $this->session->userdata('user_id'),
                        'modified_by' => $this->session->userdata('user_id'),
                        'workshop_id' => $this->session->userdata('work_shop_id'),
                        'w_branch_id' => $this->session->userdata('branch_id')
                    );
                    $service_package_id = $this->db->insert('mech_work_order_service_items', $service_package_array);
                }
            }
        }

        $is_product = $this->db->query("SELECT is_product FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND created_by = ".$this->session->userdata('user_id')." ")->row()->is_product;

        if($is_product == "Y"){
            foreach (json_decode($products_items) as $product) {
                if($product->is_from == "lead_product"){
                    if(!empty($product->rs_item_id)) {
                        $product_array = array(
                            'work_order_id' => $work_order_id,
                            'user_id' => $mech_leads->customer_id,
                            'user_car_id' => $mech_leads->user_car_list_id,                       
                            'is_from'=>'work_order_product',
                            'service_item'=>$product->service_item,
                            'user_item_price'=> $product->user_item_price?$product->user_item_price:0,
                            'mech_item_price'=> $product->mech_lbr_price?$product->mech_lbr_price:0,
                            'item_hsn' => $product->item_hsn,
                            'item_qty'=> $product->item_qty,
                            'item_amount' => $product->item_amount?$product->item_amount:0,
                            'item_discount'=> $product->item_discount?$product->item_discount:0,
                            'item_discount_price' => $product->item_discount_price?$product->item_discount_price:0,
                            'igst_pct'=> $product->igst_pct?$product->igst_pct:0,
                            'igst_amount'=> $product->igst_amount?$product->igst_amount:0,
                            'item_total_amount'=> $product->item_total_amount?$product->item_total_amount:0,
                            'created_on'=>date('Y-m-d H:i:s'),
                            'created_by'=>$this->session->userdata('user_id'),
                            'modified_by'=>$this->session->userdata('user_id'),
                            'workshop_id' => $this->session->userdata('work_shop_id'),
                            'w_branch_id' => $this->session->userdata('branch_id')
                        );
                        
                        $product_id = $this->db->insert('mech_work_order_service_items', $product_array);
                    }
                }
            }
        }

        if(!empty($mech_leads->device_token)){
            $notification_mobile_data = array(
                "body" => "Work start: HI ".$mech_leads->client_name.", We’re started service on your vehicle. Everything is going as planned. I’ll let you know when it’s done.",
                "title" => "Vehicle Service Status",
            );
            $data =  array(
                'notification_type'=>'offer',
                'post_title'=>'AC Service', 
                'post_desc'=>'Full AC Service at 1499 only'
            );
            $target = array($mech_leads->device_token);
            send_notification($data, $target, $notification_mobile_data);
        }

        $this->db->set('lead_status',6);
        // $this->db->set('status','D');
        $this->db->where('ml_id', $ml_id);
        $this->db->update('mech_leads');
        redirect('mech_work_order_dtls/book/'.$work_order_id);
    }

    public function delete(){
        
        $id = $this->input->post('id');
        $this->db->set('status','D');
        $this->db->where('ml_id', $id);
        $this->db->update('mech_leads');
        $response = array(
            'success' => 1
        );
        echo json_encode($response);
    }

    public function delete_comments(){
        $id = $this->input->post('id');
        $this->db->set('status','D');
        $this->db->where('comment_id', $id);
        $this->db->update('mech_comments');
        $response = array(
            'success' => 1
        );
        echo json_encode($response);
    }
}