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
        <div style="width:100%;float:left;padding:5px;text-align:center;">
            <h4 style="padding:0px; margin: 0;font-size:18px;"><?php echo $title; ?></h4>
        </div>
        <br>
        <div id="content" class="table-content">
            <?php $this->layout->load_view('layout/alerts'); ?>
            <section class="card">
            
    <?php $v = count($mech_invoices); foreach($mech_invoices as $key => $invoice_customer_lists){ ?> 
        <table  width="100%" class="item-tables">
            <tr style="background: #CBEAE3;">
                <th><h5 style="font-size:17px;"><?php _trans('lable709'); ?> : <?php echo $vehicle_no; ?></h5></th>
                <th></th>
                <th><h5 style="font-size:17px;"><?php _trans('lable1229'); ?> : <?php echo $v;$v--; ?></h5></th>
            </tr>
            <tr width="100%">
                <td width="45%" style="width:45%;float: left;">
                    <table width="100%" style="font-size:16px;">
                        <?php if($invoice_customer_lists->invoice_no){ ?>
                            <tr width="100%">
                                <td width="60%"><?php _trans('lable29');?> :</td>
                                <td width="60%"><?php echo $invoice_customer_lists->invoice_no; ?></td>
                            </tr>
                        <?php } if($invoice_customer_lists->invoice_date){ ?>                    
                            <tr width="100%">
                                <td width="60%"><?php _trans('lable368');?> :</td>
                                <td width="60%"><?php echo ($invoice_customer_lists->invoice_date?date_from_mysql($invoice_customer_lists->invoice_date):""); ?></td>
                            </tr>
                        <?php }if($invoice_customer_lists->jobsheet_no){ ?>    
                            <tr width="100%">
                                <td width="85%"><?php _trans('lable1052');?> :</td>
                                <td width="60%"><?php echo $invoice_customer_lists->jobsheet_no; ?></td>
                            </tr>
                        <?php }if($invoice_customer_lists->next_service_dt){ ?>    
                            <tr width="100%">
                                <td width="85%"><?php _trans('lable299');?> :</td>
                                <td width="60%"><?php echo ($invoice_customer_lists->next_service_dt?date_from_mysql($invoice_customer_lists->next_service_dt):""); ?></td>
                            </tr>
                        <?php } ?>	          
                    </table>
                </td>
                <td width="45%" style="width:45%;">
                    <table width="100%" style="font-size:16px;">
                        <?php if($invoice_customer_lists->customer_details->client_name){ ?>    
                            <tr width="100%">
                                <td width="100%"><?php _trans('lable36');?> :</td>
                                <td width="100%"><?php echo $invoice_customer_lists->customer_details->client_name; ?></td>
                            </tr>
                        <?php } if($invoice_customer_lists->customer_details->client_contact_no != ""){?>                    
                            <tr width="100%">
                                <td width="100%"><?php _trans('lable1051');?> :</td>
                                <td width="50%"><?php echo $invoice_customer_lists->customer_details->client_contact_no;?></td>
                            </tr>
                        <?php } if($invoice_customer_lists->customer_details->client_email_id != ""){ ?>    
                            <tr width="100%">
                                <td colspan="2" width="100%"><?php echo $invoice_customer_lists->customer_details->client_email_id; ?></td>
                            </tr>
                        <?php }if($invoice_customer_lists->next_service_dt){ ?>    
                            <tr width="100%">
                                <td colspan="2" width="100%"><?php echo $this->mdl_user_address->get_user_complete_address($invoice_customer_lists->user_address_id); ?></td>
                            </tr>
                        <?php } if($invoice_customer_lists->customer_details->client_gstin){ ?>    
                            <tr width="100%">
                                <td colspan="2"><?php echo $invoice_customer_lists->customer_details->client_gstin; ?></td>
                            </tr>    
                        <?php } ?>	          
                    </table>
                </td>
                <td width="45%" style="width:45%;float:right;">
                    <table width="100%" style="font-size:16px;">
                        <?php if($invoice_detail->car_reg_no){ ?>    
                            <tr width="100%">
                                <td width="100%"><?php _trans('lable72');?> :</td>
                                <td width="100%"><?php echo $invoice_detail->car_reg_no; ?></td>
                            </tr>
                        <?php } if($invoice_customer_lists->brand_name){ ?>                    
                            <tr width="100%">
                                <td width="100%"><?php _trans('lable1049');?> :</td>
                                <td width="100%"><?php echo $invoice_customer_lists->brand_name; ?> <?php echo ($invoice_customer_lists->car_model_year?$invoice_customer_lists->car_model_year."-":" ")."".($invoice_customer_lists->model_name?$invoice_customer_lists->model_name:"")."".($invoice_customer_lists->variant_name?"-".$invoice_customer_lists->variant_name:" "); ?></td>
                            </tr>
                        <?php } if($invoice_customer_lists->current_odometer_reading){ ?>    
                            <tr width="100%">
                                <td width="100%"><?php _trans('lable1113');?> :</td>
                                <td width="100%"><?php echo $invoice_customer_lists->current_odometer_reading; ?></td>
                            </tr>
                            <?php } if($invoice_customer_lists->next_service_km){ ?>    
                            <tr width="100%">
                                <td width="100%"><?php _trans('lable298');?> :</td>
                                <td width="100%"><?php echo $invoice_customer_lists->next_service_km; ?></td>
                            </tr>    
                        <?php } ?>	          
                    </table>
                </td>
            </tr>
        </table>

        <!-- //Part_list// -->
        <?php if(count($invoice_customer_lists->product_list) > 0){ ?>
        <table  width="100%" class="item-tables">
            <tr width="100%" style="float:left;background: #CBEAE3;">
                <th style="text-align:left"><h5 style="font-size:13px;"><?php _trans('lable125'); ?></h5></th>
                <th style="text-align:left;padding:0% 2.5%;"><h5 style="font-size:13px;"><?php _trans('lable1234'); ?></h5></th>
                <th style="text-align:left"><h5 style="font-size:13px;"><?php _trans('lable1235'); ?></h5></th>
                <th style="text-align:left"><h5 style="font-size:13px;"><?php _trans('lable348'); ?></h5></th>
            </tr>
            <?php $i = 1; foreach(json_decode($invoice_customer_lists->product_list) as $key => $product_lists){ ?>
            <tr width="100%" style="margin-right:3px;">
                <td style="text-align:left;padding:0% 2%;"><?php echo $i;$i++; ?></td>
                <td style="text-align:left;padding:0% 2.5%;"><?php echo $product_lists->product_id; ?></td>
                <td><?php echo $product_lists->item_product_name; ?></td>
                <td style="text-align:left;padding:0% 2%;"><?php echo $product_lists->item_qty; ?></td>
            </tr>
            <?php } ?>
        </table>
         <?php } ?>

        <!-- //Labour_list// -->
        <?php if(count($invoice_customer_lists->service_list) > 0){ ?>
        <table  width="100%" class="item-tables">
            <tr width="100%" style="background: #CBEAE3;">
                <th style="text-align:left"><h5 style="font-size:13px;"><?php _trans('lable125'); ?></h5></th>
                <th style="text-align:left:padding:0% 0%;"><h5 style="font-size:13px;"><?php _trans('lable1232'); ?></h5></th>
                <th style="text-align:left"><h5 style="font-size:13px;"><?php _trans('lable1233'); ?></h5></th>
            </tr>
            <?php $j = 1; foreach(json_decode($invoice_customer_lists->service_list) as $key => $service_lists){ ?>        
            <tr width="100%" >
                <td style="text-align:left;padding:0% 2%;"><?php echo $j;$j++; ?></td>
                <td style="text-align:left;padding:0% 0%;"><?php echo $service_lists->msim_id; ?></td>
                <td><?php echo $service_lists->service_item_name; ?></td>
            </tr>
            <?php } ?>
        </table>
         <?php } ?>

         <!-- //service_package_list// -->
         <?php if(count($invoice_customer_lists->service_package_list) > 0){ ?>
        <table  width="100%" class="item-tables">
            <tr width="100%" style="background: #CBEAE3;">
                <th style="text-align:left"><h5 style="font-size:13px;"><?php _trans('lable125'); ?></h5></th>
                <th style="text-align:left;margin-right:50%;"><h5 style="font-size:13px;"><?php _trans('lable1231'); ?></h5></th>
                <th style="text-align:left;"><h5 style="font-size:13px;"><?php _trans('lable1230'); ?></h5></th>
            </tr>
            <?php $k = 1; foreach(json_decode($invoice_customer_lists->service_package_list) as $key => $service_package_lists){ ?>
            <tr width="100%" >
                <td style="text-align:left;padding:0% 2%;"><?php echo $k;$k++; ?></td>
                <td><?php echo $service_package_lists->s_pack_id; ?></td>
                <td style="padding:0% 0%;"><?php echo $service_package_lists->service_item_name; ?></td>
            </tr>
            <?php } ?>
        </table>
         <?php } ?>
<hr>
<?php } ?>
            </section>
        </div>
    </main>
	<?php //exit(); ?>
</body>
</html> 