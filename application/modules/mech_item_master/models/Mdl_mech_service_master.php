<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Mech_Service_Master extends Response_Model
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
        mech_service_item_dtls.estimated_hour,
        mech_service_item_dtls.default_estimated_cost,
        mech_service_item_dtls.fill_gst,
        mech_service_item_dtls.tax_id,
        mech_service_item_dtls.kilo_from,
        mech_service_item_dtls.kilo_to,
        mech_service_item_dtls.mon_from,
        mech_service_item_dtls.mon_to,
        mech_service_item_dtls.apply_for_all_bmv,
        mech_service_item_dtls.service_cost_setup,
        mech_service_item_dtls.service_category_id,
        mech_service_item_dtls.service_item_name,
        mech_service_item_dtls.sku,
        mech_service_item_dtls.tax_percentage,
        mech_service_item_dtls.complete_service_description,
        uad.category_name,
        msipl.msipl_id,
        msipl.estimated_cost', false);
    }
	
	public function default_join()
	{
        $work_shop_id =  $this->session->userdata("work_shop_id");
        $this->db->join('mechanic_service_category_list uad', 'uad.service_cat_id = mech_service_item_dtls.service_category_id and uad.status = 1', 'left');
        $this->db->join('mech_service_item_price_list msipl', 'msipl.msim_id = mech_service_item_dtls.msim_id AND msipl.workshop_id = '.$work_shop_id, 'left');
	}

    public function default_where()
    {
        $this->db->where_in('mech_service_item_dtls.workshop_id', array(1,$this->session->userdata('work_shop_id')));
        if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ){
            $this->db->where_in('mech_service_item_dtls.w_branch_id', array(1,$this->session->userdata('branch_id')));
        }else if($this->session->userdata('user_type') == 6){
            $array = $this->session->userdata('user_branch_id');
            array_push($array,1);
            $this->db->where_in('mech_service_item_dtls.w_branch_id', $array);
		}
        $this->db->where('mech_service_item_dtls.status', 'A');
    }

    public function validation_rules()
    {
        return array(
            'estimated_hour' => array(
                'field' => 'estimated_hour'
            ),
            'default_estimated_cost' => array(
                'field' => 'default_estimated_cost'
            ),
            'fill_gst' => array(
                'field' => 'fill_gst'
            ),
            'tax_id' => array(
                'field' => 'tax_id'
            ),
            'service_cost_setup' => array(
                'field' => 'service_cost_setup',
                // 'label' => trans('service_cost_setup'),
            ),
            'apply_for_all_bmv' => array(
                'field' => 'apply_for_all_bmv',
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
            'tax_percentage' => array(
                'field' => 'tax_percentage',
                'label' => trans('lable227'),
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
		$db_array['complete_service_description'] = strip_tags($db_array['complete_service_description']);
        return $db_array;
    }

	public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();
        if($id){
            $db_array['modified_by'] = $this->session->userdata('user_id');
        }else{
            $db_array['workshop_id'] = $this->session->userdata('work_shop_id');
            $db_array['w_branch_id'] = $this->session->userdata('branch_id');
            $db_array['created_by'] = $this->session->userdata('user_id');
            $db_array['modified_by'] = $this->session->userdata('user_id');
        }
        $id = parent::save($id, $db_array);
        return $id;
    }

    public function getServiceItemList(){

        $this->load->model('user_cars/mdl_user_cars');
        $user_car_list_id = $this->input->post('user_car_list_id');
        $model_type_id = $this->input->post('model_type_id');
        $customerCarDetail = $this->mdl_user_cars->where('car_list_id' , $user_car_list_id)->get()->row();
        $service_category_id  = $this->input->post('service_category_id');
        return $this->mdl_mech_service_master->where('mech_service_item_dtls.service_category_id' , $this->input->post('service_category_id'))->get()->result();
    }

    public function getServiceDetails(){

        $this->load->model('user_cars/mdl_user_cars');
        $user_car_list_id = $this->input->post('user_car_list_id');
        $model_type_id = $this->input->post('model_type_id');
        $customerCarDetail = $this->mdl_user_cars->where('car_list_id' , $user_car_list_id)->get()->row();
        $service_id = $this->input->post('service_id');
        $response = $this->mdl_mech_service_master->where('mech_service_item_dtls.msim_id' , $this->input->post('service_id'))->get()->row();
        // print_r($customerCarDetail);
        if($response->apply_for_all_bmv == 'S'){
            $this->db->select('*');
            $this->db->from('service_body_type_price_dtls');
            $this->db->where('msim_id' , $this->input->post('service_id'));
            $this->db->where('mvt_id' , $customerCarDetail->model_type);
            $this->db->where('workshop_id' , $this->session->userdata('work_shop_id'));
            $this->db->where('status' , 'A');
            $mech_service_map_detail = $this->db->get()->row();
            if(!empty($mech_service_map_detail)){
                $response->default_cost = $mech_service_map_detail->default_cost;
                $response->estimated_hour = $mech_service_map_detail->estimated_hour;
                $response->estimated_cost = $mech_service_map_detail->estimated_cost;
            }
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

    public function getServiceBrandDetails($service_id){
        $this->db->select('mech_service_map_detail.*, mech_car_brand_details.brand_name, mech_car_brand_models_details.model_name, mech_brand_model_variants.variant_name');
        $this->db->from('mech_service_map_detail');
        $this->db->join('mech_car_brand_details' , 'mech_car_brand_details.brand_id = mech_service_map_detail.brand_id' , 'left');
        $this->db->join('mech_car_brand_models_details' , 'mech_car_brand_models_details.model_id = mech_service_map_detail.model_id' , 'left');
        $this->db->join('mech_brand_model_variants' , 'mech_brand_model_variants.brand_model_variant_id = mech_service_map_detail.variant_id' , 'left');
        $this->db->where('msim_id' , $service_id);
        return $this->db->get()->result();
    }

}