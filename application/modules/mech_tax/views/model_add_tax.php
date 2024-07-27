<script type="text/javascript">

    $(function () {

        // Display the create expense category modal
        $('#addNewCar').modal('show');

		$('#tax_value').keyup(function(){
			$("#showErrorMsg").empty().append('');
			if ($(this).val() > 100){
				$("#showErrorMsg").empty().append('No numbers above 100');
				$(this).val('100');
			}
		});

		$("#tax_value").on("keypress keyup blur",function (event) {    
           $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
	    });

        $('#add_tax').click(function () {

			var validation = [];

			if($("#tax_name").val() == ''){
			validation.push('tax_name');
			}
			if($("#tax_value").val() == ''){
			validation.push('tax_value');
			}
			if($("#hsn_code").val() == ''){
			validation.push('hsn_code');
			}

			if(validation.length > 0){
				validation.forEach(function(val){
					$('#'+val).parent().addClass('has-error');
					$('#'+val).addClass("border_error");
					if($('#'+val+'_error').length == 0){
					} 
			});
			return false;
		}
		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');
		$(".hideSubmitButtons").hide();

            $.post("<?php echo site_url('mech_tax/ajax/create'); ?>", {
				tax_id : $("#tax_id").val(),
                tax_name : $("#tax_name").val(),
				tax_value : $("#tax_value").val(),
                hsn_code : $("#hsn_code").val(),
				tax_type: ($("input[name='tax_type']:checked").val())?$("input[name='tax_type']:checked").val():'',				
                description : $("#description").val(),
				_mm_csrf: $('#_mm_csrf').val()
			},
			function (data) {
				var response = JSON.parse(data);
				//console.log(response);
				if(response.success == 1){
					notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
					window.location.href = "<?php echo site_url('workshop_setup/index'); ?>/13";
                    $('#addNewCar').modal('hide');
                    $('#add_car_fdetail').hide();
                    $('#add_car_sdetail').hide();
                    $('.modal').remove();
                    $('.modal-backdrop').remove();
                    $('body').removeClass( "modal-open" );
            
				} else if(response.success == 2){
                    notie.alert(3,'<?php _trans('err8');?>', 2);
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
         }); 
         
         $( ".check_error_label" ).change(function() {
  			$('.error_msg_' + $(this).attr('name')).hide();
			$('#' + $(this).attr('name')).parent().removeClass('has-error'); 
		}); 	
    });
</script>

<div class="modal fade" id="addNewCar" tabindex="-1" role="dialog" aria-labelledby="addNewCarLabel">
	<div class="modal-dialog vechicleBox" role="document">
		<div class="modal-content" id="add_car_fdetail">
			<form name="car_fdetails" method="post" class="car_fdetails">
				<input type="hidden" name="tax_id" id="tax_id" value="<?php echo $tax_list->tax_id;?>" autocomplete="off">
				<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" autocomplete="off"/>
				<div class="modal-header">
					<div class="col-xs-12 text-center">
						<?php if ($tax_list->tax_id) {
    ?> 
						<h3 class="modal__h3"><?php _trans('lable1182'); ?></h3>
						<?php
} else {
        ?> 
						<h3 class="modal__h3"><?php _trans('lable1177'); ?></h3>
						<?php
    } ?>
					</div>
					<button type="button" class="modal-close modal-popup-close">
						<i class="font-icon-close-2"></i>
					</button>
				</div>
				<div class="modal-body">
					<div class="form">
						<div class="row">
							<div class="form_group" >
								<label class="form_label section-header-text"><?php _trans('lable1178'); ?> *</label>
								<input type="text" class="form-control check_error_label" name="tax_name" id="tax_name"  value="<?php echo $tax_list->tax_name;?>" autocomplete="off">
							</div>
							<div class="form_group" >
								<label class="form_label section-header-text"><?php _trans('lable1180'); ?> *</label>
								<input type="text" class="form-control check_error_label" name="tax_value" id="tax_value" value="<?php echo $tax_list->tax_value;?>" autocomplete="off">
								<div id="showErrorMsg" class="error"></div>
							</div>
							<div class="form_group" >
								<label class="form_label section-header-text"><?php _trans('lable1184'); ?> *</label>
								<input type="text" class="form-control check_error_label" name="hsn_code" id="hsn_code"  value="<?php echo $tax_list->hsn_code;?>" autocomplete="off">
							</div>
							
							<div class="form_group" >
							    <label class="form_label section-header-text"><?php _trans('lable1183'); ?> </label>
							</div>

							<div class="col-lg-12 col-md-12">
									<span class="service">
									<input type="radio" id="tax_type_service" name="tax_type" class="g-input tax_type" value="S" <?php if($tax_list->tax_type == 'S'){echo 'checked="checked"';} ?>>
									<span><?php _trans('lable335'); ?></span>
									</span>

									<span class="goods" style="padding-left: inherit;">
									<input type="radio" id="tax_type_goods"  name="tax_type" class="g-input tax_type" value="G" <?php if($tax_list->tax_type == 'G'){echo 'checked="checked"';} ?>>
									<span><?php _trans('lable1181'); ?></span>
									</span>
							</div>							
							<div class="form_group" >
								<label class="form_label section-header-text"><?php _trans('lable177'); ?> </label>
								<textarea class="form-control" type="text" name="description" id="description" ><?php echo $tax_list->description; ?></textarea>
							</div>
						</div>
					</div>
					<div class="modal-footer text-center col-xs-12">
						<button type="button" class="btn btn-rounded btn-primary"  name="add_tax" id="add_tax"><?php _trans('lable1177'); ?></button>
						<button type="button" class="btn btn-rounded btn-default modal-popup-close"><?php _trans('lable58'); ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>