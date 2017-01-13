<?php
/**
 * Modalités d'accés au DUER
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
	<li><h2><?php esc_html_e( 'DUER', 'digirisk' ); ?></h2></li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->DUER['how_access_to_duer'] ) ? 'active' : '' ); ?>">
		<input name="DUER[how_access_to_duer]" type="text" value="<?php echo esc_attr( $legal_display->DUER['how_access_to_duer'] ); ?>" />
		<label><?php esc_html_e( 'Modalités d\'accès', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
</ul>
