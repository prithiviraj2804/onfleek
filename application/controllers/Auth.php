<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Auth
 */

require_once APPPATH . 'libraries/REST_Controller.php';

class Auth extends REST_Controller
{
	
	public function __construct()
    {
        parent::__construct();
		$this->load->helper('settings');
		$this->load->model('users/mdl_users'); 
    }
    
    public function authenticate($email_address, $password)
    {
        $this->load->model('sessions/mdl_sessions');
		if ($this->mdl_sessions->auth($email_address, $password)) {
            return true;
        }
		return false;
    } 

    public function send_otp_post(){
            $this->load->model('settings/mdl_settings'); 
            $this->load->model('clients/mdl_clients'); 
            // $this->load->model('referral/Mdl_user_referral');
            // $this->load->model('referral/Mdl_user_referral_confirm');
        
            $json = file_get_contents('php://input');
            $obj = json_decode($json, TRUE);
            
            $user_mobile = htmlspecialchars($obj['mobile_no']);
            $workshop_id = htmlspecialchars($obj['workshop_id']);
            $device_token = htmlspecialchars($obj['device_token']);
            
            // $user_details = json_decode($this->mdl_users->select_user($user_mobile,'signup'));
            // $message = $user_details->action;
            //$user_email = $user_details->result->email_id;
            if($user_mobile != '' && $device_token != '') {
                $otp = rand(1000,9999);
                $txt = $otp." is your dynamic access code for MechPoint";
                $sms = send_sms($user_mobile,$txt);
                $user_details = json_decode($this->mdl_clients->user_signup($user_mobile,$otp,$device_token, $workshop_id));
                if($user_details->mdl_status == "success"){
                    $param=array('mobile_no'=>$user_mobile,'otp'=>$otp);
                    //$this->background_service->do_in_background(base_url()."index.php/settings/send_login_signup_otp", $param);
                    $response = array(
                        'api_status' => '1',
                        'msg' => 'success',
                        'mobile_no' => $user_mobile,
                        'user_entry_type' => $user_details->user_entry_type
                    );
                }else{
                    $response = array(
                        'api_status' => '0',
                        'msg' => 'Something went wrong, Please try again',
                        'mobile_no' => $user_mobile,
                        'user_entry_type' => ''
                    );
                }
            }else{
                $response = array(
                    'api_status' => '0',
                    'msg' => 'Mobile no or device token missing',
                    'mobile_no' => $user_mobile,
                    'user_entry_type' => ''
                );	
            }
            echo json_encode($response);
    }

    public function verify_otp_post(){
        $this->load->model('clients/mdl_clients'); 
        $json = file_get_contents('php://input');
        $obj = json_decode($json, TRUE);
        
        $user_mobile = htmlspecialchars($obj['mobile_no']);
        $otp = htmlspecialchars($obj['otp']);
        
        $message = json_decode($this->mdl_clients->verify_user_otp($user_mobile, $otp));
        
        if($message){
            $response = array(
                'api_status' => 1,
                'client_id' => $message->client_id,
                'message' => $message->status,
                'mobile_no' => $user_mobile,
                'client_data' => $message->client_data
            );                      
            echo json_encode($response);
        }else{
            $response = array(
                'api_status' => 0,
                'client_id' => '',
                'message' => 'Something went wrong, please try agian',
                'mobile_no' => $user_mobile,
                'client_data' => array()
            );                      
            echo json_encode($response);
        }  
    } 

    public function update_user_detail_post(){
        $this->load->model('clients/mdl_clients'); 
        $json = file_get_contents('php://input');
        $obj = json_decode($json, TRUE);
        $client_id = htmlspecialchars($obj['id']);
        $user_mobile = htmlspecialchars($obj['mobile_no']);
        $data = array(
			'client_name' => htmlspecialchars($obj['name']),
			'client_email_id' => htmlspecialchars($obj['email_id']),
			'city_id' => htmlspecialchars($obj['city']),
			'is_new_customer' => 'N',
			'mobile_app_status' => 'U'
        );
        $this->db->where('client_contact_no', $user_mobile);
        $this->db->where('client_id', $client_id);
        
        if($this->db->update('mech_clients', $data)){
            $user_data =  $this->db->select('client_id,client_no,customer_category_id,client_name,total_rewards_point,is_new_customer,city_id,client_email_id,client_contact_no')->get_where('mech_clients', array('client_id' => $client_id, 'client_contact_no' => $user_mobile))->row();
            $api_status  = 1;
            $message = 'success';
        }else{
            $api_status  = 0;
            $user_data = array();
            $message = 'error';
        }
        $response = array(
                'api_status' => $api_status,
                'message' => $message,
                'user_data' => $user_data
        );
        echo json_encode($response);
    } 
}