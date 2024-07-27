<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mechanic_Service_Category_Items extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_mechanic_service_category_items');
        $this->load->model('mechanic_service_category/mdl_mechanic_service_category_list');
    }

    public function index($page = 0)
    {

        $limit = 15;
        $query = $this->mdl_mechanic_service_category_items->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();
        $this->mdl_mechanic_service_category_items->limit($limit);
        $mechanic_service_category_items = $this->mdl_mechanic_service_category_items->get()->result();
        
        $this->layout->set(
            array(
                'mechanic_service_category_items' => $mechanic_service_category_items,
                'service_category_lists' => $this->db->get_where('mechanic_service_category_list', array('category_type' => 1))->result(),
                'name' => $this->input->post('service_item_name')?$this->input->post('service_item_name'):'',
                'cat' => $this->input->post('service_category_id')?$this->input->post('service_category_id'):'',
                'createLinks' => $createLinks
            )
        );

        $this->layout->buffer('content', 'mechanic_service_category_items/index');
        $this->layout->render();
        
    }

    public function form($id = null)
    {
        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_mechanic_service_category_items->prep_form($id)) {
                show_404();
            }
			$this->mdl_mechanic_service_category_items->set_form_value('is_update', true);
       		$breadcrumb = "lable255";
		}else{
			$breadcrumb = "lable254";
        }
        
        $this->mdl_mechanic_service_category_list->where('category_type', 1);
        $service_category_list = $this->mdl_mechanic_service_category_list->get()->result();
		
        $this->layout->set(array(
        	 'breadcrumb' => $breadcrumb,
             'service_category_lists' => $service_category_list,
        ));
        $this->layout->buffer('content', 'mechanic_service_category_items/form');
        $this->layout->render();
    }

    public function delete()
    {
       
        $id = $this->input->post('id');
		$this->db->where('sc_item_id', $id);
		$this->db->update('mechanic_service_category_items', array('sci_status'=>'2'));
		$response = array(
            'success' => 1
        );  
		echo json_encode($response);
    }
		
	public function sitem_link()
    {
        $mechanic_service_category_items = $this->mdl_mechanic_service_category_items->get()->result();
        
        $this->layout->set('mechanic_service_category_items', $mechanic_service_category_items);
        $this->layout->buffer('content', 'mechanic_service_category_items/index');
        $this->layout->render();
    }
	
}
