<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Usercars
 */

require_once APPPATH . 'libraries/REST_Controller.php';

class Usercars extends REST_Controller{

	public function basic_post($id = null){
		$json = file_get_contents('php://input');
		$obj = json_decode($json, TRUE);
		$workshop_id = $obj['workshop_id'];
        	$data = array(
            'car_brand_list' => $this->db->get_where('mech_car_brand_details', array('status' => 1))->result(),
            'car_model_list' => $this->db->get_where('mech_car_brand_models_details', array('status' => 1))->result(),
			'car_variant_list' => $this->db->get_where('mech_brand_model_variants', array('status' => 1))->result(),
			'vehicle_body_type' => $this->db->select('mvt_id,vehicle_type_name,vehicle_type_value')->get_where('mech_vehicle_type', array('status' => 'A','workshop_id' => $workshop_id))->result()
        );
        echo json_encode($data); 
	}

	public function create_post(){
		$this->load->model('user_cars/mdl_user_cars');
		$json = file_get_contents('php://input');
        $obj = json_decode($json, TRUE);
		$data = array(
			'workshop_id' => $obj['workshop_id'],
			'car_reg_no' => $obj['car_reg_no'],
			'car_model_year' => $obj['car_model_year'],
			'car_brand_id' => $obj['car_brand_id'],
			'car_brand_model_id' => $obj['car_brand_model_id'],
			'car_variant' => $obj['car_variant'],
			'fuel_type' => $obj['fuel_type'],
			'transmission_type' => $obj['transmission_type'],
			'model_type' => $obj['model_type'],
			'owner_id' => $obj['owner_id'],
			'entity_type' => $obj['entity_type'],
			'created_by' => $obj['owner_id'],
			'created_on' => date('Y-m-d H:i:s')
		);
        $res = $this->mdl_user_cars->saveApiData($data);
        echo json_encode($res);
	}

	public function update_post($id){
		$this->load->model('user_cars/mdl_user_cars');
		$json = file_get_contents('php://input');
        $obj = json_decode($json, TRUE);
        $data = array(
			'workshop_id' => $obj['workshop_id'],
			'car_reg_no' => $obj['car_reg_no'],
			'car_model_year' => $obj['car_model_year'],
			'car_brand_id' => $obj['car_brand_id'],
			'car_brand_model_id' => $obj['car_brand_model_id'],
			'car_variant' => $obj['car_variant'],
			'fuel_type' => $obj['fuel_type'],
			'transmission_type' => $obj['transmission_type'],
			'model_type' => $obj['model_type'],
			'owner_id' => $obj['owner_id'],
			'entity_type' => $obj['entity_type'],
			'modified_by' => $obj['owner_id']
		);
        $res = $this->mdl_user_cars->saveApiData($data, $id);
        echo json_encode($res);
	}

	public function index_post($owner_id = null){
		$this->load->model('user_cars/mdl_user_cars');	
		$json = file_get_contents('php://input');
		$obj = json_decode($json, TRUE);
        if($obj['car_list_id']){
			$cars = $this->mdl_user_cars->getApiData($owner_id, $obj['car_list_id']);
        } else{
        	$cars = $this->mdl_user_cars->getApiData($owner_id);
        }
        echo json_encode($cars);
	}

	public function remove_post($id){
		$this->load->model('user_cars/mdl_user_cars');
		$this->mdl_user_cars->removeApiData($id);

		$res = array('api' => 1, 'message' => 'success');

		echo json_encode($res);
	}
}