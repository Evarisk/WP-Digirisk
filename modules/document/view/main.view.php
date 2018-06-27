<?php
/**
 * Template appelant la méthode display_document_list afin d'afficher la liste des documents (fiche de groupement ou de poste).
 *
 * Appel la vue "item-edit" pour ajouter le bouton "+" qui permet de généré une fiche de groupement ou de poste.
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
	<?php Document_Class::g()->display_document_list( $element_id, array( $type ) ); ?>

	<?php
	\eoxia\View_Util::exec( 'digirisk', 'document', 'item-edit', array(
		'_this'      => $_this,
		'action'     => $action,
		'element'    => $element,
		'element_id' => $element_id,
	) );
	?>
</table>
