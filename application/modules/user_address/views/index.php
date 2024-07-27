<header class="page-content-header">
			<div class="container-fluid">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Address</h3>
						</div>
						<div class="tbl-cell pull-right">
							<a class="btn btn-sm btn-primary" href="<?php echo site_url('user_address/form'); ?>">
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
					<table id="user_address_list" class="display table table-bordered" cellspacing="0" width="100%">
						<thead>
						<tr>
			                <th>Zip Code</th>
			                <th>Area</th>
			                <th>Address</th>
			                <th>Tag Place</th>
			                <th>Default</th>
			                <th>Options</th>
			            </tr>
						</thead>
						
						<tbody>
						<?php foreach ($user_address_list as $user_address) { ?>
                <tr>
                    <td><?php _htmlsc($user_address->zip_code); ?></td>
                    <td><?php _htmlsc($user_address->area_name); ?></td>
                    <td><?php _htmlsc($user_address->full_address); ?></td>
                    <td><?php _htmlsc($user_address->address_type); ?></td>
                    <td><?php _htmlsc($user_address->is_default); ?></td>
                    <td>
                    	<div class="options btn-group">
                            <a class="btn btn-default btn-sm dropdown-toggle"
                               data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('user_address/form/' . $user_address->user_address_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('user_address/delete/' . $user_address->user_address_id); ?>"
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
			</section>

</div>
