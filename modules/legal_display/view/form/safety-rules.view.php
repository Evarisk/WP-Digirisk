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

<ul class="form">
	<li><h2><?php esc_html_e( 'Consignes de sécurité', 'digirisk' ); ?></h2></li>

	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->data['safety_rule']['responsible_for_preventing'] ) ? 'active' : '' ); ?>">
		<input name="safety_rule[responsible_for_preventing]" type="text" value="<?php echo esc_attr( $legal_display->data['safety_rule']['responsible_for_preventing'] ); ?>" />
		<label><?php esc_html_e( 'Responsable à prévenir', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->data['safety_rule']['phone'] ) ? 'active' : '' ); ?>">
		<input name="safety_rule[phone]" type="text" value="<?php echo esc_attr( $legal_display->data['safety_rule']['phone'] ); ?>" />
		<label><?php esc_html_e( 'Téléphone', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->data['safety_rule']['location_of_detailed_instruction'] ) ? 'active' : '' ); ?>">
		<input name="safety_rule[location_of_detailed_instruction]" type="text" value="<?php echo esc_attr( $legal_display->data['safety_rule']['location_of_detailed_instruction'] ); ?>" />
		<label><?php esc_html_e( 'Emplacement de la consigne détaillée', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
</ul>
