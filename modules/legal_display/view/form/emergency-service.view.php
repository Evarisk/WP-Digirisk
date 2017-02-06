<?php namespace digi;
/**
* Service d'urgence
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @since 0.1
* @version 6.2.4.0
* @copyright 2015-2017 Evarisk
* @package legal_display
* @subpackage view
*/

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<ul class="form">
	<li><h2><?php esc_html_e( 'Service d\'urgence', 'digirisk' ); ?></h2></li>

	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->emergency_service['samu'] ) ? 'active' : '' ); ?>">
		<input name="emergency_service[samu]" type="text" value="<?php echo esc_attr( $legal_display->emergency_service['samu'] ); ?>" />
		<label><?php esc_html_e( 'Samu', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->emergency_service['police'] ) ? 'active' : '' ); ?>">
		<input name="emergency_service[police]" type="text" value="<?php echo esc_attr( $legal_display->emergency_service['police'] ); ?>" />
		<label><?php esc_html_e( 'Police/Gendarmerie', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->emergency_service['pompier'] ) ? 'active' : '' ); ?>">
		<input name="emergency_service[pompier]" type="text" value="<?php echo esc_attr( $legal_display->emergency_service['pompier'] ); ?>" />
		<label><?php esc_html_e( 'Pompiers', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->emergency_service['emergency'] ) ? 'active' : '' ); ?>">
		<input name="emergency_service[emergency]" type="text" value="<?php echo esc_attr( $legal_display->emergency_service['emergency'] ); ?>" />
		<label><?php esc_html_e( 'Toute urgence', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->emergency_service['right_defender'] ) ? 'active' : '' ); ?>">
		<input name="emergency_service[right_defender]" type="text" value="<?php echo esc_attr( $legal_display->emergency_service['right_defender'] ); ?>" />
		<label><?php esc_html_e( 'Défenseur des droits', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->emergency_service['poison_control_center'] ) ? 'active' : '' ); ?>">
		<input name="emergency_service[poison_control_center]" type="text" value="<?php echo esc_attr( $legal_display->emergency_service['poison_control_center'] ); ?>" />
		<label><?php esc_html_e( 'Centre anti poison', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
</ul>
