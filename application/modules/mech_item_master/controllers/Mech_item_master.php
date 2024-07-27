<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mech_Item_Master extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
		$this->load->model('mdl_mech_item_master');
        $this->load->model('mdl_mech_product_price_list');
		$this->load->model('mdl_mech_service_master');
		$this->load->model('mdl_service_bmv_type_price_dtls');
        $this->load->model('mdl_service_body_type_price_dtls');
		$this->load->model('families/mdl_families');
		$this->load->model('mechanic_service_category/mdl_mechanic_service_category_list');
		$this->load->model('mech_car_brand_details/mdl_mech_car_brand_details');
		$this->load->model('product_brands/mdl_vendor_product_brand');
		$this->load->model('mech_car_brand_models_details/mdl_mech_car_brand_models_details');
		$this->load->model('units/mdl_units');
		$this->load->model('mech_tax/mdl_mech_tax');
		$this->load->model('mech_vehicle_type/mdl_mech_vehicle_type');
		$this->load->model('upload/mdl_upload_status');
        $this->load->model('user_cars/mdl_user_cars');

	}

    public function index($page = 0)
    {
		$limit = 15;
        $query = $this->mdl_mech_item_master->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
		$createLinks = $pagination->createLinks();
		$this->mdl_mech_item_master->limit($limit);
		$products = $this->mdl_mech_item_master->get()->result();
		
		if(count($products) > 0){
			foreach($products as $key => $pro){
				if($pro->apply_for_all_bmv != "Y"){
					$subproducts = $this->mdl_mech_item_master->getProductBrandDetails($pro->product_id);
					if(count($subproducts) > 0){
						$products[$key]->subproducts = $subproducts;
					}else{
						$products[$key]->subproducts = array();
					}
				}else{
					$products[$key]->subproducts = array();
				}
			}
		}

		$this->layout->set(
            array(
                'products' => $products,
                'car_brand_list' => $this->db->get_where('mech_car_brand_details', array('status' => 1))->result(),
                'families' => $this->mdl_families->get()->result(),
				'createLinks' => $createLinks,
            )
        );

		$this->layout->buffer('content', 'mech_item_master/product_list');
		$this->layout->render();
    }

	public function product_create($id = Null){
		if ($id) {
			if (!$this->mdl_mech_item_master->prep_form($id)) {
				show_404();
			}
			$this->mdl_mech_item_master->set_form_value('is_update', true);
			$uploadedImages = $this->mdl_mech_item_master->getUploadedImages($this->mdl_mech_item_master->form_value('url_key', true));
			$breadcrumb = "lable217";
			$subproducts = $this->mdl_mech_item_master->getProductBrandDetails($id);
			$product_details = $this->mdl_mech_item_master->where('mech_products.product_id' , $id)->get()->row();
		}else{
			$breadcrumb = "lable216";
			$uploadedImages = array();
			$subproducts = array();
			$product_details = '';
		}

		$this->layout->set(array(
			'breadcrumb' => $breadcrumb,
			'product_details' => $product_details,
			'subproducts' => $subproducts,
			'uploadedImages' => $uploadedImages,
			'families' => $this->mdl_families->get()->result(),
			'car_brand_list' => $this->mdl_mech_car_brand_details->get()->result(),
			'product_brand' => $this->mdl_vendor_product_brand->get()->result(),
            'car_model_list' => $this->mdl_mech_car_brand_models_details->get()->result(),
            'car_variant_list' => $this->db->get_where('mech_brand_model_variants', array('status' => 1))->result(),
			'units' => $this->mdl_units->get()->result(), 
			'gst_categories' => $this->mdl_mech_tax->where('tax_type','G')->where_in('workshop_id', array('1', $this->session->userdata('work_shop_id')))->get()->result(),
		));
		$this->layout->buffer('content', 'mech_item_master/product_create');
		$this->layout->render();
	}

	public function product_delete() {

		$id = $this->input->post('id');
		$this->db->where('product_id', $id);
		$this->db->update('mech_products', array('status'=>'D'));
		$response = array(
            'success' => 1
        );
		echo json_encode($response);

	}

	public function delete_sub_item(){
		$id = $this->input->post('id');
		$this->db->where('product_map_id', $id);
		$this->db->delete('mech_product_map_detail');
		$response = array(
            'success' => 1
		);
		echo json_encode($response);
	}

	public function product_upload($type = NULL)
    {
        $message = array();
        $upload_success = 0;
        $upload_failed = 0;

        if($type != 'new'){
            $message = $this->mdl_upload_status->get_upload_status(4);
            $upload_success = $this->mdl_upload_status->success_upload_count(4);
            $upload_failed = $this->mdl_upload_status->failed_upload_count(4);
        }

        $this->layout->set('message',$message);
        $this->layout->set('upload_success',$upload_success);
        $this->layout->set('upload_failed',$upload_failed);
        $this->layout->buffer('content', 'mech_item_master/product_upload');
        $this->layout->render();
    }

	public function import_product_csv() {

        $filepath = './uploads/csv/';

        if (!file_exists($filepath)) {
            mkdir($filepath, 0777, true);
        }

        $imagename = time()."_".$_FILES['product_file']['name']; 
        
        $tmp = $_FILES['product_file']['tmp_name'];      
        
        $data['error'] = '';    //initialize image upload error array to empty
        
        // If upload failed, display error
        if (move_uploaded_file($tmp, $filepath . $imagename)) {

            $this->mdl_upload_status->delete_upload_status(4);

            $file_path =  './uploads/csv/'.$imagename;

            $path_parts = pathinfo($file_path);

            if($path_parts['extension'] != 'xls' && $path_parts['extension'] != 'xlsx' && $path_parts['extension'] != 'csv'){
                $response = array(
                    'success' => 3,
                    'validation_errors' => 'Please upload only xls,xlsx,csv format');
                echo json_encode($response);
                exit();
            }
            
            if ($this->excel_import->get_array($file_path)){

                $csv_array = $this->excel_import->get_array($file_path);            
            
                // print_r($csv_array);
                // exit();

                $total_row = count($csv_array);

                // echo "i amhere one";

                if($total_row > 1){

                    // echo "i amhere two";

                    foreach ($csv_array as $key => $row) {
                        // echo $key;
                        // print_r($row);
                        if($key == 0){
                            // print_r($row);
                            $index = array();
                            foreach ($row as $i => $value) {
                                $index[$value] = $i;
                            }
                        } 
                        
                        if( $key > 0 ) {

                            // Product Details
                            $product_name = $row[$index['product_name']]?strip_tags($row[$index['product_name']]):NULL;
                            $parent_id = $row[$index['parent_id']]?strip_tags($row[$index['parent_id']]):0;
                            $is_parent = $row[$index['is_parent']]?strip_tags($row[$index['is_parent']]):NULL;
                            $product_category_id = $row[$index['product_category_id']]?strip_tags($row[$index['product_category_id']]):NULL;
                            $product_type = $row[$index['product_type']]?strip_tags($row[$index['product_type']]):NULL;
                            $unit_type = $row[$index['unit_type']]?strip_tags($row[$index['unit_type']]):NULL;
                            $product_brand_id = $row[$index['product_brand_id']]?strip_tags($row[$index['product_brand_id']]):NULL;
                            $vendor_part_no = $row[$index['vendor_part_no']]?strip_tags($row[$index['vendor_part_no']]):NULL;
                            $apply_for_all_bmv = $row[$index['apply_for_all_bmv']]?strip_tags($row[$index['apply_for_all_bmv']]):NULL;
                            $enable_for_sale = $row[$index['enable_for_sale']]?strip_tags($row[$index['enable_for_sale']]):NULL;
                            $fill_inventory = $row[$index['fill_inventory']]?strip_tags($row[$index['fill_inventory']]):NULL;
                            $reorder_quantity = $row[$index['reorder_quantity']]?strip_tags($row[$index['reorder_quantity']]):NULL;
                            $rack_no = $row[$index['rack_no']]?strip_tags($row[$index['rack_no']]):NULL;
                            $current_stock = $row[$index['current_stock']]?strip_tags($row[$index['current_stock']]):NULL;
                            $fill_gst = $row[$index['fill_gst']]?strip_tags($row[$index['fill_gst']]):NULL;
                            $tax_id = $row[$index['tax_id']]?strip_tags($row[$index['tax_id']]):NULL;
                            $hsn_code = $row[$index['hsn_code']]?strip_tags($row[$index['hsn_code']]):NULL;
                            $tax_percentage = $row[$index['tax_percentage']]?strip_tags($row[$index['tax_percentage']]):NULL;
                            $kilo_from = $row[$index['kilo_from']]?strip_tags($row[$index['kilo_from']]):NULL;
                            $kilo_to = $row[$index['kilo_to']]?strip_tags($row[$index['kilo_to']]):NULL;
                            $mon_from = $row[$index['mon_from']]?strip_tags($row[$index['mon_from']]):NULL;
                            $mon_to = $row[$index['mon_to']]?strip_tags($row[$index['mon_to']]):NULL;
                            $description = $row[$index['description']]?strip_tags($row[$index['description']]):NULL;
                            $part_number = $row[$index['part_number']]?strip_tags($row[$index['part_number']]):NULL;
                            $mrp_price = $row[$index['mrp_price']]?strip_tags($row[$index['mrp_price']]):0;
                            $cost_price = $row[$index['cost_price']]?strip_tags($row[$index['cost_price']]):0;
                            $sale_price = $row[$index['sale_price']]?strip_tags($row[$index['sale_price']]):0;
                            $brand_id = $row[$index['brand']]?strip_tags($row[$index['brand']]):NULL;
                            $model_id = $row[$index['model']]?strip_tags($row[$index['model']]):NULL;
                            $variant_id = $row[$index['variant']]?strip_tags($row[$index['variant']]):NULL;
                            $fuel_type = $row[$index['fuel_type']]?strip_tags($row[$index['fuel_type']]):NULL;
                            $year = $row[$index['year']]?strip_tags($row[$index['year']]):NULL;

                            if(empty(strip_tags($row[$index['product_name']]))){
                                $data = array(
                                    'excel_id' => $key,
                                    'message' => 'Please provide Product Name',
                                    'upload_status' => 'Failed',
                                    'upload_type' => 4,
                                    'entity_name' => $product_name
                                );
                                $this->mdl_upload_status->insert_upload_status($data);
                                continue;
                            }

                            $this->db->select('a.*, b.mrp_price, b.cost_price, b.sale_price');
                            $this->db->from('mech_products as a');
                            $this->db->join('mech_product_price_list as b','b.product_id = a.product_id','left');
                            $this->db->where('product_name' , $product_name);
                            $checkexist = $this->db->get()->result();

                            // print_r($checkexist);

                            if(count($checkexist) > 0){
                                foreach($checkexist as $checks){
                                    // echo "check sale_price===".floatval($checks->sale_price)."<br>";
                                    // echo "sale_price===".floatval($sale_price)."<br>";
                                    if(floatval($checks->sale_price) != floatval($sale_price)){
                                        // echo "i am hera same ";
                                        $product_basic_data = array(
                                            'url_key' => $this->mdl_mech_item_master->get_url_key(),
                                            'workshop_id' => $this->session->userdata('work_shop_id'),
                                            'w_branch_id' => $this->session->userdata('branch_id'),
                                            'product_name' => $product_name,
                                            'parent_id' => $parent_id,
                                            'is_parent' => $is_parent,
                                            'product_category_id' => $product_category_id,
                                            'product_type' => $product_type,
                                            'unit_type' => $unit_type,
                                            'product_brand_id' => $product_brand_id,
                                            'vendor_part_no' => $vendor_part_no,
                                            'apply_for_all_bmv' => $apply_for_all_bmv,
                                            'enable_for_sale' => $enable_for_sale,
                                            'fill_inventory' => $fill_inventory,
                                            'reorder_quantity' => $reorder_quantity,
                                            'rack_no' => $rack_no,
                                            'current_stock' => $current_stock,
                                            'fill_gst' => $fill_gst,
                                            'tax_id' => $tax_id,
                                            'hsn_code' => $hsn_code,
                                            'tax_percentage' => $tax_percentage,
                                            'kilo_from' => $kilo_from,
                                            'kilo_to' => $kilo_to,
                                            'mon_from' => $mon_from,
                                            'mon_to' => $mon_to,
                                            'description' => $description,
                                            'part_number' => $part_number,
                                            'created_on' => date('Y-m-d H:i:s'),
                                            'created_by' => $this->session->userdata('user_id'),
                                            'modified_by' => $this->session->userdata('user_id'),
                                            'status' => 'A',
                                        );
                                        $this->db->insert('mech_products' , $product_basic_data);
                                        $product_id = $this->db->insert_id();
            
                                        if(!empty($product_id)){

                                            $price_list = array(
                                                'workshop_id' => $this->session->userdata('work_shop_id'),
                                                'w_branch_id' => $this->session->userdata('branch_id'),
                                                'product_id' => $product_id,
                                                'mrp_price' => $mrp_price,
                                                'cost_price' => $cost_price,
                                                'sale_price' => $sale_price,
                                                'created_on' => date('Y-m-d H:i:s'),
                                                'created_by' => $this->session->userdata('user_id'),
                                                'modified_by' => $this->session->userdata('user_id'),
                                            );
                                            $this->mdl_mech_product_price_list->save(NULL, $price_list);
            
                                            if($apply_for_all_bmv == "N"){
                                                $product_map_array = array(
                                                    'workshop_id' => $this->session->userdata('work_shop_id'),
                                                    'w_branch_id' => $this->session->userdata('branch_id'),
                                                    'product_id' => $product_id,
                                                    'brand_id' => $brand_id,
                                                    'model_id' => $model_id,
                                                    'variant_id' => $variant,
                                                    'fuel_type' => $fuel_type,
                                                    'year' => $year,
                                                );
                                                $this->db->insert('mech_product_map_detail' , $product_map_array);
                                            }

                                            $data = array(
                                                'excel_id' => $key,
                                                'message' => 'Product added successfully',
                                                'upload_status' => 'Success',
                                                'upload_type' => 4,
                                                'entity_name' => $product_name
                                            );
                                            $this->mdl_upload_status->insert_upload_status($data);
                                        }
                                    }else {
                                        if($checks->apply_for_all_bmv == 'N'){
                                            $this->db->select('c.*');
                                            $this->db->from('mech_product_map_detail as c');
                                            $this->db->where('c.workshop_id', $this->session->userdata('work_shop_id'));
                                            $this->db->where('c.product_id', $checks->product_id);
                                            $mapped_products = $this->db->get()->result();
                                            if(count($mapped_products) > 0){
                                                foreach($mapped_products as $map){
                                                    if($map->brand_id != $brand_id){
                                                        $product_map_array = array(
                                                            'workshop_id' => $this->session->userdata('work_shop_id'),
                                                            'w_branch_id' => $this->session->userdata('branch_id'),
                                                            'product_id' => $checks->product_id,
                                                            'brand_id' => $brand_id,
                                                            'model_id' => $model_id,
                                                            'variant_id' => $variant,
                                                            'fuel_type' => $fuel_type,
                                                            'year' => $year,
                                                        );
                                                        $this->db->insert('mech_product_map_detail' , $product_map_array);
                                                    }else {
                                                        if($map->model_id != $model_id){
                                                            $product_map_array = array(
                                                                'workshop_id' => $this->session->userdata('work_shop_id'),
                                                                'w_branch_id' => $this->session->userdata('branch_id'),
                                                                'product_id' => $checks->product_id,
                                                                'brand_id' => $brand_id,
                                                                'model_id' => $model_id,
                                                                'variant_id' => $variant,
                                                                'fuel_type' => $fuel_type,
                                                                'year' => $year,
                                                            );
                                                            $this->db->insert('mech_product_map_detail' , $product_map_array);
                                                        }else {
                                                            if($map->variant_id != $variant_id){
                                                                $product_map_array = array(
                                                                    'workshop_id' => $this->session->userdata('work_shop_id'),
                                                                    'w_branch_id' => $this->session->userdata('branch_id'),
                                                                    'product_id' => $checks->product_id,
                                                                    'brand_id' => $brand_id,
                                                                    'model_id' => $model_id,
                                                                    'variant_id' => $variant,
                                                                    'fuel_type' => $fuel_type,
                                                                    'year' => $year,
                                                                );
                                                                $this->db->insert('mech_product_map_detail' , $product_map_array);
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }else{
                                $product_basic_data = array(
                                    'url_key' => $this->mdl_mech_item_master->get_url_key(),
                                    'workshop_id' => $this->session->userdata('work_shop_id'),
                                    'w_branch_id' => $this->session->userdata('branch_id'),
                                    'product_name' => $product_name,
                                    'parent_id' => $parent_id,
                                    'is_parent' => $is_parent,
                                    'product_category_id' => $product_category_id,
                                    'product_type' => $product_type,
                                    'unit_type' => $unit_type,
                                    'product_brand_id' => $product_brand_id,
                                    'vendor_part_no' => $vendor_part_no,
                                    'apply_for_all_bmv' => $apply_for_all_bmv,
                                    'enable_for_sale' => $enable_for_sale,
                                    'fill_inventory' => $fill_inventory,
                                    'reorder_quantity' => $reorder_quantity,
                                    'rack_no' => $rack_no,
                                    'current_stock' => $current_stock,
                                    'fill_gst' => $fill_gst,
                                    'tax_id' => $tax_id,
                                    'hsn_code' => $hsn_code,
                                    'tax_percentage' => $tax_percentage,
                                    'kilo_from' => $kilo_from,
                                    'kilo_to' => $kilo_to,
                                    'mon_from' => $mon_from,
                                    'mon_to' => $mon_to,
                                    'description' => $description,
                                    'part_number' => $part_number,
                                    'created_on' => date('Y-m-d H:i:s'),
                                    'created_by' => $this->session->userdata('user_id'),
                                    'modified_by' => $this->session->userdata('user_id'),
                                    'status' => 'A',
                                );
                                $this->db->insert('mech_products' , $product_basic_data);
                                $product_id = $this->db->insert_id();
    
                                if($product_id){
    
                                    if($product_id && $this->session->userdata('work_shop_id') != 1){
                                        $price_list = array(
                                            'workshop_id' => $this->session->userdata('work_shop_id'),
                                            'w_branch_id' => $this->session->userdata('branch_id'),
                                            'product_id' => $product_id,
                                            'mrp_price' => $mrp_price,
                                            'cost_price' => $cost_price,
                                            'sale_price' => $sale_price,
                                            'created_on' => date('Y-m-d H:i:s'),
                                            'created_by' => $this->session->userdata('user_id'),
                                            'modified_by' => $this->session->userdata('user_id'),
                                        );
                                        $this->mdl_mech_product_price_list->save(NULL, $price_list);
                                    }
    
                                    if($apply_for_all_bmv == "N"){
                                        $product_map_array = array(
                                            'workshop_id' => $this->session->userdata('work_shop_id'),
                                            'w_branch_id' => $this->session->userdata('branch_id'),
                                            'product_id' => $product_id,
                                            'brand_id' => $brand_id,
                                            'model_id' => $model_id,
                                            'variant_id' => $variant,
                                            'fuel_type' => $fuel_type,
                                            'year' => $year,
                                        );
                                        $this->db->insert('mech_product_map_detail' , $product_map_array);
                                    }
    
                                    $data = array(
                                        'excel_id' => $key,
                                        'message' => 'Product added successfully',
                                        'upload_status' => 'Success',
                                        'upload_type' => 4,
                                        'entity_name' => $product_name
                                    );
                                    $this->mdl_upload_status->insert_upload_status($data);
                                }
                            }
                        }
                    }
                    header_remove('Set-Cookie');
                    $response = array(
                        'success' => 1,
                        'validation_errors' => ''
                    );
                    echo json_encode($response);
                }else{
                    $response = array(
                        'success' => 0,
                        'validation_errors' => 'Error occured in csv import'
                    );
                    echo json_encode($response);
                }
            }else{
                $response = array(
                    'success' => 0,
                    'validation_errors' => 'Error occured in csv import'
                );
                echo json_encode($response);
            } 
        }else{
            $response = array(
                'success' => 0,
                'validation_errors' => 'Error occured in file upload'
            );
            echo json_encode($response);
        }
    }

	public function download_product_csv() {        	
		header('Content-Type: application/application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename=product.xlsx');
		header('Pragma: no-cache');
		readfile(FCPATH."uploads/csv_bulk_upload_format/product.xlsx");
    }

	public function delete_sub_service(){
		$id = $this->input->post('id');
		$this->db->where('service_map_id', $id);
		$this->db->delete('mech_service_map_detail');
		$response = array(
            'success' => 1
		);
		echo json_encode($response);
	}
	

	public function view_inventory($product_id = NULL){
		$inventory_list = $this->db->select('inventory_id,workshop_id,w_branch_id,product_id,entity_id,stock_type,quantity,price,stock_date,description,action_type')->where('product_id',$product_id)->where('workshop_id' , $this->session->userdata('work_shop_id'))->get('mech_inventory')->result();
		$product = $this->mdl_mech_item_master->where('mech_products.product_id',$product_id)->get()->row();

		$this->layout->set(array(
			'inventory_list' => $inventory_list,
			'product' => $product
		));
		
		$this->layout->buffer('content', 'mech_item_master/product_stock_history');
		$this->layout->render();
	}	

	public function service_index($page = 0)
    {
        $limit = 15;
        $query = $this->mdl_mech_service_master->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();
        $this->mdl_mech_service_master->limit($limit);
        $mech_service_item_dtls = $this->mdl_mech_service_master->get()->result();

		if(count($mech_service_item_dtls) > 0){
			foreach($mech_service_item_dtls as $key => $pro){
				if($pro->apply_for_all_bmv == "N"){
					$subproducts = $this->mdl_mech_service_master->getServiceBrandDetails($pro->msim_id);
					if(count($subproducts) > 0){
						$mech_service_item_dtls[$key]->subproducts = $subproducts;
					}else{
						$mech_service_item_dtls[$key]->subproducts = array();
					}
					$mech_service_item_dtls[$key]->service_body_type_details = array();
				}else if($pro->apply_for_all_bmv == "S"){
					$subproducts = $this->mdl_service_body_type_price_dtls->where('msim_id' , $pro->msim_id)->get()->result();
					if(count($subproducts) > 0){
						$mech_service_item_dtls[$key]->service_body_type_details = $subproducts;
					}else{
						$mech_service_item_dtls[$key]->service_body_type_details = array();
					}
					$mech_service_item_dtls[$key]->subproducts = array();
				}else{
					$mech_service_item_dtls[$key]->subproducts = array();
					$mech_service_item_dtls[$key]->service_body_type_details = array();
				}
			}
		}

        $this->layout->set(
            array(
                'mech_service_item_dtls' => $mech_service_item_dtls,
                'service_category_lists' => $this->mdl_mechanic_service_category_list->get()->result(),
                'car_brand_list' => $this->db->get_where('mech_car_brand_details', array('status' => 1))->result(),
                'createLinks' => $createLinks
            )
        );

		$this->layout->buffer('content', 'mech_item_master/service_list');
		$this->layout->render();
    }

	public function service_create($id = NULL){
		if($id){
			$service = $this->mdl_mech_service_master->where('mech_service_item_dtls.msim_id' , $id)->get()->row();
            if (!$this->mdl_mech_service_master->prep_form($id)) {
                show_404();
            }
			$this->mdl_mech_service_master->set_form_value('is_update', true);

			$this->mdl_service_body_type_price_dtls->where('msim_id' , $id);
			$service_body_type_details = $this->mdl_service_body_type_price_dtls->get()->result();
			if(count($service_body_type_details) <= 0){
				$service_body_type_details = array();
			}

			$subproducts = $this->mdl_mech_service_master->getServiceBrandDetails($id);
        }else{
			$subproducts = array();
			$service = "";
        }
		$this->mdl_mech_vehicle_type->where('type_checked',1);
        $mechVehicleType = $this->mdl_mech_vehicle_type->get()->result();
        $this->layout->set(array(
			'car_brand_list' => $this->mdl_mech_car_brand_details->get()->result(),
            'car_model_list' => $this->mdl_mech_car_brand_models_details->get()->result(),
            'car_variant_list' => $this->db->get_where('mech_brand_model_variants', array('status' => 1))->result(),
            'service_category_lists' => $this->mdl_mechanic_service_category_list->get()->result(),
			'gst_categories' => $this->mdl_mech_tax->where('tax_type','S')->where_in('workshop_id', array('1', $this->session->userdata('work_shop_id')))->get()->result(),
            'service' => $service,
			'subproducts' => $subproducts,
			'mechVehicleType' => $mechVehicleType,
			'service_body_type_details' => $service_body_type_details,
		));
		
		$this->layout->buffer('content', 'mech_item_master/service_create');
		$this->layout->render();
	}

	public function service_delete(){

		$id = $this->input->post('id');
		$this->db->where('msim_id', $id);
		$this->db->update('mech_service_item_dtls', array('status'=>'D'));
		$response = array(
            'success' => 1
        );
		echo json_encode($response);

	}
}