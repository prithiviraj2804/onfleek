<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mech_Referral extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mech_referral/mdl_mech_referral');
    }

    public function index($page = 0)
    {
        $this->mdl_mech_referral->paginate(site_url('mech_referral/index'), $page);
        $mech_referrals = $this->mdl_mech_referral->result();

        $this->layout->set(
            array(
                'mech_referrals' => $mech_referrals,
            )
        );

        $this->layout->buffer('content', 'mech_referral/index');
        $this->layout->render();
    }
    
 	public function create($mrefh_id = NULL)
    {
        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');

        if($mrefh_id){

            $this->mdl_mech_referral->where('mrefh_id='.$mrefh_id.'');
            $referral_detail = $this->mdl_mech_referral->get()->row();
			$breadcrumb = "Edit Referral";
        }else{
            $referral_detail = array();
            $breadcrumb = "Create Referral";
        }

        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name,referral FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name,referral FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name,referral FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name,referral FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
        }else{
            $branch_list = array();
        }

        $this->layout->set(array(
        	'breadcrumb' => $breadcrumb,
            'mrefh_id' => $mrefh_id,
            'branch_list' => $branch_list,
            'referral_detail' => $referral_detail,
        ));

        $this->layout->buffer('content', 'mech_referral/create');
        $this->layout->render();
    }

    public function delete()
    {
    	$id = $this->input->post('id');
		$this->db->where('mrefh_id', $id);
		$this->db->update('mech_referral_dlts', array('status'=>'D'));
		$response = array(
            'success' => 1
        );
		echo json_encode($response);
    }

}