<?php if(count($mechanic_service_category_list) < 1) {  ?>
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
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('mechanic_service_category/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('label928'); ?>
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
                    <h3><?php _trans('lable239'); ?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-sm btn-primary" href="<?php echo site_url('mechanic_service_category/form'); ?>">
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
                <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable240'); ?></label>
                    <div class="form_controls">
                        <input onkeyup="searchFilter()" type="text" name="category_name" id="category_name" class="form-control" autocomplete="off">
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
                    <div class="form_controls paddingTop15px">
                        <span><button onclick="searchFilter()" class="btn_submit btn btn-primary"><?php _trans('lable39'); ?></button></span>
                        <span><span id="reset_filter" class="btn"><?php _trans('lable827'); ?></span></span>
                    </div>
                </div>
            </div>
            <div id="posts_content">
                <div class="overflowScrollForTable">
                    <table id="mechanic_service_category" class="display table datatable table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th><?php _trans('lable50'); ?></th>
                                <th><?php _trans('lable248'); ?></th>
                                <th><?php _trans('lable177'); ?></th>
                                <th><?php _trans('label946'); ?></th>
                                <th class="text_align_center"><?php _trans('lable22'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($mechanic_service_category_list)>0){
                                $i = 1;
                                foreach ($mechanic_service_category_list as $mechanic_service_category) { 
                            if(count($mechanic_service_category_list) >= 4 )
                            {        
                                if(count($mechanic_service_category_list) == $i || count($mechanic_service_category_list) == $i+1)
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
                                <td data-original-title="<?php _htmlsc($mechanic_service_category->category_name);?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($mechanic_service_category->category_name); ?></td>
                                <td data-original-title="<?php _htmlsc($mechanic_service_category->service_short_description?$mechanic_service_category->service_short_description:"-");?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($mechanic_service_category->service_short_description?$mechanic_service_category->service_short_description:"-"); ?></td>
                                <td data-original-title="<?php _htmlsc($mechanic_service_category->service_description?$mechanic_service_category->service_description:"-");?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($mechanic_service_category->service_description?$mechanic_service_category->service_description:"-"); ?></td>
                                <td data-original-title="<?php if($mechanic_service_category->enable_mobile == 'Y'){ echo "Enable"; } else{ echo 'Disable'; } ?>" data-toggle="tooltip" class="textEllipsis"><?php if($mechanic_service_category->enable_mobile == 'Y'){ echo "Enable"; } else{ echo 'Disable'; } ?></td>

                                <td class="text_align_center">
                                    <?php if (($this->session->userdata('work_shop_id') == 1 && $this->session->userdata('user_type') == 1) || ($this->session->userdata('work_shop_id') == $mechanic_service_category->workshop_id)) { ?>
                                    <div class="options btn-group <?php echo $dropup; ?>">
                                        <a class="btn btn-default btn-sm dropdown-toggle"
                                            data-toggle="dropdown" href="#">
                                            <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                        </a>
                                        <ul class="optionTag dropdown-menu">
                                            <li>
                                                <a href="<?php echo site_url('mechanic_service_category/form/'.$mechanic_service_category->service_cat_id); ?>">
                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_record('mechanic_service_category',<?php echo $mechanic_service_category->service_cat_id; ?>,'<?= $this->security->get_csrf_hash() ?>')">
                                                <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php $i++;} } else { echo '<tr><td colspan="2" class="text-center" > No data found </td></tr>'; } ?>
                        </tbody>
                    </table>
                </div>
                <div class="headerbar-item pull-right paddingTop20px">
                    <?php echo $createLinks;?>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
function searchFilter(page_num) {
    page_num = page_num?page_num:0;
    var category_name = $('#category_name').val()?$('#category_name').val():'';
    var service_short_description = $('#service_short_description').val()?$('#service_short_description').val():'';
    var service_description = $('#service_description').val()?$('#service_description').val():'';
    var category_owner = $('#category_owner').val()?$('#category_owner').val():'';

    $.post('<?php echo site_url('mechanic_service_category/ajax/get_filter_list'); ?>', {
        page : page_num,
        category_name : category_name,
        service_short_description : service_short_description,
        service_description : service_description,
        category_owner : category_owner,
        _mm_csrf: $('#_mm_csrf').val()

    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            var html = '';
            html += '<div class="overflowScrollForTable">';
            html += '<table class="display table datatable table-bordered" cellspacing="0" width="100%">';
            html += '<thead><tr><th><?php _trans('lable50'); ?></th>';
            html += '<th><?php _trans('lable248'); ?></th>';
            html += '<th><?php _trans('lable177'); ?></th>';
            html += '<th><?php _trans('label946'); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable22"); ?></th>';
            html += '</tr></thead><tbody>';
            if(list.mechanic_service_category_list.length > 0){
                for(var v=0; v < list.mechanic_service_category_list.length; v++){ 
                
                if(list.mechanic_service_category_list.length >= 4)
                {    
                    if(list.mechanic_service_category_list.length == v || list.mechanic_service_category_list.length == v+1)
                    {
                        var dropup = "dropup";
                    }
                    else
                    {
                        var dropup = "";
                    }
                }    
                    html += '<tr><td data-original-title="'+list.mechanic_service_category_list[v].category_name+'" data-toggle="tooltip" class="textEllipsis">'+list.mechanic_service_category_list[v].category_name+'</td>';
                    html += '<td data-original-title="'+((list.mechanic_service_category_list[v].service_short_description)?list.mechanic_service_category_list[v].service_short_description:" ")+'" data-toggle="tooltip" class="textEllipsis">'+((list.mechanic_service_category_list[v].service_short_description)?list.mechanic_service_category_list[v].service_short_description:" ")+'</td>';
                    html += '<td data-original-title="'+((list.mechanic_service_category_list[v].service_description)?list.mechanic_service_category_list[v].service_description:" ")+'" data-toggle="tooltip" class="textEllipsis">'+((list.mechanic_service_category_list[v].service_description)?list.mechanic_service_category_list[v].service_description:" ")+'</td>';
                    html += '<td class="text-center" data-original-title="';
					if(list.mechanic_service_category_list[v].enable_mobile == 'Y'){ html += 'Enable'; }else{ html += 'Disable'; }
                    html += '" data-toggle="tooltip" class="textEllipsis">';
                    if(list.mechanic_service_category_list[v].enable_mobile == 'Y'){ html += 'Enable'; }else{ html += 'Disable'; }
                    html += '</td>';
                    html += '<td class="text_align_center">';
                    if(list.mechanic_service_category_list[v].workshop_id != 1 && list.mechanic_service_category_list[v].w_branch_id != 1){
                    html += '<div class="options btn-group '+dropup+'">';
                    html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">';
                    html += '<i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
                    html += '<ul class="optionTag dropdown-menu"><li>';
                    html += '<a href="<?php echo site_url("mechanic_service_category/form/'+list.mechanic_service_category_list[v].service_cat_id+'"); ?>">';
                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable44"); ?></a></li><li>';
                    html += '<a href="javascript:void(0)" onclick="delete_record(\'mechanic_service_category\',\''+list.mechanic_service_category_list[v].service_cat_id+'\',\'<?= $this->security->get_csrf_hash() ?>\')">';
                    html += '<i class="fa fa-trash-o fa-margin"></i> <?php _trans("lable47"); ?></a></li>';
                    html += '</li></ul></div></td>';
                    }
                    html +='</tr>';
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
        $("#category_name").val('');
        $("#category_owner").val('');
        $('.bootstrap-select').selectpicker("refresh");
        searchFilter();
    });

});
</script>
<?php } ?>