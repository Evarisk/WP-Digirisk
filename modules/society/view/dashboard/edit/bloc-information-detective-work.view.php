<?php
/**
 * Inspecteur du travail
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
	<input type="hidden" name="action" value="save_detective_work" />
	<input type="hidden" name="society[id]" value="<?php echo esc_attr( $element->data['id'] ); ?>" />
	<input type="hidden" name="address[post_id]" value="<?php echo esc_attr( $element->data['id'] ); ?>" />
	<input type="hidden" name="society[type]" value="<?php echo esc_attr( $element->data['type'] ); ?>" />
	<input type="hidden" name="legaldisplay_id" value="<?php echo esc_attr( $legal_display->data['id'] ); ?>" />

	<?php wp_nonce_field( 'save_detective_work' ); ?>

	<div class="wpeo-gridlayout grid-1 grid-gap-1">
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Nom de l\'inspecteur', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="detective_work[full_name]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['detective_work']->data['full_name'] ); ?>" />
			</label>
		</div>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Adresse', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="detective_work[address][address]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['detective_work']->data['address']->data['address'] ); ?>" />
			</label>
		</div>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Code postal', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="detective_work[address][postcode]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['detective_work']->data['address']->data['postcode'] ); ?>" />
			</label>
		</div>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Ville', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="detective_work[address][town]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['detective_work']->data['address']->data['town'] ); ?>" />
			</label>
		</div>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Téléphone', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="detective_work[contact][phone]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['detective_work']->data['contact']['phone'] ); ?>" />
			</label>
		</div>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Horaires', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="detective_work[opening_time]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['detective_work']->data['opening_time'] ); ?>"/>
			</label>
		</div>
	</div>
	<div class="gridw-2" style="margin-top : 10px">
		<button class="wpeo-button button-main action-input alignright" data-parent="wpeo-form"><?php esc_html_e( 'Enregistrer les modifications', 'digirisk' ); ?></button>
	</div>
</form>
