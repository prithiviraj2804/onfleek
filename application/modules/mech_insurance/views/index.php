<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3>Mechanic Insurance</h3>
				</div>
				<div class="tbl-cell pull-right">
					<a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_insurance/form'); ?>">
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
				<table id="mechanic_service_category" class="display table table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Car</th>
							<th>RC Book</th>
							<th>Insurance</th>
							<th>Option</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($mech_insurances as $mech_insurance) { ?>
						<tr>
							<td><?php  _htmlsc($mech_insurance->car_id); ?></td>
							<td><?php if($mech_insurance->rc_book_url){ ?>
									<a href="<?php echo base_url().'uploads/insurance/'.$mech_insurance->rc_book_url; ?>" target="_blank">RC Book</a>
								<?php }else{ ?> 
									<a href="javascript:void(0)">RC Book</a>
								<?php } ?>
							</td>
							<td>
								<?php if($mech_insurance->insurance_url){ ?>
									<a href="<?php echo base_url().'uploads/insurance/'.$mech_insurance->insurance_url; ?>" target="_blank">Insurance Book</a>
								<?php }else{ ?> 
									<a href="javascript:void(0)">Insurance Book</a>
								<?php } ?>
							</td>
							<td>
								<div class="options btn-group">
									<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
										<i class="fa fa-cog"></i> <?php _trans('options'); ?>
									</a>
									<ul class="dropdown-menu">
										<li>
											<a href="<?php echo site_url('mech_insurance/form/' . $mech_insurance->insurance_id); ?>">
												<i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
											</a>
										</li>
										<li>
											<a href="<?php echo site_url('mech_insurance/delete/' . $mech_insurance->insurance_id); ?>" onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
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