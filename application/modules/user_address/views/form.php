<form method="post" class="form">
<input type="hidden" name="_mm_csrf" value="<?= $this->security->get_csrf_hash() ?>">
<header class="page-content-header">
			<div class="container-fluid">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Add Address</h3>
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
                    <?php if ($this->mdl_user_address->form_value('is_update')) {
                        echo 'value="1"';
                    } else {
                        echo 'value="0"';
                    } ?>>
	<div class="box">
		<div class="row">
		<div class="col-xs-12">
			<a class="anchor anchor-back" href="<?php echo site_url('user_address'); ?>"><i class="fa fa-long-arrow-left"></i><span>Back to Address</span></a>
		</div>
		</div>
		<div class="box_body">
				<div class="form_group">
					<label class="form_label">Plot no. / Street</label>
					<div class="form_controls">
						<input type="text" name="full_address" id="full_address" class="g-input"
                           value="<?php echo $this->mdl_user_address->form_value('full_address', true); ?>">
					</div>
				</div>
				<div class="form_group">
					<label class="form_label">Pin Code</label>
					<div class="form_controls">
						<select name="zip_code" id="zip_code" class="bootstrap-select bootstrap-select-arrow g-input">
												<option value="">Select Zipcode</option>
												<?php  $selected = ''; foreach ($pincode_list as $pincode) {
														 if($pincode->pincode == $this->mdl_user_address->form_value('zip_code', true)){
														 	$selected = 'selected="selected"';
														 }else{
														 	$selected = '';
														 }
													?>
													<option value="<?php echo $pincode->pincode; ?>" <?php echo $selected; ?>><?php echo $pincode->pincode;  ?></option>
												<?php } ?>
											</select>
					</div>
				</div>
				<?php /* * / ?>
				<div class="form_group">
					<label class="form_label">Area</label>
					<div class="form_controls">
						<select name="address_area_id" id="address_area_id" class="bootstrap-select bootstrap-select-arrow g-input">
												<option value="">Select Area</option>
												<?php  $selected = ''; foreach ($area_list as $area) {
														 if($area->area_id == $this->mdl_user_address->form_value('address_area_id', true)){
														 	$selected = 'selected="selected"';
														 }else{
														 	$selected = '';
														 }
													?>
													<option value="<?php echo $area->area_id; ?>" <?php echo $selected; ?>><?php echo $area->area_name;  ?></option>
												<?php } ?>
											</select>
					</div>
				</div>
				<?php / * */ ?>
				
				<div class="form_group">
					<label class="form_label">Tag Place</label>
					<div class="form_controls">
						<div class="row tag_place">
							<div class="col-xs-3">
								<input type="radio" <?php if($this->mdl_user_address->form_value('address_type', true) == 'Home'){ echo "checked"; } ?> name="address_type" class="g-input"
                           value="Home"><label>Home</label>
							</div>
							<div class="col-xs-3">
								<input type="radio" <?php if($this->mdl_user_address->form_value('address_type', true) == 'Office'){ echo "checked"; } ?> name="address_type" class="g-input"
                           value="Office"><label>Office</label>
							</div>
							<div class="col-xs-3">
								 <input type="radio" <?php if($this->mdl_user_address->form_value('address_type', true) == 'Others'){ echo "checked"; } ?> name="address_type" class="g-input"
                           value="Others"><label>Others</label>
							</div>
						</div>
					</div>
				</div>
				<div class="form_group">
					<label class="form_label">Is Default</label>
					<div class="form_controls">
						<input type="checkbox" <?php if($this->mdl_user_address->form_value('is_default', true) == 'Y'){ echo "checked"; } ?> name="is_default" id="is_default" class="g-input"
                           value="Y">
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
