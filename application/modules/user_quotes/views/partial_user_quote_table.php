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
			</div>
		</div>
	</div>
	<div class="quote-card-body col-sm-10">
		<div class="quote-card-details">
			<div class="quote-card-menu hidden-xs">
				<button class="quote-card-menu-button" onclick="remove_entity(<?php echo $quote->quote_id; ?>,'user_quotes', 'quote','<?= $this->security->get_csrf_hash() ?>')">
					<i class="fa fa-trash"></i>
				</button>
			</div>
			<div class="quote-card-detail">
				<div class="quote-card-detail-label">
					<?php _trans('quote_number');?>
				</div>
				<div class="quote-card-detail__value">
					<?php echo $quote->quote_no; ?>
				</div>
			</div>
			<div class="quote-card-detail">
				<div class="quote-card-detail-label">
					<?php _trans('vehicle_details');?>
				</div>
				<div class="quote-card-detail__value">
					<?php echo $quote->car_model_year." ".$quote->brand_name." ".$quote->model_name." ".$quote->variant_name;  ?>
				</div>
			</div>
			<div class="quote-card-detail">
				<div class="quote-card-detail-label">
					<?php _trans('quote_requested_on');?>
				</div>
				<div class="quote-card-detail__value">
					<?php echo date("d-m-Y", strtotime($quote->created_on)); ?>
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
								<a href="<?php echo site_url('user_quotes/update_user_request_quote/re/' . $quote->quote_id); ?>">
									<button type="button" class="btn btn-inline btn-primary">
										<?php _trans('edit_quote');?>
									</button></a>
							</div>

							<div class="quote-card__service__buttons-inner">
								<a href="<?php echo site_url('user_quotes/book/appointment/').$quote->quote_id; ?>">
									<button type="button" class="btn btn-inline btn-primary">
										<?php _trans('book_appointment');?>
									</button></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="quote-card__footer">
			<a class="anchor anchor--underlined anchor--blue" href="<?php echo site_url('user_quotes/view/').$quote->quote_id; ?>">View details</a>
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