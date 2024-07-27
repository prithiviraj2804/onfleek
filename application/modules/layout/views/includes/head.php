	<meta charset="UTF-8">
	<meta name="robots" content="noindex, nofollow, disallow" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Garage Management Software | MechToolz</title>
	<meta name="og:title" content="Garage Management Software | MechToolz" />
	<meta name="description" content="MechToolz – Garage Management software is custom fit and well suited for the Auto repair garages and service workshops, giving them complete control of their workshop and automobile business." />
	<meta name="og:description" content="MechToolz – Garage Management software is custom fit and well suited for the Auto repair garages and service workshops, giving them complete control of their workshop and automobile business." />
	<meta name="keywords" content="Multi Brand Car Workshop, car workshop software, car care automotive software, software, Spare parts management software, auto repair software, cloud software, garage management software, vehicle management software">
	<meta name="og:url" content="https://www.mechtoolz.com/" />
	<!-- <link href="<?php echo base_url(); ?>assets/mp_backend/img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="<?php echo base_url(); ?>assets/mp_backend/img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
	<link href="<?php echo base_url(); ?>assets/mp_backend/img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
	<link href="<?php echo base_url(); ?>assets/mp_backend/img/favicon.57x57.png" rel="apple-touch-icon" type="image/png"> -->
	<link rel="icon" type="image/ico" href="<?php echo base_url(); ?>assets/mp_backend/img/favicon.ico">
	<link href="<?php echo base_url(); ?>assets/mp_backend/img/favicon.ico" rel="shortcut icon">


	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/lib/lobipanel/lobipanel.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/separate/vendor/lobipanel.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/lib/jqueryui/jquery-ui.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/separate/pages/widgets.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/lib/font-awesome/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/lib/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/main.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/mm_backend.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/separate/vendor/select2.min.css">

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/lib/bootstrap-sweetalert/sweetalert.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/separate/vendor/sweet-alert-animations.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/separate/pages/contacts.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/separate/vendor/bootstrap-select/bootstrap-select.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/separate/vendor/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/separate/vendor/bootstrap-daterangepicker.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/separate/vendor/datepicker.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/lib/datatables-net/datatables.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/separate/vendor/datatables-net.min.css">
	<script src="<?php echo base_url(); ?>assets/mp_backend/js/lib/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/mp_backend/js/lib/jquery/jquery.slimscroll.min.js"></script>
	<script>
		$(function() {

			 <?php if($this->session->userdata('is_new_user') == 'N'){ ?>
				<?php if( $this->router->fetch_class() != 'workshop_setup' ){ ?>
					window.location = "<?php echo site_url('workshop_setup/form')."/".$this->session->userdata('work_shop_id'); ?>";
				<?php } ?>
			 <?php  } ?>

			$(':input').on('focus',function(){
				$(this).attr('autocomplete', 'off');
			});

			$('body').on('focus', ".datepicker", function() {
				$(this).datepicker({
					autoclose: true,
					format: '<?php echo $this->session->userdata('default_date_format');?>'
				});
			});
			$(document).on('keyup', 'input,textarea', function() {
				var len = (this.value).length;
				if (len > 0) {
					$('#' + $(this).attr('name')).parent().removeClass('has-error');
					$('#' + $(this).attr('name')).removeClass('border_error');
					$('#' + $(this).attr('name')).parent().removeClass('border_error');
					$('#' + $(this).attr('id')).parent().removeClass('has-error');
					$('#' + $(this).attr('id')).removeClass('border_error');
					$('#' + $(this).attr('id')).parent().removeClass('border_error');

				} 
			});

			$(".twodigit").change(function() {
				if(this.value == '' || this.value == 0 || this.value == "0"){
					this.value = 0;
				}else{
					this.value = parseFloat(this.value).toFixed(2);
				}
				
			});

			// $(".searchSelect").change(function(){
   //      		$('.btn_submit').click();
			// });
	
			$(".removeError").change(function() {
				var len = (this.value);
				if (this.value != "" || this.value != 0) {
					$('#' + $(this).attr('name')).parent().removeClass('has-error');
					$('#' + $(this).attr('name')).parent().removeClass('border_error');
					$('#' + $(this).attr('name')).removeClass('has-error');
					$('#' + $(this).attr('name')).removeClass('border_error');
				}
			});

			$(document).on('change', '.removeErrorInput', function() {
				var len = (this.value);
				if (this.value != "" || this.value != 0) {
					$('#' + $(this).attr('name')).removeClass('border_error');
					$('#' + $(this).attr('name')).parent().removeClass('has-error');
				}
			});
			
			$(".datepicker_error").on('blur', function() {
				var len = (this.value);
				if (this.value != "" || this.value != 0) {
					$('#' + $(this).attr('name')).removeClass('border_error');
					$('#' + $(this).attr('name')).parent().removeClass('has-error');
				}
			});

			$(".reschedule_error").on('blur', function() {
				var len = (this.value).length;
				if (len > 0) {
					$('#' + $(this).attr('name')).removeClass('border_error');
					$('#' + $(this).attr('name')).parent().removeClass('has-error');
				}
			});

			$(document).on('click', '.add_car', function() {
				if ($(this).attr('data-car-id')) {
					var car_id = $(this).attr('data-car-id');
					if (car_id == '' || car_id == null) {
						car_id = 0;
					}
				} else {
					var car_id = 0;
				}
				
				if ($(this).attr('data-model-type')) {
					var module_type = $(this).attr('data-model-type');
					if (module_type == '' || module_type == null) {
						module_type = 0;
					}
				} else {
					var module_type = 0;
				}
				$('#modal-placeholder').load("<?php echo site_url('user_cars/ajax/modal_add_car'); ?>/" + $(this).attr('data-customer-id') + "/" + $(this).attr('data-model-from') + "/" + car_id + "/" + module_type);
			});

			$(document).on('click', '.addproduct', function() {
				var existing_product_ids = $(this).attr('data-existing_product_ids');
				if(existing_product_ids == '' || existing_product_ids == null || existing_product_ids == undefined){
					existing_product_ids = 0;
				}else{
					existing_product_ids = existing_product_ids.replace(/,/g, '-');
				}
				var entity_type = $(this).attr('data-entity-type');
				if(entity_type == '' || entity_type == null || entity_type == undefined){
					entity_type = 0;
				}
				var entity_id = $(this).attr('data-entity-id');
				if(entity_id == '' || entity_id == null || entity_id == undefined){
					entity_id = 0;
				}
				var customer_id = $(this).attr('data-customer-id');
				if(customer_id == '' || customer_id == null || customer_id == undefined){
					customer_id = 0;
				}
				$('#modal-placeholder-two').load("<?php echo site_url('mech_item_master/ajax/addproductmodal'); ?>/" + existing_product_ids+"/"+entity_type+"/"+entity_id+"/"+customer_id);
			});

			$(document).on('click', '.addservice', function() {

				var existing_service_ids = $(this).attr('data-existing_service_ids');
				if(existing_service_ids == '' || existing_service_ids == null || existing_service_ids == undefined){
					existing_service_ids = 0;
				}else{
					existing_service_ids = existing_service_ids.replace(/,/g, '-');
				}

				var entity_type = $(this).attr('data-entity_type');
				if(entity_type == '' || entity_type == null || entity_type == undefined){
					entity_type = 0;
				}

				var entity_id = $(this).attr('data-entity_id');
				if(entity_id == '' || entity_id == null || entity_id == undefined){
					entity_id = 0;
				}

				var customer_id = $(this).attr('data-customer-id');
				if(customer_id == '' || customer_id == null || customer_id == undefined){
					customer_id = 0;
				}

				$('#modal-placeholder-two').load("<?php echo site_url('mech_item_master/ajax/addservicemodal'); ?>/" + existing_service_ids+"/"+entity_type+"/"+entity_id+"/"+customer_id);
			});

			$(document).on('click', '.add_services_popup', function() {
				$('#modal-placeholder').load("<?php echo site_url('mechanic_service_item_price_list/ajax/modal_add_services'); ?>");
			});

			$(document).on('click', '.purchase_order', function() {
				if ($(this).attr('data-purchase_order_id')) {
					var purchase_order_id = $(this).attr('data-purchase_order_id');
					if (purchase_order_id == '' || purchase_order_id == null) {
						purchase_order_id = 0;
					}
				} else {
					var purchase_order_id = 0;
				}

				$('#modal-placeholder').load("<?php echo site_url('mech_purchase_order/ajax/purchase_order_modal'); ?>/"+purchase_order_id);
			});

			$(document).on('click', '.add_appointment', function() {
				if ($(this).attr('data-lead-id')) {
					var lead_id = $(this).attr('data-lead-id');
					if (lead_id == '' || lead_id == null) {
						lead_id = 0;
					}
				} else {
					var lead_id = 0;
				}
				
				if ($(this).attr('data-model-type')) {
					var module_type = $(this).attr('data-model-type');
					if (module_type == '' || module_type == null) {
						module_type = 0;
					}
				} else {
					var module_type = 0;
				}

				if ($(this).attr('data-appoint-id')) {
					var appoint_id = $(this).attr('data-appoint-id');
					if (appoint_id == '' || appoint_id == null) {
						appoint_id = 0;
					}
				} else {
					var appoint_id = 0;
				}

				$('#modal-placeholder').load("<?php echo site_url('mech_leads/ajax/modal_add_appointment'); ?>/"+lead_id+"/"+appoint_id+"/"+$(this).attr('data-model-from')+"/"+module_type);
			});

			$(document).on('click', '.add_client_page', function() {
				$('#modal-placeholder').load("<?php echo site_url('clients/ajax/modal_add_client'); ?>");
			});

			$(document).on('click', '.send_sms', function() {
				$('#modal-placeholder').load("<?php echo site_url('mech_sms/ajax/modalSendRemainderSms'); ?>/"+$(this).attr('data-invoice-id')+"/"+$(this).attr('data-type-id'));
			});

			$(document).on('click', '.add_feedback', function() {
				$('#modal-placeholder').load("<?php echo site_url('mech_add_feedback/ajax/modal_add_feedback'); ?>/"+$(this).attr('data-invoice-id'));
			});

			$(document).on('click', '.make-add-payment', function () {
			$('#modal-placeholder').load("<?php echo site_url('mech_payments/ajax/modal_add_payment'); ?>/"+$(this).attr('data-entity-id')+"/"+$(this).attr('data-grand-amt')+"/"+$(this).attr('data-balance-amt')+"/"+$(this).attr('data-customer-id')+"/"+$(this).attr('data-entity-type'));
       		});

			$(document).on('click', '.add_reminder', function() {
				if ($(this).attr('data-module') == "custom") {
					var type = "CUS";
				} else if ($(this).attr('data-module') == "contact") {
					var type = "CON";
				}
				$('#modal-placeholder').load("<?php echo site_url('reminder/ajax/modal_add_reminder'); ?>/"+$(this).attr('data-reminder-id')+"/"+type);
			});

			$(document).on('click', '.add_recommended_product', function(){

				if($(this).attr('data-model_from')) {
					var model_from = $(this).attr('data-model_from');
				}else{
					var model_from = 'I';
				}

				if($(this).attr('data-invoice_id')){
					var invoice_id = $(this).attr('data-invoice_id');
				}else{
					var invoice_id = 0;
				}

				if($(this).attr('data-customer_id')){
					var customer_id = $(this).attr('data-customer_id');
				}else{
					var customer_id = 0;
				}

				if($(this).attr('data-vehicle_id')){
					var vehicle_id = $(this).attr('data-vehicle_id');
				}else{
					var vehicle_id  = 0;
				}

				$('#modal-placeholder').load("<?php echo site_url('user_cars/ajax/modal_add_recommended_products'); ?>/"+model_from+"/"+invoice_id+"/"+customer_id+"/"+vehicle_id);

			});

			$(document).on('click', '.add_recommended_service', function(){

				if($(this).attr('data-model_from')) {
					var model_from = $(this).attr('data-model_from');
				}else{
					var model_from = 'I';
				}

				if($(this).attr('data-invoice_id')){
					var invoice_id = $(this).attr('data-invoice_id');
				}else{
					var invoice_id = 0;
				}

				if($(this).attr('data-customer_id')){
					var customer_id = $(this).attr('data-customer_id');
				}else{
					var customer_id = 0;
				}

				if($(this).attr('data-vehicle_id')){
					var vehicle_id = $(this).attr('data-vehicle_id');
				}else{
					var vehicle_id  = 0;
				}

				$('#modal-placeholder').load("<?php echo site_url('user_cars/ajax/modal_add_recommended_services'); ?>/"+model_from+"/"+invoice_id+"/"+customer_id+"/"+vehicle_id);

			});

			$(document).on('click', '.add_address', function() {
				if ($(this).attr('data-address-id')) {
					var address_id = $(this).attr('data-address-id');
					if (address_id == '' || address_id == null) {
						address_id = 0;
					}
				} else {
					var address_id = 0;
				}
				if ($(this).attr('data-model-from')) {
					var module_from = $(this).attr('data-model-from');
					if (module_from == '' || module_from == null) {
						module_from = 0;
					}
				} else {
					var module_from = 0;
				}
				if ($(this).attr('data-model-type')) {
					var module_type = $(this).attr('data-model-type');
					if (module_type == '' || module_type == null) {
						module_type = 0;
					}
				} else {
					var module_type = 0;
				}
				$('#modal-placeholder').load("<?php echo site_url('user_address/ajax/modal_add_address'); ?>/" + $(this).attr('data-customer-id') + "/" + address_id + "/" + module_from + "/" + module_type);
			});

			//update_delivery_status
			$(document).on('click', '.update_delivery_status', function() {
				//console.log("sdsadsads");
				$('#modal-placeholder').load("<?php echo site_url('user_appointments/ajax/update_delivery_status/'); ?>" + $(this).attr("data-quote-id"));
			});

			//update payment
			$(document).on('click', '.update_payment_status', function() {
				//console.log("sdsadsads");
				$('#modal-placeholder').load("<?php echo site_url('user_appointments/ajax/update_payment_status/'); ?>" + $(this).attr("data-quote-id"));
			});


			$(document).on('click', '.add_status', function() {
				//console.log("sdsadsads");
				$('#modal-placeholder').load("<?php echo site_url('user_appointments/ajax/modal_add_status/'); ?>" + $(this).attr("data-quote-id"));
			});

			$(document).on('click', '.order_history', function() {
				$('#modal-placeholder').load("<?php echo site_url('user_appointments/ajax/status_history/'); ?>" + $(this).attr("data-quote-id"));
			});

			$(document).on('click', '#generate_invoice', function() {
				$('#modal-placeholder').load("<?php echo site_url('mech_invoices/ajax/modal_generate_invoice'); ?>");
			});

			$(document).on('click', '.add_reduce_stock', function() {
				$('#modal-placeholder').load("<?php echo site_url('mech_item_master/ajax/modal_add_reduce_stock/'); ?>" + $(this).attr("data-product-id") + "/" + $(this).attr("data-action-type") + "/" + $(this).attr("data-purchase-price") + "/" + $(this).attr("data-page-from"));
			});
			$(document).on('click', '.add_bank', function() {

				if ($(this).attr("data-entity-id")) {
					var entity_id = $(this).attr("data-entity-id");
				} else {
					var entity_id = 0;
				}

				if ($(this).attr("data-module-type")) {
					var module_type = $(this).attr("data-module-type");
				} else {
					var module_type = 0;
				}

				if ($(this).attr("data-bank-id")) {
					var bank_id = $(this).attr("data-bank-id");
				} else {
					var bank_id = 0;
				}

				$('#modal-placeholder').load("<?php echo site_url('mech_bank_list/ajax/model_add_bank/'); ?>" + module_type + "/" + bank_id + "/" + entity_id);
			});

			$(document).on('click', '.add_skill', function() {
				$('#modal-placeholder').load("<?php echo site_url('mech_employee/ajax/model_add_skill/'); ?>" + $(this).attr("data-employee-id") + "/" + $(this).attr("data-model-from"));
			});

			$(document).on('click', '.add_expense_type', function() {
				$('#modal-placeholder').load("<?php echo site_url('mech_expense/ajax/model_add_expensetype'); ?>");
			});

			$(document).on('click', '.add_customer_category', function() {
				$('#modal-placeholder').load("<?php echo site_url('clients/ajax/add_customer_category'); ?>");
			});

			$(document).on('click', '.add_supplier_category', function() {
				$('#modal-placeholder').load("<?php echo site_url('suppliers/ajax/add_supplier_category'); ?>");
			});

			$(document).on('click', '.add_employee_role', function() {
				$('#modal-placeholder').load("<?php echo site_url('mech_employee/ajax/add_employee_role'); ?>");
			});

			$(document).on('click', '.add_tax', function() {

				if ($(this).attr("data-tax-id")) {
					var tax_id = $(this).attr("data-tax-id");
				} else {
					var tax_id = 0;
				}
				$('#modal-placeholder').load("<?php echo site_url('mech_tax/ajax/model_add_tax/'); ?>"+ tax_id);
			});

			$(document).on('click', '.add_experience', function() {

				if ($(this).attr("data-employee-id")) {
					var employee_id = $(this).attr("data-employee-id");
				} else {
					var employee_id = 0;
				}

				if ($(this).attr("data-model-from")) {
					var model_from = $(this).attr("data-model-from");
				} else {
					var model_from = 0;
				}

				if ($(this).attr("data-experience-id")) {
					var emp_experience_id = $(this).attr("data-experience-id");
				} else {
					var emp_experience_id = 0;
				}

				$('#modal-placeholder').load("<?php echo site_url('mech_employee/ajax/model_add_experience/'); ?>" + employee_id + "/" + model_from + "/" + emp_experience_id);
			});

			// $(document).on('click', '.remove_added_item', function() {
			// 	$(this).parent().parent().remove();
			// 	service_calculation();
			// 	product_calculation();
			// });

			// $(document).on('click', '.pur_remove_added_item', function() {
			// 	$(this).parent().parent().remove();
			// 	product_calculation();
			// });

		});

	function formatDate(date){


		if(date == "" || date == null || date == "null" || date == "0000-00-00"){
			return "";
		}

	    var dt = new Date(date);
	    var dtd = dt.getDate();
	    var dtm = dt.getMonth()+1;
		var dty = dt.getFullYear();

		var formatedDate = "";
        <?php if($this->session->userdata('default_php_date_format') == 'd/m/Y'){ ?>
			formatedDate = ('0' + dtd).slice(-2) + "/" + ('0' + dtm).slice(-2) + "/" + dty;	
        <?php } elseif($this->session->userdata('default_php_date_format') == 'm/d/Y'){ ?>
			formatedDate = ('0' + dtm).slice(-2) + "/" + ('0' + dtd).slice(-2)  + "/" + dty;	
        <?php } elseif($this->session->userdata('default_php_date_format') == 'd/Y/m'){ ?>
			formatedDate = ('0' + dtd).slice(-2) + "/"  +dty + "/" + ('0' + dtm).slice(-2);	
        <?php } elseif($this->session->userdata('default_php_date_format') == 'm/Y/d'){ ?>
			formatedDate = ('0' + dtm).slice(-2) + "/" + dty + "/" + ('0' + dtd).slice(-2) ;	
        <?php } elseif($this->session->userdata('default_php_date_format') == 'Y/m/d'){ ?>
			formatedDate = dty + "/" + ('0' + dtm).slice(-2) + "/" + ('0' + dtd).slice(-2) ;	
        <?php }elseif($this->session->userdata('default_php_date_format') == 'Y/d/m'){ ?>
			formatedDate = dty + "/" + ('0' + dtd).slice(-2) + "/" + ('0' + dtm).slice(-2);	
        <?php } elseif($this->session->userdata('default_php_date_format') == 'd-m-Y'){ ?>
	    	formatedDate = ('0' + dtd).slice(-2) + "-" + ('0' + dtm).slice(-2) + "-" + dty;	
        <?php } elseif($this->session->userdata('default_php_date_format') == 'm-d-Y'){ ?>
	    	formatedDate = ('0' + dtm).slice(-2) + "-" + ('0' + dtd).slice(-2)  + "-" + dty;	
	    <?php } elseif($this->session->userdata('default_php_date_format') == 'd-Y-m'){ ?>
            formatedDate = ('0' + dtd).slice(-2) + "-"  +dty + "-" + ('0' + dtm).slice(-2);	
	    <?php } elseif($this->session->userdata('default_php_date_format') == 'm-Y-d'){ ?>
            formatedDate = ('0' + dtm).slice(-2) + "-" + dty + "-" + ('0' + dtd).slice(-2) ;	
        <?php } elseif($this->session->userdata('default_php_date_format') == 'Y-m-d'){ ?>
            formatedDate = dty + "-" + ('0' + dtm).slice(-2) + "-" + ('0' + dtd).slice(-2) ;	
        <?php }elseif($this->session->userdata('default_php_date_format') == 'Y-d-m'){ ?>
            formatedDate = dty + "-" + ('0' + dtd).slice(-2) + "-" + ('0' + dtm).slice(-2);	
        <?php } else { ?>
	    	formatedDate = dty + "-" + ('0' + dtm).slice(-2) + "-" +  ('0' + dtd).slice(-2);
		<?php } ?>
		
		return formatedDate;
	    
	}


	function coverttimedate(data){
	var today = new Date(data);
	var day = today.getDate() + "";
	var month = (today.getMonth() + 1) + "";
	var year = today.getFullYear() + "";
	var hour = today.getHours() + "";
	var minutes = today.getMinutes() + "";
	var seconds = today.getSeconds() + "";

	day = checkZero(day);
	month = checkZero(month);
	year = checkZero(year);
	hour = checkZero(hour);
	mintues = checkZero(minutes);
	seconds = checkZero(seconds);

	if (hour == 0)
	{
		hour = 12;
	}
	if (hour > 12)
	{
		hour = hour - 12;
	}

	var form = day + "-" + month + "-" + year + " " + hour + ":" + minutes + ":" + seconds;
	return form;
}

