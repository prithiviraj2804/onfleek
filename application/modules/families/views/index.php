<?php if(count($families) < 1) {  ?>
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
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('families/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('label926'); ?>
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
                    <h3><?php _trans('lable235'); ?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-sm btn-primary" href="<?php echo site_url('families/form'); ?>">
                        <i class="fa fa-plus"></i> <?php _trans('lable40'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<div id="content" class="table-content">
    <?php $this->layout->load_view('layout/alerts'); ?>
    <section class="card">
		<div class="card-block">
            <div class="row col-xl-12 col-lg-12 col-md-12 col-sm-12 padding0px">
                <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>"autocomplete="off">
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable236'); ?></label>
                    <div class="form_controls">
                        <input onkeyup="searchFilter()" type="text" name="family_name" id="family_name" class="form-control" value="<?php echo $name;?>" autocomplete="off">
                    </div>
                </div>
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable1238'); ?></label>
                    <div class="form_controls">
                        <select name="category_owner" id="category_owner" class="bootstrap-select bootstrap-select-arrow g-input removeError">
                            <option value=""><?php _trans("lable1239"); ?></option>
                            <option value="O">Own</option>
                            <option value="A">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"></label>
                    <div class="form_controls paddingTop18px">
                        <span><button onclick="searchFilter()" class="btn_submit btn btn-primary"><?php _trans('lable39'); ?></button></span>
                        <span><span id="reset_filter" class="btn"><?php _trans('lable827'); ?></span></span>
                    </div>
                </div>
            </div>
            <div id="posts_content">
                <div class="overflowScrollForTable">
                    <table class="display table datatable table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th><?php _trans('lable236'); ?></th>
                                <th class="text_align_center"><?php _trans('lable22'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($families)) { 
                                $i = 1;
                                foreach ($families as $family) { 

                            if(count($families) >= 4)
                            {
                                    if(count($families) == $i || count($families) == $i+1)
                                    {
                                        $dropup = "dropup";
                                    }
                                    else
                                    {
                                        $dropup = "";
                                    }
                            }    
                            ?>
                            <tr>
                                <td data-original-title="<?php echo $family->family_name;?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($family->family_name); ?></td>
                                <td class="text_align_center">
                                <?php if($family->workshop_id != 1 && $family->w_branch_id != 1){ ?>
                                    <div class="options btn-group <?php echo $dropup; ?>">
                                        <a class="btn btn-default btn-sm dropdown-toggle"
                                        data-toggle="dropdown" href="#">
                                            <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                        </a>
                                        <ul class="optionTag dropdown-menu">
                                            <li>
                                                <a href="<?php echo site_url('families/form/' . $family->family_id); ?>">
                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_record('families',<?php echo $family->family_id; ?>, '<?= $this->security->get_csrf_hash() ?>')"> <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?></a>
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
    var family_name = $('#family_name').val()?$('#family_name').val():'';
    var category_owner = $('#category_owner').val()?$('#category_owner').val():'';

    $.post('<?php echo site_url('families/ajax/get_filter_list'); ?>', {
        page : page_num,
        family_name : family_name,
        category_owner : category_owner,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            var html = '';
            html += '<div class="overflowScrollForTable">';
            html += '<table class="display table datatable table-bordered" cellspacing="0" width="100%">';
            html += '<thead><tr><th><?php _trans("lable236"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable22"); ?></th>';
            html += '</tr></thead><tbody>';
            if(list.families.length > 0){
                for(var v=0; v < list.families.length; v++){ 
                if(list.families.length >= 4 )  
                { 
                    if(list.families.length == v || list.families.length == v+1)
                    {
                        var dropup = "dropup";
                    }
                    else
                    {
                        var dropup = "";
                    }
                }    
                    html += '<tr><td data-original-title="'+list.families[v].family_name+'" data-toggle="tooltip" class="textEllipsis">'+list.families[v].family_name+'</td>';
                    html += '<td class="text_align_center">';
                    if(list.families[v].workshop_id != 1 && list.families[v].w_branch_id != 1){
                    html += '<div class="options btn-group '+dropup+'">';
                    html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">';
                    html += '<i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
                    html += '<ul class="optionTag dropdown-menu"><li>';
                    html += '<a href="<?php echo site_url("families/form/'+list.families[v].family_id+'"); ?>">';
                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable44"); ?></a></li>';
                    html += '<li><a href="javascript:void(0)" onclick="delete_record(\'families\',\''+list.families[v].family_id+'\',\'<?= $this->security->get_csrf_hash() ?>\')">';
                    html += '<i class="fa fa-trash-o fa-margin"></i> <?php _trans("lable47"); ?></a></li>';
                    html += '</li></ul></div></td>';
                    }
                    html +='</tr>';
                } 
            }else{ 
                html += '<tr><td colspan="6" class="text-center" > No data found </td></tr>';
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
        $("#family_name").val('');
        $("#category_owner").val('');
        $('.bootstrap-select').selectpicker("refresh");
        searchFilter();
    });

});
</script>
<?php } ?>