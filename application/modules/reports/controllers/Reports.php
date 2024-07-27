<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends Admin_Controller
{
   
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_reports');
        $this->load->model('clients/mdl_clients');
        $this->load->model('suppliers/mdl_suppliers');
        $this->load->model('mech_item_master/mdl_mech_item_master');
        $this->load->model('user_cars/mdl_user_cars');
        $this->load->model('mech_invoices/mdl_mech_invoice');
        $this->load->model('user_address/mdl_user_address');  
        $this->load->model('families/mdl_families');
    }

    public function index(){
        $this->layout->set('is_product', $this->db->query("SELECT is_product FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND created_by = ".$this->session->userdata('user_id')." ")->row()->is_product);
        $this->layout->buffer('content', 'reports/index')->render();
    }

    public function customer_due_report()
    {
        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
        }else{
            $branch_list = array();
        }

        if ($this->input->post('btn_submit')) {
            $results = $this->mdl_reports->customer_due_report($this->input->post('from_date'), $this->input->post('to_date'), $this->input->post('user_branch_id'));
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $user_branch_id = $this->input->post('user_branch_id');
        }else{
            $results = $this->mdl_reports->customer_due_report(date($this->session->userdata('default_php_date_format')), date($this->session->userdata('default_php_date_format')), $this->session->userdata('branch_id'));
            $from_date = date_from_mysql(date('Y-m-d'));
            $to_date = date_from_mysql(date('Y-m-d'));
            $user_branch_id = $branch_list[0]->w_branch_id;
        }
       
        $this->layout->set(array(
            'results' => $results,
            'branch_list' => $branch_list,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'user_branch_id' => $user_branch_id,
        ));
        $this->layout->buffer('content', 'reports/customer_due_report');
        $this->layout->render();
    }

    public function service_summary(){

        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
        }else{
            $branch_list = array();
        }

        if ($this->input->post('btn_submit')) {
            $results = $this->mdl_reports->service_by_summary($this->input->post('from_date'), $this->input->post('to_date'), $this->input->post('user_branch_id'));
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $user_branch_id = $this->input->post('user_branch_id');
        }else{
            $results = $this->mdl_reports->service_by_summary(date($this->session->userdata('default_php_date_format')), date($this->session->userdata('default_php_date_format')), $this->session->userdata('branch_id'));
            $from_date = date_from_mysql(date('Y-m-d'));
            $to_date = date_from_mysql(date('Y-m-d'));
            $user_branch_id = $branch_list[0]->w_branch_id;
        }
       
        $this->layout->set(array(
            'results' => $results,
            'branch_list' => $branch_list,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'user_branch_id' => $user_branch_id,
        ));
        $this->layout->buffer('content', 'reports/service_summary_index')->render();

    }

    public function service_category_rep(){

        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
        }else{
            $branch_list = array();
        }

        if ($this->input->post('btn_submit')) {
            $results = $this->mdl_reports->service_category($this->input->post('from_date'), $this->input->post('to_date'), $this->input->post('user_branch_id'));
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $user_branch_id = $this->input->post('user_branch_id');
        }else{
            $results = $this->mdl_reports->service_category(date($this->session->userdata('default_php_date_format')), date($this->session->userdata('default_php_date_format')), $this->session->userdata('branch_id'));
            $from_date = date_from_mysql(date('Y-m-d'));
            $to_date = date_from_mysql(date('Y-m-d'));
            $user_branch_id = $branch_list[0]->w_branch_id;
        }
       
        $this->layout->set(array(
            'results' => $results,
            'branch_list' => $branch_list,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'user_branch_id' => $user_branch_id,
        ));
        $this->layout->buffer('content', 'reports/sales_service_index');
        $this->layout->render();
    }

    // public function sales_service_by_client()
    // {
    //     if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
    //         $branch_list = $this->db->query("SELECT * FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
    //     }else if($this->session->userdata('user_type') == 3){
    //         $branch_list = $this->db->query("SELECT * FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A' ")->result();
    //     }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 || $this->session->userdata('user_type') == 6){
    //         $branch_list = $this->db->query("SELECT * FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A' ")->result();
    //     }

    //     if ($this->input->post('btn_submit')) {
    //         $results = $this->mdl_reports->sales_service_by_client($this->input->post('from_date'), $this->input->post('to_date'), $this->input->post('user_branch_id'));
    //         $from_date = $this->input->post('from_date');
    //         $to_date = $this->input->post('to_date');
    //         $user_branch_id = $this->input->post('user_branch_id');
    //     }else{
    //         $results = $this->mdl_reports->sales_service_by_client(date('d/m/Y'), date('d/m/Y'), $this->session->userdata('branch_id'));
    //         $from_date = date('d/m/Y');
    //         $to_date = date('d/m/Y');
    //         $user_branch_id = $branch_list[0]->w_branch_id;
    //     }
       
    //     $this->layout->set(array(
    //         'results' => $results,
    //         'branch_list' => $branch_list,
    //         'from_date' => $from_date,
    //         'to_date' => $to_date,
    //         'user_branch_id' => $user_branch_id,
    //     ));
    //     $this->layout->buffer('content', 'reports/sales_service_by_client_index');
    //     $this->layout->render();
    // }

    public function sales_summary(){

        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
        }else{
            $branch_list = array();
        }

        if ($this->input->post('btn_submit')) {
            $results = $this->mdl_reports->sales_by_summary($this->input->post('from_date'), $this->input->post('to_date'), $this->input->post('user_branch_id'));
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $user_branch_id = $this->input->post('user_branch_id');
        }else{
            $results = $this->mdl_reports->sales_by_summary(date($this->session->userdata('default_php_date_format')), date($this->session->userdata('default_php_date_format')), $this->session->userdata('branch_id'));
            $from_date = date_from_mysql(date('Y-m-d'));
            $to_date = date_from_mysql(date('Y-m-d'));
            $user_branch_id = $branch_list[0]->w_branch_id;
        }
       
        $this->layout->set(array(
            'results' => $results,
            'branch_list' => $branch_list,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'user_branch_id' => $user_branch_id,
        ));
        $this->layout->buffer('content', 'reports/sales_summary_index');
        $this->layout->render();
    }

    public function sales_by_product(){

        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
        }else{
            $branch_list = array();
        }
       
        if ($this->input->post('btn_submit')) {
            $results = $this->mdl_reports->sales_by_product($this->input->post('from_date'), $this->input->post('to_date'), $this->input->post('user_branch_id'));
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $user_branch_id = $this->input->post('user_branch_id');
        }else{
            $results = $this->mdl_reports->sales_by_product(date($this->session->userdata('default_php_date_format')), date($this->session->userdata('default_php_date_format')), $this->session->userdata('branch_id'));
            $from_date = date_from_mysql(date('Y-m-d'));
            $to_date = date_from_mysql(date('Y-m-d'));
            $user_branch_id = $branch_list[0]->w_branch_id;
        }
       
        $this->layout->set(array(
            'results' => $results,
            'branch_list' => $branch_list,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'user_branch_id' => $user_branch_id,
        ));
        $this->layout->buffer('content', 'reports/sales_product_index');
        $this->layout->render();
    }
    
    public function sales_product_by_client()
    {
        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
        }else{
            $branch_list = array();
        }
       
        if ($this->input->post('btn_submit')) {
            $results = $this->mdl_reports->sales_product_by_client($this->input->post('from_date'), $this->input->post('to_date'), $this->input->post('user_branch_id'));
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $user_branch_id = $this->input->post('user_branch_id');
        }else{
            $results = $this->mdl_reports->sales_product_by_client(date($this->session->userdata('default_php_date_format')), date($this->session->userdata('default_php_date_format')), $this->session->userdata('branch_id'));
            $from_date = date_from_mysql(date('Y-m-d'));
            $to_date = date_from_mysql(date('Y-m-d'));
            $user_branch_id = $branch_list[0]->w_branch_id;
        }
       
        $this->layout->set(array(
            'results' => $results,
            'branch_list' => $branch_list,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'user_branch_id' => $user_branch_id,
        ));
        $this->layout->buffer('content', 'reports/sales_product_by_client_index');
        $this->layout->render();
    }

    public function expense_details(){

        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
        }else{
            $branch_list = array();
        }
       
        if ($this->input->post('btn_submit')) {
            $results = $this->mdl_reports->expense_detail($this->input->post('from_date'), $this->input->post('to_date'), $this->input->post('user_branch_id'));
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $user_branch_id = $this->input->post('user_branch_id');
        }else{ 
            $results = $this->mdl_reports->expense_detail(date($this->session->userdata('default_php_date_format')), date($this->session->userdata('default_php_date_format')), explode(',',$this->session->userdata('branch_id')));
            $from_date = date_from_mysql(date('Y-m-d'));
            $to_date = date_from_mysql(date('Y-m-d'));
            $user_branch_id = $branch_list[0]->w_branch_id;
        }

        $string = json_encode($user_branch_id);
        $string = str_replace(array('["'),'',$string);
        $string = str_replace(array('"'),'',$string);
        $string = str_replace(array(']'),'',$string);

        $this->layout->set(array(
            'results' => $results,
            'branch_list' => $branch_list,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'user_branch_id' => $string,
        ));
        $this->layout->buffer('content', 'reports/expense_detail_index')->render();
    }

    public function expense_by_category(){

        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
        }else{
            $branch_list = array();
        }

        if ($this->input->post('btn_submit')) {
            $results = $this->mdl_reports->expense_by_category($this->input->post('from_date'), $this->input->post('to_date'), $this->input->post('user_branch_id'));
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $user_branch_id = $this->input->post('user_branch_id');
            $shift = $this->input->post('shift');
            $expense_head_id = $this->input->post('expense_head_id');
        }else{
            $results = $this->mdl_reports->expense_by_category(date($this->session->userdata('default_php_date_format')), date($this->session->userdata('default_php_date_format')), $this->session->userdata('branch_id'));
            $from_date = date_from_mysql(date('Y-m-d'));
            $to_date = date_from_mysql(date('Y-m-d'));
            $user_branch_id = $branch_list[0]->w_branch_id;
            $shift = $this->input->post('shift');
            $expense_head_id = $this->input->post('expense_head_id');
        }
       
        $this->layout->set(array(
            'results' => $results,
            'branch_list' => $branch_list,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'user_branch_id' => $user_branch_id,
            'shift' => $shift,
            'expense_head_id' => $expense_head_id,
        ));
        $this->layout->buffer('content', 'reports/expense_category_index')->render();
    }

    public function payment_history()
    {
        if ($this->input->post('btn_submit')) {
            $data = array(
                'results' => $this->mdl_reports->payment_history($this->input->post('from_date'), $this->input->post('to_date')),
                'from_date' => $this->input->post('from_date'),
                'to_date' => $this->input->post('to_date'),
            );

            $html = $this->load->view('reports/payment_history', $data, true);

            $this->load->helper('mpdf');

            pdf_create($html, trans('payment_history'), true);
        }

        $this->layout->buffer('content', 'reports/payment_history_index')->render();
    }

    public function invoice_aging()
    {
        if ($this->input->post('btn_submit')) {
            $data = array(
                'results' => $this->mdl_reports->invoice_aging()
            );

            $this->load->helper('client');
            $html = $this->load->view('reports/invoice_aging', $data, true);

            $this->load->helper('mpdf');

            pdf_create($html, trans('invoice_aging'), true);
        }

        $this->layout->buffer('content', 'reports/invoice_aging_index')->render();
    }

    public function sales_by_year()
    {

        if ($this->input->post('btn_submit')) {
            $data = array(
                'results' => $this->mdl_reports->sales_by_year($this->input->post('from_date'), $this->input->post('to_date'), $this->input->post('minQuantity'), $this->input->post('maxQuantity'), $this->input->post('checkboxTax')),
                'from_date' => $this->input->post('from_date'),
                'to_date' => $this->input->post('to_date'),
            );

            $html = $this->load->view('reports/sales_by_year', $data, true);

            $this->load->helper('mpdf');

            pdf_create($html, trans('sales_by_date'), true);
        }

        $this->layout->buffer('content', 'reports/sales_by_year_index')->render();
    }


    public function sales()
    {

        if ($this->input->post('btn_submit')) {
            $data = array(
                'results' => $this->mdl_reports->sales_by_year($this->input->post('from_date'), $this->input->post('to_date'), $this->input->post('minQuantity'), $this->input->post('maxQuantity'), $this->input->post('checkboxTax')),
                'from_date' => $this->input->post('from_date'),
                'to_date' => $this->input->post('to_date'),
            );

            $html = $this->load->view('reports/sales_by_year', $data, true);

            $this->load->helper('mpdf');

            pdf_create($html, trans('sales_by_date'), true);
        }

        $this->layout->buffer('content', 'reports/sales_by_year_index')->render();
    }

    public function purchase()
    {

        if ($this->input->post('btn_submit')) {
            $data = array(
                'results' => $this->mdl_reports->sales_by_year($this->input->post('from_date'), $this->input->post('to_date'), $this->input->post('minQuantity'), $this->input->post('maxQuantity'), $this->input->post('checkboxTax')),
                'from_date' => $this->input->post('from_date'),
                'to_date' => $this->input->post('to_date'),
            );

            $html = $this->load->view('reports/sales_by_year', $data, true);

            $this->load->helper('mpdf');

            pdf_create($html, trans('sales_by_date'), true);
        }

        $this->layout->buffer('content', 'reports/sales_by_year_index')->render();
    }

    public function expense()
    {

        if ($this->input->post('btn_submit')) {
            $data = array(
                'results' => $this->mdl_reports->sales_by_year($this->input->post('from_date'), $this->input->post('to_date'), $this->input->post('minQuantity'), $this->input->post('maxQuantity'), $this->input->post('checkboxTax')),
                'from_date' => $this->input->post('from_date'),
                'to_date' => $this->input->post('to_date'),
            );

            $html = $this->load->view('reports/sales_by_year', $data, true);

            $this->load->helper('mpdf');

            pdf_create($html, trans('sales_by_date'), true);
        }

        $this->layout->buffer('content', 'reports/sales_by_year_index')->render();
    }

    public function margin_by_products()
    {

        if ($this->input->post('btn_submit')) {
            $data = array(
                'results' => $this->mdl_reports->sales_by_year($this->input->post('from_date'), $this->input->post('to_date'), $this->input->post('minQuantity'), $this->input->post('maxQuantity'), $this->input->post('checkboxTax')),
                'from_date' => $this->input->post('from_date'),
                'to_date' => $this->input->post('to_date'),
            );

            $html = $this->load->view('reports/sales_by_year', $data, true);

            $this->load->helper('mpdf');

            pdf_create($html, trans('sales_by_date'), true);
        }

        $this->layout->buffer('content', 'reports/sales_by_year_index')->render();
    }
    public function margin_by_services()
    {

        if ($this->input->post('btn_submit')) {
            $data = array(
                'results' => $this->mdl_reports->sales_by_year($this->input->post('from_date'), $this->input->post('to_date'), $this->input->post('minQuantity'), $this->input->post('maxQuantity'), $this->input->post('checkboxTax')),
                'from_date' => $this->input->post('from_date'),
                'to_date' => $this->input->post('to_date'),
            );

            $html = $this->load->view('reports/sales_by_year', $data, true);

            $this->load->helper('mpdf');

            pdf_create($html, trans('sales_by_date'), true);
        }

        $this->layout->buffer('content', 'reports/sales_by_year_index')->render();
    }

    public function todaysreport(){

        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
        }else{
            $branch_list = array();
        }

        if ($this->input->post('btn_submit')) {
            $todaysreport = $this->mdl_reports->todaysreportinvoice( $this->input->post('from_date'),  $this->input->post('to_date'), $this->input->post('user_branch_id'));
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $user_branch_id = $this->input->post('user_branch_id');
        }else{
            $branch = array($this->session->userdata('branch_id'));
            $todaysreport = $this->mdl_reports->todaysreportinvoice(date($this->session->userdata('default_php_date_format')), date($this->session->userdata('default_php_date_format')), $branch);
            $from_date = date_from_mysql(date('Y-m-d'));
            $to_date = date_from_mysql(date('Y-m-d'));
            $user_branch_id = 'ALL';
        }

        $string = json_encode($user_branch_id);
        $string = str_replace(array('["'),'',$string);
        $string = str_replace(array('"'),'',$string);
        $string = str_replace(array(']'),'',$string);
        
        $this->layout->set(array(
            'todaysreport' => $todaysreport,
            'branch_list' => $branch_list,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'user_branch_id' => $string,
        ));

        $this->layout->buffer('content', 'reports/todaysreport')->render();
    }

    public function generate_pdf($report_name = Null, $from_date = Null, $to_date = Null, $branch_id = Null, $refered_by_type = NULL,$refered_by_id = NULL){
       
        if($report_name == "CustomerLedgerReport" ){
            $data = array(
                'branch_id' => $branch_id,
                'customer_id' => $refered_by_type,
            ); 
        }else if($report_name == "SupplierLedgerReport"){
            $data = array(
                'branch_id' => $branch_id,
                'supplier_id' => $refered_by_type,
            ); 
        }else if($report_name == "ProductLedgerReport"){
            $data = array(
                'branch_id' => $branch_id,
                'product_id' => $refered_by_type,
            ); 
        }else if($report_name == "PurchaseSummaryReport"){
            $data = array(
                'branch_id' => $branch_id,
            ); 
        }else{
            $data = array(
                'branch_id' => $branch_id,
                'refered_by_type' => $refered_by_type,
                'refered_by_id' => $refered_by_id,
            );
        }
        $this->load->helper('pdf');
        generate_reports($report_name,date_from_mysql($from_date),date_from_mysql($to_date),$data);
    }

    public function generate_history_pdf($report_name = Null, $vehicle_no = Null){
       
        if($report_name == "ServiceHistoryReport"){
            $data = array(
                'vehicle_no' => $vehicle_no,
            ); 
        }else{
            $data = array(
                'vehicle_no' => $vehicle_no,
            );
        }
        $this->load->helper('pdf');
        generate_history_reports($report_name,$vehicle_no);
    }

    public function generate_inventory_pdf($report_name = Null,$product_name = Null,$product_category = Null){
        if($product_name){
            $product_namee = str_replace("%20"," ",$product_name);
        }
        $this->load->helper('pdf');
        generate_inventory_reports($report_name,$product_namee,$product_category);
    }
    public function generate_inventory_lowstock_pdf($report_name = Null,$product_name = Null,$product_category = Null){
        if($product_name){
            $product_namee = str_replace("%20"," ",$product_name);
        }        
        $this->load->helper('pdf');
        generate_inventory_lowstock_reports($report_name,$product_namee,$product_category);
    }

    public function reference_type_report()
    {
        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
        }else{
            $branch_list = array();
        }

        if ($this->input->post('btn_submit')) {
            $results = $this->mdl_reports->reference_type_report($this->input->post('from_date'), $this->input->post('to_date'), $this->input->post('user_branch_id'),$this->input->post('refered_by_type'),$this->input->post('refered_by_id'));
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $user_branch_id = $this->input->post('user_branch_id');
            $refered_by_type = $this->input->post('refered_by_type');
            $refered_by_id = $this->input->post('refered_by_id');
        }else {
            $results = $this->mdl_reports->reference_type_report(date($this->session->userdata('default_php_date_format')), date($this->session->userdata('default_php_date_format')));
            $from_date = date_from_mysql(date('Y-m-d'));
            $to_date = date_from_mysql(date('Y-m-d'));
            $user_branch_id = ' ';
            $refered_by_type = ' ';
            $refered_by_id = ' ';
        }

        $reference_type_list = $this->db->get_where('mech_reference_dtls', array('status' => 1))->result();

        if($this->input->post('refered_by_type') == '2'){
            $refered_dtls = $this->db->get_where('mech_employee', array('mech_employee.employee_status' => 1, 'mech_employee.workshop_id' => $this->session->userdata('work_shop_id')))->result();
        }elseif($this->input->post('refered_by_type') == '1'){
            $refered_dtls = $this->mdl_clients->where('client_active','A')->get()->result();
        }elseif($this->input->post('refered_by_type') == '3'){
            $refered_dtls = $this->mdl_suppliers->where('supplier_active','1')->get()->result();
        }else{
            $refered_dtls = array();
        }
        $this->layout->set(array(
            'results' => $results,
            'branch_list' => $branch_list,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'user_branch_id' => $user_branch_id,
            'refered_by_type' => $refered_by_type,
            'refered_by_id' => $refered_by_id,
            'reference_type_list' => $reference_type_list,
            'refered_dtls' => $refered_dtls,

        ));
        $this->layout->buffer('content', 'reports/reference_type_report');
        $this->layout->render();
    }
    public function customer_ledger()
    {
        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
        }else{
            $branch_list = array();
        }

        if ($this->input->post('btn_submit')) {
            $results = $this->mdl_reports->customer_ledger($this->input->post('from_date'), $this->input->post('to_date'), $this->input->post('user_branch_id'),$this->input->post('customer_id'));
            $customer_info = $this->mdl_reports->customernameledger($this->input->post('customer_id'));
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $user_branch_id = $this->input->post('user_branch_id');
            $customer_id = $this->input->post('customer_id');
        }else {
            $results = $this->mdl_reports->customer_ledger(date($this->session->userdata('default_php_date_format')), date($this->session->userdata('default_php_date_format')));
            $customer_info = $this->mdl_reports->customernameledger();
            $from_date = date_from_mysql(date('Y-m-d'));
            $to_date = date_from_mysql(date('Y-m-d'));
            $user_branch_id = $branch_list[0]->w_branch_id;
            $customer_id = ' ';

        }

        $customer_dtls = $this->mdl_clients->where('client_active','A')->get()->result();

        $this->layout->set(array(
            'results' => $results,
            'customer_info' => $customer_info,
            'branch_list' => $branch_list,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'user_branch_id' => $user_branch_id,
            'customer_dtls' => $customer_dtls,
            'customer_id' => $customer_id,
        ));
        $this->layout->buffer('content', 'reports/customer_ledger');
        $this->layout->render();

    }

    public function supplier_ledger()
    {
        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
        }else{
            $branch_list = array();
        }

        if ($this->input->post('btn_submit')) {
            $results = $this->mdl_reports->supplier_ledger($this->input->post('from_date'), $this->input->post('to_date'), $this->input->post('user_branch_id'),$this->input->post('supplier_id'));
            $supplier_info = $this->mdl_reports->suppliernameledger($this->input->post('supplier_id'));
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $user_branch_id = $this->input->post('user_branch_id');
            $supplier_id = $this->input->post('supplier_id');
        }else {
            $results = $this->mdl_reports->supplier_ledger(date($this->session->userdata('default_php_date_format')), date($this->session->userdata('default_php_date_format')));
            $supplier_info = $this->mdl_reports->suppliernameledger();
            $from_date = date_from_mysql(date('Y-m-d'));
            $to_date = date_from_mysql(date('Y-m-d'));
            $user_branch_id = $branch_list[0]->w_branch_id;
            $supplier_id = ' ';

        }
        $suppliers_dtls = $this->mdl_suppliers->where('supplier_active','1')->get()->result();


        $this->layout->set(array(
            'results' => $results,
            'supplier_info' => $supplier_info,
            'branch_list' => $branch_list,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'user_branch_id' => $user_branch_id,
            'suppliers_dtls' => $suppliers_dtls,
            'supplier_id' => $supplier_id,
        ));
        $this->layout->buffer('content', 'reports/supplier_ledger');
        $this->layout->render();

    }
    public function product_ledger()
    {
        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
        }else{
            $branch_list = array();
        }

        if ($this->input->post('btn_submit')) {
            $results = $this->mdl_reports->product_ledger($this->input->post('from_date'), $this->input->post('to_date'), $this->input->post('user_branch_id'),$this->input->post('product_id'));
            $product_info = $this->mdl_reports->productnameledger($this->input->post('product_id'));
            $results_sales = $this->mdl_reports->product_ledger_salesreport($this->input->post('from_date'), $this->input->post('to_date'), $this->input->post('user_branch_id'),$this->input->post('product_id'));
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $user_branch_id = $this->input->post('user_branch_id');
            $product_id = $this->input->post('product_id');
        }else {
            $results = $this->mdl_reports->product_ledger(date($this->session->userdata('default_php_date_format')), date($this->session->userdata('default_php_date_format')));
            $results_sales = $this->mdl_reports->product_ledger_salesreport(date($this->session->userdata('default_php_date_format')), date($this->session->userdata('default_php_date_format')));
            $product_info = $this->mdl_reports->productnameledger();
            $from_date = date_from_mysql(date('Y-m-d'));
            $to_date = date_from_mysql(date('Y-m-d'));
            $user_branch_id = $branch_list[0]->w_branch_id;
            $product_id = ' ';

        }
        
        $product_dtls = $this->mdl_mech_item_master->where('mech_products.status','A')->get()->result();

        $this->layout->set(array(
            'results' => $results,
            'results_sales' => $results_sales,
            'product_info' => $product_info,
            'branch_list' => $branch_list,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'user_branch_id' => $user_branch_id,
            'product_dtls' => $product_dtls,
            'product_id' => $product_id,
        ));
        $this->layout->buffer('content', 'reports/product_ledger');
        $this->layout->render();

    }
    public function purchase_summary(){

        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
        }else{
            $branch_list = array();
        }

        if ($this->input->post('btn_submit')) {
            $results = $this->mdl_reports->purchase_by_summary($this->input->post('from_date'), $this->input->post('to_date'), $this->input->post('user_branch_id'));
            $from_date = $this->input->post('from_date');
            $to_date = $this->input->post('to_date');
            $user_branch_id = $this->input->post('user_branch_id');
        }else{
            $results = $this->mdl_reports->purchase_by_summary(date($this->session->userdata('default_php_date_format')), date($this->session->userdata('default_php_date_format')), $this->session->userdata('branch_id'));
            $from_date = date_from_mysql(date('Y-m-d'));
            $to_date = date_from_mysql(date('Y-m-d'));
            $user_branch_id = $branch_list[0]->w_branch_id;
        }
       
        $this->layout->set(array(
            'results' => $results,
            'branch_list' => $branch_list,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'user_branch_id' => $user_branch_id,
        ));
        $this->layout->buffer('content', 'reports/purchase_summary_index');
        $this->layout->render();
    }

    public function service_history(){

        $vehicle_no = $this->input->post('vehicle_no');

        if ($this->input->post('btn_submit')) {
            $mech_invoices = $this->mdl_reports->vehicle_service_history($this->input->post('vehicle_no'));
        }else{
            $mech_invoices = $this->mdl_reports->vehicle_service_history($this->input->post('vehicle_no'));
        }

        $this->layout->set(array(
            'mech_invoices' => $mech_invoices,
            'vehicle_no'=> $vehicle_no,
        ));

        $this->layout->buffer('content', 'reports/service_history_index');
        $this->layout->render();        
    }

    public function inventory_hand(){

        $product_category = $this->input->post('product_category_id');
        $product_name = $this->input->post('product_name');

        if ($this->input->post('btn_submit')) {
            $results = $this->mdl_reports->product_inventory_hand($product_name,$product_category);
        }else{
            $results = $this->mdl_reports->product_inventory_hand($product_name,$product_category);
        }

        $this->layout->set(array(
            'results' => $results,
            'families' => $this->mdl_families->get()->result(),
            'product_name' => $product_name,
            'product_category' => $product_category,
        ));

        $this->layout->buffer('content', 'reports/inventory_hand_index');
        $this->layout->render();        
    }

    public function inventory_lowstock(){

        $product_category = $this->input->post('product_category_id');
        $product_name = $this->input->post('product_name');

        if ($this->input->post('btn_submit')) {
            $results = $this->mdl_reports->product_inventory_lowstock($product_name,$product_category);
        }else{
            $results = $this->mdl_reports->product_inventory_lowstock($product_name,$product_category);
        }

        $this->layout->set(array(
            'results' => $results,
            'families' => $this->mdl_families->get()->result(),
            'product_name' => $product_name,
            'product_category' => $product_category,
        ));

        $this->layout->buffer('content', 'reports/inventory_lowstock_index');
        $this->layout->render();        
    }

    public function getvehiclenos($vehicle_no = Null){
        $this->db->select('car_reg_no');
        $this->db->from('mech_owner_car_list');
        $this->db->like('car_reg_no', $vehicle_no);
        $this->db->where('mech_owner_car_list.status', 1);
        $result = $this->db->get()->result();

        $vehicle_list = array();

        if(count($result) > 0){
           foreach($result as $res){
               array_push($vehicle_list , $res->car_reg_no);
           }
        }

        $response = array(
            'success' => 1,
            'result' => $result,
            'vehicle_list' => $vehicle_list,
        );

        echo json_encode($response);

    } 
    

}
