
  <header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php echo $breadcrumb; ?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-sm btn-primary" href="<?php echo site_url('workshop_setup/index/0/5'); ?>">
                        <i class="fa fa-plus"></i> <?php _trans('new'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
    <input type="hidden" id="_mm_csrf" name="_mm_csrf" value="<?= $this->security->get_csrf_hash(); ?>">
    <div id="content">
        <div class="row">
            <div class="col-xs-12 top-15">
                <a class="anchor anchor-back" href="<?php echo site_url('workshop_setup/index/5'); ?>"><i class="fa fa-long-arrow-left"></i><span>Back to List</span></a>
            </div>
            <div class="col-xs-12 col-md-12 col-md-offset-3">
				<?php $this->layout->load_view('layout/alerts'); ?>
				<div class="container-wide">
                	<input class="hidden" name="is_update" type="hidden"
                    <?php if ($this->mdl_payment_methods->form_value('is_update')) {
    echo 'value="1"';
} else {
    echo 'value="0"';
} ?>>
                    <div class="box">
                        <div class="box_body">
                            <div class="form_group">
                                <label class="form_label"> <?php _trans('lable880'); ?>*</label>
                                <div class="form_controls ">
                                <input type="hidden"  name="payment_method_id" id="payment_method_id" class="form-control"
                                        value="<?php echo $this->mdl_payment_methods->form_value('payment_method_id', true); ?>" autocomplete="off">
                                    <input type="text" name="payment_method_name" id="payment_method_name" class="form-control"
                                        value="<?php echo $this->mdl_payment_methods->form_value('payment_method_name', true); ?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="buttons text-center paddingtop15px">
									<button value="2" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
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
<script type="text/javascript">
		
	$("#btn_cancel").click(function () {
        window.location.href = "<?php echo site_url('workshop_setup/index/5'); ?>";
        return false;
    });

    $(".btn_submit").click(function () {

		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');

		var validation = [];

		if($("#payment_method_name").val() == ''){
			validation.push('payment_method_name');
		}
		
		if(validation.length > 0){
			validation.forEach(function(val) {
				$('#'+val).addClass("border_error");
				if($('#'+val+'_error').length == 0){
					$('#'+val).parent().addClass('has-error');
				} 
			});
			return false;
		}

		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');
		$('#gif').show();

		$.post('<?php echo site_url('payment_methods/ajax/savepay'); ?>', {
            payment_method_id : $("#payment_method_id").val(),
            payment_method_name : $("#payment_method_name").val(),
			is_udpate : $("#is_udpate").val(),
			_mm_csrf: $('#_mm_csrf').val()
        }, function (data) {
            list = JSON.parse(data);
            if(list.success=='1'){
                notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
				setTimeout(function(){
					$('#gif').hide(); 
					window.location = "<?php echo site_url('workshop_setup/index/5'); ?>";
				}, 100);
            }else if(list.success == '2'){
				$('#gif').hide();	
				notie.alert(3, 'Already Existed', 2);
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