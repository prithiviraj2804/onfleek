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
    var getServicePackageDetailsURL = '<?php echo site_url('service_packages/ajax/get_package_details'); ?>';
    var taxURL = '<?php echo site_url('mech_tax/ajax/gettaxDetails');?>';

    $(function() {
        $('#btn-cancel').click(function() {
            window.location = "<?php echo site_url('mech_pos_invoices'); ?>";
        });
    });
</script>
<script src="<?php echo base_url(); ?>assets/mp_backend/js/autocomplete_plugin.js"></script>
<script src="<?php echo base_url(); ?>assets/mp_backend/js/pos_invoice.js"></script>
<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell" id="total_user_quote">
                    <h3><?php _trans('lable1025'); ?><?php if ($invoice_detail->invoice_no) { echo ' - '.$invoice_detail->invoice_no; } ?></h3>
                </div>
                <div class="tbl-cell tbl-cell-action">
					<a href="<?php echo site_url('mech_pos_invoices/create'); ?>"  class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> <?php _trans('lable40'); ?></a>
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
		<a class="anchor anchor-back" onclick="goBack()" href="<?php echo site_url('mech_pos_invoices/index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
	</div>
</div>
<div class="container-fluid">
    <section class="card">
        <div class="card-block invoice">
            <div class="row invoice-company_details">
                <div class="col-lg-12">
                    <div class="company_logo col-lg-4">
                        <?php $company_details = $this->mdl_workshop_branch->get_company_branch_details();
                        if ($company_details->workshop_logo) { ?>
                        <img src="<?php echo base_url(); ?>uploads/workshop_logo/<?php echo $company_details->workshop_logo; ?>" width="150" height="150" alt="<?php echo $company_details->workshop_name; ?>">
                        <?php } ?>
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
                <input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                <input type="hidden" name="pos_invoice_id" id="pos_invoice_id" value="<?php echo $pos_invoice_id; ?>" />
                <input type="hidden" name="pos_invoice_no" id="pos_invoice_no" value="<?php echo $invoice_detail->pos_invoice_no; ?>" />
                <input type="hidden" name="refered_by_id" id="refered_by_id" value="<?php echo $invoice_detail->refered_by_id; ?>" />
                <input type="hidden" name="refered_by_type" id="refered_by_type" value="<?php echo $invoice_detail->refered_by_type; ?>" />

                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable149'); ?>*</label>
                    <div class="form_controls">
                        <select id="branch_id" name="branch_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" >
                            <?php foreach ($branch_list as $branchList) {?>
                            <option value="<?php echo $branchList->w_branch_id; ?>" <?php if($invoice_detail->branch_id == $branchList->w_branch_id){echo "selected";}?> > <?php echo $branchList->display_board_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable378'); ?>*</label>
                    <div class="form_controls">
                        <select name="invoice_group_id" id="invoice_group_id" <?php if($invoice_detail->invoice_status != 'D' && $invoice_detail->invoice_status != ''){ echo 'disabled'; } ?> class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                            <?php if(count($invoice_group)>1){ ?>
                            <option value="">Select Serial Number</option>
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
                    <label class="form_label"><?php _trans('lable368'); ?>*</label>
                    <div class="form_controls">
                        <input type="text" onchange="changeDueDatebyCreated('invoice_date','in_days','invoice_date_due')" name="invoice_date" id="invoice_date" class="form-control removeErrorInput datepicker" value="<?php echo $invoice_detail->invoice_date?date_from_mysql($invoice_detail->invoice_date):date_from_mysql(date('Y-m-d')); ?>">
                    </div>
                </div>
                <div class="row m-b-2" id="credit" <?php if($invoice_detail->is_credit == "Y"){ echo 'style="display:block;"';} else { echo 'style="display:none;"'; }?> >
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12" style="margin-left: 1%;">
                    <label class="form_label"><?php _trans('lable387'); ?></label>
                    <div class="form_controls">
                        <input type="text" onchange="changeDueDatebyDay('invoice_date','in_days','invoice_date_due')" name="in_days" id="in_days" class="form-control" value="<?php echo $invoice_detail->in_days; ?>">
                    </div>
                </div>
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"> <?php _trans('lable127'); ?></label>
                    <div class="form_controls">
                        <input type="text" onchange="changeCreditPeriodbyDueDate('invoice_date','in_days','invoice_date_due')" name="invoice_date_due" id="invoice_date_due" class="form-control datepicker" value="<?php echo $invoice_detail->invoice_date_due?date_from_mysql($invoice_detail->invoice_date_due):''; ?>">
                    </div>
                </div>         
            </div>
            </div>
            <div class="row">
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable421'); ?>*</label>
                    <div class="form_controls">
                        <form autocomplete="off" class="autocomplateinput">
                            <div class="autocomplete">
                                <input id="customer_name" onkeypress="customerName()" onclick="getCarName()" onselect="getCarName()" onchange="getCarName()" onblur="getCarName()" type="text" value="<?php echo $customer_name;?>" class="form-control" name="customer_name">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable422'); ?>*</label>
                    <div class="form_controls">
                        <select name="customer_car_id" id="customer_car_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                            <option value=""><?php _trans('lable423'); ?></option>
                            <?php foreach($user_cars as $key => $user_cars_list) { ?> 
                                <optgroup label="<?php echo $user_cars_list->brand_name; ?>" >
                                    <?php foreach($user_cars_list->model_list as $modelList){ 
                                        if (!empty($invoice_detail)) {
                                            if ($invoice_detail->customer_car_id == $modelList->model_id) {
                                                $selected = 'selected="selected"';
                                            } else {
                                                $selected = '';
                                            }
                                        } else {
                                            $selected = '';
                                        } ?>
                                        ?>
                                        <option value="<?php echo $modelList->model_id;?>" <?php echo $selected;?>><?php echo $modelList->model_name;?></option>
                                    <?php } ?>
                                </optgroup>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable883'); ?></label>
                    <div class="form_controls">
                        <select name="is_credit" id="is_credit" <?php if($invoice_detail->is_credit != "" && $invoice_detail->invoice_status != 'D' && $invoice_detail->invoice_status != ''){ echo 'disabled'; } ?> class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                            <option value=""><?php _trans('lable382'); ?></option>
                            <option value="Y" <?php if($invoice_detail->is_credit == "Y"){echo "selected";}?>><?php _trans('lable522'); ?></option>
                            <option value="N" <?php if($invoice_detail->is_credit == "N"){echo "selected";}?>><?php _trans('lable538'); ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row m-b-2">
                <?php if($this->session->userdata('is_shift') == 1){ ?>
                    <input type="hidden" value="<?php echo $invoice_detail->shift?$invoice_detail->shift:1;?>" id="shift" name="shift">
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
            </div>
            <div class="row m-b-2" id="paid" <?php if($invoice_detail->is_credit == "N"){ echo 'style="display:block;"';} else { echo 'style="display:none;"'; }?> >
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable109'); ?></label>
                    <div class="form_controls">
                        <select id="payment_method_id" name="payment_method_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" <?php if($invoice_detail->is_credit != "" && $invoice_detail->invoice_status != 'D' && $invoice_detail->invoice_status != ''){ echo 'disabled'; } ?> >
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
                    <input type="text" name="cheque_no" id="cheque_no" <?php if($invoice_detail->is_credit == "N" && $invoice_detail->invoice_status != 'D' && $invoice_detail->invoice_status != ''){ echo 'readonly'; } ?> class="form-control car_reg_no" value="<?php echo $invoice_detail->cheque_no; ?>">    
                    </div>
                </div> 
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12 showChequeDetailBoxs" style="display:none;">
                    <label class="form_label"><?php _trans('lable756'); ?>*</label>
                    <div class="form_controls">
                    <input type="text" name="cheque_to" id="cheque_to" <?php if($invoice_detail->is_credit == "N" && $invoice_detail->invoice_status != 'D' && $invoice_detail->invoice_status != ''){ echo 'readonly'; } ?> class="form-control" value="<?php echo $invoice_detail->cheque_to; ?>">    
                    </div>
                </div> 
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12 showChequeDetailBoxs" style="display:none;">
                    <label class="form_label"><?php _trans('lable99'); ?>*</label>
                    <div class="form_controls">
                    <input type="text" name="bank_name" id="bank_name" <?php if($invoice_detail->is_credit == "N" && $invoice_detail->invoice_status != 'D' && $invoice_detail->invoice_status != ''){ echo 'readonly'; } ?> class="form-control" value="<?php echo $invoice_detail->bank_name; ?>">    
                    </div>
                </div> 
                <div class="form_group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label class="form_label"><?php _trans('lable117'); ?></label>
                    <div class="form_controls">
                    <input type="text" name="online_payment_ref_no" id="online_payment_ref_no" class="form-control" value="<?php echo $invoice_detail->online_payment_ref_no; ?>">    
                    </div>
                </div>              
            </div>
            
            <?php if($is_product == "Y"){ ?>
            <?php $this->layout->load_view('mech_pos_invoices/partial_product_table'); ?>
            <?php } ?>
            <?php $this->layout->load_view('mech_pos_invoices/partial_service_table'); ?>
			<?php $this->layout->load_view('mech_pos_invoices/partial_service_package_table'); ?>
            <div class="row m-b-3">
                <div class="col-lg-12">
                    <div class="col-lg-5 col-md-5 col-sm-12 terms-and-conditions">
                        <div class="row">
                            <strong><?php _trans('lable388'); ?></strong><br>
                            <?php _trans('lable389'); ?>
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
                                    <select class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" name="bank_id" id="bank_id">
                                        <option value=""><?php echo trans('lable390'); ?></option>
                                        <?php foreach($bank_dtls as $bank){ ?>
                                        <option value="<?php echo $bank->bank_id; ?>" <?php if ($bank->bank_id == $invoice_detail->bank_id) { echo 'selected="selected"';  } ?>> <?php _htmlsc($bank->bank_name); ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-12 clearfix" style="float: right">
                        <div class="total-amount row" style="float: left;width: 100%`">

                            <div class="row">
                                <div class="col-lg-7 col-md-7 col-sm-7 clearfix">
                                    <b><?php _trans('lable356'); ?>:</b>
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-5 price clearfix">
                                    <?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<b class="total_product_invoice">0.00</b>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-9 col-md-9 col-sm-9 clearfix">
                                    <b><?php _trans('lable393'); ?>: </b>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 price clearfix">
                                <?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<b class="total_servie_invoice">0.00</b>
                                </div>
                            </div>

                           
                            <div class="row">
                                <div class="col-lg-9 col-md-9 col-sm-9 clearfix">
                                    <b><?php _trans('label960'); ?>: </b>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 price clearfix">
                                    <?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<b class="total_servie_package_invoice">0.00</b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-9 col-md-9 col-sm-9 clearfix">
                                    <b><?php _trans('lable332'); ?></b><br>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 price clearfix" style="border-top:1px solid #000; margin-top: 5px">
                                    <?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<b class="grand_total">0.00</b>
                                </div>
                                <input type="hidden" id="total_due_amount_save" name="total_due_amount_save" value="<?php echo $invoice_detail->total_due_amount;?>" autocomplete="off">
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
            <input id="invoice_status" type="hidden" value="<?php echo $invoice_detail->invoice_status;?>" autocomplete="off">
            
            <div class="row invoiceFloatbtn">
                <div class="col-lg-12 clearfix buttons text-right">
                    <?php if($invoice_detail->invoice_id){ ?>
                        <?php if($is_product == "Y"){ ?>
                        <a href="javascript:void(0)" data-toggle="modal" data-model_from="I" data-invoice_id="<?php echo $invoice_detail->invoice_id;?>" data-customer_id="<?php echo $invoice_detail->customer_id; ?>" data-vehicle_id="<?php echo $invoice_detail->customer_car_id; ?>" data-target="#addNewCar" class="add_recommended_product marginTopBot10px hideSubmitButtons btn btn-rounded btn-primary">
                            + <?php _trans('lable853'); ?>
                        </a>
                        <?php } ?>
                        <a href="javascript:void(0)" data-toggle="modal" data-model_from="I" data-invoice_id="<?php echo $invoice_detail->invoice_id;?>" data-customer_id="<?php echo $invoice_detail->customer_id; ?>" data-vehicle_id="<?php echo $invoice_detail->customer_car_id; ?>" data-target="#addNewCar" class="add_recommended_service marginTopBot10px hideSubmitButtons btn btn-rounded btn-primary">
                            + <?php _trans('lable395'); ?>
                        </a>
                    <?php } ?>
                    <?php
                     if ($invoice_detail->invoice_status != 'D' && $invoice_detail->invoice_status != '') {  ?>
                    <button id="btn_submit" name="btn_submit" class="btn_submit marginTopBot10px btn btn-rounded btn-primary" value="G">
                        <i class="fa fa-check"></i> <?php _trans('lable57'); ?></button>
                        <a class="btn btn-rounded marginTopBot10px btn-primary" target="_blank" href="<?php echo site_url('mech_pos_invoices/generate_thermal_pdf/'.$invoice_detail->invoice_id); ?>">
                            <i class="fa fa-edit fa-margin"></i> <?php _trans('lable420'); ?>
                        </a>
                        <a class="btn btn-rounded marginTopBot10px btn-primary" target="_blank" href="<?php echo site_url('mech_pos_invoices/generate_pdf/'.$invoice_detail->invoice_id); ?>">
                            <i class="fa fa-edit fa-margin"></i> <?php _trans('lable141'); ?>
                        </a>
                    <?php
                     } else {
                         ?>
                    <button id="btn_submit" name="btn_submit" class="btn_submit marginTopBot10px btn btn-rounded btn-primary" value="G">
                        <i class="fa fa-check"></i><?php _trans('lable376'); ?></button>
                    <button id="btn_submit" name="btn_submit" class="btn_submit marginTopBot10px btn btn-rounded btn-primary" value="D">
                        <i class="fa fa-check"></i> <?php _trans('lable57'); ?></button>
                    <?php
                     } ?>
                    <button id="btn_cancel" name="btn_cancel" class="btn btn-rounded marginTopBot10px btn-default" value="1">
                        <i class="fa fa-times"></i><?php _trans('lable58'); ?></button>
                </div>
            </div>
        </div>
</div>

</section>
</div>


<!--.box-typical-->
</div>

<script  type="text/javascript">

function getproductsByFilter(){

    // if($("#customer_car_id").val() == ''){
    //     notie.alert(3, '<?php // _trans('toaster5'); ?>', 2);
    //     $("#service_category_id").val(0);
    //     $('.bootstrap-select').selectpicker("refresh");
    //     return false;
    // }
    $('#gif').show();    
    $.post("<?php echo site_url('mech_item_master/ajax/getProductItemList'); ?>", {
        product_category_id: $('#product_category_id').val()?$('#product_category_id').val():'',
        product_brand_id: $("#product_brand_id").val()?$("#product_brand_id").val():'',
        user_car_list_id: $('#customer_car_id').val()?$('#customer_car_id').val():'',
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

function customerName(){
    var customer_name = $("#customer_name").val();
    if(customer_name.length > 3){
        $('#gif').show();
        $.post('<?php echo site_url('mech_pos_invoices/ajax/getcustomername'); ?>', {
            customer_name: customer_name,
            _mm_csrf: $('#_mm_csrf').val()
        }, function(data) {
            list = JSON.parse(data);
            if (list.success == '1') {
                $('#gif').hide();
                if(list.customernameList){
                    if(list.customernameList.length > 0){
                        // $('#gif').hide();
                        var customernameList = list.customernameList;
                        autocomplete(document.getElementById("customer_name"), customernameList);
                        getCarName();
                    }
                }
            }
        });
    }
}

function getCarName(){
    var customer_name = $("#customer_name").val();
    if(customer_name.length > 3){
        $.post("<?php echo site_url('user_cars/ajax/getCustomerCarsByName'); ?>", {
            customer_name: $("#customer_name").val(),
            _mm_csrf: $('#_mm_csrf').val()
        },
        function(data) {
            var response = JSON.parse(data);
            // console.log(response);
            if (response.success == 1) {
                $('#gif').hide();
                if(response.user_cars){
                    if(response.user_cars.length > 0){
                        $('#gif').hide();
                        var html = '';
                        html += '<option value="">Select</option>';
                        for( var i = 0; i < response.user_cars.length; i++) {
                            html += '<optgroup label="'+response.user_cars[i].brand_name+'">';
                            for(var j = 0; j < response.user_cars[i].model_list.length; j++){
                                html += '<option value="'+response.user_cars[i].model_list[j].model_id+'">'+response.user_cars[i].model_list[j].model_name+'</option>';
                            }
                            html += '</optgroup>';
                        }
                        $('#customer_car_id').empty().append(html);
                        if(response.user_cars[0].car_brand_model_id != '' && response.user_cars[0].car_brand_model_id != 'NULL' && response.user_cars[0].car_brand_model_id != null){
                            $('#gif').hide();
                            $('#customer_car_id').val(response.user_cars[0].car_brand_model_id);
                        }
                        $('#customer_car_id').selectpicker("refresh");
                        getrefereence(response.user_cars[0].owner_id);
                    }
                }
            } 
        });
    }
}

function getrefereence(customer_id){
    $.post("<?php echo site_url('clients/ajax/get_customer_cars_address'); ?>", {
        customer_id: customer_id,
        _mm_csrf: $('#_mm_csrf').val()
    },
    function(data) {
        var response = JSON.parse(data);
        if (response.success == '1' || response.success == 1 ) {
            $('#gif').hide();
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
}

</script>
<!--.container-fluid-->
<script type="text/javascript">

    $(document).ready(function() {

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

        $("#btn_cancel").click(function() {
            window.location.href = "<?php echo site_url('mech_pos_invoices'); ?>";
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

        $('#service_category_id').change(function () {

            // if($("#customer_car_id").val() == ''){
            //     notie.alert(3, '<?php // _trans('toaster5'); ?>', 2);
            //     $("#service_category_id").val(0);
            //     $('.bootstrap-select').selectpicker("refresh");
            //     return false;
            // }
            $('#gif').show();
            $.post("<?php echo site_url('mech_item_master/ajax/getServiceList'); ?>", {
                service_category_id: $('#service_category_id').val(),
                user_car_list_id: $('#customer_car_id').val(),
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


        $(".btn_submit").click(function() {

            $(".border_error").removeClass('border_error');
            $(".has-error").removeClass('has-error');

            var validation = [];

            if($("#branch_id").val() == ''){
                validation.push('branch_id');
            }

            if($("#invoice_group_id").val() == ''){
                validation.push('invoice_group_id');
            }

            if($("#customer_name").val() == ''){
                validation.push('customer_name');
            }

            if($("#customer_car_id").val() == ''){
                validation.push('customer_car_id');
            }

            if($("#invoice_date").val() == ''){
                validation.push('invoice_date');
            }

            if($("#is_credit").val() != ''){
                if($("#is_credit").val() == "N"){
                    if($("#payment_method_id").val() == ''){
                        validation.push('payment_method_id');
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
                    $('#'+val).parent().addClass('has-error');
                });
                return false;
            }

            var invoice_status = $(this).val();
            if(invoice_status == 'G'){
                if($("#invoice_group_id").val() == ''){
                    $('#invoice_group_id').parent().addClass('has-error');
                    return false;
                }else{
                    $('.has-error').removeClass('has-error');
                }
            }

            var service_items = [];
            $('table#service_item_table tbody>tr.item').each(function() {
                var service_row = {};
                $(this).find('input,select,textarea').each(function() {
                    if ($(this).is(':checkbox')) {
                        service_row[$(this).attr('name')] = $(this).is(':checked');
                    } else {
                        service_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
                    }
                });
                service_items.push(service_row);
            });

            var service_package_items = [];
            $('table#service_package_item_table tbody>tr.item').each(function () {
                var service_package_row = {};
                $(this).find('input,select,textarea').each(function () {
                    if ($(this).is(':checkbox')) {
                        service_package_row[$(this).attr('name')] = $(this).is(':checked');
                    } else {
                        service_package_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
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
                        service_package_total_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
                    }
                });
                service_package_totals.push(service_package_total_row);
            });

            var product_items = [];
            $('table#product_item_table tbody>tr.item').each(function() {
                var product_row = {};
                $(this).find('input,select,textarea').each(function() {
                        if ($(this).is(':checkbox')) {
                            product_row[$(this).attr('name')] = $(this).is(':checked');
                        } else {
                            product_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
                        }
                });
                product_items.push(product_row);
            });

            var product_totals = [];
            $('table#product_item_table .product_total_calculations').each(function() {
                var product_total_row = {};
                $(this).find('input,select,textarea').each(function() {
                    if ($(this).is(':checkbox')) {
                        product_total_row[$(this).attr('name')] = $(this).is(':checked');
                    } else {
                        product_total_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
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
                        service_total_row[$(this).attr('name')] = $(this).val().replace(/,/g, '');
                    }
                });
                service_totals.push(service_total_row);
            });

            $('.has-error').removeClass('has-error');
            $('.border_error').removeClass("border_error");
            $('#gif').show();

            $.post('<?php echo site_url('mech_pos_invoices/ajax/invoice_save'); ?>', {
                invoice_status: invoice_status,
                pos_invoice_no: $('#pos_invoice_no').val()?$('#pos_invoice_no').val():'',
                branch_id: $("#branch_id").val()?$("#branch_id").val():'',
                shift: 1,
                invoice_group_id: $("#invoice_group_id").val()?$("#invoice_group_id").val():'',
                pos_invoice_id: $('#pos_invoice_id').val()?$('#pos_invoice_id').val():'',
                refered_by_type: $("#refered_by_type").val()?$("#refered_by_type").val():'',
                refered_by_id: $("#refered_by_id").val()?$("#refered_by_id").val():'',
                customer_car_id: $('#customer_car_id').val()?$('#customer_car_id').val():'',
                customer_name: $("#customer_name").val()?$("#customer_name").val():'',
                invoice_date: $('#invoice_date').val()?$('#invoice_date').val():'',
                is_credit: $("#is_credit").val()?$("#is_credit").val():'N',
                payment_method_id: $("#payment_method_id").val()?$("#payment_method_id").val():'',
                cheque_no: $("#cheque_no").val()?$("#cheque_no").val().toUpperCase():'',
                cheque_to: $("#cheque_to").val()?$("#cheque_to").val():'',
                bank_name: $("#bank_name").val()?$("#bank_name").val():'',
                online_payment_ref_no: $("#online_payment_ref_no").val()?$("#online_payment_ref_no").val():'',
                invoice_date_created: $('#invoice_date').val()?$('#invoice_date').val():'',
                in_days: $("#in_days").val()?$("#in_days").val():'',
                invoice_date_due: $("#invoice_date_due").val()?$("#invoice_date_due").val():'',
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
                total_taxable_amount: $(".total_taxable_amount").html()?$(".total_taxable_amount").html().replace(/,/g, ''):0,
                total_tax_amount: $('.total_gst_amount').html()?$('.total_gst_amount').html().replace(/,/g, ''):0,
                total_due_amount: $(".grand_total").html()?$(".grand_total").html().replace(/,/g, ''):0,
                userrequpdate: $("#userrequpdate").val()?$("#userrequpdate").val():'',
                appointment_grand_total: $(".grand_total").html()?$(".grand_total").html().replace(/,/g, ''):0,
                bank_id: $('#bank_id').val()?$('#bank_id').val():'',
                description: $("#description").val()?$("#description").val():'',
                _mm_csrf: $('#_mm_csrf').val()
            }, function(data) {
                list = JSON.parse(data);
                if (list.success == '1') {
                    notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
                    setTimeout(function() {
                        window.location = "<?php echo site_url('mech_pos_invoices/view/'); ?>"+list.pos_invoice_id;
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
    });
</script> 
