<script type="text/javascript">
$(function(){

    $("#btn-cancel").click(function(){
        window.location.href = "<?php echo site_url('packages/service_packages_index'); ?>";
    });
	
	$('.select2').select2();
	
	$('#brand_id').change(function () {
		$.post("<?php echo site_url('user_cars/ajax/get_brand_models'); ?>", {
			brand_id: $('#brand_id').val(),
			_mm_csrf: $('#_mm_csrf').val()
		},function (data) {
			var response = JSON.parse(data);
			$('#variant_id').empty();
			$('#variant_id').append($('<option></option>').attr('value', '').text('Variant'));
			$('#variant_id').selectpicker("refresh");
			if(response.length > 0) {
				$('#model_id').empty(); // clear the current elements in select box
				$('#model_id').append($('<option></option>').attr('value', '').text('Model'));
		       	for (row in response) {
		       		$('#model_id').append($('<option></option>').attr('value', response[row].model_id).text(response[row].model_name));
                   }
                   $('#model_id').selectpicker("refresh");
		    	fillProductList();
         	}else{
             	console.log("No Data Found");
           	}
		});
	});

	$('#model_id').change(function () {
		$.post("<?php echo site_url('user_cars/ajax/get_brand_model_variant'); ?>", {
			brand_id: $('#brand_id').val(),
			model_id: $('#model_id').val(),
			_mm_csrf: $('#_mm_csrf').val()
		},function (data) {
        	var response = JSON.parse(data);
           	if (response.length > 0) {
          		$('#variant_id').empty(); // clear the current elements in select box
            	$('#variant_id').append($('<option></option>').attr('value', '').text('Variant'));
	        	for (row in response) {
	           		$('#variant_id').append($('<option></option>').attr('value', response[row].brand_model_variant_id).text(response[row].variant_name));
	           	}
	       		$('#variant_id').selectpicker("refresh");
	         	fillProductList();
         	}else {
             	console.log("No data found");
            }
		});
	});
    
    $('#service_category_id').change(function () {

        if($("#model_type").val() == ''){
            notie.alert(3, '<?php _trans('toaster6'); ?>', 2);
            $("#service_category_id").val(0);
            $('.bootstrap-select').selectpicker("refresh");
            return false;
        }

        $.post("<?php echo site_url('mechanic_service_item_price_list/ajax/getServiceList'); ?>", {
            service_category_id: $('#service_category_id').val(),
            model_type_id: $('#model_type').val(),
            _mm_csrf: $('#_mm_csrf').val()
        },function (data) {
            var response = JSON.parse(data);
            if (response) {
                $('#service_item_id').empty(); // clear the current elements in select box
                $('#service_item_id').append($('<option></option>').attr('value', '').text('Item'));
                for (row in response) {
                    $('#service_item_id').append($('<option></option>').attr('value', response[row].msim_id).attr('data-s_id', response[row].s_id).text(response[row].service_item_name));
                }
                $('#service_item_id').selectpicker("refresh");
            }else{
                console.log("No data found");
            }
        });
    });

    $('#service_item_id').change(function () {

        if($("#model_type").val() == ''){
            notie.alert(3, '<?php _trans('toaster6'); ?>', 2);
            $("#service_item_id").val(0);
            $('.bootstrap-select').selectpicker("refresh");
            return false;
        }

        $.post("<?php echo site_url('mechanic_service_item_price_list/ajax/getServiceDetails'); ?>", {
            serviceattrid: $("#service_item_id option:selected").attr('data-s_id'),
            service_id: $("#service_item_id").val(),
            model_type_id: $('#model_type').val(),
            _mm_csrf: $('#_mm_csrf').val()
        },function (data) {
            var response = JSON.parse(data);
            // console.log(response);
            if (response.success == 1) {
                if(response.services.estimated_cost){
                    $("#service_product_total_price").val(response.services.estimated_cost);
                    $('#service_product_total_price').parent().removeClass('has-error');
                    $('#service_product_total_price').removeClass('border_error');

                }
            }
        });
    });

});

