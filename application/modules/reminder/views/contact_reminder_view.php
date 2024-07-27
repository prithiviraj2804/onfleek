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
            <a class="anchor anchor-back" href="<?php echo site_url('reminder/contact_reminder_index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
        </div>
        <div class="col-xs-12 col-md-12 col-md-offset-3">
			<div class="container-wide usermanagement overflow_inherit">
                <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
				<section class="tabs-section" >
					<div class="tab-content">
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable551'); ?> :</label>
                            </div>
                            <div class="col-sm-9 paddingTop7px">
                                <?php foreach ($reference_type as $rtype) {
                                    if ($contact_reminder_details->refered_by_type == $rtype->refer_type_id) {
                                        echo $rtype->refer_name;
                                    } } ?>
                            </div>
                        </div> 
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable559'); ?> :</label>
                            </div>
                            <div class="col-sm-9 paddingTop7px">
                                <?php foreach ($refered_dtls as $refered) {
                                    if ($contact_reminder_details->refered_by_type == 2) {
                                        $id = $refered->employee_id;
                                        $name = $refered->employee_name.' '.($refered->mobile_no?"-".$refered->mobile_no:"");
                                    } elseif ($contact_reminder_details->refered_by_type == 1) {
                                        $id = $refered->client_id;
                                        $name = $refered->client_name.' '.($refered->client_contact_no?"-".$refered->client_contact_no:"");
                                    } elseif ($contact_reminder_details->refered_by_type == 3) {
                                        $id = $refered->supplier_id;
                                        $name = $refered->supplier_name.' '.($refered->supplier_contact_no?"-".$refered->supplier_contact_no:"");
                                    }
                                    if ($contact_reminder_details->refered_by_id == $id) {
                                        echo $name;
                                } } ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable558'); ?> :</label>
                            </div>
                            <div class="col-sm-9 paddingTop7px">
                            <?php if($contact_reminder_details->contact_reminder_next_due_date != "" && $contact_reminder_details->contact_reminder_next_due_date != "0000-00-00 00:00:00"){echo date("d-m-Y H:i:s", strtotime($contact_reminder_details->contact_reminder_next_due_date));} ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable19'); ?> :</label>
                            </div>
                            <div class="col-sm-9 paddingTop7px">
                                <?php if($contact_reminder_details->status == "O"){ echo "Open"; } ?>
                                <?php if($contact_reminder_details->status == "P"){ echo "Pending"; } ?>
                                <?php if($contact_reminder_details->status == "C"){ echo "Completed"; } ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable177'); ?> :</label>
                            </div>
                            <div class="col-sm-9 paddingTop7px">
                                <?php echo $contact_reminder_details->description; ?>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable292'); ?> :</label>
                            </div>
                            <div class="col-sm-9 paddingTop7px">
                                <?php foreach ($employee_list as $employeeList) {
                                    if ($contact_reminder_details->employee_id == $employeeList->employee_id) {
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
    						        <input type="checkbox" class="checkbox" name="contact_email_notification" id="contact_email_notification" <?php if($contact_reminder_details->contact_email_notification == '1'){ echo "checked"; }?> value="<?php if($contact_reminder_details->contact_email_notification == '1'){ echo "1"; } else{ echo '0'; }?>" disabled>
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
        window.location.href = "<?php echo site_url('reminder/contact_reminder_index'); ?>";
    });
});

</script>