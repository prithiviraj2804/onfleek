<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Digital Garage Management software | MechTooz</title>
    <meta name="description" content="MechToolz is a Garage Management application is designed with smart features to manage your workshop easier. Our goal is to automate, enhance & go digital.">
    <meta name="keywords" content="Workshop Software, Automotive Workshop Software, Car Service Management system, Digital Job Card, Digital Job Sheet, Workshop Customer Management, Workshop Vehicle Management, Workshop Supplier Management, Parts and Inventory Management">
    <meta name="author" content="OnfleekMT">

	<?php /* * / ?>
	<link href="<?php echo base_url(); ?>assets/mp_backend/img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="<?php echo base_url(); ?>assets/mp_backend/img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
	<link href="<?php echo base_url(); ?>assets/mp_backend/img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
	<link href="<?php echo base_url(); ?>assets/mp_backend/img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
	<?php / * */ ?>
	<link href="<?php echo base_url(); ?>assets/mp_backend/img/favicon-32x32.png" rel="icon" type="image/png">
	<link href="<?php echo base_url(); ?>assets/mp_backend/img/favicon.ico" rel="shortcut icon">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/separate/pages/login.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/main.css">
</head>
<!-- <style>
	body{
		background: url(../../assets/mm_fe_latest/images/slider/slide1.jpg);
		background-size: cover;
	}
</style> -->
<body>
<?php /* * / ?><img src="<?php echo base_url(); ?>/assets/mm_fe_latest/images/mm_custom/mechpoint.svg" alt="MechPoint"><?php / * */ ?>
    <div class="page-center">
        <div class="page-center-in">
            <div id="gif" class="gifload">
                <div class="gifcenter">
                <center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
                </div>
            </div>
            <div class="container-fluid">
                <form class="sign-box" form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="col-xl-9 col-lg-9 col-md-8 col-sm-8 hidden-xs-down">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                <img style="width: 100%; float:left;" src="<?php echo base_url(); ?>assets/mp_backend/img/mechtoolzsignuptwo.jpg" alt="Mechtoolz">
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                <img style="width: 100%; float:left;" src="<?php echo base_url(); ?>assets/mp_backend/img/mechtoolzsignup.jpg" alt="Mechtoolz">
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                            <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
                                    value="<?php echo $this->security->get_csrf_hash() ?>">
                            <div class="sign-avatar">
                                <img src="<?php echo base_url(); ?>assets/mp_backend/img/mechtoolz-logo.svg" alt="">
                            </div>
                            <header class="sign-title">Log In</header>
                            <div class="form-group">
                                <input type="email" name="email" id="email" class="form-control" placeholder="E-Mail or Phone" required autofocus autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required autocomplete="off"/>
                            </div>
                            <input type="hidden" name="btn_login" value="true">
                            <div class="text-left">
                                    <a href="<?php echo site_url('forgetpsw'); ?>"><?php _trans('lable1030'); ?></a>
                            </div>
                            <button type="submit" class="btn btn-rounded">
                                <i class="fa fa-unlock fa-margin"></i> <?php _trans('login'); ?>
                            </button>
                            <?php $this->layout->load_view('layout/alerts'); ?>
                            <div class="form-group">
                                <div class="text-center">
                                    <a href="<?php echo site_url('signup'); ?>"><?php _trans('lable888'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


<script src="<?php echo base_url(); ?>assets/mp_backend/js/lib/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/mp_backend/js/lib/popper/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/mp_backend/js/lib/tether/tether.min.js"></script>
<script src="<?php echo base_url(); ?>assets/mp_backend/js/lib/bootstrap/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/mp_backend/js/plugins.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/mp_backend/js/lib/match-height/jquery.matchHeight.min.js"></script>
    <script>
        $(function() {
            $('.page-center').matchHeight({
                target: $('html')
            });

            $(window).resize(function(){
                setTimeout(function(){
                    $('.page-center').matchHeight({ remove: true });
                    $('.page-center').matchHeight({
                        target: $('html')
                    });
                },100);
            });
        });
    </script>
<script src="<?php echo base_url(); ?>assets/mp_backend/js/app.js"></script>
</body>
</html>