function checkZero(data){
	
  if(data.length == 1){
    data = "0" + data;
  }
  return data;
}

function formatDatetimechange(date){


if(date == "" || date == null || date == "null" || date == "0000-00-00"){
	return "";
}

var dt = new Date(date);
var dtd = dt.getDate();
var dtm = dt.getMonth()+1;
var dty = dt.getFullYear();
var dhr = dt.getHours();
var dmt = dt.getMinutes();
var dsec = dt.getSeconds();
var time = dt.getTime();
formatedDate = ('0' + dtd).slice(-2) + "-" + ('0' + dtm).slice(-2) + "-" + dty +" "+ ('0' + dhr).slice(-2) + ":" + ('0' + dmt).slice(-2) + ":" +('0' + dsec).slice(-2);	
// console.log(formatedDate);
return formatedDate;

}





function format_money(num, decimal_point) {
	if(parseFloat(num) < 10){
		return parseFloat(num).toFixed(2);
	}
	num=num.toString();
	if(num != ''){
		var sign = null;
		if (num == 0 || num == '0') {
			num = '0.00';
		}
		if (decimal_point == '' || decimal_point == '0' || decimal_point == '2' || decimal_point == 2 || decimal_point == 0 || decimal_point == null) {
			decimal_point = 2;
		}
		var tokens = [];
		var append_decimal;
		if (decimal_point == '3' || decimal_point == 3) {
			append_decimal = '000';
		} else {
			append_decimal = '00';
		}
		var is_decimal=num.indexOf(".");
		if(is_decimal=='-1'||is_decimal==-1)
		{
			num=num+"."+append_decimal;
		}
		var s = (num.toString()).charAt(0);
		if (s == '-') {
			var sign = '-';
			num = (num.toString()).substr(1);
		}
		if(sign == null){
			sign = '';
		}
		temp_num = num;
		num= num.substr(0, num.indexOf('.')); 
		if(num.length > 1) {
			append_decimal= temp_num.substr(temp_num.indexOf(".") + 1);
			if(append_decimal.length != decimal_point){
				append_decimal = append_decimal.substr(0,decimal_point);
			}
		}
		if (num.length < 4) {
			return (sign +''+ num + '.' + append_decimal);
		}
		var hundreds = num.substr(num.length - 3);
		var thousands = num.substr(0,num.length-3);
		var i = 0;
		while (thousands.length > 0) {
			var temp = thousands.substr(thousands.length - 2);
			tokens[i] = temp;
			thousands = thousands.substr(0,thousands.length-2); 
			i = i + 1;
		}
		var final_value = (sign+((tokens.reverse()).join())+","+hundreds+"."+append_decimal);
		return final_value;
	} else {
		return "";
	}
}
			
