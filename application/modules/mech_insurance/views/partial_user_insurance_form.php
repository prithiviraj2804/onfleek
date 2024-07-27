<form method="post" action="<?php echo site_url('mech_insurance/user_insurance'); ?>" class="form" enctype="multipart/form-data">
<input type="hidden" name="_mm_csrf" value="<?= $this->security->get_csrf_hash() ?>">
<div id="content">
        <div class="row">
            <div class="col-xs-12 col-md-12 col-md-offset-3">

                <?php echo $this->layout->load_view('layout/alerts'); ?>

                <div class="container-wide">
                	<input class="hidden" name="insurance_id" type="hidden" value="<?php echo $insurance_id; ?>">
                	<input class="hidden" name="is_update" type="hidden"
                    <?php if ($this->mdl_mech_insurance->form_value('is_update')) {
                        echo 'value="1"';
                    } else {
                        echo 'value="0"';
                    } ?>>
	<div class="box">
		<div class="row">
		<div class="col-xs-12">
			<a class="anchor anchor-back" href="<?php echo site_url('mech_insurance'); ?>"><i class="fa fa-long-arrow-left"></i><span>Back to Insurance</span></a>
		</div>
		</div>
		<div class="box_body">
			<?php if(isset($validation)){ ?>
				Please Enter Mandatory Field
			<?php } ?>
				<div class="form-group">
					<label class="form_label">Select your car *</label>
					<div class="form_controls">
					<select name="user_car_list_id" id="user_car_list_id" class="bootstrap-select bootstrap-select-arrow g-input removeError" data-live-search="true" required="required" autocomplete="off">
						<option value="">Select your car</option>
						<?php foreach ($car_list as $car) { 
								if($this->mdl_mech_insurance->form_value('car_id', true) == $car->car_list_id){
								 	$selected = 'selected="selected"';
								 }else{
								 	$selected = '';
								 }
							
							$variant_name = ($car->variant_name)?$car->variant_name:'';
							?>
							<option value="<?php echo $car->car_list_id; ?>" <?php echo $selected; ?>><?php echo $car->model_name." ".$variant_name."( ".$car->car_reg_no." )";  ?></option>
						<?php } ?>
					</select>
					<a href="javascript:void(0)" data-toggle="modal" data-model-from="quote" data-target="#addNewCar" class="add_car">ADD A NEW CAR</a>
					</div>
				</div>
				
				<div class="form_group">
					<label class="form_label">Existing IDV Value  *</label>
					<div class="form_controls">
						<input type="text" name="existing_idv_value" id="existing_idv_value" class="g-input"
                           value="<?php echo $this->mdl_mech_insurance->form_value('existing_idv_value', true); ?>" autocomplete="off">
					</div>
				</div>	
				
				<div class="form-group">
					<label class="form_label">Is Already Experied ?</label>
					<div class="form_controls">
					<select class="bootstrap-select bootstrap-select-arrow g-input removeError" name="is_already_expired" id="is_already_expired" autocomplete="off">
						<option =""></option>
						<option value="Y" <?php if($this->mdl_mech_insurance->form_value('is_already_expired', true)=='Y'){ echo "selected='selected'"; } ?>>Yes</option>
						<option value="N" <?php if($this->mdl_mech_insurance->form_value('is_already_expired', true)=='N'){ echo "selected='selected'"; } ?>>No</option>
						</select>
					</div>
				</div>
				<div class="form_group">
					<label class="form_label">Existing Expired Date  *</label>
					<div class="form_controls">
						
						<div class="input-group date datetimepicker-1">
								<input type="text" class="form-control" id="existing_expired_date" name="existing_expired_date" value="<?php echo $this->mdl_mech_insurance->form_value('existing_expired_date', true); ?>" autocomplete="off">
							<span class="input-group-addon">
								<i class="font-icon font-icon-calend"></i>
							</span>
							</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="form_label">RC Book  *</label>
					<div class="form_controls">
						<input type="file" name="rc_book_image" id="rc_book_image" class="input-custom input-full" 
						value="<?php echo $this->mdl_mech_insurance->form_value('rc_book_url', true); ?>" required="required" autocomplete="off">
					</div>
				</div>
				
				<div class="form_group">
					<label class="form_label">Insurance  *</label>
					<div class="form_controls">
						<input type="file" name="insurance_url" id="insurance_url" class="g-input"
                           value="<?php echo $this->mdl_mech_insurance->form_value('insurance_url', true); ?>" autocomplete="off">
					</div>
				</div>
				
				
				<?php if($this->mdl_mech_insurance->form_value('insurance_url', true)){ ?>
				<div class="form_group">
					<label class="form_label"></label>
					<div class="form_controls">
						<a target="_blank" href="<?php echo base_url();?>uploads/insurance/<?php echo $this->mdl_mech_insurance->form_value('insurance_url', true); ?>">Click Insurance Book</a>
						
					</div>
					<input type="hidden" name="insurance_url_existing" value="<?php echo $this->mdl_mech_insurance->form_value('insurance_url', true); ?>" />
				</div>
				<?php } ?>
				
				<?php if($this->mdl_mech_insurance->form_value('rc_book_url', true)){ ?>
				<div class="form_group">
					<label class="form_label"></label>
					<div class="form_controls">
						<a target="_blank" href="<?php echo base_url();?>uploads/insurance/<?php echo $this->mdl_mech_insurance->form_value('rc_book_url', true); ?>">Click RC Book</a>
						
					</div>
					<input type="hidden" name="rc_book_url_existing" value="<?php echo $this->mdl_mech_insurance->form_value('rc_book_url', true); ?>" />
				</div>
				<?php } ?>
				
				<div class="buttons text-center">
					<button id="btn_submit" name="btn-submit" class="btn btn-rounded btn-primary btn-padding-left-right-40" value="1">
						    <i class="fa fa-check"></i> Save</button>
					<button id="btn_cancel" name="btn-cancel" class="btn btn-rounded btn-default" value="1">
					    <i class="fa fa-times"></i> Cancel</button>	
				</div>
		</div>
	</div>

</div>

            </div>
        </div>
    </div>

</form>

<script type="text/javascript">
		$(document).ready(function(){

$('.datetimepicker-1').datetimepicker({
				widgetPositioning: {
					horizontal: 'right'
				},
				defaultDate: new Date(),
    			format:'DD/MM/YYYY',
    			minDate:new Date(),
				debug: false
			});

			$('.datetimepicker-2').datetimepicker({
				widgetPositioning: {
					horizontal: 'right'
				},
				format: 'hh:mm',
				debug: false
			});
    });
    </script>


