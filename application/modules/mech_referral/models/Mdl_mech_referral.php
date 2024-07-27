<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mdl_Mech_Referral extends Response_Model
{
    public $table = 'mech_referral_dlts';
    public $primary_key = 'mech_referral_dlts.mrefh_id';
    public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mech_referral_dlts.*, wbd.display_board_name', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_referral_dlts.mrefh_id');
    }

    public function default_join()
    {
        $this->db->join('workshop_branch_details wbd', 'wbd.w_branch_id=mech_referral_dlts.branch_id', 'left');
    }

    public function default_where()
    {
        $this->db->where('mech_referral_dlts.workshop_id' , $this->session->userdata('work_shop_id'));
        if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $this->db->where('mech_referral_dlts.w_branch_id' , $this->session->userdata('branch_id'));
            $this->db->where('mech_referral_dlts.created_by' , $this->session->userdata('user_id'));
        }else if($this->session->userdata('user_type') == 6){
            $this->db->where_in('mech_referral_dlts.w_branch_id' , $this->session->userdata('user_branch_id'));
        }
        $this->db->where('mech_referral_dlts.status' , "A");
    }

    public function get_latest()
    {
        $this->db->order_by('mech_referral_dlts.mrefh_id', 'DESC');

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
            'cusreffCheckBox' => array(
                'field' => 'bill_no',
                // 'label' => trans('bill_no'),
            ),
            'empreffCheckBox' => array(
                'field' => 'empreffCheckBox',
                'label' => trans('lable818'),
            ),
            'cus_ref_type' => array(
                'field' => 'cus_ref_type',
                'label' => trans('lable797'),
            ),
            'emp_ref_type' => array(
                'field' => 'emp_ref_type',
                'label' => trans('lable797'),
            ),
            'cus_ref_pt' => array(
                'field' => 'cus_ref_pt',
                'label' => trans('lable175'),
            ),
            'emp_ref_pt' => array(
                'field' => 'emp_ref_pt',
                'label' => trans('lable175'),
            ),
            'cus_red_pt' => array(
                'field' => 'cus_red_pt',
                'label' => trans('lable176'),
            ),
            'emp_red_pt' => array(
                'field' => 'emp_red_pt',
                'label' => trans('lable176'),
            ),
            'cus_referral_amount' => array(
                'field' => 'cus_referral_amount',
                // 'label' => trans('cus_referral_amount'),
            ),
            'emp_referral_amount' => array(
                'field' => 'emp_referral_amount',
                // 'label' => trans('emp_referral_amount'),
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