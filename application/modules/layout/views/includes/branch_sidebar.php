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
	    		<li class="grey <?php if('dashboard' == $class){ echo 'opened'; } ?>">
	        	<a href="<?php echo site_url('dashboard'); ?>">
	            <span>
	                <i class="font-icon font-icon-dashboard"></i>
	                <span class="lbl">Dashboard</span>
	            </span>
	            </a>
	        </li>
	        <li class="green with-sub <?php if('clients' == $class || 'suppliers' == $class || 'advisors' == $class){ echo 'opened'; } ?>">
	            <span>
	                <i class="fa fa-user"></i>
	                <span class="lbl">Contacts</span>
	            </span>
	            <ul>
	            	<li class="<?php if('clients' == $class){ echo 'active'; } ?>"><a href="<?php echo site_url('clients'); ?>">Customer</a></li>
	            	<li class="<?php if('suppliers' == $class){ echo 'active'; } ?>"><a href="<?php echo site_url('suppliers'); ?>">Supplier</a></li>
	            </ul>
	        </li>
	         <li class="blue">
	        	<a href="<?php echo site_url('user_cars'); ?>">
	            <span>
	                <i class="fa fa-car"></i>
	                <span class="lbl">Customer Cars</span>
	            </span>
	            </a>
	        </li>
	        
	    		<li class="gold with-sub">
	            <span>
	                <i class="fa fa-cogs"></i>
	                <span class="lbl">Spare Parts</span>
	            </span>
	            <ul>
	            	<li><a href="<?php echo site_url('products'); ?>">Products</a></li>
	            	<li><a href="<?php echo site_url('products/product_mapping'); ?>">Product Mapping</a></li>
	            	<li><a href="<?php echo site_url('families'); ?>">Product Category</a></li>
	            	<li><a href="<?php echo site_url('units'); ?>">Units</a></li>
	            	<li><a href="<?php echo site_url('units'); ?>">Inventory</a></li>
	            </ul>
	        </li>
	        <li class="pink with-sub">
	            <span>
	                <i class="fa fa-users"></i>
	                <span class="lbl">Employee</span>
	            </span>
	            <ul>
	            	<li><a href="<?php echo site_url('mech_employee'); ?>">Employee</a></li>
	            	<li><a href="<?php echo site_url('employee_role'); ?>">Role</a></li>
	            </ul>
	        </li>
	         <li class="gold with-sub <?php if('mechanic_service_category' == $class || 'mechanic_service_item_price_list' == $class){ echo 'opened'; } ?>">
	            <span>
	                <i class="fa fa-wrench"></i>
	                <span class="lbl">Manage SP</span>
	            </span>
	            <ul>
	            	<li class="<?php if('mechanic_service_category' == $class){ echo 'active'; } ?>"><a href="<?php echo site_url('mechanic_service_category'); ?>">Service Category</a></li>
	            	<li class="<?php if('mechanic_service_item_price_list' == $class){ echo 'active'; } ?>"><a href="<?php echo site_url('mechanic_service_item_price_list'); ?>">Service Items Mapping</a></li>
	            </ul>
	        </li>
	        <li class="gold with-sub <?php if('user_quotes' == $class){ echo 'opened'; } ?>">
	            <span>
	                <i class="font-icon glyphicon glyphicon-send"></i>
	                <span class="lbl">Quotes</span>
	            </span>
	            <?php //if($this->session->userdata('user_type') == 1){ ?>
	            <ul>
	            	<li class="<?php if('all' == $segment3){ echo 'active'; } ?>"><a href="<?php echo site_url('user_quotes'); ?>">All Quotes</a></li>
	            	<li class="<?php if('request' == $segment3){ echo 'active'; } ?>"><a href="<?php echo site_url('user_quotes/status/request'); ?>">Requested Quotes</a></li>
	            	<li class="<?php if('pending' == $segment3){ echo 'active'; } ?>"><a href="<?php echo site_url('user_quotes/status/pending'); ?>">Pending Quotes</a></li>
	            </ul>
	            <?php //} ?>
	        </li>
	        <li class="blue">
	        	<a href="<?php echo site_url('user_appointments'); ?>">
	            <span>
	                <span class="glyphicon glyphicon-list-alt"></span>
	                <span class="lbl">Manage Appoinment</span>
	            </span>
	            </a>
	        </li>
	       
	        <li class="magenta <?php if('job_sheet' == $class){ echo 'opened'; } ?>">
	        	<a href="<?php echo site_url('job_sheet'); ?>">
	            <span>
	                <span class="glyphicon glyphicon-list-alt"></span>
	                <span class="lbl">Manage Jobsheets</span>
	            </span>
	            </a>
	        </li>
	        <li class="blue">
	        	<a href="<?php echo site_url('mech_purchase'); ?>">
	            <span>
	                <span class="glyphicon glyphicon-list-alt"></span>
	                <span class="lbl">Purchase</span>
	            </span>
	            </a>
	        </li>
	        <li class="blue">
	        	<a href="<?php echo site_url('mech_expense'); ?>">
	            <span>
	                <span class="glyphicon glyphicon-list-alt"></span>
	                <span class="lbl">Expense</span>
	            </span>
	            </a>
	        </li>
	        <li class="blue">
	        	<a href="<?php echo site_url('mech_invoice'); ?>">
	            <span>
	                <span class="glyphicon glyphicon-list-alt"></span>
	                <span class="lbl">Invoice</span>
	            </span>
	            </a>
	        </li>
	        <li class="blue">
	        	<a href="<?php echo site_url('user_appointments'); ?>">
	            <span>
	                <span class="glyphicon glyphicon-list-alt"></span>
	                <span class="lbl">Reports</span>
	            </span>
	            </a>
	        </li>
	      </ul>
	
	</nav><!--.side-menu-->