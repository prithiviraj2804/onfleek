<!DOCTYPE html>
<html lang="<?php _trans('cldr'); ?>">
<head>
    <meta charset="utf-8">
    <title><?php _trans('lable119'); ?></title>
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
                        <?php } ?>
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
												if ($company_details->branch_country) {
													echo $company_details->name;
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
            <div style="width:100%;float:left;padding:5px;">
                <h4 style="padding:0px; margin: 0;font-size:18px;"><?php echo $title; ?></h4>
            </div>
            <div style="width:100%;float:left;padding:5px;">
                <h4 style="padding:0px; margin: 0;font-size:18px;"><?php _trans('lable1044'); ?> <?php echo $from_date; ?> <?php _trans('lable176'); ?> <?php echo $to_date;?></h4>
            </div>
            <div style="width:100%;float:left;padding-top:10px;text-align:center;">
            <?php if(count($results) > 0){
            foreach ($results as $result){ ?>
            <div style="width: 50%;float: left;text-align: left;">
                <div style="padding: 5px;"><h6 style="font-size:16px;"><strong><?php echo $result->display_board_name; ?></strong></h6></div>
                <div style="width:100%;float: left;padding:10px;">
                    <table class="customer-details" style="font-size:.9375rem;margin-bottom: 0;background: #fff;table-layout:fixed;border: 1px solid #eceeef;width: 100%;max-width: 100%;border-collapse: collapse;border-spacing: 0;padding:5px;" cellspacing="0" width="100%">
                        <tbody>
                            <tr>
                                <th><?php _trans('lable661'); ?></th>
                                <td style="text-align:right;"><?php echo ($result->total_vehicle?$result->total_vehicle:0); ?></td>
                            </tr>
                            <tr>
                                <th><?php _trans('lable662'); ?></th>
                                <td style="text-align:right;"><?php echo ($result->grand_total?$result->grand_total:0); ?></td>
                            </tr>
                            <tr>
                                <th><?php _trans('lable663'); ?></th>
                                <td style="text-align:right;"><?php echo ($result->expense_grand_total?$result->expense_grand_total:0); ?></td>
                            </tr>
                            <tr>
                                <th><strong><?php _trans('lable114'); ?></strong></th>
                                <td style="text-align:right;"><strong><?php echo (($result->grand_total?$result->grand_total:0) - ($result->expense_grand_total?$result->expense_grand_total:0)); ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php } } else{
                echo '<div style="width: 100%;float: left;text-align: center;">No data Found</div>';
            }?>
            <br>
            <br>
            <div style="width:100%;float: left;">
                <div style="padding: 5px;"><h6 style="font-size:16px;"><strong><?php echo "Consolidated Summary"; ?></strong></h6></div>
                <div style="width:50%;float: none;margin: 0 auto;">
                    <table class="customer-details display table table-bordered" style="font-size:.9375rem;margin-bottom: 0;background: #fff;table-layout:fixed;border: 1px solid #eceeef;width: 100%;max-width: 100%;border-collapse: collapse;border-spacing: 0;" cellspacing="0" width="100%">
                        <tbody>
                            <?php 
                            $overall_incomeee = 0;
                            $overall_expenseee = 0;
                            foreach($results as $result) {
                                $overall_incomeee += $result->grand_total;
                                $overall_expenseee += $result->expense_grand_total;
                            } ?>
                            <tr class="income pointer">
                                <td><?php echo "Overall Income"; ?></td>
                                <td style="text-align:right;"><?php echo "".($overall_incomeee).""; ?></td>
                            </tr>
                            <tr class="expense pointer">
                                <td><?php echo "Overall Expense"; ?></td>
                                <td style="text-align:right;"><?php echo "".($overall_expenseee).""; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo "<strong> Overall Total</strong>"; ?></td>
                                <td style="text-align:right;"><?php echo "<strong>".($overall_incomeee - $overall_expenseee)."</strong>"; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div> 
        </div>
    </main>
	<?php //exit(); ?>
</body>
</html> 