<div class="row table-details">
	<div class="col-lg-12">
		<section class="box-typical">
				<div class="table-responsive">
					<table class="table table-hover" id="service_item_table">
						<thead>
								<th class="text_align_center"><?php _trans('s_no');?>.</th>
								<th><?php _trans('service');?></th>
								<th class="text_align_center"><?php _trans('hsn_code');?></th>
								<?php /* * / ?><th>Mech Labour Price</th><?php / * */ ?>
								<th class="text_align_center"><?php _trans('labour_price');?> </th>
								<th class="text_align_center"><?php _trans('taxable');?></th>
						</thead>
						<tbody>
							
						<?php $service_list = json_decode($service_list);
						if(count($service_list) > 0){
							$i=1;
							  foreach ($service_list as $service) { ?>
							  	<tr class="item" id="tr_<?php echo $service->item_id; ?>">
								<td class="item_sno text_align_center"><?php echo $i; $i++; ?></td>
								<td><?php echo $service->service_item_name; ?></td>
								<td class="text_align_center"><?php echo $service->item_hsn; ?></td>
								<td class="text_align_right"><?php echo $service->user_item_price; ?></td>
								<td class="text_align_right"><?php echo $service->item_total_amount; ?></td>
								</tr>
							<?php } } ?>
						</tbody>
					</table>
				</div>
		</section>
	</div>
</div>