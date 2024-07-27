<?php if(count($clients) < 1) {  ?>
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
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('clients/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('label919'); ?>
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
                        <h3><?php _trans('lable35'); ?></h3>
                    </div>
                    <div class="tbl-cell pull-right">
                        <a class="btn btn-sm btn-primary" href="<?php echo site_url('clients/upload/new'); ?>">
                            <i class="fa fa-cloud-upload"></i>
                        </a>
                        <a class="btn btn-sm btn-primary" href="<?php echo site_url('clients/form'); ?>">
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
                        <label class="form_label"><?php _trans('lable95'); ?></label>
                        <div class="form_controls">
                            <select onchange="searchFilter()" name="branch_id" id="branch_id" class="searchSelect bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true">
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
                        <label class="form_label"><?php _trans('lable1210'); ?></label>
                        <div class="form_controls">
                            <input onkeyup="searchFilter()" type="text" name="client_no" id="client_no" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                        <label class="form_label"><?php _trans('lable36'); ?></label>
                        <div class="form_controls">
                            <input onkeyup="searchFilter()" type="text" name="client_name" id="client_name" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                        <label class="form_label"><?php _trans('lable208'); ?></label>
                        <div class="form_controls">
                            <select onchange="searchFilter()" name="customer_category_id" id="customer_category_id" class="searchSelect bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true">
                                <?php if(count($customercategory)>0){ ?>
                                    <option value=""><?php _trans('lable851'); ?></option>
                                <?php } ?>
                                <?php foreach ($customercategory as $custcategory) {?>
                                <option value="<?php echo $custcategory->customer_category_id; ?>"> <?php echo $custcategory->customer_category_name; ?></option>
                                <?php } ?>
                            </select>
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
                        <label class="form_label"><?php _trans('lable1237'); ?></label>
                        <div class="form_controls">
                            <select name="mobile_app" id="mobile_app" class="bootstrap-select bootstrap-select-arrow g-input removeError">
                                <option value=""><?php _trans("lable423"); ?></option>
                                <option value="U" <?php if ($clients->mobile_app_status == "U") {echo "selected";} ?>>Yes</option>
                                <option value="N" <?php if ($clients->mobile_app_status == "N") {echo "selected";} ?>>No</option>
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
                                    <th><?php _trans('lable95'); ?></th>
                                    <th><?php _trans('lable1210'); ?></th>
                                    <th><?php _trans('lable36'); ?></th>
                                    <th><?php _trans('lable846');?></th>
                                    <th class="text_align_center"><?php _trans('lable42'); ?></th>
                                    <th class="text_align_left"><?php _trans('lable41'); ?></th>
                                    <th class="text_align_center"><?php _trans('lable1237'); ?></th>
                                    <th class="text_align_right"><?php _trans('lable43'); ?></th>
                                    <th class="text_align_center"><?php _trans('lable22'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($clients) > 0) { 
                                    $i = 1;
                                    foreach ($clients as $client) { 
                                    if(count($clients) >= 4)
                                    {    
                                        if(count($clients) == $i || count($clients) == $i+1)
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
                                    <td data-original-title="<?php _htmlsc($client->display_board_name); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($client->display_board_name); ?></td>
                                    <td class="textEllipsis"><a data-original-title="<?php _htmlsc($client->client_no); ?>" data-toggle="tooltip" href="<?php echo site_url('clients/form/' . $client->client_id); ?>"><?php _htmlsc($client->client_no); ?></a></td>
                                    <td data-original-title="<?php _htmlsc($client->client_name); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($client->client_name); ?></td>
                                    <td data-original-title="<?php _htmlsc($client->customer_category_name); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($client->customer_category_name); ?></td>
                                    <td data-original-title="<?php _htmlsc($client->client_contact_no); ?>" data-toggle="tooltip" class="text_align_center textEllipsis"><?php _htmlsc($client->client_contact_no); ?></td>
                                    <td data-original-title="<?php _htmlsc($client->client_email_id); ?>" data-toggle="tooltip" class="text_align_left textEllipsis"><?php _htmlsc($client->client_email_id); ?></td>
                                    <td data-original-title="<?php if($client->mobile_app_status == 'U'){ echo "Yes"; } else{ echo 'No'; } ?>" data-toggle="tooltip" class="textEllipsis text_align_center"><?php if($client->mobile_app_status == 'U'){ echo "Yes"; } else{ echo 'No'; } ?></td>
                                    <td data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($client->total_rewards_point,$this->session->userdata('default_currency_digit')); ?>" data-toggle="tooltip" class="text_align_center textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($client->total_rewards_point,$this->session->userdata('default_currency_digit')); ?></td>
                                    <td class="text_align_center">
                                        <div class="options btn-group <?php echo $dropup; ?>">
                                            <a class="btn btn-default btn-sm dropdown-toggle"
                                            data-toggle="dropdown" href="#" >
                                                <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                            </a>
                                            <ul class="optionTag dropdown-menu">
                                                <li>
                                                    <a href="<?php echo site_url('clients/form/' . $client->client_id); ?>">
                                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#addAddress" data-model-type="C" data-customer-id="<?php echo $client->client_id; ?>" class="add_address">
                                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('lable45'); ?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#addNewCar" data-model-type="C" data-customer-id="<?php echo $client->client_id; ?>" class="add_car">
                                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('lable46'); ?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" onclick="delete_record('clients',<?php echo $client->client_id; ?>, '<?= $this->security->get_csrf_hash() ?>')"> <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <?php $i++; } } else { echo '<tr><td colspan="6" class="text-center" > No data found </td></tr>'; } ?>
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
    var client_name = $('#client_name').val()?$('#client_name').val():'';
    var branch_id = $("#branch_id").val()?$("#branch_id").val():'';
    var customer_category_id = $("#customer_category_id").val()?$("#customer_category_id").val():'';
    var client_no = $("#client_no").val()?$("#client_no").val():'';
    var client_contact_no = $('#client_contact_no').val()?$('#client_contact_no').val():'';
    var client_email_id = $('#client_email_id').val()?$('#client_email_id').val():'';
    var mobile_app = $('#mobile_app').val()?$('#mobile_app').val():'';
    $.post('<?php echo site_url('clients/ajax/get_filter_list'); ?>', {
        page : page_num,
        client_name : client_name,
        branch_id : branch_id,
        customer_category_id : customer_category_id,
        client_no : client_no,
        client_contact_no : client_contact_no,
        client_email_id : client_email_id,
        mobile_app : mobile_app,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            var html = '';
            html += '<div class="overflowScrollForTable">';
            html += '<table class="display table datatable table-bordered" cellspacing="0" width="100%">';
            html += '<thead><tr>';
            html += '<th><?php _trans("lable95"); ?></th>';
            html += '<th><?php _trans('lable1210'); ?></th>';
            html += '<th><?php _trans("lable36"); ?></th>';
            html += '<th><?php _trans("lable846");?></th>';
            html += '<th class="text_align_center"><?php _trans("lable42"); ?></th>';
            html += '<th><?php _trans("lable41"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable1237"); ?></th>';
            html += '<th class="text_align_right"><?php _trans("lable43"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable22"); ?></th>';
            html += '</tr></thead><tbody>';
            if(list.clients.length > 0){
                for(var v=0; v < list.clients.length; v++){ 
                if(list.clients.length >= 4)
                {
                    if(list.clients.length == v || list.clients.length == v+1)
                    {
                        var dropup = "dropup";
                    }
                    else
                    {
                        var dropup = "";
                    }
                }
                    html += '<tr>';
                    html += '<td class="textEllipsis" data-original-title="'+((list.clients[v].display_board_name)?list.clients[v].display_board_name:" ")+'" data-toggle="tooltip">'+((list.clients[v].display_board_name)?list.clients[v].display_board_name:" ")+'</td>';
                    html += '<td class="textEllipsis"><a data-original-title="'+((list.clients[v].client_no)?list.clients[v].client_no:" ")+'" data-toggle="tooltip"  href="<?php echo site_url("clients/form/'+list.clients[v].client_id+'"); ?>">'+((list.clients[v].client_no)?list.clients[v].client_no:" ")+'</a></td>';
                    html += '<td data-original-title="'+((list.clients[v].client_name)?list.clients[v].client_name:" ")+'" data-toggle="tooltip" class="textEllipsis">'+((list.clients[v].client_name)?list.clients[v].client_name:" ")+'</td>';
                    html += '<td data-original-title="'+((list.clients[v].customer_category_name)?list.clients[v].customer_category_name:" ")+'" data-toggle="tooltip" class="textEllipsis">'+((list.clients[v].customer_category_name)?list.clients[v].customer_category_name:" ")+'</td>';
                    html += '<td class="text_align_center textEllipsis" data-original-title="'+((list.clients[v].customer_category_name)?list.clients[v].customer_category_name:" ")+'" data-toggle="tooltip">'+((list.clients[v].client_contact_no)?list.clients[v].client_contact_no:" ")+'</td>';
                    html += '<td data-original-title="'+((list.clients[v].client_email_id)?list.clients[v].client_email_id:" ")+'" data-toggle="tooltip" class="textEllipsis">'+((list.clients[v].client_email_id)?list.clients[v].client_email_id:" ")+'</td>';
                    html += '<td data-original-title="';
					if(list.clients[v].mobile_app_status == 'U'){ html += 'Yes'; }else{ html += 'No'; }
                    html += '" data-toggle="tooltip" class="textEllipsis text_align_center">';
                    if(list.clients[v].mobile_app_status == 'U'){ html += 'Yes'; }else{ html += 'No'; }
                    html += '</td>';
                    html += '<td class="text_align_center textEllipsis" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;'+format_money(((list.clients[v].total_rewards_point)?list.clients[v].total_rewards_point:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'" data-toggle="tooltip"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;'+format_money(((list.clients[v].total_rewards_point)?list.clients[v].total_rewards_point:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'</td>';
                    html += '<td class="text_align_center">';
                    html += '<div class="options btn-group '+dropup+'">';
                    html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">';
                    html += '<i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
                    html += '<ul class="optionTag dropdown-menu">';
                    html += '<li><a href="<?php echo site_url("clients/form/'+list.clients[v].client_id+'"); ?>">';
                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable44"); ?></a></li>';
                    html += '<li><a href="javascript:void(0)" data-toggle="modal" data-target="#addAddress" data-model-type="C" data-customer-id="'+list.clients[v].client_id+'" class="add_address">';
                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable45"); ?></a></li>';
                    html += '<li><a href="javascript:void(0)" data-toggle="modal" data-target="#addNewCar" data-model-type="C" data-customer-id="'+list.clients[v].client_id+'" class="add_car">';
                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans('lable46'); ?></a></li>';
                    html += '<li><a href="javascript:void(0)" onclick="delete_record(\'clients\',\''+list.clients[v].client_id+'\',\'<?= $this->security->get_csrf_hash() ?>\')">';
                    html += '<i class="fa fa-trash-o fa-margin"></i> <?php _trans("lable47"); ?></a></li>';
                    html += '</ul></div></td></tr>';
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
        $("#branch_id").val('');
        $("#customer_category_id").val('');
        $("#client_name").val('');
        $("#client_contact_no").val('');
        $("#client_email_id").val('');
        $("#client_no").val('');
        $("#mobile_app").val('');
        $('.bootstrap-select').selectpicker("refresh");
        searchFilter();
    });

});
</script>
<?php } ?>
