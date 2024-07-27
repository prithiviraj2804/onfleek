<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mdl_Mech_Service_Price_List extends Response_Model
{
    public $table = 'mech_service_item_price_list';
    public $primary_key = 'mech_service_item_price_list.msipl_id';
    public $date_created_field = 'created_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mech_service_item_price_list.msipl_id,
        mech_service_item_price_list.workshop_id, mech_service_item_price_list.w_branch_id,
        mech_service_item_price_list.msim_id, mech_service_item_price_list.estimated_cost', false);
    }
   
    public function default_where()
    {
        $this->db->where_in('mech_service_item_price_list.workshop_id', array(1,$this->session->userdata('work_shop_id')));
        if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $this->db->where_in('mech_service_item_price_list.w_branch_id', array(1,$this->session->userdata('branch_id')));
        }else if($this->session->userdata('user_type') == 6){
            $array = $this->session->userdata('user_branch_id');
            array_push($array,1);
            $this->db->where_in('mech_service_item_price_list.w_branch_id', $array);
		}
        $this->db->where('mech_service_item_price_list.status', 'A');
    }

    public function validation_rules()
    {
        return array(
            'msim_id'=> array(
                'field' => 'msim_id',
            ),
            'estimated_cost'=> array(
                'field' => 'estimated_cost',
            ),
            '_mm_csrf' => array(
                'field' => '_mm_csrf',
            ),
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
        if($id){
            $db_array['modified_by'] = $this->session->userdata('user_id');
        }else{
            $db_array['created_by'] = $this->session->userdata('user_id');
            $db_array['modified_by'] = $this->session->userdata('user_id');
            $db_array['workshop_id'] = $this->session->userdata('work_shop_id');
            $db_array['w_branch_id'] = $this->session->userdata('branch_id');
        }
        $id = parent::save($id, $db_array);
        return $id;
    }

}