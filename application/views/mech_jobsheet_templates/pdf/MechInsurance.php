<!DOCTYPE html>
<html lang="<?php _trans('cldr'); ?>">
<head>
    <meta charset="utf-8">
    <title><?php _trans('lable1043'); ?></title>
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
            width: 33.3px;
            vertical-align: -webkit-baseline-middle;
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
                        <?php } ?>
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
                        if ($company_details->branch_country) {
                            echo $company_details->name;
                        } ?>
                        <?php if ($company_details->branch_contact_no) {
                            echo '<br><span>' . $company_details->branch_contact_no . '</span>';
                        } ?>
                        <?php if ($company_details->branch_email_id) {
                            echo '<br><span>' . $company_details->branch_email_id . '</span>';
                        } ?>
                        <?php if ($company_details->branch_gstin) {
                            echo '<br><span>' . $company_details->branch_gstin . '</span>';
                        } ?>
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
        <div style="padding:5px; background: #F5F5F5;">
            <h4 style="padding:0px; margin: 0;"><?php _trans('lable562'); ?></h4>
        </div>
        <table width="100%" class="">
            <thead width="100%">
                <tr>
                    <td rowspan="4" class="item-desc text-left">
                        <p>
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
                        if ($company_details->branch_country) {
                            echo $company_details->name;
                        } ?>
                        <?php if ($company_details->branch_contact_no) {
                            echo '<br><span>' . $company_details->branch_contact_no . '</span>';
                        } ?>
                        <?php if ($company_details->branch_email_id) {
                            echo '<br><span>' . $company_details->branch_email_id . '</span>';
                        } ?>
                        <?php if ($company_details->branch_gstin) {
                            echo '<br><span>' . $company_details->branch_gstin . '</span>';
                        } ?>
                    </p>
                    </td>
                    <td class="text-left">
                    <?php _trans('lable1052'); ?>: <?php echo $work_order_detail->jobsheet_no; ?>
                    <td>
                    <td class="text-left">
                    <?php _trans('lable31'); ?>: <?php echo $work_order_detail->ins_start_date; ?>
                    <td>
                </tr>
                <tr>
                    <td class="text-left">
                    <?php _trans('lable1086'); ?>: <?php echo $work_order_detail->jobsheet_no; ?>
                    <td>
                    <td class="text-left">
                    <?php _trans('lable1087'); ?>: <?php echo $work_order_detail->car_reg_no; ?>
                    <td>
                </tr>
                <tr>
                    <td class="text-left">
                    <?php _trans('lable1088'); ?>: <?php echo $work_order_detail->vin; ?>
                    <td>
                    <td class="text-left">
                    <?php _trans('lable1089'); ?>: <?php echo $work_order_detail->engine_number; ?>
                    <td>
                </tr>
                <tr>
                    <td class="text-left">
                    <?php _trans('lable1091'); ?>
                    <td>
                    <td>
                    <?php _trans('lable1090'); ?>: <?php echo $work_order_detail->policy_no;?>
                    </td>
                </tr>
                <tr>
                    <td rowspan="2" class="text-left">
                        <p>
                        <?php _trans('lable174'); ?> : <?php echo $work_order_detail->ins_pro_name; ?> <br> 
                        <?php _trans('lable61'); ?>: <?php echo $work_order_detail->contact_street; ?> <br> 
                        <?php _trans('lable88'); ?>: <?php echo $work_order_detail->cityname; ?> <br> 
                        <?php _trans('lable87'); ?>: <?php echo $work_order_detail->statename; ?> <br> 
                        <?php _trans('lable695'); ?>: <?php echo $work_order_detail->countryName; ?> <br> 
                        <?php _trans('lable698'); ?>: <?php echo $work_order_detail->contact_pincode; ?> <br> 
                            
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="text-left">
                        <p>
                        <?php _trans('lable565'); ?> :  <?php echo $work_order_detail->client_name; ?> <br> 
                        <?php _trans('lable273'); ?> : <?php echo $work_order_detail->brand_name; echo $work_order_detail->model_name; echo $work_order_detail->variant_name; ?><br>
                        <?php _trans('lable233'); ?> :<?php echo $work_order_detail->current_odometer_reading; ?><br>
                        <?php _trans('lable1085'); ?>: <?php echo $work_order_detail->client_email_id; ?><br>
                        <?php _trans('lable1084'); ?>:  <?php if($work_order_detail->fuel_type == "P"){ echo "PETROL";}else if($work_order_detail->fuel_type == "D"){ echo "DIESEL";} ?><br>
                        <?php _trans('lable1083'); ?>: <?php echo $work_order_detail->client_contact_no; ?> <br>
                        <?php _trans('lable38'); ?>: <?php echo $work_order_detail->client_email_id; ?>
                        </p>
                    </td>
                </tr>
            </thead>
        </table>
        <?php if ($product_list) { ?>
        <div style="padding:5px; background: #F5F5F5;">
            <h4 style="padding:0px; margin: 0;">Parts</h4>
        </div>
        <table class="item-table">
            <thead>
                <tr>
                    <th class="item-desc text-center"><?php _trans('lable402'); ?></th>
                    <th class="item-desc text-left"><?php _trans('lable177'); ?></th>
                    <th class="item-desc text-center"><?php _trans('lable348'); ?></th>
                    <th class="item-desc text-right"><?php _trans('lable399'); ?><br>(Per Qty)</th>
                    <th class="item-desc text-right"><?php _trans('lable349'); ?><br>(Per Qty)</th>
                    <th class="item-desc text-right"><?php _trans('lable331'); ?> (%)</th>
                    <th class="item-desc text-right"><?php _trans('lable339'); ?></th>
                </tr>
                <?php if ($product_list) {
					$i = 1;
					foreach (json_decode($product_list) as $product) { 		
					if($product->is_from == "work_order_product"){ ?>
                <tr>
                    <td class="item-desc text-center"><?php echo $i; $i++; ?></td>
                    <td class="item-desc text-left"><?php echo $product->item_product_name; ?></td>
                    <td class="item-desc text-center"><?php echo $product->item_qty ? $product->item_qty : '1'; ?></td>
                    <td class="item-desc text-right"><?php echo $product->user_item_price; ?>
                    </td>
                    <td class="item-desc text-right"><?php echo $product->item_discount; ?></td>
                    <td class="item-desc text-right"><?php echo $product->igst_pct. "%"; ?><br>
                        <label class="igst_amount_label"><?php echo $product->igst_amount; ?></label>
                    </td>
                    <td class="item-desc text-right">
                        <label class="item_total_amount_label"><?php echo $product->item_total_amount; ?></label>
                    </td>
                </tr>
                <?php } } } ?>
            </thead>
        </table>
        <?php } ?>

        <?php if($service_list){ ?>
        <div style="padding:5px; background: #F5F5F5;">
            <h4 style="padding:0px; margin: 0;"><?php _trans('lable1022'); ?></h4>
        </div>
        <table class="item-table">
            <thead>
                <tr>
                    <th class="item-desc text-center"><?php _trans('lable402'); ?></th>
                    <th class="item-name text-left"><?php _trans('lable177'); ?></th>
                    <th width="25%" style="width:25%;text-align: left" class="item-name"><?php _trans('lable456'); ?></th>
                    <th width="10%" style="width:10%;text-align: left" class="item-desc"><?php _trans('lable396'); ?></th>
                    <th class="item-amount text-right"><?php _trans('lable399'); ?> </th>
                    <th class="item-amount text-right"><?php _trans('lable338'); ?></th>
                </tr>
                <?php if ($service_list) {
                    $i = 1;
                    foreach (json_decode($service_list) as $service) { 
                    if($service->is_from == "work_order_service"){ ?>
                <tr>
                    <td class="item-desc text-center"><?php echo $i; $i++; ?></td>
                    <td class="item-name text-left"><?php echo $service->service_item_name; ?></td>
                    <td class="item-name text-left"><?php echo $service->employee_name; ?></td>
                    <td class="item-desc text-left"><?php echo $service->item_hsn; ?></td>
                    <td class="item-amount text-right"><?php echo $service->user_item_price; ?></td>
                    <td class="item-amount text-right"><?php echo $service->item_total_amount; ?></td>
                </tr>
                <?php } } } ?>
            </thead>
        </table>
        <?php } ?>
   
        <?php if($service_package_list){ ?>
        <div style="padding:5px; background: #F5F5F5;">
            <h4 style="padding:0px; margin: 0;"><?php _trans('lable539'); ?></h4>
        </div>
        <table class="item-table">
            <thead>
                <tr>
                    <th class="item-desc text-center"><?php _trans('lable402'); ?>.</th>
                    <th class="item-name text-left"><?php _trans('lable177'); ?></th>
                    <th width="25%" style="width:25%;text-align: left" class="item-name"><?php _trans('lable456'); ?></th>
                    <th width="10%" style="width:10%;text-align: left" class="item-desc"><?php _trans('lable396'); ?></th>
                    <th class="item-amount text-right"><?php _trans('lable399'); ?> </th>
                    <th class="item-amount text-right"><?php _trans('lable338'); ?></th>
                </tr>
                <?php if ($service_package_list) {
                    $i = 1;
                    foreach (json_decode($service_package_list) as $service) { ?>
                <tr>
                    <td class="item-desc text-center"><?php echo $i; $i++; ?></td>
                    <td class="item-name text-left"><?php echo $service->service_item_name; ?></td>
                    <td class="item-name text-left"><?php echo $service->employee_name; ?></td>
                    <td class="item-desc text-left"><?php echo $service->item_hsn; ?></td>
                    <td class="item-amount text-right"><?php echo $service->user_item_price; ?></td>
                    <td class="item-amount text-right"><?php echo $service->item_total_amount; ?></td>
                </tr>
                <?php } } ?>
            </thead>
        </table>
        <?php } ?>
        <div style="width: 100%;float : left;">
            <?php if($bank_dtls->account_number){ ?>
            <div style="width:40%;float: left;">
                <h4><?php _trans('lable1048'); ?></h4>
                <table>
                    <tr>
                        <td><?php _trans('lable401'); ?> :</td>
                        <td><?php echo $bank_dtls->account_holder_name; ?></td>
                    </tr>
                    <tr>
                        <td><?php _trans('lable98'); ?> :</td>
                        <td><?php echo $bank_dtls->account_number; ?></td>
                    </tr>
                    <tr>
                        <td><?php _trans('lable99'); ?> :</td>
                        <td><?php echo $bank_dtls->bank_name; ?></td>
                    </tr>
                    <tr>
                        <td><?php _trans('lable1047'); ?> :</td>
                        <td><?php echo $bank_dtls->bank_ifsc_Code; ?></td>
                    </tr>
                    <tr>
                        <td><?php _trans('lable95'); ?> :</td>
                        <td><?php echo $bank_dtls->bank_branch; ?></td>
                    </tr>
                </table>
            </div>
            <?php } ?>
            <div style="padding-left:30px;width:50%;float:right">
                <table class="item-table">
                    <tr height="30">
                    </tr>
                    <tr>
                        <td><b> <?php _trans('lable332'); ?> </b></td>
                        <td class="text-right"><b><?php echo format_money($work_order_detail->grand_total,$this->session->userdata('default_currency_digit')); ?></b></td>
                    </tr>
                    <tr>
                        <td><b> <?php _trans('lable1082'); ?> </b></td>
                        <td class="text-right"><b><?php echo format_money($work_order_detail->ins_approved_amount,$this->session->userdata('default_currency_digit')); ?></b></td>
                    </tr>
                    <tr>
                        <td><b> <?php _trans('lable1081'); ?></b></td>
                        <td class="text-right"><b><?php echo format_money($work_order_detail->grand_total - $work_order_detail->ins_approved_amount,$this->session->userdata('default_currency_digit')); ?></b></td>
                    </tr>
                </table>
            </div>
        </div>
        <div style="border-top: 1px solid #d3d3d3">
            <p style="font-size : 20px ! important;"><b><?php _trans('lable1080'); ?></b></p><br>
            <br>
            <br>
            <br>
            <p style="font-size : 20px ! important;"><?php _trans('lable1079'); ?>
            </p>
        </div>
        <br>
        <br>
        <br>
        <br>
        <table style="width:100%; table-layout: fixed;">
            <tr>
                <td>
                    <div>----------------------------</div>
                    <div><?php _trans('lable1078'); ?></div>
                </td>
                <td>
                    <div>----------------------------</div>
                    <div><?php _trans('lable1077'); ?></div>
                </td>
                <td>
                    <div>----------------------------</div>
                    <div><?php _trans('lable1076'); ?></div>
                </td>
            </tr>
        </table>
    </main>
	<?php // exit(); ?>
</body>
</html> 