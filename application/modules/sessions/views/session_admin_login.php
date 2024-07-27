<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>MechToolz</title>

	<link href="<?php echo base_url(); ?>assets/mp_backend/img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="<?php echo base_url(); ?>assets/mp_backend/img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
	<link href="<?php echo base_url(); ?>assets/mp_backend/img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
	<link href="<?php echo base_url(); ?>assets/mp_backend/img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
	<link href="<?php echo base_url(); ?>assets/mp_backend/img/favicon.png" rel="icon" type="image/png">
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
<style>
	body{
		background: url(../../assets/mm_fe_latest/images/slider/slide1.jpg);
		background-size: cover;
	}
</style>
<body>
<?php /* * / ?><img src="<?php echo base_url(); ?>/assets/mm_fe_latest/images/mm_custom/mechpoint.svg" alt="MechPoint"><?php / * */ ?>
    <div class="page-center">
        <div class="page-center-in">
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
                            <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>" value="<?php echo $this->security->get_csrf_hash() ?>">
                            <div class="sign-avatar">
                                <img src="<?php echo base_url(); ?>assets/mp_backend/img/avatar-sign.png" alt="" style="width: 80px;height: 80px;text-align: center;float: none;margin: 0 auto;">
                            </div>
                            <header class="sign-title">Log In</header>
                            <div class="form-group">
                                <input type="email" name="email" id="email" class="form-control" placeholder="E-Mail or Phone" required autofocus autocomplete="off"/>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required autocomplete="off"/>
                            </div>
                            
                            <input type="hidden" name="access_type" id="access_type" value="1"/>
                            
                            <input type="hidden" name="btn_login" value="true">
                            <button type="submit" class="btn btn-rounded">
                                <i class="fa fa-unlock fa-margin"></i> <?php _trans('login'); ?>
                            </button>
                            <?php $this->layout->load_view('layout/alerts'); ?>
                            <div class="form-group">
                                <div class="text-center">
                                    <a href="<?php echo site_url('sessions/passwordreset'); ?>"><?php _trans('forgot_your_password'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><!--.page-center-->


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
<?php /* * / ?>



<!doctype html>

<!--[if lt IE 7]>
<html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>
<html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>
<html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en"> <!--<![endif]-->

<head>
    <title>
        <?php
        if (get_setting('custom_title') != '') {
            echo get_setting('custom_title');
        } else {
            echo 'InvoicePlane';
        } ?>
    </title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width">
    <meta name="robots" content="NOINDEX,NOFOLLOW">

    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/core/img/favicon.png">

    <link href="<?php echo base_url(); ?>assets/<?php echo get_setting('system_theme', 'invoiceplane'); ?>/css/style.css"
          rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/core/css/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/separate/pages/login.min.css">

</head>

<body>
   
<noscript>
    <div class="alert alert-danger no-margin"><?php _trans('please_enable_js'); ?></div>
</noscript>

<br>

<div class="container">

    <div id="login" class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">

        <?php if ($login_logo) { ?>
            <img src="<?php echo base_url(); ?>uploads/<?php echo $login_logo; ?>" class="login-logo img-responsive">
        <?php } else { ?>
            <h1><?php _trans('login'); ?></h1>
        <?php } ?>

        <div class="row"><?php $this->layout->load_view('layout/alerts'); ?></div>

        <form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>">

            <input type="hidden" name="<?php echo $this->config->item('csrf_token_name'); ?>"
                   value="<?php echo $this->security->get_csrf_hash() ?>">

            <div class="form-group">
                <label for="email" class="control-label"><?php _trans('email'); ?></label>
                <input type="email" name="email" id="email" class="form-control"
                       placeholder="<?php _trans('email'); ?>" required autofocus
                    <?php if (!empty($_POST['email'])) : ?> value="<?php echo $_POST['email']; ?>"<?php endif; ?>>
            </div>

            <div class="form-group">
                <label for="password" class="control-label"><?php _trans('password'); ?></label>
                <input type="password" name="password" id="password" class="form-control"
                       placeholder="<?php _trans('password'); ?>" required
                    <?php if (!empty($_POST['password'])) : ?> value="<?php echo $_POST['email']; ?>"<?php endif; ?>>
            </div>

            <input type="hidden" name="btn_login" value="true">

            <button type="submit" class="btn btn-primary">
                <i class="fa fa-unlock fa-margin"></i> <?php _trans('login'); ?>
            </button>
            <a href="<?php echo site_url('sessions/passwordreset'); ?>" class="btn btn-default">
                <?php _trans('forgot_your_password'); ?>
            </a>

        </form>

    </div>
</div>

</body>
</html>
<?php / * */ ?>