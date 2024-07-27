<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Packages extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_service_packages');
        $this->load->model('mech_car_brand_models_details/mdl_mech_car_brand_models_details');
		$this->load->model('mech_brand_model_variants/mdl_mech_brand_model_variants');
        $this->load->model('mech_brand_model_variants/mdl_mech_brand_model_variants');
        $this->load->model('mech_item_master/mdl_mech_item_master');
        $this->load->model('products/mdl_products');
        $this->load->model('mech_vehicle_type/mdl_mech_vehicle_type');
        $this->load->model('mechanic_service_category/mdl_mechanic_service_category_list');
        $this->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls');
        
    }

    public function service_packages_index($page = 0)
    {

        $limit = 15;
        $query = $this->mdl_service_packages->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        $this->mdl_service_packages->limit($limit);
        $service_packages_details = $this->mdl_service_packages->get()->result();

        $this->layout->set(
            array(
                'service_packages_details' => $service_packages_details,
                'service_package_name' => $this->input->post('service_package_name')?$this->input->post('service_package_name'):'',
                'package_from_date' => $this->input->post('package_from_date')?$this->input->post('package_from_date'):'',
                'package_to_date' => $this->input->post('package_to_date')?$this->input->post('package_to_date'):'',
                'createLinks' => $createLinks,
            )
        );

        $this->layout->buffer('content', 'packages/service_packages_index');
        $this->layout->render();
    }

    public function service_packages($service_package_id = NULL)
    {
        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');
		
        if($service_package_id){
            $this->mdl_service_packages->where('mech_service_packages.service_package_id ='.$service_package_id.'');
            $service_packages_details = $this->mdl_service_packages->get()->row();
			$brand_id = $service_packages_details->brand_id;
			$model_id = $service_packages_details->model_id;
			$variant_id = $service_packages_details->variant_id;
			$product_list = $this->mdl_mech_item_master->where('mech_products.brand_id',$brand_id)->where('mech_products.model_id',$model_id)->get()-> result();
			$brand_models_list = $this->db->get_where('mech_car_brand_models_details', array('status' => 1,'brand_id'=>$brand_id))->result();
            $breadcrumb = 'Edit Service Package';
            $service_category_item = $this->mdl_mech_service_item_dtls->getServiceItemListForEdit(NULL, $service_packages_details->model_type, $service_packages_details->service_category_id );
        }else{
            $product_list = array();
			$brand_models_list = array();
            $breadcrumb = 'New Service Package';
            $service_packages_details = array();
            $service_category_item  = array();
        }

        $this->layout->set(array(
            'vehicle_model_type' => $this->mdl_mech_vehicle_type->get()->result(),
            'service_packages_details' => $service_packages_details,
            'car_brand_list' => $this->db->get_where('mech_car_brand_details', array('status' => 1))->result(),
            'service_category_lists' => $this->mdl_mechanic_service_category_list->get()->result(),
            'service_category_item' => $service_category_item,
            'brand_models_list' => $brand_models_list,
            'variants_list' => $this->mdl_mech_brand_model_variants->get()->result(), 
            'product_list' => $product_list
        ));

        $this->layout->buffer('content', 'packages/service_packages');
        $this->layout->render();
    }

    public function service_packages_view($service_package_id){
        if(empty($service_package_id)){
            redirect('packages/service_packages');
        }
        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');
		
        if($service_package_id){
            $this->mdl_service_packages->where('mech_service_packages.service_package_id ='.$service_package_id.'');
            $service_packages_details = $this->mdl_service_packages->get()->row();
			$brand_id = $service_packages_details->brand_id;
			$model_id = $service_packages_details->model_id;
			$variant_id = $service_packages_details->variant_id;
			$product_list = $this->mdl_mech_item_master->where('mech_products.brand_id',$brand_id)->where('mech_products.model_id',$model_id)->get()-> result();
			$brand_models_list = $this->db->get_where('mech_car_brand_models_details', array('status' => 1,'brand_id'=>$brand_id))->result();
            $breadcrumb = 'View Service Package';
        }

        $this->layout->set(array(
            'model_type' => $this->db->get_where('mech_vehicle_type', array('status' => "A"))->result(),
            'service_packages_details' => $service_packages_details,
            'car_brand_list' => $this->db->get_where('mech_car_brand_details', array('status' => 1))->result(),
            'service_category_lists' => $this->db->get_where('mechanic_service_category_list', array('category_type' => 1))->result(),
            'service_category_item' => $this->db->get_where('mech_service_item_dtls')->result(),
            'brand_models_list' => $brand_models_list,
            'variants_list' => $this->mdl_mech_brand_model_variants->get()->result(), 
            'product_list' => $product_list
        ));

        $this->layout->buffer('content', 'packages/service_packages_view');
        $this->layout->render();
    }

    public function delete_service_packages(){
    	$id = $this->input->post('id');
		$this->db->where('service_package_id', $id);
		$this->db->update('mech_service_packages_old', array('status'=>'D'));
		$response = array(
            'success' => 1
        );
		echo json_encode($response);
    }

}
