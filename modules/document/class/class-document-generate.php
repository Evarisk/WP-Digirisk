<?php
/**
 * Classe gérant la génération de tous les documents.
 *
 * Elle comporte de nombreux filtre WordPress permettant de rajouter des
 * données à tout moment avant de généré le document ODT.
 *
 * Cette classe gère tous les types de document, DUER, Fiche de Groupement,
 * Fiche de Poste, Affichage légal, Diffusion d'information, Listing de risque.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     7.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Document util class.
 */
class Document_Generate extends \eoxia\Singleton_Util {

	/**
	 * Constructeur.
	 *
	 * @since 7.0.0
	 */
	protected function construct() {}


}

Document_Generate::g();
