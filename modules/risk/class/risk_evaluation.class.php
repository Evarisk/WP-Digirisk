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
class risk_evaluation_class extends comment_class {

	/**
	 * Nom du modèle à utiliser / Model name to use
	 * @var string
	 */
	protected $model_name   = 'wpdigi_riskevaluation_mdl_01';
	/**
	 * Nom du champs (meta) de stockage des données liées / Name of field (meta) for linked datas storage
	 * @var string
	 */
	protected $meta_key     = '_wpdigi_risk_evaluation';
	protected $comment_type	= 'digi-risk-eval';

	/** Défini la route par défaut permettant d'accèder aux points depuis WP Rest API  / Define the default route for accessing to point from WP Rest API */
	protected $base = 'digirisk/risk-evaluation';
	protected $version = '0.1';

	public $element_prefix = 'E';

	/**
	 * Instanciation de la gestion des évaluations pour un risque / Instanciate controller for risk evaluation
	 */
	protected function construct() {
		/**	Inclusion du modèle pour les groupements / Include groups' model	*/
		include_once( RISK_PATH . '/model/risk_evaluation.model.01.php' );
	}

}
