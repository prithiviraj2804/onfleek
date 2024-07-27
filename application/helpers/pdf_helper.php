<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function generate_invoice_pdf($invoice_id, $stream = true, $invoice_template = null, $is_guest = null)
{
    $CI = &get_instance();

    $CI->load->model('invoices/mdl_items');
    $CI->load->model('invoices/mdl_invoices');
    $CI->load->model('invoices/mdl_invoice_tax_rates');
    $CI->load->model('custom_fields/mdl_custom_fields');
    $CI->load->model('payment_methods/mdl_payment_methods');

    $CI->load->helper('country');
    $CI->load->helper('client');

    $invoice = $CI->mdl_invoices->get_by_id($invoice_id);

    // Override language with system language
    set_language($invoice->client_language);

    if (!$invoice_template) {
        $CI->load->helper('template');
        $invoice_template = select_pdf_invoice_template($invoice);
    }

    $payment_method = $CI->mdl_payment_methods->where('payment_method_id', $invoice->payment_method)->get()->row();
    if ($invoice->payment_method == 0) $payment_method = false;

    // Determine if discounts should be displayed
    $items = $CI->mdl_items->where('invoice_id', $invoice_id)->get()->result();

    // Discount settings
    $show_item_discounts = false;
    foreach ($items as $item) {
        if ($item->item_discount != '0.00') {
            $show_item_discounts = true;
        }
    }

    // Get all custom fields
    $custom_fields = array(
        'invoice' => $CI->mdl_custom_fields->get_values_for_fields('mdl_invoice_custom', $invoice->invoice_id),
        'client' => $CI->mdl_custom_fields->get_values_for_fields('mdl_client_custom', $invoice->client_id),
        'user' => $CI->mdl_custom_fields->get_values_for_fields('mdl_user_custom', $invoice->user_id),
    );

    if ($invoice->quote_id) {
        $custom_fields['quote'] = $CI->mdl_custom_fields->get_values_for_fields('mdl_quote_custom', $invoice->quote_id);
    }

    // PDF associated files
    $include_zugferd = $CI->mdl_settings->setting('include_zugferd');

    if ($include_zugferd) {
        $CI->load->helper('zugferd');

        $associatedFiles = array(array(
            'name' => 'ZUGFeRD-invoice.xml',
            'description' => 'ZUGFeRD Invoice',
            'AFRelationship' => 'Alternative',
            'mime' => 'text/xml',
            'path' => generate_invoice_zugferd_xml_temp_file($invoice, $items)
        ));
    } else {
        $associatedFiles = null;
    }

    $data = array(
        'invoice' => $invoice,
        'invoice_tax_rates' => $CI->mdl_invoice_tax_rates->where('invoice_id', $invoice_id)->get()->result(),
        'items' => $items,
        'payment_method' => $payment_method,
        'output_type' => 'pdf',
        'show_item_discounts' => $show_item_discounts,
        'custom_fields' => $custom_fields,
    );

    $html = $CI->load->view('invoice_templates/pdf/' . $invoice_template, $data, true);

    $CI->load->helper('mpdf');
    return pdf_create($html, trans('lable119') . '_' . str_replace(array('\\', '/'), '_', $invoice->invoice_number),
        $stream, $invoice->invoice_password, true, $is_guest, $include_zugferd, $associatedFiles);
}

function generate_invoice_sumex($invoice_id, $stream = true, $client = false)
{
    $CI = &get_instance();

    $CI->load->model('invoices/mdl_items');
    $invoice = $CI->mdl_invoices->get_by_id($invoice_id);
    $CI->load->library('Sumex', array(
        'invoice' => $invoice,
        'items' => $CI->mdl_items->where('invoice_id', $invoice_id)->get()->result()
    ));

    // Append a copy at the end and change the title:
    // WARNING: The title depends on what invoice type is (TP, TG)
    // and is language-dependant. Fix accordingly if you really need this hack
    require FCPATH . '/vendor/autoload.php';
    $temp = tempnam("/tmp", "invsumex_");
    $tempCopy = tempnam("/tmp", "invsumex_");
    $pdf = new FPDI();
    $sumexPDF = $CI->sumex->pdf();

    $sha1sum = sha1($sumexPDF);
    $shortsum = substr($sha1sum, 0, 8);
    $filename = trans('lable119') . '_' . $invoice->invoice_number . '_' . $shortsum;

    if (!$client) {
        file_put_contents($temp, $sumexPDF);

        // Hackish
        $sumexPDF = str_replace(
            "Giustificativo per la richiesta di rimborso",
            "Copia: Giustificativo per la richiesta di rimborso",
            $sumexPDF
        );

        file_put_contents($tempCopy, $sumexPDF);

        $pageCount = $pdf->setSourceFile($temp);

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);

            if ($size['w'] > $size['h']) {
                $pageFormat = 'L';  //  landscape
            } else {
                $pageFormat = 'P';  //  portrait
            }

            $pdf->addPage($pageFormat, array($size['w'], $size['h']));
            $pdf->useTemplate($templateId);
        }

        $pageCount = $pdf->setSourceFile($tempCopy);

        for ($pageNo = 2; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);

            if ($size['w'] > $size['h']) {
                $pageFormat = 'L';  //  landscape
            } else {
                $pageFormat = 'P';  //  portrait
            }

            $pdf->addPage($pageFormat, array($size['w'], $size['h']));
            $pdf->useTemplate($templateId);
        }

        unlink($temp);
        unlink($tempCopy);

        if ($stream) {
            header("Content-Type", "application/pdf");
            $pdf->Output($filename . '.pdf', 'I');
            return;
        }

        $filePath = UPLOADS_FOLDER . 'temp/' . $filename . '.pdf';
        $pdf->Output($filePath, 'F');
        return $filePath;
    } else {
        if ($stream) {
            return $sumexPDF;
        }

        $filePath = UPLOADS_FOLDER . 'temp/' . $filename . '.pdf';
        file_put_contents($filePath, $sumexPDF);
        return $filePath;
    }
}

