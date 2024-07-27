<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function mailer_configured()
{
    $CI = &get_instance();

    return (($CI->mdl_settings->setting('email_send_method') == 'phpmail') ||
        ($CI->mdl_settings->setting('email_send_method') == 'sendmail') ||
        (($CI->mdl_settings->setting('email_send_method') == 'smtp') && ($CI->mdl_settings->setting('smtp_server_address')))
    );
}

function email_notification($invoice_id, $invoice_template, $from, $to, $subject, $message, $cc = null, $bcc = null, $attachments = null)
{
	$CI = &get_instance();
    $CI->load->helper('mailer/phpmailer');

    return phpmail_send($from, $to, $subject, $message, $invoice = NULL , $cc, $bcc, $attachments);
}

function email_plan($workshop_id, $template, $from, $to, $subject, $body, $cc = null, $bcc = null, $attachments = null)
{
    
	$CI = &get_instance();
    // $CI->load->helper('mailer/sendmailer');
    $CI->load->helper('mailer/phpmailer');


    return phpmail_send($from, $to, $subject, $body, $invoice = NULL , $cc = null, $bcc = null, $attachments = null);
}

function emailtous_notification($invoice_id, $invoice_template, $from, $to, $subject, $message, $cc = null, $bcc = null, $attachments = null)
{
	$CI = &get_instance();
    $CI->load->helper('mailer/sendmailer');

    return phpsendmail_send($from, $to, $subject, $message, $invoice = NULL , $cc, $bcc, $attachments);
}

function email_invoice($invoice_id, $invoice_template, $from, $to, $subject, $body, $cc = null, $bcc = null, $attachments = null)
{
	$CI = &get_instance();
	$CI->load->model('mech_invoices/mdl_mech_invoice');
    $CI->load->helper('mailer/phpmailer');
    $CI->load->helper('template');
    $CI->load->helper('invoice');
    $CI->load->helper('pdf');

    $db_invoice = $CI->mdl_mech_invoice->where('mech_invoice.invoice_id', $invoice_id)->get()->row();

    if ($db_invoice->sumex_id == null) {
        $invoice = generate_user_invoice_pdf($invoice_id, false, $invoice_template);
    } else {
        $invoice = generate_invoice_sumex($invoice_id, false, true);
    }

    $message = parse_template($db_invoice, $body, $invoice_id);
    $subject = parse_template($db_invoice, $subject, $invoice_id);
    $cc = parse_template($db_invoice, $cc, $invoice_id);
    $bcc = parse_template($db_invoice, $bcc, $invoice_id);
    $from = array(parse_template($db_invoice, $from[0], $invoice_id), parse_template($db_invoice, $from[1], $invoice_id));
    $message = (empty($message) ? ' ' : $message);

    return phpmail_send($from, $to, $subject, $message, $invoice, $cc, $bcc, $attachments);
}


function email_jobcard($jobcard_id, $jobcard_template, $from, $to, $subject, $body, $cc = null, $bcc = null, $attachments = null)
{
	$CI = &get_instance();
	$CI->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');
    $CI->load->helper('mailer/phpmailer');
    $CI->load->helper('template');
    $CI->load->helper('invoice');
    $CI->load->helper('pdf');

    $db_jobcard = $CI->mdl_mech_work_order_dtls->where('mech_work_order_dtls.work_order_id', $jobcard_id)->get()->row();

    if ($db_jobcard->sumex_id == null) {
        $job_card = generate_jobsheet_pdf($jobcard_id, false, $jobcard_template);
    } else {
        $job_card = generate_jobsheet_pdf($jobcard_id, false, true);
    }

    $message = parse_template($db_jobcard, $body, $jobcard_id);
    $subject = parse_template($db_jobcard, $subject, $jobcard_id);
    $cc = parse_template($db_jobcard, $cc, $jobcard_id);
    $bcc = parse_template($db_jobcard, $bcc, $jobcard_id);
    $from = array(parse_template($db_jobcard, $from[0], $jobcard_id), parse_template($db_jobcard, $from[1], $jobcard_id));
    $message = (empty($message) ? ' ' : $message);

    return phpmail_send($from, $to, $subject, $message, $job_card, $cc, $bcc, $attachments);
}

function email_quote($quote_id, $quote_template, $from, $to, $subject, $body, $cc = null, $bcc = null, $attachments = null)
{
    $CI = &get_instance();

    $CI->load->helper('mailer/phpmailer');
    $CI->load->helper('template');
    $CI->load->helper('pdf');

    $quote = generate_quote_pdf($quote_id, false, $quote_template);

    $db_quote = $CI->mdl_quotes->where('ip_quotes.quote_id', $quote_id)->get()->row();

    $message = parse_template($db_quote, $body, $quote_id);
    $subject = parse_template($db_quote, $subject, $quote_id);
    $cc = parse_template($db_quote, $cc, $quote_id);
    $bcc = parse_template($db_quote, $bcc, $quote_id);
    $from = array(parse_template($db_quote, $from[0], $quote_id), parse_template($db_quote, $from[1], $quote_id));

    $message = (empty($message) ? ' ' : $message);

    return phpmail_send($from, $to, $subject, $message, $quote, $cc, $bcc, $attachments);
}


function email_quote_status($quote_id, $status)
{
    ini_set('display_errors', 'on');
    error_reporting(E_ALL);

    if (!mailer_configured()) return false;

    $CI = &get_instance();
    $CI->load->helper('mailer/phpmailer');

    $quote = $CI->mdl_quotes->where('ip_quotes.quote_id', $quote_id)->get()->row();
    $base_url = base_url('/quotes/view/' . $quote_id);

    $user_email = $quote->user_email;
    $subject = sprintf(trans('quote_status_email_subject'),
        $quote->client_name,
        strtolower(lang($status)),
        $quote->quote_number
    );
    $body = sprintf(nl2br(trans('quote_status_email_body')),
        $quote->client_name,
        strtolower(lang($status)),
        $quote->quote_number,
        '<a href="' . $base_url . '">' . $base_url . '</a>'
    );

    return phpmail_send($user_email, $user_email, $subject, $body);
}
