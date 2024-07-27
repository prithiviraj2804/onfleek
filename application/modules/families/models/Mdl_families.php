<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Families extends Response_Model
{
    public $table = 'ip_families';
    public $primary_key = 'ip_families.family_id';
    public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS ip_families.family_id, ip_families.workshop_id, ip_families.w_branch_id, ip_families.family_name,ip_families.parent_id', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_families.family_id DESC');
    }

    public function default_where()
    {
        $this->db->where_in('ip_families.workshop_id', array('1',$this->session->userdata('work_shop_id')));
        if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $this->db->where_in('ip_families.w_branch_id', array('1',$this->session->userdata('branch_id')));
            $this->db->where_in('ip_families.created_by', array('1',$this->session->userdata('user_id')));
		}else if($this->session->userdata('user_type') == 6){
            $array = $this->session->userdata('user_branch_id');
            array_push($array,1);
            $this->db->where_in('ip_families.w_branch_id', $array);
		}
		$this->db->where('ip_families.status', 'A');
    }

    public function validation_rules()
    {
        return array(
            'family_name' => array(
                'field' => 'family_name',
                'label' => trans('lable50'),
                'rules' => 'required'
            ),
            'parent_category_id' => array(
                'field' => 'parent_category_id',
                'label' => trans('lable1023'),
                'rules' => ''
            ),
            '_mm_csrf' => array(
                'field' => '_mm_csrf'
            )
        );
    }

    public function db_array()
    {
        $db_array = parent::db_array();
        return $db_array;
    }

	public function save($id = null, $db_array = null, $parent_id = null)
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
        if($parent_id != '')
        {
            $this->db->set('parent_id',$parent_id);
            $this->db->where('family_id',$id);
            $this->db->update('ip_families');
        }
        return $id;
    }

}