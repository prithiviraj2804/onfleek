<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php _trans('lable623'); ?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-rounded btn-primary btn-padding-left-right-40" target="_blank" href="<?php echo site_url('reports/generate_pdf/ExpenseReports/'.date_to_mysql($from_date).'/'.date_to_mysql($to_date).'/'.str_replace(",","-",$user_branch_id)); ?>">
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
        <div class='col-md-3 padding-left-0px'>
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
        <div class='col-md-3'>
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
        <div class='col-md-6'>
            <div class="form-group">
                <label><?php _trans('lable95'); ?></label>
                <div class='input-group'>
                    <select id="user_branch_id[]" name="user_branch_id[]" class="select2 user_branch_id" multiple="multiple" data-live-search="true" >
                        <?php if($this->session->userdata('user_id') == 1 || $this->session->userdata('user_type') == 3){ ?>
                            <option <?php if($branchList->w_branch_id == $user_branch_id){ echo "selected";} ?> value="ALL"><?php _trans('lable629'); ?></option>
                        <?php } ?>
                        <?php $user_branch_ids = explode(',', $user_branch_id);
                            foreach ($branch_list as $branchList) {
                            if (in_array($branchList->w_branch_id, $user_branch_ids)) {
                                $selected = "selected='selected'";
                            } else {
                                $selected = '';
                            } ?>
                        <option value="<?php echo $branchList->w_branch_id; ?>" <?php echo $selected;?>> <?php echo $branchList->display_board_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class='col-md-12 padding0px'>
            <div class='col-md-3 padding0px'>
                <div class="form-group">
                    <div class='input-group paddingTop5px'>
                        <input type="submit" class="btn btn-success" name="btn_submit" value="<?php _trans('lable628'); ?>">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>
    <section class="card">
        <div class="card-block">
            <div class="overflowScrollForTable">
        <?php foreach($results as $value){ ?>
            <br><h6><?php echo $value->display_board_name;?></h6>
            
                <table class="display table table-bordered" style="table-layout: fixed;" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="text_align_center"><?php _trans('lable31'); ?></th>
                            <th class="text_align_center"><?php _trans('lable647'); ?></th>
                            <th class="text_align_center"><?php _trans('lable151'); ?></th>
                            <th class="text_align_center"><?php _trans('lable114'); ?></th>
                        </tr>
                    </thead>
                    <?php if(count($value->expense_list) > 0){
                    $overall_grand_total = 0; ?>
                    <tbody>
                        <?php foreach ($value->expense_list as $result){
                        $overall_grand_total += $result->grand_total;?>
                        <tr>
                            <td class="text_align_center"><?php echo ($result->expense_date?date_from_mysql($result->expense_date):" "); ?></td>
                            <td class="text_align_center"><?php echo $result->expense_category_name; ?></td>
                            <td class="text_align_center"><?php if($result->shift == 1){ echo "Regular Shift";}else if($result->shift == 2){ echo "Day Shift";}else if($result->shift == 3){ echo "Night Shift";} ?></td>
                            <td class="text_align_center"><?php echo format_money($result->grand_total,$this->session->userdata('default_currency_digit')); ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td class="text_align_right" colspan="3"><strong><?php _trans('lable638'); ?></strong></td>
                            <td class="text_align_center"><strong><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($overall_grand_total,$this->session->userdata('default_currency_digit')); ?></strong></td>
                        </tr>
                    </tbody>
                    <?php } else {?>
                    <tbody>
                        <tr>
                            <td class="text_align_center" colspan="4"><strong><?php _trans('lable343'); ?></strong></td>
                        </tr>
                    </tbody>
                    <?php } ?>
                </table>
        <?php } ?> 

        <br><h4><?php _trans('lable646'); ?></h4>
        <?php $overall_branch_grand_total = 0;
        foreach($results as $value){
            if(count($value->expense_list) > 0){
            $overall_grand_total = 0; ?>
                <table class="display table table-bordered" style="table-layout: fixed;" cellspacing="0" width="100%">
                    <tbody>
                        <?php foreach ($value->expense_list as $result){ 
                            $overall_branch_grand_total += $result->grand_total;
                            $overall_grand_total += $result->grand_total;?>
                        <?php } ?>
                        <tr>
                            <td class="text_align_right" colspan="3"><strong><?php echo $value->display_board_name; ?></strong></td>
                            <td class="text_align_center"><strong><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($overall_grand_total,$this->session->userdata('default_currency_digit')); ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            <?php } } ?>
                <table class="display table table-bordered" style="table-layout: fixed;" cellspacing="0" width="100%">
                    <tbody>
                        <?php foreach ($value->expense_list as $result){ 
                            $overall_grand_total += $result->grand_total;?>
                        <?php } ?>
                        <tr>
                            <td class="text_align_right" colspan="3"><strong><?php _trans('lable646'); ?></strong></td>
                            <td class="text_align_center"><strong><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($overall_branch_grand_total,$this->session->userdata('default_currency_digit')); ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- /* sale details reports css end*/ -->


<script type="text/javascript">
    $(function() {

        $('.user_branch_id').change(function() {
            var user_branch_id = $(".user_branch_id").val();
            if(user_branch_id.length > 1){
                if(user_branch_id.includes("ALL")){
                    $(".user_branch_id").val("ALL");
                }
            }
        });
        
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