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
		<div class="sign-box" autocomplete="off">
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
						<header class="sign-title"><?php _trans('lable1030'); ?></header>

						<div class="form-group enter_email" id="first">
							<div class="form-group">
								<input type="email" name="user_email" id="user_email" class="form-control" placeholder="Enter Your Email" autocomplete="off"/>
							</div>
							<div class="error validation_error"></div>
							<div class="validation_success"></div>

							<div class="footer text-center" id="getcode_hide">
								<button class="btn btn-rounded">
								<a onclick="forget_submit();" id="getcode" name="getcode" value="1"><span>GET CODE</span></a>
								</button>
							</div>
						</div>

						<div class="form-group enter_code" style="display:none;" id="second">
							<div class="form-group">
								<input type="text" class="form-control" name="verification_code" id="verification_code" placeholder="Enter Your Vrification Code" autocomplete="off">
							</div>
							<div class="error validation_code"></div>
							<div class="validation_success"></div>
							<div class="footer text-center" id="verifiy_hide">
								<button class="btn btn-rounded">
								<a onclick="getcode_submit();">SUBMIT</a>
								</button>
							</div>
						</div>

						<div class="form-group new_psw" style="display:none;" id="third">
							<div class="form-group">
							<input type="password" class="form-control" name="password_new" id="password_new" placeholder="Enter Your New Password" autocomplete="off">
							<span class="error" id="user_password_errmsg" style="display:none;"></span>
							<p class="message" id="message">Use 8 or more characters with a mix of letters, numbers & symbols</p>
							</div>

							<div class="form-group">
                            <input type="password" class="form-control" name="password_confirm" id="password_confirm" placeholder="Retype New Password" autocomplete="off">
							</div>
							<div class="error validation_psw"></div>
				    		<div class="validation_success"></div>
							<div class="footer text-center">
								<button class="btn btn-rounded">
								<a onclick="getnewpassword_submit();" name="submit_psw" id="submit_psw">SUBMIT</a>
								</button>
							</div>
							<div class="error reset_success"></div>
						</div>

					</div>
				</div>
			</div>
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
/* Forget password */
function forget_submit()
{
    var user_email = $('#user_email').val();
    if($('#user_email').val() != "")
    {
		$('#gif').show();
		$.post("<?php echo site_url('sessions/forgotpassword'); ?>", {
			user_email: $('#user_email').val(),
			_mm_csrf: $('#_mm_csrf').val()
    	},function (data) {
			<?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
            var response = JSON.parse(data);
            if(response.success == 0)
            {
				$('#gif').hide();
				if(response.msg){
					$('.validation_error').empty().html(response.msg);
				}
                return false;
            }else if(response.success == 1)
            {	
				$('#gif').hide();
				if(response.msg){
					$('.validation_error').empty().html(response.msg);
				}
                return false;
            }
            else if(response.success == 2)
            {
				$('#gif').hide();
                $("#first").show();
				$("#getcode_hide").hide();
                $("#second").show();
                $("#third").hide();
                $('.validation_error').empty().html('');
            }
            else{
				$('#gif').hide();
				$('.validation_error').empty().html('');
				window.location = "<?php echo site_url('login');?>";
            }
        });
    }
    else
    {
		$('#gif').hide();	
	    $('.validation_error').empty().html('Please Enter A Valid E-Mail Id');
	}
}        

/* Get Verification Code */

function getcode_submit()
{
    var user_email = $('#user_email').val();
    var verification_code = $('#verification_code').val();
    if($('#verification_code').val() != "")
    {
		$('#gif').show();
		$.post("<?php echo site_url('sessions/verificationcode'); ?>", {
			user_email: $('#user_email').val(),
            verification_code: $('#verification_code').val(),
			_mm_csrf: $('#_mm_csrf').val()
    	},function (data) {
			<?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
            var response = JSON.parse(data);
            if(response.success == 4)
            {
				$('#gif').hide();
                $("#first").show();
                $("#second").show();
				$("#getcode_hide").hide();
				$("#verifiy_hide").hide();
                $("#third").show();
                $('.validation_code').empty().html('');
            }else if(response.success == 5)
            {	
				$('#gif').hide();
				if(response.msg){
					$('.validation_code').empty().html(response.msg);
				}
                return false;
            }
        });
    }
    else
    {	
		$('#gif').hide();
	    $('.validation_code').empty().html('Code is Empty');
	}
}  

