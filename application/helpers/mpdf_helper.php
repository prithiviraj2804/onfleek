<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');



/**
 * Create a PDF
 *
 * @param $html
 * @param $filename
 * @param bool $stream
 * @param null $password
 * @param null $isInvoice
 * @param null $is_guest
 * @param bool $zugferd_invoice
 * @param null $associated_files
 * @return string
 */
function pdf_create($html, $filename, $stream = true, $password = null, $isInvoice = null, $is_guest = null, $zugferd_invoice = false, $associated_files = null)
{
    // echo "dddd";
	
    $CI = &get_instance();

    // Get the invoice from the archive if available
    $invoice_array = array();

    if (!(is_dir('./uploads/temp/') || is_link('./uploads/temp/'))) {
        mkdir('./uploads/temp/', '0777');
        if (!(is_dir('./uploads/temp/mpdf') || is_link('./uploads/temp/mpdf'))) {
            mkdir('./uploads/temp/mpdf', '0777');
        }
    }

    // mPDF loading
    if (!defined('_MPDF_TEMP_PATH')) {
        define('_MPDF_TEMP_PATH', FCPATH . 'uploads/temp/mpdf/');
        define('_MPDF_TTFONTDATAPATH', FCPATH . 'uploads/temp/mpdf/');
    }

    require_once(FCPATH . 'vendor/autoload.php');
    $mpdf = new \Mpdf\Mpdf();

    // mPDF configuration
    $mpdf->useAdobeCJK = true;
    $mpdf->autoScriptToLang = true;

    if (IP_DEBUG) {
        // Enable image error logging
        $mpdf->showImageErrors = true;
    }

    // Include zugferd if enabled
    if ($zugferd_invoice) {
        $CI->load->helper('zugferd');
        $mpdf->PDFA = true;
        $mpdf->PDFAauto = true;
        $mpdf->SetAdditionalXmpRdf(zugferd_rdf());
        $mpdf->SetAssociatedFiles($associated_files);
    }
    $mpdf->setAutoTopMargin = 'stretch';

    // Set a password if set for the voucher
    if (!empty($password)) {
        $mpdf->SetProtection(array('copy', 'print'), $password, $password);
    }

    // Check if the archive folder is available
    if (!(is_dir('./uploads/archive/') || is_link('./uploads/archive/'))) {
        mkdir('./uploads/archive/', '0777');
    }

/*
echo $CI->mdl_settings->settings['pdf_invoice_header'];
exit();*/
//echo '<header style="background-color: black;color:#FFC806;padding: 5px 0;margin-bottom: 30px;width:100%;float:left">' . $CI->mdl_settings->settings['pdf_invoice_header'] . '</header><div class="clearfix" style="display: table;clear: both"></div>';
//exit();
//$mpdf->SetHTMLHeader('<header style="background-color: black;color:#FFC806;padding: 5px 0;margin-bottom: 30px;width:100%;float:left">' . $CI->mdl_settings->settings['pdf_invoice_header'] . '</header><div class="clearfix" style="display: table;clear: both"></div>', 0);
    // Set the footer if voucher is invoice and if set in settings
    if (!empty($CI->mdl_settings->settings['pdf_invoice_footer'])) {
        $mpdf->setAutoBottomMargin = 'stretch';
		//echo $CI->mdl_settings->settings['pdf_invoice_footer'];
		//exit();
       // $mpdf->SetHTMLFooter('<div id="footer" style="color: #878686; width: 100%; border-top: 2px solid #878686; padding: 8px 0; float: left;width: 100%">' . $CI->mdl_settings->settings['pdf_invoice_footer'] . '</div>');
    }
	$mpdf->lMargin= 0;
	$mpdf->tMargin= 0;
	$mpdf->rMargin= 0;
	$mpdf->bMargin= 0;
	$mpdf->cMarginL= 0;
	$mpdf->cMarginR= 0;
	$mpdf->DeflMargin= 0;
	$mpdf->DefrMargin= 0;
	
    $mpdf->WriteHTML($html);

    if ($isInvoice) {

        foreach (glob(UPLOADS_FOLDER . 'archive/*' . $filename . '.pdf') as $file) {
            array_push($invoice_array, $file);
        }

        if (!empty($invoice_array) && !is_null($is_guest)) {
            rsort($invoice_array);

            if ($stream) {
                return $mpdf->Output($filename . '.pdf', 'I');
            } else {
                return $invoice_array[0];
            }
        }

        $archived_file = UPLOADS_FOLDER . 'archive/' . date('Y-m-d') . '_' . $filename . '.pdf';
        $mpdf->Output($archived_file, 'F');

        if ($stream) {
            return $mpdf->Output($filename . '.pdf', 'I');
        } else {
            return $archived_file;
        }
    }

    // If $stream is true (default) the PDF will be displayed directly in the browser
    // otherwise will be returned as a download
    if ($stream) {
        return $mpdf->Output($filename . '.pdf', 'I');
    } else {

        $mpdf->Output(UPLOADS_FOLDER . 'temp/' . $filename . '.pdf', 'F');

        // Housekeeping
        // Delete any files in temp/ directory that are >1 hrs old
        $interval = 3600;
        if ($handle = @opendir(preg_replace('/\/$/', '', './uploads/temp/'))) {
            while (false !== ($file = readdir($handle))) {
                if (($file != '..') && ($file != '.') && !is_dir($file) && ((filemtime('./uploads/temp/' . $file) + $interval) < time()) && (substr($file, 0, 1) !== '.') && ($file != 'remove.txt')) { // mPDF 5.7.3
                    unlink(UPLOADS_FOLDER . 'temp/' . $file);
                }
            }
            closedir($handle);
        }

        return UPLOADS_FOLDER . 'temp/' . $filename . '.pdf';

    }
}
