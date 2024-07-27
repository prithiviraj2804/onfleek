<?php if(count(json_decode($service_package_list)) > 0){ ?>
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 paddingLeftRight0px paddingTop20px">
	<h4><?php _trans('lable539');?></h4>
</div>
<table class="item_table">
	<thead>
		<tr>
			<th width="5%;" style="width:5%;max-width:5%;" class="text-left"><?php _trans('lable346'); ?></th>
			<th width="10%;" style="width:10%;max-width:10%;" class="text-left"><?php _trans('lable177'); ?></th>
			<th width="10%;" style="width:10%;max-width:10%;" class="text-left"><?php _trans('label942'); ?></th>
			<th width="15%;" style="width:15%;max-width:15%;" class="text-left"><?php _trans('lable396'); ?></th>
			<th width="15%;" style="width:15%;max-width:15%;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable399'); ?></th>
			<th width="20%;" style="width:15%;max-width:15%;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable338'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php $service_package_list = json_decode($service_package_list);
		if(count($service_package_list) > 0){
		$i = 1;
		foreach ($service_package_list as $service){ ?>
		<tr>
			<td width="5%;" style="width:5%;max-width:5%;" class="item_sno text-left"><?php echo $i; ++$i; ?></td>
			<td width="10%;" style="width:10%;max-width:10%;" class="text_align_left"><?php echo $service->service_item_name; ?></td>
			<td width="10%;" style="width:10%;max-width:10%;" class="text_align_left"><?php echo $service->employee_name; ?></td>
			<td width="15%;" style="width:15%;max-width:15%;" class="text_align_center"><?php echo $service->item_hsn; ?></td>
			<td width="15%;" style="width:15%;max-width:15%;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($service->user_item_price?$service->user_item_price:0),$this->session->userdata('default_currency_digit')); ?></td>
			<td width="20%;" style="width:15%; max-width:15%;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($service->item_total_amount?$service->item_total_amount:0),$this->session->userdata('default_currency_digit')); ?></td>
		</tr>
		<?php } } ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="5" align="right"> <b><?php _trans('lable339');?></b></td>
			<td class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($work_order_detail->service_package_grand_total?$work_order_detail->service_package_grand_total:0),$this->session->userdata('default_currency_digit')); ?></td>
		</tr>
	</tfoot>
</table>
<?php } ?>