function fillProductList(){
	$.post("<?php echo site_url('products/ajax/get_service_item_list'); ?>", {
        brand_id: $('#brand_id').val(),
        model_id: $('#model_id').val(),
        variant_id: $('#variant_id').val(),
        apply_for_all_bmv: $("#apply_for_all_bmv").val(),
        _mm_csrf: $('#_mm_csrf').val()
    },function (data) {
        var response = JSON.parse(data);
        if (response.success == '1') {
        	var response = (response.products);
           $('#product_id').empty(); // clear the current elements in select box
           $('#product_id').append($('<option></option>').attr('value', '').text('Select Service Item'));
            for (row in response) {
            	var tot_price = parseFloat(response[row].sale_price);
               
                $('#product_id').append($('<option></option>').attr('value', response[row].product_id).attr('data-price', tot_price).text(response[row].product_name));
            }
            $('#product_id').selectpicker("refresh");
        }
        else {
           $('#product_id').empty();
        //    $('#product_id').append($('<option></option>').attr('value', '').text('Select Service Item'));
           
        }
    });
}
</script>

<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php  _trans('lable546'); ?></h3>
				</div>
				<div class="tbl-cell pull-right">
					<a class="btn btn-sm btn-primary" href="<?php echo site_url('packages/service_packages'); ?>">
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
			<a class="anchor anchor-back" href="<?php echo site_url('packages/service_packages_index'); ?>"><i class="fa fa-long-arrow-left"></i><span> <?php _trans('lable59'); ?></span></a>
		</div>
        <div class="col-xs-12 col-md-12 col-md-offset-3">
            <?php echo $this->layout->load_view('layout/alerts'); ?>
            <div class="container-wide">
                <input class="hidden" name="is_update" type="hidden" <?php if($service_packages_details->service_packages_id){echo 'value="1"';}else{echo 'value="0"';}?>>
                <input class="hidden" id="service_package_id" name="service_package_id" type="hidden" value="<?php echo $service_packages_details->service_package_id;?>">
	            <div class="box">
		            <div class="box_body">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12 form_group">
                                <label class="form_label"><?php _trans('lable545'); ?>*</label>
                                <input type="text" name="service_package_name" id="service_package_name" class="form-control"  value="<?php echo $service_packages_details->service_package_name; ?>">
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12 form_group">
                                <label class="form_label"><?php  _trans('lable78'); ?> *</label>
                                <select name="model_type" id="model_type" class="bootstrap-select bootstrap-select-arrow check_error_label removeError form-control">
                                    <option value=""><?php  _trans('lable544'); ?></option>
                                    <?php foreach($model_type as $modelType){?>
                                    <option value="<?php echo $modelType->mvt_id; ?>" <?php if($modelType->mvt_id == $service_packages_details->model_type){echo 'selected';}?>><?php echo $modelType->vehicle_type_name; ?></option>
                                    <?php } ?>
                                </select>
				            </div>
				            <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12 form_group">
                                <label class="form_label"><?php _trans('lable239'); ?>*</label>
                                <select name="service_category_id" id="service_category_id" class="bootstrap-select bootstrap-select-arrow removeError form-control" data-live-search="true">
                                    <option value=""><?php _trans('lable252'); ?></option>
                                    <?php $service_category_id = $service_packages_details->service_category_id;
                                    if ($service_category_lists):
                                    foreach ($service_category_lists as $key => $service_category):
                                    ?>
                                    <option value="<?php echo $service_category->service_cat_id; ?>" <?php if ($service_category->service_cat_id == $service_category_id) {
                                        echo 'selected';
                                    } ?>> <?php echo $service_category->category_name; ?></option>
                                    <?php endforeach;
                                    endif;
                                    ?>
                                </select>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12 form_group">
                                <label class="form_label"><?php  _trans('lable249'); ?>  *</label>
                                <select name="service_item_id" id="service_item_id" class="bootstrap-select bootstrap-select-arrow check_error_label removeError form-control">
                                    <option value=""><?php  _trans('lable262'); ?></option>
                                    <?php foreach($service_category_item as $key => $service_item): ?>
                                    <option value="<?php echo $service_item->msim_id; ?>" <?php if($service_item->msim_id == $service_packages_details->service_item_id){echo 'selected';}?>><?php echo $service_item->service_item_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12 form_group">
                                <label class="form_label"><?php  _trans('lable543'); ?> *</label>
                                <input class="form-control datepicker removeErrorInput" id="offer_start_date" name="offer_start_date" value="<?php echo $service_packages_details->offer_start_date?date_from_mysql($service_packages_details->offer_start_date):date('d/m/Y');?>">
				            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12 form_group">
                                <label class="form_label"><?php  _trans('lable542'); ?> *</label>
                                <input class="form-control datepicker removeErrorInput" id="offer_end_date" name="offer_end_date" value="<?php echo $service_packages_details->offer_end_date?date_from_mysql($service_packages_details->offer_end_date):date('d/m/Y');?>">
				            </div>
			            </div>
			            <div class="row">
				            <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12 form_group paddingTop20px">
                                <input id="apply_for_all_bmv" name="apply_for_all_bmv" <?php if($service_packages_details->apply_for_all_bmv == 'Y'){ echo "checked"; } ?> type="checkbox" value="<?php echo $service_packages_details->apply_for_all_bmv;?>" >
                                <span><?php  _trans('lable228'); ?> </span>
				            </div>
			            </div>
                        <?php if($service_packages_details->apply_for_all_bmv == 'Y'){ 
                            $showhide = 'style="display:none"';
                        }else{
                            $showhide = 'style="display:block"';
                        }?>
                        <div class="row modelandvariants" <?php echo $showhide; ?> >
                            <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12 form_group">
                                <label class="form_label"><?php  _trans('lable229'); ?> *</label>
                                <select name="brand_id" id="brand_id" class="bootstrap-select bootstrap-select-arrow removeError check_error_label form-control">
                                    <option value=""><?php  _trans('lable229'); ?></option>
                                    <?php $brand_id = $service_packages_details->brand_id;
                                    if(!empty($car_brand_list)) : ?>
                                    <?php foreach ($car_brand_list as $brand_list){?>
                                    <option value="<?php echo $brand_list->brand_id; ?>" <?php if($brand_list->brand_id == $brand_id){echo 'selected';}?>><?php echo $brand_list->brand_name; ?></option>
                                    <?php } endif; ?>
                                </select>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12 form_group">
                                <label class="form_label"><?php  _trans('lable231'); ?></label>
                                <select name="model_id" id="model_id" class="bootstrap-select bootstrap-select-arrow check_error_label form-control">
                                    <option value=""><?php  _trans('lable231'); ?></option>
                                    <?php $model_id = $service_packages_details->model_id;
                                    if(!empty($brand_models_list)) : ?>
                                        <?php foreach ($brand_models_list as $model_list) {
                                        ?>
                                            <option value="<?php echo $model_list->model_id; ?>" <?php if ($model_list->model_id == $model_id) {
                                            echo 'selected';
                                        } ?>>
                                                <?php echo $model_list->model_name; ?>
                                            </option>
                                            <?php
                                    } endif; ?>
                                </select>
				            </div>
			            </div>
                        <div class="row modelandvariants" <?php echo $showhide; ?> >
				            <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12 form_group">
                                <label class="form_label"><?php  _trans('lable263'); ?> </label>
                                <select name="variant_id" id="variant_id" class="bootstrap-select bootstrap-select-arrow check_error_label form-control" data-live-search="true">
                                    <option value=""><?php  _trans('lable264'); ?></option>
                                    <?php if ($variants_list):
                                    $variant_id = $service_packages_details->variant_id;
                                    foreach ($variants_list as $names):
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
						<div class="form_group">
							<label class="form_label"><?php  _trans('lable268'); ?> *</label>
							<input type="text" name="service_product_total_price" id="service_product_total_price" class="form-control removeError" value="<?php echo $service_packages_details->service_product_total_price; ?>">
						</div>
						<div class="form_group">
							<label class="form_label"><?php  _trans('lable177'); ?></label>
                            <div class="summernote-theme-1">
                                <textarea name="service_package_description" id="service_package_description" class="form-control" name="name"><?php echo $service_packages_details->service_package_description; ?></textarea>
                            </div>
						</div>
						<div class="buttons text-center paddingTop40px">
							<button name="btn_submit" class="btn_submit btn btn-rounded btn-primary" value="2">
								<i class="fa fa-check"></i> <?php  _trans('lable57'); ?>
							</button>
							<button name="btn_submit" class="btn_submit btn btn-rounded btn-primary" value="1">
								<i class="fa fa-check"></i><?php  _trans('lable234'); ?> 
							</button>
							<button id="btn-cancel" name="btn_cancel" class="btn btn-rounded btn-default" value="1">
								<i class="fa fa-times"></i><?php  _trans('lable58'); ?> 
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
		
    $("#apply_for_all_bmv").click(function(){
        if($("#apply_for_all_bmv:checked").is(":checked")){
            $("#apply_for_all_bmv").val('Y');
            fillProductList();
            $(".modelandvariants").hide();
        }else{
            $("#apply_for_all_bmv").val('N');
            $('#product_id').empty();
            $('#product_id').append($('<option></option>').attr('value', '').text('Select Service Item'));
            $(".modelandvariants").show();
        }
    });

    $(".btn_submit").click(function () {

        // var product_id = $('#product_id').val();
        // if(product_id == null || product_id == 'null' || product_id == ''){
        //     product_id = '';
        // }
        var brand_id = $('#brand_id').val();
        var model_id = $('#model_id').val();
        var variant_id = $('#variant_id').val();
        var model_type = $("#model_type").val();
        var fuel_type = $('#fuel_type').val();
        var service_package_name = $('#service_package_name').val();
        var service_category_id = $('#service_category_id').val();
        var service_item_id = $('#service_item_id').val();
        var offer_start_date = $('#offer_start_date').val();
        var offer_end_date = $('#offer_end_date').val();
        var user_price = $('#service_product_total_price').val();
        var service_product_total_price = $('#service_product_total_price').val();
        
        var validation = [];

        if($("#service_package_name").val() == ''){
			validation.push('service_package_name');
		}
        if($("#service_category_id").val() == ''){
			validation.push('service_category_id');
		}
        if($("#service_item_id").val() == ''){
			validation.push('service_item_id');
		}
        if($("#model_type").val() == ''){
			validation.push('model_type');
		}
        if($("#offer_start_date").val() == ''){
			validation.push('offer_start_date');
		}
        if($("#offer_end_date").val() == ''){
			validation.push('offer_end_date');
		}
        
        // if($("#user_price").val() == ''){
		// 	validation.push('user_price');
		// }
        if($("#service_product_total_price").val() == ''){
			validation.push('service_product_total_price');
        }
        
        if($('#apply_for_all_bmv').val() == 'Y'){
            brand_id = 0;
            model_id = 0;
            variant_id = 0;
            fuel_type = 'A';
        }else{
            if(brand_id == ''){
			    validation.push('brand_id');
		    }
        }
		
		if(validation.length > 0){
			validation.forEach(function(val) {
				$('#'+val).addClass("border_error");
					$('#'+val).parent().addClass('has-error');
			});
			return false;
		}
        $('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');
		$('#gif').show();

        $.post('<?php echo site_url('packages/ajax/save_service_package'); ?>', {
            service_package_id : $("#service_package_id").val(),
            service_package_name : $("#service_package_name").val(),
            model_type : model_type,
            offer_start_date : $("#offer_start_date").val(),
            offer_end_date : $("#offer_end_date").val(),
            brand_id : brand_id,
            model_id : model_id,
            variant_id : variant_id,
            apply_for_all_bmv : $('#apply_for_all_bmv').val(),
            service_category_id : $('#service_category_id').val(),
            service_item_id : $('#service_item_id').val(),
            mech_price : $('#service_product_total_price').val(),
            user_price : $('#service_product_total_price').val(),
            // product_id : product_id,
            service_package_description : $("#service_package_description").val(),
            service_product_total_price : $('#service_product_total_price').val(),
            btn_submit : $(this).val(),
            _mm_csrf : $('#_mm_csrf').val()
        }, function (data) {
            list = JSON.parse(data);
            if(list.success=='1'){
                notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
                if(list.btn_submit == '1'){
                    setTimeout(function(){
                        window.location = "<?php echo site_url('packages/service_packages'); ?>";
                    }, 100);
                }else{
                    setTimeout(function(){
                        window.location = "<?php echo site_url('packages/service_packages_index'); ?>/";
                    }, 100);
                }
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
});
	
function calculate_total_amount(product_total=0){
    var user_price = ($("#user_price").val())?parseFloat($("#user_price").val()):0;
    var product_price = 0;
    $('#product_id option:selected').each(function(i, selected){
        product_price+=parseFloat($(selected).attr('data-price'));
    });
    var total = user_price+product_price;
    $("#service_product_total_price").val(total);
    
}
</script>