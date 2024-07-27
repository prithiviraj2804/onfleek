<header class="page-content-header">
			<div class="container-fluid">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Mechanic Car Brand Models</h3>
						</div>
						<div class="tbl-cell pull-right">
							<a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_car_brand_models_details/form'); ?>">
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
					<table id="mechanic_service_category" class="display table table-bordered" cellspacing="0" width="100%">
						<thead>
						<tr>
			                <th>Brand Name</th>
			                <th>Model Name</th>
			                <th>Model Image</th>
			                <th></th>
			            </tr>
						</thead>
						
						<tbody>
						<?php foreach ($mech_car_brand_models_details as $mech_car_brand_model) { ?>
                <tr>
                    <td><?php _htmlsc($mech_car_brand_model->brand_name); ?></td>
                    <td><?php _htmlsc($mech_car_brand_model->model_name); ?></td>
                    <td><img src="<?php echo base_url();?>uploads/car_images/models/<?php _htmlsc($mech_car_brand_model->model_image); ?>" width="100" height="100"></td>
                    <td>
                    	<div class="options btn-group">
                            <a class="btn btn-default btn-sm dropdown-toggle"
                               data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo site_url('mech_car_brand_models_details/form/' . $mech_car_brand_model->model_id); ?>">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('mech_car_brand_models_details/delete/' . $mech_car_brand_model->model_id); ?>"
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
