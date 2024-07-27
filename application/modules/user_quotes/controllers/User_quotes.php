<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Cars
 */
class User_Quotes extends Admin_Controller
{
    /**
     * Quotes constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_user_quotes');
        $this->load->model('user_cars/mdl_user_cars'); 
        $this->load->model('clients/mdl_clients');
        $this->load->model('mech_item_master/mdl_mech_item_master');
        $this->load->model('products/mdl_products');     
        $this->load->model('user_address/mdl_user_address');  
        $this->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls');
        $this->load->model('mechanic_service_category_items/mdl_mechanic_service_category_items'); 
		$this->load->model('workshop_branch/mdl_workshop_branch');  
    }

    /**
     * @param int $page
     */
    public function index()
    {
        redirect('user_quotes/status/all');
    }

    public function status($status = 'all', $page = 0)
    {
        if($this->session->userdata('user_type') == 3){
            $this->mdl_user_quotes->where('mech_quotes.workshop_id', $this->session->userdata('work_shop_id'));
        }elseif($this->session->userdata('user_type') == 4){
            $this->mdl_user_quotes->where('mech_quotes.workshop_id', $this->session->userdata('work_shop_id'))->where('mech_quotes.w_branch_id', $this->session->userdata('branch_id'));
        }
        switch ($status) {
            case 'all':
                $label_name = 'JOB CARDS';
                $url_from = 'q';
                break;
            case 'request':
                $label_name = 'REQUESTED JOBS';
                $url_from = 're';
                $this->mdl_user_quotes->where('quote_status', 1);
                break;
            case 'current':
                $label_name = 'RUNNING JOBS';
                $url_from = 'ru';
                $this->mdl_user_quotes->where('quote_status', 2)->where('current_track_status<', 8);
                break;
			 case 'completed':
                $label_name = 'COMPLETED JOBS';
                $url_from = 'c';
                $this->mdl_user_quotes->where('quote_status', 2)->where('current_track_status', 8);
                break;
        }
        $this->mdl_user_quotes->where('mech_quotes.status', 'A');
        $quotes = $this->mdl_user_quotes->get()->result();
        
        $this->db->select('*');
        $this->db->from('mech_repair_service_items si');
        $this->db->join('mech_service_item_dtls ci', 'ci.msim_id = si.service_item');
       if($this->session->userdata('user_type') == 3){
			$this->db->where('si.workshop_id', $this->session->userdata('work_shop_id'));
		}elseif($this->session->userdata('user_type') == 4){
			$this->db->where('si.workshop_id', $this->session->userdata('work_shop_id'));
			$this->db->where('si.w_branch_id', $this->session->userdata('branch_id'));
		}
        $service_items = $this->db->get()->result();
        
        $this->layout->set('quote_book_list', $quotes);
        $this->layout->set('service_item_list', $service_items);
        $this->layout->set('label_name', $label_name);
        $this->layout->set('url_from', $url_from);
        $this->layout->buffer('content', 'user_quotes/index');
        $this->layout->render();
    }
    
    public function get_user_quote_product_item($quote_id = null, $user_id  = null)
    {
        if($quote_id){
        	$work_shop_id = $this->session->userdata('work_shop_id');
			$branch_id = $this->session->userdata('branch_id');
            $this->db->select('*');
            $this->db->from('mech_repair_service_items si');
            $this->db->join('mech_products ci', 'ci.product_id = si.service_item');
            if($this->session->userdata('user_type') == 3){
				$this->db->where('si.workshop_id='.$work_shop_id.'');
			}elseif($this->session->userdata('user_type') == 4){
				$this->db->where('si.workshop_id='.$work_shop_id.' AND si.w_branch_id='.$branch_id.'');
			}
            $this->db->where('si.is_from', 'invoice_product');
            $this->db->where('si.quote_id', $quote_id);
            $service_items = $this->db->get()->result();
        }else{
            $service_items = array();
        }
        
        return json_encode($service_items);
    }
    
