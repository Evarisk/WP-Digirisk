<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<li class="wp-digi-workunit wp-digi-new-workunit" >
	<span class="wp-digi-new-workunit-name" >
		<form id="wpdigi-workunit-creation-form" action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="post" >
			<input type="hidden" name="action" value="wpdigi_ajax_workunit_create" />
			<input type="hidden" name="workunit[parent_id]" value="<?php echo $groupment_id; ?>" />
			<?php wp_nonce_field( 'wpdigi-workunit-creation', 'wpdigi_nonce', false, true ); ?>
			<input type="text" placeholder="<?php _e( 'New work unit', 'digirisk' ); ?>" name="workunit[title]" />
		</form>
	</span>
	<span class="wp-digi-new-workunit-action" ><a href="#" class="wp-digi-action dashicons dashicons-plus" ></a></span>
</li>
