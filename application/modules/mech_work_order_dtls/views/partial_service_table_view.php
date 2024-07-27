<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 paddingLeftRight0px paddingTop20px">
    <h3><?php _trans('lable1022');?></h3>
</div>
<table class="item_table">
    <thead>
        <tr>
			<th width="5%;" style="width:5%;max-width:5%;" class="text-left"><?php _trans('lable346'); ?></th>
			<th width="20%;" style="width:20%;max-width:20%;" class="text-left"><?php _trans('lable177'); ?></th>
			<th width="15%;" style="width:15%;max-width:15%;" class="text-left"><?php _trans('label942'); ?></th>
			<th width="10%;" style="width:10%;max-width:10%;" class="text-left"><?php _trans('lable396'); ?></th>
			<th width="10%;" style="width:10%;max-width:10%;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable399'); ?></th>
			<th width="10%;" style="width:10%;max-width:10%;" class="text-right"><?php _trans('lable1207'); ?></th>
			<th width="10%;" style="width:10%;max-width:10%;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable339'); ?></th>
			<th width="10%;" style="width:10%;max-width:10%;" class="text-right"><?php _trans('lable331'); ?>(%)</th>
			<th width="10%;" style="width:10%;max-width:10%;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable332'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $service_list = json_decode($service_list);
        if(count($service_list) > 0){
        $i = 1;
        $total_user_item_price_service = 0;
		$total_item_discount_price_service = 0;
		$total_item_amount_service = 0;
		$total_igst_amount_service = 0;
        foreach ($service_list as $service){ 
            $total_user_item_price_service += $service->user_item_price; 
			$total_item_discount_price_service += $service->item_discount_price;
			$total_item_amount_service += $service->item_amount;
			$total_igst_amount_service += $service->igst_amount;?>
        <tr>
			<td width="5%" style="width:5%;" class="item-desc text-center"><?php echo $i;$i++; ?></td>
			<td width="20%" style="width:20%;" class="item-name"><?php echo $service->service_item_name; ?></td>
			<td width="15%;" style="width:15%;max-width:15%;" class="text_align_left"><?php echo $service->employee_name; ?></td>
			<td width="10%" style="width:10%;" class="item-desc"><?php echo $service->item_hsn; ?></td>
			<td width="10%" style="width:10%;" class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($service->user_item_price,$this->session->userdata('default_currency_digit')); ?></td>
			<td width="10%" style="width:10%;" class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($service->item_discount_price,$this->session->userdata('default_currency_digit')); ?></td>
			<td width="10%" style="width:10%;" class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($service->item_amount,$this->session->userdata('default_currency_digit')); ?></td>
			<td width="10%" style="width:10%;" class="item-desc text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($service->igst_amount,$this->session->userdata('default_currency_digit')).' ('.$service->igst_pct.'%)'; ?></td>
			<td width="10%" style="width:10%;" class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($service->item_total_amount,$this->session->userdata('default_currency_digit')); ?></td>
        </tr>
        <?php } } ?>
    </tbody>
    <tfoot>
        <tr>
			<td colspan="4" class="item-desc text-right"><b><?php echo "Total"; ?></b></td>
			<td class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money(($total_user_item_price_service?$total_user_item_price_service:0),$this->session->userdata('default_currency_digit')); ?></td>
			<td class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money(($total_item_discount_price_service?$total_item_discount_price_service:0),$this->session->userdata('default_currency_digit')); ?></td>
			<td class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money(($total_item_amount_service?$total_item_amount_service:0),$this->session->userdata('default_currency_digit')); ?></td>
			<td class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')).';'; ?>&nbsp;<?php echo format_money(($total_igst_amount_service?$total_igst_amount_service:0),$this->session->userdata('default_currency_digit')); ?></td>
			<td class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($work_order_detail->service_grand_total?$work_order_detail->service_grand_total:0),$this->session->userdata('default_currency_digit')); ?></td>
        </tr>
    </tfoot>
</table>