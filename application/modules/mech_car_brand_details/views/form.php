<form method="post" class="form" enctype="multipart/form-data">
<input type="hidden" name="_mm_csrf" value="<?= $this->security->get_csrf_hash() ?>">
<header class="page-content-header">
			<div class="container-fluid">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Add New Car Brand</h3>
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
                    <?php if ($this->mdl_mech_car_brand_details->form_value('is_update')) {
                        echo 'value="1"';
                    } else {
                        echo 'value="0"';
                    } ?>>
	<div class="box">
		<div class="row">
		<div class="col-xs-12">
			<a class="anchor anchor-back" href="<?php echo site_url('mech_car_brand_details'); ?>"><i class="fa fa-long-arrow-left"></i><span>Back to Car Brand</span></a>
		</div>
		</div>
		<div class="box_body">
				<div class="form_group">
					<label class="form_label"><?php _trans('lable229'); ?></label>
					<div class="form_controls">
						<input type="text" name="brand_name" id="brand_name" class="g-input"
                           value="<?php echo $this->mdl_mech_car_brand_details->form_value('brand_name', true); ?>" autocomplete="off">
					</div>
				</div>
	
				<div class="form_group">
					<label class="form_label"><?php _trans('lable448'); ?></label>
					<div class="form_controls">
						<input type="file" name="brand_image" id="brand_image" class="g-input"
                           value="<?php echo $this->mdl_mech_car_brand_details->form_value('brand_image', true); ?>" autocomplete="off">
					</div>
				</div>
				<?php if($this->mdl_mech_car_brand_details->form_value('brand_image', true)){ ?>
				<div class="form_group">
					<label class="form_label"></label>
					<div class="form_controls">
						<img src="<?php echo base_url();?>uploads/car_images/brand/<?php echo $this->mdl_mech_car_brand_details->form_value('brand_image', true); ?>" width="100" height="100">
						
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
