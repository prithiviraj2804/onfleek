<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('clients/mdl_clients');
        $this->load->model('customer_category/mdl_customer_category');
        $this->load->helper('settings_helper');
        $this->load->model('settings/mdl_settings');
        $this->load->model('sessions/mdl_sessions');
    }

    public function create()
    {
        $this->load->model('workshop_branch/mdl_workshop_branch');
        $action_from = ($this->input->post('action_from'))?$this->input->post('action_from'):'';
        $customer_id = $this->input->post('client_id');
        $btn_submit = $this->input->post('btn_submit');
        $branch_id_select = $this->input->post('branch_id');

        if ($this->mdl_clients->run_validation('validation_rules_model')) {

            $client_group_no = $this->input->post('client_no');
			
			if(empty($client_group_no)){
                $client_no = $this->mdl_settings->get_invoice_number($this->input->post('invoice_group_id'));
                $_POST['client_no'] = $client_no;
			}
            
            $customer_id = $this->mdl_clients->save($customer_id);

            $client_details = $this->mdl_clients->where('client_id', $customer_id)->get()->row();
            if($client_details->is_new_customer == "Y"){
                $rewards_id = $this->mdl_settings->calculate_referral_points($customer_id);
            }			
            
            if(base_url() != "http://localhost/mechtool/"){
                if($this->session->userdata('customer_E') == 1){
                    if($this->input->post('client_email_id')){
                        $this->load->helper('mailer');
                        $this->load->helper('mailer/phpmailer');
                        $message = $this->load->view('emails/customer', array (
                            'client_name' => $this->input->post('client_name'),
                            'client_email' => strip_tags ($this->input->post('client_email_id'))
                        ), true );
                        $subject = trans('Customer Onboarding');
                        if (mailer_configured()) {
                            $this->load->helper('mailer/phpmailer');
                            if (!email_notification($invoice_id = null, $pdf_template = null, $from, $this->input->post ('client_email_id'), $subject, $message, $cc = null, $bcc = null, $attachment_files = null)) {
                                $email_failed = true;
                                log_message('error', $this->email->print_debugger());
                            }
                        } 
                    }
                }
                if($this->session->userdata('customer_P_S') == 1){
                    if($this->input->post('client_contact_no')){
                        $txt = 'Greetings from '.$this->session->userdata('display_name').', Dear '.$this->input->post('client_name').', Thanks for choosing us to be your vehicle Doctor. As a special treat, Enjoy 20% Off on your next arrival.';
                        $sms = send_sms(htmlspecialchars($this->input->post('client_contact_no')),$txt);
                        if($sms->status == "success"){
                            $db_sms_array = array(
                                'user_id' => $this->session->userdata('user_id'),
                                'name' => $this->input->post('client_name'),
                                'email_id' => $this->input->post ('client_email_id'),
                                'mobile_number' => $this->input->post('client_contact_no'),
                                'message' => $txt,
                                'type' => 3,
                                'status' => 'S',
                                'created_on' => date('Y-m-d H:m:s')
                            ); 
                        }else{
                            $db_sms_array = array(
                                'user_id' => $this->session->userdata('user_id'),
                                'name' => $this->input->post('client_name'),
                                'email_id' => $this->input->post ('client_email_id'),
                                'mobile_number' => $this->input->post('client_contact_no'),
                                'message' => $txt,
                                'type' => 3,
                                'status' => 'F',
                                'created_on' => date('Y-m-d H:m:s')
                            ); 
                        }

                        $this->db->insert('tc_sms_log', $db_sms_array);
                    }
                }
            }

            if(!empty($action_from)){
                $customer_detail = $this->mdl_clients->where('client_id', $customer_id)->get()->result_array();
                $customer_list = $this->mdl_clients->get()->result_array();
            }else{
                $customer_detail = '';
                $customer_list = array();
            }

            $response = array(
                'success' => 1,
                'customer_details' => $customer_detail,
                'customer_id'=>$customer_id,
                'customer_list' => $customer_list,
                'btn_submit' => $btn_submit
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

    public function add_customer_category(){
        $this->layout->load_view('clients/modal_add_customer_category');
    }
    
    public function modal_add_client()
    {
        $this->load->module('layout');

        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A'")->result();
        }else{
            $branch_list = array();
        }


        $data = array(
            'branch_list' => $branch_list,
            'reference_type' => $this->db->get_where('mech_reference_dtls', array('status' => 1))->result(),
        );

        $this->layout->load_view('clients/modal_add_client', $data);
    }
	
	public function get_customer_address()
	{
        $customer_id = $this->input->post('customer_id');
        $work_shop_id = $this->session->userdata('work_shop_id');
		$this->db->select("*");	
		$this->db->from('mech_user_address');
        $this->db->where('user_id', $customer_id);
        $this->db->where('workshop_id', $work_shop_id);
        $this->db->where('status', 1);
        $response = $this->db->get()->result();
        echo json_encode($response);
        exit();
    }

    public function get_customer_cars_address(){

        $customer_id = $this->input->post('customer_id');
        $work_shop_id = $this->session->userdata('work_shop_id');

        $this->db->select('*');
        $this->db->from('mech_owner_car_list');
        $this->db->join('mech_car_brand_details cb', 'cb.brand_id=mech_owner_car_list.car_brand_id', 'left');
        $this->db->join('mech_car_brand_models_details cm', 'cm.model_id=mech_owner_car_list.car_brand_model_id', 'left');
        $this->db->join('mech_brand_model_variants cv', 'cv.brand_model_variant_id=mech_owner_car_list.car_variant', 'left');
        $this->db->where('owner_id', $customer_id);
        $this->db->where('mech_owner_car_list.status', 1);
        $user_cars = $this->db->get()->result();
        if(count($user_cars) < 1){
            $user_cars = array();
        }

		$this->db->select("*");	
		$this->db->from('mech_user_address');
        $this->db->where('user_id', $customer_id);
        $this->db->where('workshop_id', $work_shop_id);
        $this->db->where('status', 1);
        $user_address = $this->db->get()->result();

        if(count($user_address) < 1){
            $user_address = array();
        }

        $this->db->select("refered_by_type,refered_by_id");	
		$this->db->from('mech_clients');
        $this->db->where('client_id', $customer_id);
        $this->db->where('workshop_id', $work_shop_id);
        $this->db->where('client_active', 'A');
        $customer_referrence = $this->db->get()->result();

        if(count($customer_referrence) < 1){
            $customer_referrence = array();
        }

        $response = array(
            'success' => 1,
            'user_cars' => $user_cars, 
            'user_address' => $user_address, 
            'customer_referrence' => $customer_referrence
        );

        echo json_encode($response);
        exit();
    }

    public function get_client_list($cus_id = NULL)
	{
        $work_shop_id = $this->session->userdata('work_shop_id');
        $customer_id = $this->input->post('customer_id');
        if(!empty($this->input->post('customer_id'))){
            $this->mdl_clients->where_not_in('client_active.client_id' , $customer_id);
        }
        $result = $this->mdl_clients->where('client_active', 'A')->where('mech_clients.workshop_id', $work_shop_id )->get()->result();
        echo json_encode($result);
        exit();
    }
    
    public function get_client_detail_by_vehicle_id(){

        $car_list_id = $this->input->post('car_list_id');
        $work_shop_id = $this->session->userdata('work_shop_id');
        $w_branch_id = $this->session->userdata('branch_id');

		$this->db->select("owner_id");	
		$this->db->from('mech_owner_car_list');
        $this->db->where('car_list_id', $car_list_id);
        $this->db->where('workshop_id', $work_shop_id);
        $this->db->where('status', 1);
        $owner_id = $this->db->get()->row()->owner_id;

        $this->db->select("*");
        $this->db->from('mech_clients');
        $this->db->where('client_id',$owner_id);
        $this->db->where('workshop_id', $work_shop_id);
        $this->db->where('w_branch_id', $w_branch_id);
        $response = $this->db->get()->result();
        echo json_encode($response);
        exit();
    }

    public function delete_customer(){
         
        $client_id = $this->input->post('client_id');
        $client_id = $this->mdl_clients->deletecustomer_details($client_id);

        if($client_id)
        {
            $response = array('success' => 1);

        }else{
            $response = array ('success' => 0);
        }
        echo json_encode($response);
    }

    public function get_filter_list(){
        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;
        if($this->input->post('client_name')){
            $this->mdl_clients->like('mech_clients.client_name',$this->input->post('client_name'));
        }
        if($this->input->post('client_contact_no')){
            $this->mdl_clients->like('mech_clients.client_contact_no', $this->input->post('client_contact_no'));
        }
        if($this->input->post('client_email_id')){
            $this->mdl_clients->like('mech_clients.client_email_id', $this->input->post('client_email_id'));
        }
        if($this->input->post('branch_id')){
            $this->mdl_clients->where('mech_clients.branch_id', $this->input->post('branch_id'));
        }
        if($this->input->post('customer_category_id')){
            $this->mdl_clients->where('mech_clients.customer_category_id', $this->input->post('customer_category_id'));
        }
        if($this->input->post('client_no')){
            $this->mdl_clients->like('mech_clients.client_no', $this->input->post('client_no'));
        }
        if($this->input->post('mobile_app')){
            $this->mdl_clients->where('mech_clients.mobile_app_status', $this->input->post('mobile_app'));
        }

        $rowCount = $this->mdl_clients->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        if($this->input->post('client_name')){
            $this->mdl_clients->like('mech_clients.client_name',$this->input->post('client_name'));
        }
        if($this->input->post('client_contact_no')){
            $this->mdl_clients->like('mech_clients.client_contact_no', $this->input->post('client_contact_no'));
        }
        if($this->input->post('client_email_id')){
            $this->mdl_clients->like('mech_clients.client_email_id', $this->input->post('client_email_id'));
        }
        if($this->input->post('branch_id')){
            $this->mdl_clients->where('mech_clients.branch_id', $this->input->post('branch_id'));
        }
        if($this->input->post('customer_category_id')){
            $this->mdl_clients->where('mech_clients.customer_category_id', $this->input->post('customer_category_id'));
        }
        if($this->input->post('client_no')){
            $this->mdl_clients->like('mech_clients.client_no', $this->input->post('client_no'));
        }
        if($this->input->post('mobile_app')){
            $this->mdl_clients->where('mech_clients.mobile_app_status', $this->input->post('mobile_app'));
        }
        $this->mdl_clients->limit($limit,$start);
        $clients = $this->mdl_clients->get()->result();           

        $response = array(
            'success' => 1,
            'clients' => $clients, 
            'createLinks' => $createLinks,
            'work_shop_id' => $this->session->userdata('work_shop_id'),
            'user_type' => $this->session->userdata('user_type'),
            'workshop_is_enabled_inventory' => $this->session->userdata('workshop_is_enabled_inventory'),
        );
        echo json_encode($response);
    }
    
    function phonenoexist()
    {
        $phoneno = $this->input->post('client_contact_no');
        $clientid = $this->input->post('client_id');
        $branchid = $this->input->post('branch_id');

        $noexists = $this->mdl_clients->findphoneno($phoneno,$clientid,$branchid);
        if(count($noexists) > 0)
        {
            $response = array('success' => 1);

        }else{
            $response = array ('success' => 0);
        }
        echo json_encode($response);
    }

}