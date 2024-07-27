<input type="hidden" id="_mm_csrf" name="_mm_csrf" value="<?= $this->security->get_csrf_hash(); ?>">
<div id="content">
	<div class="row">
		<div id="gif" class="gifload">
			<div class="gifcenter">
			  <center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
		    </div>
		</div>
		<div class="col-xs-12 top-15">
			<a class="anchor anchor-back" onclick="goBack()" href="javascript:void(0)"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
		</div>
		<div class="col-xs-12 col-md-12 col-md-offset-3">
			<div class="container-wide">
				<input name="mvt_id" type="hidden" id="mvt_id" value="<?php echo $mech_vehicle_type->mvt_id;?>">
				<div class="withfull box">
					<div class="withfull box_body">
						<div class="withfull form-group clearfix">
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
								<label class="form_label"> <?php _trans('lable78'); ?>*</label>
							</div>
							<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="vehicle_type_name" id="vehicle_type_name" class="form-control" value="<?php echo $mech_vehicle_type->vehicle_type_name;?>">
							</div>
						</div>
						<div class="withfull form-group clearfix">
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
								<label class="form_label"> <?php _trans('lable877'); ?>*</label>
							</div>
							<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
								<input type="text" name="vehicle_type_value" id="vehicle_type_value" class="form-control" value="<?php echo $mech_vehicle_type->vehicle_type_value;?>">
							</div>
						</div>
						<div class="withfull form_group buttons text-center paddingTop20px">
							<button value="1" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
								<i class="fa fa-check"></i> <?php _trans('lable57'); ?>
							</button>
							<button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default">
								<i class="fa fa-times"></i> <?php _trans('lable58'); ?>
							</button>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>
<script type="text/javascript">

$(document).ready(function() {

	$("#btn_cancel").click(function () {
		window.location.href = "<?php echo site_url('workshop_setup/index/10'); ?>";
    });


	$(".btn_submit").click(function () {

		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');

		var validation = [];

		if($("#vehicle_type_name").val() == ''){
			validation.push('vehicle_type_name');
		}

		if($("#vehicle_type_value").val() == ''){
			validation.push('vehicle_type_value');
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

		$.post('<?php echo site_url('mech_vehicle_type/ajax/create'); ?>', {
			mvt_id : $("#mvt_id").val(),
			vehicle_type_name : $("#vehicle_type_name").val(),
			vehicle_type_value : $("#vehicle_type_value").val(),
			_mm_csrf: $('#_mm_csrf').val()
		}, function (data) {	
			list = JSON.parse(data);
			if(list.success == '1' || list.success == 1){
				setTimeout(function(){
					notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
					window.location.href = "<?php echo site_url('workshop_setup/index/10'); ?>";
				}, 100);
			}else if(list.success == '2' || list.success == 2){
				$('#gif').hide();	
				notie.alert(3, '<?php _trans('err5'); ?>', 2);
			}
			else{
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
});
</script>