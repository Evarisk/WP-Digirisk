<?php if ( !defined( 'ABSPATH' ) ) exit;
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
class wpdigi_danger_category_ctr_01 extends term_ctr_01 {
	/**
	 * Nom du modèle à utiliser / Model name to use
	 * @var string
	 */
	protected $model_name   = 'wpdigi_category_danger_mdl_01';
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

	public $element_prefix = 'CD';

	/**
	 * Instanciation de l'objet cétégories de danger / Danger category instanciation
	 */
	function __construct() {
		/**	Instanciation du controlleur parent / Instanciate the parent controller */
		parent::__construct();

		/**	Inclusion du modèle / Include model	*/
		include_once( WPDIGI_DANGER_PATH . 'model/danger_category.model.01.php' );

		/**	Définition du type de données personnalisées pour les catégories de dangers / Define custom type for danger categories */
		add_action( 'init', array( $this, 'custom_type_creation' ), 0 );
	}

	/**
	 * Création du type d'élément interne a wordpress pour gérer les catégories de dangers / Create wordpress element type for managing dangers categories
	 *
	 * @uses register_post_type()
	 */
	function custom_type_creation() {
		global $wpdigi_risk_ctr;

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

		register_taxonomy( $this->taxonomy, array( $wpdigi_risk_ctr->get_post_type() ), $args );
	}

	function display_category_danger( $args ) {
		$danger_category_list = $this->index( array() );

		require_once( wpdigi_utils::get_template_part( WPDIGI_DANGER_DIR, DIGI_DANGER_TEMPLATES_MAIN_DIR, "backend", 'category_danger', 'list' ) );
	}

}

/**
 * Création de l'élément catégorie de danger / Danger category element creation
 */
global $wpdigi_danger_category_ctr;
$wpdigi_danger_category_ctr = new wpdigi_danger_category_ctr_01();
