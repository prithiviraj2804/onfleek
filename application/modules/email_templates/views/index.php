<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php _trans('email_templates'); ?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-sm btn-primary" href="<?php echo site_url('email_templates/form'); ?>">
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
            <div class="headerbar-item pull-right">
                <?php if(count($email_templates) > 0) { echo pager(site_url('email_templates/index'), 'mdl_email_templates'); } ?>
            </div>
            <div class="overflowScrollForTable">
                <table class="display table datatable table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="text_align_center"><?php _trans('lable496'); ?></th>
                            <th class="text_align_center"><?php _trans('lable104'); ?></th>
                            <th class="text_align_center"><?php _trans('lable22'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(count($email_templates)) { 
                            $i = 1;                            
                        foreach ($email_templates as $email_template) { 
                        if(count($email_templates) >= 4)
                        {
                            if(count($email_templates) == $i || count($email_templates) == $i+1)
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
                            <td class="text_align_center"><?php _htmlsc($email_template->email_template_title); ?></td>
                            <td class="text_align_center"><?php if($email_template->email_template_type == 'I'){ echo "Invoice";}else{ echo "Job Card"; } ?></td>
                            <td class="text_align_center">
                                <div class="options btn-group <?php echo $dropup; ?>">
                                    <a class="btn btn-default btn-sm dropdown-toggle"
                                    data-toggle="dropdown" href="#">
                                        <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                    </a>
                                    <ul class="optionTag dropdown-menu">
                                        <li>
                                            <a href="<?php echo site_url('email_templates/form/' . $email_template->email_template_id); ?>">
                                                <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" onclick="delete_record('email_templates',<?php echo $email_template->email_template_id; ?>, '<?= $this->security->get_csrf_hash() ?>')"> <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php $i++; } } else { echo '<tr><td colspan="3" class="text-center" > No data found </td></tr>'; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>