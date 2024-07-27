<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_sms_bulk extends Response_Model
{
    public $table = 'mech_sms_notification_dtls';
    public $primary_key = 'mech_sms_notification_dtls.id';
    public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mech_sms_notification_dtls.id,mech_sms_notification_dtls.campaign_name,mech_sms_notification_dtls.body, 
        mech_sms_notification_dtls.user_id, mech_sms_notification_dtls.workshop_id, mech_sms_notification_dtls.branch_id, mech_sms_notification_dtls.date, 
        mech_sms_notification_dtls.created_on, count(mech_clients_notification_sms_dtls.client_id) as client_count,mech_clients_notification_sms_dtls.sms_status', false);
    }

    public function default_join()
    {
		$this->db->join('mech_clients_notification_sms_dtls', 'mech_clients_notification_sms_dtls.mapped_id = mech_sms_notification_dtls.id', 'left');
    }

    public function default_where()
    {
		$this->db->where('mech_sms_notification_dtls.workshop_id', $this->session->userdata('work_shop_id'));
		$this->db->where('mech_sms_notification_dtls.status', 'A');
    }

    public function default_GROUP_BY()
    {
        $this->db->GROUP_BY('mech_sms_notification_dtls.id');
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
    
    public function get_sms_status_count($id = null,$status = null)
    {    
        $this->db->select("count(sms_status) as statuscount");	
        $this->db->from('mech_clients_notification_sms_dtls');
        $this->db->where('sms_status', $status);
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