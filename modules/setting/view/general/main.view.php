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

	<div class="wpeo-button button-main action-input" data-parent="wpeo-form">
		<span><?php esc_html_e( 'Enregistrer les modifications', 'digirisk' ); ?></span>
	</div>
</div>
