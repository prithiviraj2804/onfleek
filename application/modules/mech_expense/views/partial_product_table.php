<div class="row table-details">
	<div class="col-lg-12">
		<section class="box-typical">
			<div class="box-typical-body">
				<div class="table-responsive">
					<table class="table table-hover" id="product_item_table">
						<thead>
								<th><?php _trans('lable402'); ?>.</th>
								<th><?php _trans('lable347'); ?></th>
								<th><?php _trans('lable218'); ?></th>
								<th><?php _trans('lable348'); ?></th>
								<th><?php _trans('lable399'); ?></th>
								<?php /* * / ?><th>Mech Item Price</th><?php / * */ ?>
								<th><?php _trans('lable349'); ?><br>(<?php _trans('lable350'); ?>)</th>
								<th><?php _trans('lable405'); ?>(%)</th>
								<th><?php _trans('lable403'); ?>(%)</th>
								<th><?php _trans('lable404'); ?>(%)</th>
								<!-- <th>Warranty Period</th> -->
								<th><?php _trans('lable339'); ?></th>
								<?php if($expense_details->expense_status != 'PP' && $expense_details->expense_status != 'FP') {?>
								<th></th>
							<?php } ?>
						</thead>
						<tbody>
							<?php 
						if(count(json_decode($product_list)) > 0){
							$i=1;
							foreach (json_decode($product_list) as $product) {
							$selected_product = ""; ?>
							  	<tr class="item" id="tr_<?php echo $product->item_id; ?>">
							  		<input type="hidden" name="item_id" value="<?php echo $product->item_id; ?>" autocomplete="off">
								<td class="item_sno"><?php echo $i; $i++; ?></td>
								<td>
									<?php foreach($product_category_items as $item){
										if($item->product_id==$product->product_id){
											$selected_product = $item->product_name;
										}
									} ?>
									<input name="item_product_id" class="item_product_id" style="width: 150px;" type="text" list="products" value="<?php echo $selected_product; ?>" autocomplete="off"/>
									<datalist id="products">
										<?php foreach($product_category_items as $item){ ?>
										<option data-id="<?php echo $item->product_id; ?>" value="<?php echo $item->product_name; ?>"></option>
										<?php } ?>
									</datalist>
									<select name="product_category_id" class="product_category_id removeError" style="width: 150px;" autocomplete="off">
										<option value="0"><?php _trans('lable471'); ?></option>
										<?php foreach($expense_category_items as $item){ ?> 
										<option value="<?php echo $item->expense_category_id; ?>" <?php if($item->expense_category_id==$product->expense_category_id){
											echo "selected";
										} ?>><?php echo $item->expense_category_name; ?></option>
										<?php } ?>
									</select>
								</td>
								<td>
									<input type="text" name="item_hsn" class="item_hsn col-sm-12" value="<?php echo $product->item_hsn; ?>" autocomplete="off">
								</td>
								<td><input type="text" name="product_qty" class="product_qty col-sm-12" onkeyup="product_calculation(<?php echo $product->item_id; ?>)" value="<?php echo (($product->item_qty)?$product->item_qty:'1'); ?>" autocomplete="off"></td>
								<td><input type="text" name="usr_lbr_price" class="usr_lbr_price col-sm-12"  onkeyup="product_calculation(<?php echo $product->item_id; ?>)"  value="<?php echo $product->item_price; ?>" autocomplete="off">
									<input type="hidden" name="total_amount" class="total_amount" value="<?php echo $product->item_price * $product->item_qty; ?>" autocomplete="off">
									<input type="hidden" name="mech_lbr_price" class="mech_lbr_price product_id col-sm-12" value="<?php echo $product->mech_item_price; ?>" autocomplete="off">
								</td>
								
								<td><input type="text" name="item_discount" class="item_discount col-sm-12"  onkeyup="product_calculation(<?php echo $product->item_id; ?>)" value="<?php echo $product->item_discount; ?>" autocomplete="off">
									<input type="hidden" name="item_discount_price" value="<?php echo $product->item_discount; ?>">
								</td>
								<td><input type="text" name="igst_pct" class="igst_pct col-sm-12" onkeyup="product_calculation(<?php echo $product->item_id; ?>)" value="<?php echo $product->igst_pct; ?>" autocomplete="off">
									<input type="hidden" name="igst_amount" class="igst_amount" value="<?php echo $product->igst_amount; ?>">
								</td>
								<td><input type="text" name="cgst_pct" class="cgst_pct col-sm-12" onkeyup="product_calculation(<?php echo $product->item_id; ?>)" value="<?php echo $product->cgst_pct; ?>" autocomplete="off">
									<input type="hidden" name="cgst_amount" class="cgst_amount" value="<?php echo $product->cgst_amount; ?>">
								</td>
								<td><input type="text" name="sgst_pct" class="sgst_pct col-sm-12" onkeyup="product_calculation(<?php echo $product->item_id; ?>)" value="<?php echo $product->sgst_pct; ?>" autocomplete="off">
									<input type="hidden" name="sgst_amount" class="sgst_amount" value="<?php echo $product->sgst_amount; ?>">
								</td>
								<?php /* * / ?><td>
									<input type="text" name="warrentry_prd" class="warrentry_prd col-sm-12" value="<?php echo $product->warrentry_prd; ?>">
								</td><?php / * */ ?>
								<td><input type="hidden" name="item_total_amount" class="item_total_amount" value="<?php echo $product->item_total_amount; ?>">
									<label class="item_total_amount_label"><?php echo $product->item_total_amount; ?></label></td>
									<?php if($expense_details->expense_status != 'PP' && $expense_details->expense_status != 'FP') {?>
									<td><span onclick="remove_item(<?php echo $product->item_id; ?>,'prod','mech_expense','<?= $this->security->get_csrf_hash() ?>');"><i class="fa fa-times"></i></span></td>
								<?php } ?>
									</tr>
							<?php } } ?>
							
							<tr id="new_product_row" style="display: none;">
							
								<td class="item_sno">1</td>
								<td>
									<input name="item_product_id" placeholder="Select or type expense" class="item_product_id" style="width: 150px;" type="text" list="expense_products" autocomplete="off"/>
									<datalist id="expense_products">
										<?php foreach($product_category_items as $item){ ?> 
										<option data-id="<?php echo $item->product_id; ?>" value="<?php echo $item->product_name; ?>"></option>
										<?php } ?>
									</datalist>
									<select name="product_category_id" class="product_category_id removeError" style="width: 150px;" autocomplete="off">
										<option value="0"><?php _trans('lable471'); ?></option>
										<?php foreach($expense_category_items as $item){ ?> 
										<option value="<?php echo $item->expense_category_id; ?>"><?php echo $item->expense_category_name; ?></option>
										<?php } ?>
									</select>
								</td>
								<td>
									<input type="text" name="item_hsn" class="item_hsn col-sm-12" value="" autocomplete="off">
								</td>
								<td><input type="text" name="product_qty" class="product_qty col-sm-12" autocomplete="off"></td>
								<td><input type="text" name="usr_lbr_price" class="usr_lbr_price col-sm-12" autocomplete="off">
									<input type="hidden" name="total_amount" class="total_amount" value="" autocomplete="off">
									<!--label class="total_amount_label">0.00</label-->
									<input type="hidden" name="mech_lbr_price" class="mech_lbr_price product_id col-sm-12">
									<input type="hidden" name="total_mech_amount" class="total_mech_amount" value="" autocomplete="off">
								</td>
								
								<td><input type="text" name="item_discount" class="item_discount col-sm-12" value="" autocomplete="off">
									<input type="hidden" name="item_discount_price" autocomplete="off"></td>
								<td><input type="text" name="igst_pct" class="igst_pct col-sm-12" autocomplete="off">
									<input type="hidden" name="igst_amount" class="igst_amount" value="" autocomplete="off">
									<!--label class="igst_amount_label">0.00</label-->
								</td>
								<td><input type="text" name="cgst_pct" class="cgst_pct col-sm-12" autocomplete="off">
									<input type="hidden" name="cgst_amount" class="cgst_amount" value="" autocomplete="off">
									<!--label class="cgst_amount_label">0.00</label-->
								</td>
								<td><input type="text" name="sgst_pct" class="sgst_pct col-sm-12" autocomplete="off">
									<input type="hidden" name="sgst_amount" class="sgst_amount" value="" autocomplete="off">
									<!--label class="sgst_amount_label">0.00</label-->
								</td>
								<?php /* * /?>
								<td>
									<input type="text" name="warrentry_prd" class="warrentry_prd col-sm-12">
								</td>
								<?php / * */?>
								<td><input type="hidden" name="item_total_amount" class="item_total_amount" value="" autocomplete="off">
									<label class="item_total_amount_label">0.00</label></td>
								<?php if($expense_details->expense_status != 'PP' && $expense_details->expense_status != 'FP') {?>
								<td><span class="remove_added_item"><i class="fa fa-times"></i></span></td>
							<?php } ?>
						</tr>
						
						</tbody>
						
						<tfoot class="product_total_calculations">
								<td style="background-color:#f6f8fa" colspan="3"><button class="btn add_product"><?php _trans('lable216'); ?></button></td>
								<td></td>
								<td>
									<input type="hidden" name="total_usr_lbr_price" class="total_usr_lbr_price" value="" autocomplete="off">
									<label class="total_usr_lbr_price_label">0.00</label>
									<input type="hidden" name="total_mech_lbr_price" class="total_mech_lbr_price" value="" autocomplete="off">
								</td>
								<?php /* * / ?><td>
									<label class="total_mech_lbr_price_label">0.00</label>
								</td><?php / * */ ?>
								<td>
									<input type="hidden" name="total_item_discount" class="total_item_discount" value="" autocomplete="off">
									<label class="total_item_discount_label">0.00</label>
								</td>
								<td>
									<input type="hidden" name="total_igst_amount" class="total_igst_amount" value="" autocomplete="off">
									<label class="total_igst_amount_label">0.00</label>
								</td>
								<td>
									<input type="hidden" name="total_cgst_amount" class="total_cgst_amount" value="" autocomplete="off">
									<label class="total_cgst_amount_label">0.00</label>
								</td>
								<td>
									<input type="hidden" name="total_sgst_amount" class="total_sgst_amount" value="" autocomplete="off">
									<label class="total_sgst_amount_label">0.00</label>
								</td>
								<!-- <td>
									
								</td> -->
								<td>
									<input type="hidden" name="total_item_total_amount" class="total_item_total_amount" value="" autocomplete="off">
									<label class="total_item_total_amount_label">0.00</label>
								</td>
								<?php if($expense_details->expense_status != 'PP' && $expense_details->expense_status != 'FP') {?>
								<td></td>
							<?php } ?>
						</tfoot>
					</table>
					
				</div>
			</div>
		</section>
	</div>
</div>