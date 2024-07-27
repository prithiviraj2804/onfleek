<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer_category/mdl_customer_category');
    }

    public function create()
    {
        $customer_category_id = $this->input->post('customer_category_id');

        if ($this->mdl_customer_category->run_validation()) {
            
                $check = $this->db->select('customer_category_name')->from('mech_customer_category')->where('customer_category_name',$this->input->post('customer_category_name'))->where('status !=','D')->where_in('workshop_id',array(1,$this->session->userdata('work_shop_id')))->where_in('w_branch_id',array(1,$this->session->userdata('branch_id')))->get()->result();   
                // $check = $this->db->get_where('mech_customer_category', array('customer_category_name' => $this->input->post('customer_category_name'),'workshop_id' => $this->session->userdata('work_shop_id'),'status !=' => 'D'))->result();
                if (!empty($check)) {
                    $response = array(
                        'success' => 2,
                    );
                    echo json_encode($response);
                    exit();
                }

            $customer_category_id = $this->mdl_customer_category->save($customer_category_id);

            if($customer_category_id){
                $response = array(
                    'success' => 1,
                    'customer_category_id' => $customer_category_id,
                    'customer_category_det' => $this->mdl_customer_category->get()->result(),
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
        if($this->input->post('customer_category_name')){
            $this->mdl_customer_category->like('customer_category_name', trim($this->input->post('customer_category_name')));
        }
        $rowCount = $this->mdl_customer_category->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        if($this->input->post('customer_category_name')){
            $this->mdl_customer_category->like('customer_category_name', trim($this->input->post('customer_category_name')));
        }
        $this->mdl_customer_category->limit($limit,$start);
        $customercategory = $this->mdl_customer_category->get()->result();           

        $response = array(
            'success' => 1,
            'customercategory' => $customercategory, 
            'createLinks' => $createLinks,
        );
        echo json_encode($response);
    }
   
}