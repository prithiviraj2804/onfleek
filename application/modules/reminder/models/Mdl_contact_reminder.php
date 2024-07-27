<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Contact_Reminder extends Response_Model
{

    public $table = 'mech_contact_reminder';
    public $primary_key = 'mech_contact_reminder.contact_reminder_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_where()
    {
        $this->db->where('mech_contact_reminder.workshop_id', $this->session->userdata('work_shop_id'));
		if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $this->db->where('mech_contact_reminder.w_branch_id', $this->session->userdata('branch_id'));
            $this->db->where('mech_contact_reminder.created_by', $this->session->userdata('user_id'));
        }else if($this->session->userdata('user_type') == 6){
			$this->db->where_in('mech_contact_reminder.w_branch_id', $this->session->userdata('user_branch_id'));
        }
        $this->db->where('mech_contact_reminder.contact_reminder_status' , "A");
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_contact_reminder.contact_reminder_id', "desc");
    }

    public function validation_rules()
    {
        return array(
            'contact_reminder_next_due_date' => array(
                'field' => 'contact_reminder_next_due_date',
                'label' => trans('lable558'),
                'rules' => 'required'
            ),
            'status' => array(
                'field' => 'status',
                'label' => trans('lable19'),
                'rules' => 'required'
            ),
            'description' => array(
                'field' => 'description',
                'label' => trans('lable177'),
            ),
            'employee_id' => array(
                'field' => 'employee_id',
                'label' => trans('lable292'),
                'rules' => 'required'
            ),
            'contact_email_notification' => array(
                'field' => 'contact_email_notification',
                'label' => trans('lable557')
            ),
            'refered_by_type' => array(
                'field' => 'refered_by_type',
                'label' => trans('lable551'),
                'rules' => 'required'
            ),
            'refered_by_id' => array(
                'field' => 'refered_by_id',
                'label' => trans('lable559'),
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
        $db_array['contact_reminder_next_due_date'] = $this->input->post('contact_reminder_next_due_date')?date("Y-m-d h:i:s", strtotime($this->input->post('contact_reminder_next_due_date'))):date("Y-m-d h:i:s");
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
