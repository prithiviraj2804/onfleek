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
                    <h3><?php _trans('menu15');?> <?php if($purchase_details->purchase_no) { echo " - ".$purchase_details->purchase_no; } ?><span>
					<?php if(!empty($purchase_details->purchase_id)) { if($purchase_details->purchase_status == '1'){ ?>
					<a class="lable" style="font-size:large; color: green;"><?php echo 'Pending'; ?></a>
					<?php }else if($purchase_details->purchase_status == '2'){ ?>
					<a class="lable" style="font-size:large; color: green;"><?php echo 'Processing'; ?></a>
					<?php }else if($purchase_details->purchase_status == '3'){ ?>
					<a class="lable" style="font-size:large; color: green;"><?php echo 'Confirmed'; ?></a>
					<?php }else  if($purchase_details->purchase_status == '4'){ ?>
					<a class="lable" style="font-size:large; color: green;"><?php echo 'Out For Delivery'; ?></a>
					<?php }else if($purchase_details->purchase_status == '5'){ ?>
					<a class="lable" style="font-size:large; color: green;"><?php echo 'Delivered'; ?></a>
					<?php }else if($purchase_details->purchase_status == '6'){ ?>
					<a class="lable" style="font-size:large; color: green;"><?php echo 'Returned'; ?></a>
					<?php }else if($purchase_details->purchase_status == '9'){ ?>
					<a class="lable" style="font-size:large; color: green;"><?php echo 'Cancelled'; ?></a>
					<?php } } ?>
					</span></h3>
				</div>
				<div class="tbl-cell pull-right">
					<?php if(!empty($purchase_details->purchase_id)) { ?>
					<?php if($purchase_details->purchase_status == '1' || $purchase_details->purchase_status == '2' ){ ?>
						<a class="btn btn-sm btn-primary cancel_purchase" href="javascript:void(0)" onclick="cancel_purchase_order(<?php echo $purchase_details->purchase_id;?>,'<?= $this->security->get_csrf_hash(); ?>');" >
							<?php _trans('cancel'); ?>
						</a>
					<?php } if($purchase_details->purchase_status == '6'){ ?>
						<a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_purchase_order/return_order/'.$purchase_details->purchase_id); ?>">
						 <?php echo ('Return'); ?>
						</a>
					<?php }if($purchase_details->purchase_status == '5' && $purchase_details->convert_to_pur_order != 'Y'){ ?>
						<a class="btn btn-sm btn-success purchase_order" href="javascript:void(0)" data-toggle="modal" data-model-from="purchase_order" data-purchase_order_id="<?php echo $purchase_details->purchase_id;?>" data-target="#purchase_order">
						 <?php echo ('Completed'); ?>
						</a>
					<?php } } ?>
					<a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_purchase_order/create'); ?>">
						<i class="fa fa-plus"></i> <?php _trans('lable40'); ?>
					</a>
				</div>
            </div>
        </div>
    </div>
</header>
<div class="row">
	<div class="col-xs-12 top-15">
		<a class="anchor anchor-back" href="<?php echo site_url('mech_purchase_order/index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59');?></span></a>
	</div>
