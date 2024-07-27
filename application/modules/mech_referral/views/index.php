<div id="search">
    <header class="page-content-header">
        <div class="container-fluid">
            <div class="tbl">
                <div class="tbl-row">
                    <div class="tbl-cell">
                        <h3><?php _trans('Referral'); ?></h3>
                    </div>
                    <div class="tbl-cell pull-right">
                        <a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_referral/form'); ?>">
                            <i class="fa fa-plus"></i><?php _trans('new'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div id="content" class="table-content">
        <?php $this->layout->load_view('layout/alerts'); ?>
        <section class="card">
            <div class="card-block">
                <div class="headerbar-item pull-right">
                    <?php if(count($mech_referrals) > 0){ echo pager(site_url('mech_referral/index'), 'mdl_mech_referral'); } ?>
                </div>
                <div class="overflowScrollForTable">
                    <table class="display table datatable table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text_align_center"><?php _trans('lable95'); ?></th>
                                <th class="text_align_center"><?php _trans('lable734'); ?></th>
                                <th class="text_align_center"><?php _trans('lable783'); ?></th>
                                <th class="text_align_center"><?php _trans('lable175'); ?></th>
                                <th class="text_align_center"><?php _trans('lable176'); ?></th>
                                <th class="text_align_center"><?php _trans('lable184'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($mech_referrals) > 0) { foreach ($mech_referrals as $referrals_list) { ?>
                            <tr>
                                <td><?php echo $referrals_list->display_board_name; ?></td>
                                <td>
                                    <?php if($referrals_list->cusreffCheckBox == 'Y'){
                                        echo 'Customer </br>';
                                    }
                                    if($referrals_list->empreffCheckBox == 'Y'){
                                        echo 'Employee';
                                    } ?>
                                </td>
                                <td>
                                    <?php if($referrals_list->cus_ref_type == 'P'){
                                        echo 'Points </br>';
                                    }else if($referrals_list->cus_ref_type == 'R'){
                                        echo 'Percentage  </br>';
                                    }else if($referrals_list->cus_ref_type == 'A'){
                                        echo 'Amount  </br>';
                                    }
                                    if($referrals_list->emp_ref_type == 'P'){
                                        echo 'Points </br>';
                                    }else if($referrals_list->emp_ref_type == 'R'){
                                        echo 'Percentage  </br>';
                                    }else if($referrals_list->emp_ref_type == 'A'){
                                        echo 'Amount  </br>';
                                    } ?>
                                </td>
                                <td>
                                    <?php if($referrals_list->cus_ref_pt){
                                        echo $referrals_list->cus_ref_pt.' </br>';
                                    }if($referrals_list->emp_ref_pt){
                                        echo $referrals_list->emp_ref_pt;
                                    } ?>
                                </td>
                                <td>
                                    <?php if($referrals_list->cus_red_pt){
                                        echo $referrals_list->cus_red_pt.' </br>';
                                    }if($referrals_list->emp_red_pt){
                                        echo $referrals_list->emp_red_pt;
                                    } ?>
                                </td>
                                <td class="text_align_center">
                                    <div class="options btn-group">
                                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                                            <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="<?php echo site_url('mech_referral/create/'.$referrals_list->mrefh_id); ?>">
                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_record('mech_referral',<?php echo $referrals_list->mrefh_id; ?>, '<?= $this->security->get_csrf_hash() ?>')"> <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <?php  } } else { echo '<tr><td colspan="5" class="text-center"> No Data Found </td></tr>'; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
<script>
$(function() {
    $(".card-block input").keypress(function (e) {
        if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
            $('.btn_submit').click();
            return false;
        } else {
            return true;
        }
    });
        
    $(".btn_submit").click(function () {
        window.location = "<?php echo site_url('mech_referral/index'); ?>/0/"+($("#name").val()?$("#name").val():0)+"/"+($('#mobile_no').val()?$('#mobile_no').val():0)+"/"+($("#email").val()?$("#email").val():0);
    });

});

</script>