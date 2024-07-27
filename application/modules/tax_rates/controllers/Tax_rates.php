<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tax_Rates extends Admin_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->model('tax_rates/mdl_tax_rates');
    }


    public function index($page = 0)
    {
        $this->mdl_tax_rates->paginate(site_url('tax_rates/index'), $page);
        $tax_rates = $this->mdl_tax_rates->result();
        if(count($tax_rates) > 0){
            foreach($tax_rates as $taxRateKey => $tax_rate){
                if(!empty($tax_rate->module_id)){
                    $moduleidarray = explode(',', $tax_rate->module_id); 
                    $module_name = array();
                    for ($i = 0; $i < count($moduleidarray); $i++) {
                        $this->db->select('module_label');
                        $this->db->from('mech_modules');
                        $this->db->where('module_id' , $moduleidarray[$i]);
                        $word = $this->db->get()->row()->module_label;
                        array_push($module_name, $word);

                    } 
                }
                $tax_rates[$taxRateKey]->module_name = $module_name; 
            }
        }
        $this->layout->set('tax_rates', $tax_rates);
        $this->layout->buffer('content', 'tax_rates/index');
        $this->layout->render();
    }

    public function form($tax_rate_id = null)
    {
        if ($tax_rate_id){
            $tax_details = $this->mdl_tax_rates->where('tax_rate_id', $tax_rate_id)->get()->row();
            $breadcrumb = "lable987";
        }else{
            $tax_details = array();
            $breadcrumb = "lable988";
        } 

        $this->layout->set(
            array(
                'active_tab' => $tab,
                'breadcrumb' => $breadcrumb, 
                'tax_rate_id' => $tax_rate_id,
                'tax_details' => $tax_details,
            )
        );
        $this->layout->buffer('content', 'tax_rates/form');
        $this->layout->render();
    }

    public function delete()
    {   
        $id = $this->input->post('id');
		$this->db->where('tax_rate_id', $id);
		$this->db->update('ip_tax_rates', array('status'=>'D'));
		$response = array(
            'success' => 1
        );
		echo json_encode($response);
    }

}