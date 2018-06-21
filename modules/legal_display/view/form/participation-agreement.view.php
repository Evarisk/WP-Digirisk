<?php
/**
 * Formulaire: Accord de participation.
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
	<li><h2><?php esc_html_e( 'Accord de participation', 'digirisk' ); ?></h2></li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->data['participation_agreement']['information_procedures'] ) ? 'active' : '' ); ?>">
		<input name="participation_agreement[information_procedures]" type="text" value="<?php echo esc_attr( $legal_display->data['participation_agreement']['information_procedures'] ); ?>" />
		<label><?php esc_html_e( 'Modalités d\'information', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
</ul>
