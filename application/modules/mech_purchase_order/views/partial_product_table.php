<div class="paddingLeftRight0px table-details col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0px 15px;">
		<h3><?php _trans('lable344');?></h3>
	</div>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:0;">
        <section class="box-typical" style="overflow-x: inherit;">
        <?php /* ?>
            <div class="col-xl-6 col-lg-4 col-md-12 col-sm-6 col-xs-6" style="padding:0;">
                <div class="col-xs-12 col-sm-4 col-md-6 col-lg-6 col-xl-4">
                    <label class="form_label"><?php _trans('lable229'); ?></label>
                    <select name="brand_id" class="bootstrap-select bootstrap-select-arrow g-input" data-live-search="true" id="brand_id" onchange="getModelList(<?php echo $product->product_map_id; ?>)">
                        <option value=""><?php  _trans('lable73'); ?></option>
                        <?php if(!empty($car_brand_list)){
                        foreach($car_brand_list as $brand_list){ ?>
                            <option value="<?php echo $brand_list->brand_id; ?>" <?php if($product->brand_id == $brand_list->brand_id){ echo "selected"; } ?> ><?php echo $brand_list->brand_name; ?></option>
                        <?php } } ?>
                    </select>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-6 col-lg-6 col-xl-4">
                    <label class="form_label"><?php _trans('lable231'); ?></label>
                    <select name="model_id" class="bootstrap-select bootstrap-select-arrow g-input" id="model_id" data-live-search="true" onchange="getvariantList(<?php echo $product->product_map_id; ?>)">
                        <option value=""><?php  _trans('lable74'); ?></option>
                        <?php if(!empty($car_model_list)){
                            foreach ($car_model_list as $model_list){ ?>
                            <option value="<?php echo $model_list->model_id; ?>" <?php if($product->model_id == $model_list->model_id){ echo "selected"; } ?> ><?php echo $model_list->model_name;?></option>
                        <?php }}?>
                    </select>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-6 col-lg-6 col-xl-4">
                    <label class="form_label"><?php _trans('lable232'); ?></label>
                    <select name="variant_id" class="bootstrap-select bootstrap-select-arrow g-input" data-live-search="true" onchange="searchFilter()" id="variant_id">
                        <option value=""><?php  _trans('lable75'); ?></option>
                        <?php if ($car_variant_list){
                        foreach ($car_variant_list as $names){ ?>
                        <option value="<?php echo $names->brand_model_variant_id; ?>" <?php if($product->variant_id == $names->brand_model_variant_id){ echo "selected"; } ?>><?php echo $names->variant_name; ?></option>
                        <?php } } ?>
                    </select>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-6 col-lg-6 col-xl-4">
                    <label class="form_label"><?php _trans('lable132'); ?></label>
                    <select name="fuel_type" class="bootstrap-select bootstrap-select-arrow g-input" data-live-search="true" onchange="searchFilter()" id="fuel_type">
                        <option value="">select Fuel Type</option>
                        <option value="P"><?php echo 'Petrol';?></option>
                        <option value="D"><?php echo 'Diesel';?></option>
                        <option value="O"><?php echo 'Others';?></option>
                    </select>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-6 col-lg-6 col-xl-4">
                    <label class="form_label"><?php _trans('lable235'); ?>*</label>
                    <select name="product_category_id" id="product_category_id" onchange="searchFilter()" class="bootstrap-select bootstrap-select-arrow g-input" data-live-search="true">
                        <option value="0"><?php _trans('lable209'); ?></option>
                        <?php foreach ($families as $family) { ?>
                            <option value="<?php echo $family->family_id; ?>"><?php echo $family->family_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-6 col-lg-6 col-xl-4">
                    <label class="form_label"><?php _trans('lable1026'); ?></label>
                    <select name="product_brand_id" id="product_brand_id" onchange="searchFilter()" class="bootstrap-select bootstrap-select-arrow g-input" data-live-search="true">
                        <option value="0"><?php _trans('lable1027'); ?></option>
                        <?php foreach ($product_brand as $brands) { ?>
                            <option value="<?php echo $brands->vpb_id; ?>"
                                <?php check_select($this->mdl_mech_item_master->form_value('product_brand_id'), $brands->vpb_id); ?>
                            ><?php echo $brands->prd_brand_name ?></option>
                        <?php } ?>
                    </select>
                </div>   

                <div class="form_group col-xl-4 col-lg-6 col-md-6 col-sm-4">
                    <label class="form_label"></label>
                    <div class="form_controls paddingTop18px">
                        <span><span id="reset_filter" class="btn"><?php _trans('lable827'); ?></span></span>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" >
                    <div class='row' id="product_search">
                    </div>
                </div>
                
            </div>
            <?php */ ?>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="display table table-bordered" id="product_item_table" width="100%" style="width:100%;float:left;table-layout: fixed;">
                    <thead>
                        <th width="3%;" style="width:3%;max-width:3%;" class="text-center"><?php _trans('lable346'); ?></th>
                        <th width="22%;" style="width:22%;max-width:24%;"><?php _trans('lable177'); ?></th>
                        <th width="6%;" style="width:6%;max-width:6%;" class="text-center"><?php _trans('lable348'); ?></th>
                        <th width="10%;" style="width:10%;max-width:10%;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable399'); ?></th>
                        <th width="11%;" style="width:11%;max-width:11%;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable339'); ?></th>
                        <th width="17%;" style="width:17%;max-width:17%;" class="text-right"><?php _trans('lable331'); ?>(%)</th>
                        <th width="12%;" style="width:12%;max-width:12%;" class="text-right"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php _trans('lable332'); ?></th>
                        <th width="4%;" style="width:4%;max-width:2%;"></th>
                    </thead>
                    <tbody>
                        <?php 
                        if ($product_list) {
                            $i = 1;
                            foreach (json_decode($product_list) as $product) {
                                if($product->is_available != 'Y'){ ?>
                                     <tr class="item" id="tr_<?php echo $product->item_id; ?>">
                            <input type="hidden" class="item_id" name="item_id" value="<?php echo $product->item_id; ?>">
                            <td width="3%;" style="width:3%;max-width:3%;" class="item_sno text-center"><?php echo $i; $i++; ?></td>
                            <td width="40%;" style="width:40%;max-width:40%;">
                                <input type="text" name="item_product_name" class="item_product_name textEclip" style=" background-color: transparent;line-height: normal;border: none;text-align: left;width:100%;" value="<?php echo $product->product_name; ?>" readonly>
                                <?php if($purchase_details->purchase_status != 1){ 
                                    echo '<label style="color: red">Not Available</label>'; 
                                }?>
                                
                                <input type="hidden" name="item_product_id" class="item_product_id" id="item_product_id_<?php echo $product->item_id; ?>" value="<?php echo $product->product_id;?>">
                                <input type="hidden" name="kilo_from" class="kilo_from" value="<?php echo $product->kilo_from;?>" readonly>
                                <input type="hidden" name="kilo_to" class="kilo_to" value="<?php echo $product->kilo_to;?>" readonly>
                                <input type="hidden" name="mon_from" class="mon_from" value="<?php echo $product->mon_from;?>" readonly>
                                <input type="hidden" name="mon_to" class="mon_to" value="<?php echo $product->mon_to;?>" readonly>
                            </td>
                            <td width="6%;" style="width:6%;max-width:6%;" class="text-center">
                                <input type="text" name="product_qty" class="product_qty form-control text-center" onkeyup="product_calculation(<?php echo $product->item_id; ?>)" value="<?php echo $product->item_qty ? $product->item_qty : '1'; ?>">
                            </td>
                            <td width="10%;" style="width:10%;max-width:10%;" class="text-right">
                                <input type="text" name="usr_lbr_price" class="usr_lbr_price form-control text-right" onblur="product_calculation(<?php echo $product->item_id; ?>)" value="<?php echo format_money(($product->item_price?$product->item_price:0),$this->session->userdata('default_currency_digit')); ?>">
                                <input type="hidden" name="total_amount" class="total_amount" value="<?php echo ($product->item_price * ($product->item_qty?$product->item_qty:1)); ?>">
                                <input type="hidden" name="mech_lbr_price" class="mech_lbr_price product_id" value="<?php echo $product->item_price; ?>">
                            </td>
                            <td width="11%;" style="width:11%;max-width:11%;" class="text-right">
                                <input type="hidden" name="item_amount" class="item_amount form-control" value="<?php echo $product->item_amount; ?>">
                                <label style="width:100%;float:left;" class="item_amount_label"><?php echo format_money(($product->item_amount?$product->item_amount:0),$this->session->userdata('default_currency_digit')); ?></label>
                            </td>
                            <td width="17%;" style="width:17%;max-width:17%;" class="text-right">
                                <input style="width:35%;float: left; border-bottom-right-radius: 0px;border-top-right-radius: 0px;" type="text" name="igst_pct" class="igst_pct form-control text-right" onkeyup="product_calculation(<?php echo $product->item_id; ?>)" value="<?php echo $product->igst_pct; ?>">
                                <input style="width:65%;float: left; border-left:none;border-bottom-left-radius: 0px;border-top-left-radius: 0px;" type="text" name="igst_amount" class="form-control text-right" readonly value="<?php echo format_money(($product->igst_amount?$product->igst_amount:0),$this->session->userdata('default_currency_digit')); ?>">
                            </td>
                            <td width="12%;" style="width:12%;max-width:12%;" class="text-right">
                                <input type="hidden" name="item_total_amount" class="item_total_amount form-control" value="<?php echo $product->item_total_amount; ?>">
                                <label style="width:100%;float:left;" class="item_total_amount_label"><?php echo format_money(($product->item_total_amount?$product->item_total_amount:0),$this->session->userdata('default_currency_digit')); ?></label>
                            </td>
                            <td width="4%;" style="width:2%;max-width:2%;" class="text-center">
                                <span onclick="remove_item(<?php echo $product->item_id; ?>,'prod','mech_purchase','<?= $this->security->get_csrf_hash(); ?>');"><i class="fa fa-times"></i></span>
                            </td>
                        </tr>

                        <?php }else{ ?>
                           
                        <tr class="item" id="tr_<?php echo $product->item_id; ?>">
                            <input type="hidden" name="item_id" value="<?php echo $product->item_id; ?>">
                            <td width="3%;" style="width:3%;max-width:3%;" class="item_sno text-center"><?php echo $i; $i++; ?></td>
                            <td width="40%;" style="width:40%;max-width:40%;">
                                <input type="text" name="item_product_name" class="item_product_name textEclip" style=" background-color: transparent;line-height: normal;border: none;text-align: left;width:100%;" value="<?php echo $product->product_name; ?>" readonly>
                                <?php if($purchase_details->purchase_status != 1){  
                                    echo '<label style="color: green">Available</label>';
                                } ?>
                                
                                <input type="hidden" name="item_product_id" class="item_product_id" id="item_product_id_<?php echo $product->item_id; ?>" value="<?php echo $product->product_id;?>">
                                <input type="hidden" name="kilo_from" class="kilo_from" value="<?php echo $product->kilo_from;?>" readonly>
                                <input type="hidden" name="kilo_to" class="kilo_to" value="<?php echo $product->kilo_to;?>" readonly>
                                <input type="hidden" name="mon_from" class="mon_from" value="<?php echo $product->mon_from;?>" readonly>
                                <input type="hidden" name="mon_to" class="mon_to" value="<?php echo $product->mon_to;?>" readonly>
                            </td>
                            <td width="6%;" style="width:6%;max-width:6%;" class="text-center">
                                <input type="text" name="product_qty" class="product_qty form-control text-center" onkeyup="product_calculation(<?php echo $product->item_id; ?>)" value="<?php echo $product->item_qty ? $product->item_qty : '1'; ?>" readonly>
                            </td>
                            <td width="10%;" style="width:10%;max-width:10%;" class="text-right">
                                <input type="text" name="usr_lbr_price" class="usr_lbr_price form-control text-right" onblur="product_calculation(<?php echo $product->item_id; ?>)" value="<?php echo format_money(($product->item_price?$product->item_price:0),$this->session->userdata('default_currency_digit')); ?>" readonly>
                                <input type="hidden" name="total_amount" class="total_amount" value="<?php echo ($product->item_price * ($product->item_qty?$product->item_qty:1)); ?>">
                                <input type="hidden" name="mech_lbr_price" class="mech_lbr_price product_id" value="<?php echo $product->item_price; ?>">
                            </td>
                            <td width="11%;" style="width:11%;max-width:11%;" class="text-right">
                                <input type="hidden" name="item_amount" class="item_amount form-control" value="<?php echo $product->item_amount; ?>">
                                <label style="width:100%;float:left;" class="item_amount_label"><?php echo format_money(($product->item_amount?$product->item_amount:0),$this->session->userdata('default_currency_digit')); ?></label>
                            </td>
                            <td width="17%;" style="width:17%;max-width:17%;" class="text-right">
                                <input style="width:35%;float: left; border-bottom-right-radius: 0px;border-top-right-radius: 0px;" type="text" name="igst_pct" class="igst_pct form-control text-right" onkeyup="product_calculation(<?php echo $product->item_id; ?>)" value="<?php echo $product->igst_pct; ?>" readonly>
                                <input style="width:65%;float: left; border-left:none;border-bottom-left-radius: 0px;border-top-left-radius: 0px;" type="text" name="igst_amount" class="form-control text-right" readonly value="<?php echo format_money(($product->igst_amount?$product->igst_amount:0),$this->session->userdata('default_currency_digit')); ?>" readonly>
                            </td>
                            <td width="12%;" style="width:12%;max-width:12%;" class="text-right">
                                <input type="hidden" name="item_total_amount" class="item_total_amount form-control" value="<?php echo $product->item_total_amount; ?>">
                                <label style="width:100%;float:left;" class="item_total_amount_label"><?php echo format_money(($product->item_total_amount?$product->item_total_amount:0),$this->session->userdata('default_currency_digit')); ?></label>
                            </td>
                            <td width="4%;" style="width:2%;max-width:2%;" class="text-center">
                                <span onclick="remove_item(<?php echo $product->item_id; ?>,'prod','mech_purchase','<?= $this->security->get_csrf_hash(); ?>');"><i class="fa fa-times"></i></span>
                            </td>
                        </tr>

                        <?php } } } ?>
                    </tbody>
                    <tfoot class="product_total_calculations">
                        <td colspan="4"></td>
                        <td class="text-right">
                            <input type="hidden" name="total_usr_lbr_price" class="total_usr_lbr_price" value="">
                            <label class="total_usr_lbr_price_label">0.00</label>
                            <input type="hidden" name="total_mech_lbr_price" class="total_mech_lbr_price" value="">
                        </td>
                        <td class="text-right">
                            <input type="hidden" name="total_igst_amount" class="total_igst_amount" value="">
                            <label class="total_igst_amount_label">0.00</label>
                        </td>
                        <td class="text-right">
                            <input type="hidden" name="total_item_total_amount" class="total_item_total_amount" value="">
                            <label class="total_item_total_amount_label">0.00</label>
                        </td>
                        <td></td>
                    </tfoot>
                </table>
                <table style="display: none;">
                    <tr id="new_product_row" style="display: none;">
                        <td width="3%;" style="width:3%;max-width:3%;" class="item_sno text-center"></td>
                        <td width="24%;" style="width:24%;max-width:24%;">
                            <input type="hidden" name="item_product_id" id="item_product_id" class="item_product_id" value="">
                            <input type="text" name="item_product_name" class="item_product_name textEclip" style=" background-color: transparent;line-height: normal;border: none;width:100%;" value="" readonly>
                            <input type="hidden" name="kilo_from" class="kilo_from">
                            <input type="hidden" name="kilo_to" class="kilo_to">
                            <input type="hidden" name="mon_from" class="mon_from">
                            <input type="hidden" name="mon_to" class="mon_to">
                        </td>
                        <td width="6%;" style="width:6%;max-width:6%;" class="text-center">
                            <input type="text" name="product_qty" class="product_qty form-control text-center">
                        </td>
                        <td width="10%;" style="width:10%;max-width:10%;">
                            <input type="text" name="usr_lbr_price" class="usr_lbr_price form-control text-right" value="" disabled readonly>
                            <input type="hidden" name="total_amount" class="total_amount" value="">
                            <input type="hidden" name="mech_lbr_price" class="mech_lbr_price product_id" value="">
                            <input type="hidden" name="total_mech_amount" class="total_mech_amount" value="">
                        </td>
                        <td width="11%;" style="width:11%;max-width:11%;"  class="text-right">
                            <input type="hidden" name="item_amount" class="item_amount form-control" value="">
                            <label style="width:100%;float:left;" class="item_amount_label">0.00</label>
                        </td>
                        <td width="17%;" style="width:17%;max-width:17%;" class="text-right">
                            <input style="width:35%;float: left; border-bottom-right-radius: 0px;border-top-right-radius: 0px;" type="text" name="igst_pct" class="igst_pct form-control text-right" disabled readonly>
                            <input style="width:65%;float: left; border-left:none;border-bottom-left-radius: 0px;border-top-left-radius: 0px;" type="text" name="igst_amount" class="igst_amount form-control text-right" disabled readonly>
                        </td>
                        <td width="12%;" style="width:12%;max-width:12%;" class="text-right">
                            <input type="hidden" name="item_total_amount" class="item_total_amount form-control" value="">
                            <label style="width:100%;float:left;" class="item_total_amount_label">0.00</label>
                        </td>
                        <td width="2%;" style="width:2%;max-width:2%;" class="text-center">
                            <span class="remove_added_item"><i class="fa fa-times"></i></span>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 clearfix" style="float: right">
					<div class="total-amount row" style="float: left;width: 100%`">
						<div class="row">
							<div class="col-lg-7 col-md-7 col-sm-7 clearfix">
								<?php _trans('lable339'); ?> :
							</div>
							<div class="col-lg-5 col-md-5 col-sm-5 price clearfix">
							<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<b class="total_user_product_price">0.00</b>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-7 col-md-7 col-sm-7 clearfix">
								<?php _trans('lable330'); ?> :
							</div>
							<div class="col-lg-5 col-md-5 col-sm-5 price clearfix">
							<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<b class="product_total_discount">0.00</b>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-7 col-md-7 col-sm-7 clearfix">
								<?php _trans('lable392'); ?>:
							</div>
							<div class="col-lg-5 col-md-5 col-sm-5 price clearfix">
                            <?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<b class="total_user_product_taxable">0.00</b>
                            <input type="hidden" id="total_user_product_taxable" name="total_user_product_taxable" autocomplete="off">
							</div>
						</div>
						<div class="row">
							<div class="col-lg-7 col-md-7 col-sm-7 clearfix">
								<?php _trans('lable331'); ?> :
							</div>
							<div class="col-lg-5 col-md-5 col-sm-5 price clearfix">
							<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<b class="total_user_product_gst">0.00</b>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-7 col-md-7 col-sm-7 clearfix">
								<b><?php _trans('lable332'); ?>:</b>
							</div>
							<div class="col-lg-5 col-md-5 col-sm-5 price clearfix" style="border-top:1px solid #000; margin-top: 5px">
							<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<b class="total_product_invoice">0.00</b>
							</div>
						</div>
						<br>
						<div class="row" style="display:none">
							<div class="col-lg-9 col-md-9 col-sm-9 clearfix">
								<b><?php _trans('lable329'); ?></b> <br>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-3 price clearfix">
                            <?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<b class="total_taxable_amount">0.00</b>
							</div>
						</div>
						<div class="row" style="display:none">
							<div class="col-lg-9 col-md-9 col-sm-9 clearfix">
								<b> <?php _trans('lable331'); ?></b><br>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-3 price clearfix">
							<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<b class="total_gst_amount">0.00</b>
							</div>
						</div>
						<div class="row" style="display:none">
							<div class="col-lg-9 col-md-9 col-sm-9 clearfix">
								<b><?php _trans('lable332'); ?></b><br>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-3 price clearfix" style="border-top:1px solid #000; margin-top: 5px">
							<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<b class="grand_total">0.00</b>
							</div>
							<input type="hidden" id="total_due_amount_save" name="total_due_amount_save" value="<?php echo $purchase_details->total_due_amount;?>" autocomplete="off">
						</div>
						<br>
					</div>
				</div>
            </div>
        </section>
    </div>
    <div class="error error_msg_product_item"></div>
</div> 
