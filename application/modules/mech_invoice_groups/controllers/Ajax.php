<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true; 
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mech_invoice_groups/mdl_mech_invoice_groups');
    }

	public function save()
	{
        $creation_check = $this->mdl_mech_invoice_groups->check_invoice_group_validity();
        
        $this->load->helper('security');
        $invoice_group_id = $this->input->post('invoice_group_id')?$this->input->post('invoice_group_id'):NULL;
        $invoice_group_name = $this->input->post('invoice_group_name');
        $prefix_text = $this->input->post('prefix_text');
        $suffix_text = $this->input->post('suffix_text');
        $module_type = $this->input->post('module_type');
        $invoice_group_identifier_format = $prefix_text."{{{id}}}".$suffix_text;

        if($invoice_group_id == null && $invoice_group_name){
             $check = $this->db->select('invoice_group_name')->from('ip_invoice_groups')->where('invoice_group_name',$invoice_group_name)->where('module_type', $module_type)->where(array('workshop_id'=>$this->session->userdata('work_shop_id'),'w_branch_id'=>$this->session->userdata('branch_id'),'branch_id'=>$this->session->userdata('branch_id')))->get()->result();
        }else if($invoice_group_id){
             $check = $this->db->select('invoice_group_name')->from('ip_invoice_groups')->where('invoice_group_name',$invoice_group_name)->where('module_type', $module_type)->where(array('workshop_id'=>$this->session->userdata('work_shop_id'),'w_branch_id'=>$this->session->userdata('branch_id'),'branch_id'=>$this->session->userdata('branch_id')))->where_not_in('invoice_group_id',$invoice_group_id)->get()->result();
        }
 
        if($check && $invoice_group_name){
            if (count($check) > 0) {
                $response = array(
                    'success' => 2,
                    'validation_errors' => trans('Invoice Group Name already exists')
                );
                echo json_encode($response);
		        exit();
            }   
        }
 
         if($invoice_group_id == null && $prefix_text != '' && $suffix_text != ''){
             $check1 = $this->db->select('invoice_group_name')->from('ip_invoice_groups')->where(array('invoice_group_identifier_format' => $invoice_group_identifier_format,'module_type' => $this->input->post('module_type'),'workshop_id'=>$this->session->userdata('work_shop_id'),'w_branch_id'=>$this->session->userdata('branch_id')))->get()->result();
         }else if($id){
             $check1 = $this->db->select('invoice_group_name')->from('ip_invoice_groups')->where(array('invoice_group_identifier_format' => $invoice_group_identifier_format,'module_type' => $this->input->post('module_type'),'workshop_id'=>$this->session->userdata('work_shop_id'),'w_branch_id'=>$this->session->userdata('branch_id')))->where_not_in('invoice_group_id',$id)->get()->result();
         }else{
            $check1 = array();
         }
 
         if($check1 == null && ($prefix_text || $suffix_text)){
             if (count($check1) > 0) {
                $response = array(
                    'success' => 2,
                    'validation_errors' => trans('Invoice Group with the same prefix and suffix already exists')
                );
                echo json_encode($response);
		        exit();
             }
         }
         
         if ($this->input->post('is_update') == 0 && $prefix_text != '' && $suffix_text != '') {
             if($invoice_group_id == null){
                 $check = $this->db->get_where('ip_invoice_groups', array('invoice_group_identifier_format' => $invoice_group_identifier_format,'module_type' => $this->input->post('module_type'),'workshop_id'=>$this->session->userdata('work_shop_id'),'w_branch_id'=>$this->session->userdata('branch_id')))->result();
             }else if($invoice_group_id){
                 $check = $this->db->get_where('ip_invoice_groups', array('invoice_group_identifier_format' => $invoice_group_identifier_format,'module_type' => $this->input->post('module_type'),'workshop_id'=>$this->session->userdata('work_shop_id'),'w_branch_id'=>$this->session->userdata('branch_id'),'invoice_group_id !=' => $invoice_group_id))->result();
             }
 
             if (!empty($check)) {
                $response = array(
                    'success' => 2,
                    'validation_errors' => trans('Invoice Group with the same prefix and suffix already exists')
                );
                echo json_encode($response);
		        exit();
             }
         }
 
         if($this->mdl_mech_invoice_groups->run_validation()){
             $invoice_group_id = $this->mdl_mech_invoice_groups->save($invoice_group_id);
             $response = array(
                'success' => 1
            );
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

}