<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php _trans('lable644'); ?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-rounded btn-primary btn-padding-left-right-40" target="_blank" href="<?php echo site_url('reports/generate_pdf/SalesProductReports/'.date_to_mysql($from_date).'/'.date_to_mysql($to_date).'/'.$user_branch_id); ?>">
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
        <div class='col-md-3 padding0px'>
            <div class="form-group">
                <div class='input-group paddingTop5px'>
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
            <div class="overflowScrollForTable">
                <table class="display table table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <!-- <th class="text_align_center"><?php _trans('lable31'); ?></th> -->
                            <th class="text_align_center"><?php _trans('lable25'); ?></th>
                            <th class="text_align_center"><?php _trans('lable208'); ?></th>
                            <th class="text_align_center"><?php _trans('lable643'); ?></th>
                            <th class="text_align_right"><?php _trans('lable642'); ?></th>
                            <th class="text_align_right"><?php _trans('lable641'); ?></th>
                            <th class="text_align_right"><?php _trans('lable331'); ?></th>
                            <th class="text_align_right"><?php _trans('lable637'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($results) > 0){
                            $totalQuantity = 0;
                            $totalPurchaseCost = 0;
                            $totalSaleCost = 0;
                            $totalTax = 0;
                            $overall_grand_total = 0;
                            foreach ($results as $result){

                                $totalQuantity += $result->qty;
                                $totalPurchaseCost += $result->cost_price;
                                $totalSaleCost += $result->sale_price;
                                $totalTax += $result->igst_amt+$result->cgst_amt+$result->sgst_amt;
                                $overall_grand_total += $result->amt;
                                
                                
                            ?>
                            <tr>
                                <?php /* * / ?><td class="text_align_center"><?php echo $result->invoice_date; ?></td><?php / * */ ?>
                                <td class="text_align_left"><?php echo $result->product_name; ?></td>
                                <td class="text_align_left"><?php echo $result->family_name; ?></td>
                                <td class="text_align_center"><?php echo $result->qty; ?></td>
                                <td class="text_align_right"><?php echo format_currency($result->cost_price); ?></td>
                                <td class="text_align_right"><?php echo format_currency($result->sale_price); ?></td>
                                <td class="text_align_right"><?php echo $result->igst_amt+$result->cgst_amt+$result->sgst_amt; ?></td>
                                <td class="text_align_right"><?php echo format_currency($result->amt); ?></td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="2" class="text_align_right"><strong><?php _trans('lable625'); ?></strong></td>
                                <td class="text_align_center"><strong><?php echo $totalQuantity; ?></strong></td>
                                <td class="text_align_right"><strong><?php echo format_currency($totalPurchaseCost); ?></strong></td>
                                <td class="text_align_right"><strong><?php echo format_currency($totalSaleCost); ?></strong></td>
                                <td class="text_align_right"><strong><?php echo format_currency($totalTax); ?></strong></td>
                                <td class="text_align_right"><strong><?php echo format_currency($overall_grand_total); ?></strong></td>
                            </tr>
                            <?php } else { ?>
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