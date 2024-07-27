<style type="text/css">

input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
}
#product_item_table input {
    padding-left: 0px;
    padding-right: 0px;
}

</style>
<script type="text/javascript">


function renderComments(){

	$("#reschedule").prop("checked", false);
	$("#rescheduleBox").hide();	

	$('.border_error').removeClass("border_error");
	$('.has-error').removeClass('has-error');

	$("#comments").val('');
	$("#note_user_id").val('');
	$('#note_user_id').selectpicker("refresh");
	$("#reschedule_date").val('');
	$("#reschedule").val('');

	var entity_id = $("#ml_id").val();
	$.post("<?php echo site_url('mech_leads/ajax/get_comments'); ?>", {
		entity_id : entity_id,
		_mm_csrf: $('input[name="_mm_csrf"]').val()
	},
	function (data) {
		var list = JSON.parse(data);
		if(list.success == 1){
			var htmll = '';
			var mech_comments = "mech_comments";
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
				htmll += '<div id="parentDiv_'+list.comments[i].comment_id+'" class="singleNoteBorder addedNotesList pT7 pB7">';
				htmll += '<table cellpadding="0" cellspacing="0" class="w100p"><tbody>';
				htmll += '<tr class="pR w100p pB0">';
				htmll += '<td class="aligntop notesUserImg">';
				htmll += '<span class="feedsImgHolder16 dIB mT7 pL5">';
				htmll += '<img align="absmiddle" src="<?php echo base_url(); ?>assets/mp_backend/img/user.png"></span></td>';
				htmll += '<td class="pL10 pR10 w100p pR">';
				htmll += '<div class="pB5 cBafter">';
				htmll += '<pre id="ncontent_'+list.comments[i].comment_id+'" wrap="soft" class="pre f14 fL cB col333 p5 paddingTop10px ">'+list.comments[i].comments+'</pre>';
				htmll += '<span style="clear:left;"></span>';
				htmll += '<span class="note_edit_div w100p dIB float_left cB" style="box-sizing: border-box;"></span>';
				htmll += '<div class="mT5 p5 f12 gray2 float_left cB lh20 notesBtmDet">';
				htmll += '<span class="notesModdet float_left">';
				htmll += '<span class="notesgray float_left ellipsistext cD" style="max-width: 100px;" title="Lead">Lead</span></span>';
				htmll += '<span class="float_left pL10 pR10 notesDot">•</span>';
				htmll += '<span class="float_left pR5 notesgray dIB">';
				htmll += '<span class="timerIcon-notes mT2 float_left mR5">';
				htmll += '<img src="<?php echo base_url(); ?>assets/mp_backend/img/clock.svg" width="15px" height="15px">';
				htmll += '</span>'+coverttimedate(list.comments[i].created_on)+'</span>';
				htmll += '<span class="float_left pR5 notesgray dIB">by</span>';
				htmll += '<span class="float_left pR5 notesgray dIB" data-title="'+list.comments[i].employee_name+'">'+list.comments[i].employee_name+'</span>';
				if(list.comments[i].reschedule == 'Y'){
					htmll += ' <span class="float_left pR5 notesgray dIB"> Re-scheduled Date</span>';
					htmll += ' <span class="float_left pR5 notesgray dIB"> '+coverttimedate(list.comments[i].reschedule_date)+'</span>';
				}
				htmll += '<span class="pA whiteBg" id="noteOper_'+list.comments[i].comment_id+'" style="top: 10px; right: 0px;">';
				htmll += '<a style="float: right;" href="javascript:void(0)" class="editDeleteButtonsRight" onclick="delete_record(\''+mech_comments+'\',\''+list.comments[i].comment_id+'\',\''+dynamic_code+'\')" ><i class="fa fa-trash"></i></a>';
				if(i == 0){
					htmll += '<a style="float: right;margin-right: 10px;" href="javascript:void(0)" onclick="editComments(\''+list.comments[i].comment_id+'\',\''+list.comments[i].entity_id+'\',\''+list.comments[i].comments+'\');" class="editDeleteButtonsRight">';
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
function editComments(comment_id){

	$("#newNoteBox").hide();

	$.post("<?php echo site_url('mech_leads/ajax/get_Comment_detials'); ?>", {
		comment_id : comment_id,
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
			html += '<textarea id="ncontent_'+list.comments.comment_id+'" wrap="soft" class="form-control pre f14 fL cB col333 p5 paddingTop10px">'+list.comments.comments+'</textarea>';
			html += '</div></div>';
			html += '<div class="form-group clearfix paddingTop10px">';
			html += '<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">';
			html += '<label class="control-label string required">Given by *</label></div>';
			html += '<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 padding0px">';
			html += '<select name="nselect_'+list.comments.comment_id+'" id="nselect_'+list.comments.comment_id+'" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">';
			html += '<option value="">Select Name</option>';
			if(list.assigned_to.length > 0){
				for(var i=0; i< list.assigned_to.length; i++){
					var selected = '';
					if(list.comments.employee_id == list.assigned_to[i].employee_id){
						selected = 'selected';
					}
					html += '<option value="'+list.assigned_to[i].employee_id+'" '+selected+'>'+list.assigned_to[i].employee_name+'</option>';
				}
			}
			html += '</select></div></div>';
			html += '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">';
			html += '<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">';
			html += '<label class="control-label string required">Re-Schedule</label></div>';
			html += '<div class="form_controls col-lg-9 col-md-9 col-sm-9 col-xs-10 paddingTop10px text-left">';
			var checked = '';
			var showBox = 'style="display:none;"';
			if(list.comments.reschedule == 'Y'){
				checked = 'checked';
				showBox = 'style="display:block;"';
			}
			html += '<input type="checkbox" onchange="reschedulCheckBox('+list.comments.comment_id+')" class="nreschedule_'+list.comments.comment_id+'" id="nreschedule_'+list.comments.comment_id+'" name="nreschedule_'+list.comments.comment_id+'" '+checked+' value="'+list.comments.reschedule+'"></div></div> ';
			html += '<div class="form-group clearfix paddingTop10px padding0px" id="rescheduleBox_'+list.comments.comment_id+'" '+showBox+'>';
			html += '<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right paddingTop20px">';
			html += '<label class="control-label string required">Re-schedule Date</label></div>';
			html += '<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 paddingTop20px">';
			html += '<input type="text" name="nreschedule_date_'+list.comments.comment_id+'" id="nreschedule_date_'+list.comments.comment_id+'" class="form-control reschedule_date" value="';
			if(list.comments.reschedule_date == null){
				html += '';
			}else{
				html += coverttimedate(list.comments.reschedule_date);
			}
			html += '" autocomplete="off"></div></div>';
			html += '<div class="mT5 p5 f12 gray2 float_right cB lh20 notesBtmDet">';
			html += '<span class="pA whiteBg" id="noteOper_'+list.comments.comment_id+'" style="top: 10px; right: 0px;">';
			html += '<a style="float: right;" href="javascript:void(0)" class="editDeleteButtonsRight" onclick="renderComments()" ><button name="btn_cancel" class="btn btn-rounded"><i class="fa fa-times" aria-hidden="true"></i> <?php _trans('lable58'); ?></button></a>';
			html += '<a style="float: right;margin-right: 10px;" href="javascript:void(0)" onclick="saveComments(\''+list.comments.comment_id+'\',\''+list.comments.entity_id+'\')" class="editDeleteButtonsRight">';
			html += '<button value="1" name="btn_submit" class="btn_submit btn btn-rounded"><i class="fa fa-check" aria-hidden="true"></i> <?php _trans('lable57'); ?></button></i></a></span></div></div></td></tr></tbody></table>';

			$("#parentDiv_"+list.comments.comment_id).empty().append(html);
			$('#nselect_'+list.comments.comment_id).selectpicker("refresh");
			$(".reschedule").datetimepicker({
        		format: 'DD-MM-YYYY HH:mm:ss',
			});
			$("#nreschedule_date_"+comment_id).datetimepicker({
        		format: 'DD-MM-YYYY HH:mm:ss',
			});
		}
	});
	// nreschedule_date_85
	$("#nreschedule_date_"+comment_id).datetimepicker({
        format: 'DD-MM-YYYY HH:mm:ss',
	});
}

function saveComments(comment_id, lead_id){

	$('.border_error').removeClass("border_error");
	$('.has-error').removeClass('has-error');


	var validations = [];
	var comments = $("#ncontent_"+comment_id).val()?$("#ncontent_"+comment_id).val():'';
	var assign_to = $("#nselect_"+comment_id).val()?$("#nselect_"+comment_id).val():'';
	var reschedule = $("#nreschedule_"+comment_id).val()?$("#nreschedule_"+comment_id).val():'';
	var reschedule_date = $("#nreschedule_date_"+comment_id).val()?$("#nreschedule_date_"+comment_id).val():'';

	if(comments == ''){
		validations.push("ncontent_"+comment_id);
	}

	if(assign_to == ''){
		validations.push("nselect_"+comment_id);
	}

	if(reschedule_date == 'null' || reschedule_date == null){
		reschedule_date = "";
	}

	if(reschedule == 'Y'){
		if(reschedule_date == ''){
			validation.push('nreschedule_date_'+comment_id);
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

	$.post("<?php echo site_url('mech_leads/ajax/save_comments'); ?>", {
		ml_id : lead_id,
		comments: comments,
		comment_id: comment_id,
		modified_employee_id: assign_to,
		reschedule: reschedule,
		reschedule_date: reschedule_date,
		entity_type: 'L',
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


function getproductsByFilter(){

	// if($("#user_car_list_id").val() == ''){
	//     notie.alert(3, '<?php // _trans('toaster5'); ?>', 2);
	//     $("#service_category_id").val(0);
	//     $('.bootstrap-select').selectpicker("refresh");
	//     return false;
	// }
	$('#gif').show();
	$.post("<?php echo site_url('mech_item_master/ajax/getProductItemList'); ?>", {
		product_category_id: $('#product_category_id').val()?$('#product_category_id').val():'',
		product_brand_id: $("#product_brand_id").val()?$("#product_brand_id").val():'',
		user_car_list_id: $('#user_car_list_id').val()?$('#user_car_list_id').val():'',
		_mm_csrf: $('input[name="_mm_csrf"]').val()
	},function (data) {
		var response = JSON.parse(data);
		if (response) {
			$('#gif').hide();
			$('#services_item_product_id').empty(); // clear the current elements in select box
			$('#services_item_product_id').append($('<option></option>').attr('value', '').text('Item'));
			for (row in response) {
				$('#services_item_product_id').append($('<option></option>').attr('value', response[row].product_id).text(response[row].product_name));
			}
			$('#services_item_product_id').selectpicker("refresh");
		}else{
			$('#gif').hide();
			$('#services_item_product_id').empty(); // clear the current elements in select box
			$('#services_item_product_id').append($('<option></option>').attr('value', '').text('Item'));
			$('#services_item_product_id').selectpicker("refresh");
		}
	});
}
var currency_symbol = "<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;";
var default_currency_digit  = parseInt('<?php echo $this->session->userdata("default_currency_digit")?$this->session->userdata("default_currency_digit"):0;?>');
var getServiceDetailsURL = '<?php echo site_url('mech_item_master/ajax/getServiceDetails'); ?>';
var getProductDetailsURL = '<?php echo site_url('mech_item_master/ajax/get_product_details'); ?>';
var getServicePackageDetailsURL = '<?php echo site_url('service_packages/ajax/get_package_details'); ?>';
</script>
<script src="<?php echo base_url(); ?>assets/mp_backend/js/leads.js"></script>
<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell" id="total_user_quote">
				<h3><?php _trans('menu9'); ?><?php if ($mech_leads->leads_no) { echo ' - '.$mech_leads->leads_no; } ?></h3>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="row">
	<div class="col-xs-12 top-15">
		<a class="anchor anchor-back" onclick="goBack()" href="<?php echo site_url('mech_leads/index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
	</div>
</div>
<?php if (isset($active_tab)) {
    if ($active_tab == 1) {
        $one_tab_active = 'active show in';
        $two_tab_active = '';
        $three_tab_active = '';
        $one_area_selected = true;
        $two_area_selected = false;
        $three_area_selected = false;
    } else if ($active_tab == 2) {
        $one_tab_active = '';
        $two_tab_active = 'active show in';
        $three_tab_active = '';
        $one_area_selected = false;
        $two_area_selected = true;
        $three_area_selected = false;
    } else if ($active_tab == 3) {
        $one_tab_active = '';
        $two_tab_active = '';
        $three_tab_active = 'active show in';
        $one_area_selected = false;
        $two_area_selected = false;
        $three_area_selected = true;
    } 
} else {
    $one_tab_active = 'active show in';
    $two_tab_active = '';
    $three_tab_active = '';
    $one_area_selected = true;
    $two_area_selected = false;
    $three_area_selected = false;
}
?>
<div id="content" class="usermanagement">
    <div class="row">
		<div id="gif" class="gifload">
			<div class="gifcenter">
			  <center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
		    </div>
		</div>
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 ipadview">
			<div class="nav nav-tabs">
				<div class="tbl">
					<ul class="nav" role="tablist">
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $one_tab_active; ?>" href="#tabs-2-tab-1" role="tab" data-toggle="tab" aria-selected="<?php echo $one_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable60'); ?></span>
							</a>
						</li>
						<?php if($mech_leads->ml_id){?>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $two_tab_active; ?>" href="#tabs-2-tab-2" role="tab" data-toggle="tab" aria-selected="<?php echo $two_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable492'); if($is_product == 'Y'){ _trans('lable493'); }?></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $three_tab_active; ?> " href="#tabs-2-tab-3" role="tab" data-toggle="tab" aria-selected="<?php echo $three_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable494'); ?></span>
							</a>
						</li>
						<?php } else { ?>
						<li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable492'); if($is_product == 'Y'){ _trans('lable493'); }?></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab" >
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable494'); ?></span>
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
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable60'); ?></span>
							</a>
						</li>
						<?php if($mech_leads->ml_id){?>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $two_tab_active; ?>" href="#tabs-2-tab-2" role="tab" data-toggle="tab" aria-selected="<?php echo $two_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable492'); if($is_product == 'Y'){ _trans('lable493'); }?></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $three_tab_active; ?> " href="#tabs-2-tab-3" role="tab" data-toggle="tab" aria-selected="<?php echo $three_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable494'); ?></span>
							</a>
						</li>
						<?php } else { ?>
						<li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable492'); if($is_product == 'Y'){ _trans('lable493'); }?></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link not-allowed" href="#" role="tab" >
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable494'); ?></span>
							</a>
						</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<input type="hidden" name="ml_id" id="ml_id" class="form-control" value="<?php echo $mech_leads->ml_id;?>"autocomplete="off">
			<input type="hidden" name="leads_no" id="leads_no" class="form-control" value="<?php echo $mech_leads->leads_no;?>"autocomplete="off">
			<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 paddingTopLeft0px">
				<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" autocomplete="off"/>
				<section class="tabs-section" >
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane fade <?php echo $one_tab_active; ?>" id="tabs-2-tab-1">
							<input class="hidden" name="is_update" type="hidden"  <?php if($mech_leads->ml_id){echo 'value="1"';} else {echo 'value="0"';}?>autocomplete="off">
							<div class="form-group clearfix">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
									<label class="control-label string required"><?php _trans('lable95'); ?> *</label>
								</div>
								<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
									<select id="branch_id" name="branch_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
										<?php if($this->session->userdata('user_type') == 3){ ?>
										<option value=""><?php _trans('lable149'); ?></option>	
										<?php } ?>	
										<?php foreach ($branch_list as $branchList) {?>
										<option value="<?php echo $branchList->w_branch_id; ?>" <?php if($mech_leads->branch_id == $branchList->w_branch_id){echo "selected";}?> > <?php echo $branchList->display_board_name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<input type="hidden" name="invoice_group_id" id="invoice_group_id" value="<?php echo $invoice_group->invoice_group_id;?>"autocomplete="off">
							<!-- <div class="form-group clearfix">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
									<label class="control-label string required"><?php // _trans('lable495'); ?> *</label>
								</div>
								<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
									<select name="user_id" id="user_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
										<option value=""><?php // _trans('lable293'); ?></option>
										<?php // foreach ($assigned_to as $assigned_to_list) {?>
										<option value="<?php // echo $assigned_to_list->employee_id; ?>" <?php // if($mech_leads->user_id == $assigned_to_list->employee_id){ echo "selected"; }?> ><?php // echo $assigned_to_list->employee_name; ?></option>
										<?php // } ?>
									</select>
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php // _trans('lable496');?></label>
								</div>
								<div class="col-sm-9">
									<input type="text" name="title" id="title" class="form-control" value="<?php // echo $mech_leads->title;?>" autocomplete="off">
								</div>
							</div> -->
							<div class="form-group clearfix">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
									<label class="control-label string required"><?php _trans('lable36');?> *</label>
								</div>
								<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
									<select name="customer_id" id="customer_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
										<option value=""><?php _trans('lable272'); ?></option>
										<?php foreach ($customer_list as $customer) {
											if ($mech_leads->customer_id == $customer->client_id) {
												$selected = 'selected="selected"';
											} else {
												$selected = '';
											} ?>
										<option value="<?php echo $customer->client_id; ?>" <?php echo $selected; ?>><?php echo ($customer->client_name?$customer->client_name:"").' '.($customer->client_contact_no?"(".$customer->client_contact_no.")":""); ?></option>
										<?php } ?>
									</select>
									<div class="col-lg-12 paddingTop5px paddingLeft0px">
										<a class="fontSize_85rem float_left add_client_page" href="javascript:void(0)" data-toggle="modal" data-model-from="leads" data-target="#addNewCar">
											+ <?php _trans('lable48'); ?>
										</a>
									</div>
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
									<label class="control-label string required"><?php _trans('lable280'); ?></label>
								</div>
							
								<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
									<select name="user_car_list_id" id="user_car_list_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
										<option value=""><?php _trans('lable281'); ?></option>
										<?php foreach ($user_cars as $cars) {																						
											$user_cars_list = $cars->brand_name.', '.$cars->model_name.''.($cars->variant_name?", ".$cars->variant_name:"").', '.$cars->car_reg_no; ?>
										<option value="<?php echo $cars->car_list_id; ?>" <?php if($mech_leads->user_car_list_id == $cars->car_list_id) {echo "selected";} ?>><?php echo $user_cars_list; ?></option>
										<?php } ?>
									</select>
									<div class="col-lg-12 paddingTop5px paddingLeft0px">
										<a href="javascript:void(0)" data-toggle="modal" data-model-from="leads" data-target="#addNewCar" <?php if($mech_leads->customer_id){ echo 'data-customer-id="'.$mech_leads->customer_id.'"';}?> class="add_car addcarpopuplink fontSize_85rem float_left display_none">+ <?php _trans('lable498'); ?></a>
									</div>
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
									<label class="control-label string required"><?php _trans('lable497'); ?></label>
								</div>	
								<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
									<select name="user_address_id" id="user_address_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
										<option value=""><?php _trans('lable282'); ?></option>
										<?php foreach ($address_dtls as $address) {
											$full_address = $address->customer_street_1.' '.($address->customer_street_2?",".$address->customer_street_2:"").' ,'.$address->area.' ,'.$address->zip_code;
											if ($mech_leads->user_address_id == $address->user_address_id) {
												$selected = 'selected="selected"';
											} else {
												$selected = '';
											} ?>
										<option value="<?php echo $address->user_address_id; ?>" <?php echo $selected; ?>><?php echo $full_address; ?></option>
										<?php  } ?>
									</select>
									<div class="col-lg-12 paddingTop5px paddingLeft0px">
										<a href="javascript:void(0)" data-model-from="leads" <?php if($mech_leads->customer_id){ echo 'data-customer-id="'.$mech_leads->customer_id.'"';}?> data-toggle="modal" data-target="#addAddress" class="add_address addcarpopuplink fontSize_85rem float_left display_none">
											+ <?php _trans('lable45'); ?>
										</a>
									</div>
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required "><?php _trans('lable487');?> *</label>
								</div>
								<div class="col-sm-9">
									<input type="hidden" id="lead_reschedule_date" name="lead_reschedule_date" value="<?php if($mech_leads->reschedule_date != "" && $mech_leads->reschedule_date != "0000-00-00 00:00:00"){echo date("d-m-Y H:i:s", strtotime($mech_leads->reschedule_date));}else { echo date('d-m-Y H:m:s'); }?>" autocomplete="off">
									<input type="text" name="lead_date" id="lead_date" class="form-control reschedule_date removeError datepicker_error" value="<?php if($mech_leads->lead_date != "" && $mech_leads->lead_date != "0000-00-00 00:00:00"){echo date("d-m-Y H:i:s", strtotime($mech_leads->lead_date));}else { echo date('d-m-Y H:m:s'); }?>" autocomplete="off">
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable499');?></label>
								</div>
								<div class="col-sm-9">
									<select name="lead_source" id="lead_source" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
										<option value=""><?php _trans('lable500');?></option>
										<?php foreach($mech_lead_source as $mechLeadSourceList){ ?>
											<option value="<?php echo $mechLeadSourceList->mls_id;?>" <?php if($mech_leads->lead_source == $mechLeadSourceList->mls_id){ echo "selected";}?> ><?php echo $mechLeadSourceList->lead_source_name;?></option>
										<?php }?>
									</select>
								</div>
							</div>
							<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable509');?> *</label>
								</div>
								<div class="col-sm-9">
									<select name="lead_status" id="lead_status" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
										<option value=""><?php _trans('lable285');?></option>
										<?php foreach($mech_lead_status as $mechLeadStatus){ ?>
										<option value="<?php echo $mechLeadStatus->mlstatus_id;?>" <?php if($mech_leads->lead_status == $mechLeadStatus->mlstatus_id){ echo "selected";}?> ><?php echo $mechLeadStatus->status_label;?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="buttons text-center">
								<button id="btn_submit" value="1" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
									<i class="fa fa-check"></i> <?php _trans('lable57'); ?>
								</button>
								<button name="btn_cancel" class="btn_cancel btn btn-rounded btn-default">
									<i class="fa fa-times"></i> <?php _trans('lable58'); ?>
								</button>
							</div>	
						</div>
						<div role="tabpanel" class="tab-pane fade <?php echo $two_tab_active; ?>" id="tabs-2-tab-2">
							<?php if($is_product == 'Y') { ?>
							<div class="card-block invoice">
								<?php $this->layout->load_view('mech_leads/partial_product_table'); ?>
							</div>
							<div class="error error_msg_product_name"></div>
							<?php } ?>
							<div class="card-block invoice">
								<?php $this->layout->load_view('mech_leads/partial_service_table'); ?>
							</div>
							<div class="card-block invoice">
								<?php $this->layout->load_view('mech_leads/partial_service_package_table'); ?>
							</div>
							<div class="error error_msg_service_name"></div>
							<div class="row m-b-3">
								<div class="col-lg-12">
									<div class="col-lg-5 form-group clearfix">
										<div class="col-sm-12 padding0px">
											<label class="control-label" style="text-align: left"><?php _trans('lable177');?></label>
										</div>
										<textarea class="form-control" name="description" id="description">
											<?php echo $mech_leads->description; ?>
										</textarea>
									</div>
									<div class="col-lg-7 clearfix" style="float: right">
										<div class="total-amount row" style="float: left;width: 100%`">
		
									    </br>
											<?php if($is_product == "Y"){ ?>
											<div class="row">
												<div class="col-xl-8 col-lg-7 col-md-7 col-sm-7 clearfix">
													<b><?php _trans('lable356'); ?>: </b>
												</div>
												<div class="col-xl-4 col-lg-5 col-md-5 col-sm-5 price clearfix">
													<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code'));?> &nbsp;<b class="total_product_invoice">0.00</b>
												</div>
											</div>
											<?php } ?>
											<div class="row">
												<div class="col-xl-8 col-lg-7 col-md-7 col-sm-7 clearfix">
													<b><?php _trans('lable393'); ?>: </b>
												</div>
												<div class="col-xl-4 col-lg-5 col-md-5 col-sm-5 price clearfix">
													<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code'));?> &nbsp;<b class="total_servie_invoice">0.00</b>
												</div>
											</div>
											<div class="row">
												<div class="col-xl-8 col-lg-7 col-md-7 col-sm-7 clearfix">
													<b><?php _trans('label960'); ?>: </b>
												</div>
												<div class="col-xl-4 col-lg-5 col-md-5 col-sm-5 price clearfix">
													<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code'));?> &nbsp;<b class="total_servie_package_invoice">0.00</b>
												</div>
											</div>
											
											<div class="row">
												<div class="col-lg-9 col-md-9 col-sm-9 clearfix">
													<b><?php _trans('lable332'); ?></b>
												</div>
												<div class="col-lg-3 col-md-3 col-sm-3 price clearfix" style="border-top:1px solid #000; margin-top: 5px">
													<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<b class="grand_total">0.00</b>
												</div>
												<input type="hidden" id="total_due_amount_save" name="total_due_amount_save" value="<?php echo $mech_leads->total_due_amount;?>" autocomplete="off">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="buttons text-center">
								<button id="save_service_product" value="1" name="save_service_product" class="btn btn-rounded btn-primary btn-padding-left-right-40">
									<i class="fa fa-check"></i> <?php _trans('lable57'); ?>
								</button>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade <?php echo $three_tab_active; ?>" id="tabs-2-tab-3">
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
										<div id="parentDiv_<?php echo $commentslist->comment_id;?>" class="singleNoteBorder addedNotesList pT7 pB7">
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
																<pre id="ncontent_<?php echo $commentslist->comment_id;?>" wrap="soft" class="pre f14 fL cB col333 p5 paddingTop10px "><?php echo $commentslist->comments;?></pre>
																<span style="clear:left;"></span>
																<span class="note_edit_div w100p dIB float_left cB" style="box-sizing: border-box;">
																</span>
																<div class="mT5 p5 f12 gray2 float_left cB lh20 notesBtmDet">
																	<span class="notesModdet float_left">
																		<span class="notesgray float_left ellipsistext cD" style="max-width: 100px;" title="Leads"><?php _trans('lable511');?></span>
																	</span>
																	<span class="float_left pL10 pR10 notesDot">-</span>
																	<span class="float_left pR5 notesgray dIB">
																		<span class="timerIcon-notes mT2 float_left mR5">
																			<img src="<?php echo base_url(); ?>assets/mp_backend/img/clock.svg" width="15px" height="15px">
																		</span><?php if($commentslist->created_on != "" && $commentslist->created_on != "0000-00-00 00:00:00"){echo date("d-m-Y H:i:s", strtotime($commentslist->created_on));}else { echo "";}?>
																	</span>
																	<span class="float_left pR5 notesgray dIB"><?php _trans('lable503');?></span>
																	<span class="float_left pR5 notesgray dIB" data-title="<?php echo $commentslist->employee_name;?>"><?php echo $commentslist->employee_name;?></span>
																	<?php if($commentslist->reschedule == 'Y'){ ?>
																		<span class="float_left pR5 notesgray dIB"><?php _trans('lable502');?></span>
																		<span class="float_left pR5 notesgray dIB">
																		<?php if($commentslist->reschedule_date != "" && $commentslist->reschedule_date != "0000-00-00 00:00:00"){echo date("d-m-Y H:i:s", strtotime($commentslist->reschedule_date));}else { echo "";}?>
																		</span>
																	<?php } ?>
																	<span class="pA whiteBg" id="noteOper_<?php echo $commentslist->comment_id;?>" style="top: 10px; right: 0px;">
																		<a style="float: right;" href="javascript:void(0)" class="editDeleteButtonsRight" onclick="delete_record('mech_comments',<?php echo $commentslist->comment_id; ?>, '<?=$this->security->get_csrf_hash(); ?>')" ><i class="fa fa-trash"></i></a>
																		<?php if($key == 0){ ?>
																		<a style="float: right;margin-right: 10px;" href="javascript:void(0)" onclick="editComments(<?php echo $commentslist->comment_id;?>);" class="editDeleteButtonsRight">
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
											<label class="control-label string required"><?php _trans('lable508');?> *</label>
										</div>
										<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
											<select name="note_user_id" id="note_user_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
												<option value=""><?php _trans('lable507');?></option>
												<?php foreach ($assigned_to as $assigned_to_list) {?>
												<option value="<?php echo $assigned_to_list->employee_id; ?>"><?php echo $assigned_to_list->employee_name; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group clearfix">
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
											<label class="control-label string required"><?php _trans('lable506');?></label>
										</div>
										<div class="form_controls col-lg-9 col-md-9 col-sm-9 col-xs-10 paddingTop10px text-left">
											<input type="checkbox"  id="reschedule" name="reschedule" value="N" autocomplete="off">
										</div>
									</div> 
									<div class="form-group clearfix" id="rescheduleBox" style="display:none;">
										<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right paddingTop10px">
											<label class="control-label string required"><?php _trans('lable505');?></label>
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

<script type="text/javascript">

$(document).ready(function(){
	
	$('.reschedule_date').datetimepicker({
        format: 'DD-MM-YYYY HH:mm:ss',
    });
	
	$("textarea").keyup(function() {
            var len = (this.value).length;
            if (len > 0) {
                $('#' + $(this).attr('name')).parent().removeClass('has-error');
                $('#' + $(this).attr('name')).removeClass('border_error');

            } 
        });

		$("select").keyup(function() {
            var len = (this.value).length;
            if (len > 0) {
                $('#' + $(this).attr('name')).parent().removeClass('has-error');
                $('#' + $(this).attr('name')).removeClass('border_error');

            } 
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

	$('#leads_car_brand_id').change(function () {
		$('#gif').show();
		$.post("<?php echo site_url('user_cars/ajax/get_brand_models'); ?>", {
			brand_id: $('#leads_car_brand_id').val(),
			_mm_csrf: $('input[name="_mm_csrf"]').val()
		},
		function (data) {
			var response = JSON.parse(data);
			if (response.length > 0) {
				$('#gif').hide();
				$('#leads_car_brand_model_id').empty(); 
				$('#leads_car_brand_model_id').append($('<option></option>').attr('value', '').text('Model'));
				for (row in response) {
					$('#leads_car_brand_model_id').append($('<option></option>').attr('value', response[row].model_id).text(response[row].model_name));
				}
				$('#leads_car_brand_model_id').selectpicker("refresh");
			}
			else {
				$('#gif').hide();
				$('#leads_car_brand_model_id').empty(); 
				$('#leads_car_brand_model_id').append($('<option></option>').attr('value', '').text('Model'));
				$('#leads_car_brand_model_id').selectpicker("refresh");
			}
		});
	});

	$('#leads_car_brand_model_id').change(function () {
		$('#gif').show();
		$.post("<?php echo site_url('user_cars/ajax/get_brand_model_variant'); ?>", {
			brand_id: $('#leads_car_brand_id').val(),
			model_id: $('#leads_car_brand_model_id').val(),
			_mm_csrf: $('input[name="_mm_csrf"]').val()
		},
		function (data) {
			var response = JSON.parse(data);
			if (response.length > 0) {
				$('#gif').hide();
				$('#car_variant').empty();
				$('#car_variant').append($('<option></option>').attr('value', '').text('Variant'));
				for (row in response) {
					$('#car_variant').append($('<option></option>').attr('value', response[row].brand_model_variant_id).text(response[row].variant_name));
				}
				$('#car_variant').selectpicker("refresh");
			}
			else {
				$('#gif').hide();
				$('#car_variant').empty();
				$('#car_variant').append($('<option></option>').attr('value', '').text('Variant'));
				$('#car_variant').selectpicker("refresh");
			}
		});
	});

	$(".btn_cancel").click(function () {
		window.location.href = "<?php echo site_url('mech_leads'); ?>";
	});

	// $('#lead_date').change(function() {
	// if ($('#lead_date').val() != '') {
	// 		$('.removeError').show();
	// 	}
	// }

	if ($('#customer_id').val() != '') {
		$('.addcarpopuplink').show();
	} else {
		$('.addcarpopuplink').hide();
	}

	$('#service_category_id').change(function () {

		// if($("#user_car_list_id").val() == ''){
		//     notie.alert(3, '<?php _trans('toaster5'); ?>', 2);
		//     $("#service_category_id").val(0);
		//     $('.bootstrap-select').selectpicker("refresh");
		//     return false;
		// }
		$('#gif').show();	
		$.post("<?php echo site_url('mech_item_master/ajax/getServiceList'); ?>", {
			service_category_id: $('#service_category_id').val(),
			user_car_list_id: $('#user_car_list_id').val(),
			_mm_csrf: $('input[name="_mm_csrf"]').val()
		},function (data) {
			var response = JSON.parse(data);
			if (response) {
				$('#gif').hide();
				$('#services_add_service').empty(); // clear the current elements in select box
				$('#services_add_service').append($('<option></option>').attr('value', '').text('Item'));
				for (row in response) {
					$('#services_add_service').append($('<option></option>').attr('value', response[row].msim_id).text(response[row].service_item_name));
				}
				$('#services_add_service').selectpicker("refresh");
			}else{
				$('#gif').hide();
				console.log("No data found");
			}
		});
	});

	$('#customer_id').change(function() {
		if ($('#customer_id').val() != '') {
			$('.addcarpopuplink').show();
		} else {
			$('.addcarpopuplink').hide();
		}
		$('#gif').show();
		$.post("<?php echo site_url('clients/ajax/get_customer_cars_address'); ?>", {
			customer_id: $('#customer_id').val(),
			_mm_csrf: $('input[name="_mm_csrf"]').val()
		},
		function(data) {
			var response = JSON.parse(data);
			$('.add_car').attr('data-customer-id', $('#customer_id').val());
			$('.add_address').attr('data-customer-id', $('#customer_id').val());
			$('#common_customer_id').val($('#customer_id').val());
			if (response.success == '1' || response.success == 1 ) {
				if (response.user_cars.length > 0) {
					$('#gif').hide();
					var cars = response.user_cars;
					$('#user_car_list_id').empty();
					$('#user_car_list_id').append($('<option></option>').attr('value', '').text('Select Customer Vehicle'));
					for (row in cars) {
						var user_cars_list = (cars[row].brand_name?cars[row].brand_name:'')+""+(cars[row].model_name?", "+cars[row].model_name: '')+""+(cars[row].variant_name?", "+cars[row].variant_name:'')+""+(cars[row].car_reg_no?", "+cars[row].car_reg_no: '');
						var cars_detail = user_cars_list;
						$('#user_car_list_id').append($('<option></option>').attr('value', cars[row].car_list_id).text(cars_detail));
					}
					$('#user_car_list_id').selectpicker("refresh");
				} else {
					$('#gif').hide();
					$('#user_car_list_id').empty();
					$('#user_car_list_id').append($('<option></option>').attr('value', '').text('Select Customer Vehicle'));
					$('#user_car_list_id').selectpicker("refresh");
				}
				if (response.user_address.length > 0) {
					$('#gif').hide();
					var add = response.user_address;
					$('#user_address_id').empty();
					$('#user_address_id').append($('<option></option>').attr('value', '').text('Select Customer Address'));
					for (row in add) {
						var full_address = ((add[row].customer_street_1)?add[row].customer_street_1:'')+" "+((add[row].customer_street_2)?", "+add[row].customer_street_2:'')+""+((add[row].area)?", "+add[row].area:'');
						var zip_code = (add[row].zip_code) ? add[row].zip_code : '';
						var address = full_address + ',' + zip_code;
						$('#user_address_id').append($('<option></option>').attr('value', add[row].user_address_id).text(address));
					}
					$('#user_address_id').selectpicker("refresh");
				} else {
					$('#gif').hide();
					$('#user_address_id').empty();
					$('#user_address_id').append($('<option></option>').attr('value', '').text('Select Customer Address'));
					$('#user_address_id').selectpicker("refresh");
				}
				if(response.customer_referrence.length > 0){
					$('#gif').hide();
					$("#refered_by_type").val(response.customer_referrence[0].refered_by_type).trigger("change");
					setTimeout(function(){ 
						$("#refered_by_id").val(response.customer_referrence[0].refered_by_id).trigger("change");
					}, 1000);
				}
			}
		});
	});

	
	$(".btn_submit").click(function () {

		var validation = [];
		if($("#invoice_group_id").val() == '' ){
			validation.push('invoice_group_id');
		}
		if($("#branch_id").val() == '' ){			
			validation.push('branch_id');
		}
		// if($("#user_id").val() == '' ){			
		// 	validation.push('user_id');
		// }
		if($("#customer_id").val() == '' ){			
			validation.push('customer_id');
		}
		// if($("#user_car_list_id").val() == ""){
		// 	validation.push('user_car_list_id');
		// }
		if($("#lead_status").val() == '' ){			
			validation.push('lead_status');
		}
		if($("#lead_date").val() == '' ){			
			validation.push('lead_date');
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

		if($("#ml_id").val() == ''){			
			var lead_reschedule_date = $("#lead_date").val();
		}else{			
			if($("#lead_reschedule_date").val() == '' || $("#lead_reschedule_date").val() == null || $("#lead_reschedule_date").val() == 'null'){
				var lead_reschedule_date = $("#lead_date").val();
			}else{
				var lead_reschedule_date = $("#lead_reschedule_date").val();
			}
		}
		$('#gif').show();

		$.post('<?php echo site_url('mech_leads/ajax/create'); ?>', {
			ml_id : $("#ml_id").val(),
			branch_id : $('#branch_id').val(),
			// user_id : $("#user_id").val(),
			category_type : 'L',
			customer_id : $("#customer_id").val(),
			user_address_id : $("#user_address_id").val(),
			user_car_list_id : $("#user_car_list_id").val(),
			// title : $("#title").val(),
			invoice_group_id : $("#invoice_group_id").val(),
			leads_no : $("#leads_no").val(),
			lead_date : $('#lead_date').val(),
			reschedule_date : lead_reschedule_date,
			lead_source : $('#lead_source').val(),
			lead_status: $('#lead_status').val(),
			action_from: 'L',
			btn_submit : $(this).val(),
			_mm_csrf: $('input[name="_mm_csrf"]').val()
		}, function (data) {
			list = JSON.parse(data);
			if(list.success=='1'){
				notie.alert(1, '<?php _trans('toaster1');?>', 2);
				setTimeout(function(){
					window.location = "<?php echo site_url('mech_leads/form'); ?>/"+list.ml_id+"/2";
				}, 100);
			}else if (list.success == '2') {
				$('#gif').hide();
				notie.alert(3, '<?php _trans('toaster2');?>', 2);
            }else{
				$('#gif').hide();
				notie.alert(3, '<?php _trans('toaster2');?>', 2);
				$('.has-error').removeClass('has-error');
				for (var key in list.validation_errors) {
					$('#' + key).parent().addClass('has-error');
					$('.error_msg_' + key).show().empty().html(list.validation_errors[key]);
				}
			}
		});
	});

	$("#save_service_product").click(function () {	
		var service_items = [];
		$('table#service_item_table tbody>tr.item').each(function () {
			var service_row = {};
			$(this).find('input,select,textarea').each(function () {
				if ($(this).is(':checkbox')) {
					service_row[$(this).attr('name')] = $(this).is(':checked');
				} else {
					service_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
				}
			});
			service_items.push(service_row);
		});

		var service_totals = [];
		$('table#service_item_table .service_total_calculations').each(function () {
			var service_total_row = {};
			$(this).find('input,select,textarea').each(function () {
				if ($(this).is(':checkbox')) {
					service_total_row[$(this).attr('name')] = $(this).is(':checked');
				} else {
					service_total_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
				}
			});
			service_totals.push(service_total_row);
		});

		var service_package_items = [];
		$('table#service_package_item_table tbody>tr.item').each(function () {
			var service_package_row = {};
			$(this).find('input,select,textarea').each(function () {
				if ($(this).is(':checkbox')) {
					service_package_row[$(this).attr('name')] = $(this).is(':checked');
				} else {
					service_package_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
				}
			});
			service_package_items.push(service_package_row);
		});

		var service_package_totals = [];
		$('table#service_package_item_table .service_total_calculations').each(function () {
			var service_package_total_row = {};
			$(this).find('input,select,textarea').each(function () {
				if ($(this).is(':checkbox')) {
					service_package_total_row[$(this).attr('name')] = $(this).is(':checked');
				} else {
					service_package_total_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
				}
			});
			service_package_totals.push(service_package_total_row);
		});

		var product_items = [];
		$('table#product_item_table tbody>tr.item').each(function () {
			var product_row = {};
			$(this).find('input,select,textarea').each(function () {
				if ($(this).is(':checkbox')) {
					product_row[$(this).attr('name')] = $(this).is(':checked');
				} else {
					product_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
				}
			});
			product_items.push(product_row);
		});

		var product_totals = [];
		$('table#product_item_table .product_total_calculations').each(function () {
			var product_total_row = {};
			$(this).find('input,select,textarea').each(function () {
				if ($(this).is(':checkbox')) {
					product_total_row[$(this).attr('name')] = $(this).is(':checked');
				} else	 {
					product_total_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
				}
			});
			product_totals.push(product_total_row);
		});
		$('#gif').show();
		$.post('<?php echo site_url('mech_leads/ajax/create_services_products'); ?>', {
			ml_id : $("#ml_id").val(),
			service_items : JSON.stringify(service_items),
			service_totals : JSON.stringify(service_totals),
			product_items: JSON.stringify(product_items),
			product_totals : JSON.stringify(product_totals),
			service_discountstate: $("#service_discountstate").val()?$("#service_discountstate").val():'',
			parts_discountstate: $("#parts_discountstate").val()?$("#parts_discountstate").val():'',
			service_user_total: $(".total_user_service_price").html()?$(".total_user_service_price").html().replace(/,/g, ''):'',
			discountstate: $("#discountstate").val()?$("#discountstate").val():'',
			service_total_discount_pct: $("#service_discount").val()?$("#service_discount").val().replace(/,/g, ''):0,
			service_total_discount: $(".service_total_discount").html()?$(".service_total_discount").html().replace(/,/g, ''):0,
			service_total_taxable: $(".total_user_service_taxable").html()?$(".total_user_service_taxable").html().replace(/,/g, ''):0,
			service_total_gst_pct:  $("#total_service_tax").val()?$("#total_service_tax").val().replace(/,/g, ''):0,
			service_total_gst: $(".total_servie_gst_price").html()?$(".total_servie_gst_price").html().replace(/,/g, ''):0,
			service_grand_total: $(".total_servie_invoice").html()?$(".total_servie_invoice").html().replace(/,/g, ''):0,
			
			service_package_items : JSON.stringify(service_package_items),
			service_package_totals : JSON.stringify(service_package_totals),
			service_package_user_total: $(".total_user_service_package_price").html()?$(".total_user_service_package_price").html().replace(/,/g, ''):'',
			packagediscountstate: $("#packagediscountstate").val()?$("#packagediscountstate").val().replace(/,/g, ''):'',
			service_package_total_discount_pct: $("#service_package_discount").val()?$("#service_package_discount").val().replace(/,/g, ''):0,
			service_package_total_discount: $(".service_package_total_discount").html()?$(".service_package_total_discount").html().replace(/,/g, ''):0,
			service_package_total_taxable: $(".total_user_service_package_taxable").html()?$(".total_user_service_package_taxable").html().replace(/,/g, ''):0,
			service_package_total_gst_pct:  $("#total_service_package_tax").val()?$("#total_service_package_tax").val().replace(/,/g, ''):0,
			service_package_total_gst: $(".total_servie_package_gst_price").html()?$(".total_servie_package_gst_price").html().replace(/,/g, ''):0,
			service_package_grand_total: $(".total_servie_package_invoice").html()?$(".total_servie_package_invoice").html().replace(/,/g, ''):0,
			
			product_user_total: $(".total_user_product_price").html()?$(".total_user_product_price").html().replace(/,/g, ''):0,
			product_total_discount: $(".product_total_discount").html()?$(".product_total_discount").html().replace(/,/g, ''):0,
			product_total_taxable: $(".total_user_product_taxable").html()?$(".total_user_product_taxable").html().replace(/,/g, ''):0,
			product_total_gst: $(".total_user_product_gst").html()?$(".total_user_product_gst").html().replace(/,/g, ''):0,
			product_grand_total: $(".total_product_invoice").html()?$(".total_product_invoice").html().replace(/,/g, ''):0,
			total_taxable_amount: $(".total_taxable_amount").html()?$(".total_taxable_amount").html().replace(/,/g, ''):0,
			overall_discount_amount: $(".overall_discount_amount").html()?$(".overall_discount_amount").html().replace(/,/g, ''):0,
			total_tax_amount: $(".total_gst_amount").html()?$(".total_gst_amount").html().replace(/,/g, ''):0,
			grand_total: $(".grand_total").html()?$(".grand_total").html().replace(/,/g, ''):0,
			description: $("#description").val()?$("#description").val():'',
			action_from: 'L',
			_mm_csrf: $('input[name="_mm_csrf"]').val()
		}, function (data) {
			list = JSON.parse(data);
			if(list.success == '1'){
				notie.alert(1, '<?php _trans('toaster1');?>', 2);
				setTimeout(function(){
					window.location = "<?php echo site_url('mech_leads/form'); ?>/"+list.ml_id+"/3";
				}, 100);
			}else{
				$('#gif').hide();
				notie.alert(3,'<?php _trans('toaster2');?>', 2);
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
		var note_user_id = $("#note_user_id").val()?$("#note_user_id").val():'';
		var reschedule = $("#reschedule").val()?$("#reschedule").val():'';
		var reschedule_date = $("#reschedule_date").val()?$("#reschedule_date").val():'';

        if($("#comments").val() == ''){
            validation.push('comments');
        }
		if($("#note_user_id").val() == ''){
			validation.push('note_user_id');
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
        $.post("<?php echo site_url('mech_leads/ajax/save_comments'); ?>", {
            ml_id : $("#ml_id").val(),
            comments: $('#comments').val()?$('#comments').val():'',
			modified_employee_id: $("#note_user_id").val()?$("#note_user_id").val():'',
			reschedule: $('#reschedule').val()?$('#reschedule').val():'',
			reschedule_date: $("#reschedule_date").val()?$("#reschedule_date").val():'',
            entity_type: 'L',
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

});
</script>