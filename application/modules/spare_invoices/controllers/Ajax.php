<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


class Ajax extends Admin_Controller
{
    public $ajax_controller = true; 
	public $qoute_id;
	
	public function __construct()
    {
        parent::__construct();

		$this->load->model('user_quotes/mdl_user_quotes');
		$this->load->model('spare_invoices/mdl_spare_invoice');
		$this->load->model('settings/mdl_settings');
		$this->load->model('mech_item_master/mdl_mech_item_master'); 
		$this->load->model('products/mdl_products');
		$this->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');
		$this->load->model('spare_invoices/mdl_spare_postfeedback');
		$this->load->model('mech_payments/mdl_mech_payments');
	}
	
    public function invoice_save()
	{

		// print_r($_REQUEST);
		// exit();

		$datas = array();
		$work_shop_id = $this->session->userdata('work_shop_id');
		$branch_id = $this->session->userdata('branch_id');
		$invoice_status = $this->input->post('invoice_status');
		$btn_status = $this->input->post('btn_status');
		$advance_paid_amount = $this->input->post('advance_paid_amount')?$this->input->post('advance_paid_amount'):0;
		$total_due_amount = $this->input->post('total_due_amount')?$this->input->post('total_due_amount'):0;
		$grand_total = $this->input->post('appointment_grand_total')?$this->input->post('appointment_grand_total'):0;
		if($this->input->post('invoice_id')){
			$invoice_id = $this->input->post('invoice_id');
			
			$payment_query = $this->db->query("
								select DISTINCT
(select IFNULL(SUM(payment_amount),0) from mech_payments where entity_id = ".$this->db->escape($invoice_id)." and entity_type = 'invoice') as invoice_amount from mech_payments where workshop_id = ".$work_shop_id." AND w_branch_id=".$branch_id."")->row();
       
			$total_paid_amount = ($payment_query->invoice_amount?$payment_query->invoice_amount:0) + ($payment_query->jobcard_amount?$payment_query->jobcard_amount:0) + ($advance_paid_amount?$advance_paid_amount:0);
			$total_due_amount_save = $total_due_amount;

		}else{
			$invoice_id = NULL;
			$total_paid_amount = 0 + $advance_paid_amount;
			$total_due_amount_save = $grand_total - $advance_paid_amount;
		}

		if($this->input->post('invoice_status') != 'FP'){			
			if($btn_status == 'G'){
				if($this->input->post('invoice_id')){
					if($total_paid_amount == 0 || $total_paid_amount == 0.00 || $total_paid_amount == '0' || $total_paid_amount == '0.00'){
						$invoice_status = 'P';
					}elseif($total_paid_amount < $this->input->post('appointment_grand_total')){
						$invoice_status = 'PP';
					}elseif($total_paid_amount === $this->input->post('appointment_grand_total')){
						$invoice_status = 'FP';
					}else{
						$invoice_status = 'P';
					}
				}else{
					if($this->input->post('jobsheet_no')){
						if($total_paid_amount == 0 || $total_paid_amount == 0.00 || $total_paid_amount == '0' || $total_paid_amount == '0.00'){
							$invoice_status = 'P';
						}else if($total_paid_amount < $this->input->post('appointment_grand_total')){
							$invoice_status = 'PP';
						}elseif($total_paid_amount === $this->input->post('appointment_grand_total')){
							$invoice_status = 'FP';
						}else{
							$invoice_status = 'P';
						}
					}else{
						$invoice_status = 'P';
					}
				}
			}else{
				$invoice_status = 'D';
			}
		}


		// if($this->input->post('invoice_no')){
		// 	$invoice_no = $this->input->post('invoice_no');
		// }else{
		// 	if($btn_status == 'G'){
		// 		$group_no = $this->mdl_settings->getquote_book_no('invoice');
		// 		if($group_no == 0){
		// 		    $response = array(
		// 		        'success' => '2',
		// 		        'validation_errors' => array(
		// 		            'invoice_no' => 'empty',
		// 		        )
		// 		    );
				    
		// 		    echo json_encode($response);
		// 		    exit;
		// 		}else{
		// 		    $invoice_no = $this->mdl_settings->get_invoice_number($group_no);
		// 		}
		// 	}else{
		// 		$invoice_no = NULL;
		// 	}
		// }
		
		if($this->input->post('invoice_no')){
			$invoice_no = $this->input->post('invoice_no');
		}else{
			if($btn_status == 'G'){
				$invoice_no = $this->mdl_settings->get_invoice_number($this->input->post('invoice_group_id'));
			}else{
				$invoice_no = NULL;
			}
		}
		
		$quote_id = ($this->input->post('quote_id'))?$this->input->post('quote_id'):NULL;
		$customer_id = $this->input->post('customer_id');
		$mm_csrf = $this->input->post('_mm_csrf');

		$product_items = json_decode($this->input->post('product_items'));
		$product_totals =  (object) json_decode($this->input->post('product_totals'),TRUE)[0]; 

		if($this->mdl_spare_invoice->run_validation('validation_rules')){

			if(count($product_items) <= 0){
				$data['one'] = "No data";
			}

			if(count($data) > 0){
				$response = array(
					'success' => 3,
					'msg' => 'add items'
				);
				echo json_encode($response);
				exit;
			}
			
			$data = array(
				'invoice_category' => 'I', 
				'branch_id' => ($this->input->post('branch_id'))?$this->input->post('branch_id'):NULL,
				'quote_id' => ($this->input->post('quote_id'))?$this->input->post('quote_id'):NULL,
				'invoice_group_id' => ($this->input->post('invoice_group_id'))?$this->input->post('invoice_group_id'):NULL,
				'quote_id' => $quote_id,
				'invoice_no' => $invoice_no,
				'invoice_date' => $this->input->post('invoice_date')?date_to_mysql($this->input->post('invoice_date')):date('d/m/Y'),
				'customer_id' => $customer_id,
				'user_address_id' => $this->input->post('user_address_id')?$this->input->post('user_address_id'):NULL,
				'visit_type' => 'W',
				'refered_by_type' => $this->input->post('refered_by_type')?$this->input->post('refered_by_type'):NULL,
				'refered_by_id' => $this->input->post('refered_by_id')?$this->input->post('refered_by_id'):NULL,
				'is_credit' => $this->input->post('is_credit')?$this->input->post('is_credit'):'N',
				'payment_method_id' => $this->input->post('payment_method_id')?$this->input->post('payment_method_id'):NULL,
				'cheque_no' =>  $this->input->post('cheque_no')?$this->input->post('cheque_no'):NULL,
                'cheque_to' =>  $this->input->post('cheque_to')?$this->input->post('cheque_to'):NULL,
                'bank_name' => $this->input->post('bank_name')?$this->input->post('bank_name'):NULL,
				'online_payment_ref_no' => $this->input->post('online_payment_ref_no')?$this->input->post('online_payment_ref_no'):NULL,
				'payment_date' => $this->input->post('payment_date')?date_to_mysql($this->input->post('payment_date')):date('d/m/Y'),
				'invoice_date_created' => date('Y-m-d'),
				'in_days' => $this->input->post('in_days')?$this->input->post('in_days'):NULL,
				'invoice_date_due' => $this->input->post('invoice_date_due')?date_to_mysql($this->input->post('invoice_date_due')):NULL,
				'applied_rewards' => $this->input->post('applied_rewards')?$this->input->post('applied_rewards'):NULL,
				'parts_discountstate' => $this->input->post('parts_discountstate')?strip_tags($this->input->post('parts_discountstate')):NULL,

				'product_user_total' => $product_totals->total_usr_lbr_price?$product_totals->total_usr_lbr_price:0,
				'product_mech_total' => $product_totals->total_mech_lbr_price?$product_totals->total_mech_lbr_price:0,
				'product_total_discount' => $product_totals->total_item_discount?$product_totals->total_item_discount:0,
				'product_total_taxable' => $this->input->post('product_total_taxable')?$this->input->post('product_total_taxable'):0,
				'product_total_gst' => $productgrandtotal,
				'product_grand_total' => $product_totals->total_item_total_amount?$product_totals->total_item_total_amount:0,

				'total_taxable_amount' => $this->input->post('total_taxable_amount')?$this->input->post('total_taxable_amount'):0,
				'total_tax_amount' => $this->input->post('total_tax_amount')?$this->input->post('total_tax_amount'):0,
				'earned_amount'=> $this->input->post('earned_amount')?$this->input->post('earned_amount'):0,
				'grand_total'=> $this->input->post('appointment_grand_total')?$this->input->post('appointment_grand_total'):0,
				'total_due_amount' => $total_due_amount_save,
				'total_paid_amount' => $total_paid_amount,
				'advance_paid' => $this->input->post('advance_paid_amount')?$this->input->post('advance_paid_amount'):0,
				'invoice_status' => $invoice_status,
				'mode_of_payment' => $this->input->post('mode_of_payment')?$this->input->post('mode_of_payment'):NULL,
				'description' => $this->input->post('description')?strip_tags($this->input->post('description')):NULL,
				'bank_id' => $this->input->post('bank_id')?$this->input->post('bank_id'):NULL
			);
			$invoice_id = $this->mdl_spare_invoice->save($invoice_id, $data);

			if($this->input->post('customer_id')){
				$this->db->select("client_name,client_email_id,client_contact_no,is_new_customer");	
				$this->db->from('mech_clients');
				$this->db->where('client_id', $customer_id);
				$this->db->where('workshop_id', $work_shop_id);
				$client_details = $this->db->get()->row();
				if($client_details->is_new_customer == "Y"){
					$rewards_id = $this->mdl_settings->calculate_referral_points($customer_id);
				}			
			}

			if(count($product_items) > 0){
				foreach ($product_items as $product) {
					$expiry_date = NULL;
					$expiry_kilometer = NULL;
					$item_product_id = NULL;
					if(!empty($product->item_product_id)) {
						if(!empty($product->mon_from) && $product->mon_from != NULL){
							$expiry_date = date("Y-m-d",strtotime(date("Y-m-d", strtotime(date_to_mysql($this->input->post('invoice_date')))) . " +$product->mon_from month"));
						}
						if(!empty($product->kilo_from) && $product->kilo_from != NULL){
							$expiry_kilometer = intval($this->input->post('current_odometer_reading')) + $product->kilo_from;
						}
						if($product->service_item_type == "C"){
							$item_product_id = $product->subpro_id;
						}else{
							$item_product_id = $product->item_product_id;
						}
						
						$product_array = array(
							'quote_id' =>$quote_id,
							'invoice_id' => $invoice_id,
							'user_id' => $customer_id,
							'is_from' => 'invoice_product',
							'service_item' => $item_product_id,
							// 'service_item_type' => $product->service_item_type,
							// 'item_product_name' => $product->item_product_name,
							'tax_id' => $product->gst_spare?$product->gst_spare:0,
							'user_item_price' => $product->usr_lbr_price?$product->usr_lbr_price:0,
							'mech_item_price' => $product->mech_lbr_price?$product->mech_lbr_price:0,
							'item_hsn' => $product->item_hsn?$product->item_hsn:NULL,
							'item_qty' => $product->product_qty?$product->product_qty:1,
							'item_amount' => $product->item_amount?$product->item_amount:0,
							'item_discount' => $product->item_discount?$product->item_discount:0,
							'item_discount_price' => $product->item_discount_price?$product->item_discount_price:0,
							'igst_pct'=> $product->igst_pct?$product->igst_pct:0,
							'igst_amount'=> $product->igst_amount?$product->igst_amount:0,
							'cgst_pct'=> $product->cgst_pct?$product->cgst_pct:0,
							'cgst_amount'=> $product->cgst_amount?$product->cgst_amount:0,
							'sgst_pct'=> $product->sgst_pct?$product->sgst_pct:0,
							'sgst_amount'=> $product->sgst_amount?$product->sgst_amount:0,
							'expiry_date' => $expiry_date?$expiry_date:NULL,
							'expiry_kilometer' => $expiry_kilometer?$expiry_kilometer:NULL,
							'warrentry_prd'=> $product->warrentry_prd?$product->warrentry_prd:NULL,
							'item_total_amount'=> $product->item_total_amount?$product->item_total_amount:0,
							'created_on'=>date('Y-m-d H:i:s'),
							'created_by'=>$this->session->userdata('user_id'),
							'modified_by'=>$this->session->userdata('user_id'),
							'workshop_id' => $this->session->userdata('work_shop_id'),
							'w_branch_id' => $this->session->userdata('branch_id')
						);
						if(isset($product->item_id)){
							$this->db->where('item_id', $product->item_id);
							$product_id = $this->db->update('spare_invoice_item', $product_array);
						}else{
							$product_id = $this->db->insert('spare_invoice_item', $product_array);
						}
						$inventory_data = array(
							'product_id' => $item_product_id,
							'stock_type' => 1,
							'quantity' => $product->product_qty,
							'price' => $product->usr_lbr_price?$product->usr_lbr_price:0,
							'stock_date' => $this->input->post('invoice_date')?date_to_mysql($this->input->post('invoice_date')):date('Y-m-d'),
							'description' => "Invoice stock",
							'action_type' => 2,
							'entity_id' => $invoice_id
						);
						$status = $this->mdl_mech_item_master->save_inventory($inventory_data);
					}else {
								// Throw an error message and use the form validation for that
						$this->load->library('form_validation');
						$this->form_validation->set_rules('product_item', trans('product'), 'required');
						$this->form_validation->run();
			
						$response = array(
							'success' => 0,
							'validation_errors' => array(
								'product_item' => form_error('product_item', '', ''),
							)
						);
			
						echo json_encode($response);
						exit;
					}
				}
			}

			if($this->input->post('applied_rewards') == 'Y'){
				if($this->input->post('invoice_id') == NULL && $this->input->post('invoice_id') == ''){
					$rewards_history = array(
						'rewards_id' => ($this->input->post('rewards_id'))?$this->input->post('rewards_id'):NULL,
						'branch_id' => ($this->input->post('branch_id'))?$this->input->post('branch_id'):NULL,
						'entity_id' => $invoice_id,
						'entity_type' => 'I',
						'customer_id' => $customer_id,
						'old_amount' => $this->input->post('appointment_grand_total')?$this->input->post('appointment_grand_total'):0,
						'earned_amount' => $this->input->post('earned_amount')?$this->input->post('earned_amount'):0,
						'total_current_amount' => $this->input->post('appointment_grand_total')?$this->input->post('appointment_grand_total'):0,
						'created_on' => date('Y-m-d H:i:s'),
						'created_by' => $this->session->userdata('user_id'),
						'modified_by' => $this->session->userdata('user_id'),
					);
					$referral_history_id = $this->db->insert('mech_rewards_history', $rewards_history);
				}
			}
			
			$invoice = $this->mdl_spare_invoice->get_by_id($invoice_id);	

			if($invoice){

				if($invoice_status != "D" && $this->input->post('is_credit') == "N" && ( $invoice->total_due_amount > 0  )&& ( $invoice->total_paid_amount != $this->input->post('appointment_grand_total') )){
					$payvalue = $this->input->post('appointment_grand_total') - $invoice->total_paid_amount;
					$_POST['entity_id'] = $invoice_id;
					$_POST['entity_type'] = 'invoice';
					$_POST['payment_method_id'] = $this->input->post('payment_method_id')?$this->input->post('payment_method_id'):NULL;
					$_POST['invoice_amount'] = $this->input->post('appointment_grand_total')?$this->input->post('appointment_grand_total'):0;
					$_POST['payment_amount'] = $payvalue;
					$_POST['customer_id'] = $customer_id;
					$_POST['online_payment_ref_no'] = $this->input->post('online_payment_ref_no')?$this->input->post('online_payment_ref_no'):NULL;
					$_POST['paid_on'] = $this->input->post('payment_date')?$this->input->post('payment_date'):date('d/m/Y');
					if ($this->mdl_mech_payments->run_validation()) {
						$db_array = $this->mdl_mech_payments->db_array();
						$id = $this->mdl_mech_payments->save(null, $db_array);
					}
				}
			}

			if(!empty($invoice->client_contact_no) && count($invoice->client_contact_no) == 10){

				if($this->input->post('invoice_status') == "P" && $this->session->userdata('generated_I_S') == 1){
					$txt = $invoice->client_name."Invoice is pending";
				}else if($this->input->post('invoice_status') == "PP" && $this->session->userdata('partially_paid_I_S') == 1 ){
					$txt = $invoice->client_name."Invoice has been partially paid";
				}else if($this->input->post('invoice_status') == "FP" && $this->session->userdata('paid_I_S') == 1){
					$txt = $invoice->client_name."Invoice has been paid";
				}else{
					$txt = $invoice->client_name."Invoice has been raised";
				}

				// $sms = send_sms(htmlspecialchars($invoice->client_contact_no),$txt);
				
				if($sms->status == "success"){
                    $db_sms_array = array(
                        'user_id' => $this->session->userdata('user_id'),
                        'name' => $invoice->client_name,
                        'email_id' => $invoice->client_email_id,
                        'mobile_number' => $invoice->client_contact_no,
                        'message' => $txt,
                        'type' => 3,
                        'status' => 'S',
                        'created_on' => date('Y-m-d H:m:s')
                    ); 
                }else{
                    $db_sms_array = array(
                        'user_id' => $this->session->userdata('user_id'),
                        'name' => $invoice->client_name,
                        'email_id' => $invoice->client_email_id,
                        'mobile_number' => $invoice->client_contact_no,
                        'message' => $txt,
                        'type' => 3,
                        'status' => 'F',
                        'created_on' => date('Y-m-d H:m:s')
                    ); 
                }
                $this->db->insert('tc_sms_log', $db_sms_array);
				
			}

			$response = array(
				'success' => 1,
				'invoice_id' => $invoice_id
			);
			
		}else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
        }

        echo json_encode($response);
		exit();
	}

