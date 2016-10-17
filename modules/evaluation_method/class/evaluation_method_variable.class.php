<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;
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
class evaluation_method_variable_class extends term_class {

	/**
	 * Nom du modèle à utiliser / Model name to use
	 * @var string
	 */
	protected $model_name   = '\digi\evaluation_method_variable_model';
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

	/**
	* Le constructeur
	*/
	protected function construct() {
		/**	Define taxonomy for evaluation method's vars	*/
		add_action( 'init', array( $this, 'evaluation_method_vars_type' ), 1 );
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}

	/**
	 * Création du type d'élément interne a wordpress pour gérer les variables des méthodes d'évaluation / Create wordpress element type for managing evaluation methods' vars
	 *
	*/
	function evaluation_method_vars_type() {
		$labels = array(
			'name'                       => _x( 'Evaluation methods vars', 'digirisk' ),
			'singular_name'              => _x( 'Evaluation methods var', 'digirisk' ),
			'search_items'               => __( 'Search evaluation methods vars', 'digirisk' ),
			'popular_items'              => __( 'Popular evaluation methods vars', 'digirisk' ),
			'all_items'                  => __( 'All evaluation methods vars', 'digirisk' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit evaluation methods var', 'digirisk' ),
			'update_item'                => __( 'Update evaluation methods var', 'digirisk' ),
			'add_new_item'               => __( 'Add New evaluation methods var', 'digirisk' ),
			'new_item_name'              => __( 'New evaluation methods var Name', 'digirisk' ),
			'separate_items_with_commas' => __( 'Separate evaluation methods vars with commas', 'digirisk' ),
			'add_or_remove_items'        => __( 'Add or remove evaluation methods vars', 'digirisk' ),
			'choose_from_most_used'      => __( 'Choose from the most used evaluation methods vars', 'digirisk' ),
			'not_found'                  => __( 'No evaluation methods vars found.', 'digirisk' ),
			'menu_name'                  => __( 'Evaluation methods vars', 'digirisk' ),
		);

		$args = array(
			'hierarchical'          => false,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'evaluation-method-variable' ),
		);

		register_taxonomy( evaluation_method_variable_class::g()->get_taxonomy(), array( risk_class::g()->get_post_type() ), $args );
	}

	public function get_evaluation_method_variable( $formula ) {
		$list_evaluation_method_variable = array();

		if ( !empty( $formula ) ) {
			foreach ( $formula as $key => $id ) {
				if ( $key % 2 == 0 ) {
					$evaluation_method_variable = evaluation_method_variable_class::g()->get( array( 'id' => $id ) );
					$list_evaluation_method_variable[] = $evaluation_method_variable[0];
				}
			}
		}

		return $list_evaluation_method_variable;
	}

}

evaluation_method_variable_class::g();
