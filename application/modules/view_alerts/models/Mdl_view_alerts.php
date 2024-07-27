<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class mdl_view_alerts extends Response_Model
{
    public function getViewAlerts(){
        $this->db->select('a.product_id, a.product_name, a.part_number, b.balance_stock, c.sale_price, c.cost_price, c.mrp_price');
        $this->db->from('mech_products as a');
        $this->db->join('mech_product_price_list as c','c.product_id = a.product_id','left');
        $this->db->join('mech_product_stock_details as b','b.product_id = a.product_id and b.workshop_id = '.$this->session->userdata('work_shop_id'),'left');
        $this->db->where('b.balance_stock <= a.reorder_quantity');
        $this->db->where_in('a.workshop_id', array('1',$this->session->userdata('work_shop_id')));
        return $this->db->get()->result();
    }

}