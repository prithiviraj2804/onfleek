<?php $product_url_key = $this->mdl_products->form_value('url_key', true)?$this->mdl_products->form_value('url_key', true):$this->mdl_products->get_url_key(); ?>
<style>
	#products_form .tax_percentage{
		    width: 48%;
    		float: inherit;
	}
	#products_form .tax_amount{
		    width: 48%;
    		float: right;
	}
</style>
<script type="text/javascript">
function getfile(){
	var filename = $('input[type=file]').val().split("\\");
	$("#fileName").val(filename[2]);
	$("#showError").hide();
}

function getproductUploadFiles(url_key){
	if(url_key){
		$.post('<?php echo site_url('products/ajax/getUploadedImages'); ?>', {
			url_key : url_key,
			_mm_csrf : $('#_mm_csrf').val()
		}, function (data) {
			list = JSON.parse(data);
			if(list.success == '1'){
				if(list.productImages.length > 0){
					var html = '';
					var hrefs = '<?php echo base_url()."uploads/customer_files/";?>';
					for(var i = 0; i<list.productImages.length; i++){

						html += '<li>';
						html += '<span class="spanOne">';
						html += '<a href="'+hrefs+''+list.productImages[i].file_name_new+'" target="_blank" >';
						html += '<img src="'+hrefs+''+list.productImages[i].file_name_new+'" width="100%" height="100%">';
						html += '</a></span>';
						html += '<span class="spanTwo" onclick="getDeleteUploadFIle(\''+list.productImages[i].upload_id+'\',\'D\',\''+list.productImages[i].file_name_original+'\')">';
						html += '<i class="fa fa-trash-o" aria-hidden="true"></i></span></li>';
					}
					$("#productImagesBox").empty().append(html);
				}else{
					$("#productImagesBox").empty().append('');
				}
			}
		});
	}
}

