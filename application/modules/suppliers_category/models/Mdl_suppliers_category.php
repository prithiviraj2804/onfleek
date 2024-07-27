<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_suppliers_category extends Response_Model
{
    public $table = 'mech_suppliers_category';
    public $primary_key = 'mech_suppliers_category.suppliers_category_id';
    public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_suppliers_category.suppliers_category_id DESC');
    }

    public function default_where()
    {

        $this->db->where_in('workshop_id', array('1',$this->session->userdata('work_shop_id')));
        if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $this->db->where_in('w_branch_id', array('1',$this->session->userdata('branch_id')));
            $this->db->where_in('created_by', array('1',$this->session->userdata('user_id')));
		}else if($this->session->userdata('user_type') == 6){
            $array = $this->session->userdata('user_branch_id');
            array_push($array,1);
            $this->db->where_in('w_branch_id', $array);
        }
		$this->db->where('status', 'A');
    }

    public function validation_rules()
    {
        return array(
            'suppliers_category_name' => array(
                'field' => 'suppliers_category_name',
                'label' => trans('lable244'),
                'rules' => 'required|alpha_numeric_spaces'
            ),
            '_mm_csrf' => array(
                'field' => '_mm_csrf'
            )
        );
    }

    public function db_array()
    {
        $db_array = parent::db_array();
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

}