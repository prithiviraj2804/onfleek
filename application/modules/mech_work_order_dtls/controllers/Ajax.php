<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true; 
	
	public function save_custom_service()
    {
		$data = array(
		    'service_item_name' => $this->input->post('service_item_name'),
		    'service_category_id' => '2',
		    'is_repair_diagnostics' => 2,
		    'workshop_id' => $this->session->userdata('work_shop_id'),
		    'w_branch_id' => $this->session->userdata('branch_id'),
		    'created_by' => $this->session->userdata('user_id'),
		    'created_on' => date('Y-m-d H:i:s'),
		    'sci_status' => 1
		);

		$this->db->insert('mechanic_service_category_items', $data);
		$id = $this->db->insert_id();
		$item_details = $this->db->get_where('mech_service_item_dtls', array('status' => 'A', 'msim_id' => $id))->result();
		echo json_encode($item_details);
    } 
    
	public function remove_added_service()
    {
    	$work_order_id = $this->input->post('work_order_id');
		$item_id = $this->input->post('item_id');
		
		$this->db->select('*');
        $this->db->from('mech_work_order_service_items mi');
        $this->db->where('mi.work_order_id',$work_order_id); 
		$this->db->where('mi.service_item',$item_id);           
        $query = $this->db->get()->row();
		
		$this->db->select('*');
        $this->db->from('mech_work_order_dtls mq');
        $this->db->where('mq.work_order_id',$work_order_id);         
        $query_quote = $this->db->get()->row();
		
		$price_data = array(
			'total_user_price' => $query_quote->total_user_price - $query->user_item_price,
			'total_mech_price' => $query_quote->total_mech_price - $query->mech_item_price,
			'total_labour_user_price' => $query_quote->total_labour_user_price - $query->user_item_labour_price,
			'total_labour_mech_price' => $query_quote->total_labour_mech_price - $query->mech_item_labour_price,
			'modified_by' => $this->session->userdata('user_id')
		);
		$this->db->where('work_order_id', $work_order_id);
		$this->db->update('mech_work_order_dtls', $price_data);
			
    	$this->db->where('service_item', $item_id);
		$this->db->where('work_order_id', $work_order_id);
   		$this->db->delete('mech_work_order_service_items'); 	
		$item_details = $this->db->get_where('mech_service_item_dtls', array('status' => 'A', 'msim_id' => $item_id))->result();
		echo json_encode($item_details);
    }

	public function get_category_items()
	{
		$this->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');
		$cat_id = $this->input->post('cat_id');
		$item_list = $this->db->get_where('mech_service_item_dtls', array('status' => 'A', 'service_category_id' => $cat_id))->result();
		$response = array(
                'cat_name' => $this->mdl_mech_work_order_dtls->get_service_category_name($cat_id),
                'item_list' => $item_list
            );
		echo json_encode($response);
	}

	public function get_category_item_details()
	{
		$this->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');
		$cat_id = $this->input->post('cat_id');
		$item_id = $this->input->post('item_id');
		$user_car_id = $this->input->post('user_car_id');

		$car_details = $this->db->get_where('mech_owner_car_list',array('car_list_id'=>$user_car_id))->row();

		$price_details = $this->db->get_where('mechanic_service_item_mapping',array('brand_id'=>$car_details->car_brand_id,'model_id'=>$car_details->car_brand_model_id,'fuel_type'=>$car_details->fuel_type,'service_item_id'=>$item_id))->result_array();

		$item_details = $this->db->get_where('mech_service_item_dtls', array('status' => 'A', 'msim_id' => $item_id))->result();
		
		
		$response = array(
                'cat_name' => $this->mdl_mech_work_order_dtls->get_service_category_name($cat_id),
                'item_details' => $item_details,
                'price_details' => $price_details
            );
		echo json_encode($response);
	}

	public function get_item_details()
	{
		$this->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');
		$item_id = $this->input->post('item_id');
		$item_details = $this->db->get_where('mech_service_item_dtls', array('status' => 'A', 'msim_id' => $item_id))->result();
		echo json_encode($item_details);
	}

	public function sendQuoteAppointmentsMail($type, $entity_id, $app_id = NULL)
	{
		$this->load->model('user_cars/mdl_user_cars');
		$this->load->model('users/mdl_users');
		$this->db->select('*');
        $this->db->from('mech_work_order_dtls mq');
        $this->db->where('mq.work_order_id',$entity_id);         
        $query = $this->db->get()->row(); 
		
		$this->db->select('*');
		$this->db->from('mech_work_order_service_items si');
		$this->db->join('mech_service_item_dtls ci', 'ci.msim_id = si.service_item');
		$this->db->where('work_order_id', $entity_id);
		$service_item_detail = $this->db->get()->result();

		$car_details = $this->mdl_user_cars->get_by_id($query->user_car_id);
		$user_email = 'kcsimbu@gmail.com'; //$this->mdl_users->get_user_detail_by_input($query->user_id, 'email_id');
		$subject = "Service estimate for your ". $car_details->brand_name." ".$car_details->model_name." ".$car_details->variant_name."( ".$car_details->car_reg_no." )";

		if($type == "quote"){
			$email_details = $this->load->view('emails/service_quote', array(
             		'name' => $this->mdl_users->get_user_detail_by_input($query->user_id, 'name'),
             		'user_car_reg_no' => $car_details->car_reg_no,
             		'user_car_name' => $car_details->brand_name." ".$car_details->model_name." ".$car_details->variant_name,
             		'booking_url' => '',
             		'service_list' => $service_item_detail
             ), true);
		}elseif($type == "appointment"){
			$email_details = $this->load->view('emails/service_app', array(
             		'name' => $this->mdl_users->get_user_detail_by_input($query->user_id, 'name'),
             		'user_car_reg_no' => $car_details->car_reg_no,
             		'user_car_name' => $car_details->brand_name." ".$car_details->model_name." ".$car_details->variant_name,
             		'track_url' => '',
             		'service_list' => $service_item_detail
             ), true);
		}
		$this->load->helper('mailer');
		
		$email_from = 'customerservice@' . preg_replace("/^[\w]{2,6}:\/\/([\w\d\.\-]+).*$/", "$1", base_url());
		$email_from_name = 'From: MechPoint <info@mechpoint.care>';
		// Mail the invoice with the pre-configured mailer if possible
		
		if (mailer_configured()) {
		$this->load->helper('mailer/phpmailer');
		
		if (!phpmail_send($email_from_name, $user_email, $subject, $email_details)) {
			$email_failed = true;
			log_message('error', $this->email->print_debugger());
		}
		
		} else {
		$this->load->library('email');
		
		// Set email configuration
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		
		// Set the email params
		$this->email->from($email_from_name);
		$this->email->to($user_email);
		$this->email->subject($subject);
		$this->email->message($email_details);
		
		// Send the reset email
		if (!$this->email->send()) {
			$email_failed = true;
			log_message('error', $this->email->print_debugger());
		}
		}
             // Redirect back to the login screen with an alert
             if (isset($email_failed)) {
             	//$this->session->set_flashdata('alert_error', trans('password_reset_failed'));
             	$account_active_message = trans('failed');
             } else {
             	//$this->session->set_flashdata('alert_success', trans('email_successfully_sent'));
             	$account_active_message = trans('email_successfully_sent');
             }
		$response = array(
			'success' => '1',
			'validation_errors' => $account_active_message
		);            			
		echo json_encode($response);
		
	}

	public function invoice_create()
	{

		// print_r($_REQUEST);
		
	    $mm_csrf = $this->input->post('_mm_csrf');
	    $book_type = $this->input->post('book_type');
		$work_order_id = $this->input->post('work_order_id');
		$work_order_status = $this->input->post('work_order_status');

		$service_items = json_decode($this->input->post('service_items'));
		$service_totals = json_decode($this->input->post('service_totals'));

		$service_package_items = json_decode($this->input->post('service_package_items'));
		$service_package_totals = json_decode($this->input->post('service_package_totals'));

		$product_items = json_decode($this->input->post('product_items'));
		$product_totals = json_decode($this->input->post('product_totals'));

		$work_from_id = $this->input->post('work_from_id');
		$work_from = $this->input->post('work_from');
		$jobsheet_status = $this->input->post('jobsheet_status');
		$next_service_dt = $this->input->post('next_service_dt')?date_to_mysql($this->input->post('next_service_dt')):date('d/m/Y');

		$checkinArray = json_decode($this->input->post('checkinArray'));
		
		$this->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');
		$this->load->model('mech_item_master/mdl_mech_item_master'); 
		$this->load->model('products/mdl_products');

		// if($this->input->post('jobsheet_no')){
		// 	$jobsheet_no = $this->input->post('jobsheet_no');
		// }else{
		// 	if($work_order_status == 'G'){
		// 		$group_no = $this->mdl_settings->getquote_book_no('job_card');
		// 		if($group_no == 0){
		// 			$response = array(
		// 				'success' => '2',
		// 				'validation_errors' => array(
		// 					'invoice_no' => 'empty',
		// 				)
		// 			);
		// 			echo json_encode($response);
		// 			exit;
		// 		}else{
		// 			$jobsheet_no = $this->mdl_settings->get_invoice_number($group_no);
		// 		}
		// 	}else{
		// 		$jobsheet_no = NULL;
		// 	}
		// }

		if($this->input->post('jobsheet_no')){
			$jobsheet_no = $this->input->post('jobsheet_no');
		}else{
			if($work_order_status == 'G'){
				$jobsheet_no = $this->mdl_settings->get_invoice_number($this->input->post('invoice_group_id'));
			}else{
				$jobsheet_no = NULL;
			}
		}

		$data = array();
		if ($this->mdl_mech_work_order_dtls->run_validation()) {
			
			$work_order_id = $this->mdl_mech_work_order_dtls->save($work_order_id);
			
			$total_update = array(
				'start_date' => $this->input->post('start_date')?date("Y-m-d h:i:s", strtotime($this->input->post('start_date'))):NULL,
				'end_date' => $this->input->post('end_date')?date("Y-m-d h:i:s", strtotime($this->input->post('end_date'))):NULL,
				'jobsheet_no' => $jobsheet_no,
				'job_terms_condition' => $this->input->post('job_terms_condition')?strip_tags($this->input->post('job_terms_condition')):NULL,
				'work_order_status' => $work_order_status,
				'work_from_id' => $this->input->post('work_from_id'),
				'work_from' => $this->input->post('work_from'),
				'invoice_number' => strip_tags($this->input->post('invoice_number')),
				'product_user_total' => $this->input->post('product_user_total')?$this->input->post('product_user_total'):0,
				'product_total_discount' => $this->input->post('product_total_discount')?$this->input->post('product_total_discount'):0,
			    'product_total_taxable' => $this->input->post('product_total_taxable')?$this->input->post('product_total_taxable'):0,
				'product_total_gst' => $this->input->post('product_total_gst')?$this->input->post('product_total_gst'):0,
				'product_grand_total' => $this->input->post('product_grand_total')?$this->input->post('product_grand_total'):0,

				'parts_discountstate' => $this->input->post('parts_discountstate')?strip_tags($this->input->post('parts_discountstate')):NULL,
				'service_discountstate' => $this->input->post('service_discountstate')?strip_tags($this->input->post('service_discountstate')):NULL,
				'service_user_total' => $this->input->post('service_user_total')?$this->input->post('service_user_total'):0,
				'service_total_discount_pct' => $this->input->post('service_total_discount_pct')?$this->input->post('service_total_discount_pct'):0,
				'service_total_discount' => $this->input->post('service_total_discount')?$this->input->post('service_total_discount'):0,
				'service_total_taxable' => $this->input->post('service_total_taxable')?$this->input->post('service_total_taxable'):0,
				'service_total_gst_pct' => $this->input->post('service_total_gst_pct')?$this->input->post('service_total_gst_pct'):0,
				'service_total_gst' => $this->input->post('service_total_gst')?$this->input->post('service_total_gst'):0,
				'service_grand_total' => $this->input->post('service_grand_total')?$this->input->post('service_grand_total'):0,

				'packagediscountstate' => $this->input->post('packagediscountstate')?$this->input->post('packagediscountstate'):NULL,
				'service_package_user_total' => $this->input->post('service_package_user_total')?$this->input->post('service_package_user_total'):0,
				'service_package_total_discount_pct' => $this->input->post('service_package_total_discount_pct')?$this->input->post('service_package_total_discount_pct'):0,
				'service_package_total_discount' => $this->input->post('service_package_total_discount')?$this->input->post('service_package_total_discount'):0,
				'service_package_total_taxable' => $this->input->post('service_package_total_taxable')?$this->input->post('service_package_total_taxable'):0,
				'service_package_total_gst_pct' => $this->input->post('service_package_total_gst_pct')?$this->input->post('service_package_total_gst_pct'):0,
				'service_package_total_gst' => $this->input->post('service_package_total_gst')?$this->input->post('service_package_total_gst'):0,
				'service_package_grand_total' => $this->input->post('service_package_grand_total')?$this->input->post('service_package_grand_total'):0,
				'service_package_mech_total' => $service_package_totals[0]->total_mech_lbr_price?$service_package_totals[0]->total_mech_lbr_price:0,

				'total_taxable_amount' => $this->input->post('total_taxable_amount')?$this->input->post('total_taxable_amount'):0,
				'overall_discount_amount' => $this->input->post('overall_discount_amount')?$this->input->post('overall_discount_amount'):0,
				'total_tax_amount' => $this->input->post('total_tax_amount')?$this->input->post('total_tax_amount'):0,
				'grand_total' => $this->input->post('grand_total')?$this->input->post('grand_total'):0,
				'total_due_amount' => (($this->input->post('grand_total')?$this->input->post('grand_total'):0) - $total_paid_amount),
				'description' => strip_tags($this->input->post('description')),
				'next_service_dt' => $this->input->post('next_service_dt')?date_to_mysql($this->input->post('next_service_dt')):date('d/m/Y'),
				'service_mech_total' => $service_totals[0]->total_mech_lbr_price?$service_totals[0]->total_mech_lbr_price:0,
				'product_mech_total' => $product_totals[0]->total_mech_lbr_price?$product_totals[0]->total_mech_lbr_price:0,
			);
			$this->db->where('work_order_id', $work_order_id);
			$this->db->update('mech_work_order_dtls', $total_update);
			
			if(count($checkinArray) > 0){
			    
			    $this->db->where('work_order_id', $work_order_id);
			    $this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
			    $this->db->delete('mech_vehicle_checkin_dtls');
			    
			    foreach ($checkinArray as $checkin) {
			        if(!empty($checkin->checkin_count)){
			            $checkinListArray = array(
			                'work_order_id' => $work_order_id,
			                'checkin_prod_id' => $checkin->checkin_prod_id,
			                'checkin_count' => $checkin->checkin_count,
			                'created_on' => date('Y-m-d H:i:s'),
			                'created_by' => $this->session->userdata('user_id'),
			                'modified_by' => $this->session->userdata('user_id'),
			                'workshop_id' => $this->session->userdata('work_shop_id'),
			                'w_branch_id' => $this->session->userdata('branch_id')
			            );
			            $checkin_id = $this->db->insert('mech_vehicle_checkin_dtls', $checkinListArray);
			        }
			    }
			}
			
			if($this->input->post('serviceCheckBox') == 1){
				$service_remainder = array(
					'work_order_id' => $work_order_id,
					'customer_id' => $this->input->post('customer_id'),
					'service_vehicle_id' => $this->input->post('customer_car_id'),
					'serviceCheckBox' => $this->input->post('serviceCheckBox'),
					'next_service_km' => $this->input->post('next_service_km'),
					'next_service_date' => $this->input->post('next_service_date')?date_to_mysql($this->input->post('next_service_date')):NULL,
					'created_on' => date('Y-m-d H:i:s'),
					'created_by' => $this->session->userdata('user_id'),
					'modified_by' => $this->session->userdata('user_id'),
					'workshop_id' => $this->session->userdata('work_shop_id'),
					'w_branch_id' => $this->session->userdata('branch_id')
				);
				
				if($this->input->post('service_remainder_id')){
					$this->db->where('service_remainder_id', $this->input->post('service_remainder_id'));
					$this->db->update('mech_service_remainder', $service_remainder);
				}else{
					$this->db->insert('mech_service_remainder', $service_remainder);
				}
			}else{
				$this->db->where('work_order_id' , $work_order_id);
				$this->db->delete('mech_service_remainder');
			}
			

			if($this->input->post('insuranceCheckBox') == 1){
				$insurance_remainder = array(
					'work_order_id' => $work_order_id,
					'customer_id' => $this->input->post('customer_id'),
					'vehicle_id' => $this->input->post('customer_car_id'),
					'policy_number' => $this->input->post('policy_number'),
					'insuranceCheckBox' => $this->input->post('insuranceCheckBox'),
					'policy_number' => $this->input->post('policy_number'),
					'next_service_ins_date' => $this->input->post('next_service_ins_date')?date_to_mysql($this->input->post('next_service_ins_date')):NULL,
					'ins_company_name' => $this->input->post('ins_company_name'),
					'job_type' => $this->input->post('job_type'),
					'created_on' => date('Y-m-d H:i:s'),
					'created_by' => $this->session->userdata('user_id'),
					'modified_by' => $this->session->userdata('user_id'),
					'workshop_id' => $this->session->userdata('work_shop_id'),
					'w_branch_id' => $this->session->userdata('branch_id')
				);
				
				if($this->input->post('service_insurance_id')){
					$this->db->where('service_insurance_id', $this->input->post('service_insurance_id'));
					$this->db->update('mech_insurance_remainder', $insurance_remainder);
				}else{
					$this->db->insert('mech_insurance_remainder', $insurance_remainder);
				}
			}else{
				$this->db->where('work_order_id' , $work_order_id);
				$this->db->delete('mech_insurance_remainder');
			}
			
			
			if($this->input->post('insuranceBillingCheckBox') == 1){
				$this->load->model('mech_insurance/mdl_mech_insurance_billing');
				$_POST['entity_id'] = $work_order_id;
				$_POST['entity_type'] = 'J';
				if ($this->mdl_mech_insurance_billing->run_validation()) {
					$mins_id = $this->mdl_mech_insurance_billing->save($this->input->post('mins_id'));				
				}else{
					$this->load->helper('json_error');
					$response = array(
						'success' => 0,
						'validation_errors' => json_errors()
					);
					echo json_encode($response);
				}
			}
			
			$upload_array = array(
			    'entity_id' =>  $work_order_id
			);
			
			if($this->input->post('uploadCheckBox') == 1 || $this->input->post('uploadCheckBox') == '1'){
			    $this->db->where('url_key', $this->input->post('url_key'));
			    $this->db->update('ip_uploads', $upload_array);
			}

			foreach ($service_items as $service) {
				if (!empty($service->item_service_id)) {
					$service_array = array(
						'work_order_id' => $work_order_id,
						'user_id' => $this->input->post('customer_id'),
						'user_car_id' => $this->input->post('customer_car_id'),
						'employee_id' => $service->employee_id,
						'is_from' => 'work_order_service',
						'service_item' => $service->item_service_id,
						'item_service_name' => $service->item_service_name?$service->item_service_name:NULL,
						'user_item_price' => $service->usr_lbr_price?$service->usr_lbr_price:0,
						'mech_item_price' => $service->mech_lbr_price?$service->mech_lbr_price:0,
						'item_discount' => $service->item_discount?$service->item_discount:0,
						'item_amount' => $service->item_amount?$service->item_amount:0,
						'item_discount_price' => $service->item_discount_price?$service->item_discount_price:0,
						'tax_id' => $service->gst_service?$service->gst_service:0,
						'item_hsn' => $service->item_hsn?$service->item_hsn:0,
						'igst_pct' => $service->igst_pct?$service->igst_pct:0,
						'igst_amount' => $service->igst_amount?$service->igst_amount:0,
						'item_total_amount' => $service->item_total_amount?$service->item_total_amount:0,
						'created_on' => date('Y-m-d H:i:s'),
						'created_by' => $this->session->userdata('user_id'),
						'modified_by' => $this->session->userdata('user_id'),
						'workshop_id' => $this->session->userdata('work_shop_id'),
						'w_branch_id' => $this->session->userdata('branch_id')
					);
					if(isset($service->rs_item_id)){
						$this->db->where('rs_item_id', $service->rs_item_id);
						$service_id = $this->db->update('mech_work_order_service_items', $service_array);
					}else{
						$service_id = $this->db->insert('mech_work_order_service_items', $service_array);
					}
					
				}else {
					// Throw an error message and use the form validation for that
					$this->load->library('form_validation');
					$this->form_validation->set_rules('service_name', trans('service'), 'required');
					$this->form_validation->run();
					
					$response = array(
						'success' => 0,
						'validation_errors' => array(
							'service_name' => form_error('service_name', '', ''),
						)
					);
					
					echo json_encode($response);
					exit;
				}
			}

			foreach ($service_package_items as $service) {
				if (!empty($service->item_service_id)) {
					$service_array = array(
						'work_order_id' => $work_order_id,
						'user_id' => $this->input->post('customer_id'),
						'user_car_id' => $this->input->post('customer_car_id'),
						'employee_id' => $service->employee_id,
						'is_from' => 'work_order_package',
						'service_item' => $service->item_service_id,
						'item_service_name' => $service->item_service_name?$service->item_service_name:NULL,
						'user_item_price' => $service->usr_lbr_price?$service->usr_lbr_price:0,
						'mech_item_price' => $service->mech_lbr_price?$service->mech_lbr_price:0,
						'item_discount' => $service->item_discount?$service->item_discount:0,
						'item_discount_price' => $service->item_discount_price?$service->item_discount_price:0,
						'igst_pct' => $service->igst_pct?$service->igst_pct:0,
						'igst_amount' => $service->igst_amount?$service->igst_amount:0,
						'item_total_amount' => $service->item_total_amount?$service->item_total_amount:0,
						'created_on' => date('Y-m-d H:i:s'),
						'created_by' => $this->session->userdata('user_id'),
						'modified_by' => $this->session->userdata('user_id'),
						'workshop_id' => $this->session->userdata('work_shop_id'),
						'w_branch_id' => $this->session->userdata('branch_id')
					);
					if(isset($service->rs_item_id)){
						$this->db->where('rs_item_id', $service->rs_item_id);
						$service_id = $this->db->update('mech_work_order_service_items', $service_array);
					}else{
						$service_id = $this->db->insert('mech_work_order_service_items', $service_array);
					}
					
				}else {
					// Throw an error message and use the form validation for that
					$this->load->library('form_validation');
					$this->form_validation->set_rules('service_name', trans('service'), 'required');
					$this->form_validation->run();
					
					$response = array(
						'success' => 0,
						'validation_errors' => array(
							'service_name' => form_error('service_name', '', ''),
						)
					);
					
					echo json_encode($response);
					exit;
				}
			}

			foreach ($product_items as $product) {
				if (!empty($product->item_product_id)) {
					$product_array = array(
						'work_order_id' => $work_order_id,
						'user_id' => $this->input->post('customer_id'),
						'user_car_id' => $this->input->post('customer_car_id'),
						'is_from' => 'work_order_product',
						'service_item' => $product->item_product_id,
						'item_service_name' => $product->item_product_name,
						'tax_id' => $product->gst_spare?$product->gst_spare:0,
						'item_hsn' => $product->item_hsn?$product->item_hsn:0,
						'user_item_price' => $product->usr_lbr_price?$product->usr_lbr_price:0,
						'mech_item_price' => $product->mech_lbr_price?$product->mech_lbr_price:0,
						'item_qty' => $product->product_qty?$product->product_qty:0,
						'item_discount' => $product->item_discount?$product->item_discount:0,
						'item_discount_price' => $product->item_discount_price?$product->item_discount_price:0,
						'item_amount' => $product->item_amount?$product->item_amount:0,
						'igst_pct' => $product->igst_pct?$product->igst_pct:0,
						'igst_amount' => $product->igst_amount?$product->igst_amount:0,
						'item_total_amount' => $product->item_total_amount?$product->item_total_amount:0,
						'created_on' => date('Y-m-d H:i:s'),
						'created_by' => $this->session->userdata('user_id'),
						'modified_by' => $this->session->userdata('user_id'),
						'workshop_id' => $this->session->userdata('work_shop_id'),
						'w_branch_id' => $this->session->userdata('branch_id')
					);
					
					if(isset($product->rs_item_id)){
						$this->db->where('rs_item_id', $product->rs_item_id);
						$this->db->update('mech_work_order_service_items', $product_array);
					}else{
						$product_id = $this->db->insert('mech_work_order_service_items', $product_array);
					}
				}else {
					// Throw an error message and use the form validation for that
					$this->load->library('form_validation');
					$this->form_validation->set_rules('product_name', trans('product'), 'required');
					$this->form_validation->run();
					
					$response = array(
						'success' => 0,
						'validation_errors' => array(
							'product_name' => form_error('product_name', '', ''),
						)
					);
					
					echo json_encode($response);
					exit;
				}
				
			}

			if($this->input->post('customer_id')){
				$this->db->select("client_name,client_email_id,client_contact_no,is_new_customer");	
				$this->db->from('mech_clients');
				$this->db->where('client_id', $this->input->post('customer_id'));
				$this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
				$client_details = $this->db->get()->row();
				if($client_details->is_new_customer == "Y"){
					$rewards_id = $this->mdl_settings->calculate_referral_points($customer_id);
				}			
			}

			if($this->input->post('jobsheet_status') != $this->input->post('ex_jobsheet_status')){
				if($this->input->post('jobsheet_status') == 'Y' && $this->session->userdata('open_J_S') == 1){
					$txt = "Hi ".$client_details->client_name.", your Job card has been raised.";
				}else if($this->input->post('jobsheet_status') == 'P' && $this->session->userdata('pending_J_S') == 1){
					$txt = "Way to go!!!! Your car service has started... Keep track of your car servicing with regular updates..";
				}else if($this->input->post('jobsheet_status') == 'C' && $this->session->userdata('completed_J_S') == 1){
					$txt = "Job well done.. Your car service is successfully completed. Your service amount is Rs. ".$this->input->post('grand_total');
				}else if($this->input->post('jobsheet_status') == 'RA' && $this->session->userdata('reopen_J_S') == 1){
					$txt = $client_details->client_name."Job card has been raised";
				}else{
					$txt = $client_details->client_name."Job card has been raised";
				}

				if(!empty($client_details->client_contact_no)){
					// $sms = send_sms(htmlspecialchars($client_details->client_contact_no),$txt);
					if($sms->status == "success"){
			            $db_sms_array = array(
			                'user_id' => $this->session->userdata('user_id'),
			                'name' => $client_details->client_name,
			                'email_id' => $client_details->client_email_id,
			                'mobile_number' => $client_details->client_contact_no,
			                'message' => $txt,
							'type' => 3,
							'response' => json_encode($sms),
			                'status' => 'S',
			                'created_on' => date('Y-m-d H:m:s')
			            ); 
			        }else{
			            $db_sms_array = array(
			                'user_id' => $this->session->userdata('user_id'),
			                'name' => $client_details->client_name,
			                'email_id' => $client_details->client_email_id,
			                'mobile_number' => $client_details->client_contact_no,
			                'message' => $txt,
							'type' => 3,
							'response' => json_encode($sms),
			                'status' => 'F',
			                'created_on' => date('Y-m-d H:m:s')
			            ); 
			        }
			        $this->db->insert('tc_sms_log', $db_sms_array);
			    }
			}
			// convert_invoice
			if($this->input->post('convert_invoice') == 'Y'){
			  $invoice_id = $this->convert_to_invoice($work_order_id, $jobsheet_status, $jobsheet_no,$next_service_dt);
			}

            $response = array(
                'success' => 1,
                'work_order_id' => $work_order_id,
				'invoice_id'	=> $invoice_id,
			);

			if($jobsheet_status == 3){
				$this->db->set('lead_status',7);
				// $this->db->set('status' , 'D');
				$this->db->where('ml_id', $work_from_id);
				$this->db->where('category_type', $work_from);
				$this->db->update('mech_leads');
			}
			
        } else {
			
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
        }

        echo json_encode($response);				
	}

	public function invoice_save()
	{
		$work_order_id = $this->input->post('work_order_id');
		$user_id = $this->input->post('user_id');
		$car_brand_id = $this->input->post('car_brand_id');
		$car_brand_model_id = $this->input->post('car_brand_model_id');
		$brand_model_variant_id = $this->input->post('brand_model_variant_id');
		$mm_csrf = $this->input->post('_mm_csrf');
		$product_items = json_decode($this->input->post('product_items'));
		$service_items = json_decode($this->input->post('service_items'));
		
		if($work_order_id){
			
			$product_totals =  (object) json_decode($this->input->post('product_totals'),TRUE)[0];
			$service_totals =  (object) json_decode($this->input->post('service_totals'),TRUE)[0];

			$this->db->select_sum('payment_amount');
        	$payments = $this->db->get_where("mech_payments",array('entity_id'=>$work_order_id, 'entity_type' => 'jobcard'))->row();

			$total_update = array(
				'service_user_total' => $service_totals->total_usr_lbr_price?$service_totals->total_usr_lbr_price:0,
				'service_mech_total' => $service_totals->total_mech_lbr_price?$service_totals->total_mech_lbr_price:0,
				'service_total_discount' => $this->input->post('service_total_discount')?$this->input->post('service_total_discount'):0,
				'service_total_discount_pct' => $this->input->post('service_discount_pct')?$this->input->post('service_discount_pct'):0,
				'service_total_taxable' => $this->input->post('service_total_taxable')?$this->input->post('service_total_taxable'):0,
				'service_total_gst_pct' => $this->input->post('service_tax_pct')?$this->input->post('service_tax_pct'):0,
				'service_total_gst' => $this->input->post('total_servie_gst_price')?$this->input->post('total_servie_gst_price'):0,
				'service_grand_total' => $this->input->post('total_service_amount')?$this->input->post('total_service_amount'):0,
				'product_user_total' => $product_totals->total_usr_lbr_price?$product_totals->total_usr_lbr_price:0,
				'product_mech_total' => $product_totals->total_mech_lbr_price?$product_totals->total_mech_lbr_price:0,
				'product_total_discount' => $product_totals->total_item_discount?$product_totals->total_item_discount:0,
				'product_total_taxable' => $this->input->post('product_total_taxable')?$this->input->post('product_total_taxable'):0,
				'product_total_gst' => ($product_totals->total_igst_amount) + ($product_totals->total_cgst_amount) + ($product_totals->total_sgst_amount),
				'product_grand_total' => $product_totals->total_item_total_amount?$product_totals->total_item_total_amount:0,
				'total_taxable_amount' => $this->input->post('total_taxable_amount')?$this->input->post('total_taxable_amount'):0,
				'total_tax_amount' => $this->input->post('total_tax_amount')?$this->input->post('total_tax_amount'):0,
				'appointment_grand_total'=> $this->input->post('appointment_grand_total')?$this->input->post('appointment_grand_total'):0,
				'total_due_amount' => ($this->input->post('total_due_amount')?$this->input->post('total_due_amount'):0) - $payments->payment_amount,
				//'request_admin_update' => $this->input->post('userrequpdate')
			);
			$this->db->where('work_order_id', $work_order_id);
			$this->db->update('mech_work_order_dtls', $total_update);

		}
	
		foreach($service_items as $service) {
			if(!empty($service->item_service_id)) {
				$service_array = array(
					'work_order_id'=>$work_order_id,
					'user_id'=>$user_id,
					'user_car_id'=>$car_brand_id,
					'car_brand_model_id'=>$car_brand_model_id,
					'brand_model_variant_id'=>$brand_model_variant_id,
					'is_from'=>'work_order_service',
					'service_item'=>$service->item_service_id,
					'item_service_name'=>$service->item_service_name?$service->item_service_name:NULL,
					'user_item_price'=> $service->usr_lbr_price?$service->usr_lbr_price:0,
					'mech_item_price'=> $service->mech_lbr_price?$service->mech_lbr_price:0,
					'item_discount'=> $service->item_discount?$service->item_discount:0,
					'igst_pct'=> $service->igst_pct?$service->igst_pct:0,
					'igst_amount'=> $service->igst_amount?$service->igst_amount:0,
					'item_total_amount'=> $service->item_total_amount?$service->item_total_amount:0,
					'created_on'=>date('Y-m-d H:i:s'),
					'created_by'=>$this->session->userdata('user_id'),
					'modified_by'=>$this->session->userdata('user_id'),
					'workshop_id' => $this->session->userdata('work_shop_id'),
					'w_branch_id' => $this->session->userdata('branch_id')
				);
				if(isset($service->rs_item_id)){
					$this->db->where('rs_item_id', $service->rs_item_id);
					$service_id = $this->db->update('mech_work_order_service_items', $service_array);
				}else{
					$service_id = $this->db->insert('mech_work_order_service_items', $service_array);
				}
			
			}else {
                    // Throw an error message and use the form validation for that
                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('item_name', trans('item'), 'required');
                    $this->form_validation->run();

                    $response = array(
                        'success' => 0,
                        'validation_errors' => array(
                            'item_name' => form_error('item_name', '', ''),
                        )
                    );

                    echo json_encode($response);
                    exit;
                }
		}

		foreach ($product_items as $product) {
			if (!empty($product->item_product_id)) {
				$product_array = array(
					'work_order_id'=>$work_order_id,
					'user_id'=>$user_id,
					'user_car_id'=>$car_brand_id,
					'car_brand_model_id'=>$car_brand_model_id,
					'brand_model_variant_id'=>$brand_model_variant_id,
					'is_from'=>'work_order_product',
					'service_item'=>$product->item_product_id,
					'item_service_name'=> $service->item_product_name?$service->item_product_name:NULL,
					'user_item_price'=> $product->usr_lbr_price?$product->usr_lbr_price:0,
					'mech_item_price'=> $product->mech_lbr_price?$product->mech_lbr_price:0,
					'item_qty'=> $product->product_qty,
					'item_discount'=> $product->item_discount?$product->item_discount:0,
					'igst_pct'=> $product->igst_pct?$product->igst_pct:0,
					'igst_amount'=> $product->igst_amount?$product->igst_amount:0,
					'item_total_amount'=> $product->item_total_amount?$product->item_total_amount:0,
					'created_on'=>date('Y-m-d H:i:s'),
					'created_by'=>$this->session->userdata('user_id'),
					'modified_by'=>$this->session->userdata('user_id'),
					'workshop_id' => $this->session->userdata('work_shop_id'),
					'w_branch_id' => $this->session->userdata('branch_id')
				);
				if(isset($product->rs_item_id)){
					$this->db->where('rs_item_id', $product->rs_item_id);
					$product_id = $this->db->update('mech_work_order_service_items', $product_array);
				}else{
					$product_id = $this->db->insert('mech_work_order_service_items', $product_array);
				}
			}else {
					// Throw an error message and use the form validation for that
				$this->load->library('form_validation');
				$this->form_validation->set_rules('item_name', trans('item'), 'required');
				$this->form_validation->run();

				$response = array(
					'success' => 0,
					'validation_errors' => array(
						'item_name' => form_error('item_name', '', ''),
					)
				);

				echo json_encode($response);
				exit;
			}
		}

		if($work_order_id){
			$response = array(
				'success' => 1
			);
		}else{
			$response = array(
				'success' => 0
			);
		}

		echo json_encode($response);
		exit();
	}

    public function delete_item(){
        $item_id = $this->input->post('item_id');
        $this->db->where('rs_item_id', $item_id);
        $this->db->delete('mech_work_order_service_items');
        $response = array(
            'success' => 1
        );
        echo json_encode($response);
    }
    
    public function getCheckInList(){
        
        $checkIn_id = $this->input->post('checkIn_id');
        $checkIn_list = array();
        
        for($i = 0; $i < count($checkIn_id); $i++){
            $checkDetail = $this->db->get_where('vehicle_checkin_lookup',array('checkin_prod_id'=>$checkIn_id[$i]))->row();
            array_push($checkIn_list,$checkDetail);
        }
        
        if(count($checkIn_list) > 0){
            $response = array(
                'success' => 1,
                'checkIn_list' => $checkIn_list
            );
        }else{
            $response = array(
                'success' => 0,
                'checkIn_list' => ''
            );
		}
		echo json_encode($response);
		
	}
	
	public function get_filter_list(){

		$this->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');

        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
		$limit = 15;		
        if($this->input->post('from_date')){
            $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.issue_date >=', date_to_mysql($this->input->post('from_date')));
        }

        if($this->input->post('to_date')){
            $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.issue_date <=', date_to_mysql($this->input->post('to_date')));
        }

        if($this->input->post('jobsheet_no')){
            $this->mdl_mech_work_order_dtls->like('mech_work_order_dtls.jobsheet_no', trim($this->input->post('jobsheet_no')));
        }

        if($this->input->post('invoice_number')){
            $this->mdl_mech_work_order_dtls->like('mech_work_order_dtls.invoice_number', trim($this->input->post('invoice_number')));
        }

		if($this->input->post('vehicle_no')){
            $this->mdl_mech_work_order_dtls->like('car.car_reg_no', trim($this->input->post('vehicle_no')));
        }

        if($this->input->post('customer_id')){
            $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.customer_id', trim($this->input->post('customer_id')));
        }

        if($this->input->post('jobsheet_status')){
            $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.jobsheet_status', trim($this->input->post('jobsheet_status')));
        }

        if($this->input->post('branch_id')){
            $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.branch_id', trim($this->input->post('branch_id')));
        }

		$this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.jobsheet_status != ', 'C'); 
        $rowCount = $this->mdl_mech_work_order_dtls->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        if($this->input->post('from_date')){
            $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.issue_date >=', date_to_mysql($this->input->post('from_date')));
        }

        if($this->input->post('to_date')){
            $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.issue_date <=', date_to_mysql($this->input->post('to_date')));
        }

        if($this->input->post('jobsheet_no')){
            $this->mdl_mech_work_order_dtls->like('mech_work_order_dtls.jobsheet_no', trim($this->input->post('jobsheet_no')));
        }

        if($this->input->post('invoice_number')){
            $this->mdl_mech_work_order_dtls->like('mech_work_order_dtls.invoice_number', trim($this->input->post('invoice_number')));
        }

        if($this->input->post('customer_id')){
            $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.customer_id', trim($this->input->post('customer_id')));
        }

        if($this->input->post('jobsheet_status')){
			$this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.jobsheet_status', trim($this->input->post('jobsheet_status')));
        }

		if($this->input->post('vehicle_no')){
            $this->mdl_mech_work_order_dtls->like('car.car_reg_no', trim($this->input->post('vehicle_no')));
        }

        if($this->input->post('branch_id')){
            $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.branch_id', trim($this->input->post('branch_id')));
		}
		
		$this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.jobsheet_status != ', 'C'); 
        $this->mdl_mech_work_order_dtls->limit($limit,$start);
        $work_orders = $this->mdl_mech_work_order_dtls->get()->result();           

        $response = array(
            'success' => 1,
            'work_orders' => $work_orders, 
			'createLinks' => $createLinks,
			'job_card_E' => $this->session->userdata('job_card_E'),
        );
        echo json_encode($response);
	}
	
	public function get_completed_filter_list(){

		$this->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');

        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;
        if($this->input->post('from_date')){
            $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.issue_date >=', date_to_mysql($this->input->post('from_date')));
        }

        if($this->input->post('to_date')){
            $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.issue_date <=', date_to_mysql($this->input->post('to_date')));
        }

        if($this->input->post('jobsheet_no')){
            $this->mdl_mech_work_order_dtls->like('mech_work_order_dtls.jobsheet_no', trim($this->input->post('jobsheet_no')));
        }

        if($this->input->post('invoice_number')){
            $this->mdl_mech_work_order_dtls->like('mech_work_order_dtls.invoice_number', trim($this->input->post('invoice_number')));
        }

        if($this->input->post('customer_id')){
            $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.customer_id', trim($this->input->post('customer_id')));
        }

        if($this->input->post('branch_id')){
            $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.branch_id', trim($this->input->post('branch_id')));
        }

		if($this->input->post('jobsheet_status') == 'C'){
			$this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.work_order_status', 'G');
			$this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.jobsheet_status', 'C');
		}

        $rowCount = $this->mdl_mech_work_order_dtls->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        if($this->input->post('from_date')){
            $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.issue_date >=', date_to_mysql($this->input->post('from_date')));
        }

        if($this->input->post('to_date')){
            $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.issue_date <=', date_to_mysql($this->input->post('to_date')));
        }

        if($this->input->post('jobsheet_no')){
            $this->mdl_mech_work_order_dtls->like('mech_work_order_dtls.jobsheet_no', trim($this->input->post('jobsheet_no')));
        }

        if($this->input->post('invoice_number')){
            $this->mdl_mech_work_order_dtls->like('mech_work_order_dtls.invoice_number', trim($this->input->post('invoice_number')));
        }

        if($this->input->post('customer_id')){
            $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.customer_id', trim($this->input->post('customer_id')));
        }

        if($this->input->post('branch_id')){
            $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.branch_id', trim($this->input->post('branch_id')));
		}
		
		if($this->input->post('jobsheet_status') == 'C'){
			$this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.work_order_status', 'G');
			$this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.jobsheet_status', 'C');
		}
		
        $this->mdl_mech_work_order_dtls->limit($limit,$start);
        $work_orders = $this->mdl_mech_work_order_dtls->get()->result();           

        $response = array(
            'success' => 1,
            'work_orders' => $work_orders, 
			'createLinks' => $createLinks,
			'job_card_E' => $this->session->userdata('job_card_E'),
        );
        echo json_encode($response);
    }

	public function convert_to_invoice($work_order_id = NULL,$jobsheet_status = NULL,$jobsheet_no = NULL,$next_service_dt = NULL)
    {

		$this->load->model('mech_invoices/mdl_mech_invoice');
		$this->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');
		
        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');

        if($work_order_id){
            if($jobsheet_status == 3){
                $_POST['jobsheet_status'] = 3;
            }
            $work_order_details = $this->mdl_mech_work_order_dtls->where('work_order_id', $work_order_id)->get()->row();
            $service_items = $this->mdl_mech_work_order_dtls->get_user_quote_service_item($work_order_id, $work_order_details->customer_id);
            $service_package_items  = $this->mdl_mech_work_order_dtls->get_user_quote_service_package_item($work_order_id, $work_order_details->customer_id);
            $products_items = $this->mdl_mech_work_order_dtls->get_user_quote_product_item($work_order_id, $work_order_details->customer_id);
            $comments = $this->db->select('mech_comments.comment_id, mech_comments.workshop_id, mech_comments.w_branch_id, mech_comments.entity_id, mech_comments.entity_type, mech_comments.modified_employee_id,mech_comments.comments,mech_comments.reschedule,mech_comments.reschedule_date,mech_comments.created_on,mech_employee.employee_name')->from('mech_comments')->where('mech_comments.entity_id',$ml_id)->where('mech_comments.entity_type','A')->where('mech_comments.status','A')->join('mech_employee', 'mech_employee.employee_id = mech_comments.modified_employee_id')->order_by("mech_comments.comment_id","desc")->get()->result();
            $appointment = $this->db->get_where('mech_lead_appointment', array('status' => 'A','entity_type' => 'L','entity_id' => $ml_id))->result();
        }
		if($work_order_details->branch_id != ''){
			$terms_condition = $this->db->select('invoice_description')->from('workshop_branch_details')->where('workshop_id ',$work_shop_id)->where('w_branch_id',$work_order_details->branch_id)->get()->row()->invoice_description;
		} 

        $data = array(
            'invoice_category' => 'I', 
            'branch_id' => $work_order_details->branch_id?$work_order_details->branch_id:NULL,
            'work_from' => 'J',
            'work_from_id' => $work_order_id,
			'jobsheet_no' => $jobsheet_no,
			'next_service_dt' => $next_service_dt,
			'invoice_terms_condition' => $terms_condition,
			'refered_by_type' => $work_order_details->refered_by_type,
			'refered_by_id' => $work_order_details->refered_by_id,
            'workshop_id' => $work_shop_id,
            'w_branch_id' => $work_order_details->branch_id?$work_order_details->branch_id:NULL,
            'invoice_date' => date('Y-m-d'),
            'customer_id' => $work_order_details->customer_id,
            'customer_car_id' => $work_order_details->user_car_list_id,
            'user_address_id' => $work_order_details->user_address_id,
            'visit_type' => 'W',
            'parts_discountstate' => $work_order_details->parts_discountstate?$work_order_details->parts_discountstate:"",
            'service_discountstate' => $work_order_details->service_discountstate?$work_order_details->service_discountstate:"",
            'service_user_total' => $work_order_details->service_user_total?$work_order_details->service_user_total:0,
            'service_mech_total' => $work_order_details->service_mech_total?$work_order_details->service_mech_total:0,
            'service_total_discount' => $work_order_details->service_total_discount?$work_order_details->service_total_discount:0,
            'service_total_discount_pct' => $work_order_details->service_total_discount_pct?$work_order_details->service_total_discount_pct:0,
            'service_total_taxable' => $work_order_details->service_total_taxable?$work_order_details->service_total_taxable:0,
            'service_total_gst_pct' => $work_order_details->service_total_gst_pct?$work_order_details->service_total_gst_pct:0,
            'service_total_gst' => $work_order_details->total_servie_gst_price?$work_order_details->total_servie_gst_price:0,
            'service_grand_total' => $work_order_details->total_service_amount?$work_order_details->total_service_amount:0,

            'packagediscountstate' => $work_order_details->packagediscountstate?$work_order_details->packagediscountstate:"",
            'service_package_user_total' => $work_order_details->service_package_user_total?$work_order_details->service_package_user_total:0,
            'service_package_mech_total' => $work_order_details->service_package_mech_total?$work_order_details->service_package_mech_total:0,
            'service_package_total_discount' => $work_order_details->service_package_total_discount?$work_order_details->service_package_total_discount:0,
            'service_package_total_discount_pct' => $work_order_details->service_package_total_discount_pct?$work_order_details->service_package_total_discount_pct:0,
            'service_package_total_taxable' => $work_order_details->service_package_total_taxable?$work_order_details->service_package_total_taxable:0,
            'service_package_total_gst_pct' => $work_order_details->service_package_total_gst_pct?$work_order_details->service_package_total_gst_pct:0,
            'service_package_total_gst' => $work_order_details->service_package_total_gst?$work_order_details->service_package_total_gst:0,
            'service_package_grand_total' => $work_order_details->service_package_grand_total?$work_order_details->service_package_grand_total:0,

            'product_user_total' => $work_order_details->product_user_total?$work_order_details->product_user_total:0,
            'product_mech_total' => $work_order_details->product_mech_total?$work_order_details->product_mech_total:0,
            'product_total_discount' => $work_order_details->product_total_discount?$work_order_details->product_total_discount:0,
            'product_total_taxable' => $work_order_details->product_total_taxable?$work_order_details->product_total_taxable:0,
            'product_total_gst' => $work_order_details->product_total_gst?$work_order_details->product_total_gst:0,
            'product_grand_total' => $work_order_details->product_grand_total?$work_order_details->product_grand_total:0,
            'total_taxable_amount' => $work_order_details->total_taxable_amount?$work_order_details->total_taxable_amount:0,
            'total_tax_amount' => $work_order_details->total_tax_amount?$work_order_details->total_tax_amount:0,
            'invoice_status' => 'D',
            'created_on' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id')
        );
		
        $invoice_id = $this->mdl_mech_invoice->save($invoice_id, $data);

        foreach (json_decode($service_items) as $service) {
            if($service->is_from == "work_order_service"){
                if (!empty($service->rs_item_id)) {
                    $service_array = array(
                        'quote_id'=>$quote_id,
                        'invoice_id' => $invoice_id,
                        'user_id'=> $work_order_details->customer_id,
                        'is_from'=>'invoice_service',
                        'service_item'=> $service->service_item,
                        'item_hsn' => $service->item_hsn,
                        'user_item_price'=> $service->user_item_price?$service->user_item_price:0,
                        'mech_item_price'=> $service->mech_item_price?$service->mech_item_price:0,
                        'item_discount'=> $service->item_discount?$service->item_discount:0,
                        'igst_pct'=> $service->igst_pct?$service->igst_pct:0,
                        'igst_amount'=> $service->igst_amount?$service->igst_amount:0,
                        'cgst_pct'=> $service->cgst_pct?$service->cgst_pct:0,
                        'cgst_amount'=> $service->cgst_amount?$service->cgst_amount:0,
                        'sgst_pct'=> $service->sgst_pct?$service->sgst_pct:0,
                        'sgst_amount'=> $service->sgst_amount?$service->sgst_amount:0,
                        'warrentry_prd'=>$service->warrentry_prd,
                        'item_total_amount'=> $service->item_total_amount?$service->item_total_amount:0,
                        'created_on'=>date('Y-m-d H:i:s'),
                        'created_by'=>$this->session->userdata('user_id'),
                        'modified_by'=>$this->session->userdata('user_id'),
                        'workshop_id' => $this->session->userdata('work_shop_id'),
                        'w_branch_id' => $this->session->userdata('branch_id')
                    );
                    
                    $service_id = $this->db->insert('mech_invoice_item', $service_array);
                    
                }
            }
        }

        foreach (json_decode($service_package_items) as $service) {
            if($service->is_from == "work_order_package"){
                if (!empty($service->rs_item_id)) {
                    $service_package_array = array(
                        'quote_id' => $quote_id,
                        'invoice_id' => $invoice_id,
                        'user_id' => $work_order_details->customer_id,
                        'is_from' => 'invoice_package',
                        'service_item' => $service->service_item,
                        'item_hsn' => $service->item_hsn,
                        'employee_id' => $service->employee_id,
                        'user_item_price' => $service->user_item_price?$service->user_item_price:0,
                        'mech_item_price' => $service->mech_item_price?$service->mech_item_price:0,
                        'item_discount' => $service->item_discount?$service->item_discount:0,
                        'igst_pct' => $service->igst_pct?$service->igst_pct:0,
                        'igst_amount' => $service->igst_amount?$service->igst_amount:0,
                        'cgst_pct' => $service->cgst_pct?$service->cgst_pct:0,
                        'cgst_amount' => $service->cgst_amount?$service->cgst_amount:0,
                        'sgst_pct' => $service->sgst_pct?$service->sgst_pct:0,
                        'sgst_amount' => $service->sgst_amount?$service->sgst_amount:0,
                        'warrentry_prd' =>$service->warrentry_prd,
                        'item_total_amount' => $service->item_total_amount?$service->item_total_amount:0,
                        'created_on' =>date('Y-m-d H:i:s'),
                        'created_by' =>$this->session->userdata('user_id'),
                        'modified_by' =>$this->session->userdata('user_id'),
                        'workshop_id' => $this->session->userdata('work_shop_id'),
                        'w_branch_id' => $this->session->userdata('branch_id')
                    );
                    
                    $service_package_id = $this->db->insert('mech_invoice_item', $service_package_array);
                    
                }
            }
        }

        $is_product = $this->db->query("SELECT is_product FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND created_by = ".$this->session->userdata('user_id')." ")->row()->is_product;
        if($is_product == "Y"){
            foreach (json_decode($products_items) as $product) {
                if($product->is_from == "work_order_product"){
                    if(!empty($product->rs_item_id)) {
                        $product_array = array(
                            'quote_id'=> $quote_id,
                            'invoice_id' => $invoice_id,
                            'user_id'=> $work_order_details->customer_id,
                            'is_from'=>'invoice_product',
                            'service_item'=>$product->service_item,
                            'user_item_price'=> $product->user_item_price?$product->user_item_price:0,
                            'mech_item_price'=> $product->mech_lbr_price?$product->mech_lbr_price:0,
                            'item_hsn' => $product->item_hsn,
                            'item_qty'=> $product->item_qty,
                            'item_amount' => $product->item_amount?$product->item_amount:0,
                            'item_discount'=> $product->item_discount?$product->item_discount:0,
                            'igst_pct'=> $product->igst_pct?$product->igst_pct:0,
                            'igst_amount'=> $product->igst_amount?$product->igst_amount:0,
                            'cgst_pct'=> $product->cgst_pct?$product->cgst_pct:0,
                            'cgst_amount'=> $product->cgst_amount?$product->cgst_amount:0,
                            'sgst_pct'=> $product->sgst_pct?$product->sgst_pct:0,
                            'sgst_amount'=> $product->sgst_amount?$product->sgst_amount:0,
                            'warrentry_prd'=> $product->warrentry_prd,
                            'item_total_amount'=> $product->item_total_amount?$product->item_total_amount:0,
                            'created_on'=>date('Y-m-d H:i:s'),
                            'created_by'=>$this->session->userdata('user_id'),
                            'modified_by'=>$this->session->userdata('user_id'),
                            'workshop_id' => $this->session->userdata('work_shop_id'),
                            'w_branch_id' => $this->session->userdata('branch_id')
                        );
                        
                        $product_id = $this->db->insert('mech_invoice_item', $product_array);
                        
                        $inventory_data = array(
                            'product_id' => $product->service_item,
                            'stock_type' => 1,
                            'quantity' => $product->item_qty,
                            'price' => $product->user_item_price?$product->user_item_price:0,
                            'stock_date' => date('Y-m-d H:i:s'),
                            'description' => "Invoice stock",
                            'action_type' => 2
                        );
                        $status = $this->mdl_mech_item_master->save_inventory($inventory_data);
                    }
                }
            }
        }
		return $invoice_id;
    }

	public function getjobvehiclenos($vehicle_no = Null){
        $this->db->select('car_reg_no');
        $this->db->from('mech_owner_car_list');
        $this->db->like('car_reg_no', $vehicle_no);
        $this->db->where('mech_owner_car_list.status', 1);
        $result = $this->db->get()->result();

        $vehicle_list = array();

        if(count($result) > 0){
           foreach($result as $res){
               array_push($vehicle_list , $res->car_reg_no);
           }
        }

        $response = array(
            'success' => 1,
            'result' => $result,
            'vehicle_list' => $vehicle_list,
        );

        echo json_encode($response);

    }
}
