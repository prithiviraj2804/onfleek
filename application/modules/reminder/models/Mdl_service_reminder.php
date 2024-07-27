<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_service_Reminder extends Response_Model
{

    public $table = 'mech_service_remainder';
    public $primary_key = 'mech_service_remainder.service_remainder_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_where()
    {
        $this->db->where('mech_service_remainder.workshop_id', $this->session->userdata('work_shop_id'));
		if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $this->db->where('mech_service_remainder.w_branch_id', $this->session->userdata('branch_id'));
            $this->db->where('mech_service_remainder.created_by', $this->session->userdata('user_id'));
        }else if($this->session->userdata('user_type') == 6){
			$this->db->where_in('mech_service_remainder.w_branch_id', $this->session->userdata('user_branch_id'));
        }
        $this->db->where('mech_service_remainder.entity_id != " "');
        $this->db->where('mech_service_remainder.service_reminder_status' , "A");
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_service_remainder.service_remainder_id', "desc");
    }

    public function validation_rules()
    {
        return array(
            'service_vehicle_id' => array(
                'field' => 'service_vehicle_id',
                'label' => trans('service_vehicle_id'),
                'rules' => 'required'
            ),
            'services_id' => array(
                'field' => 'services_id',
                'label' => trans('services_id'),
                'rules' => 'required'
            ),
            'service_completed_on' => array(
                'field' => 'service_completed_on',
                'label' => trans('service_completed_on'),
                'rules' => 'required'
            ),
            'service_meter_interval' => array(
                'field' => 'service_meter_interval',
                'label' => trans('service_meter_interval'),
            ),
            'service_time_interval' => array(
                'field' => 'service_time_interval',
                'label' => trans('service_time_interval'),
            ),
            'service_time_interval_frequency' => array(
                'field' => 'service_time_interval_frequency',
                'label' => trans('service_time_interval_frequency'),
            ),
            'service_meter_threshold' => array(
                'field' => 'service_meter_threshold',
                'label' => trans('service_meter_threshold'),
            ),
            'service_time_threshold' => array(
                'field' => 'service_time_threshold',
                'label' => trans('service_time_threshold'),
            ),
            'service_time_threshold_frequency' => array(
                'field' => 'service_time_threshold_frequency',
                'label' => trans('service_time_threshold_frequency'),
            ),
            'service_email_notification' => array(
                'field' => 'service_email_notification',
                'label' => trans('service_email_notification')
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
