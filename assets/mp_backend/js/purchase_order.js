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
			if($("#"+product_row_id+" .item_product_id").val()){
				existing_product.push(parseInt($("#"+product_row_id+" .item_product_id").val()));
				product_calculation(parseInt($("#"+product_row_id+" .item_id").val()));
			}
		}
	});

    $("#supplier_id").change(function(){
        var gstin = $(this).find(':selected').data('gstin');
        $("#supplier_gstin").val(gstin);
	}).trigger('change');
	
	// if($('#purchase_id').val() == ''){
	// 	product_row_data();
	// }

	$("#services_item_product_id").on("change", function (e) {
		// if($("#user_car_list_id").val() == ''){
		// 	notie.alert(3, 'Please choose vehicle', 2);
		// 	$("#services_item_product_id").val(0);
		// 	$('#services_item_product_id').selectpicker("refresh");
		// 	return false;
		// }else{
			product_row_data();
		// }
	});
});

function product_row_data(product_id){
		
	var product_id = parseInt(product_id);
	if(product_id == "" || product_id == 0){
		return false;
	}
	existing_product.push(parseInt(product_id));
	
	countofproduct = $.grep(existing_product, function (elem) {
		return elem === product_id;
	}).length;
	
	if (countofproduct > 1) {
		notie.alert(3, 'Product Already Selected!', 2);
		$("#services_item_product_id").val(0);
		$('#services_item_product_id').selectpicker("refresh");
		return false;
	}
	
	// var productname = $("#services_item_product_id option:selected").text();

	var add_mathround = parseInt(new Date().getTime() + Math.random());
	var next_row_id = $("#product_item_table > tbody > tr").length;
	$('#new_product_row').clone().appendTo('#product_item_table').removeAttr('id').addClass('item').attr('id', 'tr_' + add_mathround).show();
	$('#tr_' + add_mathround + ' .item_sno').attr('id', "item_sno_" + add_mathround);
	$('#tr_' + add_mathround + ' .item_sno').empty().html(next_row_id);
	$('#tr_' + add_mathround + ' .item_product_id').attr('id', "item_product_id_" + add_mathround);
	$('#tr_' + add_mathround + ' .item_product_name').attr('id', "item_product_name_" + add_mathround);
	$('#tr_' + add_mathround + ' .usr_lbr_price').attr('id', "usr_lbr_price_" + add_mathround);
	$('#tr_' + add_mathround + ' .product_id').attr('id', "product_id_" + add_mathround);
	$('#tr_' + add_mathround + ' .igst_pct').attr('id', "igst_pct_" + add_mathround);
	$('#tr_' + add_mathround + ' .kilo_from').attr('id', "kilo_from_" + add_mathround);
	$('#tr_' + add_mathround + ' .kilo_to').attr('id', "kilo_to_" + add_mathround);
	$('#tr_' + add_mathround + ' .mon_from').attr('id', "mon_from_" + add_mathround);
	$('#tr_' + add_mathround + ' .mon_to').attr('id', "mon_to_" + add_mathround);
	$('#tr_' + add_mathround + ' .remove_added_item').attr('id', "remove_added_item_" + add_mathround);

	$("#item_product_id_"+add_mathround).val(product_id);
	// $("#item_product_name_"+add_mathround).val(productname);

	// var product_id = parseInt($("#services_item_product_id").val());
	if (product_id != '' && product_id > 0) {
		$('.error_msg_product_item').empty().append('');
		getProductDetails(product_id, add_mathround);
		$("#services_item_product_id").val(0);
		$('#services_item_product_id').selectpicker("refresh");
	} else {
		emptyallfield(add_mathround);
	}
}

