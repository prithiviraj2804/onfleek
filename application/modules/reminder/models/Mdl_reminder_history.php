<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Reminder_History extends Response_Model
{

    public $table = 'mech_reminder_history';
    public $primary_key = 'mech_reminder_history.mr_history_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_where()
    {

        $this->db->where('mech_reminder_history.workshop_id', $this->session->userdata('work_shop_id'));
		if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $this->db->where('mech_reminder_history.w_branch_id', $this->session->userdata('branch_id'));
        }else if($this->session->userdata('user_type') == 6){
			$this->db->where_in('mech_reminder_history.w_branch_id', $this->session->userdata('user_branch_id'));
        }
        $this->db->where('mech_reminder_history.status' , "A");
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_reminder_history.mr_history_id', "desc");
    }

    public function validation_rules()
    {
        return array(
            'reminder_id' => array(
                'field' => 'reminder_id',
                'label' => trans('reminder_id'),
                'rules' => 'required'
            ),
            'reminder_type' => array(
                'field' => 'reminder_type',
                'label' => trans('lable548'),
                'rules' => 'required'
            ),
            'current_schedule_date' => array(
                'field' => 'current_schedule_date',
                'label' => trans('lable577'),
                'rules' => 'required'
            ),
            'next_schedule_day' => array(
                'field' => 'next_schedule_day',
                'label' => trans('lable555'),
                'rules' => 'required|trim|strip_tags|numeric',
            ),
            'next_schedule_date' => array(
                'field' => 'next_schedule_date',
                'label' => trans('lable554'),
                'rules' => 'required'
            ),
            'description' => array(
                'field' => 'description',
                'label' => trans('lable177'),
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
        unset($db_array['current_schedule_date']);
        unset($db_array['next_schedule_date']);
        $db_array['current_schedule_date'] = date_to_mysql($this->input->post('current_schedule_date'));
    	$db_array['next_schedule_date'] = date_to_mysql($this->input->post('next_schedule_date'));
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
