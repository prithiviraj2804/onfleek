<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('families/mdl_families');
    }

    public function create()
    {
        $family_id = $this->input->post('family_id');
        $family_parent_id = $this->input->post('parent_id');

        if ($this->mdl_families->run_validation()) {
            if ($this->input->post('family_id')) {
                $check = $this->db->select('family_name')->from('ip_families')->where('family_name',$this->input->post('family_name'))->where('status !=','D')->where_in('workshop_id',array(1,$this->session->userdata('work_shop_id')))->where_in('w_branch_id',array(1,$this->session->userdata('branch_id')))->where_not_in('family_id',$this->input->post('family_id'))->get()->result();   
                if (!empty($check)) {
                    $response = array(
                        'success' => 2,
                    );
                    echo json_encode($response);
                    exit();
                }
            }else{
                $check = $this->db->select('family_name')->from('ip_families')->where('family_name',$this->input->post('family_name'))->where('status !=','D')->where_in('workshop_id',array(1,$this->session->userdata('work_shop_id')))->where_in('w_branch_id',array(1,$this->session->userdata('branch_id')))->get()->result();   

                // $check = $this->db->get_where('ip_families', array('family_name' => $this->input->post('family_name'),'workshop_id' => $this->session->userdata('work_shop_id'),'status !=' => 'D'))->result();
                if (!empty($check)) {
                    $response = array(
                        'success' => 2,
                    );
                    echo json_encode($response);
                    exit();
                }
            }
            $family_id = $this->mdl_families->save($family_id,$db_array,$family_parent_id);
            if($family_id){
                $response = array(
                    'success' => 1,
                    'family_id' => $family_id,
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

        $workshop_id = $this->session->userdata('work_shop_id');
        $category_owner = $this->input->post('category_owner');
        
        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;

        if($this->input->post('family_name')){
            $this->mdl_families->like('family_name', trim($this->input->post('family_name')));
        }

        if($category_owner == 'O'){
                $this->mdl_families->where('workshop_id', $workshop_id);
        }elseif($category_owner == 'A'){
                $this->mdl_families->where('workshop_id', 1);
        }
        
        $rowCount = $this->mdl_families->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        if($this->input->post('family_name')){
            $this->mdl_families->like('family_name', trim($this->input->post('family_name')));
        }

        if($category_owner == 'O'){
            $this->mdl_families->where('workshop_id', $workshop_id);
        }elseif($category_owner == 'A'){
            $this->mdl_families->where('workshop_id', 1);
        }

        $this->mdl_families->limit($limit,$start);
        $families = $this->mdl_families->get()->result();           

        $response = array(
            'success' => 1,
            'families' => $families, 
            'createLinks' => $createLinks,
        );
        echo json_encode($response);
    }
}