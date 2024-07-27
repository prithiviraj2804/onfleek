<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout extends MX_Controller
{
    public $view_data = array();

    public function buffer()
    {
        if($this->session->userdata('user_type') == 6){
            $this->db->select('user_branch_id');
            $this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
            $this->db->where('employee_id', $this->session->userdata('emp_id'));
            $user_branch_id = $this->db->get('mech_employee')->row()->user_branch_id;
            $user_branch_id = explode(',', $user_branch_id);
        }else{
            $user_branch_id = array();
        }
        $this->session->set_userdata(array('user_branch_id' => $user_branch_id));
        $args = func_get_args();
        if (count($args) == 1) {
            foreach ($args[0] as $arg) {
                $key = $arg[0];
                $view = explode('/', $arg[1]);
                $data = array_merge(isset($arg[2]) ? $arg[2] : array(), $this->view_data);

                $this->view_data[$key] = $this->load->view($view[0] . '/' . $view[1], $data, true);
            }
        } else {
            $key = $args[0];
            $view = explode('/', $args[1]);
            $data = array_merge(isset($args[2]) ? $args[2] : array(), $this->view_data);

            $this->view_data[$key] = $this->load->view($view[0] . '/' . $view[1], $data, true);
        }
        return $this;
    }

    public function set()
    {
        if($this->session->userdata('user_type') == 6){
            $this->db->select('user_branch_id');
            $this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
            $this->db->where('employee_id', $this->session->userdata('emp_id'));
            $user_branch_id = $this->db->get('mech_employee')->row()->user_branch_id;
            $user_branch_id = explode(',', $user_branch_id);
        }else{
            $user_branch_id = array();
        }
        $this->session->set_userdata(array('user_branch_id' => $user_branch_id));
        $args = func_get_args();
        if (count($args) == 1) {
            foreach ($args[0] as $key => $value) {
                $this->view_data[$key] = $value;
            }
        } else {
            $this->view_data[$args[0]] = $args[1];
        }
        return $this;
    }

    public function render($view = 'layout')
    {
        if($this->session->userdata('user_type') == 6){
            $this->db->select('user_branch_id');
            $this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
            $this->db->where('employee_id', $this->session->userdata('emp_id'));
            $user_branch_id = $this->db->get('mech_employee')->row()->user_branch_id;
            $user_branch_id = explode(',', $user_branch_id);
        }else{
            $user_branch_id = array();
        }
        $this->session->set_userdata(array('user_branch_id' => $user_branch_id));
        $this->load->model('users/mdl_users');
        $this->view_data['permission'] = $this->mdl_users->user_module_permission();
        if($this->session->userdata('branch_id')){
            $this->view_data['is_product'] = $this->db->query("SELECT is_product FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." ")->row()->is_product;
            $this->view_data['is_pos'] = $this->db->query("SELECT pos FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." ")->row()->pos;
            $this->view_data['expiry_date'] = $this->db->query("SELECT to_date FROM mech_subscription_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')."  ORDER BY to_date DESC LIMIT 1" )->row()->to_date;
        }else{
            $this->view_data['is_product'] = '';
            $this->view_data['is_pos'] = '';
        }
        $this->load->view('layout/' . $view, $this->view_data);
    }

    public function load_view($view, $data = array())
    {
        if($this->session->userdata('user_type') == 6){
            $this->db->select('user_branch_id');
            $this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
            $this->db->where('employee_id', $this->session->userdata('emp_id'));
            $user_branch_id = $this->db->get('mech_employee')->row()->user_branch_id;
            $user_branch_id = explode(',', $user_branch_id);
        }else{
            $user_branch_id = array();
        }
        $this->session->set_userdata(array('user_branch_id' => $user_branch_id));
        $view = explode('/', $view);
        $view = $view[0] . '/' . $view[1] . (isset($view[2]) ? '/' . $view[2] : '');
        $this->load->view($view, $data);
    }

}