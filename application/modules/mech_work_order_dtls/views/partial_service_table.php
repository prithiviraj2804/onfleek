<div class="row table-details">
	<div class="col-lg-12">
		<div class="col-lg-10 col-md-9 col-sm-8 col-xs-12" style="padding: 10px 15px;">
			<h3><?php _trans('lable1022');?></h3>
		</div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12" style="padding: 10px 15px;">
            <label class="padding0px"><?php _trans('lable330'); ?>:</label>
            <select id="service_discountstate" name="service_discountstate" onchange="service_discountstate()" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 bootstrap-select bootstrap-select-arrow form-control">
                <option <?php if ($work_order_detail->service_discountstate == 1) { echo 'selected'; } ?> value="1">&#8377;</option>
                <option <?php if ($work_order_detail->service_discountstate == 2) { echo 'selected'; } ?> value="2">&#37;</option>
            </select>
        </div>
		<section class="box-typical" style="overflow-x: inherit;">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 20px 15px;">
			<?php
                if(count($service_ids) > 0){
                    $existing_service_ids =  implode(',', $service_ids); 
                }else{
                    $existing_service_ids = '0';
                } ?>
                <a class="float_left fontSize_85rem addservice" href="javascript:void(0)" data-toggle="modal" data-existing_service_ids="<?php echo $existing_service_ids; ?>" data-entity_type="J" data-entity_id="<?php echo $work_order_detail->work_order_id; ?>" data-model-from="jobcard" data-target="#addservice">
                    + <?php _trans('lable398'); ?>
                </a>
            </div>
			<div class="table-responsive">
				<table class="display table table-bordered" id="service_item_table" style="table-layout: fixed;" >
					<thead>
						<th width="2%;" style="width:2%;max-width:2%;" class="text-center"><?php _trans('lable346'); ?></th>
						<th width="12%;" style="width:12%;max-width:12%;"><?php _trans('lable177'); ?></th>
						<th width="12%;" style="width:12%;max-width:12%;" class="text-left"><?php _trans('label942'); ?></th>
						<th width="12%;" style="width:12%;max-width:12%;"><?php _trans('lable396'); ?></th>
						<th width="12%;" style="width:12%;max-width:12%;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable399'); ?></th>
						<th width="12%;" style="width:12%;max-width:12%;" class="text-right">
						<span class="showservicerupee" <?php if($work_order_detail->service_discountstate != 2 ){ echo 'style="display:block"';}else{ echo 'style="display:none"';} ?> ><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?></span>
                        <span class="showservicepercentage" <?php if($work_order_detail->service_discountstate == 2 ){ echo 'style="display:block"';}else{ echo 'style="display:none"';} ?>>%</span>&nbsp;<?php _trans('lable1207'); ?></th>
						<th width="12%;" style="width:12%;max-width:12%;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable339'); ?></th>
						<th width="12%;" style="width:12%;max-width:12%;" class="text-right"><?php _trans('lable331'); ?>(%)</th>
						<th width="12%;" style="width:12%;max-width:12%;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable332'); ?></th>
						<th width="2%;" style="width:2%;max-width:2%;" class="text-center"></th>
					</thead>
					<tbody>
					<?php
					if ($service_list) {
						$i = 1;
						foreach (json_decode($service_list) as $service) {?>
							<tr  class="item" id="tr_<?php echo $service->rs_item_id; ?>">
								<td width="2%;" style="width:2%;max-width:2%;" class="item_sno text-center">
									<?php echo $i;++$i; ?>
								</td>
								<td width="12%;" style="width:12%;max-width:12%;"><?php echo $service->service_item_name; ?>
									<input type="hidden" class="rs_item_id" name="rs_item_id" value="<?php echo $service->rs_item_id; ?>">
									<input type="hidden" name="item_service_id" class="item_service_id" id="item_service_id_<?php echo $service->rs_item_id; ?>" value="<?php echo $service->service_item; ?>" readonly>
									<input type="hidden" name="item_service_name" class="item_service_name"  value="<?php echo $service->service_item_name; ?>" readonly>
								</td>
								<td width="12%" style="max-width:12%;width:12%;" class="text-left">
								<select name="employee_id" class="employee_id select2 form-control" id="employee_id_<?php echo $service->rs_item_id; ?>">
									<option value="0"><?php  _trans('lable457'); ?></option>
									<?php if(!empty($getemployee)){
									foreach($getemployee as $getemploye){ ?>
										<option value="<?php echo $getemploye->employee_id; ?>" <?php if($getemploye->employee_id == $service->employee_id){ echo "selected";} ?>><?php echo $getemploye->employee_name; ?></option>
									<?php } } ?>
									</select>
								</td>	
								<td width="12%;" style="width:12%;max-width:12%;">
									<input type="text" name="item_hsn" class="item_hsn form-control" value="<?php echo $service->item_hsn; ?>">
								</td>
								<td width="12%;" style="width:12%;max-width:12%;" class="text-right">
									<input type="hidden" name="mech_lbr_price" class="mech_lbr_price service_id" value="<?php echo $service->mech_item_price; ?>">
									<input type="text" name="usr_lbr_price" class="usr_lbr_price form-control text-right" onblur="service_calculation(<?php echo $service->rs_item_id; ?>)" value="<?php echo format_money(($service->user_item_price?$service->user_item_price:0),$this->session->userdata('default_currency_digit')); ?>">
								</td>
								<td width="12%;" style="width:12%;max-width:12%;" class="text-right">
									<input type="text" name="item_discount" class="item_discount form-control text-right" onblur="service_calculation(<?php echo $service->rs_item_id; ?>)" value="<?php echo format_money(($service->item_discount?$service->item_discount:0),$this->session->userdata('default_currency_digit')); ?>">
									<input type="hidden" name="item_discount_price" value="<?php echo $service->item_discount_price; ?>">
								</td>
								<td width="12%;" style="width:12%;max-width:12%;" class="text-right">
                                	<input type="hidden" name="item_amount" class="item_amount form-control" value="<?php echo $service->item_amount; ?>">
                                	<label style="width:100%;float:left;" class="item_amount_label"><?php echo format_money(($service->item_amount?$service->item_amount:0),$this->session->userdata('default_currency_digit')); ?></label>
                            	</td>
								<td width="12%;" style="width:12%;max-width:12%;" class="text-right">
									<input style="width:35%;float: left; border-bottom-right-radius: 0px;border-top-right-radius: 0px;" type="text" name="igst_pct" class="igst_pct form-control text-right" onkeyup="service_calculation(<?php echo $service->rs_item_id; ?>)" value="<?php echo $service->igst_pct; ?>">
									<input style="width:65%;float: left; border-left:none;border-bottom-left-radius: 0px;border-top-left-radius: 0px;" type="text" name="igst_amount" class="form-control text-right" value="<?php echo format_money(($service->igst_amount?$service->igst_amount:0),$this->session->userdata('default_currency_digit'));  ?>" disable readonly>
								</td>
								<td width="12%;" style="width:12%; max-width:12%;" class="text-right">
									<input type="hidden" name="item_total_amount" class="item_total_amount" value="<?php echo $service->item_total_amount; ?>" id="item_total_amount_<?php echo $service->rs_item_id; ?>">
									<label class="item_total_amount_label"><?php echo format_money(($service->item_total_amount?$service->item_total_amount:0),$this->session->userdata('default_currency_digit')); ?></label>
								</td>
								<td width="2%;" style="width:2%;max-width:2%;" class="text-center"><span onclick="remove_item(<?php echo $service->rs_item_id; ?>,'service','mech_work_order_dtls','<?= $this->security->get_csrf_hash(); ?>');"><i class="fa fa-times"></i></span></td>
							</tr>
						<?php } } ?>
					</tbody>
					<tfoot class="service_total_calculations">
						<td colspan="4" align="right">
							<span><b><?php _trans('lable339');?></b></span>
						</td>
						<td>
							<input type="hidden" name="total_mech_lbr_price" class="total_mech_lbr_price" value="">
							<input type="hidden" name="total_usr_lbr_price" class="total_usr_lbr_price" value="">
							<label class="total_usr_lbr_price_label"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;0.00</label>
						</td>
						<td align="right">
							<input type="hidden" name="total_item_discount" class="total_item_discount" value="">
							<label class="total_item_discount_label"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;0.00</label>
						</td>
						<td class="text-right">			
							<input type="hidden" name="total_item_amount" class="total_item_amount" value="">
							<label class="total_item_amount_label"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;0.00</label>
                        </td>
						<td class="text-right">
                            <input type="hidden" name="total_igst_amount" class="total_igst_amount" value="">
                            <label class="total_igst_amount_label"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;0.00</label>
                        </td>
						<td class="text-right">
							<input type="hidden" name="total_item_total_amount" class="total_item_total_amount" value="">
							<label class="total_item_total_amount_label"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;0.00</label>
						</td>
						<td class="text-right"></td>
					</tfoot>
				</table>
				<table style="display: none;">
					<tr id="new_service_row">
						<td width="2%;" style="width:2%;max-width:2%;" class="item_sno text-center"></td>
						<td width="12%;" style="width:12%;max-width:12%;">
							<input type="hidden" name="item_service_id" class="item_service_id" autocomplete="off">
							<input type="text" name="item_service_name" class="item_service_name capitalize form-control"  style="line-height: normal;border: none; background-color: transparent;padding: 0px;" readonly autocomplete="off">
							<input type="hidden" name="kilo_from" class="kilo_from">
							<input type="hidden" name="kilo_to" class="kilo_to">
							<input type="hidden" name="mon_from" class="mon_from">
							<input type="hidden" name="mon_to" class="mon_to">
						</td>
						<td width="12%" style="max-width:12%;width:12%;" class="text-left">
							<select name="employee_id" class="employee_id form-control">
								<option value="0"><?php  _trans('lable457'); ?></option>
								<?php if(!empty($getemployee)){
								foreach($getemployee as $getemploye){ ?>
									<option value="<?php echo $getemploye->employee_id; ?>"><?php echo $getemploye->employee_name; ?></option>
								<?php } } ?>
							</select>
						</td>
						<td width="12%;" style="width:12%;max-width:12%;">
							<input type="text" name="item_hsn" class="item_hsn form-control" value="">
						</td>
						<td width="12%;" style="width:12%;max-width:12%;" class="text-center">
							<input type="hidden" name="mech_lbr_price" class="mech_lbr_price service_id" value="">
							<input type="text" name="usr_lbr_price" class="usr_lbr_price form-control text-right" value="">
						</td>
						<td width="12%;" style="width:12%;max-width:12%;" class="text-right">
							<input type="text" name="item_discount" class="item_discount form-control text-right" value="">
							<input type="hidden" name="item_discount_price" value="">
						</td>
						<td width="12%;" style="width:12%;max-width:12%;" class="text-right">
							<input type="hidden" name="item_amount" class="item_amount form-control" value="">
							<label style="width:100%;float:left;" class="item_amount_label"></label>
						</td>
						<td width="12%;" style="width:12%;max-width:12%;" class="text-right">
							<input style="width:35%;float: left; border-bottom-right-radius: 0px;border-top-right-radius: 0px;" type="text" name="igst_pct" class="igst_pct form-control text-right">
							<input style="width:65%;float: left; border-left:none;border-bottom-left-radius: 0px;border-top-left-radius: 0px;" type="text" name="igst_amount" class="igst_amount form-control text-right"  disable readonly>
						</td>
						<td width="12%;" style="width:12%; max-width:12%;" class="text-right">
							<input type="hidden" name="item_total_amount" class="item_total_amount" value="" >
							<label class="item_total_amount_label"></label>
						</td>
						<td width="2%;" style="width:2%;max-width:2%;" class="text-center"><span class="remove_added_item"><i class="fa fa-times"></i></span></td>
					</tr>
				</table>
			</div>
		</section>
	</div>
</div>
