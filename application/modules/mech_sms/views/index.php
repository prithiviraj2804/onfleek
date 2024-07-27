<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php _trans('SMS'); ?></h3>
                </div>
            </div>
        </div>
    </div>
</header>
<div id="content" class="table-content">
    <?php $this->layout->load_view('layout/alerts'); ?>
    <section class="card">
        <div class="card-block" style="min-height: 250px;">
            <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="col-lg-3 col-md-3 col-sm-3"><input type="radio" class="checkbox" name="sms" checked id="singlesms" value="1"> Single Sms</div>
                <div class="col-lg-3 col-md-3 col-sm-3"><input type="radio" class="checkbox" name="sms" id="bulkysms" value="2"> Bulk Sms</div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div id="singlesmsbox">
                    <div class="col-lg-4 col-md-4 col-sm-4 paddingTop20px">
                        <label class="form_label"><?php _trans('Select Customer'); ?>*</label>
                        <select name="client" id="client" class="removeError bootstrap-select bootstrap-select-arrow" data-live-search="true">
                            <option value="">Select customer</option>
                            <?php if(!empty($clients)){
                            foreach ($clients as $clientslist) { ?>
                            <option value="<?php echo $clientslist->client_id; ?>" <?php echo $selected; ?>><?php echo $clientslist->client_name; ?></option>
                            <?php }} ?>
                        </select>
                    </div>
                </div>
                <div id="bulksmsbox" style="display:none;">
                    <div class="col-lg-8 col-md-8 col-sm-8 paddingTop20px">
                        <label class="form_label"><?php _trans('Select Customers'); ?>*</label>
                        <select name="clients[]" id="clients" class="select2" multiple="multiple" autocomplete="off">
                            <?php if(!empty($clients)){
                            foreach ($clients as $clientslist) { ?>
                            <option value="<?php echo $clientslist->client_id; ?>" <?php echo $selected; ?>><?php echo $clientslist->client_name; ?></option>
                            <?php }} ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="col-lg-8 col-md-8 col-sm-8 paddingTop20px">
                    <label class="form_label"><?php _trans('Text message'); ?>*</label>
                    <textarea rows="4" cols="50" id="text_message" maxlength="150" class="form-control"></textarea> 
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 buttons text-center hideSubmitButtons paddingTop40px">
                <button value="1" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
                    <i class="fa fa-check"></i> <?php _trans('Send SMS'); ?>
                </button>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">

$(function() {

    $(".select2").select2();
    $(".bootstrap-select").selectpicker("refresh");
    //select all checkboxes
    $("#singlesms").change(function(){  //"select all" change 
        $("#singlesmsbox").show();
        $("#bulksmsbox").hide();
    });

    $("#bulkysms").change(function(){  //"select all" change 
        $("#singlesmsbox").hide();
        $("#bulksmsbox").show();
    });


    $(".btn_submit").click(function () {

        $('.border_error').removeClass('border_error');
        $('.has-error').removeClass('has-error');

        var validation = [];

        if($('#singlesms').is(':checked')){ 
            if($("#client").val() == ''){
                validation.push('client');
            }
        }

        if($('#bulkysms').is(':checked')){ 
            if($("#clients").val() == ''){
                validation.push('clients');
            }
        }
        
        if($("#text_message").val() == ''){
            validation.push('text_message');
        }

        if(validation.length > 0){
            validation.forEach(function(val) {
                $('#'+val).addClass("border_error");
                if($('#'+val+'_error').length == 0){
                    $('#'+val).parent().addClass('has-error');
                } 
            });
            return false;
        }

        $('.border_error').removeClass('border_error');
        $('.has-error').removeClass('has-error');
        $(".hideSubmitButtons").hide();

        $.post('<?php echo site_url('mech_sms/ajax/sendsms'); ?>', {
            sms : $("input[name='sms']:checked").val(),
            client : $("#client").val(),
            clients : $("#clients").val(),
            text_message : $("#text_message").val(),
            _mm_csrf: $('#_mm_csrf').val()
        }, function (data) {
            list = JSON.parse(data);
            if(list.success=='1'){
                notie.alert(1, 'Message Sent Successfully', 2);
                setTimeout(function(){
                    window.location = "<?php echo site_url('mech_sms'); ?>";
                }, 100);
            }else{
                $(".hideSubmitButtons").show();
                notie.alert(3, 'Please fill the mandatory fields and continue', 2);
                $('.has-error').removeClass('has-error');
                for (var key in list.validation_errors) {
                    $('#' + key).parent().addClass('has-error');
                    $('.error_msg_' + key).show().empty().html(list.validation_errors[key]);
                }
            }
        });
    });
});
</script>