<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Families extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_families');
    }

    public function index($page = 0)
    {
        $limit = 15;
        $query = $this->mdl_families->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();
        $this->mdl_families->limit($limit);
        $families = $this->mdl_families->get()->result();

        $this->layout->set(
            array(
                'families' => $families,
                'createLinks' => $createLinks,
                'name' => $this->input->post('family_name')?$this->input->post('family_name'):'',
            )
        );

        $this->layout->buffer('content', 'families/index');
        $this->layout->render();
    }

    public function form($id = null)
    {
        if($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_families->prep_form($id)) {
                show_404();
            }
			$this->mdl_families->set_form_value('is_update', true);
			$breadcrumb = "lable237";
        }else{
        	$breadcrumb = "lable238";
        }
		$this -> layout -> set(array(
            'breadcrumb' => $breadcrumb,
            'parentcategory' => $this->mdl_families->where('parent_id','0')->where('workshop_id',$this->session->userdata('work_shop_id'))->get()->result(),

			));
        $this->layout->buffer('content', 'families/form');
        $this->layout->render();
    }
  
    public function delete()
    {
    	$id = $this->input->post('id');
		$this->db->where('family_id', $id);
		$this->db->update('ip_families', array('status'=>'D'));
		$response = array(
            'success' => 1
        );
		echo json_encode($response);
    }

}