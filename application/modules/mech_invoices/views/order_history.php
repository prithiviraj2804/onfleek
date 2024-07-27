<?php 
//print_r($order_history);
//exit;
?>

<script>
    $(function () {
        // Display the create quote modal
        $('#orderHistory').modal('show');
       
        
         $('#skip_scar_level').click(function () {
         	$('#addNewCar').modal('hide');
            location.reload();
         });
         
		$('.modal-popup-close').click(function () {
			$('.modal').remove();
			$('.modal-backdrop').remove();
			$('body').removeClass( "modal-open" );
         });      
        
    });
</script>
<div class="modal fade" id="orderHistory" tabindex="-1" role="dialog" aria-labelledby="orderHistory">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="modal-close modal-popup-close">
					<i class="font-icon-close-2"></i>
				</button>
				<h4 class="modal-title" id="myModalLabel">
                  <?php _trans('status_history'); ?>  
                </h4>
			</div>
			<div class="modal-body" id="add_car_fdetail">
				<article class="profile-info-item">
							<header class="profile-info-item-header">
								<i class="font-icon font-icon-case"></i>
						<?php _trans('order_history'); ?>		
							</header>
							<ul class="exp-timeline">
								<?php $i = 1; 
								foreach ($order_history as $history) { ?>
									<li class="exp-timeline-item">
										<div class="dot"></div>
										<div class="tbl">
											<div class="tbl-row">
												<div class="tbl-cell">
													<div class="exp-timeline-range"><b><?php _trans('status'); ?>: </b><?php _htmlsc($history['ahc_name']); ?></div>
													<?php if($history['ahc_amount']){ ?>
														<div class="exp-timeline-range"><b><?php _trans('amount'); ?>: </b><?php _htmlsc($history['ahc_amount']); ?></div>
													<?php } ?>
													<?php if($history['ahc_date']){ ?>
														<div class="exp-timeline-range"><b><?php _trans('date'); ?>: </b><?php _htmlsc($history['ahc_date']); ?></div>
													<?php } ?>
													<?php if($history['ahc_timing']){ ?>
														<div class="exp-timeline-range"><b><?php _trans('timing'); ?>: </b><?php _htmlsc($history['ahc_timing']); ?></div>
													<?php } ?>
													<?php if($history['ahc_employee']){ ?>
														<div class="exp-timeline-range"><b><?php _trans('employee'); ?>	: </b><?php _htmlsc($history['ahc_employee']); ?></div>
													<?php } ?>
													
													<div class="exp-timeline-status"><b><?php _trans('comments'); ?>: </b><?php _htmlsc($history['comments']); ?></div>
													<div class="exp-timeline-location"><?php _trans('updated_on'); ?> <?php _htmlsc($history['updated_on']); ?></div>
												</div>
												
											</div>
										</div>
										<br/>
										<br/>
									</li>
								<?php
								}								
								?>
							</ul>
						</article>
			</div>
		</div>
		
	</div>
</div>

