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

<ul class="form">
	<li><h2><?php esc_html_e( 'Service de santé au travail', 'digirisk' ); ?></h2></li>

	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->data['occupational_health_service']->data['full_name'] ) ? 'active' : '' ); ?>">
		<input name="occupational_health_service[full_name]" type="text" value="<?php echo esc_attr( $legal_display->data['occupational_health_service']->data['full_name'] ); ?>" />
		<label><?php esc_html_e( 'Nom du médecin du travail', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->data['occupational_health_service']->data['address']->data['address'] ) ? 'active' : '' ); ?>">
		<input name="occupational_health_service[address][address]" type="text" value="<?php echo esc_attr( $legal_display->data['occupational_health_service']->data['address']->data['address'] ); ?>" />
		<label><?php esc_html_e( 'Adresse', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->data['occupational_health_service']->data['address']->data['postcode'] ) ? 'active' : '' ); ?>">
		<input name="occupational_health_service[address][postcode]" type="text" value="<?php echo esc_attr( $legal_display->data['occupational_health_service']->data['address']->data['postcode'] ); ?>" />
		<label><?php esc_html_e( 'Code postal', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->data['occupational_health_service']->data['address']->data['town'] ) ? 'active' : '' ); ?>">
		<input name="occupational_health_service[address][town]" type="text" value="<?php echo esc_attr( $legal_display->data['occupational_health_service']->data['address']->data['town'] ); ?>" />
		<label><?php esc_html_e( 'Ville', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->data['occupational_health_service']->data['contact']['phone'] ) ? 'active' : '' ); ?>">
		<input name="occupational_health_service[contact][phone]" type="text" value="<?php echo esc_attr( $legal_display->data['occupational_health_service']->data['contact']['phone'] ); ?>" />
		<label><?php esc_html_e( 'Téléphone', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->data['occupational_health_service']->data['opening_time'] ) ? 'active' : '' ); ?>">
		<input name="occupational_health_service[opening_time]" type="text" value="<?php echo esc_attr( $legal_display->data['occupational_health_service']->data['opening_time'] ); ?>" />
		<label><?php esc_html_e( 'Horaires', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
</ul>
