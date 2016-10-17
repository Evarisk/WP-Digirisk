<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier du controlleur principal pour les catégories de dangers dans Digirisk / Controller file for danger categories for Digirisk
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe du controlleur principal pour les catégories de dangers dans Digirisk / Controller class for danger categories for Digirisk
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class category_danger_class extends term_class {
	/**
	 * Nom du modèle à utiliser / Model name to use
	 * @var string
	 */
	protected $model_name   = '\digi\category_danger_model';
	/**
	 * Type de l'élément dans wordpress / Wordpress element type
	 * @var string
	 */
	protected $taxonomy    	= 'digi-danger-category';
	/**
	 * Nom du champs (meta) de stockage des données liées / Name of field (meta) for linked datas storage
	 * @var string
	 */
	protected $meta_key    	= '_wpdigi_dangercategory';

	/**	Défini la route par défaut permettant d'accèder à l'élément depuis WP Rest API  / Define the default route for accessing to element from WP Rest API	*/
	protected $base = 'digirisk/danger-category';
	protected $version = '0.1';

	protected $before_post_function = array( '\digi\construct_identifier' );
	protected $after_get_function = array( '\digi\get_identifier' );
	public $element_prefix = 'CD';

	/**
	 * Instanciation de l'objet cétégories de danger / Danger category instanciation
	 */
	protected function construct() {
		/**	Définition du type de données personnalisées pour les catégories de dangers / Define custom type for danger categories */
		add_action( 'init', array( $this, 'custom_type_creation' ), 1 );
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}

	/**
	 * Création du type d'élément interne a wordpress pour gérer les catégories de dangers / Create wordpress element type for managing dangers categories
	 */
	function custom_type_creation() {
		$labels = array(
			'name'              => __( 'Danger categories', 'digirisk' ),
			'singular_name'     => __( 'Danger category', 'digirisk' ),
			'search_items'      => __( 'Search Danger categories', 'digirisk' ),
			'all_items'         => __( 'All Danger categories', 'digirisk' ),
			'parent_item'       => null,
			'parent_item_colon' => null,
			'edit_item'         => __( 'Edit Danger category', 'digirisk' ),
			'update_item'       => __( 'Update Danger category', 'digirisk' ),
			'add_new_item'      => __( 'Add New Danger category', 'digirisk' ),
			'new_item_name'     => __( 'New Danger category Name' , 'digirisk'),
			'menu_name'         => __( 'Danger category', 'digirisk' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'danger-category' ),
		);

		register_taxonomy( $this->taxonomy, array( risk_class::g()->get_post_type() ), $args );
	}
}

category_danger_class::g();
