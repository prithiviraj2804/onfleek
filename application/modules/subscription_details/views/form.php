
    <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?= $this->security->get_csrf_hash(); ?>">
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
	
    <div id="content">
        <div class="row">
			
		<div id="gif" class="gifload">
			<div class="gifcenter">
			  <center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
		    </div>
		</div>
				<div class="col-xs-12 top-15">
					<a class="anchor anchor-back" onclick="goBack()"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
				</div>
            <div class="col-xs-12 col-md-12 col-md-offset-3">
				<div class="container-wide">

					<div class="col-sm-9">
						<input type="hidden" name="plan_sub_id" id="plan_sub_id" class="form-control" value="<?php echo $this->mdl_subscription_details->form_value('plan_sub_id', true); ?>"autocomplete="off">
						<input type="hidden" name="invoice_group_id" id="invoice_group_id" class="form-control" value="<?php echo $subscription_group->invoice_group_id; ?>"autocomplete="off">
						<input type="hidden" name="workshop_email" id="workshop_email" class="form-control" value="<?php echo $workshop_email; ?>"autocomplete="off">
						<input type="hidden" name="workshop_name" id="workshop_name" class="form-control" value="<?php echo $workshop_name; ?>"autocomplete="off">
					</div>
					<div class="box">
						<div class="box_body">	
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('lable1131'); ?>*</label>
									</div>
									<div class="col-sm-9">
										<?php $selected = 'selected="selected"';$plan_type = $plan_list->plan_id;?>
										<select name="plan_id" id="plan_id" class="plan bootstrap-select bootstrap-select-arrow removeError">
											<option value=""><?php _trans('lable1133'); ?></option>
											<?php foreach ($plan_list as $plan) { ?>
											<option data-monthly-amount="<?php echo $plan->monthly_amount; ?>"
											data-quarterly-amount="<?php echo $plan->quarterly_amount; ?>"
											data-halfly-amount="<?php echo $plan->halfly_amount; ?>"
											data-annual-amount="<?php echo $plan->annual_amount; ?>" value="<?php echo $plan->plan_id; ?>" > <?php echo $plan->plan_name; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('lable1094'); ?>*</label>
									</div>
									<div class="col-sm-9">
										<?php $selected = 'selected="selected"';$plan_type = $plan_list->plan_id;?>
										<select name="plan_month_type" id="plan_month_type" class="plan bootstrap-select bootstrap-select-arrow removeError">
											<option value=""><?php _trans('lable1134'); ?></option>
 											<option value="1" <?php if (1 == $plan_type) {echo $selected;} ?>><?php _trans('lable1135'); ?></option>
											<option value="3" <?php if (3 == $plan_type) {echo $selected;} ?>><?php _trans('lable1136'); ?></option>
											<option value="6" <?php if (6 == $plan_type) {echo $selected;} ?>><?php _trans('lable1137'); ?></option>
											<option value="12" <?php if (12 == $plan_type) {echo $selected;} ?>><?php _trans('lable1138'); ?></option>
										</select>
									</div>
								</div>
								<div class="form-group clearfix tot_amt">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('lable114'); ?>*</label>
									</div>
									<div class="col-sm-9">
									<label name="plan_amt" id="plan_amt" style="text-align:left;" class="control-label string required"></label>
									</div>
								</div>
									<input type="hidden" name="plan_save_amount" id="plan_save_amount">								
									<div class="buttons text-center paddingtop15px">
									<button value="2" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
										<i class="fa fa-check"></i> <?php _trans('lable57'); ?>
									</button>
									<button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default">
										<i class="fa fa-times"></i> <?php _trans('lable58'); ?>
									</button>
								</div>	
							</div>
						</div>
					</div>
            </div>
			</div>
        </div>
    </div>

	<script type="text/javascript">
	$(".tot_amt").hide();

	function goBack() {
      window.history.back();
    }
		
	$("#btn_cancel").click(function () {
        window.location.href = "<?php echo site_url('workshop_setup/index/12'); ?>";
	});
	

	$('.plan').change(function() {

		var plan_id;
		var plan_month_type;
		var plan_amt;
		var total_amt = 0;
		plan_id = $('#plan_id').val();
		plan_month_type = $('#plan_month_type').val();

		if(plan_id != '' && plan_month_type !=''){

			if(plan_month_type == 1){
				plan_amt = $("#plan_id").find('option:selected').attr('data-monthly-amount');
			}else if(plan_month_type == 3){
				plan_amt = $("#plan_id").find('option:selected').attr('data-quarterly-amount');
			}else if(plan_month_type == 6){
				plan_amt = $("#plan_id").find('option:selected').attr('data-halfly-amount');
			}else if(plan_month_type == 12){
				plan_amt = $("#plan_id").find('option:selected').attr('data-annual-amount');
			}
			total_amt = plan_amt;
			$("#plan_amt").empty().append(total_amt);
			$("#plan_save_amount").empty().val(total_amt);
		}
		if(total_amt){
			$(".tot_amt").show();
		}else{
			$(".tot_amt").hide();
		}

	});

    $(".btn_submit").click(function () {

		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');

		var plan= [];
		
		if($("#plan_id").val() == ''){
			plan.push('plan_id');
		}

		if($("#plan_month_type").val() == ''){
			plan.push('plan_month_type');
		}

		if(plan.length > 0){
			plan.forEach(function(val) {
				$('#'+val).addClass("border_error");
				if($('#'+val+'_error').length == 0){
					$('#' + val).parent().addClass('has-error');
				} 
			});
			return false;
		}

		$('#gif').show();

		$.post('<?php echo site_url('subscription_details/ajax/create'); ?>', {
			plan_id : $('#plan_id').val(),
			plan_month_type : $('#plan_month_type').val(),
			save_plan : $(this).val(),
			total_amt : $('#plan_save_amount').val(),
			invoice_group_id : $('#invoice_group_id').val(),
			workshop_email_id : $('#workshop_email').val(),
			workshop_name : $('#workshop_name').val(),
			_mm_csrf: $('#_mm_csrf').val()
        }, function (data) {
			console.log(data);
            list = JSON.parse(data);
            if(list.success=='1'){
            	notie.alert(1, 'Successfully Created', 3);
				setTimeout(function(){
					window.location = "<?php echo site_url('workshop_setup/index/12'); ?>";
				}, 100);
            }else{
				$('#gif').hide();
				notie.alert(3, 'Oops, something has gone wrong', 2);
            }
        });
	});

</script>
