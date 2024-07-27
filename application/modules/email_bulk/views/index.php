<?php if(count($bulkemaillist) < 1) {  ?>
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
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('email_bulk/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('lable1146'); ?>
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
                    <h3><?php _trans('lable1156'); ?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-sm btn-primary" href="<?php echo site_url('email_bulk/form'); ?>">
                        <i class="fa fa-plus"></i> <?php _trans('lable274'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<div id="content" class="table-content">
    <section class="card">
		<div class="card-block">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 padding0px">
                <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
                
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable1167'); ?></label>
                    <div class="form_controls">
                        <input onkeyup="searchFilter()" type="text" name="campaign_name" id="campaign_name" class="form-control" autocomplete="off">
                    </div>
                </div>
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4" style="display:none;">
                    <label class="form_label"><?php _trans('lable19'); ?></label>
                    <div class="form_controls">
                        <select onchange="searchFilter()" name="email_status" id="email_status" class="searchSelect bootstrap-select bootstrap-select-arrow" data-live-search="true">
                            <option value=""><?php _trans('lable285'); ?></option>
                            <option <?php if($status == "P"){ echo "selected"; } ?> value="P"><?php _trans('lable560'); ?></option>
                            <option <?php if($status == "S"){ echo "selected"; } ?> value="S"><?php _trans('lable1163'); ?></option>
                            <option <?php if($status == "F"){ echo "selected"; } ?> value="F"><?php _trans('lable1164'); ?></option>
                        </select> 
                    </div>
            </div>
            <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <label class="form_label"><?php _trans('lable175'); ?></label>
                <div class="form_controls">
                    <input onchange="searchFilter()" type="text" name="from_date" id="from_date" class="form-control datepicker" autocomplete="off">
                </div>
            </div>
            <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <label class="form_label"><?php _trans('lable176'); ?></label>
                <div class="form_controls">
                    <input onchange="searchFilter()" type="text" name="to_date" id="to_date" class="form-control datepicker" autocomplete="off">
                </div>
            </div>
            <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <label class="form_label"></label>
                <div class="form_controls paddingTop18px">
                    <span><button onclick="searchFilter()" name="btn_submit" type="submit" class="btn_submit btn btn-primary"><?php _trans('lable39'); ?></button></span>
                    <span><span id="reset_filter" class="btn"><?php _trans('lable827'); ?></span></span>
                </div>
            </div>
        </div>
        <div id="posts_content">
            <div class="overflowScrollForTable">
                <table class="display table datatable table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="text_align_center"><?php _trans('lable125'); ?></th>
                            <th class="text_align_center"><?php _trans('lable31'); ?></th>
                            <th><?php _trans('lable1167'); ?></th>
                            <th class="text_align_left"><?php _trans('lable811'); ?></th>
                            <th class="text_align_center"><?php _trans('lable1153'); ?></th>
                            <th class="text_align_center"><?php _trans('lable1161'); ?></th>
                            <th class="text_align_center"><?php _trans('lable1154'); ?></th>
                            <th class="text_align_center"><?php _trans('lable1155'); ?></th>   
                            <th class="text_align_center"><?php _trans('lable1166'); ?></th>                        
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($bulkemaillist)) { 
                            $i = 1;
                        foreach ($bulkemaillist as $bulkemail) { ?>
                        <tr>
                            <td class="text_align_center" data-original-title="<?php echo $i; ?>" data-toggle="tooltip" class="textEllipsis"><?php echo $i; ?></td>
                            <td class="text_align_center" data-original-title="<?php echo date_from_mysql($bulkemail->date); ?>" data-toggle="tooltip" class="textEllipsis"><?php echo date_from_mysql($bulkemail->date); ?></td>
                            <td data-original-title="<?php _htmlsc($bulkemail->campaign_name); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($bulkemail->campaign_name); ?></td>
                            <td data-original-title="<?php _htmlsc($bulkemail->subject);?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($bulkemail->subject); ?></td>
                            <td class="text_align_center" data-original-title="<?php _htmlsc($bulkemail->client_count);?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($bulkemail->client_count); ?></td>
                            <td class="text_align_center" data-original-title="<?php echo $this->mdl_email_bulk->get_email_status_count($bulkemail->id,'P'); ?>" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_email_bulk->get_email_status_count($bulkemail->id,'P'); ?></td>
                            <td class="text_align_center" data-original-title="<?php echo $this->mdl_email_bulk->get_email_status_count($bulkemail->id,'S'); ?>" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_email_bulk->get_email_status_count($bulkemail->id,'S'); ?></td>
                            <td class="text_align_center" data-original-title="<?php echo $this->mdl_email_bulk->get_email_status_count($bulkemail->id,'F'); ?>" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_email_bulk->get_email_status_count($bulkemail->id,'F'); ?></td>
                            <td class="text_align_center" data-original-title="<?php echo $this->mdl_email_bulk->get_email_status_count($bulkemail->id,'C'); ?>" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_email_bulk->get_email_status_count($bulkemail->id,'C'); ?></td>
                        </tr>
                        <?php $i++; } } else { echo '<tr><td colspan="5" class="text-center" > No data found </td></tr>'; } ?>
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
    var from_date = $('#from_date').val()?$('#from_date').val():'';
    var to_date = $('#to_date').val()?$('#to_date').val():'';
    var campaign_name = $('#campaign_name').val()?$('#campaign_name').val():'';
    var email_status = $('#email_status').val()?$('#email_status').val():'';

    $.post('<?php echo site_url('email_bulk/ajax/get_filter_list'); ?>', {
        page : page_num,
        from_date : from_date,
        to_date   : to_date,
        campaign_name : campaign_name,
        email_status : email_status,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            var html = '';
            html += '<div class="overflowScrollForTable">';
            html += '<table class="display table datatable table-bordered" cellspacing="0" width="100%">';
            html += '<thead><tr><th class="text_align_center"><?php _trans("lable125"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable31"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable1167"); ?></th>';
            html += '<th class="text_align_left"><?php _trans("lable811"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable1153"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable1161"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable1154"); ?></th>'; 
            html += '<th class="text_align_center"><?php _trans("lable1155"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable1166"); ?></th>';
            html += '</tr></thead><tbody>';
            if(list.bulkemail.length > 0){
                for(var v=0; v < list.bulkemail.length; v++){     
                    html += '<tr><td data-original-title="'+[v+1]+'" data-toggle="tooltip" class="textEllipsis">'+[v+1]+'</td>';
                    html += '<td class="text_align_center" data-original-title="'+(list.bulkemail[v].date?formatDate(list.bulkemail[v].date):"")+'" class="text_align_center" data-toggle="tooltip" class="textEllipsis">'+(list.bulkemail[v].date?formatDate(list.bulkemail[v].date):"")+'</td>';
                    html += '<td data-original-title="'+((list.bulkemail[v].campaign_name)?list.bulkemail[v].campaign_name:" ")+'" data-toggle="tooltip" class="textEllipsis">'+((list.bulkemail[v].campaign_name)?list.bulkemail[v].campaign_name:" ")+'</td>';
                    html += '<td class="text_align_left" data-original-title="'+list.bulkemail[v].subject+'" data-toggle="tooltip" class="textEllipsis">'+list.bulkemail[v].subject+'</td>';
                    html += '<td class="text_align_center" data-original-title="'+list.bulkemail[v].client_count+'" data-toggle="tooltip" class="textEllipsis">'+list.bulkemail[v].client_count+'</td>';
                    html += '<td class="text_align_center" data-original-title="'+list.bulkemail[v].pending_count+'" data-toggle="tooltip" class="textEllipsis">'+list.bulkemail[v].pending_count+'</td>';
                    html += '<td class="text_align_center" data-original-title="'+list.bulkemail[v].success_count+'" data-toggle="tooltip" class="textEllipsis">'+list.bulkemail[v].success_count+'</td>';
                    html += '<td class="text_align_center" data-original-title="'+list.bulkemail[v].failed_count+'" data-toggle="tooltip" class="textEllipsis">'+list.bulkemail[v].failed_count+'</td>';
                    html += '<td class="text_align_center" data-original-title="'+list.bulkemail[v].cancelled_count+'" data-toggle="tooltip" class="textEllipsis">'+list.bulkemail[v].cancelled_count+'</td>';
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
        $("#from_date").val('');
        $("#to_date").val('');
        $("#email_status").val('');
        $('.bootstrap-select').selectpicker("refresh");
        searchFilter();
    });

});
</script>
<?php } ?>