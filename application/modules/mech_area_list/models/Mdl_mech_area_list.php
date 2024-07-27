<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Mech_Area_List extends Response_Model
{
    public $table = 'mech_area_list';
    public $primary_key = 'mech_area_list.area_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }
	public function default_join()
    {
    }
    public function default_order_by()
    {
        $this->db->order_by('mech_area_list.area_id', "desc");
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'area_name' => array(
                'field' => 'area_name',
                'label' => trans('lable899'),
                'rules' => 'required|callback_checkAreaNameExist'
            ),
            'area_pincode' => array(
                'field' => 'area_pincode',
                'label' => trans('lable89'),
                'rules' => 'required'
            ),
            'is_service' => array(
                'field' => 'is_service',
                'label' => trans('lable900')
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
        $db_array['created_by'] = $this->session->userdata('user_id');
    	$db_array['modified_by'] = $this->session->userdata('user_id');
    	if($this->input->post('is_service')){
			$db_array['is_service'] = 1;
		}
        return $db_array;
    }

	public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();

        // Save the car
        $id = parent::save($id, $db_array);

        return $id;
    }
	public function checkAreaNameExist($area_name)
	{
		if($this->input->post('is_update')== 0){
			$check = $this->db->select('area_name')->from('mech_area_list')->where('area_name',$area_name)->get()->result();
		}else if($this->input->post('is_update')== 1){
			$check = $this->db->select('area_name')->from('mech_area_list')->where('area_name',$area_name)->where_not_in('area_id',$this->uri->segment(3))->get()->result();
		}
		if(count($check) > 0){
			$this->form_validation->set_message('checkAreaNameExist', 'Area Name. already exist.');
			return false;
		}else{
			return true;
		}
	}
}
