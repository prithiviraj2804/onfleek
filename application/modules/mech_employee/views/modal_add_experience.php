<script type="text/javascript">

function create_datepicker_onchange(){
	
	var date2 = $('.create_datepicker').datepicker('getDate', '+6570d');
	date2.setDate(date2.getDate()+6570);
	var lastDate = new Date();
	$('.expire_datepicker').datepicker('setDate', lastDate);
	$('.expire_datepicker').datepicker('setStartDate',date2);
	
}  

    $(function () {

    	$('#customer_country').change(function () {
			$('#gif').show();
            $.post("<?php echo site_url('settings/ajax/get_state_list'); ?>", {
				country_id: $('#customer_country').val(),
				_mm_csrf: $('#_mm_csrf').val()
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
				_mm_csrf: $('#_mm_csrf').val()
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

		<?php //  if($employee_experience_detail->from){ ?>
		// 	var to_date = '<?php // echo $employee_experience_detail->from; ?>';
		// 	to_date = new Date(to_date);
		// 	$('#to').datepicker('setStartDate', to_date);
		 <?php // } ?>

		// var date = new Date();
  		// var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
  		// var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());

		// $('#from').datepicker({
		// 	endDate: end,
		// 	autoclose: true
  		// }).on('changeDate', function (selected) {
		// 	var toStartDate = new Date(selected.date.valueOf());
		// 	$('#to').datepicker('setStartDate', toStartDate);
  		// });

		// $('#to').datepicker({
		// 	endDate: end,
		// 	autoclose: true
  		// });

        // Display the create quote modal
        $('#addNewCar').modal('show');
        $(".bootstrap-select").selectpicker("refresh");
        var model_from = "<?php echo $model_from; ?>";
		var employee_id = "<?php echo $employee_id; ?>";

        $('#add_experience_details').click(function () {
			var validation = [];

			if($("#previous_employee_role").val() == ''){
				validation.push('previous_employee_role');
			}
			if($("#company_name").val() == ''){
				validation.push('company_name');
			}			

			if($("#from").val() == ''){
				validation.push('from');
			}			

			if($("#to").val() == ''){
				validation.push('to');
			}	

			if($("#area").val() == ''){
				validation.push('area');
			}
			if($("#customer_country").val() == ''){
				validation.push('customer_country');
			}
			if($("#customer_state").val() == ''){
				validation.push('customer_state');
			}
			if($("#customer_city").val() == ''){
				validation.push('customer_city');
			}
			if($("#zip_code").val() == ''){
				validation.push('zip_code');
			}
					

			if(validation.length > 0){
			validation.forEach(function(val) {
				$('#'+val).addClass("border_error");
				if($('#'+val+'_error').length == 0){
					$('#'+val).parent().addClass('has-error');
				} 
			});
			return false;
		}
		
		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');
		$('#gif').show();

            $.post("<?php echo site_url('mech_employee/ajax/addexperience'); ?>", {
            	customer_country : $("#customer_country").val(),
				customer_state : $("#customer_state").val(),
				customer_city : $("#customer_city").val(),
				zip_code: $('#zip_code').val(),
				customer_street_1: $('#customer_street_1').val(),
				customer_street_2: $('#customer_street_2').val(),
				area:$('#area').val(),
				employee_experience_id: $('#employee_experience_id').val(),
				employee_id: employee_id,
				previous_employee_role: $('#previous_employee_role').val(),
				company_name: $('#company_name').val(),
				from: $("#from").val(),
				to: $("#to").val(),
				address: $('#address').val(),
				description: $('#description').val(),
				_mm_csrf: $('#_mm_csrf').val()
			},
			function (data) {
				var response = JSON.parse(data);
				//console.log(response);
				if(response.success === 1){
					notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
					$('#addNewCar').modal('hide');
					$('#add_car_fdetail').hide();
					$('#add_car_sdetail').hide();
					$('.modal').remove();
					$('.modal-backdrop').remove();
					$('body').removeClass( "modal-open" );
					window.location = '<?php echo site_url('mech_employee/form'); ?>/'+employee_id+'/5';	
				} else {
					for (var key in response.validation_errors) {
						$('#' + key).parent().addClass('has-error');
						$('.error_msg_' + key).show().empty().html(response.validation_errors[key]);
					}
					$('#user_car_list_id').selectpicker("refresh");
				}
			});
        });

		$('.modal-popup-close').click(function () {
			$('#addNewCar').modal('hide');
			$('#add_car_fdetail').hide();
			$('#add_car_sdetail').hide();
			$('.modal').remove();
			$('.modal-backdrop').remove();
			$('body').removeClass( "modal-open" );
         }); 
         
         $( ".check_error_label" ).change(function() {
  			$('.error_msg_' + $(this).attr('name')).hide();
			$('#' + $(this).attr('name')).parent().removeClass('has-error'); 
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
			<form name="car_fdetails" method="post" class="car_fdetails">
				<input type="hidden" name="employee_experience_id" id="employee_experience_id" value="<?php echo $employee_experience_detail->employee_experience_id ?>" autocomplete="off" >
				<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" autocomplete="off"/>
				<div class="modal-header">
					<div class="col-xs-12 text-center">
						<?php if (count($employee_experience_detail) > 0) { ?> 
						<h3 class="modal__h3"><?php _trans('lable173'); ?></h3>
						<?php } else { ?> 
						<h3 class="modal__h3"><?php _trans('lable172'); ?></h3>
						<?php } ?>
					</div>
					<button type="button" class="modal-close modal-popup-close">
						<i class="font-icon-close-2"></i>
					</button>
				</div>
				<div class="modal-body">
					<div class="form">
						<div class="row">
							<div class="form-group clearfix">
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="padding-left:0px;">
									<label class="form_label"><?php _trans('lable135'); ?>*</label>
									<div class="form_controls">
										<select name="previous_employee_role" id="previous_employee_role" class="bootstrap-select bootstrap-select-arrow form-control removeErrorInput" data-live-search="true" autocomplete="off">
											<option value=""><?php _trans('lable150'); ?></option>
											<?php foreach ($employees_role as $key => $role){ ?><option value="<?php echo $role->role_id; ?>" <?php if ($role->role_id == $employee_experience_detail->previous_employee_role){ echo 'selected="selected"'; }?> ><?php echo $role->role_name; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="padding-right:0px;">
									<label class="form_label section-header-text"><?php _trans('lable174'); ?>*</label>
									<input class="form-control check_error_label" name="company_name" id="company_name"  value="<?php if (count($employee_experience_detail) > 0) { echo $employee_experience_detail->company_name; } ?>" autocomplete="off">
									<label class="pop_textbox_error_msg error_msg_car_reg_no" style="display: none"></label>
									</div>
								</div>
								<div class="form-group clearfix" >
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="padding-left:0px;">
										<label class="form_label"><?php _trans('lable175'); ?>*</label>
										<div class="form_controls">
											<input type="text" name="from" id="from" class="form-control removeErrorInput datepicker" value="<?php echo $employee_experience_detail->from?date_from_mysql($employee_experience_detail->from):''; ?>" autocomplete="off">
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="padding-right:0px;">
										<label class="form_label"><?php _trans('lable176'); ?>*</label>
										<div class="form_controls">
											<input type="text" name="to" id="to" class="form-control removeErrorInput datepicker" value="<?php echo $employee_experience_detail->to?date_from_mysql($employee_experience_detail->to):''; ?>" autocomplete="off">
										</div>
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="padding-left:0px;">
										<label class="form_label"><?php _trans('lable85'); ?> 1</label>
										<div  class="form_controls">
											<input name="customer_street_1" id="customer_street_1" class="form-control" value="<?php if (count($employee_experience_detail) > 0) { echo $employee_experience_detail->customer_street_1; } ?>" autocomplete="off">
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="padding-right:0px;">
										<label class="form_label"><?php _trans('lable85'); ?> 2</label>
										<div class="form_controls">
											<input name="customer_street_2" id="customer_street_2" class="form-control" value="<?php if (count($employee_experience_detail) > 0) { echo $employee_experience_detail->customer_street_2;} ?>" autocomplete="off">
										</div>
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="padding-left:0px;">
										<label class="form_label">Area*</label>
										<div class="form_controls">
											<input name="area" id="area" class="form-control" value="<?php if (count($employee_experience_detail) > 0) { echo $employee_experience_detail->area; } ?>" autocomplete="off">
										</div>
									</div>			
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="padding-right:0px;">
										<label class="form_label"><?php _trans('lable86'); ?>*</label>
										<div>
											<?php if($employee_experience_detail->customer_country){
												$default_country_id = $employee_experience_detail->customer_country;
											}else{
												$default_country_id = $this->session->userdata('default_country_id');
											} ?>
											<select id="customer_country" name="customer_country" class="country bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
												<option value=""><?php _trans('lable163'); ?></option>
												<?php foreach ($country_list as $countryList) {?>
												<option value="<?php echo $countryList->id; ?>" <?php if ($countryList->id == $default_country_id) {echo 'selected';} ?> > <?php echo $countryList->name; ?> </option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="padding-left:0px;">
										<label class="form_label"><?php _trans('lable87'); ?>*</label>
										<div>
											<?php if($employee_experience_detail->customer_state){
												$default_state_id = $employee_experience_detail->customer_state;
											}else{
												$default_state_id = $this->session->userdata('default_state_id');
											} ?>
											<select id="customer_state" name="customer_state" class="state bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
												<option value=""><?php _trans('lable164'); ?></option>
												<?php foreach ($state_list as $stateList) {?>
												<option value="<?php echo $stateList->state_id; ?>" <?php if ($stateList->state_id == $default_state_id) {echo 'selected';} ?> > <?php echo $stateList->state_name; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="padding-right:0px;">
										<label class="form_label"><?php _trans('lable88'); ?>*</label>
										<div>
											<?php if($employee_experience_detail->customer_city){
												$default_city_id = $employee_experience_detail->customer_city;
											}else{
												$default_city_id = $this->session->userdata('default_city_id');
											} ?>
											<select id="customer_city" name="customer_city" class="city bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
												<option value=""><?php _trans('lable165'); ?></option>
												<?php foreach ($city_list as $cityList) { ?>
												<option value="<?php echo $cityList->city_id; ?>" <?php if ($cityList->city_id == $default_city_id) { echo 'selected';} ?> > <?php echo $cityList->city_name; ?></option><?php } ?>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="padding-left:0px;">
										<label class="form_label"><?php _trans('lable89'); ?>*</label>
										<div class="form_controls">
											<input name="zip_code" id="zip_code" class="form-control" value="<?php if(count($employee_experience_detail) > 0) { echo $employee_experience_detail->zip_code; } ?>" autocomplete="off">
										</div>
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:0px;">
										<label class="form_label"><?php _trans('lable177'); ?></label>
										<div class="form_controls">
											<textarea class="form-control" id="description" name="description" maxlength="250" autocomplete="off"><?php echo $employee_experience_detail->description; ?></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer text-center col-xs-12">
						<button type="button" class="btn btn-rounded btn-primary"  name="add_experience_details" id="add_experience_details"><?php _trans('lable172'); ?></button>
						<button type="button" class="btn btn-rounded btn-default modal-popup-close"><?php _trans('lable171'); ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>