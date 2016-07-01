<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
	<li class="<?php echo $workunit->id == $args['workunit_id'] ? 'active' : ''; ?> wp-digi-list-item wp-digi-workunit-<?php echo $workunit->id; ?> wp-digi-item-workunit" data-id="<?php echo $workunit->id; ?>" data-type="<?php echo $workunit->type; ?>" data-nonce="<?php echo $workunit_display_nonce; ?>" >
		<?php require( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'workunit', 'identity' ) ); ?>
		<span class="wp-digi-workunit-action" ><a href="#" data-id="<?php echo $workunit->id; ?>" data-nonce="<?php echo wp_create_nonce( 'ajax_delete_workunit_' . $workunit->id ); ?>" class="wp-digi-action wp-digi-action-delete dashicons dashicons-no-alt" ></a></span>
	</li>
