<style type="text/css">
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
}
#product_item_table input {
    padding-left: 0px;
    padding-right: 5px;
}
</style>
<?php $purchase_url_key = $purchase_details->url_key?$purchase_details->url_key:$this->mdl_mech_purchase->get_url_key(); ?>
<script src="<?php echo base_url(); ?>assets/mp_backend/js/purchase_expense.js"></script>
<script type="text/javascript">
	var currency_symbol = '<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;';
	var default_currency_digit  = parseInt('<?php echo $this->session->userdata("default_currency_digit")?$this->session->userdata("default_currency_digit"):0;?>');
	var getProductDetailsURL = '<?php echo site_url('mech_item_master/ajax/get_product_details'); ?>';
	var taxURL = '<?php echo site_url('mech_tax/ajax/gettaxDetails');?>';
	function getfile()
	{
		var filename = $('input[type=file]').val().split("\\");
		$("#fileName").val(filename[2]);
		$("#showError").hide();
	}
	function getDeleteUploadFIle(id,type)
    {
    	$("#file").val('');
    	var employee_id = $("#employee_id").val();

		if(type == "D"){
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

					$.post('<?php echo site_url('upload/getDeleteUploadData'); ?>', {
						entity_id : $('#purchase_id').val(),
						entity_type : 'P',
						upload_id : id,
						url_key : $("#url_key").val(),
						upload_type : type,
						_mm_csrf: $('#_mm_csrf').val()
					}, function (data) {
							var list = JSON.parse(data);

							if (list.success === 1) {
								swal({
										title: "The row is deleted successfully",
										text: "Your imaginary file has been deleted.",
										type: "success",
										confirmButtonClass: "btn-success"
									},
									function() {
										if(list.doclist.length > 0)
										{
											var htmlStr = '';
											var href = '<?php echo base_url()."uploads/purchase_files/";?>';
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
												htmlStr += '<td align="center" class="text-center"><span style="cursor: pointer" onclick="getDeleteUploadFIle(\''+list.doclist[i].upload_id+'\',\'D\')"><i class="fa fa-trash-o" aria-hidden="true"></i></span></td>';
												htmlStr += '</tr>';
											}
											htmlStr += '</tbody>';
											htmlStr += '</table>';
										
											$("#preview_section").empty().append(htmlStr);
										}else{
											$("#preview_section").empty().append('<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" > No Images found </div>');
										}
										$("#document_name").val('');
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
		}else{
			$.post('<?php echo site_url('upload/getDeleteUploadData'); ?>', {
				entity_id : $('#purchase_id').val(),
				entity_type : 'P',
				upload_id : id,
				url_key : $("#url_key").val(),
				upload_type : type,
				_mm_csrf: $('#_mm_csrf').val()
			}, function (data) {
				list = JSON.parse(data);
				if(list.success=='1'){
					// console.log(list.doclist.length);
					if(list.doclist.length > 0)
					{
						var htmlStr = '';
						var href = '<?php echo base_url()."uploads/purchase_files/";?>';
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
							htmlStr += '<td align="center" class="text-center"><span style="cursor: pointer" onclick="getDeleteUploadFIle(\''+list.doclist[i].upload_id+'\',\'D\')"><i class="fa fa-trash-o" aria-hidden="true"></i></span></td>';
							htmlStr += '</tr>';
						}
						htmlStr += '</tbody>';
						htmlStr += '</table>';
					
					$("#preview_section").empty().append(htmlStr);
					
					}else{
						$("#preview_section").empty().append('<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" > No Images found </div>');
					}
					$("#document_name").val('');	
				}
			});
		}
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
		$('#gif').show();
		$.post("<?php echo site_url('mech_item_master/ajax/getProductItemList'); ?>", {
			product_category_id: $('#product_category_id').val()?$('#product_category_id').val():'',
			product_brand_id: $("#product_brand_id").val()?$("#product_brand_id").val():'',
			brand_id: $('#brand_id').val()?$('#brand_id').val():'',
			model_id: $('#model_id').val()?$('#model_id').val():'',
			variant_id : $('#variant_id').val()?$('#variant_id').val():'',
			fuel_type: $("#fuel_type").val()?$("#fuel_type").val():'',
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
</script>
<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php _trans($breadcrumb); ?><?php if($purchase_details->purchase_no) { echo " - ".$purchase_details->purchase_no; } ?></h3>
				</div>
				<div class="tbl-cell pull-right">
					<a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_purchase/create'); ?>">
						<i class="fa fa-plus"></i> <?php _trans('lable40'); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</header>
<div class="box"> 
	<div class="row">
		<div id="gif" class="gifload">
			<div class="gifcenter">
			  <center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
		    </div>
		</div>
		<div class="col-xs-12 top-15">
			<a class="anchor anchor-back" onclick="goBack()" href="<?php echo site_url('mech_purchase/index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
		</div>
	</div>
	<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
	<input type="hidden" name="purchase_id" id="purchase_id" value="<?php echo $purchase_details->purchase_id; ?>">
	<input type="hidden" name="url_key" id="url_key" value="<?php echo $purchase_url_key; ?>">
	<input type="hidden" name="purchase_no" id="purchase_no" value="<?php echo $purchase_details->purchase_no; ?>">
	<div class="box_body col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sideHeading">
			<span><?php _trans('lable432'); ?></span>
		</div>
		<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<label class="form_label"><?php _trans('lable34'); ?>.*</label>
			<div class="form_controls">
				<input type="text" name="purchase_number" id="purchase_number" class="form-control" value="<?php echo $purchase_details->purchase_number; ?>" autocomplete="off">
			</div>
		</div>
		<div class="form_group col-sm-4 col-md-4 col-lg-4 col-xs-12">
			<label class="form_label"><?php _trans('lable51'); ?>*</label>
			<select id="w_branch_id" name="w_branch_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
				<?php foreach ($branch_list as $branchList) {?>
				<option value="<?php echo $branchList->w_branch_id; ?>" <?php if($purchase_details->w_branch_id == $branchList->w_branch_id){echo "selected";}?> > <?php echo $branchList->display_board_name; ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-sm-4 col-md-4 col-lg-4 col-xs-12 form_group">
			<label class="form_label"><?php _trans('lable433'); ?>. *</label>
			<select name="invoice_group_id" id="invoice_group_id" <?php if($purchase_details->purchase_status != 'D' && $purchase_details->purchase_status != '' && $purchase_details->invoice_group_id != '' ){ echo 'disabled'; } ?> class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
				<?php if(count($invoice_group) != 1){ ?>
					<option value=""><?php _trans('lable277'); ?></option>
				<?php } ?>
				<?php foreach ($invoice_group as $invoice_group_list) {
					if (!empty($purchase_details)) {
						if ($purchase_details->invoice_group_id == $invoice_group_list->invoice_group_id) {
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
			<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<label class="form_label"><?php _trans('lable434'); ?> *</label>
				<div class="form_controls">
					<select name="purchase_type_id" id="purchase_type_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
						<option value=""><?php _trans('lable435'); ?></option>
						<option value="1" <?php if ($purchase_details->purchase_type_id == 1) {
    echo "selected='selected'";
} ?> ><?php _trans('lable436'); ?></option>
						<option value="2" <?php if ($purchase_details->purchase_type_id == 2) {
    echo "selected='selected'";
} ?> ><?php _trans('lable437'); ?></option>
						<option value="3" <?php if ($purchase_details->purchase_type_id == 3) {
    echo "selected='selected'";
} ?> ><?php _trans('lable438'); ?></option>
						<option value="4" <?php if ($purchase_details->purchase_type_id == 4) {
    echo "selected='selected'";
} ?> ><?php _trans('lable439'); ?></option>
						<option value="5" <?php if ($purchase_details->purchase_type_id == 5) {
    echo "selected='selected'";
} ?> ><?php _trans('lable440'); ?></option>
						<option value="6" <?php if ($purchase_details->purchase_type_id == 6) {
    echo "selected='selected'";
} ?> ><?php _trans('lable441'); ?></option>
						<option value="7" <?php if ($purchase_details->purchase_type_id == 7) {
    echo "selected='selected'";
} ?> ><?php _trans('lable442'); ?></option>
						<option value="8" <?php if ($purchase_details->purchase_type_id == 8) {
    echo "selected='selected'";
} ?> ><?php _trans('lable443'); ?></option>
						<option value="9" <?php if ($purchase_details->purchase_type_id == 9) {
    echo "selected='selected'";
} ?> ><?php _trans('lable444'); ?></option>
					</select>
				</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 sideHeading">
			<span><?php _trans('lable445'); ?></span>
		</div>
		<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<label class="form_label"> <?php _trans('lable80'); ?>*</label>
			<div class="form_controls">
				<select name="supplier_id" id="supplier_id" class="credit_period bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" >
					<option value=""><?php echo trans('lable429'); ?></option>
					<?php foreach ($supplier_details as $supplier): ?>
						<option data-credit-period="<?php echo $supplier->credit_period; ?>" value="<?php echo $supplier->supplier_id; ?>"
							<?php if ($supplier->supplier_id == $purchase_details->supplier_id) {
								echo 'selected="selected"';
								} ?> data-gstin="<?php echo $supplier->supplier_gstin; ?>"
							>
							<?php _htmlsc($supplier->supplier_name); ?>
						</option>
					<?php endforeach; ?>
				</select>
				
			</div>
		</div>
		
		<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<label class="form_label"><?php _trans('lable84'); ?></label>
			<div class="form_controls">
				<input type="text" name="supplier_gstin" id="supplier_gstin" class="form-control" value="<?php echo $purchase_details->supplier_gstin; ?>">
			</div>
		</div>
		
		<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<label class="form_label"><?php _trans('lable446'); ?> *</label>
			<div class="form_controls">
				<select name="place_of_supply_id" id="place_of_supply_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
					<option value=""><?php echo trans('lable447'); ?></option>
					<?php foreach ($states as $state): ?>
						<option value="<?php echo $state->state_id; ?>"
							<?php if ($state->state_id == $purchase_details->place_of_supply_id) {
echo 'selected="selected"';
} ?>
							>
							<?php _htmlsc($state->state_id.'-'.$state->state_name); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<label class="form_label"> <?php _trans('lable386'); ?>*</label>
			<div class="form_controls">
				<input type="text" onchange="changeDueDatebyCreated('purchase_date_created','in_days','purchase_date_due')" name="purchase_date_created" id="purchase_date_created" class="form-control removeError datepicker" value="<?php echo ($purchase_details->purchase_date_created?date_from_mysql($purchase_details->purchase_date_created):date_from_mysql(date('Y-m-d'))); ?>">
			</div>
		</div>
		<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<label class="form_label"><?php _trans('lable387'); ?></label>
			<div class="form_controls">
					<input type="text" onkeyup="changeDueDatebyDay('purchase_date_created','in_days','purchase_date_due')" onchange="changeDueDatebyDay('purchase_date_created','in_days','purchase_date_due')" name="in_days" id="in_days" class="form-control" value="<?php echo $purchase_details->in_days; ?>">
			</div>
		</div>
		<div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<label class="form_label"> <?php _trans('lable127'); ?>*</label>
			<div class="form_controls">
				<input type="text" onchange="changeCreditPeriodbyDueDate('purchase_date_created','in_days','purchase_date_due')" name="purchase_date_due" id="purchase_date_due" class="form-control removeError datepicker" value="<?php echo $purchase_details->purchase_date_due?date_from_mysql($purchase_details->purchase_date_due):''; ?>">
			</div>
		</div>
		<?php $this->layout->load_view('mech_purchase/partial_product_table'); ?>
		<div class="row">
			<div class="col-lg-12 paddingTop20px">
				<div class="col-lg-6 terms-and-conditions">
                    <div class="form_group col-lg-12 col-md-12 col-sm-12 col-xs-12" style="display: none;">
                        <label class="form_label"><?php echo trans('lable81'); ?></label>
                        <div class="form_controls">
                            <select name="bank_id" id="bank_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" >
                                <option value=""><?php echo trans('lable390'); ?></option>
                                <?php foreach ($bank_list as $bank): ?>
                                <option value="<?php echo $bank->bank_id; ?>"
                                    <?php if ($bank->bank_id == $purchase_details->bank_id) {
    echo 'selected="selected"';
} ?>
                                    >
                                    <?php _htmlsc($bank->bank_name); ?>
                                </option>
                                <?php endforeach; ?>    
                            </select>
                        </div>
                    </div>
                </div>
				<div class="col-lg-5 col-md-8 col-sm-8 clearfix" style="float: right">
					<div class="row">
						<input type="hidden" class="total_user_product_price" value="" >
						<input type="hidden" class="product_total_discount" value="" >
						<input type="hidden" class="total_user_product_taxable" value="" >
						<input type="hidden" class="total_user_product_gst" value="" >
						<input type="hidden" class="total_product_invoice" value="" >
						<input type="hidden" class="total_taxable_amount" value="" >
						<input type="hidden" class="total_gst_amount" value="" >
						<div class="col-lg-9 col-md-9 col-sm-9 clearfix">
							<b><?php _trans('lable332'); ?></b><br>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-3 price clearfix">
							<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<b class="grand_total">0.00</b>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-9 col-md-9 col-sm-9 clearfix">
							<?php _trans('lable1020'); ?>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-3 price clearfix">
							<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<span class="advance_amount_label"><?php echo $purchase_details->total_paid_amount?$purchase_details->total_paid_amount:0.00; ?></span>
						</div>
						<input type="hidden" id="advance_paid_amount" name="advance_paid_amount" value="<?php echo $purchase_details->total_paid_amount;?>" autocomplete="off">
					</div>
					<div class="row">
						<div class="col-lg-9 col-md-9 col-sm-9 clearfix">
							<?php _trans('lable1021'); ?>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-3 price clearfix">
							<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<span class="total_due_amount_lable"><?php echo $purchase_details->total_due_amount?$purchase_details->total_due_amount:0.00; ?></span>
						</div>
						<input type="hidden" id="total_due_amount" name="total_due_amount" value="<?php echo $purchase_details->total_due_amount;?>" autocomplete="off">
						<input type="hidden" id="total_due_amount_save" name="total_due_amount_save" value="<?php echo $purchase_details->total_due_amount;?>" autocomplete="off">
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" id="upload_section">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 import_invoice_title padding_left_15px paddingTop20px"><h5><?php echo trans('lable448'); ?></h5></div>
					<form class="col-xl-12 col-lg-12 col-md-12 col-sm-12 upload" upload-id="upload_csv_add" id="upload_csv_add" method="post" enctype="multipart/form-data">
						<input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
						<div class="form-group clearfix">
							<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 text-right paddingTop7px">
								<label class="control-label string required"><?php _trans('lable179'); ?></label>
							</div>
							<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
								<input type="text" name="document_name" id="document_name" class="form-control" value="">
							</div>
							<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 paddingTop7px">
								<input type="file" id="file" onchange="getfile()" class="inputTypeFile inputfile" name="file" />
								<input type="hidden" id="fileName" name="fileName" value="" />
								<div id="showError" class="errorColor" style="display:none;" ><?php _trans('lable181'); ?></div>
							</div>
							<div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 paddingTop7px">
								<span class="text-center">
									<button type="submit">
										<i class="fa fa-upload" aria-hidden="true"></i>
									</button>
								</span>
							</div>
						</div>
					</form>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div id="preview_section" class="preview_uploads col-xs-12 col-sm-12 col-md-12 col-lg-12 paddingTop20px">
						<?php if(count($upload_details) > 0) { ?>
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
										<a href="<?php echo base_url()."uploads/purchase_files/".$documentList->file_name_new?>" target="_blank" >
											<img src="<?php echo base_url()."uploads/purchase_files/".$documentList->file_name_new?>" width="50" height="50">
										</a>
									</span></td>
									<td align="center" class="text-center"><span style="cursor: pointer" onclick="getDeleteUploadFIle('<?php echo $documentList->upload_id; ?>','D')"><i class="fa fa-trash-o" aria-hidden="true"></i></span></td>
								</tr>
								<?php }  ?>
							</tbody>
						</table>
						<?php } else { ?>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center paddingTop20px" ><?php _trans('lable451'); ?> </div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<div class="row invoiceFloatbtn">
			<div class="buttons text-right">
				<input type="hidden" name="existing_purchase_status" id="existing_purchase_status" value="<?php echo $purchase_details->purchase_status; ?>" />
				<button id="btn_submit" name="btn_submit" class="btn_submit btn btn-rounded btn-primary" value="G">
				    <i class="fa fa-check"></i> <?php _trans('lable449'); ?>
				</button>
				<?php if ($purchase_details->purchase_status == 'D' || $purchase_id == '') { ?>
					<button id="btn_submit" name="btn_submit" class="btn_submit btn btn-rounded btn-primary" value="D">
				    	<i class="fa fa-check"></i> <?php _trans('lable450'); ?>
					</button>
				<?php } ?>
				<button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default" value="1">
				    <i class="fa fa-times"></i> <?php _trans('lable58'); ?>
				</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">

$('.credit_period').change(function() { 
	var credit_period = $("#supplier_id").find('option:selected').attr('data-credit-period');
         $("#in_days").val(credit_period);
		 changeDueDatebyCreated('purchase_date_created','in_days','purchase_date_due');
});

$(document).ready(function(){

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

		$.ajax({
			url : "<?php echo site_url('upload/upload/upload_file/'.($purchase_details->purchase_id?$purchase_details->purchase_id:'0').'/P/'.($purchase_url_key)); ?>/",
			method:"POST",
			data : new FormData(this),
			contentType:false,
			cache:false,
			processData:false,
			success: function(data){
				var response = JSON.parse(data);
				if(response.success=='1'){
					getDeleteUploadFIle('','U');
				}else{
					$('#showError').empty().append('invalid file format');
					$('#showError').show();
				}
			}
		});
	});
    
	$("#btn_cancel").click(function () {
        window.location.href = "<?php echo site_url('mech_purchase'); ?>";
	}); 

	$("#reset_filter").click(function(){
		$("#brand_id").val('');
		$('#brand_id').selectpicker("refresh");
		$("#model_id").val('');
		$('#model_id').selectpicker("refresh");
		$("#variant_id").val('');
		$('#variant_id').selectpicker("refresh");
		$("#fuel_type").val('');
		$('#fuel_type').selectpicker("refresh");
		$("#product_category_id").val(0);
		$('#product_category_id').selectpicker("refresh");
		$("#product_brand_id").val(0);
		$('#product_brand_id').selectpicker("refresh");
		$('#services_item_product_id').val(0);
		$('#services_item_product_id').selectpicker("refresh");
	});
    
    $(".btn_submit").click(function () {

		var validation = [];
		if($("#purchase_number").val() == ''){
			validation.push('purchase_number');
		}
		if($("#w_branch_id").val() == ''){
			validation.push('w_branch_id');
		}
		if($("#invoice_group_id").val() == ''){
			validation.push('invoice_group_id');
		}
		if($("#purchase_type_id").val() ==''){
			validation.push('purchase_type_id');
		}
		if($("#purchase_date_created").val() ==''){
			validation.push('purchase_date_created');
		}
		if($("#purchase_date_due").val() ==''){
			validation.push('purchase_date_due');
		}
		if($("#supplier_id").val() == ''){
			validation.push('supplier_id');
		}
		if($("#place_of_supply_id").val() == ''){
			validation.push('place_of_supply_id');
		}

		if(validation.length > 0){
			validation.forEach(function(val){
				$('#' + val).parent().addClass('has-error');
				$('#'+val).addClass("border_error");
				if($('#'+val+'_error').length == 0){
					$('#'+val).parent().addClass('has_error');
				}
			});
			notie.alert(3, '<?php _trans('toaster2');?>', 2);
			return false;
		}
	
        var product_items = [];
        $('table#product_item_table tbody>tr.item').each(function () {
            var product_row = {};
            $(this).find('input,select,textarea').each(function () {
                if ($(this).is(':checkbox')) {
                    product_row[$(this).attr('name')] = $(this).is(':checked');
                } else {
                    if($(this).attr('name') == 'item_product_id'){
                        if($(this).val() == 0 || $(this).val() == ''){
                            $(this).parent().find('.error_msg_item_product_id').remove();
                            $(this).parent().append('<label class="pop_textbox_error_msg error_msg_item_product_id"><?php _trans('err3'); ?></label>');
                        }else{
                            product_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');    
                        }
                    }else{
                        product_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
                    }
                }
            });
            product_items.push(product_row);
		});
		
		if($('#existing_purchase_status').val() == 'G'){
			var purchase_status = 'G';
		}else if($('#existing_purchase_status').val() == '' || $('#existing_purchase_status').val() == 'D'){
			var purchase_status = $(this).val();
		}else{
			var purchase_status = $('#existing_purchase_status').val();
		}
		$('#gif').show();
        $.post('<?php echo site_url('mech_purchase/ajax/purchase_save'); ?>', {
            purchase_id : $("#purchase_id").val(),
			url_key : $("#url_key").val()?$("#url_key").val():'',
			w_branch_id: $("#w_branch_id").val()?$("#w_branch_id").val():'',
            purchase_number : $('#purchase_number').val()?$('#purchase_number').val():'',
            purchase_no : $("#purchase_no").val()?$("#purchase_no").val():'',
			purchase_status: purchase_status,
			invoice_group_id :$("#invoice_group_id").val()?$("#invoice_group_id").val():'',
            bank_id: $('#bank_id').val()?$('#bank_id').val():'',
            purchase_date_created : $('#purchase_date_created').val()?$('#purchase_date_created').val():'',
            purchase_date_due : $('#purchase_date_due').val()?$('#purchase_date_due').val():'',
            in_days : $("#in_days").val()?$("#in_days").val():'',
            supplier_id : $("#supplier_id").val()?$("#supplier_id").val():'',
            purchase_type_id : $("#purchase_type_id").val()?$("#purchase_type_id").val():'',
            place_of_supply_id: $('#place_of_supply_id').val()?$('#place_of_supply_id').val():'',
			supplier_gstin: $('#supplier_gstin').val()?$('#supplier_gstin').val():'',
			parts_discountstate : $("#parts_discountstate").val(),
            product_items: JSON.stringify(product_items),
			product_user_total: $(".total_user_product_price").val()?$(".total_user_product_price").val().replace(/,/g, ''):0,
            total_taxable_amount : $(".total_user_product_taxable").val().replace(/,/g, ''),
            total_discount:$('.product_total_discount').val().replace(/,/g, ''),
            total_tax_amount:$(".total_user_product_gst").val().replace(/,/g, ''),
            grand_total:$('.total_product_invoice').val().replace(/,/g, ''),
            _mm_csrf: $('#_mm_csrf').val()
        }, function (data) {
            list = JSON.parse(data);
            if(list.success=='1'){
                if (purchase_status == "D") {
					notie.alert(1,'<?php _trans('toaster1');?>',2);
					setTimeout(function() {
						window.location = "<?php echo site_url('mech_purchase'); ?>";
					}, 1000);
				} else {
					notie.alert(1,'<?php _trans('toaster1');?>',2);
					setTimeout(function() {
						window.location = "<?php echo site_url('mech_purchase/view'); ?>/"+list.purchase_id+"/";
					}, 1000);
				}
            }else if (list.success == '2') {
				$('#gif').hide();
				notie.alert(3, '<?php _trans('toaster2');?>', 2);
			}else if(list.success == '3') {
				$('#gif').hide();	
				notie.alert(3,list.msg,2);
			}else{
				$('#gif').hide();
                for (var key in list.validation_errors) {
                    $('#' + key).parent().addClass('has-error');
                    $('.error_msg_' + key).show().empty().html(list.validation_errors[key]);
                }
            }
        });
    });
});
</script>
