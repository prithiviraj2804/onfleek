<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reminder extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('reminder/mdl_contact_reminder');
        $this->load->model('reminder/mdl_custom_reminder');
        $this->load->model('reminder/mdl_reminder_history');
        $this->load->model('reminder/mdl_service_reminder');
        $this->load->model('reminder/mdl_vehicle_reminder');
        $this->load->model('mech_employee/mdl_mech_employee');
        $this->load->model('clients/mdl_clients');
        $this->load->model('suppliers/mdl_suppliers');
        $this->load->model('user_cars/mdl_user_cars');
        $this->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls');
        $this->load->model('mechanic_service_category_items/mdl_mechanic_service_category_items');
        $this->load->model('mech_item_master/mdl_mech_item_master');
        $this->load->model('products/mdl_products');
        
    }

    public function contact_reminder_index($page = 0)
    {
       

        $limit = 15;
        $query = $this->mdl_contact_reminder->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        $this->mdl_contact_reminder->limit($limit);
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
        
        $this->layout->set(array(
            'contact_reminder_details' => $contact_reminder_details,
            'reference_type' => $this->db->get_where('mech_reference_dtls', array('status' => 1))->result(),
            'createLinks' => $createLinks,
        ));

        $this->layout->buffer('content', 'reminder/contact_reminder_index');
        $this->layout->render();
    }

    public function contact_reminder($contact_reminder_id = NULL)
    {
        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');
		
        if($contact_reminder_id){
            $this->mdl_contact_reminder->where('mech_contact_reminder.contact_reminder_id ='.$contact_reminder_id.'');
            $contact_reminder_details = $this->mdl_contact_reminder->get()->row();
            if($contact_reminder_details->refered_by_type == '2'){
                $refered_dtls = $this->db->get_where('mech_employee', array('mech_employee.employee_status' => 1, 'mech_employee.workshop_id' => $work_shop_id))->result();
            }elseif($contact_reminder_details->refered_by_type == '1'){
                $refered_dtls = $this->mdl_clients->where('client_active','A')->get()->result();
            }elseif($contact_reminder_details->refered_by_type == '3'){
                $refered_dtls = $this->mdl_suppliers->where('supplier_active',1)->get()->result();
            }else{
                $refered_dtls = array();
            }
            $breadcrumb = "lable553";
        }else{
            $breadcrumb = "lable552";
            $contact_reminder_details = array();
            $refered_dtls = array();    
        }
        $this->layout->set(array(
            'employee_list' => $this->mdl_mech_employee->get()->result(),
            'breadcrumb' => $breadcrumb,
            'reference_type' => $this->db->get_where('mech_reference_dtls', array('status' => 1))->result(),
            'refered_dtls' => $refered_dtls,
            'contact_reminder_details' => $contact_reminder_details,
        ));

        $this->layout->buffer('content', 'reminder/contact_reminder');
        $this->layout->render();
    }

    public function contact_reminder_view($contact_reminder_id){
        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');
		
        if($contact_reminder_id){
            $this->mdl_contact_reminder->where('mech_contact_reminder.contact_reminder_id ='.$contact_reminder_id.'');
            $contact_reminder_details = $this->mdl_contact_reminder->get()->row();
            if($contact_reminder_details->refered_by_type == '2' || $contact_reminder_details->refered_by_type == '4'){
                $refered_dtls = $this->db->get_where('mech_employee', array('mech_employee.employee_status' => 1, 'mech_employee.workshop_id' => $work_shop_id))->result();
            }elseif($contact_reminder_details->refered_by_type == '1'){
                $refered_dtls = $this->mdl_clients->where('client_active','A')->get()->result();
            }elseif($contact_reminder_details->refered_by_type == '3'){
                $refered_dtls = $this->mdl_suppliers->where('supplier_active',1)->get()->result();
            }else{
                $refered_dtls = array();
            }
            $this->mdl_reminder_history->where('mech_reminder_history.reminder_type = "CON"');
            $this->mdl_reminder_history->where('mech_reminder_history.reminder_id ='.$contact_reminder_id.'');
            $reminder_history_details = $this->mdl_reminder_history->get()->result();
            if(count($reminder_history_details) < 1){
                $reminder_history_details = array();
            }
            $breadcrumb = 'lable547';
        }

        $this->layout->set(array(
            'reminder_history_details' => $reminder_history_details,
            'employee_list' => $this->mdl_mech_employee->get()->result(),
            'breadcrumb' => $breadcrumb,
            'reference_type' => $this->db->get_where('mech_reference_dtls', array('status' => 1))->result(),
            'refered_dtls' => $refered_dtls,
            'contact_reminder_details' => $contact_reminder_details,
        ));

        $this->layout->buffer('content', 'reminder/contact_reminder_view');
        $this->layout->render();
    }

    public function delete_contact_reminder(){
    	$id = $this->input->post('id');
		$this->db->where('contact_reminder_id', $id);
		$this->db->update('mech_contact_reminder', array('contact_reminder_status'=>'D'));
		$response = array(
            'success' => 1
        );
		echo json_encode($response);
    }

    
    public function custom_reminder_index($page = 0)
    {
        $limit = 15;
        $query = $this->mdl_custom_reminder->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        $this->mdl_contact_reminder->limit($limit);
        $custom_reminder_details = $this->mdl_custom_reminder->get()->result();

        $this->layout->set(array(
            'custom_reminder_details' => $custom_reminder_details,
            'customer_list' => $this->mdl_clients->where('client_active','A')->get()->result(),
            'employee_list' => $this->mdl_mech_employee->get()->result(),
            'createLinks' => $createLinks
        ));

        $this->layout->buffer('content', 'reminder/custom_reminder_index');
        $this->layout->render();
    }

    public function custom_reminder($custom_reminder_id = NULL)
    {
        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');
		
        if($custom_reminder_id){
            $this->mdl_custom_reminder->where('mech_custom_reminder.custom_reminder_id ='.$custom_reminder_id.'');
            $custom_reminder_details = $this->mdl_custom_reminder->get()->row();
            if($custom_reminder_details->type_id == 'S'){
                $item_list = $this->mdl_mech_service_item_dtls->get()->result();
            }elseif($custom_reminder_details->type_id == 'P'){
                $item_list = $this->mdl_mech_item_master->get()->result();
            }
            $user_cars = $this->mdl_user_cars->where('owner_id',$custom_reminder_details->customer_id)->get()->result();
            $breadcrumb = "lable568";
        }else{
            $breadcrumb = "lable567";
            $custom_reminder_details = array();
            $item_list = array();
            $user_cars = array();
        }
        $this->layout->set(array(
            'user_cars' => $user_cars,
            'customer_list' => $this->mdl_clients->where('client_active','A')->get()->result(),
            'employee_list' => $this->mdl_mech_employee->get()->result(),
            'breadcrumb' => $breadcrumb,
            'reference_type' => $this->db->get_where('mech_reference_dtls', array('status' => 1))->result(),
            'item_list' => $item_list,
            'custom_reminder_details' => $custom_reminder_details,
        ));

        $this->layout->buffer('content', 'reminder/custom_reminder');
        $this->layout->render();
    }

    public function custom_reminder_view($custom_reminder_id){
        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');
		
        if($custom_reminder_id){
            $this->mdl_custom_reminder->where('mech_custom_reminder.custom_reminder_id ='.$custom_reminder_id.'');
            $custom_reminder_details = $this->mdl_custom_reminder->get()->row();
            if($custom_reminder_details->type_id == 'S'){
                $item_list = $this->mdl_mech_service_item_dtls->get()->result();
            }elseif($custom_reminder_details->type_id == 'P'){
                $item_list = $this->mdl_mech_item_master->get()->result();
            }
            $this->mdl_reminder_history->where('mech_reminder_history.reminder_type = "CUS"');
            $this->mdl_reminder_history->where('mech_reminder_history.reminder_id ='.$custom_reminder_id.'');
            $reminder_history_details = $this->mdl_reminder_history->get()->result();
            if(count($reminder_history_details) < 1){
                $reminder_history_details = array();
            }
            $breadcrumb = 'lable1041';
        }

        $this->layout->set(array(
            'reminder_history_details' => $reminder_history_details,
            // 'customer_list' => $this->mdl_clients->where('client_active','A')->get()->result(),
            'employee_list' => $this->mdl_mech_employee->get()->result(),
            'breadcrumb' => $breadcrumb,
            'reference_type' => $this->db->get_where('mech_reference_dtls', array('status' => 1))->result(),
            'item_list' => $item_list,
            'custom_reminder_details' => $custom_reminder_details,
        ));

        $this->layout->buffer('content', 'reminder/custom_reminder_view');
        $this->layout->render();
    }

    public function delete_custom_reminder(){
    	$id = $this->input->post('id');
		$this->db->where('custom_reminder_id', $id);
		$this->db->update('mech_custom_reminder', array('status'=>'D'));
		$response = array(
            'success' => 1
        );
		echo json_encode($response);
    }

    public function reminder_history($page = 0)
    {
        $this->mdl_reminder_history->paginate(site_url('reminder/reminder_history'), $page);
        $reminder_history_details = $this->mdl_reminder_history->result();

        $this->layout->set(array(
            'reminder_history_details' => $reminder_history_details,
        ));

        $this->layout->buffer('content', 'reminder/reminder_history');
        $this->layout->render();
    }

    public function service_reminder_index($page = 0)
    {   
        $this->mdl_service_reminder->paginate(site_url('reminder/service_reminder_index'), $page);
        $service_reminder_details = $this->mdl_service_reminder->result();

        $this->layout->set(array(
            'service_reminder_details' => $service_reminder_details,
        ));

        $this->layout->buffer('content', 'reminder/service_reminder_index');
        $this->layout->render();
    }

    public function service_reminder($service_remainder_id = NULL)
    {
        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');
		if($this->session->userdata('user_type') == 3){
            $this->mdl_user_cars->get()->where('mech_owner_car_list.workshop_id='.$work_shop_id.'');
		}elseif($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 || $this->session->userdata('user_type') == 6){
            $this->mdl_user_cars->get()->where('mech_owner_car_list.workshop_id='.$work_shop_id.' AND mech_owner_car_list.w_branch_id='.$branch_id.' AND mech_owner_car_list.created_by='.$this->session->userdata('user_id').'');
        }
        $this->mdl_user_cars->where('mech_owner_car_list.status = 1');
		$user_cars = $this->mdl_user_cars->get()->result();
        
        if($service_remainder_id){
            if($this->session->userdata('user_type') == 3){
                $this->mdl_service_reminder->get()->where('mech_service_remainder.workshop_id='.$work_shop_id.'');
            }elseif($this->session->userdata('user_type') == 4){
                $this->mdl_service_reminder->get()->where('mech_service_remainder.workshop_id='.$work_shop_id.' AND mech_service_remainder.w_branch_id='.$branch_id.' AND mech_service_remainder.created_by='.$this->session->userdata('user_id').'');
            }
            $this->mdl_service_reminder->where('mech_service_remainder.entity_id != " "');
            $this->mdl_service_reminder->where('mech_service_remainder.service_reminder_status = "A"');
            $this->mdl_service_reminder->where('mech_service_remainder.service_remainder_id ='.$service_remainder_id.'');
            $service_reminder_details = $this->mdl_service_reminder->get()->row();

            $this->db->select("owner_id");	
		    $this->db->from('mech_owner_car_list');
            $this->db->where('car_list_id', $service_reminder_details->service_vehicle_id);
            $this->db->where('workshop_id', $work_shop_id);
            $this->db->where('w_branch_id', $branch_id);
            $owner_id = $this->db->get()->row()->owner_id;

            $this->db->select("*");
            $this->db->from('mech_clients');
            $this->db->where('client_id',$owner_id);
            $this->db->where('workshop_id', $work_shop_id);
            $this->db->where('w_branch_id', $branch_id);
            $entity_list = $this->db->get()->result();
            $breadcrumb = 'Edit Service Reminder';
        }else{
            $service_reminder_details = array();
            $breadcrumb = 'New Service Reminder';
            $entity_list = array();
        }
       
        $this->layout->set(array(
            'breadcrumb' => $breadcrumb,
            'user_cars' => $user_cars,
            'service_category_items'=>$this->mdl_mech_service_item_dtls->where('status' , 'A')->get()->result(),
            'service_reminder_details' => $service_reminder_details,
            'entity_list' => $entity_list,
        ));
        $this->layout->buffer('content', 'reminder/service_reminder');
        $this->layout->render();
    }

    public function delete_service_reminder(){
    	$id = $this->input->post('id');
		$this->db->where('service_remainder_id', $id);
		$this->db->update('mech_service_remainder', array('service_reminder_status'=>'D'));
		$response = array(
            'success' => 1
        );
		echo json_encode($response);
    }

    public function vehicle_reminder_index($page = 0)
    {
        $this->mdl_vehicle_reminder->paginate(site_url('reminder/vehicle_reminder_index'), $page);
        $vehicle_reminder_details = $this->mdl_vehicle_reminder->result();

        $this->layout->set(array(
            'vehicle_reminder_details' => $vehicle_reminder_details,
        ));
        $this->layout->buffer('content', 'reminder/vehicle_reminder_index');
        $this->layout->render();
    }

    public function vehicle_reminder($vehicle_reminder_id = NULL)
    {
        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');
		if($this->session->userdata('user_type') == 3){
            $this->mdl_user_cars->get()->where('mech_owner_car_list.workshop_id='.$work_shop_id.'');
		}elseif($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 || $this->session->userdata('user_type') == 6){
            $this->mdl_user_cars->get()->where('mech_owner_car_list.workshop_id='.$work_shop_id.' AND mech_owner_car_list.w_branch_id='.$branch_id.' AND mech_owner_car_list.created_by='.$this->session->userdata('user_id').'');
        }
        $this->mdl_user_cars->where('mech_owner_car_list.status = 1');
		$user_cars = $this->mdl_user_cars->get()->result();
        
        if($vehicle_reminder_id){
            if($this->session->userdata('user_type') == 3){
                $this->mdl_vehicle_reminder->get()->where('mech_vehicle_reminder.workshop_id='.$work_shop_id.'');
            }elseif($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 || $this->session->userdata('user_type') == 6){
                $this->mdl_vehicle_reminder->get()->where('mech_vehicle_reminder.workshop_id='.$work_shop_id.' AND mech_vehicle_reminder.w_branch_id='.$branch_id.' AND mech_vehicle_reminder.created_by='.$this->session->userdata('user_id').'');
            }
            $this->mdl_vehicle_reminder->where('mech_vehicle_reminder.vehicle_reminder_status = "A"');
            $this->mdl_vehicle_reminder->where('mech_vehicle_reminder.vehicle_reminder_id ='.$vehicle_reminder_id.'');
            $vehicle_reminder_details = $this->mdl_vehicle_reminder->get()->row();

            $this->db->select("owner_id");	
		    $this->db->from('mech_owner_car_list');
            $this->db->where('car_list_id', $vehicle_reminder_details->reminder_vehicle_id);
            $this->db->where('workshop_id', $work_shop_id);
            $this->db->where('w_branch_id', $branch_id);
            $owner_id = $this->db->get()->row()->owner_id;

            $this->db->select("*");
            $this->db->from('mech_clients');
            $this->db->where('client_id',$owner_id);
            $this->db->where('workshop_id', $work_shop_id);
            $this->db->where('w_branch_id', $branch_id);
            $entity_list = $this->db->get()->result();
            $breadcrumb = 'Edit Vehicle Reminder';
        }else{
            $vehicle_reminder_details = array();
            $breadcrumb = 'New vehicle Reminder';
            $entity_list = array();
        }
       
        $this->layout->set(array(
            'breadcrumb' => $breadcrumb,
            'user_cars' => $user_cars,
            'vehicle_reminder_details' => $vehicle_reminder_details,
            'entity_list' => $entity_list,
        ));
        $this->layout->buffer('content', 'reminder/vehicle_reminder');
        $this->layout->render();
    }

    public function delete_vehicle_reminder(){
    	$id = $this->input->post('id');
		$this->db->where('vehicle_reminder_id', $id);
		$this->db->update('mech_vehicle_reminder', array('vehicle_reminder_status'=>'D'));
		$response = array(
            'success' => 1
        );
		echo json_encode($response);
    }

}
