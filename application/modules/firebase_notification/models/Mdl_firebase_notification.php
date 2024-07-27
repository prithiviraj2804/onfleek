<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_firebase_notification extends Response_Model
{
    public $table = 'mech_firebase_notification';
    public $primary_key = 'mech_firebase_notification.id';
    public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mech_firebase_notification.id,mech_firebase_notification.campaign_name,mech_firebase_notification.subject, mech_firebase_notification.body, mech_firebase_notification.attachment_url, 
        mech_firebase_notification.date, mech_firebase_notification.user_id, mech_firebase_notification.workshop_id, mech_firebase_notification.branch_id, 
        mech_firebase_notification.created_on, count(mech_clients_notification_firebase_dtls.client_id) as client_count', false);
    }

    public function default_join()
    {
		$this->db->join('mech_clients_notification_firebase_dtls', 'mech_clients_notification_firebase_dtls.mapped_id = mech_firebase_notification.id', 'left');
    }

    public function default_where()
    {
		$this->db->where('mech_firebase_notification.workshop_id', $this->session->userdata('work_shop_id'));
		$this->db->where('mech_firebase_notification.status', 'A');
    }

    public function default_GROUP_BY()
    {
        $this->db->GROUP_BY('mech_firebase_notification.id');
    }    

    public function validation_rules()
    {
        return array(
            'plan_name' => array(
                'field' => 'plan_name',
                'label' => trans('lable1042'),
                'rules' => 'required'
            ),
            'monthly_amount' => array(
                'field' => 'monthly_amount',
                'label' => trans('lable1043'),
                'rules' => 'required'
            ),
            '_mm_csrf' => array(
                'field' => '_mm_csrf'
            )
        );
    }

    public function db_array()
    {
        $db_array = parent::db_array();
    	$db_array['created_by'] = $this->session->userdata('user_id');
    	$db_array['modified_by'] = $this->session->userdata('user_id');
        return $db_array;
    }

	public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();
        $id = parent::save($id, $db_array);
        return $id;
    }

    public function get_email_status_count($id = null, $status = null)
    {    
        $this->db->select("count(email_status) as statuscount");	
        $this->db->from('mech_clients_notification_firebase_dtls');
        $this->db->where('email_status', $status);
        $this->db->where('mapped_id', $id);
        $this->db->where('status', 'A');
        $this->db->group_by('mapped_id');
        $status_count = $this->db->get()->row()->statuscount;
        if(empty($status_count)){
            return 0;
        }
        return $status_count;
    }
}