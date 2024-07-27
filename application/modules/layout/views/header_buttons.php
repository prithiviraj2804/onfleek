<?php if (!isset($hide_submit_button)) : ?>
<button id="btn-submit" name="btn_submit" class="btn btn-rounded btn-primary" value="1">
    <i class="fa fa-check"></i> <?php _trans('save'); ?>
</button>
<?php endif; ?>
<?php if (!isset($hide_cancel_button)) : ?>
<button id="btn-cancel" name="btn_cancel" class="btn btn-rounded btn-default" value="1">
    <i class="fa fa-times"></i> <?php _trans('cancel'); ?>
</button>
<?php endif; ?>
