<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Mdl_Mech_Car_Brand_Models_Details
 */
class Mdl_Mech_Car_Brand_Models_Details extends Response_Model
{
    public $table = 'mech_car_brand_models_details';
    public $primary_key = 'mech_car_brand_models_details.model_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }
	public function default_join()
    {
       $this->db->join('mech_car_brand_details uad', 'uad.brand_id = mech_car_brand_models_details.brand_id', 'left');
    }
    public function default_order_by()
    {
        $this->db->order_by('mech_car_brand_models_details.model_id', "asc");
    }

    public function default_where()
    {
        $this->db->where('mech_car_brand_models_details.status', 1);
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'model_name' => array(
                'field' => 'model_name',
                'label' => trans('lable231'),
                'rules' => 'required|callback_checkModelNameExist'
            ),
            'brand_id' => array(
                'field' => 'brand_id',
                'label' => trans('lable229'),
                'rules' => 'required'
            ),
            'model_image' => array(
                'field' => 'model_image',
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

        // Save the car
        $id = parent::save($id, $db_array);

        return $id;
    }
	public function checkModelNameExist($model_name)
	{
		if($this->input->post('is_update')== 0){
			$check = $this->db->select('model_name')->from('mech_car_brand_models_details')->where('model_name',$model_name)->get()->result();
		}else if($this->input->post('is_update')== 1){
			$check = $this->db->select('model_name')->from('mech_car_brand_models_details')->where('model_name',$model_name)->where_not_in('model_id',$this->uri->segment(3))->get()->result();
		}
		if(count($check) > 0){
			$this->form_validation->set_message('checkModelNameExist', 'Model Name. already exist.');
			return false;
		}else{
			return true;
		}
	}
}
