<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/autocomplete_veh_plugin.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="<?php echo base_url(); ?>assets/mp_backend/js/autocomplete_veh_plugin.js"></script>
<script src="<?php echo base_url(); ?>assets/mp_backend/js/autocomplete_veh_plugin_ui.js"></script>
<script>

function vehiclenumber(){
        var vehicle_no = $("#vehicle_no").val();
        if(vehicle_no.length > 2){
            $('#gif').show();
            $.post('<?php echo site_url('reports/reports/getvehiclenos'); ?>', {
                vehicle_no: vehicle_no,
                _mm_csrf: $('#_mm_csrf').val()
            }, function(data) {
                list = JSON.parse(data);
                if (list.success == '1') {
                    $('#gif').hide();
                    if(list.vehicle_list){
                        if(list.vehicle_list.length > 0){
                            var vehiclenoList = list.vehicle_list;
                            $("#vehicle_no").autocomplete({
                            source: vehiclenoList
                            });
                        }
                    }
                }
            });
        }
}

</script>
<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php _trans('lable1224'); ?></h3>
                </div>
                <div class="tbl-cell pull-right">
                    <a class="btn btn-rounded btn-primary btn-padding-left-right-40" target="_blank" href="<?php echo site_url('reports/generate_history_pdf/ServiceHistoryReport/'.$vehicle_no); ?>">
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
        <div class='col-lg-4 col-md-6 col-sm-6 col-xs-12' style="padding: 0px;">
            <div class="form-group">
                <label><?php _trans('lable1087'); ?></label>
                <div class='input-group'>
                    <input type="text" name="vehicle_no" id="vehicle_no" onkeypress="vehiclenumber()" value="<?php echo $vehicle_no; ?>" class="form-control" autocomplete="off">  
                </div>
            </div>
        </div>
        <div class='col-lg-4 col-md-6 col-sm-6 col-xs-12' style="padding: 22px 0px 0px 17px;">
            <div class="form-group">
                <div class='input-group'>
                    <input type="submit" class="btn btn-success" name="btn_submit" value="<?php _trans('lable628'); ?>">
                </div>
            </div>
        </div>
    </form>
