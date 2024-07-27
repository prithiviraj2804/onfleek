<section class="card">
	<div class="card-block">
		<div class="row col-xl-12 col-lg-12 col-md-12 col-sm-12 padding0px">
			<input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
			<div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<label class="form_label"><?php _trans('lable95'); ?></label>
				<div class="form_controls">
					<select onchange="searchFilter()" name="branch_id" id="branch_id" class="searchSelect bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
						<?php if(count($branch_list)>0){ ?>
							<option value=""><?php _trans('lable51'); ?></option>
						<?php } ?>
						<?php foreach ($branch_list as $branchList) {?>
						<option value="<?php echo $branchList->w_branch_id; ?>"> <?php echo $branchList->display_board_name; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<label class="form_label"><?php _trans('lable128'); ?></label>
				<div class="form_controls">
					<select onchange="searchFilter()" name="purchase_status" id="purchase_status" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
						<option value=""><?php _trans('lable285'); ?></option>
						<option value="D" >Draft</option>
						<option value="G" >Generated</option>
						<option value="PP" >Partially Paid</option>
						<option value="FP" >paid</option>
					</select>
				</div>
			</div>
			
			<div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<label class="form_label"><?php _trans('lable427'); ?></label>
				<div class="form_controls">
					<input onkeyup="searchFilter()" type="text" name="purchase_no" id="purchase_no" class="form-control"  autocomplete="off">
				</div>
			</div>
			<div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<label class="form_label"><?php _trans('lable428'); ?></label>
				<div class="form_controls">
					<input onkeyup="searchFilter()" type="text" name="purchase_number" id="purchase_number" class="form-control"  autocomplete="off">
				</div>
			</div>
			<div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<label class="form_label"><?php _trans('lable107'); ?></label>
				<div class="form_controls">
					<select onchange="searchFilter()" name="supplier_id" id="supplier_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
						<option value=""><?php echo trans('lable429'); ?></option>
						<?php foreach ($supplier_details as $supplier): ?>
						<option value="<?php echo $supplier->supplier_id; ?>" data-gstin="<?php echo $supplier->supplier_gstin; ?>"><?php _htmlsc($supplier->supplier_name); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<label class="form_label"><?php _trans('lable175'); ?></label>
				<div class="form_controls">
					<input onchange="searchFilter()" type="text" name="purchase_from_date" id="purchase_from_date" class="form-control datepicker" autocomplete="off">
				</div>
			</div>
			<div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<label class="form_label"><?php _trans('lable176'); ?></label>
				<div class="form_controls">
					<input onchange="searchFilter()" type="text" name="purchase_to_date" id="purchase_to_date" class="form-control datepicker"  autocomplete="off">
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
				<table id="admin_purchase_list" class="display datatable table table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th><?php _trans('lable128'); ?></th>
							<th><?php _trans('lable126'); ?>.</th>
							<th><?php _trans('lable34'); ?>.</th>
							<th><?php _trans('lable107'); ?></th>
							<th class="text_align_right"><?php _trans('lable32'); ?></th>
							<th class="text_align_center"><?php _trans('lable386'); ?></th>
							<th class="text_align_center"><?php _trans('lable127'); ?></th>
							<th class="text_align_center"><?php _trans('lable22'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php if(count($purchase_list)>0){
							$i = 1;
							foreach ($purchase_list as $purchase) { 
								if(count($purchase_list) >= 4){
								if(count($purchase_list) == $i || count($purchase_list) == $i+1)
								{
									$dropup = "dropup";
								}
								else
								{
									$dropup = "";
								}
							}?>
						<tr>
							<td data-original-title="<?php if($purchase->purchase_status == "D"){ echo "Draft"; }elseif($purchase->purchase_status == "G"){ echo "Generated"; }
							elseif($purchase->purchase_status == "PP"){ echo "Partial paid"; }elseif($purchase->purchase_status == "FP"){ echo "Paid"; } ?>" data-toggle="tooltip" class="textEllipsis"><?php if($purchase->purchase_status == "D"){ echo "Draft"; }elseif($purchase->purchase_status == "G"){ echo "Generated"; }
							elseif($purchase->purchase_status == "PP"){ echo "Partial paid"; }elseif($purchase->purchase_status == "FP"){ echo "Paid"; } ?></td>
							<td data-original-title="<?php _htmlsc($purchase->purchase_no); ?>" data-toggle="tooltip" class="textEllipsis"><a href="<?php echo site_url('mech_purchase/view/' . $purchase->purchase_id); ?>"><?php _htmlsc($purchase->purchase_no); ?></a></td>
							<td data-original-title="<?php _htmlsc($purchase->purchase_number?$purchase->purchase_number:NULL); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($purchase->purchase_number?$purchase->purchase_number:NULL); ?></td>
							<td data-original-title="<?php _htmlsc($purchase->supplier_name?$purchase->supplier_name:NULL); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($purchase->supplier_name?$purchase->supplier_name:NULL); ?></td>
							<td class="text-right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($purchase->total_due_amount,$this->session->userdata('default_currency_digit'));?>" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($purchase->total_due_amount,$this->session->userdata('default_currency_digit')); ?></td>
							<td class="text-center" data-original-title="<?php _htmlsc($purchase->purchase_date_created?date_from_mysql($purchase->purchase_date_created):""); ?>" data-toggle="tooltip" class="textEllipsis"><?php echo ($purchase->purchase_date_created?date_from_mysql($purchase->purchase_date_created):""); ?></td>
							<td class="text-center" data-original-title="<?php _htmlsc($purchase->purchase_date_due?date_from_mysql($purchase->purchase_date_due):""); ?>" data-toggle="tooltip" class="textEllipsis"><?php echo ($purchase->purchase_date_due?date_from_mysql($purchase->purchase_date_due):""); ?></td>
							
							<td class="text_align_center">
								<div class="options btn-group <?php echo $dropup; ?>">
									<a class="btn btn-default btn-sm dropdown-toggle"
									data-toggle="dropdown" href="#">
										<i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
									</a>
									<ul class="optionTag dropdown-menu">
										<li>
											<a href="<?php echo site_url('mech_purchase/create/' . $purchase->purchase_id); ?>">
												<i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
											</a>
										</li>
										<?php if($purchase->purchase_status != "D" && $purchase->purchase_status != "FP"){ ?>
										<li>
											<a href="javascript:void(0)" data-toggle="modal" data-target="#enter-payment" data-entity-id="<?php echo $purchase->purchase_id; ?>" data-grand-amt="<?php echo $purchase->grand_total; ?>" data-balance-amt="<?php echo $purchase->total_due_amount; ?>" data-customer-id="<?php echo $purchase->supplier_id; ?>" data-entity-type='purchase' class="make-add-payment">
												<i class="fa fa-edit fa-margin"></i> <?php _trans('lable82'); ?>
											</a>
										</li>
										<?php } ?>
										<li>
											<a target="_blank" href="<?php echo site_url('mech_purchase/generate_pdf/' . $purchase->purchase_id); ?>">
												<i class="fa fa-edit fa-margin"></i> <?php _trans('lable141'); ?>
											</a>
										</li>
										<?php if($purchase->purchase_status != 'PP' && $purchase->purchase_status != 'FP') {?>
										<li>
											<a href="javascript:void(0)" onclick="remove_entity(<?php echo $purchase->purchase_id; ?>,'mech_purchase', 'purchase','<?= $this->security->get_csrf_hash() ?>')">
												<i class="fa fa-edit fa-times"></i> <?php _trans('lable47'); ?>
											</a>
										</li>
										<?php } ?>
									</ul>
								</div>
							</td>
						</tr>
						<?php $i++; } } else { echo '<tr><td colspan="8" class="text-center" > No data found </td></tr>'; } ?>
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
    var purchase_status = $('#purchase_status').val()?$('#purchase_status').val():'';
    var branch_id = $("#branch_id").val()?$("#branch_id").val():'';
    var purchase_from_date = $("#purchase_from_date").val()?$("#purchase_from_date").val():'';
    var purchase_to_date = $("#purchase_to_date").val()?$("#purchase_to_date").val():'';
    var purchase_no = $('#purchase_no').val()?$('#purchase_no').val():'';
    var purchase_number = $('#purchase_number').val()?$('#purchase_number').val():'';
	var supplier_id = $('#supplier_id').val()?$('#supplier_id').val():'';

    $.post('<?php echo site_url('mech_purchase/ajax/get_filter_list'); ?>', {
        page : page_num,
        purchase_status : purchase_status,
        branch_id : branch_id,
        purchase_from_date : purchase_from_date,
        purchase_to_date : purchase_to_date,
        purchase_no : purchase_no,
        purchase_number : purchase_number,
		supplier_id : supplier_id,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            var html = '';
            html += '<div class="overflowScrollForTable">';
            html += '<table class="display table datatable table-bordered" cellspacing="0" width="100%">';
			html += '<thead><tr>';
			html += '<th><?php _trans("lable128"); ?></th>';
			html += '<th><?php _trans("lable126"); ?>.</th>';
			html += '<th><?php _trans("lable34"); ?>.</th>';
			html += '<th><?php _trans("lable107"); ?></th>';
			html += '<th class="text_align_right"><?php _trans("lable32"); ?></th>';
			html += '<th class="text_align_center"><?php _trans("lable386"); ?></th>';
			html += '<th class="text_align_center"><?php _trans("lable127"); ?></th>';
			html += '<th class="text_align_center"><?php _trans("lable22"); ?></th>';
            html += '</tr></thead><tbody>';
            if(list.purchase_list.length > 0){
                for(var v=0; v < list.purchase_list.length; v++){ 
					if(list.purchase_list.length >= 4){
						if(list.purchase_list.length == v || list.purchase_list.length == v+1)
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
					if(list.purchase_list[v].purchase_status == "D"){
						html += 'Draft';
					}else if(list.purchase_list[v].purchase_status == "G"){ 
						html += 'Generated';
					}else if(list.purchase_list[v].purchase_status == "PP"){ 
						html += 'Partial paid';
					}else if(list.purchase_list[v].purchase_status == "FP"){
						html += 'Paid';
					}else{
						html += ' ';
					}
					html += '" data-toggle="tooltip" class="textEllipsis">';
					
					if(list.purchase_list[v].purchase_status == "D"){
						html += 'Draft';
					}else if(list.purchase_list[v].purchase_status == "G"){ 
						html += 'Generated';
					}else if(list.purchase_list[v].purchase_status == "PP"){ 
						html += 'Partial paid';
					}else if(list.purchase_list[v].purchase_status == "FP"){
						html += 'Paid';
					}else{
						html += ' ';
					}
					html += '</td>';
					html += '<td data-original-title="'+(list.purchase_list[v].purchase_no?list.purchase_list[v].purchase_no:"")+'" data-toggle="tooltip" class="textEllipsis"><a href="<?php echo site_url("mech_purchase/view/'+list.purchase_list[v].purchase_id+'"); ?>">'+(list.purchase_list[v].purchase_no?list.purchase_list[v].purchase_no:"")+'</a></td>';
					html += '<td data-original-title="'+(list.purchase_list[v].purchase_number?list.purchase_list[v].purchase_number:"")+'" data-toggle="tooltip" class="textEllipsis">'+(list.purchase_list[v].purchase_number?list.purchase_list[v].purchase_number:"")+'</td>';
					html += '<td data-original-title="'+(list.purchase_list[v].supplier_name?list.purchase_list[v].supplier_name:"")+'" data-toggle="tooltip" class="textEllipsis">'+(list.purchase_list[v].supplier_name?list.purchase_list[v].supplier_name:"")+'</td>';
					html += '<td class="text-right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;'+format_money((list.purchase_list[v].total_due_amount?list.purchase_list[v].total_due_amount:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;'+format_money((list.purchase_list[v].total_due_amount?list.purchase_list[v].total_due_amount:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'</td>';
					html += '<td class="text-center" data-original-title="'+(list.purchase_list[v].purchase_date_created?formatDate(new Date(list.purchase_list[v].purchase_date_created)):"")+'" data-toggle="tooltip" class="textEllipsis">'+(list.purchase_list[v].purchase_date_created?formatDate(new Date(list.purchase_list[v].purchase_date_created)):"")+'</td>';
					html += '<td class="text-center" data-original-title="'+(list.purchase_list[v].purchase_date_due?formatDate(new Date(list.purchase_list[v].purchase_date_due)):"")+'" data-toggle="tooltip" class="textEllipsis">'+(list.purchase_list[v].purchase_date_due?formatDate(new Date(list.purchase_list[v].purchase_date_due)):"")+'</td>';
					html += '<td class="text_align_center">';
					html += '<div class="options btn-group '+dropup+'">';
					html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">';
					html += '<i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
					html += '<ul class="optionTag dropdown-menu">';
					html += '<li><a href="<?php echo site_url("mech_purchase/create/'+list.purchase_list[v].purchase_id+'"); ?>">';
					html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable44"); ?></a></li>';
					if(list.purchase_list[v].purchase_status != "FP" && list.purchase_list[v].purchase_status != "D"){
						html += '<li><a href="javascript:void(0)" data-toggle="modal" data-entity-id="'+list.purchase_list[v].purchase_id+'" data-grand-amt="'+list.purchase_list[v].grand_total+'" data-balance-amt="'+list.purchase_list[v].total_due_amount+'" data-customer-id="'+list.purchase_list[v].supplier_id+'" data-entity-type="purchase" data-target="#enter-payment" class="make-add-payment">';
						html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable82"); ?></a></li>';
					}
					html += '<li><a target="_blank" href="<?php echo site_url("mech_purchase/generate_pdf/'+list.purchase_list[v].purchase_id+'");?>">';
					html += '<i class="fa fa-print fa-margin" aria-hidden="true"></i></i> <?php _trans("lable141"); ?></a></li>';
					if(list.purchase_list[v].purchase_status != 'PP' && list.purchase_list[v].purchase_status != 'FP'){
						html += '<li><a href="javascript:void(0)" onclick="remove_entity(\''+list.purchase_list[v].purchase_id+'\',\'mech_purchase\',\'purchase\',\'<?= $this->security->get_csrf_hash() ?>\')">';
						html += '<i class="fa fa-edit fa-times"></i> <?php _trans("lable47"); ?></a></li>';
					}
					html += '</ul></div></td></tr>';
                } 
            }else{ 
                html += '<tr><td colspan="8" class="text-center" > No data found </td></tr>';
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
function sendmail(invoice_id,cat){
	$('#modal-placeholder').load("<?php echo site_url('mailer/model_mech_invoice'); ?>/"+invoice_id+"/"+cat);
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
		$("#purchase_status").val('');
		$("#purchase_from_date").val('');
		$("#purchase_to_date").val('');
		$("#purchase_no").val('');
		$("#purchase_number").val('');
		$("#supplier_id").val('');
		$('.bootstrap-select').selectpicker("refresh");
		searchFilter();
	});
});
</script>