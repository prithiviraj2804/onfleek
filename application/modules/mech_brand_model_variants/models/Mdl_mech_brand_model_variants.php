<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Mdl_Mech_Brand_Model_Variants
 */
class Mdl_Mech_Brand_Model_Variants extends Response_Model
{
    public $table = 'mech_brand_model_variants';
    public $primary_key = 'mech_brand_model_variants.brand_model_variant_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }
	public function default_join()
    {
       $this->db->join('mech_car_brand_details uad', 'uad.brand_id = mech_brand_model_variants.brand_id', 'inner');
       $this->db->join('mech_car_brand_models_details cbm', 'cbm.brand_id = mech_brand_model_variants.model_id', 'inner');
    }
    public function default_order_by()
    {
        $this->db->order_by('mech_brand_model_variants.brand_model_variant_id', "desc");
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'brand_id' => array(
                'field' => 'brand_id',
                'label' => trans('lable229'),
                'rules' => 'required'
            ),
            'model_id' => array(
                'field' => 'model_id',
                'label' => trans('lable231'),
                'rules' => 'required'
            ),
            'variant_name' => array(
                'field' => 'variant_name',
                'label' => trans('lable232'),
                'rules' => 'required|callback_checkVariantNameExist'
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
	public function checkVariantNameExist($variant_name)
	{
		if($this->input->post('is_update')== 0){
			$check = $this->db->select('variant_name')->from('mech_brand_model_variants')->where('variant_name',$variant_name)->get()->result();
		}else if($this->input->post('is_update')== 1){
			$check = $this->db->select('variant_name')->from('mech_brand_model_variants')->where('variant_name',$variant_name)->where_not_in('brand_model_variant_id',$this->uri->segment(3))->get()->result();
		}
		if(count($check) > 0){
			$this->form_validation->set_message('checkVariantNameExist', 'Variant Name. already exist.');
			return false;
		}else{
			return true;
		}
	}
	public function getVariantName($variant_id)
	{
		if($variant_id){
			$variant_name = $this->db->select('variant_name')->from('mech_brand_model_variants')->where('brand_model_variant_id',$variant_id)->get()->row()->variant_name;
		}else{
			$variant_name = '';
		}
		return $variant_name;
	}
}
