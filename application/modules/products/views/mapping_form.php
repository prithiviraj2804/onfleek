<style>
	#products_form .tax_percentage{
		    width: 48%;
    		float: inherit;
	}
	#products_form .tax_amount{
		    width: 48%;
    		float: right;
	}
</style>
<script type="text/javascript">
    $(function () {
        // Display the create quote modal
        $(".bootstrap-select").selectpicker("refresh");
        
         $('#brand_id').change(function () {
         	$('#variant_id').empty(); // clear the current elements in select box
            $('#variant_id').append($('<option></option>').attr('value', '').text('Variant'));
            $('#variant_id').selectpicker("refresh");
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
		                $('#model_id').selectpicker("refresh");
                    }
                    else {
                       $('#model_id').empty(); // clear the current elements in select box
                       $('#model_id').append($('<option></option>').attr('value', '').text('Model'));
                       $('#model_id').selectpicker("refresh");
                    }
                });
        });
        $('#model_id').change(function () {
            $.post("<?php echo site_url('user_cars/ajax/get_brand_model_variant'); ?>", {
                    brand_id: $('#brand_id').val(),
                    model_id: $('#model_id').val(),
                    _mm_csrf: $('#_mm_csrf').val()
                },
                function (data) {
                    var response = JSON.parse(data);
                    if (response.length > 0) {
                       $('#variant_id').empty(); // clear the current elements in select box
                       $('#variant_id').append($('<option></option>').attr('value', '').text('Variant'));
		                for (row in response) {
		                    $('#variant_id').append($('<option></option>').attr('value', response[row].brand_model_variant_id).text(response[row].variant_name));
		                }
		                $('#variant_id').selectpicker("refresh");
                    }
                    else {
                       $('#variant_id').empty(); // clear the current elements in select box
                       $('#variant_id').append($('<option></option>').attr('value', '').text('Variant'));
                       $('#variant_id').selectpicker("refresh");
                    }
                });
        });
    });