function goBack() {
	window.history.back();
}
		
function replaceSymbols(value){
	var value = value;
	if(value != 0 && value != ''){
		value = value.replace("@", "%40");
	}else{
		value = 0;
	}
	return value;
}

function isNumberKey(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
	return true;
}

function remove_car(car_list_id, client_id, get_csrf_hash) {
	swal({
			title: "Are you sure?",
			text: "You will not be able to recover this imaginary file!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, delete it!",
			cancelButtonText: "No, cancel plx!",
			closeOnConfirm: false,
			closeOnCancel: false
		},
		function(isConfirm) {
			if (isConfirm) {
				$.post("<?php echo site_url('user_cars/delete'); ?>", {
						user_car_id: car_list_id,
						_mm_csrf: get_csrf_hash
					},
					function(data) {
						var response = JSON.parse(data);

						if (response.success === 1) {
							swal({
									title: "The row is deleted successfully",
									text: "Your imaginary file has been deleted.",
									type: "success",
									confirmButtonClass: "btn-success"
								},
								function() {
									setTimeout(function() {
										window.location.href = "<?php echo site_url('clients/form'); ?>/"+client_id+"/3";
									}, 1000);
								});

						} else {
							notie.alert(3, 'Error.', 2);
						}
					});


			} else {
				swal({
					title: "Cancelled",
					text: "Your imaginary file is safe :)",
					type: "error",
					confirmButtonClass: "btn-danger"
				});
			}
		});
}

