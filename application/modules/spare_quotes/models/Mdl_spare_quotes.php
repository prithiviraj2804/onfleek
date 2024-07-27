<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Spare_Quotes extends Response_Model
{
    public $table = 'spare_quotes';
    public $primary_key = 'spare_quotes.quote_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS spare_quotes.quote_id, spare_quotes.branch_id,
        spare_quotes.invoice_group_id, spare_quotes.workshop_id, spare_quotes.w_branch_id,
        spare_quotes.quote_no, spare_quotes.customer_id, spare_quotes.user_address_id,
        spare_quotes.quote_date, 
        spare_quotes.parts_discountstate, spare_quotes.product_user_total, spare_quotes.product_mech_total, 
        spare_quotes.product_total_discount,
        spare_quotes.product_total_taxable, spare_quotes.product_total_gst, spare_quotes.product_grand_total,
        spare_quotes.total_taxable_amount, spare_quotes.total_tax_amount, spare_quotes.grand_sub_total,
        spare_quotes.earned_amount, spare_quotes.grand_total, spare_quotes.applied_rewards,
        spare_quotes.total_due_amount, spare_quotes.total_paid_amount, spare_quotes.refered_by_type,
        spare_quotes.refered_by_id, spare_quotes.description, spare_quotes.quote_status,
        mc.client_name', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('spare_quotes.quote_date, spare_quotes.quote_id', 'DESC');
    }
	
	public function default_join()
    {
        $this->db->join('mech_clients mc', 'mc.client_id = spare_quotes.customer_id', 'left');
    }

    public function default_where(){
        $this->db->where('spare_quotes.workshop_id', $this->session->userdata('work_shop_id'));
		if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $this->db->where('spare_quotes.w_branch_id', $this->session->userdata('branch_id'));
            $this->db->where('spare_quotes.created_by', $this->session->userdata('user_id'));
        }else if($this->session->userdata('user_type') == 6){
			$this->db->where_in('spare_quotes.w_branch_id', $this->session->userdata('user_branch_id'));
		}
		$this->db->where('spare_quotes.status' , "A");
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
            $this->db->select('si.item_id,si.quote_id,si.user_id,si.is_from,si.service_type,si.category_type,si.service_item,si.item_service_name,si.tax_id,si.item_hsn,si.user_item_price,si.mech_item_price,si.item_qty,si.item_discount,si.item_amount,si.item_discount_price,si.igst_pct,si.igst_amount,si.cgst_pct,si.cgst_amount,si.sgst_pct,si.sgst_amount,si.expiry_date,si.expiry_kilometer,si.warrentry_prd,si.item_total_amount,si.service_status,mp.product_id,mp.product_name as item_product_name,mp.product_name');
            $this->db->from('spare_quotes_item si');
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

     public function get_user_quote_product_ids($quote_id = null, $user_id  = null)
     {
         if($invoice_id){
             $this->db->select('si.service_item');
             $this->db->from('spare_quotes_item si');
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
}
