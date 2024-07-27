<input type="hidden" id="_mm_csrf" name="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>"autocomplete="off">
<script type="text/javascript">
var yourArray = [];
var entity_type = '<?php echo $entity_type; ?>';
var entity_id = '<?php echo $entity_id;?>';
var custm_id = '<?php echo  $customer_id; ?>';

function servicefilter(){
    var service_name = $('#service_name').val()?$('#service_name').val():'';
    if(service_name.length > 3){
        searchFilter();
    }else if(service_name.length == 0){
        searchFilter();
    }
}

function sentServiceTable(){

    if(yourArray.length  > 0){
        $('#gif').show();
        $.post('<?php echo site_url('mech_item_master/ajax/get_selected_service_list'); ?>', {
            yourArray : yourArray,
            _mm_csrf: $('#_mm_csrf').val()
        }, function (data) {	
            list = JSON.parse(data);            
            if(list.services != '' && list.services.length > 0){
                popupservices(list.services);
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
    var service_name = $('#service_name').val()?$('#service_name').val():'';
    var service_category_id = $("#service_category_id").val()?$("#service_category_id").val():'';
    $('#gif').show();
    $.post('<?php echo site_url('mech_item_master/ajax/get_service_filter_list'); ?>', {
        page : page_num,
        service_item_name : service_name,
        service_category_id : service_category_id,
        entity_type: entity_type,
        entity_id : entity_id,
        customer_id : custm_id,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            var html = '';
            html += '<div class="overflowScrollForTableProduct">';
            html += '<div class="col-xl-12 col-lg-12 col-sm-12 col-md-12 col-xs-12">';
            html += '<table class="product_content" width="100%" style="width: 100%;">';
            html += '<thead><tr>';
            html += '<th></th>';
            html += '<th><?php echo trans("lable25"); ?></th>';
            html += '<th><?php echo trans('lable879'); ?></th>';
            html += '<tbody>';
            if(list.mech_service_item_dtls.length > 0){
                for(var v=0; v < list.mech_service_item_dtls.length; v++){ 
                    html += '<tr>';
                    html += '<td><input ';
                    if(list.service_list.length > 0){
                        for(var j=0; j < list.service_list.length; j++){
                            if(entity_type == 'SP'){
                                if(parseInt(list.service_list[j].msim_id) == parseInt(list.mech_service_item_dtls[v].msim_id)){
                                    html += ' disabled ';
                                }
                            }else{
                                if(parseInt(list.service_list[j].msim_id) == parseInt(list.mech_service_item_dtls[v].msim_id)){
                                    html += ' disabled ';
                                }
                            }
                            
                        }
                    }
                    html += ' type="checkbox"';
                    if (jQuery.inArray(list.mech_service_item_dtls[v].msim_id, yourArray)!='-1') {
                        html += 'checked ';
                    }
                    html += ' name="service_ids[]" class="service_ids service_'+list.mech_service_item_dtls[v].msim_id+'" id="service_'+list.mech_service_item_dtls[v].msim_id+'" value="'+list.mech_service_item_dtls[v].msim_id+'" ></td>';
                    html += '<td data-original-title="'+(list.mech_service_item_dtls[v].service_item_name?list.mech_service_item_dtls[v].service_item_name:"")+'" data-toggle="tooltip">'+(list.mech_service_item_dtls[v].service_item_name?list.mech_service_item_dtls[v].service_item_name:"")+'</td>';
                    var estimated_cost = list.mech_service_item_dtls[v].estimated_cost?list.mech_service_item_dtls[v].estimated_cost:'';
                    var default_estimated_cost = list.mech_service_item_dtls[v].default_estimated_cost?list.mech_service_item_dtls[v].default_estimated_cost:'';
                    var sp = estimated_cost?estimated_cost:default_estimated_cost;
                    html += '<td data-original-title="'+(sp?sp:0)+'" data-toggle="tooltip">'+(sp?sp:0)+'</td>';
                } 
            }
            html += '</tbody></table></div></div>';
            html += '<div class="headerbar-item pull-right paddingTop20px">';
            html += list.createLinks;
            html += '</div>';
            $('#contents').html(html);
            $('#gif').hide();
        }
    });

    $('body').on('mouseenter', '.table', function () {
        $(".datatable [data-toggle='tooltip']").tooltip();
    });
}

$(function () {

    var exprod = '<?php echo $existing_service_ids; ?>';
    if(exprod != '' && exprod != 0){
        yourArray = exprod.split('-');
        $("#selected_count").empty().append(yourArray.length);
    }

    var screenheighth = $( window ).height();
    $('#addproduct').modal('show');
    $(".bootstrap-select").selectpicker("refresh");
    
    $(document).on('change', '.service_ids', function() {
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
        $('#service_content .service_ids').prop('checked' , false);
        yourArray = [];
        $('.modal').remove();
        $('.modal-backdrop').remove();
        $('body').removeClass( "modal-open" );
    }); 
        
    $( ".check_error_label" ).change(function() {
        $('.error_msg_' + $(this).attr('name')).hide();
        $('#' + $(this).attr('name')).parent().removeClass('has-error'); 
    });     

});
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
        $("#service_name").val('');
        $("#service_category_id").val('');
        $('.bootstrap-select').selectpicker("refresh");
        searchFilter();
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
                            <select name="service_category_id" id="service_category_id" onchange="searchFilter()" class="searchSelect bootstrap-select bootstrap-select-arrow g-input" data-live-search="true">
                                <option value=""><?php _trans('lable252'); ?></option>
                                <?php foreach ($service_cat as $service_catt) { ?>
                                    <option value="<?php echo $service_catt->service_cat_id; ?>" <?php check_select($cat, $service_catt->service_cat_id); ?>><?php echo $service_catt->category_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form_group col-xl-3 col-lg-3 col-md-4 col-sm-4">
                        <label class="form_label"><?php _trans('lable240'); ?></label>
                        <div class="form_controls">
                            <input type="text" name="service_name" id="service_name" class="form-control" onkeyup="servicefilter()" value="<?php echo $name;?>" autocomplete="off">
                        </div>
                    </div>
                    
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0px;">
                        <div class="form_group col-xl-9 col-lg-9 col-md-8 col-sm-8">
                            <label class="form_label"></label>
                            <div class="form_controls">
                                <span><button onclick="searchFilter()" class="btn_submit btn btn-primary"><?php _trans('lable39'); ?></button></span>
                                <span><span id="reset_filter" class="btn"><?php _trans('lable827'); ?></span></span>
                            </div>
                        </div>
                        <div class="form_group col-xl-3 col-lg-3 col-md-4 col-sm-4 float_right text-right">
                            <label class="form_label"></label>
                            <div class="form_controls">
                                <span> Selected : </span>
                                <span  style="margin-right: 20px;margin-left: 10px;text-align: center;" id="selected_count"> 0 </span>
                                <span> <button onclick="sentServiceTable()" class="btn_submit btn btn-primary"> <?php _trans('lable1142'); ?> </button> </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="contents" class="table datatable">
                    <div class="overflowScrollForTableProduct">
                        <div class="col-xl-12 col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <table width="100%" style="width: 100%;" id="product_content">
                                <thead>
                                    <th></th>
                                    <th><?php echo trans('lable253'); ?></th>
                                    <th><?php echo trans('lable879'); ?></th>
                                </thead>
                                <tbody> 
                                <?php $existing_service_ids = explode('-', $existing_service_ids); 
                                if(count($services) > 0){
                                    $i = 1;
                                    foreach ($services as $service) {
                                        if(count($service_list) > 0){
                                            $disabled = '';
                                            foreach($service_list as $serlist){
                                                if($entity_type == 'SP'){
                                                    if($serlist->msim_id == $service->msim_id){
                                                        $disabled = 'disabled';
                                                    }
                                                }else{
                                                    if($serlist->msim_id == $service->msim_id){
                                                        $disabled = 'disabled';
                                                    }
                                                }
                                            }
                                        }?>
                                    <tr>
                                        <td>
                                            <input <?php echo $disabled;?> type="checkbox" <?php if(in_array($service->msim_id , $existing_service_ids)){ echo 'checked'; }?>  name="service_ids[]" class="service_ids service_<?php echo $service->msim_id;?>" id="service_<?php echo $service->msim_id;?>" value="<?php echo $service->msim_id;?>" >
                                        </td>

                                        <?php if(count($service->subproducts) > 0){ ?>
                                            <td class="pointer" data-original-title="<?php _htmlsc($service->service_item_name); ?>" data-toggle="tooltip"><span class="themeTextColor" data-toggle="collapse" data-target="#accordion_<?php echo $service->msim_id; ?>"><?php  _htmlsc($service->service_item_name); ?></span></td>
                                        <?php }else{ ?>
                                            <td data-original-title="<?php _htmlsc($service->service_item_name); ?>" data-toggle="tooltip"><span><?php  _htmlsc($service->service_item_name); ?></span></td>    
                                        <?php } ?>
                                        
                                        <td data-original-title="<?php _htmlsc($service->estimated_cost?$service->estimated_cost:$service->default_estimated_cost); ?>" data-toggle="tooltip"><?php  _htmlsc($service->estimated_cost?$service->estimated_cost:$service->default_estimated_cost); ?></td>
                                    </tr>
                                    <?php if(count($service->subproducts) > 0){ ?>
                                    <tr>
                                        <td colspan="4" style="border: none ! important">
                                            <table width="100%" style="table-layout: fixed;width: 100%;" class="rowBorder collapse" id="accordion_<?php echo $service->msim_id;?>">
                                                <thead>
                                                    <th><?php echo trans('lable229'); ?></th>
                                                    <th><?php echo trans('lable231'); ?></th>
                                                    <th><?php echo trans('lable232'); ?></th>
                                                    <th><?php echo trans('lable132'); ?></th>
                                                    <th><?php echo ('Year'); ?></th>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($service->subproducts as $subpro){ ?>
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
                                    <?php }  $i++; } } ?>
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