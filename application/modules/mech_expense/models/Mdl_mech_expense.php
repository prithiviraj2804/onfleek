<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mdl_Mech_Expense extends Response_Model
{
    public $table = 'mech_expense';
    public $primary_key = 'mech_expense.expense_id';
    public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mech_expense.expense_id,mech_expense.workshop_id,
        mech_expense.w_branch_id,mech_expense.branch_id,mech_expense.bank_id,mech_expense.shift,
        mech_expense.bill_no,mech_expense.invoice_group_id,mech_expense.expense_no,
        mech_expense.expense_head_id,mech_expense.amount,mech_expense.is_credit,mech_expense.payment_type_id,
        mech_expense.cheque_no,mech_expense.cheque_to,mech_expense.bank_name,mech_expense.online_payment_ref_no,
        mech_expense.expense_date_created,mech_expense.in_days,mech_expense.expense_date_due,
        mech_expense.expense_date,mech_expense.action_emp_id,
        mech_expense.tax_percentage,mech_expense.tax_amount,mech_expense.grand_total,
        mech_expense.total_due_amount,mech_expense.total_paid_amount,mech_expense.description,
        mech_expense.payment_status,expcat.expense_category_name,mech_employee.employee_name,mech_employee.employee_number,workshop_branch_details.display_board_name', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_expense.expense_date,mech_expense.expense_id','desc');
    }
    public function default_join()
    {
        $this->db->join('mech_expense_categories expcat', 'expcat.expense_category_id = mech_expense.expense_head_id', 'LEFT');
        $this->db->join('mech_employee','mech_employee.employee_id = mech_expense.action_emp_id', 'left');
        $this->db->join('workshop_branch_details', 'workshop_branch_details.w_branch_id = mech_expense.branch_id', 'left');

    }

    public function default_where()
    {
        $this->db->where('mech_expense.workshop_id' , $this->session->userdata('work_shop_id'));
        if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $this->db->where('mech_expense.w_branch_id' , $this->session->userdata('branch_id'));
            $this->db->where('mech_expense.created_by' , $this->session->userdata('user_id'));
        }else if($this->session->userdata('user_type') == 6){
            $this->db->where_in('mech_expense.w_branch_id' , $this->session->userdata('user_branch_id'));
        }
        $this->db->where('mech_expense.status = "1"');
    }

    public function validation_rules()
    {
        return array(
            'bill_no' => array(
                'field' => 'bill_no',
                'label' => trans('lable34'),
            ),
            'branch_id' => array(
                'field' => 'branch_id',
                'label' => trans('lable51'),
                'rules' => 'required',
            ),
            'invoice_group_id' => array(
                'field' => 'invoice_group_id',
                'label' => trans('lable464'),
                'rules' => 'required',
            ),
            'bank_id' => array(
                'field' => 'bank_id',
                'label' => trans('lable390'),
            ),
            'shift' => array(
                'field' => 'shift',
                'label' => trans('lable152'),
            ),
            'expense_date' => array(
                'field' => 'expense_date',
                'label' => trans('lable386'),
                'rules' => 'required',
            ),
            'amount' => array(
                'field' => 'amount',
                'label' => trans('lable108'),
                'rules' => 'required',
            ),
            'is_credit' => array(
                'field' => 'is_credit',
                'label' => trans('lable381'),
            ),
            'payment_type_id' => array(
                'field' => 'payment_type_id',
                'label' => trans('lable109'),
                // 'rules' => 'required',
            ),
            'cheque_no' => array(
                'field' => 'cheque_no',
                'label' => trans('lable755'),
            ),
            'cheque_to' => array(
                'field' => 'cheque_to',
                'label' => trans('lable756'),
            ),
            'bank_name' => array(
                'field' => 'bank_name',
                'label' => trans('lable99'),
            ),
            'online_payment_ref_no' => array(
                'field' => 'online_payment_ref_no',
                'label' => trans('lable385'),
            ),
            'expense_date_created' => array(
                'field' => 'expense_date_created',
                'label' => trans('lable452'),
            ),
            'in_days' => array(
                'field' => 'in_days',
                'label' => trans('lable387'),
            ),
            'expense_date_due' => array(
                'field' => 'expense_date_due',
                'label' => trans('lable127'),
            ),
            'expense_head_id' => array(
                'field' => 'expense_head_id',
                'label' => trans('lable454'),
                'rules' => 'required',
            ),
            'action_emp_id' => array(
                'field' => 'action_emp_id',
                'label' => trans('lable148'),
                'rules' => 'required',
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
        $db_array['workshop_id'] = $this->session->userdata('work_shop_id');
        $db_array['w_branch_id'] = $this->session->userdata('branch_id');
        $db_array['created_by'] = $this->session->userdata('user_id');
        $db_array['modified_by'] = $this->session->userdata('user_id');
        $id = parent::save($id, $db_array);
        return $id;
    }

    public function getExpenseTypeName($expenseHeadId = null)
    {
        return $this->db->select('expense_category_name')->from('mech_expense_categories')->where('expense_category_id', $expenseHeadId)->get()->row()->expense_category_name;
    }

    public function get_expense_product_item($expense_id = null)
    {
        if ($expense_id) {
            $work_shop_id = $this->session->userdata('work_shop_id');
            $branch_id = $this->session->userdata('branch_id');
            $this->db->select('mpi.item_id,mpi.workshop_id,mpi.w_branch_id,mpi.expense_id,mpi.expense_category_id,mpi.user_id,mpi.product_id,mpi.item_name,mpi.item_hsn,mpi.item_price,mpi.item_qty,mpi.item_discount,mpi.igst_pct,mpi.igst_amount,mpi.cgst_pct,mpi.cgst_amount,mpi.sgst_pct,mpi.sgst_amount,mpi.item_total_amount,mp.url_key,mp.product_name,mp.hsn_code,mp.sku_code,mp.product_category_id,mp.product_type,mp.unit_type,mp.reorder_quantity,mp.kilo_from,mp.kilo_to,mp.mon_from,mp.mon_to,mp.fuel_type,mp.rack_no,mp.cost_price,mp.sale_price,mp.diff_amount,mp.tax_percentage,mp.description');
            $this->db->from('mech_expense_item mpi');
            $this->db->join('mech_products mp', 'mp.product_id = mpi.product_id');
            $this->db->where('mpi.expense_id', $expense_id);
            $product_items = $this->db->get()->result();
        } else {
            $product_items = array();
        }

        return json_encode($product_items);
    }

    public function updateExpensePayment($amount, $invoice_id)
    {
        $this->db->set('total_paid_amount', 'total_paid_amount + '.$amount, false);
        $this->db->set('total_due_amount', 'total_due_amount - '.$amount, false);
        $this->db->where('expense_id', $invoice_id);
        $this->db->update('mech_expense');

        $this->db->select('total_due_amount');
        $due = $this->db->get_where('mech_expense', array('expense_id' => $invoice_id))->row();

        if ($due->total_due_amount == 0.00) {
            $this->db->set('payment_status', 3);
            $this->db->where('expense_id', $invoice_id);
            $this->db->update('mech_expense');
        } else {
            $this->db->set('payment_status', 2);
            $this->db->where('expense_id', $invoice_id);
            $this->db->update('mech_expense');
        }
    }

    public function reduceExpensePayment($amount, $invoice_id)
    {
        $this->db->set('total_paid_amount', 'total_paid_amount - '.$amount, false);
        $this->db->set('total_due_amount', 'total_due_amount + '.$amount, false);
        $this->db->where('expense_id', $invoice_id);
        $this->db->update('mech_expense');

        $this->db->select('total_due_amount');
        $due = $this->db->get_where('mech_expense', array('expense_id' => $invoice_id))->row();

        if ($due->total_due_amount == 0.00) {
            $this->db->set('payment_status', 3);
            $this->db->where('expense_id', $invoice_id);
            $this->db->update('mech_expense');
        } else {
            $this->db->set('payment_status', 2);
            $this->db->where('expense_id', $invoice_id);
            $this->db->update('mech_expense');
        }
    }

    public function updateTotalDueAmount($invoice_id)
    {
        $this->db->select('grand_total,payment_status');
        $due = $this->db->get_where('mech_expense', array('expense_id' => $invoice_id))->row();
        $grand_total = $due->grand_total;

        $this->db->select_sum('payment_amount');
        $total_paid = $this->db->get_where('mech_payments', array('entity_id' => $invoice_id, 'entity_type' => 'expense'))->row();

        $total_paid = $total_paid->payment_amount;
        $total_due_amount = $grand_total - $total_paid;

        $this->db->set('total_paid_amount', $total_paid);
        $this->db->set('total_due_amount', $total_due_amount);
        if ($due->payment_status != 1) {
            if ($total_due_amount == 0.00) {
                $this->db->set('expense_status', 3);
            } else {
                $this->db->set('expense_status', 2);
            }
        }
        $this->db->where('expense_id', $invoice_id);
        $this->db->update('mech_expense');
    }
}