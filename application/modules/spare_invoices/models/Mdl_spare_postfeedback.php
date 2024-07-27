<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Spare_Postfeedback extends Response_Model
{
    public $table = 'spare_postfeedback';
    public $primary_key = 'spare_postfeedback.fb_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS spare_postfeedback.fb_id,spare_postfeedback.invoice_id,
        spare_postfeedback.customer_rating, spare_postfeedback.customer_description, spare_postfeedback.service_rating,
        spare_postfeedback.service_description, spare_postfeedback.technician_ratting, spare_postfeedback.technician_description', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('spare_postfeedback.fb_id', 'DESC');
    }
	
    public function validation_rules()
    {
        return array(
            'invoice_id' => array(
                'field' => 'invoice_id',
                // 'label' => trans('invoice_id'),
                'rules' => 'required'
            ),
            'customer_rating' => array(
                'field' => 'customer_rating',
                'label' => trans('lable419'),
                'rules' => 'required',
            ),
            'customer_description' => array(
                'field' => 'customer_description',
                'label' => trans('lable177'),
            ),
            'service_rating' => array(
                'field' => 'service_rating',
                'label' => trans('lable417'),
                'rules' => 'required',
            ),
            'service_description' => array(
                'field' => 'service_description',
                'label' => trans('lable1117'),
            ),
            'technician_ratting' => array(
                'field' => 'technician_ratting',
                'label' => trans('lable416'),
                'rules' => 'required',
            ),
            'technician_description' => array(
                'field' => 'technician_description',
                'label' => trans('lable1118'),
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