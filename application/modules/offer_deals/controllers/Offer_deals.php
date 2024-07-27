<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Offer_deals extends Admin_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_offer_deals');
        $this->load->model('mechanic_service_category/mdl_mechanic_service_category_list');
        $this->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls');
        $this->load->model('service_packages/mdl_service_package');
        $this->load->model('offer_deals/mdl_offer_deals_feature');

       
    }

    public function index($page = 0)
    {
        $limit = 15;
        $query = $this->mdl_offer_deals->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();
        $this->mdl_offer_deals->limit($limit);
        $offer_deals = $this->mdl_offer_deals->get()->result();

		$this->layout->set(
            array(
                'offer_deals' => $offer_deals,
                'service_category' => $this->mdl_mechanic_service_category_list->get()->result(),
                'createLinks' => $createLinks,
            )
        );

        $this->layout->buffer('content', 'offer_deals/index');
        $this->layout->render();
    }
    
    public function form($offer_id = NULL , $tab = NULL)
    {    
        if ($offer_id){
            $offer_details = $this->mdl_offer_deals->where('offer_id', $offer_id)->get()->row();
            $breadcrumb = "label974";
        }else{
            $offer_details = array();
            $breadcrumb = "label973";
        } 
        $offer_feature_list = $this->mdl_offer_deals_feature->getEntityFeatureList($offer_id, 'off');
        $this->layout->set(
            array(
                'active_tab' => $tab,
                'breadcrumb' => $breadcrumb, 
                'offer_id' => $offer_id,
                'offer_details' => $offer_details,
                'service_category_lists' => $this->mdl_mechanic_service_category_list->get()->result(),
                'service_category_items'=>$this->mdl_mech_service_item_dtls->get()->result(),
                'service_package' => $this->mdl_service_package->get()->result(),  
                'offer_feature_list' => $offer_feature_list,        
            )
        );            
        $this->layout->buffer('content', 'offer_deals/form');
        $this->layout->render();
    }

    public function view($offer_id = Null){
        
        $this->layout->buffer('content', 'offer_deals/view');
        $this->layout->render();
    }   

    public function delete(){
        
        $id = $this->input->post('id');
        $this->db->set('status','D');
        $this->db->where('offer_id', $id);
        $this->db->update('mech_service_offer_dtls', array('status'=>'D'));
        $response = array(
            'success' => 1
        );
        echo json_encode($response);
    }
    
}