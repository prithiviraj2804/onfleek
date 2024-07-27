<script>
	 var is_reshedule = false;
	 var emp; 
    $(function () {
        // Display the create quote modal
        $('#addNewCar').modal('show');
        $('.select2').select2();
       });	
        
         
    	$('#payment_type').change(function(){
		  		if($(this).val() == 2){
		  			$("#onlinepay").show();
		  			$("#update_status").hide();
		  		} else {
		  			$("#onlinepay").hide();
		  			$("#update_status").show();
		  		}	
		 });

		$('.modal-popup-close').click(function () {
			$('.modal').remove();
			$('.modal-backdrop').remove();
			$('body').removeClass( "modal-open" );
         });      
        
    
</script>

<script>

document.getElementById('update_status').onclick = function(e){
	
	$.post("<?php echo site_url('user_appointments/ajax/save_payment'); ?>", {
                    //track_status_id: status,
                    //payment_id : response.razorpay_payment_id,
                    payment_method_id : $('#payment_type').val(),
                    amount : $('#amount').val(),
                    payment_note : $('#payment_note').val(),
					quote_id:$('#quote_id').val(),
					mobile:<?php echo $user->mobile_no; ?>,
					user_id:<?php echo $user->user_id; ?>,
					appointment_no: '<?php echo $user->appointment_no;?>',
					_mm_csrf: $('#_mm_csrf').val(),
					//remain_amount: $('#amounttobepaid').val() - $('#amount').val() 
                },
                function (data) {
                	//console.log(data);
                    var response = JSON.parse(data);
                    //console.log(data);
                    if(response.success === 1){
                    	notie.alert(1, 'Payment has been successfully updated!', 2);
						$('.modal').remove();
						$('.modal-backdrop').remove();
						$('body').removeClass( "modal-open" );
						//location.reload();
                    }else{
                    	notie.alert(1, 'Oops, something has gone wrong', 3);
                    }
                });
}


document.getElementById('onlinepay').onclick = function(e){

	var options = {
	    "key": "rzp_live_FvEZPBynV92NDo",
	    "amount": $("#amount").val() * 100, // 2000 paise = INR 20
	    "name": "MechPoint",
	    "description": "Payment for Invoice # <?php echo $user->appointment_no; ?>",
	    "image": "http://www.mechpoint.care/assets/mm_fe_latest/images/mm_custom/mechpoint.png",
	    "handler": function (response){
	        //alert(response.razorpay_payment_id);
	          $.post("<?php echo site_url('user_appointments/ajax/save_payment'); ?>", {
                    //track_status_id: status,
                    payment_id : response.razorpay_payment_id,
                    payment_method_id : $('#payment_type').val(),
                    amount : $('#amount').val(),
                    payment_note : $('#payment_note').val(),
					quote_id:$('#quote_id').val(),
					mobile:<?php echo $user->mobile_no; ?>,
					user_id:<?php echo $user->user_id; ?>,
					_mm_csrf: $('#_mm_csrf').val(),
					//remain_amount: $('#amounttobepaid').val() - $('#amount').val() 

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
	    },
	    "prefill": {
	        "name": "<?php echo $user->name ?>",
	        "email": "<?php echo $user->email_id ?>",
	    },
	    "notes": {
	        "address": "<?php echo $user->email_id ?>" 
	    },
	    "theme": {
	        "color": "#2c313e"
	    }
	};
	var rzp1 = new Razorpay(options);

    rzp1.open();
    e.preventDefault();
}
</script>


<div class="modal fade" id="addNewCar" tabindex="-1" role="dialog" aria-labelledby="addNewCarLabel">
	<div class="modal-dialog" role="document">
		<?php
		  //print_r($user);
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
								<h3 class="modal__h3"><?php _trans('payment_update_for'); ?> <?php echo $user->appointment_no; ?></h3>
								
							</div>
						</div>

						<div>
							
							<div class="row spacetop-20">
								<div class="col-sm-10 col-centered">
									<span><?php _trans('payment_type'); ?></span>

									<select class="bootstrap-select bootstrap-select-arrow select2" name="payment_type" id="payment_type">
													<?php foreach ($payment_methord as $methord) { 
													
														?>
														<option value="<?php echo $methord->payment_method_id; ?>">
															<?php echo $methord->payment_method_name ?>
																
															</option>
													<?php } ?>
												</select>
								</div>
							</div>

							

							
							
							
							<div class="row spacetop-20" id="is_date">
								<div class="col-sm-10 col-centered">
									<span><?php _trans('total_amount'); ?></span>
									<?php  //print_r($appointment_details);?>
									<input type="text" disabled="disabled" value="<?php echo number_format((float)$appointment_details->appointment_grand_total, 2, '.', ''); ?>" class="form-control" name="amounttobepaid" id="total_amount" placeholder="Date">
								</div>
							</div>


							<div class="row spacetop-20" id="is_date">
								<div class="col-sm-10 col-centered">
									<span><?php _trans('paid_amount_if_any'); ?></span>
									<?php  //print_r($appointment_details);?>
									<input type="text" readonly="readonly" value="<?php echo number_format((float)$appointment_details->total_paid_amount, 2, '.', ''); ?>" class="form-control" name="amounttobepaid" id="amounttobepaid" placeholder="Date">
								</div>
							</div>



							<div class="row spacetop-20">
								<div class="col-sm-10 col-centered">
									<span><?php _trans('amount_to_be_paid'); ?>:</span>
								</div>
							</div>
							
							<div class="row spacetop-20">
								<div class="col-sm-10 col-centered">
									<input type="text" value="<?php echo number_format((float)$appointment_details->total_due_amount, 2, '.', ''); ?>" class="form-control" name="amount" id="amount" placeholder="Date">
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
									<textarea class="g-input" placeholder="Enter your comment" name="payment_note" id="payment_note"></textarea>
									<input type="hidden" name="is_reshedule" id="is_reshedule" value="false">
								</div>
							</div>

						</div>

					</div>
				</div>
				<div class="modal-footer text-center">
				<input type="hidden" id="quote_id" value='<?php echo $quote_id ?>' >
					<button type="button" style="display: none;" class="btn btn-rounded btn-primary"  name="onlinepay" id="onlinepay">
									<?php _trans('pay_online'); ?>	
									</button>
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