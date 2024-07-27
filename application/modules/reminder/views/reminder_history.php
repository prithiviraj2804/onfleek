<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php _trans('lable579'); ?></h3>
                </div>
            </div>
        </div>
    </div>
</header>
<div id="content" class="table-content">
    <?php $this->layout->load_view('layout/alerts'); ?>
    <section class="card">
        <div class="card-block">
            <div class="headerbar-item pull-right">
                <?php echo pager(site_url('reminder/reminder_history'), 'mdl_reminder_history'); ?>
            </div>
            <table class="display table datatable table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="text_align_center"><?php _trans('lable548'); ?></th>
                        <th class="text_align_center"><?php _trans('lable556'); ?></th>
                        <th class="text_align_center"><?php _trans('lable555'); ?></th>
                        <th class="text_align_center"><?php _trans('lable554'); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php if(count($reminder_history_details) > 0 ){
                    foreach ($reminder_history_details as $reminderHistoryList) { ?>
                    <tr>
                        <td class="text_align_center">
                        <?php if($reminderHistoryList->reminder_type == "CON"){
                            echo "Contact";
                        }else if($reminderHistoryList->reminder_type == "CUS"){
                            echo "Custom";
                        }?>
                        </td>
                        <td class="text_align_center"><?php echo ($reminderHistoryList->current_schedule_date?date_from_mysql($reminderHistoryList->current_schedule_date):'-'); ?></td>
                        <td class="text_align_center"><?php echo ($reminderHistoryList->next_schedule_day?$reminderHistoryList->next_schedule_day:'-'); ?></td>
                        <td class="text_align_center"><?php echo ($reminderHistoryList->next_schedule_date?date_from_mysql($reminderHistoryList->next_schedule_date):'-'); ?></td>
                    </tr>
                    <?php } } else { echo '<tr><td colspan="4" class="text-center" > No data found </td></tr>'; } ?>
                </tbody>
            </table>
		</div>
	</section>
</div>
