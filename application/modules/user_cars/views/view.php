<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3>View Car Detail</h3>
				</div>
				<!-- <div class="tbl-cell tbl-cell-action">
					<a href="javascript:void(0)" data-toggle="modal" data-model-from="car" data-target="#addNewCar" class="btn btn-rounded add_car">ADD A NEW CAR</a>
				</div> -->
			</div>
		</div>
	</div>
</header>
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12 top-15">
			<a class="anchor anchor-back" href="<?php echo site_url('clients/form').'/'.$customer_id.'/3'; ?>"><i class="fa fa-long-arrow-left"></i><span>Back to List</span></a>
		</div>
	</div>
	<div class="box-typical car-box-panel">
		<div class="row spacetop-10">
			<div class="col-xs-6"></div>
			<div class="col-xs-6 text-right">
				<a class="page-header-remove page-header-remove-mobile" onclick="remove_car(<?php echo $cars->car_list_id; ?>,<?php echo $customer_id; ?>, '<?=$this->security->get_csrf_hash(); ?>')" id="remove_car"><i class="fa fa-trash"></i></a>
			</div>
		</div>
		<div class="row">
			<?php $imagepath =  FCPATH.'uploads/car_images/models/'.$cars->model_image; ?>
			<div class="col-sm-4">
				<div class="car-image-box">
					<?php if($cars->model_image && file_exists($imagepath)){ ?>
					<img src="<?php echo base_url(); ?>uploads/car_images/models/<?php echo $cars->model_image; ?>">
					<?php } else { ?>
					<img alt="car" src="<?php echo base_url(); ?>assets/mp_backend/img/dummycarimage.svg">
					<?php } ?>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="car-details-box">
					<div class="car-reg-no-box"><?php echo ($cars->car_reg_no?$cars->car_reg_no:"-"); ?></div>
					<h3 class="car-name-box"><?php echo ($cars->brand_name?$cars->brand_name:"-").' '.($cars->model_name?$cars->model_name:"-").' '.($cars->variant_name?$cars->variant_name:"-"); ?></h3>
					<table class="car-table-box">
						<tbody>
							<tr>
								<th>Year</th><td><?php echo ($cars->car_model_year?$cars->car_model_year:"-"); ?></td>
							</tr>
							<tr>
								<th>Fuel Type</th><td><?php if ($cars->fuel_type == 'P') {
									echo 'Petrol';
								} elseif ($cars->fuel_type == 'D') {
									echo 'Diesel';
								} elseif ($cars->fuel_type == 'G') {
									echo 'Gas';
								} else {
									echo '-';
								}?></td>
							</tr>
							<tr>
								<th>Recommended services</th><td>0</td>
							</tr>
							<tr>
								<th>Total mileage</th><td><?php echo ($cars->total_mileage?$cars->total_mileage:"-"); ?></td>
							</tr>
							<tr>
								<th>Daily average mileage</th><td><?php echo ($cars->daily_mileage?$cars->daily_mileage:"-"); ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="car-details-box">
					<h3 class="car-name-box">Recent Service</h3>
					<table class="car-table-box">
						<tbody>
							<tr>
								<th>Date</th><td>10-12-2016</td>
							</tr>
							<tr>
								<th>mileage</th><td>123456</td>
							</tr>
							<tr>
								<th>Rating</th><td>15,939</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<section class="tabs-section">
		<div class="tabs-section-nav tabs-section-nav-inline">
			<ul class="nav" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" href="#tabs-4-tab-1" role="tab" data-toggle="tab">
						VECHICLE DETAILS
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#tabs-4-tab-2" role="tab" data-toggle="tab">
						SERVICE HISTORY
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#tabs-4-tab-3" role="tab" data-toggle="tab">
						SCHEDULED MAINTENANCE
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#tabs-4-tab-4" role="tab" data-toggle="tab">
						RECOMMENDED SERVICE & PRODUCTS
					</a>
				</li>
			</ul>
		</div><!--.tabs-section-nav-->

				<div class="tab-content">
					<div role="tabpanel" class="tab-pane fade in active" id="tabs-4-tab-1">
						<div class="box-typical car-box-panel">
							<form method="post" name="car_extra_information">
								<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
							<div class="row spacetop-20">
								<div class="col-xs-12">
									<div class="alert alert-info">
									Please fill out the information below. The more information you provide, the faster we'll be able to create your custom quotes.
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group row">
										<label class="col-sm-6 form-control-label spacetop-15">Current Mileage</label>
										<div class="col-sm-6">
										<p class="form-control-static"><input type="text" class="form-control" name="total_mileage" id="total_mileage" value="<?php echo $cars->total_mileage; ?>"></p>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-6 form-control-label spacetop-15">VIN</label>
										<div class="col-sm-6">
										<p class="form-control-static"><input type="text" class="form-control" name="vin" id="vin" value="<?php echo $cars->vin; ?>"></p>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-6 form-control-label spacetop-15">What type of engine oil do you use?</label>
										<div class="col-sm-6">
										<p class="form-control-static">
											<select name="engine_oil_type" id="engine_oil_type" class="form-control">
												<option value="">Select Engine Oil Type</option>
												<?php foreach ($engine_oil_types as $eot) {
    if ($eot->eng_oil_type_id == $cars->engine_oil_type) {
        $eot_selected = 'selected="selected"';
    } else {
        $eot_selected = '';
    } ?>
													<option value="<?php echo $eot->eng_oil_type_id; ?>" <?php echo $eot_selected; ?>><?php echo $eot->name; ?></option>
												<?php
} ?>
											</select>
										</p>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-6 form-control-label spacetop-15">Fuel Type</label>
										<div class="col-sm-6">
										<p class="form-control-static">
											<select name="fuel_type" id="fuel_type" class="form-control">
												<option value="P" <?php if ($cars->fuel_type == 'P') {
        echo 'selected="selected"';
    } ?>>Petrol</option>
												<option value="D" <?php if ($cars->fuel_type == 'D') {
        echo 'selected="selected"';
    } ?>>Diesel</option>
												<option value="G" <?php if ($cars->fuel_type == 'G') {
        echo 'selected="selected"';
    } ?>>Gas</option>
											</select>
										</p>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-6 form-control-label spacetop-15">What is your steering type?</label>
										<div class="col-sm-6">
										<p class="form-control-static">
											<select name="steering_type" id="steering_type" class="form-control">
												<option value="1" <?php if ($cars->steering_type == 1) {
        echo 'selected="selected"';
    } ?>>Power Steering</option>
												<option value="2" <?php if ($cars->steering_type == 2) {
        echo 'selected="selected"';
    } ?>>Manual Steering</option>
											</select>
										</p>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group row">
										<label class="col-sm-6 form-control-label spacetop-15">Daily Mileage</label>
										<div class="col-sm-6">
										<p class="form-control-static"><input type="text" class="form-control" name="daily_mileage" id="daily_mileage" value="<?php echo $cars->daily_mileage; ?>"></p>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-6 form-control-label spacetop-15">Does your vechicle have air conditioning?</label>
										<div class="col-sm-6">
										<p class="form-control-static">
											<select name="air_conditioning" id="air_conditioning" class="form-control">
												<option>Vechicle Have Air Conditioning?</option>
												<option value="yes" <?php if ($cars->air_conditioning == 'yes') {
        echo 'selected="selected"';
    } ?>>Yes</option>
												<option value="no" <?php if ($cars->air_conditioning == 'no') {
        echo 'selected="selected"';
    } ?>>no</option>
											</select>
										</p>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-6 form-control-label spacetop-15">What type of drive does your vechicle have?</label>
										<div class="col-sm-6">
										<p class="form-control-static">
											<select name="car_drive_type" id="car_drive_type" class="form-control">
												<option value="">Select Drive Type</option>
												<?php foreach ($drive_types as $dt) {
        if ($dt->drive_type_id == $cars->car_drive_type) {
            $dt_selected = 'selected="selected"';
        } else {
            $dt_selected = '';
        } ?>
													<option value="<?php echo $dt->drive_type_id; ?>" <?php echo $dt_selected; ?>><?php echo $dt->name; ?></option>
												<?php
    } ?>
											</select>
										</p>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-6 form-control-label spacetop-15">What is your transmission type?</label>
										<div class="col-sm-6">
										<p class="form-control-static">
											<select name="transmission_type" id="transmission_type" class="form-control">
												<option value="">Select Transmission Type</option>
												<option value="A" <?php if ($cars->transmission_type == 'A') {
        echo 'selected="selected"';
    } ?>>Automatic</option>
												<option value="M" <?php if ($cars->transmission_type == 'M') {
        echo 'selected="selected"';
    } ?>>Manual</option>
											</select>
										</p>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12 text-right"><button type="button" id="update_car_information" class="btn btn-rounded btn-inline btn-primary">UPDATE</button></div>
							</div>
							</form>
						</div>
					</div><!--.tab-pane-->
					<div role="tabpanel" class="tab-pane fade" id="tabs-4-tab-2">
						<div class="box-typical car-box-panel">
							<?php foreach($user_service_history as $userServiceHistory){ ?>
							<div class="row">
								<div class="col-sm-12">
									<table class="col-sm-12" style="table-layout:fixed;">
										<thead>
											<tr>
												<th>DATE</th>
												<th>SERVICE TYPE</th>
												<th>MILEAGE</th>
												<th>SERVICE PROVIDER</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><?php if($userServiceHistory->invoice_date){ echo date_from_mysql($userServiceHistory->invoice_date);} ?></td>
												<td>Dealer</td>
												<td>53,000</td>
												<td><?php if($userServiceHistory->workshop_name){ echo $userServiceHistory->workshop_name; } ?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<h4 class="paddingTop20px" >Description</h4>
									<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 padding0px">
										<p>Repair Order Number <?php if($userServiceHistory->invoice_no){ echo $userServiceHistory->invoice_no; } ?><p>
										<div><?php if(count($userServiceHistory->invoice_items)>0){
											foreach($userServiceHistory->invoice_items as $invoiceItemsList){
												echo "<span>".$invoiceItemsList->service_item_name.",</span>";
										} } ?></div>
									</div>
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
										<a class="float_right pull-right" href="<?php echo site_url('mech_invoices/generate_pdf/'.$userServiceHistory->invoice_id); ?>"><img src="<?php echo base_url(); ?>assets/mp_backend/img/pdf.png" width="25" height="25" >Download Details</a>
									</div>
								</div>
							</div>
							<hr>
							<?php } ?>
						</div>
					</div><!--.tab-pane-->
					<div role="tabpanel" class="tab-pane fade" id="tabs-4-tab-3">In-Progress...</div><!--.tab-pane-->
					<div role="tabpanel" class="tab-pane fade" id="tabs-4-tab-4">
						<section class="card">
            				<div class="card-block">
							<table class="display table datatable table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th><?php _trans('lable853'); ?></th>
										<th class="text_align_center"><?php _trans('lable860'); ?></th>
										<th class="text_align_center"><?php _trans('Type'); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php if(count($pro_rec_his) > 0) { foreach ($pro_rec_his as $pro_list) { ?>
									<tr>
										<td><?php _htmlsc($pro_list->product_name); ?></td>
										<td class="text_align_center"><?php _htmlsc($pro_list->days); ?></td>
										<td class="text_align_center"><?php _htmlsc($pro_list->service_status); ?></td>
									</tr>
									<?php  } } else { echo '<tr><td colspan="3" class="text-center" > No data found </td></tr>'; } ?>
								</tbody>
							</table>
							<table class="display table datatable table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th><?php _trans('lable395'); ?></th>
										<th class="text_align_center"><?php _trans('lable860'); ?></th>
										<th class="text_align_center"><?php _trans('Type'); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php if(count($ser_rec_his) > 0) { foreach ($ser_rec_his as $ser_list) { ?>
									<tr>
										<td><?php _htmlsc($ser_list->service_item_name); ?></td>
										<td class="text_align_center"><?php _htmlsc($ser_list->days); ?></td>
										<td class="text_align_center"><?php _htmlsc($ser_list->service_status); ?></td>
									</tr>
									<?php  } } else { echo '<tr><td colspan="3" class="text-center" > No data found </td></tr>'; } ?>
								</tbody>
							</table>
							</div>
						</section>
					</div><!--.tab-pane-->
				</div><!--.tab-content-->
			</section>
</div><!--.container-fluid-->
<script type="text/javascript">
$(function () {
	$('#update_car_information').click(function () {
            $.post("<?php echo site_url('user_cars/ajax/update_car_details'); ?>", {
                    user_car_id: <?php echo $cars->car_list_id; ?>,
                    total_mileage: $('#total_mileage').val(),
                    daily_mileage: $('#daily_mileage').val(),
                    engine_oil_type: $('#engine_oil_type').val(),
                    vin: $('#vin').val(),
                    steering_type: $('#steering_type').val(),
                    fuel_type: $('#fuel_type').val(),
                    car_drive_type: $('#car_drive_type').val(),
                    air_conditioning: $('#air_conditioning').val(),
                    transmission_type: $('#transmission_type').val(),
                    _mm_csrf: $('#_mm_csrf').val()
                },
                function (data) {
                    var response = JSON.parse(data);
                    
                   if(response.success === 1){
        				notie.alert(1, 'Success!', 2);
                    }else{
                    	notie.alert(3, 'Error.', 2);
                    }
                });
        });
        
        });
	
</script>