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
class wpdigi_recommendation_ctr_01 extends term_ctr_01 {

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

	/* PRODEST:
	{
		"name": "__construct",
		"description": "Instanciation des outils pour la gestion des catégories de préconisation et les préconisations / Instanciate utilities for managing recommendation categories and recommendations",
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
		include_once( WPDIGI_RECOM_PATH . 'model/recommendation.model.01.php' );

		/**	Define taxonomy for recommendation	*/
		add_action( 'init', array( $this, 'recommendation_type' ), 0 );

		/**	Ajoute les onglets pour les unités de travail / Add tabs for workunit	*/
		add_filter( 'wpdigi_workunit_sheet_tab', array( $this, 'filter_add_sheet_tab_to_element' ), 6, 2 );
		/**	Ajoute le contenu pour les onglets des unités de travail / Add the content for workunit tabs	*/
		add_filter( 'wpdigi_workunit_sheet_content', array( $this, 'filter_display_recommendation_in_element' ), 10, 3 );
	}


	function filter_add_sheet_tab_to_element( $tab_list, $current_element ) {
		/** Définition de l'onglet permettant l'affichage des utilisateurs pour le type d'élément actuel / Define the tab allowing to display evaluators' tab for current element type	*/
		$tab_list = array_merge( $tab_list, array(
			'recommendation' => array(
				'text'	=> __( 'Recommendations', 'digirisk' ),
				'count' => 0,
			),
		)	);

		return $tab_list;
	}

	function filter_display_recommendation_in_element( $output, $element, $tab_to_display ) {
		global $digi_recommendation_category_controller;
		if ( 'recommendation' == $tab_to_display ) {
			ob_start();
			$list_recommendation_category = $digi_recommendation_category_controller->index();

			$list_recommendation_in_workunit = $element->option['associated_recommendation'];
			require_once( wpdigi_utils::get_template_part( WPDIGI_RECOM_DIR, DIGI_RECOM_TEMPLATES_MAIN_DIR, '', 'list' ) );
			$output .= ob_get_contents();
			ob_end_clean();
		}

		return $output;
	}

	/* PRODEST:
	{
		"name": "recommendation_type",
		"description": "Création du type d'élément interne a wordpress pour gérer les préconisations / Create wordpress element type for managing recommendations",
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

	public function create_default_data() {
		global $digi_recommendation_category_controller;

		$file_content = file_get_contents( WPDIGI_RECOM_PATH . 'asset/json/default.json' );
		$data = json_decode( $file_content );

		if ( !empty( $data ) ) {
			foreach ( $data as $json_recommendation_category ) {
				$unique_key = wpdigi_utils::get_last_unique_key( 'term', $digi_recommendation_category_controller->get_taxonomy() );
				$unique_key++;
				$unique_identifier = $digi_recommendation_category_controller->element_prefix . '' . $unique_key;
				$recommendation_category = $digi_recommendation_category_controller->create( array(
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
				$recommendation_category = $digi_recommendation_category_controller->update( $recommendation_category );

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

global $digi_recommendation_controller;
$digi_recommendation_controller = new wpdigi_recommendation_ctr_01();

?>
