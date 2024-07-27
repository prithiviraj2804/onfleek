<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/lib/summernote/summernote.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/separate/pages/editor.min.css">
<script type="text/javascript">
var service_cost_setup = '<?php echo $this->session->userdata('service_cost_setup'); ?>';
</script>
<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
<header class="page-content-header">
	<div class="container">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php  _trans('lable257'); ?></h3>
				</div>
				<div class="tbl-cell pull-right">
					<a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_item_master/service_create'); ?>">
                        <i class="fa fa-plus"></i> <?php _trans('lable40'); ?>
                    </a>
				</div>
			</div>
		</div>
	</div>
</header>
<div id="content">
	<div class="row">
		<div id="gif" class="gifload">
			<div class="gifcenter">
			  <center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
		    </div>
		</div>
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 top-15">
			<a class="anchor anchor-back" onclick="goBack()" href="<?php echo site_url('mech_item_master/service_index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
		</div>
        <div class="col-xl-12 col-xl-offset-3 col-lg-12 col-lg-offset-3 col-md-12 col-md-offset-3 col-sm-12 col-12">
			<div class="container">
            	<input class="hidden" name="is_update" type="hidden" <?php if($this->mdl_mech_service_master->form_value('is_update')){echo 'value="1"';} else {echo 'value="0"';}?> >
                <input class="hidden" id="msim_id" name="msim_id" type="hidden" value="<?php echo $this->mdl_mech_service_master->form_value('msim_id', true)?>" >
                <input class="hidden" id="msipl_id" name="msipl_id" type="hidden" value="<?php echo $service->msipl_id;?>" >
				<div class="box">
					<div class="box_body">
						<div class="row">
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
								<div class="form_group">
									<label class="form_label"><?php _trans('lable253'); ?>*</label>
									<div class="form_controls">
									<?php if($this->mdl_mech_service_master->form_value('workshop_id', true) != 1){ ?>
										<input type="text" name="service_item_name" id="service_item_name" class="form-control" value="<?php echo $this->mdl_mech_service_master->form_value('service_item_name', true); ?>">
									<?php }else { ?> 
										<input type="hidden" name="service_item_name" id="service_item_name" class="form-control" value="<?php echo $this->mdl_mech_service_master->form_value('service_item_name', true); ?>">
										<?php echo $this->mdl_mech_service_master->form_value('service_item_name', true); } ?>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
								<div class="form_group">
									<label class="form_label"><?php  _trans('lable239'); ?> *</label>
									<div class="form_controls">
									<?php if($this->mdl_mech_service_master->form_value('workshop_id', true) != 1){ ?>
										<select name="service_category_id" id="service_category_id" class="bootstrap-select bootstrap-select-arrow form-control removeError check_error_label" data-live-search="true" autocomplete="off">
											<option value=""><?php  _trans('lable252'); ?></option>
											<?php $service_category_id = $this->mdl_mech_service_master->form_value('service_category_id', true);
											if($service_category_lists):
											foreach ($service_category_lists as $key => $service_category): ?>
											<option value="<?php echo $service_category->service_cat_id; ?>" <?php if ($service_category->service_cat_id == $service_category_id) {
												echo 'selected';
											} ?>> <?php echo $service_category->category_name; ?></option>
											<?php endforeach;
											endif;
											?>
										</select>
										<?php }else {  ?>
											<input type="hidden" name="service_category_id" id="service_category_id" class="form-control" value="<?php echo $this->mdl_mech_service_master->form_value('service_category_id', true); ?>">
										<?php 
											echo $this->mdl_mech_service_master->form_value('category_name', true); } ?>
									</div>	
								</div>
							</div>
						</div>
						<div class="row genericBox" <?php if($this->mdl_mech_service_master->form_value('apply_for_all_bmv', true) == 'S'){ echo 'style="display:none"'; }else { echo 'style="display:block"'; } ?>>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
								<div class="form_group">
									<label class="form_label"><?php _trans('lable878'); ?></label>
									<div class="form_controls">
										<input type="text" name="estimated_hour" id="estimated_hour" class="form-control" value="<?php echo $this->mdl_mech_service_master->form_value('estimated_hour', true); ?>">
									</div>
								</div>
							</div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
								<div class="form_group">
									<label class="form_label"><?php _trans('lable879'); ?></label>
									<div class="form_controls">
										<input type="text" name="estimated_cost" id="estimated_cost" class="form-control" value="<?php echo ($service->estimated_cost?$service->estimated_cost:$this->mdl_mech_service_master->form_value('default_estimated_cost', true)); ?>">
									</div>
								</div>
							</div>
						</div>
						<div class="row paddingTop20px">
							<div class="col-xs-6 col-md-6">
								<div class="form_group">
									<div class="form_controls">
										<input id="generic_part" class="apply_for_all_bmv" name="apply_for_all_bmv" <?php if($this->mdl_mech_service_master->form_value('apply_for_all_bmv', true) == 'Y' || $this->mdl_mech_service_master->form_value('apply_for_all_bmv', true) == ''){ echo "checked"; } ?> type="radio" value="Y" >
										<span><?php  _trans('lable1202'); ?> </span>
									</div>
									<div class="form_controls">
										<input id="specific_part" class="apply_for_all_bmv" name="apply_for_all_bmv" <?php if($this->mdl_mech_service_master->form_value('apply_for_all_bmv', true) == 'N'){ echo "checked"; } ?> type="radio" value="N" >
										<span><?php  _trans('lable1203'); ?> </span>
									</div>
									<div class="form_controls">
										<input id="specific_type" class="apply_for_all_bmv" name="apply_for_all_bmv" <?php if($this->mdl_mech_service_master->form_value('apply_for_all_bmv', true) == 'S'){ echo "checked"; } ?> type="radio" value="S" >
										<span><?php  _trans('lable1204'); ?> </span>
									</div>
								</div>
							</div>
						</div>
						<div class="row table-details modelandvariants"  <?php if($this->mdl_mech_service_master->form_value('apply_for_all_bmv', true) == 'N'){ echo 'style="display:block"'; }else{ echo 'style="display:none"';}?>>
							<div class="col-lg-12">
								<section class="box-typical">
									<div class="box-typical-body">
										<div class="table-responsive">
											<table class="display table table-bordered" id="product_item_table" width="100%" style="width:100%;float:left;table-layout: fixed;">
												<thead>
													<th width="2%" style="max-width:2%;width:2%;" class="text-center"><?php _trans('lable346'); ?></th>
													<th width="20%" style="max-width:20%;width:20%;" class="text-left"><?php _trans('lable229'); ?></th>
													<th width="20%" style="max-width:20%;width:20%;" class="text-left"><?php _trans('lable231'); ?></th>
													<th width="20%" style="max-width:20%;width:20%;" class="text-left"><?php _trans('lable232'); ?></th>
													<th width="18%" style="max-width:18%;width:18%;" class="text-left"><?php _trans('lable132'); ?></th>
													<th width="18%" style="max-width:18%;width:18%;" class="text-left"><?php echo _trans('lable130'); ?></th>
													<th width="2%" style="max-width:2%;width:2%;"></th>
												</thead>
												<tbody>
												<?php if(count($subproducts) > 0) { $i = 1;
												foreach ($subproducts as $product) {  ?>
													<tr class="item" id="tr_<?php echo $product->product_id; ?>">
														<input type="hidden" name="service_map_id" value="<?php echo $product->service_map_id; ?>">
														<input type="hidden" name="duplicate_service_map_id" value="<?php echo $product->service_map_id; ?>">
														<td width="2%" style="max-width:2%;width:2%;" class="item_sno text-center"><?php echo $i; $i++; ?></td>
														<td width="20%" style="max-width:20%;width:20%;" class="text-left">
															<select name="brand_id" class="brand_id select2 removeError" id="brand_id_<?php echo $product->service_map_id; ?>" onchange="getModelList(<?php echo $product->service_map_id; ?>)">
																<option value="0"><?php  _trans('lable73'); ?></option>
																<?php if(!empty($car_brand_list)){
																foreach($car_brand_list as $brand_list){ ?>
																	<option value="<?php echo $brand_list->brand_id; ?>" <?php if($product->brand_id == $brand_list->brand_id){ echo "selected"; } ?> ><?php echo $brand_list->brand_name; ?></option>
																<?php } } ?>
															</select>
														</td>
														<td width="20%" style="max-width:20%;width:20%;" class="text-left">
															<select name="model_id" class="model_id select2 removeError" id="model_id_<?php echo $product->service_map_id;?>" onchange="getvariantList(<?php echo $product->service_map_id; ?>)">
																<option value=""><?php  _trans('lable74'); ?></option>
																<?php if(!empty($car_model_list)){
																	foreach ($car_model_list as $model_list){ ?>
																	<option value="<?php echo $model_list->model_id; ?>" <?php if($product->model_id == $model_list->model_id){ echo "selected"; } ?> ><?php echo $model_list->model_name;?></option>
																<?php }}?>
															</select>
														</td>
														<td width="20%" style="max-width:20%;width:20%;" class="text-left">
															<select name="variant_id" class="variant_id select2" id="variant_id_<?php echo $product->service_map_id;?>">
																<option value=""><?php  _trans('lable75'); ?></option>
																<?php if ($car_variant_list){
																foreach ($car_variant_list as $names){ ?>
																<option value="<?php echo $names->brand_model_variant_id; ?>" <?php if($product->variant_id == $names->brand_model_variant_id){ echo "selected"; } ?>><?php echo $names->variant_name; ?></option>
																<?php } } ?>
															</select>
														</td>
														<td width="18%" style="max-width:18%;width:18%;" class="text-left">
															<select name="fuel_type" class="fuel_type select2" id="fuel_type_<?php echo $product->service_map_id;?>">
																<option value="0">select Fuel Type</option>
																<option value="P" <?php if($product->fuel_type == 'P'){ echo "selected"; } ?>><?php echo 'Petrol';?></option>
																<option value="D" <?php if($product->fuel_type == 'D'){ echo "selected"; } ?>><?php echo 'Diesel';?></option>
																<option value="O" <?php if($product->fuel_type == 'O'){ echo "selected"; } ?>><?php echo 'Others';?></option>
															</select>
														</td>
														<td width="18%" style="max-width:18%;width:18%;" class="text-left">
															<select name="year" class="year select2" data-live-search="true" id="year_<?php echo $product->service_map_id;?>">
																<option value="0">select Year</option>
																<?php for($j = 1980; $j <= date("Y"); $j++){ ?>
																	<option value="<?php echo $j;?>" <?php if($product->year == $j){ echo "selected"; } ?>><?php echo $j;?></option>
																<?php } ?>
															</select>
														</td>
														<td width="2%" style="max-width:2%;width:2%;" >
															<span onclick="delete_record('products',<?php echo $product->product_id; ?>,'<?= $this->security->get_csrf_hash() ?>');"><i class="fa fa-times"></i></span>
														</td>
													</tr>
													<?php } } ?>
												</tbody>
												<tfoot class="product_total_calculations">
													<td colspan="9"><button class="btn add_product"><?php _trans('lable409'); ?></button></td>
												</tfoot>
											</table>
											<table>
												<tr id="new_product_row" style="display: none;">
													<input type="hidden" name="service_map_id" class="service_map_id">
													<input type="hidden" name="duplicate_service_map_id" class="duplicate_service_map_id">
													<td width="2%" style="max-width:2%;width:2%;" class="item_sno text-center"></td>
													<td width="20%" style="max-width:14%;width:14%;" class="text-left">
														<select name="brand_id" class="brand_id removeError">
															<option value="0"><?php  _trans('lable73'); ?></option>
															<?php if(!empty($car_brand_list)){
															foreach($car_brand_list as $brand_list){ ?>
																<option value="<?php echo $brand_list->brand_id; ?>"><?php echo $brand_list->brand_name; ?></option>
															<?php } } ?>
														</select>
													</td>
													<td width="20%" style="max-width:20%;width:20%;" class="text-left">
														<select name="model_id" class="model_id removeError">
															<option value="0"><?php  _trans('lable74'); ?></option>
															<?php if(!empty($car_model_list)){
																foreach ($car_model_list as $model_list){ ?>
																<option value="<?php echo $model_list->model_id; ?>"><?php echo $model_list->model_name;?></option>
															<?php }}?>
														</select>
													</td>
													<td width="20%" style="max-width:20%;width:20%;" class="text-left">
														<select name="variant_id" class="variant_id removeError">
															<option value="0"><?php  _trans('lable75'); ?></option>
															<?php if ($car_variant_list){
															foreach ($car_variant_list as $names){ ?>
															<option value="<?php echo $names->brand_model_variant_id; ?>"><?php echo $names->variant_name; ?></option>
															<?php } } ?>
														</select>
													</td>
													<td width="18%" style="max-width:18%;width:18%;" class="text-left">
														<select name="fuel_type" class="fuel_type">
															<option value="0">select Fuel Type</option>
															<option value="P"><?php echo 'Petrol';?></option>
															<option value="D"><?php echo 'Diesel';?></option>
															<option value="O"><?php echo 'Others';?></option>
														</select>
													</td>
													<td width="18%" style="max-width:18%;width:18%;" class="text-left">
														<select name="year" class="year" data-live-search="true">
															<option value="0">select Year</option>
															<?php for($j = 1980; $j <= date("Y"); $j++){ ?>
																<option value="<?php echo $j;?>" <?php if($j == date('Y')){ echo 'selected'; } ?> ><?php echo $j;?></option>
															<?php } ?>
														</select>
													</td>
													<td width="18%" style="max-width:18%;width:18%;" class="text-left">
														<input type="text" name="estimated_hour" class="estimated_hour form-control" >
													</td>
													<td width="18%" style="max-width:18%;width:18%;" class="text-left">
														<input type="text" name="estimated_cost" class="estimated_cost form-control" >
													</td>
													<td width="2%" style="max-width:2%;width:2%;" class="text-center">
														<span class="remove_added_item"><i class="fa fa-times"></i></span>
													</td>
												</tr>
											</table>
										</div>
									</div>
								</section>
							</div>
						</div>
						<div class="row bodyType" <?php if($this->mdl_mech_service_master->form_value('apply_for_all_bmv', true) == 'S'){ echo 'style="display:block"'; }else{ echo 'style="display:none"';}?>>
							<div id="checkinListDatas" class="col-lg-12 col-lg-12 col-sm-12 col-xs-12 paddingTop20px">
								<div class="row">
									<div class="multi-field col-lg-12 col-lg-12 col-sm-12 col-xs-12">
										<div class="form-group clearfix">
											<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text_align_left"><b><?php _trans('lable78'); ?></b></div>
											<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><b><?php _trans('lable878')?></b></div>
											<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right"><b><?php _trans('lable879')?></b></div>
										</div>
									</div>
								</div>
								<?php if(count($mechVehicleType) > 0){  
									
								$i = 1;
								foreach ($mechVehicleType as $checkInList) { 
									$hours = '';
									$cost = '';
									$default_cost = '';
									$sct_id = '';
									foreach($service_body_type_details as $serviceDetailsList){
										if($serviceDetailsList->mvt_id == $checkInList->mvt_id){  
											$sct_id = $serviceDetailsList->sct_id;
											$hours = $serviceDetailsList->estimated_hour;
											$cost = $serviceDetailsList->estimated_cost;
											$default_cost = $serviceDetailsList->default_cost;
										}
									}?>
																		
								<div class="row servicesCheckinListDatas" id="model_row_<?php echo $checkInList->mvt_id;?>">
									<div class="multi-field col-lg-12 colg-12 col-sm-12 col-xs-12">
										<div class="form-group clearfix">
											<input type="hidden" id="sct_<?php echo ($sct_id?$sct_id:"");?>"  name="sct_id" class="sct_id" value="<?php echo ($sct_id?$sct_id:"");?>">
											<input type="hidden" id="mvt_<?php echo $checkInList->mvt_id;?>"  name="mvt_id" class="mvt_id" value="<?php echo $checkInList->mvt_id;?>">
											<input type="hidden" name="default_cost" class="default_cost form-control" style="padding: 8px 4px;" value="<?php echo $checkInList->default_cost;?>">
											<input type="hidden" name="vehicle_type_value" class="vehicle_type_value form-control" style="padding: 8px 4px;" value="<?php echo $checkInList->vehicle_type_value;?>">
											<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text_align_left paddingTop7px"><?php echo $checkInList->vehicle_type_name; ?></div>
											<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
												<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text_align_left paddingTop7px text_align_right">hours&nbsp;&nbsp; </div>
												<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 ml_15px padding0px">
													<input type="text" name="estimated_hour" id="estimated_hour_<?php echo ($checkInList->sct_id?$checkInList->sct_id:$i);?>" onkeyup="costHourBasedCalculation(<?php echo $checkInList->mvt_id;?>)" class="estimated_hour checkin_hours_<?php echo $checkInList->mvt_id; ?> text-center form-control" style="padding: 8px 4px;" value="<?php echo ($hours?$hours:1);?>">
												</div>
											</div>
											<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
												<input type="text" name="estimated_cost" id="estimated_cost_<?php echo ($checkInList->sct_id?$checkInList->sct_id:$i);?>" class="estimated_cost checkin_cost_<?php echo $checkInList->mvt_id; ?> form-control text_align_right twodigit" style="padding: 8px 4px;" value="<?php echo ($cost?$cost:$checkInList->default_cost);?>">
											</div>
										</div>
									</div>
								</div>
								<?php ++$i;} } ?>
							</div>
						</div>
						<div class="row paddingTop20px">
							<div class="col-xs-6 col-md-6">
								<div class="form_group">
									<div class="form_controls">
										<input id="fill_gst" name="fill_gst" <?php if($this->mdl_mech_service_master->form_value('fill_gst', true) == 'Y'){ echo "checked"; } ?> type="checkbox" value="<?php echo ($this->mdl_mech_service_master->form_value('fill_gst', true)?$this->mdl_mech_service_master->form_value('fill_gst', true):'N'); ?>" >
										<span><?php  _trans('lable1197'); ?> </span>
									</div>
								</div>
							</div>
						</div>
						<div class="row show_gst_box" <?php if($this->mdl_mech_service_master->form_value('fill_gst', true) == 'Y'){ echo 'style="display:block;"'; }else{ echo 'style="display:none;"'; } ?>>
							<div class="col-xs-4 col-md-4">
								<div class="form_group">
									<label class="form_label"><?php  _trans('lable1198'); ?> *</label>
									<div class="form_controls">
										<select name="tax_id" id="tax_id" class="bootstrap-select bootstrap-select-arrow removeError" data-live-search="true">
											<option value=""><?php _trans('lable1199'); ?></option>
											<?php foreach ($gst_categories as $mech_tax) { ?>
												<option value="<?php echo $mech_tax->tax_id; ?>" <?php if($mech_tax->tax_id == $this->mdl_mech_service_master->form_value('tax_id', true)){ echo "selected"; } ?>><?php echo $mech_tax->tax_name; ?></option>
											<?php } ?>
										</select>
										<div class="col-lg-12 paddingTop5px paddingLeft0px">
										<a href="javascript:void(0)" data-toggle="modal" data-model-from="tax" data-module-type="T" data-target="#addTax" class="fontSize_85rem float_left add_tax">+ <?php _trans('lable1177'); ?></a>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-4 col-md-4">
								<div class="form_group">
									<label class="form_label"> <?php _trans('lable218'); ?></label>
									<div class="form_controls">
										<input type="text" name="sku" id="sku" class="form-control" value="<?php echo $this->mdl_mech_service_master->form_value('sku', true); ?>">
									</div>
								</div>
							</div>
							<div class="col-xs-4 col-md-4">
								<div class="form_group">
									<label class="form_label"> <?php  _trans('lable227'); ?></label>
									<div class="form_controls">
										<input type="text" name="tax_percentage" id="tax_percentage" class="form-control"
									value="<?php echo $this->mdl_mech_service_master->form_value('tax_percentage'); ?>">
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 padding0px">
								<div class="col-xs-6 col-md-6">
									<div class="form_group">
										<div class="form_controls">
											<input type="hidden" name="mon_from" id="mon_from" onkeypress="return isNumberKey(event)" class="form-control" value="<?php echo $this->mdl_mech_service_master->form_value('mon_from', true); ?>">
											<input type="hidden" name="mon_from" id="mon_from" class="form-control" value="<?php echo $this->mdl_mech_service_master->form_value('mon_from', true); ?>" >
										</div>
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 ">
									<div class="form_group">
										<div class="form_controls">
											<input type="hidden" name="mon_to" id="mon_to" onkeypress="return isNumberKey(event)" class="form-control" value="<?php echo $this->mdl_mech_service_master->form_value('mon_to', true); ?>">
											<input type="hidden" name="mon_to" id="mon_to" class="form-control" value="<?php echo $this->mdl_mech_service_master->form_value('mon_to', true); ?>" >
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12  padding0px">
								<div class="col-xs-6 col-md-6">
									<div class="form_group">
										<div class="form_controls">
											<input type="hidden" name="kilo_from" id="kilo_from" onkeypress="return isNumberKey(event)" class="form-control" value="<?php echo $this->mdl_mech_service_master->form_value('kilo_from', true); ?>">
											<input type="hidden" name="kilo_from" id="kilo_from" class="form-control" value="<?php echo $this->mdl_mech_service_master->form_value('kilo_from', true); ?>" >
										</div>
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 ">
									<div class="form_group">
										<div class="form_controls">
											<input type="hidden" name="kilo_to" id="kilo_to" onkeypress="return isNumberKey(event)" class="form-control" value="<?php echo $this->mdl_mech_service_master->form_value('kilo_to', true); ?>">
											<input type="hidden" name="kilo_to" id="kilo_to" class="form-control" value="<?php echo $this->mdl_mech_service_master->form_value('kilo_to', true); ?>" >
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form_group">
							<label class="form_label"><?php  _trans('lable177'); ?></label>
							<div class="form_controls">
								<div class="summernote-theme-1">
									<textarea name="complete_service_description" id="complete_service_description" class="summernote" name="name"><?php echo $this->mdl_mech_service_master->form_value('complete_service_description', true); ?></textarea>
								</div>
							</div>
						</div>
						<div class="buttons text-center paddingTop40px">
							<button name="btn_submit" class="btn_submit btn btn-rounded btn-primary" value="2">
								<i class="fa fa-check"></i> <?php  _trans('lable57'); ?>
							</button>
							<button name="btn_submit" class="btn_submit btn btn-rounded btn-primary" value="1">
								<i class="fa fa-check"></i> <?php  _trans('lable234'); ?>
							</button>
							<button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default" value="1">
								<i class="fa fa-times"></i> <?php  _trans('lable58'); ?>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>assets/mp_backend/js/lib/summernote/summernote.min.js"></script>
