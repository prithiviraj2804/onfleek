

<script src="<?php echo base_url(); ?>assets/mp_backend/js/lib/jquery-validation/jquery.validate.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/additional-methods.js"></script>
<script type="text/javascript">
	$(document).ready(function() {

		$('#fileError').empty();

		$('#workshop_logo').bind('change', function() {
			var a=(this.files[0].size);
			if(a > 50000) {
				$('#fileError').empty().append('File Size is too large');
			};
		});

		$("#btn-submit").click(function(){

			$("form[name='workshop']").validate({
				rules: {
					workshop_name:{
						required:true,
					},
					owner_name:{
						required:true,
					},
					workshop_contact_no:{
						required:true,
					},
					workshop_email_id:{
						required:true,
					},
					workshop_street:{
						required:true,
					},
					workshop_country:{
						required:false,
					},
					workshop_state:{
						required:false,
					},
					workshop_city:{
						required:false,
					},
					workshop_pincode: {
						required:true,
					},
					registration_type:{
						required:true,
					},
					total_employee_count:{
						required:true,
					},
					since_from:{
						required:true,
					},
					workshop_is_enabled_inventory:{
						required:true,
					},
					workshop_is_enabled_jobsheet:{
						required:true,
					},
				},
				submitHandler: function(form) {
					form.submit();
				}
			});
		});
		$('.country').change(function () {
            $.post("<?php echo site_url('settings/ajax/get_state_list'); ?>", {
				country_id: $('#workshop_country').val(),
				_mm_csrf: $('#_mm_csrf').val()
			},
			function (data) {
				var response = JSON.parse(data);
				if (response.length > 0) {
					$('#workshop_state').empty(); // clear the current elements in select box
					$('#workshop_state').append($('<option></option>').attr('value', '').text('Select State'));
					for (row in response) {
						$('#workshop_state').append($('<option></option>').attr('value', response[row].state_id).text(response[row].state_name));
					}
					$('#workshop_state').selectpicker("refresh");
				}
				else {
					$('#workshop_state').empty(); // clear the current elements in select box
					$('#workshop_state').append($('<option></option>').attr('value', '').text('Select State'));
					$('#workshop_state').selectpicker("refresh");
				}
			});
		});
		
		$('.state').change(function () {
            $.post("<?php echo site_url('settings/ajax/get_city_list'); ?>", {
				state_id: $('#workshop_state').val(),
				_mm_csrf: $('#_mm_csrf').val()
			},
			function (data) {
				var response = JSON.parse(data);
				if (response.length > 0) {
					$('#workshop_city').empty(); // clear the current elements in select box
					$('#workshop_city').append($('<option></option>').attr('value', '').text('Select City'));
					for (row in response) {
						$('#workshop_city').append($('<option></option>').attr('value', response[row].city_id).text(response[row].city_name));
					}
					$('#workshop_city').selectpicker("refresh");
				}
				else {
					$('#workshop_city').empty(); // clear the current elements in select box
					$('#workshop_city').append($('<option></option>').attr('value', '').text('Select City'));
					$('#workshop_city').selectpicker("refresh");
				}
			});
		});
	});
</script>
<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php _trans('label959'); ?></h3>
				</div>
			</div>
		</div>
	</div>
