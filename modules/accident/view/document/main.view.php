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
 * @since     6.3.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<table class="table document-accident-benins">
	<?php
	Document_Class::g()->display_document_list( $element->data['id'], array( 'accidents_benin' ) );

	\eoxia\View_Util::exec( 'digirisk', 'accident', 'document/item-edit', array(
		'element' => $element,
	) );
	?>
</table>
