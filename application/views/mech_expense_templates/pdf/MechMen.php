<!DOCTYPE html>
<html lang="<?php _trans('cldr'); ?>">
<head>
    <meta charset="utf-8">
    <title><?php _trans('lable1042'); ?></title>
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/mechmen_pdf/css/templates.css">
    <style>
	@page {
		margin-top: 3.8cm;
		margin-bottom: 1.5cm;
		margin-left: 1cm;
		margin-right: 1cm;
		margin-header: 0mm;
		margin-footer: 0mm;
		footer: html_myHTMLFooter;
		header: html_myHTMLHeader;
	}
	.customer-details tr td{
		width:33.3px
	}
	.work_shop
	{
		font-size: 18px;;
		font-weight: 400;
    	margin-bottom: 1.2rem;
	}
	body
	{
		line-height:1.5;
		font-size:13px;
	}
	</style>
</head>
<body>
<htmlpageheader name="myHTMLHeader">
	<div style="font-weight:500;font-size:15px;padding:12px;border-bottom:1px solid #d8e2e7;"><?php _trans('lable1060'); ?></div>
	<table style="width:100%;">
		<tr>
			<td width="50%;padding-left:20px;padding-top:20px;">
	<div class="company_logo">
		<?php  $company_details = $this->mdl_workshop_branch->get_company_branch_details(); 
		if($company_details->workshop_logo){ ?>
			<img class="hidden-md-down" src="<?php echo base_url(); ?>uploads/workshop_logo/<?php echo $company_details->workshop_logo; ?>" width="150" height="150" alt="<?php echo $company_details->workshop_name; ?>">
		<?php }  ?>
	</div>
			</td>
			<td style="width:50%;text-align: right;float: right;padding-right:20px;padding-top:20px;">
			
		<div>
		<div><h4 class="work_shop"><?php echo $company_details->workshop_name; ?></h4></div><br>
		<div><?php if($company_details->branch_street){ echo $company_details->branch_street; }
		  if($company_details->area_name){ echo ",".$company_details->area_name; }
		  if($company_details->state_name){ echo ",".$company_details->state_name; }
		  if($company_details->branch_pincode){ echo " - ".$company_details->branch_pincode; }
		  if ($company_details->branch_country) {
			echo ' - '.$company_details->name;
		}
		   ?></div>
		   <?php if($company_details->branch_contact_no){ echo '<span>'.$company_details->branch_contact_no.'</span>'; } ?>
		   <?php if($company_details->branch_email_id){ echo '<br><span>'.$company_details->branch_email_id.'</span>'; } ?>
		   <?php if($company_details->branch_gstin){ echo '<br><span>'.$company_details->branch_gstin.'</span>'; } ?>
		   
		</div>						
		</td>
		</tr>
	</table>						
	
	<!--<div class="header_bg"></div>-->
	<hr>
</htmlpageheader>


<htmlpagefooter name="myHTMLFooter">
	<div class="footer_bg"></div>
</htmlpagefooter>


