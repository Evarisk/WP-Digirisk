<?php
/**
 * Gestion des commentaires de recommandations.
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
 * Gestion des commentaires de recommandations.
 */
class Recommendation_Comment_Class extends \eoxia\Comment_Class {

	/**
	 * Nom du modèle à utiliser
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Recommendation_Comment_Model';

	/**
	 * Nom du champs (meta) de stockage des données liées
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_recommendation_comment';

	/**
	 * Type de l'élément dans WordPress
	 *
	 * @var string
	 */
	protected $type = 'digi-re-comment';

	/**
	 * La route pour la REST API.
	 *
	 * @var string
	 */
	protected $base = 'recommendation-comment';

	/**
	 * La version pour la rest api.
	 *
	 * @var string
	 */
	protected $version = '0.1';
}

Recommendation_Comment_Class::g();
