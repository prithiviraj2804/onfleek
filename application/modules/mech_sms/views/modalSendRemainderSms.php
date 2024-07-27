<script type="text/javascript">
    $(function () {

        $(".removeError").change(function() {
            var len = (this.value);
            if (this.value != "" || this.value != 0) {
                $('#' + $(this).attr('name')).parent().removeClass('has-error');
                $('#' + $(this).attr('name')).parent().removeClass('border_error');
                $('#' + $(this).attr('name')).removeClass('has-error');
                $('#' + $(this).attr('name')).removeClass('border_error');
            }
        });

        $('#sendSms').modal('show');
        $(".bootstrap-select").selectpicker("refresh");

        var entity_id = "<?php echo $entity_id; ?>";
        var entity_type = "<?php echo $entity_type; ?>";
        
        $('#sendSMSRemainder').click(function(){
           
            $('.border_error').removeClass('border_error');
            $('.has-error').removeClass('has-error');

            var validation = [];

            if($("#remainder_id").val() == ''){
                validation.push('remainder_id');
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
            
            $.post("<?php echo site_url('mech_sms/ajax/sendRemainderSMS'); ?>", {
                remainder_id: $('#remainder_id').val(),
                entity_type : entity_type,
                entity_id: entity_id,
                _mm_csrf: $('input[name="_mm_csrf"]').val()
            },
            function (data) {
                var response = JSON.parse(data);
                if(response.success == 1){
                    $('#gif').hide();
                    notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
                    $('.modal').remove();
                    $('.modal-backdrop').remove();
                    $('body').removeClass( "modal-open" );
                } else {
                    $("#error").html(response.error);
                }
            });
        });
        
        $('.modal-popup-close').click(function () {
            $('.modal').remove();
            $('.modal-backdrop').remove();
            $('body').removeClass( "modal-open" );
        });     
        
    });
</script>

<div class="modal fade" id="sendSms" tabindex="-1" role="dialog" aria-labelledby="addNewCarLabel" >
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="add_car_fdetail">
			<form name="car_fdetails">
				<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
				<div class="modal-header">
					<div class="col-xs-12 text-center">
						<h3 class="modal__h3 margin0px"><?php _trans('lable905'); ?></h3>
					</div>
					<button type="button" class="modal-close modal-popup-close">
						<i class="font-icon-close-2"></i>
					</button>
				</div>
				<div class="modal-body">
					<div class="form">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
						<div class="row">
                            <?php if($entity_type == "I"){ ?>
                            <div class="form_group">
                                <label class="form_label label-width"> <?php _trans('lable19'); ?>*</label>
                                <div class="form_controls input-width">
                                    <select id="remainder_id" name="remainder_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                                        <option value=""><?php _trans('lable285'); ?></option>
                                        <option value="1">Remainder</option>
                                        <option value="2">Warning</option>
                                    </select>
                                </div>
                            </div>
                            <?php } else if($entity_type == "J"){ ?>
                                <div class="form_group">
                                <label class="form_label label-width"> <?php _trans('lable19'); ?>*</label>
                                <div class="form_controls input-width">
                                    <select id="remainder_id" name="remainder_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                                        <option value=""><?php _trans('lable285'); ?></option>
                                        <option value="1">Started</option>
                                        <option value="2">Completed</option>
                                        <option value="3">Re-Open</option>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>
						</div>
					</div>
				</div>
				<div class="modal-footer text-center">
                    <div id="error" class="text-center col-xl-12 col-lg-12 col-md-12 col-sm-12 error"></div>
					<button type="button" class="btn btn-rounded btn-primary"  name="add_client_details" id="sendSMSRemainder">
                    <?php _trans('lable904'); ?>
					</button>
					<button type="button" class="btn btn-rounded btn-default modal-popup-close">
                    <?php _trans('lable171'); ?>
					</button>
				</div>
			</form>
		</div>
	</div>
</div>