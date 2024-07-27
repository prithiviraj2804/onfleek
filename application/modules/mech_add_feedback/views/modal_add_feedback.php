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
        // Display the create quote modal
		
        $('#addNewCar').modal('show');
        $(".bootstrap-select").selectpicker("refresh");
        var invoice_id = "<?php echo $invoice_id; ?>";

        $('#add_feedback_details').click(function () {


			$(".border_error").removeClass('border_error');
            $(".has-error").removeClass('has-error');

            var validation = [];

            if($("#customer_rating").val() == ''){
                validation.push('customer_rating');
            }

            if($("#service_rating").val() == ''){
                validation.push('service_rating');
            }

            if($("#technician_ratting").val() == ''){
                validation.push('technician_ratting');
            }

            if(validation.length > 0){
                validation.forEach(function(val) {
                    $('#'+val).addClass("border_error");
                    $('#'+val).parent().addClass('has-error');
                });
                return false;
            }
            $.post("<?php echo site_url('mech_add_feedback/ajax/add_feedback'); ?>", {
                invoice_id: invoice_id,
                feedback_no : $("#feedback_no").val(),
                invoice_group_id : $("#invoice_group_id").val(),
                fb_id: $("#fb_id").val(),
                customer_rating: $("#customer_rating").val(),
                customer_description: $("#customer_description").val(),
                service_rating: $("#service_rating").val(),
                service_description: $("#service_description").val(),
                technician_ratting: $("#technician_ratting").val(),
                technician_description: $("#technician_description").val(),
                _mm_csrf: $('#_mm_csrf').val()
            },
            function (data) {
                var response = JSON.parse(data);
                if(response.success == 1){
                    notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
                    $('.modal').remove();
                    $('.modal-backdrop').remove();
                    $('body').removeClass( "modal-open" );
                } else {
                    $('.has-error').removeClass('has-error');
                    for (var key in response.validation_errors) {
                        $('#' + key).parent().addClass('has-error');
                        $('.error_msg_' + key).show().empty().html(response.validation_errors[key]);
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
<div class="modal fade" id="addNewCar" tabindex="-1" role="dialog" aria-labelledby="addNewCarLabel" >
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="add_car_fdetail">
			<form name="car_fdetails" class="car_fdetails">
				<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                <input type="hidden" id="fb_id" name="fb_id" value="<?php echo $feedback_details->fb_id;?>" >
                <input type="hidden" name="feedback_no" id="feedback_no" value="<?php echo $feedback_details->feedback_no; ?>" autocomplete="off"/>
                <input type="hidden" id="invoice_group_id" name="invoice_group_id" value="<?php echo $feedback->invoice_group_id;?>" >
				<div class="modal-header">
					<div class="col-xs-12 text-center">
						<h3 class="modal__h3"><?php _trans('lable408'); ?></h3>
					</div>
					<button type="button" class="modal-close modal-popup-close">
						<i class="font-icon-close-2"></i>
					</button>
				</div>
				<div class="modal-body">
					<div class="form">
						<div class="row">
                            <div class="col-sm-12 col-lg-12 col-md-12 text-center"><h6 class="popupsplit"><?php _trans('lable415'); ?></h6></div>
                            <div class="form-group clearfix">
								<div class="col-sm-8 text-left">
									<label class="control-label paddingTop7px"><?php _trans('lable416'); ?>*</label>
								</div>
								<div class="col-sm-4 float_right">
									<select name="technician_ratting" id="technician_ratting" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
									<option value=""><?php _trans('lable414'); ?></option>
                                        <option <?php if($feedback_details->technician_ratting == "P"){ echo "selected";}?> value="P"><?php _trans('lable410'); ?></option>
                                        <option <?php if($feedback_details->technician_ratting == "G"){ echo "selected";}?> value="G"><?php _trans('lable411'); ?></option>
                                        <option <?php if($feedback_details->technician_ratting == "VG"){ echo "selected";}?> value="VG"><?php _trans('lable412'); ?></option>
                                        <option <?php if($feedback_details->technician_ratting == "E"){ echo "selected";}?> value="E"><?php _trans('lable413'); ?></option>
                                    </select>
								</div>
							</div>
                            <div class="form-group clearfix">
								<div class="col-sm-12">
									<textarea id="technician_description" placeholder="Technician Description" name="technician_description" class="form-control" ><?php echo $feedback_details->technician_description;?></textarea>
								</div>
							</div>
                            <div class="form-group clearfix">
								<div class="col-sm-8 text-left">
									<label class="control-label paddingTop7px"><?php _trans('lable417'); ?>*</label>
								</div>
								<div class="col-sm-4 float_right">
									<select name="service_rating" id="service_rating" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
									<option value=""><?php _trans('lable414'); ?></option>
                                        <option <?php if($feedback_details->service_rating == "P"){ echo "selected";}?> value="P"><?php _trans('lable410'); ?></option>
                                        <option <?php if($feedback_details->service_rating == "G"){ echo "selected";}?> value="G"><?php _trans('lable411'); ?></option>
                                        <option <?php if($feedback_details->service_rating == "VG"){ echo "selected";}?> value="VG"><?php _trans('lable412'); ?></option>
                                        <option <?php if($feedback_details->service_rating == "E"){ echo "selected";}?> value="E"><?php _trans('lable413'); ?></option>
                                    </select>
								</div>
							</div>
                            <div class="form-group clearfix">
								<div class="col-sm-12 float_right">
									<textarea id="service_description"  placeholder="Service Description" name="service_description" class="form-control" ><?php echo $feedback_details->service_description;?></textarea>
								</div>
							</div>
                            <div class="col-sm-12 col-lg-12 col-md-12 text-center"><h6 class="popupsplit"><?php _trans('lable418'); ?></h6></div>
                            <div class="form-group clearfix">
								<div class="col-sm-8 text-left">
									<label class="control-label paddingTop7px"><?php _trans('lable419'); ?>*</label>
								</div>
								<div class="col-sm-4 float_right">
									<select name="customer_rating" id="customer_rating" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
										<option value=""><?php _trans('lable414'); ?></option>
                                        <option <?php if($feedback_details->customer_rating == "P"){ echo "selected";}?> value="P"><?php _trans('lable410'); ?></option>
                                        <option <?php if($feedback_details->customer_rating == "G"){ echo "selected";}?> value="G"><?php _trans('lable411'); ?></option>
                                        <option <?php if($feedback_details->customer_rating == "VG"){ echo "selected";}?> value="VG"><?php _trans('lable412'); ?></option>
                                        <option <?php if($feedback_details->customer_rating == "E"){ echo "selected";}?> value="E"><?php _trans('lable413'); ?></option>
                                    </select>
								</div>
							</div>
                            <div class="form-group clearfix">
								<div class="col-sm-12 float_right">
									<textarea id="customer_description" name="customer_description"  placeholder="<?php _trans('lable177'); ?>" class="form-control" ><?php echo $feedback_details->customer_description;?></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer text-center">
					<button type="button" class="btn btn-rounded btn-primary"  name="add_feedback_details" id="add_feedback_details">
                    <?php if($feedback_details->fb_id){?>
					    <?php _trans('lable1223'); ?>
                    <?php }else { ?>
                        <?php _trans('lable409'); ?>
                    <?php } ?>
					</button>
					<button type="button" class="btn btn-rounded btn-default modal-popup-close">
					<?php _trans('lable171'); ?>
					</button>
				</div>
			</form>
		</div>
	</div>
</div>