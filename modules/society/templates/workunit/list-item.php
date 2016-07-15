<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
	<li class="<?php echo $element->id == $args['workunit_id'] ? 'active' : ''; ?> wp-digi-list-item wp-digi-workunit-<?php echo $element->id; ?> wp-digi-item-workunit" data-id="<?php echo $element->id; ?>" data-type="<?php echo $element->type; ?>" data-nonce="<?php echo $workunit_display_nonce; ?>" >
		<?php require( SOCIETY_VIEW_DIR . '/identity.view.php' ); ?>
		<span class="wp-digi-workunit-action" ><a href="#" data-id="<?php echo $element->id; ?>" data-nonce="<?php echo wp_create_nonce( 'ajax_delete_workunit_' . $element->id ); ?>" class="wp-digi-action wp-digi-action-delete dashicons dashicons-no-alt" ></a></span>
	</li>
