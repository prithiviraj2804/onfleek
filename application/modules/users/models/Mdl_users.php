<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Users extends Response_Model
{
    public $table = 'ip_users';
    public $primary_key = 'ip_users.user_id';
    public $date_created_field = 'user_date_created';
    public $date_modified_field = 'user_date_modified';

    public function user_types()
    {
        return array(
            '1' => trans('administrator'),
            '2' => trans('guest_read_only'),
            '3' => trans('menu7'),
            '4' => trans('lable95')
        );
    }

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS ip_users.*', false);
    }

    public function default_order_by()
    {
        $this->db->order_by('ip_users.user_name');
    }

    public function validation_rules()
    {
        return array(
            'emp_id' => array(
                'field' => 'emp_id',
            ),
            'user_type' => array(
                'field' => 'user_type',
                'label' => trans('lable551'),
                'rules' => 'required'
            ),
            'user_email' => array(
                'field' => 'user_email',
                'label' => trans('lable889'),
                'rules' => 'required|valid_email|is_unique[ip_users.user_email]'
            ),
            'user_name' => array(
                'field' => 'user_name',
                'label' => trans('lable193'),
                'rules' => 'required'
            ),
            'user_password' => array(
                'field' => 'user_password',
                'label' => trans('lable890'),
                'rules' => 'required|min_length[8]'
            ),
            'user_passwordv' => array(
                'field' => 'confirm_password',
                'label' => trans('lable196'),
                'rules' => 'required|matches[user_password]'
            ),
            'user_language' => array(
                'field' => 'user_language',
                'label' => trans('lable891'),
                'rules' => 'required'
            ),
            'user_company' => array(
                'field' => 'user_company'
            ),
            'user_address_1' => array(
                'field' => 'user_address_1'
            ),
            'user_address_2' => array(
                'field' => 'user_address_2'
            ),
            'user_city' => array(
                'field' => 'user_city'
            ),
            'user_state' => array(
                'field' => 'user_state'
            ),
            'user_zip' => array(
                'field' => 'user_zip'
            ),
            'user_country' => array(
                'field' => 'user_country',
                'label' => trans('lable892'),
            ),
            'user_phone' => array(
                'field' => 'user_phone'
            ),
            'user_fax' => array(
                'field' => 'user_fax'
            ),
            'user_mobile' => array(
                'field' => 'user_mobile'
            ),
            'user_web' => array(
                'field' => 'user_web'
            ),
            'user_vat_id' => array(
                'field' => 'user_vat_id'
            ),
            'user_tax_code' => array(
                'field' => 'user_tax_code'
            ),
            'user_subscribernumber' => array(
                'field' => 'user_subscribernumber'
            ),
            'user_iban' => array(
                'field' => 'user_iban'
            ),
            # SUMEX
            'user_gln' => array(
                'field' => 'user_gln'
            ),
            'user_rcc' => array(
                'field' => 'user_rcc'
            ),
            'workshop_id' => array(
                'field' => 'workshop_id'
            ),
            'branch_id' => array(
                'field' => 'branch_id'
            )
        );
    }

    public function validation_rules_existing()
    {
        return array(
            'emp_id' => array(
                'field' => 'emp_id',
            ),
            'user_type' => array(
                'field' => 'user_type',
                'label' => trans('lable551'),
                'rules' => 'required'
            ),
            'user_email' => array(
                'field' => 'user_email',
                'label' => trans('lable889'),
                'rules' => 'required|valid_email'
            ),
            'user_name' => array(
                'field' => 'user_name',
                'label' => trans('lable193'),
                'rules' => 'required'
            ),
            'user_language' => array(
                'field' => 'user_language',
                'label' => trans('lable891'),
                'rules' => 'required'
            ),
            'user_company' => array(
                'field' => 'user_company'
            ),
            'user_address_1' => array(
                'field' => 'user_address_1'
            ),
            'user_address_2' => array(
                'field' => 'user_address_2'
            ),
            'user_city' => array(
                'field' => 'user_city'
            ),
            'user_state' => array(
                'field' => 'user_state'
            ),
            'user_zip' => array(
                'field' => 'user_zip'
            ),
            'user_country' => array(
                'field' => 'user_country',
                'label' => trans('lable892'),
            ),
            'user_phone' => array(
                'field' => 'user_phone'
            ),
            'user_fax' => array(
                'field' => 'user_fax'
            ),
            'user_mobile' => array(
                'field' => 'user_mobile'
            ),
            'user_web' => array(
                'field' => 'user_web'
            ),
            'user_vat_id' => array(
                'field' => 'user_vat_id'
            ),
            'user_tax_code' => array(
                'field' => 'user_tax_code'
            ),
            'user_subscribernumber' => array(
                'field' => 'user_subscribernumber'
            ),
            'user_iban' => array(
                'field' => 'user_iban'
            ),
            # SUMEX
            'user_gln' => array(
                'field' => 'user_gln'
            ),
            'user_rcc' => array(
                'field' => 'user_rcc'
            )
        );
    }

    public function validation_rules_change_password()
    {
        return array(
            'user_password' => array(
                'field' => 'user_password',
                'label' => trans('lable890'),
                'rules' => 'required'
            ),
            'user_passwordv' => array(
                'field' => 'user_passwordv',
                'label' => trans('lable196'),
                'rules' => 'required|matches[user_password]'
            )
        );
    }

    public function signup_rules()
    {
        return array(
            'emp_id' => array(
                'field' => 'emp_id',
            ),          
            'user_email	' => array(
                'field' => 'user_email',
                'label' => trans('lable889'),
                'rules' => 'required'
            ),
            'user_mobile' => array(
        		'field' => 'user_mobile',
        		'label' => trans('lable893'),
                'rules' => 'required|trim|strip_tags|numeric'
            ),
            'user_company' => array(
                'field' => 'user_company',
                // 'label' => trans('lable193'),
                'rules' => 'required'
            ),
            'user_name' => array(
                'field' => 'user_name',
                'label' => trans('lable193'),
                'rules' => 'required'
            ),
            'user_password' => array(
                'field' => 'user_password',
                'label' => trans('lable890'),
                'rules' => 'required'
            ),
            'user_passwordv' => array(
                'field' => 'user_passwordv',
                'label' => trans('lable196'),
                'rules' => 'required|matches[user_password]'
            ),
        	 '_mm_csrf' => array(
                'field' => '_mm_csrf'
            )
        );
    }

    public function signup_update_rules()
    {
        return array(
            'emp_id' => array(
                'field' => 'emp_id',
            ), 
            'user_name' => array(
                'field' => 'user_name',
                'label' => trans('lable193'),
                'rules' => 'required'
            ),
            'user_password' => array(
                'field' => 'user_password',
                'label' => trans('lable890'),
                'rules' => 'required'
            ),
            'user_passwordv' => array(
                'field' => 'user_passwordv',
                'label' => trans('lable196'),
                'rules' => 'required|matches[user_password]'
            ),
        	 '_mm_csrf' => array(
                'field' => '_mm_csrf'
            )
        );
    }

	public function update_user_details_validation_rules()
    {
        return array(            
            'user_email	' => array(
                'field' => 'user_email',
                'label' => trans('lable889'),
                'rules' => 'required|valid_email|trim|strip_tags'
            ),
            'user_name' => array(
                'field' => 'user_name',
                'label' => trans('lable193'),
                'rules' => 'required'
            ),
            'user_type' => array(
                'field' => 'user_type',
                'label' => trans('lable551'),
                'rules' => 'required'
            ),
            'user_mobile' => array(
        		'field' => 'user_mobile',
        		'label' => trans('lable893'),
                'rules' => 'required|trim|strip_tags|numeric'
            ),
            'user_company' => array(
                'field' => 'user_company',
                // 'label' => trans('lable193'),
                // 'rules' => 'required'
            ),
        	'user_phone' => array(
        		'field' => 'user_phone',
        		'label' => trans('lable894'),
                'rules' => 'trim|strip_tags|numeric'
        	),
        	'user_active' =>array(
        		'field' => 'user_active',
        		'label' => trans('lable895'),
        		'rules' => 'required'
        	),
        	 '_mm_csrf' => array(
                'field' => '_mm_csrf'
            )
        );
    }

    public function db_array()
    {
        $db_array = parent::db_array();

        if (isset($db_array['user_password'])) {
            unset($db_array['user_passwordv']);

            $this->load->library('crypt');

            $user_psalt = $this->crypt->salt();

            $db_array['user_psalt'] = $user_psalt;
            $db_array['user_password'] = $this->crypt->generate_password($db_array['user_password'], $user_psalt);
        }

        return $db_array;
    }

    public function save_change_password($user_id, $password)
    {
        $this->load->library('crypt');

        $user_psalt = $this->crypt->salt();
        $user_password = $this->crypt->generate_password($password, $user_psalt);

        $db_array = array(
            'user_psalt' => $user_psalt,
            'user_password' => $user_password
        );

        $this->db->where('user_id', $user_id);
        $this->db->update('ip_users', $db_array);

        $this->session->set_flashdata('alert_success', trans('password_changed'));

        return $user_id;
    }

    public function save($id = null, $db_array = null)
    {
        $id = parent::save($id, $db_array);
        if ($user_clients = $this->session->userdata('user_clients')) {
            $this->load->model('users/mdl_user_clients');

            foreach ($user_clients as $user_client) {
                $this->mdl_user_clients->save(null, array('user_id' => $id, 'client_id' => $user_client));
            }

            $this->session->unset_userdata('user_clients');
        }

        return $id;
    }

    public function delete($id)
    {
        parent::delete($id);
        $this->load->helper('orphan');
        delete_orphans();
    }

    public function user_module_permission(){
        $return =  $this->db->query("SELECT mmp.permission_id,mmp.user_id,mmp.workshop_id,mm.module_id,mmp.status,mm.module_name,mm.module_label FROM mech_module_permission AS mmp LEFT JOIN mech_modules mm ON mm.module_id = mmp.module_id WHERE mmp.status = 1 AND mm.status = 'A' AND mmp.workshop_id = ".$this->session->userdata('work_shop_id')." AND mmp.user_id = ".$this->session->userdata('user_id')."")->result();
        return $return;
    }

    public function getusername($user_id){
        
		$this->db->select('user_name');
    	$this->db->where('user_id', $user_id);
    	$users = $this->db->get('ip_users');
    	 
    	if ($users->num_rows()) {
    		$user_name = $users->row()->user_name;
    	} else {
    		$user_name = '-';
    	}
    
    	return $user_name;
    }
    
    public function checkipuserMobile($mob_no){
        $this->db->select('ip_users.user_mobile');
        $this->db->from('ip_users'); 
        $this->db->where('ip_users.user_mobile' , $mob_no);
        return $this->db->get()->result();
    }

    public function checkipuseremail($email){
        $this->db->select('ip_users.user_email');
        $this->db->from('ip_users');
        $this->db->where('ip_users.user_email' , $email);
        return $this->db->get()->result();
    }

}