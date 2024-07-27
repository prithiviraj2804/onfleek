<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true; 
	
	public function create()
    {
		$this->load->model('mech_vehicle_type/mdl_mech_vehicle_type');
		
        $mvt_id = $this->input->post('mvt_id');
		
        if ($this->mdl_mech_vehicle_type->run_validation('validation_rules')) {

            if ($this->input->post('mvt_id') && $this->input->post('vehicle_type_value') != '' ) {
                $check = $this->db->select('vehicle_type_value')->from('mech_vehicle_type')->where('vehicle_type_value',$this->input->post('vehicle_type_value'))->where('workshop_id',$this->session->userdata('work_shop_id'))->where_not_in('mvt_id',$this->input->post('mvt_id'))->get()->result();   
                if (!empty($check)) {
                    $response = array(
                        'success' => 2,
                    );
                    echo json_encode($response);
                    exit();
                }
            }else{
                $check = $this->db->get_where('mech_vehicle_type', array('vehicle_type_value' => $this->input->post('vehicle_type_value'),'workshop_id' => $this->session->userdata('work_shop_id')))->result();
                if (!empty($check)) {
                    $response = array(
                        'success' => 2,
                    );
                    echo json_encode($response);
                    exit();
                }
            }

            $mvt_id = $this->mdl_mech_vehicle_type->save($mvt_id);

            $response = array(
                'success' => 1,
                'mvt_id' => $mvt_id,
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