    public function get_user_quote_service_item($quote_id = null)
    {
        if($quote_id){
        	$work_shop_id = $this->session->userdata('work_shop_id');
			$branch_id = $this->session->userdata('branch_id');
            $this->db->select('*');
            $this->db->from('mech_repair_service_items si');
            $this->db->join('mech_service_item_dtls ci', 'ci.msim_id = si.service_item');
            if($this->session->userdata('user_type') == 3){
				$this->db->where('si.workshop_id='.$work_shop_id.'');
			}elseif($this->session->userdata('user_type') == 4){
				$this->db->where('si.workshop_id='.$work_shop_id.' AND si.w_branch_id='.$branch_id.'');
			}
            $this->db->where('si.is_from', 'invoice_service');
            $this->db->where('si.quote_id', $quote_id);
            $service_items = $this->db->get()->result();
        }else{
            $service_items = array();
        }
        //print_r($service_items);
        //exit;
        return json_encode($service_items);
    }
    
    /**
     * @param null $quote_id
     */
    
    public function book($tab=null,$quote_id=null)
    {
        
        
        if ($this->input->post('btn_cancel')) {
            redirect('user_quotes');
        }

        if($quote_id){
            $work_shop_id = $this->session->userdata('work_shop_id');
			$branch_id = $this->session->userdata('branch_id');
        	
			$this->mdl_user_quotes->where('mech_quotes.workshop_id='.$work_shop_id.' AND mech_quotes.w_branch_id='.$branch_id.'');
			$quotes = $this->mdl_user_quotes->where('quote_id='.$quote_id.'')->get()->row();
			
            $this->db->select('*');
            $this->db->from('mech_repair_service_items si');
            $this->db->join('mech_service_item_dtls ci', 'ci.msim_id = si.service_item');
            $this->db->where('si.workshop_id='.$work_shop_id.' AND si.w_branch_id='.$branch_id.'');
			$this->db->where('si.quote_id', $quote_id);
            $service_items = $this->db->get()->result();
			
			$user_details = $this->mdl_clients->get_by_id($quotes->customer_id);
			
			$user_address_list = $this->db->get_where('mech_user_address',array('user_id'=>$quotes->customer_id))->result();
      
        }else{
            $quotes = array();
            $service_items = array();
			$user_details = array();
			$user_address_list = array();
        }
        
        $this->layout->set(array(
            'current_tab' => $tab,
            'quote_detail' => $quotes,
            'service_list' => $service_items,
            //'pincode_list' => $this->db->get_where('mech_area_pincode', array('status' => 'A'))->result(),
            'url_key' => $this->mdl_user_quotes->get_url_key(),
            'car_list' => $this->mdl_user_cars->where('owner_id='.$this->session->userdata('user_id').' AND mech_owner_car_list.status = 1')->get()->result() ,
            'customer_list' => $this->mdl_clients->where('client_active','A')->get()->result(),
            'user_details' => $user_details,
            'user_address_list' => $user_address_list,
            'service_category_list' => $this->db->get_where('mechanic_service_category_list', array('status' => 1))->result(),
            'service_category_items'=>$this->mdl_mech_service_item_dtls->where('status','A')->get()->result(),
            'product_category_items' =>$this->mdl_mech_item_master->get()->result(),
            'popular_service_category_item_list' => $this->db->get_where('mech_service_item_dtls', array('status' => 'A'))->result(),
            'diagnostics_service_category_item_list' => $this->db->get_where('mech_service_item_dtls', array('status' => 'A'))->result(),
            //'drive_types' => $this->db->get_where('mech_drive_types', array('status' => 1))->result()
        )); 
        $this->layout->buffer('content', 'user_quotes/create');
        $this->layout->render();
    }

