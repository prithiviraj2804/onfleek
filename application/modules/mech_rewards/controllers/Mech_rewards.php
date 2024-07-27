<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mech_Rewards extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mech_rewards/mdl_mech_rewards');
    }

    public function index($page = 0)
    {
        $this->mdl_mech_rewards->paginate(site_url('mech_rewards/index'), $page);
        $mech_rewards = $this->mdl_mech_rewards->result();

        $this->layout->set(
            array(
                'mech_rewards' => $mech_rewards,
            )
        );

        $this->layout->buffer('content', 'mech_rewards/index');
        $this->layout->render();
    }
    
 	public function create($mrdlts_id = NULL)
    {
        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');

        if($mrdlts_id){

            $this->mdl_mech_rewards->where('mrdlts_id='.$mrdlts_id.'');
            if($this->session->userdata('user_type') == 3){
                $this->mdl_mech_rewards->where('mech_rewards_dlts.workshop_id='.$work_shop_id.'');
            }elseif($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 || $this->session->userdata('user_type') == 6){
                $this->mdl_mech_rewards->where('mech_rewards_dlts.workshop_id='.$work_shop_id.' AND mech_rewards_dlts.w_branch_id='.$branch_id.' AND mech_rewards_dlts.created_by='.$this->session->userdata('user_id').' ');
            }

            $rewards_detail = $this->mdl_mech_rewards->get()->row();
			$breadcrumb = "Edit Rewards";
        }else{
            $rewards_detail = array();
            $breadcrumb = "Create Rewards";
        }

        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name,rewards FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name,rewards FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name,rewards FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name,rewards FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
        }else{
            $branch_list = array();
        }

        $this->layout->set(array(
        	'breadcrumb' => $breadcrumb,
            'mrdlts_id' => $mrdlts_id,
            'branch_list' => $branch_list,
            'rewards_detail' => $rewards_detail,
        ));

        $this->layout->buffer('content', 'mech_rewards/create');
        $this->layout->render();
    }

    public function delete()
    {
    	$id = $this->input->post('id');
		$this->db->where('mrdlts_id', $id);
		$this->db->update('mech_rewards_dlts', array('status'=>'D'));
		$response = array(
            'success' => 1
        );
		echo json_encode($response);
    }

}