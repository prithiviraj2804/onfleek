<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Userquotes
 */

require_once APPPATH . 'libraries/REST_Controller.php';

class Userquotes extends REST_Controller{


	public function __construct()
    {
        parent::__construct();
		$this->load->helper('settings');
		$this->load->model('users/mdl_users'); 
		$this->load->model('user_quotes/mdl_user_quotes'); 
		$this->load->model('user_address/mdl_user_address'); 
		$this->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls'); 
	}

	public function basic_post($id = null){
		$json = file_get_contents('php://input');
        $obj = json_decode($json, TRUE);
		     	
        	$data = array(
            'service_category_list' => $this->db->select('service_cat_id,category_parent_id,category_name,category_type')->get_where('mechanic_service_category_list', array('status' => 1))->result(),
            'service_category_items' => $this->mdl_mech_service_item_dtls->get()->result();
        );
        
        echo json_encode($data);
	}

	public function list_post()
	{
		$json = file_get_contents('php://input');
        $obj = json_decode($json, TRUE);
        //$this->db->limit(1, 2);
		
		if(isset($obj['user_car_id'])){
			$quotes =$this->db->get_where('mech_quotes',array('user_id'=>$obj['user_id'],'user_car_id'=>$obj['user_car_id'], 'quote_status' => 1))->result();
		} else {
			$quotes =$this->db->get_where('mech_quotes',array('user_id'=>$obj['user_id'], 'quote_status' => 1))->result();	
		}
		$response = [];
		//$q->book_appointment = $this->db->get_where('mech_appointment_books',array('quote_id'=>$q->quote_id));
		foreach ($quotes as $q) {
			$q->service_items =$this->db->query("SELECT GROUP_CONCAT(service_item) as service_item FROM mech_repair_service_items WHERE quote_id='$q->quote_id' GROUP BY quote_id")->row()->service_item;
			$q->book_appointment = $this->db->get_where('mech_appointment_books',array('quote_id'=>$q->quote_id))->result();
			array_push($response, $q);
		};

		echo json_encode($response);
        
	}


	public function list_appointment_post(){
		$json = file_get_contents('php://input');
        $obj = json_decode($json, TRUE);
		$user_id = $obj['user_id'];
        $this->db->select('mech_appointment_books.appointment_id,appointment_no,mech_appointment_books.quote_id,mech_appointment_books.user_id,mech_owner_car_list.car_reg_no,current_track_status,delivery_date,mech_car_brand_details.brand_name,mech_car_brand_models_details.model_name,mech_quotes.appointment_grand_total,mech_quotes.total_due_amount');
        $this->db->from('mech_appointment_books');
		$this->db->join('mech_quotes', 'mech_quotes.quote_id=mech_appointment_books.quote_id');
		$this->db->join('mech_owner_car_list', 'mech_owner_car_list.car_list_id=mech_appointment_books.user_car_id');
		$this->db->join('mech_car_brand_details', 'mech_car_brand_details.brand_id=mech_owner_car_list.car_brand_id');
		$this->db->join('mech_car_brand_models_details', 'mech_car_brand_models_details.model_id=mech_owner_car_list.car_brand_model_id');
        $this->db->where('current_track_status <','9');
		$this->db->where('mech_appointment_books.user_id',$user_id);
        $q = $this->db->get()->result();
		echo json_encode($q);
    }

	public function listquote_post(){
		$json = file_get_contents('php://input');
        $obj = json_decode($json, TRUE);
        //$this->db->limit(1, 2);
		$quotes =$this->db->get_where('mech_quotes',array('user_id'=>$obj['user_id']))->result();
		$response = [];
		//$q->book_appointment = $this->db->get_where('mech_appointment_books',array('quote_id'=>$q->quote_id));
		foreach ($quotes as $q) {
			$q->repair_service =$this->db->select('service_item')->get_where('mech_repair_service_items',array('quote_id'=>$q->quote_id))->result();
			$q->book_appointment = $this->db->get_where('mech_appointment_books',array('quote_id'=>$q->quote_id))->result();
			array_push($response, $q);
		};

		echo json_encode($response);
        
	}

