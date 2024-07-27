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
					<h3><?php _trans('lable843'); ?><?php if($quote_detail->quote_no) { echo " - ".$quote_detail->quote_no; } ?></h3>
				</div>
			</div>
		</div>
	</div>
</header>
<div class="row">
	<div class="col-xs-12 top-15">
		<a class="anchor anchor-back" href="<?php echo site_url('mech_quotes/index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
	</div>
</div>
<div class="container-fluid viewPages">
	<section class="card">
		<div class="card-block invoice">
			<div class="row invoice-company_details">
				<div class="col-lg-12 text-center"><h4><?php _trans('lable837'); ?></h4></div>
				<div class="col-lg-12">
					<div class="company_logo col-lg-4">
						<?php $company_details = $this->mdl_workshop_branch->get_company_branch_details($quote_detail->branch_id); 
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
							if ($company_details->branch_country) {echo ' - '.$company_details->name;} ?></span>
							<?php if($company_details->branch_contact_no){ echo '<span>'.$company_details->branch_contact_no.'</span>'; } ?>
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
							<td width="45%" class="firstSectionFirsttd">
								<table width="100%">
								<?php if($customer_details->client_name){ ?>
									<tr width="100%">    
										<td width="35%" ><?php _trans('lable36'); ?> :</td>
										<td width="65%"><?php echo $customer_details->client_name;?></td>
									</tr>
								<?php }if($quote_detail->user_address_id){ ?>
									<tr width="100%">    
										<td width="35%"><?php _trans('lable61'); ?> : </td>
										<td width="65%"><?php echo $this->mdl_user_address->get_user_complete_address($quote_detail->user_address_id); ?></td>
									</tr>
								<?php }if($customer_details->client_gstin){ ?>
									<tr width="100%">
										<td width="35%"><?php _trans('lable910'); ?> :</b>
										<td width="65%"><?php echo $customer_details->client_gstin; ?></td>
									</tr>
								<?php } if($customer_details->client_contact_no != "" || $customer_details->client_email_id != ""){?>
									<tr width="100%">    
										<td width="35%"><?php _trans('lable1051'); ?> :</td>
										<td width="65%">
											<?php echo $customer_details->client_contact_no;?><br>
											<?php echo $customer_details->client_email_id; ?>
										</td>
									</tr>
								<?php } ?>
								</table>
							</td>
							<td width="54%" class="firstSectionSecondtd">
								<table width="100%" class="firstTable" >
								<?php if($quote_detail->quote_no){ ?>
										<tr width="100%" style="width:100%;">
											<td width="40%" class="text-right"><?php _trans('lable844');?> :</td>
											<td width="60%" class="text-right"><?php echo ($quote_detail->quote_no?$quote_detail->quote_no:""); ?></td>
										</tr>
									<?php } if($quote_detail->quote_date){ ?>                    
										<tr width="100%" style="width:100%;">
											<td width="60%" class="text-right"><?php _trans('lable841');?> :</td>
											<td width="60%" class="text-right"><?php echo ($quote_detail->quote_date?$quote_detail->quote_date:""); ?></td>
										</tr>
									<?php } if($quote_detail->car_reg_no){ ?>
										<tr width="100%" style="width:100%;">
											<td width="40%" class="text-right"><?php _trans('lable72'); ?> :</td>
											<td width="60%" class="text-right"><?php echo ($quote_detail->car_reg_no?$quote_detail->car_reg_no:""); ?></td>
										</tr>
									<?php } if($quote_detail->brand_name){ ?>
										<tr width="100%" style="width:100%;">
											<td width="40%" class="text-right"><?php _trans('lable1049'); ?> :</td>
											<td width="60%" class="text-right"><?php echo ($quote_detail->brand_name?$quote_detail->brand_name:""); ?></td>
										</tr>
									<?php } if($quote_detail->brand_name){ ?>
										<tr width="100%" style="width:100%;">
											<td width="40%" class="text-right"><?php _trans('lable977'); ?>:</td>
											<td width="60%" class="text-right"><?php echo ($quote_detail->car_model_year?$quote_detail->car_model_year:" ")." ".($quote_detail->model_name?$quote_detail->model_name:" ")." ".($quote_detail->variant_name?$quote_detail->variant_name:""); ?></td>
										</tr>
									<?php } if($quote_detail->current_odometer_reading){ ?>
										<tr width="100%" style="width:100%;">
											<td width="40%" class="text-right"><?php _trans('lable1113'); ?> :</td>
											<td width="60%" class="text-right"><?php echo $quote_detail->current_odometer_reading; ?>
											</td>
										</tr>
									<?php } if($quote_detail->fuel_type){ ?>
										<tr width="100%" style="width:100%;">
											<td width="40%" class="text-right"><?php _trans('lable132'); ?> :</td>
											<td width="60%" class="text-right"><?php if($quote_detail->fuel_type == 'P'){ echo "Petrol"; } else if($quote_detail->fuel_type == 'D'){ echo "Diesel"; } ?>
											</td>
										<tr>
									<?php } ?>
								</table>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<?php if($is_product == 'Y'){ $this->layout->load_view('mech_quotes/partial_product_table_view'); } ?>
			<?php $this->layout->load_view('mech_quotes/partial_service_table_view'); ?>
			<?php $this->layout->load_view('mech_quotes/partial_service_package_table_view'); ?>
			<table><tr><td height="20"></td></tr></table>
			<div class="fourthSection paddingBottom25px">
				<div class="fourthSectionFirstSec">
				<?php if($bank_dtls->account_number){ ?>
					<h4><?php _trans('lable1048'); ?></h4>
					<table>
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
				<?php } if($quote_detail->quote_terms_condition){?>
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 padding0px paddingTop20px" style="text-align:justify;">
						<strong><?php _trans('lable388'); ?></strong><br>
						<?php echo $quote_detail->quote_terms_condition; ?>
					</div>
				<?php } if($quote_detail->description){?>
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 padding0px paddingTop20px">
						<label class="control-label" style="text-align: left"><?php _trans('lable177');?></label>
						<textarea class="form-control" readonly><?php echo $quote_detail->description; ?></textarea>
					</div>
				<?php } ?>
				</div>
				<div class="fourthSectionSecondSec ipadle">
					<table class="item_table">
						<?php if (count(json_decode($product_list)) > 0) { ?>
						<tr>
							<td class="item-amount text-right border_none"><?php _trans('lable356'); ?></td>
							<td class="item-amount text-left border_none"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($quote_detail->product_grand_total?$quote_detail->product_grand_total:o),$this->session->userdata('default_currency_digit')); ?></td>
						</tr>
						<?php } ?>
						<?php if(count(json_decode($service_list)) > 0) { ?>
						<tr>
							<td class="item-amount text-right border_none"><?php _trans('lable342'); ?></td>
							<td class="item-amount text-left border_none"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($quote_detail->service_grand_total?$quote_detail->service_grand_total:0),$this->session->userdata('default_currency_digit')); ?></td>
						</tr>
						<?php } ?>
						<?php if(count(json_decode($service_package_list)) > 0) { ?>
						<tr>
							<td class="item-amount text-right border_none"><?php _trans('label960'); ?></td>
							<td class="item-amount text-left border_none"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($quote_detail->service_package_grand_total?$quote_detail->service_package_grand_total:0),$this->session->userdata('default_currency_digit')); ?></td>
						</tr>
						<?php } ?>
					
						<tr>
							<td class="item-amount text-right border_none" style="border:none;"><?php _trans('lable332'); ?></td>
							<td class="item-amount text-left border_none" style="font-size:14px;"><b><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($quote_detail->grand_total,$this->session->userdata('default_currency_digit')); ?></b></td>
						</tr>
					</table>
				</div>
			</div>
			<div class="row invoiceFloatbtn">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 clearfix buttons text-right">
					<a class="btn btn-rounded btn-primary btn-padding-left-right-40" href="<?php echo site_url('mech_quotes/create/'.$quote_detail->quote_id); ?>">
						<i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
					</a>
					<a class="btn btn-rounded btn-primary btn-padding-left-right-40" target="_blank" href="<?php echo site_url('mech_quotes/generate_pdf/'.$quote_detail->quote_id); ?>">
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
<script type="text/javascript">
	$(document).ready(function(){
		$("#btn_cancel").click(function () {
			window.location.href = "<?php echo site_url('mech_quotes'); ?>";
		});
	});
</script>
