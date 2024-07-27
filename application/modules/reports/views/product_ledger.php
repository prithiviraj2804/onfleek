<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php _trans('lable992'); ?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-rounded btn-primary btn-padding-left-right-40" target="_blank" href="<?php echo site_url('reports/generate_pdf/ProductLedgerReport/'.date_to_mysql($from_date).'/'.date_to_mysql($to_date).'/'.$user_branch_id.'/'.$product_id); ?>">
                        <i class="fa fa-edit fa-margin"></i> <?php _trans('lable141'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="container row">
    <div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 top-15">
			<a class="anchor anchor-back" href="<?php echo site_url('reports/index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
		</div>
	</div>
    <form method="POST" action="<?php echo site_url($this->uri->uri_string()); ?>">
    <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
        <div class='col-lg-4 col-md-6 col-sm-6 col-xs-12'>
            <div class="form-group">
                <label><?php _trans('lable361'); ?></label>
                <div class='input-group'>
                    <input type='text' name="from_date" id="from_date" value="<?php echo $from_date; ?>" class="form-control datepicker" />
                    <label class="input-group-addon" for="from_date">
                        <span class="fa fa-calendar"></span>
                    </label>  
                </div>
            </div>
        </div>
        <div class='col-lg-4 col-md-6 col-sm-6 col-xs-12'>
            <div class="form-group">
                <label><?php _trans('lable630'); ?></label>
                <div class='input-group'>
                    <input type='text' name="to_date" id="to_date" value="<?php echo $to_date; ?>" class="form-control datepicker" />
                    <label class="input-group-addon" for="to_date">
                        <span class="fa fa-calendar"></span>
                    </label> 
                </div>
            </div>
        </div>
        <div class='col-lg-4 col-md-6 col-sm-6 col-xs-12'>
            <div class="form-group">
                <label><?php _trans('lable95'); ?></label>
                <div class='input-group'>
                    <select id="user_branch_id" name="user_branch_id" class="bootstrap-select bootstrap-select-arrow g-input form-control" data-live-search="true" >
                        <?php if($this->session->userdata('user_id') == 1 || $this->session->userdata('user_type') == 3){ ?>
                            <option <?php if($branchList->w_branch_id == $user_branch_id){ echo "selected";} ?> value="ALL"><?php _trans('lable629'); ?></option>
                        <?php } ?>
                        <?php foreach ($branch_list as $branchList) {?>
                        <option value="<?php echo $branchList->w_branch_id; ?>" <?php if($branchList->w_branch_id == $user_branch_id){ echo "selected";} ?>> <?php echo $branchList->display_board_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class='col-lg-4 col-md-6 col-sm-6 col-xs-12'>
            <div class="form-group">
                <label><?php _trans('lable206'); ?></label>
                <div class='input-group'>
                <select name="product_id" id="product_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                            <option value=""><?php _trans('lable1008'); ?></option>
                            <?php foreach ($product_dtls as $product) { ?>
                                <option value="<?php echo $product->product_id; ?>" <?php if($product_id == $product->product_id) { echo "selected"; }?>><?php echo ($product->product_name?$product->product_name:""); ?></option>
                            <?php } ?>
                </select>
                </div>
            </div>
        </div>
        <div class='col-lg-4 col-md-6 col-sm-6 col-xs-12' style="padding: 22px 0px 0px 17px;">
            <div class="form-group">
                <div class='input-group'>
                    <input type="submit" class="btn btn-success" name="btn_submit" value="<?php _trans('lable628'); ?>">
                </div>
            </div>
        </div>
    </form>
</div>

<div id="content" class="table-content">
    <?php $this->layout->load_view('layout/alerts'); ?>
    <section class="card">
        <div class="card-block">
            <div class="form-group clearfix">
                <h5><?php _trans('lable1009'); ?></h5>
                <div class="row">
                <hr style="border-top-color: #c5d6de;margin: 5px;width:100%">
                </div>
            </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:1px;">
                        <div class="clearfix">
                            <div style="padding:0px; margin: 0;font-size:23px;"><?php _trans('lable25');?>:
                            <?php foreach ($product_info as $product_in){  ?>
                                 <?php echo $product_in->product_name; ?>
                            <?php } ?>
                            </div>
                        </div>
                        <div class="clearfix">
                            <div><?php _trans('lable231');?>:
                            <?php foreach ($product_info as $product_in){  ?>
                                <?php echo $product_in->family_name; ?>
                            <?php } ?>
                            </div>
                        </div>
                        <div class="clearfix">
                            <div><?php _trans('lable224');?>:
                            <?php foreach ($product_info as $product_in){  ?>
                                <?php echo $product_in->cost_price; ?>
                            <?php } ?>
                            </div>
                        </div>
                        <div class="clearfix">
                            <div><?php _trans('lable225');?>:
                            <?php foreach ($product_info as $product_in){  ?>
                                <?php echo $product_in->sale_price; ?>
                            <?php } ?>
                            </div>
                        </div>
                        <div class="row">
                        <hr style="border-top-color: #c5d6de;margin: 5px;width:99%">
                        </div>
                </div>      
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-4">        
                                <div><strong><?php _trans('lable1010');?> = 
                                <?php if(count($results) > 0){
                                    $overall_pur_total = 0;
                                foreach ($results as $result){ 
                                    $overall_pur_total += $result->item_qty;?>
                                <?php } ?>
                                    <span style="color:red;"><?php echo $overall_pur_total?$overall_pur_total:"0"; ?></span>
                                    <?php }else{ ?>
                                        <span style="color:red;"><?php echo 0;?></span>
                                    <?php } ?>                               
                                 </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-4">        
                                <div><strong><?php _trans('lable637');?> =
                                <?php if(count($results_sales) > 0){
                                    $overall_sal_total = 0;
                                foreach ($results_sales as $result){ 
                                    $overall_sal_total += $result->item_qty;?>
                                <?php } ?>
                                    <span style="color:red;"><?php echo $overall_sal_total?$overall_sal_total:"0"; ?></span>
                                <?php }else{ ?>
                                    <span style="color:red;"><?php echo 0;?></span>
                                <?php } ?>
                                </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-4">
                                <div><strong><?php _trans('lable1011');?> =
                                <?php $total = ($overall_pur_total - $overall_sal_total); ?>
                                    <span style="color:red;"><?php echo $total?$total:"0"; ?></span>
                               </div>
                    </div>
                </div>      
                <br>  
        </div>
    </section>
</div>

<div id="content" class="table-content">
    <?php $this->layout->load_view('layout/alerts'); ?>
    <section class="card">
        <div class="card-block">
            <div class="overflowScrollForTable">
            <h5><?php _trans('lable1012'); ?></h5>
                <table class="display table table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="text_align_left"><?php _trans('lable31'); ?></th>
                            <th class="text_align_left"><?php _trans('lable29'); ?></th>
                            <th class="text_align_left"><?php _trans('lable80'); ?></th>
                            <th class="text_align_center"><?php _trans('lable997'); ?></th>
                            <th class="text_align_right"><?php _trans('lable337'); ?></th>
                            <th class="text_align_right"><?php _trans('lable114'); ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(count($results) > 0){
                            $overall_grand_total = 0;
                            $overall_total_paid_amount = 0;
                            $overall_total_due_amount = 0;
                        foreach ($results as $result){ 
                            $overall_grand_total += $result->item_qty;
                            $overall_total_paid_amount += $result->item_price;
                            $overall_total_due_amount += $result->item_amount;?>
                            <tr>
                                <td class="text_align_left"><?php echo ($result->purchase_date_created?date_from_mysql($result->purchase_date_created):" "); ?></td>
                                <td class="text_align_left"><a href="<?php echo site_url('mech_purchase/view/' . $result->purchase_id); ?>"><?php echo $result->purchase_no; ?></a></td>
                                <td class="text_align_left"><?php echo $result->supplier_name; ?></td>
                                <td class="text_align_center"><?php echo $result->item_qty; ?></td>
                                <td class="text_align_right"><?php echo format_currency($result->item_price); ?></td>
                                <td class="text_align_right"><?php echo format_currency($result->item_amount); ?></td>
                            </tr>
                        <?php } ?>
                            <tr>
                            <td colspan="3" class="text_align_center"><strong><?php _trans('lable625'); ?></strong></td>
                            <td class="text_align_center"><strong><?php echo ($overall_grand_total); ?></strong></td>
                            <td class="text_align_right"><strong><?php echo format_currency($overall_total_paid_amount); ?></strong></td>
                            <td class="text_align_right"><strong><?php echo format_currency($overall_total_due_amount); ?></strong></td>
                            </tr>
                        <?php }else{ ?>
                        <tr>
                            <td colspan="7" align="center"><?php _trans('lable343'); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
     <!-- sales report -->
     <div id="content" class="table-content">
    <?php $this->layout->load_view('layout/alerts'); ?>
    <section class="card">
        <div class="card-block">
            <div class="overflowScrollForTable">
            <h5><?php _trans('lable1013'); ?></h5>
                <table class="display table table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="text_align_left"><?php _trans('lable31'); ?></th>
                            <th class="text_align_left"><?php _trans('lable29'); ?></th>
                            <th class="text_align_left"><?php _trans('lable36'); ?></th>
                            <th class="text_align_center"><?php _trans('lable997'); ?></th>
                            <th class="text_align_right"><?php _trans('lable337'); ?></th>
                            <th class="text_align_right"><?php _trans('lable114'); ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(count($results_sales) > 0){
                            $overall_grand_total = 0;
                            $overall_total_paid_amount = 0;
                            $overall_total_due_amount = 0;
                        foreach ($results_sales as $result){ 
                            $overall_grand_total += $result->item_qty;
                            $overall_total_paid_amount += $result->user_item_price;
                            $overall_total_due_amount += $result->item_amount;?>
                            <tr>
                                <td class="text_align_left"><?php echo ($result->invoice_date?date_from_mysql($result->invoice_date):" "); ?></td>
                                <?php if($this->session->userdata('plan_type') != 3){ ?>
                                <td class="text_align_left"><a href="<?php echo site_url('mech_invoices/view/' . $result->invoice_id); ?>"><?php echo $result->invoice_no; ?></a></td>
                               <?php } else { ?>
                                <td class="text_align_left"><a href="<?php echo site_url('spare_invoices/view/' . $result->invoice_id); ?>"><?php echo $result->invoice_no; ?></a></td>
                               <?php } ?>
                                <td class="text_align_left"><?php echo $result->client_name; ?></td>
                                <td class="text_align_center"><?php echo $result->item_qty; ?></td>
                                <td class="text_align_right"><?php echo format_currency($result->user_item_price); ?></td>
                                <td class="text_align_right"><?php echo format_currency($result->item_amount); ?></td>
                            </tr>
                        <?php } ?>
                            <tr>
                            <td colspan="3" class="text_align_center"><strong><?php _trans('lable625'); ?></strong></td>
                            <td class="text_align_center"><strong><?php echo ($overall_grand_total); ?></strong></td>
                            <td class="text_align_right"><strong><?php echo format_currency($overall_total_paid_amount); ?></strong></td>
                            <td class="text_align_right"><strong><?php echo format_currency($overall_total_due_amount); ?></strong></td>
                            </tr>
                        <?php }else{ ?>
                        <tr>
                            <td colspan="7" align="center"><?php _trans('lable343'); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
     <!-- end sales -->
<script type="text/javascript">

    $(".btn").click(function() {

        $('.has-error').removeClass('has-error');
        $('.border_error').removeClass("border_error");

        var validation = [];

        if($("#product_id").val() == ''){
            validation.push('product_id');
        }
        if(validation.length > 0){
            validation.forEach(function(val) {
                $('#'+val).addClass("border_error");
                $('#' + val).parent().addClass('has-error');
                if($('#'+val+'_error').length == 0){
                    $('#' + val).parent().addClass('has-error');
                } 
            });
            return false;
        }
    });
    $(function() {
        $('#datetimepicker6').datetimepicker();
        $('#datetimepicker7').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
        $("#datetimepicker6").on("dp.change", function(e) {
            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker7").on("dp.change", function(e) {
            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
        });
    });
</script> 