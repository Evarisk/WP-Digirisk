<?php
/**
 * Gestion des catégories de recommandation.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.1.5
 * @version 6.5.0
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
	protected $taxonomy = 'digi-recommendation-category';

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
	 * La fonction appelée automatiquement avant la création de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_post_function = array( '\digi\construct_identifier' );

	/**
	 * La fonction appelée automatiquement après la récupération de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $after_get_function = array( '\digi\get_identifier', '\digi\get_full_recommendation_category' );

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'RC';
}

Recommendation_Category_Term_Class::g();
