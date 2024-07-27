<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Tax_Rates extends Response_Model
{
    public $table = 'ip_tax_rates';
    public $primary_key = 'ip_tax_rates.tax_rate_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_where()
    {
        $this->db->where('ip_tax_rates.workshop_id' , $this->session->userdata('work_shop_id'));
        $this->db->where('ip_tax_rates.status != "D"');
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_tax_rates.tax_rate_percent');
    }

    public function validation_rules_tax()
    {
        return array(
            'tax_rate_name' => array(
                'field' => 'tax_rate_name',
                'label' => trans('lable980'),
                'rules' => 'required'
            ),
            'tax_rate_percent' => array(
                'field' => 'tax_rate_percent',
                'label' => trans('lable981'),
                'rules' => 'required'
			),
            'module_id' => array(
                'field' => 'module_id',
                'label' => trans('lable982'),
                // 'rules' => 'required'
            ),
            'apply_for' => array(
                'field' => 'apply_for',
                'label' => trans('lable983'),
                'rules' => 'required'
            ),
            'status' => array(
                'field' => 'status',
                'label' => trans('lable19'),
                'rules' => 'required'
            )
        );
    }

    public function db_array()
    {   
        $db_array = parent::db_array();
        unset($db_array['_mm_csrf']);    
        $db_array['workshop_id'] = $this->session->userdata('work_shop_id');
    	$db_array['created_by'] = $this->session->userdata('user_id');
    	$db_array['modified_by'] = $this->session->userdata('user_id');
        return $db_array;
    }

	public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();
        $db_array['module_id'] = $this->input->post('module_id')?implode(",",$this->input->post('module_id')):NULL;
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