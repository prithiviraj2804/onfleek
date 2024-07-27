<?php $this->load->view('common/header'); ?>
<?php $this->load->view('common/head_menu'); ?>
<section class="post-wrapper-top jt-shadow clearfix">
		<div class="container">
			<div class="col-lg-12">
				<h2>Contact us</h2>
                <ul class="breadcrumb pull-right">
                    <li><a href="<?php echo base_url(); ?>">Home</a></li>
                    <li>Contact us</li>
                </ul>
			</div>
		</div>
	</section><!-- end post-wrapper-top -->

    <section class="white-wrapper">
        <div class="container">
            <div class="general-title">
                <h2>Contact Us</h2>
                <hr>
                <p class="lead">We provide best solution for your business</p>
            </div><!-- end general title -->    
            <div class="contact_form">
                <div id="message"></div>
            <form id="contactform" action="contact.php" name="contactform" method="post">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<input type="text" name="name" id="name" class="form-control" placeholder="Name"> 
					<input type="text" name="email" id="email" class="form-control" placeholder="Email Address">
					<input type="text" name="website" id="website" class="form-control" placeholder="Website"> 
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<input type="text" name="subject" id="subject" class="form-control" placeholder="Subject">  
					<textarea class="form-control" name="comments" id="comments" rows="6" placeholder="Message"></textarea>
					<button type="submit" value="SEND" id="submit" class="btn btn-lg btn-primary pull-right">GET A QUOTE</button>
				</div>
            </form>    
            </div><!-- end contact-form -->
        </div><!-- end container -->
	</section><!-- end map wrapper -->

        <div class="clearfix"></div>
        <div class="clearfix"></div>

	<section id="one-parallax" class="parallax" style="background-image: url('<?php echo base_url(); ?>assets/fv1/demos/parallax_06.jpg');" data-stellar-background-ratio="0.6" data-stellar-vertical-offset="20">
		<div class="overlay">
            <div class="container">
                <div class="row padding-top margin-top">
                    <div class="contact_details">
                        <div class="col-lg-4 col-sm-4 col-md-6 col-xs-12">
                            <div class="text-center">
                                <div class="wow swing">
                                    <div class="contact-icon">
                                        <a href="#" class=""> <i class="fa fa-map-marker fa-3x"></i> </a>
                                    </div><!-- end dm-icon-effect-1 -->
                                     <p>No.236, Gandhi Nagar, I A F Road,<br>
                                        Selaiyur, Chennai - 600073</p>
                                </div><!-- end service-icon -->
                            </div><!-- end miniboxes -->
                        </div><!-- end col-lg-4 -->
                        
                        <div class="col-lg-4 col-sm-4 col-md-6 col-xs-12">
                            <div class="text-center">
                                <div class="wow swing">
                                    <div class="contact-icon">
                                        <a href="#" class=""> <i class="fa fa-phone fa-3x"></i> </a>
                                    </div><!-- end dm-icon-effect-1 -->
                                     <p><strong>Phone:</strong> (+91) 98840 44724</p>
                                </div><!-- end service-icon -->
                            </div><!-- end miniboxes -->
                        </div><!-- end col-lg-4 -->  
        
                        <div class="col-lg-4 col-sm-4 col-md-6 col-xs-12">
                            <div class="text-center">
                                <div class="wow swing">
                                    <div class="contact-icon">
                                        <a href="#" class=""> <i class="fa fa-envelope-o fa-3x"></i> </a>
                                    </div><!-- end dm-icon-effect-1 -->
                                     <p><strong>Email:</strong> support@mechtoolz.com</p>
                                </div><!-- end service-icon -->
                            </div><!-- end miniboxes -->
                        </div><!-- end col-lg-4 -->                  
                    </div><!-- end contact_details -->
                </div><!-- end margin-top --><br><br>
            </div><!-- end container -->
        </div><!-- end overlay -->
    </section><!-- end map wrapper -->
<?php $this->load->view('common/footer'); ?>