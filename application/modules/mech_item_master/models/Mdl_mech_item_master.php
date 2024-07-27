<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mdl_Mech_Item_Master extends Response_Model
{
    public $table = 'mech_products';
    public $primary_key = 'mech_products.product_id';
    public $date_created_field = 'created_on';
    
    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS DISTINCT mech_products.product_id, mech_products.url_key,
        mech_products.workshop_id, mech_products.w_branch_id, mech_products.product_name, 
        mech_products.parent_id, mech_products.is_parent, mech_products.product_category_id, 
        mech_products.product_type, mech_products.unit_type,  mech_products.product_brand_id,
        mech_products.vendor_part_no, mech_products.hsn_code, mech_products.tax_percentage, 
        mech_products.apply_for_all_bmv, mech_products.kilo_from, mech_products.kilo_to, 
        mech_products.mon_from, mech_products.mon_to, mech_products.diff_amount, 
        mech_products.description, mech_products.part_number, mech_products.default_mrp_price,
        mech_products.default_cost_price, mech_products.default_sale_price, mech_products.tax_id,
        mech_products.fill_gst, mech_products.fill_inventory, mech_products.current_stock,
        mech_products.reorder_quantity, mech_products.rack_no,
        vendor_product_brand.prd_brand_name,
        wk.mrp_price as mrp, wk.cost_price as cost, wk.sale_price as sale,
        mech_product_price_list.mppl_id, mech_product_price_list.mrp_price, mech_product_price_list.cost_price,
        mech_product_price_list.sale_price, 
        ip_families.family_id, ip_families.family_name,
        ip_units.unit_id, ip_units.unit_name, ip_units.unit_name_plrl,
        mech_tax.tax_name,
        mech_product_stock_details.psd_id, mech_product_stock_details.balance_stock', false);
    }

    public function default_join()
    {
        $work_shop_id =  $this->session->userdata("work_shop_id");
        $this->db->join('mech_product_price_list as wk', 'wk.product_id = mech_products.product_id and wk.workshop_id = 1', 'left');
        $this->db->join('mech_product_price_list', 'mech_product_price_list.product_id = mech_products.product_id and mech_product_price_list.workshop_id = '.$work_shop_id, 'left');
        $this->db->join('ip_families', 'ip_families.family_id = mech_products.product_category_id and ip_families.status = "A"', 'left');
        $this->db->join('ip_units', 'ip_units.unit_id = mech_products.unit_type', 'left');
        $this->db->join('vendor_product_brand','vendor_product_brand.vpb_id = mech_products.product_brand_id','left');
        $this->db->join('mech_tax','mech_tax.tax_id = mech_products.tax_id','left');
        $this->db->join('mech_product_stock_details', 'mech_product_stock_details.product_id = mech_products.product_id and mech_product_stock_details.workshop_id = '.$work_shop_id, 'left');
    }
   
    public function default_where()
    {
        $this->db->where_in('mech_products.workshop_id', array('1',$this->session->userdata('work_shop_id')));
        if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $this->db->where_in('mech_products.w_branch_id', array('1',$this->session->userdata('branch_id')));
        }else if($this->session->userdata('user_type') == 6){
            $array = $this->session->userdata('user_branch_id');
            array_push($array,'1');
            $this->db->where_in('mech_products.w_branch_id', $array);
		}
        $this->db->where('mech_products.status', 'A');
    }
    
    public function default_order_by()
    {
        $this->db->order_by('mech_products.product_name' , 'asc');
    }

    public function by_product($match)
    {
        $this->db->group_start();
        $this->db->like('mech_products.product_sku', $match);
        $this->db->or_like('mech_products.product_name', $match);
        $this->db->or_like('mech_products.product_description', $match);
        $this->db->group_end();
    }

    public function by_family($match)
    {
        $this->db->where('mech_products.family_id', $match);
    }

    public function validation_rules()
    {
        return array(
            'url_key' => array(
                'field' => 'url_key',
                'rules' => '',
                'rules' => '',
            ),
            'product_name' => array(
                'field' => 'product_name',
                'label' => trans('lable207'),
                'rules' => 'required|trim',
            ),
            'product_category_id' => array(
                'field' => 'product_category_id',
                'label' => trans('lable219'),
                'rules' => 'required|trim',
            ),
            'unit_type' => array(
                'field' => 'unit_type',
                'label' => trans('lable220'),
                'rules' => '',
            ),
            'product_brand_id' => array(
                'field' => 'product_brand_id',
                'label' => trans('lable1026'),
                'rules' => '',
            ),
            'vendor_part_no' => array(
                'field' => 'vendor_part_no',
                'label' => trans('lable1028'),
                'rules' => '',
            ),
            'part_number' => array(
                'field' => 'part_number',
                'label' => trans('lable1024'),
                'rules' => '',
            ),
            'default_mrp_price' => array(
                'field' => 'default_mrp_price',
                'label' => 'default_mrp_price',
                'rules' => '',
            ),
            'apply_for_all_bmv' => array(
                'field' => 'apply_for_all_bmv',
                'label' => trans('lable228'),
                'rules' => '',
            ),
            'default_cost_price' => array(
                'field' => 'cost_price',
                'label' => 'default_cost_price',
                'rules' => '',
            ),
            'default_sale_price' => array(
                'field' => 'sale_price',
                'label' => 'default_sale_price',
                'rules' => '',
            ),
            'fill_gst' => array(
                'field' => 'fill_gst',
                'label' => trans('lable1189'),
                'rules' => '',
            ),
            'tax_id' => array(
                'field' => 'tax_id',
                'label' => trans('lable1191'),
                'rules' => '',
            ),
            'hsn_code' => array(
                'field' => 'hsn_code',
                'label' => trans('lable218'),
                'rules' => '',
            ),
            'tax_percentage' => array(
                'field' => 'tax_percentage',
                'label' => trans('lable227'),
                'rules' => '',
            ),
            'fill_inventory' => array(
                'field' => 'fill_inventory',
                'label' => trans('lable177'),
                'rules' => '',
            ),
            'reorder_quantity' => array(
                'field' => 'reorder_quantity',
                'label' => trans('lable222'),
                'rules' => '',
            ),
            'rack_no' => array(
                'field' => 'rack_no',
                'label' => trans('lable223'),
                'rules' => '',
            ),
            'current_stock' => array(
                'field' => 'current_stock',
                'label' => trans('lable1193'),
                'rules' => '',
            ),
            'kilo_from' => array(
                'field' => 'kilo_from',
                'label' => trans('lable175'),
                'rules' => '',
            ),
            'kilo_to' => array(
                'field' => 'kilo_to',
                'label' => trans('lable176'),
                'rules' => '',
            ),
            'mon_from' => array(
                'field' => 'mon_from',
                'label' => trans('lable175'),
                'rules' => '',
            ),
            'mon_to' => array(
                'field' => 'mon_to',
                'label' => trans('lable176'),
                'rules' => '',
            ),
            'description' => array(
                'field' => 'description',
                'label' => trans('lable177'),
                'rules' => '',
            ),
            '_mm_csrf' => array(
                'field' => '_mm_csrf',
            ),
        );
    }

    public function validation_rules_add_stock()
    {
        return array(
            'stock_date' => array(
                'field' => 'stock_date',
                'label' => trans('lable652'),
                'rules' => 'required',
            ),
            'stock_type' => array(
                'field' => 'stock_type',
                'label' => trans('lable654'),
                'rules' => 'required',
            ),
            'quantity' => array(
                'field' => 'quantity',
                'label' => trans('lable643'),
                'rules' => 'required',
            ),
            'price' => array(
                'field' => 'price',
                'label' => trans('lable658'),
                'rules' => 'required',
            ),
            'note' => array(
                'field' => 'note',
                'label' => trans('lable477'),
                'rules' => '',
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
        $db_array['product_type'] = 'P';
        // if($db_array['apply_for_all_bmv'] == 'N' || $db_array['apply_for_all_bmv'] == ''){
        //     $db_array['is_parent'] = 'P';
        // }
        return $db_array;
    }

    public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();
        if($id){
            $db_array['modified_by'] = $this->session->userdata('user_id');
        }else{
            $db_array['created_by'] = $this->session->userdata('user_id');
            $db_array['modified_by'] = $this->session->userdata('user_id');
            $db_array['workshop_id'] = $this->session->userdata('work_shop_id');
            $db_array['w_branch_id'] = $this->session->userdata('branch_id');
        }
        $id = parent::save($id, $db_array);
        return $id;
    }

    public function get_product_name($product_id)
    {
        $this->db->select('product_name');
        $this->db->where('product_id', $product_id);
        $product = $this->db->get('mech_products');

        if ($product->num_rows()) {
            $product_name = $product->row()->product_name;
        } else {
            $product_name = '-';
        }

        return $product_name;
    }

    public function save_inventory($item_data = array())
    {
        $item_data['workshop_id'] = $this->session->userdata('work_shop_id');
        $item_data['w_branch_id'] = $this->session->userdata('branch_id');
        $item_data['created_user_id'] = $this->session->userdata('user_id');
        $item_data['modified_user_id'] = $this->session->userdata('user_id');
        $item_data['inventory_created'] = date('Y-m-d H:i:s');

        $check_inventory_exit = array();
        if($item_data['stock_type'] == 1 || $item_data['stock_type'] == 2){
            $check_inventory_exit = $this->db->select('*')->from('mech_inventory')->where(array('product_id' => $item_data['product_id'],'workshop_id'=>$this->session->userdata('work_shop_id'),'w_branch_id'=>$this->session->userdata('branch_id'),'stock_type'=>$item_data['stock_type'],'entity_id' => $item_data['entity_id']))->get()->row();
            if($check_inventory_exit){
                $this->db->set('quantity',$item_data['quantity']);
                $this->db->set('stock_date',$item_data['stock_date']);
                $this->db->set('modified_user_id',$this->session->userdata('user_id'));
                $this->db->where('inventory_id',$check_inventory_exit->inventory_id);
                $this->db->update('mech_inventory');
            }
        }
        if (!$check_inventory_exit) {
            $inventory_id = $this->db->insert('mech_inventory', $item_data);
        }

        $product_stock_details = $this->db->select('*')->where(array('product_id' => $item_data['product_id'], 'workshop_id' => $this->session->userdata('work_shop_id'), 'w_branch_id' => $this->session->userdata('branch_id')))->get('mech_product_stock_details')->row();

        $total_product_stock = $this->db->select('SUM(CASE WHEN action_type = 1 THEN quantity ELSE -1*quantity END) as quantity')->where(array('product_id' => $item_data['product_id'], 'workshop_id' => $this->session->userdata('work_shop_id'), 'w_branch_id' => $this->session->userdata('branch_id')))->get('mech_inventory')->row();

        if ($product_stock_details) {
            $this->db->set('balance_stock', ($total_product_stock->quantity));
            $this->db->where('psd_id', $product_stock_details->psd_id);
            $this->db->update('mech_product_stock_details');
        } else {
            $stock_data = array(
                'workshop_id' => $this->session->userdata('work_shop_id'),
                'w_branch_id' => $this->session->userdata('branch_id'),
                'product_id' => $item_data['product_id'],
                'balance_stock' => $total_product_stock->quantity,
                'created_by' => $this->session->userdata('user_id'),
                'modified_by' => $this->session->userdata('user_id'),
                'created_on' => date('Y-m-d H:i:s'),
            );

            $product_stock_id = $this->db->insert('mech_product_stock_details', $stock_data);
        }

        return 'SUCCESS';
    }

    public function get_url_key()
    {
        $this->load->helper('string');
        return random_string('alnum', 15);
    }

    public function getUploadedImages($url_key){

        $this->db->select('upload_id,entity_id,url_key,file_name_original,file_name_new');
        $this->db->where('url_key',$url_key);
        $this->db->from('ip_uploads');
        $this->db->order_by('upload_id','desc');
        return $this->db->get()->result();
       
    }

    public function getProductItemList(){

        $productList = array();

        $this->load->model('user_cars/mdl_user_cars');
        $user_car_list_id = $this->input->post('user_car_list_id');
        $customerCarDetail = $this->mdl_user_cars->where('car_list_id' , $user_car_list_id)->get()->row();
        $product_category_id  = $this->input->post('product_category_id');
        $customer_car_id = $this->input->post('customer_car_id');
        $customerCarDetail = $this->mdl_user_cars->where('car_list_id' , $customer_car_id)->get()->row();

        $this->mdl_mech_item_master->where_in('mech_products.workshop_id', array('1',$this->session->userdata('work_shop_id')));
        $this->mdl_mech_item_master->join('mech_product_map_detail', 'mech_product_map_detail.product_id = mech_products.product_id','left');
        if($customer_car_id){
            if($customerCarDetail->car_brand_id){
                $this->mdl_mech_item_master->where('mech_product_map_detail.brand_id' , $customerCarDetail->car_brand_id);
            }
            if($customerCarDetail->car_brand_model_id){
                $this->mdl_mech_item_master->where('mech_product_map_detail.model_id' , $customerCarDetail->car_brand_model_id);
            }
            if($customerCarDetail->car_variant){
                $this->mdl_mech_item_master->where('mech_product_map_detail.variant_id' , $customerCarDetail->car_variant);
            }
            if($customerCarDetail->fuel_type){
                $this->mdl_mech_item_master->where('mech_product_map_detail.fuel_type', $customerCarDetail->fuel_type);
            }
            if($customerCarDetail->car_model_year){
                $this->mdl_mech_item_master->where('mech_product_map_detail.year' , $customerCarDetail->car_model_year);
            }
        }else{
            if($this->input->post('brand_id')){
                $this->mdl_mech_item_master->where('mech_product_map_detail.brand_id' , $this->input->post('brand_id'));
            }
            if($this->input->post('model_id')){
                $this->mdl_mech_item_master->where('mech_product_map_detail.model_id' , $this->input->post('model_id'));
            }
            if($this->input->post('variant_id')){
                $this->mdl_mech_item_master->where('mech_product_map_detail.variant_id' , $this->input->post('variant_id'));
            }
            if($this->input->post('fuel_type')){
                $this->mdl_mech_item_master->where('mech_product_map_detail.fuel_type' , $this->input->post('fuel_type'));
            }
            
        }
        if($this->input->post('product_category_id')){
            $this->mdl_mech_item_master->where('mech_products.product_category_id', $this->input->post('product_category_id'));
        }
        
        if($this->input->post('product_brand_id')){
            $this->mdl_mech_item_master->where('mech_products.product_brand_id', $this->input->post('product_brand_id'));
        }

        if(($this->input->post('product_category_id') < 1) || ($this->input->post('product_brand_id') < 1)){
            $this->mdl_mech_item_master->or_where('mech_products.apply_for_all_bmv' , 'Y');
            $this->mdl_mech_item_master->where_in('mech_products.workshop_id', array('1',$this->session->userdata('work_shop_id')));
        }
        
        return $this->mdl_mech_item_master->get()->result();
    }

    public function getAdminProductItemList(){
        $work_shop_id =  $this->session->userdata("work_shop_id");
        $productList = array();
        $this->load->model('mech_item_master/mdl_mech_service_master');

        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;

        $this->db->select('mech_products.*, mech_product_map_detail.brand_id, mech_product_map_detail.model_id, mech_product_map_detail.variant_id, mech_product_map_detail.fuel_type,
        mech_product_price_list.mppl_id, mech_product_price_list.mrp_price, mech_product_price_list.cost_price,
        mech_product_price_list.sale_price, mech_product_price_list.reorder_quantity, mech_product_price_list.rack_no,');
        $this->db->from('mech_products');
        $this->db->join('mech_product_price_list', 'mech_product_price_list.product_id = mech_products.product_id and mech_product_price_list.workshop_id = 1', 'left');
        $this->db->join('mech_product_map_detail', 'mech_product_map_detail.product_id = mech_products.product_id','left');
        $this->db->where('mech_products.workshop_id', '1');
        if($this->input->post('brand_id')){
            $this->db->where('mech_product_map_detail.brand_id' , $this->input->post('brand_id'));
        }
        if($this->input->post('model_id')){
            $this->db->where('mech_product_map_detail.model_id' , $this->input->post('model_id'));
        }
        if($this->input->post('variant_id')){
            $this->db->where('mech_product_map_detail.variant_id' , $this->input->post('variant_id'));
        }
        if($this->input->post('fuel_type')){
            $this->db->where('mech_product_map_detail.fuel_type' , $this->input->post('fuel_type'));
        }
        if($this->input->post('product_category_id')){
            $this->db->where('mech_products.product_category_id', $this->input->post('product_category_id'));
        }
        if($this->input->post('product_brand_id')){
            $this->db->where('mech_products.product_brand_id', $this->input->post('product_brand_id'));
        }
        if(($this->input->post('product_category_id') < 1) || ($this->input->post('product_brand_id') < 1)){
            // $this->db->or_where('mech_products.apply_for_all_bmv' , 'Y');
            $this->db->where('mech_products.workshop_id', '1');
        }
        $this->db->where('mech_products.enable_for_sale', 'Y');

        $rowCount = $this->db->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        $this->db->select('mech_products.*, mech_product_map_detail.brand_id, mech_product_map_detail.model_id, mech_product_map_detail.variant_id, mech_product_map_detail.fuel_type,
        mech_product_price_list.mppl_id, mech_product_price_list.mrp_price, mech_product_price_list.cost_price,
        mech_product_price_list.sale_price, mech_product_price_list.reorder_quantity, mech_product_price_list.rack_no,');
        $this->db->from('mech_products');
        $this->db->join('mech_product_price_list', 'mech_product_price_list.product_id = mech_products.product_id and mech_product_price_list.workshop_id = 1', 'left');
        $this->db->join('mech_product_map_detail', 'mech_product_map_detail.product_id = mech_products.product_id','left');
        $this->db->where('mech_products.workshop_id', '1');
        if($this->input->post('brand_id')){
            $this->db->where('mech_product_map_detail.brand_id' , $this->input->post('brand_id'));
        }
        if($this->input->post('model_id')){
            $this->db->where('mech_product_map_detail.model_id' , $this->input->post('model_id'));
        }
        if($this->input->post('variant_id')){
            $this->db->where('mech_product_map_detail.variant_id' , $this->input->post('variant_id'));
        }
        if($this->input->post('fuel_type')){
            $this->db->where('mech_product_map_detail.fuel_type' , $this->input->post('fuel_type'));
        }
        if($this->input->post('product_category_id')){
            $this->db->where('mech_products.product_category_id', $this->input->post('product_category_id'));
        }
        if($this->input->post('product_brand_id')){
            $this->db->where('mech_products.product_brand_id', $this->input->post('product_brand_id'));
        }
        if(($this->input->post('product_category_id') < 1) || ($this->input->post('product_brand_id') < 1)){
            // $this->db->or_where('mech_products.apply_for_all_bmv' , 'Y');
            $this->db->where('mech_products.workshop_id', '1');
        }
        $this->db->where('mech_products.enable_for_sale', 'Y');

        $this->db->limit($limit,$start);
        $result =  $this->db->get()->result();
            foreach($result as $result_list_key => $res){
                $item_id = $res->product_id;
                $this->db->select('file_name_new');
                $this->db->from('admin_uploads');
                $this->db->where('entity_id', $item_id);
                $this->db->order_by('entity_id', 'ASC');
                $this->db->limit('1');
                $product_img = $this->db->get()->row()->file_name_new;
                $result[$result_list_key]->product_img = $product_img;
            }
            $response = array(
                 'result' => $result,
                 'createLinks' => $createLinks,
            );
            return $response;
        }

    public function  getProductDetails(){
        $this->load->model('user_cars/mdl_user_cars');
        $product_id = $this->input->post('product_id');
        $product_details = $this->mdl_mech_item_master->where('mech_products.product_id' , $product_id)->get()->row();
        // if($product_details->apply_for_all_bmv == 'N'){

        // }
        return $product_details;
    }

    public function getAdminProductDetails(){
        $product_id = $this->input->post('product_id');
        $this->db->select('mech_products.*, mp.sale_price, mp.cost_price');
        $this->db->from('mech_products');
        $this->db->join('mech_product_price_list as mp', 'mp.product_id = mech_products.product_id and mp.workshop_id = 1', 'left');
        return $this->db->where('mech_products.product_id' , $product_id)->get()->row();
    }

    public function getProductBrandDetails($product_id = NULl){
        $this->db->select('mech_product_map_detail.*, mech_car_brand_details.brand_name, mech_car_brand_models_details.model_name, mech_brand_model_variants.variant_name');
        $this->db->from('mech_product_map_detail');
        $this->db->join('mech_car_brand_details' , 'mech_car_brand_details.brand_id = mech_product_map_detail.brand_id' , 'left');
        $this->db->join('mech_car_brand_models_details' , 'mech_car_brand_models_details.model_id = mech_product_map_detail.model_id' , 'left');
        $this->db->join('mech_brand_model_variants' , 'mech_brand_model_variants.brand_model_variant_id = mech_product_map_detail.variant_id' , 'left');
        $this->db->where('product_id' , $product_id);
        return $this->db->get()->result();
    }
}
