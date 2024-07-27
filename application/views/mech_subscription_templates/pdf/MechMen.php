<!DOCTYPE html>
<html lang="<?php _trans('cldr'); ?>">
<head>
    <meta charset="utf-8">
    <title><?php _trans('lable1141'); ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mechmen_pdf/css/templates.css">
    <style>
        @page {
            margin-top: 3.5cm;
            margin-bottom: 1cm;
            margin-left: 1cm;
            margin-right: 1cm;
            margin-header: 5mm;
            margin-footer: 5mm;
            footer: html_myHTMLFooter;
            header: html_myHTMLHeader;
        }
        .customer-details tr td {
            width: 33.3px;
            vertical-align: top;
        }
    </style>
</head>
<body>
    <htmlpageheader name="myHTMLHeader">
        <table width="100%">
            <tr width="100%" align="center">
                <td width="100%" colspan="2" style="width:100%;text-align: center;font-size:24px;float:left;"><?php _trans('lable1054'); ?></td>
            </tr>
            <tr width="100%">
                <td style="width:50%;text-align: left;padding: 10px 10px;">
                    <div class="company_logo">
                        <img class="hidden-md-down" src="<?php echo base_url(); ?>assets/mp_backend/img/mechtoolz-logo.png" width="150" height="100" alt="<?php echo "Mechtoolz"; ?>">
                    </div>
                </td>
                <td style="width:50%;text-align: right; padding: 10px 10px;">
                    <div>
                        <?php echo '<span style="font-weight: bold; font-size: 13px;">'."Mechtoolz".'</span><br>'; ?>
                        <?php
                            echo "#236, Gandhi Nagar, I A F Road";
                            echo ", <br>" . " Selaiyur-Chennai";
                            echo ", <br>" . "Tamilnadu";
                            echo " - " . "600073";
                            echo ' - '."India.";
                        ?>
                        <?php
						echo '<br><span>' . "9841967890" . '</span>';
						?>
                        <?php
                            echo '<br><span>' . "services@mechpoint.care" . '</span>';
                        ?>
                        <?php 
                            echo '<br><span style="text-transform:uppercase;">' . "33CUZPP2905E1ZD" . '</span>';
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <hr>
                </td>
            </tr>
        </table>
    </htmlpageheader>
    <main style="padding:12px;">
        <table><tr><td height="15"></td></tr></table>
        <table width="100%" class="item-tables">
            <tr width="100%">
                <td width="46%" style="width:40%;float: left;">
                    <table width="100%">
                    <?php if($workshop_det[0]->workshop_name){ ?>
                        <tr width="100%">    
                            <td width="35%" ><?php _trans('lable36'); ?> :</td>
                            <td width="65%"><?php echo $workshop_det[0]->workshop_name;?></td>
                        </tr>
                    <?php }if($workshop_det[0]->name){ ?>
                        <tr width="100%">    
                            <td width="35%"><?php _trans('lable61'); ?> : </td>
                            <td width="65%"><?php
                            echo $workshop_det[0]->workshop_street;
                            echo ", <br>" . $workshop_det[0]->city_name;
                            echo ", <br>" . $workshop_det[0]->state_name;
                            echo " - " . $workshop_det[0]->workshop_pincode;
                            echo ' - '.$workshop_det[0]->name .'.';
                             ?></td>
                        </tr>
                    <?php }if($workshop_det[0]->workshop_gstin){ ?>
                        <tr width="100%">
                            <td width="35%"><?php _trans('lable910'); ?> :</b>
                            <td width="65%"><?php echo $workshop_det[0]->workshop_gstin; ?></td>
                        </tr>
                    <?php } if($workshop_det[0]->workshop_contact_no != "" || $workshop_det[0]->workshop_email_id != ""){?>
                        <tr width="100%">    
                            <td width="35%"><?php _trans('lable1051'); ?> :</td>
                            <td width="65%">
                                <?php echo $workshop_det[0]->workshop_contact_no;?><br>
                                <?php echo $workshop_det[0]->workshop_email_id; ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </table>
                </td>
                <td width="53%" style="float: right; text-align: right;">
                    <table width="100%" style="width:100%;float: right" class="item-tables">
                       <?php if($subscription_list[0]->invoice_no){ ?>
                            <tr width="100%" style="width:100%;">
                                <td><?php _trans('lable29'); ?> :</td>
                                <td><?php echo $subscription_list[0]->invoice_no; ?></td>
                            </tr>
                        <?php } if($subscription_list[0]->from_date){ ?>                    
                            <tr width="100%" style="width:100%;">
                                <td><?php _trans('lable368'); ?> :</td>
                                <td><?php echo ($subscription_list[0]->from_date?date_from_mysql($subscription_list[0]->from_date):""); ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </td>
            </tr>
        </table>
        <br>
        <?php if(count($subscription_list) > 0){ ?>
       
        <div>
            <h4 style="padding:0px 0px 10px 0px; margin: 0;font-size:12px;font-weight: bold;"><?php _trans('lable564'); ?></h4>
        </div>
        <table class="item-table">
            <thead>
                <tr>
                    <th width="5%" style="width:5%;text-align: center" class="item-desc"><?php _trans('lable125'); ?></th>
                    <th width="35%" style="width:35%;" class="item-desc text-left"><?php _trans('lable177'); ?></th>
                    <th width="6%" style="width:6%;" class="item-desc text-right"><?php _trans('lable331'); ?> (%)</th>
                    <th width="12%" style="width:12%;" class="item-desc text-right"><img src="uploads/workshop_logo/rupee.svg" width="10px" height="7.5px"><?php _trans('lable351'); ?></th>
                    <th width="8%" style="width:8%;" class="item-desc text-right"><img src="uploads/workshop_logo/rupee.svg" width="10px" height="7.5px"><?php _trans('lable108'); ?></th>
                    <th width="8%" style="width:8%;" class="item-desc text-right"><img src="uploads/workshop_logo/rupee.svg" width="10px" height="7.5px"><?php _trans('lable339'); ?></th>
                </tr>
                <?php if (count($subscription_list) > 0) {
				$i = 1;
				foreach ($subscription_list as $subscription) { ?>

                <?php if($subscription->plan_month_type == 1){
                            $month_type = trans('lable1135');}
                        elseif($subscription->plan_month_type == 3){
                            $month_type = trans('lable1136');}
                        elseif($subscription->plan_month_type == 6){
                            $month_type = trans('lable1137');} 
                        elseif($subscription->plan_month_type == 12){
                            $month_type = trans('lable1138');} 
                ?>
                <tr> 
                    <td width="5%" style="width:5%;text-align: center" class="item-desc"><?php echo $i;$i++; ?></td>
                    <td width="35%" style="width:35%;" class="item-desc"><?php echo $subscription->plan_type .' - '. $month_type; ?></td>
                    <td width="6%" style="width:6%;" class="item-desc text-right"><?php echo $subscription->tax; ?>
                    <td width="12%" style="width:12%;" class="item-desc text-right"><img src="uploads/workshop_logo/rupee.svg" width="10px" height="7.5px"><?php echo format_money($subscription->tax_amount,$this->session->userdata('default_currency_digit')); ?></td>
                    <td width="12%" style="width:12%;" class="item-desc text-right"><img src="uploads/workshop_logo/rupee.svg" width="10px" height="7.5px"><?php echo format_money($subscription->total_amount,$this->session->userdata('default_currency_digit')); ?></td>
                    <td width="12%" style="width:12%;" class="item-desc text-right"><img src="uploads/workshop_logo/rupee.svg" width="10px" height="7.5px"><?php echo format_money($subscription->grand_total,$this->session->userdata('default_currency_digit')); ?></td>
                </tr>
                <?php } } ?>
            </thead>
        </table>
        <br>
        <div class="item-desc" style="text-align: right;font-weight: bold;">
            <?php echo  _trans('lable332'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <img src="uploads/workshop_logo/rupee.svg" width="10px" height="7.5px"><?php echo format_money($subscription->grand_total,$this->session->userdata('default_currency_digit')); ?>
        </div>
        <?php } ?> 
        <table><tr><td height="20"></td></tr></table>
    </main>
    <htmlpagefooter name="myHTMLFooter">
        <div class="footer_bg"><?php _trans('lable1045'); ?></div>
    </htmlpagefooter>
    <?php //exit(); ?>
</body>
</html> 