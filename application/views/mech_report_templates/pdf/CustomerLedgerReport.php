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
        <div class="row">
            <hr style="border-top-color: #c5d6de;margin: 5px;width:100%">
        </div>
        <div style="width:100%;float:left;padding:5px;">
            <h5 style="padding:0px; margin: 0;font-size:14px;"><?php _trans('lable998'); ?></h5>
        </div>

        <div class="row">
            <hr style="border-top-color: #c5d6de;margin: 5px;width:100%">
        </div>

        <div id="content" class="table-content">
            <?php $this->layout->load_view('layout/alerts'); ?>
            <section class="card">
            <table width="100%" class="item-tables">
            <tr width="100%">
                <td width="45%" style="width:45%;float: left;">
                    <table width="100%">
                            <tr width="100%">
                                <td width="40%"><?php _trans('lable36');?> :</td>
                                <?php foreach ($customer_info as $customer_in){  ?>
                                <td width="100%"><?php echo $customer_in->client_name; ?></td>
                                <?php } ?>
                            </tr>

                            <tr width="100%">
                                <td width="40%"><?php _trans('lable999');?> :</td>
                                <?php foreach ($customer_info as $customer_in){  ?>
                                <td width="100%"><?php echo ($customer_in->customer_street_1?$customer_in->customer_street_1:"")." ".($customer_in->customer_street_2?",".$customer_in->customer_street_2:"")." ".($customer_in->area?",".$customer_in->area:"")." ".($customer_in->city_name?",".$customer_in->city_name:"")." ".($customer_in->state_name?",".$customer_in->state_name:"")." ".($customer_in->country_name?",".$customer_in->country_name:"")." ".($customer_in->zip_code?",".$customer_in->zip_code:""); ?></td>
                                <?php } ?>
                            </tr>
                            
                            <tr width="100%">
                                <td width="40%"><?php _trans('label946');?> :</td>
                                <?php foreach ($customer_info as $customer_in){  ?>
                                <td width="100%"><?php echo $customer_in->client_contact_no; ?></td>
                                <?php } ?>
                            </tr>
                    </table>
                </td>
                <td width="15%" style="float: right; text-align: right;">
                    <table width="100%" style="width:100%;float: right" class="item-tables">
                    <?php if(count($results) > 0){
                            $overall_grand_total = 0;
                            $overall_total_paid_amount = 0;
                            $overall_total_due_amount = 0;
                        foreach ($results as $result){ 
                            $overall_grand_total += $result->grand_total;
                            $overall_total_paid_amount += $result->total_paid_amount;
                            $overall_total_due_amount += $result->total_due_amount;?>
                        <?php } ?>
                        <tr style="background-color: #F8F9F9;">
                        <th style="float: left; text-align: left;"><?php _trans('lable1002'); ?></th>
                        <td style="float: right; text-align: right;"><strong><?php echo format_currency($overall_total_paid_amount); ?></strong></td>
                        </tr>
                        <tr>
                        <th style="float: left; text-align: left;"><?php _trans('lable1003'); ?></th>
                        <td style="float: right; text-align: right;"><strong><?php echo format_currency($overall_grand_total); ?></strong></td>
                        </tr>
                        <tr style="background-color: #F8F9F9;">
                        <th style="float: left; text-align: left;"><?php _trans('lable1004'); ?></th>
                        <td style="float: right; text-align: right;"><strong><?php echo format_currency($overall_total_due_amount); ?></strong></td>
                        </tr>
                        <?php } ?>
                    </table>
                </td>
            </tr>
        </table>
            </section>
        </div>
        
        <table class="customer-details" style="font-size:.9375rem;margin-bottom: 0;background: #fff;table-layout:fixed;border: 1px solid #eceeef;width: 100%;max-width: 100%;border-collapse: collapse;border-spacing: 0;" cellspacing="0" width="100%">
        <thead>
            <tr>
            <th style="float: left; text-align: left;"><?php _trans('lable29'); ?></th>
            <th style="float: left; text-align: left;"><?php _trans('lable31'); ?></th>
            <th class="text_align_left"><?php _trans('lable127'); ?></th>
            <th class="text_align_center"><?php _trans('lable1127'); ?></th>
            <th style="float: right; text-align: right;"><?php _trans('lable994'); ?></th>
            <th style="float: right; text-align: right;"><?php _trans('lable384'); ?></th>
            <th style="float: right; text-align: right;"><?php _trans('lable995'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($results) > 0){
                $overall_grand_total = 0;
                $overall_total_paid_amount = 0;
                $overall_total_due_amount = 0;
            foreach ($results as $result){ 
                $overall_grand_total += $result->grand_total;
                $overall_total_paid_amount += $result->total_paid_amount;
                $overall_total_due_amount += $result->total_due_amount;?>
                <?php 
                $today_dt = date_create(date('Y-m-d'));
                $invoice_dt = date_create($result->invoice_date);
                $due_days = date_diff($today_dt,$invoice_dt);
                ?>
                <tr>
                <td class="text_align_left"><?php echo $result->invoice_no; ?></td>
                <td class="text_align_left"><?php echo ($result->invoice_date?date_from_mysql($result->invoice_date):" "); ?></td>
                <td class="text_align_left"><?php echo ($result->invoice_date_due?date_from_mysql($result->invoice_date_due):" "); ?></td>
                <td class="text_align_center"><?php echo ($result->due_days?$result->due_days:0); ?></td>
                <td style="float: right; text-align: right;"><?php echo format_currency($result->total_paid_amount); ?></td>
                <td style="float: right; text-align: right;"><?php echo format_currency($result->grand_total); ?></td>
                <td style="float: right; text-align: right;"><?php echo format_currency($result->total_due_amount); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-center">
                    <span style="float: right; text-align: right;"><strong><?php _trans('lable1005'); ?> = </strong><strong><?php echo $overall_total_paid_amount; ?></strong></span>
                </td>
                <td class="text-right">
                    <span style="float: right; text-align: right;"><strong><?php _trans('lable1006'); ?> = </strong><strong><?php echo format_currency($overall_grand_total, 2); ?></strong></span>
                </td>
                <td class="text-right">
                    <span style="float: right; text-align: right;"><strong><?php _trans('lable1007'); ?> = </strong><strong><?php echo format_currency($overall_total_due_amount, 2); ?></strong></span>
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