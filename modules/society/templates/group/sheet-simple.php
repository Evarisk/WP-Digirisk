<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<div class="wp-digi-group-sheet wp-digi-clearer" data-id="<?php echo $group_id; ?>"  >
	<div class="wp-digi-group-sheet-header wp-digi-global-sheet-header .wp-digi-clearer" >
		<?php require( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'group', 'identity' ) ); ?>
		<div class="wp-digi-group-action-container wp-digi-global-action-container hidden" >
			<button class="wp-digi-bton-fourth" id="wp-digi-save-group-identity-button" data-nonce="<?php echo wp_create_nonce( 'ajax_update_group_' . $group_id ); ?>" ><?php _e( 'Save', 'wpdigi-i18n' ); ?></button>
		</div>
		<?php if ( $group->option[ 'unique_identifier' ] != 'GP1' ): ?>
			<a class="wp-digi-delete-group-action" data-id="<?php echo $group_id; ?>" data-nonce="<?php echo wp_create_nonce( 'ajax_delete_group_' . $group_id ); ?>" ><i class="dashicons dashicons-trash"></i></a>
		<?php endif; ?>
	</div>

	<ul class="wp-digi-group-sheet-tab wp-digi-global-sheet-tab wp-digi-clearer" data-type="group" ><?php $this->display_group_tab( $group, $group_default_tab ); ?></ul>
	<div class="wp-digi-group-sheet-content wp-digi-global-sheet-content wp-digi-clearer wp-digi-bloc-loader" ><?php $this->display_group_tab_content( $group, $group_default_tab ); ?></div>
</div>
