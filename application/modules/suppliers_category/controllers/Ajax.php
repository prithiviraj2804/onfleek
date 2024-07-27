<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('suppliers_category/mdl_suppliers_category');
    }

    public function create()
    {
        $suppliers_category_id = $this->input->post('suppliers_category_id');

        if ($this->mdl_suppliers_category->run_validation()) {
            
                $check = $this->db->get_where('mech_suppliers_category', array('suppliers_category_name' => $this->input->post('suppliers_category_name'),'workshop_id' => $this->session->userdata('work_shop_id'),'status !=' => 'D'))->result();
                if (!empty($check)) {
                    $response = array(
                        'success' => 2,
                    );
                    echo json_encode($response);
                    exit();
                }

            $suppliers_category_id = $this->mdl_suppliers_category->save($suppliers_category_id);

            if($suppliers_category_id){
                $response = array(
                    'success' => 1,
                    'suppliers_category_id' => $suppliers_category_id,
                    'supplier_category_det' => $this->mdl_suppliers_category->get()->result(),
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
        if($this->input->post('suppliers_category_name')){
            $this->mdl_suppliers_category->like('suppliers_category_name', trim($this->input->post('suppliers_category_name')));
        }
        $rowCount = $this->mdl_suppliers_category->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        if($this->input->post('suppliers_category_name')){
            $this->mdl_suppliers_category->like('suppliers_category_name', trim($this->input->post('suppliers_category_name')));
        }
        $this->mdl_suppliers_category->limit($limit,$start);
        $suppliercategory = $this->mdl_suppliers_category->get()->result();           

        $response = array(
            'success' => 1,
            'suppliercategory' => $suppliercategory, 
            'createLinks' => $createLinks,
        );
        echo json_encode($response);
    }
   
}