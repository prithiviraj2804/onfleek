<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Mech_Invoice extends Response_Model
{
    public $table = 'mech_invoice';
    public $primary_key = 'mech_invoice.invoice_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mech_invoice.invoice_id,mech_invoice.branch_id,mech_invoice.shift,
        mech_invoice.quote_id,mech_invoice.invoice_group_id,mech_invoice.invoice_no,
        mech_invoice.purchase_no,mech_invoice.jobsheet_no,mech_invoice.customer_id,
        mech_invoice.customer_car_id,mech_invoice.user_address_id,mech_invoice.user_alternative_mobile_no,
        mech_invoice.visit_type,mech_invoice.mode_of_payment,mech_invoice.invoice_date,mech_invoice.next_service_dt,
        mech_invoice.invoice_date_created,mech_invoice.in_days,mech_invoice.invoice_date_due,
        mech_invoice.bank_id,mech_invoice.current_odometer_reading,mech_invoice.next_service_km,mech_invoice.fuel_level,

        mech_invoice.service_mech_total,mech_invoice.service_user_total,mech_invoice.service_total_discount,
        mech_invoice.service_total_discount_pct,mech_invoice.service_total_taxable,mech_invoice.service_total_gst_pct,
        mech_invoice.service_total_gst,mech_invoice.service_grand_total,

        mech_invoice.service_package_mech_total,mech_invoice.service_package_user_total,mech_invoice.service_package_total_discount,
        mech_invoice.service_package_total_discount_pct,mech_invoice.service_package_total_taxable,mech_invoice.service_package_total_gst_pct,
        mech_invoice.service_package_total_gst,mech_invoice.service_package_grand_total,

        mech_invoice.product_user_total,
        mech_invoice.product_mech_total,mech_invoice.product_total_discount,mech_invoice.product_total_taxable,
        mech_invoice.product_total_gst,mech_invoice.product_grand_total,mech_invoice.total_taxable_amount,
        
        mech_invoice.total_tax_amount,mech_invoice.grand_sub_total,mech_invoice.earned_amount,
        mech_invoice.grand_total,mech_invoice.applied_rewards,mech_invoice.total_due_amount,
        mech_invoice.total_paid_amount,mech_invoice.refered_by_type,mech_invoice.refered_by_id,
        mech_invoice.is_credit,mech_invoice.tax_invoice,mech_invoice.cheque_no,mech_invoice.cheque_to,
        mech_invoice.bank_name,mech_invoice.online_payment_ref_no,mech_invoice.payment_method_id,mech_invoice.payment_date,
        mech_invoice.invoice_status,mech_invoice.invoice_category,mech_invoice.workshop_id,
        mech_invoice.w_branch_id,mech_invoice.description,mech_invoice.service_discountstate,mech_invoice.invoice_terms_condition,
        mech_invoice.parts_discountstate,mech_invoice.advance_paid,
        mc.client_name,mc.client_contact_no,
        car.car_list_id,car.owner_id,car.entity_type,car.model_type,car.car_reg_no,
        car.fuel_type,car.vin,.car.total_mileage,car.daily_mileage,car.engine_oil_type,
        car.steering_type,car.air_conditioning,car.car_drive_type,car.transmission_type,
        brand.brand_name,model.model_name,cv.variant_name', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_invoice.invoice_date,mech_invoice.invoice_id', 'DESC');
    }
	
	public function default_join()
    {
        $this->db->join('mech_clients mc', 'mc.client_id = mech_invoice.customer_id', 'left');
        $this->db->join('mech_owner_car_list car', 'car.car_list_id = mech_invoice.customer_car_id', 'left');
		$this->db->join('mech_car_brand_details brand', 'brand.brand_id = car.car_brand_id', 'left');
		$this->db->join('mech_car_brand_models_details model', 'model.model_id = car.car_brand_model_id', 'left');
		$this->db->join('mech_brand_model_variants cv', 'cv.brand_model_variant_id = car.car_variant', 'left');
    }

    public function default_where(){
        $this->db->where('mech_invoice.workshop_id' , $this->session->userdata('work_shop_id'));
		if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $this->db->where('mech_invoice.w_branch_id' , $this->session->userdata('branch_id'));
            $this->db->where('mech_invoice.created_by' , $this->session->userdata('user_id'));
        }else if($this->session->userdata('user_type') == 6){
            $this->db->where_in('mech_invoice.w_branch_id' , $this->session->userdata('user_branch_id'));
		}
        $this->db->where('mech_invoice.invoice_category' ,  "I");
		$this->db->where('mech_invoice.status' , "A");
    }
	
    public function validation_rules()
    {
        return array(
            `customer_id` => array(
                'field' => 'customer_id',
                'label' => trans('lable36'),
                'rules' => 'required'
            ),
            `branch_id` => array(
                'field' => 'branch_id',
                'label' => trans('lable51'),
                'rules' => 'required'
            ),
            `shift` => array(
                'field' => 'shift',
                'label' => trans('lable152'),
            ),
            `invoice_group_id` => array(
                'field' => 'invoice_group_id',
                'label' => trans('lable378'),
                'rules' => 'required'
            ),
            `invoice_date` => array(
                'field' => 'invoice_date',
                'label' => trans('lable368'),
                'rules' => 'required'
            ),
            'mode_of_payment' => array(
                'field' => 'mode_of_payment',
                // 'label' => trans('mode_of_payment'),
            ),
            'fuel_level' => array(
                'field' => 'fuel_level',
                'label' => trans('lable284'),
            ),
            'location_zip_code' => array(
                'field' => 'location_zip_code',
                // 'label' => trans('location_zip_code'),
            ),
            'refered_by_type' => array(
                'field' => 'refered_by_type',
                'label' => trans('lable52'),
            ),
            'refered_by_id' => array(
                'field' => 'refered_by_id',
                'label' => trans('lable291'),
            ),
            'is_credit' => array(
                'field' => 'is_credit',
                'label' => trans('lable883'),
            ),
            'payment_method_id' => array(
                'field' => 'payment_method_id',
                'label' => trans('lable109'),
            ),
            'online_payment_ref_no' => array(
                'field' => 'online_payment_ref_no',
                'label' => trans('lable385'),
            ),
            'payment_date' => array(
                'field' => 'payment_date',
                'label' => trans('lable105'),
            ),
            'invoice_date_created' => array(
                'field' => 'invoice_date_created',
                // 'label' => trans('invoice_date_created'),
            ),
            'in_days' => array(
                'field' => 'in_days',
                'label' => trans('lable387'),
            ),
            'invoice_date_due' => array(
                'field' => 'invoice_date_due',
                'label' => trans('lable127'),
            ),
            'invoice_terms_condition' => array(
                'field' => 'invoice_terms_condition',
            ),
            'next_service_dt' => array(
                'field' => 'next_service_dt',
                'label' => trans('lable299'),
            ),
            'url_key' => array(
                'field' => 'url_key'
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
        $db_array['created_on'] = date('Y-m-d H:i:s');
        $db_array['user_id'] = $this->session->userdata('user_id');
        $db_array['created_by'] = $this->session->userdata('user_id');
        $db_array['modified_by'] = $this->session->userdata('user_id');
        return $db_array;
    }

	public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();
        $db_array['workshop_id'] = $this->session->userdata('work_shop_id');
        $db_array['w_branch_id'] = $this->session->userdata('branch_id'); 
        $db_array['created_on'] = date('Y-m-d H:i:s');
        $db_array['created_by'] = $this->session->userdata('user_id');
        $db_array['modified_by'] = $this->session->userdata('user_id'); 
        $id = parent::save($id, $db_array);
        return $id;
    }
    
	public function updateInvoicePayment($amount,$invoice_id)
	{
		$this->db->set('total_paid_amount', 'total_paid_amount + '.$amount, FALSE);
		$this->db->set('total_due_amount', 'total_due_amount - '.$amount, FALSE);
		$this->db->where('invoice_id',$invoice_id);
		$this->db->update('mech_invoice');

		$this->db->select('total_due_amount');
		$due = $this->db->get_where("mech_invoice",array('invoice_id'=>$invoice_id))->row();
		
		if($due->total_due_amount == 0.00){
            $this->db->set('invoice_status', 'FP');
            $this->db->set('is_credit', 'N');
            $this->db->set('online_payment_ref_no', $this->input->post('online_payment_ref_no'));
            $this->db->set('payment_method_id', $this->input->post('payment_method_id')); 
            $this->db->set('payment_date', $this->input->post('payment_date')?date_to_mysql($this->input->post('payment_date')):date('d/m/Y'));                      
			$this->db->where('invoice_id',$invoice_id);
			$this->db->update('mech_invoice');
		}else{
            $this->db->set('invoice_status', 'PP');
            // $this->db->set('is_credit', 'N');
            // $this->db->set('online_payment_ref_no', $this->input->post('online_payment_ref_no'));
            // $this->db->set('payment_method_id', $this->input->post('payment_method_id'));
            // $this->db->set('payment_date', $this->input->post('payment_date')?date_to_mysql($this->input->post('payment_date')):date('d/m/Y'));                      
			$this->db->where('invoice_id',$invoice_id);
			$this->db->update('mech_invoice');
		}
	}

	public function reduceInvoicePayment($amount,$invoice_id)
	{
		$this->db->set('total_paid_amount', 'total_paid_amount - '.$amount, FALSE);
        $this->db->set('total_due_amount', 'total_due_amount + '.$amount, FALSE);
		$this->db->where('invoice_id',$invoice_id);
		$this->db->update('mech_invoice');

		$this->db->select('total_due_amount');
		$due = $this->db->get_where("mech_invoice",array('invoice_id'=>$invoice_id))->row();
		
		if($due->total_due_amount == 0.00){
            $this->db->set('invoice_status', 'FP');
            $this->db->set('is_credit', 'N');
            $this->db->set('online_payment_ref_no', $this->input->post('online_payment_ref_no'));
            $this->db->set('payment_method_id', $this->input->post('payment_method_id'));
            $this->db->set('payment_date', $this->input->post('payment_date')?date_to_mysql($this->input->post('payment_date')):date('d/m/Y'));                      
			$this->db->where('invoice_id',$invoice_id);
			$this->db->update('mech_invoice');
		}else{
            $this->db->set('invoice_status', 'PP');
            // $this->db->set('is_credit', 'N');
            // $this->db->set('online_payment_ref_no', $this->input->post('online_payment_ref_no'));
            // $this->db->set('payment_method_id', $this->input->post('payment_method_id'));
            // $this->db->set('payment_date', $this->input->post('payment_date')?date_to_mysql($this->input->post('payment_date')):date('d/m/Y'));                      
			$this->db->where('invoice_id',$invoice_id);
			$this->db->update('mech_invoice');
        }
	}
	
	public function get_user_quote_product_item($invoice_id = null, $user_id  = null)
    {
        if($invoice_id){
            $this->db->select('si.item_id,si.invoice_id,si.quote_id,si.user_id,si.is_from,si.service_type,si.category_type,si.service_item,si.tax_id,si.item_service_name,si.item_hsn,si.user_item_price,si.mech_item_price,si.item_qty,si.item_discount,si.item_discount_price,si.item_amount,si.igst_pct,si.igst_amount,si.cgst_pct,si.cgst_amount,si.sgst_pct,si.sgst_amount,si.expiry_date,si.expiry_kilometer,si.warrentry_prd,si.item_total_amount,si.service_status,mp.product_id,mp.url_key,mp.product_name as item_product_name,mp.product_category_id,mp.product_type,mp.unit_type,mp.apply_for_all_bmv,mp.kilo_from,mp.kilo_to,mp.mon_from,mp.mon_to,mp.diff_amount,mp.description');
            $this->db->from('mech_invoice_item si');
            $this->db->join('mech_products mp', 'mp.product_id = si.service_item');
            $this->db->where('si.is_from', 'invoice_product');
            $this->db->where('si.invoice_id', $invoice_id);
            $service_items = $this->db->get()->result();
        }else{
            $service_items = array();
        }
        
        return json_encode($service_items);
    }

    public function get_user_quote_service_item($invoice_id = null)
    {
        if($invoice_id){
        	$work_shop_id = $this->session->userdata('work_shop_id');
			$branch_id = $this->session->userdata('branch_id');
            $this->db->select('si.item_id,si.invoice_id,si.quote_id,si.user_id,si.is_from,si.service_type,si.category_type,si.service_item,si.tax_id,si.item_service_name,si.item_hsn,si.user_item_price,si.mech_item_price,si.item_qty,si.item_discount,si.item_discount_price,si.item_amount,si.igst_pct,si.igst_amount,si.cgst_pct,si.cgst_amount,si.sgst_pct,si.sgst_amount,si.expiry_date,si.expiry_kilometer,si.warrentry_prd,si.item_total_amount,si.service_status,ci.msim_id,ci.service_item_name,ci.service_category_id');
            $this->db->from('mech_invoice_item si');
            $this->db->join('mech_service_item_dtls ci', 'ci.msim_id = si.service_item');
            $this->db->where('si.is_from', 'invoice_service');
            $this->db->where('si.invoice_id', $invoice_id);
            $service_items = $this->db->get()->result();
        }else{
            $service_items = array();
        }
        return json_encode($service_items);
    }

    public function get_user_quote_service_package_item($invoice_id = null)
    {
        if($invoice_id){
        	$work_shop_id = $this->session->userdata('work_shop_id');
			$branch_id = $this->session->userdata('branch_id');
            $this->db->select('si.item_id,si.invoice_id,si.quote_id,si.user_id,si.is_from,si.service_type,si.category_type,si.service_item,si.item_service_name,si.item_hsn,si.user_item_price,si.mech_item_price,si.item_qty,si.item_discount,si.item_discount_price,si.item_amount,si.igst_pct,si.igst_amount,si.cgst_pct,si.cgst_amount,si.sgst_pct,si.sgst_amount,si.expiry_date,si.expiry_kilometer,si.warrentry_prd,si.item_total_amount,si.service_status,ci.s_pack_id ,ci.package_name as service_item_name,ci.category_id as service_category_id');
            $this->db->from('mech_invoice_item si');
            $this->db->join('mech_service_packages ci', 'ci.s_pack_id  = si.service_item', 'left');
            $this->db->where('si.is_from', 'invoice_package');
            $this->db->where('si.invoice_id', $invoice_id);
            $service_items = $this->db->get()->result();
        }else{
            $service_items = array();
        }
        // print_r($service_items);
        return json_encode($service_items);
    }
    
	 public function getTodayTotalIncome()
	 {
		 echo "getTodayTotalIncome";
     }
     
     public function get_user_quote_product_ids($invoice_id = null, $user_id  = null)
     {
         if($invoice_id){
             $this->db->select('si.service_item');
             $this->db->from('mech_invoice_item si');
             $this->db->join('mech_products mp', 'mp.product_id = si.service_item');
             $this->db->where('si.is_from', 'invoice_product');
             $this->db->where('si.invoice_id', $invoice_id);
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

    public function get_user_quote_service_ids($invoice_id = null, $user_id  = null){
        if($invoice_id){
            $this->db->select('si.service_item');
            $this->db->from('mech_invoice_item si');
            $this->db->join('mech_service_item_dtls ci', 'ci.msim_id = si.service_item');
            $this->db->where('si.is_from', 'invoice_service');
            $this->db->where('si.invoice_id', $invoice_id);
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