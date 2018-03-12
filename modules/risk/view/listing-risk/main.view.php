<?php
/**
 * Appel la méthode pour afficher la liste des listing de risque.
 * Appel la vue "item-edit".
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.5.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<table class="table">
	<?php Listing_Risk_Class::g()->display_document_list( $element_id ); ?>

	<?php
	\eoxia\View_Util::exec( 'digirisk', 'risk', 'listing-risk/item-edit', array(
		'element'    => $element,
		'element_id' => $element_id,
	) );
	?>
</table>