	public function update_post(){
		$this->load->model('user_quotes/mdl_user_quotes');
		$this->load->model('settings/mdl_settings');		
		$this->load->helper('date');

		$json = file_get_contents('php://input');
        $obj = json_decode($json, TRUE);

        $quote_id = $obj['quote_id'];

        $user_id = $obj['user_id'];
       
        $this->db->select('*');
        $this->db->from('mech_quotes mq');
        $this->db->where('mq.quote_id',$quote_id);         
        $query = $this->db->get()->row();
		$selected_service_item = $obj['selected_service_item'];

		$user_alternative_mobile_no = $obj['user_alternative_mobile_no'];

		$book_type = $obj['book_type'];

		$user_car_id = $obj['user_car_id'];

		$pickup_address = $obj['pickup_address'];
		//$pickup_date = $obj['pickup_date'];

		$originalDate = $obj['pickup_date'];
        $originalDate = str_replace('/', '-', $originalDate);
		$pickup_date = date("Y-m-d", strtotime($originalDate));

		$pickup_time = $obj['pickup_time'];

		if($query){
			$url_key = 	$query->url_key;
			
			$update = array(
                    'user_car_id'=>$obj['user_car_id'],
                    'location_zip_code'=>$obj['location_zip_code'],
                    // 'user_alternative_mobile_no' => $user_alternative_mobile_no
                );

			$this->db->where('quote_id',$quote_id);
			$this->db->update('mech_quotes',$update);


			$data_user = array(
			    'user_alternative_mobile_no' => $user_alternative_mobile_no
			);

			$this->db->where('user_id', $user_id);
			$this->db->update('mech_user', $data_user);

			$exist_sitem = [];
			$check_service_item_detail = $this->db->select('service_item')->get_where('mech_repair_service_items', 
				array('quote_id' => $quote_id))->result();

			foreach ($check_service_item_detail as $key => $value) {
	    		$exist_sitem[] = $value->service_item;
			}

			if(count($selected_service_item) > 0){
				$item_total_user_price = 0;
				$item_total_mech_price = 0;
				$lab_total_user_price = 0;
				$lab_total_mech_price = 0;
				foreach ($selected_service_item as $item) {
					$item_detail = $this->mdl_mech_service_item_dtls->where( 'msim_id' , $item )->get()->row();
					if($item_detail != ''){

						$service_category_id = $item_detail->service_category_id;

						$car_details = $this->db->get_where('mech_owner_car_list',array('car_list_id'=>$user_car_id))->row();

						$price_details = $this->db->get_where('mechanic_service_item_mapping',array('brand_id'=>$car_details->car_brand_id,'model_id'=>$car_details->car_brand_model_id,'fuel_type'=>$car_details->fuel_type,'service_item_id'=>$item))->result_array();

						//print_r($price_details);

						if(isset($price_details[0])){
							$item_user_price = $price_details[0]['mech_price'];
							$item_mech_price = $price_details[0]['user_price'];		
						} else {
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
						    //'user_item_labour_price' => $labour_user_price,
						    'mech_item_price' => $item_mech_price,
						    //'mech_item_labour_price' => $labour_mech_price,
						    'service_status' => 0,
						    'created_by' => $obj['user_id'],
						    'created_on' => date('Y-m-d H:i:s')
						);

						$item_total_user_price += $item_user_price;
						$item_total_mech_price += $item_mech_price;

						if(!in_array($item, $exist_sitem)){
							$this->db->insert('mech_repair_service_items', $data);
						} else{
							$this->db->where('quote_id',$quote_id);
							$this->db->update('mech_repair_service_items',$data);
						}
					} else {
						$response = array(
				                'success' => 0,
				                'error_message' => 'Invalid Service id',			        
			            	);	
				
						echo json_encode($response);
						exit();
					}	// end item if condition					
				}  // end for loop
			$price_data = array(
				//'is_request_quote' => $is_request_quote,
			    //'total_user_price' => $query->total_user_price + $item_total_user_price,
			    //'total_mech_price' => $query->total_mech_price + $item_total_mech_price,
			    //'total_labour_user_price' => $quote['total_labour_user_price'] + $lab_total_user_price,
			    //'total_labour_mech_price' => $quote['total_labour_mech_price'] + $lab_total_mech_price,
			    'modified_by' => $this->session->userdata('user_id')
			);
			
			$this->db->where('quote_id', $quote_id);
			$this->db->update('mech_quotes', $price_data);
			}

			if($book_type == 2){
				  $this->db->select('*');
			      $this->db->from('mech_appointment_books ab');
			      $this->db->where('ab.quote_id',$quote_id);         
			      $appquery = $this->db->get()->row();
			    	
				//$group_no = $this->mdl_settings->getquote_book_no('quote');
				if($appquery != '')
				{
					$app_id = $appquery->appointment_id;

					$data = array(
				    	'user_car_id' => $user_car_id,
				    	'pickup_address' => $pickup_address,
				    	'pickup_date' => $pickup_date,
				    	'pickup_time' => $pickup_time,
				    	'created_by' => $obj['user_id'],
				    	'app_created_on' => date('Y-m-d H:i:s'),
				    	'status' => 0
					);
					$this->db->where('appointment_id', $appquery->appointment_id);
					$this->db->update('mech_appointment_books', $data);
					//exit;	
				} else {
					$app_group_no = $this->mdl_settings->getquote_book_no('appointment');
				$data = array(
				    'quote_id' => $quote_id,
				    'appointment_no' => $this->mdl_settings->get_invoice_number($app_group_no),
				    'user_id' => $user_id,
				    'url_key' => $url_key,
				    'user_car_id' => $user_car_id,
				    'pickup_address' => $pickup_address,
				    'pickup_date' => $pickup_date,
				    'pickup_time' => $pickup_time,
				    'created_by' => $obj['user_id'],
				    'app_created_on' => date('Y-m-d H:i:s'),
				    'status' => 0
				);
				$this->db->insert('mech_appointment_books', $data);
				$app_id = $this->db->insert_id();

				$car_details = $this->db->get_where('mech_owner_car_list',array('car_list_id'=>$user_car_id))->row();
				
				$msg = 'we have received an appointment for your car '.$car_details->car_reg_no.'. We will pick up your after confirmation';
				
				$this->db->insert('mech_service_tracking_details',array('quote_id'=>$quote_id,'track_status_id'=>1,'comments'=>$msg));
				

				}

					$data = array(
					    'quote_status' => 2,
					    'modified_by' => $obj['user_id']
					);
					$req_type = 'app';

				
				//$this->sendQuoteAppointmentsMail("appointment", $quote_id, $id);
			} else {
				$data = array(
				    'quote_status' => 1,
				    'modified_by' => $obj['user_id']
				);
				$req_type = 'savequote';
				$app_id = '';
			}

			$this->db->where('quote_id', $quote_id);
			$this->db->update('mech_quotes', $data);

			$quotes = $this->db->get_where('mech_quotes',array('quote_id'=>$quote_id))->result();
			
			$quote_response = [];
			//$q->book_appointment = $this->db->get_where('mech_appointment_books',array('quote_id'=>$q->quote_id));
			foreach ($quotes as $q) {
				//$q->repair_service =$this->db->get_where('mech_repair_service_items',array('quote_id'=>$q->quote_id))->result();
				$q->book_appointment = $this->db->get_where('mech_appointment_books',array('quote_id'=>$q->quote_id))->result();
				array_push($quote_response, $q);
			};

			//echo json_encode($response);


			
			$response = array(
	                'success' => 1,
	                'appointment_id' => $app_id,
	                'quote_id'=>$quote_id,
	                'type'=> $req_type,
	                'quote_details' => $quote_response,
	                'selected_service_item'=>$obj['selected_service_item']
            );	
			
			
			echo json_encode($response);
			
		

		} else {
			echo "Unkown quote ID";
		}


	}
	
