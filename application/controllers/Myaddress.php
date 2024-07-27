<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Myaddress
 */

require_once APPPATH . 'libraries/REST_Controller.php';

class Myaddress extends REST_Controller{


	public function __construct()
    {
        parent::__construct();

        $this->load->model('user_address/mdl_user_address');
    }

	public function index_post($id = null){
		$json = file_get_contents('php://input');
        $obj = json_decode($json, TRUE);
        
        //print_r($obj['user_id']);
        $where = array('user_id' => $obj['user_id'], '`mech_user_address`.status' => 1);

		$user_address_list = $this->mdl_user_address->where($where)->get()->result();
		echo json_encode($user_address_list);

	}

	public function create_post($id = null){
		$json = file_get_contents('php://input');
		$obj = json_decode($json, TRUE);
		$data = array(
			'workshop_id' => $obj['workshop_id'],
			'user_id' => $obj['user_id'],
			'entity_type' => $obj['entity_type'],
			'customer_street_1' => $obj['customer_street_1'],
			'customer_street_2' => $obj['customer_street_2'],
			'area' => $obj['area'],
			'customer_city' => $obj['customer_city'],
			'customer_state' => $obj['customer_state'],
			'customer_country' => $obj['customer_country'],
			'zip_code' => $obj['zip_code'],
			'address_type' => $obj['address_type'],
			'created_by' => $obj['user_id'],
			'created_on' => date('Y-m-d H:i:s')
		);
        $res = $this->mdl_user_address->save_my_address($data);
        if($res['success']){
        	$where = array('user_id' => $obj['user_id'],'user_address_id'=>$res['id'], '`mech_user_address`.status' => 1);
        	$user_address_list = $this->mdl_user_address->where($where)->get()->row();
        }
        $res['success'] = 1;
        $res['user_address_list'] = $user_address_list;
        echo json_encode($res);
	}

	public function update_post($id = null){
		$json = file_get_contents('php://input');
		$obj = json_decode($json, TRUE);
		$data = array(
			'workshop_id' => $obj['workshop_id'],
			'user_id' => $obj['user_id'],
			'entity_type' => $obj['entity_type'],
			'customer_street_1' => $obj['customer_street_1'],
			'customer_street_2' => $obj['customer_street_2'],
			'area' => $obj['area'],
			'customer_city' => $obj['customer_city'],
			'customer_state' => $obj['customer_state'],
			'customer_country' => $obj['customer_country'],
			'zip_code' => $obj['zip_code'],
			'address_type' => $obj['address_type'],
			'modified_by' => $obj['user_id']
		);
        $res = $this->mdl_user_address->save_my_address($data,$id);
        if($res['success']){
        	$where = array('user_id' => $obj['user_id'],'user_address_id'=>$id, '`mech_user_address`.status' => 1);
        	$user_address_list = $this->mdl_user_address->where($where)->get()->row();
        }
        $res['success'] = 1;
        $res['user_address_list'] = $user_address_list;

        echo json_encode($res);
	}

	public function remove_post($id){
		$this->mdl_user_address->remove_my_address($id);
		$res = array('apistatus' => 1, 'message' => 'success');
		echo json_encode($res);
	}

	public function arealist_post(){
		$data = array(
            'area_list' => $this->db->select('area_id,area_name,area_pincode,is_service')->get_where('mech_area_list', array('status' => 1))->result(),
           );
        echo json_encode($data);
	}
	public function pincodelist_post(){
		$data = array(
            'pincode_list' => $this->db->select('pincoce_id,pincode,state_id')->get_where('mech_area_pincode', array('status' => 'A'))->result(),
           );
        echo json_encode($data);
	}

}