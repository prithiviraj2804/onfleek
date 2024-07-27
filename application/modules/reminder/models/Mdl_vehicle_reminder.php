<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_vehicle_Reminder extends Response_Model
{

    public $table = 'mech_vehicle_reminder';
    public $primary_key = 'mech_vehicle_reminder.vehicle_reminder_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_vehicle_reminder.vehicle_reminder_id', "desc");
    }

    public function default_where(){
        $this->db->where('mech_vehicle_reminder.workshop_id', $this->session->userdata('work_shop_id'));
		if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $this->db->where('mech_vehicle_reminder.w_branch_id', $this->session->userdata('branch_id'));
            $this->db->where('mech_vehicle_reminder.created_by', $this->session->userdata('user_id'));
        }else if($this->session->userdata('user_type') == 6){
			$this->db->where_in('mech_vehicle_reminder.w_branch_id', $this->session->userdata('user_branch_id'));
        }
        $this->db->where('mech_vehicle_reminder.vehicle_reminder_status = "A"');
    }

    public function validation_rules()
    {
        return array(
            'reminder_vehicle_id' => array(
                'field' => 'reminder_vehicle_id',
                'label' => trans('reminder_vehicle_id'),
                'rules' => 'required'
            ),
            'vehicle_renewal_type_id' => array(
                'field' => 'vehicle_renewal_type_id',
                'label' => trans('vehicle_renewal_type_id'),
                'rules' => 'required'
            ),
            'vehicle_reminder_next_due_date' => array(
                'field' => 'vehicle_reminder_next_due_date',
                'label' => trans('vehicle_reminder_next_due_date'),
                'rules' => 'required'
            ),
            'vehicle_time_interval' => array(
                'field' => 'vehicle_time_interval',
                'label' => trans('vehicle_time_interval'),
            ),
            'vehicle_time_frequency' => array(
                'field' => 'vehicle_time_frequency',
                'label' => trans('vehicle_time_frequency'),
            ),
            'vehicle_email_notification' => array(
                'field' => 'vehicle_email_notification',
                'label' => trans('vehicle_email_notification')
            ),
            'entity_id' => array(
                'field' => 'entity_id',
                'label' => trans('entity_id'),
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
		unset($db_array['_mm_csrf']);
        $db_array['workshop_id'] = $this->session->userdata('work_shop_id');
    	$db_array['w_branch_id'] = $this->session->userdata('branch_id');
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

}