</script>
<link href="<?php echo base_url(); ?>assets/mp_backend/css/main.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/lib/summernote/summernote.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/separate/pages/editor.min.css">
<form method="post" id="products_form" class="form" enctype="multipart/form-data">
    <input type="hidden" id="_mm_csrf" name="_mm_csrf" value="<?= $this->security->get_csrf_hash(); ?>">
	<header class="page-content-header">
			<div class="container-fluid">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3><?php echo $breadcrumb; ?></h3>
						</div>
						<div class="tbl-cell pull-right">
							<a class="btn btn-sm btn-primary" href="<?php echo site_url('products/product_mapping/form'); ?>">
								<i class="fa fa-plus"></i> <?php _trans('new'); ?>
							</a>
						</div>
					</div>
				</div>
			</div>
	</header>
	
    <div id="content">
        <div class="row">
			<div class="col-xs-12 top-15">
				<a class="anchor anchor-back" href="<?php echo site_url('products/product_mapping'); ?>"><i class="fa fa-long-arrow-left"></i><span>Back to List</span></a>
			</div>
            <div class="col-xs-12 col-md-12 col-md-offset-3">
				<?php $this->layout->load_view('layout/alerts'); ?>
				<div class="container-wide">
                	<input class="hidden" name="is_update" type="hidden"
                    <?php if ($this->mdl_product_mapping->form_value('is_update')) {
    echo 'value="1"';
} else {
    echo 'value="0"';
} ?>>
					<div class="box">
						<div class="box_body">
							<div class="row">
            				<div class="col-xs-12 col-md-12">
								<div class="form_group">
									<label class="form_label"><?php _trans('product_name'); ?> *</label>
									<div class="form_controls">
										<select name="product_id" id="product_id" class="form-control simple-select">
			                                <option value=""><?php _trans('product'); ?></option>
			                                <?php foreach ($products as $product) {
    ?>
			                                    <option value="<?php echo $product->product_id; ?>"
			                                        <?php check_select($this->mdl_product_mapping->form_value('product_id'), $product->product_id); ?>
			                                    ><?php echo $product->product_name; ?></option>
			                                <?php
} ?>
			                            </select>
									</div>
								</div>
							</div>
							
								
							</div>
							
							<div class="row">
            				<div class="col-xs-6 col-md-6">
								<div class="form_group">
								<label class="form_label"><?php _trans('brand'); ?> *</label>
								<div class="form_controls">
									<select name="brand_id" id="brand_id" class="bootstrap-select bootstrap-select-arrow g-input" data-live-search="true" style="width: 100%;">
										<option value="">Select Brand Name</option>
										<?php if ($brand_list):
                                        $brand_id = $this->mdl_product_mapping->form_value('brand_id', true);
                                        foreach ($brand_list as $key => $names):
                                        ?>
										<option value="<?php echo $names->brand_id; ?>" <?php if ($names->brand_id == $brand_id) {
                                            echo 'selected';
                                        }?>> <?php echo $names->brand_name; ?></option>
										<?php endforeach;
                                        endif;
                                        ?>
									</select>
								</div>
							</div>
							</div>	
							<div class="col-xs-6 col-md-6">
							<div class="form_group">
								<label class="form_label"><?php _trans('model'); ?> *</label>
								<div class="form_controls">
									<select name="model_id" id="model_id" class="bootstrap-select bootstrap-select-arrow g-input" data-live-search="true">
										<option value="">Select Model</option>
										<?php if ($brand_models_list):
                                        $model_id = $this->mdl_product_mapping->form_value('model_id', true);
                                        foreach ($brand_models_list as $key => $names):
                                        ?>
										<option value="<?php echo $names->model_id; ?>" <?php if ($names->model_id == $model_id) {
                                            echo 'selected';
                                        }?>> <?php echo $names->model_name; ?></option>
										<?php endforeach;
                                        endif;
                                        ?>
									</select>
								</div>
							</div>
							</div>
							</div>
				
							<div class="row">
            				<div class="col-xs-6 col-md-6">
							<div class="form_group">
								<label class="form_label"><?php _trans('variant'); ?></label>
								<div class="form_controls">
									<select name="variant_id" id="variant_id" class="bootstrap-select bootstrap-select-arrow g-input" data-live-search="true">
										<option value="">Select Variant</option>
										<?php if ($variants_list):
                                        $variant_id = $this->mdl_product_mapping->form_value('variant_id', true);
                                        foreach ($variants_list as $key => $names):
                                        ?>
										<option value="<?php echo $names->brand_model_variant_id; ?>" <?php if ($names->brand_model_variant_id == $variant_id) {
                                            echo 'selected';
                                        }?>> <?php echo $names->variant_name; ?></option>
										<?php endforeach;
                                        endif;
                                        ?>
									</select>
								</div>
							</div>
							</div>
							<div class="col-xs-6 col-md-6">
							<div class="form_group">
								<label class="form_label"><?php _trans('fuel_type'); ?> *</label>
								<div class="form_controls">
									<select name="fuel_type" id="fuel_type" class="bootstrap-select bootstrap-select-arrow g-input" data-live-search="true">
										<option value="">Select Fuel Type</option>
										<?php 
                                        $fuel_type = $this->mdl_product_mapping->form_value('fuel_type', true);
                                        ?>
										<option value="P" <?php if ('P' == $fuel_type) {
                                            echo 'selected';
                                        }?>>Petrol</option>
										<option value="D" <?php if ('D' == $fuel_type) {
                                            echo 'selected';
                                        }?>>Diesel</option>
										<option value="G" <?php if ('G' == $fuel_type) {
                                            echo 'selected';
                                        }?>>Gas</option>
									</select>
								</div>
							</div>
							</div>
							</div>
							
							<div class="row">
            				<div class="col-xs-6 col-md-6">
								<div class="form_group">
									<label class="form_label"> <?php  _trans('purchase_price'); ?></label>
									<div class="form_controls">
										<input type="text" name="cost_price" id="cost_price" class="form-control"
                                       value="<?php echo format_amount($this->mdl_product_mapping->form_value('cost_price')); ?>">
									</div>
								</div>
							</div>
							<div class="col-xs-6 col-md-6">
								<div class="form_group">
									<label class="form_label"> <?php  _trans('sale_price'); ?></label>
									<div class="form_controls">
										<input type="text" name="sale_price" id="sale_price" class="form-control"
                                       value="<?php echo format_amount($this->mdl_product_mapping->form_value('sale_price')); ?>">
									</div>
								</div>
							</div>
							</div>
								
							<div class="row">
							<?php /* * / ?>
                                <div class="col-xs-6 col-md-6">
                                    <div class="form_group">
                                            <label class="form_label"> <?php  _trans('cgst'); ?></label>
                                            <div class="form_controls">
                                            <input type="text" name="cgst_amount" id="cgst_amount" class="tax_amount form-control"
                                           value="<?php echo $this->mdl_product_mapping->form_value('cgst_amount', true); ?>" readonly>
                                           <input type="text" name="cgst_percentage" id="cgst_percentage" class="tax_percentage form-control"
                                           value="<?php echo $this->mdl_product_mapping->form_value('cgst_percentage', true); ?>">
                                            </div>
                                    </div>
                            </div>
                            <div class="col-xs-6 col-md-6">
                                <div class="form_group">
                                            <label class="form_label">  <?php  _trans('sgst'); ?></label>
                                            <div class="form_controls">
                                                <input type="text" name="sgst_amount" id="sgst_amount" class="tax_amount form-control"
                                           value="<?php echo $this->mdl_product_mapping->form_value('sgst_amount', true); ?>" readonly>
                                                <input type="text" name="sgst_percentage" id="sgst_percentage" class="tax_percentage form-control"
                                           value="<?php echo $this->mdl_product_mapping->form_value('sgst_percentage', true); ?>">
                                            </div>
                                </div>
                            </div>
                            <?php / * */ ?>
							</div>
							
			                <div class="row">
            				<div class="col-xs-6 col-md-6">   		
			                    		<div class="form_group">
											<label class="form_label"> <?php  _trans('Tax'); ?></label>
											<div class="form_controls">
												<input type="text"  name="igst_amount" id="igst_amount" class="tax_amount form-control"
		                                   value="<?php echo $this->mdl_product_mapping->form_value('igst_amount', true); ?>" readonly>
												<input type="text" placeholder="%" name="igst_percentage" id="igst_percentage" class="tax_percentage form-control"
		                                   value="<?php echo $this->mdl_product_mapping->form_value('igst_percentage', true); ?>">
											</div>
										</div>
										<input type="hidden" name="total_amount" id="total_amount" value="<?php echo $this->mdl_product_mapping->form_value('total_amount', true); ?>">
										<label id="total_tax_amount"><?php if ($this->mdl_product_mapping->form_value('total_amount', true)) {
                                            echo 'Total Amount :  '.$this->mdl_product_mapping->form_value('total_amount', true);
                                        } ?> </label>
							</div>
							<div class="col-xs-6 col-md-6">
								<div class="form_group">
									<label class="form_label"> <?php _trans('Re-order Quantity'); ?></label>
									<div class="form_controls">
										<input type="text" name="reorder_quantity" id="reorder_quantity" class="form-control"
                                   value="<?php echo $this->mdl_product_mapping->form_value('reorder_quantity', true); ?>">
									</div>
								</div>
							</div>
							<?php /* * / ?>
                            <div class="col-xs-6 col-md-6">
                                        <div class="form_group">
                                            <label class="form_label"> <?php  _trans('cess'); ?></label>
                                            <div class="form_controls">
                                                <input type="text" name="cess_amount" id="cess_amount" class="tax_amount form-control"
                                           value="<?php echo $this->mdl_product_mapping->form_value('cess_amount', true); ?>" readonly>
                                                <input type="text" name="cess_percentage" id="cess_percentage" class="tax_percentage form-control"
                                           value="<?php echo $this->mdl_product_mapping->form_value('cess_percentage', true); ?>">
                                            </div>
                                        </div>
                            </div>
                            <?php / * */ ?>
							</div>
										<div class="form_group">
									<label class="form_label"> <?php  _trans('profit_amount'); ?></label>
									<div class="form_controls">
										<input type="text" name="diff_amount" id="diff_amount" class="form-control"
                                   value="<?php echo $this->mdl_product_mapping->form_value('diff_amount', true); ?>" readonly>
									</div>
								</div>
										<div class="form_group">
											<label class="form_label"> <?php _trans('description'); ?></label>
											<div class="form_controls">
												<textarea name="description" id="description" class="form-control"
		                                      rows="3"><?php echo $this->mdl_product_mapping->form_value('description', true); ?></textarea>
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

