<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Login
 */
class Login extends Base_Controller
{
	public function __construct()
    {
        parent::__construct();
		 if($this->session->userdata('user_id') != ''){
        	redirect('dashboard');
        }

    }
    public function index()
    {
    	$data=array();
		
    	 if ($this->input->post('btn_login')) {
    	 	
    	 	$mobile_no = htmlspecialchars($this->input->post('mobile_no'));
    	 	$otp = htmlspecialchars($this->input->post('otp'));
			
			if ($mobile_no=="") {
            	$data['mobile_no_empty'] = "Phone number is empty";
            }
			
			if ($otp=="") {
            	$data['otp_empty'] = "OTP is empty";
            }
			
            $this->db->where('mobile_no', $mobile_no);
            $query = $this->db->get('mech_user');
            $user = $query->row();
			

            // Check if the user exists
            if (count($user) < 1) {
            	$data['user_not_found'] = "Phone number is not registered";
            }else {
				// Check if the user is marked as active
                if ($user->status == 2) {
                	$data['user_inactive'] = trans('loginalert_user_inactive');
                } else {
                	if($otp == $user->otp){
                		$session_data = array(
		                    'user_type' => $user->user_type,
		                    'user_id' => $user->user_id,
		                    'user_name' => $user->name,
		                    'user_email' => $user->email_id,
		                    'mobile_no' => $user->mobile_no
		                    //'user_language' => isset($user->user_language) ? $user->user_language : 'system',
		                );

                $this->session->set_userdata($session_data);
				redirect('dashboard');
                	}else {
                    	$data['login_credentials_incorrect'] = trans('loginalert_credentials_incorrect');
                    }
				}

            }

        }
		$this->load->view('index', $data); 
    }
    /**
     * @param $email_address
     * @param $password
     * @return bool
     */
    public function authenticate($mobile_no, $otp)
    {
        $this->load->model('sessions/mdl_sessions');

        if ($this->mdl_sessions->auth($mobile_no, $otp)) {
            return true;
        }

        return false;
    }
}
