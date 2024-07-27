<form method="post" class="form" enctype="multipart/form-data">
<input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?= $this->security->get_csrf_hash() ?>">
<header class="page-content-header">
			<div class="container-fluid">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Add New Car Variant</h3>
						</div>
					</div>
				</div>
			</div>
</header>

    <div id="content">
        <div class="row">
            <div class="col-xs-12 col-md-12 col-md-offset-3">

                <?php echo $this->layout->load_view('layout/alerts'); ?>

                <div class="container-wide">
                	<input class="hidden" name="is_update" type="hidden"
                    <?php if ($this->mdl_mech_brand_model_variants->form_value('is_update')) {
                        echo 'value="1"';
                    } else {
                        echo 'value="0"';
                    } ?>>
	<div class="box">
		<div class="row">
		<div class="col-xs-12">
			<a class="anchor anchor-back" href="<?php echo site_url('mech_brand_model_variants'); ?>"><i class="fa fa-long-arrow-left"></i><span>Back to Car Variant</span></a>
		</div>
		</div>
		<div class="box_body">
				<div class="form_group">
					<label class="form_label"><?php _trans('lable229'); ?></label>
					<div class="form_controls">
						<select name="brand_id" id="brand_id" class="bootstrap-select bootstrap-select-arrow g-input removeError" autocomplete="off">
							<option value="">Select Brand Name</option>
							<?php if ($brand_list): 
							$brand_id =  $this->mdl_mech_brand_model_variants->form_value('brand_id', true);
							foreach ($brand_list as $key => $names): 
							?>
							<option value="<?php echo $names->brand_id;?>" <?php if ($names->brand_id == $brand_id) { echo "selected"; }?>> <?php echo $names->brand_name;?></option>
							<?php endforeach;
							endif;
							?>
						</select>
					</div>
				</div>
	
				<div class="form_group">
					<label class="form_label"><?php _trans('lable231'); ?></label>
					<div class="form_controls">
						<select name="model_id" id="model_id" class="bootstrap-select bootstrap-select-arrow g-input removeError" autocomplete="off">
							<option value="">Select Model Name</option>
							<?php if ($brand_models_list): 
							$model_id =  $this->mdl_mech_brand_model_variants->form_value('model_id', true);
							foreach ($brand_models_list as $key => $names): 
							?>
							<option value="<?php echo $names->model_id;?>" <?php if ($names->model_id == $model_id) { echo "selected"; }?>> <?php echo $names->model_name;?></option>
							<?php endforeach;
							endif;
							?>
						</select>
					</div>
				</div>

				<div class="form_group">
					<label class="form_label"><?php _trans('lable232'); ?></label>
					<div class="form_controls">
						<input type="text" name="variant_name" id="variant_name" class="g-input"
                           value="<?php echo $this->mdl_mech_brand_model_variants->form_value('variant_name', true); ?>" autocomplete="off">
					</div>
				</div>

				<div class="buttons text-center">
					<?php $this->layout->load_view('layout/header_buttons'); ?>
				</div>
		</div>
	</div>

</div>

            </div>
        </div>
    </div>

</form>

<script>
$('#brand_id').change(function () {
	$.post("<?php echo site_url('user_cars/ajax/get_brand_models'); ?>", {
			brand_id: $('#brand_id').val(),
			_mm_csrf: $('#_mm_csrf').val()
		},
		function (data) {
			var response = JSON.parse(data);
			if (response.length > 0) {
				$('#model_id').empty(); // clear the current elements in select box
				$('#model_id').append($('<option></option>').attr('value', '').text('Model'));
				for (row in response) {
					$('#model_id').append($('<option></option>').attr('value', response[row].model_id).text(response[row].model_name));
				}
			}
			else {
				
			}
		});
});
</script>