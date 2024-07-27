<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>MechToolz</title>

	<?php /* * / ?>
	<link href="<?php echo base_url(); ?>assets/mp_backend/img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="<?php echo base_url(); ?>assets/mp_backend/img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
	<link href="<?php echo base_url(); ?>assets/mp_backend/img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
	<link href="<?php echo base_url(); ?>assets/mp_backend/img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
	<?php / * */ ?>
	<link href="<?php echo base_url(); ?>assets/mp_backend/img/favicon-32x32.png" rel="icon" type="image/png">
	<link href="<?php echo base_url(); ?>assets/mp_backend/img/favicon.ico" rel="shortcut icon">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/separate/pages/login.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/lib/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/main.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/signup.css">
</head>
<!-- <style>
	body{
		background: url(../../assets/mm_fe_latest/images/slider/slide1.jpg);
		background-size: cover;
	}
</style> -->
<body>
<?php /* * / ?><img src="<?php echo base_url(); ?>/assets/mm_fe_latest/images/mm_custom/mechpoint.svg" alt="MechPoint"><?php / * */ ?>

<div class="page-center">
	<div class="page-center-in">
		<div id="gif" class="gifload">
			<div class="gifcenter">
			  <center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
		    </div>
		</div>
		<div class="container-fluid getHeight">
			<form class="sign-box" autocomplete="off">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
					<div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 hidden-xs-down">
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
							<div class="imageDynamicHeight" style="display: table;">
								<div style="display: table-cell;vertical-align: middle;">
									<img style="width: 100%; float:left;" src="<?php echo base_url(); ?>assets/mp_backend/img/mechtoolzsignuptwo.jpg" alt="Mechtoolz">
								</div>
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
							<div class="imageDynamicHeight" style="display: table;">
								<div style="display: table-cell;vertical-align: middle;">
									<img style="width: 100%; float:left;" src="<?php echo base_url(); ?>assets/mp_backend/img/mechtoolzsignup.jpg" alt="Mechtoolz">
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
						<input type="hidden" id="_mm_csrf" name="_mm_csrf" value="<?= $this->security->get_csrf_hash() ?>">
						<div class="mechtoollogo">
							<img src="<?php echo base_url(); ?>assets/mp_backend/img/mechtoolz-logo.svg" alt="Mechtoolz">
						</div>
						<header class="sign-title"><?php _trans('lable835'); ?></header>
						<div class="form-group">
							<input type="text" onkeypress="showOtpButton()" name="user_name" id="user_name" class="form-control" placeholder="Full name" autocomplete="off">
							<div class="error" id="invalidname"></div>
						</div>
						<div class="form-group">
							<input type="text" onkeypress="showOtpButton()" name="workshop_name" id="workshop_name" class="form-control" placeholder="Workshop Name" autocomplete="off">
							<div class="error" id="invalidWorkshopName"></div>
						</div>
						<div class="form-group">
							<input type="text" onkeypress="showOtpButton()" name="user_mobile" id="user_mobile" class="form-control" placeholder="Phone number" autocomplete="off"/>
							<div class="error" id="invalidmobileno"></div>
						</div>
						<div class="form-group">
							<input type="email" onkeypress="showOtpButton()" name="user_email" id="user_email" class="form-control" placeholder="E-Mail" autocomplete="off"/>
							<div class="error" id="invalidemail"></div>
						</div>
						<div class="form-group">
							<input type="password" onkeypress="showOtpButton()" name="password" id="password" class="form-control" placeholder="Password" autocomplete="off" />
							<span class="error" id="user_password_errmsg" style="display:none;"></span>
							<p class="message" id="message">Use 8 or more characters with a mix of letters, numbers & symbols</p>
						</div>
						<div class="form-group">
							<input type="password" onkeypress="showOtpButton()" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password" autocomplete="off" />
							<span class="error" id="user_passwordv_errmsg" style="display:none;"></span>
						</div>
						<div class="form-group">
							<select id="subscription_plan" name="subscription_plan" class="form-control" >
								<option value="1">Car Care</option>
								<option value="2">Car Repair and Service</option>
								<option value="3">Automobile Sales</option>
							</select>
						</div>
						<div class="row" id="otp_div" style="display: none">
							<div class="col-sm-12">
								<span class="otpMessage" >Please enter the OTP sent on your mobile number in the box below</span>
								<div class="form-group">
									<input type="text" name="otp" id="otp" class="form-control input-custom" value="" placeholder="OTP" autocomplete="off">	
								</div>
								<div class="form-group">
									<a id="resend" onclick="resendotp();">Resend OTP?</a>
								</div>
							</div>
						</div>
						<div class="error" id="validation_error"></div>
						<div id="validation_success"></div>
						<a onclick="otp_submit();" style="display: none"  id="otpform" name="otpform" value="1" class="btn btn-rounded"><span>Send OTP</span></a>
						<a onclick="signup_submit();" style="display: none" id="signupform" name="signupform" value="2" class="btn btn-rounded colorWhite"><span>Sign Up</span></a>
						<div class="row">
							<div class="col-sm-12 text-center dont_have_account">
								<span>Already have an account?</span><a href="<?php echo site_url('login'); ?>"> Log in</a>
							</div>
						</div>
					</div>
				</div>
			</form>		
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>assets/mp_backend/js/lib/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/mp_backend/js/lib/popper/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/mp_backend/js/lib/tether/tether.min.js"></script>
<script src="<?php echo base_url(); ?>assets/mp_backend/js/lib/bootstrap/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/mp_backend/js/plugins.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/mp_backend/js/lib/match-height/jquery.matchHeight.min.js"></script>
<script type="text/javascript">