function remove_address(user_address_id,client_id, get_csrf_hash) {
	swal({
			title: "Are you sure?",
			text: "You will not be able to recover this imaginary file!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, delete it!",
			cancelButtonText: "No, cancel plx!",
			closeOnConfirm: false,
			closeOnCancel: false
		},
		function(isConfirm) {
			if (isConfirm) {
				$.post("<?php echo site_url('user_address/delete'); ?>", {
						user_address_id: user_address_id,
						_mm_csrf: get_csrf_hash
					},
					function(data) {
						var response = JSON.parse(data);

						if (response.success === 1) {
							swal({
									title: "The row is deleted successfully",
									text: "Your imaginary file has been deleted.",
									type: "success",
									confirmButtonClass: "btn-success"
								},
								function() {
									setTimeout(function() {
										window.location.href = "<?php echo site_url('clients/form'); ?>/"+client_id+"/2";
									}, 1000);
								});

						} else {
							notie.alert(3, 'Error.', 2);
						}
					});


			} else {
				swal({
					title: "Cancelled",
					text: "Your imaginary file is safe :)",
					type: "error",
					confirmButtonClass: "btn-danger"
				});
			}
		});
}

function remove_employee_experience(employee_id, employee_experience_id, get_csrf_hash) {
	swal({
			title: "Are you sure?",
			text: "You will not be able to recover this imaginary file!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, delete it!",
			cancelButtonText: "No, cancel plx!",
			closeOnConfirm: false,
			closeOnCancel: false
		},
		function(isConfirm) {
			if (isConfirm) {
				$.post("<?php echo site_url('mech_employee/ajax/deleteExperience'); ?>", {
						employee_experience_id: employee_experience_id,
						employee_id: employee_id,
						_mm_csrf: get_csrf_hash
					},
					function(data) {
						var response = JSON.parse(data);

						if (response.success === 1) {
							swal({
									title: "The row is deleted successfully",
									text: "Your imaginary file has been deleted.",
									type: "success",
									confirmButtonClass: "btn-success"
								},
								function() {
									setTimeout(function() {
										location.reload();
									}, 1000);
								});

						} else {
							notie.alert(3, 'Error.', 2);
						}
					});


			} else {
				swal({
					title: "Cancelled",
					text: "Your imaginary file is safe :)",
					type: "error",
					confirmButtonClass: "btn-danger"
				});
			}
		});
}

