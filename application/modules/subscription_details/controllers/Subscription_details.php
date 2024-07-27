<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Subscription_details extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
       $this->load->model('mdl_subscription_details');
    }

    public function form($id = null)
    {
        if($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_subscription_details->prep_form($id)) {
                show_404();
            }
			$breadcrumb = "lable1037";
        }else{
        	$breadcrumb = "lable1134";
        }
        $feature_list =  $this->db->query('SELECT * FROM sub_feature_option where status = "A"')->result();

        $workshop_email = $this->db->query('SELECT workshop_email_id FROM workshop_setup where workshop_status = "A" and workshop_id = '.$this->session->userdata('work_shop_id').'')->row()->workshop_email_id;
        $workshop_name = $this->db->query('SELECT workshop_name FROM workshop_setup where workshop_status = "A" and workshop_id = '.$this->session->userdata('work_shop_id').'')->row()->workshop_name;


		$this -> layout -> set(array(
            'breadcrumb' => $breadcrumb,
            'plan_list' => $this->db->query('SELECT * FROM mech_plan_table ORDER BY plan_name')->result(),
            'subscription_group' => $this->db->query('SELECT * FROM admin_invoice_groups where module_type = "subscription" ORDER BY invoice_group_id ASC LIMIT 1')->row(),
            'workshop_name' => $workshop_name,
            'workshop_email' => $workshop_email,
            'feature_list' => $feature_list
			));
        $this->layout->buffer('content', 'subscription_details/form');
        $this->layout->render();
    }
  
    public function delete()
    {
    	$id = $this->input->post('id');
		$this->db->where('plan_id', $id);
		$this->db->update('mech_plan_table', array('status'=>'D'));
		$response = array(
            'success' => 1
        );
		echo json_encode($response);
    }

    public function generate_pdf($subscription_id = null, $stream = true, $subscription_template = null)
    {
        $this->load->helper('pdf');
        generate_subscription_pdf($subscription_id, $stream, $subscription_template, null);
    }

}

