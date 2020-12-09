<?php
/**
 * Gestion des réglages générales de DigiRisk.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     7.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

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
		<span class="form-label"><?php esc_html_e( 'Nombre de jour obligatoire pour le DUER', 'digirisk' ); ?></span>

		<label class="form-field-container">
			<input type="text" name="general_options[required_duer_day]" class="form-field" value="<?php echo esc_attr( $general_options['required_duer_day'] ); ?>" />
		</label>
	</div>


	<div class="form-element">
		<label class="form-field-container">
			<div class="form-field-inline">
				<input type="checkbox" id="edit_risk_category" class="form-field" name="edit_risk_category" <?php echo $can_edit_risk_category ? 'checked' : ''; ?> />
				<label for="edit_risk_category"><?php esc_html_e( 'Autoriser la modification des catégories de risques', 'digirisk' ); ?></label>
			</div>
		</label>
	</div>

	<div class="form-element">
		<label class="form-field-container">
			<div class="form-field-inline">
				<input type="checkbox" id="edit_type_cotation" class="form-field" name="edit_type_cotation" <?php echo $can_edit_type_cotation ? 'checked' : ''; ?> />
				<label for="edit_type_cotation"><?php esc_html_e( 'Autoriser la modification des types de cotation', 'digirisk' ); ?></label>
			</div>
		</label>
	</div>

	<div class="form-element">
		<label class="form-field-container">
			<div class="form-field-inline">
				<input type="checkbox" id="mask_number_GP_UT" class="form-field" name="mask_number_GP_UT" <?php echo $can_mask_number_GP_UT ? 'checked' : ''; ?> />
				<label for="mask_number_GP_UT"><?php esc_html_e( 'Hide GP and UT number', 'digirisk' ); ?></label>
			</div>
		</label>
	</div>

	<div class="wpeo-button button-main action-input" data-parent="wpeo-form">
		<span><?php esc_html_e( 'Enregistrer les modifications', 'digirisk' ); ?></span>
	</div>
</div>
