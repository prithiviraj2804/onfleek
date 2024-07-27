<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Customer_Retention extends Response_Model
{
    public $table = 'mech_invoice_item';
    public $primary_key = 'mech_invoice_item.item_id';
    public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mech_invoice_item.expiry_date,mech_invoice_item.user_id,count(mech_invoice_item.service_item) as service_item,mi.invoice_no,mi.invoice_date,mi.customer_id,mi.customer_car_id,mi.user_address_id,mi.invoice_id,mi.current_odometer_reading,mi.fuel_level,mc.client_name,mc.client_contact_no,mc.client_email_id,mocl.car_list_id,mocl.car_reg_no,mocl.fuel_type,cb.brand_name,cm.model_name,cv.variant_name', false);
    }

    public function default_join()
    {
        $this->db->join('mech_invoice mi','mi.invoice_id = mech_invoice_item.invoice_id','left');
        $this->db->join('mech_clients mc','mc.client_id = mech_invoice_item.user_id','left');
        $this->db->join('mech_user_address mua','mua.user_address_id = mi.user_address_id');
        $this->db->join('mech_owner_car_list mocl','mocl.car_list_id = mi.customer_car_id','left');
        $this->db->join('mech_car_brand_details cb', 'cb.brand_id = mocl.car_brand_id', 'left');
        $this->db->join('mech_car_brand_models_details cm', 'cm.model_id = mocl.car_brand_model_id', 'left');
        $this->db->join('mech_brand_model_variants cv', 'cv.brand_model_variant_id = mocl.car_variant', 'left');
    }

    public function default_where()
    {
        $this->db->where("mi.status = 'A' and mi.invoice_status != 'D'");
        $this->db->where('mech_invoice_item.workshop_id' , $this->session->userdata('work_shop_id'));
        if($this->input->post('expiry_from_date') && $this->input->post('expiry_to_date')){
            $this->db->where("mech_invoice_item.expiry_date BETWEEN '".date_to_mysql($this->input->post('expiry_from_date'))."' and '".date_to_mysql($this->input->post('expiry_to_date'))."'");
        }
        if($this->input->post('expiry_kilometer')){
            $this->db->where("mech_invoice_item.expiry_kilometer = '".trim($this->input->post('expiry_kilometer'))."'");
        }
        if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
            $this->db->where("mech_invoice_item.w_branch_id" , $this->session->userdata('branch_id'));
        }else if($this->session->userdata('user_type') == 6){
            $this->db->where_in("mech_invoice_item.w_branch_id" , $this->session->userdata('user_branch_id'));
        }
    }

    public function default_group_by(){
        $this->db->group_by('mi.customer_car_id');
	}

	public function getCustomerRetentionlist(){

        $this->db->select('mi.invoice_id,mi.branch_id,mi.shift,mi.invoice_no,mi.jobsheet_no,mi.customer_id,mi.customer_car_id,mi.user_address_id,mi.invoice_date,mi.current_odometer_reading,mi.fuel_level,cli.client_name,cli.client_gstin,cli.client_contact_no,cli.client_email_id,mua.full_address,mua.zip_code,mua.address_area_id,mocl.car_reg_no,mocl.fuel_type,mcbd.brand_name,mcbm.model_name,mbmv.variant_name');
        $this->db->join('mech_clients as cli','cli.client_id = mi.customer_id','left');
        $this->db->join('mech_user_address as mua','mua.user_address_id = mi.user_address_id','left');
        $this->db->join('mech_owner_car_list as mocl','mocl.car_list_id = mi.customer_car_id','left');
        $this->db->join('mech_car_brand_details as mcbd','mcbd.brand_id = mocl.car_brand_id','left');
        $this->db->join('mech_car_brand_models_details as mcbm','mcbm.model_id = mocl.car_brand_model_id','left');
        $this->db->join('mech_brand_model_variants as mbmv','mbmv.brand_model_variant_id = mocl.car_variant','left');
        $this->db->from('mech_invoice as mi');
        $this->db->where('mi.customer_car_id',$this->input->post('customer_car_id'));
        $invoices = $this->db->get()->result();

        if(count($invoices) > 0){
            foreach($invoices as $key => $invoiceList){
                $this->db->select('mii.item_id,mii.invoice_id,mii.user_id,
                mii.expiry_date,mii.is_from,mii.service_item,
                mii.item_total_amount,mii.igst_amount,mii.igst_pct,
                mii.item_amount,mii.item_discount,mii.item_qty,
                mii.mech_item_price,mii.user_item_price,mii.item_hsn,
                mpro.product_name,msci.service_item_name');
                $this->db->join('mech_products as mpro','mpro.product_id=mii.service_item','left');
                $this->db->join('mech_service_item_dtls as msci','msci.msim_id = mii.service_item','left');
                $this->db->where('mii.invoice_id', $invoiceList->invoice_id );
                if($this->input->post('from_date') != '' && $this->input->post('to_date') != ''){
                    $this->db->where('mii.expiry_date >=',$this->input->post('from_date'));
                    $this->db->where('mii.expiry_date <=',$this->input->post('to_date'));
                }
                if($this->input->post('expiry_kilometer')){
                    $this->db->where('mii.expiry_kilometer',$this->input->post('expiry_kilometer'));
                }
                $this->db->from('mech_invoice_item as mii');
                $service_product = $this->db->get()->result();

                $product_array = array();
                $service_array = array();
                if(count($service_product)>0){
                    foreach($service_product as $serviceproduct){
                        if($serviceproduct->is_from == 'invoice_service'){
                            array_push($service_array,$serviceproduct);
                        }else if($serviceproduct->is_from == 'invoice_product'){
                            array_push($product_array,$serviceproduct);
                        }
                    }
                    if(count($service_array) > 0){
                        $invoices[$key]->services = $service_array;
                    }else{
                        $invoices[$key]->services = array();
                    }
                    if(count($product_array) > 0){
                        $invoices[$key]->products = $product_array;
                    }else{
                        $invoices[$key]->products = array();
                    }

                }else{
                    $invoices[$key]->services = $service_array;
                    $invoices[$key]->products = $product_array;
                }
                $this->load->model('user_cars/mdl_user_cars');
                $recommended_services = $this->mdl_user_cars->getRecommendedServicehistory($invoiceList->invoice_id);
                if(!empty($recommended_services)){
                    $invoices[$key]->recommended_services = $recommended_services;
                }else{
                    $invoices[$key]->recommended_services = array();
                }
                $recommended_products = $this->mdl_user_cars->getRecommendedProducthistory($invoiceList->invoice_id);
                if(!empty($recommended_products)){
                    $invoices[$key]->recommended_products = $recommended_products;
                }else{
                    $invoices[$key]->recommended_products = array();
                }
            }
        }

        return $invoices;
    }

}