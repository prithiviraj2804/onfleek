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
		$this->load->model('spare_quotes/mdl_spare_quotes');
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
		$product_totals =  (object) json_decode($this->input->post('product_totals'),TRUE)[0];

		if($this->mdl_spare_quotes->run_validation('validation_rules')){
	
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
				'branch_id' => ($this->input->post('branch_id'))?$this->input->post('branch_id'):NULL,
				'invoice_group_id' => ($this->input->post('invoice_group_id'))?$this->input->post('invoice_group_id'):NULL,
				'quote_no' => $quote_no,
				'quote_date' => $this->input->post('quote_date')?date_to_mysql($this->input->post('quote_date')):NULL,
				'customer_id' => $customer_id,
				'user_address_id' => $this->input->post('user_address_id')?$this->input->post('user_address_id'):NULL,
				'refered_by_type' => $this->input->post('refered_by_type')?$this->input->post('refered_by_type'):NULL,
				'refered_by_id' => $this->input->post('refered_by_id')?$this->input->post('refered_by_id'):NULL,
                                'parts_discountstate' => $this->input->post('parts_discountstate')?strip_tags($this->input->post('parts_discountstate')):NULL,
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
			$quote_id = $this->mdl_spare_quotes->save($quote_id, $data);

			if(count($product_items) > 0){
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
							$product_id = $this->db->update('spare_quotes_item', $product_array);
						}else{
							$product_id = $this->db->insert('spare_quotes_item', $product_array);
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
        $this->db->delete('spare_quotes_item');
        $response = array(
            'success' => 1
        );
        echo json_encode($response);
    }
    
    public function delete(){
        $document_id = $this->input->post('document_id');
        $this->db->set('status','D');
        $this->db->where('quote_id', $document_id);
        $this->db->update('spare_quotes');
        $response = array(
            'success' => 1
        );
        echo json_encode($response);
    }
    
	public function get_filter_list(){
        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;
		if($this->input->post('quote_from_date')){
            $this->mdl_spare_quotes->where('spare_quotes.quote_date >=', date_to_mysql($this->input->post('quote_from_date')));
        }

        if($this->input->post('quote_to_date')){
            $this->mdl_spare_quotes->where('spare_quotes.quote_date <=', date_to_mysql($this->input->post('quote_to_date')));
        }

        if($this->input->post('quote_no')){
            $this->mdl_spare_quotes->like('spare_quotes.quote_no', trim($this->input->post('quote_no')));
        }

        if($this->input->post('customer_id')){
            $this->mdl_spare_quotes->where('spare_quotes.customer_id', trim($this->input->post('customer_id')));
        }

        if($this->input->post('quote_status')){
            $this->mdl_spare_quotes->where('spare_quotes.quote_status', trim($this->input->post('quote_status')));
        }

        if($this->input->post('branch_id')){
            $this->mdl_spare_quotes->where('spare_quotes.branch_id', trim($this->input->post('branch_id')));
        }

        $rowCount = $this->mdl_spare_quotes->get()->result();
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
            $this->mdl_spare_quotes->where('spare_quotes.quote_date >=', date_to_mysql($this->input->post('quote_from_date')));
        }

        if($this->input->post('quote_to_date')){
            $this->mdl_spare_quotes->where('spare_quotes.quote_date <=', date_to_mysql($this->input->post('quote_to_date')));
        }

        if($this->input->post('quote_no')){
            $this->mdl_spare_quotes->like('spare_quotes.quote_no', trim($this->input->post('quote_no')));
        }

        if($this->input->post('customer_id')){
            $this->mdl_spare_quotes->where('spare_quotes.customer_id', trim($this->input->post('customer_id')));
        }

        if($this->input->post('quote_status')){
            $this->mdl_spare_quotes->where('spare_quotes.quote_status', trim($this->input->post('quote_status')));
        }

        if($this->input->post('branch_id')){
            $this->mdl_spare_quotes->where('spare_quotes.branch_id', trim($this->input->post('branch_id')));
        }
        $this->mdl_spare_quotes->limit($limit,$start);
		$spare_quotes = $this->mdl_spare_quotes->get()->result();  
	
        $response = array(
            'success' => 1,
            'spare_quotes' => $spare_quotes, 
			'createLinks' => $createLinks,
			'user_type' => $this->session->userdata('user_type'),
			'quote_E' => $this->session->userdata('invoice_E'),
			'is_product' => ($this->db->query("SELECT is_product FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND created_by = ".$this->session->userdata('user_id')." ")->row()->is_product),
        );
        echo json_encode($response);
    }
}
