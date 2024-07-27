<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_Cars extends Admin_Controller
{
    
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_user_cars');
	}

    public function index()
    {
    	if($this->session->userdata('user_type') == 1){
    		$cars = $this->mdl_user_cars->get()->result();
    	}else{
    		$cars = $this->mdl_user_cars->where('owner_id', $this->session->userdata('user_id'))->get()->result();
    	}
        
		$this->layout->set(array(
            'cars_list' => $cars,
            'engine_oil_types' => $this->db->get_where('mech_engine_oil_types', array('status' => 1))->result(),
            'drive_types' => $this->db->get_where('mech_drive_types', array('status' => 1))->result()
        ));
        $this->layout->set('cars_list', $cars);
        $this->layout->buffer('content', 'user_cars/index');
        $this->layout->render();
    }

    public function view($car_id, $customer_id=NULL)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('user_cars');
        }

        $workshop_id = $this->session->userdata('work_shop_id');
        $cars = $this->mdl_user_cars->get_by_id($car_id);
        if($customer_id){
            $this->db->select('mi.invoice_id,mi.invoice_no,mi.invoice_date,mi.workshop_id,ws.workshop_name');
            $this->db->join('workshop_setup as ws','ws.workshop_id=mi.workshop_id','left');
            $this->db->where('mi.customer_id',$customer_id);
            $this->db->where('mi.workshop_id',$workshop_id);
            $this->db->order_by('mi.invoice_id');
            $customer_invoices = $this->db->get('mech_invoice as mi')->result();
            foreach ($customer_invoices as $customer_invoices_key => $customer_invoices_lists){
                $invoice_items = $this->db->query("SELECT mii.service_item,mscu.service_item_name FROM mech_invoice_item as mii left join mech_service_item_dtls mscu on mscu.msim_id = mii.service_item WHERE mii.workshop_id = '".$workshop_id."' AND mii.invoice_id = '".$customer_invoices_lists->invoice_id."' AND mii.is_from = 'invoice_service' ")->result();
                $customer_invoices[$customer_invoices_key]->invoice_items = $invoice_items;
            }
        }else{
            $user_service_history = array();
        }
        
        if (!$cars) {
            show_404();
        }

        $this->layout->set(array(
            'cars' => $cars,
            'user_service_history' => $customer_invoices,
            'pro_rec_his' => $this->mdl_user_cars->getRecommendedProductsForVehicle($car_id),
            'ser_rec_his' => $this->mdl_user_cars->getRecommendedServicesForVehicle($car_id),
            'customer_id' => $customer_id,
            'engine_oil_types' => $this->db->get_where('mech_engine_oil_types', array('status' => 1))->result(),
            'drive_types' => $this->db->get_where('mech_drive_types', array('status' => 1))->result()
        ));
        $this->layout->buffer('content', 'user_cars/view');
        $this->layout->render();
    }

    public function delete()
    {
    	$id = $this->input->post('user_car_id');
		$this->db->where('car_list_id', $id);
		$this->db->update('mech_owner_car_list', array('status'=>2));
		
        //$this->mdl_user_cars->delete($id);
        $response = array(
                'success' => 1
            );
		echo json_encode($response);	
    }

}