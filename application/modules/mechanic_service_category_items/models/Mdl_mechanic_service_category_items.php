<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Mechanic_Service_Category_Items extends Response_Model
{
    public $table = 'mechanic_service_category_items';
    public $primary_key = 'mechanic_service_category_items.sc_item_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mechanic_service_category_items.sc_item_id,mechanic_service_category_items.workshop_id,
        mechanic_service_category_items.service_item_name,mechanic_service_category_items.service_category_id,
        mechanic_service_category_items.is_popular,mechanic_service_category_items.service_item_short_description,
        mechanic_service_category_items.service_item_description,mechanic_service_category_items.is_repair_diagnostics,
        mechanic_service_category_items.sci_status,uad.service_cat_id,uad.category_parent_id,uad.category_name,uad.category_url_key,uad.category_type,
        uad.service_short_description,uad.service_description,uad.service_image', false);
    }
	public function default_join()
    {
       $this->db->join('mechanic_service_category_list uad', 'uad.service_cat_id = mechanic_service_category_items.service_category_id', 'left');
    }
    public function default_where()
    {
        $this->db->where_in('mechanic_service_category_items.workshop_id', array(1,$this->session->userdata('work_shop_id')));
        $this->db->where('mechanic_service_category_items.sci_status', 1);
    }
    public function default_order_by()
    {
        $this->db->order_by('mechanic_service_category_items.sc_item_id', "DESC");
    }

    public function validation_rules()
    {
        return array(
            'service_item_name' => array(
                'field' => 'service_item_name',
                'label' => trans('Service Item Name'),
                'rules' => 'required'
            ),
            'service_category_id' => array(
                'field' => 'service_category_id',
                'label' => trans('service_category_id'),
            ),
            'is_popular' => array(
                'field' => 'is_popular',
                'label' => trans('is_popular'),
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
        $db_array['is_popular']=($this->input->post('is_popular'))?$this->input->post('is_popular'):0;
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
        
    public function getServiceCategoryNameById($sc_item_id){
        $this->db->select("service_item_name");	
		$this->db->from('mechanic_service_category_items');
		$this->db->where('sc_item_id', $sc_item_id);
        return $this->db->get()->row()->service_item_name;
    }
}
