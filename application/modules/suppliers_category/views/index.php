<?php if(count($suppliercategory) < 1) {  ?>
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
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('suppliers_category/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('label922'); ?>
            </a>
        </div>
    </div>
</div>
<?php } else { ?>
<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php _trans('lable855')?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-sm btn-primary" href="<?php echo site_url('suppliers_category/form'); ?>">
                        <i class="fa fa-plus"></i> <?php _trans('lable40'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<div id="content" class="table-content">
    <section class="card">
        <div class="card-block">
            <div class="row col-xl-12 col-lg-12 col-md-12 col-sm-12 padding0px">
                <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>"autocomplete="off">
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable856')?></label>
                    <div class="form_controls">
                        <input onkeyup="searchFilter()" type="text" name="suppliers_category_name" id="suppliers_category_name" class="form-control" value="<?php echo $name;?>" autocomplete="off">
                    </div>
                </div>
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"></label>
                    <div class="form_controls paddingTop18px">
                        <span><button onkeyup="searchFilter()" name="btn_submit" type="submit" class="btn_submit btn btn-primary"><?php _trans('lable39'); ?></button></span>
                        <span><span id="reset_filter" class="btn"><?php _trans('lable827'); ?></span></span>
                    </div>
                </div>
            </div>
            <div id="posts_content">
                <div class="overflowScrollForTable">
                    <table class="display table datatable table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th><?php _trans('lable244')?></th>
                                <th class="text_align_center"><?php _trans('lable22'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($suppliercategory)) { 
                                $i = 1;
                            foreach ($suppliercategory as $suppcategory) { 
                            if(count($suppliercategory) >= 4)
                            {
                                if(count($suppliercategory) == $i || count($suppliercategory) == $i+1)
                                    {
                                        $dropup = "dropup";
                                    }
                                    else
                                    {
                                        $dropup = "";
                                    }
                            } ?>
                            <tr>
                                <td><?php _htmlsc($suppcategory->suppliers_category_name); ?></td>
                                <td class="text_align_center">
                                <?php if($suppcategory->workshop_id != 1 && $suppcategory->w_branch_id != 1){ ?>
                                    <div class="options btn-group <?php echo $dropup; ?>">
                                        <a class="btn btn-default btn-sm dropdown-toggle"
                                        data-toggle="dropdown" href="#">
                                            <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                        </a>
                                        <ul class="optionTag dropdown-menu">
                                            <li>
                                                <a href="<?php echo site_url('suppliers_category/form/' . $suppcategory->suppliers_category_id); ?>">
                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_record('suppliers_category',<?php echo $suppcategory->suppliers_category_id; ?>, '<?= $this->security->get_csrf_hash() ?>')"> <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                <?php }?>
                                </td> 
                            </tr>
                            <?php $i++; } } else { echo '<tr><td colspan="2" class="text-center" > No data found </td></tr>'; } ?>
                        </tbody>
                    </table>
                </div>
                <div class="headerbar-item pull-right">
                    <?php echo $createLinks;?>
                </div>
            </div>
        </div>
    </section>
</div>
<script>

function searchFilter(page_num) {
    page_num = page_num?page_num:0;
    var suppliers_category_name = $('#suppliers_category_name').val()?$('#suppliers_category_name').val():'';

    $.post('<?php echo site_url('suppliers_category/ajax/get_filter_list'); ?>', {
        page : page_num,
        suppliers_category_name : suppliers_category_name,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {    
        list = JSON.parse(data);
        if(list.success=='1'){
            var html = '';
            html += '<div class="overflowScrollForTable">';
            html += '<table class="display table datatable table-bordered" cellspacing="0" width="100%">';
            html += '<thead><tr><th><?php _trans('lable244')?></th>';
            html += '<th class="text_align_center"><?php _trans("lable22"); ?></th>';
            html += '</tr></thead><tbody>';
            if(list.suppliercategory.length > 0){
                for(var v=0; v < list.suppliercategory.length; v++){ 
                if(list.suppliercategory.length >= 4)
                {   
                    if(list.suppliercategory.length == v || list.suppliercategory.length == v+1)
                    {
                        var dropup = "dropup";
                    }
                    else
                    {
                        var dropup = "";
                    }
                }
                    html += '<tr><td data-original-title="'+list.suppliercategory[v].suppliers_category_name+'" data-toggle="tooltip" class="textEllipsis">'+list.suppliercategory[v].suppliers_category_name+'</td>';
                    html += '<td class="text_align_center">';
                    html += '<div class="options btn-group '+dropup+'">';
                    html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">';
                    html += '<i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
                    html += '<ul class="optionTag dropdown-menu"><li>';
                    html += '<a href="<?php echo site_url("suppliers_category/form/'+list.suppliercategory[v].suppliers_category_id+'"); ?>">';
                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable44"); ?></a></li>';
                    html += '<li><a href="javascript:void(0)" onclick="delete_record(\'suppliers_category\',\''+list.suppliercategory[v].suppliers_category_id+'\',\'<?= $this->security->get_csrf_hash() ?>\')">';
                    html += '<i class="fa fa-trash-o fa-margin"></i> <?php _trans("lable47"); ?></a></li>';
                    html += '</li></ul></div></td></tr>';
                } 
            }else{ 
                html += '<tr><td colspan="2" class="text-center" > No data found </td></tr>';
            }
            html += '</tbody></table></div>';
            html += '<div class="headerbar-item pull-right paddingTop20px">';
            html += list.createLinks;
            html += '</div>';
            $('#posts_content').html(html);
        }
    });

    $('body').on('mouseenter', '.table', function () {
        $(".datatable [data-toggle='tooltip']").tooltip();
    });
}

$(function() {

    $("[data-toggle='tooltip']").tooltip();

    $(".card-block input").keypress(function (e) {
        if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
            $('.btn_submit').click();
            return false;
        } else {
            return true;
        }
    });

    $("#reset_filter").click(function () {
        $("#suppliers_category_name").val('');
        searchFilter();
    });

});
</script>
<?php } ?>