function generate_quote_pdf($quote_id, $stream = true, $quote_template = null)
{
    $CI = &get_instance();

    $CI->load->model('quotes/mdl_quotes');
    $CI->load->model('quotes/mdl_quote_items');
    $CI->load->model('quotes/mdl_quote_tax_rates');
    $CI->load->model('custom_fields/mdl_custom_fields');
    $CI->load->helper('country');
    $CI->load->helper('client');

    $quote = $CI->mdl_quotes->get_by_id($quote_id);

    // Override language with system language
    set_language($quote->client_language);

    if (!$quote_template) {
        $quote_template = $CI->mdl_settings->setting('pdf_quote_template');
    }

    // Determine if discounts should be displayed
    $items = $CI->mdl_quote_items->where('quote_id', $quote_id)->get()->result();

    $show_item_discounts = false;
    foreach ($items as $item) {
        if ($item->item_discount != '0.00') {
            $show_item_discounts = true;
        }
    }

    // Get all custom fields
    $custom_fields = array(
        'quote' => $CI->mdl_custom_fields->get_values_for_fields('mdl_quote_custom', $quote->quote_id),
        'client' => $CI->mdl_custom_fields->get_values_for_fields('mdl_client_custom', $quote->client_id),
        'user' => $CI->mdl_custom_fields->get_values_for_fields('mdl_user_custom', $quote->user_id),
    );

    $data = array(
        'quote' => $quote,
        'quote_tax_rates' => $CI->mdl_quote_tax_rates->where('quote_id', $quote_id)->get()->result(),
        'items' => $items,
        'output_type' => 'pdf',
        'show_item_discounts' => $show_item_discounts,
        'custom_fields' => $custom_fields,
    );

    $html = $CI->load->view('quote_templates/pdf/' . $quote_template, $data, true);

    $CI->load->helper('mpdf');

    return pdf_create($html, trans('quote') . '_' . str_replace(array('\\', '/'), '_', $quote->quote_number), $stream, $quote->quote_password);
}

function generate_user_spare_quote_pdf($quote_id, $stream = true, $quote_template = null)
{
	$CI = &get_instance();
	
	$CI->load->model('spare_quotes/mdl_spare_quotes');
	$CI->load->model('clients/mdl_clients');
    $CI->load->model('mech_item_master/mdl_mech_item_master');
	$CI->load->model('products/mdl_products');
	$CI->load->model('workshop_branch/mdl_workshop_branch');
	$CI->load->model('user_address/mdl_user_address');
	
	if (!$quote_template) {
        $quote_template = 'MechMen.php';
    }
	
	$work_shop_id = $CI->session->userdata('work_shop_id');
	$branch_id = $CI->session->userdata('branch_id');
	$CI->mdl_spare_quotes->where('quote_id='.$quote_id.'');
	if($CI->session->userdata('user_type') == 3){
		$CI->mdl_spare_quotes->where('spare_quotes.workshop_id='.$work_shop_id.'');
	}elseif($CI->session->userdata('user_type') == 4){
		$CI->mdl_spare_quotes->where('spare_quotes.workshop_id='.$work_shop_id.' AND spare_quotes.w_branch_id='.$branch_id.'');
	}
	$quote = $CI->mdl_spare_quotes->get()->row();
    
    $data = (array(
        'quote_id' => $quote_id,
        'quote_detail' => $quote,
        'product_list' => $CI->mdl_spare_quotes->get_user_quote_product_item($quote_id, $quote->customer_id),
        'product_category_items' =>$CI->mdl_mech_item_master->get()->result(),
        'customer_details' => $CI->mdl_clients->get_by_id($quote->customer_id),
        'title' => 'Estimate',
        'bank_dtls' => $CI->db->get_where('mech_workshop_bank_list', array('module_type' =>'B', 'w_branch_id'=>$quote->branch_id, 'bank_status' => 'A'))->row(),
        'quote' => array(),
    ));
	
	$html = $CI->load->view('spare_quote_templates/pdf/' . $quote_template, $data, true);
    $CI->load->helper('mpdf');

    return pdf_create($html, trans('lable837') . '_' . str_replace(array('\\', '/'), '_', 1), $stream, null);
}

function generate_user_quote_pdf($quote_id, $stream = true, $quote_template = null)
{
	$CI = &get_instance();
	
	$CI->load->model('mech_quotes/mdl_mech_quotes');
	$CI->load->model('clients/mdl_clients');
    $CI->load->model('mech_item_master/mdl_mech_item_master');
	$CI->load->model('products/mdl_products');
	$CI->load->model('workshop_branch/mdl_workshop_branch');
	$CI->load->model('user_address/mdl_user_address');
	
	// $CI->load->model('mechanic_service_category_items/mdl_mechanic_service_category_items');

    $CI->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls'); 
	
	if (!$quote_template) {
        $quote_template = 'MechMen.php';
    }
	
	$work_shop_id = $CI->session->userdata('work_shop_id');
	$branch_id = $CI->session->userdata('branch_id');
	$CI->mdl_mech_quotes->where('quote_id='.$quote_id.'');
	if($CI->session->userdata('user_type') == 3){
		$CI->mdl_mech_quotes->where('mech_quotes.workshop_id='.$work_shop_id.'');
	}elseif($CI->session->userdata('user_type') == 4){
		$CI->mdl_mech_quotes->where('mech_quotes.workshop_id='.$work_shop_id.' AND mech_quotes.w_branch_id='.$branch_id.'');
	}
	$quote = $CI->mdl_mech_quotes->get()->row();
    
    $data = (array(
        'quote_id' => $quote_id,
        'quote_detail' => $quote,
        'service_list' => $CI->mdl_mech_quotes->get_user_quote_service_item($quote_id, $quote->customer_id),
        'service_package_list' => $CI->mdl_mech_quotes->get_user_quote_service_package_item($quote_id, $quote->customer_id),
        'product_list' => $CI->mdl_mech_quotes->get_user_quote_product_item($quote_id, $quote->customer_id),
        'service_category_items'=>$CI->mdl_mech_service_item_dtls->get()->result(),
        'product_category_items' =>$CI->mdl_mech_item_master->get()->result(),
        'customer_details' => $CI->mdl_clients->get_by_id($quote->customer_id),
        'title' => 'Estimate',
        'bank_dtls' => $CI->db->get_where('mech_workshop_bank_list', array('module_type' =>'B', 'w_branch_id'=>$quote->branch_id, 'bank_status' => 'A'))->row(),
        'quote' => array(),
    ));
	
	$html = $CI->load->view('mech_quote_templates/pdf/' . $quote_template, $data, true);
    $CI->load->helper('mpdf');

    return pdf_create($html, trans('lable837') . '_' . str_replace(array('\\', '/'), '_', 1), $stream, null);
}