function getProductDetails(product_id, product_row_id) {

	$.post(getProductDetailsURL, {
		product_id: product_id,
		_mm_csrf: $('#_mm_csrf').val(),
	}, function (data) {
		product_items = JSON.parse(data);
		if (product_items) {
			
			var last_item_row = $('#product_item_table tbody>#tr_' + product_row_id);

			if(product_items.success == '1'){
				var ser_arr = product_items.products;
				var product_name = ser_arr.product_name;
				var apply_for_all_bmv = ser_arr.apply_for_all_bmv;
				var mech_price = (ser_arr.cost_price?parseFloat(ser_arr.cost_price):parseFloat(ser_arr.default_cost_price));
				var user_price = (ser_arr.sale_price?parseFloat(ser_arr.sale_price):parseFloat(ser_arr.default_sale_price));
				var igst_percentage = (ser_arr.tax_percentage?parseFloat(ser_arr.tax_percentage):0);
				var igst_amount = (ser_arr.igst_amount?parseFloat(ser_arr.igst_amount):0);
				var hsn_code = ser_arr.hsn_code?ser_arr.hsn_code:'';
				var kilo_from = ser_arr.kilo_from?ser_arr.kilo_from:'';
				var kilo_to = ser_arr.kilo_to?ser_arr.kilo_to:'';
				var mon_from = ser_arr.mon_from?ser_arr.mon_from:'';
				var mon_to = ser_arr.mon_to?ser_arr.mon_to:'';
			}else{
				var product_name = "";
				var apply_for_all_bmv = "";
				var mech_price = 0;
				var user_price = 0;
				var igst_percentage = 0;
				var igst_amount = 0;
				var kilo_from = 0;
				var kilo_to = 0;
				var mon_from = 0;
				var mon_to = 0;
				var hsn_code = '';
			}


			last_item_row.find('input[name=item_product_name]').val(product_name?product_name:"");
			last_item_row.find('input[name=usr_lbr_price]').attr('onblur', 'product_calculation("' + product_row_id + '")');
			last_item_row.find('input[name=item_discount]').attr('onblur', 'product_calculation("' + product_row_id + '")');
			last_item_row.find('input[name=product_qty]').attr('onkeyup', 'product_calculation("' + product_row_id + '")');
			last_item_row.find('input[name=igst_pct]').attr('onkeyup', 'product_calculation("' + product_row_id + '")');
			last_item_row.find('input[name=item_hsn]').val(hsn_code);
			last_item_row.find('input[name=product_qty]').val(1);
			last_item_row.find('input[name=mech_lbr_price]').val(mech_price.toFixed(2));
			last_item_row.find('input[name=usr_lbr_price]').val(format_money((parseFloat(user_price).toFixed(2)),default_currency_digit));
			last_item_row.find('input[name=igst_pct]').val(igst_percentage);
			last_item_row.find('input[name=igst_amount]').val(format_money((parseFloat(igst_amount).toFixed(2)),default_currency_digit));
			last_item_row.find('input[name=kilo_from]').val(kilo_from);
			last_item_row.find('input[name=kilo_to]').val(kilo_to);
			last_item_row.find('input[name=mon_from]').val(mon_from);
			last_item_row.find('input[name=mon_to]').val(mon_to);
			last_item_row.find('.remove_added_item').attr('onclick', 'remove_product("'+product_id+'","' + product_row_id + '")');

			product_calculation(product_row_id);
		}
	});
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
		$("#" + tr_id + " input[name=usr_lbr_price]").val(format_money((parseFloat(usr_lbr_price).toFixed(2)),default_currency_digit));

		var product_qty = ($("#" + tr_id + " input[name=product_qty]").val()) ? parseFloat($("#" + tr_id + " input[name=product_qty]").val()) : 1;

		var item_discount = ($("#" + tr_id + " input[name=item_discount]").val()) ? parseFloat(($("#" + tr_id + " input[name=item_discount]").val()).replace(/,/g, '')) : 0;
		$("#" + tr_id + " input[name=item_discount]").val(format_money((parseFloat(item_discount).toFixed(2)),default_currency_digit));

		var total_amount = parseFloat(usr_lbr_price) * product_qty;
		var total_taxable_amount = total_amount - (product_qty * parseFloat(item_discount));

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
		$("#" + tr_id + " input[name=item_discount_price]").val((product_qty * parseFloat(item_discount)).toFixed(2));
		$("#" + tr_id + " .igst_amount_label").empty().html(format_money(parseFloat(igst_amount).toFixed(2),default_currency_digit));

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

	$("#product_item_table .total_usr_lbr_price_label").empty().html(format_money(parseFloat(total_usr_lbr_price).toFixed(2),default_currency_digit));
	$("#product_item_table .total_item_discount_label").empty().html(format_money(parseFloat(total_item_discount).toFixed(2),default_currency_digit));
	
	$("#product_item_table .total_item_amount_lable").empty().html(format_money(parseFloat(total_item_amount).toFixed(2),default_currency_digit));
	$("#product_item_table .total_igst_amount_label").empty().html(parseFloat(total_igst_amount).toFixed(2));
	$("#product_item_table .total_item_total_amount_label").empty().html(format_money(parseFloat(total_item_total_amount).toFixed(2),default_currency_digit));

	overall_invoice_calc();
}

