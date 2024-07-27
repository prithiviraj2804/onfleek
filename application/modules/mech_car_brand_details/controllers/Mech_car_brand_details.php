<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Mech_Car_Brand_Details
 */
class Mech_Car_Brand_Details extends Admin_Controller
{
    /**
     * Families constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_mech_car_brand_details');
    }

    /**
     * @param int $page
     */
    public function index()
    {
        $mech_car_brand_details = $this->mdl_mech_car_brand_details->get()->result();
        
        $this->layout->set('mech_car_brand_details', $mech_car_brand_details);
        $this->layout->buffer('content', 'mech_car_brand_details/index');
        $this->layout->render();
    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('mech_car_brand_details');
        }

        if ($this->mdl_mech_car_brand_details->run_validation()) {
        	$id = $this->mdl_mech_car_brand_details->save($id);
            $config['upload_path']          = './uploads/car_images/brand/';
            $config['allowed_types']        = 'jpg|gif|svg|jpeg|png';
            $config['max_size']             = 1000;
            $config['max_width']            = 1024;
            $config['max_height']           = 768;
			$new_name = time()."_".str_replace(" ", "_", $_FILES["brand_image"]['name']);
			$config['file_name'] = $_FILES["brand_image"]['name'];

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('brand_image'))
            {
                $error = array('error' => $this->upload->display_errors());
				$data = array();
            }
            else
            {
            	$existing_data = $this->mdl_mech_car_brand_details->get_by_id($id);
				unlink("./uploads/car_images/brand/".$existing_data->brand_image);
                $data = array('brand_image' => $new_name);
			}
			$this->mdl_mech_car_brand_details->save($id, $data);
            redirect('mech_car_brand_details');
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_mech_car_brand_details->prep_form($id)) {
                show_404();
            }

            $this->mdl_mech_car_brand_details->set_form_value('is_update', true);
        }
		if($id){
			$address_details = array();
		}else{
			$address_details = array();
		}
        $this->layout->set(array(
            'service_category_lists' => $this->db->get_where('mechanic_service_category_list', array('status' => 1))->result(),
        ));
        $this->layout->buffer('content', 'mech_car_brand_details/form');
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
        $this->mdl_mech_car_brand_details->save($id, $data);
        redirect('mech_car_brand_details');
    }

}
