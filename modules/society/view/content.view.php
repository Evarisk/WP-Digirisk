<?php
/**
* Display .... Fichier incompréhensible.
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package establishment
* @subpackage view
*/

if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="wp-digi-group-sheet wp-digi-sheet" data-id="<?php echo $element->id; ?>"  >
	<div class="wp-digi-global-sheet-header wp-digi-global-sheet-header">
    <?php apply_filters( 'wpdigi_establishment_identity', $element, true ); ?>

		<?php do_shortcode( '[digi-search id="' . $element->id . '" class="group_class" text="' . __( 'Write groupment number or name for move this object to it', 'digirisk' ) . '" type="post" field="group_id"]' ); ?>

		<div class="wp-digi-group-action-container wp-digi-global-action-container hidden">
			<button class="wp-digi-bton-fourth wp-digi-save-identity-button" data-nonce="<?php echo wp_create_nonce( 'ajax_update_group_' . $element->id ); ?>"><?php _e( 'Save', 'digirisk' ); ?></button>
		</div>

		<a class="wp-digi-delete-action" data-id="<?php echo $element->id; ?>"><i class="dashicons dashicons-trash"></i></a>
	</div>

	<?php echo do_shortcode( '[digi-tab type="' . $element->type . '" display="' . $tab_to_display . '"]' ); ?>
	<?php apply_filters( 'wpdigi_establishment_tab_content', '', $element, $tab_to_display ); ?>

</div>
