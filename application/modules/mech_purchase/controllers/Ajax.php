<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true; 
	
	public function purchase_save()
	{
		$this->load->model('mech_purchase/mdl_mech_purchase');
        $this->load->model('mech_item_master/mdl_mech_item_master');
		$this->load->model('products/mdl_products');

		$mm_csrf = $this->input->post('_mm_csrf');

		$product_items = json_decode($this->input->post('product_items'));

		$purchase_id = $this->input->post('purchase_id');
		
        if ($this->mdl_mech_purchase->run_validation()) {
	
			if(count($product_items) <= 0){
				$data['one'] = "No data";
			}

			if(count($data) > 0){
				$response = array(
					'success' => 3,
					'msg' => 'please add the items'
				);
				echo json_encode($response);
				exit;
			}

			// if($this->input->post('purchase_no')){
			// 	$purchase_no = $this->input->post('purchase_no');
			// }else{
			// 	if($this->input->post('purchase_status') != 'D'){
			// 		$group_no = $this->mdl_settings->getquote_book_no('purchase');
			// 		if($group_no == 0){
			// 			$response = array(
			// 				'success' => '1',
			// 				'validation_errors' => array(
			// 				'purchase_no' => 'empty',
			// 				)
			// 			);
						
			// 			echo json_encode($response);
			// 			exit;
			// 		}else{
			// 			$purchase_no = $this->mdl_settings->get_invoice_number($group_no);
			// 		}
			// 	}else{
			// 		$purchase_no = NULL;
			// 	}
			// }

			if($this->input->post('purchase_no')){
				$purchase_no = $this->input->post('purchase_no');
			}else{
				if($this->input->post('purchase_status') != 'D'){
					$purchase_no = $this->mdl_settings->get_invoice_number($this->input->post('invoice_group_id'));
				}else{
					$purchase_no = NULL;
				}
			}

			foreach ($product_items as $product){
    			if (empty($product->item_product_id)){
					$this->load->library('form_validation');
					$this->form_validation->set_rules('product_item', trans('product_item'), 'required');
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
			
    		$db_array = array(
				'supplier_id' => $this->input->post('supplier_id')?$this->input->post('supplier_id'):NULL,
				'w_branch_id' => $this->input->post('w_branch_id')?$this->input->post('w_branch_id'):NULL,
                'purchase_number' => $this->input->post('purchase_number')?$this->input->post('purchase_number'):NULL,
				'purchase_no' => $purchase_no,
				'invoice_group_id' => ($this->input->post('invoice_group_id')?$this->input->post('invoice_group_id'):NULL),
				'url_key' => $this->input->post('url_key'),
                'in_days' => $this->input->post('in_days')?$this->input->post('in_days'):NULL,
                'place_of_supply_id' => $this->input->post('place_of_supply_id')?$this->input->post('place_of_supply_id'):NULL,
				'purchase_type_id' => $this->input->post('purchase_type_id')?$this->input->post('purchase_type_id'):NULL,
				'supplier_gstin' => $this->input->post('supplier_gstin')?$this->input->post('supplier_gstin'):NULL,
                'purchase_date_created' => $this->input->post('purchase_date_created')?date_to_mysql($this->input->post('purchase_date_created')):NULL,
                'purchase_date_due' => $this->input->post('purchase_date_due')?date_to_mysql($this->input->post('purchase_date_due')):NULL,
				'purchase_status' => $this->input->post('purchase_status')?$this->input->post('purchase_status'):NULL,
				'parts_discountstate' => $this->input->post('parts_discountstate')?strip_tags($this->input->post('parts_discountstate')):NULL,
				'product_user_total' => $this->input->post('product_user_total')?$this->input->post('product_user_total'):0,
                'total_taxable_amount' => $this->input->post('total_taxable_amount')?$this->input->post('total_taxable_amount'):0,
                'total_discount' => $this->input->post('total_discount')?$this->input->post('total_discount'):0,
                'total_tax_amount' => $this->input->post('total_tax_amount')?$this->input->post('total_tax_amount'):0,
				'grand_total' => $this->input->post('grand_total')?$this->input->post('grand_total'):0,
				'total_due_amount' => $this->input->post('grand_total')?$this->input->post('grand_total'):0,
                'bank_id' => $this->input->post('bank_id')?$this->input->post('bank_id'):NULL,
			);
			
			$purchase_id = $this->mdl_mech_purchase->save($purchase_id, $db_array);

    		foreach ($product_items as $product){
    			if (!empty($product->item_product_id)){
    				$product_array = array(
    					'purchase_id' => $purchase_id,
    					'user_id' => $this->session->userdata('user_id'),
    					'product_id' => $product->item_product_id,
    					'item_name' => $product->item_name?$product->item_name:NULL,
    					'item_hsn' => $product->item_hsn?$product->item_hsn:NULL,
    					'item_qty' => $product->product_qty?$product->product_qty:1,
						'item_price' => $product->usr_lbr_price?$product->usr_lbr_price:NULL,
						'item_amount' => $product->item_amount?$product->item_amount:NULL,
    					'item_discount'=> $product->item_discount?$product->item_discount:0,
						'item_discount_price'=> $product->item_discount_price?$product->item_discount_price:0,
						'tax_id'=> $product->gst_spare?$product->gst_spare:0,
    					'igst_pct'=> $product->igst_pct?$product->igst_pct:0,
    					'igst_amount'=> $product->igst_amount?$product->igst_amount:0,
    					'cgst_pct'=> $product->cgst_pct?$product->cgst_pct:0,
    					'cgst_amount'=> $product->cgst_amount?$product->cgst_amount:0,
    					'sgst_pct'=> $product->sgst_pct?$product->sgst_pct:0,
    					'sgst_amount'=> $product->sgst_amount?$product->sgst_amount:0,
    					'item_total_amount'=> $product->item_total_amount?$product->item_total_amount:0,
    					'created_on' => date('Y-m-d H:i:s'),
    					'created_by' => $this->session->userdata('user_id'),
    					'modified_by' => $this->session->userdata('user_id'),
    					'workshop_id' => $this->session->userdata('work_shop_id'),
    					'w_branch_id' => $this->session->userdata('branch_id')
    				);
    				
    				if(isset($product->item_id)){
    					$this->db->where('item_id', $product->item_id);
    					$this->db->update('mech_purchase_item', $product_array);
    				}else{
    					$this->db->insert('mech_purchase_item', $product_array);
    				}

    				$inventory_data = array(
    		            'product_id' => $product->item_product_id,
    		            'stock_type' => 2,
    		            'quantity' => $product->product_qty,
    		            'price' => $product->usr_lbr_price?$product->usr_lbr_price:0,
    		            'stock_date' => $this->input->post('purchase_date_created')?date_to_mysql($this->input->post('purchase_date_created')):NULL,
    		            'description' => "Purchase stock",
						'action_type' => 1,
						'entity_id' => $purchase_id
						
    		        );
    				$status = $this->mdl_mech_item_master->save_inventory($inventory_data);
    			}
			}

			$checkUrlKey = $this->db->get_where('ip_uploads', array('url_key' => $this->input->post('url_key')))->result();
			
			if(count($checkUrlKey)>0){
				$upload_array = array(
					'entity_id' =>  $purchase_id
				);
			    $this->db->where('url_key', $this->input->post('url_key'));
			    $this->db->update('ip_uploads', $upload_array);
			}

            $response = array(
				'success' => 1,
				'purchase_id' => $purchase_id
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
        $this->db->delete('mech_purchase_item');
        $response = array(
            'success' => 1
        );
        echo json_encode($response);
	}
	
    public function delete(){
        $document_id = $this->input->post('document_id');
        $this->db->set('status','D');
        $this->db->where('purchase_id', $document_id);
        $this->db->update('mech_purchase');
        $response = array(
            'success' => 1
        );
        echo json_encode($response);
	}
	
	public function get_filter_list(){

		$this->load->model('mech_purchase/mdl_mech_purchase');
		
        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;
        if($this->input->post('purchase_from_date')){
            $this->mdl_mech_purchase->where('mech_purchase.purchase_date_created >=', date_to_mysql($this->input->post('purchase_from_date')));
        }

        if($this->input->post('purchase_to_date')){
            $this->mdl_mech_purchase->where('mech_purchase.purchase_date_created <=', date_to_mysql($this->input->post('purchase_to_date')));
        }

        if($this->input->post('purchase_no')){
            $this->mdl_mech_purchase->or_like('mech_purchase.purchase_no', trim($this->input->post('purchase_no')));
        }

        if($this->input->post('purchase_number')){
            $this->mdl_mech_purchase->or_like('mech_purchase.purchase_number', trim($this->input->post('purchase_number')));
        }

        if($this->input->post('supplier_id')){
            $this->mdl_mech_purchase->where('mech_purchase.supplier_id', trim($this->input->post('supplier_id')));
        }

        if($this->input->post('purchase_status')){
            $this->mdl_mech_purchase->where('mech_purchase.purchase_status', trim($this->input->post('purchase_status')));
        }

        if($this->input->post('branch_id')){
            $this->mdl_mech_purchase->where('mech_purchase.branch_id', trim($this->input->post('branch_id')));
        }

        $rowCount = $this->mdl_mech_purchase->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        if($this->input->post('purchase_from_date')){
            $this->mdl_mech_purchase->where('mech_purchase.purchase_date_created >=', date_to_mysql($this->input->post('purchase_from_date')));
        }

        if($this->input->post('purchase_to_date')){
            $this->mdl_mech_purchase->where('mech_purchase.purchase_date_created <=', date_to_mysql($this->input->post('purchase_to_date')));
        }

        if($this->input->post('purchase_no')){
            $this->mdl_mech_purchase->or_like('mech_purchase.purchase_no', trim($this->input->post('purchase_no')));
        }

        if($this->input->post('purchase_number')){
            $this->mdl_mech_purchase->or_like('mech_purchase.purchase_number', trim($this->input->post('purchase_number')));
        }

        if($this->input->post('supplier_id')){
            $this->mdl_mech_purchase->where('mech_purchase.supplier_id', trim($this->input->post('supplier_id')));
        }

        if($this->input->post('purchase_status')){
            $this->mdl_mech_purchase->where('mech_purchase.purchase_status', trim($this->input->post('purchase_status')));
        }

        if($this->input->post('branch_id')){
            $this->mdl_mech_purchase->where('mech_purchase.branch_id', trim($this->input->post('branch_id')));
        }
        $this->mdl_mech_purchase->limit($limit,$start);
        $purchase_list = $this->mdl_mech_purchase->get()->result();           
		
        $response = array(
            'success' => 1,
            'purchase_list' => $purchase_list, 
            'createLinks' => $createLinks,
            'work_shop_id' => $this->session->userdata('work_shop_id'),
            'user_type' => $this->session->userdata('user_type'),
            'workshop_is_enabled_inventory' => $this->session->userdata('workshop_is_enabled_inventory'),
        );
        echo json_encode($response);
    }
}