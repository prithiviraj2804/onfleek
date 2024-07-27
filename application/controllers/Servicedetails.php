<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Servicedetails
 */

require_once APPPATH . 'libraries/REST_Controller.php';

class Servicedetails extends REST_Controller{

	public function category_get($workshop_id){
		$data = array(
            'service_category_list' => $this->db->select('service_cat_id,category_name,service_icon_image')->get_where('mechanic_service_category_list', array('workshop_id' => $workshop_id, 'category_type' => 1, 'enable_mobile' => 'Y', 'status' => 1))->result(),
            // 'popular_package_list' => $this->db->select('s_pack_id,package_name,category_id,short_desc,description,features,icon_image,banner_image,important_note')->get_where('mech_service_packages', array('workshop_id' => $workshop_id, 'mobile_enable' => 'Y', 'status' => 'A', 'is_popular_service' => 'Y'))->result()
        );
        echo json_encode($data); 
	}

	public function packagelist_get($workshop_id){
        $data = array();
        $service_category_list =  $this->db->select('service_cat_id')->get_where('mechanic_service_category_list', array('workshop_id' => $workshop_id, 'category_type' => 1, 'enable_mobile' => 'Y', 'status' => 1))->result();
        foreach($service_category_list as $cat){
            $package_list = $this->db->select('s_pack_id,package_name,category_id,icon_image,banner_image')->get_where('mech_service_packages', array('workshop_id' => $workshop_id, 'mobile_enable' => 'Y', 'status' => 'A', 'category_id' => $cat->service_cat_id))->result_array();
            $j = 0;
            if(count($package_list) > 0){
                $package_array = array();
            foreach($package_list as $package){
                $package_array[$j] = $package;
                $package_array[$j]['price_dtls'] = $this->db->select('sp_price_id,s_pack_id,mvt_id,service_cost,estimated_hour')->get_where('mech_service_package_price_dtls', array('workshop_id' => $workshop_id, 'status' => 'A','s_pack_id' => $package['s_pack_id']))->result();
                $j++;
            }
            $data[$cat->service_cat_id] = $package_array;
        }
    }
    echo json_encode($data); 
    }

    public function packageview_get($workshop_id, $s_pack_id){
        $package_array = array();
        if($s_pack_id !== ''){
        $package_list = $this->db->select('s_pack_id,package_name,category_id,short_desc,description,features,icon_image,banner_image,important_note')->get_where('mech_service_packages', array('workshop_id' => $workshop_id, 'mobile_enable' => 'Y', 'status' => 'A', 's_pack_id' => $s_pack_id))->result_array();
        $j = 0;
        if(count($package_list) > 0){
            foreach($package_list as $package){
                $package_array[$j] = $package;
                $package_array[$j]['features'] = $this->db->select('feature_id,name')->get_where('mech_service_feature_dtls', array('workshop_id' => $workshop_id, 'entity_type' => 'sp', 'status' => 'A','entity_id' => $s_pack_id))->result();
                $package_array[$j]['price_dtls'] = $this->db->select('sp_price_id,s_pack_id,mvt_id,service_cost,estimated_hour')->get_where('mech_service_package_price_dtls', array('workshop_id' => $workshop_id, 'status' => 'A','s_pack_id' => $s_pack_id))->result();
                $j++;
            }
        }
        $api_status  = 1;
        $service_data = $package_array;
        $message = 'success';
    }else{
        $api_status  = 0;
        $service_data = $package_array;
        $message = 'service pack id missing';
    }
    $response = array(
        'api_status' => $api_status,
        'message' => $message,
        'service_data' => $service_data
    );
    echo json_encode($response); 
    }

    public function packageofferlist_get($workshop_id){
        $package_list = $this->db->select('s_pack_id,package_name,category_id,icon_image,banner_image')->get_where('mech_service_packages', array('workshop_id' => $workshop_id, 'mobile_enable' => 'Y', 'status' => 'A', 'is_offer_enable' => 'Y', 'is_offer_enable_mobile_banner' => 'Y'))->result_array();
        echo json_encode($package_list);
    }
    
    public function offers_post(){
        $json = file_get_contents('php://input');
        $obj = json_decode($json, TRUE);
        $workshop_id = $obj['workshop_id'];
        $current_date = $obj['current_date'];
        $page_type = $obj['page_type'];
        if($page_type == 'D'){
            $col_name = 'offer_id,offer_title,service_category_id,service_package_id,offer_banner_image,offer_type,offer_rate';
        }elseif($page_type == 'V'){
            $col_name = 'offer_id,offer_title,service_category_id,service_package_id,short_desc,long_desc,term_cond,offer_banner_image,offer_type,offer_rate';
        }
        $this->db->select($col_name);
        $this->db->where("'$current_date' BETWEEN `start_date` AND `end_date`");
        $this->db->where('workshop_id', $workshop_id);
        $this->db->where('status', 'A');
        $this->db->where('mobile_enable', 'Y');
        $offer_list = $this->db->get('mech_service_offer_dtls')->result();
		$data = array(
            'offer_list' => $offer_list
        );
        echo json_encode($data); 
	}
}