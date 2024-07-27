<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true; 
	
	public function referral_save()
	{
        $this->load->model('mech_referral/mdl_mech_referral');
        $mrefh_id = $this->input->post('mrefh_id');
        if ($this->mdl_mech_referral->run_validation('')) {

            if($this->input->post('mrefh_id') == '' || $this->input->post('mrefh_id') == NULL){
                $check = $this->db->get_where('mech_referral_dlts', array('branch_id' => $this->input->post('branch_id'), 'workshop_id' => $this->session->userdata('work_shop_id'), 'status' => 'A'))->result();
                if (!empty($check)) {
                    $response = array(
                        'success' => 2,
                        'msg' => 'Please choose other branch'
                    );
                    echo json_encode($response);
                    exit();
                }
            }

            $mrefh_id = $this->mdl_mech_referral->save($mrefh_id);
            $referral_detail = $this->mdl_mech_referral->where('mrefh_id', $mrefh_id)->get()->result_array();
            $referral_list = $this->mdl_mech_referral->get()->result_array();
            $response = array(
                'success' => 1,
                'referral_detail' => $referral_detail,
                'mrefh_id' => $mrefh_id,
                'referral_list' => $referral_list,
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