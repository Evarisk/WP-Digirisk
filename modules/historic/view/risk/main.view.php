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

defined( 'ABSPATH' ) || exit;

\eoxia\View_Util::exec( 'digirisk', 'historic', 'risk/list', array(
	'evaluations' => $evaluations,
) );
