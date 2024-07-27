<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mech_Sms extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_mech_sms');
        $this->load->model('clients/mdl_clients');
        
    }

    public function index($page = 0)
    {

        $this->mdl_clients->paginate(site_url('clients/index'), $page);
		$clients = $this->mdl_clients->result();

        $this->layout->set(
            array(
                'clients' => $clients,
            )
        );

        $this->layout->buffer('content', 'mech_sms/index');
        $this->layout->render();
    }

    public function send_message(){
        
        $mobile_no = $this->input->post('client_contact_no');
		$txt = $this->input->post('text_message');
        $sms = send_sms($mobile_no,$txt);
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

