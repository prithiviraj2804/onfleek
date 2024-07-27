<div class="row table-details">
	<div class="col-lg-12">
		<section class="box-typical">
			<div class="box-typical-body">
				<div class="table-responsive">
					<table class="table table-hover" id="service_item_table">
						<thead>
							<th class="text_align_center"><?php _trans('s_no');?>.</th>
							<th class="text_align_center"><?php _trans('service');?></th>
							<th class="text_align_center"><?php _trans('HSN');?></th>
								<?php /* * / ?><th>Mech Labour Price</th><?php / * */ ?>
							<th class="text_align_center"><?php _trans('labour_price');?></th>
							<th class="text_align_center"><?php _trans('taxable');?></th>
							<th></th>
						</thead>
						<tbody>
							<?php $service_list = json_decode($service_list);
							if(count($service_list) > 0){
							$i=1;
							foreach ($service_list as $service) { 
							  		//print_r($service);
							?>
							<tr  class="item text_align_center" id="tr_<?php echo $service->rs_item_id; ?>">
							<td class="item_sno text_align_center"><?php echo $i; $i++; ?></td>
							<td class="text_align_center"><?php echo $service->service_item_name; ?>
								<input type="hidden" name="rs_item_id" value="<?php echo $service->rs_item_id; ?>">
								<input type="hidden" name="item_service_id" class="item_service_id" id="<?php echo $service->sc_item_id; ?>" value="<?php echo $service->sc_item_id; ?>" readonly>
								<input type="hidden" name="item_service_name" class="item_service_name" id="<?php echo $service->rs_item_id; ?>" value="<?php echo $service->service_item_name; ?>" readonly>
								<?php /*
									<select name="item_service_id" class="item_service_id" id="item_service_id_<?php echo $service->item_id; ?>">
										 <option value="0">Select Your Service</option> 
										<option value="<?php echo $service->sc_item_id; ?>" selected><?php echo $service->service_item_name; ?></option>
									</select>
								*/ ?>
							</td>
							<td class="text_align_center"> 
								<input type="text" name="item_hsn" class="item_hsn col-sm-12 text_align_center" value="<?php echo $service->item_hsn; ?>">
							</td>
							<td class="text_align_center">
								<input type="hidden" name="mech_lbr_price" class="mech_lbr_price service_id col-sm-12" value="<?php echo $service->mech_item_price; ?>">
								<input type="text" name="usr_lbr_price" class="usr_lbr_price col-sm-12 text_align_center" onkeyup="service_calculation(<?php echo $service->rs_item_id; ?>)" value="<?php echo $service->user_item_price; ?>">
							</td>
							<td class="text_align_center">
								<input type="hidden" name="item_total_amount" class="item_total_amount" value="<?php echo $service->item_total_amount; ?>" id="<?php echo $service->sc_item_id; ?>">
								<label class="item_total_amount_label text_align_center"><?php echo $service->item_total_amount; ?></label>
							</td>
							<td class="text_align_center" ><span onclick="remove_item(<?php echo $product->rs_item_id; ?>,'service','mech_user_quotes','<?= $this->security->get_csrf_hash() ?>');"><i class="fa fa-times"></i></span></td>
						</tr>
						<?php }} ?>
						<tr id="new_service_row" style="display: none;">
							<td class="item_sno text_align_center"></td>
							<td class="text_align_center" >
								<select name="item_service_id" class="item_service_id">
									<option value="0">Select Your Service</option>
									<?php foreach($service_category_items as $item){ ?> 
									<option value="<?php echo $item->sc_item_id; ?>"><?php echo $item->service_item_name; ?></option>
									<?php } ?>
								</select></td>
								<td class="text_align_center">
										<input type="text" name="item_hsn" class="item_hsn col-sm-12 text_align_center " value="">
									</td>
								<td class="text_align_center" >
									<input type="hidden" name="mech_lbr_price" class="mech_lbr_price service_id col-sm-12">
									<input type="text" name="usr_lbr_price" class="usr_lbr_price col-sm-12 text_align_center ">
								</td>
								<!--td><input type="text" name="item_discount" class="item_discount col-sm-12"></td-->
								<td class="text_align_center" >
									<input type="hidden" name="item_total_amount" class="item_total_amount text_align_center" value="">
									<label class="item_total_amount_label text_align_center">0.00</label></td>
								<td class="text_align_center" ><span class="remove_added_item"><i class="fa fa-times"></i></span></td>
							</tr>
						</tbody>
						<tfoot class="service_total_calculations">
							<td colspan="1" class="text_align_left"><button class="btn add_service">Add Service</button></td>
							<td></td>
							<?php /* * / ?>
							<td>
								<label class="total_mech_lbr_price_label">0.00</label>
							</td>
							<?php / * */ ?>
							<td>
								<input type="hidden" name="total_mech_lbr_price" class="total_mech_lbr_price" value="">
								<input type="hidden" name="total_usr_lbr_price" class="total_usr_lbr_price" value="">
								<!-- <label class="total_usr_lbr_price_label">0.00</label> -->
							</td>
							<td class="text_align_right">
								<input type="hidden" name="total_item_total_amount" class="total_item_total_amount" value="">
								<label class="total_item_total_amount_label">0.00</label>
							</td>
							<td></td>
						</tfoot>
					</table>
				</div>
			</div>
		</section>
	</div>
</div>