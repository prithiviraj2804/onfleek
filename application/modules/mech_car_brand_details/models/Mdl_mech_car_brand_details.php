<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Mdl_Mech_Car_Brand_Details
 */
class Mdl_Mech_Car_Brand_Details extends Response_Model
{
    public $table = 'mech_car_brand_details';
    public $primary_key = 'mech_car_brand_details.brand_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }
	public function default_join()
    {
    //    $this->db->join('mechanic_service_category_list uad', 'uad.service_cat_id = mechanic_service_category_items.service_category_id', 'left');
    }
    public function default_order_by()
    {
        $this->db->order_by('mech_car_brand_details.brand_id', "asc");
    }

    public function default_where()
    {
        $this->db->where('mech_car_brand_details.status', 1);
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'brand_name' => array(
                'field' => 'brand_name',
                'label' => trans('lable229'),
                'rules' => 'required|callback_checkBrandNameExist'
            ),
            'brand_image'=> array(
                'field' => 'brand_image',
                'label' => trans('lable448')
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
        return $db_array;
    }

	public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();

        $id = parent::save($id, $db_array);

        return $id;
    }
	public function checkBrandNameExist($brand_name)
	{
		if($this->input->post('is_update')== 0){
			$check = $this->db->select('brand_name')->from('mech_car_brand_details')->where('brand_name',$brand_name)->get()->result();
		}else if($this->input->post('is_update')== 1){
			$check = $this->db->select('brand_name')->from('mech_car_brand_details')->where('brand_name',$brand_name)->where_not_in('brand_id',$this->uri->segment(3))->get()->result();
		}
		if(count($check) > 0){
			$this->form_validation->set_message('checkBrandNameExist', 'Brand Name. already exist.');
			return false;
		}else{
			return true;
		}
	}
}
