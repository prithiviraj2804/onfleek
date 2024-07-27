<?php
$location = "";
$service = "";
$appointment = "";
if($current_tab){
if($current_tab == "location"){
	$location = "active";
}elseif($current_tab == "service"){
	$service = "active";
}elseif($current_tab == "appointment"){
	$appointment = "active";
}
}else{
	$location = "active";
}
?>
<header class="box-typical-header box-typical-header-bordered">
					<div class="tbl-row">
						<div class="tbl-cell tbl-cell-title">
							<ul class="contacts-tabs" role="tablist">
								<li class="nav-item">
									<a href="#car_location_tab_content" id="car_location_tab" role="tab" data-toggle="tab" class="<?php echo $location; ?>">Customer &amp; Vehicle</a>
								</li>
								<li class="nav-item" id="service_tab_li">
									<a href="javascript:void(0)" id="service_tab" role="tab" class="<?php echo $service; ?>"><?php _trans('services');?>Services</a>
								</li>
								<li class="nav-item" id="appointment_tab_li">
									<a href="javascript:void(0)" id="appointment_tab" role="tab" class="<?php echo $appointment; ?>"><?php _trans('appointment_time');?></a>
								</li>
							</ul>
						</div>
						<div class="tbl-cell tbl-cell-actions">
							<button type="button" class="action-btn action-btn-expand">
								<i class="font-icon font-icon-expand"></i>
							</button>
						</div>
					</div>
				</header>