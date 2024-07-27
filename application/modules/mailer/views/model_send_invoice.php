<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/lib/summernote/summernote.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/separate/pages/editor.min.css">
<script type="text/javascript">
	function show_option_for_cc_bcc(){
	    $('.option_for_cc_bcc').toggle();
	}
	    
    $(function () {
		$(".bootstrap-select").selectpicker("refresh");
		var inv_cat = '<?php echo $invoice->invoice_category; ?>';
    	$('#send-invoice').modal('show');
	    $('#btn_generate_pdf').click(function () {
			<?php if($invoice->invoice_category == "P"){ ?>
				window.open('<?php echo site_url('mech_pos_invoices/generate_pdf/' .($invoice_id)); ?>', '_blank');
			<?php }else{ ?>
				window.open('<?php echo site_url('mech_invoices/generate_pdf/' .($invoice_id)); ?>', '_blank');
			<?php } ?>
        });
        var template_fields = ["body", "subject", "from_name", "from_email", "cc", "bcc", "pdf_template"];

        $('#email_template').change(function () {
            var email_template_id = $(this).val();
            if (email_template_id == '') return;
			var $this = $(this);
            $.post("<?php echo site_url('email_templates/ajax/get_content'); ?>", {
                email_template_id: email_template_id,
				_mm_csrf: $('#_mm_csrf').val()
            }, function (data) {
				var response = JSON.parse(data);
				$("#bcc").val(response.email_template_bcc);
				$(".note-editable").empty().append(response.email_template_body+' '+'<?php echo $this->session->userdata('user_company'); ?>');
				$("#cc").val(response.email_template_cc);
				$("#from_name").val(response.email_template_from_name);
				$("#subject").val(response.email_template_subject);
            });
        });
		
		$('.modal-popup-close').click(function () {
			$('.modal').remove();
			$('.modal-backdrop').remove();
			$('body').removeClass( "modal-open" );
         }); 
    });
</script>
<div class="modal fade" id="send-invoice" tabindex="-1" role="dialog" aria-labelledby="addNewCustomerLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content withfull" id="add_customer_fdetail">
				<form class="withfull" method="post" class="form-horizontal" action="<?php echo site_url('mailer/send_mech_invoice/' .($invoice_id).'/'.$cat); ?>">
				<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
				<div class="modal-header withfull">
					<button type="button" class="modal-close modal-popup-close">
						<i class="font-icon-close-2"></i>
					</button>
				</div>
				<div class="modal-body withfull">
					<div class="withfull">
						<div class="withfull text-center">
							<div class="col-xs-12">
								<h3 class="modal__h3"><?php echo trans('email_invoice'); ?></h3>
							</div>
						</div>
						<div class="withfull">
							<div class="form_group">
								<label class="form_label">Select Email Template</label>
								<div class="form_controls">
									<select id="email_template" name="email_template" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" >
										<?php foreach ($email_templates as $email_template) {?>
										<option value="<?php echo $email_template->email_template_id; ?>" > <?php echo $email_template->email_template_title; ?></option>
										<?php } ?>
									</select>
                       			</div>
							</div>
							<div class="form_group">
								<label class="form_label">To email</label>
								<div class="form_controls">
									<input type="text" name="to_email" id="to_email" class="form-control" value="<?php echo $invoice->client_email_id; ?>" required="required" autocomplete="off">
			               			<input type="hidden" name="from_name" id="from_name" value="<?php echo $users->user_company; ?>"autocomplete="off">
			               			<input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo $invoice_id; ?>"autocomplete="off">
			               			<input type="hidden" name="from_email" id="from_email" value="<?php echo $users->user_email; ?>"autocomplete="off">
								</div>
							</div>
							<div class="form_group">
								<label class="form_label"></label>
								<div class="form_controls">
									<a class="layout_text_color" href="javascript:void(0)" id="btn_generate_pdf" style="font-size: 16px;" data-invoice-id="<?php echo ($invoice->invoice_id); ?>">
		                      			<i class="fa fa-eye" aria-hidden="true" style="font-size: 20px;"></i>     Preview Pdf</a>
                       			</div>
							</div>
							
							<div class="form_group">
								<label class="form_label"></label>
								<div class="form_controls">
									<a href="javascript:void(0)" onclick="show_option_for_cc_bcc();">Cc / Bcc</a>
                       			</div>
							</div>
							<div class="withfull option_for_cc_bcc" style="display: none;">
		
								<div class="form_group">
									<label class="form_label">CC</label>
									<div class="form_controls">
										<input type="text" name="cc" id="cc" value="<?php echo $email_templates[0]->email_template_cc;?>" class="form-control" autocomplete="off">
									</div>
								</div>
								
								<div class="form_group">
									<label class="form_label">BCC</label>
									<div class="form_controls">
										<input type="text" name="bcc" id="bcc" value="<?php echo $email_templates[0]->email_template_bcc;?>" class="form-control" autocomplete="off">
									</div>
								</div>
								
							</div>
							
							<div class="form_group">
									<label class="form_label">Subject</label>
									<div class="form_controls">
										<input type="text" name="subject" id="subject" class="form-control" value="<?php if($email_templates[0]->email_template_subject){ echo $email_templates[0]->email_template_subject; }else { echo 'Invoice #' .($invoice->appointment_no).' from  '.$this->session->userdata('user_company'); } ?>" autocomplete="off">
									</div>
								</div>
							<div class="form_group">
									<label class="form_label"><?php echo trans('body'); ?></label>
									<div class="form_controls">
										<textarea name="body" id="body" style="height: 200px;"
			                          class="summernote email-template-body form-control taggable" autocomplete="off">
									  
									  <?php if($email_templates[0]->email_template_body){
										  echo $email_templates[0]->email_template_body;
									  }else{ ?>
										Hi,
			                          	Here's your invoice! We appreciate your prompt payment.
									  	Thanks for your business!
									  <?php } ?>
									 
									<?php echo $this->session->userdata('user_company'); ?>
									</textarea>
															</div>
														</div>
								
					
				
					</div>
					</div>
				</div>
				<div class="modal-footer text-center withfull">
					<button type="submit" class="btn btn-rounded btn-primary" name="send_invoice_mail" id="send_invoice_mail">
						SEND MAIL
					</button>
					<button type="button" class="btn btn-rounded btn-default modal-popup-close">
						CANCEL
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/mp_backend/js/lib/summernote/summernote.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.summernote').summernote();
	});
</script>