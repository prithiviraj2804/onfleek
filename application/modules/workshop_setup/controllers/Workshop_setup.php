<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Workshop_Setup extends Admin_Controller
{
    
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_workshop_setup');
        $this->load->model('workshop_branch/mdl_workshop_branch');
        $this->load->model('mech_bank_list/mdl_mech_bank_list');
        $this->load->model('mech_invoice_groups/mdl_mech_invoice_groups');
        $this->load->model('payment_methods/mdl_payment_methods');
        $this->load->model('email_templates/mdl_email_templates');
        $this->load->model('mech_referral/mdl_mech_referral');
        $this->load->model('mech_rewards/mdl_mech_rewards');
        $this->load->model('mech_vehicle_type/mdl_mech_vehicle_type');
        $this->load->model('tax_rates/mdl_tax_rates');
        
    }

    public function index($tab = NULL)
    {
       
        if ($this->session->userdata('user_type') == 1) {
            $this->mdl_workshop_setup->paginate(site_url('workshop_setup/index'), $page);
            $workshop_setup = $this->mdl_workshop_setup->result();
            $this->layout->set('workshop_setup', $workshop_setup);
            $this->layout->buffer('content', 'workshop_setup/index');

        } elseif ($this->session->userdata('user_type') == 3) {
            $workshop_details = $this->mdl_workshop_setup->where('workshop_setup.workshop_id', $this->session->userdata('work_shop_id'))->get()->row();
            $workshop_branch_list = $this->mdl_workshop_branch->where('workshop_id', $this->session->userdata('work_shop_id'))->get()->result();
            $workshop_bank_list = $this->mdl_mech_bank_list->where('mech_workshop_bank_list.workshop_id', $this->session->userdata('work_shop_id'))->where_in('mech_workshop_bank_list.module_type', array('B', 'W'))->get()->result();

            if($this->session->userdata('is_new_user') == 'O'){
                $this->mdl_mech_invoice_groups->where('module_type != "appointment"');
                $this->mdl_mech_invoice_groups->where('module_type != "leads"');
                $invoice_groups = $this->mdl_mech_invoice_groups->get()->result();
                $get_count = $this->mdl_mech_invoice_groups->get_invoice_group_type_count();
                $creation_check = $this->mdl_mech_invoice_groups->check_invoice_group_validity();
                $payment_methods = $this->mdl_payment_methods->get()->result();
            }else{
                $invoice_groups = array();
                $get_count = array();
                $creation_check = array();
                $payment_methods = array();
            }
            
            $state_list = $this->mdl_settings->getStateList($workshop_details->workshop_country);
            $city_list = $this->mdl_settings->getCityList($workshop_details->workshop_state);
            $sub_deplan_list = $this->db->query('SELECT * FROM mech_subscription_details where plan_status = "D" and workshop_id = '.$this->session->userdata('work_shop_id').'')->result();
            $sub_acplan_list = $this->db->query('SELECT * FROM mech_subscription_details where plan_status = "A" and workshop_id = '.$this->session->userdata('work_shop_id').'')->row();

           
            $this->mdl_email_templates->paginate(site_url('email_templates/index'), $page);
            $email_templates = $this->mdl_email_templates->result();

            $this->mdl_tax_rates->paginate(site_url('tax_rates/index'), $page);
            $tax_rates = $this->mdl_tax_rates->result();
            if(count($tax_rates) > 0){
                foreach($tax_rates as $taxRateKey => $tax_rate){
                    if(!empty($tax_rate->module_id)){
                        $moduleidarray = explode(',', $tax_rate->module_id); 
                        $module_name = array();
                        for ($i = 0; $i < count($moduleidarray); $i++) {
                            $this->db->select('module_label');
                            $this->db->from('mech_modules');
                            $this->db->where('module_id' , $moduleidarray[$i]);
                            $word = $this->db->get()->row()->module_label;
                            array_push($module_name, $word);

                        } 
                    }
                    $tax_rates[$taxRateKey]->module_name = $module_name; 
                }
            }

            $this->db->select('*');
            $this->db->from('mech_tax');
            $this->db->where('status' , 'A');
            $this->db->where_in('workshop_id', array('1', $this->session->userdata('work_shop_id')));
            $tax_list = $this->db->get()->result();

            $this->layout->set(
                array(
                    'active_tab' => $tab,
                    'workshop_id' => $this->session->userdata('work_shop_id'),
                    'currency_list' => $this->db->query('SELECT * FROM mech_currency_list')->result(),
                    'country_list' => $this->db->query('SELECT * FROM country_lookup')->result(),
                    'state_list' => $state_list,
                    'city_list' => $city_list,
                    'payment_methods' => $payment_methods,
                    'workshop_details' => $workshop_details,
                    'workshop_branch_list' => $workshop_branch_list,
                    'workshop_bank_list' => $workshop_bank_list,
                    'invoice_groups' => $invoice_groups,
                    'get_count' => $get_count,
                    'creation_check' => $creation_check,
                    'mech_referrals' => $this->mdl_mech_referral->get()->result(),
                    'mech_rewards' => $this->mdl_mech_rewards->get()->result(),
                    'email_templates' => $email_templates,
                    'tax_rates' => $tax_rates,
                    'date_list' => $this->db->query('SELECT * FROM mech_date_list where status = "A"')->result(),
                    'notification_list' => $this->db->query('SELECT * FROM mech_notification_list where status = "A" ')->result(),
                    'notification_setup' => $this->db->query('SELECT * FROM mech_notification_setup where workshop_id = '.$this->session->userdata('work_shop_id').'')->result(),
                    'jobcard_status' => $this->db->query('SELECT * FROM mech_jobcard_status where status = "A"')->result(),
                    'invoice_status' => $this->db->query('SELECT * FROM mech_invoice_status where status = "A"')->result(),
                    'mech_vehicle_type_list' => $this->mdl_mech_vehicle_type->get()->result(),
                    'vehicle_model_type' => $this->mdl_mech_vehicle_type->get()->result(),
                    'plan_list' => $this->db->query('SELECT * FROM mech_plan_table ORDER BY plan_name')->result(),
                    'sub_deplan_list' => $sub_deplan_list,
                    'sub_acplan_list' => $sub_acplan_list,
                    'tax_list' => $tax_list,
                )
            );

            $this->layout->buffer('content', 'workshop_setup/profile');

        }

        $this->layout->render();
    }

    public function form($workshop_id = null)
    {
        $this->load->model('workshop_branch/mdl_workshop_branch');
        $this->load->model('users/mdl_users');
        $this->load->helper('country');
        $this->load->model('settings/mdl_settings');
      
        if($workshop_id && $this->input->post('btn_submit')){
            if (!$this->mdl_workshop_setup->prep_form($workshop_id)){
                show_404();
            }
            $this->mdl_workshop_setup->set_form_value('is_update', true);
            if ($this->mdl_workshop_setup->form_value('workshop_country', true)) {
                $state_list = $this->mdl_settings->getStateList($this->mdl_workshop_setup->form_value('workshop_country', true));
            } else {
                $state_list = array();
            }

            if ($this->mdl_workshop_setup->form_value('workshop_state', true)) {
                $city_list = $this->mdl_settings->getCityList($this->mdl_workshop_setup->form_value('workshop_state', true));
            } else {
                $city_list = array();
            }
        } else {
            $state_list = array();
            $city_list = array();
        }

        $this->layout->set(
            array(
                'workshop_id' => $workshop_id,
                'country_list' => $this->db->query('SELECT * FROM country_lookup')->result(),
                'state_list' => $state_list,
                'city_list' => $city_list,
                //'pincode_list' => $this->db->get_where('mech_area_pincode', array('status' => 'A'))->result(),
            ));

        $this->layout->buffer('content', 'workshop_setup/form');
        $this->layout->render();
    }

    public function delete($id)
    {
        $this->mdl_workshop_setup->delete($id);
        redirect('workshop_setup');
    }

    public function delete_log($id, $path)
    {
        $img_base_url = './uploads/workshop_logo';
        $file = $img_base_url.'/'.$path;
        unlink($file);
        $this->db->where('workshop_id', $id);
        $this->db->update('workshop_setup', array('workshop_logo' => null));
        redirect('workshop_setup');
    }
}