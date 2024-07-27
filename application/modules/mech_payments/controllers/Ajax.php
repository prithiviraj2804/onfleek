<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('client');
        $this->load->model('mech_payments/mdl_mech_payments');
        $this->load->model('mech_invoices/mdl_mech_invoice');
        $this->load->model('spare_invoices/mdl_spare_invoice');
        $this->load->model('mech_purchase/mdl_mech_purchase');
        $this->load->model('mech_expense/mdl_mech_expense');
        $this->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');
    }

    public function save(){

        $payment_id = $this->input->post('payment_id');
        
        if ($this->mdl_mech_payments->run_validation()) {

            $payment_id = $this->mdl_mech_payments->save($payment_id);

            $payment_details = $this->mdl_mech_payments->where('mech_payments.payment_id', $payment_id)->get()->row();
            $payment_list = $this->mdl_mech_payments->get()->result();

            $response = array(
                'success' => 1,
                'payment_details' => $payment_details,
                'payment_id' => $payment_id,
                'payment_list' => $payment_list
            );

        }else{
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
        }
        
        echo json_encode($response);
    }

    public function get_entity_list()
    {
        echo json_encode($this->mdl_mech_payments->getEntityList($this->input->post('entity_type')));
    }

    public function checkPaymentAmount()
    {
        $entity_type = $this->input->post('entity_type');
        $entity_id = $this->input->post('entity_id');
        $payment_amount = $this->input->post('payment_amount');

        if ($entity_type == 'invoice') {
            if($this->session->userdata('plan_type') != 3){ 
                $data = $this->mdl_mech_invoice->where('mech_invoice.invoice_id', $entity_id)->get()->row();
            }else{
                $data = $this->mdl_spare_invoice->where('spare_invoice.invoice_id', $entity_id)->get()->row();
            }
        } elseif ($entity_type == 'jobcard') {
            $data = $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.work_order_id', $entity_id)->get()->row();
        } elseif ($entity_type == 'purchase') {
            $data = $this->mdl_mech_purchase->where('mech_purchase.purchase_id', $entity_id)->get()->row();
        } elseif ($entity_type == 'expense') {
            $data = $this->mdl_mech_expense->where('mech_expense.expense_id', $entity_id)->get()->row();
        }
        if ($data == null) {
            echo '';
        } else {
            $balance = (float) $data->total_due_amount;
            
            if ($balance < $payment_amount) {
                echo trans('payment_cannot_exceed_balance');
            } else {
                echo '';
            }
        }
    }

    public function get_filter_list(){
        
        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;
        if($this->input->post('paid_on')){
            $this->mdl_mech_payments->where('mech_payments.paid_on', date_to_mysql($this->input->post('paid_on')));
        }

        if($this->input->post('entity_type')){
            $this->mdl_mech_payments->where('mech_payments.entity_type', $this->input->post('entity_type'));
        }

        if($this->input->post('payment_method_id')){
            $this->mdl_mech_payments->where('mech_payments.payment_method_id', $this->input->post('payment_method_id'));
        }

        if($this->input->post('customer_id')){
            $this->mdl_mech_payments->where('mech_payments.customer_id', $this->input->post('customer_id'));
        }

        $rowCount = $this->mdl_mech_payments->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        if($this->input->post('paid_on')){
            $this->mdl_mech_payments->where('mech_payments.paid_on', date_to_mysql($this->input->post('paid_on')));
        }

        if($this->input->post('entity_type')){
            $this->mdl_mech_payments->where('mech_payments.entity_type', $this->input->post('entity_type'));
        }

        if($this->input->post('payment_method_id')){
            $this->mdl_mech_payments->where('mech_payments.payment_method_id', $this->input->post('payment_method_id'));
        }

        if($this->input->post('customer_id')){
            $this->mdl_mech_payments->where('mech_payments.customer_id', $this->input->post('customer_id'));
        }
        $this->mdl_mech_payments->limit($limit,$start);
        $payments = $this->mdl_mech_payments->get()->result();
        
        if(count($payments) > 0){
            foreach($payments as $payment){
                $payment->cusSupname = getCustomerSupplierName($payment->customer_id, $payment->entity_type);
            }
        }

        $response = array(
            'success' => 1,
            'payments' => $payments, 
            'createLinks' => $createLinks,
        );
        echo json_encode($response);
    }
    public function modal_add_payment($entity_id = NULL, $grand_amt = NULL, $balance_amt = NULL, $customer_id = NULL, $entity_type = NULL)
    {
        $this->load->module('layout');
        $this->load->model('mech_payments/mdl_mech_payments');
        $this->load->model('payment_methods/mdl_payment_methods');
        $data = array(
            'payment_methods' => $this->mdl_payment_methods->get()->result(),
            'entity_id' => $entity_id,
            'grand_amt' => $grand_amt,
            'balance_amt' => $balance_amt,
            'customer_id' => $customer_id,
            'entity_type' => $entity_type,
        );

        $this->layout->load_view('mech_payments/modal_add_payment', $data);
    }
}
