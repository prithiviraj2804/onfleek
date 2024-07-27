<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mech_Vehicle_Type extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_mech_vehicle_type');	
    }

    public function index($page = 0)
    {

        $limit = 15;
        $query = $this->mdl_mech_vehicle_type->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();
        $this->mdl_mech_vehicle_type->limit($limit);
        $mech_vehicle_type_list = $this->mdl_mech_vehicle_type->get()->result();
        
        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
        }else{
            $branch_list = array();
        }
        

        $this->layout->set(
            array(
                'mech_vehicle_type_list' => $mech_vehicle_type_list,
                'branch_list' => $branch_list,
            )
        );

        $this->layout->buffer('content', 'mech_vehicle_type/index');
        $this->layout->render();
    }
    
    public function form($mvt_id = null , $tab = NULL)
    {
        if($mvt_id){
            $this->mdl_mech_vehicle_type->where('mvt_id',$mvt_id);
            $mech_vehicle_type = $this->mdl_mech_vehicle_type->get()->row();
        }else{
            $mech_vehicle_type = array();
        }

        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
        }else{
            $branch_list = array();
        }

        $this->layout->set(
            array(
                'mech_vehicle_type' => $mech_vehicle_type,
                'branch_list' => $branch_list,
            )
        );

        $this->layout->buffer('content', 'mech_vehicle_type/create');
        $this->layout->render();
    }

    public function view($mvt_id = null , $tab = NULL)
    {
        $this->layout->buffer('content', 'mech_vehicle_type/view');
        $this->layout->render();
    }

    public function delete()
    {
        $id = $this->input->post('id');
		$this->db->where('mvt_id', $id);
		$this->db->update('mech_vehicle_type', array('status'=>'D'));
		$response = array(
            'success' => 1
        );
		echo json_encode($response);
    }

}