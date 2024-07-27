<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php echo _trans($breadcrumb); ?><?php echo ($this->mdl_suppliers->form_value('supplier_no', true)?" (".$this->mdl_suppliers->form_value('supplier_no', true).") ":''); ?></h3>
				</div>
				<div class="tbl-cell pull-right">
					<a class="btn btn-sm btn-primary" href="<?php echo site_url('suppliers/form'); ?>">
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
        $one_area_selected = true;
        $two_area_selected = false;
        $three_area_selected = false;
        $four_area_selected = false;
    } elseif ($active_tab == 2) {
        $one_tab_active = '';
        $two_tab_active = 'active show in';
        $three_tab_active = '';
        $four_tab_active = '';
        $one_area_selected = false;
        $two_area_selected = true;
        $three_area_selected = false;
        $four_area_selected = false;
    } elseif ($active_tab == 3) {
        $one_tab_active = '';
        $two_tab_active = '';
        $three_tab_active = 'active show in';
        $four_tab_active = '';
        $one_area_selected = false;
        $two_area_selected = false;
        $three_area_selected = true;
        $four_area_selected = false;
    } elseif ($active_tab == 4) {
        $one_tab_active = '';
        $two_tab_active = '';
        $three_tab_active = '';
        $four_tab_active = 'active show in';
        $one_area_selected = false;
        $two_area_selected = false;
        $three_area_selected = false;
        $four_area_selected = true;
    }
} else {
    $one_tab_active = 'active show in';
    $two_tab_active = '';
    $three_tab_active = '';
    $four_tab_active = '';
    $one_area_selected = true;
    $two_area_selected = false;
    $three_area_selected = false;
    $four_area_selected = false;
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
			<a class="anchor anchor-back" onclick="goBack()" href="<?php echo site_url('suppliers/index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
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
						<?php if ($this->mdl_suppliers->form_value('supplier_id', true)) {
    ?>
						
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $two_tab_active; ?> " href="#tabs-2-tab-3" role="tab" data-toggle="tab" aria-selected="<?php echo $two_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable81'); ?></span>
								<span class="rightCountipad label label-pill label-success"><?php echo count($workshop_bank_list); ?></span>
							</a>
						</li>
						<li class="nav-item">	
							<a class="navListlink nav-link <?php echo $four_tab_active; ?> " href="#tabs-2-tab-4" role="tab" data-toggle="tab" aria-selected="<?php echo $four_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable82'); ?></span>
								<span class="rightCountipad label label-pill label-success"><?php echo count($payments); ?></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $three_tab_active; ?>" href="#tabs-2-tab-2" role="tab" data-toggle="tab" aria-selected="<?php echo $three_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable83'); ?></span>
								<span class="rightCountipad label label-pill label-success"><?php echo count($purchase_list); ?></span>
							</a>
						</li>
						<?php } else { ?>
						
						<li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable81'); ?></span>
								<span class="rightCountipad label label-pill label-success"><?php echo count($workshop_bank_list); ?></span>
							</a>
						</li>
						<li class="nav-item">	
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable82'); ?></span>
								<span class="rightCountipad label label-pill label-success"><?php echo count($payments); ?></span>
							</a>
						</li> 
						<li class="nav-item">
						    <a class="navListlink nav-link not-allowed" href="#" role="tab" >
						    	<span class="leftHeadSpan nav-link-in"><?php _trans('lable83'); ?></span>
								<span class="rightCountipad label label-pill label-success"><?php echo count($purchase_list); ?></span>
							</a>
						</li>
						<?php }?>
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
						<?php if ($this->mdl_suppliers->form_value('supplier_id', true)) {
    ?>
						
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $two_tab_active; ?> " href="#tabs-2-tab-3" role="tab" data-toggle="tab" aria-selected="<?php echo $two_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable81'); ?></span>
								<span class="rightCountSpan label label-pill label-success"><?php echo count($workshop_bank_list); ?></span>
							</a>
						</li>
						<li class="nav-item">	
							<a class="navListlink nav-link <?php echo $four_tab_active; ?> " href="#tabs-2-tab-4" role="tab" data-toggle="tab" aria-selected="<?php echo $four_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable82'); ?></span>
								<span class="rightCountSpan label label-pill label-success"><?php echo count($payments); ?></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $three_tab_active; ?>" href="#tabs-2-tab-2" role="tab" data-toggle="tab" aria-selected="<?php echo $three_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable83'); ?></span>
								<span class="rightCountSpan label label-pill label-success"><?php echo count($purchase_list); ?></span>
							</a>
						</li>
						<?php } else { ?>
						
						<li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable81'); ?></span>
								<span class="rightCountSpan label label-pill label-success"><?php echo count($workshop_bank_list); ?></span>
							</a>
						</li>
						<li class="nav-item">	
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable82'); ?></span>
								<span class="rightCountSpan label label-pill label-success"><?php echo count($payments); ?></span>
							</a>
						</li> 
						<li class="nav-item">
						    <a class="navListlink nav-link not-allowed" href="#" role="tab" >
						    	<span class="leftHeadSpan nav-link-in"><?php _trans('lable83'); ?></span>
								<span class="rightCountSpan label label-pill label-success"><?php echo count($purchase_list); ?></span>
							</a>
						</li>
						<?php }?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 paddingTopLeft0px">
            	<input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
				<section class="tabs-section" >
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane fade <?php echo $one_tab_active; ?>" id="tabs-2-tab-1">
							<input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?= $this->security->get_csrf_hash(); ?>">
							<input type="hidden" name="supplier_no" id="supplier_no" value="<?php echo $this->mdl_suppliers->form_value('supplier_no', true); ?>" autocomplete="off"/>
							<input type="hidden" id="invoice_group_id" name="invoice_group_id" value="<?php echo $invoice_group_number->invoice_group_id;?>" >
							<input class="hidden" name="is_update" type="hidden"
							<?php if ($this->mdl_suppliers->form_value('is_update')) {
    echo 'value="1"';
} else {
    echo 'value="0"';
}?>>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable50'); ?>*</label>
								</div>
								<div class="col-sm-9">
									<input type="hidden" name="supplier_id" id="supplier_id" class="form-control" value="<?php echo $this->mdl_suppliers->form_value('supplier_id', true); ?>">
									<input type="text" name="supplier_name" id="supplier_name" class="form-control" value="<?php echo $this->mdl_suppliers->form_value('supplier_name', true); ?>">
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
									<label class="control-label string required"><?php _trans('lable51'); ?>*</label>
								</div>
								<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
									<select id="branch_id" name="branch_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" >
										<?php if(count($branch_list) != 1){ ?>
											<option value=""><?php _trans('lable51'); ?></option>
										<?php } ?>
										<?php foreach ($branch_list as $branchList) {?>
										<option value="<?php echo $branchList->w_branch_id; ?>" <?php if($this->mdl_suppliers->form_value('branch_id', true) == $branchList->w_branch_id){echo "selected";}?> > <?php echo $branchList->display_board_name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>

							<div class="form-group clearfix">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
									<label class="control-label string required"><?php _trans('lable208'); ?> *</label>
								</div>
								<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
									<select id="suppliers_category_id" name="suppliers_category_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" >
										<?php if(count($suppliercategory)>0){ ?>
											<option value=""><?php _trans('lable855'); ?></option>
										<?php } ?>
										<?php foreach ($suppliercategory as $suppcategory) {?>
											<option value="<?php echo $suppcategory->suppliers_category_id; ?>" <?php if($this->mdl_suppliers->form_value('suppliers_category_id', true) == $suppcategory->suppliers_category_id){echo "selected";}?> > <?php echo $suppcategory->suppliers_category_name; ?></option>
										<?php } ?>
									</select>
									<div class="col-lg-12 paddingLeft0px paddingTop5px">
										<a href="javascript:void(0)" data-toggle="modal" data-model-from="supplier" data-target="#addNewCar" class="float_left fontSize_85rem add_supplier_category">
											+ <?php echo trans('lable1037'); ?>
										</a>
									</div>
								</div>
							</div>

							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable42'); ?>. *</label>
								</div>
								<div class="col-sm-9">
									<input type="text" name="supplier_contact_no" id="supplier_contact_no" class="form-control" value="<?php echo $this->mdl_suppliers->form_value('supplier_contact_no', true); ?>" onkeyup="checkmobilenoexist();">
									<div id="showErrorMsg" class="error"></div>
								</div>
								
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required" style="margin-right: 3px"><?php _trans('lable41'); ?></label>
								</div>
								<div class="col-sm-9">
									<input type="text" name="supplier_email_id" id="supplier_email_id" onblur="chkEmail(this);" class="form-control" value="<?php echo $this->mdl_suppliers->form_value('supplier_email_id', true); ?>">
									<span class="error emailIdErrorr"></span>
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable84'); ?></label>
								</div>
								<div class="col-sm-9">
									<input type="text" name="supplier_gstin" id="supplier_gstin" class="form-control" value="<?php echo $this->mdl_suppliers->form_value('supplier_gstin', true); ?>">
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable85'); ?></label>
								</div>
								<div class="col-sm-9">
									<input type="text" name="supplier_street" id="supplier_street" class="form-control" value="<?php echo $this->mdl_suppliers->form_value('supplier_street', true); ?>">
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label"><?php _trans('lable86'); ?></label>
								</div>
								<div class="col-sm-9">
									<?php if($this->mdl_suppliers->form_value('supplier_country', true)){
										$default_country_id = $this->mdl_suppliers->form_value('supplier_country', true);
									}else{
										$default_country_id = $this->session->userdata('default_country_id');
									} ?>
									<select name="supplier_country" id="supplier_country" class="country bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" >
										<option value=""><?php _trans('lable163'); ?></option>
										<?php foreach ($country_list as $countryList) {?>
										<option value="<?php echo $countryList->id; ?>" <?php if ($countryList->id == $default_country_id){ echo 'selected';} ?>><?php echo $countryList->name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label"><?php _trans('lable87'); ?></label>
								</div>
								<div class="col-sm-9">
									<?php if($this->mdl_suppliers->form_value('supplier_state', true)){
										$default_state_id = $this->mdl_suppliers->form_value('supplier_state', true);
									}else{
										$default_state_id = $this->session->userdata('default_state_id');
									} ?>
									<select name="supplier_state" id="supplier_state" class="state bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" >
										<option value=""><?php _trans('lable164'); ?></option>
										<?php foreach ($state_list as $stateList) {?>
										<option value="<?php echo $stateList->state_id; ?>" <?php if ($stateList->state_id == $default_state_id) {echo 'selected';} ?> > <?php echo $stateList->state_name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label"><?php _trans('lable88'); ?></label>
								</div>
								<div class="col-sm-9">
									<?php if($this->mdl_suppliers->form_value('supplier_city', true)){
										$default_city_id = $this->mdl_suppliers->form_value('supplier_city', true);
									}else{
										$default_city_id = $this->session->userdata('default_city_id');
									} ?>
									<select id="supplier_city" name="supplier_city" class="city bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" >
										<option value=""><?php _trans('lable165'); ?></option>
										<?php foreach ($city_list as $cityList) {?>
										<option value="<?php echo $cityList->city_id; ?>" <?php if ($cityList->city_id == $default_city_id) { echo 'selected';}?>><?php echo $cityList->city_name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable89'); ?></label>
								</div>
								<div class="col-sm-9">
									<input type="text" name="supplier_pincode" id="supplier_pincode" class="form-control" value="<?php echo $this->mdl_suppliers->form_value('supplier_pincode', true); ?>" >
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable1128'); ?></label>
								</div>
								<div class="col-sm-9">
									<input type="text" name="credit_period" id="credit_period" class="form-control" value="<?php echo $this->mdl_suppliers->form_value('credit_period', true); ?>" >
								</div>
							</div>
							<div class="buttons text-center">
								<button id="btn_submit" value="1" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
									<i class="fa fa-check"></i> <?php _trans('lable56'); ?>
								</button>
								<button id="btn_submit" value="2" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
									<i class="fa fa-check"></i> <?php _trans('lable57'); ?>
								</button>
								<button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default btn_cancel">
									<i class="fa fa-times"></i> <?php _trans('lable58'); ?>
								</button>
							</div>	
						</div>
						<div role="tabpanel" class="tab-pane fade <?php echo $four_tab_active; ?>" id="tabs-2-tab-4">
						<?php if ($this->mdl_suppliers->form_value('supplier_id', true)) {
        ?>
							<div class="row">
								<div class="col-sm-12">
									<a style="margin-bottom: 15px; float: right" href="<?php echo site_url('mech_payments/form'); ?>"  class="btn btn-rounded"><?php _trans('lable102'); ?></a>
								</div>
							</div>
						<?php
    }?>
	<div class="overflowScrollForTable">
						<table id="mechanic_list" class="display table table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><?php _trans('lable104'); ?></th>
			            <th><?php _trans('lable105'); ?></th>
				        <th><?php _trans('lable106'); ?>/<?php _trans('lable107'); ?></th>
				        <th class="text_align_right"><?php _trans('lable108'); ?></th>
				        <th><?php _trans('lable109'); ?></th>
				        <th class="text_align_center"><?php _trans('lable22'); ?></th>
			        </tr>
                </thead>
                <tbody>
                    <?php if (count($payments) > 0) {
						$i = 1;
					foreach ($payments as $payment) {
						if(count($payments) >= 4)
						{    	
						if(count($payments) == 1 || count($payments) == $i+1)
						{
							$dropup = "dropup";
						}
						else
						{
						$dropup = "";
						}
						} ?>
                    <tr>
                        <td>
						<?php echo ucfirst($payment->entity_type); ?></td>
                        <td><?php  echo date_from_mysql($payment->paid_on); ?></td>
                        <td>
                            <?php if ($payment->entity_type == 'invoice') {
                $site_url = 'clients/form/';
            } elseif ($payment->entity_type == 'purchase' || $payment->entity_type == 'expense') {
                $site_url = 'suppliers/form/';
            } ?>
                            <a href="<?php echo site_url($site_url.$payment->customer_id); ?>" title="<?php _trans('lable122'); ?>">
                                <?php _htmlsc(getCustomerSupplierName($payment->customer_id, $payment->entity_type)); ?>
                            </a>
                        </td>
                        <td class="text_align_right"><?php echo format_currency($payment->payment_amount); ?></td>
                        <td><?php _htmlsc($payment->payment_method_name); ?></td>
                        <td class="text_align_center">
                            <div class="options btn-group  <?php echo $dropup;?>">
                                <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                </a>
                                <ul class="optionTag dropdown-menu">
                                    <?php if (($payment->inv_tda > 0 && $payment->entity_type == 'invoice') || ($payment->pur_tda > 0 && $payment->entity_type == 'purchase') || ($payment->exp_tda > 0 && $payment->entity_type == 'expense')) {
                ?>
                                    <li>
                                        <a href="<?php echo site_url('mech_payments/form/'.$payment->payment_id); ?>">
                                            <i class="fa fa-edit fa-margin"></i>
                                            <?php _trans('lable44'); ?>
                                        </a>
                    </li><?php
            } ?>
                                    <li>
                                        <a href="<?php echo site_url('mech_payments/delete/'.$payment->payment_id); ?>" onclick="return confirm('<?php _trans('lable123'); ?>');">
                                            <i class="fa fa-trash-o fa-margin"></i>
                                            <?php _trans('lable47'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        				</td>
                   					</tr>
                     			<?php ++$i; } } else { echo '<tr><td colspan="7" class="text-center" > No data found </td></tr>'; } ?>
	            				</tbody>
							</table>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade <?php echo $three_tab_active; ?>" id="tabs-2-tab-2">
							<section class="card">
								<div class="card-block">
					<?php if ($this->mdl_suppliers->form_value('supplier_id', true)) {
        ?>
									<div class="row">
										<div class="col-sm-12">
											<a style="margin-bottom: 15px; float: right" href="<?php echo site_url('mech_purchase/create'); ?>"  class="btn btn-rounded"><?php _trans('lable124'); ?></a>
										</div>
									</div>
					<?php
    }?>
									
									<div class="overflowScrollForTable">
									<table id="supplier_purchase_list" class="display table table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th class="text_align_center"><?php _trans('lable125'); ?></th>
												<th><?php _trans('lable126'); ?>.</th>
												<th class="text_align_center"><?php _trans('lable32'); ?></th>
												<th class="text_align_center"><?php _trans('lable127'); ?></th>
												<th><?php _trans('lable128'); ?></th>
												<th class="text_align_center"><?php _trans('lable22'); ?></th>
											</tr>
										</thead>
										<tbody>
							<?php
	if (count($purchase_list) > 0) {
			$i = 1;
			foreach ($purchase_list as $purchase) {
				if(count($purchase_list) >= 4)
				{    	
				if(count($purchase_list) == 1 || count($purchase_list) == $i+1)
				{
					$dropup = "dropup";
				}
				else
				{
				$dropup = "";
				}
				} ?>
											<tr>
												<td class="text_align_center"><?php _htmlsc($i); ?></td>
												<td><a href="<?php echo site_url('mech_purchase/create/'.$purchase->purchase_id); ?>"><?php _htmlsc($purchase->purchase_no); ?></a></td>
												<td class="text_align_right"><?php echo format_currency($purchase->total_due_amount); ?></td>
												<td class="text_align_center"><?php echo date_from_mysql($purchase->purchase_date_due); ?></td>
												<td><?php if ($purchase->purchase_status == 'D') {
					echo 'Draft';
				} elseif ($purchase->purchase_status == 'G') {
					echo 'Saved';
				} elseif ($purchase->purchase_status == 'PP') {
					echo 'Partial paid';
				} elseif ($purchase->purchase_status == 'FP') {
					echo 'Paid';
				} ?>
												</td>
												<td class="text_align_center">
													<div class="options btn-group <?php echo $dropup;?>">
														<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
															<i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
														</a>
														<ul class="optionTag dropdown-menu">
															<li>
																<a href="<?php echo site_url('mech_purchase/create/'.$purchase->purchase_id); ?>">
																	<i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
																</a>
															</li>
															<?php if ($purchase->purchase_status != 'PP' && $purchase->purchase_status != 'FP') {
					?>
															<li>
																<a href="javascript:void(0)" onclick="remove_entity(<?php echo $purchase->purchase_id; ?>,'mech_purchase', 'purchase','<?=$this->security->get_csrf_hash(); ?>')">
																	<i class="fa fa-edit fa-times"></i> <?php _trans('lable47'); ?>
																</a>
															</li>
                                <?php
            } ?>
														</ul>
													</div>
												</td>
                							</tr>
            <?php ++$i; } } else { echo '<tr><td colspan="6" class="text-center" > No data found </td></tr>'; } ?>
										</tbody>
									</table>
									</div>
								</div>
							</section>
						</div>
						<div role="tabpanel" class="tab-pane fade <?php echo $two_tab_active; ?>" id="tabs-2-tab-3">
							<div class="row">
								<div class="col-sm-12">
									<a style="margin-bottom: 15px; float: right" href="javascript:void(0)" data-toggle="modal" data-module-type="S" data-entity-id="<?php echo $this->mdl_suppliers->form_value('supplier_id', true); ?>" data-bank-id="0" data-target="#addBank" class="btn btn-rounded add_bank"><?php _trans('lable92');?></a>
								</div>
							</div>
							<?php if (count($workshop_bank_list) > 0) {
        foreach ($workshop_bank_list as $bank) {
            ?>
							<div class="box-typical car-box-panel" id="renderbankDetails">
                				<div class="row">
                					<div class="col-sm-5">
                						<div class="car-details-box profile-box border-right">
										<div class="overflowScrollForTable" style="min-height: 150px;">
                							<table class="car-table-box">
                								<tbody>
                									<tr>
													<th><strong><?php _trans('lable129'); ?></strong></th><td><?php echo $bank->display_board_name; ?></td>
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
                					<div class="col-sm-5">
                						<div class="car-details-box profile-box">
										<div class="overflowScrollForTable" style="min-height: 150px;">
                							<table class="car-table-box">
                								<tbody>
													<tr>
														<th><strong><?php _trans('lable98'); ?></strong></th><td><?php echo $bank->account_holder_name; ?></td>
													</tr>
													<tr>
														<th><strong><?php _trans('lable101'); ?></strong></th><td><?php if ($bank->account_type == '1') {
												echo 'Current';
											} elseif ($bank->account_type == '2') {
												echo 'Saving';
											} elseif ($bank->account_type == '3') {
												echo 'Others';
											} elseif ($bank->account_type == '4') {
												echo 'Saving';
											} ?></td>
													</tr>
													<tr>
														<th><strong><?php _trans('lable98'); ?></strong></th><td><?php echo $bank->account_number; ?></td>
													</tr>
													<tr>
														<th><strong><?php _trans('lable69'); ?></strong></th><td><?php if ($bank->is_default == 'Y') {
												echo 'Yes';
											} elseif ($bank->is_default == 'N') {
												echo 'No';
													} ?>		</td>
                        							</tr>
                        						</tbody>
                        					</table>
											</div>
                        				</div>
                        			</div>
                    				<div class="col-sm-2 pull-right text_align_right">
    									<a href="javascript:void(0)" data-toggle="modal" data-module-type="S" data-target="#addBank" data-entity-id="<?php echo $this->mdl_suppliers->form_value('supplier_id', true); ?>" data-bank-id="<?php echo $bank->bank_id; ?>" class="page-header-edit add_bank">
    										<i class="fa fa-edit"></i>
    									</a>
    									<a href="javascript:void(0)" class="page-header-remove" onclick="remove_bank(<?php echo $bank->bank_id; ?>, '<?= $this->security->get_csrf_hash(); ?>')"><i class="fa fa-trash"></i></a>
                    				</div>
								</div>
							</div>
<?php
        }
							} else {
							    echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" > No data found </div>';
							}?>
						</div>

					</div>
				</section>
			</div>
		</div>
    </div>
</div>

<script>

var Emailinvalid = false;

$("#supplier_contact_no").on("keypress keyup blur",function (event) {    
           $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
	});
$("#credit_period").on("keypress keyup blur",function (event) {    
           $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
	});	

var phonenumberexist = '';
	$(document).ready(function() {
		$("#btn_cancel").click(function () {
        	window.location.href = "<?php echo site_url('suppliers'); ?>";
    	});

	

		$(".btn_submit").click(function () {

			
		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');

		var validation = [];

		if($("#supplier_name").val() == ''){
			validation.push('supplier_name');
		}
		if($("#branch_id").val() == ''){
			validation.push('branch_id');
		}
		if($("#suppliers_category_id").val() == ''){
			validation.push('suppliers_category_id');
		}
		if($("#supplier_contact_no").val() == ''){
			validation.push('supplier_contact_no');
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

		if($("#supplier_email_id").val() != ''){
			if(Emailinvalid){
				$('.emailIdErrorr').empty().append('Invalid Email Address');
				$("#supplier_email_id").focus();
				return false;
			}
		}
			
			var btn_type = $(this).val();

				$('.border_error').removeClass('border_error');
				$('.has-error').removeClass('has-error');
				$('#gif').show();

			$.post('<?php echo site_url('suppliers/ajax/create'); ?>', {
				supplier_id : $("#supplier_id").val(),
				supplier_no : $("#supplier_no").val(),
				invoice_group_id : $("#invoice_group_id").val(),
				supplier_name : $('#supplier_name').val(),
				branch_id : $("#branch_id").val(),
				suppliers_category_id : $("#suppliers_category_id").val(),
				supplier_gstin : $('#supplier_gstin').val(),
				supplier_street : $('#supplier_street').val(),
				// supplier_area : $('#supplier_area').val(),
				supplier_city : $('#supplier_city').val(),
				supplier_state: $('#supplier_state').val(),
				supplier_pincode : $('#supplier_pincode').val(),
				credit_period  : $('#credit_period').val(),
				supplier_country : $("#supplier_country").val(),
				supplier_contact_no : $('#supplier_contact_no').val(),
				supplier_email_id : $('#supplier_email_id').val(),
				action_from: 'S',
				btn_submit : $(this).val(),
				_mm_csrf: $('#_mm_csrf').val()
	        }, function (data) {
	            list = JSON.parse(data);
	            if(list.success=='1'){
	                notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
					if(btn_type == '1'){
						setTimeout(function(){
							window.location = "<?php echo site_url('suppliers/form'); ?>";
						}, 100);
					}else{
						setTimeout(function(){
							window.location = "<?php echo site_url('suppliers/form'); ?>/"+list.supplier_id+"/2";
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
		

		$('.country').change(function () {
			$('#gif').show();
            $.post("<?php echo site_url('settings/ajax/get_state_list'); ?>", {
				country_id: $('#supplier_country').val(),
				_mm_csrf: $('#_mm_csrf').val()
			},
			function (data) {
				var response = JSON.parse(data);
				if (response.length > 0) {
					$('#gif').hide();
					$('#supplier_state').empty(); // clear the current elements in select box
					$('#supplier_state').append($('<option></option>').attr('value', '').text('Select State'));
					for (row in response) {
						$('#supplier_state').append($('<option></option>').attr('value', response[row].state_id).text(response[row].state_name));
					}
					$('#supplier_state').selectpicker("refresh");
				}
				else {
					$('#gif').hide();
					$('#supplier_state').empty(); // clear the current elements in select box
					$('#supplier_state').append($('<option></option>').attr('value', '').text('Select State'));
					$('#supplier_state').selectpicker("refresh");
				}
			});
		});
		
		$('.state').change(function () {
			$('#gif').show();
            $.post("<?php echo site_url('settings/ajax/get_city_list'); ?>", {
				state_id: $('#supplier_state').val(),
				_mm_csrf: $('#_mm_csrf').val()
			},
			function (data) {
				var response = JSON.parse(data);
				if (response.length > 0) {
					$('#gif').hide();
					$('#supplier_city').empty(); // clear the current elements in select box
					$('#supplier_city').append($('<option></option>').attr('value', '').text('Select City'));
					for (row in response) {
						$('#supplier_city').append($('<option></option>').attr('value', response[row].city_id).text(response[row].city_name));
					}
					$('#supplier_city').selectpicker("refresh");
				}
				else {
					$('#gif').hide();
					$('#supplier_city').empty(); // clear the current elements in select box
					$('#supplier_city').append($('<option></option>').attr('value', '').text('Select City'));
					$('#supplier_city').selectpicker("refresh");
				}
			});
		});
	});

	function chkEmail(emailField){
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	if($("#supplier_email_id").val() != ''){
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

	function checkmobilenoexist()
    {
		$.post('<?php echo site_url('suppliers/ajax/mobilenoexist'); ?>', {
		 supplier_id : $("#supplier_id").val(),
		 supplier_contact_no : $("#supplier_contact_no").val(),
		_mm_csrf: $("#_mm_csrf").val()
	 },
	 function (data) 
	 {	
		response = JSON.parse(data);
            if(response.success == 1)
			{
				phonenumberexist = response.success;
				$("#showErrorMsg").empty().append('Mobile Number Already Exist');
			}
			else
			{
				phonenumberexist = response.success;
				$("#showErrorMsg").empty().append('');
	
            }
        });
     }
</script>