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
		<!-- Dashboard -->
		<?php foreach($permission as $perlist){
		if($perlist->module_name == "dashboard"){ ?>
		<li class="grey <?php if('dashboard' == $class){ echo 'opened'; } ?>">
			<a href="<?php echo site_url('dashboard'); ?>">
				<span>
					<i class="fa fa-tachometer"></i>
					<span class="lbl"><?php _trans('menu1'); ?></span>
				</span>
			</a>
		</li>	
		<?php } } ?>
		<!-- CRM -->
		<?php $showCRM = 'style="display:none"'; 
		foreach($permission as $perlist){ 
			if($perlist->module_name == "leads" || $perlist->module_name == "mech_appointments" || $perlist->module_name == "email_bulk" || $perlist->module_name == "sms_bulk"){
				$showCRM = 'style="display:block"';
				
		} } ?>
		<li <?php echo $showCRM; ?>  class="grey with-sub <?php if('mech_leads' == $class || 'mech_appointments' == $class || 'email_bulk' == $class || 'sms_bulk' == $class){ echo 'opened'; } ?>">
			<span>
				<i class="fa fa-bolt"></i>
				<span class="lbl"><?php _trans('lable1169'); ?></span>
			</span>
			<ul>
				<!-- leads -->
				<?php foreach($permission as $perlist){ 
				if($perlist->module_name == "leads"){ ?>
				<li class="<?php if(('index' == $method || 'mech_leads' == $method ) && 'mech_leads' == $class){ echo 'active'; } ?>"><a href="<?php echo site_url('mech_leads/index'); ?>"><?php _trans('menu9'); ?></a></li>
				<?php } } ?>
				<!-- Appointments -->
				<?php foreach($permission as $perlist){ 
				if($perlist->module_name == "appointments"){ ?>
				<li class="<?php if(('index' == $method || 'mech_appointments' == $method ) && 'mech_appointments' == $class){ echo 'active'; } ?>"><a href="<?php echo site_url('mech_appointments/index'); ?>"><?php _trans('menu10'); ?></a></li>
				<?php } } ?>
				<!-- Email Marketing -->
				<?php foreach($permission as $perlist){ 
				if($perlist->module_name == "email_bulk"){ ?>
				<li class="<?php if(('index' == $method || 'email_bulk' == $method ) && 'email_bulk' == $class){ echo 'active'; } ?>"><a href="<?php echo site_url('email_bulk/index'); ?>"><?php _trans('lable1146'); ?></a></li>
				<?php } } ?>
				<!-- SMS Marketing -->
				<?php /*?>
				<?php foreach($permission as $perlist){ 
				if($perlist->module_name == "sms_bulk"){ ?>
				<li class="<?php if(('index' == $method || 'sms_bulk' == $method ) && 'sms_bulk' == $class){ echo 'active'; } ?>"><a href="<?php echo site_url('sms_bulk/index'); ?>"><?php _trans('lable1151'); ?></a></li> 
				<?php } } ?><?php */?>
				<!-- firebase notification -->
				<?php foreach($permission as $perlist){ 
				if($perlist->module_name == "firebase"){ ?>
				<li class="<?php if(('index' == $method || 'firebase_notification' == $method ) && 'firebase_notification' == $class){ echo 'active'; } ?>"><a href="<?php echo site_url('firebase_notification/index'); ?>"><?php _trans('lable1214'); ?></a></li>
				<?php } } ?>
			</ul>
		</li>
		<!-- Customer Retensions -->
		<?php foreach($permission as $perlist){
		if($perlist->module_name == "customer_retention"){ ?>
		<li class="grey <?php if('customer_retention' == $class){ echo 'opened'; } ?>">
			<a href="<?php echo site_url('customer_retention'); ?>">
				<span>
					<i class="fa fa-retweet"></i>
					<span class="lbl"><?php _trans('menu2'); ?></span>
				</span>
			</a>
		</li>
		<?php } } ?>
		<!-- My Customers -->
		<?php foreach($permission as $perlist){ 
		if($perlist->module_name == "clients"){ ?>
		<li class="grey <?php if('clients' == $class){ echo 'opened'; } ?>">
			<a href="<?php echo site_url('clients'); ?>">
				<span>
					<i class="fa fa-user"></i>
					<span class="lbl"><?php _trans('lable1170'); ?></span>
				</span>
			</a>
		</li>	
		<?php } } ?>
		<!-- My Suppliers -->
		<?php foreach($permission as $perlist){ 
		if($perlist->module_name == "suppliers"){ ?>
		<li class="grey <?php if('suppliers' == $class){ echo 'opened'; } ?>">
			<a href="<?php echo site_url('suppliers'); ?>">
				<span>
					<i class="fa fa-user"></i>
					<span class="lbl"><?php _trans('lable1171'); ?></span>
				</span>
			</a>
		</li>
		<?php } } ?>
		<!-- My Employees -->
		<?php foreach($permission as $perlist){ 
		if($perlist->module_name == "mech_employee"){ ?>
		<li class="grey <?php if('mech_employee' == $class){ echo 'opened'; } ?>">
			<a href="<?php echo site_url('mech_employee'); ?>">
				<span>
					<i class="fa fa-users"></i>
					<span class="lbl"><?php _trans('lable1172'); ?></span>
				</span>
			</a>
		</li>
		<?php } } ?>
		<!-- Inventory -->
		<?php $showInventory = 'style="display:none"';
		foreach($permission as $perlist){
			if($perlist->module_name == "parts" || $perlist->module_name == "purchase_order" || $perlist->module_name == "view_alerts"){ 
				$showInventory = 'style="display:block"';
		} } ?>
		<li <?php echo $showInventory; ?> class="grey with-sub <?php if(($class == 'mech_item_master' && $method == 'index') || 'families' == $class || 'mech_purchase_order' == $class || 'view_alerts' == $class){ echo 'opened'; } ?>">
			<span>
				<i class="fa fa-houzz"></i>
				<span class="lbl"><?php _trans('menu14'); ?></span>
			</span>
			<ul>
			<!-- Parts -->
			<?php foreach($permission as $perlist){
			if($perlist->module_name == "parts"){ ?>
				<li class="<?php if('index' == $method && 'mech_item_master' == $class){ echo 'active'; } ?>"><a href="<?php echo site_url('mech_item_master'); ?>"><?php _trans('lable582'); ?></a></li>
				<li class="<?php if('families' == $class){ echo 'active'; } ?>"><a href="<?php echo site_url('families'); ?>"><?php _trans('lable235'); ?></a></li>
			<?php }} ?>
			<!-- Purchase Order -->
			<?php ?>
			<?php foreach($permission as $perlist){
			if($perlist->module_name == "purchase_order"){ ?>
				<li class="<?php if('mech_purchase_order' == $class){ echo 'active'; } ?>"><a href="<?php echo site_url('mech_purchase_order'); ?>"><?php _trans('menu15'); ?></a></li>
			<?php }} ?>
			<?php ?>
			<!-- View Alerts -->
			<?php foreach($permission as $perlist){
			if($perlist->module_name == "view_alerts"){ ?>
				<li class="<?php if('view_alerts' == $class){ echo 'active'; } ?>"><a href="<?php echo site_url('view_alerts'); ?>"><?php _trans('lable1173'); ?></a></li>
			<?php }} ?>
			</ul>
		</li>
		<!-- Service Master -->
		<?php $showServiceMaster = 'style="display:none"';
		foreach($permission as $perlist){
			if($perlist->module_name == "services"){ 
				$showServiceMaster = 'style="display:block"';
		} } ?>
		<li <?php echo $showServiceMaster; ?> class="grey with-sub <?php if('service_index' == $method && 'mech_item_master' || 'mechanic_service_category' == $class ){ echo 'opened'; } ?>">
			<span>
				<i class="fa fa-cogs"></i>
				<span class="lbl"><?php _trans('lable1175'); ?></span>
			</span>
			<ul>
			<?php foreach($permission as $perlist){
			if($perlist->module_name == "services"){ ?>
				<li class="<?php if('service_index' == $method){ echo 'active'; } ?>"><a href="<?php echo site_url('mech_item_master/service_index'); ?>"><?php _trans('menu6'); ?></a></li>
				<li class="<?php if('mechanic_service_category' == $class && 'index' == $method){ echo 'active'; } ?>"><a href="<?php echo site_url('mechanic_service_category'); ?>"><?php _trans('lable239'); ?></a></li>
			<?php }} ?>
			</ul>
		</li>

		<!-- Jobs -->
		<?php foreach($permission as $perlist){ 
		if($perlist->module_name == "jobs"){ ?>
		<?php if($this->session->userdata('workshop_is_enabled_jobsheet') == 'Y'){ ?>
		<li class="grey <?php if('mech_work_order_dtls' == $class){ echo 'opened'; } ?>">
			<a href="<?php echo site_url('mech_work_order_dtls'); ?>">
				<span>
					<i class="fa fa-car"></i>
					<span class="lbl"><?php _trans('lable1176'); ?></span>
				</span>
			</a>
		</li>		
		<?php } } } ?>

		<!-- Estimate -->
		<?php foreach($permission as $perlist){ 
		if($perlist->module_name == "estimate"){ ?>
		<?php if($this->session->userdata('plan_type') != 3){ ?>
		<li class="grey <?php if('mech_quotes' == $class){ echo 'opened'; } ?>">
			<a href="<?php echo site_url('mech_quotes'); ?>">
		<?php }else{ ?>
		<li class="grey <?php if('spare_quotes' == $class){ echo 'opened'; } ?>">
			<a href="<?php echo site_url('spare_quotes'); ?>">
		<?php } ?>	
				<span>
					<i class="fa fa-calculator"></i>
					<span class="lbl"><?php _trans('lable837'); ?></span>
				</span>
			</a>
		</li>
		<?php } } ?>
		<!-- Accounts -->
		<?php $showAccounts = 'style="display:none"'; foreach($permission as $perlist){ 
		if($perlist->module_name == "invoice" || $perlist->module_name == "pos_invoice" || $perlist->module_name == "mech_purchase" || $perlist->module_name == "expense" || $perlist->module_name == "payment"){
				$showAccounts = 'style="display:block"';
				
		} } ?>
		<li <?php echo $showAccounts; ?>  class="grey with-sub <?php if('payment_methods' == $class || 'mech_bank_list' == $class ||'mech_pos_invoices' == $class || 'mech_expense' == $class || 'mech_payments' == $class || 'mech_invoices' == $class || 'spare_invoices' == $class || 'mech_purchase' == $class){ echo 'opened'; } ?>">
			<span>
				<i class="fa fa-bar-chart"></i>
				<span class="lbl"><?php _trans('menu8'); ?></span>
			</span>
			<ul>
			<?php foreach($permission as $perlist){
				// Invoice
				if($perlist->module_name == "invoice"){ 
				if($this->session->userdata('plan_type') != 3){ ?>
					<li class="<?php if('mech_invoices' == $class){ echo 'active'; } ?>"><a href="<?php echo site_url('mech_invoices'); ?>"><?php _trans('lable119'); ?></a></li>
				<?php }else{ ?>
					<li class="<?php if('spare_invoices' == $class){ echo 'active'; } ?>"><a href="<?php echo site_url('spare_invoices'); ?>"><?php _trans('lable119'); ?></a></li>
				<?php } } } foreach($permission as $perlist){
				// Quick Invoice
				if($perlist->module_name == "quick_invoice"){ 
				if($is_pos == "Y"){?>
				<li class="<?php if('mech_pos_invoices' == $class){ echo 'active'; } ?>"><a href="<?php echo site_url('mech_pos_invoices'); ?>"><?php _trans('lable587'); ?></a></li>
				<?php } } } foreach($permission as $perlist){
				// Purchase
				if($perlist->module_name == "purchase"){ ?>
				<li class="<?php if('mech_purchase' == $class){ echo 'active'; } ?>"><a href="<?php echo site_url('mech_purchase'); ?>"><?php _trans('lable120'); ?></a></li>
				<?php  } } foreach($permission as $perlist){
			 	// Expense
				if($perlist->module_name == "expense"){ ?>
				<li class="<?php if('mech_expense' == $class){ echo 'active'; } ?>"><a href="<?php echo site_url('mech_expense'); ?>"><?php _trans('lable121'); ?></a></li>
				<?php } } foreach($permission as $perlist){
				// Payment and transaction
				if($perlist->module_name == "payment"){ ?>
				<li class="<?php if('mech_payments' == $class){ echo 'active'; } ?>"><a href="<?php echo site_url('mech_payments'); ?>"><?php _trans('lable82'); ?></a></li>
				<li class="<?php if('mech_bank_list' == $class){ echo 'active'; } ?>"><a href="<?php echo site_url('mech_bank_list/transaction_list'); ?>"><?php _trans('lable478'); ?></a></li>
				<?php } }?>
			</ul>
		</li>
		<!-- Package -->
		<?php foreach($permission as $perlist){ 
		if($perlist->module_name == "package"){ ?>
		<?php if($this->session->userdata('plan_type') != 3){ ?>
		<li class="grey <?php if('service_packages' == $class){ echo 'opened'; } ?>">
			<a href="<?php echo site_url('service_packages'); ?>">
				<span>
					<i class="fa fa-briefcase"></i>
					<span class="lbl"><?php _trans('lable546'); ?></span>
				</span>
			</a>
		</li>
		<li class="grey <?php if('mech_add_feedback' == $class){ echo 'opened'; } ?>">
			<a href="<?php echo site_url('mech_add_feedback'); ?>">
				<span>
					<i class="fa fa-comments-o"></i>
					<span class="lbl"><?php _trans('lable417'); ?></span>
				</span>
			</a>
		</li>
		<?php } } } ?>
	
		<!-- Reminder -->
		<?php foreach($permission as $perlist){
			if($perlist->module_name == "reminder"){ ?>
			<li class="grey with-sub <?php if('reminder' == $class){ echo 'opened'; } ?>">
			<span>
				<i class="fa fa-bell"></i>
				<span class="lbl"><?php _trans('menu12'); ?></span>
				<!-- <span class="lbl">Reminder</span> -->
			</span>
			<ul>
				<li class="<?php if(('contact_reminder_index' == $method || 'contact_reminder_view' == $method || 'contact_reminder' == $method ) && 'reminder' == $class){ echo 'active'; } ?>"><a href="<?php echo site_url('reminder/contact_reminder_index'); ?>"><?php _trans('lable547'); ?></a></li>
				<li class="<?php if(('custom_reminder_index' == $method || 'custom_reminder_view' == $method || 'custom_reminder' == $method ) && 'reminder' == $class){ echo 'active'; } ?>"><a href="<?php echo site_url('reminder/custom_reminder_index'); ?>"><?php _trans('lable561'); ?></a></li>
			</ul>
		</li>
		<?php } } ?>
		<!-- Reports -->
		<?php foreach($permission as $perlist){
		if($perlist->module_name == "reports"){ ?>
		<li class="grey <?php if('reports' == $class){ echo 'opened'; } ?>">
			<a href="<?php echo site_url('reports'); ?>">
				<span>
					<span class="glyphicon glyphicon-list-alt"></span>
					<span class="lbl"><?php _trans('menu13'); ?></span>
					<!-- <span class="lbl">Reports</span> -->
				</span>
			</a>
		</li>
		<?php } } ?>
	</ul>
</nav>
<span><a href="https://www.onfleek.in/" target="_blank" class="powered_by">Powered By Onfleek</a></span>