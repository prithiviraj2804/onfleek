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
					<a class="btn btn-sm btn-primary" href="<?php echo site_url('mechanic_service_category/form'); ?>">
                        <i class="fa fa-plus"></i> <?php _trans('lable40'); ?>
                    </a>
				</div>
			</div>
		</div>
	</div>
</header>
<form class="upload" upload-id="upload_csv_add" id="upload_csv_add" method="post" enctype="multipart/form-data" autocomplete="off">
<div id="content">
	<div class="row">
		<div id="gif" class="gifload">
			<div class="gifcenter">
			  <center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
		    </div>
		</div>
		<div class="col-xs-12 top-15">
			<a class="anchor anchor-back" onclick="goBack()" href="<?php echo site_url('mechanic_service_category/index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
		</div>
		<div class="col-xs-12 col-md-12 col-md-offset-3">
			<div class="container-wide">
                <input name="is_update" id="is_update" type="hidden" <?php if($this->mdl_mechanic_service_category_list->form_value('is_update')){echo 'value="1"';} else {echo 'value="0"';} ?>>
				<input type="hidden" name="service_cat_id" id="service_cat_id" class="form-control" value="<?php echo $servicecategory_details->service_cat_id; ?>" autocomplete="off">

				<div class="box">
					<div class="box_body">
						<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable244'); ?> *</label>
								</div>
								<div class="col-sm-9">
								<input type="text" name="category_name" id="category_name" class="form-control" value="<?php echo $servicecategory_details->category_name; ?>">
								</div>
						</div>

						<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable248'); ?></label>
								</div>
								<div class="col-sm-9">
									<div class="summernote-theme-1">
									<textarea name="service_short_description" id="service_short_description" class="summernote" name="name"><?php echo $servicecategory_details->service_short_description; ?></textarea>
									</div>
                                </div>
                        </div>
						<div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required"><?php _trans('lable177'); ?></label>
								</div>
								<div class="col-sm-9">
									<div class="summernote-theme-1">
									<textarea name="service_description" id="service_description" class="summernote" name="name"><?php echo $servicecategory_details->service_description; ?></textarea>
									</div>
                                </div>
                        </div>

						<div id="upload_section">
								<input type="hidden" name="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>" autocomplete="off">
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('label950'); ?></label>
									</div>
									<div class="col-sm-2">
										<span class="text-center">
											<input type="file" name="iconfile[]" id="fileOne" onchange="getfile('fileOneLable')" class="inputfile">
											<label for="fileOne" class="btn_upload_icon btn btn-rounded btn-primary btn-padding-left-right-40"><?php _trans('lable594'); ?></label>
										</span>
									</div>
									<div class="col-sm-4 paddingTop7px">
										<?php $iconimage = $servicecategory_details->service_icon_image; ?>
										<?php $iconfileName = preg_split ('/[_,]+/', $iconimage); ?>
										<?php $iconname = $iconfileName[count($iconfileName)-1] ?>
							
										<div style="padding: 0px 30px;" id="fileOneLable">
										<span style="cursor: pointer">
											<a href="<?php echo base_url().$iconimage?>" target="_blank" ><?php echo $iconname; ?></a>
										</span>
										</div>
										<div id="showErrorone" class="errorColor" style="font-size: 14px;padding: 0% 15%;display:none;color: red" ><?php _trans('lable181'); ?></div>
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('label951'); ?></label>
									</div>
									<div class="col-sm-2">
										<span class="text-center">
											<input type="file" name="bannerfile[]" id="fileTwo" onchange="getfile('fileTwoLable')" class="inputfile">
											<label for="fileTwo" class="btn_upload_icon btn btn-rounded btn-primary btn-padding-left-right-40"><?php _trans('lable594'); ?></label>
										</span>
									</div>
									<div class="col-sm-4 paddingTop7px">
										<?php $bannerimage = $servicecategory_details->service_image; ?>
										<?php $bannerfileName = preg_split ('/[_,]+/', $bannerimage); ?>
										<?php $bannername = $bannerfileName[count($bannerfileName)-1] ?>
										<div style="padding: 0px 30px;" id="fileTwoLable">
										<span style="cursor: pointer">
										<a href="<?php echo base_url().$bannerimage?>" target="_blank" ><?php echo $bannername; ?></a>
										</span>
										</div>
										<div id="showErrortwo" class="errorColor" style="font-size: 14px;padding: 0% 15%;display:none;color: red" ><?php _trans('lable181'); ?></div>
									</div>
								</div>
						</div>

						<div class="form-group clearfix">
							<div class="col-sm-3 text-right">
								<label class="control-label string required"><?php _trans('label946'); ?> </label>
							</div>
							<div class="col-sm-9">
								<input class="form-control" style="width: 15px; height: 20px;" type="checkbox" name="enable_mobile" id="enable_mobile" autocomplete="off" <?php if($servicecategory_details->enable_mobile == 'Y'){ echo "checked"; }?> value="<?php if($servicecategory_details->enable_mobile == 'Y'){ echo "Y"; } else{ echo 'N'; }?>">
							</div>
                        </div>
						<div id="showError" class="errorColor" style="font-size: 14px;padding: 0% 40%;display:none;color: red" ><?php _trans('lable181'); ?></div>
						<div class="buttons text-center">
							<button value="1" type="submit" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
								<i class="fa fa-check"></i> <?php _trans('lable57'); ?>
							</button>
							<button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default">
								<i class="fa fa-times"></i> <?php _trans('lable58'); ?>
							</button>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>
