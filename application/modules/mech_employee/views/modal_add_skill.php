<script type="text/javascript">
    $(function () {

        // Display the create quote modal
        $('#addNewCar').modal('show');
		$("#skill_id").select2();
        $(".bootstrap-select").selectpicker("refresh");
        var model_from = "<?php echo $model_from; ?>";
		var employee_id = "<?php echo $employee_id; ?>";
		
        $('#add_skill_details').click(function () {
		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');
		var validation = [];
		var skill_id = $("#skill_id").val();
		if($("#skill_id").val() == '' || $("#skill_id").val() == null){
		validation.push('skill_id');
		}
		
		if(validation.length > 0){
			validation.forEach(function(val) {
				$('.select2-selection.select2-selection--multiple').addClass("border_error");
				// if($('#'+val+'_error').length == 0){
				// 	$('#'+val).parent().addClass('has-error');
				// }
		});
		return false;
		}
		
		
		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');
		$('#gif').show();

		$.post("<?php echo site_url('mech_employee/ajax/addskill'); ?>", {
			skill_ids: $('#skill_id').val(),
			employee_id:$('#employee_id').val(),
			model_from: $('#model_from').val(),
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
						window.location = '<?php echo site_url('mech_employee/form'); ?>/'+employee_id+'/2';	
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
				window.location = '<?php echo site_url('mech_employee/form'); ?>/'+employee_id+'/2';
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
				<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" autocomplete="off"/>
				<div class="modal-header">
					<div class="col-xs-12 text-center">
						<?php if (!empty($employee_skill_list)) {
    ?> 
						<h3 class="modal__h3"><?php _trans('lable168'); ?></h3>
						<?php
} else {
        ?> 
						<h3 class="modal__h3"><?php _trans('lable166'); ?></h3>
						<?php
    } ?>
					</div>
					<button type="button" class="modal-close modal-popup-close">
						<i class="font-icon-close-2"></i>
					</button>
				</div>
				<div class="modal-body" style="min-height: 250px;">
					<div class="form">
						<div class="row">
							<div class="form_group">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:0px 15px 0px 0px;" > 
									<label class="form_label section-header-text"><?php _trans('lable169'); ?>*</label>
									<select  name="skill_id[]" id="skill_id" class="select2 bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" multiple="multiple" autocomplete="off">
										<?php if (!empty($skill_list)) : ?>
										<?php $employee_skill_list = explode(',', $skill_ids);
                                        foreach ($skill_list as $skilllist) {
                                            if (in_array($skilllist->skill_id, $employee_skill_list)) {
                                                $selected = "selected='selected'";
                                            } else {
                                                $selected = '';
                                            } ?>
										<option value="<?php echo $skilllist->skill_id; ?>" <?php echo $selected; ?>><?php echo $skilllist->skill_name; ?></option>
										<?php
                                        } endif; ?>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer text-center">
					<button type="button" class="btn btn-rounded btn-primary"  name="add_skill_details" id="add_skill_details"><?php _trans('lable170'); ?></button>
					<button type="button" class="btn btn-rounded btn-default modal-popup-close"><?php _trans('lable171'); ?></button>
				</div>
			</form>
		</div>
	</div>
</div>	