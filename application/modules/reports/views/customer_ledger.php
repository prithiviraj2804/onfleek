<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php _trans('lable990'); ?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-rounded btn-primary btn-padding-left-right-40" target="_blank" href="<?php echo site_url('reports/generate_pdf/CustomerLedgerReport/'.date_to_mysql($from_date).'/'.date_to_mysql($to_date).'/'.$user_branch_id.'/'.$customer_id); ?>">
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
                <label><?php _trans('lable35'); ?></label>
                <div class='input-group'>
                <select name="customer_id" id="customer_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                            <option value=""><?php _trans('lable272'); ?></option>
                            <?php foreach ($customer_dtls as $customer) { ?>
                                <option value="<?php echo $customer->client_id; ?>" <?php if($customer_id == $customer->client_id) { echo "selected"; }?>><?php echo ($customer->client_name?$customer->client_name:"").' '.($customer->client_contact_no?"(".$customer->client_contact_no.")":""); ?></option>
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
                <h5><?php _trans('lable998'); ?></h5>
                <div class="row">
                <hr style="border-top-color: #c5d6de;margin: 5px;width:100%">
                </div>
            </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:1px;">
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12" style="padding:1px;">
                        <div class="clearfix">
                            <div><?php _trans('lable36');?> :
                            <?php foreach ($customer_info as $customer_in){  ?>
                            <?php echo $customer_in->client_name; ?>
                            <?php } ?>
                            </div>
                        </div>
                        <div class="clearfix">
                            <div><?php _trans('lable999');?> :
                            <?php foreach ($customer_info as $customer_in){  ?>
                                <?php echo ($customer_in->customer_street_1?$customer_in->customer_street_1:"")." ".($customer_in->customer_street_2?",".$customer_in->customer_street_2:"")." ".($customer_in->area?",".$customer_in->area:"")." ".($customer_in->city_name?",".$customer_in->city_name:"")." ".($customer_in->state_name?",".$customer_in->state_name:"")." ".($customer_in->country_name?",".$customer_in->country_name:"")." ".($customer_in->zip_code?",".$customer_in->zip_code:""); ?>   
                            <?php } ?>
                            </div>
                        </div>
                        <div class="clearfix">
                            <div><?php _trans('label946');?> :
                            <?php foreach ($customer_info as $customer_in){  ?>
                                <?php echo $customer_in->client_contact_no; ?>
                            <?php } ?>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <table class="display table table-bordered" cellspacing="0" width="10%">
                        <?php if(count($results) > 0){
                            $overall_grand_total = 0;
                            $overall_total_paid_amount = 0;
                            $overall_total_due_amount = 0;
                        foreach ($results as $result){ 
                            $overall_grand_total += $result->grand_total;
                            $overall_total_paid_amount += $result->total_paid_amount;
                            $overall_total_due_amount += $result->total_due_amount;?>
                        <?php } ?>
                        <tr style="background-color: #F8F9F9;">
                        <th class="text_align_left"><?php _trans('lable1002'); ?></th>
                        <td class="text_align_right"><strong><?php echo format_currency($overall_total_paid_amount); ?></strong></td>
                        </tr>
                        <tr>
                        <th class="text_align_left"><?php _trans('lable1003'); ?></th>
                        <td class="text_align_right"><strong><?php echo format_currency($overall_grand_total); ?></strong></td>
                        </tr>
                        <tr style="background-color: #F8F9F9;">
                        <th class="text_align_left"><?php _trans('lable1004'); ?></th>
                        <td class="text_align_right"><strong><?php echo format_currency($overall_total_due_amount); ?></strong></td>
                        </tr>
                        <?php } ?>
                        </table>
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
                <table class="display table table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="text_align_left"><?php _trans('lable29'); ?></th>
                            <th class="text_align_left"><?php _trans('lable31'); ?></th>
                            <th class="text_align_left"><?php _trans('lable127'); ?></th>
                            <th class="text_align_center"><?php _trans('lable1127'); ?></th>
                            <th class="text_align_right"><?php _trans('lable994'); ?></th>
                            <th class="text_align_right"><?php _trans('lable384'); ?></th>
                            <th class="text_align_right"><?php _trans('lable995'); ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if(count($results) > 0){
                            $overall_grand_total = 0;
                            $overall_total_paid_amount = 0;
                            $overall_total_due_amount = 0;
                        foreach ($results as $result){ 
                            $overall_grand_total += $result->grand_total;
                            $overall_total_paid_amount += $result->total_paid_amount;
                            $overall_total_due_amount += $result->total_due_amount;?>
                            <?php 
                            $today_dt = date_create(date('Y-m-d'));
                            $invoice_dt = date_create($result->invoice_date);
                            $due_days = date_diff($today_dt,$invoice_dt);
                            ?>
                            <tr>
                                <?php if($this->session->userdata('plan_type') != 3){ ?>
                                <td class="text_align_left"><a href="<?php echo site_url('mech_invoices/view/' . $result->invoice_id); ?>"><?php echo $result->invoice_no; ?></a></td>
                               <?php } else { ?>
                                <td class="text_align_left"><a href="<?php echo site_url('spare_invoices/view/' . $result->invoice_id); ?>"><?php echo $result->invoice_no; ?></a></td>
                               <?php } ?>
                                <td class="text_align_left"><?php echo ($result->invoice_date?date_from_mysql($result->invoice_date):" "); ?></td>
                                <td class="text_align_left"><?php echo ($result->invoice_date_due?date_from_mysql($result->invoice_date_due):" "); ?></td>
                                <td class="text_align_center"><?php echo ($due_days->days?$due_days->days:0); ?></td>
                                <td class="text_align_right"><?php echo format_currency($result->total_paid_amount); ?></td>
                                <td class="text_align_right"><?php echo format_currency($result->grand_total); ?></td>
                                <td class="text_align_right"><?php echo format_currency($result->total_due_amount); ?></td>
                            </tr>
                        <?php } ?>
                            <tr>
                            <td colspan="4" class="text_align_center"><strong><?php _trans('lable625'); ?></strong></td>
                            <td class="text_align_right"><strong><?php echo format_currency($overall_total_paid_amount); ?></strong></td>
                            <td class="text_align_right"><strong><?php echo format_currency($overall_grand_total); ?></strong></td>
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
<script type="text/javascript">

    $(".btn").click(function() {

        $('.has-error').removeClass('has-error');
        $('.border_error').removeClass("border_error");

        var validation = [];

        if($("#customer_id").val() == ''){
            validation.push('customer_id');
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