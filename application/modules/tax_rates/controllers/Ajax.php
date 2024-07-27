<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('tax_rates/mdl_tax_rates');
    }

    public function save_tax()
    {
        $tax_rate_id = $this->input->post('tax_rate_id');
        $btn_submit = $this->input->post('btn_submit');

        if ($this->mdl_tax_rates->run_validation('validation_rules_tax')) {
            $tax_rate_id = $this->mdl_tax_rates->save($tax_rate_id);	

            $response = array(
                'success' => 1,
                'tax_rate_id'=>$tax_rate_id,
                'btn_submit' => $btn_submit,
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