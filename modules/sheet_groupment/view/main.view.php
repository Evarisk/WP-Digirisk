<?php
/**
 * Appel la méthode pour afficher la liste des fiches de groupement.
 * Appel la vue "item-edit".
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.1
 * @version 6.4.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<table class="table">
	<?php Sheet_Groupment_Class::g()->display_document_list( $element_id ); ?>

	<?php
	\eoxia\View_Util::exec( 'digirisk', 'sheet_groupment', 'item-edit', array(
		'element'    => $element,
		'element_id' => $element_id,
	) );
	?>
</table>
