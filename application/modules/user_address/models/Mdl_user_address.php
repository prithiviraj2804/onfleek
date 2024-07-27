<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_User_Address extends Response_Model
{
    public $table = 'mech_user_address';
    public $primary_key = 'mech_user_address.user_address_id';
	public $date_created_field = 'created_on';
    public $date_modified_field = 'modified_on';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS mech_user_address.user_address_id, mech_user_address.user_id, mech_user_address.workshop_id,
        mech_user_address.w_branch_id, mech_user_address.entity_type, mech_user_address.full_address,
        mech_user_address.customer_street_1, mech_user_address.customer_street_2, mech_user_address.area,
        mech_user_address.customer_city, mech_user_address.customer_state, mech_user_address.customer_country,
        mech_user_address.zip_code, mech_user_address.address_area_id, mech_user_address.is_default,
        mech_user_address.long_latitude, mech_user_address.address_type,
        cl.name as country_name,msl.state_name,cil.city_name', false);
    }
	public function default_join()
    {
        $this->db->join('country_lookup cl','cl.id = mech_user_address.customer_country','left');
        $this->db->join('mech_state_list msl','msl.state_id = mech_user_address.customer_state','left');
        $this->db->join('city_lookup cil','cil.city_id = mech_user_address.customer_city','left');
    }
    public function default_order_by()
    {
        $this->db->order_by('mech_user_address.user_address_id', "desc");
    }
	 public function default_where()
    {
        $this->db->where('mech_user_address.status', '1');
    }

    public function validation_rules()
    {
        return array(
            'user_id' => array(
                'field' => 'user_id',
                'rules' => 'required'
            ),
            'is_default' => array(
                'field' => 'is_default',
                'label' => trans('lable69')
            ),
            'address_type' => array(
                'field' => 'address_type',
                'label' => trans('lable63'),
                'rules' => 'required'
            ),
            'entity_type' => array(
                'field' => 'entity_type',
                'rules' => 'required'
            ),
            'customer_country' => array(
                'field' => 'customer_country',
                'label' => trans('lable86'),
                'rules' => 'required'
            ),
            'customer_state' => array(
                'field' => 'customer_state',
                'label' => trans('lable87'),
                'rules' => 'required'
            ),
            'customer_city' => array(
                'field' => 'customer_city',
                'label' => trans('lable88'),
                'rules' => 'required'
            ),
            'customer_street_1' => array(
                'field' => 'customer_street_1',
                'label' => trans('lable85'),
            ),
            'customer_street_2' => array(
                'field' => 'customer_street_2',
                'label' => trans('lable85'),
            ),
            'zip_code' => array(
                'field' => 'zip_code',
                'label' => trans('lable89'),
                'rules' => 'required'
            ),
            'area' => array(
                'field' => 'area',
                'label' => trans('lable899'),
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
		unset($db_array['_mm_csrf']);
        if ($db_array['is_default'] == 'Y') {   
            $this->db->select("*");	
            $this->db->from('mech_user_address');
            $this->db->where('workshop_id',$this->session->userdata('work_shop_id'));
            $this->db->where('w_branch_id',$this->session->userdata('branch_id'));
            $this->db->where('status',0);
            $list = $this->db->get()->result();

            foreach($list as $ls){
                if($ls->is_default == 'Y'){
                    $data = array ('is_default' => 'N');
                    $this->db->where('user_address_id',$ls->user_address_id);
                    $this->db->update('mech_user_address',$data);
                }
            }
        } 
        
		unset($db_array['address_id']);
		$db_array['workshop_id'] = $this->session->userdata('work_shop_id');
    	$db_array['w_branch_id'] = $this->session->userdata('branch_id');
    	$db_array['created_by'] = $this->session->userdata('user_id');
    	$db_array['modified_by'] = $this->session->userdata('user_id');
        return $db_array;
    }

	public function save($id = null, $db_array = null)
    {
    	$this->update_default_address_flag($this->input->post('is_default'));
        $db_array = ($db_array) ? $db_array : $this->db_array();
        $id = parent::save($id, $db_array);

        return $id;
    }

    public function save_my_address($data,$id = null){

        if($id){
            $this->db->where('user_address_id',$id);
            $this->db->update('mech_user_address',$data);
            $user_car_id = $id;
        } else {
            $this->db->insert('mech_user_address', $data);
            $user_car_id = $this->db->insert_id();    
        }

            $response = array(
                'success' => 1,
                'id'=>$user_car_id
            );

            return $response;
    
    }

    public function remove_my_address($id){
        $this->db->where('user_address_id',$id);
        $this->db->update('mech_user_address',array("status"=>'2'));
    }
	public function update_default_address_flag($is_default){
		$user_id = $this->session->userdata('user_id');
        $this->db->where('user_id',$user_id);
        $this->db->update('mech_user_address',array("is_default"=>'N'));
    }

	public function get_user_total_address()
	{
		if($this->session->userdata('user_type') != 1){
			$this->db->where('user_id', $this->session->userdata('user_id'));
		}
		
		$this->db->where('status', 'A');
    	$address_data = $this->db->get('mech_user_address');
		return count($address_data->result());
	}
	public function get_user_complete_address($user_address_id)
	{
		$this->mdl_user_address->where('user_address_id', $user_address_id);
        $address = $this->mdl_user_address->get()->row();
        $finalAddress = ($address->customer_street_1?$address->customer_street_1:"")." ".($address->customer_street_2?", ".$address->customer_street_2:"")." ".($address->area?", ".$address->area:"")." ".($address->city_name?", ".$address->city_name:"")." ".($address->state_name?", ".$address->state_name:"")." ".($address->country_name?", ".$address->country_name:"")." ".($address->zip_code?", ".$address->zip_code:"");
		return $finalAddress;
	}
	public function get_user_address_id($user_address_id)
	{   
		$this->db->select("user_address_id");	
		$this->db->from('mech_user_address add');
		$this->db->where('user_address_id', $user_address_id);
		return $this->db->get()->row()->user_address_id;
	}
}