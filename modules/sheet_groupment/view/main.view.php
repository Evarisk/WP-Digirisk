<?php
/**
 * Déclares la liste des contenant les fiches de groupements
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package sheet_groupment
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<table class="table">
	<?php Fiche_De_Groupement_Class::g()->display_document_list( $element_id ); ?>
	<?php View_Util::exec( 'sheet_groupment', 'item-edit', array( 'element' => $element, 'element_id' => $element_id ) ); ?>
</table>
