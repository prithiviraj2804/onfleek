<header class="page-content-header">
			<div class="container-fluid">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell" id="total_user_quote">
							<h3><?php echo $label_name." ( ".count($quote_book_list)." )"; ?></h3>
						</div>
						<div class="tbl-cell tbl-cell-action">
							<a href="<?php echo site_url('user_quotes/book'); ?>" id="get_new_quote" class="btn btn-rounded">GET A NEW JOB CARD</a>
						</div>
					</div>
				</div>
			</div>
</header>

<div class="container-fluid">
	<?php
	if($this->session->userdata('user_type') == 1){
		$this->layout->load_view('user_quotes/partial_admin_quote_table');
	}else{
		if($url_from == 'c'){
			$this->layout->load_view('user_quotes/partial_admin_quote_table');
		}elseif($url_from == 're'){
			$this->layout->load_view('user_quotes/partial_user_quote_table');
		}elseif($url_from == 'ru'){
			$this->layout->load_view('user_quotes/partial_running_quote_table');
		}
	}
	?>
</div><!--.container-fluid-->