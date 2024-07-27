<section class="card">
	<div class="card-block">
		<div class="row col-xl-12 col-lg-12 col-md-12 col-sm-12 padding0px">
			<input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
			<div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<label class="form_label"><?php _trans('lable95'); ?></label>
				<div class="form_controls">
					<select onchange="searchFilter()" name="branch_id" id="branch_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
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
				<label class="form_label"><?php _trans('lable838'); ?></label>
				<div class="form_controls">
					<select onchange="searchFilter()" name="quote_status" id="quote_status" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
						<option value=""><?php _trans('lable285'); ?></option>
						<option value="D" >Draft</option>
						<option value="G" >Generated</option>
					</select>
				</div>
			</div>
			<div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<label class="form_label"><?php _trans('lable839'); ?></label>
				<div class="form_controls">
					<input type="text" onkeyup="searchFilter()" name="quote_no" id="quote_no" class="form-control" autocomplete="off">
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
					<input type="text" onchange="searchFilter()" name="quote_from_date" id="quote_from_date" class="form-control datepicker" autocomplete="off">
				</div>
			</div>
			<div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<label class="form_label"><?php _trans('lable176'); ?></label>
				<div class="form_controls">
					<input type="text" onchange="searchFilter()" name="quote_to_date" id="quote_to_date" class="form-control datepicker" autocomplete="off">
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
							<th><?php _trans('lable840'); ?>.</th>
							<th class="text-center"><?php _trans('lable841'); ?></th>
							<th><?php _trans('lable370'); ?></th>
							<th><?php _trans('lable371'); ?></th>
							<th class="text-right"><?php _trans('lable842'); ?></th>
							<th class="text_align_center"><?php _trans('lable22'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php if(count($mech_quotes)>0){
							$i = 1;
							foreach ($mech_quotes as $quote) {
								if(count($mech_quotes) >= 4){

							if(count($mech_quotes) == $i || count($mech_quotes) == $i+1)
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
							<td data-original-title="<?php _htmlsc($quote->quote_no?$quote->quote_no:""); ?>" data-toggle="tooltip" class="textEllipsis"><a href="<?php echo site_url('mech_quotes/view/'.$quote->quote_id); ?>"><?php _htmlsc($quote->quote_no?$quote->quote_no:""); ?></a></td>
							<td data-original-title="<?php echo ($quote->quote_date?date_from_mysql($quote->quote_date):'-'); ?>" data-toggle="tooltip" class="textEllipsis text-center"><?php _htmlsc($quote->quote_date?date_from_mysql($quote->quote_date):'-'); ?></td>
							<td data-original-title="<?php _htmlsc($quote->client_name?$quote->client_name:''); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($quote->client_name?$quote->client_name:''); ?></td>
							<td data-original-title="<?php _htmlsc(($quote->brand_name?$quote->brand_name:" ")." ".($quote->model_name?$quote->model_name:"")." ".($quote->variant_name?$quote->variant_name:"")); ?>" data-toggle="tooltip" class="textEllipsis"><?php echo '<span class="car_reg_no">'.($quote->car_reg_no?$quote->car_reg_no:"").'</span>';?> <br> <?php _htmlsc(($quote->brand_name?$quote->brand_name:" ")." ".($quote->model_name?$quote->model_name:"")." ".($quote->variant_name?$quote->variant_name:"")); ?></td>					
							<td class="text-right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($quote->grand_total?$quote->grand_total:0),$this->session->userdata('default_currency_digit')); ?>" data-toggle="tooltip" class="text_align_center textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($quote->grand_total?$quote->grand_total:0),$this->session->userdata('default_currency_digit')); ?></td>
							<td class="text_align_center">
								<div class="options btn-group <?php echo $dropup; ?>">
									<a class="btn btn-default btn-sm dropdown-toggle"
									data-toggle="dropdown" href="#">
										<i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
									</a>
									<ul class="optionTag dropdown-menu">
										<?php if($this->session->userdata('user_type') == 3){ ?>
										<li>
											<a href="<?php echo site_url('mech_quotes/create/'.$quote->quote_id); ?>">
												<i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
											</a>
										</li>
										<?php } ?>
										<?php if($this->session->userdata('quote_E') == 1){ ?>
											<li>
												<a href="javascript:void(0)" onclick="sendmail(<?php echo $quote->quote_id; ?>)">
													<i class="fa fa-edit fa-margin"></i> <?php _trans('lable375'); ?>
												</a>
											</li>
										<?php } ?>
										<li>
											<a href="<?php echo site_url('mech_quotes/convert_to_invoice/' . $quote->quote_id); ?>">
                                                <i class="fa fa-edit fa-margin"></i> <?php _trans('lable490'); ?>
                                            </a>
                                        </li>
										<li>
											<a target="_blank" href="<?php echo site_url('mech_quotes/generate_pdf/'.$quote->quote_id); ?>">
												<i class="fa fa-print fa-margin" aria-hidden="true"></i></i> <?php _trans('lable141'); ?>
											</a>
										</li>
										<?php if($this->session->userdata('user_type') == 3){ ?>
										<li>
											<a href="javascript:void(0)" onclick="remove_entity(<?php echo $quote->quote_id; ?>,'mech_quotes', 'quote','<?= $this->security->get_csrf_hash() ?>')">
												<i class="fa fa-edit fa-times"></i> <?php _trans('lable47'); ?>
											</a>
										</li>
										<?php } ?>
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

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/autocomplete_veh_plugin.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="<?php echo base_url(); ?>assets/mp_backend/js/autocomplete_veh_plugin.js"></script>
<script src="<?php echo base_url(); ?>assets/mp_backend/js/autocomplete_veh_plugin_ui.js"></script>
<script>

function vehiclenumber(){
        var vehicle_no = $("#vehicle_no").val();
        if(vehicle_no.length > 2){
            $('#gif').show();
            $.post('<?php echo site_url('mech_quotes/ajax/getqutvehiclenos'); ?>', {
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
    var quote_status = $('#quote_status').val()?$('#quote_status').val():'';
    var branch_id = $("#branch_id").val()?$("#branch_id").val():'';
    var quote_from_date = $("#quote_from_date").val()?$("#quote_from_date").val():'';
    var quote_to_date = $("#quote_to_date").val()?$("#quote_to_date").val():'';
    var quote_no = $('#quote_no').val()?$('#quote_no').val():'';
    var customer_id = $('#customer_id').val()?$('#customer_id').val():'';
    var vehicle_no = $('#vehicle_no').val()?$('#vehicle_no').val():'';

    $.post('<?php echo site_url('mech_quotes/ajax/get_filter_list'); ?>', {
        page : page_num,
        quote_status : quote_status,
        branch_id : branch_id,
        quote_from_date : quote_from_date,
        quote_to_date : quote_to_date,
        quote_no : quote_no,
        customer_id : customer_id,
		vehicle_no : vehicle_no,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            var html = '';
            html += '<div class="overflowScrollForTable">';
            html += '<table class="display table datatable table-bordered" cellspacing="0" width="100%">';
            html += '<thead><tr>';
			html += '<th><?php _trans("lable840"); ?></th>';
			html += '<th class="text-center"><?php _trans("lable841"); ?></th>';
			html += '<th><?php _trans("lable370"); ?></th>';
			html += '<th><?php _trans("lable371"); ?></th>';
			html += '<th class="text-right"><?php _trans("lable842"); ?></th>';
			html += '<th class="text_align_center"><?php _trans("lable22"); ?></th>';
            html += '</tr></thead><tbody>';
            if(list.mech_quotes.length > 0){
                for(var v=0; v < list.mech_quotes.length; v++){ 
					if(list.mech_quotes.length >= 4)
					{ 
                    if(list.mech_quotes.length == v || list.mech_quotes.length == v+1)
                    {
                        var dropup = "dropup";
                    }
                    else
                    {
                        var dropup = "";
					}
					}
					html += '<td data-original-title="'+(list.mech_quotes[v].quote_no?list.mech_quotes[v].quote_no:"")+'" data-toggle="tooltip" class="textEllipsis"><a href="<?php echo site_url("mech_quotes/view/'+list.mech_quotes[v].quote_id+'"); ?>">'+(list.mech_quotes[v].quote_no?list.mech_quotes[v].quote_no:"")+'</a></td>';	
					html += '<td class="text-center" data-original-title="';
					html += list.mech_quotes[v].quote_date?formatDate(list.mech_quotes[v].quote_date):"";
                    html += '" data-toggle="tooltip" class="textEllipsis">';
                    html += (list.mech_quotes[v].quote_date?formatDate(list.mech_quotes[v].quote_date):"");
                    html += '</td>';
					html += '<td data-original-title="'+list.mech_quotes[v].client_name+'" data-toggle="tooltip" class="textEllipsis">'+(list.mech_quotes[v].client_name?list.mech_quotes[v].client_name:"")+'</td>';
					html += '<td><span class="car_reg_no">'+(list.mech_quotes[v].car_reg_no?list.mech_quotes[v].car_reg_no:"")+'</span><br>'+(list.mech_quotes[v].brand_name?list.mech_quotes[v].brand_name:" ")+' '+(list.mech_quotes[v].model_name?list.mech_quotes[v].model_name:" ")+' '+(list.mech_quotes[v].variant_name?list.mech_quotes[v].variant_name:" ")+'</td>';
					html += '<td class="text-right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;'+format_money((list.mech_quotes[v].grand_total?list.mech_quotes[v].grand_total:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;'+format_money((list.mech_quotes[v].grand_total?list.mech_quotes[v].grand_total:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'</td>';
					html += '<td class="text-center"><div class="options btn-group '+dropup+'">';
					html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">';
					html += '<i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
					html += '<ul class="optionTag dropdown-menu">';
					if(list.user_type == 3){
						html += '<li><a href="<?php echo site_url("mech_quotes/create/'+list.mech_quotes[v].quote_id+'");?>">';
						html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable44"); ?></a></li>';
					}
					if(list.quote_E == 1){
						html += '<li><a href="javascript:void(0)" onclick="sendmail('+list.mech_quotes[v].quote_id+')">';
						html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable375"); ?></a></li>';
					}
					html += '<li><a href="<?php echo site_url("mech_quotes/convert_to_invoice/'+list.mech_quotes[v].quote_id+'"); ?>">';
					html += '<i class="fa fa-edit fa-margin" aria-hidden="true"></i> <?php _trans("lable490"); ?></a></li>';
					html += '<li><a target="_blank" href="<?php echo site_url("mech_quotes/generate_pdf/'+list.mech_quotes[v].quote_id+'"); ?>">';
					html += '<i class="fa fa-print fa-margin" aria-hidden="true"></i> <?php _trans("lable141"); ?></a></li>';
					if(list.user_type == 3){
						html += '<li><a href="javascript:void(0)" onclick="remove_entity(\''+list.mech_quotes[v].quote_id+'\',\'mech_quotes\',\'quote\',\'<?= $this->security->get_csrf_hash() ?>\')">';
						html += '<i class="fa fa-edit fa-times"></i> <?php _trans("lable47"); ?></a></li>';
					}
					html += '</ul></div></td></tr>';
                } 
            }else{ 
                html += '<tr><td colspan="7" class="text-center">No data found</td></tr>';
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
function sendmail(quote_id){
	$('#modal-placeholder').load("<?php echo site_url('mailer/model_mech_quotes'); ?>/"+quote_id+"/I");
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
		$("#quote_status").val('');
		$("#quote_from_date").val('');
		$("#quote_to_date").val('');
		$("#quote_no").val('');
		$("#customer_id").val('');
		$("#vehicle_no").val('');
		$('.bootstrap-select').selectpicker("refresh");
		searchFilter();
	});
});
</script>	