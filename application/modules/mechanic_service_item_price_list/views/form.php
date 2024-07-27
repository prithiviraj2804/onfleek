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
					<a class="btn btn-sm btn-primary" href="<?php echo site_url('mechanic_service_item_price_list/form'); ?>">
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
			<a class="anchor anchor-back" onclick="goBack()" href="#"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
		</div>
        <div class="col-xl-12 col-xl-offset-3 col-lg-12 col-lg-offset-3 col-md-12 col-md-offset-3 col-sm-12 col-12">
			<div class="container">
            	<input class="hidden" name="is_update" type="hidden" <?php if($this->mdl_mech_service_item_dtls->form_value('is_update')){echo 'value="1"';} else {echo 'value="0"';}?> >
                <input class="hidden" id="msim_id" name="msim_id" type="hidden" value="<?php echo $this->mdl_mech_service_item_dtls->form_value('msim_id', true)?>" >
				<div class="box">
					<div class="box_body">
						<div class="row">
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
								<div class="form_group">
									<label class="form_label"><?php _trans('lable253'); ?>*</label>
									<div class="form_controls">
										<input type="text" name="service_item_name" id="service_item_name" class="form-control" value="<?php echo $this->mdl_mech_service_item_dtls->form_value('service_item_name', true); ?>">
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
								<div class="form_group">
									<label class="form_label"><?php  _trans('lable239'); ?> *</label>
									<div class="form_controls">
										<select name="service_category_id" id="service_category_id" class="bootstrap-select bootstrap-select-arrow form-control removeError check_error_label" data-live-search="true" autocomplete="off">
											<option value=""><?php  _trans('lable252'); ?></option>
											<?php $service_category_id = $this->mdl_mech_service_item_dtls->form_value('service_category_id', true);
											if($service_category_lists):
											foreach ($service_category_lists as $key => $service_category): ?>
											<option value="<?php echo $service_category->service_cat_id; ?>" <?php if ($service_category->service_cat_id == $service_category_id) {
												echo 'selected';
											} ?>> <?php echo $service_category->category_name; ?></option>
											<?php endforeach;
											endif;
											?>
										</select>
									</div>	
								</div>
							</div>
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
								<div class="form_group">
									<label class="form_label"><?php _trans('lable211'); ?></label>
									<div class="form_controls">
										<input type="text" name="sku" id="sku" class="form-control" value="<?php echo $this->mdl_mech_service_item_dtls->form_value('sku', true); ?>">
									</div>
								</div>
							</div>
						</div>
						<?php if($this->session->userdata('service_cost_setup') == 1){ ?>
						<div class="row">
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
						<?php } else{ ?>
						<div class="row table-details">
							<div class="col-lg-12">
								<section class="box-typical">
									<div class="box-typical-body">
										<div class="table-responsive">
											<table class="display table table-bordered" id="product_item_table" width="100%" style="width:100%;float:left;table-layout: fixed;">
												<thead>
													<th width="5%" style="max-width:5%;width:5%;" class="text-center"><?php _trans('lable346'); ?></th>
													<th width="18%" style="max-width:18%;width:18%;"><?php _trans('lable229'); ?></th>
													<th width="18%" style="max-width:18%;width:18%;"><?php _trans('lable231'); ?></th>
													<th width="18%" style="max-width:18%;width:18%;"><?php _trans('lable263'); ?></th>
													<th width="18%" style="max-width:18%;width:18%;"><?php _trans('lable132'); ?></th>
													<th width="18%" style="max-width:18%;width:18%;" class="text-center"><?php _trans('lable878'); ?><br>(hr)</th>
													<th width="18%" style="max-width:18%;width:18%;" class="text-right"><?php _trans('lable879'); ?></th>
													<th width="5%" style="max-width:5%;width:5%;"></th>
												</thead>
												<tbody>
												<?php if(count($service_bmv_type_details) > 0) { $i = 1;
												foreach ($service_bmv_type_details as $product) {  ?>
													<tr class="item" id="tr_<?php echo $product->pct_id; ?>">
														<input type="hidden" name="pct_id" value="<?php echo $product->pct_id; ?>">
														<td width="5%" style="max-width:5%;width:5%;" class="item_sno text-center"><?php echo $i; $i++; ?>
														</td>
														<td width="18%" style="max-width:18%;width:18%;">
															<select name="brand_id" class="brand_id select2" id="brand_id_<?php echo $product->pct_id; ?>" onchange="getModelList(<?php echo $product->pct_id; ?>)">
																<option value="0"><?php  _trans('lable229'); ?></option>
																<?php if(!empty($car_brand_list)){
																foreach($car_brand_list as $brand_list){ ?>
																	<option value="<?php echo $brand_list->brand_id; ?>" <?php if($product->brand_id == $brand_list->brand_id){ echo "selected"; } ?> ><?php echo $brand_list->brand_name; ?></option>
																<?php } } ?>
															</select>
														</td>
														<td width="18%" style="max-width:18%;width:18%;">
															<select name="model_id" class="model_id select2" id="model_id_<?php echo $product->pct_id;?>" onchange="getvariantList(<?php echo $product->pct_id; ?>)">
																<option value=""><?php  _trans('lable231'); ?></option>
																<?php if(!empty($car_model_list)){
																	foreach ($car_model_list as $model_list){ ?>
																	<option value="<?php echo $model_list->model_id; ?>" <?php if($product->model_id == $model_list->model_id){ echo "selected"; } ?> ><?php echo $model_list->model_name;?></option>
																<?php }}?>
															</select>
														</td>
														<td width="18%" style="max-width:18%;width:18%;">
															<select name="variant_id" class="variant_id select2" id="variant_id_<?php echo $product->pct_id;?>">
																<option value=""><?php  _trans('lable264'); ?></option>
																<?php if ($car_variant_list){
																foreach ($car_variant_list as $names){ ?>
																<option value="<?php echo $names->brand_model_variant_id; ?>" <?php if($product->variant_id == $names->brand_model_variant_id){ echo "selected"; } ?>><?php echo $names->variant_name; ?></option>
																<?php } } ?>
															</select>
														</td>
														<td width="18%" style="max-width:18%;width:18%;">
															<select name="fuel_type" class="fuel_type select2" id="fuel_type_<?php echo $product->pct_id; ?>">
																<option value=""></option>
																<option value="P" <?php if($product->fuel_type == "P"){ echo "selected"; } ?>>Petrol</option>
																<option value="D" <?php if($product->fuel_type == "D"){ echo "selected"; } ?>>Diesel</option>
																<option value="G" <?php if($product->fuel_type == "G"){ echo "selected"; } ?>>CNG</option>
															</select>
														</td>
														<td width="18%" style="max-width:18%;width:18%;">
															<input type="text" name="estimated_hour" id="estimated_hour_<?php echo $product->pct_id; ?>" class="estimated_hour text-center form-control" value="<?php echo $product->estimated_hour;?>">
														</td>
														<td width="18%" style="max-width:18%;width:18%;">
															<input type="text" name="estimated_cost" id="estimated_cost_<?php echo $product->pct_id; ?>" class="estimated_cost form-control text_align_right twodigit" value="<?php echo $product->estimated_cost;?>">
														</td>
														<td width="5%" style="max-width:5%;width:5%;">
															<span onclick="remove_sub_item(<?php echo $product->pct_id; ?>,'mechanic_service_item_price_list','deleteServiceBmv','<?= $this->security->get_csrf_hash(); ?>');"><i class="fa fa-times"></i></span>
														</td>
													</tr>
													<?php } } ?>
												</tbody>
												<tfoot class="product_total_calculations">
													<td colspan="8"><button class="btn add_product"><?php _trans('lable409'); ?></button></td>
												</tfoot>
											</table>
											<table style="display: none;">
												<tr id="new_product_row" style="display: none;">
													<input type="hidden" name="pct_id" class="pct_id">
													<td width="5%" style="max-width:5%;width:5%;" class="item_sno text-center">1</td>
													<td width="18%" style="max-width:18%;width:18%;">
														<select name="brand_id" class="brand_id">
															<option value="0"><?php  _trans('lable73'); ?></option>
															<?php if(!empty($car_brand_list)){
															foreach($car_brand_list as $brand_list){ ?>
																<option value="<?php echo $brand_list->brand_id; ?>"><?php echo $brand_list->brand_name; ?></option>
															<?php } } ?>
														</select>
													</td>
													<td width="18%" style="max-width:18%;width:18%;">
														<select name="model_id" class="model_id">
															<option value="0"><?php  _trans('lable74'); ?></option>
															<?php if(!empty($car_model_list)){
																foreach ($car_model_list as $model_list){ ?>
																<option value="<?php echo $model_list->model_id; ?>"><?php echo $model_list->model_name;?></option>
															<?php }}?>
														</select>
													</td>
													<td width="18%" style="max-width:18%;width:18%;">
														<select name="variant_id" class="variant_id">
															<option value="0"><?php  _trans('lable75'); ?></option>
															<?php if ($car_variant_list){
															foreach ($car_variant_list as $names){ ?>
															<option value="<?php echo $names->brand_model_variant_id; ?>"><?php echo $names->variant_name; ?></option>
															<?php } } ?>
														</select>
													</td>
													<td width="18%" style="max-width:18%;width:18%;">
														<select name="fuel_type" class="fuel_type">
															<option value="P">Petrol</option>
															<option value="D">Diesel</option>
															<option value="G">CNG</option>
														</select>
													</td>
													<td width="18%" style="max-width:18%;width:18%;">
														<input type="text" name="estimated_hour" class="estimated_hour form-control text-center">
													</td>
													<td width="18%" style="max-width:18%;width:18%;">
														<input type="text" name="estimated_cost" class="estimated_cost form-control text_align_right twodigit">
													</td>
													<td width="5%" style="max-width:5%;width:5%;" class="text-center">
														<span class="remove_added_item"><i class="fa fa-times"></i></span>
													</td>
												</tr>
											</table>
										</div>
									</div>
								</section>
							</div>
						</div> 					
						<?php } ?>
						<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 paddingTop20px">
								<h6 class="margin-bottom-0px">Expires in Month / Kilometer</h6>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 padding0px">
								<div class="col-xs-6 col-md-6">
									<div class="form_group">
										<label class="form_label"> <?php _trans('lable175'); ?></label>
										<div class="form_controls">
											<input type="text" name="mon_from" id="mon_from" onkeypress="return isNumberKey(event)" class="form-control" value="<?php echo $this->mdl_mech_service_item_dtls->form_value('mon_from', true); ?>">
										</div>
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 ">
									<div class="form_group">
										<label class="form_label"> <?php _trans('lable176'); ?></label>
										<div class="form_controls">
											<input type="text" name="mon_to" id="mon_to" onkeypress="return isNumberKey(event)" class="form-control" value="<?php echo $this->mdl_mech_service_item_dtls->form_value('mon_to', true); ?>">
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12  padding0px">
								<div class="col-xs-6 col-md-6">
									<div class="form_group">
										<label class="form_label"> <?php _trans('lable175'); ?></label>
										<div class="form_controls">
											<input type="text" name="kilo_from" id="kilo_from" onkeypress="return isNumberKey(event)" class="form-control" value="<?php echo $this->mdl_mech_service_item_dtls->form_value('kilo_from', true); ?>">
										</div>
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 ">
									<div class="form_group">
										<label class="form_label"> <?php _trans('lable176'); ?></label>
										<div class="form_controls">
											<input type="text" name="kilo_to" id="kilo_to" onkeypress="return isNumberKey(event)" class="form-control" value="<?php echo $this->mdl_mech_service_item_dtls->form_value('kilo_to', true); ?>">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form_group">
							<label class="form_label"><?php  _trans('lable177'); ?></label>
							<div class="form_controls">
								<div class="summernote-theme-1">
									<textarea name="complete_service_description" id="complete_service_description" class="summernote" name="name"><?php echo $this->mdl_mech_service_item_dtls->form_value('complete_service_description', true); ?></textarea>
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

	function costHourBasedCalculation(id){
		var row_id = "model_row_"+id;
		var mvt_id = ($("#" + row_id + " input[name=mvt_id]").val()) ? $("#" + row_id + " input[name=mvt_id]").val() : 0;
		var default_cost = ($("#" + row_id + " input[name=default_cost]").val()) ? $("#" + row_id + " input[name=default_cost]").val() : 0;
		var estimated_hour = ($("#" + row_id + " input[name=estimated_hour]").val()) ? $("#" + row_id + " input[name=estimated_hour]").val() : 0;
		var estimated_cost = ($("#" + row_id + " input[name=estimated_cost]").val()) ? $("#" + row_id + " input[name=estimated_cost]").val() : 0;
		var latestCost = default_cost * estimated_hour;
		$("#" + row_id + " input[name=estimated_cost]").val(latestCost.toFixed(2));
	}

	function getModelList(row_id){
		$.post("<?php echo site_url('user_cars/ajax/get_brand_models'); ?>", {
			brand_id: $('#brand_id_'+row_id).val(),
			_mm_csrf: $('#_mm_csrf').val()
		},function (data) {
			var response = JSON.parse(data);
			$('#variant_id_'+row_id).empty();
			$('#variant_id_'+row_id).append($('<option></option>').attr('value', '').text('Select Variant'));
			$("#variant_id_"+row_id).select2().on("change", function (e) {});
			if(response.length > 0) {
				$('#model_id_'+row_id).empty(); // clear the current elements in select box
				$('#model_id_'+row_id).append($('<option></option>').attr('value', '').text('Select Model'));
		       	for (row in response) {
		       		$('#model_id_'+row_id).append($('<option></option>').attr('value', response[row].model_id).text(response[row].model_name));
				}
				$("#model_id_" + row_id).select2().on("change", function (e) {});
         	}else{
             	console.log("No Data Found");
           	}
		});
	}

	function getvariantList(row_id){
		$.post("<?php echo site_url('user_cars/ajax/get_brand_model_variant'); ?>", {
			brand_id: $('#brand_id_'+row_id).val(),
			model_id: $('#model_id_'+row_id).val(),
			_mm_csrf: $('#_mm_csrf').val()
		},function (data) {
        	var response = JSON.parse(data);
           	if (response.length > 0) {
          		$('#variant_id_'+row_id).empty(); // clear the current elements in select box
            	$('#variant_id_'+row_id).append($('<option></option>').attr('value', '').text('Select Variant'));
	        	for (row in response) {
	           		$('#variant_id_'+row_id).append($('<option></option>').attr('value', response[row].brand_model_variant_id).text(response[row].variant_name));
				}
				$("#variant_id_" + row_id).select2().on("change", function (e) {});
         	}else {
             	console.log("No data found");
            }
		});
	}

	function remove_service(row_id){

		console.log("i amejh");

		$("#product_item_table #tr_"+row_id).remove();

		var renumser = 1;
		$("#product_item_table tr td.item_sno").each(function() {
			$(this).text(renumser);
			renumser++;
		});

	}

	function product_row_data(){

		var add_mathround = parseInt(new Date().getTime() + Math.random());

		var next_row_id = $("#product_item_table > tbody > tr").length;

		$('#new_product_row').clone().appendTo('#product_item_table').removeAttr('id').addClass('item').attr('id', 'tr_' + add_mathround).show();

		$('#tr_' + add_mathround + ' .item_sno').attr('id', "item_sno_" + add_mathround);

		$('#tr_' + add_mathround + ' .item_sno').empty().html(next_row_id);

		$('#tr_' + add_mathround + ' .brand_id').attr('id', "brand_id_" + add_mathround);

		$('#tr_' + add_mathround + ' .model_id').attr('id', "model_id_" + add_mathround);

		$('#tr_' + add_mathround + ' .variant_id').attr('id', "variant_id_" + add_mathround);

		$('#tr_' + add_mathround + ' .fuel_type').attr('id', "fuel_type_" + add_mathround);

		$('#tr_' + add_mathround + ' .estimated_hour').attr('id', "estimated_hour_" + add_mathround);

		$('#tr_' + add_mathround + ' .estimated_hour').attr('id', "estimated_cost_" + add_mathround);

		$('#tr_' + add_mathround + ' .remove_added_item').attr('onclick', 'remove_service("'+add_mathround+'")');

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
			
		});

		var renumser = 1;
		$("#product_item_table tr td.item_sno").each(function() {
			$(this).text(renumser);
			renumser++;
		});

	}

	$(document).ready(function() {

		$(".select2").select2();

		$("#btn_cancel").click(function() {
            window.location.href = "<?php echo site_url('mechanic_service_item_price_list'); ?>";
        });
		
		$('.summernote').summernote();

		$(".add_product").click(function () {
			var empty = '';
			product_row_data(empty);
		});

		$(".btn_submit").click(function () {			
			var validation = [];

			if($("#service_item_name").val() == ''){
				validation.push('service_item_name');
			}

			if($("#service_category_id").val() == ''){
				validation.push('service_category_id');
			}

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

			if(service_cost_setup == 1){
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
			}else if(service_cost_setup == 2){
				if(productCostPriceList.length > 0){
					productCostPriceList.forEach(function(val) {
						if(val.brand_id == ''){
							$('#brand_id_'+val.pct_id).addClass("border_error");
							return false;
						}
						if(val.model_id == ''){
							$('#model_id_'+val.pct_id).addClass("border_error");
							return false;
						}
						if(val.estimated_hour == ''){
							$('#estimated_hour_'+val.pct_id).addClass("border_error");
							return false;
						}
						if(val.estimated_cost == ''){
							$('#estimated_cost_'+val.pct_id).addClass("border_error");
							return false;
						}
					});
				}
			}

			if(validation.length > 0){
				validation.forEach(function(val) {
					$('#'+val).addClass("border_error");
					$('#'+val).parent().addClass('has-error');
					if($('#'+val+'_error').length == 0){
						$('#'+val).parent().addClass('has-error');
					} 
				});
				return false;
			}

			$('#gif').show();

			$.post('<?php echo site_url('mechanic_service_item_price_list/ajax/create'); ?>', {
				msim_id : $("#msim_id").val(),
				service_item_name : $('#service_item_name').val(),
				service_category_id : $('#service_category_id').val(),
				sku : $("#sku").val()?$("#sku").val():"",
				service_cost_setup : service_cost_setup,
				serviceCostPriceList : JSON.stringify(serviceCostPriceList),
				productCostPriceList : JSON.stringify(productCostPriceList),
				kilo_from : $('#kilo_from').val()?$('#kilo_from').val():"",
				kilo_to : $('#kilo_to').val()?$('#kilo_to').val():'',
            	mon_from : $('#mon_from').val()?$('#mon_from').val():'',
            	mon_to : $('#mon_to').val()?$('#mon_to').val():'',
	            complete_service_description : $("#complete_service_description").val()?$("#complete_service_description").val():'',
				action_from : 'S',
				btn_submit : $(this).val(),
				_mm_csrf : $('#_mm_csrf').val()
	        }, function (data) {
				list = JSON.parse(data);
	            if(list.success=='1'){
	                notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
					if(list.btn_submit == '1'){
						setTimeout(function(){
							window.location = "<?php echo site_url('mechanic_service_item_price_list/form'); ?>";
						}, 100);
					}else{
						setTimeout(function(){
							window.location = "<?php echo site_url('mechanic_service_item_price_list'); ?>/";
						}, 100);
					}
	            }else if(list.success == '2'){
					$('#gif').hide();
					notie.alert(3, '<?php _trans('toaster2'); ?>', 2);
					return false;
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