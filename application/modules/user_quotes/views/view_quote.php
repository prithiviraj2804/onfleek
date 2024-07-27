<style type="text/css">
#product_item_table input {
    padding-left: 0px;
    padding-right: 0px;
	}
</style>

<header class="page-content-header">
			<div class="container-fluid">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell" id="total_user_quote">
							<h3><?php _trans('job_card');?> <?php if($quote_detail->appointment_no) { echo " - ".$quote_detail->appointment_no; } ?></h3>
						</div>
						
					</div>
				</div>
			</div>
</header>

	<div class="container-fluid">
		<div class="row">
		<div class="col-xs-12 top-15">
			<a class="anchor anchor-back" href="<?php echo site_url('user_quotes/status/'.$url_from); ?>"><i class="fa fa-long-arrow-left"></i><span>Back to List</span></a>
		</div>
		</div>
			<section class="card">
				<div class="card-block invoice">
					<div class="row invoice-company_details">
						<div class="col-lg-12">
						<div class="company_logo col-lg-4">
							<?php $company_details = $this->mdl_workshop_branch->get_company_branch_details(); 
							if($company_details->workshop_logo){ ?>
								<img src="<?php echo base_url(); ?>uploads/workshop_logo/<?php echo $company_details->workshop_logo; ?>" width="300" height="100" alt="<?php echo $company_details->workshop_name; ?>">
							<?php } ?>
						</div>
						<div class="col-lg-8 company_address">
							<div class="text-lg-right">
								  <h4><?php echo $company_details->workshop_name; ?></h4>
								  <span><?php if($company_details->branch_street){ echo $company_details->branch_street; }
								  if($company_details->area_name){ echo ", ".$company_details->area_name; }
								  if($company_details->state_name){ echo ", ".$company_details->state_name; }
								  if($company_details->branch_pincode){ echo " - ".$company_details->branch_pincode; }
								  if($company_details->branch_country == 101){ echo ", India"; }
								   ?></span>
								   <?php if($company_details->branch_contact_no){ echo '<span>'.$company_details->branch_contact_no.'</span>'; } ?>
								   <?php if($company_details->branch_email_id){ echo '<span>'.$company_details->branch_email_id.'</span>'; } ?>
								   <?php if($company_details->branch_gstin){ echo '<span>'.$company_details->branch_gstin.'</span>'; } ?>
								</div>
							
								
						</div>
					</div>
					</div>
					<div class="row m-b-3">
						<div class="col-lg-4 invoice_customer_details">
							<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
							<input type="hidden" name="quote_id" id="quote_id" value="<?php echo $quote_detail->quote_id; ?>" />
							<input type="hidden" name="user_id" id="user_id" value="<?php echo $quote_detail->customer_id; ?>" />
							<input type="hidden" name="car_brand_id" id="car_brand_id" value="<?php echo $quote_detail->customer_car_id; ?>" />
							<input type="hidden" name="car_brand_model_id" id="car_brand_model_id" value="<?php echo $quote_detail->car_brand_model_id; ?>" />
							<input type="hidden" name="brand_model_variant_id" id="brand_model_variant_id" value="<?php echo $quote_detail->brand_model_variant_id; ?>" />
							
							<strong><?php _trans('invoice_to');?>:</strong>
							<?php if($customer_details->client_name){ echo '<span>'.$customer_details->client_name.'</span>'; } ?>
							<?php if($customer_details->client_contact_no){ echo '<span>'.$customer_details->client_contact_no.'</span>'; } ?>
							<strong><?php _trans('pick_up_address');?>:</strong>
							<span><?php echo $this->mdl_user_address->get_user_complete_address($quote_detail->pickup_address_id); ?></span>
							<strong><?php _trans('delivery_address');?>:</strong>
							<span><?php echo $this->mdl_user_address->get_user_complete_address($quote_detail->delivery_address_id); ?></span>
						</div>
						
						<div class="col-lg-4 invoice_customer_details">
							<strong><?php _trans('vehicle_details');?>:</strong>
							<?php if($quote_detail->car_reg_no){ echo '<span>'.$quote_detail->car_reg_no.'</span>'; } ?>
							<span><?php if($quote_detail->car_model_year){ echo $quote_detail->car_model_year; }
								  if($quote_detail->brand_name){ echo " ".$quote_detail->brand_name; }
								  if($quote_detail->model_name){ echo " ".$quote_detail->model_name; }
								  if($quote_detail->variant_name){ echo " ".$quote_detail->variant_name; }
								   ?></span>
							<?php if($quote_detail->fuel_type){
								if($quote_detail->fuel_type == 'P'){
									echo '<span>Fuel Type : Petrol</span>';
								}elseif($quote_detail->fuel_type == 'D'){
									echo '<span>Fuel Type : Diesel</span>';
								}else{
									echo '<span>Fuel Type : -</span>';
								} } ?>
							<?php if($quote_detail->current_odometer_reading){ echo '<span>Odometer Reading : '.$quote_detail->current_odometer_reading.'</span>'; } ?>
							<?php if($quote_detail->fuel_level){ echo '<span>Fuel level : '.$quote_detail->fuel_level.'</span>'; } ?>
							<?php if($quote_detail->pickup_date){ echo '<span>Pickup Date : '.$quote_detail->pickup_date .' '.$quote_detail->pickup_time.'</span>'; } ?>
							<?php if($quote_detail->delivery_date){ echo '<span>Delivery Date : '.$quote_detail->delivery_date.' '.$quote_detail->delivery_time.'</span>'; } ?>
							
						</div>
						
						<div class="col-lg-4 invoice_customer_details">
							<?php if($quote_detail->invoice_no) { ?>
									<strong><?php _trans('invoice_no');?>: <?php echo $quote_detail->invoice_no; ?></strong>
							<?php } ?>
							<span>Job Card No : <?php echo $quote_detail->appointment_no; ?></span>
							<?php if($quote_detail->appointment_book_date){ echo '<span>Appointment Date : '.$quote_detail->appointment_book_date .' '.$quote_detail->appointment_book_time.'</span>'; } ?>
						</div>
					</div>
					
					<?php $this->layout->load_view('user_quotes/partial_service_table_view'); ?>
					<?php $this->layout->load_view('user_quotes/partial_product_table_view'); ?>
					
					<div class="row m-b-3">
						<div class="col-lg-12">
						<div class="col-lg-6 terms-and-conditions">
							<div class="row m-b-3">
							<strong><?php _trans('terms_and_conditions');?></strong><br>
							Thank you for your business. We do expect payment within 21 days, so please process this invoice within that time. There will be a 1.5% interest charge per month on late invoices.
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
						</div>
						<div class="col-lg-5 clearfix" style="float: right">
							<div class="total-amount row" style="float: left;width: 100%`">
								<div class="row">
									<div class="col-lg-12 clearfix">
										<b> <?php _trans('service');?> </b>
									</div>
								</div>	
								
								<div class="row">
									<div class="col-lg-7 clearfix">
										<?php _trans('total');?>:
									</div>
									<div class="col-lg-5 price clearfix"> 
										<b class="total_user_service_price"><?php echo $quote_detail->service_user_total; ?></b>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-4 clearfix">
									<?php _trans('discount');?>: 
									</div>
									<div class="col-lg-3">
										<span><?php echo $quote_detail->service_total_discount_pct ?> %</span>
									</div>
									<div class="col-lg-5 price clearfix">
										<b class="service_total_discount"><?php echo $quote_detail->service_total_discount ?></b>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-7 clearfix">
										<?php _trans('taxable_amount');?>:
									</div>
									<div class="col-lg-5 price clearfix"> 
										<b class="total_user_service_taxable"><?php echo $quote_detail->service_total_taxable; ?></b>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-4 clearfix">
										<?php _trans('gst');?> :  
									</div>
									<div class="col-lg-3"><?php echo $quote_detail->service_total_gst_pct; ?></div>
									<div class="col-lg-5 price clearfix">
										<b class="total_servie_gst_price"><?php echo $quote_detail->service_total_gst; ?></b>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-9 clearfix">
										<b><?php _trans('service_grand_total');?>: </b>
									</div>
									
									<div class="col-lg-3 price clearfix"  style="border-top:1px solid #000; margin-top: 5px">
										<b class="total_servie_invoice"><?php echo $quote_detail->service_grand_total; ?></b>
									</div>
								</div>
								
								<div class="row">
									<div class="col-lg-12 clearfix">
										<b> <?php _trans('product');?> </b>
									</div>
								</div>	

								<div class="row">
									<div class="col-lg-7 clearfix">
									 <?php _trans('total');?>:
									</div>
									<div class="col-lg-5 price clearfix">
									 	<b class="total_user_product_price"><?php echo $quote_detail->product_user_total; ?></b>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-7 clearfix">
										<?php _trans('discount');?> :
									</div>
									<div class="col-lg-5 price clearfix">
									 	<b class="product_total_discount"><?php echo $quote_detail->product_total_discount; ?></b>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-7 clearfix">
										 	<?php _trans('taxable_amount');?>:
									</div>
									<div class="col-lg-5 price clearfix">
									 	<b class="total_user_product_taxable"><?php echo $quote_detail->product_total_taxable; ?></b>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-7 clearfix">
										 <?php _trans('gst');?>:
									</div>
									<div class="col-lg-5 price clearfix">
									 	<b class="total_user_product_gst"><?php echo $quote_detail->product_total_gst; ?></b>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-7 clearfix">
										<b><?php _trans('product_grand_total');?>:</b>
									</div>
									<div class="col-lg-5 price clearfix" style="border-top:1px solid #000; margin-top: 5px">
									 	<b class="total_product_invoice"><?php echo $quote_detail->product_grand_total; ?></b>
									</div>
								</div>

								<br>

								<div class="row">
									<div class="col-lg-9 clearfix">
										 <b><?php _trans('total_taxable_amount');?></b> <br><?php _trans('service_total_product_total');?>
									</div>
									<div class="col-lg-3 price clearfix">
									 	<b class="total_taxable_amount"><?php echo $quote_detail->total_taxable_amount; ?></b>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-9 clearfix">
										 <b> <?php _trans('gst');?></b><br><?php _trans('service_gst_product_gst');?>
									</div>
									<div class="col-lg-3 price clearfix">
									 	<b class="total_gst_amount"><?php echo $quote_detail->total_tax_amount; ?></b>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-9 clearfix">
										<b><?php _trans('grand_total');?></b><br> <?php _trans('total_service_amt_total_product_amount');?>
									</div>
									<div class="col-lg-3 price clearfix" style="border-top:1px solid #000; margin-top: 5px">
									 	<b class="grand_total"><?php echo $quote_detail->appointment_grand_total; ?></b>
									</div>
								</div>
								
								<br>
								</div>
								</div>
							</div>
							</div>
							<div class="row">
								<div class="col-lg-12 clearfix buttons text-right">
									<button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default" value="1">
									    <i class="fa fa-times"></i> <?php _trans('cancel');?></button>
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
			window.location.href = "<?php echo site_url('user_quotes/status/'.$url_from); ?>";
		});	
	});
</script>