	public function create_post(){
		$this->load->model('user_quotes/mdl_user_quotes');
		$this->load->model('settings/mdl_settings');		
		$this->load->helper('date');

		$json = file_get_contents('php://input');
        $obj = json_decode($json, TRUE);

		$user_id = $obj['user_id'];
		$user_car_id = $obj['user_car_id'];
		$location_zip_code = $obj['location_zip_code'];
		$is_request_quote = $obj['is_request_quote'];
		
		$selected_service_item = $obj['selected_service_item'];
		$book_type = $obj['book_type'];
		$pickup_address = $obj['pickup_address'];
		$originalDate = $obj['pickup_date'];
		$originalDate = str_replace('/', '-', $originalDate);
		$pickup_date = date("Y-m-d", strtotime($originalDate));
		$pickup_time = $obj['pickup_time'];
		$user_alternative_mobile_no = $obj['user_alternative_mobile_no'];
		
        $app_id = null;
  
         $group_no = $this->mdl_settings->getquote_book_no('quote');
        /*
        	$db_array['quote_no'] = $this->mdl_settings->get_invoice_number($group_no);
        	appointment
		*/

          $insert = array(
                    'user_car_id'=>$user_car_id,
                    'location_zip_code'=>$location_zip_code,
                    'url_key'=> $this->mdl_user_quotes->get_url_key(),
                    'user_id'=>$user_id,
                    'quote_no' => $this->mdl_settings->get_invoice_number($group_no)
                );
		
		$quote = $this->mdl_user_quotes->create_api_quote($insert);
		//$quote = $query[0];	
      
        $quote_id = $quote->quote_id;
		$url_key = $quote->url_key;
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
		
			$item_detail = $this->mdl_mech_service_item_dtls->where( 'msim_id' , $item )->get()->row();
			
			$service_category_id = $item_detail->service_category_id;

			$car_details = $this->db->get_where('mech_owner_car_list',array('car_list_id'=>$user_car_id))->row();

			$price_details = $this->db->get_where('mechanic_service_item_mapping',array('brand_id'=>$car_details->car_brand_id,'model_id'=>$car_details->car_brand_model_id,'variant_id'=>$car_details->car_variant,'fuel_type'=>$car_details->fuel_type,'service_item_id'=>$item))->result_array();
			
			
			if(isset($price_details[0])){
				if(!empty($price_details[0]['product_id'])){
				$service_product_ids = explode (", ", $price_details[0]['product_id']);
				}else{
					$service_product_ids = array();
				}
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
			    'service_status' => 0,
			    'created_by' => $this->session->userdata('user_id'),
			    'created_on' => date('Y-m-d H:i:s')
			);
			$service_user_total += $item_user_price;
			$service_mech_total += $item_mech_price;
			//$lab_total_user_price += $labour_user_price;
			//$lab_total_mech_price += $labour_mech_price;
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
				//print_r($product_details[0]);
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
			    'service_status' => 0,
			    'created_by' => $this->session->userdata('user_id'),
			    'created_on' => date('Y-m-d H:i:s')
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
         if($is_request_quote == 1)
		{

			//echo "Request Service";
			$data = array(
			    'service_item_name' => $obj['requested_quote'],
			    'service_category_id' => '0',
			    'is_repair_diagnostics' => 2,
			    'service_added_by' => 2,
			    'created_by' => $obj['user_id'],
			    'created_on' => date('Y-m-d H:i:s'),
			    'sci_status' => 1
			);

			$this->db->insert('mechanic_service_category_items', $data);
			$id = $this->db->insert_id();

			$data = array(
			    'quote_id' => $quote_id,
			    'user_id' => $user_id,
			    'url_key' => $url_key,
			    'user_car_id' => $user_car_id,
			    'service_type' => 2,
			    'category_type' => 0,
			    'service_item' => $id,
			    'service_status' => 0,
			    'created_by' => $obj['user_id'],
			    'created_on' => date('Y-m-d H:i:s')
			);
			$this->db->insert('mech_repair_service_items', $data);
			$book_type = 1;
			//echo "rest";
			//exit;
		}

		if($book_type == 2){
			//$group_no = $this->mdl_settings->getquote_book_no('quote');
				$app_group_no = $this->mdl_settings->getquote_book_no('appointment');
				$data = array(
				    'quote_id' => $quote_id,
				    'current_track_status' => 1,
				    'appointment_no' => $this->mdl_settings->get_invoice_number($app_group_no),
				    'user_id' => $user_id,
				    'url_key' => $url_key,
				    'user_car_id' => $user_car_id,
				    'pickup_address' => $pickup_address,
				    'pickup_date' => $pickup_date,
				    'pickup_time' => $pickup_time,
				    'created_by' => $user_id,
				    'app_created_on' => date('Y-m-d H:i:s'),
				    'status' => 0
				);
				$this->db->insert('mech_appointment_books', $data);
				$app_id = $this->db->insert_id();

				$car_details = $this->db->get_where('mech_owner_car_list',array('car_list_id'=>$user_car_id))->row();
				
				$msg = 'we have received an appointment for your car '.$car_details->car_reg_no.'. We will pick up your after confirmation';
				
				$this->db->insert('mech_service_tracking_details',array('quote_id'=>$quote_id,'appointment_id'=>$app_id,'track_status_id'=>1,'comments'=>$msg));
				

				$data = array(
				    'quote_status' => 2,
				    'modified_by' => $user_id
				);
				$req_type = 'app';
				//$this->sendQuoteAppointmentsMail("appointment", $quote_id, $id);
			}else{
				$data = array(
				    'quote_status' => 1,
				    'modified_by' => $user_id
				);
				$req_type = 'savequote';
				if($is_request_quote == 1){
					$req_type = 'reqquote';
				}
				//$this->sendQuoteAppointmentsMail("quote", $quote_id);
				//erxit();
			}
		
			$this->db->where('quote_id', $quote_id);
			$this->db->update('mech_quotes', $data);
			
			$data_user = array(
			    'user_alternative_mobile_no' => $user_alternative_mobile_no
			);

			$this->db->where('user_id', $user_id);
			$this->db->update('mech_user', $data_user);


			
			$quotes = $this->db->get_where('mech_quotes',array('quote_id'=>$quote_id))->result();
			
			$quote_response = [];
			//$q->book_appointment = $this->db->get_where('mech_appointment_books',array('quote_id'=>$q->quote_id));
			foreach ($quotes as $q) {
				$q->repair_service =$this->db->get_where('mech_repair_service_items',array('quote_id'=>$q->quote_id))->result();
				$q->book_appointment = $this->db->get_where('mech_appointment_books',array('quote_id'=>$q->quote_id))->result();
				array_push($quote_response, $q);
			};

			//echo json_encode($response);


			
			$response = array(
	                'success' => 1,
	                'appointment_id' => $app_id,
	                'quote_id'=>$quote_id,
	                'type'=> $req_type,
	                'quote_details' => $quote_response,
	                'selected_service_item'=>$obj['selected_service_item']
            );	
			
			
			echo json_encode($response);
			exit();


        //print_r($obj);
	}

