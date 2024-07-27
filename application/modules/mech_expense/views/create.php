
<script type="text/javascript">

var default_currency_digit  = parseInt('<?php echo $this->session->userdata("default_currency_digit")?$this->session->userdata("default_currency_digit"):0; ?>');

	function formatDates(date){
		var dt = new Date(date);
		var dtd = dt.getDate();
		var dtm = dt.getMonth()+1;
		var dty = dt.getFullYear();
		return  ('0' + dtd).slice(-2) + "-" + ('0' + dtm).slice(-2) + "-" + dty ;
	}

	function changeDueDatebyCreated(created_date,days,due_date){
		var billDays = $("#"+days).val();
		if(billDays=='')
		{
		var billDate = $('#'+created_date).val();
		setTimeout(function(){ 
			$('#'+due_date).val(billDate);
		}, 100);
		}
		else
		{
			var billDates = $('#'+created_date).val().split("/").reverse().join("-");
			var billDate = new Date(billDates);
			var billDays = parseInt($("#"+days).val(), 10);
			var newDate = billDate.setDate(billDate.getDate() + billDays);
			var dueDate = formatDates(newDate);
			setTimeout(function(){ 
				$('#' + due_date).val(dueDate.split("-").join("/"));
			}, 100);
		}
	}

	function changeDueDatebyDay(created_date,days,due_date){
		var billDays = $("#"+days).val();
		var billDate = $('#'+created_date).val().split("/").reverse().join("-");
		if(billDays < 0 || billDays == ""){
			$("#"+days).val(0);
			billDays = 0;
		}
		if (billDays.length > 4){
		billDays = billDays.slice(0, 4);
		}
		var billDate = new Date($('#'+created_date).val().split("/").reverse().join("-"));
		var billDays = parseInt($("#"+days).val(), 10);
		var newDate = billDate.setDate(billDate.getDate() + billDays); 
		var dueDate = formatDates(newDate);
		setTimeout(function(){ 
			$('#' + due_date).val(dueDate.split("-").join("/"));
		}, 100);
		$("#"+days).val(parseInt(billDays));
	}

	function changeCreditPeriodbyDueDate(created_date,days,due_date) {
		var billDates = $('#'+created_date).val().split("/").reverse().join("-");
		var billDate = new Date(billDates).getDate();
		var dueDates = $('#'+due_date).val().split("/").reverse().join("-");
		var dueDate = new Date(dueDates).getDate();
		var creditedDays = dueDate - billDate;
		$('#'+days).val(creditedDays);
	}

	function overall_grand_calc(){
		
		var amount = parseFloat($("#amount").val()?($("#amount").val().replace(/,/g, '')):0);
		$("#amount").val(format_money(parseFloat(amount).toFixed(2),default_currency_digit));
		if(amount > 0.00){
			$("#total_amount").empty().append(format_money(parseFloat(amount).toFixed(2),default_currency_digit));
			var tax_percentage = $("#tax_percentage").val()?$("#tax_percentage").val():0;
			$("#tax_amount_lable").empty().append(0.00);
			$("#tax_amount").val(0.00);
			if(tax_percentage > 0.00){
				console.log("amount=="+amount);
				var grand_tax_amount = (parseFloat(amount)*parseFloat(tax_percentage))/100;
				
				$("#tax_amount_lable").empty().append(format_money(parseFloat(grand_tax_amount).toFixed(2),default_currency_digit));
				$("#tax_amount").val(parseFloat(grand_tax_amount).toFixed(2));
				$("#grand_total").empty().append(format_money((parseFloat(amount)+parseFloat(grand_tax_amount)).toFixed(2),default_currency_digit));
			}else{
				
				$("#grand_total").empty().append(format_money((parseFloat(amount)).toFixed(2),default_currency_digit));
			}
		}else{
			$("#total_amount").empty().append("0.00");
			$("#grand_total").empty().append(format_money((parseFloat(amount)).toFixed(2),default_currency_digit));
		}
	}
</script>

