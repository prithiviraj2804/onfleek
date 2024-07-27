<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');



/**
 * Class Ajax
 */
class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_settings');
    }

    public function get_cron_key()
    {
        $this->load->helper('string');
        echo random_string('alnum', 16);
    }

    public function test_mail()
    {
        $this->load->helper('mailer');
        email_invoice(1, 'InvoicePlane', 'denys@denv.it', 'denys@denv.it', 'Test', 'Some text');
    }

    public function get_state_list()
    {
        if (!empty($this->input->post('country_id'))) {
            $result = $this->mdl_settings->getStateList($this->input->post('country_id'));
        } else {
            $result = array();
        }
        echo json_encode($result);
    }

    public function get_city_list()
    {
        if (!empty($this->input->post('state_id'))) {
            $result = $this->mdl_settings->getCityList($this->input->post('state_id'));
        } else {
            $result = array();
        }
        echo json_encode($result);
    }
}
