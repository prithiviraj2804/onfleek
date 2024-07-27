<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mdl_Mech_Rewards extends Response_Model
{
    public $table = 'mech_rewards_dlts';
    public $primary_key = 'mech_rewards_dlts.mrdlts_id';
    public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mech_rewards_dlts.*, wbd.display_board_name', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_rewards_dlts.mrdlts_id');
    }

    public function default_join()
    {
        $this->db->join('workshop_branch_details wbd', 'wbd.w_branch_id=mech_rewards_dlts.branch_id', 'left');
    }

    public function default_where()
    {
        $this->db->where('mech_rewards_dlts.workshop_id' , $this->session->userdata('work_shop_id'));
        if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $this->db->where('mech_rewards_dlts.w_branch_id' , $this->session->userdata('branch_id'));
            $this->db->where('mech_rewards_dlts.created_by' , $this->session->userdata('user_id'));
        }else if($this->session->userdata('user_type') == 6){
            $this->db->where_in('mech_rewards_dlts.w_branch_id' , $this->session->userdata('user_branch_id'));
        }
        $this->db->where('mech_rewards_dlts.status' , "A");
    }

    public function get_latest()
    {
        $this->db->order_by('mech_rewards_dlts.mrdlts_id', 'DESC');

        return $this;
    }

    public function validation_rules()
    {
        return array(
            'branch_id' => array(
                'field' => 'branch_id',
                'label' => trans('lable51'),
                'rules' => 'required',
            ),
            'applied_for' => array(
                'field' => 'applied_for',
                'label' => trans('lable801'),
                'rules' => 'required',
            ),
            'inclusive_exclusive' => array(
                'field' => 'inclusive_exclusive',
                'label' => trans('lable807'),
                'rules' => 'required',
            ),
            'reward_type' => array(
                'field' => 'reward_type',
                'label' => trans('lable805'),
                'rules' => 'required',
            ),
            'reward_amount' => array(
                'field' => 'reward_amount',
                'label' => trans('lable806'),
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