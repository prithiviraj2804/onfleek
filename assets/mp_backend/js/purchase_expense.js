var existing_product = [];
var countofproduct = [];
$(document).ready(function() {
    $("#mode_of_payment").change(function(){
        if($(this).val() == 'O'){
            $("#bank_id").parent().parent().show()
        }else{
            $("#bank_id").parent().parent().hide()
        }
	});
	
    $(".item_product_id").each(function (index) {
		var product_row_id = $(this).parent().parent().attr("id");
		if (product_row_id) {
			if($("#"+product_row_id+" .item_id").val()){
				existing_product.push(parseInt($("#"+product_row_id+" .item_product_id").val()));
				product_calculation(parseInt($("#"+product_row_id+" .item_id").val()));
			}
		}
	});

    $("#supplier_id").change(function(){
        var gstin = $(this).find(':selected').data('gstin');
        $("#supplier_gstin").val(gstin);
	}).trigger('change');
	
	$("#services_item_product_id").on("change", function (e) {
		product_row_data();
	});
});

function changeSparetaxValue(id){
	if($("#gst_spare_"+id).val() != '' && $("#gst_spare_"+id).val() != null && $("#gst_spare_"+id).val() != undefined){
		$.post(taxURL, {
			tax_id : $("#gst_spare_"+id).val(),
			_mm_csrf : $('#_mm_csrf').val()
		}, function (data) {
			list = JSON.parse(data);
			if(list.success=='1'){
				var last_item_row = $('#product_item_table tbody>#tr_' + id);
				last_item_row.find('input[name=item_hsn]').val(list.data[0].hsn_code?list.data[0].hsn_code:'');
				last_item_row.find('input[name=igst_pct]').val(list.data[0].tax_value?list.data[0].tax_value:0);
				product_calculation(id);
			}
		});
	}else{
		var last_item_row = $('#product_item_table tbody>#tr_' + id);
		last_item_row.find('input[name=item_hsn]').val('');
		last_item_row.find('input[name=igst_pct]').val(0);
		product_calculation(id);
	}
	
}

function part_discountstate(){
	if($("#parts_discountstate").val() == 1){
		$(".showrupee").show();
		$(".showpercentage").hide();
	}else{
		$(".showrupee").hide();
		$(".showpercentage").show();
	}
	$("#product_item_table .item_product_id").each(function (index) {
		var product_row_id = $(this).parent().parent().attr("id");
		if (product_row_id) {
			if($("#"+product_row_id+" .item_product_id").val()){
				$("#"+product_row_id+" .item_discount").val('0');
				product_row_id = product_row_id.split('_');
				product_calculation(product_row_id[product_row_id.length - 1]);
			}
		}
	});
}

