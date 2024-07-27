<!DOCTYPE html>
<html lang="<?php _trans('cldr'); ?>">
<head>
	<meta charset="utf-8">
    <title><?php _trans('lable1039'); ?></title>
<style type="text/css">
  @page {
         size: auto;   /* auto is the initial value */
         margin: 0%;
         padding:0%;
      }
      table { page-break-inside : avoid }
      body
      {
      margin:0;
      width:100%;
      }
      table tr td
      {
      	font-size:10px !important;
      }
      table .medium td
      {
      	font-size:12px !important;
      }
</style>
</head>
<body>
<div  style="width:1.9 inc;">
<?php $company_details = $this->mdl_workshop_branch->get_company_branch_details($invoice_detail->branch_id);?>
	<table style="width:95%;margin: 0 auto;">
		<tr align="center" class="medium">
			<td colspan="2" align="center" style="text-align:center;width:100%;"><b><?php echo $company_details->display_board_name;?></b></td>
		</tr>
		<tr align="center">
			<td colspan="2" align="center"><?php echo $company_details->branch_street;echo $company_details->area_name; ?></td>
		</tr>
		<tr align="center">
			<td colspan="2" align="center"><?php echo $company_details->state_name." PIN:".$company_details->branch_pincode; ?></td>
		</tr>
		<tr align="center">
			<td colspan="2" align="center"><?php echo $company_details->name; ?></td>
		</tr>
		<tr align="center">
			<td colspan="2" align="center">
				<?php if($company_details->branch_contact_no){
					echo $company_details->branch_contact_no;
				} ?>
			</td>
		</tr>
		<tr align="center">
			<td colspan="2" align="center">
				<?php if($company_details->branch_email_id){
					echo $company_details->branch_email_id;
				} ?>
			</td>
		</tr>
		<tr align="center">
			<td colspan="2" align="center">
				<?php if($company_details->branch_gstin){
					echo $company_details->branch_gstin;
				} ?>
			</td>
		</tr>
		<tr align="center">
			<td colspan="2" align="center" style="padding-top:x;border-bottom:1px dashed black;"></td>
		</tr>
		<tr align="center"><td colspan="2" align="center" style="padding-top:8px;"><?php _trans('lable1054'); ?></td></tr>
		<tr align="center"><td colspan="2" align="center" style=""><?php _trans('lable1067'); ?> : <?php echo $invoice_detail->invoice_date?date_from_mysql($invoice_detail->invoice_date):''; ?></td></tr>
		<tr align="center"><td colspan="2" align="center" style=""><?php _trans('lable34'); ?> : <?php echo $invoice_detail->invoice_no; ?></td></tr>
		<tr align="center"><td colspan="2" align="center" style=""><?php _trans('lable421'); ?>: <?php echo $invoice_detail->car_reg_no; ?></td></tr>
		<tr align="center"><td colspan="2" align="center" style=""><?php _trans('lable422'); ?> : <?php echo $invoice_detail->brand_name; ?></td></tr>
		<tr align="center"><td colspan="2" align="center" style="border-bottom:1px dashed black;padding-top:8px;"></td></tr>
		<tr align="center" >
			<td colspan=""  style="padding-top:8px;width:50%"><?php _trans('lable1068'); ?> </td>

			<td colspan="" align="right" style="padding-top:8px;width:50%"><?php _trans('lable1069'); ?> (<?php echo $this->session->userdata('default_currency_code'); ?>)</td>
		</tr>	
		<tr>
		<td colspan="2" align="center" style="border-bottom:1px dashed black;padding-top:8px;"></td>
		</tr>
		
		<?php if($invoice_detail->product_user_total > 0){ ?>
		<tr align="center"><td colspan="2" align="center" ></td> </tr>
		<tr><td colspan=""  style="padding-top:8px;width:50%;font-weight: bold"><?php _trans('lable344'); ?></td>
		</tr>
		<?php $product_list = json_decode($product_list);
			if (count($product_list) > 0) {
				$i = 1;
				foreach ($product_list as $product) { ?>
		<tr>
			<td align="left" style="padding-top:8px;"><?php echo $product->item_product_name; ?></td>
			<td align="right" style=""><?php echo $product->item_total_amount;?></td>
		</tr>
		<?php } } ?>
		<tr align="center"><td colspan="2" align="center" style="border-bottom: 1px dashed;padding-top:8px;"></td></tr>
		<tr align="center"><td colspan="2" align="center" style="border-top: 1px dashed;padding-bottom: 8px;"></td></tr>
		<?php } ?>

		<?php if($invoice_detail->service_user_total > 0){ ?>
		<tr align="center"><td colspan="2" align="center" ></td> </tr>
		<tr><td colspan=""  style="padding-top:8px;width:50%;font-weight: bold"><?php _trans('lable1022'); ?></td>
		</tr>
		<?php $service_list = json_decode($service_list);
			if (count($service_list) > 0) {
				$i = 1;
				foreach ($service_list as $service) { ?>
		<tr>
			<td align="left" style="padding-top:8px;"><?php echo $service->service_item_name; ?></td>
			<td align="right" style=""><?php echo $service->item_total_amount;?></td>
		</tr>
		<?php } } ?>
		<tr align="center"><td colspan="2" align="center" style="border-bottom: 1px dashed;padding-top:8px;"></td></tr>
		<tr align="center"><td colspan="2" align="center" style="border-top: 1px dashed;padding-bottom: 8px;"></td></tr>
		<?php } ?>

		<?php if($invoice_detail->service_package_user_total > 0){ ?>
		<tr align="center"><td colspan="2" align="center" ></td> </tr>
		<tr><td colspan=""  style="padding-top:8px;width:50%;font-weight: bold"><?php _trans('lable546'); ?></td>
		</tr>
		<?php $service_package_list = json_decode($service_package_list);
			if (count($service_package_list) > 0) {
				$i = 1;
				foreach ($service_package_list as $service) { ?>
		<tr>
			<td align="left" style="padding-top:8px;"><?php echo $service->service_item_name; ?></td>
			<td align="right" style=""><?php echo $service->item_total_amount;?></td>
		</tr>
		<?php } } ?>
		<tr align="center"><td colspan="2" align="center" style="border-bottom: 1px dashed;padding-top:8px;"></td></tr>
		<tr align="center"><td colspan="2" align="center" style="border-top: 1px dashed;padding-bottom: 8px;"></td></tr>
		<?php } ?>
		<tr align="center" class="medium">
			<td align="left" style="padding-top:8px;"><?php _trans('lable1070'); ?> : </td>
			<td align="right" style="padding-top:8px;"><?php echo ($invoice_detail->service_total_taxable + $invoice_detail->service_package_total_taxable + $invoice_detail->product_total_taxable) + ($invoice_detail->service_total_gst + $invoice_detail->service_package_total_gst + $invoice_detail->product_total_gst ); ?></td>
		</tr>
		<tr align="center">
			<td align="left" style=""><?php _trans('lable902'); ?>: </td>
			<td align="right" style=""><?php echo $invoice_detail->service_total_discount + $invoice_detail->service_package_total_discount + $invoice_detail->product_total_discount; ?></td>
		</tr>
		<tr align="center" class="medium">
			<td align="left" style="padding-bottom: 8px;padding-top: 8px;"><b><?php _trans('lable332'); ?> : </b></td>
			<td align="right" style="padding-bottom: 8px;padding-top: 8px;"><b><?php echo format_money($invoice_detail->grand_total,$this->session->userdata('default_currency_digit')); ?></b></td>
		</tr>
		<tr align="center"><td colspan="2" align="center" style="border-bottom: 1px dashed;"></td></tr>
		<tr align="center"><td colspan="2" align="center" style="border-top: 1px dashed;padding-bottom: 8px;"></td></tr>
		<tr align="center"><td colspan="2" align="center" style="padding-bottom: 8px;padding-top: 8px;font-size:12px;">*** <?php _trans('lable1066'); ?> ***</td></tr>
	</table>
</div>
<?php //exit();?>
</body>
</html>