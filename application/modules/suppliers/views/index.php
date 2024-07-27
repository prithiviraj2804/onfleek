<?php if(count($suppliers) < 1) {  ?>
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
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('suppliers/form'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('label921'); ?>
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
                    <h3><?php _trans('lable79'); ?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-sm btn-primary" href="<?php echo site_url('suppliers/form'); ?>">
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
                    <label class="form_label"><?php _trans('lable1211'); ?></label>
                    <div class="form_controls">
                        <input onkeyup="searchFilter()" type="text" name="supplier_no" id="supplier_no" class="form-control" autocomplete="off">
                    </div>
                </div>

                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable80'); ?></label>
                    <div class="form_controls">
                        <input onkeyup="searchFilter()" type="text" name="supplier_name" id="supplier_name" class="form-control" value="<?php echo $name;?>" autocomplete="off">
                    </div>
                </div>    

                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                        <label class="form_label">Category</label>
                        <div class="form_controls">
                            <select onchange="searchFilter()" name="suppliers_category_id" id="suppliers_category_id" class="searchSelect bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true">
                                <?php if(count($suppliercategory)>0){ ?>
                                    <option value=""><?php _trans('lable855'); ?></option>
                                <?php } ?>
                                <?php foreach ($suppliercategory as $suppcategory) {?>
                                <option value="<?php echo $suppcategory->suppliers_category_id; ?>"> <?php echo $suppcategory->suppliers_category_name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable42'); ?></label>
                    <div class="form_controls">
                    <input onkeyup="searchFilter()" type="text" name="supplier_contact_no" id="supplier_contact_no" class="form-control" value="<?php echo $supplier_contact_no;?>" autocomplete="off">
                    </div>
                </div>
                <div class="form_group col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <label class="form_label"><?php _trans('lable41'); ?></label>
                    <div class="form_controls">
                        <input onkeyup="searchFilter()" type="text" name="supplier_email_id" id="supplier_email_id" class="form-control" value="<?php echo $supplier_email_id;?>" autocomplete="off">
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
                <div class="overflowScrollForTable">
                    <table class="display table datatable table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th><?php _trans('lable95'); ?></th>
                                <th><?php _trans('lable1211'); ?></th>
                                <th><?php _trans('lable80'); ?></th>
                                <th class="text_align_left"><?php _trans('lable855'); ?></th>
                                <th class="text_align_center"><?php _trans('lable42'); ?></th>
                                <th class="text_align_left"><?php _trans('lable41'); ?></th>
                                <th class="text_align_right"><?php _trans('lable1219'); ?></th>
                                <th class="text_align_center"><?php _trans('lable22'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($suppliers) > 0) { 
                                $i = 1;
                                foreach ($suppliers as $supplier) { 
                                if(count($suppliers) >= 4)   
                                { 
                                    if(count($suppliers) == $i || count($suppliers) == $i+1)
                                    {
                                        $dropup = "dropup";
                                    }else{
                                        $dropup = "";
                                    }
                                }    
                                ?>
                            <tr>
                                <td class="textEllipsis" data-original-title="<?php _htmlsc($supplier->display_board_name); ?>" data-toggle="tooltip"><?php _htmlsc($supplier->display_board_name); ?></td>
                                <td class="textEllipsis"><a data-original-title="<?php _htmlsc($supplier->supplier_no); ?>" data-toggle="tooltip" href="<?php echo site_url('suppliers/form/'.$supplier->supplier_id); ?>"><?php _htmlsc($supplier->supplier_no); ?></a></td>
                                <td data-original-title="<?php _htmlsc($supplier->supplier_name); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($supplier->supplier_name); ?></td>
                                <td class="textEllipsis" data-original-title="<?php _htmlsc($supplier->suppliers_category_name); ?>" data-toggle="tooltip"><?php _htmlsc($supplier->suppliers_category_name); ?></td>
                                <td class="textEllipsis text_align_center" data-original-title="<?php _htmlsc($supplier->supplier_contact_no); ?>" data-toggle="tooltip"><?php _htmlsc($supplier->supplier_contact_no); ?></td>
                                <td data-original-title="<?php _htmlsc($supplier->supplier_email_id); ?>" data-toggle="tooltip" class="text_align_left textEllipsis">
                                    <?php _htmlsc($supplier->supplier_email_id); ?>
                                </td>
                                <td data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($supplier->total_due_amount,$this->session->userdata('default_currency_digit')); ?>" data-toggle="tooltip" class="text_align_right textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($supplier->total_due_amount,$this->session->userdata('default_currency_digit')); ?></td>
                                <td class="text_align_center">
                                    <div class="options btn-group <?php echo $dropup; ?>">
                                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                                            <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                        </a>
                                        <ul class="optionTag dropdown-menu">
                                            <li>
                                                <a href="<?php echo site_url('suppliers/form/'.$supplier->supplier_id); ?>">
                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_record('suppliers',<?php echo $supplier->supplier_id; ?>,'<?=$this->security->get_csrf_hash(); ?>')" >
                                                    <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php $i++; } } else { echo '<tr><td colspan="5" class="text-center" > No data found </td></tr>'; } ?>
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

<script type="text/javascript">

function searchFilter(page_num){
   
    page_num = page_num?page_num:0;
    var supplier_name = $('#supplier_name').val()?$('#supplier_name').val():'';
    var suppliers_category_id = $("#suppliers_category_id").val()?$("#suppliers_category_id").val():'';
    var branch_id = $("#branch_id").val()?$("#branch_id").val():'';
    var supplier_contact_no = $('#supplier_contact_no').val()?$('#supplier_contact_no').val():'';
    var supplier_email_id = $('#supplier_email_id').val()?$('#supplier_email_id').val():'';
    var supplier_no = $('#supplier_no').val()?$('#supplier_no').val():'';

    $.post('<?php echo site_url('suppliers/ajax/get_filter_list'); ?>', {
        page : page_num,
        supplier_name : supplier_name,
        suppliers_category_id : suppliers_category_id,
        branch_id : branch_id,
        supplier_no : supplier_no,
        supplier_contact_no : supplier_contact_no,
        supplier_email_id : supplier_email_id,
        _mm_csrf: $('#_mm_csrf').val()
    }, function (data) {	
        list = JSON.parse(data);
        if(list.success=='1'){
            var html = '';
            html += '<div class="overflowScrollForTable">';
            html += '<table class="display table datatable table-bordered" cellspacing="0" width="100%">';
            html += '<thead><tr> <th><?php _trans('lable95'); ?></th>';
            html += '<th><?php _trans("lable1211"); ?></th>';            
            html += '<th><?php _trans("lable80"); ?></th>';
            html += '<th><?php _trans("lable855"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable42"); ?></th>';
            html += '<th><?php _trans("lable41"); ?></th>';
            html += '<th class="text_align_right"><?php _trans("lable1219"); ?></th>';
            html += '<th class="text_align_center"><?php _trans("lable22"); ?></th>';
            html += '</tr></thead><tbody>';
            if(list.suppliers.length > 0){
                for(var v=0; v < list.suppliers.length; v++){ 

                if(list.suppliers.length >= 4 )
                {    
                    if(list.suppliers.length == v || list.suppliers.length == v+1)
                    {
                        var dropup = "dropup";
                    }
                    else
                    {
                        var dropup = "";
                    }
                }    
                    html += '<tr><td data-original-title="'+list.suppliers[v].display_board_name+'" data-toggle="tooltip" class="textEllipsis">'+list.suppliers[v].display_board_name+'</td>';
                    html += '<td class="textEllipsis"><a data-original-title="'+(list.suppliers[v].supplier_no?list.suppliers[v].supplier_no:'')+'" data-toggle="tooltip" href="<?php echo site_url("suppliers/form/'+list.suppliers[v].supplier_id+'"); ?>">'+(list.suppliers[v].supplier_no?list.suppliers[v].supplier_no:'')+'</a></td>';
                    html += '<td data-original-title="'+list.suppliers[v].supplier_name+'" data-toggle="tooltip" class="textEllipsis">'+list.suppliers[v].supplier_name+'</td>';
                    html += '<td data-original-title="'+((list.suppliers[v].suppliers_category_name)?list.suppliers[v].suppliers_category_name:" ")+'" data-toggle="tooltip">'+((list.suppliers[v].suppliers_category_name)?list.suppliers[v].suppliers_category_name:" ")+'</td>';
                    html += '<td class="text_align_center" data-original-title="'+list.suppliers[v].supplier_contact_no+'" data-toggle="tooltip" class="textEllipsis">'+list.suppliers[v].supplier_contact_no+'</td>';
                    html += '<td data-original-title="'+list.suppliers[v].supplier_email_id+'" data-toggle="tooltip" class="textEllipsis">'+list.suppliers[v].supplier_email_id+'</td>';
                    html += '<td class="text_align_center textEllipsis" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;'+format_money(((list.suppliers[v].total_due_amount)?list.suppliers[v].total_due_amount:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'" data-toggle="tooltip"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;'+format_money(((list.suppliers[v].total_due_amount)?list.suppliers[v].total_due_amount:0),<?php echo $this->session->userdata("default_currency_digit");?>)+'</td>';
                    html += '<td class="text_align_center">';
                    html += '<div class="options btn-group '+dropup+'">';
                    html += '<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">';
                    html += '<i class="fa fa-cog"></i> <?php _trans("lable22"); ?></a>';
                    html += '<ul class="optionTag dropdown-menu"><li>';
                    html += '<a href="<?php echo site_url("suppliers/form/'+list.suppliers[v].supplier_id+'"); ?>">';
                    html += '<i class="fa fa-edit fa-margin"></i> <?php _trans("lable44"); ?></a></li><li>';
                    html += '<a href="javascript:void(0)" onclick="delete_record(\'suppliers\',\''+list.suppliers[v].supplier_id+'\',\'<?= $this->security->get_csrf_hash() ?>\')">';
                    html += '<i class="fa fa-trash-o fa-margin"></i> <?php _trans("lable47"); ?></a>';
                    html += '</ul></div></td></tr>';
                } 
            }else{ 
                html += '<tr><td colspan="5" class="text-center" > No data found </td></tr>';
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
        $("#branch_id").val('');
        $("#suppliers_category_id").val('');
        $("#supplier_name").val('');
        $("#supplier_contact_no").val('');
        $("#supplier_email_id").val('');
        $("#supplier_no").val('');
        $('.bootstrap-select').selectpicker("refresh");
        searchFilter();
    });
});
</script>
<?php } ?>