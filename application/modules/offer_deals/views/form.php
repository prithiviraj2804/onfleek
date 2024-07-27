<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/lib/summernote/summernote.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/separate/pages/editor.min.css">

<style>
.inputfile {
  /* visibility: hidden etc. wont work */
  width: 0.1px;
  height: 0.1px;
  opacity: 0;
  overflow: hidden;
  position: absolute;
  z-index: -1;
}
.inputfile:focus + label {
  /* keyboard navigation */
  outline: 1px dotted #000;
  outline: -webkit-focus-ring-color auto 5px;
}
.inputfile + label * {
  pointer-events: none;
}
</style>
<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php echo _trans($breadcrumb); ?></h3>
				</div>
				<div class="tbl-cell pull-right">
					<a class="btn btn-sm btn-primary" href="<?php echo site_url('offer_deals/form'); ?>">
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
        <div class="col-xs-12 col-md-12 col-md-offset-3">
			<div class="container-wide usermanagement overflow_inherit">
                <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
				<section class="tabs-section" >
					<div class="tab-content">
						<form class="upload" upload-id="upload_csv_add" id="upload_csv_add" method="post" enctype="multipart/form-data" autocomplete="off">
							<input type="hidden" name="offer_id" id="offer_id" class="form-control" value="<?php echo $offer_details->offer_id ;?>">
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('label962'); ?> *</label>
									</div>
									<div class="col-sm-9">
										<input class="form-control" type="text" name="offer_title" id="offer_title" value="<?php echo $offer_details->offer_title; ?>" autocomplete="off">
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
									<label class="control-label string required" style="margin-right: 3px"> <?php _trans('lable239'); ?> *</label>
									</div>
									<div class="col-sm-9">
									<?php $this->layout->load_view('offer_deals/partial_service_category'); ?>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
									<label class="control-label string required" style="margin-right: 3px"> <?php _trans('lable546'); ?> *</label>
									</div>
									<div class="col-sm-9">
									<?php $this->layout->load_view('offer_deals/partial_service_package'); ?>
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('lable248'); ?></label>
									</div>
									<div class="col-sm-9">
										<div class="summernote-theme-1">
										<textarea name="short_desc" id="short_desc" class="form-control summernote"><?php echo $offer_details->short_desc; ?></textarea>								
									</div>
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('label963'); ?></label>
									</div>
									<div class="col-sm-9">
									<div class="summernote-theme-1">
										<textarea name="long_desc" id="long_desc" class="form-control summernote" ><?php echo $offer_details->long_desc; ?></textarea>								
									</div>
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('label964'); ?></label>
									</div>
									<div class="col-sm-9">
									<div class="summernote-theme-1">
										<textarea name="term_cond" id="term_cond" class="form-control summernote"><?php echo $offer_details->term_cond; ?></textarea>								
									</div>
									</div>
								</div>

								<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label style="padding-top: 0px ! important;"><?php _trans('label944'); ?>*</label>
								</div>
								<div class="col-sm-9 paddingLeftRight5px" style="padding: 0%;">
								<div class="multi-fields">
										<?php if(count($offer_feature_list) > 0){  ?>
										<?php foreach ($offer_feature_list as $value){?>
										<div class="multi-field col-lg-12 col-lg-12 col-sm-12 col-xs-12">
											<input type="hidden" name="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>" autocomplete="off">
											<input type="hidden" name="feature_id[]" class="feature_id" value="<?php echo $value->feature_id;?>" autocomplete="off">
											<input type="hidden" name="duplicate_feature_id[]" class="duplicate_feature_id" value="<?php echo $value->feature_id;?>" autocomplete="off">
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right" style="padding: 0px 0px 10px 0px;">
												<input  type="text" name="column_name[]" class="column_name removeError form-control" value="<?php echo $value->name; ?>" autocomplete="off">
											</div>
											<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 paddingTop5px">
												<button type="button" class="remove_field"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
											</div>
										</div>
										<?php } }?>
										
									</div>
									<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12">
										<button type="button" class="add-field"><i class="fa fa-plus-circle" aria-hidden="true"></i> <?php _trans('label970'); ?></button>
										<div id="showfeature" class="errorColor" style="font-size: 14px;display:none;color: red" ></div>
									</div>
								</div>
							</div>
								
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required" style="margin-right: 3px"><?php _trans('label965'); ?> *</label>
									</div>
									<div class="col-sm-9">
										<input class="" type="checkbox" name="mobile_enable" id="mobile_enable" style="margin-top: 10px" autocomplete="off" <?php if($offer_details->mobile_enable == 'Y'){ echo "checked"; }?> value="<?php if($offer_details->mobile_enable == 'Y'){ echo "Y"; } else{ echo 'N'; }?>">
									</div>
									<div id="tag_place" style="font-size: 14px;padding: 0% 40%;display:none;" class="alertColor"><?php _trans('err6'); ?></div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required" style="margin-right: 3px"><?php _trans('lable361'); ?> *</label>
									</div>
									<div class="col-sm-9">
										<input class="form-control datepicker" type="text" name="start_date" id="start_date" value="<?php echo $offer_details->start_date?date_from_mysql($offer_details->start_date):date_from_mysql(date('Y-m-d')); ?>" autocomplete="off">
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required" style="margin-right: 3px"><?php _trans('lable630'); ?> *</label>
									</div>
									<div class="col-sm-9">
										<input class="form-control datepicker" type="text" name="end_date" id="end_date" value="<?php echo $offer_details->end_date?date_from_mysql($offer_details->end_date):date_from_mysql(date('Y-m-d')); ?>" autocomplete="off">
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required" style="margin-right: 3px"><?php _trans('label966'); ?></label>
									</div>
									<div class="col-sm-9">									
										<input type="hidden" name="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>" autocomplete="off">
										<div class="form-group clearfix">											
											<div class="col-sm-2 paddingTop7px">
											<span class="text-center">
												<input type="file" name="iconfile[]" id="fileOne" onchange="getfile('fileOneLable')" class="inputfile">
												<input type="hidden" id="filehideone" name="filehideone" value="<?php echo $offer_details->offer_banner_image; ?>" autocomplete="off"/>
												<label for="fileOne" class="btn_upload_icon btn btn-rounded btn-primary btn-padding-left-right-40"><?php _trans('lable594'); ?></label>
											</span>
											</div>
											<div class="col-sm-4 paddingTop7px ">
												<?php $iconimage = $offer_details->offer_banner_image; ?>
												<?php $iconfileName = preg_split ('/[_,]+/', $iconimage); ?>
												<?php $iconname = $iconfileName[count($iconfileName)-1] ?>	
												<div style="padding: 5px 60px;" id="fileOneLable">
													<span style="cursor: pointer">
														<a href="<?php echo base_url().$iconimage?>" target="_blank" ><?php echo $iconname; ?></a>
													</span>
												</div>						
											</div>
										</div>
										<div id="showErrorone" class="errorColor" style="font-size: 14px;padding: 0% 28%;display:none;color: red" ><?php _trans('lable181'); ?></div>
										<div id="showError" class="errorColor" style="font-size: 14px;padding: 0% 2%;display:none;color: red" ><?php _trans('lable181'); ?></div>
								</div>									
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required" style="margin-right: 3px"> <?php _trans('label967'); ?> *</label>
									</div>
									<div class="col-sm-9">
										<select name="offer_type" id="offer_type" class="bootstrap-select bootstrap-select-arrow g-input removeError">
											<option value=""><?php _trans("label968"); ?></option>
											<option value="A" <?php if ($offer_details->offer_type == 'A') {echo "selected";} ?>>Percentage</option>
											<option value="B" <?php if ($offer_details->offer_type == 'B') {echo "selected";} ?>>Rupee</option>
										</select>
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required" style="margin-right: 3px"><?php _trans('lable337'); ?> *</label>
									</div>
									<div class="col-sm-9">
										<input class="form-control" type="number" name="offer_rate" id="offer_rate" value="<?php echo $offer_details->offer_rate; ?>" autocomplete="off">
									</div>
								</div>			
								<div class="buttons text-center">
									<button type="submit" class="btn btn-rounded btn-primary btn-padding-left-right-40">
										<i class="fa fa-check"></i> <?php _trans('lable57'); ?>
									</button>
									<button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default">
										<i class="fa fa-times"></i> <?php _trans('lable58'); ?>
									</button>
								</div>
						</form>			
								<!-- clone section don't delete -->
								<div id="new_custom_row" class="col-sm-12" style="display: none;">				
									<input type="hidden" name="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>" autocomplete="off">
									<input type="hidden" name="feature_id[]" class="feature_id" autocomplete="off">
									<input type="hidden" name="duplicate_feature_id[]" class="duplicate_feature_id" autocomplete="off">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right" style="padding: 0px 0px 10px 0px;">
										<input type="text" name="column_name[]" class="column_name form-control" value="" autocomplete="off">
									</div>
									<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 paddingTop5px">
										<button type="button" class="remove-field"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
									</div>
								</div>		
								<!-- clone section don't delete -->
		
					</div>
				</section>
			</div>	
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>assets/mp_backend/js/lib/summernote/summernote.min.js"></script>
<script type="text/javascript">


	$("#offer_rate").on("keypress keyup blur",function (event) {    
           $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
	});

	$(".add-field").click(function(){

		$('#showfeature').hide();
		var add_mathround = parseInt(new Date().getTime() + Math.random());

		$('#new_custom_row').clone().appendTo('.multi-fields').removeAttr('id').addClass('multi-field').attr('id', 'tr_' + add_mathround).show();

		$('#tr_' + add_mathround + ' .feature_id').attr('id', "feature_id_" + add_mathround);

		$('#tr_' + add_mathround + ' .duplicate_feature_id').attr('id', "duplicate_feature_id_" + add_mathround);

		$('#tr_' + add_mathround + ' .column_name').attr('id', "column_name_" + add_mathround);

		$("#duplicate_feature_id_" + add_mathround).val(add_mathround);

		});

		$(document).on("click",".remove-field",function(){
		$(this).parent().parent().remove();
		});	

		$(document).on("click",".remove_field",function() {

		var feature_id = $(this).parent().parent().find('.feature_id').val();
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
				$.post('<?php echo site_url('offer_deals/ajax/deletefeatureData'); ?>', {
					feature_id : feature_id,
					_mm_csrf: $('input[name="_mm_csrf"]').val()
				}, function (data) {
					list = JSON.parse(data);
					if(list.success=='1'){
						swal({
							title: "The row is deleted successfully",
							text: "Your imaginary file has been deleted.",
							type: "success",
							confirmButtonClass: "btn-success"
						},function() {
							notie.alert(1, 'Successfully deleted', 2);
							window.location = "<?php echo site_url('offer_deals/form'); ?>/"+"<?php echo $offer_details->offer_id; ?>";
						});
					}else{
						notie.alert(3, '<?php _trans('toaster2');?>', 2);
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

	function getfile(name)
		{
		if(name == 'fileOneLable'){
			var filename = $('input[name="iconfile[]"]').val().split("\\");
			$("#filehideone").val(filename[2]);
			$('#showErrorone').empty().append('');
			$('#showErrorone').hide();
			var fileNameone;
			var fileExtensionone;

			fileNameone = filename[2];
			fileExtensionone = fileNameone.replace(/^.*\./, '');

			if(fileExtensionone != 'jpeg' && fileExtensionone != 'JPEG' && 
			      fileExtensionone != 'png' && fileExtensionone != 'PNG' &&
               	  fileExtensionone != 'jpg' && fileExtensionone != 'JPG' &&
                  fileExtensionone != 'gif' && fileExtensionone != 'GIF' &&
                  fileExtensionone != 'tiff' && fileExtensionone != 'TIFF' &&
                  fileExtensionone != 'pdf' && fileExtensionone != 'PDF' &&
                  fileExtensionone != 'bmp' && fileExtensionone != 'BMP' &&
                  fileExtensionone != 'tif' && fileExtensionone != 'TIF' && fileExtensionone != ''){
					$('#showErrorone').empty().append('Invalid File Format');
					$('#showError').hide();
					$('#showErrorone').show();
				  }else{
					$('#showErrorone').empty().append('');
					$('#showErrorone').hide();
				  }
		}

        $("#"+name).empty().append(filename[2]);

    	$("#showError").hide();
	}

	$("#mobile_enable").click(function(){
        if($("#mobile_enable:checked").is(":checked")){
			$("#mobile_enable").val('Y');
			$("#tag_place").hide();
        }else{
			$("#mobile_enable").val('N');
			$("#tag_place").show();
        }
    });

$('#service_category_id').change(function () {

// if($("#customer_car_id").val() == ''){
// 	notie.alert(3, '<//?php // _trans('toaster5'); ?>', 2);
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
        window.location.href = "<?php echo site_url('offer_deals'); ?>";
    });

$(document).ready(function() {
	$('.summernote').summernote(); 

    $(document).on('submit', ".upload", function (e) {

		$('#showErrorone').empty().append('');
		$('#showErrorone').hide();
		$('#showError').empty().append('');
		$('#showError').hide();
		$('#showfeature').empty().append('');
		$('#showfeature').hide();

		var attr_name = $(this).attr("upload-id");
		var forImg = this;
		
		var fileNameone;
		var fileExtensionone;
		fileNameone = $("#fileOne").val();
		fileExtensionone = fileNameone.replace(/^.*\./, '');
	
		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');

		var validation = [];
		var featureArray = [];
		
		if($("#offer_title").val() == ''){
			validation.push('offer_title');
		}

		if(fileExtensionone != 'jpeg' && fileExtensionone != 'JPEG' && 
			fileExtensionone != 'png' && fileExtensionone != 'PNG' &&
			fileExtensionone != 'jpg' && fileExtensionone != 'JPG' &&
			fileExtensionone != 'gif' && fileExtensionone != 'GIF' &&
			fileExtensionone != 'tiff' && fileExtensionone != 'TIFF' &&
			fileExtensionone != 'pdf' && fileExtensionone != 'PDF' &&
			fileExtensionone != 'bmp' && fileExtensionone != 'BMP' &&
			fileExtensionone != 'tif' && fileExtensionone != 'TIF' && fileExtensionone != ''){
			$('#showErrorone').empty().append('Invalid File Format');
			$('#showErrorone').show();
			return false;
			}else{
			$('#showErrorone').empty().append('');
			$('#showErrorone').hide();
			}

		if($("#service_category_id").val() == ''){
			validation.push('service_category_id');
		}
		if($("#service_package_id").val() == ''){
			validation.push('service_package_id');
		}

		$(".multi-fields .multi-field").each(function(){
		var requestObj = {};
		requestObj.duplicate_feature_id = $(this).find(".duplicate_feature_id").val();
		requestObj.feature_id = $(this).find(".feature_id").val();
		requestObj.column_name = $(this).find(".column_name").val();
		featureArray.push(requestObj);
		});

		if($("#mobile_enable").val() == ''){
			validation.push('mobile_enable');
		}
		if($("#start_date").val() == ''){
			validation.push('start_date');
		}
		if($("#end_date").val() == ''){
			validation.push('end_date');
		}	
		if($("#offer_type").val() == ''){
			validation.push('offer_type');
		}
		if($("#offer_rate").val() == ''){
			validation.push('offer_rate');
		}

		if(featureArray.length > 0){
			featureArray.forEach(function(val){
				if(val.column_name == ''){
					validation.push('column_name_'+val.duplicate_feature_id);
				}
			});
			$('#showfeature').empty().append('');
			$('#showfeature').hide();
		}else{
				$('#showfeature').empty().append('Please Add Features');
				$('#showfeature').show();
				return false;
		}
		
		if(validation.length > 0){
			validation.forEach(function(val) {
				$('#'+val).parent().addClass("has-error");
				$('#' +val).parent().removeClass('border_error');

				$('#'+val).addClass("border_error");
				$('#'+val).parent().addClass('has-error');
			});
			return false;
		}
		
		if($("#mobile_enable").val() == 'N'){
				$("#tag_place").show();
				return false;
			}else{
				$("#tag_place").hide();
		}

		if($("#filehideone").val() == ''){
			$('#showError').empty().append('Please upload Offer Image');
			$('#showError').show();
			return false;
		}else{
			$('#showError').empty().append('');
			$('#showError').hide();
		}	
		
		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');
		
		$('#gif').show();

		e.preventDefault();
			e.stopPropagation();

		$.ajax({
			url : "<?php echo site_url('offer_deals/ajax/create'); ?>",
			method:"POST",
			data : new FormData(this),
			data1 : JSON.stringify(featureArray),
			contentType:false,
			cache:false,
			processData:false,
			success: function(data){
				var response = JSON.parse(data);
				if(response.success=='1'){
					notie.alert(1, '<?php _trans('toaster1'); ?>', 2);					
						setTimeout(function(){
							window.location = "<?php echo site_url('offer_deals/index'); ?>/"+response.offer_id+"/2";
						}, 100);
					}else{
						$('#gif').hide();
							notie.alert(3, '<?php _trans('toaster2'); ?>', 2);
							$('.has-error').removeClass('has-error');
							for (var key in response.validation_errors) {
								$('#' + key).parent().addClass('has-error');
								$('.error_msg_' + key).show().empty().html(response.validation_errors[key]);
							}
					}				
			}
		});
	});
});
</script>

				