<input type="hidden" name="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>"autocomplete="off">
<script type="text/javascript">
    
    $(function () {
        // Display the create quote modal
        $('#addNewCar').modal('show');
        
        $(".bootstrap-select").selectpicker("refresh");
        var purchase_order_id = "<?php echo $purchase_order_id; ?>";
        
        $('#convert_to_purchase').click(function(){
       
            $('#gif').show();
		
            $.post("<?php echo site_url('mech_purchase_order/ajax/convert_to_purchase'); ?>", {
                purchase_order_id: purchase_order_id,
                _mm_csrf: $('input[name="_mm_csrf"]').val()
            },
            function (data) {
                var response = JSON.parse(data);
                if(response.success == 1){
                    $('#gif').hide();
                    notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
                    $('.modal').remove();
                    $('.modal-backdrop').remove();
                    $('body').removeClass( "modal-open" );
                    setTimeout(function() {
						window.location = "<?php echo site_url('mech_purchase/create/'); ?>"+response.purchase_id;
					}, 1000);
                } else {
                    $('.has-error').removeClass('has-error');
                    for (var key in response.validation_errors) {
                        // console.log(key);
                        $('#' + key).parent().addClass('has-error');
                        $('.error_msg_' + key).show().empty().html(response.validation_errors[key]);
                    }
                }
            });
        });
        
        $('.modal-popup-close').click(function () {
            $('.modal').remove();
            $('.modal-backdrop').remove();
            $('body').removeClass( "modal-open" );
        }); 
        
    });
</script>
<div class="modal fade" id="addNewCar" tabindex="-1" role="dialog" aria-labelledby="addNewCarLabel" >
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="add_car_fdetail">
			<form name="car_fdetails" method="post" class="car_fdetails">
				<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
				<div class="modal-header">
					<div class="col-xs-12 text-center">
						<h3 class="modal__h3"><?php echo ('Purchase Order'); ?></h3>
					</div>
					<button type="button" class="modal-close modal-popup-close">
						<i class="font-icon-close-2"></i>
					</button>
				</div>
				<div class="modal-body">
					<div class="form">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
						<div class="row">
                                <p>Are you sure?  you want to convert this purchase order to purchase.</p>
						</div>
					</div>
				</div>
				<div class="modal-footer text-center">
					<button type="button" class="btn btn-rounded btn-default modal-popup-close">
                    <?php echo (' No '); ?>
					</button>
                    <button type="button" class="btn btn-rounded btn-primary"  name="convert_to_purchase" id="convert_to_purchase">
                    <?php echo (' Yes '); ?>
					</button>
				</div>
			</form>
		</div>
	</div>
</div>