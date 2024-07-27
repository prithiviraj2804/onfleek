<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


class Mdl_Workshop_Setup extends Response_Model
{
    public $table = 'workshop_setup';
    public $primary_key = 'workshop_setup.workshop_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('workshop_setup.workshop_id');
    }
	public function default_join()
    {
        $this->db->join('city_lookup ar', 'ar.city_id=workshop_setup.workshop_city','LEFT');
        $this->db->join('mech_state_list st', 'st.state_id=workshop_setup.workshop_state', 'LEFT');
        $this->db->join('country_lookup cou', 'cou.id=workshop_setup.workshop_country', 'LEFT');
        $this->db->join('mech_subscription_details msd', 'msd.workshop_id=workshop_setup.workshop_id', 'LEFT');
    }
    public function default_where()
    {
		$this->db->where('workshop_setup.workshop_id', $this->session->userdata('work_shop_id'));
    }
    
    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'workshop_name' => array(
                'field' => 'workshop_name',
                'label' => trans('lable683'),
                'rules' => 'required'
            ),
            'owner_name' => array(
                'field' => 'owner_name',
                'label' => trans('lable684'),
                'rules' => 'required'
            ),
            'workshop_contact_no' => array(
                'field' => 'workshop_contact_no',
                'label' => trans('lable692'),
                'rules' => 'required'
            ),
            'workshop_email_id' => array(
                'field' => 'workshop_email_id',
                'label' => trans('lable693'),
               // 'rules' => 'required'
            ),
            'workshop_street' => array(
                'field' => 'workshop_street',
                'label' => trans('lable694'),
                'rules' => 'required'
            ),
            'workshop_city' => array(
                'field' => 'workshop_city',
                'label' => trans('lable697'),
                'rules' => 'required'
            ),
            'workshop_state' => array(
                'field' => 'workshop_state',
                'label' => trans('lable696'),
               'rules' => 'required'
            ),
            'service_cost_setup' => array(
                'field' => 'service_cost_setup',
                'label' => trans('lable872'),
            ),
            'workshop_country' => array(
                'field' => 'workshop_country',
                'label' => trans('lable695'),
                'rules' => 'required'
            ),
            'workshop_pincode' => array(
                'field' => 'workshop_pincode',
                'label' => trans('lable698'),
                'rules' => 'required'
            ),
            'registration_type' => array(
                'field' => 'registration_type',
                'label' => trans('lable699'),
                'rules' => 'required'
            ),
            'registration_number' => array(
                'field' => 'registration_number',
                'label' => trans('lable709'),
                //'rules' => 'required'
            ),
            'total_employee_count' => array(
                'field' => 'total_employee_count',
                'label' => trans('lable711'),
                'rules' => 'required'
            ),
            'since_from' => array(
                'field' => 'since_from',
                'label' => trans('lable712'),
                'rules' => 'required'
            ),
            'workshop_is_enabled_inventory' => array(
                'field' => 'workshop_is_enabled_inventory',
                'label' => trans('lable714'),
                'rules' => 'required'
            ),
            'is_mobileapp_enabled' => array(
                'field' => 'is_mobileapp_enabled',
                'label' => trans('lable1220'),
                'rules' => 'required'
            ),
            'workshop_is_enabled_jobsheet' => array(
                'field' => 'workshop_is_enabled_jobsheet',
                'label' => trans('lable715'),
                'rules' => 'required'
            ),
            'workshop_gstin' => array(
                'field' => 'workshop_gstin',
                'label' => trans('lable710')
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
        if (!isset($db_array['workshop_status'])) {
            $db_array['workshop_status'] = 'A';
        }
    	$db_array['created_by'] = $this->session->userdata('user_id');
    	$db_array['modified_by'] = $this->session->userdata('user_id');
        return $db_array;
    }

	public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();

        // Save the car
        $id = parent::save($id, $db_array);

        return $id;
    }
	
    public function getReferralList($w_branch_id){
        return $this->db->select('*')->from('mech_ws_rewards_config')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('w_branch_id', $w_branch_id)->where('status', 1)->get()->result();
    }

    public function getReferralLists(){
        if($this->session->userdata('user_type') == 3){
			return $this->db->select('*')->from('mech_ws_rewards_config')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', 1)->get()->result();
		}elseif($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 || $this->session->userdata('user_type') == 6){
			return $this->db->select('*')->from('mech_ws_rewards_config')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('w_branch_id', $this->session->userdata('branch_id'))->where('status', 1)->get()->result();
		}
    }
}
