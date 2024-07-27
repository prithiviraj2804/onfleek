<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php echo $breadcrumb; ?></h3>
				</div>
			</div>
		</div>
	</div>
</header>
<div id="content">
    <div class="row">
        <div class="col-xs-12 top-15">
            <a class="anchor anchor-back" href="<?php echo site_url('reminder/vehicle_reminder_index'); ?>"><i class="fa fa-long-arrow-left"></i><span>Back to List</span></a>
        </div>
        <div class="col-xs-12 col-md-12 col-md-offset-3">
			<div class="container-wide usermanagement overflow_inherit">
                <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
				<section class="tabs-section" >
					<div class="tab-content">
                        <input class="hidden" name="is_update" type="hidden" value="0">
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('Vehicle(S)'); ?>*</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="hidden" name="vehicle_reminder_id" id="vehicle_reminder_id" class="form-control" value="<?php echo $vehicle_reminder_details->vehicle_reminder_id; ?>">
                                <select name="reminder_vehicle_id" id="reminder_vehicle_id" class="bootstrap-select bootstrap-select-arrow form-control" data-live-search="true">
                                    <option value="">Select vehicle Type</option>
                                    <?php if(count($user_cars)>0){
                                        foreach($user_cars as $userCarsList){ ?>
                                         <option value="<?php echo $userCarsList->car_list_id; ?>" <?php if($vehicle_reminder_details->reminder_vehicle_id == $userCarsList->car_list_id){ echo 'selected'; }?> ><?php echo $userCarsList->brand_name."-".$userCarsList->model_name."-".$userCarsList->variant_name."-".$userCarsList->car_model_year."-(".$userCarsList->car_reg_no.")"; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('Renewal Type'); ?>*</label>
                            </div>
                            <div class="col-sm-9">
                                <select name="vehicle_renewal_type_id" id="vehicle_renewal_type_id" class="bootstrap-select bootstrap-select-arrow form-control" data-live-search="true">
                                    <option value="">Select Renewal Type</option>
                                    <option value="1" <?php if($vehicle_reminder_details->vehicle_renewal_type_id == 1){ echo "selected"; }?> ><?php echo "Certification"; ?></option>
                                    <option value="2" <?php if($vehicle_reminder_details->vehicle_renewal_type_id == 2){ echo "selected"; }?> ><?php echo "License"; ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('Due Date'); ?>*</label>
                            </div>
                            <div class="col-sm-9">
                                <input class="form-control datepicker" type="text" name="vehicle_reminder_next_due_date" id="vehicle_reminder_next_due_date" value="<?php echo $vehicle_reminder_details->vehicle_reminder_next_due_date?date_from_mysql($vehicle_reminder_details->vehicle_reminder_next_due_date):''; ?>">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required" style="margin-right: 3px"><?php _trans('Time Threshold'); ?></label>
                            </div>
                            <div class="col-sm-9">
                                <input id="vehicle_time_interval" style="width:100px;float: left;" class="form-control" type="text" value="<?php echo $vehicle_reminder_details->vehicle_time_interval;?>" name="vehicle_time_interval">
                                <select id="vehicle_time_frequency" style="margin-left: 20px;width: 200px;float: left;height: 38px;" class="form-control" name="vehicle_time_frequency">
                                    <option value=""> Select frequency</option>
                                    <option value="days" <?php if($vehicle_reminder_details->vehicle_time_frequency == 'days'){ echo 'selected' ; } ?> >day(s)</option>
                                    <option value="weeks" <?php if($vehicle_reminder_details->vehicle_time_frequency == 'weeks'){ echo 'selected' ; } ?> >week(s)</option>
                                    <option value="months" <?php if($vehicle_reminder_details->vehicle_time_frequency == 'months'){ echo 'selected' ; } ?> >month(s)</option>
                                    <option value="years" <?php if($vehicle_reminder_details->vehicle_time_frequency == 'years'){ echo 'selected' ; } ?> >year(s)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label"><?php _trans('Email Notifications'); ?></label>
                            </div>
                            <div class="col-sm-9 paddingTop7px">
                                <label class="switch">
    						        <input type="checkbox" class="checkbox" name="vehicle_email_notification" id="vehicle_email_notification" <?php if($vehicle_reminder_details->vehicle_email_notification == '1'){ echo "checked"; }?> value="<?php if($vehicle_reminder_details->vehicle_email_notification == '1'){ echo "1"; } else{ echo '0'; }?>" >
    						        <span class="slider round"></span>
    					        </label>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label"><?php _trans('Users'); ?>*</label>
                            </div>
                            <div class="col-sm-9">
                                <select name="entity_id" id="entity_id" class="bootstrap-select bootstrap-select-arrow form-control" data-live-search="true">
                                    <option value="">Select users</option>
                                    <?php if(count($entity_list)>0){
                                        foreach($entity_list as $entityList){ ?>
                                         <option value="<?php echo $entityList->client_id; ?>" <?php if($vehicle_reminder_details->entity_id == $entityList->client_id){ echo 'selected'; }?> ><?php echo $entityList->client_name; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="buttons text-center paddingTop20px hideSubmitButtons">
                            <button value="1" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
                                <i class="fa fa-check"></i> <?php _trans('Save & Add another'); ?>
                            </button>
                            <button value="2" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
                                <i class="fa fa-check"></i> <?php _trans('Save'); ?>
                            </button>
                            <button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default">
                                <i class="fa fa-times"></i><?php _trans('cancel'); ?>
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

    $('#reminder_vehicle_id').change(function() {
        var reminder_vehicle_id = $('#reminder_vehicle_id').val();
        $.post("<?php echo site_url('clients/ajax/get_client_detail_by_vehicle_id'); ?>", {
            car_list_id: $('#reminder_vehicle_id').val(),
            _mm_csrf: $('#_mm_csrf').val()
        },
        function(data) {
            var response = JSON.parse(data);
            $('#entity_id').empty();
            if (response.length > 0) {
                for (row in response) {
                    $('#entity_id').append($('<option></option>').attr('value', response[row].client_id).text(response[row].client_name + ' ' + response[row].client_contact_no));
                }
                $('#entity_id').selectpicker("refresh");
            } else {
                $('#entity_id').selectpicker("refresh");
            }
        });
    });

    $("#btn_cancel").click(function () {
        window.location.href = "<?php echo site_url('reminder/vehicle_reminder_index'); ?>";
    });

    $("#vehicle_email_notification").click(function(){
        if($("#vehicle_email_notification:checked").is(":checked")){
            $("#vehicle_email_notification").val(1);
        }else{
            $("#vehicle_email_notification").val(0);
        }
    });

    $(".btn_submit").click(function () {
        $(".hideSubmitButtons").hide();
        $.post('<?php echo site_url('reminder/ajax/save_vehicle_reminder'); ?>', {
            vehicle_reminder_id : $("#vehicle_reminder_id").val(),
            reminder_vehicle_id : $("#reminder_vehicle_id").val(),
            vehicle_renewal_type_id : $("#vehicle_renewal_type_id").val(),
            vehicle_reminder_next_due_date : $('#vehicle_reminder_next_due_date').val().split("/").reverse().join("-"),
            vehicle_time_interval : $("#vehicle_time_interval").val(),
            vehicle_time_frequency : $('#vehicle_time_frequency').val(),
            vehicle_email_notification : $('#vehicle_email_notification').val(),
            entity_id : $('#entity_id').val(),
            btn_submit : $(this).val(),
            _mm_csrf: $('#_mm_csrf').val()
        }, function (data) {
            list = JSON.parse(data);
            if(list.success=='1'){
                notie.alert(1, 'Successfully Created', 2);
                if(list.btn_submit == '1'){
                    setTimeout(function(){
                        window.location = "<?php echo site_url('reminder/vehicle_reminder'); ?>";
                    }, 100);
                }else{
                    setTimeout(function(){
                        window.location = "<?php echo site_url('reminder/vehicle_reminder_index'); ?>";
                    }, 100);
                }
            }else{
                $(".hideSubmitButtons").show();
                notie.alert(3, 'Oops, something has gone wrong', 2);
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