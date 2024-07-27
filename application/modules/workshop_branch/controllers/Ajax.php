<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('workshop_branch/mdl_workshop_branch');
        $this->load->model('mech_rewards/mdl_mech_rewards');
    }

    public function save_branch()
    {
        $this->load->model('workshop_setup/mdl_workshop_setup');
        $this->load->model('mech_bank_list/mdl_mech_bank_list');
        $this->load->helper('settings_helper');

        if($this->input->post('w_branch_id')){
            $branch_id = $this->input->post('w_branch_id');
        }else{
            $branch_id = NULL;
        }

        if($this->input->post('w_branch_id')){
            if($this->input->post('w_branch_id') == $this->session->userdata('branch_id')){
                $this->db->select('cry_iso_code,cry_digit');
                $this->db->where('currency_id', $this->input->post('default_currency_id'));
                $currency = $this->db->get('mech_currency_list')->row();
                if($this->input->post('default_date_id')){
                    $this->db->select('date_formate_lable,php_date_format');
				    $this->db->where('mech_date_id', $this->input->post('default_date_id'));
                    $default_date_format = $this->db->get('mech_date_list')->row();
                }else{
                    $default_date_format = '';
                }
                $session_data = array(
                    'is_shift' => $this->input->post('shift'),
                    'default_date_id' => $this->input->post('default_date_id'),
                    'default_date_format' => $default_date_format->date_formate_lable,
                    'default_php_date_format' => $default_date_format->php_date_format,
                    'default_city_id' => $this->input->post('branch_city'),
                    'default_state_id' => $this->input->post('branch_state'),
                    'default_country_id' => $this->input->post('branch_country'),
                    'default_currency_id' => $this->input->post('default_currency_id'),
                    'default_currency_code' => $currency->cry_iso_code,
                    'default_currency_digit' => $currency->cry_digit,
                    'display_name' => $this->input->post('workshop_branch_name'),
                );
                $this->session->set_userdata($session_data);
            }
        }

        if ($this->input->post('is_update') == 0 && $this->input->post('workshop_branch_name') != '') {
            $check = $this->db->get_where('ip_workshop_branch', array('workshop_branch_name' => $this->input->post('workshop_branch_name')))->result();
            if (!empty($check)) {
                $response = array(
                    'success' => 0,
                    'msg' => 'workshop_branch_already_exists'
                );
                echo json_encode($response);
                exit();
            }
        }

        $this->load->model('users/mdl_users');

        if ($this->mdl_workshop_branch->run_validation()) {
            $branch_id = $this->mdl_workshop_branch->save($branch_id);

            if ($this->input->post('is_update') == 0) {
                $temp_req = $_REQUEST;
            }

            // $temp_req = $_REQUEST;
            // $email = $temp_req['branch_email_id'];

            // // Send the email with reset link
            // $this->load->helper('mailer');
            // // Preprare some variables for the email
            // $email_message = $this->load->view('emails/branch_mail', array(
            //         'resetlink' => '1',
            //     ), true);

            // $email_from = get_setting('smtp_mail_from');
            // if (empty($email_from)) {
            //     $email_from = 'system@'.preg_replace("/^[\w]{2,6}:\/\/([\w\d\.\-]+).*$/", '$1', base_url());
            // }

            // // Mail the invoice with the pre-configured mailer if possible
            // if (mailer_configured()) {
            //     $this->load->helper('mailer/phpmailer');

            //     if (!phpmail_send($email_from, $email, trans('password_reset'), $email_message)) {
            //         $email_failed = true;
            //     }
            // } else {
            //     $this->load->library('email');

            //     // Set email configuration
            //     $config['mailtype'] = 'html';
            //     $this->email->initialize($config);

            //     // Set the email params
            //     $this->email->from($email_from);
            //     $this->email->to($email);
            //     $this->email->subject(trans('workshop'));
            //     $this->email->message($email_message);

            //     // Send the reset email
            //     if (!$this->email->send()) {
            //         $email_failed = true;
            //         log_message('error', $this->email->print_debugger());
            //     }
            // }

            $response = array(
                'success' => 1,
                'branch_id' => $branch_id,
                'btn_submit' => $this->input->post('btn_submit'),
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
    }

    public function getBranchDetail(){
        $w_branch_id = $this->input->post('w_branch_id');
        $branch_details = $this->mdl_workshop_branch->where('w_branch_id',$w_branch_id)->get()->row();
        if($branch_details->rewards == 'Y'){
            $reward_details = $this->mdl_mech_rewards->where('mech_rewards_dlts.branch_id',$w_branch_id)->get()->row();  
        }else{
            $reward_details = array();
        }
        
        $response = array(
            'success' => 1,
            'branch_details' => $branch_details,
            'reward_details' => $reward_details
        );
        echo json_encode($response);
        exit();
    }
}