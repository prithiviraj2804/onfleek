<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Mech_Quotes extends Response_Model
{
    public $table = 'mech_quotes';
    public $primary_key = 'mech_quotes.quote_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mech_quotes.quote_id,mech_quotes.branch_id,mech_quotes.shift,
        mech_quotes.current_odometer_reading,mech_quotes.invoice_group_id,mech_quotes.workshop_id,mech_quotes.w_branch_id,
        mech_quotes.quote_no,mech_quotes.purchase_no,
        mech_quotes.customer_id,mech_quotes.customer_car_id,mech_quotes.user_address_id,
        mech_quotes.quote_date,
        mech_quotes.service_discountstate, mech_quotes.service_mech_total,mech_quotes.service_user_total,
        mech_quotes.service_total_discount,mech_quotes.service_total_discount_pct,mech_quotes.service_total_taxable,
        mech_quotes.service_total_gst_pct,mech_quotes.service_total_gst,mech_quotes.service_grand_total,

        mech_quotes.service_package_mech_total,mech_quotes.service_package_user_total,
        mech_quotes.packagediscountstate,mech_quotes.service_package_total_discount,
        mech_quotes.service_package_total_discount_pct,mech_quotes.service_package_total_taxable,
        mech_quotes.service_package_total_gst_pct,mech_quotes.service_package_total_gst,mech_quotes.service_package_grand_total,

        mech_quotes.product_user_total,mech_quotes.product_mech_total,mech_quotes.product_total_discount,
        mech_quotes.product_total_taxable,mech_quotes.product_total_gst,mech_quotes.product_grand_total,
        mech_quotes.total_taxable_amount,mech_quotes.total_tax_amount,mech_quotes.grand_sub_total,
        mech_quotes.earned_amount,mech_quotes.grand_total,mech_quotes.applied_rewards,
        mech_quotes.total_due_amount,mech_quotes.total_paid_amount,mech_quotes.refered_by_type,
        mech_quotes.parts_discountstate,mech_quotes.refered_by_id,mech_quotes.description,
        mech_quotes.quote_status,mech_quotes.quote_terms_condition,
        mc.client_name,
        car.car_list_id,car.owner_id,car.entity_type,car.model_type,car.car_reg_no,
        car.fuel_type,car.vin,.car.total_mileage,car.daily_mileage,car.engine_oil_type,
        car.steering_type,car.air_conditioning,car.car_drive_type,car.transmission_type,
        brand.brand_name,model.model_name,cv.variant_name', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_quotes.quote_date,mech_quotes.quote_id', 'DESC');
    }
	
	public function default_join()
    {
        $this->db->join('mech_clients mc', 'mc.client_id = mech_quotes.customer_id', 'left');
        $this->db->join('mech_owner_car_list car', 'car.car_list_id = mech_quotes.customer_car_id', 'left');
		$this->db->join('mech_car_brand_details brand', 'brand.brand_id = car.car_brand_id', 'left');
		$this->db->join('mech_car_brand_models_details model', 'model.model_id = car.car_brand_model_id', 'left');
		$this->db->join('mech_brand_model_variants cv', 'cv.brand_model_variant_id = car.car_variant', 'left');
    }

    public function default_where(){
        $this->db->where('mech_quotes.workshop_id', $this->session->userdata('work_shop_id'));
		if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $this->db->where('mech_quotes.w_branch_id', $this->session->userdata('branch_id'));
            $this->db->where('mech_quotes.created_by', $this->session->userdata('user_id'));
        }else if($this->session->userdata('user_type') == 6){
			$this->db->where_in('mech_quotes.w_branch_id', $this->session->userdata('user_branch_id'));
		}
		$this->db->where('mech_quotes.status' , "A");
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
            `quote_date` => array(
                'field' => 'quote_date',
                'label' => trans('lable841'),
                'rules' => 'required'
            ),
            'refered_by_type' => array(
                'field' => 'refered_by_type',
                'label' => trans('lable52'),
            ),
            'refered_by_id' => array(
                'field' => 'refered_by_id',
                'label' => trans('lable291'),
            ),
            'quote_terms_condition' => array(
                'field' => 'quote_terms_condition',
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





    public function get_user_quote_product_item($quote_id = null, $user_id  = null)
    {
        if($quote_id){
        	$work_shop_id = $this->session->userdata('work_shop_id');
			$branch_id = $this->session->userdata('branch_id');
            $this->db->select('si.item_id,si.quote_id,si.user_id,si.is_from,si.service_type,si.category_type,si.service_item,si.item_service_name,si.tax_id,si.item_hsn,si.user_item_price,si.mech_item_price,si.item_qty,si.item_discount,si.item_discount_price,si.item_amount,si.igst_pct,si.igst_amount,si.cgst_pct,si.cgst_amount,si.sgst_pct,si.sgst_amount,si.expiry_date,si.expiry_kilometer,si.warrentry_prd,si.item_total_amount,si.service_status,mp.product_id,mp.product_name as item_product_name,mp.product_name');
            $this->db->from('mech_quotes_item si');
            $this->db->join('mech_products mp', 'mp.product_id = si.service_item');
            if($this->session->userdata('user_type') == 3){
				$this->db->where('si.workshop_id='.$work_shop_id.'');
			}elseif($this->session->userdata('user_type') == 4){
				$this->db->where('si.workshop_id='.$work_shop_id.' AND si.w_branch_id='.$branch_id.'');
			}
            $this->db->where('si.is_from', 'quote_product');
            $this->db->where('si.quote_id', $quote_id);
            $service_items = $this->db->get()->result();
        }else{
            $service_items = "";
        }
        
        return json_encode($service_items);
    }

    public function get_user_quote_service_item($quote_id = null)
    {
        if($quote_id){
        	$work_shop_id = $this->session->userdata('work_shop_id');
			$branch_id = $this->session->userdata('branch_id');
            $this->db->select('si.item_id,si.quote_id,si.user_id,si.is_from,si.service_type,si.category_type,si.service_item,si.tax_id,si.item_service_name,si.item_hsn,si.user_item_price,si.mech_item_price,si.item_qty,si.item_discount,si.item_discount_price,si.item_amount,si.igst_pct,si.igst_amount,si.cgst_pct,si.cgst_amount,si.sgst_pct,si.sgst_amount,si.expiry_date,si.expiry_kilometer,si.warrentry_prd,si.item_total_amount,si.service_status,ci.msim_id,ci.service_item_name,ci.service_category_id');
            $this->db->from('mech_quotes_item si');
            $this->db->join('mech_service_item_dtls ci', 'ci.msim_id = si.service_item');
            if($this->session->userdata('user_type') == 3){
				$this->db->where('si.workshop_id='.$work_shop_id.'');
			}elseif($this->session->userdata('user_type') == 4){
				$this->db->where('si.workshop_id='.$work_shop_id.' AND si.w_branch_id='.$branch_id.'');
			}
            $this->db->where('si.is_from', 'quote_service');
            $this->db->where('si.quote_id', $quote_id);
            $service_items = $this->db->get()->result();
        }else{
            $service_items = "";
        }
        return json_encode($service_items);
    }

    public function get_user_quote_service_package_item($quote_id = null)
    {
        if($quote_id){
        	$work_shop_id = $this->session->userdata('work_shop_id');
			$branch_id = $this->session->userdata('branch_id');
            $this->db->select('si.item_id,si.quote_id,si.user_id,si.is_from,si.service_type,si.category_type,si.service_item,si.item_service_name,si.item_hsn,si.user_item_price,si.mech_item_price,si.item_qty,si.item_discount,si.item_discount_price,si.item_amount,si.igst_pct,si.igst_amount,si.cgst_pct,si.cgst_amount,si.sgst_pct,si.sgst_amount,si.expiry_date,si.expiry_kilometer,si.warrentry_prd,si.item_total_amount,si.service_status,ci.s_pack_id ,ci.package_name as service_item_name,ci.category_id as service_category_id');
            $this->db->from('mech_quotes_item si');
            $this->db->join('mech_service_packages ci', 'ci.s_pack_id  = si.service_item', 'left');
            if($this->session->userdata('user_type') == 3){
				$this->db->where('si.workshop_id='.$work_shop_id.'');
			}elseif($this->session->userdata('user_type') == 4){
				$this->db->where('si.workshop_id='.$work_shop_id.' AND si.w_branch_id='.$branch_id.'');
			}
            $this->db->where('si.is_from', 'quote_package');
            $this->db->where('si.quote_id', $quote_id);
            $service_items = $this->db->get()->result();
        }else{
            $service_items = "";
        }
        return json_encode($service_items);
    }

     public function get_user_quote_product_ids($quote_id = null, $user_id  = null)
     {
         if($invoice_id){
             $this->db->select('si.service_item');
             $this->db->from('mech_quotes_item si');
             $this->db->join('mech_products mp', 'mp.product_id = si.service_item');
             $this->db->where('si.is_from', 'quote_product');
             $this->db->where('si.quote_id', $quote_id);
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

    public function get_user_quote_service_ids($quote_id = null, $user_id  = null){
        if($invoice_id){
            $this->db->select('si.service_item');
            $this->db->from('mech_quotes_item si');
            $this->db->join('mech_service_item_dtls ci', 'ci.msim_id = si.service_item');
            $this->db->where('si.is_from', 'quote_service');
            $this->db->where('si.quote_id', $quote_id);
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
