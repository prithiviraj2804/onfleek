<header class="page-content-header">
    <div class="container-fluid">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3><?php echo $pagetitle; ?></h3>
                </div>
                <div class="tbl-cell tbl-cell-action">
                    <?php if (!$creation_check->job_card_status || !$creation_check->quote_status || !$creation_check->invoice_status) { ?>
                        <a href="<?php echo site_url('mech_invoice_groups/form'); ?>" id="generate_invoice_group" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> <?php _trans('lable40'); ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</header>
<?php if ($this->mdl_mech_invoice_groups->form_value('invoice_group_next_id') > 1) {
        $readonly = 'readonly="readonly"';
        $disable = 'disabled="disabled"';
    } else {
        $readonly = '';
        $disable = '';
    } ?>
    <input type="hidden" id="_mm_csrf" name="_mm_csrf" value="<?= $this->security->get_csrf_hash(); ?>" autocomplete="off">
    <div id="content-fluid">
        <div class="row">
        <div id="gif" class="gifload">
			<div class="gifcenter">
			  <center><img src="<?php echo base_url(); ?>assets\fv1\images\giphy.gif" alt="Loading"></center>
		    </div>
		</div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php $this->layout->load_view('layout/alerts'); ?>
                <div class="container">
                    <input type="hidden" name="invoice_group_id" id="invoice_group_id" value="<?php echo $this->mdl_mech_invoice_groups->form_value('invoice_group_id', true); ?>" autocomplete="off">
                    <input class="hidden" name="is_update" type="hidden" <?php if ($this->mdl_mech_invoice_groups->form_value('is_update')) { echo 'value="1"'; } else { echo 'value="0"'; } ?> autocomplete="off">
                    <div class="box">
                    	<div class="row">
                            <div class="col-xs-12">
                                <a class="anchor anchor-back" href="<?php echo site_url('workshop_setup/index/4'); ?>"><i class="fa fa-long-arrow-left"></i><span><?php _trans('lable59'); ?></span></a>
                            </div>
						</div>
                        <div class="box_body row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <div class="form_group">
                                    <label class="form_label"> <?php _trans('lable51'); ?>*</label>
                                    <div class="form_controls">
                                        <select id="branch_id" name="branch_id" class="bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true"  autocomplete="off">
                                            <?php foreach ($branch_list as $branchList) {?>
                                            <option value="<?php echo $branchList->w_branch_id; ?>" <?php if($this->mdl_mech_invoice_groups->form_value('branch_id') == $branchList->w_branch_id){echo "selected";}?> > <?php echo $branchList->display_board_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form_group">
                                    <label class="form_label"> <?php _trans('lable782'); ?> *</label>
                                    <div class="form_controls">
                                        <input <?php echo $readonly; ?> type="text" name="invoice_group_name" id="invoice_group_name" class="form-control" placeholder="Name" value="<?php echo $this->mdl_mech_invoice_groups->form_value('invoice_group_name', true); ?>" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form_group">
                                    <label class="form_label"> <?php _trans('lable783'); ?></label>
                                    <div class="form_controls">
                                        <select <?php echo $disable; ?> class="form-control bootstrap-select bootstrap-select-arrow form-control removeError" data-live-search="true" <?php echo $disable; ?> name="module_type" id="module_type" autocomplete="off">
                                            <option value=""><?php _trans('lable241'); ?></option>
                                            <option value="customer" 
                                            <?php if ($creation_check->cash_invoice_status == true && $creation_check->other_invoice_status == true) { ?> disabled="disabled" <?php } ?> 
                                            <?php if ($this->mdl_mech_invoice_groups->form_value('module_type') == 'customer') { echo 'selected="selected"'; } ?>>Customer</option>
                                            <option value="supplier" 
                                            <?php if ($creation_check->cash_invoice_status == true && $creation_check->other_invoice_status == true) { ?> disabled="disabled" <?php } ?> 
                                            <?php if ($this->mdl_mech_invoice_groups->form_value('module_type') == 'supplier') { echo 'selected="selected"'; } ?>>Supplier</option>
                                            <option value="employee" 
                                            <?php if ($creation_check->cash_invoice_status == true && $creation_check->other_invoice_status == true) { ?> disabled="disabled" <?php } ?> 
                                            <?php if ($this->mdl_mech_invoice_groups->form_value('module_type') == 'employee') { echo 'selected="selected"'; } ?>>Employee</option>
                                            <option value="invoice" 
                                                <?php if ($creation_check->cash_invoice_status == true && $creation_check->other_invoice_status == true) { ?> disabled="disabled" <?php } ?> 
                                                <?php if ($this->mdl_mech_invoice_groups->form_value('module_type') == 'invoice') { echo 'selected="selected"'; } ?>>Invoice</option>
                                            <option value="feedback" 
                                            <?php if ($creation_check->cash_invoice_status == true && $creation_check->other_invoice_status == true) { ?> disabled="disabled" <?php } ?> 
                                            <?php if ($this->mdl_mech_invoice_groups->form_value('module_type') == 'feedback') { echo 'selected="selected"'; } ?>>Feedback</option>
                                            <option value="quote" 
                                                <?php if ($creation_check->cash_quote_status == true && $creation_check->other_quote_status) { ?> disabled="disabled" <?php } ?>
                                                <?php if ($this->mdl_mech_invoice_groups->form_value('module_type') == 'quote') { echo 'selected="selected"'; } ?>>Quote</option>
                                            <option value="purchase" <?php if ($creation_check->cash_purchase_status == true && $creation_check->other_purchase_status == true) {
                                                ?> disabled="disabled" <?php
                                            } ?> <?php if ($this->mdl_mech_invoice_groups->form_value('module_type') == 'purchase') {
                                                echo 'selected="selected"';
                                            } ?>>Purchase</option>

                                        <?php if($this->session->userdata('plan_type') != 3){ ?>
                                            <option value="purchase_order" <?php if ($creation_check->cash_purchase_order_status == true && $creation_check->other_purchase_order_status == true) {
                                                ?> disabled="disabled" <?php
                                            } ?> <?php if ($this->mdl_mech_invoice_groups->form_value('module_type') == 'purchase_order') {
                                                echo 'selected="selected"';
                                            } ?>>Purchase Order</option>
                                        <?php } ?>
                                            <option value="expense" <?php if ($creation_check->cash_exp_status == true && $creation_check->online_exp_status == true) {
                                                ?> disabled="disabled" <?php
                                            } ?> <?php if ($this->mdl_mech_invoice_groups->form_value('module_type') == 'expense') {
                                                echo 'selected="selected"';
                                            } ?>>Expense</option>
                                            <?php if($this->session->userdata('plan_type') != 3){ ?>
                                            <option value="job_card" <?php if ($creation_check->cash_job_card_status == true && $creation_check->other_job_card_status) {
                                                ?> disabled="disabled" <?php
                                            } ?> <?php if ($this->mdl_mech_invoice_groups->form_value('module_type') == 'job_card') {
                                                echo 'selected="selected"';
                                            } ?>>Job Card</option>  <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <?php if (!empty($invoice_group)) {
                                        $prefix_split = explode('{{{', $invoice_group->invoice_group_identifier_format);
                                    } else {
                                        $prefix_split = array();
                                    }
                                    if (!empty($invoice_group)) {
                                        $suffix_split = explode('}}}', $invoice_group->invoice_group_identifier_format);
                                    } else {
                                        $suffix_split = array();
                                    } ?>
                                <div class="form_group">
                                    <label class="form_label"> <?php _trans('lable784'); ?></label>
                                    <div class="form_controls">
                                        <input <?php echo $readonly; ?> type="text" placeholder="Prefix" name="prefix_text" id="prefix_text" class="form-control" value="<?php echo (count($prefix_split) > 0) ? $prefix_split[0] : ''; ?>" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form_group">
                                    <label class="form_label"> <?php _trans('lable785'); ?></label>
                                    <div class="form_controls">
                                        <input <?php echo $readonly; ?> type="text" placeholder="Suffix" name="suffix_text" id="suffix_text" class="form-control" value="<?php echo (count($suffix_split) > 0) ? $suffix_split[1] : ''; ?>" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form_group ">
                                    <label class="form_label"> <?php _trans('lable786'); ?></label>
                                    <div class="form_controls">
                                        <input <?php echo $readonly; ?> type="text" placeholder="Next no" name="invoice_group_next_id" id="invoice_group_next_id" class="form-control" value="<?php echo $this->mdl_mech_invoice_groups->form_value('invoice_group_next_id', true); ?>" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form_group ">
                                    <label class="form_label"> <?php _trans('lable787'); ?></label>
                                    <div class="form_controls">
                                        <input <?php echo $readonly; ?> type="text" placeholder="Length of serial no" name="invoice_group_left_pad" id="invoice_group_left_pad" class="form-control"
                                   value="<?php echo $this->mdl_mech_invoice_groups->form_value('invoice_group_left_pad', true); ?>" autocomplete="off">
                                    </div>
                                </div>
                                <div class="buttons text-center paddingtop15px">
                                    <button value="2" name="btn_submit" class="btn_submit btn btn-rounded btn-primary btn-padding-left-right-40">
                                        <i class="fa fa-check"></i> <?php _trans('lable57'); ?>
                                    </button>
                                    <button id="btn_cancel" name="btn_cancel" class="btn btn-rounded btn-default">
                                        <i class="fa fa-times"></i> <?php _trans('lable58'); ?>
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" id="invoice_grouptable">
                                <div class="table_title"><?php _trans('lable788'); ?></div>
                                    <table class="table">
                                        <thead>
                                            <tr> 
                                                <th rowspan="2" class="document_no_required"><?php _trans('lable789'); ?><br><?php _trans('lable790'); ?></th> 
                                                <th colspan=4 class="text_align_center"><?php _trans('inputs_to_given'); ?></th>
                                            </tr> 
                                            <tr class="head_table_padding_0px"> 
                                                <th class="text_align_center prefix_color"><?php _trans('lable784'); ?></th> 
                                                <th class="text_align_center suffix_color"><?php _trans('lable785'); ?></th> 
                                                <th class="text_align_center"><?php _trans('lable730'); ?></th> 
                                                <th class="text_align_center"><?php _trans('lable791'); ?></th>
                                            </tr> 
                                        </thead>
                                        <tbody>
                                            <tr> 
                                                <td>
                                                    <span class="prefix_color"><?php _trans('lable792'); ?></span>
                                                    <span class="number_color">0001</span>
                                                    <span class="suffix_color">/17-18</span>
                                                </td>
                                                <td class="prefix_color"><?php _trans('lable792'); ?></td>
                                                <td class="suffix_color">/17-18</td> 
                                                <td class="text_align_right">1</td>
                                                <td class="text_align_right">4</td>
                                            </tr> 
                                            <tr> 
                                                <td>
                                                    <span class="prefix_color"><?php _trans('lable793'); ?></span>
                                                    <span class="number_color">00001</span>
                                                    <span class="suffix_color">/17-18</span>
                                                </td>
                                                <td class="prefix_color"><?php _trans('lable793'); ?></td>
                                                <td class="suffix_color">/17-18</td> 
                                                <td class="text_align_right">1</td>
                                                <td class="text_align_right">5</td>
                                            </tr> 
                                            <tr> 
                                                <td>
                                                    <span class="prefix_color"><?php _trans('lable794'); ?></span>
                                                    <span class="number_color">0254</span>
                                                    <span class="suffix_color">/A</span>
                                                </td>
                                                <td class="prefix_color"><?php _trans('lable794'); ?></td>
                                                <td class="suffix_color">/A</td> 
                                                <td class="text_align_right">254</td>
                                                <td class="text_align_right">4</td>
                                            </tr> 
                                            <tr> 
                                                <td>
                                                    <span class="prefix_color"><?php echo trans('lable795'); ?></span>
                                                    <span class="number_color">0001</span>
                                                    <span class="suffix_color">AZ</span>
                                                </td>
                                                <td class="prefix_color"><?php echo trans('lable795'); ?></td>
                                                <td class="suffix_color">AZ</td> 
                                                <td class="text_align_right">1</td>
                                                <td class="text_align_right">4</td>
                                            </tr> 
                                            <tr> 
                                                <td>
                                                    <span class="prefix_color"><?php echo trans('lable796').'-'; ?></span>
                                                    <span class="number_color">00039</span>
                                                    <span class="suffix_color">M</span>
                                                </td>
                                                <td class="prefix_color"><?php echo trans('lable796').'-'; ?></td>
                                                <td class="suffix_color">M</td> 
                                                <td class="text_align_right">39</td>
                                                <td class="text_align_right">5</td>
                                            </tr> 
                                            <tr> 
                                                <td>
                                                    <span class="prefix_color"><?php echo trans('lable792').'-'; ?></span>
                                                    <span class="number_color">0001</span>
                                                    <span class="suffix_color">/17-18</span>
                                                </td>
                                                <td class="prefix_color"><?php echo trans('lable792').'-'; ?></td>
                                                <td class="suffix_color">/17-18</td> 
                                                <td class="text_align_right">1</td>
                                                <td class="text_align_right">4</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="bank_prefix_suffix_contant">
                                        <span>
                                            <?php _trans('lable816'); ?>
                                            <br />
                                            <?php _trans('lable817'); ?>
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
		
	$("#btn_cancel").click(function () {
        window.location.href = "<?php echo site_url('workshop_setup/index/4'); ?>";
    });

    $(".btn_submit").click(function () {

		$('.border_error').removeClass('border_error');
		$('.has-error').removeClass('has-error');

		var validation = [];

		if($("#branch_id").val() == ''){
			validation.push('branch_id');
		}
		if($("#invoice_group_name").val() == ''){
			validation.push('invoice_group_name');
		}
        if($("#module_type").val() == ''){
			validation.push('module_type');
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

		$.post('<?php echo site_url('mech_invoice_groups/ajax/save'); ?>', {
            invoice_group_id : $("#invoice_group_id").val(),
            is_update : $("#is_update").val(),
            branch_id : $('#branch_id').val(),
			invoice_group_name : $("#invoice_group_name").val(),
            module_type : $('#module_type').val(),
			prefix_text : $('#prefix_text').val(),
			suffix_text : $('#suffix_text').val(),
			invoice_group_next_id : $('#invoice_group_next_id').val(),
			invoice_group_left_pad: $('#invoice_group_left_pad').val(),
			_mm_csrf: $('#_mm_csrf').val()
        }, function (data) {
            list = JSON.parse(data);
            if(list.success=='1'){
                notie.alert(1, 'Successfully Created', 2);
				setTimeout(function(){
                    window.location = "<?php echo site_url('workshop_setup/index/4'); ?>";
                }, 100);
            }else if(list.success=='2'){
				$('#gif').hide();	
                notie.alert(3,list.validation_errors , 2);
            }else{
				$('#gif').hide();	
				notie.alert(3, 'Please fill the mandatory fields and continue', 2);
				$('.has-error').removeClass('has-error');
                for (var key in list.validation_errors) {
                    $('#' + key).parent().addClass('has-error');
                    $('.error_msg_' + key).show().empty().html(list.validation_errors[key]);
                }
            }
        });
	});

</script>