function generate_spare_user_invoice_pdf($invoice_id, $stream = true, $invoice_template = null){
    $CI = &get_instance();
	
	$CI->load->model('spare_invoices/mdl_spare_invoice');
	$CI->load->model('clients/mdl_clients');
    $CI->load->model('mech_item_master/mdl_mech_item_master');
	$CI->load->model('products/mdl_products');
	$CI->load->model('workshop_branch/mdl_workshop_branch');
	$CI->load->model('user_address/mdl_user_address');
	
	if (!$invoice_template) {
        $invoice_template = 'MechMen.php';
    }
	
	$work_shop_id = $CI->session->userdata('work_shop_id');
	$branch_id = $CI->session->userdata('branch_id');
	$CI->mdl_spare_invoice->where('invoice_id='.$invoice_id.'');
	if($CI->session->userdata('user_type') == 3){
		$CI->mdl_spare_invoice->where('spare_invoice.workshop_id='.$work_shop_id.'');
	}elseif($CI->session->userdata('user_type') == 4){
		$CI->mdl_spare_invoice->where('spare_invoice.workshop_id='.$work_shop_id.' AND spare_invoice.w_branch_id='.$branch_id.'');
	}
	$invoice = $CI->mdl_spare_invoice->get()->row();

    $data = (array(
        'invoice_id' => $invoice_id,
        'invoice_detail' => $invoice,
        'product_list' => $CI->mdl_spare_invoice->get_user_quote_product_item($invoice_id, $invoice->customer_id),
        'product_category_items' =>$CI->mdl_mech_item_master->get()->result(),
        'customer_details' => $CI->mdl_clients->get_by_id($invoice->customer_id),
        'title' => 'Invoice',
        'bank_dtls' => $CI->db->get_where('mech_workshop_bank_list', array('module_type' =>'B', 'w_branch_id'=>$invoice->branch_id, 'bank_status' => 'A'))->row(),
        'quote' => array(),
    ));
	
	$html = $CI->load->view('spare_invoice_templates/pdf/' . $invoice_template, $data, true);
    $CI->load->helper('mpdf');

    return pdf_create($html, trans('lable119') . '_' . str_replace(array('\\', '/'), '_', 1), $stream, null);
}

function generate_user_invoice_pdf($invoice_id, $stream = true, $invoice_template = null)
{
	$CI = &get_instance();
	
	$CI->load->model('mech_invoices/mdl_mech_invoice');
	$CI->load->model('clients/mdl_clients');
    $CI->load->model('mech_item_master/mdl_mech_item_master');
	$CI->load->model('products/mdl_products');
	$CI->load->model('workshop_branch/mdl_workshop_branch');
	$CI->load->model('user_address/mdl_user_address');
	
	$CI->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls'); 
	
	if (!$invoice_template) {
        $invoice_template = 'MechMen.php';
    }
	
	$work_shop_id = $CI->session->userdata('work_shop_id');
	$branch_id = $CI->session->userdata('branch_id');
	$CI->mdl_mech_invoice->where('invoice_id='.$invoice_id.'');
	if($CI->session->userdata('user_type') == 3){
		$CI->mdl_mech_invoice->where('mech_invoice.workshop_id='.$work_shop_id.'');
	}elseif($CI->session->userdata('user_type') == 4){
		$CI->mdl_mech_invoice->where('mech_invoice.workshop_id='.$work_shop_id.' AND mech_invoice.w_branch_id='.$branch_id.'');
	}
	$invoice = $CI->mdl_mech_invoice->get()->row();
    $service_package_list = $CI->mdl_mech_invoice->get_user_quote_service_package_item($invoice_id, $invoice->customer_id);

    $data = (array(
        'invoice_id' => $invoice_id,
        'invoice_detail' => $invoice,
        'service_list' => $CI->mdl_mech_invoice->get_user_quote_service_item($invoice_id, $invoice->customer_id),
        'service_package_list' => $service_package_list,
        'product_list' => $CI->mdl_mech_invoice->get_user_quote_product_item($invoice_id, $invoice->customer_id),
        'service_category_items'=>$CI->mdl_mech_service_item_dtls->get()->result(),
        'product_category_items' =>$CI->mdl_mech_item_master->get()->result(),
        'customer_details' => $CI->mdl_clients->get_by_id($invoice->customer_id),
        'title' => 'Invoice',
        'bank_dtls' => $CI->db->get_where('mech_workshop_bank_list', array('module_type' =>'B', 'w_branch_id'=>$invoice->branch_id, 'bank_status' => 'A'))->row(),
        'quote' => array(),
    ));

	$html = $CI->load->view('mech_invoice_templates/pdf/' . $invoice_template, $data, true);
    $CI->load->helper('mpdf');

    return pdf_create($html, trans('lable119') . '_' . str_replace(array('\\', '/'), '_', 1), $stream, null);
}


