<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Service_packages extends Admin_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->model('service_packages/mdl_service_package');
        $this->load->model('service_packages/mdl_service_package_price_dtls');
        $this->load->model('mech_vehicle_type/mdl_mech_vehicle_type');
        $this->load->model('upload/mdl_uploads');
        $this->load->model('mechanic_service_category/mdl_mechanic_service_category_list');
        $this->load->model('service_packages/mdl_service_package_feature');
        $this->load->model('service_packages/mdl_mech_package_subscription_dtls');

    }

    public function index($page = 0)
    {
        $limit = 15;
        $query = $this->mdl_service_package->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();
        $this->mdl_service_package->limit($limit);
        $service_package = $this->mdl_service_package->get()->result();

		$this->layout->set(
            array(
                'service_package' => $service_package,
                'createLinks' => $createLinks,
                'service_category' => $this->mdl_mechanic_service_category_list->get()->result(),

            )
        );
        
        $this->layout->buffer('content', 'service_packages/index');
        $this->layout->render();
    }

    public function form($s_pack_id = null,$tab = null)
    {
        if ($s_pack_id){
            $package_details = $this->mdl_service_package->where('s_pack_id', $s_pack_id)->get()->row();
            $breadcrumb = "label949";
        }else{
            $package_details = array();
            $breadcrumb = "label948";
        } 

        $work_shop_id = $this->session->userdata('work_shop_id');
        $this->mdl_mech_vehicle_type->where('type_checked' , 1);
        $mech_vehicle_type = $this->mdl_mech_vehicle_type->get()->result();
        $service_package_price_details = $this->mdl_service_package_price_dtls->where('s_pack_id', $s_pack_id)->get()->result();
        $service_category_lists = $this->mdl_mechanic_service_category_list->where('status=1')->where_in('workshop_id',array(1,$work_shop_id))->get()->result();
        $service_feature_list = $this->mdl_service_package_feature->getEntityFeatureList($s_pack_id, 'sp');
        $service_ids = $this->mdl_service_package->get_existing_service_ids($s_pack_id);
        $service_list = $this->mdl_service_package->service_item_list($s_pack_id);

        $this->db->select('*');
        $this->db->from('mech_service_offer_dtls');
        $this->db->where('workshop_id',$this->session->userdata('work_shop_id')); 
		$this->db->where('entity_id',$s_pack_id);           
        $offer_details = $this->db->get()->row();

        $this->layout->set(
            array(
                'active_tab' => $tab,
                'breadcrumb' => $breadcrumb, 
                's_pack_id' => $s_pack_id,
                'service_category_lists' => $service_category_lists,
                'package_details' => $package_details,  
                'mech_vehicle_type' => $mech_vehicle_type,
                'is_mobileapp_enabled' => $this->session->userdata('is_mobileapp_enabled'),
                'service_package_price_details' => $service_package_price_details,
                'package_subscription_details' => $this->mdl_mech_package_subscription_dtls->where('s_pack_id', $s_pack_id)->get()->result(),
                'offer_details' => $offer_details,
                'service_feature_list' => $service_feature_list,
                'service_ids' => $service_ids,
                'service_list' => $service_list,
            )
        );
        $this->layout->buffer('content', 'service_packages/form');
        $this->layout->render();
    }

    public function delete()
    {
        $id = $this->input->post('id');
		$this->db->where('s_pack_id', $id);
		$this->db->update('mech_service_packages', array('status'=>'D'));
		$response = array(
            'success' => 1
        );
		echo json_encode($response);
    }

}