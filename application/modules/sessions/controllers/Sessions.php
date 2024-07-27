<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sessions extends Base_Controller
{
    public function index()
    {
        if(!empty($this->session->userdata('user_id'))){
            redirect('dashboard');
        }else{
            redirect('sessions/login');
        }
    }

    public function login()
    {
        
        if(!empty($this->session->userdata('user_id'))){
            if($this->session->userdata('is_new_user') == 'N'){
                redirect('workshop_setup');
            }else{
                redirect('dashboard');
            }
        }else{
            $view_data = array(
                'login_logo' => get_setting('login_logo')
            );
    
            if ($this->input->post('btn_login')) {
    
                $this->db->where('user_email', $this->input->post('email'));
                $query = $this->db->get('ip_users');
                $user = $query->row();
    
                if($user->user_id != "" && $user->user_type != 1 && $user->user_type != 2){
                    $this->db->select('from_date,to_date');
                    $this->db->from('mech_subscription_details');
                    $this->db->where('workshop_id', $user->workshop_id);
                    $this->db->where('plan_status', 'A');
                    $date = $this->db->get()->row();
                    if(date('Y-m-d') > $date->to_date || date('Y-m-d') < $date->from_date){
                        $this->session->set_flashdata('alert_error', trans('user_expired'));
                        redirect('sessions/login');
                    }
                }
    
                // Check if the user exists
                if (empty($user)) {
                    $this->session->set_flashdata('alert_error', trans('loginalert_user_not_found'));
                    redirect('sessions/login');
                } else {
    
                    // Check if the user is marked as active
                    if ($user->user_active == 0) {
                        $this->session->set_flashdata('alert_error', trans('loginalert_user_inactive'));
                        redirect('sessions/login');
                    } else {
                        if ($this->authenticate($this->input->post('email'), $this->input->post('password'), $user->user_type)) {
                            if ($this->session->userdata('user_type') == 1) {
                                redirect('dashboard');
                            } elseif ($this->session->userdata('user_type') == 2) {
                                redirect('dashboard');
                            } else if ($this->session->userdata('user_type') == 3) {
                                if($user->is_new_user == 'N'){
                                    redirect('workshop_setup');
                                }else{ 
                                    redirect('dashboard');
                                }
                            } else if ($this->session->userdata('user_type') == 4) {
                                redirect('dashboard');
                            } else if ($this->session->userdata('user_type') == 5) {
                                redirect('dashboard');
                            } else if ($this->session->userdata('user_type') == 6) {
                                redirect('dashboard');
                            }
                        } else {
                            $this->session->set_flashdata('alert_error', trans('loginalert_credentials_incorrect'));
                            redirect('sessions/login');
                        }
                    }
                }
            }
            $this->load->view('session_login', $view_data);
        }
    }

    public function signup()
    {
    	$data=array();
		$validation_array = array();
		
    	if ($this->input->post('signupform')) {
    		
    		$user_name = htmlspecialchars($this->input->post('name'));
			$mobile_no = htmlspecialchars($this->input->post('mobile_no'));
			$user_email = htmlspecialchars($this->input->post('email_id'));
			$password = htmlspecialchars($this->input->post('password'));
			
			if ($user_name=="") {
            	$data['user_name_empty'] = trans('user_name_empty');
            }
			if ($mobile_no=="") {
            	$data['user_mobile_no_empty'] = trans('user_mobile_no_empty');
            }
			if ($user_email=="") {
            	$data['user_email_id_empty'] = trans('user_email_id_empty');
            }
			
			$this->db->where('email_id', $user_email);
            $query = $this->db->get('mech_user');
            $user = $query->row();

			$this->db->where('mobile_no', $mobile_no);
            $query_mob = $this->db->get('mech_user');
            $user_mobile = $query_mob->row();
			
            // Check if the user exists
            if (!empty($user)) {
            	$data['email_exist'] = trans('loginalert_user_found');
            	
            } 
            if(!empty($user_mobile)){
            	$data['mobile_exist'] = 'Mobile No. already exists.';
            }
			
			if(empty($data)){
				if ($this->mdl_users->run_validation('signup_validation_rules')) {
	    			
	    			$id = $this->mdl_users->save();
					$referral_code =  $this->input->post('referral_code');
					if ($referral_code) {
						$this->load->model("user_referral/mdl_user_referral");
						$this->load->model("user_referral/mdl_user_referral_confirm");
						$user_data = $this->mdl_user_referral->getByReferralCode($referral_code);
						$referral_user_id = $user_data[0]['user_id'];
						$dataArray['mech_refer_id'] = $referral_user_id;
						$dataArray['mech_user_id'] = $id;
						$this->mdl_user_referral_confirm->saveReferral($dataArray);
					}
                    $token = md5(time() . $id. $user_email);             
                    $db_array = array(
                            'activate_token' => $token,
                            'is_new_user' =>'O'
                    );             
                    $this->db->where('email_id', $user_email);
                    $this->db->update('mech_user', $db_array);
                    // Send the email with reset link
                    $this->load->helper('mailer');
                    
                    // Preprare some variables for the email
                    $email_activatelink = site_url('sessions/index/' . $token);
                    $email_message = $this->load->view('emails/welcome_signup', array(
                            'activatelink' => $email_activatelink,
                            //'activateemailid' => $user_email,
                            'user_email' => $user_email,
                            'name' => $this->input->post ('name')
                    ), true);
                    $email_from = 'customerservice@' . preg_replace("/^[\w]{2,6}:\/\/([\w\d\.\-]+).*$/", "$1", base_url());
                    $email_from_name = 'From: MechPoint <'.$email_from.'>';
                    // Mail the invoice with the pre-configured mailer if possible
                    
                    if (mailer_configured()) {
                        $this->load->helper('mailer/phpmailer');
                    
                        if (!phpmail_send($email_from_name, $user_email, trans('confirm_mail'), $email_message)) {
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
                    // Redirect back to the login screen with an alert
                    if (isset($email_failed)) {
                        //$this->session->set_flashdata('alert_error', trans('password_reset_failed'));
                        $account_active_message = trans('failed');
                    } else {
                        //$this->session->set_flashdata('alert_success', trans('email_successfully_sent'));
                        $account_active_message = trans('email_successfully_sent');
                    }
			 	
			 	    array_push($validation_array, $account_active_message);
				}
			
			}
		}
	    $data['dynamic_validation'] = $validation_array;
	    $data['referral_code'] = $referral_code;
   
		$this->load->view('session_signup', $data); 
    }


    public function super_admin()
    {
        $view_data = array(
            'login_logo' => get_setting('login_logo')
        );

        if ($this->input->post('btn_login')) {

            $this->db->where('user_email', $this->input->post('email'));
            $query = $this->db->get('ip_users');
            $user = $query->row();

            // Check if the user exists
            if (empty($user)) {
                $this->session->set_flashdata('alert_error', trans('loginalert_user_not_found'));
                redirect('sessions/super_admin');
            } else {

                // Check if the user is marked as active
                if ($user->user_active == 0) {
                    $this->session->set_flashdata('alert_error', trans('loginalert_user_inactive'));
                    redirect('sessions/super_admin');
                } else {
                    if ($this->authenticate($this->input->post('email'), $this->input->post('password'),$this->input->post('access_type'))) {
                        if ($this->session->userdata('user_type') == 1) {
                            redirect('dashboard');
                        } elseif ($this->session->userdata('user_type') == 2) {
                            redirect('dashboard');
                        } else if ($this->session->userdata('user_type') == 3) {
                        	redirect('dashboard');
                        } else if ($this->session->userdata('user_type') == 4) {
                        	redirect('dashboard');
                        }
                    } else {
                        $this->session->set_flashdata('alert_error', trans('loginalert_credentials_incorrect'));
                        redirect('sessions/super_admin');
                    }

                }

            }

        }

        $this->load->view('session_admin_login', $view_data);
    }

    public function authenticate($email_address, $password,$access_type)
    {
        $this->load->model('mdl_sessions');

        if ($this->mdl_sessions->auth($email_address, $password,$access_type)) {
            return true;
        }

        return false;
    }

    public function logout()
    {
    	$user_type = $this->session->userdata('user_type');
        $this->session->sess_destroy();
		if($user_type == 1){
			redirect('sessions/super_admin');
		}else{
			redirect('login');
		}
    }

    public function passwordreset($token = null)
    {
        if ($token) {
            $this->db->where('user_passwordreset_token', $token);
            $user = $this->db->get('ip_users');
            $user = $user->row();

            if (empty($user)) {
                // Redirect back to the login screen with an alert
                $this->session->set_flashdata('alert_error', trans('wrong_passwordreset_token'));
                redirect('sessions/passwordreset');
            }

            $formdata = array(
                'token' => $token,
                'user_id' => $user->user_id,
            );

            return $this->load->view('session_new_password', $formdata);
        }

        // Check if the form for a new password was used
        if ($this->input->post('btn_new_password')) {
            $new_password = $this->input->post('new_password');
            $user_id = $this->input->post('user_id');

            if (empty($user_id) || empty($new_password)) {
                $this->session->set_flashdata('alert_error', trans('loginalert_no_password'));
                redirect($_SERVER['HTTP_REFERER']);
            }

            $this->load->model('users/mdl_users');

            // Check for the reset token
            $user = $this->mdl_users->get_by_id($user_id);

            if (empty($user)) {
                $this->session->set_flashdata('alert_error', trans('loginalert_user_not_found'));
                redirect($_SERVER['HTTP_REFERER']);
            }

            if (empty($user->user_passwordreset_token) || $this->input->post('token') !== $user->user_passwordreset_token) {
                $this->session->set_flashdata('alert_error', trans('loginalert_wrong_auth_code'));
                redirect($_SERVER['HTTP_REFERER']);
            }

            // Call the save_change_password() function from users model
            $this->mdl_users->save_change_password(
                $user_id, $new_password
            );

            // Update the user and set him active again
            $db_array = array(
                'user_passwordreset_token' => '',
            );

            $this->db->where('user_id', $user_id);
            $this->db->update('ip_users', $db_array);

            // Redirect back to the login form
            redirect('login');

        }

        // Check if the password reset form was used
        if ($this->input->post('btn_reset')) {
            $email = $this->input->post('email');

            if (empty($email)) {
                $this->session->set_flashdata('alert_error', trans('loginalert_user_not_found'));
                redirect($_SERVER['HTTP_REFERER']);
            }

            // Test if a user with this email exists
            if ($this->db->where('user_email', $email)) {
                // Create a passwordreset token
                $email = $this->input->post('email');
                $token = md5(time() . $email);

                // Save the token to the database and set the user to inactive
                $db_array = array(
                    'user_passwordreset_token' => $token,
                );

                $this->db->where('user_email', $email);
                $this->db->update('ip_users', $db_array);

                // Send the email with reset link
                $this->load->helper('mailer');

                // Preprare some variables for the email
                $email_resetlink = site_url('sessions/passwordreset/' . $token);
                $email_message = $this->load->view('emails/passwordreset', array(
                    'resetlink' => $email_resetlink
                ), true);

                $email_from = get_setting('smtp_mail_from');
                if (empty($email_from)) {
                    $email_from = 'system@' . preg_replace("/^[\w]{2,6}:\/\/([\w\d\.\-]+).*$/", "$1", base_url());
                }

                // Mail the invoice with the pre-configured mailer if possible
                if (mailer_configured()) {

                    $this->load->helper('mailer/phpmailer');

                    // if (!phpmail_send($email_from, $email, trans('password_reset'), $email_message)) {
                    //     $email_failed = true;
                    // }

                } else {

                    $this->load->library('email');

                    // Set email configuration
                    $config['mailtype'] = 'html';
                    $this->email->initialize($config);

                    // Set the email params
                    $this->email->from($email_from);
                    $this->email->to($email);
                    $this->email->subject(trans('password_reset'));
                    $this->email->message($email_message);

                    // Send the reset email
                    if (!$this->email->send()) {
                        $email_failed = true;
                        log_message('error', $this->email->print_debugger());
                    }
                }

                // Redirect back to the login screen with an alert
                if (isset($email_failed)) {
                    $this->session->set_flashdata('alert_error', trans('password_reset_failed'));
                } else {
                    $this->session->set_flashdata('alert_success', trans('email_successfully_sent'));
                }

                redirect('login');
            }
        }

        return $this->load->view('session_passwordreset');
    }

    public function newSignUp(){

        $this->load->model('users/mdl_users');
        $data = array();
		$user_name = htmlspecialchars($this->input->post('user_name'));
        $mobile_no = htmlspecialchars($this->input->post('user_mobile'));
        $user_email = htmlspecialchars($this->input->post('user_email'));
        $password = htmlspecialchars($this->input->post('user_password'));
        $confirm_password = htmlspecialchars($this->input->post('user_passwordv'));
        $subscription_plan = htmlspecialchars($this->input->post('subscription_plan'));
        
		$this->db->where('user_email', $user_email);
        $query = $this->db->get('ip_users');
        $user = $query->row();

		$this->db->where('user_mobile', $mobile_no);
        $query_mob = $this->db->get('ip_users');
        $user_mobile = $query_mob->row();

        if (!empty($user)) {
        	$data['msg'] = trans('loginalert_user_found');
		} 
		
        if(!empty($user_mobile)){
        	$data['msg'] = 'Mobile No. already exists.';
        }

        if($password != $confirm_password){
            $data['msg'] = 'Password Mismatch.';
        }

		if(count($data) > 0){

            $data = array(
                'success'=> 0, 
                'msg'=> $data,
            );
			echo json_encode($data);
			exit();
		}else{
           if(empty($data)){
                if ($this->mdl_users->run_validation('signup_rules')) {
                    $user_id = $this->mdl_users->save();

                    $workshoparray = array(
                        'workshop_name' => $this->input->post('user_company'),
                        'plan_type' => $this->input->post('subscription_plan'),
                        'owner_name' => htmlspecialchars($this->input->post('user_name')),
                        'workshop_contact_no' => htmlspecialchars($this->input->post('user_mobile')),
                        'workshop_email_id' => htmlspecialchars($this->input->post('user_email')),
                        'created_by' => $user_id,
                        'modified_by' => $user_id,
                        'created_on' => date('Y-m-d H-m-s'),
                    );
                    $this->db->insert('workshop_setup',$workshoparray);
                    $workshop_id = $this->db->insert_id();
        
                    $startDate = date('Y-m-d');
                    $endDate = date('Y-m-d', strtotime($startDate. ' + 30 days'));
        
                    $subscriptionArray = array(
                        'workshop_id' => $workshop_id,
                        'user_id' => $user_id,
                        'from_date' => $startDate,
                        'to_date' => $endDate,
                        'days' => 10,
                        'plan_type' => 'Trial',
                        'created_by' => $user_id,
                        'modified_by' => $user_id,
                        'created_on' => date('Y-m-d H-m-s'),
                    );
                    $this->db->insert('mech_subscription_details',$subscriptionArray);
                    $subscription_id = $this->db->insert_id();
        
                    $workshop_array = array(
                        'subscription_plan_id' => $subscription_id,
                    );
                    $this->db->where('workshop_id', $workshop_id);
                    $this->db->update('workshop_setup', $workshop_array);
        
                    $db_array = array(
                        'user_email' => htmlspecialchars($this->input->post('user_email')),
                        'user_type' => 3,
                        'otp_session_time' => date("Y-m-d H:i:s"),
                        'is_new_user' =>'N',
                        'user_active' => 1,
                        'otp'=>'',
                        'workshop_id' => $workshop_id,
                    ); 
                    $this->db->where('user_id', $user_id);
                    $this->db->update('ip_users', $db_array);
        
                    if($this->input->post('subscription_plan')){
                        if($this->input->post('subscription_plan') == 1){
                            $module_list =  $this->db->get_where('mech_category_permission_dtls', array('status' => 'A', 'category_type' => '1'))->result();
                            foreach($module_list as $moduleList){
                                $dbarray = array(
                                    'workshop_id' => $workshop_id,
                                    'module_id' => $moduleList->module_id,
                                    'status' => 1
                                );
                                $this->db->insert('mech_module_permission',$dbarray);
                            }
                        }else if($this->input->post('subscription_plan') == 2){
                            $module_list =  $this->db->get_where('mech_category_permission_dtls', array('status' => 'A', 'category_type' => '2'))->result();
                            foreach($module_list as $moduleList){
                                $dbarray = array(
                                    'workshop_id' => $workshop_id,
                                    'module_id' => $moduleList->module_id,
                                    'status' => 1
                                );
                                $this->db->insert('mech_module_permission',$dbarray);
                            }
                        }else if($this->input->post('subscription_plan') == 3){
                            $module_list =  $this->db->get_where('mech_category_permission_dtls', array('status' => 'A', 'category_type' => '3'))->result();
                            foreach($module_list as $moduleList){
                                $dbarray = array(
                                    'workshop_id' => $workshop_id,
                                    'module_id' => $moduleList->module_id,
                                    'status' => 1
                                );
                                $this->db->insert('mech_module_permission',$dbarray);
                            }
                        }
                    }

                    $session_data = array(
                        'user_type' => 3,
                        'user_id' => $user_id,
                        'user_name' => htmlspecialchars($this->input->post('user_name')),
                        'user_email' => htmlspecialchars($this->input->post('user_email')),
                        'user_mobile' => htmlspecialchars($this->input->post('user_mobile')),
                        'is_new_user' => 'N',
                        'work_shop_id' => $workshop_id,
                    );
        
                    $this->session->set_userdata($session_data);

                    $otp = rand(1000,9999);
                    $txt = $otp." is your dynamic access code for Mechtool";
			        $sms = send_sms(htmlspecialchars($this->input->post('user_mobile')),$txt);

                    if($sms->status == "success"){
                        $db_sms_array = array(
                            'user_id' => $user_id,
                            'name' => htmlspecialchars($this->input->post('user_name')),
                            'email_id' => htmlspecialchars($this->input->post('user_email')),
                            'mobile_number' => htmlspecialchars($this->input->post('user_mobile')),
                            'message' => $txt,
                            'type' => 3,
                            'status' => 'S',
                            'created_on' => date('Y-m-d H:m:s')
                        ); 
                    }else{
                        $db_sms_array = array(
                            'user_id' => $user_id,
                            'name' => htmlspecialchars($this->input->post('user_name')),
                            'email_id' => htmlspecialchars($this->input->post('user_email')),
                            'mobile_number' => htmlspecialchars($this->input->post('user_mobile')),
                            'message' => $txt,
                            'type' => 3,
                            'status' => 'F',
                            'created_on' => date('Y-m-d H:m:s')
                        ); 
                    }
                    $this->db->insert('tc_sms_log', $db_sms_array);

                    $response = array(
                        'success' => '1'
                    ); 

                    $data = array(
                        'success'=>1, 
                        'msg'=>'success',
                        'workshop_id' => $workshop_id
                    );
                }
		    }else{
                $this->load->helper('json_error');
                $data = array(
                    'success' => 0,
                    'validation_errors' => json_errors()
                );
		    }
        }
		echo json_encode($data);
    }


	public function create_user()
    {
        $this->load->model('users/mdl_users');

        $this->load->helper('country');

        if ($this->mdl_users->run_validation()) {
            $db_array = $this->mdl_users->db_array();
            $db_array['user_type'] = 1;

            $this->mdl_users->save(null, $db_array);
        }

        $this->layout->buffer('content', 'sessions/create_user');
        $this->layout->render('setup');
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

    public function generate_signup_otp()
    {
        $this->load->model('users/mdl_users');
        $this->load->helper('mailer');
        $this->load->helper('mailer/phpmailer');

        $data = array();
        $user_company = htmlspecialchars($this->input->post('user_company'));
        $user_name = htmlspecialchars($this->input->post('user_name'));
        $mobile_no = htmlspecialchars($this->input->post('user_mobile'));
        $user_email = htmlspecialchars($this->input->post('user_email'));
        $password = htmlspecialchars($this->input->post('user_password'));
        $confirm_password = htmlspecialchars($this->input->post('user_passwordv'));
        $subscription_plan = htmlspecialchars($this->input->post('subscription_plan'));

        if($password != $confirm_password){
            $data['error_msg'] = 'Password Mismatch.';
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

            if((($user_details->user_mobile == $mobile_no) && ($user_details->user_active != 1 || $user_details->user_active != '1')) || (($user_details->user_email == $db_email) && ($user_details->user_active != 1 || $user_details->user_active != '1'))){
                
                if($this->mdl_users->run_validation('signup_rules')) {
                    $user_id = $this->mdl_users->save($user_details->user_id);
                    $otp = rand(1000,9999);
                    $db_array = array(
                        'user_email' => $user_email,
                        'otp' => $otp,
                        'otp_session_time' => date("Y-m-d H:i:s"),
                        'is_new_user' =>'N',
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
                        'user_type' => 3,
                        'user_active' => 0,
                        'user_email' => $user_email,
                        'otp' => $otp,
                        'otp_session_time' => date("Y-m-d H:i:s"),
                        'is_new_user' =>'N',
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

	public function submit_signup()
	{
        $this->load->model('users/mdl_users');
        $this->load->helper('mailer');
        $this->load->helper('mailer/phpmailer');
        $data = array();

        $user_company = $this->input->post('user_company');
        $otp = htmlspecialchars($this->input->post('otp'));
        $user_name = htmlspecialchars($this->input->post('user_name'));
        $user_email = htmlspecialchars($this->input->post('user_email'));
        $user_mobile = htmlspecialchars($this->input->post('user_mobile'));
        $password = htmlspecialchars($this->input->post('user_password'));
        $confirm_password = htmlspecialchars($this->input->post('user_passwordv'));
        $subscription_plan = htmlspecialchars($this->input->post('subscription_plan'));
        
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
            if($otp == $user->otp){
                if ($this->mdl_users->run_validation('signup_update_rules')) {
                    $user_id = $this->mdl_users->save($user->user_id);

                    $workshoparray = array(
                        'workshop_name' => $this->input->post('user_company'),
                        'plan_type' => $this->input->post('subscription_plan'),
                        'owner_name' => htmlspecialchars($this->input->post('user_name')),
                        'workshop_contact_no' => htmlspecialchars($this->input->post('user_mobile')),
                        'workshop_email_id' => htmlspecialchars($this->input->post('user_email')),
                        'created_by' => $user_id,
                        'modified_by' => $user_id,
                        'created_on' => date('Y-m-d H-m-s'),
                    );
                    $this->db->insert('workshop_setup',$workshoparray);
                    $workshop_id = $this->db->insert_id();
        
                    $startDate = date('Y-m-d');
                    if($this->input->post('subscription_plan') == 1){
                        $endDate = date('Y-m-d', strtotime($startDate. ' + 30 days'));
                        $days = 30;
                    }else if($this->input->post('subscription_plan') == 2){
                        $endDate = date('Y-m-d', strtotime($startDate. ' + 30 days'));
                        $days = 30;
                    }else if($this->input->post('subscription_plan') == 3){
                        $endDate = date('Y-m-d', strtotime($startDate. ' + 30 days'));
                        $days = 30;
                    }else{
                        $endDate = date('Y-m-d', strtotime($startDate. ' + 15 days'));
                        $days = 15;
                    }
        
                    $subscriptionArray = array(
                        'workshop_id' => $workshop_id,
                        'user_id' => $user_id,
                        'from_date' => $startDate,
                        'to_date' => $endDate,
                        'days' => $days,
                        'plan_type' => 'Trial',
                        'created_by' => $user_id,
                        'modified_by' => $user_id,
                        'created_on' => date('Y-m-d H-m-s'),
                    );
                    $this->db->insert('mech_subscription_details',$subscriptionArray);
                    $subscription_id = $this->db->insert_id();
        
                    $workshop_array = array(
                        'subscription_plan_id' => $subscription_id,
                    );
                    $this->db->where('workshop_id', $workshop_id);
                    $this->db->update('workshop_setup', $workshop_array);
        
                    $db_array = array(
                        'user_company' => $this->input->post('user_company'),
                        'user_email' => htmlspecialchars($this->input->post('user_email')),
                        'user_type' => 3,
                        'otp_session_time' => date("Y-m-d H:i:s"),
                        'is_new_user' =>'N',
                        'user_active' => 0,
                        'otp'=>'',
                        'workshop_id' => $workshop_id,
                    ); 
                    $this->db->where('user_id', $user_id);
                    $this->db->update('ip_users', $db_array);
        
                    if($this->input->post('subscription_plan')){
                        if($this->input->post('subscription_plan') == 1){
                            $module_list =  $this->db->get_where('mech_category_permission_dtls', array('status' => 'A', 'category_type' => '1'))->result();
                            foreach($module_list as $moduleList){
                                $dbarray = array(
                                    'workshop_id' => $workshop_id,
                                    'module_id' => $moduleList->module_id,
                                    'user_id' => $user_id,
                                    'status' => 1
                                );
                                $this->db->insert('mech_module_permission',$dbarray);
                            }
                        }else if($this->input->post('subscription_plan') == 2){
                            $module_list =  $this->db->get_where('mech_category_permission_dtls', array('status' => 'A', 'category_type' => '2'))->result();
                            foreach($module_list as $moduleList){
                                $dbarray = array(
                                    'workshop_id' => $workshop_id,
                                    'module_id' => $moduleList->module_id,
                                    'user_id' => $user_id,
                                    'status' => 1
                                );
                                $this->db->insert('mech_module_permission',$dbarray);
                            }
                        }else if($this->input->post('subscription_plan') == 3){
                            $module_list =  $this->db->get_where('mech_category_permission_dtls', array('status' => 'A', 'category_type' => '3'))->result();
                            foreach($module_list as $moduleList){
                                $dbarray = array(
                                    'workshop_id' => $workshop_id,
                                    'module_id' => $moduleList->module_id,
                                    'user_id' => $user_id,
                                    'status' => 1
                                );
                                $this->db->insert('mech_module_permission',$dbarray);
                            }
                        }
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

                        // if (!emailtous_notification($invoice_id = null, $pdf_template = null, $from, $tos, $subjects, $messages, $cc , $bcc, $attachment_files = null)) {
                        //     $email_failed = true;
                        //     log_message('error', $this->email->print_debugger());
                        // }
                        
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

                    // $session_data = array(
                    //     'user_type' => 3,
                    //     'user_id' => $user_id,
                    //     'user_name' => htmlspecialchars($this->input->post('user_name')),
                    //     'user_email' => htmlspecialchars($this->input->post('user_email')),
                    //     'user_mobile' => htmlspecialchars($this->input->post('user_mobile')),
                    //     'is_new_user' => 'N',
                    //     'work_shop_id' => $workshop_id,
                    // );
        
                    // $this->session->set_userdata($session_data);
                    $this->session->set_flashdata('alert_success', trans('register_messsage'));
                    $response = array(
                        'success' => '1'
                    ); 

                    $data = array(
                        'success'=>1, 
                        'msg'=>'success',
                        'workshop_id' => $workshop_id
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

    // forget password //

    public function forgetpsw()
    {
        $data = array(
            'login_logo' => get_setting('login_logo')
        );
		$this->load->view('session_forgetpsw',$data);
    }

    public function forgotpassword()
	{   
    $this->load->model('mdl_sessions');
    $user_email = $this->mdl_sessions->forgetpsw($this->input->post('user_email'));
    if ($user_email) {
        $response = $this->sendpasswordtoemail($user_email);
    } else {
		$response = array(
			'success' => 0, 
			'msg' => "Entered Email Is Invalid"
		);
	}
	echo json_encode($response);
    }

    public function verificationcode()
    {   
    $this->load->model('mdl_sessions');
	$verification_code = $this->mdl_sessions->getverificationcode($this->input->post('user_email'),$this->input->post('verification_code'));
	if($verification_code == $this->input->post('verification_code')){
		$response = array(
			'success' => 4, 
			'msg' => "Verification Code Is Correct"
		);
    }else {
		$response = array(
			'success' => 5, 
			'msg' => "Verification Code Is Incorrect"
		);
	}
	echo json_encode($response);
    }

    public function updatenewpassword()
    {   
    $this->load->model('mdl_sessions');
    if ($this->input->post('password_new')){
        $response = $this->mdl_sessions->updatenewpassword();
    } else {
		$response = array(
			'success' => 0, 
			'msg' => $this->input->post('user_email')." Is Invalid"
		);
	}
	echo json_encode($response);
    }
    
    public function sendpasswordtoemail($user_email)
    {
        require FCPATH . 'vendor/phpmailer/PHPMailerLatest/src/PHPMailer.php';
        require FCPATH . 'vendor/phpmailer/PHPMailerLatest/src/SMTP.php';
        require FCPATH . 'vendor/phpmailer/PHPMailerLatest/src/Exception.php';
        require FCPATH . 'vendor/autoload.php';
        require FCPATH . 'vendor/phpmailer/PHPMailerLatest/src/class.phpmailer.php';
    
        $this->db->select('user_id,user_name,user_email,user_active');
        $this->db->from('ip_users');
        $this->db->where('user_email', $user_email);
        $user = $this->db->get()->row()->user_email;
        if(!empty($user))
        {
            $verification_code = rand(999999,100);
            $this->db->set('otp', $verification_code);
            $this->db->where('user_email', $user_email);
            $this->db->update('ip_users');
            $mail_message='Dear '.$user->user_name.','. "\r\n";
            $mail_message.='Thanks for contacting regarding to forgot password,<br> Your <b>Verifiction code is: </b>'.$verification_code.'</b>'."\r\n";
            $mail = new PHPMailer(true);
            //$mail->SMTPDebug = 4;                                 // Enable verbose debug output
            $mail->isSMTP();                                        // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                         // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                                 // Enable SMTP authentication
            $mail->Username = 'support@mechtoolz.com';            // SMTP username
            $mail->Password = 'Empiric)*';                          // SMTP password
            $mail->SMTPSecure = 'tls';                              // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                      // TCP port to connect to
        
            //Recipients
            $mail->setFrom('noreply@mechtool.com', 'Mechtool');
            $mail->addAddress($user_email);                                 // Add a recipient
        
            //Content
            $mail->IsHTML(true);
            $mail->Subject = "Verification Code";
            $mail->Body = $mail_message;
            if (!$mail->send())
            {
                $response = array(
                    'success' => 1, 
                    'msg' => "Failed to send password, please try again!"
                );
                return $response;
            } 
            else 
            { 
                $response = array(
                    'success' => 2, 
                    'msg' => "Password sent to your email!"
                );
                return $response;
            }
        } 
        else
        {
            $response = array(
                'success' => 3, 
                'msg' => "Email not found try again!"
            );
            return $response;
        }
    
    }

}