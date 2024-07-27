<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php _trans('Customer Retention List'); ?></h3>
                </div>
            </div>
        </div>
    </div>
</header>
<div id="content" class="usermanagement">
    <div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 top-15">
			<a class="anchor anchor-back" onclick="goBack()" href="#"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
		</div>
	</div>
    <section class="card cr">
        <div class="card-block padding0px">
            <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>"autocomplete="off">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 retentionparent">
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-12 padding0px" style="padding-bottom:8%">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 padding0px contentheight">
                            <div class="commonHeightScroll">
                                <ul class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 padding0px custList">
                                    <?php if(count($list)>0){ foreach($list as $listas){ ?>
                                    <li class="removeActive col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 custli <?php if($customer_id == $listas->customer_car_id){ echo "active"; }?>" id="active_<?php echo $listas->customer_car_id;?>" onclick="getCustomerRetentionList(<?php echo $listas->customer_id; ?>,<?php echo $listas->customer_car_id; ?>,'<?php echo $from_date; ?>','<?php echo $to_date; ?>','<?php echo $kilometer;?>','<?php echo $type; ?>')">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 padding0px">
                                            <div class="width100_float">
                                                <span class="Clientname"><?php echo $listas->client_name; ?></span>
                                                <span class="pull-right"><?php if($listas->client_contact_no){ echo $listas->client_contact_no; } ?></span>
                                            </div>
                                            <div class="width100_float">
                                                <span class="sercountlable"><?php _trans('lable828'); ?></span>
                                                <span class="label label-pill label-success servprocount"><?php echo $listas->service_item; ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <?php } } else { ?>
                                        <li>No Date Found</li>
                                    <?php } ?>                                        
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-10 col-12 padding0px" style="padding-bottom:8%">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 padding0px contentheight">
                            <div class="commonHeightScroll padding0px" id="ShowDetails">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cr_floatbtn">
            <div class="col-lg-12 clearfix buttons text-right">
                <?php //if($type == "S"){ ?>
                <a class="btn btn-rounded btn-primary btn-padding-left-right-40 convertToLead" href="javascript:void(0)">
                    <i class="fa fa-edit fa-margin"></i> <?php _trans('Convert to Lead'); ?>
                </a>
                <a class="btn btn-rounded btn-primary btn-padding-left-right-40 convertToAppointment" href="javascript:void(0)">
                    <i class="fa fa-edit fa-margin"></i> <?php _trans('Convert to Appointment'); ?>
                </a>
                <?php //} ?> 
            </div>
        </div>  
    </section>
</div>

<script type="text/javascript">
   

