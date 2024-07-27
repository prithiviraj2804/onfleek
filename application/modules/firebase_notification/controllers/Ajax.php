<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('firebase_notification/mdl_firebase_notification');
        $this->load->helper('settings_helper');
        $this->load->model('settings/mdl_settings');
        $this->load->model('sessions/mdl_sessions');
        $this->load->helper('mailer/phpmailer');
        $this->load->helper('mailer');
        $this->load->helper('date_helper');
    }

    public function create()
    {
        if (!empty($_FILES)) {
            $targetPath = UPLOADS_FOLDER . 'email_files';
            $this->create_dir($targetPath . '/');
            $url_key = rand();
            $tempFile = $_FILES['file']['tmp_name'];
            $fileName = preg_replace('/\s+/', '_', $_FILES['file']['name']);
            $targetFile = $targetPath . '/' . $url_key . '_' . $fileName;
            $file_exists = file_exists($targetFile);
            $tempFileName = $url_key . '_' . $fileName;
            $path_parts = pathinfo($targetFile);
            if(($path_parts['extension'] == 'jpeg' || $path_parts['extension'] == 'JPEG' || 
                $path_parts['extension'] == 'png' || $path_parts['extension'] == 'PNG' ||
                $path_parts['extension'] == 'jpg' || $path_parts['extension'] == 'JPG' ||
                $path_parts['extension'] == 'gif' || $path_parts['extension'] == 'GIF' ||
                $path_parts['extension'] == 'tiff' || $path_parts['extension'] == 'TIFF' ||
                $path_parts['extension'] == 'pdf' || $path_parts['extension'] == 'PDF' ||
                $path_parts['extension'] == 'bmp' || $path_parts['extension'] == 'BMP' ||
                $path_parts['extension'] =='tif' || $path_parts['extension'] =='TIF') && !$file_exists) {       
                move_uploaded_file($tempFile, $targetFile);
            }
        }
        $attachment_url = $targetFile?$targetFile:'';
        $mailsubject = $this->input->post('mailsubject');
        $mailbody = $this->input->post('mailbody');
        $client_list = json_decode($this->input->post('client_list'));
        if(!empty($mailsubject) && !empty($mailbody) && count($client_list) > 0){
            $dbarray = array(
                'user_id' => $this->session->userdata('user_id'),
                'workshop_id' => $this->session->userdata('work_shop_id'),
                'branch_id' => $this->session->userdata('branch_id'),
                'campaign_name' => $this->input->post('campaign_name'),
                'subject' => $this->input->post('mailsubject'),
                'date' => date('Y-m-d'),
                'body' => strip_tags($this->input->post('mailbody')) ,
                'attachment_url' => $attachment_url,
                'created_by' => $this->session->userdata('user_id'),
                'modified_by' => $this->session->userdata('user_id'),
                'created_on' => date('Y-m-d H:m:s'),
            );
            $this->db->insert('mech_firebase_notification' , $dbarray);
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
                        'email_status' => 'P',
                        'created_by' => $this->session->userdata('user_id'),
                        'modified_by' => $this->session->userdata('user_id'),
                        'created_on' => date('Y-m-d H:m:s'),
                    );
                }
                if(count($dbclient) > 0){
                    $this->db->insert_batch('mech_clients_notification_firebase_dtls', $dbclient);
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


    public function create_dir($path, $chmod = '0777')
    {
        if (!(is_dir($path) || is_link($path))) {
            return mkdir($path, $chmod);
        } else {
            return false;
        }
    }

    public function add()
    {
        $customer_name_list = $this->db->query('SELECT * FROM mech_clients where client_active = "A" and device_token != " " and workshop_id = '.$this->session->userdata('work_shop_id').' ORDER BY client_name ASC')->result();

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
            $this->mdl_firebase_notification->where('mech_firebase_notification.date >=',date_to_mysql($this->input->post('from_date')));
        }
        
        if($this->input->post('to_date')){
            $this->mdl_firebase_notification->where('mech_firebase_notification.date <=',date_to_mysql($this->input->post('to_date')));
        }

        if($this->input->post('campaign_name')){
            $this->mdl_firebase_notification->like('mech_firebase_notification.campaign_name',$this->input->post('campaign_name'));
        }

        if($this->input->post('email_status')){
            $this->mdl_firebase_notification->where('mech_clients_notification_firebase_dtls.email_status', $this->input->post('email_status'));
        }
       
        $rowCount = $this->mdl_firebase_notification->get()->result();
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
            $this->mdl_firebase_notification->where('mech_firebase_notification.date >=',date_to_mysql($this->input->post('from_date')));
        }
        
        if($this->input->post('to_date')){
            $this->mdl_firebase_notification->where('mech_firebase_notification.date <=',date_to_mysql($this->input->post('to_date')));
        }

        if($this->input->post('campaign_name')){
            $this->mdl_firebase_notification->like('mech_firebase_notification.campaign_name',$this->input->post('campaign_name'));
        }

        if($this->input->post('email_status')){
            $this->mdl_firebase_notification->where('mech_clients_notification_firebase_dtls.email_status', $this->input->post('email_status'));
        }

        $this->mdl_firebase_notification->limit($limit,$start);
        $bulkemail = $this->mdl_firebase_notification->get()->result();
        
        foreach($bulkemail as $key => $email){
            $bulkemail[$key]->pending_count = $this->mdl_firebase_notification->get_email_status_count($email->id, 'P');
            
            $bulkemail[$key]->success_count = $this->mdl_firebase_notification->get_email_status_count($email->id, 'S');
            
            $bulkemail[$key]->failed_count = $this->mdl_firebase_notification->get_email_status_count($email->id, 'F');

            $bulkemail[$key]->cancelled_count = $this->mdl_firebase_notification->get_email_status_count($email->id, 'C');
        }
    
        $response = array(
            'success' => 1,
            'bulkemail' => $bulkemail, 

            'createLinks' => $createLinks,
        );
        echo json_encode($response);

    }

}