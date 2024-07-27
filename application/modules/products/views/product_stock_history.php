<header class="page-content-header">
			<div class="container-fluid">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3><?php _trans('lable650'); ?></h3>
						</div>
						<div class="tbl-cell pull-right">
							<a class="btn btn-sm btn-primary add_reduce_stock" data-page-from="history" href="javascript:void(0)" data-product-id="<?php echo $product->product_id; ?>" data-action-type="add_stock">
                                <i class="fa fa-plus"></i> <?php _trans('lable214'); ?>
                            </a>
                            <a class="btn btn-sm btn-primary add_reduce_stock" data-page-from="history" href="javascrip:void(0)" data-product-id="<?php echo $product->product_id; ?>" data-action-type="reduce_stock">
                                <i class="fa fa-minus"></i> <?php _trans('lable215'); ?>
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
            <h3>
                <?php _htmlsc($product->product_name)?>
            </h3>
            <span>
                (<?php _trans('lable651'); ?>: <?php _htmlsc($product->balance_stock)?> )
                
            </span>
        <table class="display table table-bordered" cellspacing="0" width="100%">

            <thead>
            <tr>
                <th><?php _trans('lable652'); ?></th>
                <th><?php _trans('lable482'); ?></th>
                <th><?php _trans('lable653'); ?></th>
                <th><?php _trans('lable643'); ?></th>
                <th><?php _trans('lable399'); ?></th>
                <th><?php _trans('lable477'); ?></th>
                <!-- <th><?php //_trans('options'); ?></th> -->
            </tr>
            </thead>

            <tbody>
            <?php foreach ($inventory_list as $inventory) {
                $stock_type = $inventory->stock_type;
                if($stock_type == '1'){
                    $stock_type_name = 'Invoice';
                }else if($stock_type == '2'){
                    $stock_type_name = 'Purchase';
                }else if($stock_type == '3'){
                    $stock_type_name = 'Opening stock';
                }else if($stock_type == '4'){
                    $stock_type_name = 'Sample stock';
                }else if($stock_type == '5'){
                    $stock_type_name = 'Damaged stock';
                }
             ?>
                <tr>
                    <td><?php _htmlsc(date_from_mysql($inventory->stock_date))?></td>
                    <td><?php _htmlsc($stock_type_name); ?></td>
                    <td><?php _htmlsc($inventory->action_type == '1' ? 'Add stock' : 'Reduce stock' ); ?></td>
                    <td><?php _htmlsc($inventory->quantity); ?></td>
                    <td><?php echo format_money($inventory->price,$this->session->userdata('default_currency_digit')); ?></td>
                    <td><?php _htmlsc($inventory->description); ?></td>
                    <?php /* * /?><td>
                        <div class="options btn-group">
                            <a class="btn btn-default btn-sm dropdown-toggle"
                               data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('products/form/' . $product->product_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('products/delete/' . $product->product_id); ?>"
                                       onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                                        <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td><?php / * */?>
                </tr>
            <?php } ?>
            </tbody>

        </table>
    </div>
	</section>
</div>
