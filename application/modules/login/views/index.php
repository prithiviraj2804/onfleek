<?php $this->load->view('welcome/common/header'); ?>
<body>
	<!-- Loader -->
	<?php $this->load->view('welcome/common/loader'); ?>
	<!-- //Loader -->
	<!-- Header -->
	<?php $this->load->view('welcome/common/head_menu'); ?>
	<!-- // Header -->
	<!-- Content  -->
	<!--page Title-->
	<?php $this->load->view('welcome/common/page_title'); ?>
	<!--page Title-->
	<div id="pageContent">
		<!-- Block -->
		<div class="block offset-sm">
			<div class="container">
		<div id="gif" class="gifload">
			<div class="gifcenter">
			  <center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
		    </div>
		</div>
				<div class="col-sm-8">
				<h2><?php _trans('lable829'); ?></h2>
				<span><?php _trans('lable830'); ?></span>
									
					<input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?php echo $this->security->get_csrf_hash(); ?>" autocomplete="off">
					
					<div id="validation_error">
						<?php if(isset($login_credentials_incorrect)){ echo $login_credentials_incorrect; } ?>
						<?php if(isset($user_inactive)){ echo $user_inactive; } ?>
					</div>
					<div id="validation_success">
						<?php if(!empty($dynamic_validation)){ echo $dynamic_validation[0]; } ?>
					</div>
					
					<div class="row">
						<div class="col-sm-8">
							<div class="input-wrapper">
								<input type="text" name="mobile_no" id="mobile_no" class="form-control input-custom" autocomplete="off" value="" placeholder="10 Digit Mobile Number">	
							</div>
							<div id="validation_error">
								<?php if(isset($mobile_no_empty)){ echo $mobile_no_empty; } ?>
							</div>
						</div>
					</div>
					<div class="row" id="otp_div" style="display: none">
					
						<div class="col-sm-8">
							<span><?php _trans('lable831'); ?></span>
							<div class="input-wrapper">
								<input type="text" name="otp" id="otp" class="form-control input-custom" autocomplete="off" value="" placeholder="OTP">	
							</div>
							<div class="input-wrapper">
								<a id="resend"><?php _trans('lable832'); ?></a>
							</div>
							<div id="validation_error">
								<?php if(isset($otp_empty)){ echo $otp_empty; } ?>
							</div>
						</div>
					</div>
					<div class="divider-sm"></div>
					<div class="row">
						<div  class="col-sm-3">
							<a id="otp_submit" class="btn btn-lg"><?php _trans('lable833'); ?></a>
							<button style="display: none;" id="login_submit" value="1" name="btn_login" class="btn btn-lg"><span><?php _trans('lable834'); ?></span></button></div>
						<div class="col-sm-5 dont_have_account">
							<span>Don't Have An Account?</span><a href="<?php echo site_url('signup'); ?>"><?php _trans('lable835'); ?> </a>
						</div>
					</div>	
			</div>
			<div class="col-sm-4">
				<ul>
						<li>24/7 Appointment Booking &amp; Customer Support</li>
						<li>Real Time Tracking Vehicle Service Status</li>
						<li>Anytime, Anywhere Booking &amp; Monitoring</li>
						<li>Special Customized Subscription Packages</li>
						<li>Expert Technicians For Car Servicing</li>
						<li>24 Hour Road Side Assistance</li>
					</ul>
			</div>
			
		</div>
		</div>
		<!-- //Block -->
	</div>
	<!-- // Content  -->
	<!-- Footer -->
	<?php // $this->load->view('welcome/common/footer'); ?>
	<!-- //Footer -->
	<div class="darkout-menu"></div>
	<!-- Appointment Form -->
	<?php // include 'appointment_modelform.php'; ?>
	<!-- //Appointment Form -->
<!--frontend_common-->
<script type="text/javascript">
$(function () {
	        $('#otp_submit, #resend').click(function () {
	        	if($('#mobile_no').val()){
	        	$.post("<?php echo site_url('login/ajax/generate_mobile_otp'); ?>", {
                    mobile_no: $('#mobile_no').val(),
                    _mm_csrf: $('#_mm_csrf').val()
                },
                function (data) {
                	//console.log(data);
                	//return false;
                    var response = JSON.parse(data);
                    if ((response.success) == '0') {
                       $('#validation_error').empty().html('Phone number is not registered'); // clear the current elements in select box
                    }
                    else {
                       $('#validation_error').empty().html('');
                       $("#otp_submit").hide();
                       $("#login_submit").show();
                       $("#otp_div").show();
                    }
                });
                }else{
	        		$('#validation_error').empty().html('Phone number is empty');
	        	}
         });
         
         $('#login_submit').click(function () {
	        	if($('#mobile_no').val() != "" && $('#otp').val() !=""){
					$('#gif').show();
	        	$.post("<?php echo site_url('login/ajax/login'); ?>", {
                    mobile_no: $('#mobile_no').val(),
                    otp: $('#otp').val(),
                    _mm_csrf: $('#_mm_csrf').val()
                },
                function (data) {
                    var response = JSON.parse(data);
                    if ((response.success) == '0') {
						$('#gif').hide();
                       $('#validation_error').empty().html(response.msg); // clear the current elements in select box
                    }
                    else {
                       $('#validation_error').empty().html('');
                       window.location = "<?php echo site_url('dashboard'); ?>";
                    }
                });
                }else{
					$('#gif').hide();
	        		$('#validation_error').empty().html('Login details is empty');
	        	}
         });
         
         
       });
</script>
	<?php  $this->load->view('welcome/common/frontend_commonjs'); ?>
<!--frontend_common-->	
