<?php
/**
 * Déclares la liste des contenant les fiches de groupements
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.2.1.0
 * @copyright 2015-2016 Evarisk
 * @package sheet_groupment
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<ul class="wp-digi-list wp-digi-risk wp-digi-table">
	<?php Fiche_De_Poste_Class::g()->display_document_list( $element_id ); ?>
	<?php view_util::exec( 'sheet_workunit', 'item-edit', array( 'element' => $element, 'element_id' => $element_id ) ); ?>
</ul>
