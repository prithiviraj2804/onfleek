<script src="<?php echo base_url(); ?>assets/mp_backend/js/lib/jquery-validation/jquery.validate.min.js"></script>
<script>

var Emailinvalid = false;

function chkEmail(emailField){
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	if($("#branch_email_id").val() != ''){
			if (reg.test(emailField.value) == false) 
			{
			Emailinvalid = true;
			if(emailField.value.length > 3){
				$('.emailIdErrorr').empty().append('Invalid Email Address');
			}
			return false;
			}else{
			Emailinvalid = false;
			$('.emailIdErrorr').empty().append('');
			return true;
			}
		}else{
		Emailinvalid = false;
		$('.emailIdErrorr').empty().append('');
		return true;
		}
	}

	$(document).ready(function() {

	$("#is_product").click(function(){
		if($("#is_product:checked").is(":checked")){
			$("#is_product").val('Y');
		}else{
			$("#is_product").val('N');
		}
	});

	$("#referral").click(function(){
		if($("#referral:checked").is(":checked")){
			$("#referral").val('Y');
			$(".referralBox").show();
		}else{
			$(".referralBox").hide();
			$("#referral").val('N');
		}
	});

	$("#rewards").click(function(){
		if($("#rewards:checked").is(":checked")){
			$("#rewards").val('Y');
			$(".rewardsBox").show();
		}else{
			$(".rewardsBox").hide();
			$("#rewards").val('N');
		}
	});

	$("#invoice_terms").click(function(){
		if($("#invoice_terms:checked").is(":checked")){
			$("#invoice_terms").val('Y');
		}else{
			$("#invoice_terms").val('N');
			$("#invoice_description").val('');
		}
	});

	$("#jobs_terms").click(function(){
		if($("#jobs_terms:checked").is(":checked")){
			$("#jobs_terms").val('Y');
		}else{
			$("#jobs_terms").val('N');
			$("#job_description").val('');

		}
	});

	$("#estimate_terms").click(function(){
		if($("#estimate_terms:checked").is(":checked")){
			$("#estimate_terms").val('Y');
		}else{
			$("#estimate_terms").val('N');
			$("#estimate_description").val('');
		}
	});

	$("#btn_cancel").click(function () {
        window.location.href = "<?php echo site_url('workshop_setup'); ?>";
    });

	$(".btn_submit").click(function () {
		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');

		var validation = [];

		if($("#display_board_name").val() == ''){
			validation.push('display_board_name');
		}

		if($("#contact_person_name").val() == ''){
			validation.push('contact_person_name');
		}

		if($("#branch_contact_no").val() == ''){
			validation.push('branch_contact_no');
		}

		if($("#branch_email_id").val() == ''){
			validation.push('branch_email_id');
		}

		if($("#branch_country").val() == ''){
			validation.push('branch_country');
		}

		if($("#branch_street").val() == ''){
			validation.push('branch_street');
		}
		if($("#branch_state").val() == ''){
			validation.push('branch_state');
		}

		if($("#branch_city").val() == ''){
			validation.push('branch_city');
		}

		if($("#branch_pincode").val() == ''){
			validation.push('branch_pincode');
		}

		if($("#branch_employee_count").val() == ''){
			validation.push('branch_employee_count');
		}

		if($("#branch_since_from").val() == ''){
			validation.push('branch_since_from');
		}

		if($("#shift").val() == ''){
			validation.push('shift');
		}

		if($("#pos").val() == ''){
			validation.push('pos');
		}
		
		if($("#default_currency_id").val() == ''){
			validation.push('default_currency_id');
		}
		
		if($("#default_date_id").val() == ''){
			validation.push('default_date_id');
		}
		
		if($("#referral:checked").is(":checked")){
			if($("#referral_amount").val() == ''){
				validation.push('referral_amount');
			}
			if($("#referral_tax").val() == ''){
				validation.push('referral_tax');
			}
		}

		if($("#rewards:checked").is(":checked")){
			if($("#rewards_amount").val() == ''){
				validation.push('rewards_amount');
			}
			if($("#rewards_tax").val() == ''){
				validation.push('rewards_tax');
			}
		}

		if($("#invoice_terms:checked").is(":checked")){
			if($("#invoice_description").val() == ''){
				validation.push('invoice_description');
			}
		}

		if($("#jobs_terms:checked").is(":checked")){
			if($("#job_description").val() == ''){
				validation.push('job_description');
			}
		}

		if($("#estimate_terms:checked").is(":checked")){
			if($("#estimate_description").val() == ''){
				validation.push('estimate_description');
			}
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

		if($("#branch_email_id").val() != ''){
			if(Emailinvalid){
				$('.emailIdErrorr').empty().append('Invalid Email Address');
				$("#branch_email_id").focus();
				return false;
			}
		}

		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');

		$('#gif').show();

		$.post('<?php echo site_url('workshop_branch/ajax/save_branch'); ?>', {
			w_branch_id:$("#w_branch_id").val(),
			pos:$("#pos").val(),
            is_update : $("#is_update").val(),
            workshop_id : $('#workshop_id').val(),
			display_board_name : $("#display_board_name").val(),
			branch_gstin: $("#branch_gstin").val(),
            contact_person_name : $('#contact_person_name').val(),
			branch_contact_no : $('#branch_contact_no').val(),
			branch_email_id : $('#branch_email_id').val(),
			branch_street : $('#branch_street').val(),
			branch_country : $('#branch_country').val(),
			branch_state : $('#branch_state').val(),
			branch_city : $('#branch_city').val(),
			branch_pincode : $('#branch_pincode').val(),
			branch_employee_count : $('#branch_employee_count').val(),
			branch_since_from : $('#branch_since_from').val(),
			default_currency_id : $('#default_currency_id').val(),
			default_date_id : $("#default_date_id").val(),
			pos : $("#pos").val(),
			shift : $("#shift").val(),
			is_product : $('#is_product').val(),
			btn_submit : $(this).val(),
			referral : $('#referral').val(),
			rewards : $('#rewards').val(),
			referral_amount : $('#referral_amount').val(),
			rewards_amount : $('#rewards_amount').val(),
			referral_tax : $("#referral_tax").val(),
			rewards_tax : $("#rewards_tax").val(),
			invoice_terms : $('#invoice_terms').val(),
			invoice_description : $('#invoice_description').val(),
			jobs_terms : $('#jobs_terms').val(),
			job_description : $('#job_description').val(),
			estimate_terms : $('#estimate_terms').val(),
			estimate_description : $('#estimate_description').val(),
			_mm_csrf: $('#_mm_csrf').val()
        }, function (data) {
            list = JSON.parse(data);
            if(list.success=='1'){
                notie.alert(1, 'Successfully Created', 2);
				if(list.btn_submit == '1'){
					setTimeout(function(){
						window.location = "<?php echo site_url('workshop_branch/form'); ?>";
					}, 100);
				}else{
					setTimeout(function(){
						window.location = "<?php echo site_url('workshop_setup/index/2'); ?>";
					}, 100);
				}
            }else{
				$('#gif').hide();
				notie.alert(3, list.msg, 2);
				$('.has-error').removeClass('has-error');
                for (var key in list.validation_errors) {
                    $('#' + key).parent().addClass('has-error');
                    $('.error_msg_' + key).show().empty().html(list.validation_errors[key]);
                }
            }
        });
	});

		$('.country').change(function () {
			$('#gif').show();
            $.post("<?php echo site_url('settings/ajax/get_state_list'); ?>", {
				country_id: $('#branch_country').val(),
				_mm_csrf: $('#_mm_csrf').val()
			},
			function (data) {
				var response = JSON.parse(data);
				if (response.length > 0) {
					$('#gif').hide();
					$('#branch_state').empty(); // clear the current elements in select box
					$('#branch_state').append($('<option></option>').attr('value', '').text('Select State'));
					for (row in response) {
						$('#branch_state').append($('<option></option>').attr('value', response[row].state_id).text(response[row].state_name));
					}
					$('#branch_state').selectpicker("refresh");
				}
				else {
					$('#gif').hide();
					$('#branch_state').empty(); // clear the current elements in select box
					$('#branch_state').append($('<option></option>').attr('value', '').text('Select State'));
					$('#branch_state').selectpicker("refresh");
				}
			});
		});
		
		$('.state').change(function () {
			$('#gif').show();
            $.post("<?php echo site_url('settings/ajax/get_city_list'); ?>", {
				state_id: $('#branch_state').val(),
				_mm_csrf: $('#_mm_csrf').val()
			},
			function (data) {
				var response = JSON.parse(data);
				if (response.length > 0) {
					$('#gif').hide();
					$('#branch_city').empty(); // clear the current elements in select box
					$('#branch_city').append($('<option></option>').attr('value', '').text('Select City'));
					for (row in response) {
						$('#branch_city').append($('<option></option>').attr('value', response[row].city_id).text(response[row].city_name));
					}
					$('#branch_city').selectpicker("refresh");
				}
				else {
					$('#gif').hide();
					$('#branch_city').empty(); // clear the current elements in select box
					$('#branch_city').append($('<option></option>').attr('value', '').text('Select City'));
					$('#branch_city').selectpicker("refresh");
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
					<h3><?php _trans('lable898'); ?></h3>
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
        <div class="col-xs-12 col-md-12">
			<input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?= $this->security->get_csrf_hash(); ?>">
			<?php $this->layout->load_view('layout/alerts'); ?>
			<div class="container-wide">
				<div class="row">
					<div class="col-xs-12">
						<a class="anchor anchor-back" href="<?php echo site_url('workshop_setup/index/2'); ?>"><i class="fa fa-long-arrow-left"></i><span>Back to branch</span></a>
					</div>
				</div>
				<input class="hidden" name="w_branch_id" id="w_branch_id" type="hidden" value="<?php echo $this->mdl_workshop_branch->form_value('w_branch_id', true);?>">
				<input class="hidden" name="is_update" id="is_update" type="hidden"
				<?php if ($this->mdl_workshop_branch->form_value('is_update')) { 
					echo 'value="1"';
				} else {
					echo 'value="0"';
				} ?>>
				<div class="box">
					<div class="box_body col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form_group col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label class="form_label"> <?php _trans('lable683'); ?>*</label>
								<div class="form_controls">
									<select name="workshop_id" id="workshop_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" disabled>
										<?php  $selected = ''; foreach ($workshops as $workshop) {
											if ($workshop->workshop_id == $this->mdl_workshop_branch->form_value('workshop_id', true)) {
												$selected = 'selected="selected"';
											} else {
												$selected = '';
											} ?>
										<option value="<?php echo $workshop->workshop_id; ?>" <?php echo $selected; ?>><?php echo $workshop->workshop_name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form_group col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label class="form_label"> <?php _trans('lable762'); ?>*</label>
								<div class="form_controls">
									<input type="text" name="display_board_name" id="display_board_name" class="form-control" value="<?php echo $this->mdl_workshop_branch->form_value('display_board_name', true); ?>">
								</div>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form_group col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label class="form_label"> <?php _trans('lable763'); ?></label>
								<div class="form_controls">
									<input type="text" name="branch_gstin" id="branch_gstin" class="form-control" value="<?php echo $this->mdl_workshop_branch->form_value('branch_gstin', true); ?>">
								</div>
							</div>
							<div class="form_group col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label class="form_label"> <?php _trans('lable764'); ?>*</label>
								<div class="form_controls">
									<input type="text" name="contact_person_name" id="contact_person_name" class="form-control" value="<?php echo $this->mdl_workshop_branch->form_value('contact_person_name', true); ?>">
								</div>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form_group col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label class="form_label"> <?php _trans('lable765'); ?>*</label>
								<div class="form_controls">
									<input type="text" name="branch_contact_no" id="branch_contact_no" class="form-control" value="<?php echo $this->mdl_workshop_branch->form_value('branch_contact_no', true); ?>">
								</div>
							</div>
							<div class="form_group col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label class="form_label"> <?php _trans('lable766'); ?>*</label>
								<div class="form_controls">
									<input type="text" name="branch_email_id" id="branch_email_id" class="form-control" onblur="chkEmail(this);" value="<?php echo $this->mdl_workshop_branch->form_value('branch_email_id', true); ?>">
									<span class="error emailIdErrorr"></span>
								</div>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form_group col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label class="form_label"> <?php _trans('lable767'); ?>*</label>
								<div class="form_controls">
									<input type="text" name="branch_street" id="branch_street" class="form-control" value="<?php echo $this->mdl_workshop_branch->form_value('branch_street', true); ?>">
								</div>
							</div>
							<div class="form_group col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label class="form_label"> <?php _trans('lable768'); ?>*</label>
								<div class="form_controls">
									<select name="branch_country" id="branch_country" class="country bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" >
										<option value=""><?php _trans('lable163'); ?></option>
										<?php foreach ($country_list as $countryList) { ?>
										<option value="<?php echo $countryList->id; ?>" <?php if ($countryList->id == $this->mdl_workshop_branch->form_value('branch_country', true)) { echo 'selected'; } ?> > <?php echo $countryList->name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form_group col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label class="form_label"> <?php _trans('lable769'); ?>*</label>
								<div class="form_controls">
									<select name="branch_state" id="branch_state" class="state bootstrap-select bootstrap-select-arrow removeError form-control" data-live-search="true">
										<option value=""><?php _trans('lable164'); ?></option>
										<?php foreach ($state_list as $stateList) { ?>
										<option value="<?php echo $stateList->state_id; ?>" <?php if ($stateList->state_id == $this->mdl_workshop_branch->form_value('branch_state', true)) { echo 'selected'; } ?> > <?php echo $stateList->state_name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form_group col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label class="form_label"><?php _trans('lable770'); ?>*</label>
								<div class="form_controls">
									<select name="branch_city" id="branch_city" class="bootstrap-select bootstrap-select-arrow removeError form-control" data-live-search="true">
										<option value=""><?php _trans('lable165'); ?></option>
										<?php foreach ($city_list as $cityList) { ?>
										<option value="<?php echo $cityList->city_id; ?>" <?php if ($cityList->city_id == $this->mdl_workshop_branch->form_value('branch_city', true)) { echo 'selected'; } ?> > <?php echo $cityList->city_name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form_group col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label class="form_label"><?php _trans('lable1017'); ?>*</label>
								<div class="form_controls">
									<input type="text" name="branch_pincode" id="branch_pincode" class="form-control" value="<?php echo $this->mdl_workshop_branch->form_value('branch_pincode', true); ?>">
								</div>
							</div>
							<div class="form_group col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label class="form_label"> <?php _trans('lable771'); ?>*</label>
								<div class="form_controls">
									<input type="text" name="branch_employee_count" id="branch_employee_count" class="form-control" value="<?php echo $this->mdl_workshop_branch->form_value('branch_employee_count', true); ?>">
								</div>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form_group col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label class="form_label"> <?php _trans('lable712'); ?>*</label>
								<div class="form_controls">
									<input type="text" name="branch_since_from" id="branch_since_from" class="form-control" value="<?php echo $this->mdl_workshop_branch->form_value('branch_since_from', true); ?>">
								</div>
							</div>
							<div class="form_group col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label class="form_label"><?php _trans('lable151'); ?>*</label>
								<div class="form_controls">
									<select name="shift" id="shift" class="bootstrap-select bootstrap-select-arrow form-control removeError">
										<option value=""><?php _trans('lable152');?></option>
										<option value="1" <?php if ($this->mdl_workshop_branch->form_value('shift', true) == '1') {echo $selected;} ?>>Normal</option>
										<option value="2" <?php if ($this->mdl_workshop_branch->form_value('shift', true) == '2') {echo $selected;} ?>>24/7</option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form_group col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label class="form_label"><?php _trans('lable587'); ?>*</label>
								<div class="form_controls">
									<select name="pos" id="pos" class="bootstrap-select bootstrap-select-arrow form-control removeError">
										<option value=""></option>
										<option value="Y" <?php if ($this->mdl_workshop_branch->form_value('pos', true) == 'Y') {echo $selected;} ?>>Yes</option>
										<option value="N" <?php if ($this->mdl_workshop_branch->form_value('pos', true) == 'N') {echo $selected;} ?>>No</option>
									</select>
								</div>
							</div>
							<div class="form_group col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label class="form_label"><?php _trans('lable720'); ?>*</label>
								<div class="form_controls">
									<select name="default_currency_id" id="default_currency_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true">
										<option value=""><?php _trans('lable165'); ?></option>
										<?php foreach ($currency_list as $currencyList) { ?>
										<option value="<?php echo $currencyList->currency_id; ?>" <?php if ($currencyList->currency_id == $this->mdl_workshop_branch->form_value('default_currency_id', true)) { echo 'selected'; } ?> > <?php echo $currencyList->cry_iso_code; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>	
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form_group col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<label class="form_label"><?php _trans('lable854'); ?>*</label>
								<div class="form_controls">
									<select name="default_date_id" id="default_date_id" class="bootstrap-select bootstrap-select-arrow form-control" data-live-search="true">
										<?php foreach ($date_list as $dateList) { ?>
										<option value="<?php echo $dateList->mech_date_id; ?>" <?php if ($dateList->mech_date_id == $this->mdl_workshop_branch->form_value('default_date_id', true)) { echo 'selected'; } ?> > <?php echo $dateList->date_formate; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<?php if($this->session->userdata('plan_type') != 3){ ?>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form_controls col-lg-1 col-md-1 col-sm-1 col-xs-1 paddingTop20px">
									<input type="checkbox" class="is_product" id="is_product" <?php if($this->mdl_workshop_branch->form_value('is_product', true) == 'Y'){echo "checked";}?> name="is_product" value="<?php echo $this->mdl_workshop_branch->form_value('is_product', true); ?>" >
								</div>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 text_align_left paddingTop15px"><?php _trans('lable722'); ?></div>
							</div>
						<?php } else { ?>
							<input type="hidden" class="is_product" id="is_product" checked name="is_product" value="Y" >
						<?php } ?>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 my_15px">
							<div class="form_group col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 paddingLeft0px paddingTop10px">
									<input type="checkbox" class="checkbox" <?php if($this->mdl_workshop_branch->form_value('referral', true) == 'Y'){ echo "checked"; } ?> name="checkbox" id="referral" value="<?php echo $this->mdl_workshop_branch->form_value('referral', true); ?>">
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text_align_left paddingTop7px"><?php _trans('lable773'); ?></div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text_align_left padding0px referralBox" id="referralBox"  <?php if($this->mdl_workshop_branch->form_value('referral', true) == 'Y'){ echo 'style="display:block"'; }else{ echo 'style="display:none"'; } ?>>
									<div class="form_controls">
										<input type="text" name="referral_amount" id="referral_amount" class="form-control" value="<?php echo $this->mdl_workshop_branch->form_value('referral_amount', true); ?>">
									</div>
								</div>
								<div class="form_group col-lg-12 col-md-12 col-sm-12 col-xs-12 padding0px referralBox" <?php if($this->mdl_workshop_branch->form_value('referral', true) == 'Y'){ echo 'style="display:block"'; }else{ echo 'style="display:none"'; } ?>>
									<label class="form_label"><?php _trans('lable774'); ?></label>
									<div class="form_controls">
										<select name="referral_tax" id="referral_tax" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true">
											<option value=""><?php _trans('lable775'); ?></option>
											<option value="I" <?php if($this->mdl_workshop_branch->form_value('referral_tax', true) == 'I'){ echo "selected";} ?>><?php _trans('lable776'); ?></option>
											<option value="E" <?php if($this->mdl_workshop_branch->form_value('referral_tax', true) == 'E'){ echo "selected";} ?>><?php _trans('lable777'); ?></option>
										</select>
									</div>
								</div>
							</div>
							<div class="form_group col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 paddingLeft0px paddingTop10px">
									<input type="checkbox" class="checkbox" <?php if($this->mdl_workshop_branch->form_value('rewards', true) == 'Y'){ echo "checked"; } ?> name="checkbox" id="rewards" value="<?php echo $this->mdl_workshop_branch->form_value('rewards', true); ?>">
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text_align_left paddingTop7px"><?php _trans('lable779'); ?></div>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text_align_left padding0px rewardsBox" id="rewardsBox" <?php if($this->mdl_workshop_branch->form_value('rewards', true) == 'Y'){ echo 'style="display:block"'; }else{ echo 'style="display:none"'; } ?> >
									<div class="form_controls">
										<input type="text" name="rewards_amount" id="rewards_amount" class="form-control" value="<?php echo $this->mdl_workshop_branch->form_value('rewards_amount', true); ?>">
									</div>
								</div>
								<div class="form_group col-lg-12 col-md-12 col-sm-12 col-xs-12 padding0px rewardsBox" <?php if($this->mdl_workshop_branch->form_value('rewards', true) == 'Y'){ echo 'style="display:block"'; }else{ echo 'style="display:none"'; } ?>>
									<label class="form_label"><?php _trans('lable778'); ?></label>
									<div class="form_controls">
										<select name="rewards_tax" id="rewards_tax" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true">
											<option value=""><?php _trans('lable775'); ?></option>
											<option value="I" <?php if($this->mdl_workshop_branch->form_value('rewards_tax', true) == 'I'){ echo "selected";} ?> ><?php _trans('lable776'); ?></option>
											<option value="E" <?php if($this->mdl_workshop_branch->form_value('rewards_tax', true) == 'E'){ echo "selected";} ?>><?php _trans('lable777'); ?></option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 my_15px">
							<div class="form_group col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 paddingLeft0px paddingTop10px">
									<input type="checkbox" class="checkbox" <?php if($this->mdl_workshop_branch->form_value('invoice_terms', true) == 'Y'){ echo "checked"; } ?> name="checkbox" id="invoice_terms" value="<?php echo $this->mdl_workshop_branch->form_value('invoice_terms', true); ?>">
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text_align_left paddingTop7px"><?php _trans('lable119'); ?></div>
								<div class="form_group col-lg-12 col-md-12 col-sm-12 col-xs-12 padding0px">
									<label class="form_label"><?php _trans('lable388'); ?></label>
									<div class="form_controls">
									     <textarea name="invoice_description" id="invoice_description" class="form-control"><?php echo $this->mdl_workshop_branch->form_value('invoice_description', true); ?></textarea>
									</div>
								</div>
							</div>
							<div class="form_group col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 paddingLeft0px paddingTop10px">
									<input type="checkbox" class="checkbox" <?php if($this->mdl_workshop_branch->form_value('jobs_terms', true) == 'Y'){ echo "checked"; } ?> name="checkbox" id="jobs_terms" value="<?php echo $this->mdl_workshop_branch->form_value('jobs_terms', true); ?>">
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text_align_left paddingTop7px"><?php _trans('lable269'); ?></div>
								<div class="form_group col-lg-12 col-md-12 col-sm-12 col-xs-12 padding0px">
									<label class="form_label"><?php _trans('lable388'); ?></label>
									<div class="form_controls">
									      <textarea name="job_description" id="job_description" class="form-control"><?php echo $this->mdl_workshop_branch->form_value('job_description', true); ?></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 my_15px">
							<div class="form_group col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 paddingLeft0px paddingTop10px">
									<input type="checkbox" class="checkbox" <?php if($this->mdl_workshop_branch->form_value('estimate_terms', true) == 'Y'){ echo "checked"; } ?> name="checkbox" id="estimate_terms" value="<?php echo $this->mdl_workshop_branch->form_value('estimate_terms', true); ?>">
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text_align_left paddingTop7px"><?php _trans('lable837'); ?></div>
								<div class="form_group col-lg-12 col-md-12 col-sm-12 col-xs-12 padding0px">
									<label class="form_label"><?php _trans('lable388'); ?></label>
									<div class="form_controls">
									     <textarea name="estimate_description" id="estimate_description" class="form-control"><?php echo $this->mdl_workshop_branch->form_value('estimate_description', true); ?></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTopBot10px">
							<div class="buttons text-center paddingTopBot10px">
								<button value="1" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
									<i class="fa fa-check"></i> <?php _trans('lable56'); ?>
								</button>
								<button value="2" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
									<i class="fa fa-check"></i> <?php _trans('lable57'); ?>
								</button>
								<button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default">
									<i class="fa fa-times"></i><?php _trans('lable58'); ?>
								</button>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
