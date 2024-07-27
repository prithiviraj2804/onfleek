<form method="post" class="form" enctype="multipart/form-data">
<input type="hidden" name="_mm_csrf" value="<?= $this->security->get_csrf_hash() ?>">
<header class="page-content-header">
			<div class="container-fluid">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Add New Car Model</h3>
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
                    <?php if ($this->mdl_mech_car_brand_models_details->form_value('is_update')) {
                        echo 'value="1"';
                    } else {
                        echo 'value="0"';
                    } ?>>
	<div class="box">
		<div class="row">
		<div class="col-xs-12">
			<a class="anchor anchor-back" href="<?php echo site_url('mech_car_brand_models_details'); ?>"><i class="fa fa-long-arrow-left"></i><span>Back to Car Model</span></a>
		</div>
		</div>
		<div class="box_body">
				<div class="form_group">
					<label class="form_label"><?php _trans('lable229'); ?></label>
					<div class="form_controls">
						<select name="brand_id" id="brand_id" class="bootstrap-select bootstrap-select-arrow g-input removeError" autocomplete="off">
							<option value="">Select Brand Name</option>
							<?php if ($brand_list): 
							$brand_id =  $this->mdl_mech_car_brand_models_details->form_value('brand_id', true);
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
						<input type="text" name="model_name" id="model_name" class="g-input"
                           value="<?php echo $this->mdl_mech_car_brand_models_details->form_value('model_name', true); ?>" autocomplete="off">
					</div>
				</div>
	
				<div class="form_group">
					<label class="form_label"><?php _trans('lable448'); ?></label>
					<div class="form_controls">
						<input type="file" name="model_image" id="model_image" class="g-input"
                           value="<?php echo $this->mdl_mech_car_brand_models_details->form_value('model_image', true); ?>" autocomplete="off">
					</div>
				</div>
				<?php if($this->mdl_mech_car_brand_models_details->form_value('model_image', true)){ ?>
				<div class="form_group">
					<label class="form_label"></label>
					<div class="form_controls">
						<img src="<?php echo base_url();?>uploads/car_images/models/<?php echo $this->mdl_mech_car_brand_models_details->form_value('model_image', true); ?>" width="100" height="100">
						
					</div>
				</div>
				<?php } ?>

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
