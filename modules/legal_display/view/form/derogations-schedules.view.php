<?php
/**
 * Dérogations aux horaires
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package legal_display
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>


<ul class="form">
	<li><h2><?php esc_html_e( 'Dérogations aux horaires de travail', 'digirisk' ); ?></h2></li>

	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->derogation_schedule['permanent'] ) ? 'active' : '' ); ?>">
		<input name="derogation_schedule[permanent]" type="text" value="<?php echo esc_attr( $legal_display->derogation_schedule['permanent'] ); ?>" />
		<label><?php esc_html_e( 'Permanentes', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->derogation_schedule['occasional'] ) ? 'active' : '' ); ?>">
		<input name="derogation_schedule[occasional]" type="text" value="<?php echo esc_attr( $legal_display->derogation_schedule['occasional'] ); ?>" />
		<label><?php esc_html_e( 'Occasionnelles', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
</ul>
