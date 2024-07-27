<script>
    $(function () {
        $('#enter-payment').modal('show');

        var entity_type = '<?php echo $entity_type; ?>'
        var customer_id = '<?php echo $customer_id; ?>'
        var entity_id = '<?php echo $entity_id; ?>'
        
        $(".bootstrap-select").selectpicker("refresh");

        $('#enter-payment').on('shown', function () {
            $('#payment_amount').focus();
        });

        $('.modal-popup-close').click(function () {
            $('.modal').remove();
            $('.modal-backdrop').remove();
            $('body').removeClass( "modal-open" );
        });

        $('#payment_amount').change(function() {
            var payment_amount = $('#payment_amount').val();
            $('#gif').show();
            $.post("<?php echo site_url('mech_payments/ajax/checkPaymentAmount'); ?>", {
                payment_amount: payment_amount,
                entity_type: entity_type,
                entity_id: entity_id,
                _mm_csrf: $('#_mm_csrf').val()
            },
            function(data) {
                //var response = JSON.parse(data);
                if (data) {
                    $('#gif').hide();
                    $(".payment_amount_error").show().html(data);
                    $("#btn_submit").hide();
                } else {
                    $('#gif').hide();
                    $(".payment_amount_error").hide().html('');
                    $("#btn_submit").show();
                }
            });
        });

        $('#btn_submit').click(function () {

            var validation = [];

            if($("#payment_method_id").val() == ''){
                validation.push('payment_method_id');
            }

            if($("#invoice_amount").val() == ''){
                validation.push('invoice_amount');
            }

            if($("#payment_amount").val() == ''){
                validation.push('payment_amount');
            }

            if($("#paid_on").val() == ''){
                validation.push('paid_on');
            }

            if(validation.length > 0){
                validation.forEach(function(val) {
                    $('#'+val).addClass("border_error");
                    if($('#'+val+'_error').length == 0){
                        $('#' + val).parent().addClass('has-error');
                    } 
                });
                return false;
            }
            $('.border_error').removeClass('border_error');
			$('.has-error').removeClass('has-error');
            $('#gif').show();


            $.post('<?php echo site_url('mech_payments/ajax/save'); ?>', {
                entity_id : entity_id,                
                entity_type: entity_type,
                payment_method_id : $("#payment_method_id").val()?$("#payment_method_id").val():'',
                invoice_amount : $("#invoice_amount").val()?$("#invoice_amount").val():'',
                payment_amount : $("#payment_amount").val()?$("#payment_amount").val():'',
                customer_id: customer_id,
                online_payment_ref_no : $("#online_payment_ref_no").val()?$("#online_payment_ref_no").val():'',
                paid_on : $("#paid_on").val()?$("#paid_on").val():'',
                payment_note : $("#payment_note").val()?$("#payment_note").val():'',
                _mm_csrf: $('#_mm_csrf').val()
                },
                function (data) {
                    var response = JSON.parse(data);
                    if (response.success == '1') {
                    notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
                    if(entity_type == 'invoice'){
                        setTimeout(function() {
                            <?php if($this->session->userdata('plan_type') == 3){  ?>
                            window.location = "<?php echo site_url('spare_invoices'); ?>";
                            <?php } else { ?>
                            window.location = "<?php echo site_url('mech_invoices'); ?>";
                            <?php } ?>
                        }, 1000);
                    }else if(entity_type == 'purchase'){
                        setTimeout(function() {
                        window.location = "<?php echo site_url('mech_purchase'); ?>";
                    }, 1000);
                    }else if(entity_type == 'expense'){
                        setTimeout(function() {
                        window.location = "<?php echo site_url('mech_expense'); ?>";
                    }, 1000);
                    }
                }else{
                    $('#gif').hide();
                    for (var key in response.validation_errors) {
                        $('#' + key).parent().addClass('has-error');
                        $('.error_msg_' + key).show().empty().html(response.validation_errors[key]);
                    }
                }
                });
        });
    });
</script>
<div class="modal fade" id="enter-payment" tabindex="-1" role="dialog" aria-labelledby="modal_enter_payment" >
	<div class="modal-dialog" role="document">
		<div class="modal-content">
                <div id="gif" class="gifload">
                    <div class="gifcenter">
                    <center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
                    </div>
                </div>
			<div name="car_fdetails" class="car_fdetails">
                <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?= $this->security->get_csrf_hash(); ?>">
				<div class="modal-header">
					<div class="col-xs-12 text-center">
						<h3 class="modal__h3"><?php _trans('lable475'); ?></h3>
					</div>
					<button type="button" class="modal-close modal-popup-close">
						<i class="font-icon-close-2"></i>
					</button>
				</div>
				<div class="modal-body">
                    <div class="form">
                        <div class="row">
                                <div class="form-group clearfix">
                                    <label class="form_label"><?php _trans('lable113'); ?>*</label>
                                    <div class="form_controls">
                                        <select name="payment_method_id" id="payment_method_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true">
                                            <option value="">Select payment mode</option>
                                            <?php foreach ($payment_methods as $payment_method) {
                                                ?>
                                            <option value="<?php echo $payment_method->payment_method_id; ?>" <?php if ($this->mdl_mech_payments->form_value('payment_method_id', true) == $payment_method->payment_method_id) {
                                                    echo 'selected';
                                                } ?>> <?php echo $payment_method->payment_method_name; ?>
                                            </option>
                                            <?php
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form_group clearfix">
                                            <label class="form_label"><?php _trans('lable114'); ?> *</label>
                                            <div class="form_controls">
                                                <input readonly="readonly" type="text" name="invoice_amount" id="invoice_amount" class="form-control" value="<?php echo $grand_amt?$grand_amt:""; ?>" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group clearfix">
                                            <label class="form_label"><?php _trans('lable115'); ?> *</label>
                                            <div class="form_controls" for="payment_amount">
                                                <input type="text" name="payment_amount" id="payment_amount" class="form-control" value="<?php echo $balance_amt?$balance_amt:""; ?>" autocomplete="off">
                                                <label class="payment_amount_error" style="color: red"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form_group clearfix">
                                            <label class="form_label"><?php _trans('lable116'); ?> *</label>
                                            <div class="form_controls">
                                                <input type="text" class="form-control removeErrorInput datepicker" style="padding: 17px 4px 6px 1rem ! important" id="paid_on" name="paid_on" value="<?php echo ($this->mdl_mech_payments->form_value('paid_on', true)) ? date_from_mysql($this->mdl_mech_payments->form_value('paid_on', true)) : date_from_mysql(date('Y-m-d')); ?>" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group clearfix">
                                            <label class="form_label"><?php _trans('lable117'); ?>.</label>
                                            <div class="form_controls">
                                                <input type="text" name="online_payment_ref_no" id="online_payment_ref_no" class="form-control" value="<?php echo $this->mdl_mech_payments->form_value('online_payment_ref_no', true); ?>" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <label class="form_label"><?php _trans('lable118'); ?> </label>
                                    <div class="form_controls">
                                        <textarea name="payment_note" id="payment_note" class="form-control"><?php echo $this->mdl_mech_payments->form_value('payment_note', true); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <button id="btn_submit" name="btn_submit" class="btn btn-rounded btn-primary btn-padding-left-right-40" value="1">
                            <i class="fa fa-check"></i> <?php _trans('lable57'); ?>
                        </button>
                        <button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default" value="1">
                            <i class="fa fa-times"></i> <?php _trans('lable58'); ?>
                        </button>
                    </div>
			    </div>
		    </div>
	    </div>
    </div>
</div>
