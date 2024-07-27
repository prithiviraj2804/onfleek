<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Mech_Car_Brand_Models_Details
 */
class Mech_Car_Brand_Models_Details extends Admin_Controller
{
    /**
     * Families constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_mech_car_brand_models_details');
    }

    /**
     * @param int $page
     */
    public function index()
    {
        $mech_car_brand_models_details = $this->mdl_mech_car_brand_models_details->get()->result();
        
        $this->layout->set('mech_car_brand_models_details', $mech_car_brand_models_details);
        $this->layout->buffer('content', 'mech_car_brand_models_details/index');
        $this->layout->render();
    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('mech_car_brand_models_details');
        }

        if ($this->mdl_mech_car_brand_models_details->run_validation()) {
			$id = $this->mdl_mech_car_brand_models_details->save($id);
            $config['upload_path']          = './uploads/car_images/models/';
            $config['allowed_types']        = 'jpg|gif|svg|jpeg|png';
            $config['max_size']             = 1000;
            $config['max_width']            = 1024;
            $config['max_height']           = 768;
			$new_name = time()."_".str_replace(" ", "_", $_FILES["model_image"]['name']);
			$config['file_name'] = $_FILES["model_image"]['name'];

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('model_image'))
            {
                $error = array('error' => $this->upload->display_errors());
				$data = array();
            }
            else
            {
            	$existing_data = $this->mdl_mech_car_brand_models_details->get_by_id($id);
				unlink("./uploads/car_images/models/".$existing_data->model_image);
                $data = array('model_image' => $new_name);
			}
			$this->mdl_mech_car_brand_models_details->save($id, $data);
			redirect('mech_car_brand_models_details');
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_mech_car_brand_models_details->prep_form($id)) {
                show_404();
            }

            $this->mdl_mech_car_brand_models_details->set_form_value('is_update', true);
        }
		if($id){
			$address_details = array();
		}else{
			$address_details = array();
		}
        $this->layout->set(array(
            'brand_list' => $this->db->get_where('mech_car_brand_details', array('status' => 1))->result(),
        )); 
        $this->layout->buffer('content', 'mech_car_brand_models_details/form');
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
        $this->mdl_mech_car_brand_models_details->save($id, $data);
        redirect('mech_car_brand_models_details');
    }

}