<script src="<?php echo base_url(); ?>assets/mp_backend/js/lib/summernote/summernote.min.js"></script>
<script>
	$(document).ready(function() {
		$('.summernote').summernote();
	});
</script>
	
<script type="text/javascript">
$(document).ready(function(){
    $("#cgst_percentage").keyup(function(){
        product_tax_calc('cgst');
    });
    $("#sgst_percentage").keyup(function(){
        product_tax_calc('sgst');
    });
    $("#igst_percentage").keyup(function(){
        product_tax_calc('igst');
    });
    $("#cess_percentage").keyup(function(){
        product_tax_calc('cess');
    });
    $("#product_price").keyup(function(){
        product_tax_calc('cgst');
        product_tax_calc('sgst');
        product_tax_calc('igst');
        product_tax_calc('cess');
        
        purchase_price_diff();
    });
    
    $("#cost_price").keyup(function(){
    	purchase_price_diff();
    });
    
    $("#sale_price").keyup(function(){
    	purchase_price_diff();
    });
    
    $('#product_price').keypress(function(key) {
    	mmAmountFormat(key,"product_price");
    });
    $('#purchase_price').keypress(function(key) {
    	mmAmountFormat(key,"purchase_price");
    });
    $('#cgst_percentage').keypress(function(key) {
    	mmAmountFormat(key,"cgst_percentage");
    });
    $('#sgst_percentage').keypress(function(key) {
    	mmAmountFormat(key,"sgst_percentage");
    });
    $('#igst_percentage').keypress(function(key) {
    	mmAmountFormat(key,"igst_percentage");
    });
    $('#cess_percentage').keypress(function(key) {
    	mmAmountFormat(key,"cess_percentage");
    });														
    
});

