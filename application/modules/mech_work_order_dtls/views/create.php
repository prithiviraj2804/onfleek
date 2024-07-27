<style type="text/css">
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
}
#product_item_table input {
    padding-left: 0px;
    padding-right: 0px;
}
</style>
<script type="text/javascript">
	var advance_paid_amount = '<?php echo $work_order_detail->advance_paid?$work_order_detail->advance_paid:0; ?>';
	var total_due_amount = '<?php echo $work_order_detail->total_due_amount?$work_order_detail->total_due_amount:0; ?>';
	var currency_symbol = "<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;";
	var default_currency_digit  = parseInt('<?php echo $this->session->userdata("default_currency_digit")?$this->session->userdata("default_currency_digit"):0;?>');
	var getServiceDetailsURL = '<?php echo site_url('mech_item_master/ajax/getServiceDetails'); ?>';
	var getProductDetailsURL = '<?php echo site_url('mech_item_master/ajax/get_product_details'); ?>';
	var getServicePackageDetailsURL = '<?php echo site_url('service_packages/ajax/get_package_details'); ?>';
	var taxURL = '<?php echo site_url('mech_tax/ajax/gettaxDetails');?>';

function getDeleteUploadFIle(id,type,url_key)
{
	 
	$("#file").val('');
	var work_order_id = $("#work_order_id").val();

	$.post('<?php echo site_url('upload/getDeleteUploadData'); ?>', {
		entity_id : work_order_id,
		upload_id : id,
		upload_type : type,
		entity_type: 'J',
		url_key :url_key,
		_mm_csrf: $('#_mm_csrf').val()
    }, function (data) {
		list = JSON.parse(data);
        if(list.success=='1'){
     		if(list.doclist.length > 0)
    	    {
      	      	var htmlStr = '';
      	      	var href = '<?php echo base_url()."uploads/jobcard_files/";?>';
      	    	htmlStr += '<h4>Uploaded Files</h4>';
      	  		htmlStr += '<table class="car-table-box col-lg-12 col-md-12 col-sm-12 col-xs-12">';
      			htmlStr += '<thead>';
      			htmlStr += '<tr>';
      			htmlStr += '<th>Document Type</th>';
      			htmlStr += '<th>Document Name</th>';
      			htmlStr += '<th align="center" class="text-center">Document Image</th>';
      			htmlStr += '<th align="center" class="text-center">Option</th>';
      			htmlStr += '</tr>';
      			htmlStr += '</thead>';
      			htmlStr += '<tbody id="uploaded_datas">';
      	      	for(var i = 0; i < list.doclist.length; i++){
      	    		htmlStr +='<tr>';
      	    		htmlStr += '<td><span>'+list.doclist[i].document_name+'</span></td>';
      	    		htmlStr += '<td><span>'+list.doclist[i].file_name_original+'</span></td>';
      	    		htmlStr += '<td align="center" class="text-center" ><span style="cursor: pointer">';
      	    		htmlStr += '<a href="'+href+''+list.doclist[i].file_name_new+'" target="_blank" >';
      	    		htmlStr += '<img src="'+href+''+list.doclist[i].file_name_new+'" width="50" height="50">';
      	    		htmlStr += '</a>';
      	    		htmlStr += '</span></td>';
      	    		htmlStr += '<td align="center" class="text-center"><span style="cursor: pointer" onclick="getDeleteUploadFIle(\''+list.doclist[i].upload_id+'\',\'D\',\''+url_key+'\')"><i class="fa fa-trash-o" aria-hidden="true"></i></span></td>';
      	    		htmlStr += '</tr>';
      	      	}
      	    	htmlStr += '</tbody>';
      	  		htmlStr += '</table>';
      	      
      		  $("#preview_section").empty().append(htmlStr);
      		  
      	  	}else{
      		 	$("#preview_section").empty().append('<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" > No document found </div>');
      	  	}
      	  	$("#document_name").val('');
        }
    });
}

function getModelList(){
		$('#gif').show();
		$.post("<?php echo site_url('user_cars/ajax/get_brand_models'); ?>", {
			brand_id: $('#brand_id').val(),
			_mm_csrf: $('#_mm_csrf').val()
		},function (data) {
			var response = JSON.parse(data);
			$('#variant_id').empty();
			$('#variant_id').append($('<option></option>').attr('value', '').text('Select Variant'));
			$('#variant_id').selectpicker("refresh");
			if(response.length > 0) {
				$('#gif').hide();
				$('#model_id').empty(); // clear the current elements in select box
				$('#model_id').append($('<option></option>').attr('value', '').text('Select Model'));
		       	for (row in response) {
		       		$('#model_id').append($('<option></option>').attr('value', response[row].model_id).text(response[row].model_name));
				}
				$('#model_id').selectpicker("refresh");
				getproductsByFilter();
         	}else{
				$('#gif').hide();
				$('#model_id').empty(); // clear the current elements in select box
				$('#model_id').append($('<option></option>').attr('value', '').text('Select Model'));
				$('#model_id').selectpicker("refresh");
           	}
		});
	}

	function getvariantList(){
		$('#gif').show();
		$.post("<?php echo site_url('user_cars/ajax/get_brand_model_variant'); ?>", {
			brand_id: $('#brand_id').val(),
			model_id: $('#model_id').val(),
			_mm_csrf: $('#_mm_csrf').val()
		},function (data) {
        	var response = JSON.parse(data);
           	if (response.length > 0) {
				$('#gif').hide();
          		$('#variant_id').empty(); // clear the current elements in select box
            	$('#variant_id').append($('<option></option>').attr('value', '').text('Select Variant'));
	        	for (row in response) {
	           		$('#variant_id').append($('<option></option>').attr('value', response[row].brand_model_variant_id).text(response[row].variant_name));
				}
				$('#variant_id').selectpicker("refresh");
				getproductsByFilter();
         	}else {
				$('#gif').hide();
				$('#variant_id').empty(); // clear the current elements in select box
            	$('#variant_id').append($('<option></option>').attr('value', '').text('Select variant'));
				$('#variant_id').selectpicker("refresh");
            }
		});
	}
	
function getproductsByFilter(){

	// if($("#user_car_list_id").val() == ''){
	//     notie.alert(3, '<?php // _trans('toaster5'); ?>', 2);
	//     $("#service_category_id").val(0);
	//     $('.bootstrap-select').selectpicker("refresh");
	//     return false;
	// }
	$('#gif').show();
	$.post("<?php echo site_url('mech_item_master/ajax/getProductItemList'); ?>", {
		product_category_id: $('#product_category_id').val()?$('#product_category_id').val():'',
		product_brand_id: $("#product_brand_id").val()?$("#product_brand_id").val():'',
		user_car_list_id: $('#user_car_list_id').val()?$('#user_car_list_id').val():'',
		_mm_csrf: $('#_mm_csrf').val()
	},function (data) {
		var response = JSON.parse(data);
		if (response) {
			$('#gif').hide();
			$('#services_item_product_id').empty(); // clear the current elements in select box
			$('#services_item_product_id').append($('<option></option>').attr('value', '').text('Item'));
			for (row in response) {
				$('#services_item_product_id').append($('<option></option>').attr('value', response[row].product_id).text(response[row].product_name));
			}
			$('#services_item_product_id').selectpicker("refresh");
		}else{
			$('#gif').hide();
			$('#services_item_product_id').empty(); // clear the current elements in select box
			$('#services_item_product_id').append($('<option></option>').attr('value', '').text('Item'));
			$('#services_item_product_id').selectpicker("refresh");
		}
	});
}

$(function () {
    $('#btn-cancel').click(function () {
        <?php if($url_from == 'q'){ ?>
            window.location = "<?php echo site_url('mech_work_order_dtls'); ?>";
        <?php }elseif($url_from == 'r'){ ?>
            window.location = "<?php echo site_url('mech_work_order_dtls/status/request'); ?>";
        <?php }elseif($url_from == 'p'){ ?>
            window.location = "<?php echo site_url('mech_work_order_dtls/status/pending'); ?>";
        <?php }elseif($url_from == 'app'){ ?>
            window.location = "<?php echo site_url('user_appointments'); ?>";
        <?php } ?>
            
     });
});
</script>
<script src="<?php echo base_url(); ?>assets/mp_backend/js/services.js"></script>
<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell" id="total_user_quote">
                    <h3><?php _trans($breadcrumb);?><?php if($work_order_detail->jobsheet_no) { echo " - ".$work_order_detail->jobsheet_no; } ?></h3>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="row">
	<div id="gif" class="gifload">
		<div class="gifcenter">
			<center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
		</div>
	</div>
	<div class="col-xs-12 top-15">
		<a class="anchor anchor-back" href="<?php echo site_url('mech_work_order_dtls/index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
	</div>
</div>

