<form method="post" class="form">

    <input type="hidden" name="_mm_csrf" value="<?= $this->security->get_csrf_hash() ?>">
<header class="page-content-header">
			<div class="container-fluid">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3><?php _trans('lable665'); ?></h3>
						</div>
					</div>
				</div>
			</div>
</header>
    <div id="content">
        <div class="row">
            <div class="col-xs-12 col-md-12 col-md-offset-3">

                <?php echo $this->layout->load_view('layout/alerts'); ?>

                <div class="container-wide">
	<div class="box">
		<div class="row">
		<div class="col-xs-12">
			<?php if ($this->session->userdata('user_type') == 3) { ?>
            	<a class="anchor anchor-back" href="<?php echo site_url('dashboard'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable666'); ?></span></a>
			<?php } else if($this->session->userdata('user_type') == 1){ ?>
				<a class="anchor anchor-back" href="<?php echo site_url('users'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable677'); ?></span></a>
			<?php } ?>
		</div>
		</div>
		<div class="box_body">
				<div class="form_group">
					<label class="form_label"><?php _trans('lable676'); ?> *</label>	
					<div class="form_controls">
						<input class="g-input" <?php if($this->mdl_users->form_value('user_name', true)){ echo "disabled";} ?> type="text" placeholder="Your name" name="user_name" id="user_name" value="<?php echo $this->mdl_users->form_value('user_name', true); ?>">
					</div>
				</div>
				<?php if($this->session->userdata('user_type') == 1){ ?>
				<div class="form_group">
					<label class="form_label"><?php _trans('lable551'); ?></label>
					<div class="form_controls">
						<select name="user_type" id="user_type" <?php if($this->mdl_users->form_value('user_type', true)){ echo "disabled";} ?>>
							<option value=""><?php _trans('lable675'); ?></option>
							<option value="1" <?php if($this->mdl_users->form_value('user_type')==1){ echo "selected"; } ?>><?php _trans('lable674'); ?></option>
							<option value="2" <?php if($this->mdl_users->form_value('user_type')==2){ echo "selected"; } ?>><?php _trans('lable370'); ?></option>
							<option value="3" <?php if($this->mdl_users->form_value('user_type')==3){ echo "selected"; } ?>><?php _trans('menu7'); ?></option>
							<option value="4" <?php if($this->mdl_users->form_value('user_type')==4){ echo "selected"; } ?>><?php _trans('lable95'); ?></option>
						</select>
					</div>
				</div>
				<?php } else if($this->session->userdata('user_type')){ ?>
					<input type="hidden" name="user_type" id="user_type" value="<?php echo $this->session->userdata('user_type'); ?>">
				<?php } ?>
				<div class="form_group">
					<label class="form_label"><?php _trans('lable673'); ?>*</label>
					<div class="form_controls">
						<input class="g-input" type="email" name="user_email" id="user_email" <?php if($this->mdl_users->form_value('user_email', true)){ echo "disabled";} ?> value="<?php echo $this->mdl_users->form_value('user_email', true); ?>" <?php echo $readonly; ?>>
					</div>
				</div>
				<div class="form_group">
					<label class="form_label"><?php _trans('lable672'); ?> *</label>
					<div class="form_controls">
						<input class="g-input" type="tel" placeholder="Your phone number" <?php if($this->mdl_users->form_value('user_mobile', true)){ echo "disabled";} ?> name="user_mobile" id="user_mobile" value="<?php echo $this->mdl_users->form_value('user_mobile', true); ?>" <?php echo $readonly; ?>>
					</div>
				</div>
				<div class="form_group">
					<label class="form_label"><?php _trans('lable671'); ?></label>
					<div class="form_controls">
						<input class="g-input" type="tel" <?php if($this->mdl_users->form_value('user_phone', true)){ echo "disabled";} ?> placeholder="Your Alternative phone number" name="user_phone" id="user_phone" value="<?php echo $this->mdl_users->form_value('user_phone', true); ?>">
					</div>
				</div>
				
				<div class="form_group">
					<label class="form_label"><?php _trans('lable19'); ?></label>
					<div class="form_controls">
						<select name="user_active" id="user_active" <?php if($this->mdl_users->form_value('user_active', true)){ echo "disabled";} ?>>
							<option value=""><?php _trans('lable670'); ?></option>
							<option value="1" <?php if($this->mdl_users->form_value('user_active')==1){ echo "selected"; } ?>><?php _trans('lable669'); ?></option>
							<option value="2" <?php if($this->mdl_users->form_value('user_active')==2){ echo "selected"; } ?>><?php _trans('lable668'); ?></option>
						</select>
					</div>
				</div>
				<?php /* * / ?>
				<div class="form_group">
					<label class="form_label">Mobile Verify</label>
					<div class="form_controls">
						<select name="mobile_verify" id="mobile_verify">
							<option value="">Choose Mobile Verification</option>
							<option value="1" <?php if($this->mdl_users->form_value('mobile_verify')==1){ echo "selected"; } ?>>Yes</option>
							<option value="2" <?php if($this->mdl_users->form_value('mobile_verify')==2){ echo "selected"; } ?>>No</option>
						</select>
					</div>
				</div>
				<div class="form_group">
					<label class="form_label">Email Verify</label>
					<div class="form_controls">
						<select name="email_verify" id="email_verify">
							<option value="">Choose Email Verification</option>
							<option value="1" <?php if($this->mdl_users->form_value('email_verify')==1){ echo "selected"; } ?>>Yes</option>
							<option value="2" <?php if($this->mdl_users->form_value('email_verify')==2){ echo "selected"; } ?>>No</option>
						</select>
					</div>
				</div>
				<div class="form_group">
					<label class="form_label">Status</label>
					<div class="form_controls">
						<select name="status" id="status">
							<option value="">Choose Email Verification</option>
							<option value="1" <?php if($this->mdl_users->form_value('status')==1){ echo "selected"; } ?>>Active</option>
							<option value="2" <?php if($this->mdl_users->form_value('status')==2){ echo "selected"; } ?>>Inactive</option>
						</select>
					</div>
				</div>
				<?php / * */ ?>
				<?php /* * / ?>
				<div class="form_group">
					<label class="form_label">New Password</label>
					<div class="form_controls">
						<input class="g-input" type="password" name="password" id="password">
					</div>
				</div>
				<div class="form_group">
					<label class="form_label">Confirm Password</label>
					<div class="form_controls">
						<input class="g-input" type="password" name="user_passwordv" id="user_passwordv">
					</div>
				</div>
				<?php / * */ ?>
				<?php if($this->session->userdata('user_type') == 3 && $this->mdl_users->form_value('user_id') != ''){ ?>
				<div class="form_group">
					<label class="form_label"><a href="<?php echo site_url('users/change_password/'.$this->mdl_users->form_value('user_id')); ?>"><?php _trans('lable667'); ?></a></label>
				</div>
				<?php } ?>
				<div class="buttons text-center">
					<?php echo $this->layout->load_view('layout/header_buttons'); ?>
				</div>
		</div>
	</div>

</div>
            </div>
        </div>
    </div>

</form>
