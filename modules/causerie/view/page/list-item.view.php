<?php
/**
 * Affichage d'une causerie
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.5.0
 * @version 6.5.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<tr class="causerie-row" data-id="<?php echo esc_attr( $causerie->id ); ?>">
	<td data-title="Ref." class="padding">
		<span>
			<strong><?php echo esc_html( $causerie->unique_identifier ); ?></strong>
		</span>
	</td>
	<td data-title="Photo" class="padding">
		<?php do_shortcode( '[wpeo_upload id="' . $causerie->id . '" model_name="/digi/' . $causerie->get_class() . '" mode="view" single="false" field_name="image" ]' ); ?>
	</td>
	<td data-title="Nom" class="padding">
		<span><?php echo esc_html( $causerie->title ); ?></span>
	</td>
	<td data-title="Catégorie" class="padding">
		<?php do_shortcode( '[digi-dropdown-categories-risk id="' . $causerie->id . '" type="causerie" display="view" category_risk_id="' . $causerie->risk_category->id . '"]' ); ?>
	</td>
	<td data-title="Descriptif" class="padding">
		<span><?php echo esc_html( $causerie->content ); ?></span>
	</td>
	<td data-title="Documents joints" class="padding">
		<?php do_shortcode( '[wpeo_upload id="' . $causerie->id . '" model_name="/digi/' . $causerie->get_class() . '" display_type="list" mode="view" single="false" field_name="document" ]' ); ?>
	</td>
	<td>
		<div class="action grid-layout w2">
			<!-- Editer un causerie -->
			<div 	class="button light w50 edit action-attribute"
						data-id="<?php echo esc_attr( $causerie->id ); ?>"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_load_causerie' ) ); ?>"
						data-loader="causerie"
						data-action="load_causerie"><i class="icon fas fa-pencil"></i></div>

			<div 	class="button light w50 delete action-delete"
						data-id="<?php echo esc_attr( $causerie->id ); ?>"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_delete_causerie' ) ); ?>"
						data-action="delete_causerie"><i class="icon far fa-times"></i></div>
		</div>
	</td>
</tr>
