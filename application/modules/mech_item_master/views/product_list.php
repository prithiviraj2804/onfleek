<?php if(count($products) < 1) {  ?>
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
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_item_master/product_create'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('label925'); ?>
            </a>
        </div>
    </div>
</div>
<?php } else { ?>
<script>
function searchFilter(page_num) {
    page_num = page_num?page_num:0;
    var product_name = $('#product_name').val()?$('#product_name').val():'';
    var part_number = $('#part_number').val()?$('#part_number').val():'';
    var product_category_id = $("#product_category_id").val()?$("#product_category_id").val():'';
    var rack_no = $('#rack_no').val()?$('#rack_no').val():'';
    var popup_car_brand_id = $('#popup_car_brand_id').val()?$('#popup_car_brand_id').val():'';
    var popup_car_brand_model_id = $('#popup_car_brand_model_id').val()?$('#popup_car_brand_model_id').val():'';

    $('#gif').show();
    $.post('<?php echo site_url('mech_item_master/ajax/get_product_filter_list'); ?>', {
        page : page_num,
        product_name : product_name,
        part_number : part_number,
        product_category_id : product_category_id,
        rack_no : rack_no,
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
            html += '<th class="text_align_left"><?php echo trans("lable25"); ?></th>';
            html += '<th class="text_align_left"><?php echo trans("lable208"); ?></th>';
            html += '<th style="column-width:30px;" class="text_align_left"><?php echo trans("lable177"); ?></th>';
            html += '<th class="text_align_center"><?php echo trans("lable1024"); ?></th>';
            html += '<th class="text_align_center"><?php echo trans("lable223"); ?></th>';
            html += '<th class="text_align_center"><?php echo trans("lable225"); ?></th>';
            html += '<th class="text_align_center"><?php echo trans("lable27"); ?></th>';
            html += '<th class="text_align_center"><?php echo trans("lable22"); ?></th></tr></thead>';
            html += ' <tbody>';
            if(list.products.length > 0){
                for(var v=0; v < list.products.length; v++){ 
                    if(list.products.length >= 4)
                    {    
                        if(list.products.length == v || list.products.length == v+1)
                        {
                            var dropup = "dropup";
                        }
                        else
                        {
                            var dropup = "";
                        }
                    }    
                    
                    html += '<tr>';
                    if(list.products[v].subproducts.length > 0){ 
                        html += '<td class="textEclip pointer" data-original-title="'+(list.products[v].product_name?list.products[v].product_name:"")+'" data-toggle="tooltip"><span class="themeTextColor" data-toggle="collapse" data-target="#accordion_'+list.products[v].product_id+'">'+(list.products[v].product_name?list.products[v].product_name:"")+'</span></td>';
                    }else{
                        html += '<td data-original-title="'+(list.products[v].product_name?list.products[v].product_name:"")+'" data-toggle="tooltip" class="textEllipsis">'+(list.products[v].product_name?list.products[v].product_name:"")+'</td>';
                    }
                    html += '<td data-original-title="'+(list.products[v].family_name?list.products[v].family_name:"")+'" data-toggle="tooltip" class="textEllipsis text_align_left">'+(list.products[v].family_name?list.products[v].family_name:"")+'</td>';
                    html += '<td style="column-width:30px;" class="textEllipsis" data-original-title="'+(list.products[v].description?list.products[v].description:"")+'" data-toggle="tooltip">'+(list.products[v].description?list.products[v].description:"")+'</td>';
                    html += '<td data-original-title="'+(list.products[v].part_number?list.products[v].part_number:"")+'" data-toggle="tooltip" class="textEllipsis text_align_center">'+(list.products[v].part_number?list.products[v].part_number:"")+'</td>';
                    html += '<td data-original-title="'+(list.products[v].rack_no?list.products[v].rack_no:"")+'" data-toggle="tooltip" class="textEllipsis text_align_center">'+(list.products[v].rack_no?list.products[v].rack_no:"")+'</td>';

                    var sale_price = list.products[v].sale_price?list.products[v].sale_price:0;
                    var sale = list.products[v].sale?list.products[v].sale:0;
                    var default_sale_price = list.products[v].default_sale_price?list.products[v].default_sale_price:0;
                    var spmin = sale_price?sale_price:sale;
                    var sp = spmin?spmin:default_sale_price;

                    html += '<td class="text_align_right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata("default_currency_code")); ?>&nbsp;'+format_money((sp?sp:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'" data-toggle="tooltip" class="textEllipsis" ><?php echo $this->mdl_settings->currencychanger($this->session->userdata("default_currency_code")); ?>&nbsp;'+format_money((sp?sp:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'</td>';
                    html += '<td class="text_align_center" data-original-title="'+(list.products[v].balance_stock?list.products[v].balance_stock:"0")+'" data-toggle="tooltip">'+(list.products[v].balance_stock?list.products[v].balance_stock:"0")+'</td>';
                    html += '<td class="text_align_center">';
                    html += '<div class="options btn-group '+dropup+'">';
                    html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
                    html += '<ul class="optionTag dropdown-menu">';
                    html += '<li><a href="<?php echo site_url("mech_item_master/product_create/'+list.products[v].product_id+'"); ?>">';
                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable44"); ?></a></li>';
                    if(list.work_shop_id == 1 && list.user_type == 1){
                        html += '<li><a href="javascript:void(0)" onclick="delete_record(\'mech_item_master\',\''+list.products[v].product_id+'\',\'<?= $this->security->get_csrf_hash() ?>\')">';
                        html += '<i class="fa fa-trash-o fa-margin"></i> <?php _trans("lable47"); ?></a></li>';
                    }else if(list.work_shop_id == list.products[v].workshop_id ){
                        html += '<li><a href="javascript:void(0)" onclick="delete_record(\'mech_item_master\',\''+list.products[v].product_id+'\',\'<?= $this->security->get_csrf_hash() ?>\')">';
                        html += '<i class="fa fa-trash-o fa-margin"></i> <?php _trans("lable47"); ?></a></li>';
                    }
                    if(list.workshop_is_enabled_inventory == 'Y'){
                        html += '<li><a href="<?php echo site_url("mech_item_master/view_inventory/'+list.products[v].product_id+'"); ?>">';
                        html += '<i class="fa fa-line-chart"></i> <?php _trans("lable213"); ?></a></li>';
                        html += '<li><a href="javascript:void(0)" class="add_reduce_stock" data-page-from="index" data-product-id="'+list.products[v].product_id+'" data-action-type="add_stock" data-purchase-price="'+list.products[v].cost_price+'">';
                        html += '<i class="fa fa-plus-circle"></i> <?php _trans('lable214'); ?></a></li>';
                        html += '<li><a href="javascrip:void(0)" class="add_reduce_stock" data-page-from="index" data-product-id="'+list.products[v].product_id+'" data-action-type="reduce_stock" data-purchase-price="'+list.products[v].cost_price+'">';
                        html += '<i class="fa fa-minus-circle fa-margin"></i> <?php _trans("lable215"); ?></a></li>';
                    }
                    html += '</ul></div></td></tr>';
                   
                    if(list.products[v].subproducts.length > 0){
                        html += '<tr width="100%" class="paddingTop10px rowBorder collapse" id="accordion_'+list.products[v].product_id+'">';
                        html += '<td width="100%" colspan="7"><table width="100%"><thead width="100%"><tr width="100%">'
                        html += '<th class="text_align_left"><?php _trans("lable229"); ?></th>';
                        html += '<th class="text_align_left"><?php _trans("lable231"); ?></th>';
                        html += '<th class="text_align_left"><?php _trans("lable232"); ?></th>';
                        html += '<th class="text_align_left"><?php _trans("lable132"); ?></th>';
                        html += '<th class="text_align_left"><?php echo ("Year"); ?></th>';
                        html += '<th class="text-center"><?php _trans("lable22"); ?></th>';
                        html += '</td></tr></thead><tbody width="100%">';
                        for(var s = 0; s < list.products[v].subproducts.length; s++){
                            if(list.products[v].subproducts.length >= 4)
                            {    
                                if(list.products[v].subproducts.length == s || list.products[v].subproducts.length == s+1)
                                {
                                    var dropup_sub = "dropup";
                                }
                                else
                                {
                                    var dropup_sub = "";
                                }
                            }
                            html += '<tr width="100%">';
                            html += '<td class="text_align_left" data-original-title="'+(list.products[v].subproducts[s].brand_name?list.products[v].subproducts[s].brand_name:'')+'" data-toggle="tooltip">'+(list.products[v].subproducts[s].brand_name?list.products[v].subproducts[s].brand_name:'')+'</td>';
                            html += '<td class="text_align_left" data-original-title="'+(list.products[v].subproducts[s].model_name?list.products[v].subproducts[s].model_name:"")+'" data-toggle="tooltip">'+(list.products[v].subproducts[s].model_name?list.products[v].subproducts[s].model_name:"")+'</td>';
                            html += '<td class="text_align_left" data-original-title="'+(list.products[v].subproducts[s].variant_name?list.products[v].subproducts[s].variant_name:"")+'" data-toggle="tooltip">'+(list.products[v].subproducts[s].variant_name?list.products[v].subproducts[s].variant_name:"")+'</td>';
                            html += '<td class="text_align_left" data-original-title="';
                            if(list.products[v].subproducts[s].fuel_type == 'P'){
                                html += 'Petrol';
                            }else if(list.products[v].subproducts[s].fuel_type == 'D'){
                                html += 'Diesel';
                            }else if(list.products[v].subproducts[s].fuel_type == 'O'){
                                html += 'Others';
                            }
                            html += 'data-toggle="tooltip">';
                            if(list.products[v].subproducts[s].fuel_type == 'P'){
                                html += 'Petrol';
                            }else if(list.products[v].subproducts[s].fuel_type == 'D'){
                                html += 'Diesel';
                            }else if(list.products[v].subproducts[s].fuel_type == 'O'){
                                html += 'Others';
                            }
                            html += '</td>';
                            html += '<td data-original-title="'+(list.products[v].subproducts[s].year?list.products[v].subproducts[s].year:"")+'" data-toggle="tooltip">'+(list.products[v].subproducts[s].year?list.products[v].subproducts[s].year:"")+'</div>';
                            html += '<td class="text-center">';
                            html += '<div class="options btn-group '+dropup_sub+'">';
                            html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
                            html += '<ul class="optionTag dropdown-menu">';
                                html += '<li><a href="javascript:void(0)" onclick="delete_record(\'mech_sub_item_master\',\''+list.products[v].subproducts[s].product_map_id+'\',\'<?= $this->security->get_csrf_hash() ?>\')">';
                                html += '<i class="fa fa-trash-o fa-margin"></i> <?php _trans("lable47"); ?></a></li>';
                            html += '</ul></div></td></tr>';
                        } 
                        html += '</tbody></table></td></tr>';
                    } 
                } 
            }else{
                html += '<tr><td colspan="6" class="text-center" > No data found </td></tr>';
            }
            html += '</tbody></table></div>';
            html += '<div class="headerbar-item pull-right paddingTop20px">';
            html += list.createLinks;
            html += '</div>';
            $('#posts_content').html(html);
            $('#gif').hide();
        }
    });

    $('body').on('mouseenter', '.table', function () {
        $(".datatable [data-toggle='tooltip']").tooltip();
    });
}
</script>

<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php _trans('lable206'); ?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_item_master/product_upload/new'); ?>">
                        <i class="fa fa-cloud-upload"></i>
                    </a>
                    <a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_item_master/product_create'); ?>">
                        <i class="fa fa-plus"></i> <?php _trans('lable40'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>  
<div id="content" class="table-content">
    <div id="gif" class="gifload">
        <div class="gifcenter">
            <center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
        </div>
    </div>
    <section class="card">
        <div class="card-block">
            <div class="row col-xl-12 col-lg-12 col-md-12 col-sm-12 padding0px">
                <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable207'); ?></label>
                    <div class="form_controls">
                        <input type="text" name="product_name" id="product_name" class="form-control" value="<?php echo $name;?>" autocomplete="off">
                    </div>
                </div>
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable1024'); ?></label>
                    <div class="form_controls">
                        <input type="text" name="part_number" id="part_number" class="form-control" value="<?php echo $part_number;?>" autocomplete="off">
                    </div>
                </div>
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable208'); ?></label>
                    <div class="form_controls">
                        <select name="product_category_id" id="product_category_id" class="searchSelect bootstrap-select bootstrap-select-arrow g-input" data-live-search="true">
                            <option value=""><?php _trans('lable209'); ?></option>
                            <?php foreach ($families as $family) { ?>
                                <option value="<?php echo $family->family_id; ?>" <?php check_select($cat, $family->family_id); ?>><?php echo $family->family_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable223'); ?></label>
                    <div class="form_controls">
                        <input onchange="searchFilter()" type="text" name="rack_no" id="rack_no" class="form-control" value="<?php echo $rack_no;?>" autocomplete="off">
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
                    <div class="form_controls paddingTop18px">
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
                            <th class="text_align_left"><?php echo trans('lable25'); ?></div>
                            <th class="text_align_left"><?php echo trans('lable208'); ?></div>
                            <th style="column-width:30px;" class="text_align_left"><?php echo trans('lable177'); ?></div> 
                            <th class="text_align_center"><?php echo trans('lable1024'); ?></div>
                            <th class="text_align_center"><?php echo trans('lable223'); ?></div>
                            <th class="text_align_right"><?php echo trans('lable225'); ?></div>
                            <th class="text_align_center"><?php echo trans('lable27'); ?></div>
                            <th class="text_align_center"><?php echo trans('lable22'); ?></div>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($products) > 0){
                            $i = 1;
                            foreach ($products as $key => $product) {
                                if(count($products) >= 4)
                                {  
                                    if(count($products) == $i || count($products) == $i+1)
                                    {
                                        $dropup = "dropup";
                                    }
                                    else
                                    {
                                        $dropup = "";
                                    }
                                } ?>
                        <tr> 
                            <?php if(count($product->subproducts) > 0){ ?>
                                <td class="textEclip pointer" data-original-title="<?php _htmlsc($product->product_name); ?>" data-toggle="tooltip"><span class="themeTextColor" data-toggle="collapse" data-target="#accordion_<?php echo $product->product_id; ?>" ><?php  _htmlsc($product->product_name); ?></span></td>
                            <?php }else{ ?>
                                 <td class="textEclip" data-original-title="<?php _htmlsc($product->product_name); ?>" data-toggle="tooltip"><span><?php  _htmlsc($product->product_name); ?></span></td>
                            <?php } ?>
                            <td class="textEclip text-left" data-original-title="<?php _htmlsc($product->family_name); ?>" data-toggle="tooltip"><?php _htmlsc($product->family_name); ?></td>
                            <td style="column-width:30px;" class="textEclip text-left" data-original-title="<?php _htmlsc($product->description); ?>" data-toggle="tooltip"><?php _htmlsc($product->description); ?></td>
                            <td class="textEclip text-center" data-original-title="<?php _htmlsc($product->part_number); ?>" data-toggle="tooltip"><?php _htmlsc($product->part_number); ?></td>
                            <td class="textEclip text-center" data-original-title="<?php _htmlsc($product->rack_no); ?>" data-toggle="tooltip"><?php _htmlsc($product->rack_no); ?></td>

                            <?php   $sale_price = 0;
                                    $sale_price = $product->sale_price?$product->sale_price:''; ?>
                            <?php   $sale = 0;
                                    $sale = $product->sale?$product->sale:''; ?>
                            <?php   $default_sale_price = 0;
                                    $default_sale_price = $product->default_sale_price?$product->default_sale_price:''; ?>
                            <?php   $spmin = $sale_price?$sale_price:$sale; ?>
                            <?php   $sp = $spmin?$spmin:$default_sale_price; ?>
                                                
                            <td class="text-right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($sp?$sp:0),$this->session->userdata('default_currency_digit')); ?>" data-toggle="tooltip"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($sp?$sp:0),$this->session->userdata('default_currency_digit')); ?></td>
                            <td class="text-center" data-original-title="<?php _htmlsc($product->balance_stock ? $product->balance_stock : '0');?>" data-toggle="tooltip"><?php _htmlsc($product->balance_stock ? $product->balance_stock : '0'); ?></td>
                            <td class="text-center">
                                <div class="options btn-group <?php echo $dropup; ?>">
                                    <a class="btn btn-default btn-sm dropdown-toggle"
                                    data-toggle="dropdown" href="#">
                                        <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                    </a>
                                    <ul class="optionTag dropdown-menu">
                                        <li>
                                            <a href="<?php echo site_url('mech_item_master/product_create/'.$product->product_id); ?>">
                                                <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                            </a>
                                        </li>
                                        <?php if ($this->session->userdata('work_shop_id') == 1 && $this->session->userdata('user_type') == 1) { ?>
                                        <li>
                                            <a href="javascript:void(0)" onclick="delete_record('mech_item_master',<?php echo $product->product_id; ?>,'<?= $this->security->get_csrf_hash() ?>');">
                                                <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?>
                                            </a>
                                        </li>
                                        <?php } else if ($this->session->userdata('work_shop_id') == $product->workshop_id) { ?>
                                        <li>
                                            <a href="javascript:void(0);" onclick="delete_record('mech_item_master',<?php echo $product->product_id; ?>,'<?= $this->security->get_csrf_hash() ?>');">
                                                <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?>
                                            </a>
                                        </li>
                                        <?php } if ($this->session->userdata('workshop_is_enabled_inventory') == 'Y') {?>
                                        <li>
                                            <a href="<?php echo site_url('mech_item_master/view_inventory/'.$product->product_id); ?>">
                                                <i class="fa fa-line-chart"></i> <?php _trans('lable213'); ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" class="add_reduce_stock" data-page-from="index" data-product-id="<?php echo $product->product_id; ?>" data-action-type="add_stock" data-purchase-price="<?php echo $product->cost_price; ?>">
                                                <i class="fa fa-plus-circle"></i> <?php _trans('lable214'); ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascrip:void(0)" class="add_reduce_stock" data-page-from="index" data-product-id="<?php echo $product->product_id; ?>" data-action-type="reduce_stock" data-purchase-price="<?php echo $product->cost_price; ?>">
                                                <i class="fa fa-minus-circle fa-margin"></i> <?php _trans('lable215'); ?>
                                            </a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php if(count($product->subproducts) > 0){ ?>
                        <tr width="100%" class="paddingTop10px paddingBot10px rowBorder collapse" id="accordion_<?php echo $product->product_id;?>">
                            <td width="100%" colspan="7">
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
                                        <?php foreach($product->subproducts as $subpro){ ?>
                                        <tr width="100%">
                                            <td class="text_align_left" data-original-title="<?php _htmlsc($subpro->brand_name); ?>" data-toggle="tooltip"><?php _htmlsc($subpro->brand_name); ?></td>
                                            <td class="text_align_left" data-original-title="<?php _htmlsc($subpro->model_name); ?>" data-toggle="tooltip"><?php _htmlsc($subpro->model_name); ?></td>
                                            <td class="text_align_left" data-original-title="<?php _htmlsc($subpro->variant_name); ?>" data-toggle="tooltip"><?php _htmlsc($subpro->variant_name); ?></td>
                                            <td class="text_align_left" data-original-title="<?php if($subpro->fuel_type == 'P'){ echo 'Petrol';}else if($subpro->fuel_type == 'D'){ echo 'Diesel';}else if($subpro->fuel_type == 'O'){ echo 'Other';} ?>" data-toggle="tooltip"><?php if($subpro->fuel_type == 'P'){ echo 'Petrol';}else if($subpro->fuel_type == 'D'){ echo 'Diesel';}else if($subpro->fuel_type == 'O'){ echo 'Other';} ?></td>
                                            <td class="text_align_left" data-original-title="<?php echo $subpro->year; ?>" data-toggle="tooltip"><?php echo $subpro->year; ?></td>
                                            <td class="text-center">
                                                <div class="options btn-group <?php echo $dropup; ?>">
                                                    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php _trans('lable22'); ?></a>
                                                    <ul class="optionTag dropdown-menu">
                                                        <li>
                                                            <a href="javascript:void(0)" onclick="delete_record('mech_sub_item_master',<?php echo $subpro->product_map_id; ?>,'<?= $this->security->get_csrf_hash() ?>');">
                                                                <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
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
                </div>
                <div class="headerbar-item pull-right paddingTop20px">
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
        $('#gif').hide();
        $("#product_name").val('');
        $("#part_number").val('');
        $("#product_category_id").val('');
        $("#rack_no").val('');
        $("#popup_car_brand_id").val('');
        $("#popup_car_brand_model_id").val('');
        $('.bootstrap-select').selectpicker("refresh");
        searchFilter();
    });

});
</script>
<?php } ?>