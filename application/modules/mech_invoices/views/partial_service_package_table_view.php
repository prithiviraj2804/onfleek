<?php if(count(json_decode($service_package_list)) > 0){ ?>
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 paddingLeftRight0px paddingTop20px">
	<h4><?php _trans('lable539');?></h4>
</div>
<table class="item_table">
	<thead>
		<tr>
			<th width="6%" style="width:6%;" class="item-desc text-center">S No.</th>
			<th width="39%" style="width:39%;" class="item-name"><?php _trans('lable177'); ?></th>
			<!-- <th width="15%" style="width:15%;" class="item-desc">SAC</th> -->
			<th width="20%" style="width:20%;" class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable399'); ?></th>
			<th width="20%" style="width:20%;" class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;Taxable</th>
		</tr>
	</thead>
	<tbody>
		<?php $service_package_list = json_decode($service_package_list);
		if(count($service_package_list) > 0){
		$i = 1;
		foreach ($service_package_list as $service){ ?>
		<tr>
			<td width="6%" style="width:6%;" class="item-desc text-center"><?php echo $i;$i++; ?></td>
			<td width="39%" style="width:39%;" class="item-name"><?php echo $service->service_item_name; ?></td>
			<!-- <td width="15%" style="width:15%;" class="item-desc"><//?php echo $service->item_hsn; ?></td> -->
			<td width="20%" style="width:20%;" class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($service->user_item_price,$this->session->userdata('default_currency_digit')); ?></td>
			<td width="20%" style="width:20%;" class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($service->item_total_amount,$this->session->userdata('default_currency_digit')); ?></td>
		</tr>
		<?php } } ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3" class="item-desc text-right"><b>Total</b></td>
			<td class="item-amount text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($invoice_detail->service_package_grand_total?$invoice_detail->service_package_grand_total:0),$this->session->userdata('default_currency_digit')); ?></td>
		</tr>
	</tfoot>
</table>
<?php } ?>