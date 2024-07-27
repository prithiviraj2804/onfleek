<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Workshop_Branch extends Response_Model
{
    public $table = 'workshop_branch_details';
    public $primary_key = 'workshop_branch_details.w_branch_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS workshop_branch_details.w_branch_id,workshop_branch_details.workshop_id,
        workshop_branch_details.branch_gstin,workshop_branch_details.display_board_name,workshop_branch_details.contact_person_name,
        workshop_branch_details.branch_contact_no,workshop_branch_details.branch_email_id,workshop_branch_details.branch_street,
        workshop_branch_details.branch_city,workshop_branch_details.branch_state,workshop_branch_details.branch_country,
        workshop_branch_details.branch_pincode,workshop_branch_details.branch_employee_count,workshop_branch_details.branch_since_from,,workshop_branch_details.estimate_description,
        workshop_branch_details.default_currency_id,workshop_branch_details.default_date_id,workshop_branch_details.invoice_description,workshop_branch_details.job_description,
        workshop_branch_details.is_product,workshop_branch_details.pos,workshop_branch_details.invoice_terms,workshop_branch_details.jobs_terms,workshop_branch_details.estimate_terms,
        workshop_branch_details.shift,workshop_branch_details.referral,workshop_branch_details.referral_amount,
        workshop_branch_details.referral_tax,workshop_branch_details.rewards,workshop_branch_details.rewards_amount,
        workshop_branch_details.rewards_tax,workshop_branch_details.created_by,workshop_branch_details.modified_by,
        workshop_branch_details.branch_status,ar.city_id,ar.city_name,cou.id,cou.name,st.state_id,st.state_name', false); 
    }

    public function default_order_by()
    {
        $this->db->order_by('workshop_branch_details.w_branch_id');
    }

	public function default_join()
    {
        $this->db->join('city_lookup ar', 'ar.city_id=workshop_branch_details.branch_city','LEFT');
        $this->db->join('country_lookup cou', 'cou.id=workshop_branch_details.branch_country', 'LEFT');
        $this->db->join('mech_state_list st', 'st.state_id=workshop_branch_details.branch_state', 'LEFT');
    }

    public function default_where()
    {
		$this->db->where('branch_status', 'A');
    }

    public function validation_rules()
    {
        return array(
            'workshop_id' => array(
                'field' => 'workshop_id',
                'label' => trans('lable683'),
                'rules' => 'required',
            ),
            'display_board_name' => array(
                'field' => 'display_board_name',
                'label' => trans('lable762'),
                'rules' => 'required',
            ),
            'contact_person_name' => array(
                'field' => 'contact_person_name',
                'label' => trans('lable764'),
                'rules' => 'required',
            ),
            'branch_contact_no' => array(
                'field' => 'branch_contact_no',
                'label' => trans('lable765'),
                'rules' => 'required',
            ),
            'branch_email_id' => array(
                'field' => 'branch_email_id',
                'label' => trans('lable766'),
                'rules' => 'required',
            ),
            'branch_street' => array(
                'field' => 'branch_street',
                'label' => trans('lable767'),
                'rules' => 'required',
            ),
            'branch_city' => array(
                'field' => 'branch_city',
                'label' => trans('lable770'),
            ),
            'branch_state' => array(
                'field' => 'branch_state',
                'label' => trans('lable769'),
            ),
            'branch_country' => array(
                'field' => 'branch_country',
                'label' => trans('lable768'),
                'rules' => 'required'
            ),
            'branch_pincode' => array(
                'field' => 'branch_pincode',
                'label' => trans('lable1017'),
                'rules' => 'required',
            ),
            'branch_employee_count' => array(
                'field' => 'branch_employee_count',
                'label' => trans('lable771'),
                'rules' => 'required',
            ),
            'branch_since_from' => array(
                'field' => 'branch_since_from',
                'label' => trans('lable712'),
                'rules' => 'required',
            ),
            'branch_gstin' => array(
                'field' => 'branch_gstin',
                'label' => trans('lable763'),
            ),
            'default_currency_id' => array(
                'field' => 'default_currency_id',
                'label' => trans('lable720'),
                'rules' => 'required',
            ),
            'default_date_id' => array(
                'field' => 'default_date_id',
                'label' => trans('lable854'),
                'rules' => 'required',
            ),
            'is_product' => array(
                'field' => 'is_product',
                'label' => trans('lable722'),
            ),
            'pos' => array(
                'field' => 'pos',
                'label' => trans('lable587'),
                'rules' => 'required',
            ),
            'shift' => array(
                'field' => 'shift',
                'label' => trans('lable151'),
                'rules' => 'required',
            ),
            'referral' => array(
                'field' => 'referral',
                'label' => trans('lable773'),
            ),
            'rewards' => array(
                'field' => 'rewards',
                'label' => trans('lable779'),
            ),
            'referral_amount' => array(
                'field' => 'referral_amount',
                // 'label' => trans('referral_amount'),
            ),
            'rewards_amount' => array(
                'field' => 'rewards_amount',
                // 'label' => trans('rewards_amount'),
            ),
            'referral_tax' => array(
                'field' => 'referral_tax',
                'label' => trans('lable774'),
            ),
            'rewards_tax' => array(
                'field' => 'rewards_tax',
                'label' => trans('lable778'),
            ),
            'invoice_terms' => array(
                'field' => 'invoice_terms',
                'label' => trans('lable119'),
            ),
            'jobs_terms' => array(
                'field' => 'jobs_terms',
                'label' => trans('lable269'),
            ),
            'invoice_description' => array(
                'field' => 'invoice_description',
                'label' => trans('lable388'),
            ),
            'job_description' => array(
                'field' => 'job_description',
                'label' => trans('lable388'),
            ),
            'estimate_terms' => array(
                'field' => 'estimate_terms',
                'label' => trans('lable837'),
            ),
            'estimate_description' => array(
                'field' => 'estimate_description',
                'label' => trans('lable388'),
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
        if (!isset($db_array['branch_status'])) {
            $db_array['branch_status'] = 'A';
        }
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

	public function get_workshop_branch_count($work_shop_id)
	{
		$this->db->select("count(w_branch_id) as total_branch");	
		$this->db->from('workshop_branch_details br');
		$this->db->where('br.workshop_id', $work_shop_id);
		return $this->db->get()->row()->total_branch;
    }
    
	public function get_company_branch_details($branchid = NULL)
	{
        $this->db->select("br.w_branch_id,br.workshop_id,br.branch_gstin,br.display_board_name,br.contact_person_name,br.branch_contact_no,br.branch_email_id,br.branch_street,br.branch_city,br.branch_state,br.branch_country,br.branch_pincode,br.branch_employee_count,br.branch_since_from,br.default_currency_id,br.default_date_id,br.is_product,br.pos,br.shift,br.referral,br.referral_amount,br.referral_tax,br.rewards,br.rewards_amount,br.rewards_tax,wk.workshop_name,wk.workshop_logo,ar.city_name,st.state_name,cou.name");	
		$this->db->from('workshop_branch_details as br');
		$this->db->join('workshop_setup wk', 'wk.workshop_id=br.workshop_id','LEFT');
		$this->db->join('city_lookup ar', 'ar.city_id=br.branch_city','LEFT');
        $this->db->join('mech_state_list st', 'st.state_id=br.branch_state','LEFT');
        $this->db->join('country_lookup cou', 'cou.id=br.branch_country','LEFT');
        $this->db->where('br.workshop_id', $this->session->userdata('work_shop_id'));
        if($branchid){
            $this->db->where('br.w_branch_id', $branchid);
        }else{
            $this->db->where('br.w_branch_id', $this->session->userdata('branch_id'));
        }
		return $this->db->get()->row();
	}

}