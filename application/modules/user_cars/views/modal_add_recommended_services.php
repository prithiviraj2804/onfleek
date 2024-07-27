<script type="text/javascript">
    var model_from = "<?php echo $model_from;?>";
    var customer_id = "<?php echo $customer_id;?>";
    var vehicle_id = "<?php echo $vehicle_id;?>";
    var recommended_invoice_id = "<?php echo $invoice_id;?>";

    $(function () {

        $(".removeError").change(function() {
            var len = (this.value);
            if (this.value != "" || this.value != 0) {
                $('#' + $(this).attr('name')).parent().removeClass('has-error');
                $('#' + $(this).attr('name')).parent().removeClass('border_error');
                $('#' + $(this).attr('name')).removeClass('has-error');
                $('#' + $(this).attr('name')).removeClass('border_error');
            }
        });
        
        $('#addNewCar').modal('show');
        $(".bootstrap-select").selectpicker("refresh");

		$('.modal-popup-close').click(function () {
            $('#addNewCar').modal('hide');
            $('#add_car_fdetail').hide();
            $('#add_car_sdetail').hide();
            $('.modal').remove();
            $('.modal-backdrop').remove();
            $('body').removeClass( "modal-open" );
         }); 
    });

    function showEditContent(id,invoice_id){
        
        $.post("<?php echo site_url('user_cars/ajax/getRecommendedService'); ?>", {
            recommended_id: id,
            invoice_id:invoice_id,
            _mm_csrf: $('#_mm_csrf').val()
        },
        function (data) {
            var response = JSON.parse(data);
            if(response.success == '1'){
                if(response.recomended_services.length > 0){
                    var html = '';
                    html += '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding0px">';
                    html += '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding0px borderBotGrey">';
                    html += '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">';
                    html += '<h5 class="section-header-text"><?php _trans("lable867");?></h5>';
                    html += '</div>';
                    html += '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">';
                    html += '<h5 class="section-header-text text-center"><?php _trans("lable860");?></h5>';
                    html += '</div>';
                    html += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">';
                    html += '<h5 class="section-header-text text-center"><?php _trans("lable861");?></h5>';
                    html += '</div>';
                    html += '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 text-center"></div>';
                    html += '</div>';
                    for(var i=0; i<response.recomended_services.length; i++){
                        html += '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 paddingTopBot10px borderBotGrey" id="showEditBox_'+response.recomended_services[i].recommended_id+'">';
                        html += '<input type="hidden" id="recommended_id_'+response.recomended_services[i].recommended_id+'" name="recommended_id_'+response.recomended_services[i].recommended_id+'" value="'+response.recomended_services[i].recommended_id+'">';
                        html += '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">'+response.recomended_services[i].service_item_name+'</div>';
                        html += '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center">'+response.recomended_services[i].days+'</div>';
                        html += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center">';
                            if(response.recomended_services[i].service_status == 'M'){ 
                                html += '<?php _trans("lable862");?>';
                            }else if(response.recomended_services[i].service_status == 'N'){
                                html += '<?php _trans("lable863");?>';
                            }
                        html += '</div>';
                        html += '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 text-center">';
                        html += '<a href="javascript:void(0)" onclick="showEditContent(\''+response.recomended_services[i].recommended_id+'\',\''+response.recomended_services[i].invoice_id+'\');" >';
                        html += '<i class="fa fa-edit fa-margin"></i>';
                        html += '</a>';
                        html += '</div>';
                        html += '</div>';
                    }
                    html += '</div>';

                    $("#appendRecommendedServices").empty().append(html);
                    $("#editShowBox").empty().append('<?php _trans("lable868");?>');
                    $("#addCommendBox").show();
                    $("#recommended_service").val('');
                    $("#days").val('');
                    $("#service_status").val('');
                    $(".bootstrap-select").selectpicker("refresh");
                }else{
                    $(".originalRecommendedServiceBox").show();
                    $("#addCommendBox").hide();
                    $("#editShowBox").empty().append('<?php _trans("lable869");?>');
                    $("#appendRecommendedServices").empty().append('');
                }
                
                if(response.recommendedService){
                    $(".originalRecommendedServiceBox").hide();
                    var html = '';
                    html += '<input type="hidden" id="recommended_id_'+response.recommendedService.recommended_id+'" name="recommended_id_'+response.recommendedService.recommended_id+'" value="'+response.recommendedService.recommended_id+'">';
                    html += '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">';
                    html += '<label class="form_label section-header-text"><?php _trans("lable867");?>*</label>';
                    html += '<select name="recommended_service_'+response.recommendedService.recommended_id+'" id="recommended_service_'+response.recommendedService.recommended_id+'" class="services_add_service bootstrap-select bootstrap-select-arrow g-input form-control" data-live-search="true">';
                    html += '<option value=""><?php _trans("lable258"); ?></option>';
                    if(response.service_category_items.length > 0){
                        for(var i=0; i<response.service_category_items.length; i++){
                            var selected = '';
                            if(response.service_category_items[i].msim_id == response.recommendedService.recommended_service){
                                selected = "selected";
                            }
                            html += '<option '+selected+' value="'+response.service_category_items[i].msim_id+'">'+response.service_category_items[i].service_item_name+'</option>';
                        }
                    }
                    html += '</select>';
                    html += '</div>';
                    html += '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">';
                    html += '<label class="form_label section-header-text"><?php _trans("lable860"); ?>*</label>';
                    html += '<input type="text" class="form-control" name="days_'+response.recommendedService.recommended_id+'" id="days_'+response.recommendedService.recommended_id+'" value="'+response.recommendedService.days+'">';
                    html += '</div>';
                    html += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">';
                    html += '<label class="form_label section-header-text"><?php _trans("lable861"); ?>*</label>';
                    html += '<select class="form-control bootstrap-select bootstrap-select-arrow" data-live-search="true" name="service_status_'+response.recommendedService.recommended_id+'" id="service_status_'+response.recommendedService.recommended_id+'">';
                    html += '<option value=""><?php _trans("lable285"); ?></option>';
                    if(response.recommendedService.service_status == "M"){
                        html += '<option value="M" selected >Major</option>';
                    }else{
                        html += '<option value="M">Major</option>';
                    }
                    if(response.recommendedService.service_status == "N"){
                        html += '<option value="N" selected >Minor</option>';
                    }else{
                        html += '<option value="N" >Minor</option>';
                    }
                    html += '</select>';
                    html += '</div>';
                    html += '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 padding0px text-center">';
                    html += '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center padding0px"><a href="javascript:void(0)" onclick="editSaveRecommendation(\''+response.recommendedService.recommended_id+'\',\''+response.recommendedService.invoice_id+'\')" class="recommeded_edit">';
                    html += '<i class="fa fa-check" aria-hidden="true"></i></a></div>';
                    html += '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center padding0px"><a href="javascript:void(0)" onclick="deleteRecommendation(\''+response.recommendedService.recommended_id+'\',\''+response.recommendedService.invoice_id+'\')" class="recommeded_edit">';
                    html += '<i class="fa fa-trash"></i></a></div>';
                    html += '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center padding0px"><a href="javascript:void(0)" onclick="cancelRecommended('+response.recommendedService.invoice_id+')" class="recommeded_edit">';
                    html += '<i class="fa fa-times" aria-hidden="true"></i>';
                    html += '</a></div></div>';

                    $("#showEditBox_"+id).empty().append(html);
                }		

                $('.bootstrap-select').selectpicker("refresh");

            } else {
                notie.alert(2, 'Not Saved!', 2);
            }
        });
    }

    function editSaveRecommendation(id,invoice_id){

        $('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');
		var validation = [];

        if(id == 'null'){
            var recommended_id = '';
            var recommended_service = $('#recommended_service').val();
            var days = $('#days').val();
            var service_status = $('#service_status').val();
            var recommended_invoice_ids = recommended_invoice_id;

            if($("#recommended_service").val() == ''){
                validation.push('recommended_service');
            }
            if($("#days").val() == ''){
                validation.push('days');
            }
            if($("#service_status").val() == ''){
                validation.push('service_status');
            }

        }else{

            var recommended_id = $("#recommended_id_"+id).val();
            var recommended_service = $('#recommended_service_'+id).val();
            var days = $('#days_'+id).val();
            var service_status = $('#service_status_'+id).val();
            var recommended_invoice_ids = invoice_id;

            if($('#recommended_service_'+id).val() == ''){
                validation.push('recommended_service_'+id);
            }
            if($('#days_'+id).val() == ''){
                validation.push('days_'+id);
            }
            if($('#service_status_'+id).val() == ''){
                validation.push('service_status_'+id);
            }

        }
		
        if(validation.length > 0){
                validation.forEach(function(val) {
                    $('#'+val).addClass("border_error");
                    $('#'+val).parent().addClass('has-error');
                });
                return false;
            }
		
		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');
        $('#gif').show();

        $.post("<?php echo site_url('user_cars/ajax/save_recommended_service'); ?>", {
            car_list_id: vehicle_id,
            customer_id: customer_id,
            invoice_id: recommended_invoice_ids,
            recommended_id: recommended_id,
            recommended_service: recommended_service,
            category_type : 'S',
            days: days,
            service_status: service_status,
            _mm_csrf: $('#_mm_csrf').val()
        },
        function (data) {
            var response = JSON.parse(data);
            if(response.success == 1){
                $('#gif').hide();
                notie.alert(1, 'Success!', 2);
                $(".originalRecommendedServiceBox").show();

                if(response.recomended_services.length > 0){
                    var html = '';
                    html += '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding0px">';
                    html += '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding0px borderBotGrey">';
                    html += '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">';
                    html += '<h5 class="section-header-text"><?php _trans("lable867");?></h5>';
                    html += '</div>';
                    html += '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">';
                    html += '<h5 class="section-header-text text-center"><?php _trans("lable860");?></h5>';
                    html += '</div>';
                    html += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">';
                    html += '<h5 class="section-header-text text-center"><?php _trans("lable861");?></h5>';
                    html += '</div>';
                    html += '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 text-center"></div>';
                    html += '</div>';
                    for(var i=0; i<response.recomended_services.length; i++){
                        html += '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 paddingTopBot10px borderBotGrey" id="showEditBox_'+response.recomended_services[i].recommended_id+'">';
                        html += '<input type="hidden" id="recommended_id_'+response.recomended_services[i].recommended_id+'" name="recommended_id_'+response.recomended_services[i].recommended_id+'" value="'+response.recomended_services[i].recommended_id+'">';
                        html += '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">'+response.recomended_services[i].service_item_name+'</div>';
                        html += '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center">'+response.recomended_services[i].days+'</div>';
                        html += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center">';
                            if(response.recomended_services[i].service_status == 'M'){ 
                                html += 'Major';
                            }else if(response.recomended_services[i].service_status == 'N'){
                                html += 'Minor';
                            }
                        html += '</div>';
                        html += '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 text-center">';
                        html += '<a style="float: right;margin-right: 10px;" href="javascript:void(0)" onclick="showEditContent(\''+response.recomended_services[i].recommended_id+'\',\''+response.recomended_services[i].invoice_id+'\');" >';
                        html += '<i class="fa fa-edit fa-margin"></i>';
                        html += '</a>';
                        html += '</div>';
                        html += '</div>';
                    }
                    html += '</div>';
                    $("#appendRecommendedServices").empty().append(html);
                    $("#editShowBox").empty().append('<?php _trans("lable868");?>');
                    $("#addCommendBox").show();
                    $("#recommended_service").val('');
                    $("#days").val('');
                    $("#service_status").val('');
                    $(".bootstrap-select").selectpicker("refresh");
                }else{
                    $(".originalRecommendedServiceBox").show();
                    $("#addCommendBox").hide();
                    $("#editShowBox").empty().append('<?php _trans("lable869");?>');
                    $("#appendRecommendedServices").empty().append('');
                }
            } else {
                notie.alert(2, 'Not Saved!', 2);
            }
        });
    }

    function cancelRecommended(invoice_id){
        $.post("<?php echo site_url('user_cars/ajax/get_recommended_service_list'); ?>", {
            invoice_id: invoice_id,
            _mm_csrf: $('#_mm_csrf').val()
        },
        function (data) {
            var response = JSON.parse(data);
            if(response.success == 1){
                $(".originalRecommendedServiceBox").show();
                if(response.recomended_services.length > 0){
                    var html = '';
                    html += '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding0px">';
                    html += '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding0px borderBotGrey">';
                    html += '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">';
                    html += '<h5 class="section-header-text"><?php _trans("lable867");?></h5>';
                    html += '</div>';
                    html += '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">';
                    html += '<h5 class="section-header-text text-center"><?php _trans("lable860");?></h5>';
                    html += '</div>';
                    html += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">';
                    html += '<h5 class="section-header-text text-center"><?php _trans("lable861");?></h5>';
                    html += '</div>';
                    html += '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 text-center"></div>';
                    html += '</div>';
                    for(var i=0; i<response.recomended_services.length; i++){
                        html += '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 paddingTopBot10px borderBotGrey" id="showEditBox_'+response.recomended_services[i].recommended_id+'">';
                        html += '<input type="hidden" id="recommended_id_'+response.recomended_services[i].recommended_id+'" name="recommended_id_'+response.recomended_services[i].recommended_id+'" value="'+response.recomended_services[i].recommended_id+'">';
                        html += '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">'+response.recomended_services[i].service_item_name+'</div>';
                        html += '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center">'+response.recomended_services[i].days+'</div>';
                        html += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center">';
                            if(response.recomended_services[i].service_status == 'M'){ 
                                html += 'Major';
                            }else if(response.recomended_services[i].service_status == 'N'){
                                html += 'Minor';
                            }
                        html += '</div>';
                        html += '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 text-center">';
                        html += '<a style="float: right;margin-right: 10px;" href="javascript:void(0)" onclick="showEditContent(\''+response.recomended_services[i].recommended_id+'\',\''+response.recomended_services[i].invoice_id+'\');" >';
                        html += '<i class="fa fa-edit fa-margin"></i>';
                        html += '</a>';
                        html += '</div>';
                        html += '</div>';
                    }
                    html += '</div>';

                    $("#appendRecommendedServices").empty().append(html);
                    $("#recommended_service").val('');
                    $("#editShowBox").empty().append('<?php _trans("lable868");?>');
                    $("#addCommendBox").show();
                    $("#days").val('');
                    $("#service_status").val('');
                    $(".bootstrap-select").selectpicker("refresh");
                }else{
                    $(".originalRecommendedServiceBox").show();
                    $("#addCommendBox").hide();
                    $("#editShowBox").empty().append('<?php _trans("lable869");?>');
                    $("#appendRecommendedServices").empty().append('');
                }
            } else {
                notie.alert(2, 'Not Saved!', 2);
            }
        });
    }

    function deleteRecommendation(recommended_id,invoice_id){

        $.post("<?php echo site_url('user_cars/ajax/delete_recommended_service'); ?>", {
            recommended_id: recommended_id,
            invoice_id: invoice_id,
            _mm_csrf: $('#_mm_csrf').val()
        },
        function (data) {
            var response = JSON.parse(data);
            if(response.success == 1){
                notie.alert(1, 'Success!', 2);
                $(".originalRecommendedServiceBox").show();
                if(response.recomended_services.length > 0){
                    var html = '';
                    html += '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding0px">';
                    html += '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding0px borderBotGrey">';
                    html += '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">';
                    html += '<h5 class="section-header-text"><?php _trans("lable867");?></h5>';
                    html += '</div>';
                    html += '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">';
                    html += '<h5 class="section-header-text text-center"><?php _trans("lable860");?></h5>';
                    html += '</div>';
                    html += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">';
                    html += '<h5 class="section-header-text text-center"><?php _trans("lable861");?></h5>';
                    html += '</div>';
                    html += '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 text-center"></div>';
                    html += '</div>';
                    for(var i=0; i<response.recomended_services.length; i++){
                        html += '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 paddingTopBot10px borderBotGrey" id="showEditBox_'+response.recomended_services[i].recommended_id+'">';
                        html += '<input type="hidden" id="recommended_id_'+response.recomended_services[i].recommended_id+'" name="recommended_id_'+response.recomended_services[i].recommended_id+'" value="'+response.recomended_services[i].recommended_id+'">';
                        html += '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">'+response.recomended_services[i].service_item_name+'</div>';
                        html += '<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center">'+response.recomended_services[i].days+'</div>';
                        html += '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center">';
                            if(response.recomended_services[i].service_status == 'M'){ 
                                html += 'Major';
                            }else if(response.recomended_services[i].service_status == 'N'){
                                html += 'Minor';
                            }
                        html += '</div>';
                        html += '<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 text-center">';
                        html += '<a style="float: right;margin-right: 10px;" href="javascript:void(0)" onclick="showEditContent(\''+response.recomended_services[i].recommended_id+'\',\''+response.recomended_services[i].invoice_id+'\');" >';
                        html += '<i class="fa fa-edit fa-margin"></i>';
                        html += '</a>';
                        html += '</div>';
                        html += '</div>';
                    }
                    html += '</div>';

                    $("#appendRecommendedServices").empty().append(html);
                    $("#recommended_service").val('');
                    $("#addCommendBox").show();
                    $("#editShowBox").empty().append('<?php _trans("lable868");?>');
                    $("#days").val('');
                    $("#service_status").val('');
                    $(".bootstrap-select").selectpicker("refresh");
                }else{
                    $(".originalRecommendedServiceBox").show();
                    $("#addCommendBox").hide();
                    $("#editShowBox").empty().append('<?php _trans("lable869");?>');
                    $("#appendRecommendedServices").empty().append('');
                }	
            } 
        });

    }
