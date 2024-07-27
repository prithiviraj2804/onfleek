<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mech_Insurance extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_mech_insurance');
        $this->load->model('user_cars/mdl_user_cars');
		
	}
	
    public function index()
    {
    	
		if($this->session->userdata('user_type') == 1){
			$mech_insurance = $this->mdl_mech_insurance->get()->where('insurance_status', 'A')->result();
		}else{
			$mech_insurance = $this->mdl_mech_insurance->where('user_id',$this->session->userdata('user_id'))->where('insurance_status', 'A')->get()->result();
		}

        $this->layout->set('mech_insurances', $mech_insurance);
        $this->layout->buffer('content', 'mech_insurance/index');
        $this->layout->render();
	}
	
    public function form($id = null,$validation= null)
    {
    	if ($this->input->post('btn_cancel')) {
            redirect('mech_insurance');
            exit();
        }
		 if($this->session->userdata('user_type') == 1){
		 	$run_validation = "user_validation_rules";
		 }elseif($this->session->userdata('user_type') == 2){
		 	$run_validation = "admin_validation_rules";
		 }
        if ($this->mdl_mech_insurance->run_validation($run_validation)) {
        	$rc_config['upload_path']          = './uploads/insurance/';
            $rc_config['allowed_types']        = 'jpg|gif|svg|jpeg|png|pdf';
            $rc_config['max_size']             = 1000;
			$rc_config['file_name'] = $_FILES["rc_book_image"]['name'];
			$this->load->library('upload', $rc_config);
			if ( ! $this->upload->do_upload('rc_book_image')){
                $error = array('error' => $this->upload->display_errors());
				$data = array();
				$rc_book_image_name = "";
            }else{
            	$rc_arr = $this->upload->data();
				$rc_book_image_name = $rc_arr['file_name'];	
			}
			
			$inc_config['upload_path']          = './uploads/insurance/';
            $inc_config['allowed_types']        = 'jpg|gif|svg|jpeg|png|pdf';
            $inc_config['max_size']             = 1000;
			$inc_config['file_name'] = $_FILES["insurance_url"]['name'];
			$this->load->library('upload', $inc_config);
			if ( ! $this->upload->do_upload('insurance_url')){
                $error = array('error' => $this->upload->display_errors());
				$data = array();
				$insurance_arr_name = "";
            }else{
            	$insurance_arr = $this->upload->data();
				$insurance_arr_name = $insurance_arr['file_name'];
			}
			if($this->input->post('is_update')==1){
				$ins_id = $this->input->post('insurance_id');
			}else{
				$ins_id = NULL;
			}
			if($this->session->userdata('user_type') == 2){
			$db_array = array(
				'car_id'=>$this->input->post('car_id'),
				'existing_idv_value	'=>$this->input->post('existing_idv_value'),
				'is_already_expired'=>$this->input->post('is_experied'),
				'existing_expired_date'=>$this->input->post('existing_expired_date'),
				'rc_book_url'=>$rc_book_image_name,
				'insurance_url'=>$insurance_arr_name,
			);
			}elseif($this->session->userdata('user_type') == 1){
				$db_array = array(
					'car_id'=>$this->input->post('car_id'),
					'existing_idv_value	'=>$this->input->post('existing_idv_value'),
					'current_idv_value'=>$this->input->post('current_idv_value'),
					'is_already_expired'=>$this->input->post('is_already_expired'),
					'existing_expired_date'=>$this->input->post('existing_expired_date'),
					'is_renewal'=>$this->input->post('is_renewal'),
					'existing_Insurance_id'=>$this->input->post('renewal_id'),
					'insurance_start_date'=>$this->input->post('insurance_date'),
					'insurance_end_date'=>$this->input->post('expired_date'),
					'rc_book_url'=>$rc_book_image_name,
					'insurance_url'=>$insurance_arr_name,
				);
			}
			$insurance_id = $this->mdl_mech_insurance->save($ins_id,$db_array);
		}

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_mech_insurance->prep_form($id)) {
                show_404();
            }
			$this->mdl_mech_insurance->set_form_value('is_update', true);
        }
		
        $this->layout->set(array(
        	'insurance_id'=>($id)?$id:NULL,
        	'car_list' => $this->mdl_user_cars->where('owner_id='.$this->session->userdata('user_id').' AND mech_owner_car_list.status = 1')->get()->result() ,
            'brand_list' => $this->db->get_where('mech_car_brand_details', array('status' => 1))->result(),
            'validation'=> $validation
        )); 
		
        $this->layout->buffer('content', 'mech_insurance/form');
        $this->layout->render();
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $data = array(
            'insurance_status' => 'D'
        );
        $this->mdl_mech_insurance->save($id, $data);
        redirect('mech_insurance');
    }

	public function user_insurance()
	{
		if ($this->input->post('btn_cancel')) {
            redirect('mech_insurance');
            exit();
        }

			$run_validation = "user_validation_rules";
        if ($this->mdl_mech_insurance->run_validation($run_validation)) {
        	
			if($this->input->post('is_update')==1){
				$ins_id = $this->input->post('insurance_id');
			}else{
				$ins_id = NULL;
			}
			
			$rc_config['upload_path']          = './uploads/insurance/';
            $rc_config['allowed_types']        = 'jpg|gif|svg|jpeg|png|pdf';
            $rc_config['max_size']             = 1000;
			$rc_config['file_name'] = $_FILES["rc_book_image"]['name'];
			
			$this->load->library('upload', $rc_config);
			if($_FILES["rc_book_image"]['name']=="" && $ins_id!=''){
				$rc_book_image_name = $this->input->post('rc_book_url_existing');
			}else{
				$existing_data = $this->mdl_mech_insurance->get_by_id($ins_id);
				unlink("./uploads/insurance/".$existing_data->rc_book_url);
				if ( ! $this->upload->do_upload('rc_book_image')){
	                $error = array('error' => $this->upload->display_errors());
					$data = array();
					$rc_book_image_name = "";
	            }else{
	            	$rc_arr = $this->upload->data();
					$rc_book_image_name = $rc_arr['file_name'];	
				}
			}
			$inc_config['upload_path']          = './uploads/insurance/';
            $inc_config['allowed_types']        = 'jpg|gif|svg|jpeg|png|pdf';
            $inc_config['max_size']             = 1000;
			$inc_config['file_name'] = $_FILES["insurance_url"]['name'];
			$this->load->library('upload', $inc_config);
			if($_FILES["insurance_url"]['name']=="" && $ins_id!=''){
				$insurance_arr_name = $this->input->post('insurance_url_existing');
			}else{
				$existing_data = $this->mdl_mech_insurance->get_by_id($ins_id);
				unlink("./uploads/insurance/".$existing_data->insurance_url);
				if ( ! $this->upload->do_upload('insurance_url')){
	                $error = array('error' => $this->upload->display_errors());
					$data = array();
					$insurance_arr_name = "";
	            }else{
	            	$insurance_arr = $this->upload->data();
					$insurance_arr_name = $insurance_arr['file_name'];
				}
			}

			$db_array = array(
				'car_id'=>$this->input->post('user_car_list_id'),
				'existing_idv_value	'=>$this->input->post('existing_idv_value'),
				'is_already_expired'=>$this->input->post('is_experied'),
				'existing_expired_date'=>$this->input->post('existing_expired_date'),
				'rc_book_url'=>$rc_book_image_name,
				'insurance_url'=>$insurance_arr_name,
			);
				$insurance_id = $this->mdl_mech_insurance->save($ins_id,$db_array);
				if($insurance_id){
					redirect('mech_insurance');
				}
			}else{
				$error = validation_errors();   
				print_r($error);
				exit();
				redirect('mech_insurance/form');
				
			}
			
	}

	public function admin_insurance()
	{
		if ($this->input->post('btn_cancel')) {
            redirect('mech_insurance');
            exit();
        }
        
		$run_validation = "admin_validation_rules";
        if ($this->mdl_mech_insurance->run_validation($run_validation)) {
        	
				$rc_config['upload_path']          = './uploads/insurance/';
		        $rc_config['allowed_types']        = 'jpg|gif|svg|jpeg|png|pdf';
		        $rc_config['max_size']             = 1000;
				$rc_config['file_name'] = $_FILES["rc_book_image"]['name'];
				$this->load->library('upload', $rc_config);
				if ( ! $this->upload->do_upload('rc_book_image')){
		            $error = array('error' => $this->upload->display_errors());
					$data = array();
		        }else{
		        	$rc_arr = $this->upload->data();
					$rc_book_image_name = $rc_arr['file_name'];	
				}
				
				
				
				$inc_config['upload_path']          = './uploads/insurance/';
		        $inc_config['allowed_types']        = 'jpg|gif|svg|jpeg|png|pdf';
		        $inc_config['max_size']             = 1000;
				$inc_config['file_name'] = $_FILES["insurance_url"]['name'];
				$this->load->library('upload', $inc_config);
				if ( ! $this->upload->do_upload('insurance_url')){
		            $error = array('error' => $this->upload->display_errors());
					$data = array();
		        }else{
		        	$insurance_arr = $this->upload->data();
					$insurance_arr_name = $insurance_arr['file_name'];
				}
		
				if($this->input->post('is_update')==1){
					$ins_id = $this->input->post('insurance_id');
				}else{
					$ins_id = NULL;
				}
				
				$db_array = array(
					'car_id'=>$this->input->post('user_car_list_id'),
					'existing_idv_value	'=>$this->input->post('existing_idv_value'),
					'current_idv_value'=>$this->input->post('current_idv_value'),
					'is_already_expired'=>$this->input->post('is_experied'),
					'existing_expired_date'=>$this->input->post('existing_expired_date'),
					'is_renewal'=>$this->input->post('is_renewal'),
					'existing_Insurance_id'=>$this->input->post('renewal_id'),
					'insurance_start_date'=>$this->input->post('insurance_date'),
					'insurance_end_date'=>$this->input->post('expired_date'),
					'rc_book_url'=>$rc_book_image_name,
					'insurance_url'=>$insurance_arr_name,
				);
				$insurance_id = $this->mdl_mech_insurance->save($ins_id,$db_array);
				if($insurance_id){
					redirect('mech_insurance');
				}
			}
	else{
		$error = validation_errors();   
		print_r($error);
		exit();
		redirect('mech_insurance/form');
		
		}

	}
}
