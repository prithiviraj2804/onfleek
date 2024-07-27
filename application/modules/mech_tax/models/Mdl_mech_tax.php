<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Mech_tax extends Response_Model
{
    public $table = 'mech_tax';
    public $primary_key = 'mech_tax.tax_id';
	public $date_created_field = 'created_by';
    public $date_modified_field = 'modified_by';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_tax.tax_id', "ASC");
    }
    
	 public function default_where()
    {
        $this->db->where('mech_tax.status', 'A');
    }

    public function validation_rules()
    {
        return array(
            'tax_name' => array(
                'field' => 'tax_name',
                'label' => trans('lable1178'),
                'rules' => 'required'
            ),
            'tax_value' => array(
                'field' => 'tax_value',
                'label' => trans('lable1180'),
                'rules' => 'required'
            ),
            'hsn_code' => array(
                'field' => 'hsn_code',
                'label' => trans('lable1184')
            ),
            'tax_type' => array(
                'field' => 'tax_type',
                'label' => trans('lable1183'),
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
        if (!isset($db_array['status'])) {
            $db_array['status'] = 'A';
        }
		unset($db_array['tax_id']);
		$db_array['workshop_id'] = $this->session->userdata('work_shop_id');
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
