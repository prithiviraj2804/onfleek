<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Clients extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_clients');
        $this->load->model('user_address/mdl_user_address');
        $this->load->model('user_cars/mdl_user_cars');
        $this->load->model('workshop_setup/mdl_workshop_setup');
        $this->load->model('upload/mdl_upload_status');
        $this->load->model('customer_category/mdl_customer_category');
        
    }

    public function index($page = 0)
    {
        $limit = 15;
        $query = $this->mdl_clients->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();
        $this->mdl_clients->limit($limit);
        $clients = $this->mdl_clients->get()->result();

        if($this->session->userdata('user_id') == 1 && $this->session->userdata('user_type') == 1){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE branch_status = 'A' ")->result();
        }else if($this->session->userdata('user_type') == 3){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND branch_status = 'A'")->result();
        }else if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id = ".$this->session->userdata('branch_id')." AND branch_status = 'A'")->result();
        }else if($this->session->userdata('user_type') == 6){
            $branch_list = $this->db->query("SELECT w_branch_id,display_board_name FROM workshop_branch_details WHERE workshop_id = ".$this->session->userdata('work_shop_id')." AND w_branch_id IN (".implode(',', $this->session->userdata('user_branch_id')).") AND branch_status = 'A'")->result();
        }else{
            $branch_list = array();
        }

		$this->layout->set(
            array(
                'clients' => $clients,
                'branch_list' => $branch_list,
                'createLinks' => $createLinks,
                'customercategory' => $this->mdl_customer_category->get()->result(),
            )
        );

        $this->layout->buffer('content', 'clients/index');
        $this->layout->render();
    }

    public function form($id = null,$tab = null)
    {
    	if ($this->input->post('btn_cancel')) {
            redirect('clients');
        }
        $work_shop_id = $this->session->userdata('work_shop_id');
		$branch_id = $this->session->userdata('branch_id');

        // Set validation rule based on is_update
        if ($this->input->post('is_update') == 0 && $this->input->post('client_name') != '') {
            $check = $this->db->get_where('mech_clients', array(
                'client_name' => $this->input->post('client_name'),
            ))->result();

            if (!empty($check)) {
                $this->session->set_flashdata('alert_error', trans('client_already_exists'));
                redirect('clients/form');
            }
        }
       
        if ($this->mdl_clients->run_validation()) {
            $id = $this->mdl_clients->save($id);
			redirect('clients/form/'.$id);
        }
		
		if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_clients->prep_form($id)) {
                show_404();
            }
			$this->mdl_clients->set_form_value('is_update', true);
        }
		
		if($id){
            $user_address_list = $this->mdl_user_address->where('user_id', $id)->where('entity_type', 'C')->get()->result();
			$cars_list = $this->mdl_user_cars->where('owner_id', $id)->where('entity_type', 'C')->get()->result();
            $breadcrumb = "lable49";
            if($this->mdl_clients->form_value('refered_by_type', true) == '2'){
                $refered_dtls = $this->db->get_where('mech_employee', array('mech_employee.employee_status' => 1, 'mech_employee.workshop_id' => $work_shop_id))->result();
            }elseif($this->mdl_clients->form_value('refered_by_type', true) == '1'){
                $refered_dtls = $this->mdl_clients->where('client_active','A')->get()->result();
            }else{
                $refered_dtls = array();
            }
		}else{
            $refered_dtls = array();
			$user_address_list = array();
			$cars_list = array();
			$breadcrumb = "lable48";
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

        $customer_id = $this->mdl_clients->where('client_active','A')->where('client_id',$id)->get()->row()->client_id;

        $invoice_group_number = $this->db->query("SELECT * FROM ip_invoice_groups where module_type = 'customer' AND workshop_id = '".$this->session->userdata('work_shop_id')."' ORDER BY invoice_group_id ASC LIMIT 1")->row();

        $this->layout->set(
            array(
                'referral_lists' => $this->mdl_workshop_setup->getReferralLists(),
                'active_tab' => $tab,
                'breadcrumb' => $breadcrumb, 
                'branch_list' => $branch_list,
                'id' => $id,
                'invoice_group_number' => $invoice_group_number,
                'cilent_invoice' => $cilent_invoice,
                'refered_dtls' => $refered_dtls,
                'states'=> $this->db->from('mech_state_list')->get()->result(),
                'reference_type' => $this->db->get_where('mech_reference_dtls', array('status' => 1))->result(),
			 	'area_list' => $this->db->get_where('mech_area_list', array('status' => 1))->result(),
	            'pincode_list' => $this->db->get_where('mech_area_pincode', array('status' => 'A'))->result(),
                'user_address_list' => $user_address_list,
                'employee_list' => $this->db->get_where('mech_reference_dtls', array('status' => 1))->result(),
                'customer_list' => $this->mdl_clients->where('client_active','A')->get()->result(),
                'cars_list' => $cars_list,
                'customercategory' => $this->mdl_customer_category->get()->result(),
                'recommended_services' => $this->mdl_user_cars->getRecommendedserviceforcustomers($customer_id),
                'recommended_products' => $this->mdl_user_cars->getRecommendedproductforcustomers($customer_id),
                'recent_service' => array(),
                
            )
        );

        $this->layout->buffer('content', 'clients/form');
        $this->layout->render();
    }

    public function delete()
    {
    	$id = $this->input->post('id');
		$this->db->where('client_id', $id);
		$this->db->update('mech_clients', array('client_active'=>'2'));
		$response = array(
            'success' => 1
        );
		echo json_encode($response);
    }

    public function importcsv() {

        $filepath = './uploads/csv/';

        if (!file_exists($filepath)) {
            mkdir($filepath, 0777, true);
        }

        $imagename = time()."_".$_FILES['client_file']['name']; 
        
        $tmp = $_FILES['client_file']['tmp_name'];      
        
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
                $total_row = count($csv_array);
                if($total_row > 1){
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
                        
                        if( $key > 0 && !empty(strip_tags($row[$index['S.No']])) ) {

                            // Client Details
                            $client_name = $row[$index['Name']]?strip_tags($row[$index['Name']]):NULL;
                            $total_rewards_point = $row[$index['Rewards Point']]?strip_tags($row[$index['Rewards Point']]):NULL;
                            $is_new_customer = $row[$index['New customer']]?strip_tags($row[$index['New customer']]):'Y';
                            $client_street = $row[$index['Street']]?strip_tags($row[$index['Street']]):NULL;
                            $client_area = $row[$index['Area']]?strip_tags($row[$index['Area']]):NULL;
                            $client_state = $row[$index['State']]?strip_tags($row[$index['State']]):NULL;
                            $client_pincode = $row[$index['Pincode']]?strip_tags($row[$index['Pincode']]):NULL;
                            $client_country = $row[$index['Country']]?strip_tags($row[$index['Country']]):NULL;
                            $client_contact_no = $row[$index['Mobile number']]?strip_tags($row[$index['Mobile number']]):NULL;
                            $client_email_id = $row[$index['Email id']]?strip_tags($row[$index['Email id']]):NULL;
                            $refered_by_type = $row[$index['Reference type']]?strip_tags($row[$index['Reference type']]):NULL;
                            $refered_by_id = $row[$index['Reference name']]?strip_tags($row[$index['Reference name']]):NULL;

                            // Address
                            $full_address = $row[$index['Full address']]?strip_tags($row[$index['Full address']]):NULL;
                            $zip_code = $row[$index['Zip code']]?strip_tags($row[$index['Zip code']]):NULL;
                            $address_area_id = $row[$index['Area']]?strip_tags($row[$index['Area']]):NULL;
                            $is_default = $row[$index['Default address']]?strip_tags($row[$index['Default address']]):NULL;
                            $long_latitude = $row[$index['Longitude latitude']]?strip_tags($row[$index['Longitude latitude']]):NULL;
                            $address_type = $row[$index['Type']]?strip_tags($row[$index['Type']]):NULL;

                            // Vehicle
                            $model_type = $row[$index['Model type']]?strip_tags($row[$index['Model type']]):NULL;
                            $car_reg_no = $row[$index['Car registration number']]?strip_tags($row[$index['Car registration number']]):NULL;
                            $car_brand_id = $row[$index['Brand Name']]?strip_tags($row[$index['Brand Name']]):NULL;
                            $car_brand_model_id = $row[$index['Model name']]?strip_tags($row[$index['Model name']]):NULL;
                            $car_model_year = $row[$index['Year']]?strip_tags($row[$index['Year']]):NULL;
                            $car_variant = $row[$index['Variant']]?strip_tags($row[$index['Variant']]):NULL;
                            $fuel_type = $row[$index['Fuel type']]?strip_tags($row[$index['Fuel type']]):NULL;
                            $vin = $row[$index['Vin']]?strip_tags($row[$index['Vin']]):NULL;
                            $total_mileage = $row[$index['Total mileage']]?strip_tags($row[$index['Total mileage']]):NULL;
                            $daily_mileage = $row[$index['Daily mileage']]?strip_tags($row[$index['Daily mileage']]):NULL;
                            $engine_oil_type = $row[$index['Engine oil type']]?strip_tags($row[$index['Engine oil type']]):NULL;
                            $steering_type = $row[$index['Steering type']]?strip_tags($row[$index['Steering type']]):NULL;
                            $air_conditioning = $row[$index['Air conditioning']]?strip_tags($row[$index['Air conditioning']]):NULL;
                            $car_drive_type = $row[$index['Drive type']]?strip_tags($row[$index['Drive type']]):NULL;
                            $transmission_type = $row[$index['Transmission type']]?strip_tags($row[$index['Transmission type']]):NULL;

                            if(empty(strip_tags($row[$index['Name']]))){
                                $data = array(
                                    'excel_id' => $key,
                                    'message' => 'Please provide customer Name',
                                    'upload_status' => 'Failed',
                                    'upload_type' => 4,
                                    'entity_name' => $client_name
                                );
                                $this->mdl_upload_status->insert_upload_status($data);
                                continue;
                            }

                            if(empty(strip_tags($row[$index['Mobile number']]))){
                                $data = array(
                                    'excel_id' => $key,
                                    'message' => 'Please provide customer mobile number',
                                    'upload_status' => 'Failed',
                                    'upload_type' => 4,
                                    'entity_name' => $client_name
                                );
                                $this->mdl_upload_status->insert_upload_status($data);
                                continue;
                            }

                            if(empty(strip_tags($row[$index['Model type']]))){
                                $data = array(
                                    'excel_id' => $key,
                                    'message' => 'Please provide model type',
                                    'upload_status' => 'Failed',
                                    'upload_type' => 4,
                                    'entity_name' => $client_name
                                );
                                $this->mdl_upload_status->insert_upload_status($data);
                                continue;
                            }

							$client_basic_data = array(
                                'workshop_id' => $this->session->userdata('work_shop_id'),
                                'w_branch_id' => $this->session->userdata('branch_id'),
                                'client_name' => $client_name,
                                'total_rewards_point' => $total_rewards_point,
                                'is_new_customer' => $is_new_customer,
                                'branch_id' => $this->session->userdata('branch_id'),
                                'client_street' => $client_street,
                                'client_area' => $client_area,
                                'client_state' => $client_state,
                                'client_pincode' => $client_pincode,
                                'client_country' => $client_country,
                                'client_contact_no' => $client_contact_no,
                                'client_email_id' => $client_email_id,
                                'refered_by_type' => $refered_by_type,
                                'refered_by_id' => $refered_by_id,
                                'client_date_created' => date('Y-m-d H:i:s'),
                                'client_created_by' => $this->session->userdata('user_id'),
                                'client_modified_by' => $this->session->userdata('user_id')
                            );
                            $client_id = $this->mdl_clients->upload_client_details($client_basic_data);

                            if($client_id){

                                $client_vehicle_array = array(
                                    'user_id' => $client_id,
                                    'entity_type' => 'C',
                                    'full_address' => $full_address,
                                    'zip_code' => $zip_code,
                                    'address_area_id' => $address_area_id,
                                    'is_default' => $is_default,
                                    'long_latitude' => $long_latitude,
                                    'address_type' => $address_type,
                                );
                                $address_id = $this->mdl_user_address->save($address_id,$client_vehicle_array);

                                $client_address_array = array(
                                    'owner_id' => $client_id,
                                    'entity_type' => 'C',
                                    'model_type' => $model_type,
                                    'car_reg_no' => $car_reg_no,
                                    'car_brand_id' => $car_brand_id,
                                    'car_brand_model_id' => $car_brand_model_id,
                                    'car_model_year' => $car_model_year,
                                    'car_variant' => $car_variant,
                                    'fuel_type' => $fuel_type,
                                    'vin' => $vin,
                                    'total_mileage' => $total_mileage,
                                    'daily_mileage' => $daily_mileage,
                                    'engine_oil_type' => $engine_oil_type,
                                    'steering_type' => $steering_type,
                                    'air_conditioning' => $air_conditioning,
                                    'car_drive_type' => $car_drive_type,
                                    'transmission_type' => $transmission_type,
                                );

                                $car_id = $this->mdl_user_cars->save($car_list_id = NULL, $client_address_array);

                                $data = array(
                                    'excel_id' => $key,
                                    'message' => 'Customer added successfully',
                                    'upload_status' => 'Success',
                                    'upload_type' => 4,
                                    'entity_name' => $client_name
                                );
                                $this->mdl_upload_status->insert_upload_status($data);
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
    
    public function download_csv() {        	
        	header('Content-Type: application/application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        	header('Content-Disposition: attachment; filename=customersample.xlsx');
        	header('Pragma: no-cache');
        	readfile(FCPATH."uploads/csv_bulk_upload_format/customersample.xlsx");
    }

    public function upload($type = NULL)
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
        $this->layout->buffer('content', 'clients/upload');
        $this->layout->render();
    }

}
