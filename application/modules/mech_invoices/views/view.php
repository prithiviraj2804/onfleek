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
					<h3><?php _trans('lable376'); ?><?php if($invoice_detail->invoice_no) { echo " - ".$invoice_detail->invoice_no; } ?></h3>
				</div>
			</div>
		</div>
	</div>
</header>
<div class="row">
	<div class="col-xs-12 top-15">
		<a class="anchor anchor-back" href="<?php echo site_url('mech_invoices/index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
	</div>
</div>
<div class="container-fluid viewPages">
	<section class="card">
		<div class="card-block invoice">
			<div class="row invoice-company_details">
				<?php if($invoice_detail->tax_invoice == 'Y'){ ?>
					<div class="col-lg-12 text-center"><h4><?php _trans('lable1115'); ?></h4></div>
				<?php } else { ?>
					<div class="col-lg-12 text-center"><h4><?php _trans('lable119'); ?></h4></div>
				<?php } ?>    
				<div class="col-lg-12">
					<div class="company_logo col-lg-4">
						<?php $company_details = $this->mdl_workshop_branch->get_company_branch_details($invoice_detail->branch_id); 
						if($company_details->workshop_logo){ ?>
						<img src="<?php echo base_url(); ?>uploads/workshop_logo/<?php echo $company_details->workshop_logo; ?>" width="150" height="150" alt="<?php echo $company_details->workshop_name; ?>">
						<?php } ?>
					</div>
					<div class="col-lg-8 company_address">
						<div class="text-lg-right">
							<h4><?php echo $company_details->display_board_name; ?></h4>
							<span><?php if($company_details->branch_street){ echo $company_details->branch_street; }
							if($company_details->area_name){ echo ", ".$company_details->area_name; }
							if($company_details->state_name){ echo ", ".$company_details->state_name; }
							if($company_details->branch_pincode){ echo " - ".$company_details->branch_pincode; }
							if ($company_details->branch_country){echo ' - '.$company_details->name;} ?>
						</span>
							<?php if($company_details->branch_contact_no){ echo '<span>'.'Ph.No.'.$company_details->branch_contact_no.'</span>'; } ?>
							<?php if($company_details->branch_email_id){ echo '<span>'.$company_details->branch_email_id.'</span>'; } ?>
							<?php if($company_details->branch_gstin){ echo '<span>'.$company_details->branch_gstin.'</span>'; } ?>
						</div>	
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
					<table width="100%" class="item-tables firstSection">
						<tr width="100%">
							<td width="33%" style="width:33%;float: left;" class="firstSectionFirsttd">
								<table width="100%">
								<?php if($invoice_detail->invoice_no){ ?>
										<tr width="100%" style="width:100%;">
											<td width="40%" class="text-left"><?php _trans('lable29'); ?> :</td>
											<td width="60%" class="text-left"><?php echo $invoice_detail->invoice_no; ?></td>
										</tr>
									<?php } if($invoice_detail->invoice_date){ ?>                    
										<tr width="100%" style="width:100%;">
											<td width="60%" class="text-left"><?php _trans('lable368'); ?> :</td>
											<td width="60%" class="text-left"><?php echo ($invoice_detail->invoice_date?date_from_mysql($invoice_detail->invoice_date):""); ?></td>
										</tr>
									<?php }if($invoice_detail->jobsheet_no){ ?>
										<tr width="100%">
											<td width="35%" class="text-left"><?php _trans('lable1052'); ?> :</td>
											<td width="65%" class="text-left"><?php echo $invoice_detail->jobsheet_no; ?></td>
										</tr>
								<?php } if($customer_details->client_name){ ?>
									<tr width="100%">    
										<td width="35%" class="text-left"><?php _trans('lable36'); ?>:</td>
										<td width="65%" class="text-left"><?php echo $customer_details->client_name;?></td>
									</tr>
								<?php } if($customer_details->client_gstin){ ?>
										<tr width="100%" style="width:100%;">
											<td width="60%" class="text-left"><?php _trans('lable910'); ?> :</b>
											<td width="60%" class="text-left"><?php echo $customer_details->client_gstin; ?></td>
										</tr>	
								<?php } if($invoice_detail->next_service_dt){ ?>
										<tr width="100%" style="width:100%;">
											<td width="60%" class="text-left"><?php _trans('lable299'); ?> :</b>
											<td width="60%" class="text-left"><?php echo ($invoice_detail->next_service_dt?date_from_mysql($invoice_detail->next_service_dt):""); ?></td>
										</tr>	
								<?php } ?>	
										<tr width="100%">
											<td width="35%" class="text-left"><?php _trans('lable1126'); ?> :</td>
											<td width="65%" class="text-left"></td>
										</tr>
								</table>
							</td>
							<td width="33%" class="firstSectionSecondtd">
								<table width="100%" class="firstTable" >
								<?php  if($invoice_detail->user_address_id){ ?>
									<tr width="100%">    
										<td width="35%" class="text-left"><?php _trans('lable61'); ?> : </td>
										<td width="65%" class="text-left"><?php echo $this->mdl_user_address->get_user_complete_address($invoice_detail->user_address_id); ?></td>
									</tr>
								<?php } if($customer_details->client_contact_no != "" || $customer_details->client_email_id != ""){?>
									<tr width="100%">    
										<td width="35%" class="text-left"><?php _trans('lable1051'); ?> :</td>
										<td width="65%" class="text-left">
											<?php echo $customer_details->client_contact_no;?><br>
											<?php echo $customer_details->client_email_id; ?>
										</td>
									</tr>
									<?php }?>
								</table>
							</td>
							<td width="33%" class="firstSectionSecondtd">
								<table width="100%" class="firstTable" >
								<?php if($invoice_detail->car_reg_no){ ?>
										<tr width="100%">
											<td width="35%" class="text-left"><?php _trans('lable72'); ?> :</td>
											<td width="65%" class="text-left"><?php echo $invoice_detail->car_reg_no; ?></td>
										</tr>
									<?php } if($invoice_detail->brand_name){ ?>
										<tr width="100%">
											<td width="35%" class="text-left"><?php _trans('lable1049'); ?> :</td>
											<td width="65%" class="text-left"><?php echo $invoice_detail->brand_name; ?> <?php echo ($invoice_detail->car_model_year?$invoice_detail->car_model_year."-":" ")."".($invoice_detail->model_name?$invoice_detail->model_name:"")."".($invoice_detail->variant_name?"-".$invoice_detail->variant_name:" "); ?></td>
										</tr>
									<?php } if($invoice_detail->current_odometer_reading){ ?>
										<tr width="100%">
											<td width="35%" class="text-left"><?php _trans('lable1113'); ?> :</td>
											<td width="65%" class="text-left"><?php echo $invoice_detail->current_odometer_reading; ?>
											</td>
										</tr>
									<?php } if($invoice_detail->next_service_km){ ?>
										<tr width="100%" >
											<td width="35%" class="text-left"><?php _trans('lable298'); ?> :</td>
											<td width="65%" class="text-left"><?php echo $invoice_detail->next_service_km; ?>
											</td>
										</tr>	
								<?php }  ?>
								</table>
							</td>
						</tr>
					</table>
				</div>
			</div>
			
			<?php if($is_product == 'Y'){ $this->layout->load_view('mech_invoices/partial_product_table_view'); } ?>
			<?php $this->layout->load_view('mech_invoices/partial_service_table_view'); ?>
			<?php $this->layout->load_view('mech_invoices/partial_service_package_table_view'); ?>
			<table><tr><td height="20"></td></tr></table>
			<div class="fourthSection paddingBottom25px">
				<div class="fourthSectionFirstSec padding20px">
				<?php if($bank_dtls->account_number){ ?>
					<h5><?php _trans('lable1048'); ?></h5>
					<table width="100%">
						<tr>
							<td><?php _trans('lable401'); ?> :</td>
							<td><?php echo $bank_dtls->account_holder_name; ?></td>
						</tr>
						<tr>
							<td><?php _trans('lable98'); ?> :</td>
							<td><?php echo $bank_dtls->account_number; ?></td>
						</tr>
						<tr>
							<td><?php _trans('lable99'); ?> :</td>
							<td><?php echo $bank_dtls->bank_name; ?></td>
						</tr>
						<tr>
							<td><?php _trans('lable1047'); ?> :</td>
							<td><?php echo $bank_dtls->bank_ifsc_Code; ?></td>
						</tr>
						<tr>
							<td><?php _trans('lable95'); ?> :</td>
							<td><?php echo $bank_dtls->bank_branch; ?></td>
						</tr>
					</table>
				<?php } if($invoice_detail->invoice_terms_condition){?>
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 padding0px paddingTop20px">
					    <strong><?php _trans('lable388'); ?></strong><br>
						<?php echo $invoice_detail->invoice_terms_condition; ?>
					</div>
				<?php } if($invoice_detail->description){?>
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 padding0px paddingTop20px">
						<label class="control-label" style="text-align: left"><?php _trans('lable1208');?></label>
						<textarea class="form-control" readonly><?php echo $invoice_detail->description; ?></textarea>
					</div>
				<?php } ?>
				</div>
				<div class="fourthSectionSecondSec ipadle">
					<table class="item_table">
						<?php if (count(json_decode($product_list)) > 0) { ?>
						<tr>
							<td class="item-amount text-right border_none"><?php _trans('lable356'); ?></td>
							<td class="item-amount text-left border_none"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($invoice_detail->product_grand_total?$invoice_detail->product_grand_total:o),$this->session->userdata('default_currency_digit')); ?></td>
						</tr>
						<?php } ?>
						<?php if(count(json_decode($service_list)) > 0) { ?>
						<tr>
							<td class="item-amount text-right border_none"><?php _trans('lable342'); ?></td>
							<td class="item-amount text-left border_none"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($invoice_detail->service_grand_total?$invoice_detail->service_grand_total:0),$this->session->userdata('default_currency_digit')); ?></td>
						</tr>
						<?php } ?>
						<?php if(count(json_decode($service_package_list)) > 0) { ?>
						<tr>
							<td class="item-amount text-right border_none"><?php _trans('label960'); ?></td>
							<td class="item-amount text-left border_none"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($invoice_detail->service_package_grand_total?$invoice_detail->service_package_grand_total:0),$this->session->userdata('default_currency_digit')); ?></td>
						</tr>
						<?php } ?>
					
						<tr>
							<td class="item-amount text-right border_none" style="border:none;"><?php _trans('lable332'); ?></td>
							<td class="item-amount text-left border_none" style="font-size:14px;"><b><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($invoice_detail->grand_total,$this->session->userdata('default_currency_digit')); ?></b></td>
						</tr>
						<tr>
							<td class="item-amount text-right border_none" style="border:none;">(Inclusive of the advance paid amount from job card <?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($invoice_detail->advance_paid,$this->session->userdata('default_currency_digit')); ?>)<?php _trans('lable8'); ?>:</td>
							<td class="item-amount text-left border_none"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($invoice_detail->total_paid_amount,$this->session->userdata('default_currency_digit')); ?></td>
						</tr>
						<tr>
							<td class="item-amount text-right border_none" style="border:none;"><?php _trans('lable627'); ?>:</td>
							<td class="item-amount text-left border_none"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($invoice_detail->total_due_amount,$this->session->userdata('default_currency_digit')); ?></td>
						</tr>
					</table>			
				</div>
			</div>
			<div style="float: right;width: 48%;font-size:14px;">
			<?php // print_r(); ?>
			</div>
			<div class="row invoiceFloatbtn">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 clearfix buttons text-right">
					<?php if($this->session->userdata('user_type') == 3){ ?>

						<?php if($invoice_detail->invoice_status == "FP"){ ?>	
						<?php } else { ?>
						<a class="btn btn-rounded btn-primary btn-padding-left-right-40" href="<?php echo site_url('mech_invoices/create/'.$invoice_detail->invoice_id); ?>">
							<i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
						</a>
						<?php } ?>

					<?php } ?>
					<a class="btn btn-rounded btn-primary btn-padding-left-right-40" target="_blank" href="<?php echo site_url('mech_invoices/generate_pdf/'.$invoice_detail->invoice_id); ?>">
						<i class="fa fa-edit fa-margin"></i> <?php _trans('lable141'); ?>
					</a>
					<button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default" value="1">
						<i class="fa fa-times"></i> <?php _trans('lable58'); ?>
					</button>
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
			window.location.href = "<?php echo site_url('mech_invoices'); ?>";
		});
	});
</script>