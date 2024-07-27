<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php echo $breadcrumb; ?></h3>
				</div>
				<div class="tbl-cell pull-right">
					<a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_rewards/create'); ?>">
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
			<a class="anchor anchor-back" href="<?php echo site_url('workshop_setup/index/9'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
		</div>
	</div>
	<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
	<input type="hidden" name="mrdlts_id" id="mrdlts_id" value="<?php echo $rewards_detail->mrdlts_id; ?>">
	<div class="box_body col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding0px">
			<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<label class="form_label"><?php _trans('lable51'); ?>*</label>
				<select id="branch_id" name="branch_id" class="bootstrap-select bootstrap-select-arrow g-input form-control removeError" data-live-search="true" autocomplete="off">
					<option value=""><?php _trans('lable51'); ?></option>
					<?php foreach ($branch_list as $branch) { if($branch->rewards == 'Y'){ ?>
					<option value="<?php echo $branch->w_branch_id; ?>" <?php if($rewards_detail->branch_id == $branch->w_branch_id){echo "selected";}?> > <?php echo $branch->display_board_name; ?></option>
					<?php } } ?>
				</select>
			</div> 
			<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<label class="form_label"><?php _trans('lable801'); ?>*</label>
				<select id="applied_for" name="applied_for" class="bootstrap-select bootstrap-select-arrow g-input form-control removeError" data-live-search="true" autocomplete="off">
					<option value=""><?php _trans('lable241'); ?></option>
					<option value="A" <?php if($rewards_detail->applied_for == 'A'){echo "selected";}?> ><?php _trans('lable802'); ?></option>
					<option value="P" <?php if($rewards_detail->applied_for == 'P'){echo "selected";}?> ><?php _trans('lable803'); ?></option>
					<option value="S" <?php if($rewards_detail->applied_for == 'S'){echo "selected";}?> ><?php _trans('lable804'); ?></option>
				</select>
			</div>
			<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<label class="form_label"><?php _trans('lable805'); ?>*</label>
				<select id="reward_type" name="reward_type" class="bootstrap-select bootstrap-select-arrow g-input form-control removeError" data-live-search="true" autocomplete="off">
					<option value=""><?php _trans('lable805'); ?></option>
					<option value="P" <?php if($rewards_detail->reward_type == 'P'){ echo "selected"; } ?>><?php _trans('lable798'); ?></option>
					<option value="R" <?php if($rewards_detail->reward_type == 'R'){ echo "selected"; } ?>><?php _trans('lable799'); ?></option>
					<option value="A" <?php if($rewards_detail->reward_type == 'A'){ echo "selected"; } ?>><?php _trans('lable800'); ?></option>
				</select>
			</div>
			<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<label class="form_label"><?php _trans('lable806'); ?></label>
				<input type="text" name="reward_amount" id="reward_amount" class="form-control" value="<?php echo $rewards_detail->reward_amount; ?>">
			</div> 
			<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12 paddingTop10px">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop40px">
					<input type="radio" name="inclusive_exclusive" <?php echo ($rewards_detail->inclusive_exclusive == 1)?'checked':'' ?> value="1"> <?php _trans('lable807'); ?><br>
				</div>
			</div>  
			<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12 paddingTop10px">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop40px">
					<input type="radio" name="inclusive_exclusive" <?php echo ($rewards_detail->inclusive_exclusive == 2)?'checked':'' ?> value="2"> <?php _trans('lable808'); ?><br>
				</div>
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

	$("#btn_cancel").click(function () {
        window.location.href = "<?php echo site_url('workshop_setup/index/9'); ?>";
    }); 
    
    $(".btn_submit").click(function () {

		var validation = [];
		var branch_id = $("#branch_id").val();
		var reward_type = $("#reward_type").val();

		if($("#branch_id").val() == ''){
			validation.push('branch_id');
		}

		if($("#applied_for").val() == ''){
			validation.push('applied_for');
		}

		if($("#reward_type").val() == ''){
			validation.push('reward_type');
		}
		
		if(reward_type != 'A' && reward_type != ''){
			if($("#reward_amount").val() == ''){
				validation.push('reward_amount');
			}
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

		if($("input[name='inclusive_exclusive']:checked").length == 0){
			notie.alert(3, 'Please choose inclusive or Exclusive', 2);
			return false;
		}

		$('#gif').show();
		$.post('<?php echo site_url('mech_rewards/ajax/rewards_save'); ?>', {
            mrdlts_id : $("#mrdlts_id").val(),
            branch_id : $("#branch_id").val(),
			applied_for : $("#applied_for").val(),
			inclusive_exclusive : $("input:radio[name=inclusive_exclusive]:checked").val(),
			reward_type : $("#reward_type").val(),
			reward_amount : $("#reward_amount").val(),
			_mm_csrf: $('#_mm_csrf').val()
        }, function (data) {
            list = JSON.parse(data);
            if(list.success=='1'){
                notie.alert(1, 'Successfully Created', 2);
                setTimeout(function(){ 
                    window.location = "<?php echo site_url('workshop_setup/index/9'); ?>";
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