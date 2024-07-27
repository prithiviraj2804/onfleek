<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3>My Cars <small class="text-muted">( <?php echo count($cars_list); ?> )</small></h3>
				</div>
				<div class="tbl-cell tbl-cell-action">
					<a href="javascript:void(0)" data-toggle="modal" data-model-from="car" data-target="#addNewCar" class="btn btn-rounded add_car">ADD A NEW CAR</a>
				</div>
			</div>
		</div>
	</div>
</header>
<div class="container-fluid">
	<?php foreach ($cars_list as $cars) {  ?>
	<div class="box-typical car-box-panel">
		<div class="row">
			<div class="col-sm-4">
				<div class="car-image-box">
					<img src="<?php echo base_url(); ?>uploads/car_images/models/<?php echo $cars->model_image; ?>">
				</div>
				<div class="button stroke-button block-button car-details-button">
					<a href="<?php echo site_url('user_cars/view/').$cars->car_list_id; ?>">View car information</a>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="car-details-box">
					<div class="car-reg-no-box"><?php echo $cars->car_reg_no; ?></div>
					<h3 class="car-name-box"><?php echo $cars->brand_name." ".$cars->model_name." ".$cars->variant_name;  ?></h3>
					<table class="car-table-box">
						<tbody>
							<tr>
								<th>Year</th><td><?php echo $cars->car_model_year; ?></td>
							</tr>
							<tr>
								<th>Fuel Type</th><td><?php if($cars->fuel_type=='p'){ echo "Petrol"; }elseif($cars->fuel_type=='d'){ echo "Diesel"; } ?></td>
							</tr>
							<tr>
								<th>Recommended services</th><td>0</td>
							</tr>
							<tr>
								<th>Total mileage</th><td><?php echo $cars->total_mileage; ?></td>
							</tr>
							<tr>
								<th>Daily average mileage</th><td><?php echo $cars->daily_mileage; ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
</div>