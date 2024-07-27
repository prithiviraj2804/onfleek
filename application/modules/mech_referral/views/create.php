<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php echo $breadcrumb; ?></h3>
				</div>
				<div class="tbl-cell pull-right">
					<a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_referral/create'); ?>">
						<i class="fa fa-plus"></i> <?php _trans('lable40'); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</header>
<div class="box expense">
	<div class="row">
		<div id="gif" class="gifload">
			<div class="gifcenter">
			  <center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
		    </div>
		</div>
		<div class="col-xs-12 top-15">
			<a class="anchor anchor-back" href="<?php echo site_url('workshop_setup/index/6'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
		</div>
	</div>
	<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
	<input type="hidden" name="mrefh_id" id="mrefh_id" value="<?php echo $referral_detail->mrefh_id; ?>">
	<div class="box_body col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding0px">
			<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<label class="form_label"><?php _trans('lable51'); ?>*</label>
				<select id="branch_id" name="branch_id" class="bootstrap-select bootstrap-select-arrow g-input form-control removeError" data-live-search="true" autocomplete="off">
					<option value=""><?php _trans('lable51'); ?></option>
					<?php foreach ($branch_list as $branch) {
						if($branch->referral == 'Y'){
						?>
					<option value="<?php echo $branch->w_branch_id; ?>" <?php if($referral_detail->branch_id == $branch->w_branch_id){echo "selected";}?> > <?php echo $branch->display_board_name; ?></option>
					<?php } } ?>
				</select>
			</div>    
		</div>
		<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12 paddingTop20px" >
			<h6 style="margin-bottom: 0px;width: auto;float: left;"><?php _trans('lable819'); ?></h6>
			<label class="switch" style="margin-left: 20px;">
			<input type="checkbox" class="checkbox" <?php if($referral_detail->cusreffCheckBox == 'Y'){ echo "checked"; } ?> name="checkbox" id="cusreffCheckBox" value="<?php echo ($referral_detail->cusreffCheckBox?$referral_detail->cusreffCheckBox:'N'); ?>" data-target="cuscollapse">
				<span class="slider round"></span>
			</label>
		</div>
		<div class="collapse col-lg-12 col-lg-12 col-sm-12 col-xs-12 paddingTop20px <?php if($referral_detail->cusreffCheckBox == 'Y'){ echo 'in'; }?>" id="cuscollapse">
			<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<label class="form_label"><?php _trans('lable797'); ?>*</label>
				<select id="cus_ref_type" name="cus_ref_type" class="bootstrap-select bootstrap-select-arrow g-input form-control removeError" data-live-search="true" autocomplete="off">
					<option value=""><?php _trans('lable797'); ?></option>
					<option value="P" <?php if($referral_detail->cus_ref_type == 'P'){ echo "selected"; } ?>><?php _trans('lable798'); ?></option>
					<option value="R" <?php if($referral_detail->cus_ref_type == 'R'){ echo "selected"; } ?>><?php _trans('lable799'); ?></option>
					<option value="A" <?php if($referral_detail->cus_ref_type == 'A'){ echo "selected"; } ?>><?php _trans('lable800'); ?></option>
				</select>
			</div> 
			<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<label class="form_label"><?php _trans('lable175'); ?>*</label>
				<input type="text" name="cus_ref_pt" id="cus_ref_pt" class="form-control" value="<?php echo $referral_detail->cus_ref_pt; ?>">
			</div> 
			<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<label class="form_label"><?php _trans('lable176'); ?>*</label>
				<input type="text" name="cus_red_pt" id="cus_red_pt" class="form-control" value="<?php echo $referral_detail->cus_red_pt; ?>">
			</div> 
		</div>
		<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12 paddingTop20px" >
			<h6 style="margin-bottom: 0px;width: auto;float: left;"><?php _trans('lable818'); ?></h6>
			<label class="switch" style="margin-left: 20px;">
				<input type="checkbox" class="checkbox" <?php if($referral_detail->empreffCheckBox == 'Y'){ echo "checked"; } ?> name="checkbox" id="empreffCheckBox" value="<?php echo ($referral_detail->empreffCheckBox?$referral_detail->empreffCheckBox:'N'); ?>" data-target="empcollapse">
				<span class="slider round"></span>
			</label>
		</div>
		<div class="collapse col-lg-12 col-lg-12 col-sm-12 col-xs-12 paddingTop20px <?php if($referral_detail->empreffCheckBox == 'Y'){ echo 'in'; }?>" id="empcollapse">
			<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<label class="form_label"><?php _trans('lable797'); ?>*</label>
				<select id="emp_ref_type" name="emp_ref_type" class="bootstrap-select bootstrap-select-arrow g-input form-control removeError" data-live-search="true" autocomplete="off">
					<option value=""><?php _trans('lable797'); ?></option>
					<option value="P" <?php if($referral_detail->emp_ref_type == 'P'){ echo "selected"; } ?> ><?php _trans('lable798'); ?></option>
					<option value="R" <?php if($referral_detail->emp_ref_type == 'R'){ echo "selected"; } ?>><?php _trans('lable799'); ?></option>
					<option value="A" <?php if($referral_detail->emp_ref_type == 'A'){ echo "selected"; } ?>><?php _trans('lable800'); ?></option>
				</select>
			</div> 
			<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<label class="form_label"><?php _trans('lable175'); ?>*</label>
				<input type="text" name="emp_ref_pt" id="emp_ref_pt" class="form-control" value="<?php echo $referral_detail->emp_ref_pt; ?>">
			</div> 
			<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<label class="form_label"><?php _trans('lable176'); ?>*</label>
				<input type="text" name="emp_red_pt" id="emp_red_pt" class="form-control" value="<?php echo $referral_detail->emp_red_pt; ?>">
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop20px">
			<div class="buttons text-center">
				<button id="btn_submit" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
				    <i class="fa fa-check"></i> <?php _trans('lable57'); ?>
				</button>
				<button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default">
				    <i class="fa fa-times"></i> <?php _trans('lable58'); ?>
				</button>
			</div>
		</div>
	<div>
