<?php
/**
 * Gestion des réglages générales de DigiRisk.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.6.0
 * @version 6.6.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digirisk;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wpeo-form">
	<input type="hidden" name="action" value="save_general_settings_digirisk" />
	<?php wp_nonce_field( 'save_general_settings_digirisk' ); ?>

	<div class="form-element">
		<span class="form-label"><?php esc_html_e( 'Domaine de l\'email', 'digirisk' ); ?></span>

		<label class="form-field-container">
			<input type="text" name="domain_mail" class="form-field" value="<?php echo esc_attr( get_option( 'digirisk_domain_mail', 'demo.com' ) ); ?>" />
		</label>
	</div>
	
	<div class="form-element">
		<label class="form-field-container">
			<div class="form-field-inline">
				<input type="checkbox" id="edit_risk_category" class="form-field" name="edit_risk_category" <?php echo $can_edit_risk_category ? 'checked' : ''; ?> />
				<label for="edit_risk_category">Autoriser la modification des catégories de risques</label>
			</div>
		</label>
	</div>
	
	<div class="form-element">
		<label class="form-field-container">
			<div class="form-field-inline">
				<input type="checkbox" id="edit_type_cotation" class="form-field" name="edit_type_cotation" <?php echo $can_edit_type_cotation ? 'checked' : ''; ?> />
				<label for="edit_type_cotation">Autoriser la modification des types de cotation</label>
			</div>
		</label>
	</div>

	<div class="wpeo-button button-main action-input" data-parent="wpeo-form">
		<span><?php esc_html_e( 'Enregistrer les modifications', 'digirisk' ); ?></span>
	</div>
</div>