<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php echo _trans($breadcrumb); ?> <?php if($expense_details->expense_no) { echo " - ".$expense_details->expense_no; } ?></h3>
				</div>
				<div class="tbl-cell pull-right">
					<a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_expense/create'); ?>">
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
			<a class="anchor anchor-back" href="<?php echo site_url('mech_expense/index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
		</div>
	</div>
	<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" autocomplete="off"/>
	<input type="hidden" name="expense_id" id="expense_id" value="<?php echo ($expense_details->expense_id?$expense_details->expense_id:""); ?>" autocomplete="off">
	<input type="hidden" name="expense_no" id="expense_no" value="<?php echo ($expense_details->expense_no?$expense_details->expense_no:""); ?>" autocomplete="off">
	<input type="hidden" name="payment_status" id="payment_status" value="<?php echo ($expense_details->payment_status?$expense_details->payment_status:""); ?>" autocomplete="off">
	<div class="box_body col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding0px">
			<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<label class="form_label"><?php _trans('lable34'); ?></label>
				<div class="form_controls">
					<input type="text" name="bill_no" id="bill_no" class="form-control" value="<?php echo ($expense_details->bill_no?$expense_details->bill_no:""); ?>" autocomplete="off">
				</div>
			</div>
			<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<label class="form_label"><?php _trans('lable51'); ?>*</label>
				<select id="branch_id" name="branch_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
					<?php foreach ($branch_list as $branchList) {?>
					<option value="<?php echo $branchList->w_branch_id; ?>" <?php if($expense_details->branch_id == $branchList->w_branch_id){echo "selected";}?> > <?php echo $branchList->display_board_name; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<label class="form_label"> <?php _trans('lable386'); ?>*</label>
				<div class="form_controls">
					<input type="text" onchange="changeDueDatebyCreated('expense_date','in_days','expense_date_due')" name="expense_date" id="expense_date" class="form-control removeErrorInput datepicker" value="<?php echo $expense_details->expense_date?date_from_mysql($expense_details->expense_date):date_from_mysql(date('Y-m-d')); ?>" autocomplete="off">
					<label class="pop_textbox_error_msg error_msg_expense_date_created" style="display: none"></label>
				</div>
			</div>
		</div>         
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding0px">
			<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<label class="form_label"><?php _trans('lable454'); ?>*</label>
				<div class="form_controls">
					<select class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" name="expense_head_id" id="expense_head_id">
						<option value=""><?php echo trans('lable467'); ?></option>
						<?php foreach ($expense_category_items as $expcatlist) { ?>
						<option value="<?php echo $expcatlist->expense_category_id; ?>" 
						<?php if ($expcatlist->expense_category_id == $expense_details->expense_head_id) {
			echo "selected='selected'"; } ?> >
						<?php echo $expcatlist->expense_category_name; ?></option>
						<?php } ?>
					</select>
					<div class="col-lg-12 paddingLeft0px paddingTop5px">
						<a href="javascript:void(0)" data-toggle="modal" data-model-from="expense" data-target="#addNewCar" class="float_left fontSize_85rem add_expense_type">
							+ <?php echo trans('lable468'); ?>
						</a>
					</div>
				</div>
			</div>
			<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<label class="form_label"><?php _trans('lable464'); ?>. *</label>
				<select name="invoice_group_id" id="invoice_group_id" <?php if($expense_details->expense_id){ echo 'disabled'; } ?> class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
				    <?php if(count($invoice_group) > 1){ ?> 
					<?php if($this->session->userdata('user_type') == 3){?>
					<option value=""><?php _trans('lable277'); ?></option>
					<?php } }?>
					<?php foreach ($invoice_group as $invoice_group_list) {
						if (!empty($expense_details) > 0) {
							if ($expense_details->invoice_group_id == $invoice_group_list->invoice_group_id) {
								$selected = 'selected="selected"';
							} else {
								$selected = '';
							}
						} else {
							$selected = '';
						} ?>
						<option value="<?php echo $invoice_group_list->invoice_group_id; ?>" <?php echo $selected; ?>><?php echo $invoice_group_list->invoice_group_name; ?></option>
					<?php
					} ?>
				</select>
			</div>
			<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<label class="form_label"><?php _trans('lable390'); ?></label>
				<input type="hidden" value="<?php echo $deposit_id;?>" name="deposit_id" id="deposit_id" autocomplete="off">
				<select id="bank_id" name="bank_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
					<option value=""><?php _trans('lable390'); ?></option>
					<?php foreach ($bank_list as $bankList) {?>
					<option value="<?php echo $bankList->bank_id; ?>" <?php if($expense_details->bank_id == $bankList->bank_id){echo "selected";}?> > <?php echo $bankList->account_number." (".$bankList->bank_name.")"; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding0px">
			<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<label class="form_label"><?php _trans('lable108'); ?>*</label>
				<div class="form_controls">
					<input type="text" name="amount" id="amount" class="form-control" onblur="overall_grand_calc()" value="<?php echo ($expense_details->amount?format_money($expense_details->amount,$this->session->userdata('default_currency_digit')):0); ?>" autocomplete="off">
					<label class="pop_textbox_error_msg error_msg_expense_number" style="display: none"></label>
				</div>
			</div>
			<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<label class="form_label"><?php _trans('lable883'); ?> *</label>
				<div class="form_controls">
					<select name="is_credit" id="is_credit" <?php if($expense_details->is_credit != "" && $expense_details->payment_status != 4 && $expense_details->payment_status != ''){ echo 'disabled'; } ?> class="form-control bootstrap-select bootstrap-select-arrow removeError" data-live-search="true" autocomplete="off">
						<option value=""><?php _trans('lable382'); ?></option>
						<option value="Y" <?php if($expense_details->is_credit == "Y"){echo "selected";}?>><?php _trans('lable522'); ?></option>
						<option value="N" <?php if($expense_details->is_credit == "N"){echo "selected";}?>><?php _trans('lable538'); ?></option>
					</select>
				</div>
			</div>
			<div id="paid" <?php if($expense_details->is_credit == "N"){ echo 'style="display:block;"';} else { echo 'style="display:none;"'; }?> >
				<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<label class="form_label"><?php _trans('lable109'); ?>*</label>
					<div class="form_controls">
						<select class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" name="payment_type_id" id="payment_type_id">
							<option value=""><?php echo trans('lable466'); ?></option>
							<?php foreach ($payment_methods as $payMetList) { ?>
							<option value="<?php echo $payMetList->payment_method_id; ?>" 
							<?php if($payMetList->payment_method_id == $expense_details->payment_type_id) { echo "selected='selected'"; } ?> >
							<?php echo $payMetList->payment_method_name; ?></option>
							<?php } ?>
						</select>
						<label class="pop_textbox_error_msg error_msg_mode_of_payment" style="display: none"></label>
					</div>
				</div>
				<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12 showChequeDetailBoxs" style="display:none;">
					<label class="form_label"><?php _trans('lable755'); ?>*</label>
					<div class="form_controls">
					<input type="text" name="cheque_no" id="cheque_no" <?php if($expense_details->is_credit == "N" && $expense_details->payment_status != 4 && $expense_details->payment_status != ''){ echo 'readonly'; } ?> class="form-control car_reg_no" value="<?php echo $expense_details->cheque_no; ?>"autocomplete="off">    
					</div>
				</div> 
				<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12 showChequeDetailBoxs" style="display:none;">
					<label class="form_label"><?php _trans('lable756'); ?>*</label>
					<div class="form_controls">
					<input type="text" name="cheque_to" id="cheque_to" <?php if($expense_details->is_credit == "N" && $expense_details->payment_status != 4 && $expense_details->payment_status != ''){ echo 'readonly'; } ?> class="form-control" value="<?php echo $expense_details->cheque_to; ?>"autocomplete="off">    
					</div>
				</div> 
				<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12 showChequeDetailBoxs" style="display:none;">
					<label class="form_label"><?php _trans('lable99'); ?>*</label>
					<div class="form_controls">
					<input type="text" name="bank_name" id="bank_name" <?php if($expense_details->is_credit == "N" && $expense_details->payment_status != 4 && $expense_details->payment_status != ''){ echo 'readonly'; } ?> class="form-control" value="<?php echo $expense_details->bank_name; ?>"autocomplete="off">    
					</div>
				</div> 
				<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<label class="form_label"><?php _trans('lable385'); ?></label>
					<div class="form_controls">
					<input type="text" name="online_payment_ref_no" id="online_payment_ref_no" <?php if($expense_details->is_credit == "N" && $expense_details->payment_status != 4 && $expense_details->payment_status != ''){ if($expense_details->online_payment_ref_no){ echo 'readonly';} } ?> class="form-control" value="<?php echo $expense_details->online_payment_ref_no; ?>"autocomplete="off">    
					</div>
				</div>              
			</div>
			<div id="credit" <?php if($expense_details->is_credit == "Y"){ echo 'style="display:block;"';} else { echo 'style="display:none;"'; }?> >
				<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<label class="form_label"><?php _trans('lable387'); ?></label>
					<div class="form_controls">
						<input type="text" onchange="changeDueDatebyDay('expense_date','in_days','expense_date_due')" name="in_days" id="in_days" class="form-control" value="<?php echo $expense_details->in_days; ?>"autocomplete="off">
					</div>
				</div>
				<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<label class="form_label"> <?php _trans('lable127'); ?></label>
					<div class="form_controls">
						<input type="text" onchange="changeCreditPeriodbyDueDate('expense_date','in_days','expense_date_due')" name="expense_date_due" id="expense_date_due" class="form-control datepicker" value="<?php echo $expense_details->expense_date_due?date_from_mysql($expense_details->expense_date_due):''; ?>"autocomplete="off">
					</div>
				</div>         
			</div>
			<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<label class="form_label"><?php _trans('lable148'); ?>*</label>
				<div class="form_controls">
					<select class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" name="action_emp_id" id="action_emp_id">
						<option value=""><?php echo trans('lable457'); ?></option>
						<?php foreach ($employee_list as $emplist) {?>
						<option value="<?php echo $emplist->employee_id; ?>" 
						<?php if ($emplist->employee_id == $expense_details->action_emp_id) {
							echo "selected='selected'";} ?> >
						<?php echo $emplist->employee_name; ?></option>
						<?php } ?>
					</select>
				</div>
			</div> 
			<?php if($this->session->userdata('is_shift') == 1){ ?>
			<input type="hidden" value="<?php echo $expense_details->shift?$expense_details->shift:1;?>" id="shift" name="shift" autocomplete="off">
			<?php } else { ?>
			<div class="col-sm-4 col-md-4 col-lg-4 col-xs-12 invoice_customer_details">
				<label class="form_label"><?php _trans('lable152'); ?></label>
				<select id="shift" name="shift" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
					<option value=""><?php echo trans('lable152'); ?></option>	
					<?php foreach ($shift_list as $shiftList) {?>
					<option value="<?php echo $shiftList->shift_id; ?>" <?php if($expense_details->shift == $shiftList->shift_id){echo "selected";}?> > <?php echo $shiftList->shift_name; ?></option>
					<?php } ?>
				</select>
			</div>
			<?php } ?>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingBottom25px paddingLeftRight0px">
			<div class="form_group col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<label class="form_label"><?php _trans('lable177'); ?></label>
				<div class="form_controls">
					<textarea class="form-control" id="description" name="description" maxlength="250" autocomplete="off"><?php echo ($expense_details->description?$expense_details->description:""); ?></textarea>
				</div>
			</div>
			<div class="form_group col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<div class="total-amount" style="float:left;width: 100%;padding: 20px 0px;">
					<div class="col-lg-12" style="padding: 10px 0px;">
						<div class="col-lg-7 clearfix">
							<?php _trans('lable392'); ?>:
						</div>
						<div class="col-lg-5 price clearfix" style="padding-right: 30px;">
						<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<b  class="total_amount" id="total_amount" ><?php if (!empty($expense_details->amount)){ echo format_money($expense_details->amount,$this->session->userdata('default_currency_digit')); } else {echo '0.00'; }?></b>
						</div>
					</div>
					<div class="col-lg-12" style="padding: 20px 0px; 10px 0px">
						<div class="col-lg-7 clearfix" style="padding-top:5px;">
							<b><?php _trans('lable332'); ?>:</b>
						</div>
						<div class="col-lg-5 price clearfix" style="border-top:1px solid #000;padding-right: 30px;padding-top:5px;">
							<input type="hidden" value="<?php echo $expense_details->grand_total;?>" name="existing_grand_total" id="existing_grand_total" autocomplete="off">
							<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<b class="total_product_invoice" id="grand_total"><?php if (!empty($expense_details->grand_total)){ echo format_money($expense_details->grand_total,$this->session->userdata('default_currency_digit')); } else {echo '0.00'; }?></b>
						</div>
					</div>
					<br>
				</div>
			</div>
		</div>
		<div class="row invoiceFloatbtn">
			<div class="buttons text-right">
				<?php if($expense_id != '' && $expense_details->payment_status != 5 ){ ?>
					<button id="btn_submit" name="btn_submit" class=" btn_submit btn btn-rounded btn-primary" value="G">
						<i class="fa fa-check"></i> <?php _trans('lable57'); ?>
					</button>
				<?php } else { ?>
					<button id="btn_submit" name="btn_submit" class=" btn_submit btn btn-rounded btn-primary" value="G">
						<i class="fa fa-check"></i><?php _trans('lable871'); ?>
					</button>
					<button id="btn_submit" name="btn_submit" class=" btn_submit btn btn-rounded btn-primary" value="D">
						<i class="fa fa-check"></i> <?php _trans('lable450'); ?>
					</button>
				<?php } ?>
				<button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default">
				    <i class="fa fa-times"></i><?php _trans('lable58'); ?>
				</button>
			</div>
		</div>
	<div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
	<?php if($expense_id){ ?>
		var payment_type_id_name = $("#payment_type_id option:selected").text();
		var trim = payment_type_id_name.trim();
		var string = trim.toLowerCase();
		if(string == "cheque"){
			$(".showChequeDetailBoxs").show();
		}else{
			$(".showChequeDetailBoxs").hide();
		}
	<?php } ?>
	$("#payment_type_id").change(function(){
		var payment_type_id_name = $("#payment_type_id option:selected").text();
		var trim = payment_type_id_name.trim();
		var string = trim.toLowerCase();
		if(string == "cheque"){
			$(".showChequeDetailBoxs").show();
		}else{
			$(".showChequeDetailBoxs").hide();
		}
	});
		
	$("#is_credit").change(function(){
		var is_credit = $("#is_credit").val();
		if(is_credit == "N"){
			$("#paid").show();
			$("#credit").hide();
		}else if(is_credit == "Y"){
			$("#paid").hide();
			$("#credit").show();
		}else{
			$("#paid").hide();
			$("#credit").hide();
		}
	});

	// $("#expense_date").change(function(){
	// 	var remove = $("#expense_date").val();
	// 	if(remove != '')
	// 	{
	// 		$("#expense_date").removeClass('border_error');	
	// 		$("#expense_date").parent().removeClass('has-error');	
	// 	}
	// });

	$("#btn_cancel").click(function () {
        window.location.href = "<?php echo site_url('mech_expense'); ?>";
    }); 
    
    $(".btn_submit").click(function () {

	  $('.border_error').removeClass('border_error');
      $('.has-error').removeClass('has-error');

		var validation = [];
		
		var btn_status = $(this).val();

        if($("#invoice_group_id").val() == ''){
            validation.push('invoice_group_id');
        }
        if($("#expense_date").val() == ''){
            validation.push('expense_date');
        }
		var tamount = ($("#amount").val()).replace(/,/g, '');
		if(parseInt(tamount) == '' || parseInt(tamount) == 0){
            validation.push('amount');
		}
		if($("#is_credit").val() == ''){
            validation.push('is_credit');
		}
		if($("#action_emp_id").val() == ''){
            validation.push('action_emp_id');
		}
		
		
		
		if($("#is_credit").val() != ''){
			if($("#is_credit").val() == "N"){
				if($("#payment_type_id").val() == ''){
					validation.push('payment_type_id');
				}
				var payment_type_id_name = $("#payment_type_id option:selected").text();
				var trim = payment_type_id_name.trim();
				var string = trim.toLowerCase();
				if(string == "cheque"){
					if($("#cheque_no").val() == ''){
						validation.push('cheque_no');
					}
					if($("#cheque_to").val() == ''){
						validation.push('cheque_to');
					}
					if($("#bank_name").val() == ''){
						validation.push('bank_name');
					}
				}
			}
		}

        if($("#expense_head_id").val() == ''){
            validation.push('expense_head_id');
		}
		
		if($("#branch_id").val() == ''){
            validation.push('branch_id');
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
		
		$.post('<?php echo site_url('mech_expense/ajax/expense_save'); ?>', {
			btn_status : btn_status,
			payment_status : $("#payment_status").val()?$("#payment_status").val():'',
            expense_id : $("#expense_id").val(),
            expense_no : $("#expense_no").val()?$("#expense_no").val():'',
            bill_no : $('#bill_no').val()?$('#bill_no').val():'',
			deposit_id : $("#deposit_id").val()?$("#deposit_id").val():'',
			bank_id : $("#bank_id").val()?$("#bank_id").val():'',
			branch_id : $("#branch_id").val()?$("#branch_id").val():'',
			shift : $("#shift").val()?$("#shift").val():'',
            expense_head_id : $('#expense_head_id').val()?$('#expense_head_id').val():'',
			amount : $('#amount').val()?($('#amount').val()).replace(/,/g, ''):'',
			invoice_group_id : $("#invoice_group_id").val()?$("#invoice_group_id").val():'',
			is_credit : $("#is_credit").val()?$("#is_credit").val():'',
			payment_type_id : $("#payment_type_id").val()?$("#payment_type_id").val():'',
			cheque_no: $("#cheque_no").val()?$("#cheque_no").val().toUpperCase():'',
            cheque_to: $("#cheque_to").val()?$("#cheque_to").val():'',
        	bank_name: $("#bank_name").val()?$("#bank_name").val():'',
			online_payment_ref_no : $("#online_payment_ref_no").val()?$("#online_payment_ref_no").val():'',
			expense_date_created : $("#expense_date").val()?$("#expense_date").val():'',
			in_days : $("#in_days").val()?$("#in_days").val():'',
			expense_date_due : $("#expense_date_due").val()?$("#expense_date_due").val():'',
            expense_date : $("#expense_date").val()?$("#expense_date").val():'',
            action_emp_id : $("#action_emp_id").val()?$("#action_emp_id").val():'',
			description: $("#description").val()?$("#description").val():'',
            tax_percentage : $("#tax_percentage").val()?$("#tax_percentage").val():'',
            tax_amount: $('#tax_amount').val()?$('#tax_amount').val():0,
			existing_grand_total : $("#existing_grand_total").val()?$("#existing_grand_total").val():0,
			grand_total: $('#grand_total').html().replace(/,/g, ''),
            description: $('#description').val()?$('#description').val():'',
			_mm_csrf: $('#_mm_csrf').val()
        }, function (data) {
            list = JSON.parse(data);
            if(list.success=='1'){
				if (btn_status == "D") {
					notie.alert(1,'<?php _trans('toaster1');?>',2);
					setTimeout(function() {
						window.location = "<?php echo site_url('mech_expense'); ?>";
					}, 1000);
				} else {
					notie.alert(1,'<?php _trans('toaster1');?>',2);
					setTimeout(function() {
						window.location = "<?php echo site_url('mech_expense/view'); ?>/"+list.expense_id+"/";
					}, 1000);
				}
            }else if(list.success=='2'){
				$('#gif').hide();
                notie.alert(3, '<?php _trans('toaster2'); ?>', 2);
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

});
</script>