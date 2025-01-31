<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends Admin_Controller
{
   
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_users');
    }

    public function index($page = 0)
    {
        $this->mdl_users->paginate(site_url('users/index'), $page);
        $users = $this->mdl_users->result();

        $this->layout->set('users', $users);
        $this->layout->set('user_types', $this->mdl_users->user_types());
        $this->layout->buffer('content', 'users/index');
        $this->layout->render();
    }

    public function form($id = null)
    {
        if ($this->input->post('btn_cancel')) {
        	if($this->session->userdata('user_type') == 1) { 
                redirect('users');
            } else if($this->session->userdata('user_type') == 3){ 
                redirect('dashboard');
            }else{
                redirect('dashboard');
            }
        }
			
		if ($this->mdl_users->run_validation('update_user_details_validation_rules')) {
            $id = $this->mdl_users->save($id);

            // Update the session details if the logged in user edited his account
            if ($this->session->userdata('user_id') == $id) {
                $new_details = $this->mdl_users->get_by_id($id);

                $session_data = array(
                    'user_type' => $new_details->user_type,
                    'user_id' => $new_details->user_id,
                    'user_name' => $new_details->name,
                    'user_email' => $new_details->email_id,
                    'mobile_no' => $new_details->mobile_no
                    //'user_language' => isset($user->user_language) ? $user->user_language : 'system',
                );

                $this->session->set_userdata($session_data);
            }

            if ($this->session->userdata('user_type') == 3 || $this->session->userdata('user_type') == 4) {
            	redirect('dashboard');
			}else{
				redirect('users');
			}
        }
		
		if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_users->prep_form($id)) {
                show_404();
            }

            $this->mdl_users->set_form_value('is_update', true);
        }
		
        

        $this->load->helper('custom_values');
        $this->load->model('user_clients/mdl_user_clients');
        $this->load->model('clients/mdl_clients');
        $this->load->helper('country');
		
		if($readonly==1){
			$readonly = 'readonly';
		}else{
			$readonly = '';
		}

        $this->layout->set(
            array(
                'id' => $id,
                'readonly'=>$readonly,
                'user_types' => $this->mdl_users->user_types(),
                'custom_fields' => $custom_fields,
                'custom_values' => $custom_values,
                'countries' => get_country_list(trans('cldr')),
                'selected_country' => $this->mdl_users->form_value('user_country') ?: get_setting('default_country'),
                'clients' => $this->mdl_clients->where('client_active', 1)->get()->result(),
                'languages' => get_available_languages(),
            )
        );

        $this->layout->buffer('content', 'users/form');
        $this->layout->render();
    }

    public function change_password($user_id=null)
    {    

        if($user_id){
            if (!$this->mdl_users->prep_form($user_id)) {
                show_404();
            }
            $this->mdl_users->set_form_value('is_update', true);
        }
       
        $this->layout->buffer('content', 'users/form_change_password');
        $this->layout->render();
    }

    public function delete($id)
    {
        if ($id <> 1) {
            $this->mdl_users->delete($id);
        }
        redirect('users');
    }

    public function delete_user_client($user_id, $user_client_id)
    {
        $this->load->model('mdl_user_clients');
        $this->mdl_user_clients->delete($user_client_id);
        redirect('users/form/'.$user_id);
    }

}