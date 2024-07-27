<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php  _trans('lable249'); ?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-sm btn-primary" href="<?php echo site_url('mechanic_service_category_items/form'); ?>">
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
                    <label class="form_label"><?php _trans('lable250'); ?></label>
                    <div class="form_controls">
                        <input onkeyup="searchFilter()" type="text" name="service_item_name" id="service_item_name" class="form-control" value="<?php echo $name;?>" autocomplete="off">
                    </div>
                </div>
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable251'); ?></label>
                    <div class="form_controls">
                        <select onchange="searchFilter()" name="service_category_id" id="service_category_id" class="searchSelect bootstrap-select bootstrap-select-arrow g-input form-control removeError" autocomplete="off" data-live-search="true">
                            <option value=""><?php _trans('lable252'); ?></option>
                            <?php if ($service_category_lists):
                            foreach ($service_category_lists as $key => $service_category):
                            ?>
                            <option value="<?php echo $service_category->service_cat_id; ?>" <?php if ($service_category->service_cat_id == $cat) {
                                echo 'selected';
                            }?>> <?php echo $service_category->category_name; ?></option>
                            <?php endforeach;
                            endif;
                            ?>
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
                                <th><?php _trans('lable253'); ?></th>
                                <th><?php _trans('lable251'); ?></th>
                                <th class="text_align_center"><?php  _trans('lable22'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($mechanic_service_category_items) > 0 ){
                                $i = 1;
                                foreach ($mechanic_service_category_items as $mechanic_service_category) { 
                            if(count($mechanic_service_category_items) >= 4) 
                            {      
                                if(count($mechanic_service_category_items) == $i || count($mechanic_service_category_items) == $i+1)
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
                                <td data-original-title="<?php _htmlsc($mechanic_service_category->service_item_name); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($mechanic_service_category->service_item_name); ?></td>
                                <td data-original-title="<?php _htmlsc($mechanic_service_category->category_name); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($mechanic_service_category->category_name); ?></td>
                                <td class="text_align_center">
                                <?php if(($this->session->userdata('work_shop_id') == 1 && $this->session->userdata('user_type') == 1) || ($this->session->userdata('work_shop_id') == $mechanic_service_category->workshop_id)){ ?>
                                    <div class="options btn-group <?php echo $dropup; ?>">
                                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php _trans('lable22'); ?></a>
                                        <ul class="optionTag dropdown-menu">
                                            <li>
                                                <a href="<?php echo site_url('mechanic_service_category_items/form/'.$mechanic_service_category->sc_item_id); ?>"><i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?></a>
                                            </li>
                                            <li>

                                                <a href="javascript:void(0)" onclick="delete_record('mechanic_service_category_items',<?php echo $mechanic_service_category->sc_item_id; ?>, '<?= $this->security->get_csrf_hash() ?>')"> <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?></a>

                                            </li>
                                        </ul>
                                    </div>
                                <?php } ?>
                                </td>
                            </tr>
                            <?php $i++;} } else { echo '<tr><td colspan="3" class="text-center" > No data found </td></tr>'; } ?>
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
    var service_item_name = $('#service_item_name').val()?$('#service_item_name').val():'';
    var service_category_id = $("#service_category_id").val()?$("#service_category_id").val():'';

    $.post('<?php echo site_url('mechanic_service_category_items/ajax/get_filter_list'); ?>', {
        page : page_num,
        service_item_name : service_item_name,
        service_category_id : service_category_id,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            var html = '';
            html += '<div class="overflowScrollForTable">';
            html += '<table class="display table datatable table-bordered" cellspacing="0" width="100%">';
            html += '<thead><tr><th><?php _trans("lable253"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable251"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable22"); ?></th>';
            html += '</tr></thead><tbody>';
            if(list.mechanic_service_category_items.length > 0){
                for(var v=0; v < list.mechanic_service_category_items.length; v++){ 
                if(list.mechanic_service_category_items.length >= 4)
                {    
                    if(list.mechanic_service_category_items.length == v || list.mechanic_service_category_items.length == v+1)
                    {
                        var dropup = "dropup";
                    }
                    else
                    {
                        var dropup = "";
                    }
                }  
                    html += '<tr><td data-original-title="'+list.mechanic_service_category_items[v].service_item_name+'" data-toggle="tooltip" class="textEllipsis">'+list.mechanic_service_category_items[v].service_item_name+'</td>';
                    html += '<td class="text_align_center" data-original-title="'+list.mechanic_service_category_items[v].category_name+'" data-toggle="tooltip" class="textEllipsis">';
                    if(list.mechanic_service_category_items[v].category_name == '' || list.mechanic_service_category_items[v].category_name == null || list.mechanic_service_category_items[v].category_name == 'null'){
                        html += ' ';
                    }else{
                        html += list.mechanic_service_category_items[v].category_name;
                    }
                    html += '</td>';
                    html += '<td class="text_align_center">';
                    html += '<div class="options btn-group '+dropup+'">';
                    html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">';
                    html += '<i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
                    html += '<ul class="optionTag dropdown-menu"><li>';
                    html += '<a href="<?php echo site_url("mechanic_service_category_items/form/'+list.mechanic_service_category_items[v].sc_item_id+'"); ?>">';
                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable44"); ?></a></li><li>';
                    html += '<a href="javascript:void(0)" onclick="delete_record(\'mechanic_service_category_items\',\''+list.mechanic_service_category_items[v].sc_item_id+'\',\'<?= $this->security->get_csrf_hash() ?>\')">';
                    html += '<i class="fa fa-trash-o fa-margin"></i> <?php _trans("lable47"); ?></a>';
                    html += '</li></ul></div></td></tr>';
                } 
            }else{ 
                html += '<tr><td colspan="3" class="text-center" > No data found </td></tr>';
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
        $("#service_item_name").val('');
        $("#service_category_id").val('');
        $('.bootstrap-select').selectpicker("refresh");
        searchFilter();
    });

});
</script>