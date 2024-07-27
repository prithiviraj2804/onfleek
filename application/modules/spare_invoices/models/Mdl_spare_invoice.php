<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Spare_Invoice extends Response_Model
{
    public $table = 'spare_invoice';
    public $primary_key = 'spare_invoice.invoice_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS spare_invoice.invoice_id, spare_invoice.branch_id,
        spare_invoice.quote_id, spare_invoice.invoice_group_id, spare_invoice.invoice_no,
        spare_invoice.customer_id, spare_invoice.user_address_id, spare_invoice.user_alternative_mobile_no,
        spare_invoice.visit_type, spare_invoice.mode_of_payment, spare_invoice.invoice_date,
        spare_invoice.invoice_date_created, spare_invoice.in_days, spare_invoice.invoice_date_due,
        spare_invoice.bank_id,

        spare_invoice.product_user_total, spare_invoice.parts_discountstate,
        spare_invoice.product_mech_total, spare_invoice.product_total_discount, spare_invoice.product_total_taxable,
        spare_invoice.product_total_gst, spare_invoice.product_grand_total, spare_invoice.total_taxable_amount,
        
        spare_invoice.total_tax_amount, spare_invoice.grand_sub_total, spare_invoice.earned_amount,
        spare_invoice.grand_total, spare_invoice.applied_rewards, spare_invoice.total_due_amount,
        spare_invoice.total_paid_amount, spare_invoice.refered_by_type, spare_invoice.refered_by_id,
        spare_invoice.is_credit, spare_invoice.cheque_no, spare_invoice.cheque_to,
        spare_invoice.bank_name, spare_invoice.online_payment_ref_no, spare_invoice.payment_method_id,
        spare_invoice.payment_date,
        spare_invoice.invoice_status, spare_invoice.invoice_category, spare_invoice.workshop_id,
        spare_invoice.w_branch_id, spare_invoice.description, spare_invoice.advance_paid,
        mc.client_name,mc.client_contact_no', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('spare_invoice.invoice_date,spare_invoice.invoice_id', 'DESC');
    }
	
	public function default_join()
    {
        $this->db->join('mech_clients mc', 'mc.client_id = spare_invoice.customer_id', 'left');
    }

    public function default_where(){
        $this->db->where('spare_invoice.workshop_id' , $this->session->userdata('work_shop_id'));
		if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $this->db->where('spare_invoice.w_branch_id' , $this->session->userdata('branch_id'));
            $this->db->where('spare_invoice.created_by' , $this->session->userdata('user_id'));
        }else if($this->session->userdata('user_type') == 6){
            $this->db->where_in('spare_invoice.w_branch_id' , $this->session->userdata('user_branch_id'));
		}
        $this->db->where('spare_invoice.invoice_category' ,  "I");
		$this->db->where('spare_invoice.status' , "A");
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
		$this->db->update('spare_invoice');

		$this->db->select('total_due_amount');
		$due = $this->db->get_where("spare_invoice",array('invoice_id'=>$invoice_id))->row();
		
		if($due->total_due_amount == 0.00){
            $this->db->set('invoice_status', 'FP');
            $this->db->set('is_credit', 'N');
            $this->db->set('online_payment_ref_no', $this->input->post('online_payment_ref_no'));
            $this->db->set('payment_method_id', $this->input->post('payment_method_id')); 
            $this->db->set('payment_date', $this->input->post('payment_date')?date_to_mysql($this->input->post('payment_date')):date('d/m/Y'));                      
			$this->db->where('invoice_id',$invoice_id);
			$this->db->update('spare_invoice');
		}else{
            $this->db->set('invoice_status', 'PP');
            // $this->db->set('is_credit', 'N');
            // $this->db->set('online_payment_ref_no', $this->input->post('online_payment_ref_no'));
            // $this->db->set('payment_method_id', $this->input->post('payment_method_id'));
            // $this->db->set('payment_date', $this->input->post('payment_date')?date_to_mysql($this->input->post('payment_date')):date('d/m/Y'));                      
			$this->db->where('invoice_id',$invoice_id);
			$this->db->update('spare_invoice');
		}
	}

	public function reduceInvoicePayment($amount,$invoice_id)
	{
		$this->db->set('total_paid_amount', 'total_paid_amount - '.$amount, FALSE);
        $this->db->set('total_due_amount', 'total_due_amount + '.$amount, FALSE);
		$this->db->where('invoice_id',$invoice_id);
		$this->db->update('spare_invoice');

		$this->db->select('total_due_amount');
		$due = $this->db->get_where("spare_invoice",array('invoice_id'=>$invoice_id))->row();
		
		if($due->total_due_amount == 0.00){
            $this->db->set('invoice_status', 'FP');
            $this->db->set('is_credit', 'N');
            $this->db->set('online_payment_ref_no', $this->input->post('online_payment_ref_no'));
            $this->db->set('payment_method_id', $this->input->post('payment_method_id'));
            $this->db->set('payment_date', $this->input->post('payment_date')?date_to_mysql($this->input->post('payment_date')):date('d/m/Y'));                      
			$this->db->where('invoice_id',$invoice_id);
			$this->db->update('spare_invoice');
		}else{
            $this->db->set('invoice_status', 'PP');
            // $this->db->set('is_credit', 'N');
            // $this->db->set('online_payment_ref_no', $this->input->post('online_payment_ref_no'));
            // $this->db->set('payment_method_id', $this->input->post('payment_method_id'));
            // $this->db->set('payment_date', $this->input->post('payment_date')?date_to_mysql($this->input->post('payment_date')):date('d/m/Y'));                      
			$this->db->where('invoice_id',$invoice_id);
			$this->db->update('spare_invoice');
        }
	}
	
	public function get_user_quote_product_item($invoice_id = null, $user_id  = null)
    {
        if($invoice_id){
            $this->db->select('si.item_id,si.invoice_id,si.quote_id,si.user_id,si.is_from,si.service_type,si.category_type,si.service_item,si.tax_id,si.item_service_name,si.item_hsn,si.user_item_price,si.mech_item_price,si.item_qty,si.item_discount,si.item_discount_price,si.item_amount,si.igst_pct,si.igst_amount,si.cgst_pct,si.cgst_amount,si.sgst_pct,si.sgst_amount,si.expiry_date,si.expiry_kilometer,si.warrentry_prd,si.item_total_amount,si.service_status,mp.product_id,mp.url_key,mp.product_name as item_product_name,mp.product_category_id,mp.product_type,mp.unit_type,mp.apply_for_all_bmv,mp.kilo_from,mp.kilo_to,mp.mon_from,mp.mon_to,mp.diff_amount,mp.description');
            $this->db->from('spare_invoice_item si');
            $this->db->join('mech_products mp', 'mp.product_id = si.service_item');
            $this->db->where('si.is_from', 'invoice_product');
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
            $this->db->from('spare_invoice_item si');
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

}
