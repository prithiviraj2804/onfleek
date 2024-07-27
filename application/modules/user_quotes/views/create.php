<style type="text/css">
#product_item_table input {
    padding-left: 0px;
    padding-right: 0px;
}
</style>
<script type="text/javascript">
var getServiceDetailsURL = '<?php echo site_url('mechanic_service_item_price_list/ajax/get_service_details'); ?>';
var getProductDetailsURL = '<?php echo site_url('products/ajax/get_product_details'); ?>';

$(function () {
    $('#btn-cancel').click(function () {
        <?php if($url_from == 'q'){ ?>
            window.location = "<?php echo site_url('user_quotes'); ?>";
        <?php }elseif($url_from == 'r'){ ?>
            window.location = "<?php echo site_url('user_quotes/status/request'); ?>";
        <?php }elseif($url_from == 'p'){ ?>
            window.location = "<?php echo site_url('user_quotes/status/pending'); ?>";
        <?php }elseif($url_from == 'app'){ ?>
            window.location = "<?php echo site_url('user_appointments'); ?>";
        <?php } ?>
            
     });
});
</script>
<script src="<?php echo base_url(); ?>assets/mp_backend/js/invoice.js"></script>
<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell" id="total_user_quote">
                    <h3>Create Quote <?php if($quote_detail->appointment_no) { echo " - ".$quote_detail->appointment_no; } ?></h3>
                </div>
                
            </div>
        </div>
    </div>
