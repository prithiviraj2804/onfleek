<?php if(count($feedback) < 1) {  ?>
<script type="text/javascript">
    $(function() {
        var getHeight = $( window ).height();
        $(".imageDynamicHeight").css('height' , getHeight - 200);
    });
</script>
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center imageDynamicHeight" style="display: table;">
    <div class="tbl-cell">
        <img style="width: 30%; text-center" src="<?php echo base_url(); ?>assets/mp_backend/img/no_data_available.jpg" alt="Mechtoolz">
    </div>
</div>
<?php } else { ?>
<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php _trans('lable1189'); ?></h3>
                </div>
            </div>
        </div>
    </div>
</header>
<div id="content" class="table-content">
    <section class="card">
		<div class="card-block">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 padding0px">
            <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
            <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                        <label class="form_label"><?php _trans('lable1190'); ?></label>
                <div class="form_controls">
                    <input onkeyup="searchFilter()" type="text" name="feedback_no" id="feedback_no" class="form-control" autocomplete="off">
                </div>
            </div>

            <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<label class="form_label"><?php _trans('lable29'); ?></label>
				<div class="form_controls">
					<select onchange="searchFilter()" name="invoice_no" id="invoice_no" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
						<option value=""><?php _trans('lable295'); ?></option>
						<?php foreach ($feedback as $invoice){ ?>
							<option value="<?php echo $invoice->invoice_id; ?>"><?php echo $invoice->invoice_no;  ?></option>
						<?php } ?>
					</select>
				</div>
			</div>

            <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <label class="form_label"><?php _trans('lable175'); ?></label>
                <div class="form_controls">
                    <input onchange="searchFilter()" type="text" name="from_date" id="from_date" class="form-control datepicker" autocomplete="off">
                </div>
            </div>
            <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <label class="form_label"><?php _trans('lable176'); ?></label>
                <div class="form_controls">
                    <input onchange="searchFilter()" type="text" name="to_date" id="to_date" class="form-control datepicker" autocomplete="off">
                </div>
            </div>
           
            <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <label class="form_label"></label>
                <div class="form_controls paddingTop18px">
                    <span><button onclick="searchFilter()" name="btn_submit" type="submit" class="btn_submit btn btn-primary"><?php _trans('lable39'); ?></button></span>
                    <span><span id="reset_filter" class="btn"><?php _trans('lable827'); ?></span></span>
                </div>
            </div>
        <div id="posts_content">
            <div class="overflowScrollForTable">
                <table class="display table datatable table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="text_align_center"><?php _trans('lable125'); ?></th>
                            <th class="text_align_center"><?php _trans('lable31'); ?></th>
                            <th class="text_align_center"><?php _trans('lable1190'); ?></th>
                            <th class="text_align_center"><?php _trans('lable29'); ?></th>
                            <th class="text_align_center"><?php _trans('lable19'); ?></th>
                            <th class="text_align_center"><?php _trans('lable22'); ?></th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($feedback)) { 
                            $i = 1;
                        foreach ($feedback as $key => $feed) { ?>
                        <tr>
                            <td class="text_align_center" data-original-title="<?php echo $i; ?>" data-toggle="tooltip" class="textEllipsis"><?php echo $i; ?></td>
                            <td class="text_align_center" data-original-title="<?php if($feed->reschedule_date != "" && $feed->reschedule_date != "0000-00-00 00:00:00"){echo " ".date("d-m-Y H:i:s", strtotime($feed->reschedule_date))."";} ?>" data-toggle="tooltip" class="textEllipsis"><?php if($feed->reschedule_date != "" && $feed->reschedule_date != "0000-00-00 00:00:00"){echo " ".date("d-m-Y H:i:s", strtotime($feed->reschedule_date))."";} ?></td>
                            <td class="text_align_center" data-original-title="<?php _htmlsc($feed->feedback_no);?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($feed->feedback_no); ?></td>
                            <td class="text_align_center" data-original-title="<?php _htmlsc($feed->invoice_no); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($feed->invoice_no); ?></td>
                            
                            <td class="text_align_center" data-original-title="
                                    <?php if($feed->fd_status == "N"){ echo _trans('lable40');  } ?>
									<?php if($feed->fd_status == "PR"){ echo _trans('lable1192');  } ?>
									<?php if($feed->fd_status == "PE"){ echo _trans('lable560'); } ?>
									<?php if($feed->fd_status == "CC"){ echo _trans('lable1193');  } ?>
                                    <?php if($feed->fd_status == "CO"){ echo _trans('lable535');  } ?>
                                    <?php if($feed->fd_status == "CL"){ echo _trans('lable1194');  } ?>
                                    <?php if($feed->fd_status == "RO"){ echo _trans('lable1195');  } ?>" 
                                    data-toggle="tooltip" class="textEllipsis">								    
                                    <?php if($feed->fd_status == "N"){ echo _trans('lable40');  } ?>
									<?php if($feed->fd_status == "PR"){ echo _trans('lable1192');  } ?>
									<?php if($feed->fd_status == "PE"){ echo _trans('lable560'); } ?>
									<?php if($feed->fd_status == "CC"){ echo _trans('lable1193');  } ?>
                                    <?php if($feed->fd_status == "CO"){ echo _trans('lable535');  } ?>
                                    <?php if($feed->fd_status == "CL"){ echo _trans('lable1194');  } ?>
                                    <?php if($feed->fd_status == "RO"){ echo _trans('lable1195');  } ?>  								
                            </td>

                            

                            <td class="text_align_center">
								<div class="options btn-group">
									<a class="btn btn-default btn-sm dropdown-toggle"
									data-toggle="dropdown" href="#">
										<i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
									</a>
									<ul class="optionTag dropdown-menu">
										<li>
                                            <a href="<?php echo site_url('mech_add_feedback/form/'.$feed->fb_id); ?>">
                                            <i class="fa fa-edit fa-margin"></i> <?php _trans('lable1191'); ?>
                                            </a>
										</li>
									</ul>
								</div>
							</td>
                        </tr>
                        <?php $i++; } } else { echo '<tr><td colspan="2" class="text-center" > No data found </td></tr>'; } ?>
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

