<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_subscription_details extends Response_Model
{
    public $table = 'mech_subscription_details';
    public $primary_key = 'mech_subscription_details.subscription_id';
    public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_subscription_details.subscription_id DESC');
    }

    public function default_where()
    {
		// $this->db->where('status', 'A');
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

    public function get_subscription_plan($subscription_id = null){
        return $this->db->query("SELECT * FROM mech_subscription_details where subscription_id = '".$subscription_id."' and workshop_id = '".$this->session->userdata('work_shop_id')."'")->result();
    }

    public function get_workshop_det($workshop_id = null){

        $this->db->select("ws.workshop_name,ws.workshop_gstin,ws.workshop_contact_no,ws.workshop_email_id,ws.workshop_street,ws.workshop_pincode,ar.city_name,st.state_name,cou.name");	
		$this->db->from('workshop_setup as ws');
	
        $this->db->join('city_lookup ar', 'ar.city_id=ws.workshop_city','LEFT');
        $this->db->join('mech_state_list st', 'st.state_id=ws.workshop_state', 'LEFT');
        $this->db->join('country_lookup cou', 'cou.id=ws.workshop_country', 'LEFT');

        $this->db->where('ws.workshop_id', $this->session->userdata('work_shop_id'));

		return $this->db->get()->result();
    }


}