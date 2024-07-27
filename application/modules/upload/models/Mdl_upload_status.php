<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_upload_status extends Response_Model
{
    public $table = 'tc_tmp_upload_status';
    public $primary_key = 'tc_tmp_upload_status.upload_id';
    public $date_modified_field = 'modified_on';
    

    public function get_upload_status($type) {
        $get_details = $this->db->select('*')->from('tc_tmp_upload_status')->where(array('workshop_id' => $this->session->userdata('work_shop_id'),'user_id' => $this->session->userdata('user_id'),'upload_type' => $type))->get()->result();
        return $get_details;
    }
    public function success_upload_count($type) {
        $success_count = $this->db->select('count(status)')->from('tc_tmp_upload_status')->where(array('workshop_id' => $this->session->userdata('work_shop_id'),'user_id' => $this->session->userdata('user_id'),'upload_type' => $type,'status' => 'success'))->get()->result();
        return $success_count;
    }
    public function failed_upload_count($type) {
        $failed_count = $this->db->select('count(status)')->from('tc_tmp_upload_status')->where(array('workshop_id' => $this->session->userdata('work_shop_id'),'user_id' => $this->session->userdata('user_id'),'upload_type' => $type,'status' => 'failed'))->get()->result();
        return $failed_count;
    }
    public function insert_upload_status($data = NULL){
        $data['workshop_id'] =  $this->session->userdata('work_shop_id');
        $data['user_id'] = $this->session->userdata('user_id');
        $data['created_on'] = date('Y-m-d H:i:s');
        $this->db->insert('tc_tmp_upload_status', $data);
    }
    public function delete_upload_status($type){
        $data = array(
            'workshop_id' => $this->session->userdata('workshop_id'),
            'user_id' => $this->session->userdata('user_id'),
            'upload_type' => $type
        );
        $this->db->delete('tc_tmp_upload_status', $data);
    }
}
