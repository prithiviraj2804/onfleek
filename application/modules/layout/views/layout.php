<!doctype html lang="<?php _trans('cldr'); ?>">

<!--[if lt IE 7]>
<html class="no-js ie6 oldie" lang="<?php _trans('cldr'); ?>"> <![endif]-->
<!--[if IE 7]>
<html class="no-js ie7 oldie" lang="<?php _trans('cldr'); ?>"> <![endif]-->
<!--[if IE 8]>
<html class="no-js ie8 oldie" lang="<?php _trans('cldr'); ?>"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="<?php _trans('cldr'); ?>"> <!--<![endif]-->

<head lang="<?php _trans('cldr'); ?>">
<?php
    // Get the page head content
    $this->layout->load_view('layout/includes/head');
    ?>

</head>
<body class="with-side-menu control-panel control-panel-compact <?php if( ($this->router->fetch_class() ==  "mech_leads" && $this->router->fetch_method() == "form") || ($this->router->fetch_class() ==  "mech_appointments" && $this->router->fetch_method() == "form") || $this->router->fetch_class() == "mech_invoices" || $this->router->fetch_class() == "mech_purchase_order"|| $this->router->fetch_class() == "mech_work_order_dtls" || $this->router->fetch_class() == "mech_quotes" || $this->router->fetch_class() == "mech_pos_invoices" || $this->router->fetch_class() == "mech_purchase" || $this->router->fetch_class() == "mech_expense" || $this->router->fetch_class() == "workshop_setup" || $this->router->fetch_class() == "mech_leads" || $this->router->fetch_class() == "mech_appointments" || $this->session->userdata('is_new_user') == 'N') { echo "sidebar-hidden"; } ?>" >
<noscript>
    <div class="alert alert-danger no-margin"><?php _trans('please_enable_js'); ?></div>
</noscript>
<?php
// Get the navigation bar
$this->layout->load_view('layout/includes/navbar');
?>

	<div class="mobile-menu-left-overlay"></div>
	<?php
// Get the navigation bar
$this->layout->load_view('layout/includes/sidebar');
?>

	<div class="page-content">
	    
	    	<?php echo $content; ?>
	        
	</div><!--.page-content-->
<div id="modal-placeholder"></div>
<div id="modal-placeholder-two"></div>
	

	<?php
// Get the navigation bar
$this->layout->load_view('layout/includes/footer');

?>
<script type="text/javascript">

$("#show-hide-sidebar-toggle").click(function() {
  var windowlength = $( window ).width();
  if(windowlength <= 768){
    if($('.with-side-menu').hasClass('sidebar-hidden')){
      $(".makeFixed").css('left','239px');
      $(".makeFixed").css('width','162px');
      $(".usermanagement .tabs-section-nav").css('width','162px');
    }else{
      $(".makeFixed").css('left','0px');
      $(".makeFixed").css('width','306px');
      $(".usermanagement .tabs-section-nav").css('width','306px');
    }
  }else if(windowlength >= 1024){
    if($('.with-side-menu').hasClass('sidebar-hidden')){
      $(".makeFixed").css('left','239px');
      $(".makeFixed").css('width','240px');
      $(".usermanagement .tabs-section-nav").css('width','240px');
    }else{
      $(".makeFixed").css('left','0px');
      $(".makeFixed").css('width','306px');
      $(".usermanagement .tabs-section-nav").css('width','306px');
    }
  }else{
    if($('.with-side-menu').hasClass('sidebar-hidden')){
      $(".makeFixed").css('left','239px');
      $(".makeFixed").css('width','260px');
      $(".usermanagement .tabs-section-nav").css('width','260px');
    }else{
      $(".makeFixed").css('left','0px');
      $(".makeFixed").css('width','306px');
      $(".usermanagement .tabs-section-nav").css('width','306px');
    }
  }
});



window.onscroll = function() {
var currentScrollPos = window.pageYOffset;
var windowlength = $( window ).width();
if(windowlength <= 768){
  if (currentScrollPos > 100) {
	  $(".usermanagement .tabs-section-nav").addClass('makeFixed');
      if($('.with-side-menu').hasClass('sidebar-hidden')){
        $(".makeFixed").css('width','306px');
      }else{
        $(".makeFixed").css('width','162px');
      }
    } else {
      $(".usermanagement .tabs-section-nav").removeClass('makeFixed');
      if($('.with-side-menu').hasClass('sidebar-hidden')){
        $(".usermanagement .tabs-section-nav").css('width','306px');
      }else{
        $(".usermanagement .tabs-section-nav").css('width','162px');
      }
    }
  }else if(windowlength >= 1024){
    if (currentScrollPos > 100) {
	  $(".usermanagement .tabs-section-nav").addClass('makeFixed');
      if($('.with-side-menu').hasClass('sidebar-hidden')){
        $(".makeFixed").css('width','306px');
      }else{
        $(".makeFixed").css('width','240px');
      }
    } else {
      $(".usermanagement .tabs-section-nav").removeClass('makeFixed');
      if($('.with-side-menu').hasClass('sidebar-hidden')){
        $(".usermanagement .tabs-section-nav").css('width','306px');
      }else{
        $(".usermanagement .tabs-section-nav").css('width','240px');
      }
    }
  }else{
    if (currentScrollPos > 100) {
      $(".usermanagement .tabs-section-nav").addClass('makeFixed');
      if($('.with-side-menu').hasClass('sidebar-hidden')){
        $(".makeFixed").css('width','306px');
      }else{
        $(".makeFixed").css('width','260px');
      }
    } else {
      $(".usermanagement .tabs-section-nav").removeClass('makeFixed');
      if($('.with-side-menu').hasClass('sidebar-hidden')){
        $(".usermanagement .tabs-section-nav").css('width','306px');
      }else{
        $(".usermanagement .tabs-section-nav").css('width','260px');
      }
    }
  }
}
</script>
</body>
</html>