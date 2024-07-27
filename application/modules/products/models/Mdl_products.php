<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mdl_Products extends Response_Model
{
    public $table = 'mech_products';
    public $primary_key = 'mech_products.product_id';
    public $date_created_field = 'created_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mech_products.product_id,mech_products.workshop_id,
        mech_products.url_key,mech_products.parent_id,mech_products.is_parent,
        mech_products.product_name,mech_products.hsn_code,mech_products.sku_code,
        mech_products.product_category_id,mech_products.product_type,mech_products.unit_type,
        mech_products.reorder_quantity,mech_products.apply_for_all_bmv,mech_products.brand_id,
        mech_products.model_id,mech_products.variant_id,mech_products.kilo_from,
        mech_products.kilo_to,mech_products.mon_from,mech_products.mon_to,
        mech_products.fuel_type,mech_products.rack_no,mech_products.default_cost_price,
        mech_products.default_sale_price,mech_products.diff_amount,mech_products.tax_percentage,mech_products.description,
        ip_families.family_id,ip_families.family_name,
        ip_units.unit_id,ip_units.unit_name,ip_units.unit_name_plrl,
        mech_product_stock_details.psd_id,mech_product_stock_details.balance_stock,
        cb.brand_name,cm.model_name,cv.variant_name', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_products.product_name' , 'asc');
    }

    public function default_where()
    {

        $this->db->where('mech_products.workshop_id', $this->session->userdata('work_shop_id'));
		if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $this->db->where_in('mech_products.w_branch_id', array(1,$this->session->userdata('branch_id')));
        }else if($this->session->userdata('user_type') == 6){
            $array = $this->session->userdata('user_branch_id');
            array_push($array,1);
            $this->db->where_in('mech_products.w_branch_id', $array);
        }
        $this->db->where('mech_products.product_type', 'P');
        $this->db->where('mech_products.status', 'A');
        $this->db->where('ip_families.status', 'A');
    }

    public function default_join()
    {
        $this->db->join('ip_families', 'ip_families.family_id = mech_products.product_category_id', 'left');
        $this->db->join('ip_units', 'ip_units.unit_id = mech_products.unit_type', 'left');
        $this->db->join('mech_product_stock_details', 'mech_product_stock_details.product_id = mech_products.product_id', 'left');
        $this->db->join('mech_car_brand_details cb', 'cb.brand_id = mech_products.brand_id', 'left');
        $this->db->join('mech_car_brand_models_details cm', 'cm.model_id = mech_products.model_id', 'left');
		$this->db->join('mech_brand_model_variants cv', 'cv.brand_model_variant_id = mech_products.variant_id', 'left');
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
            'parent_id'=> array(
                'field' => 'parent_id',
            ),
            'is_parent'=> array(
                'field' => 'is_parent',
            ),
            'product_name' => array(
                'field' => 'product_name',
                'label' => trans('lable207'),
                'rules' => 'required|trim',
            ),
            'hsn_code' => array(
                'field' => 'hsn_code',
                'label' => trans('lable218'),
                'rules' => '',
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
            'apply_for_all_bmv' => array(
                'field' => 'apply_for_all_bmv',
                'label' => trans('lable228'),
                'rules' => '',
            ),
            'reorder_quantity' => array(
                'field' => 'reorder_quantity',
                'label' => trans('lable222'),
                'rules' => '',
            ),
            'cost_price' => array(
                'field' => 'cost_price',
                'label' => trans('lable224'),
                'rules' => '',
            ),
            'sale_price' => array(
                'field' => 'sale_price',
                'label' => trans('lable225'),
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
            'rack_no' => array(
                'field' => 'rack_no',
                'label' => trans('lable223'),
                'rules' => '',
            ),
            'tax_percentage' => array(
                'field' => 'tax_percentage',
                'label' => trans('lable227'),
                'rules' => '',
            ),
            'url_key' => array(
                'field' => 'url_key',
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
        if($db_array['apply_for_all_bmv'] == 'N' || $db_array['apply_for_all_bmv'] == ''){
            $db_array['is_parent'] = 'P';
        }
        $db_array['created_by'] = $this->session->userdata('user_id');
        $db_array['modified_by'] = $this->session->userdata('user_id');
        $db_array['workshop_id'] = $this->session->userdata('work_shop_id');
        $db_array['w_branch_id'] = $this->session->userdata('branch_id');
        $db_array['status'] = 'A';

        return $db_array;
    }

    public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();
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
        $this->mdl_products->where('mech_products.is_parent != "P"');
        $this->mdl_products->where('mech_products.product_category_id', $this->input->post('product_category_id'));
        $productList = $this->mdl_products->get()->result();

        if(count($productList) < 1){
            $this->mdl_products->where('mech_products.product_category_id', $this->input->post('product_category_id'));
            $productList= $this->mdl_products->get()->result();
        }

        return $productList;
    }

    public function  getProductDetails(){

        $this->load->model('user_cars/mdl_user_cars');
        $product_id = $this->input->post('product_id');

        $customer_car_id = $this->input->post('customer_car_id');

        $customerCarDetail = $this->mdl_user_cars->where('car_list_id' , $customer_car_id)->get()->row();

        $this->db->select('apply_for_all_bmv');
        $this->db->from('mech_products');
        $this->db->where('product_id' , $product_id);
        $apply_for_all_bmv = $this->db->get()->row()->apply_for_all_bmv;

        if($apply_for_all_bmv == "N" || $apply_for_all_bmv == ""){
            $this->db->select('mp.product_id, mp.url_key, mp.product_name, mp.hsn_code, mp.sku_code, mp.product_category_id, mp.product_type, mp.unit_type, mp.reorder_quantity, mp.apply_for_all_bmv,
            mp.kilo_from, mp.kilo_to, mp.mon_from, mp.mon_to, mp.rack_no, mp.cost_price, mp.sale_price, mp.tax_percentage');
            if($customerCarDetail->car_brand_id){
                $this->db->where('mp.brand_id' , $customerCarDetail->car_brand_id);
            }
            if($customerCarDetail->car_brand_model_id){
                $this->db->where('mp.model_id' , $customerCarDetail->car_brand_model_id);
            }
            if($customerCarDetail->car_variant){
                $this->db->where('mp.variant_id' , $customerCarDetail->car_variant);
            }
            if($customerCarDetail->fuel_type){
                $this->db->where('mp.fuel_type' , $customerCarDetail->fuel_type);
            }
            $this->db->where('mp.product_id' , $product_id);
            $this->db->where('mp.status' , 'A');
            $this->db->from('mech_products as mp');
            $response = $this->db->get()->row();

            if(empty($response)){
                $this->db->select('mp.product_id, mp.url_key, mp.product_name, mp.hsn_code, mp.sku_code, mp.product_category_id, mp.product_type, mp.unit_type, mp.reorder_quantity, mp.apply_for_all_bmv,
                mp.kilo_from, mp.kilo_to, mp.mon_from, mp.mon_to, mp.rack_no');
                $this->db->where('mp.status' , 'A');
                $this->db->where('mp.product_id' , $product_id);
                $this->db->from('mech_products as mp');
                $response = $this->db->get()->row();
            }

        }else{

            $this->db->select('mp.product_id, mp.url_key, mp.product_name, mp.hsn_code, mp.sku_code, mp.product_category_id, mp.product_type, mp.unit_type, mp.reorder_quantity, mp.apply_for_all_bmv,
            mp.kilo_from, mp.kilo_to, mp.mon_from, mp.mon_to, mp.rack_no, mp.cost_price, mp.sale_price, mp.tax_percentage');
            $this->db->where('mp.status' , 'A');
            $this->db->where('mp.product_id' , $product_id);
            $this->db->from('mech_products as mp');
            $response = $this->db->get()->row();
        }

        return $response;
    }
}
