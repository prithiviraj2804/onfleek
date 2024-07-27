<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('mech_add_feedback/mdl_mech_postfeedback');
        $this->load->helper('settings_helper');
        $this->load->model('settings/mdl_settings');
        $this->load->model('sessions/mdl_sessions');
        $this->load->helper('mailer/phpmailer');
        $this->load->helper('mailer');
        $this->load->helper('date_helper');
        $this->load->model('mech_employee/mdl_mech_employee');	
    }

    public function status_update()
    {
        $fb_id = $this->input->post('fb_id');
        $fd_status = $this->input->post('fd_status');

        if ($fb_id) {
            
            $data = array(
                'fd_status' => $fd_status,
                'workshop_id' => $this->session->userdata('work_shop_id'),
                'modified_by' => $this->session->userdata('user_id'),
                );

                $this->db->where('fb_id',$fb_id);
                $this->db->update('mech_postfeedback',$data);

            $response = array(
                'success' => 1,
                'fb_id'=>$fb_id,
            );
        } else {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
        }

        echo json_encode($response);
    }

    public function save_comments(){

		if($this->input->post('feedback_comment_id')){
			$updatedata = array(
				'comments' =>  $this->input->post('comments')?strip_tags($this->input->post('comments')):NULL,
				'reschedule' =>  $this->input->post('reschedule')?strip_tags($this->input->post('reschedule')):NULL,
				'reschedule_date' =>  $this->input->post('reschedule_date')?date("Y-m-d H:i:s", strtotime($this->input->post('reschedule_date'))):NULL,
				'modified_by' => $this->session->userdata('user_id'),
			);
			$this->db->where('feedback_comment_id ',$this->input->post('feedback_comment_id'));
			$id = $this->db->update('mech_feedback_comments', $updatedata);

		}else{
			$insertData = array(
				'entity_id' => $this->input->post('fb_id'),
				'entity_type' => $this->input->post('entity_type'),
				'comments' => $this->input->post('comments')?strip_tags($this->input->post('comments')):NULL,
				'reschedule' =>  $this->input->post('reschedule')?strip_tags($this->input->post('reschedule')):NULL,
				'reschedule_date' =>  $this->input->post('reschedule_date')?date("Y-m-d h:i:s", strtotime($this->input->post('reschedule_date'))):NULL,
				'workshop_id' => $this->session->userdata('work_shop_id'),
				'w_branch_id' => $this->session->userdata('branch_id'),
				'created_by' => $this->session->userdata('user_id'),
				'modified_by' => $this->session->userdata('user_id'),
				'created_on' => date('Y-m-d H:i:s'),
			);

			$this->db->insert('mech_feedback_comments', $insertData);
			$id = $this->db->insert_id();
		}

		if($this->input->post('reschedule') == 'Y'){
			if($this->input->post('reschedule_date')){
				$this->db->where('fb_id',$this->input->post('fb_id'));
				$fb_id = $this->db->update('mech_postfeedback', array(
					'reschedule_date' => $this->input->post('reschedule_date')?date("Y-m-d h:i:s", strtotime($this->input->post('reschedule_date'))):NULL
				));
			}
		}

		if($id){
			$response = array(
				'success' => 1
			);
		}else{
			$response = array(
				'success' => 0
			);
		}
		echo json_encode($response);
	}

    public function get_comments(){

		$entity_id = $this->input->post('entity_id');	
		$comments = $this->db->select("mech_feedback_comments.feedback_comment_id,mech_feedback_comments.entity_id,mech_feedback_comments.comments,mech_feedback_comments.reschedule,mech_feedback_comments.reschedule_date,mech_feedback_comments.created_on,ip_users.user_name")->from('mech_feedback_comments')->where('mech_feedback_comments.entity_id',$entity_id)->where('mech_feedback_comments.entity_type','FB')->where('mech_feedback_comments.status','A')->join('ip_users', 'ip_users.user_id = mech_feedback_comments.created_by')->order_by("mech_feedback_comments.feedback_comment_id","desc")->get()->result();
  
		if(!empty($comments)){
			$response = array(
				'success' => 1,
				'comments' => $comments,
			);
		}else{
			$response = array(
				'success' => 0
			);
		}

		echo json_encode($response);
	}

    public function get_Comment_detials(){
		$feedback_comment_id = $this->input->post('feedback_comment_id');	
		$comments = $this->db->from('mech_feedback_comments')->where('mech_feedback_comments.feedback_comment_id',$feedback_comment_id)->where('mech_feedback_comments.entity_type','FB')->where('mech_feedback_comments.status','A')->order_by("mech_feedback_comments.feedback_comment_id","desc")->get()->row();
		$assigned_to = $this->mdl_mech_employee->get()->result();
		if(!empty($comments)){
			$response = array(
				'success' => 1,
				'comments' => $comments,
				'assigned_to' => $assigned_to
			);
		}else{
			$response = array(
				'success' => 0
			);
		}

		echo json_encode($response);
	}

    public function modal_add_feedback($invoice_id = NULL){
		$this->load->module('layout');
		$work_shop_id = $this->session->userdata('work_shop_id');
		$branch_id = $this->session->userdata('branch_id');

		if($invoice_id){

			$this->db->select('*');
            $this->db->from('mech_postfeedback');
			$this->db->where('workshop_id' , $work_shop_id);
			$this->db->where('w_branch_id' , $branch_id );
            $this->db->where('invoice_id', $invoice_id);
			$feedback_details = $this->db->get()->row();

			if(empty($feedback_details)){
				$feedback_details = array();
			}

			$feed_back = $this->db->query('SELECT * FROM ip_invoice_groups where module_type = "feedback" ORDER BY invoice_group_id ASC LIMIT 1')->row();

			$data = array(
				'feedback_details' => $feedback_details,
				'feedback' => $feed_back,
				'invoice_id' => $invoice_id,
			);
			$this->layout->load_view('mech_add_feedback/modal_add_feedback', $data);
		}
	}

	public function add_feedback(){

		$this->load->model('mech_add_feedback/mdl_mech_postfeedback');
		
		if($this->input->post('fb_id')){
			$fb_id = $this->input->post('fb_id');
		}else{
			$fb_id = NULL;
		}

		if($this->mdl_mech_postfeedback->run_validation('validation_rules')){
			$feed_back_no = $this->input->post('feedback_no');
			
			if(empty($feed_back_no)){
				$feedback_no = $this->mdl_settings->get_invoice_number($this->input->post('invoice_group_id'));
				$_POST['feedback_no'] = $feedback_no;
			}

			$_POST['fd_status'] = 'N';

			$fb_id = $this->mdl_mech_postfeedback->save($fb_id);

			$response = array(
                'success' => 1,
                'fb_id' => $fb_id,
            );
		}else{
			$this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors(),
            );
		}
		echo json_encode($response);
		exit();

	}

    public function get_filter_list(){

        $start = !empty($this->input->post('page'))?$this->input->post('page'):0;
        $limit = 15;

        if($this->input->post('from_date')){  
            $this->mdl_mech_postfeedback->where('Cast(mech_postfeedback.reschedule_date as Date) >=',date_to_mysql($this->input->post('from_date')));
        }
        
        if($this->input->post('to_date')){
            $this->mdl_mech_postfeedback->where('Cast(mech_postfeedback.reschedule_date as Date) <=',date_to_mysql($this->input->post('to_date')));
        }
  
        if($this->input->post('feedback_no')){
            $this->mdl_mech_postfeedback->like('mech_postfeedback.feedback_no',$this->input->post('feedback_no'));
        }

        if($this->input->post('invoice_no')){
            $this->mdl_mech_postfeedback->where('mech_postfeedback.invoice_id', $this->input->post('invoice_no'));
        }
       
        $rowCount = $this->mdl_mech_postfeedback->get()->result();
        $rowCount = count($rowCount);
        $pagConfig = array(
            'currentPage' => $start,
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination =  new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();

        if($this->input->post('from_date')){  
            $this->mdl_mech_postfeedback->where('Cast(mech_postfeedback.reschedule_date as Date) >=',date_to_mysql($this->input->post('from_date')));
        }
        
        if($this->input->post('to_date')){
            $this->mdl_mech_postfeedback->where('Cast(mech_postfeedback.reschedule_date as date) <=',date_to_mysql($this->input->post('to_date')));
        }
  
        if($this->input->post('feedback_no')){
            $this->mdl_mech_postfeedback->like('mech_postfeedback.feedback_no',$this->input->post('feedback_no'));
        }

        if($this->input->post('invoice_no')){
            $this->mdl_mech_postfeedback->where('mech_postfeedback.invoice_id', $this->input->post('invoice_no'));
        }

        $this->mdl_mech_postfeedback->limit($limit,$start);
        $feedback = $this->mdl_mech_postfeedback->get()->result();

        $response = array(
            'success' => 1,
            'feedback' => $feedback, 
            'createLinks' => $createLinks,
        );
        echo json_encode($response);

    }

}