function generate_user_pos_invoice_pdf($pos_invoice_id, $stream = true, $pos_invoice_template = null)
{
	$CI = &get_instance();
	
	$CI->load->model('mech_pos_invoices/mdl_mech_pos_invoice');
	$CI->load->model('clients/mdl_clients');
    $CI->load->model('mech_item_master/mdl_mech_item_master');
	$CI->load->model('products/mdl_products');
	$CI->load->model('workshop_branch/mdl_workshop_branch');
	$CI->load->model('user_address/mdl_user_address');
	
	$CI->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls'); 
	
	if (!$pos_invoice_template) {
        $pos_invoice_template = 'MechMen.php';
    }
	
	$CI->mdl_mech_pos_invoice->where('invoice_id', $pos_invoice_id);
	$invoice = $CI->mdl_mech_pos_invoice->get()->row();

    $data = (array(
        'invoice_id' => $pos_invoice_id,
        'invoice_detail' => $invoice,
        'service_list' => $CI->mdl_mech_pos_invoice->get_user_quote_service_item($pos_invoice_id, $invoice->customer_id),
        'service_package_list' => $CI->mdl_mech_pos_invoice->get_user_quote_service_package_item($pos_invoice_id, $invoice->customer_id),
        'product_list' => $CI->mdl_mech_pos_invoice->get_user_quote_product_item($pos_invoice_id, $invoice->customer_id),
        'service_category_items'=>$CI->mdl_mech_service_item_dtls->get()->result(),
        'product_category_items' =>$CI->mdl_mech_item_master->get()->result(),
        'customer_details' => $CI->mdl_clients->get_by_id($invoice->customer_id),
        'title' => 'Invoice',
        'bank_dtls' => $CI->db->get_where('mech_workshop_bank_list', array('module_type' =>'B', 'w_branch_id'=>$branch_id, 'bank_status' => 'A'))->row(),
        'quote' => array(),
    ));
	
	$html = $CI->load->view('mech_pos_invoice_templates/pdf/' . $pos_invoice_template, $data, true);
    $CI->load->helper('mpdf');

    return pdf_create($html, trans('lable119') . '_' . str_replace(array('\\', '/'), '_', 1), $stream, null);
}

function generate_user_pos_thermal_invoice_pdf($pos_invoice_id, $stream = true, $pos_thermal_inoivice_template = null)
{
	$CI = &get_instance();
	
	$CI->load->model('mech_pos_invoices/mdl_mech_pos_invoice');
	$CI->load->model('clients/mdl_clients');
    $CI->load->model('mech_item_master/mdl_mech_item_master');
	$CI->load->model('products/mdl_products');
	$CI->load->model('workshop_branch/mdl_workshop_branch');
	$CI->load->model('user_address/mdl_user_address');
	
	$CI->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls'); 
	
	if (!$pos_thermal_inoivice_template) {
        $pos_thermal_inoivice_template = 'MechMenThermal.php';
    }
	
	$CI->mdl_mech_pos_invoice->where('invoice_id', $pos_invoice_id);
    $invoice = $CI->mdl_mech_pos_invoice->get()->row();
    
    $data = (array(
        'invoice_id' => $pos_invoice_id,
        'invoice_detail' => $invoice,
        'service_list' => $CI->mdl_mech_pos_invoice->get_user_quote_service_item($pos_invoice_id, $invoice->customer_id),
        'service_package_list' => $CI->mdl_mech_pos_invoice->get_user_quote_service_package_item($pos_invoice_id, $invoice->customer_id),
        'product_list' => $CI->mdl_mech_pos_invoice->get_user_quote_product_item($pos_invoice_id, $invoice->customer_id),
        'service_category_items'=>$CI->mdl_mech_service_item_dtls->get()->result(),
        'product_category_items' =>$CI->mdl_mech_item_master->get()->result(),
        'customer_details' => $CI->mdl_clients->get_by_id($invoice->customer_id),
        'title' => 'Invoice',
        'bank_dtls' => $CI->db->get_where('mech_workshop_bank_list', array('module_type' =>'B', 'w_branch_id'=>$branch_id, 'bank_status' => 'A'))->row(),
        'quote' => array(),
    ));
    // print_r($data);
	$html = $CI->load->view('mech_pos_invoice_templates/pdf/'.$pos_thermal_inoivice_template, $data, true);
    $CI->load->helper('mpdf');

    return pdf_create($html, trans('lable119') . '_' . str_replace(array('\\', '/'), '_', 1), $stream, null);
}

