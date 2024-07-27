<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Service_Package_Feature extends Response_Model
{

    public $table = 'mech_service_feature_dtls';
    public $primary_key = 'mech_service_feature_dtls.feature_id';
    public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_service_feature_dtls.feature_id');
    }

    public function default_where()
    {
        $this->db->where('mech_service_feature_dtls.status != "D"');
    }

    public function validation_rules()
    {
        return array(
            'entity_id' => array(
                'field' => 'entity_id',
                'rules' => 'required',
            ),
            'entity_type' => array(
                'field' => 'entity_type',
                'label' => trans('entity_type'),
                'rules' => 'required',
            ),
            'name' => array(
                'field' => 'name',
                'label' => trans('name'),
                'rules' => 'required',
            ),
        );
    }
    public function save($id = null, $db_array = null)
    {
       $db_array = ($db_array) ? $db_array : $this->db_array();
        $id = parent::save($id, $db_array);
        
        return $id;
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

    public function getEntityFeatureList($entity_id, $entity_type)
    {
        return $this->db->select('*')->from('mech_service_feature_dtls')->where('entity_id', $entity_id)->where('entity_type', $entity_type)->where('workshop_id', $this->session->userdata('work_shop_id'))->where('mech_service_feature_dtls.status != "D"')->get()->result();
    }

}