<script type="text/javascript">
    $(function () {

        // Display the create expense category modal
        $('#addNewCar').modal('show');

        $('#add_employee_role').click(function () {

			var validation = [];

			var branch_id = $("#role_name").val();
			if($("#role_name").val() == ''){
			validation.push('role_name');
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

            $.post("<?php echo site_url('employee_role/ajax/create'); ?>", {
                role_name : $("#role_name").val(),
				_mm_csrf: $('#_mm_csrf').val()
			},
			function (data) {
				var response = JSON.parse(data);
				if(response.success == 1){
					notie.alert(1, 'Success!', 2);
					$('#employee_role').empty(); // clear the current elements in select box
					$('#employee_role').append($('<option></option>').attr('value', '').text('Model'));
					for (row in response.employee_role) {
						$('#employee_role').append($('<option></option>').attr('value', response.employee_role[row].role_id).text(response.employee_role[row].role_name));
                    }
                    $("#employee_role").val(response.role_id);
                    $('#employee_role').selectpicker("refresh");	
                    
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
				<input type="hidden" name="role_id" id="role_id" value="<?php echo $employee_role->role_id;?>" autocomplete="off">
				<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" autocomplete="off"/>
				<div class="modal-header">
					<div class="col-xs-12 text-center">
						<?php if ($customer_category_det->role_id) {
    ?> 
						<h3 class="modal__h3"><?php _trans('lable204'); ?></h3>
						<?php
} else {
        ?> 
						<h3 class="modal__h3"><?php _trans('lable203'); ?></h3>
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
								<label class="form_label section-header-text"><?php _trans('lable205'); ?> *</label>
								<input type="text" class="form-control check_error_label" name="role_name" id="role_name"  value="<?php echo $employee_role->role_name;?>" autocomplete="off">
							</div>
						</div>
					</div>
					<div class="modal-footer text-center col-xs-12">
						<button type="button" class="btn btn-rounded btn-primary"  name="add_employee_role" id="add_employee_role"><?php _trans('lable203'); ?></button>
						<button type="button" class="btn btn-rounded btn-default modal-popup-close"><?php _trans('lable58'); ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>