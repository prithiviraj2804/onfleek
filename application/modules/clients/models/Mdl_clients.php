<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Clients extends Response_Model
{
    public $table = 'mech_clients';
    public $primary_key = 'mech_clients.client_id';
    public $date_created_field = 'client_date_created';
    public $date_modified_field = 'client_date_modified';

    public function default_select()
    {
		$this->db->select('SQL_CALC_FOUND_ROWS mech_clients.client_id,mech_clients.workshop_id,mech_clients.w_branch_id,
		mech_clients.client_name,mech_clients.client_gstin,mech_clients.total_rewards_point,mech_clients.is_new_customer,
		mech_clients.branch_id,mech_clients.customer_category_id,mech_clients.client_contact_no,mech_clients.client_email_id,
		mech_clients.refered_by_type,mech_clients.refered_by_id,mech_clients.client_active,mech_clients.client_no,mech_clients.mobile_app_status,
		workshop_branch_details.display_board_name,
		mech_customer_category.customer_category_name', false);
	}
	
	public function default_join()
    {
		$this->db->join('workshop_branch_details', 'workshop_branch_details.w_branch_id = mech_clients.branch_id', 'left');
		$this->db->join('mech_customer_category' , 'mech_customer_category.customer_category_id = mech_clients.customer_category_id', 'left');
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_clients.client_name');
    }
	public function default_where()
    {
		$this->db->where('mech_clients.workshop_id', $this->session->userdata('work_shop_id'));
       	if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5){
			$this->db->where('mech_clients.w_branch_id', $this->session->userdata('branch_id'));
		}else if($this->session->userdata('user_type') == 6){
			$this->db->where_in('mech_clients.w_branch_id', $this->session->userdata('user_branch_id'));
		}
		$this->db->where('mech_clients.client_active', 'A');
    }

    public function validation_rules()
    {
        return array(
            'client_name' => array(
                'field' => 'client_name',
                'label' => trans('lable50'),
                // 'rules' => 'required|trim|strip_tags|alpha_numeric_spaces'
			),
            'client_contact_no' => array(
                'field' => 'client_contact_no',
                'label' => 'lable54',
                'rules' => 'numeric|trim|strip_tags'
            ),
            'client_email_id' => array(
                'field' => 'client_email_id',
                'label' => trans('lable42'),
                //'rules' => 'valid_email|trim|strip_tags'
			),
			'client_gstin' => array(
				'field' => 'client_gstin',
                'label' => trans('lable41'),
			), 
			'refered_by_type' => array(
                'field' => 'refered_by_type',
                'label' => trans('lable52')
			),
			'refered_by_id' => array(
                'field' => 'refered_by_id',
                'label' => trans('lable54')
			),
            '_mm_csrf' => array(
                'field' => '_mm_csrf'
            )
        );
    }

	public function validation_rules_model()
    {
		
        return array(
            'client_name' => array(
                'field' => 'client_name',
                'label' => trans('lable50'),
                // 'rules' => 'required|trim|strip_tags'
			),
			'branch_id' => array(
                'field' => 'branch_id',
                'label' => trans('lable95'),
                // 'rules' => 'required',
			),
			'customer_category_id' => array(
                'field' => 'customer_category_id',
                'label' => trans('lable208'),
                // 'rules' => 'required',
			),
			'client_gstin' => array(
				'field' => 'client_gstin',
                'label' => trans('lable760'),
			), 
            'client_contact_no' => array(
                'field' => 'client_contact_no',
                'label' => trans('lable42'),
                'rules' => 'trim|strip_tags|numeric'
            ),
            'client_email_id' => array(
                'field' => 'client_email_id',
                'label' => trans('lable41'),
                //'rules' => 'valid_email|trim|strip_tags'
			),
			'refered_by_type' => array(
                'field' => 'refered_by_type',
                // 'label' => trans('lable52')
			),
			'refered_by_id' => array(
                'field' => 'refered_by_id',
                // 'label' => trans('lable54')
            ),
			'client_no' => array(
                'field' => 'client_no',
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
		unset($db_array['action_from']);
        if (!isset($db_array['client_active'])) {
            $db_array['client_active'] = 'A';
        }
		unset($db_array['client_id']);
    	$db_array['client_created_by'] = $this->session->userdata('user_id');
    	$db_array['client_modified_by'] = $this->session->userdata('user_id');
		$db_array['workshop_id'] = $this->session->userdata('work_shop_id');
    	$db_array['w_branch_id'] = $this->session->userdata('branch_id');
        return $db_array;
    }

	public function save($id = null, $db_array = null)
    {
		$db_array = ($db_array) ? $db_array : $this->db_array();		
        $id = parent::save($id, $db_array);
        return $id;
    }
	
    public function delete($id)
    {
        parent::delete($id);

        $this->load->helper('orphan');
        delete_orphans();
    }
	public function get_customer_name($customer_id)
	{
		$this->db->select("client_name");	
		$this->db->from('mech_clients');
		$this->db->where('client_id', $customer_id);
		return $this->db->get()->row()->client_name;
	}
	public function get_area_name($area_id)
	{
		$this->db->select("area_name");	
		$this->db->from('mech_area_list');
		$this->db->where('area_id', $area_id);
		return $this->db->get()->row()->area_name;
	}
	public function get_state_name($state_id)
	{
		$this->db->select("state_name");	
		$this->db->from('mech_state_list');
		$this->db->where('state_id', $state_id);
		return $this->db->get()->row()->state_name;
	}
	public function get_country_name($country_id)
	{
		return "India";
	}
	/* Dashboard Code */
	public function get_total_customer()
	{
		//if($this->session->userdata('user_type') == 3){
			//$this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
		//}elseif($this->session->userdata('user_type') == 4){
			$this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
			$this->db->where('w_branch_id', $this->session->userdata('branch_id'));
		//}
		$this->db->where('client_active', 'A');
		$customer_data = $this->db->get('mech_clients');
		return $customer_data->num_rows();
	}
	public function checkClientEmailExist($email_id=NULL)
	{
		
		if ($email_id != '') {
		 	$client_id = $this->input->post('client_id');
		if($client_id){
			 $check = $this->db->select('client_email_id')->from('mech_clients')->where('client_email_id',$email_id)->where('client_id!=',$client_id,FALSE )->where('client_active','A')->get()->result();
		}else{
			 $check = $this->db->select('client_email_id')->from('mech_clients')->where('client_email_id',$email_id)->where('client_active','A')->get()->result();
		}
	       $existing_email = array();
			foreach($check as $exists){
				$already_exists =  str_replace(' ', '', strtolower($exists->client_email_id));
				array_push($existing_email, $already_exists);
			}
			
			if(in_array($email_id, $existing_email)){
				$this->form_validation->set_message('checkClientEmailExist', 'Email id already exist.');
				return false;
			}else{
				return true;
			}
			
	    }	
	}
	
	public function check_client_mobile_exist($client_contact_no=NULL)
	{
		if ($client_contact_no != '') {
		 	$client_id = $this->input->post('client_id');
		if($client_id){
			 $check = $this->db->select('client_contact_no')->from('mech_clients')->where('client_contact_no',$mobile_no)->where('client_id!=',$client_id,FALSE )->where('client_active','A')->get()->result();
		}else{
			 $check = $this->db->select('client_contact_no')->from('mech_clients')->where('client_contact_no',$mobile_no)->where('client_active','A')->get()->result();
		}
	       $existing_mobile = array();
			foreach($check as $exists){
				$already_exists =  str_replace(' ', '', strtolower($exists->client_contact_no));
				array_push($existing_mobile, $already_exists);
			}
			
			if(in_array($client_contact_no, $existing_mobile)){
				$this->form_validation->set_message('check_client_mobile_exist', 'Mobile No already exist.');
				return false;
			}else{
				return true;
			}
		}
	}

	public function upload_client_details($db_client_array = null)
    {
    	$this->db->select('client_id');
        $this->db->where('client_name', $db_client_array['client_name']);
        $this->db->where('client_contact_no', $db_client_array['client_contact_no']);
    	$this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
		$client = $this->db->get('mech_clients'); 
    	
        if ($client->num_rows()) {
            $client_id = $client->row()->client_id;
           // parent::save($client_id, $db_client_array);
        } else {                    
            $client_id = parent::save(null, $db_client_array);
        }
		return $client_id;
		
	}
	
	function findphoneno($phoneno = NULL,$clientid = NULL,$branchid = NULL)
	{
		$this->db->select('*'); 
		$this->db->from('mech_clients');
		$this->db->where('client_contact_no', $phoneno);
		$this->db->where('branch_id', $branchid);
		$this->db->where_not_in('client_id', $clientid);
		$query = $this->db->get()->result();
		return $query;
	}

	// Mobile API Code

	function user_signup($user_mobile, $otp, $device_token, $workshop_id){
		$this->load->model('settings/mdl_settings');
		$this->db->select('client_id,mobile_app_status');
		$this->db->where('client_contact_no', $user_mobile);
        $query = $this->db->get('mech_clients');
		$user = $query->row();
		$datetime = date('Y-m-d H:m:s');
		
        if(!empty($user) > 0){
        	if($user->mobile_app_status == 'N'){
        		$data=array('mobile_app_status'=>'U','otp'=>$otp,'otp_session_time'=>$datetime,'device_token'=>$device_token, 'client_modified_by' => $user->client_id);
        	}else{
        		$data=array('otp'=>$otp,'otp_session_time'=>$datetime,'device_token'=>$device_token, 'client_modified_by' => $user->client_id);
			}
			$this->db->where('client_id', $user->client_id);
			$this->db->where('client_contact_no', $user_mobile);
			$this->db->update('mech_clients', $data);
			$client_id = $user->client_id;
			$user_entry_type = 'O';
        }else{

			$invoice_group_number = $this->db->query("SELECT * FROM ip_invoice_groups where module_type = 'customer' AND workshop_id = '".$workshop_id."' ORDER BY invoice_group_id ASC LIMIT 1")->row();
			$invoice_group_id = $invoice_group_number->invoice_group_id;
			$client_no = $this->mdl_settings->get_invoice_number($invoice_group_id);

        	$data=array('workshop_id' => $workshop_id, 'client_contact_no'=>$user_mobile,'client_no' =>$client_no,'is_new_customer'=>'Y','mobile_app_status'=>'U','otp'=>$otp,'otp_session_time'=>$datetime,'device_token'=>$device_token,'client_date_created' => $datetime);
			$this->db->insert('mech_clients', $data);
			$client_id = $this->db->insert_id();
			$user_entry_type = 'N';
		}

		if($client_id){
			$return_data = array('client_id' =>$client_id,'otp_session_time'=>$datetime,'mdl_status'=>'success', 'user_entry_type'=>$user_entry_type);
		}else{
			$return_data = array('client_id' =>'','otp_session_time'=>'','mdl_status'=>'error', 'user_entry_type'=>'');
		}
		return json_encode($return_data);
	}


	public function verify_user_otp($user_mobile_no, $otp){
		$this->db->where('client_contact_no', $user_mobile_no);
		$this->db->where('otp', $otp);
		$query = $this->db->get('mech_clients');
		$user = $query->row();
		
		if(!empty($user)){
			   $this->db->select('client_id,client_no,client_name,city_id,client_contact_no,client_email_id')->where('client_contact_no', $user_mobile_no);
			   $where = "otp_session_time > DATE_SUB( NOW() , INTERVAL 3 MINUTE )";
			   //NOW() <= DATE_ADD(otp_session_time, INTERVAL 24 HOUR)
			   $this->db->where($where);
			   $query = $this->db->get('mech_clients');
			   $otp = $query->row();
			   if(!empty($otp) > 0){
				   $data = array('otp' => '', 'otp_session_time' => '', 'client_created_by' => $otp->client_id);
				   $this->db->where('client_contact_no', $user_mobile_no);
				   $this->db->update('mech_clients', $data);
				   return json_encode(array('status' => 'success', 'client_id' => $otp->client_id,'client_data'=>$otp));
			   }else{
				return json_encode(array('status' => 'OTP Expired', 'client_id' => '','client_data'=>array()));
			   }
		}else{
			return json_encode(array('status' => 'OTP Mismatched', 'client_id' => '','client_data'=>array()));
		}
	   }
}
