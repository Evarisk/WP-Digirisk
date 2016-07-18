<?php if ( !defined( 'ABSPATH' ) ) exit;
/**
 * Fichier contenant les utilitaires pour la gestion des préconisations / File with all utilities for managing recommendations
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */

/**
 * Classe contenant les utilitaires pour la gestion des préconisations / Class with all utilities for managing recommendations
 *
 * @author Evarisk development team <dev@evarisk.com>
 * @version 6.0
 */
class recommendation_class extends term_class {

	/**
	 * Nom du modèle à utiliser / Model name to use
	 * @var string
	 */
	protected $model_name   = 'wpdigi_recommendation_mdl_01';
	/**
	 * Type de l'élément dans wordpress / Wordpress element type
	 * @var string
	 */
	protected $taxonomy    	= 'digi-recommendation';
	/**
	 * Nom du champs (meta) de stockage des données liées / Name of field (meta) for linked datas storage
	 * @var string
	 */
	protected $meta_key    	= '_wpdigi_recommendation';

	/**	Défini la route par défaut permettant d'accèder à l'élément depuis WP Rest API  / Define the default route for accessing to element from WP Rest API	*/
	protected $base = 'digirisk/recommendation';
	protected $version = '0.1';

	public $element_prefix = 'PA';
	public $last_affectation_index_key = '_wpdigi_last_recommendation_affectation_unique_key';

	/**
	* Le constructeur
	*/
	protected function construct() {
		/**	Define taxonomy for recommendation	*/
		add_action( 'init', array( $this, 'recommendation_type' ), 0 );
	}

	/**
	* Déclares la taxonomy recommendation
	*/
	function recommendation_type() {
		$labels = array(
			'name'                       => _x( 'Recommendations', 'digirisk' ),
			'singular_name'              => _x( 'Recommendation', 'digirisk' ),
			'search_items'               => __( 'Search recommendations', 'digirisk' ),
			'popular_items'              => __( 'Popular recommendations', 'digirisk' ),
			'all_items'                  => __( 'All recommendations', 'digirisk' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit recommendation', 'digirisk' ),
			'update_item'                => __( 'Update recommendation', 'digirisk' ),
			'add_new_item'               => __( 'Add New recommendation', 'digirisk' ),
			'new_item_name'              => __( 'New recommendation Name', 'digirisk' ),
			'separate_items_with_commas' => __( 'Separate recommendations with commas', 'digirisk' ),
			'add_or_remove_items'        => __( 'Add or remove recommendations', 'digirisk' ),
			'choose_from_most_used'      => __( 'Choose from the most used recommendations', 'digirisk' ),
			'not_found'                  => __( 'No recommendations found.', 'digirisk' ),
			'menu_name'                  => __( 'Recommendations', 'digirisk' ),
		);

		$args = array(
			'hierarchical'          => true,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'recommendation' ),
			'update_count_callback' => '_update_generic_term_count',
		);

		register_taxonomy( $this->taxonomy, array( 'risk', 'societies' ), $args );

	}

	/**
	* Créer les données par défaut
	*/
	public function create_default_data() {
		$file_content = file_get_contents( RECOMMENDATION_PATH . 'asset/json/default.json' );
		$data = json_decode( $file_content );

		if ( !empty( $data ) ) {
			foreach ( $data as $json_recommendation_category ) {
				$unique_key = wpdigi_utils::get_last_unique_key( 'term', recommendation_category_class::get()->get_taxonomy() );
				$unique_key++;
				$unique_identifier = recommendation_category_class::get()->element_prefix . '' . $unique_key;
				$recommendation_category = recommendation_category_class::get()->create( array(
						'name' => $json_recommendation_category->name,
						'option' => array(
							'unique_key' => $unique_key,
							'unique_identifier' => $unique_identifier,
							'recommendation_category_print_option' => $json_recommendation_category->option->recommendation_category_print_option,
							'recommendation_category_option' => $json_recommendation_category->option->recommendation_print_option,
						),
				) );

				if ( is_wp_error( $recommendation_category ) && !empty( $recommendation_category->errors ) && !empty( $recommendation_category->errors['term_exists'] ) ) {
					$recommendation_category = $this->show( $recommendation_category->error_data['term_exists'] );
				}

				$file_id = wpdigi_utils::upload_file( WPDIGI_PATH . '/core/assets/images/preconisations/' . $json_recommendation_category->name_thumbnail, 0 );

				$recommendation_category->option['thumbnail_id'] = $file_id;
				$recommendation_category->option['associated_document_id'][] = $file_id;
				$recommendation_category = recommendation_category_class::get()->update( $recommendation_category );

				foreach( $json_recommendation_category->option->recommendation as $json_recommandation ) {
					$unique_key = wpdigi_utils::get_last_unique_key( 'term', $this->get_taxonomy() );
					$unique_key++;
					$unique_identifier = $this->element_prefix . '' . $unique_key;
					$recommandation = $this->create( array(
							'name' => $json_recommandation->name,
							'parent_id' => $recommendation_category->id,
							'option' => array(
								'unique_key' => $unique_key,
								'unique_identifier' => $unique_identifier,
								'type'	=> $json_recommandation->option->type,
							),
					) );

					if ( !is_wp_error( $recommandation ) ) {
						$file_id = wpdigi_utils::upload_file( WPDIGI_PATH . '/core/assets/images/preconisations/' . $json_recommandation->name_thumbnail, 0 );
						$recommandation->option['thumbnail_id'] = $file_id;
						$recommandation = $this->update( $recommandation );
					}
				}
			}
		}
	}

}

recommendation_class::get();
?>