</script>
<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
<div class="modal fade" id="addNewCar" tabindex="-1" role="dialog" aria-labelledby="addNewCarLabel">
	<div class="modal-dialog vechicleBox" role="document">
		<div class="modal-content" id="add_car_fdetail">
            <div class="modal-header">
                <div class="col-xs-12 text-center">
                <h3 class="modal__h3" id="editShowBox">
                    <?php if(count($recommended_services) > 0){
                        _trans("lable868");
                    }else{ 
                        _trans("lable869");
                    } ?>
                    </h3>
                </div>
                <button type="button" class="modal-close modal-popup-close">
                    <i class="font-icon-close-2"></i>
                </button>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 modal-body">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding0px" id="appendRecommendedServices">
                    <?php if(count($recommended_services) > 0){ ?>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding0px">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding0px borderBotGrey">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <h5 class="section-header-text"><?php _trans("lable867");?></h5>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <h5 class="section-header-text text-center"><?php _trans("lable860");?></h5>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                <h5 class="section-header-text text-center"><?php _trans("lable861");?></h5>
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 text-center"></div>
                        </div>
                        <?php foreach($recommended_services as $services){ ?>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 paddingTopBot10px borderBotGrey" id="showEditBox_<?php echo $services->recommended_id;?>">
                            <input type="hidden" id="recommended_id_<?php echo $services->recommended_id;?>" name="recommended_id_<?php echo $services->recommended_id;?>" value="<?php echo $services->recommended_id;?>"> 
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <?php echo $services->service_item_name;?>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center">
                                <?php echo $services->days;?>
                            </div>
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center">
                                <?php if($services->service_status == 'M'){ echo "Major";}?>
                                <?php if($services->service_status == 'N'){ echo "Minor";}?>
                            </div>
                            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 text-center">
                                <a href="javascript:void(0)" onclick="showEditContent(<?php echo $services->recommended_id;?>,<?php echo $services->invoice_id;?>);" >
                                    <i class="fa fa-edit fa-margin"></i>
                                </a>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 padding0px originalRecommendedServiceBox" id="originalRecommendedServiceBox">
                    <?php if(count($recommended_services) > 0){ ?>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 paddingTop20px" id="addCommendBox">
                        <h4 class="modal__h3"><?php _trans("lable869");?></h4>
                    </div>
                    <?php } ?>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"> 
                        <label class="form_label section-header-text"><?php _trans("lable867");?>*</label>
                        <select name="recommended_service" id="recommended_service" class="services_add_service bootstrap-select removeError bootstrap-select-arrow g-input form-control" data-live-search="true">
                            <option value="">Select Your Service</option>
                            <?php foreach($service_category_items as $item){ ?> 
                            <option value="<?php echo $item->msim_id; ?>"><?php echo $item->service_item_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <label class="form_label section-header-text"><?php _trans("lable860");?>*</label>
                        <input type="text" class="form-control" name="days" id="days">
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <label class="form_label section-header-text"><?php _trans("lable861");?>*</label>
                        <select class="form-control bootstrap-select removeError bootstrap-select-arrow" data-live-search="true" name="service_status" id="service_status">
                            <option value=""><?php _trans("lable285"); ?></option>
                            <option value="M">Major</option>
                            <option value="N">Minor</option>
                        </select>
                    </div> 
                </div>   
            </div>   
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 modal-footer text-center">
                <button type="button" class="btn btn-rounded btn-primary originalRecommendedServiceBox" id="add_vehicle_details" onclick="editSaveRecommendation('null','null')">ADD</button>
                <button type="button" class="btn btn-rounded btn-default modal-popup-close">Cancel</button>
            </div>
		</div>
	</div>
</div>