<script type="text/javascript">
    $(function () {
        // Display the create quote modal
        $('#addBank').modal('show');
        $(".bootstrap-select").selectpicker("refresh");

		var entity_id = '<?php echo $entity_id; ?>';
		var module_type = '<?php echo $module_type; ?>';
          $('#add_bank_details').click(function () {
			//   $(".hideSubmitButtons").hide();

					$('.border_error').removeClass('border_error');
					$('.has-error').removeClass('has-error');

					var validation = [];
					if($("#bank_branch_id").val() ==''){
						validation.push('bank_branch_id');
					}

					if($("#bank_account_holder_name").val() == ''){
						validation.push('bank_account_holder_name');
					}
					if($("#bank_account_number").val() == ''){
						validation.push('bank_account_number');
					}
					if($("#bank_account_type").val() == ''){

						validation.push('bank_account_type');
					}
					if($("#bank_name").val() == ''){
						validation.push('bank_name');
					}
					if($("#bank_ifsc_Code").val() == ''){
						validation.push('bank_ifsc_Code');
					}
					// if($("#bank_branch").val() == ''){
					// 	validation.push('bank_branch');
					// }

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
			

			  
            $.post("<?php echo site_url('mech_bank_list/ajax/create'); ?>", {
            		bank_id: $('#bank_id').val(),
					branch_id : $('#bank_branch_id').val(),
                    account_holder_name: $('#bank_account_holder_name').val(),
                    account_number: $('#bank_account_number').val(),
                    account_type: $('#bank_account_type').val(),
                    bank_name: $('#bank_name').val(),
                    bank_ifsc_Code: $('#bank_ifsc_Code').val(),
                    bank_branch: $('#bank_branch').val(),
                    is_default: $("input[name='is_default']:checked").val(),
					module_type: $('#module_type').val(),
					entity_id: $('#entity_id').val(),
					current_balance: $('#current_balance').val(),
                    _mm_csrf: $('#_mm_csrf').val()
                },
                function (data) {
                    var response = JSON.parse(data);
					$('#' + key).parent().removeClass('has-error');
                    if(response.success == 1){
						notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
						$('#add_bank_fdetail').hide();
						$('#addBank').modal('hide');
						if(module_type == 'B'){
							window.location.href = "<?php echo site_url('workshop_setup/index'); ?>/3";
						}else if(module_type == 'S'){
							window.location.href = "<?php echo site_url('suppliers/form'); ?>/"+entity_id+"/4";
                    	}else if(module_type == 'E'){
							window.location = '<?php echo site_url('mech_employee/form'); ?>/'+entity_id+'/4';
                        }else{
							window.location.href = window.location.href+'/2';
						}
                    } else {
						$('#gif').hide(); 
						$('.has-error').removeClass('has-error');
						// console.log();
                    	for (var key in response.validation_errors) {
							if(key == "account_holder_name"){
								$('#bank_account_holder_name').parent().addClass('has-error');
                            	$('.error_msg_#bank_account_holder_name').show().empty().html(response.validation_errors[key]);
							}else if(key == "account_number"){
								$('#bank_account_number').parent().addClass('has-error');
                            	$('.error_msg_#account_number').show().empty().html(response.validation_errors[key]);
							}else if(key == "bank_branch"){
								$('#bank_branch').parent().addClass('has-error');
                            	$('.error_msg_#bank_branch').show().empty().html(response.validation_errors[key]);
							}else if(key == "bank_ifsc_Code"){
								$('#bank_ifsc_Code').parent().addClass('has-error');
                            	$('.error_msg_#bank_ifsc_Code').show().empty().html(response.validation_errors[key]);
							}else if(key == "bank_name"){
								$('#bank_name').parent().addClass('has-error');
                            	$('.error_msg_#bank_name').show().empty().html(response.validation_errors[key]);
							}else if(key == "current_balance"){
								$('#current_balance').parent().addClass('has-error');
                            	$('.error_msg_#current_balance').show().empty().html(response.validation_errors[key]);
							}else if(key == "account_type"){
								$('#bank_account_type').parent().addClass('has-error');
                            	$('.error_msg_#account_type').show().empty().html(response.validation_errors[key]);
							}
                            
                        }
                    }
                });
        });

		$('.modal-popup-close').click(function () {
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
<div class="modal fade" id="addBank" tabindex="-1" role="dialog" aria-labelledby="addbankLabel">
	<div class="modal-dialog" role="document">
		<div id="gif" class="gifload">
			<div class="gifcenter">
			  <center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
		    </div>
		</div>
		<div class="modal-content" id="add_bank_fdetail">
			<form name="customer_fdetails" method="post">
				<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" autocomplete="off">
				<input type="hidden" name="bank_id" id="bank_id" value="<?php echo $bank_id; ?>" />
				<input type="hidden" name="module_type" id="module_type" value="<?php echo $module_type; ?>" autocomplete="off">
				<input type="hidden" name="entity_id" id="entity_id" value="<?php echo $entity_id; ?>" autocomplete="off">
				<div class="modal-header">
					<button type="button" class="modal-close modal-popup-close">
						<i class="font-icon-close-2"></i>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12"><h2 class="text_align_center"><?php _trans('lable94'); ?></h2></div>
					</div>
					<div class="row">
							<div class="col-lg-6">
								<div class="col-lg-12">
									<fieldset class="form-group">
										<label class="form-label semibold" for="bank_branch_id"><?php _trans('lable95'); ?>*</label>
										<select id="bank_branch_id" name="bank_branch_id" class="form-control bootstrap-select bootstrap-select-arrow form-control removeErrorInput" data-live-search="true" autocomplete="off">
										<option value=""><label><?php _trans('lable51'); ?></label>
										<?php foreach ($branch_list as $branchList) {?>
										<option value="<?php echo $branchList->w_branch_id; ?>" <?php if($bank_details->branch_id == $branchList->w_branch_id){echo "selected";}?> > <?php echo $branchList->display_board_name; ?></option>
										<?php } ?>
									</select>
									</fieldset>
								</div>
								<div class="col-lg-12">
									<fieldset class="form-group">
										<label class="form-label semibold" for="current_balance"><?php _trans('lable96'); ?></label>
										<input type="text" value="<?php if ($bank_id) {
    echo $bank_details->current_balance;
}?>" class="form-control" id="current_balance" name="current_balance" placeholder="Opening Balance" autocomplete="off">
									</fieldset>
								</div>
								<div class="col-lg-12">
									<fieldset class="form-group">
										<label class="form-label semibold" for="bank_account_holder_name"><?php _trans('lable97'); ?>*</label>
										<input type="text" value="<?php if ($bank_id) {
    echo $bank_details->account_holder_name;
}?>" class="form-control " name="bank_account_holder_name" id="bank_account_holder_name" placeholder="Account Holder Name" autocomplete="off">
									</fieldset>
								</div>
								<div class="col-lg-12">
									<fieldset class="form-group">
										<label class="form-label semibold" for="bank_account_number"><?php _trans('lable98'); ?>*</label>
										<input type="text" value="<?php if ($bank_id) {
    echo $bank_details->account_number;
}?>" class="form-control" id="bank_account_number" name="bank_account_number" placeholder="Account Number" autocomplete="off">
									</fieldset>
								</div>
								<div class="col-lg-12">
									<fieldset class="form-group">
										<input type="checkbox" class="form-control bankisdefault" id="is_default" value="Y" name="is_default" <?php if ($bank_id && $bank_details->is_default == 'Y') {
    echo 'checked="checked"';
}?>>
<label class="form-label semibold bankexampleinput" for="is_default"><?php _trans('lable69'); ?>?</label>
									</fieldset>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="col-lg-12">
									<fieldset class="form-group">
										<label class="form-label semibold" for="bank_name"><?php _trans('lable99'); ?>*</label>
										<input type="text" value="<?php if ($bank_id) {
    echo $bank_details->bank_name;
}?>" class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name" autocomplete="off">
									</fieldset>
								</div>
								<div class="col-lg-12">
									<fieldset class="form-group">
										<label class="form-label semibold" for="bank_ifsc_Code"><?php _trans('lable100'); ?>*</label>
										<input type="text" value="<?php if ($bank_id) {
    echo $bank_details->bank_ifsc_Code;
}?>" class="form-control" id="bank_ifsc_Code" name="bank_ifsc_Code" placeholder="IFSC Code" autocomplete="off">
									</fieldset>
								</div>
								<div class="col-lg-12">
									<fieldset class="form-group">
										<label class="form-label semibold" for="bank_branch"><?php _trans('lable761'); ?></label>
										<input type="text" class="form-control" value="<?php if ($bank_id) {
    echo $bank_details->bank_branch;
}?>" id="bank_branch" name="bank_branch" placeholder="Branch" autocomplete="off">
									</fieldset>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<label class="form-label semibold" for="bank_account_type"><?php _trans('lable101'); ?>*</label>
										<select class="form-control bootstrap-select bootstrap-select-arrow form-control removeErrorInput" data-live-search="true" id="bank_account_type" name="bank_account_type" autocomplete="off">
											<option value=""></option>
											<option value="1" <?php if ($bank_id && $bank_details->account_type == 1) {
    echo 'selected="selected"';
}?>>Current Account</option>
											<option value="2" <?php if ($bank_id && $bank_details->account_type == 2) {
    echo 'selected="selected"';
}?>>Saving Account</option>
											<option value="3" <?php if ($bank_id && $bank_details->account_type == 3) {
    echo 'selected="selected"';
}?>>Others</option>
										</select>

									</div>
								</div>
							</div>
					</div>

				</div>
				<div class="modal-footer text-center">
					<button type="button" class="btn btn-rounded btn-primary" name="add_bank_details" id="add_bank_details">
					<?php _trans('lable57'); ?>
					</button>
					<button type="button" class="btn btn-rounded btn-default modal-popup-close">
					<?php _trans('lable58'); ?>
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
