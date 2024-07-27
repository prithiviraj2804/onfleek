<?php $employee_url_key = $this->mdl_mech_employee->form_value('url_key', true)?$this->mdl_mech_employee->form_value('url_key', true):$this->mdl_mech_employee->get_url_key();?>
<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php echo _trans($breadcrumb); ?><?php echo ($this->mdl_mech_employee->form_value('employee_no', true)?" (".$this->mdl_mech_employee->form_value('employee_no', true).") ":''); ?></h3>
				</div>
				<div class="tbl-cell pull-right">
					<a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_employee/form'); ?>">
						<i class="fa fa-plus"></i> <?php _trans('lable40'); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</header>
<script type="text/javascript">
var phonenumberexist = '';
var emailexist = '';
var usermobileinvalid = false;
var userEmailinvalid = false;

function create_datepicker_onchange(){
	
	var date2 = $('#date_of_birth').datepicker('getDate', '+6570d');
	date2.setDate(date2.getDate()+6570);
	var lastDate = new Date();
	$('#date_of_joining').datepicker('setEndDate', lastDate);
	$('#date_of_joining').datepicker('setStartDate',date2);
	
}  

function mobilenocheckup()
    {
	 $.post('<?php echo site_url('mech_employee/ajax/twotablephonenoexist'); ?>', {
		user_mobile : $("#user_mobile").val(),
		_mm_csrf: $('#_mm_csrf').val()
	 },
	 function (data) 
	 {	
		response = JSON.parse(data);
            if(response.success == 1)
			{
				usermobileinvalid = true;
				phonenumberexist = response.success;
				$("#showErrorphone").empty().append('Mobile Number Already Exist');
				return false;
			}
			else
			{
				usermobileinvalid = false;
				phonenumberexist = response.success;
				$("#showErrorphone").empty().append('');
            }
        });
	}
	
	function emailcheckup()
    {
	 $.post('<?php echo site_url('mech_employee/ajax/twotableemailexist'); ?>', {
		user_email : $("#user_email").val(),
		_mm_csrf: $('#_mm_csrf').val()
	 },
	 function (data) 
	 {	
		response = JSON.parse(data);
            if(response.success == 1)
			{
				userEmailinvalid = true;
				emailexist = response.success;
				$("#showErroremail").empty().append('Email Already Exist');
				return false;
			}
			else
			{
				userEmailinvalid = false;
				emailexist = response.success;
				$("#showErroremail").empty().append('');
            }
        });
    }

function showOtpButton(){
	if($("#user_branch_id").val() != '' && $("#user_branch_id").val() != null && $("#user_name").val() != '' && $("#user_mobile").val() != '' && $("#user_email").val() != '' && $("#password").val() != '' &&$("#confirm_password").val() != ''){
		$("#otpform").show();
	}else{
		$("#otpform").hide();
	}
}

function otp_submit(){
	get_otp();
}

function resendotp(){
	$("#otp").val('');
	$.post("<?php echo site_url('mech_employee/ajax/resendotp'); ?>", {
		user_email: $('#user_email').val(),
		user_mobile: $('#user_mobile').val(),
		_mm_csrf: $('#_mm_csrf').val()
	},function (data) {
		
		var response = JSON.parse(data);
		if ((response.success) == '0') {

		}else {
			$('#otp').val();
		}
	});
}

function validateEmail(sEmail) {
	var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	if (filter.test(sEmail)) {
		return true;
	}
	else {
		return false;
	}
}

function validatePhone(txtPhone) {
	var filter = /^[0-9-+]+$/;
	if (filter.test(txtPhone)) {
		return true;
	}
	else {
		return false;
	}
}

