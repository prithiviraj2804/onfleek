<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php _trans('lable986'); ?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-sm btn-primary" href="<?php echo site_url('tax_rates/form'); ?>">
                        <i class="fa fa-plus"></i> <?php _trans('lable40'); ?>
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
                <?php if(count($tax_rates) > 0) { echo pager(site_url('tax_rates/index'), 'mdl_tax_rates'); } ?>
            </div>
            <div class="overflowScrollForTable">
                <table class="display table datatable table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                        <th class="text_align_left"><?php _trans('lable980'); ?></th>
                        <th class="text_align_center"><?php _trans('lable981'); ?></th>
                        <th class="text_align_left"><?php _trans('lable982'); ?></th>
                        <th class="text_align_left"><?php _trans('lable983'); ?></th>
                        <th class="text_align_center"><?php _trans('lable19'); ?></th>
                        <th class="text_align_center"><?php _trans('lable22'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(count($tax_rates) > 0) { 
										
                        $i = 1;
                        foreach ($tax_rates as $tax_rate) { 
                            if(count($tax_rates) >= 4)
                            {    
                                if(count($tax_rates) == $i || count($tax_rates) == $i+1)
                                {
                                    $dropup = "dropup";
                                }
                                else
                                {
                                    $dropup = "";
                                }
                            }    
                            
                            ?>
                    		<?php $moduleidarray = explode(',', $tax_rate->module_id); ?>

                        <tr>

                        <td class="text_align_left"><?php _htmlsc($tax_rate->tax_rate_name); ?></td>
                        <td class="text_align_center"><?php _htmlsc(round($tax_rate->tax_rate_percent)); ?> %</td>
                        <td class="text_align_left"><?php echo implode(',', $tax_rate->module_name); ?></td>
                        <td class="text_align_left"><?php if($tax_rate->apply_for == 'A'){ echo "After Discount";}else{ echo "Before Discount"; } ?></td>
                        <td class="text_align_center"><?php if($tax_rate->status == 'A'){ echo "Active";}else{ echo "Inactive"; } ?></td>
                        <td class="text_align_center">
                                <div class="options btn-group <?php echo $dropup; ?>">
                                    <a class="btn btn-default btn-sm dropdown-toggle"
                                    data-toggle="dropdown" href="#">
                                        <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                    </a>
                                    <ul class="optionTag dropdown-menu">
                                        <li>
                                        <a href="<?php echo site_url('tax_rates/form/' . $tax_rate->tax_rate_id); ?>">
                                            <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                        </a>
                                        </li>
                                        <li>
                                        <a href="javascript:void(0)" onclick="delete_record('tax_rates',<?php echo $tax_rate->tax_rate_id; ?>, '<?= $this->security->get_csrf_hash() ?>')"> <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?></a>
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