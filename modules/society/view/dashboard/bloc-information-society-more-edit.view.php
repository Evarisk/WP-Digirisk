<?php
/**
 * Ce template affiche le formulaire pour configurer les informations d'une société.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.2.1
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

global $eo_search; ?>

<form class="wpeo-form">
	<input type="hidden" name="action" value="save_configuration" />
	<input type="hidden" name="society[id]" value="<?php echo esc_attr( $element->data['id'] ); ?>" />
	<input type="hidden" name="address[post_id]" value="<?php echo esc_attr( $element->data['id'] ); ?>" />
	<input type="hidden" name="society[type]" value="<?php echo esc_attr( $element->data['type'] ); ?>" />
	<?php wp_nonce_field( 'save_configuration' ); ?>

	<div class="wpeo-gridlayout grid-2 grid-gap-1">
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Téléphone', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="society[contact][phone]" class="form-field" type="text" value="<?php echo esc_attr( ! empty( $element->data['contact']['phone'] ) ? end( $element->data['contact']['phone'] ) : '' ); ?>" />
			</label>
		</div>

		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Email', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="society[contact][email]" class="form-field" type="text" value="<?php echo esc_attr( $element->data['contact']['email'] ); ?>" />
			</label>
		</div>

		<div class="form-element gridw-2">
			<span class="form-label"><?php esc_html_e( 'Description', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<textarea name="society[content]" class="form-field" rows="6"><?php echo $element->data['content']; ?></textarea>
			</label>
		</div>

		<div class="form-element gridw-2">
			<span class="form-label"><?php esc_html_e( 'Moyen Generaux Mis à Disposition', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<textarea name="society[moyen]" class="form-field" rows="6"><?php echo $element->data['moyen_generaux']; ?></textarea>
			</label>
		</div>

		<div class="form-element gridw-2">
			<span class="form-label"><?php esc_html_e( 'Consignes Générales', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<textarea name="society[consigne]" class="form-field" rows="6"><?php echo $element->data['consigne_generale']; ?></textarea>
			</label>
		</div>

		<div class="gridw-2">
			<button class="wpeo-button button-main action-input alignright" data-parent="wpeo-form"><?php esc_html_e( 'Enregistrer les modifications', 'digirisk' ); ?></button>
		</div>
	</div>

</form>
