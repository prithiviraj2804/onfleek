<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true; 
	
	public function rewards_save()
	{
        $this->load->model('mech_rewards/mdl_mech_rewards');
        $mrdlts_id = $this->input->post('mrdlts_id');
        if ($this->mdl_mech_rewards->run_validation('')) {

            if($this->input->post('mrdlts_id') == '' || $this->input->post('mrdlts_id') == NULL){
                $check = $this->db->get_where('mech_rewards_dlts', array('branch_id' => $this->input->post('branch_id'), 'workshop_id' => $this->session->userdata('work_shop_id'), 'status' => 'A'))->result();
                if (!empty($check)) {
                    $response = array(
                        'success' => 2,
                        'msg' => 'Please choose other branch'
                    );
                    echo json_encode($response);
                    exit();
                }
            }

            $mrdlts_id = $this->mdl_mech_rewards->save($mrdlts_id);
            $referral_detail = $this->mdl_mech_rewards->where('mrdlts_id', $mrdlts_id)->get()->result_array();
            $referral_list = $this->mdl_mech_rewards->get()->result_array();
            $response = array(
                'success' => 1,
                'rewards_detail' => $rewards_detail,
                'mrdlts_id' => $mrdlts_id,
                'rewards_list' => $rewards_list,
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