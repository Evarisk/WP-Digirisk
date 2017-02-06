<?php
/**
 * Le règlement intérieur
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
	<li><h2><?php esc_html_e( 'Règlement intérieur', 'digirisk' ); ?></h2></li>

	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->rules['location'] ) ? 'active' : '' ); ?>">
		<input name="rules[location]" type="text" value="<?php echo esc_attr( $legal_display->rules['location'] ); ?>" />
		<label><?php esc_html_e( 'Lieux d\'affichage', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
</ul>
