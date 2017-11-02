<?php
/**
 * Affichage d'une causerie.
 *
 * @autror Jimmy Latour <jimmy@evarisk.com>
 * @since 6.5.0
 * @version 6.5.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<tr>
	<tr class="w50 padding"><?php esc_html_e( 'Ref', 'digirisk' ); ?>.</tr>
	<tr class="w50"><?php esc_html_e( 'Photo', 'digirisk' ); ?></tr>
	<tr><?php esc_html_e( 'Titre et date', 'digirisk' ); ?></tr>
	<tr><?php esc_html_e( 'Cat.', 'digirisk' ); ?></tr>
	<tr><?php esc_html_e( 'Doc. Joints', 'digirisk' ); ?></tr>
	<tr><?php esc_html_e( 'Formateur', 'digirisk' ); ?></tr>
	<tr><?php esc_html_e( 'Person. présent', 'digirisk' ); ?></tr>
	<tr class="w150"></tr>
</tr>
