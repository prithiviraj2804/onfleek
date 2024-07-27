<?php /* * / ?>
<form method="post">
    <div id="headerbar">
        <h1 class="headerbar-title"><?php _trans('email_template_form'); ?></h1>
        <?php $this->layout->load_view('layout/header_buttons'); ?>
    </div>
    <div id="content">
        <?php $this->layout->load_view('layout/alerts'); ?>
        <input class="hidden" name="is_update" type="hidden"
            <?php if ($this->mdl_email_templates->form_value('is_update')) {
                echo 'value="1"';
            } else {
                echo 'value="0"';
            } ?>
        >
        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                <div class="form-group">
                    <label for="email_template_title" class="control-label"><?php _trans('title'); ?></label>
                    <input type="text" name="email_template_title" id="email_template_title"
                           value="<?php echo $this->mdl_email_templates->form_value('email_template_title', true); ?>"
                           class="form-control" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="email_template_type" class="control-label"><?php _trans('type'); ?></label>
                    <div class="radio">
                        <label>
                            <input type="radio" name="email_template_type" id="email_template_type_invoice"
                                   value="invoice" checked>
                            <?php _trans('lable119'); ?>
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="email_template_type" id="email_template_type_invoice"
                                   value="quote">
                            <?php _trans('quote'); ?>
                        </label>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label for="email_template_from_name" class="control-label">
                        <?php _trans('from_name'); ?>
                    </label>
                    <input type="text" name="email_template_from_name" id="email_template_from_name"
                           class="form-control taggable"
                           value="<?php echo $this->mdl_email_templates->form_value('email_template_from_name', true); ?>" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="email_template_from_email" class="control-label">
                        <?php _trans('from_email'); ?>
                    </label>
                    <input type="text" name="email_template_from_email" id="email_template_from_email"
                           class="form-control taggable"
                           value="<?php echo $this->mdl_email_templates->form_value('email_template_from_email', true); ?>" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="email_template_cc" class="control-label"><?php _trans('cc'); ?></label>
                    <input type="text" name="email_template_cc" id="email_template_cc" class="form-control taggable"
                           value="<?php echo $this->mdl_email_templates->form_value('email_template_cc', true); ?>" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="email_template_bcc" class="control-label"><?php _trans('bcc'); ?>: </label>
                    <input type="text" name="email_template_bcc" id="email_template_bcc" class="form-control taggable"
                           value="<?php echo $this->mdl_email_templates->form_value('email_template_bcc', true); ?>" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="email_template_subject" class="control-label">
                        <?php _trans('subject'); ?>
                    </label>
                    <input type="text" name="email_template_subject" id="email_template_subject"
                           class="form-control taggable"
                           value="<?php echo $this->mdl_email_templates->form_value('email_template_subject', true); ?>" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="email_template_pdf_template" class="control-label">
                        <?php _trans('pdf_template'); ?>:
                    </label>
                    <select name="email_template_pdf_template" id="email_template_pdf_template"
                            class="form-control simple-select removeError" autocomplete="off">
                        <option value=""><?php _trans('none'); ?></option>
                        <optgroup label="<?php _trans('invoices'); ?>">
                            <?php foreach ($invoice_templates as $template): ?>
                                <option class="hidden-invoice" value="<?php echo $template; ?>"
                                    <?php check_select($selected_pdf_template, $template); ?>>
                                    <?php echo $template; ?>
                                </option>
                            <?php endforeach; ?>
                        </optgroup>
                        <optgroup label="<?php _trans('quotes'); ?>">
                            <?php foreach ($quote_templates as $template): ?>
                                <option class="hidden-quote" value="<?php echo $template; ?>"
                                    <?php check_select($selected_pdf_template, $template); ?>>
                                    <?php echo $template; ?>
                                </option>
                            <?php endforeach; ?>
                        </optgroup>
                    </select>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <label for="email_template_body">
                    <?php _trans('body'); ?>
                </label>
                <div class="form-group">
                    <div class="html-tags btn-group btn-group-sm">
                        <span class="html-tag btn btn-default" data-tag-type="text-paragraph">
                            <i class="fa fa-fw fa-paragraph"></i>
                        </span>
                        <span class="html-tag btn btn-default" data-tag-type="text-bold">
                            <i class="fa fa-fw fa-bold"></i>
                        </span>
                        <span class="html-tag btn btn-default" data-tag-type="text-italic">
                            <i class="fa fa-fw fa-italic"></i>
                        </span>
                    </div>
                    <div class="html-tags btn-group btn-group-sm">
                        <span class="html-tag btn btn-default" data-tag-type="text-h1">H1</span>
                        <span class="html-tag btn btn-default" data-tag-type="text-h2">H2</span>
                        <span class="html-tag btn btn-default" data-tag-type="text-h3">H3</span>
                        <span class="html-tag btn btn-default" data-tag-type="text-h4">H4</span>
                    </div>
                    <div class="html-tags btn-group btn-group-sm">
                        <span class="html-tag btn btn-default" data-tag-type="text-code">
                            <i class="fa fa-fw fa-code"></i>
                        </span>
                        <span class="html-tag btn btn-default" data-tag-type="text-hr">
                            &lt;hr/&gt;
                        </span>
                        <span class="html-tag btn btn-default" data-tag-type="text-css">
                            CSS
                        </span>
                    </div>
                    <textarea name="email_template_body" id="email_template_body" rows="5"
                              class="email-template-body form-control taggable" autocomplete="off"><?php echo $this->mdl_email_templates->form_value('email_template_body', true); ?></textarea>
                    <br>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php // _trans('preview'); ?>
                            <span id="email-template-preview-reload" class="pull-right cursor-pointer">
                                <i class="fa fa-refresh"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <iframe id="email-template-preview"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <?php // $this->layout->load_view('email_templates/template-tags'); ?>
            </div>
        </div>
    </div>
</form>
<script>
    $(function () {
        var email_template_type = "<?php //echo $this->mdl_email_templates->form_value('email_template_type'); ?>";
        var $email_template_type_options = $("[name=email_template_type]");

        $email_template_type_options.click(function () {
            // remove class "show" and deselect any selected elements.
            $(".show").removeClass("show").parent("select").each(function () {
                this.options.selectedIndex = 0;
            });
            // add show class to corresponding class
            $(".hidden-" + $(this).val()).addClass("show");
        });
        if (email_template_type === "") {
            $email_template_type_options.first().click();
        } else {
            $email_template_type_options.each(function () {
                if ($(this).val() === email_template_type) {
                    $(this).click();
                }
            });
        }
    });
</script>
<?php / * */ ?>
<header class="page-content-header">
	<div class="container-fluid">
		<div class="tbl">
			<div class="tbl-row">
				<div class="tbl-cell">
					<h3><?php echo "Email Template"; ?></h3>
				</div>
				<div class="tbl-cell pull-right">
					<a class="btn btn-sm btn-primary" href="<?php echo site_url('email_templates/form'); ?>">
            			<i class="fa fa-plus"></i> <?php _trans('new'); ?>
        			</a>
				</div>
			</div>
		</div>
	</div>
