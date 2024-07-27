<header class="page-content-header">
			<div class="container-fluid">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3><?php _trans('Workshop Branch Setup'); ?></h3>
						</div>
						<div class="tbl-cell pull-right">
							<a class="btn btn-sm btn-primary" href="<?php echo site_url('workshop_branch/form/'.$workshop_id); ?>">
            <i class="fa fa-plus"></i> <?php _trans('new'); ?>
        </a>
						</div>
					</div>
				</div>
			</div>
</header>
<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>
<div class="row spacetop-10">
		<div class="col-xs-12">
			<a class="anchor anchor-back" href="<?php echo site_url('workshop_setup'); ?>"><i class="fa fa-long-arrow-left"></i><span>Back to workshop</span></a>
		</div>
	</div>
   <section class="card">
		<div class="card-block">
        <div class="overflowScrollForTable">
        	<table class="display table table-bordered" cellspacing="0" width="100%">

            <thead>
            <tr>
                <th><?php _trans('Branch Name'); ?></th>
                <th><?php _trans('Contact No'); ?></th>
                <th><?php _trans('options'); ?></th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($workshop_branch as $workshop) { ?>
                <tr>
                    <td><?php _htmlsc($workshop->display_board_name); ?></td>
                    <td><?php _htmlsc($workshop->branch_contact_no); ?></td>
                    <td>
                        <div class="options btn-group">
                            <a class="btn btn-default btn-sm dropdown-toggle"
                               data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="optionTag dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('workshop_branch/form/' . $workshop->workshop_id."/".$workshop->w_branch_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                    </a>
                                </li>
                                <li>    
                                    <a href="<?php echo site_url('workshop_branch/delete/' . $workshop->w_branch_id); ?>"
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
