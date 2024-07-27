<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Workshop_Bank_Trans_Dtls extends Response_Model
{
    public $table = 'workshop_bank_trans_dtls';
    public $primary_key = 'workshop_bank_trans_dtls.deposit_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS workshop_bank_trans_dtls.deposit_id,workshop_bank_trans_dtls.url_key,workshop_bank_trans_dtls.workshop_id,
        workshop_bank_trans_dtls.w_branch_id,workshop_bank_trans_dtls.bank_id,workshop_bank_trans_dtls.amount,
        workshop_bank_trans_dtls.payment_date,workshop_bank_trans_dtls.entity_id,workshop_bank_trans_dtls.entity_type,
        workshop_bank_trans_dtls.tran_type,workshop_bank_trans_dtls.shift,workshop_bank_trans_dtls.payment_method_id,
        workshop_bank_trans_dtls.reference_dtls,workshop_bank_trans_dtls.action_emp_id,
        workshop_branch_details.display_board_name', false);
    }

    public function default_join()
    {
		$this->db->join('workshop_branch_details', 'workshop_branch_details.w_branch_id = workshop_bank_trans_dtls.w_branch_id', 'left');
    }

	 public function default_where()
    {
        $this->db->where('workshop_bank_trans_dtls.workshop_id' , $this->session->userdata('work_shop_id'));
        if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $this->db->where('workshop_bank_trans_dtls.w_branch_id' , $this->session->userdata('branch_id'));
            $this->db->where('workshop_bank_trans_dtls.created_by' , $this->session->userdata('user_id'));
        }else if($this->session->userdata('user_type') == 6){
            $this->db->where_in('workshop_bank_trans_dtls.w_branch_id' , $this->session->userdata('user_branch_id'));
        }
        $this->db->where('workshop_bank_trans_dtls.status', 1);
    }

    public function default_order_by()
    {
        $this->db->order_by('workshop_bank_trans_dtls.deposit_id', "desc");
    }

    public function validation_rules()
    {
        return array(
            'bank_id' => array(
                'field' => 'bank_id',
                'label' => trans('lable390'),
            ),
            'url_key' => array(
                'field' => 'url_key',
            ),
            'amount' => array(
                'field' => 'amount',
                'label' => trans('lable108'),
                'rules' => 'required'
            ),
            'payment_date' => array(
                'field' => 'payment_date',
                'label' => trans('lable31'),
                'rules' => 'required'
            ),
            'entity_id' => array(
                'field' => 'entity_id',
                // 'label' => trans('entity_id')
            ),
           'entity_type' => array(
                'field' => 'entity_type',
                // 'label' => trans('entity_type'),
            ),
            'tran_type' => array(
                'field' => 'tran_type',
                'label' => trans('lable482'),
                'rules' => 'required'
            ),
            'shift' => array(
                'field' => 'shift',
                'label' => trans('lable152'),
            ),
            'payment_method_id' => array(
                'field' => 'payment_method_id',
                'label' => trans('lable465'),
                'rules' => 'required'
            ),
            'reference_dtls' => array(
                'field' => 'reference_dtls',
                'label' => trans('lable486'),
            ),
            'action_emp_id' => array(
                'field' => 'action_emp_id',
                'label' => trans('lable148'),
            ),
            '_mm_csrf' => array(
                'field' => '_mm_csrf'
            )
        );
    }
	
	public function db_array()
    {
        $db_array = parent::db_array();
		$db_array['workshop_id'] = $this->session->userdata('work_shop_id');
    	$db_array['w_branch_id'] = $this->input->post('branch_id');
    	$db_array['created_by'] = $this->session->userdata('user_id');
    	$db_array['modified_by'] = $this->session->userdata('user_id');
        return $db_array;
    }

	public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();
        $id = parent::save($id, $db_array);
        return $id;
    }

    public function getUploadedImages($url_key){

        $this->db->select('upload_id,entity_id,url_key,file_name_original,file_name_new');
        $this->db->where('url_key',$url_key);
        $this->db->from('ip_uploads');
        $this->db->order_by('upload_id','desc');
        return $this->db->get()->result();
       
    }

    public function get_url_key()
    {
        $this->load->helper('string');
        return random_string('alnum', 15);
    }
    
}