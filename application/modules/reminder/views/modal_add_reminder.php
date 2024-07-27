<script src="<?php echo base_url(); ?>assets/mp_backend/js/purchase_expense.js"></script>
<script type="text/javascript">
    $(function () {
        // Display the create quote modal
        $('#addNewCar').modal('show');
        $(".bootstrap-select").selectpicker("refresh");

        var reminder_id = "<?php echo $reminder_id; ?>";
        var reminder_type = "<?php echo $reminder_type; ?>";

        $('#add_reminder_details').click(function () {

        var refered_by_type = $('#refered_by_type').val();
        var refered_by_id = $('#refered_by_id').val();
        var contact_reminder_next_due_date = $('#contact_reminder_next_due_date').val();
        var status = $('#status').val();
        var employee_id = $('#employee_id').val();
        
        var validation = [];

        if($("#current_schedule_date").val() == ''){
			validation.push('current_schedule_date');
		}
        if($("#next_schedule_day").val() == ''){
			validation.push('next_schedule_day');
		}
        if($("#next_schedule_date").val() == ''){
			validation.push('next_schedule_date');
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

            $.post("<?php echo site_url('reminder/ajax/add_reminder_history'); ?>", {
                reminder_id: reminder_id,
                reminder_type: reminder_type,
                current_schedule_date: $('#current_schedule_date').val(),
                next_schedule_day: $("#next_schedule_day").val(),
                next_schedule_date: $("#next_schedule_date").val(),
                description: $("#description").val(),
                _mm_csrf: $('#_mm_csrf').val()
            },
            function (data) {
                var response = JSON.parse(data);
                if(response.success == 1){
                    location.reload();
                } else {
                    $('.has-error').removeClass('has-error');
                    for (var key in response.validation_errors) {
                        // console.log(key);
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
				<div class="modal-header">
					<div class="col-xs-12 text-center">
						<h3 class="modal__h3"><?php _trans('lable578'); ?></h3>
					</div>
					<button type="button" class="modal-close modal-popup-close">
						<i class="font-icon-close-2"></i>
					</button>
				</div>
				<div class="modal-body">
					<div class="form">
						<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
						<div class="row">
                            <div class="form_group">
                                <label class="form_label label-width"> <?php _trans('lable577'); ?>*</label>
                                <div class="form_controls input-width">
                                    <input class="form-control removeErrorInput datepicker" onchange="changeDueDatebyCreated('current_schedule_date','next_schedule_day','next_schedule_date')" type="text" name="current_schedule_date" id="current_schedule_date" value="<?php echo date('d/m/Y');?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="form_group">
                                <label class="form_label label-width"> <?php _trans('lable576'); ?>*</label>
                                <div class="form_controls input-width">
                                    <input class="form-control" onchange="changeDueDatebyDay('current_schedule_date','next_schedule_day','next_schedule_date')" type="text" name="next_schedule_day" id="next_schedule_day" value="" >
                                </div>
                            </div>
                            <div class="form_group">
                                <label class="form_label label-width"> <?php _trans('lable554'); ?>*</label>
                                <div class="form_controls input-width">
                                    <input class="form-control removeErrorInput datepicker" onchange="changeCreditPeriodbyDueDate('current_schedule_date','next_schedule_day','next_schedule_date')" type="text" name="next_schedule_date" id="next_schedule_date" value="<?php echo date('d/m/Y');?>" >
                                </div>
                            </div>
                            <div class="form_group">
                                <label class="form_label label-width"> <?php _trans('lable177'); ?></label>
                                <div class="form_controls input-width">
                                <textarea id="description" name="description" class="form-control string required" ></textarea>
                                </div>
                            </div>
						</div>
					</div>
				</div>
				<div class="modal-footer text-center">
					<button type="button" class="btn btn-rounded btn-primary"  name="add_reminder_details" id="add_reminder_details">
                    <?php _trans('lable70'); ?>
					</button>
					<button type="button" class="btn btn-rounded btn-default modal-popup-close">
                    <?php _trans('lable171'); ?>
					</button>
				</div>
			</form>
		</div>
	</div>
</div>