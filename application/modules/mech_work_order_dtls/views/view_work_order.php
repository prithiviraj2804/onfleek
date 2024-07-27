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
                    <h3><?php _trans('lable269');?> <?php if($work_order_detail->jobsheet_no) { echo " - ".$work_order_detail->jobsheet_no; } ?></h3>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="row">
	<div class="col-xs-12 top-15">
		<a class="anchor anchor-back" href="<?php echo site_url('mech_work_order_dtls/index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59');?></span></a>
	</div>
</div>
<div class="container-fluid viewPages">
	<div class="paddingTop22px">
		<section class="card col-lg-10 col-md-10 col-sm-12 col-xs-12 col-centered">
            <div class="card-block invoice">
                <div class="row invoice-company_details">
                    <div class="col-lg-12">
                        <div class="company_logo">
                            <?php $company_details = $this->mdl_workshop_branch->get_company_branch_details($work_order_detail->branch_id); 
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
						<?php if($work_order_detail->display_board_name){ ?>
						<div class="form-group clearfix">
							<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text-right"><?php _trans('lable95');?>:</div>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left"><?php echo $work_order_detail->display_board_name; ?></div>
						</div>
						<?php } if($work_order_detail->client_name){ ?>
						<div class="form-group clearfix">
							<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text_align_right"><?php _trans('lable279');?>:</div>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left">
								<?php echo $work_order_detail->client_name." ".($work_order_detail->client_contact_no?" (".$work_order_detail->client_contact_no." )":""); ?>
							</div>
						</div>
						<?php } ?>
    					<div class="form-group clearfix">
    						<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text_align_right"><?php _trans('lable280');?>:</div>
    						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left">
                       			<?php echo $work_order_detail->brand_name." ,".$work_order_detail->model_name." ".($work_order_detail->variant_name?",".$work_order_detail->variant_name:"")."(".$work_order_detail->car_reg_no.")"; ?>
    						</div>
						</div>
						<?php if($work_order_detail->user_address_id){ ?>
						<div class="form-group clearfix">
    						<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text_align_right"><?php _trans('lable61');?>:</div>
    						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left">
								<?php echo $this->mdl_user_address->get_user_complete_address($work_order_detail->user_address_id); ?>
    						</div>
    					</div>
						<?php } if($work_order_detail->current_odometer_reading){?>
    					<div class="form-group clearfix">
        					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text_align_right"><?php _trans('lable283');?>:</div>
        					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left"><?php echo ($work_order_detail->current_odometer_reading?$work_order_detail->current_odometer_reading:"");?></div>
						</div>
						<?php } if($work_order_detail->fuel_level){ ?>
        				<div class="form-group clearfix">
        					<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text_align_right"><?php _trans('lable284');?>:</div>
        					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left">
                                <?php echo ($work_order_detail->fuel_level?$work_order_detail->fuel_level:""); ?>
        					</div>
						</div>
						<?php } if($work_order_detail->status_name){?>
        				<div class="form-group clearfix">
        					<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text-right"><?php _trans('lable19');?>:</div>
        					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left">
							<?php echo ($work_order_detail->status_name?$work_order_detail->status_name:""); ?>
        					</div>
						</div>
						<?php } if($work_order_detail->issue_date){?>
        				<div class="form-group clearfix">
        					<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text-right"><?php _trans('lable362');?>:</div>
        					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left"><?php echo date_from_mysql($work_order_detail->issue_date); ?></div>
						</div>
						<?php } if($work_order_detail->next_service_dt){ ?>
        				<div class="form-group clearfix">
        					<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text-right"><?php _trans('lable299');?>:</div>
        					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left"><?php echo ($work_order_detail->next_service_dt?date_from_mysql($work_order_detail->next_service_dt):""); ?></div>
						</div>
						<?php } if($work_order_detail->start_date){ ?>
						<div class="form-group clearfix">
							<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text-right"><?php _trans('lable361');?>:</div>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left"><?php if($work_order_detail->start_date != "" && $work_order_detail->start_date != "0000-00-00 00:00:00"){echo date("d-m-Y H:i:s", strtotime($work_order_detail->start_date));} ?></div>
						</div>		
						<?php } ?>				
					</div>
                	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<?php if($work_order_detail->end_date){ ?>
        				<div class="form-group clearfix">
        					<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text-right"><?php _trans('lable360');?>:</div>
        					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left"><?php if($work_order_detail->end_date != "" && $work_order_detail->end_date != "0000-00-00 00:00:00"){echo date("d-m-Y H:i:s", strtotime($work_order_detail->end_date));} ?></div>
						</div>
						<?php } if($work_order_detail->refererTypeName){?>
        				<div class="form-group clearfix">
        					<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text-right"><?php _trans('lable52');?>:</div>
        					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left">
                           		<?php echo $work_order_detail->refererTypeName; ?>
        					</div>
						</div>
						<?php } if($work_order_detail->refererName){?>
        				<div class="form-group clearfix">
        					<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text-right"><?php _trans('lable291');?>:</div>
        					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left">
								<?php echo $work_order_detail->refererName; ?>
        					</div>
						</div>
						<?php } if($work_order_detail->issued_by){?>
        				<div class="form-group clearfix">
        					<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text-right"><?php _trans('lable359');?>:</div>
        					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left">
                            	<?php echo $work_order_detail->user_name; ?>
        					</div>
						</div>
						<?php } if($work_order_detail->assigned_name){?>
        				<div class="form-group clearfix">
        					<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text-right"><?php _trans('lable358');?>:</div>
        					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left">
                            	<?php echo $work_order_detail->assigned_name; 	?>
        					</div>
						</div>
						<?php } if($work_order_detail->invoice_number){?>
        				<div class="form-group clearfix">
        					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right"><?php _trans('lable271');?>:</div>
        					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left"><?php echo $work_order_detail->invoice_number; ?></div>
						</div>
						<?php } ?>
                	</div>
    			</div>
    		</div>
	<?php if(count($selected_checkin_list) > 0){ 
	    $showhide = 'display:block'; 
	}else{
	    $showhide = 'display:none'; 
	}?>
	<?php if(count($selected_checkin_list) > 0){?>
			<div class="card-block invoice">
    			<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12" >
    				<div class="col-lg-6 col-lg-6 col-sm-6 col-xs-12" style="padding-left: 0px;"><h4 style="margin-bottom: 0px;"><?php _trans('lable296');?></h4></div>
    				<div class="col-lg-6 col-lg-6 col-sm-6 col-xs-12 text_align_right">
    					<label class="switch">
    						<input type="checkbox" class="checkbox" name="checkbox" id="checkinCheckBox" <?php if(count($selected_checkin_list) > 0){ echo "checked"; }?> value="<?php if(count($selected_checkin_list) > 0){ echo "1"; } else{ echo '0'; }?>" >
    						<span class="slider round"></span>
    					</label>
    				</div>
    			</div>
    			<div class="collapse col-lg-12 col-lg-12 col-sm-12 col-xs-12 paddingTop20px <?php if(count($selected_checkin_list) > 0){ echo "in"; }?>"  id="checkincollapse">
        			<div id="checkinListDatas" class="col-lg-12 col-lg-12 col-sm-12 col-xs-12 paddingTop7px">
        				<?php if(count($checkIn_list) > 0){  
        			     foreach ($checkIn_list as $checkInList) { 
        			     foreach($selected_checkin_list as $selectedCheckinList){
        			     if($selectedCheckinList->checkin_prod_id == $checkInList->checkin_prod_id){  ?>
        				<div class="multi-field col-lg-4 col-md-6 col-lg-4 col-sm-4 col-xs-12">
        			    	<div class="form-group clearfix">
        			        	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text_align_left paddingTop5px">
        			                 <input type="checkbox" class="checkbox select_all_row checkin_prod_id" checked name="select_all_row" value="<?php echo $checkInList->checkin_prod_id; ?>" disabled>
        			    		</div>
        			    		<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 text_align_left"><?php echo $checkInList->prod_name; ?></div>
            					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 padding0px ">
            						<?php echo $selectedCheckinList->checkin_count; ?>
            					</div>
            				</div>
            			</div>
            			<?php } } } } ?>
        			</div>
    			</div>
			</div>
	<?php } ?>
	
	<?php if($service_remainder->serviceCheckBox == 1){ ?>
	
			<div class="card-block invoice">
    			<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12" >
    				<div class="col-lg-6 col-lg-6 col-sm-6 col-xs-12" style="padding-left: 0px;"><h4 style="margin-bottom: 0px;"><?php _trans('lable297');?></h4></div>
    				<div class="col-lg-6 col-lg-6 col-sm-6 col-xs-12 text_align_right">
    					<label class="switch">
    						<input type="checkbox" class="checkbox" <?php if($service_remainder->serviceCheckBox == 1){ echo "checked"; } ?> name="checkbox" id="serviceCheckBox" value="<?php echo $service_remainder->serviceCheckBox; ?>" data-target="service">
    						<span class="slider round"></span>
    					</label>
    				</div>
    			</div>
    			<div class="collapse col-lg-12 col-lg-12 col-sm-12 col-xs-12 paddingTop20px <?php if($service_remainder->serviceCheckBox == 1){ echo 'in'; }?>" id="servicecollapse">
            		<div class="form-group clearfix">
    					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
    						<label class="control-label string required"><?php _trans('lable298');?>:</label>
    					</div>
    					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 paddingTop7px">
    						 <?php echo $service_remainder->next_service_km; ?>
    					</div>
    				</div>
    				<div class="form-group clearfix">
    					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
    						<label class="control-label string required"><?php _trans('lable299');?>:</label>
    					</div>
    					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 paddingTop7px">
    						 <?php echo date_from_mysql($service_remainder->next_service_date); ?>
    					</div>
    				</div>
    			</div>
			</div>
	<?php } ?>
	
	<?php if($insurance_remainder->insuranceCheckBox == 1) { ?>
	
    		<div class="card-block invoice">
				<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12" >
					<div class="col-lg-6 col-lg-6 col-sm-6 col-xs-12" style="padding-left: 0px;"><h4 style="margin-bottom: 0px;"><?php _trans('lable300');?></h4></div>
					<div class="col-lg-6 col-lg-6 col-sm-6 col-xs-12 text_align_right ">
						<label class="switch">
							<input type="checkbox" class="checkbox" <?php if($insurance_remainder->insuranceCheckBox == 1) { echo 'checked'; }?> name="checkbox" id="insuranceCheckBox" value="<?php echo $insurance_remainder->insuranceCheckBox; ?>" data-target="insurance">
							<span class="slider round"></span>
						</label>
					</div>
				</div>
    			<div class="collapse col-lg-12 col-lg-12 col-sm-12 col-xs-12 paddingTop20px <?php if($insurance_remainder->insuranceCheckBox == 1) { echo 'in'; }?>" id="insurancecollapse" >
              		<div class="form-group clearfix">
    					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
    						<label class="control-label string required"><?php _trans('lable301');?>:</label>
    					</div>
    					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 paddingTop7px">
    						 <?php echo $insurance_remainder->policy_number; ?>
    					</div>
    				</div>
    				<div class="form-group clearfix">
    					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
    						<label class="control-label string required"><?php _trans('lable299');?>:</label>
    					</div>
    					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 paddingTop7px">
    						<?php echo date_from_mysql($insurance_remainder->next_service_ins_date); ?>
    					</div>
    				</div>
    				<div class="form-group clearfix">
    					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
    						<label class="control-label string required"><?php _trans('lable174');?>:</label>
    					</div>
    					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 paddingTop7px">
    						 <?php echo $insurance_remainder->ins_company_name; ?>
    					</div>
    				</div>
    				<div class="form-group clearfix">
    					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
    						<label class="control-label string required"><?php _trans('lable303');?>:</label>
    					</div>
    					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 paddingTop7px">
    						<?php echo $insurance_remainder->job_type; ?>
    					</div>
    				</div>
				</div>
           	</div>
	<?php } ?>
	<?php if($work_order_detail->insuranceBillingCheckBox == 1) { ?>

    		<div class="card-block invoice">
				<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12" >
					<div class="col-lg-6 col-lg-6 col-sm-6 col-xs-12 paddingLeft0px"><h4 style="margin-bottom: 0px;"><?php _trans('lable304'); ?></h4></div>
					<div class="col-lg-6 col-lg-6 col-sm-6 col-xs-12 text_align_right ">
						<label class="switch">
							<input type="checkbox" class="checkbox" <?php if($work_order_detail->insuranceBillingCheckBox == 1) { echo 'checked'; }?> name="checkbox" id="insuranceBillingCheckBox" value="<?php echo $insurance_billing->insuranceBillingCheckBox; ?>" data-target="insurancebilling">
							<span class="slider round"></span>
						</label>
					</div>
				</div>
				<div class="collapse col-lg-12 col-lg-12 col-sm-12 col-xs-12 paddingTop20px <?php if($work_order_detail->insuranceBillingCheckBox == 1) { echo 'in'; }?>" id="insurancebillingcollapse" >
					<div class="row m-b-1">
						<div class="col-lg-6 col-md-6 col-sm-6">
							<?php if($work_order_detail->policy_no){ ?>
							<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable301');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left"><?php echo $work_order_detail->policy_no; ?></div>
							</div>
							<?php } if($work_order_detail->driving_license){ ?>
							<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable918');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left"><?php echo $work_order_detail->driving_license; ?></div>
							</div>
							<?php } if($work_order_detail->ins_pro_name) { ?>
							<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable311');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left"><?php echo $work_order_detail->ins_pro_name; ?></div>
							</div>
							<?php } if($work_order_detail->ins_claim_type){ ?>
							<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable307');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left">
									<?php if($work_order_detail->ins_claim_type == 1){ echo "Cashless"; }?>
									<?php if($work_order_detail->ins_claim_type == 2){ echo "Reimburse"; }?>
								</div>
							</div>
							<?php } if($work_order_detail->ins_gstin_no) { ?>
							<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable910');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left"><?php echo $work_order_detail->ins_gstin_no; ?></div>
							</div>
							<?php } if($work_order_detail->contact_name) { ?>
							<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable912');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left"><?php echo $work_order_detail->contact_name; ?></div>
							</div>
							<?php } if($work_order_detail->contact_number) {?>
							<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable913');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left"><?php echo $work_order_detail->contact_number; ?></div>
							</div>
							<?php } if($work_order_detail->contact_email){ ?>
							<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable914');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left"><?php echo $work_order_detail->contact_email; ?></div>
							</div>
							<?php } if($work_order_detail->contact_street){?>
							<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable915');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left"><?php echo $work_order_detail->contact_street; ?></div>
							</div>
							<?php } if($work_order_detail->contact_area){ ?>
							<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable916');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left"><?php echo $work_order_detail->contact_area; ?></div>
							</div>
							<?php } if($work_order_detail->countryName){ ?>
							<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable86');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left"><?php echo $work_order_detail->countryName; ?></div>
							</div>
							<?php } if($work_order_detail->statename){?>
							<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable87');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left"><?php echo $work_order_detail->statename; ?></div>
							</div>
							<?php } if($work_order_detail->cityname){ ?>
							<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable88');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left"><?php echo $work_order_detail->cityname; ?></div>
							</div>
							<?php } if($work_order_detail->contact_pincode){?>
							<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable917');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left"><?php echo $work_order_detail->contact_pincode; ?></div>
							</div>
							<?php } ?>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<?php if($work_order_detail->ins_start_date){ ?>
							<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable312');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left"><?php echo date_from_mysql($work_order_detail->ins_start_date); ?></div>
							</div>
							<?php } if($work_order_detail->ins_exp_date){ ?>
							<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable313');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left"><?php echo date_from_mysql($work_order_detail->ins_exp_date); ?></div>
							</div>
							<?php } if($work_order_detail->surveyor_contact_no){ ?>
							<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable321');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left"><?php echo $work_order_detail->surveyor_contact_no; ?></div>
							</div>
							<?php } if($work_order_detail->surveyor_name){?>
							<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable320');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left"><?php echo $work_order_detail->surveyor_name; ?></div>
							</div>
							<?php } if($work_order_detail->surveyor_email){ ?>
							<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable911');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left"><?php echo $work_order_detail->surveyor_email; ?></div>
							</div>
							<?php } if($work_order_detail->idv_amount){ ?>
							<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable314');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left"><?php echo $work_order_detail->idv_amount; ?></div>
							</div>
							<?php } if($work_order_detail->ins_claim_no){ ?>
								<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable315');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left"><?php echo $work_order_detail->ins_claim_no; ?></div>
							</div>
							<?php } if($work_order_detail->date_of_claim){ ?>
							<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable316');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left"><?php echo date_from_mysql($work_order_detail->date_of_claim); ?></div>
							</div>
							<?php } if($work_order_detail->claim_amount){ ?>
							<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable317');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left"><?php echo $work_order_detail->claim_amount; ?></div>
							</div>
							<?php } if($work_order_detail->ins_approved_amount){ ?>
							<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable318');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left"><?php echo $work_order_detail->ins_approved_amount; ?></div>
							</div>
							<?php } if($work_order_detail->ins_approved_date){?>
							<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable319');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left"><?php echo date_from_mysql($work_order_detail->ins_approved_date); ?></div>
							</div>
							<?php } if($work_order_detail->ins_status){  ?>
							<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable322');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left">
									<?php if($work_order_detail->ins_status == 1){ echo "Claim Intimation"; }?>
									<?php if($work_order_detail->ins_status == 2){ echo "Entered"; }?>
								</div>
							</div>
							<?php } if($work_order_detail->policy_excess){ ?>
							<div class="form-group clearfix">
								<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right"><?php _trans('lable326');?>:</div>
								<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text_align_left"><?php echo $work_order_detail->policy_excess; ?></div>
							</div>
							<?php } ?>
						</div>
					</div>
           		</div>
			</div>
	<?php } ?>

			<?php if(count(json_decode($product_list)) > 0){ ?>
    		<div class="card-block invoice">
    			<?php $this->layout->load_view('mech_work_order_dtls/partial_product_table_view'); ?>
           	</div>
			<?php } ?>
			<?php if(count(json_decode($service_list)) > 0){ ?>
    		<div class="card-block invoice">
    			<?php $this->layout->load_view('mech_work_order_dtls/partial_service_table_view'); ?>
           	</div>
			<?php } ?>
			<?php if(count(json_decode($service_package_list)) > 0){ ?>
    		<div class="card-block invoice">
    			<?php $this->layout->load_view('mech_work_order_dtls/partial_service_package_table_view'); ?>
           	</div>
			<?php } ?>
	
	<?php if(count($upload_details) > 0) { ?>
	
    		<div class="card-block invoice">
				<div class="col-lg-12 col-lg-12 col-sm-12 col-xs-12" >
					<div class="col-lg-6 col-lg-6 col-sm-6 col-xs-12" style="padding-left: 0px;"><h4 style="margin-bottom: 0px;"><?php _trans('lable327');?></h4></div>
					<div class="col-lg-6 col-lg-6 col-sm-6 col-xs-12 text_align_right ">
						<label class="switch">
							<input type="checkbox" class="checkbox"<?php if($work_order_detail->uploadCheckBox == 1){ echo "checked"; } ?> name="checkbox" id="uploadCheckBox" value="<?php echo $work_order_detail->uploadCheckBox; ?>" data-target="upload">
							<span class="slider round"></span>
						</label>
					</div>
				</div>
    			<div class="collapse col-lg-12 col-lg-12 col-sm-12 col-xs-12 paddingTop20px <?php if($work_order_detail->uploadCheckBox == 1){ echo "in"; } ?>" id="uploadcollapse" >
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
                       					<a href="<?php echo base_url()."uploads/jobcard_files/".$documentList->file_name_new?>" target="_blank" >
                       						<img src="<?php echo base_url()."uploads/jobcard_files/".$documentList->file_name_new?>" width="50" height="50">
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

			<div class="fourthSection paddingBottom25px">
				<div class="card-block invoice">
					<div class="row">
						<div class="col-lg-12">
							<div class="col-lg-5 clearfix" style="float: left">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align:justify;">
									<div class="form_group">
	    					 			<?php if(!empty($work_order_detail->job_terms_condition)) { ?>
										<strong><?php _trans('lable388'); ?></strong><br>
	    								<div class="form_controls">
										<?php echo $work_order_detail->job_terms_condition; ?>
										</div>
	    								<?php } ?>
    							    </div>
									<br>
									<div class="form_group">
										<?php if(!empty($work_order_detail->description) && $work_order_detail->description != '' && $work_order_detail->description != null) { ?>
										<label class="control-label string required text_align_left"><?php _trans('lable328'); ?></label>
										<div class="form_controls">
											<textarea disabled name="description" id="description" class="form-control"><?php echo $work_order_detail->description; ?> </textarea>
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="col-lg-7 clearfix" style="float: right">
								<div class="total-amount row" style="float: left;width: 100%`">
								<?php if($is_product == "Y"){ 
									if(count(json_decode($product_list)) > 0){ ?>
									<div class="row">
										<div class="col-lg-7 col-md-7 col-sm-7 clearfix">
											<?php _trans('lable356'); ?>:
										</div>
										<div class="col-lg-5 col-md-5 col-sm-5 price clearfix">
											<span class="total_product_invoice"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($work_order_detail->product_grand_total?$work_order_detail->product_grand_total:0),$this->session->userdata('default_currency_digit')); ?></span>
										</div>
									</div>
									<?php } } if(count(json_decode($service_list)) > 0){ ?>
									<div class="row">
										<div class="col-lg-9 col-md-7 col-sm-9 clearfix">
											<?php _trans('lable393'); ?>: 
										</div>
										<div class="col-lg-3 col-md-5 col-sm-3 price clearfix">
											<span class="total_servie_invoice"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($work_order_detail->service_grand_total?$work_order_detail->service_grand_total:0),$this->session->userdata('default_currency_digit')); ?></span>
										</div>
									</div>
									<?php } if(count(json_decode($service_package_list)) > 0){ ?>
									<div class="row">
										<div class="col-lg-9 col-md-7 col-sm-9 clearfix">
											<?php _trans('label960'); ?>: 
										</div>
										<div class="col-lg-3 col-md-5 col-sm-3 price clearfix">
											<span class="total_servie_package_invoice"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($work_order_detail->service_package_grand_total?$work_order_detail->service_package_grand_total:0),$this->session->userdata('default_currency_digit')); ?></span>
										</div>
									</div>
									<?php } ?>
									<div class="row">
										<div class="col-lg-9 col-md-7 col-sm-9 clearfix">
											<b><?php _trans('lable332'); ?></b>
										</div>
										<div class="col-lg-3 col-md-5 col-sm-3 price clearfix" style="border-top:1px solid #000; margin-top: 5px">
											<b class="grand_total"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($work_order_detail->grand_total?$work_order_detail->grand_total:0),$this->session->userdata('default_currency_digit')); ?></b>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-9 col-md-9 col-sm-9 clearfix">
											<?php _trans('lable1020'); ?>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-3 price clearfix">
											<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<span class="advance_amount_label"><?php echo format_money(($work_order_detail->advance_paid?$work_order_detail->advance_paid:0),$this->session->userdata('default_currency_digit')); ?></span>
										</div>
										<input type="hidden" id="advance_paid_amount" name="advance_paid_amount" value="<?php echo $work_order_detail->advance_paid;?>" autocomplete="off">
									</div>
									<div class="row">
										<div class="col-lg-9 col-md-9 col-sm-9 clearfix">
											<?php _trans('lable1021'); ?>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-3 price clearfix">
											<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<span class="total_due_amount_lable"><?php echo format_money(($work_order_detail->total_due_amount?$work_order_detail->total_due_amount:0),$this->session->userdata('default_currency_digit')); ?></span>
										</div>
										<input type="hidden" id="total_due_amount" name="total_due_amount" value="<?php echo $work_order_detail->total_due_amount;?>" autocomplete="off">
									</div>
									<br>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
    		<div class="card-block invoice">
    			<div class="row invoiceFloatbtn">
					<div class="col-lg-12 clearfix buttons text-right">
						<a class="btn btn-rounded btn-primary" href="<?php echo site_url('mech_work_order_dtls/book/'.$work_order_detail->work_order_id); ?>">
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
	$("#checkinCheckBox").click(function(){
		if($("#checkinCheckBox:checked").is(":checked")){
			$("#checkincollapse").addClass('in');
			$("#checkinCheckBox").val(1);
		}else{
			$("#checkincollapse").removeClass('in');
			$("#checkinCheckBox").val(0);
		}
	});
	$("#serviceCheckBox").click(function(){
		if($("#serviceCheckBox:checked").is(":checked")){
			$("#servicecollapse").addClass('in');
			$("#serviceCheckBox").val(1);
		}else{
			$("#servicecollapse").removeClass('in');
			$("#serviceCheckBox").val(0);
		}
	});
	$("#insuranceCheckBox").click(function(){
		if($("#insuranceCheckBox:checked").is(":checked")){
			$("#insurancecollapse").addClass('in');
			$("#insuranceCheckBox").val(1);
		}else{
			$("#insurancecollapse").removeClass('in');
			$("#insuranceCheckBox").val(0);
		}
	});
	$("#insuranceBillingCheckBox").click(function(){
		if($("#insuranceBillingCheckBox:checked").is(":checked")){
			$("#insurancebillingcollapse").addClass('in');
			$("#insuranceBillingCheckBox").val(1);
		}else{
			$("#insurancebillingcollapse").removeClass('in');
			$("#insuranceBillingCheckBox").val(0);
		}
	});
	
	$("#uploadCheckBox").click(function(){
		if($("#uploadCheckBox:checked").is(":checked")){
			$("#uploadcollapse").addClass('in');
			$("#uploadCheckBox").val(1);
		}else{
			$("#uploadcollapse").removeClass('in');
			$("#uploadCheckBox").val(0);
		}
	});
    $("#btn_cancel").click(function () {
        window.location.href = "<?php echo site_url('mech_work_order_dtls'); ?>";
    });
});
</script>
