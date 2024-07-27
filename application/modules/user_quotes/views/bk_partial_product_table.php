<div class="row table-details">
	<div class="col-lg-12">
		<section class="box-typical">
			<div class="box-typical-body">
				<div class="table-responsive">
					
					<table class="table table-hover" id="product_item_table">
						<thead>
								<th><?php _trans('item_no');?></th>
								<th><?php _trans('product');?></th>
								<th><?php _trans('quantity');?></th>
								<th><?php _trans('use_item_price');?></th>
								<th><?php _trans('mech_item_price');?></th>
								<th>Item Discount<br>(Per Qty)</th>
								<th><?php _trans('igst');?>(%)</th>
								<th><?php _trans('cgst');?>(%)</th>
								<th><?php _trans('sgst');?>(%)</th>
								<th><?php _trans('warranty_period');?></th>
								<th><?php _trans('total');?></th>
						</thead>
						<tbody>
							<?php 
						if(count(json_decode($product_list)) > 0){
							$i=1;
							  foreach (json_decode($product_list) as $product) { ?>
							  	<tr class="item" id="tr_<?php echo $product->rs_item_id; ?>">
							  		<input type="hidden" name="rs_item_id" value="<?php echo $product->rs_item_id; ?>">
								<td class="item_sno"><?php echo $i; $i++; ?></td>
								<td>
									<select name="item_product_id" class="item_product_id">
										<option value="0">Select Your Product</option>
										<?php foreach($product_category_items as $item){ ?> 
										<option value="<?php echo $item->product_id; ?>" <?php if($item->product_id==$product->service_item){
											echo "selected";
										} ?>><?php echo $item->product_name; ?></option>
										<?php } ?>
								</select></td>
								<td><input type="text" name="product_qty" class="product_qty col-sm-12" onkeyup="product_calculation(<?php echo $product->rs_item_id; ?>)" value="<?php echo $product->item_qty?$product->item_qty:'1'; ?>"></td>
								<td><input type="text" name="usr_lbr_price" class="usr_lbr_price col-sm-12"  onkeyup="product_calculation(<?php echo $product->rs_item_id; ?>)"  value="<?php echo $product->user_item_price; ?>">
									<input type="hidden" name="total_amount" class="total_amount" value="<?php echo $product->user_item_price; ?>">
									<label class="total_amount_label"><?php echo (($product->item_qty)?$product->item_qty:1) * $product->user_item_price; ?></label>
								</td>
								<td><input type="text" name="mech_lbr_price" class="mech_lbr_price product_id col-sm-12" onkeyup="product_calculation(<?php echo $product->rs_item_id; ?>)" value="<?php echo $product->mech_item_price; ?>"></td>
								<td><input type="text" name="item_discount" class="item_discount col-sm-12"  onkeyup="product_calculation(<?php echo $product->rs_item_id; ?>)" value="<?php echo $product->item_discount; ?>">
									<input type="hidden" name="item_discount_price" value="<?php echo $product->item_discount; ?>">
								</td>
								<td><input type="text" name="igst_pct" class="igst_pct col-sm-12" onkeyup="product_calculation(<?php echo $product->rs_item_id; ?>)" value="<?php echo $product->igst_pct; ?>">
									<input type="hidden" name="igst_amount" class="igst_amount" value="<?php echo $product->igst_amount; ?>">
									<label class="igst_amount_label"><?php echo $product->igst_amount; ?></label>
								</td>
								<td><input type="text" name="cgst_pct" class="cgst_pct col-sm-12" onkeyup="product_calculation(<?php echo $product->rs_item_id; ?>)" value="<?php echo $product->cgst_pct; ?>">
									<input type="hidden" name="cgst_amount" class="cgst_amount" value="<?php echo $product->cgst_amount; ?>">
									<label class="cgst_amount_label"><?php echo $product->cgst_amount; ?></label>
								</td>
								<td><input type="text" name="sgst_pct" class="sgst_pct col-sm-12" onkeyup="product_calculation(<?php echo $product->rs_item_id; ?>)" value="<?php echo $product->sgst_pct; ?>">
									<input type="hidden" name="sgst_amount" class="sgst_amount" value="<?php echo $product->sgst_amount; ?>">
									<label class="sgst_amount_label"><?php echo $product->sgst_amount; ?></label>
								</td>
								<td>
									<input type="text" name="warrentry_prd" class="warrentry_prd col-sm-12" value="<?php echo $product->warrentry_prd; ?>">
								</td>
								<td><input type="hidden" name="item_total_amount" class="item_total_amount" value="<?php echo $product->item_total_amount; ?>">
									<label class="item_total_amount_label"><?php echo $product->item_total_amount; ?></label></td>
									</tr>
							<?php } } ?>
							
							<tr id="new_product_row" style="display: none;">
							
								<td class="item_sno">1</td>
								<td>
									<select name="item_product_id" class="item_product_id">
										<option value="0">Select Your Product</option>
										<?php foreach($product_category_items as $item){ ?> 
										<option value="<?php echo $item->product_id; ?>"><?php echo $item->product_name; ?></option>
										<?php } ?>
								</select></td>
								<td><input type="text" name="product_qty" class="product_qty col-sm-12"></td>
								<td><input type="text" name="usr_lbr_price" class="usr_lbr_price col-sm-12">
									<input type="hidden" name="total_amount" class="total_amount" value="">
									<!--label class="total_amount_label">0.00</label-->
								</td>
								<td><input type="text" name="mech_lbr_price" class="mech_lbr_price product_id col-sm-12">
									<input type="hidden" name="total_mech_amount" class="total_mech_amount" value="">
								</td>
								<td><input type="text" name="item_discount" class="item_discount col-sm-12"  value="">
									<input type="hidden" name="item_discount_price"></td>
								<td><input type="text" name="igst_pct" class="igst_pct col-sm-12">
									<input type="hidden" name="igst_amount" class="igst_amount" value="">
									<!--label class="igst_amount_label">0.00</label-->
								</td>
								<td><input type="text" name="cgst_pct" class="cgst_pct col-sm-12">
									<input type="hidden" name="cgst_amount" class="cgst_amount" value="">
									<!--label class="cgst_amount_label">0.00</label-->
								</td>
								<td><input type="text" name="sgst_pct" class="sgst_pct col-sm-12">
									<input type="hidden" name="sgst_amount" class="sgst_amount" value="">
									<!--label class="sgst_amount_label">0.00</label-->
								</td>
								<td>
									<input type="text" name="warrentry_prd" class="warrentry_prd col-sm-12">
								</td>
								<td><input type="hidden" name="item_total_amount" class="item_total_amount" value="">
									<label class="item_total_amount_label">0.00</label></td>
						
						</tr>
						
						</tbody>
						
						<tfoot class="product_total_calculations">
								<td style="background-color:#f6f8fa" colspan="3"><button class="btn add_product">Add product</button></td>
								<td>
									<input type="hidden" name="total_usr_lbr_price" class="total_usr_lbr_price" value="">
									<label class="total_usr_lbr_price_label">0.00</label>
								</td>
								<td>
									<input type="hidden" name="total_mech_lbr_price" class="total_mech_lbr_price" value="">
									<label class="total_mech_lbr_price_label">0.00</label>
								</td>
								<td>
									<input type="hidden" name="total_item_discount" class="total_item_discount" value="">
									<label class="total_item_discount_label">0.00</label>
								</td>
								<td>
									<input type="hidden" name="total_igst_amount" class="total_igst_amount" value="">
									<label class="total_igst_amount_label">0.00</label>
								</td>
								<td>
									<input type="hidden" name="total_cgst_amount" class="total_cgst_amount" value="">
									<label class="total_cgst_amount_label">0.00</label>
								</td>
								<td>
									<input type="hidden" name="total_sgst_amount" class="total_sgst_amount" value="">
									<label class="total_sgst_amount_label">0.00</label>
								</td>
								<td>
									
								</td>
								<td>
									<input type="hidden" name="total_item_total_amount" class="total_item_total_amount" value="">
									<label class="total_item_total_amount_label">0.00</label>
								</td>
						</tfoot>
					</table>
					
				</div>
			</div>
		</section>
	</div>
</div>