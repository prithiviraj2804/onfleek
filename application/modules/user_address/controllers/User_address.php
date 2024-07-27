<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_address extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_user_address');
    }



    public function index()
    {
    	if($this->session->userdata('user_type') == 1){
    		$user_address_list = $this->mdl_user_address->get()->result();
    	}else{
    		$user_address_list = $this->mdl_user_address->where('user_id', $this->session->userdata('user_id'))->get()->result();
    	}

        $this->layout->set('user_address_list', $user_address_list);
        $this->layout->buffer('content', 'user_address/index');
        $this->layout->render();
    }

    public function form($id = null)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('user_address');
        }

        if ($this->mdl_user_address->run_validation()) {
			$this->mdl_user_address->save($id);
            redirect('user_address');
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_user_address->prep_form($id)) {
                show_404();
            }

            $this->mdl_user_address->set_form_value('is_update', true);
        }

		if($id){
			$address_details = array();
		}else{
			$address_details = array();
        }
        
		$this->layout->set(array(
           // 'area_list' => $this->db->get_where('mech_area_list', array('status' => 1))->result(),
            'pincode_list' => $this->db->get_where('mech_area_pincode', array('status' => 'A'))->result(),
        ));

        $this->layout->set('country_list', $this->db->query('SELECT * FROM country_lookup')->result());

        $this->layout->set('state_list',$this->db->query('SELECT * FROM mech_state_list')->result());
        $this->layout->set('city_list', $this->db->query('SELECT * FROM city_lookup')->result()); 

        $this->layout->buffer('content', 'user_address/form');
        $this->layout->render();
    }

    public function delete()
    {
    	$user_address_id = $this->input->post('user_address_id');
		$this->db->where('user_address_id', $user_address_id);
		$this->db->update('mech_user_address', array('status'=>'2'));
        $response = array(
                'success' => 1
            );
		echo json_encode($response);
    }
}
