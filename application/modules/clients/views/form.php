<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php echo _trans($breadcrumb); ?>  <?php echo ($this->mdl_clients->form_value('client_no', true)?" (".$this->mdl_clients->form_value('client_no', true).") ":''); ?></h3>
				</div>
				<div class="tbl-cell pull-right">
					<a class="btn btn-sm btn-primary" href="<?php echo site_url('clients/form'); ?>">
            			<i class="fa fa-plus"></i> <?php _trans('lable40'); ?>
        			</a>
				</div>
			</div>
		</div>
	</div>
</header>
<?php if (isset($active_tab)) {
    if ($active_tab == 1) {
        $one_tab_active = 'active show in';
        $two_tab_active = '';
        $three_tab_active = '';
		$four_tab_active = '';
		$five_tab_active = '';
        $one_area_selected = true;
        $two_area_selected = false;
        $three_area_selected = false;
		$four_area_selected = false;
        $five_area_selected = false;
    } elseif ($active_tab == 2) {
        $one_tab_active = '';
        $two_tab_active = 'active show in';
        $three_tab_active = '';
		$four_tab_active = '';
		$five_tab_active = '';
        $one_area_selected = false;
        $two_area_selected = true;
        $three_area_selected = false;
		$four_area_selected = false;
        $five_area_selected = false;
    } elseif ($active_tab == 3) {
        $one_tab_active = '';
        $two_tab_active = '';
        $three_tab_active = 'active show in';
		$four_tab_active = '';
		$five_tab_active = '';
        $one_area_selected = false;
        $two_area_selected = false;
        $three_area_selected = true;
		$four_area_selected = false;
        $five_area_selected = false;
    }
	elseif ($active_tab == 4) {
        $one_tab_active = '';
        $two_tab_active = '';
        $three_tab_active = '';
		$four_tab_active = 'active show in';
		$five_tab_active = '';
        $one_area_selected = false;
        $two_area_selected = false;
        $three_area_selected = false;
		$four_area_selected = true;
        $five_area_selected = false;
    }elseif ($active_tab == 5) {
        $one_tab_active = '';
        $two_tab_active = '';
        $three_tab_active = '';
		$four_tab_active = '';
		$five_tab_active = 'active show in';
        $one_area_selected = false;
        $two_area_selected = false;
        $three_area_selected = false;
		$four_area_selected = false;
        $five_area_selected = true;
    }
} else {
    $one_tab_active = 'active show in';
    $two_tab_active = '';
    $three_tab_active = '';
    $one_area_selected = true;
    $two_area_selected = false;
    $three_area_selected = false;
	$four_area_selected = false;
	$five_area_selected = false;
}
?>
<div id="content" class="usermanagement">
	<div class="row">
		<div id="gif" class="gifload">
			<div class="gifcenter">
			  <center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
		    </div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 top-15">
			<a class="anchor anchor-back" onclick="goBack()" href="<?php echo site_url('clients/index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
		</div>
	</div>
    <div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 ipadview">
			<div class="nav nav-tabs">
				<div class="tbl">
					<ul class="nav" role="tablist">
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $one_tab_active; ?>" href="#tabs-2-tab-1" role="tab" data-toggle="tab" aria-selected="<?php echo $one_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable60'); ?></span>
							</a>
						</li>
						<?php if ($this->mdl_clients->form_value('client_id', true)) { ?>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $two_tab_active; ?>" href="#tabs-2-tab-2" role="tab" data-toggle="tab" aria-selected="<?php echo $two_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable61'); ?></span>
								<span class="rightCountipad label label-pill label-success"><?php echo count($user_address_list); ?></span>
							</a>
						</li>
						<?php if($this->session->userdata('plan_type') != 3){ ?>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $three_tab_active; ?>" href="#tabs-2-tab-3" role="tab" data-toggle="tab" aria-selected="<?php echo $three_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable62'); ?></span>
								<span class="rightCountipad label label-pill label-success"><?php echo count($cars_list); ?></span>
							</a>
						</li>
						<?php } ?>

						<?php if($this->session->userdata('plan_type') == 3){ ?>
						
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $four_tab_active; ?>" href="#tabs-2-tab-4" role="tab" data-toggle="tab" aria-selected="<?php echo $four_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable853'); ?></span>
								<span class="rightCountipad label label-pill label-success"><?php echo count($recommended_products); ?></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $five_tab_active; ?>" href="#tabs-2-tab-5" role="tab" data-toggle="tab" aria-selected="<?php echo $five_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable395'); ?></span>
								<span class="rightCountipad label label-pill label-success"><?php echo count($recommended_services); ?></span>
							</a>
						</li>
						<?php } } else { ?>
						<li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable61'); ?></span>
								<span class="rightCountipad label label-pill label-success"><?php echo count($user_address_list); ?></span>
							</a>
						</li>
						<?php if($this->session->userdata('plan_type') != 3){ ?>
						<li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable62'); ?></span>
								<span class="rightCountipad label label-pill label-success"><?php echo count($cars_list); ?></span>
							</a>
						</li>
						<?php } ?>

						<?php if($this->session->userdata('plan_type') == 3){ ?>
						<li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable853'); ?></span>
								<span class="rightCountipad label label-pill label-success"><?php echo count($recommended_products); ?></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable395'); ?></span>
								<span class="rightCountipad label label-pill label-success"><?php echo count($recommended_services); ?></span>
							</a>
						</li>
						<?php } } ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-xs-12 smallPortion desktopview">
			<div class="tabs-section-nav">
				<div class="tbl">
					<ul class="nav" role="tablist">
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $one_tab_active; ?>" href="#tabs-2-tab-1" role="tab" data-toggle="tab" aria-selected="<?php echo $one_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable60'); ?></span>
							</a>
						</li>
						<?php if ($this->mdl_clients->form_value('client_id', true)) { ?>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $two_tab_active; ?>" href="#tabs-2-tab-2" role="tab" data-toggle="tab" aria-selected="<?php echo $two_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable61'); ?></span>
								<span class="rightCountSpan label label-pill label-success"><?php echo count($user_address_list); ?></span>
							</a>
						</li>
						<?php if($this->session->userdata('plan_type') != 3){ ?>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $three_tab_active; ?>" href="#tabs-2-tab-3" role="tab" data-toggle="tab" aria-selected="<?php echo $three_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable62'); ?></span>
								<span class="rightCountSpan label label-pill label-success"><?php echo count($cars_list); ?></span>
							</a>
						</li>
						<?php } ?>
						<?php if($this->session->userdata('plan_type') == 3){ ?>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $four_tab_active; ?>" href="#tabs-2-tab-4" role="tab" data-toggle="tab" aria-selected="<?php echo $four_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable853'); ?></span>
								<span class="rightCountSpan label label-pill label-success"><?php echo count($recommended_products); ?></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $five_tab_active; ?>" href="#tabs-2-tab-5" role="tab" data-toggle="tab" aria-selected="<?php echo $five_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable395'); ?></span>
								<span class="rightCountSpan label label-pill label-success"><?php echo count($recommended_services); ?></span>
							</a>
						</li>
						<?php } } else { ?>
						<li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable61'); ?></span>
								<span class="rightCountSpan label label-pill label-success"><?php echo count($user_address_list); ?></span>
							</a>
						</li>
						<?php if($this->session->userdata('plan_type') != 3){ ?>
						<li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable62'); ?></span>
								<span class="rightCountSpan label label-pill label-success"><?php echo count($cars_list); ?></span>
							</a>
						</li>
						<?php } ?>
						<?php if($this->session->userdata('plan_type') == 3){ ?>
						<li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable853'); ?></span>
								<span class="rightCountSpan label label-pill label-success"><?php echo count($recommended_products); ?></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable395'); ?></span>
								<span class="rightCountSpan label label-pill label-success"><?php echo count($recommended_services); ?></span>
							</a>
						</li>
						<?php } } ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 paddingTopLeft0px">
            	<input type="hidden" name="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>"autocomplete="off">
				<section class="tabs-section" >
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane fade <?php echo $one_tab_active; ?>" id="tabs-2-tab-1">
							<input class="hidden" name="is_update" type="hidden" autocomplete="off"
							<?php if ($this->mdl_clients->form_value('is_update')) { echo 'value="1"'; } else { echo 'value="0"'; }?>>
							<input type="hidden" name="client_no" id="client_no" value="<?php echo $this->mdl_clients->form_value('client_no', true); ?>" autocomplete="off"/>
							<input type="hidden" id="invoice_group_id" name="invoice_group_id" value="<?php echo $invoice_group_number->invoice_group_id;?>" >
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable50'); ?>*</label>
								</div>
								<div class="col-sm-9">
								<input type="hidden" name="client_id" id="client_id" class="form-control" value="<?php echo $this->mdl_clients->form_value('client_id', true); ?>"autocomplete="off">
									<input class="form-control" type="text" name="client_name" id="client_name" value="<?php echo $this->mdl_clients->form_value('client_name', true); ?>" autocomplete="off">
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
									<label class="control-label string required"><?php _trans('lable95'); ?>*</label>
								</div>
								<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
									<select id="branch_id" name="branch_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" >
										<?php if(count($branch_list) != 1){ ?>
											<option value=""><?php _trans('lable51'); ?></option>
										<?php } ?>
										<?php foreach ($branch_list as $branchList) {?>
										<option value="<?php echo $branchList->w_branch_id; ?>" <?php if($this->mdl_clients->form_value('branch_id', true) == $branchList->w_branch_id){echo "selected";}?> > <?php echo $branchList->display_board_name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							
							<div class="form-group clearfix">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
									<label class="control-label string required"><?php _trans('lable208'); ?>*</label>
								</div>
								<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
									<select id="customer_category_id" name="customer_category_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" >
										<?php if(count($customercategory)>0){ ?>
											<option value=""><?php _trans('lable851'); ?></option>
										<?php } ?>
										<?php foreach ($customercategory as $custcategory) {?>
											<option value="<?php echo $custcategory->customer_category_id; ?>" <?php if($this->mdl_clients->form_value('customer_category_id', true) == $custcategory->customer_category_id){echo "selected";}?> > <?php echo $custcategory->customer_category_name; ?></option>
										<?php } ?>
									</select>
									<div class="col-lg-12 paddingLeft0px paddingTop5px">
										<a href="javascript:void(0)" data-toggle="modal" data-model-from="customer" data-target="#addNewCar" class="float_left fontSize_85rem add_customer_category">
											+ <?php echo trans('lable849'); ?>
										</a>
									</div>
								</div>
							</div>

							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable42'); ?>. *</label>
								</div>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="client_contact_no" id="client_contact_no" value="<?php echo $this->mdl_clients->form_value('client_contact_no', true); ?>" onkeyup="checkphonenoexist();" autocomplete="off">
									<div id="showErrorMsg" class="error"></div>
								</div>
							</div>

							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required" style="margin-right: 3px"><?php _trans('lable41'); ?></label>
								</div>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="client_email_id" id="client_email_id" onblur="chkEmail(this);" value="<?php echo $this->mdl_clients->form_value('client_email_id', true); ?>" autocomplete="off">
									<span class="error emailIdErrorr"></span>
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required" style="margin-right: 3px"><?php _trans('lable760'); ?></label>
								</div>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="client_gstin" id="client_gstin" value="<?php echo $this->mdl_clients->form_value('client_gstin', true); ?>" autocomplete="off">
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label"><?php _trans('lable52'); ?></label>
								</div>
								<div class="col-sm-9">
									<select name="refered_by_type" id="refered_by_type" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
										<option value=""><?php _trans('lable53'); ?></option>
										<?php foreach ($reference_type as $rtype) {
										if ($this->mdl_clients->form_value('refered_by_type', true) == $rtype->refer_type_id) {
            								$selected = 'selected="selected"';
        								} else {
            								$selected = '';
        								} ?>
										<option value="<?php echo $rtype->refer_type_id; ?>" <?php echo $selected; ?>><?php echo $rtype->refer_name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label"><?php _trans('lable54'); ?></label>
								</div>
								<div class="col-sm-9">
									<select name="refered_by_id" id="refered_by_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
										<option value=""><?php _trans('lable55'); ?></option>
										<?php foreach ($refered_dtls as $refered) {
										if ($this->mdl_clients->form_value('refered_by_type', true) == 2) {
            								$emp_id = $refered->employee_id;
            								$name = $refered->employee_name.' - '.$refered->mobile_no;
										} elseif ($this->mdl_clients->form_value('refered_by_type', true) == 1) {
            								$emp_id = $refered->client_id;
            								$name = $refered->client_name.' - '.$refered->client_contact_no;
        								}
        								if ($this->mdl_clients->form_value('refered_by_id', true) == $emp_id) {
            								$selected = 'selected="selected"';
        								} else {
            								$selected = '';
        								} ?>
										<option value="<?php echo $emp_id; ?>" <?php echo $selected; ?>><?php echo $name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="buttons text-center">
								<button value="1" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
									<i class="fa fa-check"></i> <?php _trans('lable56'); ?>
								</button>
								<button value="2" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
									<i class="fa fa-check"></i> <?php _trans('lable57'); ?>
								</button>
								<button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default">
									<i class="fa fa-times"></i> <?php _trans('lable58'); ?>
								</button>
							</div>	
						</div>
						<div role="tabpanel" class="tab-pane fade <?php echo $two_tab_active; ?>" id="tabs-2-tab-2">
							<section class="card">
								<div class="card-block">
								<?php if ($this->mdl_clients->form_value('client_id', true)) {?>
									<div class="row">
										<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
											<a style="margin-bottom: 15px; float: right" href="javascript:void(0)" data-model-from="customer" data-model-type="C" data-toggle="modal" data-target="#addAddress" data-customer-id="<?php echo $this->mdl_clients->form_value('client_id', true); ?>" class="add_address btn btn-rounded">
                    						<?php _trans('lable45'); ?>
         									</a>
         								</div>
									</div>
									<?php } ?>
									<div class="overflowScrollForTable">
										<table id="user_address_list" class="display table table-bordered" cellspacing="0" width="100%">
											<thead>
											<tr>
												<th><?php _trans('lable63'); ?></th>
												<th><?php _trans('lable61'); ?></th>
												<th class="text_align_center"><?php _trans('lable64'); ?></th>
												<th class="text_align_center"> <?php _trans('lable22'); ?></th>
											</tr>
											</thead>
											<tbody>
											<?php if(count($user_address_list) > 0){
												$i = 1;
												foreach ($user_address_list as $user_address) { 
													if(count($user_address_list) >= 4)
													{    	
													if(count($user_address_list) == 1 || count($user_address_list) == $i+1)
													{
														$dropup = "dropup";
													}
													else
													{
													$dropup = "";
													}
											        } ?>
												<tr>
													<td><?php _htmlsc($user_address->address_type); ?></td>
		                                            <td>
		                                            	<?php if($user_address->customer_street_1){
		                                            		echo $user_address->customer_street_1.", ";
		                                            	}
		                                            	if($user_address->customer_street_2){
		                                            		echo $user_address->customer_street_2.", ";
		                                            	}
		                                            	if($user_address->area){
		                                            		echo $user_address->area.", ";
		                                            	}
		                                            	if($user_address->customer_city){
		                                            		echo $user_address->city_name.", ";
		                                            	}
		                                            	if($user_address->customer_state){
		                                            		echo $user_address->state_name.", ";
		                                            	}
		                                            	if($user_address->customer_country){
		                                            		echo $user_address->country_name.", ";
		                                            	}
		                                            	if($user_address->zip_code){
		                                            		echo $user_address->zip_code;
		                                            	} ?>                                           	

		                                            </td>
													<td class="text_align_center"><?php _htmlsc($user_address->is_default); ?></td>
													<td class="text_align_center">
														<div class="options btn-group <?php echo $dropup;?>">
															<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
																<i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
															</a>
															<ul class="optionTag dropdown-menu">
																<li>
																	<a href="javascript:void(0)" data-toggle="modal" data-target="#addAddress" data-address-id="<?php echo $user_address->user_address_id; ?>" data-model-from="customer" data-customer-id="<?php echo $id; ?>" class="add_address">
																		<i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
																	</a>
																</li>
																<li>
																	<a href="javascript:void(0)" onclick="remove_address(<?php echo $user_address->user_address_id; ?>,<?php echo $this->mdl_clients->form_value('client_id', true) ?>, '<?=$this->security->get_csrf_hash(); ?>')"> <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?></a>
																</li>
															</ul>
														</div>
													</td>
												</tr>
												<?php  $i++; } } else { echo '<tr><td colspan="4" class="text-center" > No data found </td></tr>'; } ?>
											</tbody>
										</table>
									</div>
								</div>
							</section>
						</div>
						<div role="tabpanel" class="tab-pane fade <?php echo $three_tab_active; ?>" id="tabs-2-tab-3">
							<?php if ($this->mdl_clients->form_value('client_id', true)) { ?>
							<div class="row">
								<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
									<a style="margin-bottom: 15px; float: right" href="javascript:void(0)" data-toggle="modal" data-model-from="customer" data-model-type="C" data-customer-id="<?php echo $this->mdl_clients->form_value('client_id', true); ?>" data-target="#addNewCar" class="btn btn-rounded add_car"><?php _trans('lable46'); ?></a>
								</div>
							</div>
							<?php } ?>
							<div class="overflowScrollForTable">
								<?php if (count($cars_list) > 0) {
									foreach ($cars_list as $cars) { ?>
								<div class="row carList">
									<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
										<?php $imagepath =  FCPATH.'uploads/car_images/models/'.$cars->model_image; ?>
										<div class="col-xs-12 col-md-2 col-sm-2 col-lg-2">
											<div class="carDetailsBox">
												<div class="carImageBox">
													<?php if($cars->model_image && file_exists($imagepath)){ ?>
													<img alt="car" src="<?php echo base_url(); ?>uploads/car_images/models/<?php echo $cars->model_image; ?>">
													<?php } else { ?>
													<img alt="car" src="<?php echo base_url(); ?>assets/mp_backend/img/dummycarimage.svg">
													<?php } ?>
												</div>
												<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 text-center paddingTopLeft0px">
													<a href="<?php echo site_url('user_cars/view/').$cars->car_list_id.'/'.$this->mdl_clients->form_value('client_id', true); ?>"> <?php _trans('lable133'); ?></a>
												</div>
											</div>
										</div>
										<div class="col-xs-12 col-md-8 col-sm-8 col-lg-8 midSection">
											<div class="carDetailsBox">
												<h3 class="carNameBox"><?php echo $cars->brand_name.' '.$cars->model_name.' '.$cars->variant_name; ?></h3>
												<div class="carRegNoBox"><?php echo $cars->car_reg_no; ?></div>
												<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 carDetailsBoxtable">
													<div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 carDetailsBoxtableSection">
														<div class="overflowScrollForTable" style="min-height: 100px;">
															<table class="car-table-box">
																<tbody>
																	<tr>
																		<td class="fontWeight900"><?php _trans('lable130'); ?></td>
																		<td><?php echo $cars->car_model_year; ?></td>
																	</tr>
																	<tr>
																		<td class="fontWeight900"><?php _trans('lable131'); ?></td>
																		<td><?php if (!empty($recent_service)) { echo ($recent_service->pickup_date?$recent_service->pickup_date : '-'); }else { echo "-";} ?></td>
																	</tr>
																	<tr>
																		<td class="fontWeight900" ><?php _trans('lable132'); ?></td>
																		<td><?php if ($cars->fuel_type == 'P') {
																				echo 'Petrol';
																			} elseif ($cars->fuel_type == 'D') {
																				echo 'Diesel';
																			} elseif ($cars->fuel_type == 'G') {
																				echo 'LPG/Gas';
																			}?>	
																		</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-xs-12 col-md-2 col-sm-2 col-lg-2 paddingTopLeft0px">
											<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 editDeleteButtons">
												<a href="javascript:void(0)" class="editDeleteButtonsRight" onclick="remove_car(<?php echo $cars->car_list_id; ?>,<?php echo $this->mdl_clients->form_value('client_id', true); ?>, '<?=$this->security->get_csrf_hash(); ?>')" ><i class="fa fa-trash"></i></a>
												<a href="javascript:void(0)" data-toggle="modal" data-model-from="customer" data-car-id="<?php echo $cars->car_list_id; ?>" data-customer-id="<?php echo $this->mdl_clients->form_value('client_id', true);?>" data-target="#addNewCar" class="add_car editDeleteButtonsRight">
													<i class="fa fa-edit"></i>
												</a>
											</div>
										</div>
									</div>
								</div>
								<?php } }else {
									echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" > No data found </div>';
								} ?>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade <?php echo $four_tab_active; ?>" id="tabs-2-tab-4">
							<section class="card">
								<div class="card-block">
									<div class="overflowScrollForTable">
										<table id="user_address_list" class="display table table-bordered" cellspacing="0" width="100%">
											<thead>
											<tr>
												<th><?php _trans('lable240'); ?></th>
												<th><?php _trans('lable570'); ?></th>
												<th class="text_align_center"><?php _trans('lable1168'); ?></th>
											</tr>
											</thead>
											<tbody>
											<?php if(count($recommended_products) > 0){
												$i = 1;
												foreach ($recommended_products as $recommended_product) { ?>
												<tr>
													<td><?php _htmlsc($recommended_product->service_item_name); ?></td>
													<td><?php _htmlsc($recommended_product->expiry_date?date_from_mysql($recommended_product->expiry_date):""); ?></td>
													<td class="text_align_center"><?php _htmlsc($recommended_product->service_status); ?></td>
												</tr>
												<?php  $i++; } } else { echo '<tr><td colspan="3" class="text-center" > No data found </td></tr>'; } ?>
											</tbody>
										</table>
									</div>
								</div>
							</section>
						</div>
						<div role="tabpanel" class="tab-pane fade <?php echo $five_tab_active; ?>" id="tabs-2-tab-5">
							<section class="card">
								<div class="card-block">
									<div class="overflowScrollForTable">
										<table id="user_address_list" class="display table table-bordered" cellspacing="0" width="100%">
											<thead>
											<tr>
											    <th><?php _trans('lable240'); ?></th>
												<th><?php _trans('lable570'); ?></th>
												<th class="text_align_center"><?php _trans('lable1168'); ?></th>
											</tr>
											</thead>
											<tbody>
											<?php if(count($recommended_services) > 0){
												$i = 1;
												foreach ($recommended_services as $recommended_service) { ?>
												<tr>
												    <td><?php _htmlsc($recommended_service->service_item_name); ?></td>
													<td><?php _htmlsc($recommended_service->expiry_date?date_from_mysql($recommended_service->expiry_date):""); ?></td>
													<td class="text_align_center"><?php _htmlsc($recommended_service->service_status); ?></td>
												</tr>
												<?php  $i++; } } else { echo '<tr><td colspan="4" class="text-center" > No data found </td></tr>'; } ?>
											</tbody>
										</table>
									</div>
								</div>
							</section>
						</div>
					</div>
				</section>
			</div>
		</div>
    </div>
</div>
<script type="text/javascript">

var Emailinvalid = false;

$("#client_contact_no").on("keypress keyup blur",function (event) {    
           $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
	});

var phonenumberexist = '';
	$('#refered_by_type').change(function() {
		var refered_by_type = $('#refered_by_type').val();
		if (refered_by_type == '1' || refered_by_type == '2') {
			if (refered_by_type == '2') {
				var site_url = "<?php echo site_url('mech_employee/ajax/get_employee_list'); ?>";
			} else if (refered_by_type == '1') {
				var site_url = "<?php echo site_url('clients/ajax/get_client_list'); ?>";
			}
			$('#gif').show();
			$.post(site_url, {
					refered_by_type: $('#refered_by_type').val(),
					_mm_csrf: $('input[name="_mm_csrf"]').val(),
				},
				function(data) {
					var response = JSON.parse(data);
					carResponse = response;
					// console.log(response);
					var rid = '';
					var name = '';
					var phone = '';
					$('#refered_by_id').empty(); // clear the current elements in select box
					if (refered_by_type == '2') {
						$('#gif').hide();
						$('#refered_by_id').append($('<option></option>').attr('value', '').text('Select Employee'));
					} else if (refered_by_type == '1') {
						$('#gif').hide();
						$('#refered_by_id').append($('<option></option>').attr('value', '').text('Select Customer'));
					}
					if (response.length > 0) {
						$('#gif').hide();
						for (row in response) {
							if (refered_by_type == '2') {
								rid = response[row].employee_id;
								name = response[row].employee_name;
								phone = response[row].mobile_no;
							} else if (refered_by_type == '1') {
								$('#gif').hide();
								rid = response[row].client_id;
								name = response[row].client_name;
								phone = response[row].client_contact_no;
							}
							$('#refered_by_id').append($('<option></option>').attr('value', rid).text(name + ' ' + phone));
						}
						$('#refered_by_id').selectpicker("refresh");
					} else {
						$('#gif').hide();
						$('#refered_by_id').selectpicker("refresh");
					}
				});
		} else {
			$('#gif').hide();
			console.log('refered_by_type else');
		}
	});
		
	$("#btn_cancel").click(function () {
        window.location.href = "<?php echo site_url('clients'); ?>";
	});
	
	function chkEmail(emailField){
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	if($("#client_email_id").val() != ''){
			if (reg.test(emailField.value) == false) 
			{
			Emailinvalid = true;
			if(emailField.value.length > 3){
				$('.emailIdErrorr').empty().append('Invalid Email Address');
			}
			return false;
			}else{
			Emailinvalid = false;
			$('.emailIdErrorr').empty().append('');
			return true;
			}
		}else{
		Emailinvalid = false;
		$('.emailIdErrorr').empty().append('');
		return true;
		}
	}

	function checkphonenoexist()
    {
	 $.post('<?php echo site_url('clients/ajax/phonenoexist'); ?>', {
		client_id : $("#client_id").val(),
		client_contact_no : $("#client_contact_no").val(),
		branch_id : $("#branch_id").val(),
		_mm_csrf: $('input[name="_mm_csrf"]').val(),
	 },
	 function (data) 
	 {	
		response = JSON.parse(data);
            if(response.success == 1)
			{
				phonenumberexist = response.success;
				$("#showErrorMsg").empty().append('Mobile Number Already Exist');
				return false;
			}
			else
			{
				phonenumberexist = response.success;
				$("#showErrorMsg").empty().append('');
            }
        });
    }

    $(".btn_submit").click(function () {

		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');

		var validation = [];

		if($("#client_name").val() == ''){
			validation.push('client_name');
		}
		if($("#branch_id").val() == ''){
			validation.push('branch_id');
		}
		if($("#customer_category_id").val() == ''){
			validation.push('customer_category_id');
		}
		if($("#client_contact_no").val() == ''){
			validation.push('client_contact_no');
		}else{
			if(phonenumberexist == 1){
				$("#showErrorMsg").empty().append('Mobile Number Already Exist');
				return false;
				}else{
				$("#showErrorMsg").empty().append('');
			}
		}

		if(validation.length > 0){
			validation.forEach(function(val) {
				$('#'+val).addClass("border_error");
				$('#'+val).parent().addClass('has-error');
			});
			return false;
		}

		if($("#client_email_id").val() != ''){
			if(Emailinvalid){
				$('.emailIdErrorr').empty().append('Invalid Email Address');
				$("#client_email_id").focus();
				return false;	
			}
		}
		
		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');
		$('#gif').show();

		$.post('<?php echo site_url('clients/ajax/create'); ?>', {
            client_id : $("#client_id").val(),
			client_no : $("#client_no").val(),
			invoice_group_id : $("#invoice_group_id").val(),
            client_name : $('#client_name').val(),
			branch_id : $("#branch_id").val(),
			customer_category_id : $("#customer_category_id").val(),
			client_gstin : $("#client_gstin").val(),
            client_contact_no : $('#client_contact_no').val(),
			client_email_id : $('#client_email_id').val(),
			refered_by_type : $('#refered_by_type').val(),
			refered_by_id : $('#refered_by_id').val(),
			action_from: 'C',
			btn_submit : $(this).val(),
			_mm_csrf: $('input[name="_mm_csrf"]').val(),
        }, function (data) {	
            list = JSON.parse(data);
            if(list.success=='1'){
                notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
				if(list.btn_submit == '1'){
					setTimeout(function(){
						window.location = "<?php echo site_url('clients/form'); ?>";
					}, 100);
				}else{
					setTimeout(function(){
						window.location = "<?php echo site_url('clients/form'); ?>/"+list.customer_id+"/2";
					}, 100);
				}
            }else{
				$('#gif').hide();
				notie.alert(3, '<?php _trans('toaster2'); ?>', 2);
				$('.has-error').removeClass('has-error');
                for (var key in list.validation_errors) {
                    $('#' + key).parent().addClass('has-error');
                    $('.error_msg_' + key).show().empty().html(list.validation_errors[key]);
                }
            }
        });
	});

</script>