    public function modal_generate_invoice()
    {
		$this->load->module('layout');
		$data = array(
			'quote_detail' =>$this->mdl_user_quotes->where('is_ready_for_billing="Y"')->get()->result()
		);
        $this->layout->load_view('spare_invoices/modal_generate_invoice', $data);
    }
    
    public function delete_item(){
        $item_id = $this->input->post('item_id');
        $this->db->where('item_id', $item_id);
        $this->db->delete('spare_invoice_item');
        $response = array(
            'success' => 1
        );
        echo json_encode($response);
    }
    
    public function delete(){
        $document_id = $this->input->post('document_id');
        $this->db->set('status','D');
        $this->db->where('invoice_id', $document_id);
        $this->db->update('spare_invoice');
        $response = array(
            'success' => 1
        );
        echo json_encode($response);
    }
	
	public function modal_add_feedback($invoice_id = NULL){
		$this->load->module('layout');
		$work_shop_id = $this->session->userdata('work_shop_id');
		$branch_id = $this->session->userdata('branch_id');

		if($invoice_id){

			$this->db->select('*');
            $this->db->from('spare_postfeedback');
			$this->db->where('workshop_id' , $work_shop_id);
			$this->db->where('w_branch_id' , $branch_id );
            $this->db->where('invoice_id', $invoice_id);
			$feedback_details = $this->db->get()->row();

			if(empty($feedback_details)){
				$feedback_details = array();
			}

			$data = array(
				'feedback_details' => $feedback_details,
				'invoice_id' => $invoice_id,
			);
			$this->layout->load_view('spare_invoices/modal_add_feedback', $data);
		}
	}