</header>
<div id="content" class="usermanagement">
    <div class="row">
        <div id="gif" class="gifload">
			<div class="gifcenter">
			  <center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
		    </div>
		</div>
		<div class="col-xs-12 top-15">
			<a class="anchor anchor-back" href="<?php echo site_url('workshop_setup/index/8'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59');?></span></a>
		</div>
        <div class="col-xs-12 col-md-12 col-md-offset-3">
			<?php $this->layout->load_view('layout/alerts'); ?>
			<div class="container-wide">
                <input type="hidden" id="_mm_csrf" name="_mm_csrf" value="<?= $this->security->get_csrf_hash(); ?>">
                <input class="hidden" name="is_update" type="hidden" id="is_update"
                <?php if ($this->mdl_email_templates->form_value('is_update')) {
                    echo 'value="1"';
                } else {
                    echo 'value="0"';
                } ?> >
                <div class="box">
                    <div class="box_body">
                        <div class="form-group clearfix">
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-right">
                                <label class="control-label string required"><?php _trans('lable51');?>*</label>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <select id="branch_id" name="branch_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off" >
                                    <?php foreach ($branch_list as $branchList) {?>
                                    <option value="<?php echo $branchList->w_branch_id; ?>" <?php if($this->mdl_email_templates->form_value('branch_id', true) == $branchList->w_branch_id){echo "selected";}?> > <?php echo $branchList->display_board_name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable496'); ?>*</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="hidden" name="email_template_id" id="email_template_id" class="form-control" value="<?php echo $this->mdl_email_templates->form_value('email_template_id', true); ?>">
                                <input class="form-control" type="text" name="email_template_title" id="email_template_title" value="<?php echo $this->mdl_email_templates->form_value('email_template_title', true); ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable104'); ?>*</label>
                            </div>
                            <div class="col-sm-9">
                                <select name="email_template_type" id="email_template_type" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" autocomplete="off">
                                    <option value= "">Select type</option>
                                    <option value="I" <?php if($this->mdl_email_templates->form_value('email_template_type', true)){ echo "selected"; } ?>><?php _trans('lable119'); ?></option>
                                    <option value="J" <?php if($this->mdl_email_templates->form_value('email_template_type', true)){ echo "selected"; } ?>><?php _trans('lable269'); ?></option>
                                    <option value="A" <?php if($this->mdl_email_templates->form_value('email_template_type', true)){ echo "selected"; } ?>><?php _trans('lable501'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable810'); ?>*</label>
                            </div>
                            <div class="col-sm-9">
                                <textarea name="email_template_body" id="email_template_body" class="form-control " ><?php echo $this->mdl_email_templates->form_value('email_template_body', true); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable811'); ?></label>
                            </div>
                            <div class="col-sm-9">
                                <textarea name="email_template_subject" id="email_template_subject" class="form-control" ><?php echo $this->mdl_email_templates->form_value('email_template_subject', true); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable812'); ?></label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="email_template_from_name" id="email_template_from_name" class="form-control" value="<?php echo $this->mdl_email_templates->form_value('email_template_from_name', true); ?>" >
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable813'); ?></label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="email_template_cc" id="email_template_cc" class="form-control" value="<?php echo $this->mdl_email_templates->form_value('email_template_cc', true); ?>" >
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-sm-3 text-right">
                                <label class="control-label string required"><?php _trans('lable814'); ?></label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="email_template_bcc" id="email_template_bcc" class="form-control" value="<?php echo $this->mdl_email_templates->form_value('email_template_bcc', true); ?>" >
                            </div>
                        </div>
                        <div class="buttons text-center">
                            <div class="buttons text-center">
                                <button value="1" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
                                    <i class="fa fa-check"></i> <?php _trans('lable56'); ?>
                                </button>
                                <button value="2" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
                                    <i class="fa fa-check"></i> <?php _trans('lable57'); ?>
                                </button>
                                <button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default">
                                    <i class="fa fa-times"></i><?php _trans('lable58'); ?>
                                </button>
                            </div>	
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

        // $("textarea").keyup(function() {
        //     var len = (this.value).length;
        //     if (len > 0) {
        //         $('#' + $(this).attr('name')).parent().removeClass('has-error');
        //         $('#' + $(this).attr('name')).removeClass('border_error');

        //     } 
        // });

		// $("select").onchange(function() {
        //     var len = (this.value).length;
        //     if (len > 0) {
        //         $('#' + $(this).attr('name')).parent().removeClass('has-error');
        //         $('#' + $(this).attr('name')).removeClass('border_error');

        //     } 
        // });

		
	$("#btn_cancel").click(function () {
        window.location.href = "<?php echo site_url('workshop_setup/index/8'); ?>";
    });

    $(".btn_submit").click(function () {
		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');

		var validation = [];

		if($("#branch_id").val() == ''){
			validation.push('branch_id');
		}
        if($("#email_template_title").val() == ''){
			validation.push('email_template_title');
		}
        if($("#email_template_type").val() == ''){
			validation.push('email_template_type');
		}
        if($("#email_template_body").val() == ''){
			validation.push('email_template_body');
		}
		
		if(validation.length > 0){
			validation.forEach(function(val) {
				$('#'+val).addClass("border_error");
				if($('#'+val+'_error').length == 0){
					$('#'+val).parent().addClass('has-error');
				} 
			});
			return false;
		}

		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');
		$('#gif').show();

		$.post('<?php echo site_url('email_templates/ajax/create'); ?>', {
            is_update : $("#is_update").val(),
            email_template_id : $("#email_template_id").val(),
            email_template_type : $('#email_template_type').val(),
			branch_id : $("#branch_id").val(),
            email_template_body : $('#email_template_body').val(),
			email_template_subject : $('#email_template_subject').val(),
			email_template_cc : $('#email_template_cc').val(),
			email_template_bcc : $('#email_template_bcc').val(),
			email_template_from_name: $('#email_template_from_name').val(),
            email_template_title: $('#email_template_title').val(),
			action_from: 'C',
			btn_submit : $(this).val(),
			_mm_csrf: $('#_mm_csrf').val()
        }, function (data) {
            list = JSON.parse(data);
            if(list.success=='1'){
                notie.alert(1, 'Successfully Email Template created', 2);
                if(list.btn_submit == '1'){
						setTimeout(function(){
							window.location = "<?php echo site_url('email_templates/form'); ?>";
						}, 100);
					}else{
                        setTimeout(function(){
                         window.location = "<?php echo site_url('workshop_setup/index/8'); ?>";
                          }, 100);
                    }
            }else if(list.success=='2'){
                $('#gif').hide();
                notie.alert(3, 'Already Exists', 2);
            }else{
                $('#gif').hide();
				notie.alert(3, 'Oops, something has gone wrong', 2);
				$('.has-error').removeClass('has-error');
                for (var key in list.validation_errors) {
                    $('#' + key).parent().addClass('has-error');
                    $('.error_msg_' + key).show().empty().html(list.validation_errors[key]);
                }
            }
        });
	});

</script>
