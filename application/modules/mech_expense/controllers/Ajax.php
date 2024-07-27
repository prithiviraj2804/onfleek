<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true; 
	
	public function expense_save()
	{
        $this->load->model('mech_expense/mdl_mech_expense');
        $this->load->model('mech_payments/mdl_mech_payments');
		$work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');
        $btn_status = $this->input->post('btn_status');
        $mm_csrf = $this->input->post('_mm_csrf');
        
        if($this->input->post('expense_id')){
           $expense_id = $this->input->post('expense_id');
			$payment_query = $this->db->query("
								select DISTINCT
(select IFNULL(SUM(payment_amount),0) from mech_payments where entity_id = ".$this->db->escape($expense_id)." and entity_type = 'expense') as invoice_amount from mech_payments where workshop_id = ".$work_shop_id." AND w_branch_id=".$branch_id."")->row();
			$total_paid_amount = $payment_query->invoice_amount + $payment_query->jobcard_amount;
		}else{
			$expense_id = NULL;
			$total_paid_amount = 0;
        }

        if($btn_status == 'G'){
			if(($total_paid_amount > 0) && ($total_paid_amount < $this->input->post('grand_total'))){
				$expense_status = 2;
			}elseif($total_paid_amount === $this->input->post('grand_total')){
				$expense_status = 3;
			}else{
				$expense_status = 1;
			}
		}else{
			$expense_status = 5;
		}
      
        if($expense_id){
            $expense_no = $this->input->post('expense_no');
            
            if($btn_status == 'G' && $expense_no == ""){
                $group_no = $this->mdl_settings->getquote_book_no('expense');
                if($group_no == 0){
                    $response = array(
                        'success' => '2',
                        'validation_errors' => array(
                            'expense_no' => 'empty',
                        )
                    );
                    
                    echo json_encode($response);
                    exit;
                }else{
                    $expense_no = $this->mdl_settings->get_invoice_number($group_no);
                }
            }
        }else{
            if($btn_status == 'G'){
                $group_no = $this->mdl_settings->getquote_book_no('expense');
                if($group_no == 0){
                    $response = array(
                        'success' => '2',
                        'validation_errors' => array(
                            'expense_no' => 'empty',
                        )
                    );
                    
                    echo json_encode($response);
                    exit;
                }else{
                    $expense_no = $this->mdl_settings->get_invoice_number($group_no);
                }
            }else{
                $expense_no = NULL;
            }
        }
        
        if ($this->mdl_mech_expense->run_validation()) {

    		$db_array = array(
                'invoice_group_id' => ($this->input->post('invoice_group_id')?$this->input->post('invoice_group_id'):NULL),
                'expense_no' => $expense_no,
                'branch_id' => $this->input->post('branch_id')?$this->input->post('branch_id'):NULL,
                'bank_id' => $this->input->post('bank_id')?$this->input->post('bank_id'):NULL,
                'shift' => $this->input->post('shift')?$this->input->post('shift'):NULL,
                'bill_no' => $this->input->post('bill_no')?$this->input->post('bill_no'):NULL,
                'expense_head_id' => $this->input->post('expense_head_id')?$this->input->post('expense_head_id'):NULL,
                'amount' => $this->input->post('amount')?$this->input->post('amount'):0,
                'is_credit' => $this->input->post('is_credit')?$this->input->post('is_credit'):NULL,
                'payment_type_id' => $this->input->post('payment_type_id')?$this->input->post('payment_type_id'):NULL,
                'cheque_no' => $this->input->post('cheque_no')?$this->input->post('cheque_no'):NULL,
                'cheque_to' => $this->input->post('cheque_to')?$this->input->post('cheque_to'):NULL,
                'bank_name' => $this->input->post('bank_name')?$this->input->post('bank_name'):NULL,
                'online_payment_ref_no' => $this->input->post('online_payment_ref_no')?$this->input->post('online_payment_ref_no'):NULL,
                'expense_date_created' => $this->input->post('expense_date_created')?date_to_mysql($this->input->post('expense_date_created')):NULL,
                'in_days' => $this->input->post('in_days')?$this->input->post('in_days'):NULL,
                'expense_date_due' => $this->input->post('expense_date_due')?date_to_mysql($this->input->post('expense_date_due')):NULL,
                'expense_date' => $this->input->post('expense_date')?date_to_mysql($this->input->post('expense_date')):NULL,
                'action_emp_id' => $this->input->post('action_emp_id')?$this->input->post('action_emp_id'):NULL,
                'tax_percentage' => $this->input->post('tax_percentage')?$this->input->post('tax_percentage'):0,
                'tax_amount' => $this->input->post('tax_amount')?$this->input->post('tax_amount'):0,
                'grand_total' => $this->input->post('grand_total')?$this->input->post('grand_total'):0,
                'total_due_amount' => (($this->input->post('grand_total')?$this->input->post('grand_total'):0) - $total_paid_amount),
                'description' => $this->input->post('description'),
                'payment_status' => $expense_status,
            );
            $expense_id = $this->mdl_mech_expense->save($expense_id, $db_array);

            if($expense_id){

                if($this->input->post('payment_type_id')){
                    if($this->input->post('deposit_id')){
                        $bankHistoryArray = array(
                            'bank_id' => $this->input->post('bank_id'),
                            'amount' => $this->input->post('grand_total')?$this->input->post('grand_total'):0,
                            'payment_date' => $this->input->post('expense_date')?date_to_mysql($this->input->post('expense_date')):NULL,
                            'shift' => $this->input->post('shift')?$this->input->post('shift'):NULL,
                            'payment_method_id' => $this->input->post('payment_type_id')?$this->input->post('payment_type_id'):NULL,
                            'action_emp_id' => $this->session->userdata('user_id'),
                            'modified_by' => $this->session->userdata('user_id'),
                        );
                        $this->db->where('deposit_id',$this->input->post('deposit_id'));
                        $deposite_id = $this->db->update('workshop_bank_trans_dtls', $bankHistoryArray);
                    }else{
                        $bankHistoryArray = array(
                            'workshop_id' => $this->session->userdata('work_shop_id'),
                            'w_branch_id' => $this->input->post('branch_id'),
                            'bank_id' => $this->input->post('bank_id'),
                            'amount' => $this->input->post('grand_total')?$this->input->post('grand_total'):0,
                            'payment_date' => $this->input->post('expense_date')?date_to_mysql($this->input->post('expense_date')):NULL,
                            'entity_id' => $expense_id,
                            'entity_type' =>  'E',
                            'tran_type' => 'W',
                            'shift' => $this->input->post('shift')?$this->input->post('shift'):NULL,
                            'payment_method_id' => $this->input->post('payment_type_id')?$this->input->post('payment_type_id'):NULL,
                            'action_emp_id' => $this->session->userdata('user_id'),
                            'created_by' => $this->session->userdata('user_id'),
                            'modified_by' => $this->session->userdata('user_id'),
                            'created_on' => date('Y-m-d'),
                        );
                        $deposite_id = $this->db->insert('workshop_bank_trans_dtls', $bankHistoryArray);
                    }
                }
            }

            $this->mdl_mech_expense->where('expense_id',$expense_id);
            $expense_details = $this->mdl_mech_expense->get()->row();

            $existing_grand_total = $this->input->post('existing_grand_total')?$this->input->post('existing_grand_total'):0;
            $grand_total = $this->input->post('grand_total')?$this->input->post('grand_total'):0;
            if($existing_grand_total != $grand_total){
                $this->db->select('current_balance');
                $this->db->from('mech_workshop_bank_list');
                $this->db->where('bank_id',$this->input->post('bank_id'));
                $bankbalance = $this->db->get()->row();

                if($existing_grand_total > $grand_total){
                    $grandtotal = $existing_grand_total - $grand_total;
                    $current_balance = $bankbalance->current_balance - $this->input->post('grand_total');
                }else{
                    $grandtotal = $grand_total - $existing_grand_total;
                    $current_balance = $bankbalance->current_balance + $this->input->post('grand_total');
                }

                $updateAccountbalance = array(
                    'current_balance' => $current_balance,
                );
                
                $this->db->where('bank_id',$this->input->post('bank_id'));
                $bank_id = $this->db->update('mech_workshop_bank_list', $updateAccountbalance);
            }

            if($expense_details){
				
				if($this->input->post('is_credit') == "N" && $expense_details->total_due_amount > 0 && $expense_details->total_paid_amount != $this->input->post('grand_total') && $btn_status == 'G'){
					$payvalue = $this->input->post('grand_total') - $expense_details->total_paid_amount;
                    $_POST['entity_id'] = $expense_details->expense_id;
                    $_POST['entity_type'] = 'expense';
                    $_POST['payment_method_id'] = $expense_details->payment_type_id;
                    $_POST['invoice_amount'] = $this->input->post('grand_total')?$this->input->post('grand_total'):0;
                    $_POST['payment_amount'] = $payvalue;
                    $_POST['customer_id'] = $expense_details->action_emp_id?$expense_details->action_emp_id:NULL;
                    $_POST['online_payment_ref_no'] = $this->input->post('online_payment_ref_no')?$this->input->post('online_payment_ref_no'):NULL;
                    $_POST['paid_on'] = $this->input->post('expense_date')?$this->input->post('expense_date'):NULL;
                    if ($this->mdl_mech_payments->run_validation()) {
                        $db_array = $this->mdl_mech_payments->db_array();
                        $id = $this->mdl_mech_payments->save(null, $db_array);
                    }
				}
            }
            
            $response = array(
                'success' => 1,
                'expense_id' => $expense_id
            );

        }else {

            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
        }

        echo json_encode($response);
		exit();
    }

    public function delete(){
        $document_id = $this->input->post('document_id');
        $this->db->set('status','2');
        $this->db->where('expense_id', $document_id);
        $this->db->update('mech_expense');
        $response = array(
            'success' => 1
        );
        echo json_encode($response);
    }

    public function model_add_expensetype(){
        $this->layout->load_view('mech_expense/modal_add_expensetype');
    }

    public function addexpensecategory(){
        $expense_category_id = $this->input->post('expense_category_id');
        $expense_category_name = $this->input->post('expense_category_name');
        
        if(!$expense_category_id){
			$id = NULL;
			$check = $this->db->select('expense_category_name')->from('mech_expense_categories')->where('expense_category_name',$expense_category_name)->where_in('workshop_id',array(1,$this->session->userdata('work_shop_id')))->where('del_flag', 'N')->get()->result();
		}else if($expense_category_id){
			$id=$expense_category_id;
			$check = $this->db->select('expense_category_name')->from('mech_expense_categories')->where('expense_category_name',$expense_category_name)->where_in('workshop_id',array(1,$this->session->userdata('work_shop_id')))->where('del_flag', 'N')->where_not_in('expense_category_id',$id)->get()->result();
        }
        
        if(count($check) > 0){
    		$response = array(
                'success' => 3,
                'error' => trans('product_already_exists'),
            );
    		echo json_encode($response);
    		exit();
        }
        
        $expesne_data_array = array(
            'expense_category_name' => $this->input->post('expense_category_name'),
            'expense_category_type' => $this->input->post('expense_category_type'),
            'created_user_id' => $this->session->userdata('user_id'),
            'workshop_id' => $this->session->userdata('work_shop_id'),
            'w_branch_id' => $this->session->userdata('branch_id'),
            'created_at' => date('Y-m-d'),
        );

        if($expense_category_id){
            $this->db->where('expense_category_id', $expense_category_id);
            $expense_cat = $this->db->update('mech_expense_categories', $expesne_data_array);
        }else{
            $expense_cat = $this->db->insert('mech_expense_categories', $expesne_data_array);
            $expense_category_id = $this->db->insert_id();
        }
       
        $response = array(
            'success' => 1,
            'expense_category_id'=>$expense_category_id,
            'expense_category_items' => $this->db->where('expense_category_type',1)->from('mech_expense_categories')->get()->result(),
            'btn_submit' => $btn_submit
        );
        echo json_encode($response);
    }

    public function get_filter_list(){
        $this->load->model('mech_expense/mdl_mech_expense');
        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;
        if($this->input->post('expense_from_date')){
            $this->mdl_mech_expense->where('mech_expense.expense_date >=', date_to_mysql($this->input->post('expense_from_date')));
        }

        if($this->input->post('expense_to_date')){
            $this->mdl_mech_expense->where('mech_expense.expense_date <=', date_to_mysql($this->input->post('expense_to_date')));
        }

        if($this->input->post('expense_no')){
            $this->mdl_mech_expense->like('mech_expense.expense_no', trim($this->input->post('expense_no')));
        }

        if($this->input->post('bill_no')){
            $this->mdl_mech_expense->like('mech_expense.bill_no', trim($this->input->post('bill_no')));
        }

        if($this->input->post('expense_head_id')){
            $this->mdl_mech_expense->where('mech_expense.expense_head_id', trim($this->input->post('expense_head_id')));
        }

        if($this->input->post('action_emp_id')){
            $this->mdl_mech_expense->where('mech_expense.action_emp_id', trim($this->input->post('action_emp_id')));
        }

        if($this->input->post('payment_status')){
            $this->mdl_mech_expense->where('mech_expense.payment_status', trim($this->input->post('payment_status')));
        }

        if($this->input->post('branch_id')){
            $this->mdl_mech_expense->where('mech_expense.branch_id', trim($this->input->post('branch_id')));
        }

        $rowCount = $this->mdl_mech_expense->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        if($this->input->post('expense_from_date')){
            $this->mdl_mech_expense->where('mech_expense.expense_date >=', date_to_mysql($this->input->post('expense_from_date')));
        }

        if($this->input->post('expense_to_date')){
            $this->mdl_mech_expense->where('mech_expense.expense_date <=', date_to_mysql($this->input->post('expense_to_date')));
        }

        if($this->input->post('expense_no')){
            $this->mdl_mech_expense->like('mech_expense.expense_no', trim($this->input->post('expense_no')));
        }

        if($this->input->post('bill_no')){
            $this->mdl_mech_expense->like('mech_expense.bill_no', trim($this->input->post('bill_no')));
        }

        if($this->input->post('expense_head_id')){
            $this->mdl_mech_expense->where('mech_expense.expense_head_id', trim($this->input->post('expense_head_id')));
        }

        if($this->input->post('action_emp_id')){
            $this->mdl_mech_expense->where('mech_expense.action_emp_id', trim($this->input->post('action_emp_id')));
        }

        if($this->input->post('payment_status')){
            $this->mdl_mech_expense->where('mech_expense.payment_status', trim($this->input->post('payment_status')));
        }

        if($this->input->post('branch_id')){
            $this->mdl_mech_expense->where('mech_expense.branch_id', trim($this->input->post('branch_id')));
        }
        $this->mdl_mech_expense->limit($limit,$start);
        $expense_list = $this->mdl_mech_expense->get()->result();           

        $response = array(
            'success' => 1,
            'expense_list' => $expense_list, 
            'createLinks' => $createLinks,
        );
        echo json_encode($response);
    }
}
