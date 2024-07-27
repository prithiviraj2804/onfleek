<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;


    public function __construct()
    {
        parent::__construct();
        $this->load->model('mech_employee/mdl_mech_employee');
        $this->load->model('employee_role/mdl_employee_role');
        $this->load->model('mech_employee/mdl_mech_employee_experience');
        $this->load->model('mech_employee/mdl_mech_custom_table');
        $this->load->model('users/mdl_users');
        $this->load->helper('settings_helper');
        $this->load->model('settings/mdl_settings');
        $this->load->model('sessions/mdl_sessions');
    }

    public function checkEmployeeEmail(){
        $check = $this->mdl_mech_employee->checkEmployeeEmailId();
        if($check){
            $response = array(
                'success' => 1,
                'label' => 'email_id',
                'error_msg' => 'Email Already Exist',
            );
        }else{
            $response = array(
                'success' => 0
            );
        }
        echo json_encode($response);
    }

    public function add_employee_role(){
        $this->layout->load_view('mech_employee/modal_add_employee_role');
    }

    public function checkEmployeeMobile(){
        $check = $this->mdl_mech_employee->checkEmployeeMobile();
        if($check){
            $response = array(
                'success' => 1,
                'label' => 'mobile_no',
                'error_msg' => 'Mobile Number Already Exist',
            );
        }else{
            $response = array(
                'success' => 0
            );
        }
        echo json_encode($response);
    }

    function twotablephonenoexist()
    {
        $mob_no = $this->input->post('user_mobile');

        $checkemployeephone = $this->mdl_mech_employee->checkemployeephone($mob_no);
        $checkuserphone = $this->mdl_users->checkipuserMobile($mob_no);

        if(count($checkemployeephone) > 0)
        {
            $response = array('success' => 1);

        }else if(count($checkuserphone) > 0){
            $response = array ('success' => 1);
        }else{
            $response = array ('success' => 0);

        }
        echo json_encode($response);
    }

    function twotableemailexist()
    {
        $email = $this->input->post('user_email');

        $checkemployeeemail = $this->mdl_mech_employee->checkemployeeemail($email);
        $checkuseremail = $this->mdl_users->checkipuseremail($email);

        if(count($checkemployeeemail) > 0)
        {
            $response = array('success' => 1);

        }else if(count($checkuseremail) > 0){
            $response = array ('success' => 1);
        }else{
            $response = array ('success' => 0);

        }
        echo json_encode($response);
    }


    public function create()
    {
        $btn_submit = $this->input->post('btn_submit');
        $action_from = ($this->input->post('action_from'))?$this->input->post('action_from'):'';
        $employee_id = $this->input->post('employee_id');
        $branch_id_select = $this->input->post('branch_id');

        if($this->input->post('email_id')){
            $checkEmail = $this->mdl_mech_employee->checkEmployeeEmailId();
            if($checkEmail){
                $response = array(
                    'success' => '2',
                    'error_msg' => 'Email Already Exist',
                    'label' => 'email_id'
                );
                echo json_encode($response);
                exit();
            }
        }
        
        if($this->input->post('mobile_no')){
            $checkMobile = $this->mdl_mech_employee->checkEmployeeMobile();
            if($checkMobile){
                $response = array(
                    'success' => '2',
                    'error_msg' => 'Mobile Number Already Exist',
                    'label' => 'mobile_no'
                );
                echo json_encode($response);
                exit();
            }
        }

        if ($this->mdl_mech_employee->run_validation()) {

            $employee_group_no = $this->input->post('employee_no');
			
			if(empty($employee_group_no)){
                $employee_no = $this->mdl_settings->get_invoice_number($this->input->post('invoice_group_id'));
                $_POST['employee_no'] = $employee_no;
			}

            $employee_id = $this->mdl_mech_employee->save($employee_id);
            if(empty($action_from)){
                $employee_detail = $this->mdl_mech_employee->where('employee_id', $employee_id)->get()->result_array();
                $employee_list = $this->mdl_mech_employee->get()->result_array();
            }else{
                $employee_detail = '';
                $employee_list = array();
            }
            
            $response = array(
                'success' => 1,
                'employee_detail' => $employee_detail,
                'employee_id' => $employee_id,
                'employee_list' => $employee_list,
                'btn_submit' => $btn_submit,
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
         
    public function delete_employee(){
        
        $this->load->model('mech_employee/mdl_mech_employee'); 
        $employee_id = $this->input->post('employee_id');
        
        $employee_id = $this->mdl_mech_employee->delete_employee($employee_id);

        if($employee_id)
        {
            $response = array('success' => 1);

        }else{
            $response = array ('success' => 0);
        }
        echo json_encode($response);
    }

    
    public function get_employee_list($cus_id = null)
    {
        $work_shop_id = $this->session->userdata('work_shop_id');
        $result = $this->mdl_mech_employee->where('employee_status=1')->where('mech_employee.workshop_id='.$work_shop_id)->get()->result();
        echo json_encode($result);
        exit();
    }

    public function model_add_skill($employee_id, $model_from = null)
    {
        if ($employee_id) {
            $this->db->select('*');
            $this->db->from('mech_automotive_skills');
            $this->db->where('status', 'A');
            $skill_list = $this->db->get()->result();

            $this->db->select('skill_ids');
            $this->db->from('mech_employee');
            $this->db->where('employee_id', $employee_id);
            $skill_ids = $this->db->get()->row()->skill_ids;
        }
        $data = array(
            'skill_ids' => $skill_ids,
            'model_from' => $model_from,
            'employee_id' => $employee_id,
            'skill_list' => $skill_list,
        );

        $this->layout->load_view('mech_employee/modal_add_skill', $data);
    }

    public function addskill()
    {
        $employee_id = $this->input->post('employee_id');
        if (!empty($employee_id)) {
            $this->db->set('modified_by', $this->session->userdata('user_id'));
            $this->db->set('skill_ids', implode(',', $this->input->post('skill_ids')));
            $this->db->where('employee_id', $employee_id);
            $this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
            $this->db->where('w_branch_id', $this->session->userdata('branch_id'));
            $updated_id = $this->db->update('mech_employee');
        }

        if ($updated_id > 0) {
            $response = array(
                'success' => 1,
            );
        } else {
            $response = array(
                'success' => 0,
            );
        }
        echo json_encode($response);
    }

    public function model_add_experience($employee_id, $model_from = null,$experience_id)
    {   
        $this->load->module('layout');     
        if ($experience_id) {

            $this->db->select('*');
            $this->db->from('mech_employee_experience');
            $this->db->where('employee_id', $employee_id);
            $this->db->where('employee_experience_id', $experience_id);
            $employee_experience_detail = $this->db->get()->row();

            // print_r($employee_experience_detail);
            // exit(); 

            if($employee_experience_detail->customer_country){
                $state_list = $this->db->query('SELECT * FROM mech_state_list where country_id = '.$employee_experience_detail->customer_country)->result();
            }else{
                $state_list = array();
            }
            
            if($employee_experience_detail->customer_state){
                $city_list = $this->db->query('SELECT * FROM city_lookup where state_id = '.$employee_experience_detail->customer_state)->result();
            }else{
                $city_list = array();
            }

        } else {

            $employee_experience_detail = array();
            $state_list = $this->db->query('SELECT * FROM mech_state_list')->result();
            $city_list = $this->db->query('SELECT * FROM city_lookup')->result();

        }     

        $data = array(
            'model_from' => $model_from,
            'employee_id' => $employee_id,
            'country_list' => $this->db->query('SELECT * FROM country_lookup')->result(),
            'city_list' => $city_list,
            'state_list' => $state_list,
            'employees_role' => $this->mdl_employee_role->where('status', 'A')->get()->result(),
            'employee_experience_detail' => $employee_experience_detail,
        );

        $this->layout->load_view('mech_employee/modal_add_experience', $data);
    }


    public function addexperience()
    {    
        $employee_id = $this->input->post('employee_id');
        $employee_experience_id = $this->input->post('employee_experience_id');

        if ($this->mdl_mech_employee_experience->run_validation()) {
            $employee_experience_id = $this->mdl_mech_employee_experience->save($employee_experience_id);
            
            $response = array(
                'success' => 1,
                'employee_experience_id' => $employee_experience_id,
                'employee_id' => $employee_id,
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
    
    public function saveCustomData(){             

        $customDataArray = json_decode($this->input->post('customArray'));
        $entity_id = $this->input->post('entity_id');
        $entity_type = $this->input->post('entity_type');
        $workshop_id = $this->session->userdata('work_shop_id');
        $w_branch_id = $this->session->userdata('branch_id');
        
        $insert_array = array();
        $update_array = array();

        foreach ($customDataArray as $key => $value){
            if($value->custom_id != 'null' && $value->custom_id != ''){
                $update_array[] = array(
                    'custom_id' => $value->custom_id,
                    'column_name' => $value->column_name,
                    'column_value' => $value->column_value,
                    'column_from' => $value->column_from,
                    'column_to' => $value->column_to,
                    'entity_id' => $entity_id,
                    'entity_type' => $entity_type,
                    'workshop_id' => $workshop_id,
                    'w_branch_id' => $w_branch_id,
                    'created_by' => $this->session->userdata('user_id'),
                    'modified_by' => $this->session->userdata('user_id')
                );
            }else{
                if($value->column_name != '' && $value->column_name != 'null'){
                    $insert_array[] = array(
                        'custom_id' => null,
                        'column_name' => $value->column_name,
                        'column_value' => $value->column_value,
                        'column_from' => $value->column_from,
                        'column_to' => $value->column_to,
                        'entity_id' => $entity_id,
                        'entity_type' => $entity_type,
                        'workshop_id' => $workshop_id,
                        'w_branch_id' => $w_branch_id,
                        'created_on' => date('Y-m-d'),
                        'created_by' => $this->session->userdata('user_id'),
                        'modified_by' => $this->session->userdata('user_id')
                    );
                }
            }
        }

        if(count($insert_array) > 0){
            $this->db->insert_batch('mech_custom_table', $insert_array);    
        }
        
        if(count($update_array) > 0){
            $this->db->update_batch('mech_custom_table', $update_array,'custom_id');    
        }
        
        $result = $this->mdl_mech_custom_table->getEntityCustomList($entity_id,$entity_type);
        
        if($result){
            $response = array(
                'success' => 1,
                'EntityCustomList' => $result
            );
        }else{
            $response = array(
                'success' => 0
            );
        }
        
        echo json_encode($response);
    }

    public function deleteCustomData(){
        
        $custom_id = $this->input->post('custom_id');

        $this->db->set('custom_status',0);
        $this->db->where('custom_id',$custom_id);
        $this->db->update('mech_custom_table');

        $response = array(
            'success' => 1
        );

        echo json_encode($response);
    }

    public function updateEmployeeUserDetails(){

        $employee_account_checkbox = htmlspecialchars($this->input->post('employee_account_checkbox'));
        $employee_id = $this->input->post('emp_id');
        $employee_id = $this->mdl_mech_employee->save($employee_id, array('employee_account_checkbox' => $this->input->post('employee_account_checkbox'),'user_branch_id' => implode(',', $this->input->post('user_branch_id'))));
        if($employee_account_checkbox != 1 ){
            $result = $this->mdl_mech_employee->deactivateEmployeeUserAccount($employee_id);
            $response = array(
                'success' => 1,
                'employee_id' => $employee_id
            );
        }else{
            $permissionArray = json_decode($this->input->post('permissionArray'));
            foreach($permissionArray as $moduleList){
                $dbarray = array(
                    'status' => $moduleList->status?$moduleList->status:0
                );
                $this->db->where('module_id' , $moduleList->module_id);
                $this->db->where('permission_id' , $moduleList->permission_id);
                $this->db->update('mech_module_permission',$dbarray);
            }
            $response = array(
                'success' => 1,
                'employee_id' => $employee_id
            );
        }

        echo json_encode($response);
		exit();
        
    }

    public function submit_signup()
	{
        $this->load->model('users/mdl_users');
        $this->load->helper('mailer');
        $this->load->helper('mailer/phpmailer');

        $data = array();
        $employee_id = $this->input->post('emp_id');
        $otp = htmlspecialchars($this->input->post('otp'));
        $user_name = htmlspecialchars($this->input->post('user_name'));
        $user_email = htmlspecialchars($this->input->post('user_email'));
        $user_mobile = htmlspecialchars($this->input->post('user_mobile'));
        $password = htmlspecialchars($this->input->post('user_password'));
        $confirm_password = htmlspecialchars($this->input->post('user_passwordv'));
        $employee_account_checkbox = htmlspecialchars($this->input->post('employee_account_checkbox'));
        $user_branch_id = $this->input->post('user_branch_id');
        $branch_id = $this->input->post('branch_id');
        
        $this->db->where('user_email', $user_email);
        $query = $this->db->get('ip_users');
        $userEmail = $query->row();

        $this->db->where('user_mobile', $user_mobile);
		$query = $this->db->get('ip_users');
        $user = $query->row();

        if (empty($userEmail)) {
        	$data['error_msg'] = trans('loginalert_user_found');
		} 
		
        if(empty($user)){
        	$data['error_msg'] = 'Phone number is not registered';
        }
        
        if(empty($user_name)){
        	$data['error_msg'] = 'User Name is empty';
        }

        if($password != $confirm_password){
            $data['error_msg'] = 'Password Mismatch';
        }

        // Check if the user exists
        if(count($data) > 0){
			$data = array('success'=>'0', 'error'=>$data);
			echo json_encode($data);
			exit();
		}else {
            
            $employee_id = $this->input->post('emp_id');
            $user_email = htmlspecialchars($this->input->post('user_email'));
            $user_mobile = htmlspecialchars($this->input->post('user_mobile'));

            $this->db->set('mobile_no',$user_mobile);
            $this->db->set('email_id',$user_email);
            $this->db->where('employee_id', $employee_id);
            $this->db->update('mech_employee');

            if($otp == $user->otp){
                if ($this->mdl_users->run_validation('signup_update_rules')) {
                    $user_id = $this->mdl_users->save($user->user_id);

                    $db_arrays = array(
                        'user_type' => 6,
                        'user_active' => 1,
                        'workshop_id' => $this->session->userdata('work_shop_id'),
                        'branch_id' => $branch_id,
                        'otp' => $otp,
                        'otp_session_time' => date("Y-m-d H:i:s"),
                        'is_new_user' =>'O',
                    ); 
                    $this->db->where('user_id', $user_id);
                    $this->db->update('ip_users', $db_arrays);

                    $employee_id = $this->mdl_mech_employee->save($employee_id, array('employee_account_checkbox' => $this->input->post('employee_account_checkbox'),'user_branch_id' => implode(',', $this->input->post('user_branch_id'))));
                    $permissionArray = json_decode($this->input->post('permissionArray'));
                    foreach($permissionArray as $moduleList){
                        $dbarray = array(
                            'workshop_id' => $this->session->userdata('work_shop_id'),
                            'module_id' => $moduleList->module_id,
                            'user_id' => $user->user_id,
                            'status' => $moduleList->status?$moduleList->status:0
                        );
                        $this->db->insert('mech_module_permission',$dbarray);
                    }
                
                    // Mail To Customer

                    $to = $user_email;
                    $subject = $this->input->post ('user_name'). ", Welcome to MechToolz";
                    $message = $this->load->view('emails/welcome_signup', array(
                            'user_email' => $user_email,
                            'name' => $this->input->post ('user_name'),
                            'plan' => 'Trial',
                            'start_date' => $startDate,
                            'end_date' => $endDate,
                    ), true);
                    $email_from = 'customerservice@' . preg_replace("/^[\w]{2,6}:\/\/([\w\d\.\-]+).*$/", "$1", base_url());
                    $email_from_name = 'From: MechPoint <'.$email_from.'>';

                    $tos = "kcsimbu@gmail.com";
                    $bcc = "kcsimbu@gmail.com";
                    $subjects = "New user registered";
                    $messages = "Username = ".$this->input->post('user_name')." mobile =".$this->input->post('user_mobile')." email_id =".$this->input->post('user_email');
                    
                    // Mail the invoice with the pre-configured mailer if possible
                    
                    $this->load->library('email');
                    
                    // Set email configuration
                    $config['mailtype'] = 'html';
                    $this->email->initialize($config);

                    if (mailer_configured()) {
        
                        if (!email_notification($invoice_id = null, $pdf_template = null, $from, $to, $subject, $message, $cc , $bcc, $attachment_files = null)) {
                            $email_failed = true;
                            log_message('error', $this->email->print_debugger());
                        }

                    } else {
                        // Set the email params
                        $this->email->from($email_from_name);
                        $this->email->to($user_email);
                        $this->email->subject(trans('confirm_mail'));
                        $this->email->message($email_message);
                        // Send the reset email
                        if (!$this->email->send()) {
                            $email_failed = true;
                            log_message('error', $this->email->print_debugger());
                        }
                    }

                    $data = array(
                        'success' => 1, 
                        'msg' => 'success',
                        'employee_id' => $employee_id,
                        'workshop_id' => $this->session->userdata('work_shop_id')
                    );

		        }else{

                    $this->load->helper('json_error');

                    $data = array(
                        'success' => 0,
                        'validation_errors' => json_errors()
                    );
                    
                }
                
            }else{

                $data = array('success'=>0, 'msg'=>'Invalid OTP');

            }

        }

		echo json_encode($data);
	}

    public function generate_signup_otp(){

        $this->load->model('users/mdl_users');
        $this->load->helper('mailer');
        $this->load->helper('mailer/phpmailer');

        $data = array();
        $employee_id = htmlspecialchars($this->input->post('employee_id'));
        $employee_account_checkbox = htmlspecialchars($this->input->post('employee_account_checkbox'));
		$mobile_no = htmlspecialchars($this->input->post('user_mobile'));
        $user_email = htmlspecialchars($this->input->post('user_email'));
        $user_branch_id = $this->input->post('user_branch_id')?htmlspecialchars($this->input->post('user_branch_id')):NULL;
        $branch_id = htmlspecialchars($this->input->post('branch_id'));
        $password = htmlspecialchars($this->input->post('user_password'));
        $confirm_password = htmlspecialchars($this->input->post('user_passwordv'));

        if($password != $confirm_password){
            $data['error_msg'] = 'Password Mismatch.';
            $datas = array('success'=>'0', 'error'=>$data);
			echo json_encode($datas);
			exit();
        }

        $checkuserphone = $this->mdl_users->checkipuserMobile($mobile_no);
        if($checkuserphone){
            $data['error_msg'] = 'Mobile Number Already Exist';
            $datas = array('success'=>'0', 'error'=>$data);
			echo json_encode($datas);
			exit();
        }

        $checkuseremail = $this->mdl_users->checkipuseremail($user_email);
        if($checkuseremail){
            $data['error_msg'] = 'Email Already Exist';
            $datas = array('success'=>'0', 'error'=>$data);
			echo json_encode($datas);
			exit();
        }


        $this->db->where('user_email', $user_email);
        $query = $this->db->get('ip_users');
        $db_email = $query->row()->user_email;

		$this->db->where('user_mobile', $mobile_no);
        $query = $this->db->get('ip_users');
        $db_mobile = $query->row()->user_mobile;

        // Check user email and mobile number exist or not
        if(!empty($db_email) || !empty($db_mobile)){
            if($db_mobile == $mobile_no){
                $this->db->where('user_mobile', $mobile_no);
                $query = $this->db->get('ip_users');
                $user_details = $query->row();
            }else if($db_email == $user_email){
                $this->db->where('user_mobile', $user_email);
                $query = $this->db->get('ip_users');
                $user_details = $query->row();
            }

            if((($user_details->user_mobile == $mobile_no) && ($user->user_active != 1)) || (($user_details->user_email == $db_email) && ($user->user_active != 1))){
                if($this->mdl_users->run_validation('signup_rules')) {
                    $user_id = $this->mdl_users->save($user_details->user_id);
                    $otp = rand(1000,9999);
                    $db_array = array(
                        'user_email' => $user_email,
                        'otp' => $otp,
                        'otp_session_time' => date("Y-m-d H:i:s"),
                        'is_new_user' =>'O',
                    ); 
                    $this->db->where('user_id', $user_id);
                    $this->db->update('ip_users', $db_array);

                    $txt = "$otp is your dynamic access code for Mechtool";
                    $sms = send_sms($mobile_no,$txt);

                    if($sms->status == "success"){
                        $db_sms_array = array(
                            'user_id' => $user_id,
                            'name' => $user_name,
                            'email_id' => $user_email,
                            'mobile_number' => $mobile_no,
                            'message' => $txt,
                            'type' => 3,
                            'status' => 'S',
                            'created_on' => date('Y-m-d H:m:s')
                        ); 
                    }else{
                        $db_sms_array = array(
                            'user_id' => $user_id,
                            'name' => $user_name,
                            'email_id' => $user_email,
                            'mobile_number' => $mobile_no,
                            'message' => $txt,
                            'type' => 3,
                            'status' => 'F',
                            'created_on' => date('Y-m-d H:m:s')
                        ); 
                    }

                    $this->db->insert('tc_sms_log', $db_sms_array);

                    if (mailer_configured()) {
                        $to = $user_email;
                        $subject = "Mechtoolz Verification Code";
                        $message = $this->load->view('emails/otp', array(
                            'user_email' => htmlspecialchars($this->input->post('user_email')),
                            'name' => htmlspecialchars($this->input->post('user_name')),
                            'otp' => $otp
                        ), true);

                        if (!email_notification($invoice_id = null, $pdf_template = null, $from, $to, $subject, $message, $cc = null, $bcc = null, $attachment_files = null)) {
                            $email_failed = true;
                            log_message('error', $this->email->print_debugger());
                        }
                    
                    } else {
                        $this->load->library('email');
                    
                        // Set email configuration
                        $config['mailtype'] = 'html';
                        $this->email->initialize($config);
                    
                        // Set the email params
                        $this->email->from($email_from_name);
                        $this->email->to($user_email);
                        $this->email->subject(trans('confirm_mail'));
                        $this->email->message($email_message);
                    
                        // Send the reset email
                        if (!$this->email->send()) {
                            $email_failed = true;
                            log_message('error', $this->email->print_debugger());
                        }
                    }

                    $response = array(
                        'success' => '1'
                    );

                }else{
                    echo "validation_error";
                    $this->load->helper('json_error');
                    $response = array(
                        'success' => 0,
                        'validation_errors' => json_errors()
                    );
                }
                echo json_encode($response);
                exit();
            }else{
                $data['error_msg'] = trans('loginalert_user_found');
                $datas = array('success'=>'0', 'error'=>$data);
                echo json_encode($datas);
                exit();
            }   
        }else{

            $this->db->where('user_mobile', $mobile_no);
            $query = $this->db->get('ip_users');
            $data = $query->row();
            if(empty($data)){
                if ($this->mdl_users->run_validation('signup_rules')) {
                    $user_id = $this->mdl_users->save();
                    $otp = rand(1000,9999);
                    $db_array = array(
                        'user_type' => 6,
                        'user_active' => 1,
                        'workshop_id' => $this->session->userdata('work_shop_id'),
                        'branch_id' => $branch_id,
                        'user_email' => $user_email,
                        'otp' => $otp,
                        'otp_session_time' => date("Y-m-d H:i:s"),
                        'is_new_user' =>'O',
                    ); 
                    $this->db->where('user_id', $user_id);
                    $this->db->update('ip_users', $db_array);

                    $txt = "$otp is your dynamic access code for Mechtool";
                    $sms = send_sms($mobile_no,$txt);

                    if($sms->status == "success"){
                        $db_sms_array = array(
                            'user_id' => $user_id,
                            'name' => $user_name,
                            'email_id' => $user_email,
                            'mobile_number' => $mobile_no,
                            'message' => $txt,
                            'type' => 3,
                            'status' => 'S',
                            'created_on' => date('Y-m-d H:m:s')
                        ); 
                    }else{
                        $db_sms_array = array(
                            'user_id' => $user_id,
                            'name' => $user_name,
                            'email_id' => $user_email,
                            'mobile_number' => $mobile_no,
                            'message' => $txt,
                            'type' => 3,
                            'status' => 'F',
                            'created_on' => date('Y-m-d H:m:s')
                        ); 
                    }

                    $this->db->insert('tc_sms_log', $db_sms_array);

                    if (mailer_configured()) {
                        $to = $user_email;
                        $subject = "Mechtoolz Verification Code";
                        $message = $this->load->view('emails/otp', array(
                            'user_email' => htmlspecialchars($this->input->post('user_email')),
                            'name' => htmlspecialchars($this->input->post('user_name')),
                            'otp' => $otp
                        ), true);

                        if (!email_notification($invoice_id = null, $pdf_template = null, $from, $to, $subject, $message, $cc = null, $bcc = null, $attachment_files = null)) {
                            $email_failed = true;
                            log_message('error', $this->email->print_debugger());
                        }
                    
                    } else {
                        $this->load->library('email');
                        // Set email configuration
                        $config['mailtype'] = 'html';
                        $this->email->initialize($config);
                        // Set the email params
                        $this->email->from($email_from_name);
                        $this->email->to($user_email);
                        $this->email->subject(trans('confirm_mail'));
                        $this->email->message($email_message);
                        // Send the reset email
                        if (!$this->email->send()) {
                            $email_failed = true;
                            log_message('error', $this->email->print_debugger());
                        }
                    }
                    $response = array(
                        'success' => '1'
                    ); 

                }else{
                    $this->load->helper('json_error');
                    $response = array(
                        'success' => 0,
                        'validation_errors' => json_errors()
                    );
                }
		    }else{
			    $response = array('success'=>'0', 'error'=>$data);
		    }
		    echo json_encode($response);
		}
    }

    public function resendotp(){

        $mobile_no = htmlspecialchars($this->input->post('user_mobile'));
        $user_email = htmlspecialchars($this->input->post('user_email'));
        
		$this->db->where('user_email', $user_email);
        $query = $this->db->get('ip_users');
        $user = $query->row();

		$this->db->where('user_mobile', $mobile_no);
        $query_mob = $this->db->get('ip_users');
        $user_mobile = $query_mob->row();

        if (empty($user)) {
        	$data['error_msg'] = trans('loginalert_user_found');
		} 
        $mobile_no = htmlspecialchars($this->input->post('user_mobile'));

        if(empty($user_mobile)){
        	$data['error_msg'] = 'Mobile No. already exists.';
        }

		if(count($data) > 0){
			$data = array('success'=>'0', 'error'=>$data);
			echo json_encode($data);
			exit();
		}else{
            $otp = rand(1000,9999);
            $db_array = array(
                'otp' => $otp,
            ); 
            $this->db->where('user_id', $user->user_id);
            $this->db->update('ip_users', $db_array);
            $txt = "$otp is your dynamic access code for Mechtool";
            $sms = send_sms($mobile_no,$txt);

            if($sms->status == "success"){
                $db_sms_array = array(
                    'user_id' => $user->user_id,
                    'name' => $user->user_name,
                    'email_id' => $user_email,
                    'mobile_number' => $mobile_no,
                    'message' => $txt,
                    'type' => 3,
                    'status' => 'S',
                    'created_on' => date('Y-m-d H:m:s')
                ); 
            }else{
                $db_sms_array = array(
                    'user_id' => $user->user_id,
                    'name' => $user->user_name,
                    'email_id' => $user_email,
                    'mobile_number' => $mobile_no,
                    'message' => $txt,
                    'type' => 3,
                    'status' => 'F',
                    'created_on' => date('Y-m-d H:m:s')
                ); 
            }
            $this->db->insert('tc_sms_log', $db_sms_array);

            $response = array('success' => '1'); 
            echo json_encode($response);
        }
    }
    
    public function get_filter_list(){

        $this->load->model('mech_employee/mdl_mech_employee');
        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;
        if($this->input->post('branch_id')){
            $this->mdl_mech_employee->where('mech_employee.branch_id', trim($this->input->post('branch_id')));
        }
        if($this->input->post('employee_no')){
            $this->mdl_mech_employee->like('mech_employee.employee_no', trim($this->input->post('employee_no')));
        }
        if($this->input->post('employee_name')){
            $this->mdl_mech_employee->like('mech_employee.employee_name', trim($this->input->post('employee_name')));
        }
        if($this->input->post('employee_number')){
            $this->mdl_mech_employee->like('mech_employee.employee_number', trim($this->input->post('employee_number')));
        }
        if($this->input->post('employee_role')){
            $this->mdl_mech_employee->where('mech_employee.employee_role', trim($this->input->post('employee_role')));
        }
        $rowCount = $this->mdl_mech_employee->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        if($this->input->post('branch_id')){
            $this->mdl_mech_employee->where('mech_employee.branch_id', trim($this->input->post('branch_id')));
        }
        if($this->input->post('employee_no')){
            $this->mdl_mech_employee->like('mech_employee.employee_no', trim($this->input->post('employee_no')));
        }
        if($this->input->post('employee_name')){
            $this->mdl_mech_employee->like('mech_employee.employee_name', trim($this->input->post('employee_name')));
        }
        if($this->input->post('employee_number')){
            $this->mdl_mech_employee->like('mech_employee.employee_number', trim($this->input->post('employee_number')));
        }
        if($this->input->post('employee_role')){
            $this->mdl_mech_employee->where('mech_employee.employee_role', trim($this->input->post('employee_role')));
        }
        $this->mdl_mech_employee->limit($limit,$start);
        $employees = $this->mdl_mech_employee->get()->result();           

        $response = array(
            'success' => 1,
            'employees' => $employees, 
            'createLinks' => $createLinks
        );
        echo json_encode($response);
    }
    
}
