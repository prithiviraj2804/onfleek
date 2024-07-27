<div class="row table-details">
    <div class="col-lg-12">
    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 20px 15px;">
			<h3><?php _trans('lable344'); ?></h3>
		</div>
        <section class="box-typical">
            <div class="box-typical-body">
                <div class="table-responsive" style="width:100%;float:left;">
                    <table class="table table-hover" id="product_item_table" width="100%" style="width:100%;float:left;table-layout: fixed;">
                        <thead>
                            <th width="3%;" style="width:3%;max-width:3%;" class="text_align_left"><?php _trans('lable346'); ?></th>
                            <th width="20%;" style="width:20%;max-width:20%;" class="text_align_left"><?php _trans('lable177'); ?></th>
                            <th width="6%;" style="width:6%;max-width:6%;" class="text_align_right"><?php _trans('lable348'); ?></th>
                            <th width="13%;" style="width:13%;max-width:13%;" class="text_align_right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable337'); ?></th>
                            <th width="11%;" style="width:11%;max-width:11%;" class="text_align_right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable339'); ?></th>
                            <th width="6%;" style="width:6%;max-width:6%;" class="text_align_right"><?php _trans('lable331'); ?> (%)</th>
                            <th width="13%;" style="width:13%;max-width:13%;" class="text_align_right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable351'); ?></th>
                            <th width="16%;" style="width:16%;max-width:16%;" class="text_align_right" ><?php _trans('lable332'); ?></th>
                        </thead>
                        <tbody>
                            <?php 
                            $total_item_price = 0;
                            if(count(json_decode($product_list)) > 0) {
                            $i = 1;
                            
                            foreach (json_decode($product_list) as $product) { 
                                $total_item_price += $product->item_price;?>
                            <tr class="item" id="tr_<?php echo $product->rs_item_id; ?>">
                                <td width="3%;" style="width:3%;max-width:3%;" class="item_sno text_align_left"><?php echo $i; $i++;?></td>
                                <td width="20%;" style="width:20%;max-width:20%;" class="text_align_left textEclip" ><?php echo $product->product_name; ?>
                                <?php if($purchase_details->purchase_status != 1 && $product->is_available != 'Y'){ 
                                    echo '<label class="text_align_left" style="color: red">Not Available</label>'; 
                                }else { 
                                    echo '<label class="text_align_left" style="color: green">Available</label>';
                                } ?></td>
                                <td width="6%;" style="width:6%;max-width:6%;" class="text_align_right"><?php echo $product->item_qty ? $product->item_qty : '1'; ?></td>
                                <td width="13%;" style="width:13%;max-width:13%;" class="text_align_right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($product->item_price?$product->item_price:0),$this->session->userdata('default_currency_digit')); ?></td>
                                <td width="11%;" style="width:11%;max-width:11%;" class="text_align_right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($product->item_amount?$product->item_amount:0),$this->session->userdata('default_currency_digit')); ?></td>
                                <td width="6%;" style="width:6%;max-width:6%;" class="text_align_right"><?php echo $product->igst_pct; ?></td>
                                <td width="13%;" style="width:13%;max-width:13%;" class="text_align_right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($product->igst_amount?$product->igst_amount:0),$this->session->userdata('default_currency_digit')); ?></td>
                                <td width="16%;" style="width:16%;max-width:16%;" class="text_align_right" ><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($product->item_total_amount?$product->item_total_amount:0),$this->session->userdata('default_currency_digit')); ?></td>
                            </tr>
                            <?php } } ?>
                        </tbody>
                        <tfoot class="product_total_calculations">
                        	<tr>
                        		<td width="3%;" style="width:3%;max-width:3%;padding: 0;vertical-align: bottom;"></td>
                                <td width="20%;" style="width:20%;max-width:20%;padding: 0;vertical-align: bottom;"></td>
                                <td width="7%;" style="width:7%;max-width:7%;padding: 0;vertical-align: bottom;"></td>
                                <td width="13%;" style="width:13%;max-width:13%;padding: 0;vertical-align: bottom;">
                                	<label class="text_align_right" style="font-size: 12px;"><?php _trans('lable352'); ?></label>
                                </td>
                                <td width="11%;" style="width:11%;max-width:11%;padding: 0;vertical-align: bottom;">
                                	<label class="text_align_center" style="font-size: 12px;"></label>
                                </td>
                                <td width="7%;" style="width:7%;max-width:7%;padding: 0;vertical-align: bottom;">
                                </td>
                                <td width="13%;" style="width:13%;max-width:13%;padding: 0;vertical-align: bottom;">
                                	<label class="text_align_right" style="font-size: 12px;"><?php _trans('lable355'); ?></label>
                                </td>
                                <td width="16%;" style="width:16%;max-width:16%;padding: 0;vertical-align: bottom;">
                                	<label class="text_align_right" style="font-size: 12px;"><?php _trans('lable356'); ?></label>
                                </td>
                        	</tr>
                        	<tr>
                        		<td width="3%;" style="width:3%;max-width:3%;border: none;padding: 0;vertical-align: top;"></td>
                                <td width="20%;" style="width:20%;max-width:20%;border: none;padding: 0;vertical-align: top;"></td>
                                <td width="7%;" style="width:7%;max-width:7%;border: none;padding: 0;vertical-align: top;"></td>
                                <td width="13%;" style="width:13%;max-width:13%;border: none;padding: 0;vertical-align: top;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($purchase_details->product_user_total?$purchase_details->product_user_total:0),$this->session->userdata('default_currency_digit')); ?></td>
                                <td width="11%;" style="width:11%;max-width:11%;border: none;padding: 0;vertical-align: top;"></td>
                                <td width="7%;" style="width:7%;max-width:7%;border: none;padding: 0;vertical-align: top;"></td>
                                <td width="13%;" style="width:13%;max-width:13%;border: none;padding: 0;vertical-align: top;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($purchase_details->total_tax_amount?$purchase_details->total_tax_amount:0),$this->session->userdata('default_currency_digit')); ?></td>
                                <td width="16%;" style="width:16%;max-width:16%;border: none;padding: 0;vertical-align: top;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($purchase_details->grand_total?$purchase_details->grand_total:0),$this->session->userdata('default_currency_digit')); ?></td>
                        	</tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div> 