<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php _trans('lable257'); ?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-sm btn-primary" href="<?php echo site_url('mechanic_service_item_price_list/form'); ?>">
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
                        <input onkeyup="searchFilter()" name="service_item_name" id="service_item_name" class="form-control removeError" autocomplete="off" data-live-search="true">
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
                    <label class="form_label"></label>
                    <div class="form_controls paddingTop15px">
                        <span><button onclick="searchFilter()" class="btn_submit btn btn-primary"><?php _trans('lable39'); ?></button></span>
                        <span><span id="reset_filter" class="btn"><?php _trans('lable827'); ?></span></span>
                    </div>
                </div>
            </div>
            <div id="posts_content" class="table datatable">
                <div class="overflowScrollForTable">
                    <div class="col-xl-12 col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <div class="row thead">
                            <div class="th col-xl-4 col-lg-4 col-sm-4 col-md-4 col-xs-4 text_align_left"><?php echo trans('lable253'); ?></div>
                            <div class="th col-xl-4 col-lg-4 col-sm-4 col-md-4 col-xs-4 text_align_left"><?php echo trans('lable251'); ?></div>
                            <div class="th col-xl-4 col-lg-4 col-sm-4 col-md-4 col-xs-4 text-center"><?php echo trans('lable22'); ?></div>
                        </div>
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
                        <div class="row ">
                            <div class="td textEclip col-xl-4 col-lg-4 col-sm-4 col-md-4 col-xs-4" data-original-title="<?php _htmlsc($item_price_list->service_item_name); ?>" data-toggle="tooltip"><span <?php if(count($item_price_list->sbmv) > 0){ echo 'class="themeTextColor pointer" data-toggle="collapse" data-target="#accordion_'.$item_price_list->msim_id.'"'; } ?>><a><?php _htmlsc($item_price_list->service_item_name); ?></a></span></div>
                            <div class="td textEclip col-xl-4 col-lg-4 col-sm-4 col-md-4 col-xs-4" data-original-title="<?php _htmlsc($item_price_list->category_name); ?>" data-toggle="tooltip"><?php _htmlsc($item_price_list->category_name); ?></div>
                            <div class="td text-center col-xl-4 col-lg-4 col-sm-4 col-md-4 col-xs-4">
                                <div class="options btn-group <?php echo $dropup; ?>">
                                    <a class="btn btn-default btn-sm dropdown-toggle"
                                    data-toggle="dropdown" href="#">
                                        <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                    </a>
                                    <ul class="optionTag dropdown-menu">
                                        <li>
                                            <a href="<?php echo site_url('mechanic_service_item_price_list/form/'.$item_price_list->msim_id); ?>">
                                                <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                            </a>
                                        </li>
                                        <li>
                                        <a href="javascript:void(0)" onclick="delete_record('mechanic_service_item_price_list',<?php echo $item_price_list->msim_id; ?>, '<?= $this->security->get_csrf_hash() ?>')"> <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <?php if(count($item_price_list->sbmv) > 0){ ?>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 paddingTop10px rowBorder collapse" id="accordion_<?php echo $item_price_list->msim_id;?>">
                            <div class="row thead">
                                <div class="th text_align_left col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2"><?php echo trans('lable229'); ?></div>
                                <div class="th text_align_left col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2"><?php echo trans('lable231'); ?></div>
                                <div class="th text_align_left col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2"><?php echo trans('lable132'); ?></div>
                                <div class="th text-center col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2"><?php echo trans('lable878'); ?></div>
                                <div class="th text_align_right col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2"><?php echo trans('lable225'); ?></div>
                                <div class="th text-center col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2"><?php echo trans('lable22'); ?></div>
                            </div>
                            <?php foreach($item_price_list->sbmv as $subpro){ ?>
                            <div class=" row accordianBorder" >
                                <div class="td col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2" data-original-title="<?php _htmlsc($subpro->brand_name); ?>" data-toggle="tooltip"><?php _htmlsc($subpro->brand_name); ?></div>
                                <div class="td col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2" data-original-title="<?php _htmlsc($subpro->model_name); ?>" data-toggle="tooltip"><?php _htmlsc($subpro->model_name); ?></div>
                                <div class="td col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2" data-original-title="<?php if($subpro->fuel_type == "P"){ echo "Petrol";}else if($subpro->fuel_type == "D"){ echo "Diesel";} ?>" data-toggle="tooltip"><?php if($subpro->fuel_type == "P"){ echo "Petrol";}else if($subpro->fuel_type == "D"){ echo "Diesel";} ?></div>
                                <div class="td text-center col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2" data-original-title="<?php _htmlsc($subpro->estimated_hour);?>" data-toggle="tooltip"><?php _htmlsc($subpro->estimated_hour); ?></div>
                                <div class="td text-right col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($subpro->estimated_cost,$this->session->userdata('default_currency_digit'));?>" data-toggle="tooltip"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($subpro->estimated_cost,$this->session->userdata('default_currency_digit'));?></div>
                                <div class="td text-center col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2">
                                <div class="options btn-group <?php echo $dropup; ?>">
                                    <a class="btn btn-default btn-sm dropdown-toggle"
                                    data-toggle="dropdown" href="#">
                                        <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                    </a>
                                    <ul class="optionTag dropdown-menu">

                                    <a href="javascript:void(0)" onclick="delete_record('mechanic_service_item_price_list',<?php echo $subpro->pct_id; ?>,'<?= $this->security->get_csrf_hash() ?>');">
                                    <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?>
                                    </a>

                                    </ul>
                                </div>
                            </div>
                            </div>
                         <?php } ?>
                        </div>
                    <?php } } } ?>
                    </div>
                </div>
                <div class="headerbar-item pull-right">
                    <?php echo $createLinks;?>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
