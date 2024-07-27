<script src="<?php echo base_url(); ?>assets/mp_backend/js/purchase_expense.js"></script>
<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php echo _trans($breadcrumb); ?></h3>
				</div>
			</div>
		</div>
	</div>
</header>
<div id="content">
    <div class="row">
        <div id="gif" class="gifload">
			<div class="gifcenter">
			  <center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
		    </div>
		</div>
        <div class="col-xs-12 top-15">
            <a class="anchor anchor-back" onclick="goBack()" href="<?php echo site_url('reminder/custom_reminder_index'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
        </div>
        <div class="col-xs-12 col-md-12 col-md-offset-3">
			<div class="container-wide usermanagement overflow_inherit">
                <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
				<section class="tabs-section" >
					<div class="tab-content">
                    <input type="hidden" name="custom_reminder_id" id="custom_reminder_id" class="form-control" value="<?php echo $custom_reminder_details->custom_reminder_id;?>">

                        <?php /* * / ?>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable572'); ?>*</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="hidden" name="custom_reminder_id" id="custom_reminder_id" class="form-control" value="<?php echo $custom_reminder_details->custom_reminder_id;?>">
                                <select name="type_id" id="type_id" class="bootstrap-select bootstrap-select-arrow" data-live-search="true">
                                    <option value=""><?php _trans('lable241'); ?></option>
                                    <option value="S" <?php if($custom_reminder_details->type_id == "S"){ echo "selected";}?>><?php _trans('lable335'); ?></option>
                                    <option value="P" <?php if($custom_reminder_details->type_id == "P"){ echo "selected";}?>><?php _trans('lable347'); ?></option>
                                    <option value="I" <?php if($custom_reminder_details->type_id == "I"){ echo "selected";}?>><?php _trans('lable562'); ?></option>
                                    <option value="F" <?php if($custom_reminder_details->type_id == "F"){ echo "selected";}?>><?php _trans('lable563'); ?></option>
                                </select> 
                            </div>
                        </div> 
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable573'); ?></label>
                            </div>
                            <div class="col-sm-9">
                                <select name="item_id" id="item_id" class="bootstrap-select bootstrap-select-arrow" data-live-search="true">
                                    <option value=""><?php _trans('lable55'); ?></option>
                                    <?php foreach ($item_list as $itemList) {
                                        if ($custom_reminder_details->type_id == "S") {
                                            $id = $itemList->sc_item_id;
                                            $name = $itemList->service_item_name;
                                        } elseif ($custom_reminder_details->type_id == "P") {
                                            $id = $itemList->product_id;
                                            $name = $itemList->product_name;
                                        }
                                        if ($custom_reminder_details->item_id == $id) {
                                            $selected = 'selected="selected"';
                                        } else {
                                            $selected = '';
                                        } ?>
                                    <option value="<?php echo $id; ?>" <?php echo $selected; ?>><?php echo $name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <?php / * */ ?>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable574'); ?>*</label>
                            </div>
                            <div class="col-sm-9">
                                <select name="customer_id" id="customer_id" class="bootstrap-select bootstrap-select-arrow removeError" data-live-search="true" autocomplete="off">
                                    <option value=""><?php _trans('lable272'); ?></option>
                                    <?php foreach ($customer_list as $customer) {
                                        if (!empty($custom_reminder_details)) {
                                            if ($custom_reminder_details->customer_id == $customer->client_id) {
                                                $selected = 'selected="selected"';
                                            } else {
                                                $selected = '';
                                            }
                                        } else {
                                            $selected = '';
                                        } ?>
                                        <option value="<?php echo $customer->client_id; ?>" <?php echo $selected; ?>><?php echo ($customer->client_name?$customer->client_name:"").' '.($customer->client_contact_no?"(".$customer->client_contact_no.")":""); ?></option>
                                    <?php
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable575'); ?>*</label>
                            </div>
                            <div class="col-sm-9">
                                <select name="customer_car_id" id="customer_car_id" class="bootstrap-select bootstrap-select-arrow removeError" data-live-search="true" autocomplete="off">
                                    <option value=""><?php _trans('lable281'); ?></option>
                                    <?php foreach ($user_cars as $cars) {
                                     $user_cars_list = $cars->brand_name.', '.$cars->model_name.''.($cars->variant_name?", ".$cars->variant_name:"").', '.$cars->car_reg_no;
                                        if (!empty($custom_reminder_details)) {
                                            if ($custom_reminder_details->customer_car_id == $cars->car_list_id) {
                                                $selected = 'selected="selected"';
                                            } else {
                                                $selected = '';
                                            }
                                        } else {
                                            $selected = '';
                                        } ?>
                                    <option value="<?php echo $cars->car_list_id; ?>" <?php echo $selected; ?>><?php echo $user_cars_list; ?></option>
                                    <?php } ?>
                                </select>
                                <div class="col-lg-12" style="padding-left: 0px;padding-top: 5px;">
                                    <a class="add_car fontSize_85rem float_left addcarpopuplink " style="display:none;" href="javascript:void(0)" data-toggle="modal" data-model-from="reminder" <?php if($custom_reminder_details->customer_id){echo 'data-customer-id="'.$custom_reminder_details->customer_id.'"';}?> data-target="#addNewCar" >+ Add New Vechicle</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable570'); ?>*</label>
                            </div>
                            <div class="col-sm-9">
                                <input class="form-control removeErrorInput datepicker" onchange="changeDueDatebyCreated('last_update','next_update_day','next_update')" type="text" name="last_update" id="last_update" value="<?php echo ($custom_reminder_details->last_update?date_from_mysql($custom_reminder_details->last_update):date_from_mysql(date('Y-m-d')));?>" >
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable566'); ?></label>
                            </div>
                            <div class="col-sm-2">
                                <input class="form-control" onchange="changeDueDatebyDay('last_update','next_update_day','next_update')" type="text" name="next_update_day" id="next_update_day" placeholder="Day" value="<?php echo $custom_reminder_details->next_update_day?$custom_reminder_details->next_update_day:'';?>" >
                            </div>
                            <div class="col-sm-7">
                                <input class="form-control removeErrorInput datepicker" onchange="changeCreditPeriodbyDueDate('last_update','next_update_day','next_update')" type="text" placeholder="Renewal Date" name="next_update" id="next_update" value="<?php echo ($custom_reminder_details->next_update?date_from_mysql($custom_reminder_details->next_update):"");?>" >
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable177'); ?></label>
                            </div>
                            <div class="col-sm-9">
                                <textarea id="description" name="description" class="form-control string required" ><?php echo $custom_reminder_details->description;?></textarea>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable292'); ?></label>
                            </div>
                            <div class="col-sm-9">
                                <select name="employee_id" id="employee_id" class="bootstrap-select bootstrap-select-arrow" data-live-search="true">
                                    <option value=""><?php _trans('lable457'); ?></option>
                                    <?php foreach ($employee_list as $employeeList) {
                                        if ($custom_reminder_details->employee_id == $employeeList->employee_id) {
                                            $selected = 'selected="selected"';
                                        } else {
                                            $selected = '';
                                    } ?>
                                    <option value="<?php echo $employeeList->employee_id; ?>" <?php echo $selected; ?>><?php echo $employeeList->employee_name; ?></option>
                                    <?php } ?>
                                </select> 
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label"><?php _trans('lable557'); ?></label>
                            </div>
                            <div class="col-sm-9 paddingTop7px">
                                <label class="switch">
    						        <input type="checkbox" class="checkbox" name="email_notification" id="email_notification" <?php if($custom_reminder_details->email_notification == 'Y'){ echo "checked"; }?> value="<?php if($custom_reminder_details->email_notification == 'Y'){ echo "Y"; } else{ echo 'N'; }?>" >
    						        <span class="slider round"></span>
    					        </label>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 buttons text-center paddingTop40px hideSubmitButtons">
                            <button value="1" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
                                <i class="fa fa-check"></i> <?php _trans('lable56'); ?>
                            </button>
                            <button value="2" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
                                <i class="fa fa-check"></i> <?php _trans('lable57'); ?>
                            </button>
                            <button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default">
                                <i class="fa fa-times"></i><?php _trans('lable58'); ?>
                            </button>
                        </div>	
                    </div>
    			</div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">


function formatDates(date){
    var dt = new Date(date);
    var dtd = dt.getDate();
    var dtm = dt.getMonth()+1;
    var dty = dt.getFullYear();
    return  ('0' + dtd).slice(-2) + "-" + ('0' + dtm).slice(-2) + "-" + dty ;
}

function changeDueDatebyCreated(created_date,days,due_date){

    var billDays = $("#"+days).val();
    if(billDays == '')
    {
        var billDate = $('#'+created_date).val();
        $('#'+due_date).val(billDate);
    }
    else
    {
        $("#"+days).removeClass('border_error');
        $("#"+days).removeClass('has-error'); 
        $("#"+days).parent().removeClass('has-error');   
        $("#"+days).parent().removeClass('border_error');
        
    	var billDates = $('#'+created_date).val().split("/").reverse().join("-");
        var billDate = new Date(billDates);
        var billDays = parseInt($("#"+days).val(), 10);
        var newDate = billDate.setDate(billDate.getDate() + billDays);
        var dueDate = formatDates(newDate);
        setTimeout(function(){ 
        	$('#' + due_date).val(dueDate.split("-").join("/"));
        }, 100);
    }
    if($("#"+due_date).val() != '')
    {
        $("#"+due_date).removeClass('border_error');
        $("#"+due_date).removeClass('has-error'); 
        $("#"+due_date).parent().removeClass('has-error');   
        $("#"+due_date).parent().removeClass('border_error');
    }

}

function changeDueDatebyDay(created_date,days,due_date){

	var billDays = $("#"+days).val();
    var billDate = $('#'+created_date).val().split("/").reverse().join("-");
    if(billDays < 0 || billDays == ""){
        $("#"+days).val(0);
        billDays = 0;
    }
    if (billDays.length > 4){
      billDays = billDays.slice(0, 4);
    }
    var billDate = new Date($('#'+created_date).val().split("/").reverse().join("-"));
    var billDays = parseInt($("#"+days).val(), 10);
    var newDate = billDate.setDate(billDate.getDate() + billDays); 
    var dueDate = formatDates(newDate);
    setTimeout(function(){ 
        $('#' + due_date).val(dueDate.split("-").join("/"));
	}, 100);
    $("#"+days).val(parseInt(billDays));

    if($("#"+created_date).val() != ''){
        $("#"+created_date).removeClass('border_error');
        $("#"+created_date).removeClass('has-error'); 
        $("#"+created_date).parent().removeClass('has-error');   
        $("#"+created_date).parent().removeClass('border_error');
    }
    if($("#"+due_date).val() != '')
    {
        $("#"+due_date).removeClass('border_error');
        $("#"+due_date).removeClass('has-error'); 
        $("#"+due_date).parent().removeClass('has-error');   
        $("#"+due_date).parent().removeClass('border_error');
    }
    
    
}

function changeCreditPeriodbyDueDate(created_date,days,due_date) {

    var billlDays = $("#"+days).val();
    if(billlDays == '')
    {
        var billlDate = $('#'+due_date).val();
        $('#'+created_date).val(billlDate);
    }
	var billDates = $('#'+created_date).val().split("/").reverse().join("-");
    var billDate = new Date(billDates).getDate();
    var dueDates = $('#'+due_date).val().split("/").reverse().join("-");
    var dueDate = new Date(dueDates).getDate();
	var creditedDays = dueDate - billDate;
    if (creditedDays = 'NaN'){
        $('#'+days).val(0);
    }else{
        $('#'+days).val(creditedDays);
    }

    if($("#"+created_date).val() != ''){
        $("#"+created_date).removeClass('border_error');
        $("#"+created_date).removeClass('has-error'); 
        $("#"+created_date).parent().removeClass('has-error');   
        $("#"+created_date).parent().removeClass('border_error');
    }
    if($("#"+days).val() != '')
    {
        $("#"+days).removeClass('border_error');
        $("#"+days).removeClass('has-error'); 
        $("#"+days).parent().removeClass('has-error');   
        $("#"+days).parent().removeClass('border_error');
    }
    
}

$(document).ready(function() {

    $('#contact_reminder_next_due_date').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
    });

    $('#type_id').change(function() {
        var type_id = $('#type_id').val();
        if(type_id == 'S' || type_id == 'P'){
            if (type_id == 'S') {
                var site_url = "<?php echo site_url('mechanic_service_category_items/ajax/get_service_list'); ?>";
            } else if (type_id == 'P') {
                var site_url = "<?php echo site_url('products/ajax/get_product_list'); ?>";
            } 

            $.post(site_url, {
                _mm_csrf: $('#_mm_csrf').val()
            },
            function(data) {
                var response = JSON.parse(data);
                // console.log(response);
                var rid = '';
                var name = '';
                $('#item_id').empty(); // clear the current elements in select box
                if (type_id == 'S') {
                    $('#item_id').append($('<option></option>').attr('value', '').text('Select Service'));
                }else if (type_id == 'P') {
                    $('#item_id').append($('<option></option>').attr('value', '').text('Select Product'));
                }
                if (response.length > 0) {
                    for (row in response) {
                        if (type_id == 'S') {
                            rid = response[row].sc_item_id;
                            name = response[row].service_item_name;
                        } else if (type_id == 'P') {
                            rid = response[row].product_id;
                            name = response[row].product_name;
                        }
                        $('#item_id').append($('<option></option>').attr('value', rid).text(name));
                    }
                    $('#item_id').selectpicker("refresh");
                } else {
                    $('#item_id').selectpicker("refresh");
                }
            });
        }
        
    });

    $('#customer_id').change(function() {

        if ($('#customer_id').val() != '') {
            $('.addcarpopuplink').show();
        } else {
            $('.addcarpopuplink').hide();
        }
        $('#gif').show();
        $.post("<?php echo site_url('user_cars/ajax/get_customer_cars'); ?>", {
            customer_id: $('#customer_id').val(),
            _mm_csrf: $('#_mm_csrf').val()
        },
        function(data) {
            var response = JSON.parse(data);
            $('.add_car').attr('data-customer-id', $('#customer_id').val());
            $('.add_address').attr('data-customer-id', $('#customer_id').val());
            //console.log(response);
            if (response.length > 0) {
                $('#gif').hide();
                $('#customer_car_id').empty(); // clear the current elements in select box
                $('#customer_car_id').append($('<option></option>').attr('value', '').text('Select Customer Vehicle'));
                for (row in response) {
                    var variant_name = (response[row].variant_name) ? response[row].variant_name : '';
                    $('#customer_car_id').append($('<option></option>').attr('value', response[row].car_list_id).text((response[row].brand_name?response[row].brand_name:"")+''+(response[row].model_name?", "+response[row].model_name: '')+''+(response[row].variant_name?", "+response[row].variant_name:'')+''+(response[row].car_reg_no?", "+response[row].car_reg_no: '')));
                                                                                                                
                }
                $('#customer_car_id').selectpicker("refresh");
            } else {
                $('#gif').hide();
                $('#customer_car_id').empty(); // clear the current elements in select box
                $('#customer_car_id').append($('<option></option>').attr('value', '').text('Select Customer Vehicle'));
                $('#customer_car_id').selectpicker("refresh");
            }
        });
    });

    $("#btn_cancel").click(function () {
        window.location.href = "<?php echo site_url('reminder/custom_reminder_index'); ?>";
    });

    $("#email_notification").click(function(){
        if($("#email_notification:checked").is(":checked")){
            $("#email_notification").val('Y');
        }else{
            $("#email_notification").val('N');
        }
    });

    $(".btn_submit").click(function () {


        // var type_id = $('#type_id').val();
        var customer_id = $('#customer_id').val();
        var customer_car_id = $('#customer_car_id').val();
        var next_update_day = $('#next_update_day').val();
        var last_update = $('#last_update').val();
        var next_update = $('#next_update').val();
        
        var validation = [];

        // if($("#type_id").val() == ''){
		// 	validation.push('type_id');
		// }
        if($("#customer_id").val() == ''){
			validation.push('customer_id');
		}
        if($("#customer_car_id").val() == ''){
			validation.push('customer_car_id');
		}
        if($("#next_update_day").val() == ''){
			validation.push('next_update_day');
		}
         if($("#last_update").val() == ''){
			validation.push('last_update');
		}
        if($("#next_update").val() == ''){
			validation.push('next_update');
		}

        if(validation.length > 0){
			validation.forEach(function(val){
				$('#'+val).addClass("border_error");
                $('#'+val).parent().addClass('has-error');
			});
			return false;
		}
		$('.border_error').removeClass('border_error');
        $('.has-error').removeClass('has-error');
        $('#gif').show();

        $.post('<?php echo site_url('reminder/ajax/save_custom_reminder'); ?>', {
            custom_reminder_id : $("#custom_reminder_id").val(),
            //type_id : $('#type_id').val(),
           // item_id : $('#item_id').val(),
            customer_car_id : $('#customer_car_id').val(),
            customer_id : $('#customer_id').val(),
            last_update : $("#last_update").val(),
            next_update_day : $("#next_update_day").val(),
            next_update : $("#next_update").val(),
            description : $('#description').val(),
            employee_id: $("#employee_id").val(),
            email_notification : $('#email_notification').val(),
            btn_submit : $(this).val(),
            _mm_csrf: $('#_mm_csrf').val()
        }, function (data) {
            list = JSON.parse(data);
            if(list.success=='1'){
                notie.alert(1, '<?php _trans('toaster1'); ?>', 2);
                if(list.btn_submit == '1'){
                    setTimeout(function(){
                        window.location = "<?php echo site_url('reminder/custom_reminder'); ?>";
                    }, 100);
                }else{
                    setTimeout(function(){
                        window.location = "<?php echo site_url('reminder/custom_reminder_index'); ?>";
                    }, 100);
                }
            }else{
                $('#gif').hide();
                notie.alert(3, '<?php _trans('toaster2'); ?>', 2);
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