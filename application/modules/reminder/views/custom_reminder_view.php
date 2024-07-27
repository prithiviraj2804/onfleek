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
            <a class="anchor anchor-back" href="<?php echo site_url('reminder/custom_reminder_index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
        </div>
        <div class="col-xs-12 col-md-12 col-md-offset-3">
			<div class="container-wide usermanagement overflow_inherit">
                <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
				<section class="tabs-section" >
					<div class="tab-content">
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable565'); ?> :</label>
                            </div>
                            <div class="col-sm-9 paddingTop7px">
                                <?php echo $custom_reminder_details->client_name.''.($customer->client_contact_no?"(".$customer->client_contact_no.")":""); ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable62'); ?> :</label>
                            </div>
                            <div class="col-sm-9 paddingTop7px">
                                <?php echo $custom_reminder_details->brand_name.", ".$custom_reminder_details->model_name." ".($custom_reminder_details->variant_name?", ".$custom_reminder_details->variant_name:"")."<span class='car_reg_no'>".($custom_reminder_details->car_reg_no?"(".$custom_reminder_details->car_reg_no.")":"")."</span>"; ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable570'); ?> :</label>
                            </div>
                            <div class="col-sm-9 paddingTop7px">
                                <?php echo $custom_reminder_details->last_update?date_from_mysql($custom_reminder_details->last_update):"-";?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable571'); ?> :</label>
                            </div>
                            <div class="col-sm-9 paddingTop7px">
                                <?php echo $custom_reminder_details->next_update_day?$custom_reminder_details->next_update_day:'';?>    
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable566'); ?> :</label>
                            </div>
                            <div class="col-sm-9 paddingTop7px">
                                <?php echo ($custom_reminder_details->next_update?date_from_mysql($custom_reminder_details->next_update):'-');?>   
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable177'); ?> :</label>
                            </div>
                            <div class="col-sm-9 paddingTop7px">
                                <?php echo $custom_reminder_details->description;?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable292'); ?> :</label>
                            </div>
                            <div class="col-sm-9 paddingTop7px">
                                <?php foreach ($employee_list as $employeeList) {
                                    if ($custom_reminder_details->employee_id == $employeeList->employee_id) {
                                        echo $employeeList->employee_name;
                                } } ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label"><?php _trans('lable557'); ?> :</label>
                            </div>
                            <div class="col-sm-9 paddingTop7px">
                                <label class="switch">
    						        <input type="checkbox" class="checkbox" name="email_notification" id="email_notification" <?php if($custom_reminder_details->email_notification == 'Y'){ echo "checked"; }?> value="<?php if($custom_reminder_details->email_notification == 'Y'){ echo "1"; } else{ echo 'N'; }?>" disabled>
    						        <span class="slider round"></span>
    					        </label>
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group clearfix">
                            <h3><?php echo "History"; ?></h3>
                            <table class="display table datatable table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text_align_center"><?php _trans('lable556'); ?></th>
                                        <th class="text_align_center"><?php _trans('lable555'); ?></th>
                                        <th class="text_align_center"><?php _trans('lable554'); ?></th>
                                        <th class="text_align_center"><?php _trans('lable177'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(count($reminder_history_details) > 0 ){
                                    foreach ($reminder_history_details as $reminderHistoryList) { ?>
                                    <tr>
                                        <td class="text_align_center"><?php echo ($reminderHistoryList->current_schedule_date?date_from_mysql($reminderHistoryList->current_schedule_date):'-'); ?></td>
                                        <td class="text_align_center"><?php echo ($reminderHistoryList->next_schedule_day?$reminderHistoryList->next_schedule_day:'-'); ?></td>
                                        <td class="text_align_center"><?php echo ($reminderHistoryList->next_schedule_date?date_from_mysql($reminderHistoryList->next_schedule_date):'-'); ?></td>
                                        <td class="text_align_center"><?php echo ($reminderHistoryList->description?$reminderHistoryList->description:'-'); ?></td>
                                    </tr>
                                    <?php } } else { echo '<tr><td colspan="4" class="text-center" > No data found </td></tr>'; } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 buttons text-center paddingTop40px">
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

    $("#btn_cancel").click(function () {
        window.location.href = "<?php echo site_url('reminder/custom_reminder_index'); ?>";
    });
});

</script>