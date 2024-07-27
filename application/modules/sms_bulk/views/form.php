
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/lib/summernote/summernote.css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/mp_backend/css/separate/pages/editor.min.css">
	<input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?= $this->security->get_csrf_hash(); ?>">
	<div id="gif" class="gifload">
		<div class="gifcenter">
			<center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
		</div>
	</div>
	<header class="page-content-header">
		<div class="container-fluid">
			<div class="tbl">
				<div class="tbl-row">
					<div class="tbl-cell">
						<h3><?php echo _trans($breadcrumb); ?></h3>
					</div>
				</div>	
			</div>
		</div>
	</header>
    <div id="content">
        <div class="row">
			<div class="col-xs-12 top-15">
				<a class="anchor anchor-back" onclick="goBack()"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
			</div>
            <div class="col-xs-12 col-md-12 col-md-offset-3">
				<div class="container">					
					<div class="box">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 box_body">
							<h3 class="text-center"><?php _trans('lable1152'); ?></h3>	
							<div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<h6 class="padding0px margin0px col-lg-5 col-md-5"><?php _trans('lable1149'); ?></h6>
								<h6 class="padding0px margin0px col-lg-2 col-md-2"></h6>
								<h6 class="padding0px margin0px col-lg-5 col-md-5"><?php _trans('lable1150'); ?></h6>
							</div>
							<div class="form-group col-lg-12 col-md-12">
								<div id="leftbox" class="col-lg-5 col-md-5 nameListScrollBox">
									<?php foreach($customer_name_list as $customer_list) {?>
									<div class="nameslist" id="customer_list_id_<?php echo $customer_list->client_id; ?>" onclick="customer_click('<?php echo $customer_list->client_id; ?>')">
										<input type="hidden" name="client_id" data-client_id="<?php echo $customer_list->client_id; ?>" id="client_id_<?php echo $customer_list->client_id; ?>" class="customer_active form-control" value="<?php echo "N"; ?>" autocomplete="off">
										<?php echo $customer_list->client_name . ($customer_list->client_contact_no?' ( '.$customer_list->client_contact_no.' ) ':''); ?> 
									</div>
									<?php } ?>
								</div>
								<div class="col-lg-2 col-md-2 text-center">
									<br>
									<button value="1" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 btn add_btn whiteSpace">
										<i></i> <?php _trans('lable70'); ?>
									</button>
									<br><br>
									<button value="2" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 btn addall_btn whiteSpace">
										<i></i> <?php _trans('lable1157'); ?>
									</button>
									<br><br>
									<button value="3" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 btn remove_btn whiteSpace">
										<i></i> <?php _trans('lable1158'); ?>
									</button>
									<br><br>
									<button value="4" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 btn removeall_btn whiteSpace">
										<i></i> <?php _trans('lable1159'); ?>
									</button>
								</div>
								<div id="rightbox" class="col-lg-5 col-md-5 nameListScrollBox" >
									<?php foreach ($customer_name_list as $customer_list) {?>
									<div class="nameslist" id="customer_list_id_<?php echo $customer_list->client_id; ?>" onclick="customer_click('<?php echo $customer_list->client_id; ?>')">
										<input type="hidden" name="client_id" data-client_id="<?php echo $customer_list->client_id; ?>" id="client_id_<?php echo $customer_list->client_id; ?>" class="customer_right_active form-control" value="<?php echo "N"; ?>" autocomplete="off">
									</div>
									<?php }?>
								</div>
							</div>
				
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 form-group paddingTop20px">
								<label class="control-label string required"><?php _trans('lable1167'); ?>*</label>
								<input class="form-control" type="text" name="campaign_name" id="campaign_name" value="<?php echo $customer_list->campaign_name; ?>" autocomplete="off">
							</div>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 form-group paddingTop20px">
								<label class="control-label string required"><?php _trans('lable810'); ?>*</label>
								<div class="summernote-theme-1">
									<textarea name="smsbody" id="smsbody" class="form-control summernote"></textarea>								
								</div>
							</div>								
							<div class="buttons text-center paddingtop15px">
							<button value="2" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
								<i class="fa fa-check"></i> <?php _trans('lable1187'); ?>
							</button>
							<button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default">
								<i class="fa fa-times"></i> <?php _trans('lable58'); ?>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/mp_backend/js/lib/summernote/summernote.min.js"></script>
