<script>
	 var is_reshedule = false;
	 var emp; 
    $(function () {
        // Display the create quote modal
        $('#addNewCar').modal('show');
        $('.select2').select2();
       
       

       // $("#task_status").val(4);

        

		});	
        
          $('#update_status').click(function () {

          	//var status = ($("#task_status").val() == null) ? <?php echo $current_status[0]['track_status_id'] ?>:$("#task_status").val();	

            $.post("<?php echo site_url('user_appointments/ajax/update_delivery_admin'); ?>", {
                    //track_status_id: status,
                    delivery_address : $('#delivery_address').val(),
                    delivery_date : $('#delivery_date').val(),
                    delivery_timing : $('#delivery_timing').val(),
                    delivery_comments : $('#delivery_comments').val(),
					quote_id:$('#quote_id').val(),
                    _mm_csrf: $('#_mm_csrf').val()
                },
                function (data) {
                    var response = JSON.parse(data);
                    if(response.success === 1){
                    	notie.alert(1, 'Success!', 2);
						$('.modal').remove();
						$('.modal-backdrop').remove();
						$('body').removeClass( "modal-open" );
						//location.reload();
                    }
                });
        });
        
        
         
		$('.modal-popup-close').click(function () {
			$('.modal').remove();
			$('.modal-backdrop').remove();
			$('body').removeClass( "modal-open" );
         });      
        
    
</script>
<div class="modal fade" id="addNewCar" tabindex="-1" role="dialog" aria-labelledby="addNewCarLabel">
	<div class="modal-dialog" role="document">
		<?php
		print_r($appointment_details->delivery_date); 
		?>
		<div class="modal-content" id="add_car_fdetail">
			<form name="car_fdetails" method="post" class="form">
				<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
				
				<div class="modal-header">
					<button type="button" class="modal-close modal-popup-close">
						<i class="font-icon-close-2"></i>
					</button>
				</div>
				<div class="modal-body">
					<div class="form">
						<div class="row text-center">
							<div class="col-xs-12">
								<h3 class="modal__h3"><?php _trans('delivery_update'); ?></h3>
								
							</div>
						</div>

						<div>
							
							<div class="row spacetop-20">
								<div class="col-sm-10 col-centered">
									<span><?php _trans('delivery_address'); ?></span>
									<select class="bootstrap-select bootstrap-select-arrow select2" name="delivery_address" id="delivery_address">
										<?php foreach ($user_address_list as $address) { 
											if(count($appoinment_details) > 0) {
													if($appoinment_details->delivery_address == $address->user_address_id){
														$selected = 'selected="selected"';
													}else{
														$selected = '';
													}
												}else{
													$selected = '';
												}
										?>
											<option value="<?php echo $address->user_address_id; ?>" <?php echo $selected; ?>><?php echo $address->full_address.", ".$address->area_name.", ".$address->zip_code; ?>
											</option>
										<?php } ?>
									</select>
								</div>
							</div>

							<div class="row spacetop-20" id="is_date">
								<div class="col-sm-10 col-centered">
									<span><?php _trans('delivery_date'); ?></span>
									<input type="text" value="<?php echo $appointment_details->delivery_date; ?>" class="form-control" name="delivery_date" id="delivery_date" placeholder="Date">
								</div>
							</div>

							

							<div class="row spacetop-20" id="is_timing">
								<div class="col-sm-10 col-centered">
									<span><?php _trans('delivery_time'); ?></span>
									<input type="text" value="<?php echo $appointment_details->delivery_date ?>" class="form-control" name="delivery_timing" id="ahc_timing" placeholder="Timing">
								</div>
							</div>
							
							
							
							
							
							<?php
								//echo $current_status[0]['comments']; 
							?>
							<div class="row spacetop-20">
								<div class="col-sm-10 col-centered">
									<span><?php _trans('comments'); ?>:</span>
								</div>
							</div>
							
							<div class="row spacetop-20">
								<div class="col-sm-10 col-centered">
									<textarea class="g-input" placeholder="Enter your comment" name="delivery_comments" id="delivery_comments"><?php echo $appointment_details->delivery_comments; ?></textarea>
									<input type="hidden" name="is_reshedule" id="is_reshedule" value="false">
								</div>
							</div>

						</div>

					</div>
				</div>
				<div class="modal-footer text-center">
				<input type="hidden" id="quote_id" value='<?php echo $qoute_id ?>' >
					<button type="button" class="btn btn-rounded btn-primary"  name="update_status" id="update_status">
						<?php _trans('update'); ?>
					</button>
					<button type="button" class="btn btn-rounded btn-default modal-popup-close">
					<?php _trans('cancel'); ?>	
					</button>
				</div>
			</form>
	
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('#ahc_date').datetimepicker({
        format: 'YYYY-MM-DD',
    });
    
    $('#ahc_timing').datetimepicker({
        format: 'HH:mm a',
    });
		
	});
</script>