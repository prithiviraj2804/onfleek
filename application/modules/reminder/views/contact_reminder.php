<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php echo _trans($breadcrumb); ?></h3>
				</div>
			</div>
		</div>
	</div>
</header>
<div id="content">
    <div class="row">
        <div id="gif" class="gifload">
			<div class="gifcenter">
			  <center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
		    </div>
		</div>

        <div class="col-xs-12 top-15">
            <a class="anchor anchor-back" onclick="goBack()" href="<?php echo site_url('reminder/contact_reminder_index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
        </div>
        <div class="col-xs-12 col-md-12 col-md-offset-3">
			<div class="container-wide usermanagement overflow_inherit">
                <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
				<section class="tabs-section" >
					<div class="tab-content">
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable551'); ?>*</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="hidden" name="contact_reminder_id" id="contact_reminder_id" class="form-control" value="<?php echo $contact_reminder_details->contact_reminder_id;?>">
                                <select name="refered_by_type" id="refered_by_type" class="bootstrap-select removeError bootstrap-select-arrow" data-live-search="true">
                                    <option value=""><?php _trans('label957'); ?></option>
                                    <option value="1"><?php echo "Customer"; ?></option>
                                    <option value="2"><?php echo "Employee"; ?></option>
                                    <option value="3"><?php echo "Supplier"; ?></option>
                                    <?php /* foreach ($reference_type as $rtype) {
                                        print_r($rtype);
                                        if ($contact_reminder_details->refered_by_type == $rtype->refer_type_id) {
                                            $selected = 'selected="selected"';
                                        } else {
                                            $selected = '';
                                    } ?>
                                    <option value="<?php echo $rtype->refer_type_id; ?>" <?php echo $selected; ?>><?php echo $rtype->refer_name; ?></option>
                                    <?php } */ ?>
                                </select> 
                            </div>
                        </div> 
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable559'); ?>*</label>
                            </div>
                            <div class="col-sm-9">
                                <select name="refered_by_id" id="refered_by_id" class="bootstrap-select removeError bootstrap-select-arrow" data-live-search="true">
                                    <option value=""><?php _trans('label958'); ?></option>
                                    <?php foreach ($refered_dtls as $refered) {
                                        if ($contact_reminder_details->refered_by_type == 2) {
                                            $id = $refered->employee_id;
                                            $name = ($refered->employee_name?$refered->employee_name:"").' '.($refered->mobile_no?"(".$refered->mobile_no.")":"");
                                        } elseif ($contact_reminder_details->refered_by_type == 1) {
                                            $id = $refered->client_id;
                                            $name = ($refered->client_name?$refered->client_name:"").' '.($refered->client_contact_no?"(".$refered->client_contact_no.")":"");
                                        } elseif ($contact_reminder_details->refered_by_type == 3) {
                                            $id = $refered->supplier_id;
                                            $name = ($refered->supplier_name?$refered->supplier_name:"").' '.($refered->supplier_contact_no?"(".$refered->supplier_contact_no.")":"");
                                        }
                                        if ($contact_reminder_details->refered_by_id == $id) {
                                            $selected = 'selected="selected"';
                                        } else {
                                            $selected = '';
                                        } ?>
                                    <option value="<?php echo $id; ?>" <?php echo $selected; ?>><?php echo $name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable558'); ?>*</label>
                            </div>
                            <div class="col-sm-9">
                                <input class="form-control removeErrorInput" type="text" name="contact_reminder_next_due_date" id="contact_reminder_next_due_date" value="<?php if($contact_reminder_details->contact_reminder_next_due_date != "" && $contact_reminder_details->contact_reminder_next_due_date != "0000-00-00 00:00:00"){echo date("d-m-Y H:i:s", strtotime($contact_reminder_details->contact_reminder_next_due_date));}else { echo date('d-m-Y H:m:s'); }?>" autocomplete="off">

                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable19'); ?>*</label>
                            </div>
                            <div class="col-sm-9">
                                <select name="status" id="status" class="bootstrap-select removeError bootstrap-select-arrow" data-live-search="true">
                                    <option value=""><?php _trans('lable285'); ?></option>
                                    <option <?php if($contact_reminder_details->status == "O"){ echo "selected"; } ?> value="O"><?php _trans('lable531'); ?></option>
                                    <option <?php if($contact_reminder_details->status == "P"){ echo "selected"; } ?> value="P"><?php _trans('lable560'); ?></option>
                                    <option <?php if($contact_reminder_details->status == "C"){ echo "selected"; } ?> value="C"><?php _trans('lable535'); ?></option>
                                </select> 
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable177'); ?></label>
                            </div>
                            <div class="col-sm-9">
                                <textarea class="form-control" type="text" name="description" id="description" ><?php echo $contact_reminder_details->description; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable292'); ?>*</label>
                            </div>
                            <div class="col-sm-9">
                                <select name="employee_id" id="employee_id" class="bootstrap-select removeError bootstrap-select-arrow" data-live-search="true">
                                    <option value=""><?php _trans('lable457'); ?></option>
                                    <?php foreach ($employee_list as $employeeList) {
                                        if ($contact_reminder_details->employee_id == $employeeList->employee_id) {
                                            $selected = 'selected="selected"';
                                        } else {
                                            $selected = '';
                                    } ?>
                                    <option value="<?php echo $employeeList->employee_id; ?>" <?php echo $selected; ?>><?php echo $employeeList->employee_name; ?></option>
                                    <?php } ?>
                                </select> 
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label"><?php _trans('lable557'); ?></label>
                            </div>
                            <div class="col-sm-9 paddingTop7px">
                                <label class="switch">
    						        <input type="checkbox" class="checkbox" name="contact_email_notification" id="contact_email_notification" <?php if($contact_reminder_details->contact_email_notification == '1'){ echo "checked"; }?> value="<?php if($contact_reminder_details->contact_email_notification == '1'){ echo "1"; } else{ echo '0'; }?>" >
    						        <span class="slider round"></span>
    					        </label>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 buttons text-center paddingTop40px">
                            <button value="1" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
                                <i class="fa fa-check"></i> <?php _trans('lable56'); ?>
                            </button>
                            <button value="2" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
                                <i class="fa fa-check"></i> <?php _trans('lable57'); ?>
                            </button>
                            <button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default">
                                <i class="fa fa-times"></i><?php _trans('lable58'); ?>
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

    $('#contact_reminder_next_due_date').datetimepicker({
        format: 'DD-MM-YYYY HH:mm:ss',
    });

    $('#refered_by_type').change(function() {
        var refered_by_type = $('#refered_by_type').val();
        if (refered_by_type != '') {
            if (refered_by_type == '2') {
                var site_url = "<?php echo site_url('mech_employee/ajax/get_employee_list'); ?>";
            } else if (refered_by_type == '1') {
                var site_url = "<?php echo site_url('clients/ajax/get_client_list'); ?>";
            } else if (refered_by_type == '3') {
                var site_url = "<?php echo site_url('suppliers/ajax/get_supplier_list'); ?>";
            }
            $('#gif').show();
            $.post(site_url, {
                    refered_by_type: $('#refered_by_type').val(),
                    _mm_csrf: $('#_mm_csrf').val()
                },
                function(data) {
                    var response = JSON.parse(data);
                    carResponse = response;
                    // console.log(response);
                    var rid = '';
                    var name = '';
                    var phone = '';
                    $('#refered_by_id').empty(); // clear the current elements in select box
                    if (refered_by_type == '2') {
                        $('#gif').hide();
                        $('#refered_by_id').append($('<option></option>').attr('value', '').text('Select Employee'));
                    }else if (refered_by_type == '1') {
                        $('#gif').hide();
                        $('#refered_by_id').append($('<option></option>').attr('value', '').text('Select Customer'));
                    }else if (refered_by_type == '3') {
                        $('#gif').hide();
                        $('#refered_by_id').append($('<option></option>').attr('value', '').text('Select Supplier'));
                    }
                    if (response.length > 0) {
                        for (row in response) {
                            if (refered_by_type == '2') {
                                $('#gif').hide();
                                rid = response[row].employee_id;
                                name = response[row].employee_name;
                                phone = response[row].mobile_no;
                            } else if (refered_by_type == '1') {
                                $('#gif').hide();
                                rid = response[row].client_id;
                                name = response[row].client_name;
                                phone = response[row].client_contact_no;
                            }else if (refered_by_type == '3') {
                                $('#gif').hide();
                                rid = response[row].supplier_id;
                                name = response[row].supplier_name;
                                phone = response[row].supplier_contact_no;
                            }

                            $('#refered_by_id').append($('<option></option>').attr('value', rid).text( (name?name:"") +' '+ (phone?"("+ phone +")":"") ));
                        }
                        $('#refered_by_id').selectpicker("refresh");
                    } else {
                        $('#gif').hide();
                        $('#refered_by_id').selectpicker("refresh");
                    }
                });
        } else {
            $('#gif').hide();
            console.log('refered_by_type else');
        }
    });

    $("#btn_cancel").click(function () {
        window.location.href = "<?php echo site_url('reminder/contact_reminder_index'); ?>";
    });

    $("#contact_email_notification").click(function(){
        if($("#contact_email_notification:checked").is(":checked")){
            $("#contact_email_notification").val(1);
        }else{
            $("#contact_email_notification").val(0);
        }
    });

    $(".btn_submit").click(function () {

    /* Frontend Field Validation */

        $('.border_error').removeClass('border_error');
        $('.has-error').removeClass('has-error');

        var validation = [];

        if($("#refered_by_type").val() == ''){
            validation.push('refered_by_type');
        }
        if($("#refered_by_id").val() == ''){
            validation.push('refered_by_id');
        }
        if($("#contact_reminder_next_due_date").val() == ''){
            validation.push('contact_reminder_next_due_date');
        }
        if($("#status").val() == ''){
            validation.push('status');
        }
        if($("#employee_id").val() == ''){
            validation.push('employee_id');
        }

        if(validation.length > 0){
            validation.forEach(function(val) {
                $('#'+val).addClass("border_error");
                $('#'+val).parent().addClass('has-error');

            });
            return false;
        }
		$('.border_error').removeClass('border_error');
        $('.has-error').removeClass('has-error');
        $('#gif').show();

        $.post('<?php echo site_url('reminder/ajax/save_contact_reminder'); ?>', {
            contact_reminder_id : $("#contact_reminder_id").val(),
            refered_by_type : $('#refered_by_type').val(),
            refered_by_id : $('#refered_by_id').val(),
            contact_reminder_next_due_date : $('#contact_reminder_next_due_date').val(),
            status : $('#status').val(),
            description : $('#description').val(),
            employee_id: $("#employee_id").val(),
            contact_email_notification : $('#contact_email_notification').val(),
            btn_submit : $(this).val(),
            _mm_csrf: $('#_mm_csrf').val()
        }, function (data) {
            list = JSON.parse(data);
            if(list.success=='1'){
                notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
                if(list.btn_submit == '1'){
                    setTimeout(function(){
                        window.location = "<?php echo site_url('reminder/contact_reminder'); ?>";
                    }, 100);
                }else{
                    setTimeout(function(){
                        window.location = "<?php echo site_url('reminder/contact_reminder_index'); ?>";
                    }, 100);
                }
            }else{
                $('#gif').hide();
                notie.alert(3, '<?php _trans('toaster2'); ?>', 2);
                $('.has-error').removeClass('has-error');
                for (var key in list.validation_errors) {
                    $('#' + key).parent().addClass('has-error');
                    $('.error_msg_' + key).show().empty().html(list.validation_errors[key]);
                }
            }
        });
    });
});

</script>