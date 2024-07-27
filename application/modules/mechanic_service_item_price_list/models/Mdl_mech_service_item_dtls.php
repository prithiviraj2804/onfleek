<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Mech_Service_Item_Dtls extends Response_Model
{
    public $table = 'mech_service_item_dtls';
    public $primary_key = 'mech_service_item_dtls.msim_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS 
        mech_service_item_dtls.msim_id,
        mech_service_item_dtls.workshop_id,
        mech_service_item_dtls.w_branch_id,
        mech_service_item_dtls.kilo_from,
        mech_service_item_dtls.kilo_to,
        mech_service_item_dtls.mon_from,
        mech_service_item_dtls.mon_to,
        mech_service_item_dtls.service_cost_setup,
        mech_service_item_dtls.service_category_id,
        mech_service_item_dtls.service_item_name,
        mech_service_item_dtls.sku,
        mech_service_item_dtls.complete_service_description,
        uad.category_name', false);
    }
	
	public function default_join()
	{
	    $this->db->join('mechanic_service_category_list uad', 'uad.service_cat_id = mech_service_item_dtls.service_category_id', 'left');
	}
	
    public function default_order_by()
    {
        $this->db->order_by('mech_service_item_dtls.msim_id', "desc");
    }

	public function default_where()
    {
        $this->db->where_in('mech_service_item_dtls.workshop_id',[1, $this->session->userdata('work_shop_id')]);
        $this->db->where('mech_service_item_dtls.status', 'A');
        $this->db->where('mech_service_item_dtls.service_cost_setup', $this->session->userdata('service_cost_setup'));

    }

    public function validation_rules()
    {
        return array(
            'service_cost_setup' => array(
                'field' => 'service_cost_setup',
                // 'label' => trans('service_cost_setup'),
            ),
            'kilo_from' => array(
                'field' => 'kilo_from',
                'label' => trans('lable175')
            ),
            'kilo_to' => array(
                'field' => 'kilo_to',
                'label' => trans('lable176')
            ),
            'mon_from' => array(
                'field' => 'mon_from',
                'label' => trans('lable175')
            ),
            'mon_to' => array(
                'field' => 'mon_to',
                'label' => trans('lable176')
            ),
            'service_category_id' => array(
                'field' => 'service_category_id',
                'label' => trans('lable239'),
                'rules' => 'required'
            ),
             'service_item_name' => array(
                'field' => 'service_item_name',
                'label' => trans('lable253'),
                'rules' => 'required'
            ),
            'sku' => array(
               'field' => 'sku',
               'label' => trans('lable211'),
           ),
            'complete_service_description' => array(
                'field' => 'complete_service_description',
                'label' => trans('lable177'),
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
		$db_array['workshop_id'] = $this->session->userdata('work_shop_id');
    	$db_array['w_branch_id'] = $this->session->userdata('branch_id');
    	$db_array['created_by'] = $this->session->userdata('user_id');
    	$db_array['modified_by'] = $this->session->userdata('user_id');
		$db_array['complete_service_description'] = strip_tags($db_array['complete_service_description']);
        return $db_array;
    }

	public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();
        $id = parent::save($id, $db_array);
        return $id;
    }

    public function getServiceItemList(){

        $this->load->model('user_cars/mdl_user_cars');
        $user_car_list_id = $this->input->post('user_car_list_id');
        $model_type_id = $this->input->post('model_type_id');
        $customerCarDetail = $this->mdl_user_cars->where('car_list_id' , $user_car_list_id)->get()->row();
        $service_category_id  = $this->input->post('service_category_id');

        $this->db->select('msid.msim_id, msid.service_cost_setup, msid.kilo_from, msid.kilo_to, msid.mon_from, msid.mon_to, msid.service_item_name, msid.sku');
        $this->db->where('msid.service_category_id',$service_category_id);
        $this->db->where('msid.status' , 'A');
        $this->db->from('mech_service_item_dtls as msid');
        return $this->db->get()->result();

    }

    public function getServiceDetails(){

        $this->load->model('user_cars/mdl_user_cars');
        $user_car_list_id = $this->input->post('user_car_list_id');
        $model_type_id = $this->input->post('model_type_id');
        $customerCarDetail = $this->mdl_user_cars->where('car_list_id' , $user_car_list_id)->get()->row();
        $service_id = $this->input->post('service_id');

        if($this->session->userdata('service_cost_setup') == 1){

            $this->db->select('msid.msim_id, msid.service_cost_setup, msid.kilo_from, msid.kilo_to, msid.mon_from, msid.mon_to, msid.service_item_name,  msid.sku, sbtpd.sct_id, sbtpd.mvt_id, sbtpd.vehicle_type_value, sbtpd.default_cost, sbtpd.estimated_hour, sbtpd.estimated_cost, mvt.vehicle_type_name');
            $this->db->join('service_body_type_price_dtls as sbtpd','sbtpd.msim_id = msid.msim_id','left');
            $this->db->join('mech_vehicle_type as mvt','mvt.mvt_id = sbtpd.mvt_id','left');
            $this->db->where('msid.status' , 'A');
            if($customerCarDetail->model_type){
                $this->db->where('sbtpd.mvt_id' , $customerCarDetail->model_type);
            }
            if($model_type_id){
                $this->db->where('sbtpd.mvt_id' , $model_type_id);
            }
            $this->db->where('sbtpd.msim_id' , $service_id);
            $this->db->from('mech_service_item_dtls as msid');
            $response = $this->db->get()->row();

        }else if($this->session->userdata('service_cost_setup') == 2){

            $this->db->select('msid.msim_id, msid.service_cost_setup, msid.kilo_from, msid.kilo_to, msid.mon_from, msid.mon_to, msid.service_item_name, msid.sku, sbtpd.pct_id,  sbtpd.brand_id, sbtpd.model_id, sbtpd.variant_id, sbtpd.fuel_type, sbtpd.estimated_hour, sbtpd.estimated_cost');
            $this->db->join('service_bmv_type_price_dtls as sbtpd','sbtpd.msim_id = msid.msim_id','left');
            if($customerCarDetail->car_brand_id){
                $this->db->where('sbtpd.brand_id' , $customerCarDetail->car_brand_id);
            }
            if($customerCarDetail->car_brand_model_id){
                $this->db->where('sbtpd.model_id' , $customerCarDetail->car_brand_model_id);
            }
            if($customerCarDetail->car_variant){
                $this->db->where('sbtpd.variant_id' , $customerCarDetail->car_variant);
            }
            if($customerCarDetail->fuel_type){
                $this->db->where('sbtpd.fuel_type' , $customerCarDetail->fuel_type);
            }
            $this->db->where('msid.status' , 'A');
            $this->db->where('sbtpd.status' , 'A');
            $this->db->where('msid.msim_id' , $service_id);
            $this->db->from('mech_service_item_dtls as msid');
            $response = $this->db->get()->row();

        }
        
        return $response;
    }

    public function getServiceItemListForEdit($user_car_list_id = NULL, $model_type_id = NULL,$service_category_id = NULL ){

        $this->load->model('user_cars/mdl_user_cars');
        $customerCarDetail = $this->mdl_user_cars->where('car_list_id' , $user_car_list_id)->get()->row();
        if($this->session->userdata('service_cost_setup') == 1){

            $this->db->select('msid.msim_id, msid.service_cost_setup, msid.kilo_from, msid.kilo_to, msid.mon_from, msid.mon_to, msid.service_item_name, msid.sku, sbtpd.sct_id as s_id, sbtpd.mvt_id, sbtpd.vehicle_type_value, sbtpd.default_cost, sbtpd.estimated_hour, sbtpd.estimated_cost, mvt.vehicle_type_name');
            $this->db->join('service_body_type_price_dtls as sbtpd','sbtpd.msim_id = msid.msim_id','left');
            $this->db->join('mech_vehicle_type as mvt','mvt.mvt_id = sbtpd.mvt_id','left');
            $this->db->where('msid.service_category_id',$service_category_id);
            if($customerCarDetail->model_type){
                $this->db->where('sbtpd.mvt_id' , $customerCarDetail->model_type);
            }
            if($model_type_id){
                $this->db->where('sbtpd.mvt_id' , $model_type_id);
            }
            $this->db->where('msid.status' , 'A');
            $this->db->where('sbtpd.status' , 'A');
            $this->db->from('mech_service_item_dtls as msid');
            $response = $this->db->get()->result();

            if(count($response) < 1){
                $this->db->select('msid.msim_id, msid.service_cost_setup, msid.kilo_from, msid.kilo_to, msid.mon_from, msid.mon_to, msid.service_item_name, msid.sku, sbtpd.sct_id as s_id, sbtpd.mvt_id, sbtpd.vehicle_type_value, sbtpd.default_cost, sbtpd.estimated_hour, sbtpd.estimated_cost, mvt.vehicle_type_name');
                $this->db->join('service_body_type_price_dtls as sbtpd','sbtpd.msim_id = msid.msim_id','left');
                $this->db->join('mech_vehicle_type as mvt','mvt.mvt_id = sbtpd.mvt_id','left');
                $this->db->where('msid.service_category_id',$service_category_id);
                if($model_type_id){
                    $this->db->where('sbtpd.mvt_id' , $model_type_id);
                }
                $this->db->where('msid.status' , 'A');
                $this->db->where('sbtpd.status' , 'A');
                $this->db->from('mech_service_item_dtls as msid');
                $response = $this->db->get()->result();
            }

        }else if($this->session->userdata('service_cost_setup') == 2){

            $this->db->select('msid.msim_id, msid.service_cost_setup, msid.kilo_from, msid.kilo_to, msid.mon_from, msid.mon_to, msid.service_item_name,  msid.sku, sbtpd.pct_id as s_id,  sbtpd.brand_id, sbtpd.model_id, sbtpd.variant_id, sbtpd.fuel_type, sbtpd.estimated_hour, sbtpd.estimated_cost');
            $this->db->join('service_bmv_type_price_dtls as sbtpd','sbtpd.msim_id = msid.msim_id','left');
            $this->db->where('msid.service_category_id',$service_category_id);
            if($customerCarDetail->car_brand_id){
                $this->db->where('sbtpd.brand_id' , $customerCarDetail->car_brand_id);
            }
            if($customerCarDetail->car_brand_model_id){
                $this->db->where('sbtpd.model_id' , $customerCarDetail->car_brand_model_id);
            }
            if($customerCarDetail->car_variant){
                $this->db->where('sbtpd.variant_id' , $customerCarDetail->car_variant);
            }
            if($customerCarDetail->fuel_type){
                $this->db->where('sbtpd.fuel_type' , $customerCarDetail->fuel_type);
            }
            $this->db->where('msid.status' , 'A');
            $this->db->where('sbtpd.status' , 'A');
            $this->db->from('mech_service_item_dtls as msid');
            $response = $this->db->get()->result();
            if(count($response) < 1){
                $this->db->select('msid.msim_id, msid.service_cost_setup, msid.kilo_from, msid.kilo_to, msid.mon_from, msid.mon_to, msid.service_item_name,  msid.sku, sbtpd.pct_id as s_id,  sbtpd.brand_id, sbtpd.model_id, sbtpd.variant_id, sbtpd.fuel_type, sbtpd.estimated_hour, sbtpd.estimated_cost');
                $this->db->join('service_bmv_type_price_dtls as sbtpd','sbtpd.msim_id = msid.msim_id','left');
                $this->db->where('msid.service_category_id',$service_category_id);
                $this->db->where('msid.status' , 'A');
                $this->db->where('sbtpd.status' , 'A');
                $this->db->from('mech_service_item_dtls as msid');
                $response = $this->db->get()->result();
            }

        }
        
        return $response;
    }

}