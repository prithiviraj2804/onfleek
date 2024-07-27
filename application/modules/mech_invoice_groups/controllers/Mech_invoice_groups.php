<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mech_Invoice_Groups extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_mech_invoice_groups');
    }

    public function index()
    {
        $invoice_groups = $this->mdl_mech_invoice_groups->get()->result();
        $get_count = $this->mdl_mech_invoice_groups->get_invoice_group_type_count();
        $creation_check = $this->mdl_mech_invoice_groups->check_invoice_group_validity();

        $this->layout->set('invoice_groups', $invoice_groups);
        $this->layout->set('get_count', $get_count);
        $this->layout->set('creation_check', $creation_check);
        $this->layout->buffer('content', 'mech_invoice_groups/index');
		$this->layout->buffer(array(
				array('content', 'mech_invoice_groups/index'))
				);
        $this->layout->render();
    }

    public function form($id = null)
    {
       $creation_check = $this->mdl_mech_invoice_groups->check_invoice_group_validity();

       if($this->input->post('btn_cancel')) {
            redirect('mech_invoice_groups');
       }
       
	   $this->load->helper('security');
	   $invoice_group_name = $this->input->post('invoice_group_name');
	   $prefix_text = $this->input->post('prefix_text');
	   $suffix_text = $this->input->post('suffix_text');
	   $module_type = $this->input->post('module_type');
	   $invoice_group_identifier_format = $prefix_text."{{{id}}}".$suffix_text;
	   if($id == null && $invoice_group_name){
			$check = $this->db->select('invoice_group_name')->from('ip_invoice_groups')->where('invoice_group_name',$invoice_group_name)->where('module_type', $module_type)->where(array('workshop_id'=>$this->session->userdata('work_shop_id'),'w_branch_id'=>$this->session->userdata('branch_id'),'branch_id'=>$this->session->userdata('branch_id')))->get()->result();
	   }else if($id){
			$check = $this->db->select('invoice_group_name')->from('ip_invoice_groups')->where('invoice_group_name',$invoice_group_name)->where('module_type', $module_type)->where(array('workshop_id'=>$this->session->userdata('work_shop_id'),'w_branch_id'=>$this->session->userdata('branch_id'),'branch_id'=>$this->session->userdata('branch_id')))->where_not_in('invoice_group_id',$id)->get()->result();
	   }

	   if($check && $invoice_group_name){
	       if (count($check) > 0) {
                $this->session->set_flashdata('alert_error', trans('Invoice Group Name already exists'));
                redirect('mech_invoice_groups/form');
            }   
	   }

		if($id == null && $prefix_text != '' && $suffix_text != ''){
			$check1 = $this->db->select('invoice_group_name')->from('ip_invoice_groups')->where(array('invoice_group_identifier_format' => $invoice_group_identifier_format,'module_type' => $this->input->post('module_type'),'workshop_id'=>$this->session->userdata('work_shop_id'),'w_branch_id'=>$this->session->userdata('branch_id')))->get()->result();
		}else if($id){
			$check1 = $this->db->select('invoice_group_name')->from('ip_invoice_groups')->where(array('invoice_group_identifier_format' => $invoice_group_identifier_format,'module_type' => $this->input->post('module_type'),'workshop_id'=>$this->session->userdata('work_shop_id'),'w_branch_id'=>$this->session->userdata('branch_id')))->where_not_in('invoice_group_id',$id)->get()->result();
		}

		if($check1 == null && ($prefix_text || $suffix_text)){
			if (count($check1) > 0) {
               $this->session->set_flashdata('alert_error', trans('Invoice Group with the same prefix and suffix already exists'));
                redirect('mech_invoice_groups/form');
            }
		}
        
        if ($this->input->post('is_update') == 0 && $prefix_text != '' && $suffix_text != '') {
            if($id == null){
                $check = $this->db->get_where('ip_invoice_groups', array('invoice_group_identifier_format' => $invoice_group_identifier_format,'module_type' => $this->input->post('module_type'),'workshop_id'=>$this->session->userdata('work_shop_id'),'w_branch_id'=>$this->session->userdata('branch_id')))->result();
            }else if($id){
                $check = $this->db->get_where('ip_invoice_groups', array('invoice_group_identifier_format' => $invoice_group_identifier_format,'module_type' => $this->input->post('module_type'),'workshop_id'=>$this->session->userdata('work_shop_id'),'w_branch_id'=>$this->session->userdata('branch_id'),'invoice_group_id !=' => $id))->result();
            }

            if (!empty($check)) {
                $this->session->set_flashdata('alert_error', trans('Invoice Group with the same prefix and suffix already exists'));
                redirect('mech_invoice_groups/form');
            }
        }

        if ($this->mdl_mech_invoice_groups->run_validation()) {
            $id=$this->mdl_mech_invoice_groups->save($id);
			redirect('workshop_setup/index/4');
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_mech_invoice_groups->prep_form($id)) {
                show_404();
            }
        } elseif (!$id) {
            $this->mdl_mech_invoice_groups->set_form_value('invoice_group_left_pad', 5);
            $this->mdl_mech_invoice_groups->set_form_value('invoice_group_next_id', 1);
        }
		if($id){
			$group = $this->mdl_mech_invoice_groups->where("invoice_group_id", $id)->get()->row();
        	$this->layout->set('pagetitle',trans('lable1108'));
        }else{
        	$group = array();
        	$this->layout->set('pagetitle',trans('lable1109'));
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
            'invoice_group_id' => $id,
            'branch_list' => $branch_list,
            'invoice_group' => $group,
            'creation_check' => $creation_check
        ));
		
        $this->layout->buffer('content', 'mech_invoice_groups/form');
        $this->layout->render();
    }

	public function update_status()
	{   
        $id = $this->input->post('id');
        $type = $this->input->post('type');
		$this->db->where('invoice_group_id',$id);
		$this->db->update('ip_invoice_groups', array('status'=>$type));

        $response = array(
                'success' => 1,
            );
        echo json_encode($response);
	}

    public function delete()
    {
    	$id = $this->input->post('id');
		$this->mdl_mech_invoice_groups->delete($id);
		$response = array(
            'success' => 1
        );
		echo json_encode($response);
    }
}