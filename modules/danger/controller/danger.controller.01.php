<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier du controlleur principal pour les dangers dans Digirisk / Controller file for danger for Digirisk
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe du controlleur principal pour les dangers dans Digirisk / Controller class for danger for Digirisk
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class wpdigi_danger_ctr_01 extends term_ctr_01 {
	/**
	 * Nom du modèle à utiliser / Model name to use
	 * @var string
	 */
	protected $model_name   = 'wpdigi_danger_mdl_01';
	/**
	 * Type de l'élément dans wordpress / Wordpress element type
	 * @var string
	 */
	protected $taxonomy    	= 'digi-danger';
	/**
	 * Nom du champs (meta) de stockage des données liées / Name of field (meta) for linked datas storage
	 * @var string
	 */
	protected $meta_key    	= '_wpdigi_danger';

	/**	Défini la route par défaut permettant d'accèder à l'élément depuis WP Rest API  / Define the default route for accessing to element from WP Rest API	*/
	protected $base = 'digirisk/danger';
	protected $version = '0.1';

	public $element_prefix = 'D';

	/**
	 * Instanciation de l'objet danger / Danger instanciation
	 */
	function __construct() {
		parent::__construct();

		/**	Inclusion du modèle pour les groupements / Include groups' model	*/
		include_once( WPDIGI_DANGER_PATH . 'model/danger.model.01.php' );

		/**	Define taxonomy for danger categories	*/
		add_action( 'init', array( $this, 'custom_type_creation' ), 5 );
	}

	/**
	 * Création du type d'élément interne a wordpress pour gérer les dangers / Create wordpress element type for managing dangers
	 *
	 * @uses register_taxonomy()
	 */
	function custom_type_creation() {
		global $wpdigi_risk_ctr;

		$labels = array(
			'name'                       => _x( 'Dangers', 'digirisk' ),
			'singular_name'              => _x( 'Danger', 'digirisk' ),
			'search_items'               => __( 'Search Dangers', 'digirisk' ),
			'popular_items'              => __( 'Popular Dangers', 'digirisk' ),
			'all_items'                  => __( 'All Dangers', 'digirisk' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Danger', 'digirisk' ),
			'update_item'                => __( 'Update Danger', 'digirisk' ),
			'add_new_item'               => __( 'Add New Danger', 'digirisk' ),
			'new_item_name'              => __( 'New Danger Name', 'digirisk' ),
			'separate_items_with_commas' => __( 'Separate dangers with commas', 'digirisk' ),
			'add_or_remove_items'        => __( 'Add or remove dangers', 'digirisk' ),
			'choose_from_most_used'      => __( 'Choose from the most used dangers', 'digirisk' ),
			'not_found'                  => __( 'No dangers found.', 'digirisk' ),
			'menu_name'                  => __( 'Dangers', 'digirisk' ),
		);

		$args = array(
			'hierarchical'          => true,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'danger' ),
		);

		register_taxonomy( $this->taxonomy, array( $wpdigi_risk_ctr->get_post_type() ), $args );

	}

	public function get_name_by_id( $danger_id ) {
		if (  true !== is_int( ( int )$danger_id ) )
			return false;

		$term = get_term_field( 'name', $danger_id, $this->taxonomy );

		return $term;
	}

	public function get_parent_by_id( $danger_id ) {
		if (  true !== is_int( ( int )$danger_id ) )
			return false;

		$term = get_term_field( 'parent', $danger_id, $this->taxonomy );

		return $term;
	}

	public function create_default_data() {
		global $wpdigi_danger_category_ctr;

		$file_content = file_get_contents( WPDIGI_DANGER_PATH . 'assets/json/default.json' );
		$data = json_decode( $file_content );


		if ( !empty( $data ) ) {
			foreach ( $data as $json_danger_category ) {
				$unique_key = wpdigi_utils::get_last_unique_key( 'term', $wpdigi_danger_category_ctr->get_taxonomy() );
				$unique_key++;
				$unique_identifier = $wpdigi_danger_category_ctr->element_prefix . '' . $unique_key;
				$danger_category = $wpdigi_danger_category_ctr->create( array(
					'name' => $json_danger_category->name,
					'option' => array(
						'unique_key' => $unique_key,
						'unique_identifier' => $unique_identifier,
						'status' => $json_danger_category->option->status,
					),
				) );

				if ( is_wp_error( $danger_category ) && !empty( $danger_category->errors ) && !empty( $danger_category->errors['term_exists'] ) ) {
					$danger_category = $this->show( $danger_category->error_data['term_exists'] );
				}

				if ( $json_danger_category->option->status == 'valid' ) {
					$file_id = wpdigi_utils::upload_file( WPDIGI_PATH . '/core/assets/images/categorieDangers/' . $json_danger_category->name_thumbnail, 0 );

					$danger_category->option['thumbnail_id'] = $file_id;
					$danger_category = $wpdigi_danger_category_ctr->update( $danger_category );
				}

				foreach( $json_danger_category->option->danger as $json_danger ) {
					$unique_key = wpdigi_utils::get_last_unique_key( 'term', $this->get_taxonomy() );
					$unique_key++;
					$unique_identifier = $this->element_prefix . '' . $unique_key;
					$danger = $this->create( array(
						'name' => $json_danger->name,
						'parent_id' => $danger_category->id,
						'option' => array(
							'unique_key' => $unique_key,
							'unique_identifier' => $unique_identifier,
							'status' => $json_danger->option->status,
						),
					) );

					if ( !is_wp_error( $danger ) ) {
						if ( $json_danger->option->status == 'valid' && !empty( $json_danger_category->name_thumbnail ) ) {
							if ( !empty( $json_danger->name_thumbnail ) ) {
								$file_id = wpdigi_utils::upload_file( WPDIGI_PATH . '/core/assets/images/categorieDangers/' . $json_danger->name_thumbnail, 0 );

							}
							else {
								$file_id = wpdigi_utils::upload_file( WPDIGI_PATH . '/core/assets/images/categorieDangers/' . $json_danger_category->name_thumbnail, 0 );
							}
								$danger->option['thumbnail_id'] = $file_id;
								$danger = $this->update( $danger );
						}
					}
				}
			}
		}
	}
}

/**
 * Création de l'élément danger / Danger element creation
 */
global $wpdigi_danger_ctr;
$wpdigi_danger_ctr = new wpdigi_danger_ctr_01();
