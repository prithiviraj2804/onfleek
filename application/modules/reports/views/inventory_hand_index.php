<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php _trans('lable619'); ?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-rounded btn-primary btn-padding-left-right-40" target="_blank" href="<?php echo site_url('reports/generate_inventory_pdf/InventoryInHand/'.($product_name?$product_name:0).'/'.($product_category?$product_category:0)); ?>">
                        <i class="fa fa-edit fa-margin"></i> <?php _trans('print'); ?>
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
        <div class='col-md-3 padding0px'>
            <div class="form-group">
                <label><?php _trans('lable207'); ?></label>
                <div class='input-group'>
                    <input type="text" name="product_name" id="product_name" class="form-control" value="<?php echo $product_name;?>" autocomplete="off">                     
                </div>
            </div>
        </div>
        <div class='col-md-3'>
            <div class="form-group">
                <label><?php _trans('lable208'); ?></label>
                <div class='input-group'>
                    <select name="product_category_id" id="product_category_id" class="searchSelect bootstrap-select bootstrap-select-arrow g-input" data-live-search="true">
                        <option value=""><?php _trans('lable209'); ?></option>
                        <?php foreach ($families as $family) { ?>
                            <option value="<?php echo $family->family_id; ?>" <?php if($product_category == $family->family_id){echo "selected";}?>><?php echo $family->family_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class='col-md-3' style="margin-top: 1.6%;">
            <div class="form-group">
                <div class='input-group paddingTop5px'>
                    <input type="submit" class="btn btn-success" name="btn_submit" value="<?php _trans('run_report'); ?>">
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
                            <th class="text_align_left"><?php _trans('lable25'); ?></th>
                            <th class="text_align_left"><?php _trans('lable208'); ?></th>
                            <th class="text_align_center"><?php _trans('lable1236'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($results) > 0){
                        $overall_balance_stock = 0;
                        foreach ($results as $result){
                            $overall_balance_stock += $result->balance_stock; ?>
                        <tr>
                            <td class="text_align_left"><?php echo $result->product_name; ?></td>
                            <td class="text_align_left"><?php echo $result->family_name; ?></td>
                            <td class="text_align_center"><?php echo ($result->balance_stock?$result->balance_stock:"-"); ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td></td>
                            <td class="text-right"><strong><?php _trans('lable625'); ?></strong></td>
                            <td class="text-center">
                                <span><strong><?php echo $overall_balance_stock; ?></strong></span>
                            </td>
                        <tr>
                        <?php }else{ ?>
                        <tr>
                            <td colspan="3" align="center"><?php _trans('lable23'); ?></td>
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