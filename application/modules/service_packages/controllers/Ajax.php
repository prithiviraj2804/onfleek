<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('service_packages/mdl_service_package');
        $this->load->model('service_packages/mdl_service_package_feature');
        $this->load->model('service_packages/mdl_service_package_price_dtls');
        $this->load->model('service_packages/mdl_mech_package_subscription_dtls');
        $this->load->model('mech_item_master/mdl_mech_service_master');
        $this->load->model('mechanic_service_category/mdl_mechanic_service_category_list');
    }

    public function basic_create()
    {
        $s_pack_id = $this->input->post('s_pack_id');
        $btn_submit_basic = $this->input->post('btn_submit_basic');
        $btn_submit_feature = $this->input->post('btn_submit_feature');
        $btn_submit_image = $this->input->post('btn_submit_image');

        if ($this->mdl_service_package->run_validation('validation_rules_service_package')) {
            $s_pack_id = $this->mdl_service_package->save($s_pack_id);	

            $response = array(
                'success' => 1,
                's_pack_id'=>$s_pack_id,
                'btn_submit_basic' => $btn_submit_basic,
                'btn_submit_feature' => $btn_submit_feature
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
        }

        echo json_encode($response);
    }

    public function basic_service_create()
    {
        $s_pack_id = $this->input->post('s_pack_id');
        $existing_service = json_decode($this->input->post('existing_service_ids'));

        $service_ids = array();

        if(count($existing_service) > 0){
            foreach($existing_service as $ser){
                array_push($service_ids , $ser->item_msim_id);
            }
         }

         $existing_service_ids = implode(',', $service_ids);

         if ($s_pack_id) {
            $data = array(
                'service_item_id' => $existing_service_ids,
            );

            if($s_pack_id){    
                $this->db->where('s_pack_id',$s_pack_id);
                $this->db->update('mech_service_packages',$data);
            }
            $response = array(
                'success' => 1,
                's_pack_id' => $s_pack_id,
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
        }
        echo json_encode($response);
    }
    

    public function basic_create_feature()
    {
        $s_pack_id = $this->input->post('s_pack_id');
        $btn_submit_feature = $this->input->post('btn_submit_feature');

        if ($this->mdl_service_package->run_validation('validation_rules_service_feature')) {
            $s_pack_id = $this->mdl_service_package->save($s_pack_id);	

            $featureArray = json_decode($this->input->post('featureArray'));
            if(count($featureArray) > 0){
                $insert_array = array();
                $update_array = array();
                foreach($featureArray as $feature){
                    if($feature->feature_id){
                        $update_array[] = array(
                            'feature_id' => $feature->feature_id,
                            'entity_id' => $s_pack_id,
                            'entity_type' => 'sp',
                            'name' => $feature->column_name,
                            'created_by' => $this->session->userdata('user_id'),
                            'modified_by' => $this->session->userdata('user_id')
                        );
                    }else{
                        $insert_array[] = array(
                            'entity_id' => $s_pack_id,
                            'entity_type' => 'sp',
                            'name' => $feature->column_name,
                            'workshop_id' => $this->session->userdata('work_shop_id'),
                            'created_on' => date('Y-m-d H:m:s'),
                            'created_by' => $this->session->userdata('user_id'),
                            'modified_by' => $this->session->userdata('user_id')
                        );
                    }
                }
                if(count($insert_array) > 0){
                    $this->db->insert_batch('mech_service_feature_dtls', $insert_array);    
                }
                if(count($update_array) > 0){
                    $this->db->update_batch('mech_service_feature_dtls', $update_array,'feature_id');    
                }
            }

            $response = array(
                'success' => 1,
                's_pack_id'=>$s_pack_id,
                'btn_submit_feature' => $btn_submit_feature
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
        }

        echo json_encode($response);
    }

    public function service_package_create_price(){
        $serviceCostPriceList = json_decode($this->input->post('serviceCostPriceList'));
        if($this->input->post('s_pack_id')){
            if(count($serviceCostPriceList) > 0){
                foreach($serviceCostPriceList as $serviceDtls){
                    $serPrice = array(
                        'workshop_id' => $this->session->userdata('work_shop_id'),
                        's_pack_id' => $this->input->post('s_pack_id'),
                        'mvt_id' => $serviceDtls->mvt_id,
                        'service_cost' => $serviceDtls->service_cost,
                        'estimated_hour' => $serviceDtls->estimated_hour,
                    );
                    // echo "sp_price_id===".$serviceDtls->sp_price_id;
                    if($serviceDtls->sp_price_id){
                        $serPrice['modified_by'] = $this->session->userdata('user_id');
                        $s_pack_id = $this->mdl_service_package_price_dtls->save($serviceDtls->sp_price_id,$serPrice);	
                    }else{
                        $s_pack_id = $this->mdl_service_package_price_dtls->save($serviceDtls->sp_price_id = NULL,$serPrice);	
                    }
                }
            }
            $response = array(
                'success' => 1,
                's_pack_id' => $this->input->post('s_pack_id')
            );
        }else{
            $response = array(
                'success' => 0,
                's_pack_id' => $this->input->post('s_pack_id')
            );
        }

        echo json_encode($response);
    }

    public function mech_package_subscription_create(){
        $packagesubscriptionList = json_decode($this->input->post('packagesubscriptionList'));
        $subscription_account_checkbox = htmlspecialchars($this->input->post('subscription_account_checkbox'));

        if($this->input->post('s_pack_id')){
            if(count($packagesubscriptionList) > 0){
                foreach($packagesubscriptionList as $subscriptionDtls){

                    if($subscriptionDtls->alternative == 'A'){
                        $subPrice = array(
                            'workshop_id' => $this->session->userdata('work_shop_id'),
                            's_pack_id' => $this->input->post('s_pack_id'),
                            'body_type' => $subscriptionDtls->body_type,
                            'price' => $subscriptionDtls->alternative_price,
                            'schedule_type' => 'A',
                        );
                        if($subscriptionDtls->alternative_aid){
                            $subPrice['modified_by'] = $this->session->userdata('user_id');
                            $s_pack_id = $this->mdl_mech_package_subscription_dtls->save($subscriptionDtls->alternative_aid,$subPrice);	
                        }else{
                            $s_pack_id = $this->mdl_mech_package_subscription_dtls->save($subscriptionDtls->alternative_aid = NULL,$subPrice);	
                        }
                    }

                    if($subscriptionDtls->daily == 'D'){
                        $subPrice = array(
                            'workshop_id' => $this->session->userdata('work_shop_id'),
                            's_pack_id' => $this->input->post('s_pack_id'),
                            'body_type' => $subscriptionDtls->body_type,
                            'price' => $subscriptionDtls->daily_price,
                            'schedule_type' => 'D',
                        );
                        if($subscriptionDtls->daily_aid){
                            $subPrice['modified_by'] = $this->session->userdata('user_id');
                            $s_pack_id = $this->mdl_mech_package_subscription_dtls->save($subscriptionDtls->daily_aid,$subPrice);	
                        }else{
                            $s_pack_id = $this->mdl_mech_package_subscription_dtls->save($subscriptionDtls->daily_aid = NULL,$subPrice);	
                        }
                    }

                    if($subscriptionDtls->monthly == 'M'){
                        $subPrice = array(
                            'workshop_id' => $this->session->userdata('work_shop_id'),
                            's_pack_id' => $this->input->post('s_pack_id'),
                            'body_type' => $subscriptionDtls->body_type,
                            'price' => $subscriptionDtls->monthly_price,
                            'schedule_type' => 'M',
                        );
                        if($subscriptionDtls->monthly_aid){
                            $subPrice['modified_by'] = $this->session->userdata('user_id');
                            $s_pack_id = $this->mdl_mech_package_subscription_dtls->save($subscriptionDtls->monthly_aid,$subPrice);	
                        }else{
                            $s_pack_id = $this->mdl_mech_package_subscription_dtls->save($subscriptionDtls->monthly_aid = NULL,$subPrice);	
                        }
                    }

                    if($subscriptionDtls->weekly == 'W'){
                        $subPrice = array(
                            'workshop_id' => $this->session->userdata('work_shop_id'),
                            's_pack_id' => $this->input->post('s_pack_id'),
                            'body_type' => $subscriptionDtls->body_type,
                            'price' => $subscriptionDtls->weekly_price,
                            'schedule_type' => 'W',
                        );
                        if($subscriptionDtls->weekly_aid){
                            $subPrice['modified_by'] = $this->session->userdata('user_id');
                            $s_pack_id = $this->mdl_mech_package_subscription_dtls->save($subscriptionDtls->weekly_aid,$subPrice);	
                        }else{
                            $s_pack_id = $this->mdl_mech_package_subscription_dtls->save($subscriptionDtls->weekly_aid = NULL,$subPrice);	
                        }
                    }
                } 

                $data = array(
                    'subscription_account_checkbox' => $subscription_account_checkbox,
                );
                $this->db->where('s_pack_id',$this->input->post('s_pack_id'));
                $this->db->update('mech_service_packages',$data);   
            }
            $response = array(
                'success' => 1,
                's_pack_id' => $this->input->post('s_pack_id')
            );
        }else{
            $response = array(
                'success' => 0,
                's_pack_id' => $this->input->post('s_pack_id')
            );
        }

        echo json_encode($response);
    }

    public function get_package_details(){

        $package_details = $this->mdl_service_package->getServicepackagedetails();

        if(!empty($package_details)){
            $response = array(
                'success' => 1,
                'data' => $package_details
            );
        }else{
            $response = array(
                'success' => 0,
                'data' => ''
            );
        }

        echo json_encode($response);
    }

    public function offer_create()
    {
        $s_pack_id = $this->input->post('s_pack_id');
        $start_date = $this->input->post('start_date')?date_to_mysql($this->input->post('start_date')):date('d/m/Y');
        $end_date = $this->input->post('end_date')?date_to_mysql($this->input->post('end_date')):date('d/m/Y');
        $offer_type = $this->input->post('offer_type');
        $offer_rate = $this->input->post('offer_rate');
        $offer_id = $this->input->post('offer_id');
        $btn_submit_offer = $this->input->post('btn_submit_offer');

        if ($s_pack_id) {
            
            $data = array(
                'offer_id' => $offer_id,
                'entity_id' => $s_pack_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'offer_type' => $offer_type,
                'offer_rate' => $offer_rate,
                'workshop_id' => $this->session->userdata('work_shop_id'),
                'modified_by' => $this->session->userdata('user_id'),
                );
    
                if($offer_id && $s_pack_id){    
                    $this->db->where('offer_id',$offer_id);
                    $this->db->update('mech_service_offer_dtls',$data);
                }else{
                    $data['created_on'] = date('Y-m-d H:m:s');
                    $data['created_by'] = $this->session->userdata('user_id');
                    $this->db->insert('mech_service_offer_dtls',$data);
                }

            $response = array(
                'success' => 1,
                's_pack_id'=>$s_pack_id,
                'btn_submit_offer' => $btn_submit_offer
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
        }

        echo json_encode($response);
    }

    public function deletefeatureData(){
        
        $feature_id = $this->input->post('feature_id');
        $this->db->set('status','D');
        $this->db->where('feature_id',$feature_id);
        $this->db->update('mech_service_feature_dtls');

        $response = array(
            'success' => 1
        );

        echo json_encode($response);
    }

    public function get_service_package_filter_list(){

        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;

        if($this->input->post('package_name')){
            $this->mdl_service_package->like('package_name', trim($this->input->post('package_name')));
        }

        if($this->input->post('category_id')){
            $this->mdl_service_package->like('category_id', trim($this->input->post('category_id')));
        }

        $rowCount = $this->mdl_service_package->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        if($this->input->post('package_name')){
            $this->mdl_service_package->like('package_name', trim($this->input->post('package_name')));
        }
        
        if($this->input->post('category_id')){
            $this->mdl_service_package->like('category_id', trim($this->input->post('category_id')));
        }
        
        $this->mdl_service_package->limit($limit,$start);
        $mech_service_package = $this->mdl_service_package->get()->result();
        $response = array(
            'success' => 1,
            'mech_service_package' => $mech_service_package, 
            'createLinks' => $createLinks,
        );
        echo json_encode($response);
    }

    public function delete_item(){
        $item_id = $this->input->post('item_id');
        $this->db->where('item_id', $item_id);
        $this->db->delete('mech_service_item_dtls');
        $response = array(
            'success' => 1
        );
        echo json_encode($response);
    }
}