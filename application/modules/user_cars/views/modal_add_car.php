<input type="hidden" name="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>"autocomplete="off">
<script type="text/javascript">
    $(function () {
        // Display the create quote modal
        $('#addNewCar').modal('show');
        $(".bootstrap-select").selectpicker("refresh");
        var model_from = "<?php echo $model_from; ?>";
        var customer_id = "<?php echo $customer_id; ?>";
        var car_id = "<?php echo $car_id; ?>";
		var entity_type = "<?php echo $entity_type;?>";

         $('#popup_car_brand_id').change(function () {
			$('#gif').show();
            $.post("<?php echo site_url('user_cars/ajax/get_brand_models'); ?>", {
				brand_id: $('#popup_car_brand_id').val(),
				_mm_csrf: $('input[name="_mm_csrf"]').val()
			},
			function (data) {
				var response = JSON.parse(data);
				if (response.length > 0) {
					$('#gif').hide();
					$('#popup_car_brand_model_id').empty(); // clear the current elements in select box
					$('#popup_car_brand_model_id').append($('<option></option>').attr('value', '').text('Model'));
					for (row in response) {
						$('#popup_car_brand_model_id').append($('<option></option>').attr('value', response[row].model_id).text(response[row].model_name));
					}
					$('#popup_car_brand_model_id').selectpicker("refresh");
				}
				else {
					$('#gif').hide();
					$('#popup_car_brand_model_id').empty(); // clear the current elements in select box
					$('#popup_car_brand_model_id').append($('<option></option>').attr('value', '').text('Model'));
					$('#popup_car_brand_model_id').selectpicker("refresh");
				}
			});
        });

        $('#popup_car_brand_model_id').change(function () {
			$('#gif').show();
            $.post("<?php echo site_url('user_cars/ajax/get_brand_model_variant'); ?>", {
				brand_id: $('#popup_car_brand_id').val(),
				model_id: $('#popup_car_brand_model_id').val(),
				_mm_csrf: $('input[name="_mm_csrf"]').val()
			},
			function (data) {
				var response = JSON.parse(data);
				if (response.length > 0) {
					$('#gif').hide();
					$('#car_variant').empty(); // clear the current elements in select box
					$('#car_variant').append($('<option></option>').attr('value', '').text('Variant'));
					for (row in response) {
						$('#car_variant').append($('<option></option>').attr('value', response[row].brand_model_variant_id).text(response[row].variant_name));
					}
					$('#car_variant').selectpicker("refresh");
				}
				else {
					$('#gif').hide();
					$('#car_variant').empty(); // clear the current elements in select box
					$('#car_variant').append($('<option></option>').attr('value', '').text('Variant'));
					$('#car_variant').selectpicker("refresh");
				}
			});
        });
        
        $('#add_car_details').click(function () {

			var car_reg_no = $('#car_reg_no').val();
			var popup_car_brand_id = $('#popup_car_brand_id').val();
			var popup_car_brand_model_id = $('#popup_car_brand_model_id').val();
			var fuel_type = $('#fuel_type').val();
			var model_type = $('#model_type').val();
			
			var validation = [];			
			if($("#car_reg_no").val() == ''){
				validation.push('car_reg_no');
				$('.error_msg_car_reg_no').show().empty().html('Enter The Car Registration Number');
			}else{
				$('.error_msg_car_reg_no').hide();
			}
			if($("#popup_car_brand_id").val() == ''){
				validation.push('popup_car_brand_id');
			}
			if($("#is_model_text").val() == 'Y'){
				if($("#model_txt").val() == ''){
				validation.push('model_txt');
				}	
			}else{
				if($("#popup_car_brand_model_id").val() == ''){
				validation.push('popup_car_brand_model_id');	
				}
			}
		
			if($("#fuel_type").val() == ''){				
				validation.push('fuel_type');
			}			
			if($("#model_type").val() == ''){
				validation.push('model_type');		
			}			
			if(validation.length > 0){				
				validation.forEach(function(val) {					
				//$('#'+val).addClass("border_error");					
					if($('#'+val+'_error').length == 0){
						$('#'+val).parent().addClass('has-error');		
					}					
				});
				return false;
			}

			$('.border_error').removeClass('border_error');
			$('.has-error').removeClass('has-error');
			$('#gif').show();

            $.post("<?php echo site_url('user_cars/ajax/create'); ?>", {
				car_reg_no: $('#car_reg_no').val().toUpperCase(),
				owner_id: customer_id,
				entity_type: 'C',
				car_id: car_id,
				is_model_text: $('#is_model_text').val(),
				is_variant_text: $('#is_variant_text').val(),
				model_txt: $('#model_txt').val(),
				variant_txt: $('#variant_txt').val(),
				car_brand_id: $('#popup_car_brand_id').val(),
				car_model_year: $('#car_model_year').val(),
				car_brand_model_id: $('#popup_car_brand_model_id').val(),
				car_variant: $('#car_variant').val(),
				model_type: $("#model_type").val(),
				fuel_type: $('#fuel_type').val(),
				_mm_csrf: $('input[name="_mm_csrf"]').val()
			},
			function (data) {
				var response = JSON.parse(data);
				if(response.success === 1){
					$('#gif').hide();
					notie.alert(1, '<?php _trans('toaster1');?>', 2);
					$('#add_car_fdetail').hide();
					$('#add_car_sdetail').show();
					$("#user_car_id").val(response.user_car_details[0].car_list_id);
					$(".year").empty().html(response.user_car_details[0].car_model_year);
					$(".brand").empty().html(response.user_car_details[0].brand_name);
					$(".model").empty().html(response.user_car_details[0].model_name);
					$(".variant").empty().html(response.user_car_details[0].variant_name);
					if(response.customerCars.length > 0){
						if(model_from == 'jobcard' || model_from == 'reminder'){
							$('#customer_car_id').empty(); 
							$('#customer_car_id').append($('<option></option>').attr('value', '').text('Select Customer Vehicle'));
							for (row in response.customerCars) {
								var variant_name = (response.customerCars[row].variant_name)?response.customerCars[row].variant_name:'';
								$('#customer_car_id').append($('<option></option>').attr('value', response.customerCars[row].car_list_id).text((response.customerCars[row].brand_name?response.customerCars[row].brand_name:"")+''+(response.customerCars[row].model_name?", "+response.customerCars[row].model_name:"")+''+(variant_name?", "+variant_name:"")+' ('+response.customerCars[row].car_reg_no+')'));
							}
							$("#customer_car_id").val(response.user_car_details[0].car_list_id);
							$('#customer_car_id').selectpicker("refresh");
						}else{
							$('#user_car_list_id').empty(); 
							$('#user_car_list_id').append($('<option></option>').attr('value', '').text('Select Customer Vehicle'));
							for (row in response.customerCars) {
								var variant_name = (response.customerCars[row].variant_name)?response.customerCars[row].variant_name:'';
								$('#user_car_list_id').append($('<option></option>').attr('value', response.customerCars[row].car_list_id).text((response.customerCars[row].brand_name?response.customerCars[row].brand_name:"")+''+(response.customerCars[row].model_name?", "+response.customerCars[row].model_name:"")+''+(variant_name?", "+variant_name:"")+' ('+response.customerCars[row].car_reg_no+')'));
							}
							$("#user_car_list_id").val(response.user_car_details[0].car_list_id);
							$('#user_car_list_id').selectpicker("refresh");
						}
					}else {
						if(model_from == 'jobcard' || model_from == 'reminder'){
							$('#customer_car_id').empty(); 
							$('#customer_car_id').append($('<option></option>').attr('value', '').text('Select Customer Vehicle'));
							$('#customer_car_id').selectpicker("refresh");
						}else{
							$('#user_car_list_id').empty(); 
							$('#user_car_list_id').append($('<option></option>').attr('value', '').text('Select Customer Vehicle'));
							$('#user_car_list_id').selectpicker("refresh");
						}
					}			
					}else if(response.success == '2'){
						$('#gif').hide();	
						notie.alert(3, 'Model Name Already Existed', 2);
					}else if(response.success == '3'){
						$('#gif').hide();	
						notie.alert(3, 'Variant Name Already Existed', 2);
					}else if(response.success == '4'){
						$('#gif').hide();	
						notie.alert(3, 'Registration No Already Existed', 2);
					}else{
					$('#gif').hide();
					for (var key in response.validation_errors) {
						if(key == "car_brand_id"){
							$('#popup_car_brand_id').parent().addClass('has-error');
							$('.error_msg_popup_car_brand_id').show().empty().html(response.validation_errors[key]);
						}else if(key == "car_brand_model_id"){
							$('#popup_car_brand_model_id').parent().addClass('has-error');
							$('.error_msg_popup_car_brand_model_id').show().empty().html(response.validation_errors[key]);
						}else{
							$('#' + key).parent().addClass('has-error');
							$('.error_msg_' + key).show().empty().html(response.validation_errors[key]);
						}
					}
					$('#user_car_list_id').selectpicker("refresh");
				}
			});
        });
        
        $('#add_mileage').click(function () {

			var validation = [];

			if($("#total_mileage").val() == ''){
				validation.push('total_mileage');
			}

			if($("#daily_mileage").val() == ''){
				validation.push('daily_mileage');
			}

			if(validation.length > 0){				
				validation.forEach(function(val) {					
					if($('#'+val+'_error').length == 0){
						$('#'+val).parent().addClass('has-error');		
					}					
				});
				return false;
			}

			$('#gif').show();
            $.post("<?php echo site_url('user_cars/ajax/save'); ?>", {
				user_car_id: $('#user_car_id').val(),
				total_mileage: $('#total_mileage').val(),
				daily_mileage: $('#daily_mileage').val(),
				_mm_csrf: $('input[name="_mm_csrf"]').val()
			},
			function (data) {
				var response = JSON.parse(data);
				if(response.success === 1){
					notie.alert(1, 'Success!', 2);
					if(model_from =="customer"){
						window.location.href = "<?php echo site_url('clients/form'); ?>/"+customer_id+"/3";
					}else{
						$('#gif').hide();
						$('#addNewCar').modal('hide');
						$('#add_car_fdetail').hide();
						$('#add_car_sdetail').hide();
						$('.modal').remove();
						$('.modal-backdrop').remove();
						$('body').removeClass( "modal-open" );
					}
				}
			});
        });
        
        $('#skip_scar_level').click(function () {
			if(model_from =="customer"){
				window.location.href = "<?php echo site_url('clients/form'); ?>/"+customer_id+"/3";
			}else{
				$('#addNewCar').modal('hide');
				$('#add_car_fdetail').hide();
				$('#add_car_sdetail').hide();
				$('.modal').remove();
				$('.modal-backdrop').remove();
				$('body').removeClass( "modal-open" );
			}
        });
         
		$('.modal-popup-close').click(function () {
			if(model_from =="customer"){
				window.location.href = "<?php echo site_url('clients/form'); ?>/"+customer_id+"/3";
			}else{
				$('#addNewCar').modal('hide');
				$('#add_car_fdetail').hide();
				$('#add_car_sdetail').hide();
				$('.modal').remove();
				$('.modal-backdrop').remove();
				$('body').removeClass( "modal-open" );
			}
         }); 
         
         $( ".check_error_label" ).change(function() {
  			$('.error_msg_' + $(this).attr('name')).hide();
			$('#' + $(this).attr('name')).parent().removeClass('has-error'); 
		}); 

		$('form input[name="car_reg_no"]').blur(function () {
			var car_reg_no = $(this).val();
			// var re = /^[a-zA-Z0-9-]+$/;
			var re = /^[A-Z]{2}[0-9]{1,2}(?:[A-Z])?(?:[A-Z]*)?[0-9]{4}$/igm;
			if (re.test(car_reg_no)) {
				$('.error_msg_car_reg_no').html('').hide();
				$('.error_msg_car_reg_no').hide();
				$('#car_reg_no').parent().removeClass('has-error');	
			} else {
				$('.error_msg_car_reg_no').show();
				$('#car_reg_no').parent().addClass('has-error');
				$('.error_msg_car_reg_no').html('The car registration number field is not in the correct format.');
			}
		});

	   $('#model_add').click(function(){
			$("#is_model_text").val('Y');
			$("#is_variant_text").val('Y');
			$('.model_text').show();
			$('.model_select').hide();
			$('.variant_text').show();
			$('.variant_select').hide();

		});

		$('#model_select').click(function(){
			$("#is_model_text").val('N');
			$("#is_variant_text").val('N');
			$('.model_select').show();
			$('.model_text').hide();
			$('.variant_text').hide();
			$('.variant_select').show();
		});

		$('#variant_add').click(function(){
			$("#is_variant_text").val('Y');
			$('.variant_text').show();
			$('.variant_select').hide();
		});

		$('#variant_select').click(function(){
			$("#is_variant_text").val('N');
			$('.variant_select').show();
			$('.variant_text').hide();
		});


		$('#popup_car_brand_id').change(function() {
			if ($('#popup_car_brand_id').val() != '') {
				$('.model_select').show();				
				$('#model_add').show();
				$('.model_text').hide();
				$('#variant_add').show();
				$('.variant_select').show();
				$('.variant_text').hide();				

			} else {
				$('.model_select').show();
				$('.model_text').hide();
				$('#model_add').hide();
				$('.variant_select').show();				
				$('.variant_text').hide();
				$('#variant_add').hide();

			}  
		});


    });
