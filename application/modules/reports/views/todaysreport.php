<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php _trans('lable659'); ?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <?php // ?>
                    <a class="btn btn-rounded btn-primary btn-padding-left-right-40" target="_blank" href="<?php echo site_url('reports/generate_pdf/Todaysreport/'.date_to_mysql($from_date).'/'.date_to_mysql($to_date).'/'.str_replace(",","-",$user_branch_id)); ?>">
                        <i class="fa fa-edit fa-margin"></i> <?php _trans('lable141'); ?>
                    </a>
                    <?php // ?>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container row">
    <div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 top-15">
			<a class="anchor anchor-back" href="<?php echo site_url('dashboard'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
		</div>
	</div>
    <form method="POST" action="<?php echo site_url($this->uri->uri_string()); ?>">
    <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
        <div class='col-md-3 padding-left-0px'>
            <div class="form-group">
                <label><?php _trans('lable361'); ?></label>
                <div class='input-group'>
                    <input type='text' name="from_date" id="from_date" value="<?php echo $from_date;?>" class="form-control datepicker" />
                    <label class="input-group-addon" for="to_date">
                        <span class="fa fa-calendar"></span>
                    </label> 
                </div>
            </div>
        </div>
        <div class='col-md-3'>
            <div class="form-group">
                <label><?php _trans('lable630'); ?></label>
                <div class='input-group'>
                    <input type='text' name="to_date" id="to_date" value="<?php echo $to_date;?>" class="form-control datepicker" />
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
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class='col-md-3'>
                <div class="form-group">
                    <label></label>
                    <div class='input-group paddingTop20px'>
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
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div><h6><strong><?php _trans('lable660'); ?>: <?php echo $from_date;?> <?php _trans('lable176'); ?> <?php echo $to_date;?></strong></h6></div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php if(count($todaysreport) > 0){
            foreach ($todaysreport as $result){ ?>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 paddingTop40px">
                    <div><h6><strong><?php echo $result->display_board_name; ?></strong></h6></div>
                    <table class="display table table-bordered" style="table-layout:fixed;" cellspacing="0" width="100%">
                        <tbody>
                            <tr>
                                <td><?php _trans('lable661'); ?></td>
                                <td class="text_align_right"><?php echo ($result->total_vehicle?$result->total_vehicle:0); ?></td>
                            </tr>
                            <tr>
                                <td><?php _trans('lable662'); ?></td>
                                <td class="text_align_right"><?php echo ($result->grand_total?$result->grand_total:0); ?></td>
                            </tr>
                            <tr>
                                <td><?php _trans('lable663'); ?></td>
                                <td class="text_align_right"><?php echo ($result->expense_grand_total?$result->expense_grand_total:0); ?></td>
                            </tr>
                            <tr>
                                <td><strong><?php _trans('lable114'); ?></strong></td>
                                <td class="text_align_right"><strong><?php echo (($result->grand_total?$result->grand_total:0) - ($result->expense_grand_total?$result->expense_grand_total:0)); ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
            </div>
            <?php } else{
                echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">No data Found</div>';
            }?>
            <br>
            <br>
            <div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop40px">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-centered text-center">
                    <div><h6><strong><?php _trans('lable664'); ?></strong></h6></div>
                    <table class="display table table-bordered" style="table-layout:fixed;" cellspacing="0" width="100%">
                        <tbody>
                            <?php 
                            $overall_income = 0;
                            $overall_expense = 0;
                            foreach($todaysreport as $result) {
                                $overall_income += $result->grand_total;
                                $overall_expense += $result->expense_grand_total;
                            } ?>
                            <tr class="income pointer">
                                <td><?php echo "Overall Income"; ?></td>
                                <td class="text_align_right"><?php echo "".($overall_income).""; ?></td>
                            </tr>
                            <tr class="collapse" style="display:none;" id="incomedetail">
                                <td colspan="2">
                                    <table width="100%" style="table-layout: fixed;">
                                        <tbody>
                                            <?php foreach($todaysreport as $result) { ?>
                                            <tr>
                                                <td><?php echo $result->display_board_name; ?></td>
                                                <td class="text_align_right"><?php echo $result->grand_total; ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr class="expense pointer">
                                <td><?php echo "Overall Expense"; ?></td>
                                <td class="text_align_right"><?php echo "".($overall_expense).""; ?></td>
                            </tr>
                            <tr class="collapse" style="display:none;" id="expensedetail">
                                <td colspan="2">
                                    <table width="100%" style="table-layout: fixed;">
                                        <tbody>
                                            <?php foreach($todaysreport as $result) { ?>
                                            <tr>
                                                <td><?php echo $result->display_board_name; ?></td>
                                                <td class="text_align_right"><?php echo $result->expense_grand_total; ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo "<strong> Overall Total</strong>"; ?></td>
                                <td class="text_align_right"><?php echo "<strong>".($overall_income - $overall_expense)."</strong>"; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- /* sale details reports css end*/ -->

<script type="text/javascript">
    $(function() {

        $(".income").click(function(){
            $('#incomedetail').toggle();
        });

        $(".expense").click(function(){
            $('#expensedetail').toggle();
        });

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