function generate_jobsheet_pdf($work_order_id, $stream = true, $jobsheet_template = null){

	$CI = &get_instance();
	
	$CI->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');
	$CI->load->model('user_cars/mdl_user_cars');
	$CI->load->model('clients/mdl_clients');
    $CI->load->model('mech_item_master/mdl_mech_item_master');
	$CI->load->model('products/mdl_products');
	$CI->load->model('user_address/mdl_user_address');
	$CI->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls'); 
	$CI->load->model('workshop_branch/mdl_workshop_branch');
	$CI->load->model('mech_employee/mdl_mech_employee');
	$CI->load->model('users/mdl_users');
	$CI->load->model('mech_invoices/mdl_mech_invoice'); 
	
	if (!$jobsheet_template) {
	    $jobsheet_template = 'MechMen.php';
	}
	
	$work_shop_id = $CI->session->userdata('work_shop_id');
	$branch_id = $CI->session->userdata('branch_id');
	
	$CI->mdl_mech_work_order_dtls->where('work_order_id='.$work_order_id.'');
	if($CI->session->userdata('user_type') == 3){
	    $CI->mdl_mech_work_order_dtls->where('mech_work_order_dtls.workshop_id='.$work_shop_id.'');
	}elseif($CI->session->userdata('user_type') == 4){
	    $CI->mdl_mech_work_order_dtls->where('mech_work_order_dtls.workshop_id='.$work_shop_id.' AND mech_work_order_dtls.w_branch_id='.$branch_id.'');
	}
	$work_order_list = $CI->mdl_mech_work_order_dtls->get()->row();
	$user_cars = $CI->mdl_user_cars->get_customer_cars_list($work_order_list->customer_id);
	$address_dtls = $CI->db->get_where('mech_user_address', array('status' => 1, 'user_id' => $work_order_list->customer_id, 'workshop_id' => $work_shop_id))->result();
	
	if($work_order_list->refered_by_type == '2'){
	    $refered_dtls = $CI->db->get_where('mech_employee', array('mech_employee.employee_status' => 1, 'mech_employee.workshop_id' => $work_shop_id))->result();
	}elseif($work_order_list->refered_by_type == '1'){
	    $refered_dtls = $CI->mdl_clients->where('client_active','A')->get()->result();
	}
	
	$selected_checkin_list = $CI->db->get_where('mech_vehicle_checkin_dtls', array('mech_vehicle_checkin_dtls.work_order_id' => $work_order_id, 'mech_vehicle_checkin_dtls.workshop_id' => $work_shop_id))->result();
	$service_remainder = $CI->db->select('*')->from('mech_service_remainder')->where('work_order_id',$work_order_id )->where('workshop_id',$work_shop_id)->get()->row();
	$insurance_remainder = $CI->db->select('*')->from('mech_insurance_remainder')->where('work_order_id',$work_order_id )->where('workshop_id',$work_shop_id)->get()->row();
    
    $product_list = $CI->mdl_mech_work_order_dtls->get_user_quote_product_item($work_order_id, $work_order_list->customer_id);
    $service_list = $CI->mdl_mech_work_order_dtls->get_user_quote_service_item($work_order_id, $work_order_list->customer_id);
    $service_package_list = $CI->mdl_mech_work_order_dtls->get_user_quote_service_package_item($work_order_id, $work_order_list->customer_id);
    
	$upload_details = $CI->db->select('*')->from('ip_uploads')->where('entity_type','J' )->where('entity_id',$work_order_id )->where('workshop_id',$work_shop_id)->get()->result();
	
    $user_details = $CI->mdl_clients->get_by_id($work_order_list->customer_id);
	
	if (!$jobsheet_template) {
	    $jobsheet_template = 'MechMen.php';
    }
	
	$data = (array(
	    'work_order_id' => $work_order_id,
	    'work_order_detail' => $work_order_list,
        'service_list' => $service_list,
        'product_list' => $product_list,
        'service_package_list' => $service_package_list,
	    'customer_details' => $CI->mdl_clients->get_by_id($work_order_list->customer_id),
	    'title' => 'Jobcard',
	    'bank_dtls' => $CI->db->get_where('mech_workshop_bank_list', array('module_type' =>'B', 'w_branch_id'=>$branch_id, 'bank_status' => 'A'))->row(),
     ));
	
	
	$html = $CI->load->view('mech_jobsheet_templates/pdf/' . $jobsheet_template, $data, true);
    $CI->load->helper('mpdf');

    return pdf_create($html, trans('lable1019') . '_' . str_replace(array('\\', '/'), '_', 1), $stream, null);
}

function generate_insurance_pdf($work_order_id = NULL, $stream = true, $jobsheet_template = null){

    $CI = &get_instance();
    
    $CI->load->model('mech_work_order_dtls/mdl_mech_work_order_dtls');
    $CI->load->model('mech_insurance/mdl_mech_insurance_billing');
    $CI->load->model('user_address/mdl_user_address');
	
	if (!$jobsheet_template) {
	    $jobsheet_template = 'MechInsurance.php';
    }
	
	$CI->mdl_mech_work_order_dtls->where('work_order_id' , $work_order_id);
    $jobsheets = $CI->mdl_mech_work_order_dtls->get()->row();

    if($jobsheets->insuranceBillingCheckBox){
        $CI->mdl_mech_insurance_billing->where('mins_id' , $jobsheets->mins_id);
        $insurance = $CI->mdl_mech_insurance_billing->get()->row();
    }

    $service_list = $CI->mdl_mech_work_order_dtls->get_user_quote_service_item($work_order_id, $jobsheets->customer_id);
    $product_list = $CI->mdl_mech_work_order_dtls->get_user_quote_product_item($work_order_id, $jobsheets->customer_id);
    $service_package_list = $CI->mdl_mech_work_order_dtls->get_user_quote_service_package_item($work_order_id, $jobsheets->customer_id);

	$data = (array(
        'insurance_id' => $insurance_id,
        'work_order_detail' => $jobsheets,
        'insurance' => $insurance,
        'service_list' => $service_list,
        'product_list' => $product_list,
        'service_package_list' => $service_package_list,
	    'title' => 'Insurance',
     ));
	
	$html = $CI->load->view('mech_jobsheet_templates/pdf/' . $jobsheet_template, $data, true);
    $CI->load->helper('mpdf');

    return pdf_create($html, trans('lable562') . '_' . str_replace(array('\\', '/'), '_', 1), $stream, null);

}

