<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function create()
    {
        $this->load->model('user_address/mdl_user_address');

        if($this->input->post('is_new_city') == 'Y'){

            $this->db->select('*');
            $this->db->from('city_lookup');
            $this->db->where('city_name' , $this->input->post('new_city'));
            $this->db->where('state_id' , $this->input->post('customer_state'));
            $this->db->where('country_id' , $this->input->post('customer_country'));
            $check_city = $this->db->get()->result();
            if(count($check_city) > 0){
                $response = array(
                    'success' => 0,
                    'message' => 'City already exist',
                );
                echo json_encode($response);
                exit();
            }else{
                $cityinsertdata = array(
                    'city_name' => ucfirst($this->input->post('new_city')),
                    'state_id' => $this->input->post('customer_state'),
                    'country_id' => $this->input->post('customer_country'),
                    'status' => 1
                );
                $this->db->insert('city_lookup' , $cityinsertdata);
                $_POST['customer_city'] = $this->db->insert_id();
            }
        }

        if ($this->mdl_user_address->run_validation()) {

            $address_id = $this->input->post('address_id');
            $address_id = $this->mdl_user_address->save($address_id);
            $address_list = $this->mdl_user_address->where('user_address_id', $address_id)->get()->row();

            $response = array(
                'success' => 1,
                'address_details' => $address_list,
                'address_id' => $address_id,
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors(),
            );
        }
        echo json_encode($response);
    }

    public function modal_add_address($customer_id, $address_id = null, $type = null, $entity_type = NULL)
    {
        $this->load->model('user_address/mdl_user_address');
        $this->load->module('layout');
        if ($address_id > 0) {
            $address_list = $this->mdl_user_address->where('user_address_id' , $address_id)->get()->row();
        } else {
            $address_list = array();
        }
        
        $state_list = $this->db->query('SELECT * FROM mech_state_list')->result();
        $city_list = $this->db->query('SELECT * FROM city_lookup')->result();

        $data = array(
            'type' => $type,
            'customer_id' => $customer_id,
            'entity_type' => $entity_type,
            'address_id' => $address_id,
            'pincode_list' => $this->db->get_where('mech_area_pincode', array('status' => 'A'))->result(),
            'address_detail' => $address_list,
            'country_list' => $this->db->query('SELECT * FROM country_lookup')->result(),
            'city_list' => $city_list,
            'state_list' => $state_list,
            'area' => $area
        );

        $this->layout->load_view('user_address/modal_add_address', $data);
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

    public function get_customer_q_address()
    {
        //echo $this->input->post('customer_id');
        $this->db->select('*');
        $this->db->from('mech_user_address');
        $this->db->where('user_id', $this->input->post('customer_id'));
        echo json_encode($this->db->get()->result());
        /*$this->db->select("*");
        $this->db->from('mech_user_address');
        $this->db->where('user_id', $_POST['customer_id']);
        echo json_encode($this->db->get()->result()); */
    }

    public function get_customer_address($customer_id)
    {
        $this->db->select('*');
        $this->db->from('mech_user_address');
        $this->db->where('user_id', $customer_id);

        return $this->db->get()->result();
    }
}