	public function add_feedback(){

		$this->load->model('spare_invoices/mdl_spare_postfeedback');
		if($this->input->post('fb_id')){
			$fb_id = $this->input->post('fb_id');
		}else{
			$fb_id = NULL;
		}
		
		if($this->mdl_spare_postfeedback->run_validation('validation_rules')){
			$fb_id = $this->mdl_spare_postfeedback->save($fb_id);
			$response = array(
                'success' => 1,
                'fb_id' => $fb_id,
            );
		}else{
			$this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors(),
            );
		}
		echo json_encode($response);
		exit();

	}

	public function get_filter_list(){

        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
		$limit = 15;
		
		if($this->input->post('invoice_from_date')){
            $this->mdl_spare_invoice->where('spare_invoice.invoice_date >=', date_to_mysql($this->input->post('invoice_from_date')));
        }

        if($this->input->post('invoice_to_date')){
            $this->mdl_spare_invoice->where('spare_invoice.invoice_date <=', date_to_mysql($this->input->post('invoice_to_date')));
        }

        if($this->input->post('invoice_no')){
            $this->mdl_spare_invoice->like('spare_invoice.invoice_no', trim($this->input->post('invoice_no')));
        }

        if($this->input->post('customer_id')){
            $this->mdl_spare_invoice->where('spare_invoice.customer_id', trim($this->input->post('customer_id')));
        }

        if($this->input->post('invoice_status')){
            $this->mdl_spare_invoice->where('spare_invoice.invoice_status', trim($this->input->post('invoice_status')));
        }

        if($this->input->post('branch_id')){
            $this->mdl_spare_invoice->where('spare_invoice.branch_id', trim($this->input->post('branch_id')));
        }

        $rowCount = $this->mdl_spare_invoice->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

		if($this->input->post('invoice_from_date')){
            $this->mdl_spare_invoice->where('spare_invoice.invoice_date >=', date_to_mysql($this->input->post('invoice_from_date')));
        }

        if($this->input->post('invoice_to_date')){
            $this->mdl_spare_invoice->where('spare_invoice.invoice_date <=', date_to_mysql($this->input->post('invoice_to_date')));
        }

        if($this->input->post('invoice_no')){
            $this->mdl_spare_invoice->like('spare_invoice.invoice_no', trim($this->input->post('invoice_no')));
        }

        if($this->input->post('customer_id')){
            $this->mdl_spare_invoice->where('spare_invoice.customer_id', trim($this->input->post('customer_id')));
        }

        if($this->input->post('invoice_status')){
            $this->mdl_spare_invoice->where('spare_invoice.invoice_status', trim($this->input->post('invoice_status')));
        }

        if($this->input->post('branch_id')){
            $this->mdl_spare_invoice->where('spare_invoice.branch_id', trim($this->input->post('branch_id')));
        }
        $this->mdl_spare_invoice->limit($limit,$start);
		$mech_invoices = $this->mdl_spare_invoice->get()->result();   

        $response = array(
            'success' => 1,
            'mech_invoices' => $mech_invoices, 
			'createLinks' => $createLinks,
			'user_type' => $this->session->userdata('user_type'),
			'invoice_E' => $this->session->userdata('invoice_E'),
			'is_product' => ($this->db->query("SELECT is_product FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND created_by = ".$this->session->userdata('user_id')." ")->row()->is_product),
        );
        echo json_encode($response);
    }
    
}
