<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{

    public $ajax_controller = true;

    public function save_contact_reminder(){

        $this->load->model('reminder/mdl_contact_reminder');
        $contact_reminder_id = $this->input->post('contact_reminder_id');
        $btn_submit = $this->input->post('btn_submit');

        if ($this->mdl_contact_reminder->run_validation('validation_rules')) {
            $contact_reminder_id = $this->mdl_contact_reminder->save($contact_reminder_id);
            if(empty($action_from)){
                $contact_reminder_details = $this->mdl_contact_reminder->where('contact_reminder_id', $contact_reminder_id)->get()->result_array();
                $contact_reminder_list = $this->mdl_contact_reminder->get()->result_array();
            }else{
                $contact_reminder_details = '';
                $contact_reminder_list = array();
            }
            
            $response = array(
                'success' => 1,
                'contact_reminder_details' => $contact_reminder_details,
                'contact_reminder_id'=>$contact_reminder_id,
                'contact_reminder_list' => $contact_reminder_list,
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

    public function save_custom_reminder(){

        $this->load->model('reminder/mdl_custom_reminder');
        $custom_reminder_id = $this->input->post('custom_reminder_id');
        $btn_submit = $this->input->post('btn_submit');

        if ($this->mdl_custom_reminder->run_validation('validation_rules')) {
            $custom_reminder_id = $this->mdl_custom_reminder->save($custom_reminder_id);
            if(empty($action_from)){
                $custom_reminder_details = $this->mdl_custom_reminder->where('custom_reminder_id', $custom_reminder_id)->get()->result_array();
                $custom_reminder_list = $this->mdl_custom_reminder->get()->result_array();
            }else{
                $custom_reminder_details = '';
                $custom_reminder_list = array();
            }
            
            $response = array(
                'success' => 1,
                'custom_reminder_details' => $custom_reminder_details,
                'custom_reminder_id'=>$custom_reminder_id,
                'custom_reminder_list' => $custom_reminder_list,
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

    public function save_service_reminder(){

        $this->load->model('reminder/mdl_service_reminder');
        $service_remainder_id = $this->input->post('service_remainder_id');
        $btn_submit = $this->input->post('btn_submit');
        if ($this->mdl_service_reminder->run_validation('validation_rules')) {
            $service_remainder_id = $this->mdl_service_reminder->save($service_remainder_id);
            if(empty($action_from)){
                $service_reminder_detail = $this->mdl_service_reminder->where('service_remainder_id', $service_remainder_id)->get()->result_array();
                $service_reminder_list = $this->mdl_service_reminder->get()->result_array();
            }else{
                $service_reminder_detail = '';
                $service_reminder_list = array();
            }
            
            $response = array(
                'success' => 1,
                'service_reminder_detail' => $service_reminder_detail,
                'service_remainder_id'=>$service_remainder_id,
                'service_reminder_list' => $service_reminder_list,
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

    public function save_vehicle_reminder(){

        $this->load->model('reminder/mdl_vehicle_reminder');
        $vehicle_reminder_id = $this->input->post('vehicle_reminder_id');
        $btn_submit = $this->input->post('btn_submit');
        if ($this->mdl_vehicle_reminder->run_validation('validation_rules')) {
            $vehicle_reminder_id = $this->mdl_vehicle_reminder->save($vehicle_reminder_id);
            if(empty($action_from)){
                $vehicle_reminder_details = $this->mdl_vehicle_reminder->where('vehicle_reminder_id', $vehicle_reminder_id)->get()->result_array();
                $vehicle_reminder_list = $this->mdl_vehicle_reminder->get()->result_array();
            }else{
                $vehicle_reminder_details = '';
                $vehicle_reminder_list = array();
            }
            
            $response = array(
                'success' => 1,
                'vehicle_reminder_details' => $vehicle_reminder_details,
                'vehicle_reminder_id'=>$vehicle_reminder_id,
                'vehicle_reminder_list' => $vehicle_reminder_list,
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

    public function modal_add_reminder($reminder_id = NULL, $reminder_type = NULL)
    {
        $this->load->module('layout');
        $data = array(
            'reminder_id' => $reminder_id,
            'reminder_type' => $reminder_type,
        );
        $this->layout->load_view('reminder/modal_add_reminder', $data);
    }

    public function add_reminder_history()
    {

        $this->load->model('reminder/mdl_reminder_history');
        if($this->input->post('mr_history_id')){
            $mr_history_id = $this->input->post('mr_history_id');
        }else{
            $mr_history_id = NULL;
        }
        
        $btn_submit = $this->input->post('btn_submit');

        if ($this->mdl_reminder_history->run_validation('validation_rules')) {
            $mr_history_id = $this->mdl_reminder_history->save($mr_history_id);
            if(empty($action_from)){
                $reminder_history_details = $this->mdl_reminder_history->where('mr_history_id', $mr_history_id)->get()->result_array();
                $vehicle_history_list = $this->mdl_reminder_history->get()->result_array();
            }else{
                $reminder_history_details = '';
                $vehicle_history_list = array();
            }
            
            $response = array(
                'success' => 1,
                'reminder_history_details' => $reminder_history_details,
                'mr_history_id' => $mr_history_id,
                'vehicle_history_list' => $vehicle_history_list,
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

        $this->load->model('reminder/mdl_contact_reminder');
        $this->load->model('mech_employee/mdl_mech_employee');
        $this->load->model('clients/mdl_clients');
        $this->load->model('suppliers/mdl_suppliers');
        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;

        if($this->input->post('reminder_from_date')){  
          $this->mdl_contact_reminder->where('mech_contact_reminder.contact_reminder_next_due_date >=', date("Y-m-d H:i:s", strtotime($this->input->post('reminder_from_date'))));
        }
        
        if($this->input->post('reminder_to_date')){
            $this->mdl_contact_reminder->where('mech_contact_reminder.contact_reminder_next_due_date <=', date("Y-m-d H:i:s", strtotime($this->input->post('reminder_to_date'))));
        }

        if($this->input->post('refered_by_type')){
            $this->mdl_contact_reminder->where('mech_contact_reminder.refered_by_type', $this->input->post('refered_by_type'));
        }
        if($this->input->post('status')){
            $this->mdl_contact_reminder->where('mech_contact_reminder.status', $this->input->post('status'));
        }

        $rowCount = $this->mdl_contact_reminder->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        

        if($this->input->post('reminder_from_date')){  
            $this->mdl_contact_reminder->where('mech_contact_reminder.contact_reminder_next_due_date >=', date("Y-m-d H:i:s", strtotime($this->input->post('reminder_from_date'))));
        }
        
        if($this->input->post('reminder_to_date')){
            $this->mdl_contact_reminder->where('mech_contact_reminder.contact_reminder_next_due_date <=', date("Y-m-d H:i:s", strtotime($this->input->post('reminder_to_date'))));
        }

        if($this->input->post('refered_by_type')){
            $this->mdl_contact_reminder->where('mech_contact_reminder.refered_by_type', $this->input->post('refered_by_type'));
        }
        if($this->input->post('status')){
            $this->mdl_contact_reminder->where('mech_contact_reminder.status', $this->input->post('status'));
        }
        
        $this->mdl_contact_reminder->limit($limit,$start);
        $contact_reminder_details = $this->mdl_contact_reminder->get()->result();    
        
        if(count($contact_reminder_details) > 0){
            foreach($contact_reminder_details as $key => $contactReminderList){
                if($contactReminderList->refered_by_type == 2 || $contactReminderList->refered_by_type == 4){
                    $typename = $this->mdl_mech_employee->get_employee_name($contactReminderList->refered_by_id);
                    $catName = "Employee";
                }else if($contactReminderList->refered_by_type == 1){
                    $typename =  $this->mdl_clients->get_customer_name($contactReminderList->refered_by_id);
                    $catName = "Customer";
                }else if($contactReminderList->refered_by_type == 3){
                    $typename =  $this->mdl_suppliers->get_supplier_name($contactReminderList->refered_by_id);
                    $catName = "Supplier";
                }else{
                    $typename = "";
                    $catName = "";
                }
                $contact_reminder_details[$key]->typename = $typename;
                $contact_reminder_details[$key]->catName = $catName;
            }
        }

        if(count($contact_reminder_details) > 0){
            foreach($contact_reminder_details as $key => $contactReminderList){
                if($contactReminderList->status == "O"){
                    $StatusName = "Open";
                }else if($contactReminderList->status == "P"){
                    $StatusName = "Pending";
                }else if($contactReminderList->status == "C"){
                    $StatusName = "Completed";
                }else{
                    $StatusName = "";
                }
                $contact_reminder_details[$key]->StatusName = $StatusName;
            }
        }

        $response = array(
            'success' => 1,
            'typename' => $typename,
            'contact_reminder_details' => $contact_reminder_details, 
            'createLinks' => $createLinks,
            'work_shop_id' => $this->session->userdata('work_shop_id'),
            'user_type' => $this->session->userdata('user_type'),
            'workshop_is_enabled_inventory' => $this->session->userdata('workshop_is_enabled_inventory'),
        );
        echo json_encode($response);
    }


    public function get_filter_customlist(){

        $this->load->model('reminder/mdl_custom_reminder');
        $this->load->model('clients/mdl_clients');
        $this->load->model('user_cars/mdl_user_cars');

        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;

        if($this->input->post('reminder_from_date')){  
            $this->mdl_custom_reminder->where('mech_custom_reminder.next_update >=',date_to_mysql($this->input->post('reminder_from_date')));
        }
        
        if($this->input->post('reminder_to_date')){
            $this->mdl_custom_reminder->where('mech_custom_reminder.next_update <=',date_to_mysql($this->input->post('reminder_to_date')));
        }

        if($this->input->post('customer_id')){
            $this->mdl_custom_reminder->where('mech_custom_reminder.customer_id', $this->input->post('customer_id'));
        }

        if($this->input->post('employee_id')){
            $this->mdl_custom_reminder->where('mech_custom_reminder.employee_id', $this->input->post('employee_id'));
        }

        $rowCount = $this->mdl_custom_reminder->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        if($this->input->post('reminder_from_date')){  
            $this->mdl_custom_reminder->where('mech_custom_reminder.next_update >=',date_to_mysql($this->input->post('reminder_from_date')));
        }
          
        if($this->input->post('reminder_to_date')){
            $reminder_from_date = $this->mdl_custom_reminder->where('mech_custom_reminder.next_update <=',date_to_mysql($this->input->post('reminder_to_date')));
        }

        if($this->input->post('customer_id')){
            $reminder_to_date = $this->mdl_custom_reminder->where('mech_custom_reminder.customer_id', $this->input->post('customer_id'));
        }

        if($this->input->post('employee_id')){
            $this->mdl_custom_reminder->where('mech_custom_reminder.employee_id', $this->input->post('employee_id'));
        }
        
        $this->mdl_custom_reminder->limit($limit,$start);
        $custom_reminder_details = $this->mdl_custom_reminder->get()->result();  
        
        if(count($custom_reminder_details) > 0){
            foreach($custom_reminder_details as $key => $customReminderList){
                    $typename =  $this->mdl_clients->get_customer_name($customReminderList->customer_id);
                    $custom_reminder_details[$key]->typename = $typename;
            }
        }
        if(count($custom_reminder_details) > 0){
            foreach($custom_reminder_details as $key => $customReminderList){
                    $vehicletype = $this->mdl_user_cars->getVehicleDetails($customReminderList->customer_car_id);
                    $custom_reminder_details[$key]->vehicletype = $vehicletype;
            }
        }
        $response = array(
            'success' => 1,
            'custom_reminder_details' => $custom_reminder_details, 
            'createLinks' => $createLinks
        );
        echo json_encode($response);

    }
}
