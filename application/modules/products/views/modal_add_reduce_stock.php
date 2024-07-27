<script type="text/javascript">
$(function () {

$(".removeError").change(function() {
    var len = (this.value);
    if (this.value != "" || this.value != 0) {
        $('#' + $(this).attr('name')).parent().removeClass('has-error');
        $('#' + $(this).attr('name')).parent().removeClass('border_error');
        $('#' + $(this).attr('name')).removeClass('has-error');
        $('#' + $(this).attr('name')).removeClass('border_error');
    }
});
    // Display the create quote modal
    var product_id = "<?php echo $product_id; ?>";
    var action_type = "<?php echo $action_type; ?>";
    var page = "<?php echo $page;?>";
    // console.log(action_type);
    // $('#stock_date').datetimepicker({
    //     format: 'DD-MM-YYYY',
    //     //autoclose: true,
    // });
    $('#modal-add-reduce_stock').modal('show');
     
    $('.modal-popup-close').click(function () {
        $('.modal').remove();
        $('.modal-backdrop').remove();
        $('body').removeClass( "modal-open" );
    }); 
     
     
    $( ".check_error_label" ).change(function() {
        $('.error_msg_' + $(this).attr('name')).hide();
        $('#' + $(this).attr('name')).parent().removeClass('has-error'); 
    });

    $('#save_stock').click(function () {

        var validation = [];

        if($("#stock_date").val() == ''){
			validation.push('stock_date');
		}
		if($("#stock_type").val() == ''){
			validation.push('stock_type');
		}
        if($("#quantity").val() == ''){
			validation.push('quantity');
		}
		if($("#price").val() == ''){
			validation.push('price');
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

        $.post("<?php echo site_url('products/ajax/save_stock'); ?>", {
            product_id: product_id,
            stock_date: $('#stock_date').val(),
            stock_type: $('#stock_type').val(),
            quantity: $('#quantity').val(),
            price: $('#price').val(),
            note: $('#note').val(),
            action_type: action_type == 'add_stock' ? '1' : '2',
            _mm_csrf: $('#_mm_csrf').val()
        },
        function (data) {
            var response = JSON.parse(data);
            if(response.success === 1){
                notie.alert(1, 'Success!', 2);
                if(page == "index"){
                    window.location.href = '<?php echo site_url() . "/products";?>';
                }else{
                    window.location.href = '<?php echo site_url() . "/products/view_inventory/";?>'+product_id;
                }
            }
            else{
                for (var key in response.validation_errors) {
                    $('#' + key).parent().addClass('has-error');
                    $('.error_msg_' + key).show().empty().html(response.validation_errors[key]);
                }
            }
        });
    });
});
</script>
<div class="modal fade" id="modal-add-reduce_stock" tabindex="-1" role="dialog" aria-labelledby="addNewCarLabel">
    <div class="modal-dialog" role="document">

        <div class="modal-content" id="stock-details">
            <form name="car_fdetails" method="post" autocomplete="off">
                <input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" autocomplete="off" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                
                <div class="modal-header">
                    <button type="button" class="modal-close modal-popup-close">
                        <i class="font-icon-close-2"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form">
                        <div class="row text-center">
                            <div class="col-xs-12">
                                <h3 class="modal__h3">
                                    <?php if($action_type == 'add_stock'){ ?>
                                        <?php _trans('lable214'); ?> 
                                    <?php }else{ ?>
                                        <?php _trans('lable215'); ?> 
                                    <?php } ?>
                                </h3>
                            </div>
                        </div>

                        <div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group" style="width: 100%">
                                        <label class="form-label section-header-text"><?php _trans('lable652'); ?>*</label>
                                        <input type="text" class="form-control removeError datepicker" id="stock_date" name="stock_date" value="" placeholder="Select stock date" autocomplete="off" />
                                        <label class="pop_textbox_error_msg error_msg_stock_date" style="display: none"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group" style="width: 100%">
                                        <label class="form-label section-header-text"><?php _trans('lable654'); ?>*</label>
                                        <select class="bootstrap-select removeError bootstrap-select-arrow check_error_label" data-live-search="true" name="stock_type" id="stock_type" style="width: 100%" autocomplete="off">
                                            <option value=''><?php _trans('lable423'); ?></option>
                                            <?php if($action_type == 'add_stock'){ ?>
                                            <option value="3"><?php _trans('lable655'); ?></option>
                                            <option value="4"><?php _trans('lable656'); ?></option>
                                            <?php }else{ ?>
                                            <option value="5"><?php _trans('lable657'); ?></option>
                                            <?php } ?>
                                        </select>
                                        <label class="pop_textbox_error_msg error_msg_stock_type" style="display: none"></label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group" style="width: 100%">
                                        <label class="form-label section-header-text"><?php _trans('lable643'); ?> *</label>
                                        <input type="text" class="form-control check_error_label" name="quantity" id="quantity" placeholder="Enter quantity" value="" autocomplete="off">
                                        <label class="pop_textbox_error_msg error_msg_quantity" style="display: none"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group" style="width: 100%">
                                        <label class="form-label section-header-text"><?php _trans('lable658'); ?> *</label>
                                        <input type="text" class="form-control check_error_label" name="price" id="price" placeholder="Enter price per quantity" value="" autocomplete="off">
                                        <label class="pop_textbox_error_msg error_msg_price" style="display: none"></label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group" style="width: 100%">
                                        <label class="form-label section-header-text"><?php _trans('lable477'); ?></label>
                                        <textarea type="text" class="form-control check_error_label" name="note" id="note" placeholder="Note..." value="" autocomplete="off"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-rounded btn-primary"  name="save_stock" id="save_stock">
                        <?php if($action_type == 'add_stock'){ ?>
                        <?php _trans('lable214'); ?>
                        <?php }else{ ?>
                        <?php _trans('lable215'); ?>
                        <?php } ?>
                    </button>
                    <button type="button" class="btn btn-rounded btn-default modal-popup-close">
                    <?php _trans('lable58'); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>