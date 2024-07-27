<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
	        <div class="tbl-row">
			    <div class="tbl-cell">
			        <h3>Mechanic Area List</h3>
				</div>
				<div class="tbl-cell pull-right">
			        <a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_area_list/form'); ?>">
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
			<table id="brand_model_variants" class="display table table-bordered" cellspacing="0" width="100%">
		        <thead>
				    <tr>
                        <th>Area Name</th>
                        <th>Zipcode</th>
                        <th>Service Available</th>
                        <th></th>
                    </tr>
				</thead>
                <tbody>
				<?php if(count($mech_area_list)>0){
                foreach ($mech_area_list as $mech_area) { ?>
                    <tr>
                        <td><?php _htmlsc($mech_area->area_name); ?></td>
                        <td><?php _htmlsc($mech_area->area_pincode); ?></td>
                        <td><?php if($mech_area->is_service == 1){ echo "Yes"; }else{ echo "No"; } ?></td>
                        <td>
                            <div class="options btn-group">
                                <a class="btn btn-default btn-sm dropdown-toggle"
                                data-toggle="dropdown" href="#">
                                    <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo site_url('mech_area_list/form/' . $mech_area->area_id); ?>">
                                            <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('mech_area_list/delete/' . $mech_area->area_id); ?>"
                                        onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                                            <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <?php } } else {  ?>
                    <tr>
                        <td colspan="4">No data found</td>
                    </tr>
                <?php }?>
				</tbody>
			</table>
        </div>
	</section>
</div>