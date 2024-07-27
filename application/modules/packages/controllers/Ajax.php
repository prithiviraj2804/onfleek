<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{

    public $ajax_controller = true;

    public function save_service_package(){

        $this->load->model('packages/mdl_service_packages');
        $service_package_id = $this->input->post('service_package_id');
        $btn_submit = $this->input->post('btn_submit');

        if ($this->mdl_service_packages->run_validation('validation_rules')) {
            $service_package_id = $this->mdl_service_packages->save($service_package_id);
            
            $service_package_details = $this->mdl_service_packages->where('service_package_id', $service_package_id)->get()->result_array();
            $service_package_list = $this->mdl_service_packages->get()->result_array();
    
            $response = array(
                'success' => 1,
                'service_package_details' => $service_package_details,
                'service_package_id'=>$service_package_id,
                'service_package_list' => $service_package_list,
                'btn_submit' => $btn_submit
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

    public function get_filter_list(){

        $this->load->model('packages/mdl_service_packages');
        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;

        if($this->input->post('package_from_date')){
            $this->mdl_service_packages->where('mech_service_packages.offer_end_date >=', date_to_mysql($this->input->post('package_from_date')));
        }

        if($this->input->post('package_to_date')){
            $this->mdl_service_packages->where('mech_service_packages.offer_end_date <=', date_to_mysql($this->input->post('package_to_date')));
        }

        if($this->input->post('service_package_name')){
            $this->mdl_service_packages->like('mech_service_packages.service_package_name', trim($this->input->post('service_package_name')));
        }

        $rowCount = $this->mdl_service_packages->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        if($this->input->post('package_from_date')){
            $this->mdl_service_packages->where('mech_service_packages.offer_end_date >=', date_to_mysql($this->input->post('package_from_date')));
        }

        if($this->input->post('package_to_date')){
            $this->mdl_service_packages->where('mech_service_packages.offer_end_date <=', date_to_mysql($this->input->post('package_to_date')));
        }

        if($this->input->post('service_package_name')){
            $this->mdl_service_packages->like('mech_service_packages.service_package_name', trim($this->input->post('service_package_name')));
        }

        $this->mdl_service_packages->limit($limit,$start);
        $service_packages_details = $this->mdl_service_packages->get()->result();           

        $response = array(
            'success' => 1,
            'service_packages_details' => $service_packages_details, 
            'createLinks' => $createLinks,
        );
        echo json_encode($response);
    }
}