<?php
/**
 * Classe gérant les fiches de groupement.
 *
 * Cette classe pointe seulement le modèle Sheet_Workunit_Model.
 *
 * Elle hérite de Sheet_Class qui elle permet de géré l'affichage et la génération de la fiche de poste.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Sheet Workunit class.
 */
class Sheet_Workunit_Class extends Sheet_Class {

	/**
	 * Le nom du modèle
	 *
	 * @since 6.0.0
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Sheet_Workunit_Model';

	/**
	 * Le post type
	 *
	 * @since 6.0.0
	 *
	 * @var string
	 */
	protected $type = 'fiche_de_poste';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @since 6.0.0
	 *
	 * @var string
	 */
	protected $base = 'fiche-de-poste';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @since 6.0.0
	 *
	 * @var string
	 */
	public $element_prefix = 'FP';

	/**
	 * Le nom pour le resgister post type
	 *
	 * @since 6.0.0
	 *
	 * @var string
	 */
	protected $post_type_name = 'Fiche de poste';

	/**
	 * Le nom de l'ODT sans l'extension; exemple: document_unique
	 *
	 * @since 6.0.0
	 *
	 * @var string
	 */
	protected $odt_name = 'unite_de_travail';
}

Sheet_Workunit_Class::g();
