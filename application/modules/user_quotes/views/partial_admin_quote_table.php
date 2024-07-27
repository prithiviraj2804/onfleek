<?php if(count($quote_book_list) > 0){ ?>

	<section class="card">
				<div class="card-block">
					<table id="admin_quote_list" class="display table table-bordered" cellspacing="0" width="100%">
						<thead>
						<tr>
			                <th><?php _trans('s_no');?></th>
			                <th><?php _trans('job_card_no');?>.</th>
			                 <th><?php _trans('invoice_no');?>.</th>
			                <th><?php _trans('user');?></th>
			                <th><?php _trans('car');?></th>
			                <th><?php _trans('status');?></th>
			                <th><?php _trans('options');?></th>
			            </tr>
						</thead>
						
						<tbody>
						<?php $i = 1;  
						foreach ($quote_book_list as $quote) { ?>
                <tr>
                    <td><?php _htmlsc($i); ?></td>
                    <td><?php _htmlsc($quote->appointment_no); ?></td>
                    <td><a><?php _htmlsc($quote->quote_no); ?></a></td>
                    <td><?php _htmlsc($quote->owner_id); ?></td>
                    <td><?php _htmlsc($quote->brand_name." ".$quote->model_name); ?></td>
                    <td><?php 
                    if($quote->is_request_quote == 0){
                    	echo _htmlsc("Pending");
                    }elseif($quote->is_request_quote == 1){
                    	echo _htmlsc("Request");
                    } ?></td>
                    <td>
                    	<div class="options btn-group">
                            <a class="btn btn-default btn-sm dropdown-toggle"
                               data-toggle="dropdown" href="#">
                                <i class="fa fa-cog"></i> <?php _trans('options'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('View Invoice'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-edit fa-margin"></i> <?php _trans('View Job Sheet'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" onclick="remove_entity(<?php echo $quote->quote_id; ?>,'user_quotes', 'quote','<?= $this->security->get_csrf_hash() ?>')">
                                        <i class="fa fa-edit fa-times"></i> <?php _trans('delete'); ?>
                                    </a>
                                </li>
                               	<?php /* * / ?><li>
                                    <a href="<?php echo site_url('user_quotes/delete/' . $quote->quote_id); ?>"
                                       onclick="return confirm('<?php _trans('delete_record_warning'); ?>');">
                                        <i class="fa fa-trash-o fa-margin"></i> <?php _trans('delete'); ?>
                                    </a>
                                </li><?php / * */ ?>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php $i++; } ?>
						</tbody>
					</table>
				</div>
			</section>
<?php } ?>


<script>
		$(function() {
			$('#admin_quote_list').DataTable({
				responsive: true
			});
		});
	</script>