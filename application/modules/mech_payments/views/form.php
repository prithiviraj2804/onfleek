<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php _trans('lable110'); ?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_payments/form'); ?>">
                        <i class="fa fa-plus"></i> <?php _trans('lable40'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?= $this->security->get_csrf_hash(); ?>">
<div id="content">
    <div class="row">
         <div id="gif" class="gifload">
			<div class="gifcenter">
			  <center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
		    </div>
		</div>
        <div class="col-xs-12 top-15">
            <a class="anchor anchor-back" onclick="goBack()" href="<?php echo site_url('mech_payments/index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
        </div>
        <div class="col-xs-12 col-md-12 col-md-offset-3">
            <?php echo $this->layout->load_view('layout/alerts'); ?>
            <div class="container-wide">
                <input class="hidden" name="payment_id" type="hidden" value="<?php echo $this->mdl_mech_payments->form_value('payment_id', true); ?>" autocomplete="off">
                <!-- <input class="hidden" name="job_card_no" id="job_card_no" type="hidden" value=""> -->
                <input class="hidden" name="customer_id" id="customer_id" type="hidden" value="<?php echo $this->mdl_mech_payments->form_value('customer_id', true); ?>" autocomplete="off">
                <div class="box">
                    <div class="box_body">
                        <div class="form-group">
                            <label class="form_label"><?php _trans('lable111'); ?> *</label>
                            <div class="form_controls">
                                <select name="entity_type" id="entity_type" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                                    <option value=""><?php _trans('lable111'); ?></option>
                                    <option value="invoice" <?php if ($this->mdl_mech_payments->form_value('entity_type', true) == 'invoice') {
echo 'selected';
} ?>> <?php _trans('lable119'); ?></option>
                                    <!-- <option value="jobcard">Job Card</option> -->
                                    <option value="jobcard" <?php if ($this->mdl_mech_payments->form_value('entity_type', true) == 'jobcard') {
echo 'selected';
} ?>> <?php _trans('lable1019'); ?></option>                                    
                                    <option value="purchase" <?php if ($this->mdl_mech_payments->form_value('entity_type', true) == 'purchase') {
echo 'selected';
} ?>><?php _trans('lable120'); ?></option>
                                    <option value="expense" <?php if ($this->mdl_mech_payments->form_value('entity_type', true) == 'expense') {
echo 'selected';
} ?>><?php _trans('lable121'); ?></option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form_label"><?php _trans('lable112'); ?> *</label>
                            <div class="form_controls">
                                <select name="entity_id" id="entity_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                                    <option value=""><?php _trans('lable112'); ?></option>
                                    <?php 
                                    if (count($open_invoices) > 0) {
                                        foreach ($open_invoices as $open_invoices_list) {
                                            ?>
                                    <?php
                                    if ($this->mdl_mech_payments->form_value('entity_type', true) == 'invoice') {
                                        ?>
                                    <option value="<?php echo $open_invoices_list->invoice_id; ?>" <?php if ($open_invoices_list->invoice_id == $this->mdl_mech_payments->form_value('entity_id', true)) {
                                            echo 'selected';
                                        } ?> grand_total="<?php echo $open_invoices_list->grand_total; ?>" total_due_amount="<?php echo $open_invoices_list->total_due_amount; ?>" appointment_no="<?php echo $open_invoices_list->appointment_no; ?>" customer_id="<?php echo $open_invoices_list->customer_id; ?>"> <?php echo $open_invoices_list->invoice_no.'-'.$open_invoices_list->car_reg_no; ?>
                                    </option>

                                    <?php
                                    } elseif ($this->mdl_mech_payments->form_value('entity_type', true) == 'purchase') {
                                        ?>
                                    <option value="<?php echo $open_invoices_list->purchase_id; ?>" <?php if ($open_invoices_list->purchase_id == $this->mdl_mech_payments->form_value('entity_id', true)) {
                                            echo 'selected';
                                        } ?> grand_total="<?php echo $open_invoices_list->grand_total; ?>" total_due_amount="<?php echo $open_invoices_list->total_due_amount; ?>" appointment_no="<?php echo $open_invoices_list->purchase_number; ?>" customer_id="<?php echo $open_invoices_list->supplier_id; ?>"> <?php echo $open_invoices_list->purchase_number.'-'.$open_invoices_list->supplier_name.'-'.$open_invoices_list->supplier_contact_no; ?>
                                    </option>
                                    <?php
                                    } elseif ($this->mdl_mech_payments->form_value('entity_type', true) == 'expense') {
                                        ?>
                                    <option value="<?php echo $open_invoices_list->expense_id; ?>" <?php if ($open_invoices_list->expense_id == $this->mdl_mech_payments->form_value('entity_id', true)) {
                                            echo 'selected';
                                        } ?> grand_total="<?php echo $open_invoices_list->grand_total; ?>" total_due_amount="<?php echo $open_invoices_list->total_due_amount; ?>" appointment_no="<?php echo $open_invoices_list->bill_no; ?>" customer_id="<?php echo $open_invoices_list->action_emp_id; ?>"> <?php echo $open_invoices_list->bill_no.'-'.$open_invoices_list->supplier_name.'-'.$open_invoices_list->supplier_contact_no; ?>
                                    </option>
                                    <?php
                                    } elseif ($this->mdl_mech_payments->form_value('entity_type', true) == 'jobcard') {
                                        ?>
                                    <option value="<?php echo $open_invoices_list->work_order_id; ?>" <?php if ($open_invoices_list->work_order_id == $this->mdl_mech_payments->form_value('entity_id', true)) {
                                            echo 'selected';
                                    } ?> grand_total="<?php echo $open_invoices_list->grand_total; ?>" total_due_amount="<?php echo $open_invoices_list->total_due_amount; ?>" appointment_no="<?php echo $open_invoices_list->jobsheet_no; ?>" customer_id="<?php echo $open_invoices_list->customer_id; ?>"> <?php echo $open_invoices_list->jobsheet_no.'-'.$open_invoices_list->car_reg_no; ?>
                                        </option>
                                    <?php
                                    } ?>
                                    <?php
                                        }
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
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
                                <div class="form_group">
                                    <label class="form_label"><?php _trans('lable114'); ?> *</label>
                                    <div class="form_controls">
                                        <input readonly="readonly" type="text" name="invoice_amount" id="invoice_amount" class="form-control" value="<?php echo ($this->mdl_mech_payments->form_value('invoice_amount', true)) ? format_amount($this->mdl_mech_payments->form_value('invoice_amount', true)) : ''; ?>" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="form_label"><?php _trans('lable115'); ?> *</label>
                                    <div class="form_controls" for="payment_amount">
                                        <input type="text" name="payment_amount" id="payment_amount" class="form-control" value="<?php echo ($this->mdl_mech_payments->form_value('payment_amount', true)) ? format_amount($this->mdl_mech_payments->form_value('payment_amount', true)) : ''; ?>" autocomplete="off">
                                        <label class="payment_amount_error" style="color: red"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form_group">
                                    <label class="form_label"><?php _trans('lable116'); ?> *</label>
                                    <div class="form_controls">
                                        <input type="text" class="form-control removeErrorInput datepicker" id="paid_on" name="paid_on" value="<?php echo ($this->mdl_mech_payments->form_value('paid_on', true)) ? date_from_mysql($this->mdl_mech_payments->form_value('paid_on', true)) : date_from_mysql(date('Y-m-d')); ?>" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="form_label"><?php _trans('lable117'); ?>.</label>
                                    <div class="form_controls">
                                        <input type="text" name="online_payment_ref_no" id="online_payment_ref_no" class="form-control" value="<?php echo $this->mdl_mech_payments->form_value('online_payment_ref_no', true); ?>" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form_label"><?php _trans('lable118'); ?> </label>
                            <div class="form_controls">
                                <textarea name="payment_note" id="payment_note" class="form-control"><?php echo $this->mdl_mech_payments->form_value('payment_note', true); ?></textarea>
                            </div>
                        </div>
                        <div class="buttons text-center paddingTop20px">
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
</div>

<script type="text/javascript">
    $(document).ready(function() {

        $("#btn_cancel").click(function() {
            window.location = "<?php echo site_url('mech_payments'); ?>";
        });

        $("#btn_submit").click(function() {

            var validation = [];

            if($("#entity_type").val() == ''){
                validation.push('entity_type');
            }

            if($("#entity_id").val() == ''){
                validation.push('entity_id');
            }

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

            // if($("#online_payment_ref_no").val() == ''){
            //     validation.push('online_payment_ref_no');
            // }

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
                payment_id: $("#payment_id").val()?$("#payment_id").val():'',
                customer_id: $('#customer_id').val()?$('#customer_id').val():'',
                entity_type: $("#entity_type").val(),
                entity_id : $("#entity_id").val()?$("#entity_id").val():'',
                payment_method_id : $("#payment_method_id").val()?$("#payment_method_id").val():'',
                invoice_amount : $("#invoice_amount").val()?$("#invoice_amount").val():'',
                payment_amount : $("#payment_amount").val()?$("#payment_amount").val():'',
                paid_on : $("#paid_on").val()?$("#paid_on").val():'',
                online_payment_ref_no : $("#online_payment_ref_no").val()?$("#online_payment_ref_no").val():'',
                payment_note : $("#payment_note").val()?$("#payment_note").val():'',
                _mm_csrf: $('#_mm_csrf').val()
            }, function(data) {
                list = JSON.parse(data);
                if (list.success == '1') {
                    notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
                    setTimeout(function() {
                        window.location = "<?php echo site_url('mech_payments'); ?>";
                    }, 1000);
                }else{
                    $('#gif').hide();
                    for (var key in list.validation_errors) {
                        $('#' + key).parent().addClass('has-error');
                        $('.error_msg_' + key).show().empty().html(list.validation_errors[key]);
                    }
                }
            });
        });

        $('.datetimepicker-1').datetimepicker({
            widgetPositioning: {
                horizontal: 'right'
            },
            defaultDate: new Date(),
            format: 'DD/MM/YYYY',
            minDate: new Date(),
            debug: false
        });

        $('#entity_type').change(function() {
            $('#gif').show();
            var entity_type = $(this).val();
            $.post("<?php echo site_url('mech_payments/ajax/get_entity_list'); ?>
                ", {
                entity_type: entity_type,
                _mm_csrf: $('#_mm_csrf').val()
            },
            function(data) {
                var response = JSON.parse(data);
                // console.log(response);
                if (response.length > 0) {
                    $('#gif').hide();
                    $('#entity_id').empty();
                    // clear the current elements in select box
                    $('#entity_id').append($('<option></option>').attr('value', '').text('Select module'));
                    if (entity_type == 'invoice') {
                        $('#gif').hide();
                        for (row in response) {
                            var option_text = response[row].invoice_no+" "+(response[row].client_name?"-"+response[row].client_name:" ")+" "+(response[row].client_contact_no?"- "+response[row].client_contact_no:"")+" "+(response[row].car_reg_no?"- ("+response[row].car_reg_no+")":'');
                            $('#entity_id').append($('<option></option>').attr('value', response[row].invoice_id).attr('grand_total', response[row].grand_total).attr('total_due_amount', response[row].total_due_amount).attr('appointment_no', response[row].appointment_no).attr('customer_id', response[row].customer_id).text(option_text));
                        }
                    } else if (entity_type == 'purchase') {
                        $('#gif').hide();
                        for (row in response) {
                            var option_text = response[row].purchase_no +" "+(response[row].supplier_name?"- "+response[row].supplier_name:"")+" "+(response[row].supplier_contact_no?"- "+response[row].supplier_contact_no:" ")+" "+(response[row].purchase_number?"- "+response[row].purchase_number:"");
                            $('#entity_id').append($('<option></option>').attr('value', response[row].purchase_id).attr('grand_total', response[row].grand_total).attr('total_due_amount', response[row].total_due_amount).attr('appointment_no', response[row].purchase_number).attr('customer_id', response[row].supplier_id).text(option_text));
                        }
                    } else if (entity_type == 'expense') {
                        $('#gif').hide();
                        for (row in response) {
                            var option_text = response[row].expense_no+" "+(response[row].employee_name?"- "+response[row].employee_name:" ")+" "+
                            (response[row].employee_number?"- "+response[row].employee_number:" ")+" "+(response[row].bill_no?"- "+response[row].bill_no:"");
                            $('#entity_id').append($('<option></option>').attr('value', response[row].expense_id).attr('grand_total', response[row].grand_total).attr('total_due_amount', response[row].total_due_amount).attr('appointment_no', response[row].expense_number).attr('customer_id', response[row].action_emp_id).text(option_text));
                        }
                    }else if (entity_type == 'jobcard') {
                        $('#gif').hide();
                        for (row in response) {
                            var option_text = response[row].jobsheet_no+" "+(response[row].client_name?"-"+response[row].client_name:" ")+" "+(response[row].client_contact_no?"- "+response[row].client_contact_no:"")+" "+(response[row].car_reg_no?"- ("+response[row].car_reg_no+")":'');
                            $('#entity_id').append($('<option></option>').attr('value', response[row].work_order_id).attr('grand_total', response[row].grand_total).attr('total_due_amount', response[row].total_due_amount).attr('appointment_no', response[row].appointment_no).attr('customer_id', response[row].customer_id).text(option_text));
                        }
                    }
                    $('#entity_id').selectpicker("refresh");
                } else {
                    $('#gif').hide();
                    $('#entity_id').empty();
                    // clear the current elements in select box
                    $('#entity_id').append($('<option></option>').attr('value', '').text('Select module'));
                    $('#entity_id').selectpicker("refresh");
                }
            });
        });

    $('#entity_id').change(function() {
        $('.border_error').removeClass('border_error');

        $("#invoice_amount").removeClass('border_error');	
        $("#invoice_amount").parent().removeClass('has-error');
        $("#payment_amount").removeClass('border_error');	
        $("#payment_amount").parent().removeClass('has-error');		

        var grand_total = $('option:selected', this).attr('grand_total');
        var total_due_amount = $('option:selected', this).attr('total_due_amount');
        var customer_id = $('option:selected', this).attr('customer_id');
        var appointment_no = $('option:selected', this).attr('appointment_no');
        $("#invoice_amount").val(grand_total);
        $("#payment_amount").val(total_due_amount);
        $("#customer_id").val(customer_id);
        // $("#job_card_no").val(appointment_no);
    });

    // $("#paid_on").change(function(){
    // var remove = $("#paid_on").val();
    // if(remove != '')
    //     {
    //     $("#paid_on").removeClass('border_error');	
    //     $("#paid_on").parent().removeClass('has-error');	
    //     }
    // });


    $('#payment_amount').change(function() {
            var payment_amount = $('#payment_amount').val();
            var entity_type = $('#entity_type').val();
            var entity_id = $('#entity_id').val();
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
    });
</script> 