<main style="padding:20px;">
	<div style="width:100%;padding-top:20px; ">
		<div style="width:33.33%;float:left;">
			<b><?php _trans('lable279'); ?>:</b>
			<?php if($quote->invoice_no) { ?>
			<strong><?php _trans('lable29'); ?> : <?php echo $quote->invoice_no; ?></strong>
			<?php } ?>
		
			<?php if($quote->client_name){ echo '<div>'.$quote->client_name.'</div>'; } ?>
			<?php if($quote->client_contact_no){ echo '<div>'.$quote->client_contact_no.'</div>'; } ?>
			<strong><?php _trans('lable1061'); ?>:</strong>
			<div><?php echo $this->mdl_user_address->get_user_complete_address($quotes->pickup_address_id); ?></div>
			
			<strong><?php _trans('lable1062'); ?>:</strong>
			<div><?php echo $this->mdl_user_address->get_user_complete_address($quotes->delivery_address_id); ?></div>
		</div>
		<div style="width:33.33%;float:left;">
					<strong><?php _trans('lable280'); ?>:</strong><br>
							<?php if($quote->car_reg_no){ echo '<span>'.$quote->car_reg_no.'</span>'; } ?>
						<div><?php if($quote->car_model_year){ echo $quote->car_model_year; }
						  if($quote->brand_name){ echo " ".$quote->brand_name; }
						  if($quote->model_name){ echo " ".$quote->model_name; }
						  if($quote->variant_name){ echo " ".$quote->variant_name; }
						   ?></div>
						 <?php if($quote->current_odometer_reading){ echo '<span>Odometer Reading : '.$quote->current_odometer_reading.'</span>'; } ?>
		<?php if($quote->fuel_level){ echo '<div>Fuel level : '.$quote->fuel_level.'</div>'; } ?>
		<?php if($quote->pickup_date){ echo '<div>Pickup Date : '.$quote->pickup_date .' '.$quote->pickup_time.'</div>'; } ?>
		<?php if($quote->delivery_date){ echo '<span>Delivery Date : '.$quote->delivery_date.' '.$quote->delivery_time.'</span>'; } ?>
		</div>
		<div style="width:33.33%;float:left;"><span><?php _trans('lable20'); ?> : <?php echo $quote->appointment_no; ?></span></div>
	</div>
	 
	 <?php 
		for($i=0;$i<count($repair_list);$i++){
			$repair_list_ids = $repair_list[$i]->rs_item_id; ?>
			<table style="border:1px solid #FFC806;width:100%;margin-top:10px;border-spacing:0px;">
			<tr style="border:1px solid #FFC806;">
			<td style="background-color:#FFC806;padding:10px 40px;width:40px;">+</td>
			<td style="padding-left:30px;border-bottom:1px solid #FFC806;">
			<?php echo '<b  style="color:#FFC806;font-size:16px;font-weight: 600;color: black;    text-transform: uppercase;">'.$repair_list[$i]->service_item_name."</b>"; ?>
			</td>
			<td style="text-align:right;padding-right:30px;border-bottom:1px solid #FFC806;">
			<?php echo '<span style="right:0px">'.($repair_list[$i]->service_status).'</span>'; ?>
			</td>
			</tr>
			 <?php foreach($job_sheet_setup as $jobs){ 
				if($jobs->repair_service_item_id == $repair_list_ids){ 
				$role_name = $this->mdl_employee_role->get_employee_role_name($jobs->role_id); 
					?>

						<tr>
							<td></td>
							<td style="padding: 20px;line-height: 3;">
								<?php echo "<b>".($role_name)." Comment"; ?>
							</td>
							<td>
								<span><?php echo $jobs->comment; ?></span>
							</td>

						</tr>
					
		<?php  }  } ?>
			<tr>
				<td></td>
				<td colspan="2"><b><?php _trans('lable1059'); ?></b></td>
			</tr>
			<?php 
			$repair_product_list = $this->mdl_job_sheet->repair_product_list($repair_list[$i]->rs_item_id,$repair_list[$i]->quote_id,"invoice_product");
			//print_r($products_list);
			foreach($repair_product_list as $repair){ ?>
			<tr>
			<td></td>
						<?php foreach($products_list as $list){ ?>
							<?php if ($list->product_id==$repair->service_item) {?>
								  <td style="padding:10px;font-size:16px;"><?php echo $list->product_name."-"; ?></td>
							<?php } ?>
						<?php } ?>
<!--				<?php //echo $repair->item_qty?$repair->item_qty." Qty <br>":'1'; ?>-->
					<td style="padding:10px;font-size:16px;"><?php echo $repair->item_qty?$repair->item_qty." Qty <br>":'1'; ?></td>
				
			</tr>
			<?php } ?>
		</table>
		
		<!--<table>
			<tr>
				<td width="20%"><?php echo ""; ?></td>
				<td width="60%">
					
		
			<?php 
			
			$repair_product_list = $this->mdl_job_sheet->repair_product_list($repair_list[$i]->rs_item_id,$repair_list[$i]->quote_id,"invoice_product");
			//print_r($products_list);
			foreach($repair_product_list as $repair){ ?>
						<?php foreach($products_list as $list){ ?>
							<?php if ($list->product_id==$repair->service_item) {
								  echo $list->product_name."-"; } ?>
						<?php } ?>
					<?php echo $repair->item_qty?$repair->item_qty." Qty <br>":'1'; ?>
				
			
			<?php } ?>
					</td>
			</tr>
		</table>									
														
		--><?php  } ?>
	
		<!--<?php 
		for($i=0;$i<count($repair_list);$i++){
			$repair_list_ids = $repair_list[$i]->rs_item_id; ?>
			<hr style="color:#FFC806">
			<?php echo '<b  style="color:#FFC806;font-size:16px">'.$repair_list[$i]->service_item_name."</b>"; ?>
			<?php echo '<span style="right:0px">'.($repair_list[$i]->service_status).'</span>'; ?>
			 <hr style="color:#FFC806">
			 <?php foreach($job_sheet_setup as $jobs){ 
				if($jobs->repair_service_item_id == $repair_list_ids){ 
				$role_name = $this->mdl_employee_role->get_employee_role_name($jobs->role_id); 
					?>
					
					<table>
						<tr>
							<td width="30%"><?php echo "<b>".($role_name)." Comment"; ?></td>
							<td width="60%"><?php echo $jobs->comment; ?></td>
						</tr>
					</table>
		<?php  }  } ?>
		
		
		<table>
			<tr>
				<td width="20%"><?php echo "<b>Select used Products</b>"; ?></td>
				<td width="60%">
					
		
			<?php 
			
			$repair_product_list = $this->mdl_job_sheet->repair_product_list($repair_list[$i]->rs_item_id,$repair_list[$i]->quote_id,"invoice_product");
			//print_r($products_list);
			foreach($repair_product_list as $repair){ ?>
						<?php foreach($products_list as $list){ ?>
							<?php if ($list->product_id==$repair->service_item) {
								  echo $list->product_name."-"; } ?>
						<?php } ?>
					<?php echo $repair->item_qty?$repair->item_qty." Qty <br>":'1'; ?>
				
			
			<?php } ?>
					</td>
			</tr>
		</table>									
														
		<?php  } ?>
		
		--><!--<table class="item-table">
			<thead>
				<tr>
					<th  class="item-desc">Item no.</th>
					<th  class="item-name">Service</th>
					<th  class="item-desc">HSN</th>
					<th  class="item-amount">Labour Price </th>
					<th  class="item-amount">Taxable</th>
					</tr>
			
				
			
				</thead>
		</table>
		
		<div><?php echo $this->mdl_employee_role->get_employee_role_name($approval->role_id); ?>
				<?php $approval_lcase = strtolower($this->mdl_employee_role->get_employee_role_name($approval->role_id)); ?>
				
					<select name="approval_role" data-role="<?php echo $approval_lcase; ?>" data-role-id="<?php echo $approval->role_id; ?>" class="form-control ser-employee-dropdown" id="approval_<?php echo $approval->js_action_id; ?>">
						<option value=""></option>
						<?php foreach($employee_list as $role) { ?> 
						<?php if($approval->role_id == $role->employee_role){ 
							if($approval->employee_id==$role->employee_id){ $selected ='selected="selected"';} else { $selected=""; }
							?>
						<option value="<?php echo $role->employee_id; ?>" <?php echo $selected; ?>><?php echo $role->employee_name; ?></option>
						<?php } } ?>
					</select>
			<?php  ?>
			</div>
   --><div>

   </div>
</main>

</body>
</html>
<?php //exit();?>