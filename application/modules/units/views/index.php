<header class="page-content-header">
			<div class="container-fluid">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3><?php _trans('units'); ?></h3>
						</div>
						<div class="tbl-cell pull-right">
							<a class="btn btn-sm btn-primary" href="<?php echo site_url('units/form'); ?>">
            <i class="fa fa-plus"></i> <?php _trans('new'); ?>
        </a>
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
                <th><?php _trans('unit_name'); ?></th>
                <th><?php _trans('unit_name_plrl'); ?></th>
                <th><?php _trans('options'); ?></th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($units as $unit) { ?>
                <tr>
                    <td><?php _htmlsc($unit->unit_name); ?></td>
                    <td><?php _htmlsc($unit->unit_name_plrl); ?></td>
                    <td>
                        <div class="options btn-group">
                            <a class="btn btn-default btn-sm dropdown-toggle"
                               data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('units/form/' . $unit->unit_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('units/delete/' . $unit->unit_id); ?>"
                                       onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                                        <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php } ?>
            </tbody>

        </table>
        </div>
		</div>
    </div>
	</section>
</div>
