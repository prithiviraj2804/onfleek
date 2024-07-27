<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class View_alerts extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_view_alerts');
    }

    public function index($page = 0)
    {
        $view_alerts = $this->mdl_view_alerts->getViewAlerts();
        $this->layout->set(
            array(
                'view_alerts' => $view_alerts,
            )
        ); 
        $this->layout->buffer('content', 'view_alerts/index');
        $this->layout->render();
    }

}