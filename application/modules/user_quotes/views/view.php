<div class="container-fluid user_quotes">
	<section class="card view">
		<header class="card-header card-header-lg">
			Invoice
		</header>
		<div class="card-block invoice">
			<div class="row">
				<div class="col-lg-6 company-info">
					<h5><?php _trans('mech_point');?></h5>
					<p>www.mechpoint.care</p>

					<div class="invoice-block">
						<div>MechPoint</div>
						<div>Chennai - 600100</div>
						<div>Tamilnadu</div>
					</div>

					<div class="invoice-block">
						<div>Telephone: +91 98419 67890</div>
					</div>

					<div class="invoice-block">
						<h5><?php _trans('invoice_to');?>:</h5>
						<div><?php echo $user_details->name; ?></div>
						<div>
							<?php echo $user_details->mobile_no; ?> <br>
							<?php echo $user_details->email_id; ?>
						</div>
					</div>
				</div>
				<div class="col-lg-6 clearfix invoice-info">
					<div class="text-lg-right">
						<h5><?php _trans('lable119');?> : # <?php echo $quote_detail->quote_no; ?></h5>
						<div>Date: January 12, 2015</div>
						<div>Date: January 16, 2015</div>
					</div>

					<div class="payment-details">
						<strong><?php _trans('payment_details');?></strong>
						<table>
							<tbody><tr>
								<td><?php _trans('total_due');?>:</td>
								<td>$8,750</td>
							</tr>
							<tr>
								<td><?php _trans('bank_name');?>:</td>
								<td>Profit Bank Europe</td>
							</tr>
							<tr>
								<td><?php _trans('country');?>:</td>
								<td>United Kingdom</td>
							</tr>
							<tr>
								<td><?php _trans('city');?>:</td>
								<td>London</td>
							</tr>
							<tr>
								<td><?php _trans('address');?>:</td>
								<td>3 Goodman street</td>
							</tr>
							<tr>
								<td><?php _trans('user_iban');?>:</td>
								<td>KFHT32565523921540571</td>
							</tr>
							<tr>
								<td><?php _trans('swift_code');?>:</td>
								<td>BPT4E</td>
							</tr>
						</tbody></table>
					</div>
				</div>
			</div>
			<div class="row table-details">
				<div class="col-lg-12">
					<table class="table table-bordered user_quotes_table">
						<thead>
							<tr>
								<th width="10"><?php _trans('sl_no');?>/th>
								<th><?php _trans('pair_parts');?></th>
								<th><?php _trans('qty');?></th>
								<th><?php _trans('price');?>$</th>
								<th><?php _trans('discount');?>$</th>
								<th><?php _trans('cgst');?></th>
								<th><?php _trans('sgst');?></th>
								<th><?php _trans('igst');?></th>
								<th><?php _trans('cess');?></th>
								<th><?php _trans('total_amount');?>$</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1; foreach($service_list as $service){ ?>
							<tr class="first_tr">
								<td><?php echo $i; $i++; ?></td>
								<td><?php echo $service->service_item_name; ?></td>
								<td><?php echo $service->mech_item_labour_price; ?></td>
								<td>10000</td>
								<td>100</td>
								<td>10%</td>
								<td>10%</td>
								<td>10%</td>
								<td>10%</td>
								<td>4500.00</td>
							</tr>
							<tr class="second_tr">
								<td></td>
								<td>HSN : 1100</td>
								<td></td>
								<td></td>
								<td></td>
								<td>100.00</td>
								<td>100.00</td>
								<td>100.00</td>
								<td>100.00</td>
								<td></td>
							</tr>
							 <?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			
			<div class="row table-details">
				<div class="col-lg-12">
					<table class="table table-bordered user_quotes_table">
						<thead>
							<tr>
								<th width="10"><?php _trans('sl_no');?></th>
								<th><?php _trans('labor');?></th>
								<th><?php _trans('qty');?></th>
								<th><?php _trans('price');?> $</th>
								<th><?php _trans('discount');?> $</th>
								<th><?php _trans('cgst');?></th>
								<th><?php _trans('sgst');?></th>
								<th><?php _trans('igst');?></th>
								<th><?php _trans('cess');?></th>
								<th><?php _trans('total_amount');?>$</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1; foreach($service_list as $service){  ?>
							<tr class="first_tr">
								<td><?php echo $i; $i++; ?></td>
								<td><?php echo $service->service_item_name; ?></td>
								<td><?php echo $service->mech_item_labour_price; ?></td>
								<td>10000</td>
								<td>100</td>
								<td>10%</td>
								<td>10%</td>
								<td>10%</td>
								<td>10%</td>
								<td>4500.00</td>
							</tr>
							<tr class="second_tr">
								<td></td>
								<td>HSN : 1100</td>
								<td></td>
								<td></td>
								<td></td>
								<td>100.00</td>
								<td>100.00</td>
								<td>100.00</td>
								<td>100.00</td>
								<td></td>
							</tr>
							 <?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			
			
			<div class="row">
				<div class="col-lg-7 terms-and-conditions">
					<strong>Terms and Conditions</strong>
					Thank you for your business. We do expect payment within 21 days, so please process this invoice within that time. There will be a 1.5% interest charge per month on late invoices.
				</div>
				<div class="col-lg-5 clearfix">
					<div class="total-amount">
						<div>Sub - Total amount: <b>$4,800</b></div>
						<div>VAT: $35</div>
						<div>Grand Total: <span class="colored">$4,000</span></div>
						<div class="actions">
							<button class="btn btn-rounded btn-inline">Send</button>
							<button class="btn btn-inline btn-secondary btn-rounded">Print</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
		
		<script type="text/javascript">
		$(document).ready(function(){
		$('.contacts-page').each(function(){
        var parent = $(this),
            btnExpand = parent.find('.action-btn-expand'),
            classExpand = 'box-typical-full-screen';

        btnExpand.click(function(){
            if (parent.hasClass(classExpand)) {
                parent.removeClass(classExpand);
                $('html').css('overflow','auto');
                parent.find('.tab-content').height('auto').css('overflow','visible');
            } else {
                parent.addClass(classExpand);
                $('html').css('overflow','hidden');
                parent.find('.tab-content').css('overflow','auto').height(
                    $(window).height() - 2 - parent.find('.box-typical-header').outerHeight()
                );
            }
        });
    });

    });
		</script>