<?php
/**
 * Déclares la liste des contient les documents uniques
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

<ul class="wp-digi-list wp-digi-risk wp-digi-table">
	<?php DUER_Class::g()->display_document_list( $element_id ); ?>
	<?php view_util::exec( 'document', 'DUER/item-edit', array( 'element' => $element, 'element_id' => $element_id ) ); ?>
</ul>
