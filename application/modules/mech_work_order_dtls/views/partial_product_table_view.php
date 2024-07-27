<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 paddingLeftRight0px paddingTop20px">
    <h3>Parts</h3>
</div>
<table class="item_table">
    <thead>
        <tr>
            <th width="3%;" style="width:3%;max-width:3%;" class="text_align_left"><?php _trans('lable346'); ?></th>
            <th width="20%;" style="width:20%;max-width:20%;" class="text_align_left"><?php _trans('lable177'); ?></th>
            <th width="6%;" style="width:6%;max-width:6%;" class="text-center"><?php _trans('lable348'); ?></th>
            <th width="13%;" style="width:13%;max-width:13%;" class="text_align_right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable337'); ?></th>
            <th width="10%;" style="width:10%;max-width:10%;" class="text_align_right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable349'); ?><br>(<?php _trans('lable350'); ?>)</th>
            <th width="11%;" style="width:11%;max-width:11%;" class="text_align_right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable339'); ?></th>
            <th width="13%;" style="width:13%;max-width:13%;" class="text_align_right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable351'); ?></th>
            <th width="16%;" style="width:16%;max-width:16%;" class="text_align_right" ><?php _trans('lable332'); ?></th>
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
            <td width="3%;" style="width:3%;max-width:3%;" class="item_sno text_align_left"><?php echo $i; $i++;?></td>
            <td width="20%;" style="width:20%;max-width:20%;" class="text_align_left" ><?php echo $product->item_service_name; ?></td>
            <td width="6%;" style="width:6%;max-width:6%;" class="text-center"><?php echo $product->item_qty ? $product->item_qty : '1'; ?></td>
            <td width="13%;" style="width:13%;max-width:13%;" class="text_align_right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($product->user_item_price?$product->user_item_price:0),$this->session->userdata('default_currency_digit')); ?></td>
            <td width="10%;" style="width:10%;max-width:10%;" class="text_align_right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($product->item_discount_price?$product->item_discount_price:0),$this->session->userdata('default_currency_digit')); ?></td>
            <td width="11%;" style="width:11%;max-width:11%;" class="text_align_right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($product->item_amount?$product->item_amount:0),$this->session->userdata('default_currency_digit')); ?></td>
            <td width="13%;" style="width:13%;max-width:13%;" class="text_align_right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($product->igst_amount?$product->igst_amount:0),$this->session->userdata('default_currency_digit')).' ('.$product->igst_pct.' %)'; ?></td>
            <td width="16%;" style="width:16%;max-width:16%;" class="text_align_right" ><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($product->item_total_amount?$product->item_total_amount:0),$this->session->userdata('default_currency_digit')); ?></td>
        </tr>
        <?php } } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" class="item-desc text-right"><b><?php _trans('lable339');?></b></td>
            <td class="item-desc text-center"><?php echo $total_item_qty_spare; ?></td>
            <td class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($total_user_item_price_spare?$total_user_item_price_spare:0),$this->session->userdata('default_currency_digit')); ?></td>
            <td class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($total_item_discount_price_spare?$total_item_discount_price_spare:0),$this->session->userdata('default_currency_digit')); ?></td>
            <td class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($total_item_amount_spare?$total_item_amount_spare:0),$this->session->userdata('default_currency_digit')); ?></td>
            <td class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($total_igst_amount_spare?$total_igst_amount_spare:0),$this->session->userdata('default_currency_digit')); ?></td>
            <td class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($work_order_detail->product_grand_total?$work_order_detail->product_grand_total:0),$this->session->userdata('default_currency_digit')); ?></td>
        </tr>
    </tfoot>
</table>