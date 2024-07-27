<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php _trans('payment_methods'); ?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-sm btn-primary" href="<?php echo site_url('payment_methods/form'); ?>"><i class="fa fa-plus"></i> <?php _trans('new'); ?></a>
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
                <table class="display table datatable table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="text_align_center"><?php _trans('payment_method'); ?></th>
                            <th class="text_align_center"><?php _trans('options'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($payment_methods) > 0){
                            foreach ($payment_methods as $payment_method) { ?>
                        <tr>
                            <td align="center"><?php _htmlsc($payment_method->payment_method_name); ?></td>
                            <td align="center">
                                <div class="options btn-group">
                                    <a class="btn btn-default btn-sm dropdown-toggle"
                                    data-toggle="dropdown" href="#">
                                        <i class="fa fa-cog"></i>
                                        <?php _trans('options'); ?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="<?php echo site_url('payment_methods/form/'.$payment_method->payment_method_id); ?>">
                                                <i class="fa fa-edit fa-margin"></i>
                                                <?php _trans('edit'); ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" onclick="delete_record('payment_methods',<?php echo $payment_method->payment_method_id; ?>, '<?= $this->security->get_csrf_hash() ?>')"> <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php } } else { echo '<tr><td colspan="2" class="text-center" > No data found </td></tr>'; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </section>
</div>