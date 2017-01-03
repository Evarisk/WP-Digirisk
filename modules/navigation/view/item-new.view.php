<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="workunit-add">
	<input type="hidden" name="action" value="save_workunit" />
	<input type="hidden" name="groupment_id" value="<?php echo $parent_id; ?>" />
	<?php wp_nonce_field( 'wpdigi-workunit-creation', 'wpdigi_nonce', false, true ); ?>
	<input class="title" type="text" placeholder="<?php _e( 'New work unit', 'digirisk' ); ?>" name="workunit[title]" />
	<div class="add button blue w50 action-input" data-parent="workunit-add"><i class="icon fa fa-plus"></i></div>
</div>
