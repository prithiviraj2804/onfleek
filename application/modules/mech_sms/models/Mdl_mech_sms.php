<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Mech_Sms extends Response_Model
{
    public $table = 'mech_clients';
    public $primary_key = 'mech_clients.client_id';
    public $date_created_field = 'client_date_created';
    public $date_modified_field = 'client_date_modified';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mech_clients.*', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_clients.client_name');
    }

	public function default_where()
    {    
        $this->db->where('workshop_id' , $this->session->userdata('work_shop_id'));
        if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $this->db->where('w_branch_id' , $this->session->userdata('branch_id'));
            $this->db->where('client_created_by' , $this->session->userdata('user_id'));
        }else if($this->session->userdata('user_type') == 6){
            $this->db->where_in('w_branch_id' , $this->session->userdata('user_branch_id'));
        }
		$this->db->where('client_active', 'A');
    }

    public function validation_rules()
    {
        return array(
            'client_name' => array(
                'field' => 'client_name',
                'label' => trans('client_name'),
                'rules' => 'required|trim|strip_tags|alpha_numeric_spaces'
			),
            'client_contact_no' => array(
                'field' => 'client_contact_no',
                'label' => 'client_contact_no',
                'rules' => 'numeric|trim|strip_tags'
            ),
            'client_email_id' => array(
                'field' => 'client_email_id',
                'label' => trans('Email ID'),
                //'rules' => 'valid_email|trim|strip_tags'
			),
			'refered_by_type' => array(
                'field' => 'refered_by_type',
                'label' => trans('refered_by_type')
			),
			'refered_by_id' => array(
                'field' => 'refered_by_id',
                'label' => trans('refered_by_id')
			),
            '_mm_csrf' => array(
                'field' => '_mm_csrf'
            )
            
        );
    }

	public function validation_rules_model()
    {
        return array(
            'client_name' => array(
                'field' => 'client_name',
                'label' => trans('client_name'),
                'rules' => 'required|trim|strip_tags'
			),
			'branch_id' => array(
                'field' => 'branch_id',
                'label' => trans('branch_id'),
                'rules' => 'required',
            ),
            'client_contact_no' => array(
                'field' => 'client_contact_no',
                'label' => trans('Phone No'),
                'rules' => 'trim|strip_tags|numeric'
            ),
            'client_email_id' => array(
                'field' => 'client_email_id',
                'label' => trans('Email ID'),
                //'rules' => 'valid_email|trim|strip_tags'
			),
			'refered_by_type' => array(
                'field' => 'refered_by_type',
                'label' => trans('refered_by_type')
			),
			'refered_by_id' => array(
                'field' => 'refered_by_id',
                'label' => trans('refered_by_id')
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
		unset($db_array['action_from']);
        if (!isset($db_array['client_active'])) {
            $db_array['client_active'] = 'A';
        }
		unset($db_array['client_id']);
    	$db_array['client_created_by'] = $this->session->userdata('user_id');
    	$db_array['client_modified_by'] = $this->session->userdata('user_id');
		$db_array['workshop_id'] = $this->session->userdata('work_shop_id');
    	$db_array['w_branch_id'] = $this->session->userdata('branch_id');
        return $db_array;
    }

	public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();
        $id = parent::save($id, $db_array);

        return $id;
    }
	
    public function delete($id)
    {
        parent::delete($id);

        $this->load->helper('orphan');
        delete_orphans();
    }
    
}