</div>
<script type="text/javascript">

	$("#cusreffCheckBox").click(function(){
		if($("#cusreffCheckBox:checked").is(":checked")){
			$("#cuscollapse").addClass('in');
			$("#cusreffCheckBox").val('Y');
		}else{
			$("#cuscollapse").removeClass('in');
			$("#cusreffCheckBox").val('N');
		}
	});

	$("#empreffCheckBox").click(function(){
		if($("#empreffCheckBox:checked").is(":checked")){
			$("#empcollapse").addClass('in');
			$("#empreffCheckBox").val('Y');
		}else{
			$("#empcollapse").removeClass('in');
			$("#empreffCheckBox").val('N');
		}
	});

	$("#btn_cancel").click(function () {
        window.location.href = "<?php echo site_url('workshop_setup/index/6'); ?>";
    }); 

    $(".btn_submit").click(function () {

		$('.has-error').removeClass('has-error');
		$('.border_error').removeClass('border_error');

		var validation = [];

		if($("#branch_id").val() == ''){
			validation.push('branch_id');
		}
		
		// var branch_id = $("#branch_id").val();
		var cusreffCheckBox = $("#cusreffCheckBox").val();
		var empreffCheckBox = $("#empreffCheckBox").val();

		if(cusreffCheckBox == 'N' &&  empreffCheckBox == 'N'){
			notie.alert(3, 'Please select any referral type', 2);
			return false;
		}

		if(cusreffCheckBox == 'Y'){
			if($("#cus_ref_type").val() == ''){
				validation.push('cus_ref_type');
			}
			if($("#cus_ref_pt").val() == ''){
				validation.push('cus_ref_pt');
			}
			if($("#cus_red_pt").val() == ''){
				validation.push('cus_red_pt');
			}	
		}else{
			$("#cus_ref_type").val('');
			$("#cus_ref_pt").val('');
			$("#cus_red_pt").val('');
		}

		if(empreffCheckBox == 'Y'){
			if($("#emp_ref_type").val() == ''){
				validation.push('emp_ref_type');
			}
			if($("#emp_ref_pt").val() == ''){
				validation.push('emp_ref_pt');
			}
			if($("#emp_red_pt").val() == ''){
				validation.push('emp_red_pt');
			}	
		}else{
			$("#emp_ref_type").val() == '';
			$("#emp_ref_pt").val() == '';
			$("#emp_red_pt").val() == '';
		}

		if(validation.length > 0){
			validation.forEach(function(val) {
				$('#'+val).addClass("border_error");
				if($('#'+val+'_error').length == 0){
					$('#' + val).parent().addClass('has-error');
				} 
			});
			return false;
		}

		$('.has-error').removeClass('has-error');
		$('.border_error').removeClass('border_error');
		$('#gif').show();

		$.post('<?php echo site_url('mech_referral/ajax/referral_save'); ?>', {
            mrefh_id : $("#mrefh_id").val(),
            branch_id : $("#branch_id").val(),
            cusreffCheckBox : $('#cusreffCheckBox').val(),
			empreffCheckBox : $("#empreffCheckBox").val(),
			cus_ref_type : $("#cus_ref_type").val(),
			emp_ref_type : $("#emp_ref_type").val(),
			cus_ref_pt : $("#cus_ref_pt").val()?$("#cus_ref_pt").val():'',
            emp_ref_pt : $('#emp_ref_pt').val()?$('#emp_ref_pt').val():'',
			cus_red_pt : $('#cus_red_pt').val()?$('#cus_red_pt').val():'',
			emp_red_pt : $("#emp_red_pt").val()?$("#emp_red_pt").val():'',
			_mm_csrf: $('#_mm_csrf').val()
        }, function (data) {
            list = JSON.parse(data);
            if(list.success=='1'){
                notie.alert(1, 'Successfully Created', 2);
                setTimeout(function(){ 
                    window.location = "<?php echo site_url('workshop_setup/index/6'); ?>";
                }, 1000);
            }else if(list.success=='2'){
				$('#gif').hide();
                notie.alert(3, 'Please choose other branch', 2);
            }else{
				$('#gif').hide();
				$('.has-error').removeClass('has-error');
                for (var key in list.validation_errors) {
                    $('#' + key).parent().addClass('has-error');
                    $('.error_msg_' + key).show().empty().html(list.validation_errors[key]);
                }
            }
        });
	});
</script>