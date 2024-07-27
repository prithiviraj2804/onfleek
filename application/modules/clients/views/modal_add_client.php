<input type="hidden" name="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>"autocomplete="off">
<script type="text/javascript">

    $("#client_contact_no").on("keypress keyup blur",function (event) {    
           $(this).val($(this).val().replace(/[^\d].+/, ""));
            if ((event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
    });

    var phonenumberexist = '';

    $(document).on('change', '#refered_by_types', function() {
		var refered_by_type = $('#refered_by_types').val();
		if (refered_by_type == '1' || refered_by_type == '2') {
			if (refered_by_type == '2') {
				var site_url = "<?php echo site_url('mech_employee/ajax/get_employee_list'); ?>";
			} else if (refered_by_type == '1') {
				var site_url = "<?php echo site_url('clients/ajax/get_client_list'); ?>";
			}
			$('#gif').show();
			$.post(site_url, {
					refered_by_type: $('#refered_by_types').val(),
					_mm_csrf: $('input[name="_mm_csrf"]').val(),
				},
				function(data) {
					var response = JSON.parse(data);
					carResponse = response;
					// console.log(response);
					var rid = '';
					var name = '';
					var phone = '';
					$('#refered_by_ids').empty(); // clear the current elements in select box
					if (refered_by_type == '2') {
						$('#gif').hide();
						$('#refered_by_ids').append($('<option></option>').attr('value', '').text('Select Employee'));
					} else if (refered_by_type == '1') {
						$('#gif').hide();
						$('#refered_by_ids').append($('<option></option>').attr('value', '').text('Select Customer'));
					}
					if (response.length > 0) {
						$('#gif').hide();
						for (row in response) {
							if (refered_by_type == '2') {
								rid = response[row].employee_id;
								name = response[row].employee_name;
								phone = response[row].mobile_no;
							} else if (refered_by_type == '1') {
								$('#gif').hide();
								rid = response[row].client_id;
								name = response[row].client_name;
								phone = response[row].client_contact_no;
							}
							$('#refered_by_ids').append($('<option></option>').attr('value', rid).text(name + ' ' + phone));
						}
						$('#refered_by_ids').selectpicker("refresh");
					} else {
						$('#gif').hide();
						$('#refered_by_ids').selectpicker("refresh");
					}
				});
		} else {
			$('#gif').hide();
			console.log('refered_by_type else');
		}
	});

    function checkphonenoexist()
    {
	 $.post('<?php echo site_url('clients/ajax/phonenoexist'); ?>', {
		client_contact_no : $("#client_contact_no").val(),
        branch_id: $("#popbranch_id").val(),
		_mm_csrf: $('input[name="_mm_csrf"]').val(),
	 },
	 function (data) 
	 {	
		response = JSON.parse(data);
            if(response.success == 1)
			{
				phonenumberexist = response.success;
				$("#showErrorMsg").empty().append('Mobile Number Already Exist');
				return false;
			}
			else
			{
				phonenumberexist = response.success;
				$("#showErrorMsg").empty().append('');
            }
        });
    }
    
    $(function () {
        // Display the create quote modal
        $('#addNewCar').modal('show');
        
        $(".bootstrap-select").selectpicker("refresh");
        var customer_id = "<?php echo $customer_id; ?>";
        var address_id = "<?php echo $address_id; ?>";
        
        $('#add_client_details').click(function(){
           
        $('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');

		var validation = [];

		if($("#popbranch_id").val() == ''){
			validation.push('popbranch_id');
		}
		if($("#client_name").val() == ''){
			validation.push('client_name');
        }
        if($("#client_contact_no").val() == ''){
			validation.push('client_contact_no');
		}else{
            if(phonenumberexist == 1){
				$("#showErrorMsg").empty().append('Mobile Number Already Exist');
				return false;
				}else{
				$("#showErrorMsg").empty().append('');
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
		
        $.post("<?php echo site_url('clients/ajax/create'); ?>", {
                client_name: $('#client_name').val(),
                client_contact_no: $("#client_contact_no").val(),
                client_email_id: $("#client_email_id").val(),
                branch_id: $("#popbranch_id").val(),
                refered_by_type : $('#refered_by_types').val(),
			    refered_by_id : $('#refered_by_ids').val(),
                action_from: 'C',
                _mm_csrf: $('input[name="_mm_csrf"]').val()
            },
            function (data) {
                var response = JSON.parse(data);
                if(response.success == 1){
                    $('#gif').hide();
                    notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
                    $('#customer_id').empty(); // clear the current elements in select box
                    $('#customer_id').append($('<option></option>').attr('value', '').text('select customer'));
		            for (row in response.customer_list) {
                        $('#customer_id').append($('<option></option>').attr('value', response.customer_list[row].client_id).text((response.customer_list[row].client_name?response.customer_list[row].client_name:"")+' '+(response.customer_list[row].client_contact_no?"("+response.customer_list[row].client_contact_no+")":"")));
		            }
                    $('#customer_id').selectpicker("refresh");
		            $('#customer_id').selectpicker('val',response.customer_id);
                    if(response.customer_id != '' || response.customer_id != '0' ){
                        $('.addcarpopuplink').show();
                        $('.add_car').attr('data-customer-id', response.customer_id);
                        $('.add_address').attr('data-customer-id', response.customer_id);
                    }
                    $('#user_car_list_id').empty();
                    $('#user_car_list_id').selectpicker("refresh");
                    $('#user_address_id').empty();
                    $('#user_address_id').selectpicker("refresh");
                    $('.modal').remove();
                    $('.modal-backdrop').remove();
                    $('body').removeClass( "modal-open" );
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
         
        $( ".check_error_label" ).change(function() {
  			$('.error_msg_' + $(this).attr('name')).hide();
			$('#' + $(this).attr('name')).parent().removeClass('has-error'); 
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
						<h3 class="modal__h3"><?php _trans('lable48'); ?></h3>
					</div>
					<button type="button" class="modal-close modal-popup-close">
						<i class="font-icon-close-2"></i>
					</button>
				</div>
				<div class="modal-body">
					<div class="form" style="padding: 0px !important;">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"> 
								<div class="form_group">
									<label class="form_label label-width"> <?php _trans('lable95'); ?>*</label>
									<div class="form_controls input-width">
										<select id="popbranch_id" name="popbranch_id" class="bootstrap-select bootstrap-select-arrow g-input form-control removeError" data-live-search="true" autocomplete="off">
											<?php foreach ($branch_list as $branchList) {?>
											<option value="<?php echo $branchList->w_branch_id; ?>"> <?php echo $branchList->display_board_name; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>	
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"> 
								<div class="form_group">
									<label class="form_label label-width"> <?php _trans('lable50'); ?>*</label>
									<div class="form_controls input-width">
										<input type="text" name="client_name" id="client_name" class="form-control removeError" value=""<?php echo $this->mdl_clients->form_value('client_id', true); ?> autocomplete="off">
									</div>
								</div>
							</div>
						</div>	
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"> 
								<div class="form_group">
									<label class="form_label label-width"> <?php _trans('lable42'); ?>*</label>
									<div class="form_controls input-width">
										<input type="text" name="client_contact_no" id="client_contact_no" class="form-control" onkeyup="checkphonenoexist();" value="<?php echo $this->mdl_clients->form_value('client_contact_no', true); ?>" autocomplete="off">
									</div>
									<div id="showErrorMsg" class="error"></div>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"> 	
								<div class="form_group">
									<label class="form_label label-width"> <?php _trans('lable41'); ?></label>
									<div class="form_controls input-width">
										<input type="text" name="client_email_id" id="client_email_id" class="form-control" value="" autocomplete="off">
									</div>
								</div>
							</div>
						</div>	
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"> 	
								<div class="form_group">
									<label class="form_label label-width"> <?php _trans('lable52'); ?></label>
									<div class="form_controls input-width">
										<select name="refered_by_types" id="refered_by_types" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
											<option value=""><?php _trans('lable53'); ?></option>
											<?php foreach ($reference_type as $rtype) {
											if ($this->mdl_clients->form_value('refered_by_type', true) == $rtype->refer_type_id) {
												$selected = 'selected="selected"';
											} else {
												$selected = '';
											} ?>
											<option value="<?php echo $rtype->refer_type_id; ?>" <?php echo $selected; ?>><?php echo $rtype->refer_name; ?></option>
											<?php } ?>
										</select>                                
									</div>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12"> 		
								<div class="form_group">
									<label class="form_label label-width"> <?php _trans('lable54'); ?></label>
									<div class="form_controls input-width">
										<select name="refered_by_ids" id="refered_by_ids" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
											<option value=""><?php _trans('lable55'); ?></option>
											<?php foreach ($refered_dtls as $refered) {
											if ($this->mdl_clients->form_value('refered_by_type', true) == 2) {
												$emp_id = $refered->employee_id;
												$name = $refered->employee_name.' - '.$refered->mobile_no;
											} elseif ($this->mdl_clients->form_value('refered_by_type', true) == 1) {
												$emp_id = $refered->client_id;
												$name = $refered->client_name.' - '.$refered->client_contact_no;
											}
											if ($this->mdl_clients->form_value('refered_by_id', true) == $emp_id) {
												$selected = 'selected="selected"';
											} else {
												$selected = '';
											} ?>
											<option value="<?php echo $emp_id; ?>" <?php echo $selected; ?>><?php echo $name; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer text-center">
					<button type="button" class="btn btn-rounded btn-primary"  name="add_client_details" id="add_client_details">
                    <?php _trans('lable70'); ?>
					</button>
					<button type="button" class="btn btn-rounded btn-default modal-popup-close">
                    <?php _trans('lable171'); ?>
					</button>
				</div>
			</form>
		</div>
	</div>
</div>