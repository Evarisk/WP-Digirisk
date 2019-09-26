<?php
/**
 * Service d'urgence
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
	<input type="hidden" name="action" value="save_emergency_work" />
	<input type="hidden" name="society[id]" value="<?php echo esc_attr( $element->data['id'] ); ?>" />
	<input type="hidden" name="address[post_id]" value="<?php echo esc_attr( $element->data['id'] ); ?>" />
	<input type="hidden" name="society[type]" value="<?php echo esc_attr( $element->data['type'] ); ?>" />
	<input type="hidden" name="legaldisplay_id" value="<?php echo esc_attr( $legal_display->data['id'] ); ?>" />
	<?php wp_nonce_field( 'save_emergency_work' ); ?>
	<div class="wpeo-gridlayout grid-1 grid-gap-1">

		<!-- PARTIE SERVICE D'URGENCE - EMERGENCY SERVICE -->

		<span style="text-align:  center; margin-top : 20px">
			<h2><?php esc_html_e( 'Service d\'urgence', 'digirisk' ); ?></h2>
		</span>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Samu', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="emergency_service[samu]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['emergency_service']['samu'] ); ?>" />
			</label>
		</div>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Police/Gendarmerie', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="emergency_service[police]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['emergency_service']['police'] ); ?>" />
			</label>
		</div>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Pompiers', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="emergency_service[pompier]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['emergency_service']['pompier'] ); ?>" />
			</label>
		</div>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Toute urgence', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="emergency_service[emergency]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['emergency_service']['emergency'] ); ?>" />
			</label>
		</div>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Défenseur des droits', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="emergency_service[right_defender]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['emergency_service']['right_defender'] ); ?>" />
			</label>
		</div>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Centre anti poison', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="emergency_service[poison_control_center]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['emergency_service']['poison_control_center'] ); ?>" />
			</label>
		</div>

		<!-- PARTIE CONSIGNE DE SECURTIE - SAFETY RULE -->

		<span style="text-align:  center; margin-top : 20px">
			<h2><?php esc_html_e( 'Consigne de sécurité', 'digirisk' ); ?></h2>
		</span>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Responsable à prévenir', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="safety_rule[responsible_for_preventing]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['safety_rule']['responsible_for_preventing'] ); ?>" />
			</label>
		</div>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Téléphone', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="safety_rule[phone]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['safety_rule']['phone'] ); ?>" />
			</label>
		</div>
		<div class="form-element">
			<span class="form-label"><?php esc_html_e( 'Emplacement de la consigne détaillée', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input name="safety_rule[location_of_detailed_instruction]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['safety_rule']['location_of_detailed_instruction'] ); ?>" />
			</label>
		</div>
	</div>
	<div class="gridw-2" style="margin-top : 10px">
		<button class="wpeo-button button-main action-input alignright" data-parent="wpeo-form"><?php esc_html_e( 'Enregistrer les modifications', 'digirisk' ); ?></button>
	</div>
</form>
