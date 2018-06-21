<?php
/**
 * Dérogations aux horaires de travail
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
	<li><h2><?php esc_html_e( 'Dérogations aux horaires de travail', 'digirisk' ); ?></h2></li>

	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->data['derogation_schedule']['permanent'] ) ? 'active' : '' ); ?>">
		<input name="derogation_schedule[permanent]" type="text" value="<?php echo esc_attr( $legal_display->data['derogation_schedule']['permanent'] ); ?>" />
		<label><?php esc_html_e( 'Permanentes', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->data['derogation_schedule']['occasional'] ) ? 'active' : '' ); ?>">
		<input name="derogation_schedule[occasional]" type="text" value="<?php echo esc_attr( $legal_display->data['derogation_schedule']['occasional'] ); ?>" />
		<label><?php esc_html_e( 'Occasionnelles', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
</ul>
