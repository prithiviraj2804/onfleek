<input type="hidden" id="_mm_csrf" name="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>"autocomplete="off">
<?php if(count($view_alerts) < 1) {  ?>
<script type="text/javascript">
    $(function() {
        var getHeight = $( window ).height();
        $(".imageDynamicHeight").css('height' , getHeight - 200);
    });
</script>
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center imageDynamicHeight" style="display: table;">
    <div class="tbl-cell">
        <img style="width: 30%; text-center" src="<?php echo base_url(); ?>assets/mp_backend/img/no_data_available.jpg" alt="Mechtoolz">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
        </div>
    </div>
</div>
<?php } else { ?>
<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php _trans('lable1173'); ?></h3>
                </div>
            </div>
        </div>
    </div>
</header>
<div id="content" class="table-content">
    <section class="card">
		<div class="card-block">
            <div id="posts_content">
                <button id="showsavebtn" style="display:none;" class="float-right btn_submit btn btn-primary save"> <?php _trans('lable1142'); ?> </button>
                <div class="overflowScrollForTable">
                    <table class="display table datatable table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th><?php _trans('lable25'); ?></th>
                                <th><?php _trans('lable1024'); ?></th>
                                <th><?php _trans('lable27') ?></th>
                                <th><?php _trans('lable1029') ?></th>
                                <th><?php _trans('lable224') ?></th>
                                <th><?php _trans('lable225') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($view_alerts) > 0) { 
                            foreach($view_alerts as $vi_als){ ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="product_ids" name="product_ids" value="<?php _htmlsc($vi_als->product_id);?>" >
                                </td>
                                <td data-original-title="<?php _htmlsc($vi_als->product_name);?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($vi_als->product_name); ?></td>
                                <td data-original-title="<?php _htmlsc($vi_als->part_number);?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($vi_als->part_number); ?></td>
                                <td data-original-title="<?php _htmlsc($vi_als->balance_stock);?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($vi_als->balance_stock); ?></td>
                                <td data-original-title="<?php _htmlsc($vi_als->mrp_price);?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($vi_als->mrp_price); ?></td>
                                <td data-original-title="<?php _htmlsc($vi_als->cost_price);?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($vi_als->cost_price); ?></td>
                                <td data-original-title="<?php _htmlsc($vi_als->sale_price);?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($vi_als->sale_price); ?></td>
                            </tr>
                            <?php $i++; } } else { echo '<tr><td colspan="2" class="text-center" > No data found </td></tr>'; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<script>

$(function() {
    $("[data-toggle='tooltip']").tooltip();

    $('.product_ids').click(function() {
        var checkboxes = $('input:checkbox:checked').length;
        if(checkboxes > 0){
            $("#showsavebtn").show();
        }else{
            $("#showsavebtn").hide();
        }
    });

    $("#showsavebtn").click(function() {

        // console.log("i am hegtf");
        var yourArray = [];
        $('input[name="product_ids"]:checked').each(function() {
            yourArray.push(this.value);
        });

        if(yourArray.length  > 0){
            swal({
                title: "Are you sure?",
                text: "You want to add those products into your purchase order",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
                closeOnCancel: false
            },function(isConfirm) {
                if (isConfirm) {
                    $('#gif').show();
                    $.post('<?php echo site_url('view_alerts/ajax/converttopurchaseorder'); ?>', {
                        product_items : yourArray,
                        _mm_csrf: $('#_mm_csrf').val()
                    }, function (data) {	
                        list = JSON.parse(data);
                        // console.log(list);
                        if(list.success == 1){
                            swal({
                                title: "successfully added to purchase order",
                                text: "",
                                type: "success",
                                confirmButtonClass: "btn-success"
                            },function() {
                                setTimeout(function(){
                                    window.location = "<?php echo site_url('mech_purchase_order/create/'); ?>"+list.purchase_id;
                                }, 100);
                            });
                        }
                        $('#gif').hide();
                    });
                } else {
                    swal({
                        title: "Cancelled",
                        text: "",
                        type: "error",
                        confirmButtonClass: "btn-danger"
                    });
                }
            });
        }
    });

});
</script>
<?php } ?>