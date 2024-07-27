<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mech_Purchase_Order extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mech_invoice_groups/mdl_mech_invoice_groups');
        $this->load->model('mdl_mech_purchase_order');
        $this->load->model('mech_item_master/mdl_mech_item_master');
        $this->load->model('products/mdl_products');
        $this->load->model('mech_car_brand_details/mdl_mech_car_brand_details');
        $this->load->model('product_brands/mdl_vendor_product_brand');
        $this->load->model('mech_car_brand_models_details/mdl_mech_car_brand_models_details');
        $this->load->model('mech_bank_list/mdl_mech_bank_list');
        $this->load->model('families/mdl_families'); 
        $this->load->model('workshop_branch/mdl_workshop_branch'); 
        $this->load->model('users/mdl_users');
 
    }

    public function index($page = 0)
    {
        $limit = 15;
        $query = $this->mdl_mech_purchase_order->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();
        $this->mdl_mech_purchase_order->limit($limit);

        $purchase_list = $this->mdl_mech_purchase_order->get()->result();

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
                'supplier_details' => $this->db->select('*')->from('admin_suppliers')->where('supplier_status','1')->get()->result(),
                'createLinks' => $createLinks,
            )
        );

        $this->layout->buffer('content', 'mech_purchase_order/index');
        $this->layout->render();
    }
    
 	public function create($purchase_id = NULL)
    {

        if ($this->input->post('btn_cancel')) {
            redirect('mech_purchase_order');
        }

        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');

        if($purchase_id){
            $this->mdl_mech_purchase_order->where('purchase_id' , $purchase_id);
            $purchase_details = $this->mdl_mech_purchase_order->get()->row();
            $purchase_details->Supply_place = $this->db->from('mech_state_list')->where('state_id',$purchase_details->place_of_supply_id)->get()->row()->state_name;
            $purchase_details->supplier_name = $this->db->select('*')->from('admin_suppliers')->where('supplier_status','1')->where('supplier_id' , $purchase_details->supplier_id)->get()->row()->supplier_name;
            $product_list = $this->mdl_mech_purchase_order->get_purchase_product_item($purchase_id);
            $upload_details = $this->db->select('*')->from('ip_uploads')->where('entity_type','PO' )->where('url_key',$purchase_details->url_key )->where('entity_id',$purchase_id )->where('workshop_id',$work_shop_id)->get()->result();
			$breadcrumb = "lable1034";
        }else{
            $product_list = array();
            $purchase_details = (object) array();
            $upload_details = array();
			$breadcrumb = "lable1033";
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
            'invoice_group' => $this->mdl_mech_invoice_groups->where('module_type','purchase_order')->where('status' , 'A')->where('workshop_id' , $work_shop_id)->get()->result(),
            'product_category_items' =>$this->mdl_mech_item_master->where('apply_for_all_bmv' , 'Y')->get()->result(),
            'car_brand_list' => $this->mdl_mech_car_brand_details->get()->result(),
			'product_brand' => $this->mdl_vendor_product_brand->get()->result(),
            'car_model_list' => $this->mdl_mech_car_brand_models_details->get()->result(),
            'car_variant_list' => $this->db->get_where('mech_brand_model_variants', array('status' => 1))->result(),
            'supplier_details' => $this->db->select('*')->from('admin_suppliers')->where('supplier_status','1')->get()->result(),
            'states' => $this->db->from('mech_state_list')->where('country_id',$this->session->userdata('default_country_id'))->get()->result(),
            'product_list' => $product_list,
            'purchase_details' => $purchase_details,
            'upload_details' => $upload_details,
            'bank_list' => $this->mdl_mech_bank_list->get()->result(),
            'families' => $this->mdl_families->get()->result(),
        ));

        $this->layout->buffer('content', 'mech_purchase_order/create');
        $this->layout->render();
    }

    public function view($purchase_id = NULL, $status = NULL)
    {
        if(!$purchase_id){
            exit();
        }
        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');
        $purchase_details = $this->mdl_mech_purchase_order->where('purchase_id='.$purchase_id.'')->get()->row();
        $upload_details = $this->db->select('*')->from('ip_uploads')->where('entity_type','PO' )->where('entity_id',$purchase_id )->where('workshop_id',$work_shop_id)->get()->result();
        $product_list = $this->mdl_mech_purchase_order->get_purchase_product_item($purchase_id);
        $purchase_details->Supply_place = $this->db->from('mech_state_list')->where('state_id',$purchase_details->place_of_supply_id)->get()->row()->state_name;
        $purchase_details->supplier_name = $this->db->select('*')->from('admin_suppliers')->where('supplier_status','1')->where('supplier_id' , $purchase_details->supplier_id)->get()->row()->supplier_name;
        
        $this->layout->set(array(
            'is_product' => $this->db->query("SELECT is_product FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND created_by = ".$this->session->userdata('user_id')." ")->row()->is_product,
            'purchase_details' => $purchase_details,
            'upload_details' => $upload_details,
            'product_list' => $product_list,
        ));
        
        $this->layout->buffer('content', 'mech_purchase_order/view');
        $this->layout->render();
    }
    
    public function generate_pdf($purchase_id, $stream = true, $purchase_template = null)
    {
        $this->load->helper('pdf');
        generate_user_purchase_order_pdf($purchase_id, $stream, $purchase_template, null);
    }

    public function cancel_order($purchase_id = NULL){
        $id = $this->input->post('id');
		$this->db->where('purchase_id', $id);
		$this->db->update('mech_purchase_order', array('purchase_status'=> 9));
		$response = array(
            'success' => 1
        );
		echo json_encode($response);
    }

    public function return_order($purchase_id = NULl){
        // echo "returned Orderes";
    }
    
}