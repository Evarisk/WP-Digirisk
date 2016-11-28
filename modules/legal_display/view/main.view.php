<?php
/**
 * Déclares la liste des contenant les affichages légaux
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @version 6.2.1.0
 * @copyright 2015-2016 Evarisk
 * @package legal_display
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<ul class="wp-digi-list wp-digi-risk wp-digi-table">
	<?php Legal_Display_Class::g()->display_document_list( $element_id ); ?>
</ul>
