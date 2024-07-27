<style type="text/css">
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
}
#product_item_table input {
    padding-left: 0px;
    padding-right: 5px;
}
</style>
<script type="text/javascript">
    var currency_symbol = "<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;";
    var jobadvance_amt = <?php echo $invoice_detail->total_paid_amount?$invoice_detail->total_paid_amount:0.00; ?>;
    var default_currency_digit  = parseInt('<?php echo $this->session->userdata("default_currency_digit")?$this->session->userdata("default_currency_digit"):0;?>');
    var getServiceDetailsURL = '<?php echo site_url('mech_item_master/ajax/getServiceDetails'); ?>';
    var getProductDetailsURL = '<?php echo site_url('mech_item_master/ajax/get_product_details'); ?>';
    var getBranchDetailsURL = '<?php echo site_url('workshop_branch/ajax/getBranchDetail'); ?>';
    var getServicePackageDetailsURL = '<?php echo site_url('service_packages/ajax/get_package_details'); ?>';
    var taxURL = '<?php echo site_url('mech_tax/ajax/gettaxDetails');?>';

    $(function() {
        $('#btn-cancel').click(function() {
            window.location = "<?php echo site_url('mech_invoices'); ?>";
        });
    });
    
    function getModelList(){
		$('#gif').show();
		$.post("<?php echo site_url('user_cars/ajax/get_brand_models'); ?>", {
			brand_id: $('#brand_id').val(),
			_mm_csrf: $('#_mm_csrf').val()
		},function (data) {
			var response = JSON.parse(data);
			$('#variant_id').empty();
			$('#variant_id').append($('<option></option>').attr('value', '').text('Select Variant'));
			$('#variant_id').selectpicker("refresh");
			if(response.length > 0) {
				$('#gif').hide();
				$('#model_id').empty(); // clear the current elements in select box
				$('#model_id').append($('<option></option>').attr('value', '').text('Select Model'));
		       	for (row in response) {
		       		$('#model_id').append($('<option></option>').attr('value', response[row].model_id).text(response[row].model_name));
				}
				$('#model_id').selectpicker("refresh");
				getproductsByFilter();
         	}else{
				$('#gif').hide();
				$('#model_id').empty(); // clear the current elements in select box
				$('#model_id').append($('<option></option>').attr('value', '').text('Select Model'));
				$('#model_id').selectpicker("refresh");
           	}
		});
	}

	function getvariantList(){
		$('#gif').show();
		$.post("<?php echo site_url('user_cars/ajax/get_brand_model_variant'); ?>", {
			brand_id: $('#brand_id').val(),
			model_id: $('#model_id').val(),
			_mm_csrf: $('#_mm_csrf').val()
		},function (data) {
        	var response = JSON.parse(data);
           	if (response.length > 0) {
				$('#gif').hide();
          		$('#variant_id').empty(); // clear the current elements in select box
            	$('#variant_id').append($('<option></option>').attr('value', '').text('Select Variant'));
	        	for (row in response) {
	           		$('#variant_id').append($('<option></option>').attr('value', response[row].brand_model_variant_id).text(response[row].variant_name));
				}
				$('#variant_id').selectpicker("refresh");
				getproductsByFilter();
         	}else {
				$('#gif').hide();
				$('#variant_id').empty(); // clear the current elements in select box
            	$('#variant_id').append($('<option></option>').attr('value', '').text('Select variant'));
				$('#variant_id').selectpicker("refresh");
            }
		});
	}
    
    function getproductsByFilter(){

    // if($("#user_car_list_id").val() == ''){
    //     notie.alert(3, '<?php // _trans('toaster5'); ?>', 2);
    //     $("#service_category_id").val(0);
    //     $('.bootstrap-select').selectpicker("refresh");
    //     return false;
    // }
    $('#gif').show();   
    $.post("<?php echo site_url('mech_item_master/ajax/getProductItemList'); ?>", {
        product_category_id: $('#product_category_id').val()?$('#product_category_id').val():'',
        product_brand_id: $("#product_brand_id").val()?$("#product_brand_id").val():'',
        user_car_list_id: $('#user_car_list_id').val()?$('#user_car_list_id').val():'',
        _mm_csrf: $('#_mm_csrf').val()
    },function (data) {
        var response = JSON.parse(data);
        if (response) {
            $('#gif').hide();
            $('#services_item_product_id').empty(); // clear the current elements in select box
            $('#services_item_product_id').append($('<option></option>').attr('value', '').text('Item'));
            for (row in response) {
                $('#services_item_product_id').append($('<option></option>').attr('value', response[row].product_id).text(response[row].product_name));
            }
            $('#services_item_product_id').selectpicker("refresh");
        }else{
            $('#gif').hide();
            $('#services_item_product_id').empty(); // clear the current elements in select box
            $('#services_item_product_id').append($('<option></option>').attr('value', '').text('Item'));
            $('#services_item_product_id').selectpicker("refresh");
        }
    });
}
</script>
<script src="<?php echo base_url(); ?>assets/mp_backend/js/invoice.js"></script>
<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell" id="total_user_quote">
                    <h3><?php _trans('lable376'); ?><?php if ($invoice_detail->invoice_no) { echo ' - '.$invoice_detail->invoice_no; } ?></h3>
                </div>
                <div class="tbl-cell tbl-cell-action">
					<a href="<?php echo site_url('mech_invoices/create'); ?>"  class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> <?php _trans('lable40'); ?></a>
				</div>
            </div>
        </div>
    </div>
</header>
<div class="row">
    <div id="gif" class="gifload">
        <div class="gifcenter">
            <center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
        </div>
    </div>
	<div class="col-xs-12 top-15">
		<a class="anchor anchor-back" href="<?php echo site_url('mech_invoices/index'); ?>"><i class="fa fa-long-arrow-left"></i><span> <?php _trans('lable59'); ?></span></a>
	</div>
