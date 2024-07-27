<header class="page-content-header">
			<div class="container-fluid">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Product Mapping</h3>
						</div>
						<div class="tbl-cell pull-right">
							<a class="btn btn-sm btn-primary" href="<?php echo site_url('products/product_mapping/form'); ?>">
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
                <th><?php _trans('product_name'); ?></th>
                <th><?php _trans('brand_name'); ?></th>
                <th><?php _trans('model_name'); ?></th>
                <th><?php _trans('variant_name'); ?></th>
              <?php /* * /?>  <th><?php _trans('product_description'); ?></th> <?php / * */?>
                <th class="text_align_right"><?php _trans('sale_price'); ?></th>
                <th class="text_align_center"><?php _trans('options'); ?></th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($products as $product) { ?>
                <tr>
                    <td><?php _htmlsc($product->product_name); ?></td>
                    <td><?php _htmlsc($product->brand_name); ?></td>
                    <td><?php _htmlsc($product->model_name); ?></td>
                    <td><?php _htmlsc($product->variant_name); ?></td>
                    <?php /* * /?><td><?php echo nl2br(htmlsc($product->product_description)); ?></td><?php / * */?>
                    <td class="amount text_align_right"><?php echo format_currency($product->sale_price); ?></td>
                    
                    <td class="text_align_center">
                        <div class="options btn-group">
                            <a class="btn btn-default btn-sm dropdown-toggle"
                               data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('products/product_mapping/form/' . $product->product_map_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('products/product_mapping/delete/' . $product->product_map_id); ?>"
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
	</section>
</div>
