<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mech_Purchase extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mech_invoice_groups/mdl_mech_invoice_groups');
        $this->load->model('mdl_mech_purchase');
        $this->load->model('mech_item_master/mdl_mech_item_master');
        $this->load->model('products/mdl_products');
        $this->load->model('mech_car_brand_details/mdl_mech_car_brand_details');
        $this->load->model('product_brands/mdl_vendor_product_brand');
        $this->load->model('mech_car_brand_models_details/mdl_mech_car_brand_models_details');
        $this->load->model('suppliers/mdl_suppliers');
        $this->load->model('mech_bank_list/mdl_mech_bank_list');
        $this->load->model('families/mdl_families'); 
        $this->load->model('workshop_branch/mdl_workshop_branch'); 
        $this->load->model('users/mdl_users');
        $this->load->model('mech_tax/mdl_mech_tax');
 
    }

    public function index($page = 0)
    {

        $limit = 15;
        $query = $this->mdl_mech_purchase->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();
        $this->mdl_mech_purchase->limit($limit);
        $purchase_list = $this->mdl_mech_purchase->get()->result();
        
        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
        }else{
            $branch_list = array();
        }

        $this->layout->set(
            array(
                'purchase_list' => $purchase_list,
                'branch_list' => $branch_list,
                'supplier_details' => $this->mdl_suppliers->get()->result(),
                'createLinks' => $createLinks,
            )
        );

        $this->layout->buffer('content', 'mech_purchase/index');
        $this->layout->render();
    }
    
 	public function create($purchase_id = NULL)
    {

        if ($this->input->post('btn_cancel')) {
            redirect('mech_purchase');
        }

        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');

        if($purchase_id){
            $this->mdl_mech_purchase->where('purchase_id' , $purchase_id);
            $purchase_details = $this->mdl_mech_purchase->get()->row();
            $product_list = $this->mdl_mech_purchase->get_purchase_product_item($purchase_id);
            $product_ids = $this->mdl_mech_purchase->get_purchase_product_ids($purchase_id);
            $upload_details = $this->db->select('*')->from('ip_uploads')->where('entity_type','P' )->where('url_key',$purchase_details->url_key )->where('entity_id',$purchase_id )->where('workshop_id',$work_shop_id)->get()->result();
			$breadcrumb = "lable431";
        }else{
            $product_list = array();
            $product_ids = array();
            $purchase_details = (object) array();
            $upload_details = array();
			$breadcrumb = "lable430";
        }

        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'  ")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A' ")->result();
        }else{
            $branch_list = array();
        }

        $this->layout->set(array(
        	'breadcrumb' => $breadcrumb,
            'purchase_id' => $purchase_id,
            'branch_list' => $branch_list,
            'invoice_group' => $this->mdl_mech_invoice_groups->where('module_type','purchase')->where('status' , 'A')->where('workshop_id' , $work_shop_id)->get()->result(),
            'product_category_items' =>$this->mdl_mech_item_master->where('apply_for_all_bmv' , 'Y')->get()->result(),
            'car_brand_list' => $this->mdl_mech_car_brand_details->get()->result(),
			'product_brand' => $this->mdl_vendor_product_brand->get()->result(),
            'car_model_list' => $this->mdl_mech_car_brand_models_details->get()->result(),
            'car_variant_list' => $this->db->get_where('mech_brand_model_variants', array('status' => 1))->result(),
            'supplier_details' => $this->mdl_suppliers->get()->result(),
            'states' => $this->db->from('mech_state_list')->where('country_id',$this->session->userdata('default_country_id'))->get()->result(),
            'product_list' => $product_list,
            'product_ids' => $product_ids,
            'purchase_details' => $purchase_details,
            'upload_details' => $upload_details,
            'bank_list' => $this->mdl_mech_bank_list->get()->result(),
            'families' => $this->mdl_families->get()->result(),
            'gst_spare' => $this->mdl_mech_tax->where('tax_type','G')->where_in('workshop_id', array('1', $this->session->userdata('work_shop_id')))->get()->result(),
        ));

        $this->layout->buffer('content', 'mech_purchase/create');
        $this->layout->render();
    }

    public function view($purchase_id = NULL, $status = NULL)
    {
        if(!$purchase_id){
            exit();
        }
        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');
        $purchase_details = $this->mdl_mech_purchase->where('purchase_id='.$purchase_id.'')->get()->row();
        $upload_details = $this->db->select('*')->from('ip_uploads')->where('entity_type','P' )->where('entity_id',$purchase_id )->where('workshop_id',$work_shop_id)->get()->result();
        $product_list = $this->mdl_mech_purchase->get_purchase_product_item($purchase_id);
        $purchase_details->Supply_place = $this->db->from('mech_state_list')->where('state_id',$purchase_details->place_of_supply_id)->get()->row()->state_name;
        $purchase_details->supplier_name = $this->mdl_suppliers->get_supplier_name($purchase_details->supplier_id);
        
        $this->layout->set(array(
            'is_product' => $this->db->query("SELECT is_product FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND created_by = ".$this->session->userdata('user_id')." ")->row()->is_product,
            'purchase_details' => $purchase_details,
            'upload_details' => $upload_details,
            'product_list' => $product_list,
        ));
        
        $this->layout->buffer('content', 'mech_purchase/view');
        $this->layout->render();
    }
    
    public function generate_pdf($purchase_id, $stream = true, $purchase_template = null)
    {
        $this->load->helper('pdf');
        generate_user_purchase_pdf($purchase_id, $stream, $purchase_template, null);
    }

}