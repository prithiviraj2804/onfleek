<?php if(count($custom_reminder_details) < 1) {  ?>
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
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('reminder/custom_reminder'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('label940'); ?>
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
                    <h3><?php _trans('lable561'); ?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-sm btn-primary" href="<?php echo site_url('reminder/custom_reminder'); ?>"><i class="fa fa-plus"></i> <?php _trans('lable40'); ?></a>
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
                            <input onchange="searchFilter()" type="text" name="reminder_from_date" id="reminder_from_date" class="form-control datepicker" autocomplete="off">
                        </div>
                    </div>
                    <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                        <label class="form_label"><?php _trans('lable176'); ?></label>
                        <div class="form_controls">
                            <input onchange="searchFilter()" type="text" name="reminder_to_date" id="reminder_to_date" class="form-control datepicker" autocomplete="off">
                        </div>
                    </div>
                    <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                        <label class="form_label"><?php _trans('lable574'); ?></label>
                        <div class="form_controls">
                            <select onchange="searchFilter()" name="customer_id" id="customer_id" class="searchSelect bootstrap-select bootstrap-select-arrow removeError" data-live-search="true" autocomplete="off">
                                <option value=""><?php _trans('lable272'); ?></option>
                                <?php foreach ($customer_list as $customer){ ?>
                                <option value="<?php echo $customer->client_id; ?>" <?php if($customer_id == $customer->client_id){ echo "selected"; } ?>><?php echo ($customer->client_name?$customer->client_name:"").' '.($customer->client_contact_no?"(".$customer->client_contact_no.")":""); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                        <label class="form_label"><?php _trans('lable292'); ?></label>
                        <div class="form_controls">
                            <select onchange="searchFilter()" name="employee_id" id="employee_id" class="searchSelect bootstrap-select bootstrap-select-arrow removeError" data-live-search="true" autocomplete="off">
                                <option value=""><?php _trans('lable457'); ?></option>
                                <?php foreach ($employee_list as $employeeList) {
                                    if ($employee_id == $employeeList->employee_id) {
                                        $selected = 'selected="selected"';
                                    } else {
                                        $selected = '';
                                } ?>
                                <option value="<?php echo $employeeList->employee_id; ?>" <?php echo $selected; ?>><?php echo $employeeList->employee_name; ?></option>
                            <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                        <label class="form_label"></label>
                        <div class="form_controls paddingTop18px">
                            <span><button name="btn_submit" type="submit" class="btn_submit btn btn-primary"><?php _trans('lable39'); ?></button></span>
                            <span><span id="reset_filter" class="btn"><?php _trans('lable827'); ?></span></span>
                        </div>
                    </div>
                </div>
            <div class="headerbar-item pull-right">
                <?php if(count($custom_reminder_details) > 0 ){ echo pager(site_url('reminder/custom_reminder_index'), 'mdl_custom_reminder'); } ?>
            </div>
            <div id="posts_content">
            <div class="overflowScrollForTable">
                <table class="display table datatable table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php _trans('lable565'); ?></th>
                            <th><?php _trans('lable62'); ?></th>
                            <th class="text_align_center"><?php _trans('lable566'); ?></th>
                            <th class="text_align_center"><?php _trans('lable22'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(count($custom_reminder_details) > 0 ){
                        $i = 1;
                        foreach ($custom_reminder_details as $customReminderList) {
                        if(count($custom_reminder_details) >= 4)
                        {
                            if(count($custom_reminder_details) == $i || count($custom_reminder_details) == $i+1)
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
                            <td data-original-title="<?php _htmlsc($this->mdl_clients->get_customer_name($customReminderList->customer_id));?>" data-toggle="tooltip" class="textEllipsis"><a href="<?php echo site_url('reminder/custom_reminder_view/'.$customReminderList->custom_reminder_id);?>" target="_blank" ><?php echo $this->mdl_clients->get_customer_name($customReminderList->customer_id); ?></a></td>
                            <td data-original-title="<?php _htmlsc($this->mdl_user_cars->getVehicleDetails($customReminderList->customer_car_id));?>" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_user_cars->getVehicleDetails($customReminderList->customer_car_id); ?></td>
                            <td class="text_align_center" data-original-title="<?php _htmlsc($customReminderList->next_update?date_from_mysql($customReminderList->next_update):'-');?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($customReminderList->next_update?date_from_mysql($customReminderList->next_update):'-'); ?></td>
                            <td class="text_align_center">
                                <div class="options btn-group <?php echo $dropup; ?>">
                                    <a class="btn btn-default btn-sm dropdown-toggle"
                                    data-toggle="dropdown" href="#">
                                        <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                    </a>
                                    <ul class="optionTag dropdown-menu">
                                        <li>
                                            <a href="<?php echo site_url('reminder/custom_reminder/'.$customReminderList->custom_reminder_id); ?>">
                                                <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo site_url('reminder/custom_reminder_view/'.$customReminderList->custom_reminder_id); ?>">
                                                <i class="fa fa-edit fa-margin"></i> <?php _trans('lable365'); ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#addNewCar" data-module="custom" data-reminder-id="<?php echo $customReminderList->custom_reminder_id; ?>" class="add_reminder">
                                                <i class="fa fa-edit fa-margin"></i> <?php _trans('lable549'); ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" onclick="delete_record('custom_reminder',<?php echo $customReminderList->custom_reminder_id ?>,'<?= $this->security->get_csrf_hash(); ?>');">
                                                <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php $i++; } } else { echo '<tr><td colspan="6" class="text-center" > No data found </td></tr>'; } ?>
                    </tbody>
                </table>
            </div>
            <div class="headerbar-item pull-right">
                    <?php echo $createLinks;?>
                </div>
		</div>
	</section>
</div>
<script>

function searchFilter(page_num) {
    page_num = page_num?page_num:0;
    var reminder_from_date = $('#reminder_from_date').val()?$('#reminder_from_date').val():'';
    var reminder_to_date = $('#reminder_to_date').val()?$('#reminder_to_date').val():'';
    var customer_id = $('#customer_id').val()?$('#customer_id').val():'';
    var employee_id = $('#employee_id').val()?$('#employee_id').val():'';
    
    $.post('<?php echo site_url('reminder/ajax/get_filter_customlist'); ?>', {
        page : page_num,
        reminder_from_date : reminder_from_date,
        reminder_to_date   : reminder_to_date,
        customer_id : customer_id,
        employee_id : employee_id,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {      
        list = JSON.parse(data);
        if(list.success=='1'){
            var html = '';
            html += '<div class="overflowScrollForTable">';
            html += '<table class="display table datatable table-bordered" cellspacing="0" width="100%">';
            html += '<thead><th style="background: #f6f8fa;"><?php _trans("lable565"); ?></th>';
            html += '<th style="background: #f6f8fa;"><?php _trans("lable62"); ?></th>';
            html += '<th style="background: #f6f8fa;" class="text_align_center"><?php _trans("lable566"); ?></th>';
            html += '<th style="background: #f6f8fa;" class="text_align_center"><?php _trans("lable22"); ?></th>';
            html += '</tr></thead><tbody>';
            if(list.custom_reminder_details.length > 0){
                for(var v=0; v < list.custom_reminder_details.length; v++){ 
                if(list.custom_reminder_details.length >= 4)
                {    
                    if(list.custom_reminder_details.length == v || list.custom_reminder_details.length == v+1)
                    {
                        var dropup = "dropup";
                    }
                    else
                    {
                        var dropup = "";
                    }
                }   
                    html += '<td data-original-title="'+list.custom_reminder_details[v].typename+'" data-toggle="tooltip" class="textEllipsis"><a href="<?php echo site_url("reminder/custom_reminder_view/'+list.custom_reminder_details[v].custom_reminder_id+'"); ?>">'+list.custom_reminder_details[v].typename+'</a></td>';
                    html += '<td data-original-title="'+((list.custom_reminder_details[v].vehicletype)?list.custom_reminder_details[v].vehicletype:"")+'" data-toggle="tooltip" class="textEllipsis">'+((list.custom_reminder_details[v].vehicletype)?list.custom_reminder_details[v].vehicletype:"")+'</td>';  
                    html += '<td data-original-title="'+(list.custom_reminder_details[v].next_update?formatDate(list.custom_reminder_details[v].next_update):" ")+'" class="text_align_center" data-toggle="tooltip" class="textEllipsis">'+(list.custom_reminder_details[v].next_update?formatDate(list.custom_reminder_details[v].next_update):" ")+'</td>';  
                    html += '<td class="text_align_center">';
                    html += '<div class="options btn-group '+dropup+'">';
                    html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">';
                    html += '<i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
                    html += '<ul class="optionTag dropdown-menu"><li>';
                    html += '<a href="<?php echo site_url("reminder/custom_reminder/'+list.custom_reminder_details[v].custom_reminder_id+'"); ?>">';
                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable44"); ?></a></li>';
                    html += '<a href="<?php echo site_url("reminder/custom_reminder_view/'+list.custom_reminder_details[v].custom_reminder_id+'"); ?>">';
                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable365"); ?></a></li>';
                    html += '<li><a href="javascript:void(0)" class="add_reminder" data-toggle="modal" data-target="#addNewCar" data-module="custom" data-reminder-id='+list.custom_reminder_details[v].custom_reminder_id+'>';
                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable549"); ?></a></li>';                            
                    html += '<li><a href="javascript:void(0)" onclick="delete_record(\'custom_reminder\',\''+list.custom_reminder_details[v].custom_reminder_id+'\',\'<?= $this->security->get_csrf_hash() ?>\')">';
                    html += '<i class="fa fa-trash-o fa-margin"></i> <?php _trans("lable47"); ?></a></li>';
                    html += '</li></ul></div></td></tr>';
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


$(document).ready(function() {
    $("[data-toggle='tooltip']").tooltip();

    $("#reset_filter").click(function () {
        $("#reminder_from_date").val('');
        $("#reminder_to_date").val('');
        $("#type_id").val('');
        $("#customer_id").val('');
        $("#employee_id").val('');
        $('.bootstrap-select').selectpicker("refresh");
        searchFilter();

    });
});
</script>
<?php } ?>