<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
	public $ajax_controller = true;
	
	public function __construct()
    {
        parent::__construct();
        $this->load->model('mechanic_service_category_items/mdl_mechanic_service_category_items');
    }

	public function get_service_category()
	{
		$service_category_id = $this->input->post('service_category_id');
		$service_category_list = $this->mdl_mechanic_service_category_items->where('service_category_id' ,$service_category_id)->get()->result();
		echo json_encode($service_category_list);
	}

	public function get_service_list(){
		$service_category_lists = $this->mdl_mechanic_service_category_items->get()->result();
		echo json_encode($service_category_lists);
	}

	public function save(){

        $sc_item_id = $this->input->post('sc_item_id');
		if($this->mdl_mechanic_service_category_items->run_validation()){
            if($this->input->post('sc_item_id')){
                $check = $this->db->select('service_item_name')->from('mechanic_service_category_items')->where('service_item_name',$this->input->post('service_item_name'))->where('workshop_id',$this->session->userdata('work_shop_id'))->where_not_in('sc_item_id',$this->input->post('sc_item_id'))->get()->result();
            }else{
                $check = $this->db->select('service_item_name')->from('mechanic_service_category_items')->where('service_item_name',$this->input->post('service_item_name'))->where('workshop_id',$this->session->userdata('work_shop_id'))->get()->result();
            }
            if(!empty($check)){
                $response = array(
                    'success' => 2,
                );
                echo json_encode($response);
                exit();
            }
			$sc_item_id = $this->mdl_mechanic_service_category_items->save($sc_item_id);
            if($sc_item_id){
                $response = array(
                    'success' => 1,
                    'sc_item_id' => $sc_item_id,
                );
            }else{
                $response = array(
                    'success' => 0,
                );
            }	
        }else{
			$this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
        }
        echo json_encode($response);
        exit();
    }
    

    public function get_filter_list(){
        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;
        if($this->input->post('service_item_name')){
            $this->mdl_mechanic_service_category_items->like('service_item_name', trim($this->input->post('service_item_name')));
        }
        if($this->input->post('service_category_id')){
            $this->mdl_mechanic_service_category_items->where('service_category_id', trim($this->input->post('service_category_id')));
        }
        $rowCount = $this->mdl_mechanic_service_category_items->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        if($this->input->post('service_item_name')){
            $this->mdl_mechanic_service_category_items->like('service_item_name', trim($this->input->post('service_item_name')));
        }
        if($this->input->post('service_category_id')){
            $this->mdl_mechanic_service_category_items->where('service_category_id', trim($this->input->post('service_category_id')));
        }
        $this->mdl_mechanic_service_category_items->limit($limit,$start);
        $mechanic_service_category_items = $this->mdl_mechanic_service_category_items->get()->result();           

        $response = array(
            'success' => 1,
            'mechanic_service_category_items' => $mechanic_service_category_items, 
            'createLinks' => $createLinks,
        );
        echo json_encode($response);
    }
}