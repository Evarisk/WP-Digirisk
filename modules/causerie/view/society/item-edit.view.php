<?php
/**
 * Affichage d'une causerie d'une société.
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

<tr>
	<!-- Les champs obligatoires pour le formulaire -->
	<input type="hidden" name="action" value="edit_causerie_society" />
	<?php wp_nonce_field( 'edit_causerie_society' ); ?>
	<input type="hidden" name="id" value="<?php echo esc_attr( $causerie->id ); ?>" />
	<input type="hidden" name="parent_id" value="<?php echo esc_attr( $society_id ); ?>" />

	<td class="w50 padding">Ref</td>
	<td>
		<?php do_shortcode( '[wpeo_upload id="' . $causerie->id . '" model_name="/digi/' . $causerie->get_class() . '" single="false" field_name="image" ]' ); ?>
	</td>

	<td>
		Catégorie de causerie
	</td>
	<td><?php esc_html_e( 'Cat.', 'digirisk' ); ?></td>
	<td><?php esc_html_e( 'Doc. Joints', 'digirisk' ); ?></td>
	<td><?php esc_html_e( 'Formateur', 'digirisk' ); ?></td>
	<td><?php esc_html_e( 'Person. présent', 'digirisk' ); ?></td>
	<td data-title="action">
		<?php if ( 0 !== $causerie->id ) : ?>
			<div class="action grid-layout w3">
				<div data-parent="causerie-row" data-loader="table" class="button w50 green save action-input"><i class="icon fa fa-floppy-o"></i></div>
			</div>
		<?php else : ?>
			<div class="action grid-layout w3">
				<div data-loader="table" data-parent="causerie-row" class="button w50 blue add action-input progress"><i class="icon fa fa-plus"></i></div>
			</div>
		<?php endif; ?>
	</td>
</tr>
