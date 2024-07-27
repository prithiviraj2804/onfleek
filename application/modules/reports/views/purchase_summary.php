<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php _trans('lable615'); ?></h3>
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
    <div class='col-md-4 padding-left-0px'>
        <div class="form-group">
            <label><?php _trans('lable361'); ?></label>
            <div class='input-group date' id='datetimepicker6'>
                <input type='text' class="form-control" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
    </div>
    <div class='col-md-4'>
        <div class="form-group">
            <label><?php _trans('lable630'); ?></label>
            <div class='input-group date' id='datetimepicker7'>
                <input type='text' class="form-control" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
    </div>
</div>


<div id="content" class="table-content">

    <?php $this->layout->load_view('layout/alerts'); ?>

    <section class="card">
        <div class="card-block">
            <div class="overflowScrollForTable">
                <table class="display table table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="text_align_center"><?php _trans('lable31'); ?></th>
                            <th class="text_align_center"><?php _trans('lable640'); ?></th>
                            <th class="text_align_center"><?php _trans('lable114'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text_align_center">12-03-2019</td>
                            <td class="text_align_center">23</td>
                            <td class="text_align_center">54000</td>
                        </tr>
                        <tr>
                            <td class="text_align_center">13-03-2019</td>
                            <td class="text_align_center">18</td>
                            <td class="text_align_center">45000</td>
                        </tr>
                        <tr>
                            <td class="text_align_center">14-03-2019</td>
                            <td class="text_align_center">20</td>
                            <td class="text_align_center">48000</td>
                        </tr>
                        <tr>
                            <td class="text_align_center">15-03-2019</td>
                            <td class="text_align_center">12</td>
                            <td class="text_align_center">24000</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text_align_right"><b><?php _trans('lable332'); ?></b></td>
                            <td class="text_align_center"><b>171000</b></td>
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