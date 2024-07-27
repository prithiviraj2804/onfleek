<section class="card">
	<div class="card-block">
		<div class="row col-xl-12 col-lg-12 col-md-12 col-sm-12 padding0px">
			<input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>" autocomplete="off">
			<div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<label class="form_label"><?php _trans('lable95'); ?></label>
				<div class="form_controls">
					<select onchange="searchFilter()" name="branch_id" id="branch_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
						<?php if(count($branch_list)>0){ ?>
							<option value=""><?php _trans('lable51'); ?></option>
						<?php } ?>
						<?php foreach ($branch_list as $branchList) {?>
						<option value="<?php echo $branchList->w_branch_id; ?>" > <?php echo $branchList->display_board_name; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<label class="form_label"><?php _trans('lable458'); ?></label>
				<div class="form_controls">
					<select onchange="searchFilter()" name="payment_status" id="payment_status" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
						<option value=""><?php _trans('lable285'); ?></option>
						<option value="1">Pending</option>
						<option value="2">Partially Paid</option>
						<option value="3">paid</option>
					</select>
				</div>
			</div>
			
			<div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<label class="form_label"><?php _trans('lable453'); ?></label>
				<div class="form_controls">
					<input onkeyup="searchFilter()" type="text" name="expense_no" id="expense_no" class="form-control" autocomplete="off">
				</div>
			</div>
			<div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<label class="form_label"><?php _trans('lable428'); ?></label>
				<div class="form_controls">
					<input onkeyup="searchFilter()" type="text" name="bill_no" id="bill_no" class="form-control" autocomplete="off">
				</div>
			</div>
			<div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<label class="form_label"><?php _trans('lable454'); ?></label>
				<div class="form_controls">
					<select onchange="searchFilter()" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" name="expense_head_id" id="expense_head_id">
						<option value=""><?php echo trans('lable455'); ?></option>
						<?php foreach ($expense_category_items as $expcatlist) { ?>
						<option value="<?php echo $expcatlist->expense_category_id; ?>" ><?php echo $expcatlist->expense_category_name; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<label class="form_label"><?php _trans('lable456'); ?></label>
				<div class="form_controls">
					<select onchange="searchFilter()" name="action_emp_id" id="action_emp_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
					<option value=""><?php echo trans('lable457'); ?></option>
						<?php foreach ($employee_list as $emplist) {?>
						<option value="<?php echo $emplist->employee_id; ?>"><?php echo $emplist->employee_name; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<label class="form_label"><?php _trans('lable175'); ?></label>
				<div class="form_controls">
					<input onchange="searchFilter()" type="text" name="expense_from_date" id="expense_from_date" class="form-control datepicker"  autocomplete="off">
				</div>
			</div>
			<div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<label class="form_label"><?php _trans('lable176'); ?></label>
				<div class="form_controls">
				<input onchange="searchFilter()" type="text" name="expense_to_date" id="expense_to_date" class="form-control datepicker" autocomplete="off">
				</div>
			</div>
			<div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<label class="form_label"></label>
				<div class="form_controls paddingTop18px">
					<span><button onclick="searchFilter()" class="btn_submit btn btn-primary"><?php _trans('lable39'); ?></button></span>
					<span><span id="reset_filter" class="btn"><?php _trans('lable827'); ?></span></span>
				</div>
			</div>
		</div>
		<div id="posts_content">
			<div class="overflowScrollForTable">
				<table id="admin_expense_list" class="display table datatable table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th><?php _trans('lable458'); ?></th>
							<th><?php _trans('lable454'); ?></th>
							<th><?php _trans('lable459'); ?></th>
							<th class="text_align_right"><?php _trans('lable332'); ?></th>
							<th class="text_align_center"><?php _trans('lable452'); ?></th>
							<th class="text_align_right"><?php _trans('lable460'); ?></th>
							<th class="text_align_right"><?php _trans('lable461'); ?></th>
							<th class="text_align_center"><?php _trans('lable22'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php 
						if (count($expense_list) > 0) {
							$i = 1;
							foreach ($expense_list as $expense) { 
								if(count($expense_list) >= 4){
								if(count($expense_list) == $i || count($expense_list) == $i+1)
								{
									$dropup = "dropup";
								}
								else
								{
									$dropup = "";
								}
							}
							?>
						<tr>
							<td data-original-title="<?php if ($expense->payment_status == 1) {
									echo 'Pending';
								} elseif ($expense->payment_status == 2) {
									echo 'Partial paid';
								} elseif ($expense->payment_status == 3) {
									echo 'Paid';
								} elseif ($expense->payment_status == 4) {
									echo 'Generated';
								}elseif ($expense->payment_status == 5) {
									echo 'Draft';
								}?>" data-toggle="tooltip" class="textEllipsis">

								<?php if ($expense->payment_status == 1) {
									echo 'Pending';
								} elseif ($expense->payment_status == 2) {
									echo 'Partial paid';
								} elseif ($expense->payment_status == 3) {
									echo 'Paid';
								}  elseif ($expense->payment_status == 4) {
									echo 'Generated';
								}elseif ($expense->payment_status == 5) {
									echo 'Draft';
								}?>
							</td>
							<td data-original-title="<?php _htmlsc($expense->expense_category_name); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($expense->expense_category_name); ?></td>
							<td data-original-title="<?php _htmlsc($expense->expense_no); ?>" data-toggle="tooltip" class="textEllipsis"><a href="<?php echo site_url('mech_expense/view/'.$expense->expense_id); ?>"><?php echo $expense->expense_no; ?></a></td>
							<td class="text_align_right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($expense->grand_total,$this->session->userdata('default_currency_digit')); ?>" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($expense->grand_total,$this->session->userdata('default_currency_digit')); ?></td>
							<td class="text_align_center" data-original-title="<?php _htmlsc($expense->expense_date?date_from_mysql($expense->expense_date):'-'); ?>" data-toggle="tooltip" class="textEllipsis"><?php echo $expense->expense_date?date_from_mysql($expense->expense_date):'-'; ?></td>
							<td class="text_align_right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($expense->total_paid_amount,$this->session->userdata('default_currency_digit'));?>" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($expense->total_paid_amount,$this->session->userdata('default_currency_digit')); ?></td>
							<td class="text_align_right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($expense->total_due_amount,$this->session->userdata('default_currency_digit'));?>" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($expense->total_due_amount,$this->session->userdata('default_currency_digit')); ?></td>
							<td class="text_align_center">
								<div class="options btn-group <?php echo $dropup; ?>">
									<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
										<i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
									</a>
									<ul class="optionTag dropdown-menu">
										<li>
											<a href="<?php echo site_url('mech_expense/create/'.$expense->expense_id); ?>">
												<i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
											</a>
										</li>
										
										<?php if($expense->payment_status != 3 && $expense->payment_status != 5){ ?>
										<li>
											<a href="javascript:void(0)" data-toggle="modal" data-target="#enter-payment" data-entity-id="<?php echo $expense->expense_id; ?>" data-grand-amt="<?php echo $expense->grand_total; ?>" data-balance-amt="<?php echo $expense->total_due_amount; ?>" data-customer-id="<?php echo $expense->action_emp_id; ?>" data-entity-type='expense' class="make-add-payment">
												<i class="fa fa-edit fa-margin"></i> <?php _trans('lable82'); ?>
											</a>
										</li>
										<?php } ?>
										<li>
											<a href="javascript:void(0)" onclick="remove_entity(<?php echo $expense->expense_id; ?>,'mech_expense', 'expense','<?= $this->security->get_csrf_hash(); ?>')">
												<i class="fa fa-edit fa-times"></i> <?php _trans('lable47'); ?>
											</a>
										</li>
									</ul>
								</div>
							</td>
						</tr>
						<?php $i++; } } else { echo '<tr><td colspan="7" class="text-center" > No data found </td></tr>'; } ?>
					</tbody>
				</table>
			</div>
			<div class="headerbar-item pull-right">
				<?php echo $createLinks;?>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">

function searchFilter(page_num) {
    page_num = page_num?page_num:0;
    var payment_status = $('#payment_status').val()?$('#payment_status').val():'';
    var branch_id = $("#branch_id").val()?$("#branch_id").val():'';
    var expense_from_date = $("#expense_from_date").val()?$("#expense_from_date").val():'';
    var expense_to_date = $("#expense_to_date").val()?$("#expense_to_date").val():'';
    var expense_no = $('#expense_no').val()?$('#expense_no').val():'';
	var bill_no = $('#bill_no').val()?$('#bill_no').val():'';
	var expense_head_id = $('#expense_head_id').val()?$('#expense_head_id').val():'';
	var action_emp_id = $('#action_emp_id').val()?$('#action_emp_id').val():'';
	

    $.post('<?php echo site_url('mech_expense/ajax/get_filter_list'); ?>', {
        page : page_num,
        payment_status : payment_status,
        branch_id : branch_id,
        expense_from_date : expense_from_date,
        expense_to_date : expense_to_date,
        expense_no : expense_no,
		bill_no : bill_no,
		expense_head_id : expense_head_id,
        action_emp_id : action_emp_id,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            var html = '';
            html += '<div class="overflowScrollForTable">';
            html += '<table class="display table datatable table-bordered" cellspacing="0" width="100%">';
			html += '<thead><tr>';
			html += '<th><?php _trans("lable458"); ?></th>';
			html += '<th><?php _trans("lable454"); ?></th>';
			html += '<th><?php _trans("lable459"); ?></th>';
			html += '<th class="text_align_right"><?php _trans("lable332"); ?></th>';
			html += '<th class="text_align_center"><?php _trans("lable452"); ?></th>';
			html += '<th class="text_align_right"><?php _trans("lable460"); ?></th>';
			html += '<th class="text_align_right"><?php _trans("lable461"); ?></th>';
			html += '<th class="text_align_center"><?php _trans("lable22"); ?></th>';
            html += '</tr></thead><tbody>';
            if(list.expense_list.length > 0){
                for(var v=0; v < list.expense_list.length; v++){ 
					if(list.expense_list.length >= 4){
						if(list.expense_list.length == v || list.expense_list.length == v+1)
						{
							var dropup = "dropup";
						}
						else
						{
							var dropup = "";
						}
					}
					html += '<tr>';
					html += '<td data-original-title="';
					if(list.expense_list[v].payment_status == 1){
						html += 'Pending';
					}else if(list.expense_list[v].payment_status == 2){
						html += 'Partial paid';
					}else if(list.expense_list[v].payment_status == 3){
						html += 'Paid';
					}else if(list.expense_list[v].payment_status == 4){
						html += 'Generated';
					}else if(list.expense_list[v].payment_status == 5){
						html += 'Draft';
					}else{
						html += '';
					}
					html += '" data-toggle="tooltip" class="textEllipsis">';

					if(list.expense_list[v].payment_status == 1){
						html += 'Pending';
					}else if(list.expense_list[v].payment_status == 2){
						html += 'Partial paid';
					}else if(list.expense_list[v].payment_status == 3){
						html += 'Paid';
					}else if(list.expense_list[v].payment_status == 4){
						html += 'Generated';
					}else if(list.expense_list[v].payment_status == 5){
						html += 'Draft';
					}else{
						html += '';
					}
					html += '</td>';
					html += '<td data-original-title="'+((list.expense_list[v].expense_category_name)?list.expense_list[v].expense_category_name:" ")+'" data-toggle="tooltip" class="textEllipsis">'+list.expense_list[v].expense_category_name+'</td>';
					html += '<td data-original-title="'+(list.expense_list[v].expense_no?list.expense_list[v].expense_no:"")+'" data-toggle="tooltip" class="textEllipsis"><a href="<?php echo site_url("mech_expense/view/'+list.expense_list[v].expense_id+'"); ?>">'+(list.expense_list[v].expense_no?list.expense_list[v].expense_no:"")+'</a></td>';
					html += '<td class="text_align_right"  data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata("default_currency_code")); ?>&nbsp;'+format_money(((list.expense_list[v].grand_total)?list.expense_list[v].grand_total:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata("default_currency_code")); ?>&nbsp;'+format_money(((list.expense_list[v].grand_total)?list.expense_list[v].grand_total:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'</td>';
					html += '<td class="text_align_center"  data-original-title="'+(list.expense_list[v].expense_date?formatDate(list.expense_list[v].expense_date):"")+'" data-toggle="tooltip" class="textEllipsis">'+(list.expense_list[v].expense_date?formatDate(list.expense_list[v].expense_date):"")+'</td>';
					html += '<td class="text_align_right"  data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata("default_currency_code")); ?>&nbsp;'+format_money(((list.expense_list[v].total_paid_amount)?list.expense_list[v].total_paid_amount:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata("default_currency_code")); ?>&nbsp;'+format_money(((list.expense_list[v].total_paid_amount)?list.expense_list[v].total_paid_amount:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'</td>';
					html += '<td class="text_align_right"  data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata("default_currency_code")); ?>&nbsp;'+format_money(((list.expense_list[v].total_due_amount)?list.expense_list[v].total_due_amount:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata("default_currency_code")); ?>&nbsp;'+format_money(((list.expense_list[v].total_due_amount)?list.expense_list[v].total_due_amount:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'</td>';
					html += '<td class="text_align_center">';
					html += '<div class="options btn-group '+dropup+'">';
					html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">';
					html += '<i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
					html += '<ul class="optionTag dropdown-menu">';
					html += '<li><a href="<?php echo site_url("mech_expense/create/'+list.expense_list[v].expense_id+'"); ?>">';
					html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable44"); ?></a></li>';
					if(list.expense_list[v].payment_status != 3 && list.expense_list[v].payment_status != 5){
						html += '<li><a href="javascript:void(0)" data-toggle="modal" data-entity-id="'+list.expense_list[v].expense_id+'" data-grand-amt="'+list.expense_list[v].grand_total+'" data-balance-amt="'+list.expense_list[v].total_due_amount+'" data-customer-id="'+list.expense_list[v].action_emp_id+'" data-entity-type="expense" data-target="#enter-payment" class="make-add-payment">';
						html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable82"); ?></a></li>';
					}
					html += '<li><a href="javascript:void(0)" onclick="remove_entity(\''+list.expense_list[v].expense_id+'\',\'mech_expense\',\'expense\',\'<?= $this->security->get_csrf_hash() ?>\')">';
					html += '<i class="fa fa-edit fa-times"></i> <?php _trans("lable47"); ?></a></li>';
					html += '</ul></div></td>';
					html += '</tr>';
                } 
            }else{ 
                html += '<tr><td colspan="7" class="text-center" > No data found </td></tr>';
            }
            html += '</tbody></table></div>';
            html += '<div class="headerbar-item pull-right paddingTop20px">';
            html += list.createLinks;
            html += '</div>';
            $('#posts_content').html(html);
        }
    });

    $('body').on('mouseenter', '.table', function () {
        $(".datatable [data-toggle='tooltip']").tooltip();
    });
}
	$(function() {

		$("[data-toggle='tooltip']").tooltip();
		
		$(".card-block input").keypress(function (e) {
			if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
				$('.btn_submit').click();
				return false;
			} else {
				return true;
			}
		});

		$("#reset_filter").click(function () {
			$("#branch_id").val('');
			$("#payment_status").val('');
			$("#expense_from_date").val('');
			$("#expense_to_date").val('');
			$("#expense_no").val('');
			$("#bill_no").val('');
			$("#expense_head_id").val('');
			$("#action_emp_id").val('');
			$('.bootstrap-select').selectpicker("refresh");
			searchFilter();
		});

	});
</script>