</form>

<script src="<?php echo base_url(); ?>assets/mp_backend/js/lib/summernote/summernote.min.js"></script>
<script type="text/javascript">

	$("#btn_cancel").click(function () {
        window.location.href = "<?php echo site_url('mechanic_service_category'); ?>";
    });

	function getfile(name)
	{
		if(name == 'fileOneLable'){
			var filename = $('input[name="iconfile[]"]').val().split("\\");
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
					$('#showErrorone').show();
				  }else{
					$('#showErrorone').empty().append('');
					$('#showErrorone').hide();
				  }
		}else{
			var filename = $('input[name="bannerfile[]"]').val().split("\\");
			$('#showErrortwo').empty().append('');
			$('#showErrortwo').hide();
			var fileNametwo;
			var fileExtensiontwo;
			fileNametwo = filename[2];
			fileExtensiontwo = fileNametwo.replace(/^.*\./, '');

			if(fileExtensiontwo != 'jpeg' && fileExtensiontwo != 'JPEG' && 
			      fileExtensiontwo != 'png' && fileExtensiontwo != 'PNG' &&
               	  fileExtensiontwo != 'jpg' && fileExtensiontwo != 'JPG' &&
                  fileExtensiontwo != 'gif' && fileExtensiontwo != 'GIF' &&
                  fileExtensiontwo != 'tiff' && fileExtensiontwo != 'TIFF' &&
                  fileExtensiontwo != 'pdf' && fileExtensiontwo != 'PDF' &&
                  fileExtensiontwo != 'bmp' && fileExtensiontwo != 'BMP' &&
                  fileExtensiontwo != 'tif' && fileExtensiontwo != 'TIF' && fileExtensiontwo != ''){
					$('#showErrortwo').empty().append('Invalid File Format');
					$('#showErrortwo').show();
				  }else{
					$('#showErrortwo').empty().append('');
					$('#showErrortwo').hide();
				  }
		}

        $("#"+name).empty().append(filename[2]);

	}

    $("#enable_mobile").click(function(){
        if($("#enable_mobile:checked").is(":checked")){
            $("#enable_mobile").val('Y');
        }else{
            $("#enable_mobile").val('N');
        }
    });
	
	$("#category_type").click(function(){
		if($(this).is(":checked")){
			$("#category_parent_div").show();
		}else{
			$("#category_parent_div").hide();
		}
	});

	$(document).ready(function() {

		$('.summernote').summernote();

		$(document).on('submit', ".upload", function (e) {

			$('#showErrorone').empty().append('');
			$('#showErrorone').hide();
			$('#showErrortwo').empty().append('');
			$('#showErrortwo').hide();

			var attr_name = $(this).attr("upload-id");
			var forImg = this;

			var fileNameone;
			var fileExtensionone;
			fileNameone = $("#fileOne").val();
			fileExtensionone = fileNameone.replace(/^.*\./, '');

			var fileNametwo;
			var fileExtensiontwo;
			fileNametwo = $("#fileTwo").val();
			fileExtensiontwo = fileNametwo.replace(/^.*\./, '');

			e.preventDefault();
			e.stopPropagation();

			$('.border_error').removeClass('border_error');
			$('.has-error').removeClass('has-error');

			var validation = [];

			if($("#category_name").val() == ''){
				validation.push('category_name');
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

			if(fileExtensiontwo != 'jpeg' && fileExtensiontwo != 'JPEG' && 
			      fileExtensiontwo != 'png' && fileExtensiontwo != 'PNG' &&
               	  fileExtensiontwo != 'jpg' && fileExtensiontwo != 'JPG' &&
                  fileExtensiontwo != 'gif' && fileExtensiontwo != 'GIF' &&
                  fileExtensiontwo != 'tiff' && fileExtensiontwo != 'TIFF' &&
                  fileExtensiontwo != 'pdf' && fileExtensiontwo != 'PDF' &&
                  fileExtensiontwo != 'bmp' && fileExtensiontwo != 'BMP' &&
                  fileExtensiontwo != 'tif' && fileExtensiontwo != 'TIF' && fileExtensiontwo != ''){
					$('#showErrortwo').empty().append('Invalid File Format');
					$('#showErrortwo').show();
					return false;
				  }else{
					$('#showErrortwo').empty().append('');
					$('#showErrortwo').hide();
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

		
			$.ajax({
				url : '<?php echo site_url('mechanic_service_category/ajax/create'); ?>',
				method:"POST",
				data : new FormData(this),
				contentType:false,
				cache:false,
				processData:false,
				success: function(data){
				var response = JSON.parse(data);
				if(response.success=='1'){
					notie.alert(1, '<?php _trans('toaster1');?>', 2);
					setTimeout(function(){ 
                    window.location = "<?php echo site_url('mechanic_service_category'); ?>";
                }, 1000);
				}else if (response.success == '2') {
				$('#gif').hide();
				notie.alert(3, '<?php _trans('err7'); ?>', 2);
				}else if(response.success=='3'){
				$('#gif').hide();	
				notie.alert(3, response.msg, 2);
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