<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Mdl_User_Cars
 */
class Mdl_User_Cars extends Response_Model
{
    public $table = 'mech_owner_car_list';
    public $primary_key = 'mech_owner_car_list.car_list_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mech_owner_car_list.car_list_id,mech_owner_car_list.workshop_id,
        mech_owner_car_list.w_branch_id,mech_owner_car_list.owner_id,mech_owner_car_list.entity_type,
        mech_owner_car_list.model_type,mech_owner_car_list.car_reg_no,mech_owner_car_list.car_brand_id,
        mech_owner_car_list.car_brand_model_id,mech_owner_car_list.car_model_year,mech_owner_car_list.car_variant,
        mech_owner_car_list.fuel_type,mech_owner_car_list.engine_number,mech_owner_car_list.vin,mech_owner_car_list.total_mileage,mech_owner_car_list.daily_mileage,
        mech_owner_car_list.engine_oil_type,mech_owner_car_list.steering_type,mech_owner_car_list.air_conditioning,
        mech_owner_car_list.car_drive_type,mech_owner_car_list.transmission_type,cb.brand_name,cm.model_name,cv.variant_name', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_owner_car_list.car_list_id', "desc");
    }
	public function default_where()
    {
        $this->db->where('mech_owner_car_list.status', 1);
    }

    public function default_join()
    {
        $this->db->join('mech_car_brand_details cb', 'cb.brand_id=mech_owner_car_list.car_brand_id', 'left');
        $this->db->join('mech_car_brand_models_details cm', 'cm.model_id=mech_owner_car_list.car_brand_model_id', 'left');
		$this->db->join('mech_brand_model_variants cv', 'cv.brand_model_variant_id=mech_owner_car_list.car_variant', 'left');
    }

    public function get_latest()
    {
        $this->db->order_by('mech_owner_car_list.car_list_id', 'DESC');
        return $this;
    }
    
    public function validation_rules()   
    {
        return array(
            'car_reg_no' => array(
                'field' => 'car_reg_no',
                'label' => trans('lable72'),
                'rules' => 'required'
            ),
            'owner_id' => array(
                'field' => 'owner_id',
                // 'label' => trans('owner_id'),
                'rules' => 'required'
            ),
            'car_brand_id' => array(
                'field' => 'car_brand_id',
                'label' => trans('lable73'),
                'rules' => 'required'
            ),
            'entity_type' => array(
                'field' => 'entity_type',
                // 'label' => trans('entity_type'),
                //'rules' => 'required'
            ),
            'car_brand_model_id' => array(
                'field' => 'car_brand_model_id',
                'label' => trans('lable74'),
                'rules' => 'required'
            ),
            'car_model_year' => array(
                'field' => 'car_model_year',
                'label' => trans('lable76')
            ),
            'car_variant' => array(
                'field' => 'car_variant',
                'label' => trans('lable75')
            ),
            'fuel_type' => array(
                'field' => 'fuel_type',
                'label' => trans('lable77'),
                //'rules' => 'required'
            ),
            'model_type' => array(
                'field' => 'model_type',
                'label' => trans('lable78'),
            ),
            'total_mileage' => array(
                'field' => 'total_mileage'
            ),
            'daily_mileage' => array(
                'field' => 'daily_mileage'
            ),
            '_mm_csrf' => array(
                'field' => '_mm_csrf'
            )
        );
    }
    
    public function lead_validation_rules()
    {
        $db_array =  array(
            'car_reg_no' => array(
                'field' => 'car_reg_no',
                'label' => trans('lable72'),
                'rules' => 'required'
            ),
            'owner_id' => array(
                'field' => 'owner_id',
                // 'label' => trans('owner_id'),
                'rules' => 'required'
            ),
            'car_brand_id' => array(
                'field' => 'car_brand_id',
                'label' => trans('lable74'),
            ),
            'entity_type' => array(
                'field' => 'entity_type',
                // 'label' => trans('entity_type'),
            ),
            'car_brand_model_id' => array(
                'field' => 'car_brand_model_id',
                'label' => trans('lable74'),
            ),
            'car_model_year' => array(
                'field' => 'car_model_year',
                'label' => trans('lable76')
            ),
            'car_variant' => array(
                'field' => 'car_variant',
                'label' => trans('lable75')
            ),
            'fuel_type' => array(
                'field' => 'fuel_type',
                'label' => trans('lable77'),
            ),
            'model_type' => array(
                'field' => 'model_type',
                'label' => trans('lable78'),
            ),
            'total_mileage' => array(
                'field' => 'total_mileage'
            ),
            'daily_mileage' => array(
                'field' => 'daily_mileage'
            ),
            '_mm_csrf' => array(
                'field' => '_mm_csrf'
            )
        );
    }

	public function db_array()
    {
        $db_array = parent::db_array();
		unset($db_array['_mm_csrf']);
        if (!isset($db_array['status'])) {
            $db_array['status'] = 1;
        }
		unset($db_array['car_id']);
		//$db_array['owner_id'] = $this->session->userdata('user_id');
		$db_array['workshop_id'] = $this->session->userdata('work_shop_id');
    	$db_array['w_branch_id'] = $this->session->userdata('branch_id');
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

    public function getApiData($owner_id, $car_id=NULL){
        $this->db->select('cl.car_list_id,cl.car_brand_id,cl.car_brand_model_id,cl.car_variant,cl.car_model_year,cb.brand_name,cm.model_name,cv.variant_name,cl.car_reg_no,cl.total_mileage,cl.daily_mileage,cl.fuel_type,cl.transmission_type,cl.model_type');
        $this->db->from('mech_owner_car_list cl'); 
        $this->db->join('mech_car_brand_details cb', 'cb.brand_id=cl.car_brand_id', 'left');
        $this->db->join('mech_car_brand_models_details cm', 'cm.model_id=cl.car_brand_model_id', 'left');
        $this->db->join('mech_brand_model_variants cv', 'cv.brand_model_variant_id=cl.car_variant', 'left');
        $this->db->where('cl.owner_id',$owner_id);
        $this->db->where('cl.status',1);
        if($car_id){
            $this->db->where('cl.car_list_id',$car_id);
        }  
        $query = $this->db->get(); 
        if($query->num_rows() > 0 )
        {
            $result = $query->result_array();
        }
        else
        {
            $result = array();
        }
        
        $response = array(
            'message' => 'success',
            'user_car_details' => $result
        );

        return $response;
    }

    public function removeApiData($id){
        $this->db->where('car_list_id',$id);
        $this->db->update('mech_owner_car_list',array("status"=>2));
            
    }

    public function saveApiData($data,$id = null){
        if($id){
            $this->db->where('car_list_id',$id);
            $this->db->update('mech_owner_car_list',$data);
            $user_car_id = $id;
        } else {
            $this->db->insert('mech_owner_car_list', $data);
            $user_car_id = $this->db->insert_id();    
        }
        //$user_car_id = $this->db->insert_id();
            
        $this->db->select('cl.car_list_id,cl.car_brand_id,cl.car_brand_model_id,cl.car_variant,cl.car_model_year,cb.brand_name,cm.model_name,cv.variant_name,cl.car_reg_no,cl.total_mileage,cl.daily_mileage,cl.fuel_type,cl.transmission_type,cl.model_type');
        $this->db->from('mech_owner_car_list cl'); 
        $this->db->join('mech_car_brand_details cb', 'cb.brand_id=cl.car_brand_id', 'left');
        $this->db->join('mech_car_brand_models_details cm', 'cm.model_id=cl.car_brand_model_id', 'left');
        $this->db->join('mech_brand_model_variants cv', 'cv.brand_model_variant_id=cl.car_variant', 'left');
        $this->db->where('cl.car_list_id',$user_car_id);    
        $this->db->where('cl.status',1);     
        $query = $this->db->get(); 
        if($query->num_rows() != 0)
        {
            $result = $query->result_array();
        }
        else
        {
            $result = array();
        }
        
        $response = array(
            'message' => 'success',
            'user_car_details' => $result
        );

        return $response;
    }

	public function get_user_total_cars()
	{
		//if($this->session->userdata('user_type') == 3){
			//$this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
		//}elseif($this->session->userdata('user_type') == 4){
			$this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
			$this->db->where('w_branch_id', $this->session->userdata('branch_id'));
		//}
		$this->db->where('status', 1);
    	$cars_data = $this->db->get('mech_owner_car_list');
		return count($cars_data->result());
	}

	public function checkUserCarExist($car_no)
	{
		if ($car_no != '') {
		 	$car_id = $this->input->post('car_id');
		 	$owner_id = $this->input->post('owner_id');
		if($car_id){
			 $check = $this->db->select('car_reg_no')->from('mech_owner_car_list')->where('owner_id',$owner_id,FALSE )->where('car_list_id!=',$car_id,FALSE )->where('status',1)->get()->result();
		}else{
			 $check = $this->db->select('car_reg_no')->from('mech_owner_car_list')->where('owner_id',$owner_id,FALSE )->where('status',1)->get()->result();
		}
	       
			$car_reg_no =  str_replace(' ', '', strtolower($car_no));
			$existing_car_no = array();
			foreach($check as $exists){
				$already_exists =  str_replace(' ', '', strtolower($exists->car_reg_no));
				array_push($existing_car_no, $already_exists);
			}
			
			if(in_array($car_reg_no, $existing_car_no)){
				$this->form_validation->set_message('checkUserCarExist', 'Car Registration no. already exist.');
				return false;
			}else{
				return true;
			}
			
	    }
	}
	
	public function get_customer_cars_list($cus_id = null)
	{
	    if ($cus_id) {
	        $customer_id = $cus_id;
	    } else {
	        $customer_id = $this->input->post('customer_id');
	    }
	    
	    $this->db->select('*');
	    $this->db->from('mech_owner_car_list');
	    $this->db->join('mech_car_brand_details cb', 'cb.brand_id=mech_owner_car_list.car_brand_id', 'left');
	    $this->db->join('mech_car_brand_models_details cm', 'cm.model_id=mech_owner_car_list.car_brand_model_id', 'left');
	    $this->db->join('mech_brand_model_variants cv', 'cv.brand_model_variant_id=mech_owner_car_list.car_variant', 'left');
	    $this->db->where('owner_id', $customer_id);
	    $this->db->where('mech_owner_car_list.status', 1);
	    $result = $this->db->get()->result();
	    
	    if (empty($cus_id) || $cus_id = '') {
	        echo json_encode($result);
	    } else {
	        return $result;
	    }
    }
    
    public function getVehicleDetails($car_list_id){

        $work_shop_id = $this->session->userdata('work_shop_id');
        $branch_id = $this->session->userdata('branch_id');
		if($this->session->userdata('user_type') == 3){
            $this->mdl_user_cars->get()->where('mech_owner_car_list.workshop_id='.$work_shop_id.'');
		}elseif($this->session->userdata('user_type') == 4){
            $this->mdl_user_cars->get()->where('mech_owner_car_list.workshop_id='.$work_shop_id.' AND mech_owner_car_list.w_branch_id='.$branch_id.'');
        }
        $this->mdl_user_cars->where('mech_owner_car_list.status = 1');
        $this->mdl_user_cars->where('mech_owner_car_list.car_list_id',$car_list_id);
        $user_cars = $this->mdl_user_cars->get()->row();
        return ($user_cars->brand_name?$user_cars->brand_name:" ").' '.($user_cars->model_name?"- ".$user_cars->model_name:"").' '.($user_cars->variant_name?"- ".$user_cars->variant_name:"").' '.($user_cars->car_model_year?"- ".$user_cars->car_model_year:"").' '.($user_cars->car_reg_no?"- ".$user_cars->car_reg_no:"");
    }

    public function getCarBrandId($model_id){
        $this->db->select('brand_id');
        $this->db->where('model_id',$model_id);
        $this->db->from('mech_car_brand_models_details');
        $brand = $this->db->get()->row();
        return $brand->brand_id;
    }

    public function getRecommendedService($recommendedId){
        $this->db->select('service.recommended_id,service.invoice_id,service.recommended_service,service.days,service.service_status,items.msim_id,items.service_item_name');
        $this->db->join('mech_service_item_dtls as items','items.msim_id=service.recommended_service','left');
        $this->db->where('service.recommended_id',$recommendedId);
        $this->db->where('service.category_type','S');
        $this->db->where('service.status','A');
        if($this->session->userdata('plan_type') != 3){
            $this->db->from('recommended_services as service');
        }else{
            $this->db->from('recommended_spare_services as service');
        }
        $recommended_service_history = $this->db->get()->row();
        return $recommended_service_history;
    }

    public function getRecommendedProduct($recommendedId){

        $this->db->select('service.recommended_id,service.invoice_id,service.recommended_service,service.days,service.service_status,items.product_id,items.product_name');
        $this->db->join('mech_products as items','items.product_id=service.recommended_service','left');
        $this->db->where('service.recommended_id',$recommendedId);
        $this->db->where('service.category_type','P');
        $this->db->where('service.status','A');
        if($this->session->userdata('plan_type') != 3){
            $this->db->from('recommended_services as service');
        }else{
            $this->db->from('recommended_spare_services as service');
        }
        $recommended_product_history = $this->db->get()->row();
        return $recommended_product_history;
    }

    public function getRecommendedServicehistory($invoice_id){

        $this->db->select('service.recommended_id,service.category_type,service.invoice_id,service.recommended_service,service.days,service.service_status,items.msim_id,items.service_item_name');
        $this->db->join('mech_service_item_dtls as items','items.msim_id=service.recommended_service','left');
        $this->db->where('service.invoice_id',$invoice_id);
        $this->db->where('service.category_type','S');
        $this->db->where('service.status','A');
        if($this->session->userdata('plan_type') != 3){
            $this->db->from('recommended_services as service');
        }else{
            $this->db->from('recommended_spare_services as service');
        }
        $recommended_service_history = $this->db->get()->result();
        return $recommended_service_history;
        
    }

    public function getRecommendedProducthistory($invoice_id){

        $this->db->select('service.recommended_id,service.category_type,service.invoice_id,service.recommended_service,service.days,service.service_status,items.product_id,items.product_name');
        $this->db->join('mech_products as items','items.product_id=service.recommended_service','left');
        $this->db->where('service.invoice_id',$invoice_id);
        $this->db->where('service.category_type','P');
        $this->db->where('service.status','A');
        if($this->session->userdata('plan_type') != 3){
            $this->db->from('recommended_services as service');
        }else{
            $this->db->from('recommended_spare_services as service');
        }
        $recommended_product_history = $this->db->get()->result();
        return $recommended_product_history;
    
    }

    public function saveRecommendedServiceHistory($recommendedServiceHistory = null){
        unset($recommendedServiceHistory['_mm_csrf']);
        $expiry_date = NULL;
        $days = $recommendedProductHistory['days'];
        if(!empty($recommendedProductHistory['days']) && $recommendedProductHistory['days'] != NULL){
            $expiry_date = Date('Y-m-d', strtotime("+$days days"));
        }
        $recommendServiceHis = array(
            'workshop_id' => $this->session->userdata('work_shop_id'),
            'w_branch_id' => $this->session->userdata('branch_id'),
            'car_list_id' => $recommendedServiceHistory['car_list_id'],
            'customer_id' => $recommendedServiceHistory['customer_id'],
            'recommended_service' => $recommendedServiceHistory['recommended_service'],
            'days' => $recommendedServiceHistory['days'],
            'expiry_date' => $expiry_date,
            'category_type' => $recommendedServiceHistory['category_type'],
            'service_status' => $recommendedServiceHistory['service_status'],
            'invoice_id' => $recommendedServiceHistory['invoice_id'],
    	    'created_by' => $this->session->userdata('user_id'),
            'modified_by' => $this->session->userdata('user_id'),
            'created_on' => date('Y-m-d H:i:s'),
        );
        if($recommendedServiceHistory['recommended_id']){
            unset($recommendedServiceHistory['created_by']);
            $this->db->where('recommended_id' , $recommendedServiceHistory['recommended_id']);
            if($this->session->userdata('plan_type') != 3){
                $this->db->update('recommended_services', $recommendServiceHis);
            }else{
                $this->db->update('recommended_spare_services', $recommendServiceHis);
            }
          
            $recommended_id = $this->db->affected_rows();
        }else{
            if($this->session->userdata('plan_type') != 3){
                $this->db->insert('recommended_services', $recommendServiceHis);
            }else{
                $this->db->insert('recommended_spare_services', $recommendServiceHis);
            }
            $recommended_id = $this->db->insert_id();
        }
        return $recommended_id;

    }

    public function saveRecommendedProductHistory($recommendedProductHistory = null){
        unset($recommendedProductHistory['_mm_csrf']);
        $expiry_date = NULL;
        $days = $recommendedProductHistory['days'];
        if(!empty($recommendedProductHistory['days']) && $recommendedProductHistory['days'] != NULL){
            $expiry_date = Date('Y-m-d', strtotime("+$days days"));
        }

        $recommendProductHis = array(
            'workshop_id' => $this->session->userdata('work_shop_id'),
            'w_branch_id' => $this->session->userdata('branch_id'),
            'car_list_id' => $recommendedProductHistory['car_list_id'],
            'customer_id' => $recommendedProductHistory['customer_id'],
            'recommended_service' => $recommendedProductHistory['recommended_service'],
            'days' => $recommendedProductHistory['days'],
            'expiry_date' => $expiry_date,
            'category_type' => $recommendedProductHistory['category_type'],
            'service_status' => $recommendedProductHistory['service_status'],
            'invoice_id' => $recommendedProductHistory['invoice_id'],
    	    'created_by' => $this->session->userdata('user_id'),
            'modified_by' => $this->session->userdata('user_id'),
            'created_on' => date('Y-m-d H:i:s'),
        );
        if($recommendedProductHistory['recommended_id']){
            unset($recommendedProductHistory['created_by']);
            $this->db->where('recommended_id' , $recommendedProductHistory['recommended_id']);
            if($this->session->userdata('plan_type') != 3){
                $this->db->update('recommended_services', $recommendProductHis);
            }else{
                $this->db->update('recommended_spare_services', $recommendProductHis);
            }
           
            $recommended_id = $this->db->affected_rows();
        }else{
            if($this->session->userdata('plan_type') != 3){
                $this->db->insert('recommended_services', $recommendProductHis);
            }else{
                $this->db->insert('recommended_spare_services', $recommendProductHis);
            }
           
            $recommended_id = $this->db->insert_id();
        }
        return $recommended_id;
    }

    public function deleteRecommendedProduct($recommended_id){
        $this->db->where('recommended_id', $recommended_id);
        if($this->session->userdata('plan_type') != 3){
            $this->db->update('recommended_services', array('status'=>'D'));
        }else{
            $this->db->update('recommended_spare_services', array('status'=>'D'));
        }
       
        $response = $this->db->affected_rows();
		return $response;
    }

    public function deleteRecommendedService($recommended_id){
		$this->db->where('recommended_id', $recommended_id);
        $this->db->update('recommended_services', array('status'=>'D'));
        if($this->session->userdata('plan_type') != 3){
            $this->db->update('recommended_services', array('status'=>'D'));
        }else{
            $this->db->update('recommended_spare_services', array('status'=>'D'));
        }
        $response = $this->db->affected_rows();
		return $response;
    }

    public function getRecommendedProductsForVehicle($car_list_id = NULL){
        $this->db->select('service.recommended_id,service.category_type,service.invoice_id,service.recommended_service,service.days,service.service_status,items.product_id,items.product_name');
        $this->db->join('mech_products as items','items.product_id=service.recommended_service','left');
        $this->db->where('service.car_list_id',$car_list_id);
        $this->db->where('service.category_type','P');
        $this->db->where('service.status','A');
        if($this->session->userdata('plan_type') != 3){
            $this->db->from('recommended_services as service');
        }else{
            $this->db->from('recommended_spare_services as service');
        }
        $this->db->order_by('recommended_id','desc');
        $recommended_product_history = $this->db->get()->result();
        return $recommended_product_history;
    }

    public function getRecommendedServicesForVehicle($car_list_id = NULL){
        $this->db->select('service.recommended_id,service.category_type,service.invoice_id,service.recommended_service,service.days,service.service_status,items.msim_id,items.service_item_name');
        $this->db->join('mech_service_item_dtls as items','items.msim_id=service.recommended_service','left');
        $this->db->where('service.car_list_id',$car_list_id);
        $this->db->where('service.category_type','S');
        $this->db->where('service.status','A');
        if($this->session->userdata('plan_type') != 3){
            $this->db->from('recommended_services as service');
        }else{
            $this->db->from('recommended_spare_services as service');
        }
        $this->db->order_by('recommended_id','desc');
        $recommended_service_history = $this->db->get()->result();
        return $recommended_service_history;
    }

    public function getRecommendedproductforcustomers($cust_id = NULL){
        $this->db->select('service.recommended_id,service.category_type,service.expiry_date,service.invoice_id,service.recommended_service,service.days,service.service_status,items.msim_id,items.service_item_name');
        $this->db->join('mech_service_item_dtls as items','items.msim_id=service.recommended_service','left');
        $this->db->where('service.customer_id',$cust_id);
        $this->db->where('service.category_type','P');
        $this->db->where('service.expiry_date >', date('Y-m-d'));
        $this->db->where('service.status','A');
        $this->db->from('recommended_services as service');
        $this->db->order_by('recommended_id','ASC');
        $recommended_products = $this->db->get()->result();
        return $recommended_products;
    }

    public function getRecommendedserviceforcustomers($cust_id = NULL){
        $this->db->select('service.recommended_id,service.category_type,service.expiry_date,service.invoice_id,service.recommended_service,service.days,service.service_status,items.msim_id,items.service_item_name');
        $this->db->join('mech_service_item_dtls as items','items.msim_id=service.recommended_service','left');
        $this->db->where('service.customer_id',$cust_id);
        $this->db->where('service.category_type','S');
        $this->db->where('service.expiry_date >', date('Y-m-d'));
        $this->db->where('service.status','A');
        $this->db->from('recommended_services as service');
        $this->db->order_by('recommended_id','ASC');
        $recommended_services = $this->db->get()->result();
        return $recommended_services;
    }


}