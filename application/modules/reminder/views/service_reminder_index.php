<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php _trans('lable297'); ?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-sm btn-primary" href="<?php echo site_url('reminder/service_reminder'); ?>"><i class="fa fa-plus"></i> <?php _trans('lable40'); ?></a>
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
                <?php echo pager(site_url('reminder/service_reminder_index'), 'mdl_service_reminder'); ?>
            </div>
        	<table class="display table datatable table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="text_align_center"><?php _trans('lable62'); ?></th>
                        <th class="text_align_center"><?php _trans('lable580'); ?></th>
                        <?php // <th class="text_align_center">Due Date</th> ?>
                        <th class="text_align_center"><?php _trans('lable22'); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php if(count($service_reminder_details) > 0 ){
                    foreach ($service_reminder_details as $serviceReminderDetailsList) { ?>
                    <tr>
                    <td class="text_align_center"><?php if($serviceReminderDetailsList->service_vehicle_id){
                            echo $this->mdl_user_cars->getvehicleDetails($serviceReminderDetailsList->service_vehicle_id);
                        } ?></td>
                        <td class="text_align_center"> 
                            <?php if($serviceReminderDetailsList->services_id){
                                    echo $this->mdl_mechanic_service_category_items->getServiceCategoryNameById($serviceReminderDetailsList->services_id);
                            }?>
                        </td>
                        <!-- <td class="text_align_center"></td> -->
                        <td class="text_align_center">
                            <div class="options btn-group">
                                <a class="btn btn-default btn-sm dropdown-toggle"
                                data-toggle="dropdown" href="#">
                                    <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo site_url('reminder/service_reminder/'.$serviceReminderDetailsList->service_remainder_id); ?>">
                                            <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)"
                                        onclick="delete_record('service_reminder',<?php echo $serviceReminderDetailsList->service_remainder_id ?>,'<?= $this->security->get_csrf_hash(); ?>');">
                                            <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?>
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
