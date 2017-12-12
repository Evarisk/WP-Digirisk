<?php
/**
 * Display .... Fichier incompréhensible.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.4.4
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="main-header">
	<div class="unit-header">
		<?php do_shortcode( '[wpeo_upload id="' . $element->id . '" title="' . $element->unique_identifier . ' - ' . $element->title . '" model_name="/digi/' . $element->get_class() . '" field_name="image" single="false" ]' ); ?>

		<?php apply_filters( 'society_identity', $element, true ); ?>
		<div class="button w50 edit"><i class="icon fa fa-pencil"></i></div>

		<div
				class="button green action-input save"
				data-parent="unit-header"
				data-loader="digirisk-wrap"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'save_society' ) ); ?>"><span><i class="fa fa-floppy-o"></i></span></div>
		<div class="mobile-navigation"><i class="icon fa fa-bars"></i></div>
	</div>
</div>

<?php echo do_shortcode( '[digi_tab id="' . $element->id . '" type="' . $element->type . '" display="' . $tab_to_display . '"]' ); ?>
<?php apply_filters( 'tab_content', '', $element->id, $tab_to_display, $title ); ?>
