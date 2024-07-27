	<div>
		<select name="service_package_id" id="service_package_id" class="bootstrap-select bootstrap-select-arrow form-control removeError check_error_label" data-live-search="true" autocomplete="off">
			<option value=""><?php  _trans('label969'); ?></option>
			<?php if(count($service_package) > 0){
				foreach ($service_package as $key => $service_packages){ ?>
					<option value="<?php echo $service_packages->s_pack_id;?>" <?php if($service_packages->s_pack_id == $offer_details->service_package_id){ echo "selected";} ?> >
					<?php echo $service_packages->package_name; ?></option>
			<?php } } ?>
		</select>
	</div>