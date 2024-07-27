<?php if(count($transactions) < 1) {  ?>
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
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_bank_list/create'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('label937'); ?>
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
                    <h3><?php _trans('lable478'); ?></h3>
                </div>
                <div class="tbl-cell tbl-cell-action">
                <a href="<?php echo site_url('mech_bank_list/create'); ?>"  class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> <?php _trans('lable40'); ?></a>
                </div>
            </div>
        </div>
    </div>
</header>
<section class="card">
	<div class="card-block">
        <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
        <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
            <label class="form_label"><?php _trans('lable95'); ?></label>
            <div class="form_controls">
                <select onchange="searchFilter()" name="user_branch_id" id="user_branch_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" autocomplete="off" data-live-search="true">
                    <?php if(count($branch_list)>0){ ?>
                        <option value=""><?php _trans('lable51'); ?></option>
                    <?php } ?>
                    <?php foreach ($branch_list as $branchList) {?>
                    <option value="<?php echo $branchList->w_branch_id; ?>"> <?php echo $branchList->display_board_name; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
            <label class="form_label"><?php _trans('lable822'); ?></label>
            <div class="form_controls">
                <input onchange="searchFilter()" type="text" name="from_date" id="from_date" class="form-control datepicker"  autocomplete="off">
            </div>
        </div>
        <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
            <label class="form_label"><?php _trans('lable823'); ?></label>
            <div class="form_controls">
                <input onchange="searchFilter()" type="text" name="to_date" id="to_date" class="form-control datepicker" autocomplete="off">
            </div>
        </div>
        <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
            <label class="form_label"></label>
            <div class="form_controls paddingTop15px">
                <span><button onclick="searchFilter()" class="btn_submit btn btn-primary"><?php _trans('lable39'); ?></button></span>
                <span><span id="reset_filter" class="btn"><?php _trans('lable827'); ?></span></span>
            </div>
        </div>
        <div id="posts_content">
            <div class="overflowScrollForTable">
                <table class="display table datatable table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="text_align_center"><?php _trans('lable31'); ?></th>
                            <th><?php _trans('lable95'); ?></th>
                            <th><?php _trans('lable151'); ?></th>
                            <th><?php _trans('lable104'); ?></th>
                            <th class="text_align_right"><?php _trans('lable108'); ?></th>
                            <th class="text_align_center"><?php _trans('lable184'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                
                        <?php if(count($transactions) > 0){
                            $i = 1;
                        foreach ($transactions as $result){
                        if(count($transactions) >= 4) 
                        {   
                            if(count($transactions) == $i || count($transactions) == $i+1)
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
                            <td class="text_align_center" data-original-title="<?php _htmlsc($result->payment_date?date_from_mysql($result->payment_date):""); ?>" data-toggle="tooltip" class="textEllipsis"><?php echo $result->payment_date?date_from_mysql($result->payment_date):""; ?></td>
                            <td data-original-title="<?php _htmlsc($result->display_board_name?$result->display_board_name:""); ?>" data-toggle="tooltip" class="textEllipsis"><?php echo $result->display_board_name?$result->display_board_name:""; ?></td>
                            <td data-original-title="<?php if($result->shift == 1){
                                echo "regular";
                            }else if($result->shift == 2){
                                echo "Day Shift";
                            }else if($result->shift == 3){
                                echo "Night Shift";
                            } ?>" data-toggle="tooltip" class="textEllipsis">

                            <?php if($result->shift == 1){
                                echo "regular";
                            }else if($result->shift == 2){
                                echo "Day Shift";
                            }else if($result->shift == 3){
                                echo "Night Shift";
                            } ?></td>
                            <td data-original-title="<?php if($result->tran_type == "D"){echo "Deposite";}elseif($result->tran_type == "W"){
                                echo "Withdraw";
                            } ?>" data-toggle="tooltip" class="textEllipsis">
                            
                            <?php if($result->tran_type == "D"){echo "Deposite";}elseif($result->tran_type == "W"){
                                echo "Withdraw";
                            } ?>
                            </td>
                            <td class="text-right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($result->amount?$result->amount:0),$this->session->userdata('default_currency_digit')); ?>" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($result->amount?$result->amount:0),$this->session->userdata('default_currency_digit')); ?></td>
                            <td class="text_align_center">
                            <div class="options btn-group <?php echo $dropup; ?>">
                                <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-cog"></i> <?php _trans('lable184'); ?>
                                </a>
                                <ul class="optionTag dropdown-menu">
                                    <li>
                                        <a href="<?php echo site_url('mech_bank_list/create/'.$result->deposit_id); ?>">
                                            <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="delete_record('mech_bank_list',<?php echo $result->deposit_id; ?>, '<?= $this->security->get_csrf_hash() ?>')"> <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?></a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        </tr>
                        <?php $i++; } }else{ ?>
                        <tr>
                            <td colspan="6" align="center"><?php _trans('lable343'); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="headerbar-item pull-right paddingTop20px">
                <?php echo $createLinks;?>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
function searchFilter(page_num) {
    page_num = page_num?page_num:0;
    var from_date = $('#from_date').val()?$('#from_date').val():'';
    var w_branch_id = $("#user_branch_id").val()?$("#user_branch_id").val():'';
    var to_date = $("#to_date").val()?$("#to_date").val():'';

    $.post('<?php echo site_url('mech_bank_list/ajax/get_filter_list'); ?>', {
        page : page_num,
        from_date : from_date,
        w_branch_id : w_branch_id,
        to_date : to_date,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            var html = '';
            html += '<div class="overflowScrollForTable">';
            html += '<table class="display table datatable table-bordered" cellspacing="0" width="100%">';
            html += '<thead><tr>';
            html += '<th class="text_align_center"><?php _trans("lable31"); ?></th>';
            html += '<th><?php _trans("lable95"); ?></th>';
            html += '<th><?php _trans("lable151"); ?></th>';
            html += '<th><?php _trans("lable104"); ?></th>';
            html += '<th class="text_align_right"><?php _trans("lable108"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable184"); ?></th>';
            html += '</tr></thead><tbody>';
            if(list.transactions.length > 0){
                for(var v=0; v < list.transactions.length; v++){ 
                    if(list.transactions.length >= 4){
                    if(list.transactions.length == v || list.transactions.length == v+1)
                    {
                        var dropup = "dropup";
                    }
                    else
                    {
                        var dropup = "";
                    }
                }
                    html += '<tr>';
                    html += '<td class="text_align_center" class="text-center" data-original-title="'+(list.transactions[v].payment_date?formatDate(list.transactions[v].payment_date):"")+'" data-toggle="tooltip" class="textEllipsis">'+(list.transactions[v].payment_date?formatDate(list.transactions[v].payment_date):"")+'</td>';
                    html += '<td data-original-title="'+(list.transactions[v].display_board_name?list.transactions[v].display_board_name:"")+'" data-toggle="tooltip" class="textEllipsis">'+(list.transactions[v].display_board_name?list.transactions[v].display_board_name:"")+'</td>';
                    html += '<td data-original-title="';
					if(list.transactions[v].shift == 1){
                        html += 'regular';
                    }else if(list.transactions[v].shift == 2){
                        html += 'Day Shift';
                    }else if(list.transactions[v].shift == 3){
                        html += 'Night Shift';
                    }
                    html += '" data-toggle="tooltip" class="textEllipsis">';
                    
                    if(list.transactions[v].shift == 1){
                        html += 'regular';
                    }else if(list.transactions[v].shift == 2){
                        html += 'Day Shift';
                    }else if(list.transactions[v].shift == 3){
                        html += 'Night Shift';
                    }
                    html += '</td>';
                    html += '<td data-original-title="';
                    if(list.transactions[v].tran_type == "D"){
                        html += 'Deposite';
                    }else if(list.transactions[v].tran_type == "W"){
                        html += 'Withdraw';
                    }
                    html += '" data-toggle="tooltip" class="textEllipsis">';
                    if(list.transactions[v].tran_type == "D"){
                        html += 'Deposite';
                    }else if(list.transactions[v].tran_type == "W"){
                        html += 'Withdraw';
                    }
                    html += '</td>';
                    html += '<td class="text-right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;'+format_money((list.transactions[v].amount?list.transactions[v].amount:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;'+format_money((list.transactions[v].amount?list.transactions[v].amount:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'</td>';
                    html += '<td class="text_align_center">';
                    html += '<div class="options btn-group '+dropup+'">';
                    html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">';
                    html += '<i class="fa fa-cog"></i> <?php _trans("lable184"); ?></a>';
                    html += '<ul class="optionTag dropdown-menu">';
                    html += '<li><a href="<?php echo site_url("mech_bank_list/create/'+list.transactions[v].deposit_id+'");?>">';
                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable44"); ?></a></li>';

                    html += '<li><a href="javascript:void(0)" onclick="delete_record(\'mech_bank_list\',\''+list.transactions[v].deposit_id+'\',\'<?= $this->security->get_csrf_hash() ?>\')">';
                    html += '<i class="fa fa-trash-o fa-margin"></i> <?php _trans("lable47"); ?></a></li>';
                    html += '</ul></div></td>';
                    html += '</tr>';
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

        $(function() {
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
                $("#user_branch_id").val('');
                $('.bootstrap-select').selectpicker("refresh");
                searchFilter();
            });
        
        });
    });
</script>
<?php } ?> 