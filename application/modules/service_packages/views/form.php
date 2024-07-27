<?php $servicepack_url_key = $this->mdl_service_package->form_value('url_key', true)?$this->mdl_service_package->form_value('url_key', true):$this->mdl_service_package->get_url_key();?>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/lib/summernote/summernote.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/separate/pages/editor.min.css">
<style>
.inputfile {
  /* visibility: hidden etc. wont work */
  width: 0.1px;
  height: 0.1px;
  opacity: 0;
  overflow: hidden;
  position: absolute;
  z-index: -1;
}
.inputfile:focus + label {
  /* keyboard navigation */
  outline: 1px dotted #000;
  outline: -webkit-focus-ring-color auto 5px;
}
.inputfile + label * {
  pointer-events: none;
}
</style>

<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php echo _trans($breadcrumb); ?></h3>
				</div>
				<div class="tbl-cell pull-right">
					<a class="btn btn-sm btn-primary" href="<?php echo site_url('service_packages/form'); ?>">
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
		$six_tab_active = '';
        $two_tab_active = '';
        $three_tab_active = '';
		$four_tab_active = '';
		$five_tab_active = '';
		$seven_tab_active = '';
        $one_area_selected = true;
		$six_area_selected = false;
        $two_area_selected = false;
        $three_area_selected = false;
		$four_area_selected = false;
		$five_area_selected = false;
		$seven_area_selected = false;
    } elseif ($active_tab == 6) {
        $one_tab_active = '';
		$six_tab_active = 'active show in';
        $two_tab_active = '';
        $three_tab_active = '';
        $four_tab_active = '';
		$five_tab_active = '';
		$seven_tab_active = '';
        $one_area_selected = false;
		$six_area_selected = true;
        $two_area_selected = false;
        $three_area_selected = false;
        $four_area_selected = false;
		$five_area_selected = false;
		$seven_area_selected = false;
    }elseif ($active_tab == 2) {
        $one_tab_active = '';
		$six_tab_active = '';
        $two_tab_active = 'active show in';
        $three_tab_active = '';
		$four_tab_active = '';
		$five_tab_active = '';
		$seven_tab_active = '';
        $one_area_selected = false;
		$six_area_selected = false;
        $two_area_selected = true;
        $three_area_selected = false;
		$four_area_selected = false;
		$five_area_selected = false;
		$seven_area_selected = false;
    } elseif ($active_tab == 3) {
        $one_tab_active = '';
		$six_tab_active = '';
        $two_tab_active = '';
        $three_tab_active = 'active show in';
		$four_tab_active = '';
		$five_tab_active = '';
		$seven_tab_active = '';
        $one_area_selected = false;
		$six_area_selected = false;
        $two_area_selected = false;
        $three_area_selected = true;
		$four_area_selected = false;
		$five_area_selected = false;
		$seven_area_selected = false;
    }elseif ($active_tab == 4) {
        $one_tab_active = '';
		$six_tab_active = '';
        $two_tab_active = '';
        $three_tab_active = '';
        $four_tab_active = 'active show in';
		$five_tab_active = '';
		$seven_tab_active = '';
        $one_area_selected = false;
		$six_area_selected = false;
        $two_area_selected = false;
        $three_area_selected = false;
        $four_area_selected = true;
		$five_area_selected = false;
		$seven_area_selected = false;
    }elseif ($active_tab == 5) {
        $one_tab_active = '';
		$six_tab_active = '';
        $two_tab_active = '';
        $three_tab_active = '';
        $four_tab_active = '';
		$seven_tab_active = '';
		$five_tab_active = 'active show in';
        $one_area_selected = false;
		$six_area_selected = false;
        $two_area_selected = false;
        $three_area_selected = false;
        $four_area_selected = false;
		$five_area_selected = true;
		$seven_area_selected = false;
    }elseif ($active_tab == 6) {
        $one_tab_active = '';
		$six_tab_active = '';
        $two_tab_active = '';
        $three_tab_active = '';
        $four_tab_active = '';
		$seven_tab_active = '';
		$five_tab_active = 'active show in';
        $one_area_selected = false;
		$six_area_selected = false;
        $two_area_selected = false;
        $three_area_selected = false;
        $four_area_selected = false;
		$five_area_selected = false;
		$seven_area_selected = true;
    }
	
} else {
    $one_tab_active = 'active show in';
	$six_tab_active = '';
    $two_tab_active = '';
	$three_tab_active = '';
	$four_tab_active = '';
	$seven_tab_active = '';
    $one_area_selected = true;
	$six_area_selected = false;
    $two_area_selected = false;
    $three_area_selected = false;
    $four_area_selected = false;
	$five_area_selected = false;
	$seven_area_selected = false;
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
			<a class="anchor anchor-back" href="<?php echo site_url('service_packages/index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
		</div>
	</div>
    <div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 ipadview">
			<div class="nav nav-tabs">
				<div class="tbl">
                <ul class="nav" role="tablist">
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $one_tab_active; ?>" href="#tabs-2-tab-1" role="tab" data-toggle="tab" aria-selected="<?php echo $one_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('label952'); ?></span>
							</a>
						</li>
						<?php if($package_details->s_pack_id) { ?>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $six_tab_active; ?>" href="#tabs-2-tab-6" role="tab" data-toggle="tab" aria-selected="<?php echo $six_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable881'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $two_tab_active; ?>" href="#tabs-2-tab-2" role="tab" data-toggle="tab" aria-selected="<?php echo $two_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('label943'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $three_tab_active; ?>" href="#tabs-2-tab-3" role="tab" data-toggle="tab" aria-selected="<?php echo $three_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('label944'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>
                        <li class="nav-item">
							<a class="navListlink nav-link <?php echo $four_tab_active; ?>" href="#tabs-2-tab-4" role="tab" data-toggle="tab" aria-selected="<?php echo $four_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('label945'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $five_tab_active; ?>" href="#tabs-2-tab-5" role="tab" data-toggle="tab" aria-selected="<?php echo $five_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('label971'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $seven_tab_active; ?>" href="#tabs-2-tab-7" role="tab" data-toggle="tab" aria-selected="<?php echo $seven_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable1240'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>
						<?php } else { ?>

						<li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable881'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>

						<li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('label943'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>

						<li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('label944'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>
                       
                        <li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('label945'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('label971'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable1240'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>
						<?php } ?>
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
								<span class="leftHeadSpan nav-link-in"><?php _trans('label952'); ?></span>
							</a>
						</li>
						<?php if($package_details->s_pack_id) { ?>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $six_tab_active; ?>" href="#tabs-2-tab-6" role="tab" data-toggle="tab" aria-selected="<?php echo $six_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable881'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $two_tab_active; ?>" href="#tabs-2-tab-2" role="tab" data-toggle="tab" aria-selected="<?php echo $two_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('label943'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $three_tab_active; ?>" href="#tabs-2-tab-3" role="tab" data-toggle="tab" aria-selected="<?php echo $three_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('label944'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>
                        <li class="nav-item">
							<a class="navListlink nav-link <?php echo $four_tab_active; ?>" href="#tabs-2-tab-4" role="tab" data-toggle="tab" aria-selected="<?php echo $four_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('label945'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $five_tab_active; ?>" href="#tabs-2-tab-5" role="tab" data-toggle="tab" aria-selected="<?php echo $five_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('label971'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $seven_tab_active; ?>" href="#tabs-2-tab-7" role="tab" data-toggle="tab" aria-selected="<?php echo $seven_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable1240'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>
						<?php } else { ?>

						<li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable881'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>

						<li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('label943'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>

						<li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('label944'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>
                       
                        <li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('label945'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('label971'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable1240'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>
						<?php } ?>
					</ul>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 paddingTopLeft0px">
			<input type="hidden" name="s_pack_id" id="s_pack_id" class="form-control" value="<?php echo $package_details->s_pack_id; ?>"autocomplete="off">
            <input type="hidden" name="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>" autocomplete="off">
			<input type="hidden" name="url_key" id="url_key" value="<?php echo $servicepack_url_key; ?>" >
				<section class="tabs-section" >
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade <?php echo $one_tab_active; ?>" id="tabs-2-tab-1">
                            <input class="hidden" name="is_update" type="hidden" autocomplete="off"
                            <?php if ($this->mdl_service_package->form_value('is_update')) { echo 'value="1"'; } else { echo 'value="0"'; }?>>
                            <div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable540'); ?> *</label>
								</div>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="package_name" id="package_name" value="<?php echo $package_details->package_name; ?>" autocomplete="off">
								</div>
							</div>

							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required" style="margin-right: 3px"> <?php _trans('lable208'); ?> *</label>
								</div>								
								<div class="col-sm-9">
								<select name="category_id" id="category_id" class="bootstrap-select bootstrap-select-arrow removeError form-control" data-live-search="true">
                                    <option value=""><?php _trans('lable252'); ?></option>
                                    <?php $category_id = $package_details->category_id;
                                    if ($service_category_lists):
                                    foreach ($service_category_lists as $key => $service_category):
                                    ?>
                                    <option value="<?php echo $service_category->service_cat_id; ?>" <?php if ($service_category->service_cat_id == $category_id) {
                                        echo 'selected';
                                    } ?>> <?php echo $service_category->category_name; ?></option>
                                    <?php endforeach;
                                    endif;
                                    ?>
                                </select>
								</div>
							</div>
                        <?php if($is_mobileapp_enabled == 'Y') { ?>
                            <div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('label946'); ?></label>
								</div>
								<div class="col-sm-9">
									<input class="form-control" style="width: 13px; height: 29px;" type="checkbox" name="mobile_enable" id="mobile_enable" autocomplete="off" <?php if($package_details->mobile_enable == 'Y'){ echo "checked"; }?> value="<?php if($package_details->mobile_enable == 'Y'){ echo "Y"; } else{ echo 'N'; }?>">
								</div>
                            </div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable1213'); ?></label>
								</div>
								<div class="col-sm-9">
									<input class="form-control" style="width: 13px; height: 29px;" type="checkbox" name="is_offer_enable_mobile_banner" id="is_offer_enable_mobile_banner" autocomplete="off" <?php if($package_details->is_offer_enable_mobile_banner == 'Y'){ echo "checked"; }?> value="<?php if($package_details->is_offer_enable_mobile_banner == 'Y'){ echo "Y"; } else{ echo 'N'; }?>">
								</div>
                            </div>
						<?php  } ?>	
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('label961'); ?></label>
								</div>
								<div class="col-sm-9">
									<input class="form-control" style="width: 13px; height: 29px;" type="checkbox" name="is_popular_service" id="is_popular_service" autocomplete="off" <?php if($package_details->is_popular_service == 'Y'){ echo "checked"; }?> value="<?php if($package_details->is_popular_service == 'Y'){ echo "Y"; } else{ echo 'N'; }?>">
								</div>
                            </div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable1240'); ?></label>
								</div>
								<div class="col-sm-9">
									<input class="form-control" style="width: 13px; height: 29px;" type="checkbox" name="subscription" id="subscription" autocomplete="off" <?php if($package_details->subscription == 'Y'){ echo "checked"; }?> value="<?php if($package_details->subscription == 'Y'){ echo "Y"; } else{ echo 'N'; }?>">
								</div>
                            </div>
                           	<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required" style="margin-right: 3px"> <?php _trans('lable19'); ?> *</label>
								</div>
								<div class="col-sm-9">
                           			<select name="status" id="status" class="bootstrap-select bootstrap-select-arrow g-input removeError">
	                           			<option value=""><?php _trans("lable285"); ?></option>
										<option value="A" <?php if ($package_details->status == "A") {echo "selected";} ?>>Active</option>
										<option value="I" <?php if ($package_details->status == "I") {echo "selected";} ?>>Inactive</option>
									</select>
								</div>
							</div>
							<div class="buttons text-center">
								<button value="1" name="btn_submit_basic" class="btn_submit_basic btn btn-rounded btn-primary btn-padding-left-right-40">
									<i class="fa fa-check"></i> <?php _trans('lable57'); ?>
								</button>
								<button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default">
									<i class="fa fa-times"></i> <?php _trans('lable58'); ?>
								</button>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade <?php echo $two_tab_active; ?>" id="tabs-2-tab-2">
							<div id="upload_section">
								<form class="uploadone" upload-id="upload_csv_add_one" id="upload_csv_add_one" method="post" enctype="multipart/form-data" autocomplete="off">
									<input type="hidden" name="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>" autocomplete="off">
									<div class="form-group clearfix">
										<div class="col-sm-3 text-right">
											<label class="control-label string required"><?php _trans('label950'); ?></label>
										</div>
										<div class="col-sm-2 paddingTop7px">
											<span class="text-center">
												<input type="file" name="iconfile[]" id="fileOne" onchange="getfile('fileOneLable')" class="inputfile">
												<input type="hidden" id="filehideone" name="filehideone" value="<?php echo $package_details->icon_image; ?>" autocomplete="off"/>
												<input type="hidden" id="fileoneinvalid" name="fileoneinvalid" value="<?php echo $package_details->icon_image?0:1; ?>" autocomplete="off"/>
												<label for="fileOne" class="btn_upload_icon btn btn-rounded btn-primary btn-padding-left-right-40"><?php _trans('lable594'); ?></label>
											</span>
										</div>
										<div class="col-sm-4 paddingTop7px">
											<?php $iconimage = $package_details->icon_image; ?>
											<?php $iconfileName = preg_split ('/[_,]+/', $iconimage); ?>
											<?php $iconname = $iconfileName[count($iconfileName)-1] ?>
								
											<div style="padding: 5px 18px;" id="fileOneLable">
											<span style="cursor: pointer">
												<a href="<?php echo base_url().$iconimage?>" target="_blank" ><?php echo $iconname; ?></a>
											</span>
											</div>
											<div id="showErrorone" class="errorColor" style="font-size: 14px;padding: 0% 5%;display:none;color: red"></div>
										</div>
									</div>
								</form>

								<form class="uploadtwo" upload-id="upload_csv_add_two" id="upload_csv_add_two" method="post" enctype="multipart/form-data" autocomplete="off">
								<input type="hidden" name="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>" autocomplete="off">
									<div class="form-group clearfix">
										<div class="col-sm-3 text-right">
											<label class="control-label string required"><?php _trans('label951'); ?></label>
										</div>
										<div class="col-sm-2 paddingTop7px">
											<span class="text-center">
												<input type="file" name="bannerfile[]" id="fileTwo" onchange="getfile('fileTwoLable')" class="inputfile">
												<input type="hidden" id="filehidetwo" name="filehidetwo" value="<?php echo $package_details->banner_image; ?>" autocomplete="off"/>
												<input type="hidden" id="filetwoinvalid" name="filetwoinvalid" value="<?php echo $package_details->banner_image?0:1; ?>" autocomplete="off"/>
												<label for="fileTwo" class="btn_upload_icon btn btn-rounded btn-primary btn-padding-left-right-40"><?php _trans('lable594'); ?></label>
											</span>
										</div>
										<div class="col-sm-4 paddingTop7px">
											<?php $bannerimage = $package_details->banner_image; ?>
											<?php $bannerfileName = preg_split ('/[_,]+/', $bannerimage); ?>
											<?php $bannername = $bannerfileName[count($bannerfileName)-1] ?>
												<div style="padding: 5px 18px;" id="fileTwoLable">
												<span style="cursor: pointer">
													<a href="<?php echo base_url().$bannerimage?>" target="_blank" ><?php echo $bannername; ?></a>
												</span>
												</div>
												<div id="showErrortwo" class="errorColor" style="font-size: 14px;padding: 0% 5%;display:none;color: red" ></div>
										</div>
									</div>
								</form>

								<div id="showError" class="errorColor" style="font-size: 14px;padding: 0% 40%;display:none;color: red" ><?php _trans('lable181'); ?></div>
								<div class="buttons text-center paddingTop20px">
										<button id="saveimage" class="btn btn-rounded btn-primary btn-padding-left-right-40">
											</i> <?php _trans('lable57'); ?>
										</button>
										<button id="btn_cancel_img" name="btn_cancel_img" class="btn btn-rounded btn-default">
											<?php _trans('lable58'); ?>
										</button>
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade <?php echo $three_tab_active; ?>" id="tabs-2-tab-3">
                        	<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable177'); ?> </label>
								</div>
								<div class="col-sm-9">
									<div class="summernote-theme-1">
									<textarea name="description" id="description" class="form-control summernote" name="name"><?php echo $package_details->description; ?></textarea>
									</div>
                                </div>
                        	</div>

                        	<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable248'); ?> </label>
								</div>
								<div class="col-sm-9">
									<div class="summernote-theme-1">
									<textarea name="short_desc" id="short_desc" class="summernote" name="name"><?php echo $package_details->short_desc; ?></textarea>
									</div>
                                </div>
                        	</div>

							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label style="padding-top: 0px ! important;"><?php _trans('label944'); ?></label>
								</div>
								<div class="col-sm-9 paddingLeftRight5px" style="padding: 0%;">
								<div class="multi-fields">
										<?php if(count($service_feature_list) > 0){  ?>
										<?php foreach ($service_feature_list as $value){?>
										<div class="multi-field col-lg-12 col-lg-12 col-sm-12 col-xs-12">
											<input type="hidden" name="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>" autocomplete="off">
											<input type="hidden" name="feature_id" class="feature_id" value="<?php echo $value->feature_id;?>" autocomplete="off">
											<input type="hidden" name="duplicate_feature_id" class="duplicate_feature_id" value="<?php echo $value->feature_id;?>" autocomplete="off">
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right" style="margin: 0px 0px 10px 0px;padding: 0px;">
												<input  type="text" name="column_name" class="column_name removeError form-control" value="<?php echo $value->name; ?>" autocomplete="off">
											</div>
											<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 paddingTop5px">
												<button type="button" class="remove_field"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
											</div>
										</div>
										<?php } }?>
										<div id="new_custom_row" class="col-sm-12" style="display: none;">				
											<input type="hidden" name="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>" autocomplete="off">
											<input type="hidden" name="feature_id" class="feature_id" autocomplete="off">
											<input type="hidden" name="duplicate_feature_id" class="duplicate_feature_id" autocomplete="off">
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right" style="margin: 0px 0px 10px 0px;padding: 0px;">
												<input type="text" name="column_name" class="column_name form-control" value="" autocomplete="off">
											</div>
											<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 paddingTop5px">
												<button type="button" class="remove-field"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
											</div>
										</div>
									</div>
									<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
										<button type="button" class="add-field"><i class="fa fa-plus-circle" aria-hidden="true"></i> <?php _trans('label970'); ?></button>
										<div id="showfeature" class="errorColor" style="font-size: 14px;display:none;color: red" ></div>
									</div>
								</div>
							</div>
                        	<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('label947'); ?> </label>
								</div>
								<div class="col-sm-9">
									<div class="summernote-theme-1">
										<textarea name="important_note" id="important_note" class="summernote" name="name"><?php echo $package_details->important_note; ?></textarea>
									</div>
                                </div>
                        	</div>
							<div class="buttons text-center">
								<button value="1" id="btn_feature" name="btn_submit_feature" class="btn_submit_feature btn btn-rounded btn-primary btn-padding-left-right-40">
									<i class="fa fa-check"></i> <?php _trans('lable57'); ?>
								</button>
								<button id="btn_cancel_fet" name="btn_cancel_fet" class="btn btn-rounded btn-default">
									<i class="fa fa-times"></i> <?php _trans('lable58'); ?>
								</button>
							</div>
                        </div>
                    	<div role="tabpanel" class="tab-pane fade <?php echo $four_tab_active; ?>" id="tabs-2-tab-4">
                        	<div class="form-group clearfix">
								<div class="col-sm-12"><?php _trans('label956'); ?>
								</div>
                        	</div>
                        	<div class="form-group clearfix">
								<div class="form-group clearfix">
									<div class="col-sm-12">
										<div class="row">
											<div id="checkinListDatas" class="col-lg-12 col-lg-12 col-sm-12 col-xs-12 paddingTop20px">
												<div class="row">
													<div class="multi-field col-lg-12 col-lg-12 col-sm-12 col-xs-12">
														<div class="form-group clearfix">
															<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text_align_left"><b><?php _trans('lable78'); ?></b></div>
															<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><b><?php _trans('lable878')?></b></div>
															<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right"><b><?php _trans('lable879')?></b></div>
														</div>
													</div>
												</div>
												<?php if(count($mech_vehicle_type) > 0){  
													
												$i = 1;
												foreach ($mech_vehicle_type as $checkInList) { 
													$hours = '';
													$cost = '';
													$default_cost = '';
													$sct_id = '';
													foreach($service_package_price_details as $serviceDetailsList){
														if($serviceDetailsList->mvt_id == $checkInList->mvt_id){  
															$sp_price_id = $serviceDetailsList->sp_price_id ;
															$hours = $serviceDetailsList->estimated_hour;
															$cost = $serviceDetailsList->service_cost;
														}
													}?>
																						
												<div class="row servicesCheckinListDatas" id="model_row_<?php echo $checkInList->mvt_id;?>">
													<div class="multi-field col-lg-12 colg-12 col-sm-12 col-xs-12">
														<div class="form-group clearfix">
															<input type="hidden" id="sp_price_id_<?php echo ($sp_price_id?$sp_price_id:"");?>"  name="sp_price_id" class="sp_price_id" value="<?php echo ($sp_price_id?$sp_price_id:"");?>">
															<input type="hidden" id="mvt_<?php echo $checkInList->mvt_id;?>"  name="mvt_id" class="mvt_id" value="<?php echo $checkInList->mvt_id;?>">
															<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text_align_left paddingTop7px"><?php echo $checkInList->vehicle_type_name; ?></div>
															<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
																<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text_align_left paddingTop7px text_align_right">hours&nbsp;&nbsp; </div>
																<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 ml_15px padding0px">
																	<input type="text" name="estimated_hour" id="estimated_hour_<?php echo ($checkInList->sp_price_id?$checkInList->sp_price_id:$i);?>" class="estimated_hour checkin_hours_<?php echo $checkInList->mvt_id; ?> text-center form-control" style="padding: 8px 4px;" value="<?php echo ($hours?$hours:1);?>">
																</div>
															</div>
															<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
																<input type="text" name="service_cost" id="service_cost_<?php echo ($checkInList->sp_price_id?$checkInList->sp_price_id:$i);?>" class="service_cost checkin_cost_<?php echo $checkInList->mvt_id; ?> form-control text_align_right twodigit" style="padding: 8px 4px;" value="<?php echo ($cost?$cost:$checkInList->default_cost);?>">
															</div>
														</div>
													</div>
												</div>
												<?php ++$i;} } ?>
											</div>
										</div>
						
									</div>
								</div>
                        	</div> 
                        	<div class="buttons text-center">
								<button value="1" name="btn_submit_price" class="btn_submit_price btn btn-rounded btn-primary btn-padding-left-right-40">
									<i class="fa fa-check"></i> <?php _trans('lable57'); ?>
								</button>
								<button id="btn_cancel_pr" name="btn_cancel_pr" class="btn btn-rounded btn-default">
									<i class="fa fa-times"></i> <?php _trans('lable58'); ?>
								</button>
                        	</div>
                        </div>
						<div role="tabpanel" class="tab-pane fade <?php echo $five_tab_active; ?>" id="tabs-2-tab-5">
                            <input class="hidden" name="is_update" type="hidden" autocomplete="off"
                            <?php if ($this->mdl_service_package->form_value('is_update')) { echo 'value="1"'; } else { echo 'value="0"'; }?>>
							<input type="hidden" name="offer_id" id="offer_id" class="offer_id" value="<?php echo $offer_details->offer_id;?>" autocomplete="off">
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required" style="margin-right: 3px"><?php _trans('lable361'); ?> *</label>
								</div>
								<div class="col-sm-9">
									<input class="form-control datepicker" type="text" name="start_date" id="start_date" value="<?php echo $offer_details->start_date?date_from_mysql($offer_details->start_date):date_from_mysql(date('Y-m-d')); ?>" autocomplete="off">
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required" style="margin-right: 3px"><?php _trans('lable630'); ?> *</label>
								</div>
								<div class="col-sm-9">
									<input class="form-control datepicker" type="text" name="end_date" id="end_date" value="<?php echo $offer_details->end_date?date_from_mysql($offer_details->end_date):date_from_mysql(date('Y-m-d')); ?>" autocomplete="off">
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required" style="margin-right: 3px"> <?php _trans('label967'); ?> *</label>
								</div>
								<div class="col-sm-9">
									<select name="offer_type" id="offer_type" class="bootstrap-select bootstrap-select-arrow g-input removeError">
										<option value=""><?php _trans("label968"); ?></option>
										<option value="A" <?php if ($offer_details->offer_type == 'A') {echo "selected";} ?>>Percentage</option>
										<option value="B" <?php if ($offer_details->offer_type == 'B') {echo "selected";} ?>>Rupee</option>
									</select>
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required" style="margin-right: 3px"><?php _trans('lable337'); ?> *</label>
								</div>
								<div class="col-sm-9">
									<input class="form-control" type="number" name="offer_rate" id="offer_rate" value="<?php echo $offer_details->offer_rate; ?>" autocomplete="off">
								</div>
							</div>
							<div class="buttons text-center">
								<button value="1" name="btn_submit_offer" class="btn_submit_offer btn btn-rounded btn-primary btn-padding-left-right-40">
									<i class="fa fa-check"></i> <?php _trans('lable57'); ?>
								</button>
								<button id="btn_cancel_off" name="btn_cancel_off" class="btn btn-rounded btn-default">
									<i class="fa fa-times"></i> <?php _trans('lable58'); ?>
								</button>
							</div>
						</div>

						<div role="tabpanel" class="tab-pane fade <?php echo $six_tab_active; ?>" id="tabs-2-tab-6">
							<?php $this->layout->load_view('service_packages/partial_service_table'); ?>
							<div class="buttons text-center">
								<button value="1" name="btn_submit_service" class="btn_submit_service btn btn-rounded btn-primary btn-padding-left-right-40">
									<i class="fa fa-check"></i> <?php _trans('lable57'); ?>
								</button>
								<button id="btn_cancel_ser" name="btn_cancel_ser" class="btn btn-rounded btn-default">
									<i class="fa fa-times"></i> <?php _trans('lable58'); ?>
								</button>
							</div> 
                        </div> 
						<div role="tabpanel" class="tab-pane fade <?php echo $seven_tab_active; ?>" id="tabs-2-tab-7">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box-typical car-box-panel">
							<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12" >
								<div class="col-lg-6 col-lg-6 col-sm-6 col-xs-12" style="padding-left: 0px;">
									<h4 style="margin-bottom: 0px;"><?php _trans('lable1243'); ?></h4>
								</div>
								<div class="col-lg-6 col-lg-6 col-sm-6 col-xs-12 text_align_right">
									<label class="switch">
									<input type="checkbox" class="checkbox" <?php if($package_details->subscription_account_checkbox == 1){ echo "checked"; } ?> name="checkbox" id="subscription_account_checkbox" value="<?php echo $package_details->subscription_account_checkbox; ?>" data-target="upload" autocomplete="off">
										<span class="slider round"></span>
									</label>
								</div>
							</div>
                        	<div class="collapse form-group clearfix <?php if($package_details->subscription_account_checkbox == 1){ echo "in"; } ?>" id="supscriptionAccountcollapse">
								<div class="form-group clearfix">
									<div class="col-sm-12">
										<div class="row">
											<div id="checkinListDatas" class="col-lg-12 col-lg-12 col-sm-12 col-xs-12 paddingTop20px">
												<div class="row">
													<div class="multi-field col-lg-12 col-lg-12 col-sm-12 col-xs-12">
														<div class="form-group clearfix">
															<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text_align_left"><b><?php _trans('lable873'); ?></b></div>
															<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text_align_center"><b><?php _trans('lable1244')?></b></div>
															<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text_align_center"><b><?php _trans('lable1245')?></b></div>
															<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text_align_center"><b><?php _trans('lable1246')?></b></div>
															<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text_align_center"><b><?php _trans('lable1247')?></b></div>
														</div>
													</div>
												</div>
												<?php if(count($mech_vehicle_type) > 0){  
												$i = 1;
												foreach ($mech_vehicle_type as $checkInList) { 
													$price = '';
													$default_cost = '';
													$sct_id = '';
													$schedule_type = ''; ?>																			
												<div class="row subscriptionCheckinListDatas" id="model_row_<?php echo $checkInList->mvt_id;?>">
													<div class="multi-field col-lg-12 colg-12 col-sm-12 col-xs-12">
														<div class="form-group clearfix">
															<input type="hidden" id="ps_id_<?php echo ($ps_id?$ps_id:"");?>"  name="ps_id" class="ps_id" value="<?php echo ($ps_id?$ps_id:"");?>">
															<input type="hidden" id="body_type_<?php echo $checkInList->mvt_id;?>"  name="body_type" class="body_type" value="<?php echo $checkInList->mvt_id;?>">
															<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text_align_left paddingTop7px"><?php echo $checkInList->vehicle_type_name; ?></div>
														<?php foreach($package_subscription_details as $subscriptionDetailsList){?>
															<?php if(($checkInList->mvt_id == $subscriptionDetailsList->body_type) && $subscriptionDetailsList->schedule_type=='D'){ 
																$ps_id = $subscriptionDetailsList->ps_id ;
																$body_type = $subscriptionDetailsList->body_type;
																$schedule_type = $subscriptionDetailsList->schedule_type;
																$dprice = $subscriptionDetailsList->price;
															}} ?>
															<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
															    <input type="hidden" name="daily" class="daily" value="<?php echo "D";?>">
																<input type="hidden" name="daily_aid" class="daily_aid" value="<?php echo $ps_id;?>">
																<input type="text" name="daily_price" id="price_<?php echo ($checkInList->ps_id?$checkInList->ps_id:$i);?>" class="price checkin_cost_<?php echo $checkInList->mvt_id; ?> form-control text_align_right twodigit" style="padding: 8px 4px;" value="<?php echo ($dprice?$dprice:$checkInList->default_cost);?>">
															</div>
														<?php foreach($package_subscription_details as $subscriptionDetailsList){?>
															<?php if(($checkInList->mvt_id == $subscriptionDetailsList->body_type) && $subscriptionDetailsList->schedule_type=='A'){  
																$ps_id = $subscriptionDetailsList->ps_id ;
																$body_type = $subscriptionDetailsList->body_type;
																$schedule_type = $subscriptionDetailsList->schedule_type;
																$aprice = $subscriptionDetailsList->price;
															}}?>
															<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
															    <input type="hidden"  name="alternative" class="alternative" value="<?php echo "A";?>">
																<input type="hidden" name="alternative_aid" class="alternative_aid" value="<?php echo $ps_id;?>">
																<input type="text" name="alternative_price" id="price_<?php echo ($checkInList->ps_id?$checkInList->ps_id:$i);?>" class="price checkin_cost_<?php echo $checkInList->body_type; ?> form-control text_align_right twodigit" style="padding: 8px 4px;" value="<?php echo ($aprice?$aprice:$checkInList->default_cost);?>">
															</div>
														<?php foreach($package_subscription_details as $subscriptionDetailsList){?>	
															<?php if(($checkInList->mvt_id == $subscriptionDetailsList->body_type) && $subscriptionDetailsList->schedule_type=='W'){  
																$ps_id = $subscriptionDetailsList->ps_id ;
																$body_type = $subscriptionDetailsList->body_type;
																$schedule_type = $subscriptionDetailsList->schedule_type;
																$wprice = $subscriptionDetailsList->price;
															}}?>
															<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
															    <input type="hidden"  name="weekly" class="weekly" value="<?php echo "W";?>">
																<input type="hidden" name="weekly_aid" class="weekly_aid" value="<?php echo $ps_id;?>">
																<input type="text" name="weekly_price" id="price_<?php echo ($checkInList->ps_id?$checkInList->ps_id:$i);?>" class="price checkin_cost_<?php echo $checkInList->body_type; ?> form-control text_align_right twodigit" style="padding: 8px 4px;" value="<?php echo ($wprice?$wprice:$checkInList->default_cost);?>">
															</div>
														<?php foreach($package_subscription_details as $subscriptionDetailsList){?>
															<?php if(($checkInList->mvt_id == $subscriptionDetailsList->body_type) && $subscriptionDetailsList->schedule_type=='M'){  
																$ps_id = $subscriptionDetailsList->ps_id ;
																$body_type = $subscriptionDetailsList->body_type;
																$schedule_type = $subscriptionDetailsList->schedule_type;
																$mprice = $subscriptionDetailsList->price;
															}}?>
															<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
															    <input type="hidden" name="monthly" class="monthly" value="<?php echo "M";?>">
																<input type="hidden" name="monthly_aid" class="monthly_aid" value="<?php echo $ps_id;?>">
																<input type="text" name="monthly_price" id="price_<?php echo ($checkInList->ps_id?$checkInList->ps_id:$i);?>" class="price checkin_cost_<?php echo $checkInList->body_type; ?> form-control text_align_right twodigit" style="padding: 8px 4px;" value="<?php echo ($mprice?$mprice:$checkInList->default_cost);?>">
															</div>
														</div>
													</div>
												</div>
												<?php ++$i;} } ?>
											</div>
										</div>
									</div>
								</div>
								<div class="buttons text-center">
									<button value="1" name="btn_submit_subscription" class="btn_submit_subscription btn btn-rounded btn-primary btn-padding-left-right-40">
										<i class="fa fa-check"></i> <?php _trans('lable57'); ?>
									</button>
									<button id="btn_cancel_subs" name="btn_cancel_subs" class="btn btn-rounded btn-default">
										<i class="fa fa-times"></i> <?php _trans('lable58'); ?>
									</button>
								</div>
                        	</div> 
                        </div>
						</div>	   
                    </div>
                </section>	
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/mp_backend/js/lib/summernote/summernote.min.js"></script>
<script type="text/javascript">

	$("#subscription_account_checkbox").click(function(){
		if($("#subscription_account_checkbox:checked").is(":checked")){
			$("#supscriptionAccountcollapse").addClass('in');
			$("#subscription_account_checkbox").val(1);
		}else{
			$("#supscriptionAccountcollapse").removeClass('in');
			$("#subscription_account_checkbox").val(0);
		}
	});

	var existing_service = [];
	var countofservice = [];

    $("#btn_cancel").click(function () {
        window.location.href = "<?php echo site_url('service_packages'); ?>";
	});

	$("#btn_cancel_img").click(function () {
        window.location.href = "<?php echo site_url('service_packages'); ?>";
	});
	$("#btn_cancel_fet").click(function () {
        window.location.href = "<?php echo site_url('service_packages'); ?>";
	});
	$("#btn_cancel_pr").click(function () {
        window.location.href = "<?php echo site_url('service_packages'); ?>";
	});
	$("#btn_cancel_off").click(function () {
        window.location.href = "<?php echo site_url('service_packages'); ?>";
	});
	$("#btn_cancel_ser").click(function () {
        window.location.href = "<?php echo site_url('service_packages'); ?>";
	});
	$("#btn_cancel_subs").click(function () {
        window.location.href = "<?php echo site_url('service_packages'); ?>";
	});

	$(".add-field").click(function(){

		$('#showfeature').hide();
		var add_mathround = parseInt(new Date().getTime() + Math.random());

		$('#new_custom_row').clone().appendTo('.multi-fields').removeAttr('id').addClass('multi-field').attr('id', 'tr_' + add_mathround).show();

		$('#tr_' + add_mathround + ' .feature_id').attr('id', "feature_id_" + add_mathround);

		$('#tr_' + add_mathround + ' .duplicate_feature_id').attr('id', "duplicate_feature_id_" + add_mathround);

		$('#tr_' + add_mathround + ' .column_name').attr('id', "column_name_" + add_mathround);

		$("#duplicate_feature_id_" + add_mathround).val(add_mathround);

	});

	$(document).on("click",".remove-field",function(){
		$(this).parent().parent().remove();
	});	

	$(document).on("click",".remove_field",function() {

		var feature_id = $(this).parent().parent().find('.feature_id').val();
		swal({
			title: "Are you sure?",
			text: "You will not be able to recover this imaginary file!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, delete it!",
			cancelButtonText: "No, cancel plx!",
			closeOnConfirm: false,
			closeOnCancel: false
		},
		function(isConfirm) {
			if (isConfirm) {
				$.post('<?php echo site_url('service_packages/ajax/deletefeatureData'); ?>', {
					feature_id : feature_id,
					_mm_csrf: $('input[name="_mm_csrf"]').val()
				}, function (data) {
					list = JSON.parse(data);
					if(list.success=='1'){
						swal({
							title: "The row is deleted successfully",
							text: "Your imaginary file has been deleted.",
							type: "success",
							confirmButtonClass: "btn-success"
						},function() {
							notie.alert(1, 'Successfully deleted', 2);
							window.location = "<?php echo site_url('service_packages/form'); ?>/"+"<?php echo $package_details->s_pack_id; ?>"+"/3";
						});
					}else{
						notie.alert(3, '<?php _trans('toaster2');?>', 2);
					}
				});
			} else {
				swal({
					title: "Cancelled",
					text: "Your imaginary file is safe :)",
					type: "error",
					confirmButtonClass: "btn-danger"
				});
			}
		});
	});

	function getfile(name)
	{
		if(name == 'fileOneLable'){
			var filename = $('input[name="iconfile[]"]').val().split("\\");
			$("#filehideone").val(filename[2]);
			$('#showErrorone').empty().append('');
			$('#showErrorone').hide();
			var fileNameone;
			var fileExtensionone;

			fileNameone = filename[2];
			fileExtensionone = fileNameone.replace(/^.*\./, '');

			if(fileExtensionone != 'jpeg' && fileExtensionone != 'JPEG' && 
			      fileExtensionone != 'png' && fileExtensionone != 'PNG' &&
               	  fileExtensionone != 'jpg' && fileExtensionone != 'JPG' &&
                  fileExtensionone != 'gif' && fileExtensionone != 'GIF' &&
                  fileExtensionone != 'tiff' && fileExtensionone != 'TIFF' &&
                  fileExtensionone != 'pdf' && fileExtensionone != 'PDF' &&
                  fileExtensionone != 'bmp' && fileExtensionone != 'BMP' &&
                  fileExtensionone != 'tif' && fileExtensionone != 'TIF' && fileExtensionone != ''){
					$('#showErrorone').empty().append('Invalid File Format');
					$('#fileoneinvalid').val(1);
					$('#showError').hide();
					$('#showErrorone').show();
			}else{
				$('#showErrorone').empty().append('');
				$('#showErrorone').hide();
				$('#fileoneinvalid').val(0);
			}

			$(".uploadone").submit();

		}else{
			var filename = $('input[name="bannerfile[]"]').val().split("\\");
			$("#filehidetwo").val(filename[2]);
			$('#showErrortwo').empty().append('');
			$('#showErrortwo').hide();
			var fileNametwo;
			var fileExtensiontwo;
			fileNametwo = filename[2];
			fileExtensiontwo = fileNametwo.replace(/^.*\./, '');

			if(fileExtensiontwo != 'jpeg' && fileExtensiontwo != 'JPEG' && 
			      fileExtensiontwo != 'png' && fileExtensiontwo != 'PNG' &&
               	  fileExtensiontwo != 'jpg' && fileExtensiontwo != 'JPG' &&
                  fileExtensiontwo != 'gif' && fileExtensiontwo != 'GIF' &&
                  fileExtensiontwo != 'tiff' && fileExtensiontwo != 'TIFF' &&
                  fileExtensiontwo != 'pdf' && fileExtensiontwo != 'PDF' &&
                  fileExtensiontwo != 'bmp' && fileExtensiontwo != 'BMP' &&
                  fileExtensiontwo != 'tif' && fileExtensiontwo != 'TIF' && fileExtensiontwo != ''){
					$('#showErrortwo').empty().append('Invalid File Format');
					$('#filetwoinvalid').val(1);
					$('#showError').hide();
					$('#showErrortwo').show();
				  }else{
					$('#showErrortwo').empty().append('');
					$('#showErrortwo').hide();
					$('#filetwoinvalid').val(0);
				  }

				$(".uploadtwo").submit();

		}

        $("#"+name).empty().append(filename[2]);
		$("#showError").hide();

	}

	$("#saveimage").click(function(){

		if($("#filehideone").val() == '' || $("#filehidetwo").val() == ''){
			$('#showError').empty().append('Please upload both files');
			$('#showError').show();
			return false;
		}else{
			if($("#fileoneinvalid").val() == '1'){
				$('#showErrorone').empty().append('Invalid File Format');
				$('#fileoneinvalid').val(1);
				$('#showError').hide();
				$('#showErrorone').show();
				return false;
			}else if($("#filetwoinvalid").val() == '1'){
				$('#showErrortwo').empty().append('Invalid File Format');
				$('#filetwoinvalid').val(1);
				$('#showError').hide();
				$('#showErrortwo').show();
				return false;
			}else{
				$('#showError').empty().append('');
				$('#showError').hide();
			}
		}
		notie.alert(1, '<?php _trans('toaster7'); ?>', 2);
		window.location = "<?php echo site_url('service_packages/form'); ?>/"+"<?php echo $package_details->s_pack_id; ?>"+"/3";

		});

    $("#mobile_enable").click(function(){
        if($("#mobile_enable:checked").is(":checked")){
            $("#mobile_enable").val('Y');
        }else{
            $("#mobile_enable").val('N');
        }
    });

	$("#is_offer_enable_mobile_banner").click(function(){
        if($("#is_offer_enable_mobile_banner:checked").is(":checked")){
            $("#is_offer_enable_mobile_banner").val('Y');
        }else{
            $("#is_offer_enable_mobile_banner").val('N');
        }
    });
	
	
	$("#is_popular_service").click(function(){
        if($("#is_popular_service:checked").is(":checked")){
            $("#is_popular_service").val('Y');
        }else{
            $("#is_popular_service").val('N');
        }
    });

	$("#subscription").click(function(){
        if($("#subscription:checked").is(":checked")){
            $("#subscription").val('Y');
        }else{
            $("#subscription").val('N');
        }
    });

$(".btn_submit_basic").click(function () {

    $('.border_error').removeClass('border_error');
    $('.has-error').removeClass('has-error');

    var validation = [];

    if($("#package_name").val() == ''){
        validation.push('package_name');
    }
	if($("#category_id").val() == ''){
        validation.push('category_id');
    }
    // if($("#mobile_enable").val() == ''){
    //     validation.push('mobile_enable');
    // }
	if($("#is_popular_service").val() == ''){
        validation.push('is_popular_service');
    }
    if($("#status").val() == ''){
        validation.push('status');
    }

    if(validation.length > 0){
        validation.forEach(function(val) {
            $('#'+val).addClass("border_error");
            $('#'+val).parent().addClass('has-error');
        });
        return false;
    }

    $('.border_error').removeClass('border_error');
    $('.has-error').removeClass('has-error');
    $('#gif').show();

    $.post('<?php echo site_url('service_packages/ajax/basic_create'); ?>', {
        
        s_pack_id : $("#s_pack_id").val(),
        package_name : $('#package_name').val(),
		category_id : $("#category_id").val(),
		mobile_enable : $("#mobile_enable").val(),
		is_offer_enable_mobile_banner : $("#is_offer_enable_mobile_banner").val(),
		is_popular_service : $("#is_popular_service").val(),
		subscription : $("#subscription").val(),
		url_key : $("#url_key").val(),
        status : $('#status').val(),
        btn_submit_basic : $(this).val(),
        _mm_csrf: $('input[name="_mm_csrf"]').val(),
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
            if(list.btn_submit_basic == '1'){
                setTimeout(function(){
                    window.location = "<?php echo site_url('service_packages/form'); ?>/"+list.s_pack_id+"/6";
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

$(".btn_submit_feature").click(function () {

	$('#showfeature').empty().append('');
	$('#showfeature').hide();

    $('.border_error').parent().removeClass('border_error');
	var featureArray = [];
	var validations = [];
	
	$(".multi-fields .multi-field").each(function(){
		var requestObj = {};
		requestObj.duplicate_feature_id = $(this).find(".duplicate_feature_id").val();
		requestObj.feature_id = $(this).find(".feature_id").val();
		requestObj.column_name = $(this).find(".column_name").val();
		featureArray.push(requestObj);
	});

	if(featureArray.length > 0){
		featureArray.forEach(function(val){
			if(val.column_name == ''){
				validations.push('column_name_'+val.duplicate_feature_id);
			}
		});
		$('#showfeature').empty().append('');
		$('#showfeature').hide();
	}
	
	// else{
	// 		$('#showfeature').empty().append('Please Add Features');
    //         $('#showfeature').show();
    //         return false;
	// }

	if(validations.length > 0){
        validations.forEach(function(val) {
			$('#'+val).parent().addClass('border_error');
        });
        return false;
    }

    $('.border_error').parent().removeClass('border_error');

	$('#gif').show();

    $.post('<?php echo site_url('service_packages/ajax/basic_create_feature'); ?>', {
        s_pack_id : $("#s_pack_id").val(),
        description : $('#description').val(),
        short_desc : $("#short_desc").val(),
        important_note : $('#important_note').val(),
		featureArray : JSON.stringify(featureArray),
        btn_submit_feature : $(this).val(),
        _mm_csrf: $('input[name="_mm_csrf"]').val(),
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
            if(list.btn_submit_feature == '1'){
                setTimeout(function(){
                    window.location = "<?php echo site_url('service_packages/form'); ?>/"+list.s_pack_id+"/4";
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


$(".btn_submit_price").click(function () {
	var serviceCostPriceList = [];
	$(".servicesCheckinListDatas .multi-field").each(function(){
		var requestObj = {};
		requestObj.sp_price_id  = $(this).find(".sp_price_id").val();
		requestObj.mvt_id = $(this).find(".mvt_id").val();
		requestObj.estimated_hour = $(this).find(".estimated_hour").val();
		requestObj.service_cost = $(this).find(".service_cost").val();
		serviceCostPriceList.push(requestObj);
	});

	if(serviceCostPriceList.length > 0){
		serviceCostPriceList.forEach(function(val) {
			if(val.estimated_hour == ''){
				$('#estimated_hour_'+val.sp_price_id).addClass("border_error");
				return false;
			}
			if(val.service_cost == ''){
				$('#service_cost_'+val.sp_price_id).addClass("border_error");
				return false;
			}
		});
	}

	$('#gif').show();

	$.post('<?php echo site_url('service_packages/ajax/mech_package_subscription_create'); ?>', {
		s_pack_id : $("#s_pack_id").val(),
		serviceCostPriceList : JSON.stringify(serviceCostPriceList),
		_mm_csrf: $('input[name="_mm_csrf"]').val(),
	}, function (data) {
		list = JSON.parse(data);
		if(list.success=='1'){
			notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
			setTimeout(function(){
				window.location = "<?php echo site_url('service_packages'); ?>";
			}, 100);
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

$(".btn_submit_subscription").click(function () {

	var packagesubscriptionList = [];
	$(".subscriptionCheckinListDatas .multi-field").each(function(){

	var requestObj = {};
	$(this).find('input,select,textarea').each(function() {
		if ($(this).is(':checkbox')) {
			requestObj[$(this).attr('name')] = $(this).is(':checked');
		} else {
			if($(this).val() != '' && $(this).val() != null && $(this).val() != undefined){
				requestObj[$(this).attr('name')] = $(this).val().replace(/,/g, '');
			}
		}
	});
	if(requestObj){
		if(requestObj.ps_id != "0" && requestObj.ps_id != 0){
			packagesubscriptionList.push(requestObj);
		}
	}
		// var requestObj = {};
		// requestObj.ps_id  = $(this).find(".ps_id").val();
		// requestObj.body_type = $(this).find(".body_type").val();
		// requestObj.schedule_type = $(this).find(".schedule_type").val();
		// requestObj.price = $(this).find(".price").val();
		// packagesubscriptionList.push(requestObj);
	});

	if(packagesubscriptionList.length > 0){
		packagesubscriptionList.forEach(function(val) {
			if(val.schedule_type == ''){
				$('#schedule_type_'+val.ps_id).addClass("border_error");
				return false;
			}
			if(val.price == ''){
				$('#price_'+val.ps_id).addClass("border_error");
				return false;
			}
		});
	}

	$('#gif').show();

	$.post('<?php echo site_url('service_packages/ajax/mech_package_subscription_create'); ?>', {
		s_pack_id : $("#s_pack_id").val(),
		packagesubscriptionList : JSON.stringify(packagesubscriptionList),
		subscription_account_checkbox : $("#subscription_account_checkbox").val(),
		_mm_csrf: $('input[name="_mm_csrf"]').val(),
	}, function (data) {
		list = JSON.parse(data);
		if(list.success=='1'){
			notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
			setTimeout(function(){
				window.location = "<?php echo site_url('service_packages'); ?>";
			}, 100);
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

$(".btn_submit_offer").click(function () {

	$('.border_error').removeClass('border_error');
	$('.has-error').removeClass('has-error');

	var validation = [];

	if($("#start_date").val() == ''){
		validation.push('start_date');
	}
	if($("#end_date").val() == ''){
		validation.push('end_date');
	}	
	if($("#offer_type").val() == ''){
		validation.push('offer_type');
	}
	if($("#offer_rate").val() == ''){
		validation.push('offer_rate');
	}

	if(validation.length > 0){
		validation.forEach(function(val) {
			$('#'+val).addClass("border_error");
			$('#'+val).parent().addClass('has-error');
		});
		return false;
	}


	$('.border_error').removeClass('border_error');
	$('.has-error').removeClass('has-error');
	$('#gif').show();

	$.post('<?php echo site_url('service_packages/ajax/offer_create'); ?>', {
		offer_id : $("#offer_id").val(),
		s_pack_id : $("#s_pack_id").val(),
		start_date : $("#start_date").val(),
		end_date : $("#end_date").val(),
		offer_type : $("#offer_type").val( ),
		offer_rate : $('#offer_rate').val(),
		url_key : $("#url_key").val(),
		btn_submit_offer : $(this).val(),
		_mm_csrf: $('input[name="_mm_csrf"]').val(),
	}, function (data) {	
		list = JSON.parse(data); 
		if(list.success=='1'){
			notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
			if(list.btn_submit_offer == '1'){
				setTimeout(function(){
					window.location = "<?php echo site_url('service_packages/form'); ?>/"+list.s_pack_id+"/5";
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

$(".btn_submit_service").click(function () {

		var existing_service_ids = [];
		$('table#service_item_table tbody>tr.item').each(function() {
			var service_row = {};
			$(this).find('input,select,textarea').each(function() {
					if ($(this).is(':checkbox')) {
						service_row[$(this).attr('name')] = $(this).is(':checked');
					} else {
						service_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
					}
			});
			if(service_row){
				if(service_row.item_msim_id != "0" && service_row.item_msim_id != 0){
					existing_service_ids.push(service_row);
				}
			}
		});

		$('#gif').show();
		$.post('<?php echo site_url('service_packages/ajax/basic_service_create'); ?>', {
			s_pack_id : $("#s_pack_id").val(),
			existing_service_ids: JSON.stringify(existing_service_ids),
			_mm_csrf: $('input[name="_mm_csrf"]').val(),
		}, function (data) {	
			list = JSON.parse(data);
			if(list.success=='1'){
				notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
				setTimeout(function(){
					window.location = "<?php echo site_url('service_packages/form'); ?>/"+list.s_pack_id+"/2";
				}, 100);
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

$(document).ready(function() {

    $('.summernote').summernote(); 

	$("#service_item_table .item_msim_id").each(function (index) {
		var service_row_id = $(this).parent().parent().attr("id");		
		if (service_row_id) {
			if($("#"+service_row_id+" .item_msim_id").val()){
				existing_service.push(parseInt($("#"+service_row_id+" .item_msim_id").val()));
			}
		}
	});
	

    $(document).on('submit', ".uploadone", function (e) {

		$('#showError').empty().append('');
		$('#showError').hide();

		$('#showErrorone').empty().append('');
		$('#showErrorone').hide();
		
		var attr_name = $(this).attr("upload-id");
		var forImg = this;

		var fileNameone;
		var fileExtensionone;
		fileNameone = $("#fileOne").val();
		fileExtensionone = fileNameone.replace(/^.*\./, '');

		e.preventDefault();
		e.stopPropagation ();

		if(fileExtensionone != 'jpeg' && fileExtensionone != 'JPEG' && 
				fileExtensionone != 'png' && fileExtensionone != 'PNG' &&
				fileExtensionone != 'jpg' && fileExtensionone != 'JPG' &&
				fileExtensionone != 'gif' && fileExtensionone != 'GIF' &&
				fileExtensionone != 'tiff' && fileExtensionone != 'TIFF' &&
				fileExtensionone != 'pdf' && fileExtensionone != 'PDF' &&
				fileExtensionone != 'bmp' && fileExtensionone != 'BMP' &&
				fileExtensionone != 'tif' && fileExtensionone != 'TIF' && fileExtensionone != ''){
				$('#showErrorone').empty().append('Invalid File Format');
				$('#showError').hide();
				$('#showErrorone').show();
				return false;
				}else{
				$('#showErrorone').empty().append('');
				$('#showErrorone').hide();
				}
		
		$('#gif').show();

		$.ajax({
			url : "<?php echo site_url('upload/upload/upload_multiple_file/'.$package_details->s_pack_id."/SP/".$servicepack_url_key); ?>/",
			method:"POST",
			data : new FormData(this),
			contentType:false,
			cache:false,
			processData:false,
			success: function(data){
				var response = JSON.parse(data);
				if(response.success=='1'){
					window.location = "<?php echo site_url('service_packages/form'); ?>/"+response.s_pack_id+"/2";
				}else{
					$('#gif').hide();
					$('#showError').empty().append('invalid file format');
					$('#showError').show();
				}
			}
		});
	});

	$(document).on('submit', ".uploadtwo", function (e) {

		$('#showError').empty().append('');
		$('#showError').hide();

		$('#showErrortwo').empty().append('');
		$('#showErrortwo').hide();

		var attr_name = $(this).attr("upload-id");
		var forImg = this;

		var fileNametwo;
		var fileExtensiontwo;
		fileNametwo = $("#fileTwo").val();
		fileExtensiontwo = fileNametwo.replace(/^.*\./, '');

		e.preventDefault();
		e.stopPropagation ();

		if(fileExtensiontwo != 'jpeg' && fileExtensiontwo != 'JPEG' && 
			fileExtensiontwo != 'png' && fileExtensiontwo != 'PNG' &&
			fileExtensiontwo != 'jpg' && fileExtensiontwo != 'JPG' &&
			fileExtensiontwo != 'gif' && fileExtensiontwo != 'GIF' &&
			fileExtensiontwo != 'tiff' && fileExtensiontwo != 'TIFF' &&
			fileExtensiontwo != 'pdf' && fileExtensiontwo != 'PDF' &&
			fileExtensiontwo != 'bmp' && fileExtensiontwo != 'BMP' &&
			fileExtensiontwo != 'tif' && fileExtensiontwo != 'TIF' && fileExtensiontwo != ''){
				$('#showErrortwo').empty().append('Invalid File Format');
				$('#showError').hide();
				$('#showErrortwo').show();
				return false;
				}else{
				$('#showErrortwo').empty().append('');
				$('#showErrortwo').hide();
				}

		$('#gif').show();

		$.ajax({
			url : "<?php echo site_url('upload/upload/upload_multiple_file/'.$package_details->s_pack_id."/SP/".$servicepack_url_key); ?>/",
			method:"POST",
			data : new FormData(this),
			contentType:false,
			cache:false,
			processData:false,
			success: function(data){
				var response = JSON.parse(data);
				if(response.success=='1'){
					window.location = "<?php echo site_url('service_packages/form'); ?>/"+response.s_pack_id+"/2";
				}else{
					$('#gif').hide();
					$('#showError').empty().append('invalid file format');
					$('#showError').show();
				}
			}
		});
	});

});


function remove_service_pack_items(item_id, row_id) {
	swal({
	title: "Are you sure?",
	text: "You will not be able to recover this item!",
	type: "warning",
	showCancelButton: true,
	confirmButtonClass: "btn-danger",
	confirmButtonText: "Yes, delete it!",
	cancelButtonText: "No, cancel plx!",
	closeOnConfirm: false,
	closeOnCancel: false
	},
	function(isConfirm) {
		if (isConfirm) {
			remove_service(item_id,row_id);
			var existing_service_ids = [];
			$('table#service_item_table tbody>tr.item').each(function() {
				var service_row = {};
				$(this).find('input,select,textarea').each(function() {
					if ($(this).is(':checkbox')) {
						service_row[$(this).attr('name')] = $(this).is(':checked');
					} else {
						service_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
					}
				});
				if(service_row){
					if(service_row.item_msim_id != "0" && service_row.item_msim_id != 0){
						existing_service_ids.push(service_row);
					}
				}
			});

			$.post('<?php echo site_url('service_packages/ajax/basic_service_create'); ?>', {
				s_pack_id : $("#s_pack_id").val(),
				existing_service_ids: JSON.stringify(existing_service_ids),
				_mm_csrf: $('input[name="_mm_csrf"]').val(),
			},function(data) {
				var response = JSON.parse(data);
				if (response.success === 1) {
					swal({
						title: "The row is deleted successfully",
						text: "Item has been deleted.",
						type: "success",
						confirmButtonClass: "btn-success"
					},
					function() {
						setTimeout(function() {
							window.location = "<?php echo site_url('service_packages/form'); ?>/"+response.s_pack_id+"/6";
						}, 1000);
					});
				} else {
					notie.alert(3, 'Error.', 2);
				}
			});
		} else {
			swal({
			title: "Cancelled",
			text: "Your imaginary file is safe :)",
			type: "error",
			confirmButtonClass: "btn-danger"
			});
		}
	});
}

function remove_service(service_id, service_row_id){
	for( var i = 0; i < existing_service.length; i++){ 
		if ( existing_service[i] == service_id) {
			existing_service.splice(i, 1); 
		}
	}
	$("#service_item_table #tr_"+service_row_id).remove();

	var renumpro = 1;
	$("#service_item_table tr td.item_sno").each(function() {
		$(this).text(renumpro);
		renumpro++;
	});

	$('.addservice').attr('data-existing_service_ids', '');
	var existing_service_ids = existing_service.toString();
	$("#existing_service_ids").val(existing_service_ids);
	$('.addservice').attr('data-existing_service_ids', existing_service_ids);
}

function emptyallfield(service_row_id){
    var last_item_row = $('#service_item_table tbody>#tr_'+service_row_id);
    last_item_row.find('input').attr('id', service_row_id);
}

function popupservices(serviceList){
	var newarray = [];
	if(serviceList != '' && serviceList != undefined){
		if(serviceList.length > 0){
			for(var i = 0 ; i < serviceList.length; i++){
				if(jQuery.inArray(parseInt(serviceList[i].msim_id), existing_service) !== -1){
					newarray.push(parseInt(serviceList[i].msim_id));
				}
			}
			var newArrays=$.merge($(existing_service).not(newarray).get(),$(newarray).not(existing_service).get());
			if(newArrays.length > 0){
				for(v = 0; v < newArrays.length; v++){
					var row_id = $("#duplicate_id_"+ newArrays[v] ).parent().parent().attr("id");
					if(row_id != '' && row_id != undefined && row_id != null){
						var pd_row_id = row_id.split('_');
						var rowdupid = pd_row_id[pd_row_id.length - 1];
						remove_service(newArrays[v] , rowdupid);
					}
				}
			}
			for(var i = 0; i < serviceList.length; i++){
				if(!existing_service.includes(parseInt(serviceList[i].msim_id))){
					existing_service.push(parseInt(serviceList[i].msim_id));
					countofservice = $.grep(existing_service, function (elem) {
						return elem === serviceList[i].msim_id;
					}).length;
					if (countofservice <= 1) {
						var servicename = serviceList[i].service_item_name;
						var add_mathround = parseInt(new Date().getTime() + Math.random());
						var next_row_id = $("#service_item_table > tbody > tr").length;
						$('#new_service_row').clone().appendTo('#service_item_table').removeAttr('id').addClass('item').attr('id', 'tr_' + add_mathround).show();
						$('#tr_' + add_mathround + ' .item_sno').attr('id', "item_sno_" + add_mathround);
						$('#tr_' + add_mathround + ' .duplicate_id').attr('id', "duplicate_id_" + serviceList[i].msim_id);
						$('#tr_' + add_mathround + ' .item_msim_id').attr('id', "item_msim_id_" + add_mathround);
						$('#tr_' + add_mathround + ' .item_service_name').attr('id', "item_service_name_" + add_mathround);
						$('#tr_' + add_mathround + ' .remove_added_item').attr('id', "remove_added_item_" + add_mathround);
						$("#duplicate_id_"+serviceList[i].msim_id).val(serviceList[i].msim_id);
						$("#item_msim_id_"+add_mathround).val(serviceList[i].msim_id);
						$("#item_service_name_"+add_mathround).val(serviceList[i].service_item_name);
						var last_item_row = $('#service_item_table tbody>#tr_' + add_mathround);
						last_item_row.find('.remove_added_item').attr('onclick', 'remove_service("'+serviceList[i].msim_id+'","' + add_mathround + '")');
					}
				}
			}
		}
	}else{
		$('#service_item_table tbody tr.item').remove();
	}
	
	var renumpro = 1;
	$("#service_item_table tr td.item_sno").each(function() {
		$(this).text(renumpro);
		renumpro++;
	});

	$('.addservice').attr('data-existing_service_ids', '');
	var existing_service_ids = existing_service.toString();
	$("#existing_service_ids").val(existing_service_ids);
	$('.addservice').attr('data-existing_service_ids', existing_service_ids);
}

</script>