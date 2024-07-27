<?php if(count($mech_lead_status) < 1) {  ?>
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
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_appointments/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('label930'); ?>
            </a>
        </div>
    </div>
</div>
<?php } else { ?>
    <div id="search">
    <header class="page-content-header">
        <div class="container-fluid">
            <div class="tbl">
                <div class="tbl-row">
                    <div class="tbl-cell">
                        <h3><?php _trans('menu10'); ?></h3>
                    </div>
                    <div class="tbl-cell pull-right">
                        <a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_appointments/form'); ?>">
                            <i class="fa fa-plus"> </i> <?php _trans('lable40'); ?>
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
                        <label class="form_label"><?php _trans('lable488'); ?></label>
                        <div class="form_controls">
                            <input onkeyup="searchFilter()" type="text" name="leads_no" id="leads_no" class="form-control" autocomplete="off">
                        </div>
                    </div>

                    <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                        <label class="form_label"><?php _trans('lable36'); ?></label>
                        <div class="form_controls">
                            <input onkeyup="searchFilter()" type="text" name="client_name" id="client_name" class="form-control" autocomplete="off">
                        </div>
                    </div>

                    <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                        <label class="form_label"><?php _trans('lable42'); ?>.</label>
                        <div class="form_controls">
                            <input onkeyup="searchFilter()" type="text" name="client_contact_no" id="client_contact_no" class="form-control" autocomplete="off">
                        </div>
                    </div>

                    <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                        <label class="form_label"><?php _trans('lable38'); ?></label>
                        <div class="form_controls">
                            <input onkeyup="searchFilter()" type="text" name="client_email_id" id="client_email_id" class="form-control" autocomplete="off">
                        </div>
                    </div>

                    <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                        <label class="form_label"><?php _trans('lable529'); ?></label>
                        <div class="form_controls">
                            <select onchange="searchFilter()" name="lead_source" id="lead_source" class="searchSelect bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true">
                                <?php if(count($mech_lead_source)>0){ ?>
                                    <option value=""><?php _trans('lable500'); ?></option>
                                <?php } ?>
                                <?php foreach ($mech_lead_source as $mechLeadSourceList) {?>
                                <option value="<?php echo $mechLeadSourceList->mls_id; ?>"> <?php echo $mechLeadSourceList->lead_source_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                        <label class="form_label"><?php _trans('lable530'); ?></label>
                        <div class="form_controls">
                            <select onchange="searchFilter()" name="lead_status" id="lead_status" class="searchSelect bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true">
                                <?php if(count($mech_lead_status_list)>0){ ?>
                                    <option value=""><?php _trans('lable285'); ?></option>
                                <?php } ?>
                                <?php foreach ($mech_lead_status_list as $mechLeadStatus) {?>
                                <option value="<?php echo $mechLeadStatus->mps_id; ?>"> <?php echo $mechLeadStatus->status_label; ?></option>
                                <?php } ?>
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
                                    <th><?php _trans('lable527');?></th>
                                    <th><?php _trans('lable528'); ?></th>
                                    <th><?php _trans('lable36'); ?></th>
                                    <th><?php _trans('lable672'); ?></th>
                                    <th><?php _trans('lable38'); ?></th>
                                    <th><?php _trans('lable529');?></th>
                                    <th><?php _trans('lable530');?></th>
                                    <th class="text_align_center"><?php _trans('lable22'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($mech_lead_status) > 0) { 
                                    $i = 1;
                                    foreach ($mech_lead_status as $leads_ind) { 
                                    if(count($mech_lead_status) >= 4)
                                    {    
                                        if(count($mech_lead_status) == $i || count($mech_lead_status) == $i+1)
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
                                    <td class="text_align_left" data-original-title="<?php if($leads_ind->reschedule_date != "" && $leads_ind->reschedule_date != "0000-00-00 00:00:00"){echo " ".date("d-m-Y H:i:s", strtotime($leads_ind->reschedule_date))."";} ?>" data-toggle="tooltip" class="textEllipsis"><?php if($leads_ind->reschedule_date != "" && $leads_ind->reschedule_date != "0000-00-00 00:00:00"){echo " ".date("d-m-Y H:i:s", strtotime($leads_ind->reschedule_date))."";} ?></td>
                                    <td class="textEllipsis"><a data-original-title="<?php _htmlsc($leads_ind->leads_no); ?>" data-toggle="tooltip" href="<?php echo site_url('mech_appointments/view/' . $leads_ind->ml_id ); ?>"><?php _htmlsc($leads_ind->leads_no); ?></a></td>
                                    <td data-original-title="<?php _htmlsc($leads_ind->client_name); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($leads_ind->client_name); ?></td>
                                    <td data-original-title="<?php _htmlsc($leads_ind->client_contact_no); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($leads_ind->client_contact_no); ?></td>
                                    <td data-original-title="<?php _htmlsc($leads_ind->client_email_id); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($leads_ind->client_email_id); ?></td>
                                    <td data-original-title="<?php _htmlsc($leads_ind->lead_source_name); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($leads_ind->lead_source_name); ?></td>
                                    <td data-original-title="<?php _htmlsc($leads_ind->status_label); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($leads_ind->status_label); ?></td>
                                    <td class="text_align_center">
                                        <div class="options btn-group <?php echo $dropup; ?>">
                                            <a class="btn btn-default btn-sm dropdown-toggle"
                                            data-toggle="dropdown" href="#" >
                                                <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                            </a>
                                            <ul class="optionTag dropdown-menu">
                                                <li>
                                                    <a href="<?php echo site_url('mech_appointments/form/' . $leads_ind->ml_id); ?>">
                                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                                    </a>
                                                </li>

                                                    <?php if($this->session->userdata('workshop_is_enabled_jobsheet') == 'Y'){
                                                        foreach($permission as $perlist){
                                                        if($perlist->module_name == "jobs"){ ?>
                                                        <?php if(($leads_ind->lead_status == 6 || $leads_ind->lead_status == 7 || $leads_ind->lead_status == 8 ) && $leads_ind->work_order_id != '') { ?>
                                                            <li>
                                                                <a href="<?php echo site_url('mech_work_order_dtls/view/' . $leads_ind->work_order_id); ?>">
                                                                    <i class="fa fa-eye fa-margin"></i> <?php _trans('lable1221'); ?>
                                                                </a>
                                                            </li>
                                                        <?php } else if($leads_ind->lead_status != 6 && $leads_ind->lead_status != 7 && $leads_ind->lead_status != 8) { ?>

                                                            <li>
                                                                <a href="<?php echo site_url('mech_appointments/convert_to_jobcard/' . $leads_ind->ml_id); ?>">
                                                                <i class="fa fa-edit fa-margin"></i> <?php _trans('lable491'); ?>
                                                                </a>
                                                            </li>
                                                        <?php }}}} foreach($permission as $perlist){

                                                            if($perlist->module_name == "invoice"){ ?>
                                                        <?php if(($leads_ind->lead_status == 6 || $leads_ind->lead_status == 7)) { ?>

                                                            <?php if($leads_ind->invoice_id != '') { ?>
                                                                <li>
                                                                    <a href="<?php echo site_url('mech_invoices/view/' . $leads_ind->invoice_id); ?>">
                                                                        <i class="fa fa-eye fa-margin"></i> <?php _trans('lable1222'); ?>
                                                                    </a>
                                                                </li>
                                                            <?php } else if($leads_ind->jobcard_invoice_id != ''){ ?>
                                                                <li>
                                                                    <a href="<?php echo site_url('mech_invoices/view/' . $leads_ind->jobcard_invoice_id); ?>">
                                                                        <i class="fa fa-eye fa-margin"></i> <?php _trans('lable1222'); ?>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                        <?php } else if($leads_ind->lead_status != 6 && $leads_ind->lead_status != 7 && $leads_ind->lead_status != 8) { ?>
                                                                <li>
                                                                    <a href="<?php echo site_url('mech_appointments/convert_to_invoice/' . $leads_ind->ml_id); ?>">
                                                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('lable490'); ?>
                                                                    </a>
                                                                </li>
                                                        <?php }}} ?>
                                                
                                                <li>
                                                    <a href="javascript:void(0)" onclick="delete_record('mech_appointments',<?php echo $leads_ind->ml_id; ?>, '<?= $this->security->get_csrf_hash() ?>')"> <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <?php $i++; } } else { echo '<tr><td colspan="8" class="text-center" > No data found </td></tr>'; } ?>
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
</div>
<script type="text/javascript">
function searchFilter(page_num) {
    page_num = page_num?page_num:0;

    var from_date = $('#from_date').val()?$('#from_date').val():'';
    var to_date = $('#to_date').val()?$('#to_date').val():'';
    var leads_no = $("#leads_no").val()?$("#leads_no").val():'';
    var client_name = $('#client_name').val()?$('#client_name').val():'';
    var client_contact_no = $('#client_contact_no').val()?$('#client_contact_no').val():'';
    var client_email_id = $('#client_email_id').val()?$('#client_email_id').val():'';
    var lead_source = $("#lead_source").val()?$("#lead_source").val():'';
    var lead_status = $('#lead_status').val()?$('#lead_status').val():'';

    $.post('<?php echo site_url('mech_appointments/ajax/get_filter_list'); ?>', {
        page : page_num,
        from_date : from_date,
        to_date   : to_date,
        leads_no : leads_no,
        client_name : client_name,
        client_contact_no : client_contact_no,
        client_email_id : client_email_id,
        lead_source : lead_source,
        lead_status : lead_status,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            var html = '';
            html += '<div class="overflowScrollForTable">';
            html += '<table class="display table datatable table-bordered" cellspacing="0" width="100%">';
            html += '<thead><tr>';
            html += '<th><?php _trans('lable527'); ?></th>';
            html += '<th><?php _trans('lable528'); ?></th>';
            html += '<th><?php _trans("lable36"); ?></th>';
            html += '<th><?php _trans("lable672");?></th>';
            html += '<th><?php _trans("lable38"); ?></th>';
            html += '<th><?php _trans("lable529"); ?></th>';
            html += '<th><?php _trans("lable530"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable22"); ?></th>';
            html += '</tr></thead><tbody>';
            if(list.mech_lead_status.length > 0){
                for(var v=0; v < list.mech_lead_status.length; v++){ 
                if(list.mech_lead_status.length >= 4)
                {
                    if(list.mech_lead_status.length == v || list.mech_lead_status.length == v+1)
                    {
                        var dropup = "dropup";
                    }
                    else
                    {
                        var dropup = "";
                    }
                }
                    html += '<tr>';
                    html += '<td class="text_align_left" data-original-title="'+(list.mech_lead_status[v].reschedule_date?formatDatetimechange(list.mech_lead_status[v].reschedule_date):"")+'" class="text_align_left" data-toggle="tooltip" class="textEllipsis">'+(list.mech_lead_status[v].reschedule_date?formatDatetimechange(list.mech_lead_status[v].reschedule_date):"")+'</td>';  
                    html += '<td class="textEllipsis"><a data-original-title="'+((list.mech_lead_status[v].leads_no)?list.mech_lead_status[v].leads_no:" ")+'" data-toggle="tooltip"  href="<?php echo site_url("mech_appointments/view/'+list.mech_lead_status[v].ml_id+'"); ?>">'+((list.mech_lead_status[v].leads_no)?list.mech_lead_status[v].leads_no:" ")+'</a></td>';
                    html += '<td class="textEllipsis" data-original-title="'+((list.mech_lead_status[v].client_name)?list.mech_lead_status[v].client_name:" ")+'" data-toggle="tooltip">'+((list.mech_lead_status[v].client_name)?list.mech_lead_status[v].client_name:" ")+'</td>';
                    html += '<td class="textEllipsis" data-original-title="'+((list.mech_lead_status[v].client_contact_no)?list.mech_lead_status[v].client_contact_no:" ")+'" data-toggle="tooltip">'+((list.mech_lead_status[v].client_contact_no)?list.mech_lead_status[v].client_contact_no:" ")+'</td>';
                    html += '<td class="textEllipsis" data-original-title="'+((list.mech_lead_status[v].client_email_id)?list.mech_lead_status[v].client_email_id:" ")+'" data-toggle="tooltip">'+((list.mech_lead_status[v].client_email_id)?list.mech_lead_status[v].client_email_id:" ")+'</td>';
                    html += '<td class="textEllipsis" data-original-title="'+((list.mech_lead_status[v].lead_source_name)?list.mech_lead_status[v].lead_source_name:" ")+'" data-toggle="tooltip">'+((list.mech_lead_status[v].lead_source_name)?list.mech_lead_status[v].lead_source_name:" ")+'</td>';
                    html += '<td class="textEllipsis" data-original-title="'+((list.mech_lead_status[v].status_label)?list.mech_lead_status[v].status_label:" ")+'" data-toggle="tooltip">'+((list.mech_lead_status[v].status_label)?list.mech_lead_status[v].status_label:" ")+'</td>';

                    html += '<td class="text_align_center">';
                    html += '<div class="options btn-group '+dropup+'">';
                    html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">';
                    html += '<i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
                    html += '<ul class="optionTag dropdown-menu">';
                    html += '<li><a href="<?php echo site_url("mech_appointments/form/'+list.mech_lead_status[v].ml_id+'"); ?>">';
                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable44"); ?></a></li>';

                    var workshop_is_enabled_jobsheet = '<?php echo $this->session->userdata('workshop_is_enabled_jobsheet'); ?>';

                    if(workshop_is_enabled_jobsheet == 'Y'){
                        for(var n = 0; n < list.permission.length; n++){
    
                            if(list.permission[n].module_name == "jobs"){
                                if((list.mech_lead_status[v].lead_status == 6 || list.mech_lead_status[v].lead_status == 7 || list.mech_lead_status[v].lead_status == 8 ) && list.mech_lead_status[v].lead_status != ''){
                                    html += '<li><a href="<?php echo site_url("mech_work_order_dtls/view/'+list.mech_lead_status[v].work_order_id+'"); ?>">';
                                    html += '<i class="fa fa-eye fa-margin"></i> <?php _trans("lable1221"); ?></a></li>';
                                }else if(list.mech_lead_status[v].lead_status != 6 && list.mech_lead_status[v].lead_status != 7 && list.mech_lead_status[v].lead_status != 8){
                                    html += '<li><a href="<?php echo site_url("mech_appointments/convert_to_jobcard/'+list.mech_lead_status[v].ml_id+'"); ?>">';
                                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable491"); ?></a></li>';
                                }
                            }

                        }
                    }    

                        for(var k = 0; k < list.permission.length; k++){
                            if(list.permission[k].module_name == "invoice"){

                                if(list.mech_lead_status[v].lead_status == 6 || list.mech_lead_status[v].lead_status == 7){

                                    if(list.mech_lead_status[v].invoice_id != ''){
                                        html += '<li><a href="<?php echo site_url("mech_invoices/view/'+list.mech_lead_status[v].invoice_id+'"); ?>">';
                                        html += '<i class="fa fa-eye fa-margin"></i> <?php _trans("lable1222"); ?></a></li>';
                                    }else if(list.mech_lead_status[v].jobcard_invoice_id != ''){
                                        html += '<li><a href="<?php echo site_url("mech_invoices/view/'+list.mech_lead_status[v].jobcard_invoice_id+'"); ?>">';
                                        html += '<i class="fa fa-eye fa-margin"></i> <?php _trans("lable1222"); ?></a></li>';
                                    }

                                }else if(list.mech_lead_status[v].lead_status != 6 && list.mech_lead_status[v].lead_status != 7 && list.mech_lead_status[v].lead_status != 8){
                                    html += '<li><a href="<?php echo site_url("mech_appointments/convert_to_invoice/'+list.mech_lead_status[v].ml_id+'"); ?>">';
                                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable490"); ?></a></li>';

                                }

                            }
                        }

                    html += '<li><a href="javascript:void(0)" onclick="delete_record(\'mech_appointments\',\''+list.mech_lead_status[v].ml_id+'\',\'<?= $this->security->get_csrf_hash() ?>\')">';
                    html += '<i class="fa fa-trash-o fa-margin"></i> <?php _trans("lable47"); ?></a></li>';
                    html += '</ul></div></td></tr>';
                } 
            }else{ 
                html += '<tr><td colspan="8" class="text-center" > No data found </td></tr>';
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
        $("#leads_no").val('');
        $("#client_name").val('');
        $("#client_contact_no").val('');
        $("#client_email_id").val('');
        $("#lead_source").val('');
        $("#lead_status").val('');
        $('.bootstrap-select').selectpicker("refresh");
        searchFilter();
    });

});
</script>
<?php } ?>
