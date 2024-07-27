<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php _trans('lable269'); ?> <small class="text-muted"></small></h3>
				</div>
				<div class="tbl-cell pull-right">
					<a class="btn btn-sm btn-primary" id="btn_cancel" href="javascript:void(0)" >
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
                            <option value="<?php echo $branchList->w_branch_id; ?>" <?php if($branch_id == $branchList->w_branch_id){echo "selected";}?> > <?php echo $branchList->display_board_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable270'); ?></label>
                    <div class="form_controls">
                        <input onkeyup="searchFilter()" type="text" name="jobsheet_no" id="jobsheet_no" class="form-control" value="<?php echo $jobsheet_no;?>" autocomplete="off">
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
                                <th><?php _trans('lable278');?></th>
                                <th><?php _trans('lable95'); ?></th>
                                <th><?php _trans('lable20');?>.</th>
                                <th><?php _trans('lable36');?></th>
                                <th><?php _trans('lable273');?></th>
                                <th><?php _trans('lable19');?></th>
                                <th class="text-center"><?php _trans('lable22');?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(count($work_orders)>0) {
                            $i = 1;
                            foreach ($work_orders as $work_ord_list) { 
                             if(count($work_orders) >= 4)
                             {  
                                if(count($work_orders) == $i || count($work_orders) == $i+1)
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
                                <td data-original-title="<?php _htmlsc($work_ord_list->issue_date?date_from_mysql($work_ord_list->issue_date):'-'); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($work_ord_list->issue_date?date_from_mysql($work_ord_list->issue_date):'-'); ?></td>
                                <td data-original-title="<?php _htmlsc($work_ord_list->display_board_name); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($work_ord_list->display_board_name); ?></td>
                                <td data-original-title="<?php _htmlsc($work_ord_list->jobsheet_no); ?>" data-toggle="tooltip" class="textEllipsis"><a href="<?php echo site_url('mech_work_order_dtls/view/'.$work_ord_list->work_order_id.'/0/'.$work_ord_list->jobsheet_status); ?>"><?php _htmlsc($work_ord_list->jobsheet_no); ?></a></td>
                                <td data-original-title="<?php _htmlsc($work_ord_list->client_name); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($work_ord_list->client_name); ?></td>
                                <td data-original-title="<?php echo $work_ord_list->car_reg_no; ?> <?php _htmlsc(($work_ord_list->brand_name?$work_ord_list->brand_name:" ")." ".($work_ord_list->model_name?$work_ord_list->model_name:" ")." ".($work_ord_list->variant_name?$work_ord_list->variant_name:' ')." ".($work_ord_list->car_model_year?$work_ord_list->car_model_year:" "));?>" data-toggle="tooltip" class="textEllipsis"><span class="car_reg_no"><?php echo $work_ord_list->car_reg_no; ?></span><br><?php _htmlsc(($work_ord_list->brand_name?$work_ord_list->brand_name:" ")." ".($work_ord_list->model_name?$work_ord_list->model_name:" ")." ".($work_ord_list->variant_name?$work_ord_list->variant_name:' ')." ".($work_ord_list->car_model_year?$work_ord_list->car_model_year:" ")); ?></td>
                                <td data-original-title="<?php if($work_ord_list->jobsheet_status == 'P'){
                                        echo _htmlsc("Pending");
                                }elseif($work_ord_list->jobsheet_status == 'C'){
                                        echo _htmlsc("Completed");
                                }else if($work_ord_list->jobsheet_status == 'Y'){
                                    echo _htmlsc("Yet to start");
                                }else if($work_ord_list->jobsheet_status == 'RA'){
                                    echo _htmlsc("Re-Assigned");
                                } ?>" data-toggle="tooltip" class="textEllipsis">
                                
                                <?php 
                                if($work_ord_list->jobsheet_status == 'P'){
                                        echo _htmlsc("Pending");
                                }elseif($work_ord_list->jobsheet_status == 'C'){
                                        echo _htmlsc("Completed");
                                }else if($work_ord_list->jobsheet_status == 'Y'){
                                    echo _htmlsc("Yet to start");
                                }else if($work_ord_list->jobsheet_status == 'RA'){
                                    echo _htmlsc("Re-Assigned");
                                }?>
                                </td>
                                <td class="text_align_center">
                                <div class="options btn-group <?php echo $dropup; ?>">
                                    <a class="btn btn-default btn-sm dropdown-toggle"
                                    data-toggle="dropdown" href="#">
                                        <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                    </a>
                                    <ul class="optionTag dropdown-menu">
                                        <li>
                                            <a href="<?php echo site_url('mech_work_order_dtls/book/'.$work_ord_list->work_order_id.'/1/'.$work_ord_list->jobsheet_status); ?>">
                                                <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                            </a>
                                        </li>
                                        <li>
                                            <a target="_blank" href="<?php echo site_url('mech_work_order_dtls/generate_pdf/'.$work_ord_list->work_order_id); ?>">
                                                <i class="fa fa-edit fa-margin"></i> <?php _trans('lable141'); ?>
                                            </a>
                                        </li>
                                        <?php if($this->session->userdata('job_card_E') == 1){ ?>
                                        <li>
                                            <a href="javascript:void(0)" onclick="sendmail(<?php echo $work_ord_list->work_order_id;?>)">
                                                <i class="fa fa-edit fa-margin"></i> <?php _trans('lable274'); ?>
                                            </a>
                                        </li>
                                        <?php } ?>
                                        <li>
                                            <a href="javascript:void(0)" onclick="remove_jobsheet(<?php echo $work_ord_list->work_order_id; ?>, '<?= $this->security->get_csrf_hash() ?>')"> <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?></a>
                                        
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            </tr>
                        <?php $i++; } } else { echo '<tr><td colspan="7" class="text-center" > No data found </td></tr>'; } ?>
                        </tbody>
                    </table>
                </div>
                <div class="headerbar-item pull-right">
                    <?php echo $createLinks;?>
                </div>
            </div>
    	</div>
	</section>
