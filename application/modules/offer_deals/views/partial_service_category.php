<div style="padding-bottom: 15px;">
	<select name="service_category_id" id="service_category_id" class="bootstrap-select bootstrap-select-arrow form-control removeError check_error_label" data-live-search="true" autocomplete="off">
		<option value=""><?php  _trans('lable252'); ?></option>
		<?php if(count($service_category_lists) > 0){
			foreach ($service_category_lists as $key => $service_category){ ?>
				<option value="<?php echo $service_category->service_cat_id;?>" <?php if($service_category->service_cat_id == $offer_details->service_category_id){ echo "selected";} ?> >
				<?php echo $service_category->category_name; ?></option>
		<?php } } ?>
	</select>
</div>	