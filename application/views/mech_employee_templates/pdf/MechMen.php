<!DOCTYPE html>
<html lang="<?php _trans('cldr'); ?>">
<head>
    <meta charset="utf-8">
    <title><?php _trans('lable456'); ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mechmen_pdf/css/templates.css">
    <style>
        @page {
            margin-top: 3.5cm;
            margin-bottom: 1cm;
            margin-left: 1cm;
            margin-right: 1cm;
            margin-header: 0mm;
            margin-footer: 0mm;
            footer: html_myHTMLFooter;
            header: html_myHTMLHeader;
        }
        .customer-details tr td {
			width: 33.3px;
			vertical-align: -webkit-baseline-middle;
        }
    </style>
</head>
<body>
    <htmlpageheader name="myHTMLHeader">
        <table width="100%">
            <tr width="100%">
                <td style="width:50%;text-align: left;padding: 10px 10px;">
                    <div class="company_logo">
                        <?php $company_details = $this->mdl_workshop_branch->get_company_branch_details($employee_details->branch_id);
						if ($company_details->workshop_logo) { ?>
                        <img class="hidden-md-down" src="<?php echo base_url(); ?>uploads/workshop_logo/<?php echo $company_details->workshop_logo; ?>" width="150" height="150" alt="<?php echo $company_details->workshop_name; ?>">
                        <?php } ?>
                    </div>
                </td>
                <td style="width:50%;text-align: right; padding: 10px 10px;">
                    <div>
                        <?php echo $company_details->display_board_name; ?>
                        <?php if ($company_details->branch_street) {
													echo $company_details->branch_street;
												}
												if ($company_details->area_name) {
													echo ", <br>" . $company_details->area_name;
												}
												if ($company_details->state_name) {
													echo ", <br>" . $company_details->state_name;
												}
												if ($company_details->branch_pincode) {
													echo " - " . $company_details->branch_pincode;
												}
												if ($company_details->branch_country) {
                                                    echo ' - '.$company_details->name;
                                                }
												?>
                        <?php if ($company_details->branch_contact_no) {
													echo '<br><span>' . $company_details->branch_contact_no . '</span>';
												} ?>
                        <?php if ($company_details->branch_email_id) {
													echo '<br><span>' . $company_details->branch_email_id . '</span>';
												} ?>
                        <?php if ($company_details->branch_gstin) {
													echo '<br><span>' . $company_details->branch_gstin . '</span>';
												} ?>
                    </div>
                </td>
            </tr>
        </table>
        <hr>
    </htmlpageheader>
    <htmlpagefooter name="myHTMLFooter">
        <div class="footer_bg"><?php _trans('lable1045'); ?></div>
    </htmlpagefooter>
    <main style="padding:20px;">
        <div style="width:100%;float:left;padding-top:10px;">
            <div style="width:100%;float:left;padding:5px; background: #F5F5F5;">
                <h4 style="padding:0px; margin: 0;"><?php _trans('lable1057'); ?>:</h4>
            </div>
            <table width="100%" class="customer-details" style="width:100%;float:left;padding-top:10px;">
                <thead>
                    <tr>
                        <td align="left">
                            <?php if ($employee_details->employee_name) { echo '<span>'.$employee_details->employee_name.'</span>'; } ?>
                        </td>
                        <td align="right">
                                <?php if ($employee_details->mobile_no) { echo '<span> Mobile : ' . $employee_details->mobile_no . '</span>'; } ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left"> 
                            <?php if ($employee_details->employee_number) { echo '<span> Employee ID : '.$employee_details->employee_number.'</span>'; } ?>
                        </td>
                        <td align="right">
                            <?php if ($employee_details->email_id) { echo '<span> Email Id : ' . $employee_details->email_id . '</span>'; } ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left">
                            <?php if ($employee_details->display_board_name) { echo '<span> Branch : ' . $employee_details->display_board_name . '</span>'; } ?>
                        </td>
                        <?php if ($employee_details->shift){ 
                        if($employee_details->shift == "D"){ 
                            echo '<td align="right"><span> Shift : Day Shift </span></td>'; 
                        }else if($employee_details->shift == "N"){ 
                            echo '<td align="right"><span> Shift : Day Shift </span></td>'; 
                        } } ?>
                    </tr>
                    <tr>
                        <td align="left">
                            <?php if ($employee_details->employee_street_1) { echo '<span>' . $employee_details->employee_street_1 . '</span>'; } ?>
                        </td>
                        <td align="right">
                            <?php if ($employee_details->role_name) { echo '<span> Role : ' . $employee_details->role_name . '</span>'; } ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left">
                            <?php if ($employee_details->employee_street_2) { echo '<span>' . $employee_details->employee_street_2 . '</span>'; } ?>
                        </td>
                        <td align="right">
                            <?php if ($employee_details->basic_salary) { echo '<span> Basic pay : ' . $employee_details->basic_salary . '</span>'; } ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left">
                            <?php if ($employee_details->cty_name) { echo '<span>' . $employee_details->cty_name . '</span>'; } ?>
                            <?php if ($employee_details->st_name) { echo ',<span>' . $employee_details->st_name . '</span>'; } ?>
                        </td>
                        <td align="right">
                            <?php if ($employee_details->date_of_joining) { echo '<span> Date of Joining : ' . date_from_mysql($employee_details->date_of_joining) . '</span>'; } ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left">
                            <?php if ($employee_details->country_name) { echo '<span>' . $employee_details->country_name . '</span>'; } ?>
                            <?php if ($employee_details->employee_pincode) { echo ' - <span>' . $employee_details->employee_pincode . '</span>'; } ?>
                        </td>
                    </tr>
                    <tr height="10">
                        <td>
                            <div style="border-top: 1px solid #d3d3d3;"></div>
                        </td>
                    </tr>
                </thead>
                </table>
                <div style="width:100%;float:left;padding:5px; background: #F5F5F5;">
                    <h4 style="padding:0px; margin: 0;"><?php _trans('lable1058'); ?>:</h4>
                </div>
               
                <table>
                <thead>
                    <br>
                    <tr>
                        <td>
                            <?php if ($employee_details->date_of_birth != "" && $employee_details->date_of_birth != "0000-00-00") { echo '<br><span> Date of Birth : ' . date_from_mysql($employee_details->date_of_birth) . '</span>'; } ?>
                        </td>
                    </tr>
                    <?php if(count($employee_custom_list) > 0){
                        foreach($employee_custom_list as $employeeCustomList){ 
                            if($employeeCustomList->column_from != "0000-00-00"){ ?>
                            <?php if ($employeeCustomList->column_name) { 
                                echo '<tr><td><span>'.$employeeCustomList->column_name.': '.$employeeCustomList->column_value.'</span>
                                </td></tr><tr><td><span> '.$employeeCustomList->column_name.': Valid From :'.date_from_mysql($employeeCustomList->column_from) .'</span>
                                </td></tr><tr><td><span> '.$employeeCustomList->column_name.': Valid To :'.date_from_mysql($employeeCustomList->column_to) .'</span></td></tr>'; } ?>
                    <?php } } }?>
                    <tr>
                        <td>
                            <?php if ($employee_details->blood_group) {
                            if($employee_details->blood_group == 1){
                                echo '<span> Blood Group : A RhD positive (A+)</span>';
                            }else if($employee_details->blood_group == 1){
                                echo '<span> Blood Group : A RhD negative (A-)</span>';
                            }else if($employee_details->blood_group == 2){
                                echo '<span> Blood Group : B RhD positive (B+)</span>';
                            }else if($employee_details->blood_group == 3){
                                echo '<span> Blood Group : B RhD negative (B-)</span>';
                            }else if($employee_details->blood_group == 4){
                                echo '<span> Blood Group : O RhD positive (O+)</span>';
                            }else if($employee_details->blood_group == 5){
                                echo '<span> Blood Group : O RhD negative (O-)</span>';
                            }else if($employee_details->blood_group == 6){
                                echo '<span> Blood Group : AB RhD positive (AB+)</span>';
                            }elseif($employee_details->blood_group == 8){
                                echo '<span> Blood Group : AB RhD negative (AB-)</span>';
                            } } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php if($employee_details->blood_group){
                                if($employee_details->physical_challange == 1){
                                    echo '<span> Physical Challange : Yes</span>'; 
                                }else if($employee_details->physical_challange == 2){
                                    echo '<span> Physical Challange : No</span>'; 
                                } 
                            } ?>
                        </td>
                    </tr>
                </thead>
            </table>
        </div>
        <div style="width:100%;float:left;padding-top:10px;">
        <?php if(count($employee_document_list)>0) { ?>
            <div style="width:100%;float:left;padding:5px; background: #F5F5F5;">
                <h4 style="padding:0px; margin: 0;"><?php _trans('lable1056'); ?></h4>
            </div>
            <table style="width:100%;float: left;padding-top:10px;">
                <thead>
                    <tr>
                        <th><?php _trans('lable182'); ?></th>
                        <th><?php _trans('lable179'); ?></th>
                        <th align="center" class="text-center"><?php _trans('lable183'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($employee_document_list as $documentList){ ?>
                    <tr>
                        <td align="center"><span><?php echo $documentList->document_name; ?></span></td>
                        <td align="center"><span><?php echo $documentList->file_name_original; ?></span></td>
                        <td align="center">
                        <span style="cursor: pointer">
                            <a href="<?php echo base_url()."uploads/customer_files/".$documentList->file_name_new?>" target="_blank" >
                                <img src="<?php echo base_url()."uploads/customer_files/".$documentList->file_name_new?>" width="50" height="50">
                            </a>
                        </span></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
        </div>
        <div style="width:100%;float:left;padding-top:10px;">
            <?php if(count($employee_experience_list) > 0) { $i = 1;?>
            <div style="width:100%;float:left;padding:5px; background: #F5F5F5;">
                <h4 style="padding:0px; margin: 0;"><?php _trans('lable178'); ?></h4>
            </div>
            <?php foreach ($employee_experience_list as $experience) { ?>
            <div style="width:100%;float:left;padding-top:10px;">
                <h4 style="padding:0px; margin: 0;"><?php _trans('lable145'); ?> - <?php _htmlsc($i); ?></h4>
                <table cellspacing="0" width="50%" style="width:100%;float:left;padding-left:20px;">
                    <tbody>
                        <tr>
                            <td align="left"><span><?php _trans('lable135'); ?></span> - <span><?php echo $experience->role_name; ?><span></td>
                        </tr>
                        <tr>
                            <td align="left"><span><?php _trans('lable174'); ?></span> - <span><?php echo $experience->company_name; ?></span></td>
                        </tr>
                        <tr>
                            <td align="left"><span><?php _trans('lable175'); ?> - <?php echo $experience->from; ?></span><span><?php _trans(' To '); ?> - <?php echo $experience->to; ?></span></td>
                        </tr>
                        <tr>
                            <td align="left"><span><?php _trans('lable61'); ?></span><span> - <?php echo $experience->address; ?></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php ++$i; } } ?>
        </div>
        <div style="width:100%;float:left;padding-top:10px;">
            <?php if(count($employee_skill_list) > 0) { $i = 1;?>
            <div style="width:100%;float:left;padding:5px; background: #F5F5F5;">
                <h4 style="padding:0px; margin: 0;"><?php _trans('lable1055'); ?></h4>
            </div>
            <table cellspacing="0" width="100%" style="width:100%;float:left;">
                <tbody>
                    <tr>
                        <td>
                            <ul>
				                <?php foreach ($employee_skill_list as $skill_list) { ?>
                                <li><?php _htmlsc($skill_list->skill_name); ?></li>
            	                <?php ++$i; } ?>
                            </ul>
                        </td>
                    </tr>
				</tbody>
            </table>
            <?php } ?>
        </div>
        <?php if(count($employeebank)>0){ ?>
        <div style="width:100%;float:left;padding-top:10px;">
            <div style="width:100%;float: left;padding-top:10px;">
                <div style="padding:5px; background: #F5F5F5;">
                    <h4 style="padding:0px; margin: 0;"><?php _trans('lable94'); ?></h4>
                </div>
                <table>
                <?php foreach($employeebank as $bank_dtls){ ?>
                    <tr>
                        <td><?php _trans('lable401'); ?> :</td>
                        <td><?php echo $bank_dtls->account_holder_name; ?></td>
                    </tr>
                    <tr>
                        <td><?php _trans('lable98'); ?> :</td>
                        <td><?php echo $bank_dtls->account_number; ?></td>
                    </tr>
                    <tr>
                        <td><?php _trans('lable99'); ?> :</td>
                        <td><?php echo $bank_dtls->bank_name; ?></td>
                    </tr>
                    <tr>
                        <td><?php _trans('lable1047'); ?> :</td>
                        <td><?php echo $bank_dtls->bank_ifsc_Code; ?></td>
                    </tr>
                    <tr>
                        <td><?php _trans('lable95'); ?> :</td>
                        <td><?php echo $bank_dtls->bank_branch; ?></td>
                    </tr>
                <?php } ?>
                </table>
            </div>
        </div>
        <?php } ?>
    </main>
	<?php //exit(); ?>
</body>
</html> 