/* confirmpsw matching validation */
$('#password_new, #password_confirm').on('keyup', function () {
	if($('#password_new').val() != ''){
		$('#user_password_errmsg').empty().append('');
		$("#user_password_errmsg").hide();
	}
	if ($('#password_new').val() == $('#password_confirm').val()) 
	{
		$('.validation_psw').html('Password Is Matching').css('color', 'green');
	} else{
		$('.validation_psw').html('Password Is Not Matching').css('color', 'red');
	}
	if ($('#password_new').val() == '' && $('#password_confirm').val() == '') {
		$('.validation_psw').empty().html('');
	}

});

function getnewpassword_submit()
{
    var user_email = $('#user_email').val();
    var password_new = $('#password_new').val();
    var password_confirm = $('#password_confirm').val();

	$("#user_password_errmsg").hide();

	if(password_new.length < 8 ){
		$("#user_password_errmsg").show();		
		$('#user_password_errmsg').empty().append('Invalid Password');
		return false;
	} else {
	    $('#user_password_errmsg').empty().append('');
		$("#user_password_errmsg").hide();
	}

   	if(password_new.match(/[A-Z]/)) {
		$('#user_password_errmsg').empty().append('');
		$("#user_password_errmsg").hide();
	} else {
		$("#user_password_errmsg").show();
		$('#user_password_errmsg').empty().append('Atleast one Caps letter');
		return false;
	}

	if (password_new.match(/\d/) ) {
		$('#user_password_errmsg').empty().append('');
		$("#user_password_errmsg").hide();
	} else {
		$("#user_password_errmsg").show();
	    $('#user_password_errmsg').empty().append('Atleast one numeric');
		return false;
	}
	
  	if(password_new.match(/[~`!@#$%^&*()-_+={}[|\;:"<>,./?]/)) {
		$('#user_password_errmsg').empty().append('');
		$("#user_password_errmsg").hide();
	} else {
		$("#user_password_errmsg").show();
  		$('#user_password_errmsg').empty().append('Atleast one special character');
		return false;
	}

  	if(password_new.length==0)
	{
		$('#user_password_errmsg').empty().append('');
		$("#user_password_errmsg").hide();
	}


    if($('#user_email').val() != "" && (password_new == password_confirm) && password_confirm != '')
    {	
		$('#gif').show();
		$.post("<?php echo site_url('sessions/updatenewpassword'); ?>", {
			user_email: $('#user_email').val(),
            password_new: $('#password_new').val(),
			_mm_csrf: $('#_mm_csrf').val()
    	},function (data) {
			<?php echo(IP_DEBUG ? 'console.log(data);' : ''); ?>
            var response = JSON.parse(data);
            if(response.success == 0)
            {
				$('#gif').hide();
				if(response.msg){
					$('.validation_error').empty().html(response.msg);
				}
                return false;
            }else if(response.success == 1)
            {		    
				$('.validation_code').empty().html('');
				$('.validation_error').empty().html('');
				$('.validation_psw').empty().html('');
				$('#user_password_errmsg').empty().append('');
				$('#gif').hide();
                $('.reset_success').html('Your password has been reset successfully!').css('color', 'blue');
				setTimeout(function(){
					window.location = "<?php echo site_url('sessions');?>";
					}, 300);                
            }
        });
    }
    else
    {
		$('#gif').hide();
	    $('.validation_psw').empty().html('Password Is Not Matching');
	}
}  

</script>
</body>
</html>