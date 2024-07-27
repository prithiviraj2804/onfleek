<div class="row table-details">
	<div class="col-lg-12">
		<section class="box-typical">
				<div class="table-responsive">
					<table class="table table-hover" id="product_item_table">
						<thead>
								<th><?php _trans('s_no');?>.</th>
								<th><?php _trans('product');?></th>
								<th><?php _trans('qty');?></th>
								<th><?php _trans('price');?></th>
								<th><?php _trans('item_discount');?><br><?php _trans('per_qty');?></th>
								<th><?php _trans('igst');?> (%)</th>
								<th><?php _trans('cgst');?> (%)</th>
								<th><?php _trans('sgst');?> (%)</th>
								<th><?php _trans('warranty_period');?></th>
								<th><?php _trans('total');?></th>
						</thead>
						<tbody>
							<?php 
						if(count(json_decode($product_list)) > 0){
							$i=1;
							  foreach (json_decode($product_list) as $product) { ?>
							  	<tr class="item" id="tr_<?php echo $product->item_id; ?>">
							  	<td class="item_sno"><?php echo $i; $i++; ?></td>
								<td class="text_align_center"><?php echo $product->product_name; ?><br>HSN: <?php echo $product->item_hsn; ?></td>
								
								<td><?php echo $product->item_qty?$product->item_qty:'1'; ?></td>
								<td><?php echo $product->user_item_price; ?>
									<label class="total_amount_label"><?php echo (($product->item_qty)?$product->item_qty:1) * $product->user_item_price; ?></label>
								</td>
								
								<td><?php echo $product->item_discount; ?></td>
								<td><?php echo $product->igst_pct; ?>
									<label class="igst_amount_label"><?php echo $product->igst_amount; ?></label>
								</td>
								<td><?php echo $product->cgst_pct; ?>
									<label class="cgst_amount_label"><?php echo $product->cgst_amount; ?></label>
								</td>
								<td><?php echo $product->sgst_pct; ?>
									<label class="sgst_amount_label"><?php echo $product->sgst_amount; ?></label>
								</td>
								<td><?php echo $product->warrentry_prd; ?></td>
								<td><?php echo $product->item_total_amount; ?>
									<label class="item_total_amount_label"><?php echo $product->item_total_amount; ?></label>
								</td>
								</tr>
							<?php } } ?>
						</tbody>
					</table>
					
				</div>
		</section>
	</div>
</div>