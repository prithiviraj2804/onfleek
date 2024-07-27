<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Sessions extends CI_Model
{
    
    public function auth($email, $password,$access_type)
    {
        $this->db->where('user_email', $email);
		$this->db->where('user_type', $access_type);
        $query = $this->db->get('ip_users');

        if ($query->num_rows()) {
            $user = $query->row();

            if($user->user_id != "" && $user->user_type != 1 && $user->user_type != 2){
                $this->db->select('to_date,from_date');
                $this->db->from('mech_subscription_details');
                $this->db->where('workshop_id', $user->workshop_id);
                $this->db->where('plan_status', 'A');
                $date = $this->db->get()->row();
                if(date('Y-m-d') > $date->to_date || date('Y-m-d') < $date->from_date){
                    $this->session->set_flashdata('alert_error', trans('user_expired'));
                    redirect('sessions/login');
                    return false;
                }
            }

            $this->load->library('crypt');

            /**
             * Password hashing changed after 1.2.0
             * Check to see if user has logged in since the password change
             */
            if (!$user->user_psalt) {
                /**
                 * The user has not logged in, so we're going to attempt to
                 * update their record with the updated hash
                 */
                if (md5($password) == $user->user_password) {
                    /**
                     * The md5 login validated - let's update this user
                     * to the new hash
                     */
                    $salt = $this->crypt->salt();
                    $hash = $this->crypt->generate_password($password, $salt);

                    $db_array = array(
                        'user_psalt' => $salt,
                        'user_password' => $hash
                    );

                    $this->db->where('user_id', $user->user_id);
                    $this->db->update('ip_users', $db_array);

                    $this->db->where('user_email', $email);
					$this->db->where('user_type', $access_type);
                    $user = $this->db->get('ip_users')->row();
                } else {
                    /**
                     * The password didn't verify against original md5
                     */
                    return false;
                }
            }

            if ($this->crypt->check_password($user->user_password, $password)) {

                if($user->user_id){
                    $this->db->where('user_id', $user->user_id);
                    $this->db->update('ip_users', array('last_login' => date('Y-m-d H:m:s')));
                }
                if($user->user_type == 6){
                    $this->db->select('user_branch_id');
                    $this->db->where('workshop_id', $user->workshop_id);
                    $this->db->where('employee_id', $user->emp_id);
                    $user_branch_id = $this->db->get('mech_employee')->row()->user_branch_id;
                    $user_branch_id = explode(',', $user_branch_id);
                }else{
                    $user_branch_id = array();
                }
                
            	$this->db->select('plan_type,workshop_name,workshop_logo,service_cost_setup,is_mobileapp_enabled,workshop_is_enabled_inventory,workshop_is_enabled_jobsheet');
				$this->db->where('workshop_id', $user->workshop_id);
                $workshop = $this->db->get('workshop_setup')->row();
                
                $this->db->select('branch_city,display_board_name,branch_state,branch_country,default_currency_id,default_date_id,is_product');
				$this->db->where('w_branch_id', $user->branch_id);
                $branch = $this->db->get('workshop_branch_details')->row();
                if($branch->default_currency_id){
                    $this->db->select('cry_iso_code,cry_digit');
				    $this->db->where('currency_id', $branch->default_currency_id);
                    $currency = $this->db->get('mech_currency_list')->row();
                }else{
                    $currency = '';
                }
                if($branch->default_date_id){
                    $this->db->select('date_formate_lable,php_date_format');
				    $this->db->where('mech_date_id', $branch->default_date_id);
                    $default_date_format = $this->db->get('mech_date_list')->row();
                }else{
                    $default_date_format = '';
                }
                $to_date = '';
                $session_data = array(
                    'emp_id' => $user->emp_id,
                    'user_type' => $user->user_type,
                    'expiry_date' => $to_date,
                    'user_id' => $user->user_id,
                    'user_name' => $user->user_name,
                    'work_shop_id' => $user->workshop_id,
                    'branch_id' => $user->branch_id,
                    'user_branch_id' => $user_branch_id,
                    'user_email' => $user->user_email,
                    'user_company' => $user->user_company,
                    'plan_type' => $workshop->plan_type,
                    'workshop_name' => $workshop->workshop_name,
                    'workshop_logo' => $workshop->workshop_logo,
                    'is_mobileapp_enabled' => $workshop->is_mobileapp_enabled,
                    'workshop_is_enabled_inventory' => $workshop->workshop_is_enabled_inventory,
                    'workshop_is_enabled_jobsheet' => $workshop->workshop_is_enabled_jobsheet,
                    'user_language' => isset($user->user_language) ? $user->user_language : 'system',
                    'is_new_user' => $user->is_new_user,
                    'display_name' => $branch->display_board_name,
                    'default_date_id' => $branch->default_date_id,
                    'default_date_format' => $default_date_format->date_formate_lable?$default_date_format->date_formate_lable:'dd/mm/yyyy',
                    'default_php_date_format' => $default_date_format->php_date_format?$default_date_format->php_date_format:'d/m/Y',
                    'service_cost_setup' => $workshop->service_cost_setup,
                    'default_city_id' => $branch->branch_city,
                    'default_state_id' => $branch->branch_state,
                    'default_country_id' => $branch->branch_country,
                    'default_currency_id' => $branch->default_currency_id,
                    'default_currency_code' => $currency->cry_iso_code,
                    'default_currency_digit' => $currency->cry_digit,
                    'is_shift' => $branch->shift,
                );
                $this->session->set_userdata($session_data);
                $notification_setup = $this->db->query('SELECT * FROM mech_notification_setup as mns left join mech_notification_list mnl on mnl.mnl_id = mns.mnl_id where mns.workshop_id = '.$this->session->userdata('work_shop_id').'')->result();       
                if(count($notification_setup)>0){
                    foreach($notification_setup as $value){
                        if($value->notify_type == "E"){
                            $session_data = array(
                                $value->noti_list_name.'_E' => $value->notifi_status,
                            );
                            $this->session->set_userdata($session_data);
                            $session_data = array();
                        }else{
                            $session_data = array(
                                $value->noti_list_name.'_S' => $value->notifi_status,
                            );
                            $this->session->set_userdata($session_data);
                            $session_data = array();
                        }
                    }
                }
                return true;
            }
        }
	return false;
    }

    // forget password
    public function forgetpsw($user_email)
    {   
        $this->db->select('user_email');
        $this->db->from('ip_users');
        $this->db->where('user_email', $user_email);
        return $this->db->get()->row()->user_email;
        
    }

    public function getverificationcode($user_email,$verification_code)
    {
        return $this->db->query("SELECT otp from ip_users where user_email = '".$user_email."' AND otp = '".$verification_code."' ")->row()->otp;
    }

    public function updatenewpassword()
    {
        $db_array = array();
        if($this->input->post('password_new')){
            $this->load->library('crypt');
            $user_psalt = $this->crypt->salt();
            $db_array['user_psalt'] = $user_psalt;
            $db_array['user_password'] = $this->crypt->generate_password($this->input->post('password_new'), $user_psalt);
            $this->db->where('user_email',$this->input->post('user_email'));
            $this->db->update('ip_users',$db_array);
            $response = array(
                'success' => 1, 
                'msg' => ""
            );
            return $response;
         }else{
            $response = array(
                'success' => 0, 
                'msg' => $this->input->post('user_email')." Is Invalid"
            );
             return $response;
         }
       
    }
    
}