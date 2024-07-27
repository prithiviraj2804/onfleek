<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function create()
    {
        $this->load->model('suppliers/mdl_suppliers');
        $this->load->helper('settings_helper');
        $this->load->model('settings/mdl_settings');
        $this->load->model('sessions/mdl_sessions');
        
        $action_from = ($this->input->post('action_from'))?$this->input->post('action_from'):'';
        $supplier_id = $this->input->post('supplier_id');
        $branch_id_select = $this->input->post('branch_id');

        if ($this->mdl_suppliers->run_validation()) {

            $supplier_group_no = $this->input->post('supplier_no');
						
			if(empty($supplier_group_no)){
                $supplier_no = $this->mdl_settings->get_invoice_number($this->input->post('invoice_group_id'));
                $_POST['supplier_no'] = $supplier_no;
			}

            $supplier_id = $this->mdl_suppliers->save($supplier_id);
            if(empty($action_from)){
                $supplier_detail = $this->mdl_suppliers->where('supplier_id', $supplier_id)->get()->result_array();
                $supplier_list = $this->mdl_suppliers->get()->result_array();
            }else{
                $supplier_detail = '';
                $supplier_list = array();
            }
            
            $response = array(
                'success' => 1,
                'supplier_detail' => $supplier_detail,
                'supplier_id' => $supplier_id,
                'supplier_list' => $supplier_list,
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
        }

        echo json_encode($response);
    }

    public function get_supplier_list($sup_id = NULL)
	{
        $this->load->model('suppliers/mdl_suppliers');
        $work_shop_id = $this->session->userdata('work_shop_id');
        $result = $this->mdl_suppliers->where('supplier_active="1"')->where('mech_suppliers.workshop_id='.$work_shop_id)->get()->result();
        echo json_encode($result);
        exit();
    }

    public function add_supplier_category(){
        $this->load->model('suppliers_category/mdl_suppliers_category');
        $this->layout->load_view('suppliers/modal_add_suppliers_category');
    }

    
    public function mobilenoexist()
    {
        $this->load->model('suppliers/mdl_suppliers');
        $phoneno = $this->input->post('supplier_contact_no');
        $supplierid = $this->input->post('supplier_id');
        $noexists = $this->mdl_suppliers->findmobileno($phoneno,$supplierid);
        if(count($noexists) > 0)
        {
            $response = array('success' => 1);

        }else{
            $response = array ('success' => 0);
        }
        echo json_encode($response);
    }

    public function get_filter_list(){

        $this->load->model('suppliers/mdl_suppliers');
        
        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;
        if($this->input->post('supplier_name')){
            $this->mdl_suppliers->like('supplier_name', trim($this->input->post('supplier_name')));
        }

        if($this->input->post('supplier_contact_no')){
            $this->mdl_suppliers->like('supplier_contact_no', trim($this->input->post('supplier_contact_no')));
        }

        if($this->input->post('supplier_email_id')){
            $this->mdl_suppliers->like('supplier_email_id', trim($this->input->post('supplier_email_id')));
        }

        if($this->input->post('branch_id')){
            $this->mdl_suppliers->where('branch_id', trim($this->input->post('branch_id')));
        }
        if($this->input->post('suppliers_category_id')){
            
            $this->mdl_suppliers->where('mech_suppliers.suppliers_category_id', $this->input->post('suppliers_category_id'));
        }

        if($this->input->post('supplier_no')){
            $this->mdl_suppliers->like('supplier_no', trim($this->input->post('supplier_no')));
        }

        $rowCount = $this->mdl_suppliers->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        if($this->input->post('supplier_name')){
            $this->mdl_suppliers->like('supplier_name', trim($this->input->post('supplier_name')));
        }

        if($this->input->post('supplier_contact_no')){
            $this->mdl_suppliers->like('supplier_contact_no', trim($this->input->post('supplier_contact_no')));
        }

        if($this->input->post('supplier_email_id')){
            $this->mdl_suppliers->like('supplier_email_id', trim($this->input->post('supplier_email_id')));
        }

        if($this->input->post('branch_id')){
            $this->mdl_suppliers->where('branch_id', trim($this->input->post('branch_id')));
        }

        if($this->input->post('suppliers_category_id')){

            $this->mdl_suppliers->where('mech_suppliers.suppliers_category_id', $this->input->post('suppliers_category_id'));
        }

        if($this->input->post('supplier_no')){
            $this->mdl_suppliers->like('supplier_no', trim($this->input->post('supplier_no')));
        }
        
        $this->mdl_suppliers->limit($limit,$start);
        $suppliers = $this->mdl_suppliers->get()->result();           

        $response = array(
            'success' => 1,
            'suppliers' => $suppliers, 
            'createLinks' => $createLinks
        );
        echo json_encode($response);
    }
}
