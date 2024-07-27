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
					<h3><?php echo "Import Customers"; ?></h3>
				</div>
				<div class="tbl-cell pull-right">
          <a class="btn btn-sm btn-primary" href="<?php echo site_url('mech_item_master/product_create'); ?>">
            <i class="fa fa-plus"></i> <?php _trans('lable40'); ?>
          </a>
				</div>
			</div>
		</div>
	</div>
</header>

<?php if (isset($active_tab)) {
    if ($active_tab == 1) {
        $one_tab_active = 'active show in';
        $two_tab_active = '';
        $three_tab_active = '';
        $one_area_selected = true;
        $two_area_selected = false;
        $three_area_selected = false;
    } elseif ($active_tab == 2) {
        $one_tab_active = '';
        $two_tab_active = 'active show in';
        $three_tab_active = '';
        $one_area_selected = false;
        $two_area_selected = true;
        $three_area_selected = false;
    } 
} else {
    $one_tab_active = 'active show in';
    $two_tab_active = '';
    $three_tab_active = '';
    $one_area_selected = true;
    $two_area_selected = false;
    $three_area_selected = false;
}
?>
<div id="content" class="usermanagement uploadcss">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 top-15">
			<a class="anchor anchor-back" href="<?php echo site_url('mech_item_master'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
		</div>
  </div>
  <section class="card">
    <div class="card-block">
      <div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop20px">
        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-9 instruction_content"><?php _trans('lable609'); ?> <a class="download_sample"  href="<?php echo site_url('mech_item_master/download_product_csv'); ?>"><?php _trans('lable608'); ?></a> <?php _trans('lable607'); ?></div>
      </div>
      <div class="row paddingTop20px">
		    <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 paddingTop20px">
          <ul class="nav nav-tabs paddingTop20px" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="upload_result" onclick="change_active_tab('upload_result')" data-toggle="tab" href="#upload_result_li" role="tab" aria-controls="upload_result_li" aria-selected="false"><?php _trans('lable606'); ?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="read_me" onclick="change_active_tab('read_me')" data-toggle="tab" href="#read_me_li" role="tab" aria-controls="How" aria-selected="true"><?php _trans('lable605'); ?></a>
            </li>
            
          </ul>
          <div class="tab-content">
              <div class="tab-pane" id="read_me_li" role="tabpanel" aria-labelledby="read_me_li-tab">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop20px"><?php _trans('lable605'); ?></div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop20px"><?php _trans('lable604'); ?></div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop20px"><?php _trans('lable603'); ?></div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop20px"><?php _trans('lable602'); ?></div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop20px"><?php _trans('lable601'); ?></div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop20px"><?php _trans('lable600'); ?></div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop20px"><?php _trans('lable599'); ?></div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop20px"><?php _trans('lable598'); ?></div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop20px"><?php _trans('lable597'); ?></div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingTop20px"><?php _trans('lable596'); ?></div>
              </div>
            <div class="tab-pane active" id="upload_result_li" role="tabpanel" aria-labelledby="upload_result_li-tab">
              <section class="card">
                <div class="card-block">
                  <div class="col-lg-12 col-md-12 col-sm-12 padding20px upload_border">
                    <form class="col-lg-12 col-md-12 col-sm-12" id="upload_csv" method="post" enctype="multipart/form-data">  
                      <div class="padding0px col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input type="file" id="chfile" onchange="getfile()" name="product_file" class="inputfile"/>
                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3 btn" style="cursor:pointer;" id="choose_file"><?php _trans('lable595'); ?></div>
                        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-9">
                          <span class="paddingTop10px pull-left file_name"><span id="file_name"></span></span>
                          <button type="submit" class="btn float_right layout_bordor_color layout_bg_color upload_btn" id="upload_btn"><?php _trans('lable594'); ?></button>
                        </div>
                        <div id="show_upload_error" style="display:none;"><?php _trans('lable593'); ?></div>
                      </div>
                      <input type="hidden" name="_mm_csrf" id="_mm_csrf" value="<?=$this->security->get_csrf_hash(); ?>">
                    </form> 
                  </div>
                  <div class="overflowScrollForTable">
                      <table id="result_table" class="table table-bordered table-striped list-out-box">
                        <thead>
                            <tr class="table_header_bgcolor">
                                <th><?php _trans('lable592'); ?></th>
                                <th><?php _trans('lable19'); ?></th>
                                <th><?php _trans('lable36'); ?></th>
                                <th><?php _trans('lable591'); ?></th>
                            </tr>
                        </thead>
                        <tbody id="upload_result_table">
                          <?php if(count($message) > 0){foreach ($message as $key => $value) { ?>
                            <?php if($value->upload_status == 'Success'){
                                  $statusClass = 'class="sucess_case"';
                                }else{
                                  $statusClass = 'class="fail_case"';
                                }
                                  ?>
                            <tr>
                              <td><span><?php echo $value->excel_id;?></span></td>
                              <td><span <?php echo $statusClass;?>><?php echo $value->upload_status;?></span></td>
                              <td><?php echo $value->entity_name;?></td>
                              <td><?php echo $value->message;?></td>
                            </tr>
                            <?php } } else{ ?>
                            <tr>
                              <td colspan="4" class="text-center"><span><?php _trans('lable590'); ?></span></td>
                            </tr>
                           <?php } ?>
                        </tbody>
                      </table>
                  </div>
                </div>
              </section>              
            </div>
          </div>
        </div>
      </div>
  </div>
</section>
</div>
<script type="text/javascript">

function close_upload(){
  window.location = "<?php echo site_url('clients'); ?>";
}

function getfile(){
 var filename = $('input[type=file]').val().split("\\");
  $("#file_name").empty().append("Select file : "+filename[2]);
}

function change_active_tab(selector){
  $(".nav-link").removeClass('active');
  $(".tab-pane").removeClass('in active');
  $("#"+selector+'_li').addClass("active");
  $("#"+selector).addClass('in active');
}

$(document).ready(function(){
    var upload_status = <?php echo json_encode($message);?>;

    if(upload_status.length > 0){
      change_active_tab('upload_result'); 
    }

    $("#upload_loader").hide();

    $("#choose_file").click(function()
    {
      $("#chfile").click();
    });

    $('#upload_csv').on("submit", function(e){               
      e.preventDefault(); //form will not submitted 
      if($('input[type=file]').val() == ""){
        $("#show_upload_error").empty().append("Choose a file to upload");
        $("#show_upload_error").show();
        return false;
      }else{
        $("#show_upload_error").hide();
      }

      $("#gif").show();
      
      // var company_gstin_id = $("#company_gstin_id").val();
      $.ajax({  
           url:"<?php echo site_url('mech_item_master/import_product_csv'); ?>",
           method:"POST",  
           data:new FormData(this),
           contentType:false,          // The content type used when sending data to the server.  
           cache:false,                // To unable request pages to be cached  
           processData:false,          // To send DOMDocument or non processed data file it is set to false  
           success: function(data){ 
             //console.log(data);
            // return false;
           var response = JSON.parse(data);
           //console.log(response);
                if(response.success=='1')  
                {
                    $("#gif").hide();
                    window.location = "<?php echo site_url('mech_item_master/product_upload'); ?>";
                }
                else if(response.success=='3'){
                    $("#gif").hide();
                    $("#show_upload_error").empty().append("Please upload only xls file format.");
                    $("#show_upload_error").show();
                }else if(response.success=='0'){
                    $("#gif").hide();
                    $("#show_upload_error").empty().append(response.validation_errors);
                    $("#show_upload_error").show();
                }
            }  
        })  
    }); 
});
</script>