<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true; 
  
	public function __construct()
    {
        parent::__construct();
        $this->load->model('mech_leads/mdl_mech_leads');
        $this->load->model('user_cars/mdl_user_cars'); 
        $this->load->model('clients/mdl_clients');
        $this->load->model('mech_item_master/mdl_mech_item_master'); 
        $this->load->model('products/mdl_products');     
        $this->load->model('user_address/mdl_user_address');  
        $this->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls'); 
		$this->load->model('workshop_branch/mdl_workshop_branch');
		$this->load->model('mech_employee/mdl_mech_employee');
		$this->load->model('users/mdl_users');
        $this->load->model('mech_invoices/mdl_mech_invoice');
		$this->load->model('mech_invoice_groups/mdl_mech_invoice_groups');
		$this->load->model('mech_employee/mdl_mech_employee');	
	}
	
    public function create()
    {		

		$action_from = ($this->input->post('action_from'))?$this->input->post('action_from'):'';
        $ml_id = $this->input->post('ml_id');
		$btn_submit = $this->input->post('btn_submit');
		
		// if($this->input->post('leads_no')){
		// 	$leads_no = $this->input->post('leads_no');
		// }else{
		// 	$group_no = $this->mdl_settings->getquote_book_no('leads');
		// 	if($group_no == 0){
		// 		$response = array(
		// 			'success' => '2',
		// 			'validation_errors' => array(
		// 				'leads_no' => 'empty',
		// 			)
		// 		);
		// 		echo json_encode($response);
		// 		exit;
		// 	}else{
		// 		$leads_no = $this->mdl_settings->get_invoice_number($group_no);
		// 	}
		// }

		if($this->input->post('leads_no')){
			$leads_no = $this->input->post('leads_no');
		}else{
			$leads_no = $this->mdl_settings->get_invoice_number($this->input->post('invoice_group_id'));
		}
		
        if ($this->mdl_mech_leads->run_validation('validation_rules')) {
			$ml_id = $this->mdl_mech_leads->save($ml_id);
			$ml_id = $this->mdl_mech_leads->save($ml_id , array('leads_no' => $leads_no));

            if(empty($action_from)){
                $lead_detail = $this->mdl_mech_leads->where('ml_id', $ml_id)->get()->result_array();
                $lead_list = $this->mdl_mech_leads->get()->result();
            }else{
                $lead_detail = '';
                $lead_list = array();
			}
			
            $response = array(
                'success' => 1,
                'lead_detail' => $lead_detail,
                'ml_id' => $ml_id,
                'lead_list' => $lead_list,
                'btn_submit' => $btn_submit
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
	
	public function create_services_products()
    {
		
		$data = array();
		$service_items = json_decode($this->input->post('service_items'));
		$service_totals = json_decode($this->input->post('service_totals'));

		$service_package_items = json_decode($this->input->post('service_package_items'));
		$service_package_totals = json_decode($this->input->post('service_package_totals'));

		$product_items = json_decode($this->input->post('product_items'));
		$product_totals = json_decode($this->input->post('product_totals'));
		$ml_id = $this->input->post('ml_id');

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
				'success' => 0,
				'validation_errors' => array(
					'service_name' => form_error('service_name', '', ''),
				)
			);
			
			echo json_encode($response);
			exit;
		}

		if(count($service_items) > 0){

			$db_array = array(
				'discountstate' => $this->input->post('discountstate')?$this->input->post('discountstate'):NULL,
				'service_user_total' => $this->input->post('service_user_total')?$this->input->post('service_user_total'):0,
				'service_total_discount_pct' => $this->input->post('service_total_discount_pct')?$this->input->post('service_total_discount_pct'):0,
				'service_total_discount' => $this->input->post('service_total_discount')?$this->input->post('service_total_discount'):0,
				'service_total_taxable' => $this->input->post('service_total_taxable')?$this->input->post('service_total_taxable'):0,
				'service_total_gst_pct' => $this->input->post('service_total_gst_pct')?$this->input->post('service_total_gst_pct'):0,
				'service_total_gst' => $this->input->post('service_total_gst')?$this->input->post('service_total_gst'):0,
				'service_grand_total' => $this->input->post('service_grand_total')?$this->input->post('service_grand_total'):0,
				'total_taxable_amount' => $this->input->post('total_taxable_amount')?$this->input->post('total_taxable_amount'):0,
				'overall_discount_amount' => $this->input->post('overall_discount_amount')?$this->input->post('overall_discount_amount'):0,
				'total_tax_amount' => $this->input->post('total_tax_amount')?$this->input->post('total_tax_amount'):0,
				'grand_total' => $this->input->post('grand_total')?$this->input->post('grand_total'):0,
				'description' => $this->input->post('description')?strip_tags($this->input->post('description')):NULL,
				'service_discountstate' => $this->input->post('service_discountstate')?strip_tags($this->input->post('service_discountstate')):NULL,
			);
			$this->db->where('ml_id', $ml_id);
			$this->db->update('mech_leads', $db_array);

			foreach ($service_items as $service) {
				if (!empty($service->item_service_id)) {
					$service_array = array(
						'ml_id' => $ml_id,
						'is_from' => 'lead_service',
						'service_item' => $service->item_service_id,
						'user_item_price' => $service->usr_lbr_price?$service->usr_lbr_price:0,
						'mech_item_price' => $service->mech_lbr_price?$service->mech_lbr_price:0,
						'igst_pct' => $service->igst_pct?$service->igst_pct:0,
						'igst_amount' => $service->igst_amount?$service->igst_amount:0,
						'item_total_amount' => $service->item_total_amount?$service->item_total_amount:0,
						'item_discount' => $service->item_discount?$service->item_discount:0,
						'item_amount' => $service->item_amount?$service->item_amount:0,
						'item_hsn' => $service->item_hsn?$service->item_hsn:NULL,
						'created_on' => date('Y-m-d H:i:s'),
						'created_by' => $this->session->userdata('user_id'),
						'modified_by' => $this->session->userdata('user_id'),
						'workshop_id' => $this->session->userdata('work_shop_id'),
						'w_branch_id' => $this->session->userdata('branch_id')
					);
	
					if(isset($service->rs_item_id)){
						$this->db->where('rs_item_id', $service->rs_item_id);
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
					
					echo json_encode($response);
					exit;
				}
			}
		}

		if(count($service_package_items)>0){
			$db_array = array(
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
				'description' => $this->input->post('description')?strip_tags($this->input->post('description')):NULL,
			);
			$this->db->where('ml_id', $ml_id);
			$this->db->update('mech_leads', $db_array);

			foreach ($service_package_items as $service) {

				if (!empty($service->item_service_id)) {
	
					$service_array = array(
						'ml_id' => $ml_id,
						'is_from' => 'lead_package',
						'service_item' => $service->item_service_id,
						'employee_id' => $service->employee_id,
						'user_item_price' => $service->usr_lbr_price?$service->usr_lbr_price:0,
						'mech_item_price' => $service->mech_lbr_price?$service->mech_lbr_price:0,
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
					
					echo json_encode($response);
					exit;
				}
			}
		}
		
		if(count($product_items) > 0){
			$db_array = array(
				'product_user_total' => $this->input->post('product_user_total')?$this->input->post('product_user_total'):0,
				'product_total_discount' => $this->input->post('product_total_discount')?$this->input->post('product_total_discount'):0,
			    'product_total_taxable' => $this->input->post('product_total_taxable')?$this->input->post('product_total_taxable'):0,
				'product_total_gst' => $this->input->post('product_total_gst')?$this->input->post('product_total_gst'):0,
				'product_grand_total' => $this->input->post('product_grand_total')?$this->input->post('product_grand_total'):0,
			    'total_taxable_amount' => $this->input->post('total_taxable_amount')?$this->input->post('total_taxable_amount'):0,
				'overall_discount_amount' => $this->input->post('overall_discount_amount')?$this->input->post('overall_discount_amount'):0,
				'total_tax_amount' => $this->input->post('total_tax_amount')?$this->input->post('total_tax_amount'):0,
				'grand_total' => $this->input->post('grand_total')?$this->input->post('grand_total'):0,
				'description' => $this->input->post('description')?strip_tags($this->input->post('description')):NULL,
				'parts_discountstate' => $this->input->post('parts_discountstate')?strip_tags($this->input->post('parts_discountstate')):NULL,
			);
			$this->db->where('ml_id', $ml_id);
			$this->db->update('mech_leads', $db_array);

			foreach ($product_items as $product){
				if(!empty($product->item_product_id)){
					$product_array = array(
						'ml_id' => $ml_id,
						'is_from' => 'lead_product',
						'service_item' => $product->item_product_id,
						'user_item_price' => $product->usr_lbr_price?$product->usr_lbr_price:0,
						'mech_item_price' => $product->mech_lbr_price?$product->mech_lbr_price:0,
						'item_hsn' => $product->item_hsn?$product->item_hsn:NULL,
						'item_qty' => $product->product_qty?$product->product_qty:0,
						'item_discount' => $product->item_discount?$product->item_discount:0,
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
						$product_id = $this->db->update('mech_leads_items', $product_array);
					}else{
						$product_id = $this->db->insert('mech_leads_items', $product_array);
					}
				}else{
	
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
		}

		$response = array(
			'success' => 1,
			'ml_id' => $ml_id
		);
		echo json_encode($response);
	}

	public function save_comments(){

		if($this->input->post('comment_id')){
			$updatedata = array(
				'comments' =>  $this->input->post('comments')?strip_tags($this->input->post('comments')):NULL,
				'modified_employee_id' => $this->input->post('modified_employee_id')?strip_tags($this->input->post('modified_employee_id')):NULL,
				'reschedule' =>  $this->input->post('reschedule')?strip_tags($this->input->post('reschedule')):NULL,
				'reschedule_date' =>  $this->input->post('reschedule_date')?date("Y-m-d H:i:s", strtotime($this->input->post('reschedule_date'))):NULL,
				'modified_by' => $this->session->userdata('user_id'),
			);
			$this->db->where('comment_id',$this->input->post('comment_id'));
			$id = $this->db->update('mech_comments', $updatedata);

		}else{
			$insertData = array(
				'entity_id' => $this->input->post('ml_id'),
				'entity_type' => $this->input->post('entity_type'),
				'comments' => $this->input->post('comments')?strip_tags($this->input->post('comments')):NULL,
				'modified_employee_id' => $this->input->post('modified_employee_id')?strip_tags($this->input->post('modified_employee_id')):NULL,
				'reschedule' =>  $this->input->post('reschedule')?strip_tags($this->input->post('reschedule')):NULL,
				'reschedule_date' =>  $this->input->post('reschedule_date')?date("Y-m-d h:i:s", strtotime($this->input->post('reschedule_date'))):NULL,
				'workshop_id' => $this->session->userdata('work_shop_id'),
				'w_branch_id' => $this->session->userdata('branch_id'),
				'created_by' => $this->session->userdata('user_id'),
				'modified_by' => $this->session->userdata('user_id'),
				'created_on' => date('Y-m-d H:i:s'),
			);

			
			$this->db->insert('mech_comments', $insertData);
			$id = $this->db->insert_id();
		}

		if($this->input->post('reschedule') == 'Y'){
			if($this->input->post('reschedule_date')){
				$this->db->where('ml_id',$this->input->post('ml_id'));
				$ml_id = $this->db->update('mech_leads', array(
					'user_id' => $this->input->post('modified_employee_id')?strip_tags($this->input->post('modified_employee_id')):NULL,
					'reschedule_date' => $this->input->post('reschedule_date')?date("Y-m-d h:i:s", strtotime($this->input->post('reschedule_date'))):NULL
				));
			}
		}

		if($id){
			$response = array(
				'success' => 1
			);
		}else{
			$response = array(
				'success' => 0
			);
		}
		echo json_encode($response);
	}

	public function get_Comment_detials(){
		$comment_id = $this->input->post('comment_id');	
		$comments = $this->db->from('mech_comments')->where('mech_comments.comment_id',$comment_id)->where('mech_comments.entity_type','L')->where('mech_comments.status','A')->join('mech_employee', 'mech_employee.employee_id = mech_comments.modified_employee_id')->order_by("mech_comments.comment_id","desc")->get()->row();
		$assigned_to = $this->mdl_mech_employee->get()->result();
		if(!empty($comments)){
			$response = array(
				'success' => 1,
				'comments' => $comments,
				'assigned_to' => $assigned_to
			);
		}else{
			$response = array(
				'success' => 0
			);
		}

		echo json_encode($response);
	}

	public function get_comments(){
		$entity_id = $this->input->post('entity_id');	
		$comments = $this->db->select("mech_comments.comment_id,mech_comments.entity_id,mech_comments.comments,mech_comments.reschedule,mech_comments.reschedule_date,mech_comments.created_on,mech_employee.employee_name")->from('mech_comments')->where('mech_comments.entity_id',$entity_id)->where('mech_comments.entity_type','L')->where('mech_comments.status','A')->join('mech_employee', 'mech_employee.employee_id = mech_comments.modified_employee_id')->order_by("mech_comments.comment_id","desc")->get()->result();
		if(!empty($comments)){
			$response = array(
				'success' => 1,
				'comments' => $comments,
			);
		}else{
			$response = array(
				'success' => 0
			);
		}

		echo json_encode($response);
	}

	public function delete_item(){
        $item_id = $this->input->post('item_id');
        $this->db->where('rs_item_id', $item_id);
        $this->db->delete('mech_leads_items');
        $response = array(
            'success' => 1
        );
        echo json_encode($response);
    }

	public function get_filter_list(){
        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;

		if($this->input->post('from_date')){  
			$this->mdl_mech_leads->where('Cast(mech_leads.reschedule_date as Date) >=', date_to_mysql($this->input->post('from_date')) );
		}
		if($this->input->post('to_date')){
			$this->mdl_mech_leads->where('Cast(mech_leads.reschedule_date as date) <=', date_to_mysql($this->input->post('to_date')) );
		}
		if($this->input->post('leads_no')){
            $this->mdl_mech_leads->like('mech_leads.leads_no', $this->input->post('leads_no'));
        }
		if($this->input->post('client_name')){
            $this->mdl_mech_leads->like('mech_clients.client_name',$this->input->post('client_name'));
        }
        if($this->input->post('client_contact_no')){
            $this->mdl_mech_leads->like('mech_clients.client_contact_no', $this->input->post('client_contact_no'));
        }
        if($this->input->post('client_email_id')){
            $this->mdl_mech_leads->like('mech_clients.client_email_id', $this->input->post('client_email_id'));
        }
        if($this->input->post('lead_source')){
            $this->mdl_mech_leads->like('mech_leads.lead_source',$this->input->post('lead_source'));
        }
        if($this->input->post('lead_status')){
            $this->mdl_mech_leads->like('mech_leads.lead_status',$this->input->post('lead_status'));
        }

        $rowCount = $this->mdl_mech_leads->get()->result();
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
			$this->mdl_mech_leads->where('Cast(mech_leads.reschedule_date as Date) >=', date_to_mysql($this->input->post('from_date')) );
		}
		if($this->input->post('to_date')){
			$this->mdl_mech_leads->where('Cast(mech_leads.reschedule_date as date) <=', date_to_mysql($this->input->post('to_date')) );
		}
        if($this->input->post('leads_no')){
            $this->mdl_mech_leads->like('mech_leads.leads_no', $this->input->post('leads_no'));
        }
		if($this->input->post('client_name')){
            $this->mdl_mech_leads->like('mech_clients.client_name',$this->input->post('client_name'));
        }
        if($this->input->post('client_contact_no')){
            $this->mdl_mech_leads->like('mech_clients.client_contact_no', $this->input->post('client_contact_no'));
        }
        if($this->input->post('client_email_id')){
            $this->mdl_mech_leads->like('mech_clients.client_email_id', $this->input->post('client_email_id'));
        }
        if($this->input->post('lead_source')){
            $this->mdl_mech_leads->like('mech_leads.lead_source',$this->input->post('lead_source'));
        }
        if($this->input->post('lead_status')){
            $this->mdl_mech_leads->like('mech_leads.lead_status',$this->input->post('lead_status'));
        }
        
        $this->mdl_mech_leads->limit($limit,$start);
        $mech_lead_status = $this->mdl_mech_leads->get()->result();           

        $response = array(
            'success' => 1,
            'mech_lead_status' => $mech_lead_status, 
            'createLinks' => $createLinks,
			'permission' => $this->mdl_users->user_module_permission(),
            'work_shop_id' => $this->session->userdata('work_shop_id'),
            'user_type' => $this->session->userdata('user_type'),
        );
        echo json_encode($response);
    }
    
}