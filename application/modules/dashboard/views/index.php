
<style>
.c3-axis.c3-axis-y,.c3-axis.c3-axis-y {
   display: none;
}
.c3-line {
    stroke-width: 15px;
}
#chart_container .btn-group .active{
	background: #fede00;
    border-color: #fede00;
}
</style>
<link href="<?php echo base_url(); ?>assets/lib/c3.min.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url(); ?>assets/lib/d3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/lib/c3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/lib/c3js-init.js"></script>
<!-- <div class="firstmainBg"><div class="mainBG"></div></div> -->
<div class="container-fluid">
	<input type="hidden" id="<?php echo $this->security->get_csrf_token_name(); ?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" autocomplete="off">
    <div class="row marginTopBot10px">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 float_right">
            <div class="btn-group float_right summaryBoxOne" role="group" aria-label="Basic example">
                <button type="button" class="btn activegroupBtn" id="total" onclick="daymonth('T')">All</button>
                <button type="button" class="btn" id="month" onclick="daymonth('M')">Month</button>
                <button type="button" class="btn" id="week" onclick="daymonth('W')">Week</button>
                <button type="button" class="btn" id="day" onclick="daymonth('D')">Day</button>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-right">
                <span id="showDateNumber" class="dateText"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- jobs status types -->
        <?php foreach($permission as $perlist){
        if($perlist->module_name == "jobs"){ 
        if($this->session->userdata('workshop_is_enabled_jobsheet') == 'Y'){ ?>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 marginTopBot10px">
            <a href="<?php echo site_url('mech_work_order_dtls'); ?>" target="_blank">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 summaryBox">
                    <div class="summaryBoxContent">
                        <div class="summaryBoxContentImage">
                            <span class="summaryBoxContentSpanBoxone leadsBg">
                                <span class="spaninnerVerticle">
                                    <img class="ImageSpan" src="<?php echo base_url(); ?>assets/mp_backend/img/leads.svg">
                                </span>
                            </span>
                            <span class="summaryBoxContentSpanBoxTwo ml_15px">
                                <div class="spanBoxtwoContent" id="total_job_openings"><?php echo $total_job_openings; ?></div>
                                <div class="mutedText"><?php _trans('dash7'); ?></div>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 marginTopBot10px">
            <a href="<?php echo site_url('mech_work_order_dtls'); ?>" target="_blank">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 summaryBox">
                    <div class="summaryBoxContent">
                        <div class="summaryBoxContentImage">
                            <span class="summaryBoxContentSpanBoxone appointmentBg">
                                <span class="spaninnerVerticle">
                                    <img class="ImageSpan" src="<?php echo base_url(); ?>assets/mp_backend/img/appointment.svg">
                                </span>
                            </span>
                            <span class="summaryBoxContentSpanBoxTwo ml_15px">
                                <div class="spanBoxtwoContent" id="total_working_progress"><?php echo $total_working_progress; ?></div>
                                <div class="mutedText"><?php _trans('dash8'); ?></div>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 marginTopBot10px">
            <a href="<?php echo site_url('mech_work_order_dtls'); ?>" target="_blank">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 summaryBox">
                    <div class="summaryBoxContent">
                        <div class="summaryBoxContentImage">
                            <span class="summaryBoxContentSpanBoxone jobCompBg">
                                <span class="spaninnerVerticle">
                                    <img class="ImageSpan" src="<?php echo base_url(); ?>assets/mp_backend/img/jobcard.svg">
                                </span>
                            </span>
                            <span class="summaryBoxContentSpanBoxTwo ml_15px">
                                <div class="spanBoxtwoContent" id="total_job_completeds"><?php echo $total_job_completeds; ?></div>
                                <div class="mutedText"><?php _trans('lable4'); ?></div>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 marginTopBot10px">
            <a href="<?php echo site_url('mech_work_order_dtls'); ?>" target="_blank">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 summaryBox">
                    <div class="summaryBoxContent">
                        <div class="summaryBoxContentImage">
                            <span class="summaryBoxContentSpanBoxone jobPendBg">
                                <span class="spaninnerVerticle">
                                    <img class="ImageSpan" src="<?php echo base_url(); ?>assets/mp_backend/img/jobcard.svg">
                                </span>
                            </span>
                            <span class="summaryBoxContentSpanBoxTwo ml_15px">
                                <div class="spanBoxtwoContent" id="total_onhold"><?php echo $total_onhold; ?></div>
                                <div class="mutedText"><?php _trans('dash9'); ?></div>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php }}} ?>
    </div>
    <div class="row">
    <!-- invoice -->
    <?php foreach($permission as $perlist){
        if($perlist->module_name == "invoice"){ ?>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 marginTopBot10px">
            <a href="<?php echo site_url('mech_invoices');?>" target="_blank" >
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 summaryBox">
                    <div class="summaryBoxContent">
                        <div class="summaryBoxContentImage">
                            <span class="summaryBoxContentSpanBoxone incomeBg">
                                <span class="spaninnerVerticle">
                                    <img class="ImageSpan" src="<?php echo base_url(); ?>assets/mp_backend/img/income.svg">
                                </span>
                            </span>
                            <span class="summaryBoxContentSpanBoxTwo ml_15px">
                                <div class="spanBoxtwoContent" id="total_income"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($total_income,$this->session->userdata('default_currency_digit')); ?></div>
                                <div class="mutedText"><?php _trans('dash3'); ?></div>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php }} ?>
        <!-- Purchase -->
        <?php foreach($permission as $perlist){
        if($perlist->module_name == "purchase"){  ?>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 marginTopBot10px">
            <a href="<?php echo site_url('mech_purchase'); ?>" target="_blank">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 summaryBox">
                    <div class="summaryBoxContent">
                        <div class="summaryBoxContentImage">
                            <span class="summaryBoxContentSpanBoxone incomepaidBg">
                                <span class="spaninnerVerticle">
                                    <img class="ImageSpan" src="<?php echo base_url(); ?>assets/mp_backend/img/total-income-paid.svg">
                                </span>
                            </span>
                            <span class="summaryBoxContentSpanBoxTwo ml_15px">
                                <div class="spanBoxtwoContent" id="total_purchase"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($total_purchase,$this->session->userdata('default_currency_digit')); ?></div>
                                <div class="mutedText"><?php _trans('dash10'); ?></div>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php }} ?>
        <!-- Expense -->
        <?php foreach($permission as $perlist){
        if($perlist->module_name == "expense"){ ?>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 marginTopBot10px">
            <a href="<?php echo site_url('mech_expense');?>" target="_blank" >
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 summaryBox">
                    <div class="summaryBoxContent">
                        <div class="summaryBoxContentImage">
                            <span class="summaryBoxContentSpanBoxone expensepaidBg">
                                <span class="spaninnerVerticle">
                                    <img class="ImageSpan" src="<?php echo base_url(); ?>assets/mp_backend/img/expense-paid.svg">
                                </span>
                            </span>
                            <span class="summaryBoxContentSpanBoxTwo ml_15px">
                                <div class="spanBoxtwoContent" id="total_expenese"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($total_expenese,$this->session->userdata('default_currency_digit')); ?></div>
                                <div class="mutedText"><?php _trans('dash5'); ?></div>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php }} ?>
        <!-- Income & Expense dues -->
        <?php $due = 'style="display:none"';
        foreach($permission as $perlist){
        if($perlist->module_name == "invoice" || $perlist->module_name == "expense"){ 
            $due = 'style="display:block"';
        } } ?>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 marginTopBot10px" <?php echo $due; ?> >
            <a href="javascript:void(0)">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 summaryBox">
                    <div class="summaryBoxContent">
                        <div class="summaryBoxContentImage">
                            <span class="summaryBoxContentSpanBoxone expenseDueBg">
                                <span class="spaninnerVerticle">
                                    <img class="ImageSpan" src="<?php echo base_url(); ?>assets/mp_backend/img/expense-due.svg">
                                </span>
                            </span>
                            <span class="summaryBoxContentSpanBoxTwo ml_15px">
                                <div class="spanBoxtwoContent" id="total_expenese_due"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($total_income_due,$this->session->userdata('default_currency_digit')); ?> / <?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($total_expenese_due,$this->session->userdata('default_currency_digit')); ?></div>
                                <div class="mutedText"><?php _trans('dash3'); ?> / <?php _trans('dash6'); ?></div>
                            </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <!-- Jobs tabs -->
    <?php foreach($permission as $perlist){
    if($perlist->module_name == "jobs"){ 
    if($this->session->userdata('workshop_is_enabled_jobsheet') == 'Y'){ ?>
    <div class="row margin-bottom-10px">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop20px">
			<div class="nav nav-tabs">
				<div class="tbl">
					<ul class="nav" role="tablist">
						<li class="nav-item">
							<a class="navListlink nav-link active show in" href="#tabs-1-tab-1" role="tab" data-toggle="tab" aria-selected="1">
								<span class="leftHeadSpan nav-link-in"><?php _trans('dash7'); ?></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link " href="#tabs-2-tab-1" role="tab" data-toggle="tab" aria-selected="">
								<span class="leftHeadSpan nav-link-in"><?php _trans('dash8'); ?></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link " href="#tabs-3-tab-1" role="tab" data-toggle="tab" aria-selected="">
								<span class="leftHeadSpan nav-link-in"><?php _trans('dash12'); ?></span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 padding0px">
            	<section class="tabs-section">
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane fade active show in dahsboard-column" id="tabs-1-tab-1">
                            <section class="box-typical box-typical-dashboard panel panel-default scrollable" style="margin-bottom: 0px">
                                <div class="box-typical-body panel-body">
                                    <table class="tbl-typical display table datatable table-bordered" cellspacing="0" width="100%" style="margin-top:0px ! important;">
                                        <thead>
                                            <tr>
                                                <th><?php _trans('lable20');?></th>
                                                <th class="text_align_center"><?php _trans('lable278');?></th>
                                                <th><?php _trans('lable95'); ?></th>
                                                <th><?php _trans('lable36');?></th>
                                                <th><?php _trans('lable273');?></th>
                                                <th class="text_align_right"><?php _trans('lable1018');?></th>
                                                <th class="text-center"><?php _trans('lable22');?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(count($open_job_list)>0) {
                                            $i = 1;
                                            foreach ($open_job_list as $work_ord_list) { 
                                                if(count($open_job_list) >= 4)
                                                {  
                                                    if(count($open_job_list) == $i || count($open_job_list) == $i+1)
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
                                                <td data-original-title="<?php _htmlsc($work_ord_list->jobsheet_no?$work_ord_list->jobsheet_no:""); ?>" data-toggle="tooltip" class="textEllipsis"><a href="<?php echo site_url('mech_work_order_dtls/view/'.$work_ord_list->work_order_id.'/'.$work_ord_list->jobsheet_status); ?>"><?php _htmlsc($work_ord_list->jobsheet_no?$work_ord_list->jobsheet_no:""); ?></a></td>
                                                <td data-original-title="<?php _htmlsc($work_ord_list->issue_date?date_from_mysql($work_ord_list->issue_date):'-'); ?>" data-toggle="tooltip" class="textEllipsis text_align_center"><?php _htmlsc($work_ord_list->issue_date?date_from_mysql($work_ord_list->issue_date):'-'); ?></td>
                                                <td data-original-title="<?php _htmlsc($work_ord_list->display_board_name); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($work_ord_list->display_board_name); ?></td>
                                                <td data-original-title="<?php _htmlsc($work_ord_list->client_name); ?><?php _htmlsc(($work_ord_list->client_contact_no?" ( ".$work_ord_list->client_contact_no." )":"")); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($work_ord_list->client_name); ?><?php _htmlsc(($work_ord_list->client_contact_no?" ( ".$work_ord_list->client_contact_no." )":"")); ?></td>
                                                <td data-original-title="<?php echo $work_ord_list->car_reg_no; ?> <?php _htmlsc(($work_ord_list->brand_name?$work_ord_list->brand_name:" ")." ".($work_ord_list->model_name?$work_ord_list->model_name:" ")." ".($work_ord_list->variant_name?$work_ord_list->variant_name:' ')." ".($work_ord_list->car_model_year?$work_ord_list->car_model_year:" "));?>" data-toggle="tooltip" class="textEllipsis"><span class="car_reg_no"><?php echo $work_ord_list->car_reg_no; ?></span><br><?php _htmlsc(($work_ord_list->brand_name?$work_ord_list->brand_name:" ")." ".($work_ord_list->model_name?$work_ord_list->model_name:" ")." ".($work_ord_list->variant_name?$work_ord_list->variant_name:' ')." ".($work_ord_list->car_model_year?$work_ord_list->car_model_year:" ")); ?></td>
                                                <td class="text-right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($work_ord_list->total_paid_amount?$work_ord_list->total_paid_amount:0),$this->session->userdata('default_currency_digit'));?>" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($work_ord_list->total_paid_amount?$work_ord_list->total_paid_amount:0),$this->session->userdata('default_currency_digit')); ?></td>
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
                                                                <a href="javascript:void(0)" data-type-id="J" data-toggle="modal" data-target="#sendSms" data-invoice-id="<?php echo $work_ord_list->work_order_id; ?>" class="send_sms">
                                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable903'); ?>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a target="_blank" href="<?php echo site_url('mech_work_order_dtls/generate_pdf/'.$work_ord_list->work_order_id); ?>">
                                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable141'); ?>
                                                                </a>
                                                            </li>
                                                            <?php if($work_ord_list->insuranceBillingCheckBox == 1){ ?>
                                                            <li>
                                                                <a target="_blank" href="<?php echo site_url('mech_work_order_dtls/generate_insurance_pdf/'.$work_ord_list->work_order_id); ?>">
                                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable304'); ?>
                                                                </a>
                                                            </li>
                                                            <?php } ?>
                                                            
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
                            </section>
						</div>
						<div role="tabpanel" class="tab-pane fade " id="tabs-2-tab-1">
                            <section class="box-typical box-typical-dashboard panel panel-default scrollable" style="margin-bottom: 0px">
                                <div class="box-typical-body panel-body">
                                    <table class="tbl-typical display table datatable table-bordered" cellspacing="0" width="100%" style="margin-top:0px ! important;">
                                        <thead>
                                            <tr>
                                                <th><?php _trans('lable20');?></th>
                                                <th class="text_align_center"><?php _trans('lable278');?></th>
                                                <th><?php _trans('lable95'); ?></th>
                                                <th><?php _trans('lable36');?></th>
                                                <th><?php _trans('lable273');?></th>
                                                <th class="text_align_right"><?php _trans('lable1018');?></th>
                                                <th class="text-center"><?php _trans('lable22');?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(count($wip_job_list)>0) {
                                            $i = 1;
                                            foreach ($wip_job_list as $work_ord_list) { 
                                                if(count($wip_job_list) >= 4)
                                                {  
                                                    if(count($wip_job_list) == $i || count($wip_job_list) == $i+1)
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
                                                <td data-original-title="<?php _htmlsc($work_ord_list->jobsheet_no?$work_ord_list->jobsheet_no:""); ?>" data-toggle="tooltip" class="textEllipsis"><a href="<?php echo site_url('mech_work_order_dtls/view/'.$work_ord_list->work_order_id.'/'.$work_ord_list->jobsheet_status); ?>"><?php _htmlsc($work_ord_list->jobsheet_no?$work_ord_list->jobsheet_no:""); ?></a></td>
                                                <td data-original-title="<?php _htmlsc($work_ord_list->issue_date?date_from_mysql($work_ord_list->issue_date):'-'); ?>" data-toggle="tooltip" class="textEllipsis text_align_center"><?php _htmlsc($work_ord_list->issue_date?date_from_mysql($work_ord_list->issue_date):'-'); ?></td>
                                                <td data-original-title="<?php _htmlsc($work_ord_list->display_board_name); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($work_ord_list->display_board_name); ?></td>
                                                <td data-original-title="<?php _htmlsc($work_ord_list->client_name); ?><?php _htmlsc(($work_ord_list->client_contact_no?" ( ".$work_ord_list->client_contact_no." )":"")); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($work_ord_list->client_name); ?><?php _htmlsc(($work_ord_list->client_contact_no?" ( ".$work_ord_list->client_contact_no." )":"")); ?></td>
                                                <td data-original-title="<?php echo $work_ord_list->car_reg_no; ?> <?php _htmlsc(($work_ord_list->brand_name?$work_ord_list->brand_name:" ")." ".($work_ord_list->model_name?$work_ord_list->model_name:" ")." ".($work_ord_list->variant_name?$work_ord_list->variant_name:' ')." ".($work_ord_list->car_model_year?$work_ord_list->car_model_year:" "));?>" data-toggle="tooltip" class="textEllipsis"><span class="car_reg_no"><?php echo $work_ord_list->car_reg_no; ?></span><br><?php _htmlsc(($work_ord_list->brand_name?$work_ord_list->brand_name:" ")." ".($work_ord_list->model_name?$work_ord_list->model_name:" ")." ".($work_ord_list->variant_name?$work_ord_list->variant_name:' ')." ".($work_ord_list->car_model_year?$work_ord_list->car_model_year:" ")); ?></td>
                                                <td class="text-right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($work_ord_list->total_paid_amount?$work_ord_list->total_paid_amount:0),$this->session->userdata('default_currency_digit'));?>" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($work_ord_list->total_paid_amount?$work_ord_list->total_paid_amount:0),$this->session->userdata('default_currency_digit')); ?></td>
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
                                                                <a href="javascript:void(0)" data-type-id="J" data-toggle="modal" data-target="#sendSms" data-invoice-id="<?php echo $work_ord_list->work_order_id; ?>" class="send_sms">
                                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable903'); ?>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a target="_blank" href="<?php echo site_url('mech_work_order_dtls/generate_pdf/'.$work_ord_list->work_order_id); ?>">
                                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable141'); ?>
                                                                </a>
                                                            </li>
                                                            <?php if($work_ord_list->insuranceBillingCheckBox == 1){ ?>
                                                            <li>
                                                                <a target="_blank" href="<?php echo site_url('mech_work_order_dtls/generate_insurance_pdf/'.$work_ord_list->work_order_id); ?>">
                                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable304'); ?>
                                                                </a>
                                                            </li>
                                                            <?php } if($this->session->userdata('job_card_E') == 1){ ?>
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
                            </section>
						</div>
						<div role="tabpanel" class="tab-pane fade " id="tabs-3-tab-1">
                            <section class="box-typical box-typical-dashboard panel panel-default scrollable" style="margin-bottom: 0px">
                                <div class="box-typical-body panel-body">
                                    <table class="tbl-typical display table datatable table-bordered" cellspacing="0" width="100%" style="margin-top:0px ! important;">
                                        <thead>
                                            <tr>
                                                <th><?php _trans('lable20');?></th>
                                                <th class="text_align_center"><?php _trans('lable278');?></th>
                                                <th><?php _trans('lable95'); ?></th>
                                                <th><?php _trans('lable36');?></th>
                                                <th><?php _trans('lable273');?></th>
                                                <th class="text_align_right"><?php _trans('lable1018');?></th>
                                                <th class="text-center"><?php _trans('lable22');?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(count($spare_requested_job_list)>0) {
                                            $i = 1;
                                            foreach ($spare_requested_job_list as $work_ord_list) { 
                                                if(count($spare_requested_job_list) >= 4)
                                                {  
                                                    if(count($spare_requested_job_list) == $i || count($spare_requested_job_list) == $i+1)
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
                                                <td data-original-title="<?php _htmlsc($work_ord_list->jobsheet_no?$work_ord_list->jobsheet_no:""); ?>" data-toggle="tooltip" class="textEllipsis"><a href="<?php echo site_url('mech_work_order_dtls/view/'.$work_ord_list->work_order_id.'/'.$work_ord_list->jobsheet_status); ?>"><?php _htmlsc($work_ord_list->jobsheet_no?$work_ord_list->jobsheet_no:""); ?></a></td>
                                                <td data-original-title="<?php _htmlsc($work_ord_list->issue_date?date_from_mysql($work_ord_list->issue_date):'-'); ?>" data-toggle="tooltip" class="textEllipsis text_align_center"><?php _htmlsc($work_ord_list->issue_date?date_from_mysql($work_ord_list->issue_date):'-'); ?></td>
                                                <td data-original-title="<?php _htmlsc($work_ord_list->display_board_name); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($work_ord_list->display_board_name); ?></td>
                                                <td data-original-title="<?php _htmlsc($work_ord_list->client_name); ?><?php _htmlsc(($work_ord_list->client_contact_no?" ( ".$work_ord_list->client_contact_no." )":"")); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($work_ord_list->client_name); ?><?php _htmlsc(($work_ord_list->client_contact_no?" ( ".$work_ord_list->client_contact_no." )":"")); ?></td>
                                                <td data-original-title="<?php echo $work_ord_list->car_reg_no; ?> <?php _htmlsc(($work_ord_list->brand_name?$work_ord_list->brand_name:" ")." ".($work_ord_list->model_name?$work_ord_list->model_name:" ")." ".($work_ord_list->variant_name?$work_ord_list->variant_name:' ')." ".($work_ord_list->car_model_year?$work_ord_list->car_model_year:" "));?>" data-toggle="tooltip" class="textEllipsis"><span class="car_reg_no"><?php echo $work_ord_list->car_reg_no; ?></span><br><?php _htmlsc(($work_ord_list->brand_name?$work_ord_list->brand_name:" ")." ".($work_ord_list->model_name?$work_ord_list->model_name:" ")." ".($work_ord_list->variant_name?$work_ord_list->variant_name:' ')." ".($work_ord_list->car_model_year?$work_ord_list->car_model_year:" ")); ?></td>
                                                <td class="text-right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($work_ord_list->total_paid_amount?$work_ord_list->total_paid_amount:0),$this->session->userdata('default_currency_digit'));?>" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money(($work_ord_list->total_paid_amount?$work_ord_list->total_paid_amount:0),$this->session->userdata('default_currency_digit')); ?></td>
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
                                                                <a href="javascript:void(0)" data-type-id="J" data-toggle="modal" data-target="#sendSms" data-invoice-id="<?php echo $work_ord_list->work_order_id; ?>" class="send_sms">
                                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable903'); ?>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a target="_blank" href="<?php echo site_url('mech_work_order_dtls/generate_pdf/'.$work_ord_list->work_order_id); ?>">
                                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable141'); ?>
                                                                </a>
                                                            </li>
                                                            <?php if($work_ord_list->insuranceBillingCheckBox == 1){ ?>
                                                            <li>
                                                                <a target="_blank" href="<?php echo site_url('mech_work_order_dtls/generate_insurance_pdf/'.$work_ord_list->work_order_id); ?>">
                                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable304'); ?>
                                                                </a>
                                                            </li>
                                                            <?php } ?>
                                                            
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
                            </section> 
						</div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right paddingTop20px">
                            <a href="<?php echo site_url('mech_work_order_dtls');?>" target="_blank">See More</a>
                        </div>
					</div>
				</section>
			</div>
		</div>
    </div>
    <?php }}} ?>
    <!-- Leads & Appointments -->
    <?php $showLeadsAppointment = 'style="display:none"';
    foreach($permission as $perlist){
    if($perlist->module_name == "leads" || $perlist->module_name == "appointments"){
        $showLeadsAppointment = 'style="display:block"';
    } }?>
    <div class="row margin-bottom-10px" <?php echo $showLeadsAppointment;?> >
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop20px">
			<div class="nav nav-tabs">
				<div class="tbl">
					<ul class="nav" role="tablist">
                    <?php foreach($permission as $perlist){
                        if($perlist->module_name == "leads"){ ?>
						<li class="nav-item">
							<a class="navListlink nav-link active show in" href="#tabs-4-tab-1" role="tab" data-toggle="tab" aria-selected="1">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable757'); ?></span>
							</a>
						</li>
                        <?php } if($perlist->module_name == "appointments"){ ?>
						<li class="nav-item">
							<a class="navListlink nav-link " href="#tabs-5-tab-1" role="tab" data-toggle="tab" aria-selected="">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable758'); ?></span>
							</a>
						</li>
                        <?php }} ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 padding0px">
            	<section class="tabs-section">
					<div class="tab-content">
                        <?php foreach($permission as $perlist){
                        if($perlist->module_name == "leads"){ ?>
						<div role="tabpanel" class="tab-pane fade active show in dahsboard-column" id="tabs-4-tab-1">
                            <section class="box-typical box-typical-dashboard panel panel-default scrollable" style="margin-bottom: 0px">
                                <div class="box-typical-body panel-body">
                                    <table class="tbl-typical display table datatable table-bordered" cellspacing="0" width="100%" style="margin-top:0px ! important;">
                                        <thead>
                                            <tr>
                                                <th><?php _trans('lable36'); ?></th>
                                                <th class="text-center"><div><?php _trans('lable37'); ?></div></th>
                                                <th class="text-center"><div><?php _trans('lable759'); ?></div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (count($recent_leads) > 0) {
                                        foreach ($recent_leads as $todayLea) { ?>
                                            <tr>
                                                <td><a target="_blank" href="<?php echo site_url('mech_leads/view/'.$todayLea->ml_id.'');?>"><?php echo $todayLea->client_name; ?></a></td>
                                                <td class="text-center"><?php echo $todayLea->client_contact_no; ?></td>
                                                <td class="text-center"><?php if($todayLea->reschedule_date != "" && $todayLea->reschedule_date != "0000-00-00 00:00:00"){echo " (".date("d-m-Y H:i:s", strtotime($todayLea->reschedule_date)).")";} ?></td>					
                                            </tr>
                                        <?php } } else { ?>
                                            <tr><td colspan="3" class="text_align_center"><?php _trans('lable23'); ?></td></tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right paddingTop20px">
                                <a href="<?php echo site_url('mech_leads');?>" target="_blank">See More</a>
                            </div>
						</div>
                        <?php } if($perlist->module_name == "appointments"){ ?>
						<div role="tabpanel" class="tab-pane fade " id="tabs-5-tab-1">
                            <section class="box-typical box-typical-dashboard panel panel-default scrollable" style="margin-bottom: 0px">
                                <div class="box-typical-body panel-body">
                                    <table class="tbl-typical display table datatable table-bordered" cellspacing="0" width="100%" style="margin-top:0px ! important;">
                                        <thead>
                                            <tr>
                                                <th><div><?php _trans('lable36'); ?></div></th>
                                                <th class="text-center"><div><?php _trans('lable37'); ?></div></th>
                                                <th class="text-center"><div><?php _trans('lable759'); ?></div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (count($recent_appointments) > 0) {
                                            foreach ($recent_appointments as $todayLea) { ?>
						                    <tr>
                                                <td><a target="_blank" href="<?php echo site_url('mech_appointments/view/'.$todayLea->ml_id.'');?>"><?php echo $todayLea->client_name; ?></a></td>
                                                <td class="text-center"><?php echo $todayLea->client_contact_no; ?></td>
                                                <td class="text-center"><?php if($todayLea->reschedule_date != "" && $todayLea->reschedule_date != "0000-00-00 00:00:00"){echo " (".date("d-m-Y H:i:s", strtotime($todayLea->reschedule_date)).")";} ?></td>					
						                    </tr>
						                <?php } } else { ?>
							                <tr><td colspan="3" class="text_align_center"><?php _trans('lable23'); ?></td></tr>
						                <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right paddingTop20px">
                                <a href="<?php echo site_url('mech_appointments');?>" target="_blank">See More</a>
                            </div>
						</div>
                        <?php }} ?>
					</div>
				</section>
			</div>
		</div>
    </div>
    <!-- Reminder -->
    <?php $showReminder = 'style="display:none"';
    foreach($permission as $perlist){
    if($perlist->module_name == "reminder"){
        $showReminder = 'style="display:block"';
    } }?>
    <div class="row margin-bottom-10px" <?php echo $showReminder;?> >
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop20px">
			<div class="nav nav-tabs">
				<div class="tbl">
					<ul class="nav" role="tablist">
						<li class="nav-item">
							<a class="navListlink nav-link active show in" href="#tabs-6-tab-1" role="tab" data-toggle="tab" aria-selected="1">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable297'); ?></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link " href="#tabs-7-tab-1" role="tab" data-toggle="tab" aria-selected="">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable300'); ?></span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 padding0px">
            	<section class="tabs-section">
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane fade active show in dahsboard-column" id="tabs-6-tab-1">
                            <section class="box-typical box-typical-dashboard panel panel-default scrollable" style="margin-bottom: 0px">
                                <div class="box-typical-body panel-body">
                                    <table class="tbl-typical display table datatable table-bordered" cellspacing="0" width="100%" style="margin-top:0px ! important;">
                                        <thead>
                                            <tr>
                                                <th><div><?php _trans('lable36'); ?></div></th>
                                                <th><div><?php _trans('lable72'); ?></div></th>
                                                <th><div><?php _trans('lable299'); ?></div></th>
                                                <th><div><?php _trans('lable298'); ?></div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (count($service_remainder) > 0) {
                                                foreach ($service_remainder as $serviceremin) { ?>
                                            <tr>
                                                <td><a href="<?php echo site_url('mech_work_order_dtls/view/'.$serviceremin->work_order_id);?>" target="_blank"><?php echo $serviceremin->client_name; ?></a></td>
                                                <td class="car_reg_no"><?php echo $serviceremin->car_reg_no; ?></td>
                                                <td><?php echo ($serviceremin->next_service_date?date_from_mysql($serviceremin->next_service_date):""); ?></td>	
                                                <td><?php echo $serviceremin->next_service_km; ?></td>				
                                            </tr>
                                            <?php }} else { ?>
                                                <tr><td colspan="4" class="text_align_center"><?php _trans('lable23'); ?></td></tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </section>
						</div>
						<div role="tabpanel" class="tab-pane fade " id="tabs-7-tab-1">
                            <section class="box-typical box-typical-dashboard panel panel-default scrollable" style="margin-bottom: 0px">
                                <div class="box-typical-body panel-body">
                                    <table class="tbl-typical display table datatable table-bordered" cellspacing="0" width="100%" style="margin-top:0px ! important;">
                                        <thead>
                                            <tr>
                                                <th><div><?php _trans('lable36'); ?></div></th>
                                                <th><div><?php _trans('lable72'); ?></div></th>
                                                <th><div><?php _trans('lable301'); ?></div></th>
                                                <th><div><?php _trans('lable302'); ?></div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(count($insurance_remainder) > 0) {
                                            foreach ($insurance_remainder as $insuranceremainder) { ?>
                                            <tr>
                                                <td><a href="<?php echo site_url('mech_work_order_dtls/view/'.$insuranceremainder->work_order_id);?>" target="_blank"><?php echo $insuranceremainder->client_name; ?></a></td>
                                                <td  class="car_reg_no"><?php echo $insuranceremainder->car_reg_no; ?></td>
                                                <td><?php echo $insuranceremainder->policy_number; ?></td>
                                                <td><?php echo ($insuranceremainder->next_service_ins_date?date_from_mysql($insuranceremainder->next_service_ins_date):""); ?></td>
                                            </tr>   
                                            <?php }} else { ?>
                                                <tr><td colspan="4" class="text_align_center"><?php _trans('lable23'); ?></td></tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </section>
						</div>
					</div>
				</section>
			</div>
		</div>
    </div>
    <!-- Accounts -->
    <?php $showAccountss = 'style="display:none"';
    foreach($permission as $perlist){
    if($perlist->module_name == "invoice" || $perlist->module_name == "expense" || $perlist->module_name == "purchase"){
        $showAccountss = 'style="display:block"';
    } }?>
    <div class="row margin-bottom-10px" <?php echo $showAccountss;?> >
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop20px">
			<div class="nav nav-tabs">
				<div class="tbl">
					<ul class="nav" role="tablist">
                        <?php foreach($permission as $perlist){
                        if($perlist->module_name == "invoice"){ ?>
						<li class="nav-item">
							<a class="navListlink nav-link active show in" href="#tabs-10-tab-1" role="tab" data-toggle="tab" aria-selected="1">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable28'); ?></span>
							</a>
						</li>
                        <?php }} foreach($permission as $perlist){ if($perlist->module_name == "expense"){ ?>
						<li class="nav-item">
							<a class="navListlink nav-link " href="#tabs-11-tab-1" role="tab" data-toggle="tab" aria-selected="">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable33'); ?></span>
							</a>
						</li>
                        <?php }}foreach($permission as $perlist){ if($perlist->module_name == "purchase"){ ?>
                        <li class="nav-item">
							<a class="navListlink nav-link " href="#tabs-12-tab-1" role="tab" data-toggle="tab" aria-selected="">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable1185'); ?></span>
							</a>
						</li>
                        <?php }} ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 padding0px">
            	<section class="tabs-section">
					<div class="tab-content">
                        <?php foreach($permission as $perlist){
                        if($perlist->module_name == "invoice"){ ?>
						<div role="tabpanel" class="tab-pane fade active show in dahsboard-column" id="tabs-10-tab-1">
                            <?php  if($this->session->userdata('plan_type') != 3){ ?>
                            <section class="box-typical box-typical-dashboard panel panel-default scrollable" style="margin-bottom: 0px">
                                <div class="box-typical-body panel-body">
                                    <table class="tbl-typical display table datatable table-bordered" cellspacing="0" width="100%" style="margin-top:0px ! important;">
                                        <thead>
                                            <tr>
                                                <th><?php _trans('lable369'); ?></th>
                                                <th><?php _trans('lable29'); ?></th>
                                                <th class="text-center"><?php _trans('lable368'); ?></th>
                                                <th><?php _trans('lable370'); ?></th>
                                                <th><?php _trans('lable371'); ?></th>
                                                <th class="text-right"><?php _trans('lable372'); ?></th>
                                                <th class="text-right"><?php _trans('lable373'); ?></th>
                                                <th class="text_align_center"><?php _trans('lable22'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(count($outstanding_invoice)>0){
                                            $i = 1;
                                            foreach ($outstanding_invoice as $invoice) {
                                                if(count($outstanding_invoice) >= 4)
                                                {
                                                if(count($outstanding_invoice) == $i || count($outstanding_invoice) == $i+1)
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
                                                <td data-original-title="<?php if($invoice->invoice_status == "D"){ echo "Draft"; }
                                                    elseif($invoice->invoice_status == "P"){ echo "Pending"; }
                                                    elseif($invoice->invoice_status == "PP"){ echo "Partial Paid"; }
                                                    elseif($invoice->invoice_status == "FP"){ echo "Paid"; } ?>" data-toggle="tooltip" class="textEllipsis">
                                                    <?php if($invoice->invoice_status == "D"){ echo "Draft"; }
                                                    elseif($invoice->invoice_status == "P"){ echo "Pending"; }
                                                    elseif($invoice->invoice_status == "PP"){ echo "Partial Paid"; }
                                                    elseif($invoice->invoice_status == "FP"){ echo "Paid"; } ?>
                                                </td>
                                                <td data-original-title="<?php _htmlsc($invoice->invoice_no); ?>" data-toggle="tooltip" class="textEllipsis"><a href="<?php echo site_url('mech_invoices/view/'.$invoice->invoice_id); ?>"><?php _htmlsc($invoice->invoice_no); ?></a></td>
                                                <td class="text-center textEllipsis" data-original-title="<?php _htmlsc($invoice->invoice_date?date_from_mysql($invoice->invoice_date):'-'); ?>" data-toggle="tooltip"><?php _htmlsc($invoice->invoice_date?date_from_mysql($invoice->invoice_date):'-'); ?></td>
                                                <td data-original-title="<?php _htmlsc($invoice->client_name.($invoice->client_contact_no?' ('.$invoice->client_contact_no.')':"")); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($invoice->client_name.($invoice->client_contact_no?' ('.$invoice->client_contact_no.')':"")); ?></td>
                                                <td data-original-title="<?php _htmlsc(($invoice->brand_name?$invoice->brand_name."-":" ")." ".($invoice->model_name?$invoice->model_name:"")." ".($invoice->variant_name?"-".$invoice->variant_name:" "));?>" data-toggle="tooltip" class="textEllipsis"><?php echo '<span class="car_reg_no">'.(($invoice->car_reg_no)?$invoice->car_reg_no:"").'</span>';?> <br> <?php _htmlsc(($invoice->brand_name?$invoice->brand_name."-":" ")." ".($invoice->model_name?$invoice->model_name:"")." ".($invoice->variant_name?"-".$invoice->variant_name:" ")); ?></td>
                                                <td class="text-right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($invoice->grand_total,$this->session->userdata('default_currency_digit')); ?>" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($invoice->grand_total,$this->session->userdata('default_currency_digit')); ?></td>
                                                <td class="text-right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($invoice->total_due_amount,$this->session->userdata('default_currency_digit')); ?>" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($invoice->total_due_amount,$this->session->userdata('default_currency_digit')); ?></td>
                                                <td class="text_align_center">
                                                    <div class="options btn-group <?php echo $dropup; ?>">
                                                        <a class="btn btn-default btn-sm dropdown-toggle"
                                                        data-toggle="dropdown" href="#">
                                                            <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                                        </a>
                                                        <ul class="optionTag dropdown-menu">
                                                            <?php if($this->session->userdata('user_type') == 3){ ?>
                                                            <li>
                                                                <?php if($invoice->invoice_status == "FP"){ ?>	
                                                                <?php } else { ?>
                                                                    <a href="<?php echo site_url('mech_invoices/create/' . $invoice->invoice_id); ?>">
                                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                                                    </a>
                                                                <?php } ?>
                                                            </li>
                                                            <?php } ?>

                                                            <?php if($invoice->invoice_status != "D" && $invoice->invoice_status != "FP"){ ?>
                                                            <li>
                                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#enter-payment" data-entity-id="<?php echo $invoice->invoice_id; ?>" data-grand-amt="<?php echo $invoice->grand_total; ?>" data-balance-amt="<?php echo $invoice->total_due_amount; ?>" data-customer-id="<?php echo $invoice->customer_id; ?>" data-entity-type='invoice' class="make-add-payment">
                                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable82'); ?>
                                                                </a>
                                                            </li>
                                                            <?php } ?>

                                                            <?php if($invoice->invoice_status != "D"){ ?>
                                                            <li>
                                                                <a href="javascript:void(0)" data-type-id="I" data-toggle="modal" data-target="#sendSms" data-invoice-id="<?php echo $invoice->invoice_id; ?>" class="send_sms">
                                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable903'); ?>
                                                                </a>
                                                            </li>
                                                            <?php } ?>
                                                            <li>
                                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#addNewCar" data-invoice-id="<?php echo $invoice->invoice_id; ?>" class="add_feedback">
                                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable374'); ?>
                                                                </a>
                                                            </li>
                                                            <?php if($is_product == "Y"){ ?>
                                                            <li>
                                                                <a href="javascript:void(0)" data-toggle="modal" data-model_from="I" data-invoice_id="<?php echo $invoice->invoice_id;?>" data-customer_id="<?php echo $invoice->customer_id; ?>" data-vehicle_id="<?php echo $invoice->customer_car_id; ?>" data-target="#addNewCar" class="add_recommended_product">
                                                                    <i class="fa fa-plus fa-margin" aria-hidden="true"></i> <?php _trans("lable853"); ?>
                                                                </a>
                                                            </li>
                                                            <?php } ?>
                                                            <li>
                                                                <a href="javascript:void(0)" data-toggle="modal" data-model_from="I" data-invoice_id="<?php echo $invoice->invoice_id;?>" data-customer_id="<?php echo $invoice->customer_id; ?>" data-vehicle_id="<?php echo $invoice->customer_car_id; ?>" data-target="#addNewCar" class="add_recommended_service">
                                                                    <i class="fa fa-plus fa-margin" aria-hidden="true"></i> <?php _trans("lable395"); ?>
                                                                </a>
                                                            </li>
                                                            <?php if($this->session->userdata('invoice_E') == 1){ ?>
                                                                <li>
                                                                    <a href="javascript:void(0)" onclick="sendmail(<?php echo $invoice->invoice_id; ?>)">
                                                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('lable375'); ?>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            <li>
                                                                <a target="_blank" href="<?php echo site_url('mech_invoices/generate_pdf/' . $invoice->invoice_id); ?>">
                                                                    <i class="fa fa-print fa-margin" aria-hidden="true"></i></i> <?php _trans('lable141'); ?>
                                                                </a>
                                                            </li>
                                                            <?php if($this->session->userdata('user_type') == 3){ ?>
                                                            <li>
                                                                <a href="javascript:void(0)" onclick="remove_entity(<?php echo $invoice->invoice_id; ?>,'mech_invoices', 'invoice','<?= $this->security->get_csrf_hash() ?>')">
                                                                    <i class="fa fa-edit fa-times"></i> <?php _trans('lable47'); ?>
                                                                </a>
                                                            </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $i++; } } else { echo '<tr><td colspan="8" class="text-center" > No data found </td></tr>'; } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right paddingTop20px">
                                <a href="<?php echo site_url('mech_invoices');?>" target="_blank">See More</a>
                            </div>
                            <?php }else { ?>
                            <section class="box-typical box-typical-dashboard panel panel-default scrollable" style="margin-bottom: 0px">
                                <div class="box-typical-body panel-body">
                                    <table class="tbl-typical display table datatable table-bordered" cellspacing="0" width="100%" style="margin-top:0px ! important;">
                                        <thead>
                                            <tr>
                                                <th><?php _trans('lable369'); ?></th>
                                                <th><?php _trans('lable29'); ?></th>
                                                <th class="text-center"><?php _trans('lable368'); ?></th>
                                                <th><?php _trans('lable370'); ?></th>
                                                <th><?php _trans('lable371'); ?></th>
                                                <th class="text-right"><?php _trans('lable372'); ?></th>
                                                <th class="text-right"><?php _trans('lable373'); ?></th>
                                                <th class="text_align_center"><?php _trans('lable22'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    
                                        <?php if(count($outstanding_invoice)>0){
                                            $i = 1;
                                            foreach ($outstanding_invoice as $invoice) {
                                                if(count($outstanding_invoice) >= 4)
                                                {
                                                if(count($outstanding_invoice) == $i || count($outstanding_invoice) == $i+1)
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
                                                <td data-original-title="<?php if($invoice->invoice_status == "D"){ echo "Draft"; }
                                                    elseif($invoice->invoice_status == "P"){ echo "Pending"; }
                                                    elseif($invoice->invoice_status == "PP"){ echo "Partial Paid"; }
                                                    elseif($invoice->invoice_status == "FP"){ echo "Paid"; } ?>" data-toggle="tooltip" class="textEllipsis">

                                                    <?php if($invoice->invoice_status == "D"){ echo "Draft"; }
                                                    elseif($invoice->invoice_status == "P"){ echo "Pending"; }
                                                    elseif($invoice->invoice_status == "PP"){ echo "Partial Paid"; }
                                                    elseif($invoice->invoice_status == "FP"){ echo "Paid"; } ?>
                                                </td>
                                                <td data-original-title="<?php _htmlsc($invoice->invoice_no); ?>" data-toggle="tooltip" class="textEllipsis"><a href="<?php echo site_url('spare_invoices/view/'.$invoice->invoice_id); ?>"><?php _htmlsc($invoice->invoice_no); ?></a></td>
                                                <td class="text-center textEllipsis" data-original-title="<?php _htmlsc($invoice->invoice_date?date_from_mysql($invoice->invoice_date):'-'); ?>" data-toggle="tooltip"><?php _htmlsc($invoice->invoice_date?date_from_mysql($invoice->invoice_date):'-'); ?></td>
                                                <td data-original-title="<?php _htmlsc($invoice->client_name.($invoice->client_contact_no?' ('.$invoice->client_contact_no.')':"")); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($invoice->client_name.($invoice->client_contact_no?' ('.$invoice->client_contact_no.')':"")); ?></td>
                                                <td data-original-title="<?php _htmlsc(($invoice->brand_name?$invoice->brand_name."-":" ")." ".($invoice->model_name?$invoice->model_name:"")." ".($invoice->variant_name?"-".$invoice->variant_name:" "));?>" data-toggle="tooltip" class="textEllipsis"><?php echo '<span class="car_reg_no">'.(($invoice->car_reg_no)?$invoice->car_reg_no:"").'</span>';?> <br> <?php _htmlsc(($invoice->brand_name?$invoice->brand_name."-":" ")." ".($invoice->model_name?$invoice->model_name:"")." ".($invoice->variant_name?"-".$invoice->variant_name:" ")); ?></td>
                                                <td class="text-right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($invoice->grand_total,$this->session->userdata('default_currency_digit')); ?>" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($invoice->grand_total,$this->session->userdata('default_currency_digit')); ?></td>
                                                <td class="text-right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($invoice->total_due_amount,$this->session->userdata('default_currency_digit')); ?>" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($invoice->total_due_amount,$this->session->userdata('default_currency_digit')); ?></td>
                                                <td class="text_align_center">

                                                    <div class="options btn-group <?php echo $dropup; ?>">
                                                        <a class="btn btn-default btn-sm dropdown-toggle"
                                                        data-toggle="dropdown" href="#">
                                                            <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                                        </a>
                                                        <ul class="optionTag dropdown-menu">
                                                            <?php if($this->session->userdata('user_type') == 3){ ?>
                                                            <li>
                                                                <?php if($invoice->invoice_status == "FP"){ ?>	
                                                                <?php } else { ?>
                                                                    <a href="<?php echo site_url('spare_invoices/create/' . $invoice->invoice_id); ?>">
                                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                                                    </a>
                                                                <?php } ?>
                                                            </li>
                                                            <?php } ?>
                                                            <?php if($invoice->invoice_status != "D" && $invoice->invoice_status != "FP"){ ?>
                                                            <li>
                                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#enter-payment" data-entity-id="<?php echo $invoice->invoice_id; ?>" data-grand-amt="<?php echo $invoice->grand_total; ?>" data-balance-amt="<?php echo $invoice->total_due_amount; ?>" data-customer-id="<?php echo $invoice->customer_id; ?>" data-entity-type='invoice' class="make-add-payment">
                                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable82'); ?>
                                                                </a>
                                                            </li>
                                                            <?php } ?>
                                                            <?php if($invoice->invoice_status != "D"){ ?>
                                                            <li>
                                                                <a href="javascript:void(0)" data-type-id="I" data-toggle="modal" data-target="#sendSms" data-invoice-id="<?php echo $invoice->invoice_id; ?>" class="send_sms">
                                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable903'); ?>
                                                                </a>
                                                            </li>
                                                            <?php } ?>
                                                            <li>
                                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#addNewCar" data-invoice-id="<?php echo $invoice->invoice_id; ?>" class="add_feedback">
                                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable374'); ?>
                                                                </a>
                                                            </li>
                                                            <?php if($is_product == "Y"){ ?>
                                                            <li>
                                                                <a href="javascript:void(0)" data-toggle="modal" data-model_from="I" data-invoice_id="<?php echo $invoice->invoice_id;?>" data-customer_id="<?php echo $invoice->customer_id; ?>" data-vehicle_id="<?php echo $invoice->customer_car_id; ?>" data-target="#addNewCar" class="add_recommended_product">
                                                                    <i class="fa fa-plus fa-margin" aria-hidden="true"></i> <?php _trans("lable853"); ?>
                                                                </a>
                                                            </li>
                                                            <?php } ?>
                                                            <?php if($this->session->userdata('invoice_E') == 1){ ?>
                                                                <li>
                                                                    <a href="javascript:void(0)" onclick="sendmail(<?php echo $invoice->invoice_id; ?>)">
                                                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('lable375'); ?>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            <li>
                                                                <a target="_blank" href="<?php echo site_url('spare_invoices/generate_pdf/' . $invoice->invoice_id); ?>">
                                                                    <i class="fa fa-print fa-margin" aria-hidden="true"></i></i> <?php _trans('lable141'); ?>
                                                                </a>
                                                            </li>
                                                            <?php if($this->session->userdata('user_type') == 3){ ?>
                                                            <li>
                                                                <a href="javascript:void(0)" onclick="remove_entity(<?php echo $invoice->invoice_id; ?>,'spare_invoices', 'spare_invoice','<?= $this->security->get_csrf_hash() ?>')">
                                                                    <i class="fa fa-edit fa-times"></i> <?php _trans('lable47'); ?>
                                                                </a>
                                                            </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $i++; } } else { echo '<tr><td colspan="8" class="text-center" > No data found </td></tr>'; } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right paddingTop20px">
                                <a href="<?php echo site_url('spare_invoices');?>" target="_blank">See More</a>
                            </div>
                            <?php } ?>
						</div>
                        <?php } } foreach($permission as $perlist){ if($perlist->module_name == "expense"){ ?>
						<div role="tabpanel" class="tab-pane fade " id="tabs-11-tab-1">
                            <section class="box-typical box-typical-dashboard panel panel-default scrollable" style="margin-bottom: 0px">
                                <div class="box-typical-body panel-body">
                                    <table class="tbl-typical display table datatable table-bordered" cellspacing="0" width="100%" style="margin-top:0px ! important;">
                                        <thead>
                                            <tr>
                                                <th><?php _trans('lable458'); ?></th>
                                                <th><?php _trans('lable454'); ?></th>
                                                <th><?php _trans('lable459'); ?></th>
                                                <th class="text_align_right"><?php _trans('lable332'); ?></th>
                                                <th class="text_align_center"><?php _trans('lable452'); ?></th>
                                                <th class="text_align_right"><?php _trans('lable460'); ?></th>
                                                <th class="text_align_right"><?php _trans('lable461'); ?></th>
                                                <th class="text_align_center"><?php _trans('lable22'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (count($outstanding_expense) > 0) {
                                                $i = 1;
                                                foreach ($outstanding_expense as $expense) { 
                                                    if(count($outstanding_expense) >= 4){
                                                    if(count($outstanding_expense) == $i || count($outstanding_expense) == $i+1)
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
                                                <td data-original-title="<?php if ($expense->payment_status == 1) {
                                                        echo 'Pending';
                                                    } elseif ($expense->payment_status == 2) {
                                                        echo 'Partial paid';
                                                    } elseif ($expense->payment_status == 3) {
                                                        echo 'Paid';
                                                    } elseif ($expense->payment_status == 4) {
                                                        echo 'Generated';
                                                    }elseif ($expense->payment_status == 5) {
                                                        echo 'Draft';
                                                    }?>" data-toggle="tooltip" class="textEllipsis">

                                                    <?php if ($expense->payment_status == 1) {
                                                        echo 'Pending';
                                                    } elseif ($expense->payment_status == 2) {
                                                        echo 'Partial paid';
                                                    } elseif ($expense->payment_status == 3) {
                                                        echo 'Paid';
                                                    }  elseif ($expense->payment_status == 4) {
                                                        echo 'Generated';
                                                    }elseif ($expense->payment_status == 5) {
                                                        echo 'Draft';
                                                    }?>
                                                </td>
                                                <td data-original-title="<?php _htmlsc($expense->expense_category_name); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($expense->expense_category_name); ?></td>
                                                <td data-original-title="<?php _htmlsc($expense->expense_no); ?>" data-toggle="tooltip" class="textEllipsis"><a href="<?php echo site_url('mech_expense/view/'.$expense->expense_id); ?>"><?php echo $expense->expense_no; ?></a></td>
                                                <td class="text_align_right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($expense->grand_total,$this->session->userdata('default_currency_digit')); ?>" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($expense->grand_total,$this->session->userdata('default_currency_digit')); ?></td>
                                                <td class="text_align_center" data-original-title="<?php _htmlsc($expense->expense_date?date_from_mysql($expense->expense_date):'-'); ?>" data-toggle="tooltip" class="textEllipsis"><?php echo $expense->expense_date?date_from_mysql($expense->expense_date):'-'; ?></td>
                                                <td class="text_align_right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($expense->total_paid_amount,$this->session->userdata('default_currency_digit'));?>" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($expense->total_paid_amount,$this->session->userdata('default_currency_digit')); ?></td>
                                                <td class="text_align_right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($expense->total_due_amount,$this->session->userdata('default_currency_digit'));?>" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($expense->total_due_amount,$this->session->userdata('default_currency_digit')); ?></td>
                                                <td class="text_align_center">
                                                    <div class="options btn-group <?php echo $dropup; ?>">
                                                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                                                            <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                                        </a>
                                                        <ul class="optionTag dropdown-menu">
                                                            <li>
                                                                <a href="<?php echo site_url('mech_expense/create/'.$expense->expense_id); ?>">
                                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                                                </a>
                                                            </li>
                                                            
                                                            <?php if($expense->payment_status != 3 && $expense->payment_status != 5){ ?>
                                                            <li>
                                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#enter-payment" data-entity-id="<?php echo $expense->expense_id; ?>" data-grand-amt="<?php echo $expense->grand_total; ?>" data-balance-amt="<?php echo $expense->total_due_amount; ?>" data-customer-id="<?php echo $expense->action_emp_id; ?>" data-entity-type='expense' class="make-add-payment">
                                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable82'); ?>
                                                                </a>
                                                            </li>
                                                            <?php } ?>
                                                            <li>
                                                                <a href="javascript:void(0)" onclick="remove_entity(<?php echo $expense->expense_id; ?>,'mech_expense', 'expense','<?= $this->security->get_csrf_hash(); ?>')">
                                                                    <i class="fa fa-edit fa-times"></i> <?php _trans('lable47'); ?>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $i++; } } else { echo '<tr><td colspan="7" class="text-center" > No data found </td></tr>'; } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right paddingTop20px">
                                <a href="<?php echo site_url('mech_expense');?>" target="_blank">See More</a>
                            </div>
						</div>
                        <?php }} foreach($permission as $perlist){ if($perlist->module_name == "purchase"){ ?>
                        <div role="tabpanel" class="tab-pane fade" id="tabs-12-tab-1">
                            <section class="box-typical box-typical-dashboard panel panel-default scrollable" style="margin-bottom: 0px">
                                <div class="box-typical-body panel-body">
                                    <table class="tbl-typical display table datatable table-bordered" cellspacing="0" width="100%" style="margin-top:0px ! important;">
                                        <thead>
                                            <tr>
                                                <th><?php _trans('lable128'); ?></th>
                                                <th><?php _trans('lable126'); ?>.</th>
                                                <th><?php _trans('lable34'); ?>.</th>
                                                <th><?php _trans('lable107'); ?></th>
                                                <th class="text_align_right"><?php _trans('lable32'); ?></th>
                                                <th class="text_align_center"><?php _trans('lable386'); ?></th>
                                                <th class="text_align_center"><?php _trans('lable127'); ?></th>
                                                <th class="text_align_center"><?php _trans('lable22'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(count($outstanding_purchase)>0){
                                            $i = 1;
                                            foreach ($outstanding_purchase as $purchase) { 
                                                if(count($outstanding_purchase) >= 4){
                                                    if(count($outstanding_purchase) == $i || count($outstanding_purchase) == $i+1)
                                                    {
                                                        $dropup = "dropup";
                                                    }
                                                    else
                                                    {
                                                        $dropup = "";
                                                    }
                                                }?>
                                            <tr>
                                                <td data-original-title="<?php if($purchase->purchase_status == "D"){ echo "Draft"; }elseif($purchase->purchase_status == "G"){ echo "Generated"; }
                                                elseif($purchase->purchase_status == "PP"){ echo "Partial paid"; }elseif($purchase->purchase_status == "FP"){ echo "Paid"; } ?>" data-toggle="tooltip" class="textEllipsis"><?php if($purchase->purchase_status == "D"){ echo "Draft"; }elseif($purchase->purchase_status == "G"){ echo "Generated"; }
                                                elseif($purchase->purchase_status == "PP"){ echo "Partial paid"; }elseif($purchase->purchase_status == "FP"){ echo "Paid"; } ?></td>
                                                <td data-original-title="<?php _htmlsc($purchase->purchase_no); ?>" data-toggle="tooltip" class="textEllipsis"><a href="<?php echo site_url('mech_purchase/view/' . $purchase->purchase_id); ?>"><?php _htmlsc($purchase->purchase_no); ?></a></td>
                                                <td data-original-title="<?php _htmlsc($purchase->purchase_number?$purchase->purchase_number:NULL); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($purchase->purchase_number?$purchase->purchase_number:NULL); ?></td>
                                                <td data-original-title="<?php _htmlsc($purchase->supplier_name?$purchase->supplier_name:NULL); ?>" data-toggle="tooltip" class="textEllipsis"><?php _htmlsc($purchase->supplier_name?$purchase->supplier_name:NULL); ?></td>
                                                <td class="text-right" data-original-title="<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($purchase->total_due_amount,$this->session->userdata('default_currency_digit'));?>" data-toggle="tooltip" class="textEllipsis"><?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;<?php echo format_money($purchase->total_due_amount,$this->session->userdata('default_currency_digit')); ?></td>
                                                <td class="text-center" data-original-title="<?php _htmlsc($purchase->purchase_date_created?date_from_mysql($purchase->purchase_date_created):""); ?>" data-toggle="tooltip" class="textEllipsis"><?php echo ($purchase->purchase_date_created?date_from_mysql($purchase->purchase_date_created):""); ?></td>
                                                <td class="text-center" data-original-title="<?php _htmlsc($purchase->purchase_date_due?date_from_mysql($purchase->purchase_date_due):""); ?>" data-toggle="tooltip" class="textEllipsis"><?php echo ($purchase->purchase_date_due?date_from_mysql($purchase->purchase_date_due):""); ?></td>
                                                
                                                <td class="text_align_center">
                                                    <div class="options btn-group <?php echo $dropup; ?>">
                                                        <a class="btn btn-default btn-sm dropdown-toggle"
                                                        data-toggle="dropdown" href="#">
                                                            <i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
                                                        </a>
                                                        <ul class="optionTag dropdown-menu">
                                                            <li>
                                                                <a href="<?php echo site_url('mech_purchase/create/' . $purchase->purchase_id); ?>">
                                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
                                                                </a>
                                                            </li>
                                                            <?php if($purchase->purchase_status != "D" && $purchase->purchase_status != "FP"){ ?>
                                                            <li>
                                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#enter-payment" data-entity-id="<?php echo $purchase->purchase_id; ?>" data-grand-amt="<?php echo $purchase->grand_total; ?>" data-balance-amt="<?php echo $purchase->total_due_amount; ?>" data-customer-id="<?php echo $purchase->supplier_id; ?>" data-entity-type='purchase' class="make-add-payment">
                                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable82'); ?>
                                                                </a>
                                                            </li>
                                                            <?php } ?>
                                                            <li>
                                                                <a target="_blank" href="<?php echo site_url('mech_purchase/generate_pdf/' . $purchase->purchase_id); ?>">
                                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('lable141'); ?>
                                                                </a>
                                                            </li>
                                                            <?php if($purchase->purchase_status != 'PP' && $purchase->purchase_status != 'FP') {?>
                                                            <li>
                                                                <a href="javascript:void(0)" onclick="remove_entity(<?php echo $purchase->purchase_id; ?>,'mech_purchase', 'purchase','<?= $this->security->get_csrf_hash() ?>')">
                                                                    <i class="fa fa-edit fa-times"></i> <?php _trans('lable47'); ?>
                                                                </a>
                                                            </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $i++; } } else { echo '<tr><td colspan="8" class="text-center" > No data found </td></tr>'; } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </section>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right paddingTop20px">
                                <a href="<?php echo site_url('mech_purchase');?>" target="_blank" >See More</a>
                            </div>
						</div>
                        <?php }} ?>
					</div>
				</section>
			</div>
		</div>
    </div>
</div>
<script type="text/javascript">
    function daymonth(id){
        $.post("<?php echo site_url('dashboard/ajax/getdayMonthData'); ?>", {
			id : id,
			_mm_csrf: $('#_mm_csrf').val()
		},function (data) {
            var response = JSON.parse(data);
			if (response.success == 1) {
                $(".activegroupBtn").removeClass('activegroupBtn');
                if(id == "D"){
                    $("#day").addClass('activegroupBtn');
                    $("#showDateNumber").empty().append(response.currentDate);
                }else if(id == "M"){
                    $("#month").addClass('activegroupBtn');
                    $("#showDateNumber").empty().append("( "+response.monthStartDate+" - "+response.monthEndDate+" )");
                }else if(id == "W"){
                    $("#week").addClass('activegroupBtn');
                    $("#showDateNumber").empty().append("( "+response.weekStart+" - "+response.weekEnd+" )");
                }else{
                    $("#total").addClass('activegroupBtn');
                    $("#showDateNumber").empty().append('');
                }
                $("#total_job_completeds").empty().append(response.total_job_completeds?response.total_job_completeds:0);
                $("#total_job_openings").empty().append(response.total_job_openings?response.total_job_openings:0);
                $("#total_working_progress").empty().append(response.total_working_progress?response.total_working_progress:0);
                $("#total_onhold").empty().append(response.total_onhold?response.total_onhold:0);
                $("#total_income").empty().append("<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;"+format_money((response.total_income?response.total_income:0),<?php echo $this->session->userdata('default_currency_digit');?>));
                $("#total_purchase").empty().append("<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;"+format_money((response.total_purchase?response.total_purchase:0),'<?php echo $this->session->userdata('default_currency_digit');?>'));
                $("#total_expenese").empty().append("<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;"+format_money((response.total_expenese?response.total_expenese:0),'<?php echo $this->session->userdata('default_currency_digit');?>'));
                $("#total_expenese_due").empty().append("<?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;"+format_money((response.total_income_due?response.total_income_due:0),'<?php echo $this->session->userdata('default_currency_digit');?>')+" / <?php echo $this->mdl_settings->currencychanger($this->session->userdata('default_currency_code')); ?>&nbsp;"+format_money((response.total_expenese_due?response.total_expenese_due:0),'<?php echo $this->session->userdata('default_currency_digit');?>'));
			}
        });
    }
</script>
