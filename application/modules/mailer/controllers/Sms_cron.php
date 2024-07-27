<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sms_cron extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function sendSms()
    {
        $this->db->select('me.body, mn.id as sms_id, mn.mapped_id, mn.client_id, mn.sms_status, cli.client_email_id');
        $this->db->from('mech_sms_notification_dtls as me');
        $this->db->join('mech_clients_notification_sms_dtls as mn','mn.mapped_id = me.id','left' );
        $this->db->join('mech_clients as cli','cli.client_id = mn.client_id','left' );
        $this->db->where('mn.sms_status' , 'P');
        $this->db->where('mn.status' , 'A');
        $this->db->where('me.status' , 'A');
        $this->db->order_by('mn.id');
        $lists = $this->db->get()->result();
        if(count($lists) > 0){
            foreach($lists as $list){
                $send_sms = send_sms(htmlspecialchars($list->client_contact_no),$list->body);

                if($send_sms->status == 'failure')
                {
                    $db_array = array (
                        'sms_status' => 'F'
                    );
                    $this->db->where('id' , $list->sms_id);
                    $this->db->update('mech_clients_notification_sms_dtls', $db_array );
                }
                 else
                {
                    $db_array = array (
                        'sms_status' => 'S'
                    );
                    $this->db->where('id' , $list->sms_id);
                    $this->db->update('mech_clients_notification_sms_dtls', $db_array );   
                }
            }
        }
        $this->resendSms();
    }

    public function resendSms()
    {
        $this->db->select('me.body, mn.id as sms_id, mn.mapped_id, mn.client_id, mn.sms_status, cli.client_email_id');
        $this->db->from('mech_sms_notification_dtls as me');
        $this->db->join('mech_clients_notification_sms_dtls as mn','mn.mapped_id = me.id','left' );
        $this->db->join('mech_clients as cli','cli.client_id = mn.client_id','left' );
        $this->db->where('mn.sms_status' , 'F');
        $this->db->where('mn.status' , 'A');
        $this->db->where('me.status' , 'A');
        $this->db->order_by('mn.id');
        $lists = $this->db->get()->result();
        if(count($lists) > 0){
            foreach($lists as $list){
                $send_sms = send_sms(htmlspecialchars($list->client_contact_no),$list->body);
                if($send_sms->status == 'failure')
                {
                    $db_array = array (
                        'sms_status' => 'C'
                    );
                    $this->db->where('id' , $list->sms_id);
                    $this->db->update('mech_clients_notification_sms_dtls', $db_array );
                }
                 else
                {
                    $db_array = array (
                        'sms_status' => 'S'
                    );
                    $this->db->where('id' , $list->sms_id);
                    $this->db->update('mech_clients_notification_sms_dtls', $db_array );   
                }
            }
        }
    }
}
