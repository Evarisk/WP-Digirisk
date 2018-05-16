<?php
/**
 * Edition d'une causerie
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

<tr class="causerie-row edit" data-id="<?php echo esc_attr( $causerie->id ); ?>">

	<!-- Les champs obligatoires pour le formulaire -->
	<input type="hidden" name="action" value="edit_causerie" />
	<?php wp_nonce_field( 'edit_causerie' ); ?>
	<input type="hidden" name="id" value="<?php echo esc_attr( $causerie->id ); ?>" />
	<input type="hidden" name="parent_id" value="<?php echo esc_attr( $main_society->id ); ?>" />

	<td data-title="Ref." class="padding">
		<span>
			<strong><?php echo esc_html( $causerie->modified_unique_identifier ); ?></strong>
		</span>
	</td>
	<td>
		<?php do_shortcode( '[wpeo_upload id="' . $causerie->id . '" model_name="/digi/' . $causerie->get_class() . '" single="false" field_name="image" ]' ); ?>
	</td>
	<td>
		<input type="text" name="title" />
	</td>
	<td>
		<?php do_shortcode( '[digi_dropdown_categories_risk id="' . $causerie->id . '" type="causerie" display="edit" category_risk_id="' . $causerie->risk_category->id . '" preset="0"]' ); ?>
	</td>
	<td>
		<textarea rows="2" name="description"></textarea>
	</td>
	<td>
		<?php do_shortcode( '[wpeo_upload id="' . $causerie->id . '" model_name="/digi/' . $causerie->get_class() . '" single="false" display_type="list" field_name="document" ]' ); ?>
	</td>
	<td data-title="action">
		<?php if ( 0 !== $causerie->id ) : ?>
			<div class="action grid-layout w3">
				<div data-parent="causerie-row" data-loader="table" class="button w50 green save action-input"><i class="icon fas fa-save"></i></div>
			</div>
		<?php else : ?>
			<div class="action grid-layout w3">
				<div data-loader="table" data-parent="causerie-row" class="button w50 blue add action-input progress"><i class="icon far fa-plus"></i></div>
			</div>
		<?php endif; ?>
	</td>
</tr>
