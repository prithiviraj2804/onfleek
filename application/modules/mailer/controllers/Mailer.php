<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mailer extends Admin_Controller
{
    private $mailer_configured;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('mailer');
        $this->mailer_configured = mailer_configured();
        if ($this->mailer_configured == false) {
            $this->layout->buffer('content', 'mailer/not_configured');
            $this->layout->render();
        }
    }
    
    public function model_mech_invoice($invoice_id, $cat = NULL)
    {
        if (!$this->mailer_configured) return;
		
        $this->load->model('mech_invoices/mdl_mech_invoice');
        $this->load->model('mech_pos_invoices/mdl_mech_pos_invoice');
        $this->load->model('workshop_branch/mdl_workshop_branch');
        $this->load->model('email_templates/mdl_email_templates');
        $this->load->helper('template');
		$this->load->model('users/mdl_users');

        if($cat == 'I'){
            $invoice = $this->mdl_mech_invoice->where('mech_invoice.invoice_id', $invoice_id)->join('mech_clients', 'mech_invoice.customer_id = mech_clients.client_id')->get()->row();
        }else{
            $invoice = $this->mdl_mech_pos_invoice->where('mech_invoice.invoice_id', $invoice_id)->join('mech_clients', 'mech_invoice.customer_id = mech_clients.client_id')->get()->row();
        }
		
		$user_id = $this->session->userdata('user_id');
		$users = $this->mdl_users->where("user_id",$user_id)->get()->row();
     
		$data = array(
            'cat' => $cat,
            'invoice_id' => $invoice_id,
            'selected_pdf_template' => select_pdf_invoice_template($invoice),
            'selected_email_template' => $email_template_id,
            'email_templates' => $this->mdl_email_templates->where('email_template_type', 'I')->get()->result(),
        	'invoice' => $invoice,
        	'users'=>$users,
        );
		$this->layout->load_view('mailer/model_send_invoice', $data);
    }

    public function model_mech_quotes($invoice_id, $cat = NULL){
        if (!$this->mailer_configured) return;
		
        $this->load->model('mech_invoices/mdl_mech_invoice');
        $this->load->model('mech_pos_invoices/mdl_mech_pos_invoice');
        $this->load->model('workshop_branch/mdl_workshop_branch');
        $this->load->model('email_templates/mdl_email_templates');
        $this->load->helper('template');
		$this->load->model('users/mdl_users');

        if($cat == 'I'){
            $invoice = $this->mdl_mech_invoice->where('mech_invoice.invoice_id', $invoice_id)->join('mech_clients', 'mech_invoice.customer_id = mech_clients.client_id')->get()->row();
        }else{
            $invoice = $this->mdl_mech_pos_invoice->where('mech_invoice.invoice_id', $invoice_id)->join('mech_clients', 'mech_invoice.customer_id = mech_clients.client_id')->get()->row();
        }
		
		$user_id = $this->session->userdata('user_id');
		$users = $this->mdl_users->where("user_id",$user_id)->get()->row();
     
		$data = array(
            'cat' => $cat,
            'invoice_id' => $invoice_id,
            'selected_pdf_template' => select_pdf_invoice_template($invoice),
            'selected_email_template' => $email_template_id,
            'email_templates' => $this->mdl_email_templates->where('email_template_type', 'I')->get()->result(),
        	'invoice' => $invoice,
        	'users'=>$users,
        );
		$this->layout->load_view('mailer/model_send_invoice', $data);
    }


    public function model_spare_quotes($invoice_id, $cat = NULL){
        if (!$this->mailer_configured) return;
		
        $this->load->model('mech_invoices/mdl_mech_invoice');
        $this->load->model('mech_pos_invoices/mdl_mech_pos_invoice');
        $this->load->model('workshop_branch/mdl_workshop_branch');
        $this->load->model('email_templates/mdl_email_templates');
        $this->load->helper('template');
		$this->load->model('users/mdl_users');

        if($cat == 'I'){
            $invoice = $this->mdl_mech_invoice->where('mech_invoice.invoice_id', $invoice_id)->join('mech_clients', 'mech_invoice.customer_id = mech_clients.client_id')->get()->row();
        }else{
            $invoice = $this->mdl_mech_pos_invoice->where('mech_invoice.invoice_id', $invoice_id)->join('mech_clients', 'mech_invoice.customer_id = mech_clients.client_id')->get()->row();
        }
		
		$user_id = $this->session->userdata('user_id');
		$users = $this->mdl_users->where("user_id",$user_id)->get()->row();
     
		$data = array(
            'cat' => $cat,
            'invoice_id' => $invoice_id,
            'selected_pdf_template' => select_pdf_invoice_template($invoice),
            'selected_email_template' => $email_template_id,
            'email_templates' => $this->mdl_email_templates->where('email_template_type', 'I')->get()->result(),
        	'invoice' => $invoice,
        	'users'=>$users,
        );
		$this->layout->load_view('mailer/model_send_invoice', $data);
    }

    public function send_mech_invoice($invoice_id, $cat=NULL)
    {
        $this->load->model('mech_invoices/mdl_templates');
        $this->load->model('mech_invoices/mdl_mech_invoice');
        $this->load->model('mech_pos_invoices/mdl_mech_pos_invoice');
        $this->load->model('email_templates/mdl_email_templates');
        $this->load->model('workshop_branch/mdl_workshop_branch');
        $this->load->helper('template');
        if ($this->input->post('btn_cancel')) {
            redirect('mech_invoices');
        }

        if($cat == 'I'){
            $invoice = $this->mdl_mech_invoice->where('mech_invoice.invoice_id', $invoice_id)->get()->row();
        }else{
            $invoice = $this->mdl_mech_pos_invoice->where('mech_invoice.invoice_id', $invoice_id)->get()->row();
        }
        
        if (!$this->mailer_configured) return;
        $this->load->model('upload/mdl_uploads');
        $from = array(
            $this->input->post('from_email'),
            $this->input->post('from_name')
        );
        $to = $this->input->post('to_email');
        $pdf_template = $this->input->post('pdf_template');
        $subject = $this->input->post('subject');
        
        if (strlen($this->input->post('body')) != strlen(strip_tags($this->input->post('body')))) {
            $content = htmlspecialchars_decode($this->input->post('body'));
        } else {
            $content = htmlspecialchars_decode(nl2br($this->input->post('body')));
        }

        $body = $this->load->view('emails/invoice', array (
            'content' => $content,
        ), true );

        $cc = $this->input->post('cc');
        $bcc = $this->input->post('bcc');
        $attachment_files = NULL;

        if (email_invoice($invoice_id, $pdf_template, $from, $to, $subject, $body, $cc, $bcc, $attachment_files)) {
            if($cat == 'I'){
                $this->mdl_mech_invoice->mark_sent($invoice_id);
                $this->session->set_flashdata('alert_success', trans('email_successfully_sent'));
                redirect('mech_invoices');
            }else{
                $this->mdl_mech_pos_invoice->mark_sent($invoice_id);
                $this->session->set_flashdata('alert_success', trans('email_successfully_sent'));
                redirect('mech_pos_invoices');
            }
            
        } else {
            redirect('mailer/model_mech_invoice/'.$invoice_id);
        }
    }
    
    public function model_mech_jobcard($jobcard_id)
    {
        if (!$this->mailer_configured) return;
		
		$this->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');
        $this->load->model('email_templates/mdl_email_templates');
        $this->load->helper('template');
		$this->load->model('users/mdl_users');

        $job_card = $this->mdl_mech_work_order_dtls->where('mech_work_order_dtls.work_order_id', $jobcard_id)->join('mech_clients', 'mech_work_order_dtls.customer_id = mech_clients.client_id')->get()->row();
		
		$user_id = $this->session->userdata('user_id');
		$users = $this->mdl_users->where("user_id",$user_id)->get()->row();
     
		$data = array(
            'jobcard_id' => $jobcard_id,
            'selected_pdf_template' => select_pdf_invoice_template($invoice),
            'email_templates' => $this->mdl_email_templates->where('email_template_type', 'J')->get()->result(),
        	'job_card' => $job_card,
        	'users'=>$users,
        );
		$this->layout->load_view('mailer/model_mech_jobcard', $data);
    }

    public function send_mech_jobcard($jobcard_id)
    {
        $this->load->model('mech_invoices/mdl_templates');
        $this->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');
        $this->load->model('email_templates/mdl_email_templates');
        $this->load->model('workshop_branch/mdl_workshop_branch');
        $this->load->helper('template');
        if ($this->input->post('btn_cancel')) {
            redirect('mech_work_order_dtls');
        }
      
        if (!$this->mailer_configured) return;
        $this->load->model('upload/mdl_uploads');
        $from = array(
            $this->input->post('from_email'),
            $this->input->post('from_name')
        );
        $to = $this->input->post('to_email');
        $pdf_template = $this->input->post('pdf_template');
        $subject = $this->input->post('subject');
        
        if (strlen($this->input->post('body')) != strlen(strip_tags($this->input->post('body')))) {
            $content = htmlspecialchars_decode($this->input->post('body'));
        } else {
            $content = htmlspecialchars_decode(nl2br($this->input->post('body')));
        }

        $body = $this->load->view('emails/job_card', array (
            'content' => $content,
        ), true );

        $cc = $this->input->post('cc');
        $bcc = $this->input->post('bcc');
        $attachment_files = NULL;

        if (email_jobcard($jobcard_id, $pdf_template, $from, $to, $subject, $body, $cc, $bcc, $attachment_files)) {
            $this->session->set_flashdata('alert_success', trans('email_successfully_sent'));
            redirect('mech_work_order_dtls/index');
        } else {
            redirect('mailer/model_mech_jobcard/'.$jobcard_id);
        }
    }

    public function invoice($invoice_id)
    {
        if (!$this->mailer_configured) return;

        $this->load->model('invoices/mdl_templates');
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('email_templates/mdl_email_templates');
        $this->load->helper('template');

        $invoice = $this->mdl_invoices->get_by_id($invoice_id);

        $email_template_id = select_email_invoice_template($invoice);

        if ($email_template_id) {
            $email_template = $this->mdl_email_templates->get_by_id($email_template_id);
            $this->layout->set('email_template', json_encode($email_template));
        } else {
            $this->layout->set('email_template', '{}');
        }

        $this->layout->set('selected_pdf_template', select_pdf_invoice_template($invoice));
        $this->layout->set('selected_email_template', $email_template_id);
        $this->layout->set('email_templates', $this->mdl_email_templates->where('email_template_type', 'invoice')->get()->result());
        $this->layout->set('invoice', $invoice);
        $this->layout->set('pdf_templates', $this->mdl_templates->get_invoice_templates());
        $this->layout->buffer('content', 'mailer/invoice');
        $this->layout->render();
    }

    public function quote($quote_id)
    {
        if (!$this->mailer_configured) return;

        $this->load->model('invoices/mdl_templates');
        $this->load->model('quotes/mdl_quotes');
        $this->load->model('upload/mdl_uploads');
        $this->load->model('email_templates/mdl_email_templates');

        $email_template_id = get_setting('email_quote_template');

        if ($email_template_id) {
            $email_template = $this->mdl_email_templates->get_by_id($email_template_id);
            $this->layout->set('email_template', json_encode($email_template));
        } else {
            $this->layout->set('email_template', '{}');
        }

        $this->layout->set('selected_pdf_template', get_setting('pdf_quote_template'));
        $this->layout->set('selected_email_template', $email_template_id);
        $this->layout->set('email_templates', $this->mdl_email_templates->where('email_template_type', 'quote')->get()->result());
        $this->layout->set('quote', $this->mdl_quotes->get_by_id($quote_id));
        $this->layout->set('pdf_templates', $this->mdl_templates->get_quote_templates());
        $this->layout->buffer('content', 'mailer/quote');
        $this->layout->render();

    }

    public function send_invoices($invoice_id)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('invoices/view/' . $invoice_id);
        }

        if (!$this->mailer_configured) return;

        $to = $this->input->post('to_email');

        if (empty($to)) {
            $this->session->set_flashdata('alert_danger', trans('email_to_address_missing'));
            redirect('mailer/invoice/' . $invoice_id);
        }

        $this->load->model('upload/mdl_uploads');
        $from = array(
            $this->input->post('from_email'),
            $this->input->post('from_name')
        );

        $pdf_template = $this->input->post('pdf_template');
        $subject = $this->input->post('subject');

        if (strlen($this->input->post('body')) != strlen(strip_tags($this->input->post('body')))) {
            $body = htmlspecialchars_decode($this->input->post('body'));
        } else {
            $body = htmlspecialchars_decode(nl2br($this->input->post('body')));
        }

        $cc = $this->input->post('cc');
        $bcc = $this->input->post('bcc');
        $attachment_files = $this->mdl_uploads->get_invoice_uploads($invoice_id);

        if (email_invoice($invoice_id, $pdf_template, $from, $to, $subject, $body, $cc, $bcc, $attachment_files)) {
            $this->mdl_invoices->mark_sent($invoice_id);
            $this->session->set_flashdata('alert_success', trans('email_successfully_sent'));
            redirect('invoices/view/' . $invoice_id);
        } else {
            redirect('mailer/invoice/' . $invoice_id);
        }
    }

    public function send_quote($quote_id)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('quotes/view/' . $quote_id);
        }

        if (!$this->mailer_configured) return;

        $to = $this->input->post('to_email');

        if (empty($to)) {
            $this->session->set_flashdata('alert_danger', trans('email_to_address_missing'));
            redirect('mailer/quote/' . $quote_id);
        }

        $this->load->model('upload/mdl_uploads');
        $from = array(
            $this->input->post('from_email'),
            $this->input->post('from_name')
        );

        $pdf_template = $this->input->post('pdf_template');
        $subject = $this->input->post('subject');

        if (strlen($this->input->post('body')) != strlen(strip_tags($this->input->post('body')))) {
            $body = htmlspecialchars_decode($this->input->post('body'));
        } else {
            $body = htmlspecialchars_decode(nl2br($this->input->post('body')));
        }

        $cc = $this->input->post('cc');
        $bcc = $this->input->post('bcc');
        $attachment_files = $this->mdl_uploads->get_quote_uploads($quote_id);

        if (email_quote($quote_id, $pdf_template, $from, $to, $subject, $body, $cc, $bcc, $attachment_files)) {
            $this->mdl_quotes->mark_sent($quote_id);

            $this->session->set_flashdata('alert_success', trans('email_successfully_sent'));

            redirect('quotes/view/' . $quote_id);
        } else {
            redirect('mailer/quote/' . $quote_id);
        }
    }
}