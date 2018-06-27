<?php
/**
 * Appel la méthode display_document_list de Document_Class pour gérér le template.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.2.1
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<table class="table">
	<?php Document_Class::g()->display_document_list( $element_id, array( 'affichage_legal_A3', 'affichage_legal_A4' ) ); ?>
</table>
