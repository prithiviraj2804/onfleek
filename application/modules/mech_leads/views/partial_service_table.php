<div class="row table-details">
	<div class="col-lg-12">
		<div class="col-lg-10 col-md-9 col-sm-8 col-xs-12" style="padding: 10px 15px;">
			<h3><?php _trans('lable1022');?></h3>
		</div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12" style="padding: 10px 15px;">
            <label class="padding0px"><?php _trans('lable330'); ?>:</label>
            <select id="service_discountstate" name="service_discountstate" onchange="service_discountstate()" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 bootstrap-select bootstrap-select-arrow form-control">
                <option <?php if ($mech_leads->service_discountstate == 1) { echo 'selected'; } ?> value="1">&#8377;</option>
                <option <?php if ($mech_leads->service_discountstate == 2) { echo 'selected'; } ?> value="2">&#37;</option>
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
                <a class="float_left fontSize_85rem addservice" href="javascript:void(0)" data-toggle="modal" data-existing_service_ids="<?php echo $existing_service_ids; ?>" data-entity_type="I" data-entity_id="<?php echo $invoice_id; ?>" data-model-from="invoice" data-target="#addservice">
                    + <?php _trans('lable398'); ?>
                </a>
            </div>
			<div class="table-responsive">
				<table class="display table table-bordered" id="service_item_table" style="table-layout: fixed;" >
					<thead>
						<th width="5%;" style="width:5%;max-width:5%;" class="text-center"><?php _trans('lable346'); ?></th>
						<th width="20%;" style="width:20%;max-width:20%;"><?php _trans('lable177'); ?></th>
						<th width="15%;" style="width:15%;max-width:15%;"><?php _trans('lable396'); ?></th>
						<th width="15%;" style="width:15%;max-width:15%;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable399'); ?></th>
						<th width="10%;" style="width:10%;max-width:10%;" class="text-right">
							<span class="showservicerupee" <?php if($mech_leads->service_discountstate != 2 ){ echo 'style="display:block"';}else{ echo 'style="display:none"';} ?> ><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?></span>
							<span class="showservicepercentage" <?php if($mech_leads->service_discountstate == 2 ){ echo 'style="display:block"';}else{ echo 'style="display:none"';} ?>>%</span>&nbsp;<?php _trans('lable1207'); ?></th>
						<th width="11%;" style="width:11%;max-width:11%;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable339'); ?></th>
						<th width="15%;" style="width:15%;max-width:15%;" class="text-right"><?php _trans('lable331'); ?>(%)</th>
						<th width="15%;" style="width:15%;max-width:15%;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable332'); ?></th>
						<th width="5%;" style="width:5%;max-width:5%;" class="text-center"></th>
					</thead>
					<tbody>
						<?php if ($service_list) {
						$i = 1;
						foreach (json_decode($service_list) as $service) {?>
							<tr  class="item" id="tr_<?php echo $service->rs_item_id; ?>">
								<td width="5%;" style="width:5%;max-width:5%;" class="item_sno text-center">
									<?php echo $i;++$i; ?>
								</td>
								<td width="20%;" style="width:20%;max-width:20%;"><?php echo $service->service_item_name; ?>
									<input type="hidden" name="rs_item_id" class="rs_item_id" value="<?php echo $service->rs_item_id; ?>">
									<input type="hidden" name="duplicate_id" class="duplicate_id" id="duplicate_id_<?php echo $service->service_item;?>" value="<?php echo $service->service_item;?>">  
									<input type="hidden" name="item_service_id" class="item_service_id" id="item_service_id_<?php echo $service->rs_item_id; ?>" value="<?php echo $service->service_item; ?>" readonly>
									<input type="hidden" name="kilo_from" class="kilo_from" value="<?php echo $service->kilo_from;?>" readonly>
									<input type="hidden" name="kilo_to" class="kilo_to" value="<?php echo $service->kilo_to;?>" readonly>
									<input type="hidden" name="mon_from" class="mon_from" value="<?php echo $service->mon_from;?>" readonly>
									<input type="hidden" name="mon_to" class="mon_to" value="<?php echo $service->mon_to;?>" readonly>
									<input type="hidden" name="item_service_name" class="item_service_name "  value="<?php echo $service->service_item_name; ?>" readonly>
								</td>
								<td width="15%;" style="width:15%;max-width:15%;">
									<input type="text" name="item_hsn" class="item_hsn form-control" value="<?php echo $service->item_hsn; ?>">
								</td>
								<td width="15%;" style="width:15%;max-width:15%;" class="text-center">
									<input type="hidden" name="mech_lbr_price" class="mech_lbr_price service_id" value="<?php echo $service->mech_item_price; ?>">
									<input type="text" name="usr_lbr_price" class="usr_lbr_price form-control text-right" onblur="service_calculation(<?php echo $service->rs_item_id; ?>)" value="<?php echo format_money(($service->user_item_price?$service->user_item_price:0),$this->session->userdata('default_currency_digit')); ?>">
								</td>
								<td width="10%;" style="width:10%;max-width:10%;" class="text-right">
									<input type="text" name="item_discount" class="item_discount form-control text-right" onblur="service_calculation(<?php echo $service->rs_item_id; ?>)" value="<?php echo format_money(($service->item_discount?$service->item_discount:0),$this->session->userdata('default_currency_digit')); ?>">
									<input type="hidden" name="item_discount_price" value="<?php echo $service->item_discount_price; ?>">
								</td>
								<td width="11%;" style="width:11%;max-width:11%;" class="text-right">
                                	<input type="hidden" name="item_amount" class="item_amount form-control" value="<?php echo $service->item_amount; ?>">
                                	<label style="width:100%;float:left;" class="item_amount_label"><?php echo format_money(($service->item_amount?$service->item_amount:0),$this->session->userdata('default_currency_digit')); ?></label>
                            	</td>
								<td width="15%;" style="width:15%;max-width:15%;" class="text-right">
									<input style="width:35%;float: left; border-bottom-right-radius: 0px;border-top-right-radius: 0px;" type="text" name="igst_pct" class="igst_pct form-control text-right" onkeyup="service_calculation(<?php echo $service->rs_item_id; ?>)" value="<?php echo $service->igst_pct; ?>">
									<input style="width:65%;float: left; border-left:none;border-bottom-left-radius: 0px;border-top-left-radius: 0px;" type="text" name="igst_amount" class="form-control text-right" value="<?php echo format_money(($service->igst_amount?$service->igst_amount:0),$this->session->userdata('default_currency_digit'));  ?>" disable readonly>
								</td>
								<td width="15%;" style="width:15%; max-width:15%;" class="text-right">
									<input type="hidden" name="item_total_amount" class="item_total_amount" value="<?php echo $service->item_total_amount; ?>" id="<?php echo $service->sc_item_id; ?>">
									<label class="item_total_amount_label"><?php echo format_money(($service->item_total_amount?$service->item_total_amount:0),$this->session->userdata('default_currency_digit')); ?></label>
								</td>
								<td width="5%;" style="width:5%;max-width:5%;" class="text-center"><span onclick="remove_item(<?php echo $service->rs_item_id; ?>,'service','mech_leads','<?= $this->security->get_csrf_hash(); ?>');"><i class="fa fa-times"></i></span></td>
							</tr>
						<?php } } ?>
					</tbody>
					<tfoot class="service_total_calculations">
						<td colspan="3" align="right"><span><b><?php _trans('lable339');?></b></span></td>
						<td>
							<input type="hidden" name="total_mech_lbr_price" class="total_mech_lbr_price" value="">
							<input type="hidden" name="total_usr_lbr_price" class="total_usr_lbr_price" value="">
							<label class="total_usr_lbr_price_label text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;0.00</label>
						</td>
						<td>
							<input type="hidden" name="total_item_discount" class="total_item_discount" value="">
							<label class="total_item_discount_label text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;0.00</label>
						</td>
						<td class="text-right">			
							<input type="hidden" name="total_item_amount" class="total_item_amount" value="">
							<label class="total_item_amount_label text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;0.00</label>
                        </td>
						<td class="text-right">
                            <input type="hidden" name="total_igst_amount" class="total_igst_amount" value="">
                            <label class="total_igst_amount_label text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;0.00</label>
                        </td>
						<td class="text-right">
							<input type="hidden" name="total_item_total_amount" class="total_item_total_amount" value="">
							<label class="total_item_total_amount_label text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;0.00</label>
						</td>
						<td class="text-right"></td>
					</tfoot>
				</table>
				<table style="display: none;">
					<tr id="new_service_row">
						<td width="5%;" style="width:5%;max-width:5%;" class="item_sno text-center"></td>
						<td width="20%;" style="width:20%;max-width:20%;">
							<input type="hidden" name="duplicate_id" id="duplicate_id" class="duplicate_id" value="">  
							<input type="hidden" name="item_service_id" class="item_service_id" autocomplete="off">
							<input type="text" name="item_service_name" class="item_service_name capitalize form-control"  style="line-height: normal;border: none; background-color: transparent;padding: 0px;" readonly autocomplete="off">
							<input type="hidden" name="kilo_from" class="kilo_from">
							<input type="hidden" name="kilo_to" class="kilo_to">
							<input type="hidden" name="mon_from" class="mon_from">
							<input type="hidden" name="mon_to" class="mon_to">
						</td>
						<td width="15%;" style="width:15%;max-width:15%;">
							<input type="text" name="item_hsn" class="item_hsn form-control" value="">
						</td>
						<td width="15%;" style="width:15%;max-width:15%;" class="text-right">
							<input type="hidden" name="mech_lbr_price" class="mech_lbr_price service_id">
							<input type="text" name="usr_lbr_price" class="usr_lbr_price form-control text-right">
						</td>
						<td width="10%;" style="width:10%;max-width:10%;" class="text-right">
							<input type="text" name="item_discount" class="item_discount form-control text-right" >
							<input type="hidden" name="item_discount_price" >
						</td>
						<td width="11%;" style="width:11%;max-width:11%;" class="text-right">
							<input type="hidden" name="item_amount" class="item_amount form-control">
							<label style="width:100%;float:left;" class="item_amount_label"></label>
						</td>
						<td width="15%;" style="width:15%;max-width:15%;" class="text-right">
							<input style="width:35%;float: left; border-bottom-right-radius: 0px;border-top-right-radius: 0px;" type="text" name="igst_pct" class="igst_pct form-control text-right">
							<input style="width:65%;float: left; border-left:none;border-bottom-left-radius: 0px;border-top-left-radius: 0px;" type="text" name="igst_amount" class="igst_amount form-control text-right"  disable readonly>
						</td>
						<td width="15%;" style="width:15%;max-width:15%;" class="text-right">
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