    /**
     * @param null $quote_id
     */
    public function view($quote_id,$url_from=NULL)
    {
    	if(!$quote_id){
            exit();
        }
            $work_shop_id = $this->session->userdata('work_shop_id');
			$branch_id = $this->session->userdata('branch_id');
        	$this->mdl_user_quotes->where('quote_id='.$quote_id.'');
			if($this->session->userdata('user_type') == 3){
				$this->mdl_user_quotes->where('mech_quotes.workshop_id='.$work_shop_id.'');
			}elseif($this->session->userdata('user_type') == 4){
				$this->mdl_user_quotes->where('mech_quotes.workshop_id='.$work_shop_id.' AND mech_quotes.w_branch_id='.$branch_id.'');
			}
			$quotes = $this->mdl_user_quotes->get()->row();
			
        $this->layout->set(array(
            'quote_id' => $quote_id,
            'url_from' => $url_from,
            'quote_detail' => $quotes,
            'service_list' => $this->get_user_quote_service_item($quote_id, $quotes->customer_id),
            'product_list' => $this->get_user_quote_product_item($quote_id, $quotes->customer_id),
            'service_category_items'=>$this->mdl_mech_service_item_dtls->where('status' , 'A')->get()->result(),
            'product_category_items' =>$this->mdl_mech_item_master->get()->result(),
            'user_address' => $this->mdl_user_address->get_by_id($quotes->pickup_address_id),
            'customer_details' => $this->mdl_clients->get_by_id($quotes->customer_id)
        )); 
        $this->layout->buffer('content', 'user_quotes/view_quote');
        $this->layout->render();
    }

    /**
     * @param null $quote_id
     */
    public function update_user_request_quote($url_from = null, $quote_id = null)
    {
		if(!$quote_id){
            exit();
        }
            $work_shop_id = $this->session->userdata('work_shop_id');
			$branch_id = $this->session->userdata('branch_id');
        	$this->mdl_user_quotes->where('quote_id='.$quote_id.'');
			if($this->session->userdata('user_type') == 3){
				$this->mdl_user_quotes->where('mech_quotes.workshop_id='.$work_shop_id.'');
			}elseif($this->session->userdata('user_type') == 4){
				$this->mdl_user_quotes->where('mech_quotes.workshop_id='.$work_shop_id.' AND mech_quotes.w_branch_id='.$branch_id.'');
			}
			$quotes = $this->mdl_user_quotes->get()->row();
            $customer_id = $quotes->customer_id;

            $this->db->select("*"); 
            $this->db->from('mech_owner_car_list');
            $this->db->join('mech_car_brand_details cb', 'cb.brand_id=mech_owner_car_list.car_brand_id', 'left');
            $this->db->join('mech_car_brand_models_details cm', 'cm.model_id=mech_owner_car_list.car_brand_model_id', 'left');
            $this->db->join('mech_brand_model_variants cv', 'cv.brand_model_variant_id=mech_owner_car_list.car_variant', 'left');
            $this->db->where('owner_id', $customer_id);
            $this->db->where('mech_owner_car_list.status', 1);
            $customer_car_list = $this->db->get()->result();

            $this->db->select("*"); 
            $this->db->from('mech_user_address');
            $this->db->where('user_id', $customer_id);
            $customer_address_list = $this->db->get()->result();

        $this->layout->set(array(
            'quote_id' => $quote_id,
            'url_from' => $url_from,
            'quote_detail' => $quotes,
            'customer_list' => $this->mdl_clients->where('client_active','A')->get()->result(),
            'customer_car_list' => $customer_car_list,
            'customer_address_list' => $customer_address_list,
            'service_list' => $this->get_user_quote_service_item($quote_id, $invoice->customer_id),
            'product_list' => $this->get_user_quote_product_item($quote_id, $invoice->customer_id),
            'service_category_items'=>$this->mdl_mech_service_item_dtls->where('status' , 'A')->get()->result(),
            'product_category_items' =>$this->mdl_mech_item_master->get()->result(),
            'customer_details' => $this->mdl_clients->get_by_id($quotes->customer_id)
        )); 
		
        $this->layout->buffer('content', 'user_quotes/update_user_request_quote');
        $this->layout->render();
		
		
		
		
    }

    /**
     * @param $id
     */
    public function delete()
    {
        $id = $this->input->post('user_car_id');
        $this->mdl_user_cars->delete($id);
        $response = array(
                'success' => 1
            );
        echo json_encode($response);    
    }
    public function generate_pdf($invoice_id=2, $stream = true, $invoice_template = null)
    {
        $this->load->helper('pdf');
        generate_user_quote_pdf($invoice_id, $stream, $invoice_template, null);
    }

}