</script>

<div class="modal fade" id="addNewCar" tabindex="-1" role="dialog" aria-labelledby="addNewCarLabel">
	<div id="gif" class="gifload">
		<div class="gifcenter">
			<center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
		</div>
	</div>
	<div class="modal-dialog vechicleBox" role="document">
		<div class="modal-content" id="add_car_fdetail">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
			<div class="modal-header withfull">
				<div class="col-xs-12 text-center">
					<?php if (!empty($car_detail)) { ?> 
					<h3 class="modal__h3 margin0px"><?php _trans('lable1107');?></h3>
					<?php } else { ?> 
					<h3 class="modal__h3 margin0px"> <?php _trans('lable71');?> </h3>
					<?php } ?>
				</div>
				<button type="button" class="modal-close modal-popup-close">
					<i class="font-icon-close-2"></i>
				</button>
			</div>
			<div class="modal-body col-xl-12">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 padding0px">
							<label class="form_label section-header-text"><?php _trans('lable72');?>. *</label>
							<input type="text" class="form-control check_error_label car_reg_no" name="car_reg_no" id="car_reg_no" value="<?php if (!empty($car_detail)) { echo $car_detail->car_reg_no; } ?>">
							<label class="pop_textbox_error_msg error_msg_car_reg_no" style="display: none"></label>
						</div>
						<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
								<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="padding:0px 15px 0px 0px;" > 
									<label class="form_label section-header-text"><?php _trans('lable73');?>*</label>
									<select class="bootstrap-select bootstrap-select-arrow check_error_label" data-live-search="true" name="popup_car_brand_id" id="popup_car_brand_id">
										<option value=''><?php _trans('lable1106');?></option>
										<?php if (count($car_brand_list) > 0) : ?>
										<?php foreach ($car_brand_list as $brand_list) {
											if(!empty($car_detail) && $car_detail->car_brand_id == $brand_list->brand_id) {
											$selected = 'selected="selected"'; } else { $selected = ''; } ?>
										<option value="<?php echo $brand_list->brand_id; ?>" <?php echo $selected; ?>><?php echo $brand_list->brand_name; ?></option>
										<?php } endif; ?>
									</select>
								</div>
								<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 model_select" style="padding:0px 5px 0px 5px;" >
									<label class="form_label section-header-text"><?php _trans('lable74');?>*</label>
									<select class="bootstrap-select bootstrap-select-arrow check_error_label" data-live-search="true" name="popup_car_brand_model_id" id="popup_car_brand_model_id">
										<option value=""><?php _trans('lable231');?></option>
										<?php if (!empty($car_model_list)) : ?>
											<?php foreach ($car_model_list as $model_list) {
											if (!empty($car_detail) && $car_detail->car_brand_model_id == $model_list->model_id) {
												$selected = 'selected="selected"';
											} else {
												$selected = '';
											} ?>
										<option value="<?php echo $model_list->model_id; ?>" <?php echo $selected; ?>><?php echo $model_list->model_name; ?></option>
										<?php } endif; ?>
									</select>
									<div class="col-lg-12 paddingTop5px paddingLeft0px">
									   <a style="display:none;" href="javascript:void(0)" id="model_add" class="fontSize_85rem float_left">+ Add Model</a>
									</div>
								</div>
								<input type="hidden" id="is_model_text" value="N">
								<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 model_text" style="padding:0px 5px 0px 5px;display:none" >
									<label class="form_label section-header-text"><?php _trans('lable231');?>*</label>
									<input type="text" placeholder="Enter Model" class="form-control" name="model_txt" id="model_txt" value="<?php if (!empty($car_detail)) { echo $car_detail->car_reg_no; } ?>">
									<div class="col-lg-12 paddingTop5px paddingLeft0px">
									   <a href="javascript:void(0)" id="model_select" class="fontSize_85rem float_left">+ Select Model</a>
									</div>
								</div>
								<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 variant_select" style="padding:0px 0px 0px 15px;" >
									<label class="form_label section-header-text"><?php _trans('lable75');?></label>
									<select class="bootstrap-select bootstrap-select-arrow check_error_label" data-live-search="true" name="car_variant" id="car_variant">
										<option value=""><?php _trans('lable232');?></option>
										<?php if (!empty($car_variant_list)) : ?>
											<?php foreach ($car_variant_list as $variant_list) {
											if (!empty($car_detail) && $car_detail->car_variant == $variant_list->brand_model_variant_id) {
												$selected = 'selected="selected"';
											} else {
												$selected = '';
											} ?>
										<option value="<?php echo $variant_list->brand_model_variant_id; ?>" <?php echo $selected; ?>><?php echo $variant_list->variant_name; ?></option>
										<?php } endif; ?>
									</select>
									<div class="col-lg-12 paddingTop5px paddingLeft0px">
									   <a style="display:none;" href="javascript:void(0)" id="variant_add" class="fontSize_85rem float_left">+ Add Variant</a>
									</div>
								</div>
								<input type="hidden" id="is_variant_text" value="N">
								<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 variant_text" style="padding:0px 5px 0px 5px;display:none" >
									<label class="form_label section-header-text"><?php _trans('lable232');?></label>
									<input type="text" placeholder="Enter Variant" class="form-control" name="variant_txt" id="variant_txt" value="<?php if (!empty($car_detail)) { echo $car_detail->car_reg_no; } ?>">
									<div class="col-lg-12 paddingTop5px paddingLeft0px">
									   <a href="javascript:void(0)" id="variant_select" class="fontSize_85rem float_left">+ Select Variant</a>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
								<div class="col-xl-4 col-lg-4 col-md-4 col-xs-12" style="padding:0px 15px 0px 0px;">
									<label class="form_label section-header-text"> <?php _trans('lable76'); ?></label>
									<select class="bootstrap-select bootstrap-select-arrow check_error_label" data-live-search="true" name="car_model_year" id="car_model_year">
										<option value=""><?php _trans('lable130');?></option>
										<?php for ($i = 2030; $i >= 1980; --$i) {
											if (!empty($car_detail) && $car_detail->car_model_year == $i) {
												$selected = 'selected="selected"';
											} else {
												$selected = '';
											} ?>
											<option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="col-xl-4 col-lg-4 col-md-4 col-xs-12" style="padding:0px 5px 0px 5px;">
									<label class="form_label section-header-text"><?php _trans('lable77');?> *</label>
									<select class="bootstrap-select bootstrap-select-arrow check_error_label form-control" name="fuel_type" id="fuel_type" style="height: 45px;" >
										<option value=""><?php _trans('lable132');?></option>
										<option value="P" <?php if (!empty($car_detail) && $car_detail->fuel_type == 'P') {
														echo 'selected="selected"';
											} ?>><?php _trans('lable1105');?></option>
										<option value="D" <?php if (!empty($car_detail) && $car_detail->fuel_type == 'D') {
														echo 'selected="selected"';
											} ?>><?php _trans('lable1104');?></option>
										<option value="G" <?php if (!empty($car_detail) && $car_detail->fuel_type == 'G') {
												echo 'selected="selected"';
											} ?>><?php _trans('lable1103');?></option>
									</select>
								</div>
								<div class="col-xl-4 col-lg-4 col-md-4 col-xs-12" style="padding:0px 0px 0px 15px;">
									<label class="form_label"><?php _trans('lable78');?>*</label>
									<select name="model_type" id="model_type" class="bootstrap-select bootstrap-select-arrow check_error_label form-control">
										<option value=""><?php _trans('lable544');?></option>
										<?php foreach($model_type as $modelType){?>
										<option value="<?php echo $modelType->mvt_id; ?>" <?php if($modelType->mvt_id == $car_detail->model_type){echo 'selected';}?>><?php if($modelType->workshop_id != 1){ echo $modelType->vehicle_type_name."  ".$modelType->display_board_name; } else { echo $modelType->vehicle_type_name; } ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer withfull text-center">
				<button type="button" class="btn btn-rounded btn-primary"  name="add_car_details" id="add_car_details"><?php _trans('lable70');?></button>
				<button type="button" class="btn btn-rounded btn-default modal-popup-close"><?php _trans('lable58');?></button>
			</div>
		</div>
		
		<div class="modal-content" id="add_car_sdetail" style="display: none">
			<input type="hidden" name="user_car_id" id="user_car_id" />
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
			<div class="modal-header">
				<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
					<i class="font-icon-close-2"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="form">
					<div class="row text-center">
						<div class="col-xs-12">
							<img src="data:image/png;base64,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" class="modal__icon" width="70" data-reactid=".9.1.0.0.2.0.0">
							<h3 class="h3-modal"><?php _trans('lable1102');?></h3>
							<p class="p-modal">
								<span>Total and daily average mileage help us determine the pace of wear on your </span><span class="year">2014</span><span> </span><span class="brand">Audi</span><span> </span><span class="model">A4 allroad</span><span> </span><span class="variant">L4-2.0L Turbo</span><span>.</span>
							</p>
						</div>
					</div>
					<div>
						<div class="row">
							<div class="col-sm-10 col-centered">
								<label class="form_label"><?php _trans('lable896');?>*</label>
								<input type="text" class="form-control" name="total_mileage" id="total_mileage" value="<?php if (!empty($car_detail)) {
									echo $car_detail->total_mileage;
								} ?>">
							</div>
						</div>
						<div class="row">
							<div class="col-sm-10 col-centered">
								<label class="form_label"><?php _trans('lable897');?>*</label>
								<input type="text" class="form-control" name="daily_mileage" id="daily_mileage" value="<?php if (!empty($car_detail) > 0) {
									echo $car_detail->daily_mileage;
								} ?>">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer text-center">
				<button type="button" name="add_mileage" id="add_mileage" class="btn btn-rounded btn-primary">
				<?php _trans('lable57');?>
				</button>
				<button type="button" class="btn btn-rounded btn-default" id="skip_scar_level">
				<?php _trans('lable1101');?>
				</button>
			</div>
		</div>
	</div>
</div>
