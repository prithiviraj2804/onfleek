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
                    <h3><?php _trans('menu10');?> <?php if($mech_leads->leads_no) { echo " - ".$mech_leads->leads_no; } ?></h3>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="row">
	<div class="col-xs-12 top-15">
        <a class="anchor anchor-back" href="<?php echo site_url('mech_appointments/index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59');?></span></a>
	</div>
</div>
<div class="container-fluid viewPages">
	<div class="paddingTop22px">
		<section class="card col-lg-10 col-md-10 col-sm-12 col-xs-12 col-centered">
            <div class="card-block invoice">
                <div class="row invoice-company_details">
                    <div class="col-lg-12">
                        <div class="company_logo">
                            <?php $company_details = $this->mdl_workshop_branch->get_company_branch_details($mech_leads->branch_id); 
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
                	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-left">
					<?php if ($mech_leads->display_board_name){ ?>
						<div class="form-group clearfix">
        					<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text_align_right"><?php _trans('lable95');?>:</div>
        					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left">
								<?php echo $mech_leads->display_board_name;?>
							</div>
        				</div>
						<?php } if ($mech_leads->client_name){ ?>
                		<div class="form-group clearfix">
    						<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text_align_right"><?php _trans('lable510');?>:</div>
    						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left">
                            	<?php echo $mech_leads->client_name;?>
    						</div>
    					</div>
						<?php } ?>
    					<div class="form-group clearfix">
    						<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text_align_right"><?php _trans('lable280');?>:</div>
    						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left">
                       			<?php echo $mech_leads->brand_name." ".($mech_leads->model_name?", ".$mech_leads->model_name:"")." ".($mech_leads->variant_name?",".$mech_leads->variant_name:"")."<span class='car_reg_no'>".($mech_leads->car_reg_no?"( ".$mech_leads->car_reg_no." )":"")."</span>"; ?>
    						</div>
    					</div>
    					<div class="form-group clearfix">
    						<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text_align_right"><?php _trans('lable61');?>:</div>
    						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left">
                       		<?php $full_address = $this->mdl_user_address->get_user_complete_address($mech_leads->user_address_id);
                                if (!empty($mech_leads)) {
                                    if ($mech_leads->user_address_id) {
                                        echo '<p style="display:block;
										overflow: hidden;
										text-align: left;
										text-overflow: clip;
										white-space: normal;">'.$full_address."</p>";
                                    }
                                }?>
    						</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 pull-left">
					<p style="display:block;">
					    <?php if ($mech_leads->reschedule_date){ ?>
						<div class="form-group clearfix">
        					<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text_align_right"><?php _trans('lable487');?>:</div>
        					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left">
							<?php if($mech_leads->reschedule_date != "" && $mech_leads->reschedule_date != "0000-00-00 00:00:00"){echo date("d-m-Y H:i:s", strtotime($mech_leads->reschedule_date));} ?>
        					</div>
						</div>
						<?php } if ($mech_leads->title){ ?>	
						<div class="form-group clearfix">
        					<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text_align_right"><?php _trans('lable496');?>:</div>
        					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left">
                                <?php echo $mech_leads->title; ?>
        					</div>
						</div>
						<?php } if ($mech_leads->employee_name){ ?>	
        				<div class="form-group clearfix">
        					<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text_align_right"><?php _trans('lable495');?>:</div>
        					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left">
								<?php echo $mech_leads->employee_name;?>
        					</div>
						</div>
						<?php } if ($mech_leads->lead_source_name){ ?>	
						<div class="form-group clearfix">
        					<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text_align_right"><?php _trans('lable499');?>:</div>
        					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left">
								<?php echo $mech_leads->lead_source_name;?>
        					</div>
						</div>
						<?php } if ($mech_leads->status_label){ ?>	
						<div class="form-group clearfix">
        					<div class="col-lg-4 col-md-4 col-sm-4  col-xs-12 text_align_right"><?php _trans('lable509');?>:</div>
        					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text_align_left">
								<?php echo $mech_leads->status_label;?>
        					</div>
						</div>
						<?php } ?>
                	</div>
					</p>
    			</div>
    		</div>

			<?php if(count(json_decode($product_list)) > 0){ ?>
    		<div class="card-block invoice">
    			<?php $this->layout->load_view('mech_appointments/partial_product_table_view'); ?>
           	</div>
			<?php } ?>
			<?php if(count(json_decode($service_list)) > 0){ ?>
    		<div class="card-block invoice">
    			<?php $this->layout->load_view('mech_appointments/partial_service_table_view'); ?>
           	</div>
			<?php } ?>
			<?php if(count(json_decode($service_package_list)) > 0){ ?>
    		<div class="card-block invoice">
    			<?php $this->layout->load_view('mech_appointments/partial_service_package_table_view'); ?>
           	</div>
			<?php } ?>
			<div class="fourthSection paddingBottom25px">
				<div class="card-block invoice">
					<div class="row">
						<div class="col-lg-12">
							<div class="col-lg-5 clearfix" style="float: left">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align:justify;">
									<div class="form_group">
										<?php if(!empty($mech_leads->description) && $mech_leads->description != '' && $mech_leads->description != null) { ?>
										<label class="control-label string required text_align_left"><?php _trans('lable328'); ?></label>
										<div class="form_controls">
											<textarea disabled name="description" id="description" class="form-control"><?php echo $mech_leads->description; ?> </textarea>
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
											<span class="total_product_invoice"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($mech_leads->product_grand_total?$mech_leads->product_grand_total:0),$this->session->userdata('default_currency_digit')); ?></span>
										</div>
									</div>
									<?php } } if(count(json_decode($service_list)) > 0){ ?>
									<div class="row">
										<div class="col-lg-9 col-md-7 col-sm-9 clearfix">
											<?php _trans('lable393'); ?>: 
										</div>
										<div class="col-lg-3 col-md-5 col-sm-3 price clearfix">
											<span class="total_servie_invoice"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($mech_leads->service_grand_total?$mech_leads->service_grand_total:0),$this->session->userdata('default_currency_digit')); ?></span>
										</div>
									</div>
									<?php } if(count(json_decode($service_package_list)) > 0){ ?>
									<div class="row">
										<div class="col-lg-9 col-md-7 col-sm-9 clearfix">
											<?php _trans('label960'); ?>: 
										</div>
										<div class="col-lg-3 col-md-5 col-sm-3 price clearfix">
											<span class="total_servie_package_invoice"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($mech_leads->service_package_grand_total?$mech_leads->service_package_grand_total:0),$this->session->userdata('default_currency_digit')); ?></span>
										</div>
									</div>
									<?php } ?>
									<div class="row">
										<div class="col-lg-9 col-md-7 col-sm-9 clearfix">
											<b><?php _trans('lable332'); ?></b>
										</div>
										<div class="col-lg-3 col-md-5 col-sm-3 price clearfix" style="border-top:1px solid #000; margin-top: 5px">
											<b class="grand_total"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($mech_leads->grand_total?$mech_leads->grand_total:0),$this->session->userdata('default_currency_digit')); ?></b>
										</div>
									</div>
									<br>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php if(count($comments) > 0) { ?>
			<div class="card-block invoice">
				<div class="row invoice-company_details">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 20px 15px;">
						<h3><?php _trans('lable328');?></h3>
					</div>
					<?php 
					foreach($comments as $key => $commentslist){ ?>
					<div class="form-group clearfix actnotes">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div id="parentDiv_<?php echo $commentslist->comment_id;?>" class="singleNoteBorder addedNotesList pT7 pB7">
								<table cellpadding="0" cellspacing="0" class="w100p">
									<tbody>
										<tr class="pR w100p pB0">
											<td class="aligntop notesUserImg">
												<span class="feedsImgHolder16 dIB mT7 pL5">
													<img align="absmiddle" src="<?php echo base_url(); ?>assets/mp_backend/img/user.png">
												</span>
											</td>
											<td class="pL10 pR10 w100p pR">
												<div class="pB5 cBafter">
													<pre id="ncontent_<?php echo $commentslist->comment_id;?>" wrap="soft" class="pre f14 fL cB col333 p5 paddingTop10px "><?php echo $commentslist->comments;?></pre>
													<span style="clear:left;"></span>
													<span class="note_edit_div w100p dIB float_left cB" style="box-sizing: border-box;">
													</span>
													<div class="mT5 p5 f12 gray2 float_left cB lh20 notesBtmDet">
														<span class="notesModdet float_left">
															<span class="notesgray float_left ellipsistext cD" style="max-width: 100px;" title="Appointment"><?php _trans('lable501');?></span>
														</span>
														<span class="float_left pL10 pR10 notesDot">-</span>
														<span class="float_left pR5 notesgray dIB">
															<span class="timerIcon-notes mT2 float_left mR5">
																<img src="<?php echo base_url(); ?>assets/mp_backend/img/clock.svg" width="15px" height="15px">
															</span><?php if($commentslist->created_on != "" && $commentslist->created_on != "0000-00-00 00:00:00"){echo date("d-m-Y H:i:s", strtotime($commentslist->created_on));} ?>
														</span>
														<span class="float_left pR5 notesgray dIB"><?php _trans('lable503');?></span>
														<span class="float_left pR5 notesgray dIB" data-title="<?php echo $commentslist->employee_name;?>"><?php echo $commentslist->employee_name;?></span>
														<?php if($commentslist->reschedule == 'Y'){ ?>
															<span class="float_left pR5 notesgray dIB"><?php _trans('lable502');?></span>
															<span class="float_left pR5 notesgray dIB"><?php if($commentslist->reschedule_date != "" && $commentslist->reschedule_date != "0000-00-00 00:00:00"){echo date("d-m-Y H:i:s", strtotime($commentslist->reschedule_date));} ?></span>
														<?php } ?>
														<span class="pA whiteBg" id="noteOper_<?php echo $commentslist->comment_id;?>" style="top: 10px; right: 0px;"></span>
													</div>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
			<?php } ?>
    		<div class="card-block invoice">
    			<div class="row invoiceFloatbtn">
                    <div class="col-lg-12 clearfix buttons text-right">
						<a class="btn btn-rounded btn-primary btn-padding-left-right-40" href="<?php echo site_url('mech_appointments/form/'.$mech_leads->ml_id); ?>">
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
        window.location.href = "<?php echo site_url('mech_work_order_dtls'); ?>";
    });
});
</script>