function getDeleteUploadFIle(id,type,file_name)
{
	$("#file").val('');
	var product_id = $("#product_id").val();

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
					entity_id : $('#product_id').val(),
					entity_type : 'pro',
					file_name: file_name,
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
									if(list.doclist.length > 0){
										var html = '';
										var href = '<?php echo base_url()."uploads/customer_files/";?>';
										for(var i = 0; i<list.doclist.length; i++){
											html += '<li>';
											html += '<span class="spanOne">';
											html += '<a href="'+href+''+list.doclist[i].file_name_new+'" target="_blank" >';
											html += '<img src="'+href+''+list.doclist[i].file_name_new+'" width="100%" height="100%">';
											html += '</a></span>';
											html += '<span class="spanTwo" onclick="getDeleteUploadFIle(\''+list.doclist[i].upload_id+'\',\'D\',\''+list.doclist[i].file_name_original+'\')">';
											html += '<i class="fa fa-trash-o" aria-hidden="true"></i></span></li>';
										}
										$("#productImagesBox").empty().append(html);
									}else{
										$("#productImagesBox").empty().append('');
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
	}else{
		$.post('<?php echo site_url('upload/getDeleteUploadData'); ?>', {
			entity_id : $('#purchase_id').val(),
			entity_type : 'pro',
			upload_id : id,
			file_name: file_name,
			url_key : $("#url_key").val(),
			upload_type : type,
			_mm_csrf: $('#_mm_csrf').val()
		}, function (data) {
			list = JSON.parse(data);
			if(list.success=='1'){
				if(list.doclist.length > 0){
					var html = '';
					var href = '<?php echo base_url()."uploads/customer_files/";?>';
					for(var i = 0; i<list.doclist.length; i++){
						html += '<li>';
						html += '<span class="spanOne">';
						html += '<a href="'+href+''+list.doclist[i].file_name_new+'" target="_blank" >';
						html += '<img src="'+href+''+list.doclist[i].file_name_new+'" width="100%" height="100%">';
						html += '</a></span>';
						html += '<span class="spanTwo" onclick="getDeleteUploadFIle(\''+list.doclist[i].upload_id+'\',\'D\',\''+list.doclist[i].file_name_original+'\')">';
						html += '<i class="fa fa-trash-o" aria-hidden="true"></i></span></li>';
					}
					$("#productImagesBox").empty().append(html);
				}else{
					$("#productImagesBox").empty().append('');
				}
			}
		});
	}
}
</script>
<div>
	<input type="hidden" id="_mm_csrf" name="_mm_csrf" value="<?= $this->security->get_csrf_hash(); ?>">
	<header class="page-content-header">
		<div class="container-fluid">
			<div class="tbl">
				<div class="tbl-row">
					<div class="tbl-cell">
						<h3><?php echo _trans($breadcrumb); ?></h3>
					</div>
					<div class="tbl-cell pull-right">
                   		<a class="btn btn-sm btn-primary" href="<?php echo site_url('products/form'); ?>">
                       		<i class="fa fa-plus"></i> <?php _trans('lable40'); ?>
                     	</a>
					</div>
				</div>
			</div>	
		</div>
	</header>
	<div id="content">
        <div class="row">
		<div id="gif" class="gifload">
			<div class="gifcenter">
			  <center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
		    </div>
		</div>
			<div class="col-xs-12 top-15">
				<a class="anchor anchor-back" onclick="goBack()" href="#"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
			</div>
            <div class="col-xs-12 col-md-12">
				<div class="container-fluid">
					<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 col-xl-12">
						<input class="hidden" name="product_id" id="product_id" value="<?php echo $this->mdl_products->form_value('product_id', true); ?>" type="hidden" >
						<input class="hidden" name="parent_id" id="parent_id" value="<?php echo ($this->mdl_products->form_value('parent_id', true)?$this->mdl_products->form_value('parent_id', true):1); ?>" type="hidden" >
						<input type="hidden" id="url_key" value="<?php echo $product_url_key;?>" >
						<input class="hidden" name="is_update" type="hidden"
						<?php if($this->mdl_products->form_value('is_update')){echo 'value="1"';} else{ echo 'value="0"'; } ?>>
						<div class="box">
							<div class="box_body">
								<div class="row">
									<div class="col-xs-4 col-md-4">
										<div class="form_group">
											<label class="form_label"> <?php _trans('lable207'); ?> *</label>
											<div class="form_controls">
												<input type="text" name="product_name" id="product_name" class="form-control" value="<?php echo $this->mdl_products->form_value('product_name', true); ?>">
											</div>
										</div>	
									</div>
									<div class="col-xs-4 col-md-4">
										<div class="form_group">
											<label class="form_label"><?php  _trans('lable219'); ?> *</label>
											<div class="form_controls">
												<select name="product_category_id" id="product_category_id" class="bootstrap-select bootstrap-select-arrow removeError" data-live-search="true">
													<option value=""><?php _trans('lable209'); ?></option>
													<?php foreach ($families as $family) { ?>
														<option value="<?php echo $family->family_id; ?>"
															<?php check_select($this->mdl_products->form_value('product_category_id'), $family->family_id); ?>
														><?php echo $family->family_name; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
									<div class="col-xs-4 col-md-4">
										<div class="form_group">
											<label class="form_label"> <?php  _trans('lable220'); ?></label>
											<div class="form_controls">
												<select name="unit_type" id="unit_type" class="bootstrap-select bootstrap-select-arrow g-input" data-live-search="true">
													<option value="0"><?php _trans('lable221'); ?></option>
													<?php foreach ($units as $unit) { ?>
														<option value="<?php echo $unit->unit_id; ?>"
															<?php check_select($this->mdl_products->form_value('unit_type'), $unit->unit_id); ?>
														><?php echo $unit->unit_name.'/'.$unit->unit_name_plrl; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>
									<div class="col-xs-4 col-md-4">
										<div class="form_group">
											<label class="form_label"> <?php _trans('lable223'); ?>.</label>
											<div class="form_controls">
												<input type="text" name="rack_no" id="rack_no" class="form-control" value="<?php echo $this->mdl_products->form_value('rack_no', true); ?>">
											</div>
										</div>
									</div>
									<div class="col-xs-4 col-md-4">
										<div class="form_group">
											<label class="form_label"> <?php  _trans('lable227'); ?></label>
											<div class="form_controls">
												<input type="text" name="tax_percentage" id="tax_percentage" class="form-control"
											value="<?php echo $this->mdl_products->form_value('tax_percentage'); ?>">
											</div>
										</div>
									</div>
								</div>
								<div class="row paddingTop20px">
									<div class="col-xs-6 col-md-6">
										<div class="form_group">
											<div class="form_controls">
												<input id="apply_for_all_bmv" name="apply_for_all_bmv" <?php if($this->mdl_products->form_value('apply_for_all_bmv', true) == 'Y'){ echo "checked"; } ?> type="checkbox" value="<?php echo ($this->mdl_products->form_value('apply_for_all_bmv', true)?$this->mdl_products->form_value('apply_for_all_bmv', true):'N'); ?>" >
												<span><?php  _trans('lable228'); ?> </span>
											</div>
										</div>
									</div>
								</div>
								<div class="row bodyType" <?php if($this->mdl_products->form_value('apply_for_all_bmv', true) == 'Y'){ echo 'style="display:block"'; }else{ echo 'style="display:none"';}?>>
									<div class="col-xs-4 col-md-4">
										<div class="form_group">
											<label class="form_label"> <?php _trans('lable218'); ?></label>
											<div class="form_controls">
												<input type="text" name="hsn_item_code" id="hsn_item_code" class="form-control" value="<?php echo $this->mdl_products->form_value('hsn_code', true); ?>">
											</div>
										</div>
									</div>
									<div class="col-xs-4 col-md-4">
										<div class="form_group">
											<label class="form_label"> <?php _trans('lable222'); ?></label>
											<div class="form_controls">
												<input type="text" name="reorder_quantity" id="reorder_quantity" class="form-control" value="<?php echo $this->mdl_products->form_value('reorder_quantity', true); ?>">
											</div>
										</div>
									</div>
									<div class="col-xs-4 col-md-4">
										<div class="form_group">
											<label class="form_label"> <?php  _trans('lable224'); ?></label>
											<div class="form_controls">
												<input type="text" name="cost_price" id="cost_price" class="twodigit form-control" value="<?php echo format_amount($this->mdl_products->form_value('cost_price')); ?>">
											</div>
										</div>
									</div>
									<div class="col-xs-4 col-md-4">
										<div class="form_group">
											<label class="form_label"> <?php  _trans('lable225'); ?></label>
											<div class="form_controls">
												<input type="text" name="sale_price" id="sale_price" class="twodigit form-control"
											value="<?php echo format_amount($this->mdl_products->form_value('sale_price')); ?>">
											</div>
										</div>
									</div>
								</div>
								<div class="row table-details modelandvariants"  <?php if($this->mdl_products->form_value('apply_for_all_bmv', true) == 'Y'){ echo 'style="display:none"'; }else{ echo 'style="display:block"';}?>>
									<div class="col-lg-12">
										<section class="box-typical">
											<div class="box-typical-body">
												<div class="table-responsive">
													<table class="display table table-bordered" id="product_item_table" width="100%" style="width:100%;float:left;table-layout: fixed;">
														<thead>
															<th width="2%" style="max-width:2%;width:2%;" class="text-center"><?php _trans('lable346'); ?></th>
															<th width="20%" style="max-width:20%;width:20%;"><?php _trans('lable882'); ?></th>
															<th width="14%" style="max-width:14%;width:14%;" class="text-left"><?php _trans('lable229'); ?></th>
															<th width="14%" style="max-width:14%;width:14%;" class="text-left"><?php _trans('lable231'); ?></th>
															<th width="14%" style="max-width:14%;width:14%;" class="text-left"><?php _trans('lable232'); ?></th>
															<th width="10%" style="max-width:10%;width:10%;" class="text-left"><?php _trans('lable132'); ?></th>
															<th width="6%" style="max-width:6%;width:6%;" class="text-center"><?php _trans('lable222'); ?></th>
															<th width="10%" style="max-width:10%;width:10%;" class="text-right"><?php _trans('lable224'); ?></th>
															<th width="10%" style="max-width:10%;width:10%;" class="text-right"><?php _trans('lable225'); ?></th>
															<th width="2%" style="max-width:2%;width:2%;"></th>
														</thead>
														<tbody>
														<?php if(count($subproducts) > 0) { $i = 1;
														foreach ($subproducts as $product) {  ?>
															<tr class="item" id="tr_<?php echo $product->product_id; ?>">
																<input type="hidden" name="subpro_id" value="<?php echo $product->product_id; ?>">
																<input type="hidden" name="duplicate_subpro_id" value="<?php echo $product->product_id; ?>">
																<td width="2%" style="max-width:2%;width:2%;" class="item_sno text-center"><?php echo $i; $i++; ?></td>
																<td width="20%" style="max-width:20%;width:20%;">
																	<div style="width:100%;">
																		<input type="text" name="subProductName" id="subProductName_<?php echo $product->product_id; ?>" class="subProductName form-control" value="<?php echo $product->product_name;?>" onkeyup="product_name(<?php echo $product->product_id; ?>);">
																	</div>
																	<div style="width:100%;padding-top:10px;">
																		<lable style="width: 40%;float: left;font-size: 12px;padding-top: 10px;"><?php _trans('lable218'); ?></lable>
																		<input style="width: 60%;float: left;" type="text" name="hsn_code" id="hsn_code_<?php echo $product->product_id; ?>" class="hsn_code form-control" value="<?php echo $product->hsn_code; ?>">
																	</div>
																</td>
																<td width="14%" style="max-width:14%;width:14%;" class="text-left">
																	<select name="brand_id" class="brand_id select2" id="brand_id_<?php echo $product->product_id; ?>" onchange="getModelList(<?php echo $product->product_id; ?>)">
																		<option value="0"><?php  _trans('lable73'); ?></option>
																		<?php if(!empty($car_brand_list)){
																		foreach($car_brand_list as $brand_list){ ?>
																			<option value="<?php echo $brand_list->brand_id; ?>" <?php if($product->brand_id == $brand_list->brand_id){ echo "selected"; } ?> ><?php echo $brand_list->brand_name; ?></option>
																		<?php } } ?>
																	</select>
																</td>
																<td width="14%" style="max-width:14%;width:14%;" class="text-left">
																	<select name="model_id" class="model_id select2" id="model_id_<?php echo $product->product_id;?>" onchange="getvariantList(<?php echo $product->product_id; ?>)">
																		<option value=""><?php  _trans('lable74'); ?></option>
																		<?php if(!empty($car_model_list)){
																			foreach ($car_model_list as $model_list){ ?>
																			<option value="<?php echo $model_list->model_id; ?>" <?php if($product->model_id == $model_list->model_id){ echo "selected"; } ?> ><?php echo $model_list->model_name;?></option>
																		<?php }}?>
																	</select>
																</td>
																<td width="14%" style="max-width:14%;width:14%;" class="text-left">
																	<select name="variant_id" class="variant_id select2" id="variant_id_<?php echo $product->product_id;?>">
																		<option value=""><?php  _trans('lable75'); ?></option>
																		<?php if ($car_variant_list){
																		foreach ($car_variant_list as $names){ ?>
																		<option value="<?php echo $names->brand_model_variant_id; ?>" <?php if($product->variant_id == $names->brand_model_variant_id){ echo "selected"; } ?>><?php echo $names->variant_name; ?></option>
																		<?php } } ?>
																	</select>
																</td>
																<td width="10%" style="max-width:10%;width:10%;" class="text-left">
																	<select name="fuel_type" class="fuel_type select2" id="fuel_type_<?php echo $product->product_id; ?>">
																		<option value=""></option>
																		<option value="P" <?php if($product->fuel_type == "P"){ echo "selected"; } ?>>Petrol</option>
																		<option value="D" <?php if($product->fuel_type == "D"){ echo "selected"; } ?>>Diesel</option>
																		<option value="G" <?php if($product->fuel_type == "G"){ echo "selected"; } ?>>CNG</option>
																	</select>
																</td>
																<td width="6%" style="max-width:6%;width:6%;" class="text-center">
																	<input type="text" name="reorder_qty" id="reorder_qty_<?php echo $product->product_id; ?>" class="reorder_qty form-control text-center" value="<?php echo $product->reorder_quantity;?>">
																</td>
																<td width="10%" style="max-width:10%;width:10%;" class="text-right">
																	<input type="text" name="cost_pr" id="cost_pr_<?php echo $product->product_id; ?>" class="cost_pr twodigit form-control text-right" value="<?php echo $product->cost_price;?>">
																</td>
																<td width="10%" style="max-width:10%;width:10%;" class="text-right">
																	<input type="text" name="sale_pr" id="sale_pr_<?php echo $product->product_id; ?>" class="sale_pr twodigit form-control text-right" value="<?php echo $product->sale_price;?>">
																</td>
																<td width="2%" style="max-width:2%;width:2%;" >
																	<span onclick="delete_record('products',<?php echo $product->product_id; ?>,'<?= $this->security->get_csrf_hash() ?>');"><i class="fa fa-times"></i></span>
																</td>
															</tr>
															<?php } } ?>
														</tbody>
														<tfoot class="product_total_calculations">
															<td colspan="10"><button class="btn add_product"><?php _trans('lable409'); ?></button></td>
														</tfoot>
													</table>
													<table>
														<tr id="new_product_row" style="display: none;">
															<input type="hidden" name="subpro_id" class="subpro_id">
															<input type="hidden" name="duplicate_subpro_id" class="duplicate_subpro_id">
															<td width="2%" style="max-width:2%;width:2%;" class="item_sno text-center"></td>
															<td width="20%" style="max-width:20%;width:20%;">
																<div style="width:100%;">
																	<input type="text" name="subProductName" class="subProductName form-control">
																</div>
																<div style="width:100%;padding-top:10px;">
																	<lable style="width: 40%;float: left;font-size: 12px;padding-top: 10px;"><?php _trans('lable218'); ?></lable>
																	<input style="width: 60%;float: left;" type="text" name="hsn_code" class="hsn_code form-control">
																</div>
															</td>
															<td width="14%" style="max-width:14%;width:14%;" class="text-left">
																<select name="brand_id" class="brand_id">
																	<option value="0"><?php  _trans('lable73'); ?></option>
																	<?php if(!empty($car_brand_list)){
																	foreach($car_brand_list as $brand_list){ ?>
																		<option value="<?php echo $brand_list->brand_id; ?>"><?php echo $brand_list->brand_name; ?></option>
																	<?php } } ?>
																</select>
															</td>
															<td width="14%" style="max-width:14%;width:14%;" class="text-left">
																<select name="model_id" class="model_id">
																	<option value="0"><?php  _trans('lable74'); ?></option>
																	<?php if(!empty($car_model_list)){
																		foreach ($car_model_list as $model_list){ ?>
																		<option value="<?php echo $model_list->model_id; ?>"><?php echo $model_list->model_name;?></option>
																	<?php }}?>
																</select>
															</td>
															<td width="14%" style="max-width:14%;width:14%;" class="text-left">
																<select name="variant_id" class="variant_id">
																	<option value="0"><?php  _trans('lable75'); ?></option>
																	<?php if ($car_variant_list){
																	foreach ($car_variant_list as $names){ ?>
																	<option value="<?php echo $names->brand_model_variant_id; ?>"><?php echo $names->variant_name; ?></option>
																	<?php } } ?>
																</select>
															</td>
															<td width="10%" style="max-width:10%;width:10%;" class="text-left">
																<select name="fuel_type" class="fuel_type">
																	<option value="P">Petrol</option>
																	<option value="D">Diesel</option>
																	<option value="G">CNG</option>
																</select>
															</td>
															<td width="6%" style="max-width:6%;width:6%;" class="text-center">
																<input type="text" name="reorder_qty" class="reorder_qty form-control text-center">
															</td>
															<td width="10%" style="max-width:10%;width:10%;">
																<input type="text" name="cost_pr" class="cost_pr twodigit form-control text-right">
															</td>
															<td width="10%" style="max-width:10%;width:10%;">
																<input type="text" name="sale_pr" class="sale_pr twodigit form-control text-right">
															</td>
															<td width="2%" style="max-width:2%;width:2%;" class="text-center">
																<span class="remove_added_item"><i class="fa fa-times"></i></span>
															</td>
														</tr>
													</table>
												</div>
											</div>
										</section>
									</div>
								</div> 	
								<div class="row">
									<div class="col-xs-6 col-md-6 padding0px">
										<h6 class="sideheadings"><?php _trans('lable6'); ?></h6>
										<div class="col-xs-6 col-md-6">
											<div class="form_group">
												<label class="form_label"> <?php _trans('lable175'); ?></label>
												<div class="form_controls">
													<input type="text" name="mon_from" id="mon_from" onkeypress="return isNumberKey(event)" class="form-control" value="<?php echo $this->mdl_products->form_value('mon_from', true); ?>">
												</div>
											</div>
										</div>
										<div class="col-xs-6 col-md-6">
											<div class="form_group">
												<label class="form_label"> <?php _trans('lable176'); ?></label>
												<div class="form_controls">
													<input type="text" name="mon_to" id="mon_to" onkeypress="return isNumberKey(event)" class="form-control" value="<?php echo $this->mdl_products->form_value('mon_to', true); ?>">
												</div>
											</div>
										</div>
									</div>
									<div class="col-xs-6 col-md-6 padding0px">
										<h6 class="sideheadings"><?php _trans('lable233'); ?></h6>
										<div class="col-xs-6 col-md-6">
											<div class="form_group">
												<label class="form_label"> <?php _trans('lable175'); ?></label>
												<div class="form_controls">
													<input type="text" name="kilo_from" id="kilo_from" onkeypress="return isNumberKey(event)" class="form-control" value="<?php echo $this->mdl_products->form_value('kilo_from', true); ?>">
												</div>
											</div>
										</div>
										<div class="col-xs-6 col-md-6">
											<div class="form_group">
												<label class="form_label"> <?php _trans('lable176'); ?></label>
												<div class="form_controls">
													<input type="text" name="kilo_to" id="kilo_to" onkeypress="return isNumberKey(event)" class="form-control" value="<?php echo $this->mdl_products->form_value('kilo_to', true); ?>">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-md-12">
										<div class="form_group">
											<label class="form_label"><?php _trans('lable177'); ?></label>
											<div class="form_controls">
												<textarea name="description" id="description" class="form-control"><?php echo $this->mdl_products->form_value('description', true); ?></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-3 col-md-3 col-sm-3 col-lg-3 col-xl-3">
										<div class="row">
											<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 col-xl-12 font_weight_bold">
												Upload Picture
											</div>
											<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 col-xl-12">
												<form class="col-lg-12 col-md-12 col-sm-12 paddingTop20px upload" id="upload_csv" method="post" enctype="multipart/form-data">  
													<input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
													<input type="file" id="file" onchange="getfile()" class="inputTypeFile inputfile" name="file" style="display:none;"/>
													<input type="hidden" id="fileName" name="fileName" value="" />
													<div class="btn" id="uploadButton">Choose File</div>
													<input type="submit" class="upload_btn" id="upload_btn" style="display:none;">
												</form>
											</div>
											<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 col-xl-12 text-center">
												<span id="showErrorMessage" class="error"></span>
											</div>
											<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 col-xl-12">
												<ul id="productImagesBox" class="productImagesBox">
													<?php foreach ($uploadedImages as $documentList){ ?>
													<li style="float:left;">
														<span class="spanOne">
															<a href="<?php echo base_url()."uploads/customer_files/".$documentList->file_name_new?>" target="_blank" >
																<img src="<?php echo base_url()."uploads/customer_files/".$documentList->file_name_new?>" width="100%" height="100%">
															</a>
														</span>
														<span class="spanTwo" onclick="getDeleteUploadFIle('<?php echo $documentList->upload_id; ?>','D','<?php echo $documentList->file_name_original; ?>')">
															<i class="fa fa-trash-o" aria-hidden="true"></i>
														</span>
													</li>
													<?php } ?>
												</ul>
											</div>
										</div>							
									</div>
								</div>
								<div class="buttons text-center paddingTop40px">
									<button name="btn_submit" class="btn_submit btn btn-rounded btn-primary" value="2">
										<i class="fa fa-check"></i>  <?php _trans('lable57'); ?>
									</button>
									<button name="btn_submit" class="btn_submit btn btn-rounded btn-primary" value="1">
										<i class="fa fa-check"></i>  <?php _trans('lable234'); ?>
									</button>
									<button id="btn-cancel" name="btn_cancel" class="btn btn-rounded btn-default" value="1">
										<i class="fa fa-times"></i>  <?php _trans('lable58'); ?>
									</button>
								</div>
							</div>
						</div>
					</div>
    			</div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

	function getModelList(row_id){
		$.post("<?php echo site_url('user_cars/ajax/get_brand_models'); ?>", {
			brand_id: $('#brand_id_'+row_id).val(),
			_mm_csrf: $('#_mm_csrf').val()
		},function (data) {
			var response = JSON.parse(data);
			$('#variant_id_'+row_id).empty();
			$('#variant_id_'+row_id).append($('<option></option>').attr('value', '').text('Select Variant'));
			$("#variant_id_"+row_id).select2().on("change", function (e) {});
			if(response.length > 0) {
				$('#model_id_'+row_id).empty(); // clear the current elements in select box
				$('#model_id_'+row_id).append($('<option></option>').attr('value', '').text('Select Model'));
		       	for (row in response) {
		       		$('#model_id_'+row_id).append($('<option></option>').attr('value', response[row].model_id).text(response[row].model_name));
				}
				$("#model_id_" + row_id).select2().on("change", function (e) {});
         	}else{
				$('#model_id_'+row_id).empty(); // clear the current elements in select box
				$('#model_id_'+row_id).append($('<option></option>').attr('value', '').text('Select Model'));
				$("#model_id_" + row_id).select2().on("change", function (e) {});
           	}
		});
	}

	function getvariantList(row_id){
		$.post("<?php echo site_url('user_cars/ajax/get_brand_model_variant'); ?>", {
			brand_id: $('#brand_id_'+row_id).val(),
			model_id: $('#model_id_'+row_id).val(),
			_mm_csrf: $('#_mm_csrf').val()
		},function (data) {
        	var response = JSON.parse(data);
           	if (response.length > 0) {
          		$('#variant_id_'+row_id).empty(); // clear the current elements in select box
            	$('#variant_id_'+row_id).append($('<option></option>').attr('value', '').text('Select Variant'));
	        	for (row in response) {
	           		$('#variant_id_'+row_id).append($('<option></option>').attr('value', response[row].brand_model_variant_id).text(response[row].variant_name));
				}
				$("#variant_id_" + row_id).select2().on("change", function (e) {});
         	}else {
				$('#variant_id_'+row_id).empty(); // clear the current elements in select box
            	$('#variant_id_'+row_id).append($('<option></option>').attr('value', '').text('Select variant'));
				$("#variant_id_" + row_id).select2().on("change", function (e) {});
            }
		});
	}

	function product_name(id){
		var subProductName = $("#subProductName_"+parseInt(id)).val();
		var product_name = $("#product_name").val();
		if(subProductName.length > 0){
			var res = subProductName.split("-");
			$("#subProductName_"+id).val(product_name+" - "+(res[1]?res[1].trim():""));
		}else{
			$("#subProductName_"+id).val(product_name+" - ");
		}
	}

	function remove_product(id){
		$("#product_item_table #tr_"+id).remove();
		var renumpro = 1;
		$("#product_item_table tr .item_sno").each(function() {
			$(this).text(renumpro);
			renumpro++;
		});
	}

	function product_row_data(){

		var add_mathround = parseInt(new Date().getTime() + Math.random());

		var next_row_id = $("#product_item_table > tbody > tr").length;

		$('#new_product_row').clone().appendTo('#product_item_table').removeAttr('id').addClass('item').attr('id', 'tr_' + add_mathround).show();

		$('#tr_' + add_mathround + ' .item_sno').attr('id', "item_sno_" + add_mathround);

		$('#tr_' + add_mathround + ' .item_sno').empty().html(next_row_id);

		$('#tr_' + add_mathround + ' .subpro_id').attr('id', "subpro_id_" + add_mathround);

		$('#tr_' + add_mathround + ' .duplicate_subpro_id').attr('id', "duplicate_subpro_id_" + add_mathround);

		$('#tr_' + add_mathround + ' .subProductName').attr('id', "subProductName_" + add_mathround);

		$('#tr_' + add_mathround + ' .hsn_code').attr('id', "hsn_code_" + add_mathround);

		$('#tr_' + add_mathround + ' .brand_id').attr('id', "brand_id_" + add_mathround);

		$('#tr_' + add_mathround + ' .model_id').attr('id', "model_id_" + add_mathround);

		$('#tr_' + add_mathround + ' .variant_id').attr('id', "variant_id_" + add_mathround);

		$('#tr_' + add_mathround + ' .fuel_type').attr('id', "fuel_type_" + add_mathround);

		$('#tr_' + add_mathround + ' .reorder_qty').attr('id', "reorder_qty_" + add_mathround);

		$('#tr_' + add_mathround + ' .cost_pr').attr('id', "cost_pr_" + add_mathround);

		$('#tr_' + add_mathround + ' .sale_pr').attr('id', "sale_pr_" + add_mathround);

		$('#tr_' + add_mathround + ' .remove_added_item').attr('id' , "remove_added_item_" + add_mathround);

		$('#tr_' + add_mathround + ' .subproductName').attr('onkeyup', 'product_name("' + add_mathround + '")');

		$('#tr_' + add_mathround + ' .subproductName').val($("#product_name").val()+" -");

		$("#duplicate_subpro_id_"+add_mathround).val(add_mathround);
		
		$().ready(function () {

			$("#brand_id_" + add_mathround).select2().on("change", function (e) {
				getModelList(add_mathround);
			});

			$("#model_id_" + add_mathround).select2().on("change", function (e) {
				getvariantList(add_mathround);
			});

			$("#variant_id_" + add_mathround).select2().on("change", function (e) {
			});

			$("#fuel_type_" + add_mathround).select2().on("change", function (e) {
			});

			$("#remove_added_item_" + add_mathround).attr('onclick', 'remove_product("' + add_mathround + '")');
			
		});

		var renumpro = 1;
		$("#product_item_table tr .item_sno").each(function() {
			$(this).text(renumpro);
			renumpro++;
		});

	}

$(document).ready(function(){

	$(".select2").select2();

	$("#btn-cancel").click(function(){
		window.location = "<?php echo site_url('products'); ?>/";
	});

	$(".add_product").click(function () {
		var product_name = $("#product_name").val();
		if(product_name == ""){
			$('#product_name').addClass("border_error");
			$('#product_name').parent().addClass('has-error');
			return false;
		}
		var empty = '';
		product_row_data(empty);
	});

	$("#uploadButton").click(function(){
		$("#file").click();
	});

	$('#file').on("change", function(e)
	{
		$(".upload").submit();
	});

	$(document).on("submit",".upload",function(e) {

		$("#showErrorMessage").html('');
		e.preventDefault();
		e.stopPropagation();

		$.ajax({
			url : "<?php echo site_url('upload/upload/upload_file/'.($this->mdl_products->form_value("product_id", true)?$this->mdl_products->form_value("product_id", true):0).'/pro/'.($product_url_key)); ?>",
			method:"POST",
			data : new FormData(this),
			contentType:false,
			cache:false,
			processData:false,
			success: function(data){
				var response = JSON.parse(data);
				if(response.success =='1' || response.success == 1){
					getproductUploadFiles(response.url_key);
				}else{
					if(response.message){
						$("#showErrorMessage").html(response.message);
					}
				}
			}
		});
	});

	$("#tax_percentage").keyup(function(){
		var tax_percentage = $("#tax_percentage").val();
		if(parseInt(tax_percentage) > 100 || parseInt(tax_percentage) < 0){
			$("#tax_percentage").val(0);
		}
	});
	
    $("#apply_for_all_bmv").click(function(){
    	if($("#apply_for_all_bmv:checked").is(":checked")){
			$("#apply_for_all_bmv").val('Y');
			$("#parent_id").val(0);
			$(".modelandvariants").hide();
			$(".bodyType").show();
		}else{
			$("#apply_for_all_bmv").val('N');
			$("#parent_id").val(1);
			$(".modelandvariants").show();
			$(".bodyType").hide();
		}
	});

    $(".btn_submit").click(function () {
		
		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');

		var validation = [];

		if($("#product_name").val() == ''){
			validation.push('product_name');
		}

		if($("#product_category_id").val() == ''){
			validation.push('product_category_id');
		}

		var productCostPriceList = [];
		$('table#product_item_table tbody>tr.item').each(function() {
			var product_row = {};
			$(this).find('input,select,textarea').each(function() {
				if ($(this).is(':checkbox')) {
					product_row[$(this).attr('name')] = $(this).is(':checked');
				} else {
					product_row[$(this).attr('name')] = $(this).val();
				}
			});
			if(product_row){
				productCostPriceList.push(product_row);
			}
		});

		if(productCostPriceList.length > 0){
			productCostPriceList.forEach(function(val) {
				if(val.subproductName == ''){
					validation.push('subproductName_'+val.duplicate_subpro_id);
				}
				if(val.brand_id == ''){
					validation.push('brand_id_'+val.duplicate_subpro_id);
				}
				if(val.model_id == ''){
					validation.push('model_id_'+val.duplicate_subpro_id);
				}
				if(val.cost_pr == ''){
					validation.push('cost_pr_'+val.duplicate_subpro_id);
				}
				if(val.sale_pr == ''){
					validation.push('sale_pr_'+val.duplicate_subpro_id);
				}
			});
		}

		if(validation.length > 0){			
			validation.forEach(function(val) {				
				$('#'+val).addClass("border_error");
				$('#'+val).parent().addClass('has-error');
			});
			return false;
		}

		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');
		$('#gif').show();


		$.post('<?php echo site_url('products/ajax/create'); ?>', {
			product_id : $("#product_id").val(),
			parent_id : $("#parent_id").val(),
			url_key: $("#url_key").val(),
			product_name : $('#product_name').val(),
			product_category_id : $('#product_category_id').val(),
            hsn_code : $('#hsn_item_code').val()?$('#hsn_item_code').val():"",
            unit_type : $('#unit_type').val(),
			rack_no : $('#rack_no').val(),
			tax_percentage : $('#tax_percentage').val(),
			apply_for_all_bmv : $("#apply_for_all_bmv").val()?$("#apply_for_all_bmv").val():"",
			reorder_quantity : $("#reorder_quantity").val()?$("#reorder_quantity").val():"",
			cost_price : $("#cost_price").val()?$("#cost_price").val():"",
			sale_price : $("#sale_price").val()?$("#sale_price").val():"",
			productCostPriceList : JSON.stringify(productCostPriceList),
			kilo_from : $('#kilo_from').val(),
			kilo_to : $('#kilo_to').val(),
            mon_from : $('#mon_from').val(),
            mon_to : $('#mon_to').val(),
            description : $("#description").val(),
			action_from : 'P',
			btn_submit : $(this).val(),
			_mm_csrf : $('#_mm_csrf').val()
        }, function (data) {
			list = JSON.parse(data);
            if(list.success=='1'){
                notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
				if(list.btn_submit == '1'){
					setTimeout(function(){
						window.location = "<?php echo site_url('products/form'); ?>";
					}, 100);
				}else{
					setTimeout(function(){
						window.location = "<?php echo site_url('products'); ?>/";
					}, 100);
				}
            }else{
				$('#gif').hide();
				notie.alert(3, '<?php _trans('toaster2'); ?>', 2);
				$('.has-error').removeClass('has-error');
                for (var key in list.validation_errors) {
					$('#'+key).addClass("border_error");
					$('#'+key).parent().addClass('has-error');
                }
            }
        });
	});											
});

</script>