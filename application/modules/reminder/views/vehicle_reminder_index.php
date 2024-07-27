<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php _trans('Vehicle Reminder'); ?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-sm btn-primary" href="<?php echo site_url('reminder/vehicle_reminder'); ?>"><i class="fa fa-plus"></i> <?php _trans('new'); ?></a>
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
                <?php echo pager(site_url('reminder/vehicle_reminder_index'), 'mdl_vehicle_reminder'); ?>
            </div>
        	<table class="display table datatable table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="text_align_center"><?php _trans('Vehicle'); ?></th>
                        <th class="text_align_center"><?php _trans('Vehicle Renewal Type'); ?></th>
                        <th class="text_align_center"><?php _trans('Due Date'); ?></th>
                        <th class="text_align_center"><?php _trans('options'); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php if(count($vehicle_reminder_details) > 0 ){
                    foreach ($vehicle_reminder_details as $vehicleReminderDetailsList) { ?>
                    <tr>
                        <td class="text_align_center"><?php if($vehicleReminderDetailsList->reminder_vehicle_id){
                            echo $this->mdl_user_cars->getvehicleDetails($vehicleReminderDetailsList->reminder_vehicle_id);
                        } ?></td>
                        <td class="text_align_center"> <?php if($vehicleReminderDetailsList->vehicle_renewal_type_id == 1){
                                    echo 'Certification';
                            }else{
                                echo 'License';
                            } ?></td>
                        <td class="text_align_center"><?php _htmlsc($vehicleReminderDetailsList->vehicle_reminder_next_due_date?date_from_mysql($vehicleReminderDetailsList->vehicle_reminder_next_due_date):''); ?></td>
                        <td class="text_align_center">
                            <div class="options btn-group">
                                <a class="btn btn-default btn-sm dropdown-toggle"
                                data-toggle="dropdown" href="#">
                                    <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo site_url('reminder/vehicle_reminder/'.$vehicleReminderDetailsList->vehicle_reminder_id); ?>">
                                            <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)"
                                        onclick="delete_record('vehicle_reminder',<?php echo $vehicleReminderDetailsList->vehicle_reminder_id ?>,'<?= $this->security->get_csrf_hash(); ?>');">
                                            <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php } } else { echo '<tr><td colspan="4" class="text-center" > No data found </td></tr>'; } ?>
                </tbody>
            </table>
		</div>
	</section>
</div>