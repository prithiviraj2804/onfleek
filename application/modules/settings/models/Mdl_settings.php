<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

//require_once APPPATH . 'textlocal.class.php';

class Mdl_Settings extends CI_Model
{
    public $settings = array();

    /**
     * @param $key
     * @param $value
     */
    public function save($key, $value)
    {
        $db_array = array(
            'setting_key' => $key,
            'setting_value' => $value,
        );

        if ($this->get($key) !== null) {
            $this->db->where('setting_key', $key);
            $this->db->update('ip_settings', $db_array);
        } else {
            $this->db->insert('ip_settings', $db_array);
        }
    }

    /**
     * @param $key
     */
    public function get($key)
    {
        $this->db->select('setting_value');
        $this->db->where('setting_key', $key);
        $query = $this->db->get('ip_settings');

        if ($query->row()) {
            return $query->row()->setting_value;
        } else {
            return null;
        }
    }

    /**
     * @param $key
     */
    public function delete($key)
    {
        $this->db->where('setting_key', $key);
        $this->db->delete('ip_settings');
    }

    public function load_settings()
    {
        $ip_settings = $this->db->get('ip_settings')->result();

        foreach ($ip_settings as $data) {
            $this->settings[$data->setting_key] = $data->setting_value;
        }
    }

    /**
     * @param $key
     * @param string $default
     *
     * @return mixed|string
     */
    public function setting($key, $default = '')
    {
        return (isset($this->settings[$key])) ? $this->settings[$key] : $default;
    }

    /**
     * @param string $key
     *
     * @return mixed|string
     */
    public function gateway_settings($key)
    {
        return $this->db->like('setting_key', 'gateway_'.strtolower($key), 'after')->get('ip_settings')->result();
    }

    /**
     * @param $key
     * @param $value
     */
    public function set_setting($key, $value)
    {
        $this->settings[$key] = $value;
    }

    /**
     * Returns all available themes.
     *
     * @return array
     */
    public function get_themes()
    {
        $this->load->helper('directory');

        $found_folders = directory_map(THEME_FOLDER, 1);

        $themes = [];

        foreach ($found_folders as $theme) {
            if ($theme == 'core') {
                continue;
            }

            // Get the theme info file
            $theme = str_replace('/', '', $theme);
            $info_path = THEME_FOLDER.$theme.'/';
            $info_file = $theme.'.theme';

            if (file_exists($info_path.$info_file)) {
                $theme_info = new \Dotenv\Dotenv($info_path, $info_file);
                $theme_info->overload();
                $themes[$theme] = env('TITLE');
            }
        }

        return $themes;
    }

    public function get_invoice_number($invoice_group_id)
    {
        $this->load->model('mech_invoice_groups/mdl_mech_invoice_groups');
        return $this->mdl_mech_invoice_groups->generate_invoice_number($invoice_group_id);
    }
    
    public function get_superadmin_invoice_number($invoice_group_id, $set_next = true)
    {
        $invoice_group = $this->db->query("SELECT  * FROM admin_invoice_groups WHERE invoice_group_id = '" .$invoice_group_id. "'")->row();
                         
        $invoice_identifier = $this->parse_identifier_format(
            $invoice_group->invoice_group_identifier_format,
            $invoice_group->invoice_group_next_id,
            $invoice_group->invoice_group_left_pad
        );

        if ($set_next) {
            $this->set_admin_next_invoice_number($invoice_group_id);
        }

        return $invoice_identifier;
    }

    public function set_admin_next_invoice_number($invoice_group_id)
    {
        $this->db->where('invoice_group_id', $invoice_group_id);
        $this->db->set('invoice_group_next_id', 'invoice_group_next_id+1', false);
        $this->db->update('admin_invoice_groups');
    }

    private function parse_identifier_format($identifier_format, $next_id, $left_pad)
    {
        if (preg_match_all('/{{{([^{|}]*)}}}/', $identifier_format, $template_vars)) {
            foreach ($template_vars[1] as $var) {
                switch ($var) {
                    case 'year':
                        $replace = date('Y');
                        break;
                    case 'month':
                        $replace = date('m');
                        break;
                    case 'day':
                        $replace = date('d');
                        break;
                    case 'id':
                        $replace = str_pad($next_id, $left_pad, '0', STR_PAD_LEFT);
                        break;
                    default:
                        $replace = '';
                }

                $identifier_format = str_replace('{{{' . $var . '}}}', $replace, $identifier_format);
            }
        }

        return $identifier_format;
    }


