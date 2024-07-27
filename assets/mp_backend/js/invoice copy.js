 $( document ).ready(function() {

$(".item_service_id").each(function( index ) {
			  var service_row_id = $(this).parent().parent().attr("id");
				  if(service_row_id){
					  service_group_tax_calculation();
				  }
			   });
$(".item_product_id").each(function( index ) {
			  var product_row_id = $(this).parent().parent().attr("id");
				  if(product_row_id){
					  product_group_tax_calculation();	
				  }
			   });
	 


 $(".add_service").click(function() {
    	//console.log('jiii');
    	var add_mathround = parseInt(new Date().getTime() + Math.random());
    	var next_row_id = $("#service_item_table > tbody > tr").length;
    	
    	$('#new_service_row').clone().appendTo('#service_item_table').removeAttr('id').addClass('item').attr('id', 'tr_'+add_mathround).show();
    	
    	$('#tr_'+add_mathround+' .item_sno').attr('id', "item_sno_"+add_mathround);
		$('#tr_'+add_mathround+' .item_sno').empty().html(next_row_id);
        $('#tr_'+add_mathround+' .item_service_id').attr('id', "item_service_id_"+add_mathround);
            
    	$('#tr_'+add_mathround+' .usr_lbr_price').attr('id', "usr_lbr_price_"+add_mathround);
    	$('#tr_'+add_mathround+' .service_id').attr('id', "service_id_"+add_mathround);
    	$('#tr_'+add_mathround+' .item_discount').attr('id', "item_discount"+add_mathround);
    	
    	$('#tr_'+add_mathround+' .igst_pct').attr('id', "igst_pct_"+add_mathround);
    	$('#tr_'+add_mathround+' .cgst_pct').attr('id', "cgst_pct_"+add_mathround);
    	$('#tr_'+add_mathround+' .sgst_pct').attr('id', "sgst_pct_"+add_mathround);
    	$('#tr_'+add_mathround+' .warrentry_prd').attr('id', "warrentry_prd_"+add_mathround);
    	$().ready(function () {
            	 $("#item_service_id_"+add_mathround).select2().on("change", function(e) {
                     var service_id = parseInt($(this).val());
                     var service_row_id = $(this).attr('id').replace(/item_service_id_/g,'');
					if(service_id != '' && service_id > 0){
	               		getServiceDetails(service_id, service_row_id);
		               }else{
		               	emptyallfield(service_row_id);
		               }
                   });
            });
    });
       $(".add_product").click(function() {
    	//console.log('jiii');
    	var add_mathround = parseInt(new Date().getTime() + Math.random());
    	var next_row_id = $("#product_item_table > tbody > tr").length;
    	$('#new_product_row').clone().appendTo('#product_item_table').removeAttr('id').addClass('item').attr('id', 'tr_'+add_mathround).show();
    	
    	$('#tr_'+add_mathround+' .item_sno').attr('id', "item_sno_"+add_mathround);
		$('#tr_'+add_mathround+' .item_sno').empty().html(next_row_id);
        $('#tr_'+add_mathround+' .item_product_id').attr('id', "item_product_id_"+add_mathround);
            
    	$('#tr_'+add_mathround+' .usr_lbr_price').attr('id', "usr_lbr_price_"+add_mathround);
    	$('#tr_'+add_mathround+' .product_id').attr('id', "product_id_"+add_mathround);
    	$('#tr_'+add_mathround+' .igst_pct').attr('id', "igst_pct_"+add_mathround);
    	$('#tr_'+add_mathround+' .cgst_pct').attr('id', "cgst_pct_"+add_mathround);
    	$('#tr_'+add_mathround+' .sgst_pct').attr('id', "sgst_pct_"+add_mathround);
    	$('#tr_'+add_mathround+' .warrentry_prd').attr('id', "warrentry_prd_"+add_mathround);
    	$().ready(function () {
            	 $("#item_product_id_"+add_mathround).select2().on("change", function(e) {
                     var product_id = parseInt($(this).val());
                     var product_row_id = $(this).attr('id').replace(/item_product_id_/g,'');
					if(product_id != '' && product_id > 0){
	               		getProductDetails(product_id, product_row_id);
		               }else{
		               	emptyallfield(product_row_id);
		               }
                   });
            });
    });

    });
    function getServiceDetails(service_id, service_row_id){
    	//console.log("service_row_id==="+service_row_id);
    	$.post(getServiceDetailsURL, {
                service_ids: service_id,
                car_brand_id: $('#car_brand_id').val(),
                car_brand_model_id: $('#car_brand_model_id').val(),
                 _mm_csrf: $('#_mm_csrf').val(),
            }, function (data) {
            	service_items = JSON.parse(data);
            	if(service_items){
            		if(service_items.success=='1'){
            			var ser_arr = service_items.services;
	            		var mech_price = parseFloat(ser_arr.mech_price);
	            		var user_price = parseFloat(ser_arr.user_price);
            		}
            		if(service_items.success=='0'){
	            		var mech_price = 0;
	            		var user_price = 0;
            		}
            		
            		
            		var last_item_row = $('#service_item_table tbody>#tr_'+service_row_id);
            		last_item_row.find('input').attr('id', service_row_id);
            		
            		last_item_row.find('input[name=mech_lbr_price]').attr('onkeyup', 'service_calculation("'+service_row_id+'")');
					last_item_row.find('input[name=usr_lbr_price]').attr('onkeyup', 'service_calculation("'+service_row_id+'")');
					last_item_row.find('input[name=item_discount]').attr('onkeyup', 'service_calculation("'+service_row_id+'")');
					
					last_item_row.find('input[name=igst_pct]').attr('onkeyup', 'service_calculation("'+service_row_id+'")');
					last_item_row.find('input[name=cgst_pct]').attr('onkeyup', 'service_calculation("'+service_row_id+'")');
					last_item_row.find('input[name=sgst_pct]').attr('onkeyup', 'service_calculation("'+service_row_id+'")');
					last_item_row.find('input[name=warrentry_prd]').attr('onkeyup', 'service_calculation("'+service_row_id+'")');
					
            		 last_item_row.find('input[name=mech_lbr_price]').val(mech_price.toFixed(2));
            		 last_item_row.find('input[name=usr_lbr_price]').val(user_price.toFixed(2));
            		service_calculation(service_row_id);
            	}
            });
    }
    function getProductDetails(product_id, product_row_id){
    	$.post(getProductDetailsURL, {
                product_ids: product_id,
                car_brand_id: $('#car_brand_id').val(),
                car_brand_model_id: $('#car_brand_model_id').val(),
                 _mm_csrf: $('#_mm_csrf').val(),
            }, function (data) {
            	product_items = JSON.parse(data);
            	// console.log(product_items);
            	if(product_items){
            		if(product_items.success=='1'){
            			var ser_arr = product_items.products;
	            		var mech_price = parseFloat(ser_arr.max_purchase_price);
	            		var user_price = parseFloat(ser_arr.max_product_price);
	            		var igst_percentage = parseFloat(ser_arr.igst_percentage);
	            		var igst_amount = parseFloat(ser_arr.igst_amount);
	            		var cgst_percentage = parseFloat(ser_arr.cgst_percentage);
	            		var cgst_amount = parseFloat(ser_arr.cgst_amount);
	            		var sgst_percentage = parseFloat(ser_arr.sgst_percentage);
	            		var sgst_amount = parseFloat(ser_arr.sgst_amount);
            		}
            		if(product_items.success=='0'){
	            		var mech_price = 0;
	            		var user_price = 0;
	            		var igst_percentage = 0;
	            		var igst_amount = 0;
	            		var cgst_percentage = 0;
	            		var cgst_amount = 0;
	            		var sgst_percentage = 0;
	            		var sgst_amount = 0;
            		}
            		
            		var last_item_row = $('#product_item_table tbody>#tr_'+product_row_id);
            		last_item_row.find('input').attr('id', product_row_id);
            		
            		last_item_row.find('input[name=mech_lbr_price]').attr('onkeyup', 'product_calculation("'+product_row_id+'")');
					last_item_row.find('input[name=usr_lbr_price]').attr('onkeyup', 'product_calculation("'+product_row_id+'")');
					last_item_row.find('input[name=item_discount]').attr('onkeyup', 'product_calculation("'+product_row_id+'")');
					last_item_row.find('input[name=product_qty]').attr('onkeyup', 'product_calculation("'+product_row_id+'")');
					last_item_row.find('input[name=igst_pct]').attr('onkeyup', 'product_calculation("'+product_row_id+'")');
					last_item_row.find('input[name=cgst_pct]').attr('onkeyup', 'product_calculation("'+product_row_id+'")');
					last_item_row.find('input[name=sgst_pct]').attr('onkeyup', 'product_calculation("'+product_row_id+'")');
					last_item_row.find('input[name=warrentry_prd]').attr('onkeyup', 'product_calculation("'+product_row_id+'")');
					
            		 last_item_row.find('input[name=mech_lbr_price]').val(mech_price.toFixed(2));
            		 last_item_row.find('input[name=usr_lbr_price]').val(user_price.toFixed(2));
            		  last_item_row.find('input[name=igst_pct]').val(igst_percentage.toFixed(2));
            		 last_item_row.find('input[name=igst_amount]').val(igst_amount.toFixed(2));
            		  last_item_row.find('input[name=cgst_pct]').val(cgst_percentage.toFixed(2));
            		 last_item_row.find('input[name=cgst_amount]').val(cgst_amount.toFixed(2));
            		  last_item_row.find('input[name=sgst_pct]').val(sgst_percentage.toFixed(2));
            		 last_item_row.find('input[name=sgst_amount]').val(sgst_amount.toFixed(2));
            		product_calculation(product_row_id);
            	}
            });
    }
    function service_calculation(id){
    	if(id){
    		var tr_id = "tr_"+id;
    		
    		var usr_lbr_price = ($("#"+tr_id+" input[name=usr_lbr_price]").val())?$("#"+tr_id+" input[name=usr_lbr_price]").val():0;
    		var item_discount = 0;
    		
    		var igst_pct = ($("#"+tr_id+" input[name=igst_pct]").val())?$("#"+tr_id+" input[name=igst_pct]").val():0;
    		var cgst_pct = ($("#"+tr_id+" input[name=cgst_pct]").val())?$("#"+tr_id+" input[name=cgst_pct]").val():0;
    		var sgst_pct = ($("#"+tr_id+" input[name=sgst_pct]").val())?$("#"+tr_id+" input[name=sgst_pct]").val():0;
    		var igst_amount =(igst_pct) ? parseFloat(((usr_lbr_price*igst_pct)- item_discount)/100): 0;
    		var cgst_amount =(cgst_pct) ? parseFloat(((usr_lbr_price*cgst_pct)- item_discount)/100): 0;
    		var sgst_amount =(sgst_pct) ? parseFloat(((usr_lbr_price*sgst_pct)- item_discount)/100): 0;
    		
    		$("#"+tr_id+" input[name=igst_amount]").val(igst_amount.toFixed(2));
    		$("#"+tr_id+" input[name=cgst_amount]").val(cgst_amount.toFixed(2));
    		$("#"+tr_id+" input[name=sgst_amount]").val(sgst_amount.toFixed(2));
    		
            //console.log()
    		
    		$("#"+tr_id+" .igst_amount_label").empty().html(igst_amount.toFixed(2));
    		$("#"+tr_id+" .cgst_amount_label").empty().html(cgst_amount.toFixed(2));
    		$("#"+tr_id+" .sgst_amount_label").empty().html(sgst_amount.toFixed(2));
    		
    		var item_total_amount = (parseFloat(usr_lbr_price) + parseFloat(igst_amount) +  parseFloat(cgst_amount) + parseFloat(sgst_amount)) - parseFloat(item_discount);
    		//total_servie_gst_price
            $("#"+tr_id+" input[name=item_total_amount]").val(item_total_amount.toFixed(2));
    		$("#"+tr_id+" input[name=item_total_amount]").val(item_total_amount.toFixed(2));
    		$("#"+tr_id+" .item_total_amount_label").empty().html(item_total_amount.toFixed(2));
    		
    		//console.log("item_total_amount"+parseFloat(item_total_amount));
    	}
    	
    	service_group_tax_calculation();
    	
    }
    function service_group_tax_calculation(){
    	var total_mech_lbr_price = group_by_textbox_name_value('service','mech_lbr_price');
    	var total_usr_lbr_price = group_by_textbox_name_value('service','usr_lbr_price');
    	var total_item_discount = group_by_textbox_name_value('service','item_discount');
    	var total_igst_amount = group_by_textbox_name_value('service','igst_amount');
    	var total_cgst_amount = group_by_textbox_name_value('service','cgst_amount');
    	var total_sgst_amount = group_by_textbox_name_value('service','sgst_amount');
    	var total_warrentry_prd = group_by_textbox_name_value('service','warrentry_prd');
    	var total_item_total_amount = group_by_textbox_name_value('service','item_total_amount');
    	
    	/*
		console.log("total_mech_lbr_price"+total_mech_lbr_price);
				console.log("total_usr_lbr_price"+total_usr_lbr_price);
				console.log("total_cgst_amount"+total_cgst_amount);
				console.log("total_sgst_amount"+total_sgst_amount);
				console.log("total_igst_amount"+total_igst_amount);
				console.log("total_warrentry_prd"+total_item_total_amount);*/
		
    	
    		$("#service_item_table input[name=total_mech_lbr_price]").val(total_mech_lbr_price.toFixed(2));
    		$("#service_item_table input[name=total_usr_lbr_price]").val(total_usr_lbr_price.toFixed(2));
    		$("#service_item_table input[name=total_item_discount").val(total_item_discount.toFixed(2));
    		$("#service_item_table input[name=total_igst_amount]").val(total_igst_amount.toFixed(2));
    		$("#service_item_table input[name=total_cgst_amount]").val(total_cgst_amount.toFixed(2));
    		$("#service_item_table input[name=total_sgst_amount]").val(total_sgst_amount.toFixed(2));
    		$("#service_item_table input[name=total_item_total_amount]").val(total_item_total_amount.toFixed(2));
    		
    		
    		$("#service_item_table .total_mech_lbr_price_label").empty().html(total_mech_lbr_price.toFixed(2));
    		$("#service_item_table .total_usr_lbr_price_label").empty().html(total_usr_lbr_price.toFixed(2));
			$("#service_item_table .total_item_discount_label").empty().html(total_item_discount.toFixed(2));
    		$("#service_item_table .total_igst_amount_label").empty().html(total_igst_amount.toFixed(2));
    		$("#service_item_table .total_cgst_amount_label").empty().html(total_cgst_amount.toFixed(2));
    		$("#service_item_table .total_sgst_amount_label").empty().html(total_sgst_amount.toFixed(2));
    		$("#service_item_table .total_item_total_amount_label").empty().html(total_item_total_amount.toFixed(2));
    		
    		overall_invoice_calc();
    		
    }
    function product_calculation(id){
    	//console.log("==="+id);
    	if(id){
    		var tr_id = "tr_"+id;
    		var mech_lbr_price = ($("#"+tr_id+" input[name=mech_lbr_price]").val())?parseFloat($("#"+tr_id+" input[name=mech_lbr_price]").val()):0;
    		//console.log("product_qty=========="+$("#"+tr_id+" input[name=product_qty]").val());
    		var usr_lbr_price = ($("#"+tr_id+" input[name=usr_lbr_price]").val())?parseFloat($("#"+tr_id+" input[name=usr_lbr_price]").val()):0;
    		var product_qty = ($("#"+tr_id+" input[name=product_qty]").val())?parseFloat($("#"+tr_id+" input[name=product_qty]").val()):1;
    		var item_discount = ($("#"+tr_id+" input[name=item_discount]").val())?parseFloat($("#"+tr_id+" input[name=item_discount]").val()):0;
    		
    		var total_amount = usr_lbr_price * product_qty;
            var total_taxable_amount = total_amount - (product_qty*item_discount);
    		//console.log("product_qty======"+product_qty);
    		var igst_pct = ($("#"+tr_id+" input[name=igst_pct]").val())?$("#"+tr_id+" input[name=igst_pct]").val():0;
    		var igst_pct = ($("#"+tr_id+" input[name=igst_pct]").val())?$("#"+tr_id+" input[name=igst_pct]").val():0;
    		var cgst_pct = ($("#"+tr_id+" input[name=cgst_pct]").val())?$("#"+tr_id+" input[name=cgst_pct]").val():0;
    		var sgst_pct = ($("#"+tr_id+" input[name=sgst_pct]").val())?$("#"+tr_id+" input[name=sgst_pct]").val():0;
    		
    		var igst_amount =(igst_pct) ? parseFloat(((total_taxable_amount*igst_pct))/100): 0;
    		var cgst_amount =(cgst_pct) ? parseFloat(((total_taxable_amount*cgst_pct))/100): 0;
    		var sgst_amount =(sgst_pct) ? parseFloat(((total_taxable_amount*sgst_pct))/100): 0;
    		
    		//$("#"+tr_id+" input[name=product_qty]").val(1);
    		$("#"+tr_id+" input[name=total_amount]").val(total_amount.toFixed(2));
            $("#"+tr_id+" input[name=total_mech_amount]").val((mech_lbr_price * product_qty).toFixed(2));
    		$("#"+tr_id+" input[name=igst_amount]").val(igst_amount.toFixed(2));
    		$("#"+tr_id+" input[name=cgst_amount]").val(cgst_amount.toFixed(2));
    		$("#"+tr_id+" input[name=sgst_amount]").val(sgst_amount.toFixed(2));
            //item_discount
    		$("#"+tr_id+" input[name=item_discount_price]").val((product_qty*item_discount).toFixed(2));
            
    		$("#"+tr_id+" .total_amount_label").empty().html(product_qty*parseFloat(usr_lbr_price));
    		$("#"+tr_id+" .igst_amount_label").empty().html(igst_amount.toFixed(2));
    		$("#"+tr_id+" .cgst_amount_label").empty().html(cgst_amount.toFixed(2));
    		$("#"+tr_id+" .sgst_amount_label").empty().html(sgst_amount.toFixed(2));
    		
    		var item_total_amount = (parseFloat(total_taxable_amount) + parseFloat(igst_amount) +  parseFloat(cgst_amount) + parseFloat(sgst_amount));
    		
    		$("#"+tr_id+" input[name=item_total_amount]").val(item_total_amount.toFixed(2));
    		$("#"+tr_id+" .item_total_amount_label").empty().html(item_total_amount.toFixed(2));
    		
    //		//console.log("item_total_amount"+parseFloat(item_total_amount));
    	}
    	product_group_tax_calculation();
    	
    }
    function product_group_tax_calculation(){
    	var total_mech_lbr_price = group_by_textbox_name_value('product','mech_lbr_price');
    	var total_usr_lbr_price = group_by_textbox_name_value('product','total_amount');
    	//console.log("total_mech_lbr_price===="+total_mech_lbr_price);
    	var total_item_discount = group_by_textbox_name_value('product','item_discount_price');
    	var total_igst_amount = group_by_textbox_name_value('product','igst_amount');
    	var total_cgst_amount = group_by_textbox_name_value('product','cgst_amount');
    	var total_sgst_amount = group_by_textbox_name_value('product','sgst_amount');
    	var total_warrentry_prd = group_by_textbox_name_value('product','warrentry_prd');
    	var total_item_total_amount = group_by_textbox_name_value('product','item_total_amount');
    	
    	/*
		console.log("total_mech_lbr_price"+total_mech_lbr_price);
				console.log("total_usr_lbr_price"+total_usr_lbr_price);
				console.log("total_cgst_amount"+total_cgst_amount);
				console.log("total_sgst_amount"+total_sgst_amount);
				console.log("total_igst_amount"+total_igst_amount);
				console.log("total_warrentry_prd"+total_item_total_amount);*/
		
    	
    		$("#product_item_table input[name=total_mech_lbr_price]").val(total_mech_lbr_price.toFixed(2));
    		$("#product_item_table input[name=total_usr_lbr_price]").val(total_usr_lbr_price.toFixed(2));
    		$("#product_item_table input[name=total_item_discount").val(total_item_discount.toFixed(2));
    		$("#product_item_table input[name=total_igst_amount]").val(total_igst_amount.toFixed(2));
    		$("#product_item_table input[name=total_cgst_amount]").val(total_cgst_amount.toFixed(2));
    		$("#product_item_table input[name=total_sgst_amount]").val(total_sgst_amount.toFixed(2));
    		$("#product_item_table input[name=total_item_total_amount]").val(total_item_total_amount.toFixed(2));
    		
    		
    		$("#product_item_table .total_mech_lbr_price_label").empty().html(total_mech_lbr_price.toFixed(2));
    		$("#product_item_table .total_usr_lbr_price_label").empty().html(total_usr_lbr_price.toFixed(2));
    		$("#product_item_table .total_item_discount_label").empty().html(total_item_discount.toFixed(2));
    		$("#product_item_table .total_igst_amount_label").empty().html(total_igst_amount.toFixed(2));
    		$("#product_item_table .total_cgst_amount_label").empty().html(total_cgst_amount.toFixed(2));
    		$("#product_item_table .total_sgst_amount_label").empty().html(total_sgst_amount.toFixed(2));
    		$("#product_item_table .total_item_total_amount_label").empty().html(total_item_total_amount.toFixed(2));
    		
    		overall_invoice_calc();
    }
    function overall_invoice_calc(){
   	 	
   	 	var total_product_mech_lab_amount = $("#product_item_table input[name=total_mech_lbr_price]").val();
   	 	var total_service_mech_lab_amount = $("#service_item_table input[name=total_mech_lbr_price]").val();
   	 	
   	 	var total_product_usr_lab_amount = $("#product_item_table .total_usr_lbr_price_label").html();
   	 	var total_service_usr_lab_amount = $("#service_item_table input[name=total_usr_lbr_price]").val();
   	 	
   	 	var total_product_discount_amount = $("#product_item_table input[name=total_item_discount").val();
   	 	var total_service_discount_amount = $("input[name=service_discount").val();
        total_service_discount_amount = (total_service_discount_amount == '') ? 0:total_service_discount_amount; 
   	 	
   	 	var total_product_igst_amount = $("#product_item_table input[name=total_igst_amount]").val();
   	 	var total_service_igst_amount = $("#service_item_table input[name=total_igst_amount]").val();
   	 	
   	 	var total_product_cgst_amount = $("#product_item_table input[name=total_cgst_amount]").val();
   	 	var total_service_cgst_amount = $("#service_item_table input[name=total_cgst_amount]").val();
   	 	
   	 	var total_product_sgst_amount = $("#product_item_table input[name=total_sgst_amount]").val();
   	 	var total_service_sgst_amount = $("#service_item_table input[name=total_sgst_amount]").val();
   	 	
   	 	var total_product_amount = $("#product_item_table input[name=total_item_total_amount]").val();
   	 	var total_service_amount = $("#service_item_table input[name=total_item_total_amount]").val();
   	 	
   	 	
        var service_discount = parseFloat(total_service_discount_amount);
        var service_discount_amount = (parseFloat(total_service_usr_lab_amount)  * service_discount) / 100;
        var service_total_taxable = (total_service_usr_lab_amount - service_discount_amount);
        var service_gst_pct = ($('#total_service_tax').val() == '') ? 0:$('#total_service_tax').val();
        var service_gst_amount =(service_gst_pct) ? parseFloat((service_total_taxable * service_gst_pct)/100): 0;
        var total_servie_invoice =  service_total_taxable + service_gst_amount;  

        var mech_total = parseFloat(total_product_mech_lab_amount) + parseFloat(total_service_mech_lab_amount);
        var user_total = parseFloat(total_product_usr_lab_amount) + parseFloat(total_service_usr_lab_amount);
   	 	var product_gst_price = (parseFloat(total_product_cgst_amount)+parseFloat(total_product_sgst_amount)+parseFloat(total_product_igst_amount));
   	 	//var total = parseFloat(total_product_amount) + parseFloat(total_service_amount);
        var product_total_taxable =  total_product_usr_lab_amount - total_product_discount_amount;

        var total_taxable_amount = service_total_taxable + product_total_taxable; 

        //console.log(product_total_taxable);
   	 	
        //var grand_total = (user_total) + gst;
        grand_total = parseFloat(total_servie_invoice) + parseFloat(total_product_amount);

   	 	
        // service totals
        $(".total_service_mech_price").empty().html(format_money(parseFloat(total_service_mech_lab_amount.toFixed(2),default_currency_digit)));
        $(".total_user_service_price").empty().html(format_money(total_service_usr_lab_amount,default_currency_digit));
        $(".service_total_discount").empty().html(format_money(service_discount_amount,default_currency_digit));
        $(".total_user_service_taxable").empty().html(format_money(service_total_taxable.toFixed(2),default_currency_digit));
        $(".total_servie_gst_price").empty().html(format_money(service_gst_amount.toFixed(2),default_currency_digit));
        $('.total_servie_invoice').empty().html(format_money(total_servie_invoice.toFixed(2),default_currency_digit));
        
        //product totals product_total_discount
        $(".total_product_mech_price").empty().html(format_money(parseFloat(total_product_mech_lab_amount).toFixed(2),default_currency_digit));
        $(".total_user_product_price").empty().html(format_money(total_product_usr_lab_amount,default_currency_digit));
        $(".product_total_discount").empty().html(format_money(total_product_discount_amount,default_currency_digit));
        $(".total_user_product_taxable").empty().html(format_money(product_total_taxable.toFixed(2),default_currency_digit));
        $(".total_user_product_gst").empty().html(format_money(product_gst_price.toFixed(2),default_currency_digit));
        $(".total_product_invoice").empty().html(format_money(total_product_amount,default_currency_digit));
        //

        //all total 
        $(".total_taxable_amount").empty().html(format_money(total_taxable_amount.toFixed(2),default_currency_digit));
        $(".total_gst_amount").empty().html(format_money(service_gst_amount + product_gst_price.toFixed(2),default_currency_digit));
        $(".grand_total").empty().html(format_money(grand_total.toFixed(2),default_currency_digit)); 
        //$(".total_user_price").empty().html(user_total.toFixed(2));
        //$(".total_gst_price").empty().html(gst.toFixed(2));
        
   	 	
    }
    function group_by_textbox_name_value (id,name_arg) {
		  var group_by_value = 0;
			 $('table#'+id+'_item_table tbody>tr').each(function () {
				 $(this).find('input[name='+name_arg+']').each(function () {
				 	//console.log(name_arg+"======"+$(this).val());
		    	 if($(this).val()){
		        	 group_by_value += parseFloat($(this).val());
		    	 }
				});
			});
			return group_by_value;
		}