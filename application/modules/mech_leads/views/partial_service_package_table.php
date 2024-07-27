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
						<th width="5%;" style="width:5%;max-width:5%;" class="text-center"><?php _trans('lable346'); ?></th>
						<th width="40%;" style="width:30%;max-width:30%;"><?php _trans('lable177'); ?></th>
						<th width="40%;" style="width:30%;max-width:30%;" class="text-left"><?php _trans('label942'); ?></th>
						<th width="15%;" style="width:15%;max-width:15%;"><?php _trans('lable396'); ?></th>
						<th width="15%;" style="width:15%;max-width:15%;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable399'); ?></th>
						<th width="20%;" style="width:15%;max-width:15%;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable338'); ?></th>
						<th width="5%;" style="width:5%;max-width:5%;" class="text-center"></th>
					</thead>
					<tbody>
					<?php
					if ($service_package_list) {
						$i = 1;
						foreach (json_decode($service_package_list) as $service) {?>
							<tr  class="item" id="tr_<?php echo $service->rs_item_id; ?>">
								<td width="5%;" style="width:5%;max-width:5%;" class="item_sno text-center">
									<?php echo $i;++$i; ?>
								</td>
								<td width="40%;" style="width:40%;max-width:40%;"><?php echo $service->service_item_name; ?>
									<input type="hidden" name="rs_item_id" class="rs_item_id" value="<?php echo $service->rs_item_id; ?>">
									<input type="hidden" name="item_service_id" class="item_service_id" id="item_service_id_<?php echo $service->rs_item_id; ?>" value="<?php echo $service->service_item; ?>" readonly>
									<input type="hidden" name="item_service_name" class="item_service_name"  value="<?php echo $service->service_item_name; ?>" readonly>
								</td>
								<td width="14%" style="max-width:14%;width:14%;" class="text-left">
								<select name="employee_id" class="employee_id select2" id="employee_id_"<?php echo $service->rs_item_id; ?>">
									<option value="0"><?php  _trans('lable457'); ?></option>
									<?php if(!empty($getemployee)){
									foreach($getemployee as $getemploye){ ?>
										<option value="<?php echo $getemploye->employee_id; ?>" <?php if($getemploye->employee_id == $service->employee_id){ echo "selected";} ?>><?php echo $getemploye->employee_name; ?></option>
									<?php } } ?>
									</select>
								</td>	
								<td width="15%;" style="width:15%;max-width:15%;">
									<input type="text" name="item_hsn" class="item_hsn form-control" value="<?php echo $service->item_hsn; ?>">
								</td>
								<td width="15%;" style="width:15%;max-width:15%;" class="text-right">
									<input type="hidden" name="mech_lbr_price" class="mech_lbr_price service_id" value="<?php echo $service->mech_item_price; ?>">
									<input type="text" name="usr_lbr_price" class="usr_lbr_price form-control text-right" onblur="service_package_calculation(<?php echo $service->rs_item_id; ?>)" value="<?php echo format_money(($service->user_item_price?$service->user_item_price:0),$this->session->userdata('default_currency_digit')); ?>">
								</td>
								<td width="20%;" style="width:15%; max-width:15%;" class="text-right">
									<input type="hidden" name="item_total_amount" class="item_total_amount" value="<?php echo $service->item_total_amount; ?>" id="item_total_amount_<?php echo $service->rs_item_id; ?>">
									<label class="item_total_amount_label"><?php echo format_money(($service->item_total_amount?$service->item_total_amount:0),$this->session->userdata('default_currency_digit')); ?></label>
								</td>
								<td width="5%;" style="width:5%;max-width:5%;" class="text-center"><span onclick="remove_item(<?php echo $service->rs_item_id; ?>,'package','mech_leads','<?= $this->security->get_csrf_hash(); ?>');"><i class="fa fa-times"></i></span></td>
							</tr>
						<?php } } ?>
					
					</tbody>
					<tfoot class="service_total_calculations">
					<td colspan="4" align="right"></td>
						<td  class="text-right">
						    <span><b><?php _trans('lable339');?></b></span>
							<input type="hidden" name="total_mech_lbr_price" class="total_mech_lbr_price" value="">
							<input type="hidden" name="total_usr_lbr_price" class="total_usr_lbr_price" value="">
						</td>
						<td class="text-center">
							<input type="hidden" name="total_item_total_amount" class="total_item_total_amount" value="">
							<label class="total_item_total_amount_label">0.00</label>
						</td>
						<td></td>
					</tfoot>
				</table>
				<table style="display: none;">
					<tr id="new_service_package_row">
						<td width="5%;" style="width:5%;max-width:5%;" class="item_sno text-center"></td>
						<td width="40%;" style="width:40%;max-width:40%;">
							<input type="hidden" name="item_service_id" class="item_service_id" autocomplete="off">
							<input type="text" name="item_service_name" class="item_service_name capitalize form-control"  style="line-height: normal;border: none; background-color: transparent;padding: 0px;" readonly autocomplete="off">
							<input type="hidden" name="kilo_from" class="kilo_from">
							<input type="hidden" name="kilo_to" class="kilo_to">
							<input type="hidden" name="mon_from" class="mon_from">
							<input type="hidden" name="mon_to" class="mon_to">
						</td>
						<td width="14%" style="max-width:14%;width:14%;" class="text-left">
							<select name="employee_id" class="employee_id">
								<option value="0"><?php  _trans('lable457'); ?></option>
								<?php if(!empty($getemployee)){
								foreach($getemployee as $getemploye){ ?>
									<option value="<?php echo $getemploye->employee_id; ?>"><?php echo $getemploye->employee_name; ?></option>
								<?php } } ?>
							</select>
						</td>
						
						<td width="15%;" style="width:15%;max-width:15%;">
							<input type="text" name="item_hsn" class="item_hsn form-control" value="">
						</td>
						<td width="15%;" style="width:15%;max-width:15%;" class="text-right">
							<input type="hidden" name="mech_lbr_price" class="mech_lbr_price service_id">
							<input type="text" name="usr_lbr_price" class="usr_lbr_price form-control text-right">
						</td>
						<td width="20%;" style="width:15%;max-width:15%;" class="text-right">
							<input type="hidden" name="item_total_amount" class="item_total_amount" value="">
							<label class="item_total_amount_label">0.00</label>
						</td>
						<td width="5%;" style="width:5%;max-width:5%;" class="text-center"><span class="remove_added_item"><i class="fa fa-times"></i></span></td>
					</tr>
				</table>
			</div>
		</section>
	</div>
</div>
