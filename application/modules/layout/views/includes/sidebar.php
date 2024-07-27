<?php if($this->session->userdata('user_type') == 1){
	$this->load->view('admin_sidebar');
}elseif($this->session->userdata('user_type') == 2){
	$this->load->view('user_sidebar');
}elseif($this->session->userdata('user_type') == 3){
	$this->load->view('workshop_sidebar');
}elseif($this->session->userdata('user_type') == 4){
	$this->load->view('branch_sidebar');
}elseif($this->session->userdata('user_type') == 5){
	$this->load->view('workshop_sidebar');
}elseif($this->session->userdata('user_type') == 6){
	$this->load->view('workshop_sidebar');
} ?>