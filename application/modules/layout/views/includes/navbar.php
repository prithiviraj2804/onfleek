<header class="site-header">
	<div class="container-fluid">
		<a href="<?php echo site_url('dashboard'); ?>" class="site-logo">
			<img class="hidden-md-down" src="<?php echo base_url(); ?>assets/mp_backend/img/mechtoolz-logo.svg" width="180" height="50px" alt="MechToolz">
			<img class="hidden-lg-up" src="<?php echo base_url(); ?>assets/mp_backend/img/mechtoolz-logo.svg" alt="MechToolz">
		</a>
		<?php if($this->session->userdata('is_new_user') != 'N'){ ?>
	    <button id="show-hide-sidebar-toggle" class="show-hide-sidebar">
	        <span><?php _trans('lable754');?></span>
		</button>
		<?php }?>
	    <button class="hamburger hamburger--htla">
	        <span><?php _trans('lable754');?></span>
		</button>
	    <div class="site-header-content">
	        <div class="site-header-content-in">
	            <div class="site-header-shown">
	                <div class="dropdown user-menu">
	                    <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

							<?php $file_pointer =  FCPATH.'uploads/workshop_logo/'.$this->session->userdata('workshop_logo'); ?>
							<?php if($this->session->userdata('workshop_logo') &&  file_exists($file_pointer)){ ?>
								<img src="<?php echo base_url(); ?>uploads/workshop_logo/<?php echo $this->session->userdata('workshop_logo'); ?>" alt="">
							<?php } else { ?>
								<img src="<?php echo base_url(); ?>uploads/user.png" alt="">
							<?php } ?>
	                    </button>
	                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
							<?php if($this->session->userdata('is_new_user') != 'N'){?>
	                        	<a class="dropdown-item" href="<?php echo site_url('users/form/'.$this->session->userdata('user_id')); ?>"><span class="font-icon glyphicon glyphicon-user"></span><?php _trans('lable753');?></a>
                        	<?php if($this->session->userdata('user_type')==1){ ?> 
                        		<a class="dropdown-item" href="<?php echo site_url('workshop_setup'); ?>"><span class="font-icon glyphicon glyphicon-cog"></span><?php _trans('lable751');?></a>
                       			<a class="dropdown-item" href="<?php echo site_url('workshop_branch/index'); ?>"><span class="font-icon glyphicon glyphicon-cog"></span><?php _trans('lable752');?></a>
                        	<?php }elseif($this->session->userdata('user_type')==3){ ?>
                        		<a class="dropdown-item" href="<?php echo site_url('workshop_setup'); ?>"><span class="font-icon glyphicon glyphicon-cog"></span><?php _trans('lable751');?></a>
                        	<?php }elseif($this->session->userdata('user_type')==4){ ?>
                        		<a class="dropdown-item" href="<?php echo site_url('workshop_branch/index/'.$this->session->userdata('branch_id')); ?>"><span class="font-icon glyphicon glyphicon-cog"></span><?php _trans('lable752');?></a>
                        	<?php } ?>
                        	<?php if($this->session->userdata('user_type')==1){ ?>
	                            <a class="dropdown-item" href="#"><span class="font-icon glyphicon glyphicon-cog"></span><?php _trans('lable751');?></a>
	                    	<?php } ?>
	                    	<?php if($this->session->userdata('workshop_is_enabled_jobsheet') == 'Y' && ($this->session->userdata('user_type')==3 || $this->session->userdata('user_type')==4) && $this->session->userdata('plan_type')!=3){ ?>
	                            <a class="dropdown-item" href="<?php echo site_url('mech_work_order_dtls/book'); ?>"><span class="font-icon glyphicon glyphicon-cog"></span><?php _trans('lable585');?></a>
	                    	<?php } ?>
	                            <a class="dropdown-item" href="#"><span class="font-icon glyphicon glyphicon-question-sign"></span><?php _trans('lable606');?></a>
								<div class="dropdown-divider"></div>
							<?php } ?>
	                            <a class="dropdown-item" href="<?php echo site_url('sessions/logout'); ?>"><span class="font-icon glyphicon glyphicon-log-out"></span><?php _trans('lable749'); ?></a>
	                        </div>
	                    </div>
	                    <button type="button" class="burger-right">
	                        <i class="font-icon-menu-addl"></i>
	                    </button>
	                </div><!--.site-header-shown-->
					<div class="mobile-menu-right-overlay"></div>
					<div class="site-header-collapsed">
	                    <div class="site-header-collapsed-in">
							<?php if($this->session->userdata('is_new_user') != 'N'){ ?>
	                        <div class="dropdown">
	                            <button class="btn btn-rounded dropdown-toggle" id="dd-header-add" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<?php _trans('lable748');?>
	                            </button>
	                            <div class="dropdown-menu" aria-labelledby="dd-header-add">
									<a class="dropdown-item" href="<?php echo site_url('mech_work_order_dtls/book'); ?>"><?php _trans('lable269');?></a>
									<a class="dropdown-item" href="<?php echo site_url('mech_invoices/create'); ?>"><?php _trans('lable119');?></a>
									<a class="dropdown-item" href="<?php echo site_url('mech_pos_invoices/create'); ?>"><?php _trans('lable587');?></a>
									<a class="dropdown-item" href="<?php echo site_url('mech_expense/create'); ?>"><?php _trans('lable121');?></a>
									<a class="dropdown-item" href="<?php echo site_url('mech_employee/form'); ?>"><?php _trans('lable456');?></a>
	                                <a class="dropdown-item" href="<?php echo site_url('mech_bank_list/create'); ?>"><?php _trans('lable478');?></a>
	                            </div>
							</div>
							<?php } ?>        	
							<?php if($this->session->userdata('is_new_user') != 'N'){ ?>
	                        <div class="dropdown todayreportmargin">
								<a class="btn btn-rounded todayreport" href="<?php echo site_url('reports/todaysreport'); ?>"><?php _trans('lable747');?></a>
							</div>
							<?php } ?>
							<div class="dropdown todayreportmargin">
								<label class="expiryLabel"><b><?php $diff = date_diff(date_create(date('Y-m-d')),date_create($expiry_date)); echo "Remaining Days : ".$diff->format("%a"); ?></b></label>
							</div>
	                    </div><!--.site-header-collapsed-in-->
					</div><!--.site-header-collapsed-->
				</div><!--site-header-content-in-->
	        </div><!--.site-header-content-->
	    </div><!--.container-fluid-->
	</header>