</div>
<div class="container-fluid">
    <section class="card">
        <div class="card-block invoice">
            <div class="row invoice-company_details">
                <div class="col-lg-12">
                    <div class="company_logo col-lg-4">
                        <?php $company_details = $this->mdl_workshop_branch->get_company_branch_details();
                        if ($company_details->workshop_logo) {
                            ?>
                        <img src="<?php echo base_url(); ?>uploads/workshop_logo/<?php echo $company_details->workshop_logo; ?>" width="150" height="150" alt="<?php echo $company_details->workshop_name; ?>">
                        <?php
                        } ?>
                    </div>
                    <div class="col-lg-8 company_address">
                        <div class="text-lg-right text_align_right">
                            <h4><?php echo $company_details->workshop_name; ?></h4>
                            <span>
                            <?php if ($company_details->branch_street) {
                                echo $company_details->branch_street;
                            }
                            if ($company_details->area_name) {
                                echo ', '.$company_details->area_name;
                            }
                            if ($company_details->state_name) {
                                echo ', '.$company_details->state_name;
                            }
                            if ($company_details->branch_pincode) {
                                echo ' - '.$company_details->branch_pincode;
                            }
                            if ($company_details->branch_country) {
                                echo ' - '.$company_details->name;
                            }
                            ?>
                            </span>
                            <?php if ($company_details->branch_contact_no) {
                                        echo '<span>'.$company_details->branch_contact_no.'</span>';
                            } ?>
                            <?php if ($company_details->branch_email_id) {
                                        echo '<span>'.$company_details->branch_email_id.'</span>';
                            } ?>
                            <?php if ($company_details->branch_gstin) {
                                        echo '<span>'.$company_details->branch_gstin.'</span>';
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" autocomplete="off"/>
                <input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo $invoice_id; ?>" autocomplete="off"/>
                <input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $invoice_detail->invoice_no; ?>" autocomplete="off"/>
                <input type="hidden" name="quote_id" id="quote_id" value="<?php echo $invoice_detail->quote_id; ?>" autocomplete="off"/>
                <input type="hidden" name="refered_by_type" id="refered_by_type" value="<?php echo $invoice_detail->refered_by_type; ?>" />
				<input type="hidden" name="refered_by_id" id="refered_by_id" value="<?php echo $invoice_detail->refered_by_id; ?>" />
                <input type="hidden" name="term_val" id="term_val" value="<?php echo $invoice_detail->invoice_terms_condition; ?>" autocomplete="off"/>

                <?php if($invoice_detail->invoice_status == "D" || $invoice_detail->invoice_status == ""){ ?>	
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable20'); ?></label>
                    <div class="form_controls">
                        <select name="jobsheet_no" id="jobsheet_no" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                            <option value=""><?php _trans('lable377'); ?></option>
                            <?php foreach ($work_order_no_list as $workOrdList) {?>
                            <option value="<?php echo $workOrdList->jobsheet_no; ?>" <?php if($invoice_detail->jobsheet_no == $workOrdList->jobsheet_no){ echo "selected"; }?> ><?php echo $workOrdList->jobsheet_no; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <?php } else { ?>
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable20'); ?>: </label>
                    <?php echo $invoice_detail->jobsheet_no?$invoice_detail->jobsheet_no:"";?>
                </div>
                <?php } ?>
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable51'); ?>*</label>
                    <div class="form_controls">
                        <select id="branch_id" name="branch_id" class="invoice_terms bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                            <?php if(count($branch_list) > 1){ ?> 
                            <option value=""><?php _trans('lable51'); ?></option>
                            <?php } ?>
                            <?php foreach ($branch_list as $branchList) {?>
                            <option data-terms-condition="<?php echo $branchList->invoice_description; ?>" value="<?php echo $branchList->w_branch_id; ?>" <?php if($invoice_detail->branch_id == $branchList->w_branch_id){echo "selected";}?> > <?php echo $branchList->display_board_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable378'); ?>.*</label>
                    <div class="form_controls">
                        <select name="invoice_group_id" id="invoice_group_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                        <?php if(count($invoice_group) > 1){ ?> 
                            <option value=""><?php _trans('lable277'); ?></option>
                        <?php } ?>    
                            <?php foreach ($invoice_group as $invoice_group_list) {
                                if (!empty($invoice_detail)) {
                                    if ($invoice_detail->invoice_group_id == $invoice_group_list->invoice_group_id) {
                                        $selected = 'selected="selected"';
                                    } else {
                                        $selected = '';
                                    }
                                } else {
                                    $selected = '';
                                } ?>
                                <option value="<?php echo $invoice_group_list->invoice_group_id; ?>" <?php echo $selected; ?>><?php echo $invoice_group_list->invoice_group_name; ?></option>
                            <?php
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable36'); ?>*</label>
                    <div class="form_controls">
                        <select name="customer_id" id="customer_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                            <option value=""><?php _trans('lable379'); ?></option>
                            <?php foreach ($customer_list as $customer) { ?>
                                <option value="<?php echo $customer->client_id; ?>" <?php if($invoice_detail->customer_id == $customer->client_id) { echo "selected"; }?>><?php echo ($customer->client_name?$customer->client_name:"").' '.($customer->client_contact_no?"(".$customer->client_contact_no.")":""); ?></option>
                            <?php } ?>
                        </select>
                        <div class="col-lg-12 paddingLeft0px paddingTop5px">
                            <a class="float_left fontSize_85rem add_client_page" href="javascript:void(0)" data-toggle="modal" data-model-from="invoice" data-target="#addNewCar">
                                + <?php _trans('lable48'); ?> 
                            </a>
                        </div>
                    </div>
                </div>
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable280'); ?>*</label>
                    <div class="form_controls">
                        <select name="user_car_list_id" id="user_car_list_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                            <option value=""><?php _trans('lable281'); ?></option>
                            <?php foreach ($user_cars as $cars) {
                                $user_cars_list = $cars->brand_name.', '.$cars->model_name.''.($cars->variant_name?", ".$cars->variant_name:"").', '.$cars->car_reg_no;
                                if (!empty($invoice_detail)) {
                                    if ($invoice_detail->customer_car_id == $cars->car_list_id) {
                                        $selected = 'selected="selected"';
                                    } else {
                                        $selected = '';
                                    }
                                } else {
                                    $selected = '';
                                } ?>
                            <option value="<?php echo $cars->car_list_id; ?>" <?php echo $selected; ?>><?php echo $user_cars_list; ?></option>
                            <?php } ?>
                        </select>
                        <div class="col-lg-12 paddingLeft0px paddingTop5px">
                            <a style="display:none;" href="javascript:void(0)" data-toggle="modal" data-model-from="invoice" <?php if($invoice_detail->customer_id){echo 'data-customer-id="'.$invoice_detail->customer_id.'"';}?> data-target="#addNewCar" class="add_car fontSize_85rem float_left addcarpopuplink ">+ Add New Vechicle</a>
                        </div>
                    </div>
                </div>
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable61'); ?></label>
                    <div class="form_controls">
                        <select name="user_address_id" id="user_address_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                            <option value=""><?php _trans('lable281'); ?></option>
                            <?php foreach ($address_dtls as $address) {
                                $full_address = $address->customer_street_1.' '.($address->customer_street_2?",".$address->customer_street_2:"").' ,'.$address->area.' ,'.$address->zip_code;
                                if (!empty($invoice_detail)) {
                                    if ($invoice_detail->user_address_id == $address->user_address_id) {
                                        $selected = 'selected="selected"';
                                    } else {
                                        $selected = '';
                                    }
                                } else {
                                    $selected = '';
                                } ?>
                            <option value="<?php echo $address->user_address_id; ?>" <?php echo $selected; ?>><?php echo $full_address; ?></option>
                            <?php  } ?>
                        </select>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 paddingLeft0px paddingTop5px">
                            <a style="display:none;" href="javascript:void(0)" data-model-from="invoice" <?php if($invoice_detail->customer_id){echo 'data-customer-id="'.$invoice_detail->customer_id.'"';} ?> data-toggle="modal" data-target="#addAddress" class="add_address fontSize_85rem float_left addcarpopuplink">
                                + <?php _trans('lable45'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php if($this->session->userdata('is_shift') == 1){ ?>
                    <input type="hidden" value="<?php echo $invoice_detail->shift?$invoice_detail->shift:1;?>" id="shift" name="shift" autocomplete="off">
                <?php } else { ?>
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12" style="display:none;">
                    <label class="form_label"><?php _trans('lable152'); ?></label>
                    <div class="form_controls">
                        <select id="shift" name="shift" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                            <option value=""><?php _trans('lable152'); ?></option>	
                            <?php foreach ($shift_list as $shiftList) {?>
                            <option value="<?php echo $shiftList->shift_id; ?>" <?php if($invoice_detail->shift == $shiftList->shift_id){echo "selected";}?> > <?php echo $shiftList->shift_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <?php } ?>
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable283'); ?></label>
                    <div class="form_controls">
                        <input type="text" name="current_odometer_reading" id="current_odometer_reading" class="form-control" value="<?php if ($invoice_detail) {
                                        echo $invoice_detail->current_odometer_reading;
                                    } ?>" autocomplete="off">
                    </div>
                </div>
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable298'); ?></label>
                    <div class="form_controls">
                        <input type="text" name="next_service_km" id="next_service_km" class="form-control" value="<?php if ($invoice_detail) {
                                        echo $invoice_detail->next_service_km;
                                    } ?>" autocomplete="off">
                    </div>
                </div>
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable299'); ?></label>
                    <div class="form_controls">
                        <input type="text" name="next_service_dt" id="next_service_dt" class="form-control removeErrorInput datepicker" value="<?php echo $invoice_detail->next_service_dt?date_from_mysql($invoice_detail->next_service_dt):date_from_mysql(date('Y-m-d')); ?>" autocomplete="off">
                    </div>
                </div>
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable284'); ?></label>
                    <div class="form_controls">
                        <select class="bootstrap-select bootstrap-select-arrow form-control removeError" name="fuel_level" id="fuel_level" autocomplete="off">
                            <option value=""><?php _trans('lable286'); ?></option>
                            <?php for ($i = 0; $i < 20; $i += 0.5) {
                                $selected = '';
                                if ($invoice_detail) {
                                    if ($invoice_detail->fuel_level == $i) {
                                        $selected = 'selected="selected"';
                                    }
                                } ?>
                            <option value="<?php echo $i; ?>" <?php echo $selected; ?>> <?php echo $i; ?></option>
                            <?php  } ?>
                        </select>
                    </div>
                </div>
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable368'); ?>*</label>
                    <div class="form_controls">
                        <input type="text" name="invoice_date" id="invoice_date" class="form-control removeErrorInput datepicker" value="<?php echo $invoice_detail->invoice_date?date_from_mysql($invoice_detail->invoice_date):date_from_mysql(date('Y-m-d')); ?>" autocomplete="off">
                    </div>
                </div>
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable126'); ?></label>
                    <div class="form_controls">
                        <select name="purchase_no" id="purchase_no" class="form-control bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                            <option value=""><?php _trans('lable380'); ?></option>
                            <?php foreach ($purchase_no_list as $purnoList) {?>
                            <option value="<?php echo $purnoList->purchase_no; ?>" <?php if($invoice_detail->purchase_no == $purnoList->purchase_no){ echo "selected"; }?> ><?php echo $purnoList->purchase_no; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable883'); ?> *</label>
                    <div class="form_controls">
                        <select name="is_credit" id="is_credit" <?php if($invoice_detail->is_credit != "" && $invoice_detail->invoice_status != 'D' && $invoice_detail->invoice_status != ''){ echo 'disabled'; } ?> class="form-control bootstrap-select bootstrap-select-arrow removeError" data-live-search="true" autocomplete="off">
                            <option value=""><?php _trans('lable382'); ?></option>
                            <option value="Y" <?php if($invoice_detail->is_credit == "Y"){echo "selected";}?>><?php _trans('lable522'); ?></option>
                            <option value="N" <?php if($invoice_detail->is_credit == "N"){echo "selected";}?>><?php _trans('lable538'); ?></option>
                        </select>
                    </div>
                </div>
                <div id="paid" <?php if($invoice_detail->is_credit == "N"){ echo 'style="display:block;"';} else { echo 'style="display:none;"'; }?> >
                    <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <label class="form_label"><?php _trans('lable109'); ?>*</label>
                        <div class="form_controls">
                            <select id="payment_method_id" name="payment_method_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" <?php if($invoice_detail->is_credit == "N" && $invoice_detail->invoice_status != 'D' && $invoice_detail->invoice_status != ''){ echo 'disabled'; } ?> >
                                <?php foreach ($payment_methods as $payment_method) { ?>
                                <option value="<?php echo $payment_method->payment_method_id; ?>"
                                <?php if ($invoice_detail->payment_method_id == $payment_method->payment_method_id) { ?>selected="selected"<?php } ?>>
                                <?php echo $payment_method->payment_method_name; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12 showChequeDetailBoxs" style="display:none;">
                        <label class="form_label"><?php _trans('lable755'); ?>*</label>
                        <div class="form_controls">
                        <input type="text" name="cheque_no" id="cheque_no" <?php if($invoice_detail->is_credit == "N" && $invoice_detail->invoice_status != 'D' && $invoice_detail->invoice_status != ''){ echo 'readonly'; } ?> class="form-control car_reg_no" value="<?php echo $invoice_detail->cheque_no; ?>"autocomplete="off">    
                        </div>
                    </div> 
                    <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12 showChequeDetailBoxs" style="display:none;">
                        <label class="form_label"><?php _trans('lable756'); ?>*</label>
                        <div class="form_controls">
                        <input type="text" name="cheque_to" id="cheque_to" <?php if($invoice_detail->is_credit == "N" && $invoice_detail->invoice_status != 'D' && $invoice_detail->invoice_status != ''){ echo 'readonly'; } ?> class="form-control" value="<?php echo $invoice_detail->cheque_to; ?>"autocomplete="off">    
                        </div>
                    </div> 
                    <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12 showChequeDetailBoxs" style="display:none;">
                        <label class="form_label"><?php _trans('lable99'); ?>*</label>
                        <div class="form_controls">
                        <input type="text" name="bank_name" id="bank_name" <?php if($invoice_detail->is_credit == "N" && $invoice_detail->invoice_status != 'D' && $invoice_detail->invoice_status != ''){ echo 'readonly'; } ?> class="form-control" value="<?php echo $invoice_detail->bank_name; ?>"autocomplete="off">    
                        </div>
                    </div> 
                    <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <label class="form_label"><?php _trans('lable385'); ?></label>
                        <div class="form_controls">
                        <input type="text" name="online_payment_ref_no" id="online_payment_ref_no" <?php if($invoice_detail->is_credit == "N" && $invoice_detail->invoice_status != 'D' && $invoice_detail->invoice_status != ''){ if($invoice_detail->online_payment_ref_no){ echo 'readonly';} } ?> class="form-control" value="<?php echo $invoice_detail->online_payment_ref_no; ?>"autocomplete="off">    
                        </div>
                    </div>
                    <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <label class="form_label"><?php _trans('lable105'); ?>*</label>
                        <div class="form_controls">
                        <input type="text" name="payment_date" id="payment_date" class="form-control removeErrorInput datepicker" <?php if($invoice_detail->is_credit == "N" && $invoice_detail->invoice_status != 'D' && $invoice_detail->invoice_status != ''){ if($invoice_detail->online_payment_ref_no){ echo 'readonly';} } ?> class="form-control" value="<?php echo $invoice_detail->payment_date?date_from_mysql($invoice_detail->payment_date):date_from_mysql(date('Y-m-d')); ?>" autocomplete="off">    
                        </div>
                    </div>              
                </div>
                <div id="credit" <?php if($invoice_detail->is_credit == "Y"){ echo 'style="display:block;"';} else { echo 'style="display:none;"'; }?> >
                    
                    <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <label class="form_label"><?php _trans('lable387'); ?></label>
                        <div class="form_controls">
                            <input type="text" onchange="changeDueDatebyDay('invoice_date','in_days','invoice_date_due')" name="in_days" id="in_days" class="form-control" value="<?php echo $invoice_detail->in_days; ?>"autocomplete="off">
                        </div>
                    </div>
                    <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <label class="form_label"> <?php _trans('lable127'); ?></label>
                        <div class="form_controls">
                            <input type="text" onchange="changeCreditPeriodbyDueDate('invoice_date','in_days','invoice_date_due')" name="invoice_date_due" id="invoice_date_due" class="form-control datepicker" value="<?php echo $invoice_detail->invoice_date_due?date_from_mysql($invoice_detail->invoice_date_due):''; ?>"autocomplete="off">
                        </div>
                    </div>         
                </div>
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable1054'); ?></label>
                    <div class="form_controls">
                    <input class="form-control" style="width: 16px; height: 29px;" type="checkbox" name="tax_invoice" id="tax_invoice" autocomplete="off" <?php if($invoice_detail->tax_invoice == 'Y'){ echo "checked"; }?> value="<?php if($invoice_detail->tax_invoice == 'Y'){ echo "Y"; } else{ echo 'N'; }?>">
                    </div>
                </div>
            </div>
            <?php if($is_product == "Y"){ ?>
            <?php $this->layout->load_view('mech_invoices/partial_product_table'); ?>
            <?php } ?>
            <?php $this->layout->load_view('mech_invoices/partial_service_table'); ?>
			<?php $this->layout->load_view('mech_invoices/partial_service_package_table'); ?>
            <div class="row paddingBottom25px">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 terms-and-conditions">
                        <div class="row hide_terms">
                            <div class="form_group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <strong><?php _trans('lable388'); ?></strong><br>
                                <label name="inv_ter_cond" id="inv_ter_cond" style="text-align:left;text-align:justify;" class="control-label string required"><?php echo $invoice_detail->invoice_terms_condition;?></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form_group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label class="form_label"><?php _trans('lable177'); ?></label>
                                <div class="form_controls">
                                    <textarea class="form-control" row="5" id="description"><?php echo $invoice->description;?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form_group col-lg-12 col-md-12 col-sm-12 col-xs-12" style="display: none;">
                                <label class="form_label"><?php _trans('lable81'); ?></label>
                                <div class="form_controls">
                                    <select class="bootstrap-select bootstrap-select-arrow form-control removeError" name="bank_id" id="bank_id" autocomplete="off">
                                        <option value=""><?php echo trans('lable390'); ?></option>
                                        <?php foreach($bank_dtls as $bank){ ?>
                                        <option value="<?php echo $bank->bank_id; ?>" <?php if ($bank->bank_id == $invoice_detail->bank_id) {
                    echo 'selected="selected"';
                } ?>>
                                            <?php _htmlsc($bank->bank_name); ?>
                                        </option>
            <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-8 clearfix" style="float: right">
                        <div class="total-amount row" style="float: left;width: 100%`">
                            <div class="row">
                                <div id="referral_rewards" <?php if($invoice_detail->applied_rewards == 'Y'){ echo 'style="display:block"'; }else { echo 'style="display:none"';} ?> class="referral_rewards col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop10px">
                                    <input type="checkbox" value="<?php echo $invoice_detail->applied_rewards;?>" <?php if($invoice_detail->applied_rewards == 'Y'){ echo 'checked';}else if($applied_rewards == 'Y'){ echo 'checked'; }?> class="checkbox" name="applied_rewards" id="applied_rewards" autocomplete="off"> <?php echo trans('lable391'); ?>
                                    <input type="hidden" id="mrdlts_id" value="<?php echo $reward_detail->mrdlts_id; ?>"autocomplete="off" >
                                    <input type="hidden" id="rewards_amount" value="<?php echo $rewards_amount; ?>" autocomplete="off">
                                    <input type="hidden" id="rewards_tax" value="<?php echo $rewards_tax; ?>"autocomplete="off">
                                    <input type="hidden" id="applied_for" value="<?php echo (($reward_detail->applied_for)?$reward_detail->applied_for:" ");?>"autocomplete="off">
                                    <input type="hidden" id="inclusive_exclusive" value="<?php echo $reward_detail->inclusive_exclusive;?>"autocomplete="off">
                                    <input type="hidden" id="reward_type" value="<?php echo $reward_detail->reward_type;?>"autocomplete="off">
                                    <input type="hidden" id="reward_amount" value="<?php echo $reward_detail->reward_amount;?>"autocomplete="off">
								</div>
                            </div>
                            <?php if($is_product == "Y"){ ?>
                            <div class="row">
                                <div class="col-xl-8 col-lg-7 col-md-7 col-sm-7 clearfix">
                                    <b><?php _trans('lable356'); ?>: </b>
                                </div>
                                <div class="col-xl-4 col-lg-5 col-md-5 col-sm-5 price clearfix">
                                    <?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code'));?> &nbsp;<b class="total_product_invoice">0.00</b>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="row">
                                <div class="col-xl-8 col-lg-7 col-md-7 col-sm-7 clearfix">
                                    <b><?php _trans('lable393'); ?>: </b>
                                </div>
                                <div class="col-xl-4 col-lg-5 col-md-5 col-sm-5 price clearfix">
                                    <?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code'));?> &nbsp;<b class="total_servie_invoice">0.00</b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-8 col-lg-7 col-md-7 col-sm-7 clearfix">
                                    <b><?php _trans('label960'); ?>: </b>
                                </div>
                                <div class="col-xl-4 col-lg-5 col-md-5 col-sm-5 price clearfix">
                                    <?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code'));?> &nbsp;<b class="total_servie_package_invoice">0.00</b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-9 col-md-9 col-sm-9 clearfix">
                                    <?php _trans('lable43'); ?>: (<b class="total_earned_amount"></b>)
                                </div>
                                <div <?php if($invoice_detail->applied_rewards == 'Y'){ echo 'style="display:block"'; }else { echo 'style="display:none"';} ?> class="col-lg-3 col-md-3 col-sm-3 price padding0px clearfix float_right" id="showRewards">
                                    <input onkeyup="overall_invoice_calc()" type="text" name="earned_amount" id="earned_amount" value="<?php echo $invoice_detail->earned_amount?$invoice_detail->earned_amount:0;?>" class="form-control text-right" autocomplete="off">
                                </div>
                                <div <?php if($invoice_detail->applied_rewards != 'Y'){ echo 'style="display:block"'; }else { echo 'style="display:none"';} ?>  class="col-lg-3 col-md-3 col-sm-3 price padding0px clearfix float_right" id="hideRewards">
                                    <?php _trans('lable394'); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-9 col-md-9 col-sm-9 clearfix">
                                    <b><?php _trans('lable332'); ?></b>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 price clearfix" style="border-top:1px solid #000; margin-top: 5px">
                                    <?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<b class="grand_total">0.00</b>
                                </div>
                                <input type="hidden" id="total_due_amount_save" name="total_due_amount_save" value="<?php echo $invoice_detail->total_due_amount;?>" autocomplete="off">
                            </div>
                            <div class="row">
                                <div class="col-lg-9 col-md-9 col-sm-9 clearfix">
                                    <b><?php _trans('lable1020'); ?></b>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 price clearfix">
                                    <?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<b class="advance_amount_label"><?php echo $invoice_detail->advance_paid?$invoice_detail->advance_paid:0.00; ?></b>
                                </div>
                                <input type="hidden" id="advance_paid_amount" name="advance_paid_amount" value="<?php echo $invoice_detail->advance_paid;?>" autocomplete="off">
                            </div>
                            <div class="row">
                                <div class="col-lg-9 col-md-9 col-sm-9 clearfix">
                                    <b><?php _trans('lable1021'); ?></b>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 price clearfix">
                                    <?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<b class="total_due_amount_lable"><?php echo $invoice_detail->total_due_amount?$invoice_detail->total_due_amount:0.00; ?></b>
                                </div>
                                <input type="hidden" id="total_due_amount" name="total_due_amount" value="<?php echo $invoice_detail->total_due_amount;?>" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input id="invoice_status" type="hidden" value="<?php echo $invoice_detail->invoice_status;?>" autocomplete="off">
            <div class="row invoiceFloatbtn">
                <div class="col-lg-12 clearfix buttons text-right">
                    <?php if($invoice_detail->invoice_id){ ?>
                        <?php if($is_product == "Y"){ ?>
                        <a href="javascript:void(0)" data-toggle="modal" data-model_from="I" data-invoice_id="<?php echo $invoice_detail->invoice_id;?>" data-customer_id="<?php echo $invoice_detail->customer_id; ?>" data-vehicle_id="<?php echo $invoice_detail->customer_car_id; ?>" data-target="#addNewCar" class="add_recommended_product hideSubmitButtons btn btn-rounded btn-primary">
                            + <?php _trans("lable853"); ?>
                        </a>
                        <?php } ?>
                        <a href="javascript:void(0)" data-toggle="modal" data-model_from="I" data-invoice_id="<?php echo $invoice_detail->invoice_id;?>" data-customer_id="<?php echo $invoice_detail->customer_id; ?>" data-vehicle_id="<?php echo $invoice_detail->customer_car_id; ?>" data-target="#addNewCar" class="add_recommended_service btn btn-rounded btn-primary">
                            + <?php _trans('lable395'); ?>
                        </a>
                    <?php } ?>
                    <?php if($invoice_detail->invoice_status != 'D' && $invoice_detail->invoice_status != '') { ?>
                    <button id="btn_submit" name="btn_submit" class="btn_submit btn btn-rounded btn-primary" value="G">
                        <i class="fa fa-check"></i> <?php _trans('lable57'); ?>
                    </button>                    
                    <?php } else {  ?>
                    <button id="btn_submit" name="btn_submit" class="btn_submit btn btn-rounded btn-primary" value="G">
                        <i class="fa fa-check"></i><?php _trans('lable376'); ?></button>
                    <button id="btn_submit" name="btn_submit" class="btn_submit btn btn-rounded btn-primary" value="D">
                        <i class="fa fa-check"></i> <?php _trans('lable450'); ?></button>
                    <?php
                     } ?>
                     <?php if($invoice_detail->invoice_id){ ?>
                        <a class="btn btn-rounded btn-primary" target="_blank" href="<?php echo site_url('mech_invoices/generate_pdf/'.$invoice_detail->invoice_id); ?>">
                            <i class="fa fa-edit fa-margin"></i> <?php _trans('lable141'); ?>
                        </a>
                    <?php }?>
                    <button id="btn_cancel" name="btn_cancel" class=" btn btn-rounded btn-default" value="1">
                        <i class="fa fa-times"></i> <?php _trans('lable58'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
</div>
<script type="text/javascript">

    if($("#term_val").val()){
        $('.hide_terms').show();
    }else{
        $('.hide_terms').hide();
    }

    $(document).ready(function() {

        $(".select2").select2();

        <?php if($invoice_id){ ?>
            var payment_method_id_name = $("#payment_method_id option:selected").text();
            var trim = payment_method_id_name.trim();
            var string = trim.toLowerCase();
            if(string == "cheque"){
                $(".showChequeDetailBoxs").show();
            }else{
                $(".showChequeDetailBoxs").hide();
            }
        <?php } ?>

        $("#payment_method_id").change(function(){
            var payment_method_id_name = $("#payment_method_id option:selected").text();
            var trim = payment_method_id_name.trim();
            var string = trim.toLowerCase();
            if(string == "cheque"){
                $(".showChequeDetailBoxs").show();
            }else{
                $(".showChequeDetailBoxs").hide();
            }
        });

        $("#is_credit").change(function(){
            var is_credit = $("#is_credit").val();
            if(is_credit == "N"){
                $("#paid").show();
                $("#credit").hide();
            }else if(is_credit == "Y"){
                $("#paid").hide();
                $("#credit").show();
            }else{
                $("#paid").hide();
                $("#credit").hide();
            }
        });

        $('.invoice_terms').change(function() {
            var invoice_terms_condition = $("#branch_id").find('option:selected').attr('data-terms-condition');
                $("#inv_ter_cond").empty().append(invoice_terms_condition);
            if(invoice_terms_condition == ''){
                $('.hide_terms').hide();
            }else{
                $('.hide_terms').show();
            }   
        }); 

        $("#tax_invoice").click(function(){
            if($("#tax_invoice:checked").is(":checked")){
                $("#tax_invoice").val('Y');
            }else{
                $("#tax_invoice").val('N');
            }
        });

        if ($('#customer_id').val() != '') {
            $('.addcarpopuplink').show();
        } else {
            $('.addcarpopuplink').hide();
        }

        $("#btn_cancel").click(function() {
            window.location.href = "<?php echo site_url('mech_invoices'); ?>";
        });

        $(".btn_submit").click(function() {


            $('.has-error').removeClass('has-error');
            $('.border_error').removeClass("border_error");

            var validation = [];

            var btn_status = $(this).val();
            
            if(btn_status == 'G'){
                if($("#invoice_group_id").val() == ''){
                    validation.push('invoice_group_id');
                }
            }

            if($("#branch_id").val() == ''){
                validation.push('branch_id');
            }

            if($("#invoice_group_id").val() == ''){
                validation.push('invoice_group_id');
            }

            if($("#customer_id").val() == ''){
                validation.push('customer_id');
            }

            if($("#user_car_list_id").val() == ''){
                validation.push('user_car_list_id');
            }

            if($("#invoice_date").val() == ''){
                validation.push('invoice_date');
            }

            if($("#is_credit").val() == ''){
                validation.push('is_credit');
            }

            if($("#is_credit").val() != ''){
                if($("#is_credit").val() == "N"){
                    if($("#payment_method_id").val() == ''){
                        validation.push('payment_method_id');
                    }
                    if($("#payment_date").val() == ''){
                        validation.push('payment_date');
                    }
                    var payment_method_id_name = $("#payment_method_id option:selected").text();
                    var trim = payment_method_id_name.trim();
                    var string = trim.toLowerCase();
                    if(string == "cheque"){
                        if($("#cheque_no").val() == ''){
                            validation.push('cheque_no');
                        }
                        if($("#cheque_to").val() == ''){
                            validation.push('cheque_to');
                        }
                        if($("#bank_name").val() == ''){
                            validation.push('bank_name');
                        }
                    }
                }
            }

            if(validation.length > 0){
                validation.forEach(function(val) {
                    $('#'+val).addClass("border_error");
                    $('#' + val).parent().addClass('has-error');
                    if($('#'+val+'_error').length == 0){
                        $('#' + val).parent().addClass('has-error');
                    } 
                });
                notie.alert(3, '<?php _trans('toaster2'); ?>', 2);
                return false;
            }

            var service_items = [];
            $('table#service_item_table tbody>tr.item').each(function() {
                var service_row = {};
                $(this).find('input,select,textarea').each(function() {
                    if ($(this).is(':checkbox')) {
                        service_row[$(this).attr('name')] = $(this).is(':checked');
                    } else {
                        if($(this).val() != '' && $(this).val() != null && $(this).val() != undefined){
                            service_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
                        }
                    }
                });
                if(service_row){
                    if(service_row.item_service_id != "0" && service_row.item_service_id != 0){
                        service_items.push(service_row);
                    }
                }
            });

            var product_items = [];
            $('table#product_item_table tbody>tr.item').each(function() {
                var product_row = {};
                $(this).find('input,select,textarea').each(function() {
                        if ($(this).is(':checkbox')) {
                            product_row[$(this).attr('name')] = $(this).is(':checked');
                        } else {
                            if($(this).val() != '' && $(this).val() != null && $(this).val() != undefined){
                                product_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
                            }
                        }
                });
                if(product_row){
                    if(product_row.item_product_id != "0" && product_row.item_product_id != 0){
                        product_items.push(product_row);
                    }
                }
            });

            var product_totals = [];
            $('table#product_item_table .product_total_calculations').each(function() {
                var product_total_row = {};
                $(this).find('input,select,textarea').each(function() {
                    if ($(this).is(':checkbox')) {
                        product_total_row[$(this).attr('name')] = $(this).is(':checked');
                    } else {
                        if($(this).val() != '' && $(this).val() != null && $(this).val() != undefined){
                            product_total_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
                        }
                    }
                });
                product_totals.push(product_total_row);
            });

            var service_totals = [];
            $('table#service_item_table .service_total_calculations').each(function() {
                var service_total_row = {};
                $(this).find('input,select,textarea').each(function() {
                    if ($(this).is(':checkbox')) {
                        service_total_row[$(this).attr('name')] = $(this).is(':checked');
                    } else {
                        if($(this).val() != '' && $(this).val() != null && $(this).val() != undefined){
                            service_total_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
                        }
                    }
                });
                service_totals.push(service_total_row);
            });

            var service_package_items = [];
            $('table#service_package_item_table tbody>tr.item').each(function () {
                var service_package_row = {};
                $(this).find('input,select,textarea').each(function () {
                    if ($(this).is(':checkbox')) {
                        service_package_row[$(this).attr('name')] = $(this).is(':checked');
                    } else {
                        if($(this).val() != '' && $(this).val() != null && $(this).val() != undefined){
                            service_package_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
                        }
                    }
                });
                service_package_items.push(service_package_row);
            });

            var service_package_totals = [];
            $('table#service_package_item_table .service_total_calculations').each(function () {
                var service_package_total_row = {};
                $(this).find('input,select,textarea').each(function () {
                    if ($(this).is(':checkbox')) {
                        service_package_total_row[$(this).attr('name')] = $(this).is(':checked');
                    } else {
                        if($(this).val() != '' && $(this).val() != null && $(this).val() != undefined){
                            service_package_total_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
                        }
                    }
                });
                service_package_totals.push(service_package_total_row);
            });

            $('.has-error').removeClass('has-error');
            $('.border_error').removeClass("border_error");
            $('#gif').show();
            
            $.post('<?php echo site_url('mech_invoices/ajax/invoice_save'); ?>', {
                invoice_status: $('#invoice_status').val(),
                btn_status: btn_status,
                // ex_invoice_status: $("#ex_invoice_status").val()?$("#ex_invoice_status").val():'',
                invoice_no: $('#invoice_no').val()?$('#invoice_no').val():'',
                branch_id: $("#branch_id").val()?$("#branch_id").val():'',
                shift : 1,
                invoice_group_id : $("#invoice_group_id").val()?$("#invoice_group_id").val():'',
                purchase_no : $('#purchase_no').val()?$('#purchase_no').val():'',
                jobsheet_no : $('#jobsheet_no').val()?$('#jobsheet_no').val():'',
                invoice_id: $('#invoice_id').val()?$('#invoice_id').val():'',
                customer_car_id: $('#user_car_list_id').val()?$('#user_car_list_id').val():'',
                user_address_id: $('#user_address_id').val()?$('#user_address_id').val():'',
                invoice_date: $('#invoice_date').val()?$('#invoice_date').val():'',
                is_credit: $("#is_credit").val()?$("#is_credit").val():'N',
                tax_invoice : $("#tax_invoice").val(),
                payment_method_id: $("#payment_method_id").val()?$("#payment_method_id").val():'',
                cheque_no: $("#cheque_no").val()?$("#cheque_no").val().toUpperCase():'',
                cheque_to: $("#cheque_to").val()?$("#cheque_to").val():'',
                bank_name: $("#bank_name").val()?$("#bank_name").val():'',
                online_payment_ref_no: $("#online_payment_ref_no").val()?$("#online_payment_ref_no").val():'',
                payment_date: $('#payment_date').val()?$('#payment_date').val():'',
                in_days: $("#in_days").val()?$("#in_days").val():'',
                invoice_date_due: $("#invoice_date_due").val()?$("#invoice_date_due").val():'',
                quote_id: $('#quote_id').val()?$('#quote_id').val():'',
                customer_id: $('#customer_id').val()?$('#customer_id').val():'',
                invoice_terms_condition : $('#inv_ter_cond').html()?$('#inv_ter_cond').html():'',

                product_items: JSON.stringify(product_items),
                service_items: JSON.stringify(service_items),
                product_totals: JSON.stringify(product_totals),
                service_totals: JSON.stringify(service_totals),

                service_discountstate: $("#service_discountstate").val()?$("#service_discountstate").val():'',
                service_discount_pct: $("#service_discount").val()?$("#service_discount").val().replace(/,/g, ''):'',
                service_total_discount: $(".service_total_discount").html()?$(".service_total_discount").html().replace(/,/g, ''):'',
                service_tax_pct: $("#total_service_tax").val()?$("#total_service_tax").val().replace(/,/g, ''):'',
                total_servie_gst_price: $(".total_servie_gst_price").html()?$(".total_servie_gst_price").html().replace(/,/g, ''):'',
                total_service_amount: $(".total_servie_invoice").html()?$(".total_servie_invoice").html().replace(/,/g, ''):'',
                service_total_taxable: $('.total_user_service_taxable').html()?$('.total_user_service_taxable').html().replace(/,/g, ''):'',

                service_package_items : JSON.stringify(service_package_items),
                service_package_totals : JSON.stringify(service_package_totals),
                service_package_user_total: $(".total_user_service_package_price").html()?$(".total_user_service_package_price").html().replace(/,/g, ''):'',
                packagediscountstate: $("#packagediscountstate").val()?$("#packagediscountstate").val().replace(/,/g, ''):'',
                service_package_total_discount_pct: $("#service_package_discount").val()?$("#service_package_discount").val().replace(/,/g, ''):0,
                service_package_total_discount: $(".service_package_total_discount").html()?$(".service_package_total_discount").html().replace(/,/g, ''):0,
                service_package_total_taxable: $(".total_user_service_package_taxable").html()?$(".total_user_service_package_taxable").html().replace(/,/g, ''):0,
                service_package_total_gst_pct:  $("#total_service_package_tax").val()?$("#total_service_package_tax").val().replace(/,/g, ''):0,
                service_package_total_gst: $(".total_servie_package_gst_price").html()?$(".total_servie_package_gst_price").html().replace(/,/g, ''):0,
                service_package_grand_total: $(".total_servie_package_invoice").html()?$(".total_servie_package_invoice").html().replace(/,/g, ''):0,

                parts_discountstate: $("#parts_discountstate").val()?$("#parts_discountstate").val():'',
                product_total_taxable: $('.total_user_product_taxable').html()?$('.total_user_product_taxable').html().replace(/,/g, ''):'',
                total_taxable_amount: $(".total_taxable_amount").html()?$(".total_taxable_amount").html().replace(/,/g, ''):'',
                total_tax_amount: $('.total_gst_amount').html()?$('.total_gst_amount').html().replace(/,/g, ''):'',
                earned_amount: $("#earned_amount").val()?$("#earned_amount").val().replace(/,/g, ''):'',
                total_due_amount: $("#total_due_amount").val()?$("#total_due_amount").val().replace(/,/g, ''):'',
                advance_paid_amount: $("#advance_paid_amount").val()?$("#advance_paid_amount").val().replace(/,/g, ''):'',
                total_due_amount_save: $("#total_due_amount_save").val()?$("#total_due_amount_save").val().replace(/,/g, ''):'',
                appointment_grand_total: $(".grand_total").html()?$(".grand_total").html().replace(/,/g, ''):'',
                applied_rewards : $("#applied_rewards").val()?$("#applied_rewards").val().replace(/,/g, ''):'',
                rewards_id : $("#mrdlts_id").val()?$("#mrdlts_id").val().replace(/,/g, ''):'',
                rewards_amount : $("#rewards_amount").val()?$("#rewards_amount").val().replace(/,/g, ''):'',
                rewards_tax : $("#rewards_tax").val()?$("#rewards_tax").val().replace(/,/g, ''):'',
                applied_for : $("#applied_for").val()?$("#applied_for").val().replace(/,/g, ''):'',
                inclusive_exclusive : $("#inclusive_exclusive").val()?$("#inclusive_exclusive").val().replace(/,/g, ''):'',
                reward_type : $("#reward_type").val()?$("#reward_type").val().replace(/,/g, ''):'',
                reward_amount : $("#reward_amount").val()?$("#reward_amount").val().replace(/,/g, ''):'',
                bank_id: $('#bank_id').val()?$('#bank_id').val():'',
                refered_by_type: $('#refered_by_type').val()?$('#refered_by_type').val():'',
                refered_by_id: $('#refered_by_id').val()?$('#refered_by_id').val():'',
                fuel_level: $('#fuel_level').val()?$('#fuel_level').val():'',
                current_odometer_reading: $('#current_odometer_reading').val()?$('#current_odometer_reading').val():'',
                next_service_km: $("#next_service_km").val()?$("#next_service_km").val():'',
                next_service_dt: $("#next_service_dt").val()?$("#next_service_dt").val():'',
                description: $("#description").val()?$("#description").val():'',
                _mm_csrf: $('#_mm_csrf').val()
            }, function(data) {
                list = JSON.parse(data);
                if (list.success == '1') {
                    notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
                    if(btn_status == 'D'){
                        setTimeout(function() {
                            window.location = "<?php echo site_url('mech_invoices'); ?>";
                        }, 1000);
                    }else{
                        setTimeout(function() {
                            window.location = "<?php echo site_url('mech_invoices/view/'); ?>"+list.invoice_id;
                        }, 1000);
                    }
                }else if (list.success == '2') {
                    $('#gif').hide();
                    notie.alert(3, '<?php _trans('toaster2'); ?>', 2);
                }else if (list.success == '3') {
                    $('#gif').hide();
                    notie.alert(3,list.msg, 2);
                }else{
                    $('#gif').hide();
                    for (var key in list.validation_errors) {
                        $('#' + key).parent().addClass('has-error');
                        $('.error_msg_' + key).show().empty().html(list.validation_errors[key]);
                    }
                }
            });
        });

        $('.contacts-page').each(function() {
            var parent = $(this),
                btnExpand = parent.find('.action-btn-expand'),
                classExpand = 'box-typical-full-screen';

            btnExpand.click(function() {
                if (parent.hasClass(classExpand)) {
                    parent.removeClass(classExpand);
                    $('html').css('overflow', 'auto');
                    parent.find('.tab-content').height('auto').css('overflow', 'visible');
                } else {
                    parent.addClass(classExpand);
                    $('html').css('overflow', 'hidden');
                    parent.find('.tab-content').css('overflow', 'auto').height(
                        $(window).height() - 2 - parent.find('.box-typical-header').outerHeight()
                    );
                }
            });
        });

        $('#service_category_id').change(function () {

            // if($("#user_car_list_id").val() == ''){
            //     notie.alert(3, '<?php // _trans('toaster5'); ?>', 2);
            //     $("#service_category_id").val(0);
            //     $('.bootstrap-select').selectpicker("refresh");
            //     return false;
            // }
            $('#gif').show();
            $.post("<?php echo site_url('mech_item_master/ajax/getServiceList'); ?>", {
                service_category_id: $('#service_category_id').val(),
                user_car_list_id: $('#user_car_list_id').val(),
                _mm_csrf: $('#_mm_csrf').val()
            },function (data) {
                var response = JSON.parse(data);
                if (response) {
                    $('#gif').hide();
                    $('#services_add_service').empty(); // clear the current elements in select box
                    $('#services_add_service').append($('<option></option>').attr('value', '').text('Item'));
                    for (row in response) {
                        $('#services_add_service').append($('<option></option>').attr('value', response[row].msim_id).text(response[row].service_item_name));
                    }
                    $('#services_add_service').selectpicker("refresh");
                }else{
                    $('#gif').hide();
                    console.log("No data found");
                }
            });
        });

        $('#customer_id').change(function(){

            if ($('#customer_id').val() != '') {
                $('.addcarpopuplink').show();
            } else {
                $('.addcarpopuplink').hide();
            }
            $('#gif').show();
            $.post("<?php echo site_url('clients/ajax/get_customer_cars_address'); ?>", {
                customer_id: $('#customer_id').val(),
                _mm_csrf: $('#_mm_csrf').val()
            },
            function(data) {
                var response = JSON.parse(data);
                $('.add_car').attr('data-customer-id', $('#customer_id').val());
                $('.add_address').attr('data-customer-id', $('#customer_id').val());
                $('#common_customer_id').val($('#customer_id').val());
                if (response.success == '1' || response.success == 1 ) {
                    if (response.user_cars.length > 0) {
                        $('#gif').hide();
                        var cars = response.user_cars;
                        $('#user_car_list_id').empty();
                        $('#user_car_list_id').append($('<option></option>').attr('value', '').text('Select Customer Vehicle'));
                        for (row in cars) {
                            var variant_name = (cars[row].variant_name) ? cars[row].variant_name : '';
                            $('#user_car_list_id').append($('<option></option>').attr('value', cars[row].car_list_id).text((cars[row].brand_name?cars[row].brand_name:"")+''+(cars[row].model_name?", "+cars[row].model_name: '')+''+(cars[row].variant_name?", "+cars[row].variant_name:'')+''+(cars[row].car_reg_no?", "+cars[row].car_reg_no: '')));
                        }
                        $('#user_car_list_id').selectpicker("refresh");
                    } else {
                        $('#gif').hide();
                        $('#user_car_list_id').empty();
                        $('#user_car_list_id').append($('<option></option>').attr('value', '').text('Select Customer Vehicle'));
                        $('#user_car_list_id').selectpicker("refresh");
                    }
                    if (response.user_address.length > 0) {
                        $('#gif').hide();
                        var add = response.user_address;
                        $('#user_address_id').empty();
                        $('#user_address_id').append($('<option></option>').attr('value', '').text('Select Customer Address'));
                        for (row in add) {
                            var full_address = ((add[row].customer_street_1)?add[row].customer_street_1:'')+" "+((add[row].customer_street_2)?", "+add[row].customer_street_2:'')+""+((add[row].area)?", "+add[row].area:'');
                            var zip_code = (add[row].zip_code) ? add[row].zip_code : '';
                            var address = full_address + ', ' + zip_code;
                            $('#user_address_id').append($('<option></option>').attr('value', add[row].user_address_id).text(address));
                        }
                        $('#user_address_id').selectpicker("refresh");
                    } else {
                        $('#gif').hide();
                        $('#user_address_id').empty();
                        $('#user_address_id').append($('<option></option>').attr('value', '').text('Select Customer Address'));
                        $('#user_address_id').selectpicker("refresh");
                    }
                    if(response.customer_referrence.length > 0){
                        $('#gif').hide();
                        $("#refered_by_type").val(response.customer_referrence[0].refered_by_type);
                        $("#refered_by_id").val(response.customer_referrence[0].refered_by_id);
                    }else{
                        $('#gif').hide();
                        $("#refered_by_type").val('');
                        $("#refered_by_id").val('');
                    }
                }
            });
        });

        $("#jobsheet_no").change(function(){
            var jobsheet_no = $("#jobsheet_no").val();
			if(jobsheet_no == ''){
                $("#branch_id").val('').trigger("change");
                $("#customer_id").val('').trigger("change");
                $("#current_odometer_reading").val('');
                $("#fuel_level").val('').trigger("change");
                $("#next_service_dt").val('').trigger("change");
                $('#user_car_list_id').empty(); // clear the current elements in select box
                $('#user_car_list_id').append($('<option></option>').attr('value', '').text('Select Customer Vehicle'));
                $('#user_car_list_id').selectpicker("refresh");
                $('#user_address_id').empty(); // clear the current elements in select box
                $('#user_address_id').append($('<option></option>').attr('value', '').text('Select Customer Address'));
                $('#user_address_id').selectpicker("refresh");
                $('#service_item_table tbody tr.item').remove();
                $('#product_item_table tbody tr.item').remove();
                $("#service_discount").val('');
                $("#service_discountstate").val(1);
                $("#parts_discountstate").val(1);
                $("#total_service_tax").val(0);
                $(".total_servie_gst_price").empty().append('');
                $("#advance_paid_amount").val('');
                $("#due_amount_label").val('');
                $("#service_package_discount").val('');
                $("#total_service_package_tax").val(0);

                service_calculation();
                product_calculation();
                service_package_calculation();
			}else{
                $('#gif').show();
                $.post("<?php echo site_url('mech_invoices/ajax/getJobsheetServiceProduct'); ?>", {
                	jobsheet_no: $('#jobsheet_no').val(),
                    _mm_csrf: $('#_mm_csrf').val()
                },
                function(data) {
                    var response = JSON.parse(data);
                    if(response.success == 1 || response.success == '1'){
                        if(response.work_order_details){
                            $('#gif').hide();
                            if(response.work_order_details.customer_id){
                                $('#gif').hide();
                                $("#customer_id").val(response.work_order_details.customer_id).trigger("change");
                            }
                            if(response.work_order_details.branch_id){
                                $('#gif').hide();
                                $("#branch_id").val(response.work_order_details.branch_id).trigger("change");
                            }
                            setTimeout(function(){ 
                                if(response.work_order_details.customer_car_id){
                                    $('#gif').hide();
                                    $("#user_car_list_id").val(response.work_order_details.customer_car_id).trigger("change");
                                    $('.bootstrap-select').selectpicker("refresh");
                                }
                                if(response.work_order_details.user_address_id){
                                    $('#gif').hide();
                                    $("#user_address_id").val(response.work_order_details.user_address_id).trigger("change");
                                    $('.bootstrap-select').selectpicker("refresh");
                                }
                            }, 300);
                            if(response.work_order_details.current_odometer_reading){
                                $('#gif').hide();
                                $("#current_odometer_reading").val(response.work_order_details.current_odometer_reading);
                            }
                            if(response.work_order_details.next_service_dt){
                                $('#gif').hide();
                                $("#next_service_dt").val((response.work_order_details.next_service_dt?formatDate(response.work_order_details.next_service_dt):""));
                            }
                            if(response.work_order_details.fuel_level){
                                $('#gif').hide();
                                $("#fuel_level").val(response.work_order_details.fuel_level).trigger("change");
                            }
                            if(response.work_order_details.refered_by_type){
                                $('#gif').hide();

                                $("#refered_by_type").val(response.work_order_details.refered_by_type);
                            }
                            if(response.work_order_details.refered_by_id){
                                $('#gif').hide();
                                $("#refered_by_id").val(response.work_order_details.refered_by_id);
                                $('.bootstrap-select').selectpicker("refresh");
                            }
                            if(response.work_order_details.service_total_discount_pct){
                                $('#gif').hide();
                                $("#service_discount").val(response.work_order_details.service_total_discount_pct);
                            }
                            if(response.work_order_details.service_total_gst_pct){
                                $('#gif').hide();
                                $("#total_service_tax").val(parseInt(response.work_order_details.service_total_gst_pct)).trigger("change");;
                            }
                            if(response.work_order_details.service_total_gst){
                                $('#gif').hide();
                                $(".total_servie_gst_price").empty().append(response.work_order_details.service_total_gst);
                            }
                            if(response.work_order_details.service_discountstate){
                                $('#gif').hide();
                                $("#service_discountstate").val(response.work_order_details.service_discountstate);
                            }
                            if(response.work_order_details.parts_discountstate){
                                $('#gif').hide();
                                $("#parts_discountstate").val(response.work_order_details.parts_discountstate);
                            }
                            if(response.work_order_details.total_paid_amount){
                                $('#gif').hide();
                                jobadvance_amt = response.work_order_details.total_paid_amount;
                                $("#advance_paid_amount").val(response.work_order_details.total_paid_amount);
                                $(".advance_amount_label").empty().append(response.work_order_details.total_paid_amount);
                                // $(".due_amount_label").empty().append(format_money(response.work_order_details.grand_total - response.work_order_details.total_paid_amount));
                                // $("#total_due_amount").val(format_money(response.work_order_details.grand_total - response.work_order_details.total_paid_amount));
                            }
                            if(response.work_order_details.service_package_total_discount_pct){
                                $('#gif').hide();
                                $("#service_package_discount").val(response.work_order_details.service_package_total_discount_pct);
                            }
                            if(response.work_order_details.service_package_total_gst_pct){
                                $('#gif').hide();
                                $("#total_service_package_tax").val(parseInt(response.work_order_details.service_package_total_gst_pct)).trigger("change");;
                            }
                            
                        }
                    	if (response.serviceList.length > 0) {
                            $('#gif').hide();
                            service_row_data(response.serviceList);
                        }else{
                            $('#gif').hide();
                            var empty = '';
                            $("#service_item_table .item").empty();
                            service_calculation();
                            service_row_data(empty);
                        }				
                        if (response.productList.length > 0) {
                            $('#gif').hide();
                            product_row_data(response.productList);
                        }else{
                            $('#gif').hide();
                            var empty = '';
                            $("#product_item_table .item").empty();
                            product_calculation();
                            product_row_data(empty);
                        }
                        if (response.service_package_items.length > 0) {
                            $('#gif').hide();
                            service_package_row_data(response.service_package_items);
                        }else{
                            $('#gif').hide();
                            var empty = '';
                            $("#service_package_item_table .item").empty();
                            service_package_calculation();
                            service_package_row_data(empty);
                        }
                    }
                    $('#gif').hide();
                    $('.bootstrap-select').selectpicker("refresh");
               });
			}
        });
    });
</script> 