<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mdl_Mech_Payments extends Response_Model
{
    public $table = 'mech_payments';
    public $primary_key = 'mech_payments.payment_id';
    public $date_created_field = 'created_on';
    public $date_modified_field = 'updated_on';
    public $validation_rules = 'validation_rules';

    public function default_select()
    {
        if($this->session->userdata('plan_type') != 3){ 
            $this->db->select('mech_payments.payment_id,mech_payments.workshop_id,mech_payments.w_branch_id,
            mech_payments.entity_id,mech_payments.entity_type,mech_payments.payment_method_id,
            mech_payments.invoice_amount,mech_payments.payment_amount,mech_payments.customer_id,
            mech_payments.payment_note,mech_payments.online_payment_ref_no,mech_payments.paid_on,
            ip_payment_methods.*, mech_invoice.total_due_amount as inv_tda,mech_invoice.invoice_no,mech_purchase.purchase_no,mech_expense.expense_no,mech_purchase.total_due_amount as pur_tda, mech_expense.total_due_amount as exp_tda,
            mech_work_order_dtls.work_order_id,mech_work_order_dtls.jobsheet_no,mech_work_order_dtls.total_due_amount as job_tda', false);
        } else {
            $this->db->select('mech_payments.payment_id,mech_payments.workshop_id,mech_payments.w_branch_id,
            mech_payments.entity_id,mech_payments.entity_type,mech_payments.payment_method_id,
            mech_payments.invoice_amount,mech_payments.payment_amount,mech_payments.customer_id,
            mech_payments.payment_note,mech_payments.online_payment_ref_no,mech_payments.paid_on,
            ip_payment_methods.*, spare_invoice.total_due_amount as inv_tda, spare_invoice.invoice_no,mech_purchase.purchase_no,mech_expense.expense_no,mech_purchase.total_due_amount as pur_tda, mech_expense.total_due_amount as exp_tda,
            mech_work_order_dtls.work_order_id,mech_work_order_dtls.jobsheet_no,mech_work_order_dtls.total_due_amount as job_tda', false);
        }
    }

    public function default_join()
    {
        if($this->session->userdata('plan_type') != 3){
            $this->db->join('mech_invoice', 'mech_invoice.invoice_id = mech_payments.entity_id', 'left');
        } else {
            $this->db->join('spare_invoice', 'spare_invoice.invoice_id = mech_payments.entity_id', 'left');
        }
        $this->db->join('mech_work_order_dtls', 'mech_work_order_dtls.work_order_id = mech_payments.entity_id', 'left');
        $this->db->join('mech_purchase', 'mech_purchase.purchase_id = mech_payments.entity_id', 'left');
        $this->db->join('mech_expense', 'mech_expense.expense_id = mech_payments.entity_id', 'left');
        $this->db->join('ip_payment_methods', 'ip_payment_methods.payment_method_id = mech_payments.payment_method_id', 'left');
    }

    public function default_where(){
        $this->db->where('mech_payments.workshop_id' , $this->session->userdata('work_shop_id'));
		if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $this->db->where('mech_payments.w_branch_id' , $this->session->userdata('branch_id'));
            $this->db->where('mech_payments.created_by' , $this->session->userdata('user_id'));
        }else if($this->session->userdata('user_type') == 6){
            $this->db->where_in('mech_payments.w_branch_id' , $this->session->userdata('user_branch_id'));
		}
        $this->db->where('mech_payments.status', 'A');
    }

    public function validation_rules()
    {
        return array(
            'entity_id' => array(
                'field' => 'entity_id',
                'label' => trans('lable112'),
                'rules' => 'required',
            ),
            'entity_type' => array(
                'field' => 'entity_type',
                'label' => trans('lable111'),
                'rules' => 'required',
            ),
            'payment_method_id' => array(
                'field' => 'payment_method_id',
                'label' => trans('lable113'),
                'rules' => 'required',
            ),
            'invoice_amount' => array(
                'field' => 'invoice_amount',
                'label' => trans('lable114'),
            ),
            'payment_amount' => array(
                'field' => 'payment_amount',
                'label' => trans('lable115'),
                'rules' => 'required',
            ),
            'customer_id' => array(
                'field' => 'customer_id',
                // 'label' => trans('customer_id'),
                'rules' => 'required',
            ),
            'online_payment_ref_no' => array(
                'field' => 'online_payment_ref_no',
                'label' => trans('lable117'),
            ),
            'paid_on' => array(
                'field' => 'paid_on',
                'label' => trans('lable116'),
                'rules' => 'required',
            ),
            'payment_note' => array(
                'field' => 'payment_note',
                'label' => trans('lable118'),
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
        $db_array['workshop_id'] = $this->session->userdata('work_shop_id');
        $db_array['w_branch_id'] = $this->session->userdata('branch_id');
        $db_array['paid_on'] = $db_array['paid_on']?date_to_mysql($db_array['paid_on']):NULL;
        $db_array['payment_amount'] = standardize_amount($db_array['payment_amount']);
        $db_array['created_by'] = $this->session->userdata('user_id');
    	$db_array['modified_by'] = $this->session->userdata('user_id');
        return $db_array;
    }

    public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();
        $id = parent::save($id, $db_array);
        $entity_type = $db_array['entity_type'];

        if ($entity_type == 'invoice') {
            if($this->session->userdata('plan_type') != 3){
                $this->load->model('mech_invoices/mdl_mech_invoice');
                $this->mdl_mech_invoice->updateInvoicePayment($db_array['payment_amount'], $db_array['entity_id']);
            } else {
                $this->load->model('spare_invoices/mdl_spare_invoice');
                $this->mdl_spare_invoice->updateInvoicePayment($db_array['payment_amount'], $db_array['entity_id']);
            }
        } elseif ($entity_type == 'jobcard') {
            $this->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');
            $this->mdl_mech_work_order_dtls->updateJobcardPayment($db_array['payment_amount'], $db_array['entity_id']);
        } elseif ($entity_type == 'purchase') {
            $this->load->model('mech_purchase/mdl_mech_purchase');
            $this->mdl_mech_purchase->updatePurchasePayment($db_array['payment_amount'], $db_array['entity_id']);
        } elseif ($entity_type == 'expense') {
            $this->load->model('mech_expense/mdl_mech_expense');
            $this->mdl_mech_expense->updateExpensePayment($db_array['payment_amount'], $db_array['entity_id']);
        }

        return $id;
    }

    public function delete($id = null)
    {
        // Get the invoice id before deleting payment
        $this->db->select('entity_id,entity_type,payment_amount');
        $this->db->where('payment_id', $id);
        $data = $this->db->get('mech_payments')->row();

        $entity_id = $data->entity_id;
        $entity_type = $data->entity_type;
        $payment_amount = $data->payment_amount;
        // Recalculate invoice amounts
        if ($entity_type == 'invoice') {
            if($this->session->userdata('plan_type') != 3){
                $this->load->model('mech_invoices/mdl_mech_invoice');
                $this->mdl_mech_invoice->reduceInvoicePayment($payment_amount, $entity_id);
            } else {
                $this->load->model('spare_invoices/mdl_spare_invoice');
                $this->mdl_spare_invoice->reduceInvoicePayment($payment_amount, $entity_id);
            }
        } elseif ($entity_type == 'jobcard') {
            $this->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');
            $this->mdl_mech_work_order_dtls->reduceJobcardPayment($payment_amount, $entity_id);
        } elseif ($entity_type == 'purchase') {
            $this->load->model('mech_purchase/mdl_mech_purchase');
            $this->mdl_mech_purchase->reducePurchasePayment($payment_amount, $entity_id);
        } elseif ($entity_type == 'expense') {
            $this->load->model('mech_expense/mdl_mech_expense');
            $this->mdl_mech_expense->reduceExpensePayment($payment_amount, $entity_id);
        }
        // Delete the payment
        parent::delete($id);
        //$this->load->helper('orphan');
        //delete_orphans();
    }

    public function prep_form($id = null)
    {
        if (!parent::prep_form($id)) {
            return false;
        }

        if (!$id) {
            parent::set_form_value('payment_date', date('Y-m-d'));
        }

        return true;
    }

    public function by_client($client_id)
    {
        $this->filter_where('ip_clients.client_id', $client_id);
        return $this;
    }

    public function getEntityList($entity_type = null)
    {
        if($this->session->userdata('user_type') == 3){
            if ($entity_type == 'invoice') {
                if($this->session->userdata('plan_type') != 3){ 
                    $this->load->model('mech_invoices/mdl_mech_invoice');
                    $open_invoices = $this->mdl_mech_invoice
                    ->where('mech_invoice.workshop_id', $this->session->userdata('work_shop_id'))
                    ->where('mech_invoice.total_due_amount >', 0)
                    ->or_where('mech_invoice.total_due_amount <', 0)
                    ->get()->result();
                }else {
                    $this->load->model('spare_invoices/mdl_spare_invoice');
                    $open_invoices = $this->mdl_spare_invoice
                    ->where('spare_invoice.workshop_id', $this->session->userdata('work_shop_id'))
                    ->where('spare_invoice.total_due_amount >', 0)
                    ->or_where('spare_invoice.total_due_amount <', 0)
                    ->get()->result();
                }
            } elseif ($entity_type == 'jobcard') {
                $this->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');
                $open_invoices = $this->mdl_mech_work_order_dtls
                ->where('mech_work_order_dtls.workshop_id', $this->session->userdata('work_shop_id'))
                ->where('mech_work_order_dtls.jobsheet_status !=','C')
                ->get()->result();
            } elseif ($entity_type == 'purchase') {
                $this->load->model('mech_purchase/mdl_mech_purchase');
                $open_invoices = $this->mdl_mech_purchase
                ->where('mech_purchase.workshop_id', $this->session->userdata('work_shop_id'))
                ->where('mech_purchase.total_due_amount >', 0)
                ->or_where('mech_purchase.total_due_amount <', 0)
                ->get()->result();
            } elseif ($entity_type == 'expense') {
                $this->load->model('mech_expense/mdl_mech_expense');
                $open_invoices = $this->mdl_mech_expense
                ->where('mech_expense.workshop_id', $this->session->userdata('work_shop_id'))
                ->where('mech_expense.total_due_amount >', 0)
                ->or_where('mech_expense.total_due_amount <', 0)
                ->get()->result();
            }
        }else{
            if ($entity_type == 'invoice') {
                if($this->session->userdata('plan_type') != 3){ 
                    $this->load->model('mech_invoices/mdl_mech_invoice');
                    $open_invoices = $this->mdl_mech_invoice
                    ->where('mech_invoice.workshop_id', $this->session->userdata('work_shop_id'))
                    ->where('mech_invoice.w_branch_id', $this->session->userdata('branch_id'))
                    ->where('mech_invoice.total_due_amount >', 0)
                    ->or_where('mech_invoice.total_due_amount <', 0)
                    ->get()->result();
                } else {
                    $this->load->model('spare_invoices/mdl_spare_invoice');
                    $open_invoices = $this->mdl_spare_invoice
                    ->where('spare_invoice.workshop_id', $this->session->userdata('work_shop_id'))
                    ->where('spare_invoice.w_branch_id', $this->session->userdata('branch_id'))
                    ->where('spare_invoice.total_due_amount >', 0)
                    ->or_where('spare_invoice.total_due_amount <', 0)
                    ->get()->result();
                }
            } elseif ($entity_type == 'jobcard') {
                $this->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');
                $open_invoices = $this->mdl_mech_work_order_dtls
                ->where('mech_work_order_dtls.workshop_id', $this->session->userdata('work_shop_id'))
                ->where('mech_work_order_dtls.w_branch_id', $this->session->userdata('branch_id'))
                ->where('mech_work_order_dtls.jobsheet_status !=','C')
                ->get()->result();
            } elseif ($entity_type == 'purchase') {
                $this->load->model('mech_purchase/mdl_mech_purchase');
                $open_invoices = $this->mdl_mech_purchase
                ->where('mech_purchase.workshop_id', $this->session->userdata('work_shop_id'))
                ->where('mech_purchase.w_branch_id', $this->session->userdata('branch_id'))
                ->where('mech_purchase.total_due_amount >', 0)
                ->or_where('mech_purchase.total_due_amount <', 0)
                ->get()->result();
            } elseif ($entity_type == 'expense') {
                $this->load->model('mech_expense/mdl_mech_expense');
                $open_invoices = $this->mdl_mech_expense
                ->where('mech_expense.workshop_id', $this->session->userdata('work_shop_id'))
                ->where('mech_expense.w_branch_id', $this->session->userdata('branch_id'))
                ->where('mech_expense.total_due_amount >', 0)
                ->or_where('mech_expense.total_due_amount <', 0)
                ->get()->result();
            }
        }

        // print_r($open_invoices);
        // exit();
        
        return $open_invoices;
    }
}