	public function track_post(){
		$json = file_get_contents('php://input');
        $obj = json_decode($json, TRUE);
        //print_r($obj);
        $this->load->model('user_quotes/mdl_user_quotes'); 
        $app = $this->mdl_user_quotes->get_appointments($obj['appointment_id']);
		//print_r($app);
        //$quotes =$this->db->get_where('mech_appointment_books',array('appointment_id'=>$obj['appointment_id']))->result();
		$res = [];
		//$q->book_appointment = $this->db->get_where('mech_appointment_books',array('quote_id'=>$q->quote_id));
		
		//$q['service_items'] =$this->db->get_where('mech_repair_service_items',array('quote_id'=>$q['appointment_id']))->result();
		//$q['service_items'] = $this->mdl_user_quotes->get_service_name($q['quote_id']);
		$q['quote_id'] = $app->quote_id;
		$q['appointment_id'] = $obj['appointment_id'];
		$q['app_track'] = $this->mdl_user_quotes->get_track($app->quote_id,$obj['appointment_id'],'asc');
		$q['current_track_status'] = $app->current_track_status;
		$q['is_payment_enable'] = $app->is_payment_enable;
		$q['pickup_address'] = $app->pickup_address; //$this->mdl_user_address->get_user_complete_address($app->pickup_address);
		$q['pickup_date'] = $app->pickup_date;
		$q['pickup_time'] = $app->pickup_time;
		$q['delivery_address'] = $app->delivery_address; //$this->mdl_user_address->get_user_complete_address($app->delivery_address);
		$q['delivery_date'] = $app->delivery_date;
		$q['delivery_time'] = $app->delivery_time;
		$q['payment_request_amount'] = $app->payment_request_amount;
		//$q['service_items'] = $query->result();
		//$q->app_track = $this->db->get_where('mech_appointment_books',array('quote_id'=>$q->quote_id))->result();
		array_push($res, $q);
		echo json_encode($res[0]);

	}

