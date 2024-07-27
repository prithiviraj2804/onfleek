<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mech_Work_Order_Dtls extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_mech_work_order_dtls');
        $this->load->model('user_cars/mdl_user_cars'); 
        $this->load->model('clients/mdl_clients');
        $this->load->model('mech_item_master/mdl_mech_item_master'); 
        $this->load->model('products/mdl_products');  
        $this->load->model('product_brands/mdl_vendor_product_brand');   
        $this->load->model('user_address/mdl_user_address');
        $this->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls');
        $this->load->model('mechanic_service_category_items/mdl_mechanic_service_category_items'); 
		$this->load->model('workshop_branch/mdl_workshop_branch');
		$this->load->model('mech_employee/mdl_mech_employee');
		$this->load->model('users/mdl_users');
        $this->load->model('mech_invoices/mdl_mech_invoice');
        $this->load->model('mech_invoice_groups/mdl_mech_invoice_groups');
        $this->load->model('families/mdl_families');
        $this->load->model('mechanic_service_category/mdl_mechanic_service_category_list');
        $this->load->model('service_packages/mdl_service_package');
        $this->load->model('mech_tax/mdl_mech_tax');
        	
    }

    public function index($page = 0)
    {

        $limit = 15;
        $query = $this->mdl_mech_work_order_dtls->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();
        $this->mdl_mech_work_order_dtls->limit($limit);
        $work_orders = $this->mdl_mech_work_order_dtls->get()->result();
        
        
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

        // $this->db->select('mech_work_order_dtls.work_order_id,mech_work_order_dtls.jobsheet_status,jc.jobcard_status_id,
        // jc.status_name');
        // $this->db->select('jc.status_name,jc.jobcard_status_id');
        // $this->db->from('mech_work_order_dtls');
        // $this->db->join('mech_jobcard_status jc', 'jc.jobcard_status_id = mech_work_order_dtls.jobsheet_status', 'left');
        // $this->db->where('mech_work_order_dtls.status', 'A');
        // $jobcard_status = $this->db->get()->result();
        // print_r($jobcard_status);
        // exit();

        $this->layout->set(
            array(
                'customer_list' => $this->mdl_clients->where('client_active','A')->get()->result(),
                'work_orders' => $work_orders,
                'branch_list' => $branch_list,
                'createLinks' => $createLinks,
                'job_status'  => $this->db->query("SELECT jobcard_status_id,status_name FROM mech_jobcard_status WHERE mech_jobcard_status.status = 'A' ")->result(),
                // 'jobcard_detail'  => $jobcard_status,
                
            )
        );

        $this->layout->buffer('content', 'mech_work_order_dtls/index');
        $this->layout->render();
    }

    public function completed($page = 0)
    {

        $limit = 15;
        $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.work_order_status', 'G');
        $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.jobsheet_status', 'C');
        $query = $this->mdl_mech_work_order_dtls->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();
        $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.work_order_status', 'G');
        $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.jobsheet_status', 'C');
        $this->mdl_mech_work_order_dtls->limit($limit);
        $work_orders = $this->mdl_mech_work_order_dtls->get()->result();
        
        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name,job_description FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name,job_description FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name,job_description FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name,job_description FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
        }else{
            $branch_list = array();
        }

        $this->layout->set(
            array(
                'work_orders' => $work_orders,
                'branch_list' => $branch_list,
                'customer_list' => $this->mdl_clients->where('client_active','A')->get()->result(),
                'createLinks' => $createLinks,
            )
        );

        $this->layout->buffer('content', 'mech_work_order_dtls/completed');
        $this->layout->render();
    }
    
    public function get_user_quote_product_item($work_order_id = null, $user_id  = null)
    {
        if($work_order_id){
        	$work_shop_id = $this->session->userdata('work_shop_id');
			$branch_id = $this->session->userdata('branch_id');
            $this->db->select('si.rs_item_id,si.user_id,si.url_key,si.user_car_id,si.car_brand_model_id,si.brand_model_variant_id,si.is_from,si.service_type,si.category_type,si.service_item,si.item_service_name,si.item_hsn,si.user_item_price,si.mech_item_price,si.item_qty,si.item_discount,si.item_amount,si.igst_pct,si.igst_amount,si.item_total_amount,si.service_status,si.item_work_level, ci.product_name');
            $this->db->from('mech_work_order_service_items si');
            $this->db->join('mech_products ci', 'ci.product_id = si.service_item');
            if($this->session->userdata('user_type') == 3){
				$this->db->where('si.workshop_id='.$work_shop_id.'');
			}elseif($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 || $this->session->userdata('user_type') == 6){
				$this->db->where('si.workshop_id='.$work_shop_id.' AND si.w_branch_id='.$branch_id.' AND si.created_by='.$this->session->userdata('user_id').'');
			}
            $this->db->where('si.is_from', 'work_order_product');
            $this->db->where('si.work_order_id', $work_order_id);
            $service_items = $this->db->get()->result();
        }else{
            $service_items = array();
        }
        
        return json_encode($service_items);
    }
    
    public function get_user_quote_service_item($work_order_id = null)
    {
        if($work_order_id){
        	$work_shop_id = $this->session->userdata('work_shop_id');
			$branch_id = $this->session->userdata('branch_id');
            $this->db->select('si.rs_item_id,si.user_id,si.employee_id,si.url_key,si.user_car_id,si.car_brand_model_id,si.brand_model_variant_id,si.is_from,si.service_type,si.category_type,si.service_item,si.item_service_name,si.item_hsn,si.user_item_price,si.mech_item_price,si.item_qty,si.item_discount,si.item_amount,si.igst_pct,si.igst_amount,si.item_total_amount,si.service_status,si.item_work_level,ci.msim_id,ci.service_item_name,ci.service_category_id,mi.employee_name');
            $this->db->from('mech_work_order_service_items si');
            $this->db->join('mech_service_item_dtls ci', 'ci.msim_id = si.service_item','left');
            $this->db->join('mech_employee mi', 'mi.employee_id = si.employee_id','left');
            if($this->session->userdata('user_type') == 3){
				$this->db->where('si.workshop_id='.$work_shop_id.'');
			}elseif($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 || $this->session->userdata('user_type') == 6){
				$this->db->where('si.workshop_id='.$work_shop_id.' AND si.w_branch_id='.$branch_id.' AND si.created_by='.$this->session->userdata('user_id').'');
			}
            $this->db->where('si.is_from', 'work_order_service');
            $this->db->where('si.work_order_id', $work_order_id);
            $service_items = $this->db->get()->result();
        }else{
            $service_items = array();
        }
        return json_encode($service_items);
    }
    
    public function book($work_order_id = null , $tab = NULL, $status = NULL)
    {
        $work_shop_id = $this->session->userdata('work_shop_id');
		$branch_id = $this->session->userdata('branch_id');
        if ($this->input->post('btn_cancel')) {
            redirect('mech_work_order_dtls');
        }

        if($work_order_id){
            
            $work_order_list = $this->mdl_mech_work_order_dtls->where('work_order_id' , $work_order_id)->get()->row();
            // print_r($work_order_list);
            // exit();
            $user_cars = $this->mdl_user_cars->get_customer_cars_list($work_order_list->customer_id);
			$address_dtls = $this->db->get_where('mech_user_address', array('status' => 1, 'user_id' => $work_order_list->customer_id, 'workshop_id' => $work_shop_id))->result();
			if($work_order_list->refered_by_type == '2'){
			    $refered_dtls = $this->db->get_where('mech_employee', array('mech_employee.employee_status' => 1, 'mech_employee.workshop_id' => $work_shop_id))->result();
			}elseif($work_order_list->refered_by_type == '1'){
			    $refered_dtls = $this->mdl_clients->where('client_active','A')->get()->result();
			}else{
                $refered_dtls = array();
            }
			$selected_checkin_list = $this->db->get_where('mech_vehicle_checkin_dtls', array('mech_vehicle_checkin_dtls.work_order_id' => $work_order_id, 'mech_vehicle_checkin_dtls.workshop_id' => $work_shop_id))->result();
			$service_remainder = $this->db->select('*')->from('mech_service_remainder')->where('work_order_id',$work_order_id )->where('workshop_id',$work_shop_id)->get()->row();
            $insurance_remainder = $this->db->select('*')->from('mech_insurance_remainder')->where('work_order_id',$work_order_id )->where('workshop_id',$work_shop_id)->get()->row();
            $insurance_billing = $this->db->select('*')->from('mech_insurance_billing')->where('entity_id',$work_order_id )->where('entity_type','J')->where('workshop_id',$work_shop_id)->get()->row();
            $service_list = $this->mdl_mech_work_order_dtls->get_user_quote_service_item($work_order_id, $work_order_list->customer_id);
            $service_package_list = $this->mdl_mech_work_order_dtls->get_user_quote_service_package_item($work_order_id, $work_order_list->customer_id);
            $product_list = $this->mdl_mech_work_order_dtls->get_user_quote_product_item($work_order_id, $work_order_list->customer_id);
            $product_ids = $this->mdl_mech_work_order_dtls->get_jobsheet_product_ids($work_order_id, $work_order_list->customer_id);
            $upload_details = $this->db->select('*')->from('ip_uploads')->where('entity_type','J' )->where('url_key',$work_order_list->url_key )->where('workshop_id',$work_shop_id)->get()->result();
            $user_details = $this->mdl_clients->get_by_id($work_order_list->customer_id);
            $breadcrumb = 'lable870';
        }else{

            $breadcrumb = 'lable275';
            $work_order_list = array();
            $user_cars = array();
            $address_dtls = array();
            $refered_dtls = array();
            $selected_checkin_list = array();
            $service_remainder = array();
            $insurance_remainder = array();
            $service_list = array();
            $service_package_list = array();
            $product_list = array();
            $product_ids = array();
            $upload_details = array();
            $user_details = array();
            $insurance_billing = array();
            
        }
        
        // $getemployee = $this->db->get_where('mech_employee', array('mech_employee.employee_status' => 1, 'mech_employee.workshop_id' => $work_shop_id))->result();
        $getemployee = $this->mdl_mech_employee->get()->result();
        if($this->session->userdata('user_type') == 3){
            $this->mdl_mech_invoice->where('mech_invoice.workshop_id='.$work_shop_id.'');
        }elseif($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 || $this->session->userdata('user_type') == 6){
            $this->mdl_mech_invoice->where('mech_invoice.workshop_id='.$work_shop_id.' AND mech_invoice.w_branch_id='.$branch_id.' AND mech_invoice.created_by='.$this->session->userdata('user_id').'');
        }

        $this->mdl_mech_invoice->where('mech_invoice.status',"A");
        $this->mdl_mech_invoice->or_where('mech_invoice.jobsheet_no',"");
        $this->mdl_mech_invoice->or_where('mech_invoice.jobsheet_no',NULL);
        $this->mdl_mech_invoice->where('mech_invoice.invoice_status','G');
        $invoice_number_list = $this->mdl_mech_invoice->get()->result();
        
        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name,job_description FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name,job_description FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name,job_description FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name,job_description FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
        }else{
            $branch_list = array();
        }

        $this->layout->set(array(
            'is_product' => $this->db->query("SELECT is_product FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND created_by = ".$this->session->userdata('user_id')." ")->row()->is_product,
            'work_order_detail' => $work_order_list,
            'user_cars' => $user_cars,
            'branch_list' => $branch_list,
            'address_dtls' => $address_dtls,
            'invoice_number_list' => $invoice_number_list,
            'invoice_group' => $this->mdl_mech_invoice_groups->where('module_type','job_card')->where('status' , 'A')->where('workshop_id' , $work_shop_id)->get()->result(),
            'checkIn_list' => $this->db->get_where('vehicle_checkin_lookup', array('status' => 1))->result(),
            'service_remainder' => $service_remainder,
            'insurance_remainder' => $insurance_remainder,
            'country_list' => $this->db->query('SELECT id,sortname,name,phonecode FROM country_lookup')->result(),
            'state_list' => $this->db->query('SELECT state_id,state_name,country_id FROM mech_state_list')->result(),
            'city_list' => $this->db->query('SELECT city_id,city_name,state_id,country_id FROM city_lookup')->result(),
            'service_list' => $service_list,
            'service_package_list' => $service_package_list,
            'product_list' => $product_list,
            'product_ids' => $product_ids,
            'product_brand' => $this->mdl_vendor_product_brand->get()->result(),
            'selected_checkin_list' => $selected_checkin_list,
            'upload_details' => $upload_details,
            'url_key' => $this->mdl_mech_work_order_dtls->get_url_key(),
            'car_list' => $this->mdl_user_cars->where('owner_id='.$this->session->userdata('user_id').' AND mech_owner_car_list.status = 1')->get()->result() ,
            'customer_list' => $this->mdl_clients->where('client_active','A')->get()->result(),
            'user_details' => $user_details,
            'refered_dtls' => $refered_dtls,
            'issued_by' => $this->mdl_users->where('user_id',$this->session->userdata('user_id'))->get()->result(),
            'assigned_to' => $this->mdl_mech_employee->get()->result(),
            'reference_type' => $this->db->get_where('mech_reference_dtls', array('status' => 1))->result(),
            'service_category_lists' => $this->mdl_mechanic_service_category_list->get()->result(),
            'service_category_items'=>$this->mdl_mech_service_item_dtls->get()->result(),
            'product_category_items' =>$this->mdl_mech_item_master->where('apply_for_all_bmv' , 'Y')->get()->result(),
            'popular_service_category_item_list' => $this->db->get_where('mech_service_item_dtls', array('status' => 'A'))->result(),
            'diagnostics_service_category_item_list' => $this->db->get_where('mech_service_item_dtls', array('status' => 'A'))->result(),
            'breadcrumb' => $breadcrumb,
            'families' => $this->mdl_families->get()->result(),
            'getemployee' => $getemployee,
            'service_package' => $this->mdl_service_package->get()->result(),
            'job_status'  => $this->db->query("SELECT jobcard_status_id,status_name FROM mech_jobcard_status WHERE mech_jobcard_status.status = 'A' ")->result(),
            'gst_spare' => $this->mdl_mech_tax->where('tax_type','G')->where_in('workshop_id', array('1', $this->session->userdata('work_shop_id')))->get()->result(),
            'gst_service' => $this->mdl_mech_tax->where('tax_type','S')->where_in('workshop_id', array('1', $this->session->userdata('work_shop_id')))->get()->result(),
        )); 
        
        $this->layout->buffer('content', 'mech_work_order_dtls/create');
        $this->layout->render();
    }

    public function view($work_order_id = NULL, $status = NULL)
    {
        if(!$work_order_id){
            exit();
        }
        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');
        $work_order_list = $this->mdl_mech_work_order_dtls->where('work_order_id='.$work_order_id.'')->get()->row();
        $work_order_list->refererTypeName = $this->mdl_mech_work_order_dtls->getRefererTypeName($work_order_list->refered_by_type);
        $work_order_list->refererName = $this->mdl_mech_work_order_dtls->getRefererName($work_order_list->refered_by_type , $work_order_list->refered_by_id);
        $work_order_list->user_name = $this->mdl_users->where('user_id', $work_order_list->issued_by)->get()->row()->user_name;
        $work_order_list->assigned_name = $this->mdl_mech_employee->where('employee_id', $work_order_list->assigned_to)->where('employee_status', 1)->get()->row()->employee_name;
        $selected_checkin_list = $this->db->get_where('mech_vehicle_checkin_dtls', array('mech_vehicle_checkin_dtls.work_order_id' => $work_order_id, 'mech_vehicle_checkin_dtls.workshop_id' => $work_shop_id))->result();
        $service_remainder = $this->db->select('*')->from('mech_service_remainder')->where('work_order_id',$work_order_id )->where('workshop_id',$work_shop_id)->get()->row();
        $insurance_remainder = $this->db->select('*')->from('mech_insurance_remainder')->where('work_order_id',$work_order_id )->where('workshop_id',$work_shop_id)->get()->row();
        $insurance_billing = $this->db->select('*')->from('mech_insurance_billing')->where('entity_id',$work_order_id )->where('entity_type','J')->where('workshop_id',$work_shop_id)->get()->row();

        $service_list = $this->mdl_mech_work_order_dtls->get_user_quote_service_item($work_order_id, $work_order_list->customer_id);
        $service_package_list = $this->mdl_mech_work_order_dtls->get_user_quote_service_package_item($work_order_id, $work_order_list->customer_id);
        $product_list = $this->mdl_mech_work_order_dtls->get_user_quote_product_item($work_order_id, $work_order_list->customer_id);

        $upload_details = $this->db->select('*')->from('ip_uploads')->where('entity_type','J' )->where('entity_id',$work_order_id )->where('workshop_id',$work_shop_id)->get()->result();
        $user_details = $this->mdl_clients->get_by_id($work_order_list->customer_id);

        $this->layout->set(array(
            'is_product' => $this->db->query("SELECT is_product FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND created_by = ".$this->session->userdata('user_id')." ")->row()->is_product,
            'work_order_detail' => $work_order_list,
            'checkIn_list' => $this->db->get_where('vehicle_checkin_lookup', array('status' => 1))->result(),
            'service_remainder' => $service_remainder,
            'insurance_remainder' => $insurance_remainder,
            'insurance_billing' => $insurance_billing,
            'service_list' => $service_list,
            'service_package_list' => $service_package_list,
            'product_list' => $product_list,
            'selected_checkin_list' => $selected_checkin_list,
            'upload_details' => $upload_details,
            'assigned_to' => $this->mdl_mech_employee->get()->result(),
        ));
        
        $this->layout->buffer('content', 'mech_work_order_dtls/view_work_order');
        $this->layout->render();
    }

    public function update_user_request_quote($url_from = null, $work_order_id = null)
    {
		if(!$work_order_id){
            exit();
        }

        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');
        $this->mdl_mech_work_order_dtls->where('work_order_id='.$work_order_id.'');
        if($this->session->userdata('user_type') == 3){
            $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.workshop_id='.$work_shop_id.'');
        }elseif($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 || $this->session->userdata('user_type') == 6){
            $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.workshop_id='.$work_shop_id.' AND mech_work_order_dtls.w_branch_id='.$branch_id.' AND mech_work_order_dtls.created_by='.$this->session->userdata('user_id').'');
        }

        $quotes = $this->mdl_mech_work_order_dtls->get()->row();
        $customer_id = $quotes->customer_id;

        $this->db->select("*"); 
        $this->db->from('mech_owner_car_list');
        $this->db->join('mech_car_brand_details cb', 'cb.brand_id=mech_owner_car_list.car_brand_id', 'left');
        $this->db->join('mech_car_brand_models_details cm', 'cm.model_id=mech_owner_car_list.car_brand_model_id', 'left');
        $this->db->join('mech_brand_model_variants cv', 'cv.brand_model_variant_id=mech_owner_car_list.car_variant', 'left');
        $this->db->where('owner_id', $customer_id);
        $this->db->where('mech_owner_car_list.status', 1);
        $customer_car_list = $this->db->get()->result();

        $this->db->select("*"); 
        $this->db->from('mech_user_address');
        $this->db->where('user_id', $customer_id);
        $customer_address_list = $this->db->get()->result();

        $this->layout->set(array(
            'work_order_id' => $work_order_id,
            'url_from' => $url_from,
            'quote_detail' => $quotes,
            'customer_list' => $this->mdl_clients->where('client_active','A')->get()->result(),
            'customer_car_list' => $customer_car_list,
            'customer_address_list' => $customer_address_list,
            'service_list' => $this->get_user_quote_service_item($work_order_id, $invoice->customer_id),
            'product_list' => $this->get_user_quote_product_item($work_order_id, $invoice->customer_id),
            'service_category_items'=>$this->mdl_mech_service_item_dtls->where('status', 'A')->get()->result(),
            'product_category_items' =>$this->mdl_mech_item_master->get()->result(),
            'customer_details' => $this->mdl_clients->get_by_id($quotes->customer_id)
        )); 
		
        $this->layout->buffer('content', 'mech_work_order_dtls/update_user_request_quote');
        $this->layout->render();
    }

    public function delete(){
        $document_id = $this->input->post('work_order_id');
        $this->db->set('status','D');
        $this->db->where('work_order_id', $document_id);
        $this->db->update('mech_work_order_dtls');
        $response = array(
            'success' => 1
        );
        echo json_encode($response);
    }

    
    public function generate_pdf($jobcard_id, $stream = true, $jobcard_template = null)
    {
        $this->load->helper('pdf');
        generate_jobsheet_pdf($jobcard_id, $stream, $jobcard_template, null);
    }

    public function generate_insurance_pdf($jobcard_id, $stream = true, $jobcard_template = null){
        $this->load->helper('pdf');
        generate_insurance_pdf($jobcard_id, $stream, $jobcard_template, null);
    }

}
