<?php
/**
 * Documents
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
	<li><h2><?php esc_html_e( 'Convention(s) collective(s) applicable(s)', 'digirisk' ); ?></h2></li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->collective_agreement['title_of_the_applicable_collective_agreement'] ) ? 'active' : '' ); ?>">
		<input name="collective_agreement[title_of_the_applicable_collective_agreement]" type="text" value="<?php echo esc_attr( $legal_display->collective_agreement['title_of_the_applicable_collective_agreement'] ); ?>" />
		<label><?php esc_html_e( 'Intitulé', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->collective_agreement['location_and_access_terms_of_the_agreement'] ) ? 'active' : '' ); ?>">
		<input name="collective_agreement[location_and_access_terms_of_the_agreement]" type="text" value="<?php echo esc_attr( $legal_display->collective_agreement['location_and_access_terms_of_the_agreement'] ); ?>" />
		<label><?php esc_html_e( 'Lieu et modalités de consultation', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
</ul>