$(function() {

	var getHeight = $(".getHeight").height();

	$(".imageDynamicHeight").css('height' , getHeight);

	$("input").keyup(function(){
		var len = (this.value).length;
		if(len > 0){
			$('#'+$(this).attr('name')+'_error').remove();
			$('#'+$(this).attr('name')).removeClass('border_error');
		}
	});

	$('.page-center').matchHeight({
		target: $('html')
	});

	$(window).resize(function(){
		setTimeout(function(){
			$('.page-center').matchHeight({ remove: true });
			$('.page-center').matchHeight({
				target: $('html')
			});
		},100);
	});

});

</script>

<script src="<?php echo base_url(); ?>assets/mp_backend/js/app.js"></script>

<script type="text/javascript">

function showOtpButton(){
	if($("#workshop_name").val() != '' && $("#user_name").val() != '' && $("#subscription_plan").val() != ""  && $("#user_mobile").val() != '' && $("#user_email").val() != '' && $("#password").val() != '' &&$("#confirm_password").val() != ''){
		$("#otpform").show();
	}else{
		$("#otpform").hide();
	}
}

function otp_submit(){
	get_otp();
}

function resendotp(){
	$('#otp').val('');
	$.post("<?php echo site_url('sessions/resendotp'); ?>", {
		user_company: $("#workshop_name").val(),
		user_email: $('#user_email').val(),
		user_mobile: $('#user_mobile').val(),
		_mm_csrf: $('#_mm_csrf').val()
	},function (data) {
		var response = JSON.parse(data);
		if (response.success == '1') {
			$("#validation_success").empty().append('New Opt has been sent');
		}else {
			
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
	$('#otp').val('');
	var user_company = $("#workshop_name").val();
	var user_name = $('#user_name').val();
	var user_mobile = $('#user_mobile').val();
	var user_email = $('#user_email').val();
	var passwordo = $('#password').val();
	var confirm_password = $('#confirm_password').val();
	var subscription_plan = $("#subscription_plan").val();
	var validation = [];

	if(user_company == ''){
		validation.push('workshop_name');
	}

	if(user_name == ''){
		validation.push('user_name');
	}

	if(user_mobile == '' || user_mobile.length < 10){
		validation.push('user_mobile');
	}else{
		if (!validatePhone(user_mobile)) {
			validation.push('user_mobile');
        }
	}

	if(user_email == ''){
		validation.push('user_email');
	}else{
		if (!validateEmail(user_email)) {
			validation.push('user_email');
        }
	}

	if(passwordo == ''){
		validation.push('password');
	}

	if(confirm_password == ''){
		validation.push('confirm_password');
	}

	if(subscription_plan == ''){
		validation.push('subscription_plan');
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

	if($('#user_mobile').val()){

		$("#gif").show();

		$.post("<?php echo site_url('sessions/generate_signup_otp'); ?>", {
			user_company : $("#workshop_name").val(),
			user_name : $("#user_name").val(),
			user_mobile: $('#user_mobile').val(),
			user_email: $('#user_email').val(),
			user_password: $('#password').val(),
			user_passwordv: $('#confirm_password').val(),
			subscription_plan: $('#subscription_plan').val(),
			_mm_csrf: $('#_mm_csrf').val()
        },function (data) {
			var response = JSON.parse(data);
			if ((response.success) == '0') {
				$("#gif").hide();
				$('#validation_error').empty().html(response.error.error_msg);
            }else {
				$("#gif").hide();
				$("#workshop_name").attr('readonly',true);
				$("#user_email").attr('readonly',true);
				$("#user_mobile").attr('readonly',true);
				$('#password').attr('readonly',true);
				$('#confirm_password').attr('readonly',true);
				$('#validation_error').empty().html('');
				$('#otpform').hide();
            	$("#signupform").show();
                $("#otp_div").show();     
            }
        });
    }else{
		$('#validation_error').empty().html('Phone number is empty');
	}
}

function signup_submit(){

	var user_company = $('#workshop_name').val();
	var user_name = $('#user_name').val();
	var user_mobile = $('#user_mobile').val();
	var user_email = $('#user_email').val();
	var passwordo = $('#password').val();
	var otp = $('#otp').val();
	var confirm_password = $('#confirm_password').val();
	var validation = [];
	var subscription_plan = $("#subscription_plan").val();

	if(user_company == ''){
		validation.push('workshop_name');
	}

	if(user_name == ''){
		validation.push('user_name');
	}

	if(user_mobile == ''){
		validation.push('user_mobile');
	}else{
		if (!validatePhone(user_mobile)) {
			validation.push('user_mobile');
        }
	}

	if(user_email == ''){
		validation.push('user_email');
	}else{
		if (!validateEmail(user_email)) {
			validation.push('user_email');
        }
	}

	if(passwordo == ''){
		validation.push('password');
	}

	if(confirm_password == ''){
		validation.push('confirm_password');
	}

	if(subscription_plan == ''){
		validation.push('subscription_plan');
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

	if($('#user_mobile').val() != ""){
		$('#gif').show();
		$.post("<?php echo site_url('sessions/submit_signup'); ?>", {
			user_company : $("#workshop_name").val(),
			user_mobile: $('#user_mobile').val(),
			user_name: $('#user_name').val(),
			user_email: $('#user_email').val(),
			user_password: $('#password').val(),
			user_passwordv: $('#confirm_password').val(),
			subscription_plan: $('#subscription_plan').val(),
            from:'signup',
            otp: $('#otp').val(),
            _mm_csrf: $('#_mm_csrf').val()
    	},function (data) {
            var response = JSON.parse(data);
            if ((response.success) == '0') {
				if(response.msg.msg){
					$('#gif').hide();
					$('#validation_error').empty().html(response.msg.msg);
				}else{
					$('#gif').hide();
					$('#validation_error').empty().html(response.msg);
				}
            }else{
				$("#gif").hide();
				$('#validation_error').empty().html('');
				window.location = "<?php echo site_url('login'); ?>";
            }
        });
    }else{
		$('#gif').hide();
	    $('#validation_error').empty().html('Login details is empty');
	}
}
</script>
</body>
</html>