<style type="text/css">

input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
}
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
                    <h3><?php _trans('lable120');?> <?php if($purchase_details->purchase_no) { echo " - ".$purchase_details->purchase_no; } ?></h3>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="row">
	<div class="col-xs-12 top-15">
		<a class="anchor anchor-back" href="<?php echo site_url('mech_purchase/index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59');?></span></a>
	</div>
</div>
<div class="container-fluid viewPages">
	<section class="card col-lg-10 col-md-10 col-sm-12 col-xs-12 col-centered">
		<div class="card-block invoice">
			<div class="row invoice-company_details">
				<div class="col-lg-12">
					<div class="company_logo">
						<?php $company_details = $this->mdl_workshop_branch->get_company_branch_details($purchase_details->branch_id); 
						if($company_details->workshop_logo){ ?>
						<img src="<?php echo base_url(); ?>uploads/workshop_logo/<?php echo $company_details->workshop_logo; ?>" width="150" height="150" alt="<?php echo $company_details->workshop_name; ?>">
						<?php } ?>
					</div>
					<div class="clearfix company_address">
						<div class="text-lg-right">
							<h4><?php echo $company_details->display_board_name; ?></h4>
							<span>
								<?php if($company_details->branch_street){ echo $company_details->branch_street; }
								if($company_details->area_name){ echo ", ".$company_details->area_name; }
								if($company_details->state_name){ echo ", ".$company_details->state_name; }
								if($company_details->branch_pincode){ echo " - ".$company_details->branch_pincode; }
								if ($company_details->branch_country) {echo ' - '.$company_details->name;}
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
				<div class="col-lg-6 col-md-6 col-sm-6">
					<?php if($purchase_details->display_board_name){ ?>
					<div class="form-group clearfix">
						<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text-right"><?php _trans('lable95');?>:</div>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left"><?php echo $purchase_details->display_board_name; ?></div>
					</div>
					<?php } if($purchase_details->purchase_number){ ?>
					<div class="form-group clearfix">
						<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text-right"><?php _trans('lable34');?>:</div>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left"><?php echo $purchase_details->purchase_number; ?></div>
					</div>
					<?php } if($purchase_details->purchase_type_id){ ?>
					<div class="form-group clearfix">
						<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text_align_right"><?php _trans('lable434');?>:</div>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left">
						<?php if($purchase_details->purchase_type_id == 1){ ?>
							<?php echo _trans('lable436'); ?>
						<?php } else if($purchase_details->purchase_type_id == 2) { ?>
							<?php echo _trans('lable437'); ?>
						<?php } else if($purchase_details->purchase_type_id == 3) { ?>
							<?php echo _trans('lable438'); ?>
						<?php } else if($purchase_details->purchase_type_id == 4) { ?>
							<?php echo _trans('lable439'); ?>
						<?php } else if($purchase_details->purchase_type_id == 5) { ?>
							<?php echo _trans('lable440'); ?>
						<?php } else if($purchase_details->purchase_type_id == 6) { ?>
							<?php echo _trans('lable441'); ?>
						<?php } else if($purchase_details->purchase_type_id == 7) { ?>
							<?php echo _trans('lable442'); ?>
						<?php } else if($purchase_details->purchase_type_id == 8) { ?>
							<?php echo _trans('lable443'); ?>
						<?php } else if($purchase_details->purchase_type_id == 9) { ?>
							<?php echo _trans('lable444'); ?>
						<?php } ?>
						</div>
					</div>
					<?php } if($purchase_details->purchase_date_created){ ?>
					<div class="form-group clearfix">
						<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text_align_right"><?php _trans('lable386');?>:</div>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left"><?php echo date_from_mysql($purchase_details->purchase_date_created); ?>
						</div>
					</div>	
					<?php } ?>				
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<?php if($purchase_details->purchase_date_due){ ?>
					<div class="form-group clearfix">
						<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text_align_right"><?php _trans('lable127');?>:</div>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left"><?php echo date_from_mysql($purchase_details->purchase_date_due); ?>
						</div>
					</div>	
					<?php } if($purchase_details->supplier_name){ ?>
					<div class="form-group clearfix">
						<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text-right"><?php _trans('lable80');?>:</div>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left"><?php echo $purchase_details->supplier_name; ?></div>
					</div>	
					<?php } if($purchase_details->supplier_gstin){ ?>
					<div class="form-group clearfix">
						<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text-right"><?php _trans('lable84');?>:</div>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left"><?php echo $purchase_details->supplier_gstin; ?></div>
					</div>
					<?php } if($purchase_details->Supply_place){ ?>
					<div class="form-group clearfix">
						<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text-right"><?php _trans('lable446');?>:</div>
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left">
							<?php echo $purchase_details->place_of_supply_id.'-'.$purchase_details->Supply_place; ?>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="card-block invoice">
			<?php $this->layout->load_view('mech_purchase/partial_product_table_view'); ?>
		</div>
		<table><tr><td height="20"></td></tr></table>
		<div class="fourthSection paddingBottom25px">
			<div class="fourthSectionFirstSec padding20px">
			</div>
			<div class="fourthSectionSecondSec ipadle">
				<table class="item_table">
					<tr>
						<td class="item-amount text-right border_none"><?php _trans('lable356'); ?></td>
						<td class="item-amount text-left border_none"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($purchase_details->grand_total?$purchase_details->grand_total:0),$this->session->userdata('default_currency_digit')); ?></td>
					</tr>
					<tr>
						<td class="item-amount text-right border_none" style="border:none;"><?php _trans('lable332'); ?></td>
						<td class="item-amount text-left border_none" style="font-size:14px;"><b><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($purchase_details->grand_total,$this->session->userdata('default_currency_digit')); ?></b></td>
					</tr>
					<tr>
						<td class="item-amount text-right border_none" style="border:none;"><?php _trans('lable8'); ?>:</td>
						<td class="item-amount text-left border_none"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($purchase_details->total_paid_amount,$this->session->userdata('default_currency_digit')); ?></td>
					</tr>
					<tr>
						<td class="item-amount text-right border_none" style="border:none;"><?php _trans('lable627'); ?>:</td>
						<td class="item-amount text-left border_none"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($purchase_details->total_due_amount,$this->session->userdata('default_currency_digit')); ?></td>
					</tr>
				</table>			
			</div>
		</div>
		<?php if(count($upload_details) > 0) { ?>
		<div class="card-block invoice">
			<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12" >
				<div class="col-lg-6 col-lg-6 col-sm-6 col-xs-12" style="padding-left: 0px;"><h4 style="margin-bottom: 0px;"><?php _trans('lable327');?></h4></div>
				<div class="col-lg-6 col-lg-6 col-sm-6 col-xs-12 text_align_right ">
				</div>
			</div>
			<div class="collapse col-lg-12 col-lg-12 col-sm-12 col-xs-12 paddingTop20px <?php if($upload_details){ echo "in"; } ?>" id="uploadcollapse" >
				<div id="preview_section" class="preview_uploads col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<?php if(count($upload_details) > 0) { ?>
					<table class="car-table-box col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<thead>
							<tr>
								<th><?php _trans('lable182');?></th>
								<th><?php _trans('lable179');?></th>
								<th align="center" class="text-center"><?php _trans('lable183');?></th>
								
							</tr>
						</thead>
						<tbody id="uploaded_datas">
								<?php foreach ($upload_details as $documentList){ ?>
							<tr>
								<td><span><?php echo $documentList->document_name; ?></span></td>
								<td><span><?php echo $documentList->file_name_original; ?></span></td>
								<td align="center" class="text-center" >
								<span style="cursor: pointer">
									<a href="<?php echo base_url()."uploads/purchase_files/".$documentList->file_name_new?>" target="_blank" >
										<img src="<?php echo base_url()."uploads/purchase_files/".$documentList->file_name_new?>" width="50" height="50">
									</a>
								</span></td>
								
							</tr>
						<?php }?>
						</tbody>
					</table>
					<?php } else { ?> 
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" > <?php _trans('lable185');?></div>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="card-block invoice">
			<div class="row invoiceFloatbtn">
				<div class="col-lg-12 clearfix buttons text-right">
					<a class="btn btn-rounded btn-primary" href="<?php echo site_url('mech_purchase/create/'.$purchase_details->purchase_id); ?>">
						<i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
					</a>
					<a class="btn btn-rounded btn-primary btn-padding-left-right-40" target="_blank" href="<?php echo site_url('mech_purchase/generate_pdf/'.$purchase_details->purchase_id); ?>">
					<i class="fa fa-edit fa-margin"></i> <?php _trans('lable141'); ?>
					</a>
					<button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default" value="1">
						<i class="fa fa-times"></i> <?php _trans('lable364');?>
					</button>
				</div>
			</div>
		</div>
	</section>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $("#btn_cancel").click(function () {
        window.location.href = "<?php echo site_url('mech_purchase'); ?>";
    });
});
</script>