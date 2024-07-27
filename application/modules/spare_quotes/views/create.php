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
    var getProductDetailsURL = '<?php echo site_url('mech_item_master/ajax/get_product_details'); ?>';
    var getBranchDetailsURL = '<?php echo site_url('workshop_branch/ajax/getBranchDetail'); ?>';
    var taxURL = '<?php echo site_url('mech_tax/ajax/gettaxDetails');?>';
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
    $('#gif').show();
$.post("<?php echo site_url('mech_item_master/ajax/getProductItemList'); ?>", {
    product_category_id: $('#product_category_id').val()?$('#product_category_id').val():'',
    product_brand_id: $("#product_brand_id").val()?$("#product_brand_id").val():'',
    brand_id: $('#brand_id').val()?$('#brand_id').val():'',
    model_id: $('#model_id').val()?$('#model_id').val():'',
    variant_id : $("#variant_id").val()?$("#variant_id").val():'',
    fuel_type: $("#fuel_type").val()?$("#fuel_type").val():'',
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
            window.location = "<?php echo site_url('spare_quotes'); ?>";
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
					<a href="<?php echo site_url('spare_quotes/create'); ?>"  class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> <?php _trans('lable40'); ?></a>
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
		<a class="anchor anchor-back" href="<?php echo site_url('spare_quotes/index'); ?>"><i class="fa fa-long-arrow-left"></i><span> <?php _trans('lable59'); ?></span></a>
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
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable51'); ?>*</label>
                    <div class="form_controls">
                        <select id="branch_id" name="branch_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                            <?php if(count($branch_list) > 1){ ?> 
                            <option value=""><?php _trans('lable51'); ?></option>
                            <?php } ?>
                            <?php foreach ($branch_list as $branchList) {?>
                            <option value="<?php echo $branchList->w_branch_id; ?>" <?php if($quotes_detail->branch_id == $branchList->w_branch_id){echo "selected";}?> > <?php echo $branchList->display_board_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable276'); ?>.*</label>
                    <div class="form_controls">
                        <select name="invoice_group_id" id="invoice_group_id" <?php if($quotes_detail->invoice_status != 'D' && $quotes_detail->invoice_status != ''){ echo 'disabled'; } ?> class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                            <?php if(count($invoice_group) != 1){ ?>
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
                            <a class="fontSize_85rem float_left add_client_page" href="javascript:void(0)" data-toggle="modal" data-model-from="invoice" data-target="#addNewCar">
                                + <?php _trans('lable48'); ?> 
                            </a>
                        </div>
                    </div>
                </div>
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable61'); ?></label>
                    <div class="form_controls">
                        <select name="user_address_id" id="user_address_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                            <option value=""><?php _trans('lable282'); ?></option>
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
                            <a class="fontSize_85rem float_left add_address addcarpopuplink" href="javascript:void(0)" data-model-from="invoice" <?php if($quotes_detail->customer_id){echo 'data-customer-id="'.$quotes_detail->customer_id.'"';} ?> data-toggle="modal" data-target="#addAddress">
                                + <?php _trans('lable45'); ?>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable841'); ?>*</label>
                    <div class="form_controls">
                        <input type="text" name="quote_date" id="quote_date" class="form-control removeErrorInput datepicker" value="<?php echo $quotes_detail->quote_date?date_from_mysql($quotes_detail->quote_date):date_from_mysql(date('Y-m-d')); ?>" autocomplete="off">
                    </div>
                </div>
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable52'); ?></label>
                    <div class="form_controls">
                        <select name="refered_by_type" id="refered_by_type" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                            <option value=""><?php _trans('lable53'); ?></option>
                            <?php foreach ($reference_type as $rtype) {
                                if ($quotes_detail->refered_by_type == $rtype->refer_type_id) {
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
                <div class="row">
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable291'); ?></label>
                    <div class="form_controls">
                        <select name="refered_by_id" id="refered_by_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                            <option value=""><?php _trans('lable55'); ?></option>
                            <?php foreach ($refered_dtls as $refered) {
                                            if ($quotes_detail->refered_by_type == 1) {
                                                $id = $refered->client_id;
                                                $name = $refered->client_name.' - '.$refered->client_contact_no;
                                            } elseif ($quotes_detail->refered_by_type == 2) {
                                                $id = $refered->employee_id;
                                                $name = $refered->employee_name.' - '.$refered->mobile_no;
                                            }
                                            if ($quotes_detail->refered_by_id == $id) {
                                                $selected = 'selected="selected"';
                                            } else {
                                                $selected = '';
                                            } ?>
                            <option value="<?php echo $id; ?>" <?php echo $selected; ?>><?php echo $name; ?></option>
                            <?php  } ?>
                        </select>
                    </div>
                </div>
            </div>
            <?php $this->layout->load_view('spare_quotes/partial_product_table'); ?>
            <div class="row paddingBottom25px">
                <div class="col-lg-12">
                    <div class="col-lg-5 col-md-5 col-sm-4 terms-and-conditions">
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
                            <div class="row">
                                <div class="col-xl-8 col-lg-7 col-md-7 col-sm-7 clearfix">
                                    <b><?php _trans('lable356'); ?>: </b>
                                </div>
                                <div class="col-xl-4 col-lg-5 col-md-5 col-sm-5 price clearfix">
                                    <?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code'));?> &nbsp;<b class="total_product_invoice">0.00</b>
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
                        <a class="btn btn-rounded btn-primary" target="_blank" href="<?php echo site_url('spare_quotes/generate_pdf/'.$quotes_detail->quote_id); ?>">
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
    $(document).ready(function() {

        if ($('#customer_id').val() != '') {
            $('.addcarpopuplink').show();
        } else {
            $('.addcarpopuplink').hide();
        }

        $("#btn_cancel").click(function() {
            window.location.href = "<?php echo site_url('spare_quotes'); ?>";
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

           

            $('.has-error').removeClass('has-error');
            $('.border_error').removeClass("border_error");
            $('#gif').show();

            $.post('<?php echo site_url('spare_quotes/ajax/quote_save'); ?>', {
                quote_status: quote_status,
                ex_quote_status: $("#ex_quote_status").val()?$("#ex_quote_status").val():'',
                quote_no: $('#quote_no').val()?$('#quote_no').val():'',
                branch_id: $("#branch_id").val()?$("#branch_id").val():'',
                invoice_group_id : $("#invoice_group_id").val()?$("#invoice_group_id").val():'',
                quote_id: $('#quote_id').val()?$('#quote_id').val():'',
                user_address_id: $('#user_address_id').val()?$('#user_address_id').val():'',
                quote_date: $('#quote_date').val()?$('#quote_date').val():'',
                customer_id: $('#customer_id').val()?$('#customer_id').val():'',
                product_items: JSON.stringify(product_items),
                product_totals: JSON.stringify(product_totals),
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
                        window.location = "<?php echo site_url('spare_quotes/view/'); ?>"+list.quote_id;
                    }, 1000);
                }else if (list.success == '2') {
                    $('#gif').hide();
                	notie.alert(3, '<?php _trans('toaster2'); ?>', 2);
                }else if (list.success == '3') {
                    $('#gif').hide();
                	notie.alert(3, '<?php _trans('toaster2'); ?>', 2);
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
                $('.add_address').attr('data-customer-id', $('#customer_id').val());
                $('#common_customer_id').val($('#customer_id').val());
                if (response.success == '1' || response.success == 1 ) {
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
                    $('#user_address_id').selectpicker("refresh");
                    if(response.customer_referrence.length > 0){
                        $('#gif').hide();
                        $("#refered_by_type").val(response.customer_referrence[0].refered_by_type).trigger("change");
                        setTimeout(function(){ 
                            $("#refered_by_id").val(response.customer_referrence[0].refered_by_id).trigger("change");
                        }, 1000);
                    }
                }
            });
        });

        $('#refered_by_type').change(function() {
            var refered_by_type = $('#refered_by_type').val();
            if (refered_by_type == '1' || refered_by_type == '2') {
                if (refered_by_type == '1') {
                    var site_url = "<?php echo site_url('clients/ajax/get_client_list'); ?>";
                } else if (refered_by_type == '2') {
                    var site_url = "<?php echo site_url('mech_employee/ajax/get_employee_list'); ?>";
                }
                $('#gif').show();
                $.post(site_url, {
                    customer_id : $("#customer_id").val()?$("#customer_id").val():'',
                    refered_by_type: $('#refered_by_type').val(),
                    _mm_csrf: $('#_mm_csrf').val()
                },
                function(data) {
                    var response = JSON.parse(data);
                    carResponse = response;
                    var rid = '';
                    var name = '';
                    var phone = '';
                    $('#refered_by_id').empty();
                    if (refered_by_type == '1') {
                        $('#gif').hide();
                        $('#refered_by_id').append($('<option></option>').attr('value', '').text('Select Customer'));
                    } else if (refered_by_type == '2') {
                        $('#gif').hide();
                        $('#refered_by_id').append($('<option></option>').attr('value', '').text('Select Employee'));
                    }
                    if (response.length > 0) {
                        for (row in response) {
                            if (refered_by_type == '1') {
                                $('#gif').hide();
                                rid = response[row].client_id;
                                name = response[row].client_name;
                                phone = response[row].client_contact_no;
                            } else if (refered_by_type == '2') {
                                $('#gif').hide();
                                rid = response[row].employee_id;
                                name = response[row].employee_name;
                                phone = response[row].mobile_no;
                            }
                            $('#refered_by_id').append($('<option></option>').attr('value', rid).text((name?name:'') + ' ' + phone));
                        }
                        $('#refered_by_id').selectpicker("refresh");
                    } else {
                        $('#gif').hide();
                        $('#refered_by_id').selectpicker("refresh");
                    }
                });
            } else {
                $('#gif').hide();
                console.log('refered_by_type else');
            }
        });

        $("#reset_filter").click(function(){
            $("#brand_id").val('');
            $('#brand_id').selectpicker("refresh");
            $("#model_id").val('');
            $('#model_id').selectpicker("refresh");
            $("#variant_id").val('');
            $('#variant_id').selectpicker("refresh");
            $("#fuel_type").val('');
            $('#fuel_type').selectpicker("refresh");
            $("#product_category_id").val(0);
            $('#product_category_id').selectpicker("refresh");
            $("#product_brand_id").val(0);
            $('#product_brand_id').selectpicker("refresh");
            $('#services_item_product_id').val(0);
            $('#services_item_product_id').selectpicker("refresh");
        });
    });
</script> 
