<script type="text/javascript">
	 var is_reshedule = false;
	 var emp; 
    $(function () {
        // Display the create quote modal
        $('#generateInvoice').modal('show');
        $('.select2').select2();
       
          $('#inv_btn_submit').click(function () {

            $.post("<?php echo site_url('mech_pos_invoices/ajax/create'); ?>", {
                    quote_id:$('#quote_id').val(),
                    _mm_csrf: $('#_mm_csrf').val()
                },
                function (data) {
                    var response = JSON.parse(data);
                   
                    if(response.success === 1){
                    	notie.alert(1, 'Invoice successfully created!!', 2);
						$('.modal').remove();
						$('.modal-backdrop').remove();
						$('body').removeClass( "modal-open" );
						
						setTimeout(function(){ window.location = "<?php echo site_url('mech_pos_invoices/create'); ?>/"+response.invoice_id; }, 1000);
						
                    }else{
                    	notie.alert(1, 'Oops, something has gone wrong', 3);
                    }
                });
        });
        
         
		$('.modal-popup-close').click(function () {
			$('.modal').remove();
			$('.modal-backdrop').remove();
			$('body').removeClass( "modal-open" );
         });      
        
    });

</script>

<div class="modal fade" id="generateInvoice" tabindex="-1" role="dialog" aria-labelledby="generateInvoiceLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="generate_invoice_fdetail">
			<form name="invoice_fdetails" method="post" class="form">
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
								<h3 class="modal__h3"><?php _trans('select_job_card'); ?> </h3>
							</div>
						</div>
						<div>
							<div class="row spacetop-20">
								<div class="col-sm-10 col-centered">
									<select class="select2" name="quote_id" id="quote_id">
										<option value=''><?php _trans('select_job_card'); ?></option>
										<?php if(count($quote_detail) > 0) { ?>
											<?php foreach ($quote_detail as $quote) { ?>
                        				<option value="<?php echo $quote->quote_id; ?>"><?php echo $quote->appointment_no; ?></option>
                    					<?php } } ?>
									</select>
								</div>
							</div>
						</div>

					</div>
				</div>
				<div class="modal-footer text-center">
					<button type="button" class="btn btn-rounded btn-primary" name="inv_btn_submit" id="inv_btn_submit">
						<?php _trans('submit'); ?> 
					</button>
					<button type="button" class="btn btn-rounded btn-default modal-popup-close">
						<?php _trans('cancel'); ?> 
					</button>
				</div>
			</form>
	
		</div>
	</div>
</div>