function mmAmountFormat(key,val){
	var self = $("#"+val);
   		self.val(self.val().replace(/[^0-9\.]/g, ''));
        if((key.which != 46 || $("#"+val).val().indexOf('.') != -1) &&(key.charCode < 48 || key.charCode > 57)) 
        {
	     	key.preventDefault();
	   	}
}
function product_tax_calc(type){
	var product_price = $("#sale_price").val()?$("#sale_price").val():0;
		var per = $("#"+type+"_percentage").val()?$("#"+type+"_percentage").val():0;
		var calc = (product_price * per) / 100;
		$("#"+type+"_amount").empty().val(calc?calc:0);
		with_tax_cal();
}

function with_tax_cal(){
	var sale_price = $("#sale_price").val()?$("#sale_price").val():0;
	var igst_amount = $("#igst_amount").val()?$("#igst_amount").val():0;
	var calc = parseFloat(igst_amount) + parseFloat(sale_price);
	$("#total_amount").empty().val(calc?+calc:0);
	$("#total_tax_amount").empty().html(calc?"Total Amount : "+calc:0);

}

function purchase_price_diff(){
		var cost_price = $("#cost_price").val()?$("#cost_price").val():0;
		var sale_price = $("#sale_price").val()?$("#sale_price").val():0;
		var calc = parseFloat(sale_price) - parseFloat(cost_price);
		$("#diff_amount").empty().val(calc?calc:0);
}
</script>
