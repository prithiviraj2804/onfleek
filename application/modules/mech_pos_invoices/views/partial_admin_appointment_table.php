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
						<option value="<?php echo $branchList->w_branch_id; ?>"  > <?php echo $branchList->display_board_name; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<label class="form_label"><?php _trans('lable369'); ?></label>
				<div class="form_controls">
					<select onchange="searchFilter()" name="invoice_status" id="invoice_status" class="searchSelect bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
						<option value=""><?php _trans('lable285'); ?></option>
						<option value="D" >Draft</option>
						<option value="G" >Generated</option>
						<option value="PP">Partially Paid</option>
						<option value="FP" >paid</option>
					</select>
				</div>
			</div>
			<div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<label class="form_label"><?php _trans('lable271'); ?></label>
				<div class="form_controls">
					<input onkeyup="searchFilter()" type="text" name="invoice_no" id="invoice_no" class="form-control" autocomplete="off">
				</div>
			</div>
			<div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable1087'); ?></label>
                    <div class="form_controls">
                        <input onchange="searchFilter()" type="text" name="vehicle_no" id="vehicle_no" onkeypress="vehiclenumber()" value="<?php echo $vehicle_no; ?>" class="form-control" autocomplete="off">  
                    </div>
            </div>
			<div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<label class="form_label"><?php _trans('lable36'); ?></label>
				<div class="form_controls">
					<select onchange="searchFilter()" name="customer_id" id="customer_id" class="searchSelect bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
						<option value=""><?php _trans('lable272'); ?></option>
						<?php foreach ($customer_list as $customer){ ?>
							<option value="<?php echo $customer->client_id; ?>"><?php echo $customer->client_name."(".$customer->client_contact_no.")";  ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<label class="form_label"><?php _trans('lable175'); ?></label>
				<div class="form_controls">
					<input onchange="searchFilter()" type="text" name="invoice_from_date" id="invoice_from_date" class="form-control datepicker" autocomplete="off">
				</div>
			</div>
			<div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<label class="form_label"><?php _trans('lable176'); ?></label>
				<div class="form_controls">
					<input onchange="searchFilter()" type="text" name="invoice_to_date" id="invoice_to_date" class="form-control datepicker" autocomplete="off">
				</div>
			</div>
			<div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<div class="form_controls paddingTop30px">
					<span><button onclick="searchFilter()" class="btn_submit btn btn-primary"><?php _trans('lable39'); ?></button></span>
                    <span><span id="reset_filter" class="btn"><?php _trans('lable827'); ?></span></span>
				</div>
			</div>	
		</div>
		<div id="posts_content">			
				<div class="overflowScrollForTable">
					<table id="admin_quote_list" class="display table datatable table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th><?php _trans('lable369'); ?></th>
								<th><?php _trans('lable29'); ?>.</th>
								<th class="text-center"><?php _trans('lable368'); ?></th>
								<th><?php _trans('lable370'); ?></th>
								<th><?php _trans('lable371'); ?></th>
								<th class="text-right"><?php _trans('lable372'); ?></th>
								<th class="text-right"><?php _trans('lable373'); ?></th>
								<th class="text_align_center"><?php _trans('lable22'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php if(count($invoice_list)>0){
								$i = 1; 
							foreach ($invoice_list as $invoice) { 
								if(count($invoice_list) >= 4){
								if(count($invoice_list) == $i || count($invoice_list) == $i+1)
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
								<td data-original-title="<?php if($invoice->invoice_status == "D"){ echo "Draft"; }elseif($invoice->invoice_status == "G"){ echo "Generated"; }
								elseif($invoice->invoice_status == "PP"){ echo "Partial paid"; }elseif($invoice->invoice_status == "FP"){ echo "Paid"; } ?>" data-toggle="tooltip" class="textEllipsis"><?php if($invoice->invoice_status == "D"){ echo "Draft"; }elseif($invoice->invoice_status == "G"){ echo "Generated"; }
								elseif($invoice->invoice_status == "PP"){ echo "Partial paid"; }elseif($invoice->invoice_status == "FP"){ echo "Paid"; } ?></td>
								<td data-original-title="<?php _htmlsc($invoice->invoice_no); ?>" data-toggle="tooltip" class="textEllipsis"><a href="<?php echo site_url('mech_pos_invoices/view/'.$invoice->invoice_id); ?>"><?php _htmlsc($invoice->invoice_no); ?></a></td>
								<td class="text_align_center" data-original-title="<?php _htmlsc($invoice->invoice_date?date_from_mysql($invoice->invoice_date):'-'); ?>" data-toggle="tooltip" class="textEllipsis"><?php  _htmlsc($invoice->invoice_date?date_from_mysql($invoice->invoice_date):'-'); ?></td>
								<td data-original-title="<?php _htmlsc($this->mdl_clients->get_customer_name($invoice->customer_id)); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($this->mdl_clients->get_customer_name($invoice->customer_id)); ?></td>
								<td data-original-title="<?php echo $invoice->car_reg_no;?> <?php _htmlsc($invoice->brand_name." ".$invoice->model_name." ".$invoice->variant_name);?>" data-toggle="tooltip" class="textEllipsis"><?php echo $invoice->car_reg_no;?> <br> <?php _htmlsc($invoice->brand_name." ".$invoice->model_name." ".$invoice->variant_name); ?></td>
								<td class="text-right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($invoice->grand_total,$this->session->userdata('default_currency_digit')); ?>" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($invoice->grand_total,$this->session->userdata('default_currency_digit')); ?></td>
								<td class="text-right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($invoice->total_due_amount,$this->session->userdata('default_currency_digit')); ?>" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($invoice->total_due_amount,$this->session->userdata('default_currency_digit')); ?></td>
								<td class="text_align_center">
									<div class="options btn-group <?php echo $dropup; ?>">
										<a class="btn btn-default btn-sm dropdown-toggle"
										data-toggle="dropdown" href="#">
											<i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
										</a>
										<ul class="optionTag dropdown-menu">
											<li>
												<a href="<?php echo site_url('mech_pos_invoices/create/'.$invoice->invoice_id); ?>">
													<i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
												</a>
											</li>
											<li>
												<a href="javascript:void(0)" data-toggle="modal" data-target="#addNewCar" data-invoice-id="<?php echo $invoice->invoice_id; ?>" class="add_feedback">
													<i class="fa fa-edit fa-margin"></i> <?php _trans('lable374'); ?>
												</a>
											</li>											
											<?php if($is_product == "Y"){ ?>
											<li>
												<a href="javascript:void(0)" data-toggle="modal" data-model_from="I" data-invoice_id="<?php echo $invoice->invoice_id;?>" data-customer_id="<?php echo $invoice->customer_id; ?>" data-vehicle_id="<?php echo $invoice->customer_car_id; ?>" data-target="#addNewCar" class="add_recommended_product">
													<i class="fa fa-plus fa-margin" aria-hidden="true"></i> <?php _trans("lable853"); ?>
												</a>
											</li>
											<?php } ?>
											<li>
												<a href="javascript:void(0)" data-toggle="modal" data-model_from="I" data-invoice_id="<?php echo $invoice->invoice_id;?>" data-customer_id="<?php echo $invoice->customer_id; ?>" data-vehicle_id="<?php echo $invoice->customer_car_id; ?>" data-target="#addNewCar" class="add_recommended_service">
													<i class="fa fa-plus fa-margin" aria-hidden="true"></i> <?php _trans("lable395"); ?>
												</a>
											</li>
											<li>
												<a target="_blank" href="<?php echo site_url('mech_pos_invoices/generate_pdf/'.$invoice->invoice_id); ?>">
													<i class="fa fa-edit fa-margin"></i> <?php _trans('lable141'); ?>
												</a>
											</li>
											<li>
												<a target="_blank" href="<?php echo site_url('mech_pos_invoices/generate_thermal_pdf/'.$invoice->invoice_id); ?>">
													<i class="fa fa-edit fa-margin"></i> <?php _trans('lable420'); ?>
												</a>
											</li>
											<?php if($this->session->userdata('invoice_E') == 1){ ?>
											<li>
												<a href="javascript:void(0)" onclick="sendmail(<?php echo $invoice->invoice_id; ?>,'<?php echo $invoice->invoice_category; ?>')">
													<i class="fa fa-edit fa-margin"></i> <?php _trans('lable274'); ?>
												</a>
											</li>
											<?php } ?>
											<?php if($this->session->userdata('user_type') == 3){ ?>
											<li>
												<a href="javascript:void(0)" onclick="remove_entity(<?php echo $invoice->invoice_id; ?>,'mech_pos_invoices', 'invoice','<?= $this->security->get_csrf_hash() ?>')">
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
				<div class="headerbar-item pull-right paddingTop20px">
					<?php echo $createLinks;?>
			</div>
		</div>
	</div>
</section>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/autocomplete_veh_plugin.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="<?php echo base_url(); ?>assets/mp_backend/js/autocomplete_veh_plugin.js"></script>
<script src="<?php echo base_url(); ?>assets/mp_backend/js/autocomplete_veh_plugin_ui.js"></script>
<script>

function vehiclenumber(){
        var vehicle_no = $("#vehicle_no").val();
        if(vehicle_no.length > 2){
            $('#gif').show();
            $.post('<?php echo site_url('mech_pos_invoices/ajax/getposvehiclenos'); ?>', {
                vehicle_no: vehicle_no,
                _mm_csrf: $('#_mm_csrf').val()
            }, function(data) {
                list = JSON.parse(data);
                if (list.success == '1') {
                    $('#gif').hide();
                    if(list.vehicle_list){
                        if(list.vehicle_list.length > 0){
                            var vehiclenoList = list.vehicle_list;
                            $("#vehicle_no").autocomplete({
                            source: vehiclenoList
                            });
                        }
                    }
                }
            });
        }
    }

function searchFilter(page_num) {
    page_num = page_num?page_num:0;
    var invoice_status = $('#invoice_status').val()?$('#invoice_status').val():'';
    var branch_id = $("#branch_id").val()?$("#branch_id").val():'';
    var invoice_from_date = $("#invoice_from_date").val()?$("#invoice_from_date").val():'';
    var invoice_to_date = $("#invoice_to_date").val()?$("#invoice_to_date").val():'';
    var invoice_no = $('#invoice_no').val()?$('#invoice_no').val():'';
    var customer_id = $('#customer_id').val()?$('#customer_id').val():'';
    var vehicle_no = $('#vehicle_no').val()?$('#vehicle_no').val():'';

    $.post('<?php echo site_url('mech_pos_invoices/ajax/get_filter_list'); ?>', {
        page : page_num,
        invoice_status : invoice_status,
        branch_id : branch_id,
        invoice_from_date : invoice_from_date,
        invoice_to_date : invoice_to_date,
        invoice_no : invoice_no,
        customer_id : customer_id,
		vehicle_no : vehicle_no,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            var html = '';
            html += '<div class="overflowScrollForTable">';
            html += '<table class="display table datatable table-bordered" cellspacing="0" width="100%">';
            html += '<thead><tr><th><?php _trans("lable369"); ?></th>';
            html += '<th class="text-center"><?php _trans("lable29");?></th>';
            html += '<th class="text-center"><?php _trans("lable368"); ?></th>';
            html += '<th><?php _trans("lable370"); ?></th>';
            html += '<th><?php _trans("lable371"); ?></th>';
			html += '<th class="text-center"><?php _trans("lable372"); ?></th>';
			html += '<th class="text-center"><?php _trans("lable373"); ?></th>';
            html += '<th class="text-center"><?php _trans("lable22"); ?></th>';
            html += '</tr></thead><tbody>';
            if(list.invoice_list.length > 0){
                for(var v=0; v < list.invoice_list.length; v++){
					if(list.invoice_list.length >= 4)
					{
						 
                    if(list.invoice_list.length == v || list.invoice_list.length == v+1)
                    {
                        var dropup = "dropup";
                    }
                    else
                    {
                        var dropup = "";
					}
				}
					html += '<tr><td data-original-title="';
					if(list.invoice_list[v].invoice_status == "D"){
						html += 'Draft';
					}else if(list.invoice_list[v].invoice_status == "G"){
						html += 'Generated';
					}else if(list.invoice_list[v].invoice_status == "PP"){
						html += 'Partial paid';
					}else if(list.invoice_list[v].invoice_status == "FP"){
						html += 'Paid';
					}
					html += '" data-toggle="tooltip" class="textEllipsis">';

					if(list.invoice_list[v].invoice_status == "D"){
						html += 'Draft';
					}else if(list.invoice_list[v].invoice_status == "G"){
						html += 'Generated';
					}else if(list.invoice_list[v].invoice_status == "PP"){
						html += 'Partial paid';
					}else if(list.invoice_list[v].invoice_status == "FP"){
						html += 'Paid';
					}
					html += '</td>';
					html += '<td data-original-title="'+(list.invoice_list[v].invoice_no?list.invoice_list[v].invoice_no:"")+'" data-toggle="tooltip" class="textEllipsis"><a href="<?php echo site_url("mech_pos_invoices/view/'+list.invoice_list[v].invoice_id+'"); ?>">'+(list.invoice_list[v].invoice_no?list.invoice_list[v].invoice_no:"")+'</a></td>';
                    html += '<td class="text-center" data-original-title="';
					html += list.invoice_list[v].invoice_date?formatDate(list.invoice_list[v].invoice_date):"";
                    html += '" data-toggle="tooltip" class="textEllipsis">';
                    html += (list.invoice_list[v].invoice_date?formatDate(list.invoice_list[v].invoice_date):"");
                    html += '</td>';
					html += '<td data-original-title="'+(list.invoice_list[v].client_name?list.invoice_list[v].client_name:"")+'" data-toggle="tooltip" class="textEllipsis">'+(list.invoice_list[v].client_name?list.invoice_list[v].client_name:"")+'</td>';
					html += '<td data-original-title="'+(list.invoice_list[v].car_reg_no?list.invoice_list[v].car_reg_no:"")+' '+(list.invoice_list[v].brand_name?list.invoice_list[v].brand_name:" ")+' '+(list.invoice_list[v].model_name?list.invoice_list[v].model_name:" ")+' '+(list.invoice_list[v].variant_name?list.invoice_list[v].variant_name:" ")+'" data-toggle="tooltip" class="textEllipsis"><span class="car_reg_no">'+(list.invoice_list[v].car_reg_no?list.invoice_list[v].car_reg_no:"")+'</span><br>'+(list.invoice_list[v].brand_name?list.invoice_list[v].brand_name:" ")+' '+(list.invoice_list[v].model_name?list.invoice_list[v].model_name:" ")+' '+(list.invoice_list[v].variant_name?list.invoice_list[v].variant_name:" ")+'</td>';
					html += '<td class="text-right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;'+format_money((list.invoice_list[v].grand_total?list.invoice_list[v].grand_total:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;'+format_money((list.invoice_list[v].grand_total?list.invoice_list[v].grand_total:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'</td>';
					html += '<td class="text-right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;'+format_money((list.invoice_list[v].total_due_amount?list.invoice_list[v].total_due_amount:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;'+format_money((list.invoice_list[v].total_due_amount?list.invoice_list[v].total_due_amount:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'</td>';
					html += '<td class="text-center"><div class="options btn-group '+dropup+'">';
					html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">';
					html += '<i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
					html += '<ul class="optionTag dropdown-menu">';
					if(list.user_type == 3){
						html += '<li><a href="<?php echo site_url("mech_pos_invoices/create/'+list.invoice_list[v].invoice_id+'");?>">';
						html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable44"); ?></a></li>';
					}
					html += '<li><a href="javascript:void(0)" data-toggle="modal" data-target="#addNewCar" data-invoice-id="'+list.invoice_list[v].invoice_id+'" class="add_feedback">';
					html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable374"); ?></a></li>';
					if(list.is_product == "Y"){
						html += '<li><a href="javascript:void(0)" data-toggle="modal" data-model_from="I" data-invoice_id="'+list.invoice_list[v].invoice_id+'" data-customer_id="'+list.invoice_list[v].customer_id+'" data-vehicle_id="'+list.invoice_list[v].customer_car_id+'" data-target="#addNewCar" class="add_recommended_product">';
						html += '<i class="fa fa-plus fa-margin" aria-hidden="true"></i> <?php _trans("lable853"); ?></a></li>';
					}
					html += '<li><a href="javascript:void(0)" data-toggle="modal" data-model_from="I" data-invoice_id="'+list.invoice_list[v].invoice_id+'" data-customer_id="'+list.invoice_list[v].customer_id+'" data-vehicle_id="'+list.invoice_list[v].customer_car_id+'" data-target="#addNewCar" class="add_recommended_service">';
					html += '<i class="fa fa-plus fa-margin" aria-hidden="true"></i> <?php _trans("lable395"); ?></a></li>';
					if(list.invoice_E == 1){
						html += '<li><a href="javascript:void(0)" onclick="sendmail('+list.invoice_list[v].invoice_id+')">';
						html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable375"); ?></a></li>';
					}
					html += '<li><a target="_blank" href="<?php echo site_url("mech_pos_invoices/generate_pdf/'+list.invoice_list[v].invoice_id+'"); ?>">';
					html += '<i class="fa fa-print fa-margin" aria-hidden="true"></i></i> <?php _trans("lable141"); ?></a></li>';
					html += '<li><a target="_blank" href="<?php echo site_url("mech_pos_invoices/generate_thermal_pdf/'+list.invoice_list[v].invoice_id+'"); ?>">';
					html += '<i class="fa fa-print fa-margin" aria-hidden="true"></i></i> <?php _trans("lable420"); ?></a></li>';
					if(list.user_type == 3){
						html += '<li><a href="javascript:void(0)" onclick="remove_entity(\''+list.invoice_list[v].invoice_id+'\',\'mech_pos_invoices\',\'invoice\',\'<?= $this->security->get_csrf_hash() ?>\')">';
						html += '<i class="fa fa-edit fa-times"></i> <?php _trans("lable47"); ?></a></li>';
					}
					html += '</ul></div></td></tr>';
                } 
            }else{ 
                html += '<tr><td colspan="8" class="text-center">No data found</td></tr>';
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
			$("#invoice_status").val('');
			$("#invoice_from_date").val('');
			$("#invoice_to_date").val('');
			$("#invoice_no").val('');
			$("#customer_id").val('');
			$("#vehicle_no").val('');
			$('.bootstrap-select').selectpicker("refresh");
			searchFilter();
		});
	});

</script>