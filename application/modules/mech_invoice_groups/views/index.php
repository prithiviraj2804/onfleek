<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php _trans('lable815'); ?><small class="text-muted">( <?php echo count($invoice_groups); ?> )</small></h3>
				</div>
				<div class="tbl-cell tbl-cell-action">
					<?php if (!$creation_check->job_card_status || !$creation_check->quote_status || !$creation_check->invoice_status) {
    ?>
						<a href="<?php echo site_url('mech_invoice_groups/form'); ?>" id="generate_invoice_group" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> <?php _trans('lable40'); ?></a>
					<?php
} ?>
				</div>
			</div>
		</div>	
	</div>
</header>
<div id="content" class="table-content">
    <?php $this->layout->load_view('layout/alerts'); ?>
    <section class="card">
		<div class="card-block">
            <div class="overflowScrollForTable">
                <table class="display table table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php _trans('lable781'); ?></th>
                            <th><?php _trans('lable50'); ?></th>
                            <th><?php _trans('lable730'); ?></th>
                            <th><?php _trans('lable731'); ?></th>
                            <th><?php _trans('lable19'); ?></th>
                            <th><?php _trans('lable22'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($invoice_groups as $invoice_group) { ?>
                        <tr>
                            <td><?php _htmlsc($i); ?></td>
                            <td><?php _htmlsc($invoice_group->invoice_group_name); ?></td>
                            <td><?php _htmlsc($invoice_group->invoice_group_next_id); ?></td>
                            <td><?php _htmlsc($invoice_group->invoice_group_left_pad); ?></td>
                            <td>
                                <?php if ($invoice_group->status == 'A') {
                                    echo 'Active';
                                } elseif ($invoice_group->status == 'D') {
                                    echo 'Deactive';
                                } elseif ($invoice_group->status == 'C') {
                                    echo 'Completed';
                                } ?>
                            </td>
                            <td>
                                <div class="options btn-group">
                                    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                                        <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php if ($invoice_group->status == 'A') { ?>
                                        <li>
                                            <a onclick="update_status('mech_invoice_groups','C',<?php echo $invoice_group->invoice_group_id; ?>, '<?= $this->security->get_csrf_hash() ?>');" href="javascript:void(0)">
                                                <i class="fa fa-edit fa-margin"></i> <?php _trans('lable732'); ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a onclick="update_status('mech_invoice_groups','D',<?php echo $invoice_group->invoice_group_id; ?>, '<?= $this->security->get_csrf_hash() ?>');" href="javascript:void(0)">
                                                <i class="fa fa-edit fa-margin"></i> <?php _trans('lable733'); ?>
                                            </a>
                                        </li>
                                        <?php } elseif($invoice_group->status == 'D' && $get_count->{$invoice_group->module_type} < 2){ ?>
                                        <li>
                                            <a onclick="update_status('mech_invoice_groups','A',<?php echo $invoice_group->invoice_group_id; ?>, '<?= $this->security->get_csrf_hash() ?>');" href="javascript:void(0)">>
                                                <i class="fa fa-edit fa-margin"></i> <?php _trans('lable669'); ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a onclick="update_status('mech_invoice_groups','C',<?php echo $invoice_group->invoice_group_id; ?>, '<?= $this->security->get_csrf_hash() ?>');" href="javascript:void(0)">
                                                <i class="fa fa-edit fa-margin"></i> <?php _trans('lable732'); ?>
                                            </a>
                                        </li>	
                                        <?php } ?>
                                        <li>
                                            <a href="<?php echo site_url('mech_invoice_groups/form/'.$invoice_group->invoice_group_id); ?>">
                                                <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url('mech_invoice_groups/delete/'.$invoice_group->invoice_group_id); ?>" onclick="return confirm('<?php _trans('lable123'); ?>');">
                                                <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php ++$i; } ?>
                    </tbody>
                </table>
            <div class="overflowScrollForTable">
		</div>
	</section>
</div>