<script type="text/javascript">
    $(function(){

        var contentheight = window.screen.height-500;
		$("#listOfservices").css("height",contentheight);

        $('#addNewCar').modal('show');
        $(".bootstrap-select").selectpicker("refresh");
        $('#service_category_id').change(function (){
            $.post("<?php echo site_url('mechanic_service_item_price_list/ajax/getServiceList'); ?>", {
				service_category_id: $('#service_category_id').val(),
                user_car_list_id: $("#user_car_list_id").val()?$("#user_car_list_id").val():"",
				_mm_csrf: $('#_mm_csrf').val()
			},
			function (data) {
				var response = JSON.parse(data);
                var html = '';
				if (response.length > 0) {                
                    for(var i=0; i < response.length; i++){
                        html += '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 padding0px">';
                        if(response[i].serviceList.length > 0){
                            for(var j=0; j < response[i].serviceList.length; j++){
                                html += '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 padding0px paddingTop10px">';
                                html += '<div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 paddingTop5px">';
                                html += '<input type="checkbox" name="checkbox" value=""></div>';
                                html += '<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5">'+response[i].service_item_name+'</div>';
                                html += '<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">'+response[i].serviceList[j].vehicle_type_name+'</div>';
                                html += '<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">';
                                html += '<input type="text" class="form-control text-right" name="estimated_cost" value="'+response[i].serviceList[j].estimated_cost+'">';
                                html += '</div>';
                                html += '</div>';
                            }
                        }
                       
                        html += '</div>';
                    }
                   
				}else {
                    html += '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center paddingTop20px">';
                    html += 'No Services Found </div>';
				}

                $("#listOfservices").empty().append(html);
			});
        });
        
        $('#add_car_details').click(function (){
			
			$('.border_error').removeClass('border_error');
			$('.has-error').removeClass('has-error');
			$('#gif').show();

            $.post("<?php echo site_url('user_cars/ajax/create'); ?>", {
				car_reg_no: $('#car_reg_no').val().toUpperCase(),
				_mm_csrf: $('#_mm_csrf').val()
			},
			function (data) {
				var response = JSON.parse(data);
				if(response.success === 1){
						
				} else {
					
				}
			});
        });

		$('.modal-popup-close').click(function () {
            $('#addNewCar').modal('hide');
            $('.modal').remove();
            $('.modal-backdrop').remove();
            $('body').removeClass( "modal-open" );
        }); 

    });
</script>

<div class="modal fade" id="addNewCar" tabindex="-1" role="dialog" aria-labelledby="addNewCarLabel">
    <div id="gif" class="gifload">
        <div class="gifcenter">
            <center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
        </div>
    </div>
	<div class="modal-dialog vechicleBox" role="document">
		<div class="modal-content" id="add_car_fdetail">
            <input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            <div class="modal-header">
               <h3 class="margin-bottom-0px text-center"><?php echo _trans('lable881');?></h3>
            </div>
            <div class="modal-body withfull">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form_group">
                            <label class="form_label"><?php  _trans('lable239'); ?> *</label>
                            <div class="form_controls">
                                <select name="service_category_id" id="service_category_id" class="bootstrap-select bootstrap-select-arrow form-control removeError check_error_label" data-live-search="true" autocomplete="off">
                                    <option value=""><?php  _trans('lable252'); ?></option>
                                    <?php if($service_category_lists){
                                        foreach ($service_category_lists as $key => $service_category){ ?>
                                            <option value="<?php echo $service_category->service_cat_id; ?>" ><?php echo $service_category->category_name;?></option>
                                    <?php } } ?>
                                </select>
                            </div>	
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 paddingTopBot20px popupscroll" id="listOfservices">
                    <?php /* * / foreach($serviceListDetails as $list){ ?>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 padding0px">
                        <h5 class="car_reg_no paddingTop10px margin-bottom-0px"><?php echo $list->service_item_name;?></h5>
                        <?php foreach($list->serviceList as $innerList){ ?>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 padding0px paddingTop10px">
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 paddingTop5px">
                                <input type="checkbox" name="checkbox" value="">
                            </div>
                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5">
                                <?php echo $innerList->vehicle_type_name; ?>
                            </div>
                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5">
                                <input type="text" class="form-control text-right" name="estimated_cost" value="<?php echo $innerList->estimated_cost; ?>">
                            </div>
                        </div>
                    <?php } ?>
                    </div>
                    <?php } / * */ ?>
                </div>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-rounded btn-primary"  name="add_car_details" id="add_car_details"><?php _trans('lable70');?></button>
                <button type="button" class="btn btn-rounded btn-default modal-popup-close"><?php _trans('lable58');?></button>
            </div>
		</div>
	</div>
</div>