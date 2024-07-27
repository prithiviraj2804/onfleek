<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Class Mdl_Payment_Methods.
 */
class Mdl_Payment_Methods extends Response_Model
{
    public $table = 'ip_payment_methods';
    public $primary_key = 'ip_payment_methods.payment_method_id';
    public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_where()
    {
		$this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
		$this->db->where('status', 'A');
    }

    public function order_by()
    {
        $this->db->order_by('ip_payment_methods.payment_method_name');
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'payment_method_name' => array(
                'field' => 'payment_method_name',
                'label' => trans('lable880'),
                'rules' => 'required',
            ),
        );
    }

    public function db_array()
    {
        $db_array = parent::db_array();
		unset($db_array['_mm_csrf']);
    	$db_array['created_by'] = $this->session->userdata('user_id');
    	$db_array['modified_by'] = $this->session->userdata('user_id');
		$db_array['workshop_id'] = $this->session->userdata('work_shop_id');
    	$db_array['w_branch_id'] = $this->session->userdata('branch_id');
        return $db_array;
    }

	public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();
        $id = parent::save($id, $db_array);
        return $id;
    }

    public function getPaymentMethodName($paymentMethodId = null)
    {
        return $this->db->select('payment_method_name')->from('ip_payment_methods')->where('payment_method_id', $paymentMethodId)->get()->row()->payment_method_name;
    }
}
