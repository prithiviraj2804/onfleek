<div class="row table-details">
	<div class="col-lg-12">
			<h3><?php _trans('lable492');?></h3>
        <section class="box-typical" style="overflow-x: inherit;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 20px 15px;">
            <?php
                if(count($service_ids) > 0){
                    $existing_service_ids =   str_replace(',','-', $service_ids);
                }else{
                    $existing_service_ids = '0';
                } ?>
                <a class="float_left fontSize_85rem addservice" href="javascript:void(0)" data-toggle="modal" data-existing_service_ids="<?php echo $existing_service_ids; ?>" data-entity_type="SP" data-entity_id=<?php echo $package_details->s_pack_id; ?> data-model-from="servicepackage" data-target="#addservice">
                    + <?php _trans('lable398'); ?>
                </a>
            </div>
            <div class="table-responsive">
                <table class="display table table-bordered" id="service_item_table" width="100%" style="width:100%;float:left;table-layout: fixed;">
                    <thead>
                        <th width="3%;" style="width:3%;max-width:3%;" class="text-center"><?php _trans('lable346'); ?></th>
                        <th width="22%;" style="width:22%;max-width:24%;"><?php _trans('lable240'); ?></th>
                        <th width="4%;" style="width:4%;max-width:2%;"></th>
                    </thead>
                    <tbody>
                        <?php 
                        if (count($service_list) > 0) {
                            $i = 1;
                            foreach ($service_list as $service) {?>
                        <tr class="item" id="tr_<?php echo $service->msim_id; ?>">
                            <input type="hidden" name="item_id" value="<?php echo $service->msim_id; ?>">
                            <td width="3%;" style="width:3%;max-width:3%;" class="item_sno text-center"><?php echo $i; $i++; ?></td>
                            <td width="40%;" style="width:40%;max-width:40%;">
                                <input type="text" name="item_service_name" class="item_service_name textEclip" style=" background-color: transparent;line-height: normal;border: none;text-align: left;width:100%;" value="<?php echo $service->service_item_name; ?>" readonly>
                                <input type="hidden" name="duplicate_id" class="duplicate_id" id="duplicate_id_<?php echo $service->msim_id;?>" value="<?php echo $service->msim_id;?>">   
                                <input type="hidden" name="item_msim_id" class="item_msim_id" id="item_msim_id_<?php echo $service->msim_id; ?>" value="<?php echo $service->msim_id;?>">
                            </td>
                            <td width="4%;" style="width:2%;max-width:2%;" class="text-center">
                                <span onclick="remove_service_pack_items(<?php echo $service->msim_id; ?>,<?php echo $service->msim_id; ?>)"><i class="fa fa-times"></i></span>
                            </td>
                        </tr>
                        <?php } } ?>
                    </tbody>
                </table>
                <table style="display: none;">
                    <tbody>
                        <tr id="new_service_row" style="display: none;">
                            <td width="3%;" style="width:3%;max-width:3%;" class="item_sno text-center"></td>
                            <td width="24%;" style="width:24%;max-width:24%;">
                                <input type="hidden" name="duplicate_id" id="duplicate_id" class="duplicate_id" value="">   
                                <input type="hidden" name="item_msim_id" id="item_msim_id" class="item_msim_id" value="">
                                <input type="text" name="item_service_name" class="item_service_name textEclip" style=" background-color: transparent;line-height: normal;border: none;width:100%;" value="" readonly>
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
    <div class="error error_msg_service_item"></div>
</div> 