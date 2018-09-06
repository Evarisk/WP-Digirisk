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

<ul class="wpeo-form">
	<li><h2><?php esc_html_e( 'Convention(s) collective(s) applicable(s)', 'digirisk' ); ?></h2></li>
	<li class="form-element">
		<span class="form-label"><?php esc_html_e( 'Intitulé', 'digirisk' ); ?></span>
		<label class="form-field-container">
			<input name="collective_agreement[title_of_the_applicable_collective_agreement]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['collective_agreement']['title_of_the_applicable_collective_agreement'] ); ?>" />
		</label>
	</li>
	<li class="form-element">
		<span class="form-label"><?php esc_html_e( 'Lieu et modalités de consultation', 'digirisk' ); ?></span>
		<label class="form-field-container">
			<input name="collective_agreement[location_and_access_terms_of_the_agreement]" class="form-field" type="text" value="<?php echo esc_attr( $legal_display->data['collective_agreement']['location_and_access_terms_of_the_agreement'] ); ?>" />
		</label>
	</li>
</ul>
