<?php
/**
 * Déclares la liste des contenant les ODT des accidents de travail bénin
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.3.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; } ?>

<table class="table document-accident-benins">
	<?php Accident_Travail_Benin_Class::g()->display_document_list(); ?>
	<?php \eoxia\View_Util::exec( 'digirisk', 'accident', 'document/item-edit', array(
		'element' => $element,
	) ); ?>
</table>
