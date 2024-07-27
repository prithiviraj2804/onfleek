<?php $this->load->view('common/header'); ?>
    <?php $this->load->view('common/head_menu'); ?>

    <section class="post-wrapper-top jt-shadow clearfix">
		<div class="container">
			<div class="col-lg-12">
				<h2>About us</h2>
                <ul class="breadcrumb pull-right">
                    <li><a href="<?php echo base_url(); ?>">Home</a></li>
                    <li>About</li>
                </ul>
			</div>
		</div>
	</section><!-- end post-wrapper-top -->


	<section class="white-wrapper">
		<div class="container">
        	<div class="row">
            	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="widget margin-top">
                        <div id="aboutslider" class="flexslider clearfix">
                            <ul class="slides">
                                <li><img src="<?php echo base_url(); ?>assets/fv1/images/about_mini_01.jpg" class="img-responsive" alt=""></li>
                            </ul><!-- end slides -->
                        </div><!-- end slider -->
                    </div><!-- end widget -->
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="widget">
                        <h3>WHAT WE CAN OFFER YOU?</h3>
                        <p>We are team of highly talented professionals with multi years of experience in Automotive technology catering to various aspects of business.</p>
                        <p>Mechtoolz is multi utility tool which helps its users to concentrate on business taking care of day to day work management of garage. It manages the workshop easily without any delays in delivery, effective work control, responsibility & tracking of car service history in case of complaints, work delegation & GST compliant. It’s a first of its kind - end to end business management tool for garage. </p>
                        <div class="clearfix"></div>
                        <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h4>Ease of use advanced benefits</h4>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 first">
                            <ul class="check">
                                <li>Simple click GST invoice creation from Repair Orders and Estimates</li>
                                <li>Preset Invoices, create new invoices from previously saved details</li>
                                <li>Easy Work Order creation, clock-in and clock-out of jobs</li>
                                <li>Detailed customer and Vehicle records </li>
                                <li>Effective customers management email service reminders</li>
                                <li>Get detailed sales overview effective for GST filing</li>
                            </ul><!-- end check -->
                        </div><!-- end col-lg-12 --> 
                        </div><!-- end row -->      
                    </div><!-- end widget -->
                </div><!-- end col-lg-6 -->
			</div><!-- end row --><br>
		</div><!-- end container -->
	</section><!-- end postwrapper -->
    <!-- start footer -->
    <?php $this->load->view('common/footer'); ?>