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
    var default_currency_digit  = parseInt('<?php echo $this->session->userdata("default_currency_digit")?$this->session->userdata("default_currency_digit"):0;?>');
    var getServiceDetailsURL = '<?php echo site_url('mech_item_master/ajax/getServiceDetails'); ?>';
    var getProductDetailsURL = '<?php echo site_url('mech_item_master/ajax/get_product_details'); ?>';
    var getBranchDetailsURL = '<?php echo site_url('workshop_branch/ajax/getBranchDetail'); ?>';
    var getServicePackageDetailsURL = '<?php echo site_url('service_packages/ajax/get_package_details'); ?>';
    var taxURL = '<?php echo site_url('mech_tax/ajax/gettaxDetails');?>';
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
    $(function() {
        $('#btn-cancel').click(function() {
            window.location = "<?php echo site_url('mech_quotes'); ?>";
        });
    });
</script>
<script src="<?php echo base_url(); ?>assets/mp_backend/js/quote.js"></script>
<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell" id="total_user_quote">
                    <h3><?php _trans('lable843'); ?><?php if ($quote_detail->quote_no) { echo ' - '.$quotes_detail->quote_no; } ?></h3>
                </div>
                <div class="tbl-cell tbl-cell-action">
					<a href="<?php echo site_url('mech_quotes/create'); ?>"  class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> <?php _trans('lable40'); ?></a>
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
		<a class="anchor anchor-back" href="<?php echo site_url('mech_quotes/index'); ?>"><i class="fa fa-long-arrow-left"></i><span> <?php _trans('lable59'); ?></span></a>
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
                            <span><?php if ($company_details->branch_street) {
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
                                    ?></span>
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
                <input type="hidden" name="quote_id" id="quote_id" value="<?php echo $quote_id; ?>" autocomplete="off"/>
                <input type="hidden" name="quote_no" id="quote_no" value="<?php echo $quotes_detail->quote_no; ?>" autocomplete="off"/>
                <input type="hidden" name="car_brand_id" id="car_brand_id" value="<?php echo $quotes_detail->car_brand_id; ?>" autocomplete="off"/>
                <input type="hidden" name="car_brand_model_id" id="car_brand_model_id" value="<?php echo $quotes_detail->car_brand_model_id; ?>" autocomplete="off"/>
                <input type="hidden" name="brand_model_variant_id" id="brand_model_variant_id" value="<?php echo $quotes_detail->brand_model_variant_id; ?>" autocomplete="off"/>
                <input type="hidden" name="refered_by_type" id="refered_by_type" value="<?php echo $quotes_detail->refered_by_type; ?>" />
		        <input type="hidden" name="refered_by_id" id="refered_by_id" value="<?php echo $quotes_detail->refered_by_id; ?>" />
                <input type="hidden" name="term_val" id="term_val" value="<?php echo $quotes_detail->quote_terms_condition; ?>" autocomplete="off"/>

                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable51'); ?>*</label>
                    <div class="form_controls">
                        <select id="branch_id" name="branch_id" class="quote_terms bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                            <?php if(count($branch_list) > 1){ ?> 
                            <option value=""><?php _trans('lable51'); ?></option>
                            <?php } ?>
                            <?php foreach ($branch_list as $branchList) {?>
                            <option data-terms-condition="<?php echo $branchList->estimate_description; ?>" value="<?php echo $branchList->w_branch_id; ?>" <?php if($quotes_detail->branch_id == $branchList->w_branch_id){echo "selected";}?> > <?php echo $branchList->display_board_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable276'); ?>.*</label>
                    <div class="form_controls">
                        <select name="invoice_group_id" id="invoice_group_id" <?php if($quotes_detail->invoice_status != 'D' && $quotes_detail->invoice_status != ''){ echo 'disabled'; } ?> class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                            <?php if(count($invoice_group) > 1){ ?> 
                            <option value=""><?php _trans('lable277'); ?></option>
                            <?php } ?>
                            <?php foreach ($invoice_group as $invoice_group_list) {
                                if (!empty($quotes_detail)) {
                                    if ($quotes_detail->invoice_group_id == $invoice_group_list->invoice_group_id) {
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
                    <label class="form_label"><?php _trans('lable841'); ?>*</label>
                    <div class="form_controls">
                        <input type="text" name="quote_date" id="quote_date" class="form-control removeErrorInput datepicker" value="<?php echo $quotes_detail->quote_date?date_from_mysql($quotes_detail->quote_date):date_from_mysql(date('Y-m-d')); ?>" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable36'); ?>*</label>
                    <div class="form_controls">
                        <select name="customer_id" id="customer_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                            <option value=""><?php _trans('lable379'); ?></option>
                            <?php foreach ($customer_list as $customer) {
                                if (!empty($quotes_detail)) {
                                    if ($quotes_detail->customer_id == $customer->client_id) {
                                        $selected = 'selected="selected"';
                                    } else {
                                        $selected = '';
                                    }
                                } else {
                                    $selected = '';
                                } ?>
                                <option value="<?php echo $customer->client_id; ?>" <?php echo $selected; ?>><?php echo ($customer->client_name?$customer->client_name:"").' '.($customer->client_contact_no?"(".$customer->client_contact_no.")":""); ?></option>
                            <?php
                            } ?>
                        </select>
                        <div class="col-lg-12 paddingTop5px paddingLeft0px">
                            <a class="fontSize_85rem float_left add_client_page" href="javascript:void(0)" data-toggle="modal" data-model-from="quote" data-target="#addNewCar">
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
                                if (!empty($quotes_detail)) {
                                    if ($quotes_detail->customer_car_id == $cars->car_list_id) {
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
                        <div class="col-lg-12 paddingTop5px paddingLeft0px">
                            <a class="fontSize_85rem float_left add_car addcarpopuplink " href="javascript:void(0)" data-toggle="modal" data-model-from="quote" <?php if($quotes_detail->customer_id){echo 'data-customer-id="'.$quotes_detail->customer_id.'"';}?> data-target="#addNewCar">+ Add New Vechicle</a>
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
                                if (!empty($quotes_detail)) {
                                    if ($quotes_detail->user_address_id == $address->user_address_id) {
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
                        <div class="col-lg-12 paddingTop5px paddingLeft0px">
                            <a class="fontSize_85rem float_left add_address addcarpopuplink" href="javascript:void(0)" data-model-from="quote" <?php if($quotes_detail->customer_id){echo 'data-customer-id="'.$quotes_detail->customer_id.'"';} ?> data-toggle="modal" data-target="#addAddress">
                                + <?php _trans('lable45'); ?>
                            </a>
                        </div>
                    </div>
                </div>
                <?php if($this->session->userdata('is_shift') == 1){ ?>
                    <input type="hidden" value="<?php echo $quotes_detail->shift?$quotes_detail->shift:1;?>" id="shift" name="shift" autocomplete="off">
                <?php } else { ?>
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12" style="display:none;">
                    <label class="form_label"><?php _trans('lable152'); ?></label>
                    <div class="form_controls">
                        <select id="shift" name="shift" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                            <option value=""><?php _trans('lable152'); ?></option>	
                            <?php foreach ($shift_list as $shiftList) {?>
                            <option value="<?php echo $shiftList->shift_id; ?>" <?php if($quotes_detail->shift == $shiftList->shift_id){echo "selected";}?> > <?php echo $shiftList->shift_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="row">
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable283'); ?></label>
                    <div class="form_controls">
                        <input type="text" name="current_odometer_reading" id="current_odometer_reading" class="form-control" value="<?php if ($quotes_detail) {
                                        echo $quotes_detail->current_odometer_reading;
                                    } ?>" autocomplete="off">
                    </div>
                </div>
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable126'); ?></label>
                    <div class="form_controls">
                        <select name="purchase_no" id="purchase_no" class="form-control bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                            <option value=""><?php _trans('lable380'); ?></option>
                            <?php foreach ($purchase_no_list as $purnoList) {?>
                            <option value="<?php echo $purnoList->purchase_no; ?>" <?php if($quotes_detail->purchase_no == $purnoList->purchase_no){ echo "selected"; }?> ><?php echo $purnoList->purchase_no; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <?php if($is_product == "Y"){ ?>
            <?php $this->layout->load_view('mech_quotes/partial_product_table'); ?>
            <?php } ?>
            <?php $this->layout->load_view('mech_quotes/partial_service_table'); ?>
            <?php $this->layout->load_view('mech_quotes/partial_service_package_table'); ?>
            <div class="row paddingBottom25px">
                <div class="col-lg-12">
                    <div class="col-lg-5 col-md-5 col-sm-4 terms-and-conditions">
                        <div class="col-sm-12 hide_terms form-group padding0px">
                            <strong><?php _trans('lable388'); ?></strong><br>
                            <label name="quote_ter_cond" id="quote_ter_cond" style="text-align:left;text-align:justify;" class="control-label string required"><?php echo $quotes_detail->quote_terms_condition;?></label>
                        </div>
                        <div class="col-sm-12 form-group padding0px">
                            <label class="control-label" style="text-align: left"><?php _trans('lable177');?></label>
<textarea class="form-control" name="description" id="description">
<?php echo $quotes_detail->description; ?>
</textarea>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-8 clearfix" style="float: right">
                        <div class="total-amount row" style="float: left;width: 100%`">
                            <div class="row">
                                <div id="referral_rewards" <?php if($quotes_detail->applied_rewards == 'Y'){ echo 'style="display:block"'; }else { echo 'style="display:none"';} ?> class="referral_rewards col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop10px">
                                    <input type="checkbox" value="<?php echo $quotes_detail->applied_rewards;?>" <?php if($quotes_detail->applied_rewards == 'Y'){ echo 'checked';}else if($applied_rewards == 'Y'){ echo 'checked'; }?> class="checkbox" name="applied_rewards" id="applied_rewards" autocomplete="off"> <?php echo trans('lable391'); ?>
                                    <input type="hidden" id="mrdlts_id" value="<?php echo $reward_detail->mrdlts_id; ?>"autocomplete="off" >
                                    <input type="hidden" id="rewards_amount" value="<?php echo $rewards_amount; ?>" autocomplete="off">
                                    <input type="hidden" id="rewards_tax" value="<?php echo $rewards_tax; ?>"autocomplete="off">
                                    <input type="hidden" id="applied_for" value="<?php echo $reward_detail->applied_for;?>"autocomplete="off">
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
                                    <b><?php _trans('lable332'); ?></b>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 price clearfix" style="border-top:1px solid #000; margin-top: 5px">
                                    <?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<b class="grand_total">0.00</b>
                                </div>
                                <input type="hidden" id="total_due_amount_save" name="total_due_amount_save" value="<?php echo $quotes_detail->total_due_amount;?>" autocomplete="off">
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
            <input id="quote_status" type="hidden" value="<?php echo $quotes_detail->quote_status;?>" autocomplete="off">
            <input id="ex_quote_status" type="hidden" value="<?php echo $quotes_detail->quote_status;?>" autocomplete="off">
            <div class="row invoiceFloatbtn">
                <div class="col-lg-+12 clearfix buttons text-right">
                    <?php
                     if ($quotes_detail->quote_status != 'D') { ?>
                    <button id="btn_submit" name="btn_submit" class="btn_submit btn btn-rounded btn-primary" value="G">
                        <i class="fa fa-check"></i> <?php _trans('lable57'); ?>
                    </button>                    
                    <?php } else {  ?>
                    <button id="btn_submit" name="btn_submit" class="btn_submit btn btn-rounded btn-primary" value="G">
                        <i class="fa fa-check"></i><?php _trans('lable376'); ?></button>
                    <button id="btn_submit" name="btn_submit" class="btn_submit btn btn-rounded btn-primary" value="D">
                        <i class="fa fa-check"></i> <?php _trans('lable57'); ?></button>
                    <?php
                     } ?>
                     <?php if($quotes_detail->quote_id){ ?>
                        <a class="btn btn-rounded btn-primary" target="_blank" href="<?php echo site_url('mech_quotes/generate_pdf/'.$quotes_detail->quote_id); ?>">
                            <i class="fa fa-edit fa-margin"></i> <?php _trans('lable141'); ?>
                        </a>
                    <?php }?>
                    <button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default" value="1">
                        <i class="fa fa-times"></i> <?php _trans('lable58'); ?>
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    if($("#term_val").val()){
        $('.hide_terms').show();
    }else{
        $('.hide_terms').hide();
    }
    $(document).ready(function() {

        if ($('#customer_id').val() != '') {
            $('.addcarpopuplink').show();
        } else {
            $('.addcarpopuplink').hide();
        }

        $("#btn_cancel").click(function() {
            window.location.href = "<?php echo site_url('mech_quotes'); ?>";
        });

        $('.quote_terms').change(function() {
            var quote_terms_condition = $("#branch_id").find('option:selected').attr('data-terms-condition');
                $("#quote_ter_cond").empty().append(quote_terms_condition);
                if(quote_terms_condition == ''){
                $('.hide_terms').hide();
            }else{
                $('.hide_terms').show();
            }
        });

        $(".btn_submit").click(function() {

            $('.has-error').removeClass('has-error');
            $('.border_error').removeClass("border_error");

            var validation = [];

            var quote_status = $(this).val();
            
            if(quote_status == 'G'){
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

            if($("#quote_date").val() == ''){
                validation.push('quote_date');
            }

            if($("#user_car_list_id").val() == ''){
                validation.push('user_car_list_id');
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

            $.post('<?php echo site_url('mech_quotes/ajax/quote_save'); ?>', {
                quote_status: quote_status,
                ex_quote_status: $("#ex_quote_status").val()?$("#ex_quote_status").val():'',
                quote_no: $('#quote_no').val()?$('#quote_no').val():'',
                branch_id: $("#branch_id").val()?$("#branch_id").val():'',
                current_odometer_reading: $('#current_odometer_reading').val()?$('#current_odometer_reading').val():'',
                shift : 1,
                invoice_group_id : $("#invoice_group_id").val()?$("#invoice_group_id").val():'',
                purchase_no : $('#purchase_no').val()?$('#purchase_no').val():'',
                quote_id: $('#quote_id').val()?$('#quote_id').val():'',
                customer_car_id: $('#user_car_list_id').val()?$('#user_car_list_id').val():'',
                user_address_id: $('#user_address_id').val()?$('#user_address_id').val():'',
                quote_date: $('#quote_date').val()?$('#quote_date').val():'',
                customer_id: $('#customer_id').val()?$('#customer_id').val():'',
                car_brand_id: $('#car_brand_id').val()?$('#car_brand_id').val():'',
                car_brand_model_id: $('#car_brand_model_id').val()?$('#car_brand_model_id').val():'',
                brand_model_variant_id: $('#brand_model_variant_id').val()?$('#brand_model_variant_id').val():'',
                quote_terms_condition : $('#quote_ter_cond').html()?$('#quote_ter_cond').html():'',
                product_items: JSON.stringify(product_items),
                service_items: JSON.stringify(service_items),
                product_totals: JSON.stringify(product_totals),
                service_totals: JSON.stringify(service_totals),

                service_discountstate: $("#service_discountstate").val()?$("#service_discountstate").val():'',
                service_discount_pct: $("#service_discount").val()?$("#service_discount").val().replace(/,/g, ''):'',
                service_total_discount: $(".service_total_discount").html()?$(".service_total_discount").html().replace(/,/g, ''):'',
                service_tax_pct: $("#total_service_tax").val()?$("#total_service_tax").val():'',
                total_servie_gst_price: $(".total_servie_gst_price").html()?$(".total_servie_gst_price").html().replace(/,/g, ''):'',
                total_service_amount: $(".total_servie_invoice").html()?$(".total_servie_invoice").html().replace(/,/g, ''):'',
                service_total_taxable: $('.total_user_service_taxable').html()?$('.total_user_service_taxable').html().replace(/,/g, ''):'',

                service_package_items : JSON.stringify(service_package_items),
                service_package_totals : JSON.stringify(service_package_totals),
                service_package_user_total: $(".total_user_service_package_price").html()?$(".total_user_service_package_price").html().replace(/,/g, ''):'',
                packagediscountstate: $("#packagediscountstate").val()?$("#packagediscountstate").val():'',
                service_package_total_discount_pct: $("#service_package_discount").val()?$("#service_package_discount").val().replace(/,/g, ''):0,
                service_package_total_discount: $(".service_package_total_discount").html()?$(".service_package_total_discount").html().replace(/,/g, ''):0,
                service_package_total_taxable: $(".total_user_service_package_taxable").html()?$(".total_user_service_package_taxable").html().replace(/,/g, ''):0,
                service_package_total_gst_pct:  $("#total_service_package_tax").val()?$("#total_service_package_tax").val():0,
                service_package_total_gst: $(".total_servie_package_gst_price").html()?$(".total_servie_package_gst_price").html().replace(/,/g, ''):0,
                service_package_grand_total: $(".total_servie_package_invoice").html()?$(".total_servie_package_invoice").html().replace(/,/g, ''):0,

                parts_discountstate: $("#parts_discountstate").val()?$("#parts_discountstate").val():'',
                product_total_taxable: $('.total_user_product_taxable').html()?$('.total_user_product_taxable').html().replace(/,/g, ''):'',
                total_taxable_amount: $(".total_taxable_amount").html()?$(".total_taxable_amount").html().replace(/,/g, ''):'',
                total_tax_amount: $('.total_gst_amount').html()?$('.total_gst_amount').html().replace(/,/g, ''):'',
                total_due_amount: $("#total_due_amount").val()?$("#total_due_amount").val().replace(/,/g, ''):'',
                total_due_amount_save: $("#total_due_amount_save").val()?$("#total_due_amount_save").val().replace(/,/g, ''):'',
                appointment_grand_total: $(".grand_total").html().replace(/,/g, ''),           
                refered_by_type: $('#refered_by_type').val()?$('#refered_by_type').val():'',
                refered_by_id: $('#refered_by_id').val()?$('#refered_by_id').val():'',
                description: $("#description").val()?$("#description").val():'',
                _mm_csrf: $('#_mm_csrf').val()
            }, function(data) {
                list = JSON.parse(data);
                if (list.success == '1') {
                    notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
                    setTimeout(function() {
                        window.location = "<?php echo site_url('mech_quotes/view/'); ?>"+list.quote_id;
                    }, 1000);
                }else if (list.success == '2') {
                    $('#gif').hide();
                	notie.alert(3, '<?php _trans('toaster2'); ?>', 2);
                }else if (list.success == '3') {
                    $('#gif').hide();
                    notie.alert(3,list.msg,2);
                }else{
                    $('#gif').hide();
                    for (var key in list.validation_errors) {
                        $('#' + key).parent().addClass('has-error');
                        $('.error_msg_' + key).show().empty().html(list.validation_errors[key]);
                    }
                }
            });
        });

        $('#customer_id').change(function() {

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
                    $('#user_car_list_id').empty();
                    if (response.user_cars.length > 0) {
                        $('#gif').hide();
                        var cars = response.user_cars;
                        $('#user_car_list_id').append($('<option></option>').attr('value', '').text('Select Customer Vehicle'));
                        for (row in cars) {
                            var variant_name = (cars[row].variant_name) ? cars[row].variant_name : '';
                            $('#user_car_list_id').append($('<option></option>').attr('value', cars[row].car_list_id).text((cars[row].brand_name?cars[row].brand_name:"")+''+(cars[row].model_name?", "+cars[row].model_name: '')+''+(cars[row].variant_name?", "+cars[row].variant_name:'')+''+(cars[row].car_reg_no?", "+cars[row].car_reg_no: '')));
                        }
                    } else {
                        $('#gif').hide();
                        $('#user_car_list_id').append($('<option></option>').attr('value', '').text('Select Customer Vehicle'));
                    }
                    $('#gif').hide();
                    $('#user_car_list_id').selectpicker("refresh");
                    $('#user_address_id').empty();
                    if (response.user_address.length > 0) {
                        $('#gif').hide();
                        var add = response.user_address;
                        $('#user_address_id').append($('<option></option>').attr('value', '').text('Select Customer Address'));
                        for (row in add) {
                            var full_address = ((add[row].customer_street_1)?add[row].customer_street_1:'')+" "+((add[row].customer_street_2)?", "+add[row].customer_street_2:'')+""+((add[row].area)?", "+add[row].area:'');
                            var zip_code = (add[row].zip_code) ? add[row].zip_code : '';
                            var address = full_address + ', ' + zip_code;
                            $('#user_address_id').append($('<option></option>').attr('value', add[row].user_address_id).text(address));
                        }
                    } else {
                        $('#gif').hide();
                        $('#user_address_id').append($('<option></option>').attr('value', '').text('Select Customer Address'));
                        $('#user_address_id').selectpicker("refresh");
                    }
                    $('#gif').hide();
                    $('#user_address_id').selectpicker("refresh");
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
                if (response.length > 0) {
                    $('#gif').hide();
                    $('#services_add_service').empty(); // clear the current elements in select box
                    $('#services_add_service').append($('<option></option>').attr('value', '').text('Item'));
                    for (row in response) {
                        $('#services_add_service').append($('<option></option>').attr('value', response[row].msim_id).attr('data-s_id', response[row].s_id).text(response[row].service_item_name));
                    }
                    $('#services_add_service').selectpicker("refresh");
                }else{
                    $('#gif').hide();
                    console.log("No data found");
                }
            });
        });

    });
</script> 