function popupproducts(productList){
	var newarray = [];
	if(productList != '' && productList != undefined){
		if(productList.length > 0){
			for(var i = 0 ; i < productList.length; i++){
				if(jQuery.inArray(parseInt(productList[i].product_id), existing_product) !== -1){
					newarray.push(parseInt(productList[i].product_id));
				}
			}
			var newArrays=$.merge($(existing_product).not(newarray).get(),$(newarray).not(existing_product).get());
			if(newArrays.length > 0){
				for(v = 0; v < newArrays.length; v++){
					var row_id = $("#duplicate_id_"+ newArrays[v] ).parent().parent().attr("id");
					if(row_id != '' && row_id != undefined && row_id != null){
						var pd_row_id = row_id.split('_');
						var rowdupid = pd_row_id[pd_row_id.length - 1];
						remove_product(newArrays[v] , rowdupid);
					}
				}
			}
			for(var i = 0; i < productList.length; i++){
				if(!existing_product.includes(parseInt(productList[i].product_id))){
					existing_product.push(parseInt(productList[i].product_id));
					countofproduct = $.grep(existing_product, function (elem) {
						return elem === productList[i].product_id;
					}).length;
					if (countofproduct <= 1) {
						var productname = productList[i].product_name;
						var add_mathround = parseInt(new Date().getTime() + Math.random());
						var next_row_id = $("#product_item_table > tbody > tr").length;
						$('#new_product_row').clone().appendTo('#product_item_table').removeAttr('id').addClass('item').attr('id', 'tr_' + add_mathround).show();
						$('#tr_' + add_mathround + ' .item_sno').attr('id', "item_sno_" + add_mathround);
						$('#tr_' + add_mathround + ' .item_sno').empty().html(next_row_id);
						$('#tr_' + add_mathround + ' .duplicate_id').attr('id', "duplicate_id_" + productList[i].product_id);
						$('#tr_' + add_mathround + ' .item_product_id').attr('id', "item_product_id_" + add_mathround);
						$('#tr_' + add_mathround + ' .item_product_name').attr('id', "item_product_name_" + add_mathround);
						// $('#tr_' + add_mathround + ' .gst_spare').attr('id', "gst_spare_" + add_mathround);
						$('#tr_' + add_mathround + ' .usr_lbr_price').attr('id', "usr_lbr_price_" + add_mathround);
						$('#tr_' + add_mathround + ' .product_id').attr('id', "product_id_" + add_mathround);
						$('#tr_' + add_mathround + ' .igst_pct').attr('id', "igst_pct_" + add_mathround);
						$('#tr_' + add_mathround + ' .kilo_from').attr('id', "kilo_from_" + add_mathround);
						$('#tr_' + add_mathround + ' .kilo_to').attr('id', "kilo_to_" + add_mathround);
						$('#tr_' + add_mathround + ' .mon_from').attr('id', "mon_from_" + add_mathround);
						$('#tr_' + add_mathround + ' .mon_to').attr('id', "mon_to_" + add_mathround);
						$('#tr_' + add_mathround + ' .remove_added_item').attr('id', "remove_added_item_" + add_mathround);
						$("#duplicate_id_"+productList[i].product_id).val(productList[i].product_id);
						$("#item_product_id_"+add_mathround).val(productList[i].product_id);
						$("#item_product_name_"+add_mathround).val(productList[i].product_name);
						var product_id = parseInt(productList[i].product_id);
						if (product_id != '' && product_id > 0) {
							$('.error_msg_product_item').empty().append('');
							var last_item_row = $('#product_item_table tbody>#tr_' + add_mathround);
							var ser_arr = productList[i];
							var product_name = ser_arr.product_name;
							var apply_for_all_bmv = ser_arr.apply_for_all_bmv;
							var cost_price = (ser_arr.cost_price?parseFloat(ser_arr.cost_price):'');
							var cost = (ser_arr.cost?parseFloat(ser_arr.cost):'');
							var default_cost_price = (ser_arr.default_cost_price?parseFloat(ser_arr.default_cost_price):'');
							var cpmin = cost_price?cost_price:cost;
							var cp = cpmin?cpmin:default_cost_price;
							var sale_price = (ser_arr.sale_price?parseFloat(ser_arr.sale_price):'');
							var sale = (ser_arr.sale?parseFloat(ser_arr.sale):'');
							var default_sale_price = (ser_arr.default_sale_price?parseFloat(ser_arr.default_sale_price):'');
							var spmin = sale_price?sale_price:sale;
							var sp = spmin?spmin:default_sale_price;
							var mech_price = cp;
							var user_price = sp;
							// var gst_spare_id = ser_arr.tax_id?ser_arr.tax_id:'';
							var igst_percentage = (ser_arr.tax_percentage?parseFloat(ser_arr.tax_percentage):0);
							var igst_amount = (ser_arr.igst_amount?parseFloat(ser_arr.igst_amount):0);
							var hsn_code = ser_arr.hsn_code?ser_arr.hsn_code:'';
							var kilo_from = ser_arr.kilo_from?ser_arr.kilo_from:'';
							var kilo_to = ser_arr.kilo_to?ser_arr.kilo_to:'';
							var mon_from = ser_arr.mon_from?ser_arr.mon_from:'';
							var mon_to = ser_arr.mon_to?ser_arr.mon_to:'';
							last_item_row.find('input[name=item_product_name]').val(product_name?product_name:"");
							last_item_row.find('input[name=usr_lbr_price]').attr('onblur', 'product_calculation("' + add_mathround + '")');
							// last_item_row.find('select[name=gst_spare]').attr('onchange', 'changeSparetaxValue("' + add_mathround + '")');
							last_item_row.find('input[name=item_discount]').attr('onblur', 'product_calculation("' + add_mathround + '")');
							last_item_row.find('input[name=product_qty]').attr('onkeyup', 'product_calculation("' + add_mathround + '")');
							last_item_row.find('input[name=igst_pct]').attr('onkeyup', 'product_calculation("' + add_mathround + '")');
							last_item_row.find('input[name=igst_pct]').attr('onblur', 'product_calculation("' + add_mathround + '")');
							// if(gst_spare_id != '' && parseInt(gst_spare_id) > 0){
							// 	last_item_row.find('select[name=gst_spare]').val(gst_spare_id);
							// }
							last_item_row.find('input[name=item_hsn]').val(hsn_code);
							last_item_row.find('input[name=product_qty]').val(1);
							last_item_row.find('input[name=mech_lbr_price]').val(parseFloat(mech_price).toFixed(2));
							last_item_row.find('input[name=usr_lbr_price]').val(format_money((parseFloat(user_price).toFixed(2)),default_currency_digit));
							last_item_row.find('input[name=igst_pct]').val(igst_percentage);
							last_item_row.find('input[name=igst_amount]').val(format_money((parseFloat(igst_amount).toFixed(2)),default_currency_digit));
							last_item_row.find('input[name=kilo_from]').val(kilo_from);
							last_item_row.find('input[name=kilo_to]').val(kilo_to);
							last_item_row.find('input[name=mon_from]').val(mon_from);
							last_item_row.find('input[name=mon_to]').val(mon_to);
							last_item_row.find('.remove_added_item').attr('onclick', 'remove_product("'+product_id+'","' + add_mathround + '")');
							// $().ready(function () {
							// 	$("#gst_spare_" + add_mathround).select2().on("change", function (e) {
							// 	});
							// 	$("#gst_spare_" + add_mathround).val(gst_spare_id).trigger('change');
							// });
							product_calculation(add_mathround);
						} else {
							emptyallfield(add_mathround);
						}
					}
				}
			}
		}
	}else{
		$('#product_item_table tbody tr.item').remove();
		overall_invoice_calc();
	}
}

