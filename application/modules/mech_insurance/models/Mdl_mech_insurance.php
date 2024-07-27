<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Mdl_mech_insurance_details
 */
class Mdl_Mech_Insurance extends Response_Model
{
    public $table = 'mech_insurance_details';
    public $primary_key = 'mech_insurance_details.insurance_id';
	public $date_created_field = 'created_date';
    public $date_modified_field = 'modified_date';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }
		
    public function default_order_by()
    {
        $this->db->order_by('mech_insurance_details.insurance_id', "desc");
    }
	
	public function user_validation_rules()
    {
        return array(
            'car_id' => array(
                'field' => 'user_car_list_id',
                'rules' => 'required'
            ),
            'existing_idv_value' => array(
                'field' => 'existing_idv_value',
                'label' => trans('is_experied')
            ),
            'is_already_expired' => array(
                'field' => 'is_already_expired',
                'label' => trans('is_already_expired')
            ),
            'existing_expired_date' => array(
                'field' => 'existing_expired_date',
                'label' => trans('existing_expired_date')
            ),
            'rc_book_url' => array(
                'field' => 'rc_book_url',
                'label' => trans('rc_book_url'),
                //'rules' => 'required'
            ),
            'insurance_url' => array(
                'field' => 'insurance_url',
                'label' => trans('insurance_url'),
               // 'rules' => 'required'
            ),
            '_mm_csrf' => array(
                'field' => '_mm_csrf'
            )
        );
    }
	public function admin_validation_rules()
    {
        return array(
            'car_id' => array(
                'field' => 'user_car_list_id',
                'rules' => 'required'
            ),
            'is_already_expired' => array(
                'field' => 'is_experied',
                'label' => trans('is_experied'),
                'rules' => 'required'
            ),
            'rc_book_image' => array(
                'field' => 'rc_book_image',
                'label' => trans('rc_book_image'),
               // 'rules' => 'required'
            ),
            'insurance_url' => array(
                'field' => 'insurance_url',
                'label' => trans('insurance_url'),
               // 'rules' => 'required'
            ),
            'existing_idv_value' => array(
                'field' => 'existing_idv_value',
                'label' => trans('existing_idv_value'),
            ),
            'existing_expired_date' => array(
                'field' => 'existing_expired_date',
                'label' => trans('existing_expired_date'),
            ),
            'is_renewal' => array(
                'field' => 'is_renewal',
                'label' => trans('is_renewal')
            ),
            'existing_Insurance_id' => array(
                'field' => 'existing_Insurance_id',
                'label' => trans('existing_Insurance_id')
            ),
            'insurance_start_date' => array(
                'field' => 'insurance_start_date',
                'label' => trans('insurance_start_date'),
               // 'rules' => 'required'
            ),
			'insurance_end_date' => array(
                'field' => 'insurance_end_date',
                'label' => trans('insurance_end_date'),
                //'rules' => 'required'
            ),
			'current_idv_value' => array(
                'field' => 'current_idv_value',
                'label' => trans('current_idv_value'),
                'rules' => 'required'
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
		
		$user_type = $this->session->userdata('user_type');
		if($user_type == 1){
			$entire_by = 'A';
		}else if($user_type == 2){
			$entire_by = 'U';
		}
		if($db_array['existing_expired_date']){
				$existing_expired_date = str_replace('/', '-', $db_array['existing_expired_date']);
                $existing_expired_date = strtotime($existing_expired_date);
                $db_array['existing_expired_date'] = date("Y-m-d H:i:s", $existing_expired_date);
		}
		if($db_array['insurance_start_date']){
			$existing_expired_date = str_replace('/', '-', $db_array['insurance_start_date']);
                $existing_expired_date = strtotime($existing_expired_date);
                $db_array['insurance_start_date'] = date("Y-m-d H:i:s", $existing_expired_date);
		}
		if($db_array['insurance_end_date']){
			$insurance_end_date = str_replace('/', '-', $db_array['insurance_end_date']);
                $insurance_end_date = strtotime($insurance_end_date);
                $db_array['insurance_end_date'] = date("Y-m-d H:i:s", $insurance_end_date);
		}
		
		$db_array['entire_by']=$entire_by;
		$db_array['user_id'] = $this->session->userdata('user_id');
		$db_array['created_by'] = $this->session->userdata('user_id');
		$db_array['modified_by'] = $this->session->userdata('user_id');
        $id = parent::save($id, $db_array);
        return $id;
    }
	
}