function remove_customer(client_id, get_csrf_hash) {
	swal({
			title: "Are you sure?",
			text: "You will not be able to recover this imaginary file!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, delete it!",
			cancelButtonText: "No, cancel plx!",
			closeOnConfirm: false,
			closeOnCancel: false
		},
		function(isConfirm) {
			if (isConfirm) {
				$.post("<?php echo site_url('clients/delete'); ?>", {
						client_id: client_id,
						_mm_csrf: get_csrf_hash
					},
					function(data) {
						var response = JSON.parse(data);
						if (response.success === 1) {
							swal({
									title: "The row is deleted successfully",
									text: "Your imaginary file has been deleted.",
									type: "success",
									confirmButtonClass: "btn-success"
								},
								function() {
									setTimeout(function() {
										location.reload();
									}, 1000);
								});

						} else {
							notie.alert(3, 'Error.', 2);
						}
					});
			} else {
				swal({
					title: "Cancelled",
					text: "Your imaginary file is safe :)",
					type: "error",
					confirmButtonClass: "btn-danger"
				});
			}
		});
}

function employee_delete_record(controller_name, id, get_csrf_hash) {
	var function_name = "delete";
		$.post("<?php echo site_url('mech_employee/checkEmployeeUserOrNot'); ?>", {
						employee_id: id,
						_mm_csrf: get_csrf_hash
					},
					function(data) {
						var response = JSON.parse(data);
						if (response.success == 1 || response.success == '1') {
							var text_msg = "This employee have an user account, if you delete this employee account also be deleted.";
							}else{
							var text_msg = "Your imaginary file has been deleted.";
							}
						swal({
							title: "Are you sure?",
							text: text_msg,
							type: "warning",
							showCancelButton: true,
							confirmButtonClass: "btn-danger",
							confirmButtonText: "Yes, delete it!",
							cancelButtonText: "No, cancel plx!",
							closeOnConfirm: false,
							closeOnCancel: false
						},
						function(isConfirm) {
							if (isConfirm) {
								$.post("<?php echo site_url(); ?>/"+controller_name+"/"+function_name, {
										id: id,
										_mm_csrf: get_csrf_hash
									},
									function(data) {
										var response = JSON.parse(data);

										if (response.success === 1) {
											swal({
													title: "The row is deleted successfully",
													text: "Your imaginary file has been deleted.",
													type: "success",
													confirmButtonClass: "btn-success"
												},
												function() {
													location.reload();
												});

										} else {
											notie.alert(3, 'Error.', 2);
										}
									});


							} else {
								swal({
									title: "Cancelled",
									text: "Your imaginary file is safe :)",
									type: "error",
									confirmButtonClass: "btn-danger"
								});
							}
						});
					});			
}