function remove_product(product_id, product_row_id){
	for( var i = 0; i < existing_product.length; i++){ 
		if ( existing_product[i] == parseInt(product_id)) {
			existing_product.splice(i, 1); 
		}
	}
	$("#product_item_table #tr_"+product_row_id).remove();
	product_calculation(product_row_id);
}

function emptyallfield(product_row_id){
    var last_item_row = $('#product_item_table tbody>#tr_'+product_row_id);
    last_item_row.find('input').attr('id', product_row_id);
    last_item_row.find('input[name=usr_lbr_price]').attr('onblur', 'product_calculation("'+product_row_id+'")');
    last_item_row.find('input[name=item_discount]').attr('onblur', 'product_calculation("'+product_row_id+'")');
    last_item_row.find('input[name=product_qty]').attr('onkeyup', 'product_calculation("'+product_row_id+'")');
    last_item_row.find('input[name=igst_pct]').attr('onkeyup', 'product_calculation("'+product_row_id+'")');
}

function product_calculation(id) {

	if (id) {

		var tr_id = "tr_" + id;
		var mech_lbr_price = ($("#" + tr_id + " input[name=mech_lbr_price]").val()) ? parseFloat($("#" + tr_id + " input[name=mech_lbr_price]").val()) : 0;
		var usr_lbr_price = ($("#" + tr_id + " input[name=usr_lbr_price]").val()) ? parseFloat(($("#" + tr_id + " input[name=usr_lbr_price]").val()).replace(/,/g, '')) : 0;
		// $("#" + tr_id + " input[name=usr_lbr_price]").val(format_money((parseFloat(usr_lbr_price).toFixed(2)),default_currency_digit));
		var product_qty = ($("#" + tr_id + " input[name=product_qty]").val()) ? parseFloat($("#" + tr_id + " input[name=product_qty]").val()) : 1;
		var total_amount = parseFloat(usr_lbr_price) * product_qty;

		var parts_discountstate = $("#parts_discountstate").val();
		var item_discount = ($("#" + tr_id + " input[name=item_discount]").val()) ? parseFloat(($("#" + tr_id + " input[name=item_discount]").val()).replace(/,/g, '')) : 0;
		$("#" + tr_id + " input[name=item_discount]").val(format_money((parseFloat(item_discount).toFixed(2)),default_currency_digit));


		if(parts_discountstate == 1){
			var discount_amount = (product_qty * parseFloat(item_discount));
			var total_taxable_amount = total_amount - (product_qty * parseFloat(item_discount));
		}else{
			if(parseFloat(item_discount) > 100 || parseFloat(item_discount) < 0){
				item_discount = 0;
				$("#" + tr_id + " input[name=item_discount]").val(format_money((parseFloat(item_discount).toFixed(2)),default_currency_digit));
			}
			var discount_amount = (total_amount * parseFloat(item_discount) / 100);
			var total_taxable_amount = total_amount - discount_amount;
		}

		$("#" + tr_id + " input[name=item_amount]").val(parseFloat(total_taxable_amount).toFixed(2));
		$("#" + tr_id + " .item_amount_label").empty().html(format_money(parseFloat(total_taxable_amount).toFixed(2),default_currency_digit));
		var igst_pct = ($("#" + tr_id + " input[name=igst_pct]").val()) ? parseFloat($("#" + tr_id + " input[name=igst_pct]").val()) : 0;
		if(parseInt(igst_pct) > 100){
			igst_pct = 0;
			$("#" + tr_id + " input[name=igst_pct]").val(0);
		}

		var igst_amount = (igst_pct) ? parseFloat(((total_taxable_amount * igst_pct)) / 100) : 0;

		$("#" + tr_id + " input[name=igst_amount]").val(parseFloat(igst_amount).toFixed(2));
		$("#" + tr_id + " input[name=total_amount]").val(total_amount.toFixed(2));
		$("#" + tr_id + " input[name=total_mech_amount]").val((mech_lbr_price * product_qty).toFixed(2));
		// $("#" + tr_id + " input[name=igst_amount]").val(igst_amount.toFixed(2));
		$("#" + tr_id + " input[name=item_discount_price]").val((parseFloat(discount_amount)).toFixed(2));
		$("#" + tr_id + " .igst_amount_label").empty().html(format_money(parseFloat(igst_amount).toFixed(2),default_currency_digit)+'('+igst_pct+'%)');

		var item_total_amount = (parseFloat(total_taxable_amount) + parseFloat(igst_amount));

		$("#" + tr_id + " input[name=item_total_amount]").val(item_total_amount.toFixed(2));
		$("#" + tr_id + " .item_total_amount_label").empty().html(format_money(parseFloat(item_total_amount).toFixed(2),default_currency_digit));
	}
	product_group_tax_calculation();

}

