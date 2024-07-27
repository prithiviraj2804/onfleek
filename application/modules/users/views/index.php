
<header class="page-content-header">
			<div class="container-fluid">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3><?php _trans('lable681'); ?></h3>
						</div>
						<div class="tbl-cell pull-right">
							<a class="btn btn-sm btn-primary" href="<?php echo site_url('users/form'); ?>">
            <i class="fa fa-plus"></i> <?php _trans('lable40'); ?>
        </a>
						</div>
					</div>
				</div>
			</div>
</header>

<div id="content" class="table-content">

    <?php echo $this->layout->load_view('layout/alerts'); ?>

    <section class="card">
		<div class="card-block">
        <table class="display table table-bordered" cellspacing="0" width="100%">

            <thead>
            <tr>
                <th><?php _trans('lable50'); ?></th>
                <th><?php _trans('lable551'); ?></th>
                <th><?php _trans('lable673'); ?></th>
                <th><?php _trans('lable22'); ?></th>
            </tr>
            </thead>

            <tbody>

                <?php if(count($users) > 0) { 
                    $i = 1;
                    foreach ($users as $user) { 
                    if(count($users) >= 4)
                    {    
                        if(count($users) == $i || count($users) == $i+1)
                        {
                            $dropup = "dropup";
                        }
                        else
                        {
                            $dropup = "";
                        }
                    }    
                ?>
                <tr>
                    <td><?php _htmlsc($user->user_name); ?></td>
                    <td><?php echo $user_types[$user->user_type]; ?></td>
                    <td><?php echo $user->user_email; ?></td>
                    <td>
                        <div class="options btn-group btn-group-sm <?php echo $dropup; ?>">
                            <a class="btn btn-default dropdown-toggle"
                               data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                            </a>
                            <ul class="optionTag dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('users/form/' . $user->user_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                    </a>
                                </li>
                                <?php if ($user->user_id <> 1) { ?>
                                    <li>
                                        <a href="<?php echo site_url('users/delete/' . $user->user_id); ?>"
                                           onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                                            <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php $i++; } } ?>
            </tbody>

        </table>
    </div>
  </section>
</div>