function cancel_purchase_order(id, get_csrf_hash) {
	swal({
		title: "Are you sure? You want to cancel this order",
		text: "You will not be able to receive your order!",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "Yes",
		cancelButtonText: "No",
		closeOnConfirm: false,
		closeOnCancel: false
	},
	function(isConfirm) {
		if (isConfirm) {
			$.post("<?php echo site_url(); ?>/mech_purchase_order/cancel_order", {
				id: id,
				_mm_csrf: get_csrf_hash
			},
			function(data) {
				var response = JSON.parse(data);
				if (response.success === 1) {
					swal({
						title: "Your order is canceled successfully",
						text: "Your imaginary file has been deleted.",
						type: "success",
						confirmButtonClass: "btn-success"
					},
					function() {
						setTimeout(function() {
							location.reload();
						}, 1000);
					});
				} else {
					notie.alert(3, 'Error.', 2);
				}
			});
		} else {
			swal({
				title: "Cancelled",
				text: "Your imaginary file is safe :)",
				type: "error",
				confirmButtonClass: "btn-danger"
			});
		}
	});
}

function delete_record(controller_name, id, get_csrf_hash) {
	
	if(controller_name == "mech_employee_exp"){
		controller_name = "mech_employee";
		var function_name = "deleteExperience";
	}else if(controller_name == "contact_reminder"){
		controller_name = "reminder";
		var function_name = "delete_contact_reminder";
	}else if(controller_name == "service_reminder"){
		controller_name = "reminder";
		var function_name = "delete_service_reminder";
	}else if(controller_name == "vehicle_reminder"){
		controller_name = "reminder";
		var function_name = "delete_vehicle_reminder";
	}else if(controller_name == "custom_reminder"){
		controller_name = "reminder";
		var function_name = "delete_custom_reminder";
	}else if(controller_name == "service_packages"){
			controller_name = "service_packages";
		var function_name = "delete";
		// controller_name = "packages";
		// var function_name = "delete_servi_packages";
	}else if(controller_name == "mech_leads_appointment"){
		controller_name = "mech_leads";
		var function_name = "delete_appointment";
	}else if(controller_name == "mech_comments"){
		controller_name = "mech_leads";
		var function_name = "delete_comments";
	}else if(controller_name == "mech_item_master"){
		controller_name = "mech_item_master";
		var function_name = "product_delete";
	}else if(controller_name == "mech_service_master"){
		controller_name = "mech_item_master";
		var function_name = "service_delete";
	}else if(controller_name == "mech_sub_item_master"){
		controller_name = "mech_item_master";
		var function_name = "delete_sub_item";
	}else if(controller_name == "mech_feedback_comments"){
		controller_name = "mech_add_feedback";
		var function_name = "delete_feedback_comments";
	}else if(controller_name == "mech_sub_service_master"){
		controller_name = "mech_item_master";
		var function_name = "delete_sub_service";
	}else{
		var function_name = "delete";
	}

	

	swal({
			title: "Are you sure?",
			text: "You will not be able to recover this imaginary file!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, delete it!",
			cancelButtonText: "No, cancel plx!",
			closeOnConfirm: false,
			closeOnCancel: false
		},
		function(isConfirm) {
			if (isConfirm) {


				$.post("<?php echo site_url(); ?>/"+controller_name+"/"+function_name, {
						id: id,
						_mm_csrf: get_csrf_hash
					},
					function(data) {
						var response = JSON.parse(data);

						if (response.success === 1) {
							swal({
									title: "The row is deleted successfully",
									text: "Your imaginary file has been deleted.",
									type: "success",
									confirmButtonClass: "btn-success"
								},
								function() {
									setTimeout(function() {
										if(controller_name == "mech_invoice_groups"){
											window.location = "<?php echo site_url('workshop_setup/index/4'); ?>";
										}else{
											location.reload();
										}
										
									}, 1000);
								});

						} else {
							notie.alert(3, 'Error.', 2);
						}
					});


			} else {
				swal({
					title: "Cancelled",
					text: "Your imaginary file is safe :)",
					type: "error",
					confirmButtonClass: "btn-danger"
				});
			}
		});
}