function generate_user_purchase_pdf($purchase_id, $stream = true, $purchase_template = null){
    
    $CI = &get_instance();
    
    $CI->load->model('mech_purchase/mdl_mech_purchase');
    $CI->load->model('clients/mdl_clients');
    $CI->load->model('mech_item_master/mdl_mech_item_master');
    $CI->load->model('products/mdl_products');
    $CI->load->model('workshop_branch/mdl_workshop_branch');
    $CI->load->model('user_address/mdl_user_address');
    
    $CI->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls'); 
    
    if (!$purchase_template) {
        $purchase_template = 'MechMen.php';
    }
    
    $work_shop_id = $CI->session->userdata('work_shop_id');
    $branch_id = $CI->session->userdata('branch_id');
    $CI->mdl_mech_purchase->where('purchase_id='.$purchase_id.'');
    if($CI->session->userdata('user_type') == 3){
        $CI->mdl_mech_purchase->where('mech_purchase.workshop_id='.$work_shop_id.'');
    }elseif($CI->session->userdata('user_type') == 4){
        $CI->mdl_mech_purchase->where('mech_purchase.workshop_id='.$work_shop_id.' AND mech_purchase.w_branch_id='.$branch_id.'');
    }
    $purchase = $CI->mdl_mech_purchase->get()->row();
    
    $data = (array(
        'purchase_id' => $purchase_id,
        'purchase_detail' => $purchase,
        'product_list' => $CI->mdl_mech_purchase->get_purchase_product_item($purchase_id),
        'customer_details' => $CI->mdl_clients->get_by_id($purchase->customer_id),
        'title' => 'Purchase',
        'bank_dtls' => $CI->db->get_where('mech_workshop_bank_list', array('module_type' =>'B', 'w_branch_id'=>$branch_id, 'bank_status' => 'A'))->row(),
        'purchase' => array(),
    ));
    
    $html = $CI->load->view('mech_purchase_templates/pdf/' . $purchase_template, $data, true);
    $CI->load->helper('mpdf');
    
    return pdf_create($html, trans('purchase') . '_' . str_replace(array('\\', '/'), '_', 1), $stream, null);
}

function generate_user_purchase_order_pdf($purchase_id, $stream = true, $purchase_template = null){
    
    $CI = &get_instance();
    
    $CI->load->model('mech_purchase_order/mdl_mech_purchase_order');
    $CI->load->model('clients/mdl_clients');
    $CI->load->model('mech_item_master/mdl_mech_item_master');
    $CI->load->model('products/mdl_products');
    $CI->load->model('workshop_branch/mdl_workshop_branch');
    $CI->load->model('user_address/mdl_user_address');
    
    $CI->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls'); 
    
    if (!$purchase_template) {
        $purchase_template = 'MechMen.php';
    }
    
    $work_shop_id = $CI->session->userdata('work_shop_id');
    $branch_id = $CI->session->userdata('branch_id');
    $CI->mdl_mech_purchase_order->where('purchase_id='.$purchase_id.'');
    if($CI->session->userdata('user_type') == 3){
        $CI->mdl_mech_purchase_order->where('mech_purchase_order.workshop_id='.$work_shop_id.'');
    }elseif($CI->session->userdata('user_type') == 4){
        $CI->mdl_mech_purchase_order->where('mech_purchase_order.workshop_id='.$work_shop_id.' AND mech_purchase_order.w_branch_id='.$branch_id.'');
    }
    $purchase = $CI->mdl_mech_purchase_order->get()->row();
    
    $data = (array(
        'purchase_id' => $purchase_id,
        'purchase_detail' => $purchase,
        'product_list' => $CI->mdl_mech_purchase_order->get_purchase_product_item($purchase_id),
        'customer_details' => $CI->mdl_clients->get_by_id($purchase->customer_id),
        'title' => 'Purchase',
        'bank_dtls' => $CI->db->get_where('mech_workshop_bank_list', array('module_type' =>'B', 'w_branch_id'=>$branch_id, 'bank_status' => 'A'))->row(),
        'purchase' => array(),
    ));
    
    $html = $CI->load->view('mech_purchase_templates/pdf/' . $purchase_template, $data, true);
    $CI->load->helper('mpdf');
    
    return pdf_create($html, trans('purchase') . '_' . str_replace(array('\\', '/'), '_', 1), $stream, null);
}

function generate_user_expense_pdf($expense_id, $stream = true, $expense_template = null){
    
    $CI = &get_instance();
    
    $CI->load->model('mech_expense/mdl_mech_expense');
    $CI->load->model('clients/mdl_clients');
    $CI->load->model('mech_item_master/mdl_mech_item_master');
    $CI->load->model('products/mdl_products');
    $CI->load->model('workshop_branch/mdl_workshop_branch');
    $CI->load->model('user_address/mdl_user_address');
    
    $CI->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls'); 
    
    if (!$expense_template) {
        $expense_template = 'MechMen.php';
    }
    
    $work_shop_id = $CI->session->userdata('work_shop_id');
    $branch_id = $CI->session->userdata('branch_id');
    $CI->mdl_mech_expense->where('expense_id='.$expense_id.'');
    if($CI->session->userdata('user_type') == 3){
        $CI->mdl_mech_expense->where('mech_expense.workshop_id='.$work_shop_id.'');
    }elseif($CI->session->userdata('user_type') == 4){
        $CI->mdl_mech_expense->where('mech_expense.workshop_id='.$work_shop_id.' AND mech_expense.w_branch_id='.$branch_id.'');
    }
    $expense = $CI->mdl_mech_expense->get()->row();
    
    $data = (array(
        'expense_id' => $expense_id,
        'expense_detail' => $expense,
        'product_list' => $CI->mdl_mech_expense->get_expense_product_item($expense_id),
        'customer_details' => $CI->mdl_clients->get_by_id($expense->customer_id),
        'title' => 'Expense',
        'bank_dtls' => $CI->db->get_where('mech_workshop_bank_list', array('module_type' =>'B', 'w_branch_id'=>$branch_id, 'bank_status' => 'A'))->row(),
        'expense' => array(),
    ));
    
    $html = $CI->load->view('mech_expense_templates/pdf/' . $expense_template, $data, true);
    $CI->load->helper('mpdf');
    
    return pdf_create($html, trans('expense') . '_' . str_replace(array('\\', '/'), '_', 1), $stream, null);
}

