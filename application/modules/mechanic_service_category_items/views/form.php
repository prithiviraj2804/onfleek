<link href="<?php echo base_url(); ?>assets/mp_backend/css/main.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/lib/summernote/summernote.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/separate/pages/editor.min.css">
<input type="hidden" id="_mm_csrf" name="_mm_csrf" value="<?= $this->security->get_csrf_hash(); ?>">
<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php echo _trans($breadcrumb); ?></h3>
				</div>
				<div class="tbl-cell pull-right">
					<a class="btn btn-sm btn-primary" href="<?php echo site_url('mechanic_service_category_items/form'); ?>">
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
		<?php echo $this->layout->load_view('layout/alerts'); ?>
			<div class="container-wide">
				<input type="hidden" name="sc_item_id" id="sc_item_id" value="<?php echo $this->mdl_mechanic_service_category_items->form_value('sc_item_id', true);?>">	
                <input class="hidden" name="is_update" type="hidden" <?php if ($this->mdl_mechanic_service_category_items->form_value('is_update')){echo 'value="1"';}else{echo 'value="0"'; }?>>
				<div class="box">
					<div class="box_body">
						<div class="form_group">
							<label class="form_label"><?php _trans('lable253'); ?>*</label>
							<div class="form_controls">
								<input type="text" name="service_item_name" id="service_item_name" class="form-control" value="<?php echo $this->mdl_mechanic_service_category_items->form_value('service_item_name', true); ?>">
							</div>
						</div>
						<div class="form_group">
							<label class="form_label"><?php _trans('lable239'); ?></label>
							<div class="form_controls">
								<select name="service_category_id" id="service_category_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
									<option value=""><?php _trans('lable252'); ?></option>
									<?php if($service_category_lists):
									$service_category_id = $this->mdl_mechanic_service_category_items->form_value('service_category_id', true);
									foreach ($service_category_lists as $key => $service_category): ?>
									<option value="<?php echo $service_category->service_cat_id; ?>" <?php if ($service_category->service_cat_id == $service_category_id) {
										echo 'selected';
									}?>> <?php echo $service_category->category_name; ?></option>
									<?php endforeach;
									endif;
									?>
								</select>
							</div>	
						</div>
						<div class="form_group">
							<label class="form_label"><?php  _trans('lable256'); ?></label>
							<div class="form_controls">
								<input type="checkbox" name="is_popular" id="is_popular" class="g-input" value="1" 
								<?php if ($this->mdl_mechanic_service_category_items->form_value('is_popular', true) == 1) {
                                	echo 'checked';
                            	} ?>>
							</div>
						</div>
						<div class="buttons text-center">
							<button id="btn-submit" name="btn_submit" class="btn btn-rounded btn-primary btn_submit">
    							<i class="fa fa-check"></i> <?php  _trans('lable57'); ?>
							</button>
							<button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default">
    							<i class="fa fa-times"></i> <?php  _trans('lable58'); ?>
							</button>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/mp_backend/js/lib/summernote/summernote.min.js"></script>
<script type="text/javascript">

	$(document).ready(function() {
		$('.summernote').summernote();
	});

	$("#btn_cancel").click(function () {
        window.location.href = "<?php echo site_url('mechanic_service_category_items'); ?>";
    });

    $(".btn_submit").click(function () {

		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');

		var validation = [];

		if($("#service_item_name").val() == ''){
			validation.push('service_item_name');
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

		$.post('<?php echo site_url('mechanic_service_category_items/ajax/save'); ?>', {
            sc_item_id : $("#sc_item_id").val(),
            is_update : $("#is_update").val(),
			service_item_name : $("#service_item_name").val(),
            service_category_id : $('#service_category_id').val(),
			is_popular : $('#is_popular').val(),
			_mm_csrf: $('#_mm_csrf').val()
        }, function (data) {
            list = JSON.parse(data);
            if(list.success=='1'){
                notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
				setTimeout(function(){
					window.location = "<?php echo site_url('mechanic_service_category_items'); ?>";
				}, 100);
            }else if(list.success=='2'){
				$('#gif').hide();	
				notie.alert(3, 'Aleady Exists', 2);
			}else{
				$('#gif').hide();	
				notie.alert(3, '<?php _trans('toaster2'); ?>', 2);
				$('.has-error').removeClass('has-error');
                for (var key in list.validation_errors) {
                    $('#' + key).parent().addClass('has-error');
                    $('.error_msg_'+key).show().empty().html(list.validation_errors[key]);
                }
            }
        });
	});
</script>