function searchFilter(page_num) {
    page_num = page_num?page_num:0;
    var from_date = $('#from_date').val()?$('#from_date').val():'';
    var to_date = $('#to_date').val()?$('#to_date').val():'';
    var feedback_no = $('#feedback_no').val()?$('#feedback_no').val():'';
    var invoice_no = $('#invoice_no').val()?$('#invoice_no').val():'';

    $.post('<?php echo site_url('mech_add_feedback/ajax/get_filter_list'); ?>', {
        page : page_num,
        from_date : from_date,
        to_date   : to_date,
        feedback_no : feedback_no,
        invoice_no : invoice_no,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            var html = '';
            html += '<div class="overflowScrollForTable">';
            html += '<table class="display table datatable table-bordered" cellspacing="0" width="100%">';
            html += '<thead><tr><th class="text_align_center"><?php _trans("lable125"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable1205"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable1190"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable29"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable19"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable22"); ?></th>'; 
            html += '</tr></thead><tbody>';
            if(list.feedback.length > 0){
                for(var v=0; v < list.feedback.length; v++){     
                    html += '<tr><td class="text_align_center" data-original-title="'+[v+1]+'" data-toggle="tooltip" class="textEllipsis">'+[v+1]+'</td>';
                    html += '<td class="text_align_center" data-original-title="'+(list.feedback[v].reschedule_date?formatDatetimechange(list.feedback[v].reschedule_date):"")+'" class="text_align_center" data-toggle="tooltip" class="textEllipsis">'+(list.feedback[v].reschedule_date?formatDatetimechange(list.feedback[v].reschedule_date):"")+'</td>';
                    html += '<td class="text_align_center" data-original-title="'+((list.feedback[v].feedback_no)?list.feedback[v].feedback_no:" ")+'" data-toggle="tooltip" class="textEllipsis">'+((list.feedback[v].feedback_no)?list.feedback[v].feedback_no:" ")+'</td>';
                    html += '<td class="text_align_center" data-original-title="'+((list.feedback[v].invoice_no)?list.feedback[v].invoice_no:" ")+'" data-toggle="tooltip" class="textEllipsis">'+((list.feedback[v].invoice_no)?list.feedback[v].invoice_no:" ")+'</td>';
                    html += '<td class="text_align_center" data-original-title="';
                    if(list.feedback[v].fd_status == "N"){
						html += '<?php _trans("lable40"); ?>';
					}else if(list.feedback[v].fd_status == "PR"){
						html += '<?php _trans("lable1192"); ?>';
					}else if(list.feedback[v].fd_status == "PE"){
						html += '<?php _trans("lable560"); ?>';
					}else if(list.feedback[v].fd_status == "CC"){
						html += '<?php _trans("lable1193"); ?>';
					}else if(list.feedback[v].fd_status == "CO"){
						html += '<?php _trans("lable535"); ?>';
					}else if(list.feedback[v].fd_status == "CL"){
						html += '<?php _trans("lable1194"); ?>';
					}else if(list.feedback[v].fd_status == "RO"){
						html += '<?php _trans("lable1195"); ?>';
					}
					html += '" data-toggle="tooltip" class="textEllipsis">';
					if(list.feedback[v].fd_status == "N"){
						html += '<?php _trans("lable40"); ?>';
					}else if(list.feedback[v].fd_status == "PR"){
						html += '<?php _trans("lable1192"); ?>';
					}else if(list.feedback[v].fd_status == "PE"){
						html += '<?php _trans("lable560"); ?>';
					}else if(list.feedback[v].fd_status == "CC"){
						html += '<?php _trans("lable1193"); ?>';
					}else if(list.feedback[v].fd_status == "CO"){
						html += '<?php _trans("lable535"); ?>';
					}else if(list.feedback[v].fd_status == "CL"){
						html += '<?php _trans("lable1194"); ?>';
					}else if(list.feedback[v].fd_status == "RO"){
						html += '<?php _trans("lable1195"); ?>';
					}
					html += '</td>'; 
                    html += '<td class="text-center"><div class="options btn-group">';
					html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">';
					html += '<i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
					html += '<ul class="optionTag dropdown-menu">';
                    html += '<li><a target="_blank" href="<?php echo site_url("mech_add_feedback/form/'+list.feedback[v].fb_id+'"); ?>">';
					html += '<i class="fa fa-edit fa-margin" aria-hidden="true"></i></i> <?php _trans("lable1191"); ?></a></li>';
					html += '</ul></td>';
                    html +='</tr>';
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
        $("#from_date").val('');
        $("#to_date").val('');
        $("#feedback_no").val('');
        $("#invoice_no").val('');
        $('.bootstrap-select').selectpicker("refresh");
        searchFilter();
    });

});
</script>
<?php } ?>