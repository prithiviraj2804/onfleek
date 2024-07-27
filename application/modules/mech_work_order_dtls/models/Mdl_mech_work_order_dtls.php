<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Mech_Work_Order_Dtls extends Response_Model
{
    public $table = 'mech_work_order_dtls';
    public $primary_key = 'mech_work_order_dtls.work_order_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    
    public function default_select()
    {
		$this->db->select('SQL_CALC_FOUND_ROWS mech_work_order_dtls.work_order_id,mech_work_order_dtls.workshop_id,
		mech_work_order_dtls.invoice_group_id,mech_work_order_dtls.branch_id,mech_work_order_dtls.url_key,
		mech_work_order_dtls.customer_id,mech_work_order_dtls.customer_car_id,mech_work_order_dtls.user_address_id,
		mech_work_order_dtls.current_odometer_reading,mech_work_order_dtls.fuel_level,mech_work_order_dtls.jobsheet_status,
		mech_work_order_dtls.jobsheet_no,mech_work_order_dtls.issue_date,mech_work_order_dtls.start_date,
		mech_work_order_dtls.end_date,mech_work_order_dtls.refered_by_type,mech_work_order_dtls.refered_by_id,
		mech_work_order_dtls.issued_by,mech_work_order_dtls.assigned_to,mech_work_order_dtls.invoice_number,
        mech_work_order_dtls.uploadCheckBox,mech_work_order_dtls.next_service_dt,
        
        mech_work_order_dtls.service_mech_total,mech_work_order_dtls.service_user_total,
        mech_work_order_dtls.service_discountstate,mech_work_order_dtls.service_total_discount,
        mech_work_order_dtls.service_total_discount_pct,mech_work_order_dtls.service_total_taxable,
        mech_work_order_dtls.service_total_gst_pct,mech_work_order_dtls.service_total_gst,mech_work_order_dtls.service_grand_total,
        
        mech_work_order_dtls.service_package_mech_total,mech_work_order_dtls.service_package_user_total,mech_work_order_dtls.job_terms_condition,
        mech_work_order_dtls.packagediscountstate,mech_work_order_dtls.service_package_total_discount,
        mech_work_order_dtls.service_package_total_discount_pct,mech_work_order_dtls.service_package_total_taxable,
        mech_work_order_dtls.service_package_total_gst_pct,mech_work_order_dtls.service_package_total_gst,mech_work_order_dtls.service_package_grand_total,
        
		mech_work_order_dtls.parts_discountstate,mech_work_order_dtls.product_user_total,mech_work_order_dtls.product_mech_total,mech_work_order_dtls.product_total_discount,
		mech_work_order_dtls.product_total_taxable,mech_work_order_dtls.product_total_gst,mech_work_order_dtls.product_grand_total,
		mech_work_order_dtls.total_taxable_amount,mech_work_order_dtls.total_tax_amount,mech_work_order_dtls.overall_discount,mech_work_order_dtls.overall_discount_amount,
        mech_work_order_dtls.grand_total,mech_work_order_dtls.description,mech_work_order_dtls.work_order_status,mech_work_order_dtls.total_due_amount,mech_work_order_dtls.total_paid_amount,
        mc.client_name, mc.client_contact_no,
        mua.customer_street_1, mua.customer_street_2, mua.area, 
        mua.customer_city, mua.customer_state, mua.customer_country, mua.zip_code,
        cl.name as country_name, msl.state_name, cil.city_name,
		car.model_type,car.car_reg_no,car.car_brand_id,car.car_brand_model_id,car.car_model_year,
		car.car_variant,car.fuel_type,car.engine_number,car.vin,car.total_mileage,car.daily_mileage,car.engine_oil_type,
		car.steering_type,car.air_conditioning,car.car_drive_type,car.transmission_type,
		brand.brand_name,model.model_name,cv.variant_name,
        workshop_branch_details.display_board_name,
        country_lookup.name as countryName,
        mech_state_list.state_name as statename,
        city_lookup.city_name as cityname,
        mech_insurance_billing.mins_id, mech_insurance_billing.insuranceBillingCheckBox, mech_insurance_billing.entity_id, 
        mech_insurance_billing.entity_type, mech_insurance_billing.ins_claim_type, mech_insurance_billing.ins_pro_name, 
        mech_insurance_billing.ins_gstin_no, mech_insurance_billing.contact_name, mech_insurance_billing.contact_number, 
        mech_insurance_billing.contact_email, mech_insurance_billing.contact_street, mech_insurance_billing.contact_area, 
        mech_insurance_billing.contact_country, mech_insurance_billing.contact_state, mech_insurance_billing.contact_city, 
        mech_insurance_billing.contact_pincode, mech_insurance_billing.ins_claim, mech_insurance_billing.policy_no, 
        mech_insurance_billing.driving_license, mech_insurance_billing.ins_start_date, mech_insurance_billing.ins_exp_date, 
        mech_insurance_billing.surveyor_contact_no, mech_insurance_billing.surveyor_name, mech_insurance_billing.surveyor_email, 
        mech_insurance_billing.idv_amount, mech_insurance_billing.ins_claim_no, mech_insurance_billing.date_of_claim, 
        mech_insurance_billing.claim_amount, mech_insurance_billing.ins_approved_amount, mech_insurance_billing.ins_approved_date, 
        mech_insurance_billing.ins_status, mech_insurance_billing.policy_excess,mech_jobcard_status.jobcard_status_id,mech_jobcard_status.status_name,
        mech_work_order_dtls.work_from,mech_work_order_dtls.work_from_id', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_work_order_dtls.issue_date,mech_work_order_dtls.work_order_id', "desc");
    }
	
	public function default_join()
    {
        $this->db->join('mech_insurance_billing' , 'mech_insurance_billing.entity_id = mech_work_order_dtls.work_order_id' , 'left');
        $this->db->join('mech_clients mc', 'mc.client_id = mech_work_order_dtls.customer_id', 'left');
        $this->db->join('mech_user_address mua', 'mua.user_address_id = mech_work_order_dtls.user_address_id', 'left');
        $this->db->join('country_lookup cl','cl.id = mua.customer_country','left');
        $this->db->join('mech_state_list msl','msl.state_id = mua.customer_state','left');
        $this->db->join('city_lookup cil','cil.city_id = mua.customer_city','left');
        $this->db->join('country_lookup','country_lookup.id = mech_insurance_billing.contact_country','left');
        $this->db->join('mech_state_list','mech_state_list.state_id = mech_insurance_billing.contact_state','left');
        $this->db->join('city_lookup','city_lookup.city_id = mech_insurance_billing.contact_city','left');
        $this->db->join('mech_owner_car_list car', 'car.car_list_id=mech_work_order_dtls.customer_car_id', 'left');
		$this->db->join('mech_car_brand_details brand', 'brand.brand_id=car.car_brand_id', 'left');
		$this->db->join('mech_car_brand_models_details model', 'model.model_id=car.car_brand_model_id', 'left');
		$this->db->join('mech_brand_model_variants cv', 'cv.brand_model_variant_id=car.car_variant', 'left');
        $this->db->join('workshop_branch_details', 'workshop_branch_details.w_branch_id = mech_work_order_dtls.branch_id', 'left');
        $this->db->join('mech_jobcard_status', 'mech_jobcard_status.jobcard_status_id = mech_work_order_dtls.jobsheet_status', 'left');
	}
	
	public function default_where(){

        $this->db->where('mech_work_order_dtls.workshop_id' , $this->session->userdata('work_shop_id'));
        if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $this->db->where('mech_work_order_dtls.w_branch_id' , $this->session->userdata('branch_id'));
        }else if($this->session->userdata('user_type') == 6){
            $this->db->where_in('mech_work_order_dtls.w_branch_id' , $this->session->userdata('user_branch_id'));
        }
        $this->db->where('mech_work_order_dtls.status' , "A");
        // $this->db->where('mech_jobcard_status.status' , "A");
    }

    public function get_latest()
    {
        $this->db->order_by('mech_work_order_dtls.work_order_id', 'DESC');
        return $this;
    }

    public function validation_rules()
    {
        return array(
			'invoice_group_id' => array(
				'field' => 'invoice_group_id',
                'label' => trans('lable276'),
                'rules' => 'required'
			),
            'branch_id' => array(
                'field' => 'branch_id',
                'label' => trans('lable95'),
                'rules' => 'required'
            ),
            'customer_car_id' => array(
                'field' => 'customer_car_id',
                'label' => trans('lable280'),
                //'rules' => 'required'
            ),
            'customer_id' => array(
                'field' => 'customer_id',
                'label' => trans('lable279'),
                'rules' => 'required'
            ),
            'user_address_id' => array(
                'field' => 'user_address_id',
                'label' => trans('lable61'),
               // 'rules' => 'required'
            ),
            'url_key' => array(
                'field' => 'url_key'
            ),
            'current_odometer_reading' => array(
                'field' => 'current_odometer_reading',
                'label' => trans('lable283'),
              //  'rules' => 'required'
            ),
            'fuel_level' => array(
                'field' => 'fuel_level',
                'label' => trans('lable284'),
                //'rules' => 'required'
            ),
            'jobsheet_no' => array(
                'field' => 'jobsheet_no',
                // 'label' => trans('jobsheet_no'),
            ),
            'jobsheet_status' => array(
                'field' => 'jobsheet_status',
                'label' => trans('lable861'),
                // 'rules' => 'required'
            ),
            'issue_date' => array(
                'field' => 'issue_date',
                'label' => trans('lable278'),
                'rules' => 'required'
            ),
            'refered_by_type' => array(
                'field' => 'refered_by_type',
                'label' => trans('lable52')
            ),
            'refered_by_id' => array(
                'field' => 'refered_by_id',
                'label' => trans('lable54')
            ),
            'issued_by' => array(
                'field' => 'issued_by',
                'label' => trans('lable287'),
                //'rules' => 'required'
            ),
            'assigned_to' => array(
                'field' => 'assigned_to',
                'label' => trans('lable292'),
               // 'rules' => 'required'
            ),
            'uploadCheckBox' => array(
                'field' => 'uploadCheckBox',
                'label' => trans('lable327'),
            ),
            'work_from' => array(
                'field' => 'work_from',
                'label' => ('Work from'),
            ),
            'work_from_id' => array(
                'field' => 'work_from_id',
                'label' => ('Work from id'),
            ),
            'job_terms_condition' => array(
                'field' => 'job_terms_condition',
            ),
            'next_service_dt' => array(
                'field' => 'next_service_dt',
                'label' => trans('lable299'),
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
        if (!isset($db_array['status'])) {
            $db_array['status'] = 'A';
        }
        $db_array['issue_date'] = $this->input->post('issue_date')?date_to_mysql($this->input->post('issue_date')):NULL;
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

	public function get_service_category_name($cat_id)
    {
    	$this->db->select('category_name');
    	$this->db->where('service_cat_id', $cat_id);
    	$cat = $this->db->get('mechanic_service_category_list');
    	if ($cat->num_rows()) {
    		$category_name = $cat->row()->category_name;
    	} else {
    		$category_name = '-';
    	}
    	return $category_name;
    }

    public function get_service_name($id){
        $this->select('msci.service_item_name');
        $this->db->join('mech_service_item_dtls msci', 'mrsi.service_item=msci.msim_id', 'left');
        //$this->db->join('mech_employee emp', 'emp.employee_id = track.ahc_employee', 'left');
        $this->from('mech_work_order_service_items mrsi');
        $this->db->where('mrsi.work_order_id',$id);     
        $query = $this->db->get();
        return $query->result_array();
    }
	
	public function getWorkOrderIdByJSno($jobsheet_no = null){
        if(!empty($jobsheet_no)){
            $work_order_id = $this->db->select('mech_work_order_dtls.work_order_id')->from('mech_work_order_dtls')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('jobsheet_no',$jobsheet_no)->get()->row()->work_order_id;
            $workOrderDetails = $this->mdl_mech_work_order_dtls->where('work_order_id' , $work_order_id)->get()->row();
            return $workOrderDetails;
		}else{
	        return NULL;
	    }
	}
        
    public function get_user_quote_product_item($work_order_id = null, $user_id  = null)
    {
        if($work_order_id){
            $work_shop_id = $this->session->userdata('work_shop_id');
            $branch_id = $this->session->userdata('branch_id');
            $this->db->select('si.rs_item_id,si.user_id,si.url_key,si.user_car_id,si.car_brand_model_id,si.brand_model_variant_id,si.is_from,si.service_type,si.category_type,si.service_item,si.tax_id,si.item_service_name,si.item_hsn,si.user_item_price,si.mech_item_price,si.item_qty,si.item_discount,si.item_discount_price,si.item_amount,si.igst_pct,si.igst_amount,si.item_total_amount,si.service_status,si.item_work_level,ci.product_id,ci.product_name as item_product_name,ci.product_category_id');
            $this->db->from('mech_work_order_service_items si');
            $this->db->join('mech_products ci', 'ci.product_id = si.service_item');
            $this->db->where('si.is_from', "work_order_product");
            $this->db->where('si.workshop_id='.$work_shop_id.' AND si.w_branch_id='.$branch_id.'');
            $this->db->where('si.work_order_id', $work_order_id);
            $products_items = $this->db->get()->result();
        }else{
            $products_items = array();
        }
        
        return json_encode($products_items);
    }

    public function get_jobsheet_product_ids($work_order_id = null, $user_id  = null)
    {
        if($work_order_id){
            $work_shop_id = $this->session->userdata('work_shop_id');
            $branch_id = $this->session->userdata('branch_id');
            $this->db->select('si.service_item');
            $this->db->from('mech_work_order_service_items si');
            $this->db->join('mech_products ci', 'ci.product_id = si.service_item');
            $this->db->where('si.is_from', "work_order_product");
            $this->db->where('si.workshop_id='.$work_shop_id.' AND si.w_branch_id='.$branch_id.'');
            $this->db->where('si.work_order_id', $work_order_id);
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

    public function get_user_quote_service_item($work_order_id = null, $user_id  = null )
    {
        if($work_order_id){
        	$work_shop_id = $this->session->userdata('work_shop_id');
            $branch_id = $this->session->userdata('branch_id');
            $this->db->select('si.rs_item_id,si.user_id,si.url_key,si.user_car_id,si.car_brand_model_id,si.brand_model_variant_id,si.is_from,si.service_type,si.category_type,si.service_item,si.tax_id,si.item_service_name,si.item_hsn,si.user_item_price,si.mech_item_price,si.item_qty,si.item_discount,si.item_discount_price,si.item_amount,si.igst_pct,si.igst_amount,si.item_total_amount,si.service_status,si.item_work_level,si.employee_id,mi.employee_name,ci.msim_id,ci.service_item_name,ci.service_category_id');
            $this->db->from('mech_work_order_service_items si');
            $this->db->join('mech_service_item_dtls ci', 'ci.msim_id = si.service_item', 'left');
            $this->db->join('mech_employee mi', 'mi.employee_id = si.employee_id','left');
            $this->db->where('si.workshop_id='.$work_shop_id.' AND si.w_branch_id='.$branch_id.'');
            $this->db->where('is_from', 'work_order_service');
            $this->db->where('si.work_order_id', $work_order_id);
            $service_items = $this->db->get()->result();
        }else{
            $service_items = array();
        }
        return json_encode($service_items);
    }

    public function get_user_quote_service_package_item($work_order_id = null, $user_id  = null){
        if($work_order_id){
        	$work_shop_id = $this->session->userdata('work_shop_id');
            $branch_id = $this->session->userdata('branch_id');
            $this->db->select('si.rs_item_id,si.user_id,si.url_key,si.user_car_id,si.car_brand_model_id,si.brand_model_variant_id,si.is_from,si.service_type,si.category_type,si.service_item,si.item_service_name,si.item_hsn,si.user_item_price,si.mech_item_price,si.item_qty,si.item_discount,si.item_discount_price,si.item_amount,si.igst_pct,si.igst_amount,si.item_total_amount,si.service_status,si.item_work_level,si.employee_id,mi.employee_name,ci.s_pack_id ,ci.package_name as service_item_name,ci.category_id as service_category_id');
            $this->db->from('mech_work_order_service_items si');
            $this->db->join('mech_service_packages ci', 'ci.s_pack_id  = si.service_item', 'left');
            $this->db->join('mech_employee mi', 'mi.employee_id = si.employee_id','left');
            $this->db->where('si.workshop_id='.$work_shop_id.' AND si.w_branch_id='.$branch_id.'');
            $this->db->where('is_from', 'work_order_package');
            $this->db->where('si.work_order_id', $work_order_id);
            $service_items = $this->db->get()->result();
        }else{
            $service_items = array();
        }
        return json_encode($service_items);
    }

    public function getRefererTypeName($reference_type_id = NULL){
        if($reference_type_id){
            $work_shop_id = $this->session->userdata('work_shop_id');
            $branch_id = $this->session->userdata('branch_id');
            $this->db->select('refer_name');
            $this->db->from('mech_reference_dtls');
            $this->db->where('mech_reference_dtls.refer_type_id', $reference_type_id);
            return $this->db->get()->row()->refer_name;
        }else{
            return "";
        }
    }

    public function getRefererName($reference_type_id = NULL, $refered_by_id = NULL ){
        if($reference_type_id == 1){
            $refer_name = $this->mdl_mech_employee->where('employee_id', $refered_by_id)->where('employee_status', 1)->get()->row()->employee_name;
            return $refer_name;
        }else if($reference_type_id == 3){
            $refer_name = $this->mdl_clients->where('client_id', $refered_by_id)->where('client_active','A')->get()->row()->client_name;
            return $refer_name;
        }else{
            return "";
        }
    }

    public function updateJobcardPayment($amount,$work_order_id)
	{
		$this->db->set('total_paid_amount', 'total_paid_amount + '.$amount, FALSE);
		$this->db->set('total_due_amount', 'total_due_amount - '.$amount, FALSE);
		$this->db->where('work_order_id',$work_order_id);
		$this->db->update('mech_work_order_dtls');

		$this->db->select('total_due_amount');
		$due = $this->db->get_where("mech_work_order_dtls",array('work_order_id'=>$work_order_id))->row();
	
	}

	public function reduceJobcardPayment($amount,$work_order_id)
	{
		$this->db->set('total_paid_amount', 'total_paid_amount - '.$amount, FALSE);
        $this->db->set('total_due_amount', 'total_due_amount + '.$amount, FALSE);
		$this->db->where('work_order_id',$work_order_id);
		$this->db->update('mech_work_order_dtls');

		$this->db->select('total_due_amount');
		$due = $this->db->get_where("mech_work_order_dtls",array('work_order_id'=>$work_order_id))->row();
		
	}
}