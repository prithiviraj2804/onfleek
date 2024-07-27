<?php
$class = $this->router->fetch_class();
$method = $this->router->fetch_method();
?>
    <header id="header-style-1" class="dark_header">
		<div class="container">
			<nav class="navbar yamm navbar-default">
				<div class="navbar-header">
                    <button type="button" data-toggle="collapse" data-target="#navbar-collapse-1" class="navbar-toggle">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="<?php echo base_url(); ?>" class="navbar-brand">
                    <img class="hidden-md-down" src="<?php echo base_url(); ?>assets/mp_backend/img/mechtoolz-logo.svg" width="167" height="41px" alt="MechToolz">
                    </a>
        		</div><!-- end navbar-header -->
                
				<div id="navbar-collapse-1" class="navbar-collapse collapse navbar-right">
					<ul class="nav navbar-nav">
                        <li class="<?php if($method=="home"){ echo "active"; } ?>"><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li class="<?php if($method=="about"){ echo "active"; } ?>"><a href="<?php echo site_url('about'); ?>">About us</a></li>
                        <li class="<?php if($method=="features"){ echo "active"; } ?>"><a href="<?php echo site_url('features'); ?>">Features</a></li>
                        <li class="<?php if($method=="contact"){ echo "active"; } ?>"><a href="<?php echo site_url('contact'); ?>">Contact us</a></li>
                        <?php if($this->session->userdata('user_id')){ ?>
                        <li><a href="<?php echo site_url('dashboard'); ?>">Dashboard</a></li>
                        <li><a href="<?php echo site_url('sessions/logout'); ?>">Logout</a></li>
<?php }else{ ?>
                        <li><a href="<?php echo site_url('login'); ?>">Sign In</a></li>
                        <li><a href="<?php echo site_url('signup'); ?>">Sign Up</a></li>
<?php } ?>
					</ul><!-- end navbar-nav -->
                </div><!-- #navbar-collapse-1 -->			
            </nav>
		</div><!-- end container -->
	</header><!-- end header-style-1 -->