	public function updatepayment_post(){

		$json = file_get_contents('php://input');
        $obj = json_decode($json, TRUE);

		$payment = array(
				'quote_id' => $obj['quote_id'],
				'payment_methord_id' => $obj['payment_method_id'],
				'payment_amount' => $obj['amount'],
				'user_id' => $obj['user_id'],
				'payment_note'=> $obj['payment_note'],
				'online_payment_ref_no' => ($obj['payment_id'] ? $obj['payment_id'] : '-')
		);

		$this->db->insert('mech_payments',$payment);

		$this->db->set('total_paid_amount', 'total_paid_amount + '.$obj['amount'], FALSE);
		$this->db->set('total_due_amount', 'total_due_amount - '.$obj['amount'], FALSE);
		$this->db->where('quote_id',$obj['quote_id']);
		$this->db->update('mech_quotes');

		$this->db->select('total_due_amount');
		$due = $this->db->get_where("mech_quotes",array('quote_id'=>$this->input->post('quote_id')))->row();
		
		if($due->total_due_amount == 0.00){
			$this->db->set('is_payment_enable', 'F');
			$this->db->where('quote_id',$this->input->post('quote_id'));
			$this->db->update('mech_appointment_books');
		}


		
		$mobile_no = $obj['mobile'];
		$txt = 'Payment of Rs.'.$obj['amount'].' received for your MechPoint appointment no.'.
				$obj['appointment_no'];
	
		$sms = send_sms($mobile_no,$txt);

		if($sms->status == "success"){
            $db_sms_array = array(
                'user_id' => $this->session->userdata('user_id'),
                'name' => $this->session->userdata('user_name'),
                'email_id' => $this->session->userdata('user_name'),
                'mobile_number' => $mobile_no,
                'message' => $txt,
                'type' => 3,
                'status' => 'S',
                'created_on' => date('Y-m-d H:m:s')

            ); 
        }else{
            $db_sms_array = array(
                'user_id' => $this->session->userdata('user_id'),
                'name' => $this->session->userdata('user_name'),
                'email_id' => $this->session->userdata('user_name'),
                'mobile_number' => $mobile_no,
                'message' => $txt,
                'type' => 3,
                'status' => 'F',
                'created_on' => date('Y-m-d H:m:s')
            ); 
        }

        $this->db->insert('tc_sms_log', $db_sms_array);

		$response = array(
                'success' => 1,
            );
            
		echo json_encode($response);
	}




