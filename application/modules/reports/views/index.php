<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php _trans('menu13');?></h3>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- /* sale repors css start */ -->
<div id="content" class="table-content">
    <section class="card">
		<div class="card-block">
            <div class="row">
                <div class="col-xs-12 col-md-12 sales_reports margin-bottom-20px margin-top-20px">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <label><i class="fa fa-shopping-basket" aria-hidden="true"></i><?php _trans('lable610');?>:</label>
                        <ul>
                        <li><a href="<?php echo site_url('reports/sales_summary'); ?>"><i class="fa fa-star-o" aria-hidden="true"></i><?php _trans('lable615');?></a></li>
                            <li><a href="<?php echo site_url('reports/customer_due_report'); ?>"><i class="fa fa-star-o" aria-hidden="true"></i><?php _trans('lable611');?></a></li>
                            <?php if($this->session->userdata('plan_type') != 3){ ?>
                                <li><a href="<?php echo site_url('reports/service_summary');?>"><i class="fa fa-star-o" aria-hidden="true"></i><?php _trans('lable612');?></a></li>
                                <li><a href="<?php echo site_url('reports/service_category_rep');?>"><i class="fa fa-star-o" aria-hidden="true"></i><?php _trans('lable613');?></a></li>
                            <?php } ?>
                            <!-- <li><a href="<?php // echo site_url('reports/sales_service_by_client');?>"><i class="fa fa-star-o" aria-hidden="true"></i><?php //_trans('lable614');?></a></li> -->
                            <?php if($is_product == "Y"){ ?>
                                <li><a href="<?php echo site_url('reports/sales_by_product'); ?>"><i class="fa fa-star-o" aria-hidden="true"></i><?php _trans('lable616');?></a></li>
                                <li><a href="<?php echo site_url('reports/sales_product_by_client'); ?>"><i class="fa fa-star-o" aria-hidden="true"></i><?php _trans('lable617');?></a></li>
                            <?php } ?>
                            <li><a href="<?php echo site_url('reports/reference_type_report'); ?>"><i class="fa fa-star-o" aria-hidden="true"></i><?php _trans('lable975');?></a></li>
                        </ul>
                    </div>
                    <?php if($this->session->userdata('workshop_is_enabled_inventory') == "Y"){ ?>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <label><i class="fa fa-file-text" aria-hidden="true"></i><?php _trans('lable618');?>:</label>
                        <ul>
                            <li><a href="<?php echo site_url('reports/inventory_hand'); ?>"><i class="fa fa-star-o" aria-hidden="true"></i><?php _trans('lable619');?></a></li>
                            <li><a href="<?php echo site_url('reports/inventory_lowstock'); ?>"><i class="fa fa-star-o" aria-hidden="true"></i><?php _trans('lable620');?></a></li>
                            <li><a href="javascript:void(0);"><i class="fa fa-star-o" aria-hidden="true"></i><?php _trans('lable621');?></a></li>
                        </ul>
                    </div>
                    <?php } ?>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <label><i class="fa fa-credit-card-alt" aria-hidden="true"></i><?php _trans('lable622');?>:</label>
                        <ul>
                            <li><a href="<?php echo site_url('reports/expense_details'); ?>"><i class="fa fa-star-o" aria-hidden="true"></i><?php _trans('lable623');?></a></li>
                            <li><a href="<?php echo site_url('reports/expense_by_category'); ?>"><i class="fa fa-star-o" aria-hidden="true"></i><?php _trans('lable624');?></a></li>
                            <li><a href="<?php echo site_url('reports/purchase_summary'); ?>"><i class="fa fa-star-o" aria-hidden="true"></i><?php _trans('lable1129');?></a></li>
                            <!-- <li><a href="javascript:void(0);"><i class="fa fa-star-o" aria-hidden="true"></i>Expenses by Customer</a></li>
                            <li><a href="javascript:void(0);"><i class="fa fa-star-o" aria-hidden="true"></i>Expenses by Project</a></li>
                            <li><a href="javascript:void(0);"><i class="fa fa-star-o" aria-hidden="true"></i>Mileage Expenses by Employee</a></li> -->
                        </ul>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <label><i class="fa fa-file" aria-hidden="true"></i><?php _trans('lable989');?>:</label>
                        <ul>
                            <li><a href="<?php echo site_url('reports/customer_ledger'); ?>"><i class="fa fa-star-o" aria-hidden="true"></i><?php _trans('lable990');?></a></li>
                            <li><a href="<?php echo site_url('reports/supplier_ledger'); ?>"><i class="fa fa-star-o" aria-hidden="true"></i><?php _trans('lable991');?></a></li>
                            <li><a href="<?php echo site_url('reports/product_ledger'); ?>"><i class="fa fa-star-o" aria-hidden="true"></i><?php _trans('lable992');?></a></li>
                        </ul>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12" style="margin-top: 1%;">
                        <label><i class="fa fa-history" aria-hidden="true"></i><?php _trans('lable1224');?>:</label>
                        <ul>
                            <li><a href="<?php echo site_url('reports/service_history'); ?>"><i class="fa fa-star-o" aria-hidden="true"></i><?php _trans('lable1225');?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
	</section>
</div>