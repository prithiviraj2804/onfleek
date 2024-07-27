<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Email_Templates extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_email_templates');
    }

    public function index($page = 0)
    {
        $this->mdl_email_templates->paginate(site_url('email_templates/index'), $page);
        $email_templates = $this->mdl_email_templates->result();

        $this->layout->set('email_templates', $email_templates);
        $this->layout->buffer('content', 'email_templates/index');
        $this->layout->render();
    }

    public function form($id = null)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('email_templates');
        }

        if ($this->input->post('is_update') == 0 && $this->input->post('email_template_title') != '') {
            $check = $this->db->get_where('ip_email_templates', array('email_template_type' => $this->input->post('email_template_type'),'	branch_id' => $this->input->post('branch_id')))->result();
            if (!empty($check)) {
                $this->session->set_flashdata('alert_error', trans('email_template_already_exists'));
                redirect('email_templates/form');
            }
        }

        if ($this->mdl_email_templates->run_validation()) {
            $this->mdl_email_templates->save($id);
            redirect('email_templates');
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_email_templates->prep_form($id)) {
                show_404();
            }
            $this->mdl_email_templates->set_form_value('is_update', true);
        }

        //$this->load->model('custom_fields/mdl_custom_fields');
        $this->load->model('mech_invoices/mdl_templates');

        // foreach (array_keys($this->mdl_custom_fields->custom_tables()) as $table) {
        //     $custom_fields[$table] = $this->mdl_custom_fields->by_table($table)->get()->result();
        // }

        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A'")->result();
        }else{
            $branch_list = array();
        }

        $this->layout->set('branch_list', $branch_list);
        $this->layout->set('invoice_templates', $this->mdl_templates->get_invoice_templates());
        $this->layout->set('quote_templates', $this->mdl_templates->get_quote_templates());
        $this->layout->set('selected_pdf_template', $this->mdl_email_templates->form_value('email_template_pdf_template'));
        $this->layout->buffer('content', 'email_templates/form');
        $this->layout->render();

    }

    public function delete()
    {
    	$id = $this->input->post('id');
		$this->db->where('email_template_id', $id);
		$this->db->update('ip_email_templates', array('status'=>'D'));
		$response = array(
            'success' => 1
        );
		echo json_encode($response);
    }

}