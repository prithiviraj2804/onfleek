<header class="page-content-header">
			<div class="container-fluid">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Add Insurance</h3>
						</div>
					</div>
				</div>
			</div>
</header>

<?php 
if($this->session->userdata('user_type') == 1){
	$this->layout->load_view('mech_insurance/partial_admin_insurance_form');
}else{
	$this->layout->load_view('mech_insurance/partial_user_insurance_form');
}
?>
<?php $this->layout->load_view('layout/alerts'); ?>
<?php 
if(isset($validation)){
	echo validation_errors();
}
?>
