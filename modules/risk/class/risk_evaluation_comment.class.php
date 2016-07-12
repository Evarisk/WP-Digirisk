<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier du controlleur principal de l'extension digirisk pour wordpress / Main controller file for digirisk plugin
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe du controlleur principal de l'extension digirisk pour wordpress / Main controller class for digirisk plugin
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class risk_evaluation_comment_class extends comment_class {

	/**
	 * Nom du modèle à utiliser / Model name to use
	 * @var string
	 */
	protected $model_name   = 'wpdigi_riskevaluationcomment_mdl_01';
	/**
	 * Nom du champs (meta) de stockage des données liées / Name of field (meta) for linked datas storage
	 * @var string
	 */
	protected $meta_key     = '_wpdigi_risk_evaluation_comment';
	protected $comment_type	= 'digi-riskevalcomment';

	/** Défini la route par défaut permettant d'accèder aux points depuis WP Rest API  / Define the default route for accessing to point from WP Rest API */
	protected $base = 'digirisk/risk-evaluation-comment';
	protected $version = '0.1';

	/**
	 * Instanciation de la gestion des évaluations pour un risque / Instanciate controller for risk evaluation
	 */
	protected function construct() {
	}

}
