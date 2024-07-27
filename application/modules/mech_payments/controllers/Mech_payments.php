<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mech_Payments extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('client');
        $this->load->model('mdl_mech_payments');
        $this->load->model('mech_invoices/mdl_mech_invoice');
        $this->load->model('spare_invoices/mdl_spare_invoice');
        $this->load->model('clients/mdl_clients');
        $this->load->model('suppliers/mdl_suppliers');
        $this->load->model('payment_methods/mdl_payment_methods');
    }

    public function index($page = 0)
    {
        $limit = 15;
        $query = $this->mdl_mech_payments->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();
        $this->mdl_mech_payments->limit($limit);
        $payments = $this->mdl_mech_payments->order_by('paid_on', 'DESC')->get()->result();
        $this->layout->set(
            array(
                'payments' => $payments,
                'filter_display' => true,
                'filter_placeholder' => trans('filter_payments'),
                'filter_method' => 'filter_payments',
                'payment_methods' => $this->mdl_payment_methods->get()->result(),
                'customer_list' => $this->mdl_clients->where('client_active','A')->get()->result(),
                'supplier_details' => $this->mdl_suppliers->get()->result(),
                'createLinks' => $createLinks
            )
        );

        $this->layout->buffer('content', 'mech_payments/index');
        $this->layout->render();
    }

    public function form($id = null)
    {

        if ($this->input->post('btn_cancel')) {
            redirect('mech_payments');
        }

        if ($this->mdl_mech_payments->run_validation()) {
            $id = $this->mdl_mech_payments->save($id);
            redirect('mech_payments');
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_mech_payments->prep_form($id)) {
                show_404();
            }
        }

        if ($id) {
            $payment = $this->mdl_mech_payments->where('mech_payments.payment_id', $id)->get()->row();
            if (!empty($payment->entity_type)) {
                $this->load->model('mech_payments/mdl_mech_payments');
                $open_invoices = $this->mdl_mech_payments->getEntityList($payment->entity_type);
            }
        } else {
            $payment = array();
            $open_invoices = array();
        }

        $this->layout->set(
            array(
                'payment_id' => $id,
                'payment' => $payment,
                'open_invoices' => $open_invoices,
                'payment_methods' => $this->mdl_payment_methods->get()->result(),
             )
        );

        $this->layout->buffer('content', 'mech_payments/form');
        $this->layout->render();
    }

    public function delete()
    {
    	$id = $this->input->post('id');
		$this->db->where('payment_id', $id);
		$this->db->update('mech_payments', array('status'=>'D'));
		$response = array(
            'success' => 1
        );
		echo json_encode($response);
    }
}
