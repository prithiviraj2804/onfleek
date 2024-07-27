<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Ajax
 */
class Ajax extends Base_Controller
{
    public $ajax_controller = true;

    public function generate_mobile_otp()
    {
    	$this->load->model('users/mdl_users'); 
    	$mobile_no = $this->input->post('mobile_no');
		$user_details = json_decode($this->mdl_users->select_user($mobile_no,'signup'));
		$message = $user_details->action;
		$user_email = $user_details->result->email_id;
		//print_r($user_details);
		if ($message == 'old') {
			$otp = rand(1000,9999);
			$account_type = 'old';
            $db_array = array(
                'otp' => $otp,
                'otp_session_time' => date("Y-m-d H:i:s")
            ); 
             $this->db->where('mobile_no', $mobile_no);
             $this->db->update('mech_user', $db_array);
			 
			 //$param = array('mobile_no'=>$mobile_no,'otp'=>$otp,'user_email'=>$user_email);
			 //$this->load->library('background_service'); 	
			 //exit;

			 $txt = $otp." is your dynamic access code for MechPoint";

			 $sms = send_sms($mobile_no,$txt);

			  if($sms->status == "success"){
                    $db_sms_array = array(
                        'user_id' => $user_details->user_id,
                        'name' => $user_details->user_name,
                        'email_id' => $user_details->user_email,
                        'mobile_number' => $mobile_no,
                        'message' => $txt,
                        'type' => 3,
                        'status' => 'S',
                        'created_on' => date('Y-m-d H:m:s')
                    ); 
                }else{
                    $db_sms_array = array(
                        'user_id' => $user_details->user_id,
                        'name' => $user_details->user_name,
                        'email_id' => $user_details->user_email,
                        'mobile_number' => $mobile_no,
                        'message' => $txt,
                        'type' => 3,
                        'status' => 'F',
                        'created_on' => date('Y-m-d H:m:s')
                    ); 
                }

                $this->db->insert('tc_sms_log', $db_sms_array);

			 //$this->mdl_settings->generate_mobile_otp($mobile_no,$user_email,$otp);
			 //exit();
			 //$this->background_service->do_in_background(base_url()."index.php/settings/send_login_signup_otp", $param);
       
		$response = array('success' => '1'); 
		}else{
		$response = array('success' => '0'); 
		}
		echo json_encode($response);
    }

	public function login()
	{
			$mobile_no = htmlspecialchars($this->input->post('mobile_no'));
    	 	$otp = htmlspecialchars($this->input->post('otp'));
			
			$this->db->where('mobile_no', $mobile_no);
            $query = $this->db->get('mech_user');
            $user = $query->row();
			

            // Check if the user exists
            if (count($user) < 1) {
            	$data = array('success'=>0, 'msg'=>'Phone number is not registered');
            	
            }else {
				// Check if the user is marked as active
                if ($user->status == 2) {
                	$data = array('success'=>0, 'msg'=>trans('loginalert_user_inactive'));
                } else {
                	if($otp == $user->otp){
                		
						$db_array = array(
		                	'otp'=>''
		            	); 
			             $this->db->where('mobile_no', $mobile_no);
			             $this->db->update('mech_user', $db_array);
						 
						 
                		$session_data = array(
		                    'user_type' => $user->user_type,
		                    'user_id' => $user->user_id,
		                    'user_name' => $user->name,
		                    'user_email' => $user->email_id,
		                    'mobile_no' => $user->mobile_no
		                    //'user_language' => isset($user->user_language) ? $user->user_language : 'system',
		                );

                $this->session->set_userdata($session_data);
				$data = array('success'=>1, 'msg'=>'success');
                	}else {
                		$data = array('success'=>0, 'msg'=>'Invalid OTP');
                    }
				}

            }
			echo json_encode($data);
	}
    //public function test_mail()
    //{
    //    $this->load->helper('mailer');
    //    email_invoice(1, 'MechPoint', 'denys@denv.it', 'denys@denv.it', 'Test', 'Some text');
    //}

}
