<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Class Mdl_suppliers.
 */
class Mdl_Suppliers extends Response_Model
{
    public $table = 'mech_suppliers';
    public $primary_key = 'mech_suppliers.supplier_id';
    public $date_created_field = 'supplier_date_created';
    public $date_modified_field = 'supplier_date_modified';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mech_suppliers.supplier_id,mech_suppliers.workshop_id,mech_suppliers.w_branch_id,
        mech_suppliers.supplier_name,mech_suppliers.branch_id,mech_suppliers.supplier_gstin,
        mech_suppliers.supplier_street,mech_suppliers.supplier_area,mech_suppliers.supplier_city,
        mech_suppliers.supplier_state,mech_suppliers.supplier_pincode,mech_suppliers.supplier_country,mech_suppliers.credit_period,
        mech_suppliers.supplier_contact_no,mech_suppliers.supplier_email_id,mech_suppliers.supplier_active,mech_suppliers.supplier_no,
        workshop_branch_details.display_board_name,mech_suppliers.suppliers_category_id,mech_suppliers_category.suppliers_category_name,
        SUM(mech_purchase.total_due_amount) AS total_due_amount', false);
    }

    public function default_join()
    {
        $this->db->join('workshop_branch_details', 'workshop_branch_details.w_branch_id = mech_suppliers.branch_id', 'left');
        $this->db->join('mech_suppliers_category' , 'mech_suppliers_category.suppliers_category_id = mech_suppliers.suppliers_category_id', 'left');
        $this->db->join('mech_purchase' , 'mech_purchase.supplier_id = mech_suppliers.supplier_id', 'left');
    }

    public function default_where()
    {
        $this->db->where_in('mech_suppliers.workshop_id', array('1',$this->session->userdata('work_shop_id')));
        if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
			$this->db->where('mech_suppliers.w_branch_id', $this->session->userdata('branch_id'));
			$this->db->where('mech_suppliers.supplier_created_by', $this->session->userdata('user_id'));
		}elseif($this->session->userdata('user_type') == 6){
			$this->db->where_in('mech_suppliers.w_branch_id', $this->session->userdata('user_branch_id'));
		}
		$this->db->where('mech_suppliers.supplier_active', 1);
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_suppliers.supplier_name');
    }

    public function default_GROUP_BY()
    {
        $this->db->GROUP_BY('mech_suppliers.supplier_id');
    }

    public function validation_rules()
    {
        return array(
            'supplier_name' => array(
                'field' => 'supplier_name',
                'label' => trans('lable50'),
                'rules' => 'required',
            ),
            'branch_id' => array(
                'field' => 'branch_id',
                'label' => trans('lable51'),
                'rules' => 'required',
            ),
            'suppliers_category_id' => array(
                'field' => 'suppliers_category_id',
                'label' => trans('lable208'),
                // 'rules' => 'required',
            ),
            'supplier_gstin' => array(
                'field' => 'supplier_gstin',
                'label' => trans('lable84'),
            ),
            'supplier_contact_no' => array(
                'field' => 'supplier_contact_no',
                'label' => trans('lable42'),
                'rules' => 'required|trim|strip_tags|numeric',
                //'rules' => 'required|trim|strip_tags|numeric|callback_checkSupplierMobileExist'
            ),
            'supplier_email_id' => array(
                'field' => 'supplier_email_id',
                'label' => trans('lable41'),
               // 'rules' => 'required|valid_email|trim|strip_tags',
                //'rules' => 'required|valid_email|trim|strip_tags|callback_checkSupplierEmailExist'
            ),
            'supplier_street' => array(
                'field' => 'supplier_street',
                'label' => trans('lable85'),
                // 'rules' => 'required',
            ),
            'supplier_city' => array(
                'field' => 'supplier_city',
                'label' => trans('lable88'),
               // 'rules' => 'required',
            ),
            // 'supplier_area' => array(
            //     'field' => 'supplier_area',
            //     'label' => trans('Area'),
            // ),
            'supplier_state' => array(
                'field' => 'supplier_state',
                'label' => trans('lable87'),
               // 'rules' => 'required',
            ),
            'supplier_country' => array(
                'field' => 'supplier_country',
                'label' => trans('lable86'),
               // 'rules' => 'required',
            ),
            'supplier_pincode' => array(
                'field' => 'supplier_pincode',
                'label' => trans('lable89'),
               // 'rules' => 'required',
            ),
            'credit_period' => array(
                'field' => 'credit_period',
                'label' => trans('lable1128'),
               // 'rules' => 'required',
            ),
            'supplier_no' => array(
                'field' => 'supplier_no',
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
        /*
        if (!isset($db_array['supplier_active'])) {
            $db_array['supplier_active'] = 'A';
        }
        */
        unset($db_array['supplier_id']);
        $db_array['supplier_created_by'] = $this->session->userdata('user_id');
        $db_array['supplier_modified_by'] = $this->session->userdata('user_id');
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

    public function delete($id)
    {
        parent::delete($id);

        $this->load->helper('orphan');
        delete_orphans();
    }

    public function get_supplier_name($supplier_id)
    {
        $this->db->select('supplier_name');
        $this->db->from('mech_suppliers');
        $this->db->where('mech_suppliers.supplier_id', $supplier_id);

        return $this->db->get()->row()->supplier_name;
    }

    public function checkSupplierEmailExist($email_id = null)
    {
        if ($email_id != '') {
            $supplier_id = $this->input->post('supplier_id');
            if ($supplier_id) {
                $check = $this->db->select('supplier_email_id')->from('mech_suppliers')->where('supplier_email_id', $email_id)->where('mech_suppliers.supplier_id!=', $supplier_id, false)->where('supplier_active', 'A')->get()->result();
            } else {
                $check = $this->db->select('supplier_email_id')->from('mech_suppliers')->where('supplier_email_id', $email_id)->where('supplier_active', 'A')->get()->result();
            }
            $existing_email = array();
            foreach ($check as $exists) {
                $already_exists = str_replace(' ', '', strtolower($exists->supplier_email_id));
                array_push($existing_email, $already_exists);
            }

            if (in_array($email_id, $existing_email)) {
                $this->form_validation->set_message('checkSupplierEmailExist', 'Email id already exist.');

                return false;
            } else {
                return true;
            }
        }
    }

    public function checkSupplierMobileExist($mobile_no = null)
    {
        if ($mobile_no != '') {
            $supplier_id = $this->input->post('supplier_id');
            if ($supplier_id) {
                $check = $this->db->select('supplier_contact_no')->from('mech_suppliers')->where('supplier_contact_no', $mobile_no)->where('mech_suppliers.supplier_id!=', $supplier_id, false)->where('supplier_active', 'A')->get()->result();
            } else {
                $check = $this->db->select('supplier_contact_no')->from('mech_suppliers')->where('supplier_contact_no', $mobile_no)->where('supplier_active', 'A')->get()->result();
            }
            // print_r($check);
            // exit();
            $existing_mobile = array();
            foreach ($check as $exists) {
                $already_exists = str_replace(' ', '', strtolower($exists->supplier_contact_no));
                array_push($existing_mobile, $already_exists);
            }

            if (in_array($mobile_no, $existing_mobile)) {
                $this->form_validation->set_message('checkSupplierMobileExist', 'Mobile No already exist.');

                return false;
            } else {
                return true;
            }
        }
    }
    
    public function findmobileno($phoneno = NULL,$supplierid = NULL)
	{
		$this->db->select('*'); 
		$this->db->from('mech_suppliers');
        $this->db->where('supplier_contact_no', $phoneno);
        $this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
        $this->db->where('w_branch_id', $this->session->userdata('branch_id'));
        $this->db->where_not_in('mech_suppliers.supplier_id', $supplierid);
		$query = $this->db->get()->result();
		return $query;
	}
}
