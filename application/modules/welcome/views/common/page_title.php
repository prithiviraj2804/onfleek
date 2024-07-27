<?php if($this->router->fetch_method()=="howitworks") { ?> 
	<div id="pageTitle">
		<div class="container">
			<div class="breadcrumbs">
				<ul class="breadcrumb">
					<li><a href="<?php echo site_url('welcome'); ?>">Home</a></li>
					<li>How it works</li>
				</ul>
			</div>
			<h1>How it <span class="color">Works</span></h1>
		</div>
	</div>
<?php } ?>

<?php if($this->router->fetch_method()=="services") { ?>
	<div id="pageTitle">
		<div class="container">
			<div class="breadcrumbs">
				<ul class="breadcrumb">
					<li><a href="<?php echo site_url('welcome'); ?>">Home</a></li>
					<li>Services</li>
				</ul>
			</div>
			<h1>Services</h1>
		</div>
	</div>
<?php } ?>
<?php if($this->router->fetch_method()=="insurance") { ?>
	<div id="pageTitle">
		<div class="container">
			<div class="breadcrumbs">
				<ul class="breadcrumb">
					<?php /* * / ?>
					<li><a href="<?php echo site_url('welcome'); ?>">Home</a></li>
					<li>Pricing &amp; Coupons</li>
					<?php / * */ ?>
				</ul>
			</div>
			<h1>Insurance</h1>
		</div>
	</div>
<?php } ?>
<?php if($this->router->fetch_method()=="insurance_form") { ?>
	<div id="pageTitle">
		<div class="container">
			<div class="breadcrumbs">
				<ul class="breadcrumb">
					<?php /* * / ?>
					<li><a href="<?php echo site_url('welcome'); ?>">Home</a></li>
					<li>Pricing &amp; Coupons</li>
					<?php / * */ ?>
				</ul>
			</div>
			<h1>Insurance Form</h1>
		</div>
	</div>
<?php } ?>
<?php if($this->router->fetch_method()=="coupon") { ?>
	<div id="pageTitle">
		<div class="container">
			<div class="breadcrumbs">
				<ul class="breadcrumb">
					<?php /* * / ?>
					<li><a href="<?php echo site_url('welcome'); ?>">Home</a></li>
					<li>Pricing &amp; Coupons</li>
					<?php / * */ ?>
				</ul>
			</div>
			<h1>Comming Soon</h1>
		</div>
	</div>
<?php } ?>

<?php if($this->router->fetch_method()=="gallery") { ?>
	<div id="pageTitle">
		<div class="container">
			<div class="breadcrumbs">
				<ul class="breadcrumb">
					<li><a href="<?php echo site_url('welcome'); ?>">Home</a></li>
					<li>Gallery</li>
				</ul>
			</div>
			<h1>Gallery</h1>
		</div>
	</div>
<?php } ?>

<?php if($this->router->fetch_method()=="get_quotes") { ?>
	<div id="pageTitle">
			<div class="container">
				<div class="breadcrumbs">
					<ul class="breadcrumb">
						<li><a href="<?php echo site_url('welcome'); ?>">Home</a></li>
						<li>Get Quotes</li>
					</ul>
				</div>
			</div>
		</div>
<?php } ?>


<?php if($this->router->fetch_method()=="testimonials") { ?>
	<div id="pageTitle">
		<div class="container">
			<div class="breadcrumbs">
				<ul class="breadcrumb">
					<li><a href="<?php echo site_url('welcome'); ?>">Home</a></li>
					<li>Testimonials</li>
				</ul>
			</div>
			<h1>Testimonials</h1>
		</div>
	</div>
<?php } ?>

<?php if($this->router->fetch_method()=="faq") { ?>
	<div id="pageTitle">
		<div class="container">
			<div class="breadcrumbs">
				<ul class="breadcrumb">
					<li><a href="<?php echo site_url('welcome'); ?>">Home</a></li>
					<li>Frequently Asked Question</li>
				</ul>
			</div>
			<h1>Frequently <span class="color">Asked Question</span></h1>
		</div>
	</div>
<?php } ?>

<?php if($this->router->fetch_method()=="contact") { ?>
	<div id="pageTitle">
		<div class="container">
			<div class="breadcrumbs">
				<ul class="breadcrumb">
					<li><a href="<?php echo site_url('welcome'); ?>">Home</a></li>
					<li>Contacts</li>
				</ul>
			</div>
			<h1>Contacts</h1>
		</div>
	</div>
<?php } ?>

<?php if($this->router->fetch_method()=="blog" || $this->router->fetch_method()=="blog_details") { ?>
	<div id="pageTitle">
		<div class="container">
			<div class="breadcrumbs">
				<ul class="breadcrumb">
					<li><a href="<?php echo site_url('blogger'); ?>">Blog</a></li>
					<li>Blogger</li>
				</ul>
			</div>
			<h1>Blogger</h1>
		</div>
	</div>
<?php } ?>

<?php if($this->router->fetch_method()=="privacy_policy") { ?>
	<div id="pageTitle">
		<div class="container">
			<div class="breadcrumbs">
				<ul class="breadcrumb">
					<li><a href="<?php echo site_url('welcome'); ?>">Home</a></li>
					<li>Privacy Policy</li>
				</ul>
			</div>
			<h1>Privacy Policy</h1>
		</div>
	</div>
<?php } ?>

<?php if($this->router->fetch_method()=="terms_conditions") { ?>
	<div id="pageTitle">
		<div class="container">
			<div class="breadcrumbs">
				<ul class="breadcrumb">
					<li><a href="<?php echo site_url('welcome'); ?>">Home</a></li>
					<li>CUSTOMER TERMS AND CONDITIONS</li>
				</ul>
			</div>
			<h1>CUSTOMER TERMS AND CONDITIONS</h1>
		</div>
	</div>
<?php } ?>