<?php


if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function get_chart_data()
    {
        $type = $this->input->post('type');
        if(date('D')!='Sun')
        {    
            $weekStart = date('Y-m-d',strtotime('last Sunday'));    
        }else{
            $weekStart = date('Y-m-d');   
        }
        if(date('D')!='Sat')
        {
            $weekEnd = date('Y-m-d',strtotime('next Saturday'));
        }else{
            $weekEnd = date('Y-m-d');
        }

        if($this->input->post('type') == "D"){
            $date1 = date_create(date('Y-m-d'));
            $date2 = date_create(date('Y-m-d'));
        }else if($this->input->post('type') == "W"){
            $date1 = date_create($weekStart);
            $date2 = date_create($weekEnd);
        }else if($this->input->post('type') == "M"){
            $date1 = date_create(date('Y-m-01'));
            $date2 = date_create(date('Y-m-t'));
        }

        if ($this->session->userdata('user_type') == 3) {
            if($this->input->post('type') == "D"){
                if($this->session->userdata('plan_type') != 3){
                    $invoice_details = $this->db->select('SUM(grand_total) as grand_total,DATE(invoice_date) as created_on')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', 'A')->where('invoice_date BETWEEN "'.date('Y-m-d').'" and "'.date('Y-m-d').'"')->group_by('invoice_date')->get('mech_invoice')->result();
                }else{
                    $invoice_details = $this->db->select('SUM(grand_total) as grand_total,DATE(invoice_date) as created_on')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', 'A')->where('invoice_date BETWEEN "'.date('Y-m-d').'" and "'.date('Y-m-d').'"')->group_by('invoice_date')->get('spare_invoice')->result();
                }
                $purchase_details = $this->db->select('SUM(grand_total) as grand_total,purchase_date_created as date_created')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', '1')->where('purchase_date_created BETWEEN "'.date('Y-m-d').'" and "'.date('Y-m-d').'"')->group_by('purchase_date_created')->get('mech_purchase')->result();
                $expenese_details = $this->db->select('SUM(grand_total) as grand_total,expense_date as date_created')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', '1')->where('expense_date BETWEEN "'.date('Y-m-d').'" and "'.date('Y-m-d').'"')->group_by('expense_date')->get('mech_expense')->result();
            }else if($this->input->post('type') == "W"){
                if($this->session->userdata('plan_type') != 3){
                    $invoice_details = $this->db->select('SUM(grand_total) as grand_total,DATE(invoice_date) as created_on')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', 'A')->where('invoice_date BETWEEN "'.$weekStart.'" and "'.$weekEnd.'"')->group_by('invoice_date')->get('mech_invoice')->result();
                }else{
                    $invoice_details = $this->db->select('SUM(grand_total) as grand_total,DATE(invoice_date) as created_on')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', 'A')->where('invoice_date BETWEEN "'.$weekStart.'" and "'.$weekEnd.'"')->group_by('invoice_date')->get('spare_invoice')->result();
                }
                $purchase_details = $this->db->select('SUM(grand_total) as grand_total,purchase_date_created as date_created')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', '1')->where('purchase_date_created BETWEEN "'.$weekStart.'" and "'.$weekEnd.'"')->group_by('purchase_date_created')->get('mech_purchase')->result();
                $expenese_details = $this->db->select('SUM(grand_total) as grand_total,expense_date as date_created')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', '1')->where('expense_date BETWEEN "'.$weekStart.'" and "'.$weekEnd.'"')->group_by('expense_date')->get('mech_expense')->result();
            }else if($this->input->post('type') == "M"){
                if($this->session->userdata('plan_type') != 3){
                    $invoice_details = $this->db->select('SUM(grand_total) as grand_total,DATE(invoice_date) as created_on')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', 'A')->where('invoice_date BETWEEN "'.date('Y-m-01').'" and "'.date('Y-m-t').'"')->group_by('invoice_date')->get('mech_invoice')->result();
                }else{
                    $invoice_details = $this->db->select('SUM(grand_total) as grand_total,DATE(invoice_date) as created_on')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', 'A')->where('invoice_date BETWEEN "'.date('Y-m-01').'" and "'.date('Y-m-t').'"')->group_by('invoice_date')->get('spare_invoice')->result();
                }
                $purchase_details = $this->db->select('SUM(grand_total) as grand_total,purchase_date_created as date_created')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', '1')->where('purchase_date_created BETWEEN "'.date('Y-m-01').'" and "'.date('Y-m-t').'"')->group_by('purchase_date_created')->get('mech_purchase')->result();
                $expenese_details = $this->db->select('SUM(grand_total) as grand_total,expense_date as date_created')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', '1')->where('expense_date BETWEEN "'.date('Y-m-01').'" and "'.date('Y-m-t').'"')->group_by('expense_date')->get('mech_expense')->result();
            }else{
                if($this->session->userdata('plan_type') != 3){
                    $invoice_details = $this->db->select('SUM(grand_total) as grand_total,DATE(invoice_date) as created_on')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', 'A')->group_by('invoice_date')->get('mech_invoice')->result();
                }else{
                    $invoice_details = $this->db->select('SUM(grand_total) as grand_total,DATE(invoice_date) as created_on')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', 'A')->group_by('invoice_date')->get('spare_invoice')->result();
                }
                $purchase_details = $this->db->select('SUM(grand_total) as grand_total,purchase_date_created as date_created')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', '1')->group_by('purchase_date_created')->get('mech_purchase')->result();
                $expenese_details = $this->db->select('SUM(grand_total) as grand_total,expense_date as date_created')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', '1')->group_by('expense_date')->get('mech_expense')->result();
            }
        } elseif ($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5) {
            if($this->input->post('type') == "D"){
                if($this->session->userdata('plan_type') != 3){
                    $invoice_details = $this->db->select('SUM(grand_total) as grand_total,DATE(invoice_date) as created_on')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', 'A')->where('mech_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('invoice_date BETWEEN "'.date('Y-m-d').'" and "'.date('Y-m-d').'"')->group_by('invoice_date')->get('mech_invoice')->result();
                }else{
                    $invoice_details = $this->db->select('SUM(grand_total) as grand_total,DATE(invoice_date) as created_on')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', 'A')->where('spare_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('invoice_date BETWEEN "'.date('Y-m-d').'" and "'.date('Y-m-d').'"')->group_by('invoice_date')->get('spare_invoice')->result();
                }
                $purchase_details = $this->db->select('SUM(grand_total) as grand_total,purchase_date_created as date_created')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('mech_purchase.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', '1')->where('purchase_date_created BETWEEN "'.date('Y-m-d').'" and "'.date('Y-m-d').'"')->group_by('purchase_date_created')->get('mech_purchase')->result();
                $expenese_details = $this->db->select('SUM(grand_total) as grand_total,expense_date as date_created')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('mech_expense.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', '1')->where('expense_date BETWEEN "'.date('Y-m-d').'" and "'.date('Y-m-d').'"')->group_by('expense_date')->get('mech_expense')->result();
            }else if($this->input->post('type') == "W"){
                if($this->session->userdata('plan_type') != 3){
                    $invoice_details = $this->db->select('SUM(grand_total) as grand_total,DATE(invoice_date) as created_on')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', 'A')->where('mech_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('invoice_date BETWEEN "'.$weekStart.'" and "'.$weekEnd.'"')->group_by('invoice_date')->get('mech_invoice')->result();
                }else{
                    $invoice_details = $this->db->select('SUM(grand_total) as grand_total,DATE(invoice_date) as created_on')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', 'A')->where('spare_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('invoice_date BETWEEN "'.$weekStart.'" and "'.$weekEnd.'"')->group_by('invoice_date')->get('spare_invoice')->result();
                }
                $purchase_details = $this->db->select('SUM(grand_total) as grand_total,purchase_date_created as date_created')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('mech_purchase.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', '1')->where('purchase_date_created BETWEEN "'.$weekStart.'" and "'.$weekEnd.'"')->group_by('purchase_date_created')->get('mech_purchase')->result();
                $expenese_details = $this->db->select('SUM(grand_total) as grand_total,expense_date as date_created')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('mech_expense.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', '1')->where('expense_date BETWEEN "'.$weekStart.'" and "'.$weekEnd.'"')->group_by('expense_date')->get('mech_expense')->result();
            }else if($this->input->post('type') == "M"){
                if($this->session->userdata('plan_type') != 3){
                    $invoice_details = $this->db->select('SUM(grand_total) as grand_total,DATE(invoice_date) as created_on')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', 'A')->where('mech_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('invoice_date BETWEEN "'.date('Y-m-01').'" and "'.date('Y-m-t').'"')->group_by('invoice_date')->get('mech_invoice')->result();
                }else{
                    $invoice_details = $this->db->select('SUM(grand_total) as grand_total,DATE(invoice_date) as created_on')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', 'A')->where('spare_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('invoice_date BETWEEN "'.date('Y-m-01').'" and "'.date('Y-m-t').'"')->group_by('invoice_date')->get('spare_invoice')->result();
                }
                $purchase_details = $this->db->select('SUM(grand_total) as grand_total,purchase_date_created as date_created')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('mech_purchase.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', '1')->where('purchase_date_created BETWEEN "'.date('Y-m-01').'" and "'.date('Y-m-t').'"')->group_by('purchase_date_created')->get('mech_purchase')->result();
                $expenese_details = $this->db->select('SUM(grand_total) as grand_total,expense_date as date_created')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('mech_expense.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', '1')->where('expense_date BETWEEN "'.date('Y-m-01').'" and "'.date('Y-m-t').'"')->group_by('expense_date')->get('mech_expense')->result();
            }else{
                if($this->session->userdata('plan_type') != 3){
                    $invoice_details = $this->db->select('SUM(grand_total) as grand_total,DATE(invoice_date) as created_on')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', 'A')->where('mech_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->group_by('invoice_date')->get('mech_invoice')->result();
                }else{
                    $invoice_details = $this->db->select('SUM(grand_total) as grand_total,DATE(invoice_date) as created_on')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', 'A')->where('spare_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->group_by('invoice_date')->get('spare_invoice')->result();
                }
                $purchase_details = $this->db->select('SUM(grand_total) as grand_total,purchase_date_created as date_created')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('mech_purchase.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', '1')->group_by('purchase_date_created')->get('mech_purchase')->result();
                $expenese_details = $this->db->select('SUM(grand_total) as grand_total,expense_date as date_created')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('mech_expense.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', '1')->group_by('expense_date')->get('mech_expense')->result();
            }
        } elseif ($this->session->userdata('user_type') == 6) {
            if($this->input->post('type') == "D"){
                if($this->session->userdata('plan_type') != 3){
                    $invoice_details = $this->db->select('SUM(grand_total) as grand_total,DATE(invoice_date) as created_on')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', 'A')->where_in('mech_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->where('invoice_date BETWEEN "'.date('Y-m-d').'" and "'.date('Y-m-d').'"')->group_by('invoice_date')->get('mech_invoice')->result();
                }else{
                    $invoice_details = $this->db->select('SUM(grand_total) as grand_total,DATE(invoice_date) as created_on')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', 'A')->where_in('spare_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->where('invoice_date BETWEEN "'.date('Y-m-d').'" and "'.date('Y-m-d').'"')->group_by('invoice_date')->get('spare_invoice')->result();  
                }
                $purchase_details = $this->db->select('SUM(grand_total) as grand_total,purchase_date_created as date_created')->where('workshop_id', $this->session->userdata('work_shop_id'))->where_in('mech_purchase.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', '1')->where('purchase_date_created BETWEEN "'.date('Y-m-d').'" and "'.date('Y-m-d').'"')->group_by('purchase_date_created')->get('mech_purchase')->result();
                $expenese_details = $this->db->select('SUM(grand_total) as grand_total,expense_date as date_created')->where('workshop_id', $this->session->userdata('work_shop_id'))->where_in('mech_expense.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', '1')->where('expense_date BETWEEN "'.date('Y-m-d').'" and "'.date('Y-m-d').'"')->group_by('expense_date')->get('mech_expense')->result();
            }else if($this->input->post('type') == "W"){
                if($this->session->userdata('plan_type') != 3){
                    $invoice_details = $this->db->select('SUM(grand_total) as grand_total,DATE(invoice_date) as created_on')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', 'A')->where_in('mech_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->where('invoice_date BETWEEN "'.$weekStart.'" and "'.$weekEnd.'"')->group_by('invoice_date')->get('mech_invoice')->result();
                }else{
                    $invoice_details = $this->db->select('SUM(grand_total) as grand_total,DATE(invoice_date) as created_on')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', 'A')->where_in('spare_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->where('invoice_date BETWEEN "'.$weekStart.'" and "'.$weekEnd.'"')->group_by('invoice_date')->get('spare_invoice')->result();
                }
                $purchase_details = $this->db->select('SUM(grand_total) as grand_total,purchase_date_created as date_created')->where('workshop_id', $this->session->userdata('work_shop_id'))->where_in('mech_purchase.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', '1')->where('purchase_date_created BETWEEN "'.$weekStart.'" and "'.$weekEnd.'"')->group_by('purchase_date_created')->get('mech_purchase')->result();
                $expenese_details = $this->db->select('SUM(grand_total) as grand_total,expense_date as date_created')->where('workshop_id', $this->session->userdata('work_shop_id'))->where_in('mech_expense.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', '1')->where('expense_date BETWEEN "'.$weekStart.'" and "'.$weekEnd.'"')->group_by('expense_date')->get('mech_expense')->result();
            }else if($this->input->post('type') == "M"){
                if($this->session->userdata('plan_type') != 3){
                    $invoice_details = $this->db->select('SUM(grand_total) as grand_total,DATE(invoice_date) as created_on')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', 'A')->where_in('mech_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->where('invoice_date BETWEEN "'.date('Y-m-01').'" and "'.date('Y-m-t').'"')->group_by('invoice_date')->get('mech_invoice')->result();
                }else{
                    $invoice_details = $this->db->select('SUM(grand_total) as grand_total,DATE(invoice_date) as created_on')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', 'A')->where_in('spare_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->where('invoice_date BETWEEN "'.date('Y-m-01').'" and "'.date('Y-m-t').'"')->group_by('invoice_date')->get('spare_invoice')->result();
                }
                $purchase_details = $this->db->select('SUM(grand_total) as grand_total,purchase_date_created as date_created')->where('workshop_id', $this->session->userdata('work_shop_id'))->where_in('mech_purchase.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', '1')->where('purchase_date_created BETWEEN "'.date('Y-m-01').'" and "'.date('Y-m-t').'"')->group_by('purchase_date_created')->get('mech_purchase')->result();
                $expenese_details = $this->db->select('SUM(grand_total) as grand_total,expense_date as date_created')->where('workshop_id', $this->session->userdata('work_shop_id'))->where_in('mech_expense.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', '1')->where('expense_date BETWEEN "'.date('Y-m-01').'" and "'.date('Y-m-t').'"')->group_by('expense_date')->get('mech_expense')->result();
            }else{
                if($this->session->userdata('plan_type') != 3){
                    $invoice_details = $this->db->select('SUM(grand_total) as grand_total,DATE(invoice_date) as created_on')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', 'A')->where_in('mech_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->group_by('invoice_date')->get('mech_invoice')->result();
                }else{
                    $invoice_details = $this->db->select('SUM(grand_total) as grand_total,DATE(invoice_date) as created_on')->where('workshop_id', $this->session->userdata('work_shop_id'))->where('status', 'A')->where_in('spare_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->group_by('invoice_date')->get('spare_invoice')->result();
                }
                $purchase_details = $this->db->select('SUM(grand_total) as grand_total,purchase_date_created as date_created')->where('workshop_id', $this->session->userdata('work_shop_id'))->where_in('mech_purchase.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', '1')->group_by('purchase_date_created')->get('mech_purchase')->result();
                $expenese_details = $this->db->select('SUM(grand_total) as grand_total,expense_date as date_created')->where('workshop_id', $this->session->userdata('work_shop_id'))->where_in('mech_expense.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', '1')->group_by('expense_date')->get('mech_expense')->result();
            }
        }

        if (count($purchase_details) > 0) {
            foreach ($expenese_details as $key => $expense) {
                $purchase = array_filter($purchase_details, function ($object) use ($expense) {
                    return strtotime($expense->date_created) == strtotime($object->date_created);
                });
                if (count($purchase) > 0) {
                    foreach ($purchase as $key => $object) {
                        $purchase_details[$key]->grand_total = $expense->grand_total + $purchase[$key]->grand_total;
                    }
                } else {
                    array_push($purchase_details, $expense);
                }
            }
        } else {
            $purchase_details = $expenese_details;
        }

        $diff = date_diff($date1,$date2);

        $response = array(
            'days' =>  $diff->format("%a"),
            'success' => 1,
            'invoice_details' => $invoice_details,
            'purchase_details' => $purchase_details,
        );

        echo json_encode($response);
    }

    public function getdayMonthData(){

        if(date('D')!='Sun')
        {    
            $weekStart = date('Y-m-d',strtotime('last Sunday'));    
        }else{
            $weekStart = date('Y-m-d');   
        }
        if(date('D')!='Sat')
        {
            $weekEnd = date('Y-m-d',strtotime('next Saturday'));
        }else{
            $weekEnd = date('Y-m-d');
        }
        $monthDate = '( '.date("d-m-Y", strtotime(date("Y-m-01"))).' - '.date("d-m-Y", strtotime(date("Y-m-t"))).' )';
        $monthStartDate = date('Y-m-01');
        $monthEndDate = date('Y-m-t');
        
        if($this->input->post('id')){
            if($this->input->post('id') == "D"){
                if($this->session->userdata('user_type') == 3){

                    $total_leads = $this->db->query("SELECT count(mech_leads.ml_id) as total_leads FROM mech_leads where reschedule_date >= '".date('Y-m-d 00:00:00')."' and reschedule_date <= '".date('Y-m-d 23:59:59')."' and mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.category_type = 'L' and mech_leads.status != 'D'")->row()->total_leads;
                    $total_appointments = $this->db->query("SELECT count(mech_leads.ml_id) as total_appointments FROM mech_leads where mech_leads.reschedule_date >= '".date('Y-m-d 00:00:00')."' and mech_leads.reschedule_date <= '".date('Y-m-d 23:59:59')."' and mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.category_type = 'A' and mech_leads.status != 'D'")->row()->total_appointments;
                    
                    $total_job_completeds = $this->db->select('count(work_order_id) as total_job_completeds')->where('issue_date', date('Y-m-d'))->where('jobsheet_status', '3')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_completeds;
                    $total_job_openings = $this->db->select('count(work_order_id) as total_job_openings')->where('issue_date', date('Y-m-d'))->where('jobsheet_status', '1')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_openings;
                    $total_working_progress = $this->db->select('count(work_order_id) as total_working_progress')->where('issue_date', date('Y-m-d'))->where('jobsheet_status', '2')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_working_progress;
                    $total_onhold = $this->db->select('count(work_order_id) as total_onhold')->where('issue_date', date('Y-m-d'))->where('jobsheet_status', '6')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_onhold;

                    if($this->session->userdata('plan_type') != 3){
                        $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date', date('Y-m-d'))->where('status', 'A')->get('mech_invoice')->row()->grand_total;
                        $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date', date('Y-m-d'))->where('status', 'A')->get('mech_invoice')->row()->total_due_amount;
                        $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date', date('Y-m-d'))->where('status', 'A')->get('mech_invoice')->row()->total_paid_amount;
                    }else{
                        $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date', date('Y-m-d'))->where('status', 'A')->get('spare_invoice')->row()->grand_total;
                        $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date', date('Y-m-d'))->where('status', 'A')->get('spare_invoice')->row()->total_due_amount;
                        $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date', date('Y-m-d'))->where('status', 'A')->get('spare_invoice')->row()->total_paid_amount;
                    }

                    $total_purchase = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created', date('Y-m-d'))->where('status', 'A')->get('mech_purchase')->row()->grand_total;
                    $total_purchase_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created', date('Y-m-d'))->where('status', 'A')->get('mech_purchase')->row()->total_due_amount;
                    $total_purchase_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created', date('Y-m-d'))->where('status', 'A')->get('mech_purchase')->row()->total_paid_amount;
        
                    $total_expenese = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('expense_date', date('Y-m-d'))->where('status', 1)->get('mech_expense')->row()->grand_total;
                    $total_expenese_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('expense_date', date('Y-m-d'))->where('status', 1)->get('mech_expense')->row()->total_paid_amount;
                    $total_expenese_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('expense_date', date('Y-m-d'))->where('status', 1)->get('mech_expense')->row()->total_due_amount;
        
                }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
                    $total_leads = $this->db->query("SELECT count(mech_leads.ml_id) as total_leads FROM mech_leads where mech_leads.reschedule_date >= '".date('Y-m-d 00:00:00')."' and mech_leads.reschedule_date <= '".date('Y-m-d 23:59:59')."' and mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.w_branch_id = ".$this->session->userdata('branch_id')." and mech_leads.category_type = 'L' and mech_leads.status != 'D'")->row()->total_leads;
                    $total_appointments = $this->db->query("SELECT count(mech_leads.ml_id) as total_appointments FROM mech_leads where mech_leads.reschedule_date >= '".date('Y-m-d 00:00:00')."' and mech_leads.reschedule_date <= '".date('Y-m-d 23:59:59')."' and mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.w_branch_id = ".$this->session->userdata('branch_id')." and mech_leads.category_type = 'A' and mech_leads.status != 'D'")->row()->total_appointments;
                    
                    $total_job_completeds = $this->db->select('count(work_order_id) as total_job_completeds')->where('issue_date', date('Y-m-d'))->where('jobsheet_status', '3')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_completeds;
                    $total_job_openings = $this->db->select('count(work_order_id) as total_job_openings')->where('issue_date', date('Y-m-d'))->where('jobsheet_status', '1')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_openings;
                    $total_working_progress = $this->db->select('count(work_order_id) as total_working_progress')->where('issue_date', date('Y-m-d'))->where('jobsheet_status', '2')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_working_progress;
                    $total_onhold = $this->db->select('count(work_order_id) as total_onhold')->where('issue_date', date('Y-m-d'))->where('jobsheet_status', '6')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_onhold;

                    if($this->session->userdata('plan_type') != 3){
                        $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date', date('Y-m-d'))->where('status', 'A')->where('mech_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('mech_invoice')->row()->grand_total;
                        $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date', date('Y-m-d'))->where('status', 'A')->where('mech_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('mech_invoice')->row()->total_due_amount;
                        $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date', date('Y-m-d'))->where('status', 'A')->where('mech_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('mech_invoice')->row()->total_paid_amount;
                    }else{
                        $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date', date('Y-m-d'))->where('status', 'A')->where('spare_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('spare_invoice')->row()->grand_total;
                        $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date', date('Y-m-d'))->where('status', 'A')->where('spare_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('spare_invoice')->row()->total_due_amount;
                        $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date', date('Y-m-d'))->where('status', 'A')->where('spare_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('spare_invoice')->row()->total_paid_amount;
                    }
                    $total_purchase = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created', date('Y-m-d'))->where('mech_purchase.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_purchase')->row()->grand_total;
                    $total_purchase_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created', date('Y-m-d'))->where('mech_purchase.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_purchase')->row()->total_due_amount;
                    $total_purchase_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created', date('Y-m-d'))->where('mech_purchase.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_purchase')->row()->total_paid_amount;
        
                    $total_expenese = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_expense.w_branch_id', $this->session->userdata('branch_id'))->where('expense_date', date('Y-m-d'))->where('created_by', $this->session->userdata('user_id'))->where('status', 1)->get('mech_expense')->row()->grand_total;
                    $total_expenese_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_expense.w_branch_id', $this->session->userdata('branch_id'))->where('expense_date', date('Y-m-d'))->where('created_by', $this->session->userdata('user_id'))->where('status', 1)->get('mech_expense')->row()->total_paid_amount;
                    $total_expenese_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_expense.w_branch_id', $this->session->userdata('branch_id'))->where('expense_date', date('Y-m-d'))->where('created_by', $this->session->userdata('user_id'))->where('status',1)->get('mech_expense')->row()->total_due_amount;
                }else if($this->session->userdata('user_type') == 6){
                    $total_leads = $this->db->query("SELECT count(mech_leads.ml_id) as total_leads FROM mech_leads where mech_leads.reschedule_date >= '".date('Y-m-d 00:00:00')."' and mech_leads.reschedule_date <= '".date('Y-m-d 23:59:59')."' and mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") and mech_leads.category_type = 'L' and mech_leads.status != 'D'")->row()->total_leads;
                    $total_appointments = $this->db->query("SELECT count(mech_leads.ml_id) as total_appointments FROM mech_leads where mech_leads.reschedule_date >= '".date('Y-m-d 00:00:00')."' and mech_leads.reschedule_date <= '".date('Y-m-d 23:59:59')."' and mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") and mech_leads.category_type = 'A' and mech_leads.status != 'D'")->row()->total_appointments;


                    $total_job_completeds = $this->db->select('count(work_order_id) as total_job_completeds')->where('issue_date', date('Y-m-d'))->where('jobsheet_status', '3')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_completeds;
                    $total_job_openings = $this->db->select('count(work_order_id) as total_job_openings')->where('issue_date', date('Y-m-d'))->where('jobsheet_status', '1')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_openings;
                    $total_working_progress = $this->db->select('count(work_order_id) as total_working_progress')->where('issue_date', date('Y-m-d'))->where('jobsheet_status', '2')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_working_progress;
                    $total_onhold = $this->db->select('count(work_order_id) as total_onhold')->where('issue_date', date('Y-m-d'))->where('jobsheet_status', '6')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_onhold;

                    if($this->session->userdata('plan_type') != 3){
                        $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date', date('Y-m-d'))->where('status', 'A')->where_in('mech_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->get('mech_invoice')->row()->grand_total;
                        $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date', date('Y-m-d'))->where('status', 'A')->where_in('mech_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->get('mech_invoice')->row()->total_due_amount;
                        $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date', date('Y-m-d'))->where('status', 'A')->where_in('mech_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->get('mech_invoice')->row()->total_paid_amount;
                    }else{
                        $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date', date('Y-m-d'))->where('status', 'A')->where_in('spare_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->get('spare_invoice')->row()->grand_total;
                        $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date', date('Y-m-d'))->where('status', 'A')->where_in('spare_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->get('spare_invoice')->row()->total_due_amount;
                        $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date', date('Y-m-d'))->where('status', 'A')->where_in('spare_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->get('spare_invoice')->row()->total_paid_amount;
                    }

                    $total_purchase = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created', date('Y-m-d'))->where_in('mech_purchase.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', 'A')->get('mech_purchase')->row()->grand_total;
                    $total_purchase_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created', date('Y-m-d'))->where_in('mech_purchase.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', 'A')->get('mech_purchase')->row()->total_due_amount;
                    $total_purchase_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created', date('Y-m-d'))->where_in('mech_purchase.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', 'A')->get('mech_purchase')->row()->total_paid_amount;
        
                    $total_expenese = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_expense.w_branch_id', $this->session->userdata('user_branch_id'))->where('expense_date', date('Y-m-d'))->where('status', 1)->get('mech_expense')->row()->grand_total;
                    $total_expenese_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_expense.w_branch_id', $this->session->userdata('user_branch_id'))->where('expense_date', date('Y-m-d'))->where('status', 1)->get('mech_expense')->row()->total_paid_amount;
                    $total_expenese_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_expense.w_branch_id', $this->session->userdata('user_branch_id'))->where('expense_date', date('Y-m-d'))->where('status',1)->get('mech_expense')->row()->total_due_amount;
                }

            }else if($this->input->post('id') == "W"){

                if($this->session->userdata('user_type') == 3){

                    $total_leads = $this->db->query("SELECT count(mech_leads.ml_id) as total_leads FROM mech_leads where mech_leads.reschedule_date BETWEEN '".$weekStart."' and '".$weekEnd."' and mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.category_type = 'L' and mech_leads.status != 'D'")->row()->total_leads;
                    $total_appointments = $this->db->query("SELECT count(mech_leads.ml_id) as total_appointments FROM mech_leads where mech_leads.reschedule_date BETWEEN '".$weekStart."' and '".$weekEnd."' and mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.category_type = 'A' and mech_leads.status != 'D'")->row()->total_appointments;
                    
                    $total_job_completeds = $this->db->select('count(work_order_id) as total_job_completeds')->where('issue_date >=', $weekStart)->where('issue_date <=' , $weekEnd)->where('jobsheet_status', '3')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_completeds;
                    $total_job_openings = $this->db->select('count(work_order_id) as total_job_openings')->where('issue_date >=', $weekStart)->where('issue_date <=' , $weekEnd)->where('jobsheet_status', '1')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_openings;
                    $total_working_progress = $this->db->select('count(work_order_id) as total_working_progress')->where('issue_date >=', $weekStart)->where('issue_date <=' , $weekEnd)->where('jobsheet_status', '2')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_working_progress;
                    $total_onhold = $this->db->select('count(work_order_id) as total_onhold')->where('issue_date >=', $weekStart)->where('issue_date <=' , $weekEnd)->where('jobsheet_status', '6')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_onhold;

                    if($this->session->userdata('plan_type') != 3){
                        $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', $weekStart)->where('invoice_date <=', $weekEnd)->where('status', 'A')->get('mech_invoice')->row()->grand_total;
                        $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', $weekStart)->where('invoice_date <=', $weekEnd)->where('status', 'A')->get('mech_invoice')->row()->total_due_amount;
                        $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', $weekStart)->where('invoice_date <=', $weekEnd)->where('status', 'A')->get('mech_invoice')->row()->total_paid_amount;
                    }else{
                        $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', $weekStart)->where('invoice_date <=', $weekEnd)->where('status', 'A')->get('spare_invoice')->row()->grand_total;
                        $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', $weekStart)->where('invoice_date <=', $weekEnd)->where('status', 'A')->get('spare_invoice')->row()->total_due_amount;
                        $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', $weekStart)->where('invoice_date <=', $weekEnd)->where('status', 'A')->get('spare_invoice')->row()->total_paid_amount;
                    }

                    $total_purchase = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created >=', $weekStart)->where('purchase_date_created <=', $weekEnd)->where('status', 'A')->get('mech_purchase')->row()->grand_total;
                    $total_purchase_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created >=', $weekStart)->where('purchase_date_created <=', $weekEnd)->where('status', 'A')->get('mech_purchase')->row()->total_due_amount;
                    $total_purchase_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created >=', $weekStart)->where('purchase_date_created <=', $weekEnd)->where('status', 'A')->get('mech_purchase')->row()->total_paid_amount;
        
                    $total_expenese = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('expense_date >=', $weekStart)->where('expense_date <=', $weekEnd)->where('status', 1)->get('mech_expense')->row()->grand_total;
                    $total_expenese_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('expense_date >=', $weekStart)->where('expense_date <=', $weekEnd)->where('status', 1)->get('mech_expense')->row()->total_paid_amount;
                    $total_expenese_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('expense_date >=', $weekStart)->where('expense_date <=', $weekEnd)->where('status', 1)->get('mech_expense')->row()->total_due_amount;
        
                }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){

                    $total_leads = $this->db->query("SELECT count(mech_leads.ml_id) as total_leads FROM mech_leads where mech_leads.reschedule_date between '".$weekStart."' and '".$weekEnd."' and mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.w_branch_id = ".$this->session->userdata('branch_id')." and mech_leads.category_type = 'L'")->row()->total_leads;
                    $total_appointments = $this->db->query("SELECT count(mech_leads.ml_id) as total_appointments FROM mech_leads where mech_leads.reschedule_date between '".$weekStart."' and '".$weekEnd."' and mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and w_branch_id = ".$this->session->userdata('branch_id')." and mech_leads.category_type = 'A'")->row()->total_appointments;

                    $total_job_completeds = $this->db->select('count(work_order_id) as total_job_completeds')->where('issue_date >=',$weekStart)->where('issue_date <=',$weekEnd)->where('jobsheet_status', '3')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('mech_work_order_dtls.status', 'A')->get('mech_work_order_dtls')->row()->total_job_completeds;
                    $total_job_openings = $this->db->select('count(work_order_id) as total_job_openings')->where('issue_date >=',$weekStart)->where('issue_date <=',$weekEnd)->where('jobsheet_status', '1')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('mech_work_order_dtls.status', 'A')->get('mech_work_order_dtls')->row()->total_job_openings;
                    $total_working_progress = $this->db->select('count(work_order_id) as total_working_progress')->where('issue_date >=',$weekStart)->where('issue_date <=',$weekEnd)->where('jobsheet_status', '2')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('mech_work_order_dtls.status', 'A')->get('mech_work_order_dtls')->row()->total_working_progress;
                    $total_onhold = $this->db->select('count(work_order_id) as total_onhold')->where('issue_date >=',$weekStart)->where('issue_date <=',$weekEnd)->where('jobsheet_status', '6')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('mech_work_order_dtls.status', 'A')->get('mech_work_order_dtls')->row()->total_onhold;

                    if($this->session->userdata('plan_type') != 3){
                        $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', $weekStart)->where('invoice_date <=', $weekEnd)->where('status', 'A')->where('mech_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('mech_invoice')->row()->grand_total;
                        $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', $weekStart)->where('invoice_date <=', $weekEnd)->where('status', 'A')->where('mech_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('mech_invoice')->row()->total_due_amount;
                        $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', $weekStart)->where('invoice_date <=', $weekEnd)->where('status', 'A')->where('mech_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('mech_invoice')->row()->total_paid_amount;
                    }else{
                        $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', $weekStart)->where('invoice_date <=', $weekEnd)->where('status', 'A')->where('spare_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('spare_invoice')->row()->grand_total;
                        $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', $weekStart)->where('invoice_date <=', $weekEnd)->where('status', 'A')->where('spare_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('spare_invoice')->row()->total_due_amount;
                        $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', $weekStart)->where('invoice_date <=', $weekEnd)->where('status', 'A')->where('spare_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('spare_invoice')->row()->total_paid_amount;
                    }
                    $total_purchase = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created >=', $weekStart)->where('purchase_date_created <=', $weekEnd)->where('mech_purchase.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_purchase')->row()->grand_total;
                    $total_purchase_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created >=', $weekStart)->where('purchase_date_created <=', $weekEnd)->where('mech_purchase.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_purchase')->row()->total_due_amount;
                    $total_purchase_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created >=', $weekStart)->where('purchase_date_created <=', $weekEnd)->where('mech_purchase.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_purchase')->row()->total_paid_amount;
        
                    $total_expenese = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_expense.w_branch_id', $this->session->userdata('branch_id'))->where('expense_date >=', $weekStart)->where('mech_expense.expense_date <=', $weekEnd)->where('created_by', $this->session->userdata('user_id'))->where('status', 1)->get('mech_expense')->row()->grand_total;
                    $total_expenese_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_expense.w_branch_id', $this->session->userdata('branch_id'))->where('expense_date >=', $weekStart)->where('mech_expense.expense_date <=', $weekEnd)->where('created_by', $this->session->userdata('user_id'))->where('status', 1)->get('mech_expense')->row()->total_paid_amount;
                    $total_expenese_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_expense.w_branch_id', $this->session->userdata('branch_id'))->where('expense_date >=', $weekStart)->where('mech_expense.expense_date <=', $weekEnd)->where('created_by', $this->session->userdata('user_id'))->where('status',1)->get('mech_expense')->row()->total_due_amount;
                }else if( $this->session->userdata('user_type') == 6){

                    $total_leads = $this->db->query("SELECT count(mech_leads.ml_id) as total_leads FROM mech_leads where mech_leads.reschedule_date between '".$weekStart."' and '".$weekEnd."' and mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") and mech_leads.category_type = 'L' and mech_leads.status != 'D'")->row()->total_leads;

                    $total_appointments = $this->db->query("SELECT count(mech_leads.ml_id) as total_appointments FROM mech_leads where mech_leads.reschedule_date between '".$weekStart."' and '".$weekEnd."' and mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") and mech_leads.category_type = 'A' and mech_leads.status != 'D'")->row()->total_appointments;

                    $total_job_completeds = $this->db->select('count(work_order_id) as total_job_completeds')->where('issue_date >=',$weekStart)->where('issue_date <=',$weekEnd)->where('jobsheet_status', '3')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_completeds;
                    $total_job_openings = $this->db->select('count(work_order_id) as total_job_openings')->where('issue_date >=',$weekStart)->where('issue_date <=',$weekEnd)->where('jobsheet_status', '1')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_openings;
                    $total_working_progress = $this->db->select('count(work_order_id) as total_working_progress')->where('issue_date >=',$weekStart)->where('issue_date <=',$weekEnd)->where('jobsheet_status', '2')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_working_progress;
                    $total_onhold = $this->db->select('count(work_order_id) as total_onhold')->where('issue_date >=',$weekStart)->where('issue_date <=',$weekEnd)->where('jobsheet_status', '6')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_onhold;
                    
                    if($this->session->userdata('plan_type') != 3){
                        $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', $weekStart)->where('invoice_date <=', $weekEnd)->where('status', 'A')->where_in('mech_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->get('mech_invoice')->row()->grand_total;
                        $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', $weekStart)->where('invoice_date <=', $weekEnd)->where('status', 'A')->where_in('mech_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->get('mech_invoice')->row()->total_due_amount;
                        $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', $weekStart)->where('invoice_date <=', $weekEnd)->where('status', 'A')->where_in('mech_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->get('mech_invoice')->row()->total_paid_amount;
                    }else{
                        $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', $weekStart)->where('invoice_date <=', $weekEnd)->where('status', 'A')->where_in('spare_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->get('spare_invoice')->row()->grand_total;
                        $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', $weekStart)->where('invoice_date <=', $weekEnd)->where('status', 'A')->where_in('spare_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->get('spare_invoice')->row()->total_due_amount;
                        $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', $weekStart)->where('invoice_date <=', $weekEnd)->where('status', 'A')->where_in('spare_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->get('spare_invoice')->row()->total_paid_amount;
                    }

                    $total_purchase = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created >=', $weekStart)->where('purchase_date_created <=', $weekEnd)->where_in('mech_purchase.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', 'A')->get('mech_purchase')->row()->grand_total;
                    $total_purchase_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created >=', $weekStart)->where('purchase_date_created <=', $weekEnd)->where_in('mech_purchase.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', 'A')->get('mech_purchase')->row()->total_due_amount;
                    $total_purchase_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created >=', $weekStart)->where('purchase_date_created <=', $weekEnd)->where_in('mech_purchase.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', 'A')->get('mech_purchase')->row()->total_paid_amount;
        
                    $total_expenese = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_expense.w_branch_id', $this->session->userdata('user_branch_id'))->where('expense_date >=', $weekStart)->where('expense_date <=', $weekEnd)->where('status', 1)->get('mech_expense')->row()->grand_total;
                    $total_expenese_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_expense.w_branch_id', $this->session->userdata('user_branch_id'))->where('expense_date >=', $weekStart)->where('expense_date <=', $weekEnd)->where('status', 1)->get('mech_expense')->row()->total_paid_amount;
                    $total_expenese_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_expense.w_branch_id', $this->session->userdata('user_branch_id'))->where('expense_date >=', $weekStart)->where('expense_date <=', $weekEnd)->where('status',1)->get('mech_expense')->row()->total_due_amount;
                }
            }else if($this->input->post('id') == "M"){
                if($this->session->userdata('user_type') == 3){

                    $total_leads = $this->db->query("SELECT count(mech_leads.ml_id) as total_leads FROM mech_leads where mech_leads.reschedule_date BETWEEN '".date('Y-m-01')."' and '".date('Y-m-t')."' and mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.category_type = 'L' and mech_leads.status != 'D'")->row()->total_leads;
                    $total_appointments = $this->db->query("SELECT count(mech_leads.ml_id) as total_appointments FROM mech_leads where mech_leads.reschedule_date BETWEEN '".date('Y-m-01')."' and '".date('Y-m-t')."' and mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.category_type = 'A' and mech_leads.status != 'D'")->row()->total_appointments;
                    
                    $total_job_completeds = $this->db->select('count(work_order_id) as total_job_completeds')->where('issue_date >=', date('Y-m-01'))->where('issue_date <=', date('Y-m-t'))->where('jobsheet_status', '3')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_completeds;
                    $total_job_openings = $this->db->select('count(work_order_id) as total_job_openings')->where('issue_date >=', date('Y-m-01'))->where('issue_date <=', date('Y-m-t'))->where('jobsheet_status', '1')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_openings;
                    $total_working_progress = $this->db->select('count(work_order_id) as total_working_progress')->where('issue_date >=', date('Y-m-01'))->where('issue_date <=', date('Y-m-t'))->where('jobsheet_status', '2')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_working_progress;
                    $total_onhold = $this->db->select('count(work_order_id) as total_onhold')->where('issue_date >=', date('Y-m-01'))->where('issue_date <=', date('Y-m-t'))->where('jobsheet_status', '6')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_onhold;

                    if($this->session->userdata('plan_type') != 3){
                        $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', date('Y-m-01'))->where('invoice_date <=', date('Y-m-t'))->where('status', 'A')->get('mech_invoice')->row()->grand_total;
                        $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', date('Y-m-01'))->where('invoice_date <=', date('Y-m-t'))->where('status', 'A')->get('mech_invoice')->row()->total_due_amount;
                        $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', date('Y-m-01'))->where('invoice_date <=', date('Y-m-t'))->where('status', 'A')->get('mech_invoice')->row()->total_paid_amount;
                    }else{
                        $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', date('Y-m-01'))->where('invoice_date <=', date('Y-m-t'))->where('status', 'A')->get('spare_invoice')->row()->grand_total;
                        $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', date('Y-m-01'))->where('invoice_date <=', date('Y-m-t'))->where('status', 'A')->get('spare_invoice')->row()->total_due_amount;
                        $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', date('Y-m-01'))->where('invoice_date <=', date('Y-m-t'))->where('status', 'A')->get('spare_invoice')->row()->total_paid_amount;
                    }

                    $total_purchase = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created >=', date('Y-m-01'))->where('purchase_date_created <=', date('Y-m-t'))->where('status', 'A')->get('mech_purchase')->row()->grand_total;
                    $total_purchase_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created >=', date('Y-m-01'))->where('purchase_date_created <=', date('Y-m-t'))->where('status', 'A')->get('mech_purchase')->row()->total_due_amount;
                    $total_purchase_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created >=', date('Y-m-01'))->where('purchase_date_created <=', date('Y-m-t'))->where('status', 'A')->get('mech_purchase')->row()->total_paid_amount;
        
                    $total_expenese = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('expense_date >=', date('Y-m-01'))->where('expense_date <=', date('Y-m-t'))->where('status', 1)->get('mech_expense')->row()->grand_total;
                    $total_expenese_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('expense_date >=', date('Y-m-01'))->where('expense_date <=', date('Y-m-t'))->where('status', 1)->get('mech_expense')->row()->total_paid_amount;
                    $total_expenese_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('expense_date >=', date('Y-m-01'))->where('expense_date <=', date('Y-m-t'))->where('status', 1)->get('mech_expense')->row()->total_due_amount;
        
                }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
                    $total_leads = $this->db->query("SELECT count(mech_leads.ml_id) as total_leads FROM mech_leads where mech_leads.reschedule_date BETWEEN '".date('Y-m-01')."' and '".date('Y-m-t')."' and mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.w_branch_id = ".$this->session->userdata('branch_id')." and mech_leads.category_type = 'L' and mech_leads.status != 'D'")->row()->total_leads;
                    $total_appointments = $this->db->query("SELECT count(mech_leads.ml_id) as total_appointments FROM mech_leads where mech_leads.reschedule_date BETWEEN '".date('Y-m-01')."' and '".date('Y-m-t')."' and mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.w_branch_id = ".$this->session->userdata('branch_id')." and mech_leads.category_type = 'A' and mech_leads.status != 'D'")->row()->total_appointments;
                    
                    $total_job_completeds = $this->db->select('count(work_order_id) as total_job_completeds')->where('issue_date >=',date('Y-m-01'))->where('issue_date <=',date('Y-m-t'))->where('jobsheet_status', '3')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_completeds;
                    $total_job_openings = $this->db->select('count(work_order_id) as total_job_openings')->where('issue_date >=',date('Y-m-01'))->where('issue_date <=',date('Y-m-t'))->where('jobsheet_status', '1')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_openings;
                    $total_working_progress = $this->db->select('count(work_order_id) as total_working_progress')->where('issue_date >=',date('Y-m-01'))->where('issue_date <=',date('Y-m-t'))->where('jobsheet_status', '2')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_working_progress;
                    $total_onhold = $this->db->select('count(work_order_id) as total_onhold')->where('issue_date >=',date('Y-m-01'))->where('issue_date <=',date('Y-m-t'))->where('jobsheet_status', '6')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_onhold;

                    if($this->session->userdata('plan_type') != 3){
                        $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', date('Y-m-01'))->where('invoice_date <=', date('Y-m-t'))->where('status', 'A')->where('mech_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('mech_invoice')->row()->grand_total;
                        $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', date('Y-m-01'))->where('invoice_date <=', date('Y-m-t'))->where('status', 'A')->where('mech_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('mech_invoice')->row()->total_due_amount;
                        $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', date('Y-m-01'))->where('invoice_date <=', date('Y-m-t'))->where('status', 'A')->where('mech_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('mech_invoice')->row()->total_paid_amount;
                    }else{
                        $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', date('Y-m-01'))->where('invoice_date <=', date('Y-m-t'))->where('status', 'A')->where('spare_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('spare_invoice')->row()->grand_total;
                        $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', date('Y-m-01'))->where('invoice_date <=', date('Y-m-t'))->where('status', 'A')->where('spare_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('spare_invoice')->row()->total_due_amount;
                        $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', date('Y-m-01'))->where('invoice_date <=', date('Y-m-t'))->where('status', 'A')->where('spare_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('spare_invoice')->row()->total_paid_amount;
                    }

                    $total_purchase = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created >=', date('Y-m-01'))->where('purchase_date_created <=', date('Y-m-t'))->where('mech_purchase.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_purchase')->row()->grand_total;
                    $total_purchase_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created >=', date('Y-m-01'))->where('purchase_date_created <=', date('Y-m-t'))->where('mech_purchase.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_purchase')->row()->total_due_amount;
                    $total_purchase_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created >=', date('Y-m-01'))->where('purchase_date_created <=', date('Y-m-t'))->where('mech_purchase.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_purchase')->row()->total_paid_amount;
        
                    $total_expenese = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_expense.w_branch_id', $this->session->userdata('branch_id'))->where('expense_date >=', date('Y-m-01'))->where('expense_date <=', date('Y-m-t'))->where('created_by', $this->session->userdata('user_id'))->where('status', 1)->get('mech_expense')->row()->grand_total;
                    $total_expenese_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_expense.w_branch_id', $this->session->userdata('branch_id'))->where('expense_date >=', date('Y-m-01'))->where('expense_date <=', date('Y-m-t'))->where('created_by', $this->session->userdata('user_id'))->where('status', 1)->get('mech_expense')->row()->total_paid_amount;
                    $total_expenese_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_expense.w_branch_id', $this->session->userdata('branch_id'))->where('expense_date >=', date('Y-m-01'))->where('expense_date <=', date('Y-m-t'))->where('created_by', $this->session->userdata('user_id'))->where('status',1)->get('mech_expense')->row()->total_due_amount;
               
                }else if( $this->session->userdata('user_type') == 6){
                    $total_leads = $this->db->query("SELECT count(mech_leads.ml_id) as total_leads FROM mech_leads where mech_leads.reschedule_date BETWEEN '".date('Y-m-01')."' and '".date('Y-m-t')."' and mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") and mech_leads.category_type = 'L' and mech_leads.status != 'D'")->row()->total_leads;
                    $total_appointments = $this->db->query("SELECT count(mech_leads.ml_id) as total_appointments FROM mech_leads where mech_leads.reschedule_date BETWEEN '".date('Y-m-01')."' and '".date('Y-m-t')."' and mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") and mech_leads.category_type = 'A' and mech_leads.status != 'D'")->row()->total_appointments;
                   
                    $total_job_completeds = $this->db->select('count(work_order_id) as total_job_completeds')->where('issue_date >=',date('Y-m-01'))->where('issue_date <=',date('Y-m-t'))->where('jobsheet_status', '3')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_completeds;
                    $total_job_openings = $this->db->select('count(work_order_id) as total_job_openings')->where('issue_date >=',date('Y-m-01'))->where('issue_date <=',date('Y-m-t'))->where('jobsheet_status', '1')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_openings;
                    $total_working_progress = $this->db->select('count(work_order_id) as total_working_progress')->where('issue_date >=',date('Y-m-01'))->where('issue_date <=',date('Y-m-t'))->where('jobsheet_status', '2')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_working_progress;
                    $total_onhold = $this->db->select('count(work_order_id) as total_onhold')->where('issue_date >=',date('Y-m-01'))->where('issue_date <=',date('Y-m-t'))->where('jobsheet_status', '6')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_onhold;

                    if($this->session->userdata('plan_type') != 3){
                        $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', date('Y-m-01'))->where('invoice_date <=', date('Y-m-t'))->where('status', 'A')->where_in('mech_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->get('mech_invoice')->row()->grand_total;
                        $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', date('Y-m-01'))->where('invoice_date <=', date('Y-m-t'))->where('status', 'A')->where_in('mech_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->get('mech_invoice')->row()->total_due_amount;
                        $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', date('Y-m-01'))->where('invoice_date <=', date('Y-m-t'))->where('status', 'A')->where_in('mech_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->get('mech_invoice')->row()->total_paid_amount;
                    } else {
                        $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', date('Y-m-01'))->where('invoice_date <=', date('Y-m-t'))->where('status', 'A')->where_in('spare_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->get('spare_invoice')->row()->grand_total;
                        $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', date('Y-m-01'))->where('invoice_date <=', date('Y-m-t'))->where('status', 'A')->where_in('spare_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->get('spare_invoice')->row()->total_due_amount;
                        $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', date('Y-m-01'))->where('invoice_date <=', date('Y-m-t'))->where('status', 'A')->where_in('spare_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->get('spare_invoice')->row()->total_paid_amount;
                    }

                    $total_purchase = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created >=', date('Y-m-01'))->where('purchase_date_created <=', date('Y-m-t'))->where_in('mech_purchase.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', 'A')->get('mech_purchase')->row()->grand_total;
                    $total_purchase_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created >=', date('Y-m-01'))->where('purchase_date_created <=', date('Y-m-t'))->where_in('mech_purchase.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', 'A')->get('mech_purchase')->row()->total_due_amount;
                    $total_purchase_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('purchase_date_created >=', date('Y-m-01'))->where('purchase_date_created <=', date('Y-m-t'))->where_in('mech_purchase.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', 'A')->get('mech_purchase')->row()->total_paid_amount;
        
                    $total_expenese = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_expense.w_branch_id', $this->session->userdata('user_branch_id'))->where('expense_date >=', date('Y-m-01'))->where('expense_date <=', date('Y-m-t'))->where('status', 1)->get('mech_expense')->row()->grand_total;
                    $total_expenese_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_expense.w_branch_id', $this->session->userdata('user_branch_id'))->where('expense_date >=', date('Y-m-01'))->where('expense_date <=', date('Y-m-t'))->where('status', 1)->get('mech_expense')->row()->total_paid_amount;
                    $total_expenese_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_expense.w_branch_id', $this->session->userdata('user_branch_id'))->where('expense_date >=', date('Y-m-01'))->where('expense_date <=', date('Y-m-t'))->where('status',1)->get('mech_expense')->row()->total_due_amount;
                }
            }else{
                if($this->session->userdata('user_type') == 3){

                    $total_leads = $this->db->query("SELECT count(mech_leads.ml_id) as total_leads FROM mech_leads where mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.category_type = 'L' and mech_leads.status != 'D'")->row()->total_leads;
                    $total_appointments = $this->db->query("SELECT count(mech_leads.ml_id) as total_appointments FROM mech_leads where mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.category_type = 'A' and mech_leads.status != 'D'")->row()->total_appointments;
                    
                    $total_job_completeds = $this->db->select('count(work_order_id) as total_job_completeds')->where('jobsheet_status', '3')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_completeds;
                    $total_job_openings = $this->db->select('count(work_order_id) as total_job_openings')->where('jobsheet_status', '1')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_openings;
                    $total_working_progress = $this->db->select('count(work_order_id) as total_working_progress')->where('jobsheet_status', '2')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_working_progress;
                    $total_onhold = $this->db->select('count(work_order_id) as total_onhold')->where('jobsheet_status', '6')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_onhold;

                    if($this->session->userdata('plan_type') != 3){
                        $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->get('mech_invoice')->row()->grand_total;
                        $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->get('mech_invoice')->row()->total_due_amount;
                        $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('invoice_date >=', date('Y-m-01'))->where('invoice_date <=', date('Y-m-t'))->where('status', 'A')->get('mech_invoice')->row()->total_paid_amount;
                    }else{
                        $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->get('spare_invoice')->row()->grand_total;
                        $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->get('spare_invoice')->row()->total_due_amount;
                        $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->get('spare_invoice')->row()->total_paid_amount;
                    }

                    $total_purchase = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->get('mech_purchase')->row()->grand_total;
                    $total_purchase_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->get('mech_purchase')->row()->total_due_amount;
                    $total_purchase_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->get('mech_purchase')->row()->total_paid_amount;
        
                    $total_expenese = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 1)->get('mech_expense')->row()->grand_total;
                    $total_expenese_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 1)->get('mech_expense')->row()->total_paid_amount;
                    $total_expenese_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 1)->get('mech_expense')->row()->total_due_amount;
        
                }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
                    $total_leads = $this->db->query("SELECT count(mech_leads.ml_id) as total_leads FROM mech_leads where mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.w_branch_id = ".$this->session->userdata('branch_id')." and mech_leads.category_type = 'L' and mech_leads.status != 'D'")->row()->total_leads;
                    $total_appointments = $this->db->query("SELECT count(mech_leads.ml_id) as total_appointments FROM mech_leads where mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.w_branch_id = ".$this->session->userdata('branch_id')." and mech_leads.category_type = 'A' and mech_leads.status != 'D'")->row()->total_appointments;
                    
                    $total_job_completeds = $this->db->select('count(work_order_id) as total_job_completeds')->where('jobsheet_status', '3')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_completeds;
                    $total_job_openings = $this->db->select('count(work_order_id) as total_job_openings')->where('jobsheet_status', '1')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_openings;
                    $total_working_progress = $this->db->select('count(work_order_id) as total_working_progress')->where('jobsheet_status', '2')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_working_progress;
                    $total_onhold = $this->db->select('count(work_order_id) as total_onhold')->where('jobsheet_status', '6')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_onhold;

                    if($this->session->userdata('plan_type') != 3){
                        $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->where('mech_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('mech_invoice')->row()->grand_total;
                        $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->where('mech_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('mech_invoice')->row()->total_due_amount;
                        $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->where('mech_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('mech_invoice')->row()->total_paid_amount;
                    }else{
                        $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->where('spare_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('spare_invoice')->row()->grand_total;
                        $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->where('spare_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('spare_invoice')->row()->total_due_amount;
                        $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->where('spare_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('spare_invoice')->row()->total_paid_amount;
                    }

                    $total_purchase = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_purchase.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_purchase')->row()->grand_total;
                    $total_purchase_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_purchase.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_purchase')->row()->total_due_amount;
                    $total_purchase_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_purchase.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_purchase')->row()->total_paid_amount;
        
                    $total_expenese = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_expense.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 1)->get('mech_expense')->row()->grand_total;
                    $total_expenese_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_expense.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 1)->get('mech_expense')->row()->total_paid_amount;
                    $total_expenese_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_expense.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status',1)->get('mech_expense')->row()->total_due_amount;
               
                }else if( $this->session->userdata('user_type') == 6){
                    $total_leads = $this->db->query("SELECT count(mech_leads.ml_id) as total_leads FROM mech_leads where mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") and mech_leads.category_type = 'L' and mech_leads.status != 'D'")->row()->total_leads;
                    $total_appointments = $this->db->query("SELECT count(mech_leads.ml_id) as total_appointments FROM mech_leads where mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") and mech_leads.category_type = 'A' and mech_leads.status != 'D'")->row()->total_appointments;
                   
                    $total_job_completeds = $this->db->select('count(work_order_id) as total_job_completeds')->where('jobsheet_status', '3')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_completeds;
                    $total_job_openings = $this->db->select('count(work_order_id) as total_job_openings')->where('jobsheet_status', '1')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_openings;
                    $total_working_progress = $this->db->select('count(work_order_id) as total_working_progress')->where('jobsheet_status', '2')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_working_progress;
                    $total_onhold = $this->db->select('count(work_order_id) as total_onhold')->where('jobsheet_status', '6')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_onhold;

                    if($this->session->userdata('plan_type') != 3){
                        $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->where_in('mech_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->get('mech_invoice')->row()->grand_total;
                        $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->where_in('mech_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->get('mech_invoice')->row()->total_due_amount;
                        $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->where_in('mech_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->get('mech_invoice')->row()->total_paid_amount;
                    } else {
                        $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->where_in('spare_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->get('spare_invoice')->row()->grand_total;
                        $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->where_in('spare_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->get('spare_invoice')->row()->total_due_amount;
                        $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->where_in('spare_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->get('spare_invoice')->row()->total_paid_amount;
                    }

                    $total_purchase = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_purchase.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', 'A')->get('mech_purchase')->row()->grand_total;
                    $total_purchase_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_purchase.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', 'A')->get('mech_purchase')->row()->total_due_amount;
                    $total_purchase_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_purchase.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', 'A')->get('mech_purchase')->row()->total_paid_amount;
        
                    $total_expenese = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_expense.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', 1)->get('mech_expense')->row()->grand_total;
                    $total_expenese_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_expense.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', 1)->get('mech_expense')->row()->total_paid_amount;
                    $total_expenese_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_expense.w_branch_id', $this->session->userdata('user_branch_id'))->where('status',1)->get('mech_expense')->row()->total_due_amount;
                }
            }

            $response = array(
                'success' => 1,
                'normalCurrentDate' => date('Y-m-d'),
                'normalWeekEndDate' => $weekEnd,
                'normalMonthEndDate' => date('Y-m-t'),
                'currentDate' => date_from_mysql(date('Y-m-d')),
                'weekStart' => date_from_mysql($weekStart),
                'weekEnd' => date_from_mysql($weekEnd),
                'monthDate' => $monthDate,
                'monthStartDate' => date_from_mysql($monthStartDate),
                'monthEndDate' => date_from_mysql($monthEndDate),
                'total_leads' => $total_leads,
                'total_appointments' => $total_appointments,
                'total_job_completeds' => $total_job_completeds,
                'total_job_openings' => $total_job_openings,
                'total_working_progress' => $total_working_progress,
                'total_onhold' => $total_onhold,
                'total_purchase' => $total_purchase?$total_purchase:'0',
                'total_income' => number_format((float)$total_income, 2, '.', ''),
                'total_paid' => number_format((float)$total_paid, 2, '.', ''),
                'total_income_due' => number_format((float)$total_income_due, 2, '.', ''),
				'total_expenese' => number_format((float)($total_expenese + $total_purchase), 2, '.', ''),
                'total_expenese_paid' => number_format((float)($total_expenese_paid + $total_purchase_paid), 2, '.', ''),
                'total_expenese_due' => number_format((float)($total_expenese_due + $total_purchase_due), 2, '.', ''),
            );

        } else {
            $response = array(
                'success' => 0,
            );
        }
        echo json_encode($response);
    }


    public function get_donut_data()
    {
        if(date('D')!='Sun')
        {    
            $weekStart = date('Y-m-d',strtotime('last Sunday'));    
        }else{
            $weekStart = date('Y-m-d');   
        }
        if(date('D')!='Sat')
        {
            $weekEnd = date('Y-m-d',strtotime('next Saturday'));
        }else{
            $weekEnd = date('Y-m-d');
        }

        $type = $this->input->post('type');
        $total_job_completeds = 0;
        $total_job_openings = 0;
        if($this->session->userdata('user_type') == 3){
            if($type == "D"){
                $total_job_completeds = $this->db->select('count(work_order_id) as total_job_completeds')->where('issue_date', date('Y-m-d'))->where('jobsheet_status', 'C')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_completeds;
                $total_job_openings = $this->db->select('count(work_order_id) as total_job_openings')->where('issue_date', date('Y-m-d'))->where('jobsheet_status != ', 'C')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_openings;
            }else if($type == "W"){
                $total_job_completeds = $this->db->select('count(work_order_id) as total_job_completeds')->where('issue_date >=', $weekStart)->where('issue_date <=', $weekEnd)->where('jobsheet_status', 'C')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_completeds;
                $total_job_openings = $this->db->select('count(work_order_id) as total_job_openings')->where('issue_date', $weekStart)->where('issue_date <=', $weekEnd)->where('jobsheet_status != ', 'C')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_openings;
            }else if($type == "M"){
                $total_job_completeds = $this->db->select('count(work_order_id) as total_job_completeds')->where('issue_date >=', date('Y-m-01'))->where('issue_date <=', date('Y-m-t'))->where('jobsheet_status', 'C')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_completeds;
                $total_job_openings = $this->db->select('count(work_order_id) as total_job_openings')->where('issue_date >=', date('Y-m-01'))->where('issue_date <=', date('Y-m-t'))->where('jobsheet_status != ', 'C')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_openings;
            }
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            if($type == "D"){
                $total_job_completeds = $this->db->select('count(work_order_id) as total_job_completeds')->where('issue_date', date('Y-m-d'))->where('jobsheet_status', 'C')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_completeds;
                $total_job_openings = $this->db->select('count(work_order_id) as total_job_openings')->where('issue_date', date('Y-m-d'))->where('jobsheet_status != ', 'C')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_openings;
            }else if($type == "W"){
                $total_job_completeds = $this->db->select('count(work_order_id) as total_job_completeds')->where('issue_date >=', $weekStart)->where('issue_date <=', $weekEnd)->where('jobsheet_status', 'C')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_completeds;
                $total_job_openings = $this->db->select('count(work_order_id) as total_job_openings')->where('issue_date', $weekStart)->where('issue_date <=', $weekEnd)->where('jobsheet_status != ', 'C')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_openings;
            }else if($type == "M"){
                $total_job_completeds = $this->db->select('count(work_order_id) as total_job_completeds')->where('issue_date >=', date('Y-m-01'))->where('issue_date <=', date('Y-m-t'))->where('jobsheet_status', 'C')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_completeds;
                $total_job_openings = $this->db->select('count(work_order_id) as total_job_openings')->where('issue_date >=', date('Y-m-01'))->where('issue_date <=', date('Y-m-t'))->where('jobsheet_status != ', 'C')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_openings;
            }
        }else if( $this->session->userdata('user_type') == 6){
            if($type == "D"){
                $total_job_completeds = $this->db->select('count(work_order_id) as total_job_completeds')->where('issue_date', date('Y-m-d'))->where('jobsheet_status', 'C')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_completeds;
                $total_job_openings = $this->db->select('count(work_order_id) as total_job_openings')->where('issue_date', date('Y-m-d'))->where('jobsheet_status != ', 'C')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_openings;
            }else if($type == "W"){
                $total_job_completeds = $this->db->select('count(work_order_id) as total_job_completeds')->where('issue_date >=', $weekStart)->where('issue_date <=', $weekEnd)->where('jobsheet_status', 'C')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_completeds;
                $total_job_openings = $this->db->select('count(work_order_id) as total_job_openings')->where('issue_date', $weekStart)->where('issue_date <=', $weekEnd)->where('jobsheet_status != ', 'C')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_openings;
            }else if($type == "M"){
                $total_job_completeds = $this->db->select('count(work_order_id) as total_job_completeds')->where('issue_date >=', date('Y-m-01'))->where('issue_date <=', date('Y-m-t'))->where('jobsheet_status', 'C')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_completeds;
                $total_job_openings = $this->db->select('count(work_order_id) as total_job_openings')->where('issue_date >=', date('Y-m-01'))->where('issue_date <=', date('Y-m-t'))->where('jobsheet_status != ', 'C')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_openings;
            }
        }
       

        $response = array(
            'success' => 1,
            'total_job_completeds' => $total_job_completeds,
            'total_job_openings' => $total_job_openings,
        );

        echo json_encode($response);
    }

}
?>