<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Service_Package extends Response_Model
{

    public $table = 'mech_service_packages';
    public $primary_key = 'mech_service_packages.s_pack_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
		$this->db->select('SQL_CALC_FOUND_ROWS mech_service_packages.s_pack_id,mech_service_packages.url_key,mech_service_packages.package_name,mech_service_packages.category_id,mech_service_packages.short_desc,
        mech_service_packages.description,mech_service_packages.service_item_id,mech_service_packages.features,mech_service_packages.icon_image,mech_service_packages.banner_image,mech_service_packages.important_note,
        mech_service_packages.mobile_enable,mech_service_packages.is_offer_enable_mobile_banner,mech_service_packages.is_popular_service,mech_service_packages.subscription,mech_service_packages.status,mech_service_packages.subscription_account_checkbox,mechanic_service_category_list.category_name', false);
    }

    public function default_join()
    {
    $this->db->join('mechanic_service_category_list','mechanic_service_category_list.service_cat_id = mech_service_packages.category_id', 'left');
    }
    
    public function default_where()
    {
        $this->db->where('mech_service_packages.workshop_id' , $this->session->userdata('work_shop_id'));
        $this->db->where('mech_service_packages.status != "D"');
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_service_packages.s_pack_id', "desc");
    }

    public function validation_rules_service_package()
    {
        return array(
            'package_name' => array(
                'field' => 'package_name',
                'label' => trans('lable540'),
                'rules' => 'required'
			),
            'category_id' => array(
                'field' => 'category_id',
                'label' => trans('lable208'),
                'rules' => 'required'
            ),
            'mobile_enable' => array(
                'field' => 'mobile_enable',
                'label' => trans('label946'),
                // 'rules' => 'required'
            ),
            'is_offer_enable_mobile_banner' => array(
                'field' => 'is_offer_enable_mobile_banner',
                'label' => trans('lable1213'),
                // 'rules' => 'required'
            ),
            'is_popular_service' => array(
                'field' => 'is_popular_service',
                'label' => trans('label961'),
                'rules' => 'required'
            ),
            'subscription' => array(
                'field' => 'subscription',
                'label' => trans('lable1240'),
                // 'rules' => 'required'
            ),
            'status' => array(
                'field' => 'status',
                'label' => trans('lable19'),
                'rules' => 'required'
			),
            '_mm_csrf' => array(
                'field' => '_mm_csrf'
            )
            
        );
    }

    public function validation_rules_service_feature()
    {
        return array(
            's_pack_id' => array(
                'field' => 's_pack_id',
                'rules' => 'required'
			),
            'description' => array(
                'field' => 'description',
                'label' => trans('lable177'),
                // 'rules' => 'required'
			),
            'short_desc' => array(
                'field' => 'short_desc',
                'label' => trans('lable248'),
                // 'rules' => 'required'
            ),

            'important_note' => array(
                'field' => 'status',
                'label' => trans('label947'),
                // 'rules' => 'important_note'
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
        $db_array['description'] = strip_tags($db_array['description']);
        $db_array['short_desc'] = strip_tags($db_array['short_desc']);
        $db_array['features'] = strip_tags($db_array['features']);
        $db_array['important_note'] = strip_tags($db_array['important_note']);
        $db_array['workshop_id'] = $this->session->userdata('work_shop_id');
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

    public function get_url_key()
    {
        $this->load->helper('string');
        return random_string('alnum', 15);
    }

    public function getServicepackagedetails(){
        $this->load->model('user_cars/mdl_user_cars');
        $user_car_list_id = $this->input->post('user_car_list_id');
        $customerCarDetail = $this->mdl_user_cars->where('car_list_id' , $user_car_list_id)->get()->row();
        $s_pack_id = $this->input->post('s_pack_id');

        $this->db->select('*');
        $this->db->from('mech_service_packages');
        $this->db->join('mech_service_package_price_dtls', 'mech_service_package_price_dtls.s_pack_id = mech_service_packages.s_pack_id','left');
        $this->db->where('mech_service_package_price_dtls.mvt_id' , $customerCarDetail->model_type );
        $this->db->where('mech_service_packages.s_pack_id ' , $s_pack_id );
        $response = $this->db->get()->result();
        return $response;
    }

    public function delete($id)
    {
        parent::delete($id);
        $this->load->helper('orphan');
        delete_orphans();
    }

    public function get_existing_service_ids($service_id = null)
     {
        $service_ids = array();

        if($service_id){
            $this->db->select('sp.service_item_id');
            $this->db->from('mech_service_packages sp');
            $this->db->where('sp.s_pack_id', $service_id);
            $service_item_ids = $this->db->get()->row()->service_item_id;
        }else{
            $service_item_ids = '';
        }
        return $service_item_ids;
     }

     public function service_item_list($s_pack_id = null)
     {
        $this->db->select('service_item_id');
        $this->db->from('mech_service_packages');
        $this->db->where('s_pack_id', $s_pack_id);
        $service_item_ids = $this->db->get()->row();
        
        $service_item_id = explode(',', $service_item_ids->service_item_id);

        $service_list = array();

        for($i = 0; $i < count($service_item_id); $i++){
            $this->db->select('msim_id,service_item_name');
            $this->db->from('mech_service_item_dtls');
            $this->db->where('msim_id', $service_item_id[$i]);
            $service_details = $this->db->get()->row();
            if(!empty($service_details)){
                array_push($service_list,$service_details);
            }
        }
         return $service_list;
     }

}