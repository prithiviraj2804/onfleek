var existing_service = [];
var countofservice = [];
var existing_product = [];
var countofproduct = [];
var existing_service_package = [];
var countofservicepackage = [];
	
function getfile()
{
 	var filename = $('input[type=file]').val().split("\\");
 	$("#fileName").val(filename[2]);
 	$("#showError").hide();
}

$(document).ready(function () {
	$("#mode_of_payment").change(function () {
		if ($(this).val() == 'O') {
			$("#bank_id").parent().parent().show()
		} else {
			$("#bank_id").parent().parent().hide()
		}
	});
	
	$("#service_item_table .item_service_id").each(function (index) {
		var service_row_id = $(this).parent().parent().attr("id");
		if (service_row_id) {
			if($("#"+service_row_id+" .rs_item_id").val()){
				existing_service.push(parseInt($("#"+service_row_id+" .item_service_id").val()));
				service_calculation(parseInt($("#"+service_row_id+" .rs_item_id").val()));
			}
		}
	});

	$("#service_package_item_table .item_service_id").each(function (index) {
		var service_row_id = $(this).parent().parent().attr("id");
		if (service_row_id) {
			if($("#"+service_row_id+" .rs_item_id").val()){
				existing_service_package.push(parseInt($("#"+service_row_id+" .item_service_id").val()));
				service_package_calculation(parseInt($("#"+service_row_id+" .rs_item_id").val()));
			}
		}
	});
	
	$("#product_item_table .item_product_id").each(function (index) {
		var product_row_id = $(this).parent().parent().attr("id");
		if (product_row_id) {
			if($("#"+product_row_id+" .rs_item_id").val()){
				existing_product.push(parseInt($("#"+product_row_id+" .item_product_id").val()));
				product_calculation(parseInt($("#"+product_row_id+" .rs_item_id").val()));
			}
		}
	});
	

	$("#s_pack_id").on("change", function (e) {

		if($("#customer_car_id").val() == ''){
			notie.alert(3, 'Please choose vehicle', 2);
			$("#s_pack_id").val(0);
			$('#s_pack_id').selectpicker("refresh");
			return false;
		}else{
			var s_pack_id = $("#s_pack_id").val();

			
			if(s_pack_id == "" || s_pack_id == 0 || s_pack_id == NaN){
				return false;
			}

			existing_service_package.push(parseInt(s_pack_id));

			countofservicepackage = $.grep(existing_service_package, function (elem) {
				return elem === parseInt(s_pack_id);
			}).length;
			
			if (countofservicepackage > 1) {
				notie.alert(3, 'Service package Selected!', 2);
				$("#s_pack_id").val(0);
				$('#s_pack_id').selectpicker("refresh");
				return false;
			}

			var servicename = $("#s_pack_id option:selected").text();
			
			var add_mathround = parseInt(new Date().getTime() + Math.random());
			var next_row_id = $("#service_package_item_table > tbody > tr").length;

			$('#new_service_package_row').clone().appendTo('#service_package_item_table').removeAttr('id').addClass('item').attr('id', 'tr_' + add_mathround).show();

			$('#tr_' + add_mathround + ' .item_sno').attr('id', "item_sno_" + add_mathround);
			$('#tr_' + add_mathround + ' .item_sno').empty().html(next_row_id);
			$('#tr_' + add_mathround + ' .item_service_id').attr('id', "item_service_id_" + add_mathround);
			$('#tr_' + add_mathround + ' .employee_id').attr('id', "employee_id_" + add_mathround);
			$('#tr_' + add_mathround + ' .item_service_name').attr('id', "item_service_name_" + add_mathround);
			$('#tr_' + add_mathround + ' .usr_lbr_price').attr('id', "usr_lbr_price_" + add_mathround);
			$('#tr_' + add_mathround + ' .service_id').attr('id', "service_id_" + add_mathround);
			$('#tr_' + add_mathround + ' .item_hsn').attr('id', "item_hsn_" + add_mathround);
			$('#tr_' + add_mathround + ' .kilo_from').attr('id', "kilo_from_" + add_mathround);
			$('#tr_' + add_mathround + ' .kilo_to').attr('id', "kilo_to_" + add_mathround);
			$('#tr_' + add_mathround + ' .mon_from').attr('id', "mon_from_" + add_mathround);
			$('#tr_' + add_mathround + ' .mon_to').attr('id', "mon_to_" + add_mathround);
			$('#tr_' + add_mathround + ' .remove_added_item').attr('id', "remove_added_item" + add_mathround);

			$().ready(function () {
				$("#employee_id_" + add_mathround).select2().on("change", function (e) {
				});
			});

			$("#item_service_id_"+add_mathround).val(s_pack_id);
			$("#item_service_name_"+add_mathround).val(servicename);

			if (parseInt(s_pack_id) > 0 ) {
				getServicePackageDetails(parseInt(s_pack_id), add_mathround);
				$("#s_pack_id").val(0);
				$('#s_pack_id').selectpicker("refresh");
			} else {
				emptyallfield(add_mathround);
			}
			$("#s_pack_id").val(0);
			$('#s_pack_id').selectpicker("refresh");
		}
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



// Services  
function popupservices(serviceList){
	var newarray = [];
	if(serviceList != '' && serviceList != undefined){
		if(serviceList.length > 0){
			for(var i = 0 ; i < serviceList.length; i++){
				if(jQuery.inArray(parseInt(serviceList[i].msim_id), existing_service) !== -1){
					newarray.push(parseInt(serviceList[i].msim_id));
				}
			}
			var newArrays=$.merge($(existing_service).not(newarray).get(),$(newarray).not(existing_service).get());
			if(newArrays.length > 0){
				for(v = 0; v < newArrays.length; v++){
					var row_id = $("#duplicate_id_"+ newArrays[v] ).parent().parent().attr("id");
					if(row_id != '' && row_id != undefined && row_id != null){
						var pd_row_id = row_id.split('_');
						var rowdupid = pd_row_id[pd_row_id.length - 1];
						remove_service(newArrays[v] , rowdupid);
					}
				}
			}
			for(var i = 0; i < serviceList.length; i++){
				if(!existing_service.includes(parseInt(serviceList[i].msim_id))){
					existing_service.push(parseInt(serviceList[i].msim_id));
					countofservice = $.grep(existing_service, function (elem) {
						return elem === serviceList[i].msim_id;
					}).length;
					if (countofservice <= 1) {
						var add_mathround = parseInt(new Date().getTime() + Math.random());
						var next_row_id = $("#service_item_table > tbody > tr").length;
						$('#new_service_row').clone().appendTo('#service_item_table').removeAttr('id').addClass('item').attr('id', 'tr_' + add_mathround).show();
						$('#tr_' + add_mathround + ' .item_sno').attr('id', "item_sno_" + add_mathround);
						$('#tr_' + add_mathround + ' .item_sno').empty().html(next_row_id);
						$('#tr_' + add_mathround + ' .duplicate_id').attr('id', "duplicate_id_" + serviceList[i].msim_id);
						$('#tr_' + add_mathround + ' .item_service_id').attr('id', "item_service_id_" + add_mathround);
						$('#tr_' + add_mathround + ' .item_service_name').attr('id', "item_service_name_" + add_mathround);
						$('#tr_' + add_mathround + ' .employee_id').attr('id', "employee_id_" + add_mathround);
						$('#tr_' + add_mathround + ' .item_hsn').attr('id', "item_hsn_" + add_mathround);
						$('#tr_' + add_mathround + ' .service_id').attr('id', "service_id_" + add_mathround);
						$('#tr_' + add_mathround + ' .usr_lbr_price').attr('id', "usr_lbr_price_" + add_mathround);
						$('#tr_' + add_mathround + ' .item_discount').attr('id', "item_discount_" + add_mathround);
						// $('#tr_' + add_mathround + ' .gst_service').attr('id', "gst_service_" + add_mathround);
						$('#tr_' + add_mathround + ' .kilo_from').attr('id', "kilo_from_" + add_mathround);
						$('#tr_' + add_mathround + ' .kilo_to').attr('id', "kilo_to_" + add_mathround);
						$('#tr_' + add_mathround + ' .mon_from').attr('id', "mon_from_" + add_mathround);
						$('#tr_' + add_mathround + ' .mon_to').attr('id', "mon_to_" + add_mathround);
						$('#tr_' + add_mathround + ' .remove_added_item').attr('id', "remove_added_item" + add_mathround);

						var mech_price = (serviceList[i].default_cost?parseFloat(serviceList[i].default_cost):0);
						var user_price = (serviceList[i].estimated_cost?parseFloat(serviceList[i].estimated_cost):0);
						var igst_percentage = (serviceList[i].tax_percentage?parseFloat(serviceList[i].tax_percentage):0);
						// var gst_service_id = (serviceList[i].tax_id?parseFloat(serviceList[i].tax_id):0);
						var last_item_row = $('#service_item_table tbody>#tr_'+add_mathround);
						last_item_row.find('input[name=usr_lbr_price]').attr('onblur', 'service_calculation("'+add_mathround+'")');
						// last_item_row.find('select[name=gst_service]').attr('onchange', 'changeServicetaxValue("'+add_mathround+'")');
						last_item_row.find('input[name=item_discount]').attr('onblur', 'service_calculation("' + add_mathround + '")');
						last_item_row.find('input[name=igst_pct]').attr('onkeyup', 'service_calculation("' + add_mathround + '")');
						last_item_row.find('input[name=igst_pct]').attr('onblur', 'service_calculation("' + add_mathround + '")');
						last_item_row.find('input[name=mech_lbr_price]').val(parseFloat(mech_price).toFixed(2));
						last_item_row.find('input[name=usr_lbr_price]').val(format_money((parseFloat(user_price).toFixed(2)),default_currency_digit));
						last_item_row.find('input[name=item_hsn]').val((serviceList[i].sku?serviceList[i].sku:""));
						// if(gst_service_id != '' && gst_service_id != null && parseInt(gst_service_id) > 0){
						// 	last_item_row.find('select[name=gst_service]').val(gst_service_id);
						// }else{
						// 	gst_service_id = '';
						// }
						last_item_row.find('input[name=igst_pct]').val((igst_percentage?igst_percentage:""));
						last_item_row.find('input[name=kilo_from]').val((serviceList[i].kilo_from?serviceList[i].kilo_from:""));
						last_item_row.find('input[name=kilo_to]').val((serviceList[i].kilo_to?serviceList[i].kilo_to:""));
						last_item_row.find('input[name=mon_from]').val((serviceList[i].mon_from?serviceList[i].mon_from:""));
						last_item_row.find('input[name=mon_to]').val((serviceList[i].mon_to?serviceList[i].mon_to:""));
						last_item_row.find('.remove_added_item').attr('onclick', 'remove_service("'+serviceList[i].msim_id+'","' + add_mathround + '")');
						$("#duplicate_id_"+serviceList[i].msim_id).val(serviceList[i].msim_id);
						$("#item_service_id_"+add_mathround).val(serviceList[i].msim_id);
						$("#item_service_name_"+add_mathround).val(serviceList[i].service_item_name);
						$().ready(function () {
							$("#employee_id_" + add_mathround).select2().on("change", function (e) {
							});
							// $("#gst_service_" + add_mathround).select2().on("change", function (e) {
							// });
							$("#employee_id_" + add_mathround).val(0).trigger('change');
							// $("#gst_service_" + add_mathround).val(gst_service_id).trigger('change');
						});
						service_calculation(add_mathround);
					}
				}
			}
		}
	}else{
		$('#service_item_table tbody tr.item').remove();
		overall_invoice_calc();
	}
}


function changeServicetaxValue(id){
	if($("#gst_service_"+id).val() != '' && $("#gst_service_"+id).val() != null && $("#gst_service_"+id).val() != undefined){
		$.post(taxURL, {
			tax_id : $("#gst_service_"+id).val(),
			_mm_csrf : $('#_mm_csrf').val()
		}, function (data) {
			list = JSON.parse(data);
			if(list.success=='1'){
				var last_item_row = $('#service_item_table tbody>#tr_' + id);
				last_item_row.find('input[name=item_hsn]').val(list.data[0].hsn_code?list.data[0].hsn_code:'');
				last_item_row.find('input[name=igst_pct]').val(list.data[0].tax_value?list.data[0].tax_value:0);
				service_calculation(id);
			}
		});
	}else{
		var last_item_row = $('#service_item_table tbody>#tr_' + id);
		last_item_row.find('input[name=item_hsn]').val('');
		last_item_row.find('input[name=igst_pct]').val(0);
		service_calculation(id);
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

function service_discountstate(){
	if($("#service_discountstate").val() == 1){
		$(".showservicerupee").show();
		$(".showservicepercentage").hide();
	}else{
		$(".showservicerupee").hide();
		$(".showservicepercentage").show();
	}
	
	$("#service_item_table .item_service_id").each(function (index) {
		var service_row_id = $(this).parent().parent().attr("id");
		if (service_row_id) {
			if($("#"+service_row_id+" .item_service_id").val()){
				$("#"+service_row_id+" .item_discount").val('0');
				service_row_id = service_row_id.split('_');
				service_calculation(service_row_id[service_row_id.length - 1]);
			}
		}
	});
}

function getServicePackageDetails(s_pack_id , service_row_id){
	$.post(getServicePackageDetailsURL, {
		user_car_list_id: $('#customer_car_id').val(),
		s_pack_id: s_pack_id,
		_mm_csrf: $('#_mm_csrf').val(),
	}, function (data) {
		service_items = JSON.parse(data);
		if (service_items) {
			if (service_items.success == '1' || service_items.success == 1) {
				var ser_arr = service_items.data[0];
				var mech_price = (ser_arr.service_cost?parseFloat(ser_arr.service_cost):0);
				var user_price = (ser_arr.service_cost?parseFloat(ser_arr.service_cost):0);
				var kilo_from = (ser_arr.kilo_from?parseFloat(ser_arr.kilo_from):0);
				var kilo_to = (ser_arr.kilo_to?parseFloat(ser_arr.kilo_to):0);
				var mon_from = (ser_arr.mon_from?parseFloat(ser_arr.mon_from):0);
				var mon_to = (ser_arr.mon_to?parseFloat(ser_arr.mon_to):0);
				var item_hsn =  (ser_arr.sku?ser_arr.sku:"");
			}
			if (service_items.success == '0') {
				var mech_price = 0;
				var user_price = 0;
				var kilo_from = 0;
				var kilo_to = 0;
				var mon_from = 0;
				var mon_to = 0;
				var item_hsn =  '';
			}

			var last_item_row = $('#service_package_item_table tbody>#tr_' + service_row_id);
			last_item_row.find('input[name=usr_lbr_price]').attr('onblur', 'service_package_calculation("' + service_row_id + '")');
			last_item_row.find('input[name=mech_lbr_price]').val(mech_price.toFixed(2));
			last_item_row.find('input[name=usr_lbr_price]').val(format_money(parseFloat(user_price).toFixed(2),default_currency_digit));
			last_item_row.find('input[name=item_hsn]').val(item_hsn);
			last_item_row.find('input[name=kilo_from]').val(kilo_from);
			last_item_row.find('input[name=kilo_to]').val(kilo_to);
			last_item_row.find('input[name=mon_from]').val(mon_from);
			last_item_row.find('input[name=mon_to]').val(mon_to);
			last_item_row.find('.remove_added_item').attr('onclick', 'remove_package("'+s_pack_id+'","' + service_row_id + '")');
			service_package_calculation(service_row_id);
		}
	});
}

function service_row_data(servicelist){

	var service_id = $("#services_add_service").val();

	if(service_id == "" || service_id == 0 || service_id == NaN){
		return false;
	}

	existing_service.push(parseInt(service_id));

	countofservice = $.grep(existing_service, function (elem) {
	    return elem === parseInt(service_id);
	}).length;
	
	if (countofservice > 1) {
		notie.alert(3, 'Service Already Selected!', 2);
		$("#services_add_service").val(0);
		$('#services_add_service').selectpicker("refresh");
       return false;
	}
	
	var servicename = $("#services_add_service option:selected").text();

	if(servicelist != '' && servicelist != undefined){

		if(servicelist.length > 0){

			$('#service_item_table tbody tr.item').remove();
			$('#product_item_table tbody tr.item').remove();

			for(var i = 0; i < servicelist.length; i++){

				var mech_price = '';
				var user_price = '';
				var add_mathround = parseInt(new Date().getTime() + Math.random());
				var next_row_id = $("#service_item_table > tbody > tr").length;

				$('#new_service_row').clone().appendTo('#service_item_table').removeAttr('id').addClass('item').attr('id', 'tr_' + add_mathround).show();

				$('#tr_' + add_mathround + ' .item_sno').attr('id', "item_sno_" + add_mathround);
				$('#tr_' + add_mathround + ' .item_sno').empty().html(next_row_id);
				$('#tr_' + add_mathround + ' .item_service_id').attr('id', "item_service_id_" + add_mathround);
				$('#tr_' + add_mathround + ' .item_service_name').attr('id', "item_service_name_" + add_mathround);
				// $('#tr_' + add_mathround + ' .gst_service').attr('id', "gst_service_" + add_mathround);
				
				$('#tr_' + add_mathround + ' .item_hsn').attr('id', "item_hsn_" + add_mathround);
				$('#tr_' + add_mathround + ' .igst_pct').attr('id', "igst_pct_" + add_mathround);
				$('#tr_' + add_mathround + ' .item_discount').attr('id', "item_discount_" + add_mathround);
				$('#tr_' + add_mathround + ' .usr_lbr_price').attr('id', "usr_lbr_price_" + add_mathround);
				$('#tr_' + add_mathround + ' .service_id').attr('id', "service_id_" + add_mathround);
				$('#tr_' + add_mathround + ' .kilo_from').attr('id', "kilo_from_" + add_mathround);
				$('#tr_' + add_mathround + ' .kilo_to').attr('id', "kilo_to_" + add_mathround);
				$('#tr_' + add_mathround + ' .mon_from').attr('id', "mon_from_" + add_mathround);
				$('#tr_' + add_mathround + ' .mon_to').attr('id', "mon_to_" + add_mathround);
				$('#tr_' + add_mathround + ' .remove_added_item').attr('id', "remove_added_item" + add_mathround);

				$("#item_service_id_"+add_mathround).val(service_id);
				$("#item_service_name_"+add_mathround).val(servicename);

				if (service_id > 0 ) {
					getServiceDetails(parseInt(service_id), service_row_id);
				} else {
					emptyallfield(service_row_id);
				}

				$("#services_add_service").val(servicelist[i].service_item).trigger("change");

				var mech_price = (servicelist[i].mech_item_price?parseFloat(servicelist[i].mech_item_price):0);
				var user_price = (servicelist[i].user_item_price?parseFloat(servicelist[i].user_item_price):0);
				var igst_percentage = (servicelist[i].igst_pct?parseFloat(servicelist[i].igst_pct):0);
				// var gst_service_id = (servicelist[i].tax_id?parseFloat(servicelist[i].tax_id):0);
				var last_item_row = $('#service_item_table tbody>#tr_'+add_mathround);

				last_item_row.find('input[name=usr_lbr_price]').attr('onblur', 'service_calculation("'+add_mathround+'")');
				last_item_row.find('input[name=mech_lbr_price]').val(mech_price.toFixed(2));
				last_item_row.find('input[name=usr_lbr_price]').val(format_money(parseFloat(user_price).toFixed(2),default_currency_digit));
				// last_item_row.find('select[name=gst_service]').attr('onchange', 'changeServicetaxValue("'+add_mathround+'")');
				last_item_row.find('input[name=item_discount]').attr('onblur', 'service_calculation("' + add_mathround + '")');
				last_item_row.find('input[name=igst_pct]').attr('onkeyup', 'service_calculation("' + add_mathround + '")');
				last_item_row.find('input[name=igst_pct]').attr('onblur', 'service_calculation("' + add_mathround + '")');
				last_item_row.find('input[name=item_hsn]').val((servicelist[i].sku?servicelist[i].sku:""));
				last_item_row.find('input[name=igst_pct]').val((igst_percentage?igst_percentage:""));
				last_item_row.find('input[name=kilo_from]').val((servicelist[i].kilo_from?servicelist[i].kilo_from:""));
				last_item_row.find('input[name=kilo_to]').val((servicelist[i].kilo_to?servicelist[i].kilo_to:""));
				last_item_row.find('input[name=mon_from]').val((servicelist[i].mon_from?servicelist[i].mon_from:""));
				last_item_row.find('input[name=mon_to]').val((servicelist[i].mon_to?servicelist[i].mon_from:""));
				last_item_row.find('.remove_added_item').attr('onclick', 'remove_service("'+productList[i].service_item+'","' + add_mathround + '")');
				// $().ready(function () {
				// 	$("#gst_service_" + add_mathround).select2().on("change", function (e) {
				// 	});
				// 	$("#gst_service_" + add_mathround).val(gst_service_id).trigger('change');
				// });
				service_calculation(add_mathround);
				$("#services_add_service").val(0);
				$('#services_add_service').selectpicker("refresh");
			}
		}
	}else{

		var add_mathround = parseInt(new Date().getTime() + Math.random());
		var next_row_id = $("#service_item_table > tbody > tr").length;

		$('#new_service_row').clone().appendTo('#service_item_table').removeAttr('id').addClass('item').attr('id', 'tr_' + add_mathround).show();

		$('#tr_' + add_mathround + ' .item_sno').attr('id', "item_sno_" + add_mathround);
		$('#tr_' + add_mathround + ' .item_sno').empty().html(next_row_id);
		$('#tr_' + add_mathround + ' .item_service_id').attr('id', "item_service_id_" + add_mathround);
		$('#tr_' + add_mathround + ' .employee_id').attr('id', "employee_id_" + add_mathround);
		$('#tr_' + add_mathround + ' .item_service_name').attr('id', "item_service_name_" + add_mathround);
		// $('#tr_' + add_mathround + ' .gst_service').attr('id', "gst_service_" + add_mathround);
		$('#tr_' + add_mathround + ' .igst_pct').attr('id', "igst_pct_" + add_mathround);
		$('#tr_' + add_mathround + ' .usr_lbr_price').attr('id', "usr_lbr_price_" + add_mathround);
		$('#tr_' + add_mathround + ' .service_id').attr('id', "service_id_" + add_mathround);
		$('#tr_' + add_mathround + ' .item_discount').attr('id', "item_discount_" + add_mathround);
		$('#tr_' + add_mathround + ' .item_hsn').attr('id', "item_hsn_" + add_mathround);
		$('#tr_' + add_mathround + ' .kilo_from').attr('id', "kilo_from_" + add_mathround);
		$('#tr_' + add_mathround + ' .kilo_to').attr('id', "kilo_to_" + add_mathround);
		$('#tr_' + add_mathround + ' .mon_from').attr('id', "mon_from_" + add_mathround);
		$('#tr_' + add_mathround + ' .mon_to').attr('id', "mon_to_" + add_mathround);
		$('#tr_' + add_mathround + ' .remove_added_item').attr('id', "remove_added_item" + add_mathround);
		$("#item_service_id_"+add_mathround).val(service_id);
		$("#item_service_name_"+add_mathround).val(servicename);

		$().ready(function () {
			$("#employee_id_" + add_mathround).select2().on("change", function (e) {
			});
		});

		if (parseInt(service_id) > 0 ) {
			getServiceDetails(parseInt(service_id), add_mathround);
			$("#services_add_service").val(0);
			$('#services_add_service').selectpicker("refresh");
		} else {
			emptyallfield(add_mathround);
		}
	}
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


function product_row_data(productList){

	var product_id = parseInt($("#services_item_product_id").val());
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
	
	var productname = $("#services_item_product_id option:selected").text();

	if(productList != '' && productList != undefined){

		if(productList.length > 0){

			$('#product_item_table tbody tr.item').remove();

			for(var i = 0; i < productList.length; i++){

				var mech_price = '';
				var user_price = '';
				var igst_percentage = '';
				var igst_amount = '';
				var add_mathround = parseInt(new Date().getTime() + Math.random());
				var next_row_id = $("#product_item_table > tbody > tr").length;

				$('#new_product_row').clone().appendTo('#product_item_table').removeAttr('id').addClass('item').attr('id', 'tr_' + add_mathround).show();

				$('#tr_' + add_mathround + ' .item_sno').attr('id', "item_sno_" + add_mathround);
				$('#tr_' + add_mathround + ' .item_sno').empty().html(next_row_id);
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
				$('#tr_' + add_mathround + ' .remove_added_item').attr('id', "remove_added_item" + add_mathround);


				$("#item_product_id_"+add_mathround).val(product_id);
				$("#item_product_name_"+add_mathround).val(productname);

				var product_id = parseInt($("#services_item_product_id").val());
				if (product_id != '' && product_id > 0) {
					$('.error_msg_product_item').empty().append('');
					getProductDetails(product_id, add_mathround , productattrid);
				} else {
					emptyallfield(add_mathround);
				}

				$("#services_item_product_id").val(productList[i].service_item).trigger("change");
				var mech_price = (productList[i].mech_item_price?parseFloat(productList[i].mech_item_price):0);
				var user_price = (productList[i].user_item_price?parseFloat(productList[i].user_item_price):0);
				var igst_percentage = (productList[i].igst_pct?parseFloat(productList[i].igst_pct):0);
				var igst_amount = (productList[i].igst_amount?parseFloat(productList[i].igst_amount):0);
				var kilo_from = productList[i].kilo_from?productList[i].kilo_from:'';;
				var kilo_to = productList[i].kilo_to?productList[i].kilo_to:'';
				var mon_from = productList[i].mon_from?productList[i].mon_from:'';
				var mon_to = productList[i].mon_to?productList[i].mon_to:'';
				var item_qty = productList[i].item_qty?productList[i].item_qty:1;
				var item_discount = (productList[i].item_discount?parseFloat(productList[i].item_discount):0);
				// var gst_spare_id = (productList[i].tax_id?productList[i].tax_id:'');

				var last_item_row = $('#product_item_table tbody>#tr_'+ add_mathround);
				// last_item_row.find('select[name=gst_spare]').attr('onchange', 'changeSparetaxValue("' + add_mathround + '")');
				last_item_row.find('input[name=usr_lbr_price]').attr('onblur', 'product_calculation("' + add_mathround + '")');
				last_item_row.find('input[name=item_discount]').attr('onblur', 'product_calculation("' + add_mathround + '")');
				last_item_row.find('input[name=product_qty]').attr('onkeyup', 'product_calculation("' + add_mathround + '")');
				last_item_row.find('input[name=igst_pct]').attr('onkeyup', 'product_calculation("' + add_mathround + '")');
				last_item_row.find('input[name=product_qty]').val(item_qty);
				last_item_row.find('input[name=mech_lbr_price]').val(mech_price.toFixed(2));
				last_item_row.find('input[name=usr_lbr_price]').val(format_money(parseFloat(user_price).toFixed(2),default_currency_digit));
				last_item_row.find('input[name=igst_pct]').val(igst_percentage);
				last_item_row.find('input[name=igst_amount]').val(format_money(parseFloat(igst_amount).toFixed(2),default_currency_digit));
				last_item_row.find('input[name=kilo_from]').val(kilo_from);
				last_item_row.find('input[name=kilo_to]').val(kilo_to);
				last_item_row.find('input[name=mon_from]').val(mon_from);
				last_item_row.find('input[name=mon_to]').val(mon_to);
				// if(gst_spare_id != '' && parseInt(gst_spare_id) > 0){
				// 	last_item_row.find('select[name=gst_spare]').val(gst_spare_id);
				// }
				last_item_row.find('.remove_added_item').attr('onclick', 'remove_product("'+productList[i].service_item+'","' + add_mathround + '")');
				// $().ready(function () {
				// 	$("#gst_spare_" + add_mathround).select2().on("change", function (e) {
				// 	});
				// 	$("#gst_spare_" + add_mathround).val(gst_spare_id).trigger('change');
				// });
				product_calculation(add_mathround);

				$("#services_item_product_id").val(0);
				$('#services_item_product_id').selectpicker("refresh");
			}
		}
	}else{
		var add_mathround = parseInt(new Date().getTime() + Math.random());
		var next_row_id = $("#product_item_table > tbody > tr").length;
		$('#new_product_row').clone().appendTo('#product_item_table').removeAttr('id').addClass('item').attr('id', 'tr_' + add_mathround).show();
		$('#tr_' + add_mathround + ' .item_sno').attr('id', "item_sno_" + add_mathround);
		$('#tr_' + add_mathround + ' .item_sno').empty().html(next_row_id);
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

		$("#item_product_id_"+add_mathround).val(product_id);
		$("#item_product_name_"+add_mathround).val(productname);

		var product_id = parseInt($("#services_item_product_id").val());
		if (product_id != '' && product_id > 0) {
			$('.error_msg_product_item').empty().append('');
			getProductDetails(product_id, add_mathround);
			$("#services_item_product_id").val(0);
			$('#services_item_product_id').selectpicker("refresh");
		} else {
			emptyallfield(add_mathround);
		}
	}
}

function getServiceDetails(service_id, service_row_id) {
	$.post(getServiceDetailsURL, {
		user_car_list_id: $('#customer_car_id').val(),
		service_id: service_id,
		_mm_csrf: $('#_mm_csrf').val(),
	}, function (data) {
		service_items = JSON.parse(data);
		if (service_items) {
			if (service_items.success == '1' || service_items.success == 1) {
				var ser_arr = service_items.services;
				var mech_price = (ser_arr.default_cost?parseFloat(ser_arr.default_cost):0);
				var user_price = (ser_arr.estimated_cost?parseFloat(ser_arr.estimated_cost):0);
				var kilo_from = (ser_arr.kilo_from?parseFloat(ser_arr.kilo_from):0);
				var kilo_to = (ser_arr.kilo_to?parseFloat(ser_arr.kilo_to):0);
				var mon_from = (ser_arr.mon_from?parseFloat(ser_arr.mon_from):0);
				var mon_to = (ser_arr.mon_to?parseFloat(ser_arr.mon_to):0);
				var item_hsn =  (ser_arr.sku?ser_arr.sku:"");
				// var gst_service_id = (ser_arr.tax_id?ser_arr.tax_id:"");
			}
			if (service_items.success == '0') {
				var mech_price = 0;
				var user_price = 0;
				var kilo_from = 0;
				var kilo_to = 0;
				var mon_from = 0;
				var mon_to = 0;
				var item_hsn =  '';
				// var gst_service_id = '';
			}

			var last_item_row = $('#service_item_table tbody>#tr_' + service_row_id);
			last_item_row.find('input[name=usr_lbr_price]').attr('onblur', 'service_calculation("' + service_row_id + '")');
			last_item_row.find('input[name=item_discount]').attr('onblur', 'service_calculation("'+service_row_id+'")');
			last_item_row.find('input[name=igst_pct]').attr('onkeyup', 'product_calculation("' + add_mathround + '")');
			last_item_row.find('input[name=igst_pct]').attr('onblur', 'product_calculation("' + add_mathround + '")');
			// last_item_row.find('select[name=gst_service]').attr('onchange', 'changeServicetaxValue("'+service_row_id+'")');
			last_item_row.find('input[name=mech_lbr_price]').val(mech_price.toFixed(2));
			last_item_row.find('input[name=usr_lbr_price]').val(format_money(parseFloat(user_price).toFixed(2),default_currency_digit));
			// if(gst_service_id != '' && parseInt(gst_service_id) > 0){
			// 	last_item_row.find('select[name=gst_service]').val(gst_service_id);
			// }
			last_item_row.find('input[name=item_hsn]').val(item_hsn);
			last_item_row.find('input[name=kilo_from]').val(kilo_from);
			last_item_row.find('input[name=kilo_to]').val(kilo_to);
			last_item_row.find('input[name=mon_from]').val(mon_from);
			last_item_row.find('input[name=mon_to]').val(mon_to);
			last_item_row.find('.remove_added_item').attr('onclick', 'remove_service("'+service_id+'","' + service_row_id + '")');
			// $().ready(function () {
			// 	$("#gst_service_" + service_row_id).select2().on("change", function (e) {
			// 	});
			// 	$("#gst_service_" + service_row_id).val(gst_service_id).trigger('change');
			// });
			service_calculation(service_row_id);
		}
	});
}

function getProductDetails(product_id, product_row_id) {

	$.post(getProductDetailsURL, {
		product_id: product_id,
		customer_car_id: $('#customer_car_id').val(),
		_mm_csrf: $('#_mm_csrf').val(),
	}, function (data) {
		product_items = JSON.parse(data);
		if (product_items) {
			
			var last_item_row = $('#product_item_table tbody>#tr_' + product_row_id);

			if(product_items.success == '1'){
				var ser_arr = product_items.products;
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
				// var gst_spare_id = (ser_arr.tax_id?ser_arr.tax_id:'');
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
				// var gst_spare_id = '';
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
			// last_item_row.find('select[name=gst_spare]').attr('onchange', 'changeSparetaxValue("' + product_row_id + '")');
			last_item_row.find('input[name=item_discount]').attr('onblur', 'product_calculation("' + product_row_id + '")');
			last_item_row.find('input[name=product_qty]').attr('onkeyup', 'product_calculation("' + product_row_id + '")');
			last_item_row.find('input[name=igst_pct]').attr('onkeyup', 'product_calculation("' + product_row_id + '")');
			// if(gst_spare_id != '' && parseInt(gst_spare_id) > 0){
			// 	last_item_row.find('select[name=gst_spare]').val(gst_spare_id);
			// }
			last_item_row.find('input[name=item_hsn]').val(hsn_code);
			last_item_row.find('input[name=product_qty]').val(1);
			last_item_row.find('input[name=mech_lbr_price]').val(mech_price.toFixed(2));
			last_item_row.find('input[name=usr_lbr_price]').val(format_money(parseFloat(user_price).toFixed(2),default_currency_digit));
			last_item_row.find('input[name=igst_pct]').val(igst_percentage);
			last_item_row.find('input[name=igst_amount]').val(format_money(parseFloat(igst_amount).toFixed(2),default_currency_digit));
			last_item_row.find('input[name=kilo_from]').val(kilo_from);
			last_item_row.find('input[name=kilo_to]').val(kilo_to);
			last_item_row.find('input[name=mon_from]').val(mon_from);
			last_item_row.find('input[name=mon_to]').val(mon_to);
			last_item_row.find('.remove_added_item').attr('onclick', 'remove_product("'+product_id+'","' + product_row_id + '")');
			// $().ready(function () {
			// 	$("#gst_spare_" + product_row_id).select2().on("change", function (e) {
			// 	});
			// 	$("#gst_spare_" + product_row_id).val(gst_spare_id).trigger('change');
			// });
			product_calculation(product_row_id);
		}
	});
}


function remove_service(service_id, service_row_id){
	for( var i = 0; i < existing_service.length; i++){ 
		if ( existing_service[i] == service_id) {
			existing_service.splice(i, 1); 
		}
	}
	$("#service_item_table #tr_"+service_row_id).remove();
	service_calculation(service_row_id);
}

function remove_package(package_id, package_row_id){
	for( var i = 0; i < existing_service_package.length; i++){ 
		if ( existing_service_package[i] == package_id) {
			existing_service_package.splice(i, 1); 
		}
	}
	$("#service_package_item_table #tr_"+package_row_id).remove();
	service_package_calculation(package_row_id);
}

function remove_product(product_id, product_row_id){
	for( var i = 0; i < existing_product.length; i++){ 
		if ( existing_product[i] == product_id) {
			existing_product.splice(i, 1); 
		}
	}
	$("#product_item_table #tr_"+product_row_id).remove();
	product_calculation(product_row_id);
}

function service_calculation(id) {
	if (id) {
		var tr_id = "tr_" + id;

		var usr_lbr_price = ($("#" + tr_id + " input[name=usr_lbr_price]").val()) ? parseFloat(($("#" + tr_id + " input[name=usr_lbr_price]").val()).replace(/,/g, '')) : 0;
		$("#" + tr_id + " input[name=usr_lbr_price]").val(format_money((parseFloat(usr_lbr_price).toFixed(2)),default_currency_digit));
		
		var item_discount = ($("#" + tr_id + " input[name=item_discount]").val()) ? parseFloat(($("#" + tr_id + " input[name=item_discount]").val()).replace(/,/g, '')) : 0;
		$("#" + tr_id + " input[name=item_discount]").val(format_money((parseFloat(item_discount).toFixed(2)),default_currency_digit));

		var service_discountstate = $("#service_discountstate").val();

		if(service_discountstate == 1){
			var total_taxable_amount = parseFloat(usr_lbr_price) - parseFloat(item_discount);
			var discount_amount = item_discount;
		}else{
			if(parseInt(item_discount) > 100 || parseInt(item_discount) < 0){
				item_discount = 0;
				$("#" + tr_id + " input[name=item_discount]").val(format_money((parseFloat(item_discount).toFixed(2)),default_currency_digit));
			}
			var discount_amount = (usr_lbr_price * parseFloat(item_discount) / 100);
			var total_taxable_amount = parseFloat(usr_lbr_price) - parseFloat(discount_amount);
		}

		$("#" + tr_id + " input[name=item_discount_price]").val((parseFloat(discount_amount)).toFixed(2));
		$("#" + tr_id + " input[name=item_amount]").val(total_taxable_amount.toFixed(2));
		$("#" + tr_id + " .item_amount_label").empty().html(format_money(parseFloat(total_taxable_amount).toFixed(2),default_currency_digit));	

		var igst_pct = ($("#" + tr_id + " input[name=igst_pct]").val()) ? $("#" + tr_id + " input[name=igst_pct]").val() : 0;
		var igst_amount = (igst_pct) ? ((parseFloat(total_taxable_amount) * igst_pct) / 100) : 0;

		$("#" + tr_id + " input[name=igst_amount]").val(igst_amount.toFixed(2));
		$("#" + tr_id + " .igst_amount_label").empty().html(format_money(parseFloat(igst_amount).toFixed(2),default_currency_digit)+'('+igst_pct+'%)');

		var item_total_amount = (parseFloat(total_taxable_amount) + parseFloat(igst_amount));

		$("#" + tr_id + " input[name=item_total_amount]").val(item_total_amount.toFixed(2));
		$("#" + tr_id + " .item_total_amount_label").empty().html(format_money(parseFloat(item_total_amount).toFixed(2),default_currency_digit));
	}
	service_group_tax_calculation();
}


function service_package_calculation(id){
	if (id) {
		var tr_id = "tr_" + id;

		var usr_lbr_price = ($("#" + tr_id + " input[name=usr_lbr_price]").val()) ? parseFloat(($("#" + tr_id + " input[name=usr_lbr_price]").val()).replace(/,/g, '')) : 0;
		$("#" + tr_id + " input[name=usr_lbr_price]").val(format_money((parseFloat(usr_lbr_price).toFixed(2)),default_currency_digit));
		
		var item_discount = 0;
		var igst_pct = ($("#" + tr_id + " input[name=igst_pct]").val()) ? $("#" + tr_id + " input[name=igst_pct]").val() : 0;
		var igst_amount = (igst_pct) ? parseFloat(((parseFloat(usr_lbr_price) * igst_pct) - item_discount) / 100) : 0;

		$("#" + tr_id + " input[name=igst_amount]").val(igst_amount.toFixed(2));
		$("#" + tr_id + " .igst_amount_label").empty().html(format_money(parseFloat(igst_amount).toFixed(2),default_currency_digit));

		var item_total_amount = (parseFloat(usr_lbr_price) + parseFloat(igst_amount)) - parseFloat(item_discount);

		$("#" + tr_id + " input[name=item_total_amount]").val(item_total_amount.toFixed(2));
		$("#" + tr_id + " .item_total_amount_label").empty().html(format_money(parseFloat(item_total_amount).toFixed(2),default_currency_digit));
	}
	service_package_group_tax_calculation();
}

function service_group_tax_calculation() {

	var total_mech_lbr_price = group_by_textbox_name_value('service', 'mech_lbr_price');
	var total_usr_lbr_price = group_by_textbox_name_value('service', 'usr_lbr_price');
	var total_item_amount = group_by_textbox_name_value('service', 'item_amount');
	var total_item_discount = group_by_textbox_name_value('service', 'item_discount_price');
	var total_igst_amount = group_by_textbox_name_value('service', 'igst_amount');
	var total_item_total_amount = group_by_textbox_name_value('service', 'item_total_amount');

	$("#service_item_table input[name=total_mech_lbr_price]").val(total_mech_lbr_price.toFixed(2));
	$("#service_item_table input[name=total_usr_lbr_price]").val(total_usr_lbr_price.toFixed(2));
	$("#service_item_table input[name=total_item_discount").val(total_item_discount.toFixed(2));
	$("#service_item_table input[name=total_item_amount]").val(total_item_amount.toFixed(2));
	$("#service_item_table input[name=total_igst_amount]").val(total_igst_amount.toFixed(2));
	$("#service_item_table input[name=total_item_total_amount]").val(total_item_total_amount.toFixed(2));

	
	$("#service_item_table .total_usr_lbr_price_label").empty().html(currency_symbol+format_money(parseFloat(total_usr_lbr_price),default_currency_digit.toFixed(2)));
	$("#service_item_table .total_item_amount_label").empty().html(currency_symbol+format_money(parseFloat(total_item_amount),default_currency_digit.toFixed(2)));
	$("#service_item_table .total_item_discount_label").empty().html(currency_symbol+format_money(parseFloat(total_item_discount),default_currency_digit.toFixed(2)));
	$("#service_item_table .total_igst_amount_label").empty().html(currency_symbol+format_money(parseFloat(total_igst_amount),default_currency_digit.toFixed(2)));
	$("#service_item_table .total_item_total_amount_label").empty().html(currency_symbol+format_money(parseFloat(total_item_total_amount),default_currency_digit.toFixed(2)));

	overall_invoice_calc();

}

function service_package_group_tax_calculation(){
	var total_mech_lbr_price = group_by_textbox_name_value('service_package', 'mech_lbr_price');
	var total_usr_lbr_price = group_by_textbox_name_value('service_package', 'usr_lbr_price');
	var total_item_discount = group_by_textbox_name_value('service_package', 'item_discount');
	var total_igst_amount = group_by_textbox_name_value('service_package', 'igst_amount');
	var total_item_total_amount = group_by_textbox_name_value('service_package', 'item_total_amount');
	
	$("#service_package_item_table input[name=total_mech_lbr_price]").val(total_mech_lbr_price.toFixed(2));
	$("#service_package_item_table input[name=total_usr_lbr_price]").val(total_usr_lbr_price.toFixed(2));
	$("#service_package_item_table input[name=total_item_discount").val(total_item_discount.toFixed(2));
	$("#service_package_item_table input[name=total_igst_amount]").val(total_igst_amount.toFixed(2));
	$("#service_package_item_table input[name=total_item_total_amount]").val(total_item_total_amount.toFixed(2));

	$("#service_package_item_table .total_item_discount_label").empty().html(format_money(parseFloat(total_item_discount),default_currency_digit.toFixed(2)));
	$("#service_package_item_table .total_igst_amount_label").empty().html(format_money(parseFloat(total_igst_amount),default_currency_digit.toFixed(2)));
	$("#service_package_item_table .total_item_total_amount_label").empty().html(currency_symbol+format_money(parseFloat(total_item_total_amount),default_currency_digit.toFixed(2)));

	overall_invoice_calc();
}

function product_calculation(id) {
	if (id) {

		var tr_id = "tr_" + id;
		var mech_lbr_price = ($("#" + tr_id + " input[name=mech_lbr_price]").val()) ? parseFloat(($("#" + tr_id + " input[name=mech_lbr_price]").val()).replace(/,/g, '')) : 0;
		var usr_lbr_price = ($("#" + tr_id + " input[name=usr_lbr_price]").val()) ? parseFloat(($("#" + tr_id + " input[name=usr_lbr_price]").val()).replace(/,/g, '')) : 0;
		$("#" + tr_id + " input[name=usr_lbr_price]").val(format_money((parseFloat(usr_lbr_price).toFixed(2)),default_currency_digit));
		
		var product_qty = ($("#" + tr_id + " input[name=product_qty]").val()) ? parseFloat($("#" + tr_id + " input[name=product_qty]").val()) : 1;
		
		var item_discount = ($("#" + tr_id + " input[name=item_discount]").val()) ? parseFloat(($("#" + tr_id + " input[name=item_discount]").val()).replace(/,/g, '')) : 0;
		$("#" + tr_id + " input[name=item_discount]").val(format_money((parseFloat(item_discount).toFixed(2)),default_currency_digit));
		
		var total_amount = parseFloat(usr_lbr_price) * product_qty;
		var parts_discountstate = $("#parts_discountstate").val();

		if(parts_discountstate == 1){
			var total_taxable_amount = total_amount - (product_qty * parseFloat(item_discount));
			var discount_amount = (product_qty * parseFloat(item_discount));
		}else{
			if(parseInt(item_discount) > 100 || parseInt(item_discount) < 0){
				item_discount = 0;
				$("#" + tr_id + " input[name=item_discount]").val(format_money((parseFloat(item_discount).toFixed(2)),default_currency_digit));
			}
			var discount_amount = (total_amount * parseFloat(item_discount) / 100);
			var total_taxable_amount = total_amount - discount_amount;
		}

		$("#" + tr_id + " input[name=item_amount]").val(total_taxable_amount.toFixed(2));
		$("#" + tr_id + " .item_amount_label").empty().html(format_money(parseFloat(total_taxable_amount).toFixed(2),default_currency_digit));

		var igst_pct = ($("#" + tr_id + " input[name=igst_pct]").val()) ? parseFloat($("#" + tr_id + " input[name=igst_pct]").val()) : 0;

		if(parseInt(igst_pct) > 100 || parseInt(igst_pct) < 0){
			igst_pct = 0;
			$("#" + tr_id + " input[name=igst_pct]").val(0);
		}
		
		var igst_amount = (igst_pct) ? parseFloat(((total_taxable_amount * igst_pct)) / 100) : 0;

		$("#" + tr_id + " input[name=igst_amount]").val(parseFloat(igst_amount).toFixed(2));
		$("#" + tr_id + " input[name=usr_lbr_price]").val(format_money(parseFloat(usr_lbr_price).toFixed(2),default_currency_digit));
		$("#" + tr_id + " input[name=total_amount]").val(total_amount.toFixed(2));
		$("#" + tr_id + " input[name=total_mech_amount]").val((parseFloat(mech_lbr_price) * product_qty).toFixed(2));
		$("#" + tr_id + " input[name=item_discount]").val(format_money(parseFloat(item_discount).toFixed(2),default_currency_digit));
		$("#" + tr_id + " input[name=item_discount_price]").val(parseFloat(discount_amount).toFixed(2));
		$("#" + tr_id + " .igst_amount_label").empty().html(format_money(parseFloat(igst_amount).toFixed(2),default_currency_digit)+' ('+igst_pct+'%)');

		var item_total_amount = (parseFloat(total_taxable_amount) + parseFloat(igst_amount));

		$("#" + tr_id + " input[name=item_total_amount]").val(item_total_amount.toFixed(2));
		$("#" + tr_id + " .item_total_amount_label").empty().html(format_money(parseFloat(item_total_amount).toFixed(2),default_currency_digit));
	}
	product_group_tax_calculation();

}

function product_group_tax_calculation() {

	var total_mech_lbr_price = group_by_textbox_name_value('product', 'mech_lbr_price');
	var total_usr_lbr_price = group_by_textbox_name_value('product', 'total_amount');
	var total_product_qty = group_by_textbox_name_value('product', 'product_qty');
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
	$("#product_item_table .total_product_qty").empty().html(total_product_qty);
	$("#product_item_table .total_item_amount_lable").empty().html(currency_symbol+format_money(parseFloat(total_item_amount).toFixed(2),default_currency_digit));
	$("#product_item_table .total_igst_amount_label").empty().html(currency_symbol+parseFloat(total_igst_amount).toFixed(2));
	$("#product_item_table .total_item_total_amount_label").empty().html(currency_symbol+format_money(parseFloat(total_item_total_amount).toFixed(2),default_currency_digit));
	overall_invoice_calc();
}

function overall_invoice_calc() {

	var grand_total = 0;

	var total_product_mech_lab_amount = $("#product_item_table input[name=total_mech_lbr_price]").val()?$("#product_item_table input[name=total_mech_lbr_price]").val().replace(/,/g, ''):0;
	var total_service_mech_lab_amount = $("#service_item_table input[name=total_mech_lbr_price]").val()?$("#service_item_table input[name=total_mech_lbr_price]").val().replace(/,/g, ''):0;
	var total_service_package_mech_lab_amount = $("#service_package_item_table input[name=total_mech_lbr_price]").val()?$("#service_package_item_table input[name=total_mech_lbr_price]").val().replace(/,/g, ''):0;

	var total_product_usr_lab_amount = $("#product_item_table input[name=total_usr_lbr_price]").val()?$("#product_item_table input[name=total_usr_lbr_price]").val().replace(/,/g, ''):0;
	var total_service_usr_lab_amount = $("#service_item_table input[name=total_usr_lbr_price]").val()?$("#service_item_table input[name=total_usr_lbr_price]").val().replace(/,/g, ''):0;
	var total_service_package_usr_lab_amount = $("#service_package_item_table input[name=total_usr_lbr_price]").val()?$("#service_package_item_table input[name=total_usr_lbr_price]").val().replace(/,/g, ''):0;
	
	var total_product_discount_amount = $("#product_item_table input[name=total_item_discount").val()?$("#product_item_table input[name=total_item_discount").val().replace(/,/g, ''):0;
	var total_service_discount_amount = $("#service_item_table input[name=total_item_discount").val()?$("#service_item_table input[name=total_item_discount").val().replace(/,/g, ''):0;
	var total_service_package_discount_amount = $("input[name=service_package_discount").val()?$("input[name=service_package_discount").val().replace(/,/g, ''):0;

	$("input[name=service_package_discount").val(format_money(parseFloat(total_service_package_discount_amount).toFixed(2),default_currency_digit));
	total_service_package_discount_amount = (total_service_package_discount_amount == '') ? 0 : parseFloat(total_service_package_discount_amount);

	var total_product_igst_amount = $("#product_item_table input[name=total_igst_amount]").val()?$("#product_item_table input[name=total_igst_amount]").val().replace(/,/g, ''):0;
	var total_service_igst_amount = $("#service_item_table input[name=total_igst_amount]").val()?$("#service_item_table input[name=total_igst_amount]").val().replace(/,/g, ''):0;
	var total_service_package_igst_amount = $("#service_package_item_table input[name=total_igst_amount]").val()?$("#service_package_item_table input[name=total_igst_amount]").val().replace(/,/g, ''):0;
	
	var total_product_amount = $("#product_item_table input[name=total_item_total_amount]").val()?$("#product_item_table input[name=total_item_total_amount]").val().replace(/,/g, ''):0;
	var total_service_amount = $("#service_item_table input[name=total_item_total_amount]").val()?$("#service_item_table input[name=total_item_total_amount]").val().replace(/,/g, ''):0;

	var total_service_package_amount = $("#service_package_item_table input[name=total_item_total_amount]").val()?$("#service_package_item_table input[name=total_item_total_amount]").val().replace(/,/g, ''):0;

	
	var service_package_total_taxable = (parseFloat(total_service_package_usr_lab_amount));

	var service_package_gst_pct = ($('#total_service_package_tax').val() == '') ? 0 : $('#total_service_package_tax').val();
	var service_package_gst_amount = (service_package_gst_pct) ? parseFloat((service_package_total_taxable * service_package_gst_pct) / 100) : 0;
	var total_servie_package_invoice = service_package_total_taxable + service_package_gst_amount;

	var product_total_taxable = parseFloat(total_product_usr_lab_amount) - parseFloat(total_product_discount_amount);
	var service_total_taxable = parseFloat(total_service_usr_lab_amount) - parseFloat(total_service_discount_amount);

	var product_gst_price = parseFloat(total_product_igst_amount);
	var total_product_invoice = product_total_taxable + product_gst_price;
	var service_gst_price = parseFloat(total_service_igst_amount);
	var total_service_invoice = service_total_taxable + service_gst_price;

	var total_taxable_amount = service_total_taxable + service_package_total_taxable + product_total_taxable;
	grand_total = parseFloat(total_service_invoice) + parseFloat(total_servie_package_invoice) + parseFloat(total_product_invoice);
	
	// service totals
	$(".total_user_service_price").empty().html(format_money(parseFloat(total_service_usr_lab_amount).toFixed(2),default_currency_digit));
	$(".service_total_discount").empty().html(format_money(parseFloat(total_service_discount_amount).toFixed(2),default_currency_digit));
	$(".total_user_service_taxable").empty().html(format_money(parseFloat(service_total_taxable).toFixed(2),default_currency_digit));
	$(".total_servie_gst_price").empty().html(format_money(parseFloat(service_gst_price).toFixed(2),default_currency_digit));
	$('.total_servie_invoice').empty().html(format_money(parseFloat(total_service_amount).toFixed(2),default_currency_digit));


	// service package total
	$(".total_user_service_package_price").empty().html(format_money(parseFloat(total_service_package_usr_lab_amount).toFixed(2),default_currency_digit));
	$(".total_user_service_package_taxable").empty().html(format_money(parseFloat(service_package_total_taxable).toFixed(2),default_currency_digit));
	$(".total_servie_package_gst_price").empty().html(format_money(parseFloat(service_package_gst_amount).toFixed(2),default_currency_digit));
	$('.total_servie_package_invoice').empty().html(format_money(parseFloat(total_servie_package_invoice).toFixed(2),default_currency_digit));

	// product total
	$(".total_user_product_price").empty().html(format_money(parseFloat(total_product_usr_lab_amount).toFixed(2),default_currency_digit));
	$(".product_total_discount").empty().html(format_money(parseFloat(total_product_discount_amount).toFixed(2),default_currency_digit));
	$(".total_user_product_taxable").empty().html(format_money(parseFloat(product_total_taxable).toFixed(2),default_currency_digit));
	$(".total_user_product_gst").empty().html(format_money(parseFloat(product_gst_price).toFixed(2),default_currency_digit));
	$(".total_product_invoice").empty().html(format_money(parseFloat(total_product_amount).toFixed(2),default_currency_digit));
	
	//all total 
	$(".total_taxable_amount").empty().html(format_money(parseFloat(total_taxable_amount).toFixed(2),default_currency_digit));

	var overall_discount_amount = parseFloat(total_service_discount_amount) + parseFloat(total_product_discount_amount);
	$(".overall_discount_amount").empty().html(format_money(parseFloat(overall_discount_amount).toFixed(2),default_currency_digit));

	$(".total_gst_amount").empty().html(format_money(parseFloat(service_gst_price + service_package_gst_amount + product_gst_price).toFixed(2),default_currency_digit));

	$(".grand_total").empty().html(format_money(parseFloat(grand_total.toFixed(2),default_currency_digit)));
	
	
	$("#advance_paid_amount").val(advance_paid_amount);
	$(".advance_amount_label").empty().html(format_money(parseFloat(advance_paid_amount,default_currency_digit)));

	$("#total_due_amount").val(grand_total - advance_paid_amount);
	$(".total_due_amount_lable").empty().html(format_money(parseFloat((grand_total - advance_paid_amount).toFixed(2),default_currency_digit)));


	var renum = 1;
	$("#product_item_table tr td.item_sno").each(function() {
		$(this).text(renum);
    	renum++;
	});

	var renum = 1;
	$("#service_item_table tr td.item_sno").each(function() {
		$(this).text(renum);
    	renum++;
	});

	var renumpac = 1;
	$("#service_package_item_table tr td.item_sno").each(function() {
		$(this).text(renumpac);
    	renumpac++;
	});

	$('.addproduct').attr('data-existing_product_ids', '');
	var existing_product_ids = existing_product.toString();
	$("#existing_product_ids").val(existing_product_ids);
	$('.addproduct').attr('data-existing_product_ids', existing_product_ids);

	$('.addservice').attr('data-existing_service_ids', '');
	var existing_service_ids = existing_service.toString();
	$("#existing_service_ids").val(existing_service_ids);
	$('.addservice').attr('data-existing_service_ids', existing_service_ids);

}

function group_by_textbox_name_value(id, name_arg) {
	
	var group_by_value = 0;
	
	$('table#' + id + '_item_table tbody>tr').each(function () {
		$(this).find('input[name=' + name_arg + ']').each(function () {
			if ($(this).val()) {
				group_by_value += parseFloat($(this).val().replace(/,/g, ''));
			}
		});
	});
	
	return group_by_value;
	
}

function emptyallfield(product_row_id){
    var last_item_row = $('#product_item_table tbody>#tr_'+product_row_id);
    last_item_row.find('input').attr('id', product_row_id);
    last_item_row.find('input[name=usr_lbr_price]').attr('onblur', 'product_calculation("'+product_row_id+'")');
    last_item_row.find('input[name=item_discount]').attr('onblur', 'product_calculation("'+product_row_id+'")');
    last_item_row.find('input[name=product_qty]').attr('onkeyup', 'product_calculation("'+product_row_id+'")');
    last_item_row.find('input[name=igst_pct]').attr('onkeyup', 'product_calculation("'+product_row_id+'")');
}
