<?php
/**
 * Service de santé au travail
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.0.0
 * @version   7.0.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<form class="wpeo-form">
	<input type="hidden" name="action" value="save_health_service" />
	<input type="hidden" name="society[id]" value="<?php echo esc_attr( $element->data['id'] ); ?>" />
	<input type="hidden" name="address[post_id]" value="<?php echo esc_attr( $element->data['id'] ); ?>" />
	<input type="hidden" name="society[type]" value="<?php echo esc_attr( $element->data['type'] ); ?>" />
	<input type="hidden" name="legaldisplay_id" value="<?php echo esc_attr( $legal_display->data['id'] ); ?>" />
	<?php wp_nonce_field( 'save_health_service' ); ?>

	<div class="wpeo-gridlayout grid-1 grid-gap-1">
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Nom du médecin du travail', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="occupational_health_service[full_name]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['occupational_health_service']->data['full_name'] ); ?>" />
			</label>
		</div>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Adresse', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="occupational_health_service[address][address]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['occupational_health_service']->data['address']->data['address'] ); ?>" />
			</label>
		</div>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Code postal', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="occupational_health_service[address][postcode]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['occupational_health_service']->data['address']->data['postcode'] ); ?>" />
			</label>
		</div>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Ville', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="occupational_health_service[address][town]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['occupational_health_service']->data['address']->data['town'] ); ?>" />
			</label>
		</div>

		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Téléphone', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="occupational_health_service[contact][phone]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['occupational_health_service']->data['contact']['phone'] ); ?>" />
			</label>
		</div>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Horaires', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="occupational_health_service[opening_time]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['occupational_health_service']->data['opening_time'] ); ?>" />
			</label>
		</div>
	</div>
	<div class="gridw-2" style="margin-top : 10px">
		<button class="wpeo-button button-main action-input alignright" data-parent="wpeo-form"><?php esc_html_e( 'Enregistrer les modifications', 'digirisk' ); ?></button>
	</div>
</form>
