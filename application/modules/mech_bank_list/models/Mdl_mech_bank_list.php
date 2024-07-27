<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Mech_Bank_List extends Response_Model
{
    public $table = 'mech_workshop_bank_list';
    public $primary_key = 'mech_workshop_bank_list.bank_id';
	public $date_created_field = 'bank_date_created';
    public $date_modified_field = 'bank_date_modified';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mech_workshop_bank_list.bank_id,mech_workshop_bank_list.module_type,
        mech_workshop_bank_list.entity_id,mech_workshop_bank_list.workshop_id,mech_workshop_bank_list.w_branch_id,
        mech_workshop_bank_list.branch_id,mech_workshop_bank_list.account_holder_name,mech_workshop_bank_list.account_number,
        mech_workshop_bank_list.account_type,mech_workshop_bank_list.bank_name,mech_workshop_bank_list.bank_ifsc_Code,
        mech_workshop_bank_list.bank_branch,mech_workshop_bank_list.current_balance,mech_workshop_bank_list.is_default,
        br.display_board_name', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_workshop_bank_list.bank_id', "desc");
    }

    public function default_join()
    {
       $this->db->join('workshop_branch_details br', 'br.w_branch_id = mech_workshop_bank_list.w_branch_id');
    }
    
	 public function default_where()
    {
        $this->db->where('mech_workshop_bank_list.bank_status', 'A');
    }

    public function validation_rules()
    {
        return array(
            'module_type' => array(
                'field' => 'module_type',
                // 'label' => 'module_type',
                'rules' => 'required'
            ),
            'branch_id' => array(
                'field' => 'branch_id',
                'label' => trans('lable95'),
                'rules' => 'required'
            ),
            'entity_id' => array(
                'field' => 'entity_id',
            ),
            'is_default' => array(
                'field' => 'is_default',
                'label' => trans('lable69')
            ),
           'account_holder_name' => array(
                'field' => 'account_holder_name',
                'label' => trans('lable97'),
                'rules' => 'required'
            ),
            'account_number' => array(
                'field' => 'account_number',
                'label' => trans('lable98'),
                'rules' => 'required|regex_match[/^\d+$/]'
            ),
            'account_type' => array(
                'field' => 'account_type',
                'label' => trans('lable101'),
                'rules' => 'required'
            ),
            'bank_name' => array(
                'field' => 'bank_name',
                'label' => trans('lable99'),
                'rules' => 'required'
            ),
            'bank_ifsc_Code' => array(
                'field' => 'bank_ifsc_Code',
                'label' => trans('lable100'),
                'rules' => 'required|regex_match[/^[a-z0-9]+$/i]'
            ),
            'current_balance' => array(
                'field' => 'current_balance',
                'label' => trans('lable96'),
            ),
            'bank_branch' => array(
                'field' => 'bank_branch',
                'label' => trans('lable761'),
                // 'rules' => 'required'
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
        if (!isset($db_array['bank_status'])) {
            $db_array['bank_status'] = 'A';
        }
		unset($db_array['bank_id']);
		$db_array['workshop_id'] = $this->session->userdata('work_shop_id');
    	$db_array['w_branch_id'] = $this->input->post('branch_id');
    	$db_array['created_user_id'] = $this->session->userdata('user_id');
    	$db_array['modified_user_id'] = $this->session->userdata('user_id');
        return $db_array;
    }

	public function save($id = null, $db_array = null)
    {
    	$this->update_default_bank_flag($this->input->post('is_default'));
        $db_array = ($db_array) ? $db_array : $this->db_array();
        $id = parent::save($id, $db_array);
        return $id;
    }

	public function update_default_bank_flag($is_default){
        $this->db->where('workshop_id',$this->session->userdata('work_shop_id'));
        $this->db->where('w_branch_id',$this->session->userdata('branch_id'));
        $this->db->update('mech_workshop_bank_list',array("is_default"=>'N'));
    }

	public function get_wb_total_bank()
	{
		if($this->session->userdata('user_type') == 3){
			$this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
		}elseif($this->session->userdata('user_type') == 4){
			$this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
            $this->db->where('w_branch_id', $this->session->userdata('branch_id'));
            $this->db->where('created_user_id', $this->session->userdata('user_id'));
		}
		$this->db->where('status', 'A');
    	$bank_data = $this->db->get('mech_workshop_bank_list');
		return count($bank_data->result());
    }
    
    public function getEmployeebanklist($entity_id,$module_type){
        return $this->mdl_mech_bank_list->where('mech_workshop_bank_list.workshop_id', $this->session->userdata('work_shop_id'))->where('mech_workshop_bank_list.entity_id', $entity_id)->where('mech_workshop_bank_list.module_type', $module_type)->get()->result();
    }
    
    
}
