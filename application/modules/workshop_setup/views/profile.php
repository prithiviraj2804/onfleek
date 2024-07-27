<script src="<?php echo base_url(); ?>assets/mp_backend/js/lib/jquery-validation/jquery.validate.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/additional-methods.js"></script>
<script type="text/javascript">
var is_new_user = '<?php echo $this->session->userdata('is_new_user'); ?>';
	$(document).ready(function() {

		$("#is_product").click(function(){
			if($("#is_product:checked").is(":checked")){
				$("#is_product").val('Y');
			}else{
				$("#is_product").val('N');
			}
		});

		$(".ipad_dropdown").click(function(){
			$(".ipad_dropdown").removeClass('active');
		});

		$('.country').change(function () {
			$('#gif').show();
            $.post("<?php echo site_url('settings/ajax/get_state_list'); ?>", {
				country_id: $('#workshop_country').val(),
				_mm_csrf: $('#_mm_csrf').val()
			},
			function (data) {
				var response = JSON.parse(data);
				if (response.length > 0) {
					$('#gif').hide();
					$('#workshop_state').empty(); // clear the current elements in select box
					$('#workshop_state').append($('<option></option>').attr('value', '').text('Select State'));
					for (row in response) {
						$('#workshop_state').append($('<option></option>').attr('value', response[row].state_id).text(response[row].state_name));
					}
					$('#workshop_state').selectpicker("refresh");
				}
				else {
					$('#gif').hide();
					$('#workshop_state').empty(); // clear the current elements in select box
					$('#workshop_state').append($('<option></option>').attr('value', '').text('Select State'));
					$('#workshop_state').selectpicker("refresh");
				}
			});
		});
		
		$('.state').change(function () {
			$('#gif').show();
            $.post("<?php echo site_url('settings/ajax/get_city_list'); ?>", {
				state_id: $('#workshop_state').val(),
				_mm_csrf: $('#_mm_csrf').val()
			},
			function (data) {
				<?php // echo IP_DEBUG ? 'console.log(data);' : ''; ?>
				var response = JSON.parse(data);
				if (response.length > 0) {
					$('#gif').hide();
					$('#workshop_city').empty(); // clear the current elements in select box
					$('#workshop_city').append($('<option></option>').attr('value', '').text('Select City'));
					for (row in response) {
						$('#workshop_city').append($('<option></option>').attr('value', response[row].city_id).text(response[row].city_name));
					}
					$('#workshop_city').selectpicker("refresh");
				}
				else {
					$('#gif').hide();
					$('#workshop_city').empty(); // clear the current elements in select box
					$('#workshop_city').append($('<option></option>').attr('value', '').text('Select City'));
					$('#workshop_city').selectpicker("refresh");
				}
			});
		});
	});
</script>
<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php _trans('lable685'); ?></h3>
				</div>
			</div>
		</div>
	</div>