</div>
<?php $this->layout->load_view('layout/alerts'); ?>
<?php if(count($mech_invoices) > 0 ) {  ?>
<div class="table-content">
    <section class="card">
        <div class="card-block">
            <div class="topdiv onlyhr col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php $v = count($mech_invoices); foreach($mech_invoices as $key => $invoice_customer_lists){ ?> 
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:1px;">
                    <div class="divcolor col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group clearfix">
                        <h5 class="hyheadline"><?php _trans('lable709'); ?> : <?php echo $vehicle_no; ?></h5>
                    </div>
                    <div class="divcolor col-lg-6 col-md-6 col-sm-6 col-xs-12 form-group clearfix" style="float:right;">
                        <h5 class="hyheadline"><?php _trans('lable1229'); ?> : <?php echo $v;$v--; ?></h5>
                    </div>
                </div>    
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:1px;">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <?php if($invoice_customer_lists->invoice_no){ ?>
                            <div class="clearfix">
                                <div><span class="hyheadline"><?php _trans('lable29');?> :</span>
                                <?php echo $invoice_customer_lists->invoice_no; ?>
                                </div>
                            </div>
                        <?php } if($invoice_customer_lists->invoice_date){ ?>                    
                            <div class="clearfix">
                                <div><span class="hyheadline"><?php _trans('lable368');?> :</span>
                                <?php echo ($invoice_customer_lists->invoice_date?date_from_mysql($invoice_customer_lists->invoice_date):""); ?>                               
                                </div>
                            </div>
                        <?php }if($invoice_customer_lists->jobsheet_no){ ?>    
                            <div class="clearfix">
                                <div><span class="hyheadline"><?php _trans('lable1052');?> :</span>
                                <?php echo $invoice_customer_lists->jobsheet_no; ?> 
                                </div>
                            </div>
                        <?php }if($invoice_customer_lists->next_service_dt){ ?>    
                            <div class="clearfix">
                                <div><span class="hyheadline"><?php _trans('lable299');?> :</span>
                                <?php echo ($invoice_customer_lists->next_service_dt?date_from_mysql($invoice_customer_lists->next_service_dt):""); ?>                            
                                </div>
                            </div>  
                        <?php } ?>	      
                    </div> 
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <?php if($invoice_customer_lists->customer_details->client_name){ ?>    
                            <div class="clearfix">
                                <div><span class="hyheadline"><?php _trans('lable36');?> :</span>
                                <?php echo $invoice_customer_lists->customer_details->client_name; ?> 
                                </div>
                            </div>
                        <?php } if($invoice_customer_lists->customer_details->client_contact_no != ""){?>
                            <div class="clearfix">
                                <div><span class="hyheadline"><?php _trans('lable1051');?> :</span>
                                <?php echo $invoice_customer_lists->customer_details->client_contact_no;?>
                                </div>
                            </div>
                        <?php } if($invoice_customer_lists->customer_details->client_email_id != ""){ ?>    
                            <div class="clearfix">
                                <div><span class="hyheadline"><?php _trans('lable38');?> :</span>
								<?php echo $invoice_customer_lists->customer_details->client_email_id; ?>
                                </div>
                            </div>        
                        <?php } if($invoice_customer_lists->user_address_id){ ?>
                            <div class="clearfix">
                                <div><span class="hyheadline"><?php _trans('lable61');?> :</span>
                                    <?php echo $this->mdl_user_address->get_user_complete_address($invoice_customer_lists->user_address_id); ?>
                                </div>
                            </div>    
                        <?php } if($invoice_customer_lists->customer_details->client_gstin){ ?>    
                            <div class="clearfix">
                                <div><span class="hyheadline"><?php _trans('lable910');?> :</span>
                                <?php echo $invoice_customer_lists->customer_details->client_gstin; ?> 
                                </div>
                            </div>    
                        <?php }?>    
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="float:right;">
                            <?php if($invoice_detail->car_reg_no){ ?>
                            <div class="clearfix">
                                <div><span class="hyheadline"><?php _trans('lable72');?> :</span>
                                <?php echo $invoice_detail->car_reg_no; ?>
                                </div>
                            </div>    
                            <?php } if($invoice_customer_lists->brand_name){ ?>    
                            <div class="clearfix">
                                <div><span class="hyheadline"><?php _trans('lable1049');?> :</span>
                                <?php echo $invoice_customer_lists->brand_name; ?> <?php echo ($invoice_customer_lists->car_model_year?$invoice_customer_lists->car_model_year."-":" ")."".($invoice_customer_lists->model_name?$invoice_customer_lists->model_name:"")."".($invoice_customer_lists->variant_name?"-".$invoice_customer_lists->variant_name:" "); ?>                                
                                </div>
                            </div>
                            <?php } if($invoice_customer_lists->current_odometer_reading){ ?>
                            <div class="clearfix">
                                <div><span class="hyheadline"><?php _trans('lable1113');?> :</span>
                                <?php echo $invoice_customer_lists->current_odometer_reading; ?>                                
                                </div>
                            </div>
                            <?php } if($invoice_customer_lists->next_service_km){ ?>
                            <div class="clearfix">
                                <div><span class="hyheadline"><?php _trans('lable298');?> :</span>
                                <?php echo $invoice_customer_lists->next_service_km; ?> 
                                </div>
                            </div>
                            <?php } ?>
                    </div>    
                </div> 
                <!-- //Part_list// -->
                <?php if(count($invoice_customer_lists->product_list) > 0){ ?>
                    <div class="topdiv col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:1px;">
                            <div class="divcolor col-lg-1 col-md-1 col-sm-1 col-xs-12 form-group clearfix">
                                <h5 class="hyheadline"><?php _trans('lable125'); ?></h5>
                            </div>
                            <div class="divcolor col-lg-3 col-md-3 col-sm-3 col-xs-12 form-group clearfix">
                                <h5 class="hyheadline"><?php _trans('lable1234'); ?></h5>
                            </div>
                            <div class="divcolor col-lg-5 col-md-5 col-sm-5 col-xs-12  form-group clearfix">
                                <h5 class="hyheadline"><?php _trans('lable1235'); ?></h5>
                            </div>
                            <div class="divcolor col-lg-3 col-md-3 col-sm-3 col-xs-12 form-group clearfix">
                                <h5 class="hyheadline"><?php _trans('lable348'); ?></h5>
                            </div>
                        </div>
                    <?php $i = 1; foreach(json_decode($invoice_customer_lists->product_list) as $key => $product_lists){ ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                <div class="clearfix">
                                    <?php echo $i;$i++; ?>
                                </div>
                            </div> 
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <div class="clearfix">
                                    <?php echo $product_lists->product_id; ?>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12" style="padding: 0px 2%;">
                                <div class="clearfix">
                                    <?php echo $product_lists->item_product_name; ?>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="padding: 0px 4%;">
                                <div class="clearfix">
                                    <?php echo $product_lists->item_qty; ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?> 
                    </div>
                <?php } ?>  
                 <!-- //Labour_list// -->
                <?php if(count($invoice_customer_lists->service_list) > 0){ ?>
                    <div class="topdiv col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:1px;">
                            <div class="divcolor col-lg-1 col-md-1 col-sm-1 col-xs-12 form-group clearfix">
                                <h5 class="hyheadline"><?php _trans('lable125'); ?></h5>
                            </div>
                            <div class="divcolor col-lg-3 col-md-3 col-sm-3 col-xs-12 form-group clearfix">
                                <h5 class="hyheadline"><?php _trans('lable1232'); ?></h5>
                            </div>
                            <div class="divcolor col-lg-8 col-md-8 col-sm-8 col-xs-12 form-group clearfix" style="float:right;">
                                <h5 class="hyheadline"><?php _trans('lable1233'); ?></h5>
                            </div>
                        </div>
                    <?php $j = 1; foreach(json_decode($invoice_customer_lists->service_list) as $key => $service_lists){ ?>        
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                <div class="clearfix">
                                    <?php echo $j;$j++; ?>
                                </div>
                            </div> 
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="padding: 0px 1.5%;">
                                <div class="clearfix">
                                    <?php echo $service_lists->msim_id; ?>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" style="padding: 0px 2%;">
                                <div class="clearfix">
                                    <?php echo $service_lists->service_item_name; ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?> 
                    </div>
                <?php } ?>  
                 <!-- //service_package_list// -->
                <?php if(count($invoice_customer_lists->service_package_list) > 0){ ?>
                    <div class="topdiv col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:1px;">
                            <div class="divcolor col-lg-1 col-md-1 col-sm-1 col-xs-12 form-group clearfix">
                                <h5 class="hyheadline"><?php _trans('lable125'); ?></h5>
                            </div>
                            <div class="divcolor col-lg-3 col-md-3 col-sm-3 col-xs-12 form-group clearfix">
                                <h5 class="hyheadline"><?php _trans('lable1231'); ?></h5>
                            </div>
                            <div class="divcolor col-lg-8 col-md-8 col-sm-8 col-xs-12 form-group clearfix" style="float:right;">
                                <h5 class="hyheadline"><?php _trans('lable1230'); ?></h5>
                            </div>
                        </div>
                    <?php $k = 1; foreach(json_decode($invoice_customer_lists->service_package_list) as $key => $service_package_lists){ ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                <div class="clearfix">
                                    <?php echo $k;$k++; ?>
                                </div>
                            </div> 
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="padding: 0px 1.5%;">
                                <div class="clearfix">
                                    <?php echo $service_package_lists->s_pack_id; ?>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" style="padding: 0px 2%;">
                                <div class="clearfix">
                                    <?php echo $service_package_lists->service_item_name; ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?> 
                    </div>
                <?php } ?>
            <?php } ?>                    
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">

    $(".btn").click(function() {

        $('.has-error').removeClass('has-error');
        $('.border_error').removeClass("border_error");

        var validation = [];

        if($("#customer_id").val() == ''){
            validation.push('customer_id');
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
</script> 
<style>
.hyheadline{
    font-weight: bold;
    padding: 10px;
    margin: 0px;
}
.topdiv{
    padding:1px 1px 15px 1px;
}
.divcolor{
    border-bottom: 1px solid #d3d3d3;background: #f6f8fa;
}
.onlyhis{
    padding:10px;border-bottom: 1px solid #d3d3d3;
}
.onlyhr{
    border-bottom: 1px solid #d3d3d3;
}
</style>
<?php } ?>