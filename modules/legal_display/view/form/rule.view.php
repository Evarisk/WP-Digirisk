<?php
/**
 * Formulaire du Règlement intérieur
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
	<li><h2><?php esc_html_e( 'Règlement intérieur', 'digirisk' ); ?></h2></li>

	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->data['rules']['location'] ) ? 'active' : '' ); ?>">
		<input name="rules[location]" type="text" value="<?php echo esc_attr( $legal_display->data['rules']['location'] ); ?>" />
		<label><?php esc_html_e( 'Lieux d\'affichage', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
</ul>
