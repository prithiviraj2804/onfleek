<script type="text/javascript">
    $(function () {

		$(".add_new_city_btn").click(function(){
			$(".city_select_box").hide();
			$(".add_new_city_btn").hide();
			$(".cancel_new_city_btn").show();
			$(".city_text_box").show();
			$("#customer_city").val('').trigger('change');
			$('#customer_state').selectpicker("refresh");
			$("#is_new_city").val('Y');
		});

		$(".cancel_new_city_btn").click(function(){
			$(".add_new_city_btn").show();
			$(".city_select_box").show();
			$(".cancel_new_city_btn").hide();
			$(".city_text_box").hide();
			$("#new_city").val('');
			$("#is_new_city").val('N');
		});

		$("#is_default").change(function() {
			if($("#is_default:checked").is(":checked"))
			{
			$("#is_default").val('Y');
			}
			else
			{
			$("#is_default").val('N');
			}
		});

		$(".removeError").change(function() {
			var len = (this.value);
			if (this.value != "" || this.value != 0) {
				$('#' + $(this).attr('name')).parent().removeClass('has-error');
				$('#' + $(this).attr('name')).parent().removeClass('border_error');
				$('#' + $(this).attr('name')).removeClass('has-error');
				$('#' + $(this).attr('name')).removeClass('border_error');
			}
		});

        $('#addNewCar').modal('show');
		$(".bootstrap-select").selectpicker("refresh");
		var type = "<?php echo $type; ?>";
		var customer_id = "<?php echo $customer_id; ?>";
		var address_id = "<?php echo $address_id; ?>";
		var entity_type = "<?php echo $entity_type; ?>";

	$('#add_address_details').click(function () {

		$("#tag_place").hide();
		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');

		var validation = [];

		if($("#customer_street_1").val() == ''){
			validation.push('customer_street_1');
		}
		if($("#customer_country").val() == ''){
			validation.push('customer_country');
		}
		if($("#customer_state").val() == ''){
			validation.push('customer_state');
		}
		if($("#area").val() == ''){
			validation.push('area');
		}

		if($("#is_new_city").val() == 'Y'){
			if($("#new_city").val() == ''){
				validation.push('new_city');
			}
		}else{
			if($("#customer_city").val() == ''){
				validation.push('customer_city');
			}
		}

		if($("#zip_code").val() == ''){
			validation.push('zip_code');
		}

		if($("input[name='address_type']:checked").val() == '' || $("input[name='address_type']:checked").val() == null || $("input[name='address_type']:checked").val() == undefined){
			$("#tag_place").show();
			return false;
		}
		
		if(validation.length > 0){
			validation.forEach(function(val) {
				$('#'+val).addClass("border_error");
				$('#'+val).parent().addClass('has-error');
			});
			return false;
		}

        $('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');
			$('#gif').show();
			
			$.post("<?php echo site_url('user_address/ajax/create'); ?>", {
				customer_country : $("#customer_country").val(),
				customer_state : $("#customer_state").val(),
				is_new_city : $("#is_new_city").val(),
				customer_city : $("#customer_city").val(),
				new_city: $("#new_city").val()?$("#new_city").val():'',
				zip_code: $('#zip_code').val(),
				customer_street_1: $('#customer_street_1').val(),
				customer_street_2: $('#customer_street_2').val(),
				area:$('#area').val(),
				user_id: customer_id,
				address_id: address_id,
				entity_type: 'C',
				address_type: ($("input[name='address_type']:checked").val())?$("input[name='address_type']:checked").val():'',				
				is_default: $('#is_default').val(),
				_mm_csrf: $('input[name="_mm_csrf"]').val(),
			},function (data) {
				var response = JSON.parse(data);
				if(response.success == 1){
					$("#tag_place").hide();
					$('#gif').hide();
					notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
					if(type == "customer"){
						$('#add_car_fdetail').hide();
						$('#addNewCar').modal('hide');
						$('.modal').remove();
						$('.modal-backdrop').remove();
						$('body').removeClass( "modal-open" );
						window.location.href = "<?php echo site_url('clients/form'); ?>/"+customer_id+"/2";
					}else{
						var address_name = (response.address_details.customer_street_1?response.address_details.customer_street_1:"")+""+(response.address_details.customer_street_2?", "+response.address_details.customer_street_2:"")+""+(response.address_details.area?", "+response.address_details.area:"")+", "+response.address_details.zip_code;
						$('#pickup_address').append($('<option></option>').attr('value', response.address_details.user_address_id).text(address_name));
						$("#pickup_address").val(response.address_details.user_address_id);
						$('#pickup_address').selectpicker("refresh");
						$('#user_address_id').append($('<option></option>').attr('value', response.address_details.user_address_id).text(address_name));
						$("#user_address_id").val(response.address_details.user_address_id);
						$('#user_address_id').selectpicker("refresh");
						$('#add_car_fdetail').hide();
						$('#addNewCar').modal('hide');
						$('.modal').remove();
						$('.modal-backdrop').remove();
						$('body').removeClass( "modal-open" );
					}
				} else if(response.success == 0){
					$('#gif').hide();
					$('.has-error').removeClass('has-error');
					notie.alert(3, 'city already exist', 2);
				}else {
					$('#gif').hide();
					$('.has-error').removeClass('has-error');
					for (var key in response.validation_errors) {
						if(key == "address_type"){
							$("#tag_place").show();
						}else{
							$('#' + key).parent().addClass('has-error');
							$('.error_msg_' + key).show().empty().html(response.validation_errors[key]);
						}
					}
				}
			});
        });
        
		$('#customer_country').change(function () {
			$('#gif').show();
            $.post("<?php echo site_url('settings/ajax/get_state_list'); ?>", {
				country_id: $('#customer_country').val(),
				_mm_csrf: $('input[name="_mm_csrf"]').val(),
			},
			function (data) {
				var response = JSON.parse(data);
				if (response.length > 0) {
					$('#gif').hide();
					$('#customer_state').empty(); // clear the current elements in select box
					$('#customer_state').append($('<option></option>').attr('value', '').text('Select State'));
					for (row in response) {
						$('#customer_state').append($('<option></option>').attr('value', response[row].state_id).text(response[row].state_name));
					}
					$('#customer_state').selectpicker("refresh");
				}
				else {
					$('#gif').hide();
					$('#customer_state').empty(); // clear the current elements in select box
					$('#customer_state').append($('<option></option>').attr('value', '').text('Select State'));
					$('#customer_state').selectpicker("refresh");
				}
			});
		});
		
		$('#customer_state').change(function () {
			$('#gif').show();
            $.post("<?php echo site_url('settings/ajax/get_city_list'); ?>", {
				state_id: $('#customer_state').val(),
				_mm_csrf: $('input[name="_mm_csrf"]').val(),
			},
			function (data) {
				var response = JSON.parse(data);
				if (response.length > 0) {
					$('#gif').hide();
					$('#customer_city').empty(); // clear the current elements in select box
					$('#customer_city').append($('<option></option>').attr('value', '').text('Select City'));
					for (row in response) {
						$('#customer_city').append($('<option></option>').attr('value', response[row].city_id).text(response[row].city_name));
					}
					$('#customer_city').selectpicker("refresh");
				}
				else {
					$('#gif').hide();
					$('#customer_city').empty(); // clear the current elements in select box
					$('#customer_city').append($('<option></option>').attr('value', '').text('Select City'));
					$('#customer_city').selectpicker("refresh");
				}
			});
		});
		//$('.summernote').summernote();
	});
	$('.modal-popup-close').click(function () {
		$('.modal').remove();
		$('.modal-backdrop').remove();
		$('body').removeClass( "modal-open" );
	}); 
	$( ".check_error_label" ).change(function() {
		$('.error_msg_' + $(this).attr('name')).hide();
		$('#' + $(this).attr('name')).parent().removeClass('has-error'); 
	});     
