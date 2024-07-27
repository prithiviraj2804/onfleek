<?php if(count($products) < 1) {  ?>
<div class= "row">
    <img class= "width40 marginleft_nodata" src="http://localhost/mechtool/assets/mp_backend/img/no_data_available.jpg" alt="Mechtoolz">
</div>
<div class="tbl-cell pull-right">
    <a class="btn btn-sm btn-primary" style="margin-right: 657px;" href="<?php echo site_url('suppliers_category/form'); ?>">
        <i class="fa fa-plus"></i> <?php _trans('label922'); ?>
    </a>
</div>
<?php } else { ?>
    <script type="text/javascript">
    $(function() {
        var getHeight = $( window ).height();
        $(".imageDynamicHeight").css('height' , getHeight - 200);
    });
</script>
<script>
function searchFilter(page_num) {
    page_num = page_num?page_num:0;
    var product_name = $('#product_name').val()?$('#product_name').val():'';
    var product_category_id = $("#product_category_id").val()?$("#product_category_id").val():'';

    $.post('<?php echo site_url('products/ajax/get_filter_list'); ?>', {
        page : page_num,
        product_name : product_name,
        product_category_id : product_category_id,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            var html = '';
            html += '<div class="overflowScrollForTable">';
            html += '<div class="col-xl-12 col-lg-12 col-sm-12 col-md-12 col-xs-12">';
            html += '<div class="row thead">';
            html += '<div class="th text_align_left col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2"><?php _trans("lable25"); ?></div>';
            html += '<div class="th text_align_left col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2"><?php _trans("lable210"); ?></div>';
            html += '<div class="th col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text-center"><?php _trans("lable218"); ?></div>';
            html += '<div class="th text_align_right col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text-center"><?php _trans("lable225"); ?></div>';
            html += '<div class="th col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text-center"><?php _trans("lable27"); ?></div>';
            html += '<div class="th col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text-center"><?php _trans("lable22"); ?></div>';
            html += '</div>';
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
                    
                    html += '<div class="row">';

                    if(list.products[v].subproducts.length > 0){ 
                        html += '<div class="td textEclip col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 pointer" data-original-title="'+(list.products[v].product_name?list.products[v].product_name:"")+'" data-toggle="tooltip"><span class="themeTextColor" data-toggle="collapse" data-target="#accordion_'+list.products[v].product_id+'">'+(list.products[v].product_name?list.products[v].product_name:"")+'</span></div>';
                    }else{
                        html += '<div class="td textEclip col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2" data-original-title="'+(list.products[v].product_name?list.products[v].product_name:"")+'" data-toggle="tooltip">'+(list.products[v].product_name?list.products[v].product_name:"")+'</div>';
                    }
                    html += '<div class="td textEclip col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2" data-original-title="'+(list.products[v].family_name?list.products[v].family_name:"")+'" data-toggle="tooltip">'+(list.products[v].family_name?list.products[v].family_name:"")+'</div>';
                    html += '<div class="td text-center col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2" data-original-title="'+(list.products[v].hsn_code?list.products[v].hsn_code:"")+'" data-toggle="tooltip">'+(list.products[v].hsn_code?list.products[v].hsn_code:"")+'</div>';
                    html += '<div class="td text-right col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata("default_currency_code")); ?>&nbsp;'+format_money((list.products[v].sale_price?list.products[v].sale_price:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'" data-toggle="tooltip" class="textEllipsis" ><?php echo $this->mdl_settings->currencychanger($this->session->userdata("default_currency_code")); ?>&nbsp;'+format_money((list.products[v].sale_price?list.products[v].sale_price:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'</div>';
                    html += '<div class="td text-center col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2" data-original-title="'+(list.products[v].balance_stock?list.products[v].balance_stock:"0")+'" data-toggle="tooltip">'+(list.products[v].balance_stock?list.products[v].balance_stock:"0")+'</div>';
                    html += '<div class="td text-center col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2">';
                    html += '<div class="options btn-group '+dropup+'">';
                    html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
                    html += '<ul class="optionTag dropdown-menu">';
                    if(list.work_shop_id == 1 && list.user_type == 1){
                        html += '<li><a href="<?php echo site_url("products/form/'+list.products[v].product_id+'"); ?>">';
                        html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable44"); ?></a></li>';
                        html += '<li><a href="javascript:void(0)" onclick="delete_record(\'products\',\''+list.products[v].product_id+'\',\'<?= $this->security->get_csrf_hash() ?>\')">';
                        html += '<i class="fa fa-trash-o fa-margin"></i> <?php _trans("lable47"); ?></a></li>';
                    }else if(list.work_shop_id == list.products[v].workshop_id ){
                        html += '<li><a href="<?php echo site_url("products/form/'+list.products[v].product_id+'"); ?>">';
                        html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable44"); ?></a></li>';
                        html += '<li><a href="javascript:void(0)" onclick="delete_record(\'products\',\''+list.products[v].product_id+'\',\'<?= $this->security->get_csrf_hash() ?>\')">';
                        html += '<i class="fa fa-trash-o fa-margin"></i> <?php _trans("lable47"); ?></a></li>';
                    }
                    if(list.workshop_is_enabled_inventory == 'Y'&& ( list.products[v].subproducts.length == 0 || list.products[v].subproducts.length == "" )){
                        html += '<li><a href="<?php echo site_url("products/view_inventory/'+list.products[v].product_id+'"); ?>">';
                        html += '<i class="fa fa-line-chart"></i> <?php _trans("lable213"); ?></a></li>';
                        html += '<li><a href="javascript:void(0)" class="add_reduce_stock" data-page-from="index" data-product-id="'+list.products[v].product_id+'" data-action-type="add_stock">';
                        html += '<i class="fa fa-plus-circle"></i> <?php _trans('lable214'); ?></a></li>';
                        html += '<li><a href="javascrip:void(0)" class="add_reduce_stock" data-page-from="index" data-product-id="'+list.products[v].product_id+'" data-action-type="reduce_stock">';
                        html += '<i class="fa fa-minus-circle fa-margin"></i> <?php _trans("lable215"); ?></a></li>';
                    }
                    html += '</ul></div></div></div>';
                    if(list.products[v].subproducts.length > 0){
                        html += '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 paddingTop10px rowBorder collapse" id="accordion_'+list.products[v].product_id+'">';
                        html += '<div class="row thead">';
                        html += '<div class="th col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text_align_left"><?php _trans("lable882"); ?></div>';
                        html += '<div class="th col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text_align_center"><?php _trans("lable218"); ?></div>';
                        html += '<div class="th col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text_align_left"><?php _trans("lable229"); ?></div>';
                        html += '<div class="th col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text_align_left"><?php _trans("lable231"); ?></div>';
                        html += '<div class="th col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text_align_right"><?php _trans("lable225"); ?></div>';
                        html += '<div class="th col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text-center"><?php _trans("lable22"); ?></div>';
                        html += '</div>';
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
                            html += '<div class="row accordianBorder">';
                            html += '<div class="td textEclip col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2" data-original-title="'+list.products[v].subproducts[s].product_name+'" data-toggle="tooltip">'+list.products[v].subproducts[s].product_name+'</div>';
                            html += '<div class="td text-center col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2" data-original-title="'+(list.products[v].subproducts[s].hsn_code?list.products[v].subproducts[s].hsn_code:"")+'" data-toggle="tooltip">'+(list.products[v].subproducts[s].hsn_code?list.products[v].subproducts[s].hsn_code:"")+'</div>';
                            html += '<div class="td text_align_left col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2" data-original-title="'+(list.products[v].subproducts[s].brand_name?list.products[v].subproducts[s].brand_name:"")+'" data-toggle="tooltip">'+(list.products[v].subproducts[s].brand_name?list.products[v].subproducts[s].brand_name:"")+'</div>';
                            html += '<div class="td text_align_left col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2" data-original-title="'+(list.products[v].subproducts[s].variant_name?list.products[v].subproducts[s].variant_name:"")+'" data-toggle="tooltip">'+(list.products[v].subproducts[s].variant_name?list.products[v].subproducts[s].variant_name:"")+'</div>';
                            html += '<div class="td text_align_right col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;'+format_money((list.products[v].subproducts[s].sale_price?list.products[v].subproducts[s].sale_price:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'" data-toggle="tooltip"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;'+format_money((list.products[v].subproducts[s].sale_price?list.products[v].subproducts[s].sale_price:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'</div>';
                            html += '<div class="td text-center col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2">';
                            html += '<div class="options btn-group '+dropup_sub+'">';
                            html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
                            html += '<ul class="optionTag dropdown-menu">';
                            if(list.work_shop_id == 1 && list.user_type == 1){
                                html += '<li><a href="javascript:void(0)" onclick="delete_record(\'products\',\''+list.products[v].subproducts[s].product_id+'\',\'<?= $this->security->get_csrf_hash() ?>\')">';
                                html += '<i class="fa fa-trash-o fa-margin"></i> <?php _trans("lable47"); ?></a></li>';
                            }else if(list.work_shop_id == list.products[v].workshop_id){
                                html += '<li><a href="javascript:void(0)" onclick="delete_record(\'products\',\''+list.products[v].subproducts[s].product_id+'\',\'<?= $this->security->get_csrf_hash() ?>\')">';
                                html += '<i class="fa fa-trash-o fa-margin"></i> <?php _trans("lable47"); ?></a></li>';
                            }
                            if(list.workshop_is_enabled_inventory == 'Y'){
                                html += '<li><a href="<?php echo site_url("products/view_inventory/'+list.products[v].subproducts[s].product_id+'"); ?>">';
                                html += '<i class="fa fa-line-chart"></i> <?php _trans("lable213"); ?></a></li>';
                                html += '<li><a href="javascript:void(0)" class="add_reduce_stock" data-page-from="index" data-product-id="'+list.products[v].subproducts[s].product_id+'" data-action-type="add_stock">';
                                html += '<i class="fa fa-plus-circle"></i> <?php _trans('lable214'); ?></a></li>';
                                html += '<li><a href="javascrip:void(0)" class="add_reduce_stock" data-page-from="index" data-product-id="'+list.products[v].subproducts[s].product_id+'" data-action-type="reduce_stock">';
                                html += '<i class="fa fa-minus-circle fa-margin"></i> <?php _trans("lable215"); ?></a></li>';
                            }
                            html += '</ul></div></div></div>';
                        } 
                        html += '</div>';
                    } 
                } 
            }else{
                html += '<div class="row thead"></div>';
            }
            html += '</div></div>';
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
</script>

<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php _trans('lable206'); ?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-sm btn-primary" href="<?php echo site_url('products/form'); ?>">
                        <i class="fa fa-plus"></i> <?php _trans('lable40'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>   
<div id="content" class="table-content">
    <section class="card">
        <div class="card-block">
            <div class="row col-xl-12 col-lg-12 col-md-12 col-sm-12 padding0px">
                <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable207'); ?></label>
                    <div class="form_controls">
                        <input onkeyup="searchFilter()" type="text" name="product_name" id="product_name" class="form-control" value="<?php echo $name;?>" autocomplete="off">
                    </div>
                </div>
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable208'); ?></label>
                    <div class="form_controls">
                        <select onchange="searchFilter()" name="product_category_id" id="product_category_id" class="searchSelect bootstrap-select bootstrap-select-arrow g-input" data-live-search="true">
                            <option value=""><?php _trans('lable209'); ?></option>
                            <?php foreach ($families as $family) { ?>
                                <option value="<?php echo $family->family_id; ?>" <?php check_select($cat, $family->family_id); ?>><?php echo $family->family_name; ?></option>
                            <?php } ?>
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
            <div id="posts_content" class="table datatable">
                <div class="overflowScrollForTable">
                    <div class="col-xl-12 col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <div class="row thead">
                            <div class="th col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text_align_left"><?php echo trans('lable25'); ?></div>
                            <div class="th col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text_align_left"><?php echo trans('lable210'); ?></div>
                            <div class="th col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text-center"><?php echo trans('lable218'); ?></div>
                            <div class="th col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text_align_right"><?php echo trans('lable225'); ?></div>
                            <div class="th col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text-center"><?php echo trans('lable27'); ?></div>
                            <div class="th col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text-center"><?php echo trans('lable22'); ?></div>
                        </div>
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
                        <div class="row ">
                            <?php if(count($product->subproducts) > 0){ ?>
                                <div class="td textEclip col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 pointer" data-original-title="<?php _htmlsc($product->product_name); ?>" data-toggle="tooltip"><span class="themeTextColor" data-toggle="collapse" data-target="#accordion_<?php echo $product->product_id; ?>" ><?php  _htmlsc($product->product_name); ?></span></div>
                            <?php }else{ ?>
                                <div class="td textEclip col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2" data-original-title="<?php _htmlsc($product->product_name); ?>" data-toggle="tooltip"><span><?php  _htmlsc($product->product_name); ?></span></div>
                            <?php } ?>
                            <div class="td textEclip col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text-left" data-original-title="<?php _htmlsc($product->family_name); ?>" data-toggle="tooltip"><?php _htmlsc($product->family_name); ?></div>
                            <div class="td text-center col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text-center" data-original-title="<?php _htmlsc($product->hsn_code); ?>" data-toggle="tooltip"><?php _htmlsc($product->hsn_code); ?></div>
                            <div class="td text-center col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text-right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($product->sale_price,$this->session->userdata('default_currency_digit')); ?>" data-toggle="tooltip"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($product->sale_price,$this->session->userdata('default_currency_digit')); ?></div>
                            <div class="td text-center col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2" data-original-title="<?php _htmlsc($product->balance_stock ? $product->balance_stock : '0');?>" data-toggle="tooltip"><?php _htmlsc($product->balance_stock ? $product->balance_stock : '0'); ?></div>
                            <div class="td text-center col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2">
                                <div class="options btn-group <?php echo $dropup; ?>">
                                    <a class="btn btn-default btn-sm dropdown-toggle"
                                    data-toggle="dropdown" href="#">
                                        <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                    </a>
                                    <ul class="optionTag dropdown-menu">
                                        <?php if ($this->session->userdata('work_shop_id') == 1 && $this->session->userdata('user_type') == 1) { ?>
                                        <li>
                                            <a href="<?php echo site_url('products/form/'.$product->product_id); ?>">
                                                <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" onclick="delete_record('products',<?php echo $product->product_id; ?>,'<?= $this->security->get_csrf_hash() ?>');">
                                                <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?>
                                            </a>
                                        </li>
                                        <?php } else if ($this->session->userdata('work_shop_id') == $product->workshop_id) { ?>
                                        <li>
                                            <a href="<?php echo site_url('products/form/'.$product->product_id); ?>">
                                                <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" onclick="delete_record('products',<?php echo $product->product_id; ?>,'<?= $this->security->get_csrf_hash() ?>');">
                                                <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?>
                                            </a>
                                        </li>
                                        <?php } if ($this->session->userdata('workshop_is_enabled_inventory') == 'Y' && ( count($product->subproducts) == 0 || count($product->subproducts) == "" )) {?>
                                        <li>
                                            <a href="<?php echo site_url('products/view_inventory/'.$product->product_id); ?>">
                                                <i class="fa fa-line-chart"></i> <?php _trans('lable213'); ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" class="add_reduce_stock" data-page-from="index" data-product-id="<?php echo $product->product_id; ?>" data-action-type="add_stock">
                                                <i class="fa fa-plus-circle"></i> <?php _trans('lable214'); ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascrip:void(0)" class="add_reduce_stock" data-page-from="index" data-product-id="<?php echo $product->product_id; ?>" data-action-type="reduce_stock">
                                                <i class="fa fa-minus-circle fa-margin"></i> <?php _trans('lable215'); ?>
                                            </a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <?php if(count($product->subproducts) > 0){ ?>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 paddingTop10px paddingBot10px rowBorder collapse" id="accordion_<?php echo $product->product_id;?>">
                            <div class="row thead " >
                                <div class="th col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text_align_left"><?php echo trans('lable882'); ?></div>
                                <div class="th col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2"><?php echo trans('lable218'); ?></div>
                                <div class="th col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text_align_left"><?php echo trans('lable229'); ?></div>
                                <div class="th col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text_align_left"><?php echo trans('lable231'); ?></div>
                                <div class="th col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text_align_right"><?php echo trans('lable225'); ?></div>
                                <div class="th col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text-center"><?php echo trans('lable22'); ?></div>
                            </div>
                            <?php foreach($product->subproducts as $subpro){ ?>
                            <div class=" row accordianBorder" >
                                <div class="td textEclip col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text_align_left" data-original-title="<?php _htmlsc($subpro->product_name); ?>" data-toggle="tooltip"><?php _htmlsc($subpro->product_name); ?></div>
                                <div class="td textEclip col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text-center" data-original-title="<?php _htmlsc($subpro->hsn_code); ?>" data-toggle="tooltip"><?php _htmlsc($subpro->hsn_code); ?></div>
                                <div class="td textEclip text-left col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2" data-original-title="<?php _htmlsc($subpro->brand_name); ?>" data-toggle="tooltip"><?php _htmlsc($subpro->brand_name); ?></div>
                                <div class="td text-left col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2" data-original-title="<?php _htmlsc($subpro->model_name); ?>" data-toggle="tooltip"><?php _htmlsc($subpro->model_name); ?></div>
                                <div class="td text-right col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($subpro->sale_price,$this->session->userdata('default_currency_digit')); ?>" data-toggle="tooltip"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($subpro->sale_price,$this->session->userdata('default_currency_digit')); ?></div>
                                <div class="td text-center col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2">
                                    <div class="options btn-group <?php echo $dropup; ?>">
                                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-cog"></i> <?php _trans('lable22'); ?></a>
                                        <ul class="optionTag dropdown-menu">
                                            <?php if ($this->session->userdata('work_shop_id') == 1 && $this->session->userdata('user_type') == 1) { ?>
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_record('products',<?php echo $subpro->product_id; ?>,'<?= $this->security->get_csrf_hash() ?>');">
                                                    <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?>
                                                </a>
                                            </li>
                                            <?php }else if ($this->session->userdata('work_shop_id') == $subpro->workshop_id) { ?>
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_record('products',<?php echo $subpro->product_id; ?>,'<?= $this->security->get_csrf_hash() ?>');">
                                                    <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?>
                                                </a>
                                            </li>
                                            <?php }?>
                                            <?php if ($this->session->userdata('workshop_is_enabled_inventory') == 'Y') {?>
                                            <li>
                                                <a href="<?php echo site_url('products/view_inventory/'.$subpro->product_id); ?>">
                                                    <i class="fa fa-line-chart"></i> <?php _trans('lable213'); ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" class="add_reduce_stock" data-page-from="index" data-product-id="<?php echo $subpro->product_id; ?>" data-action-type="add_stock">
                                                    <i class="fa fa-plus-circle"></i> <?php _trans('lable214'); ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascrip:void(0)" class="add_reduce_stock" data-page-from="index" data-product-id="<?php echo $subpro->product_id; ?>" data-action-type="reduce_stock">
                                                    <i class="fa fa-minus-circle fa-margin"></i> <?php _trans('lable215'); ?>
                                                </a>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                         <?php } ?>
                        </div>
                    <?php } $i++; } } ?>
                    </div>
                </div>
                <div class="headerbar-item pull-right paddingTop20px">
                    <?php echo $createLinks;?>
                </div>
            </div>
        </div>
	</section>
</div>
<script>

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
        $("#product_name").val('');
        $("#product_category_id").val('');
        $('.bootstrap-select').selectpicker("refresh");
        searchFilter();
    });

});
</script>
<?php } ?>