function generate_employee_pdf($employee_id, $stream = true, $employee_template = null)
{
	$CI = &get_instance();
	
	$CI->load->model('mech_employee/mdl_mech_employee');
    $CI->load->model('mech_custom_table/mdl_mech_custom_table');
    $CI->load->model('upload/mdl_uploads');
    $CI->load->model('workshop_branch/mdl_workshop_branch');
    $CI->load->model('mech_bank_list/mdl_mech_bank_list');
    $CI->load->model('mech_employee/mdl_mech_employee_experience');

	
	if (!$employee_template) {
        $employee_template = 'MechMen.php';
    }
	
	$work_shop_id = $CI->session->userdata('work_shop_id');
	$branch_id = $CI->session->userdata('branch_id');
	$CI->mdl_mech_employee->where('employee_id='.$employee_id.'');
	if($CI->session->userdata('user_type') == 3){
		$CI->mdl_mech_employee->where('mech_employee.workshop_id='.$work_shop_id.'');
	}elseif($CI->session->userdata('user_type') == 4 || $CI->session->userdata('user_type') == 5 || $CI->session->userdata('user_type') == 6){
		$CI->mdl_mech_employee->where('mech_employee.workshop_id='.$work_shop_id.' AND mech_employee.w_branch_id='.$branch_id.'');
	}
	$employee = $CI->mdl_mech_employee->get()->row();
	$employee_document_list = $CI->mdl_uploads->getEmployeeDocuments($employee_id);
    $employee_custom_list = $CI->mdl_mech_custom_table->getEntityCustomList($employee_id, 'E');
    $employee_skill_list = $CI->mdl_mech_employee->getEmployeeSkills($employee->skill_ids);
    $employeeExperience = $CI->mdl_mech_employee_experience->getEmployeeExperience($employee_id);
    $employeebank = $CI->mdl_mech_bank_list->getEmployeebanklist($employee_id, 'E');

    $data = (array(
        'employee_id' => $employee_id,
        'employee_details' => $employee,
        'employee_document_list' => $employee_document_list,
        'employee_custom_list' => $employee_custom_list,
        'employee_experience_list' => $employeeExperience,
        'employeebank' => $employeebank,
        'employee_skill_list' => $employee_skill_list,
        'title' => 'Employee',
        'employee' => array(),
    ));
		
	$html = $CI->load->view('mech_employee_templates/pdf/'.$employee_template,$data, true);
    $CI->load->helper('mpdf');

    return pdf_create($html, trans('label942') . '_' . str_replace(array('\\', '/'), '_', 1), $stream, null);

}

function generate_subscription_pdf($subscription_id = null, $stream = true, $subscription_template = null){
    $CI = &get_instance();
    
    $CI->load->model('subscription_details/mdl_subscription_details');
    $CI->load->model('clients/mdl_clients');
    $CI->load->model('mech_item_master/mdl_mech_item_master');
    $CI->load->model('products/mdl_products');
    $CI->load->model('workshop_branch/mdl_workshop_branch');
    $CI->load->model('user_address/mdl_user_address');
    $CI->load->model('mechanic_service_item_price_list/mdl_mech_service_item_dtls'); 
    
    if (!$subscription_template) {
        $subscription_template = 'MechMen.php';
    }
    
    $work_shop_id = $CI->session->userdata('work_shop_id');
    $branch_id = $CI->session->userdata('branch_id');
   
    $sub_deplan_list = $CI->mdl_subscription_details->get_subscription_plan($subscription_id);

    $data = (array(
        'subscription_id' => $subscription_id,
        'subscription_list' => $sub_deplan_list,
        'workshop_det' => $CI->mdl_subscription_details->get_workshop_det($work_shop_id),
        'title' => 'subscription',
        'subscription' => array(),
    ));
    
    $html = $CI->load->view('mech_subscription_templates/pdf/' . $subscription_template, $data, true);
    $CI->load->helper('mpdf');
    
    return pdf_create($html, trans('lable1141') . '_' . str_replace(array('\\', '/'), '_', 1), $stream, null);
}

