<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Suppliers extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_suppliers');
        $this->load->model('mech_purchase/mdl_mech_purchase');
        $this->load->model('suppliers_category/mdl_suppliers_category');
        $this->load->model('mech_bank_list/mdl_mech_bank_list');
        $this->load->model('settings/mdl_settings');
        $this->load->helper('client');
    }

    public function index($page = 0)
    {

        $limit = 15;
        $query = $this->mdl_suppliers->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();
        $this->mdl_suppliers->limit($limit);
        $suppliers = $this->mdl_suppliers->get()->result();
        
        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A'")->result();
        }else{
            $branch_list = array();
        }
        $this->layout->set(
            array(
                'suppliers' => $suppliers,
                'branch_list' => $branch_list,
                'createLinks' => $createLinks,
                'suppliercategory' => $this->mdl_suppliers_category->get()->result(),
            )
        );

        $this->layout->buffer('content', 'suppliers/index');
        $this->layout->render();
    }

    public function form($id = null, $tab = null)
    {
        
        if ($this->input->post('btn_cancel')) {
            redirect('suppliers');
        }

        if ($this->mdl_suppliers->run_validation()) {
            $id = $this->mdl_suppliers->save($id);
            if ($this->input->post('btn_submit') == '2' || $this->input->post('btn_submit') == 2) {
                redirect('suppliers/form/');
            } else {
                redirect('suppliers/form/'.$id);
            }
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_suppliers->prep_form($id)) {
                show_404();
            }

            $this->mdl_suppliers->set_form_value('is_update', true);

            if ($this->mdl_suppliers->form_value('supplier_country', true)) {
                $state_list = $this->mdl_settings->getStateList($this->mdl_suppliers->form_value('supplier_country', true));
            } else {
                $state_list = $this->db->query('SELECT state_id,state_name,country_id FROM mech_state_list')->result();
            }

            if ($this->mdl_suppliers->form_value('supplier_state', true)) {
                $city_list = $this->mdl_settings->getCityList($this->mdl_suppliers->form_value('supplier_state', true));
            } else {
                $city_list = $this->db->query('SELECT city_id,city_name,state_id,country_id FROM city_lookup')->result();
            }
            if($this->session->userdata('user_type') == 3){
                $payments = $this->db->query('SELECT *,ip.payment_method_name FROM mech_payments AS mp left join ip_payment_methods ip on ip.payment_method_id=mp.payment_method_id WHERE mp.customer_id ='.$id.' AND mp.workshop_id = '.$this->session->userdata('work_shop_id').'')->result();
            }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 || $this->session->userdata('user_type') == 6){
                $payments = $this->db->query('SELECT *,ip.payment_method_name FROM mech_payments AS mp left join ip_payment_methods ip on ip.payment_method_id=mp.payment_method_id WHERE mp.customer_id ='.$id.' AND mp.workshop_id = '.$this->session->userdata('work_shop_id').' AND mp.w_branch_id = '.$this->session->userdata('branch_id').' AND mp.created_by = '.$this->session->userdata('user_id').'')->result();
            }
            
            $breadcrumb = "lable91";
        } else {
            $state_list = $this->db->query('SELECT state_id,state_name,country_id FROM mech_state_list')->result();
            $city_list = $this->db->query('SELECT city_id,city_name,state_id,country_id FROM city_lookup')->result();
            $breadcrumb = "lable90";
            $payments = array();
        }
        
        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A'")->result();
        }else{
            $branch_list = array();
        }
        $invoice_group_number = $this->db->query("SELECT * FROM ip_invoice_groups where module_type = 'supplier' AND workshop_id = '".$this->session->userdata('work_shop_id')."' ORDER BY invoice_group_id ASC LIMIT 1")->row();

        $this->layout->set(
            array(
                'active_tab' => $tab,
                'breadcrumb' => $breadcrumb,
                'branch_list' => $branch_list,
                'invoice_group_number' => $invoice_group_number,
                'payments' => $payments,
                'country_list' => $this->db->query('SELECT * FROM country_lookup')->result(),
                'state_list' => $state_list,
                'city_list' => $city_list,
                'area_list' => $this->db->get_where('mech_area_list', array('status' => 1))->result(),
                'pincode_list' => $this->db->get_where('mech_area_pincode', array('status' => 'A'))->result(),
                'purchase_list' => $this->mdl_mech_purchase->getSupplierBills($id),
                'workshop_bank_list' => $this->mdl_mech_bank_list->where('mech_workshop_bank_list.workshop_id', $this->session->userdata('work_shop_id'))->where('mech_workshop_bank_list.entity_id', $id)->where('mech_workshop_bank_list.module_type', 'S')->get()->result(),
                'suppliercategory' => $this->mdl_suppliers_category->get()->result(),
            )
        );

        $this->layout->buffer('content', 'suppliers/form');
        $this->layout->render();
    }

    public function delete()
    {
        $id = $this->input->post('id');
        $this->db->where('mech_suppliers.supplier_id', $id);
        $this->db->update('mech_suppliers', array('supplier_active' => '2'));
        $response = array(
            'success' => 1
        );
        echo json_encode($response);
    }
}
