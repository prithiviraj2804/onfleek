<!DOCTYPE html>
<html lang="<?php _trans('cldr'); ?>">
<head>
    <meta charset="utf-8">
    <title><?php _trans('lable120'); ?></title>
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
                        <?php $company_details = $this->mdl_workshop_branch->get_company_branch_details($purchase_detail->branch_id);
												if ($company_details->workshop_logo) { ?>
                        <img class="hidden-md-down" src="<?php echo base_url(); ?>uploads/workshop_logo/<?php echo $company_details->workshop_logo; ?>" width="150" height="150" alt="<?php echo $company_details->workshop_name; ?>">
                        <?php 
											} ?>
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
                                                    echo ' - '.$company_details->name;
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
        </table>
        <hr>
    </htmlpageheader>
    <htmlpagefooter name="myHTMLFooter">
        <div class="footer_bg"><?php _trans('lable1045'); ?></div>
    </htmlpagefooter>
    <main>
        <table width="100%" class="customer-details">
            <thead>
                <tr>
					<td>
						<?php if ($purchase_detail->purchase_no) { ?><br><strong><?php _trans('lable126'); ?> : <?php echo $purchase_detail->purchase_no; ?></strong><?php } ?>
						<?php if ($purchase_detail->purchase_number) { ?><br><strong><?php _trans('lable34'); ?> : <?php echo $purchase_detail->purchase_number; ?></strong><?php } ?>
                        <?php if ($purchase_detail->purchase_date_created) { ?><br><strong><?php _trans('lable386'); ?> : <?php echo ($purchase_detail->purchase_date_created?date_from_mysql($purchase_detail->purchase_date_created):" "); ?></strong><?php } ?>
						<?php if ($purchase_detail->purchase_date_due) { ?><br><strong><?php _trans('lable127'); ?> : <?php echo ($purchase_detail->purchase_date_due?date_from_mysql($purchase_detail->purchase_date_due):" "); ?></strong><?php } ?>
                    </td>
					<td>
                        <strong><?php _trans('lable1065'); ?>:</strong>
						<?php if ($purchase_detail->supplier_name) { echo '<span>' . $purchase_detail->supplier_name . '</span>'; } ?>
						<?php if ($purchase_detail->supplier_contact_no) { echo '<br><span>' . $purchase_detail->supplier_contact_no . '</span>'; } ?>
						<?php if ($purchase_detail->supplier_email_id) { echo '<br><span>' . $purchase_detail->supplier_email_id . '</span>'; } ?>
					</td>
					<td>
                        <strong><?php _trans('lable1064'); ?>:</strong><br>
						<?php if ($purchase_detail->supplier_street) { echo '<br><span>' . $purchase_detail->supplier_street . '</span>'; } ?>
						<?php if ($purchase_detail->supplier_city) { echo '<br><span>' . $this->mdl_settings->getCityName($purchase_detail->supplier_city,$purchase_detail->supplier_state) . ',</span>'; } ?>
						<?php if ($purchase_detail->supplier_state) { echo '<span>' . $this->mdl_settings->getStateName($purchase_detail->supplier_state,$purchase_detail->supplier_country) . ',</span>'; } ?>
						<?php if ($purchase_detail->supplier_pincode) { echo '<br><span>' . $purchase_detail->supplier_pincode . ',</span>'; } ?>
						<?php if ($purchase_detail->supplier_country) { echo '<span>' . $this->mdl_settings->getCountryName($purchase_detail->supplier_country) . '</span>'; } ?>
					</td>
                </tr>
            </thead>
        </table>
        <div style="padding:5px; background: #F5F5F5;">
            <h4 style="padding:0px; margin: 0;"><?php _trans('lable344'); ?></h4>
        </div>
        <table class="item-table">
            <thead>
                <tr>
                    <th class="item-desc"><?php _trans('lable402'); ?></th>
                    <th class="item-desc" style="text-align: left;"><?php _trans('lable177'); ?></th>
                    <th class="item-desc"><?php _trans('lable396'); ?></th>
                    <th class="item-desc"><?php _trans('lable348'); ?></th>
                    <th class="item-desc" style="text-align: right;"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php _trans('lable399'); ?><br>(Per Qty)</th>
                    <th class="item-desc" style="text-align: right;"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php _trans('lable349'); ?><br>(Per Qty)</th>
                    <th class="item-desc" style="text-align: right;"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php _trans('lable339'); ?> </th>
                    <th class="item-desc" style="text-align: right;"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php _trans('lable351'); ?></th>
                    <th class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php _trans('lable339'); ?></th>
                </tr>
                <?php 
				if(count(json_decode($product_list)) > 0) {
				    $i = 1;
                    $total_item_qty_spare = 0;
                        $total_item_price_spare = 0;
                        $total_item_discount_price_spare = 0;
                        $total_item_amount_spare = 0;
                        $total_igst_amount_spare = 0;
                        $total_item_total_amount_spare = 0;
				    foreach (json_decode($product_list) as $product) {
                        $total_item_qty_spare += $product->item_qty;
                        $total_item_price_spare += $product->item_price;
                        $total_item_discount_price_spare += $product->item_discount_price;
                        $total_item_amount_spare += $product->item_amount;
                        $total_igst_amount_spare += $product->igst_amount;
                        $total_item_total_amount_spare += $product->item_total_amount; ?>
                <tr>
                    <td class="item-desc" style="text-align: center;"><?php echo $i; $i++; ?></td>
                    <td class="item-desc"><?php echo $product->product_name; ?></td>
                    <td class="item-desc"><?php echo $product->item_hsn; ?></td>
                    <td class="item-desc" style="text-align: center;"><?php echo $product->item_qty ? $product->item_qty : '1'; ?></td>
                    <td class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($product->item_price,$this->session->userdata('default_currency_digit')); ?></td>
                    <td class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($product->item_discount_price,$this->session->userdata('default_currency_digit')); ?></td>
                    <td class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($product->item_amount,$this->session->userdata('default_currency_digit')); ?></td>
                    <td><label class="igst_amount_label text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($product->igst_amount,$this->session->userdata('default_currency_digit')).' ('.$product->igst_pct.'% )'; ?></label></td>
                    <td class="item-desc text-right">
                        <label class="item_total_amount_label text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($product->item_total_amount,$this->session->userdata('default_currency_digit')); ?></label>
                    </td>
                </tr>
                <?php } } ?>
            </thead>
            <tfoot class="product_total_calculations">
                <tr>
                    <td colspan="3" class="item-desc text-right"><b><?php echo "Total";?></b></td>
                    <td class="item-desc text-center"><?php echo $total_item_qty_spare; ?></td>
                    <td class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($total_item_price_spare,$this->session->userdata('default_currency_digit')); ?></td>
                    <td class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($total_item_discount_price_spare,$this->session->userdata('default_currency_digit')); ?></td>
                    <td class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($total_item_amount_spare,$this->session->userdata('default_currency_digit')); ?></td>
                    <td class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($total_igst_amount_spare,$this->session->userdata('default_currency_digit')); ?></td>
                    <td class="text-right"><b><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money(($purchase_detail->grand_total?$purchase_detail->grand_total:0),$this->session->userdata('default_currency_digit')); ?></b></td>
                </tr>
            </tfoot>
        </table>
        <table><tr><td height="10"></td></tr></table>
        <div style="width:100%;float:left;">
            <div style="padding-left:10px;width:65%;float:right;font-size:14px;">
                <table class="item-table">
                    <?php if (count(json_decode($product_list)) > 0) { ?>
                    <tr>
                        <td class="item-amount text-right" style="border:none;"><?php _trans('lable356'); ?> : </td>
                        <td class="item-amount text-left" style="border:none;"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($purchase_detail->grand_total,$this->session->userdata('default_currency_digit')); ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td class="item-amount text-right" style="border:none;"><?php _trans('lable332'); ?> : </td>
                        <td class="item-amount text-left" style="border:none;"><b><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($purchase_detail->grand_total,$this->session->userdata('default_currency_digit')); ?></b></td>
                    </tr>
                    <tr>
                        <td class="item-amount text-right" style="border:none;"><?php _trans('lable8'); ?> : </td>
                        <td class="item-amount text-left" style="border:none;"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($purchase_detail->total_paid_amount,$this->session->userdata('default_currency_digit')); ?></td>
                    </tr>
                    <tr>
                        <td class="item-amount text-right" style="border:none;"><?php _trans('lable627'); ?> : </td>
                        <td class="item-amount text-left" style="border:none;"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($purchase_detail->total_due_amount,$this->session->userdata('default_currency_digit')); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </main>
</body>
</html> 