function product_group_tax_calculation() {

	var total_mech_lbr_price = group_by_textbox_name_value('product', 'mech_lbr_price');
	var total_usr_lbr_price = group_by_textbox_name_value('product', 'total_amount');
	var total_item_amount = group_by_textbox_name_value('product', 'item_amount');
	var total_item_discount = group_by_textbox_name_value('product', 'item_discount_price');
	var total_igst_amount = group_by_textbox_name_value('product', 'igst_amount');
	var total_item_total_amount = group_by_textbox_name_value('product', 'item_total_amount');

	$("#product_item_table input[name=total_mech_lbr_price]").val(total_mech_lbr_price.toFixed(2));
	$("#product_item_table input[name=total_usr_lbr_price]").val(total_usr_lbr_price.toFixed(2));
	$("#product_item_table input[name=total_item_discount").val(total_item_discount.toFixed(2));
	$("#product_item_table input[name=total_igst_amount]").val(total_igst_amount.toFixed(2));
	$("#product_item_table input[name=total_item_total_amount]").val(total_item_total_amount.toFixed(2));

	$("#product_item_table .total_usr_lbr_price_label").empty().html(currency_symbol+format_money(parseFloat(total_usr_lbr_price).toFixed(2),default_currency_digit));
	$("#product_item_table .total_item_discount_label").empty().html(currency_symbol+format_money(parseFloat(total_item_discount).toFixed(2),default_currency_digit));
	
	$("#product_item_table .total_item_amount_label").empty().html(currency_symbol+format_money(parseFloat(total_item_amount).toFixed(2),default_currency_digit));
	$("#product_item_table .total_igst_amount_label").empty().html(currency_symbol+parseFloat(total_igst_amount).toFixed(2));
	$("#product_item_table .total_item_total_amount_label").empty().html(currency_symbol+format_money(parseFloat(total_item_total_amount).toFixed(2),default_currency_digit));

	overall_invoice_calc();
}

