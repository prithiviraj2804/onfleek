<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('clients/mdl_clients');
        $this->load->model('workshop_branch/mdl_workshop_branch');
    }

    public function sendsms()
    { 
        $client = $this->input->post('client');
        $clients = $this->input->post('clients');
        $text_message = $this->input->post('text_message');
        $sms = $this->input->post('sms');

        if(base_url() != "http://localhost/mechtool/"){
            if($sms == 1){
                if($client){
                    $client_details = $this->mdl_clients->where('client_id', $client)->get()->row();
                    if(!empty($client_details)){
                        $txt = "2345 is your dynamic access code for MechPoint";
                        if($client_details->client_contact_no){
                            $param = array(
                                'client_contact_no' => $client_details->client_contact_no,
                                'text_message'=>$txt
                            );
                            $sms  = send_sms($client_details->client_contact_no,$txt);
                            if($sms->status == "success"){
                                $db_sms_array = array(
                                    'user_id' => $this->session->userdata('user_id'),
                                    'name' => $client_details->client_name,
                                    'email_id' => $client_details->client_email_id,
                                    'mobile_number' => $client_details->client_contact_no,
                                    'message' => $txt,
                                    'type' => 3,
                                    'status' => 'S',
                                    'created_on' => date('Y-m-d H:m:s')
                                ); 
                            }else{
                                $db_sms_array = array(
                                    'user_id' => $this->session->userdata('user_id'),
                                    'name' => $client_details->client_name,
                                    'email_id' => $client_details->client_email_id,
                                    'mobile_number' => $client_details->client_contact_no,
                                    'message' => $txt,
                                    'type' => 3,
                                    'status' => 'F',
                                    'created_on' => date('Y-m-d H:m:s')
                                ); 
                            }
                            $this->db->insert('tc_sms_log', $db_sms_array);
                        }
                    }
                }
            }else if($sms == 2){
                if(count($clients) > 0){
                    foreach($clients as $client_id){
                        $client_details = $this->mdl_clients->where('client_id', $client_id)->get()->row();
                        if(!empty($client_details)){
                            if($client_details->client_contact_no){
                                $param = array(
                                    'client_contact_no' => $client_details->client_contact_no,
                                    'text_message'=>$text_message
                                );
                                $this->background_service->do_in_background(base_url()."index.php/mech_sms/send_message", $param);
                            }
                        }
                    }
                }
            }
        }
        
        $response = array(
            'success' => 1
        );
        echo json_encode($response);
    }

    public function modalSendRemainderSms($entity_id = NULL, $entity_type = NULL){

        $this->load->module('layout');
        $this->load->model('mech_invoices/mdl_mech_invoice');
        $this->load->model('mech_pos_invoices/mdl_mech_pos_invoice');
        $this->load->model('mech_purchase/mdl_mech_purchase');
        $this->load->model('mech_leads/Mdl_Mech_Leads');
        $this->load->model('mech_appointments/mdl_mech_leads');
        $this->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');

        if($entity_type == "I"){
            $details = $this->mdl_mech_invoice->where( 'invoice_id' , $entity_id )->get()->row();
        }else if($entity_type == "POS"){
            $details = $this->mdl_mech_pos_invoice->where( 'invoice_id' , $entity_id )->get()->row();
        }else if($entity_type == "P"){
            $details = $this->mdl_mech_purchase->where( 'purchase_id' , $entity_id )->get()->row();
        }else if($entity_type == "L"){
            $details = $this->Mdl_Mech_Leads->where( 'ml_id' , $entity_id )->get()->row();
        }else if($entity_type == "A"){
            $details = $this->mdl_mech_leads->where( 'ml_id' , $entity_id )->get()->row();
        }else if($entity_type == "J"){
            $details = $this->mdl_mech_work_order_dtls->where( 'work_order_id' , $entity_id )->get()->row();
        }

		$work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');
        $data = array(
            'details' => $details,
            'entity_type' => $entity_type,
            'entity_id' => $entity_id
        );

        $this->layout->load_view('mech_sms/modalSendRemainderSms', $data);

    }

    public function sendRemainderSMS(){

        $this->load->model('mech_invoices/mdl_mech_invoice');
        $this->load->model('mech_pos_invoices/mdl_mech_pos_invoice');
        $this->load->model('mech_purchase/mdl_mech_purchase');
        $this->load->model('mech_leads/Mdl_Mech_Leads');
        $this->load->model('mech_appointments/mdl_mech_leads');
        $this->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');

        $remainder_id = $this->input->post('remainder_id');
        $entity_type = $this->input->post('entity_type');
        $entity_id = $this->input->post('entity_id');

        if(base_url() != "http://localhost/mechtool/"){

            if($entity_type == "I"){
                if($entity_id){
                    $details = $this->mdl_mech_invoice->where('invoice_id' , $entity_id)->get()->row();
                    $invoice_no = $details->invoice_no;
                    $invoice_date = $details->invoice_date;
                    $client_name = $details->client_name;
                    if(!empty($details)){
                        if($details->client_contact_no){
                            if(strlen((string) $details->client_contact_no) >= 7){
                                if($remainder_id == 1){
                                    $txt = "Hi ".$client_name.", Reminder - Your vehicle is ready for delivery. Please pay your due-amount Rs.".$details->total_due_amount.".";
                                   
                                }else{
                                    $txt = "Hi ".$client_name.", Warning - Your vehicle is ready for delivery. Please pay your due-amount  Rs.".$details->total_due_amount.".";
                                }
                                $send = send_sms($details->client_contact_no,$txt);
                                //$send = send_sms("9600062564",$txt);
                            }else{
                                $response = array(
                                    'success' => 0,
                                    'error' => 'mobile Number is invalid'
                                );
                                echo json_encode($response);
                                exit();
                            }
                        }else{
                            $response = array(
                                'success' => 0,
                                'error' => "mobile Number doesn't exist",
                            );
                            echo json_encode($response);
                            exit();
                        }
                    }
                }
            }else if($entity_type == "J"){
                if($entity_id){
                    $details = $this->mdl_mech_work_order_dtls->where('work_order_id' , $entity_id)->get()->row();
                    $jobsheet_no = $details->jobsheet_no;
                    $issue_date = $details->issue_date;
                    $client_name = $details->client_name;
                    if(!empty($details)){
                        if($details->client_contact_no){
                            if(strlen((string) $details->client_contact_no) >= 7){
                                if($remainder_id == 1){
                                    $txt = "Hi ".$client_name.", ".$jobsheet_no." -Your vehicle service is being started. We will update you once its done";
                                }else if($remainder_id == 2){
                                    $txt = "Hi ".$client_name.", Your vehicle service has been completed. Your invoice-amount is Rs.".$details->grand_total.".";
                                }else if($remainder_id == 3){
                                    $txt = "Hi ".$client_name.", Your vehicle service is being started againleted. We will update you once its done";
                                }
                                $send = send_sms($details->client_contact_no,$txt);
                                //$send = send_sms("9600062564",$txt);
                            }else{
                                $response = array(
                                    'success' => 0,
                                    'error' => 'mobile Number is invalid'
                                );
                                echo json_encode($response);
                                exit();
                            }
                        }else{
                            $response = array(
                                'success' => 0,
                                'error' => "mobile Number doesn't exist",
                            );
                            echo json_encode($response);
                            exit();
                        }
                    }
                }
            }

        }
        
        $response = array(
            'success' => 1
        );
        echo json_encode($response);
    }

}