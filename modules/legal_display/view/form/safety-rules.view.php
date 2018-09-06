<?php
/**
 * Consignes de sécurité
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

<ul class="wpeo-form">
	<li><h2><?php esc_html_e( 'Consignes de sécurité', 'digirisk' ); ?></h2></li>

	<li class="form-element">
		<span class="form-label"><?php esc_html_e( 'Responsable à prévenir', 'digirisk' ); ?></span>
		<label class="form-field-container">
			<input name="safety_rule[responsible_for_preventing]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['safety_rule']['responsible_for_preventing'] ); ?>" />
		</label>
	</li>
	<li class="form-element">
		<span class="form-label"><?php esc_html_e( 'Téléphone', 'digirisk' ); ?></span>
		<label class="form-field-container">
			<input name="safety_rule[phone]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['safety_rule']['phone'] ); ?>" />
		</label>
	</li>
	<li class="form-element">
		<span class="form-label"><?php esc_html_e( 'Emplacement de la consigne détaillée', 'digirisk' ); ?></span>
		<label class="form-field-container">
			<input name="safety_rule[location_of_detailed_instruction]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['safety_rule']['location_of_detailed_instruction'] ); ?>" />
		</label>
	</li>
</ul>
