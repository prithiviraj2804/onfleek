<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mechanic_Service_Item_Price_List extends Admin_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_mech_service_item_dtls');
        $this->load->model('mdl_mechanic_service_item_price_list');
        $this->load->model('mdl_service_bmv_type_price_dtls');
        $this->load->model('mdl_service_body_type_price_dtls');
        $this->load->model('mechanic_service_category_items/mdl_mechanic_service_category_items');
        $this->load->model('mechanic_service_category/mdl_mechanic_service_category_list');
        $this->load->model('mech_vehicle_type/mdl_mech_vehicle_type');
    }

    public function index($page = 0)
    {

        $limit = 15;
        $query = $this->mdl_mech_service_item_dtls->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();
        $this->mdl_mech_service_item_dtls->limit($limit);
        $mech_service_item_dtls = $this->mdl_mech_service_item_dtls->get()->result();
        if(count($mech_service_item_dtls) > 0){
            foreach($mech_service_item_dtls as $key => $serviceList){
                if($serviceList->service_cost_setup == 2 && $this->session->userdata('service_cost_setup') == 2){
                    $sbmv = $this->mdl_service_bmv_type_price_dtls->where('service_bmv_type_price_dtls.msim_id' , $serviceList->msim_id )->get()->result();
                    if(count($sbmv) > 0){
                        $mech_service_item_dtls[$key]->sbmv = $sbmv;
                    }else{
                        $mech_service_item_dtls[$key]->sbmv = array();
                    }
                }else{
                    $mech_service_item_dtls[$key]->sbmv = array();
                }
            }
        } 

        $this->layout->set(
            array(
                'mech_service_item_dtls' => $mech_service_item_dtls,
                'service_category_lists' => $this->mdl_mechanic_service_category_list->get()->result(),
                'createLinks' => $createLinks
            )
        );
        $this->layout->buffer('content', 'mechanic_service_item_price_list/index');
        $this->layout->render();

    }

    public function form($id = null)
    {
		if($id){
            if (!$this->mdl_mech_service_item_dtls->prep_form($id)) {
                show_404();
            }
			$this->mdl_mech_service_item_dtls->set_form_value('is_update', true);
            if($this->session->userdata('service_cost_setup') == 1){
                $this->mdl_service_body_type_price_dtls->where('msim_id' , $id);
                $service_body_type_details = $this->mdl_service_body_type_price_dtls->get()->result();
                if(count($service_body_type_details) <= 0){
                    $service_body_type_details = array();
                }
            }else if($this->session->userdata('service_cost_setup') == 2){
                $this->mdl_service_bmv_type_price_dtls->where('msim_id' , $id);
                $service_bmv_type_details = $this->mdl_service_bmv_type_price_dtls->get()->result();
                if(count($service_bmv_type_details) <= 0){
                    $service_bmv_type_details = array();
                }
            }
        }else{
            $service_body_type_details = array();
            $service_bmv_type_details = array();
        }
        
        $this->mdl_mech_vehicle_type->where('type_checked',1);
        $mechVehicleType = $this->mdl_mech_vehicle_type->get()->result();
        $this->layout->set(array(
            'car_brand_list' => $this->db->get_where('mech_car_brand_details', array('status' => 1))->result(),
            'car_model_list' => $this->db->get_where('mech_car_brand_models_details', array('status' => 1))->result(),
            'car_variant_list' => $this->db->get_where('mech_brand_model_variants', array('status' => 1))->result(),
            'service_category_lists' => $this->mdl_mechanic_service_category_list->get()->result(),
            'service_body_type_details' => $service_body_type_details,
            'service_bmv_type_details' => $service_bmv_type_details,
            'mechVehicleType' => $mechVehicleType
        ));
        $this->layout->buffer('content', 'mechanic_service_item_price_list/form');
        $this->layout->render();

    }

    public function delete()
    {

    	$id = $this->input->post('id');
		$this->db->where('msim_id', $id);
		$this->db->update('mech_service_item_dtls', array('status'=>'D'));
		$response = array(
            'success' => 1
        );
        echo json_encode($response);
        
    }

    public function deleteServiceBmv(){
        $id = $this->input->post('id');
		$this->db->where('pct_id', $id);
		$this->db->update('service_bmv_type_price_dtls', array('status'=>'D'));
		$response = array(
            'success' => 1
        );
        echo json_encode($response);
    }
}