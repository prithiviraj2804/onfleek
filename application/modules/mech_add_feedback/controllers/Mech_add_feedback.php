<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mech_add_feedback extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
       $this->load->model('mdl_mech_postfeedback');
       $this->load->model('mech_employee/mdl_mech_employee');
    } 

    public function index($page = 0)
    {
        $limit = 15;
        $query = $this->mdl_mech_postfeedback->get();
        $rowCount = $query->num_rows();
        $pagConfig = array(
            'totalRows' => $rowCount,
            'perPage' => $limit,
            'link_func' => 'searchFilter'
        );
        $pagination = new Pagination($pagConfig);
        $createLinks = $pagination->createLinks();
        $this->mdl_mech_postfeedback->limit($limit);
        $feedback = $this->mdl_mech_postfeedback->get()->result();

		$this->layout->set(
            array(
                'feedback' => $feedback,
                'createLinks' => $createLinks,
            )
        );

        $this->layout->buffer('content', 'mech_add_feedback/index');
        $this->layout->render();
    }

    public function form($fb_id = null, $tab = null)
    {
        if($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_mech_postfeedback->prep_form($id)) {
                show_404();
            }
			$breadcrumb = "lable1188";
        }else{
        	$breadcrumb = "lable1188";
        }

        $feedback_details = $this->mdl_mech_postfeedback->where('fb_id', $fb_id)->get()->row();

        if($fb_id){
            $comments = $this->db->select("mech_feedback_comments.feedback_comment_id,mech_feedback_comments.entity_id,mech_feedback_comments.comments,mech_feedback_comments.reschedule,mech_feedback_comments.reschedule_date,mech_feedback_comments.created_on,ip_users.user_name")->from('mech_feedback_comments')->where('mech_feedback_comments.entity_id',$fb_id)->where('mech_feedback_comments.entity_type','FB')->where('mech_feedback_comments.status','A')->join('ip_users', 'ip_users.user_id = mech_feedback_comments.created_by')->order_by("mech_feedback_comments.feedback_comment_id","desc")->get()->result();
        }else{
            $comments = array();
        }
		$this -> layout -> set(array(
            'active_tab' => $tab,
            'breadcrumb' => $breadcrumb,
            'comments' => $comments,
            'feedback_details' => $feedback_details,
            'assigned_to' => $this->mdl_mech_employee->get()->result(),
            ));
        $this->layout->buffer('content', 'mech_add_feedback/form');
        $this->layout->render();
    }

    public function delete_feedback_comments(){
        $id = $this->input->post('id');
        $this->db->set('status','D');
        $this->db->where('feedback_comment_id', $id);
        $this->db->update('mech_feedback_comments');
        $response = array(
            'success' => 1
        );
        echo json_encode($response);
    }
}

