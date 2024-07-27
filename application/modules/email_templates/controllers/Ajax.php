<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function get_content()
    {
        $this->load->model('email_templates/mdl_email_templates');

        $id = $this->input->post('email_template_id');

        echo json_encode($this->mdl_email_templates->get_by_id($id));
    }

    public function create()
    {
        $this->load->model('email_templates/mdl_email_templates');
        $action_from = ($this->input->post('action_from'))?$this->input->post('action_from'):'';
        $email_template_id = $this->input->post('email_template_id');
        $btn_submit = $this->input->post('btn_submit');
        if ($this->mdl_email_templates->run_validation('validation_rules')) {

            if ($this->input->post('is_update') == 0 && $this->input->post('email_template_title') != '') {

                $check = $this->db->get_where('ip_email_templates', array('email_template_type' => $this->input->post('email_template_type'),'	branch_id' => $this->input->post('branch_id'),' status' => 'A'))->result();
                if (!empty($check)) {
                    $response = array(
                        'success' => 2,
                        'msg' => 'Already Exists'
                    );
                    echo json_encode($response);
                    exit();
                }
            }

            $email_template_id = $this->mdl_email_templates->save($email_template_id);

            if(empty($action_from)){
                $template_detail = $this->mdl_email_templates->where('email_template_id', $email_template_id)->get()->result_array();
                $template_list = $this->mdl_email_templates->get()->result_array();
            }else{
                $template_detail = '';
                $template_list = array();
            }

            $response = array(
                'success' => 1,
                'template_detail' => $template_detail,
                'email_template_id'=>$email_template_id,
                'template_list' => $template_list,
                'btn_submit' => $btn_submit
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
        }

        echo json_encode($response);
    }

}