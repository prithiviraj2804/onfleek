<?php if(count($mech_service_item_dtls) < 1) {  ?>
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
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_item_master/service_create'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('label927'); ?>
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
                    <h3><?php _trans('lable257'); ?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_item_master/service_create'); ?>">
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
        <div id="gif" class="gifload">
			<div class="gifcenter">
			  <center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
		    </div>
		</div>
            <div class="row col-xl-12 col-lg-12 col-md-12 col-sm-12 padding0px">
                <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable250'); ?></label>
                    <div class="form_controls">
                        <input name="service_item_name" id="service_item_name" class="form-control removeError" autocomplete="off" data-live-search="true">
                    </div>
                </div>
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable251'); ?></label>
                    <div class="form_controls">
                        <select onchange="searchFilter()" name="service_category_id" id="service_category_id" class="searchSelect bootstrap-select bootstrap-select-arrow form-control removeError" autocomplete="off" data-live-search="true">
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
                    <label class="form_label"><?php _trans('lable73'); ?></label>
                    <div class="form_controls">
                        <select class="bootstrap-select bootstrap-select-arrow check_error_label" data-live-search="true" name="popup_car_brand_id" id="popup_car_brand_id">
                            <option value=''><?php _trans('lable1106');?></option>
                            <?php if (count($car_brand_list) > 0) : ?>
                            <?php foreach ($car_brand_list as $brand_list) {
                                if(!empty($car_detail) && $car_detail->car_brand_id == $brand_list->brand_id) {
                                $selected = 'selected="selected"'; } else { $selected = ''; } ?>
                            <option value="<?php echo $brand_list->brand_id; ?>" <?php echo $selected; ?>><?php echo $brand_list->brand_name; ?></option>
                            <?php } endif; ?>
                        </select>
                    </div>
                </div>
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable74'); ?></label>
                    <div class="form_controls">
                        <select class="bootstrap-select bootstrap-select-arrow check_error_label" data-live-search="true" name="popup_car_brand_model_id" id="popup_car_brand_model_id">
                            <option value=""><?php _trans('lable231');?></option>
                            <?php if (!empty($car_model_list)) : ?>
                                <?php foreach ($car_model_list as $model_list) {
                                if (!empty($car_detail) && $car_detail->car_brand_model_id == $model_list->model_id) {
                                    $selected = 'selected="selected"';
                                } else {
                                    $selected = '';
                                } ?>
                            <option value="<?php echo $model_list->model_id; ?>" <?php echo $selected; ?>><?php echo $model_list->model_name; ?></option>
                            <?php } endif; ?>
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
                <div class="overflowScrollForTableProduct">
                    <table class="display table datatable table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text_align_left"><?php echo trans('lable253'); ?></div>
                                <th class="text_align_left"><?php echo trans('lable251'); ?></div>
                                <th class="text_align_right"><?php echo trans('label945'); ?></div>
                                <th class="text_align_center"><?php echo trans('lable22'); ?></div>
                            </tr>    
                        </thead>
                    <tbody>    
                        <?php if(count($mech_service_item_dtls) > 0){
                            $i = 1;
                            foreach ($mech_service_item_dtls as $key => $item_price_list) {
                                if(count($mech_service_item_dtls) >= 4)
                                {  
                                    if(count($mech_service_item_dtls) == $i || count($mech_service_item_dtls) == $i+1)
                                    {
                                        $dropup = "dropup";
                                    }
                                    else
                                    {
                                        $dropup = "";
                                    }
                                } ?>
                        <tr>

                            <?php if(count($item_price_list->subproducts) > 0){ ?>
                                <td class="textEclip pointer" data-original-title="<?php _htmlsc($item_price_list->service_item_name); ?>" data-toggle="tooltip"><span class="themeTextColor" data-toggle="collapse" data-target="#accordion_<?php echo $item_price_list->msim_id; ?>" ><?php _htmlsc($item_price_list->service_item_name); ?></span></td>
                            <?php }else{ ?>
                                <td class="textEclip" data-original-title="<?php _htmlsc($item_price_list->service_item_name); ?>" data-toggle="tooltip"><span><a><?php _htmlsc($item_price_list->service_item_name); ?></a></span></td>
                            <?php } ?>

                            <td class="textEclip" data-original-title="<?php _htmlsc($item_price_list->category_name); ?>" data-toggle="tooltip"><?php _htmlsc($item_price_list->category_name); ?></td>
                            <td class="text-right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($item_price_list->estimated_cost?$item_price_list->estimated_cost:$item_price_list->default_estimated_cost),$this->session->userdata('default_currency_digit')); ?>" data-toggle="tooltip"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($item_price_list->estimated_cost?$item_price_list->estimated_cost:$item_price_list->default_estimated_cost),$this->session->userdata('default_currency_digit')); ?></td>
                            <td class="text-center">
                                <div class="options btn-group <?php echo $dropup; ?>">
                                    <a class="btn btn-default btn-sm dropdown-toggle"
                                    data-toggle="dropdown" href="#">
                                        <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                    </a>
                                    <ul class="optionTag dropdown-menu">
                                        <li>
                                            <a href="<?php echo site_url('mech_item_master/service_create/'.$item_price_list->msim_id); ?>">
                                                <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                            </a>
                                        </li>
                                        <?php if($item_price_list->workshop_id != 1){ ?>
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_record('mech_service_master',<?php echo $item_price_list->msim_id; ?>, '<?= $this->security->get_csrf_hash() ?>')"> <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </td>   
                        </tr> 
                        <?php if(count($item_price_list->subproducts) > 0){ ?>
                        <tr width="100%" class="paddingTop10px paddingBot10px rowBorder collapse" id="accordion_<?php echo $item_price_list->msim_id;?>">
                            <td width="100%" colspan="4">
                                <table width="100%">
                                    <thead width="100%">    
                                        <tr width="100%">
                                            <th class="text_align_left"><?php echo trans('lable229'); ?></th>
                                            <th class="text_align_left"><?php echo trans('lable231'); ?></th>
                                            <th class="text_align_left"><?php echo trans('lable232'); ?></th>
                                            <th class="text_align_left"><?php echo trans('lable132'); ?></th>
                                            <th class="text_align_left"><?php echo ('Year'); ?></th>
                                            <th class="text-center"><?php echo trans('lable22'); ?></th>
                                        </tr>
                                    </thead>
                                <tbody>        
                            <?php foreach($item_price_list->subproducts as $subpro){ ?>
                            <tr width="100%">
                                <td class="textEclip text_align_left" data-original-title="<?php _htmlsc($subpro->brand_name); ?>" data-toggle="tooltip"><?php _htmlsc($subpro->brand_name); ?></td>
                                <td class="text_align_left" data-original-title="<?php _htmlsc($subpro->model_name); ?>" data-toggle="tooltip"><?php _htmlsc($subpro->model_name); ?></td>
                                <td class="text_align_left" data-original-title="<?php _htmlsc($subpro->variant_name); ?>" data-toggle="tooltip"><?php _htmlsc($subpro->variant_name); ?></td>
                                <td class="text_align_left" data-original-title="<?php if($subpro->fuel_type == 'P'){ echo 'Petrol';}else if($subpro->fuel_type == 'D'){ echo 'Diesel';}else if($subpro->fuel_type == 'O'){ echo 'Other';} ?>" data-toggle="tooltip"><?php if($subpro->fuel_type == 'P'){ echo 'Petrol';}else if($subpro->fuel_type == 'D'){ echo 'Diesel';}else if($subpro->fuel_type == 'O'){ echo 'Other';} ?></td>
                                <td class="text_align_left" data-original-title="<?php echo $subpro->year; ?>" data-toggle="tooltip"><?php echo $subpro->year; ?></td>
                                <td class="text-center">
                                    <?php if(count($item_price_list->subproducts) > 1){ ?>
                                    <div class="options btn-group <?php echo $dropup; ?>">
                                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php _trans('lable22'); ?></a>
                                        <ul class="optionTag dropdown-menu">
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_record('mech_sub_item_master',<?php echo $subpro->service_map_id; ?>,'<?= $this->security->get_csrf_hash() ?>');">
                                                    <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <?php } ?>
                                </td>
                            </tr>
                         <?php } ?>
                                </tbody>
                            </table>
                            <td>
                    </tr>    
                        <?php } $i++; } } ?>    
                    </tbody>
                </table>    
                <div class="headerbar-item pull-right">
                    <?php echo $createLinks;?>
                </div>
            </div>
        </div>
    </section>
</div>
<script>

$('#popup_car_brand_id').change(function () {
    $('#gif').show();
    $.post("<?php echo site_url('user_cars/ajax/get_brand_models'); ?>", {
        brand_id: $('#popup_car_brand_id').val(),
        _mm_csrf: $('input[name="_mm_csrf"]').val()
    },
    function (data) {
        var response = JSON.parse(data);
        if (response.length > 0) {
            $('#gif').hide();
            $('#popup_car_brand_model_id').empty(); // clear the current elements in select box
            $('#popup_car_brand_model_id').append($('<option></option>').attr('value', '').text('Model'));
            for (row in response) {
                $('#popup_car_brand_model_id').append($('<option></option>').attr('value', response[row].model_id).text(response[row].model_name));
            }
            $('#popup_car_brand_model_id').selectpicker("refresh");
        }
        else {
            $('#gif').hide();
            $('#popup_car_brand_model_id').empty(); // clear the current elements in select box
            $('#popup_car_brand_model_id').append($('<option></option>').attr('value', '').text('Model'));
            $('#popup_car_brand_model_id').selectpicker("refresh");
        }
    });
});


function searchFilter(page_num) {
    page_num = page_num?page_num:0;
    var service_item_name = $('#service_item_name').val()?$('#service_item_name').val():'';
    var service_category_id = $("#service_category_id").val()?$("#service_category_id").val():'';
    var popup_car_brand_id = $('#popup_car_brand_id').val()?$('#popup_car_brand_id').val():'';
    var popup_car_brand_model_id = $('#popup_car_brand_model_id').val()?$('#popup_car_brand_model_id').val():'';

    $.post('<?php echo site_url('mech_item_master/ajax/get_service_filter_list'); ?>', {
        page : page_num,
        service_item_name : service_item_name,
        service_category_id : service_category_id,
        popup_car_brand_id : popup_car_brand_id,
        popup_car_brand_model_id : popup_car_brand_model_id,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            var html = '';
            html += '<div class="overflowScrollForTableProduct">';
            html += '<table class="display table datatable table-bordered" cellspacing="0" width="100%">';
            html += '<thead><tr>';
            html += '<th class="text_align_left"><?php echo trans("lable253"); ?></th>';
            html += '<th class="text_align_left"><?php echo trans("lable251"); ?></th>';
            html += '<th class="text_align_right"><?php echo trans("label945"); ?></th>';
            html += '<th class="text_align_center"><?php echo trans("lable22"); ?></th></tr></thead>';
            html += ' <tbody>';
            if(list.mech_service_item_dtls.length > 0){
                for(var v=0; v < list.mech_service_item_dtls.length; v++){ 
                    if(list.mech_service_item_dtls.length >= 4)
                    {    
                        if(list.mech_service_item_dtls.length == v || list.mech_service_item_dtls.length == v+1)
                        {
                            var dropup = "dropup";
                        }
                        else
                        {
                            var dropup = "";
                        }
                    }      
                    html += '<tr>';
                    if(list.mech_service_item_dtls[v].subproducts.length > 0){ 
                        html += '<td class="textEclip pointer" data-original-title="'+(list.mech_service_item_dtls[v].service_item_name?list.mech_service_item_dtls[v].service_item_name:"")+'" data-toggle="tooltip"><span class="themeTextColor" data-toggle="collapse" data-target="#accordion_'+list.mech_service_item_dtls[v].msim_id+'">'+(list.mech_service_item_dtls[v].service_item_name?list.mech_service_item_dtls[v].service_item_name:"")+'</span></td>';
                    }else{
                        html += '<td class="textEclip" data-original-title="'+list.mech_service_item_dtls[v].service_item_name+'" data-toggle="tooltip"><span ';
                        html += '>'+list.mech_service_item_dtls[v].service_item_name+'</span></td>';
                    }
                   
                    html += '<td class="textEclip" data-original-title='+list.mech_service_item_dtls[v].category_name+'" data-toggle="tooltip">'+list.mech_service_item_dtls[v].category_name+'</td>';
                    html += '<td class="text_align_right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata("default_currency_code")); ?>&nbsp;'+format_money((list.mech_service_item_dtls[v].estimated_cost?list.mech_service_item_dtls[v].estimated_cost:list.mech_service_item_dtls[v].default_estimated_cost),<?php echo $this->session->userdata("default_currency_digit");?>)+'" data-toggle="tooltip" class="textEllipsis" ><?php echo $this->mdl_settings->currencychanger($this->session->userdata("default_currency_code")); ?>&nbsp;'+format_money((list.mech_service_item_dtls[v].estimated_cost?list.mech_service_item_dtls[v].estimated_cost:list.mech_service_item_dtls[v].default_estimated_cost),<?php echo $this->session->userdata("default_currency_digit");?>)+'</td>';
                    html += '<td class="text-center">';
                    html += '<div class="options btn-group '+dropup+'">';
                    html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">';
                    html += '<i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
                    html += '<ul class="optionTag dropdown-menu">';
                    html += '<li><a href="<?php echo site_url("mech_item_master/service_create/'+list.mech_service_item_dtls[v].msim_id+'"); ?>">';
                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable44"); ?></a></li>';
                    if(list.mech_service_item_dtls[v].workshop_id != 1){
                        html += '<li><a href="javascript:void(0)" onclick="delete_record(\'mech_service_master\',\''+list.mech_service_item_dtls[v].msim_id+'\',\'<?= $this->security->get_csrf_hash() ?>\')">';
                        html += '<i class="fa fa-trash-o fa-margin"></i> <?php _trans("lable47"); ?></a></li>';
                    }
                    html += '</ul></div></td></tr>';
                    if(list.mech_service_item_dtls[v].subproducts.length > 0){
                        html += '<tr width="100%" class="paddingTop10px rowBorder collapse" id="accordion_'+list.mech_service_item_dtls[v].msim_id+'">';
                        html += '<td width="100%" colspan="4"><table width="100%"><thead width="100%"><tr width="100%">'
                        html += '<th class="text_align_left"><?php _trans("lable229"); ?></th>';
                        html += '<th class="text_align_left"><?php _trans("lable231"); ?></th>';
                        html += '<th class="text_align_left"><?php _trans("lable232"); ?></th>';
                        html += '<th class="text_align_left"><?php _trans("lable132"); ?></th>';
                        html += '<th class="text_align_left"><?php echo ("Year"); ?></th>';
                        html += '<th class="text-center"><?php _trans("lable22"); ?></th>';
                        html += '</td></tr></thead><tbody width="100%">';

                        for(var s = 0; s < list.mech_service_item_dtls[v].subproducts.length; s++){
                            if(list.mech_service_item_dtls[v].subproducts.length >= 4)
                            {    
                                if(list.mech_service_item_dtls[v].subproducts.length == s || list.mech_service_item_dtls[v].subproducts.length == s+1)
                                {
                                    var dropup_sub = "dropup";
                                }
                                else
                                {
                                    var dropup_sub = "";
                                }
                            }
                            html += '<tr width="100%">';
                            html += '<td data-original-title="'+(list.mech_service_item_dtls[v].subproducts[s].brand_name?list.mech_service_item_dtls[v].subproducts[s].brand_name:'')+'" data-toggle="tooltip">'+(list.mech_service_item_dtls[v].subproducts[s].brand_name?list.mech_service_item_dtls[v].subproducts[s].brand_name:'')+'</td>';
                            html += '<td data-original-title="'+(list.mech_service_item_dtls[v].subproducts[s].model_name?list.mech_service_item_dtls[v].subproducts[s].model_name:"")+'" data-toggle="tooltip">'+(list.mech_service_item_dtls[v].subproducts[s].model_name?list.mech_service_item_dtls[v].subproducts[s].model_name:"")+'</td>';
                            html += '<td data-original-title="'+(list.mech_service_item_dtls[v].subproducts[s].variant_name?list.mech_service_item_dtls[v].subproducts[s].variant_name:"")+'" data-toggle="tooltip">'+(list.mech_service_item_dtls[v].subproducts[s].variant_name?list.mech_service_item_dtls[v].subproducts[s].variant_name:"")+'</td>';
                            html += '<td data-original-title="';
                            if(list.mech_service_item_dtls[v].subproducts[s].fuel_type == 'P'){
                                html += 'Petrol';
                            }else if(list.mech_service_item_dtls[v].subproducts[s].fuel_type == 'D'){
                                html += 'Diesel';
                            }else if(list.mech_service_item_dtls[v].subproducts[s].fuel_type == 'O'){
                                html += 'Others';
                            }
                            html += 'data-toggle="tooltip">';
                            if(list.mech_service_item_dtls[v].subproducts[s].fuel_type == 'P'){
                                html += 'Petrol';
                            }else if(list.mech_service_item_dtls[v].subproducts[s].fuel_type == 'D'){
                                html += 'Diesel';
                            }else if(list.mech_service_item_dtls[v].subproducts[s].fuel_type == 'O'){
                                html += 'Others';
                            }
                            html += '</td>';
                            html += '<td data-original-title="'+(list.mech_service_item_dtls[v].subproducts[s].year?list.mech_service_item_dtls[v].subproducts[s].year:"")+'" data-toggle="tooltip">'+(list.mech_service_item_dtls[v].subproducts[s].year?list.mech_service_item_dtls[v].subproducts[s].year:"")+'</td>';
                            html += '<td class="td text-center">';
                            html += '<div class="options btn-group '+dropup_sub+'">';
                            html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
                            html += '<ul class="optionTag dropdown-menu">';
                                html += '<li><a href="javascript:void(0)" onclick="delete_record(\'mech_sub_service_master\',\''+list.mech_service_item_dtls[v].subproducts[s].service_map_id+'\',\'<?= $this->security->get_csrf_hash() ?>\')">';
                                html += '<i class="fa fa-trash-o fa-margin"></i> <?php _trans("lable47"); ?></a></li>';
                            html += '</ul></div></td></tr>';
                        } 
                        html += '</tbody></table></tr>';
                    } 
                } 
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
        $("#popup_car_brand_id").val('');
        $("#popup_car_brand_model_id").val('');
        $('.bootstrap-select').selectpicker("refresh");
        searchFilter();
    });
});
</script>
<?php } ?>