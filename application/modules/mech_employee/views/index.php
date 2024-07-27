<?php if(count($employees) < 1) {  ?>
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
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_employee/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('label923'); ?>
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
                    <h3><?php _trans('menu4'); ?></h3>
                </div>
				<div class="tbl-cell pull-right">
					<a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_employee/form'); ?>">
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
                    <label class="form_label"><?php _trans('lable95'); ?></label>
                    <select onchange="searchFilter()" id="branch_id" name="branch_id" class=" searchSelect bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                        <?php if(count($branch_list)>0){ ?>
                            <option value=""><?php _trans('lable51'); ?></option>
                        <?php } ?>
                        <?php foreach ($branch_list as $branchList) {?>
                        <option value="<?php echo $branchList->w_branch_id; ?>" > <?php echo $branchList->display_board_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable134'); ?></label>
                    <div class="form_controls">
                        <input onkeyup="searchFilter()" type="text" name="employee_name" id="employee_name" class="form-control" autocomplete="off">
                    </div>
                </div>
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable1212'); ?></label>
                    <div class="form_controls">
                        <input onkeyup="searchFilter()" type="text" name="employee_no" id="employee_no" class="form-control" autocomplete="off">
                    </div>
                </div>
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable148'); ?></label>
                    <div class="form_controls">
                        <input onkeyup="searchFilter()" type="text" name="employee_number" id="employee_number" class="form-control" autocomplete="off">
                    </div>
                </div>
                
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable135'); ?></label>
                    <div class="form_controls">
                        <select onchange="searchFilter()" name="employee_role" id="employee_role" class="searchSelect bootstrap-select bootstrap-select-arrow form-control removeError" autocomplete="off" data-live-search="true">
                            <option value=""><?php _trans('lable150'); ?></option>
                            <?php if ($employees_roles):
                            foreach ($employees_roles as $key => $role):?>
                            <option value="<?php echo $role->role_id; ?>" ><?php echo $role->role_name; ?></option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>
                </div>
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4 paddingTop20px">
                    <div class="form_controls paddingTop10px">
                        <span><button onclick="searchFilter()" class="btn_submit btn btn-primary"><?php _trans('lable39'); ?></button></span>
                        <span><span id="reset_filter" class="btn"><?php _trans('lable827'); ?></span></span>
                    </div>
                </div>
            </div>
            <div id="posts_content">
                <div class="overflowScrollForTable">
                    <table class="display table datatable table-bordered tbl-typical" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                            <th><?php _trans('lable95'); ?></th>
                                <th><?php _trans("lable1212"); ?></th>
                                <th><?php _trans('lable134'); ?></th>
                                <th><?php _trans("lable148"); ?></th>
                                <th><?php _trans('lable135'); ?></th>
                                <th class="text_align_right"><?php _trans('lable43'); ?></th>
                                <th class="text_align_center"><?php _trans('lable184'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($employees) > 0 ){
                                $i = 1;
                                foreach ($employees as $employee) {
                                if(count($employees) >= 4)
                                {     
                                    if(count($employees) == $i || count($employees) == $i+1)
                                    {
                                        $dropup = "dropup";
                                    }
                                    else{
                                        $dropup = "";
                                    }
                                }    
                                ?>
                            <tr>
                                <td data-original-title="<?php _htmlsc($employee->display_board_name?$employee->display_board_name:""); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($employee->display_board_name?$employee->display_board_name:""); ?></td>
                                <td class="textEllipsis"><a data-original-title="<?php _htmlsc($employee->employee_no?$employee->employee_no:""); ?>" data-toggle="tooltip" href="<?php echo site_url('mech_employee/form/' . $employee->employee_id); ?>"><?php _htmlsc($employee->employee_no?$employee->employee_no:""); ?></a></td>
                                <td data-original-title="<?php _htmlsc($employee->employee_name?$employee->employee_name:""); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($employee->employee_name?$employee->employee_name:""); ?></td>
                                <td data-original-title="<?php _htmlsc($employee->employee_number?$employee->employee_number:""); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($employee->employee_number?$employee->employee_number:""); ?></td>
                                <td data-original-title="<?php _htmlsc($employee->role_name?$employee->role_name:""); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($employee->role_name?$employee->role_name:""); ?></td>
                                <td class="text_align_right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($employee->total_rewards_point,$this->session->userdata('default_currency_digit')); ?>" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($employee->total_rewards_point,$this->session->userdata('default_currency_digit')); ?></td>
                                <td class="text_align_center">
                                    <div class="options btn-group <?php echo $dropup; ?>">
                                        <a class="btn btn-default btn-sm dropdown-toggle"
                                        data-toggle="dropdown" href="#">
                                            <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                        </a>
                                        <ul class="optionTag dropdown-menu">
                                            <li>
                                                <a href="<?php echo site_url('mech_employee/form/' . $employee->employee_id); ?>">
                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a target="_blank" href="<?php echo site_url('mech_employee/generate_pdf/'.$employee->employee_id);?>">
                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable141'); ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)"
                                                onclick="employee_delete_record('mech_employee',<?php echo $employee->employee_id ?>,'<?= $this->security->get_csrf_hash(); ?>');">
                                                    <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php $i++; } } else { echo '<tr><td colspan="7" class="text-center" > No data found </td></tr>'; } ?>
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
    var branch_id = $("#branch_id").val()?$("#branch_id").val():'';
    var employee_no = $('#employee_no').val()?$('#employee_no').val():'';
    var employee_name = $('#employee_name').val()?$('#employee_name').val():'';
    var employee_number = $('#employee_number').val()?$('#employee_number').val():'';
    var employee_role = $('#employee_role').val()?$('#employee_role').val():'';
    $.post('<?php echo site_url('mech_employee/ajax/get_filter_list'); ?>', {
        page : page_num,
        branch_id : branch_id,
        employee_no : employee_no,
        employee_name : employee_name,
        employee_number : employee_number,
        employee_role : employee_role,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            var html = '';
            html += '<div class="overflowScrollForTable">';
            html += '<table class="display table datatable table-bordered" cellspacing="0" width="100%">';
            html += '<thead><tr>';
            html += '<th><?php _trans("lable95"); ?></th>';
            html += '<th><?php _trans("lable1212"); ?></th>';
            html += '<th><?php _trans("lable134"); ?></th>';
            html += '<th><?php _trans("lable148"); ?></th>';
            html += '<th><?php _trans("lable135"); ?></th>';
            html += '<th class="text_align_right"><?php _trans("lable43"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable22"); ?></th>';
            html += '</tr></thead><tbody>';
            if(list.employees.length > 0){
                for(var v=0; v < list.employees.length; v++){ 
                if(list.employees.length >= 4)
                { 
                    if(list.employees.length == v || list.employees.length == v+1)
                    {
                        var dropup = "dropup";
                    }
                    else
                    {
                        var dropup = "";
                    }
                }    
                    html += '<tr>';
                    html += '<td data-original-title="'+(list.employees[v].display_board_name?list.employees[v].display_board_name:"")+'" data-toggle="tooltip" class="textEllipsis">'+(list.employees[v].display_board_name?list.employees[v].display_board_name:"")+'</td>';
                    html += '<td class="textEllipsis"><a data-original-title="'+(list.employees[v].employee_no?list.employees[v].employee_no:"")+'" data-toggle="tooltip" href="<?php echo site_url("mech_employee/form/'+list.employees[v].employee_id+'"); ?>">'+(list.employees[v].employee_no?list.employees[v].employee_no:"")+'</a></td>';
                    html += '<td data-original-title="'+(list.employees[v].employee_name?list.employees[v].employee_name:"")+'" data-toggle="tooltip" class="textEllipsis">'+(list.employees[v].employee_name?list.employees[v].employee_name:"")+'</td>';
                    html += '<td data-original-title="'+(list.employees[v].employee_number?list.employees[v].employee_number:"")+'" data-toggle="tooltip" class="textEllipsis">'+(list.employees[v].employee_number?list.employees[v].employee_number:"")+'</td>';
                    html += '<td data-original-title="'+list.employees[v].role_name+'" data-toggle="tooltip" class="textEllipsis">'+list.employees[v].role_name+'</td>';
                    html += '<td class="text_align_right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;'+format_money((list.employees[v].total_rewards_point?list.employees[v].total_rewards_point:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;'+format_money((list.employees[v].total_rewards_point?list.employees[v].total_rewards_point:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'</td>';                                                                                                                                                                                                                                                    
                    html += '<td class="text_align_center">';
                    html += '<div class="options btn-group '+dropup+'">';
                    html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">';
                    html += '<i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
                    html += '<ul class="optionTag dropdown-menu">';
                    html += '<li><a href="<?php echo site_url("mech_employee/form/'+list.employees[v].employee_id+'"); ?>">';
                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable44"); ?></a></li>';
                    html += '<li><a target="_blank" href="<?php echo site_url("mech_employee/generate_pdf/'+list.employees[v].employee_id+'"); ?>">';
					html += '<i class="fa fa-print fa-margin" aria-hidden="true"></i></i> <?php _trans("lable141"); ?></a></li>';
                    html += '<li><a href="javascript:void(0)" onclick="employee_delete_record(\'mech_employee\',\''+list.employees[v].employee_id+'\',\'<?= $this->security->get_csrf_hash() ?>\')">';
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
$(function() {

    $("[data-toggle='tooltip']").tooltip();

    var currentDate = new Date();

    $(".card-block input").keypress(function (e) {
        if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
            $('.btn_submit').click();
            return false;
        } else {
            return true;
        }
    });

    $("#reset_filter").click(function () {
        $("#branch_id").val('');
        $("#employee_name").val('');
        $("#employee_no").val('');
        $("#employee_number").val('');
        $("#from_date").val('');
        $("#to_date").val('');
        $("#employee_role").val('');
        $("#shift").val('');
        $('.bootstrap-select').selectpicker("refresh");
        searchFilter();
    });

});

</script>
<?php } ?>