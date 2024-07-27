<!DOCTYPE html>
<html lang="<?php _trans('cldr'); ?>">
<head>
    <meta charset="utf-8">
    <title><?php _trans('lable837'); ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mechmen_pdf/css/templates.css">
    <style>
        @page {
            margin-top: 3.5cm;
            margin-bottom: 1cm;
            margin-left: 1cm;
            margin-right: 1cm;
            margin-header: 5mm;
            margin-footer: 5mm;
            footer: html_myHTMLFooter;
            header: html_myHTMLHeader;
        }
        .customer-details tr td {
            width: 33.3px;
            vertical-align: top;
        }
    </style>
</head>
<body>
    <htmlpageheader name="myHTMLHeader">
        <table width="100%">
            <tr width="100%" align="center">
                <td width="100%" colspan="2" style="text-transform: uppercase;width:100%;text-align: center;font-size:24px;float:left;"><?php _trans('lable837'); ?></td>
            </tr>
            <tr width="100%">
                <td style="width:50%;text-align: left;padding: 10px 10px;">
                    <div class="company_logo">
                        <?php $company_details = $this->mdl_workshop_branch->get_company_branch_details($quote_detail->branch_id);
						if($company_details->workshop_logo){ ?>
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
                            echo ' - '.$company_details->name;
                        }?>
                        <?php if ($company_details->branch_contact_no) {
						echo '<br><span>' . $company_details->branch_contact_no . '</span>';
						} ?>
                        <?php if ($company_details->branch_email_id) {
                            echo '<br><span>' . $company_details->branch_email_id . '</span>';
                        } ?>
                        <?php if ($company_details->branch_gstin) {
                            echo '<br><span style="text-transform:uppercase;">' . $company_details->branch_gstin . '</span>';
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
    <main style="padding:12px;">
        <table><tr><td height="15"></td></tr></table>
        <table width="100%" class="item-tables">
            <tr width="100%">
                <td width="46%" style="width:40%;float: left;">
                    <table width="100%">
                    <?php if($quote_detail->jobsheet_no){ ?>
                            <tr width="100%">
                                <td width="35%"><?php _trans('lable1052'); ?> :</td>
                                <td width="65%"><?php echo $quote_detail->jobsheet_no; ?></td>
                            </tr>
                    <?php } if($customer_details->client_name){ ?>
                        <tr width="100%">    
                            <td width="35%" ><?php _trans('lable36'); ?> :</td>
                            <td width="65%"><?php echo $customer_details->client_name;?></td>
                        </tr>
                    <?php }if($quote_detail->user_address_id){ ?>
                        <tr width="100%">    
                            <td width="35%"><?php _trans('lable61'); ?> : </td>
                            <td width="65%"><?php echo $this->mdl_user_address->get_user_complete_address($quote_detail->user_address_id); ?></td>
                        </tr>
                    <?php }if($customer_details->client_gstin){ ?>
                        <tr width="100%">
                            <td width="35%"><?php _trans('lable910'); ?> :</b>
                            <td width="65%"><?php echo $customer_details->client_gstin; ?></td>
                        </tr>
                    <?php } if($customer_details->client_contact_no != "" || $customer_details->client_email_id != ""){?>
                        <tr width="100%">    
                            <td width="35%"><?php _trans('lable1051'); ?> :</td>
                            <td width="65%">
                                <?php echo $customer_details->client_contact_no;?><br>
                                <?php echo $customer_details->client_email_id; ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </table>
                </td>
                <td width="53%" style="float: right; text-align: right;">
                    <table width="100%" style="width:100%;float: right" class="item-tables">
                       <?php if($quote_detail->quote_no){ ?>
                            <tr width="100%" style="width:100%;">
                                <td><?php _trans('lable1050'); ?> :</td>
                                <td><?php echo $quote_detail->quote_no; ?></td>
                            </tr>
                        <?php } if($quote_detail->quote_date){ ?>                    
                            <tr width="100%" style="width:100%;">
                                <td><?php _trans('lable841'); ?> :</td>
                                <td><?php echo ($quote_detail->quote_date?date_from_mysql($quote_detail->quote_date):""); ?></td>
                            </tr>
                        <?php } if($quote_detail->car_reg_no){ ?>
                            <tr width="100%" style="width:100%;">
                                <td><?php _trans('lable72'); ?> :</td>
                                <td><?php echo $quote_detail->car_reg_no; ?></td>
                            </tr>
                        <?php } if($quote_detail->brand_name){ ?>
                            <tr width="100%" style="width:100%;">
                                <td><?php _trans('lable1049'); ?> :</td>
                                <td>
                                    <?php echo $quote_detail->brand_name; ?>
                                </td>
                            </tr>
                        <?php } if($quote_detail->brand_name){ ?>
                            <tr width="100%" style="width:100%;">
                                <td><?php _trans('lable977'); ?>:</td>
                                <td>
                                    <?php echo ($quote_detail->car_model_year?$quote_detail->car_model_year:" ")." ".($quote_detail->model_name?$quote_detail->model_name:" ")." ".($quote_detail->variant_name?$quote_detail->variant_name:""); ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </td>
            </tr>
        </table>
        <br>
        
        <?php if(count(json_decode($product_list)) > 0){ ?>
        <div>
            <h4 style="padding:0px 0px 10px 0px; margin: 0;font-size:12px;font-weight: bold;"><?php _trans('lable344'); ?></h4>
        </div>
        <table class="item-table">
            <thead>
                <tr>
                    <th width="5%" style="width:5%;" class="item-desc text-center"><?php _trans('lable346'); ?></th>
                    <th width="15%" style="width:15%;" class="item-desc"><?php _trans('lable177'); ?></th>
                    <th width="10%" style="width:10%;text-align: center" class="item-desc"><?php _trans('lable396'); ?></th>
                    <th width="5%" style="width:5%;text-align: center" class="item-desc text-center"><?php _trans('lable348'); ?></th>
                    <th width="15%" style="width:15%;" class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;&nbsp;Price (Per Qty)</th>
                    <th width="15%" style="width:15%;" class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;Item Discount<br>(Per Qty)</th>
                    <th width="15%" style="width:15%;" class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php _trans('lable339'); ?></th>
                    <th width="15%" style="width:15%;" class="item-desc text-right"><?php _trans('lable331'); ?>(%)</th>
                    <th width="15%" style="width:15%;" class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php _trans('lable332'); ?></th>
                </tr>
          
                <?php if ($product_list) {
				$i = 1;
                $total_item_qty_spare = 0;
                $total_user_item_price_spare = 0;
                $total_item_discount_price_spare = 0;
                $total_item_amount_spare = 0;
                $total_user_item_price_spare = 0;
                $total_igst_amount_spare = 0;
                $total_item_total_amount_spare = 0;
                foreach (json_decode($product_list) as $product) {  
                    $total_item_qty_spare += $product->item_qty;
                    $total_user_item_price_spare += $product->user_item_price;
                    $total_item_discount_price_spare += $product->item_discount_price;
                    $total_item_amount_spare += $product->item_amount;
                    $total_igst_amount_spare += $product->igst_amount;
                    $total_item_total_amount_spare += $product->item_total_amount;
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
                    <td class="item-desc text-center"><?php echo $total_item_qty_spare; ?></td>
                    <td class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($total_user_item_price_spare,$this->session->userdata('default_currency_digit')); ?></td>
                    <td class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($total_item_discount_price_spare,$this->session->userdata('default_currency_digit')); ?></td>
                    <td class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($total_item_amount_spare,$this->session->userdata('default_currency_digit')); ?></td>
                    <td class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($total_igst_amount_spare,$this->session->userdata('default_currency_digit')); ?></td>
					<td class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money(($quote_detail->product_grand_total?$quote_detail->product_grand_total:o),$this->session->userdata('default_currency_digit')); ?></td>
                </tr>
            </tfoot>
        </table>
        <?php } ?>
    
        <table><tr><td height="20"></td></tr></table>
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
            <?php } ?>
            <br>
            <?php if($quote_detail->quote_terms_condition){?>
                <div style="width: 100%; float: left;">
                    <h6 style="width: 100%; float: left;text-align: left"><?php _trans('lable388');?></h6>
                    <div style="width: 100%; float: left;text-align: left;text-align:justify;"><?php echo $quote_detail->quote_terms_condition; ?></div>
                </div> 
            <?php } if($quote_detail->description){?>
                <div style="width: 100%; float: left;">
                    <h6 style="width: 100%; float: left;text-align: left"><?php _trans('lable177');?></h6>
                    <div style="width: 100%; float: left;text-align: left"><?php echo $quote_detail->description; ?></div>
                </div>
            <?php }  ?>
            </div>

            <div style="padding-left:10px;width:65%;float:right;font-size:14px;">
                <table class="item-table">
                     <tr>
                        <td class="item-amount text-right" style="border:none;"><?php _trans('lable356'); ?> : </td>
                        <td class="item-amount text-left" style="border:none;"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($quote_detail->product_grand_total,$this->session->userdata('default_currency_digit')); ?></td>
                    </tr>
                    <tr>
                        <td class="item-amount text-right" style="border:none;"><?php _trans('lable332'); ?> : </td>
                        <td class="item-amount text-left" style="border:none;"><b><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($quote_detail->grand_total,$this->session->userdata('default_currency_digit')); ?></b></td>
                    </tr>
                </table>
            </div>
        </div>
   
    </main>
 <htmlpagefooter name="myHTMLFooter">
    <div class="footer_bg"><?php _trans('lable1045'); ?></div>
    <div class="welcome" style="width:100%;float:left;">
        <table class="table table-bordered center" style="padding-left:27%;">
            <tr>
            <td>
            <h4><?php _trans('lable1114'); ?></h4>
            <hr style="width:100%;text-align:left;margin-left:0">       
            </td>
            </tr>
        </table>
	</div>
    </htmlpagefooter>
    <?php //exit(); ?>
</body>
</html> 
