<div class="row table-details">
	<div class="col-lg-12">
		<div class="col-lg-10 col-md-9 col-sm-8 col-xs-12" style="padding: 10px 15px;">
			<h3><?php _trans('lable344');?></h3>
		</div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12" style="padding: 10px 15px;">
            <label class="padding0px"><?php _trans('lable330'); ?>:</label>
            <select id="parts_discountstate" name="parts_discountstate" onchange="part_discountstate()" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 bootstrap-select bootstrap-select-arrow form-control">
                <option <?php if ($mech_leads->parts_discountstate == 1) { echo 'selected'; } ?> value="1">&#8377;</option>
                <option <?php if ($mech_leads->parts_discountstate == 2) { echo 'selected'; } ?> value="2">&#37;</option>
            </select>
        </div>
        <section class="box-typical" style="overflow-x: inherit;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 20px 15px;">
            <?php
                if(count($product_ids) > 0){
                    $existing_product_ids =   implode(',', $product_ids);
                }else{
                    $existing_product_ids = '0';
                } ?>
                <a class="float_left fontSize_85rem addproduct" href="javascript:void(0)" data-entity-type="L" data-toggle="modal" data-existing_product_ids="<?php echo $existing_product_ids; ?>" data-entity-id="<?php echo $mech_leads->ml_id;?>" data-customer-id="<?php echo $mech_leads->customer_id;?>" data-model-from="invoice" data-target="#addproduct">
                    + <?php _trans('lable1143'); ?>
                </a>
            </div>
            <div class="table-responsive">
                <table class="display table table-bordered" id="product_item_table" width="100%" style="width:100%;float:left;table-layout: fixed;">
                    <thead>
                        <th width="3%;" style="width:3%;max-width:3%;" class="text-center"><?php _trans('lable346'); ?></th>
                        <th width="22%;" style="width:22%;max-width:24%;"><?php _trans('lable177'); ?></th>
                        <th width="8%;" style="width:8%;max-width:8%;"><?php _trans('lable396'); ?></th>
                        <th width="6%;" style="width:6%;max-width:6%;" class="text-center"><?php _trans('lable348'); ?></th>
                        <th width="10%;" style="width:10%;max-width:10%;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable399'); ?></th>
                        <th width="7%;" style="width:7%;max-width:7%;" class="text-right">
                            <span class="showrupee" <?php if($mech_leads->parts_discountstate != 2 ){ echo 'style="display:block"';}else{ echo 'style="display:none"';} ?> ><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?></span>
                            <span class="showpercentage" <?php if($mech_leads->parts_discountstate == 2 ){ echo 'style="display:block"';}else{ echo 'style="display:none"';} ?>>%</span>&nbsp;
                        <?php _trans('lable349'); ?><br>(<?php _trans('lable350'); ?>)</th>
                        <th width="11%;" style="width:11%;max-width:11%;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable339'); ?></th>
                        <th width="17%;" style="width:17%;max-width:17%;" class="text-right"><?php _trans('lable331'); ?>(%)</th>
                        <th width="12%;" style="width:12%;max-width:12%;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable332'); ?></th>
                        <th width="4%;" style="width:4%;max-width:2%;"></th>
                    </thead>
                    <tbody>
                        <?php 
                        if ($product_list) {
                            $i = 1;
                            foreach (json_decode($product_list) as $product) {?>
                        <tr class="item" id="tr_<?php echo $product->rs_item_id; ?>">
                            <input type="hidden" name="rs_item_id" class="rs_item_id" value="<?php echo $product->rs_item_id; ?>">
                            <td width="3%;" style="width:3%;max-width:3%;" class="item_sno text-center"><?php echo $i; $i++; ?></td>
                            <td width="40%;" style="width:40%;max-width:40%;padding-top:10px ! important;">
                                <input type="text" name="item_product_name" class="item_product_name textEclip" style=" background-color: transparent;line-height: normal;border: none;text-align: left;width:100%;" value="<?php echo $product->item_product_name; ?>" readonly>
                                <input type="hidden" name="duplicate_id" class="duplicate_id" id="duplicate_id_<?php echo $product->service_item;?>" value="<?php echo $product->service_item;?>">   
                                <input type="hidden" name="item_product_id" class="item_product_id" id="item_product_id_<?php echo $product->rs_item_id; ?>" value="<?php echo $product->service_item;?>">
                                <input type="hidden" name="kilo_from" class="kilo_from" value="<?php echo $product->kilo_from;?>" readonly>
                                <input type="hidden" name="kilo_to" class="kilo_to" value="<?php echo $product->kilo_to;?>" readonly>
                                <input type="hidden" name="mon_from" class="mon_from" value="<?php echo $product->mon_from;?>" readonly>
                                <input type="hidden" name="mon_to" class="mon_to" value="<?php echo $product->mon_to;?>" readonly>
                                
                            </td>
                            <td width="8%;" style="width:8%;max-width:8%;">
                                <input type="text" name="item_hsn" readonly class="item_hsn form-control" value="<?php echo $product->item_hsn; ?>">
                            </td>
                            <td width="6%;" style="width:6%;max-width:6%;" class="text-center">
                                <input type="text" name="product_qty" class="product_qty form-control text-center" onkeyup="product_calculation(<?php echo $product->rs_item_id; ?>)" value="<?php echo $product->item_qty ? $product->item_qty : '1'; ?>">
                            </td>
                            <td width="10%;" style="width:10%;max-width:10%;" class="text-right">
                                <input type="text" name="usr_lbr_price" class="usr_lbr_price form-control text-right" onblur="product_calculation(<?php echo $product->rs_item_id; ?>)" value="<?php echo format_money(($product->user_item_price?$product->user_item_price:0),$this->session->userdata('default_currency_digit')); ?>">
                                <input type="hidden" name="total_amount" class="total_amount" value="<?php echo ($product->user_item_price * ($product->item_qty?$product->item_qty:1)); ?>">
                                <input type="hidden" name="mech_lbr_price" class="mech_lbr_price product_id" value="<?php echo $product->mech_item_price; ?>">
                            </td>
                            <td width="7%;" style="width:7%;max-width:7%;" class="text-right">
                                <input type="text" name="item_discount" class="item_discount form-control text-right" onblur="product_calculation(<?php echo $product->rs_item_id; ?>)" value="<?php echo format_money(($product->item_discount?$product->item_discount:0),$this->session->userdata('default_currency_digit')); ?>">
                                <input type="hidden" name="item_discount_price" value="<?php echo ($product->item_discount * ($product->item_qty?$product->item_qty:1)); ?>">
                            </td>
                            <td width="11%;" style="width:11%;max-width:11%;" class="text-right">
                                <input type="hidden" name="item_amount" class="item_amount form-control" value="<?php echo $product->item_amount; ?>">
                                <label style="width:100%;float:left;" class="item_amount_label"><?php echo format_money(($product->item_amount?$product->item_amount:0),$this->session->userdata('default_currency_digit')); ?></label>
                            </td>
                            <td width="17%;" style="width:17%;max-width:17%;" class="text-right">
                                <input style="width:35%;float: left; border-bottom-right-radius: 0px;border-top-right-radius: 0px;" type="text" name="igst_pct" class="igst_pct form-control text-right" onkeyup="product_calculation(<?php echo $product->rs_item_id; ?>)" value="<?php echo $product->igst_pct; ?>">
                                <input style="width:65%;float: left; border-left:none;border-bottom-left-radius: 0px;border-top-left-radius: 0px;" type="text" name="igst_amount" class="form-control text-right" value="<?php echo format_money(($product->igst_amount?$product->igst_amount:0),$this->session->userdata('default_currency_digit'));  ?>" disable readonly>
                            </td>
                            <td width="12%;" style="width:12%;max-width:12%;" class="text-right">
                                <input type="hidden" name="item_total_amount" class="item_total_amount form-control" value="<?php echo $product->item_total_amount; ?>">
                                <label style="width:100%;float:left;" class="item_total_amount_label"><?php echo format_money(($product->item_total_amount?$product->item_total_amount:0),$this->session->userdata('default_currency_digit')); ?></label>
                            </td>
                            <td width="4%;" style="width:2%;max-width:2%;" class="text-center">
                                <span onclick="remove_item(<?php echo $product->rs_item_id; ?>,'prod','mech_leads','<?= $this->security->get_csrf_hash(); ?>');"><i class="fa fa-times"></i></span>
                            </td>
                        </tr>
                        <?php } } ?>
                    </tbody>
                    <tfoot class="product_total_calculations">
                        <td colspan="3" align="right"><span><b><?php _trans('lable339');?></b></span></td>
                        <td class="text-center"><label style="text-align: center;" class="total_product_qty">0</label></td>
                        <td class="text-right">
                            <input type="hidden" name="total_usr_lbr_price" class="total_usr_lbr_price" value="">
                            <input type="hidden" name="total_mech_lbr_price" class="total_mech_lbr_price" value="">
                            <label class="total_usr_lbr_price_label"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;0.00</label>
                        </td>
                        <td class="text-right">
                            <input type="hidden" name="total_item_discount" class="total_item_discount" value="">
                            <label class="total_item_discount_label"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;0.00</label>
                        </td>
                        <td>
                            <input type="hidden" name="total_item_amount" class="total_item_amount" value="">
                            <label class="total_item_amount_label text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;0.00</label>
                        </td>
                        <td class="text-right">
                            <input type="hidden" name="total_igst_amount" class="total_igst_amount" value="">
                            <label class="total_igst_amount_label"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;0.00</label>
                        </td>
                        <td class="text-right">
                            <input type="hidden" name="total_item_total_amount" class="total_item_total_amount" value="">
                            <label class="total_item_total_amount_label"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;0.00</label>
                        </td>
                        <td></td>
                    </tfoot>
                </table>
                <table style="display: none;">
                    <tbody>
                        <tr id="new_product_row" style="display: none;">
                            <td width="3%;" style="width:3%;max-width:3%;" class="item_sno text-center"></td>
                            <td width="24%;" style="width:24%;max-width:24%;padding-top:10px ! important;">
                                <input type="hidden" name="duplicate_id" id="duplicate_id" class="duplicate_id" value="">   
                                <input type="hidden" name="item_product_id" id="item_product_id" class="item_product_id" value="">
                                <input type="text" name="item_product_name" class="item_product_name textEclip" style=" background-color: transparent;line-height: normal;border: none;width:100%;" value="" readonly>
                                <input type="hidden" name="kilo_from" class="kilo_from">
                                <input type="hidden" name="kilo_to" class="kilo_to">
                                <input type="hidden" name="mon_from" class="mon_from">
                                <input type="hidden" name="mon_to" class="mon_to">
                            </td>
                            <td width="8%;" style="width:8%;max-width:8%;">
                                <input type="text" name="item_hsn" readonly class="item_hsn form-control" value="">
                            </td>
                            <td width="6%;" style="width:6%;max-width:6%;" class="text-center">
                                <input type="text" name="product_qty" class="product_qty form-control text-center">
                            </td>
                            <td width="10%;" style="width:10%;max-width:10%;">
                                <input type="text" name="usr_lbr_price" class="usr_lbr_price form-control text-right" value="">
                                <input type="hidden" name="total_amount" class="total_amount" value="">
                                <input type="hidden" name="mech_lbr_price" class="mech_lbr_price product_id" value="">
                                <input type="hidden" name="total_mech_amount" class="total_mech_amount" value="">
                            </td>
                            <td width="7%;" style="width:7%;max-width:7%;" class="text-right">
                                <input type="text" name="item_discount" class="item_discount form-control text-right" value="">
                                <input type="hidden" name="item_discount_price">
                            </td>
                            <td width="11%;" style="width:11%;max-width:11%;"  class="text-right">
                                <input type="hidden" name="item_amount" class="item_amount form-control" value="">
                                <label style="width:100%;float:left;" class="item_amount_label">0.00</label>
                            </td>
                            <td width="17%;" style="width:17%;max-width:17%;" class="text-right">
                                <input style="width:35%;float: left; border-bottom-right-radius: 0px;border-top-right-radius: 0px;" type="text" name="igst_pct" class="igst_pct form-control text-right">
                                <input style="width:65%;float: left; border-left:none;border-bottom-left-radius: 0px;border-top-left-radius: 0px;" type="text" name="igst_amount" class="igst_amount form-control text-right"  disable readonly>
                            </td>
                            <td width="12%;" style="width:12%;max-width:12%;" class="text-right">
                                <input type="hidden" name="item_total_amount" class="item_total_amount form-control" value="">
                                <label style="width:100%;float:left;" class="item_total_amount_label">0.00</label>
                            </td>
                            <td width="2%;" style="width:2%;max-width:2%;" class="text-center">
                                <span class="remove_added_item"><i class="fa fa-times"></i></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
    <div class="error error_msg_product_item"></div>
</div> 