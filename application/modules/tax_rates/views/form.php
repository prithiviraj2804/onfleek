<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php echo _trans($breadcrumb); ?></h3>
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
            <a class="anchor anchor-back" onclick="goBack()" href="<?php echo site_url('workshop_setup/index/11'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
        </div>
        <div class="col-xs-12 col-md-12 col-md-offset-3">
			<div class="container-wide usermanagement overflow_inherit">
                <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="tax_rate_id" id="tax_rate_id" class="form-control" value="<?php echo $tax_details->tax_rate_id;?>">

				<section class="tabs-section" >
					<div class="tab-content">
                    <div class="form-group clearfix">
                        <div class="col-sm-3 text-right">
                            <label class="control-label string required"><?php _trans('lable980'); ?> *</label>
                        </div>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" name="tax_rate_name" id="tax_rate_name" value="<?php echo $tax_details->tax_rate_name; ?>" autocomplete="off">
                        </div>
					</div>

                    <div class="form-group clearfix">
                        <div class="col-sm-3 text-right">
                            <label class="control-label string required"><?php _trans('lable981'); ?> *</label>
                        </div>
                        <div class="col-sm-9">
                            <input class="form-control" type="text" name="tax_rate_percent" id="tax_rate_percent" value="<?php echo $tax_details->tax_rate_percent; ?>" autocomplete="off">
                        </div>
					</div>

                    <div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required" style="margin-right: 3px"> <?php _trans('lable982'); ?> *</label>
								</div>
								<div class="col-sm-9">
                                <?php $moduleidarray = explode(',', $tax_details->module_id); ?>
                           			<select name="module_id" id="module_id" class="select2 form-control removeError" multiple="multiple">
                                        <option value="10" <?php if (in_array("10", $moduleidarray)) {echo "selected";} ?>>Estimate</option>
                                        <option value="9" <?php if (in_array("9", $moduleidarray)) {echo "selected";} ?>>Workshop</option>
                                        <option value="11" <?php if (in_array("11", $moduleidarray)) {echo "selected";} ?>>Invoice</option>
                                        <option value="13" <?php if (in_array("13", $moduleidarray)) {echo "selected";} ?>>Purchase</option>
                                        <option value="14" <?php if (in_array("14", $moduleidarray)) {echo "selected";} ?>>Expense</option>                                            
									</select>
								</div>
						</div>

                        <div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required" style="margin-right: 3px"> <?php _trans('lable983'); ?> *</label>
								</div>
								<div class="col-sm-9">
                           			<select name="apply_for" id="apply_for" class="bootstrap-select bootstrap-select-arrow g-input removeError">
	                           			<option value=""><?php _trans("lable985"); ?></option>
										<option value="A" <?php if ($tax_details->apply_for == "A") {echo "selected";} ?>>After Discount</option>
										<option value="B" <?php if ($tax_details->apply_for == "B") {echo "selected";} ?>>Before  Discount</option>
									</select>
								</div>
						</div>

                        <div class="form-group clearfix">
								<div class="col-sm-3 text-right">
									<label class="control-label string required" style="margin-right: 3px"> <?php _trans('lable19'); ?> *</label>
								</div>
								<div class="col-sm-9">
                           			<select name="status" id="status" class="bootstrap-select bootstrap-select-arrow g-input removeError">
	                           			<option value=""><?php _trans("lable285"); ?></option>
										<option value="A" <?php if ($tax_details->status == "A") {echo "selected";} ?>>Active</option>
										<option value="I" <?php if ($tax_details->status == "I") {echo "selected";} ?>>Inactive</option>
									</select>
								</div>
						</div>

                        <div class="col-xs-12 col-sm-12 col-md-12 buttons text-center paddingTop40px">
                            <button value="2" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
                                <i class="fa fa-check"></i> <?php _trans('lable57'); ?>
                            </button>
                            <button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default">
                                <i class="fa fa-times"></i><?php _trans('lable58'); ?>
                            </button>
                        </div>	
                    </div>
    			</div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

$("#tax_rate_percent").on("keypress keyup blur",function (event) {    
           $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
	});

$(document).ready(function() {

    $("#module_id").select2();


    $("#btn_cancel").click(function () {
		window.location.href = "<?php echo site_url('workshop_setup/index/11'); ?>";
    });

    $(".btn_submit").click(function () {

    /* Frontend Field Validation */

        $('.border_error').removeClass('border_error');
        $('.has-error').removeClass('has-error');
        $('.select2').removeClass("border_error");

        var validation = [];

        if($("#tax_rate_name").val() == ''){
            validation.push('tax_rate_name');
        }
        if($("#tax_rate_percent").val() == ''){
            validation.push('tax_rate_percent');
        }
		if($("#module_id").val() == '' || $("#module_id").val() == null){
		validation.push('module_id');
		}
        
        if($("#apply_for").val() == ''){
            validation.push('apply_for');
        }
        if($("#status").val() == ''){
            validation.push('status');
        }

        if(validation.length > 0){
            validation.forEach(function(val) {
                $('#'+val).addClass("border_error");
				$('#'+val).parent().addClass('has-error');
				$('.select2-selection').addClass("border_error");

            });
            return false;
        }
        $('.select2').removeClass("border_error");
		$('.border_error').removeClass('border_error');
        $('.has-error').removeClass('has-error');
        $('#gif').show();

        $.post('<?php echo site_url('tax_rates/ajax/save_tax'); ?>', {
            tax_rate_id : $("#tax_rate_id").val(),
            tax_rate_name : $('#tax_rate_name').val(),
            tax_rate_percent : $('#tax_rate_percent').val(),
            module_id : $('#module_id').val(),
            apply_for : $('#apply_for').val(),
            status : $('#status').val(),
            btn_submit : $(this).val(),
            _mm_csrf: $('#_mm_csrf').val()
        }, function (data) {
            list = JSON.parse(data);
            if(list.success=='1'){
                notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
                window.location.href = "<?php echo site_url('workshop_setup/index/11'); ?>";
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
});

</script>