</header>
<?php if(isset($active_tab)){
    if ($active_tab == 1) {
        $one_tab_active = 'active show in';
        $two_tab_active = '';
		$three_tab_active = '';
		$four_tab_active = '';
		$five_tab_active = '';
		$six_tab_active = '';
		$seven_tab_active = '';
		$eight_tab_active = '';
		$nine_tab_active = '';
		$tenth_tab_active = '';
		$eleventh_tab_active = '';
		$twelve_tab_active = '';
		$thirteen_tab_active = '';
        $one_area_selected = true;
        $two_area_selected = false;
		$three_area_selected = false;
		$four_area_selected = false;
		$five_area_selected = false;
		$six_area_selected = false;
		$seven_area_selected = false;
		$eight_area_selected = false;
		$nine_area_selected = false;
		$tenth_area_selected = false;
		$eleven_area_selected = false;
		$twelve_area_selected = false;
		$thirteen_area_selected = false;
    } elseif ($active_tab == 2) {
        $one_tab_active = '';
        $two_tab_active = 'active show in';
		$three_tab_active = '';
		$four_tab_active = '';
		$five_tab_active = '';
		$six_tab_active = '';
		$seven_tab_active = '';
		$eight_tab_active = '';
		$nine_tab_active = '';
		$tenth_tab_active = '';
		$eleventh_tab_active = '';
		$twelve_tab_active = '';
		$thirteen_tab_active = '';
        $one_area_selected = false;
        $two_area_selected = true;
		$three_area_selected = false;
		$four_area_selected = false;
		$five_area_selected = false;
		$six_area_selected = false;
		$seven_area_selected = false;
		$eight_area_selected = false;
		$nine_area_selected = false;
		$tenth_area_selected = false;
		$eleven_area_selected = false;
		$twelve_area_selected = false;
		$thirteen_area_selected = false;
    } elseif ($active_tab == 3) {
        $one_tab_active = '';
        $two_tab_active = '';
		$three_tab_active = 'active show in';
		$four_tab_active = '';
		$five_tab_active = '';
		$six_tab_active = '';
		$seven_tab_active = '';
		$eight_tab_active = '';
		$nine_tab_active = '';
		$tenth_tab_active = '';
		$eleventh_tab_active = '';
		$twelve_tab_active = '';
		$thirteen_tab_active = '';
        $one_area_selected = false;
        $two_area_selected = false;
		$three_area_selected = true;
		$four_area_selected = false;
		$five_area_selected = false;
		$six_area_selected = false;
		$seven_area_selected = false;
		$eight_area_selected = false;
		$nine_area_selected = false;
		$tenth_area_selected = false;
		$eleven_area_selected = false;
		$twelve_area_selected = false;
		$thirteen_area_selected = false;
    }elseif ($active_tab == 4) {
        $one_tab_active = '';
        $two_tab_active = '';
		$three_tab_active = '';
		$four_tab_active = 'active show in';
		$five_tab_active = '';
		$six_tab_active = '';
		$seven_tab_active = '';
		$eight_tab_active = '';
		$nine_tab_active = '';
		$tenth_tab_active = '';
		$eleventh_tab_active = '';
		$twelve_tab_active = '';
		$thirteen_tab_active = '';
        $one_area_selected = false;
        $two_area_selected = false;
		$three_area_selected = false;
		$four_area_selected = true;
		$five_area_selected = false;
		$six_area_selected = false;
		$seven_area_selected = false;
		$eight_area_selected = false;
		$nine_area_selected = false;
		$tenth_area_selected = false;
		$eleven_area_selected = false;
		$twelve_area_selected = false;
		$thirteen_area_selected = false;
    }elseif ($active_tab == 5) {
        $one_tab_active = '';
        $two_tab_active = '';
		$three_tab_active = '';
		$four_tab_active = '';
		$five_tab_active = 'active show in';
		$six_tab_active = '';
		$seven_tab_active = '';
		$eight_tab_active = '';
		$nine_tab_active = '';
		$tenth_tab_active = '';
		$eleventh_tab_active = '';
		$twelve_tab_active = '';
		$thirteen_tab_active = '';
        $one_area_selected = false;
        $two_area_selected = false;
		$three_area_selected = false;
		$four_area_selected = false;
		$five_area_selected = true;
		$six_area_selected = false;
		$seven_area_selected = false;
		$eight_area_selected = false;
		$nine_area_selected = false;
		$tenth_area_selected = false;
		$eleven_area_selected = false;
		$twelve_area_selected = false;
		$thirteen_area_selected = false;
    }elseif ($active_tab == 6) {
        $one_tab_active = '';
        $two_tab_active = '';
		$three_tab_active = '';
		$four_tab_active = '';
		$five_tab_active = '';
		$six_tab_active = 'active show in';
		$seven_tab_active = '';
		$eight_tab_active = '';
		$nine_tab_active = '';
		$tenth_tab_active = '';
		$eleventh_tab_active = '';
		$twelve_tab_active = '';
		$thirteen_tab_active = '';
        $one_area_selected = false;
        $two_area_selected = false;
		$three_area_selected = false;
		$four_area_selected = false;
		$five_area_selected = false;
		$six_area_selected = true;
		$seven_area_selected = false;
		$eight_area_selected = false;
		$nine_area_selected = false;
		$tenth_area_selected = false;
		$eleven_area_selected = false;
		$twelve_area_selected = false;
		$thirteen_area_selected = false;
    }else if($active_tab == 7){
		$one_tab_active = '';
        $two_tab_active = '';
		$three_tab_active = '';
		$four_tab_active = '';
		$five_tab_active = '';
		$six_tab_active = '';
		$seven_tab_active = 'active show in';
		$eight_tab_active = '';
		$nine_tab_active = '';
		$tenth_tab_active = '';
		$eleventh_tab_active = '';
		$twelve_tab_active = '';
		$thirteen_tab_active = '';
        $one_area_selected = false;
        $two_area_selected = false;
		$three_area_selected = false;
		$four_area_selected = false;
		$five_area_selected = false;
		$six_area_selected = false;
		$seven_area_selected = true;
		$eight_area_selected = false;
		$nine_area_selected = false;
		$tenth_area_selected = false;
		$eleven_area_selected = false;
		$twelve_area_selected = false;
		$thirteen_area_selected = false;
	}else if($active_tab == 8){
		$one_tab_active = '';
        $two_tab_active = '';
		$three_tab_active = '';
		$four_tab_active = '';
		$five_tab_active = '';
		$six_tab_active = '';
		$seven_tab_active = '';
		$eight_tab_active = 'active show in';
		$nine_tab_active = '';
		$tenth_tab_active = '';
		$eleventh_tab_active = '';
		$twelve_tab_active = '';
		$thirteen_tab_active = '';
        $one_area_selected = false;
        $two_area_selected = false;
		$three_area_selected = false;
		$four_area_selected = false;
		$five_area_selected = false;
		$six_area_selected = false;
		$seven_area_selected = false;
		$eight_area_selected = true;
		$nine_area_selected = false;
		$tenth_area_selected = false;
		$eleven_area_selected = false;
		$twelve_area_selected = false;
		$thirteen_area_selected = false;
	}else if($active_tab == 9){
		$one_tab_active = '';
        $two_tab_active = '';
		$three_tab_active = '';
		$four_tab_active = '';
		$five_tab_active = '';
		$six_tab_active = '';
		$seven_tab_active = '';
		$eight_tab_active = '';
		$nine_tab_active = 'active show in';
		$tenth_tab_active = '';
		$eleventh_tab_active = '';
		$twelve_tab_active = '';
		$thirteen_tab_active = '';
        $one_area_selected = false;
        $two_area_selected = false;
		$three_area_selected = false;
		$four_area_selected = false;
		$five_area_selected = false;
		$six_area_selected = false;
		$seven_area_selected = false;
		$eight_area_selected = false;
		$nine_area_selected = true;
		$tenth_area_selected = false;
		$eleven_area_selected = false;
		$twelve_area_selected = false;
		$thirteen_area_selected = false;
	}else if($active_tab == 10){
		$one_tab_active = '';
        $two_tab_active = '';
		$three_tab_active = '';
		$four_tab_active = '';
		$five_tab_active = '';
		$six_tab_active = '';
		$seven_tab_active = '';
		$eight_tab_active = '';
		$nine_tab_active = '';
		$tenth_tab_active = 'active show in';
		$eleventh_tab_active = '';
		$twelve_tab_active = '';
		$thirteen_tab_active = '';
        $one_area_selected = false;
        $two_area_selected = false;
		$three_area_selected = false;
		$four_area_selected = false;
		$five_area_selected = false;
		$six_area_selected = false;
		$seven_area_selected = false;
		$eight_area_selected = false;
		$nine_area_selected = false;
		$tenth_area_selected = true;
		$eleven_area_selected = false;
		$twelve_area_selected = false;
		$thirteen_area_selected = false;
	}else if($active_tab == 11){
		$one_tab_active = '';
        $two_tab_active = '';
		$three_tab_active = '';
		$four_tab_active = '';
		$five_tab_active = '';
		$six_tab_active = '';
		$seven_tab_active = '';
		$eight_tab_active = '';
		$nine_tab_active = '';
		$tenth_tab_active = '';
		$eleventh_tab_active = 'active show in';
		$twelve_tab_active = '';
		$thirteen_tab_active = '';
        $one_area_selected = false;
        $two_area_selected = false;
		$three_area_selected = false;
		$four_area_selected = false;
		$five_area_selected = false;
		$six_area_selected = false;
		$seven_area_selected = false;
		$eight_area_selected = false;
		$nine_area_selected = false;
		$tenth_area_selected = false;
		$eleven_area_selected = true;
		$twelve_area_selected = false;
		$thirteen_area_selected = false;
	}else if($active_tab == 12){
		$one_tab_active = '';
        $two_tab_active = '';
		$three_tab_active = '';
		$four_tab_active = '';
		$five_tab_active = '';
		$six_tab_active = '';
		$seven_tab_active = '';
		$eight_tab_active = '';
		$nine_tab_active = '';
		$tenth_tab_active = '';
		$eleventh_tab_active = '';
		$twelve_tab_active = 'active show in';
		$thirteen_tab_active = '';
        $one_area_selected = false;
        $two_area_selected = false;
		$three_area_selected = false;
		$four_area_selected = false;
		$five_area_selected = false;
		$six_area_selected = false;
		$seven_area_selected = false;
		$eight_area_selected = false;
		$nine_area_selected = false;
		$tenth_area_selected = false;
		$eleven_area_selected = false;
		$twelve_area_selected = true;
		$thirteen_area_selected = false;
	}else if($active_tab == 13){
		$one_tab_active = '';
        $two_tab_active = '';
		$three_tab_active = '';
		$four_tab_active = '';
		$five_tab_active = '';
		$six_tab_active = '';
		$seven_tab_active = '';
		$eight_tab_active = '';
		$nine_tab_active = '';
		$tenth_tab_active = '';
		$eleventh_tab_active = '';
		$twelve_tab_active = '';
		$thirteen_tab_active = 'active show in';
        $one_area_selected = false;
        $two_area_selected = false;
		$three_area_selected = false;
		$four_area_selected = false;
		$five_area_selected = false;
		$six_area_selected = false;
		$seven_area_selected = false;
		$eight_area_selected = false;
		$nine_area_selected = false;
		$tenth_area_selected = false;
		$eleven_area_selected = false;
		$twelve_area_selected = false;
		$thirteen_area_selected = true;
	}
} else {
    $one_tab_active = 'active show in';
    $two_tab_active = '';
	$three_tab_active = '';
	$four_tab_active = '';
	$five_tab_active = '';
	$six_tab_active = '';
	$seven_tab_active = '';
	$eight_tab_active = '';
	$nine_tab_active = '';
	$tenth_tab_active = '';
	$eleventh_tab_active = '';
	$twelve_tab_active = '';
	$thirteen_tab_active = '';
    $one_area_selected = true;
    $two_area_selected = false;
	$three_area_selected = false;
	$four_area_selected = false;
	$five_area_selected = false;
	$six_area_selected = false;
	$seven_area_selected = false;
	$eight_area_selected = false;
	$nine_area_selected = false;
	$tenth_area_selected = false;
	$eleven_area_selected = false;
	$twelve_area_selected = false;
	$thirteen_area_selected = false;
}
?>
<div id="content" class="usermanagement">
    <div class="row">
		<div id="gif" class="gifload">
			<div class="gifcenter">
			  <center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
		    </div>
		</div>
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 ipadview">
			<div class="nav nav-tabs">
				<div class="tbl">
					<ul class="nav" role="tablist">
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $one_tab_active; ?>" href="#tabs-2-tab-1" role="tab" data-toggle="tab" aria-selected="<?php echo $one_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable686'); ?></span>
							</a>
						</li>
						<?php if($this->session->userdata('is_new_user') == 'O'){?>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $two_tab_active; ?>" href="#tabs-2-tab-2" role="tab" data-toggle="tab" aria-selected="<?php echo $two_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable95'); ?></span>
								<span class="rightCountipad label label-pill label-success"><?php echo count($workshop_branch_list); ?></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $three_tab_active; ?>" href="#tabs-2-tab-3" role="tab" data-toggle="tab" aria-selected="<?php echo $three_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable81'); ?></span>
								<span class="rightCountipad label label-pill label-success"><?php echo count($workshop_bank_list); ?></span>
							</a>
						</li>
						<?php if($this->session->userdata('user_type')==3 || $this->session->userdata('user_type')==4){ ?>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $four_tab_active; ?>" href="#tabs-2-tab-4" role="tab" data-toggle="tab" aria-selected="<?php echo $four_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable687'); ?></span>
								<span class="rightCountipad label label-pill label-success"><?php echo count($invoice_groups); ?></span>
							</a>
						</li>

						<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#tabs" role="button" aria-haspopup="true" aria-expanded="false">Dropdown</a>
						<div class="dropdown-menu" style="min-width: 180px !important;">
							<a style="width: 100%;float: left;" class="dropdown-item ipad_dropdown <?php echo $five_tab_active; ?>" href="#tabs-2-tab-5" role="tab" data-toggle="tab" aria-selected="<?php echo $five_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable688'); ?></span>
								<span class="rightCountipaddropdown label label-pill label-success"><?php echo count($payment_methods); ?></span>
							</a>
							<a style="width: 100%;float: left;" class="dropdown-item ipad_dropdown <?php echo $six_tab_active; ?>" href="#tabs-2-tab-6" role="tab" data-toggle="tab" aria-selected="<?php echo $six_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable689'); ?></span>
								<span class="rightCountipaddropdown label label-pill label-success"><?php echo count($mech_referrals); ?></span>
							</a>
							<a style="width: 100%;float: left;" class="dropdown-item ipad_dropdown <?php echo $nine_tab_active; ?>" href="#tabs-2-tab-9" role="tab" data-toggle="tab" aria-selected="<?php echo $nine_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable690'); ?></span>
								<span class="rightCountipaddropdown label label-pill label-success"><?php echo count($mech_rewards); ?></span>
							</a>
							<a style="width: 100%;float: left;" class="dropdown-item ipad_dropdown <?php echo $seven_tab_active; ?>" href="#tabs-2-tab-7" role="tab" data-toggle="tab" aria-selected="<?php echo $seven_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable557'); ?></span>
							</a>
							<a style="width: 100%;float: left;" class="dropdown-item ipad_dropdown <?php echo $eight_tab_active; ?>" href="#tabs-2-tab-8" role="tab" data-toggle="tab" aria-selected="<?php echo $eight_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable691'); ?></span>
								<span class="rightCountipaddropdown label label-pill label-success"><?php echo count($email_templates); ?></span>
							</a>
						<?php if($this->session->userdata('plan_type') != 3){  ?>
							<a style="width: 100%;float: left;" class="dropdown-item ipad_dropdown <?php echo $tenth_tab_active; ?>" href="#tabs-2-tab-10" role="tab" data-toggle="tab" aria-selected="<?php echo $tenth_tab_active; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable873'); ?></span>
								<span class="rightCountipaddropdown label label-pill label-success"><?php echo count($mech_vehicle_type_list); ?></span>
							</a>
						<?php } ?>
						<?php /* * / ?><li class="nav-item">
							<a class="navListlink nav-link <?php echo $eleventh_tab_active; ?>" href="#tabs-2-tab-11" role="tab" data-toggle="tab" aria-selected="<?php echo $eleventh_tab_active; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable986'); ?></span>
								<span class="rightCountSpan label label-pill label-success"><?php echo count($tax_rates); ?></span>
							</a>
						</li>
						<?php / * */ ?>
						<?php ?>
							<a style="width: 100%;float: left;" class="dropdown-item ipad_dropdown dropdown_id_12 <?php echo $twelve_tab_active; ?>" href="#tabs-2-tab-12" role="tab" data-toggle="tab" aria-selected="<?php echo $twelve_tab_active; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable1092'); ?></span>
								<span class="rightCountipaddropdown label label-pill label-success"></span>
							</a>
						<?php ?>
						<?php ?>
							<a style="width: 100%;float: left;" class="dropdown-item ipad_dropdown dropdown_id_13 <?php echo $thirteen_tab_active; ?>" href="#tabs-2-tab-13" role="tab" data-toggle="tab" aria-selected="<?php echo $thirteen_tab_active; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable331'); ?></span>
								<span class="rightCountipaddropdown label label-pill label-success"></span>
							</a>
						<?php ?>
						</div>
  						</li>
						<?php } } else { ?>
							<li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable95'); ?></span>
									<span class="rightCountipad label label-pill label-success"><?php echo count($workshop_branch_list); ?></span>
								</a>
							</li>
							<li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable81'); ?></span>
									<span class="rightCountipad label label-pill label-success"><?php echo count($workshop_bank_list); ?></span>
								</a>
							</li>
							<?php if($this->session->userdata('user_type')==3 || $this->session->userdata('user_type')==4){ ?>
							<li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable687'); ?></span>
									<span class="rightCountipad label label-pill label-success"><?php echo count($invoice_groups); ?></span>
								</a>
							</li>
							
							<li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable688'); ?></span>
									<span class="rightCountipad label label-pill label-success"><?php echo count($payment_methods); ?></span>
								</a>
							</li>
							<li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable689'); ?></span>
								</a>
							</li>
							
							<li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable690'); ?></span>
								</a>
							</li>
							<li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable557'); ?></span>
								</a>
							</li>
							<li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable691'); ?></span>
								</a>
							</li>
							<?php if($this->session->userdata('plan_type') != 3){  ?>
							<li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable873'); ?></span>
								</a>
							</li>
							<?php } ?>
							<?php /* * / ?>
							<li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable986'); ?></span>
								</a>
							</li>
							<?php / * */ ?>
							<?php ?>
							<li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable1092'); ?></span>
								</a>
							</li>
							<?php ?>
							<?php ?>
							<li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable331'); ?></span>
								</a>
							</li>
							<?php ?>
						<?php } } ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-xs-12 smallPortion desktopview" style="height: 480px;overflow-y: scroll;overflow-x: hidden;">
			<div class="tabs-section-nav">
				<div class="tbl">
					<ul class="nav" role="tablist">
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $one_tab_active; ?>" href="#tabs-2-tab-1" role="tab" data-toggle="tab" aria-selected="<?php echo $one_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable686'); ?></span>
							</a>
						</li>
						<?php if($this->session->userdata('is_new_user') == 'O'){?>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $two_tab_active; ?>" href="#tabs-2-tab-2" role="tab" data-toggle="tab" aria-selected="<?php echo $two_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable95'); ?></span>
								<span class="rightCountSpan label label-pill label-success"><?php echo count($workshop_branch_list); ?></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $three_tab_active; ?>" href="#tabs-2-tab-3" role="tab" data-toggle="tab" aria-selected="<?php echo $three_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable81'); ?></span>
								<span class="rightCountSpan label label-pill label-success"><?php echo count($workshop_bank_list); ?></span>
							</a>
						</li>
						<?php if($this->session->userdata('user_type')==3 || $this->session->userdata('user_type')==4){ ?>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $four_tab_active; ?>" href="#tabs-2-tab-4" role="tab" data-toggle="tab" aria-selected="<?php echo $four_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable687'); ?></span>
								<span class="rightCountSpan label label-pill label-success"><?php echo count($invoice_groups); ?></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $five_tab_active; ?>" href="#tabs-2-tab-5" role="tab" data-toggle="tab" aria-selected="<?php echo $five_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable688'); ?></span>
								<span class="rightCountSpan label label-pill label-success"><?php echo count($payment_methods); ?></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $six_tab_active; ?>" href="#tabs-2-tab-6" role="tab" data-toggle="tab" aria-selected="<?php echo $six_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable689'); ?></span>
								<span class="rightCountSpan label label-pill label-success"><?php echo count($mech_referrals); ?></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $nine_tab_active; ?>" href="#tabs-2-tab-9" role="tab" data-toggle="tab" aria-selected="<?php echo $nine_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable690'); ?></span>
								<span class="rightCountSpan label label-pill label-success"><?php echo count($mech_rewards); ?></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $seven_tab_active; ?>" href="#tabs-2-tab-7" role="tab" data-toggle="tab" aria-selected="<?php echo $seven_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable557'); ?></span>
							</a>
						</li>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $eight_tab_active; ?>" href="#tabs-2-tab-8" role="tab" data-toggle="tab" aria-selected="<?php echo $eight_area_selected; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable691'); ?></span>
								<span class="rightCountSpan label label-pill label-success"><?php echo count($email_templates); ?></span>

							</a>
						</li>
						<?php if($this->session->userdata('plan_type') != 3){  ?>
						<li class="nav-item">
							<a class="navListlink nav-link <?php echo $tenth_tab_active; ?>" href="#tabs-2-tab-10" role="tab" data-toggle="tab" aria-selected="<?php echo $tenth_tab_active; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable873'); ?></span>
								<span class="rightCountSpan label label-pill label-success"><?php echo count($mech_vehicle_type_list); ?></span>
							</a>
						</li>
						<?php } ?>
						<?php /* * / ?><li class="nav-item">
							<a class="navListlink nav-link <?php echo $eleventh_tab_active; ?>" href="#tabs-2-tab-11" role="tab" data-toggle="tab" aria-selected="<?php echo $eleventh_tab_active; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable986'); ?></span>
								<span class="rightCountSpan label label-pill label-success"><?php echo count($tax_rates); ?></span>
							</a>
						</li>
						<?php / * */ ?>
						<?php ?><li class="nav-item">
							<a class="navListlink nav-link <?php echo $twelve_tab_active; ?>" href="#tabs-2-tab-12" role="tab" data-toggle="tab" aria-selected="<?php echo $twelve_tab_active; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable1092'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>
						<?php ?>
						<?php ?><li class="nav-item">
							<a class="navListlink nav-link <?php echo $thirteen_tab_active; ?>" href="#tabs-2-tab-13" role="tab" data-toggle="tab" aria-selected="<?php echo $thirteen_tab_active; ?>">
								<span class="leftHeadSpan nav-link-in"><?php _trans('lable331'); ?></span>
								<span class="rightCountSpan label label-pill label-success"></span>
							</a>
						</li>
						<?php ?>
						<?php } } else { ?>
							<li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable95'); ?></span>
									<span class="rightCountSpan label label-pill label-success"><?php echo count($workshop_branch_list); ?></span>
								</a>
							</li>
							<li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable81'); ?></span>
									<span class="rightCountSpan label label-pill label-success"><?php echo count($workshop_bank_list); ?></span>
								</a>
							</li>
							<?php if($this->session->userdata('user_type')==3 || $this->session->userdata('user_type')==4){ ?>
							<li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable687'); ?></span>
									<span class="rightCountSpan label label-pill label-success"><?php echo count($invoice_groups); ?></span>
								</a>
							</li>
							<li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable688'); ?></span>
									<span class="rightCountSpan label label-pill label-success"><?php echo count($payment_methods); ?></span>
								</a>
							</li>
							<li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable689'); ?></span>
								</a>
							</li>
							<li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable690'); ?></span>
								</a>
							</li>
							<li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable557'); ?></span>
								</a>
							</li>
							<li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable691'); ?></span>
								</a>
							</li>
							<?php if($this->session->userdata('plan_type') != 3){  ?>
							<li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable873'); ?></span>
								</a>
							</li>
							<?php } ?>
							<?php /* * / ?>
							<li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable986'); ?></span>
								</a>
							</li>
							<?php / * */ ?>
							<?php ?>
							<li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable1092'); ?></span>
								</a>
							</li>
							<?php ?>
							<?php ?>
							<li class="nav-item">
								<a class="navListlink nav-link not-allowed" href="#" role="tab">
									<span class="leftHeadSpan nav-link-in"><?php _trans('lable331'); ?></span>
								</a>
							</li>
							<?php ?>
						<?php } } ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 paddingTopLeft0px">
				<section class="tabs-section" >
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane fade <?php echo $one_tab_active; ?>" id="tabs-2-tab-1">
							<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 paddingTopLeft0px">
								<input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?= $this->security->get_csrf_hash(); ?>">
								<input type="hidden" name="workshop_id" id="workshop_id" value="<?php echo $workshop_id; ?>" >
								<input type="hidden" name="is_update" id="is_update" value="<?php if($workshop_id){echo '1';}else { echo '0';} ?>" >
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('lable683'); ?>*</label>
									</div>
									<div class="col-sm-9">
										<input type="text" name="workshop_name" id="workshop_name" class="form-control" value="<?php echo $workshop_details->workshop_name; ?>">
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('lable684'); ?>*</label>
									</div>
									<div class="col-sm-9">
										<input type="text" name="owner_name" id="owner_name" class="form-control" value="<?php echo $workshop_details->owner_name; ?>">
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('lable1220'); ?>*</label>
									</div>
									<div class="col-sm-9">
										<?php $is_mobileapp_enabled = $workshop_details->is_mobileapp_enabled; ?>
										<select name="is_mobileapp_enabled" id="is_mobileapp_enabled" class="bootstrap-select bootstrap-select-arrow removeError">
											<option value=""></option>
											<option value="Y" <?php if ($is_mobileapp_enabled == 'Y') {echo "selected";} ?>><?php _trans('lable522'); ?></option>
											<option value="N" <?php if ($is_mobileapp_enabled == 'N') {echo "selected";} ?>><?php _trans('lable538'); ?></option>
										</select>
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('lable692'); ?>*</label>
									</div>
									<div class="col-sm-9">
										<input type="text" name="workshop_contact_no" id="workshop_contact_no" class="form-control" value="<?php echo $workshop_details->workshop_contact_no; ?>">
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('lable693'); ?></label>
									</div>
									<div class="col-sm-9">
										<input type="text" name="workshop_email_id" id="workshop_email_id" class="form-control" onblur="chkEmail(this);" value="<?php echo $workshop_details->workshop_email_id; ?>">
										<span class="error emailIdErrorr"></span>
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('lable694'); ?>*</label>
									</div>
									<div class="col-sm-9">
										<input type="text" name="workshop_street" id="workshop_street" class="form-control" value="<?php echo $workshop_details->workshop_street; ?>">
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('lable695'); ?>*</label>
									</div>
									<div class="col-sm-9">
										<select name="workshop_country" id="workshop_country" class="country bootstrap-select bootstrap-select-arrow removeError" data-live-search="true" >
											<option value=""><?php _trans('lable163'); ?></option>
											<?php foreach ($country_list as $countryList) { ?>
											<option value="<?php echo $countryList->id; ?>" <?php if ($countryList->id == $workshop_details->workshop_country) { echo 'selected'; } ?> > <?php echo $countryList->name; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('lable696'); ?>*</label>
									</div>
									<div class="col-sm-9">
										<select name="workshop_state" id="workshop_state" class="state bootstrap-select bootstrap-select-arrow removeError" data-live-search="true">
											<option value=""><?php _trans('lable164'); ?></option>
											<?php foreach ($state_list as $stateList) { ?>
											<option value="<?php echo $stateList->state_id; ?>" <?php if ($stateList->state_id == $workshop_details->workshop_state) { echo 'selected'; } ?> > <?php echo $stateList->state_name; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('lable697'); ?>*</label>
									</div>
									<div class="col-sm-9">
										<select name="workshop_city" id="workshop_city" class="bootstrap-select bootstrap-select-arrow removeError g-input" data-live-search="true">
											<option value=""><?php _trans('lable165'); ?></option>
											<?php foreach ($city_list as $cityList) { ?>
											<option value="<?php echo $cityList->city_id; ?>" <?php if ($cityList->city_id == $workshop_details->workshop_city) { echo 'selected'; } ?> > <?php echo $cityList->city_name; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('lable698'); ?>*</label>
									</div>
									<div class="col-sm-9">
										<input type="text" name="workshop_pincode" id="workshop_pincode" class="form-control" value="<?php echo $workshop_details->workshop_pincode; ?>">
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('lable699'); ?>*</label>
									</div>
									<div class="col-sm-9">
										<?php $selected = 'selected="selected"';$registration_type = $workshop_details->registration_type;?>
										<select name="registration_type" id="registration_type" class="bootstrap-select bootstrap-select-arrow removeError">
											<option value=""><?php _trans('lable700'); ?></option>
											<option value="1" <?php if (1 == $registration_type) {echo $selected;} ?>><?php _trans('lable701'); ?></option>
											<option value="2" <?php if (2 == $registration_type) {echo $selected;} ?>><?php _trans('lable702'); ?></option>
											<option value="3" <?php if (3 == $registration_type) {echo $selected;} ?>><?php _trans('lable703'); ?></option>
											<option value="4" <?php if (4 == $registration_type) {echo $selected;} ?>><?php _trans('lable704'); ?></option>
											<option value="5" <?php if (5 == $registration_type) {echo $selected;} ?>><?php _trans('lable705'); ?></option>
											<option value="6" <?php if (6 == $registration_type) {echo $selected;} ?>><?php _trans('lable706'); ?></option>
											<option value="7" <?php if (7 == $registration_type) {echo $selected;} ?>><?php _trans('lable707'); ?></option>
											<option value="8" <?php if (8 == $registration_type) {echo $selected;} ?>><?php _trans('lable708'); ?></option>
										</select>
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('lable709'); ?></label>
									</div>
									<div class="col-sm-9">
										<input type="text" name="registration_number" id="registration_number" class="form-control" value="<?php echo $workshop_details->registration_number; ?>">
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('lable710'); ?></label>
									</div>
									<div class="col-sm-9">
										<input type="text" name="workshop_gstin" id="workshop_gstin" class="form-control" value="<?php echo $workshop_details->workshop_gstin; ?>">
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('lable711'); ?>*</label>
									</div>
									<div class="col-sm-9">
										<input type="text" name="total_employee_count" id="total_employee_count" class="form-control" value="<?php echo $workshop_details->total_employee_count; ?>" >
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('lable712'); ?>*</label>
									</div>
									<div class="col-sm-9">
										<input type="text" name="since_from" id="since_from" class="form-control" value="<?php echo $workshop_details->since_from; ?>">
									</div>
								</div>
								
								<?php if($this->session->userdata('plan_type') != 3){ ?>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('lable714'); ?>*</label>
									</div>
									<div class="col-sm-9">
										<?php $workshop_is_enabled_inventory = $workshop_details->workshop_is_enabled_inventory; ?>
										<select name="workshop_is_enabled_inventory" id="workshop_is_enabled_inventory" class="bootstrap-select bootstrap-select-arrow removeError">
											<option value=""></option>
											<option value="Y" <?php if ($workshop_is_enabled_inventory == 'Y') {echo $selected;} ?>><?php _trans('lable522'); ?></option>
											<option value="N" <?php if ($workshop_is_enabled_inventory == 'N') {echo $selected;} ?>><?php _trans('lable538'); ?></option>
										</select>
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('lable715'); ?>*</label>
									</div>
									<div class="col-sm-9">
										<?php $workshop_is_enabled_jobsheet = $workshop_details->workshop_is_enabled_jobsheet; ?>
										<select name="workshop_is_enabled_jobsheet" id="workshop_is_enabled_jobsheet" class="bootstrap-select bootstrap-select-arrow removeError">
											<option value=""></option>
											<option value="Y" <?php if ($workshop_is_enabled_jobsheet == 'Y') {echo $selected;} ?>><?php _trans('lable522'); ?></option>
											<option value="N" <?php if ($workshop_is_enabled_jobsheet == 'N') {echo $selected;} ?>><?php _trans('lable538'); ?></option>
										</select>
									</div>
								</div>
								<?php }else{ ?>
									<input type="hidden" name="workshop_is_enabled_inventory" id="workshop_is_enabled_inventory" value="Y">
									<input type="hidden" name="workshop_is_enabled_jobsheet" id="workshop_is_enabled_jobsheet" value="N">

								<?php } ?>
								<?php if($this->session->userdata('is_new_user') == "N"){ 
									if($this->session->userdata('plan_type') != 3){ ?>
									<div class="form-group clearfix">
										<div class="col-sm-3 text-right">
											<label class="control-label string required"><?php _trans('lable716'); ?>*</label>
										</div>
										<div class="col-sm-9">
											<select name="pos" id="pos" class="bootstrap-select bootstrap-select-arrow removeError">
												<option value=""><?php _trans('lable717'); ?></option>
												<option value="Y"><?php _trans('lable522'); ?></option>
												<option value="N"><?php _trans('lable538'); ?></option>
											</select>
										</div>
									</div>
									<div class="form-group clearfix">
										<div class="col-sm-3 text-right">
											<label class="control-label string required"><?php _trans('lable151'); ?>*</label>
										</div>
										<div class="col-sm-9">
											<select name="shift" id="shift" class="bootstrap-select bootstrap-select-arrow removeError">
												<option value=""><?php _trans('lable152'); ?></option>
												<option value="1"><?php _trans('lable718'); ?></option>
												<option value="2"><?php _trans('lable719'); ?></option>
											</select>
										</div>
									</div>
								<?php } else{ ?>
									<input type="hidden" name="pos" id="pos" value="N">
									<input type="hidden" name="shift" id="shift" value="1">
								<?php }?>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('lable720'); ?>*</label>
									</div>
									<div class="col-sm-9">
										<select name="default_currency_id" id="default_currency_id" class="bootstrap-select bootstrap-select-arrow removeError" data-live-search="true">
											<option value=""><?php _trans('lable721'); ?></option>
											<?php foreach ($currency_list as $currencyList) { ?>
											<option value="<?php echo $currencyList->currency_id; ?>"> <?php echo $currencyList->cry_iso_code; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('lable854'); ?>*</label>
									</div>
									<div class="col-sm-9">
										<select name="default_date_id" id="default_date_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true">
											<?php foreach ($date_list as $dateList) { ?>
											<option value="<?php echo $dateList->mech_date_id; ?>"> <?php echo $dateList->date_formate; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
									</div>
									<div class="col-sm-9">
										<div class="form_controls col-lg-1 col-md-1 col-sm-1 col-xs-1 paddingTop10px">
											<input type="checkbox" class="is_product" id="is_product" name="is_product" value="" >
										</div>
										<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 text_align_left paddingTop7px"><?php _trans('lable722'); ?></div>
									</div>
								</div>
								<?php } ?>
								<?php if($this->session->userdata('plan_type') != 3){ ?>
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('lable872'); ?>*</label>
									</div>
									<div class="col-sm-9">
										<select name="service_cost_setup" id="service_cost_setup" class="bootstrap-select bootstrap-select-arrow removeError form-control" data-live-search="true">
											<option value=""><?php _trans('lable875'); ?></option>
											<option value="1" <?php if($workshop_details->service_cost_setup == 1){ echo "selected";} ?>><?php _trans('lable873'); ?></option>
											<option value="2" <?php if($workshop_details->service_cost_setup == 2){ echo "selected";} ?>><?php _trans('lable874'); ?></option>
										</select>
									</div>
								</div>
								<?php } else { ?>
									<input type="hidden" name="is_product" id="is_product" value="Y">
									<input type="hidden" name="service_cost_setup" id="service_cost_setup" value="2">
								<?php }?>
								
								<div class="form-group clearfix">
									<div class="col-sm-3 text-right">
									</div>
									<div class="col-sm-9">
										<div class="row" id="bodyType" <?php if($workshop_details->service_cost_setup == 1){ echo "style='display:block;'";}else{ echo "style='display:none;'";} ?>>
											<div id="checkinListDatas" class="col-lg-12 col-lg-12 col-sm-12 col-xs-12 padding0px paddingTop10px">
												<?php if(count($vehicle_model_type) > 0){  
												foreach ($vehicle_model_type as $checkInList) { ?>
												<div class="multi-field col-lg-6 col-lg-6 col-sm-6 col-xs-12">
													<div class="form-group clearfix">
														<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text_align_left paddingTop10px">
															<input type="hidden" id="mvt_<?php echo $checkInList->mvt_id;?>"  class="mvt_id" value="<?php echo $checkInList->mvt_id;?>">
															<input type="checkbox" id="checkin_count_<?php echo $checkInList->mvt_id; ?>" class="checkbox select_all_row checkin_prod_id type_checked checkin_count_<?php echo $checkInList->mvt_id; ?>" <?php if($checkInList->type_checked == 1){ echo "checked"; }?> name="select_all_row" value="<?php echo $checkInList->type_checked;?>">
														</div>
														<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 text_align_left paddingTop7px"><?php echo $checkInList->vehicle_type_name; ?></div>
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 paddingTop5px padding0px">&nbsp;cost</div>
														<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 padding0px ">
																<input type="text" name="default_cost" class="default_cost checkin_count_<?php echo $checkInList->mvt_id; ?> form-control" style="padding: 8px 4px;" value="<?php echo $checkInList->default_cost;?>">
														</div>
														<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 paddingTop5px padding0px">&nbsp;/hr</div>
													</div>
												</div>
												<?php } } ?>
											</div>
										</div>
									</div>
								</div>
								<div class="form_group" style="padding: 10px;margin-top: 30px;">
									<div class="col-sm-3 text-right">
										<label class="control-label string required"><?php _trans('lable723'); ?></label>
									</div>
									<div class="col-sm-9">
										<div>(<?php _trans('lable724'); ?>)</div>
										<div class="form_controls">
											<div class="form-group clearfix">
												<form class="upload" upload-id="upload_csv_add" id="upload_csv_add" method="post" enctype="multipart/form-data" autocomplete="off">
													<input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
													<div class="col-sm-6 paddingTop7px">
														<input type="file" id="workshop_logo" onchange="getfile()" class="inputTypeFile inputfile" name="workshop_logo" />
														<input type="hidden" id="fileName" name="fileName" value="" />
														<div id="showError" class="error" style="display:none;" ><?php _trans('lable181'); ?></div>
													</div>
												</form>
												<div class="col-sm-4 paddingTop7px" id="uploadedImage">
													<?php if ($workshop_details->workshop_logo) { ?>
													<img width="100%" height="100px" src="<?php echo base_url(); ?>uploads/workshop_logo/<?php echo $workshop_details->workshop_logo; ?>" />
													<a href="<?php echo site_url('workshop_setup/delete_log/').$workshop_id.'/'.$workshop_details->workshop_logo;?>" ><i class='fa fa-trash'></i> <?php _trans('lable47'); ?> </a>
													<?php } ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 form_group buttons text-center paddingTop40px">
								<button name="btn_submit" class="saveprofilebtn btn btn-rounded btn-primary btn-padding-left-right-40">
									<i class="fa fa-check"></i> <?php _trans('lable57'); ?>
								</button>
								<button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default">
									<i class="fa fa-times"></i> <?php _trans('lable58'); ?>
								</button>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade <?php echo $two_tab_active; ?>" id="tabs-2-tab-2">
							<div class="row">
								<div class="col-sm-12">
									<a style="margin-bottom: 15px; float: right" href="<?php echo site_url('workshop_branch/form/'); ?>"  class="btn btn-rounded"> <?php _trans('lable725'); ?></a>
								</div>
							</div>
							<section class="card">
								<div class="card-block">
								<div class="overflowScrollForTable">
									<table id="user_address_list" class="display table table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th><?php _trans('lable726'); ?></th>
												<th><?php _trans('lable61'); ?></th>
												<th><?php _trans('lable727'); ?></th>
												<th><?php _trans('lable728'); ?>.</th>
												<th><?php _trans('lable41'); ?></th>
												<th><?php _trans('lable22'); ?></th>
											</tr>	
										</thead>
										<tbody>
										<?php if(count($workshop_branch_list) > 0){
										       $i = 1;
										foreach ($workshop_branch_list as $branch_list) { 
											if(count($workshop_branch_list) >= 4)
											{    
												if(count($workshop_branch_list) == $i || count($workshop_branch_list) == $i+1)
												{
													$dropup1 = "dropup";

												}
												else
												{
													$dropup1 = "";
												}
											} 
											?>
											<tr>
												<td><a href="<?php echo site_url('workshop_branch/index/'.$branch_list->w_branch_id); ?>"><?php echo $branch_list->display_board_name; ?></a></td>
												<td><?php echo $branch_list->branch_street.', '.$branch_list->city_name.', '.$branch_list->state_name.', '.$branch_list->branch_pincode.', '.$branch_list->name; ?></td>
												<td><?php echo $branch_list->contact_person_name; ?></td>
												<td><?php echo $branch_list->branch_contact_no; ?></td>
												<td><?php echo $branch_list->branch_email_id; ?></td>
												<td>
													<div class="options btn-group <?php echo $dropup1; ?>">
														<a class="btn btn-default btn-sm dropdown-toggle"
														data-toggle="dropdown" href="#">
															<i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
														</a>
														<ul class="optionTag dropdown-menu">
															<li>
																<a href="<?php echo site_url('workshop_branch/form/'.$branch_list->w_branch_id); ?>">
																	<i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
																</a>
															</li>
															<li>
																<a href="javascript:void(0)" onclick="delete_record('workshop_branch',<?php echo $branch_list->w_branch_id; ?>, '<?= $this->security->get_csrf_hash() ?>')"> <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?></a>
															</li>
														</ul>
													</div>
												</td>
											</tr>	
											<?php $i++; } } ?>
										</tbody>
									</table>
									</div>
								</div>
							</section>
						</div>
						<div role="tabpanel" class="tab-pane fade <?php echo $three_tab_active; ?>" id="tabs-2-tab-3">
							<div class="row">
								<div class="col-sm-12">
									<a style="margin-bottom: 15px; float: right" href="javascript:void(0)" data-toggle="modal" data-module-type="B" data-bank-id="" data-target="#addBank" class="btn btn-rounded add_bank"><?php _trans('lable92'); ?></a>
								</div>
							</div>
							<?php if(count($workshop_bank_list) > 0){
							foreach ($workshop_bank_list as $bank) {  ?>
							<div class=" car-box-panel">
								<div class="row">
									<div class="col-sm-5">
										<div class="car-details-box col-xl-12 col=lg-12 col-md-12 col-sm-12 col-12 profile-box border-right">
										<div class="overflowScrollForTable" style="min-height: 150px;">
											<table class="car-table-box">
												<tbody>
													<tr>
														<th><strong><?php _trans('lable129'); ?></strong></th><td><?php if($bank->module_type=='W'){ echo "Workshop"; }elseif($bank->module_type=='B'){ echo "Branch - ".$bank->display_board_name; } ?></td>
													</tr>
													<tr>
														<th><strong><?php _trans('lable99'); ?></strong></th><td><?php echo $bank->bank_name; ?></td>
													</tr>
													<tr>
														<th><strong><?php _trans('lable95'); ?></strong></th><td><?php echo $bank->bank_branch; ?></td>
													</tr>
													<tr>
														<th><strong><?php _trans('lable100'); ?></strong></th><td><?php echo $bank->bank_ifsc_Code; ?></td>
													</tr>
													<tr>
														<th><strong><?php _trans('lable729'); ?></strong></th><td><?php echo $bank->current_balance; ?></td>
													</tr>
												</tbody>
											</table>
											</div>
										</div>
									</div>
									<div class="col-sm-5">
										<div class="car-details-box col-xl-12 col=lg-12 col-md-12 col-sm-12 col-12 profile-box">
										<div class="overflowScrollForTable" style="min-height: 150px;">
											<table class="car-table-box">
												<tbody>
													<tr>
														<th><strong><?php _trans('lable97'); ?></strong></th><td><?php echo $bank->account_holder_name; ?></td>
													</tr>
													<tr>
														<th><strong><?php _trans('lable101'); ?></strong></th><td><?php if($bank->account_type == '1'){ echo "Current"; }elseif($bank->account_type == '2'){ echo "Saving"; }elseif($bank->account_type == '3'){ echo "Others"; } ?></td>
													</tr>
													<tr>
														<th><strong><?php _trans('lable98'); ?></strong></th><td><?php echo $bank->account_number; ?></td>
													</tr>
													<tr>
														<th><strong><?php _trans('lable69'); ?></strong></th><td><?php if($bank->is_default == 'Y'){ echo "Yes"; }elseif($bank->is_default == 'N'){ echo "No"; } ?></td>
													</tr>
												</tbody>
											</table>
											</div>
										</div>
									</div>
									<div class="col-sm-2 pull-right text_align_right">
										<a href="javascript:void(0)" data-toggle="modal" data-module-type="B" data-target="#addBank" data-entity-id="0" data-bank-id="<?php echo $bank->bank_id; ?>" class="page-header-edit add_bank">
											<i class="fa fa-edit"></i>
										</a>
										<a href="javascript:void(0)" class="page-header-remove" onclick="remove_bank(<?php echo $bank->bank_id; ?>, '<?= $this->security->get_csrf_hash(); ?>')"><i class="fa fa-trash"></i></a>
									</div>
								</div>
							</div>
							<?php } }else{
								echo "No Data Found!...";
							} ?>
						</div>
						<div role="tabpanel" class="tab-pane fade <?php echo $four_tab_active; ?>" id="tabs-2-tab-4">
							<div class="row">
								<div class="col-sm-12">
								<?php if (!$creation_check->job_card_status || !$creation_check->quote_status || !$creation_check->invoice_status) {?>
									<a style="margin-bottom: 15px; float: right" href="<?php echo site_url('mech_invoice_groups/form'); ?>" id="generate_invoice_group" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> <?php _trans('lable40'); ?></a>
								<?php } ?>
								</div>
							</div>
							<section class="card">
								<div class="card-block">
								<div class="overflowScrollForTable">
									<table class="display table table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th class="text_align_center"><?php _trans('lable125'); ?></th>
												<th><?php _trans('lable50'); ?></th>
												<th class="text_align_center"><?php _trans('lable730'); ?></th>
												<th class="text_align_center"><?php _trans('lable731'); ?></th>
												<th><?php _trans('lable19'); ?></th>
												<th class="text_align_center"><?php _trans('lable22'); ?></th>
											</tr>
										</thead>
										<tbody>
										<?php
											$i = 1;
											foreach ($invoice_groups as $invoice_group) {
											  if(count($invoice_groups) >= 4)
												  {    
													if(count($invoice_groups) == $i || count($invoice_groups) == $i+1)
													{
														$dropup2 = "dropup";
													}
													else
													{
														$dropup2 = "";
													}
												}    
												?>
											<tr>
												<td class="text_align_center"><?php _htmlsc($i); ?></td>
												<td><?php _htmlsc($invoice_group->invoice_group_name); ?></td>
												<td class="text_align_center"><?php _htmlsc($invoice_group->invoice_group_next_id); ?></td>
												<td class="text_align_center"><?php _htmlsc($invoice_group->invoice_group_left_pad); ?></td>
											
												<td><?php if ($invoice_group->status == 'A') {
													echo 'Active';
												} elseif ($invoice_group->status == 'D') {
													echo 'Deactive';
												} elseif ($invoice_group->status == 'C') {
													echo 'Completed';
												} ?></td>
												<td class="text_align_center">
													<div class="options btn-group <?php echo $dropup2; ?>"> 
														<a class="btn btn-default btn-sm dropdown-toggle"
														data-toggle="dropdown" href="#">
															<i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
														</a>
														<ul class="optionTag dropdown-menu">
															<?php if ($invoice_group->status == 'A') {
													?>
																<li>
																<a onclick="update_status('C',<?php echo $invoice_group->invoice_group_id; ?>, '<?= $this->security->get_csrf_hash() ?>');" href="javascript:void(0)">
																	<i class="fa fa-edit fa-margin"></i> <?php _trans('lable732'); ?>
																</a>
																</li>
																<li>
																<a onclick="update_status('D',<?php echo $invoice_group->invoice_group_id; ?>, '<?= $this->security->get_csrf_hash() ?>');" href="javascript:void(0)">
																	<i class="fa fa-edit fa-margin"></i> <?php _trans('lable733'); ?>
																</a>
																</li>
															<?php
												} elseif ($invoice_group->status == 'D' && $get_count->{$invoice_group->module_type} < 2) {
													?>
																<li>
																<a onclick="update_status('A',<?php echo $invoice_group->invoice_group_id; ?>, '<?= $this->security->get_csrf_hash() ?>');" href="javascript:void(0)">
																	<i class="fa fa-edit fa-margin"></i> <?php _trans('lable669'); ?>
																</a>
																</li>
																<li>
																<a onclick="update_status('C',<?php echo $invoice_group->invoice_group_id; ?>, '<?= $this->security->get_csrf_hash() ?>');" href="javascript:void(0)">
																	<i class="fa fa-edit fa-margin"></i> <?php _trans('lable732'); ?>
																</a>
																</li>	
															<?php
												} ?>
															<li>
																<a href="<?php echo site_url('mech_invoice_groups/form/'.$invoice_group->invoice_group_id); ?>">
																	<i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
																</a>
															</li>
															<li>
																<a href="javascript:void(0)" onclick="delete_record('mech_invoice_groups',<?php echo $invoice_group->invoice_group_id; ?>, '<?= $this->security->get_csrf_hash() ?>')"> <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?></a>
															</li>
														</ul>
													</div>
												</td>
											</tr>
											<?php ++$i;
											} ?>
										</tbody>
									</table>
									</div>
								</div>
							</section>
						</div>
						<div role="tabpanel" class="tab-pane fade <?php echo $five_tab_active; ?>" id="tabs-2-tab-5">
							<div class="row">
								<div class="col-sm-12">
									<a style="margin-bottom: 15px; float: right" class="btn btn-sm btn-primary" href="<?php echo site_url('payment_methods/form'); ?>"><i class="fa fa-plus"></i> <?php _trans('lable40'); ?></a>
								</div>
							</div>
							<section class="card">
								<div class="card-block">
								<div class="overflowScrollForTable">
									<table class="display table table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th class="text_align_center"><?php _trans('lable109'); ?></th>
                        						<th class="text_align_center"><?php _trans('lable22'); ?></th>
											</tr>
										</thead>
										<tbody>
											<?php if(count($payment_methods) > 0){
												$i = 1;
												foreach ($payment_methods as $payment_method) { 
													if(count($payment_methods) >= 4)
													{    
														if(count($payment_methods) == $i || count($payment_methods) == $i+1)
														{
															$dropup3 = "dropup";
														}
														else
														{
															$dropup3 = "";
														}
													}    
													
													?>
											<tr>
												<td align="center"><?php _htmlsc($payment_method->payment_method_name); ?></td>
												<td align="center">
													<div class="options btn-group <?php echo $dropup3; ?>">
														<a class="btn btn-default btn-sm dropdown-toggle"
														data-toggle="dropdown" href="#">
															<i class="fa fa-cog"></i>
															<?php _trans('lable22'); ?>
														</a>
														<ul class="optionTag dropdown-menu">
															<li>
																<a href="<?php echo site_url('payment_methods/form/'.$payment_method->payment_method_id); ?>">
																	<i class="fa fa-edit fa-margin"></i>
																	<?php _trans('lable44'); ?>
																</a>
															</li>
															<li>
																<a href="javascript:void(0)" onclick="delete_record('payment_methods',<?php echo $payment_method->payment_method_id; ?>, '<?= $this->security->get_csrf_hash() ?>')"> <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?></a>
															</li>
														</ul>
													</div>
												</td>
											</tr>
											<?php $i++; } } else { echo '<tr><td colspan="2" class="text-center" > No Data Found!... </td></tr>'; } ?>
										</tbody>
									</table>
									</div>
								</div>
							</section>
						</div>
						<div role="tabpanel" class="tab-pane fade <?php echo $six_tab_active; ?>" id="tabs-2-tab-6">
							<div class="row">
								<div class="col-sm-12">
									<a style="margin-bottom: 15px; float: right" class="btn btn-sm btn-primary" href="<?php echo site_url('mech_referral/create'); ?>"><i class="fa fa-plus"></i> <?php _trans('lable40'); ?></a>
								</div>
							</div>
							<section class="card">
								<div class="card-block">
								<div class="overflowScrollForTable">
									<table class="display table datatable table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th class="text_align_center"><?php _trans('lable95'); ?></th>
												<th class="text_align_center"><?php _trans('lable734'); ?></th>
												<th class="text_align_center"><?php _trans('lable104'); ?></th>
												<th class="text_align_center"><?php _trans('lable175'); ?></th>
												<th class="text_align_center"><?php _trans('lable176'); ?></th>
												<th class="text_align_center"><?php _trans('lable22'); ?></th>
											</tr>
										</thead>
										<tbody>
											<?php if(count($mech_referrals) > 0) { 

												$i = 1;
												foreach ($mech_referrals as $referrals_list) { 
													if(count($mech_referrals) >= 4)
													{    
														if(count($mech_referrals) == $i || count($mech_referrals) == $i+1)
														{
															$dropup4 = "dropup";
														}
														else
														{
															$dropup4 = "";

														}
													} 
			
													?>
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
													<div class="options btn-group <?php echo $dropup4; ?>">
														<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
															<i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
														</a>
														<ul class="optionTag dropdown-menu">
															<li>
																<a href="<?php echo site_url('mech_referral/create/'.$referrals_list->mrefh_id); ?>">
																	<i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
																</a>
															</li>
															<li>
																<a href="javascript:void(0)" onclick="delete_record('mech_referral',<?php echo $referrals_list->mrefh_id; ?>, '<?= $this->security->get_csrf_hash() ?>')"> <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?></a>
															</li>
														</ul>
													</div>
												</td>
											</tr>
											<?php $i++; } } else { echo '<tr><td colspan="6" class="text-center"> No Data Found!... </td></tr>'; } ?>
										</tbody>
									</table>
									</div>
								</div>
							</section>
						</div>
						<div role="tabpanel" class="tab-pane fade <?php echo $nine_tab_active; ?>" id="tabs-2-tab-9">
						<div class="row">
								<div class="col-sm-12">
									<a style="margin-bottom: 15px; float: right" class="btn btn-sm btn-primary" href="<?php echo site_url('mech_rewards/create'); ?>"><i class="fa fa-plus"></i> <?php _trans('lable40'); ?></a>
								</div>
							</div>
							<section class="card">
								<div class="card-block">
								<div class="overflowScrollForTable">
								<table class="display table datatable table-bordered" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th class="text_align_center"><?php _trans('lable95'); ?></th>
											<th class="text_align_center"><?php _trans('lable734'); ?></th>
											<th class="text_align_center"><?php _trans('lable735'); ?></th>
											<th class="text_align_center"><?php _trans('lable104'); ?></th>
											<th class="text_align_center"><?php _trans('lable736'); ?></th>
											<th class="text_align_center"><?php _trans('lable22'); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php if(count($mech_rewards) > 0) {
											$i = 1;
										 foreach ($mech_rewards as $rewards_list) { 
											if(count($mech_rewards) >= 4)
											{    
												if(count($mech_rewards) == $i || count($mech_rewards) == $i+1)
												{
													$dropup5 = "dropup";
												}
												else
												{
													$dropup5 = "";
												}
											}    
											 
											 ?>
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
												<div class="options btn-group <?php echo $dropup5; ?>">
													<a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" href="#">
														<i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
													</a>
													<ul class="optionTag dropdown-menu">
														<li>
															<a href="<?php echo site_url('mech_rewards/create/'.$rewards_list->mrdlts_id); ?>">
																<i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
															</a>
														</li>
														<li>
															<a href="javascript:void(0)" onclick="delete_record('mech_rewards',<?php echo $rewards_list->mrdlts_id; ?>, '<?= $this->security->get_csrf_hash() ?>')"> <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?></a>
														</li>
													</ul>
												</div>
											</td>
										</tr>
										<?php $i++; } } else { echo '<tr><td colspan="6" class="text-center">No Data Found!... </td></tr>'; } ?>
									</tbody>
								</table>
								</div>
								</div>
							</section>
						</div>
						<div role="tabpanel" class="tab-pane fade <?php echo $seven_tab_active; ?>" id="tabs-2-tab-7">
							<div id="notification" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 car-box-panel">
								<div id="gif" class="gifload">
									<div class="gifcenter">
									<center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
									</div>
								</div>
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12"><h3><?php _trans('lable737'); ?></h3></div>
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop20px paddingLeftRight0px">
									<?php if(count($notification_list) > 0){  
									foreach ($notification_list as $notificationList){  
										$checked = "";
										$mnt_id = "";
										$notifi_status = "";
										foreach($notification_setup as $notificationSetup){
											if($notificationSetup->mnl_id == $notificationList->mnl_id && $notificationSetup->notify_type == "E"){
												$mnt_id = $notificationSetup->mnt_id;
												if($notificationSetup->notifi_status == 1){
													$checked = "checked";
													$notifi_status = $notificationSetup->notifi_status;
												}
											} 
										} ?>
									<div class="multi-field col-xl-12 col-lg-8 col-md-8 col-sm-8 col-xs-12">
										<div class="form-group clearfix">
											<div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-2 text_align_left paddingTop10px">
												<input type="checkbox" class="checkbox notifi_status" <?php echo $checked; ?> name="notifi_status" value="<?php echo $notifi_status;?>" >
												<input type="hidden" class="mnl_id" name="mnl_id" value="<?php echo $notificationList->mnl_id;?>" >
												<input type="hidden" class="notify_type" name="notify_type" value="<?php echo 'E';?>" >
												<input type="hidden" class="category_type" name="category_type" value="P" >
												<input type="hidden" class="mnt_id" name="mnt_id" value="<?php echo $mnt_id;?>" >
											</div>
											<div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-xs-7 text_align_left paddingTop7px"><?php echo $notificationList->noti_list_lable; ?></div>
										</div>
									</div>
									<?php } } ?>
								</div>
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop7px"><h3 class="paddingTop7px"><?php _trans('lable738'); ?></h3></div>
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop20px paddingLeftRight0px">
									<?php if(count($notification_list) > 0){  
									foreach ($notification_list as $notificationList){
										$checkeds = "";
										$mnt_ids = "";
										$notifi_statuss = "";
										foreach($notification_setup as $notificationSetup){
											if($notificationSetup->mnl_id == $notificationList->mnl_id && $notificationSetup->notify_type == "S" && $notificationSetup->category_type == "P"){
												$mnt_ids = $notificationSetup->mnt_id;
												if($notificationSetup->notifi_status == 1){
													$checkeds = "checked";
													$notifi_statuss = $notificationSetup->notifi_status;
												}
											} 
										}
										if($notificationList->noti_list_name == "job_card"){ ?>
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
												<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"><strong><?php echo $notificationList->noti_list_lable; ?></strong></div>
											</div>
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 paddingTop15px"></div>
											<?php foreach($jobcard_status as $jobcardStatus){ 
												$jobcard_checkeds = "";
												$mnt_jobcard_ids = "";
												$notifi_jobcard_status = "";
												foreach($notification_setup as $notificationSetup){
													if($notificationSetup->mnl_id == $jobcardStatus->jobcard_status_id && $notificationSetup->notify_type == "S" && $notificationSetup->category_type == "J"){
														$mnt_jobcard_ids = $notificationSetup->mnt_id;
														if($notificationSetup->notifi_status == 1){
															$jobcard_checkeds = "checked";
															$notifi_jobcard_status = $notificationSetup->notifi_status;
														}
													} 
												} ?>
												<div class="multi-field col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-12">
													<div class="form-group clearfix">
														<div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-2 text_align_left paddingTop10px">
															<input type="checkbox" class="checkbox notifi_status" name="notifi_status" <?php echo $jobcard_checkeds; ?> value="<?php echo $notifi_jobcard_status;?>" >
															<input type="hidden" class="mnl_id" name="mnl_id" value="<?php echo $jobcardStatus->jobcard_status_id; ?>" >
															<input type="hidden" class="category_type" name="category_type" value="J" >
															<input type="hidden" class="notify_type" name="notify_type" value="<?php echo 'S'; ?>" >
															<input type="hidden" class="mnt_id" name="mnt_id" value="<?php echo $mnt_jobcard_ids;?>" >
														</div>
														<div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-xs-7 text_align_left paddingTop7px"><?php echo $jobcardStatus->status_lable; ?></div>
													</div>
												</div>
											<?php } 
										}else if($notificationList->noti_list_name == "invoice"){ ?>
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
												<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"><strong><?php echo $notificationList->noti_list_lable; ?></strong></div>
											</div>
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 paddingTop15px"></div>
											<?php
											foreach($invoice_status as $invoiceStatus){ 
												$invoice_checkeds = "";
												$mnt_invoice_ids = "";
												$notifi_invoice_status = "";
												foreach($notification_setup as $notificationSetup){
													if($notificationSetup->mnl_id == $invoiceStatus->invoice_status_id && $notificationSetup->notify_type == "S" && $notificationSetup->category_type == "I"){
														$mnt_invoice_ids = $notificationSetup->mnt_id;
														if($notificationSetup->notifi_status == 1){
															$invoice_checkeds = "checked";
															$notifi_invoice_status = $notificationSetup->notifi_status;
														}
													} 
												} ?>
											<div class="multi-field col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-12">
												<div class="form-group clearfix">
													<div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-2 text_align_left paddingTop10px">
														<input type="checkbox" class="checkbox notifi_status" name="notifi_status" <?php echo $invoice_checkeds; ?> value="<?php echo $notifi_invoice_status;?>" >
														<input type="hidden" class="mnl_id" name="mnl_id" value="<?php echo $invoiceStatus->invoice_status_id; ?>" >
														<input type="hidden" class="category_type" name="category_type" value="I" >
														<input type="hidden" class="notify_type" name="notify_type" value="<?php echo 'S'; ?>" >
														<input type="hidden" class="mnt_id" name="mnt_id" value="<?php echo $mnt_invoice_ids;?>" >
													</div>
													<div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-xs-7 text_align_left paddingTop7px"><?php echo $invoiceStatus->status_lable; ?></div>
												</div>
											</div>
											<?php } ?>											
										<?php }else{ ?>
											<div class="multi-field col-xl-8 col-lg-8 col-md-8 col-sm-8 col-xs-12">
												<div class="form-group clearfix">
													<div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-2 text_align_left paddingTop10px">
														<input type="checkbox" data-lable="P" class="checkbox notifi_status" name="notifi_status" <?php echo $checkeds; ?> value="<?php echo $notifi_statuss;?>" >
														<input type="hidden" class="mnl_id" name="mnl_id" value="<?php echo $notificationList->mnl_id; ?>" >
														<input type="hidden" class="category_type" name="category_type" value="P" >
														<input type="hidden" class="notify_type" name="notify_type" value="<?php echo 'S'; ?>" >
														<input type="hidden" class="mnt_id" name="mnt_id" value="<?php echo $mnt_ids;?>" >
													</div>
													<div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-xs-7 text_align_left paddingTop7px"><?php echo $notificationList->noti_list_lable; ?></div>
												</div>
											</div>
										<?php } } } ?>
								</div>
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop7px paddingLeftRight0px">
									<div class="text-center">
										<button name="save_notification_settings" class="btn btn-primary" id="save_notification_settings" ><?php _trans('lable57'); ?></button>
									</div>
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade <?php echo $eight_tab_active; ?>" id="tabs-2-tab-8">
							<div class="row">
								<div class="col-sm-12">
									<a style="margin-bottom: 15px; float: right" class="btn btn-sm btn-primary" href="<?php echo site_url('email_templates/form'); ?>"><i class="fa fa-plus"></i> <?php _trans('lable40'); ?></a>
								</div>
							</div>
							<section class="card">
								<div class="card-block">
									<div class="headerbar-item pull-right">
										<?php echo pager(site_url('email_templates/index'), 'mdl_email_templates'); ?>
									</div>
									<div class="overflowScrollForTable">
									<table class="display table datatable table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th class="text_align_center"><?php _trans('lable496'); ?></th>
												<th class="text_align_center"><?php _trans('lable104'); ?></th>
												<th class="text_align_center"><?php _trans('lable22'); ?></th>
											</tr>
										</thead>
										<tbody>
											<?php if(count($email_templates) > 0) { 
										
												$i = 1;
												foreach ($email_templates as $email_template) { 
													if(count($email_templates) >= 4)
													{    
														if(count($email_templates) == $i || count($email_templates) == $i+1)
														{
															$dropup6 = "dropup";
														}
														else
														{
															$dropup6 = "";
														}
													}    
													
													?>
											<tr>
												<td class="text_align_center"><?php _htmlsc($email_template->email_template_title); ?></td>
												<td class="text_align_center"><?php if($email_template->email_template_type == 'I'){ echo "Invoice";}else if($email_template->email_template_type == 'J'){ echo "Job Card";}else if($email_template->email_template_type == 'A'){ echo "Appointment";} ?></td>
												<td class="text_align_center">
													<div class="options btn-group <?php echo $dropup6; ?>">
														<a class="btn btn-default btn-sm dropdown-toggle"
														data-toggle="dropdown" href="#">
															<i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
														</a>
														<ul class="optionTag dropdown-menu">
															<li>
																<a href="<?php echo site_url('email_templates/form/' . $email_template->email_template_id); ?>">
																	<i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
																</a>
															</li>
															<li>
																<a href="javascript:void(0)" onclick="delete_record('email_templates',<?php echo $email_template->email_template_id; ?>, '<?= $this->security->get_csrf_hash() ?>')"> <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?></a>
															</li>
														</ul>
													</div>
												</td>
											</tr>
											<?php  $i++; } } else { echo '<tr><td colspan="3" class="text-center" >No Data Found!... </td></tr>'; } ?>
										</tbody>
									</table>
									</div>
								</div>
							</section>
						</div>
						<div role="tabpanel" class="tab-pane fade <?php echo $tenth_tab_active; ?>" id="tabs-2-tab-10">
							<div class="row">
								<div class="col-sm-12">
									<a style="margin-bottom: 15px; float: right" href="<?php echo site_url('mech_vehicle_type/form'); ?>"  class="btn btn-rounded"> <?php _trans('lable876'); ?></a>
								</div>
							</div>
							<section class="card">
								<div class="card-block">
								<div class="overflowScrollForTable">
									<table id="user_address_list" class="display table table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th><?php _trans('lable78'); ?></th>
												<th class="text-center"><?php _trans('lable877'); ?></th>
												<th class="text-center"><?php _trans('lable22'); ?></th>
											</tr>	
										</thead>
										<tbody>
										<?php if(count($mech_vehicle_type_list) > 0){
										    $i = 1;
											foreach ($mech_vehicle_type_list as $mechVehicleTypeList) { 
											if(count($mech_vehicle_type_list) >= 4)
											{    
												if(count($mech_vehicle_type_list) == $i || count($mech_vehicle_type_list) == $i+1)
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
												<td><?php echo $mechVehicleTypeList->vehicle_type_name; ?></td>
												<td class="text-center"><?php echo $mechVehicleTypeList->vehicle_type_value; ?></td>
												<td class="text-center">
													<div class="options btn-group <?php echo $dropup; ?>">
														<a class="btn btn-default btn-sm dropdown-toggle"
														data-toggle="dropdown" href="#">
															<i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
														</a>
														<ul class="optionTag dropdown-menu">
															<li>
																<a href="<?php echo site_url('mech_vehicle_type/form/'.$mechVehicleTypeList->mvt_id); ?>">
																	<i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
																</a>
															</li>
															<li>
																<a href="javascript:void(0)" onclick="delete_record('mech_vehicle_type',<?php echo $mechVehicleTypeList->mvt_id; ?>, '<?= $this->security->get_csrf_hash() ?>')"> <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?></a>
															</li>
														</ul>
													</div>
												</td>
											</tr>	
											<?php $i++; } } else { echo '<tr><td colspan="4" class="text-center" > No Data Found!... </td></tr>'; } ?>
										</tbody>
									</table>
									</div>
								</div>
							</section>
						</div>
						<div role="tabpanel" class="tab-pane fade <?php echo $eleventh_tab_active; ?>" id="tabs-2-tab-11">
							<div class="row">
								<div class="col-sm-12">
									<h3><?php _trans('lable986'); ?></h3>         
									<a style="margin-bottom: 15px; float: right" class="btn btn-sm btn-primary" href="<?php echo site_url('tax_rates/form'); ?>"><i class="fa fa-plus"></i> <?php _trans('lable40'); ?></a>
								</div>
							</div>
							<section class="card">
								<div class="card-block">
									<div class="headerbar-item pull-right">
										<?php echo pager(site_url('tax_rates/index'), 'mdl_tax_rates'); ?>
									</div>
									<div class="overflowScrollForTable">
									
									<table class="display table datatable table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th class="text_align_left"><?php _trans('lable980'); ?></th>
												<th class="text_align_center"><?php _trans('lable981'); ?></th>
												<th class="text_align_left"><?php _trans('lable982'); ?></th>
												<th class="text_align_left"><?php _trans('lable983'); ?></th>
												<th class="text_align_center"><?php _trans('lable19'); ?></th>
												<th class="text_align_center"><?php _trans('lable22'); ?></th>
											</tr>
										</thead>
										<tbody>
											<?php if(count($tax_rates) > 0) { 
										
												$i = 1;
												foreach ($tax_rates as $tax_rate) { 
													if(count($tax_rates) >= 4)
													{    
														if(count($tax_rates) == $i || count($tax_rates) == $i+1)
														{
															$dropup7 = "dropup";
														}
														else
														{
															$dropup7 = "";
														}
													}    
													
													?>

											<tr>
												<td class="text_align_left"><?php _htmlsc($tax_rate->tax_rate_name); ?></td>
												<td class="text_align_center"><?php _htmlsc(round($tax_rate->tax_rate_percent)); ?> %</td>

												<td class="text_align_left"><?php echo implode(',', $tax_rate->module_name); ?></td>
												<td class="text_align_left"><?php if($tax_rate->apply_for == 'A'){ echo "After Discount";}else{ echo "Before Discount"; } ?></td>
												<td class="text_align_center"><?php if($tax_rate->status == 'A'){ echo "Active";}else{ echo "Inactive"; } ?></td>
												<td class="text_align_center">
													<div class="options btn-group <?php echo $dropup7; ?>">
														<a class="btn btn-default btn-sm dropdown-toggle"
														data-toggle="dropdown" href="#">
															<i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
														</a>
														<ul class="optionTag dropdown-menu">
															<li>
																<a href="<?php echo site_url('tax_rates/form/' . $tax_rate->tax_rate_id); ?>">
																	<i class="fa fa-edit fa-margin"></i> <?php _trans('lable44'); ?>
																</a>
															</li>
															<li>
																<a href="javascript:void(0)" onclick="delete_record('tax_rates',<?php echo $tax_rate->tax_rate_id; ?>, '<?= $this->security->get_csrf_hash() ?>')"> <i class="fa fa-trash-o fa-margin"></i> <?php _trans('lable47'); ?></a>
															</li>
														</ul>
													</div>
												</td>
											</tr>
											<?php  $i++; } } else { echo '<tr><td colspan="3" class="text-center" >No Data Found!... </td></tr>'; } ?>
										</tbody>
									</table>
									</div>
								</div>
							</section>
						</div>
						<div role="tabpanel" class="tab-pane fade <?php echo $twelve_tab_active; ?>" id="tabs-2-tab-12">
						<h3><?php _trans('lable1141'); ?></h3> 
							<section class="card">
								<div class="card-block">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<table class="display table table-bordered" cellspacing="0" style="width:60%;margin: 0px auto;">
											<h5 style="text-align:center;"><?php _trans('lable1139'); ?></h3>
											<tr style="background-color: #F8F9F9;">
											<th class="text_align_left"><?php _trans('lable1131'); ?></th>
											<td class="text_align_right"><strong><?php echo $sub_acplan_list->plan_type; ?></strong></td>
											</tr>
											<tr>
											<th class="text_align_left"><?php _trans('lable1132'); ?></th>
											<td class="text_align_right"><strong>
											<?php if($sub_acplan_list->plan_month_type == 1){
													echo trans('lable1135');}
												elseif($sub_acplan_list->plan_month_type == 3){
													echo trans('lable1136');}
												elseif($sub_acplan_list->plan_month_type == 6){
													echo trans('lable1137');} 
												elseif($sub_acplan_list->plan_month_type == 12){
													echo trans('lable1138');} ?>
											</strong></td>		
											</tr>
											<tr style="background-color: #F8F9F9;">
											<th class="text_align_left"><?php _trans('lable361'); ?></th>
											<td class="text_align_right"><strong><?php echo $sub_acplan_list->from_date?date_from_mysql($sub_acplan_list->from_date):date_from_mysql(date('Y-m-d')); ?></strong></td>
											</tr>
											<tr>
											<th class="text_align_left"><?php _trans('lable630'); ?></th>
											<td class="text_align_right"><strong><?php echo $sub_acplan_list->to_date?date_from_mysql($sub_acplan_list->to_date):date_from_mysql(date('Y-m-d')); ?></strong></td>
											</tr>
											<tr>
											<th class="text_align_left"><?php _trans('lable800'); ?></th>
											<td class="text_align_right"><strong><?php echo $sub_acplan_list->total_amount?$sub_acplan_list->total_amount:0; ?></strong></td>
											</tr>
										</table>
										<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop7px paddingLeftRight0px">
											<div class="text-center">
												<a href="<?php echo site_url('subscription_details/form'); ?>" id="up_renew" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> <?php _trans('lable1140'); ?></a>    
												<a target="_blank" href="<?php echo site_url('subscription_details/generate_pdf/' . $sub_acplan_list->subscription_id); ?>">
														<i class="fa fa-print fa-margin" aria-hidden="true"></i> <?php _trans('lable141'); ?>
													</a>   
											</div>
										</div>
									</div>				
							</div>
							</section>
							<section class="card">
								<div class="card-block">									
									<table class="display table datatable table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th class="text_align_left"><?php _trans('lable31'); ?></th>
												<th><?php _trans('lable1131'); ?></th>
												<th class="text_align_left"><?php _trans('lable1132'); ?></th>
												<th class="text_align_right"><?php _trans('lable800'); ?></th>
												<th class="text_align_left"><?php _trans('lable22'); ?></th>
											</tr>
										</thead>
										<tbody>
											<?php if(count($sub_deplan_list) > 0) { 
												$i = 1;
												foreach ($sub_deplan_list as $workshop_det) { 
											?>

											<tr>
												<td class="text_align_left"><?php echo $workshop_det->from_date?date_from_mysql($workshop_det->from_date):date_from_mysql(date('Y-m-d')); ?></td>
												<td class="text_align_left"><?php _htmlsc($workshop_det->plan_type); ?></td>
												<td class="text_align_left">
												<?php if($workshop_det->plan_month_type == 1){
														echo trans('lable1135');}
													elseif($workshop_det->plan_month_type == 3){
														echo trans('lable1136');}
													elseif($workshop_det->plan_month_type == 6){
														echo trans('lable1137');} 
													elseif($workshop_det->plan_month_type == 12){
														echo trans('lable1138');} ?>
												</td>
												<td class="text_align_right"><?php _htmlsc($workshop_det->total_amount?$workshop_det->total_amount:0); ?></td>
												<td>
													<a target="_blank" href="<?php echo site_url('subscription_details/generate_pdf/' . $workshop_det->subscription_id); ?>">
														<i class="fa fa-print fa-margin" aria-hidden="true"></i> <?php _trans('lable141'); ?>
													</a>
												</td>
											</tr>
											<?php  $i++; } } else { echo '<tr><td colspan="3" class="text-center" >No Data Found!... </td></tr>'; } ?>
										</tbody>
									</table>
									</div>
							</section>
						</div>
						<div role="tabpanel" class="tab-pane fade <?php echo $thirteen_tab_active; ?>" id="tabs-2-tab-13">
							<div class="row">
								<div class="col-sm-12">
									<a style="margin-bottom: 15px; float: right" href="javascript:void(0)" data-toggle="modal" data-model-from="tax" data-module-type="T" data-target="#addTax" class="btn btn-rounded add_tax"><?php _trans('lable1177'); ?></a>
								</div>
							</div>
							<section class="card">
								<div class="card-block">
								<div class="overflowScrollForTable">
									<table id="tax_list" class="display table table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th><?php _trans('lable1178'); ?></th>
												<th class="text-center"><?php _trans('lable1179'); ?></th>
												<th class="text-center"><?php _trans('lable1180'); ?></th>
												<th class="text-center"><?php _trans('lable22'); ?></th>
											</tr>	
										</thead>
										<tbody>
										<?php if(count($tax_list) > 0){
										    $i = 1;
											foreach ($tax_list as $tax) { ?>
											<tr>
												<td><?php echo $tax->tax_name; ?></td>
												<td class="text-center">
												    <?php if($tax->tax_type == 'S'){
														echo trans('lable335');  }
													elseif($tax->tax_type == 'G') {
														echo trans('lable1181');  } ?>
												</td>
												<td class="text-center"><?php echo $tax->tax_value; ?></td>
												<td class="text-center">
												<?php if($tax->workshop_id != 1) { ?>
													<div class="options btn-group <?php echo $dropup; ?>">
														<a class="btn btn-default btn-sm dropdown-toggle"
														data-toggle="dropdown" href="#">
															<i class="fa fa-cog"></i> <?php _trans('lable22'); ?>
														</a>
														<ul class="optionTag dropdown-menu">
															<li>
																<a href="javascript:void(0)" data-toggle="modal" data-module-type="T" data-target="#addTax" data-entity-id="0" data-tax-id="<?php echo $tax->tax_id; ?>" class="page-header-edit add_tax"><i class="fa fa-edit">&nbsp</i><?php _trans('lable44'); ?></a>
																<a href="javascript:void(0)" class="page-header-edit" onclick="remove_tax(<?php echo $tax->tax_id; ?>, '<?= $this->security->get_csrf_hash(); ?>')"><i class="fa fa-trash"></i>&nbsp<?php _trans('lable47'); ?></a>
															</li>
														</ul>
													</div>
												<?php } ?>
												</td>
											</tr>	
											<?php $i++; } } else { echo '<tr><td colspan="4" class="text-center" > No Data Found!... </td></tr>'; } ?>
										</tbody>
									</table>
									</div>
								</div>
							</section>
						</div>
					</div>
				</section>
			</div>
		</div>
    </div>
</div>
<script type="text/javascript">

var Emailinvalid = false;

function chkEmail(emailField){
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	if($("#workshop_email_id").val() != ''){
			if (reg.test(emailField.value) == false) 
			{
			Emailinvalid = true;
			if(emailField.value.length > 3){
				$('.emailIdErrorr').empty().append('Invalid Email Address');
			}
			return false;
			}else{
			Emailinvalid = false;
			$('.emailIdErrorr').empty().append('');
			return true;
			}
		}else{
		Emailinvalid = false;
		$('.emailIdErrorr').empty().append('');
		return true;
		}
	}

function getfile()
{
	var filename = $('input[type=file]').val().split("\\");
	$("#fileName").val(filename[2]);
	$("#showError").hide();
	var fileNameone;
	var fileExtensionone;

	fileNameone = filename[2];
	fileExtensionone = fileNameone.replace(/^.*\./, '');

	if(fileExtensionone != 'jpeg' && fileExtensionone != 'JPEG' && 
			fileExtensionone != 'png' && fileExtensionone != 'PNG' &&
			fileExtensionone != 'jpg' && fileExtensionone != 'JPG' &&
			fileExtensionone != 'gif' && fileExtensionone != 'GIF' &&
			fileExtensionone != 'tiff' && fileExtensionone != 'TIFF' &&
			fileExtensionone != 'pdf' && fileExtensionone != 'PDF' &&
			fileExtensionone != 'bmp' && fileExtensionone != 'BMP' &&
			fileExtensionone != 'tif' && fileExtensionone != 'TIF' && fileExtensionone != ''){
			$('#showError').empty().append('Invalid File Format');
			$('#showError').show();
			return false;
	}else{
		$('#showError').empty().append('');
		$('#showError').hide();
	}
	$(".upload").submit();
}


$(document).ready(function() {

	$(document).on('submit', ".upload", function (e) {

		$('#fileError').empty();

		$('#showError').empty().append('');
		$('#showError').hide();

		if($("#fileName").val() == ''){
			$('#showError').empty().append('Please choose the file');
			$('#showError').show();
			return false;
		}else{
			var imagesplit = $("#fileName").val();
			if(imagesplit){
				extension = imagesplit.split(".");
				if(extension.length > 2){
					$('#showError').empty().append('Please rename the file name');
					$('#showError').show();
					return false;
				}else{
					$('#showError').empty().append('');
					$('#showError').hide();
				}
			}else{
				$('#showError').empty().append('');
				$('#showError').hide();
			}
			
		}

		e.preventDefault();
		e.stopPropagation();

		$.ajax({
			url : "<?php echo site_url('workshop_setup/ajax/upload_file/'.$workshop_id); ?>/",
			method:"POST",
			data : new FormData(this),
			contentType:false,
			cache:false,
			processData:false,
			success: function(data){
				var response = JSON.parse(data);
				if(response.success =='1' || response.success == 1){
					var html = '';
					html += '<img width="100%" height="100px" src="<?php echo base_url(); ?>uploads/workshop_logo/'+response.temp_file_name.workshop_logo+'" />';
					html += '<a href="<?php echo site_url('workshop_setup/delete_log/').$workshop_id.'/'; ?>'+response.temp_file_name.workshop_logo+'" ><i class="fa fa-trash"></i> Delete </a>';
					$("#uploadedImage").empty().append(html);
				}else if(response.success == '0' || response.success == 0){
					$('#showError').empty().append(response.msg);
				}
			}
		});
	});

	$(".notifi_status").change(function(){
	   	if($(this).prop("checked") == true){
			$(this).val('1');
	 	}else{
			$(this).val('0');
	  	}
	});	

	$("#save_notification_settings").click(function(){
		var notifications = [];
		
		$("#notification .multi-field").each(function(){
			var requestObj = {};
			requestObj.mnt_id = $(this).find(".mnt_id").val();
			requestObj.mnl_id = $(this).find(".mnl_id").val();
			requestObj.category_type = $(this).find(".category_type").val();
			requestObj.notify_type = $(this).find(".notify_type").val();
			requestObj.notifi_status = $(this).find(".notifi_status").val();
			notifications.push(requestObj);
		});

		$('#gif').show();
		$.post('<?php echo site_url('workshop_setup/ajax/addnotificationSetting'); ?>', {
            notifications: JSON.stringify(notifications),
			_mm_csrf: $('#_mm_csrf').val()
        }, function (data) {
            list = JSON.parse(data);
            if(list.success=='1'){
            	notie.alert(1, 'Successfully Created', 3);
				setTimeout(function(){
					window.location = "<?php echo site_url('workshop_setup/index/7'); ?>";
				}, 100);
            }else{
				$('#gif').hide();
				notie.alert(3, 'Oops, something has gone wrong', 2);
            }
        });

	});

	$("#btn_cancel").click(function () {
		window.location.href = "<?php echo site_url('dashboard'); ?>";
	});

	$("#service_cost_setup").change(function(){
		if($("#service_cost_setup").val() == 1){
			$("#bodyType").show();
		}else{
			$("#bodyType").hide();
		}
	});

	$(".select_all_row").change(function(){
		var id = $(this).attr('id');
	   	if($(this).prop("checked") == true){
	   		$("#"+id).val(1);
	 	}else{
			$("#"+id).val(2);
	  	}
	});

	$(".saveprofilebtn").click(function () {

		var vehicleType = [];
		
		$("#checkinListDatas .multi-field").each(function(){
			var requestObj = {};
			requestObj.mvt_id = $(this).find(".mvt_id").val();
			requestObj.type_checked = $(this).find(".type_checked").val();
			requestObj.default_cost = $(this).find(".default_cost").val();
			vehicleType.push(requestObj);
		});

		var validation= [];

		if($("#workshop_name").val() == ''){
			validation.push('workshop_name');
		}

		if($("#owner_name").val() == ''){
			validation.push('owner_name');
		}

		if($("#service_cost_setup").val() == ""){
			validation.push('service_cost_setup');
		}

		if($("#workshop_contact_no").val() == ''){
			validation.push('workshop_contact_no');
		}

		if($("#workshop_street").val() == ''){
			validation.push('workshop_street');
		}

		if($("#workshop_country").val() == ""){
			validation.push('workshop_country');
		}

		if($("#workshop_state").val() == ""){
			validation.push('workshop_state');
		}
		
		if($("#workshop_city").val() == ""){
			validation.push('workshop_city');
		}
		
		if($("#workshop_pincode").val() == ""){
			validation.push('workshop_pincode');
		}

		if($("#registration_type").val() == ""){
			validation.push('registration_type');
		}

		if($("#total_employee_count").val() == ""){
			validation.push('total_employee_count');
		}

		if($("#since_from").val() == ""){
			validation.push('since_from');
		}

		if($("#is_mobileapp_enabled").val() == ""){
			validation.push('is_mobileapp_enabled');
		}

		if($("#workshop_is_enabled_inventory").val() == ""){
			validation.push('workshop_is_enabled_inventory');
		}

		if($("#workshop_is_enabled_jobsheet").val() == ""){
			validation.push('workshop_is_enabled_jobsheet');
		}

		if(is_new_user == "N"){
			if($("#pos").val() == ""){
				validation.push('pos');
			}
			if($("#shift").val() == ""){
				validation.push('shift');
			}
			if($("#default_currency_id").val() == ""){
				validation.push('default_currency_id');
			}
			if($("#default_date_id").val() == ""){
				validation.push('default_date_id');
			}
		}

		if(validation.length > 0){
			validation.forEach(function(val) {
				$('#'+val).addClass("border_error");
				if($('#'+val+'_error').length == 0){
					$('#' + val).parent().addClass('has-error');
				} 
			});
			return false;
		}

		if($("#workshop_email_id").val() != ''){
			if(Emailinvalid){
				$('.emailIdErrorr').empty().append('Invalid Email Address');
				$("#workshop_email_id").focus();
				return false;
			}
		}
		
		$('#gif').show();

		$.post('<?php echo site_url('workshop_setup/ajax/create'); ?>', {
			workshop_id : $("#workshop_id").val(),
			service_cost_setup : $("#service_cost_setup").val()?$("#service_cost_setup").val():'',
			is_update : $("#is_update").val(),
			workshop_name : $('#workshop_name').val(),
			is_mobileapp_enabled : $("#is_mobileapp_enabled").val(),
			owner_name : $("#owner_name").val(),
			workshop_contact_no : $("#workshop_contact_no").val(),
			workshop_email_id : $("#workshop_email_id").val(),
			workshop_street : $('#workshop_street').val(),
			workshop_country : $('#workshop_country').val(),
			workshop_state : $('#workshop_state').val(),
			workshop_city : $('#workshop_city').val(),
			workshop_pincode: $('#workshop_pincode').val(),
			registration_type : $('#registration_type').val(),
			registration_number : $("#registration_number").val(),
			workshop_gstin : $('#workshop_gstin').val(),
			total_employee_count : $('#total_employee_count').val(),
			since_from : $('#since_from').val(),
			vehicleType: JSON.stringify(vehicleType),
			workshop_is_enabled_inventory : $("#workshop_is_enabled_inventory").val(),
			workshop_is_enabled_jobsheet : $('#workshop_is_enabled_jobsheet').val(),
			default_currency_id : $("#default_currency_id").val()?$("#default_currency_id").val():'',
			is_product : $("#is_product").val()?$("#is_product").val():'',
			pos : $("#pos").val()?$("#pos").val():'',
			shift : $("#shift").val()?$("#shift").val():'',
			default_date_id : $("#default_date_id").val()?$("#default_date_id").val():'',
			btn_submit : $(this).val(),
			_mm_csrf: $('#_mm_csrf').val()
		}, function (data) {
			list = JSON.parse(data);
			if(list.success=='1'){
				notie.alert(1, 'Successfully Created', 2);
				setTimeout(function(){
					window.location = "<?php echo site_url('workshop_setup'); ?>";
				}, 100);
			}else{
				$('#gif').hide();
				notie.alert(3, 'Oops, something has gone wrong', 2);
				$('.has-error').removeClass('has-error');
				for (var key in list.validation_errors) {
					$('#' + key).parent().addClass('has-error');
					$('.error_msg_' + key).show().empty().html(list.validation_errors[key]);
				}
			}
		});
	});
});
</script>