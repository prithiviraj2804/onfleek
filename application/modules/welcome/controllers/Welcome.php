<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * Class Welcome
 */
class Welcome extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this -> load -> library('session');
		$this -> load -> helper('url');
		$this->load->model('settings/mdl_settings');
	}

	public function index() {
		$this -> load -> view('welcome');
	}
	public function features() {
		$this -> load -> view('features');
	}
	public function about() {
		$this -> load -> view('about');
	}
	public function pricing() {
		$this -> load -> view('pricing');
	}
	
	public function privacy_policy() {
		$this -> load -> view('common/privacy_policy');
	}
	public function terms_conditions() {
		$this -> load -> view('common/terms_conditions');
	}
	
	public function faq() {
		$this -> load -> view('faq/index');
	}
	
	public function contact($status = '') {
		$data = array('type'=>$status);
		$this -> load -> view('contactus', $data);
	}
	public function send_contact_mailer1(){
		print_r('saasdasdsa');
		exit();
		$this->load->helper('mailer');
		$this->load->helper('mailer/phpmailer');
		$name = $this->input->post('name');
		$phone = $this->input->post('phone');
		$date = $this->input->post('date');
		

		if ($name=="") {
            	$data['user_name_empty'] = trans('user_name_empty');
				$data['type']='errors';
        }

		if(strlen((string) $phone)!=10){
				$data['phone_error'] = trans('Please Enter Correct Phone Number');
				$data['type']='errors';
		}
		
		if (strlen((string)$date)!=8) {
        	$data['date_error'] = trans('Please Enter Correct Date');
			$data['type']='errors';
		}
            if(empty($data)){
			echo "first";
				$message =  $this->input->post('message');
				$user_email = 'kcsimbu@gmail.com';
				$to_email = 'kcsimbu@gmail.com';
				$bcc = 'kcsimbu@gmail.com';
				if (mailer_configured()) {
					echo "second";
		             	if (!phpmail_send($user_email, $to_email, 'Contact Us - Application', $message, '', '', $bcc)) {
		             			echo "third";
		             		$email_failed = true;
		             		log_message('error', $this->email->print_debugger());
		             	}
		             
		             } else {
		             	echo "four";
		             	$this->load->library('email');
		             
		             	// Set email configuration
		             	$config['mailtype'] = 'html';
		             	$this->email->initialize($config);
		             echo "five";
		             	// Set the email params
		             	$this->email->from($user_email);
		             	$this->email->to($to_email);
		             	$this->email->subject('Contact Us - Application');
		             	$this->email->message($message);
		             
		             	// Send the reset email
		             	if (!$this->email->send()) {
		             		echo "six";
		             		$email_failed = true;
		             		log_message('error', $this->email->print_debugger());
		             	}
		             }
		
		             // Redirect back to the login screen with an alert
		             if (isset($email_failed)) {
		             	$status=2;
		             	$this->session->set_flashdata('alert_error', ('password_reset_failed'));
		             } else {
		             	$status=1;
		             	$this->session->set_flashdata('alert_success', ('email_successfully_sent'));
		             }
					 $data=array('name'=>$name,'date'=>$date,'phone_number'=>$phone,'comments'=>$message,'status'=>$status);
					 $this->db->insert('mech_contact_form', $data);
					// exit();
		            redirect('contact/success');
			
			}else{
				$this->load->view('contact/index', $data);
			}
		
	}
	public function send_contact_mailer(){
		$this->load->helper('mailer');
		$this->load->helper('mailer/phpmailer');
		$name = $this->input->post('name');
		$phone = $this->input->post('phone');
		$user_email = $this->input->post('email');
		$subject = $this->input->post('subject');
		$message = $this->input->post('message');

		if ($name=="") {
            	$data['user_name_empty'] = trans('user_name_empty');
				$data['type']='errors';
            	
            }

		if(strlen((string) $phone)!=10){
				$data['phone_error'] = trans('Please Enter Correct Phone Number');
				$data['type']='errors';
			}
		
			if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            	$data['email_error'] = trans('Please Enter Correct Email Address');
				$data['type']='errors';
				
            }
            
            if ($subject=="") {
            	$data['subject_empty'] = trans('subject_empty');
				$data['type']='errors';
            	
            }
			if ($message=="") {
            	$data['message_empty'] = trans('message_empty');
				$data['type']='errors';
            	
            }
			if(empty($data)){
			echo "first";
				
				$to_email = 'kcsimbu@gmail.com';
				//$bcc = 'kcsimbu@gmail.com';
				if (mailer_configured()) {
					echo "second";
		             	if (!phpmail_send($user_email, $to_email, $subject, $message, '', '', $bcc)) {
		             			echo "third";
		             		$email_failed = true;
		             		log_message('error', $this->email->print_debugger());
		             	}
		             
		             } else {
		             	echo "four";
		             	$this->load->library('email');
		             
		             	// Set email configuration
		             	$config['mailtype'] = 'html';
		             	$this->email->initialize($config);
		             echo "five";
		             	// Set the email params
		             	$this->email->from($user_email);
		             	$this->email->to($to_email);
		             	$this->email->subject($subject);
		             	$this->email->message($message);
		             
		             	// Send the reset email
		             	if (!$this->email->send()) {
		             		echo "six";
		             		$email_failed = true;
		             		log_message('error', $this->email->print_debugger());
		             	}
		             }
		
		             // Redirect back to the login screen with an alert
		             if (isset($email_failed)) {
		             	$status=2;
		             	$this->session->set_flashdata('alert_error', ('email_failed'));
		             } else {
		             	$status=1;
		             	$this->session->set_flashdata('alert_success', ('email_successfully_sent'));
		             }
					 $data=array('name'=>$name,'email_id'=>$user_email,'phone_number'=>$phone,'subject'=>$subject,'comments'=>$message,'status'=>$status);
					 $this->db->insert('mech_contact_form', $data);
					
		            redirect('contact/success');
			
			}else{
				$this->load->view('contactus', $data);
			}
		
	}
}