<div class="container-fluid usermanagement">
	<div class="paddingTop22px"> 
		<section class="card col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-centered">
            <div class="card-block invoice">
                <div class="row invoice-company_details">
                    <div class="col-lg-12">
                        <div class="company_logo">
                            <?php $company_details = $this->mdl_workshop_branch->get_company_branch_details(); 
                            if($company_details->workshop_logo){ ?>
                            <img src="<?php echo base_url(); ?>uploads/workshop_logo/<?php echo $company_details->workshop_logo; ?>" width="150" height="150" alt="<?php echo $company_details->workshop_name; ?>">
                            <?php } ?>
                        </div>
                        <div class="clearfix company_address">
                            <div class="text-lg-right text_align_right">
                                <h4><?php echo $company_details->workshop_name; ?></h4>
                                <span>
                                    <?php if($company_details->branch_street){ echo $company_details->branch_street; }
                                    if($company_details->area_name){ echo ", ".$company_details->area_name; }
                                    if($company_details->state_name){ echo ", ".$company_details->state_name; }
                                    if($company_details->branch_pincode){ echo " - ".$company_details->branch_pincode; }
                                    if ($company_details->branch_country) {echo ' - '.$company_details->name;}  ?>
                                </span>
                                <?php if($company_details->branch_contact_no){ echo '<span>'.$company_details->branch_contact_no.'</span>'; } ?>
                                <?php if($company_details->branch_email_id){ echo '<span>'.$company_details->branch_email_id.'</span>'; } ?>
                                <?php if($company_details->branch_gstin){ echo '<span>'.$company_details->branch_gstin.'</span>'; } ?>
                            </div>   
                        </div>
                    </div>
                </div>
				
                <div class="row m-b-1">
					<div class="row">
						<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<label class="form_label"><?php _trans('lable51'); ?>*</label>
							<div class="form_controls">
								<select id="branch_id" name="branch_id" class="job_terms bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
								    <?php if(count($branch_list) > 1){ ?> 
									<option value=""><?php _trans('lable51'); ?></option>
									<?php } ?>									<?php foreach ($branch_list as $branchLists) {?>
									<option data-terms-condition="<?php echo $branchLists->job_description; ?>" value="<?php echo $branchLists->w_branch_id; ?>" <?php if($work_order_detail->branch_id == $branchLists->w_branch_id){echo "selected";}?> > <?php echo $branchLists->display_board_name; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<label class="form_label"><?php _trans('lable276'); ?>*</label>
							<div class="form_controls">
								<select name="invoice_group_id" id="invoice_group_id" <?php if($work_order_detail->work_order_status == 'G' && $work_order_detail->work_order_status != ''){ echo 'disabled'; } ?> class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
									<?php if(count($invoice_group) > 1){ ?> 
									<option value=""><?php _trans('lable277'); ?></option>
									<?php } ?>
									<?php foreach ($invoice_group as $invoice_group_list) {
										if (!empty($work_order_detail)) {
											if ($work_order_detail->invoice_group_id == $invoice_group_list->invoice_group_id) {
												$selected = 'selected="selected"';
											} else {
												$selected = '';
											}
										} else {
											$selected = '';
										} ?>
									<option value="<?php echo $invoice_group_list->invoice_group_id; ?>" <?php echo $selected; ?>><?php echo $invoice_group_list->invoice_group_name; ?></option>
									<?php
									} ?>
								</select>
							</div>
						</div>
						<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<label class="form_label"><?php _trans('lable278'); ?>*</label>
							<div class="form_controls">
								<input type="text" name="issue_date" id="issue_date" class="form-control removeErrorInput datepicker" value="<?php echo $work_order_detail->issue_date?date_from_mysql($work_order_detail->issue_date):date_from_mysql(date('Y-m-d')); ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<label class="form_label"><?php _trans('lable279'); ?>*</label>
							<div class="form_controls">
								<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
								<input type="hidden" name="work_order_url_key" id="work_order_url_key" value="<?php echo $work_order_detail->url_key?$work_order_detail->url_key:$this->mdl_mech_work_order_dtls->get_url_key(); ?>" />
								<input type="hidden" name="jobsheet_no" id="jobsheet_no" value="<?php echo $work_order_detail->jobsheet_no; ?>" >
								<input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo $invoice_id; ?>" />
								<input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $work_order_detail->invoice_no; ?>" />
								<input type="hidden" name="work_order_id" id="work_order_id" value="<?php echo $work_order_detail->work_order_id; ?>" />
								<input type="hidden" name="upload_ids" id="upload_ids" value="<?php echo $work_order_detail->upload_ids; ?>" />
								<input type="hidden" name="term_val" id="term_val" value="<?php echo $work_order_detail->job_terms_condition; ?>" autocomplete="off"/>
								<input type="hidden" name="refered_by_type" id="refered_by_type" value="<?php echo $work_order_detail->refered_by_type; ?>" />
								<input type="hidden" name="refered_by_id" id="refered_by_id" value="<?php echo $work_order_detail->refered_by_id; ?>" />

								<select name="customer_id" id="customer_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
									<option value=""><?php _trans('lable272'); ?></option>
									<?php foreach ($customer_list as $customer){ ?>
										<option value="<?php echo $customer->client_id; ?>" <?php if($work_order_detail->customer_id == $customer->client_id){ echo "selected";} ?>><?php echo ($customer->client_name?$customer->client_name:"").' '.($customer->client_contact_no?"(".$customer->client_contact_no.")":""); ?></option>
									<?php } ?>
								</select>
								<div class="col-lg-12 paddingTop5px paddingLeft0px">
									<a class="fontSize_85rem float_left add_client_page" href="javascript:void(0)" data-toggle="modal" data-model-from="jobcard" data-target="#addNewCar">
										+ <?php _trans('lable48'); ?>
									</a>
								</div>
							</div>
						</div>
						<?php if($work_order_detail->customer_id > 0){
							$show = "display:block";
						}else{
							$show = "display:none";
						} ?>
						<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<label class="form_label"><?php _trans('lable280'); ?>*</label>
							<div class="form_controls">
								<select name="customer_car_id" id="customer_car_id" class="dropdown_validation bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
									<option value=""><?php _trans('lable281'); ?></option>
									<?php foreach ($user_cars as $cars) {
										if (!empty($work_order_detail)) {
											if ($work_order_detail->customer_car_id == $cars->car_list_id) {
												$selected = 'selected="selected"';
											} else {
												$selected = '';
											}
										} else {
											$selected = '';
										} ?>
									<option value="<?php echo $cars->car_list_id; ?>" <?php echo $selected; ?>><?php echo ($cars->brand_name.', '.$cars->model_name.''.($cars->variant_name?", ".$cars->variant_name:"").', '.$cars->car_reg_no); ?></option>
									<?php } ?>
								</select>
								<div class="col-lg-12 paddingTop5px paddingLeft0px">
									<a class="addcarpopuplink fontSize_85rem float_left add_car" href="javascript:void(0)" data-toggle="modal" data-model-from="jobcard" data-customer-id="<?php echo $work_order_detail->customer_id; ?>" data-target="#addNewCar">+ <?php _trans('lable46'); ?></a>
								</div>
							</div>
						</div>
						<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<label class="form_label"><?php _trans('lable61'); ?></label>
							<div class="form_controls">
								<select name="user_address_id" id="user_address_id" class="dropdown_validation bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
									<option value=""><?php _trans('lable282'); ?></option>
									<?php foreach ($address_dtls as $address) {
											$full_address = $address->customer_street_1.' '.($address->customer_street_2?",".$address->customer_street_2:"").' ,'.$address->area.' ,'.$address->zip_code;
											?>
									<option value="<?php echo $address->user_address_id; ?>" <?php if($work_order_detail->user_address_id == $address->user_address_id){ echo "selected"; } ?>><?php echo $full_address; ?></option>
									<?php } ?>
								</select>
								<div class="col-lg-12  paddingTop5px paddingLeft0px">
									<a class="fontSize_85rem add_address addcarpopuplink float_left" href="javascript:void(0)" data-model-from="jobcard" data-customer-id="<?php echo $work_order_detail->customer_id; ?>" data-toggle="modal" data-target="#addAddress">
										+ <?php _trans('lable45'); ?>
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<label class="form_label"><?php _trans('lable283'); ?></label>
							<div class="form_controls">
								<input type="text" name="current_odometer_reading" id="current_odometer_reading" class="form-control" value="<?php echo $work_order_detail->current_odometer_reading;?>">
							</div>
						</div>
						<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<label class="form_label"><?php _trans('lable299'); ?></label>
							<div class="form_controls">
								<input type="text" name="next_service_dt" id="next_service_dt" class="form-control removeErrorInput datepicker" value="<?php echo $work_order_detail->next_service_dt?date_from_mysql($work_order_detail->next_service_dt):date_from_mysql(date('Y-m-d')); ?>" autocomplete="off">
							</div>
						</div>
						<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<label class="form_label"><?php _trans('lable284'); ?></label>
							<div class="form_controls">
								<select class="dropdown_validation bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" name="fuel_level" id="fuel_level">
									<option value=""><?php _trans('lable286'); ?></option>
									<?php for ($i = 0; $i < 20; $i += 0.5) { 
										$selected = '';
										if ($work_order_detail) {
											if ($work_order_detail->fuel_level == $i) {
												$selected = 'selected="selected"';
											}
										} ?>
									<option value="<?php echo $i; ?>" <?php echo $selected; ?>> <?php echo $i; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>	
					<div class="row">
						<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<label class="form_label"><?php _trans('lable19'); ?>*</label>
							<div class="form_controls">
								<input type="hidden" id="ex_jobsheet_status" value="<?php echo $work_order_detail->jobsheet_status;?>" >
									<select name="jobsheet_status" id="jobsheet_status" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
									<option value=""><?php _trans('lable285'); ?></option>
										<?php foreach ($job_status as $jobcard_status){
											if($work_order_detail->jobsheet_status == $jobcard_status->jobcard_status_id){
												$selected = 'selected="selected"';
											}else{
												$selected = '';
											}
										?>
										<option value="<?php echo $jobcard_status->jobcard_status_id; ?>" <?php echo $selected; ?>><?php echo $jobcard_status->status_name;  ?></option>
										<?php } ?>
									</select>
							</div>
						</div>
						<div>
							<input type="hidden" class="form_label" name="work_from" value="<?php echo $work_order_detail->work_from; ?>" id="work_from"/>
							<input type="hidden" class="form_label" name="work_from_id" value="<?php echo $work_order_detail->work_from_id; ?>" id="work_from_id"/>
						</div>
						<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<label class="form_label"><?php _trans('lable287'); ?></label>
							<div class="form_controls">
								<select name="issued_by" id="issued_by" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
									<option value=""><?php _trans('lable288'); ?></option>
									<?php foreach ($issued_by as $issued_by_list) { ?>
									<option value="<?php echo $issued_by_list->user_id; ?>" <?php if($work_order_detail->issued_by == $issued_by_list->user_id){ echo "selected"; }?> ><?php echo $issued_by_list->user_name; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<label class="form_label"><?php _trans('lable289'); ?></label>
							<div class="form_controls">
								<input type="text" name="start_date" id="start_date" class="form-control" value="<?php echo $work_order_detail->start_date?$work_order_detail->start_date:''; ?>">
							</div>
						</div>
					</div>		
					<div class="row">
					    <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<label class="form_label"><?php _trans('lable290'); ?></label>
							<div class="form_controls">
								<input type="text" name="end_date" id="end_date" class="form-control" value="<?php echo $work_order_detail->end_date?$work_order_detail->end_date:''; ?>">
							</div>
						</div>
						<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<label class="form_label"><?php _trans('lable292'); ?></label>
							<div class="form_controls">
								<select name="assigned_to" id="assigned_to" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
									<option value=""><?php _trans('lable293'); ?></option>
									<?php foreach ($assigned_to as $assigned_to_list) {?>
									<option value="<?php echo $assigned_to_list->employee_id; ?>" <?php if($work_order_detail->assigned_to == $assigned_to_list->employee_id){ echo "selected"; }?> ><?php echo $assigned_to_list->employee_name; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
							<label class="form_label"><?php _trans('lable294'); ?></label>
							<div class="form_controls">
								<select name="invoice_number" id="invoice_number" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
									<option value=""><?php _trans('lable295'); ?></option>
									<?php foreach ($invoice_number_list as $invList) {
										if(empty($invList->jobsheet_no)){ ?>
											<option value="<?php echo $invList->invoice_no; ?>" <?php if($work_order_detail->invoice_number == $invList->invoice_no){ echo "selected"; }?> ><?php echo $invList->invoice_no; ?></option>
									<?php } } ?>
								</select>
							</div>
						</div>
					</div>
    			</div>
    		</div>
    	</section>
	</div>
	<?php if(count($selected_checkin_list) > 0){ 
	    $showhide = 'display:block'; 
	}else{
	    $showhide = 'display:none'; 
	}?>
	<div class="paddingTop22px">
		<section class="card col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-centered">
			<div class="card-block invoice">
    			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 paddingLeft0px"><h4 style="margin-bottom: 0px;"><?php _trans('lable296'); ?></h4></div>
    				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text_align_right">
    					<label class="switch">
    						<input type="checkbox" class="checkbox" name="checkbox" id="checkinCheckBox" <?php if(count($selected_checkin_list) > 0){ echo "checked"; }?> value="<?php if(count($selected_checkin_list) > 0){ echo "1"; } else{ echo '0'; }?>" >
    						<span class="slider round"></span>
    					</label>
    				</div>
    			</div>
    			<div class="collapse col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop20px <?php if(count($selected_checkin_list) > 0){ echo "in"; }?>"  id="checkincollapse">
        			<div id="checkinListDatas" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop7px paddingLeftRight0px">
        				<?php if(count($checkIn_list) > 0){  
        			     foreach ($checkIn_list as $checkInList) { 
        			         $checked = "";
        			         $count = '';
        			         $disabled = "disabled";
        			         foreach($selected_checkin_list as $selectedCheckinList){
        			             if($selectedCheckinList->checkin_prod_id == $checkInList->checkin_prod_id){  
        			                 $checked = "checked";
        			                 $count = $selectedCheckinList->checkin_count;
        			                 $disabled = "";
        			             }}  ?>
        			    <div class="multi-field col-lg-4 col-md-6 col-sm-4 col-xs-12">
        			    	<div class="form-group clearfix">
        			    		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text_align_left paddingTop10px">
        			    			<input type="checkbox" class="checkbox select_all_row checkin_prod_id" <?php echo $checked;?> name="select_all_row" value="<?php echo $checkInList->checkin_prod_id; ?>" >
        			    		</div>
        			    		<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 text_align_left paddingTop7px"><?php echo $checkInList->prod_name; ?></div>
            					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 padding0px ">
            						 <input type="text" name="checkin_count" class="checkin_count checkin_count_<?php echo $checkInList->checkin_prod_id; ?> form-control" value="<?php echo $count;?>" <?php echo $disabled; ?> >
            					</div>
            				</div>
            			</div>
        				
        				<?php } } ?>
        			</div>
    			</div>
			</div>
    	</section>
	</div>
	<div class="paddingTop22px">
		<section class="card col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-centered">
			<div class="card-block invoice">
    			<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12" >
    				<div class="col-lg-6 col-lg-6 col-sm-6 col-xs-12 paddingLeft0px"><h4 style="margin-bottom: 0px;"><?php _trans('lable297'); ?></h4></div>
    				<div class="col-lg-6 col-lg-6 col-sm-6 col-xs-12 text_align_right">
    					<label class="switch">
    						<input type="checkbox" class="checkbox" <?php if($service_remainder->serviceCheckBox == 1){ echo "checked"; } ?> name="checkbox" id="serviceCheckBox" value="<?php echo $service_remainder->serviceCheckBox; ?>" data-target="service">
    						<span class="slider round"></span>
    					</label>
    				</div>
    			</div>
    			<div class="collapse col-lg-12 col-lg-12 col-sm-12 col-xs-12 paddingTop20px <?php if($service_remainder->serviceCheckBox == 1){ echo 'in'; }?>" id="servicecollapse">
            		<div class="form-group clearfix">
    					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
    						<label class="control-label string required"><?php _trans('lable298'); ?> *</label>
    					</div>
    					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
    						 <input type="text" name="next_service_km" id="next_service_km" class="form-control" value="<?php echo $service_remainder->next_service_km; ?>">
    					</div>
    				</div>
    				<div class="form-group clearfix">
    					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
    						<label class="control-label string required"><?php _trans('lable299'); ?> *</label>
    					</div>
    					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
    						 <input type="text" name="next_service_date" id="next_service_date" class="form-control removeErrorInput datepicker" value="<?php echo $service_remainder->next_service_date?date_from_mysql($service_remainder->next_service_date):''; ?>">
    					</div>
    				</div>
    			</div>
			</div>
    	</section>
	</div>
	<div class="paddingTop22px">
		<section class="card col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-centered">
    		<div class="card-block invoice">
				<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12" >
					<div class="col-lg-6 col-lg-6 col-sm-6 col-xs-12 paddingLeft0px"><h4 style="margin-bottom: 0px;"><?php _trans('lable300'); ?></h4></div>
					<div class="col-lg-6 col-lg-6 col-sm-6 col-xs-12 text_align_right ">
						<label class="switch">
							<input type="checkbox" class="checkbox" <?php if($insurance_remainder->insuranceCheckBox == 1) { echo 'checked'; }?> name="checkbox" id="insuranceCheckBox" value="<?php echo $insurance_remainder->insuranceCheckBox; ?>" data-target="insurance">
							<span class="slider round"></span>
						</label>
					</div>
				</div>
    			<div class="collapse col-lg-12 col-lg-12 col-sm-12 col-xs-12 paddingTop20px <?php if($insurance_remainder->insuranceCheckBox == 1) { echo 'in'; }?>" id="insurancecollapse" >
					<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<label class="form_label"><?php _trans('lable301'); ?>*</label>
						<div class="form_controls">
							<input type="text" name="policy_number" id="policy_number" class="form-control" value="<?php echo $insurance_remainder->policy_number; ?>">
						</div>
					</div>
					<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<label class="form_label"><?php _trans('lable302'); ?>*</label>
						<div class="form_controls">
							<input type="text" name="next_service_ins_date" id="next_service_ins_date" class="form-control removeErrorInput datepicker" value="<?php echo $insurance_remainder->next_service_ins_date?date_from_mysql($insurance_remainder->next_service_ins_date):''; ?>">
						</div>
					</div>
					<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<label class="form_label"><?php _trans('lable174'); ?></label>
						<div class="form_controls">
							<input type="text" name="ins_company_name" id="ins_company_name" class="form-control" value="<?php echo $insurance_remainder->ins_company_name; ?>">
						</div>
					</div>
				</div>
           	</div>
    	</section>
	</div>
	<div class="paddingTop22px">
		<section class="card col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-centered">
    		<div class="card-block invoice">
				<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12" >
					<div class="col-lg-6 col-lg-6 col-sm-6 col-xs-12 paddingLeft0px"><h4 style="margin-bottom: 0px;"><?php _trans('lable304'); ?></h4></div>
					<div class="col-lg-6 col-lg-6 col-sm-6 col-xs-12 text_align_right ">
						<label class="switch">
							<input type="checkbox" class="checkbox" <?php if($work_order_detail->insuranceBillingCheckBox == 1) { echo 'checked'; }?> name="checkbox" id="insuranceBillingCheckBox" value="<?php echo $work_order_detail->insuranceBillingCheckBox; ?>" data-target="insurancebilling">
							<span class="slider round"></span>
						</label>
					</div>
				</div>
				<input type="hidden" name="mins_id" id="mins_id" value="<?php echo $work_order_detail->mins_id;?>" > 
    			<div class="collapse col-lg-12 col-lg-12 col-sm-12 col-xs-12 paddingTop20px <?php if($work_order_detail->insuranceBillingCheckBox == 1) { echo 'in'; }?>" id="insurancebillingcollapse" >
					<ul class="nav nav-pills" role="tablist">
						<li class="nav-item">
							<a class="nav-link active company" data-toggle="pill" href="#insurance_company"><?php _trans('lable907'); ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link claim" data-toggle="pill" href="#policyClaim"><?php _trans('lable908'); ?></a>
						</li>
					</ul>
					<!-- Tab panes -->
					<div class="tab-content">
						<div id="insurance_company" class="container tab-pane active"><br>
							<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<label class="form_label"><?php _trans('lable311'); ?>*</label>
								<div class="form_controls">
									<input type="text" name="ins_pro_name" id="ins_pro_name" class="form-control" value="<?php echo $work_order_detail->ins_pro_name; ?>">
								</div>
							</div>
							<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<label class="form_label"><?php _trans('lable307'); ?>*</label>
								<div class="form_controls">
									<select id="ins_claim_type" name="ins_claim_type" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" >
										<option value=""><?php _trans('lable308'); ?></option>
										<option value="1" <?php if($work_order_detail->ins_claim_type == 1){ echo "selected";}?>><?php _trans('lable309'); ?></option>
										<option value="2" <?php if($work_order_detail->ins_claim_type == 2){ echo "selected";}?>><?php _trans('lable310'); ?></option>
									</select>
								</div>
							</div>
							<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<label class="form_label"><?php _trans('lable910'); ?></label>
								<div class="form_controls">
									<input type="text" name="ins_gstin_no" id="ins_gstin_no" class="form-control" value="<?php echo $work_order_detail->ins_gstin_no; ?>">
								</div>
							</div>
							<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<label class="form_label"><?php _trans('lable912'); ?></label>
								<div class="form_controls">
									<input type="text" name="contact_name" id="contact_name" class="form-control" value="<?php echo $work_order_detail->contact_name; ?>">
								</div>
							</div>
							<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<label class="form_label"><?php _trans('lable913'); ?></label>
								<div class="form_controls">
								<input type="text" name="contact_number" id="contact_number" class="form-control" value="<?php echo $work_order_detail->contact_number; ?>">
								</div>
							</div>
							<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<label class="form_label"><?php _trans('lable914'); ?></label>
								<div class="form_controls">
								<input type="text" name="contact_email" id="contact_email" class="form-control" value="<?php echo $work_order_detail->contact_email; ?>">
								</div>
							</div>
							<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<label class="form_label"><?php _trans('lable915'); ?>*</label>
								<div class="form_controls">
									<input type="text" name="contact_street" id="contact_street" class="form-control" value="<?php echo $work_order_detail->contact_street; ?>" >	
								</div>
							</div>
							<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<label class="form_label"><?php _trans('lable916'); ?></label>
								<div class="form_controls">
									<input type="text" name="contact_area" id="contact_area" class="form-control" value="<?php echo $work_order_detail->contact_area; ?>" >	
								</div>
							</div>
							<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<label class="form_label"><?php _trans('lable86'); ?>*</label>
								<div class="form_controls">
									<?php if($work_order_detail->contact_country){
										$default_contact_country_id = $work_order_detail->contact_country;
									}else{
										$default_contact_country_id = $this->session->userdata('default_country_id');
									} ?>
									<select name="contact_country" id="contact_country" class="country bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" >
										<option value=""><?php _trans('lable163'); ?></option>
										<?php foreach ($country_list as $countryList) {?>
										<option value="<?php echo $countryList->id; ?>" <?php if ($countryList->id == $default_contact_country_id){ echo 'selected';} ?>><?php echo $countryList->name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<label class="form_label"><?php _trans('lable87'); ?>*</label>
								<div class="form_controls">
									<?php if($work_order_detail->contact_state){
										$default_contact_state_id = $work_order_detail->contact_state;
									}else{
										$default_contact_state_id = $this->session->userdata('default_state_id');
									} ?>
									<select name="contact_state" id="contact_state" class="state bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" >
										<option value=""><?php _trans('lable164'); ?></option>
										<?php foreach ($state_list as $stateList) {?>
										<option value="<?php echo $stateList->state_id; ?>" <?php if ($stateList->state_id == $default_contact_state_id) {echo 'selected';} ?> > <?php echo $stateList->state_name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<label class="form_label"><?php _trans('lable88'); ?></label>
								<div class="form_controls">
									<?php if($work_order_detail->contact_city){
										$default_contact_city_id = $work_order_detail->contact_city;
									}else{
										$default_contact_city_id = $this->session->userdata('default_city_id');
									} ?>
									<select id="contact_city" name="contact_city" class="city bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" >
										<option value=""><?php _trans('lable165'); ?></option>
										<?php foreach ($city_list as $cityList) {?>
										<option value="<?php echo $cityList->city_id; ?>" <?php if ($cityList->city_id == $default_contact_city_id) { echo 'selected';}?>><?php echo $cityList->city_name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<label class="form_label"><?php _trans('lable917'); ?></label>
								<div class="form_controls">
									<input type="text" name="contact_pincode" id="contact_pincode" class="form-control" value="<?php echo $work_order_detail->contact_pincode; ?>" >	
								</div>
							</div>
						</div>
						<div id="policyClaim" class="container tab-pane fade"><br>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 padding0px">
								<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12 paadding0px">
									<label class="form_label"><?php _trans('lable305'); ?>*</label>
									<div class="form_controls">
										<select id="ins_claim" name="ins_claim" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" >
											<option value=""><?php _trans('lable306'); ?></option>
											<option value="Y" <?php if($work_order_detail->ins_claim == "Y"){ echo "selected";}?>>Yes</option>
											<option value="N" <?php if($work_order_detail->ins_claim == "N"){ echo "selected";}?>>No</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<label class="form_label"><?php _trans('lable301'); ?>*</label>
								<div class="form_controls">
									<input type="text" name="policy_no" id="policy_no" class="form-control" value="<?php echo $work_order_detail->policy_no; ?>">
								</div>
							</div>
							<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<label class="form_label"><?php _trans('lable918'); ?></label>
								<div class="form_controls">
									<input type="text" name="driving_license" id="driving_license" class="form-control" value="<?php echo $work_order_detail->driving_license; ?>">
								</div>
							</div>
							<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<label class="form_label"><?php _trans('lable312'); ?></label>
								<div class="form_controls">
									<input type="text" name="ins_start_date" id="ins_start_date" class="form-control removeErrorInput datepicker" value="<?php echo date_from_mysql($work_order_detail->ins_start_date); ?>">
								</div>
							</div>
							<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
								<label class="form_label"><?php _trans('lable313'); ?>*</label>
								<div class="form_controls">
									<input type="text" name="ins_exp_date" id="ins_exp_date" class="form-control removeErrorInput datepicker" value="<?php echo date_from_mysql($work_order_detail->ins_exp_date); ?>">
								</div>
							</div>
							<div id="insClaimBox" <?php if($work_order_detail->ins_claim == "Y"){ echo 'style="display:block"'; } else { echo 'style="display:none"'; } ?> >
								<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<label class="form_label"><?php _trans('lable321'); ?></label>
									<div class="form_controls">
										<input type="text" name="surveyor_contact_no" id="surveyor_contact_no" class="form-control" value="<?php echo $work_order_detail->surveyor_contact_no; ?>">
									</div>
								</div>
								<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<label class="form_label"><?php _trans('lable320'); ?></label>
									<div class="form_controls">
									<input type="text" name="surveyor_name" id="surveyor_name" class="form-control" value="<?php echo $work_order_detail->surveyor_name; ?>">
									</div>
								</div>
								<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<label class="form_label"><?php _trans('lable911'); ?></label>
									<div class="form_controls">
									<input type="text" name="surveyor_email" id="surveyor_email" class="form-control" value="<?php echo $work_order_detail->surveyor_email; ?>">
									</div>
								</div>
								<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<label class="form_label"><?php _trans('lable314'); ?></label>
									<div class="form_controls">
										<input type="text" name="idv_amount" id="idv_amount" class="form-control" value="<?php echo $work_order_detail->idv_amount; ?>">
									</div>
								</div>
								<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<label class="form_label"><?php _trans('lable315'); ?></label>
									<div class="form_controls">
										<input type="text" name="ins_claim_no" id="ins_claim_no" class="form-control" value="<?php echo $work_order_detail->ins_claim_no; ?>">
									</div>
								</div>
								<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<label class="form_label"><?php _trans('lable316'); ?></label>
									<div class="form_controls">
										<input type="text" name="date_of_claim" id="date_of_claim" class="form-control datepicker" value="<?php echo ($work_order_detail->date_of_claim?date_from_mysql($work_order_detail->date_of_claim):""); ?>">	
									</div>
								</div>
								<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<label class="form_label"><?php _trans('lable317'); ?></label>
									<div class="form_controls">
										<input type="text" name="claim_amount" id="claim_amount" class="form-control" value="<?php echo $work_order_detail->claim_amount; ?>">
									</div>
								</div>
								<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<label class="form_label"><?php _trans('lable318'); ?></label>
									<div class="form_controls">
									<input type="text" name="ins_approved_amount" id="ins_approved_amount" class="form-control" value="<?php echo $work_order_detail->ins_approved_amount; ?>">
									</div>
								</div>
								<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<label class="form_label"><?php _trans('lable319'); ?></label>
									<div class="form_controls">
									<input type="text" name="ins_approved_date" id="ins_approved_date" class="form-control datepicker" value="<?php echo ($work_order_detail->ins_approved_date?date_from_mysql($work_order_detail->ins_approved_date):""); ?>">
									</div>
								</div>
								<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<label class="form_label"><?php _trans('lable322'); ?></label>
									<div class="form_controls">
										<select id="ins_status" name="ins_status" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" >
											<option value=""><?php _trans('lable323'); ?></option>
											<option value="1" <?php if($work_order_detail->ins_status == 1){ echo "selected";}?>><?php _trans('lable324'); ?></option>
											<option value="2" <?php if($work_order_detail->ins_status == 2){ echo "selected";}?>><?php _trans('lable325'); ?></option>
										</select>
									</div>
								</div>
								<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<label class="form_label"><?php _trans('lable326'); ?></label>
									<div class="form_controls">
										<input type="text" name="policy_excess" id="policy_excess" class="form-control" value="<?php echo $work_order_detail->policy_excess; ?>">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
           	</div>
    	</section>
	</div>
    
	<?php if($is_product == "Y"){ ?>
		<div class="paddingTop22px">
			<section class="card col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-centered">
				<div class="card-block invoice">
					<?php $this->layout->load_view('mech_work_order_dtls/partial_product_table'); ?>
				</div>
				<div class="error error_msg_product_name"></div>
			</section>
		</div>
	<?php } ?>

	<div class="paddingTop22px">
		<section class="card col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-centered">
    		<div class="card-block invoice">
    			<?php $this->layout->load_view('mech_work_order_dtls/partial_service_table'); ?>
			   </div>
			   <div class="error error_msg_service_name"></div>
    	</section>
	</div>

	<div class="paddingTop22px">
		<section class="card col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-centered">
    		<div class="card-block invoice">
    			<?php $this->layout->load_view('mech_work_order_dtls/partial_service_package_table'); ?>
			   </div>
			   <div class="error error_msg_service_name"></div>
    	</section>
	</div>
	
	
	<div class="paddingTop22px">
		<section class="card col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-centered">
    		<div class="card-block invoice">
				<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12" >
					<div class="col-lg-6 col-lg-6 col-sm-6 col-xs-12 paddingLeft0px"><h4 style="margin-bottom: 0px;"><?php _trans('lable327'); ?></h4></div>
					<div class="col-lg-6 col-lg-6 col-sm-6 col-xs-12 text_align_right ">
						<label class="switch">
							<input type="checkbox" class="checkbox"<?php if($work_order_detail->uploadCheckBox == 1){ echo "checked"; } ?> name="checkbox" id="uploadCheckBox" value="<?php echo $work_order_detail->uploadCheckBox; ?>" data-target="upload">
							<span class="slider round"></span>
						</label>
					</div>
				</div>
    			<div class="collapse col-lg-12 col-lg-12 col-sm-12 col-xs-12 paddingTop20px <?php if($work_order_detail->uploadCheckBox == 1){ echo "in"; } ?>" id="uploadcollapse" >
              		<div id="upload_section">
        				<div class="import_invoice_title padding_left_15px"><?php echo trans('lable180'); ?></div>
        				<form class="upload" upload-id="upload_csv_add" id="upload_csv_add" method="post" enctype="multipart/form-data">
        					<input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
        					<div class="form-group clearfix">
        						<div class="col-sm-3 text-right">
        							<label class="control-label string required"><?php _trans('lable179'); ?></label>
        						</div>
        						<div class="col-sm-3">
        							<input type="text" name="document_name" id="document_name" class="form-control" value="">
        						</div>
        						<div class="col-sm-5 paddingTop3px">
        							<input type="file" id="file" onchange="getfile()" class="inputTypeFile inputfile" name="file" />
        							<input type="hidden" id="fileName" name="fileName" value="" />
        							<div id="showError" class="errorColor" style="display:none;" ><?php _trans('lable181'); ?></div>
        						</div>
        						<div class="col-sm-1 paddingTop7px">
        							<span class="text-center">
        								<button type="submit">
        									<i class="fa fa-upload" aria-hidden="true"></i>
        								</button>
        							</span>
        						</div>
        					</div>
        				</form>
        			</div>
        			<hr>
        			<div id="preview_section" class="preview_uploads col-xs-12 col-sm-12 col-md-12 col-lg-12">
        				<?php if(count($upload_details)) { ?>
        	  			<table class="car-table-box col-lg-12 col-md-12 col-sm-12 col-xs-12">
        	  				<thead>
        	  					<tr>
        	  						<th><?php _trans('lable182'); ?></th>
        	  						<th><?php _trans('lable179'); ?></th>
        	  						<th align="center" class="text-center"><?php _trans('lable183'); ?></th>
        	  						<th align="center" class="text-center"><?php _trans('lable184'); ?></th>
        	  					</tr>
        	  				</thead>
        					<tbody id="uploaded_datas">
        						
        						 <?php foreach ($upload_details as $documentList){ ?>
        						<tr>
        							<td><span><?php echo $documentList->document_name; ?></span></td>
        							<td><span><?php echo $documentList->file_name_original; ?></span></td>
        							<td align="center" class="text-center" >
        							<span style="cursor: pointer">
                       					<a href="<?php echo base_url()."uploads/jobcard_files/".$documentList->file_name_new?>" target="_blank" >
                       						<img src="<?php echo base_url()."uploads/jobcard_files/".$documentList->file_name_new?>" width="50" height="50">
                       					</a>
                       				</span></td>
        							<td align="center" class="text-center"><span style="cursor: pointer" onclick="getDeleteUploadFIle('<?php echo $documentList->upload_id; ?>','D','<?php echo $documentList->url_key; ?>')"><i class="fa fa-trash-o" aria-hidden="true"></i></span></td>
        						</tr>
						<?php } ?>
							</tbody>
        				</table>
						<?php } else { ?> 
        				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" ><?php _trans('lable185'); ?></div>
        				<?php } ?>
        			</div>
				</div>
           	</div>
    	</section>
	</div>
	
	<div class="paddingTop22px">
		<section class="card col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-centered">
    		<div class="card-block invoice">
    			<div class="row m-b-3">
    				<div class="col-lg-12">
    					 <div class="col-lg-5 clearfix" style="float: left">
    					 	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							    <div class="form_group hide_terms">
									<strong><?php _trans('lable388'); ?></strong><br>
									<label name="job_ter_cond" id="job_ter_cond" style="text-align:left;text-align:justify;" class="control-label string required"><?php echo $work_order_detail->job_terms_condition;?></label>
								</div>
    					 		<div class="form_group">
    								<label class="control-label string required text_align_left" ><?php _trans('lable328'); ?></label>
    								<div class="form_controls">
    									<textarea name="description" id="description" class="form-control"><?php echo $work_order_detail->description; ?> </textarea>
    								</div>
    							</div>
    					 	</div>
    					 </div>
    					 <div class="col-lg-7 clearfix" style="float: right">
						 	<div class="total-amount row" style="float: left;width: 100%`">
							 	<?php if($is_product == "Y"){ ?>
								<div class="row">
									<div class="col-lg-7 col-md-7 col-sm-7 clearfix">
										<b><?php _trans('lable356'); ?>:</b>
									</div>
									<div class="col-lg-5 col-md-5 col-sm-5 price clearfix">
									<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<b class="total_product_invoice">0.00</b>
									</div>
								</div>
								<?php } ?>
								<div class="row">
									<div class="col-lg-9 col-md-9 col-sm-9 clearfix">
										<b><?php _trans('lable393'); ?>: </b>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3 price clearfix">
										<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<b class="total_servie_invoice">0.00</b>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-9 col-md-9 col-sm-9 clearfix">
										<b><?php _trans('label960'); ?>: </b>
									</div>

									<div class="col-lg-3 col-md-3 col-sm-3 price clearfix">
									<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<b class="total_servie_package_invoice">0.00</b>
									</div>
								</div>
								
								<div class="row">
									<div class="col-lg-9 col-md-9 col-sm-9 clearfix">
										<b><?php _trans('lable332'); ?></b><br>
									</div>	
									<div class="col-lg-3 col-md-3 col-sm-3 price clearfix" style="border-top:1px solid #000; margin-top: 5px">
									<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<b class="grand_total">0.00</b>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-9 col-md-9 col-sm-9 clearfix">
										<b><?php _trans('lable1020'); ?></b>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3 price clearfix">
										<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<b class="advance_amount_label"><?php echo format_money(($work_order_detail->advance_paid?$work_order_detail->advance_paid:0),$this->session->userdata('default_currency_digit')); ?></b>
									</div>
									<input type="hidden" id="advance_paid_amount" name="advance_paid_amount" value="<?php echo $work_order_detail->advance_paid;?>" autocomplete="off">
								</div>
								<div class="row">
									<div class="col-lg-9 col-md-9 col-sm-9 clearfix">
										<b><?php _trans('lable1021'); ?></b>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3 price clearfix">
										<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<b class="total_due_amount_lable"><?php echo format_money(($work_order_detail->total_due_amount?$work_order_detail->total_due_amount:0),$this->session->userdata('default_currency_digit')); ?></b>
									</div>
									<input type="hidden" id="total_due_amount" name="total_due_amount" value="<?php echo $work_order_detail->total_due_amount;?>" autocomplete="off">
								</div>
							</div>
                        </div>
                    </div>
                </div>
			</div>
			<div class="card-block invoice">
    			<div class="row invoiceFloatbtn">
    				<div class="col-lg-12 clearfix buttons text-right">
                    	<div class="buttons">
                    		<?php if($work_order_detail->work_order_status == 'G'){ ?>
							<button name="btn_submit" class="btn_submit btn btn-rounded btn-primary createworkorder" value="G">
								<i class="fa fa-check"></i><?php _trans('lable57'); ?> 
							</button>
							<?php } else { ?>
							<button name="btn_submit" class="btn_submit btn btn-rounded btn-primary createworkorder" value="G">
								<i class="fa fa-check"></i><?php _trans('lable333'); ?> 
							</button>
							<button id="btn_submit" name="btn_submit" class="btn_submit btn btn-rounded btn-primary createworkorder" value="G">
								<i class="fa fa-check"></i><?php _trans('lable334'); ?> 
							</button>
							<?php }?>
							<button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default" value="1">
								<i class="fa fa-times"></i><?php _trans('lable58'); ?> 
							</button>
                		</div>
                    </div>
              	</div>
           	</div>
    	</section>
	</div>
</div>

<script type="text/javascript">

    if($("#term_val").val()){
        $('.hide_terms').show();
    }else{
        $('.hide_terms').hide();
    }

$(".checkin_count").on("keypress keyup blur",function (event) {    
           $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
});

var carResponse;

$(document).ready(function(){
	
	$(".select2").select2();

	$('.country').change(function () {
		$('#gif').show();
		$.post("<?php echo site_url('settings/ajax/get_state_list'); ?>", {
			country_id: $('#supplier_country').val(),
			_mm_csrf: $('#_mm_csrf').val()
		},
		function (data) {
			var response = JSON.parse(data);
			if (response.length > 0) {
				$('#gif').hide();
				$('#supplier_state').empty(); // clear the current elements in select box
				$('#supplier_state').append($('<option></option>').attr('value', '').text('Select State'));
				for (row in response) {
					$('#supplier_state').append($('<option></option>').attr('value', response[row].state_id).text(response[row].state_name));
				}
				$('#supplier_state').selectpicker("refresh");
			}
			else {
				$('#gif').hide();
				$('#supplier_state').empty(); // clear the current elements in select box
				$('#supplier_state').append($('<option></option>').attr('value', '').text('Select State'));
				$('#supplier_state').selectpicker("refresh");
			}
		});
	});

	$('.job_terms').change(function() {
		var job_terms_condition = $("#branch_id").find('option:selected').attr('data-terms-condition');
		$("#job_ter_cond").empty().append(job_terms_condition);
		    if(job_terms_condition == ''){
                $('.hide_terms').hide();
            }else{
                $('.hide_terms').show();
            }
    });

	$("#ins_claim").change(function() {
		if($("#ins_claim").val() == "Y"){
			$("#insClaimBox").show();
		}else{
			$("#insClaimBox").hide();
		}
	});
	
	$('.state').change(function () {
		$('#gif').show();
		$.post("<?php echo site_url('settings/ajax/get_city_list'); ?>", {
			state_id: $('#supplier_state').val(),
			_mm_csrf: $('#_mm_csrf').val()
		},
		function (data) {
			var response = JSON.parse(data);
			if (response.length > 0) {
				$('#gif').hide();
				$('#supplier_city').empty(); // clear the current elements in select box
				$('#supplier_city').append($('<option></option>').attr('value', '').text('Select City'));
				for (row in response) {
					$('#supplier_city').append($('<option></option>').attr('value', response[row].city_id).text(response[row].city_name));
				}
				$('#supplier_city').selectpicker("refresh");
			}
			else {
				$('#gif').hide();
				$('#supplier_city').empty(); // clear the current elements in select box
				$('#supplier_city').append($('<option></option>').attr('value', '').text('Select City'));
				$('#supplier_city').selectpicker("refresh");
			}
		});
	});


	$('#start_date').datetimepicker({
        format: 'DD-MM-YYYY HH:mm:ss',
    });

	$('#end_date').datetimepicker({
        format: 'DD-MM-YYYY HH:mm:ss',
    });

	$(".select_all_row").change(function(){
		var id = $(this).val();
	   	if($(this).prop("checked") == true){
	   		$(".checkin_count_"+id).attr("disabled", false);
	 	}else{
	 		$(".checkin_count_"+id).attr('disabled', true);
	  	}
	});

	$("#insuranceBillingCheckBox").click(function(){
		if($("#insuranceBillingCheckBox:checked").is(":checked")){
			$("#insurancebillingcollapse").addClass('in');
			$("#insuranceBillingCheckBox").val(1);
		}else{
			$("#insurancebillingcollapse").removeClass('in');
			$("#insuranceBillingCheckBox").val(0);
		}
	});

	$("#checkinCheckBox").click(function(){
		if($("#checkinCheckBox:checked").is(":checked")){
			$("#checkincollapse").addClass('in');
			$("#checkinCheckBox").val(1);
		}else{
			$("#checkincollapse").removeClass('in');
			$("#checkinCheckBox").val(0);
		}
	});

	$("#serviceCheckBox").click(function(){
		if($("#serviceCheckBox:checked").is(":checked")){
			$("#servicecollapse").addClass('in');
			$("#serviceCheckBox").val(1);
		}else{
			$("#servicecollapse").removeClass('in');
			$("#serviceCheckBox").val(0);
		}
	});

	$("#insuranceCheckBox").click(function(){
		if($("#insuranceCheckBox:checked").is(":checked")){
			$("#insurancecollapse").addClass('in');
			$("#insuranceCheckBox").val(1);
		}else{
			$("#insurancecollapse").removeClass('in');
			$("#insuranceCheckBox").val(0);
		}
	});

	$("#uploadCheckBox").click(function(){
		if($("#uploadCheckBox:checked").is(":checked")){
			$("#uploadcollapse").addClass('in');
			$("#uploadCheckBox").val(1);
		}else{
			$("#uploadcollapse").removeClass('in');
			$("#uploadCheckBox").val(0);
		}
	});
		
	if ($('#customer_id').val() != '') {
		$('.addcarpopuplink').show();
	} else {
		$('.addcarpopuplink').hide();
	}

	$('#customer_id').change(function() {

		if ($('#customer_id').val() != '') {
			$('.addcarpopuplink').show();
		} else {
			$('.addcarpopuplink').hide();
		}

		$('#gif').show();
		$.post("<?php echo site_url('clients/ajax/get_customer_cars_address'); ?>", {
			customer_id: $('#customer_id').val(),
			_mm_csrf: $('#_mm_csrf').val()
		},
		function(data) {
			var response = JSON.parse(data);
			$('.add_car').attr('data-customer-id', $('#customer_id').val());
			$('.add_address').attr('data-customer-id', $('#customer_id').val());
			$('#common_customer_id').val($('#customer_id').val());
			if (response.success == '1' || response.success == 1 ) {
				if (response.user_cars.length > 0) {
					$('#gif').hide();
					var cars = response.user_cars;
					$('#customer_car_id').empty();
					$('#customer_car_id').append($('<option></option>').attr('value', '').text('Select Customer Vehicle'));
					for (row in cars) {
						var variant_name = (cars[row].variant_name) ? cars[row].variant_name : '';
						$('#customer_car_id').append($('<option></option>').attr('value', cars[row].car_list_id).text((cars[row].brand_name?cars[row].brand_name:"")+''+(cars[row].model_name?", "+cars[row].model_name: '')+''+(cars[row].variant_name?", "+cars[row].variant_name:'')+''+(cars[row].car_reg_no?", "+cars[row].car_reg_no: '')));
					}
					$('#customer_car_id').selectpicker("refresh");
				} else {
					$('#gif').hide();
					$('#customer_car_id').empty();
					$('#customer_car_id').append($('<option></option>').attr('value', '').text('Select Customer Vehicle'));
					$('#customer_car_id').selectpicker("refresh");
				}
				if (response.user_address.length > 0) {
					$('#gif').hide();
					var add = response.user_address;
					$('#user_address_id').empty();
					$('#user_address_id').append($('<option></option>').attr('value', '').text('Select Customer Address'));
					for (row in add) {
						var full_address = ((add[row].customer_street_1)?add[row].customer_street_1:'')+" "+((add[row].customer_street_2)?", "+add[row].customer_street_2:'')+""+((add[row].area)?", "+add[row].area:'');

						var zip_code = (add[row].zip_code) ? add[row].zip_code : '';
						var address = full_address + ', ' + zip_code;
						$('#user_address_id').append($('<option></option>').attr('value', add[row].user_address_id).text(address));
					}
					$('#user_address_id').selectpicker("refresh");
				} else {
					$('#gif').hide();
					$('#user_address_id').empty();
					$('#user_address_id').append($('<option></option>').attr('value', '').text('Select Customer Address'));
					$('#user_address_id').selectpicker("refresh");
				}
				if(response.customer_referrence.length > 0){
					$('#gif').hide();
					$("#refered_by_type").val(response.customer_referrence[0].refered_by_type);
					$("#refered_by_id").val(response.customer_referrence[0].refered_by_id);
				}else{
					$('#gif').hide();
					$("#refered_by_type").val('');
					$("#refered_by_id").val('');
				}
			}
		});
	});
	
		$('#service_category_id').change(function () {

			// if($("#customer_car_id").val() == ''){
			// 	notie.alert(3, '<?php // _trans('toaster5'); ?>', 2);
			// 	$("#service_category_id").val(0);
			// 	$('.bootstrap-select').selectpicker("refresh");
			// 	return false;
			// }
			$('#gif').show();
			$.post("<?php echo site_url('mech_item_master/ajax/getServiceList'); ?>", {
				service_category_id: $('#service_category_id').val(),
				user_car_list_id: $('#customer_car_id').val(),
				_mm_csrf: $('#_mm_csrf').val()
			},function (data) {
				var response = JSON.parse(data);
				if (response) {
					$('#gif').hide();
					$('#services_add_service').empty(); // clear the current elements in select box
					$('#services_add_service').append($('<option></option>').attr('value', '').text('Item'));
					for (row in response) {
						$('#services_add_service').append($('<option></option>').attr('value', response[row].msim_id).attr('data-s_id', response[row].s_id).text(response[row].service_item_name));
					}
					$('#services_add_service').selectpicker("refresh");
				}else{
					$('#gif').hide();
					console.log("No data found");
				}
			});
		});

        
	$("#btn_cancel").click(function () {
		window.location.href = "<?php echo site_url('mech_work_order_dtls'); ?>";
	});

	function getfile()
	{
		var filename = $('input[type=file]').val().split("\\");
		$("#fileName").val(filename[2]);
		$("#showError").hide();
	}

	$(document).on('submit', ".upload", function (e) {

		$('#showError').empty().append('');
		$('#showError').hide();
		
		if($("#document_name").val() == ''){
			$('#document_name').parent().addClass('has-error');
			return false;
		}else{
			$('.has-error').removeClass('has-error');
		}

		if($("#fileName").val() == ''){
			$('#showError').empty().append('Please choose the file');
			$('#showError').show();
			return false;
		}else{
			$('#showError').empty().append('');
			$('#showError').hide();
		}
		
		var attr_name = $(this).attr("upload-id");
		var forImg = this;
		e.preventDefault();
		e.stopPropagation ();

		var work_order_url_key = $("#work_order_url_key").val();
		var work_order_id = $("#work_order_id").val();
		if(work_order_id == ''){
			work_order_id = 0;
		}
	
		$.ajax({
			url : "<?php echo site_url('upload/upload/upload_file'); ?>/"+work_order_id+"/J/"+work_order_url_key+"",
			method:"POST",
			data : new FormData(this),
			contentType:false,
			cache:false,
			processData:false,
			success: function(data){
				var response = JSON.parse(data);
				if(response.success=='1'){
					getDeleteUploadFIle(response.upload_id,'J',response.url_key);
				}else{
					$('#showError').empty().append('invalid file format');
					$('#showError').show();
				}
			}
		});
	});
 
	$(".createworkorder").click(function () {
		
		var type = this.value;
		var checkinArray = [];
		
		$("#checkinListDatas .multi-field").each(function(){
			var requestObj = {};
			requestObj.checkin_prod_id = $(this).find(".checkin_prod_id").val();
			requestObj.checkin_count = $(this).find(".checkin_count").val();
			checkinArray.push(requestObj);
		});
		
		var service_items = [];
		$('table#service_item_table tbody>tr.item').each(function () {
			var service_row = {};
			$(this).find('input,select,textarea').each(function () {
				if ($(this).is(':checkbox')) {
					service_row[$(this).attr('name')] = $(this).is(':checked');
				} else {
					if($(this).val() != '' && $(this).val() != null && $(this).val() != undefined){
					service_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
					}
				}
			});
			service_items.push(service_row);
		});

		var service_totals = [];
		$('table#service_item_table .service_total_calculations').each(function () {
			var service_total_row = {};
			$(this).find('input,select,textarea').each(function () {
				if ($(this).is(':checkbox')) {
					service_total_row[$(this).attr('name')] = $(this).is(':checked');
				} else {
					if($(this).val() != '' && $(this).val() != null && $(this).val() != undefined){
					service_total_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
					}
				}
			});
			service_totals.push(service_total_row);
		});

		var service_package_items = [];
		$('table#service_package_item_table tbody>tr.item').each(function () {
			var service_package_row = {};
			$(this).find('input,select,textarea').each(function () {
				if ($(this).is(':checkbox')) {
					service_package_row[$(this).attr('name')] = $(this).is(':checked');
				} else {
					if($(this).val() != '' && $(this).val() != null && $(this).val() != undefined){
					service_package_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
					}
				}
			});
			service_package_items.push(service_package_row);
		});

		var service_package_totals = [];
		$('table#service_package_item_table .service_total_calculations').each(function () {
			var service_package_total_row = {};
			$(this).find('input,select,textarea').each(function () {
				if ($(this).is(':checkbox')) {
					service_package_total_row[$(this).attr('name')] = $(this).is(':checked');
				} else {
					if($(this).val() != '' && $(this).val() != null && $(this).val() != undefined){
					service_package_total_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
					}
				}
			});
			service_package_totals.push(service_package_total_row);
		});
		
		var product_items = [];
		$('table#product_item_table tbody>tr.item').each(function () {
			var product_row = {};
			$(this).find('input,select,textarea').each(function () {
				if ($(this).is(':checkbox')) {
					product_row[$(this).attr('name')] = $(this).is(':checked');
				} else {
					if($(this).val() != '' && $(this).val() != null && $(this).val() != undefined){
					product_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
					}
				}
			});
			product_items.push(product_row);
		});
		
		var product_totals = [];
		$('table#product_item_table .product_total_calculations').each(function () {
			var product_total_row = {};
			$(this).find('input,select,textarea').each(function () {
				if ($(this).is(':checkbox')) {
					product_total_row[$(this).attr('name')] = $(this).is(':checked');
				} else {
					if($(this).val() != '' && $(this).val() != null && $(this).val() != undefined){
					product_total_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
					}
				}
			});
			product_totals.push(product_total_row);
		});
		
		var work_order_status = $(this).val();

		var validation = [];

		if($("#branch_id").val() == ''){
			validation.push('branch_id');
		}
		
		if($("#invoice_group_id").val() == ''){
			validation.push('invoice_group_id');
		}
		
		if($("#issue_date").val() == ''){
			validation.push('issue_date');
		}
		
		if($("#customer_id").val() == ''){
			validation.push('customer_id');
		}

		if($("#customer_car_id").val() == ''){
			validation.push('customer_car_id');
		}

		if($("#jobsheet_status").val() == ''){
			validation.push('jobsheet_status');
		}

		if($("#serviceCheckBox").val() == 1){
			if($("#next_service_km").val() == ''){
				validation.push('next_service_km');
			}
			if($("#next_service_date").val() == ''){
				validation.push('next_service_date');
			}
		}

		if($("#insuranceCheckBox").val() == 1){
			if($("#policy_number").val() == ''){
				validation.push('policy_number');
			}
			if($("#next_service_ins_date").val() == ''){
				validation.push('next_service_ins_date');
			}
		}

		if($("#insuranceBillingCheckBox").val() == 1){
			if($("#ins_pro_name").val() == ''){
				validation.push('ins_pro_name');
				$('html,body').animate({ scrollTop: 1000 }, 0
				, function(){
					if ($('#ins_pro_name').val() == '') { $('#ins_pro_name').focus(); $('.company').addClass('active'); $('.claim').removeClass('active'); $('#insurance_company').addClass('active in'); $('#policyClaim').removeClass('active in'); return false; }
				});
			}

			if($("#contact_street").val() == ''){
				validation.push('contact_street');
				$('html,body').animate({ scrollTop: 1000 }, 0
				, function(){
					if ($('#contact_street').val() == '') { $('#contact_street').focus(); $('.company').addClass('active'); $('.claim').removeClass('active'); $('#insurance_company').addClass('active in'); $('#policyClaim').removeClass('active in'); return false; }
				});
			}
			if($("#contact_country").val() == ''){
				validation.push('contact_country');
				$('html,body').animate({ scrollTop: 1000 }, 0
				, function(){
					if ($('#contact_country').val() == '') { $('#contact_country').focus(); $('.company').addClass('active'); $('.claim').removeClass('active'); $('#insurance_company').addClass('active in'); $('#policyClaim').removeClass('active in'); return false; }
				});
			}
			if($("#contact_state").val() == ''){
				validation.push('contact_state');
				$('html,body').animate({ scrollTop: 1000 }, 0
				, function(){
					if ($('#contact_state').val() == '') { $('#contact_state').focus(); $('.company').addClass('active'); $('.claim').removeClass('active'); $('#insurance_company').addClass('active in'); $('#policyClaim').removeClass('active in'); return false; }
				});
			}

			if($("#ins_claim_type").val() == ''){
				validation.push('ins_claim_type');
				$('html,body').animate({ scrollTop: 1000 }, 0
				, function(){
					if ($('#ins_claim_type').val() == '') { $('#ins_claim_type').focus(); $('.company').addClass('active'); $('.claim').removeClass('active'); $('#insurance_company').addClass('active in'); $('#policyClaim').removeClass('active in'); return false; }
				});
			}
			
			if($("#policy_no").val() == ''){
				validation.push('policy_no');
				$('html,body').animate({ scrollTop: 1000 }, 0
				, function(){
					if ($('#policy_no').val() == '') { $('#policy_no').focus(); $('.claim').addClass('active'); $('.company').removeClass('active'); $('#policyClaim').addClass('active in'); $('#insurance_company').removeClass('active in'); return false; }
				});
			}
			if($("#ins_claim").val() == ''){
				validation.push('ins_claim');
				$('html,body').animate({ scrollTop: 1000 }, 0
				, function(){
					if ($('#ins_claim').val() == '') { $('#ins_claim').focus(); $('.claim').addClass('active'); $('.company').removeClass('active'); $('#policyClaim').addClass('active in'); $('#insurance_company').removeClass('active in'); return false; }
				});
			}
			// if($("#ins_start_date").val() == ''){
			// 	validation.push('ins_start_date');
			// }
			if($("#ins_exp_date").val() == ''){
				validation.push('ins_exp_date');
				$('html,body').animate({ scrollTop: 1000 }, 0
				, function(){
					if ($('#ins_exp_date').val() == '') { $('#ins_exp_date').focus(); $('.claim').addClass('active'); $('.company').removeClass('active'); $('#policyClaim').addClass('active in'); $('#insurance_company').removeClass('active in'); return false; }
				});
			}
		}

		if(validation.length > 0){
			validation.forEach(function(val) {
				$('#'+val).addClass("border_error");
				$('#'+val).parent().addClass('has-error');
			});
			notie.alert(3,'<?php _trans('toaster2');?>',2);
			return false;
		}

		var data = [];

		if((service_items.length) <= 0){
			data.push('one');
		}

		if((service_package_items.length) <= 0){
			data.push('two');
		}

		if((product_items.length) <= 0){
			data.push('three');
		}

		if((data.length) > 2){
			notie.alert(3,'please add the items',2);
			return false;
		}

		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');
		$('#gif').show();	

		$.post('<?php echo site_url('mech_work_order_dtls/ajax/invoice_create'); ?>', {
			book_type : type,
			work_order_id : $('#work_order_id').val(),
			branch_id : $("#branch_id").val(),
			work_order_status: work_order_status,
			jobsheet_no : $("#jobsheet_no").val(),
			invoice_group_id : $("#invoice_group_id").val()?$("#invoice_group_id").val():'',
			url_key : $("#work_order_url_key").val(),
			customer_id : $("#customer_id").val(),
			customer_car_id : $("#customer_car_id").val(),
			user_address_id : $("#user_address_id").val(),
			current_odometer_reading : $("#current_odometer_reading").val(),
			fuel_level : $("#fuel_level").val(),
			jobsheet_status : $("#jobsheet_status").val(),
			ex_jobsheet_status : $("#ex_jobsheet_status").val(),
			work_from : $("#work_from").val(),
			work_from_id : $("#work_from_id").val(),
			issue_date : $("#issue_date").val(),
			start_date : $("#start_date").val(),
			end_date : $("#end_date").val(),
			refered_by_type : $("#refered_by_type").val(),
			refered_by_id : $("#refered_by_id").val(),
			issued_by : $("#issued_by").val(),
			assigned_to : $("#assigned_to").val(),
			invoice_number : $("#invoice_number").val(),
			check_in_id : $("#check_in_id").val(),
			serviceCheckBox : $("#serviceCheckBox").val(),
			next_service_km : $("#next_service_km").val(),
			next_service_date : $("#next_service_date").val(),
			insuranceCheckBox : $("#insuranceCheckBox").val(),
			policy_number : $("#policy_number").val(),
			next_service_ins_date : $("#next_service_ins_date").val(),
			ins_company_name : $("#ins_company_name").val(),
			job_type : $("#job_type").val(),
			description : $("#description").val(),
			mins_id : $("#mins_id").val(),
			insuranceBillingCheckBox : $("#insuranceBillingCheckBox").val(),
			ins_claim_type : $("#ins_claim_type").val(),
			ins_pro_name : $("#ins_pro_name").val(),
			ins_gstin_no : $("#ins_gstin_no").val(),
			contact_name: $("#contact_name").val(),
			contact_number : $("#contact_number").val(),
			contact_email : $("#contact_email").val(),
			contact_street : $("#contact_street").val(),
			contact_area : $("#contact_area").val(),
			contact_country: $("#contact_country").val(),
			contact_state : $("#contact_state").val(),
			contact_city : $("#contact_city").val(),
			contact_pincode : $("#contact_pincode").val(),
			ins_claim : $("#ins_claim").val(),
			policy_no : $("#policy_no").val(),
			driving_license : $("#driving_license").val(),
			ins_start_date : $("#ins_start_date").val(),
			ins_exp_date : $("#ins_exp_date").val(),
			surveyor_contact_no : $("#surveyor_contact_no").val(),
			surveyor_name : $("#surveyor_name").val(),
			surveyor_email : $("#surveyor_email").val(),
			idv_amount : $("#idv_amount").val(),
			ins_claim_no : $("#ins_claim_no").val(),
			date_of_claim : $("#date_of_claim").val(),
			claim_amount : $("#claim_amount").val(),
			ins_approved_amount : $("#ins_approved_amount").val(),
			ins_approved_date : $("#ins_approved_date").val(),
			ins_status : $("#ins_status").val(),		
			job_terms_condition : $('#job_ter_cond').html()?$('#job_ter_cond').html():'',	
			policy_excess : $("#policy_excess").val(),
			checkinArray: JSON.stringify(checkinArray),
			
			service_items : JSON.stringify(service_items),
			service_totals : JSON.stringify(service_totals),
			service_user_total: $(".total_user_service_price").html()?$(".total_user_service_price").html().replace(/,/g, ''):'',
			service_discountstate: $("#service_discountstate").val()?$("#service_discountstate").val():'',
			service_total_discount_pct: $("#service_discount").val()?$("#service_discount").val().replace(/,/g, ''):0,
			service_total_discount: $(".service_total_discount").html()?$(".service_total_discount").html().replace(/,/g, ''):0,
			service_total_taxable: $(".total_user_service_taxable").html()?$(".total_user_service_taxable").html().replace(/,/g, ''):0,
			service_total_gst_pct:  $("#total_service_tax").val()?$("#total_service_tax").val():0,
			service_total_gst: $(".total_servie_gst_price").html()?$(".total_servie_gst_price").html().replace(/,/g, ''):0,
			service_grand_total: $(".total_servie_invoice").html()?$(".total_servie_invoice").html().replace(/,/g, ''):0,

			service_package_items : JSON.stringify(service_package_items),
			service_package_totals : JSON.stringify(service_package_totals),
			service_package_user_total: $(".total_user_service_package_price").html()?$(".total_user_service_package_price").html().replace(/,/g, ''):'',
			packagediscountstate: $("#packagediscountstate").val()?$("#packagediscountstate").val():'',
			service_package_total_taxable: $(".total_user_service_package_taxable").html()?$(".total_user_service_package_taxable").html().replace(/,/g, ''):0,
			service_package_total_gst_pct:  $("#total_service_package_tax").val()?$("#total_service_package_tax").val():0,
			service_package_total_gst: $(".total_servie_package_gst_price").html()?$(".total_servie_package_gst_price").html().replace(/,/g, ''):0,
			service_package_grand_total: $(".total_servie_package_invoice").html()?$(".total_servie_package_invoice").html().replace(/,/g, ''):0,

			parts_discountstate: $("#parts_discountstate").val()?$("#parts_discountstate").val():'',
			product_items: JSON.stringify(product_items),
			product_totals : JSON.stringify(product_totals),
			product_user_total: $(".total_user_product_price").html()?$(".total_user_product_price").html().replace(/,/g, ''):0,
			product_total_discount: $(".product_total_discount").html()?$(".product_total_discount").html().replace(/,/g, ''):0,
			product_total_taxable: $(".total_user_product_taxable").html()?$(".total_user_product_taxable").html().replace(/,/g, ''):0,
			product_total_gst: $(".total_user_product_gst").html()?$(".total_user_product_gst").html().replace(/,/g, ''):0,
			product_grand_total: $(".total_product_invoice").html()?$(".total_product_invoice").html().replace(/,/g, ''):0,
			total_taxable_amount: $(".total_taxable_amount").html()?$(".total_taxable_amount").html().replace(/,/g, ''):0,
			overall_discount_amount: $(".overall_discount_amount").html()?$(".overall_discount_amount").html().replace(/,/g, ''):0,
			total_tax_amount: $(".total_gst_amount").html()?$(".total_gst_amount").html().replace(/,/g, ''):0,
			grand_total: $(".grand_total").html()?$(".grand_total").html().replace(/,/g, ''):0,
			total_due_amount: $(".grand_total").html()?$(".grand_total").html().replace(/,/g, ''):'',
            total_due_amount_save: $("#total_due_amount_save").val()?$("#total_due_amount_save").val().replace(/,/g, ''):'',
			next_service_dt: $("#next_service_dt").val()?$("#next_service_dt").val():'',
			uploadCheckBox : $("#uploadCheckBox").val(),
			_mm_csrf: $('#_mm_csrf').val()
		}, function (data) {
			list = JSON.parse(data);
			if(list.success=='1'){
				notie.alert(1,'<?php _trans('toaster1');?>',2);
				if (work_order_status == "D") {
					notie.alert(1,'<?php _trans('toaster1');?>',2);
					setTimeout(function() {
						window.location = "<?php echo site_url('mech_work_order_dtls/book');?>/"+list.work_order_id+"/1/"+$("#jobsheet_status").val();
					}, 1000);
				} else if (work_order_status == "G") {
					notie.alert(1,'<?php _trans('toaster1');?>',2);
					setTimeout(function() {
						window.location ="<?php echo site_url('mech_work_order_dtls/view');?>/"+list.work_order_id+"/1/"+$("#jobsheet_status").val();
					}, 1000);
				}
			}else if(list.success == '2') {
				$('#gif').hide();	
				notie.alert(3,'<?php _trans('toaster2');?>',2);
			}else if(list.success == '3') {
				$('#gif').hide();
				notie.alert(3,list.msg,2);
			}else{
				$('#gif').hide();	
				notie.alert(3,'<?php _trans('toaster2');?>',2);
				$('.has-error').removeClass('has-error');
				for (var key in list.validation_errors) {
					$('#' + key).parent().addClass('has-error');
					$('.error_msg_' + key).show().empty().html(list.validation_errors[key]);
				}
			}
		});
	});

	$('#jobsheet_status').change(function() {

		var jobsheet_status = $('#jobsheet_status').val();
		var work_order_id = $('#work_order_id').val();

		if (jobsheet_status == '3') {

			swal({
			title: "Are you sure?",
			text: "if you want to convert this jobcard to Invoice!",
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

		var checkinArray = [];
		
		$("#checkinListDatas .multi-field").each(function(){
			var requestObj = {};
			requestObj.checkin_prod_id = $(this).find(".checkin_prod_id").val();
			requestObj.checkin_count = $(this).find(".checkin_count").val();
			checkinArray.push(requestObj);
		});
		
		var service_items = [];
		$('table#service_item_table tbody>tr.item').each(function () {
			var service_row = {};
			$(this).find('input,select,textarea').each(function () {
				if ($(this).is(':checkbox')) {
					service_row[$(this).attr('name')] = $(this).is(':checked');
				} else {
					if($(this).val() != '' && $(this).val() != null && $(this).val() != undefined){
					service_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
					}
				}
			});
			service_items.push(service_row);
		});

		var service_totals = [];
		$('table#service_item_table .service_total_calculations').each(function () {
			var service_total_row = {};
			$(this).find('input,select,textarea').each(function () {
				if ($(this).is(':checkbox')) {
					service_total_row[$(this).attr('name')] = $(this).is(':checked');
				} else {
					if($(this).val() != '' && $(this).val() != null && $(this).val() != undefined){
					service_total_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
					}
				}
			});
			service_totals.push(service_total_row);
		});

		var service_package_items = [];
		$('table#service_package_item_table tbody>tr.item').each(function () {
			var service_package_row = {};
			$(this).find('input,select,textarea').each(function () {
				if ($(this).is(':checkbox')) {
					service_package_row[$(this).attr('name')] = $(this).is(':checked');
				} else {
					if($(this).val() != '' && $(this).val() != null && $(this).val() != undefined){
					service_package_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
					}
				}
			});
			service_package_items.push(service_package_row);
		});

		var service_package_totals = [];
		$('table#service_package_item_table .service_total_calculations').each(function () {
			var service_package_total_row = {};
			$(this).find('input,select,textarea').each(function () {
				if ($(this).is(':checkbox')) {
					service_package_total_row[$(this).attr('name')] = $(this).is(':checked');
				} else {
					if($(this).val() != '' && $(this).val() != null && $(this).val() != undefined){
					service_package_total_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
					}
				}
			});
			service_package_totals.push(service_package_total_row);
		});
		
		var product_items = [];
		$('table#product_item_table tbody>tr.item').each(function () {
			var product_row = {};
			$(this).find('input,select,textarea').each(function () {
				if ($(this).is(':checkbox')) {
					product_row[$(this).attr('name')] = $(this).is(':checked');
				} else {
					if($(this).val() != '' && $(this).val() != null && $(this).val() != undefined){
					product_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
					}
				}
			});
			product_items.push(product_row);
		});
		
		var product_totals = [];
		$('table#product_item_table .product_total_calculations').each(function () {
			var product_total_row = {};
			$(this).find('input,select,textarea').each(function () {
				if ($(this).is(':checkbox')) {
					product_total_row[$(this).attr('name')] = $(this).is(':checked');
				} else {
					if($(this).val() != '' && $(this).val() != null && $(this).val() != undefined){
					product_total_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
					}
				}
			});
			product_totals.push(product_total_row);
		});
		
		var work_order_status = 'G';

		var validation = [];

		if($("#branch_id").val() == ''){
			validation.push('branch_id');
		}
		
		if($("#invoice_group_id").val() == ''){
			validation.push('invoice_group_id');
		}
		
		if($("#issue_date").val() == ''){
			validation.push('issue_date');
		}
		
		if($("#customer_id").val() == ''){
			validation.push('customer_id');
		}

		if($("#customer_car_id").val() == ''){
			validation.push('customer_car_id');
		}

		if($("#jobsheet_status").val() == ''){
			validation.push('jobsheet_status');
		}
		
		if($("#serviceCheckBox").val() == 1){
			if($("#next_service_km").val() == ''){
				validation.push('next_service_km');
			}
			if($("#next_service_date").val() == ''){
				validation.push('next_service_date');
			}
		}

		if($("#insuranceCheckBox").val() == 1){
			if($("#policy_number").val() == ''){
				validation.push('policy_number');
			}
			if($("#next_service_ins_date").val() == ''){
				validation.push('next_service_ins_date');
			}
		}

		if($("#insuranceBillingCheckBox").val() == 1){
			if($("#ins_pro_name").val() == ''){
				validation.push('ins_pro_name');
				$('html,body').animate({ scrollTop: 1000 }, 0
				, function(){
					if ($('#ins_pro_name').val() == '') { $('#ins_pro_name').focus(); $('.company').addClass('active'); $('.claim').removeClass('active'); $('#insurance_company').addClass('active in'); $('#policyClaim').removeClass('active in'); return false; }
				});
			}

			if($("#contact_street").val() == ''){
				validation.push('contact_street');
				$('html,body').animate({ scrollTop: 1000 }, 0
				, function(){
					if ($('#contact_street').val() == '') { $('#contact_street').focus(); $('.company').addClass('active'); $('.claim').removeClass('active'); $('#insurance_company').addClass('active in'); $('#policyClaim').removeClass('active in'); return false; }
				});
			}
			if($("#contact_country").val() == ''){
				validation.push('contact_country');
				$('html,body').animate({ scrollTop: 1000 }, 0
				, function(){
					if ($('#contact_country').val() == '') { $('#contact_country').focus(); $('.company').addClass('active'); $('.claim').removeClass('active'); $('#insurance_company').addClass('active in'); $('#policyClaim').removeClass('active in'); return false; }
				});
			}
			if($("#contact_state").val() == ''){
				validation.push('contact_state');
				$('html,body').animate({ scrollTop: 1000 }, 0
				, function(){
					if ($('#contact_state').val() == '') { $('#contact_state').focus(); $('.company').addClass('active'); $('.claim').removeClass('active'); $('#insurance_company').addClass('active in'); $('#policyClaim').removeClass('active in'); return false; }
				});
			}

			if($("#ins_claim_type").val() == ''){
				validation.push('ins_claim_type');
				$('html,body').animate({ scrollTop: 1000 }, 0
				, function(){
					if ($('#ins_claim_type').val() == '') { $('#ins_claim_type').focus(); $('.company').addClass('active'); $('.claim').removeClass('active'); $('#insurance_company').addClass('active in'); $('#policyClaim').removeClass('active in'); return false; }
				});
			}
			
			if($("#policy_no").val() == ''){
				validation.push('policy_no');
				$('html,body').animate({ scrollTop: 1000 }, 0
				, function(){
					if ($('#policy_no').val() == '') { $('#policy_no').focus(); $('.claim').addClass('active'); $('.company').removeClass('active'); $('#policyClaim').addClass('active in'); $('#insurance_company').removeClass('active in'); return false; }
				});
			}
			if($("#ins_claim").val() == ''){
				validation.push('ins_claim');
				$('html,body').animate({ scrollTop: 1000 }, 0
				, function(){
					if ($('#ins_claim').val() == '') { $('#ins_claim').focus(); $('.claim').addClass('active'); $('.company').removeClass('active'); $('#policyClaim').addClass('active in'); $('#insurance_company').removeClass('active in'); return false; }
				});
			}

			if($("#ins_exp_date").val() == ''){
				validation.push('ins_exp_date');
				$('html,body').animate({ scrollTop: 1000 }, 0
				, function(){
					if ($('#ins_exp_date').val() == '') { $('#ins_exp_date').focus(); $('.claim').addClass('active'); $('.company').removeClass('active'); $('#policyClaim').addClass('active in'); $('#insurance_company').removeClass('active in'); return false; }
				});
			}
		}

		if(validation.length > 0){
			validation.forEach(function(val) {
				$('#'+val).addClass("border_error");
				$('#'+val).parent().addClass('has-error');
			});
			$("#jobsheet_status").val("");
			$('.bootstrap-select').selectpicker("refresh");
			swal({
					title: "Please fill all the mandatory fields",
					type: "error",
					confirmButtonClass: "btn-danger"
			});
			return false;
		}

		var data = [];

		if((service_items.length) <= 0){
			data.push('one');
		}

		if((service_package_items.length) <= 0){
			data.push('two');
		}

		if((product_items.length) <= 0){
			data.push('three');
		}

		if((data.length) > 2){
			$("#jobsheet_status").val("");
			$('.bootstrap-select').selectpicker("refresh");
			swal({
					title: "please add the items",
					type: "error",
					confirmButtonClass: "btn-danger"
			});
			return false;
		}

		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');
		$('#gif').show();	

		$.post('<?php echo site_url('mech_work_order_dtls/ajax/invoice_create'); ?>', {
			book_type : "G",
			convert_invoice : "Y",
			work_order_id : $("#work_order_id").val(),
			branch_id : $("#branch_id").val(),
			work_order_status: work_order_status,
			jobsheet_no : $("#jobsheet_no").val(),
			invoice_group_id : $("#invoice_group_id").val()?$("#invoice_group_id").val():'',
			url_key : $("#work_order_url_key").val(),
			customer_id : $("#customer_id").val(),
			customer_car_id : $("#customer_car_id").val(),
			user_address_id : $("#user_address_id").val(),
			current_odometer_reading : $("#current_odometer_reading").val(),
			fuel_level : $("#fuel_level").val(),
			jobsheet_status : $("#jobsheet_status").val(),
			ex_jobsheet_status : $("#ex_jobsheet_status").val(),
			work_from : $("#work_from").val(),
			work_from_id : $("#work_from_id").val(),
			issue_date : $("#issue_date").val(),
			start_date : $("#start_date").val(),
			end_date : $("#end_date").val(),
			refered_by_type : $("#refered_by_type").val(),
			refered_by_id : $("#refered_by_id").val(),
			issued_by : $("#issued_by").val(),
			assigned_to : $("#assigned_to").val(),
			invoice_number : $("#invoice_number").val(),
			check_in_id : $("#check_in_id").val(),
			serviceCheckBox : $("#serviceCheckBox").val(),
			next_service_km : $("#next_service_km").val(),
			next_service_date : $("#next_service_date").val(),
			insuranceCheckBox : $("#insuranceCheckBox").val(),
			policy_number : $("#policy_number").val(),
			next_service_ins_date : $("#next_service_ins_date").val(),
			ins_company_name : $("#ins_company_name").val(),
			job_type : $("#job_type").val(),
			description : $("#description").val(),
			mins_id : $("#mins_id").val(),
			insuranceBillingCheckBox : $("#insuranceBillingCheckBox").val(),
			ins_claim_type : $("#ins_claim_type").val(),
			ins_pro_name : $("#ins_pro_name").val(),
			ins_gstin_no : $("#ins_gstin_no").val(),
			contact_name: $("#contact_name").val(),
			contact_number : $("#contact_number").val(),
			contact_email : $("#contact_email").val(),
			contact_street : $("#contact_street").val(),
			contact_area : $("#contact_area").val(),
			contact_country: $("#contact_country").val(),
			contact_state : $("#contact_state").val(),
			contact_city : $("#contact_city").val(),
			contact_pincode : $("#contact_pincode").val(),
			ins_claim : $("#ins_claim").val(),
			policy_no : $("#policy_no").val(),
			driving_license : $("#driving_license").val(),
			ins_start_date : $("#ins_start_date").val(),
			ins_exp_date : $("#ins_exp_date").val(),
			surveyor_contact_no : $("#surveyor_contact_no").val(),
			surveyor_name : $("#surveyor_name").val(),
			surveyor_email : $("#surveyor_email").val(),
			idv_amount : $("#idv_amount").val(),
			ins_claim_no : $("#ins_claim_no").val(),
			date_of_claim : $("#date_of_claim").val(),
			claim_amount : $("#claim_amount").val(),
			ins_approved_amount : $("#ins_approved_amount").val(),
			ins_approved_date : $("#ins_approved_date").val(),
			ins_status : $("#ins_status").val(),		
			job_terms_condition : $('#job_ter_cond').html()?$('#job_ter_cond').html():'',		
			policy_excess : $("#policy_excess").val(),
			checkinArray: JSON.stringify(checkinArray),
			
			service_items : JSON.stringify(service_items),
			service_totals : JSON.stringify(service_totals),
			service_user_total: $(".total_user_service_price").html()?$(".total_user_service_price").html().replace(/,/g, ''):'',
			discountstate: $("#discountstate").val()?$("#discountstate").val():'',
			service_total_discount_pct: $("#service_discount").val()?$("#service_discount").val().replace(/,/g, ''):0,
			service_total_discount: $(".service_total_discount").html()?$(".service_total_discount").html().replace(/,/g, ''):0,
			service_total_taxable: $(".total_user_service_taxable").html()?$(".total_user_service_taxable").html().replace(/,/g, ''):0,
			service_total_gst_pct:  $("#total_service_tax").val()?$("#total_service_tax").val():0,
			service_total_gst: $(".total_servie_gst_price").html()?$(".total_servie_gst_price").html().replace(/,/g, ''):0,
			service_grand_total: $(".total_servie_invoice").html()?$(".total_servie_invoice").html().replace(/,/g, ''):0,

			service_package_items : JSON.stringify(service_package_items),
			service_package_totals : JSON.stringify(service_package_totals),
			service_package_user_total: $(".total_user_service_package_price").html()?$(".total_user_service_package_price").html().replace(/,/g, ''):'',
			packagediscountstate: $("#packagediscountstate").val()?$("#packagediscountstate").val():'',
			service_package_total_taxable: $(".total_user_service_package_taxable").html()?$(".total_user_service_package_taxable").html().replace(/,/g, ''):0,
			service_package_total_gst_pct:  $("#total_service_package_tax").val()?$("#total_service_package_tax").val():0,
			service_package_total_gst: $(".total_servie_package_gst_price").html()?$(".total_servie_package_gst_price").html().replace(/,/g, ''):0,
			service_package_grand_total: $(".total_servie_package_invoice").html()?$(".total_servie_package_invoice").html().replace(/,/g, ''):0,

			product_items: JSON.stringify(product_items),
			product_totals : JSON.stringify(product_totals),
			product_user_total: $(".total_user_product_price").html()?$(".total_user_product_price").html().replace(/,/g, ''):0,
			product_total_discount: $(".product_total_discount").html()?$(".product_total_discount").html().replace(/,/g, ''):0,
			product_total_taxable: $(".total_user_product_taxable").html()?$(".total_user_product_taxable").html().replace(/,/g, ''):0,
			product_total_gst: $(".total_user_product_gst").html()?$(".total_user_product_gst").html().replace(/,/g, ''):0,
			product_grand_total: $(".total_product_invoice").html()?$(".total_product_invoice").html().replace(/,/g, ''):0,
			total_taxable_amount: $(".total_taxable_amount").html()?$(".total_taxable_amount").html().replace(/,/g, ''):0,
			overall_discount_amount: $(".overall_discount_amount").html()?$(".overall_discount_amount").html().replace(/,/g, ''):0,
			total_tax_amount: $(".total_gst_amount").html()?$(".total_gst_amount").html().replace(/,/g, ''):0,
			grand_total: $(".grand_total").html()?$(".grand_total").html().replace(/,/g, ''):0,
			total_due_amount: $(".grand_total").html()?$(".grand_total").html().replace(/,/g, ''):'',
            total_due_amount_save: $("#total_due_amount_save").val()?$("#total_due_amount_save").val().replace(/,/g, ''):'',
			next_service_dt: $("#next_service_dt").val()?$("#next_service_dt").val():'',

			uploadCheckBox : $("#uploadCheckBox").val(),
			_mm_csrf: $('#_mm_csrf').val()
		}, function (data) {
			list = JSON.parse(data);
			if(list.success=='1'){
					notie.alert(1,'<?php _trans('toaster1');?>',2);
					setTimeout(function() {
						window.location = "<?php echo site_url('mech_invoices/create');?>/"+list.invoice_id;
					}, 1000);
				}else{
				$('#gif').hide();	
				notie.alert(3,'<?php _trans('toaster2');?>',2);
				$('.has-error').removeClass('has-error');
				for (var key in list.validation_errors) {
					$('#' + key).parent().addClass('has-error');
					$('.error_msg_' + key).show().empty().html(list.validation_errors[key]);
				}
			}
		});
				
			} else {
				swal({
					title: "Cancelled",
					type: "error",
					confirmButtonClass: "btn-danger"
				});
			}
		});

		}
	});
	
        
});
</script>