	public function updatepickup_post(){
		$json = file_get_contents('php://input');
        $obj = json_decode($json, TRUE);


		$quote_id = $obj['quote_id'];

		$status = $this->mdl_user_quotes->get_track_status($quote_id,'current');

		$originalDate = $obj['pickup_date'];
		$originalDate = str_replace('/', '-', $originalDate);
		$pickup_date = date("Y-m-d", strtotime($originalDate));

		//print_r();

		if($status[0]['track_status_id'] < 3)
		{
			$status = array(
				'pickup_address'=>$obj['pickup_address'],
				'pickup_date'=> $pickup_date,
				'pickup_time' =>$obj['pickup_time']
			);

			$this->db->where('quote_id', $quote_id);
			$this->db->update('mech_appointment_books', $status);
			//$this->db->insert('mech_service_tracking_details', $status);
			//xecho $this->qoute_id ;
			$response = array(
	                'success' => 1,
	            );
		
		} else {
			$response = array(
				'success' => 0,
				'reason'=>'Team on the way',	
			);
		}	
		
		echo json_encode($response);
	}

	
	public function updatedelivery_post(){
		$json = file_get_contents('php://input');
        $obj = json_decode($json, TRUE);

		//log_message('error', print_r($obj));

		$appointment_id = $obj['appointment_id'];

		$status = $this->mdl_user_quotes->get_track_status_by_app($appointment_id,'current');

		if(isset($status[0]))
		{
			$originalDate = $obj['delivery_date'];
			$originalDate = str_replace('/', '-', $originalDate);
			$delivery_date = date("Y-m-d", strtotime($originalDate));

			if($status[0]['track_status_id'] > 5)
			{
				$status = array(
				'delivery_address'=>$obj['delivery_address'],
				'delivery_date'=> $delivery_date,
				'delivery_time' =>$obj['delivery_time'],
				'delivery_comments'=> $obj['delivery_comments'],
				'delivery_updated_by'=> $obj['user_id']
			);



			$this->db->join('user_data', 'user.id = user_data.id');
			//$this->db->set($data);	
			$this->db->where('appointment_id', $appointment_id);
			$this->db->update('mech_appointment_books', $status);
			//$this->db->insert('mech_service_tracking_details', $status);
			//xecho $this->qoute_id ;
			$response = array(
	                'success' => 1,
	            );
			} else {
				$response = array(
					'success' => 0,
					'reason'=>'Service in Progress',	
				);
			}	
		} else {
				$response = array(
					'success' => 0,
					'reason'=>'quote not found',	
				);	
		}

		
		//exit();

		
		
		echo json_encode($response);
	}
}