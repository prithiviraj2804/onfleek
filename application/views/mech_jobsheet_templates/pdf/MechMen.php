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
                        <?php $company_details = $this->mdl_workshop_branch->get_company_branch_details($work_order_detail->branch_id);
						if ($company_details->workshop_logo) { ?>
                        <img class="hidden-md-down" src="<?php echo base_url(); ?>uploads/workshop_logo/<?php echo $company_details->workshop_logo; ?>" width="150" height="150" alt="<?php echo $company_details->workshop_name; ?>">
                        <?php } ?>
                    </div>
                </td>
                <td style="width:50%;text-align: right; padding: 10px 10px;">
                    <div>
                        <?php echo '<span style="font-weight: bold; font-size: 13px;">'.$company_details->display_board_name.'</span><br>'; ?>
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
                        }
                        ?>
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
            <tr>
                <td colspan="2">
                    <hr>
                </td>
            </tr>
        </table>
    </htmlpageheader>
    <main style="padding:0px 20px 20px 20px;">
        <table width="100%" class="customer-details">
            <thead>
                <tr>
                    <td width="33%" style="width:33%;float: left;">
                        <?php if ($work_order_detail->jobsheet_no) { ?><strong><?php _trans('lable1052'); ?> : <?php echo $work_order_detail->jobsheet_no; ?></strong><br><?php } ?>
                        <?php if ($work_order_detail->status_name) { ?><strong><?php echo('Job Card Status'); ?> : <?php echo $work_order_detail->status_name; ?></strong><br><?php } ?>
                        <?php if ($work_order_detail->next_service_dt) { ?><strong><?php _trans('lable299'); ?> : <?php echo ($work_order_detail->next_service_dt?date_from_mysql($work_order_detail->next_service_dt):""); ?></strong><br><?php } ?>
                    </td>
                    <td width="33%" style="width:33%;float: left;">
                    <strong><?php _trans('lable1075'); ?>:</strong><br>
                        <?php if ($customer_details->client_name) { echo '<span>' . $customer_details->client_name . '</span>'; } ?>
                        <?php if ($customer_details->client_contact_no) { echo '<br><span>' . $customer_details->client_contact_no . '</span>'; } ?>
                        <?php if ($customer_details->client_email_id) { echo '<br><span>' . $customer_details->client_email_id . '</span>'; } ?>
                        <?php if($work_order_detail->user_address_id){ ?>
                             <strong><?php _trans('lable61'); ?>:</strong><br>
                             <?php echo $this->mdl_user_address->get_user_complete_address($work_order_detail->user_address_id); ?>
                        <?php } ?>
                    </td>
                    <td width="33%" style="float: right; text-align: right;">
                        <strong><?php _trans('lable280'); ?>:</strong><br>
                        <?php if ($work_order_detail->car_reg_no) { echo '<span>' . $work_order_detail->car_reg_no . '</span><br>'; } ?>
                        <span><?php if ($work_order_detail->car_model_year) {
                            echo $work_order_detail->car_model_year;
                        }
                        if ($work_order_detail->brand_name) {
                            echo " " . $work_order_detail->brand_name;
                        }
                        if ($work_order_detail->model_name) {
                            echo " " . $work_order_detail->model_name;
                        }
                        if ($work_order_detail->variant_name) {
                            echo " " . $work_order_detail->variant_name;
                        }
                        ?>
                        </span><br>
                        <?php if ($work_order_detail->fuel_type) { if($work_order_detail->fuel_type == 'P'){ echo "<span>Petrol</span>"; } else if($work_order_detail->fuel_type == 'D'){ echo "<span>Diesel</span>"; } } ?>
                        <?php if ($work_order_detail->current_odometer_reading) { echo '<br><span>Odometer Reading : ' . $work_order_detail->current_odometer_reading . '</span>'; } ?>
                        <?php if ($work_order_detail->fuel_level) { echo '<br><span>Fuel Level : ' . $work_order_detail->fuel_level . '</span>'; } ?>
                    </td>
                </tr>
            </thead>
        </table>
        <?php if(count(json_decode($product_list)) > 0){ ?>
        <div style="padding:5px; background: #F5F5F5;">
            <h4 style="padding:0px; margin: 0;"><?php _trans('lable344'); ?></h4>
        </div>
        <table class="item-table">
        <thead>
                <tr>
                    <th width="5%" style="width:5%;" class="item-desc text-center"><?php _trans('lable346'); ?></th>
                    <th width="15%" style="width:15%;" class="item-desc"><?php _trans('lable177'); ?></th>
                    <th width="10%" style="width:10%;text-align: center" class="item-desc"><?php _trans('lable396'); ?></th>
                    <th width="5%" style="width:5%;text-align: center" class="item-desc text-center"><?php _trans('lable348'); ?></th>
                    <th width="15%" style="width:15%;" class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;Price (Per Qty)</th>
                    <th width="15%" style="width:15%;" class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;Item Discount<br>(Per Qty)</th>
                    <th width="15%" style="width:15%;" class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php _trans('lable339'); ?></th>
                    <th width="15%" style="width:15%;" class="item-desc text-right"><?php _trans('lable331'); ?>(%)</th>
                    <th width="15%" style="width:15%;" class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php _trans('lable332'); ?></th>
                </tr>
                <?php if ($product_list) {
				$i = 1;
                $total_item_qty = 0;
                $total_user_item_price = 0;
                $total_item_discount_price = 0;
                $total_item_amount = 0;
                $total_user_item_price = 0;
                $total_igst_amount = 0;
                $total_item_total_amount = 0;
                foreach (json_decode($product_list) as $product) {  
                    $total_item_qty += $product->item_qty;
                    $total_user_item_price += $product->user_item_price;
                    $total_item_discount_price += $product->item_discount_price;
                    $total_item_amount += $product->item_amount;
                    $total_igst_amount += $product->igst_amount;
                    $total_item_total_amount += $product->item_total_amount;
                    ?>
                <tr>
                    <td width="5%" style="width:5%;text-align: center" class="item-desc"><?php echo $i;$i++; ?></td>
                    <td width="15%" style="width:15%;text-align: left" class="item-desc"><?php echo $product->item_product_name; ?></td>
                    <td width="10%" style="width:10%;text-align: center" class="item-desc"><?php echo $product->item_hsn; ?></td>
                    <td width="5%" style="width:5%;text-align:center;" class="item-desc text-right"><?php echo $product->item_qty ? $product->item_qty : '1'; ?></td>
                    <td width="15%" style="width:15%;text-align: right" class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($product->user_item_price,$this->session->userdata('default_currency_digit')); ?></td>
                    <td width="15%" style="width:15%;text-align:right;" class="item-desc"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($product->item_discount_price,$this->session->userdata('default_currency_digit')); ?></td>
                    <td width="15%" style="width:15%;" class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($product->item_amount,$this->session->userdata('default_currency_digit')); ?></td>
                    <td width="15%" style="width:15%;" class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($product->igst_amount,$this->session->userdata('default_currency_digit')). ' ('.$product->igst_pct.'%)'; ?></td>
                    <td width="15%" style="width:15%;" class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($product->item_total_amount,$this->session->userdata('default_currency_digit')); ?></td>
                </tr>
                <?php } } ?>
                </thead>
            <tfoot>
                <tr>
                    <td colspan="3" class="item-desc text-right"><b><?php echo "Total";?></b></td>
                    <td class="item-desc text-center"><?php echo $total_item_qty; ?></td>
                    <td class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($total_user_item_price,$this->session->userdata('default_currency_digit')); ?></td>
                    <td class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($total_item_discount_price,$this->session->userdata('default_currency_digit')); ?></td>
                    <td class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($total_item_amount,$this->session->userdata('default_currency_digit')); ?></td>
                    <td class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($total_igst_amount,$this->session->userdata('default_currency_digit')); ?></td>
					<td class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money(($work_order_detail->product_grand_total?$work_order_detail->product_grand_total:o),$this->session->userdata('default_currency_digit')); ?></td>
                </tr>
            </tfoot>
        </table>
        <?php } ?>
        <?php if(count(json_decode($service_list)) > 0){ ?>
        <div style="padding:5px; background: #F5F5F5;">
            <h4 style="padding:0px; margin: 0;"><?php _trans('lable1022'); ?></h4>
        </div>
        <table class="item-table">
        <thead>
                <tr>
                    <th width="5%;" style="width:5%;max-width:5%;" class="text-center"><?php _trans('lable346'); ?></th>
                    <th width="25%;" style="width:20%;max-width:20%;"><?php _trans('lable177'); ?></th>
                    <th width="15%;" style="width:15%;max-width:15%;"><?php _trans('lable396'); ?></th>
                    <th width="15%;" style="width:15%;max-width:15%;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php _trans('lable399'); ?></th>
                    <th width="10%;" style="width:10%;max-width:10%;" class="text-right"><?php _trans('lable1207'); ?></th>
                    <th width="11%;" style="width:11%;max-width:11%;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php _trans('lable339'); ?></th>
                    <th width="15%;" style="width:15%;max-width:15%;" class="text-right"><?php _trans('lable331'); ?>(%)</th>
                    <th width="15%;" style="width:15%;max-width:15%;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php _trans('lable332'); ?></th>
                </tr>
                <?php if($service_list){
				$i = 1;
                $total_user_item_price_service = 0;
                $total_item_discount_price_service = 0;
                $total_item_amount_service = 0;
                $total_igst_amount_service = 0;
				foreach (json_decode($service_list) as $service){ 
                    $total_user_item_price_service += $service->user_item_price; 
                    $total_item_discount_price_service += $service->item_discount_price;
                    $total_item_amount_service += $service->item_amount;
                    $total_igst_amount_service += $service->igst_amount;
                    ?>
                <tr>
                    <td width="5%" style="width:5%;" class="item-desc text-center"><?php echo $i;$i++; ?></td>
                    <td width="25%" style="width:25%;" class="item-name"><?php echo $service->service_item_name; ?></td>
                    <td width="15%" style="width:15%;" class="item-desc"><?php echo $service->item_hsn; ?></td>
                    <td width="15%" style="width:15%;" class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($service->user_item_price,$this->session->userdata('default_currency_digit')); ?></td>
                    <td width="10%" style="width:10%;" class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($service->item_discount_price,$this->session->userdata('default_currency_digit')); ?></td>
                    <td width="11%" style="width:11%;" class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($service->item_amount,$this->session->userdata('default_currency_digit')); ?></td>
                    <td width="15%" style="width:15%;" class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($service->igst_amount,$this->session->userdata('default_currency_digit')).' ('.$service->igst_pct.'%)'; ?></td>
                    <td width="15%" style="width:15%;" class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($service->item_total_amount,$this->session->userdata('default_currency_digit')); ?></td>
                </tr>
                <?php } } ?>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="3" class="item-desc text-right"><b><?php echo "Total"; ?></b></td>
                    <td class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money(($total_user_item_price_service?$total_user_item_price_service:0),$this->session->userdata('default_currency_digit')); ?></td>
                    <td class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money(($total_item_discount_price_service?$total_item_discount_price_service:0),$this->session->userdata('default_currency_digit')); ?></td>
                    <td class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money(($total_item_amount_service?$total_item_amount_service:0),$this->session->userdata('default_currency_digit')); ?></td>
                    <td class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money(($total_igst_amount_service?$total_igst_amount_service:0),$this->session->userdata('default_currency_digit')); ?></td>
                    <td class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money(($work_order_detail->service_grand_total?$work_order_detail->service_grand_total:0),$this->session->userdata('default_currency_digit')); ?></td>
                </tr>
            </tfoot>
        </table>
        <?php } ?>

        <table><tr><td height="10"></td></tr></table>
        <?php if(count(json_decode($service_package_list)) > 0){ ?>
        <div style="padding:5px; background: #F5F5F5;">
            <h4 style="padding:0px; margin: 0;"><?php _trans('lable546'); ?></h4>
        </div>
        <table class="item-table">
            <thead>
                <tr>
                    <th width="7%" style="width:7%;text-align: center" class="item-desc"><?php _trans('lable125'); ?></th>
                    <th width="25%" style="width:25%;text-align: left" class="item-name"><?php _trans('lable177'); ?></th>
                    <th class="item-name text-left"><?php _trans('lable456'); ?></th>
                    <th width="10%" style="width:10%;text-align: left" class="item-desc"><?php _trans('lable396'); ?></th>
                    <th width="20%" style="width:20%;text-align: right" class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php _trans('label945'); ?></th>
                    <th width="20%" style="width:20%;text-align: right" class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php _trans('lable338'); ?></th>
                </tr>
                <?php 
				if($service_package_list){
				$i = 1;
				foreach (json_decode($service_package_list) as $service){ ?>
                <tr>
                    <td width="7%" style="width:7%;text-align: center;" class="item-desc"><?php echo $i;$i++; ?></td>
                    <td width="25%" style="width:25%;text-align: left" class="item-name"><?php echo $service->service_item_name; ?></td>
                    <td class="item-name text-left"><?php echo $service->employee_name; ?></td>
                    <td width="10%" style="width:10%;text-align: left" class="item-desc"><?php echo $service->item_hsn; ?></td>
                    <td width="20%" style="width:20%;text-align: right" class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($service->user_item_price,$this->session->userdata('default_currency_digit')); ?></td>
                    <td width="20%" style="width:20%;text-align: right" class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($service->item_total_amount,$this->session->userdata('default_currency_digit')); ?></td>
                </tr>
                <?php } } ?>
            </thead>
        </table>
        <?php } ?>
        <table><tr><td height="10"></td></tr></table>
        <div style="width:100%;float:left;">
            <div style="width:25%;float: left;">
                <?php if($bank_dtls->account_number){ ?>
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
                <br>
                <?php } if($work_order_detail->job_terms_condition){?>
                <div style="width: 100%; float: left;">
                    <h6 style="width: 100%; float: left;text-align: left"><?php _trans('lable388');?></h6>
                    <div style="width: 100%; float: left;text-align: left;text-align:justify;"><?php echo $work_order_detail->job_terms_condition; ?></div>
                </div> 
                <?php } if($work_order_detail->description){?>
					<div style="width: 100%; float: left;">
						<h6 style="width: 100%; float: left;text-align: left"><?php _trans('lable1208');?></h6>
						<div style="width: 100%; float: left;text-align: left"><?php echo $work_order_detail->description; ?></div>
					</div>
				<?php }  ?>
            </div>
            <div style="padding-left:10px;width:65%;float:right;font-size:14px;">
                <table class="item-table">
                    <?php if (count(json_decode($product_list)) > 0) { ?>
                    <tr>
                        <td class="item-amount text-right" style="border:none;"><?php _trans('lable356'); ?> : </td>
                        <td class="item-amount text-left" style="border:none;"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($work_order_detail->product_grand_total,$this->session->userdata('default_currency_digit')); ?></td>
                    </tr>
                    <?php } ?>
                    <?php  if(count(json_decode($service_list)) > 0) { ?>
                    <tr>
                        <td class="item-amount text-right" style="border:none;"><?php _trans('lable342'); ?> : </td>
                        <td class="item-amount text-left" style="border:none;"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($work_order_detail->service_grand_total,$this->session->userdata('default_currency_digit')); ?></td>
                    </tr>
                    <?php } ?>

                    <?php if(count(json_decode($service_package_list)) > 0) { ?>
                    <tr>
                        <td class="item-amount text-right" style="border:none;"><?php _trans('label960'); ?> : </td>
                        <td class="item-amount text-left" style="border:none;"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($work_order_detail->service_package_grand_total,$this->session->userdata('default_currency_digit')); ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td class="item-amount text-right" style="border:none;"><?php _trans('lable332'); ?> : </td>
                        <td class="item-amount text-left" style="border:none;"><b><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($work_order_detail->grand_total,$this->session->userdata('default_currency_digit')); ?></b></td>
                    </tr>
                    <tr>
                        <td class="item-amount text-right" style="border:none;"><?php _trans('lable8'); ?> : </td>
                        <td class="item-amount text-left" style="border:none;"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($work_order_detail->total_paid_amount,$this->session->userdata('default_currency_digit')); ?></td>
                    </tr>
                    <tr>
                        <td class="item-amount text-right" style="border:none;"><?php _trans('lable627'); ?> : </td>
                        <td class="item-amount text-left" style="border:none;"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($work_order_detail->total_due_amount,$this->session->userdata('default_currency_digit')); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </main>
    <htmlpagefooter name="myHTMLFooter">
        <div class="footer_bg"><?php _trans('lable1045'); ?></div>
    </htmlpagefooter>
	<?php // exit(); ?>
</body>
</html> 