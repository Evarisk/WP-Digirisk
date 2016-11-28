<?php
/**
 * La liste des DUER
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.1.9.0
 * @copyright 2015-2016 Evarisk
 * @package document
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<li class="wp-digi-risk-list-header wp-digi-table-header">
	<span><?php \esc_html_e( 'Ref', 'digirisk' ); ?></span>
	<span><?php \esc_html_e( 'Début', 'digirisk' ); ?></span>
	<span><?php \esc_html_e( 'Fin', 'digirisk' ); ?></span>
	<span style="width: 5%"><?php \esc_html_e( 'Destinataire', 'digirisk' ); ?></span>
	<span style="width: 5%"><?php \esc_html_e( 'Méthodologie', 'digirisk' ); ?></span>
	<span style="width: 5%"><?php \esc_html_e( 'Sources', 'digirisk' ); ?></span>
	<span style="width: 5%"><?php \esc_html_e( 'Notes importantes', 'digirisk' ); ?></span>
	<span style="width: 5%"><?php \esc_html_e( 'Localisation', 'digirisk' ); ?></span>
	<span></span>
</li>

<?php if ( ! empty( $list_document ) ) : ?>
	<?php foreach ( $list_document as $element ) : ?>
		<?php view_util::exec( 'duer', 'list-item', array( 'element' => $element ) ); ?>
	<?php endforeach; ?>
<?php endif; ?>
