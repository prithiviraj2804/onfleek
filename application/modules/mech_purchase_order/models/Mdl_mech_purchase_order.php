<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mdl_Mech_Purchase_Order extends Response_Model
{
    public $table = 'mech_purchase_order';
    public $primary_key = 'mech_purchase_order.purchase_id';
    public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mech_purchase_order.purchase_id, mech_purchase_order.supplier_id,
        mech_purchase_order.workshop_id, mech_purchase_order.w_branch_id, mech_purchase_order.invoice_group_id, 
        mech_purchase_order.url_key, mech_purchase_order.purchase_type_id, mech_purchase_order.convert_to_pur_order, 
        mech_purchase_order.place_of_supply_id, mech_purchase_order.supplier_gstin, mech_purchase_order.export_pos, 
        mech_purchase_order.inter_intra, mech_purchase_order.is_read_only, mech_purchase_order.purchase_date_created, 
        mech_purchase_order.purchase_date_due, mech_purchase_order.purchase_no, 
        mech_purchase_order.mode_of_payment, mech_purchase_order.bank_id, mech_purchase_order.notes, 
        mech_purchase_order.is_credit, mech_purchase_order.in_days, mech_purchase_order.product_user_total, 
        mech_purchase_order.total_taxable_amount, mech_purchase_order.total_discount, mech_purchase_order.total_tax_amount, 
        mech_purchase_order.grand_total, mech_purchase_order.total_due_amount, mech_purchase_order.total_paid_amount, 
        mech_purchase_order.purchase_status, mech_purchase_order.payment_status, 
        sup.supplier_name, sup.supplier_contact_no, sup.supplier_street,
        sup.supplier_city, sup.supplier_state, sup.supplier_pincode, sup.supplier_country', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_purchase_order.purchase_date_created, mech_purchase_order.purchase_id','DESC');
    }

    public function default_join()
    {
        $this->db->join('admin_suppliers sup', 'sup.supplier_id = mech_purchase_order.supplier_id', 'left');

    }

    public function default_where(){
        $this->db->where('mech_purchase_order.workshop_id' , $this->session->userdata('work_shop_id'));
        if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
        $this->db->where('mech_purchase_order.w_branch_id' , $this->session->userdata('branch_id'));
        $this->db->where('mech_purchase_order.created_by' , $this->session->userdata('user_id'));
        }else if($this->session->userdata('user_type') == 6){
        $this->db->where_in('mech_purchase_order.w_branch_id' , $this->session->userdata('user_branch_id'));
        }
        $this->db->where('mech_purchase_order.status' , "A");

    }

    public function get_url_key()
    {
        $this->load->helper('string');
        return random_string('alnum', 15);
    }

    public function validation_rules()
    {
        return array(
            'supplier_id' => array(
                'field' => 'supplier_id',
                'label' => trans('lable80'),
                'rules' => 'required',
            ),
            'invoice_group_id' => array(
                'field' => 'invoice_group_id',
                'label' => trans('lable433'),
                'rules' => 'required',
            ),
            'w_branch_id' => array(
                'field' => 'w_branch_id',
                'label' => trans('lable433'),
                'rules' => 'required',
            ),
            'mode_of_payment' => array(
                'field' => 'mode_of_payment',
                // 'label' => trans('mode_of_payment'),
            ),
            'place_of_supply_id' => array(
                'field' => 'place_of_supply_id',
                'label' => trans('lable446'),
            ),
            'supplier_gstin' => array(
                'field' => 'supplier_gstin',
                'label' => trans('lable84'),
            ),
            'purchase_type_id' => array(
                'field' => 'purchase_type_id',
                'label' => trans('lable434'),
                'rules' => 'required',
            ),
            'purchase_date_created' => array(
                'field' => 'purchase_date_created',
                'label' => trans('lable386'),
            ),
            'purchase_date_due' => array(
                'field' => 'purchase_date_due',
                'label' => trans('lable127'),
            ),
            'url_key' => array(
                'field' => 'url_key',
            ),
            '_mm_csrf' => array(
                'field' => '_mm_csrf',
            ),
        );
    }

    public function db_array()
    {
        $db_array = parent::db_array();
        unset($db_array['_mm_csrf']);
        if (!isset($db_array['status'])) {
            $db_array['status'] = 'A';
        }
        $db_array['created_by'] = $this->session->userdata('user_id');
        $db_array['modified_by'] = $this->session->userdata('user_id');

        return $db_array;
    }

    public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();
        $db_array['created_on'] = date('Y-m-d H:i:s');
        $db_array['created_by'] = $this->session->userdata('user_id');
        $db_array['modified_by'] = $this->session->userdata('user_id'); 
        $id = parent::save($id, $db_array);
        return $id;
    }

    public function get_purchase_product_item($purchase_id = null)
    {
        if ($purchase_id) {
            $this->db->select('mpi.item_id,mpi.user_id,mpi.product_id,mpi.is_available,mpi.item_name,mpi.item_hsn,mpi.item_price,mpi.item_amount,mpi.item_qty,mpi.item_discount,mpi.igst_pct,mpi.igst_amount,mpi.cgst_pct,mpi.cgst_amount,mpi.sgst_pct,mpi.sgst_amount,mpi.item_total_amount,mp.url_key,mp.product_name,mp.product_category_id,mp.unit_type,mp.kilo_from,mp.kilo_to,mp.mon_from,mp.mon_to');
            $this->db->from('mech_purchase_order_item mpi');
            $this->db->join('mech_products mp', 'mp.product_id = mpi.product_id');
            $this->db->where('mpi.purchase_id', $purchase_id);
            $product_items = $this->db->get()->result();
        } else {
            $product_items = array();
        }

        return json_encode($product_items);
    }

    public function get_purchase_product_ids($purchase_id = NULL){
        if ($purchase_id) {
            $work_shop_id = $this->session->userdata('work_shop_id');
            $branch_id = $this->session->userdata('branch_id');
            $this->db->select('mpi.product_id');
            $this->db->from('mech_purchase_order_item mpi');
            $this->db->join('mech_products mp', 'mp.product_id = mpi.product_id');
            $this->db->where('mpi.purchase_id', $purchase_id);
            $products = $this->db->get()->result();
        } else {
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

    public function updatePurchasePayment($amount, $invoice_id)
    {
        $this->db->set('total_paid_amount', 'total_paid_amount + '.$amount, false);
        $this->db->set('total_due_amount', 'total_due_amount - '.$amount, false);
        $this->db->where('purchase_id', $invoice_id);
        $this->db->update('mech_purchase_order');

        $this->db->select('total_due_amount');
        $due = $this->db->get_where('mech_purchase_order', array('purchase_id' => $invoice_id))->row();

        if ($due->total_due_amount == 0.00) {
            $this->db->set('purchase_status', 'FP');
            $this->db->where('purchase_id', $invoice_id);
            $this->db->update('mech_purchase_order');
        } else {
            $this->db->set('purchase_status', 'PP');
            $this->db->where('purchase_id', $invoice_id);
            $this->db->update('mech_purchase_order');
        }
    }

    public function reducePurchasePayment($amount, $invoice_id)
    {
        $this->db->set('total_paid_amount', 'total_paid_amount - '.$amount, false);
        $this->db->set('total_due_amount', 'total_due_amount + '.$amount, false);
        $this->db->where('purchase_id', $invoice_id);
        $this->db->update('mech_purchase_order');

        $this->db->select('total_due_amount');
        $due = $this->db->get_where('mech_purchase_order', array('purchase_id' => $invoice_id))->row();

        if ($due->total_due_amount == 0.00) {
            $this->db->set('purchase_status', 'FP');
            $this->db->where('purchase_id', $invoice_id);
            $this->db->update('mech_purchase_order');
        } else {
            $this->db->set('purchase_status', 'PP');
            $this->db->where('purchase_id', $invoice_id);
            $this->db->update('mech_purchase_order');
        }
    }

    public function updateTotalDueAmount($invoice_id)
    {
        $this->db->select('grand_total,purchase_status');
        $due = $this->db->get_where('mech_purchase_order', array('purchase_id' => $invoice_id))->row();
        $grand_total = $due->grand_total;

        $this->db->select_sum('payment_amount');
        $total_paid = $this->db->get_where('mech_payments', array('entity_id' => $invoice_id, 'entity_type' => 'purchase'))->row();

        $total_paid = $total_paid->payment_amount;
        $total_due_amount = $grand_total - $total_paid;

        $this->db->set('total_paid_amount', $total_paid);
        $this->db->set('total_due_amount', $total_due_amount);
        if ($due->purchase_status != 'D') {
            if ($total_due_amount == 0.00) {
                $this->db->set('purchase_status', 'FP');
            } else {
                $this->db->set('purchase_status', 'PP');
            }
        }
        $this->db->where('purchase_id', $invoice_id);
        $this->db->update('mech_purchase_order');
    }

    public function getSupplierBills($supplierId = null)
    {
        if ($supplierId) {
            $this->mdl_mech_purchase_order->where('mech_purchase_order.status', 'A');
            $this->mdl_mech_purchase_order->where('mech_purchase_order.supplier_id', $supplierId);
            $this->mdl_mech_purchase_order->order_by('mech_purchase_order.supplier_id', 'DESC');
            $product_items = $this->mdl_mech_purchase_order->get()->result();
        } else {
            $product_items = array();
        }

        return $product_items;
    }
}
