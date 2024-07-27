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
		$this->load->model('mech_quotes/mdl_mech_quotes');
		$this->load->model('settings/mdl_settings');
		$this->load->model('mech_item_master/mdl_mech_item_master');
		$this->load->model('products/mdl_products');
		$this->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls');
		$this->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');
	}
	
    public function quote_save()
	{   
		$datas = array();
		$work_shop_id = $this->session->userdata('work_shop_id');
		$branch_id = $this->session->userdata('branch_id');
		$quote_status = $this->input->post('quote_status');
		if($this->input->post('quote_id')){
			$quote_id = $this->input->post('quote_id');
		}else{
			$quote_id = NULL;
		}

		// if($this->input->post('quote_no')){
		// 	$quote_no = $this->input->post('quote_no');
		// }else{
		// 	if($quote_status == 'G'){
		// 		$group_no = $this->mdl_settings->getquote_book_no('quote');
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
		// 		    $quote_no = $this->mdl_settings->get_invoice_number($group_no);
		// 		}
		// 	}else{
		// 		$quote_no = NULL;
		// 	}
		// }

		if($this->input->post('quote_no')){
			$quote_no = $this->input->post('quote_no');
	    }else{
			if($quote_status == 'G'){
				$quote_no = $this->mdl_settings->get_invoice_number($this->input->post('invoice_group_id'));
			}else{
				$quote_no = NULL;
			}
		}
		
		$customer_id = $this->input->post('customer_id');
		$mm_csrf = $this->input->post('_mm_csrf');
		$product_items = json_decode($this->input->post('product_items'));
		$service_items = json_decode($this->input->post('service_items'));

		$service_package_items = json_decode($this->input->post('service_package_items'));
		$service_package_totals = json_decode($this->input->post('service_package_totals'));

		$product_totals =  (object) json_decode($this->input->post('product_totals'),TRUE)[0];
		$service_totals =  (object) json_decode($this->input->post('service_totals'),TRUE)[0];
		$data = array();
		if($this->mdl_mech_quotes->run_validation('validation_rules')){

			if(count($service_items) <= 0){
				$data['one'] = "No data";
			}

			if(count($service_package_items) <= 0){
				$data['two'] = "No data";
			}
	
			if(count($product_items) <= 0){
				$data['three'] = "No data";
			}

			if(count($data) > 2){
				$response = array(
					'success' => 3,
					'msg' => 'please add the items'
				);
				echo json_encode($response);
				exit;
			}
			
			$data = array(
				'branch_id' => ($this->input->post('branch_id'))?$this->input->post('branch_id'):NULL,
				'shift' => ($this->input->post('shift'))?$this->input->post('shift'):NULL,
				'purchase_no' => ($this->input->post('purchase_no'))?$this->input->post('purchase_no'):NULL,
				'invoice_group_id' => ($this->input->post('invoice_group_id'))?$this->input->post('invoice_group_id'):NULL,
				'current_odometer_reading' => $this->input->post('current_odometer_reading')?$this->input->post('current_odometer_reading'):NULL,
				'quote_no' => $quote_no,
				'quote_date' => $this->input->post('quote_date')?date_to_mysql($this->input->post('quote_date')):NULL,
				'customer_id' => $customer_id,
				'customer_car_id' => $this->input->post('customer_car_id')?$this->input->post('customer_car_id'):NULL,
				'user_address_id' => $this->input->post('user_address_id')?$this->input->post('user_address_id'):NULL,
				'refered_by_type' => $this->input->post('refered_by_type')?$this->input->post('refered_by_type'):NULL,
				'refered_by_id' => $this->input->post('refered_by_id')?$this->input->post('refered_by_id'):NULL,
				'quote_terms_condition' => $this->input->post('quote_terms_condition')?strip_tags($this->input->post('quote_terms_condition')):NULL,

				'parts_discountstate' => $this->input->post('parts_discountstate')?strip_tags($this->input->post('parts_discountstate')):NULL,
				'service_discountstate' => $this->input->post('service_discountstate')?strip_tags($this->input->post('service_discountstate')):NULL,
				'service_user_total' => $service_totals->total_usr_lbr_price?$service_totals->total_usr_lbr_price:0,
				'service_mech_total' => $service_totals->total_mech_lbr_price?$service_totals->total_mech_lbr_price:0,
				'service_total_discount' => $this->input->post('service_total_discount')?$this->input->post('service_total_discount'):0,
				'service_total_discount_pct' => $this->input->post('service_discount_pct')?$this->input->post('service_discount_pct'):0,
				'service_total_taxable' => $this->input->post('service_total_taxable')?$this->input->post('service_total_taxable'):0,
				'service_total_gst_pct' => $this->input->post('service_tax_pct')?$this->input->post('service_tax_pct'):0,
				'service_total_gst' => $this->input->post('total_servie_gst_price')?$this->input->post('total_servie_gst_price'):0,
				'service_grand_total' => $this->input->post('total_service_amount')?$this->input->post('total_service_amount'):0,
				
				'packagediscountstate' => $this->input->post('packagediscountstate')?$this->input->post('packagediscountstate'):NULL,
				'service_package_user_total' => $this->input->post('service_package_user_total')?$this->input->post('service_package_user_total'):0,
				'service_package_total_discount_pct' => $this->input->post('service_package_total_discount_pct')?$this->input->post('service_package_total_discount_pct'):0,
				'service_package_total_discount' => $this->input->post('service_package_total_discount')?$this->input->post('service_package_total_discount'):0,
				'service_package_total_taxable' => $this->input->post('service_package_total_taxable')?$this->input->post('service_package_total_taxable'):0,
				'service_package_total_gst_pct' => $this->input->post('service_package_total_gst_pct')?$this->input->post('service_package_total_gst_pct'):0,
				'service_package_total_gst' => $this->input->post('service_package_total_gst')?$this->input->post('service_package_total_gst'):0,
				'service_package_grand_total' => $this->input->post('service_package_grand_total')?$this->input->post('service_package_grand_total'):0,
				'service_package_mech_total' => $service_package_totals[0]->total_mech_lbr_price?$service_package_totals[0]->total_mech_lbr_price:0,

				'product_user_total' => $product_totals->total_usr_lbr_price?$product_totals->total_usr_lbr_price:0,
				'product_mech_total' => $product_totals->total_mech_lbr_price?$product_totals->total_mech_lbr_price:0,
				'product_total_discount' => $product_totals->total_item_discount?$product_totals->total_item_discount:0,
				'product_total_taxable' => $this->input->post('product_total_taxable')?$this->input->post('product_total_taxable'):0,
				'product_total_gst' => $productgrandtotal,
				'product_grand_total' => $product_totals->total_item_total_amount?$product_totals->total_item_total_amount:0,

				'total_taxable_amount' => $this->input->post('total_taxable_amount')?$this->input->post('total_taxable_amount'):0,
				'total_tax_amount' => $this->input->post('total_tax_amount')?$this->input->post('total_tax_amount'):0,
				'grand_total'=> $this->input->post('appointment_grand_total')?$this->input->post('appointment_grand_total'):0,
				'total_due_amount' => (($this->input->post('appointment_grand_total')?$this->input->post('appointment_grand_total'):0) - $payment),
				'description' => $this->input->post('description')?strip_tags($this->input->post('description')):NULL,
				'quote_status' => $quote_status
			);
			$quote_id = $this->mdl_mech_quotes->save($quote_id, $data);

			foreach ($service_items as $service) {
				$expiry_date_ser = NULL;
				$expiry_kilometer = NULL;
				if (!empty($service->item_service_id)) {
					if(!empty($service->mon_from) && $service->mon_from != NULL){
						$expiry_date_ser = date("Y-m-d",strtotime(date("Y-m-d", strtotime(date_to_mysql($this->input->post('quote_date')))) . " +$service->mon_from month"));
					}
					if(!empty($service->kilo_from) && $service->kilo_from != NULL){
						$expiry_kilometer = (int)$this->input->post('current_odometer_reading') + (int)$service->kilo_from;
					}
					$service_array = array(
						'quote_id' => $quote_id,
						'user_id' => $customer_id,
						'is_from' => 'quote_service',
						'service_item' => $service->item_service_id,
						'item_hsn' => $service->item_hsn?$service->item_hsn:NULL,
						'user_item_price' => $service->usr_lbr_price?$service->usr_lbr_price:0,
						'mech_item_price' => $service->mech_lbr_price?$service->mech_lbr_price:0,
						'item_discount' => $service->item_discount?$service->item_discount:0,
						'item_amount' => $service->item_amount?$service->item_amount:0,
						'item_discount_price' => $service->item_discount_price?$service->item_discount_price:0,
						'tax_id' => $service->gst_service?$service->gst_service:0,
						'igst_pct' => $service->igst_pct?$service->igst_pct:0,
						'igst_amount' => $service->igst_amount?$service->igst_amount:0,
						'cgst_pct' => $service->cgst_pct?$service->cgst_pct:0,
						'cgst_amount' => $service->cgst_amount?$service->cgst_amount:0,
						'sgst_pct' => $service->sgst_pct?$service->sgst_pct:0,
						'sgst_amount' => $service->sgst_amount?$service->sgst_amount:0,
						'expiry_date' => $expiry_date_ser?$expiry_date_ser:NULL,
						'expiry_kilometer' => $expiry_kilometer?$expiry_kilometer:NULL,
						'warrentry_prd' => $service->warrentry_prd?$service->warrentry_prd:NULL,
						'item_total_amount' => $service->item_total_amount?$service->item_total_amount:0,
						'created_on' => date('Y-m-d H:i:s'),
						'created_by' => $this->session->userdata('user_id'),
						'modified_by' => $this->session->userdata('user_id'),
						'workshop_id' => $this->session->userdata('work_shop_id'),
						'w_branch_id' => $this->session->userdata('branch_id')
					);
					if(isset($service->item_id)){
						$this->db->where('item_id', $service->item_id);
						$service_id = $this->db->update('mech_quotes_item', $service_array);
					}else{
						$service_id = $this->db->insert('mech_quotes_item', $service_array);
					}
				
				}else {
					$this->load->library('form_validation');
					$this->form_validation->set_rules('service_item', trans('service'), 'required');
					$this->form_validation->run();

					$response = array(
						'success' => 0,
						'validation_errors' => array(
							'service_item' => form_error('service_item', '', ''),
						)
					);

					echo json_encode($response);
					exit;
				}
			}

			foreach ($service_package_items as $service) {
				$expiry_date_ser = NULL;
				$expiry_kilometer = NULL;
				if (!empty($service->item_service_id)) {
					if(!empty($service->mon_from) && $service->mon_from != NULL){
						$expiry_date_ser = date("Y-m-d",strtotime(date("Y-m-d", strtotime(date_to_mysql($this->input->post('quote_date')))) . " +$service->mon_from month"));
					}
					$service_array = array(
						'quote_id' => $quote_id,
						'user_id' => $customer_id,
						'is_from' => 'quote_package',
						'service_item' => $service->item_service_id,
						'item_hsn' => $service->item_hsn?$service->item_hsn:NULL,
						'user_item_price' => $service->usr_lbr_price?$service->usr_lbr_price:0,
						'mech_item_price' => $service->mech_lbr_price?$service->mech_lbr_price:0,
						'item_discount' => $service->item_discount?$service->item_discount:0,
						'item_discount_price' => $service->item_discount_price?$service->item_discount_price:0,
						'igst_pct' => $service->igst_pct?$service->igst_pct:0,
						'igst_amount' => $service->igst_amount?$service->igst_amount:0,
						'cgst_pct' => $service->cgst_pct?$service->cgst_pct:0,
						'cgst_amount' => $service->cgst_amount?$service->cgst_amount:0,
						'sgst_pct' => $service->sgst_pct?$service->sgst_pct:0,
						'sgst_amount' => $service->sgst_amount?$service->sgst_amount:0,
						'expiry_date' => $expiry_date_ser?$expiry_date_ser:NULL,
						'expiry_kilometer' => $expiry_kilometer?$expiry_kilometer:NULL,
						'warrentry_prd' => $service->warrentry_prd?$service->warrentry_prd:NULL,
						'item_total_amount' => $service->item_total_amount?$service->item_total_amount:0,
						'created_on' => date('Y-m-d H:i:s'),
						'created_by' => $this->session->userdata('user_id'),
						'modified_by' => $this->session->userdata('user_id'),
						'workshop_id' => $this->session->userdata('work_shop_id'),
						'w_branch_id' => $this->session->userdata('branch_id')
					);
					if(isset($service->item_id)){
						$this->db->where('item_id', $service->item_id);
						$service_id = $this->db->update('mech_quotes_item', $service_array);
					}else{
						$service_id = $this->db->insert('mech_quotes_item', $service_array);
					}
				
				}else {
					$this->load->library('form_validation');
					$this->form_validation->set_rules('service_item', trans('service'), 'required');
					$this->form_validation->run();

					$response = array(
						'success' => 0,
						'validation_errors' => array(
							'service_item' => form_error('service_item', '', ''),
						)
					);

					echo json_encode($response);
					exit;
				}
			}

			$is_product = $this->db->query("SELECT is_product FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND created_by = ".$this->session->userdata('user_id')." ")->row()->is_product;

			if($is_product == "Y"){
				foreach ($product_items as $product) {
				$expiry_date = NULL;
				$expiry_kilometer = NULL;
				if(!empty($product->item_product_id)) {
					if(!empty($product->mon_from) && $product->mon_from != NULL){
						$expiry_date = date("Y-m-d",strtotime(date("Y-m-d", strtotime(date_to_mysql($this->input->post('quote_date')))) . " +$product->mon_from month"));
					}
					if(!empty($product->kilo_from) && $product->kilo_from != NULL){
						$expiry_kilometer = $this->input->post('current_odometer_reading') + $product->kilo_from;
					}
					$product_array = array(
							'quote_id'=>$quote_id,
							'user_id' => $customer_id,
							'is_from'=>'quote_product',
							'service_item'=>$product->item_product_id,
							'tax_id' => $product->gst_spare?$product->gst_spare:0,
							'user_item_price'=> $product->usr_lbr_price?$product->usr_lbr_price:0,
							'mech_item_price'=> $product->mech_lbr_price?$product->mech_lbr_price:0,
							'item_hsn' => $product->item_hsn?$product->item_hsn:NULL,
							'item_qty'=> $product->product_qty?$product->product_qty:1,
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
							$product_id = $this->db->update('mech_quotes_item', $product_array);
						}else{
							$product_id = $this->db->insert('mech_quotes_item', $product_array);
						}
					}else {
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

			$response = array(
				'success' => 1,
				'quote_id' => $quote_id
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
    
    public function delete_item(){
        $item_id = $this->input->post('item_id');
        $this->db->where('item_id', $item_id);
        $this->db->delete('mech_quotes_item');
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
    
	public function get_filter_list(){
        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;
		if($this->input->post('quote_from_date')){
            $this->mdl_mech_quotes->where('mech_quotes.quote_date >=', date_to_mysql($this->input->post('quote_from_date')));
        }

        if($this->input->post('quote_to_date')){
            $this->mdl_mech_quotes->where('mech_quotes.quote_date <=', date_to_mysql($this->input->post('quote_to_date')));
        }

        if($this->input->post('quote_no')){
            $this->mdl_mech_quotes->like('mech_quotes.quote_no', trim($this->input->post('quote_no')));
        }

        if($this->input->post('customer_id')){
            $this->mdl_mech_quotes->where('mech_quotes.customer_id', trim($this->input->post('customer_id')));
        }

        if($this->input->post('quote_status')){
            $this->mdl_mech_quotes->where('mech_quotes.quote_status', trim($this->input->post('quote_status')));
        }

        if($this->input->post('branch_id')){
            $this->mdl_mech_quotes->where('mech_quotes.branch_id', trim($this->input->post('branch_id')));
        }

		if($this->input->post('vehicle_no')){
            $this->mdl_mech_quotes->like('car.car_reg_no', trim($this->input->post('vehicle_no')));
        }

        $rowCount = $this->mdl_mech_quotes->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

		if($this->input->post('quote_from_date')){
            $this->mdl_mech_quotes->where('mech_quotes.quote_date >=', date_to_mysql($this->input->post('quote_from_date')));
        }

        if($this->input->post('quote_to_date')){
            $this->mdl_mech_quotes->where('mech_quotes.quote_date <=', date_to_mysql($this->input->post('quote_to_date')));
        }

        if($this->input->post('quote_no')){
            $this->mdl_mech_quotes->like('mech_quotes.quote_no', trim($this->input->post('quote_no')));
        }

        if($this->input->post('customer_id')){
            $this->mdl_mech_quotes->where('mech_quotes.customer_id', trim($this->input->post('customer_id')));
        }

        if($this->input->post('quote_status')){
            $this->mdl_mech_quotes->where('mech_quotes.quote_status', trim($this->input->post('quote_status')));
        }

        if($this->input->post('branch_id')){
            $this->mdl_mech_quotes->where('mech_quotes.branch_id', trim($this->input->post('branch_id')));
        }

		if($this->input->post('vehicle_no')){
            $this->mdl_mech_quotes->like('car.car_reg_no', trim($this->input->post('vehicle_no')));
        }
        $this->mdl_mech_quotes->limit($limit,$start);
		$mech_quotes = $this->mdl_mech_quotes->get()->result();  
	
        $response = array(
            'success' => 1,
            'mech_quotes' => $mech_quotes, 
			'createLinks' => $createLinks,
			'user_type' => $this->session->userdata('user_type'),
			'quote_E' => $this->session->userdata('invoice_E'),
			'is_product' => ($this->db->query("SELECT is_product FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND created_by = ".$this->session->userdata('user_id')." ")->row()->is_product),
        );
        echo json_encode($response);
    }

	public function getqutvehiclenos($vehicle_no = Null){
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
