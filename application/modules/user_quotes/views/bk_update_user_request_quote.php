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
<div class="container-fluid">
	<div class="container-fluid">
			<section class="card">
				<div class="card-block invoice">
					<div class="row">
						<div class="col-lg-6 company-info">
							<h5><?php _trans('mech_point');?></h5>
							

							<!--div class="invoice-block">
								<div>Plat no 13</div>
								<div>Jayanagar</div>
								<div>Medavakam</div>
							</div>

							<div class="invoice-block">
								<div>Telephone: 98419 67890</div>
								<div>kcsimbu@gmail.com</div>
							</div-->
							<div class="invoice-block">
								<h5><?php _trans('invoice_to');?>:</h5>
								<div><b><?php _trans('quote_no');?>: </b> : <?php echo $quote_detail->quote_no; ?></div>
								<?php if($appoinment_details) { ?>
									<div><b><?php _trans('appointment_no');?>: </b> : <?php echo $appoinment_details->appointment_no; ?></div>
								<?php } ?>	
								<div><?php echo $customer_details->client_name; ?></div>
								<div>
									
									<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
									<input type="hidden" name="quote_id" id="quote_id" value="<?php echo $quote_id; ?>" />
									<input type="hidden" name="user_id" id="user_id" value="<?php echo $quote_detail->customer_id; ?>" />
									<input type="hidden" name="car_brand_id" id="car_brand_id" value="<?php echo $quote_detail->customer_car_id; ?>" />
									<input type="hidden" name="car_brand_model_id" id="car_brand_model_id" value="<?php echo $quote_detail->car_brand_model_id; ?>" />
									<input type="hidden" name="brand_model_variant_id" id="brand_model_variant_id" value="<?php echo $quote_detail->brand_model_variant_id; ?>" />
									<p><?php echo $customer_details->client_street.", ". $this->mdl_clients->get_area_name($customer_details->client_area).", <br>".$this->mdl_clients->get_state_name($customer_details->client_state).", ".$customer_details->client_pincode.", ".$this->mdl_clients->get_country_name($customer_details->client_country); ?> <br>
									</p>
									<br><br>
								</div>
							</div>
						</div>
						<div class="col-lg-6 clearfix invoice-info">
							<div class="text-lg-right">
								<h5>Review Quote - <?php echo $quote_detail->quote_no; ?></h5>
								<?php if($appoinment_details) { ?>
									<h5><?php _trans('appointment_no');?>. - <?php echo $appoinment_details->appointment_no; ?></h5>
								<?php } ?>
								<!--div><b>Date: </b><?php if(count($appoinment_details) > 0){ echo $appoinment_details->pickup_date; } ?></div>
								<div><b>Time: </b><?php if(count($appoinment_details) > 0){ echo $appoinment_details->pickup_time; } ?></div-->
							</div>

							<div class="payment-details">
								<!--strong>Payment Details</strong>
								<table>
									<tbody><tr>
										<td>Total Due:</td>
										<td>$8,750</td>
									</tr>
									<tr>
										<td>Bank Name:</td>
										<td>Profit Bank Europe</td>
									</tr>
									<tr>
										<td>Country:</td>
										<td>United Kingdom</td>
									</tr>
									<tr>
										<td>City:</td>
										<td>London</td>
									</tr>
									<tr>
										<td>Address:</td>
										<td>3 Goodman street</td>
									</tr>
									<tr>
										<td>IBAN:</td>
										<td>KFHT32565523921540571</td>
									</tr>
									<tr>
										<td>SWIFT Code:</td>
										<td>BPT4E</td>
									</tr>
								</tbody></table>
								<br-->
								<strong><?php _trans('car_details');?></strong>
								<table>
									<tbody><tr>
										<td><?php _trans('reg_no');?>:</td>
										<td><?php echo $quote_detail->car_reg_no; ?></td>
									</tr>
									<tr>
										<td><?php _trans('car');?>:</td>
										<td><?php echo $quote_detail->car_model_year." ".$quote_detail->brand_name." ".$quote_detail->model_name." ".$quote_detail->variant_name; ?></td>
									</tr>
									<tr>
										<td><?php _trans('date');?>:</td>
										<td><?php if(count($appoinment_details) > 0){ echo $appoinment_details->pickup_date; } ?></td>
									</tr>
								</tbody></table>
							</div>
						</div>
					</div>
					<?php $this->layout->load_view('user_quotes/partial_service_table'); ?>
					<?php $this->layout->load_view('user_quotes/partial_product_table'); ?>
					
					<div class="row"><?php /* * / ?>
						<div class="col-lg-6 terms-and-conditions">
							<div class="row">
							<strong>Terms and Conditions</strong>
							Thank you for your business. We do expect payment within 21 days, so please process this invoice within that time. There will be a 1.5% interest charge per month on late invoices.
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
							</div>
						</div><?php / * */ ?>
						<div class="col-lg-5 clearfix" style="float: right">
							<div class="total-amount row" style="float: left;width: 100%`">
								
								<div class="row">
									<div class="col-lg-7 clearfix">
										<b> <?php _trans('service');?> </b>
									</div>
									<div class="col-lg-5 price clearfix"> 
										
									</div>
								</div>	
								<div class="row">
									<div class="col-lg-7 clearfix">
										<?php _trans('mech_service_amount');?>:
									</div>
									<div class="col-lg-5 price clearfix"> 
										<b class="total_service_mech_price"></b>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-7 clearfix">
										<?php _trans('user_service_amount');?>:
									</div>
									<div class="col-lg-5 price clearfix"> 
										<b class="total_user_service_price"></b>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 clearfix">
									<?php _trans('discount');?>: 
									</div>
									<div class="col-lg-3">
										<input onkeyup="overall_invoice_calc()" type="text" value="<?php echo $quote_detail->service_total_discount_pct ?>" size="3" maxlength="3"  name="service_discount" id="service_discount">
										<span>%</span>
									</div>
									<div class="col-lg-5 price clearfix">
										<b class="service_total_discount"><?php echo $quote_detail->service_total_discount ?></b>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-7 clearfix">
										<?php _trans('service_taxable_amount');?>:
									</div>
									<div class="col-lg-5 price clearfix"> 
										<b class="total_user_service_taxable"></b>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-4 clearfix">
										<?php _trans('service_gst');?>:  
									</div>
									<div class="col-lg-3">
										<select onchange="overall_invoice_calc()" id="total_service_tax" name="total_service_tax">
											<option <?php if($quote_detail->service_total_gst_pct == 0) echo "selected" ?> value="0"> 0% </option>
											<option <?php if($quote_detail->service_total_gst_pct == 18) echo "selected" ?> value="18"> 18% </option>
										</select>
									</div>
									<div class="col-lg-5 price clearfix">
										<b class="total_servie_gst_price"><?php echo $quote_detail->service_total_gst?></b>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-9 clearfix">
										<b><?php _trans('total_service_amount');?>: </b>
									</div>
									
									<div class="col-lg-3 price clearfix"  style="border-top:1px solid #000; margin-top: 5px">
										<b class="total_servie_invoice"></b>
									</div>
								</div>
								
								<div class="row">
									<div class="col-lg-7 clearfix">
										<b><?php _trans('product');?> </b>
									</div>
									<div class="col-lg-5 price clearfix"> 
										
									</div>
								</div>	

								

								<div class="row">
									<div class="col-lg-7 clearfix">
										Mech - Product amount:
									</div>
									<div class="col-lg-5 price clearfix"> 
										<b class="total_product_mech_price"></b>
									</div>
								</div>
								
								<div class="row">
									<div class="col-lg-7 clearfix">
										User - Product amount:
									</div>
									<div class="col-lg-5 price clearfix">
									 	<b class="total_user_product_price"></b>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-7 clearfix">
										Product Discount :
									</div>
									<div class="col-lg-5 price clearfix">
									 	<b class="product_total_discount"></b>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-7 clearfix">
										Product Taxable Amount:
									</div>
									<div class="col-lg-5 price clearfix">
									 	<b class="total_user_product_taxable"></b>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-7 clearfix">
										Product GST:
									</div>
									<div class="col-lg-5 price clearfix">
									 	<b class="total_user_product_gst"></b>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-7 clearfix">
										<b>Total Product Amount:</b>
									</div>
									<div class="col-lg-5 price clearfix" style="border-top:1px solid #000; margin-top: 5px">
									 	<b class="total_product_invoice"></b>
									</div>
								</div>

								<br>

								<div class="row">
									<div class="col-lg-9 clearfix">
										 Total Taxable Amount
										
									</div>
									<div class="col-lg-3 price clearfix" ">
									 	<b class="total_taxable_amount"></b>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-9 clearfix">
										 GST 
										
									</div>
									<div class="col-lg-3 price clearfix" ">
									 	<b class="total_gst_amount"></b>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-9 clearfix">
										<b> Grand Total</b> (Total Service amt + Total Product Amount)
									</div>
									<div class="col-lg-3 price clearfix" style="border-top:1px solid #000; margin-top: 5px">
									 	<b class="grand_total"></b>
									</div>
								</div>
								
								
							

									<br><br>
									<div class="row">
										<div class="buttons text-center">
											<button id="btn_submit" name="btn_submit" class="btn btn-rounded btn-primary btn-padding-left-right-40" value="1">
											    <i class="fa fa-check"></i> Save</button>
											<button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default" value="1">
											    <i class="fa fa-times"></i> Cancel</button>
										</div>
									</div>
										
									</div>
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
		$(document).ready(function(){
		
		$("#btn_cancel").click(function () {
			window.location.href = "<?php echo site_url('user_quotes/status/current'); ?>";
		});	
		
		$("#btn_submit").click(function () {
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
            
            $.post('<?php echo site_url("user_quotes/ajax/invoice_save"); ?>', {
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
					userrequpdate:$("#userrequpdate").val(),
					appointment_grand_total:$(".grand_total").html(),
					_mm_csrf: $('#_mm_csrf').val()
				}, function (data) {
				list = JSON.parse(data);
					if(list.success=='1'){
						//toastr.success("YYEESSSSSSS");
						location.reload();
					}
				});
	    });
    
		$('.contacts-page').each(function(){
        var parent = $(this),
            btnExpand = parent.find('.action-btn-expand'),
            classExpand = 'box-typical-full-screen';

        btnExpand.click(function(){
            if (parent.hasClass(classExpand)) {
                parent.removeClass(classExpand);
                $('html').css('overflow','auto');
                parent.find('.tab-content').height('auto').css('overflow','visible');
            } else {
                parent.addClass(classExpand);
                $('html').css('overflow','hidden');
                parent.find('.tab-content').css('overflow','auto').height(
                    $(window).height() - 2 - parent.find('.box-typical-header').outerHeight()
                );
            }
        });
    });
    });
		</script>