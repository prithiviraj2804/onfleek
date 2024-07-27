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
                    <h3><?php _trans('lable121');?> <?php if($expense_details->expense_no) { echo " - ".$expense_details->expense_no; } ?></h3>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="row">
	<div class="col-xs-12 top-15">
		<a class="anchor anchor-back" href="<?php echo site_url('mech_expense/index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59');?></span></a>
	</div>
</div>
<div class="container-fluid usermanagement">
	<div class="paddingTop22px">
		<section class="card col-lg-10 col-md-10 col-sm-12 col-xs-12 col-centered">
            <div class="card-block invoice">
                <div class="row invoice-company_details">
                    <div class="col-lg-12">
                        <div class="company_logo">
                            <?php $company_details = $this->mdl_workshop_branch->get_company_branch_details($expense_details->branch_id); 
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
						<?php if($expense_details->branch_id){ ?>
						<div class="form-group clearfix">
							<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text-right"><?php _trans('lable95');?>:</div>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left"><?php echo $expense_details->display_board_name; ?></div>
						</div>
						<?php } if($expense_details->bill_no){ ?>
						<div class="form-group clearfix">
							<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text-right"><?php _trans('lable34');?>:</div>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left"><?php echo $expense_details->bill_no; ?></div>
						</div>
						<?php } if($expense_details->expense_date){ ?>
						<div class="form-group clearfix">
							<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text_align_right"><?php _trans('lable386');?>:</div>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left">
							<?php echo date_from_mysql($expense_details->expense_date); ?></div>
						</div>
						<?php } if($expense_details->expensTypeName){ ?>
    					<div class="form-group clearfix">
    						<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text_align_right"><?php _trans('lable454');?>:</div>
    						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left"><?php echo $expense_details->expensTypeName; ?>
    						</div>
						</div>
                        <?php } if($expense_details->amount){ ?>
						<div class="form-group clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text_align_right"><?php _trans('lable108');?>:</div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left"><?php echo ($expense_details->amount?format_money($expense_details->amount,$this->session->userdata('default_currency_digit')):0); ?>
    						</div>
    					</div>		
						<?php } ?>				
					</div>
                	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<?php if($expense_details->is_credit){ ?>
        				<div class="form-group clearfix">
        					<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text-right"><?php _trans('lable883');?>:</div>
        					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left"><?php if($expense_details->is_credit == "Y"){echo "Yes";}else{echo "No";}?></div>
						</div>
						<?php } if($expense_details->payment_methods_name){ ?>
							<div class="form-group clearfix">
        					<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text-right"><?php _trans('lable109');?>:</div>
        					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left"><?php echo $expense_details->payment_methods_name; ?></div>
						</div>
						<?php } if($expense_details->online_payment_ref_no){ ?>
							<div class="form-group clearfix">
        					<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text-right"><?php _trans('lable117');?>:</div>
        					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left"><?php echo $expense_details->online_payment_ref_no; ?></div>
						</div>
						<?php } if($expense_details->in_days){ ?>
							<div class="form-group clearfix">
        					<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text-right"><?php _trans('lable387');?>:</div>
        					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left"><?php echo $expense_details->in_days; ?></div>
						</div>
						<?php } if($expense_details->expense_date_due){ ?>
							<div class="form-group clearfix">
        					<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text-right"><?php _trans('lable127');?>:</div>
        					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left"><?php echo date_from_mysql($expense_details->expense_date_due); ?></div>
						</div>
						<?php } if($expense_details->employee_name){?>
        				<div class="form-group clearfix">
        					<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text-right"><?php _trans('lable148');?>:</div>
        					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left">
                           		<?php echo $expense_details->employee_name; ?>
        					</div>
						</div>
						<?php } ?>
                	</div>
    			</div>
    		</div>
    	</section>
    </div>

	<div class="paddingTop22px">
		<section class="card col-lg-10 col-md-10 col-sm-12 col-xs-12 col-centered">
    		<div class="card-block invoice">
    			<div class="row">
						<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 clearfix" style="float: right">
							<div class="total-amount row" style="float: left;width: 100%;">
								<br>
								<div class="row">
									<div class="col-lg-9 col-md-9 col-sm-9 clearfix">
										<b> <?php _trans('lable392'); ?></b><br>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3 price clearfix"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($expense_details->amount?$expense_details->amount:0),$this->session->userdata('default_currency_digit')); ?>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-9 col-md-9 col-sm-9 clearfix">
										<b><?php _trans('lable332'); ?></b><br>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-3 price clearfix" style="border-top:1px solid #000; margin-top: 5px">
										<b class="grand_total"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($expense_details->grand_total?$expense_details->grand_total:0),$this->session->userdata('default_currency_digit')); ?></b>
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
		<section class="col-lg-10 col-md-10 col-sm-12 col-xs-12 col-centered">
    		<div class="card-block invoice">
    			<div class="row invoiceFloatbtn">
					<div class="col-lg-12 clearfix buttons text-right">
						<a class="btn btn-rounded btn-primary" href="<?php echo site_url('mech_expense/create/'.$expense_details->expense_id); ?>">
							<i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
						</a>
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
        window.location.href = "<?php echo site_url('mech_expense'); ?>";
    });
});
</script>