<?php
/**
 * Formulaire du DUER
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
	<li><h2><?php esc_html_e( 'DUER', 'digirisk' ); ?></h2></li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->data['DUER']['how_access_to_duer'] ) ? 'active' : '' ); ?>">
		<input name="DUER[how_access_to_duer]" type="text" value="<?php echo esc_attr( $legal_display->data['DUER']['how_access_to_duer'] ); ?>" />
		<label><?php esc_html_e( 'Modalités d\'accès', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
</ul>
