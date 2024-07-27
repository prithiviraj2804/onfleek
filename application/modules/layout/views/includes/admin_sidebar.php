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
	        <?php /* * /?>
	        <li class="magenta <?php if('user_appointments' == $class){ echo 'opened'; } ?>">
	        	<a href="<?php echo site_url('user_appointments'); ?>">
	            <span>
	                <span class="glyphicon glyphicon-list-alt"></span>
	                <span class="lbl">Manage Jobsheets</span>
	            </span>
	            </a>
	        </li>
			<?php / * */?>
			
			<li class="green with-sub <?php if('clients' == $class || 'suppliers' == $class || 'advisors' == $class){ echo 'opened'; } ?>">
	            <span>
	                <i class="fa fa-user"></i>
	                <span class="lbl">Contacts</span>
	            </span>
	            <ul>
	            	<li class="<?php if('clients' == $class){ echo 'active'; } ?>"><a href="<?php echo site_url('clients'); ?>">Customer</a></li>
	            	<li class="<?php if('suppliers' == $class){ echo 'active'; } ?>"><a href="<?php echo site_url('suppliers'); ?>">Supplier</a></li>
	            	<li class="<?php if('advisors' == $class){ echo 'active'; } ?>"><a href="<?php echo site_url('advisors'); ?>">Advisor</a></li>
	            </ul>
	        </li>
	        
	        
			<li class="magenta <?php if('user_appointments' == $class){ echo 'opened'; } ?>">
	        	<a href="<?php echo site_url('user_appointments'); ?>">
	            <span>
	                <span class="glyphicon glyphicon-list-alt"></span>
	                <span class="lbl">Invoice</span>
	            </span>
	            </a>
	        </li>
	        <li class="red <?php if('user_offer' == $class){ echo 'opened'; } ?>">
	        	<a href="<?php echo site_url('user_offer'); ?>">
	            <span>
	                <i class="fa fa-gift" aria-hidden="true"></i>
	                <span class="lbl">Offer</span>
	            </span>
	            </a>
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
	        <li class="aquamarine with-sub <?php if('mechanic_shop' == $class || 'mechanic_list' == $class){ echo 'opened'; } ?>">
	            <span>
	                <i class="fa fa-shopping-cart"></i>
	                <span class="lbl">Manage Workshop</span>
	            </span>
	            <ul>
	            	<li><a href="<?php echo site_url('mechanic_shop'); ?>">Shop's</a></li>
	            	<li><a href="<?php echo site_url('mechanic_list'); ?>">Shop Employee</a></li>
	            </ul>
	        </li>
	        
	        <li class="pink-red with-sub <?php if('mech_car_brand_details' == $class ||'mech_car_brand_models_details' == $class || 'mech_brand_model_variants' == $class){ echo 'opened'; } ?>">
	            <span>
	                <i class="fa fa-car"></i>
	                <span class="lbl">Manage Car Details</span>
	            </span>
	            <ul>
	            	<li><a href="<?php echo site_url('mech_car_brand_details'); ?>">Brands</a></li>
	            	<li><a href="<?php echo site_url('mech_car_brand_models_details'); ?>">Models</a></li>
	            	<li><a href="<?php echo site_url('mech_brand_model_variants'); ?>">Variants</a></li>
	            </ul>
	        </li>
	        <li class="gold with-sub <?php if('products' == $class ||'families' == $class || 'units' == $class || 'product_mapping'  == $class){ echo 'opened'; } ?>">
	            <span>
	                <i class="fa fa-product-hunt"></i>
	                <span class="lbl">Manage Products</span>
	            </span>
	            <ul>
	            	<li><a href="<?php echo site_url('products'); ?>">Products</a></li>
	            	<li><a href="<?php echo site_url('products/product_mapping'); ?>">Product Mapping</a></li>
	            	<li><a href="<?php echo site_url('families'); ?>">Product Category</a></li>
	            	<li><a href="<?php echo site_url('units'); ?>">Units</a></li>
	            </ul>
	        </li>
	        <li class="pink with-sub <?php if('mech_employee' == $class ||'employee_role' == $class){ echo 'opened'; } ?>">
	            <span>
	                <i class="fa fa-users"></i>
	                <span class="lbl">Manage Employee</span>
	            </span>
	            <ul>
	            	<li><a href="<?php echo site_url('mech_employee'); ?>">Employee</a></li>
	            	<?php /* <li><a href="<?php echo site_url('families'); ?>">Families</a></li> */ ?>
	            	<li><a href="<?php echo site_url('employee_role'); ?>">Role</a></li>
	            </ul>
	        </li>
	        <li class="blue <?php if('mech_assign_appoinment' == $class){ echo 'opened'; } ?>">
	        	<a href="<?php echo site_url('mech_assign_appoinment'); ?>">
	            <span>
	                <span class="glyphicon glyphicon-list-alt"></span>
	                <span class="lbl">Manage Jobs</span>
	            </span>
	            </a>
	        </li>
	        <li class="green <?php if('mech_insurance' == $class){ echo 'opened'; } ?>">
	        	<a href="<?php echo site_url('mech_insurance'); ?>">
	            <span>
	                <span class="fa fa-shield"></span>
	                <span class="lbl">Insurance</span>
	            </span>
	            </a>
	        </li>
	        <li class="blue-dirty <?php if('blogger' == $class){ echo 'opened'; } ?>">
	        	<a href="<?php echo site_url('blogger'); ?>">
	            <span>
	                <span class="glyphicon glyphicon-user"></span>
	                <span class="lbl">Manage Blog</span>
	            </span>
	            </a>
	        </li>
	        <li class="gold with-sub  <?php if('users' == $class || 'mech_area_list' == $class || 'referral_events' == $class){ echo 'opened'; } ?>">
	            <span>
	                <i class="fa fa-cogs"></i>
	                <span class="lbl">Admin</span>
	            </span>
	            <ul>
	            	<li><a href="<?php echo site_url('users'); ?>">User Management</a></li>
	            	<li><a href="<?php echo site_url('mech_area_list'); ?>">Area's</a></li>
	            	<li><a href="<?php echo site_url('referral_events'); ?>">Referral Events</a></li>
	            </ul>
	        </li>
	    </ul>
	
	</nav><!--.side-menu-->