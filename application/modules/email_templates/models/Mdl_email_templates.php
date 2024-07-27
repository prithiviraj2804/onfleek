<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


class Mdl_Email_Templates extends Response_Model
{
    public $table = 'ip_email_templates';
    public $primary_key = 'ip_email_templates.email_template_id';
    public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('email_template_title');
    }

    public function default_where()
    {
        $this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
       if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
			$this->db->where('w_branch_id', $this->session->userdata('branch_id'));
			$this->db->where('created_by', $this->session->userdata('user_id'));
		}else if($this->session->userdata('user_type') == 6){
            $this->db->where_in('w_branch_id', $this->session->userdata('user_branch_id'));
		}
		$this->db->where('status', 'A');
    }

    public function validation_rules()
    {
        return array(
            'branch_id' => array(
                'field' => 'branch_id',
                'label' => trans('lable51'),
                'rules' => 'required'
            ),
            'email_template_title' => array(
                'field' => 'email_template_title',
                'label' => trans('lable496'),
                'rules' => 'required'
            ),
            'email_template_type' => array(
                'field' => 'email_template_type',
                'label' => trans('lable104'),
                'rules' => 'required'
            ),
            'email_template_subject' => array(
                'field' => 'email_template_subject',
                'label' => trans('lable811')
            ),
            'email_template_from_name' => array(
                'field' => 'email_template_from_name',
                'label' => trans('lable812')
            ),
            // 'email_template_from_email' => array(
            //     'field' => 'email_template_from_email',
            //     'label' => trans('from_email')
            // ),
            'email_template_cc' => array(
                'field' => 'email_template_cc',
                'label' => trans('lable813')
            ),
            'email_template_bcc' => array(
                'field' => 'email_template_bcc',
                'label' => trans('lable814')
            ),
            // 'email_template_pdf_template' => array(
            //     'field' => 'email_template_pdf_template',
            //     'label' => trans('default_pdf_template')
            // ),
            'email_template_body' => array(
                'field' => 'email_template_body',
                'label' => trans('lable810'),
                'rules' => 'required'
            )
        );
    }

    public function db_array()
    {
        $db_array = parent::db_array();
		unset($db_array['_mm_csrf']);
    	$db_array['created_by'] = $this->session->userdata('user_id');
    	$db_array['modified_by'] = $this->session->userdata('user_id');
		$db_array['workshop_id'] = $this->session->userdata('work_shop_id');
    	$db_array['w_branch_id'] = $this->session->userdata('branch_id');
        return $db_array;
    }

	public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();
        $id = parent::save($id, $db_array);

        return $id;
    }

}
