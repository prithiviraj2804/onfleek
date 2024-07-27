<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_Mech_Invoice_Groups extends Response_Model
{
    public $table = 'ip_invoice_groups';
    public $primary_key = 'ip_invoice_groups.invoice_group_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }
	
	public function default_where()
	{
        $this->db->where('workshop_id' , $this->session->userdata('work_shop_id'));
        if($this->session->userdata('user_type') == 4 || $this->session->userdata('user_type') == 5 ) {
            $this->db->where('w_branch_id' , $this->session->userdata('branch_id'));
        }else if ($this->session->userdata('user_type') == 6) {
            $this->db->where_in('w_branch_id' , $this->session->userdata('user_branch_id'));
        }
        // $this->db->where('status','A');
	}
    public function default_order_by()
    {
        $this->db->order_by('ip_invoice_groups.invoice_group_name');
    }

    public function validation_rules()
    {
        return array(
            'branch_id' => array(
                'field' => 'branch_id',
                'label' => trans('lable51'),
                'rules' => 'required'
            ),
            'invoice_group_name' => array(
                'field' => 'invoice_group_name',
                'label' => trans('lable782'),
                'rules' => 'required|trim|xss_clean|strip_tags'
            ),
            'module_type' => array(
                'field' => 'module_type',
                'label' => trans('lable783'),
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            'prefix_text' => array(
                'field' => 'prefix_text',
                'label' => trans('lable784'),
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            'suffix_text' => array(
                'field' => 'suffix_text',
                'label' => trans('lable785'),
                'rules' => 'trim|xss_clean|strip_tags'
            ),
            'invoice_group_next_id' => array(
                'field' => 'invoice_group_next_id',
                'label' => trans('lable786'),
                'rules' => 'required|trim|xss_clean|strip_tags'
            ),
            'invoice_group_left_pad' => array(
                'field' => 'invoice_group_left_pad',
                'label' => trans('lable787'),
                'rules' => 'required|trim|xss_clean|strip_tags'
            ),
            'mode_of_payment' => array(
                'field' => 'mode_of_payment',
                // 'label' => trans('mode_of_payment'),
               // 'rules' => 'required|trim|xss_clean|strip_tags'
            )
        );
    }
	
	public function db_array()
    {
    	
        $db_array = parent::db_array();
		
		if($db_array['hidden_module_type'])
		{
			$db_array['module_type'] = $db_array['hidden_module_type'];
			unset($db_array['hidden_module_type']);
		}
		
		$db_array['workshop_id'] = $this->session->userdata('work_shop_id');
        $db_array['w_branch_id'] = $this->input->post('branch_id');
		if($db_array['prefix_text']){
			$prefix_text = $db_array['prefix_text'];
		}else{
			$prefix_text ="";
		}
		if($db_array['suffix_text']){
			$suffix_text = $db_array['suffix_text'];
		}else{
			$suffix_text ="";
		}
		$db_array['invoice_group_identifier_format'] = $prefix_text."{{{id}}}".$suffix_text;
        $db_array['status'] = 'A';
		unset($db_array['prefix_text']);
		unset($db_array['suffix_text']);
		return $db_array;
	}

    public function generate_invoice_number($invoice_group_id, $set_next = true)
    {
        $invoice_group = $this->mdl_mech_invoice_groups->where('invoice_group_id', $invoice_group_id)->where(array('workshop_id'=>$this->session->userdata('work_shop_id')))->get()->row();

        $invoice_identifier = $this->parse_identifier_format(
            $invoice_group->invoice_group_identifier_format,
            $invoice_group->invoice_group_next_id,
            $invoice_group->invoice_group_left_pad
        );

        if ($set_next) {
            $this->set_next_invoice_number($invoice_group_id);
        }

        return $invoice_identifier;
    }

    public function generate_invoice_number_duplicate($invoice_group_id, $set_next = true)
    {
        $invoice_group = $this->db->select('invoice_group_identifier_format,invoice_group_next_id,invoice_group_left_pad')->from('ip_invoice_groups')->where('invoice_group_id', $invoice_group_id)->get()->row();

        $invoice_identifier = $this->parse_identifier_format(
            $invoice_group->invoice_group_identifier_format,
            $invoice_group->invoice_group_next_id,
            $invoice_group->invoice_group_left_pad
        );

        if ($set_next) {
            $this->set_next_invoice_number_duplicate($invoice_group_id);
        }
        return $invoice_identifier;
    }

    public function generate_api_invoice_number($workshop_id, $w_branch_id, $invoice_group_id, $set_next = true)
    {
        $invoice_group = $this->db->select('invoice_group_identifier_format,invoice_group_next_id,invoice_group_left_pad')->from('ip_invoice_groups')->where('invoice_group_id', $invoice_group_id)->where(array('workshop_id'=>$workshop_id,'w_branch_id'=>$w_branch_id))->get()->row();

        $invoice_identifier = $this->parse_identifier_format(
            $invoice_group->invoice_group_identifier_format,
            $invoice_group->invoice_group_next_id,
            $invoice_group->invoice_group_left_pad
        );

        if ($set_next) {
            $this->api_set_next_invoice_number($workshop_id, $w_branch_id, $invoice_group_id);
        }

        return $invoice_identifier;
    }

    private function parse_identifier_format($identifier_format, $next_id, $left_pad)
    {
        if (preg_match_all('/{{{([^{|}]*)}}}/', $identifier_format, $template_vars)) {

            foreach ($template_vars[1] as $var) {
                switch ($var) {
                    case 'year':
                        $replace = date('Y');
                        break;
                    case 'month':
                        $replace = date('m');
                        break;
                    case 'day':
                        $replace = date('d');
                        break;
                    case 'id':
                        $replace = str_pad($next_id, $left_pad, '0', STR_PAD_LEFT);
                        break;
                    default:
                        $replace = '';
                }

                $identifier_format = str_replace('{{{' . $var . '}}}', $replace, $identifier_format);
            }
        }

        return $identifier_format;
    }

    public function set_next_invoice_number($invoice_group_id)
    {
        $this->db->where($this->primary_key, $invoice_group_id);
		 $this->db->where(array('workshop_id'=>$this->session->userdata('work_shop_id'),'w_branch_id'=>$this->session->userdata('branch_id')));
        $this->db->set('invoice_group_next_id', 'invoice_group_next_id+1', false);
        $this->db->update($this->table);
    }

    public function set_next_invoice_number_duplicate($invoice_group_id)
    {
        $this->db->where($this->primary_key, $invoice_group_id);
        $this->db->set('invoice_group_next_id', 'invoice_group_next_id+1', false);
        $this->db->update($this->table);
    }

    public function api_set_next_invoice_number($workshop_id, $w_branch_id, $invoice_group_id)
    {
        $this->db->where($this->primary_key, $invoice_group_id);
		 $this->db->where(array('workshop_id'=>$workshop_id,'w_branch_id'=>$w_branch_id));
        $this->db->set('invoice_group_next_id', 'invoice_group_next_id+1', false);
        $this->db->update($this->table);
    }

    public function create_invoice_groups_journal($prefix_text,$suffix_text,$module_type,$invoice_group_name,$invoice_group_next_id,$invoice_group_left_pad)
    {
        
        $invoice_group_identifier_format = $prefix_text."{{{id}}}".$suffix_text;
        
        $check = $this->db->get_where('ip_invoice_groups', array('module_type'=>$module_type,'invoice_group_identifier_format' => $invoice_group_identifier_format, 'workshop_id'=>$this->session->userdata('work_shop_id'),'w_branch_id'=>$this->session->userdata('branch_id')))->row();
        
        if (!empty($check)) {
           return $check->invoice_group_id;
        }else{
            $db_array = array(
                'invoice_group_name' => $invoice_group_name,
                'module_type' => $module_type,
                'invoice_group_identifier_format' => $invoice_group_identifier_format,
                'invoice_group_next_id' => $invoice_group_next_id,
                'invoice_group_left_pad' => $invoice_group_left_pad,
                'workshop_id'=>$this->session->userdata('work_shop_id'),
                'w_branch_id'=>$this->session->userdata('branch_id')
            );
                
            
            $this->db->insert('ip_invoice_groups', $db_array);
            $invoice_group_id  = $this->db->insert_id();

            return $invoice_group_id;
        }
    }
    public function check_invoice_group_validity(){
        return $this->db->query("SELECT 
            SUM(CASE WHEN module_type = 'job_card' AND status = 'A' AND mode_of_payment = 'C' THEN true ELSE false END) as cash_job_card_status,
            SUM(CASE WHEN module_type = 'job_card' AND status = 'A' AND mode_of_payment = 'O' THEN true ELSE false END) as other_job_card_status,
            SUM(CASE WHEN module_type = 'quote' AND status = 'A' AND mode_of_payment = 'C' THEN true ELSE false END) as cash_quote_status,
            SUM(CASE WHEN module_type = 'quote' AND status = 'A' AND mode_of_payment = 'O' THEN true ELSE false END) as other_quote_status,
            SUM(CASE WHEN module_type = 'invoice' AND status = 'A' AND mode_of_payment = 'C' THEN true ELSE false END) as cash_invoice_status,
            SUM(CASE WHEN module_type = 'invoice' AND status = 'A' AND mode_of_payment = 'O' THEN true ELSE false END) as other_invoice_status,
            SUM(CASE WHEN module_type = 'purchase' AND status = 'A' AND mode_of_payment = 'C' THEN true ELSE false END) as cash_purchase_status,
            SUM(CASE WHEN module_type = 'purchase' AND status = 'A' AND mode_of_payment = 'O' THEN true ELSE false END) as other_purchase_status,
            SUM(CASE WHEN module_type = 'purchase_order' AND status = 'A' AND mode_of_payment = 'C' THEN true ELSE false END) as cash_purchase_order_status,
            SUM(CASE WHEN module_type = 'purchase_order' AND status = 'A' AND mode_of_payment = 'O' THEN true ELSE false END) as other_purchase_order_status,
            SUM(CASE WHEN module_type = 'expense' AND status = 'A' AND mode_of_payment = 'C' THEN true ELSE false END) as cash_exp_status,
            SUM(CASE WHEN module_type = 'expense' AND status = 'A' AND mode_of_payment = 'O' THEN true ELSE false END) as online_exp_status
            FROM `ip_invoice_groups` WHERE workshop_id = " . $this->session->userdata('work_shop_id') . " AND w_branch_id = " . $this->session->userdata('branch_id'))->row();
    }

    public function get_invoice_group_type_count(){
        return $this->db->query("SELECT 
            SUM(CASE WHEN module_type = 'job_card' THEN 1 ELSE 0 END) as job_card,
            SUM(CASE WHEN module_type = 'purchase' THEN 1 ELSE 0 END) as purchase,
            SUM(CASE WHEN module_type = 'purchase_order' THEN 1 ELSE 0 END) as purchase_order,
            SUM(CASE WHEN module_type = 'expense' THEN 1 ELSE 0 END) as expense,
            SUM(CASE WHEN module_type = 'quote' THEN 1 ELSE 0 END) as quote,
            SUM(CASE WHEN module_type = 'invoice' THEN 1 ELSE 0 END) as invoice,
            SUM(CASE WHEN module_type = 'leads' THEN 1 ELSE 0 END) as leads,
            SUM(CASE WHEN module_type = 'appointment' THEN 1 ELSE 0 END) as appointment
            FROM `ip_invoice_groups` WHERE workshop_id = " . $this->session->userdata('work_shop_id') . " AND w_branch_id = " . $this->session->userdata('branch_id'))->row();   
    }
}