<?php $transaction_url_key = $transaction_details->url_key?$transaction_details->url_key:$url_key; ?>
<script type="text/javascript">
function getfile(){
	var filename = $('input[type=file]').val().split("\\");
	$("#fileName").val(filename[2]);
	$("#showError").hide();
}

function getproductUploadFiles(url_key){
	if(url_key){
		$.post('<?php echo site_url('mech_bank_list/ajax/getUploadedImages'); ?>', {
			url_key : url_key,
			_mm_csrf : $('#_mm_csrf').val()
		}, function (data) {
			list = JSON.parse(data);
			if(list.success == '1'){
				if(list.productImages.length > 0){
					var html = '';
					var hrefs = '<?php echo base_url()."uploads/transaction_files/";?>';
					for(var i = 0; i<list.productImages.length; i++){

						html += '<span class="col-xs-12 col-md-2 col-sm-2 col-lg-2 col-xl-2" style="float:left;">';
						html += '<span class="spanOne">';
						html += '<a href="'+hrefs+''+list.productImages[i].file_name_new+'" target="_blank" >';
						html += '<img src="'+hrefs+''+list.productImages[i].file_name_new+'" width="100%" height="100px">';
						html += '</a></span>';
						html += '<span class="spanTwo" onclick="getDeleteUploadFIle(\''+list.productImages[i].upload_id+'\',\'D\',\''+list.productImages[i].file_name_original+'\')">';
						html += '<i class="fa fa-trash-o" aria-hidden="true"></i></span></span>';
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
	var deposit_id = $("#deposit_id").val();

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
					entity_id : $('#deposit_id').val(),
					entity_type : 'T',
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
										var href = '<?php echo base_url()."uploads/transaction_files/";?>';
										for(var i = 0; i<list.doclist.length; i++){
											html += '<span class="col-xs-12 col-md-2 col-sm-2 col-lg-2 col-xl-2" style="float:left;">';
											html += '<span class="spanOne">';
											html += '<a href="'+href+''+list.doclist[i].file_name_new+'" target="_blank" >';
											html += '<img src="'+href+''+list.doclist[i].file_name_new+'" width="100%" height="100px">';
											html += '</a></span>';
											html += '<span class="spanTwo" onclick="getDeleteUploadFIle(\''+list.doclist[i].upload_id+'\',\'D\',\''+list.doclist[i].file_name_original+'\')">';
											html += '<i class="fa fa-trash-o" aria-hidden="true"></i></span></span>';
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
			entity_id : $('#deposit_id').val(),
			entity_type : 'T',
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
					var href = '<?php echo base_url()."uploads/transaction_files/";?>';
					for(var i = 0; i<list.doclist.length; i++){
						html += '<span class="col-xs-12 col-md-2 col-sm-2 col-lg-2 col-xl-2" style="float:left;">';
						html += '<span class="spanOne">';
						html += '<a href="'+href+''+list.doclist[i].file_name_new+'" target="_blank" >';
						html += '<img src="'+href+''+list.doclist[i].file_name_new+'" width="100%" height="100px">';
						html += '</a></span>';
						html += '<span class="spanTwo" onclick="getDeleteUploadFIle(\''+list.doclist[i].upload_id+'\',\'D\',\''+list.doclist[i].file_name_original+'\')">';
						html += '<i class="fa fa-trash-o" aria-hidden="true"></i></span></span>';
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
<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php echo _trans($breadcrumb); ?></h3>
				</div>
				<div class="tbl-cell pull-right">
					<a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_bank_list/create'); ?>">
						<i class="fa fa-plus"></i> <?php _trans('lable40'); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</header>
<div class="box expense">
	<div class="row">
		<div id="gif" class="gifload">
			<div class="gifcenter">
			  <center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
		    </div>
		</div>
		<div class="col-xs-12 top-15">
			<a class="anchor anchor-back" href="<?php echo site_url('mech_bank_list/transaction_list'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
		</div>
	</div>
	<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" autocomplete="off">
	<input type="hidden" name="deposit_id" id="deposit_id" value="<?php echo $transaction_details->deposit_id; ?>" autocomplete="off">
	<input type="hidden" name="url_key" id="url_key" value="<?php echo $transaction_url_key;?>" >
	<div class="box_body col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
			<label class="form_label"><?php _trans('lable149'); ?>*</label>
			<select id="branch_id" name="branch_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
				<?php foreach ($branch_list as $branchList) {?>
				<option value="<?php echo $branchList->w_branch_id; ?>" <?php if($transaction_details->w_branch_id == $branchList->w_branch_id){echo "selected";}?> > <?php echo $branchList->display_board_name; ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
			<label class="form_label"><?php _trans('lable390'); ?><span id="hide">*</span></label>
			<select id="bank_id" name="bank_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
				<option value=""><?php _trans('lable390'); ?></option>
				<?php foreach ($bank_list as $bankList) {?>
				<option value="<?php echo $bankList->bank_id; ?>" <?php if($transaction_details->bank_id == $bankList->bank_id){echo "selected";}?> > <?php echo $bankList->account_number." (".$bankList->bank_name.")"; ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
			<label class="form_label"> <?php _trans('lable31'); ?>*</label>
			<div class="form_controls">
				<input type="text" name="payment_date" id="payment_date" class="form-control removeErrorInput datepicker" value="<?php echo $transaction_details->payment_date?date_from_mysql($transaction_details->payment_date):date('d/m/Y'); ?>" autocomplete="off">
			</div>
		</div>
		<div class="form_group col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0px">
		<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
			<label class="form_label"><?php _trans('lable108'); ?>*</label>
			<div class="form_controls">
				<input type="hidden" value="<?php echo $transaction_details->amount;?>" id="existing_amount" name="existing_amount" ? autocomplete="off">
				<input type="text" name="amount" id="amount" class="form-control" value="<?php echo $transaction_details->amount; ?>" autocomplete="off">
			</div>
		</div>
		<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
			<label class="form_label"><?php _trans('lable482'); ?>*</label>
			<div class="form_controls">
				<select class="form-control simple-select bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" name="tran_type" id="tran_type">
					<option value=""><?php echo trans('lable483'); ?></option>
                    <option value="D" <?php if($transaction_details->tran_type == "D"){ echo "selected"; }?> ><?php echo trans('lable484'); ?></option>
                    <option value="W" <?php if($transaction_details->tran_type == "W"){ echo "selected"; }?> ><?php echo trans('lable485'); ?></option>
				</select>
			</div>
		</div>
		<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
			<label class="form_label"><?php _trans('lable465'); ?>*</label>
			<div class="form_controls">
				<select class="form-control simple-select bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" name="payment_method_id" id="payment_method_id">
					<option value=""><?php echo trans('lable466'); ?></option>
					<?php foreach ($payment_methods as $payMetList) { ?>
					<option value="<?php echo $payMetList->payment_method_id; ?>" 
					<?php if ($payMetList->payment_method_id == $transaction_details->payment_method_id) {
							echo "selected='selected'";
					} ?> >
					<?php echo $payMetList->payment_method_name; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		</div>
        <div class="form_group col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0px">
            <div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <label class="form_label"><?php _trans('lable148'); ?></label>
                <div class="form_controls">
                    <select class="form-control simple-select bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" name="action_emp_id" id="action_emp_id" autocomplete="off">
                        <option value=""><?php echo trans('lable457'); ?></option>
                        <?php foreach ($employee_list as $emplist) { ?>
                        <option value="<?php echo $emplist->employee_id; ?>" 
                        <?php if ($emplist->employee_id == $transaction_details->action_emp_id) {
                            echo "selected='selected'"; } ?> >
                        <?php echo $emplist->employee_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
			<?php if($this->session->userdata('is_shift') == 1){ ?>
			<input type="hidden" value="<?php echo $employee_shift?$employee_shift:1;?>" id="shift" name="shift" autocomplete="off">
			<?php } else { ?>
			<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<label class="form_label"><?php _trans('lable152'); ?></label>
				<select id="shift" name="shift" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
					<option value=""><?php echo trans('lable152'); ?></option>	
					<?php foreach ($shift_list as $shiftList) {?>
					<option value="<?php echo $shiftList->shift_id; ?>" <?php if($transaction_details->shift == $shiftList->shift_id){echo "selected";}?> > <?php echo $shiftList->shift_name; ?></option>
					<?php } ?>
				</select>
			</div>
			<?php } ?>
			<div class="form_group col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<label class="form_label"> <?php _trans('lable486'); ?></label>
				<div class="form_controls">
					<input type="text" name="reference_dtls" id="reference_dtls" class="form-control" value="<?php echo $transaction_details->reference_dtls; ?>" autocomplete="off">
				</div>
			</div>
        </div>
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 paddingTop20px">
			<form class="col-lg-12 col-md-12 col-sm-12 padding0px upload" id="upload_csv" method="post" enctype="multipart/form-data">  
				<span class="font_weight_bold">Upload Picture</span> <span class="btn" id="uploadButton">Choose File</span>
				<input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
				<input type="file" id="file" onchange="getfile()" class="inputTypeFile inputfile" name="file" style="display:none;"/>
				<input type="hidden" id="fileName" name="fileName" value="" />
				<input type="submit" class="upload_btn" id="upload_btn" style="display:none;">
			</form>
			<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 col-xl-12">
				<span id="showErrorMessage" class="error"></span>
			</div>
			<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 col-xl-12 paddingTop20px">
				<div id="productImagesBox" class="productImagesBox">
					<?php foreach ($uploadedImages as $documentList){ ?>
					<span class="col-xs-12 col-md-2 col-sm-2 col-lg-2 col-xl-2" style="float:left;">
						<span class="spanOne">
							<a href="<?php echo base_url()."uploads/transaction_files/".$documentList->file_name_new?>" target="_blank" >
								<img src="<?php echo base_url()."uploads/transaction_files/".$documentList->file_name_new?>" width="100%" height="100px">
							</a>
						</span>
						<span class="spanTwo marginTop10px" onclick="getDeleteUploadFIle('<?php echo $documentList->upload_id; ?>','D','<?php echo $documentList->file_name_original; ?>')">
							<i class="fa fa-trash-o" aria-hidden="true"></i>
						</span>
					</span>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0px">
			<div class="buttons text-center paddingTop20px">
				<button id="btn_submit" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
				    <i class="fa fa-check"></i> <?php _trans('lable57'); ?>
				</button>
				<button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default">
				    <i class="fa fa-times"></i><?php _trans('lable58'); ?>
				</button>
			</div>
		</div>
	<div>
</div>
<script type="text/javascript">

	$("#btn_cancel").click(function () {
        window.location.href = "<?php echo site_url('mech_bank_list/transaction_list'); ?>";
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
			url : "<?php echo site_url('upload/upload/upload_file/'.($transaction_details->deposit_id?$transaction_details->deposit_id:0).'/T/'.($transaction_url_key)); ?>",
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
    
    $(".btn_submit").click(function () {
		var validation = [];
		if($("#branch_id").val() == ''){
			validation.push('branch_id');
		}
		if($("#payment_method_id :selected").text().toLowerCase().trim() != 'cash')
		{
			if($("#bank_id").val() == ''){
				validation.push('bank_id');
			}
			else{
				$('#bank_id').removeClass("border_error");
				$('#bank_id').parent().removeClass('has-error');
			}
			$('#hide').show();
		}else{
			$('#hide').hide();
			$('#bank_id').removeClass("border_error");
			$('#bank_id').parent().removeClass('has-error');
		}
		if($("#payment_date").val() == ''){
			validation.push('payment_date');
		}
		if($("#amount").val() == ''){
			validation.push('amount');
		}
		if($("#tran_type").val() == ''){
			validation.push('tran_type');
		}
		if($("#payment_method_id").val() == ''){
			validation.push('payment_method_id');
		}
		if(validation.length > 0){
			validation.forEach(function(val){
				$('#'+val).addClass("border_error");
				$('#'+val).parent().addClass('has-error');
			});
			return false;
		}
		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');

		$('#gif').show();	
		$.post('<?php echo site_url('mech_bank_list/ajax/savetransaction'); ?>', {
			deposit_id : $("#deposit_id").val(),
			url_key : $("#url_key").val(),
			bank_id : $("#bank_id").val(),
			branch_id : $("#branch_id").val(),
			shift : $("#shift").val(),
			existing_amount : $("#existing_amount").val(),
			amount : $('#amount').val(),
			action_emp_id : $("#action_emp_id").val(),
            payment_date : $("#payment_date").val().split("/").reverse().join("-"),
            // entity_id : $("#entity_id").val(),
			// entity_type: $("#entity_type").val(),
            tran_type : $("#tran_type").val(),
			reference_dtls : $("#reference_dtls").val(),
            payment_method_id: $("#payment_method_id").val(),
			_mm_csrf: $('#_mm_csrf').val()
        }, function (data) {
            list = JSON.parse(data);
            if(list.success=='1'){
                notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
                setTimeout(function(){ 
                    window.location = "<?php echo site_url('mech_bank_list/transaction_list'); ?>";
                }, 1000);
            }else{
				$('#gif').hide();	
				notie.alert(3, '<?php _trans('toaster2'); ?>', 2);
				$('.has-error').removeClass('has-error');
                for (var key in list.validation_errors) {
                    $('#' + key).parent().addClass('has-error');
                    $('.error_msg_' + key).show().empty().html(list.validation_errors[key]);
                }
            }
        });
	});
</script>