<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mail_cron extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function sendMail()
    {
        $this->db->select('me.subject, me.body, me.attachment_url, mn.id as mailer_id, mn.mapped_id, mn.client_id, mn.email_status, cli.client_email_id');
        $this->db->from('mech_email_notification_dtls as me');
        $this->db->join('mech_clients_notification_email_dtls as mn','mn.mapped_id = me.id','left' );
        $this->db->join('mech_clients as cli','cli.client_id = mn.client_id','left' );
        $this->db->where('mn.email_status' , 'P');
        $this->db->where('mn.status' , 'A');
        $this->db->where('me.status' , 'A');
        $this->db->order_by('mn.id');
        $lists = $this->db->get()->result();
        if(count($lists) > 0){
            $CI = &get_instance();
            $CI->load->helper('mailer/phpmailer');
            foreach($lists as $list){
                if(phpmail_send("services@mechpoint.care",strip_tags($list->client_email_id),$list->subject,$list->body,$list->attachment_url,null,null,null))
                {
                    $db_array = array (
                        'email_status' => 'S',
                    );
                    $this->db->where('id' , $list->mailer_id);
                    $this->db->update('mech_clients_notification_email_dtls', $db_array );
                }
                 else
                {
                    $db_array = array (
                        'email_status' => 'F'
                    );
                    $this->db->where('id' , $list->mailer_id);
                    $this->db->update('mech_clients_notification_email_dtls', $db_array );
                }
            }
        }
        $this->resendEmails();
    }

    public function resendEmails()
    {
        $this->db->select('me.subject, me.body, me.attachment_url, mn.id as mailer_id, mn.mapped_id, mn.client_id, mn.email_status, cli.client_email_id');
        $this->db->from('mech_email_notification_dtls as me');
        $this->db->join('mech_clients_notification_email_dtls as mn','mn.mapped_id = me.id','left' );
        $this->db->join('mech_clients as cli','cli.client_id = mn.client_id','left' );
        $this->db->where('mn.email_status' , 'F');
        $this->db->where('mn.status' , 'A');
        $this->db->where('me.status' , 'A');
        $this->db->order_by('mn.id');
        $lists = $this->db->get()->result();
        if(count($lists) > 0){
            foreach($lists as $list){
                if(phpmail_send("services@mechpoint.care",strip_tags($list->client_email_id),$list->subject,$list->body,$list->attachment_url,null,null,null))
                {
                    $db_array = array (
                        'email_status' => 'S',
                    );
                    $this->db->where('id' , $list->mailer_id);
                    $this->db->update('mech_clients_notification_email_dtls', $db_array );
                }
                 else
                {
                    $db_array = array (
                        'email_status' => 'C'
                    );
                    $this->db->where('id' , $list->mailer_id);
                    $this->db->update('mech_clients_notification_email_dtls', $db_array );
                }
            }
        }
    }

    public function sendfirebaseMail()
    {
        $this->db->select('me.subject, me.body, me.attachment_url, mn.id as mailer_id, mn.mapped_id, mn.client_id, mn.email_status, cli.client_email_id, cli.device_token');
        $this->db->from('mech_firebase_notification as me');
        $this->db->join('mech_clients_notification_firebase_dtls as mn','mn.mapped_id = me.id','left' );
        $this->db->join('mech_clients as cli','cli.client_id = mn.client_id','left' );
        $this->db->where('mn.email_status' , 'P');
        $this->db->where('mn.status' , 'A');
        $this->db->where('me.status' , 'A');
        $this->db->order_by('mn.id');
        $lists = $this->db->get()->result();

        if(count($lists) > 0){
            $CI = &get_instance();
            $CI->load->helper('mailer/phpmailer');
            foreach($lists as $list){

                if(!empty($list->device_token)){

                    $notification_mobile_data = array(
                        "body" => $list->body,
                        "title" => $list->subject,
                    );
    
                    $data =  array(
                        'notification_type'=>'offer',
                        'post_title'=>'AC Service', 
                        'post_desc'=>'Full AC Service at 1499 only'
                    );
                    $target = array($list->device_token);
                    $send_notification = $this->send_notification($data, $target, $notification_mobile_data);
                    $send_notification = json_decode($send_notification);
                    if($send_notification->success == 1)
                    {
                        $db_array = array (
                            'email_status' => 'S',
                            'multicast_id' => $send_notification->multicast_id,
                        );
                        $this->db->where('id' , $list->mailer_id);
                        $this->db->update('mech_clients_notification_firebase_dtls', $db_array );
                    }
                     else
                    {
                        $db_array = array (
                            'email_status' => 'F',
                            'multicast_id' => $send_notification->multicast_id,
                        );
                        $this->db->where('id' , $list->mailer_id);
                        $this->db->update('mech_clients_notification_firebase_dtls', $db_array );
                    }
                }
            }
        }

        $this->resendfirebaseEmails();
    }

    function send_notification($data, $target, $notification_mobile_data){
        //$data = array('notification_type'=>'offer','post_title'=>'AC Service', 'post_desc'=>'Full AC Service at 1499 only');
    
        //$target = array('c_KbOXR8vB4:APA91bEIJrG_rvdB78pXgLb8TJ-TrLjskSKegy9GGeJAAxCRJcWvffquZgmV6RjQa5kB8zVjF2gTnFkdxQuBym4KgxNp291wnD2eF4gZrYVDEZoT86spy7jFo_JO7Shtj-0wNNsO83-Z');
            //FCM api URL
            $url = 'https://fcm.googleapis.com/fcm/send';
            //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
            $server_key = 'AAAAj4aTr0I:APA91bH2pkjqMJb1xFmSOi5uUxhCaym2KUb4W61Kd3RP6Fz-N63lF1knAjjmRm_xqQj5wPOcTvj7CJ5Bx6pS_a0a-6yIh_TELNcEG9aY9MyxxdMVwffiVCZ671fQyXfeesCunNO6fTQH';
                        
            $fields = array();
            $fields['data'] = $data;
            $fields['notification'] = $notification_mobile_data;
            if(is_array($target)){
                $fields['registration_ids'] = $target;
            }else{
                $fields['to'] = $target;
            }
            //header with content_type api key
            $headers = array(
                'Content-Type:application/json',
                  'Authorization:key='.$server_key.''
            );
    
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('FCM Send Error: ' . curl_error($ch));
            }
            curl_close($ch);
            return $result;
    }

    public function resendfirebaseEmails()
    {
        $this->db->select('me.subject, me.body, me.attachment_url, mn.id as mailer_id, mn.mapped_id, mn.client_id, mn.email_status, cli.client_email_id, cli.device_token');
        $this->db->from('mech_firebase_notification as me');
        $this->db->join('mech_clients_notification_firebase_dtls as mn','mn.mapped_id = me.id','left' );
        $this->db->join('mech_clients as cli','cli.client_id = mn.client_id','left' );
        $this->db->where('mn.email_status' , 'F');
        $this->db->where('mn.status' , 'A');
        $this->db->where('me.status' , 'A');
        $this->db->order_by('mn.id');
        $lists = $this->db->get()->result();
        if(count($lists) > 0){
            foreach($lists as $list){
                if(!empty($list->device_token)){
                    $notification_mobile_data = array(
                        "body" => $list->body,
                        "title" => $list->subject,
                    );

                    $data =  array(
                        'notification_type'=>'offer',
                        'post_title'=>'AC Service', 
                        'post_desc'=>'Full AC Service at 1499 only'
                    );
                    $target = array($list->device_token);
                    $send_notification = $this->send_notification($data, $target, $notification_mobile_data);
                    $send_notification = json_decode($send_notification);
                    if($send_notification->success == 1)
                    {
                        $db_array = array (
                            'email_status' => 'S',
                        );
                        $this->db->where('id' , $list->mailer_id);
                        $this->db->update('mech_clients_notification_firebase_dtls', $db_array );
                    }
                    else
                    {
                        $db_array = array (
                            'email_status' => 'C'
                        );
                        $this->db->where('id' , $list->mailer_id);
                        $this->db->update('mech_clients_notification_firebase_dtls', $db_array );
                    }
                }
            }
        }
    }

    public function update_new_module_in_category(){

        // update new modules into module categpry permission table
        // Company mani category Details

        $this->db->select('*');
        $this->db->from('mech_category_dlts');
        $mech_category_dlts = $this->db->get()->result();

        // All the modules defined

        $this->db->select('*');
        $this->db->from('mech_modules');
        $modules = $this->db->get()->result();

        if(count($modules) > 0){
            foreach($modules as $mod){
                foreach($mech_category_dlts as $mainCatdtls){
                    $this->db->select('*');
                    $this->db->from('mech_category_permission_dtls');
                    $this->db->where('module_id' , $mod->module_id);
                    $this->db->where('category_type' , $mainCatdtls->category_id);
                    $cat_permission = $this->db->get()->row();
                    if(empty($cat_permission)){
                        $data = array(
                            'module_id' => $mod->module_id,
                            'category_type' => $mainCatdtls->category_id,
                            'status' => $mod->status,
                        );
                        $this->db->insert('mech_category_permission_dtls' , $data);
                    }
                }
            }
        }else{
            // if No modules present in the main table delete all the permissions
            $this->db->delete('mech_category_permission_dtls');
        }
    }

    public function model_permission_migration(){

        // this function will migrate
        // It will update newly activated or added modules to the existing companies
        // And also remove the deactivated modules

        $workshop_list = array();
        $modeule_list = array();

        $this->db->select('ip_users.user_id, workshop_setup.workshop_id, workshop_setup.plan_type');
        $this->db->from('workshop_setup');
        $this->db->join('ip_users','ip_users.workshop_id = workshop_setup.workshop_id','left');
        // $this->db->where('workshop_setup.workshop_status', 'A');
        $this->db->where('ip_users.user_active', '1');
        $this->db->where('ip_users.user_type', '3');
        // $this->db->where('ip_users.user_id', '3');
        // $this->db->where('ip_users.workshop_id', '3');
        $this->db->order_by('workshop_setup.workshop_id', 'ASC');
        $this->db->group_by('workshop_setup.workshop_id');
        $workshop_list = $this->db->get()->result();
        if(count($workshop_list) > 0){
            $i = 0;
            foreach($workshop_list as $workshop){
                $this->db->select('*');
                $this->db->from('mech_category_permission_dtls');
                $this->db->where('category_type' , $workshop->plan_type);
                $plan_type = $this->db->get()->result();
                if(count($plan_type) > 0){
                    foreach($plan_type as $plan){
                        if($plan->status == 'A'){
                            $this->db->select('*');
                            $this->db->from('mech_module_permission');
                            $this->db->where('mech_module_permission.user_id' , $workshop->user_id);
                            $this->db->where('mech_module_permission.workshop_id' , $workshop->workshop_id);
                            $this->db->where('mech_module_permission.module_id' , $plan->module_id);
                            $permission_list = $this->db->get()->row();
                            if(empty($permission_list)){
                                $data = array(
                                    'user_id' => $workshop->user_id,
                                    'workshop_id' => $workshop->workshop_id,
                                    'module_id' => $plan->module_id,
                                    'status' => 1,
                                );
                                $this->db->insert('mech_module_permission', $data);
                            }
                        }else{
                            $this->db->select('*');
                            $this->db->from('mech_module_permission');
                            $this->db->where('mech_module_permission.user_id' , $workshop->user_id);
                            $this->db->where('mech_module_permission.workshop_id' , $workshop->workshop_id);
                            $this->db->where('mech_module_permission.module_id' , $plan->module_id);
                            $permission_list = $this->db->get()->row();
                            if(empty($permission_list)){
                                $this->db->where('permission_id' , $permission_list->permission_id);
                                $this->db->delete('mech_module_permission');
                            }
                        }
                    }
                }
            }
        }
    }

    // public function invoicegroupnumberupdate(){
       
    //     $this->db->select('*');
    //     $this->db->from('workshop_setup');
    //     $this->db->where('workshop_status','A');
    //     $workshop_list = $this->db->get()->result();
        
    //     if($workshop_list){
    //         $CI = &get_instance();
    //         $CI->load->helper('settings_helper');
    //         $CI->load->model('settings/mdl_settings');
    //         $CI->load->model('workshop_setup/mdl_workshop_setup');
    //         $CI->load->model('mech_invoice_groups/mdl_mech_invoice_groups');

    //         foreach($workshop_list as $workshop){

    //             $workshop_id = $workshop->workshop_id;

    //             $checkgroupinvoice_customer = $this->db->query("SELECT * FROM ip_invoice_groups where module_type = 'customer' and workshop_id = '".$workshop_id."' ORDER BY workshop_id ASC LIMIT 1")->row();
                
    //             if(empty($checkgroupinvoice_customer)){ 

    //                 $invoice_group_customer = array(
    //                     'workshop_id' => $workshop_id,
    //                     'invoice_group_name' => 'Customer',
    //                     'invoice_group_identifier_format' => 'CUS{{{id}}}',
    //                     'invoice_group_next_id' => 1,
    //                     'invoice_group_left_pad' => 5,
    //                     'module_type' => 'customer',
    //                     'status' => 'A',
    //                     'mode_of_payment' => 'C',
    //                 );
    //                 $invoice_group_customer_id = $this->db->insert('ip_invoice_groups', $invoice_group_customer);
    //                 echo "Customer Insert===".$workshop_id;
    //             }else{
    //                 echo "No Customer Insert";
    //             }

    //             $checkgroupinvoice_supplier = $this->db->query("SELECT * FROM ip_invoice_groups where module_type = 'supplier' and workshop_id = '".$workshop_id."' ORDER BY workshop_id ASC LIMIT 1")->row();
    //             if(empty($checkgroupinvoice_supplier)){ 

    //                 $invoice_group_supplier = array(
    //                     'workshop_id' => $workshop_id,
    //                     'invoice_group_name' => 'Supplier',
    //                     'invoice_group_identifier_format' => 'SUP{{{id}}}',
    //                     'invoice_group_next_id' => 1,
    //                     'invoice_group_left_pad' => 5,
    //                     'module_type' => 'supplier',
    //                     'status' => 'A',
    //                     'mode_of_payment' => 'C',
    //                 );
    //                 $invoice_group_supplier_id = $this->db->insert('ip_invoice_groups', $invoice_group_supplier);
    //                 echo "Supplier Insert===".$workshop_id;
    //             }else{
    //                 echo "No Supplier Insert";
    //             }

    //             $checkgroupinvoice_employee = $this->db->query("SELECT * FROM ip_invoice_groups where module_type = 'employee' and workshop_id = '".$workshop_id."' ORDER BY workshop_id ASC LIMIT 1")->row();
    //             if(empty($checkgroupinvoice_employee)){ 

    //                 $invoice_group_employee = array(
    //                     'workshop_id' => $workshop_id,
    //                     'invoice_group_name' => 'Employee',
    //                     'invoice_group_identifier_format' => 'EMP{{{id}}}',
    //                     'invoice_group_next_id' => 1,
    //                     'invoice_group_left_pad' => 5,
    //                     'module_type' => 'employee',
    //                     'status' => 'A',
    //                     'mode_of_payment' => 'C',
    //                 );
    //                 $invoice_group_employee_id = $this->db->insert('ip_invoice_groups', $invoice_group_employee);
    //                 echo "Employee Insert===".$workshop_id;
    //             }else{
    //                 echo "No Employee Insert";
    //             }
    //         }
    //     }
    // }

    // public function groupnumbermoduleupdate(){

    //     $this->db->select('*');
    //     $this->db->from('workshop_setup');
    //     $this->db->where('workshop_status','A');
    //     $workshop_list = $this->db->get()->result();
        
    //     if($workshop_list){

    //         $CI = &get_instance();
    //         $CI->load->helper('settings_helper');
    //         $CI->load->model('settings/mdl_settings');
    //         $CI->load->model('clients/mdl_clients');
    //         $CI->load->model('suppliers/mdl_suppliers');
    //         $CI->load->model('mech_employee/mdl_mech_employee');
    //         $CI->load->model('workshop_setup/mdl_workshop_setup');
    //         $CI->load->model('mech_invoice_groups/mdl_mech_invoice_groups');

    //         foreach($workshop_list as $workshop){
    //             $workshop_id = $workshop->workshop_id;
    //             //client//   
    //             $this->db->select('*');
    //             $this->db->from('mech_clients');
    //             $this->db->where('workshop_id',$workshop_id);
    //             $this->db->where('client_active','A');
    //             $customer_list = $this->db->get()->result();
                            
    //             $customer_group_number = $this->db->query("SELECT * FROM ip_invoice_groups where module_type = 'customer' and workshop_id = '".$workshop_id."' ORDER BY workshop_id ASC LIMIT 1")->row();
    //             $invoice_group_customer = $customer_group_number->invoice_group_id;
                
    //             foreach($customer_list as $customer){

    //                 if(empty($customer->client_no)){ 

    //                     $client_no = $this->mdl_mech_invoice_groups->generate_invoice_number_duplicate($invoice_group_customer);
    //                     $group_client_no = array(
    //                         'client_no' => $client_no,
    //                     );
    //                     $this->db->where('client_id',$customer->client_id);
    //                     $this->db->update('mech_clients', $group_client_no);

    //                     echo "Client_No Update===".$customer->client_id;
    //                 }else{
    //                     echo "No Client_No Update";
    //                 } 
    //             } 

    //             //supplier//
    //             $this->db->select('*');
    //             $this->db->from('mech_suppliers');
    //             $this->db->where('workshop_id',$workshop_id);
    //             $this->db->where('supplier_active',1);
    //             $supplier_list = $this->db->get()->result();

    //             $supplier_group_number = $this->db->query("SELECT * FROM ip_invoice_groups where module_type = 'supplier' and workshop_id = '".$workshop_id."' ORDER BY workshop_id ASC LIMIT 1")->row();
    //             $invoice_group_supplier = $supplier_group_number->invoice_group_id;

    //             foreach($supplier_list as $supplier){
    //                 if(empty($supplier->supplier_no)){ 
    //                     $supplier_no = $this->mdl_mech_invoice_groups->generate_invoice_number_duplicate($invoice_group_supplier);
    //                     $group_supplier_no = array(
    //                         'supplier_no' => $supplier_no,
    //                     );
    //                     $this->db->where('supplier_id',$supplier->supplier_id);
    //                     $this->db->update('mech_suppliers', $group_supplier_no);
    //                     echo "Supplier_No Update===".$supplier->supplier_id;
    //                 }else{
    //                     echo "No Supplier_No Update";
    //                 } 
    //             }

    //             //employee//

    //             $this->db->select('*');
    //             $this->db->from('mech_employee');
    //             $this->db->where('workshop_id',$workshop_id);
    //             $this->db->where('employee_status',1);
    //             $employee_list = $this->db->get()->result();
            
    //             $employee_group_number = $this->db->query("SELECT * FROM ip_invoice_groups where module_type = 'employee' and workshop_id = '".$workshop_id."' ORDER BY workshop_id ASC LIMIT 1")->row();
    //             $invoice_group_employee = $employee_group_number->invoice_group_id;
    //             foreach($employee_list as $employee){
    //                 $employee_no = $this->mdl_mech_invoice_groups->generate_invoice_number_duplicate($invoice_group_employee); 
    //                 $group_employee_no = array(
    //                     'employee_no' => $employee_no,
    //                 );
    //                 $this->db->where('employee_id',$employee->employee_id);
    //                 $this->db->update('mech_employee', $group_employee_no);
    //                 echo "Employee_No Update===".$employee->employee_id;
    //             }
    //         }
    //     }

    // }
    
    // public function update_employee_account_modules(){

    //     // update employee acount modules permission those who are having accounts
    //     $this->db->select('ip_users.user_id, workshop_setup.workshop_id, workshop_setup.plan_type');
    //     $this->db->from('ip_users');
    //     $this->db->join('workshop_setup','ip_users.workshop_id = workshop_setup.workshop_id','left');
    //     $this->db->where('ip_users.user_active', '1');
    //     $this->db->where('ip_users.user_type', '6');
    //     $workshop_list = $this->db->get()->result();

    //     if(count($workshop_list) > 0){
    //         foreach($workshop_list as $shop){
    //             // print_r($shop);
    //             $this->db->select('*');
    //             $this->db->from('mech_module_permission');
    //             $this->db->where('mech_module_permission.user_id' , $shop->user_id);
    //             $this->db->where('mech_module_permission.workshop_id' , $shop->workshop_id);
    //             $permission_list = $this->db->get()->result();
    //             // print_r($permission_list);
    //             if(count($permission_list) > 0){
    //                 $dbarray = array();
    //                 foreach($permission_list as $peerr){
    //                     // print_r($peerr);
    //                     if($peerr->module_id == 1){
    //                         $module = 2;
    //                     }else if($peerr->module_id == 2){
    //                         $module = 6;
    //                     }else if($peerr->module_id == 3){
    //                         $module = 7;
    //                     }else if($peerr->module_id == 4){
    //                         $module = 8;
    //                     }else if($peerr->module_id == 5){
    //                         $module = 9;
    //                     }else if($peerr->module_id == 6){
    //                         $module = 10;
    //                     }else if($peerr->module_id == 8){
    //                         $module = 13;
    //                     }else if($peerr->module_id == 9){
    //                         $module = 14;
    //                     }else if($peerr->module_id == 10){
    //                         $module = 15;
    //                     }else if($peerr->module_id == 11){
    //                         $module = 16;
    //                     }else if($peerr->module_id == 12){
    //                         $module = 17;
    //                     }else if($peerr->module_id == 13){
    //                         $module = 18;
    //                     }else if($peerr->module_id == 14){
    //                         $module = 19;
    //                     }else if($peerr->module_id == 15){
    //                         $module = 20;
    //                     }else if($peerr->module_id == 16){
    //                         $module = 21;
    //                     }else if($peerr->module_id == 17){
    //                         $module = 22;
    //                     }else if($peerr->module_id == 18){
    //                         $module = 23;
    //                     }else{
    //                         $module = 0;
    //                     }
    //                     if($module > 0){
    //                         $dbarray[] = array(
    //                             'user_id' => $peerr->user_id,
    //                             'workshop_id' => $peerr->workshop_id,
    //                             'module_id' => $module,
    //                             'status' => 1
    //                         );
    //                     }
    //                     $this->db->where('permission_id' , $peerr->permission_id);
    //                     $this->db->delete('mech_module_permission');
    //                 }
    //                 // print_r($dbarray);
    //                 if(count($dbarray) > 0){
    //                     $this->db->insert_batch('mech_module_permission' , $dbarray);
    //                 }
    //             }
    //         }
    //     }
    // }

    // public function change_workshop_status(){
    //     $this->db->select('work_order_id, work_from, work_from_id, invoice_group_id, jobsheet_status, jobsheet_no, work_order_status');
    //     $this->db->from('mech_work_order_dtls');
    //     $jobs = $this->db->get()->result();
    //     // print_r($jobs);
    //     if(count($jobs) > 0){
    //         $i = 1;
    //         foreach($jobs as $jb){
    //             // print_r($jb);
    //             $jobSheetStatus = 0;
    //             if($jb->jobsheet_status == 'C' || $jb->jobsheet_status == 'RA'){
    //                 $jobSheetStatus = 3;
    //             }else if($jb->jobsheet_status == 'Y'){
    //                 $jobSheetStatus = 1;
    //             }if($jb->jobsheet_status == 'P'){
    //                 $jobSheetStatus = 2;
    //             }
    //             echo $i++;
    //             $this->db->where('work_order_id' , $jb->work_order_id);
    //             $this->db->update('mech_work_order_dtls', array('jobsheet_status' => $jobSheetStatus));
    //         }
    //     }
    // }

    public function change_status_based_on_invoice(){
        $this->db->select('invoice_id, jobsheet_no, invoice_status');
        $this->db->from('mech_invoice');
        // $this->db->where('invoice_status', 'FP');
        $this->db->where("jobsheet_no != ''");
        $invoice = $this->db->get()->result();
        if(count($invoice) > 0){
            $i=1;
            foreach($invoice as $inv){
                if($inv->invoice_status == 'FP'){
                    $jobstats = 22;
                }else if($inv->invoice_status != 'D'){
                    $jobstats = 3;
                }
                if(!empty($inv->jobsheet_no)){
                    $this->db->where('jobsheet_no' , $inv->jobsheet_no);
                    $this->db->update('mech_work_order_dtls', array('jobsheet_status' => $jobstats));

                    $this->db->select('work_order_id , work_from, work_from_id');
                    $this->db->from('mech_work_order_dtls');
                    $this->db->where('jobsheet_no' , $inv->jobsheet_no);
                    $this->db->where("work_from != ''");
                    $this->db->where("work_from_id != ''");
                    $jobs = $this->db->get()->row();

                    if(!empty($jobs)){
                        if(!empty($jobs->work_from) && !empty($jobs->work_from_id)){
                            if($jobs->work_from == 'L'){
                                $status = 9;
                            }else if($jobs->work_from == 'A'){
                                $status = 8;
                            }
                            $this->db->where('ml_id', $jobs->work_from_id);
                            $this->db->update('mech_leads' , array('lead_status' => $status));
                        }
                    }
                }
            }
        }
    }

    public function change_lead_status_to_completed_with_appointment(){
        $this->db->select('ml_id, category_type, work_from, work_from_id');
        $this->db->from('mech_leads');
        $this->db->where('category_type' , 'A');
        $this->db->where("work_from != ''");
        $leads = $this->db->get()->result();
        print_r($leads);
        if(count($leads) > 0){
            $i = 0;
            foreach($leads as $leds){
                if(!empty($leds->work_from) && !empty($leds->work_from_id)){
                    $this->db->where('ml_id', $leds->work_from_id);
                    $this->db->update('mech_leads' , array('lead_status' => 9));
                    echo "index====".$i++."<br>";
                }
            }
        }
    }

    public function change_lead_status_to_completed_with_jobcard(){
        $this->db->select('work_order_id , work_from, work_from_id');
        $this->db->from('mech_work_order_dtls');
        $this->db->where('work_from' , 'L');
        $this->db->where("work_from_id != ''");
        $jobs = $this->db->get()->result();
        print_r($jobs);
        if(count($jobs) > 0){
            $i = 0;
            foreach($jobs as $leds){
                if(!empty($leds->work_from) && !empty($leds->work_from_id)){
                    $this->db->where('ml_id', $leds->work_from_id);
                    $this->db->update('mech_leads' , array('lead_status' => 9));
                    echo "index====".$i++."<br>";
                }
            }
        }
    }

    public function change_lead_status_to_completed_with_invoice(){
        $this->db->select('work_from, work_from_id');
        $this->db->from('mech_invoice');
        $this->db->where('work_from' , 'L');
        $this->db->where("work_from_id != ''");
        $invoices = $this->db->get()->result();
        print_r($invoices);
        if(count($invoices) > 0){
            $i = 0;
            foreach($invoices as $inv){
                if(!empty($inv->work_from) && !empty($inv->work_from_id)){
                    $this->db->where('ml_id', $inv->work_from_id);
                    $this->db->update('mech_leads' , array('lead_status' => 9));
                    echo "index====".$i++."<br>";
                }
            }
        }
    }


    public function change_appointment_status_to_completed_with_jobcard(){
        $this->db->select('work_order_id , work_from, work_from_id, jobsheet_status');
        $this->db->from('mech_work_order_dtls');
        $this->db->where('work_from' , 'A');
        $this->db->where("work_from_id != ''");
        $jobs = $this->db->get()->result();
        print_r($jobs);
        if(count($jobs) > 0){
            $i = 0;
            foreach($jobs as $leds){
                if(!empty($leds->work_from) && !empty($leds->work_from_id)){
                    if($leds->jobsheet_status == 1){
                        $status = 6;
                    }else if($leds->jobsheet_status == 2){
                        $status = 6;
                    }else if($leds->jobsheet_status == 3){
                        $status = 7;
                    }else if($leds->jobsheet_status == 22){
                        $status = 8;
                    }else{
                        $status = 8;
                    }
                    $this->db->where('ml_id', $leds->work_from_id);
                    $this->db->update('mech_leads' , array('lead_status' => $status));
                    echo "index====".$i++."<br>";
                }
            }
        }
    }

    

}