function searchFilter(page_num) {
    page_num = page_num?page_num:0;
    var service_item_name = $('#service_item_name').val()?$('#service_item_name').val():'';
    var service_category_id = $("#service_category_id").val()?$("#service_category_id").val():'';

    $.post('<?php echo site_url('mechanic_service_item_price_list/ajax/get_filter_list'); ?>', {
        page : page_num,
        service_item_name : service_item_name,
        service_category_id : service_category_id,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            var html = '';
            html += '<div class="overflowScrollForTable">';
            html += '<div class="col-xl-12 col-lg-12 col-sm-12 col-md-12 col-xs-12 table-bordered">';
            html += '<div class="row thead">';
            html += '<div class="th text_align_left col-xl-4 col-lg-4 col-sm-4 col-md-4 col-xs-4"><?php echo trans("lable253"); ?></div>';
            html += '<div class="th text_align_left col-xl-4 col-lg-4 col-sm-4 col-md-4 col-xs-4"><?php echo trans("lable251"); ?></div>';
            html += '<div class="th col-xl-4 col-lg-4 col-sm-4 col-md-4 col-xs-4 text-center"><?php echo trans("lable22"); ?></div>';
            html += '</div>';
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
                    html += '<div class="row ">';
                    html += '<div class="td textEclip col-xl-4 col-lg-4 col-sm-4 col-md-4 col-xs-4" data-original-title="'+list.mech_service_item_dtls[v].service_item_name+'" data-toggle="tooltip"><span ';
                    if(list.mech_service_item_dtls[v].sbmv.length > 0){ 
                        html += 'class="themeTextColor pointer" data-toggle="collapse" data-target="#accordion_'+list.mech_service_item_dtls[v].msim_id+'"';
                    } 
                    html += '>'+list.mech_service_item_dtls[v].service_item_name+'</span></div>';
                    html += '<div class="td textEclip col-xl-4 col-lg-4 col-sm-4 col-md-4 col-xs-4" data-original-title='+list.mech_service_item_dtls[v].category_name+'" data-toggle="tooltip">'+list.mech_service_item_dtls[v].category_name+'</div>';
                    html += '<div class="td text-center col-xl-4 col-lg-4 col-sm-4 col-md-4 col-xs-4">';
                    html += '<div class="options btn-group '+dropup+'">';
                    html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">';
                    html += '<i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
                    html += '<ul class="optionTag dropdown-menu">';
                    html += '<li><a href="<?php echo site_url("mechanic_service_item_price_list/form/'+list.mech_service_item_dtls[v].msim_id+'"); ?>">';
                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable44"); ?></a></li>';
                    html += '<li><a href="javascript:void(0)" onclick="delete_record(\'mechanic_service_item_price_list\',\''+list.mech_service_item_dtls[v].msim_id+'\',\'<?= $this->security->get_csrf_hash() ?>\')">';
                    html += '<i class="fa fa-trash-o fa-margin"></i> <?php _trans("lable47"); ?></a></li>';
                    html += '</a></li></ul></div></div></div>';
                        
                    if(list.mech_service_item_dtls[v].sbmv.length > 0){
                        html += '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 paddingTop10px rowBorder collapse" id="accordion_'+list.mech_service_item_dtls[v].msim_id+'">';
                        html += '<div class="row thead">';
                        html += '<div class="th text_align_left col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2"><?php echo trans('lable229'); ?></div>';
                        html += '<div class="th text_align_left col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2"><?php echo trans('lable231'); ?></div>';
                        html += '<div class="th text_align_left col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2"><?php echo trans('lable132'); ?></div>';
                        html += '<div class="th text-center col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2"><?php echo trans('lable878'); ?></div>';
                        html += '<div class="th text_align_right col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2"><?php echo trans('lable225'); ?></div>';
                        html += '<div class="th text-center col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2"><?php echo trans('lable22'); ?></div>';
                        html += '</div>';
                        for(var s=0; s < list.mech_service_item_dtls[v].sbmv.length; s++){ 
                            html += '<div class=" row accordianBorder" >';
                            html += '<div class="td text_align_left col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text-center" data-original-title="'+(list.mech_service_item_dtls[v].sbmv[s].brand_name?list.mech_service_item_dtls[v].sbmv[s].brand_name:"")+'" data-toggle="tooltip">'+(list.mech_service_item_dtls[v].sbmv[s].brand_name?list.mech_service_item_dtls[v].sbmv[s].brand_name:"")+'</div>';
                            html += '<div class="td text_align_left col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2 text-center" data-original-title="'+(list.mech_service_item_dtls[v].sbmv[s].model_name?list.mech_service_item_dtls[v].sbmv[s].model_name:"")+'" data-toggle="tooltip">'+(list.mech_service_item_dtls[v].sbmv[s].model_name?list.mech_service_item_dtls[v].sbmv[s].model_name:"")+'</div>';
                            html += '<div class="td text_align_left col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2" data-original-title="';
                            if(list.mech_service_item_dtls[v].sbmv[s].fuel_type == "P"){ 
                                html += 'Petrol';
                            }else if(list.mech_service_item_dtls[v].sbmv[s].fuel_type == "D"){ 
                                html += 'Diesel';
                            }
                            html += '" data-toggle="tooltip">';
                            if(list.mech_service_item_dtls[v].sbmv[s].fuel_type == "P"){ 
                                html += 'Petrol';
                            }else if(list.mech_service_item_dtls[v].sbmv[s].fuel_type == "D"){
                                html += 'Diesel';
                            }
                            html += '</div>';
                            html += '<div class="td text-center col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2" data-original-title="'+(list.mech_service_item_dtls[v].sbmv[s].estimated_hour?list.mech_service_item_dtls[v].sbmv[s].estimated_hour:"")+'" data-toggle="tooltip">'+(list.mech_service_item_dtls[v].sbmv[s].estimated_hour?list.mech_service_item_dtls[v].sbmv[s].estimated_hour:"")+'</div>';
                            html += '<div class="td text_align_right col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata("default_currency_code")); ?>&nbsp;'+format_money((list.mech_service_item_dtls[v].sbmv[s].estimated_cost?list.mech_service_item_dtls[v].sbmv[s].estimated_cost:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'" data-toggle="tooltip"><?php echo $this->mdl_settings->currencychanger($this->session->userdata("default_currency_code")); ?>&nbsp;'+format_money((list.mech_service_item_dtls[v].sbmv[s].estimated_cost?list.mech_service_item_dtls[v].sbmv[s].estimated_cost:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'</div>';
                            html += '<div class="td text-center col-xl-2 col-lg-2 col-sm-2 col-md-2 col-xs-2">';
                            html += '<div class="options btn-group '+dropup+'">';
                            html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">';
                            html += '<i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
                            html += '<ul class="optionTag dropdown-menu">';

                            html += '<li><a href="javascript:void(0)" onclick="delete_record(\'mechanic_service_item_price_list\',\''+list.mech_service_item_dtls[v].sbmv[s].pct_id+'\',\'<?= $this->security->get_csrf_hash() ?>\')">';
                            html += '<i class="fa fa-trash-o fa-margin"></i> <?php _trans("lable47"); ?></a></li>';

                            html += '</a></li></ul></div></div></div>';
                         }
                         html += '</div>';
                    } 
                } 
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
        $('.bootstrap-select').selectpicker("refresh");
        searchFilter();
    });
});
</script>