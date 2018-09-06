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

<ul class="wpeo-form">
	<li><h2><?php esc_html_e( 'Service de santé au travail', 'digirisk' ); ?></h2></li>

	<li class="form-element">
		<span class="form-label"><?php esc_html_e( 'Nom du médecin du travail', 'digirisk' ); ?></span>
		<label class="form-field-container">
			<input name="occupational_health_service[full_name]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['occupational_health_service']->data['full_name'] ); ?>" />
		</label>
	</li>
	<li class="form-element">
		<span class="form-label"><?php esc_html_e( 'Adresse', 'digirisk' ); ?></span>
		<label class="form-field-container">
			<input name="occupational_health_service[address][address]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['occupational_health_service']->data['address']->data['address'] ); ?>" />
		</label>
	</li>
	<li class="form-element">
		<span class="form-label"><?php esc_html_e( 'Code postal', 'digirisk' ); ?></span>
		<label class="form-field-container">
			<input name="occupational_health_service[address][postcode]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['occupational_health_service']->data['address']->data['postcode'] ); ?>" />
		</label>
	</li>
	<li class="form-element">
		<span class="form-label"><?php esc_html_e( 'Ville', 'digirisk' ); ?></span>
		<label class="form-field-container">
			<input name="occupational_health_service[address][town]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['occupational_health_service']->data['address']->data['town'] ); ?>" />
		</label>
	</li>
	<li class="form-element">
		<span class="form-label"><?php esc_html_e( 'Téléphone', 'digirisk' ); ?></span>
		<label class="form-field-container">
			<input name="occupational_health_service[contact][phone]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['occupational_health_service']->data['contact']['phone'] ); ?>" />
		</label>
	</li>
	<li class="form-element">
		<span class="form-label"><?php esc_html_e( 'Horaires', 'digirisk' ); ?></span>
		<label class="form-field-container">
			<input name="occupational_health_service[opening_time]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['occupational_health_service']->data['opening_time'] ); ?>" />
		</label>
	</li>
</ul>
