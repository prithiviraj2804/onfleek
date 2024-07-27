<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php _trans('lable821'); ?></h3>
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
                <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>" autocomplete="off">
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable822'); ?></label>
                    <div class="form_controls">
                        <input onchange="searchFilter()" type="text" name="expiry_from_date" id="expiry_from_date" class="form-control datepicker" autocomplete="off">
                    </div>
                </div>
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable823'); ?></label>
                    <div class="form_controls">
                        <input onchange="searchFilter()" type="text" name="expiry_to_date" id="expiry_to_date" class="form-control datepicker" autocomplete="off">
                    </div>
                </div>
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable824'); ?></label>
                    <div class="form_controls">
                        <input onkeyup="searchFilter()" type="text" name="expiry_kilometer" id="expiry_kilometer" class="form-control" value="<?php echo $expiry_kilometer;?>" autocomplete="off">
                    </div>
                </div>
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable104'); ?></label>
                    <div class="form_controls">
                        <select onchange="searchFilter()" name="type" id="type" class="searchSelect bootstrap-select bootstrap-select-arrow form-control removeError" autocomplete="off" data-live-search="true">
                            <option value=""><?php _trans('lable241'); ?></option>
                            <option value="I" <?php if($type == "I"){ echo "selected";}?> ><?php _trans('lable119'); ?></option>
                            <option value="S" <?php if($type == "S"){ echo "selected";}?> ><?php _trans('lable395'); ?></option>
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
          
            <?php if(count($list)>0) { 
            if($type == 'S'){ ?>
            <div id="posts_content">
                <div class="overflowScrollForTable">
                    <table class="display table table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center"><?php _trans('lable36'); ?></th>
                                <th class="text-center"><?php _trans('lable820'); ?></th>
                                <th class="text-center"><?php _trans('lable62'); ?></th>
                                <th class="text-center"><?php _trans('lable826'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(count($list) > 0) { 
                            foreach ($list as $listas) { ?>
                            <tr onclick="navigateToViewPage(<?php echo $listas->customer_id; ?>,<?php echo $listas->customer_car_id;?>)" class="pointer">
                                <td class="text-center"><?php _htmlsc($listas->client_name); ?></td>
                                <td class="text-center"><?php _htmlsc($listas->client_contact_no); ?><br><?php _htmlsc($listas->client_email_id); ?></td>
                                <td class="text-center">
                                    <?php if($listas->brand_name){
                                        echo $listas->brand_name.",";
                                    } 
                                    if($listas->model_name){
                                        echo $listas->model_name.",";
                                    }
                                    if($listas->variant_name){
                                        echo $listas->variant_name;
                                    }?>
                                </td>
                                <td class="text-center"><?php _htmlsc($listas->service_item);?></td>
                            </tr>
                        <?php } } else { echo '<tr><td colspan="4" class="text-center" > No data found </td></tr>'; } ?>
                        </tbody>
                    </table>
                </div>
                <div class="headerbar-item pull-right paddingTop20px">
                    <?php echo $createLinks;?>
                </div>
            </div>
            <?php } else { ?>
            <div id="posts_content">
                <div class="overflowScrollForTable">
                    <table class="display table table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-left"><?php _trans('lable36'); ?></th>
                                <th class="text-center"><?php _trans('lable820'); ?></th>
                                <th class="text-center"><?php _trans('lable72'); ?></th>
                                <th class="text-center"><?php _trans('lable62'); ?></th>
                                <th class="text-center"><?php _trans('lable206'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(count($list) > 0) { 
                            foreach ($list as $listas) { ?>
                            <tr onclick="navigateToViewPage(<?php echo $listas->customer_id; ?>,<?php echo $listas->customer_car_id;?>)" class="pointer">
                                <td class="text-left"><?php _htmlsc($listas->client_name); ?></td>
                                <td class="text-center"><?php _htmlsc($listas->client_contact_no); ?><br><?php _htmlsc($listas->client_email_id); ?></td>
                                <td class="text-center"><span style="text-transform: uppercase;"><?php _htmlsc($listas->car_reg_no); ?></span>
                                <td class="text-center">
                                    <?php if($listas->brand_name){
                                        echo $listas->brand_name.",";
                                    } 
                                    if($listas->model_name){
                                        echo $listas->model_name.",";
                                    }
                                    if($listas->variant_name){
                                        echo $listas->variant_name;
                                    }?>
                                </td>
                                <td class="text-center"><?php _htmlsc($listas->service_item);?></td>
                            </tr>
                        <?php } } else { echo '<tr><td colspan="4" class="text-center" > No data found </td></tr>'; } ?>
                        </tbody>
                    </table>
                </div>
                <div class="headerbar-item pull-right paddingTop20px">
                    <?php echo $createLinks;?>
                </div>
            </div>
            <?php } }  else { ?>
            <div id="posts_content">
                <div class="overflowScrollForTable">
                    <table class="display table table-bordered" cellspacing="0" width="100%"><thead>
                    <tr><th class="text-center"><?php _trans('lable36'); ?></th>
                        <th class="text-center"><?php _trans('lable820'); ?></th>
                        <th class="text-center"><?php _trans('lable62'); ?></th>
                        <th class="text-center"><?php _trans('lable825'); ?></th>
                    </tr>
                    </thead><tbody><tr><td colspan="4" class="text-center" ><?php _trans('lable23'); ?></td></tr></tbody></table>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
  </section>
</div>

<script type="text/javascript">

function searchFilter(page_num) {
    page_num = page_num?page_num:0;
    var expiry_from_date = $('#expiry_from_date').val()?$('#expiry_from_date').val():'';
    var expiry_to_date = $("#expiry_to_date").val()?$("#expiry_to_date").val():'';
    var expiry_kilometer = $("#expiry_kilometer").val()?$("#expiry_kilometer").val():'';
    var type = $("#type").val()?$("#type").val():'';

    $.post('<?php echo site_url('customer_retention/ajax/get_filter_list'); ?>', {
        page : page_num,
        expiry_from_date : expiry_from_date,
        expiry_to_date : expiry_to_date,
        expiry_kilometer : expiry_kilometer,
        type : type,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success == '1'){
            var html = '';
            if( list.list != "" && list.list.length > 0 ) { 
                if(type == 'S'){
                    html += '<div class="overflowScrollForTable">';
                    html += '<table class="display table table-bordered" cellspacing="0" width="100%">';
                    html += '<thead><tr>';
                    html += '<th class="text-center"><?php _trans("lable36"); ?></th>';
                    html += '<th class="text-center"><?php _trans("lable820"); ?></th>';
                    html += '<th class="text-center"><?php _trans("lable62"); ?></th>';
                    html += '<th class="text-center"><?php _trans("lable826"); ?></th>';
                    html += '</tr></thead><tbody>';
                    if( list.list.length > 0 ) { 
                        for(var i=0; i < list.list.length; i++){
                            html += '<tr onclick="navigateToViewPage('+list.list[i].customer_id+','+list.list[i].customer_car_id+')" class="pointer">';
                            html += '<td class="text-center">'+list.list[i].client_name+'</td>';
                            html += '<td class="text-center">'+list.list[i].client_contact_no+'<br>'+list.list[i].client_email_id+'); ?></td>';
                            html += '<td class="text-center">';
                            if(list.list[i].brand_name){
                                html += list.list[i].brand_name;
                            } 
                            if(list.list[i].model_name){
                                html += list.list[i].model_name+",";
                            }
                            if(list.list[i].variant_name){
                                html += list.list[i].variant_name;
                            }
                            html += '</td>';
                            html += '<td class="text-center">'+list.list[i].service_item+');?></td>';
                            html += '</tr>';
                        } 
                    } else { 
                        html += '<tr><td colspan="4" class="text-center" > No data found </td></tr>';
                    }
                    html += '</tbody></table></div>';
                    html += '<div class="headerbar-item pull-right paddingTop20px">';
                    html += list.createLinks;
                    html += '</div>';
            
                } else {
                    html += '<div class="overflowScrollForTable">';
                    html += '<table class="display table table-bordered" cellspacing="0" width="100%">';
                    html += '<thead><tr>';
                    html += '<th class="text-left"><?php _trans("lable36"); ?></th>';
                    html += '<th class="text-center"><?php _trans("lable820"); ?></th>';
                    html += '<th class="text-center"><?php _trans("lable72"); ?></th>';
                    html += '<th class="text-center"><?php _trans("lable62"); ?></th>';
                    html += '<th class="text-center"><?php _trans("lable206"); ?></th>';
                    html += '</tr></thead><tbody>';
                    if(list.list.length > 0) { 
                        for(var i = 0; i < list.list.length; i++){
                            html += '<tr onclick="navigateToViewPage('+list.list[i].customer_id+','+list.list[i].customer_car_id+')" class="pointer">';
                            html += '<td class="text-left">'+list.list[i].client_name+'</td>';
                            html += '<td class="text-center">'+list.list[i].client_contact_no+'<br>'+list.list[i].client_email_id+'</td>';
                            html += '<td class="text-center"><span style="text-transform: uppercase;">'+list.list[i].car_reg_no+'</span>';
                            html += '<td class="text-center">';
                            if(list.list[i].brand_name){
                                html += list.list[i].brand_name+",";
                            } 
                            if(list.list[i].model_name){
                                html += list.list[i].model_name+",";
                            }
                            if(list.list[i].variant_name){
                                html += list.list[i].variant_name;
                            }
                            html += '</td>';
                            html += '<td class="text-center">'+list.list[i].service_item+'</td>';
                            html += '</tr>';
                        } 
                    } else { 
                            html += '<tr><td colspan="4" class="text-center" > No data found </td></tr>';
                        }
                        html += '</tbody></table></div>';
                        html += '<div class="headerbar-item pull-right paddingTop20px">';
                        html += list.createLinks;
                        html += '</div>';
                    } 
                } else { 
                    html += '<div class="overflowScrollForTable">';
                    html += '<table class="display table table-bordered" cellspacing="0" width="100%"><thead>';
                    html += '<tr><th class="text-center"><?php _trans("lable36"); ?></th>';
                    html += '<th class="text-center"><?php _trans("lable820"); ?></th>';
                    html += '<th class="text-center"><?php _trans("lable62"); ?></th>';
                    html += '<th class="text-center"><?php _trans("lable825"); ?></th>';
                    html += '</tr>';
                    html += '</thead><tbody><tr><td colspan="4" class="text-center" ><?php _trans("lable23"); ?></td></tr></tbody></table>';
                    html += '</div>';
                }
                $('#posts_content').html(html);
        }
    });

    $('body').on('mouseenter', '.table', function () {
        $(".datatable [data-toggle='tooltip']").tooltip();
    });
}

function navigateToViewPage(customer_id,customer_car_id){
    var expiry_from_date = $("#expiry_from_date").val();
    expiry_from_date = expiry_from_date.split("/").reverse().join("-");
    var expiry_to_date = $("#expiry_to_date").val();
    expiry_to_date = expiry_to_date.split("/").reverse().join("-");
    var expiry_kilometer = $("#expiry_kilometer").val();
    if(expiry_kilometer == ""){
        expiry_kilometer = 0;
    }
    window.location = "<?php echo site_url('customer_retention/view/'); ?>"+customer_id+"/"+customer_car_id+"/"+expiry_from_date+"/"+expiry_to_date+"/"+expiry_kilometer+"/"+$("#type").val();
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
        $("#expiry_from_date").val('');
        $("#expiry_to_date").val('');
        $("#expiry_kilometer").val('');
        $("#type").val('');
        $('.bootstrap-select').selectpicker("refresh");
        searchFilter();
    });

});

</script>