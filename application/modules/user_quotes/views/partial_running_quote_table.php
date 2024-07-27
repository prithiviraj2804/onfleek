<label class="form-label section-header-text" id="bookable_quote">BOOKABLE JOB CARDS ( <?php echo count($quote_book_list); ?> )</label>

<?php 
foreach ($quote_book_list as $quote) { ?>
<div class="quote-card quote-card--quote car-box-panel" id="quote_card_<?php echo $quote->quote_id; ?>">
	<div class="row">
	<div class="quote-card-side col-sm-2">
		<div class="quote-card-price">
			<div class="attention-required">
				<i class="fa fa-warning fa-3x"></i>
			</div>
			<div class="quote-price-card">
				<div class="quote-card-price-label">
					<?php _trans('price');?>
				</div>
				<h5 class="quote-card-price-amount">&#8377;<?php echo $quote->appointment_grand_total; ?></h5>
				<?php if($quote->is_payment_enable == 'Y') { ?>	
					<a href="javascript:void(0)" data-quote-id="<?php echo $quote->quote_id; ?>" data-toggle="modal" data-target="#addNewStatus" class="btn btn-rounded update_payment_status">Pay Now</a>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="quote-card-body col-sm-10">
		<div class="quote-card-details">
			<?php /* * / ?>
			<div class="quote-card-menu hidden-xs">
				<button class="quote-card-menu-button" onclick="deleteuserquote(<?php echo $quote->quote_id; ?>)">
					<i class="fa fa-trash"></i>
				</button>
			</div><?php / * */ ?>
			<div class="quote-card-detail">
				<div class="quote-card-detail-label">
					<?php _trans('job_card_no');?>.
				</div>
				<div class="quote-card-detail__value">
					<?php echo $quote->appointment_no; ?>
				</div>
			</div>
			<div class="quote-card-detail">
				<div class="quote-card-detail-label">
					<?php _trans('vechicle_detials');?>
				</div>
				<div class="quote-card-detail__value">
					<?php echo $quote->car_model_year." ".$quote->brand_name." ".$quote->model_name." ".$quote->variant_name;  ?>
				</div>
			</div>
			<div class="quote-card-detail">
				<div class="quote-card-detail-label text_align_center">
					<?php _trans('booked_on');?>
				</div>
				<div class="quote-card-detail__value">
					<?php echo $quote->created_on; ?>
				</div>
			</div>
		</div>
		<div class="quote-card__content">
			<div class="quote-card__service">
				<div class="row quote-card__service__content">
					<div class="col-sm-6 col-lg-8">
						<div class="quote-card__service__label">
							<span><?php _trans('services');?></span>
						</div>

						<?php $i = 1; foreach ($service_item_list as $service_item) { 
							if($service_item->quote_id == $quote->quote_id){ ?>
							<div class="quote-card__service__value spaceb-10">
							<span><?php echo $i.". ".$service_item->service_item_name; ?></span>
						</div>
						<?php $i++;  } } ?>
						<span></span>
					</div>
					<div class="col-sm-6 col-lg-4">
						<div class="quote-card__service__buttons">
							<div class="quote-card__service__buttons-inner">
								
								
								
								
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="quote-card-detail">
				<div class="quote-card-detail-label">
					<?php _trans('service_status');?>
				</div>
				<div class="quote-card-detail__value">
					<?php  $status = $this->mdl_user_quotes->get_track_status($quote->quote_id,'current');
								echo $status[0]['ahc_name'];
					?>
				</div>
				<?php if($quote->is_ready_for_billing == 'G' || $quote->is_ready_for_billing == 'P'){ ?>
				<div class="quote-card-detail-label">
					<?php _trans('invoice_status');?>
				</div>
				<div class="quote-card-detail__value">
					<?php if($quote->is_ready_for_billing == 'P'){ echo "In Progress"; }elseif($quote->is_ready_for_billing == 'G'){ echo "Generated"; } ?>
				</div>
				<?php } ?>
			</div>
			<div class="quote-card-detail text_align_center">
				<div class="options btn-group">
                            <a class="btn btn-default btn-sm dropdown-toggle"
                               data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="dropdown-menu">
                            	<li>
                                    <a href="<?php echo site_url('user_quotes/view/' . $quote->quote_id.'/current'); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('view'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('user_quotes/update_user_request_quote/r/' . $quote->quote_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                    </a>
                                </li>
                                <li>
                                	<a href="javascript:void(0)" data-quote-id="<?php echo $quote->quote_id; ?>" data-toggle="modal" data-target="#addNewStatus" class="add_status">
                                	 <i class="fa fa-edit fa-margin"></i> <?php _trans('update_status'); ?>
                                </a>
                                </li>
                                <?php if($quote->current_track_status == '6') { ?>    
                                <li>
                                	<a href="javascript:void(0)" data-quote-id="<?php echo $quote->quote_id; ?>" data-toggle="modal" data-target="#addNewStatus" class="update_delivery_status">
                                	 <i class="fa fa-edit fa-margin"></i> <?php _trans('update_delivery'); ?>
                                </a>
                                </li>
                                   <?php 
                                    } 
                                    if($quote->current_track_status >= 2) {
                                    ?>
                                     <li>
                                    <a href="javascript:void(0)" data-quote-id="<?php echo $quote->quote_id; ?>" data-toggle="modal" data-target="#addNewStatus" class="update_payment_status">
                                     <i class="fa fa-edit fa-margin"></i> <?php _trans('update_payment'); ?>
                                </a>
                                </li>
                                    <?php    
                                    }
                                   ?> 
                                   <?php if($quote->current_track_status < '5') { ?>    
                                <li>
                                    <a href="<?php echo site_url('user_quotes/delete/' . $quote->quote_id); ?>"
                                       onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                                        <i class="fa fa-trash-o fa-margin"></i> <?php _trans('cancel'); ?>
                                    </a>
                                </li> <?php } ?>
                                <?php if($this->session->userdata('workshop_is_enabled_jobsheet') == 'Y' && $quote->current_track_status == '5') { ?>    
                            	<li>
                            		<a href="<?php echo site_url('job_sheet/update_jobsheet/' . $quote->quote_id); ?>">
						                <i class="fa fa-upload fa-margin"></i> <?php _trans('update_job_sheet'); ?>
						            </a>
                            	</li><?php } ?>
                            	<?php if($quote->current_track_status <= '8') { ?>  
                            	<li>
                                    <a href="javascript:void(0)" data-quote-id="<?php echo $quote->quote_id; ?>" data-toggle="modal" data-target="#orderHistory" class="order_history">   
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('order_history'); ?>
                                    </a>
								</li>
								<?php } ?>
				 			</ul>
               		</div>
				</div>
		</div>
		<div class="quote-card__footer">
			<a class="anchor anchor--underlined anchor--blue" href="<?php echo site_url('user_quotes/view/').$quote->quote_id.'/current'; ?>">View details</a>
		</div>
	</div>
	</div>
	<input type="hidden" id="delete_quote<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
</div>
<?php } ?>

<script type="text/javascript">
	function deleteuserquote(quote_id){
		// console.log("quote_id=="+quote_id);
		 $.post("<?php echo site_url('user_quotes/ajax/delete'); ?>", {
                    quote_id: quote_id,
                    _mm_csrf: $("#delete_quote_mm_csrf").val()
                },
                function (data) {
                	// console.log(data);
                	// console.log($('.quote-card').length);
                	if(data == "success"){
                		$("#quote_card_"+quote_id+"").remove();
                		$("#bookable_quote").html("BOOKABLE QUOTES ( "+$('.quote-card').length+" )");
                		$("#total_user_quote h3").html("<?php echo $label_name; ?>" +" ( "+$('.quote-card').length+" )");
                		
                	}
                }
              );
	}
</script>