</script>
<div class="modal fade" id="addNewCar" tabindex="-1" role="dialog" aria-labelledby="addNewCarLabel">
	<div id="gif" class="gifload">
		<div class="gifcenter">
			<center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
		</div>
	</div>
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="add_car_fdetail">
			<form name="car_fdetails" method="post" class="car_fdetails">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
				<input type="hidden" name="is_new_city" id="is_new_city" value="N" >
				<div class="modal-header">
					<div class="col-xs-12 text-center">
						<h3 class="modal__h3"><?php _trans('lable45'); ?></h3>
					</div>
					<button type="button" class="modal-close modal-popup-close">
						<i class="font-icon-close-2"></i>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"> 
							<div class="form_group clearfix">
								<label class="form_label"><?php _trans('lable85'); ?> 1*</label>
								<div class="form_controls">
									<input type="text" name="customer_street_1" id="customer_street_1" class="form-control" value="<?php if($address_id){echo $address_detail->customer_street_1; } ?>">
								</div>
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"> 
							<div class="form-group clearfix">
								<label class="form_label"><?php _trans('lable85'); ?> 2</label>
								<div class="form_controls">
									<input type="text" name="customer_street_2" id="customer_street_2" class="form-control" value="<?php if ($address_id){echo $address_detail->customer_street_2;} ?>">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"> 
							<div class="form-group clearfix">
								<label class="form_label"><?php _trans('lable899'); ?>*</label>
								<div class="form_controls">
									<input type="text" name="area" id="area" class="form-control" value="<?php if($address_id){echo $address_detail->area;} ?>">
								</div>
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"> 					
							<div class="form-group clearfix">
								<label class="form_label"><?php _trans('lable86'); ?>*</label>
								<div class="form_controls">
								<?php if($address_detail->customer_country){
									$default_country_id = $address_detail->customer_country;
									}else{
									$default_country_id = $this->session->userdata('default_country_id');
									} ?>
									<select id="customer_country" name="customer_country" class="country bootstrap-select bootstrap-select-arrow form-control removeErrorInput" data-live-search="true" autocomplete="off">
										<option value=""><?php _trans('lable163'); ?></option>
										<?php foreach ($country_list as $countryList) {?>
										<option value="<?php echo $countryList->id; ?>" <?php if ($countryList->id == $default_country_id) {echo 'selected';} ?> > <?php echo $countryList->name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<?php
					if($address_detail->customer_state){
						$default_state_id = $address_detail->customer_state;
					}else{
						$default_state_id = $this->session->userdata('default_state_id');
					} ?>
					<div class="row">
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"> 
							<div class="form-group clearfix">
								<label class="form_label"><?php _trans('lable87'); ?>*</label>
								<div class="form_controls">
									<select id="customer_state" name="customer_state" class="state bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
										<option value=""><?php _trans('lable164'); ?></option>
										<?php foreach ($state_list as $stateList) {?>
										<option value="<?php echo $stateList->state_id; ?>" <?php if ($stateList->state_id == $default_state_id) {echo 'selected';} ?> > <?php echo $stateList->state_name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"> 
							<div class="form-group clearfix">
								<label class="form_label"><?php _trans('lable88'); ?>*</label>
								<span class="add_new_city_btn">add new city</span>
								<span class="cancel_new_city_btn" style="display:none">Cancel</span>
								<div class="form_controls city_select_box">
									<?php if($address_detail->customer_city){
									$default_city_id = $address_detail->customer_city;
									}else{
									$default_city_id = $this->session->userdata('default_city_id');
									} ?>
									<select id="customer_city" name="customer_city" class="city bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
										<option value=""><?php _trans('lable165'); ?></option>
										<?php foreach ($city_list as $cityList) { ?>
										<option value="<?php echo $cityList->city_id; ?>" <?php if ($cityList->city_id == $default_city_id) { echo 'selected';} ?> > <?php echo $cityList->city_name; ?></option><?php } ?>
									</select>
								</div>
								<div class="form_controls city_text_box" style="display:none;">
									<input id="new_city" name="new_city" class="form-control removeError"  autocomplete="off">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"> 
							<div class="form-group clearfix">
								<label class="form_label"><?php _trans('lable89'); ?>*</label>
								<div class="form_controls">
									<input type="text" name="zip_code" id="zip_code" class="form-control" value="<?php if($address_id){echo $address_detail->zip_code;} ?>">
								</div>
							</div>
						</div>
					</div>
					<div>
						<div class="form-group clearfix" >
							<label class="form_label"><?php _trans('lable63'); ?>*</label>
							<div class="form_controls" >
								<div class="row tag_place" >
									<div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
										<input type="radio" id="address_type" name="address_type" class="g-input address_type" value="Home" <?php if($address_id && $address_detail->address_type == 'Home'){echo 'checked="checked"';} ?>>
											<label><?php _trans('lable66'); ?></label>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
											<input type="radio" name="address_type" class="g-input address_type" value="Office" <?php if($address_id && $address_detail->address_type == 'Office'){echo 'checked="checked"';} ?>>
											<label><?php _trans('lable67'); ?></label>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
											 <input type="radio" name="address_type" class="g-input address_type" value="Others" <?php if($address_id && $address_detail->address_type == 'Others'){echo 'checked="checked"';} ?>>
											 <label><?php _trans('lable68'); ?></label>
										</div>
									</div>
									<div id="tag_place" style="display:none;" class="alertColor"><?php _trans('err1'); ?></div>
								</div>
							</div>
							<div class="form_group" >
								<div class="form_controls" >
									<input type="checkbox" name="is_default" id="is_default" class="g-input" value="<?php echo ($address_detail->is_default?$address_detail->is_default:"N"); ?>" <?php if($address_id && $address_detail->is_default == 'Y'){echo 'checked="checked"';} ?>>
									<label class="form_label checkboxLabel "><?php _trans('lable69'); ?></label>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer text-center">
						<button type="button" class="btn btn-rounded btn-primary"  name="add_address_details" id="add_address_details">
							<?php _trans('lable70'); ?>
						</button>
						<button type="button" class="btn btn-rounded btn-default modal-popup-close">
							<?php _trans('lable58'); ?>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>