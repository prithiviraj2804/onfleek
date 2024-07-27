<div class="row table-details">
	<div class="col-lg-12">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0px 15px;">
			<h3><?php _trans('lable539');?></h3>
		</div>
		<section class="box-typical" style="overflow-x: inherit;">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-12"  style="padding: 20px 15px;">
					<select name="s_pack_id" id="s_pack_id" class="bootstrap-select bootstrap-select-arrow form-control removeError check_error_label" data-live-search="true" autocomplete="off">
						<option value="0"><?php  _trans('lable539'); ?></option>
						<?php if(count($service_package) > 0){
							foreach ($service_package as $key => $serPack){ ?>
								<option value="<?php echo $serPack->s_pack_id ;?>"><?php echo $serPack->package_name; ?></option>
						<?php } } ?>
					</select>
				</div>
			</div>
			<div class="table-responsive">
				<table class="display table table-bordered" id="service_package_item_table" style="table-layout: fixed;" >
					<thead>
						<th class="text-center" width="5%;" style="width:5%;max-width:5%;"><?php _trans('lable346'); ?></th>
						<th width="40%;" style="width:40%;max-width:40%;"><?php _trans('lable177'); ?></th>
						<th width="15%;" style="width:15%;max-width:15%;"><?php _trans('lable396'); ?></th>
						<th class="text-right" width="15%;" style="width:20%;max-width:15%;"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable399'); ?></th>
						<th class="text-right" width="20%;" style="width:20%;max-width:15%;"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable338'); ?></th>
						<th width="5%;" style="width:5%;max-width:5%;" class="text-center"></th>
					</thead>
					<tbody>
					<?php 
						if(count(json_decode($service_package_list)) > 0) {
						$i = 1;
						foreach (json_decode($service_package_list) as $service) {?>
						<tr class="item" id="tr_<?php echo $service->item_id; ?>">
							<td width="5%;" style="width:5%;max-width:5%;" class="item_sno text-center"><?php echo $i; ++$i; ?></td>
							<td width="40%;" style="width:40%;max-width:40%;">
								<input type="hidden" name="item_id" class="item_id" value="<?php echo $service->item_id; ?>">
								<input type="hidden" name="item_service_id" class="item_service_id" id="item_service_id_<?php echo $service->item_id; ?>" value="<?php echo $service->service_item; ?>" readonly>
								<input type="hidden" name="kilo_from" class="kilo_from" value="<?php echo $service->kilo_from;?>" readonly>
								<input type="hidden" name="kilo_to" class="kilo_to" value="<?php echo $service->kilo_to;?>" readonly>
								<input type="hidden" name="mon_from" class="mon_from" value="<?php echo $service->mon_from;?>" readonly>
								<input type="hidden" name="mon_to" class="mon_to" value="<?php echo $service->mon_to;?>" readonly>
								<input type="text" name="item_service_name" class="item_service_name capitalize form-control"  style="line-height: normal;border: none; background-color: transparent;padding: 0px;" value="<?php echo $service->service_item_name; ?>" readonly autocomplete="off">
							</td>
							<td class="text-center" width="15%;" style="width:15%;max-width:15%;">
									<input type="text" name="item_hsn" class="item_hsn form-control" value="<?php echo $service->item_hsn; ?>">
							</td>
							<td class="text-right" width="15%;" style="width:15%;max-width:15%;">
								<input type="hidden" name="mech_lbr_price" class="mech_lbr_price service_id form-control" value="<?php echo $service->mech_item_price; ?>">
								<input type="text" name="usr_lbr_price" class="usr_lbr_price form-control text-right" onblur="service_calculation(<?php echo $service->rs_item_id; ?>)" value="<?php echo format_money(($service->user_item_price?$service->user_item_price:0),$this->session->userdata('default_currency_digit')); ?>">
							</td>
							<td class="text-right" width="20%;" style="width:15%; max-width:15%;">
								<input type="hidden" name="item_total_amount" class="item_total_amount" value="<?php echo $service->item_total_amount; ?>" id="<?php echo $service->sc_item_id; ?>">
								<label class="item_total_amount_label"><?php echo format_money(($service->item_total_amount?$service->item_total_amount:0),$this->session->userdata('default_currency_digit')); ?></label>
							</td>
							<td class="text-center" width="5%;" style="width:5%;max-width:5%;"><span onclick="remove_item(<?php echo $service->item_id; ?>,'package','mech_quotes','<?= $this->security->get_csrf_hash(); ?>');"><i class="fa fa-times"></i></span></td>
						</tr>
						<?php } } ?>
					</tbody>
					<tfoot class="service_total_calculations">
                        <td colspan="3"></td>
						<td align="right">
							<span><b><?php _trans('lable339');?></b></span>
							<input type="hidden" name="total_mech_lbr_price" class="total_mech_lbr_price" value="">
							<input type="hidden" name="total_usr_lbr_price" class="total_usr_lbr_price" value="">
						</td>
						<td class="text-right">
							<input type="hidden" name="total_item_total_amount" class="total_item_total_amount" value="">
							<label class="total_item_total_amount_label"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;0.00</label>
						</td>
						<td class="text-center"></td>
					</tfoot>
				</table>
				<table style="display:none;">
					<tr id="new_service_package_row" style="display: none;">
						<td width="5%;" style="width:5%;max-width:5%;" class="item_sno text-center"></td>
						<td width="40%;" style="width:40%;max-width:40%;">
							<input type="hidden" name="item_service_id" class="item_service_id" autocomplete="off">
							<input type="text" name="item_service_name" class="item_service_name capitalize form-control"  style="line-height: normal;border: none; background-color: transparent;padding: 0px;" readonly autocomplete="off">
							<input type="hidden" name="kilo_from" class="kilo_from">
							<input type="hidden" name="kilo_to" class="kilo_to" >
							<input type="hidden" name="mon_from" class="mon_from">
							<input type="hidden" name="mon_to" class="mon_to">
						</td>
						<td class="text-center" width="15%;" style="width:15%;max-width:15%;">
							<input type="text" name="item_hsn" class="item_hsn form-control" value="">
						</td>
						<td class="text-right" width="15%;" style="width:15%;max-width:15%;">
							<input type="hidden" name="mech_lbr_price" class="mech_lbr_price service_id form-control">
							<input type="text" name="usr_lbr_price" class="usr_lbr_price form-control text-right">
						</td>
						<td class="text-right" width="20%;" style="width:15%;max-width:15%;">
							<input type="hidden" name="item_total_amount" class="item_total_amount" value="">
							<label class="item_total_amount_label">0.00</label>
						</td>
						<td class="text-center" width="5%;" style="width:5%;max-width:5%;"><span class="remove_added_item"><i class="fa fa-times"></i></span></td>
					</tr>
				</table>
			</div>
		</section>
	</div>
</div>
