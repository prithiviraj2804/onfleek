<?php if(count($service_packages_details) < 1) {  ?>
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
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('packages/service_packages'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('label938'); ?>
            </a>
        </div>
    </div>
</div>
<?php } else { ?>
<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell"><h3><?php _trans('lable539'); ?></h3></div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-sm btn-primary" href="<?php echo site_url('packages/service_packages'); ?>"><i class="fa fa-plus"></i> <?php _trans('lable40'); ?></a>
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
                        <input onchange="searchFilter()" type="text" name="package_from_date" id="package_from_date" class="form-control datepicker" autocomplete="off" value="<?php echo date_from_mysql(date('Y-m-d')); ?>">
                    </div>
                </div>
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable176'); ?></label>
                    <div class="form_controls">
                        <input onchange="searchFilter()" type="text" name="package_to_date" id="package_to_date" class="form-control datepicker" autocomplete="off" value="<?php echo date_from_mysql(date('Y-m-d')); ?>">
                    </div>
                </div>
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable540'); ?></label>
                    <div class="form_controls">
                        <input onkeyup="searchFilter()" type="text" name="service_package_name" id="service_package_name" class="form-control" value="<?php echo $service_package_name;?>" autocomplete="off">
                    </div>
                </div>
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"></label>
                    <div class="form_controls paddingTop18px">
                        <span><button onclick="searchFilter()" name="btn_submit" type="submit" class="btn_submit btn btn-primary"><?php _trans('lable39'); ?></button></span>
                        <span><span id="reset_filter" class="btn"><?php _trans('lable827'); ?></span></span>
                    </div>
                </div>
            </div>
            <div id="posts_content">
                <div class="overflowScrollForTable">
                    <table class="display table datatable table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th><?php _trans('lable540'); ?></th>
                                <th class="text_align_center"><?php _trans('lable541'); ?></th>
                                <th class="text_align_right"><?php _trans('lable399'); ?></th>
                                <th class="text_align_center"><?php _trans('lable22'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(count($service_packages_details) > 0 ){
                            $i = 1;
                            foreach ($service_packages_details as $servicePackagesList) { 
                            if(count($service_packages_details) >= 4)   
                                { 
                                if(count($service_packages_details) == $i || count($service_packages_details) == $i+1)
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
                                <td data-original-title="<?php echo $servicePackagesList->service_package_name;?>" data-toggle="tooltip" class="textEllipsis"> <?php echo $servicePackagesList->service_package_name;?> </td>
                                <td class="text_align_center" data-original-title="<?php echo $servicePackagesList->offer_end_date?date_from_mysql($servicePackagesList->offer_end_date):'-'; ?>" data-toggle="tooltip" class="textEllipsis"><?php echo $servicePackagesList->offer_end_date?date_from_mysql($servicePackagesList->offer_end_date):'-';?></td>
                                <td class="text_align_right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($servicePackagesList->user_price,$this->session->userdata('default_currency_digit'));?>" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($servicePackagesList->user_price,$this->session->userdata('default_currency_digit')); ?></td>
                                <td class="text_align_center">
                                    <div class="options btn-group <?php echo $dropup; ?>">
                                        <a class="btn btn-default btn-sm dropdown-toggle"
                                        data-toggle="dropdown" href="#">
                                            <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                        </a>
                                        <ul class="optionTag dropdown-menu">
                                            <li>
                                                <a href="<?php echo site_url('packages/service_packages/'.$servicePackagesList->service_package_id); ?>">
                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo site_url('packages/service_packages_view/'.$servicePackagesList->service_package_id); ?>">
                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable365'); ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_record('service_packages',<?php echo $servicePackagesList->service_package_id ?>,'<?= $this->security->get_csrf_hash(); ?>');">
                                                    <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <?php $i++; } } else { echo '<tr><td colspan="4" class="text-center" > No data found </td></tr>'; } ?>
                        </tbody>
                    </table>
                </div>
                <div class="headerbar-item pull-right"><?php echo $createLinks;?></div>
            </div>
		</div>
	</section>
</div>
<script>

function searchFilter(page_num) {
    page_num = page_num?page_num:0;
    var package_from_date = $('#package_from_date').val()?$('#package_from_date').val():'';
    var package_to_date = $('#package_to_date').val()?$('#package_to_date').val():'';
    var service_package_name = $('#service_package_name').val()?$('#service_package_name').val():'';
        $.post('<?php echo site_url('packages/ajax/get_filter_list'); ?>', {
        page : page_num,
        package_from_date : package_from_date,
        package_to_date   : package_to_date,
        service_package_name : service_package_name,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            var html = '';
            html += '<div class="overflowScrollForTable">';
            html += '<table class="display table datatable table-bordered" cellspacing="0" width="100%">';
            html += '<thead>';
            html += '<tr>';
            html += '<th><?php _trans("lable540"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable541"); ?></th>';
            html += '<th class="text_align_right"><?php _trans("lable399"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable22"); ?></th>';
            html += '</tr>';
            html += '</thead><tbody>';
            if(list.service_packages_details.length > 0){
                for(var v=0; v < list.service_packages_details.length; v++){ 
                if(list.service_packages_details.length >= 4)
                {
                    if(list.service_packages_details.length == v || list.service_packages_details.length == v+1)
                    {
                        var dropup = "dropup";
                    }
                    else
                    {
                        var dropup = "";
                    }
                }    
                    html += '<tr><td data-original-title="'+list.service_packages_details[v].service_package_name+'" data-toggle="tooltip" class="textEllipsis">'+list.service_packages_details[v].service_package_name+'</td>';
                    html += '<td class="text_align_center" data-original-title="'+(list.service_packages_details[v].offer_end_date?formatDate(list.service_packages_details[v].offer_end_date):"")+'" data-toggle="tooltip" class="textEllipsis">'+(list.service_packages_details[v].offer_end_date?formatDate(list.service_packages_details[v].offer_end_date):"")+'</td>';
                    html += '<td class="text-right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;'+format_money((list.service_packages_details[v].user_price?list.service_packages_details[v].user_price:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;'+format_money((list.service_packages_details[v].user_price?list.service_packages_details[v].user_price:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'</td>';
                    html += '<td class="text_align_center">';
                    html += '<div class="options btn-group '+dropup+'">';   
                    html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">';
                    html += '<i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
                    html += '<ul class="optionTag dropdown-menu"><li>';
                    html += '<a href="<?php echo site_url("packages/service_packages/'+list.service_packages_details[v].service_package_id+'"); ?>">';
                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable44"); ?></a></li>';
                    html += '<a href="<?php echo site_url("packages/service_packages_view/'+list.service_packages_details[v].service_package_id+'"); ?>">';
                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable365"); ?></a></li>';
                    html += '<li><a href="javascript:void(0)" onclick="delete_record(\'service_packages\',\''+list.service_packages_details[v].service_package_id+'\',\'<?= $this->security->get_csrf_hash() ?>\')">';
                    html += '<i class="fa fa-trash-o fa-margin"></i> <?php _trans("lable47"); ?></a></li>';

                    html += '</li></ul></div></td></tr>';
                } 
            }else{ 
                html += '<tr><td colspan="4" class="text-center" > No data found </td></tr>';
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
            $("#package_from_date").val('');
            $("#package_to_date").val('');
            $("#service_package_name").val('');
            searchFilter();
        });
	});
</script>
<?php } ?>