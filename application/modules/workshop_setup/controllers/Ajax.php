<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function __construct() {
        $this->load->model('workshop_setup/mdl_workshop_setup');
        $this->load->model('workshop_branch/mdl_workshop_branch');
        $this->load->model('mech_bank_list/mdl_mech_bank_list');
        $this->load->model('mech_invoice_groups/mdl_mech_invoice_groups');
        $this->load->model('payment_methods/mdl_payment_methods');
        $this->load->model('workshop_branch/mdl_workshop_branch');
        $this->load->model('users/mdl_users');
        $this->load->helper('country');
        $this->load->helper('settings_helper');
        $this->load->model('settings/mdl_settings');
    }

    public function create()
    {
        if($this->input->post('workshop_id')){
            $workshop_id = $this->input->post('workshop_id');
        }else{
            $workshop_id = NULL;
        }

        if ($this->input->post('is_update') == 0 && $this->input->post('workshop_setup_name') != '') {
            $check = $this->db->get_where('ip_workshop_setup', array('workshop_setup_name' => $this->input->post('workshop_setup_name')))->result();

            if (!empty($check)) {
                $this->session->set_flashdata('alert_error', trans('workshop_setup_already_exists'));
                redirect('workshop_setup/index');
            }
        }

        if ($this->mdl_workshop_setup->run_validation()) {

            $workshop_id = $this->mdl_workshop_setup->save($workshop_id);

            $vehicleType = json_decode($this->input->post('vehicleType'));

            if(count($vehicleType) > 0){			    
			    foreach ($vehicleType as $checkin) {
			        if(!empty($checkin->type_checked)){
			            $checkinListArray = array(
                            'type_checked' => $checkin->type_checked,
                            'default_cost' => $checkin->default_cost,
			            );
                        $this->db->where('mvt_id', $checkin->mvt_id);
                        $this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
                        $mvt_id = $this->db->update('mech_vehicle_type', $checkinListArray);
			        }
			    }
            }

            $session_data = array(
                'is_mobileapp_enabled' => $this->input->post('is_mobileapp_enabled'),
                'workshop_is_enabled_inventory' => $this->input->post('workshop_is_enabled_inventory'),
                'workshop_is_enabled_jobsheet' => $this->input->post('workshop_is_enabled_jobsheet'),
                'service_cost_setup' => $this->input->post('service_cost_setup'),
            );

            $this->session->set_userdata($session_data);
            if($this->input->post('is_update') == 1 && $this->session->userdata('is_new_user') == 'N'){
                
                $this->db->select('w_branch_id ');
                $this->db->from('workshop_branch_details');
                $this->db->where('workshop_id' , $workshop_id);
                $this->db->order_by('w_branch_id' , 'ASC');
                $this->db->limit(1);
                $branch_id = $this->db->get()->row()->w_branch_id;
                if(empty($branch_id)){
                    $branch_id = NULL;
                }

                $temp_req = $_REQUEST;
                $_POST['workshop_id'] = $workshop_id;
                $_POST['display_board_name'] = $temp_req['workshop_name'];
                $_POST['contact_person_name'] = $temp_req['owner_name'];
                $_POST['branch_contact_no'] = $temp_req['workshop_contact_no'];
                $_POST['branch_email_id'] = $temp_req['workshop_email_id'];
                $_POST['branch_street'] = $temp_req['workshop_street'];
                $_POST['branch_city'] = $temp_req['workshop_city']?$temp_req['workshop_city']:0;
                $_POST['branch_state'] = $temp_req['workshop_state']?$temp_req['workshop_state']:0;
                $_POST['branch_country'] = $temp_req['workshop_country']?$temp_req['workshop_country']:0;
                $_POST['branch_pincode'] = $temp_req['workshop_pincode'];
                $_POST['branch_gstin'] = $temp_req['workshop_gstin'];
                $_POST['branch_employee_count'] = $temp_req['total_employee_count'];
                $_POST['branch_since_from'] = $temp_req['since_from'];
                $_POST['default_currency_id'] = $this->input->post('default_currency_id');
                $_POST['is_product'] = $this->input->post('is_product');
                $_POST['pos'] = $this->input->post('pos');
                $_POST['shift'] = $this->input->post('shift');
                $_POST['default_date_id'] = $this->input->post('default_date_id');
                
                if ($this->mdl_workshop_branch->run_validation()) {
                    $branch_id = $this->mdl_workshop_branch->save($branch_id);

                    if($branch_id){
                        if($branch_id == $this->session->userdata('branch_id')){
                            $this->db->select('cry_iso_code,cry_digit');
                            $this->db->where('currency_id', $this->input->post('default_currency_id'));
                            $currency = $this->db->get('mech_currency_list')->row();
                            $session_data = array(
                                'default_currency_code' => $currency->cry_iso_code,
                                'default_currency_digit' => $currency->cry_digit,
                            );
                            $this->session->set_userdata($session_data);
                        }
                    }

                    $db_array = array(
                        'branch_id' => $branch_id,
                        'user_company' => $temp_req['workshop_name'],
                        'user_address_1' => $temp_req['workshop_street'],
                        'user_address_2' => $temp_req['workshop_city'],
                        'user_city' => $temp_req['workshop_city'],
                        'user_state' => $temp_req['workshop_state'],
                        'user_zip' => $temp_req['workshop_pincode'],
                        'user_country' => $temp_req['workshop_country'],
                        'user_phone' => $temp_req['workshop_contact_no'],
                    );
                    $user_id = $this->mdl_users->save($this->session->userdata('user_id'), $db_array);
                    $session_data = array(
                        'is_shift' => $this->input->post('shift'),
                        'branch_id' => $branch_id,
                        'default_city_id' => $temp_req['workshop_city'],
                        'default_state_id' => $temp_req['workshop_state'],
                        'default_country_id' => $temp_req['workshop_country'],
                        'default_date_id' => $temp_req['default_date_id'],
                        'display_name' => $temp_req['workshop_name'],
                    );
                    $this->session->set_userdata($session_data);

                    //customer//employee//supplier
                    $invoice_group_customer = array(
                        'workshop_id' => $workshop_id,
                        'w_branch_id' => $branch_id,
                        'branch_id' => $branch_id,
                        'invoice_group_name' => 'Customer',
                        'invoice_group_identifier_format' => 'CUS{{{id}}}',
                        'invoice_group_next_id' => 1,
                        'invoice_group_left_pad' => 5,
                        'module_type' => 'customer',
                        'status' => 'A',
                        'mode_of_payment' => 'C',
                    );
                    $invoice_group_customer_id = $this->db->insert('ip_invoice_groups', $invoice_group_customer);

                    $invoice_group_supplier = array(
                        'workshop_id' => $workshop_id,
                        'w_branch_id' => $branch_id,
                        'branch_id' => $branch_id,
                        'invoice_group_name' => 'Supplier',
                        'invoice_group_identifier_format' => 'SUP{{{id}}}',
                        'invoice_group_next_id' => 1,
                        'invoice_group_left_pad' => 5,
                        'module_type' => 'supplier',
                        'status' => 'A',
                        'mode_of_payment' => 'C',
                    );
                    $invoice_group_supplier_id = $this->db->insert('ip_invoice_groups', $invoice_group_supplier);

                    $invoice_group_employee = array(
                        'workshop_id' => $workshop_id,
                        'w_branch_id' => $branch_id,
                        'branch_id' => $branch_id,
                        'invoice_group_name' => 'Employee',
                        'invoice_group_identifier_format' => 'EMP{{{id}}}',
                        'invoice_group_next_id' => 1,
                        'invoice_group_left_pad' => 5,
                        'module_type' => 'employee',
                        'status' => 'A',
                        'mode_of_payment' => 'C',
                    );
                    $invoice_group_employee_id = $this->db->insert('ip_invoice_groups', $invoice_group_employee);
                    //end//

                    //feedback//
                    $feedback_group = array(
                        'workshop_id' => $workshop_id,
                        'w_branch_id' => $branch_id,
                        'branch_id' => $branch_id,
                        'invoice_group_name' => 'Feedback',
                        'invoice_group_identifier_format' => 'FED{{{id}}}',
                        'invoice_group_next_id' => 1,
                        'invoice_group_left_pad' => 5,
                        'module_type' => 'feedback',
                        'status' => 'A',
                        'mode_of_payment' => 'C',
                    );
                    $this->db->insert('ip_invoice_groups', $feedback_group);
                    //end//
                    
                    if($this->session->userdata('plan_type') != 3){ 

                        $invoice_group_appoint = array(
                            'workshop_id' => $workshop_id,
                            'w_branch_id' => $branch_id,
                            'branch_id' => $branch_id,
                            'invoice_group_name' => 'Appointment',
                            'invoice_group_identifier_format' => 'APP{{{id}}}INT',
                            'invoice_group_next_id' => 1,
                            'invoice_group_left_pad' => 5,
                            'module_type' => 'appointment',
                            'status' => 'A',
                            'mode_of_payment' => 'C',
                        );
                        $invoice_group_appoint_id = $this->db->insert('ip_invoice_groups', $invoice_group_appoint);

                        $invoice_group_lead = array(
                            'workshop_id' => $workshop_id,
                            'w_branch_id' => $branch_id,
                            'branch_id' => $branch_id,
                            'invoice_group_name' => 'Leads',
                            'invoice_group_identifier_format' => 'LEA{{{id}}}DS',
                            'invoice_group_next_id' => 1,
                            'invoice_group_left_pad' => 5,
                            'module_type' => 'leads',
                            'status' => 'A',
                            'mode_of_payment' => 'C',
                        );
                        $invoice_group_lead_id = $this->db->insert('ip_invoice_groups', $invoice_group_lead);

                        $jobcard_group = array(
                            'workshop_id' => $workshop_id,
                            'w_branch_id' => $branch_id,
                            'branch_id' => $branch_id,
                            'invoice_group_name' => 'Jobcard',
                            'invoice_group_identifier_format' => 'JOB{{{id}}}ARD',
                            'invoice_group_next_id' => 1,
                            'invoice_group_left_pad' => 5,
                            'module_type' => 'job_card',
                            'status' => 'A',
                            'mode_of_payment' => 'C',
                        );
                        $this->db->insert('ip_invoice_groups', $jobcard_group);

                        $quote_group = array(
                            'workshop_id' => $workshop_id,
                            'w_branch_id' => $branch_id,
                            'branch_id' => $branch_id,
                            'invoice_group_name' => 'Quote',
                            'invoice_group_identifier_format' => 'QUO{{{id}}}TE',
                            'invoice_group_next_id' => 1,
                            'invoice_group_left_pad' => 5,
                            'module_type' => 'quote',
                            'status' => 'A',
                            'mode_of_payment' => 'C',
                        );
                        $this->db->insert('ip_invoice_groups', $quote_group);

                        $invoice_group = array(
                            'workshop_id' => $workshop_id,
                            'w_branch_id' => $branch_id,
                            'branch_id' => $branch_id,
                            'invoice_group_name' => 'Invoice',
                            'invoice_group_identifier_format' => 'INV{{{id}}}ICE',
                            'invoice_group_next_id' => 1,
                            'invoice_group_left_pad' => 5,
                            'module_type' => 'invoice',
                            'status' => 'A',
                            'mode_of_payment' => 'C',
                        );
                        $this->db->insert('ip_invoice_groups', $invoice_group);

                        $purchase_group = array(
                            'workshop_id' => $workshop_id,
                            'w_branch_id' => $branch_id,
                            'branch_id' => $branch_id,
                            'invoice_group_name' => 'Purchase',
                            'invoice_group_identifier_format' => 'PUR{{{id}}}ASE',
                            'invoice_group_next_id' => 1,
                            'invoice_group_left_pad' => 5,
                            'module_type' => 'purchase',
                            'status' => 'A',
                            'mode_of_payment' => 'C',
                        );
                        $this->db->insert('ip_invoice_groups', $purchase_group);

                        $purchase_order_group = array(
                            'workshop_id' => $workshop_id,
                            'w_branch_id' => $branch_id,
                            'branch_id' => $branch_id,
                            'invoice_group_name' => 'Purchase Order',
                            'invoice_group_identifier_format' => 'PO{{{id}}}ASE',
                            'invoice_group_next_id' => 1,
                            'invoice_group_left_pad' => 5,
                            'module_type' => 'purchase_order',
                            'status' => 'A',
                            'mode_of_payment' => 'C',
                        );
                        $this->db->insert('ip_invoice_groups', $purchase_order_group);

                        $expense_group = array(
                            'workshop_id' => $workshop_id,
                            'w_branch_id' => $branch_id,
                            'branch_id' => $branch_id,
                            'invoice_group_name' => 'Expense',
                            'invoice_group_identifier_format' => 'EXP{{{id}}}NSE',
                            'invoice_group_next_id' => 1,
                            'invoice_group_left_pad' => 5,
                            'module_type' => 'expense',
                            'status' => 'A',
                            'mode_of_payment' => 'C',
                        );
                        $this->db->insert('ip_invoice_groups', $expense_group);

                        $default_payment_method = array(
                            'payment_method_name' => 'Cash',
                            'workshop_id' => $workshop_id,
                            'w_branch_id' => $branch_id,
                            'created_on' => date('Y-m-d'),
                            'created_by' => $this->session->userdata('user_id'),
                            'modified_by' => $this->session->userdata('user_id'),
                        );
                        $this->db->insert('ip_payment_methods', $default_payment_method);

                        $mech_vehicle_type_one = array(
                            'workshop_id' => $workshop_id,
                            'vehicle_type_name' => 'Hatchback',
                            'vehicle_type_value' => 'H',
                            'created_on' => date('Y-m-d'),
                            'created_by' => $this->session->userdata('user_id'),
                            'modified_by' => $this->session->userdata('user_id'),
                        );
                        $this->db->insert('mech_vehicle_type', $mech_vehicle_type_one);

                        $mech_vehicle_type_two = array(
                            'workshop_id' => $workshop_id,
                            'vehicle_type_name' => 'Sedan',
                            'vehicle_type_value' => 'S',
                            'created_on' => date('Y-m-d'),
                            'created_by' => $this->session->userdata('user_id'),
                            'modified_by' => $this->session->userdata('user_id'),
                        );
                        $this->db->insert('mech_vehicle_type', $mech_vehicle_type_two);

                        $mech_vehicle_type_three = array(
                            'workshop_id' => $workshop_id,
                            'vehicle_type_name' => 'SUV',
                            'vehicle_type_value' => 'U',
                            'created_on' => date('Y-m-d'),
                            'created_by' => $this->session->userdata('user_id'),
                            'modified_by' => $this->session->userdata('user_id'),
                        );
                        $this->db->insert('mech_vehicle_type', $mech_vehicle_type_three);

                    } else {

                        $quote_group = array(
                            'workshop_id' => $workshop_id,
                            'w_branch_id' => $branch_id,
                            'branch_id' => $branch_id,
                            'invoice_group_name' => 'Quote',
                            'invoice_group_identifier_format' => 'QUO{{{id}}}TE',
                            'invoice_group_next_id' => 1,
                            'invoice_group_left_pad' => 5,
                            'module_type' => 'quote',
                            'status' => 'A',
                            'mode_of_payment' => 'C',
                        );
                        $this->db->insert('ip_invoice_groups', $quote_group);

                        $invoice_group = array(
                            'workshop_id' => $workshop_id,
                            'w_branch_id' => $branch_id,
                            'branch_id' => $branch_id,
                            'invoice_group_name' => 'Invoice',
                            'invoice_group_identifier_format' => 'INV{{{id}}}ICE',
                            'invoice_group_next_id' => 1,
                            'invoice_group_left_pad' => 5,
                            'module_type' => 'invoice',
                            'status' => 'A',
                            'mode_of_payment' => 'C',
                        );
                        $this->db->insert('ip_invoice_groups', $invoice_group);

                        $purchase_group = array(
                            'workshop_id' => $workshop_id,
                            'w_branch_id' => $branch_id,
                            'branch_id' => $branch_id,
                            'invoice_group_name' => 'Purchase',
                            'invoice_group_identifier_format' => 'PUR{{{id}}}ASE',
                            'invoice_group_next_id' => 1,
                            'invoice_group_left_pad' => 5,
                            'module_type' => 'purchase',
                            'status' => 'A',
                            'mode_of_payment' => 'C',
                        );
                        $this->db->insert('ip_invoice_groups', $purchase_group);

                        $expense_group = array(
                            'workshop_id' => $workshop_id,
                            'w_branch_id' => $branch_id,
                            'branch_id' => $branch_id,
                            'invoice_group_name' => 'Expense',
                            'invoice_group_identifier_format' => 'EXP{{{id}}}NSE',
                            'invoice_group_next_id' => 1,
                            'invoice_group_left_pad' => 5,
                            'module_type' => 'expense',
                            'status' => 'A',
                            'mode_of_payment' => 'C',
                        );
                        $this->db->insert('ip_invoice_groups', $expense_group);

                        $default_payment_method = array(
                            'payment_method_name' => 'Cash',
                            'workshop_id' => $workshop_id,
                            'w_branch_id' => $branch_id,
                            'created_on' => date('Y-m-d'),
                            'created_by' => $this->session->userdata('user_id'),
                            'modified_by' => $this->session->userdata('user_id'),
                        );
                        $this->db->insert('ip_payment_methods', $default_payment_method);

                        $mech_vehicle_type_one = array(
                            'workshop_id' => $workshop_id,
                            'vehicle_type_name' => 'Hatchback',
                            'vehicle_type_value' => 'H',
                            'created_on' => date('Y-m-d'),
                            'created_by' => $this->session->userdata('user_id'),
                            'modified_by' => $this->session->userdata('user_id'),
                        );
                        $this->db->insert('mech_vehicle_type', $mech_vehicle_type_one);

                        $mech_vehicle_type_two = array(
                            'workshop_id' => $workshop_id,
                            'vehicle_type_name' => 'Sedan',
                            'vehicle_type_value' => 'S',
                            'created_on' => date('Y-m-d'),
                            'created_by' => $this->session->userdata('user_id'),
                            'modified_by' => $this->session->userdata('user_id'),
                        );
                        $this->db->insert('mech_vehicle_type', $mech_vehicle_type_two);

                        $mech_vehicle_type_three = array(
                            'workshop_id' => $workshop_id,
                            'vehicle_type_name' => 'SUV',
                            'vehicle_type_value' => 'U',
                            'created_on' => date('Y-m-d'),
                            'created_by' => $this->session->userdata('user_id'),
                            'modified_by' => $this->session->userdata('user_id'),
                        );
                        $this->db->insert('mech_vehicle_type', $mech_vehicle_type_three);

                    }
                    
                } else {
                    $error = validation_errors();
                    exit();
                }
            }

            // Create head branch
            if ($this->input->post('is_update') == 0) {
                $temp_req = $_REQUEST;

                $_POST['workshop_id'] = $workshop_id;
                $_POST['display_board_name'] = $temp_req['workshop_name'];
                $_POST['contact_person_name'] = $temp_req['owner_name'];
                $_POST['branch_contact_no'] = $temp_req['workshop_contact_no'];
                $_POST['branch_email_id'] = $temp_req['workshop_email_id'];
                $_POST['branch_street'] = $temp_req['workshop_street'];
                $_POST['branch_city'] = $temp_req['workshop_city'];
                $_POST['branch_state'] = $temp_req['workshop_state'];
                $_POST['branch_country'] = $temp_req['workshop_country'];
                $_POST['branch_pincode'] = $temp_req['workshop_pincode'];
                $_POST['branch_gstin'] = $temp_req['workshop_gstin'];
                $_POST['branch_employee_count'] = $temp_req['total_employee_count'];
                $_POST['branch_since_from'] = $temp_req['since_from'];
                $_POST['default_currency_id'] = '1';
                $_POST['is_product'] = 'N';

                if ($this->mdl_workshop_branch->run_validation()) {
                    $branch_id = $this->mdl_workshop_branch->save();
                } else {
                    $error = validation_errors();
                    exit();
                }
            }

            
            if($this->session->userdata('user_type') != 1){
                if($this->session->userdata('is_new_user') == 'N'){
                    $db_array = array(
                        'is_new_user' => 'O',
                    );
                    $this->db->where('user_id', $this->session->userdata('user_id'));
                    $this->db->update('ip_users', $db_array);

                    $this->session->set_userdata('is_new_user', 'O');
                    $temp_req = $_REQUEST;
                    $email = $temp_req['workshop_email_id'];

                    // Send the email with reset link
                    $this->load->helper('mailer');
                    // Preprare some variables for the email
                    $email_message = $this->load->view('emails/workshop_mail', array(
                            'resetlink' => '1',
                        ), true);

                    $email_from = get_setting('smtp_mail_from');
                    if (empty($email_from)) {
                        $email_from = 'system@'.preg_replace("/^[\w]{2,6}:\/\/([\w\d\.\-]+).*$/", '$1', base_url());
                    }
                    // Mail the invoice with the pre-configured mailer if possible
                    if (mailer_configured()) {
                        $this->load->helper('mailer/phpmailer');
                        if(!phpmail_send($email_from, $email, trans('password_reset'), $email_message)) {
                            $email_failed = true;
                        }
                    } else {
                        $this->load->library('email');

                        // Set email configuration
                        $config['mailtype'] = 'html';
                        $this->email->initialize($config);

                        // Set the email params
                        $this->email->from($email_from);
                        $this->email->to($email);
                        $this->email->subject(trans('workshop'));
                        $this->email->message($email_message);

                        // Send the reset email
                        if (!$this->email->send()) {
                            $email_failed = true;
                            log_message('error', $this->email->print_debugger());
                        }
                    }

                    if (isset($email_failed)) {
                        $this->session->set_flashdata('alert_error', ('email_failed'));
                    } else {
                        $this->session->set_flashdata('alert_success', ('email_successfully_sent'));
                    }

                }
            }
            $response = array(
                'success' => 1,
            );
            echo json_encode($response);
            exit();
        }else{
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
            echo json_encode($response);
            exit();
        }
    }


    public function upload_file($workshop_id){

        if ($_FILES['workshop_logo']['name']) {
            $config['upload_path'] = './uploads/workshop_logo/';
            $config['allowed_types'] = 'jpg|gif|svg|jpeg|png|JPG|JPEG|SVG|PNG|GIF';
            $config['max_size'] = 50000;
            $new_name = time().'_'.str_replace(' ', '_', $_FILES['workshop_logo']['name']);

            $config['file_name'] = $_FILES['workshop_logo']['name'];

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('workshop_logo')) {
                $this->session->set_flashdata('alert_error', $this->upload->display_errors());
                if ($workshop_id) {
                    $reponse = array(
                        'success' => false,
                        'msg' => $this->upload->display_errors(),
                    );
                    echo json_encode($reponse);
                    exit();
                } else {
                    $reponse = array(
                        'success' => false,
                        'msg' => $this->upload->display_errors(),
                    ); 
                    echo json_encode($reponse);
                    exit();
                }
            } else {
                if ($workshop_id) {
                    $existing_data = $this->mdl_workshop_setup->get_by_id($workshop_id);
                    if($existing_data->workshop_logo != ''){
                        if(file_exists(FCPATH.'uploads\workshop_logo/'.$existing_data->workshop_logo)){
                        unlink(FCPATH.'uploads\workshop_logo/'.$existing_data->workshop_logo);
                        }     
                    }
                }
            }
        }

        $data = array('workshop_logo' => $new_name);
        
        $this->session->set_userdata($data);
        $workshop_id = $this->mdl_workshop_setup->save($workshop_id, $data);

        $reponse = array(
            'success' => true,
            'temp_file_name' => $data,
        );
        echo json_encode($reponse);
    }

    public function getReferralList(){
        $w_branch_id = $this->input->post('w_branch_id');
        $result = $this->mdl_workshop_setup->getReferralList($w_branch_id);
        $response = array(
            'success' => 1,
            'result' => $result
        );
        echo json_encode($response);
    }

    public function saveReferralConfig(){        
        $referralArray = json_decode($this->input->post('referralArray'));
        
        $workshop_id = $this->session->userdata('work_shop_id');
        $w_branch_id = $this->input->post('w_branch_id');
        
        $insert_array = array();
        $update_array = array();

        foreach ($referralArray as $key => $value){            
            if($value->rid != 'null' && $value->rid != ''){
                $update_array[] = array(
                    'rid' => $value->rid,
                    'rtype' => $value->rtype,
                    'referrer_point' => $value->referrer_point,
                    'rpoint' => $value->rpoint,
                    'rcost' => $value->rcost,
                    'workshop_id' => $workshop_id,
                    'w_branch_id' => $w_branch_id,
                    'created_by' => $this->session->userdata('user_id'),
                    'modified_by' => $this->session->userdata('user_id')
                );
            }else{
                $insert_array[] = array(
                    'rid' => null,
                    'rtype' => $value->rtype,
                    'referrer_point' => $value->referrer_point,
                    'rpoint' => $value->rpoint,
                    'rcost' => $value->rcost,
                    'workshop_id' => $workshop_id,
                    'w_branch_id' => $w_branch_id,
                    'created_by' => $this->session->userdata('user_id'),
                    'modified_by' => $this->session->userdata('user_id')
                );
            }
        }

        if(count($insert_array) > 0){
            $this->db->insert_batch('mech_ws_rewards_config', $insert_array);    
        }
        
        if(count($update_array) > 0){
            $this->db->update_batch('mech_ws_rewards_config', $update_array,'rid');    
        }
        
        $result = $this->mdl_workshop_setup->getReferralList($w_branch_id);
                
        if($result){
            $response = array(
                'success' => 1,
                'result' => $result
            );
        }else{
            $response = array(
                'success' => 0
            );
        }
        
        echo json_encode($response);
    }

    public function deleteReferral(){
        $rid = $this->input->post('rid');

        $this->db->set('status',0);
        $this->db->where('rid',$rid);
        $this->db->update('mech_ws_rewards_config');

        $response = array(
            'success' => 1
        );

        echo json_encode($response);
    }

    public function addnotificationSetting(){

        $notifications = json_decode($this->input->post('notifications'));
        
        $workshop_id = $this->session->userdata('work_shop_id');
        $w_branch_id = $this->input->post('w_branch_id');
        
        $insert_array = array();
        $update_array = array();
        
        foreach ($notifications as $key => $value){
            if($value->notifi_status != ''){
                if($value->mnt_id != 'null' && $value->mnt_id != ''){     
                    $update_array[] = array(
                        'mnt_id' => $value->mnt_id,
                        'workshop_id' => $this->session->userdata('work_shop_id'),
                        'mnl_id' => $value->mnl_id,
                        'notify_type' => $value->notify_type,
                        'notifi_status' => $value->notifi_status,
                        'category_type' => $value->category_type,
                        'modified_by' => $this->session->userdata('user_id'),
                        'created_on' => date('Y-m-d H:i:s'),
                    );
                }else{
                    $insert_array[] = array(
                        'workshop_id' => $this->session->userdata('work_shop_id'),
                        'mnl_id' => $value->mnl_id,
                        'notify_type' => $value->notify_type,
                        'notifi_status' => $value->notifi_status,
                        'category_type' => $value->category_type,
                        'created_by' => $this->session->userdata('user_id'),
                        'modified_by' => $this->session->userdata('user_id'),
                        'created_on' => date('Y-m-d H:i:s'),
                    );
                }
            }
        }

        if(count($insert_array) > 0){
            $this->db->insert_batch('mech_notification_setup', $insert_array);    
        }
        
        if(count($update_array) > 0){
            $this->db->update_batch('mech_notification_setup', $update_array,'mnt_id');    
        }

        $notificationList = $this->db->query('SELECT * FROM mech_notification_setup as mns where mns.workshop_id = '.$this->session->userdata('work_shop_id').'')->result();       
        
        foreach($notificationList as $key => $notiList){
            if($notiList->category_type == "P"){
                $notificationList[$key]->noti_list_name = $this->db->select('noti_list_name')->from('mech_notification_list')->where('mnl_id',$notiList->mnl_id)->get()->row()->noti_list_name;
            }else if($notiList->category_type == "I"){
                $notificationList[$key]->noti_list_name = $this->db->select('status_name')->from('mech_invoice_status')->where('invoice_status_id',$notiList->mnl_id)->get()->row()->status_name;
            }else if($notiList->category_type == "J"){
                $notificationList[$key]->noti_list_name = $this->db->select('status_name')->from('mech_jobcard_status')->where('jobcard_status_id',$notiList->mnl_id)->get()->row()->status_name;
            }
        }

        if(count($notificationList)>0){
            foreach($notificationList as $value){
                if($value->notify_type == "E"){
                    $session_data = array(
                        $value->noti_list_name.'_E' => $value->notifi_status,
                    );
                    $this->session->set_userdata($session_data);
                }else{
                    $session_datas = array(
                        $value->noti_list_name.'_'.$value->category_type.'_S' => $value->notifi_status,
                    );
                    $this->session->set_userdata($session_datas);
                }
            }
        }

        if(!empty($notificationList)){
            $response = array(
                'success' => 1,
                'notificationList' => $notificationList
            );
        }else{
            $response = array(
                'success' => 0
            );
        }
        echo json_encode($response);
    }
}
