<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function create()
    {
        $this->load->model('employee_role/mdl_employee_role');
        $btn_submit = $this->input->post('btn_submit');
        $action_from = ($this->input->post('action_from'))?$this->input->post('action_from'):'';
        $role_id = $this->input->post('role_id');

        if ($this->input->post('is_update') == 0 && $this->input->post('role_name') != '') {
            $check = $this->db->get_where('mech_employee_role', array('role_name' => $this->input->post('role_name'), 'workshop_id' => $this->session->userdata('work_shop_id'), 'w_branch_id' => $this->session->userdata('branch_id'),'status' => "A" ))->result();
            if (!empty($check)) {
                $response = array(
                    'success' => 2,
                    'msg' => trans('role_already_exists'),
                );
                echo json_encode($response); 
                exit();
            }
        }

        if ($this->mdl_employee_role->run_validation()) {

            if($this->input->post('role_id')){
                $check = $this->db->select('role_name')->from('mech_employee_role')->where('role_name',$this->input->post('role_name'))->where('workshop_id',$this->session->userdata('work_shop_id'))->where('w_branch_id',$this->session->userdata('branch_id'))->where('status' , 'A')->where_not_in('role_id',$this->input->post('role_id'))->get()->result();
                if (!empty($check)) {
                    $response = array(
                        'success' => 2,
                        'msg' => trans('role_already_exists'),
                    );
                    echo json_encode($response); 
                    exit();
                }
            }

            $role_id = $this->mdl_employee_role->save($role_id);

            if(!empty($action_from)){
                $employee_role_detail = $this->mdl_employee_role->where('role_id', $role_id)->get()->result_array();
                $employee_role_list = $this->mdl_employee_role->get()->result_array();
            }else{
                $employee_role_detail = '';
                $employee_role_list = array();
            }
            
            $response = array(
                'success' => 1,
                'employee_role_detail' => $employee_role_detail,
                'employee_role' => $this->mdl_employee_role->get()->result(),
                'role_id' => $role_id,
                'employee_role_list' => $employee_role_list,
                'btn_submit' => $btn_submit,
            );
        }else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
        }

        echo json_encode($response);

    }

    public function get_filter_list(){
        $this->load->model('employee_role/mdl_employee_role');
        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;
        if($this->input->post('role_name')){
            $this->mdl_employee_role->like('role_name', trim($this->input->post('role_name')));
        }
        $rowCount = $this->mdl_employee_role->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        if($this->input->post('role_name')){
            $this->mdl_employee_role->like('role_name', trim($this->input->post('role_name')));
        }
        $this->mdl_employee_role->limit($limit,$start);
        $employee_role = $this->mdl_employee_role->get()->result();           

        $response = array(
            'success' => 1,
            'employee_role' => $employee_role, 
            'createLinks' => $createLinks
        );
        echo json_encode($response);
    }

}