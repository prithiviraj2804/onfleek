
    <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?= $this->security->get_csrf_hash(); ?>">
	<header class="page-content-header">
			<div class="container-fluid">
			
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3><?php echo _trans($breadcrumb); ?></h3>
						</div>
						<div class="tbl-cell pull-right">
							<a class="btn btn-sm btn-primary" href="<?php echo site_url('customer_category/form'); ?>">
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
					<a class="anchor anchor-back" onclick="goBack()" href="<?php echo site_url('customer_category/index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
				</div>
            <div class="col-xs-12 col-md-12 col-md-offset-3">
				<div class="container-wide">
                	<input class="hidden" name="is_update" id="is_udpate" type="hidden" value=""<?php if($this->mdl_customer_category->form_value('is_update')){
    echo "1";
} else {
    echo "0";
}?>
                    <?php  ?>autocomplete="off">

					<div class="col-sm-9">
						<input type="hidden" name="customer_category_id" id="customer_category_id" class="form-control" value="<?php echo $this->mdl_customer_category->form_value('customer_category_id', true); ?>"autocomplete="off">
					</div>
					<div class="box">
						<div class="box_body">
								<div class="form_group">
									<label class="form_label"> <?php _trans('lable850'); ?>*</label>
									<div class="form_controls">
										<input type="text" name="customer_category_name" id="customer_category_name" class="form-control"
                           					value="<?php echo $this->mdl_customer_category->form_value('customer_category_name', true); ?>" autocomplete="off">
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
    </div>

	<script type="text/javascript">
		
	$("#btn_cancel").click(function () {
        window.location.href = "<?php echo site_url('customer_category'); ?>";
    });

    $(".btn_submit").click(function () {

		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');

		var validation = [];

		if($("#customer_category_name").val() == ''){
			validation.push('customer_category_name');
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

		$.post('<?php echo site_url('customer_category/ajax/create'); ?>', {
            customer_category_id : $("#customer_category_id").val(),
            customer_category_name : $("#customer_category_name").val(),
			is_udpate : $("#is_udpate").val(),
			_mm_csrf: $('#_mm_csrf').val()
        }, function (data) {
            list = JSON.parse(data);
            if(list.success=='1'){
                notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
				setTimeout(function(){
					$('#gif').hide(); 
					window.location = "<?php echo site_url('customer_category'); ?>";
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
