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
        <div class="col-xs-12 top-15">
            <a class="anchor anchor-back" href="<?php echo site_url('reminder/service_reminder_index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
        </div>
        <div class="col-xs-12 col-md-12 col-md-offset-3">
			<div class="container-wide usermanagement overflow_inherit">
                <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
				<section class="tabs-section" >
					<div class="tab-content">
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('Vehicle(S)'); ?>*</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="hidden" name="service_remainder_id" id="service_remainder_id" class="form-control" value="<?php echo $service_reminder_details->service_remainder_id;?>">
                                <select name="service_vehicle_id" id="service_vehicle_id" class="bootstrap-select bootstrap-select-arrow form-control" data-live-search="true">
                                    <option value="">Select vehicle Type</option>
                                    <?php if(count($user_cars)>0){
                                        foreach($user_cars as $userCarsList){ ?>
                                         <option value="<?php echo $userCarsList->car_list_id; ?>" <?php if($service_reminder_details->service_vehicle_id == $userCarsList->car_list_id){ echo 'selected'; }?> ><?php echo $userCarsList->brand_name."-".$userCarsList->model_name."-".$userCarsList->variant_name."-".$userCarsList->car_model_year."-(".$userCarsList->car_reg_no.")"; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('Service Task'); ?>*</label>
                            </div>
                            <div class="col-sm-9">
                                <select name="services_id" id="services_id" class="bootstrap-select bootstrap-select-arrow form-control" data-live-search="true">
                                    <option value="">Select Your Service</option>
						            <?php foreach($service_category_items as $serviceCategoryList){ ?> 
						            <option value="<?php echo $serviceCategoryList->sc_item_id; ?>" <?php if($service_reminder_details->services_id == $serviceCategoryList->sc_item_id){ echo 'selected'; }?> ><?php echo $serviceCategoryList->service_item_name; ?></option>
						            <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('Completed On'); ?>*</label>
                            </div>
                            <div class="col-sm-9">
                                <input class="form-control datepicker" type="text" name="service_completed_on" id="service_completed_on" value="<?php echo $service_reminder_details->service_completed_on?date_from_mysql($service_reminder_details->service_completed_on):''?>" >
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('Meter Interval'); ?></label>
                            </div>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="service_meter_interval" id="service_meter_interval" value="<?php echo $service_reminder_details->service_meter_interval;?>">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required" style="margin-right: 3px"><?php _trans('Time interval'); ?></label>
                            </div>
                            <div class="col-sm-9">
                                <input id="service_time_interval" style="width:100px;float: left;" class="form-control" type="text" value="<?php echo $service_reminder_details->service_time_interval; ?>" name="service_time_interval">
                                <select id="service_time_interval_frequency" style="margin-left: 20px;width: 200px;float: left;height: 38px;" class="form-control" name="service_time_interval_frequency">
                                    <option value=""> Select frequency</option>
                                    <option value="days" <?php if($service_reminder_details->service_time_interval_frequency == 'days'){ echo 'selected' ; } ?> >day(s)</option>
                                    <option value="weeks" <?php if($service_reminder_details->service_time_interval_frequency == 'weeks'){ echo 'selected' ; } ?> >week(s)</option>
                                    <option value="months" <?php if($service_reminder_details->service_time_interval_frequency == 'months'){ echo 'selected' ; } ?> >month(s)</option>
                                    <option value="years" <?php if($service_reminder_details->service_time_interval_frequency == 'years'){ echo 'selected' ; } ?> >year(s)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('Meter Threshold'); ?></label>
                            </div>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="service_meter_threshold" id="service_meter_threshold" value="<?php echo $service_reminder_details->service_meter_threshold;?>">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required" style="margin-right: 3px"><?php _trans('Time Threshold'); ?></label>
                            </div>
                            <div class="col-sm-9">
                                <input id="service_time_threshold" style="width:100px;float: left;" class="form-control" type="text" value="<?php echo $service_reminder_details->service_time_threshold; ?>" name="service_time_threshold">
                                <select id="service_time_threshold_frequency" style="margin-left: 20px;width: 200px;float: left;height: 38px;" class="form-control" name="service_time_threshold_frequency">
                                    <option value=""> Select frequency</option>
                                    <option value="days" <?php if($service_reminder_details->service_time_threshold_frequency == 'days'){ echo 'selected' ; } ?> >day(s)</option>
                                    <option value="weeks" <?php if($service_reminder_details->service_time_threshold_frequency == 'weeks'){ echo 'selected' ; } ?> >week(s)</option>
                                    <option value="months" <?php if($service_reminder_details->service_time_threshold_frequency == 'months'){ echo 'selected' ; } ?> >month(s)</option>
                                    <option value="years" <?php if($service_reminder_details->service_time_threshold_frequency == 'years'){ echo 'selected' ; } ?> >year(s)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label"><?php _trans('Email Notifications'); ?></label>
                            </div>
                            <div class="col-sm-9 paddingTop7px">
                                <label class="switch">
    						        <input type="checkbox" class="checkbox" name="service_email_notification" id="service_email_notification" <?php if($service_reminder_details->service_email_notification == '1'){ echo "checked"; }?> value="<?php if($service_reminder_details->service_email_notification == '1'){ echo "1"; } else{ echo '0'; }?>" >
    						        <span class="slider round"></span>
    					        </label>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right paddingTop7px">
                                <label class="control-label"><?php _trans('Subscribed Users'); ?>*</label>
                            </div>
                            <div class="col-sm-9 paddingTop7px">
                                <select name="entity_id" id="entity_id" class="bootstrap-select bootstrap-select-arrow form-control" data-live-search="true">
                                    <option value="">Select users</option>
                                    <?php if(count($entity_list)>0){
                                        foreach($entity_list as $entityList){ ?>
                                         <option value="<?php echo $entityList->client_id; ?>" <?php if($service_reminder_details->entity_id == $entityList->client_id){ echo 'selected'; }?> ><?php echo $entityList->client_name; ?></option>
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

    $('#service_vehicle_id').change(function() {
        var service_vehicle_id = $('#service_vehicle_id').val();
        $.post("<?php echo site_url('clients/ajax/get_client_detail_by_vehicle_id'); ?>", {
            car_list_id: $('#service_vehicle_id').val(),
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
        window.location.href = "<?php echo site_url('reminder/service_reminder_index'); ?>";
    });

    $("#service_email_notification").click(function(){
        if($("#service_email_notification:checked").is(":checked")){
            $("#service_email_notification").val(1);
        }else{
            $("#service_email_notification").val(0);
        }
    });

    $(".btn_submit").click(function () {
        $(".hideSubmitButtons").hide();
        $.post('<?php echo site_url('reminder/ajax/save_service_reminder'); ?>', {
            service_remainder_id : $("#service_remainder_id").val(),
            service_vehicle_id : $('#service_vehicle_id').val(),
            services_id : $('#services_id').val(),
            service_completed_on : $("#service_completed_on").val().split("/").reverse().join("-"),
            service_meter_interval : $('#service_meter_interval').val(),
            service_time_interval : $('#service_time_interval').val(),
            service_time_interval_frequency : $('#service_time_interval_frequency').val(),
            service_meter_threshold : $('#service_meter_threshold').val(),
            service_time_threshold : $('#service_time_threshold').val(),
            service_time_threshold_frequency : $('#service_time_threshold_frequency').val(),
            service_email_notification : $('#service_email_notification').val(),
            entity_id : $('#entity_id').val(),
            btn_submit : $(this).val(),
            _mm_csrf: $('#_mm_csrf').val()
        }, function (data) {
            list = JSON.parse(data);
            if(list.success=='1'){
                notie.alert(1, 'Successfully Created', 2);
                if(list.btn_submit == '1'){
                    setTimeout(function(){
                        window.location = "<?php echo site_url('reminder/service_reminder'); ?>";
                    }, 100);
                }else{
                    setTimeout(function(){
                        window.location = "<?php echo site_url('reminder/service_reminder_index'); ?>";
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