<?php
/**
 * Déclares la liste des contenant les affichages légaux
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package legal_display
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<table class="table">
	<?php Legal_Display_Class::g()->display_document_list( $element_id ); ?>
</table>