</header>
<div class="container-fluid">
    <section class="card">
        <div class="card-block invoice">
            <div class="row invoice-company_details">
                <div class="col-lg-12">
                    <div class="company_logo">
                        <?php $company_details = $this->mdl_workshop_branch->get_company_branch_details(); 
                        if($company_details->workshop_logo){ ?>
                        <img src="<?php echo base_url(); ?>uploads/workshop_logo/<?php echo $company_details->workshop_logo; ?>" width="300" height="100" alt="<?php echo $company_details->workshop_name; ?>">
                        <?php } ?>
                    </div>
                    <div class="clearfix company_address">
                        <div class="text-lg-right">
                            <h4><?php echo $company_details->workshop_name; ?></h4>
                            <span>
                                <?php if($company_details->branch_street){ echo $company_details->branch_street; }
                                if($company_details->area_name){ echo ", ".$company_details->area_name; }
                                if($company_details->state_name){ echo ", ".$company_details->state_name; }
                                if($company_details->branch_pincode){ echo " - ".$company_details->branch_pincode; }
                                if($company_details->branch_country == 101){ echo ", India"; }
                                ?>
                            </span>
                            <?php if($company_details->branch_contact_no){ echo '<span>'.$company_details->branch_contact_no.'</span>'; } ?>
                            <?php if($company_details->branch_email_id){ echo '<span>'.$company_details->branch_email_id.'</span>'; } ?>
                            <?php if($company_details->branch_gstin){ echo '<span>'.$company_details->branch_gstin.'</span>'; } ?>
                        </div>   
                    </div>
                </div>
            </div>
            <div class="row m-b-1">
                <div class="col-lg-4 invoice_customer_details customerListDropDown " id="customerListDropDown">
                    <input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                    <input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo $invoice_id; ?>" />
                    <input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $quote_detail->invoice_no; ?>" />
                    <input type="hidden" name="quote_id" id="quote_id" value="<?php echo $quote_detail->quote_id; ?>" />
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $quote_detail->customer_id; ?>" />
                    <input type="hidden" name="car_brand_id" id="car_brand_id" value="<?php echo $quote_detail->car_brand_id; ?>" />
                    <input type="hidden" name="car_brand_model_id" id="car_brand_model_id" value="<?php echo $quote_detail->car_brand_model_id; ?>" />
                    <input type="hidden" name="brand_model_variant_id" id="brand_model_variant_id" value="<?php echo $quote_detail->brand_model_variant_id; ?>" />
                    <strong>Invoice To:</strong>
                    <select name="customer_id" id="customer_id" class="bootstrap-select bootstrap-select-arrow customerList " data-live-search="true">
                        <option value="">Select Customer</option>
                        <?php foreach ($customer_list as $customer){
                            if(count($quote_detail) > 0){
                                if($quote_detail->customer_id == $customer->client_id){
                                    $selected = 'selected="selected"';
                                }else{
                                    $selected = '';
                                }
                            }else{
                                $selected = '';
                            }
                            ?>
                            <option value="<?php echo $customer->client_id; ?>" <?php echo $selected; ?>><?php echo $customer->client_name."(".$customer->client_contact_no.")";  ?></option>
                        <?php } ?>
                    </select>
                    <div class="col-lg-12" style="padding-left:0px;">
						<a style="margin-bottom: 15px;float: left" href="javascript:void(0)" data-toggle="modal" data-model-from="quote" data-target="#addNewCar" class="add_client_page">
                            + Add Customer
                        </a>
                    </div>
                </div>      
                <div class="col-lg-4 invoice_customer_details">
                    <strong>Vehicle Details:</strong>
                    <select name="user_car_list_id" id="user_car_list_id" class="bootstrap-select bootstrap-select-arrow" data-live-search="true">
                        <option value="">Select Customer Vehicle</option>
                    </select>
                    <div class="col-lg-12" style="padding-left:0px;" >
                        <a style="margin-bottom: 15px; float: left;display:none;" href="javascript:void(0)" data-toggle="modal" data-model-from="quote"  data-target="#addNewCar" class="add_car addcarpopuplink ">+ ADD A NEW VECHICLE</a>
         			</div>
                </div>
                        
                        <!--div class="col-lg-4 invoice_customer_details">
                            <?php if ($quote_detail->invoice_no) {
                                    ?>
                                    <strong>Invoice No : <?php echo $quote_detail->invoice_no; ?></strong>
                            <?php
                                } ?>
                            <span>Job Card No : <?php echo $quote_detail->appointment_no; ?></span>
                            <?php if ($quote_detail->appointment_book_date) {
                                    echo '<span>Appointment Date : '.$quote_detail->appointment_book_date.' '.$quote_detail->appointment_book_time.'</span>';
                                } ?>
                        </div-->
                    </div>  
                    <?php $this->layout->load_view('user_quotes/partial_service_table'); ?>
                    <?php $this->layout->load_view('user_quotes/partial_product_table'); ?>
                    
                    <div class="row m-b-3">
                        <div class="col-lg-12">
                        <div class="col-lg-6 terms-and-conditions">
                            <div class="row m-b-3">
                            <strong>Terms and Conditions</strong><br>
                            Thank you for your business. We do expect payment within 21 days, so please process this invoice within that time. There will be a 1.5% interest charge per month on late invoices.
                            </div>
                            <div class="row m-b-3">
                            	<input type="checkbox" name="confirm_booking" id="confirm_booking" />
                            <strong>Appointment details</strong><br>
                           </div>
                            <?php /* * / ?>
                            <div class="row">
                            <strong>Bank Details</strong>
                            <table class="invoice_bank_details">
                                <tr><td>Bank Name </td><td> : ICICI Bank</td></tr>
                                <tr><td>Account Holder Name </td><td> : Bank User</td></tr>
                                <tr><td>Account Number </td><td> : 1234567890</td></tr>
                                <tr><td>Bank Branch </td><td> : chennai</td></tr>
                                <tr><td>Bank IFSC </td><td> : ICICI00000</td></tr>
                            </table>
                            
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-7"><br>  
                                    <b> User Requested Update</b><br><br>
                                    <select id="userrequpdate" name="userrequpdate">
                                        <option <?php if($quote_detail->request_admin_update == 0) echo "selected" ?> value="0">Yet To Start</option>
                                        <option <?php if($quote_detail->request_admin_update == 1) echo "selected" ?> value="1">In Progress</option>
                                        <option <?php if($quote_detail->request_admin_update == 2) echo "selected" ?> value="2">After Service</option>
                                        <option <?php if($quote_detail->request_admin_update == 3) echo "selected" ?> value="3">Price updated</option>
                                    </select>
                                </div>
                            </div><?php / * */ ?>
                        <div id="book_tab" class="col-lg-12 clearfix" style="display: none">
                        	<div class="row">
                        	<div class="col-lg-7 clearfix">
                                        <b> <u>Book Appointment</u></b>
                                    </div>
                                    <div class="col-lg-5 price clearfix"> 
                                        
                                    </div>
                            </div>

                             <div class="row">
                                
                                    <div class="col-sm-6">
                                        <div class="form-group visit_type_div">
                                            <label class="form-label zip-code">Odometer Reading *</label>
                                            
                                               <input class="input col-sm-12" type="text" id="current_odometer_reading" name="current_odometer_reading">
                                            
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label zip-code">Fuel Level *</label>
                                            <div class="input-group">
                                              <select class="bootstrap-select bootstrap-select-arrow" name="pickup_address" id="fuel_level">
                                                    <?php for ($i = 0; $i<20; $i+=0.5 ) { ?>
                                                        <option value="<?php echo $i ?>"> <?php echo  $i ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div class="row">
                            	
                                    <div class="col-sm-6">
                                        <div class="form-group visit_type_div">
                                            <label class="form-label zip-code">Visit Type*</label>
                                            <div class="input-group">
                                                <input type="radio" name="visit_type" <?php echo $visit_type_a; ?> id="visit_type_a" value="A" class="form-control textbox_padding_15"><label>Appointment</label>
                                            </div>
                                            <div class="input-group">   
                                                <input type="radio" name="visit_type" <?php echo $visit_type_w; ?> id="visit_type_w" value="W" class="form-control textbox_padding_15"><label>Walk IN</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label zip-code">Pick Up</label>
                                            <div class="input-group">
                                                <input type="checkbox" name="is_pickup" <?php echo $is_pickup; ?> id="is_pickup" value="1" class="form-control textbox_padding_15">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            <div class="row" id="appointment_detail_div" style="display: none">
                                        <div class="col-sm-12">
                                            <label class="form-label section-header-text">Select the time of your appointment</label>
                                        </div>
                                    <div class="col-sm-12">         
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class='input-group date datetimepicker-1'>
                                            <input type="text" class="form-control" id="appointment_book_date" name="appointment_book_date" value="<?php if (count($quote_detail) > 0) {
                                    echo ($quote_detail->appointment_book_date) ? date_from_mysql($quote_detail->appointment_book_date) : '';
                                } ?>" />
                                        <span class="input-group-addon">
                                            <i class="font-icon font-icon-calend"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class='input-group date datetimepicker-2'>
                                            <input type="text" class="form-control" id="appointment_book_time" name="appointment_book_time" value="<?php if (count($quote_detail) > 0) {
                                    echo $quote_detail->appointment_book_time;
                                } ?>" />
                                        <span class="input-group-addon">
                                            <i class="font-icon font-icon-clock"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                </div>
                                <div id="pick_details_div" style="display: none">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label section-header-text">Pick Up Address</label>
                                            <div class="input-group select-ur-car">
                                                <div class="input-group-addon textbox_padding_15">
                                                    <span class="glyphicon glyphicon-home"></span>
                                                </div>
                                                <select class="bootstrap-select bootstrap-select-arrow" name="pickup_address" id="pickup_address">
                                                    <?php foreach ($user_address_list as $address) {
                                    if (count($quote_detail) > 0) {
                                        if ($quote_detail->pickup_address == $address->user_address_id) {
                                            $selected = 'selected="selected"';
                                        } else {
                                            $selected = '';
                                        }
                                    } else {
                                        $selected = '';
                                    } ?>
                                                        <option value="<?php echo $address->user_address_id; ?>" <?php echo $selected; ?>><?php echo $address->full_address.', '.$address->zip_code; ?></option>
                                                    <?php
                                } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#addAddress" data-customer-id="" class="add_address">Add Address</a>
                                <div class="row">
                                        <div class="col-sm-12">
                                            <label class="form-label section-header-text">Select Pick Date &amp; Time</label>
                                        </div>
                                    <div class="col-sm-12">         
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class='input-group date datetimepicker-1'>
                                            <input type="text" class="form-control" id="pickup_date" name="pickup_date" value="<?php if (count($quote_detail) > 0) {
                                    echo ($quote_detail->pickup_date) ? date_from_mysql($quote_detail->pickup_date) : '';
                                } ?>" />
                                        <span class="input-group-addon">
                                            <i class="font-icon font-icon-calend"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class='input-group date datetimepicker-2'>
                                            <input type="text" class="form-control" id="pickup_time" name="pickup_time" value="<?php if (count($quote_detail) > 0) {
                                    echo $quote_detail->pickup_time;
                                } ?>" />
                                        <span class="input-group-addon">
                                            <i class="font-icon font-icon-clock"></i>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                             </div>
                             
                        </div>
                        </div>
                        
                        <div class="col-lg-5 clearfix" style="float: right">
                            <div class="total-amount row" style="float: left;width: 100%`">
                                
                                <div class="row">
                                    <div class="col-lg-7 clearfix">
                                        <b> Service </b>
                                    </div>
                                    <div class="col-lg-5 price clearfix"> 
                                        
                                    </div>
                                </div>  
                                <?php /* * / ?>
                                <div class="row">
                                    <div class="col-lg-7 clearfix">
                                        Mech - Service amount:
                                    </div>
                                    <div class="col-lg-5 price clearfix">
                                        <b class="total_service_mech_price"></b>
                                    </div>
                                </div>
                                <?php / * */ ?>
                                <div class="row">
                                    <div class="col-lg-7 clearfix">
                                        Total:
                                    </div>
                                    <div class="col-lg-5 price clearfix"> 
                                        <b class="total_user_service_price"></b>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 clearfix">
                                    Discount: 
                                    </div>
                                    <div class="col-lg-3">
                                        <input onkeyup="overall_invoice_calc()" type="text" value="<?php echo $quote_detail->service_total_discount_pct; ?>" size="3" maxlength="3"  name="service_discount" id="service_discount">
                                        <span>%</span>
                                    </div>
                                    <div class="col-lg-5 price clearfix">
                                        <b class="service_total_discount"><?php echo $quote_detail->service_total_discount; ?></b>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-7 clearfix">
                                        Taxable Amount:
                                    </div>
                                    <div class="col-lg-5 price clearfix"> 
                                        <b class="total_user_service_taxable"></b>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4 clearfix">
                                         GST:  
                                    </div>
                                    <div class="col-lg-3">
                                        <select onchange="overall_invoice_calc()" id="total_service_tax" name="total_service_tax">
                                            <option <?php if ($quote_detail->service_total_gst_pct == 0) {
                                    echo 'selected';
                                } ?> value="0"> 0% </option>
                                            <option <?php if ($quote_detail->service_total_gst_pct == 18) {
                                    echo 'selected';
                                } ?> value="18"> 18% </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-5 price clearfix">
                                        <b class="total_servie_gst_price"><?php echo $quote_detail->service_total_gst; ?></b>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-9 clearfix">
                                        <b>Service Grand Total: </b>
                                    </div>
                                    
                                    <div class="col-lg-3 price clearfix"  style="border-top:1px solid #000; margin-top: 5px">
                                        <b class="total_servie_invoice"></b>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-7 clearfix">
                                        <b> Product </b>
                                    </div>
                                    <div class="col-lg-5 price clearfix"> 
                                        
                                    </div>
                                </div>  

                                
                                <?php /* * / ?>
                                <div class="row">
                                    <div class="col-lg-7 clearfix">
                                        Mech - Product amount:
                                    </div>
                                    <div class="col-lg-5 price clearfix">
                                        <b class="total_product_mech_price"></b>
                                    </div>
                                </div>
                                <?php / * */ ?>
                                <div class="row">
                                    <div class="col-lg-7 clearfix">
                                     Total:
                                    </div>
                                    <div class="col-lg-5 price clearfix">
                                        <b class="total_user_product_price"></b>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-7 clearfix">
                                         Discount :
                                    </div>
                                    <div class="col-lg-5 price clearfix">
                                        <b class="product_total_discount"></b>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-7 clearfix">
                                         Taxable Amount:
                                    </div>
                                    <div class="col-lg-5 price clearfix">
                                        <b class="total_user_product_taxable"></b>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-7 clearfix">
                                         GST:
                                    </div>
                                    <div class="col-lg-5 price clearfix">
                                        <b class="total_user_product_gst"></b>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-7 clearfix">
                                        <b>Product Grand Total:</b>
                                    </div>
                                    <div class="col-lg-5 price clearfix" style="border-top:1px solid #000; margin-top: 5px">
                                        <b class="total_product_invoice"></b>
                                    </div>
                                </div>

                                <br>

                                <div class="row">
                                    <div class="col-lg-9 clearfix">
                                         <b>Total Taxable Amount</b> <br>(Service Total + Product Total)
                                    </div>
                                    <div class="col-lg-3 price clearfix">
                                        <b class="total_taxable_amount"></b>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-9 clearfix">
                                         <b> GST </b><br>(Service GST + Product GST)
                                    </div>
                                    <div class="col-lg-3 price clearfix">
                                        <b class="total_gst_amount"></b>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-9 clearfix">
                                        <b> Grand Total</b><br> (Total Service amt + Total Product Amount)
                                    </div>
                                    <div class="col-lg-3 price clearfix" style="border-top:1px solid #000; margin-top: 5px">
                                        <b class="grand_total"></b>
                                    </div>
                                </div>
                                
                                <br>
                                </div>
                                </div>
                            </div>
                        </div>
                            <div class="row">
                                <div class="col-lg-12 clearfix buttons text-right">
                                        <div class="buttons">
                                            <input type="hidden" name="existing_invoice_status" id="existing_invoice_status" value="<?php echo $quote_detail->invoice_status; ?>" />
                                            <button id="btn_submit" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40 createquote" value="1">
                                                <i class="fa fa-check"></i> Save quote</button>
                                            <button name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40 createquote" value="2">
                                                <i class="fa fa-check"></i> Save &amp; create job</button>
                                            
                                            <button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default" value="1">
                                                <i class="fa fa-times"></i> Cancel</button>
                                        </div>
                                        </div>
                                    </div>
                        </div>
                    </div>
                
            </section>
        </div>
        
        
            <!--.box-typical-->
        </div><!--.container-fluid-->
        <script type="text/javascript">

        var carResponse;
            
        $(document).ready(function(){

        $("#user_car_list_id").change(function(){
            var selected = this.value;
            var selectCar = carResponse.find(function(car){
                return car.car_list_id == selected;
            });
            //console.log(selectCar);
            $("#car_brand_id").val(selectCar.car_brand_id);
            $("#car_brand_model_id").val(selectCar.car_brand_model_id);
        });    

		$("input[name=visit_type]").click(function(){
			if($("input[name=visit_type]:checked").is(":checked")){
				if($("input[name=visit_type]:checked").val() == "A"){
					 $("#appointment_detail_div").show();
                        
                        $('#appointment_book_date').datetimepicker({
                            format: 'YYYY-MM-DD',
                        });
                        $('#appointment_book_time').datetimepicker({
                            format: 'HH:mm a',
                        });
                        

				} else if($("input[name=visit_type]:checked").val() == "W"){
					$("#appointment_detail_div").hide();
				}
			}
		})
		
		$("input[name=is_pickup]").click(function(){
			if($("input[name=is_pickup]:checked").is(":checked")){
				$("#pick_details_div").show();
                $('#pickup_date').datetimepicker({
                    format: 'YYYY-MM-DD',
                });
    
                $('#pickup_time').datetimepicker({
                    format: 'HH:mm a',
                });

                $.post("<?php echo site_url('user_address/ajax/get_customer_q_address'); ?>",{
                    customer_id: $('#customer_id').val(),
                    _mm_csrf: $('#_mm_csrf').val()
                },function(data){
                    var response = JSON.parse(data);
                    if (response.length > 0) {
                       $('#pickup_address').empty(); // clear the current elements in select box
                       $('#pickup_address').append($('<option></option>').attr('value', '').text('Select Customer Address'));
                        for (row in response) {
                            var variant_name = (response[row].variant_name)?response[row].variant_name:'';
                            $('#pickup_address').append($('<option></option>').attr('value', response[row].user_address_id).text(response[row].full_address+' '+response[row].zip_code));
                        }
                        $('#pickup_address').selectpicker("refresh");
                    }
                    else {
                       $('#pickup_address').empty(); // clear the current elements in select box
                       $('#pickup_address').append($('<option></option>').attr('value', '').text('Select Customer Address'));
                        $('#pickup_address').selectpicker("refresh");
                    }
                })
			} else{
				$("#pick_details_div").hide();
			}
		})
		
		
        $("#confirm_booking").click(function(){
        	if($(this).is(':checked')){
        		$("#book_tab").show(500);
        		$("#visit_type_w").prop('checked',true);
        	}else{
        		$("#book_tab").hide(500);
        		$("#visit_type_w").prop('checked',false);
        	}
        });
        $('#customer_id').change(function () {
            
            $.post("<?php echo site_url('user_cars/ajax/get_customer_cars'); ?>", {
                    customer_id: $('#customer_id').val(),
                    _mm_csrf: $('#_mm_csrf').val()
                },
                function (data) {
                    var response = JSON.parse(data);
                    carResponse = response;
                    //console.log(response);
                    $('.add_car').attr('data-customer-id', $('#customer_id').val());
                    $('.add_address').attr('data-customer-id', $('#customer_id').val());
                    $('#common_customer_id').val($('#customer_id').val());
                    if($('#customer_id').val() != '' || $('#customer_id').val() != '0' ){
                        $('.addcarpopuplink').show();
                    }
                   
                    if (response.length > 0) {
                       $('#user_car_list_id').empty(); // clear the current elements in select box
                       $('#user_car_list_id').append($('<option></option>').attr('value', '').text('Select Customer Vehicle'));
                        for (row in response) {
                            //console.log(response[row]);
                            var variant_name = (response[row].variant_name)?response[row].variant_name:'';
                            $('#user_car_list_id').append($('<option></option>').attr('value', response[row].car_list_id).text(response[row].brand_name+' '+response[row].model_name+' '+variant_name+' ('+response[row].car_reg_no+')'));
                        }
                        $('#user_car_list_id').selectpicker("refresh");
                    }
                    else {
                       $('#user_car_list_id').empty(); // clear the current elements in select box
                       $('#user_car_list_id').append($('<option></option>').attr('value', '').text('Select Customer Vehicle'));
                        $('#user_car_list_id').selectpicker("refresh");
                    }
                });
            });
        
        

        
        $("#btn_cancel").click(function () {
            window.location.href = "<?php echo site_url('mech_invoices'); ?>";
        });


        
        $(".createquote").click(function () {
            var type = this.value;
            if(type == 2 && !$("input[name=confirm_booking]").is(':checked')){
            	notie.alert(3, 'Please fill the appointment details', 2);
            	return false;
            }
            var service_items = [];
            $('table#service_item_table tbody>tr.item').each(function () {
                var service_row = {};
                $(this).find('input,select,textarea').each(function () {
                    if ($(this).is(':checkbox')) {
                        service_row[$(this).attr('name')] = $(this).is(':checked');
                    } else {
                        service_row[$(this).attr('name')] = $(this).val();
                    }
                });
                service_items.push(service_row);
            });
            
            var product_items = [];
            $('table#product_item_table tbody>tr.item').each(function () {
                var product_row = {};
                $(this).find('input,select,textarea').each(function () {
                    if ($(this).is(':checkbox')) {
                        product_row[$(this).attr('name')] = $(this).is(':checked');
                    } else {
                        product_row[$(this).attr('name')] = $(this).val();
                    }
                });
                product_items.push(product_row);
            });
            
            var product_totals = [];
            $('table#product_item_table .product_total_calculations').each(function () {
                var product_total_row = {};
                $(this).find('input,select,textarea').each(function () {
                    if ($(this).is(':checkbox')) {
                        product_total_row[$(this).attr('name')] = $(this).is(':checked');
                    } else {
                        product_total_row[$(this).attr('name')] = $(this).val();
                    }
                });
                product_totals.push(product_total_row);
            });
            
            var service_totals = [];
            $('table#service_item_table .service_total_calculations').each(function () {
                var service_total_row = {};
                $(this).find('input,select,textarea').each(function () {
                    if ($(this).is(':checkbox')) {
                        service_total_row[$(this).attr('name')] = $(this).is(':checked');
                    } else {
                        service_total_row[$(this).attr('name')] = $(this).val();
                    }
                });
                service_totals.push(service_total_row);
            });
            var invoice_status = $(this).val();
            $.post('<?php echo site_url('user_quotes/ajax/invoice_create'); ?>', {
                    book_type : type,
                    quote_id : $('#quote_id').val(),
                    user_id : $('#user_id').val(),
                    car_brand_id : $('#car_brand_id').val(),
                    car_brand_model_id : $('#car_brand_model_id').val(),
                    brand_model_variant_id : $('#brand_model_variant_id').val(),
                    product_items: JSON.stringify(product_items),
                    service_items : JSON.stringify(service_items),
                    product_totals : JSON.stringify(product_totals),
                    service_totals : JSON.stringify(service_totals),
                    service_discount_pct:$("#service_discount").val(),
                    service_total_discount:$(".service_total_discount").html(),
                    service_tax_pct:$("#total_service_tax").val(),
                    total_servie_gst_price:$(".total_servie_gst_price").html(),
                    total_service_amount:$(".total_servie_invoice").html(),
                    service_total_taxable:$('.total_user_service_taxable').html(),
                    product_total_taxable:$('.total_user_product_taxable').html(),
                    total_taxable_amount:$(".total_taxable_amount").html(),
                    total_tax_amount:$('.total_gst_amount').html(),
                    total_due_amount:$(".grand_total").html(),
                    customer_car_id:$("#user_car_list_id").val(),
                    customer_id:$("#customer_id").val(),
                    pickup_address_id:$("#pickup_address").val(),
                    delivery_address_id:$("#drop_address").val(),
                    fuel_level:$("#fuel_level").val(),
                    //current_odometer_reading
                    //userrequpdate:$("#userrequpdate").val(),
                    appointment_grand_total:$(".grand_total").html(),
                    current_odometer_reading:$("#current_odometer_reading").val(),
                    appointment_book_date:$("#appointment_book_date").val(),
                    appointment_book_time:$("#appointment_book_time").val(),
                    visit_type:$("input[name=visit_type]:checked").val(),
                    delivery_date:$("#appointment_book_time").val(),    
                    _mm_csrf: $('#_mm_csrf').val()
                }, function (data) {
                    list = JSON.parse(data);
                    if(list.success=='1'){
                            notie.alert(1, 'Job Card Created Successfully', 2);
                            return false;
                            /*
                            setTimeout(function(){ 
                                <?php if ($url_from == 'q') {
                                    ?>
                                        window.location = "<?php echo site_url('user_quotes'); ?>";
                                    <?php
                                } elseif ($url_from == 'r') {
                                    ?>
                                        window.location = "<?php echo site_url('user_quotes/status/current'); ?>";
                                    <?php
                                } elseif ($url_from == 'p') {
                                    ?>
                                        window.location = "<?php echo site_url('user_quotes/status/pending'); ?>";
                                    <?php
                                } ?>
            
                            }, 1000); 
                            */
                    }else{
                        notie.alert(3, 'Something went wrong...', 2);
                        /*
                            setTimeout(function(){ 
                                location.reload();
                            }, 1000); */
                    }
                });
        });
     });
        </script>