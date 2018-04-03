<?php
/**
 * Gestion des catégories de recommandation.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.1.5
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des catégories de recommandation
 */
class Recommendation_Category_Term_Class extends \eoxia\Term_Class {

	/**
	 * Nom du modèle à utiliser
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Recommendation_Category_Term_Model';

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
	protected $meta_key = '_wpdigi_recommendationcategory';

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
	public $element_prefix = 'RC';
}

Recommendation_Category_Term_Class::g();
