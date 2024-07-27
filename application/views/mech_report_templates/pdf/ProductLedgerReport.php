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
            <h5 style="padding:0px; margin: 0;font-size:14px;"><?php _trans('lable1009'); ?></h5>
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
                                <td width="10%" style="font-size:15px;"><?php _trans('lable25');?> :</td>
                                <?php foreach ($product_info as $product_in){  ?>
                                    <td width="65%" style="font-size:15px;"><?php echo $product_in->product_name; ?></td>
                                <?php } ?>
                            </tr>

                            <tr width="100%">
                                <td width="10%"><?php _trans('lable231');?> :</td>
                                <?php foreach ($product_info as $product_in){  ?>
                                <td width="65%"><?php echo $product_in->family_name; ?></td>
                                <?php } ?>
                            </tr>
                            
                            <tr width="100%">
                                <td width="10%"><?php _trans('lable224');?> :</td>
                                <?php foreach ($product_info as $product_in){  ?>
                                <td width="65%"><?php echo $product_in->cost_price; ?></td>
                                <?php } ?>
                            </tr>

                            <tr width="100%">
                                <td width="10%"><?php _trans('lable225');?> :</td>
                                <?php foreach ($product_info as $product_in){  ?>
                                <td width="65%"><?php echo $product_in->sale_price; ?></td>
                                <?php } ?>
                            </tr>
                    </table>
                </td>
            </tr>
        </table>
            </section>
        </div>

        <div class="row">
            <hr style="border-top-color: #c5d6de;margin: 5px;width:100%">
        </div>
        <table width="100%" class="item-tables">
            <tr width="100%">
                <td width="30%" style="width:45%;float: left;">
                    <table width="100%" style="width:100%;float: right">
                    <tr width="100%">
                        <td width="66%" style="font-size:20px;"><?php _trans('lable1010');?> =</td>
                        <?php if(count($results) > 0){
                            $overall_pur_total = 0;
                            foreach ($results as $result){ 
                                $overall_pur_total += $result->item_qty;?>
                            <?php } ?>
                        <td width="50%" style="font-size:20px;color:red;"><?php echo $overall_pur_total?$overall_pur_total:"0"; ?></td>
                            <?php }else{ ?>
                            <td width="50%" style="font-size:20px;color:red;"><?php echo 0; ?></td>
                        <?php } ?>
                    </tr>
                    </table>
                </td>
                <td width="30%" style="float: left; text-align: left;">
                    <table width="100%" style="width:100%;float: left" class="item-tables">
                    <tr width="100%">
                        <td width="59%" style="font-size:20px;"><?php _trans('lable637');?> =</td>
                        <?php if(count($results_sales) > 0){
                            $overall_sal_total = 0;
                        foreach ($results_sales as $result){ 
                            $overall_sal_total += $result->item_qty;?>
                        <?php } ?>
                        <td width="30%" style="font-size:20px;color:red;"><?php echo $overall_sal_total?$overall_sal_total:"0"; ?></td>
                            <?php }else{ ?>
                            <td width="30%" style="font-size:20px;color:red;"><?php echo 0; ?></td>
                        <?php } ?>
                    </tr>
                    </table>
                </td>
                <td width="30%" style="float: left; text-align: right;">
                    <table width="100%" style="width:100%;float: right" class="item-tables">
                    <tr width="100%">
                        <td width="90%" style="font-size:20px;"><?php _trans('lable1011');?> =</td>
                        <?php $total = ($overall_pur_total - $overall_sal_total); ?>
                        <td width="8%" style="font-size:20px;color:red;"><?php echo $total?$total:"0"; ?></td>
                    </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div class="row">
            <hr style="border-top-color: #c5d6de;margin: 5px;width:100%">
        </div>
        <br>
        <h5 style="font-size:15px;"><?php _trans('lable1012'); ?></h5>
        <table class="customer-details" style="font-size:.9375rem;margin-bottom: 0;background: #fff;table-layout:fixed;border: 1px solid #eceeef;width: 100%;max-width: 100%;border-collapse: collapse;border-spacing: 0;" cellspacing="0" width="100%">
        <thead>
            <tr>
            <th style="float: left; text-align: left;"><?php _trans('lable31'); ?></th>
            <th style="float: left; text-align: left;"><?php _trans('lable29'); ?></th>
            <th style="float: left; text-align: left;"><?php _trans('lable80'); ?></th>
            <th style="float: center; text-align: center;"><?php _trans('lable997'); ?></th>
            <th style="float: right; text-align: right;"><?php _trans('lable337'); ?></th>
            <th style="float: right; text-align: right;"><?php _trans('lable114'); ?></th>
            </tr>
        </thead>
        <tbody>
                <?php if(count($results) > 0){
                $overall_grand_total = 0;
                $overall_total_paid_amount = 0;
                $overall_total_due_amount = 0;
                foreach ($results as $result){ 
                $overall_grand_total += $result->item_qty;
                $overall_total_paid_amount += $result->item_price;
                $overall_total_due_amount += $result->item_amount;?>
                <tr>
                <td class="text_align_left"><?php echo ($result->purchase_date_created?date_from_mysql($result->purchase_date_created):" "); ?></td>
                <td class="text_align_left"><?php echo $result->purchase_no; ?></td>
                <td class="text_align_left"><?php echo $result->supplier_name; ?></td>
                <td style="float: center; text-align: center;"><?php echo $result->item_qty; ?></td>
                <td style="float: right; text-align: right;"><?php echo format_currency($result->item_price); ?></td>
                <td style="float: right; text-align: right;"><?php echo format_currency($result->item_amount); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-center">
                    <span style="float: center; text-align: center;"><strong><?php _trans('lable1014'); ?> = </strong><strong><?php echo $overall_grand_total; ?></strong></span>
                </td>
                <td class="text-right">
                    <span style="float: right; text-align: right;"><strong><?php _trans('lable1015'); ?> = </strong><strong><?php echo format_currency($overall_total_paid_amount, 2); ?></strong></span>
                </td>
                <td class="text-right">
                    <span style="float: right; text-align: right;"><strong><?php _trans('lable1016'); ?> = </strong><strong><?php echo format_currency($overall_total_due_amount, 2); ?></strong></span>
                </td>
            <tr>
            <?php }else{ ?>
            <tr>
                <td colspan="3" align="center"><?php _trans('lable343'); ?></td>
            </tr>
            <?php } ?>
        </tbody>
        </table>
        <!-- sales report -->
        <br>
        <h5 style="font-size:15px;"><?php _trans('lable1013'); ?></h5>
        <table class="customer-details" style="font-size:.9375rem;margin-bottom: 0;background: #fff;table-layout:fixed;border: 1px solid #eceeef;width: 100%;max-width: 100%;border-collapse: collapse;border-spacing: 0;" cellspacing="0" width="100%">
        <thead>
            <tr>
            <th style="float: left; text-align: left;"><?php _trans('lable31'); ?></th>
            <th style="float: left; text-align: left;"><?php _trans('lable29'); ?></th>
            <th style="float: left; text-align: left;"><?php _trans('lable36'); ?></th>
            <th style="float: center; text-align: center;"><?php _trans('lable997'); ?></th>
            <th style="float: right; text-align: right;"><?php _trans('lable337'); ?></th>
            <th style="float: right; text-align: right;"><?php _trans('lable114'); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php if(count($results_sales) > 0){
                $overall_grand_total = 0;
                $overall_total_paid_amount = 0;
                $overall_total_due_amount = 0;
            foreach ($results_sales as $result){ 
                $overall_grand_total += $result->item_qty;
                $overall_total_paid_amount += $result->user_item_price;
                $overall_total_due_amount += $result->item_amount;?>
                <tr>
                <td class="text_align_left"><?php echo ($result->invoice_date?date_from_mysql($result->invoice_date):" "); ?></td>
                <td class="text_align_left"><?php echo $result->invoice_no; ?></td>
                <td class="text_align_left"><?php echo $result->client_name; ?></td>
                <td style="float: center; text-align: center;"><?php echo $result->item_qty; ?></td>
                <td style="float: right; text-align: right;"><?php echo format_currency($result->user_item_price); ?></td>
                <td style="float: right; text-align: right;"><?php echo format_currency($result->item_amount); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-center">
                    <span style="float: center; text-align: center;"><strong><?php _trans('lable1014'); ?> = </strong><strong><?php echo $overall_grand_total; ?></strong></span>
                </td>
                <td class="text-right">
                    <span style="float: right; text-align: right;"><strong><?php _trans('lable1015'); ?> = </strong><strong><?php echo format_currency($overall_total_paid_amount, 2); ?></strong></span>
                </td>
                <td class="text-right">
                    <span style="float: right; text-align: right;"><strong><?php _trans('lable1016'); ?> = </strong><strong><?php echo format_currency($overall_total_due_amount, 2); ?></strong></span>
                </td>
            <tr>
            <?php }else{ ?>
            <tr>
                <td colspan="3" align="center"><?php _trans('lable343'); ?></td>
            </tr>
            <?php } ?>
        </tbody>
        </table>
        <!-- end -->
    </main>
	<?php //exit(); ?>
</body>
</html> 