function update_status(type, id, get_csrf_hash) {
	
	if(type == 'C'){
		var status = 'complete';
	}else if(type == 'D'){
		var status = 'deactive';
	}else if(type == 'A'){
		var status = 'active';
	}
	swal({
			title: "Are you sure?",
			text: "you want to "+status+" this invoice group?",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes",
			cancelButtonText: "No",
			closeOnConfirm: false,
			closeOnCancel: false
		},
		function(isConfirm) {
			if (isConfirm) {

				$.post("<?php echo site_url('mech_invoice_groups/update_status'); ?>",{
						id: id,
						type:type,
						_mm_csrf: get_csrf_hash
					},
					function(data) {
						var response = JSON.parse(data);

						if (response.success === 1) {
							swal({
									title: status.charAt(0).toUpperCase()+status.slice(1),
									text: "Your imaginary file has been "+status+"",
									type: "success",
									confirmButtonClass: "btn-success"
								},
								function() {
									setTimeout(function() {
										window.location = "<?php echo site_url('workshop_setup/index/4'); ?>";
									}, 1000);
								});

						} else {
							notie.alert(3, 'Error.', 2);
						}
					});


			} else {
				swal({
					title: "Cancelled",
					text: "Your imaginary file is safe :)",
					type: "error",
					confirmButtonClass: "btn-danger"
				});
			}
		});
}

function remove_jobsheet(work_order_id, get_csrf_hash) {
	swal({
			title: "Are you sure?",
			text: "You will not be able to recover this imaginary file!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, delete it!",
			cancelButtonText: "No, cancel plx!",
			closeOnConfirm: false,
			closeOnCancel: false
		},
		function(isConfirm) {
			if (isConfirm) {
				$.post("<?php echo site_url('mech_work_order_dtls/delete'); ?>", {
						work_order_id: work_order_id,
						_mm_csrf: get_csrf_hash
					},
					function(data) {
						var response = JSON.parse(data);

						if (response.success === 1) {
							swal({
									title: "The row is deleted successfully",
									text: "Your imaginary file has been deleted.",
									type: "success",
									confirmButtonClass: "btn-success"
								},
								function() {
									setTimeout(function() {
										location.reload();
									}, 1000);
								});

						} else {
							notie.alert(3, 'Error.', 2);
						}
					});


			} else {
				swal({
					title: "Cancelled",
					text: "Your imaginary file is safe :)",
					type: "error",
					confirmButtonClass: "btn-danger"
				});
			}
		});
}