</div>
<script>
function sendmail(work_order_id){
    $('#modal-placeholder').load("<?php echo site_url('mailer/model_mech_jobcard'); ?>/"+work_order_id);
}
function searchFilter(page_num) {
    page_num = page_num?page_num:0;
    var from_date = $('#from_date').val()?$('#from_date').val():'';
    var branch_id = $("#branch_id").val()?$("#branch_id").val():'';
    var to_date = $("#to_date").val()?$("#to_date").val():'';
    var jobsheet_status = $("#jobsheet_status").val()?$("#jobsheet_status").val():'';
    var invoice_number = $('#invoice_number').val()?$('#invoice_number').val():'';
    var customer_id = $('#customer_id').val()?$('#customer_id').val():'';

    $.post('<?php echo site_url('mech_work_order_dtls/ajax/get_filter_list'); ?>', {
        page : page_num,
        from_date : from_date,
        branch_id : branch_id,
        to_date : to_date,
        jobsheet_status : jobsheet_status,
        invoice_number : invoice_number,
        customer_id : customer_id,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            var html = '';
            html += '<div class="overflowScrollForTable">';
            html += '<table class="display table datatable table-bordered" cellspacing="0" width="100%">';
            html += '<thead><tr><th><?php _trans("lable278");?></th>';
            html += '<th><?php _trans("lable95"); ?></th>';
            html += '<th><?php _trans("lable20");?>.</th>';
            html += '<th><?php _trans("lable36");?></th>';
            html += '<th><?php _trans("lable273");?></th>';
            html += '<th><?php _trans("lable19");?></th>';
            html += '<th class="text-center"><?php _trans("lable22");?></th>';
            html += '</tr></thead><tbody>';
            if(list.work_orders.length > 0){
                for(var v=0; v < list.work_orders.length; v++){ 

                if(list.work_orders.length >= 4)
                {    
                    if(list.work_orders.length == v || list.work_orders.length == v+1)
                    {
                        var dropup = "dropup";
                    }
                    else
                    {
                        var dropup = "";
                    }
                }    
                    html += '<td data-original-title="';
					html += list.work_orders[v].issue_date?formatDate(list.work_orders[v].issue_date):"";
                    html += '" data-toggle="tooltip" class="textEllipsis">';
                    html += (list.work_orders[v].issue_date?formatDate(list.work_orders[v].issue_date):"");
                    html += '</td>';
                    html += '<td data-original-title="'+((list.work_orders[v].display_board_name)?list.work_orders[v].display_board_name:" ")+'" data-toggle="tooltip" class="textEllipsis">'+((list.work_orders[v].display_board_name)?list.work_orders[v].display_board_name:" ")+'</td>';
                    html += '<td data-original-title="'+(list.work_orders[v].jobsheet_no)+'" data-toggle="tooltip" class="textEllipsis"><a href="<?php echo site_url("mech_work_order_dtls/view/'+list.work_orders[v].work_order_id+'"/0/'+list.work_orders[v].jobsheet_status+'); ?>">'+list.work_orders[v].jobsheet_no+'</a></td>';
                    html += '<td data-original-title="'+(list.work_orders[v].client_name)+'" data-toggle="tooltip" class="textEllipsis">'+list.work_orders[v].client_name+'</td>';
                    html += '<td data-original-title="'+(list.work_orders[v].car_reg_no?list.work_orders[v].car_reg_no:" ")+' '+(list.work_orders[v].brand_name?list.work_orders[v].brand_name:" ")+' '+(list.work_orders[v].model_name?list.work_orders[v].model_name:" ")+' '+(list.work_orders[v].variant_name?list.work_orders[v].variant_name:" ")+' '+(list.work_orders[v].car_model_year?list.work_orders[v].car_model_year:" ")+'" data-toggle="tooltip" class="textEllipsis"><span class="car_reg_no">'+(list.work_orders[v].car_reg_no?list.work_orders[v].car_reg_no:" ")+'</span><br>'+(list.work_orders[v].brand_name?list.work_orders[v].brand_name:" ")+' '+(list.work_orders[v].model_name?list.work_orders[v].model_name:" ")+' '+(list.work_orders[v].variant_name?list.work_orders[v].variant_name:" ")+' '+(list.work_orders[v].car_model_year?list.work_orders[v].car_model_year:" ")+'</td>';
                    html += '<td class="text-center" data-original-title="';

                    if(list.work_orders[v].jobsheet_status == 'P'){
                        html += "Pending";
                    }else if(list.work_orders[v].jobsheet_status == 'C'){
                        html += "Completed";
                    }else if(list.work_orders[v].jobsheet_status == 'Y'){
                        html += "Yet to start";
                    }else if(list.work_orders[v].jobsheet_status == 'RA'){
                        html += "Re-Assigned";
                    }
					html += '" data-toggle="tooltip" class="textEllipsis">';

                    if(list.work_orders[v].jobsheet_status == 'P'){
                        html += "Pending";
                    }else if(list.work_orders[v].jobsheet_status == 'C'){
                        html += "Completed";
                    }else if(list.work_orders[v].jobsheet_status == 'Y'){
                        html += "Yet to start";
                    }else if(list.work_orders[v].jobsheet_status == 'RA'){
                        html += "Re-Assigned";
                    }
                    html += '</td>';
                    html += '<td class="text_align_center">';
                    html += '<div class="options btn-group '+dropup+'">';
                    html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">';
                    html += '<i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
                    html += '<ul class="optionTag dropdown-menu">';
                    html += '<li><a href="<?php echo site_url("mech_work_order_dtls/book/'+list.work_orders[v].work_order_id+'/1/'+list.work_orders[v].jobsheet_status+'"); ?>">';
                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable44"); ?></a></li>';
                    html += '<li><a target="_blank" href="<?php echo site_url("mech_work_order_dtls/generate_pdf/'+list.work_orders[v].work_order_id+'"); ?>">';
                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable141"); ?></a></li>';
                    if(list.job_card_E == 1){
                        html += '<li><a href="javascript:void(0)" onclick="sendmail('+list.work_orders[v].work_order_id+')">';
                        html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable274"); ?></a></li>';
                    }
                    html += '<li>';
                    html += '<a href="javascript:void(0)" onclick="delete_record(\'mech_work_order_dtls\',\''+list.work_orders[v].work_order_id+'\',\'<?= $this->security->get_csrf_hash() ?>\')">';
                    html += '<i class="fa fa-trash-o fa-margin"></i> <?php _trans("lable47"); ?></a></li>';
                    html += '</li></ul></div></td></tr>';
                } 
            }else{ 
                html += '<tr><td colspan="7" class="text-center" > No data found </td></tr>';
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


    $("#btn_cancel").click(function () {
		window.location.href = "<?php echo site_url('workshop_setup/index/10'); ?>";
    });

    $(".card-block input").keypress(function (e) {
        if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
            $('.btn_submit').click();
            return false;
        } else {
            return true;
        }
    });

    $("#reset_filter").click(function () {
        $("#from_date").val('');
        $("#to_date").val('');
        $("#branch_id").val('');
        $("#jobsheet_status").val('');
        $("#jobsheet_no").val('');
        $("#invoice_number").val('');
        $("#customer_id").val('');
        $('.bootstrap-select').selectpicker("refresh");
        searchFilter();
    });

});

</script>