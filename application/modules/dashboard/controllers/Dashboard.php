<?php
    if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Dashboard extends Admin_Controller
    {
        public function index()
        {
            $this->load->model('users/mdl_users');
            $this->load->model('user_quotes/mdl_user_quotes');
            $this->load->model('user_cars/mdl_user_cars');
            $this->load->model('user_address/mdl_user_address');
            $this->load->model('clients/mdl_clients');
            $this->load->model('mech_invoices/mdl_mech_invoice');
            $this->load->model('spare_invoices/mdl_spare_invoice');
            $this->load->model('mech_expense/mdl_mech_expense');
            $this->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');
            $this->load->model('mech_employee/mdl_mech_employee');
            $this->load->model('suppliers/mdl_suppliers');
            $this->load->model('mech_purchase/mdl_mech_purchase');
            $this->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls'); 

            $date = new DateTime("now");
            $curr_date = $date->format('Y-m-d');
            if($this->session->userdata('user_type') == 3){

                if($this->session->userdata('plan_type') != 3){
                    $outstanding_invoice = $this->mdl_mech_invoice->where('mech_invoice.workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_invoice.invoice_status',array('0' => 'G','1' => 'PP'))->where('mech_invoice.status', 'A')->order_by('invoice_id', 'DESC')->limit('10')->get()->result();
                    $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->get('mech_invoice')->row()->grand_total;
                    $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->get('mech_invoice')->row()->total_due_amount;
                    $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->get('mech_invoice')->row()->total_paid_amount;
                }else{
                    $outstanding_invoice = $this->mdl_spare_invoice->where('spare_invoice.workshop_id',$this->session->userdata('work_shop_id'))->where_in('spare_invoice.invoice_status',array('0' => 'G','1' => 'PP'))->where('spare_invoice.status', 'A')->order_by('invoice_id', 'DESC')->limit('10')->get()->result();
                    $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->get('spare_invoice')->row()->grand_total;
                    $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->get('spare_invoice')->row()->total_due_amount;
                    $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->get('spare_invoice')->row()->total_paid_amount;
                }
                $outstanding_expense = $this->mdl_mech_expense->where('mech_expense.workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_expense.payment_status',array('0' => '1','1' => '2'))->where('mech_expense.status', 1)->order_by('expense_id', 'DESC')->limit('10')->get()->result();
                $outstanding_purchase = $this->mdl_mech_purchase->where('mech_purchase.workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_purchase.purchase_status',array('0' => 'G','1' => 'PP'))->where('mech_purchase.status', 'A')->order_by('purchase_id', 'DESC')->limit('10')->get()->result();
                
                $total_job_completeds = $this->db->select('count(work_order_id) as total_job_completeds')->where('jobsheet_status', '3')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_completeds;
                $total_job_openings = $this->db->select('count(work_order_id) as total_job_openings')->where('jobsheet_status', '1')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_openings;
                $total_working_progress = $this->db->select('count(work_order_id) as total_working_progress')->where('jobsheet_status', '2')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_working_progress;
                $total_onhold = $this->db->select('count(work_order_id) as total_onhold')->where('jobsheet_status', '6')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_onhold;
               
                $open_job_list = $this->mdl_mech_work_order_dtls->where('jobsheet_status', '1')->limit('15')->get()->result();
                $wip_job_list = $this->mdl_mech_work_order_dtls->where('jobsheet_status', '2')->limit('15')->get()->result();
                $spare_requested_job_list = $this->mdl_mech_work_order_dtls->where('jobsheet_status', '4')->limit('15')->get()->result();

                
                $total_purchase = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->get('mech_purchase')->row()->grand_total;
                $total_purchase_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->get('mech_purchase')->row()->total_due_amount;
                $total_purchase_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->get('mech_purchase')->row()->total_paid_amount;

                $total_expenese = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 1)->get('mech_expense')->row()->grand_total;
                $total_expenese_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 1)->get('mech_expense')->row()->total_paid_amount;
                $total_expenese_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 1)->get('mech_expense')->row()->total_due_amount;

                $recent_leads = $this->db->query("SELECT mech_clients.client_name,mech_clients.client_contact_no,mech_clients.client_email_id,mech_leads.ml_id,mech_leads.leads_no,mech_leads.reschedule_date FROM mech_leads LEFT JOIN mech_clients ON mech_clients.client_id = mech_leads.customer_id where mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.category_type = 'L' order by mech_leads.ml_id DESC limit 15")->result();
                $recent_appointments = $this->db->query("SELECT mech_clients.client_name,mech_clients.client_contact_no,mech_clients.client_email_id,mech_leads.ml_id,mech_leads.leads_no,mech_leads.reschedule_date FROM mech_leads LEFT JOIN mech_clients ON mech_clients.client_id = mech_leads.customer_id where mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.category_type = 'A' order by mech_leads.ml_id DESC limit 15")->result();

                $service_remainder = $this->db->query("SELECT msr.work_order_id,msr.next_service_km,msr.next_service_date,mc.client_name,mc.client_contact_no,mc.client_email_id,mocl.car_reg_no FROM mech_service_remainder as msr LEFT JOIN mech_clients as mc on mc.client_id = msr.customer_id LEFT JOIN mech_owner_car_list as mocl on mocl.car_list_id = msr.service_vehicle_id where msr.next_service_date between '".date('Y-m-d')."' and '".date('Y-m-d', strtotime(date('Y-m-d'). ' + 7 days'))."' and msr.workshop_id = ".$this->session->userdata('work_shop_id')." ")->result();
                $insurance_remainder = $this->db->query("SELECT mir.work_order_id,mir.policy_number,mir.next_service_ins_date,mc.client_name,mc.client_contact_no,mc.client_email_id,mocl.car_reg_no FROM mech_insurance_remainder as mir LEFT JOIN mech_clients as mc on mc.client_id = mir.customer_id LEFT JOIN mech_owner_car_list as mocl on mocl.car_list_id = mir.vehicle_id where mir.next_service_ins_date between '".date('Y-m-d')."' and '".date('Y-m-d', strtotime(date('Y-m-d'). ' + 7 days'))."' and mir.workshop_id = ".$this->session->userdata('work_shop_id')." ")->result();

            }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
               
                if($this->session->userdata('plan_type') != 3){
                    $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->where('mech_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('mech_invoice')->row()->grand_total;
                    $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->where('mech_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('mech_invoice')->row()->total_due_amount;
                    $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->where('mech_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('mech_invoice')->row()->total_paid_amount;
                    $outstanding_invoice = $this->mdl_mech_invoice->where('mech_invoice.workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_invoice.invoice_status',array('0' => 'G','1' => 'PP'))->where('mech_invoice.status', 'A')->where('mech_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->order_by('invoice_id', 'DESC')->limit('10')->get()->result();
                }else{
                    $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->where('spare_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('spare_invoice')->row()->grand_total;
                    $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->where('spare_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('spare_invoice')->row()->total_due_amount;
                    $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->where('spare_invoice.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('spare_invoice')->row()->total_paid_amount;
                    $outstanding_invoice = $this->mdl_spare_invoice->where('spare_invoice.workshop_id',$this->session->userdata('work_shop_id'))->where_in('spare_invoice.invoice_status',array('0' => 'G','1' => 'PP'))->where('spare_invoice.status', 'A')->where('spare_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->order_by('invoice_id', 'DESC')->limit('10')->get()->result();
                }
                $outstanding_expense = $this->mdl_mech_expense->where('mech_expense.workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_expense.payment_status',array('0' => '1','1' => '2'))->where('mech_expense.status', 1)->where('mech_expense.w_branch_id', $this->session->userdata('user_branch_id'))->order_by('expense_id', 'DESC')->limit('10')->get()->result();
                $outstanding_purchase = $this->mdl_mech_purchase->where('mech_purchase.workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_purchase.purchase_status',array('0' => 'G','1' => 'PP'))->where('mech_purchase.status', 'A')->where('mech_purchase.w_branch_id', $this->session->userdata('user_branch_id'))->order_by('purchase_id', 'DESC')->limit('10')->get()->result();
              
                $total_job_completeds = $this->db->select('count(work_order_id) as total_job_completeds')->where('jobsheet_status', '3')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_completeds;
                $total_job_openings = $this->db->select('count(work_order_id) as total_job_openings')->where('jobsheet_status', '1')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_openings;
                $total_working_progress = $this->db->select('count(work_order_id) as total_working_progress')->where('jobsheet_status', '2')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_working_progress;
                $total_onhold = $this->db->select('count(work_order_id) as total_onhold')->where('jobsheet_status', '6')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_onhold;

                $open_job_list = $this->mdl_mech_work_order_dtls->where('jobsheet_status', '1')->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->limit('15')->get()->result();
                $wip_job_list = $this->mdl_mech_work_order_dtls->where('jobsheet_status', '2')->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->limit('15')->get()->result();
                $spare_requested_job_list = $this->mdl_mech_work_order_dtls->where('jobsheet_status', '4')->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))->limit('15')->get()->result();

                
                $total_purchase = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_purchase.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_purchase')->row()->grand_total;
                $total_purchase_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_purchase.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_purchase')->row()->total_due_amount;
                $total_purchase_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_purchase.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_purchase')->row()->total_paid_amount;

                $total_expenese = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_expense.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 1)->get('mech_expense')->row()->grand_total;
                $total_expenese_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_expense.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 1)->get('mech_expense')->row()->total_paid_amount;
                $total_expenese_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('mech_expense.w_branch_id', $this->session->userdata('branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status',1)->get('mech_expense')->row()->total_due_amount;

                $recent_leads = $this->db->query("SELECT mech_clients.client_name,mech_clients.client_contact_no,mech_clients.client_email_id,mech_leads.ml_id,mech_leads.leads_no,mech_leads.reschedule_date FROM mech_leads LEFT JOIN mech_clients ON mech_clients.client_id = mech_leads.customer_id where mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.w_branch_id = ".$this->session->userdata('branch_id')." and mech_leads.category_type = 'L' order by mech_leads.ml_id DESC limit 15")->result();
                $recent_appointments = $this->db->query("SELECT mech_clients.client_name,mech_clients.client_contact_no,mech_clients.client_email_id,mech_leads.ml_id,mech_leads.leads_no,mech_leads.reschedule_date FROM mech_leads LEFT JOIN mech_clients ON mech_clients.client_id = mech_leads.customer_id where mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.w_branch_id = ".$this->session->userdata('branch_id')." and mech_leads.category_type = 'A' order by mech_leads.ml_id DESC limit 15")->result();

                $service_remainder = $this->db->query("SELECT msr.work_order_id,msr.next_service_km,msr.next_service_date,mc.client_name,mc.client_contact_no,mc.client_email_id,mocl.car_reg_no FROM mech_service_remainder as msr LEFT JOIN mech_clients as mc on mc.client_id = msr.customer_id LEFT JOIN mech_owner_car_list as mocl on mocl.car_list_id = msr.service_vehicle_id where msr.next_service_date between '".date('Y-m-d')."' and '".date('Y-m-d', strtotime(date('Y-m-d'). ' + 7 days'))."' and msr.workshop_id = ".$this->session->userdata('work_shop_id')." and msr.w_branch_id = ".$this->session->userdata('branch_id')."")->result();
                $insurance_remainder = $this->db->query("SELECT mir.work_order_id,mir.policy_number,mir.next_service_ins_date,mc.client_name,mc.client_contact_no,mc.client_email_id,mocl.car_reg_no FROM mech_insurance_remainder as mir LEFT JOIN mech_clients as mc on mc.client_id = mir.customer_id LEFT JOIN mech_owner_car_list as mocl on mocl.car_list_id = mir.vehicle_id where mir.next_service_ins_date between '".date('Y-m-d')."' and '".date('Y-m-d', strtotime(date('Y-m-d'). ' + 7 days'))."' and mir.workshop_id = ".$this->session->userdata('work_shop_id')." and mir.w_branch_id = ".$this->session->userdata('branch_id')."")->result();

            }else if($this->session->userdata('user_type') == 6){

                if($this->session->userdata('plan_type') != 3){
                    $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->where_in('mech_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('mech_invoice')->row()->grand_total;
                    $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->where_in('mech_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('mech_invoice')->row()->total_due_amount;
                    $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->where_in('mech_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('mech_invoice')->row()->total_paid_amount;
                    $outstanding_invoice = $this->mdl_mech_invoice->where('mech_invoice.workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_invoice.invoice_status',array('0' => 'G','1' => 'PP'))->where('mech_invoice.status', 'A')->where_in('mech_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->order_by('invoice_id', 'DESC')->limit('10')->get()->result();
                }else{
                    $total_income = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->where_in('spare_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('spare_invoice')->row()->grand_total;
                    $total_income_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->where_in('spare_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('spare_invoice')->row()->total_due_amount;
                    $total_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where('status', 'A')->where_in('spare_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->get('spare_invoice')->row()->total_paid_amount;
                    $outstanding_invoice = $this->mdl_spare_invoice->where('spare_invoice.workshop_id',$this->session->userdata('work_shop_id'))->where_in('spare_invoice.invoice_status',array('0' => 'G','1' => 'PP'))->where('spare_invoice.status', 'A')->where_in('spare_invoice.w_branch_id', $this->session->userdata('user_branch_id'))->order_by('invoice_id', 'DESC')->limit('10')->get()->result();
                }
                $outstanding_expense = $this->mdl_mech_expense->where('mech_expense.workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_expense.payment_status',array('0' => '1','1' => '2'))->where('mech_expense.status', 1)->where_in('mech_expense.w_branch_id', $this->session->userdata('user_branch_id'))->order_by('expense_id', 'DESC')->limit('10')->get()->result();
                $outstanding_purchase = $this->mdl_mech_purchase->where('mech_purchase.workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_purchase.purchase_status',array('0' => 'G','1' => 'PP'))->where('mech_purchase.status', 'A')->where_in('mech_purchase.w_branch_id', $this->session->userdata('user_branch_id'))->order_by('purchase_id', 'DESC')->limit('10')->get()->result();

                $total_job_completeds = $this->db->select('count(work_order_id) as total_job_completeds')->where('jobsheet_status', '3')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_completeds;
                $total_job_openings = $this->db->select('count(work_order_id) as total_job_openings')->where('jobsheet_status', '1')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_job_openings;
                $total_working_progress = $this->db->select('count(work_order_id) as total_working_progress')->where('jobsheet_status', '2')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_working_progress;
                $total_onhold = $this->db->select('count(work_order_id) as total_onhold')->where('jobsheet_status', '6')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_work_order_dtls')->row()->total_onhold;

                $open_job_list = $this->mdl_mech_work_order_dtls->where('jobsheet_status', '1')->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->limit('15')->get()->result();
                $wip_job_list = $this->mdl_mech_work_order_dtls->where('jobsheet_status', '2')->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->limit('15')->get()->result();
                $spare_requested_job_list = $this->mdl_mech_work_order_dtls->where('jobsheet_status', '4')->where_in('mech_work_order_dtls.w_branch_id', $this->session->userdata('user_branch_id'))->limit('15')->get()->result();

               
                $total_purchase = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_purchase.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_purchase')->row()->grand_total;
                $total_purchase_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_purchase.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_purchase')->row()->total_due_amount;
                $total_purchase_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_purchase.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 'A')->get('mech_purchase')->row()->total_paid_amount;

                $total_expenese = $this->db->select('SUM(grand_total) as grand_total')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_expense.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 1)->get('mech_expense')->row()->grand_total;
                $total_expenese_paid = $this->db->select('SUM(total_paid_amount) as total_paid_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_expense.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status', 1)->get('mech_expense')->row()->total_paid_amount;
                $total_expenese_due = $this->db->select('SUM(total_due_amount) as total_due_amount')->where('workshop_id',$this->session->userdata('work_shop_id'))->where_in('mech_expense.w_branch_id', $this->session->userdata('user_branch_id'))->where('created_by', $this->session->userdata('user_id'))->where('status',1)->get('mech_expense')->row()->total_due_amount;

                $recent_leads = $this->db->query("SELECT mech_clients.client_name,mech_clients.client_contact_no,mech_clients.client_email_id,mech_leads.ml_id,mech_leads.leads_no,mech_leads.reschedule_date FROM mech_leads LEFT JOIN mech_clients ON mech_clients.client_id = mech_leads.customer_id where mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") and mech_leads.category_type = 'L' order by mech_leads.ml_id DESC limit 15")->result();
                $recent_appointments = $this->db->query("SELECT mech_clients.client_name,mech_clients.client_contact_no,mech_clients.client_email_id,mech_leads.ml_id,mech_leads.leads_no,mech_leads.reschedule_date FROM mech_leads LEFT JOIN mech_clients ON mech_clients.client_id = mech_leads.customer_id where mech_leads.workshop_id = ".$this->session->userdata('work_shop_id')." and mech_leads.w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") and mech_leads.category_type = 'A' order by mech_leads.ml_id DESC limit 15")->result();

                $service_remainder = $this->db->query("SELECT msr.work_order_id,msr.next_service_km,msr.next_service_date,mc.client_name,mc.client_contact_no,mc.client_email_id,mocl.car_reg_no FROM mech_service_remainder as msr LEFT JOIN mech_clients as mc on mc.client_id = msr.customer_id LEFT JOIN mech_owner_car_list as mocl on mocl.car_list_id = msr.service_vehicle_id where msr.next_service_date between '".date('Y-m-d')."' and '".date('Y-m-d', strtotime(date('Y-m-d'). ' + 7 days'))."' and msr.workshop_id = ".$this->session->userdata('work_shop_id')." and msr.w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).")")->result();
                $insurance_remainder = $this->db->query("SELECT mir.work_order_id,mir.policy_number,mir.next_service_ins_date,mc.client_name,mc.client_contact_no,mc.client_email_id,mocl.car_reg_no FROM mech_insurance_remainder as mir LEFT JOIN mech_clients as mc on mc.client_id = mir.customer_id LEFT JOIN mech_owner_car_list as mocl on mocl.car_list_id = mir.vehicle_id where mir.next_service_ins_date between '".date('Y-m-d')."' and '".date('Y-m-d', strtotime(date('Y-m-d'). ' + 7 days'))."' and mir.workshop_id = ".$this->session->userdata('work_shop_id')." and mir.w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).")")->result();
                
            }
            
            $this->layout->set(
                array(
                    'permission' => $this->mdl_users->user_module_permission(),
                    'outstanding_invoice' => $outstanding_invoice,
                    'outstanding_expense' => $outstanding_expense,
                    'outstanding_purchase' => $outstanding_purchase,
                    'total_income' => number_format((float)$total_income, 2, '.', ''),
                    'total_paid' => number_format((float)$total_paid, 2, '.', ''),
                    'total_income_due' => number_format((float)$total_income_due, 2, '.', ''),
                    'total_expenese' => number_format((float)($total_expenese + $total_purchase), 2, '.', ''),
                    'total_expenese_paid' => number_format((float)($total_expenese_paid + $total_purchase_paid), 2, '.', ''),
                    'total_expenese_due' => number_format((float)($total_expenese_due + $total_purchase_due), 2, '.', ''),
                    'total_job_completeds' => $total_job_completeds,
                    'total_job_openings' => $total_job_openings,
                    'total_purchase' => $total_purchase,
                    'total_working_progress' => $total_working_progress,
                    'total_onhold' => $total_onhold,
                    'recent_leads' => $recent_leads,
                    'recent_appointments' => $recent_appointments,
                    'service_remainder' => $service_remainder,
                    'insurance_remainder' => $insurance_remainder,
                    'open_job_list' => $open_job_list,
                    'wip_job_list' => $wip_job_list,
                    'spare_requested_job_list' => $spare_requested_job_list,
                )
            );

            $this->layout->buffer('content', 'dashboard/index');
            $this->layout->render();
        }

    }
?>