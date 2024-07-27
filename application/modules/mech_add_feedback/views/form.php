
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
			</div>
		</div>
	</div>
</header>
<?php if (isset($active_tab)) {
    if ($active_tab == 1) {
        $one_tab_active = 'active show in';
        $two_tab_active = '';
        $one_area_selected = true;
        $two_area_selected = false;
    } elseif ($active_tab == 2) {
        $one_tab_active = '';
        $two_tab_active = 'active show in';
		$one_area_selected = false;
        $two_area_selected = true;
    } 
	
} else {
    $one_tab_active = 'active show in';
    $two_tab_active = '';
    $one_area_selected = true;
    $two_area_selected = false;
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
			<a class="anchor anchor-back" href="<?php echo site_url('mech_add_feedback/index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
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
						<?php if($feedback_details->fb_id) { ?>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $two_tab_active; ?>" href="#tabs-2-tab-2" role="tab" data-toggle="tab" aria-selected="<?php echo $two_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable494'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>
						<?php } else { ?>
						<li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable494'); ?></span>
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
						<?php if($feedback_details->fb_id) { ?>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $two_tab_active; ?>" href="#tabs-2-tab-2" role="tab" data-toggle="tab" aria-selected="<?php echo $two_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable494'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>
						<?php } else { ?>
						<li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable494'); ?></span>
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
			<input type="hidden" id="fb_id" name="fb_id" value="<?php echo $feedback_details->fb_id;?>" >
            <input type="hidden" name="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>" autocomplete="off">
				<section class="tabs-section" >
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade <?php echo $one_tab_active; ?>" id="tabs-2-tab-1">
                            <input class="hidden" name="is_update" type="hidden" autocomplete="off">
							<div class="col-sm-12 col-lg-12 col-md-12 text-center"><h6 class="popupsplit"><?php _trans('lable415'); ?></h6></div>
                            <div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable416'); ?> :</label>
								</div>
								<div class="col-sm-9 paddingTop7px" style="padding-left: 1px;">
									<?php if($feedback_details->technician_ratting == "P"){ echo _trans('lable410');  } ?>
									<?php if($feedback_details->technician_ratting == "G"){ echo _trans('lable411');  } ?>
									<?php if($feedback_details->technician_ratting == "VG"){ echo _trans('lable412'); } ?>
									<?php if($feedback_details->technician_ratting == "E"){ echo _trans('lable413');  } ?>  
								</div>
							</div>
							<div class="col-sm-12 col-lg-12 col-md-12" style="padding: 0px 25%;">
							<?php echo $feedback_details->technician_description; ?>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable417'); ?> :</label>
								</div>
								<div class="col-sm-9 paddingTop7px" style="padding-left: 1px;">
								    <?php if($feedback_details->service_rating == "P"){ echo _trans('lable410');  } ?>
									<?php if($feedback_details->service_rating == "G"){ echo _trans('lable411');  } ?>
									<?php if($feedback_details->service_rating == "VG"){ echo _trans('lable412'); } ?>
									<?php if($feedback_details->service_rating == "E"){ echo _trans('lable413');  } ?>  
								</div>
							</div>
							<div class="col-sm-12 col-lg-12 col-md-12" style="padding: 0px 25%;">
							<?php echo $feedback_details->service_description; ?>
							</div>
							<div class="col-sm-12 col-lg-12 col-md-12 text-center"><h6 class="popupsplit"><?php _trans('lable418'); ?></h6></div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable419'); ?> :</label>
								</div>
								<div class="col-sm-9 paddingTop7px" style="padding-left: 1px;">
								    <?php if($feedback_details->customer_rating == "P"){ echo _trans('lable410');  } ?>
									<?php if($feedback_details->customer_rating == "G"){ echo _trans('lable411');  } ?>
									<?php if($feedback_details->customer_rating == "VG"){ echo _trans('lable412'); } ?>
									<?php if($feedback_details->customer_rating == "E"){ echo _trans('lable413');  } ?>  								
								</div>
                        	</div>
							<div class="col-sm-12 col-lg-12 col-md-12" style="padding: 0px 25%;">
							<?php echo $feedback_details->customer_description; ?>
							</div>
							<br><br>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required" style="margin-right: 3px"> <?php _trans('lable19'); ?> *</label>
								</div>
								<div class="col-sm-9">
                           			<select name="fd_status" id="fd_status" class="bootstrap-select bootstrap-select-arrow g-input removeError">
	                           			<option value=""><?php _trans("lable285"); ?></option>
										<option value="N" <?php if ($feedback_details->fd_status == "N") {echo "selected";} ?>><?php echo _trans('lable40'); ?></option>
										<option value="PR" <?php if ($feedback_details->fd_status == "PR") {echo "selected";} ?>><?php echo _trans('lable1192'); ?></option>
										<option value="PE" <?php if ($feedback_details->fd_status == "PE") {echo "selected";} ?>><?php echo _trans('lable560'); ?></option>
										<option value="CC" <?php if ($feedback_details->fd_status == "CC") {echo "selected";} ?>><?php echo _trans('lable1193'); ?></option>
										<option value="CO" <?php if ($feedback_details->fd_status == "CO") {echo "selected";} ?>><?php echo _trans('lable535'); ?></option>
										<option value="CL" <?php if ($feedback_details->fd_status == "CL") {echo "selected";} ?>><?php echo _trans('lable1194'); ?></option>
										<option value="RO" <?php if ($feedback_details->fd_status == "RO") {echo "selected";} ?>><?php echo _trans('lable1195'); ?></option>
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
							<div id="appendComments" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 padding0px">
								<?php if(count($comments) > 0){ ?>
								<div class="row">
									<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
										<div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">
											<div class="form-group clearfix">
												<h5 class="control-label string required"><?php _trans('lable494');?></h5>
											</div>
										</div>
									</div>
								</div>
								<?php foreach($comments as $key => $commentslist){ ?>
								<div class="form-group clearfix actnotes">
									<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div id="parentDiv_<?php echo $commentslist->feedback_comment_id;?>" class="singleNoteBorder addedNotesList pT7 pB7">
											<table cellpadding="0" cellspacing="0" class="w100p">
												<tbody>
													<tr class="pR w100p pB0">
														<td class="aligntop notesUserImg">
															<span class="feedsImgHolder16 dIB mT7 pL5">
																<img align="absmiddle" src="<?php echo base_url(); ?>assets/mp_backend/img/user.png">
															</span>
														</td>
														<td class="pL10 pR10 w100p pR">
															<div class="pB5 cBafter">
																<pre id="ncontent_<?php echo $commentslist->feedback_comment_id;?>" wrap="soft" class="pre f14 fL cB col333 p5 paddingTop10px "><?php echo $commentslist->comments;?></pre>
																<span style="clear:left;"></span>
																<span class="note_edit_div w100p dIB float_left cB" style="box-sizing: border-box;">
																</span>
																<div class="mT5 p5 f12 gray2 float_left cB lh20 notesBtmDet">
																	<span class="notesModdet float_left">
																		<span class="notesgray float_left ellipsistext cD" style="max-width: 100px;" title="Leads"><?php _trans('lable1188');?></span>
																	</span>
																	<span class="float_left pL10 pR10 notesDot">-</span>
																	<span class="float_left pR5 notesgray dIB">
																		<span class="timerIcon-notes mT2 float_left mR5">
																			<img src="<?php echo base_url(); ?>assets/mp_backend/img/clock.svg" width="15px" height="15px">
																		</span><?php if($commentslist->created_on != "" && $commentslist->created_on != "0000-00-00 00:00:00"){echo date("d-m-Y H:i:s", strtotime($commentslist->created_on));}else { echo "";}?>
																	</span>
																	<span class="float_left pR5 notesgray dIB"><?php _trans('lable503');?></span>
																	<span class="float_left pR5 notesgray dIB" data-title="<?php echo $commentslist->user_name;?>"><?php echo $commentslist->user_name;?></span>
																	<?php if($commentslist->reschedule == 'Y'){ ?>
																		<span class="float_left pR5 notesgray dIB"><?php _trans('lable1205');?></span>
																		<span class="float_left pR5 notesgray dIB">
																		<?php if($commentslist->reschedule_date != "" && $commentslist->reschedule_date != "0000-00-00 00:00:00"){echo date("d-m-Y H:i:s", strtotime($commentslist->reschedule_date));}else { echo "";}?>
																		</span>
																	<?php } ?>
																	<span class="pA whiteBg" id="noteOper_<?php echo $commentslist->feedback_comment_id;?>" style="top: 10px; right: 0px;">
																		<a style="float: right;" href="javascript:void(0)" class="editDeleteButtonsRight" onclick="delete_record('mech_feedback_comments',<?php echo $commentslist->feedback_comment_id; ?>, '<?=$this->security->get_csrf_hash(); ?>')" ><i class="fa fa-trash"></i></a>
																		<?php if($key == 0){ ?>
																		<a style="float: right;margin-right: 10px;" href="javascript:void(0)" onclick="editComments(<?php echo $commentslist->feedback_comment_id;?>);" class="editDeleteButtonsRight">
																			<i class="fa fa-edit">	</i>
																		</a>
																		<?php } ?>
																	</span>
																</div>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<?php } } ?>
							</div>
							<div class="form-group clearfix actnotes" id="newNoteBox">
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop40px">
									<h5><?php _trans('lable504');?></h5>
									<div class="form-group clearfix">
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
											<label class="control-label string required"><?php _trans('lable494');?>*</label>
										</div>
										<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 removeError">
											<textarea name="comments" placeholder="Add Notes" id="comments" class="form-control"></textarea>
										</div>
									</div>
									<div class="form-group clearfix">
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
											<label class="control-label string required"><?php _trans('lable1206');?></label>
										</div>
										<div class="form_controls col-lg-9 col-md-9 col-sm-9 col-xs-10 paddingTop10px text-left">
											<input type="checkbox"  id="reschedule" name="reschedule" value="N" autocomplete="off">
										</div>
									</div> 
									<div class="form-group clearfix" id="rescheduleBox" style="display:none;">
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right paddingTop10px">
											<label class="control-label string required"><?php _trans('lable1205');?></label>
										</div>
										<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 paddingTop20px">
											<input type="text" name="reschedule_date" id="reschedule_date" class="form-control reschedule_date reschedule_error" value="" autocomplete="off">
										</div>
									</div>
									<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center paddingTop10px">
										<button type="button" class="btn btn-rounded btn-primary save_comments"  name="save_comments" id="save_comments"><?php _trans('lable57');?></button>
										<button name="btn_cancel" class="btn_cancel btn btn-rounded btn-default"><i class="fa fa-times"></i> <?php _trans('lable58'); ?></button>
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

$(document).ready(function(){

    $('.reschedule_date').datetimepicker({
        format: 'DD-MM-YYYY HH:mm:ss',
	});
	
	$("#reschedule").click(function(){
		if($("#reschedule:checked").is(":checked")){
			$("#reschedule").val('Y');
			$("#rescheduleBox").show();
		}else{
			$("#reschedule").val('N');
			$("#rescheduleBox").hide();
		}
		$('.reschedule_date').datetimepicker({
			format: 'DD-MM-YYYY HH:mm:ss',
		});
	});
});	

function renderComments(){

	$("#reschedule").prop("checked", false);
	$("#rescheduleBox").hide();	

	$('.border_error').removeClass("border_error");
	$('.has-error').removeClass('has-error');

	$("#comments").val('');
	$("#reschedule_date").val('');
	$("#reschedule").val('');

	var entity_id = $("#fb_id").val();
	$.post("<?php echo site_url('mech_add_feedback/ajax/get_comments'); ?>", {
		entity_id : entity_id,
		_mm_csrf: $('input[name="_mm_csrf"]').val()
	},
	function (data) {
		var list = JSON.parse(data);
		if(list.success == 1){
			var htmll = '';
			var mech_feedback_comments = "mech_feedback_comments";
			var dynamic_code = '<?=$this->security->get_csrf_hash(); ?>';
			if(list.comments.length > 0){
			htmll += '<div class="row">';
			htmll += '<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">';
			htmll += '<div class="col-lg-6 col-xl-6 col-md-6 col-sm-6">';
			htmll += '<div class="form-group clearfix">';
			htmll += '<h5 class="control-label string required"><?php _trans('lable494');?></h5>';
			htmll += '</div></div></div></div>';
			for(var i=0; i<list.comments.length; i++){
				var dynamic_code = '<?=$this->security->get_csrf_hash(); ?>';
				htmll += '<div class="form-group clearfix actnotes">';
				htmll += '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">';
				htmll += '<div id="parentDiv_'+list.comments[i].feedback_comment_id+'" class="singleNoteBorder addedNotesList pT7 pB7">';
				htmll += '<table cellpadding="0" cellspacing="0" class="w100p"><tbody>';
				htmll += '<tr class="pR w100p pB0">';
				htmll += '<td class="aligntop notesUserImg">';
				htmll += '<span class="feedsImgHolder16 dIB mT7 pL5">';
				htmll += '<img align="absmiddle" src="<?php echo base_url(); ?>assets/mp_backend/img/user.png"></span></td>';
				htmll += '<td class="pL10 pR10 w100p pR">';
				htmll += '<div class="pB5 cBafter">';
				htmll += '<pre id="ncontent_'+list.comments[i].feedback_comment_id+'" wrap="soft" class="pre f14 fL cB col333 p5 paddingTop10px ">'+list.comments[i].comments+'</pre>';
				htmll += '<span style="clear:left;"></span>';
				htmll += '<span class="note_edit_div w100p dIB float_left cB" style="box-sizing: border-box;"></span>';
				htmll += '<div class="mT5 p5 f12 gray2 float_left cB lh20 notesBtmDet">';
				htmll += '<span class="notesModdet float_left">';
				htmll += '<span class="notesgray float_left ellipsistext cD" style="max-width: 100px;" title="Feedback">Feedback</span></span>';
				htmll += '<span class="float_left pL10 pR10 notesDot">•</span>';
				htmll += '<span class="float_left pR5 notesgray dIB">';
				htmll += '<span class="timerIcon-notes mT2 float_left mR5">';
				htmll += '<img src="<?php echo base_url(); ?>assets/mp_backend/img/clock.svg" width="15px" height="15px">';
				htmll += '</span>'+coverttimedate(list.comments[i].created_on)+'</span>';
				htmll += '<span class="float_left pR5 notesgray dIB">by</span>';
				htmll += '<span class="float_left pR5 notesgray dIB" data-title="'+list.comments[i].user_name+'">'+list.comments[i].user_name+'</span>';
				if(list.comments[i].reschedule == 'Y'){
					htmll += ' <span class="float_left pR5 notesgray dIB"> Call-Back Date</span>';
					htmll += ' <span class="float_left pR5 notesgray dIB"> '+coverttimedate(list.comments[i].reschedule_date)+'</span>';
				}
				htmll += '<span class="pA whiteBg" id="noteOper_'+list.comments[i].feedback_comment_id+'" style="top: 10px; right: 0px;">';
				htmll += '<a style="float: right;" href="javascript:void(0)" class="editDeleteButtonsRight" onclick="delete_record(\''+mech_feedback_comments+'\',\''+list.comments[i].feedback_comment_id+'\',\''+dynamic_code+'\')" ><i class="fa fa-trash"></i></a>';
				if(i == 0){
					htmll += '<a style="float: right;margin-right: 10px;" href="javascript:void(0)" onclick="editComments(\''+list.comments[i].feedback_comment_id+'\',\''+list.comments[i].entity_id+'\',\''+list.comments[i].comments+'\');" class="editDeleteButtonsRight">';
					htmll += '<i class="fa fa-edit"></i></a>';
				}
				htmll += '</span></div></div></td></tr></tbody></table></div></div></div>';
				$("#appendComments").empty().append(htmll);
			}} 
			$("#newNoteBox").show();
		}
	});

	$('.reschedule_date').datetimepicker({
		format: 'DD-MM-YYYY HH:mm:ss',
	});
}

function reschedulCheckBox(id){
	if($("#nreschedule_"+id+":checked").is(":checked")){
		$("#nreschedule_"+id).val('Y');
		$("#rescheduleBox_"+id).show();
	}else{
		$("#nreschedule_"+id).val('N');
		$("#rescheduleBox_"+id).hide();
	}
	$("#nreschedule_date_"+id).datetimepicker({
		format: 'DD-MM-YYYY HH:mm:ss',
	});
}
function editComments(feedback_comment_id){

	$("#newNoteBox").hide();

	$.post("<?php echo site_url('mech_add_feedback/ajax/get_Comment_detials'); ?>", {
		feedback_comment_id : feedback_comment_id,
		_mm_csrf: $('input[name="_mm_csrf"]').val()
	},
	function (data) {
		var list = JSON.parse(data);
		if(list.success == 1){
			var html = '';
			html += '<table cellpadding="0" cellspacing="0" class="w100p">';
			html += '<tbody>';
			html += '<tr class="pR w100p pB0">';
			html += '<td class="aligntop notesUserImg">';
			html += '<span class="feedsImgHolder16 dIB mT7 pL5">';
			html += '<img align="absmiddle" src="<?php echo base_url(); ?>assets/mp_backend/img/user.png">';
			html += '</span></td>';
			html += '<td class="pL10 pR10 w100p pR">';
			html += '<div class="pB5 cBafter">';
			html += '<input type="hidden" value="'+list.comments.employee_id+'" id="nassign_'+list.comments.employee_id+'" >';
			html += '<div class="form-group clearfix">';
			html += '<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">';
			html += '<label class="control-label string required">Notes *</label></div>';
			html += '<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 padding0px">';
			html += '<textarea id="ncontent_'+list.comments.feedback_comment_id+'" wrap="soft" class="form-control pre f14 fL cB col333 p5 paddingTop10px">'+list.comments.comments+'</textarea>';
			html += '</div></div>';
			html += '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">';
			html += '<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">';
			html += '<label class="control-label string required">Call-Back</label></div>';
			html += '<div class="form_controls col-lg-9 col-md-9 col-sm-9 col-xs-10 paddingTop10px text-left">';
			var checked = '';
			var showBox = 'style="display:none;"';
			if(list.comments.reschedule == 'Y'){
				checked = 'checked';
				showBox = 'style="display:block;"';
			}
			html += '<input type="checkbox" onchange="reschedulCheckBox('+list.comments.feedback_comment_id+')" class="nreschedule_'+list.comments.feedback_comment_id+'" id="nreschedule_'+list.comments.feedback_comment_id+'" name="nreschedule_'+list.comments.feedback_comment_id+'" '+checked+' value="'+list.comments.reschedule+'"></div></div> ';
			html += '<div class="form-group clearfix paddingTop10px padding0px" id="rescheduleBox_'+list.comments.feedback_comment_id+'" '+showBox+'>';
			html += '<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right paddingTop20px">';
			html += '<label class="control-label string required">Call-Back Date</label></div>';
			html += '<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 paddingTop20px">';
			html += '<input type="text" name="nreschedule_date_'+list.comments.feedback_comment_id+'" id="nreschedule_date_'+list.comments.feedback_comment_id+'" class="form-control reschedule_date" value="';
			if(list.comments.reschedule_date == null){
				html += '';
			}else{
				html += coverttimedate(list.comments.reschedule_date);
			}
			html += '" autocomplete="off"></div></div>';
			html += '<div class="mT5 p5 f12 gray2 float_right cB lh20 notesBtmDet">';
			html += '<span class="pA whiteBg" id="noteOper_'+list.comments.feedback_comment_id+'" style="top: 10px; right: 0px;">';
			html += '<a style="float: right;" href="javascript:void(0)" class="editDeleteButtonsRight" onclick="renderComments()" ><button name="btn_cancel" class="btn btn-rounded"><i class="fa fa-times" aria-hidden="true"></i> <?php _trans('lable58'); ?></button></a>';
			html += '<a style="float: right;margin-right: 10px;" href="javascript:void(0)" onclick="saveComments(\''+list.comments.feedback_comment_id+'\',\''+list.comments.entity_id+'\')" class="editDeleteButtonsRight">';
			html += '<button value="1" name="btn_submit" class="btn_submit btn btn-rounded"><i class="fa fa-check" aria-hidden="true"></i> <?php _trans('lable57'); ?></button></i></a></span></div></div></td></tr></tbody></table>';

			$("#parentDiv_"+list.comments.feedback_comment_id).empty().append(html);
			$(".reschedule").datetimepicker({
				format: 'DD-MM-YYYY HH:mm:ss',
			});
			$("#nreschedule_date_"+feedback_comment_id).datetimepicker({
				format: 'DD-MM-YYYY HH:mm:ss',
			});
		}
	});
	// nreschedule_date_85
	$("#nreschedule_date_"+feedback_comment_id).datetimepicker({
        format: 'DD-MM-YYYY HH:mm:ss',
	});
}

function saveComments(feedback_comment_id, fb_id){

	$('.border_error').removeClass("border_error");
	$('.has-error').removeClass('has-error');

	var validations = [];
	var comments = $("#ncontent_"+feedback_comment_id).val()?$("#ncontent_"+feedback_comment_id).val():'';
	var reschedule = $("#nreschedule_"+feedback_comment_id).val()?$("#nreschedule_"+feedback_comment_id).val():'';
	var reschedule_date = $("#nreschedule_date_"+feedback_comment_id).val()?$("#nreschedule_date_"+feedback_comment_id).val():'';

	if(comments == ''){
		validations.push("ncontent_"+feedback_comment_id);
	}

	if(reschedule_date == 'null' || reschedule_date == null){
		reschedule_date = "";
	}

	if(reschedule == 'Y'){
		if(reschedule_date == ''){
			validation.push('nreschedule_date_'+feedback_comment_id);
		}
	}

	if(validations.length > 0){
		validations.forEach(function(val) {
			$('#'+val).addClass("border_error");
			if($('#'+val+'_error').length == 0){
				$('#'+val).parent().addClass('has-error');
			} 
		});
		return false;
	}

	$.post("<?php echo site_url('mech_add_feedback/ajax/save_comments'); ?>", {
		fb_id : fb_id,
		comments: comments,
		feedback_comment_id: feedback_comment_id,
		reschedule: reschedule,
		reschedule_date: reschedule_date,
		entity_type: 'FB',
		_mm_csrf: $('input[name="_mm_csrf"]').val()
	},
	function (data) {
		var list = JSON.parse(data);
		if(list.success === 1){
			notie.alert(1, '<?php _trans('toaster1');?>', 2);
			renderComments();		
		} else{
			notie.alert(3, '<?php _trans('toaster2');?>', 2);
			$('.has-error').removeClass('has-error');
			for (var key in list.validation_errors) {
				$('#' + key).parent().addClass('has-error');
				$('.error_msg_' + key).show().empty().html(list.validation_errors[key]);
			}
		}
	});
	$('.reschedule_date').datetimepicker({
		format: 'DD-MM-YYYY HH:mm:ss',
	});
}

$("#btn_cancel").click(function () {
	window.location.href = "<?php echo site_url('mech_add_feedback'); ?>";
});

$("#btn_cancel_img").click(function () {
	window.location.href = "<?php echo site_url('mech_add_feedback'); ?>";
});

$(".btn_submit_basic").click(function () {

    $('.border_error').removeClass('border_error');
    $('.has-error').removeClass('has-error');

    var validation = [];

    if($("#package_name").val() == ''){
        validation.push('package_name');
    }

    if($("#mobile_enable").val() == ''){
        validation.push('mobile_enable');
    }
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

    $.post('<?php echo site_url('mech_add_feedback/ajax/status_update'); ?>', {
        fb_id : $("#fb_id").val(),
        fd_status : $('#fd_status').val(),
        _mm_csrf: $('input[name="_mm_csrf"]').val(),
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
                setTimeout(function(){
                    window.location = "<?php echo site_url('mech_add_feedback/form'); ?>/"+list.fb_id+"/2";
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

$('.save_comments').click(function () {	
			        
		var validation = [];
		var comments = $("#comments").val()?$("#comments").val():'';
		var reschedule = $("#reschedule").val()?$("#reschedule").val():'';
		var reschedule_date = $("#reschedule_date").val()?$("#reschedule_date").val():'';

		if($("#comments").val() == ''){
			validation.push('comments');
		}
		if(reschedule == 'Y'){
			if($("#reschedule_date").val() == ''){
				validation.push('reschedule_date');
			}
		}
		if(validation.length > 0){
			validation.forEach(function(val) {
				$('#'+val).addClass("border_error");
				if($('#'+val+'_error').length == 0){
					$('#'+val).parent().addClass('has-error');
				} 
			});
			return false;
		}
		$('#gif').show();
		$.post("<?php echo site_url('mech_add_feedback/ajax/save_comments'); ?>", {
			fb_id : $("#fb_id").val(),
			comments: $('#comments').val()?$('#comments').val():'',
			reschedule: $('#reschedule').val()?$('#reschedule').val():'',
			reschedule_date: $("#reschedule_date").val()?$("#reschedule_date").val():'',
			entity_type: 'FB',
			_mm_csrf: $('input[name="_mm_csrf"]').val()
		},
		function (data) {
			var list = JSON.parse(data);
			if(list.success === 1){
				$('#gif').hide();
				notie.alert(1, '<?php _trans('toaster1');?>', 2);
				renderComments();
			} else{
				$('#gif').hide();
				notie.alert(3, 'Oops, something has gone wrong', 2);
				$('.has-error').removeClass('has-error');
				for (var key in list.validation_errors) {
					$('#' + key).parent().addClass('has-error');
					$('.error_msg_' + key).show().empty().html(list.validation_errors[key]);
				}
			}
		});
	});

</script>