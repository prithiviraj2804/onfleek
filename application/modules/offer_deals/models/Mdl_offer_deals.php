<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Offer_deals extends Response_Model
{
    public $table = 'mech_service_offer_dtls';
    public $primary_key = 'mech_service_offer_dtls.offer_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    
     public function default_select()
     {
        
         $this->db->select('SQL_CALC_FOUND_ROWS mech_service_offer_dtls.offer_id,mech_service_offer_dtls.workshop_id,mech_service_offer_dtls.offer_title,
         mech_service_offer_dtls.service_category_id,mech_service_offer_dtls.service_package_id,mech_service_offer_dtls.short_desc,mech_service_offer_dtls.long_desc,
         mech_service_offer_dtls.term_cond,mech_service_offer_dtls.mobile_enable,mech_service_offer_dtls.start_date,mech_service_offer_dtls.end_date,
         mech_service_offer_dtls.offer_banner_image,mech_service_offer_dtls.offer_type,mech_service_offer_dtls.offer_rate,mech_service_offer_dtls.status,mechanic_service_category_list.category_name,mech_service_packages.package_name', false);
     }

     public function default_where()
     {  
         $this->db->where('mech_service_offer_dtls.workshop_id',($this->session->userdata('work_shop_id')));
         $this->db->where('mech_service_offer_dtls.status != "D"');
     }
     public function default_join()
    {
    $this->db->join('mechanic_service_category_list','mechanic_service_category_list.service_cat_id = mech_service_offer_dtls.service_category_id', 'left');
    $this->db->join('mech_service_packages', 'mech_service_packages.s_pack_id = mech_service_offer_dtls.service_package_id', 'left');
    }
 
     public function default_order_by()
     {
         $this->db->order_by('mech_service_offer_dtls.offer_title');
     }
 
     public function deal_validation_rules()
     {
         return array(
             'offer_title' => array(
                 'field' => 'offer_title',
                 'label' => trans('label962'),
                 'rules' => 'required'
             ),
             'service_category_id' => array(
                 'field' => 'service_category_id',
                 'label' => trans('lable239'),
                 'rules' => 'required'
             ),
             'service_package_id' => array(
                 'field' => 'service_package_id',
                 'label' => trans('lable546'),
                 'rules' => 'required'
             ),
             'short_desc' => array(
                 'field' => 'short_desc',
                 'label' => trans('lable248'),
                //  'rules' => 'required'
             ),
             'long_desc' => array(
                 'field' => 'long_desc',
                 'label' => trans('label963'),
                //  'rules' => 'required'
             ), 
            'term_cond' => array(
                'field' => 'term_cond',
                'label' => trans('label964'),
                // 'rules' => 'required'
            ),
            'mobile_enable' => array(
                'field' => 'mobile_enable',
                'label' => trans('label965'),
                 'rules' => 'required'
            ),
            'start_date' => array(
                'field' => 'start_date',
                'label' => trans('lable361'),
                'rules' => 'required'
            ),
            'end_date' => array(
                'field' => 'end_date',
                'label' => trans('lable630'),
                'rules' => 'required'
            ),
            'offer_banner_image' => array(
                'field' => 'offer_banner_image',
                'label' => trans('label966'),
                // 'rules' => 'required'
            ),
            'offer_type' => array(
                'field'  => 'offer_type',
                'label'  => trans('label967'),
                'rules'  => 'required'
            ),
            'offer_rate' => array(
                'field' => 'offer_rate',
                'label' =>  trans('lable337'),
                'rules' => 'required'
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
         $db_array['start_date'] = $this->input->post('start_date')?date_to_mysql($this->input->post('start_date')):NULL;
         $db_array['end_date'] = $this->input->post('end_date')?date_to_mysql($this->input->post('end_date')):NULL;
         $db_array['workshop_id'] = $this->session->userdata('work_shop_id');
         $db_array['created_by'] = $this->session->userdata('user_id');
         $db_array['modified_by'] = $this->session->userdata('user_id');
         $db_array['created_on'] = date('Y-m-d H:M:s');
         return $db_array;
     }
 
     public function save($id = null, $db_array = null)
     {
         
        $db_array = ($db_array) ? $db_array : $this->db_array();
        // $db_array['product_ids'] =  implode(',', $this->input->post('product_ids'));
         $id = parent::save($id, $db_array);
         return $id;
     }
     public function delete($id)
     {
         parent::delete($id);
         $this->load->helper('orphan');
         delete_orphans();
     }


}