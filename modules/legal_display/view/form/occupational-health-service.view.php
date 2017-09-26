<?php
/**
 * Service de santé au travail
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<ul class="form">
	<li><h2><?php esc_html_e( 'Service de santé au travail', 'digirisk' ); ?></h2></li>

	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->occupational_health_service->full_name ) ? 'active' : '' ); ?>">
		<input name="occupational_health_service[full_name]" type="text" value="<?php echo esc_attr( $legal_display->occupational_health_service->full_name ); ?>" />
		<label><?php esc_html_e( 'Nom du médecin du travail', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->occupational_health_service->address->address ) ? 'active' : '' ); ?>">
		<input name="occupational_health_service[address][address]" type="text" value="<?php echo esc_attr( $legal_display->occupational_health_service->address->address ); ?>" />
		<label><?php esc_html_e( 'Adresse', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->occupational_health_service->address->postcode ) ? 'active' : '' ); ?>">
		<input name="occupational_health_service[address][postcode]" type="text" value="<?php echo esc_attr( $legal_display->occupational_health_service->address->postcode ); ?>" />
		<label><?php esc_html_e( 'Code postal', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->occupational_health_service->address->town ) ? 'active' : '' ); ?>">
		<input name="occupational_health_service[address][town]" type="text" value="<?php echo esc_attr( $legal_display->occupational_health_service->address->town ); ?>" />
		<label><?php esc_html_e( 'Ville', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->occupational_health_service->contact['phone'] ) ? 'active' : '' ); ?>">
		<input name="occupational_health_service[contact][phone]" type="text" value="<?php echo esc_attr( $legal_display->occupational_health_service->contact['phone'] ); ?>" />
		<label><?php esc_html_e( 'Téléphone', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->occupational_health_service->opening_time ) ? 'active' : '' ); ?>">
		<input name="occupational_health_service[opening_time]" type="text" value="<?php echo esc_attr( $legal_display->occupational_health_service->opening_time ); ?>" />
		<label><?php esc_html_e( 'Horaires', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
</ul>
