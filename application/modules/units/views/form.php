<form method="post">
    <input type="hidden" name="_mm_csrf" value="<?= $this->security->get_csrf_hash() ?>">
	<header class="page-content-header">
			<div class="container-fluid">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3><?php _trans('add_unit'); ?></h3>
						</div>
					</div>
				</div>
			</div>
	</header>
	
    <div id="content">
        <div class="row">
            <div class="col-xs-12 col-md-12 col-md-offset-3">
				<?php $this->layout->load_view('layout/alerts'); ?>
				<div class="container-wide">
                	<input class="hidden" name="is_update" type="hidden"
                    <?php if ($this->mdl_units->form_value('is_update')) {
                        echo 'value="1"';
                    } else {
                        echo 'value="0"';
                    } ?>>
					<div class="box">
						<div class="box_body">
								<div class="form_group">
									<label class="form_label"> <?php _trans('unit_name'); ?></label>
									<div class="form_controls">
										<input type="text" name="unit_name" id="unit_name" class="form-control"
                           					value="<?php echo $this->mdl_units->form_value('unit_name', true); ?>">
									</div>
								</div>
								<div class="form_group">
									<label class="form_label"> <?php _trans('unit_name_plrl'); ?></label>
									<div class="form_controls">
										<input type="text" name="unit_name_plrl" id="unit_name_plrl" class="form-control"
                           					value="<?php echo $this->mdl_units->form_value('unit_name_plrl', true); ?>">
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
