<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('sms_bulk/mdl_sms_bulk');
        $this->load->helper('settings_helper');
        $this->load->model('settings/mdl_settings');
        $this->load->model('sessions/mdl_sessions');
        $this->load->helper('mailer/phpmailer');
        $this->load->helper('mailer');
        $this->load->helper('date_helper');
    }

    public function create()
    {
        $smsbody = $this->input->post('smsbody');
        $client_list = json_decode($this->input->post('client_list'));
        if(!empty($smsbody) && count($client_list) > 0){
            $dbarray = array(
                'user_id' => $this->session->userdata('user_id'),
                'workshop_id' => $this->session->userdata('work_shop_id'),
                'branch_id' => $this->session->userdata('branch_id'),
                'body' => $this->input->post('smsbody'),
                'campaign_name' => $this->input->post('campaign_name'),
                'date' => date('Y-m-d'),
                'created_by' => $this->session->userdata('user_id'),
                'modified_by' => $this->session->userdata('user_id'),
                'created_on' => date('Y-m-d H:m:s'),
            );
            $this->db->insert('mech_sms_notification_dtls' , $dbarray);
            $insert_id = $this->db->insert_id();

            if(!empty($insert_id) && count($client_list) > 0){
                $dbclient = array();
                for($i = 0; $i < count($client_list); $i++){
                    $dbclient[] = array(
                        'mapped_id' => $insert_id,
                        'user_id' => $this->session->userdata('user_id'),
                        'workshop_id' => $this->session->userdata('work_shop_id'),
                        'branch_id' => $this->session->userdata('branch_id'),
                        'client_id' => $client_list[$i],
                        'sms_status' => 'P',
                        'created_by' => $this->session->userdata('user_id'),
                        'modified_by' => $this->session->userdata('user_id'),
                        'created_on' => date('Y-m-d H:m:s'),
                    );
                }
                if(count($dbclient) > 0){
                    $this->db->insert_batch('mech_clients_notification_sms_dtls', $dbclient);
                    $resposne = array(
                        'status' => true,
                        'success' => 1
                    );
                }else{
                    $resposne = array(
                        'status' => false,
                        'success' => 0
                    );
                }		  
            }
        }else{
            $resposne = array(
                'status' => false,
                'success' => 0
            );
        }
        echo json_encode($resposne);
        exit();
    }

    public function add()
    {
        $customer_name_list = $this->db->query('SELECT * FROM mech_clients where client_active = "A" and client_contact_no != " " and workshop_id = '.$this->session->userdata('work_shop_id').' ORDER BY client_name ASC')->result();

        $response = array( 
            'customer_name_list' => $customer_name_list,
        );
        echo json_encode($response);
        exit();
    }

    public function get_filter_list(){

        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;

        if($this->input->post('from_date')){  
            $this->mdl_sms_bulk->where('mech_sms_notification_dtls.date >=',date_to_mysql($this->input->post('from_date')));
        }
        
        if($this->input->post('to_date')){
            $this->mdl_sms_bulk->where('mech_sms_notification_dtls.date <=',date_to_mysql($this->input->post('to_date')));
        }

        if($this->input->post('campaign_name')){
            $this->mdl_sms_bulk->like('mech_sms_notification_dtls.campaign_name',$this->input->post('campaign_name'));
        }

        if($this->input->post('sms_status')){
            $this->mdl_sms_bulk->where('mech_clients_notification_sms_dtls.sms_status', $this->input->post('sms_status'));
        }
       
        $rowCount = $this->mdl_sms_bulk->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        if($this->input->post('from_date')){  
            $this->mdl_sms_bulk->where('mech_sms_notification_dtls.date >=',date_to_mysql($this->input->post('from_date')));
        }
        
        if($this->input->post('to_date')){
            $this->mdl_sms_bulk->where('mech_sms_notification_dtls.date <=',date_to_mysql($this->input->post('to_date')));
        }

        if($this->input->post('campaign_name')){
            $this->mdl_sms_bulk->like('mech_sms_notification_dtls.campaign_name',$this->input->post('campaign_name'));
        }

        if($this->input->post('sms_status')){
            $this->mdl_sms_bulk->where('mech_clients_notification_sms_dtls.sms_status', $this->input->post('sms_status'));
        }

        $this->mdl_sms_bulk->limit($limit,$start);
        $bulksms = $this->mdl_sms_bulk->get()->result();           

        foreach($bulksms as $key => $sms){
            $bulksms[$key]->pending_count = $this->mdl_sms_bulk->get_sms_status_count($sms->id, 'P');
            
            $bulksms[$key]->success_count = $this->mdl_sms_bulk->get_sms_status_count($sms->id, 'S');
            
            $bulksms[$key]->failed_count = $this->mdl_sms_bulk->get_sms_status_count($sms->id, 'F');

            $bulksms[$key]->cancelled_count = $this->mdl_sms_bulk->get_sms_status_count($sms->id, 'C');
        }

        $response = array(
            'success' => 1,
            'bulksms' => $bulksms, 
            'createLinks' => $createLinks,
        );
        echo json_encode($response);
    }
}