<form method="post">
<input type="hidden" name="_mm_csrf" value="<?= $this->security->get_csrf_hash() ?>">
<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php _trans('lable739'); ?></h3>
				</div>
			</div>
		</div>
	</div>
</header>
<div id="content">
    <?php if($this->session->userdata('user_type') == 3){  ?>
    <div class="row">
		<div class="col-xs-12">
			<a class="anchor anchor-back" href="<?php echo site_url('workshop_setup'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable740'); ?></span></a>
		</div>
	</div>
	<?php } ?>
        <div class="row">
            <div class="col-xs-12 col-md-12 col-md-offset-3 m-b-3">
				<?php $this->layout->load_view('layout/alerts'); ?>
				<div class="container_wide m-b-3">
                	<div class="col-sm-5 col-xs-12 border-right workshopProfile">
					<div class="overflowScrollForTable">
						<table>
							<tbody>
								<tr>
									<th><strong><?php _trans('lable683'); ?>: </strong></th>
									<td><?php echo $workshop_details->workshop_name?$workshop_details->workshop_name:'-'; ?></td>
								<tr>
								<tr>
									<th><strong><strong><?php _trans('lable726'); ?>: </strong></th>
									<td><?php echo $branch_details->display_board_name?$branch_details->display_board_name:'-'; ?></td>
								<tr>
								<tr>
									<th><strong><?php _trans('lable741'); ?> : </strong></th>
									<td><?php echo $branch_details->contact_person_name?$branch_details->contact_person_name:'-'; ?></td>
								<tr>
								<tr>
									<th><strong><?php _trans('lable742'); ?> : </strong></th>
									<td><?php echo $branch_details->branch_gstin?$branch_details->branch_gstin:'-'; ?></td>
								<tr>
								<tr>
									<th><strong><?php _trans('lable728'); ?>: </strong></th>
									<td><?php echo $branch_details->branch_contact_no?$branch_details->branch_contact_no:'-'; ?></td>
								<tr>
								<tr>
									<th><strong><?php _trans('lable41'); ?>: </strong></th>
									<td><?php echo $branch_details->branch_email_id?$branch_details->branch_email_id:'-'; ?></td>
								<tr>
								<tr>
									<th><strong><?php _trans('lable85'); ?> : </strong></th>
									<td><?php echo $branch_details->branch_street?$branch_details->branch_street:'-'; ?></td>
								<tr>
							</tbody>
						</table>
						</div>
					</div>
					<div class="col-sm-5 col-xs-12 border-right workshopProfile">
						<table>
							<tbody>
								<tr>
									<th><strong><?php _trans('lable88'); ?> : </strong></th>
									<td><?php echo $branch_details->city_name?$branch_details->city_name:'-'; ?></td>
								<tr>
								<tr>
									<th><strong><?php _trans('lable87'); ?>: </strong></th>
									<td><?php echo $branch_details->state_name?$branch_details->state_name:'-'; ?></td>
								<tr>
								<tr>
									<th><strong><?php _trans('lable86'); ?>: </strong></th>
									<td><?php echo $branch_details->name?$branch_details->name:'-'; ?></td>
								<tr>
								<tr>
									<th><strong><?php _trans('lable89'); ?>: </strong></th>
									<td><?php echo $branch_details->branch_pincode?$branch_details->branch_pincode:'-'; ?></td>
								<tr>
								<tr>
									<th><strong><?php _trans('lable743'); ?>: </strong></th>
									<td><?php echo $branch_details->branch_employee_count?$branch_details->branch_employee_count:'-'; ?></td>
								<tr>
								<tr>
									<th><strong><?php _trans('lable712'); ?>: </strong></th>
									<td><?php echo $branch_details->branch_since_from?$branch_details->branch_since_from:'-'; ?></td>
								<tr>
							</tbody>
						</table>
					</div>
                    <div class="col-sm-2 col-xs-12">
                    	<div>
                    		<?php if($workshop_details->workshop_logo){ ?>
							<img width="100%" height="100px" class="hidden-md-down" src="<?php echo base_url(); ?>uploads/workshop_logo/<?php echo $workshop_details->workshop_logo; ?>"  alt="<?php echo $company_details->workshop_name; ?>">
							<?php } ?>
                    	</div>
                    </div>
				</div>
            </div>
			<div class="col-xs-12">	
				<section class="tabs-section">
					<div class="tabs-section-nav">
						<div class="tbl">
							<ul class="nav" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" href="#tabs-2-tab-2" role="tab" data-toggle="tab" aria-selected="true">
										<span class="nav-link-in">
										<?php _trans('lable81'); ?>
										<span class="label label-pill label-success"><?php echo count($branch_bank_list) ?></span>
									</span>
									</a>
								</li>
							</ul>
						</div>
					</div><!--.tabs-section-nav-->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane fade in active show" id="tabs-2-tab-2">
							<div class="row">
								<div class="col-sm-12">
									<a style="margin-bottom: 15px; float: right" href="javascript:void(0)" data-toggle="modal" data-module-type="B" data-bank-id="" data-target="#addBank" class="btn btn-rounded add_bank"><?php _trans('lable92'); ?></a>
								</div>
							</div>
							<?php if(count($branch_bank_list) > 0){
	foreach ($branch_bank_list as $bank) {  ?>
		<div class="box-typical car-box-panel">
			<div class="row spacetop-10">
	<div class="col-xs-6 text-left">
		<a style="margin-bottom: 15px; float: right" href="javascript:void(0)" data-toggle="modal" data-module-type="B" data-target="#addBank" data-bank-id="<?php echo $bank->bank_id; ?>" class="page-header-edit page-header-edit-mobile add_bank">
		<i class="fa fa-edit"></i></a>
	</div>
	<div class="col-xs-6 text-right">
		<a href="javascript:void(0)" class="page-header-remove page-header-remove-mobile" onclick="remove_bank(<?php echo $bank->bank_id; ?>, '<?= $this->security->get_csrf_hash() ?>')"><i class="fa fa-trash"></i></a>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="car-details-box profile-box border-right">
		<div class="overflowScrollForTable">
			<table class="car-table-box">
				<tbody>
					<tr>
						<th><strong><?php _trans('lable129'); ?></strong></th><td><?php if($bank->module_type=='W'){ echo "Workshop"; }elseif($bank->module_type=='B'){ echo "Branch"; } ?></td>
					</tr>
					<tr>
						<th><strong><?php _trans('lable99'); ?></strong></th><td><?php echo $bank->bank_name; ?></td>
					</tr>
					<tr>
						<th><strong><?php _trans('lable95'); ?></strong></th><td><?php echo $bank->bank_branch; ?></td>
					</tr>
					<tr>
						<th><strong><?php _trans('lable100'); ?></strong></th><td><?php echo $bank->bank_ifsc_Code; ?></td>
					</tr>
				</tbody>
			</table>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="car-details-box profile-box">
		<div class="overflowScrollForTable">
			<table class="car-table-box">
				<tbody>
					<tr>
						<th><strong><?php _trans('lable97'); ?></strong></th><td><?php echo $bank->account_holder_name; ?></td>
					</tr>
					<tr>
						<th><strong><?php _trans('lable101'); ?></strong></th><td><?php if($bank->account_type == '1'){ echo "Current"; }elseif($bank->account_type == '2'){ echo "Saving"; }elseif($bank->account_type == '3'){ echo "Others"; } ?></td>
					</tr>
					<tr>
						<th><strong><?php _trans('lable98'); ?></strong></th><td><?php echo $bank->account_number; ?></td>
					</tr>
					<tr>
						<th><strong><?php _trans('lable69'); ?></strong></th><td><?php if($bank->is_default == 'Y'){ echo "Yes"; }elseif($bank->is_default == 'N'){ echo "No"; } ?></td>
					</tr>
				</tbody>
			</table>
			</div>
		</div>
	</div>
	</div>
</div>
<?php } }else{
            	echo "No data found...";
			} ?>
						
					</div><!--.tab-pane-->
					
				</div><!--.tab-content-->
			</section>
					
            </div>
        </div>

    </div>

</form>