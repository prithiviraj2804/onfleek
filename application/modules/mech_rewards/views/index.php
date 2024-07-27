<div id="search">
    <header class="page-content-header">
        <div class="container-fluid">
            <div class="tbl">
                <div class="tbl-row">
                    <div class="tbl-cell">
                        <h3><?php _trans('Referral'); ?></h3>
                    </div>
                    <div class="tbl-cell pull-right">
                        <a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_rewards/form'); ?>">
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
                    <?php if(count($mech_rewards) > 0) { echo pager(site_url('mech_rewards/index'), 'mdl_mech_rewards'); } ?>
                </div>
                <div class="overflowScrollForTable">
                    <table class="display table datatable table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text_align_center"><?php _trans('Branch'); ?></th>
                                <th class="text_align_center"><?php _trans('Enabled For'); ?></th>
                                <th class="text_align_center"><?php _trans('Exclusive / Inclusive of Tax'); ?></th>
                                <th class="text_align_center"><?php _trans('Type'); ?></th>
                                <th class="text_align_center"><?php _trans('Point / Percentage / Amount'); ?></th>
                                <th class="text_align_center"><?php _trans('options'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($mech_rewards) > 0) { foreach ($mech_rewards as $rewards_list) { ?>
                            <tr>
                                <td><?php echo $rewards_list->display_board_name; ?></td>
                                <td>
                                    <?php if($rewards_list->applied_for == 'A'){
                                        echo "Product & Service";
                                    }else if($rewards_list->applied_for == 'P'){
                                        echo "Product";
                                    }else if($rewards_list->applied_for == 'S'){
                                        echo "Service";
                                    } ?>
                                </td>
                                <td>
                                    <?php if($rewards_list->inclusive_exclusive == 1){
                                        echo "inclusive of Tax";
                                    }else if($rewards_list->inclusive_exclusive == 2){
                                        echo "Exclusive of Tax";
                                    }?>
                                </td>
                                <td>
                                    <?php if($rewards_list->reward_type == 'P'){
                                        echo "Points";
                                    }else if($rewards_list->reward_type == 'R'){
                                        echo "Percentage";
                                    }else if($rewards_list->reward_type == 'A'){
                                        echo "Amount";
                                    } ?>
                                </td>
                                <td>
                                    <?php echo $rewards_list->reward_amount; ?>
                                </td>
                                <td class="text_align_center">
                                    <div class="options btn-group">
                                        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
                                            <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="<?php echo site_url('mech_rewards/create/'.$rewards_list->mrdlts_id); ?>">
                                                    <i class="fa fa-edit fa-margin"></i> <?php _trans('edit'); ?>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_record('mech_rewards',<?php echo $rewards_list->mrdlts_id; ?>, '<?= $this->security->get_csrf_hash() ?>')"> <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <?php  } } else { echo '<tr><td colspan="5" class="text-center"> No data found </td></tr>'; } ?>
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