<script type="text/javascript">

	function getModelList(row_id){
		$('#gif').show();
		$.post("<?php echo site_url('user_cars/ajax/get_brand_models'); ?>", {
			brand_id: $('#brand_id_'+row_id).val(),
			_mm_csrf: $('#_mm_csrf').val()
		},function (data) {
			var response = JSON.parse(data);
			$('#variant_id_'+row_id).empty();
			$('#variant_id_'+row_id).append($('<option></option>').attr('value', '').text('Select Variant'));
			$("#variant_id_"+row_id).select2().on("change", function (e) {});
			if(response.length > 0) {
				$('#gif').hide();
				$('#model_id_'+row_id).empty(); // clear the current elements in select box
				$('#model_id_'+row_id).append($('<option></option>').attr('value', '').text('Select Model'));
		       	for (row in response) {
		       		$('#model_id_'+row_id).append($('<option></option>').attr('value', response[row].model_id).text(response[row].model_name));
				}
				$("#model_id_" + row_id).select2().on("change", function (e) {});
         	}else{
				$('#gif').hide();
				$('#model_id_'+row_id).empty(); // clear the current elements in select box
				$('#model_id_'+row_id).append($('<option></option>').attr('value', '').text('Select Model'));
				$("#model_id_" + row_id).select2().on("change", function (e) {});
           	}
		});
	}

	function getvariantList(row_id){
		$('#gif').show();
		$.post("<?php echo site_url('user_cars/ajax/get_brand_model_variant'); ?>", {
			brand_id: $('#brand_id_'+row_id).val(),
			model_id: $('#model_id_'+row_id).val(),
			_mm_csrf: $('#_mm_csrf').val()
		},function (data) {
        	var response = JSON.parse(data);
           	if (response.length > 0) {
				$('#gif').hide();
          		$('#variant_id_'+row_id).empty(); // clear the current elements in select box
            	$('#variant_id_'+row_id).append($('<option></option>').attr('value', '').text('Select Variant'));
	        	for (row in response) {
	           		$('#variant_id_'+row_id).append($('<option></option>').attr('value', response[row].brand_model_variant_id).text(response[row].variant_name));
				}
				$("#variant_id_" + row_id).select2().on("change", function (e) {});
         	}else {
				$('#gif').hide();
				$('#variant_id_'+row_id).empty(); // clear the current elements in select box
            	$('#variant_id_'+row_id).append($('<option></option>').attr('value', '').text('Select variant'));
				$("#variant_id_" + row_id).select2().on("change", function (e) {});
            }
		});
	}

	function remove_product(id){
		$("#product_item_table #tr_"+id).remove();
		var renumpro = 1;
		$("#product_item_table tr .item_sno").each(function() {
			$(this).text(renumpro);
			renumpro++;
		});
	}

	function product_row_data(){

		var add_mathround = parseInt(new Date().getTime() + Math.random());

		var next_row_id = $("#product_item_table > tbody > tr").length;

		$('#new_product_row').clone().appendTo('#product_item_table').removeAttr('id').addClass('item').attr('id', 'tr_' + add_mathround).show();

		$('#tr_' + add_mathround + ' .item_sno').attr('id', "item_sno_" + add_mathround);

		$('#tr_' + add_mathround + ' .item_sno').empty().html(next_row_id);

		$('#tr_' + add_mathround + ' .service_map_id').attr('id', "service_map_id_" + add_mathround);

		$('#tr_' + add_mathround + ' .duplicate_service_map_id').attr('id', "duplicate_service_map_id_" + add_mathround);

		$('#tr_' + add_mathround + ' .brand_id').attr('id', "brand_id_" + add_mathround);

		$('#tr_' + add_mathround + ' .model_id').attr('id', "model_id_" + add_mathround);

		$('#tr_' + add_mathround + ' .variant_id').attr('id', "variant_id_" + add_mathround);

		$('#tr_' + add_mathround + ' .fuel_type').attr('id', "fuel_type_" + add_mathround);

		$('#tr_' + add_mathround + ' .year').attr('id', "year_" + add_mathround);

		$('#tr_' + add_mathround + ' .remove_added_item').attr('id' , "remove_added_item_" + add_mathround);

		$("#duplicate_subpro_id_"+add_mathround).val(add_mathround);
		
		$().ready(function () {

			$("#brand_id_" + add_mathround).select2().on("change", function (e) {
				getModelList(add_mathround);
			});

			$("#model_id_" + add_mathround).select2().on("change", function (e) {
				getvariantList(add_mathround);
			});

			$("#variant_id_" + add_mathround).select2().on("change", function (e) {
			});

			$("#fuel_type_" + add_mathround).select2().on("change", function (e) {
			});

			$("#year_" + add_mathround).select2().on("change", function (e) {
			});

			$("#remove_added_item_" + add_mathround).attr('onclick', 'remove_product("' + add_mathround + '")');
			
		});

		var renumpro = 1;
		$("#product_item_table tr .item_sno").each(function() {
			$(this).text(renumpro);
			renumpro++;
		});

	}
   

	$(document).ready(function() {

		$(".select2").select2();

		$("#btn_cancel").click(function() {
            window.location.href = "<?php echo site_url('mech_item_master/service_index'); ?>";
        });
		
		$('.summernote').summernote();

		$(".add_product").click(function () {
			var empty = '';
			product_row_data(empty);
		});

		$('.apply_for_all_bmv').on("click", function(e)
		{
			if($(this).val() == 'Y'){
				$("#parent_id").val(0);
				$(".modelandvariants").hide();
				$(".bodyType").hide();
				$(".genericBox").show();
			}else if($(this).val() == 'N'){
				$("#parent_id").val(1);
				$(".modelandvariants").show();
				$(".bodyType").hide();
				$(".genericBox").show();
			}else if($(this).val() == 'S'){
				$(".modelandvariants").hide();
				$(".bodyType").show();
				$(".genericBox").hide();
			}
		});

		$('#fill_gst').on("change", function(e)
		{
			if($("#fill_gst:checked").is(":checked")){
				$("#fill_gst").val('Y');
				$(".show_gst_box").show();
			}else{
				$("#fill_gst").val('N');
				$(".show_gst_box").hide();
			}
		});

		$("#tax_id").change(function(){
			if($(this).val() != '' || $(this).val() != null && $(this).val() != undefined){
				$.post('<?php echo site_url('mech_tax/ajax/gettaxDetails'); ?>', {
					tax_id : $(this).val(),
					_mm_csrf : $('#_mm_csrf').val()
				}, function (data) {
					list = JSON.parse(data);
					if(list.success=='1'){
						$("#sku").val(list.data[0].hsn_code?list.data[0].hsn_code:'');
						$("#tax_percentage").val(list.data[0].tax_value?list.data[0].tax_value:'');
					}
				});
			}else{
				$("#sku").val('');
				$("#tax_percentage").val('');
			}
		});
		
		$(".btn_submit").click(function () {
			
			
			var productCostPriceList = [];
			$('table#product_item_table tbody>tr.item').each(function() {
				var product_row = {};
				$(this).find('input,select,textarea').each(function() {
					if ($(this).is(':checkbox')) {
						product_row[$(this).attr('name')] = $(this).is(':checked');
					} else {
						product_row[$(this).attr('name')] = $(this).val();
					}
				});
				if(product_row){
					productCostPriceList.push(product_row);
				}
			});

			var serviceCostPriceList = [];
		
			$(".servicesCheckinListDatas .multi-field").each(function(){
				var requestObj = {};
				requestObj.sct_id = $(this).find(".sct_id").val();
				requestObj.mvt_id = $(this).find(".mvt_id").val();
				requestObj.default_cost = $(this).find(".default_cost").val();
				requestObj.vehicle_type_value = $(this).find(".vehicle_type_value").val();
				requestObj.estimated_hour = $(this).find(".estimated_hour").val();
				requestObj.estimated_cost = $(this).find(".estimated_cost").val();
				serviceCostPriceList.push(requestObj);
			});

			var validation = [];

			if($("#service_item_name").val() == ''){
				validation.push('service_item_name');
			}

			if($("#service_category_id").val() == ''){
				validation.push('service_category_id');
			}

			if($('input[name="apply_for_all_bmv"]:checked').val() == 'Y'){
				if($("#estimated_hour").val() == ''){
					validation.push('estimated_hour');
				}
				if($("#estimated_cost").val() == ''){
					validation.push('estimated_cost');
				}
			}else if($('input[name="apply_for_all_bmv"]:checked').val() == 'S'){
				if(serviceCostPriceList.length > 0){
					serviceCostPriceList.forEach(function(val) {
						if(val.estimated_hour == ''){
							$('#estimated_hour_'+val.sct_id).addClass("border_error");
							return false;
						}
						if(val.estimated_cost == ''){
							$('#estimated_cost_'+val.sct_id).addClass("border_error");
							return false;
						}
					});
				}
			}else if($('input[name="apply_for_all_bmv"]:checked').val() == 'N'){
				if($("#estimated_hour").val() == ''){
					validation.push('estimated_hour');
				}
				if($("#estimated_cost").val() == ''){
					validation.push('estimated_cost');
				}
				if(productCostPriceList.length > 0){
					productCostPriceList.forEach(function(val) {
						if(val.brand_id == '' || val.brand_id == 0){
							$('#brand_id_'+val.duplicate_service_map_id).addClass("border_error");
							validation.push('brand_concept');
						}
					});
				}
			}

			if($("#fill_gst").val() == 'Y'){
				if($("#tax_id").val() == ''){
					validation.push('tax_id');
				}
			}

			if(validation.length > 0){
				validation.forEach(function(val) {
					if(val == 'brand_concept'){
						notie.alert(3, 'Please choose brand', 2);
					}else{
						$('#'+val).addClass("border_error");
						$('#'+val).parent().addClass('has-error');
					}	
					$('#'+val).addClass("border_error");
					$('#'+val).parent().addClass('has-error');
					if($('#'+val+'_error').length == 0){
						$('#'+val).parent().addClass('has-error');
					} 
				});
				return false;
			}

			$('#gif').show();

			$.post('<?php echo site_url('mech_item_master/ajax/create_service'); ?>', {
				service_cost_setup : service_cost_setup,
                msim_id : $("#msim_id").val(),
                msipl_id : $("#msipl_id").val(),
				service_item_name : $('#service_item_name').val(),
				service_category_id : $('#service_category_id').val(),
				estimated_hour : $("#estimated_hour").val()?$("#estimated_hour").val():"",
                estimated_cost : $("#estimated_cost").val()?$("#estimated_cost").val():$("#default_estimated_cost").val(),
				apply_for_all_bmv: $('input[name="apply_for_all_bmv"]:checked').val()?$('input[name="apply_for_all_bmv"]:checked').val():'',
				fill_gst : $("#fill_gst").val()?$("#fill_gst").val():'N',
				tax_id : $('#tax_id').val()?$('#tax_id').val():"",
				sku : $("#sku").val()?$("#sku").val():"",
				tax_percentage: $("#tax_percentage").val()?$("#tax_percentage").val():"",
				kilo_from : $('#kilo_from').val()?$('#kilo_from').val():"",
				kilo_to : $('#kilo_to').val()?$('#kilo_to').val():'',
            	mon_from : $('#mon_from').val()?$('#mon_from').val():'',
            	mon_to : $('#mon_to').val()?$('#mon_to').val():'',
				complete_service_description : $("#complete_service_description").val()?$("#complete_service_description").val():'',
				productCostPriceList : JSON.stringify(productCostPriceList),
				serviceCostPriceList : JSON.stringify(serviceCostPriceList),
				action_from : 'S',
				btn_submit : $(this).val(),
				_mm_csrf : $('#_mm_csrf').val()
	        }, function (data) {
				list = JSON.parse(data);
	            if(list.success=='1'){
	                notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
					if(list.btn_submit == '1'){
						setTimeout(function(){
							window.location = "<?php echo site_url('mech_item_master/service_create'); ?>";
						}, 100);
					}else{
						setTimeout(function(){
							window.location = "<?php echo site_url('mech_item_master/service_index'); ?>/";
						}, 100);
					}
	            }else if(list.success == '2'){
					$('#gif').hide();
					notie.alert(3, '<?php _trans('toaster2'); ?>', 2);
					return false;
				}else if(list.success == '3'){
					$('#gif').hide();	
					notie.alert(3, '<?php _trans('err8'); ?>', 2);
				}else{
					$('#gif').hide();
					notie.alert(3, '<?php _trans('toaster2'); ?>', 2);
					$('.has-error').removeClass('has-error');
	                for (var key in list.validation_errors) {
	                    $('#' + key).parent().addClass('has-error');
	                    $('.error_msg_' + key).show().empty().html(list.validation_errors[key]);
	                }
	            }
	        });
		});	
	});
</script>