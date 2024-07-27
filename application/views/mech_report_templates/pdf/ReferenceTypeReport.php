<!DOCTYPE html>
<html lang="<?php _trans('cldr'); ?>">
<head>
    <meta charset="utf-8">
    <title><?php _trans('menu13'); ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mechmen_pdf/css/templates.css">
    <style>
        @page {
            margin-top: 3.5cm;
            margin-bottom: 1cm;
            margin-left: 1cm;
            margin-right: 1cm;
            margin-header: 0mm;
            margin-footer: 0mm;
            footer: html_myHTMLFooter;
            header: html_myHTMLHeader;
        }
        .customer-details tr td {
            padding-bottom: 8px;
            height: 50px;
            vertical-align: middle;
            border-top-color: #d8e2e7;
            padding: 11px 10px 10px;
            border: 1px solid #eceeef;
        }
        .customer-details tr th {
            font-weight: 700;
            vertical-align: middle;
            border-top-color: #d8e2e7;
            padding: 11px 10px 10px;
            border: 1px solid #eceeef;
            text-align: left;
        }
    </style>
</head>
<body>
    <htmlpageheader name="myHTMLHeader">
        <table width="100%">
            <tr width="100%">
                <td style="width:50%;text-align: left;padding: 10px 10px;">
                    <div class="company_logo">
                        <?php $company_details = $this->mdl_workshop_branch->get_company_branch_details();
												if ($company_details->workshop_logo) { ?>
                        <img class="hidden-md-down" src="<?php echo base_url(); ?>uploads/workshop_logo/<?php echo $company_details->workshop_logo; ?>" width="150" height="150" alt="<?php echo $company_details->workshop_name; ?>">
                        <?php 
											} ?>
                    </div>
                </td>
                <td style="width:50%;text-align: right; padding: 10px 10px;">
                    <div>
                        <?php echo $company_details->workshop_name; ?>
                        <?php if ($company_details->branch_street) {
                                echo $company_details->branch_street;
                            }
                            if ($company_details->area_name) {
                                echo ", <br>" . $company_details->area_name;
                            }
                            if ($company_details->state_name) {
                                echo ", <br>" . $company_details->state_name;
                            }
                            if ($company_details->branch_pincode) {
                                echo " - " . $company_details->branch_pincode;
                            }
							if ($company_details->branch_country) { echo $company_details->name; } ?>
                        <?php if ($company_details->branch_contact_no) { echo '<br><span>' . $company_details->branch_contact_no . '</span>'; } ?>
                        <?php if ($company_details->branch_email_id) { echo '<br><span>' . $company_details->branch_email_id . '</span>'; } ?>
                        <?php if ($company_details->branch_gstin) { echo '<br><span>' . $company_details->branch_gstin . '</span>'; } ?>
                    </div>
                </td>
            </tr>
        </table>
        <hr>
    </htmlpageheader>
    <htmlpagefooter name="myHTMLFooter">
        <div class="footer_bg"><?php _trans('lable1045'); ?></div>
    </htmlpagefooter>
    <main style="padding:20px;">
        <div style="width:100%;float:left;padding:5px;">
            <h4 style="padding:0px; margin: 0;font-size:18px;"><?php echo $title; ?></h4>
        </div>
        <div style="width:100%;float:left;padding:5px;">
            <h4 style="padding:0px; margin: 0;font-size:18px;"><?php _trans('lable1044'); ?> <?php echo $from_date; ?> <?php _trans('lable176'); ?> <?php echo $to_date;?></h4>
        </div>
        <table class="customer-details" style="font-size:.9375rem;margin-bottom: 0;background: #fff;table-layout:fixed;border: 1px solid #eceeef;width: 100%;max-width: 100%;border-collapse: collapse;border-spacing: 0;" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th><?php _trans('lable976'); ?></th>
                <th class="text_align_center" ><?php _trans('lable368'); ?></th>
                <th class="text_align_center"><?php _trans('lable640'); ?></th>
                <th class="text_align_right"><?php _trans('lable332'); ?></th>
                <th class="text_align_right"><?php _trans('lable978'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($results) > 0){
                $overall_grand_total = 0;
                $overallInvoiceCount = 0;
                $overallCommissionCount = 0;
            foreach ($results as $result){ 
                $overallInvoiceCount += $result->invoice_count;
                $overall_grand_total += $result->grand_total; 
                $overallCommissionCount += 0 ?>
                <tr>
                    <td class="text_align_left"><?php echo $result->refer_name; ?> <br> <?php echo $result->entity_name; ?></td>
                    <td class="text_align_center"><?php echo date_from_mysql($result->invoice_date); ?></td>
                    <td class="text_align_center"><?php echo $result->invoice_count; ?></td>
                    <td class="text_align_right"><?php echo $result->grand_total; ?></td>
                    <td class="text_align_right"><?php echo 0 ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td></td>
                <td></td>
                <td class="text-center">
                    <span><strong><?php _trans('lable885'); ?> = </strong><strong><?php echo $overallInvoiceCount; ?></strong></span>
                </td>
                <td class="text-right">
                    <span class="float_right"><strong><?php _trans('lable625'); ?> = </strong><strong><?php echo format_currency($overall_grand_total, 2); ?></strong></span>
                </td>
                <td class="text-right">
                    <span class="float_right"><strong><?php _trans('lable979'); ?> = </strong><strong><?php echo format_currency($overallCommissionCount, 2); ?></strong></span>
                </td>
            <tr>
            <?php }else{ ?>
            <tr>
                <td colspan="5" align="center"><?php _trans('lable343'); ?></td>
            </tr>
            <?php } ?>
        </tbody>
        </table>
    </main>
	<?php //exit(); ?>
</body>
</html> 