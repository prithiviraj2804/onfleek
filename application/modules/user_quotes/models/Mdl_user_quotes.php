<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_User_Quotes extends Response_Model
{
    public $table = 'mech_quotes';
    public $primary_key = 'mech_quotes.quote_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('mech_quotes.quote_id', "desc");
    }
	
	public function default_join()
    {
        $this->db->join('mech_owner_car_list car', 'car.car_list_id=mech_quotes.customer_car_id', 'left');
		$this->db->join('mech_car_brand_details brand', 'brand.brand_id=car.car_brand_id', 'left');
		$this->db->join('mech_car_brand_models_details model', 'model.model_id=car.car_brand_model_id', 'left');
		$this->db->join('mech_brand_model_variants cv', 'cv.brand_model_variant_id=car.car_variant', 'left');
    }

    public function get_latest()
    {
        $this->db->order_by('mech_quotes.quote_id', 'DESC');
        return $this;
    }

    /**
     * @return array
     */
    public function validation_rules()
    {
        return array(
            'customer_car_id' => array(
                'field' => 'customer_car_id',
                'label' => trans('customer_car_id'),
                'rules' => 'required'
            ),
            'customer_id' => array(
                'field' => 'customer_id',
                'label' => trans('customer_id'),
                'rules' => 'required'
            ),
            'url_key' => array(
                'field' => 'url_key'
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
        if (!isset($db_array['status'])) {
            $db_array['status'] = 'A';
        }
		if($this->input->post('quote_no')){
			$db_array['quote_no'] = $this->input->post('quote_no');
		}else{
			$group_no = $this->mdl_settings->getquote_book_no('quote');
			$db_array['quote_no'] = $this->mdl_settings->get_invoice_number($group_no);
		}
		$db_array['workshop_id'] = $this->session->userdata('work_shop_id');
    	$db_array['w_branch_id'] = $this->session->userdata('branch_id');
    	$db_array['created_by'] = $this->session->userdata('user_id');
    	$db_array['modified_by'] = $this->session->userdata('user_id');
        return $db_array;
    }

	public function save($id = null, $db_array = null)
    {
        $db_array = ($db_array) ? $db_array : $this->db_array();

        // Save the car
        $id = parent::save($id, $db_array);

        return $id;
    }
	
	 public function get_url_key()
    {
        $this->load->helper('string');
        return random_string('alnum', 15);
    }

	public function get_service_category_name($cat_id)
    {
    	$this->db->select('category_name');
    	$this->db->where('service_cat_id', $cat_id);
    	$cat = $this->db->get('mechanic_service_category_list');
    	 
    	if ($cat->num_rows()) {
    		$category_name = $cat->row()->category_name;
    	} else {
    		$category_name = '-';
    	}
    
    	return $category_name;
    }
	public function get_track_status($quote_id,$type)
    {
        $this->db->select('*');
		$this->db->from('mech_service_tracking_details mstd');
		$this->db->where('mstd.quote_id', $quote_id);
		$this->db->order_by("mstd.std_id", "DESC");
		$result = $this->db->get()->result_array();
		return $result;
	}
	public function get_track_status_by_app($appointment_id,$type)
    {
        $this->db->select('*');
		$this->db->from('mech_service_tracking_details mstd');
		$this->db->where('mstd.appointment_id', $appointment_id);
		$this->db->order_by("mstd.std_id", "DESC");
		$result = $this->db->get()->result_array();
		return $result;
	}
	
	public function get_user_total_quote()
	{
		if($this->session->userdata('user_type') == 3){
			$this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
		}elseif($this->session->userdata('user_type') == 4){
			$this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
			$this->db->where('w_branch_id', $this->session->userdata('branch_id'));
		}
		$this->db->where('quote_status', 1);
		$this->db->where('is_request_quote', 0);
		$quote_data = $this->db->get('mech_quotes');
		return count($quote_data->result());
	}
	public function get_user_total_request_quote()
	{
		if($this->session->userdata('user_type') == 3){
			$this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
		}elseif($this->session->userdata('user_type') == 4){
			$this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
			$this->db->where('w_branch_id', $this->session->userdata('branch_id'));
		}
		
		$this->db->where('quote_status', 1);
		$this->db->where('is_request_quote', 1);
		$quote_data = $this->db->get('mech_quotes');
		return count($quote_data->result());
	}

    /* Save API Quote */

      /* API Save */

    public function create_api_quote($quote){
		$this->db->insert('mech_quotes',$quote);
		$quote_id = $this->db->insert_id();

        $this->db->select('quote_id,url_key');
        $this->db->from('mech_quotes mq');
        $this->db->where('mq.quote_id',$quote_id);         
        $query = $this->db->get(); 
        if($query->num_rows() != 0)
        {
                $result = $query->row();
        }else
        {
                $result = array();
        }
        return $result;
    }

    public function get_appointments($id){
        //echo $id;
        $this->db->select('appointment_id,quote_id,current_track_status,is_payment_enable,pickup_address,pickup_date,pickup_time,delivery_address,delivery_date,delivery_time,payment_request_amount');
        $this->db->where('appointment_id',$id);
        $this->db->from(' mech_appointment_books');
        $query = $this->db->get();
        return $query->row();
    }

    public function  get_track($id = null,$appointment_id=null,$order_by=null){
        $this->select('track.comments,track.ahc_amount,track.ahc_timing,track.ahc_date,emp.employee_name,emp.mobile_no,history.ahc_name,track.track_status_id');
        $this->db->join('mech_employee emp', 'emp.employee_id = track.ahc_employee', 'left');
        $this->db->from('mech_service_tracking_details track');
		if($order_by == 'asc'){
			$this->db->order_by('track.track_status_id', "asc");
		}else{
			$this->db->order_by('track.track_status_id', "desc");
		}
        
        if($id != null)
        {
            $this->db->where('track.quote_id',$id);         
        }
		if($appointment_id != null)
        {
            $this->db->where('track.appointment_id',$appointment_id);         
        }
        $query = $this->db->get();

         return $query->result_array();
    }

    public function  get_service_name($id){
        $this->select('msci.service_item_name');
        $this->db->join('mech_service_item_dtls msci', 'mrsi.service_item=msci.msim_id', 'left');
        //$this->db->join('mech_employee emp', 'emp.employee_id = track.ahc_employee', 'left');
        $this->from('mech_repair_service_items mrsi');
        $this->db->where('mrsi.quote_id',$id);     
        $query = $this->db->get();
        return $query->result_array();
    }

    public function calc_paid_amount($quote_id){
      return $quote_id;
    }

	public function get_track_status_name($quote_id)
    {
        $this->db->select('crud.ahc_name');
		$this->db->from('mech_quotes book');
		$this->db->where('book.quote_id', $quote_id);
		return $this->db->get()->row()->ahc_name;
    }
	
	public function get_total_jobcard()
	{
		//if($this->session->userdata('user_type') == 3){
			//$this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
		//}elseif($this->session->userdata('user_type') == 4){
			$this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
			$this->db->where('w_branch_id', $this->session->userdata('branch_id'));
		//}
		$this->db->where('quote_status', 1);
		$this->db->where('is_request_quote', 0);
		$quote_data = $this->db->get('mech_quotes');
		return $quote_data->num_rows();
	}
	
	public function get_total_jobsheet()
	{
		//if($this->session->userdata('user_type') == 3){
			//$this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
		//}elseif($this->session->userdata('user_type') == 4){
			$this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
			$this->db->where('w_branch_id', $this->session->userdata('branch_id'));
		//}
		$this->db->where('quote_status', 2);
		$this->db->where('is_jobsheet', 'Y');
		$this->db->where('jobsheet_status!=', 'C');
		$quote_data = $this->db->get('mech_quotes');
		return $quote_data->num_rows();
	}
	public function get_total_delivery_details($date=NULL,$time=NULL)
	{
		
		switch ($period) {
				case 'last-month':
					 $this->filter_where('MONTH(delivery_date)', 'MONTH(NOW() - INTERVAL 1 MONTH)',FALSE);
					 $this->filter_where('YEAR(delivery_date)', 'YEAR(NOW() - INTERVAL 1 MONTH)',FALSE);
					break;
				case 'last-year':
					$this->filter_where('YEAR(delivery_date)', 'YEAR(NOW()- INTERVAL 1 YEAR)',FALSE);
					break;
				case 'this-year':
					$this->filter_where('YEAR(delivery_date)', 'YEAR(NOW())',FALSE);
					break;
				case 'this-month':
					$this->filter_where('MONTH(delivery_date)', 'MONTH(NOW())',FALSE);
					 $this->filter_where('YEAR(delivery_date)', 'YEAR(NOW())',FALSE);
					break;
				case 'this-day':
					$this->filter_where('DAY(delivery_date)', 'DAY(NOW())',FALSE);
					 $this->filter_where('YEAR(delivery_date)', 'YEAR(NOW())',FALSE);
					break;
				case 'tmr-day':
					 $this->filter_where('DAY(delivery_date)', 'DAY(NOW() + INTERVAL 1 DAY)',FALSE);
					 $this->filter_where('YEAR(delivery_date)', 'YEAR(NOW())',FALSE);
					break;
			}
		//if($this->session->userdata('user_type') == 3){
			//$this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
		//}elseif($this->session->userdata('user_type') == 4){
			$this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
			$this->db->where('w_branch_id', $this->session->userdata('branch_id'));
		//}
		$this->db->where('quote_status', 2);
		$this->db->where('current_track_status>=', 6);
		$this->db->where('jobsheet_status', 'C');
		
		$quote_data = $this->db->get('mech_quotes');
		return $quote_data->num_rows();
	}

	public function get_total_pickup_details($date=NULL,$time=NULL)
	{
		
		switch ($period) {
				case 'last-month':
					 $this->filter_where('MONTH(pickup_date)', 'MONTH(NOW() - INTERVAL 1 MONTH)',FALSE);
					 $this->filter_where('YEAR(pickup_date)', 'YEAR(NOW() - INTERVAL 1 MONTH)',FALSE);
					break;
				case 'last-year':
					$this->filter_where('YEAR(pickup_date)', 'YEAR(NOW()- INTERVAL 1 YEAR)',FALSE);
					break;
				case 'this-year':
					$this->filter_where('YEAR(pickup_date)', 'YEAR(NOW())',FALSE);
					break;
				case 'this-month':
					$this->filter_where('MONTH(pickup_date)', 'MONTH(NOW())',FALSE);
					 $this->filter_where('YEAR(pickup_date)', 'YEAR(NOW())',FALSE);
					break;
				case 'this-day':
					$this->filter_where('DAY(pickup_date)', 'DAY(NOW())',FALSE);
					 $this->filter_where('YEAR(pickup_date)', 'YEAR(NOW())',FALSE);
					break;
				case 'tmr-day':
					 $this->filter_where('DAY(pickup_date)', 'DAY(NOW() + INTERVAL 1 DAY)',FALSE);
					 $this->filter_where('YEAR(pickup_date)', 'YEAR(NOW())',FALSE);
					break;
			}
		//if($this->session->userdata('user_type') == 3){
			//$this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
		//}elseif($this->session->userdata('user_type') == 4){
			$this->db->where('workshop_id', $this->session->userdata('work_shop_id'));
			$this->db->where('w_branch_id', $this->session->userdata('branch_id'));
		//}
		$this->db->where('quote_status', 2);
		$this->db->where('current_track_status', 2);
		$this->db->where('jobsheet_status', 'Y');
		
		$quote_data = $this->db->get('mech_quotes');
		return $quote_data->num_rows();
	}
	
}