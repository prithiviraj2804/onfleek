<?php if(count($contact_reminder_details) < 1) {  ?>
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
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('reminder/contact_reminder'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('label939'); ?>
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
                    <h3><?php _trans('lable547'); ?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-sm btn-primary" href="<?php echo site_url('reminder/contact_reminder'); ?>"><i class="fa fa-plus"></i> <?php _trans('lable40'); ?></a>
                </div>
            </div>
        </div>
    </div>
</header>
<div id="content" class="table-content">
    <?php $this->layout->load_view('layout/alerts'); ?>
    <section class="card">
        <div class="card-block">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 padding0px">
                    <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
                    <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                        <label class="form_label"><?php _trans('lable175'); ?></label>
                        <div class="form_controls">
                            <input onchange="searchFilter()" type="text" name="reminder_from_date" id="reminder_from_date" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                        <label class="form_label"><?php _trans('lable176'); ?></label>
                        <div class="form_controls">
                            <input onchange="searchFilter()" type="text" name="reminder_to_date" id="reminder_to_date" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                        <label class="form_label"><?php _trans('lable548'); ?></label>
                        <div class="form_controls">
                            <select onchange="searchFilter()" name="refered_by_type" id="refered_by_type" class="searchSelect bootstrap-select bootstrap-select-arrow" data-live-search="true">
                                <option value=""><?php _trans('lable53'); ?></option>
                                <?php foreach ($reference_type as $rtype) { ?>
                                <option value="<?php echo $rtype->refer_type_id; ?>" <?php if($refered_by_type == $rtype->refer_type_id){ echo "selected";} ?> ><?php echo $rtype->refer_name; ?></option>
                                <?php } ?>
                            </select> 
                        </div>
                    </div>
                    <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                        <label class="form_label"><?php _trans('lable19'); ?></label>
                        <div class="form_controls">
                            <select onchange="searchFilter()" name="status" id="status" class="searchSelect bootstrap-select bootstrap-select-arrow" data-live-search="true">
                                <option value=""><?php _trans('lable285'); ?></option>
                                <option <?php if($status == "O"){ echo "selected"; } ?> value="O"><?php _trans('lable531'); ?></option>
                                <option <?php if($status == "P"){ echo "selected"; } ?> value="P"><?php _trans('lable560'); ?></option>
                                <option <?php if($status == "C"){ echo "selected"; } ?> value="C"><?php _trans('lable535'); ?></option>
                            </select> 
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
            <div class="headerbar-item pull-right">
                <?php if(count($contact_reminder_details) > 0 ){ echo pager(site_url('reminder/contact_reminder_index'), 'mdl_contact_reminder'); } ?>
            </div>
            <div id="posts_content">
            <div class="overflowScrollForTable">
                <table class="display table datatable table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php _trans('lable551'); ?></th>
                            <th><?php _trans('lable370'); ?></th>
                            <th class="text_align_center"><?php _trans('lable550'); ?></th>
                            <th><?php _trans('lable19'); ?></th>
                            <th class="text_align_center"><?php _trans('lable22'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(count($contact_reminder_details) > 0 ){
                        $i = 1;
                        foreach ($contact_reminder_details as $contactReminderList) {

                        if(count($contact_reminder_details) >= 4)
                            {    
                            if(count($contact_reminder_details) == $i || count($contact_reminder_details) == $i+1)
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
                        <td data-original-title="<?php _htmlsc($contactReminderList->catName);?>" data-toggle="tooltip" class="textEllipsis">
                                <?php echo $contactReminderList->catName; ?>
                            </td>
                            <td data-original-title="<?php _htmlsc($contactReminderList->typename);?>" data-toggle="tooltip" class="textEllipsis">
                                <a href="<?php echo site_url('reminder/contact_reminder_view/'.$contactReminderList->contact_reminder_id);?>" target="_blank">
                                    <?php echo $contactReminderList->typename; ?>
                                </a>
                            </td>
                            <td class="text_align_center" data-original-title="<?php if($contactReminderList->contact_reminder_next_due_date != "" && $contactReminderList->contact_reminder_next_due_date != "0000-00-00 00:00:00"){echo " ".date("d-m-Y H:i:s", strtotime($contactReminderList->contact_reminder_next_due_date))."";} ?>" data-toggle="tooltip" class="textEllipsis"><?php if($contactReminderList->contact_reminder_next_due_date != "" && $contactReminderList->contact_reminder_next_due_date != "0000-00-00 00:00:00"){echo " ".date("d-m-Y H:i:s", strtotime($contactReminderList->contact_reminder_next_due_date))."";} ?></td>
                                   
                            <td data-original-title="<?php _htmlsc($contactReminderList->StatusName);?>" data-toggle="tooltip" class="textEllipsis">
                                <?php echo $contactReminderList->StatusName; ?>
                                </td>
                            <td class="text_align_center">
                                <div class="options btn-group <?php echo $dropup; ?>">
                                    <a class="btn btn-default btn-sm dropdown-toggle"
                                    data-toggle="dropdown" href="#">
                                        <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                    </a>
                                    <ul class="optionTag dropdown-menu">
                                        <li>
                                            <a href="<?php echo site_url('reminder/contact_reminder/'.$contactReminderList->contact_reminder_id); ?>">
                                                <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#addNewCar" data-module="contact" data-reminder-id="<?php echo $contactReminderList->contact_reminder_id; ?>" class="add_reminder">
                                                <i class="fa fa-edit fa-margin"></i><?php _trans('lable549'); ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url('reminder/contact_reminder_view/'.$contactReminderList->contact_reminder_id); ?>">
                                                <i class="fa fa-edit fa-margin"></i> <?php _trans('lable365'); ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" onclick="delete_record('contact_reminder',<?php echo $contactReminderList->contact_reminder_id ?>,'<?= $this->security->get_csrf_hash(); ?>');">
                                                <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
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

<!-- <?php //print_r($contact_reminder_details);?> -->
<!-- <?php //print_r($contact_reminder_details->refer_name);?> -->
<script>

function searchFilter(page_num) {
    page_num = page_num?page_num:0;
    var reminder_from_date = $('#reminder_from_date').val()?$('#reminder_from_date').val():'';
    var reminder_to_date = $('#reminder_to_date').val()?$('#reminder_to_date').val():'';
    var refered_by_type = $('#refered_by_type').val()?$('#refered_by_type').val():'';
    var status = $('#status').val()?$('#status').val():'';
    
    $.post('<?php echo site_url('reminder/ajax/get_filter_list'); ?>', {
        page : page_num,
        reminder_from_date : reminder_from_date,
        reminder_to_date   : reminder_to_date,
        refered_by_type : refered_by_type,
        status : status,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            var html = '';
            html += '<div class="overflowScrollForTable">';
            html += '<table class="display table datatable table-bordered" cellspacing="0" width="100%">';
            html += '<thead><tr><th><?php _trans("lable551"); ?></th>';
            html += '<th><?php _trans("lable370"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable550"); ?></th>';
            html += '<th><?php _trans("lable19"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable22"); ?></th>';
            html += '</tr></thead><tbody>';
            if(list.contact_reminder_details.length > 0){
                for(var v=0; v < list.contact_reminder_details.length; v++){ 
                if(list.contact_reminder_details.length >= 4)
                {     
                    if(list.contact_reminder_details.length == v || list.contact_reminder_details.length == v+1)
                    {
                        var dropup = "dropup";
                    }
                    else
                    {
                        var dropup = "";
                    }
                }
        
                    html += '<td data-original-title="'+list.contact_reminder_details[v].catName+'" data-toggle="tooltip" class="textEllipsis">'+list.contact_reminder_details[v].catName+'</td>';  
                    html += '<td data-original-title="'+list.contact_reminder_details[v].typename+'" data-toggle="tooltip" class="textEllipsis"><a href="<?php echo site_url("reminder/contact_reminder_view/'+list.contact_reminder_details[v].contact_reminder_id+'"); ?>">'+list.contact_reminder_details[v].typename+'</a></td>';
                    html += '<td class="text_align_center" data-original-title="'+(list.contact_reminder_details[v].contact_reminder_next_due_date?formatDatetimechange(list.contact_reminder_details[v].contact_reminder_next_due_date):"")+'" class="text_align_center" data-toggle="tooltip" class="textEllipsis">'+(list.contact_reminder_details[v].contact_reminder_next_due_date?formatDatetimechange(list.contact_reminder_details[v].contact_reminder_next_due_date):"")+'</td>';  
                    html += '<td data-original-title="'+list.contact_reminder_details[v].StatusName+'" data-toggle="tooltip" class="textEllipsis">'+list.contact_reminder_details[v].StatusName+'</td>';  
                    html += '<td class="text_align_center">';
                    html += '<div class="options btn-group '+dropup+'">';
                    html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">';
                    html += '<i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
                    html += '<ul class="optionTag dropdown-menu"><li>';
                    html += '<a href="<?php echo site_url("reminder/contact_reminder/'+list.contact_reminder_details[v].contact_reminder_id+'"); ?>">';
                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable44"); ?></a></li>';
                    html += '<li><a href="javascript:void(0)" class="add_reminder" data-toggle="modal" data-target="#addNewCar" data-module="custom" data-reminder-id='+list.contact_reminder_details[v].contact_reminder_id+'>';
                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable549"); ?></a></li>'
                    html += '<a href="<?php echo site_url("reminder/contact_reminder_view/'+list.contact_reminder_details[v].contact_reminder_id+'"); ?>">';
                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable365"); ?></a></li>';
                    html += '<li><a href="javascript:void(0)" onclick="delete_record(\'contact_reminder\',\''+list.contact_reminder_details[v].contact_reminder_id+'\',\'<?= $this->security->get_csrf_hash() ?>\')">';
                    html += '<i class="fa fa-trash-o fa-margin"></i> <?php _trans("lable47"); ?></a></li>';
                    html += '</li></ul></div></td></tr>';
                } 
            }else{ 
                html += '<tr><td colspan="5" class="text-center" > No data found </td></tr>';
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


$(document).ready(function() {
    $("[data-toggle='tooltip']").tooltip();


    $('#reminder_from_date').datetimepicker({
        format: 'DD-MM-YYYY HH:mm:ss',
    });

    $('#reminder_to_date').datetimepicker({
        format: 'DD-MM-YYYY HH:mm:ss',
    });

    // $('#reminder_from_date').on('change', function() {
    //     searchFilter());
    // });

    // $('#reminder_to_date').onchange({
    //     searchFilter();
    // });


    $("#reset_filter").click(function () {
        $("#reminder_from_date").val('');
        $("#reminder_to_date").val('');
        $("#refered_by_type").val('');
        $("#status").val('');
        $('.bootstrap-select').selectpicker("refresh");
        searchFilter();
    });
});

</script>
<?php } ?>