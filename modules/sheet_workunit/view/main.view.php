<?php
/**
 * Déclares la liste des contenant les fiches de poste
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<table class="table">
	<?php Sheet_Workunit_Class::g()->display_document_list( $element_id ); ?>
</table>
