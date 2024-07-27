<link href="<?php echo base_url(); ?>assets/mp_backend/css/main.css" rel="stylesheet">
<script type="text/javascript">
$(function(){
	$("#btn-cancel").click(function(){
        window.location.href = "<?php echo site_url('packages/service_packages_index'); ?>";
    });
});
</script>
<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php  _trans('lable539'); ?></h3>
				</div>
				<div class="tbl-cell pull-right">
					<a class="btn btn-sm btn-primary" href="<?php echo site_url('packages/service_packages'); ?>">
                        <i class="fa fa-plus"></i> <?php _trans('lable40'); ?>
                    </a>
				</div>
			</div>
		</div>
	</div>
</header>
            <div class="row">
                <div class="col-xs-12 top-15">
                    <a class="anchor anchor-back" href="<?php echo site_url('packages/service_packages_index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
                </div>
            </div>
            <div class="container-fluid usermanagement">
	            <div class="paddingTop22px">
                    <section class="card col-xl-12 col-lg-11 col-md-10 col-sm-12 col-xs-12 col-centered">
                      <div class="row padding20px">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-left">
                                <div class="form_group clearfix paddingTop10px" >
                                    <div class="col-lg-6 col-md-6 col-sm-6  col-xs-12 text_align_right"><?php  _trans('lable545'); ?>:</div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text_align_left">                  
                                                <?php echo $service_packages_details->service_package_name; ?>
                                        </div>
                                </div>
                                <div class="form_group clearfix paddingTop10px">
                                <div class="col-lg-6 col-md-6 col-sm-6  col-xs-12 text_align_right"><?php  _trans('lable78'); ?> :</div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text_align_left">                  
                                             <?php echo $service_packages_details->vehicle_type_name; ?>
                                        </div>
                                </div>
				                <div class="form_group clearfix paddingTop10px">
                                    <div class="col-lg-6 col-md-6 col-sm-6  col-xs-12 text_align_right"><?php  _trans('lable239'); ?> :</div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text_align_left">
                                        <?php echo $service_packages_details->category_name; ?>
                                        </div>	
				                </div>
                                <div class="form_group clearfix paddingTop10px">
                                    <div class="col-lg-6 col-md-6 col-sm-6  col-xs-12 text_align_right"><?php  _trans('lable249'); ?> :</div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-sm-8 col-xs-12 text_align_left">
                                            <?php echo $service_packages_details->service_item_name; ?>
                                            </div>
                                </div>
                                <div class="form_group clearfix paddingTop10px">
                                    <div class="col-lg-6 col-md-6 col-sm-6  col-xs-12 text_align_right"><?php  _trans('lable543'); ?> :</div>
                                         <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text_align_left">
                                             <?php echo $service_packages_details->offer_start_date?date_from_mysql($service_packages_details->offer_start_date):date('d/m/Y');?>
                                         </div>
				                 </div>
                                <div class="form_group clearfix paddingTop10px">
                                    <div class="col-lg-6 col-md-6 col-sm-6  col-xs-12 text_align_right"><?php  _trans('lable542'); ?> :</div>
                                          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text_align_left">
                                            <?php echo $service_packages_details->offer_end_date?date_from_mysql($service_packages_details->offer_end_date):date('d/m/Y');?>
                                         </div>
				                </div>
                        </div>
                        <?php if($service_packages_details->apply_for_all_bmv == 'Y'){ 
                            $showhide = 'style="display:none"';
                        }else{
                            $showhide = 'style="display:block"';
                        }?>
                        <div class="row modelandvariants" <?php echo $showhide; ?> >

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-left">
                                <div class="form_group clearfix paddingTop10px">
                                    <div class="col-lg-6 col-md-6 col-sm-6  col-xs-12 text_align_right"><?php  _trans('lable229'); ?> :</div>
                                        <div class="col-lg-6 col-md-6 col-sm-6class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left">
                                            <?php echo $service_packages_details->brand_name; ?>
                                        </div>	
                                </div>
					            <div class="form_group clearfix paddingTop10px">
                                    <div class="col-lg-6 col-md-6 col-sm-6  col-xs-12 text_align_right"><?php  _trans('lable231'); ?> :</div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text_align_left">
                                            <?php echo $service_packages_details->model_name; ?>
                                        </div>	
				                </div>
                        <div class="row modelandvariants" <?php echo $showhide; ?> >
					        <div class="form_group clearfix paddingTop10px">
                                <div class="col-lg-6 col-md-6 col-sm-6  col-xs-12 text_align_right"><?php  _trans('lable263'); ?> :</div>
                                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text_align_left">
                                        <?php echo $service_packages_details->variant_name; ?>
                                    </div>
                            </div>
                        </div>
						<div class="form_group clearfix paddingTop10px">
                            <div class="col-lg-6 col-md-6 col-sm-6  col-xs-12 text_align_right"><?php  _trans('lable268'); ?> :</div>
        					    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text_align_left">
								<?php echo $service_packages_details->service_product_total_price; ?>
							    </div>
						</div>
						<div class="form_group clearfix paddingTop10px">
                            <div class="col-lg-6 col-md-6 col-sm-6  col-xs-12 text_align_right"><?php  _trans('lable177'); ?> :</div>
        					    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text_align_left">
									<?php echo $service_packages_details->service_package_description; ?>
							    </div>
                        </div>
                    </div>    
						
					</div>
				</div>
                        <div class="buttons text-center padding20px hideSubmitButtons">
							<button id="btn-cancel" name="btn-cancel" class="btn btn-rounded btn-default" value="1">
								<i class="fa fa-times"></i>  <?php _trans('lable58'); ?> 
							</button>
						</div>
            </section>
        </div>
    </div>
