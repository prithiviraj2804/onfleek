<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mechanic_Service_Category extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_mechanic_service_category_list');
        $this->load->model('upload/mdl_uploads');

    }

    public function index($page = 0)
    {

        $limit = 15;
        $query = $this->mdl_mechanic_service_category_list->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();
        $this->mdl_mechanic_service_category_list->limit($limit);
        $mechanic_service_category_list = $this->mdl_mechanic_service_category_list->get()->result();
        
        $this->layout->set(
            array(
                'mechanic_service_category_list' => $mechanic_service_category_list,
                'name' => $this->input->post('category_name')?$this->input->post('category_name'):'',
                'cat' => $this->input->post('category_type')?$this->input->post('category_type'):'',
                'createLinks' => $createLinks
            )
        );

        $this->layout->buffer('content', 'mechanic_service_category/index');
        $this->layout->render();
    }

    public function form($id = null)
    {
        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_mechanic_service_category_list->prep_form($id)) {
                show_404();
            }

            $this->mdl_mechanic_service_category_list->set_form_value('is_update', true);
        	$breadcrumb = "lable243";
		}else{
			$breadcrumb = "lable242";
        }
        $servicecategory_details = $this->mdl_mechanic_service_category_list->where('service_cat_id', $id)->get()->row();

        $parent_cat_list = $this->mdl_mechanic_service_category_list->where('category_type',1)->get()->result();

        $this->layout->set(array(
        	'breadcrumb' => $breadcrumb,
            'parent_cat_list' => $parent_cat_list,
            'servicecategory_details' => $servicecategory_details,
        )); 
        $this->layout->buffer('content', 'mechanic_service_category/form');
        $this->layout->render();
    }

    public function delete()
    {
        $id = $this->input->post('id');
		$this->db->where('service_cat_id', $id);
		$this->db->update('mechanic_service_category_list', array('status'=>'2'));
		$response = array(
            'success' => 1
        );
        echo json_encode($response);
    }
}