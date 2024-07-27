<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Mech_Postfeedback extends Response_Model
{
    public $table = 'mech_postfeedback';
    public $primary_key = 'mech_postfeedback.fb_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mech_postfeedback.fb_id,mech_postfeedback.invoice_id,mech_postfeedback.feedback_no,mech_postfeedback.reschedule_date,
        mech_postfeedback.customer_rating,mech_postfeedback.customer_description,mech_postfeedback.service_rating,mech_postfeedback.created_on,
        mech_postfeedback.service_description,mech_postfeedback.technician_ratting,mech_postfeedback.technician_description,mech_postfeedback.fd_status,
        mech_invoice.invoice_id,mech_invoice.invoice_no', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_postfeedback.fb_id', 'DESC');
    }
 
    public function default_join()
    {
        $this->db->join('mech_invoice', 'mech_invoice.invoice_id = mech_postfeedback.invoice_id', 'left');
    }

    public function default_where(){
        $this->db->where('mech_postfeedback.workshop_id' , $this->session->userdata('work_shop_id'));
		if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $this->db->where('mech_postfeedback.w_branch_id' , $this->session->userdata('branch_id'));
            $this->db->where('mech_postfeedback.created_by' , $this->session->userdata('user_id'));
        }else if($this->session->userdata('user_type') == 6){
            $this->db->where_in('mech_postfeedback.w_branch_id' , $this->session->userdata('user_branch_id'));
		}
        $this->db->where('mech_postfeedback.status', 'A');
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
            'feedback_no' => array(
                'field' => 'feedback_no',
            ),
            'fd_status' => array(
                'field' => 'fd_status',
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
        // $db_array['date'] = date('Y-m-d');
        return $db_array;
    }

	public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();
        $id = parent::save($id, $db_array);
        return $id;
    }
    
}