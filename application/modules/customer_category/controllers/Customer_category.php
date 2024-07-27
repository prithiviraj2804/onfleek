<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customer_category extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
       $this->load->model('mdl_customer_category');
    }

    public function index($page = 0)
    {
        if($this->input->post('customer_category_name')){
            $this->mdl_customer_category->like('customer_category_name', trim($this->input->post('customer_category_name')));
        }

        $this->mdl_customer_category->paginate(site_url('customer_category/index'), $page);
        $customercategory = $this->mdl_customer_category->result();

        $this->layout->set(
            array(
                'customercategory' => $customercategory,
                'name' => $this->input->post('customer_category_name')?$this->input->post('customer_category_name'):'',
            )
        );

        $this->layout->buffer('content', 'customer_category/index');
        $this->layout->render();
    }

    public function form($id = null)
    {
        if($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_customer_category->prep_form($id)) {
                show_404();
            }
			$this->mdl_customer_category->set_form_value('is_update', true);
			$breadcrumb = "lable848";
        }else{
        	$breadcrumb = "lable849";
        }
		$this -> layout -> set(array(
			'breadcrumb' => $breadcrumb
			));
        $this->layout->buffer('content', 'customer_category/form');
        $this->layout->render();
    }
  
    public function delete()
    {
    	$id = $this->input->post('id');
		$this->db->where('customer_category_id', $id);
		$this->db->update('mech_customer_category', array('status'=>'D'));
		$response = array(
            'success' => 1
        );
		echo json_encode($response);
    }

}

