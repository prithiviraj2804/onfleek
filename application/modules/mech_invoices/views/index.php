<?php if(count($mech_invoices) < 1) {  ?>
<script type="text/javascript">
    $(function() {
        var getHeight = $( window ).height();
        $(".imageDynamicHeight").css('height' , getHeight - 200);
    });
</script>
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center imageDynamicHeight" style="display: table;">
    <div class="tbl-cell">
        <img style="width: 30%; text-center" src="<?php echo base_url(); ?>assets/mp_backend/img/no_data_available.jpg" alt="Mechtoolz">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
            <a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_invoices/create'); ?>">
                <i class="fa fa-plus"></i> <?php _trans('label932'); ?>
            </a>
        </div>
    </div>
</div>
<?php } else { ?>
<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php _trans('lable367'); ?></h3>
				</div>
				<div class="tbl-cell tbl-cell-action">
				<a href="<?php echo site_url('mech_invoices/create'); ?>"  class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> <?php _trans('lable40'); ?></a>
					<!-- <a href="javascript:void(0)" id="generate_invoice" class="btn btn-rounded">GENERATE INVOICE</a> -->
				</div>
			</div>
		</div>
	</div>
</header>
<div class="container-fluid">
	<?php 
        $this->layout->load_view('mech_invoices/partial_admin_appointment_table');
    ?>
</div>
<?php } ?>
