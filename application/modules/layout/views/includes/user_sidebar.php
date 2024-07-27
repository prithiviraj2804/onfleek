<?php
$class = $this->router->fetch_class();
$method = $this->router->fetch_method();
$segment1 = $this->uri->segment(1);
$segment2 = $this->uri->segment(2);
$segment3 = $this->uri->segment(3);
?>
<style>
	.side-menu-list .opened .lbl{
		color : black
	}
	.side-menu-list .opened li.active a, .side-menu-list .opened li>span{
		background-color: #e4e7ff;
	}
</style>
<nav class="side-menu">
	    <ul class="side-menu-list">
	    	<!--- User Menu --->
	    	<li class="grey <?php if('dashboard' == $class){ echo 'opened'; } ?>">
	        	<a href="<?php echo site_url('dashboard'); ?>">
	            <span>
	                <i class="font-icon font-icon-dashboard"></i>
	                <span class="lbl">Dashboard</span>
	            </span>
	            </a>
	        </li>
	        <li class="blue">
	        	<a href="<?php echo site_url('user_cars'); ?>">
	            <span>
	                <i class="fa fa-car"></i>
	                <span class="lbl">My Cars</span>
	            </span>
	            </a>
	        </li>
	        <li class="magenta">
	        	<a href="<?php echo site_url('user_appointments'); ?>">
	            <span>
	                <span class="glyphicon glyphicon-list-alt"></span>
	                <span class="lbl">Appointments</span>
	            </span>
	            </a>
	        </li>
	        <li class="gold with-sub">
	            <span>
	                <i class="font-icon glyphicon glyphicon-send"></i>
	                <span class="lbl">Quotes</span>
	            </span>
	            <?php //if($this->session->userdata('user_type') == 1){ ?>
	            <ul>
	            	<li><a href="<?php echo site_url('user_quotes'); ?>">All Quotes</a></li>
	            	<li><a href="<?php echo site_url('user_quotes/status/request'); ?>">Requested Quotes</a></li>
	            	<li><a href="<?php echo site_url('user_quotes/status/pending'); ?>">Pending Quotes</a></li>
	            </ul>
	            <?php //} ?>
	        </li>
	        <li class="blue">
	        	<a href="<?php echo site_url('user_address'); ?>">
	            <span>
	                <i class="fa fa-map-marker"></i>
	                <span class="lbl">My Address</span>
	            </span>
	            </a>
	        </li>
	        <li class="blue">
	        	<a href="<?php echo site_url('mech_insurance'); ?>">
	            <span>
	                <span class="glyphicon glyphicon-list-alt"></span>
	                <span class="lbl">Insurance</span>
	            </span>
	            </a>
	        </li>
	    </ul>
	
	</nav><!--.side-menu-->