function overall_invoice_calc() {

	var rewards_amount = 0;
	var applied_for = '';
	var inclusive_exclusive = '';
	var reward_type = '';
	var reward_amount = 0;
	var rewards_tax = '';
	var total_earned_amount = 0;
	var earned_amount = 0;
	var grand_total = 0;
	
	if($("#applied_rewards:checked").is(":checked")){
		rewards_amount = parseFloat($("#rewards_amount").val())?parseFloat($("#rewards_amount").val()):'';
		applied_for = $("#applied_for").val()?$("#applied_for").val():''; // A - All ,P -  Product , S - Service
		inclusive_exclusive = $("#inclusive_exclusive").val()?$("#inclusive_exclusive").val():''; // 1 - inclusive , 2 - exclusive
		reward_type = $("#reward_type").val()?$("#reward_type").val():''; // Type P -point / R -percentage / A - amount
		reward_amount = parseFloat($("#reward_amount").val())?parseFloat($("#reward_amount").val()):''; //  Rewards Points / percentage / Amount
		rewards_tax = $("#rewards_tax").val()?$("#rewards_tax").val():''; // Type I -With Tax / E - Without Tax
		earned_amount = $("#earned_amount").val()?parseFloat($("#earned_amount").val()):'';
		if(reward_type == 'P'){
			total_earned_amount = rewards_amount * reward_amount;
		}else if(reward_type == 'R'){
			total_earned_amount = (rewards_amount * reward_amount)/100;
		}else if(reward_type == 'A'){
			total_earned_amount = reward_amount;
		}
		if(total_earned_amount > 0){
			$("#showRewards").show();
			$("#hideRewards").hide();
		}else{
			$("#showRewards").hide();
			$("#hideRewards").show();
		}
	}

	var total_product_mech_lab_amount = $("#product_item_table input[name=total_mech_lbr_price]").val()?$("#product_item_table input[name=total_mech_lbr_price]").val().replace(/,/g, ''):0;
	var total_service_mech_lab_amount = $("#service_item_table input[name=total_mech_lbr_price]").val()?$("#service_item_table input[name=total_mech_lbr_price]").val().replace(/,/g, ''):0;
	var total_product_usr_lab_amount = $("#product_item_table input[name=total_usr_lbr_price]").val()?$("#product_item_table input[name=total_usr_lbr_price]").val().replace(/,/g, ''):0;
	var total_service_usr_lab_amount = $("#service_item_table input[name=total_usr_lbr_price]").val()?$("#service_item_table input[name=total_usr_lbr_price]").val().replace(/,/g, ''):0;
	var total_product_discount_amount = $("#product_item_table input[name=total_item_discount").val()?$("#product_item_table input[name=total_item_discount").val().replace(/,/g, ''):0;
	var total_service_discount_amount = $("input[name=service_discount").val()?$("input[name=service_discount").val().replace(/,/g, ''):0;
	total_service_discount_amount = (total_service_discount_amount == '') ? 0 : total_service_discount_amount;
	var total_product_igst_amount = $("#product_item_table input[name=total_igst_amount]").val()?$("#product_item_table input[name=total_igst_amount]").val().replace(/,/g, ''):0;
	var total_service_igst_amount = $("#service_item_table input[name=total_igst_amount]").val()?$("#service_item_table input[name=total_igst_amount]").val().replace(/,/g, ''):0;
	var total_product_amount = $("#product_item_table input[name=total_item_total_amount]").val()?$("#product_item_table input[name=total_item_total_amount]").val().replace(/,/g, ''):0;
	var total_service_amount = $("#service_item_table input[name=total_item_total_amount]").val()?$("#service_item_table input[name=total_item_total_amount]").val().replace(/,/g, ''):0;
	var service_discount = parseFloat(total_service_discount_amount);
	var service_discount_amount = 0;
	if($("#discountstate").val() == 1){
		if(service_discount > total_service_usr_lab_amount){
			notie.alert(3,'Discount Amount is greater than service total', 2);
			$(".btn_submit").hide();
		}else{
			service_discount_amount = parseFloat(service_discount);
			$(".btn_submit").show();
		}
		
	}else{
		if(parseFloat(service_discount) <= 100){
			service_discount_amount = (parseFloat(total_service_usr_lab_amount) * service_discount) / 100;
			$(".btn_submit").show();
		}else{
			notie.alert(3,'Percentage should be less than 100', 2);
			$(".btn_submit").hide();
		}
	}

	var service_total_taxable = (total_service_usr_lab_amount - service_discount_amount);

	var service_gst_pct = ($('#total_service_tax').val() == '') ? 0 : $('#total_service_tax').val();
	// var service_gst_amount = (service_gst_pct) ? parseFloat((service_total_taxable * service_gst_pct) / 100) : 0;
	// var total_servie_invoice = service_total_taxable + service_gst_amount;

	var mech_total = parseFloat(total_product_mech_lab_amount) + parseFloat(total_service_mech_lab_amount);
	var user_total = parseFloat(total_product_usr_lab_amount) + parseFloat(total_service_usr_lab_amount);
	var product_total_taxable = parseFloat(total_product_usr_lab_amount) - parseFloat(total_product_discount_amount);

	var product_gst_price = parseFloat(total_product_igst_amount);
	var total_product_invoice = parseFloat(product_total_taxable) + parseFloat(product_gst_price);
	var total_taxable_amount = parseFloat(product_total_taxable);

	grand_total = parseFloat(total_product_invoice);

	$(".total_user_service_price").empty().html(format_money(total_service_usr_lab_amount,default_currency_digit));
	$(".service_total_discount").empty().html(format_money(service_discount_amount.toFixed(2),default_currency_digit));
	// $(".total_user_service_taxable").empty().html(format_money(service_total_taxable.toFixed(2),default_currency_digit));
	// $(".total_servie_gst_price").empty().html(format_money(service_gst_amount.toFixed(2),default_currency_digit));
	// $('.total_servie_invoice').empty().html(format_money(total_servie_invoice.toFixed(2),default_currency_digit));

	$(".total_user_product_price").empty().html(format_money(parseFloat(total_product_usr_lab_amount).toFixed(2),default_currency_digit));
	$(".product_total_discount").empty().html(format_money(parseFloat(total_product_discount_amount).toFixed(2),default_currency_digit));
	$(".total_user_product_taxable").empty().html(format_money(parseFloat(product_total_taxable).toFixed(2),default_currency_digit));
	$(".total_user_product_gst").empty().html(format_money(parseFloat(product_gst_price).toFixed(2),default_currency_digit));
	$(".total_product_invoice").empty().html(format_money(parseFloat(total_product_amount).toFixed(2),default_currency_digit));


	//all total 
	$(".total_taxable_amount").empty().html(format_money(parseFloat(total_taxable_amount).toFixed(2),default_currency_digit));
	$(".total_gst_amount").empty().html((format_money(parseFloat(product_gst_price),default_currency_digit)));

	$(".grand_total").empty().html(format_money(parseFloat(grand_total).toFixed(2),default_currency_digit));
	$(".total_earned_amount").empty().append(total_earned_amount.toFixed(2));

	var renumpro = 1;
	$("#product_item_table tr td.item_sno").each(function() {
		$(this).text(renumpro);
    	renumpro++;
	});



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