function remove_bank(bank_id, get_csrf_hash) {
	swal({
			title: "Are you sure?",
			text: "You will not be able to recover this imaginary file!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, delete it!",
			cancelButtonText: "No, cancel plx!",
			closeOnConfirm: false,
			closeOnCancel: false
		},
		function(isConfirm) {
			if (isConfirm) {
				$.post("<?php echo site_url('mech_bank_list/ajax/delete'); ?>", {
						bank_id: bank_id,
						_mm_csrf: get_csrf_hash
					},
					function(data) {
						var response = JSON.parse(data);

						if (response.success === 1) {
							swal({
									title: "The row is deleted successfully",
									text: "Your imaginary file has been deleted.",
									type: "success",
									confirmButtonClass: "btn-success"
								},
								function() {
									setTimeout(function() {
										location.reload();
									}, 1000);
								});

						} else {
							notie.alert(3, 'Error.', 2);
						}
					});


			} else {
				swal({
					title: "Cancelled",
					text: "Your imaginary file is safe :)",
					type: "error",
					confirmButtonClass: "btn-danger"
				});
			}
		});
}

function remove_tax(tax_id, get_csrf_hash) {
	swal({
			title: "Are you sure?",
			text: "You will not be able to recover this imaginary file!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, delete it!",
			cancelButtonText: "No, cancel plx!",
			closeOnConfirm: false,
			closeOnCancel: false
		},
		function(isConfirm) {
			if (isConfirm) {
				$.post("<?php echo site_url('mech_tax/ajax/delete'); ?>", {
					tax_id: tax_id,
						_mm_csrf: get_csrf_hash
					},
					function(data) {
						var response = JSON.parse(data);

						if (response.success === 1) {
							swal({
									title: "The row is deleted successfully",
									text: "Your imaginary file has been deleted.",
									type: "success",
									confirmButtonClass: "btn-success"
								},
								function() {
									setTimeout(function() {
										location.reload();
									}, 1000);
								});

						} else {
							notie.alert(3, 'Error.', 2);
						}
					});


			} else {
				swal({
					title: "Cancelled",
					text: "Your imaginary file is safe :)",
					type: "error",
					confirmButtonClass: "btn-danger"
				});
			}
		});
}


function remove_sub_item(item_id, modulename, functionname,  get_csrf_hash) {
	swal({
			title: "Are you sure?",
			text: "You will not be able to recover this item!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, delete it!",
			cancelButtonText: "No, cancel plx!",
			closeOnConfirm: false,
			closeOnCancel: false
		},
		function(isConfirm) {
			if (isConfirm) {
				$.post("<?php echo site_url(); ?>/"+modulename+"/"+functionname+"", {
						id: item_id,
						_mm_csrf: get_csrf_hash
					},
					function(data) {
						var response = JSON.parse(data);
						if (response.success === 1) {
							swal({
									title: "The row is deleted successfully",
									text: "Item has been deleted.",
									type: "success",
									confirmButtonClass: "btn-success"
								},
								function() {
									$("#product_item_table #tr_"+item_id).remove();
								});
						} else {
							notie.alert(3, 'Error.', 2);
						}
					});
			} else {
				swal({
					title: "Cancelled",
					text: "Your imaginary file is safe :)",
					type: "error",
					confirmButtonClass: "btn-danger"
				});
			}
		});
}


function remove_item(item_id, type, modulename, get_csrf_hash) {
	swal({
			title: "Are you sure?",
			text: "You will not be able to recover this item!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, delete it!",
			cancelButtonText: "No, cancel plx!",
			closeOnConfirm: false,
			closeOnCancel: false
		},
		function(isConfirm) {
			if (isConfirm) {
				$.post("<?php echo site_url(); ?>/" + modulename + "/ajax/delete_item", {
						item_id: item_id,
						_mm_csrf: get_csrf_hash
					},
					function(data) {
						var response = JSON.parse(data);
						if (response.success === 1) {
							swal({
									title: "The row is deleted successfully",
									text: "Item has been deleted.",
									type: "success",
									confirmButtonClass: "btn-success"
								},
								function() {
									if(type == "prod"){
										remove_product($("#item_product_id_"+item_id).val(),item_id);
									}else if(type == "service"){
										remove_service($("#item_service_id_"+item_id).val(),item_id);
									}else{
										remove_package($("#item_service_id_"+item_id).val(),item_id);
									}
								});
						} else {
							notie.alert(3, 'Error.', 2);
						}
					});
			} else {
				swal({
					title: "Cancelled",
					text: "Your imaginary file is safe :)",
					type: "error",
					confirmButtonClass: "btn-danger"
				});
			}
		});
}

function remove_entity(document_id, modulename, document, get_csrf_hash) {
	swal({
			title: "Are you sure?",
			text: "You will not be able to recover this " + document + "!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes, delete it!",
			cancelButtonText: "No, cancel plx!",
			closeOnConfirm: false,
			closeOnCancel: false
		},
		function(isConfirm) {
			if(isConfirm) {
				$.post("<?php echo site_url(); ?>/" + modulename + "/ajax/delete", {
					document_id: document_id,
					_mm_csrf: get_csrf_hash
				},
				function(data) {
					var response = JSON.parse(data);
					// console.log(response);
					if (response.success === 1) {
						swal({
								title: "The row is deleted successfully",
								text: document + " has been deleted.",
								type: "success",
								confirmButtonClass: "btn-success"
							},
							function() {
								setTimeout(function() {
									location.reload();
								}, 500);
							});

					} else {
						notie.alert(3, 'Error.', 2);
					}
				});
			} else {
				swal({
					title: "Cancelled",
					text: "Your imaginary file is safe :)",
					type: "error",
					confirmButtonClass: "btn-danger"
				});
			}
		});
}
</script>
