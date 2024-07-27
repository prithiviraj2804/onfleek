<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('payment_methods/mdl_payment_methods');
    }

    public function savepay()
    {
        $payment_method_id = $this->input->post('payment_method_id');
        if ($this->mdl_payment_methods->run_validation()) {
            
            if ($this->input->post('payment_method_id')) {
                $check = $this->db->select('payment_method_name')->from('ip_payment_methods')->where('payment_method_name',$this->input->post('payment_method_name'))->where('status !=','D')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('w_branch_id',$this->session->userdata('branch_id'))->where_not_in('payment_method_id',$this->input->post('payment_method_id'))->get()->result();   
                if (!empty($check)) {
                    $response = array(
                        'success' => 2,
                    );
                    echo json_encode($response);
                    exit();
                }
            }else{
                $check = $this->db->get_where('ip_payment_methods', array('payment_method_name' => $this->input->post('payment_method_name'),'workshop_id' => $this->session->userdata('work_shop_id'),'status !=' => 'D'))->result();
                if (!empty($check)) {
                    $response = array(
                        'success' => 2,
                    );
                    echo json_encode($response);
                    exit();
                }
            }

            $payment_method_id = $this->mdl_payment_methods->save($payment_method_id);

            if($payment_method_id){
                $response = array(
                    'success' => 1,
                    'payment_method_id' => $payment_method_id,
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