<?php
/**
 * Covention(s) collective(s) applicable(s)
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
	<li><h2><?php esc_html_e( 'Convention(s) collective(s) applicable(s)', 'digirisk' ); ?></h2></li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->data['collective_agreement']['title_of_the_applicable_collective_agreement'] ) ? 'active' : '' ); ?>">
		<input name="collective_agreement[title_of_the_applicable_collective_agreement]" type="text" value="<?php echo esc_attr( $legal_display->data['collective_agreement']['title_of_the_applicable_collective_agreement'] ); ?>" />
		<label><?php esc_html_e( 'Intitulé', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
	<li class="form-element <?php echo esc_attr( ! empty( $legal_display->data['collective_agreement']['location_and_access_terms_of_the_agreement'] ) ? 'active' : '' ); ?>">
		<input name="collective_agreement[location_and_access_terms_of_the_agreement]" type="text" value="<?php echo esc_attr( $legal_display->data['collective_agreement']['location_and_access_terms_of_the_agreement'] ); ?>" />
		<label><?php esc_html_e( 'Lieu et modalités de consultation', 'digirisk' ); ?></label>
		<span class="bar"></span>
	</li>
</ul>
