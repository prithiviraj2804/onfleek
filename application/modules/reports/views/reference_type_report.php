<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php _trans('lable975'); ?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-rounded btn-primary btn-padding-left-right-40" target="_blank" href="<?php echo site_url('reports/generate_pdf/ReferenceTypeReport/'.date_to_mysql($from_date).'/'.date_to_mysql($to_date).'/'.$user_branch_id.'/'.$refered_by_type.'/'.$refered_by_id); ?>">
                        <i class="fa fa-edit fa-margin"></i> <?php _trans('lable141'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container row">
    <div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 top-15">
			<a class="anchor anchor-back" href="<?php echo site_url('reports/index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
		</div>
	</div>
    <form method="POST" action="<?php echo site_url($this->uri->uri_string()); ?>">
    <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
        <div class='col-lg-4 col-md-6 col-sm-6 col-xs-12'>
            <div class="form-group">
                <label><?php _trans('lable361'); ?></label>
                <div class='input-group'>
                    <input type='text' name="from_date" id="from_date" value="<?php echo $from_date; ?>" class="form-control datepicker" />
                    <label class="input-group-addon" for="from_date">
                        <span class="fa fa-calendar"></span>
                    </label>  
                </div>
            </div>
        </div>
        <div class='col-lg-4 col-md-6 col-sm-6 col-xs-12'>
            <div class="form-group">
                <label><?php _trans('lable630'); ?></label>
                <div class='input-group'>
                    <input type='text' name="to_date" id="to_date" value="<?php echo $to_date; ?>" class="form-control datepicker" />
                    <label class="input-group-addon" for="to_date">
                        <span class="fa fa-calendar"></span>
                    </label> 
                </div>
            </div>
        </div>
        <div class='col-lg-4 col-md-6 col-sm-6 col-xs-12'>
            <div class="form-group">
                <label><?php _trans('lable95'); ?></label>
                <div class='input-group'>
                    <select id="user_branch_id" name="user_branch_id" class="bootstrap-select bootstrap-select-arrow g-input form-control" data-live-search="true" >
                        <?php if($this->session->userdata('user_id') == 1 || $this->session->userdata('user_type') == 3){ ?>
                            <option <?php if($branchList->w_branch_id == $user_branch_id){ echo "selected";} ?> value="ALL"><?php _trans('lable629'); ?></option>
                        <?php } ?>
                        <?php foreach ($branch_list as $branchList) {?>
                        <option value="<?php echo $branchList->w_branch_id; ?>" <?php if($branchList->w_branch_id == $user_branch_id){ echo "selected";} ?>> <?php echo $branchList->display_board_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class='col-lg-4 col-md-6 col-sm-6 col-xs-12'>
            <div class="form-group">
                <label><?php _trans('lable52'); ?></label>
                <div class='input-group'>
                <select name="refered_by_type" id="refered_by_type" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                            <option value=""><?php _trans('lable53'); ?></option>
                            <?php foreach ($reference_type_list as $rtype) {?>
                                <option value="<?php echo $rtype->refer_type_id; ?>" <?php if($rtype->refer_type_id == $refered_by_type){ echo "selected";} ?>><?php echo $rtype->refer_name; ?></option>
                            <?php } ?>
                        </select> 
                </div>
            </div>
        </div>

        <div class='col-lg-4 col-md-6 col-sm-6 col-xs-12'>
            <div class="form-group">
                <label><?php _trans('lable291'); ?></label>
                <div class='input-group'>
                <select name="refered_by_id" id="refered_by_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                            <option value=""><?php _trans('lable55'); ?></option>
                            <?php foreach ($refered_dtls as $refered) {
                                            if ($refered_by_type == 2) {
                                                $id = $refered->employee_id;
                                                $name = $refered->employee_name.' - '.$refered->mobile_no;
                                            } elseif ($refered_by_type == 1) {
                                                $id = $refered->client_id;
                                                $name = $refered->client_name.' - '.$refered->client_contact_no;
                                            }elseif ($refered_by_type == 3) {
                                                $id = $refered->supplier_id;
                                                $name = $refered->supplier_name.' - '.$refered->supplier_contact_no;
                                            }
                                            if ($refered_by_id == $id) {
                                                $selected = 'selected="selected"';
                                            } else {
                                                $selected = '';
                                            } ?>
                            <option value="<?php echo $id; ?>" <?php echo $selected; ?>><?php echo $name; ?></option>
                            <?php  } ?>
                        </select>
                </div>
            </div>
        </div>
        <div class='col-md-4' style="padding: 20px 0px 0px 17px;">
            <div class="form-group">
                <div class='input-group'>
                    <input type="submit" class="btn btn-success" name="btn_submit" value="<?php _trans('lable628'); ?>">
                </div>
            </div>
        </div>
    </form>
</div>
<div id="content" class="table-content">
    <?php $this->layout->load_view('layout/alerts'); ?>
    <section class="card">
        <div class="card-block">
            <div class="overflowScrollForTable">
                <table class="display table table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th><?php _trans('lable976'); ?></th>
                            <th class="text_align_center" ><?php _trans('lable368'); ?></th>
                            <th class="text_align_center"><?php _trans('lable640'); ?></th>
                            <th class="text_align_right"><?php _trans('lable332'); ?></th>
                            <th class="text_align_right"><?php _trans('lable978'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($results) > 0){
                            $overall_grand_total = 0;
                            $overallInvoiceCount = 0;
                            $overallCommissionCount = 0;
                        foreach ($results as $result){ 
                            $overallInvoiceCount += $result->invoice_count;
                            $overall_grand_total += $result->grand_total; 
                            $overallCommissionCount += 0 ?>
                            <tr>
                                <td class="text_align_left"><?php echo $result->refer_name; ?> <br> <?php echo $result->entity_name; ?></td>
                                <td class="text_align_center"><?php echo date_from_mysql($result->invoice_date); ?></td>
                                <td class="text_align_center"><?php echo $result->invoice_count; ?></td>
                                <td class="text_align_right"><?php echo $result->grand_total; ?></td>
                                <td class="text_align_right"><?php echo 0 ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="text-center">
                                <span><strong><?php _trans('lable885'); ?> = </strong><strong><?php echo $overallInvoiceCount; ?></strong></span>
                            </td>
                            <td class="text-right">
                                <span class="float_right"><strong><?php _trans('lable625'); ?> = </strong><strong><?php echo format_currency($overall_grand_total, 2); ?></strong></span>
                            </td>
                            <td class="text-right">
                                <span class="float_right"><strong><?php _trans('lable979'); ?> = </strong><strong><?php echo format_currency($overallCommissionCount, 2); ?></strong></span>
                            </td
                        <tr>
                        <?php }else{ ?>
                        <tr>
                            <td colspan="5" align="center"><?php _trans('lable343'); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">

    $(".btn").click(function() {

    $('.has-error').removeClass('has-error');
    $('.border_error').removeClass("border_error");

    var validation = [];

    if($("#refered_by_type").val() == ''){
        validation.push('refered_by_type');
    }
    if(validation.length > 0){
        validation.forEach(function(val) {
            $('#'+val).addClass("border_error");
            $('#' + val).parent().addClass('has-error');
            if($('#'+val+'_error').length == 0){
                $('#' + val).parent().addClass('has-error');
            } 
        });
        return false;
    }
        });

    $(function() {
        $('#datetimepicker6').datetimepicker();
        $('#datetimepicker7').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
        $("#datetimepicker6").on("dp.change", function(e) {
            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker7").on("dp.change", function(e) {
            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
        });
    });

    $('#refered_by_type').change(function() {
            var refered_by_type = $('#refered_by_type').val();

            if (refered_by_type == '1' || refered_by_type == '2' || refered_by_type == '3') {
                if (refered_by_type == '2') {
                    var site_url = "<?php echo site_url('mech_employee/ajax/get_employee_list'); ?>";
                } else if (refered_by_type == '1') {
                    var site_url = "<?php echo site_url('clients/ajax/get_client_list'); ?>";
                }else if (refered_by_type == '3') {
                    var site_url = "<?php echo site_url('suppliers/ajax/get_supplier_list'); ?>";
                }
                
                $.post(site_url, {
                    refered_by_type: $('#refered_by_type').val(),
                    _mm_csrf: $('#_mm_csrf').val()
                },
                function(data) {
                    var response = JSON.parse(data);
                    carResponse = response;
                    var rid = '';
                    var name = '';
                    var phone = '';
                    $('#refered_by_id').empty();
                    if (refered_by_type == '2') {
                        $('#refered_by_id').append($('<option></option>').attr('value', '').text('Select Employee'));
                    } else if (refered_by_type == '1') {
                        $('#refered_by_id').append($('<option></option>').attr('value', '').text('Select Customer'));
                    } else if (refered_by_type == '3') {
                        $('#refered_by_id').append($('<option></option>').attr('value', '').text('Select Supplier'));
                    }

                    if (response.length > 0) {
                        for (row in response) {
                            if (refered_by_type == '2') {
                                rid = response[row].employee_id;
                                name = response[row].employee_name;
                                phone = response[row].mobile_no;
                            } else if (refered_by_type == '1') {
                                rid = response[row].client_id;
                                name = response[row].client_name;
                                phone = response[row].client_contact_no;
                            }else if (refered_by_type == '3') {
                                rid = response[row].supplier_id;
                                name = response[row].supplier_name;
                                phone = response[row].supplier_contact_no;
                            }
                            $('#refered_by_id').append($('<option></option>').attr('value', rid).text(name + ' ' + phone));
                        }
                        $('#refered_by_id').selectpicker("refresh");
                    } else {
                        $('#refered_by_id').selectpicker("refresh");
                    }
                });
            } else {
                console.log('refered_by_type else');
            }
        });      

</script> 
<style>
  @media screen and (min-width:768) {
    .ipad_lan {
        width: 20% !importent;    }
}
  </style>  