<?php $dataCount = 0; foreach($mech_lead_status as $key => $mls){ 
	if($mls->mech_leads){
		$dataCount = 1;
	}
} 
if($dataCount < 1){ ?>
<script type="text/javascript">
    $(function() {
        var getHeight = $( window ).height();
        $(".imageDynamicHeight").css('height' , getHeight - 200);
    });
</script>
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center imageDynamicHeight" style="display: table;">
    <div class="tbl-cell">
        <img style="width: 30%; text-center" src="<?php echo base_url(); ?>assets/mp_backend/img/no_data_available.jpg" alt="Mechtoolz">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
			<a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_leads/form'); ?>">
				<i class="fa fa-plus"></i> <?php _trans('label933'); ?>
			</a>
        </div>
    </div>
</div>
<?php } else {  ?>
<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php _trans('menu9'); ?></h3>
				</div>
				<div class="tbl-cell pull-right">
					<a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_leads/form'); ?>">
           	 			<i class="fa fa-plus"></i> <?php _trans('lable40'); ?>
        			</a>
        		</div>
			</div>
		</div>
	</div>
</header>
<div id="content" class="table-content">
	<div class="row col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 overflow_y_scroll">
		<div id="testDiv" class="row displayinlineFlex paddingLeft15px">
			<?php foreach($mech_lead_status as $key => $mls){ 
			if($mls->mech_leads){ ?>
			<div class="col-xl-3 col-lg-3 col-md-4 col-sm-5 col-12 padding0px minWidth200px">
				<?php if($key != 0){ ?>
				<h5 class="leadHeaderRow">
					<span class="width10per float_left"><img class="imge" src="<?php echo base_url(); ?>assets/mp_backend/img/right-arrow.png"></span>
					<span class="headerTextCus"><?php echo $mls->status_label;?></span>
				</h5>
				<?php } else{ ?>
				<h5 class="leadHeaderRowTwo">
					<span class="headerTextCus"><?php echo $mls->status_label;?></span>
				</h5>
				<?php } ?>
				<div class="contentheight leadHorizontalScroll">
					<div class="leadSizedBox">
						<?php foreach($mls->mech_leads as $ml){ 
						if($ml->lead_status == $mls->mlstatus_id){ ?>
						<div class="margin-bottom-10px leadSizedBoxImage">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 summaryBox">
								<div class="summaryBoxContent">
									<div class="summaryBoxContentImage">
										<span class="summaryBoxContentSpanBoxTwo">
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 padding0px"><span class="leadspanBoxtwoContent"><?php echo ($ml->leads_no?$ml->leads_no:"Lead Number"); ?></span> </div>
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 padding0px"><span class="leadspanBoxtwoContent car_reg_no cardFontColor"><?php echo ($ml->client_name?$ml->client_name:"customer Name"); ?></span> <span class="cardFontColor"><?php echo ($ml->client_contact_no?" - ".$ml->client_contact_no:""); ?></span></div>
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 padding0px paddingTop10px">
												<span class="iconColor text_align_left mR5"><a data-original-title="Convert To Appointment" data-toggle="tooltip" href="<?php echo site_url('mech_leads/convert_to_appointment/'.$ml->ml_id); ?>"><i class="fa fa-calendar-check-o" aria-hidden="true"></i></a></span>
												<?php	if($this->session->userdata('workshop_is_enabled_jobsheet') == 'Y'){
														foreach($permission as $perlist){
														if($perlist->module_name == "jobs"){ ?>
												<span class="iconColor text_align_left mR5"><a data-original-title="Job Card" data-toggle="tooltip" href="<?php echo site_url('mech_leads/convert_to_jobcard/'.$ml->ml_id); ?>"><i class="fa fa-car" aria-hidden="true"></i></a></span>
												<?php }}} foreach($permission as $perlist){
													if($perlist->module_name == "invoice"){ ?>
												<span class="iconColor text_align_left mR5"><a data-original-title="Convert To Invoice" data-toggle="tooltip" href="<?php echo site_url('mech_leads/convert_to_invoice/'.$ml->ml_id); ?>"><i class="fa fa-money" aria-hidden="true"></i></a></span>
												<?php }} ?>
												<span class="iconColor text_align_left mR5"><a data-original-title="Edit" data-toggle="tooltip" href="<?php echo site_url('mech_leads/form/'.$ml->ml_id); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></span>
												<span class="iconColor text_align_left mR5"><a data-original-title="View" data-toggle="tooltip" href="<?php echo site_url('mech_leads/view/'.$ml->ml_id); ?>"><i class="fa fa-eye" aria-hidden="true"></i></a></span>
												<span class="iconColor text_align_left mR5"><a data-original-title="Delete" data-toggle="tooltip" href="javascript:void(0)" onclick="delete_record('mech_leads',<?php echo $ml->ml_id; ?>, '<?= $this->security->get_csrf_hash() ?>')" > <i class="fa fa-trash-o fa-margin"></i></a><span>
												<span class="iconColor font_12 float_right"> <?php if($ml->reschedule_date != "" && $ml->reschedule_date != "0000-00-00 00:00:00"){echo date("d-m-Y", strtotime($ml->reschedule_date));} ?></span>
											</div>
										</span>
									</div>
								</div>
							</div>
						</div>
						<?php }} ?>
					</div>
				</div>
			</div>
			<?php } } ?>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		var contentheight = window.screen.height-300;
		$(".contentheight").css("height",contentheight);
	});
</script>

<?php } ?>