</div>
<div class="container-fluid usermanagement">
	<div class="paddingTop22px">
		<section class="card col-lg-11 col-md-10 col-sm-12 col-xs-12 col-centered">
            <div class="card-block invoice">
                <div class="row invoice-company_details">
                    <div class="col-lg-12">
                        <div class="company_logo">
                            <?php $company_details = $this->mdl_workshop_branch->get_company_branch_details($purchase_details->w_branch_id); 
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
						<?php if(!empty($purchase_details->purchase_date_due)){ ?>
						<div class="form-group clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text_align_right"><?php _trans('lable1036');?>:</div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left"><?php echo $purchase_details->purchase_date_due?date_from_mysql($purchase_details->purchase_date_due):''; ?>
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
    	</section>
    </div>

	<div class="paddingTop22px">
		<section class="card col-lg-11 col-md-10 col-sm-12 col-xs-12 col-centered">
    		<div class="card-block invoice">
    			<?php $this->layout->load_view('mech_purchase_order/partial_product_table_view'); ?>
           	</div>
    	</section>
	</div>

	
	<?php if(count($upload_details) > 0) { ?>
	<div class="paddingTop22px">
		<section class="card col-lg-11 col-md-10 col-sm-12 col-xs-12 col-centered">
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
                       					<a href="<?php echo base_url()."uploads/purchase_order_files/".$documentList->file_name_new?>" target="_blank" >
                       						<img src="<?php echo base_url()."uploads/purchase_order_files/".$documentList->file_name_new?>" width="50" height="50">
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
    	</section>
	</div>
	<?php } ?>

	<div class="paddingTop22px">
		<section class="card col-lg-11 col-md-10 col-sm-12 col-xs-12 col-centered">
    		<div class="card-block invoice">
    			<div class="row">
						<div class="col-lg-7 clearfix" style="float: right">
							<div class="total-amount row" style="float: left;width: 100%`">
							<?php if($is_product == "Y"){ ?>
								<div class="row">
									<div class="col-lg-7 col-md-7 col-sm-7 clearfix">
										<b> <?php _trans('lable347'); ?> </b>
									</div>
									<div class="col-lg-5 col-md-5 col-sm-5 price clearfix"></div>
								</div>
								<div class="row">
									<div class="col-lg-7 col-md-7 col-sm-7 clearfix">
										<?php _trans('lable339'); ?> :
									</div>
									<div class="col-lg-5 col-md-5 col-sm-5 price clearfix"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($purchase_details->product_user_total?$purchase_details->product_user_total:0),$this->session->userdata('default_currency_digit')); ?>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-7 col-md-7 col-sm-7 clearfix">
										<?php _trans('lable330'); ?> :
									</div>
									<div class="col-lg-5 col-md-5 col-sm-5 price clearfix"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($purchase_details->total_discount?$purchase_details->total_discount:0),$this->session->userdata('default_currency_digit')); ?>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-7 col-md-7 col-sm-7 clearfix">
										<?php _trans('lable392'); ?> :
									</div>
									<div class="col-lg-5 col-md-5 col-sm-5 price clearfix"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($purchase_details->total_taxable_amount?$purchase_details->total_taxable_amount:0),$this->session->userdata('default_currency_digit')); ?>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-7 col-md-7 col-sm-7 clearfix">
										<?php _trans('lable331'); ?> :
									</div>
									<div class="col-lg-5 col-md-5 col-sm-5 price clearfix"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($purchase_details->total_tax_amount?$purchase_details->total_tax_amount:0),$this->session->userdata('default_currency_digit')); ?>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-7 col-md-7 col-sm-7 clearfix">
										<b><?php _trans('lable332'); ?>:</b>
									</div>
									<div class="col-lg-5 col-md-5 col-sm-5 price clearfix" style="border-top:1px solid #000; margin-top: 5px">
										<b class="total_product_invoice"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($purchase_details->grand_total?$purchase_details->grand_total:0),$this->session->userdata('default_currency_digit')); ?></b>
									</div>
								</div>
								<?php } ?>
								<br>
								<div class="row" style="display:none">
									<div class="col-lg-9 col-md-9 col-sm-9 clearfix">
										<b><?php _trans('lable329'); ?></b> <br>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3 price clearfix">
									<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($purchase_details->total_taxable_amount?$purchase_details->total_taxable_amount:0),$this->session->userdata('default_currency_digit')); ?>
									</div>
								</div>
								<div class="row" style="display:none">
									<div class="col-lg-9 col-md-9 col-sm-9 clearfix">
										<b><?php _trans('lable902'); ?></b> <br>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3 price clearfix"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($purchase_details->total_discount?$purchase_details->total_discount:0),$this->session->userdata('default_currency_digit')); ?>
									</div>
								</div>
								<div class="row" style="display:none">
									<div class="col-lg-9 col-md-9 col-sm-9 clearfix">
										<b> <?php _trans('lable901'); ?></b><br>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3 price clearfix"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($purchase_details->total_tax_amount?$purchase_details->total_tax_amount:0),$this->session->userdata('default_currency_digit')); ?>
									</div>
								</div>
								<div class="row" style="display:none">
									<div class="col-lg-9 col-md-9 col-sm-9 clearfix">
										<b><?php _trans('lable332'); ?></b><br>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3 price clearfix" style="border-top:1px solid #000; margin-top: 5px">
										<b class="grand_total"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($purchase_details->grand_total?$purchase_details->grand_total:0),$this->session->userdata('default_currency_digit')); ?></b>
									</div>
								</div>
								<br>
							</div>
                        </div>
					</div>
				</div>
        	</div>
    	</section>
	</div>
	
	<div class="paddingTop22px">
		<section class="col-lg-11 col-md-10 col-sm-12 col-xs-12 col-centered">
    		<div class="card-block invoice">
    			<div class="row invoiceFloatbtn">
					<div class="col-lg-12 clearfix buttons text-right">
						<?php if($purchase_details->purchase_status < 3){ ?>
							<a class="btn btn-rounded btn-primary" href="<?php echo site_url('mech_purchase_order/create/'.$purchase_details->purchase_id); ?>">
								<i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
							</a>
						<?php } if($purchase_details->purchase_status > 3 && $purchase_details->purchase_status != 9){ ?>
						<a class="btn btn-rounded btn-primary btn-padding-left-right-40" target="_blank" href="<?php echo site_url('mech_purchase_order/generate_pdf/'.$purchase_details->purchase_id); ?>">
							<i class="fa fa-edit fa-margin"></i> <?php _trans('lable141'); ?>
					    </a>
						<?php } ?>
						<button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default" value="1">
							<i class="fa fa-times"></i> <?php _trans('lable364');?>
						</button>
					</div>
				</div>
           	</div>
       	</section>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $("#btn_cancel").click(function () {
        window.location.href = "<?php echo site_url('mech_purchase_order'); ?>";
    });
});
</script>