    public function getquote_book_no($type = null)
    {
        $this->load->model('mech_invoice_groups/mdl_mech_invoice_groups');
        $number = $this->mdl_mech_invoice_groups->where('module_type', $type)->where('workshop_id', $this->session->userdata('work_shop_id'))->where('w_branch_id', $this->session->userdata('branch_id'))->where('status', 'A')->get()->row();
        if ($number) {
            return $number->invoice_group_id;
        } else {
            return 0;
        }
    }

    public function get_the_current_url()
    {
        $protocol = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http');
        $base_url = $protocol.'://'.$_SERVER['HTTP_HOST'];
        $complete_url = $base_url.$_SERVER['REQUEST_URI'];

        return $complete_url;
    }

    public function generate_mobile_otp($mobile_no, $otp)
    {
        // echo $mobile_no."===".$to."===".$otp;
        //$subject = "Otp for Mechmen";
        $txt = $otp." is your dynamic access code for MechPoint";
        // $txt = $otp.' is your OTP for MechPoint. This OTP is valid for 120 second, Do not share this OTP with anyone for security reasons. We look forward to serving you';
        //$headers = "From: support@mechmen.com" . "\r\n" .
        //  "CC: kcsimbu@gmail.com";

        //mail($to,$subject,$txt,$headers);
        $response = send_sms($mobile_no, $txt);

        return $response->status;
    }

    public function getStateList($country_id = null)
    {
        return $this->db->select('*')->from('mech_state_list')->where('country_id', $country_id)->get()->result();
    }

    public function getCityList($state_id = null)
    {
        return $this->db->select('*')->from('city_lookup')->where('state_id', $state_id)->get()->result();
    }
    
    public function getStateName($state_id = null,$country_id = null)
    {
        return $this->db->select('state_name')->from('mech_state_list')->where('state_id', $state_id)->where('country_id', $country_id)->get()->row()->state_name;
    }
    
    public function getCityName($city_id = null,$state_id = null)
    {
        return $this->db->select('city_name')->from('city_lookup')->where('city_id', $city_id)->where('state_id', $state_id)->get()->row()->city_name;
    }
    
    public function getCountryName($country_id = null)
    {
        return $this->db->select('name')->from('country_lookup')->where('id', $country_id)->get()->row()->name;
    }

