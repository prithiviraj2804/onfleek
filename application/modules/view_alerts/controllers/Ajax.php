<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('view_alerts/mdl_view_alerts');
    }

    public function converttopurchaseorder(){

		$this->load->model('mech_purchase_order/mdl_mech_purchase_order');
        $this->load->model('mech_item_master/mdl_mech_item_master');
		$this->load->model('products/mdl_products');

		$mm_csrf = $this->input->post('_mm_csrf');
		$product_items = $this->input->post('product_items');
		
        $db_array = array(
            'workshop_id' => $this->session->userdata('work_shop_id'),
            'w_branch_id' => $this->session->userdata('branch_id'),
        );

        $this->db->insert('mech_purchase', $db_array);
        $purchase_id = $this->db->insert_id();

        for($i = 0 ; $i < count($product_items); $i++){
            if (!empty($product_items[$i])){
                $product = $this->db->select('a.*, b.mrp_price, b.cost_price, b.sale_price')->from('mech_products as a')->join('mech_product_price_list as b','b.product_id = a.product_id','left')->where('a.product_id', $product_items[$i])->get()->row();
                $igst_amount = (($product->cost_price?$product->cost_price:0) * ($product->tax_percentage?$product->tax_percentage:0)) / 100;
                $item_total_amount = ($product->cost_price?$product->cost_price:0) + $igst_amount;
                $product_array = array(
                    'purchase_id' => $purchase_id,
                    'user_id' => $this->session->userdata('user_id'),
                    'product_id' => $product->product_id,
                    'item_name' => $product->product_name?$product->product_name:NULL,
                    'item_hsn' => $product->hsn_code?$product->hsn_code:NULL,
                    'item_qty' => $product->product_qty?$product->product_qty:1,
                    'item_price' => $product->cost_price?$product->cost_price:NULL,
                    'item_amount' => $product->item_amount?$product->item_amount:NULL,
                    'item_discount'=> $product->item_discount?$product->item_discount:0,
                    'igst_pct'=> $product->tax_percentage?$product->tax_percentage:0,
                    'igst_amount'=> $igst_amount?$igst_amount:0,
                    'cgst_pct'=> $product->cgst_pct?$product->cgst_pct:0,
                    'cgst_amount'=> $product->cgst_amount?$product->cgst_amount:0,
                    'sgst_pct'=> $product->sgst_pct?$product->sgst_pct:0,
                    'sgst_amount'=> $product->sgst_amount?$product->sgst_amount:0,
                    'item_total_amount'=> $item_total_amount?$item_total_amount:0,
                    'created_on' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('user_id'),
                    'modified_by' => $this->session->userdata('user_id'),
                );
                $this->db->insert('mech_purchase_order_item', $product_array);
            }
        }

        $response = array(
            'success' => 1,
            'purchase_id' => $purchase_id
        );
        echo json_encode($response);
		exit();
	}
   
}

