<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_Templates extends Response_Model
{
    public function get_invoice_templates($type = 'pdf')
    {
        $this->load->helper('directory');

        if ($type == 'pdf') {
            $templates = directory_map(APPPATH . '/views/invoice_templates/pdf', true);
        } elseif ($type == 'public') {
            $templates = directory_map(APPPATH . '/views/invoice_templates/public', true);
        }else{
            $templates = array();
        }

        $templates = $this->remove_extension($templates);

        return $templates;
    }

    public function get_quote_templates($type = 'pdf')
    {
        $this->load->helper('directory');

        if ($type == 'pdf') {
            $templates = directory_map(APPPATH . '/views/quote_templates/pdf', true);
        } elseif ($type == 'public') {
            $templates = directory_map(APPPATH . '/views/quote_templates/public', true);
        }

        $templates = $this->remove_extension($templates);

        return $templates;
    }

	public function get_sale_credit_note_templates($type = 'pdf')
    {
        $this->load->helper('directory');

        if ($type == 'pdf') {
            $templates = directory_map(APPPATH . '/views/sale_credit_templates/pdf', true);
        } elseif ($type == 'public') {
            $templates = directory_map(APPPATH . '/views/sale_credit_templates/public', true);
        }

        $templates = $this->remove_extension($templates);

        return $templates;
    }
	
	public function get_sale_debit_note_templates($type = 'pdf')
    {
        $this->load->helper('directory');

        if ($type == 'pdf') {
            $templates = directory_map(APPPATH . '/views/sale_debit_templates/pdf', true);
        } elseif ($type == 'public') {
            $templates = directory_map(APPPATH . '/views/sale_debit_templates/public', true);
        }

        $templates = $this->remove_extension($templates);

        return $templates;
    }
	
	public function get_purchase_order_templates($type = 'pdf')
    {
        $this->load->helper('directory');

        if ($type == 'pdf') {
            $templates = directory_map(APPPATH . '/views/purchase_order_templates/pdf', true);
        } elseif ($type == 'public') {
            $templates = directory_map(APPPATH . '/views/purchase_order_templates/public', true);
        }

        $templates = $this->remove_extension($templates);

        return $templates;
    }

    private function remove_extension($files)
    {
        foreach ($files as $key => $file) {
            $files[$key] = str_replace('.php', '', $file);
        }

        return $files;
    }

}