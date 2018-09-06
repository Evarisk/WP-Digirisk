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

<ul class="wpeo-form">
	<li><h2><?php esc_html_e( 'Service d\'urgence', 'digirisk' ); ?></h2></li>

	<li class="form-element">
		<span class="form-label"><?php esc_html_e( 'Samu', 'digirisk' ); ?></span>
		<label class="form-field-container">
			<input name="emergency_service[samu]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['emergency_service']['samu'] ); ?>" />
		</label>
	</li>
	<li class="form-element">
		<span class="form-label"><?php esc_html_e( 'Police/Gendarmerie', 'digirisk' ); ?></span>
		<label class="form-field-container">
			<input name="emergency_service[police]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['emergency_service']['police'] ); ?>" />
		</label>
	</li>
	<li class="form-element">
		<span class="form-label"><?php esc_html_e( 'Pompiers', 'digirisk' ); ?></span>
		<label class="form-field-container">
			<input name="emergency_service[pompier]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['emergency_service']['pompier'] ); ?>" />
		</label>
	</li>
	<li class="form-element">
		<span class="form-label"><?php esc_html_e( 'Toute urgence', 'digirisk' ); ?></span>
		<label class="form-field-container">
			<input name="emergency_service[emergency]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['emergency_service']['emergency'] ); ?>" />
		</label>
	</li>
	<li class="form-element">
		<span class="form-label"><?php esc_html_e( 'Défenseur des droits', 'digirisk' ); ?></span>
		<label class="form-field-container">
			<input name="emergency_service[right_defender]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['emergency_service']['right_defender'] ); ?>" />
		</label>
	</li>
	<li class="form-element">
		<span class="form-label"><?php esc_html_e( 'Centre anti poison', 'digirisk' ); ?></span>
		<label class="form-field-container">
			<input name="emergency_service[poison_control_center]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['emergency_service']['poison_control_center'] ); ?>" />
		</label>
	</li>
</ul>
