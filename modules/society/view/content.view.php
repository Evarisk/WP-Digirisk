<?php
/**
 * Display .... Fichier incompréhensible.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package society
 * @subpackage view
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<div class="main-header">
	<div class="unit-header">
		<?php do_shortcode( '[eo_upload_button id="' . $element->id . '" type="' . $element->type . '"]' ); ?>

		<?php apply_filters( 'society_identity', $element, true ); ?>
		<div
				class="button green action-input save"
				data-parent="unit-header"
				data-loader="digirisk-wrap"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'save_society' ) ); ?>"><span><i class="fa fa-floppy-o"></i></span></div>
	</div>

	<?php apply_filters( 'society_header_end', $element ); ?>
</div>

<?php echo do_shortcode( '[digi_tab id="' . $element->id . '" type="' . $element->type . '" display="' . $tab_to_display . '"]' ); ?>
<?php apply_filters( 'tab_content', '', $element->id, $tab_to_display, $title ); ?>
