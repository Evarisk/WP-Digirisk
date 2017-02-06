<?php
/**
 * La vue du bouton "Télécharger le document unique".
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.5.0
 * @version 6.2.5.0
 * @copyright 2015-2017 Evarisk
 * @package duer
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<div
	class="tab-element dut button red uppercase"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_content' ) ); ?>"
	data-target="main-content"
	data-action="digi_list_duer"
	data-id="<?php echo esc_attr( $element->id ); ?>"
	data-title="<?php echo esc_attr( 'Les documents uniques de', 'digirisk' ); ?>"><i class="icon fa fa-download"></i>

	<span><?php esc_html_e( 'DUER', 'digirisk' ); ?></span>
</div>