    public function calculate_referral_points($entity_id = NULL){
        $data = 0;
        if(!empty($entity_id)){
            $data = 1;
            // Session Variables
            $work_shop_id = $this->session->userdata('work_shop_id');
            $branch_id = $this->session->userdata('branch_id');
            // Get Customer or Employee Details with entity type

            $this->db->select("client_id,total_rewards_point,branch_id,refered_by_type,refered_by_id");	
            $this->db->from('mech_clients');
            $this->db->where('client_id', $entity_id);
            $this->db->where('workshop_id', $work_shop_id);
            $customer_detail = $this->db->get()->row();

            // Customer Details
            //print_r($customer_detail);

            // Check Customer Detail is Exist or Not
            if(!empty($customer_detail)){

                // Check the customer branch and referral branch are same and check for referral details
                if($customer_detail->branch_id){

                    // Get that branch details 
                    $this->db->select("w_branch_id,referral,referral_amount");	
                    $this->db->from('workshop_branch_details');
                    $this->db->where('w_branch_id', $customer_detail->branch_id);
                    $this->db->where('workshop_id', $work_shop_id);
                    $branch_detail = $this->db->get()->row();

                    // Branch Details
                    //print_r($branch_detail);

                    // Check the branch detail exist or Not
                    if(!empty($branch_detail)){

                        // Check this branch has enabled referral or Not
                        if($branch_detail->referral == 'Y'){
                            $this->db->select("mrefh_id,branch_id,cusreffCheckBox,cus_ref_type,cus_ref_pt,cus_red_pt,empreffCheckBox,emp_ref_type,emp_ref_pt,emp_red_pt");	
                            $this->db->from('mech_referral_dlts');
                            $this->db->where('branch_id', $branch_detail->w_branch_id);
                            $this->db->where('workshop_id', $work_shop_id);
                            $this->db->where('status', 'A');
                            $referral_detail = $this->db->get()->row();

                            // Referral Details
                            //print_r($referral_detail);

                            //Customer referred Functionality
                            $entity_tpe = NULL;
                            $total_rewards_point = 0;

                            if($customer_detail->refered_by_type == 1){
                                // if customer is referred a customer come inside to this condition.

                                 //Check Customer referral is Enabled or not
                                $cus_from_points = NULL; // Customer From points
                                $cus_to_points = NULL; // Customer To points
                                if($referral_detail->cusreffCheckBox == 'Y'){
                                    if($referral_detail->cus_ref_type == 'P'){
                                        $cus_from_points = $referral_detail->cus_ref_pt * $branch_detail->referral_amount;
                                        $cus_to_points = $referral_detail->cus_red_pt * $branch_detail->referral_amount;
                                    }else if($referral_detail->cus_ref_type == 'R'){
                                        $cus_from_points = ($referral_detail->cus_ref_pt * $branch_detail->referral_amount) / 100;
                                        $cus_to_points = ($referral_detail->cus_red_pt * $branch_detail->referral_amount) / 100;
                                    }else if($referral_detail->cus_ref_type == 'A'){
                                        $cus_from_points = $branch_detail->referral_amount;
                                        $cus_to_points = $branch_detail->referral_amount;
                                    }

                                    // Update the referral point to the new customer and the customer who referred.
                                    $client_array = array(
                                        'total_rewards_point' => ($customer_detail->total_rewards_point + $cus_to_points),
                                        'is_new_customer' => 'N',
                                    );
                                    $this->db->where('client_id', $entity_id);
                                    $cus_id = $this->db->update('mech_clients', $client_array);

                                    // Customer referred History
                                    $referral_history = array(
                                        'referrar_id' => $entity_id,
                                        'entity_id' => $entity_id,
                                        'entity_type' => 'C',
                                        'old_amount' => $customer_detail->total_rewards_point,
                                        'referral_amount' => $cus_to_points,
                                        'total_current_amount' => ($customer_detail->total_rewards_point + $cus_to_points),
                                        'created_on' => date('Y-m-d H:i:s'),
                                        'created_by' => $this->session->userdata('user_id'),
                                        'modified_by' => $this->session->userdata('user_id'),
                                    );
                                    $referral_history_id = $this->db->insert('mech_referral_history', $referral_history);
                                    
                                    // New Customer referreal Over

                                    //New Customer Referre Starting
                                    if($customer_detail->refered_by_id){
                                        $this->db->select("total_rewards_point");	
                                        $this->db->from('mech_clients');
                                        $this->db->where('client_id', $customer_detail->refered_by_id);
                                        $this->db->where('workshop_id', $work_shop_id);
                                        $total_rewards_point = $this->db->get()->row()->total_rewards_point;
                                        $cus_array = array(
                                            'total_rewards_point' => ($total_rewards_point + $cus_from_points),
                                        );
                                        $this->db->where('client_id', $customer_detail->refered_by_id);
                                        $up_id = $this->db->update('mech_clients', $cus_array);
                                        
                                        // Customer referred History
                                        $referral_history1 = array(
                                            'referrar_id' => $entity_id,
                                            'entity_id' => $customer_detail->refered_by_id,
                                            'entity_type' => 'C',
                                            'old_amount' => $total_rewards_point,
                                            'referral_amount' => $cus_from_points,
                                            'total_current_amount' => ($total_rewards_point + $cus_from_points),
                                            'created_on' => date('Y-m-d H:i:s'),
                                            'created_by' => $this->session->userdata('user_id'),
                                            'modified_by' => $this->session->userdata('user_id'),
                                        );
                                        $referral_history_id1 = $this->db->insert('mech_referral_history', $referral_history1);
                                    }
                                }
                                // Customer referral over

                            }else if($customer_detail->refered_by_type == 2){

                                // If customer is referred a employee

                                 //Check Employee referral is Enabled or not
                                $emp_from_points = NULL; // Employee referrer points
                                $emp_to_points = NULL; // Employee referred points
                                if($referral_detail->empreffCheckBox == 'Y'){

                                    if($referral_detail->emp_ref_type == 'P'){
                                        $emp_from_points = $referral_detail->emp_ref_pt * $branch_detail->referral_amount;
                                        $emp_to_points = $referral_detail->emp_red_pt * $branch_detail->referral_amount;
                                    }else if($referral_detail->cus_ref_type == 'R'){
                                        $emp_from_points = ($referral_detail->emp_ref_pt * $branch_detail->referral_amount) / 100;
                                        $emp_to_points = ($referral_detail->emp_red_pt * $branch_detail->referral_amount) / 100;
                                    }else if($referral_detail->cus_ref_type == 'A'){
                                        $emp_from_points = $branch_detail->referral_amount;
                                        $emp_to_points = $branch_detail->referral_amount;
                                    }

                                    // Update the referral point to the new customer and the customer who referred.
                                    $client_array = array(
                                        'total_rewards_point' => ($customer_detail->total_rewards_point + $emp_to_points),
                                        'is_new_customer' => 'N',
                                    );
                                    $this->db->where('client_id', $entity_id);
                                    $cus_id = $this->db->update('mech_clients', $client_array);

                                    
                                    // Customer referred History
                                    $referral_history = array(
                                        'referrar_id' => $entity_id,
                                        'entity_id' => $entity_id,
                                        'entity_type' => 'C',
                                        'old_amount' => $customer_detail->total_rewards_point,
                                        'referral_amount' => $emp_to_points,
                                        'total_current_amount' => ($customer_detail->total_rewards_point + $emp_to_points),
                                        'created_on' => date('Y-m-d H:i:s'),
                                        'created_by' => $this->session->userdata('user_id'),
                                        'modified_by' => $this->session->userdata('user_id'),
                                    );
                                    $referral_history_id = $this->db->insert('mech_referral_history', $referral_history);
                                    

                                    $this->db->select("total_rewards_point");	
                                    $this->db->from('mech_employee');
                                    $this->db->where('employee_id', $customer_detail->refered_by_id);
                                    $this->db->where('workshop_id', $work_shop_id);
                                    $total_rewards_point = $this->db->get()->row()->total_rewards_point;
                                    $emp_array = array(
                                        'total_rewards_point' => ($total_rewards_point + $emp_from_points),
                                    );
                                    $this->db->where('employee_id', $customer_detail->refered_by_id);
                                    $up_id = $this->db->update('mech_employee', $emp_array);

                                    // Employee referred History
                                    $referral_history1 = array(
                                        'referrar_id' => $entity_id,
                                        'entity_id' => $customer_detail->refered_by_id,
                                        'entity_type' => 'E',
                                        'old_amount' => $total_rewards_point,
                                        'referral_amount' => $emp_from_points,
                                        'total_current_amount' => ($total_rewards_point + $emp_from_points),
                                        'created_on' => date('Y-m-d H:i:s'),
                                        'created_by' => $this->session->userdata('user_id'),
                                        'modified_by' => $this->session->userdata('user_id'),
                                    );
                                    $referral_history_id = $this->db->insert('mech_referral_history', $referral_history1);
                                }    
                            }else if($customer_detail->refered_by_type == '0'){
                                //Check Customer referral is Enabled or not
                                $cus_to_points = NULL; // Customer To points
                                if($referral_detail->cusreffCheckBox == 'Y'){
                                    if($referral_detail->cus_ref_type == 'P'){
                                         $cus_to_points = $referral_detail->cus_red_pt * $branch_detail->referral_amount;
                                    }else if($referral_detail->cus_ref_type == 'R'){
                                         $cus_to_points = ($referral_detail->cus_red_pt * $branch_detail->referral_amount) / 100;
                                    }else if($referral_detail->cus_ref_type == 'A'){
                                         $cus_to_points = $branch_detail->referral_amount;
                                    }
 
                                    // Update the referral point to the new customer and the customer who referred.
                                    $client_array = array(
                                        'total_rewards_point' => ($customer_detail->total_rewards_point + $cus_to_points),
                                        'is_new_customer' => 'N',
                                    );
                                    $this->db->where('client_id', $entity_id);
                                    $cus_id = $this->db->update('mech_clients', $client_array);
 
                                    // Customer referred History
                                    $referral_history = array(
                                        'referrar_id' => $entity_id,
                                        'entity_id' => $entity_id,
                                        'entity_type' => 'C',
                                        'old_amount' => $customer_detail->total_rewards_point,
                                        'referral_amount' => $cus_to_points,
                                        'total_current_amount' => ($customer_detail->total_rewards_point + $cus_to_points),
                                        'created_on' => date('Y-m-d H:i:s'),
                                        'created_by' => $this->session->userdata('user_id'),
                                        'modified_by' => $this->session->userdata('user_id'),
                                    );
                                    $referral_history_id = $this->db->insert('mech_referral_history', $referral_history);
                                }
                            }      
                        }
                    }
                }
            }
        }
        return $data;
    }

public function currencychanger($currencycode='NULL')
{

    if($currencycode == "INR")
    {
        return "&#8377";
    }
    else
    {
        return "";
    }

}