function get_otp(){
	$("#otp").val('');
	var validation = [];

	if($('#user_name').val() == ''){
		validation.push('user_name');
	}

	if($('#user_mobile').val() == ''){
		validation.push('user_mobile');
	}else{
		if (!validatePhone($('#user_mobile').val())) {
			validation.push('user_mobile');
		}
	}

	if($('#user_email').val() == ''){
		validation.push('user_email');
	}else{
		if (!validateEmail($('#user_email').val())) {
			validation.push('user_email');
		}
	}

	if($('#user_branch_id').val() == '' || $('#user_branch_id').val() == null){
		validation.push('user_branch_id');
	}

	if($('#password').val() == ''){
		validation.push('password');
	}

	if($('#confirm_password').val() == ''){
		validation.push('confirm_password');
	}

	if(validation.length > 0){
		validation.forEach(function(val) {
			$('#'+val).addClass("border_error");
			if($('#'+val+'_error').length == 0){
				$("#"+val).parent().append("<span id="+val+"_error class=color-red style=padding-bottom:20px>This field is required</span>");
			} 
		});
		return false;
	}

	$("#user_password_errmsg").hide();
	var password = $('#password').val();

	if(password.length < 8 ){
		$("#user_password_errmsg").show();		
		$('#user_password_errmsg').empty().append('Invalid Password');
		return false;
	} else {
	    $('#user_password_errmsg').empty().append('');
		$("#user_password_errmsg").hide();
	}

   	if(password.match(/[A-Z]/)) {
		$('#user_password_errmsg').empty().append('');
		$("#user_password_errmsg").hide();
	} else {
		$("#user_password_errmsg").show();
		$('#user_password_errmsg').empty().append('Atleast one Caps letter');
		return false;
	}

	if (password.match(/\d/) ) {
		$('#user_password_errmsg').empty().append('');
		$("#user_password_errmsg").hide();
	} else {
		$("#user_password_errmsg").show();
	    $('#user_password_errmsg').empty().append('Atleast one numeric');
		return false;
	}
	
  	if(password.match(/[~`!@#$%^&*()-_+={}[|\;:"<>,./?]/)) {
		$('#user_password_errmsg').empty().append('');
		$("#user_password_errmsg").hide();
	} else {
		$("#user_password_errmsg").show();
  		$('#user_password_errmsg').empty().append('Atleast one special character');
		return false;
	}

  	if(password.length==0)
	{
		$('#user_password_errmsg').empty().append('');
		$("#user_password_errmsg").hide();
	}

	$('#user_passwordv_errmsg').show();
	if ($('#password').val() == $('#confirm_password').val()) {
		$('#user_passwordv_errmsg').empty().append('');
		$('#user_passwordv_errmsg').hide();
	}else {
		$('#user_passwordv_errmsg').show();
		$('#user_passwordv_errmsg').empty().append('Password did not Match');
		return false;
	}

	if($("#user_mobile").val() != ''){
		if(usermobileinvalid){
			$('#showErrormobile').empty().append('Mobile Number Already Exist');
			$("#user_mobile").focus();
			return false;
		}
	}

	if($("#user_email").val() != ''){
			if(userEmailinvalid){
				$('showErroremail').empty().append('Email Already Exist');
				$("#user_email").focus();
				return false;
			}
		}

	$('#gif').show();

	var permissionArray = [];
		
	$("#checkinListDatas .multi-field").each(function(){
		var requestObj = {};
		requestObj.module_id = $(this).find(".module_id").val();
		requestObj.permission_id = $(this).find(".permission_id").val();
		requestObj.status = $(this).find(".permission_status").val();
		permissionArray.push(requestObj);
	});


	if($('#user_mobile').val() != ''){
		$.post("<?php echo site_url('mech_employee/ajax/generate_signup_otp'); ?>", {
			employee_id : $("#employee_id").val(),
			employee_account_checkbox : $("#employee_account_checkbox").val(),
			user_name: $("#user_name").val(),
			user_company: $("#user_company").val(),
			user_mobile: $('#user_mobile').val(),
			user_email: $('#user_email').val(),
			branch_id: $('#branch_id').val(),
			user_branch_id : $("#user_branch_id").val(),
			user_password: $('#password').val(),
			user_passwordv: $('#confirm_password').val(),
			permissionArray: JSON.stringify(permissionArray),
			_mm_csrf: $('#_mm_csrf').val()
		},function (data) {
			var response = JSON.parse(data);
			if ((response.success) == '0') {
				$('#validation_error').empty().html(response.error.error_msg);
			}else {
				$("#user_email").attr('readonly',true);
				$("#user_mobile").attr('readonly',true);
				$("#password").attr('readonly',true);
				$("#confirm_password").attr('readonly',true);
				$('#validation_error').empty().html('');
				$('#otpform').hide();
				$("#signupform").show();
				$("#otp_div").show();     
			}
			$('#gif').hide();
		});
	}else{
		$('#validation_error').empty().html('Phone number is empty');
	}
}

function signup_submit(){
	var otp = $('#otp').val();
	var validation = [];

	if($('#user_name').val() == ''){
		validation.push('user_name');
	}

	if($('#user_branch_id').val() == '' || $('#user_branch_id').val() == null ){
		validation.push('user_branch_id');
	}

	if($('#user_mobile').val() == ''){
		validation.push('user_mobile');
	}else{
		if (!validatePhone($('#user_mobile').val())) {
			validation.push('user_mobile');
		}
	}

	if($('#user_email').val() == ''){
		validation.push('user_email');
	}else{
		if (!validateEmail($('#user_email').val())) {
			validation.push('user_email');
		}
	}

	if($('#password').val() == ''){
		validation.push('password');
	}

	if($('#confirm_password').val() == ''){
		validation.push('confirm_password');
	}

	if(validation.length > 0){
		validation.forEach(function(val) {
			$('#'+val).addClass("border_error");
			if($('#'+val+'_error').length == 0){
				$("#"+val).parent().append("<span id="+val+"_error class=color-red style=padding-bottom:20px>This field is required</span>");
			} 
		});
		return false;
	}

	$("#user_password_errmsg").hide();
	var password = $('#password').val();

	if(password.length < 8 ){
		$("#user_password_errmsg").show();		
		$('#user_password_errmsg').empty().append('Invalid Password');
		return false;
	} else {
	    $('#user_password_errmsg').empty().append('');
		$("#user_password_errmsg").hide();
	}

   	if(password.match(/[A-Z]/)) {
		$('#user_password_errmsg').empty().append('');
		$("#user_password_errmsg").hide();
	} else {
		$("#user_password_errmsg").show();
		$('#user_password_errmsg').empty().append('Atleast one Caps letter');
		return false;
	}

	if (password.match(/\d/) ) {
		$('#user_password_errmsg').empty().append('');
		$("#user_password_errmsg").hide();
	} else {
		$("#user_password_errmsg").show();
	    $('#user_password_errmsg').empty().append('Atleast one numeric');
		return false;
	}
	
  	if(password.match(/[~`!@#$%^&*()-_+={}[|\;:"<>,./?]/)) {
		$('#user_password_errmsg').empty().append('');
		$("#user_password_errmsg").hide();
	} else {
		$("#user_password_errmsg").show();
  		$('#user_password_errmsg').empty().append('Atleast one special character');
		return false;
	}

  	if(password.length==0)
	{
		$('#user_password_errmsg').empty().append('');
		$("#user_password_errmsg").hide();
	}

	$('#user_passwordv_errmsg').show();
	if ($('#password').val() == $('#confirm_password').val()) {
		$('#user_passwordv_errmsg').empty().append('');
		$('#user_passwordv_errmsg').hide();
	}else {
		$('#user_passwordv_errmsg').show();
		$('#user_passwordv_errmsg').empty().append('Password did not Match');
		return false;
	}

	if($("#user_mobile").val() != ''){
		if(usermobileinvalid){
			$('#showErrormobile').empty().append('Mobile Number Already Exist');
			$("#user_mobile").focus();
			return false;
		}
	}

	if($("#user_email").val() != ''){
			if(userEmailinvalid){
				$('showErroremail').empty().append('Email Already Exist');
				$("#user_email").focus();
				return false;
			}
		}

	$('#gif').show();

	var permissionArray = [];
		
	$("#checkinListDatas .multi-field").each(function(){
		var requestObj = {};
		requestObj.module_id = $(this).find(".module_id").val();
		requestObj.permission_id = $(this).find(".permission_id").val();
		requestObj.status = $(this).find(".permission_status").val();
		permissionArray.push(requestObj);
	});

	if($('#user_mobile').val() != ""){
		$.post("<?php echo site_url('mech_employee/ajax/submit_signup'); ?>", {
			emp_id : $("#employee_id").val(),
			employee_account_checkbox : $("#employee_account_checkbox").val(),
			user_name: $("#user_name").val(),
			user_company: $("#user_company").val(),
			user_mobile: $('#user_mobile').val(),
			user_email: $('#user_email').val(),
			branch_id : $("#branch_id").val(),
			user_branch_id : $("#user_branch_id").val(),
			user_password: $('#password').val(),
			user_passwordv: $('#confirm_password').val(),
			permissionArray: JSON.stringify(permissionArray),
			from:'signup',
			otp: $('#otp').val(),
			_mm_csrf: $('#_mm_csrf').val()
		},function (data) {
			var response = JSON.parse(data);
			if ((response.success) == '0') {
				if(response.msg){
					$('#gif').hide();
					$('#validation_error').empty().html(response.msg);
				}else{
					$('#gif').hide();
					$('#validation_error').empty().html(response.msg);
				}
			}else{
				$('#validation_error').empty().html('');
				notie.alert(1, 'Successfully Created', 2);
				setTimeout(function(){
					window.location = "<?php echo site_url('mech_employee/form'); ?>/"+response.employee_id+"/7";
				}, 100);
			}
		});
	}else{
		$('#gif').hide();
		// $('#validation_error').empty().html('Login details is empty');
	}
}


function deactivateEmployeeUser(){
	var permissionArray = [];
	$("#checkinListDatas .multi-field").each(function(){
		var requestObj = {};
		requestObj.module_id = $(this).find(".module_id").val();
		requestObj.permission_id = $(this).find(".permission_id").val();
		requestObj.status = $(this).find(".permission_status").val();
		permissionArray.push(requestObj);
	});

	$('#gif').show();

	$.post("<?php echo site_url('mech_employee/ajax/updateEmployeeUserDetails'); ?>", {
		emp_id : $("#employee_id").val(),
		employee_account_checkbox : $("#employee_account_checkbox").val(),
		user_branch_id : $("#user_branch_id").val(),
		permissionArray: JSON.stringify(permissionArray),
		_mm_csrf: $('#_mm_csrf').val()
	},function (data) {
		var response = JSON.parse(data);
		$('#gif').hide();
		if (response.success == 1) {
			notie.alert(1, 'Successfully Saved', 2);
			if($("#employee_account_checkbox").val() == 1){
				setTimeout(function(){
					window.location = "<?php echo site_url('mech_employee/form'); ?>/"+response.employee_id+"/7";
				}, 100);
			}
		}
	});
}
</script>
<?php if (isset($active_tab)) {
    if ($active_tab == 1) {
        $one_tab_active = 'active show in';
        $two_tab_active = '';
        $three_tab_active = '';
        $four_tab_active = '';
        $five_tab_active = '';
		$six_tab_active = '';
		$seven_tab_active = '';
        $one_area_selected = true;
        $two_area_selected = false;
        $three_area_selected = false;
        $four_area_selected = false;
        $five_area_selected = false;
		$six_area_selected = false;
		$seven_area_selected = false;
    } else if ($active_tab == 2) {
        $one_tab_active = '';
        $two_tab_active = 'active show in';
        $three_tab_active = '';
        $four_tab_active = '';
        $five_tab_active = '';
		$six_tab_active = '';
		$seven_tab_active = '';
        $one_area_selected = false;
        $two_area_selected = true;
        $three_area_selected = false;
        $four_area_selected = false;
        $five_area_selected = false;
		$six_area_selected = false;
		$seven_area_selected = false;
    } else if ($active_tab == 3) {
        $one_tab_active = '';
        $two_tab_active = '';
        $three_tab_active = 'active show in';
        $four_tab_active = '';
        $five_tab_active = '';
		$six_tab_active = '';
		$seven_tab_active = '';
        $one_area_selected = false;
        $two_area_selected = false;
        $three_area_selected = true;
        $four_area_selected = false;
        $five_area_selected = false;
		$six_area_selected = false;
		$seven_area_selected = false;
    } else if ($active_tab == 4) {
        $one_tab_active = '';
        $two_tab_active = '';
        $three_tab_active = '';
        $four_tab_active = 'active show in';
        $five_tab_active = '';
		$six_tab_active = '';
		$seven_tab_active = '';
        $one_area_selected = false;
        $two_area_selected = false;
        $three_area_selected = false;
        $four_area_selected = true;
        $five_area_selected = false;
		$six_area_selected = false;
		$seven_area_selected = false;
    } else if ($active_tab == 5) {
        $one_tab_active = '';
        $two_tab_active = '';
        $three_tab_active = '';
        $four_tab_active = '';
        $five_tab_active = 'active show in';
		$six_tab_active = '';
		$seven_tab_active = '';
        $one_area_selected = false;
        $two_area_selected = false;
        $three_area_selected = false;
        $four_area_selected = false;
        $five_area_selected = true;
		$six_area_selected = false;
		$seven_area_selected = false;
    } else if ($active_tab == 6) {
        $one_tab_active = '';
        $two_tab_active = '';
        $three_tab_active = '';
        $four_tab_active = '';
        $five_tab_active = '';
		$six_tab_active = 'active show in';
		$seven_tab_active = '';
        $one_area_selected = false;
        $two_area_selected = false;
        $three_area_selected = false;
        $four_area_selected = false;
        $five_area_selected = false;
		$six_area_selected = true;
		$seven_area_selected = false;
    }else if ($active_tab == 7) {
        $one_tab_active = '';
        $two_tab_active = '';
        $three_tab_active = '';
        $four_tab_active = '';
        $five_tab_active = '';
		$six_tab_active = '';
		$seven_tab_active = 'active show in';
        $one_area_selected = false;
        $two_area_selected = false;
        $three_area_selected = false;
        $four_area_selected = false;
        $five_area_selected = false;
		$six_area_selected = false;
		$seven_area_selected = true;
    }
} else {
    $one_tab_active = 'active show in';
    $two_tab_active = '';
    $three_tab_active = '';
    $four_tab_active = '';
    $five_tab_active = '';
	$six_tab_active = '';
	$seven_tab_active = '';
    $one_area_selected = true;
    $two_area_selected = false;
    $three_area_selected = false;
    $four_area_selected = false;
    $five_area_selected = false;
	$six_area_selected = false;
	$seven_area_selected = false;
}
?>
<div id="content" class="usermanagement">
	<div class="row">
		<div id="gif" class="gifload">
			<div class="gifcenter">
			  <center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
		    </div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 top-15">
			<a class="anchor anchor-back" onclick="goBack()" href="<?php echo site_url('mech_employee/index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
		</div>
	</div>
    <div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 ipadview">
			<div class="nav nav-tabs">
				<div class="tbl">
					<ul class="nav" role="tablist">
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $one_tab_active; ?>" href="#tabs-2-tab-1" role="tab" data-toggle="tab" aria-selected="<?php echo $one_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable60'); ?></span>
							</a>
						</li>
						<?php if ($this->mdl_mech_employee->form_value('employee_id', true)) {
    	?>
						<li class="nav-item">
								<a class="navListlink nav-link <?php echo $three_tab_active; ?>" href="#tabs-2-tab-2" role="tab" data-toggle="tab" aria-selected="<?php echo $three_area_selected; ?>">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable144'); ?></span>
									<span class="rightCountipad label label-pill label-success"><?php echo count($employee_skill_list); ?></span>
								</a>
							</li>
							<li class="nav-item">
								<a class="navListlink nav-link <?php echo $two_tab_active; ?> " href="#tabs-2-tab-3" role="tab" data-toggle="tab" aria-selected="<?php echo $two_area_selected; ?>">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable94'); ?></span>
									<span class="rightCountipad label label-pill label-success"><?php echo count($workshop_bank_list); ?></span>
								</a>
							</li>
							<li class="nav-item">	
								<a class="navListlink nav-link <?php echo $four_tab_active; ?> " href="#tabs-2-tab-4" role="tab" data-toggle="tab" aria-selected="<?php echo $four_area_selected; ?>">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable145'); ?></span>
									<span class="rightCountipad label label-pill label-success"><?php echo count($employee_experience_list); ?></span>
								</a>
							</li>

							<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#tabs" role="button" aria-haspopup="true" aria-expanded="false">Dropdown</a>
							<div class="dropdown-menu">
								<a style="width: 100%;float: left;" class="dropdown-item ipad_dropdown <?php echo $five_tab_active; ?> " href="#tabs-2-tab-5" role="tab" data-toggle="tab" aria-selected="<?php echo $five_area_selected; ?>">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable146'); ?></span>
									<span class="rightCountipaddropdown label label-pill label-success" id="employeeDocumentCount"><?php echo count($employee_document_list); ?></span>
								</a>
								<a style="width: 100%;float: left;" class="dropdown-item ipad_dropdown <?php echo $six_tab_active; ?> " href="#tabs-2-tab-6" role="tab" data-toggle="tab" aria-selected="<?php echo $six_area_selected; ?>">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable68'); ?></span>
									<span class="rightCountipaddropdown label label-pill label-success"><?php echo count($employee_custom_list); ?></span>
								</a>
							<?php if($this->session->userdata('user_type') == 3){ ?>
								<a style="width: 100%;float: left;" class="dropdown-item ipad_dropdown <?php echo $seven_tab_active; ?> " href="#tabs-2-tab-7" role="tab" data-toggle="tab" aria-selected="<?php echo $seven_area_selected; ?>">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable147'); ?></span>
								</a>
							<?php } ?>
							</div>
  						</li>

						<?php
						}  else { ?>
						
						    <li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable144'); ?></span>
									<span class="rightCountSpan label label-pill label-success"><?php echo count($employee_skill_list); ?></span>
								</a>
							</li>
							<li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab" >
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable94'); ?></span>
									<span class="rightCountSpan label label-pill label-success"><?php echo count($workshop_bank_list); ?></span>
								</a>
							</li>
							<li class="nav-item">	
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable145'); ?></span>
									<span class="rightCountSpan label label-pill label-success"><?php echo count($employee_experience_list); ?></span>
								</a>
							</li>
							<li class="nav-item not-allowed">	
								<a class="navListlink nav-link" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable146'); ?></span>
									<span class="rightCountSpan label label-pill label-success"><?php echo count($employee_document_list); ?></span>
								</a>
							</li>
							<li class="nav-item not-allowed">	
								<a class="navListlink nav-link" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable68'); ?></span>
									<span class="rightCountSpan label label-pill label-success"><?php echo count($employee_custom_list); ?></span>
								</a>
							</li>
							<?php if($this->session->userdata('user_type') == 3){ ?>
							<li class="nav-item not-allowed">	
								<a class="navListlink nav-link" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable147'); ?></span>
								</a>
							</li>
							<?php } ?>
						<?php }?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-xs-12 smallPortion desktopview">
			<div class="tabs-section-nav">
				<div class="tbl">
					<ul class="nav" role="tablist">
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $one_tab_active; ?>" href="#tabs-2-tab-1" role="tab" data-toggle="tab" aria-selected="<?php echo $one_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable60'); ?></span>
							</a>
						</li>
						<?php if ($this->mdl_mech_employee->form_value('employee_id', true)) {
    	?>
						<li class="nav-item">
								<a class="navListlink nav-link <?php echo $three_tab_active; ?>" href="#tabs-2-tab-2" role="tab" data-toggle="tab" aria-selected="<?php echo $three_area_selected; ?>">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable144'); ?></span>
									<span class="rightCountSpan label label-pill label-success"><?php echo count($employee_skill_list); ?></span>
								</a>
							</li>
							<li class="nav-item">
								<a class="navListlink nav-link <?php echo $two_tab_active; ?> " href="#tabs-2-tab-3" role="tab" data-toggle="tab" aria-selected="<?php echo $two_area_selected; ?>">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable94'); ?></span>
									<span class="rightCountSpan label label-pill label-success"><?php echo count($workshop_bank_list); ?></span>
								</a>
							</li>
							<li class="nav-item">	
								<a class="navListlink nav-link <?php echo $four_tab_active; ?> " href="#tabs-2-tab-4" role="tab" data-toggle="tab" aria-selected="<?php echo $four_area_selected; ?>">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable145'); ?></span>
									<span class="rightCountSpan label label-pill label-success"><?php echo count($employee_experience_list); ?></span>
								</a>
							</li>
							<li class="nav-item">	
								<a class="navListlink nav-link <?php echo $five_tab_active; ?> " href="#tabs-2-tab-5" role="tab" data-toggle="tab" aria-selected="<?php echo $five_area_selected; ?>">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable146'); ?></span>
									<span class="rightCountSpan label label-pill label-success" id="employeeDocumentCount"><?php echo count($employee_document_list); ?></span>
								</a>
							</li>
							
							<li class="nav-item">	
								<a class="navListlink nav-link <?php echo $six_tab_active; ?> " href="#tabs-2-tab-6" role="tab" data-toggle="tab" aria-selected="<?php echo $six_area_selected; ?>">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable68'); ?></span>
									<span class="rightCountSpan label label-pill label-success"><?php echo count($employee_custom_list); ?></span>
								</a>
							</li>
							<?php if($this->session->userdata('user_type') == 3){ ?>
							<li class="nav-item">	
								<a class="navListlink nav-link <?php echo $seven_tab_active; ?> " href="#tabs-2-tab-7" role="tab" data-toggle="tab" aria-selected="<?php echo $seven_area_selected; ?>">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable147'); ?></span>
								</a>
							</li>
							<?php } ?>
						<?php
						}  else { ?>
						
						    <li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable144'); ?></span>
									<span class="rightCountSpan label label-pill label-success"><?php echo count($employee_skill_list); ?></span>
								</a>
							</li>
							<li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab" >
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable94'); ?></span>
									<span class="rightCountSpan label label-pill label-success"><?php echo count($workshop_bank_list); ?></span>
								</a>
							</li>
							<li class="nav-item">	
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable145'); ?></span>
									<span class="rightCountSpan label label-pill label-success"><?php echo count($employee_experience_list); ?></span>
								</a>
							</li>
							<li class="nav-item not-allowed">	
								<a class="navListlink nav-link" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable146'); ?></span>
									<span class="rightCountSpan label label-pill label-success"><?php echo count($employee_document_list); ?></span>
								</a>
							</li>
							<li class="nav-item not-allowed">	
								<a class="navListlink nav-link" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable68'); ?></span>
									<span class="rightCountSpan label label-pill label-success"><?php echo count($employee_custom_list); ?></span>
								</a>
							</li>
							<?php if($this->session->userdata('user_type') == 3){ ?>
							<li class="nav-item not-allowed">	
								<a class="navListlink nav-link" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable147'); ?></span>
								</a>
							</li>
							<?php } ?>
						<?php }?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 paddingTopLeft0px">
            	<input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>" autocomplete="off">
				<section class="tabs-section" >
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane fade <?php echo $one_tab_active; ?>" id="tabs-2-tab-1">
						<input type="hidden" name="employee_no" id="employee_no" value="<?php echo $this->mdl_mech_employee->form_value('employee_no', true); ?>" autocomplete="off"/>
						<input type="hidden" id="invoice_group_id" name="invoice_group_id" value="<?php echo $invoice_group_number->invoice_group_id;?>" >
							<input class="hidden" name="is_update" type="hidden" autocomplete="off"
								<?php if ($this->mdl_mech_employee->form_value('is_update')) {
									echo 'value="1"';
								} else {
									echo 'value="0"';
								}?>>
							<div class="form-group clearfix">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
									<label class="control-label string required"><?php _trans('lable95'); ?>*</label>
								</div>
								<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
									<select id="branch_id" name="branch_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
										<?php if($this->session->userdata('user_type') == 3){ ?>
										<option value=""><?php _trans('lable149'); ?></option>	
										<?php } ?>	
										<?php foreach ($branch_list as $branchList) {?>
										<option value="<?php echo $branchList->w_branch_id; ?>" <?php if($this->mdl_mech_employee->form_value('branch_id', true) == $branchList->w_branch_id){echo "selected";}?> > <?php echo $branchList->display_board_name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable134'); ?>*</label>
								</div>
								<div class="col-sm-9">
									<input type="hidden" name="employee_id" id="employee_id" class="form-control" value="<?php echo $this->mdl_mech_employee->form_value('employee_id', true); ?>" autocomplete="off">
									<input type="hidden" name="url_key" id="url_key" class="form-control" value="<?php echo $employee_url_key; ?>" autocomplete="off">
									<input type="text" name="employee_name" id="employee_name" class="form-control" value="<?php echo $this->mdl_mech_employee->form_value('employee_name', true); ?>" autocomplete="off">
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable148'); ?></label>
								</div>
								<div class="col-sm-9">
									<input type="text" name="employee_number" id="employee_number" class="form-control" value="<?php echo $this->mdl_mech_employee->form_value('employee_number', true); ?>" autocomplete="off">
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable137'); ?></label>
								</div>
								<div class="col-sm-9">
									<input type="text" onchange="checkEmployeeMobileNumber()" name="mobile_no" id="mobile_no" class="form-control" <?php if($this->mdl_mech_employee->form_value('employee_account_checkbox', true) == 1){ echo "readonly"; } ?> value="<?php echo $this->mdl_mech_employee->form_value('mobile_no', true); ?>" autocomplete="off">
									<span class="error mobileNumberError"></span>
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable41'); ?></label>
								</div>
								<div class="col-sm-9">
									<input type="text" onchange="checkEmployeeEmail();" onblur="chkEmail(this);" name="email_id" id="email_id" class="form-control" <?php if($this->mdl_mech_employee->form_value('employee_account_checkbox', true) == 1){ echo "readonly"; } ?> value="<?php echo $this->mdl_mech_employee->form_value('email_id', true); ?>" autocomplete="off">
									<span class="error emailIdError"></span>
									<span class="error emailIdErrorr"></span>
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label"><?php _trans('lable135'); ?>*</label>
								</div>
								<div class="col-sm-9">
									<select name="employee_role" id="employee_role" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
										<option value=""><?php _trans('lable150'); ?></option>
										<?php if ($employees_role):
    $role_id = $this->mdl_mech_employee->form_value('employee_role', true);
    foreach ($employees_role as $key => $role):
    ?>
										<option value="<?php echo $role->role_id; ?>" <?php if ($role->role_id == $role_id) {
        echo 'selected="selected"';
    }?>>
										<?php echo $role->role_name; ?></option>
										<?php endforeach; endif; ?>
									</select>
									<div class="col-lg-12 paddingLeft0px paddingTop5px">
										<a href="javascript:void(0)" data-toggle="modal" data-model-from="employee" data-target="#addNewCar" class="float_left fontSize_85rem add_employee_role">
											+ <?php echo trans('lable203'); ?>
										</a>
									</div>
								</div>
							</div>
							<?php if($this->session->userdata('is_shift') == 1){ ?>
								<input type="hidden" value="<?php echo $employee_shift?$employee_shift:1;?>" id="shift" name="shift" autocomplete="off">
							<?php } else { ?>
							<div class="form-group clearfix">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
									<label class="control-label string required"><?php _trans('lable151'); ?></label>
								</div>
								<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
									<select id="shift" name="shift" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
										<option value=""><?php _trans('lable152'); ?></option>	
										<?php foreach ($shift_list as $shiftList) {?>
										<option value="<?php echo $shiftList->shift_id; ?>" <?php if($employee_shift == $shiftList->shift_id){echo "selected";}?> > <?php echo $shiftList->shift_name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<?php } ?>

							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label"><?php _trans('lable153'); ?></label>
								</div>
								<div class="col-sm-9">
									<input type="text" name="date_of_birth" id="date_of_birth" class="form-control datepicker"  value="<?php echo $this->mdl_mech_employee->form_value('date_of_birth', true)?date_from_mysql($this->mdl_mech_employee->form_value('date_of_birth', true)):''; ?>" autocomplete="off">
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label"><?php _trans('lable154'); ?></label>
								</div>
								<div class="col-sm-9">
									<input type="text" name="date_of_joining" id="date_of_joining" class="form-control datepicker" value="<?php echo $this->mdl_mech_employee->form_value('date_of_joining', true)?date_from_mysql($this->mdl_mech_employee->form_value('date_of_joining', true)):''; ?>" autocomplete="off">
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label"><?php _trans('lable155'); ?></label>	
								</div>
								<div class="col-sm-9">
									<input type="text" name="basic_salary" id="basic_salary" class="form-control" value="<?php echo $this->mdl_mech_employee->form_value('basic_salary', true); ?>" autocomplete="off">
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable156'); ?></label>
								</div>
								<div class="col-sm-9">
									<input type="text" name="employee_experience" id="employee_experience" class="form-control" value="<?php echo $this->mdl_mech_employee->form_value('employee_experience', true); ?>" autocomplete="off">
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable157'); ?></label>
								</div>
								<div class="col-sm-9">
									<select name="blood_group" id="blood_group" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
										<option value=""><?php _trans('lable161'); ?></option>
												<?php $role_id = $this->mdl_mech_employee->form_value('blood_group', true); ?>
												<option value="1" <?php if ($role_id == 1) {
    echo 'selected';
}?>>A RhD positive (A+)</option>
												<option value="2" <?php if ($role_id == 2) {
    echo 'selected';
}?>>A RhD negative (A-)</option>
												<option value="3" <?php if ($role_id == 3) {
    echo 'selected';
}?>>B RhD positive (B+)</option>
												<option value="4" <?php if ($role_id == 4) {
    echo 'selected';
}?>>B RhD negative (B-)</option>
												<option value="5" <?php if ($role_id == 5) {
    echo 'selected';
}?>>O RhD positive (O+)</option>
												<option value="6" <?php if ($role_id == 6) {
    echo 'selected';
}?>>O RhD negative (O-)</option>
												<option value="7" <?php if ($role_id == 7) {
    echo 'selected';
}?>>AB RhD positive (AB+)</option>
												<option value="8" <?php if ($role_id == 8) {
    echo 'selected';
}?>>AB RhD negative (AB-)</option>
											</select>
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable158'); ?></label>
								</div>
								<div class="col-sm-9">
									<select name="physical_challange" id="physical_challange" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
										<option value=""><?php _trans('lable162'); ?></option>
											<?php $physical_id = $this->mdl_mech_employee->form_value('physical_challange', true); ?>
										<option value="1" <?php if ($physical_id == 1) {
    echo 'selected';
}?>>Yes</option>
										<option value="2" <?php if ($physical_id == 2) {
    echo 'selected';
}?>>No</option>
									</select>
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable159'); ?></label>
								</div>
								<div class="col-sm-9">
									<input type="text" name="employee_street_1" id="employee_street_1" class="form-control" value="<?php echo $this->mdl_mech_employee->form_value('employee_street_1', true); ?>" autocomplete="off">
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable160'); ?></label>
								</div>
								<div class="col-sm-9">
									<input type="text" name="employee_street_2" id="employee_street_2" class="form-control" value="<?php echo $this->mdl_mech_employee->form_value('employee_street_2', true); ?>" autocomplete="off">
								</div>
							</div>

							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable86'); ?></label>
								</div>
								<div class="col-sm-9">
									<?php if($this->mdl_mech_employee->form_value('employee_country', true)){
										$default_country_id = $this->mdl_mech_employee->form_value('employee_country', true);
									}else{
										$default_country_id = $this->session->userdata('default_country_id');
									} ?>
									<select id="employee_country" name="employee_country" class="country bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
										<option value=""><?php _trans('lable163'); ?></option>
										<?php foreach ($country_list as $countryList) {?>
										<option value="<?php echo $countryList->id; ?>" <?php if ($countryList->id == $default_country_id) {echo 'selected';} ?> > <?php echo $countryList->name; ?></option>
										<?php } ?>
                                    </select>
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable87'); ?></label>
								</div>
								<div class="col-sm-9">
									<?php if($this->mdl_mech_employee->form_value('employee_state', true)){
										$default_state_id = $this->mdl_mech_employee->form_value('employee_state', true);
									}else{
										$default_state_id = $this->session->userdata('default_state_id');
									} ?>
									<select id="employee_state" name="employee_state" class="state bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
										<option value=""><?php _trans('lable164'); ?></option>
										<?php foreach ($state_list as $stateList) {?>
										<option value="<?php echo $stateList->state_id; ?>" <?php if ($stateList->state_id == $default_state_id) {echo 'selected';} ?> > <?php echo $stateList->state_name; ?></option>
										<?php } ?>
                                   	</select>
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable88'); ?></label>
								</div>
								<div class="col-sm-9">
									<?php if($this->mdl_mech_employee->form_value('employee_city', true)){
										$default_city_id = $this->mdl_mech_employee->form_value('employee_city', true);
									}else{
										$default_city_id = $this->session->userdata('default_city_id');
									} ?>
									<select id="employee_city" name="employee_city" class="city bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
											<option value=""><?php _trans('lable165'); ?></option>
												   <?php foreach ($city_list as $cityList) {
        ?>
													<option value="<?php echo $cityList->city_id; ?>" <?php if ($cityList->city_id == $default_city_id) {
            echo 'selected';
        } ?> > <?php echo $cityList->city_name; ?></option>
<?php
    } ?>
											</select>
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable89'); ?></label>
								</div>
								<div class="col-sm-9">
									<input type="text" name="employee_pincode" id="employee_pincode" class="form-control" value="<?php echo ($this->mdl_mech_employee->form_value('employee_pincode', true)?$this->mdl_mech_employee->form_value('employee_pincode', true):"") ?>" autocomplete="off">
								</div>
							</div>
							<div class="buttons text-center">
								<button id="btn_submit" value="1" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
									<i class="fa fa-check"></i> <?php _trans('lable56'); ?>
								</button>
								<button id="btn_submit" value="2" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
									<i class="fa fa-check"></i> <?php _trans('lable57'); ?>
								</button>
								<button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default">
									<i class="fa fa-times"></i> <?php _trans('lable58'); ?>
								</button>
								<?php // $this->layout->load_view('layout/header_buttons');?>
							</div>	
						</div>
						<div role="tabpanel" class="tab-pane fade <?php echo $three_tab_active; ?>" id="tabs-2-tab-2">
						<section class="card">
				<div class="card-block">
					<div class="row">
						<div class="col-sm-12">
							<a style="margin-bottom: 15px; float: right" href="javascript:void(0)" data-model-from="employee" data-toggle="modal" data-target="#add_skill" data-employee-id="<?php echo $this->mdl_mech_employee->form_value('employee_id', true); ?>" class="add_skill btn btn-rounded">
							<?php if (count($employee_skill_list) > 0) {
        ?>
								<i class="fa fa-edit fa-margin"></i>
								<?php
    }?>
								<?php _trans('lable166'); ?>
							</a>
						</div>
					</div>
					<div class="overflowScrollForTable">
						<table id="user_address_list" class="display table table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th><?php _trans('lable167'); ?></th>
								</tr>
							</thead>
							<tbody>
						<?php if (count($employee_skill_list) > 0) {
			$i = 1;
			foreach ($employee_skill_list as $skill_list) {
				?>
								<tr>
									<td><?php _htmlsc($skill_list->skill_name); ?></td>
								</tr>
					<?php ++$i; } } else { echo '<tr><td colspan="2" class="text-center" > No data found </td></tr>'; } ?>
							</tbody>
						</table>
					</div>
				</div>
			</section>
					</div>
				<div role="tabpanel" class="tab-pane fade <?php echo $two_tab_active; ?>" id="tabs-2-tab-3">
				<div class="row">
				<div class="col-sm-12">
					<a style="margin-bottom: 15px; float: right" href="javascript:void(0)" data-toggle="modal" data-module-type="E" data-entity-id="<?php echo $this->mdl_mech_employee->form_value('employee_id', true); ?>" data-bank-id="0" data-target="#addBank" class="btn btn-rounded add_bank"><?php _trans('lable92');?></a>
				</div>
			</div>

			<?php if (count($workshop_bank_list) > 0) {
        foreach ($workshop_bank_list as $bank) {
            ?>
			<div class="box-typical car-box-panel" id="renderbankDetails">
				<div class="row">
					<div class="col-sm-5">
						<div class="car-details-box profile-box border-right col-sm-12 padding0px">
							<div class="overflowScrollForTable" style="min-height:150px">
								<table class="car-table-box">
									<tbody>
										<tr>
											<th><strong><?php _trans('lable129'); ?></strong></th><td><?php echo $bank->display_board_name; ?></td>
										</tr>
										
										<tr>
											<th><strong><?php _trans('lable99'); ?></strong></th><td><?php echo $bank->bank_name; ?></td>
										</tr>
										<tr>
											<th><strong><?php _trans('lable96'); ?></strong></th><td><?php echo $bank->current_balance; ?></td>
										</tr>
										<tr>
											<th><strong><?php _trans('lable95'); ?></strong></th><td><?php echo $bank->bank_branch; ?></td>
										</tr>
										<tr>
											<th><strong><?php _trans('lable100'); ?></strong></th><td><?php echo $bank->bank_ifsc_Code; ?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-sm-5">
						<div class="car-details-box profile-box col-sm-12 padding0px">
							<div class="overflowScrollForTable" style="min-height:150px;">
								<table class="car-table-box">
									<tbody>
										<tr>
											<th><strong><?php _trans('lable97'); ?></strong></th>
											<td><?php echo $bank->account_holder_name; ?></td>
										</tr>
										<tr>
											<th><strong><?php _trans('lable101'); ?></strong></th>
											<td><?php if ($bank->account_type == '1') {
													echo 'Current';
												} elseif ($bank->account_type == '2') {
													echo 'Saving';
												} elseif ($bank->account_type == '3') {
													echo 'Others';
												} elseif ($bank->account_type == '4') {
													echo 'Saving';
												} ?>
											</td>
										</tr>
										<tr>
											<th><strong><?php _trans('lable98'); ?></strong></th>
											<td><?php echo $bank->account_number; ?></td>
										</tr>
										<tr>
											<th><strong><?php _trans('lable69'); ?></strong></th>
											<td><?php if ($bank->is_default == 'Y') {
					echo 'Yes';
				} elseif ($bank->is_default == 'N') {
					echo 'No';
				} ?>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-sm-2 pull-right text_align_right">
						<a href="javascript:void(0)" data-toggle="modal" data-module-type="E" data-entity-id="<?php echo $this->mdl_mech_employee->form_value('employee_id', true); ?>" data-target="#addBank" data-bank-id="<?php echo $bank->bank_id; ?>" class="page-header-edit add_bank">
							<i class="fa fa-edit"></i>
						</a>
						<a href="javascript:void(0)" class="page-header-remove" onclick="remove_bank(<?php echo $bank->bank_id; ?>, '<?= $this->security->get_csrf_hash(); ?>')"><i class="fa fa-trash"></i></a>
            		</div>
				</div>
			</div>
			<?php
        }
			} else {
			    echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" > No data found </div>';
			}?>
						</div>
						<div role="tabpanel" class="tab-pane fade <?php echo $four_tab_active; ?>" id="tabs-2-tab-4">
							<div class="row">
								<div class="col-sm-12">
									<a style="margin-bottom: 15px; float: right" href="javascript:void(0)" data-model-from="employee" data-toggle="modal" data-target="#add_experience" data-employee-id="<?php echo $this->mdl_mech_employee->form_value('employee_id', true); ?>" class="add_experience btn btn-rounded">
										<?php _trans('lable172'); ?>
									</a>
								</div>
							</div>
							<?php if (count($employee_experience_list) > 0) {
								$i = 1;
								foreach ($employee_experience_list as $experience) {
								if(count($employee_experience_list) == 1 || count($employee_experience_list) == $i+1)
											{
											$dropup = "dropup";
											}else{
											$dropup = "";
											}?>

							<div class="box-typical car-box-panel" id="renderbankDetails">
								<div class="row spacetop-10" style="padding-left:20px;">
									<strong> <?php _trans('lable178'); ?> <?php _htmlsc($i); ?></strong>
								</div>
								<div class="row">
									<div class="col-sm-7">
										<div class="car-details-box profile-box border-right">
											<div class="overflowScrollForTable" style="min-height: 100px;">
												<table class="car-table-box">
													<tbody>
														<tr>
															<th><strong><?php _trans('lable135'); ?></strong></th><td><?php echo $experience->role_name; ?></td>
														</tr>
														<tr>
															<th><strong><?php _trans('lable174'); ?></strong></th><td><?php echo $experience->company_name; ?></td>
														</tr>
														<tr>
															<th><strong><?php _trans('lable61'); ?></strong></th>
														
															<td>
											
											          	<?php if($experience->customer_street_1){
		                                            		echo $experience->customer_street_1.", ";
		                                            	}
		                                            	if($experience->customer_street_2){
		                                            		echo $experience->customer_street_2.", ";
		                                            	}
		                                            	if($experience->area){
		                                            		echo $experience->area.", ";
		                                            	}
		                                            	if($experience->customer_city){
		                                            		echo $experience->city_name.", ";
		                                            	}
		                                            	if($experience->customer_state){
		                                            		echo $experience->state_name.", ";
		                                            	}
		                                            	if($experience->customer_country){
		                                            		echo $experience->country_name.", ";
		                                            	}
		                                            	if($experience->zip_code){
		                                            		echo $experience->zip_code;
		                                            	} ?>
		                                            	</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>	
									</div>
									<div class="col-sm-3">
										<div class="car-details-box profile-box">
											<div class="overflowScrollForTable" style="min-height: 100px;">
												<table class="car-table-box">
													<tbody>
														<tr>
															<th><strong><?php _trans('lable175'); ?></strong></th>
															<td><?php echo $experience->from?date_from_mysql($experience->from):""; ?></td>
														</tr>
														<tr>
															<th><strong><?php _trans('lable176'); ?></strong></th>
															<td><?php echo $experience->to?date_from_mysql($experience->to):""; ?></td>
														</tr>
														<tr>
															<th><strong><?php _trans('lable177'); ?></strong></th>
															<td><?php echo $experience->description; ?></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="col-sm-2 pull-right text_align_right">
										<a href="javascript:void(0)" data-toggle="modal" data-model-from="employee" data-employee-id="<?php echo $this->mdl_mech_employee->form_value('employee_id', true); ?>" data-target="#add_experience" data-experience-id="<?php echo $experience->employee_experience_id; ?>"class="page-header-edit add_experience">
											<i class="fa fa-edit"></i>
										</a>
										<a href="javascript:void(0)" class="page-header-remove" onclick="delete_record('mech_employee_exp',<?php echo $experience->employee_experience_id; ?>, '<?= $this->security->get_csrf_hash(); ?>')"><i class="fa fa-trash"></i></a>
            						</div>
								</div>
							</div>
							<?php ++$i;
        						}
							}else {
							    echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" > No data found </div>';
							}?>
							</div>
							<div role="tabpanel" class="tab-pane fade <?php echo $five_tab_active; ?>" id="tabs-2-tab-5">
								<div id="upload_section">
									<div class="import_invoice_title padding_left_15px"><?php _trans('lable180'); ?></div>
									<form class="upload" upload-id="upload_csv_add" id="upload_csv_add" method="post" enctype="multipart/form-data" autocomplete="off">
										<input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>" autocomplete="off">
										<div class="form-group clearfix">
											<div class="col-sm-3 text-right">
												<label class="control-label string required"><?php _trans('lable179'); ?>*</label>
											</div>
											<div class="col-sm-3">
												<input type="text" name="document_name" id="document_name" class="form-control" value="" autocomplete="off" autocomplete="off">
											</div>
											<div class="col-sm-5 paddingTop3px">
												<input type="file" id="file" onchange="getfile()" class="inputTypeFile inputfile" name="file" autocomplete="off">
												<input type="hidden" id="fileName" name="fileName" value="" autocomplete="off"/>
												<div id="showError" class="errorColor" style="display:none;" ><?php _trans('lable181'); ?></div>
											</div>
											<div class="col-sm-1 paddingTop7px" style="padding-left:37px;">
												<span class="text-center">
													<button type="submit">
														<i class="fa fa-upload" aria-hidden="true"></i>
													</button>
												</span>
											</div>
										</div>
									</form>
								</div>
								<hr>
								<div id="preview_section" class="preview_uploads col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<?php if(count($employee_document_list) > 0) { ?>
										<div class="overflowScrollForTable">
											<table class="car-table-box col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<thead>
													<tr>
														<th><?php _trans('lable182'); ?></th>
														<th><?php _trans('lable179'); ?></th>
														<th align="center" class="text-center"><?php _trans('lable183'); ?></th>
														<th align="center" class="text-center"><?php _trans('lable184'); ?></th>
													</tr>
												</thead>
												<tbody id="uploaded_datas">
													
													<?php foreach ($employee_document_list as $documentList){ ?>
													<tr>
														<td><span><?php echo $documentList->document_name; ?></span></td>
														<td><span><?php echo $documentList->file_name_original; ?></span></td>
														<td align="center" class="text-center" >
														<span style="cursor: pointer">
															<a href="<?php echo base_url()."uploads/employee_files/".$documentList->file_name_new?>" target="_blank" >
																<img src="<?php echo base_url()."uploads/employee_files/".$documentList->file_name_new?>" width="50" height="50">
															</a>
														</span></td>
														<td align="center" class="text-center"><span style="cursor: pointer" onclick="getDeleteUploadFIle('<?php echo $documentList->upload_id; ?>','D','<?php echo $documentList->file_name_original; ?>')"><i class="fa fa-trash-o" aria-hidden="true"></i></span></td>
													</tr>
											
											<?php } ?>
											</tbody>
										</table>
									</div>
									<?php } else { ?>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" ><?php _trans('lable185'); ?></div>
									<?php } ?>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane fade <?php echo $six_tab_active; ?>" id="tabs-2-tab-6">
								<div id="gif" class="gifload">
									<div class="gifcenter">
									<center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
									</div>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box-typical car-box-panel">
									<div id="custom" class="col-lg-12 col-md-12 col-sm-12">	
										<div class="multi-field-wrapper">
                           					<div class="multi-fields">
                								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right paddingLeftRight5px">
                									<label class="text_align_left"><?php _trans('lable186'); ?>*</label>
                								</div>
                								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 paddingLeftRight5px">
                									<label class="text_align_left"><?php _trans('lable187'); ?></label>
                								</div>
                								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 paddingLeftRight5px">
													<label class="text_align_left"><?php _trans('lable188'); ?></label>
												</div>
												<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12  paddingLeftRight5px">
													<label class="text_align_left"><?php _trans('lable189'); ?></label>
												</div>
                           						<?php if(count($employee_custom_list) > 0){  ?>
                           						<?php foreach ($employee_custom_list as $value){?>
                           						<div class="multi-field">
                                    				<div class="form-group clearfix">
														<input type="hidden" name="custom_id" class="custom_id" value="<?php echo $value->custom_id;?>" autocomplete="off">
														<input type="hidden" name="duplicate_custom_id" class="duplicate_custom_id" value="<?php echo $value->custom_id;?>" autocomplete="off">
                        								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 paddingLeftRight5px text-right">
                        									<input type="text" name="column_name" class="column_name removeError form-control" value="<?php echo $value->column_name; ?>" autocomplete="off">
                        								</div>
                        								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 paddingLeftRight5px">
                        									<input type="text" name="column_value" class="column_value form-control" value="<?php echo $value->column_value; ?>" autocomplete="off">
                        								</div>
                        								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 paddingLeftRight5px">
															<input type="text" name="column_from"  class="column_from form-control datepicker" value="<?php echo $value->column_from?date_from_mysql($value->column_from):''; ?>" autocomplete="off">
														</div>
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 paddingLeftRight5px">
															<input type="text" name="column_to" class="column_to form-control datepicker" value="<?php echo $value->column_to?date_from_mysql($value->column_to):''; ?>" autocomplete="off">
														</div>
                        								<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 paddingLeftRight5px paddingTop7px">
                        									<button type="button" class="remove_field"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                        								</div>
                        							</div>
                                  				</div>
                           						<?php } }?>
												<div id="new_custom_row" style="display: none;">
													<input type="hidden" name="custom_id" class="custom_id" autocomplete="off">
													<input type="hidden" name="duplicate_custom_id" class="duplicate_custom_id" autocomplete="off">
                                    				<div class="form-group clearfix">
                        								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right paddingLeftRight5px">
                        									<input type="text" name="column_name" class="column_name form-control" value="" autocomplete="off">
                        								</div>
                        								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 paddingLeftRight5px">
                        									<input type="text" name="column_value" class="column_value form-control" value="" autocomplete="off">
                        								</div>
                        								<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 paddingLeftRight5px">
															<input type="text" name="column_from"  class="column_from form-control datepicker" value="" autocomplete="off">
														</div>
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 paddingLeftRight5px">
															<input type="text" name="column_to" class="column_to form-control datepicker" value="" autocomplete="off">
														</div>
                        								<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 paddingLeftRight5px paddingTop7px">
                        									<button type="button" class="remove-field"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                        								</div>
                        							</div>
                                  				</div>
                            				</div>
                            				<div class="col-lg-12 col-md-12 col-sm-12" >
                            					<button type="button" class="add-field"><i class="fa fa-plus-circle" aria-hidden="true"></i> <?php _trans('lable70'); ?></button>
                            				</div>
                              			</div>
    									<div class="text-center">
    										<button name="addCustomArray" class="btn btn-primary" id="addCustomArray" ><?php _trans('lable57'); ?></button>
    									</div>
									</div>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane fade <?php echo $seven_tab_active; ?>" id="tabs-2-tab-7">
							<div id="gif" class="gifload">
								<div class="gifcenter">
								<center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
								</div>
							</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box-typical car-box-panel">
									<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12" >
										<div class="col-lg-6 col-lg-6 col-sm-6 col-xs-12" style="padding-left: 0px;">
											<h4 style="margin-bottom: 0px;"><?php _trans('lable190'); ?></h4>
											<div><?php _trans('lable191'); ?></div>
										</div>
										<div class="col-lg-6 col-lg-6 col-sm-6 col-xs-12 text_align_right ">
											<label class="switch">
												<input type="checkbox" class="checkbox" <?php if($this->mdl_mech_employee->form_value('employee_account_checkbox', true) == 1){ echo "checked"; } ?> name="checkbox" id="employee_account_checkbox" value="<?php echo $this->mdl_mech_employee->form_value('employee_account_checkbox', true); ?>" data-target="upload" autocomplete="off">
												<span class="slider round"></span>
											</label>
										</div>
									</div>
									<div class="collapse col-lg-12 col-lg-12 col-sm-12 col-xs-12 paddingTop20px <?php if($this->mdl_mech_employee->form_value('employee_account_checkbox', true) == 1){ echo "in"; } ?>" id="employeeAccountcollapse" >
										<input type="hidden" id="user_company" name="user_company" value="<?php echo $this->session->userdata('user_company');?>" >
										<div id="checkinListDatas" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 padding0px">
											<?php foreach($mech_modules as $keys => $module){ 
												$checked = "";
												$permission_id = "";
												$permissionStatus = "";
												foreach($permission_list as $permission){
													if($permission->module_id == $module->module_id){
														if($permission->status == 1){
															$checked = "checked";
														}
														$permission_id = $permission->permission_id;
														$permissionStatus = $permission->status;
													} 
												} 
												?>
												<div class="multi-field col-xl-4 col-lg-4 col-md-4 col-sm-6 padding0px">
													<input type="hidden" name="module_id" value="<?php echo $module->module_id; ?>" id="module_id_<?php echo $module->module_id; ?>" class="module_id">
													<input type="hidden" name="permission_id" value="<?php echo $permission_id; ?>" id="permission_id_<?php echo $module->module_id; ?>" class="permission_id">
													<label class="text_align_left"><input type="checkbox" class="permission_status" <?php echo $checked; ?> value="<?php echo $permissionStatus;?>" name="permission_status" > <?php echo $module->module_label ;?> </label>
												</div>
											<?php } ?>
										</div>
										<form class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 paddingTop40px paddingLeftRight0px">
											<div class="form-group clearfix">
												<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
													<label class="control-label string required"><?php _trans('lable137'); ?>*</label>
												</div>
												<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
													<input type="text" onkeypress="showOtpButton()" <?php if($this->mdl_mech_employee->form_value('mobile_no', true)){echo "disabled";} ?> name="user_mobile" onblur="mobilenocheckup(this);" value="<?php echo $this->mdl_mech_employee->form_value('mobile_no', true); ?>" id="user_mobile" class="form-control" placeholder="Phone number" autocomplete="off"/>
													<div class="error" id="invalidmobileno"></div>
													<div id="showErrorphone" class="error"></div>
												</div>
											</div>
											<div class="form-group clearfix">
												<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
													<label class="control-label string required"><?php _trans('lable192'); ?>*</label>
												</div>
												<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
													<input type="email" onkeypress="showOtpButton()" <?php if($this->mdl_mech_employee->form_value('email_id', true)){echo "disabled";} ?> name="user_email" id="user_email"  onblur="emailcheckup(this);" class="form-control" value="<?php echo $this->mdl_mech_employee->form_value('email_id', true); ?>" placeholder="E-Mail" autocomplete="off"/>
													<div class="error" id="invalidemail"></div>
													<div id="showErroremail" class="error"></div>
												</div>
											</div>
											<div class="form-group clearfix">
												<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
													<label class="control-label string required"><?php _trans('lable193'); ?>*</label>
												</div>
												<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
													<input type="text" onkeypress="showOtpButton()" disabled name="user_name" id="user_name" value="<?php echo $this->mdl_mech_employee->form_value('employee_name', true); ?>" class="form-control" placeholder="Full name" autocomplete="off">
													<div class="error" id="invalidname"></div>
												</div>
											</div>
											<div class="form-group clearfix">
												<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
													<label class="control-label string required"><?php _trans('lable51'); ?>*</label>
												</div>
												<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
													<select  name="user_branch_id" id="user_branch_id" onchange="showOtpButton()" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" multiple="multiple" autocomplete="off">
														<option value=""><?php _trans('lable149'); ?></option>
														<?php if (!empty($branch_list)) : ?>
														<?php $employee_branch_list = explode(',', $this->mdl_mech_employee->form_value('user_branch_id', true));
														foreach ($branch_list as $branch) {
															if (in_array($branch->w_branch_id, $employee_branch_list)) {
																$selected = "selected='selected'";
															} else {
																$selected = '';
															} ?>
														<option value="<?php echo $branch->w_branch_id; ?>" <?php echo $selected; ?>><?php echo $branch->display_board_name; ?></option>
														<?php
														} endif; ?>
													</select>
												</div>
											</div>
											<?php if(empty($this->mdl_mech_employee->get_employee_role_id($this->mdl_mech_employee->form_value('employee_id', true)))){?>
											<div class="form-group clearfix">
												<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
													<label class="control-label string required"><?php _trans('lable194'); ?>*</label>
												</div>
												<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
													<input type="password" onkeypress="showOtpButton()" name="password" id="password" class="form-control" placeholder="Password" autocomplete="off" />
													<span class="error" id="user_password_errmsg" style="display:none;"></span>
													<p class="message" id="message"><?php _trans('lable195'); ?></p>
												</div>
											</div>
											<div class="form-group clearfix">
												<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
													<label class="control-label string required"><?php _trans('lable196'); ?>*</label>
												</div>
												<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
													<input type="password" onkeypress="showOtpButton()" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password" autocomplete="off" />
													<span class="error" id="user_passwordv_errmsg" style="display:none;"></span>
												</div>
											</div>
											<div class="form-group clearfix" id="otp_div" style="display: none">
												<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
													<label class="control-label string required"><?php _trans('lable197'); ?></label>
												</div>
												<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
													<span class="otpMessage" ><?php _trans('lable198'); ?></span>
													<div class="form-group">
														<input type="text" name="otp" id="otp" class="form-control input-custom" value="" placeholder="OTP" autocomplete="off">	
													</div>
													<div class="form-group">
														<a id="resend" onclick="resendotp();"><?php _trans('lable199'); ?>?</a>
													</div>
												</div>
											</div>
											<div class="text-center">
												<div class="error" id="validation_error"></div>
												<a onclick="otp_submit();" style="display: none"  id="otpform" name="otpform" value="1" class="btn btn-rounded"><?php _trans('lable200'); ?></a>
												<a onclick="signup_submit();" style="display: none"  id="signupform" name="signupform" value="2" class="btn btn-rounded"><?php _trans('lable201'); ?></a>
											</div>
											<?php } ?>
										</form>
										<?php if($this->mdl_mech_employee->form_value('employee_account_checkbox', true) == 1 && !empty($this->mdl_mech_employee->get_employee_role_id($this->mdl_mech_employee->form_value('employee_id', true)))){ ?>
										<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 padding0px text-center">
											<button id="update_employee_branched" name="update_employee_branched" onclick="deactivateEmployeeUser()" class="update_employee_branched btn btn-rounded btn-primary btn-padding-left-right-40">
												<?php _trans('lable57'); ?>
											</button>
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
    </div>
</div>
<script type="text/javascript">

var employeeMobileAlreadyExist = false;
var employeeEmailAlreadyExist = false;
var Emailinvalid = false;


$("#mobile_no").on("keypress keyup blur",function (event) {    
           $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
	});

$("#user_mobile").on("keypress keyup blur",function (event) {    
		$(this).val($(this).val().replace(/[^\d].+/, ""));
		if ((event.which < 48 || event.which > 57)) {
			event.preventDefault();
		}
});

function checkEmployeeMobileNumber(){

	if($("#mobile_no").val() != ""){
		// $("#user_mobile").val($("#mobile_no").val());
		$.post('<?php echo site_url('mech_employee/ajax/checkEmployeeMobile'); ?>', {
			employee_id : $("#employee_id").val(),
			mobile_no : $("#mobile_no").val(),
			_mm_csrf: $('#_mm_csrf').val()
		}, function (data) {
			list = JSON.parse(data);
			if(list.success == 1){
				employeeMobileAlreadyExist = true;
				$('.mobileNumberError').empty().append('Mobile Number Already Exist');
			}else{
				employeeMobileAlreadyExist = false;
				$('.mobileNumberError').empty().append('');
			}
		});
	}else{
		$('#mobile_no').parent().addClass('has-error');
	}
	
}

	function chkEmail(emailField){
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	if($("#email_id").val() != ''){
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

function checkEmployeeEmail(){

	if($("#email_id").val() != ""){
		// $("#user_email").val($("#email_id").val());
		$.post('<?php echo site_url('mech_employee/ajax/checkEmployeeEmail'); ?>', {
			employee_id : $("#employee_id").val(),
			email_id : $("#email_id").val(),
			_mm_csrf: $('#_mm_csrf').val()
		}, function (data) {
			list = JSON.parse(data);
			if(list.success == 1){
				employeeEmailAlreadyExist = true;
				$('.emailIdError').empty().append('Email ID Already Exist');
			}else{
				employeeEmailAlreadyExist = false;
				$('.emailIdError').empty().append('');
			}
		});
	}else{
		$('#email_id').parent().addClass('has-error');
	}

}

	$(document).ready(function() {

		$(".ipad_dropdown").click(function(){
			$(".ipad_dropdown").removeClass('active');
		});

		$("#skill_id").select2();

		// var currentDate = new Date();

		// $("#date_of_birth").datepicker({
		// 	autoclose: true,
		// 	endDate: currentDate,
		// });

		// $("#date_of_joining").datepicker({
		// 	autoclose: true,
		// 	endDate: currentDate,
		// });

		$(".permission_status").change(function(){
			if($(this).prop("checked") == true){
				$(this).val('1');
			}else{
				$(this).val('0');
			}
		});

		$("#employee_account_checkbox").click(function(){
			if($("#employee_account_checkbox:checked").is(":checked")){
				$("#employeeAccountcollapse").addClass('in');
				$("#employee_account_checkbox").val(1);
				$("#email_id").prop('disabled', true);
				$("#mobile_no").prop('disabled', true);
			}else{
				$("#employeeAccountcollapse").removeClass('in');
				$("#employee_account_checkbox").val(0);
				$("#email_id").prop('disabled', false);
				$("#mobile_no").prop('disabled', false);
				deactivateEmployeeUser();
			}
		});

		$("#btn_cancel").click(function () {
        	window.location.href = "<?php echo site_url('mech_employee'); ?>";
		});
		
		$(".btn_submit").click(function () {
			var validation = [];
			if($("#branch_id").val() == ''){
				validation.push('branch_id');
			}
			if($("#employee_name").val() == ''){
				validation.push('employee_name');
			}
			if($("#employee_role").val() == ''){
				validation.push('employee_role');
			}
			if(validation.length > 0){
				validation.forEach(function(val){
					$('#'+val).addClass("border_error");
						if($('#'+val+'_error').length == 0){
							$('#'+val).parent().addClass('has-error');
						}
				});
				return false;
			}

			if(employeeMobileAlreadyExist){
				$('.mobileNumberError').empty().append('Mobile Number Already Exist');
				$("#mobile_no").focus();
				return false;
			}

			if(employeeEmailAlreadyExist){
				$('.emailIdError').empty().append('Email ID Already Exist');
				$("#email_id").focus();
				return false;
			}

			if($("#email_id").val() != ''){
				if(Emailinvalid){
					$('.emailIdErrorr').empty().append('Invalid Email Address');
					$("#email_id").focus();
					return false;
				}
			}
			
			$('#gif').show();
			$.post('<?php echo site_url('mech_employee/ajax/create'); ?>', {
				employee_id : $("#employee_id").val(),
				employee_no : $("#employee_no").val(),
				invoice_group_id : $("#invoice_group_id").val(),
				url_key : $("#url_key").val(),
				employee_name : $('#employee_name').val(),
				employee_number : $("#employee_number").val(),
				branch_id : $("#branch_id").val(),
				shift : $("#shift").val(),
				employee_role : $('#employee_role').val(),
				skill_ids : $('#skill_ids').val(),
				employee_experience : $('#employee_experience').val(),
				basic_salary : $('#basic_salary').val(),
				date_of_birth: $('#date_of_birth').val(),
				date_of_joining : $('#date_of_joining').val(),
				mobile_no : $("#mobile_no").val(),
				employee_street_1 : $('#employee_street_1').val(),
				employee_street_2 : $('#employee_street_2').val(),
				employee_city : $('#employee_city').val(),
				employee_state : $('#employee_state').val(),
				employee_country : $("#employee_country").val(),
				employee_pincode : $('#employee_pincode').val(),
				email_id : $('#email_id').val(),
				blood_group : $('#blood_group').val(),
				physical_challange : $('#physical_challange').val(),
				refered_by_id : $('#refered_by_id').val(),
				action_from: 'E',
				btn_submit : $(this).val(),
				_mm_csrf: $('#_mm_csrf').val()
	        }, function (data) {
				list = JSON.parse(data);
				$('#gif').hide();
	            if(list.success == '1'){
	                notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
					if(list.btn_submit == '1'){
						setTimeout(function(){
							window.location = "<?php echo site_url('mech_employee/form'); ?>";
						}, 100);
					}else{
						setTimeout(function(){
							window.location = "<?php echo site_url('mech_employee/form'); ?>/"+list.employee_id+"/3";
						}, 100);
					}
	            }else if(list.success == '2'){
					if(list.label == "mobile_no"){
						$('.mobileNumberError').empty().append(list.error_msg);
						$("#mobile_no").focus();
						return false;
					}
					if(list.label == "email_id"){
						$('.emailIdError').empty().append(list.error_msg);
						$("#email_id").focus();
						return false;
					}
				}else{
					notie.alert(3, '<?php _trans('toaster2'); ?>', 2);
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
				country_id: $('#employee_country').val(),
				_mm_csrf: $('#_mm_csrf').val()
			},
			function (data) {
				var response = JSON.parse(data);
				if (response.length > 0) {
					$('#gif').hide();
					$('#employee_state').empty(); // clear the current elements in select box
					$('#employee_state').append($('<option></option>').attr('value', '').text('Select State'));
					for (row in response) {
						$('#employee_state').append($('<option></option>').attr('value', response[row].state_id).text(response[row].state_name));
					}
					$('#employee_state').selectpicker("refresh");
				}
				else {
					$('#gif').hide();
					$('#employee_state').empty(); // clear the current elements in select box
					$('#employee_state').append($('<option></option>').attr('value', '').text('Select State'));
					$('#employee_state').selectpicker("refresh");
				}
			});
		});
		
		$('.state').change(function () {
			$('#gif').show();
            $.post("<?php echo site_url('settings/ajax/get_city_list'); ?>", {
				state_id: $('#employee_state').val(),
				_mm_csrf: $('#_mm_csrf').val()
			},
			function (data) {
				var response = JSON.parse(data);
				if (response.length > 0) {
					$('#gif').hide();
					$('#employee_city').empty(); // clear the current elements in select box
					$('#employee_city').append($('<option></option>').attr('value', '').text('Select City'));
					for (row in response) {
						$('#employee_city').append($('<option></option>').attr('value', response[row].city_id).text(response[row].city_name));
					}
					$('#employee_city').selectpicker("refresh");
				}
				else {
					$('#gif').hide();
					$('#employee_city').empty(); // clear the current elements in select box
					$('#employee_city').append($('<option></option>').attr('value', '').text('Select City'));
					$('#employee_city').selectpicker("refresh");
				}
			});
		});
		//$('.summernote').summernote();
	});

	function getfile()
	{
    	var filename = $('input[type=file]').val().split("\\");
    	$("#fileName").val(filename[2]);
    	$("#showError").hide();
	}

	$(".add-field").click(function(){

		var add_mathround = parseInt(new Date().getTime() + Math.random());
		$('#new_custom_row').clone().appendTo('.multi-fields').removeAttr('id').addClass('multi-field').attr('id', 'tr_' + add_mathround).show();

		$('#tr_' + add_mathround + ' .custom_id').attr('id', "custom_id_" + add_mathround);

		$('#tr_' + add_mathround + ' .duplicate_custom_id').attr('id', "duplicate_custom_id_" + add_mathround);

		$('#tr_' + add_mathround + ' .column_name').attr('id', "column_name_" + add_mathround);

		$('#tr_' + add_mathround + ' .column_value').attr('id', "column_value_" + add_mathround);

		$('#tr_' + add_mathround + ' .column_from').attr('id', "column_from_" + add_mathround);

		$('#tr_' + add_mathround + ' .column_to').attr('id', "column_to_" + add_mathround);

		$("#duplicate_custom_id_" + add_mathround).val(add_mathround);

	});

	$(document).on("click",".remove-field",function(){
		$(this).parent().parent().parent().remove();
	});

	$(document).on("click",".remove_field",function() {
		var custom_id = $(this).parent().parent().parent().find('.custom_id').val();
		swal({
			title: "Are you sure?",
			text: "You will not be able to recover this imaginary file!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, delete it!",
			cancelButtonText: "No, cancel plx!",
			closeOnConfirm: false,
			closeOnCancel: false
		},
		function(isConfirm) {
			if (isConfirm) {
				$.post('<?php echo site_url('mech_employee/ajax/deleteCustomData'); ?>', {
					custom_id : custom_id,
					_mm_csrf: $('#_mm_csrf').val()
				}, function (data) {
					list = JSON.parse(data);
					if(list.success=='1'){
						swal({
							title: "The row is deleted successfully",
							text: "Your imaginary file has been deleted.",
							type: "success",
							confirmButtonClass: "btn-success"
						},function() {
							notie.alert(1, 'Successfully deleted', 2);
							//$(this).parent().parent().parent().remove();
							window.location.href = "<?php echo site_url('mech_employee/form'); ?>/"+$('#employee_id').val()+"/6";					
						});
					}else{
						notie.alert(3, '<?php _trans('toaster2');?>', 2);
					}
				});
			} else {
				swal({
					title: "Cancelled",
					text: "Your imaginary file is safe :)",
					type: "error",
					confirmButtonClass: "btn-danger"
				});
			}
		});
	});

	$("#addCustomArray").click(function () {

		var customArray = [];
		var validation = [];
		
		$(".multi-fields .multi-field").each(function(){

			var requestObj = {};
			requestObj.duplicate_custom_id = $(this).find(".duplicate_custom_id").val();
			requestObj.custom_id = $(this).find(".custom_id").val();
			requestObj.column_name = $(this).find(".column_name").val();
			requestObj.column_value = $(this).find(".column_value").val();
			requestObj.column_from = $(this).find(".column_from").val().split("/").reverse().join("-");
			requestObj.column_to = $(this).find(".column_to").val().split("/").reverse().join("-");
			customArray.push(requestObj);

		});

		if(customArray.length > 0){
			customArray.forEach(function(val){
				if(val.column_name == ''){
					validation.push('column_name_'+val.duplicate_custom_id);
				}
				if(val.column_value == ''){
					validation.push('column_value_'+val.duplicate_custom_id);
				}
			});
		}

		if(validation.length > 0){			
			validation.forEach(function(val) {				
				$('#'+val).addClass("border_error");
				$('#'+val).parent().addClass('has-error');
			});
			return false;
		}

		$('#gif').show();

		$.post('<?php echo site_url('mech_employee/ajax/saveCustomData'); ?>', {
			customArray : JSON.stringify(customArray),
            entity_id : $('#employee_id').val(),
            entity_type : 'E',
			_mm_csrf: $('#_mm_csrf').val()
        }, function (data) {
            list = JSON.parse(data);
            if(list.success=='1'){
                notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
				if(list.EntityCustomList.length > 0){
					window.location.href = "<?php echo site_url('mech_employee/form'); ?>/"+$('#employee_id').val()+"/6";					
				}
            }else{
				$('#gif').hide();
				notie.alert(3, '<?php _trans('toaster2'); ?>', 2);
            }
        });
	});


	$(document).on('submit', ".upload", function (e) {

		$('#showError').empty().append('');
		$('#showError').hide();
		
		if($("#document_name").val() == ''){
            $('#document_name').parent().addClass('has-error');
            return false;
		}else{
			$('.has-error').removeClass('has-error');
		}

		if($("#fileName").val() == ''){
			$('#showError').empty().append('Please choose the file');
            $('#showError').show();
            return false;
		}else{
			$('#showError').empty().append('');
			$('#showError').hide();
		}
		
		var attr_name = $(this).attr("upload-id");
		var forImg = this;
		e.preventDefault();
		e.stopPropagation ();
	
		$.ajax({
			url : "<?php echo site_url('upload/upload/upload_file/'.$this->mdl_mech_employee->form_value('employee_id', true)."/E/".$employee_url_key); ?>/",
			method:"POST",
			data : new FormData(this),
			contentType:false,
			cache:false,
			processData:false,
			success: function(data){
				var response = JSON.parse(data);
				if(response.success=='1'){
					getDeleteUploadFIle('','U',response.url_key);
				}else{
					$('#showError').empty().append('invalid file format');
					$('#showError').show();
				}
			}
		});
	});

    function getDeleteUploadFIle(id,type,file_name)
    {
    	$("#file").val('');
    	var employee_id = $("#employee_id").val();

		if(type == "D"){
			swal({
				title: "Are you sure?",
				text: "You will not be able to recover this imaginary file!",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel plx!",
				closeOnConfirm: false,
				closeOnCancel: false
			},
			function(isConfirm) {
				if (isConfirm) {

					$.post('<?php echo site_url('upload/getDeleteUploadData'); ?>', {
						entity_id : $('#employee_id').val(),
						entity_type : 'E',
						file_name : file_name,
						url_key : $("#url_key").val(),
						upload_id : id,
						upload_type : type,
						_mm_csrf: $('#_mm_csrf').val()
					}, function (data) {
							var list = JSON.parse(data);

							if (list.success === 1) {
								swal({
										title: "The row is deleted successfully",
										text: "Your imaginary file has been deleted.",
										type: "success",
										confirmButtonClass: "btn-success"
									},
									function() {
										if(list.doclist.length > 0)
										{
											var htmlStr = '';
											var href = '<?php echo base_url()."uploads/employee_files/";?>';
											htmlStr += '<h4>Uploaded Files</h4>';
											htmlStr += '<table class="car-table-box col-lg-12 col-md-12 col-sm-12 col-xs-12">';
											htmlStr += '<thead>';
											htmlStr += '<tr>';
											htmlStr += '<th>Document Type</th>';
											htmlStr += '<th>Document Name</th>';
											htmlStr += '<th align="center" class="text-center">Document Image</th>';
											htmlStr += '<th align="center" class="text-center">Option</th>';
											htmlStr += '</tr>';
											htmlStr += '</thead>';
											htmlStr += '<tbody id="uploaded_datas">';
											for(var i = 0; i < list.doclist.length; i++){
												htmlStr +='<tr>';
												htmlStr += '<td><span>'+list.doclist[i].document_name+'</span></td>';
												htmlStr += '<td><span>'+list.doclist[i].file_name_original+'</span></td>';
												htmlStr += '<td align="center" class="text-center" ><span style="cursor: pointer">';
												htmlStr += '<a href="'+href+''+list.doclist[i].file_name_new+'" target="_blank" >';
												htmlStr += '<img src="'+href+''+list.doclist[i].file_name_new+'" width="50" height="50">';
												htmlStr += '</a>';
												htmlStr += '</span></td>';
												htmlStr += '<td align="center" class="text-center"><span style="cursor: pointer" onclick="getDeleteUploadFIle(\''+list.doclist[i].upload_id+'\',\'D\',\''+list.doclist[i].file_name_original+'\')"><i class="fa fa-trash-o" aria-hidden="true"></i></span></td>';
												htmlStr += '</tr>';
											}
											htmlStr += '</tbody>';
											htmlStr += '</table>';
										
											$("#preview_section").empty().append(htmlStr);
											
										}else{
											$("#employeeDocumentCount").empty().append('0');
											$("#preview_section").empty().append('<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" > No document found </div>');
										}
										$("#document_name").val('');
									});
							} else {
								notie.alert(3, 'Error.', 2);
							}
						});
				} else {
					swal({
						title: "Cancelled",
						text: "Your imaginary file is safe :)",
						type: "error",
						confirmButtonClass: "btn-danger"
					});
				}
			});
		}else{
			$.post('<?php echo site_url('upload/getDeleteUploadData'); ?>', {
				entity_id : $('#employee_id').val(),
				entity_type : 'E',
				upload_id : id,
				url_key : $("#url_key").val(),
				upload_type : type,
				_mm_csrf: $('#_mm_csrf').val()
			}, function (data) {
				list = JSON.parse(data);
				if(list.success=='1'){
					if(list.doclist.length > 0)
					{
						var htmlStr = '';
						var href = '<?php echo base_url()."uploads/employee_files/";?>';
						htmlStr += '<h4>Uploaded Files</h4>';
						htmlStr += '<table class="car-table-box col-lg-12 col-md-12 col-sm-12 col-xs-12">';
						htmlStr += '<thead>';
						htmlStr += '<tr>';
						htmlStr += '<th>Document Type</th>';
						htmlStr += '<th>Document Name</th>';
						htmlStr += '<th align="center" class="text-center">Document Image</th>';
						htmlStr += '<th align="center" class="text-center">Option</th>';
						htmlStr += '</tr>';
						htmlStr += '</thead>';
						htmlStr += '<tbody id="uploaded_datas">';
						for(var i = 0; i < list.doclist.length; i++){
							htmlStr +='<tr>';
							htmlStr += '<td><span>'+list.doclist[i].document_name+'</span></td>';
							htmlStr += '<td><span>'+list.doclist[i].file_name_original+'</span></td>';
							htmlStr += '<td align="center" class="text-center" ><span style="cursor: pointer">';
							htmlStr += '<a href="'+href+''+list.doclist[i].file_name_new+'" target="_blank" >';
							htmlStr += '<img src="'+href+''+list.doclist[i].file_name_new+'" width="50" height="50">';
							htmlStr += '</a>';
							htmlStr += '</span></td>';
							htmlStr += '<td align="center" class="text-center"><span style="cursor: pointer" onclick="getDeleteUploadFIle(\''+list.doclist[i].upload_id+'\',\'D\',\''+list.doclist[i].file_name_original+'\')"><i class="fa fa-trash-o" aria-hidden="true"></i></span></td>';
							htmlStr += '</tr>';
						}
						htmlStr += '</tbody>';
						htmlStr += '</table>';
					
						$("#preview_section").empty().append(htmlStr);
						$("#employeeDocumentCount").empty().append(list.doclist.length);
					}else{
						$("#preview_section").empty().append('<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" > No document found </div>');
					}
					$("#document_name").val('');
				}
			});
		}
	}
</script>

<style>

.errorColor{
    color: red;
    font-size: 12px;
}

</style>