<header class="page-content-header">
			<div class="container-fluid">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3><?php _trans('workshop_setup'); ?></h3>
						</div>
						<div class="tbl-cell pull-right">
							<a class="btn btn-sm btn-primary" href="<?php echo site_url('workshop_setup/form'); ?>">
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
        	<table class="display table table-bordered" cellspacing="0" width="100%">

            <thead>
            <tr>
                <th><?php _trans('workshop_name'); ?></th>
                <th><?php _trans('total_branch'); ?> </th>
                <th><?php _trans('contact_no'); ?></th>
                <th><?php _trans('options'); ?></th>
            </tr>
            </thead>

            <tbody>
            <?php if(count($workshop_setup)) { 
                            $i = 1;
                        foreach ($workshop_setup as $workshop) { 
                        if(count($workshop_setup) >= 4)
                        {
                            if(count($workshop_setup) == $i || count($workshop_setup) == $i+1)
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
                    <td><?php _htmlsc($workshop->workshop_name); ?></td>
                    <td class="text_align_center"><?php _htmlsc($this->mdl_workshop_branch->get_workshop_branch_count($workshop->workshop_id)); ?></td>
                    <td><?php _htmlsc($workshop->workshop_contact_no); ?></td>
                    <td>
                        <div class="options btn-group <?php echo $dropup; ?>">
                            <a class="btn btn-default btn-sm dropdown-toggle"
                               data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="optionTag dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('workshop_setup/form/' . $workshop->workshop_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('workshop_branch/index/' . $workshop->workshop_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('view_branch_list'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('workshop_setup/delete/' . $workshop->workshop_id); ?>"
                                       onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                                        <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php $i++; } } ?>
            </tbody>

        </table>
    </div>
    </div>
  </section>
</div>