function generate_reports($report_name, $from_date, $to_date, $data, $stream = true, $reports_template =null)
{
	$CI = &get_instance();

    $CI->load->model('reports/mdl_reports');
    $CI->load->model('workshop_branch/mdl_workshop_branch');
    $CI->load->model('clients/mdl_clients');

    
	if (!$reports_template) {
        $reports_template = $report_name.'.php';
    }

    if($report_name == "Todaysreport"){
        $results = $CI->mdl_reports->todaysreportinvoice($from_date, $to_date, $myArray = explode(',', str_replace("-",",",$data['branch_id'])));
    }else if($report_name == "CustomerDueReports"){
        $results = $CI->mdl_reports->customer_due_report($from_date, $to_date, $data['branch_id']);
    }else if($report_name == "ServiceSumaryReport"){
        $results = $CI->mdl_reports->service_by_summary($from_date, $to_date, $data['branch_id']);
    }else if($report_name == "SalesServiceReports"){
        $results = $CI->mdl_reports->service_category($from_date, $to_date, $data['branch_id']);
    }else if($report_name == "SalesServiceCustomerReports"){
        $results = $CI->mdl_reports->sales_service_by_client($from_date, $to_date, $data['branch_id']);
    }else if($report_name == "SalesSummaryReports"){
        $results = $CI->mdl_reports->sales_by_summary($from_date, $to_date, $data['branch_id']);
    }else if($report_name == "SalesProductReports"){
        $results = $CI->mdl_reports->sales_by_product($from_date, $to_date, $data['branch_id']);
    }else if($report_name == "SalesProductCustomerReports"){
        $results = $CI->mdl_reports->sales_product_by_client($from_date, $to_date, $data['branch_id']);
    }else if($report_name == "ExpenseReports"){
        $results = $CI->mdl_reports->expense_detail($from_date, $to_date, $myArray = explode(',', str_replace("-",",",$data['branch_id'])));
    }else if($report_name == "ExpenseCategoryReports"){
        $results = $CI->mdl_reports->expense_by_category($from_date, $to_date, $data['branch_id']);
    }else if($report_name == "ReferenceTypeReport"){
        $results = $CI->mdl_reports->reference_type_report($from_date, $to_date, $data['branch_id'], $data['refered_by_type'], $data['refered_by_id']);
    }else if($report_name == "CustomerLedgerReport"){
        $results = $CI->mdl_reports->customer_ledger($from_date, $to_date, $data['branch_id'], $data['customer_id']);
        $customer_info = $CI->mdl_reports->customernameledger($data['customer_id']);
    }else if($report_name == "SupplierLedgerReport"){
        $results = $CI->mdl_reports->supplier_ledger($from_date, $to_date, $data['branch_id'], $data['supplier_id']);
        $supplier_info = $CI->mdl_reports->suppliernameledger($data['supplier_id']);
    }else if($report_name == "ProductLedgerReport"){
        $results = $CI->mdl_reports->product_ledger($from_date, $to_date, $data['branch_id'], $data['product_id']);
        $product_info = $CI->mdl_reports->productnameledger($data['product_id']);
        $results_sales = $CI->mdl_reports->product_ledger_salesreport($from_date, $to_date, $data['branch_id'], $data['product_id']);
    }else if($report_name == "PurchaseSummaryReport"){
        $results = $CI->mdl_reports->purchase_by_summary($from_date, $to_date, $data['branch_id']);
    }

    $data = (array(
        'results' => $results,
        'customer_info' => $customer_info,
        'supplier_info' => $supplier_info,
        'product_info' => $product_info,
        'results_sales' => $results_sales,
        'from_date' => $from_date,
        'to_date' => $to_date,
        'title' => $report_name,
    ));
    
    $html = $CI->load->view('mech_report_templates/pdf/'.$reports_template,$data, true);
    $CI->load->helper('mpdf');
    
    return pdf_create($html, trans('menu13') . '_' . str_replace(array('\\', '/'), '_', 1), $stream, null);
    
}

function generate_history_reports($report_name,$vehicle_no, $stream = true, $reports_template =null)
{
	$CI = &get_instance();
    $CI->load->model('reports/mdl_reports');
    $CI->load->model('workshop_branch/mdl_workshop_branch');
    $CI->load->model('clients/mdl_clients');

	if (!$reports_template) {
        $reports_template = $report_name.'.php';
    }

    if($report_name == "ServiceHistoryReport"){
        $mech_invoices = $CI->mdl_reports->vehicle_service_history($vehicle_no);
    }
    $rep_name ="Service History Report";

    $data = (array(
        'mech_invoices' => $mech_invoices,
        'vehicle_no' => $vehicle_no,
        'title' => $rep_name,
    ));
    
    $html = $CI->load->view('mech_report_templates/pdf/'.$reports_template,$data, true);
    $CI->load->helper('mpdf');
    
    return pdf_create($html, trans('menu13') . '_' . str_replace(array('\\', '/'), '_', 1), $stream, null);
    
}

function generate_inventory_reports($report_name,$product_name,$product_category, $stream = true, $reports_template =null)
{
	$CI = &get_instance();
    $CI->load->model('reports/mdl_reports');
    $CI->load->model('workshop_branch/mdl_workshop_branch');
    $CI->load->model('clients/mdl_clients');
    $CI->load->model('families/mdl_families');

	if (!$reports_template) {
        $reports_template = $report_name.'.php';
    }

    if($report_name == "InventoryInHand"){
        $results = $CI->mdl_reports->product_inventory_hand($product_name,$product_category);
    }
    $rep_name ="Inventory InHand Report";

    $data = (array(
        'results' => $results,
        'families' => $CI->mdl_families->get()->result(),
        'product_name' => $product_name,
        'product_category' => $product_category,
        'title' => $rep_name,
    ));
    
    $html = $CI->load->view('mech_report_templates/pdf/'.$reports_template,$data, true);
    $CI->load->helper('mpdf');
    
    return pdf_create($html, trans('menu13') . '_' . str_replace(array('\\', '/'), '_', 1), $stream, null);
    
}

function generate_inventory_lowstock_reports($report_name,$product_name,$product_category, $stream = true, $reports_template =null)
{
	$CI = &get_instance();
    $CI->load->model('reports/mdl_reports');
    $CI->load->model('workshop_branch/mdl_workshop_branch');
    $CI->load->model('clients/mdl_clients');
    $CI->load->model('families/mdl_families');

	if (!$reports_template) {
        $reports_template = $report_name.'.php';
    }

    if($report_name == "InventoryLowStock"){
        $results = $CI->mdl_reports->product_inventory_lowstock($product_name,$product_category);
    }
    $rep_name ="Inventory Low Stock Report";

    $data = (array(
        'results' => $results,
        'families' => $CI->mdl_families->get()->result(),
        'product_name' => $product_name,
        'product_category' => $product_category,
        'title' => $rep_name,
    ));
    
    $html = $CI->load->view('mech_report_templates/pdf/'.$reports_template,$data, true);
    $CI->load->helper('mpdf');
    
    return pdf_create($html, trans('menu13') . '_' . str_replace(array('\\', '/'), '_', 1), $stream, null);
    
}
