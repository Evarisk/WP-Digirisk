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

<ul class="wpeo-form">
	<li><h2><?php esc_html_e( 'Accord de participation', 'digirisk' ); ?></h2></li>
	<li class="form-element">
		<span class="form-label"><?php esc_html_e( 'Modalités d\'information', 'digirisk' ); ?></span>
		<label class="form-field-container">
			<input name="participation_agreement[information_procedures]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['participation_agreement']['information_procedures'] ); ?>" />
		</label>
	</li>
</ul>
