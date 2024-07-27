<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Custom_Reminder extends Response_Model
{

    public $table = 'mech_custom_reminder';
    public $primary_key = 'mech_custom_reminder.custom_reminder_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mech_custom_reminder.custom_reminder_id, mech_custom_reminder.workshop_id, mech_custom_reminder.w_branch_id,
        mech_custom_reminder.type_id, mech_custom_reminder.item_id, mech_custom_reminder.customer_car_id,
        mech_custom_reminder.customer_id, mech_custom_reminder.last_update, mech_custom_reminder.next_update_day,
        mech_custom_reminder.next_update, mech_custom_reminder.description, mech_custom_reminder.employee_id,
        mech_custom_reminder.email_notification,
        mech_owner_car_list.model_type,mech_owner_car_list.car_reg_no,mech_car_brand_details.brand_name,
        mech_car_brand_models_details.model_name,mech_brand_model_variants.variant_name,mech_clients.client_name,mech_clients.client_contact_no', false);
    }

    public function default_join()
    {
        $this->db->join('mech_owner_car_list','mech_owner_car_list.car_list_id = mech_custom_reminder.customer_car_id', 'left');
        $this->db->join('mech_car_brand_details', 'mech_car_brand_details.brand_id = mech_owner_car_list.car_brand_id', 'left');
		$this->db->join('mech_car_brand_models_details', 'mech_car_brand_models_details.model_id = mech_owner_car_list.car_brand_model_id', 'left');
        $this->db->join('mech_brand_model_variants', 'mech_brand_model_variants.brand_model_variant_id = mech_owner_car_list.car_variant', 'left');
        $this->db->join('mech_clients', 'mech_clients.client_id = mech_custom_reminder.customer_id', 'left');

    }

    public function default_where()
    {

        $this->db->where('mech_custom_reminder.workshop_id', $this->session->userdata('work_shop_id'));
		if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $this->db->where('mech_custom_reminder.w_branch_id', $this->session->userdata('branch_id'));
        }else if($this->session->userdata('user_type') == 6){
			$this->db->where_in('mech_custom_reminder.w_branch_id', $this->session->userdata('user_branch_id'));
        }
        $this->db->where('mech_custom_reminder.status' , "A");
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_custom_reminder.custom_reminder_id', "desc");
    }

    public function validation_rules()
    {
        return array(
            // 'type_id' => array(
            //     'field' => 'type_id',
            //     'label' => trans('type_id'),
            //     'rules' => 'required'
            // ),
            // 'item_id' => array(
            //     'field' => 'item_id',
            //     'label' => trans('item_id'),
            //     'rules' => 'required'
            // ),
            'customer_car_id' => array(
                'field' => 'customer_car_id',
                'label' => trans('lable575'),
                'rules' => 'required'
            ),
            'customer_id' => array(
                'field' => 'customer_id',
                'label' => trans('lable574'),
                'rules' => 'required'
            ),
            'last_update' => array(
                'field' => 'last_update',
                'label' => trans('lable570'),
                'rules' => 'required'
            ),
            'next_update_day' => array(
                'field' => 'next_update_day',
                'label' => trans('lable566'),
                //'rules' => 'required|trim|strip_tags|numeric',
            ),
            'next_update' => array(
                'field' => 'next_update',
                'label' => trans('lable570'),
                //'rules' => 'required'
            ),
            'description' => array(
                'field' => 'description',
                'label' => trans('lable177'),
            ),
            'employee_id' => array(
                'field' => 'employee_id',
                'label' => trans('lable292'),
                // 'rules' => 'required'
            ),
            'email_notification' => array(
                'field' => 'email_notification',
                'label' => trans('lable557'),
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
        unset($db_array['last_update']);
        unset($db_array['next_update']);
        $db_array['last_update'] = date_to_mysql($this->input->post('last_update'));
    	$db_array['next_update'] = date_to_mysql($this->input->post('next_update'));
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