function overall_invoice_calc() {

	var grand_total = 0;

	var total_product_mech_lab_amount = $("#product_item_table input[name=total_mech_lbr_price]").val()?$("#product_item_table input[name=total_mech_lbr_price]").val().replace(/,/g, ''):0;
	var total_product_usr_lab_amount = $("#product_item_table input[name=total_usr_lbr_price]").val()?$("#product_item_table input[name=total_usr_lbr_price]").val().replace(/,/g, ''):0;
	var total_product_discount_amount = $("#product_item_table input[name=total_item_discount").val()?$("#product_item_table input[name=total_item_discount").val().replace(/,/g, ''):0;
	var total_product_igst_amount = $("#product_item_table input[name=total_igst_amount]").val()?$("#product_item_table input[name=total_igst_amount]").val().replace(/,/g, ''):0;
	var total_product_amount = $("#product_item_table input[name=total_item_total_amount]").val()?$("#product_item_table input[name=total_item_total_amount]").val().replace(/,/g, ''):0;
	var product_total_taxable = parseFloat(total_product_usr_lab_amount) - parseFloat(total_product_discount_amount);

	var product_gst_price = parseFloat(total_product_igst_amount);
	var total_product_invoice = parseFloat(product_total_taxable) + parseFloat(product_gst_price);
	var total_taxable_amount = parseFloat(product_total_taxable);

	grand_total = parseFloat(total_product_invoice);

	$(".total_user_product_price").val(format_money(parseFloat(total_product_usr_lab_amount).toFixed(2),default_currency_digit));
	$(".product_total_discount").val(format_money(parseFloat(total_product_discount_amount).toFixed(2),default_currency_digit));
	$(".total_user_product_taxable").val(format_money(parseFloat(product_total_taxable).toFixed(2),default_currency_digit));
	$(".total_user_product_gst").val(format_money(parseFloat(product_gst_price).toFixed(2),default_currency_digit));
	$(".total_product_invoice").val(format_money(parseFloat(total_product_amount).toFixed(2),default_currency_digit));

	//all total 
	$(".total_taxable_amount").val(format_money(parseFloat(total_taxable_amount).toFixed(2),default_currency_digit));
	$(".total_gst_amount").val((format_money(parseFloat(product_gst_price),default_currency_digit)));
	$(".grand_total").empty().html(format_money(parseFloat(grand_total).toFixed(2),default_currency_digit));

	var renumpro = 1;
	$("#product_item_table tr td.item_sno").each(function() {
		$(this).text(renumpro);
    	renumpro++;
	});

	$('.addproduct').attr('data-existing_product_ids', '');
	var existing_product_ids = existing_product.toString();
	$("#existing_product_ids").val(existing_product_ids);
	$('.addproduct').attr('data-existing_product_ids', existing_product_ids);

}

function group_by_textbox_name_value (id,name_arg) {
    var group_by_value = 0;
	$('table#'+id+'_item_table tbody>tr').each(function () {
		$(this).find('input[name='+name_arg+']').each(function () {
		 	//console.log(name_arg+"======"+$(this).val());
        	if($(this).val()){
            	group_by_value += parseFloat($(this).val().replace(/,/g, ''));
        	}
		});
	});
	return group_by_value;
}

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