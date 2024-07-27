<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Mech_Area_List
 */
class Mech_Area_List extends Admin_Controller
{
    /**
     * Families constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_mech_area_list');
    }

    /**
     * @param int $page
     */
    public function index()
    {
        $mech_area_list = $this->mdl_mech_area_list->get()->result();
        
        $this->layout->set('mech_area_list', $mech_area_list);
        $this->layout->buffer('content', 'mech_area_list/index');
        $this->layout->render();
    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('mech_area_list');
        }

        if ($this->mdl_mech_area_list->run_validation()) {
            $this->mdl_mech_area_list->save($id);
            redirect('mech_area_list');
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_mech_area_list->prep_form($id)) {
                show_404();
            }

            $this->mdl_mech_area_list->set_form_value('is_update', true);
        }
		if($id){
			$address_details = array();
		}else{
			$address_details = array();
		}
        
        $this->layout->buffer('content', 'mech_area_list/form');
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
        $this->mdl_mech_area_list->save($id, $data);
        redirect('mech_area_list');
    }

}
