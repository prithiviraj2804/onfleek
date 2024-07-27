<form method="post" class="form" enctype="multipart/form-data">
<input type="hidden" name="_mm_csrf" value="<?= $this->security->get_csrf_hash() ?>">
<header class="page-content-header">
			<div class="container-fluid">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Add New Area</h3>
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
                    <?php if ($this->mdl_mech_area_list->form_value('is_update')) {
                        echo 'value="1"';
                    } else {
                        echo 'value="0"';
                    } ?>>
	<div class="box">
		<div class="row">
		<div class="col-xs-12">
			<a class="anchor anchor-back" href="<?php echo site_url('mech_area_list'); ?>"><i class="fa fa-long-arrow-left"></i><span>Back to Area</span></a>
		</div>
		</div>
		<div class="box_body">
				<div class="form_group">
					<label class="form_label"><?php _trans('lable899'); ?></label>
					<div class="form_controls">
						<input type="text" name="area_name" id="area_name" class="g-input"
                           value="<?php echo $this->mdl_mech_area_list->form_value('area_name', true); ?>" autocomplete="off">
					</div>
				</div>
	
				<div class="form_group">
					<label class="form_label"><?php _trans('lable89'); ?></label>
					<div class="form_controls">
						<input type="text" name="area_pincode" id="area_pincode" class="g-input"
                           value="<?php echo $this->mdl_mech_area_list->form_value('area_pincode', true); ?>" autocomplete="off">
					</div>
				</div>
				
				<div class="form_group">
					<label class="form_label"><?php _trans('lable900'); ?></label>
					<div class="form_controls">
						
						<input type="checkbox" name="is_service" id="is_service" class="g-input" <?php if($this->mdl_mech_area_list->form_value('is_service', true) == 1){ echo 'checked="checked"'; } ?>>
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
