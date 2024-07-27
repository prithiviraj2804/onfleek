<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Appointmentdetail
 */

require_once APPPATH . 'libraries/REST_Controller.php';

class Appointmentdetail extends REST_Controller{

	public function __construct()
    {
		parent::__construct();
		$this->load->model('settings/mdl_settings');
		$this->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');
	}
	
	public function branchdtls_get($workshop_id){
		
		$this->db->select('w_branch_id,display_board_name,branch_contact_no,branch_street,branch_city,branch_state,branch_country,branch_pincode,cy.city_name,st.state_name,ct.name as country_name');
		//$this->db->from('workshop_branch_details br'); 
		$this->db->join('city_lookup cy', 'cy.city_id=br.branch_city', 'left');
		$this->db->join('mech_state_list st', 'st.state_id=br.branch_state', 'left');
		$this->db->join('country_lookup ct', 'ct.id=br.branch_country', 'left');
		$branch = $this->db->get_where('workshop_branch_details br', array('workshop_id' => $workshop_id, 'branch_status' => 'A'));
		$branch_data = $branch->result();
		$data = array(
			'workshop_branch_list' => $branch_data
		);
        echo json_encode($data); 
	}

	public function appointmentlist_post(){
		$json = file_get_contents('php://input');
		$obj = json_decode($json, TRUE);
		
		$workshop_id = $obj['workshop_id'];
		$customer_id = $obj['user_id'];
		
		$this->db->select('ml_id,ml.user_address_id,ml.branch_id,ml.w_branch_id,ml.customer_id,ml.user_car_list_id,ml.leads_no,ml.lead_date,ml.lead_status,ml.pickup,ml.grand_total,js.status_label,wo.jobsheet_no');
		$this->db->join('mech_work_order_dtls wo', 'wo.work_from="A" and wo.work_from_id=ml.ml_id', 'left');
		$this->db->join('mech_appointment_status js', 'js.mps_id=ml.lead_status', 'left');
		$app = $this->db->order_by('ml_id', 'DESC')->get_where('mech_leads ml', array('ml.workshop_id' => $workshop_id, 'ml.customer_id' => $customer_id, 'ml.category_type' => 'A', 'ml.status' => 'A'));
		$data_ary = $app->result();
		
		$data = array(
			'appointmentlist' => $data_ary
		);
        echo json_encode($data); 
	}


