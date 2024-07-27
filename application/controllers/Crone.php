<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Appointmentdetail
 */
require FCPATH . 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
require_once APPPATH . 'libraries/REST_Controller.php';

class Crone extends REST_Controller{

	public function __construct()
    {

		parent::__construct();
		$this->load->model('settings/mdl_settings');
        $this->load->helper('settings');
	}

    function phpmail_send($from,$to,$subject,$message,$attachment_path = null,$cc = null,$bcc = null,$more_attachments = null) {
        $CI = &get_instance();
        $CI->load->library('crypt');

        // Create the basic mailer object
        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';
        $mail->isHTML();

        $email_send_method = $CI->db->select('setting_value')->from('ip_settings')->where('setting_key' , 'email_send_method')->get()->row()->setting_value;
        $smtp_server_address = $CI->db->select('setting_value')->from('ip_settings')->where('setting_key' , 'smtp_server_address')->get()->row()->setting_value;
        $smtp_port = $CI->db->select('setting_value')->from('ip_settings')->where('setting_key' , 'smtp_port')->get()->row()->setting_value;
        $smtp_authentication = $CI->db->select('setting_value')->from('ip_settings')->where('setting_key' , 'smtp_authentication')->get()->row()->setting_value;
        $smtp_security = $CI->db->select('setting_value')->from('ip_settings')->where('setting_key' , 'smtp_security')->get()->row()->setting_value;
        $smtp_verify_certs = $CI->db->select('setting_value')->from('ip_settings')->where('setting_key' , 'smtp_verify_certs')->get()->row()->setting_value;
        switch ($email_send_method) {
            case 'smtp':
                $mail->IsSMTP();

                // Set the basic properties
                $mail->Host = $smtp_server_address;
                $mail->Port = $smtp_port;

                // Is SMTP authentication required?
                if ($smtp_authentication) {
                    $mail->SMTPAuth = true;

                    $decoded = $CI->crypt->decode($CI->mdl_settings->get('smtp_password'));

                    $mail->Username = 'support@mechtoolz.com';  // 'progearautomotive@gmail.com'; //'services@mechpoint.care';            // SMTP username
                    $mail->Password = 'Empiric)*';

                    // $mail->Username = get_setting('smtp_username');
                    // $mail->Password = $decoded;
                }

                // Is a security method required?
                if ($smtp_security) {
                    $mail->SMTPSecure = $smtp_security;
                }

                // Check if certificates should not be verified
                if (!$smtp_verify_certs) {
                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );
                }

                break;
            case 'sendmail':
                $mail->IsMail();
                break;
            case 'phpmail':
            case 'default':
                $mail->IsMail();
                break;
        }

        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = $mail->normalizeBreaks($mail->html2text($message));

        if (is_array($from)) {
            // This array should be address, name
            $mail->setFrom($from[0], $from[1]);
        } else {
            // This is just an address
            $mail->setFrom($from);
        }

        // Allow multiple recipients delimited by comma or semicolon
        $to = (strpos($to, ',')) ? explode(',', $to) : explode(';', $to);

        // Add the addresses
        foreach ($to as $address) {
            $mail->addAddress($address);
        }

        if ($cc) {
            // Allow multiple CC's delimited by comma or semicolon
            $cc = (strpos($cc, ',')) ? explode(',', $cc) : explode(';', $cc);

            // Add the CC's
            foreach ($cc as $address) {
                $mail->addCC($address);
            }
        }

        if ($bcc) {
            // Allow multiple BCC's delimited by comma or semicolon
            $bcc = (strpos($bcc, ',')) ? explode(',', $bcc) : explode(';', $bcc);
            // Add the BCC's
            foreach ($bcc as $address) {
                $mail->addBCC($address);
            }
        }

        if (get_setting('bcc_mails_to_admin') == 1) {
            // Get email address of admin account and push it to the array
            $CI->load->model('users/mdl_users');
            $CI->db->where('user_id', 1);
            $admin = $CI->db->get('ip_users')->row();
            $mail->addBCC($admin->user_email);
        }

        // Add the attachment if supplied
        if ($attachment_path && get_setting('email_pdf_attachment')) {
            $mail->addAttachment($attachment_path);
        }
        // Add the other attachments if supplied
        if ($more_attachments) {
            foreach ($more_attachments as $paths) {
                $mail->addAttachment($paths['path'], $paths['filename']);
            }
        }

        // And away it goes...
        if ($mail->send()) {
            return true;
        } else {
            // Or not...
            print_r($mail->ErrorInfo);
            return false;
        }

    }

	public function sendmail_get()
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
            foreach($lists as $list){
                if($this->phpmail_send("services@mechpoint.care",strip_tags($list->client_email_id),$list->subject,$list->body,$list->attachment_url,null,null,null))
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
        $this->resendemails();
    }

    public function resendemails()
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
                if($this->phpmail_send("services@mechpoint.care",strip_tags($list->client_email_id),$list->subject,$list->body,$list->attachment_url,null,null,null))
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

    public function sendfirebasemail_get()
    {
        $json = file_get_contents('php://input');
		$obj = json_decode($json, TRUE);

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
                            'email_status' => 'F'
                        );
                        $this->db->where('id' , $list->mailer_id);
                        $this->db->update('mech_clients_notification_firebase_dtls', $db_array );
                    }
                }
            }
        }

        $this->resendfirebaseemails();
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

    public function resendfirebaseemails()
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
}