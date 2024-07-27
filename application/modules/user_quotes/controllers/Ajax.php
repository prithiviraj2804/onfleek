<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');



/**
 * Class Ajax
 */
class Ajax extends Admin_Controller
{
    public $ajax_controller = true; 
  
    public function create()
    {
    	
        $this->load->model('user_quotes/mdl_user_quotes');

        if ($this->mdl_user_quotes->run_validation()) {
        	
            $quote_id = $this->mdl_user_quotes->save();
			
			/*$this->db->select('mq.customer_id,mq.url_key,mq.customer_car_id');
            $this->db->from('mech_quotes mq');
            $this->db->where('mq.quote_id',$quote_id);         
            $query = $this->db->get(); 
            if($query->num_rows() != 0)
            {
                $result = $query->result_array();
			}
            else
            {
                $result = array();
            }*/
			
            $response = array(
                'success' => 1,
                'quote_id' => $quote_id,
                //'user_quote_details' => $result
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
	public function save_service_quote_request()
    {
        $this->load->model('user_quotes/mdl_user_quotes');
		$this->load->model('clients/mdl_clients');
		$quote_id = $this->input->post('quote_id');
		$is_request_quote = $this->input->post('is_request_quote');
		$selected_service_item = $this->input->post('selected_service_item');
		
		$this->db->select('*');
        $this->db->from('mech_quotes mq');
        $this->db->where('mq.quote_id',$quote_id);         
        $query = $this->db->get()->row();
		
		$user_id = $query->customer_id;
		$url_key = $query->url_key;
		$user_car_id = $query->customer_car_id;
		
		$exist_sitem = [];
		$check_service_item_detail = $this->db->select('service_item')->get_where('mech_repair_service_items', array('quote_id' => $quote_id))->result();
		foreach ($check_service_item_detail as $key => $value) {
    		$exist_sitem[] = $value->service_item;
		}
			$service_total_taxable = 0;
			$service_grand_total = 0;
			$product_total_taxable = 0;
			$product_grand_total = 0;
			$total_taxable_amount = 0;
			$total_tax_amount = 0;
			$appointment_grand_total = 0;
			$total_due_amount = 0;
		if(count($selected_service_item) > 0){
			$service_mech_total = 0;
			$service_user_total = 0;
			$product_user_total = 0;
			$product_mech_total = 0;
			$product_total_gst = 0;
			
			
			$item_total_user_price = 0;
			$item_total_mech_price = 0;
			$lab_total_user_price = 0;
			$lab_total_mech_price = 0;
		foreach ($selected_service_item as $item) {
			
			if(!in_array($item, $exist_sitem)){

			$item_detail = $this->db->get_where('mech_service_item_dtls', array('status' => 'A', 'msim_id' => $item))->row();
			
			$service_category_id = $item_detail->service_category_id;

			$car_details = $this->db->get_where('mech_owner_car_list',array('car_list_id'=>$user_car_id))->row();

			$price_details = $this->db->get_where('mechanic_service_item_mapping',array('brand_id'=>$car_details->car_brand_id,'model_id'=>$car_details->car_brand_model_id,'variant_id'=>$car_details->car_variant,'fuel_type'=>$car_details->fuel_type,'service_item_id'=>$item))->result_array();
			
			
			if(isset($price_details[0])){
				$service_product_ids = explode (", ", $price_details[0]['product_id']);
				$item_user_price = $price_details[0]['user_price'];
				$item_mech_price = $price_details[0]['mech_price'];		
			} else {
				$service_product_ids = array();
				$item_user_price = 0.00;
				$item_mech_price = 0.00;		
			}
			
			$data = array(
			    'quote_id' => $quote_id,
			    'user_id' => $user_id,
			    'url_key' => $url_key,
			    'user_car_id' => $user_car_id,
			    //'service_type' => $is_repair_diagnostics,
			    'category_type' => $service_category_id,
			    'service_item' => $item,
			    'user_item_price' => $item_user_price,
			    'mech_item_price' => $item_mech_price,
			    'item_total_amount'=>$item_user_price,
			    'is_from' => 'invoice_service',
			    'service_status' => 'Y',
			    'created_by' => $this->session->userdata('user_id'),
			    'created_on' => date('Y-m-d H:i:s'),
			    'workshop_id' => $this->session->userdata('work_shop_id'),
			    'w_branch_id' => $this->session->userdata('branch_id')
			);
			$service_user_total += $item_user_price;
			$service_mech_total += $item_mech_price;
			$this->db->insert('mech_repair_service_items', $data);
			
			if(count($service_product_ids) > 0){
				foreach ($service_product_ids as $prd_item) {
					$product_details = $this->db->get_where('mech_product_map_detail',array('brand_id'=>$car_details->car_brand_id,'model_id'=>$car_details->car_brand_model_id,'variant_id'=>$car_details->car_variant,'fuel_type'=>$car_details->fuel_type,'product_id'=>$prd_item))->result();
					
					$sale_price = $product_details[0]->sale_price;
					$cost_price = $product_details[0]->cost_price;
					$cgst_amount = $product_details[0]->cgst_amount;
					$sgst_amount = $product_details[0]->sgst_amount;
					$sgst_percentage = $product_details[0]->sgst_percentage;
					$cgst_percentage = $product_details[0]->cgst_percentage;
				
			 $prd_data = array(
			    'quote_id' => $quote_id,
			    'user_id' => $user_id,
			    'url_key' => $url_key,
			    'user_car_id' => $user_car_id,
			    //'service_type' => $is_repair_diagnostics,
			    'service_item' => $product_details[0]->product_id,
			    'user_item_price' => $sale_price,
			    'mech_item_price' => $cost_price,
			    'is_from' => 'invoice_product',
			    'igst_pct'=>0,
				'igst_amount'=>0,
				'cgst_pct'=>$cgst_percentage,
				'cgst_amount'=>$cgst_amount,
				'sgst_pct'=>$sgst_percentage,
				'sgst_amount'=>$sgst_amount,
			    'item_total_amount'=>$sale_price+$cgst_amount+$sgst_amount,
			    'service_status' => 'Y',
			    'created_by' => $this->session->userdata('user_id'),
			    'created_on' => date('Y-m-d H:i:s'),
			    'workshop_id' => $this->session->userdata('work_shop_id'),
			    'w_branch_id' => $this->session->userdata('branch_id')
			);
			//print_r($prd_data);
			$product_user_total += $sale_price;
			$product_mech_total += $cost_price;
			$product_total_gst += $cgst_amount+$sgst_amount;
			$this->db->insert('mech_repair_service_items', $prd_data);
			}
			}
		}
		}
		$service_total_taxable= $query->service_user_total + $service_user_total;
		$product_total_taxable = $query->product_user_total +$product_user_total;
		$product_grand_total = $product_user_total+$product_total_gst;
		$total_taxable_amount = $service_total_taxable+$product_total_taxable;
		$total_tax_amount = $product_total_gst;
		$appointment_grand_total = $total_taxable_amount+$total_tax_amount;
			$quote_data = array(
				'is_request_quote' => $is_request_quote,
			    'service_mech_total' => $query->service_mech_total + $service_mech_total,
			    'service_user_total' => $query->service_user_total + $service_user_total,
			    'service_total_discount' => '0.00',
			    'service_total_discount_pct' => 0,
			    'service_total_taxable' =>$service_total_taxable,
			    'service_total_gst_pct' => 0,
			    'service_total_gst' => 0,
			    'service_grand_total' => $service_total_taxable,
			    'product_user_total' => $product_user_total,
			    'product_mech_total' => $product_mech_total,
			    'product_total_discount' => 0,
			    'product_total_taxable' =>$product_total_taxable,
			    'product_total_gst'=> $product_total_gst,
			    'product_grand_total'=>$product_grand_total,
			    'total_taxable_amount'=>$total_taxable_amount,
			    'total_tax_amount' =>$total_tax_amount,
			    'appointment_grand_total'=>$appointment_grand_total,
			    'total_due_amount'=>$appointment_grand_total,
			    'modified_by' => $this->session->userdata('user_id')
			);
			
			$this->db->where('quote_id', $quote_id);
			$this->db->update('mech_quotes', $quote_data);
		}
		
		$user_details = $this->mdl_clients->get_by_id($user_id);
		$customer_address = $this->db->get_where('mech_user_address',array('user_id'=>$user_id))->result();
     	$response = array(
                'success' => 1,
                'quote_id' => $quote_id,
                'user_details' => $user_details,
                'customer_address' => $customer_address
            );
		echo json_encode($response);
    } 

	public function save_appointment_details($quote_id)
    {
    	
        $this->load->model('user_quotes/mdl_user_quotes');
		//$quote_id = $this->input->post('quote_id');
		//$is_request_quote = $this->input->post('is_request_quote');
		$book_type = $this->input->post('book_type');
		$user_car_list_id = $this->input->post('user_car_list_id');
		
		//$selected_service_item = $this->input->post('selected_service_item');
		$visit_type = $this->input->post('visit_type');
		$appointment_book_date = $this->input->post('appointment_book_date');
		$appointment_book_time = $this->input->post('appointment_book_time');
		$delivery_date = $this->input->post('delivery_date');
		$delivery_time = ($this->input->post('delivery_time'))?$this->input->post('delivery_time'):NULL;
		$is_pickup = $this->input->post('is_pickup');
		$pickup_address = $this->input->post('pickup_address');
		$pickup_date = ($this->input->post('pickup_date'))?date_to_mysql($this->input->post('pickup_date')):NULL;
		$pickup_time = $this->input->post('pickup_time');
		$user_alternative_mobile_no = $this->input->post('user_alternative_mobile_no');
		$current_odometer_reading  = $this->input->post('current_odometer_reading');
		$fuel_level = $this->input->post('fuel_level');
		
		$error_array=array();
		if(empty($quote_id)){
			array_push($error_array, '<p>Please select quote</p>');
		}
		if(empty($current_odometer_reading)){
			array_push($error_array, '<p>Please enter odometer reading</p>');
		}
		if(empty($fuel_level)){
			array_push($error_array, '<p>Please select fuel level</p>');
		}
		/*if(empty($pickup_time)){
			array_push($error_array, '<p>Please select pickup time</p>');
		}*/
				
		if(count($error_array) > 0 && $book_type == 2){
			$response = array(
                'success' => 0,
                'error_validation' => $error_array
            );
			echo json_encode($response);
			exit();
		}else{
			if($book_type == 1){
				$appointment_book_date = NULL;
				$appointment_book_time = NULL;
				$current_track_status = NULL;
				$app_group_no = NULL;
			}elseif($book_type == 2){
				$appointment_book_date = $appointment_book_date;
				$appointment_book_time = $appointment_book_time;
				$current_track_status = 1;
				$app_group_no = $this->mdl_settings->getquote_book_no('job_card');
			}
			
			$data = array(
			    'appointment_no' => $this->mdl_settings->get_invoice_number($app_group_no),
			    'is_pickup' => $is_pickup,
			    'pickup_address_id' => $pickup_address,
			    'pickup_date' => $pickup_date,
			    'pickup_time' => $pickup_datetime,
			    'created_by' => $this->session->userdata('user_id'),
			    'visit_type' => $visit_type,
			    'appointment_book_date' => $appointment_book_date,
			    'appointment_book_time' => $appointment_book_time,
			    'delivery_date' => $delivery_date,
			    'delivery_time' => $delivery_time,
			    'current_track_status' => $current_track_status,
			    'quote_status' => $book_type,
			    'current_odometer_reading' => $current_odometer_reading,
			    'fuel_level' => $fuel_level,
			    'user_alternative_mobile_no' => $user_alternative_mobile_no
			);
			$this->db->where('quote_id', $quote_id);
			$this->db->update('mech_quotes', $data);
			
		
		if($book_type == 1){
			$response = array(
                'success' => 1,
                'type' => $book_type,
                'quote_id' => $quote_id
            );
		}else{
			$car_details = $this->db->get_where('mech_owner_car_list',array('car_list_id'=>$user_car_list_id))->row();
			$msg = 'we have received an appointment for your car '.$car_details->car_reg_no.'. We will pick up your after confirmation';
			$this->db->insert('mech_service_tracking_details',array('quote_id'=>$quote_id,'track_status_id'=>1,'comments'=>$msg, 'workshop_id' => $this->session->userdata('work_shop_id'), 'w_branch_id' => $this->session->userdata('branch_id')));
			
			
			$response = array(
                'success' => 1,
                'type' => $book_type,
                'quote_id' => $id
            );
		}
		
		echo json_encode($response);
		exit();
        }
		
    } 
 
	
	public function remove_added_service()
    {
    	$quote_id = $this->input->post('quote_id');
		$item_id = $this->input->post('item_id');
		
		$this->db->select('*');
        $this->db->from('mech_repair_service_items mi');
        $this->db->where('mi.quote_id',$quote_id); 
		$this->db->where('mi.service_item',$item_id);           
        $query = $this->db->get()->row();
		
		$this->db->select('*');
        $this->db->from('mech_quotes mq');
        $this->db->where('mq.quote_id',$quote_id);         
        $query_quote = $this->db->get()->row();
		
		$price_data = array(
			    'total_user_price' => $query_quote->total_user_price - $query->user_item_price,
			    'total_mech_price' => $query_quote->total_mech_price - $query->mech_item_price,
			    'total_labour_user_price' => $query_quote->total_labour_user_price - $query->user_item_labour_price,
			    'total_labour_mech_price' => $query_quote->total_labour_mech_price - $query->mech_item_labour_price,
			    'modified_by' => $this->session->userdata('user_id')
			);
			
			$this->db->where('quote_id', $quote_id);
			$this->db->update('mech_quotes', $price_data);
			
    	$this->db->where('service_item', $item_id);
		$this->db->where('quote_id', $quote_id);
   		$this->db->delete('mech_repair_service_items'); 	
		$item_details = $this->db->get_where('mech_service_item_dtls', array('status' => 'A', 'msim_id' => $item_id))->result();
		echo json_encode($item_details);
    }

	public function get_category_items()
	{
		$this->load->model('user_quotes/mdl_user_quotes');
		$cat_id = $this->input->post('cat_id');
		$item_list = $this->db->get_where('mech_service_item_dtls', array('status' => 'A', 'service_category_id' => $cat_id))->result();
		$response = array(
                'cat_name' => $this->mdl_user_quotes->get_service_category_name($cat_id),
                'item_list' => $item_list
            );
		echo json_encode($response);
	}
	public function get_category_item_details()
	{
		$this->load->model('user_quotes/mdl_user_quotes');
		$cat_id = $this->input->post('cat_id');
		$item_id = $this->input->post('item_id');
		$user_car_id = $this->input->post('user_car_id');

		$car_details = $this->db->get_where('mech_owner_car_list',array('car_list_id'=>$user_car_id))->row();

		$price_details = $this->db->get_where('mechanic_service_item_mapping',array('brand_id'=>$car_details->car_brand_id,'model_id'=>$car_details->car_brand_model_id,'fuel_type'=>$car_details->fuel_type,'service_item_id'=>$item_id))->result_array();

		//print_r($price_details);

		$item_details = $this->db->get_where('mech_service_item_dtls', array('status' => 'A', 'msim_id' => $item_id))->result();
		
		
		$response = array(
                'cat_name' => $this->mdl_user_quotes->get_service_category_name($cat_id),
                'item_details' => $item_details,
                'price_details' => $price_details
            );
		echo json_encode($response);
	}
	public function get_item_details()
	{
		$this->load->model('user_quotes/mdl_user_quotes');
		$item_id = $this->input->post('item_id');
		$item_details = $this->db->get_where('mech_service_item_dtls', array('status' => 'A', 'msim_id' => $item_id))->result();
		echo json_encode($item_details);
	}

   // public function delete()
   // {
   //     $quote_id = $this->input->post('quote_id');
	  //  $this->db->where('quote_id', $quote_id);
   // 	   $this->db->delete('mech_repair_service_items'); 
	   
	  //  $this->db->where('quote_id', $quote_id);
	  //  $this->db->delete('mech_quotes');
	  //  echo "success";
	   
   // }

	public function sendQuoteAppointmentsMail($type, $entity_id, $app_id = NULL)
	{
		$this->load->model('user_cars/mdl_user_cars');
		$this->load->model('users/mdl_users');
		$this->db->select('*');
        $this->db->from('mech_quotes mq');
        $this->db->where('mq.quote_id',$entity_id);         
        $query = $this->db->get()->row(); 
		
		$this->db->select('*');
		$this->db->from('mech_repair_service_items si');
		$this->db->join('mech_service_item_dtls ci', 'ci.msim_id = si.service_item');
		$this->db->where('quote_id', $entity_id);
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
		//print_r($email_details);
		//exit();
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
		$quote_id = $this->input->post('quote_id');
		$user_id = $this->input->post('user_id');
		$car_brand_id = $this->input->post('car_brand_id');
		$car_brand_model_id = $this->input->post('car_brand_model_id');
		$brand_model_variant_id = $this->input->post('brand_model_variant_id');
		$mm_csrf = $this->input->post('_mm_csrf');
		$product_items = json_decode($this->input->post('product_items'));
		$service_items = json_decode($this->input->post('service_items'));
		
		//echo $user_id;
		$this->load->model('user_quotes/mdl_user_quotes');

        if ($this->mdl_user_quotes->run_validation()) {
        	
            $quote_id = $this->mdl_user_quotes->save();
			
			$total_update = array(
				'pickup_address_id' => $this->input->post('pickup_address_id'),
				'delivery_address_id' => $this->input->post('delivery_address_id'),
				'service_user_total' => $service_totals->total_usr_lbr_price,
				'service_mech_total' => $service_totals->total_mech_lbr_price,
				'service_total_discount' => $this->input->post('service_total_discount'),
				'service_total_discount_pct' => $this->input->post('service_discount_pct'),
				'service_total_taxable' => $this->input->post('service_total_taxable'),
				'service_total_gst_pct' => $this->input->post('service_tax_pct'),
				'service_total_gst' => $this->input->post('total_servie_gst_price'),
				'service_grand_total' => $this->input->post('total_service_amount'),
				'product_user_total' => $product_totals->total_usr_lbr_price,
				'product_mech_total' => $product_totals->total_mech_lbr_price,
				'product_total_discount' => $product_totals->total_item_discount,
				'product_total_taxable' => $this->input->post('product_total_taxable'),
				'product_total_gst' => ($product_totals->total_igst_amount) + ($product_totals->total_cgst_amount) + ($product_totals->total_sgst_amount),
				'product_grand_total' => $product_totals->total_item_total_amount,
				'total_taxable_amount' => $this->input->post('total_taxable_amount'),
				'total_tax_amount' => $this->input->post('total_tax_amount'),
				'appointment_grand_total'=> $this->input->post('total_due_amount'),
					//'request_admin_update' => $this->input->post('userrequpdate')
			);
			$this->db->where('quote_id', $quote_id);
			$this->db->update('mech_quotes', $total_update);

			foreach ($service_items as $service) {
			if (!empty($service->item_service_id)) {
			$service_array = array(
				'quote_id'=>$quote_id,
				
				'user_id'=>$user_id,
				'user_car_id'=>$car_brand_id,
				'car_brand_model_id'=>$car_brand_model_id,
				'brand_model_variant_id'=>$brand_model_variant_id,
				'is_from'=>'invoice_service',
				'service_item'=>$service->item_service_id,
				'item_hsn' => $service->item_hsn,
				//'item_service_name'=>$service->item_service_name?$service->item_service_name:NULL,
				'user_item_price'=>$service->usr_lbr_price,
				'mech_item_price'=>$service->mech_lbr_price,
				'item_discount'=>$service->item_discount,
				'igst_pct'=>$service->igst_pct,
				'igst_amount'=>$service->igst_amount,
				'cgst_pct'=>$service->cgst_pct,
				'cgst_amount'=>$service->cgst_amount,
				'sgst_pct'=>$service->sgst_pct,
				'sgst_amount'=>$service->sgst_amount,
				'warrentry_prd'=>$service->warrentry_prd,
				'item_total_amount'=>$service->item_total_amount,
				'created_on'=>date('Y-m-d H:i:s'),
				'created_by'=>$this->session->userdata('user_id'),
				'modified_by'=>$this->session->userdata('user_id'),
				'workshop_id' => $this->session->userdata('work_shop_id'),
				'w_branch_id' => $this->session->userdata('branch_id')
			);
			if(isset($service->rs_item_id)){
				$this->db->where('rs_item_id', $service->rs_item_id);
				$service_id = $this->db->update('mech_repair_service_items', $service_array);
			}else{
				$service_id = $this->db->insert('mech_repair_service_items', $service_array);
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
						'quote_id'=>$quote_id,
						//'appointment_id'=>$quote_id,
						'user_id'=>$user_id,
						'user_car_id'=>$car_brand_id,
						'car_brand_model_id'=>$car_brand_model_id,
						'brand_model_variant_id'=>$brand_model_variant_id,
						'is_from'=>'invoice_product',
						'item_hsn' => $service->item_hsn,
						'service_item'=>$product->item_product_id,
						'user_item_price'=>$product->usr_lbr_price,
						'mech_item_price'=>$product->mech_lbr_price,
						'item_qty'=>$product->product_qty,
						'item_discount'=>$product->item_discount,
						'igst_pct'=>$product->igst_pct,
						'igst_amount'=>$product->igst_amount,
						'cgst_pct'=>$product->cgst_pct,
						'cgst_amount'=>$product->cgst_amount,
						'sgst_pct'=>$product->sgst_pct,
						'sgst_amount'=>$product->sgst_amount,
						'warrentry_prd'=>$product->warrentry_prd,
						'item_total_amount'=>$product->item_total_amount,
						'created_on'=>date('Y-m-d H:i:s'),
						'created_by'=>$this->session->userdata('user_id'),
						'modified_by'=>$this->session->userdata('user_id'),
						'workshop_id' => $this->session->userdata('work_shop_id'),
						'w_branch_id' => $this->session->userdata('branch_id')
					);
					if(isset($product->rs_item_id)){
						$this->db->where('rs_item_id', $product->rs_item_id);
						$product_id = $this->db->update('mech_repair_service_items', $product_array);
					}else{
						$product_id = $this->db->insert('mech_repair_service_items', $product_array);
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

			if($this->input->post('book_type') == 2)
			{
				$this->save_appointment_details($quote_id);
			}

            $response = array(
                'success' => 1,
                'quote_id' => $quote_id,
                //'user_quote_details' => $result
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

	public function invoice_save()
	{
		$quote_id = $this->input->post('quote_id');
		$user_id = $this->input->post('user_id');
		$car_brand_id = $this->input->post('car_brand_id');
		$car_brand_model_id = $this->input->post('car_brand_model_id');
		$brand_model_variant_id = $this->input->post('brand_model_variant_id');
		$mm_csrf = $this->input->post('_mm_csrf');
		$product_items = json_decode($this->input->post('product_items'));
		$service_items = json_decode($this->input->post('service_items'));
		
		if($quote_id){
			
			$product_totals =  (object) json_decode($this->input->post('product_totals'),TRUE)[0];
			$service_totals =  (object) json_decode($this->input->post('service_totals'),TRUE)[0];

			//print_r($product_totals);

			$this->db->select_sum('payment_amount');
        	$payments = $this->db->get_where("mech_payments",array('entity_id'=>$quote_id, 'entity_type' => 'jobcard'))->row();

			$total_update = array(
				'service_user_total' => $service_totals->total_usr_lbr_price,
				'service_mech_total' => $service_totals->total_mech_lbr_price,
				'service_total_discount' => $this->input->post('service_total_discount'),
				'service_total_discount_pct' => $this->input->post('service_discount_pct'),
				'service_total_taxable' => $this->input->post('service_total_taxable'),
				'service_total_gst_pct' => $this->input->post('service_tax_pct'),
				'service_total_gst' => $this->input->post('total_servie_gst_price'),
				'service_grand_total' => $this->input->post('total_service_amount'),
				'product_user_total' => $product_totals->total_usr_lbr_price,
				'product_mech_total' => $product_totals->total_mech_lbr_price,
				'product_total_discount' => $product_totals->total_item_discount,
				'product_total_taxable' => $this->input->post('product_total_taxable'),
				'product_total_gst' => ($product_totals->total_igst_amount) + ($product_totals->total_cgst_amount) + ($product_totals->total_sgst_amount),
				'product_grand_total' => $product_totals->total_item_total_amount,
				'total_taxable_amount' => $this->input->post('total_taxable_amount'),
				'total_tax_amount' => $this->input->post('total_tax_amount'),
				'appointment_grand_total'=> $this->input->post('appointment_grand_total'),
				'total_due_amount' => $this->input->post('total_due_amount') - $payments->payment_amount,
				//'request_admin_update' => $this->input->post('userrequpdate')
			);
			$this->db->where('quote_id', $quote_id);
			$this->db->update('mech_quotes', $total_update);

		}
		
		foreach ($service_items as $service) {
			if (!empty($service->item_service_id)) {
			$service_array = array(
				'quote_id'=>$quote_id,
				
				'user_id'=>$user_id,
				'user_car_id'=>$car_brand_id,
				'car_brand_model_id'=>$car_brand_model_id,
				'brand_model_variant_id'=>$brand_model_variant_id,
				'is_from'=>'invoice_service',
				'service_item'=>$service->item_service_id,
				'item_hsn' => $service->item_hsn,
				//'item_service_name'=>$service->item_service_name?$service->item_service_name:NULL,
				'user_item_price'=>$service->usr_lbr_price,
				'mech_item_price'=>$service->mech_lbr_price,
				'item_discount'=>$service->item_discount,
				'igst_pct'=>$service->igst_pct,
				'igst_amount'=>$service->igst_amount,
				'cgst_pct'=>$service->cgst_pct,
				'cgst_amount'=>$service->cgst_amount,
				'sgst_pct'=>$service->sgst_pct,
				'sgst_amount'=>$service->sgst_amount,
				'warrentry_prd'=>$service->warrentry_prd,
				'item_total_amount'=>$service->item_total_amount,
				'created_on'=>date('Y-m-d H:i:s'),
				'created_by'=>$this->session->userdata('user_id'),
				'modified_by'=>$this->session->userdata('user_id'),
				'workshop_id' => $this->session->userdata('work_shop_id'),
				'w_branch_id' => $this->session->userdata('branch_id')
			);
			if(isset($service->rs_item_id)){
				$this->db->where('rs_item_id', $service->rs_item_id);
				$service_id = $this->db->update('mech_repair_service_items', $service_array);
			}else{
				$service_id = $this->db->insert('mech_repair_service_items', $service_array);
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
						'quote_id'=>$quote_id,
						//'appointment_id'=>$quote_id,
						'user_id'=>$user_id,
						'user_car_id'=>$car_brand_id,
						'car_brand_model_id'=>$car_brand_model_id,
						'brand_model_variant_id'=>$brand_model_variant_id,
						'is_from'=>'invoice_product',
						'item_hsn' => $service->item_hsn,
						'service_item'=>$product->item_product_id,
						'user_item_price'=>$product->usr_lbr_price,
						'mech_item_price'=>$product->mech_lbr_price,
						'item_qty'=>$product->product_qty,
						'item_discount'=>$product->item_discount,
						'igst_pct'=>$product->igst_pct,
						'igst_amount'=>$product->igst_amount,
						'cgst_pct'=>$product->cgst_pct,
						'cgst_amount'=>$product->cgst_amount,
						'sgst_pct'=>$product->sgst_pct,
						'sgst_amount'=>$product->sgst_amount,
						'warrentry_prd'=>$product->warrentry_prd,
						'item_total_amount'=>$product->item_total_amount,
						'created_on'=>date('Y-m-d H:i:s'),
						'created_by'=>$this->session->userdata('user_id'),
						'modified_by'=>$this->session->userdata('user_id'),
						'workshop_id' => $this->session->userdata('work_shop_id'),
						'w_branch_id' => $this->session->userdata('branch_id')
					);
					if(isset($product->rs_item_id)){
						$this->db->where('rs_item_id', $product->rs_item_id);
						$product_id = $this->db->update('mech_repair_service_items', $product_array);
					}else{
						$product_id = $this->db->insert('mech_repair_service_items', $product_array);
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
				if($quote_id){
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
        $this->db->delete('mech_repair_service_items');
        $response = array(
            'success' => 1
        );
        echo json_encode($response);
    }
    public function delete(){
        $document_id = $this->input->post('document_id');
        $this->db->set('status','D');
        $this->db->where('quote_id', $document_id);
        $this->db->update('mech_quotes');
        $response = array(
            'success' => 1
        );
        echo json_encode($response);
    }
}