	public function create_post(){
		$json = file_get_contents('php://input');
		$obj = json_decode($json, TRUE);
		
		$this->load->model('mech_invoice_groups/mdl_mech_invoice_groups');
        $number = $this->db->select('invoice_group_id')->from('ip_invoice_groups')->where('module_type', 'appointment')->where('workshop_id', $obj['workshop_id'])->where('w_branch_id', $obj['w_branch_id'])->where('status', 'A')->get()->row();
        if ($number) {
            $group_no = $number->invoice_group_id;
        } else {
            $group_no = 0;
		}

		$this->load->model('mech_invoice_groups/mdl_mech_invoice_groups');
        $leads_no = $this->mdl_mech_invoice_groups->generate_api_invoice_number($obj['workshop_id'],$obj['w_branch_id'],$group_no);
		$created_on = date('Y-m-d H:m:s', strtotime(date('Y-m-d H:m:s')));
	
		$service_package_items = $obj['service_package_items'];
		
		if(count($service_package_items)>0){
			$db_array = array(
				"workshop_id" => $obj['workshop_id'],
				"w_branch_id" => $obj['w_branch_id'],
				"branch_id" => $obj['w_branch_id'],
				"invoice_group_id" => $group_no,
				"leads_no" => $leads_no,
				"category_type" => $obj['category_type'],
				"customer_id" => $obj['customer_id'],
				"user_address_id" => $obj['user_address_id'],
				"user_car_list_id" => $obj['user_car_list_id'],
				"lead_date" => $obj['lead_date'],
				"reschedule_date" => $obj['lead_date'],
				"lead_source" => 22,
				"lead_status" => $obj['lead_status'],
				"pickup" => $obj['pickup'],
				"created_by" => $obj['customer_id'],
				"created_on" => $created_on,

				// 'packagediscountstate' => $this->input->post('packagediscountstate')?$this->input->post('packagediscountstate'):NULL,
				// 'service_package_user_total' => $this->input->post('service_package_user_total')?$this->input->post('service_package_user_total'):0,
				// 'service_package_total_discount_pct' => $this->input->post('service_package_total_discount_pct')?$this->input->post('service_package_total_discount_pct'):0,
				// 'service_package_total_discount' => $this->input->post('service_package_total_discount')?$this->input->post('service_package_total_discount'):0,
				'service_package_total_taxable' => $obj['total_amount']?$obj['total_amount']:0,
				'service_package_user_total' => $obj['total_amount']?$obj['total_amount']:0,
				//'service_package_total_gst_pct' => $obj['service_package_total_gst_pct'],
				//'service_package_total_gst' => $obj['service_package_total_gst'],
				'service_package_grand_total' => $obj['total_amount']?$obj['total_amount']:0,
				'total_taxable_amount' => $obj['total_amount']?$obj['total_amount']:0,
				//'overall_discount_amount' => $this->input->post('overall_discount_amount')?$this->input->post('overall_discount_amount'):0,
				//'total_tax_amount' => $this->input->post('total_tax_amount')?$this->input->post('total_tax_amount'):0,
				'grand_total' => $obj['total_amount']?$obj['total_amount']:0,
				'description' => $obj['description']?$obj['description']:NULL,
			);
			$ml_id = $this->db->insert('mech_leads', $db_array);
			
			$ml_id = $this->db->insert_id();

			foreach ($service_package_items as $service) {
				if (!empty($service['s_pack_id'])) {
					$service_array = array(
						'ml_id' => $ml_id,
						'is_from' => 'lead_package',
						'service_item' => $service['s_pack_id'],
						'item_service_name' => $service['package_name'],
						//'employee_id' => $service->employee_id,
						'user_item_price' => $service['price']?$service['price']:0,
						//'mech_item_price' => $service->mech_lbr_price?$service->mech_lbr_price:0,
						//'igst_pct' => $service->igst_pct?$service->igst_pct:0,
						//'igst_amount' => $service->igst_amount?$service->igst_amount:0,
						'item_total_amount' => $service['price']?$service['price']:0,
						'created_on' => date('Y-m-d H:i:s'),
						'created_by' => $obj['customer_id'],
						'modified_by' => $obj['customer_id'],
						'workshop_id' => $obj['workshop_id'],
						'w_branch_id' => $obj['w_branch_id']
					);
	
					if(isset($service['rs_item_id'])){
						$this->db->where('rs_item_id', $service['rs_item_id']);
						$service_id = $this->db->update('mech_leads_items', $service_array);
					}else{
						$service_id = $this->db->insert('mech_leads_items', $service_array);
					}
					
				} else {
					$this->load->library('form_validation');
					$this->form_validation->set_rules('service_name', trans('service'), 'required');
					$this->form_validation->run();
					
					$response = array(
						'success' => 0,
						'validation_errors' => array(
							'service_name' => form_error('service_name', '', ''),
						)
					);
				}
			}
			$response = array(
				'message' => 'success',
				'appointment_no' => $leads_no
			);
			
			echo json_encode($response);
			exit;
		}
	}

