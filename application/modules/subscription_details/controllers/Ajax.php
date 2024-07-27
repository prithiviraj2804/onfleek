<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public $ajax_controller = true;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('subscription_details/mdl_subscription_details');
        $this->load->helper('settings_helper');
        $this->load->model('settings/mdl_settings');
        $this->load->model('sessions/mdl_sessions');
        $this->load->helper('mailer/phpmailer');
        $this->load->helper('mailer');
        $this->load->helper('date_helper');
    }

    public function create()
    {
        if($this->session->userdata('work_shop_id')){
            $workshop_id = $this->session->userdata('work_shop_id');
        }else{
            $workshop_id = NULL;
        } 

        $invoice_group_id = $this->input->post('invoice_group_id');
        $invoice_no = $this->mdl_settings->get_superadmin_invoice_number($invoice_group_id);

        
        if ($workshop_id) {
            $plan_id = $this->input->post('plan_id');
            $plan_month_type = $this->input->post('plan_month_type');
            $check_plan_list = $this->db->query('SELECT * FROM mech_subscription_details where plan_status = "A" and workshop_id = '.$workshop_id.' ORDER BY subscription_id DESC LIMIT 1')->row();
            
            $plan_to_date = $check_plan_list->to_date;
            $plan_from_date = $check_plan_list->from_date;
            $plan_sub_id = $check_plan_list->subscription_id;
            $current_dt = date('Y-m-d');

            if($plan_month_type == 1){
                $days = 30;
            }else if($plan_month_type == 3){
                $days = 90;
            }else if($plan_month_type == 6){
                $days = 180;
            }else if($plan_month_type == 12){
                $days = 365;
            }

            if($plan_to_date > $current_dt){
                $new_exp_dt = date('Y-m-d', strtotime($plan_to_date. ' + '. $days .' days'));
            }else{
                $new_exp_dt = date('Y-m-d', strtotime($current_dt. ' + '. $days .' days'));
            }

            if($plan_id){
                $plan_name= $this->db->query('SELECT plan_name FROM mech_plan_table where status = "A" and plan_id = '.$plan_id.'')->row()->plan_name;
                $plan_type = $plan_name?$plan_name:"";
            }
            
                $startTimeStamp = strtotime($current_dt);
                $endTimeStamp = strtotime($new_exp_dt);
                $timeDiff = abs($endTimeStamp - $startTimeStamp);
                $numberDays = $timeDiff/86400;  // 86400 seconds in one day
                $numberDays = intval($numberDays);

                if($workshop_id){
                    $this->db->set('plan_status','D');
                    $this->db->where('subscription_id ', $plan_sub_id);
                    $this->db->update('mech_subscription_details');
                }

                $total_amt = $this->input->post('total_amt');
                $due_amount = 0;
                $paid_amt = $this->input->post('total_amt');
                $tax_amount = 0;
                $grand_total = 0;
                $tax_amount = (($total_amt * 18) / 100);
                
                $grand_total = $total_amt + $tax_amount;

                $plan_array = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'workshop_id' => $workshop_id,
                    'from_date' => $current_dt,
                    'to_date' => $new_exp_dt,
                    'days' => $numberDays,
                    'plan_id' => $plan_id,
                    'plan_type' => $plan_type,
                    'plan_month_type' => $plan_month_type,
                    'total_amount' => $total_amt,
                    'tax_amount' => $tax_amount,
                    'tax' => 18,
                    'grand_total' => $grand_total,
                    'due_amount' => $due_amt,
                    'paid_amount' => $paid_amt,
                    'plan_status'=> 'A',
                    'invoice_no' => $invoice_no,
                    'created_on' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('user_id'),
                    'modified_by' => $this->session->userdata('user_id'),
                    'modified_on' => date('Y-m-d H:i:s'),
                );
                $this->db->insert('mech_subscription_details', $plan_array);

                if($this->input->post('workshop_email_id')){

                    // Mail To Customer
                    $workshop_name = $this->input->post('workshop_name');
                    
                    $template = "";
                    $from = "noreply@mechtool.com";
                    $to = $this->input->post('workshop_email_id');
        
                    $subject = "MechToolz - Thank you for your transaction";
                    $body ='<table width="100%" class="item-tables">
                    <tr width="100%">
                        <td>Hi '.$workshop_name.',</td>
                    </tr>   
                    <br>
                    <tr width="100%"> 
                        <td>Thank you for choosing MechToolz. This email contains important information about your account. Please save it for future reference.</td>
                    </tr> 
                    <br>  
                    <tr width="100%">  
                     <td>Transaction No.: TN0987619SUB</td>
                    </tr>
                    <tr width="100%">    
                     <td>Transaction Date: '.date('d-m-Y').'</td>
                    </tr>
                    <tr width="100%">    
                     <td>Payment Mode: ONLINE</td>
                    </tr>
                    <tr width="100%">    
                     <td>Account Expire Date: '.date_from_mysql($new_exp_dt).'</td>
                    </tr>
                     <tr width="100%">    
                    <td>Paid Amount: '.$total_amt.'</td>
                     </tr>
                    <br>
        
                    <tr width="100%">    
                        <td>For more information: +91 9941111019</td>
                    </tr> 
                    <br>   
                    <tr width="100%">    
                        <td style="font-size:20px;">Looking forward to serve you always,</td>
                        <tr>
                        <td>Onfleek Media and Technologies Pvt Ltd.</td> 
                        </tr>
                    </tr>
                    </table>' ;
                    $cc = "";
                    $bcc = "";
                    $attachments = "";
        
                    $this->load->library('email');
        
                    $send_email = email_plan($workshop_id, $template, $from, $to, $subject, $body, $cc = null, $bcc = null, $attachments = null);
                }

            $response = array( 
                'success' => 1,
            );
            echo json_encode($response);
            exit();
        }else{
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
            echo json_encode($response);
            exit();
        }
    }
   
}