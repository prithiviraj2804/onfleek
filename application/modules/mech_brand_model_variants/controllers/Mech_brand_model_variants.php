<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Mech_Brand_Model_Variants
 */
class Mech_Brand_Model_Variants extends Admin_Controller
{
    /**
     * Families constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_mech_brand_model_variants');
    }

    /**
     * @param int $page
     */
    public function index()
    {
        $mech_brand_model_variants = $this->mdl_mech_brand_model_variants->get()->result();
        
        $this->layout->set('mech_brand_model_variants', $mech_brand_model_variants);
        $this->layout->buffer('content', 'mech_brand_model_variants/index');
        $this->layout->render();
    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('mech_brand_model_variants');
        }

        if ($this->mdl_mech_brand_model_variants->run_validation()) {
            $this->mdl_mech_brand_model_variants->save($id);
            redirect('mech_brand_model_variants');
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_mech_brand_model_variants->prep_form($id)) {
                show_404();
            }

            $this->mdl_mech_brand_model_variants->set_form_value('is_update', true);
        }
		if($id){
			$address_details = array();
		}else{
			$address_details = array();
		}
        $this->layout->set(array(
            'brand_list' => $this->db->get_where('mech_car_brand_details', array('status' => 1))->result(),
            'brand_models_list' => $this->db->get_where('mech_car_brand_models_details', array('status' => 1))->result(),
        )); 

        $this->layout->buffer('content', 'mech_brand_model_variants/form');
        $this->layout->render();
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $data = array(
            'status' => '2'
        );
        $this->mdl_mech_brand_model_variants->save($id, $data);
        redirect('mech_brand_model_variants');
    }

}
