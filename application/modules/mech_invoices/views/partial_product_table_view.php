<?php if(count(json_decode($product_list)) > 0){ ?>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 paddingLeftRight0px paddingTop20px">
            <h3>Parts</h3>
        </div>
        <table class="item_table">
            <thead>
                <tr>
                    <th width="6%" style="width:6%;" class="item-desc text-center">S No.</th>
                    <th width="34%" style="width:34%;" class="item-desc"><?php _trans('lable177'); ?></th>
                    <th width="8%" style="width:8%;" class="item-desc">HSN</th>
                    <th width="5%" style="width:5%;" class="item-desc text-center">Qty</th>
                    <th width="16%" style="width:16%;" class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;Price (Per Qty)</th>
                    <th width="13%" style="width:13%;" class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;Item Discount<br>(Per Qty)</th>
                    <th width="6%" style="width:6%;" class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable339'); ?></th>
                    <th width="12%" style="width:12%;" class="item-desc text-right"><?php _trans('lable331'); ?>(%)</th>
                    <th width="15%" style="width:15%;" class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable332'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (count(json_decode($product_list)) > 0) {
				$i = 1;
                $total_item_qty_spare = 0;
                $total_user_item_price_spare = 0;
                $total_item_discount_price_spare = 0;
                $total_item_amount_spare = 0;
                $total_igst_amount_spare = 0;
                $total_item_total_amount_spare = 0;
				foreach (json_decode($product_list) as $product) {
                    $total_item_qty_spare += $product->item_qty;
                    $total_user_item_price_spare += $product->user_item_price;
                    $total_item_discount_price_spare += $product->item_discount_price;
                    $total_item_amount_spare += $product->item_amount;
                    $total_igst_amount_spare += $product->igst_amount;
                    $total_item_total_amount_spare += $product->item_total_amount;?>
                <tr>
                    <td width="6%" style="width:6%;" class="item-desc text-center"><?php echo $i;$i++; ?></td>
                    <td width="34%" style="width:34%;" class="item-desc"><?php echo $product->item_product_name; ?></td>
                    <td width="8%" style="width:8%;" class="item-desc"><?php echo $product->item_hsn; ?></td>
                    <td width="5%" style="width:5%;" class="item-desc text-center"><?php echo $product->item_qty ? $product->item_qty : '1'; ?></td>
                    <td width="16%" style="width:16%;" class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($product->user_item_price,$this->session->userdata('default_currency_digit')); ?></td>
                    <td width="13%" style="width:13%;" class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($product->item_discount_price,$this->session->userdata('default_currency_digit')); ?></td>
                    <td width="6%" style="width:6%;" class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($product->item_amount,$this->session->userdata('default_currency_digit')); ?></td>
                    <td width="12%" style="width:12%;" class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($product->igst_amount,$this->session->userdata('default_currency_digit')).' ( '. $product->igst_pct.' )%'; ?></td>
                    <td width="15%" style="width:15%;" class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($product->item_total_amount,$this->session->userdata('default_currency_digit')); ?></td>
                </tr>
                <?php } } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="item-desc text-right"><b><?php echo "Total";?></b></td>
                    <td class="item-desc text-center"><?php echo $total_item_qty_spare; ?></td>
                    <td class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($total_user_item_price_spare,$this->session->userdata('default_currency_digit')); ?></td>
                    <td class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($total_item_discount_price_spare,$this->session->userdata('default_currency_digit')); ?></td>
                    <td class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($total_item_amount_spare,$this->session->userdata('default_currency_digit')); ?></td>
                    <td class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money($total_igst_amount_spare,$this->session->userdata('default_currency_digit')); ?></td>
					<td class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money(($invoice_detail->product_grand_total?$invoice_detail->product_grand_total:o),$this->session->userdata('default_currency_digit')); ?></td>
                </tr>
            </tfoot>
        </table>
        <?php } ?>