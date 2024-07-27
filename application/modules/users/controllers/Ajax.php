<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('users/mdl_users');
    }
    public function create()
    {   
    
        $user_id = $this->input->post('user_id');
        if ($this->mdl_users->run_validation('validation_rules_change_password')) {            
           $user_id = $this->mdl_users->save_change_password($user_id, $this->input->post('user_password'));            
            if($user_id){
                $response = array(
                    'success' => 1,
                    'user_id' => $user_id,
                );
            }else{
                $response = array(
                    'success' => 0,
                );
            }

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