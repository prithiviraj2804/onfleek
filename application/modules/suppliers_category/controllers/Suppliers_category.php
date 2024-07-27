<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Suppliers_category extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
       $this->load->model('mdl_suppliers_category');
    }

    public function index($page = 0)
    {
        if($this->input->post('suppliers_category_name')){
            $this->mdl_csuppliers_category->like('suppliers_category_name', trim($this->input->post('suppliers_category_name')));
        }

        $this->mdl_suppliers_category->paginate(site_url('suppliers_category/index'), $page);
        $suppliercategory = $this->mdl_suppliers_category->result();

        $this->layout->set(
            array(
                'suppliercategory' => $suppliercategory,
                'name' => $this->input->post('suppliers_category_name')?$this->input->post('suppliers_category_name'):'',
            )
        );

        $this->layout->buffer('content', 'suppliers_category/index');
        $this->layout->render();
    }

    public function form($id = null)
    {
        if($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_suppliers_category->prep_form($id)) {
                show_404();
            }
			$this->mdl_suppliers_category->set_form_value('is_update', true);
			$breadcrumb = "lable1038";
        }else{
        	$breadcrumb = "lable1037";
        }
		$this -> layout -> set(array(
			'breadcrumb' => $breadcrumb
			));
        $this->layout->buffer('content', 'suppliers_category/form');
        $this->layout->render();
    }
  
    public function delete()
    {
    	$id = $this->input->post('id');
		$this->db->where('suppliers_category_id', $id);
		$this->db->update('mech_suppliers_category', array('status'=>'D'));
		$response = array(
            'success' => 1
        );
		echo json_encode($response);
    }

}

