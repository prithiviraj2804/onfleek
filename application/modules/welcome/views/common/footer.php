<footer id="footer-style-1">
    	<div class="container">
        	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            	<div class="widget">
                    <div class="">
                        <h3 class="footer-logo"><img class="hidden-md-down" src="<?php echo base_url(); ?>assets/mp_backend/img/mechtoolz-logo.svg" width="167" height="41px" alt="MechToolz"></h3>
                    </div>
                	<p>We are team of highly talented professionals with multi years of experience in Automotive technology catering to various aspects of business.</p>
                    <div class="social-icons">
                        <span><a data-toggle="tooltip" data-placement="bottom" title="Facebook" href="#"><i class="fa fa-facebook"></i></a></span>
                        <span><a data-toggle="tooltip" data-placement="bottom" title="Twitter" href="#"><i class="fa fa-twitter"></i></a></span>
                        <span><a data-toggle="tooltip" data-placement="bottom" title="Youtube" href="#"><i class="fa fa-youtube"></i></a></span>
                        <span><a data-toggle="tooltip" data-placement="bottom" title="Linkedin" href="#"><i class="fa fa-linkedin"></i></a></span>
                    </div><!-- end social icons -->
                </div><!-- end widget -->
            </div><!-- end columns -->
        	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            	<div class="widget">
                	<div class="title">
                        <h3>Quick Links</h3>
                    </div><!-- end title -->
                    <ul class="quick_links">
                        <li><a href="<?php echo site_url('welcome/about'); ?>">ABOUT US</a></li>
                        <li><a href="javascript:void(0)">SUPPORT</a></li>
                        <li><a href="javascript:void(0)">PRIVACY POLICY</a></li>
                        <li><a href="javascript:void(0)">TERMS &amp; CONDITIONS</a></li>
                    </ul><!-- end twiteer_feed --> 
                </div><!-- end widget -->
            </div><!-- end columns -->
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            	<div class="widget">
                	<div class="title">
                        <h3>Contact Info</h3>
                    </div><!-- end title -->
                    <ul class="quick_links">
                        <li><i class="fa fa-map-marker-alt"></i>No.236, Gandhi Nagar, I A F Road,</li>
                        <li> Selaiyur, Chennai - 600073</li>
                        <li>support@mechtoolz.com</li>
                        <li>(+91) 98840 44724</li>
                    </ul><!-- end twiteer_feed --> 
                </div><!-- end widget -->
            </div><!-- end columns -->
    	</div><!-- end container -->
    </footer><!-- end #footer-style-1 -->    

<div id="copyrights">
    	<div class="container">
			<div class="col-lg-12 col-md-12 col-sm-12">
            	<div class="copyright-text">
                    <p>Copyright © 2018 MechToolz Powered by Onfleek media and technologies pvt ltd</p>
                </div><!-- end copyright-text -->
			</div><!-- end widget -->
			
        </div><!-- end container -->
    </div><!-- end copyrights -->
    
	<div class="dmtop">Scroll to Top</div>
        
  <!-- Main Scripts-->
  <script src="<?php echo base_url(); ?>assets/fv1/js/jquery.js"></script>
  <script src="<?php echo base_url(); ?>assets/fv1/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/fv1/js/menu.js"></script>
  <script src="<?php echo base_url(); ?>assets/fv1/js/owl.carousel.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/fv1/js/jquery.parallax-1.1.3.js"></script>
  <script src="<?php echo base_url(); ?>assets/fv1/js/jquery.simple-text-rotator.js"></script>
  <script src="<?php echo base_url(); ?>assets/fv1/js/wow.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/fv1/js/custom.js"></script>
  
  <script src="<?php echo base_url(); ?>assets/fv1/js/jquery.isotope.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/fv1/js/custom-portfolio.js"></script>

  <!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/fv1/rs-plugin/js/jquery.themepunch.plugins.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/fv1/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
  <script type="text/javascript">
	var revapi;
	jQuery(document).ready(function() {
		revapi = jQuery('.tp-banner').revolution(
		{
			delay:9000,
			startwidth:1170,
			startheight:500,
			hideThumbs:10,
			fullWidth:"on",
			forceFullWidth:"on"
		});
	});	//ready
  </script>
      
  <!-- Royal Slider script files -->
  <script src="<?php echo base_url(); ?>assets/fv1/royalslider/jquery.easing-1.3.js"></script>
  <script src="<?php echo base_url(); ?>assets/fv1/royalslider/jquery.royalslider.min.js"></script>
  <script>
	jQuery(document).ready(function($) {
	  var rsi = $('#slider-in-laptop').royalSlider({
		autoHeight: false,
		arrowsNav: false,
		fadeinLoadedSlide: false,
		controlNavigationSpacing: 0,
		controlNavigation: 'bullets',
		imageScaleMode: 'fill',
		imageAlignCenter: true,
		loop: false,
		loopRewind: false,
		numImagesToPreload: 6,
		keyboardNavEnabled: true,
		autoScaleSlider: true,  
		autoScaleSliderWidth: 486,     
		autoScaleSliderHeight: 315,
	
		/* size of all images http://help.dimsemenov.com/kb/royalslider-jquery-plugin-faq/adding-width-and-height-properties-to-images */
		imgWidth: 792,
		imgHeight: 479
	
	  }).data('royalSlider');
	  $('#slider-next').click(function() {
		rsi.next();
	  });
	  $('#slider-prev').click(function() {
		rsi.prev();
	  });
	});
  </script>

  
	<!-- FlexSlider JavaScript
    ================================================== -->
    <script src="<?php echo base_url(); ?>assets/fv1/js/jquery.flexslider.js"></script>
	<script>
	(function($) {
	  "use strict";
        $(window).load(function() {
            $('#aboutslider').flexslider({
                animation: "fade",
                controlNav: true,
                animationLoop: true,
                slideshow: true,
                sync: "#carousel"
            });
        });
	})(jQuery);
    </script>
    
  
  </body>
</html>