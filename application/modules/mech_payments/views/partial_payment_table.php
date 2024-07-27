<div id="content" class="table-content">
    <section class="card">
		<div class="card-block">
            <div class="row col-xl-12 col-lg-12 col-md-12 col-sm-12 padding0px">
                <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
                
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable473'); ?></label>
                    <div class="form_controls">
                        <select onchange="searchFilter()" name="entity_type" id="entity_type" class="bootstrap-select bootstrap-select-arrow g-input" data-live-search="true">
                            <option value=""><?php _trans('lable111'); ?></option>
                            <option value="invoice"><?php _trans('lable119'); ?></option>
                            <option value="jobcard"><?php _trans('lable1019'); ?></option>
                            <option value="purchase"><?php _trans('lable120'); ?></option>
                            <option value="expense"><?php _trans('lable121'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable454'); ?></label>
                    <div class="form_controls">
                        <select onchange="searchFilter()" name="payment_method_id" id="payment_method_id" class="bootstrap-select bootstrap-select-arrow g-input" data-live-search="true">
                            <option value=""><?php _trans('lable113'); ?></option>
                            <?php foreach ($payment_methods as $payment_method) { ?>
                            <option value="<?php echo $payment_method->payment_method_id; ?>"> <?php echo $payment_method->payment_method_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable106'); ?>/<?php _trans('lable107'); ?></label>
                    <div class="form_controls">
                        <select onchange="searchFilter()" name="customer_id" id="customer_id" class="searchSelect bootstrap-select bootstrap-select-arrow customerList " data-live-search="true">
                            <option value=""><?php _trans('lable474'); ?></option>
                            <optgroup label="Customer">
                                <?php foreach ($customer_list as $customer){?>
                                <option value="<?php echo $customer->client_id; ?>"><?php echo $customer->client_name."(".$customer->client_contact_no.")";  ?></option>
                                <?php } ?>
                            </optgroup>
                            <optgroup label="Supplier">
                                <?php foreach ($supplier_details as $supplier): ?>
                                <option value="<?php echo $supplier->supplier_id; ?>"><?php _htmlsc($supplier->supplier_name); ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable105'); ?></label>
                    <div class="form_controls">
                        <input onchange="searchFilter()" type="text" name="paid_on" id="paid_on" class="form-control datepicker" autocomplete="off">
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
                    <table id="mechanic_list" class="display table datatable table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th><?php _trans('lable104'); ?></th>
                                <th class="text-center"><?php _trans('lable105'); ?></th>
                                <th><?php _trans('lable119'); ?></th>
                                <th><?php _trans('lable106'); ?>/<?php _trans('lable107'); ?></th>
                                <th class="text_align_right"><?php _trans('lable108'); ?></th>
                                <th><?php _trans('lable109'); ?></th>
                                <th class="text_align_center"><?php _trans('lable22'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($payments)>0){
                                $i = 1;
                            foreach ($payments as $payment) {
                                if(count($payments) >= 4){
                                if(count($payments) == $i || count($payments) == $i+1)
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
                                <td data-original-title="<?php _htmlsc($payment->entity_type); ?>" data-toggle="tooltip" class="textEllipsis"><?php echo ucfirst($payment->entity_type); ?></td>
                                <td class="text-center" data-original-title="<?php _htmlsc($payment->paid_on?date_from_mysql($payment->paid_on):""  ); ?>" data-toggle="tooltip" class="textEllipsis"><?php  echo ($payment->paid_on?date_from_mysql($payment->paid_on):""); ?></td>

                                <td data-original-title="<?php if ($payment->entity_type == 'invoice') { ?>                              
                            <?php echo $payment->invoice_no; ?> 
                            <?php  } elseif ($payment->entity_type == 'jobcard'){?> 
                                    <?php echo $payment->jobsheet_no;?>                               
                            <?php  } elseif ($payment->entity_type == 'purchase'){?> 
                                    <?php echo $payment->purchase_no;?>
                            <?php } elseif ($payment->entity_type == 'expense'){ ?> 
                                <?php echo ($payment->expense_no);?>  
                            <?php } ?>" data-toggle="tooltip" class="textEllipsis">
                                
                                <?php if ($payment->entity_type == 'invoice') { 
                                    if($this->session->userdata('plan_type') != 3){ ?>
                                    <a href="<?php echo site_url('mech_invoices/view/'.$payment->entity_id); ?>">
                                        <?php echo $payment->invoice_no; ?>
                                    </a>
                                <?php } else { ?>
                                        <a href="<?php echo site_url('spare_invoices/view/'.$payment->entity_id); ?>">
                                            <?php echo $payment->invoice_no; ?>
                                        </a>
                                <?php } } elseif ($payment->entity_type == 'jobcard') { ?> 

                                    <a href="<?php echo site_url('mech_work_order_dtls/view/'.$payment->entity_id); ?>">
                                        <?php echo $payment->jobsheet_no;?>
                                    </a>    
                

                                <?php  } elseif ($payment->entity_type == 'purchase'){?> 

                                    <a href="<?php echo site_url('mech_purchase/view/'.$payment->entity_id); ?>">
                                        <?php echo $payment->purchase_no;?>
                                    </a>

                                <?php } elseif ($payment->entity_type == 'expense'){ ?> 

                                    <a href="<?php echo site_url('mech_expense/view/'.$payment->entity_id);?>">
                                    <?php echo ($payment->expense_no);?>  
                                    </a>

                                <?php } ?> 
                                </td>
                                <td data-original-title="<?php _htmlsc(getCustomerSupplierName($payment->customer_id, $payment->entity_type)); ?>" data-toggle="tooltip" class="textEllipsis">
                                    <?php if ($payment->entity_type == 'invoice' || $payment->entity_type == 'jobcard') {
                                    $site_url = 'clients/form/';
                                    
                                } elseif ($payment->entity_type == 'purchase' || $payment->entity_type == 'expense') {
                                    $site_url = 'suppliers/form/';
                                } ?>
                                    <a href="<?php echo site_url($site_url.$payment->customer_id); ?>" title="<?php _trans('lable122'); ?>">
                                        <?php _htmlsc(getCustomerSupplierName($payment->customer_id, $payment->entity_type)); ?>
                                    </a>
                                </td>
                                <td class="text-right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($payment->payment_amount?$payment->payment_amount:0),$this->session->userdata('default_currency_digit'));?>" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($payment->payment_amount?$payment->payment_amount:0),$this->session->userdata('default_currency_digit')); ?></td>
                                <td class="text-left" data-original-title="<?php _htmlsc($payment->payment_method_name); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($payment->payment_method_name); ?></td>
                                <td class="text_align_center">
                                    <div class="options btn-group <?php echo $dropup; ?>">
                                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                                            <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                        </a>
                                        <ul class="optionTag dropdown-menu">
                                            <?php /* * / if (($payment->inv_tda > 0 && $payment->entity_type == 'invoice') || ($payment->pur_tda > 0 && $payment->entity_type == 'purchase') || ($payment->exp_tda > 0 && $payment->entity_type == 'expense')) {?>
                                            <li>
                                                <a href="<?php echo site_url('mech_payments/form/'.$payment->payment_id); ?>">
                                                    <i class="fa fa-edit fa-margin"></i>
                                                    <?php _trans('lable44'); ?>
                                                </a>
                                            </li><?php } / * */?>
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_record('mech_payments',<?php echo $payment->payment_id; ?>, '<?= $this->security->get_csrf_hash() ?>')"> <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <?php $i++; } } else { echo '<tr><td colspan="7" class="text-center" > No data found </td></tr>'; } ?>
                        </tbody>
                    </table>
                </div>
                <div class="headerbar-item pull-right paddingTop20px">
                    <?php echo $createLinks;?>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
function searchFilter(page_num) {
    page_num = page_num?page_num:0;
    var paid_on = $('#paid_on').val()?$('#paid_on').val():'';
    var entity_type = $("#entity_type").val()?$("#entity_type").val():'';
    var payment_method_id = $("#payment_method_id").val()?$("#payment_method_id").val():'';
    var customer_id = $("#customer_id").val()?$("#customer_id").val():'';

    $.post('<?php echo site_url('mech_payments/ajax/get_filter_list'); ?>', {
        page : page_num,
        paid_on : paid_on,
        entity_type : entity_type,
        payment_method_id : payment_method_id,
        customer_id : customer_id,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            var html = '';
            html += '<div class="overflowScrollForTable">';
            html += '<table class="display table datatable table-bordered" cellspacing="0" width="100%">';
            html += '<thead><tr>';
            html += '<th><?php _trans("lable104"); ?></th>';
            html += '<th class="text-center"><?php _trans("lable105"); ?></th>';
            html += '<th><?php _trans("lable119"); ?></th>';
            html += '<th><?php _trans("lable106"); ?>/<?php _trans("lable107"); ?></th>';
            html += '<th class="text_align_right"><?php _trans("lable108"); ?></th>';
            html += '<th><?php _trans("lable109"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable22"); ?></th>';
            html += '</tr></thead><tbody>';
            if(list.payments.length > 0){
                for(var v=0; v < list.payments.length; v++){ 
                    if(list.payments.length >= 4){
                    if(list.payments.length == v || list.payments.length == v+1)
                    {
                        var dropup = "dropup";
                    }
                    else
                    {
                        var dropup = "";
                    }
                }
                    html += '<tr>';
                    html += '<td data-original-title="'+(list.payments[v].entity_type?list.payments[v].entity_type:"")+'" data-toggle="tooltip" class="textEllipsis">'+(list.payments[v].entity_type?list.payments[v].entity_type:"")+'</td>';
                    html += '<td class="text-center textEllipsis" data-original-title="'+(list.payments[v].paid_on?formatDate(list.payments[v].paid_on):"")+'" data-toggle="tooltip">'+(list.payments[v].paid_on?formatDate(list.payments[v].paid_on):"")+'</td>';
                    html += '<td data-original-title="';
					if(list.payments[v].entity_type == 'invoice'){
                        html += list.payments[v].invoice_no;
                    }else if(list.payments[v].entity_type == 'jobcard'){ 
                        html += list.payments[v].jobsheet_no;
                    }else if(list.payments[v].entity_type == 'purchase'){ 
                        html += list.payments[v].purchase_no;
                    }else if(list.payments[v].entity_type == 'expense'){
                        html += list.payments[v].expense_no;
                    }
                    html += '" data-toggle="tooltip" class="textEllipsis">';
                    
                    if(list.payments[v].entity_type == 'invoice'){
                        <?php if($this->session->userdata('plan_type') != 3){ ?>
                        html += '<a href="<?php echo site_url("mech_invoices/view/'+list.payments[v].entity_id+'");?>">'+(list.payments[v].invoice_no?list.payments[v].invoice_no:"")+'</a>';
                        <?php } else { ?>
                        html += '<a href="<?php echo site_url("spare_invoices/view/'+list.payments[v].entity_id+'");?>">'+(list.payments[v].invoice_no?list.payments[v].invoice_no:"")+'</a>';
                        <?php } ?>
                    }else if(list.payments[v].entity_type == 'jobcard'){ 
                        html += '<a href="<?php echo site_url("mech_work_order_dtls/view/'+list.payments[v].entity_id+'");?>">'+(list.payments[v].jobsheet_no?list.payments[v].jobsheet_no:"")+'</a>';
                    }else if(list.payments[v].entity_type == 'purchase'){ 
                        html += '<a href="<?php echo site_url("mech_purchase/create/'+list.payments[v].entity_id+'");?>">'+(list.payments[v].purchase_no?list.payments[v].purchase_no:"")+'</a>';
                    }else if(list.payments[v].entity_type == 'expense'){
                        html += '<a href="<?php echo site_url("mech_expense/create/'+$payment->entity_id+'");?>">'+(list.payments[v].expense_no?list.payments[v].expense_no:"")+'</a>';
                    }
                    html += '</td>';
                    html += '<td data-original-title="';
					var site_url = '';
                    if(list.payments[v].entity_type == 'invoice' || list.payments[v].entity_type == 'jobcard'){
                        site_url = "clients/form/";
                    }else if(list.payments[v].entity_type == 'purchase' || list.payments[v].entity_type == 'expense'){
                        site_url = "suppliers/form/";
                    }
                    html += '" data-toggle="tooltip" class="textEllipsis">';
                    
                    var site_url = '';
                    if(list.payments[v].entity_type == 'invoice' || list.payments[v].entity_type == 'jobcard'){
                        site_url = "clients/form/";
                    }else if(list.payments[v].entity_type == 'purchase' || list.payments[v].entity_type == 'expense'){
                        site_url = "suppliers/form/";
                    }
                    html += '<a href="<?php echo site_url("'+site_url+list.payments[v].customer_id+'"); ?>" title="<?php _trans("lable122"); ?>">'+(list.payments[v].cusSupname?list.payments[v].cusSupname:"")+'</a></td>';
                    html += '<td class="text-right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;'+format_money((list.payments[v].payment_amount?list.payments[v].payment_amount:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;'+format_money((list.payments[v].payment_amount?list.payments[v].payment_amount:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'</td>';
                    html += '<td class="text-left" data-original-title="'+(list.payments[v].payment_method_name)+'" data-toggle="tooltip" class="textEllipsis">'+list.payments[v].payment_method_name+'</td>';
                    html += '<td class="text_align_center">';
                    html += '<div class="options btn-group '+dropup+'">';
                    html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">';
                    html += '<i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
                    html += '<ul class="optionTag dropdown-menu">';
                    // if((list.payments[v].inv_tda > 0 && list.payments[v].entity_type == 'invoice') || (list.payments[v].job_tda > 0 && list.payments[v].entity_type == 'jobcard') || (list.payments[v].pur_tda > 0 && list.payments[v].entity_type == 'purchase') || (list.payments[v].exp_tda > 0 && list.payments[v].entity_type == 'expense')){
                    //     html += '<li><a href="<?php // echo site_url("mech_payments/form/'+list.payments[v].payment_id+'"); ?>">';
                    //     html += '<i class="fa fa-edit fa-margin"></i><?php // _trans("lable44"); ?></a></li>';
                    // }
                    html += '<li><a href="javascript:void(0)" onclick="delete_record(\'mech_payments\',\''+list.payments[v].payment_id+'\',\'<?= $this->security->get_csrf_hash() ?>\')">';
                    html += '<i class="fa fa-trash-o fa-margin"></i> <?php _trans("lable47"); ?></a></li>';
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
            $("#paid_on").val('');
            $("#entity_type").val('');
            $("#payment_method_id").val('');
            $("#customer_id").val('');
            $('.bootstrap-select').selectpicker("refresh");
            searchFilter();
        });

	});
</script>