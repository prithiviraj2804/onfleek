<script type="text/javascript">
    $(function () {

        // Display the create expense category modal
        $('#addNewCar').modal('show');

        $('#add_suppliers_category').click(function () {

			var validation = [];

			var branch_id = $("#suppliers_category_name").val();
			if($("#suppliers_category_name").val() == ''){
			validation.push('suppliers_category_name');
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

            $.post("<?php echo site_url('suppliers_category/ajax/create'); ?>", {
                suppliers_category_name : $("#suppliers_category_name").val(),
				_mm_csrf: $('#_mm_csrf').val()
			},
			function (data) {
				var response = JSON.parse(data);
				//console.log(response);
				if(response.success == 1){
					notie.alert(1, 'Success!', 2);
					$('#suppliers_category_id').empty(); // clear the current elements in select box
					$('#suppliers_category_id').append($('<option></option>').attr('value', '').text('Model'));
					for (row in response.supplier_category_det) {
						$('#suppliers_category_id').append($('<option></option>').attr('value', response.supplier_category_det[row].suppliers_category_id ).text(response.supplier_category_det[row].suppliers_category_name));
                    }
                    $("#suppliers_category_id").val(response.suppliers_category_id);
                    $('#suppliers_category_id').selectpicker("refresh");	
                    
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
				<input type="hidden" name="suppliers_category_id" id="suppliers_category_id" value="<?php echo $supplier_category_det->suppliers_category_id;?>" autocomplete="off">
				<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" autocomplete="off"/>
				<div class="modal-header">
					<div class="col-xs-12 text-center">
						<?php if ($supplier_category_det->suppliers_category_id) {
    ?> 
						<h3 class="modal__h3"><?php _trans('lable1038'); ?></h3>
						<?php
} else {
        ?> 
						<h3 class="modal__h3"><?php _trans('lable1037'); ?></h3>
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
								<label class="form_label section-header-text"><?php _trans('lable850'); ?> *</label>
								<input type="text" class="form-control check_error_label" name="suppliers_category_name" id="suppliers_category_name"  value="<?php echo $supplier_category_det->suppliers_category_name;?>" autocomplete="off">
							</div>
						</div>
					</div>
					<div class="modal-footer text-center col-xs-12">
						<button type="button" class="btn btn-rounded btn-primary"  name="add_suppliers_category" id="add_suppliers_category"><?php _trans('lable1037'); ?></button>
						<button type="button" class="btn btn-rounded btn-default modal-popup-close"><?php _trans('lable58'); ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>