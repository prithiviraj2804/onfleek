<?php if(count($offer_deals) < 1) {  ?>
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
                <a class="btn btn-sm btn-primary" href="<?php echo site_url('offer_deals/form'); ?>">
                    <i class="fa fa-plus"></i> <?php _trans('label973'); ?>
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
                        <h3><?php _trans('label971'); ?></h3>
                    </div>
                    <div class="tbl-cell pull-right">
                        <a class="btn btn-sm btn-primary" href="<?php echo site_url('offer_deals/form'); ?>">
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
                        <label class="form_label"><?php _trans('lable175'); ?></label>
                        <div class="form_controls">
                            <input onchange="searchFilter()" type="text" name="offer_from_date" id="offer_from_date" class="form-control datepicker" autocomplete="off">
                        </div>
                    </div>
                    <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                        <label class="form_label"><?php _trans('lable176'); ?></label>
                        <div class="form_controls">
                            <input onchange="searchFilter()" type="text" name="offer_to_date" id="offer_to_date" class="form-control datepicker" autocomplete="off">
                        </div>
                    </div>
                    <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                        <label class="form_label"><?php _trans('label972'); ?></label>
                        <div class="form_controls">
                            <input onkeyup="searchFilter()" type="text" name="offer_title" id="offer_title" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                        <label class="form_label"><?php _trans('lable208'); ?></label>
                        <div class="form_controls">
                            <select onchange="searchFilter()" name="service_category_id" id="service_category_id" class="searchSelect bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true">
                                <?php if(count($service_category)>0){ ?>
                                    <option value=""><?php _trans('lable252'); ?></option>
                                <?php } ?>
                                <?php foreach ($service_category as $service_cate) {?>
                                <option value="<?php echo $service_cate->service_cat_id; ?>"> <?php echo $service_cate->category_name; ?></option>
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
                <div id="posts_content">
                    <div class="overflowScrollForTable">
                        <table class="display table datatable table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    
                                    <th><?php _trans('label972');?></th>
                                    <th class="text_align_center"><?php _trans('lable239'); ?></th>
                                    <th class="text_align_center"><?php _trans('lable546'); ?></th>
                                    <th class="text_align_center"><?php _trans('lable361'); ?></th>
                                    <th class="text_align_center"><?php _trans('lable630'); ?></th>                                    
                                    <th class="text_align_center"><?php _trans('label946'); ?></th>
                                    <th class="text_align_center"><?php _trans('lable19'); ?></th>
                                    <th class="text_align_center"><?php _trans('lable22'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($offer_deals) > 0) { 
                                    $i = 1;
                                    foreach ($offer_deals as $offer_deal) { 
                                    if(count($offer_deals) >= 4)
                                    {    
                                        if(count($offer_deals) == $i || count($offer_deals) == $i+1)
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
                                    <td data-original-title="<?php _htmlsc($offer_deal->offer_title); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($offer_deal->offer_title); ?></td>
                                    <td class="text_align_center" data-original-title="<?php _htmlsc($offer_deal->category_name); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($offer_deal->category_name); ?></td>
                                    <td class="text_align_center" data-original-title="<?php _htmlsc($offer_deal->package_name); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($offer_deal->package_name); ?></td>
                                    <td class="text_align_center" data-original-title="<?php _htmlsc($offer_deal->start_date?date_from_mysql($offer_deal->start_date):'-'); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($offer_deal->start_date?date_from_mysql($offer_deal->start_date):'-'); ?></td>
                                    <td class="text_align_center" data-original-title="<?php _htmlsc($offer_deal->end_date?date_from_mysql($offer_deal->end_date):'-'); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($offer_deal->end_date?date_from_mysql($offer_deal->end_date):'-'); ?></td>
                                    <td class="text_align_center" data-original-title="<?php if($offer_deal->mobile_enable == 'Y'){ echo "Enable"; } else{ echo 'Disable'; } ?>" data-toggle="tooltip" class="textEllipsis"><?php if($offer_deal->mobile_enable == 'Y'){ echo "Enable"; } else{ echo 'Disable'; } ?></td>
                                    <td class="text_align_center" data-original-title="<?php if($offer_deal->status == 'A'){ echo "Active"; } else{ echo 'Inactive'; } ?>" data-toggle="tooltip" class="textEllipsis"><?php if($offer_deal->status == 'A'){ echo "Active"; } else{ echo 'Inactive'; } ?></td>
                                    <td class="text_align_center">
                                        <div class="options btn-group <?php echo $dropup; ?>">
                                            <a class="btn btn-default btn-sm dropdown-toggle"
                                            data-toggle="dropdown" href="#" >
                                                <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                            </a>
                                            <ul class="optionTag dropdown-menu">
                                                <li>
                                                    <a href="<?php echo site_url('offer_deals/form/' . $offer_deal->offer_id); ?>">
                                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                                    </a>
                                                </li>
                                                <li>
                                                <a href="javascript:void(0)" onclick="delete_record('offer_deals',<?php echo $offer_deal->offer_id; ?>, '<?= $this->security->get_csrf_hash() ?>')"> 
                                                <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?></a>
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
<script>
function searchFilter(page_num) {
    page_num = page_num?page_num:0;
    var offer_from_date = $('#offer_from_date').val()?$('#offer_from_date').val():'';
    var offer_to_date = $('#offer_to_date').val()?$('#offer_to_date').val():'';
    var offer_title = $('#offer_title').val()?$('#offer_title').val():'';
    var service_category_id = $('#service_category_id').val()?$('#service_category_id').val():'';


    $.post('<?php echo site_url('offer_deals/ajax/get_offer_package_filter_list'); ?>', {
        page : page_num,
        offer_from_date : offer_from_date,
        offer_to_date : offer_to_date,
        offer_title : offer_title,
        service_category_id : service_category_id,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            
            var html = '';
            html += '<div class="overflowScrollForTable">';
            html += '<table class="display table datatable table-bordered" cellspacing="0" width="100%">';
            html += '<thead><tr>';
            html += '<th><?php _trans("label972"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable546"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable239"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable361"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable630"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("label946"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable19"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable22"); ?></th>';
            html += '</tr></thead><tbody>';

            if(list.mech_offer_package.length > 0){
                for(var v=0; v < list.mech_offer_package.length; v++){ 
                if(list.mech_offer_package.length >= 4)
                { 
                    if(list.mech_offer_package.length == v || list.mech_offer_package.length == v+1)
                    {
                        var dropup = "dropup";
                    }
                    else
                    {
                        var dropup = "";
                    }
                }    

                    html += '<tr>';
                    html += '<td data-original-title="'+(list.mech_offer_package[v].offer_title?list.mech_offer_package[v].offer_title:"")+'" data-toggle="tooltip" class="textEllipsis">'+(list.mech_offer_package[v].offer_title?list.mech_offer_package[v].offer_title:"")+'</td>';
                    html += '<td class="text-center" data-original-title="'+(list.mech_offer_package[v].category_name?list.mech_offer_package[v].category_name:"")+'" data-toggle="tooltip" class="textEllipsis">'+(list.mech_offer_package[v].category_name?list.mech_offer_package[v].category_name:"")+'</td>';
                    html += '<td class="text-center" data-original-title="'+(list.mech_offer_package[v].package_name?list.mech_offer_package[v].package_name:"")+'" data-toggle="tooltip" class="textEllipsis">'+(list.mech_offer_package[v].package_name?list.mech_offer_package[v].package_name:"")+'</td>';
                    html += '<td class="text-center" data-original-title="'+(list.mech_offer_package[v].start_date?formatDate(new Date(list.mech_offer_package[v].start_date)):"")+'" data-toggle="tooltip" class="textEllipsis">'+(list.mech_offer_package[v].start_date?formatDate(new Date(list.mech_offer_package[v].start_date)):"")+'</td>';
					html += '<td class="text-center" data-original-title="'+(list.mech_offer_package[v].end_date?formatDate(new Date(list.mech_offer_package[v].end_date)):"")+'" data-toggle="tooltip" class="textEllipsis">'+(list.mech_offer_package[v].end_date?formatDate(new Date(list.mech_offer_package[v].end_date)):"")+'</td>';

                    html += '<td class="text-center" data-original-title="';
					if(list.mech_offer_package[v].mobile_enable == 'Y'){ html += 'Enable'; }else{ html += 'Disable'; }
                    html += '" data-toggle="tooltip" class="textEllipsis">';
                    if(list.mech_offer_package[v].mobile_enable == 'Y'){ html += 'Enable'; }else{ html += 'Disable'; }
                    html += '</td>';

                    html += '<td class="text-center" data-original-title="';
					if(list.mech_offer_package[v].status == 'A'){ html += 'Active'; }else{ html += 'InActive'; }
                    html += '" data-toggle="tooltip" class="textEllipsis">';
                    if(list.mech_offer_package[v].status == 'A'){ html += 'Active'; }else{ html += 'InActive'; }
                    html += '</td>';
                                                                                                                                                                                                                                                  
                    html += '<td class="text_align_center">';
                    html += '<div class="options btn-group '+dropup+'">';
                    html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">';
                    html += '<i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
                    html += '<ul class="optionTag dropdown-menu">';
                    html += '<li><a href="<?php echo site_url("offer_deals/form/'+list.mech_offer_package[v].offer_id+'"); ?>">';
                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable44"); ?></a></li>';
                    html += '<li><a href="javascript:void(0)" onclick="delete_record(\'offer_deals\',\''+list.mech_offer_package[v].offer_id+'\',\'<?= $this->security->get_csrf_hash() ?>\')">';
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
    
    $(".card-block input").keypress(function (e) {
        if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
            $('.btn_submit').click();
            return false;
        } else {
            return true;
        }
    });
    $("#reset_filter").click(function () {
        
        $("#offer_from_date").val('');
        $("#offer_to_date").val('');
        $("#offer_title").val('');
        $("#service_category_id").val('');
        $('.bootstrap-select').selectpicker("refresh");
        searchFilter();
    });
});
</script>
<?php } ?>