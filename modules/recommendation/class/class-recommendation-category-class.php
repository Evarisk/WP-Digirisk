<?php
/**
 * Gestion des catégories des signalisations
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-only.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.1.5
 * @version   7.0.0
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * Recommendation category class.
 */
class Recommendation_Category extends \eoxia\Term_Class {

	/**
	 * Nom du modèle à utiliser
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Recommendation_Category_Model';

	/**
	 * Type de l'élément dans WordPress
	 *
	 * @var string
	 */
	protected $type = 'digi-recommendation-category';

	/**
	 * Nom du champs (meta) de stockage des données liées
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_recommendation_category';

	/**
	 * La route pour la REST API.
	 *
	 * @var string
	 */
	protected $base = 'recommendation-category';

	/**
	 * La version pour la rest api.
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'RE';

	/**
	 * Index important pour connaitres l'identifiant unique des recommandations.
	 *
	 * @var string
	 */
	public $last_affectation_index_key = '_wpdigi_last_recommendation_affectation_unique_key';
}

Recommendation_Category::g();