    // public function calculate_referral_point($customer_id = NULL)
    // {
    //     $work_shop_id = $this->session->userdata('work_shop_id');
    //     $branch_id = $this->session->userdata('branch_id');
        
    //     $this->db->select("is_new_customer,total_rewards_point,refered_by_type,refered_by_id,rid");	
    //     $this->db->from('mech_clients');
    //     $this->db->where('client_id', $customer_id);
    //     $this->db->where('workshop_id', $work_shop_id);
    //     $customer_detail = $this->db->get()->row();

    //     if(!empty($customer_detail)){
    //         if($customer_detail->branch_id){
    //             $this->db->select("w_branch_id,referral,referral_amount");	
    //             $this->db->from('workshop_branch_details');
    //             $this->db->where('w_branch_id', $customer_detail->branch_id);
    //             $this->db->where('workshop_id', $work_shop_id);
    //             $referral_branch = $this->db->get()->row();
    //             if($referral_branch->referral == 'Y'){
    //                 if($customer_detail->rid == $rewards_detail->rid){
    //                     $client_array = array(
    //                         'total_rewards_point' => ($customer_detail->total_rewards_point + $rewards_detail->referrer_point),
    //                         'is_new_customer' => 'N',
    //                     );
    //                     $this->db->where('client_id', $customer_id);
    //                     $cus_id = $this->db->update('mech_clients', $client_array);
    //                     if($this->input->post('refered_by_type') == '1'){
    //                         $this->db->select("total_rewards_point");	
    //                         $this->db->from('mech_employee');
    //                         $this->db->where('employee_id', $this->input->post('refered_by_id'));
    //                         $this->db->where('workshop_id', $work_shop_id);
    //                         $emp_total_rewards_point = $this->db->get()->row()->total_rewards_point;
    //                         $emp_array = array(
    //                             'total_rewards_point' => ($emp_total_rewards_point + $rewards_detail->referrer_point),
    //                         );
    //                         $this->db->where('employee_id', $this->input->post('refered_by_id'));
    //                         $up_id = $this->db->update('mech_employee', $emp_array);
    //                     }else if($this->input->post('refered_by_type') == '3'){
    //                         $this->db->select("total_rewards_point");	
    //                         $this->db->from('mech_clients');
    //                         $this->db->where('client_id', $this->input->post('refered_by_id'));
    //                         $this->db->where('workshop_id', $work_shop_id);
    //                         $cus_total_rewards_point = $this->db->get()->row()->total_rewards_point;
    //                         $cus_array = array(
    //                             'total_rewards_point' => ($cus_total_rewards_point + $rewards_detail->referrer_point),
    //                         );
    //                         $this->db->where('client_id', $this->input->post('refered_by_id'));
    //                         $up_id = $this->db->update('mech_clients', $cus_array);
    //                     }
    //                     return 1;
    //                 }else{
    //                     return 0;
    //                 }
    //             }else{
    //                 return 0;
    //             }
                
    //         }else{
    //             return 0;
    //         }
    //     }else{
    //         return 0;
    //     }
    // }
}