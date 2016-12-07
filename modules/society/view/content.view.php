<?php
/**
 * Display .... Fichier incompréhensible.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 0.1
 * @copyright 2015-2016 Eoxia
 * @package establishment
 * @subpackage view
 */

if ( ! defined( 'ABSPATH' ) ) { exit;
} ?>

<div class="wp-digi-group-sheet wp-digi-sheet" data-id="<?php echo $element->id; ?>">
	<div class="wp-digi-global-sheet-header wp-digi-global-sheet-header">
		<input type="hidden" name="action" value="save_society" />
		<input type="hidden" name="id" value="<?php echo $element->id; ?>" />
	<?php apply_filters( 'wpdigi_establishment_identity', $element, true ); ?>

		<div class="wp-digi-group-action-container wp-digi-global-action-container hidden">
			<button
				class="wp-digi-bton-fourth wp-digi-save-identity-button action-input"
				data-parent="wp-digi-global-sheet-header"
				data-nonce="<?php echo wp_create_nonce( 'ajax_update_group_' . $element->id ); ?>"><?php _e( 'Save', 'digirisk' ); ?></button>
		</div>

		<span style="margin-left: auto;">
			<?php if ( $display_trash ) : ?>
			<a class="wp-digi-delete-action wp-digi-action-delete"
				data-action="delete_society"
				data-id="<?php echo $element->id; ?>"><i class="dashicons dashicons-trash"></i></a>
			<?php endif; ?>
			<?php
			if ( 'digi-group' === $element->type ) :
			?>
				<button data-id="<?php echo $element->id; ?>" style="height: 100%; float: right;" data-action="digi_list_duer" class="tab wp-digi-bton-fifth dashicons-before dashicons-share-alt2"><?php _e( 'Document unique', 'digirisk' ); ?></button>
			<?php
			endif;
			?>
		</span>
	</div>

	<?php echo do_shortcode( '[digi-tab type="' . $element->type . '" display="' . $tab_to_display . '"]' ); ?>
	<?php apply_filters( 'wpdigi_establishment_tab_content', '', $element->id, $tab_to_display ); ?>

</div>
