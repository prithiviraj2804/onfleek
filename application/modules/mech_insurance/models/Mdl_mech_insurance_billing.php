<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Mech_Insurance_Billing extends Response_Model
{
    public $table = 'mech_insurance_billing';
    public $primary_key = 'mech_insurance_billing.mins_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mech_insurance_billing.mins_id, mech_insurance_billing.workshop_id, mech_insurance_billing.w_branch_id,
        mech_insurance_billing.insuranceBillingCheckBox, mech_insurance_billing.entity_id, mech_insurance_billing.entity_type, 
        mech_insurance_billing.ins_claim_type,mech_insurance_billing.ins_pro_name, mech_insurance_billing.ins_gstin_no, 
        mech_insurance_billing.contact_name,mech_insurance_billing.contact_number, mech_insurance_billing.contact_email, 
        mech_insurance_billing.contact_street,mech_insurance_billing.contact_area, mech_insurance_billing.contact_country, 
        mech_insurance_billing.contact_state,
        mech_insurance_billing.contact_city, mech_insurance_billing.contact_pincode, mech_insurance_billing.ins_claim,
        mech_insurance_billing.policy_no, mech_insurance_billing.driving_license, mech_insurance_billing.ins_start_date, 
        mech_insurance_billing.ins_exp_date, mech_insurance_billing.surveyor_contact_no, mech_insurance_billing.surveyor_name,
        mech_insurance_billing.surveyor_email, mech_insurance_billing.idv_amount, mech_insurance_billing.ins_claim_no,
        mech_insurance_billing.date_of_claim, mech_insurance_billing.claim_amount, mech_insurance_billing.ins_approved_amount,
        mech_insurance_billing.ins_approved_date, mech_insurance_billing.ins_status, mech_insurance_billing.policy_excess', false);
    }
        
    public function default_where(){
        $this->db->where('mech_insurance_billing.workshop_id' , $this->session->userdata('work_shop_id'));
        if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $this->db->where('mech_insurance_billing.w_branch_id' , $this->session->userdata('branch_id'));
		}else if($this->session->userdata('user_type') == 6){
            $this->db->where_in('mech_insurance_billing.w_branch_id' , $this->session->userdata('user_branch_id'));
        }
        $this->db->where('mech_insurance_billing.status' , 'A');
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_insurance_billing.mins_id', "desc");
    }
	
	public function validation_rules()
    {
        return array(
            'insuranceBillingCheckBox' => array(
                'field' => 'insuranceBillingCheckBox',
                'label' => trans('lable304'),
            ),
            'entity_id' => array(
                'field' => 'entity_id',
                'rules' => 'required',
            ),
            'entity_type' => array(
                'field' => 'entity_type',
                'rules' => 'required',
            ),
            'ins_claim_type' => array(
                'field' => 'ins_claim_type',
                'label' => trans('lable307'),
                'rules' => 'required',
            ),
            'ins_pro_name' => array(
                'field' => 'ins_pro_name',
                'label' => trans('lable311'),
                'rules' => 'required',
            ),
            'ins_gstin_no' => array(
                'field' => 'ins_gstin_no',
                'label' => trans('lable910'),
            ),
            'contact_name' => array(
                'field' => 'contact_name',
                'label' => trans('lable912'),
            ),
            'contact_number' => array(
                'field' => 'contact_number',
                'label' => trans('lable913'),
            ),
            'contact_email' => array(
                'field' => 'contact_email',
                'label' => trans('lable914'),
            ),
            'contact_street' => array(
                'field' => 'contact_street',
                'label' => trans('lable915'),
            ),
            'contact_area' => array(
                'field' => 'contact_area',
                'label' => trans('lable916'),
            ),
            'contact_country' => array(
                'field' => 'contact_country',
                'label' => trans('lable86'),
            ),
            'contact_state' => array(
                'field' => 'contact_state',
                'label' => trans('lable87'),
            ),
            'contact_city' => array(
                'field' => 'contact_city',
                'label' => trans('lable88'),
            ),
            'contact_pincode' => array(
                'field' => 'contact_pincode',
                'label' => trans('lable917'),
            ),
            'ins_claim' => array(
                'field' => 'ins_claim',
                'label' => trans('lable305'),
            ),
            'policy_no' => array(
                'field' => 'policy_no',
                'label' => trans('lable301'),
                'rules' => 'required',
            ),
            'driving_license' => array(
                'field' => 'driving_license',
                'label' => trans('lable918'),
            ),
            'ins_start_date' => array(
                'field' => 'ins_start_date',
                'label' => trans('lable312'),
            ),
            'ins_exp_date' => array(
                'field' => 'ins_exp_date',
                'label' => trans('lable313'),
                'rules' => 'required',
            ),
            'surveyor_contact_no' => array(
                'field' => 'surveyor_contact_no',
                'label' => trans('lable321'),
            ),
            'surveyor_name' => array(
                'field' => 'surveyor_name',
                'label' => trans('lable320'),
            ),
            'surveyor_email' => array(
                'field' => 'surveyor_email',
                'label' => trans('lable911'),
            ),
            'idv_amount' => array(
                'field' => 'idv_amount',
                'label' => trans('lable314'),
            ),
            'ins_claim_no' => array(
                'field' => 'ins_claim_no',
                'label' => trans('lable315'),
            ),
			'date_of_claim' => array(
                'field' => 'date_of_claim',
                'label' => trans('lable316'),
            ),
            'claim_amount' => array(
                'field' => 'claim_amount',
                'label' => trans('lable317'),
            ),
            'ins_approved_amount' => array(
                'field' => 'ins_approved_amount',
                'label' => trans('lable318'),
            ),
			'ins_approved_date' => array(
                'field' => 'ins_approved_date',
                'label' => trans('lable319'),
            ),
			'ins_status' => array(
                'field' => 'ins_status',
                'label' => trans('lable322'),
            ),
			'policy_excess' => array(
                'field' => 'policy_excess',
                'label' => trans('lable326'),
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
		return $db_array;
    }

	public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();
        $db_array['ins_start_date'] = ($this->input->post('ins_start_date')?date_to_mysql($this->input->post('ins_start_date')):NULL);
        $db_array['ins_exp_date'] = ($this->input->post('ins_exp_date')?date_to_mysql($this->input->post('ins_exp_date')):NULL);
        $db_array['date_of_claim'] = ($this->input->post('date_of_claim')?date_to_mysql($this->input->post('date_of_claim')):NULL);
        $db_array['ins_approved_date'] = ($this->input->post('ins_approved_date')?date_to_mysql($this->input->post('ins_approved_date')):NULL);
        $db_array['workshop_id'] =  $this->session->userdata('work_shop_id');
        $db_array['w_branch_id'] = $this->session->userdata('branch_id');
		$db_array['created_by'] = $this->session->userdata('user_id');
        $db_array['modified_by'] = $this->session->userdata('user_id');
        if(empty($id)){
            $db_array['created_on'] = date('Y-m-d H:m:s');
        }
        $id = parent::save($id, $db_array);
        return $id;
    }
	
}