</header>
<div id="content">
	<div class="row">
        <div class="col-xs-12 col-md-12 col-md-offset-3">
			<form name="workshop" method="post" id="workshop" enctype="multipart/form-data">
    			<input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?= $this->security->get_csrf_hash(); ?>">
				<?php $this->layout->load_view('layout/alerts'); ?>
				<div class="container-wide">
					<div class="row">
						<?php if($this->session->userdata('is_new_user') != 'N'){ ?>
						<div class="col-xs-12">
							<a class="anchor anchor-back" href="<?php echo site_url('label959'); ?>"><i class="fa fa-long-arrow-left"></i><span>Back to workshop</span></a>
						</div>
						<?php } ?>
					</div>
                	<input class="hidden" name="is_update" type="hidden"
                    <?php if ($this->mdl_workshop_setup->form_value('is_update')) {
    					echo 'value="1"';
					} else {
    					echo 'value="0"';
					} ?>>
					<div class="box">
						<div class="box_body">
							<div class="form_group">
								<label class="form_label"> <?php _trans('lable683'); ?>*</label>
								<div class="form_controls">
									<input type="text" name="workshop_name" id="workshop_name" class="form-control"
                           				value="<?php echo $this->mdl_workshop_setup->form_value('workshop_name', true); ?>">
								</div>
							</div>
							<div class="form_group">
								<label class="form_label"> <?php _trans('lable684'); ?>*</label>
								<div class="form_controls">
									<input type="text" name="owner_name" id="owner_name" class="form-control"
                           				value="<?php echo $this->mdl_workshop_setup->form_value('owner_name', true); ?>">
								</div>
							</div>
							<div class="form_group">
								<label class="form_label"> <?php _trans('lable692'); ?>*</label>
								<div class="form_controls">
									<input type="text" name="workshop_contact_no" id="workshop_contact_no" class="form-control"
                           				value="<?php echo $this->mdl_workshop_setup->form_value('workshop_contact_no', true); ?>">
								</div>
							</div>
							<div class="form_group">
								<label class="form_label"> <?php _trans('lable693'); ?>*</label>
								<div class="form_controls">
									<input type="text" name="workshop_email_id" id="workshop_email_id" class="form-control"
										value="<?php echo $this->mdl_workshop_setup->form_value('workshop_email_id', true); ?>">
								</div>
							</div>
							<div class="form_group">
								<label class="form_label"> <?php _trans('lable694'); ?>*</label>
								<div class="form_controls">
									<input type="text" name="workshop_street" id="workshop_street" class="form-control"
										value="<?php echo $this->mdl_workshop_setup->form_value('workshop_street', true); ?>">
								</div>
							</div>
							<div class="form_group">
								<label class="form_label"> <?php _trans('lable695'); ?></label>
								<div class="form_controls">
									<select name="workshop_country" id="workshop_country" class="country bootstrap-select bootstrap-select-arrow g-input" data-live-search="true" >
										<option value="">Select Country</option>
										<?php foreach ($country_list as $countryList) { ?>
										<option value="<?php echo $countryList->id; ?>" <?php if ($countryList->id == $this->mdl_workshop_setup->form_value('workshop_country', true)) { echo 'selected'; } ?> > <?php echo $countryList->name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form_group">
								<label class="form_label"> <?php _trans('lable696'); ?></label>
								<div class="form_controls">
									<select name="workshop_state" id="workshop_state" class="state bootstrap-select bootstrap-select-arrow g-input" data-live-search="true">
										<option value="">Select State</option>
										<?php foreach ($state_list as $stateList) { ?>
										<option value="<?php echo $stateList->state_id; ?>" <?php if ($stateList->state_id == $this->mdl_workshop_setup->form_value('workshop_state', true)) { echo 'selected'; } ?> > <?php echo $stateList->state_name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form_group">
								<label class="form_label"><?php _trans('lable697'); ?></label>
								<div class="form_controls">
									<select name="workshop_city" id="workshop_city" class="bootstrap-select bootstrap-select-arrow g-input" data-live-search="true">
										<option value="">Select City</option>
										<?php foreach ($city_list as $cityList) { ?>
										<option value="<?php echo $cityList->city_id; ?>" <?php if ($cityList->city_id == $this->mdl_workshop_setup->form_value('workshop_city', true)) { echo 'selected'; } ?> > <?php echo $cityList->city_name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form_group">
								<label class="form_label"><?php _trans('lable698'); ?>*</label>
								<div class="form_controls">
									<input type="text" name="workshop_pincode" id="workshop_pincode" class="form-control"
                           				value="<?php echo $this->mdl_workshop_setup->form_value('workshop_pincode', true); ?>">
								</div>
							</div>
							<div class="form_group">
								<label class="form_label"> <?php _trans('lable699'); ?>*</label>
								<div class="form_controls">
								<?php $selected = 'selected="selected"';$registration_type = $this->mdl_workshop_setup->form_value('registration_type', true);?>
                           			<select name="registration_type" id="registration_type" class="bootstrap-select bootstrap-select-arrow g-input">
	                           			<option value=""><?php _trans("lable700"); ?></option>
										<option value="1" <?php if (1 == $registration_type) {echo $selected;} ?>>Private Ltd Company</option>
										<option value="2" <?php if (2 == $registration_type) {echo $selected;} ?>>Public Ltd Company</option>
										<option value="3" <?php if (3 == $registration_type) {echo $selected;} ?>>Unlimited Company</option>
										<option value="4" <?php if (4 == $registration_type) {echo $selected;} ?>>Sole Proprietorship/Individual</option>
										<option value="5" <?php if (5 == $registration_type) {echo $selected;} ?>>Joint Hindu Family business</option>
										<option value="6" <?php if (6 == $registration_type) {echo $selected;} ?>>Partnership</option>
										<option value="7" <?php if (7 == $registration_type) {echo $selected;} ?>>Cooperatives</option>
										<option value="8" <?php if (8 == $registration_type) {echo $selected;} ?>>Limited Liability Partnership(LLP)</option>
									</select>
								</div>
							</div>
							<div class="form_group">
								<label class="form_label"> <?php _trans('lable709'); ?></label>
								<div class="form_controls">
									<input type="text" name="registration_number" id="registration_number" class="form-control"
                           				value="<?php echo $this->mdl_workshop_setup->form_value('registration_number', true); ?>">
								</div>
							</div>
							<div class="form_group">
								<label class="form_label"> <?php _trans('lable710'); ?></label>
								<div class="form_controls">
									<input type="text" name="workshop_gstin" id="workshop_gstin" class="form-control"
                           				value="<?php echo $this->mdl_workshop_setup->form_value('workshop_gstin', true); ?>">
								</div>
							</div>
							<div class="form_group">
								<label class="form_label"> <?php _trans('lable711'); ?>*</label>
								<div class="form_controls">
									<input type="text" name="total_employee_count" id="total_employee_count" class="form-control"
										value="<?php echo $this->mdl_workshop_setup->form_value('total_employee_count', true); ?>">
								</div>
							</div>
							<div class="form_group">
								<label class="form_label"> <?php _trans('lable712'); ?>*</label>
								<div class="form_controls">
									<input type="text" name="since_from" id="since_from" class="form-control"
										value="<?php echo $this->mdl_workshop_setup->form_value('since_from', true); ?>">
								</div>
							</div>
							<div class="form_group">
								<label class="form_label"> <?php _trans('lable714'); ?>*</label>
								<div class="form_controls">
									<?php $workshop_is_enabled_inventory = $this->mdl_workshop_setup->form_value('workshop_is_enabled_inventory', true); ?>
									<select name="workshop_is_enabled_inventory" id="workshop_is_enabled_inventory" class="bootstrap-select bootstrap-select-arrow g-input">
										<option value=""></option>
										<option value="Y" <?php if ($workshop_is_enabled_inventory == 'Y') {echo $selected;} ?>>Yes</option>
										<option value="N" <?php if ($workshop_is_enabled_inventory == 'N') {echo $selected;} ?>>No</option>
									</select>
								</div>
							</div>
							<div class="form_group">
								<label class="form_label"> <?php _trans('lable715'); ?>*</label>
								<div class="form_controls">
									<?php $workshop_is_enabled_jobsheet = $this->mdl_workshop_setup->form_value('workshop_is_enabled_jobsheet', true); ?>
									<select name="workshop_is_enabled_jobsheet" id="workshop_is_enabled_jobsheet" class="boot strap-select bootstrap-select-arrow g-input">
										<option value=""></option>
										<option value="Y" <?php if ($workshop_is_enabled_jobsheet == 'Y') {echo $selected;} ?>>Yes</option>
										<option value="N" <?php if ($workshop_is_enabled_jobsheet == 'N') {echo $selected;} ?>>No</option>
									</select>
								</div>
							</div>
							<div class="form_group">
								<label class="form_label">Logo (Dimension = Width:300 * Height:100)</label>
								<div class="form_controls">
									<input type="file" name="workshop_logo" id="workshop_logo" class="g-input"
										value="<?php echo $this->mdl_workshop_setup->form_value('workshop_logo', true); ?>">
									<div class="error" id="fileError"></div>
								</div>
								<?php if ($this->mdl_workshop_setup->form_value('workshop_logo', true)) { ?>
								<img width="300" height="100" src="<?php echo base_url(); ?>uploads/workshop_logo/<?php echo $this->mdl_workshop_setup->form_value('workshop_logo', true); ?>" />
								<a href="<?php echo site_url('workshop_setup/delete_log/').$workshop_id.'/'.$this->mdl_workshop_setup->form_value('workshop_logo', true); ?>"><i class='fa fa-trash'></i> Delete </a>
								<?php } ?>
							</div>
							<div class="buttons text-center">
								<?php $this->layout->load_view('layout/header_buttons'); ?>
							</div>
						</div>
					</div>
				</div>
			</form>
        </div>
    </div>
</div>