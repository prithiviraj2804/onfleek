<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Workshop_Branch extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_workshop_branch');
        $this->load->model('workshop_setup/mdl_workshop_setup');
        $this->load->model('mech_bank_list/mdl_mech_bank_list');
        $this->load->model('mech_vehicle_type/mdl_mech_vehicle_type');
    }

    public function index($branch_id = null)
    {
        if ($this->session->userdata('user_type') == 1) {
            $this->layout->set(
            array(
                'workshop_branch' => $this->mdl_workshop_branch->get()->result(),
            ));
            $this->layout->buffer('content', 'workshop_branch/index');
        } else if ($this->session->userdata('user_type') == 3 || $this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 || $this->session->userdata('user_type') == 6) {
            $workshop_details = $this->mdl_workshop_setup->where('workshop_setup.workshop_id', $this->session->userdata('work_shop_id'))->get()->row();
            $branch_details = $this->mdl_workshop_branch->where('workshop_branch_details.w_branch_id', $branch_id)->get()->row();
            $branch_bank_list = $this->mdl_mech_bank_list->where('mech_workshop_bank_list.workshop_id', $this->session->userdata('work_shop_id'))->where('mech_workshop_bank_list.w_branch_id', $branch_id)->where_in('mech_workshop_bank_list.module_type', array('B'))->get()->result();

            $this->layout->set(
            array(
                'workshop_details' => $workshop_details,
                'branch_details' => $branch_details,
                'branch_bank_list' => $branch_bank_list,
            ));
            $this->layout->buffer('content', 'workshop_branch/profile');
        }
        $this->layout->render();
    }

    public function form($branch_id = null,$workshop_id = null)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('workshop_branch/index/'.$branch_id);
        }

        if ($this->input->post('is_update') == 0 && $this->input->post('workshop_branch_name') != '') {
            $check = $this->db->get_where('ip_workshop_branch', array('workshop_branch_name' => $this->input->post('workshop_branch_name')))->result();

            if (!empty($check)) {
                $this->session->set_flashdata('alert_error', trans('workshop_branch_already_exists'));
                redirect('workshop_branch/form');
            }
        }

        $this->load->model('users/mdl_users');

        // if ($this->mdl_workshop_branch->run_validation()) {
        //     $branch_id = $this->mdl_workshop_branch->save($branch_id);

        //     if ($this->input->post('is_update') == 0) {
        //         $temp_req = $_REQUEST;
        //         $user_password = mt_rand(10000000, 99999999);

        //         unset($_REQUEST);
        //         $_POST['user_type'] = 4;
        //         $_POST['user_email'] = $temp_req['branch_email_id'];
        //         $_POST['user_name'] = $temp_req['contact_person_name'];
        //         $_POST['user_password'] = $user_password;
        //         $_POST['user_passwordv'] = $user_password;
        //         $_POST['workshop_id'] = $temp_req['workshop_id'];
        //         $_POST['branch_id'] = $branch_id;
        //         $_POST['user_language'] = 'system';
        //         $_POST['user_company'] = $temp_req['display_board_name'];
        //         $_POST['user_address_1'] = $temp_req['branch_street'];
        //         $_POST['user_address_2'] = $temp_req['branch_area'];
        //         $_POST['user_city'] = $temp_req['branch_area'];
        //         $_POST['user_state'] = $temp_req['branch_state'];
        //         $_POST['user_zip'] = $temp_req['branch_pincode'];
        //         $_POST['user_country'] = $temp_req['branch_country'];
        //         $_POST['user_phone'] = $temp_req['branch_contact_no'];
        //         $_POST['user_mobile'] = $temp_req['branch_contact_no'];

        //         if ($this->mdl_users->run_validation()) {
        //             $db_array = $this->mdl_users->db_array();
        //             $user_id = $this->mdl_users->save(null, $db_array);
        //         } else {
        //             $error = validation_errors();
        //             exit();
        //         }
        //     }

        //     $temp_req = $_REQUEST;
        //     $email = $temp_req['branch_email_id'];

        //     // Send the email with reset link
        //     $this->load->helper('mailer');
        //     // Preprare some variables for the email
        //     $email_message = $this->load->view('emails/branch_mail', array(
        //             'resetlink' => '1',
        //         ), true);

        //     $email_from = get_setting('smtp_mail_from');
        //     if (empty($email_from)) {
        //         $email_from = 'system@'.preg_replace("/^[\w]{2,6}:\/\/([\w\d\.\-]+).*$/", '$1', base_url());
        //     }

        //     // Mail the invoice with the pre-configured mailer if possible
        //     if (mailer_configured()) {
        //         $this->load->helper('mailer/phpmailer');

        //         if (!phpmail_send($email_from, $email, trans('password_reset'), $email_message)) {
        //             $email_failed = true;
        //         }
        //     } else {
        //         $this->load->library('email');

        //         // Set email configuration
        //         $config['mailtype'] = 'html';
        //         $this->email->initialize($config);

        //         // Set the email params
        //         $this->email->from($email_from);
        //         $this->email->to($email);
        //         $this->email->subject(trans('workshop'));
        //         $this->email->message($email_message);

        //         // Send the reset email
        //         if (!$this->email->send()) {
        //             $email_failed = true;
        //             log_message('error', $this->email->print_debugger());
        //         }
        //     }

        //     if (isset($email_failed)) {
        //         $this->session->set_flashdata('alert_error', ('email_failed'));
        //     } else {
        //         $this->session->set_flashdata('alert_success', ('email_successfully_sent'));
        //     }

        //     redirect('workshop_branch/index/'.$branch_id);
        // }

        if ($branch_id) {

            if(!$this->mdl_workshop_branch->prep_form($branch_id)) {
                show_404();
            }
            
            $this->mdl_workshop_branch->set_form_value('is_update', true);
            if ($this->mdl_workshop_branch->form_value('branch_country', true)) {
                $state_list = $this->mdl_settings->getStateList($this->mdl_workshop_branch->form_value('branch_country', true));
            } else {
                $state_list = array();
            }

            if ($this->mdl_workshop_branch->form_value('branch_state', true)) {
                $city_list = $this->mdl_settings->getCityList($this->mdl_workshop_branch->form_value('branch_state', true));
            } else {
                $city_list = array();
            }
            $vehicle_model_type = $this->mdl_mech_vehicle_type->get()->result();
            

        } else {

            $state_list = array();
            $city_list = array();
            $vehicle_model_type = $this->mdl_mech_vehicle_type->get()->result();

        }

        $vehicle_model_type = $this->mdl_mech_vehicle_type->get()->result();

        $this->layout->set(
            array(
                'workshop_id' => $workshop_id,
                'workshops' => $this->mdl_workshop_setup->get()->result(),
                'date_list' => $this->db->query('SELECT * FROM mech_date_list where status = "A"')->result(),
                'currency_list' => $this->db->query('SELECT * FROM mech_currency_list')->result(),
                'country_list' => $this->db->query('SELECT * FROM country_lookup')->result(),
                'state_list' => $state_list,
                'city_list' => $city_list,
                'pincode_list' => $this->db->get_where('mech_area_pincode', array('status' => 'A'))->result(),
            ));

        $this->layout->buffer('content', 'workshop_branch/form');
        $this->layout->render();

    }

    public function delete($id=NULL)
    {
        if(empty($id)){
            $id = $this->input->post('id');
        }
        $this->mdl_workshop_branch->delete($id);
        $response = array(
            'success' => 1
        );
        echo json_encode($response);
    }
}
