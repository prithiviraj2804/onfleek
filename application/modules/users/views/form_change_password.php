<input type="hidden" id="_mm_csrf" name="_mm_csrf" value="<?= $this->security->get_csrf_hash() ?>">
<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php _trans('lable678'); ?></h3>
				</div>
			</div>
		</div>
	</div>
</header>

<div id="content">
<div class="col-sm-9">
	<input class="hidden" name="is_update" id="is_udpate" type="hidden" value="<?php if($this->mdl_users->form_value('is_update')){
		echo "1";
			} else {
					echo "0";
			}?>">
	<input type="hidden" name="user_id" id="user_id" class="form-control" value="<?php echo $this->mdl_users->form_value('user_id', true); ?>"autocomplete="off">
</div>
<div class="row">
	<div class="col-xs-12 col-md-12 col-md-offset-3">
		<?php $this->layout->load_view('layout/alerts'); ?>
			<div class="container-wide">
				<div class="box">
					<div class="box_body">
							<div class="form_group">
								<label class="form_label"><?php _trans('lable679'); ?></label>
								<div class="form_controls">
									<input class="form-control g-input" type="password" name="user_password" id="user_password" autocomplete="off">
									<span class="error" id="user_password_errmsg" style="display:none;"></span>
								</div>
							</div>
							<div class="form_group">
								<label class="form_label"><?php _trans('lable680'); ?></label>
								<div class="form_controls">
									<input class="form-control g-input" type="password" name="user_passwordv" id="user_passwordv" autocomplete="off">
									<span class="error" id="user_passwordv_errmsg" style="display:none;"></span>
								</div>
							</div>
							<div class="buttons text-center paddingTop5px">
								<button id="btn_submit" name="btn_submit" class="btn btn-rounded btn-primary" value="1">
									<i class="fa fa-check"></i> <?php _trans('save'); ?>
								</button>
								<button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default" value="1">
									<i class="fa fa-times"></i> <?php _trans('cancel'); ?>
								</button>
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">		
	$("#btn_cancel").click(function () {
        window.location.href = "<?php echo site_url('users/form'); ?>"+"/<?php echo $this->mdl_users->form_value('user_id', true); ?>";
		return false;
    });

    $("#btn_submit").click(function () {		

		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');

		var validation = [];

		if($("#user_password").val() == ''){
			validation.push('user_password');
		}
		if($("#user_passwordv").val() == ''){
			validation.push('user_passwordv');
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

	$("#user_password_errmsg").hide();
	var password = $('#user_password').val();

	if(password.length < 8 ){
		$("#user_password_errmsg").show();		
		$('#user_password_errmsg').empty().append('Use 8 or more characters');
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
	if ($('#user_password').val() == $('#user_passwordv').val()) {
		$('#user_passwordv_errmsg').empty().append('');
		$('#user_passwordv_errmsg').hide();
	}else {
		$('#user_passwordv_errmsg').show();
		$('#user_passwordv_errmsg').empty().append('Password did not Match');
		return false;
	}

		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');
		$('#gif').show();

		$.post('<?php echo site_url('users/ajax/create'); ?>', {
			user_id : $("#user_id").val(),
            user_password : $("#user_password").val(),
            user_passwordv : $("#user_passwordv").val(),
			is_udpate : $("#is_udpate").val(),
			_mm_csrf: $('#_mm_csrf').val()
        }, function (data) {
            list = JSON.parse(data);
            if(list.success=='1'){
                notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
					$('#gif').hide(); 
					window.location = "<?php echo site_url('users/form/'); ?>"+list.user_id;
            }else if(list.success == '2'){
				$('#gif').hide();	
				notie.alert(3, 'Already Existed', 2);
			}else{
				$('#gif').hide();
				notie.alert(3, '<?php _trans('toaster2'); ?>', 2);
				$('.has-error').removeClass('has-error');
                for (var key in list.validation_errors) {
                    $('#' + key).parent().addClass('has-error');
                    $('.error_msg_' + key).show().empty().html(list.validation_errors[key]);
                }
            }
        });
	});
</script>