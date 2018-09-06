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

<ul class="wpeo-form">
	<li><h2><?php esc_html_e( 'Dérogations aux horaires de travail', 'digirisk' ); ?></h2></li>

	<li class="form-element">
		<span class="form-label"><?php esc_html_e( 'Permanentes', 'digirisk' ); ?></span>
		<label class="form-field-container">
			<input name="derogation_schedule[permanent]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['derogation_schedule']['permanent'] ); ?>" />
		</label>
	</li>
	<li class="form-element">
		<span class="form-label"><?php esc_html_e( 'Occasionnelles', 'digirisk' ); ?></span>
		<label class="form-field-container">
			<input name="derogation_schedule[occasional]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['derogation_schedule']['occasional'] ); ?>" />
		</label>
	</li>
</ul>
