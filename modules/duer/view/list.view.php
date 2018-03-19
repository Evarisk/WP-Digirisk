<?php
/**
 * La liste des DUER
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.1.9
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<?php
if ( ! empty( $list_document ) ) :
	foreach ( $list_document as $element ) :
		\eoxia\View_Util::exec( 'digirisk', 'duer', 'list-item', array( 'element' => $element ) );
	endforeach;
endif;
