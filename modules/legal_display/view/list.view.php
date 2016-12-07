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
	<span><?php \esc_html_e( 'Nom', 'digirisk' ); ?></span>
	<span></span>
</li>

<?php if ( ! empty( $list_document ) ) : ?>
	<?php foreach ( $list_document as $element ) : ?>
		<?php view_util::exec( 'legal_display', 'list-item', array( 'element' => $element ) ); ?>
	<?php endforeach; ?>
<?php endif; ?>
