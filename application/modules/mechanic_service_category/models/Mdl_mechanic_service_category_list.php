<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Mechanic_Service_Category_List extends Response_Model
{
    public $table = 'mechanic_service_category_list';
    public $primary_key = 'mechanic_service_category_list.service_cat_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mechanic_service_category_list.service_cat_id,mechanic_service_category_list.workshop_id,
        mechanic_service_category_list.category_parent_id,mechanic_service_category_list.category_name,
        mechanic_service_category_list.category_type,mechanic_service_category_list.service_description,
        mechanic_service_category_list.service_short_description,mechanic_service_category_list.enable_mobile,
        mechanic_service_category_list.service_icon_image,mechanic_service_category_list.service_image',false);
    }
	
    public function default_order_by()
    {
        $this->db->order_by('mechanic_service_category_list.service_cat_id', "DESC");
    }
    
	public function default_where()
    {
        $this->db->where_in('mechanic_service_category_list.workshop_id', array(1,$this->session->userdata('work_shop_id')));
        $this->db->where('mechanic_service_category_list.status', 1);
    }

    public function validation_rules()
    {
        return array(
            'category_name' => array(
                'field' => 'category_name',
                'label' => trans('lable244'),
                'rules' => 'required'
            ),
            'service_short_description' => array(
                'field' => 'service_short_description',
                'label' => trans('lable248'),
                'rules' => ''
            ),
            'service_description' => array(
                'field' => 'service_description',
                'label' => trans('lable177'),
                'rules' => ''
            ),
            'service_icon_image' => array(
                'field' => 'service_icon_image',
                'label' => trans('label950'),
                'rules' => ''
            ),
            'service_image' => array(
                'field' => 'service_image',
                'label' => trans('label951'),
                'rules' => ''
            ),
            'enable_mobile' => array(
                'field' => 'enable_mobile',
                'label' => trans('label946'),
                // 'rules' => 'required'
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
        $db_array['service_short_description'] = strip_tags($db_array['service_short_description']);
        $db_array['service_description'] = strip_tags($db_array['service_description']);
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

    public function get_url_key()
    {
        $this->load->helper('string');
        return random_string('alnum', 15);
    }
	
	public function checkCategoryNameExist($category_name = NULL)
	{
		if($this->input->post('is_update')== 0){
			$check = $this->db->select('category_name')->from('mechanic_service_category_list')->where('category_name',$category_name)->where_in('workshop_id',array(1,$this->session->userdata('work_shop_id')))->where_in('w_branch_id',array(1,$this->session->userdata('branch_id')))->where('status !=','2')->get()->result();
		}else if($this->input->post('is_update')== 1){
			$check = $this->db->select('category_name')->from('mechanic_service_category_list')->where('category_name',$category_name)->where('status !=','2')->where_in('workshop_id',array(1,$this->session->userdata('work_shop_id')))->where_in('w_branch_id',array(1,$this->session->userdata('branch_id')))->where_not_in('service_cat_id', $this->input->post('service_cat_id'))->get()->result();
		}
		if(count($check) > 0){
			$this->form_validation->set_message('checkCategoryNameExist', 'Category Name. already exist.');
			return false;
		}else{
			return true;
		}
	}
	
}
