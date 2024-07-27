<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Mech_Leads extends Response_Model
{
    public $table = 'mech_leads';
    public $primary_key = 'mech_leads.ml_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    
    public function default_select()
    {
		$this->db->select('SQL_CALC_FOUND_ROWS mech_leads.ml_id,mech_leads.workshop_id,mech_leads.w_branch_id,
		mech_leads.category_type,mech_leads.title,mech_leads.customer_id,
		mech_leads.user_address_id,mech_leads.branch_id,mech_leads.user_id,
		mech_leads.user_car_list_id,mech_leads.invoice_group_id,mech_leads.leads_no,
		mech_leads.lead_date,mech_leads.reschedule_date,mech_leads.lead_source,
		mech_leads.lead_status,mech_leads.pickup,mech_leads.overall_discount_amount,mech_leads.overall_discount,
		mech_leads.product_grand_total,mech_leads.product_mech_total,mech_leads.product_total_discount,
		mech_leads.product_total_gst,mech_leads.product_total_taxable,mech_leads.product_user_total,
		mech_leads.discountstate,mech_leads.description,mech_leads.parts_discountstate,mech_leads.service_discountstate,
		mech_leads.service_grand_total,mech_leads.service_mech_total,mech_leads.service_total_discount,
		mech_leads.service_total_discount_pct,mech_leads.service_total_gst,mech_leads.service_total_gst_pct,
        mech_leads.service_total_taxable,mech_leads.service_user_total,
        mech_leads.packagediscountstate,
		mech_leads.service_package_grand_total,mech_leads.service_package_mech_total,mech_leads.service_package_total_discount,
		mech_leads.service_package_total_discount_pct,mech_leads.service_package_total_gst,mech_leads.service_package_total_gst_pct,
        mech_leads.service_package_total_taxable,mech_leads.service_package_user_total,
        mech_leads.total_taxable_amount,mech_leads.total_tax_amount,mech_leads.grand_total,
        mech_appointment_status.status_label,mech_lead_source.lead_source_name,
		mech_clients.client_id,mech_clients.client_name,mech_clients.total_rewards_point,
		mech_clients.is_new_customer,mech_clients.client_gstin,mech_clients.client_contact_no,
		mech_clients.client_email_id,mech_clients.refered_by_type,mech_clients.refered_by_id,
        mech_clients.device_token,
		mech_owner_car_list.car_list_id,mech_owner_car_list.owner_id,mech_owner_car_list.entity_type,
		mech_owner_car_list.model_type,mech_owner_car_list.car_reg_no,mech_owner_car_list.car_brand_id,
		mech_owner_car_list.car_brand_model_id,mech_owner_car_list.car_model_year,mech_owner_car_list.car_variant,
		mech_owner_car_list.fuel_type,mech_owner_car_list.vin,mech_owner_car_list.total_mileage,
		mech_owner_car_list.daily_mileage,mech_owner_car_list.engine_oil_type,mech_owner_car_list.steering_type,
		mech_owner_car_list.air_conditioning,mech_owner_car_list.car_drive_type,mech_owner_car_list.transmission_type,
        mech_car_brand_details.brand_name,mech_car_brand_models_details.model_name,mech_brand_model_variants.variant_name,
        workshop_branch_details.display_board_name,mech_work_order_dtls.work_order_id,mech_work_order_dtls.jobsheet_status,mech_invoice.invoice_id,inv.invoice_id as jobcard_invoice_id,
        mech_employee.employee_name', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_leads.reschedule_date,mech_leads.ml_id', "ASC");
    }
	
	public function default_join(){
        $this->db->join('mech_lead_source', 'mech_lead_source.mls_id = mech_leads.lead_source', 'left');
        $this->db->join('mech_appointment_status', 'mech_appointment_status.mps_id = mech_leads.lead_status', 'left');
		$this->db->join('mech_clients', 'mech_clients.client_id = mech_leads.customer_id', 'left');
        $this->db->join('mech_owner_car_list','mech_owner_car_list.car_list_id = mech_leads.user_car_list_id', 'left');
		$this->db->join('mech_car_brand_details', 'mech_car_brand_details.brand_id = mech_owner_car_list.car_brand_id', 'left');
		$this->db->join('mech_car_brand_models_details', 'mech_car_brand_models_details.model_id = mech_owner_car_list.car_brand_model_id', 'left');
        $this->db->join('mech_brand_model_variants', 'mech_brand_model_variants.brand_model_variant_id = mech_owner_car_list.car_variant', 'left');
        $this->db->join('workshop_branch_details', 'workshop_branch_details.w_branch_id = mech_leads.branch_id', 'left');
        $this->db->join('mech_employee', 'mech_employee.employee_id = mech_leads.user_id', 'left');
        $this->db->join('mech_work_order_dtls', 'mech_leads.ml_id  = mech_work_order_dtls.work_from_id AND mech_work_order_dtls.work_from = "A"','left');
        $this->db->join('mech_invoice', 'mech_leads.ml_id = mech_invoice.work_from_id AND mech_invoice.work_from = "A"','left');
        $this->db->join('mech_invoice as inv', 'mech_work_order_dtls.jobsheet_no = inv.jobsheet_no','left');

	}

	public function default_where(){
        $this->db->where('mech_leads.workshop_id' , $this->session->userdata('work_shop_id'));
        if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $this->db->where('mech_leads.w_branch_id' , $this->session->userdata('branch_id'));
        }else if($this->session->userdata('user_type') == 6){
            $this->db->where_in('mech_leads.w_branch_id' , $this->session->userdata('user_branch_id'));
        }
		$this->db->where('mech_leads.category_type', "A");
        $this->db->where('mech_leads.status', "A");
	}

    public function validation_rules()
    {
        return array(
			'branch_id' => array(
				'field' => 'branch_id',
                'label' => trans('lable95'),
                'rules' => 'required'
			),
            // 'user_id' => array(
            //     'field' => 'user_id',
            //     'label' => trans('lable495'),
            //     'rules' => 'required'
			// ),
			'invoice_group_id' => array(
				'field' => 'invoice_group_id',
                'label' => trans('lable276'),
                'rules' => 'required'
			),
            'customer_id' => array(
                'field' => 'customer_id',
                'label' => trans('lable36'),
                'rules' => 'required'
			),
            'category_type' => array(
                'field' => 'category_type',
                // 'label' => trans('category_type'),
                'rules' => 'required'
            ),
            // 'title' => array(
            //     'field' => 'title',
            //     'label' => trans('title'),
			// ),
			'user_address_id' => array(
				'field' => 'user_address_id',
                'label' => trans('lable497'),
			),
            'user_car_list_id' => array(
                'field' => 'user_car_list_id',
				'label' => trans('lable280'),
            ),
            'lead_date' => array(
                'field' => 'lead_date',
                'label' => trans('lable527'),
                'rules' => 'required'
            ),
            'lead_source' => array(
                'field' => 'lead_source',
                'label' => trans('lable529'),
			),
            'lead_status' => array(
                'field' => 'lead_status',
                'label' => trans('lable530'),
                'rules' => 'required'
            ),
            'pickup' => array(
                'field' => 'pickup',
                'label' => trans('lable536'),
			),
            'address_id' => array(
                'field' => 'address_id',
                'label' => trans('lable497'),
			),
            '_mm_csrf' => array(
                'field' => '_mm_csrf'
            )
        );
    }
	
	public function db_array()
    {
        $db_array = parent::db_array();
		unset($db_array['_mm_csrf']);
		$db_array['lead_date'] = $this->input->post('lead_date')?date("Y-m-d H:i:s", strtotime($this->input->post('lead_date'))):date("Y-m-d h:i:s");

		if(empty($db_array['ml_id'])){
			$db_array['reschedule_date'] = $this->input->post('lead_date')?date("Y-m-d H:i:s", strtotime($this->input->post('lead_date'))):date("Y-m-d h:i:s");
		}else{
			if(empty($db_array['reschedule_date'])){
				$db_array['reschedule_date'] = $this->input->post('lead_date')?date("Y-m-d H:i:s", strtotime($this->input->post('lead_date'))):date("Y-m-d h:i:s");
			}else{
				$db_array['reschedule_date'] = $this->input->post('reschedule_date')?date("Y-m-d H:i:s", strtotime($this->input->post('reschedule_date'))):date("Y-m-d H:i:s");
			}
		}
		$db_array['workshop_id'] = $this->session->userdata('work_shop_id');
    	$db_array['w_branch_id'] = $this->session->userdata('branch_id');
    	$db_array['created_by'] = $this->session->userdata('user_id');
    	$db_array['modified_by'] = $this->session->userdata('user_id');
        return $db_array;
    }

	public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();
        $id = parent::save($id, $db_array);
        return $id;
    }

	 public function get_url_key()
    {
        $this->load->helper('string');
        return random_string('alnum', 15);
    }

    public function get_user_quote_product_item($ml_id = null, $user_id  = null)
    {
        
        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');
        
        if($ml_id){
            $this->db->select('si.rs_item_id,si.url_key,si.is_from,si.service_item,si.item_hsn,si.user_item_price,si.mech_item_price,si.item_qty,si.item_discount,si.item_amount,si.igst_pct,si.igst_amount,si.item_total_amount,si.item_work_level,ci.product_id,ci.product_name as item_product_name,ci.product_category_id');
            $this->db->from('mech_leads_items si');
            $this->db->join('mech_products ci', 'ci.product_id = si.service_item');
            $this->db->where('si.workshop_id='.$work_shop_id.' AND si.w_branch_id='.$branch_id.'');
            $this->db->where('si.is_from', 'lead_product');
            $this->db->where('si.ml_id', $ml_id);
            $service_items = $this->db->get()->result();
        }else{
            $service_items = array();
        }
        
        return json_encode($service_items);
    }

    public function get_user_quote_service_item($ml_id = null, $user_id  = null)
    {
        if($ml_id){
        	$work_shop_id = $this->session->userdata('work_shop_id');
			$branch_id = $this->session->userdata('branch_id');
            $this->db->select('si.rs_item_id,si.url_key,si.is_from,si.service_item,si.item_hsn,si.user_item_price,si.mech_item_price,si.item_qty,si.item_discount,si.item_amount,si.igst_pct,si.igst_amount,si.item_total_amount,si.item_work_level,ci.msim_id,ci.service_item_name,ci.service_category_id');
            $this->db->from('mech_leads_items si');
            $this->db->join('mech_service_item_dtls ci', 'ci.msim_id = si.service_item');
            $this->db->where('si.workshop_id='.$work_shop_id.' AND si.w_branch_id='.$branch_id.'');
            $this->db->where('si.is_from', 'lead_service');
            $this->db->where('si.ml_id', $ml_id);
            $service_items = $this->db->get()->result();
        }else{
            $service_items = array();
        }
        return json_encode($service_items);
    }

    public function get_user_quote_service_package_item($ml_id = null, $user_id  = null){
        if($ml_id){
        	$work_shop_id = $this->session->userdata('work_shop_id');
            $branch_id = $this->session->userdata('branch_id');

            $this->db->select('si.rs_item_id,si.employee_id,si.url_key,si.is_from,si.service_item,si.item_hsn,si.user_item_price,si.mech_item_price,si.item_qty,si.item_discount,si.item_amount,si.igst_pct,si.igst_amount,si.item_total_amount,si.item_work_level,mi.employee_name,ci.s_pack_id,ci.package_name as service_item_name,ci.category_id as service_category_id');
            $this->db->from('mech_leads_items si');
            $this->db->join('mech_service_packages ci', 'ci.s_pack_id  = si.service_item', 'left');
            $this->db->join('mech_employee mi', 'mi.employee_id = si.employee_id','left');
            $this->db->where('si.workshop_id='.$work_shop_id.' AND si.w_branch_id='.$branch_id.'');
            $this->db->where('si.is_from', 'lead_package');
            $this->db->where('si.ml_id', $ml_id);
            $service_package_items = $this->db->get()->result();
        }else{
            $service_package_items = array();
        }
        return json_encode($service_package_items);
    }
	
    public function get_user_quote_product_ids($ml_id = null, $user_id  = null)
    {
        if($ml_id){
            $this->db->select('si.service_item');
            $this->db->from('mech_leads_items si');
            $this->db->join('mech_products mp', 'mp.product_id = si.service_item');
            $this->db->where('si.is_from', 'lead_product');
            $this->db->where('si.ml_id', $ml_id);
            $products = $this->db->get()->result();
        }else{
            $products = array();
        }
        
        $product_ids = array();

        if(count($products) > 0){
           foreach($products as $prd){
               array_push($product_ids , $prd->service_item);
           }
        }
        
        return $product_ids;
    }

    public function get_user_quote_service_ids($ml_id = null, $user_id  = null){
       if($ml_id){
           $this->db->select('si.service_item');
           $this->db->from('mech_leads_items si');
           $this->db->join('mech_service_item_dtls ci', 'ci.msim_id = si.service_item');
           $this->db->where('si.is_from', 'invoice_service');
           $this->db->where('si.ml_id', $ml_id);
           $services = $this->db->get()->result();
       }else{
           $services = array();
       }

       $service_ids = array();

       if(count($services) > 0){
          foreach($services as $service){
              array_push($service_ids , $service->service_item);
          }
       }

       return $service_ids;
   }
}