<script type="text/javascript">

    $(document).ready(function() {
	  $('.summernote').summernote();
	});

	function goBack() {
      window.history.back();
    }	

	$("#btn_cancel").click(function () {
        window.location.href = "<?php echo site_url('sms_bulk/form'); ?>";
	});

	function customer_click(client_id){
		if($("#client_id_" + client_id).val() == "N"){
			$("#customer_list_id_" + client_id).addClass('active');
			$("#client_id_" + client_id).val('Y');
		}else{
			$("#customer_list_id_" + client_id).removeClass('active');
			$("#client_id_" + client_id).val('N');
		}
	}

	function customer_right_click(client_id){
		if($("#client_id_" + client_id).val() == "Y"){
			$("#customer_list_id_" + client_id).addClass('active');
			$("#client_id_" + client_id).val('N');
		}else{
			$("#customer_list_id_" + client_id).removeClass('active');
			$("#client_id_" + client_id).val('Y');
		}
	}
	

	// when click add button
	$(".add_btn").click(function () {

		var client_list = [];
		$('.customer_active').each(function() {
			if ($(this).val() == 'Y') {
				client_list.push($(this).attr('data-client_id'));
			}
        });
		
		$.post('<?php echo site_url('sms_bulk/ajax/add'); ?>', {
			_mm_csrf: $('#_mm_csrf').val()
		}, function (data) {
			list = JSON.parse(data);
   			var selectedlist = [];
			var unselectedlist = [];
			for (var i = 0; i < list.customer_name_list.length; i++) {
				if (jQuery.inArray(list.customer_name_list[i].client_id, client_list)!='-1') {
					selectedlist.push(list.customer_name_list[i]);
				} else {
					unselectedlist.push(list.customer_name_list[i]);
				}
			}
			var html1 = '';
            for(var j = 0; j < selectedlist.length; j++) {
				html1 += '<div class="nameslist" id="customer_list_id_'+selectedlist[j].client_id+'" onclick="customer_right_click('+selectedlist[j].client_id+')" >';
				html1 += '<input type="hidden" name="client_id" data-client_id="'+selectedlist[j].client_id +'" id="client_id_'+selectedlist[j].client_id +'"  class="customer_active form-control" value="<?php echo "Y"; ?>" autocomplete="off">';
				html1 += selectedlist[j].client_name  + (selectedlist[j].client_contact_no?' ( '+selectedlist[j].client_contact_no+' ) ':''); 
				html1 += '</div>';	
			}
            $('#rightbox').html(html1);
			
			var html = '';
            for(var k = 0; k < unselectedlist.length; k++) {
				html += '<div class="nameslist" id="customer_list_id_'+unselectedlist[k].client_id+'" onclick="customer_click('+unselectedlist[k].client_id+')">';
				html += '<input type="hidden" name="client_id" data-client_id="'+unselectedlist[k].client_id+'" id="client_id_'+unselectedlist[k].client_id+'" class="customer_active form-control" value="<?php echo "N"; ?>" autocomplete="off">';
				html += unselectedlist[k].client_name + (unselectedlist[k].client_contact_no?' ( '+unselectedlist[k].client_contact_no+' ) ':''); 
				html += '</div>';	
			}
            $('#leftbox').html(html);
			return false;
		});
	});



	// when add all button is clicked
	$(".addall_btn").click(function () {

			$.post('<?php echo site_url('sms_bulk/ajax/add'); ?>', {
				_mm_csrf: $('#_mm_csrf').val()
			}, function (data) {
				list = JSON.parse(data);
				var selectedalllist = [];
				
				for (var i = 0; i < list.customer_name_list.length; i++) {
					selectedalllist.push(list.customer_name_list[i]);
				}

				var html = '';
				for(var l = 0; l < selectedalllist.length; l++) {
				html += '<div class="nameslist" id="customer_list_id_'+selectedalllist[l].client_id+'" onclick="customer_click('+selectedalllist[l].client_id+')" >';
				html += '<input type="hidden" name="client_id" data-client_id="'+selectedalllist[l].client_id+'" id="client_id_'+selectedalllist[l].client_id+'" class="customer_active form-control" value="<?php echo "N"; ?>" autocomplete="off">';
				html += selectedalllist[l].client_name + (selectedalllist[l].client_contact_no?' ( '+selectedalllist[l].client_contact_no+' ) ':''); 
				html += '</div>';	
				}
				$('#rightbox').html(html);

				var html1 = '';
				$('#leftbox').html(html1);
			});
	});

	$(".remove_btn").click(function () {

		var client_list = [];

		$('.customer_active').each(function() {
			if ($(this).val() == 'Y') {
				client_list.push($(this).attr('data-client_id'));
			}
		});

		$.post('<?php echo site_url('sms_bulk/ajax/add'); ?>', {
			_mm_csrf: $('#_mm_csrf').val()
		}, function (data) {
			list = JSON.parse(data);
			var selectedlist = [];
			var unselectedlist = [];
			
			for (var i = 0; i < list.customer_name_list.length; i++) {
				if (jQuery.inArray(list.customer_name_list[i].client_id, client_list)!='-1') {
					selectedlist.push(list.customer_name_list[i]);
				} else {
					unselectedlist.push(list.customer_name_list[i]);
				}
			}

			var html = '';
            for(var j = 0; j < selectedlist.length; j++) {
			html += '<div class="nameslist" id="customer_list_id_'+selectedlist[j].client_id+'" onclick="customer_right_click('+selectedlist[j].client_id+')" >';
			html += '<input type="hidden" name="client_id" data-client_id="'+selectedlist[j].client_id +'" id="client_id_'+selectedlist[j].client_id +'"  class="customer_active form-control" value="<?php echo "Y"; ?>" autocomplete="off">';
			html += selectedlist[j].client_name + (selectedlist[j].client_contact_no?' ( '+selectedlist[j].client_contact_no+' ) ':''); 
			html += '</div>';	
			}
            $('#rightbox').html(html);
			
			var html1 = '';
            for(var k = 0; k < unselectedlist.length; k++) {
			html1 += '<div class="nameslist" id="customer_list_id_'+unselectedlist[k].client_id+'" onclick="customer_click('+unselectedlist[k].client_id+')" >';
			html1 += '<input type="hidden" name="client_id" data-client_id="'+unselectedlist[k].client_id+'" id="client_id_'+unselectedlist[k].client_id+'" class="customer_active form-control" value="<?php echo "N"; ?>" autocomplete="off">';
			html1 += unselectedlist[k].client_name + (unselectedlist[k].client_contact_no?' ( '+unselectedlist[k].client_contact_no+' ) ':''); 
			html1 += '</div>';	
			}
            $('#leftbox').html(html1);
			return false;
		});
	});


	// when click remove all button
	$(".removeall_btn").click(function () {

			$.post('<?php echo site_url('sms_bulk/ajax/add'); ?>', {
				_mm_csrf: $('#_mm_csrf').val()
			}, function (data) {
				list = JSON.parse(data);
				var removeall = [];

				for (var i = 0; i < list.customer_name_list.length; i++) {
					removeall.push(list.customer_name_list[i]);
				}

				var html = '';
				for(var l = 0; l < removeall.length; l++) {
				html += '<div class="nameslist" id="customer_list_id_'+removeall[l].client_id+'" onclick="customer_click('+removeall[l].client_id+')">';
				html += '<input type="hidden" name="client_id" data-client_id="'+removeall[l].client_id+'" id="client_id_'+removeall[l].client_id+'" class="customer_active form-control" value="<?php echo "N"; ?>" autocomplete="off">';
				html += removeall[l].client_name + (removeall[l].client_contact_no?' ( '+removeall[l].client_contact_no+' ) ':''); 
				html += '</div>';	
				}
				$('#leftbox').html(html);

				var html1 = '';
				$('#rightbox').html(html1);
			});
		});

    $(".btn_submit").click(function () {

		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');

		var client_list = [];

		$('#rightbox .customer_active').each(function() {
			var obj = {};
			if ($(this).val() == 'Y') {
				if($(this).attr('data-client_id') != ''){
					client_list.push($(this).attr('data-client_id'));
				}
			}
		});

		var plan= [];

		if($("#campaign_name").val() == ''){
			plan.push('campaign_name');
		}
	
		if($("#smsbody").val() == ''){
			plan.push('smsbody');
		}

		if(plan.length > 0){
			plan.forEach(function(val) {
				$('#'+val).addClass("border_error");
				if($('#'+val+'_error').length == 0){
					$('#' + val).parent().addClass('has-error');
				} 
			});
			return false;
		}

		if(client_list.length > 0){
			$('#gif').show();
			$.post('<?php echo site_url('sms_bulk/ajax/create'); ?>', {
				client_list : JSON.stringify(client_list),
				smsbody : $('#smsbody').val(),
				campaign_name : $('#campaign_name').val(),
				workshop_email_id : $('#workshop_email').val(),
				workshop_name : $('#workshop_name').val(),
				_mm_csrf : $('#_mm_csrf').val()
			}, function (data) {
				list = JSON.parse(data);
				if(list.success=='1'){
					notie.alert(1, 'Successfully Mail Sent', 3);
					setTimeout(function(){
						window.location = "<?php echo site_url('sms_bulk'); ?>";
					}, 100);
				}else{
					$('#gif').hide();
					notie.alert(3, 'Oops, something has gone wrong', 2);
				}
			});
		}else{
			notie.alert(3, 'Please choose atleast one customer', 2);
		}
	});

</script>
<style>
.multiple{
	height: 30%;
    width: 80%;
}
.active{
	background: gray;
	color: white;
}

</style>