<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Employee_Role extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_employee_role');
    }

    public function index($page = 0)
    {
        $limit = 15;
        $query = $this->mdl_employee_role->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();
        $this->mdl_employee_role->limit($limit);
        $employee_role = $this->mdl_employee_role->get()->result();

        $this->layout->set(
            array(
                'name' => $this->input->post('role_name')?$this->input->post('role_name'):'',
                'employee_role' => $employee_role,
                'createLinks' => $createLinks 
            )
        );

        $this->layout->buffer('content', 'employee_role/index');
        $this->layout->render();
    }

    public function form($id = null)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('employee_role');
        }

        if ($this->input->post('is_update') == 0 && $this->input->post('role_name') != '') {
            $check = $this->db->get_where('mech_employee_role', array('role_name' => $this->input->post('role_name'), 'workshop_id' => $this->session->userdata('work_shop_id'), 'w_branch_id' => $this->session->userdata('branch_id')))->result();

            if (!empty($check)) {
                $this->session->set_flashdata('alert_error', trans('role_already_exists'));
                redirect('employee_role/form');
            }
        }

        if ($this->mdl_employee_role->run_validation()) {

            if($id){
                $check = $this->db->select('role_name')->from('mech_employee_role')->where('role_name',$this->input->post('role_name'))->where('workshop_id',$this->session->userdata('work_shop_id'))->where('w_branch_id',$this->session->userdata('branch_id'))->where_not_in('role_id',$id)->get()->result();
                if (!empty($check)) {
                    $this->session->set_flashdata('alert_error', trans('role_already_exists'));
                    redirect('employee_role/form');
                }
            }
           
            $this->mdl_employee_role->save($id);
            redirect('employee_role');
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_employee_role->prep_form($id)) {
                show_404();
            }
			$this->mdl_employee_role->set_form_value('is_update', true);
        	$breadcrumb = "lable204";
		}else{
			$breadcrumb = "lable203";
		}
		$this->layout->set('breadcrumb', $breadcrumb);
        $this->layout->buffer('content', 'employee_role/form');
        $this->layout->render();
    }

    public function delete()
    {
        $id = $this->input->post('id');
		$this->db->where('role_id', $id);
		$this->db->update('mech_employee_role', array('status'=>'D'));
		$response = array(
            'success' => 1
        );
		echo json_encode($response);
    }

}