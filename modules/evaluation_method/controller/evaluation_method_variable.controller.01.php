<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier contenant les utilitaires pour la gestion des méthodes d'évaluation / File with all utilities for managing evaluation method
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe contenant les utilitaires pour la gestion des méthodes d'évaluation / Class with all utilities for managing evaluation method
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class wpdigi_evaluation_method_variable_controller_01 extends term_ctr_01 {

	/**
	 * Nom du modèle à utiliser / Model name to use
	 * @var string
	 */
	protected $model_name   = 'wpdigi_evaluation_method_variable_mdl_01';
	/**
	 * Type de l'élément dans wordpress / Wordpress element type
	 * @var string
	 */
	protected $taxonomy    	= 'digi-method-variable';
	/**
	 * Nom du champs (meta) de stockage des données liées / Name of field (meta) for linked datas storage
	 * @var string
	 */
	protected $meta_key    	= '_wpdigi_methodvariable';

	/**	Défini la route par défaut permettant d'accèder à l'élément depuis WP Rest API  / Define the default route for accessing to element from WP Rest API	*/
	protected $base = 'digirisk/evaluation-method-variable';
	protected $version = '0.1';

	/* PRODEST:
	{
		"name": "__construct",
		"description": "Instanciation des outils pour la gestion des méthodes d'évaluation / Instanciate utilities for managing evaluation method",
		"type": "function",
		"check": false,
		"author":
		{
		"email": "dev@evarisk.com",
		"name": "Alexandre T"
		},
		"version": 1.0
	}
	*/
	function __construct() {
		/**	Instanciation du controlleur parent / Instanciate the parent controller */
		parent::__construct();

		/**	Inclusion du modèle / Include model	*/
		include_once( WPDIGI_EVALMETHOD_PATH . 'model/evaluation_method_variable.model.01.php' );

		/**	Define taxonomy for evaluation method's vars	*/
		add_action( 'init', array( $this, 'evaluation_method_vars_type' ), 0 );
	}

	/**
	 * Création du type d'élément interne a wordpress pour gérer les variables des méthodes d'évaluation / Create wordpress element type for managing evaluation methods' vars
	 *
	*/
	function evaluation_method_vars_type() {
		global $wpdigi_risk_ctr;

		$labels = array(
			'name'                       => _x( 'Evaluation methods vars', 'wpdigi-i18n' ),
			'singular_name'              => _x( 'Evaluation methods var', 'wpdigi-i18n' ),
			'search_items'               => __( 'Search evaluation methods vars', 'wpdigi-i18n' ),
			'popular_items'              => __( 'Popular evaluation methods vars', 'wpdigi-i18n' ),
			'all_items'                  => __( 'All evaluation methods vars', 'wpdigi-i18n' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit evaluation methods var', 'wpdigi-i18n' ),
			'update_item'                => __( 'Update evaluation methods var', 'wpdigi-i18n' ),
			'add_new_item'               => __( 'Add New evaluation methods var', 'wpdigi-i18n' ),
			'new_item_name'              => __( 'New evaluation methods var Name', 'wpdigi-i18n' ),
			'separate_items_with_commas' => __( 'Separate evaluation methods vars with commas', 'wpdigi-i18n' ),
			'add_or_remove_items'        => __( 'Add or remove evaluation methods vars', 'wpdigi-i18n' ),
			'choose_from_most_used'      => __( 'Choose from the most used evaluation methods vars', 'wpdigi-i18n' ),
			'not_found'                  => __( 'No evaluation methods vars found.', 'wpdigi-i18n' ),
			'menu_name'                  => __( 'Evaluation methods vars', 'wpdigi-i18n' ),
		);

		$args = array(
			'hierarchical'          => false,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'evaluation-method-variable' ),
		);

		register_taxonomy( $this->taxonomy, null, $args );
	}


}

global $wpdigi_evaluation_method_variable_controller;
$wpdigi_evaluation_method_variable_controller = new wpdigi_evaluation_method_variable_controller_01();
