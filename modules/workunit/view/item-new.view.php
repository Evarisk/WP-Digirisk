<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>


<li class="wp-digi-workunit wp-digi-new-workunit" >
	<span class="wp-digi-new-workunit-name" >
		<input type="hidden" name="action" value="save_workunit" />
		<input type="hidden" name="workunit[parent_id]" value="<?php echo $groupment_id; ?>" />
		<?php wp_nonce_field( 'wpdigi-workunit-creation', 'wpdigi_nonce', false, true ); ?>
		<input type="text" placeholder="<?php _e( 'New work unit', 'digirisk' ); ?>" name="workunit[title]" />
	</span>
	<span class="wp-digi-new-workunit-action" ><a data-parent="wp-digi-workunit" href="#" class="wp-digi-action dashicons dashicons-plus action-input" ></a></span>
</li>
