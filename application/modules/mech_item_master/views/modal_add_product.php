<input type="hidden" name="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>"autocomplete="off">
<script type="text/javascript">
var yourArray = [];
var entity_type = '<?php echo $entity_type; ?>';
var entity_id = '<?php echo $entity_id;?>';
var custm_id = '<?php echo  $customer_id; ?>';

function produfilt(){
    var product_name = $('#product_name').val()?$('#product_name').val():'';
    if(product_name.length > 3){
        searchFilter();
    }else if(product_name.length == 0){
        searchFilter();
    }
}

function sentProductTable(){
    if(yourArray.length  > 0){
        $('#gif').show();
        $.post('<?php echo site_url('mech_item_master/ajax/get_selected_product_list'); ?>', {
            yourArray : yourArray,
            _mm_csrf: $('#_mm_csrf').val()
        }, function (data) {	
            list = JSON.parse(data);
            if(list.products != '' && list.products.length > 0){
                popupproducts(list.products);
                $('.modal').remove();
                $('.modal-backdrop').remove();
                $('body').removeClass( "modal-open" );
            }
            $('#gif').hide();
        });
    }
}

function searchFilter(page_num) {

    page_num = page_num?page_num:0;
    var product_name = $('#product_name').val()?$('#product_name').val():'';
    var part_number = $('#part_number').val()?$('#part_number').val():'';
    var product_category_id = $("#product_category_id").val()?$("#product_category_id").val():'';
    var brand_id = $("#brand_id").val()?$("#brand_id").val():'';
    var model_id = $("#model_id").val()?$("#model_id").val():'';
    var variant_id = $("#variant_id").val()?$("#variant_id").val():'';
    var fuel_type = $("#fuel_type").val()?$("#fuel_type").val():'';
    var product_brand_id = $("#product_brand_id").val()?$("#product_brand_id").val():'';

    $('#gif').show();
    $.post('<?php echo site_url('mech_item_master/ajax/get_product_filter_list'); ?>', {
        page : page_num,
        entity_type: entity_type,
        entity_id : entity_id,
        customer_id : custm_id,
        product_name : product_name,
        part_number : part_number,
        product_category_id : product_category_id,
        brand_id: brand_id,
        model_id : model_id,
        variant_id: variant_id,
        fuel_type : fuel_type,
        product_brand_id : product_brand_id,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            var html = '';
            html += '<div class="overflowScrollForTableProduct">';
            html += '<div class="col-xl-12 col-lg-12 col-sm-12 col-md-12 col-xs-12">';
            html += '<table width="100%" style="width: 100%;">';
            html += '<thead><tr>';
            html += '<th><input type="checkbox" class="all_product" id="all_product"></th>';
            html += '<th><?php echo trans("lable25"); ?></th>';
            html += '<th><?php echo trans("lable1024"); ?></th>';
            html += '<th><?php echo trans("lable225"); ?></th></tr></thead>';
            html += ' <tbody>';
            if(list.products.length > 0){
                for(var v=0; v < list.products.length; v++){ 
                    html += '<tr>';
                    html += '<td><input ';
                    if(list.product_list.length > 0){
                        for(var j=0; j < list.product_list.length; j++){
                            if(entity_type == 'P'){
                                if(parseInt(list.product_list[j].product_id) == parseInt(list.products[v].product_id)){
                                    html += ' disabled ';
                                }
                            }else{
                                if(parseInt(list.product_list[j].service_item) == parseInt(list.products[v].product_id)){
                                    html += ' disabled ';
                                }
                            }
                            
                        }
                    }
                    html += ' type="checkbox"';
                    if (jQuery.inArray(list.products[v].product_id, yourArray)!='-1') {
                        html += 'checked ';
                    }
                    html += ' name="product_ids[]" class="product_ids product_'+list.products[v].product_id+'" id="product_'+list.products[v].product_id+'" value="'+list.products[v].product_id+'" ></td>';
                    if(list.products[v].subproducts.length > 0){ 
                        html += '<td class="cursor_pointer" data-original-title="'+(list.products[v].product_name?list.products[v].product_name:"")+'" data-toggle="tooltip"><span class="themeTextColor" data-toggle="collapse" data-target="#accordion_'+list.products[v].product_id+'">'+(list.products[v].product_name?list.products[v].product_name:"")+'</span></td>';
                    }else{
                        html += '<td data-original-title="'+(list.products[v].product_name?list.products[v].product_name:"")+'" data-toggle="tooltip">'+(list.products[v].product_name?list.products[v].product_name:"")+'</td>';
                    }
                    html += '<td data-original-title="'+(list.products[v].part_number?list.products[v].part_number:"")+'" data-toggle="tooltip">'+(list.products[v].part_number?list.products[v].part_number:"")+'</td>';
                    var sale_price = list.products[v].sale_price?list.products[v].sale_price:0;
                    var sale = list.products[v].sale?list.products[v].sale:0;
                    var default_sale_price = list.products[v].default_sale_price?list.products[v].default_sale_price:0;
                    var spmin = sale_price?sale_price:sale;
                    var sp = spmin?spmin:default_sale_price;
                    html += '<td data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata("default_currency_code")); ?>&nbsp;'+format_money((sp?sp:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'" data-toggle="tooltip" class="textEllipsis" ><?php echo $this->mdl_settings->currencychanger($this->session->userdata("default_currency_code")); ?>&nbsp;'+format_money((sp?sp:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'</td></tr>';
                    if(list.products[v].subproducts.length > 0){
                        html += '<tr>';
                        html += '<td colspan="4" style="border: none ! important">';
                        html += '<table width="100%" style="table-layout: fixed;width: 100%;" class="rowBorder collapse" id="accordion_'+list.products[v].product_id+'">';
                        html += '<thead>';
                        html += '<th><?php echo trans('lable229'); ?></th>';
                        html += '<th><?php echo trans('lable231'); ?></th>';
                        html += '<th><?php echo trans('lable232'); ?></th>';
                        html += '<th><?php echo trans('lable132'); ?></th>';
                        html += '<th><?php echo ('Year'); ?></th>';
                        html += '</thead>';
                        html += '<tbody>';  
                        for(var s = 0; s < list.products[v].subproducts.length; s++){
                            html += '<tr class="accordianBorder" >';
                            html += '<td data-original-title="'+(list.products[v].subproducts[s].brand_name?list.products[v].subproducts[s].brand_name:'')+'" data-toggle="tooltip">'+(list.products[v].subproducts[s].brand_name?list.products[v].subproducts[s].brand_name:'')+'</td>';
                            html += '<td data-original-title="'+(list.products[v].subproducts[s].model_name?list.products[v].subproducts[s].model_name:"")+'" data-toggle="tooltip">'+(list.products[v].subproducts[s].model_name?list.products[v].subproducts[s].model_name:"")+'</td>';
                            html += '<td data-original-title="'+(list.products[v].subproducts[s].variant_name?list.products[v].subproducts[s].variant_name:"")+'" data-toggle="tooltip">'+(list.products[v].subproducts[s].variant_name?list.products[v].subproducts[s].variant_name:"")+'</td>';
                            html += '<td data-original-title="';
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
                            html += '<td data-original-title="'+(list.products[v].subproducts[s].year?list.products[v].subproducts[s].year:"")+'" data-toggle="tooltip">'+(list.products[v].subproducts[s].year?list.products[v].subproducts[s].year:"")+'</td>';
                            html += '</tr>';
                        } 
                        html += ' </tbody></table></td></tr>';
                    } 
                } 
            }
            html += '</tbody></table></div></div>';
            html += '<div class="headerbar-item pull-right paddingTop20px">';
            html += list.createLinks;
            html += '</div>';
            $('#content').html(html);
            $('#gif').hide();
        }
    });

    $('body').on('mouseenter', '.table', function () {
        $(".datatable [data-toggle='tooltip']").tooltip();
    });
}

$(function () {

    var exprod = '<?php echo $existing_prod_ids; ?>';
    if(exprod != '' && exprod != 0){
        yourArray = exprod.split('-');
        $("#selected_count").empty().append(yourArray.length);
    }

    var screenheighth = $( window ).height();
    $('#addproduct').modal('show');
    $(".bootstrap-select").selectpicker("refresh");
    
    $(document).on('change', '.product_ids', function() {
        if($(this).prop("checked")){
            if(!yourArray.includes($(this).val())){
                yourArray.push($(this).val());
            }
        }else{
            yourArray = yourArray.filter((n) => {return n != ($(this).val())});
        }
        $("#selected_count").empty().append(yourArray.length);
    });

    $('.modal-popup-close').click(function () {
        $('#product_content .product_ids').prop('checked' , false);
        yourArray = [];
        $('.modal').remove();
        $('.modal-backdrop').remove();
        $('body').removeClass( "modal-open" );
    }); 
        
    $( ".check_error_label" ).change(function() {
        $('.error_msg_' + $(this).attr('name')).hide();
        $('#' + $(this).attr('name')).parent().removeClass('has-error'); 
    });     

    $("#showfilter").click(function(){
        $(".hideShowFilter").show();
        $("#showfilter").hide();
        $("#hidefilter").show();
    });

    $("#hidefilter").click(function(){
        $(".hideShowFilter").hide();
        $("#hidefilter").hide();
        $("#showfilter").show();
    });

});
</script>
<div class="modal fade screenheighth" id="addproduct" tabindex="-1" role="dialog" aria-labelledby="addNewCar" >
	<div class="modal-dialog" role="document">
		<div class="modal-content" id="add_car_fdetail">
            <div class="modal-header" style="padding: 15px 0px 0px 0px">
                <div class="col-xs-12 text-center">
                    <h3 style="margin:0px ; padding : 0px;"><?php _trans('lable1143'); ?></h3>
                </div>
                <button type="button" class="modal-close modal-popup-close">
                    <i class="font-icon-close-2"></i>
                </button>
            </div>
            <div class="modal-body" style="width: 100%;float: left;padding: 0px;">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 10px 15px;">
                    <div class="form_group col-xl-3 col-lg-3 col-md-4 col-sm-4">
                        <label class="form_label"><?php _trans('lable208'); ?></label>
                        <div class="form_controls">
                            <select name="product_category_id" id="product_category_id" onchange="searchFilter()" class="searchSelect bootstrap-select bootstrap-select-arrow g-input" data-live-search="true">
                                <option value=""><?php _trans('lable209'); ?></option>
                                <?php foreach ($families as $family) { ?>
                                    <option value="<?php echo $family->family_id; ?>" <?php check_select($cat, $family->family_id); ?>><?php echo $family->family_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form_group col-xl-3 col-lg-3 col-md-4 col-sm-4">
                        <label class="form_label"><?php _trans('lable207'); ?></label>
                        <div class="form_controls">
                            <input type="text" name="product_name" id="product_name" class="form-control" onkeyup="produfilt()" value="<?php echo $name;?>" autocomplete="off">
                        </div>
                    </div>
                    <div class="form_group col-xl-3 col-lg-3 col-md-4 col-sm-4 hideShowFilter">
                        <label class="form_label"><?php _trans('lable1024'); ?></label>
                        <div class="form_controls">
                            <input type="text" name="part_number" id="part_number" class="form-control" value="<?php echo $part_number;?>" autocomplete="off">
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3 col-xl-3 hideShowFilter">
                        <label class="form_label"><?php _trans('lable1026'); ?></label>
                        <select name="product_brand_id" id="product_brand_id" class="bootstrap-select bootstrap-select-arrow g-input" data-live-search="true">
                            <option value="0"><?php _trans('lable1027'); ?></option>
                            <?php foreach ($product_brand as $brands) { ?>
                                <option value="<?php echo $brands->vpb_id; ?>"
                                    <?php check_select($this->mdl_mech_item_master->form_value('product_brand_id'), $brands->vpb_id); ?>
                                ><?php echo $brands->prd_brand_name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3 col-xl-3 hideShowFilter" style="display:none">
                        <label class="form_label"><?php _trans('lable229'); ?></label>
                        <select name="brand_id" class="bootstrap-select bootstrap-select-arrow g-input" id="brand_id" data-live-search="true" autocomplete="off" onchange="getModelList(<?php echo $product->product_map_id; ?>)">
                            <option value="0"><?php  _trans('lable73'); ?></option>
                            <?php if(!empty($car_brand_list)){
                            foreach($car_brand_list as $brand_list){ ?>
                                <option value="<?php echo $brand_list->brand_id; ?>" <?php if($product->brand_id == $brand_list->brand_id){ echo "selected"; } ?> ><?php echo $brand_list->brand_name; ?></option>
                            <?php } } ?>
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3 col-xl-3 hideShowFilter" style="display:none">
                        <label class="form_label"><?php _trans('lable231'); ?></label>
                        <select name="model_id" class="bootstrap-select bootstrap-select-arrow g-input" data-live-search="true" autocomplete="off" id="model_id" onchange="getvariantList(<?php echo $product->product_map_id; ?>)">
                            <option value=""><?php  _trans('lable74'); ?></option>
                            <?php if(!empty($car_model_list)){
                                foreach ($car_model_list as $model_list){ ?>
                                <option value="<?php echo $model_list->model_id; ?>" <?php if($product->model_id == $model_list->model_id){ echo "selected"; } ?> ><?php echo $model_list->model_name;?></option>
                            <?php }}?>
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3 col-xl-3 hideShowFilter" style="display:none">
                        <label class="form_label"><?php _trans('lable232'); ?></label>
                        <select name="variant_id" class="bootstrap-select bootstrap-select-arrow g-input" data-live-search="true" autocomplete="off" id="variant_id">
                            <option value=""><?php  _trans('lable75'); ?></option>
                            <?php if ($car_variant_list){
                            foreach ($car_variant_list as $names){ ?>
                            <option value="<?php echo $names->brand_model_variant_id; ?>" <?php if($product->variant_id == $names->brand_model_variant_id){ echo "selected"; } ?>><?php echo $names->variant_name; ?></option>
                            <?php } } ?>
                        </select>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3 col-xl-3 hideShowFilter" style="display:none">
                        <label class="form_label"><?php _trans('lable132'); ?></label>
                        <select name="fuel_type" class="bootstrap-select bootstrap-select-arrow g-input" data-live-search="true" autocomplete="off" id="fuel_type">
                            <option value="">select Fuel Type</option>
                            <option value="P"><?php echo 'Petrol';?></option>
                            <option value="D"><?php echo 'Diesel';?></option>
                            <option value="O"><?php echo 'Others';?></option>
                        </select>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0px;">
                        <div class="form_group col-xl-9 col-lg-9 col-md-8 col-sm-8">
                            <label class="form_label"></label>
                            <div class="form_controls">
                                <span><button onclick="searchFilter()" class="btn_submit btn btn-primary"><?php _trans('lable39'); ?></button></span>
                                <span><span id="reset_filter" class="btn"><?php _trans('lable827'); ?></span></span>
                                <span><span id="showfilter" class="btn"><?php _trans('lable1144'); ?></span></span>
                                <span><span style="display:none" id="hidefilter" class="btn"><?php _trans('lable1145'); ?></span></span>
                            </div>
                        </div>
                        <div class="form_group col-xl-3 col-lg-3 col-md-4 col-sm-4 float_right text-right">
                            <label class="form_label"></label>
                            <div class="form_controls">
                                <span> Selected : </span>
                                <span  style="margin-right: 20px;margin-left: 10px;text-align: center;" id="selected_count"> 0 </span>
                                <span> <button onclick="sentProductTable()" class="btn_submit btn btn-primary"> <?php _trans('lable1142'); ?> </button> </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="content" class="table datatable">
                    <div class="overflowScrollForTableProduct">
                        <div class="col-xl-12 col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <table width="100%" style="width: 100%;" id="product_content">
                                <thead>
                                    <th>
                                    
                                    </th>
                                    <th><?php echo trans('lable25'); ?></th>
                                    <th><?php echo trans('lable1024'); ?></th>
                                    <th><?php echo trans('lable225'); ?></th>
                                </thead>
                                <tbody> 
                                <?php $existing_prod_ids = explode('-', $existing_prod_ids); 
                                if(count($products) > 0){
                                    $i = 1;
                                    foreach ($products as $key => $product) {
                                        if(count($product_list) > 0){
                                            $disabled = '';
                                            foreach($product_list as $pdlist){
                                                if($entity_type == 'P'){
                                                    if($pdlist->product_id == $product->product_id){
                                                        $disabled = 'disabled';
                                                    }
                                                }else{
                                                    if($pdlist->service_item == $product->product_id){
                                                        $disabled = 'disabled';
                                                    }
                                                }
                                            }
                                        }?>
                                    <tr>
                                        <td>
                                            <input <?php echo $disabled;?> type="checkbox" <?php if(in_array($product->product_id , $existing_prod_ids)){ echo 'checked'; }?>  name="product_ids[]" class="product_ids product_<?php echo $product->product_id;?>" id="product_<?php echo $product->product_id;?>" value="<?php echo $product->product_id;?>" >
                                        </td>
                                        <?php if(count($product->subproducts) > 0){ ?>
                                            <td class="cursor_pointer" data-original-title="<?php _htmlsc($product->product_name); ?>" data-toggle="tooltip"><span class="themeTextColor" data-toggle="collapse" data-target="#accordion_<?php echo $product->product_id; ?>" ><?php  _htmlsc($product->product_name); ?></span></td>
                                        <?php }else{ ?>
                                            <td data-original-title="<?php _htmlsc($product->product_name); ?>" data-toggle="tooltip"><span><?php  _htmlsc($product->product_name); ?></span></td>
                                        <?php } ?>
                                        <td data-original-title="<?php _htmlsc($product->part_number); ?>" data-toggle="tooltip"><?php _htmlsc($product->part_number); ?></td>

                                        <?php   $sale_price = 0;
                                                $sale_price = $product->sale_price?$product->sale_price:''; ?>
                                        <?php   $sale = 0;
                                                $sale = $product->sale?$product->sale:''; ?>
                                        <?php   $default_sale_price = 0;
                                                $default_sale_price = $product->default_sale_price?$product->default_sale_price:''; ?>
                                        <?php   $spmin = $sale_price?$sale_price:$sale; ?>
                                        <?php   $sp = $spmin?$spmin:$default_sale_price; ?>
                                                            
                                        <td data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($sp?$sp:0),$this->session->userdata('default_currency_digit')); ?>" data-toggle="tooltip"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($sp?$sp:0),$this->session->userdata('default_currency_digit')); ?></td>
                                    </tr>
                        
                                    <?php if(count($product->subproducts) > 0){ ?>
                                    <tr>
                                        <td colspan="4" style="border: none ! important">
                                            <table width="100%" style="table-layout: fixed;width: 100%;" class="rowBorder collapse" id="accordion_<?php echo $product->product_id;?>">
                                                <thead>
                                                    <th><?php echo trans('lable229'); ?></th>
                                                    <th><?php echo trans('lable231'); ?></th>
                                                    <th><?php echo trans('lable232'); ?></th>
                                                    <th><?php echo trans('lable132'); ?></th>
                                                    <th><?php echo ('Year'); ?></th>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($product->subproducts as $subpro){ ?>
                                                    <tr class="accordianBorder" >
                                                        <td data-original-title="<?php _htmlsc($subpro->brand_name); ?>" data-toggle="tooltip"><?php _htmlsc($subpro->brand_name); ?></td>
                                                        <td data-original-title="<?php _htmlsc($subpro->model_name); ?>" data-toggle="tooltip"><?php _htmlsc($subpro->model_name); ?></td>
                                                        <td data-original-title="<?php _htmlsc($subpro->variant_name); ?>" data-toggle="tooltip"><?php _htmlsc($subpro->variant_name); ?></td>
                                                        <td data-original-title="<?php if($subpro->fuel_type == 'P'){ echo 'Petrol';}else if($subpro->fuel_type == 'D'){ echo 'Diesel';}else if($subpro->fuel_type == 'O'){ echo 'Other';} ?>" data-toggle="tooltip"><?php if($subpro->fuel_type == 'P'){ echo 'Petrol';}else if($subpro->fuel_type == 'D'){ echo 'Diesel';}else if($subpro->fuel_type == 'O'){ echo 'Other';} ?></td>
                                                        <td data-original-title="<?php echo $subpro->year; ?>" data-toggle="tooltip"><?php echo $subpro->year; ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <?php } $i++; } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="headerbar-item pull-right">
                        <?php echo $createLinks;?>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
<style>
.collapse.in{
    display: table;
}
.cursor_pointer{
    cursor: pointer;
}
</style>