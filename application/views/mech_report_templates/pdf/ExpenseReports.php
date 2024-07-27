<!DOCTYPE html>
<html lang="<?php _trans('cldr'); ?>">
<head>
    <meta charset="utf-8">
    <title><?php _trans('menu13'); ?></title>
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
            padding-bottom: 8px;
            height: 50px;
            vertical-align: middle;
            border-top-color: #d8e2e7;
            padding: 11px 10px 10px;
            border: 1px solid #eceeef;
        }
        .customer-details tr th {
            font-weight: 700;
            vertical-align: middle;
            border-top-color: #d8e2e7;
            padding: 11px 10px 10px;
            border: 1px solid #eceeef;
            text-align: left;
        }
    </style>
</head>
<body>
    <htmlpageheader name="myHTMLHeader">
        <table width="100%">
            <tr width="100%">
                <td style="width:50%;text-align: left;padding: 10px 10px;">
                    <div class="company_logo">
                        <?php $company_details = $this->mdl_workshop_branch->get_company_branch_details();
												if ($company_details->workshop_logo) { ?>
                        <img class="hidden-md-down" src="<?php echo base_url(); ?>uploads/workshop_logo/<?php echo $company_details->workshop_logo; ?>" width="150" height="150" alt="<?php echo $company_details->workshop_name; ?>">
                        <?php 
											} ?>
                    </div>
                </td>
                <td style="width:50%;text-align: right; padding: 10px 10px;">
                    <div>
                        <?php echo $company_details->workshop_name; ?>
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
							if ($company_details->branch_country) { echo $company_details->name; } ?>
                        <?php if ($company_details->branch_contact_no) { echo '<br><span>' . $company_details->branch_contact_no . '</span>'; } ?>
                        <?php if ($company_details->branch_email_id) { echo '<br><span>' . $company_details->branch_email_id . '</span>'; } ?>
                        <?php if ($company_details->branch_gstin) { echo '<br><span>' . $company_details->branch_gstin . '</span>'; } ?>
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
        <div style="width:100%;float:left;padding:5px;">
            <h4 style="padding:0px; margin: 0;font-size:18px;"><?php echo $title; ?></h4>
        </div>
        <div style="width:100%;float:left;padding:5px;">
            <h4 style="padding:0px; margin: 0;font-size:18px;"><?php _trans('lable1044'); ?> <?php echo $from_date; ?> <?php _trans('lable176'); ?> <?php echo $to_date;?></h4>
        </div>
        <?php foreach($results as $value){ ?>
            <br><h6><?php echo $value->display_board_name;?></h6>
            <table class="customer-details" style="font-size:.9375rem;margin-bottom: 0;background: #fff;table-layout:fixed;border: 1px solid #eceeef;width: 100%;max-width: 100%;border-collapse: collapse;border-spacing: 0;" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th class="text_align_center"><?php _trans('lable884'); ?></th>
                        <th class="text_align_center"><?php _trans('lable647'); ?></th>
                        <th class="text_align_center"><?php _trans('lable151'); ?></th>
                        <th class="text_align_center"><?php _trans('lable114'); ?></th>
                    </tr>
                </thead>
                <?php if(count($value->expense_list) > 0){
                $overall_grand_total = 0; ?>
                <tbody>
                    <?php foreach ($value->expense_list as $result){
                    $overall_grand_total += $result->grand_total;?>
                    <tr>
                        <td class="text_align_center"><?php echo $result->expense_date; ?></td>
                        <td class="text_align_center"><?php echo $result->expense_category_name; ?></td>
                        <td class="text_align_center"><?php if($result->shift == 1){ echo "Regular Shift";}else if($result->shift == 2){ echo "Day Shift";}else if($result->shift == 3){ echo "Night Shift";} ?></td>
                        <td class="text_align_center"><?php echo $result->grand_total; ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td class="text_align_right" colspan="3"><strong><?php _trans('lable625'); ?></strong></td>
                        <td class="text_align_center"><strong><?php echo $overall_grand_total;?></strong></td>
                    </tr>
                </tbody>
                <?php } else {?>
                <tbody>
                    <tr>
                        <td class="text_align_center" colspan="4"><strong><?php _trans('lable1046'); ?></strong></td>
                    </tr>
                </tbody>
                <?php } ?>
            </table>
        <?php } ?> 

        <br><br><h4><?php _trans('lable646'); ?></h4>
        <?php $overall_branch_grand_total = 0;
        foreach($results as $value){
            if(count($value->expense_list) > 0){
            $overall_grand_total = 0; ?>
            <table class="customer-details" style="font-size:.9375rem;margin-bottom: 0;background: #fff;table-layout:fixed;border: 1px solid #eceeef;width: 100%;max-width: 100%;border-collapse: collapse;border-spacing: 0;" cellspacing="0" width="100%">
                <tbody>
                    <?php foreach ($value->expense_list as $result){ 
                        $overall_branch_grand_total += $result->grand_total;
                        $overall_grand_total += $result->grand_total;?>
                    <?php } ?>
                    <tr>
                        <td class="text_align_right"><strong><?php echo $value->display_board_name; ?></strong></td>
                        <td class="text_align_center"><strong><?php echo $overall_grand_total;?></strong></td>
                    </tr>
                </tbody>
            </table>
            <?php } } ?>
            <table class="customer-details" style="font-size:.9375rem;margin-bottom: 0;background: #fff;table-layout:fixed;border: 1px solid #eceeef;width: 100%;max-width: 100%;border-collapse: collapse;border-spacing: 0;" cellspacing="0" width="100%">
                <tbody>
                    <?php foreach ($value->expense_list as $result){ 
                        $overall_branch_grand_total += $result->grand_total;
                        $overall_grand_total += $result->grand_total;?>
                    <?php } ?>
                    <tr>
                        <td class="text_align_right"><strong><?php _trans('lable646'); ?></strong></td>
                        <td class="text_align_center"><strong><?php echo $overall_branch_grand_total;?></strong></td>
                    </tr>
                </tbody>
            </table>
    </main>
	<?php //exit(); ?>
</body>
</html> 