	public function appointmentview_post(){
		$json = file_get_contents('php://input');
		$obj = json_decode($json, TRUE);
		
		$workshop_id = $obj['workshop_id'];
		$branch_id = $obj['branch_id'];
		$customer_id = $obj['user_id'];
		$leads_no = $obj['leads_no'];
		$ml_id = $obj['ml_id'];
		$job_status = $obj['job_status'];
		$service_list = array();
		$service_package_list = array();
		$product_list = array();
		$upload_details = array();
		// if($job_status === 'WIP'){
		// 	$this->db->select('ml_id,ml.user_address_id,ml.branch_id,ml.w_branch_id,ml.customer_id,ml.user_car_list_id,ml.leads_no,ml.lead_date,ml.lead_status,ml.pickup,ml.grand_total,js.status_lable as status_label,wo.jobsheet_no');
		// 	$this->db->join('mech_work_order_dtls wo', 'wo.work_from="A" and wo.work_from_id=ml.ml_id', 'left');
		// 	$this->db->join('mech_jobcard_status js', 'js.jobcard_status_id=wo.jobsheet_status', 'left');
		// 	$app = $this->db->get_where('mech_leads ml', array('ml.workshop_id' => $workshop_id, 'ml.ml_id' => $ml_id, 'ml.customer_id' => $customer_id, 'ml.category_type' => 'A', 'ml.status' => 'A', 'ml.leads_no' => $leads_no));

		// 	$service_list = $this->mdl_mech_work_order_dtls->get_user_quote_service_item($work_order_id, $customer_id);
		// 	$service_package_list = $this->mdl_mech_work_order_dtls->get_user_quote_service_package_item($work_order_id, $customer_id);
		// 	$product_list = $this->mdl_mech_work_order_dtls->get_user_quote_product_item($work_order_id, $customer_id);
		// 	$upload_details = $this->db->select('*')->from('ip_uploads')->where('entity_type','J' )->where('entity_id', $workshop_id)->where('workshop_id', $workshop_id)->get()->result();
		// }else{
			$this->db->select('ml_id,ml.user_address_id,ml.branch_id,ml.w_branch_id,ml.customer_id,ml.user_car_list_id,ml.leads_no,ml.lead_date,ml.lead_status,ml.pickup,ml.grand_total,js.status_label as status_label,wo.jobsheet_no');
			$this->db->join('mech_work_order_dtls wo', 'wo.work_from="A" and wo.work_from_id=ml.ml_id', 'left');
			$this->db->join('mech_appointment_status js', 'js.mps_id=ml.lead_status', 'left');
			$app = $this->db->get_where('mech_leads ml', array('ml.workshop_id' => $workshop_id, 'ml.ml_id' => $ml_id, 'ml.customer_id' => $customer_id, 'ml.category_type' => 'A', 'ml.status' => 'A', 'ml.leads_no' => $leads_no));
			
			$this->db->select('service_item,item_service_name,user_item_price,item_total_amount');
			$app_item = $this->db->get_where('mech_leads_items mi', array('workshop_id' => $workshop_id, 'ml_id' => $ml_id, 'is_from' => 'lead_package'));
			$data_item = $app_item->result();
		// }
		$data_ary = $app->result();

		$this->db->select('w_branch_id,display_board_name,branch_contact_no,branch_street,branch_city,branch_state,branch_country,branch_pincode,cy.city_name,st.state_name,ct.name as country_name');
		$this->db->join('city_lookup cy', 'cy.city_id=br.branch_city', 'left');
		$this->db->join('mech_state_list st', 'st.state_id=br.branch_state', 'left');
		$this->db->join('country_lookup ct', 'ct.id=br.branch_country', 'left');
		$branch = $this->db->get_where('workshop_branch_details br', array('workshop_id' => $workshop_id, 'w_branch_id' => $branch_id, 'branch_status' => 'A'));
		$branch_data = $branch->row();
		

		$data = array(
			'message' => 'success',
			'appointmentlist' => $data_ary,
			'item_dtls' => $data_item,
			'service_list' => $service_list,
			'service_package_list' => $service_package_list,
			'product_list' => $product_list,
			'upload_details' => $upload_details,
			'service_centre' => $branch_data
		);
        echo json_encode($data); 
	}

}