<?php
/**
 * La liste des DUER
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.1.9.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package duer
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; } ?>

<?php if ( ! empty( $list_document ) ) : ?>
	<?php foreach ( $list_document as $element ) : ?>
		<?php View_Util::exec( 'duer', 'list-item', array( 'element' => $element ) ); ?>
	<?php endforeach; ?>
<?php endif;