function getCustomerRetentionList(customer_id, customer_car_id, from_date, to_date , kilometer, type){

    $(".removeActive").removeClass('active');
    $("#active_"+customer_car_id).addClass('active');

    $.post('<?php echo site_url('customer_retention/ajax/getCustomerRetentionList'); ?>', {
        customer_id: customer_id,
        customer_car_id : customer_car_id,
        from_date : from_date,
        to_date : to_date,
        kilometer: kilometer,
        type: type,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {
        list = JSON.parse(data);
        if(list.success=='1'){
            if(list.invoices.length > 0){
                var html = '';
                html += '<ul class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="customer_id" data-customer_car_id="'+customer_car_id+'" data-customer_id="'+customer_id+'">';
                for(var i = 0; i < list.invoices.length; i++){
                    html += '<li class="custilli"><a href="<?php echo site_url('mech_invoices/view/');?>'+list.invoices[i].invoice_id+'" target="_blank">';
                    html += '<div class="pcs-template">';
                    html += '<div class="pcs-template-body">';
                    html += '<div class="pcs-template-bodysection">';
                    html += '<div style="width: 100%;">';
                    html += '<table cellspacing="0" cellpadding="0" border="0" style="width: 100%;table-layout: fixed;word-wrap: break-word;" class="invoice-detailstable">';
                    html += '<thead><tr>';
                    html += '<th style="width: 33%"></th>';
                    html += '<th style="width: 33%"></th>';
                    html += '<th style="width: 33%"></th>';
                    html += '</tr></thead><tbody><tr>';
                    html += '<td style="border-right: 1px solid #9e9e9e;padding-bottom: 10px;font-size:8pt;">';
                    html += '<span class="pcs-label">#</span>';
                    html += '<span style="font-weight: 600;">: ';
                    if(list.invoices[i].invoice_no != '' && list.invoices[i].invoice_no != null){
                        html += list.invoices[i].invoice_no;
                    }
                    html += '</span>';
                    html += '<span class="pcs-label">Invoice Date</span>';
                    html += '<span style="font-weight: 600;">: ';
                    if(list.invoices[i].invoice_date != '' && list.invoices[i].invoice_date != null){
                        html += list.invoices[i].invoice_date;
                    }
                    html += '</span>';
                    html += '<span class="pcs-label">invoice To</span>';
                    html += '<span style="font-weight: 600;">: ';
                    if(list.invoices[i].client_name != '' && list.invoices[i].client_name != null){
                        html += list.invoices[i].client_name;
                    }
                    html += '</span>';
                    html += '<span class="pcs-label">Contact</span>';
                    html += '<span style="font-weight: 600;">: ';
                    if(list.invoices[i].client_contact_no != '' && list.invoices[i].client_contact_no != null){
                        html += list.invoices[i].client_contact_no;
                    }
                    html += '</span>';
                    html += '</td>';
                    html += '<td style="border-right: 1px solid #9e9e9e;padding-bottom: 10px;font-size:8pt;">';
                    if(list.invoices[i].car_reg_no != '' && list.invoices[i].car_reg_no != null){
                        html += '<span class="pcs-label"></span>';
                        html += '<span style="font-weight: 600;text-transform: uppercase;">: ';
                        html += list.invoices[i].car_reg_no;
                        html += '</span>';
                    }
                    html += '<span class="pcs-label">BMV</span>';
                    html += '<span style="font-weight: 600;">: ';
                    if(list.invoices[i].brand_name != '' && list.invoices[i].brand_name != null){
                        html += list.invoices[i].brand_name+'-';
                    }
                    if(list.invoices[i].model_name != '' && list.invoices[i].model_name != null){
                        html += list.invoices[i].model_name+'-';
                    }
                    if(list.invoices[i].variant_name != '' && list.invoices[i].variant_name != null){
                        html += list.invoices[i].variant_name;
                    }
                    html += '</span>';
                    html += '<span class="pcs-label">Fuel Type</span>';
                    html += '<span style="font-weight: 600;">: ';
                    if(list.invoices[i].fuel_type == 'P'){
                        html += 'Petrol';
                    }else if(list.invoices[i].fuel_type == 'D'){
                        html += 'Diesel';
                    }else if(list.invoices[i].fuel_type == 'G'){
                        html += 'Gas';
                    }
                    html += '</span>';
                   
                    if(list.invoices[i].current_odometer_reading != '' && list.invoices[i].current_odometer_reading != null){
                        html += '<span class="pcs-label">Odometer reading</span>';
                        html += '<span style="font-weight: 600;">: ';
                        html += list.invoices[i].current_odometer_reading;
                        html += '</span>';
                    }
                    if(list.invoices[i].fuel_level != ''  && list.invoices[i].fuel_level != null){
                        html += '<span class="pcs-label">Fuel level</span>';
                        html += '<span style="font-weight: 600;">: ';
                        html += list.invoices[i].fuel_level;
                        html += '</span>';
                    }
                    html += '</td>';
                    html += '<td style="border-right: 1px solid #9e9e9e;padding-bottom: 10px;font-size:8pt;">';
                    html += '<span class="pcs-label">Address :</span>';
                    html += '<span class="pcs-label">';
                    if(list.invoices[i].address_type != '' && list.invoices[i].address_type != null){
                        html += list.invoices[i].address_type;
                    }
                    html += '</span>';
                    if(list.invoices[i].full_address != '' && list.invoices[i].full_address != null){
                        html += '<span class="pcs-label"></span>';
                        html += '<span class="pcs-label">';
                        html += list.invoices[i].full_address;
                        html += '</span>';
                    }
                    if(list.invoices[i].zip_code != '' && list.invoices[i].zip_code != null){
                        html += '<span class="pcs-label"></span>';
                        html += '<span class="pcs-label">';
                        html += list.invoices[i].zip_code;
                        html += '</span>';
                    }
                    html += '</td></tr></tbody></table></div>';
                    html += '<div style="clear:both;"></div>';
                    if(list.invoices[i].products.length > 0){
                        html += '<table style="width: 100%;table-layout:fixed;clear: both;" class="pcs-itemtable" cellspacing="0" cellpadding="0" border="0">';
                        html += '<thead>';
                        html += '<tr style="height:17px;">';
                        html += '<td style="padding: 8px 5px 8px 5px;width: 5%;text-align: center;" valign="bottom" rowspan="2" class="pcs-itemtable-header pcs-itemtable-breakword">';
                        html += '<b>#</b>';
                        html += '</td>';
                        html += '<td style="padding: 8px 5px 8px 5px;width: 40%;text-align: left;" valign="bottom" rowspan="2" class="pcs-itemtable-header pcs-itemtable-breakword">';
                        html += '<b>Items &amp; Description</b>';
                        html += '</td>';
                        html += '<td style="padding: 8px 5px 8px 5px;width: 10%;text-align: right;" valign="bottom" rowspan="2" class="pcs-itemtable-header pcs-itemtable-breakword">';
                        html += '<b>Qty</b>';
                        html += '</td>';
                        html += '<td style="padding: 8px 5px 8px 5px;width: 15%;text-align: right;" valign="bottom" rowspan="2" class="pcs-itemtable-header pcs-itemtable-breakword">';
                        html += '<b>Amount</b>';
                        html += '</td>';
                        html += '<td style="padding: 8px 5px 8px 5px;width: 15%;text-align: right;" valign="bottom" rowspan="2" class="pcs-itemtable-header pcs-itemtable-breakword">';
                        html += '<b>Invoice Date</b>';
                        html += '</td>';
                        html += '<td style="padding: 8px 5px 8px 5px;width: 15%;text-align: right;border-right: 0px;" valign="bottom" rowspan="2" class="pcs-itemtable-header pcs-itemtable-breakword">';
                        html += '<b>Expiry Date</b>';
                        html += '</td>';
                        html += '</tr><tr>';
                        html += '</tr></thead>';
                        html += '<tbody class="itemBody">';
                        var ment = 1;
                        for(var j = 0; j < list.invoices[i].products.length; j++){
                            if(list.invoices[i].products[j].is_from == 'invoice_product'){

                                html += '<tr style="height:20px;">';
                                html += '<td rowspan="1" valign="top" style="text-align: center;" class="pcs-item-row">'+ment+'</td>';
                                html += '<td rowspan="1" valign="top" class="pcs-item-row">';
                                html += '<div><div>';
                                html += '<span style="word-wrap: break-word;">';
                                    if(list.invoices[i].products[j].product_name != '' && list.invoices[i].products[j].product_name != null){
                                        html += list.invoices[i].products[j].product_name;
                                    }
                                html += '</span>';
                                html += '</div></div>';
                                html += '</td>';
                                html += '<td rowspan="1" valign="top" style="text-align: right;" class="pcs-item-row" >';
                                    if(list.invoices[i].products[j].item_qty != '' && list.invoices[i].products[j].item_qty != null){
                                        html += list.invoices[i].products[j].item_qty;
                                    }
                                html += '</td>';
                                html += '<td rowspan="1" valign="top" style="text-align: right;" class="pcs-item-row" >';
                                    if(list.invoices[i].products[j].item_amount != '' && list.invoices[i].products[j].item_amount != null){
                                        html += list.invoices[i].products[j].item_amount;
                                    }
                                html += '</td>';
                                html += '<td rowspan="1" valign="top" style="text-align: right;" class="pcs-item-row" >';
                                    if(list.invoices[i].invoice_date != '' && list.invoices[i].invoice_date != null){
                                        html += list.invoices[i].invoice_date;
                                    }   
                                html += '</td>';
                                html += '<td rowspan="1" valign="top" style="text-align: right;" class="pcs-item-row" >';
                                    if(list.invoices[i].products[j].expiry_date != '' && list.invoices[i].products[j].expiry_date != null){
                                        html += list.invoices[i].products[j].expiry_date;
                                    }
                                html += '</td>';
                                html += '</tr>';
                            }
                            ment++;
                        }
                    }
                    html += '</tbody>';
                    html += '</table>';
                    html += '<div style="clear:both;"></div>';
                    if(list.invoices[i].services.length > 0){
                        html += '<table style="width: 100%;table-layout:fixed;clear: both;" class="pcs-itemtable" cellspacing="0" cellpadding="0" border="0">';
                        html += '<thead>';
                        html += '<tr style="height:17px;">';
                        html += '<td style="padding: 8px 5px 8px 5px;width: 5%;text-align: center;" valign="bottom" rowspan="2" class="pcs-itemtable-header pcs-itemtable-breakword">';
                        html += '<b>#</b>';
                        html += '</td>';
                        html += '<td style="padding: 8px 5px 8px 5px;width: 50%;text-align: left;" valign="bottom" rowspan="2" class="pcs-itemtable-header pcs-itemtable-breakword">';
                        html += '<b>Service &amp; Description</b>';
                        html += '</td>';
                        html += '<td style="padding: 8px 5px 8px 5px;width: 15%;text-align: right;" valign="bottom" rowspan="2" class="pcs-itemtable-header pcs-itemtable-breakword">';
                        html += '<b>Amount</b></td>';
                        html += '<td style="padding: 8px 5px 8px 5px;width: 15%;text-align: right;" valign="bottom" rowspan="2" class="pcs-itemtable-header pcs-itemtable-breakword">';
                        html += '<b>Invoice Date</b>';
                        html += '</td>';
                        html += '<td style="padding: 8px 5px 8px 5px;width: 15%;text-align: right;border-right: 0px;" valign="bottom" rowspan="2" class="pcs-itemtable-header pcs-itemtable-breakword">';
                        html += '<b>Expiry Date</b>';
                        html += '</td>';
                        html += '</tr>';
                        html += '<tr>';
                        html += '</tr>';
                        html += '</thead>';
                        html += '<tbody class="itemBody">';
                        var incr = 1;
                        for(var k = 0; k < list.invoices[i].services.length; k++){
                            if(list.invoices[i].services[k].is_from == 'invoice_service'){
                                html += '<tr style="height:20px;">';
                                html += '<td valign="top" style="text-align: center;" class="pcs-item-row">'+incr+'</td>';
                                html += '<td valign="top" class="pcs-item-row">';
                                html += '<div><div>';
                                html += '<span style="word-wrap: break-word;">';
                                if(list.invoices[i].services[k].service_item_name != '' && list.invoices[i].services[k].service_item_name != null){
                                    html += list.invoices[i].services[k].service_item_name;
                                }
                                html += '</span><br>';
                                html += '</div></div>';
                                html += '</td>';
                                html += '<td valign="top" style="text-align: right;" class="pcs-item-row">';
                                if(list.invoices[i].services[k].item_total_amount != '' && list.invoices[i].services[k].item_total_amount != null){
                                    html += list.invoices[i].services[k].item_total_amount;
                                }
                                html += '</td>';
                                html += '<td valign="top" style="text-align: right;" class="pcs-item-row">';
                                if(list.invoices[i].invoice_date != '' && list.invoices[i].invoice_date != null){
                                    html += list.invoices[i].invoice_date;
                                }
                                html += '</td>';
                                html += '<td rowspan="1" valign="top" style="text-align: right;" class="pcs-item-row">';
                                if(list.invoices[i].services[k].expiry_date != '' && list.invoices[i].services[k].expiry_date != null){
                                    html += list.invoices[i].services[k].expiry_date;
                                }
                                html += '</td>';
                                html += '</tr>';
                            }
                            incr++;
                        }
                    }
                    html += '</tbody></table>';
                    html += '<div style="clear:both;"></div>';
                    if(list.invoices[i].recommended_products.length > 0){
                        html += '<table style="width: 100%;table-layout:fixed;clear: both;" class="pcs-itemtable" cellspacing="0" cellpadding="0" border="0">';
                        html += '<thead>';
                        html += '<tr style="height:17px;">';
                        html += '<td style="padding: 8px 5px 8px 5px;width: 5%;text-align: center;" valign="bottom" rowspan="2" class="pcs-itemtable-header pcs-itemtable-breakword">';
                        html += '<b>#</b>';
                        html += '</td>';
                        html += '<td style="padding: 8px 5px 8px 5px;width: 80%;text-align: left;" valign="bottom" rowspan="2" class="pcs-itemtable-header pcs-itemtable-breakword">';
                        html += '<b>Recommended Products</b>';
                        html += '</td>';
                        html += '<td style="padding: 8px 5px 8px 5px;width: 15%;text-align: right;border-right: 0px;" valign="bottom" rowspan="2" class="pcs-itemtable-header pcs-itemtable-breakword">';
                        html += '<b>Type</b></td>';
                        html += '</tr>';
                        html += '<tr>';
                        html += '</tr>';
                        html += '</thead>';
                        html += '<tbody class="itemBody">';
                        for(var l=0; l<list.invoices[i].recommended_products.length; l++){
                            html += '<tr style="height:20px;">';
                            html += '<input type="hidden" id="recommended_id_'+list.invoices[i].recommended_products[l].recommended_id+'" value="'+list.invoices[i].recommended_products[l].recommended_id+'">';
                            html += '<td rowspan="1" valign="top" class="pcs-item-row text-center">';
                            html += '<input type="checkbox" name="checkbox" value="'+list.invoices[i].recommended_products[l].recommended_id+'">';
                            html += '</td>';
                            html += '<td rowspan="1" valign="top" class="pcs-item-row">';
                            html += '<div>';
                            html += '<div>';
                            html += '<span style="word-wrap: break-word;">'+list.invoices[i].recommended_products[l].product_name+'</span><br>';
                            html += '</div>';
                            html += '</div>';
                            html += '</td>';
                            html += '<td rowspan="1" valign="top" style="text-align: right;" class="pcs-item-row">';
                            if(list.invoices[i].recommended_products[l].service_status == 'M'){
                                html += 'Major';
                            }else if(list.invoices[i].recommended_products[l].service_status == 'N'){
                                html += 'Minor';
                            }
                            html += '</td>';
                            html += '</tr>';
                        }
                        html += '</tbody></table>';
                    }
                    html += '<div style="clear:both;"></div>';
                    if(list.invoices[i].recommended_services.length > 0){
                        html += '<table style="width: 100%;table-layout:fixed;clear: both;" class="pcs-itemtable" cellspacing="0" cellpadding="0" border="0">';
                        html += '<thead>';
                        html += '<tr style="height:17px;">';
                        html += '<td style="padding: 8px 5px 8px 5px;width: 5%;text-align: center;" valign="bottom" rowspan="2" class="pcs-itemtable-header pcs-itemtable-breakword">';
                        html += '<b>#</b>';
                        html += '</td>';
                        html += '<td style="padding: 8px 5px 8px 5px;width: 80%;text-align: left;" valign="bottom" rowspan="2" class="pcs-itemtable-header pcs-itemtable-breakword">';
                        html += '<b>Recommended Service</b>';
                        html += '</td>';
                        html += '<td style="padding: 8px 5px 8px 5px;width: 15%;text-align: right;border-right: 0px;" valign="bottom" rowspan="2" class="pcs-itemtable-header pcs-itemtable-breakword">';
                        html += '<b>Type</b></td>';
                        html += '</tr>';
                        html += '<tr>';
                        html += '</tr>';
                        html += '</thead>';
                        html += '<tbody class="itemBody">';
                        for(var l=0; l<list.invoices[i].recommended_services.length; l++){
                            html += '<tr style="height:20px;">';
                            html += '<input type="hidden" id="recommended_id_'+list.invoices[i].recommended_services[l].recommended_id+'" value="'+list.invoices[i].recommended_services[l].recommended_id+'">';
                            html += '<td rowspan="1" valign="top" class="pcs-item-row text-center">';
                            html += '<input type="checkbox" name="checkbox" value="'+list.invoices[i].recommended_services[l].recommended_id+'">';
                            html += '</td>';
                            html += '<td rowspan="1" valign="top" class="pcs-item-row">';
                            html += '<div>';
                            html += '<div>';
                            html += '<span style="word-wrap: break-word;">'+list.invoices[i].recommended_services[l].service_item_name+'</span><br>';
                            html += '</div>';
                            html += '</div>';
                            html += '</td>';
                            html += '<td rowspan="1" valign="top" style="text-align: right;" class="pcs-item-row">';
                            if(list.invoices[i].recommended_services[l].service_status == 'M'){
                                html += 'Major';
                            }else if(list.invoices[i].recommended_services[l].service_status == 'N'){
                                html += 'Minor';
                            }
                            html += '</td>';
                            html += '</tr>';
                        }
                        html += '</tbody></table>';
                    }
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</a></li>';
                }
                html += '</ul>';
                $("#ShowDetails").empty().append(html);
            }else{
                $("#ShowDetails").empty().append('<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center paddingTop40px">No data Found</div>');
            }
        }else{
            $("#ShowDetails").empty().append('<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center paddingTop40px">No data Found</div>');
        }
    });
}

$(document).ready(function(){

    var contentheight = window.screen.height-330;
 	$(".contentheight").css("height",contentheight);
 	$('.commonHeightScroll').slimScroll({
        height: contentheight
    });

    getCustomerRetentionList('<?php echo $customer_id; ?>','<?php echo $customer_car_id; ?>','<?php echo $from_date; ?>','<?php echo $to_date; ?>','<?php echo $kilometer;?>','<?php echo $type; ?>');
    
    $(document).on('click', '.convertToLead', function(){
        var recommended_ids = [];
        $('input:checkbox').each(function () {
            var sThisVal = (this.checked ? $(this).val() : "");
            if(sThisVal != ''){
                recommended_ids.push(sThisVal);
            }
        });
        var customer_id = $("#customer_id").attr('data-customer_id');
        var customer_car_id = $("#customer_id").attr('data-customer_car_id');

        if(recommended_ids.length == 0 || recommended_ids.length == ''){
            notie.alert(3, 'Please choose any recommended services', 2);
            return false;
        }

        $.post('<?php echo site_url('customer_retention/ajax/create_lead'); ?>', {
            customer_id : customer_id,
            customer_car_id : customer_car_id,
			recommended_ids : recommended_ids,
			_mm_csrf: $('#_mm_csrf').val()
        }, function (data) {
            list = JSON.parse(data);
            if(list.success=='1'){
                notie.alert(1, 'Successfully Created', 2);
				setTimeout(function(){
                    window.location = "<?php echo site_url('mech_leads/form'); ?>/"+list.ml_id;
                }, 100);
            }
        });
    });

    $(document).on('click', '.convertToAppointment', function(){
        var recommended_ids = [];
        $('input:checkbox').each(function () {
            var sThisVal = (this.checked ? $(this).val() : "");
            if(sThisVal != ''){
                recommended_ids.push(sThisVal);
            }
        });

        var customer_id = $("#customer_id").attr('data-customer_id');
        var customer_car_id = $("#customer_id").attr('data-customer_car_id');

        if(recommended_ids.length == 0 || recommended_ids.length == ''){
            notie.alert(3, 'Please choose any recommended services &amp; products', 2);
            return false;
        }

        $.post('<?php echo site_url('customer_retention/ajax/create_appointment'); ?>', {
            customer_id : customer_id,
            customer_car_id : customer_car_id,
			recommended_ids : recommended_ids,
			_mm_csrf: $('#_mm_csrf').val()
        }, function (data) {
            list = JSON.parse(data);
            if(list.success=='1'){
                notie.alert(1, 'Successfully Created', 2);
				setTimeout(function(){
                    window.location = "<?php echo site_url('mech_appointments/form'); ?>/"+list.ml_id;
                }, 100);
            }
        });
    });
});

</script>