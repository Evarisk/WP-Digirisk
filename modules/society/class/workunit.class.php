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
class workunit_class extends post_class {

	public $element_prefix = 'UT';

	protected $model_name   = 'wpdigi_workunit_mdl_01';
	protected $post_type    = WPDIGI_STES_POSTTYPE_SUB;
	protected $meta_key    	= '_wp_workunit';

	/**	Défini la route par défaut permettant d'accèder aux sociétés depuis WP Rest API  / Define the default route for accessing to society from WP Rest API	*/
	protected $base = 'digirisk/workunit';
	protected $version = '0.1';

	private $current_workunit;

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	protected function construct() {
		/**	Inclusion du modèle pour les groupements / Include groups' model	*/
		include_once( WPDIGI_STES_PATH . '/model/workunit.model.01.php' );

		/**	Création des types d'éléments pour la gestion des entreprises / Create element types for societies management	*/
		add_action( 'init', array( &$this, 'custom_post_type' ), 5 );

		/**	Create shortcodes for elements displaying	*/
		/**	Shortcode for displaying a dropdown with all groups	*/
		add_shortcode( 'wpdigi-workunit-list', array( &$this, 'shortcode_workunit_list' ) );
	}

	/**
	 * SETTER - Création des types d'éléments pour la gestion de l'entreprise / Create the different element for society management
	 */
	function custom_post_type() {
		/**	Créé les sociétés: élément principal / Create society : main element 	*/
		$labels = array(
				'name'                => __( 'Work units', 'digirisk' ),
				'singular_name'       => __( 'Work unit', 'digirisk' ),
				'menu_name'           => __( 'Work units', 'digirisk' ),
				'name_admin_bar'      => __( 'Work units', 'digirisk' ),
				'parent_item_colon'   => __( 'Parent Item:', 'digirisk' ),
				'all_items'           => __( 'Work units', 'digirisk' ),
				'add_new_item'        => __( 'Add a work unit', 'digirisk' ),
				'add_new'             => __( 'Add a work unit', 'digirisk' ),
				'new_item'            => __( 'New a work unit', 'digirisk' ),
				'edit_item'           => __( 'Edit a work unit', 'digirisk' ),
				'update_item'         => __( 'Update a work unit', 'digirisk' ),
				'view_item'           => __( 'View a work unit', 'digirisk' ),
				'search_items'        => __( 'Search a work unit', 'digirisk' ),
				'not_found'           => __( 'Not found', 'digirisk' ),
				'not_found_in_trash'  => __( 'Not found in Trash', 'digirisk' ),
		);
		$rewrite = array(
				'slug'                => '/',
				'with_front'          => true,
				'pages'               => true,
				'feeds'               => true,
		);
		$args = array(
				'label'               => __( 'Digirisk work unit', 'digirisk' ),
				'description'         => __( 'Manage societies into digirisk', 'digirisk' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes', ),
				'hierarchical'        => true,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => false,
				'show_in_admin_bar'   => false,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => true,
				'publicly_queryable'  => true,
				'rewrite'             => $rewrite,
				'capability_type'     => 'page',
		);
		register_post_type( $this->post_type, $args );
	}

	/**
	 * ROUTES - Ajoute les routes spécifiques pour les unités de travail / Add workunit specific routes
	 *
	 * @param array $array_route Les routes existantes dans l'API REST de wordpress / Existing routes into Wordpress REST API
	 *
	 * @return array La liste des routes personnalisées ajoutées aux routes existantes / The personnalized routes added to existing
	 */
	public function callback_register_route( $array_route ) {
		$array_route = parent::callback_register_route( $array_route );

		$array_route['/' . $this->version . '/get/' . $this->base . '/(?P<id>\d+)/identity' ] = array(
				array( array( $this, 'get_workunit_identity' ), WP_JSON_Server::READABLE | WP_JSON_Server::ACCEPT_JSON )
		);

		return $array_route;
	}

	/**
	 * ROUTES - Récupération des informations principale d'une unité de travail / Get the main information about a workunit
	 *
	 * @param integer $id L'identifiant de l'unité de travail dont on veux récupèrer uniquement l'identité principale / Workunit identifier we want to get main identity for
	 */
	function get_workunit_identity( $id ) {
		global $wpdb;

		$query  = $wpdb->prepare(
				"SELECT P.post_title, P.post_modified, PM.meta_value AS _wpdigi_unique_identifier
				FROM {$wpdb->posts} AS P
				INNER JOIN {$wpdb->postmeta} AS PM ON ( PM.post_id = P.ID )
				WHERE P.ID = %d
				AND PM.meta_key = %s", $id, '_wpdigi_unique_identifier'
		);
		$work_unit = $wpdb->get_row( $query );

		return $work_unit;
	}

	/**
	 * Affiche la liste des groupements existant sous forme de liste déroulante si il en existe plusieurs / Display a dropdown with all groups if there are several existing
	 *
	 * @param array $args Les paramètres passés au travers du shortcode / Parameters list passed thrgough shortcode
	 *
	 * @return string Le code html permettant d'afficher la liste déroulante contenant les groupements existant / The HTML code allowing to display existing groups
	 */
	public function shortcode_workunit_list( $args ) {
		$output = '';

		/**	Get existing groups for display	*/
		$list = $this->index( array( 'posts_per_page' => -1, 'parent_id' => 0, 'post_status' => array( 'publish', ), 'post_parent' => $args[ 'group_id' ] ), false );

		/**	Define a nonce for display sheet using ajax	*/
		$workunit_display_nonce = wp_create_nonce( 'wpdigi_workunit_sheet_display' );

		/**	Affichage de la liste des unités de travail pour le groupement actuellement sélectionné / Display the work unit list for current selected group	*/
		ob_start();
		require_once( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'workunit', 'list' ) );
		$output = ob_get_contents();
		ob_end_clean();

		return  $output;
	}

	/**
	 * Affiche une fiche d'unité de travail à partir d'un identifiant donné / Display a work unit from given identifier
	 *
	 * @param integer $id L'indentifiant de l'unité de travail à afficher / The workunit identifier to display
	 * @param string $dislay_mode Optionnal Le mode d'affichage de la fiche (simple, complète, publique, ...) / The display mode (simple, complete, public, ... )
	 */
	public function display( $id, $dislay_mode = 'simple' ) {
		/**	Get the work unit to display	*/
		$this->current_workunit = $this->show( $id );
		$element_post_type = $this->get_post_type();

		/**	Set default tab in work unit - Allow modification throught filter	*/
		$workunit_default_tab = apply_filters( 'wpdigi_workunit_default_tab', '' );

		/**	Display the template	*/
		require_once( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'workunit', 'sheet', $dislay_mode ) );
	}

	function generate_workunit_sheet( $workunit_id ) {
		$response = array(
			'status' 	=> true,
			'message'	=> __( 'An error occured while getting element to generate sheet for.', 'digirisk' ),
			'link'		=> null,
		);

		$workunit = $this->show( $workunit_id );

		/**	Définition des détails de l'unité de travail a imprimer / Define workunit details for print	*/
		/**	Définition de la photo de l'unité de travail / Define workunit main picture	*/
		$picture = __( 'No picture defined', 'digirisk' );
		if ( !empty( $workunit->thumbnail_id ) && ( true === is_int( (int)$workunit->thumbnail_id ) ) ) {
			$picture_definition = wp_get_attachment_image_src( $workunit->thumbnail_id, 'digirisk-element-thumbnail' );
			$picture_final_path = str_replace( site_url( '/' ), ABSPATH, $picture_definition[ 0 ] );
			$picture = '';
			if ( is_file( $picture_final_path ) ) {
				$picture = array(
					'type'		=> 'picture',
					'value'		=> $picture_final_path,
					'option'	=> array(
						'size'	=> 8,
					),
				);
			}
		}

		/**	Définition des informations de l'adresse de l'unité de travail / Define informations about workunit address	*/
		$option[ 'address' ] = $option[ 'postcode' ] = $option[ 'town' ] = '-';
		if ( !empty( $workunit->option[ 'contact' ][ 'address' ] ) && ( true === is_int( (int)$workunit->option[ 'contact' ][ 'address' ] ) ) ) {
			$work_unit_address_definition = address_class::get()->show( (int)$workunit->option[ 'contact' ][ 'address' ][ 0 ] );
			extract( get_object_vars( $work_unit_address_definition ) );
		}

		/**	Définition finale de l'unité de travail / Final definition for workunit	*/
		$workunit_sheet_details = array(
			'referenceUnite'	=> $workunit->option[ 'unique_identifier' ],
			'nomUnite'			=> $workunit->title,
			'photoDefault'		=> $picture,
			'description'		=> $workunit->content,
			'adresse'			=> $option[ 'address' ],
			'codePostal'		=> $option[ 'postcode' ],
			'ville'				=> $option[ 'town' ],
			'telephone'			=> implode( ', ', $workunit->option[ 'contact' ][ 'phone' ] ),
		);

		/**	Ajout des utilisateurs dans le document final / Add affected users' into final document	*/
		$workunit_sheet_details[ 'utilisateursAffectes' ] = $workunit_sheet_details[ 'utilisateursDesaffectes' ] = array( 'type' => 'segment', 'value' => array(), );
		$affected_users = $unaffected_users = null;
		if ( !empty( $workunit->option[ 'user_info' ][ 'affected_id' ][ 'user' ] ) ) {
			$user_affectation_for_export = \digi\user_class::get()->build_list_for_document_export( $workunit->option[ 'user_info' ][ 'affected_id' ][ 'user' ] );
			if ( null !== $user_affectation_for_export ) {
				$workunit_sheet_details[ 'utilisateursAffectes' ] = array(
					'type'	=> 'segment',
					'value'	=> $user_affectation_for_export[ 'affected' ],
				);
				if ( !empty( $user_affectation_for_export[ 'unaffected' ] ) ) {
					$workunit_sheet_details[ 'utilisateursDesaffectes' ] = array(
						'type'	=> 'segment',
						'value'	=> $user_affectation_for_export[ 'unaffected' ],
					);
				}
			}
		}

		/**	Ajout des préconisations affectées a l'unité de travail / Add recommendation affected to workunit	*/
		$affected_recommendation = array( );
		$workunit_sheet_details[ 'affectedRecommandation' ] = array( 'type' => 'segment', 'value' => array(), );
		if ( !empty( $workunit->option[ 'associated_recommendation' ] ) ) {
			foreach ( $workunit->option[ 'associated_recommendation' ] as $recommendation_id => $recommendation_detail ) {
				foreach ( $recommendation_detail as $recommendation ) {
					if ( 'valid' == $recommendation[ 'status' ] ) {
						$the_recommendation = recommendation_class::get()->show( $recommendation_id );

						if ( !empty( $the_recommendation ) && !empty( $the_recommendation->parent_id ) ) {
							if ( empty( $affected_recommendation ) || empty( $affected_recommendation[ $the_recommendation->id ] ) ) {
								$the_recommendation_category = recommendation_category_class::get()->show( $the_recommendation->parent_id );

								$picture_definition = wp_get_attachment_image_src( $the_recommendation_category->option[ 'thumbnail_id' ], 'digirisk-element-thumbnail' );
								$picture_final_path = str_replace( site_url( '/' ), ABSPATH, $picture_definition[ 0 ] );
								$picture = '';
								if ( is_file( $picture_final_path ) ) {
									$picture = array(
										'type'		=> 'picture',
										'value'		=> $picture_final_path,
										'option'	=> array(
											'size'	=> 2,
										),
									);
								}
								$affected_recommendation[ $the_recommendation->id ] = array(
									'recommandationCategoryIcon' => $picture,
									'recommandationCategoryName' => $the_recommendation_category->name,
								);
							}

							$picture_definition = wp_get_attachment_image_src( $the_recommendation->option[ 'thumbnail_id' ], 'digirisk-element-thumbnail' );
							$picture_final_path = str_replace( site_url( '/' ), ABSPATH, $picture_definition[ 0 ] );
							$picture = '';
							if ( is_file( $picture_final_path ) ) {
								$picture = array(
									'type'		=> 'picture',
									'value'		=> $picture_final_path,
									'option'	=> array(
										'size'	=> 8,
									),
								);
							}
							$affected_recommendation[ $the_recommendation->id ][ 'recommandations' ][ 'type' ] = 'sub_segment';
							$affected_recommendation[ $the_recommendation->id ][ 'recommandations' ][ 'value' ][] = array(
								'identifiantRecommandation'	=> $recommendation[ 'unique_identifier' ],
								'recommandationIcon'		=> $picture,
								'recommandationName'		=> $the_recommendation->name,
								'recommandationComment'		=> $recommendation[ 'comment' ],
							);
						}
					}
				}
			}
		}
		$workunit_sheet_details[ 'affectedRecommandation' ] = array(
			'type'	=> 'segment',
			'value'	=> $affected_recommendation,
		);

		/**	Ajout des personnes présentes lors de l'évaluation dans le document final / Add users' who were present when evaluation have been done into final document	*/
		$workunit_sheet_details[ 'utilisateursPresents' ] = array( 'type' => 'segment', 'value' => array(), );
		$affected_users = $unaffected_users = null;
		if ( !empty( $workunit->option[ 'user_info' ][ 'affected_id' ][ 'evaluator' ] ) ) {
			/**	Récupération de la liste des personnes présentes lors de l'évaluation / Get list of user who were present for evaluation	*/
			$list_affected_evaluator = evaluator_class::get()->get_list_affected_evaluator( $workunit );
			if ( !empty( $list_affected_evaluator ) ) {
				foreach ( $list_affected_evaluator as $evaluator_id => $evaluator_affectation_info ) {
					foreach ( $evaluator_affectation_info as $evaluator_affectation_info ) {
						if ( 'valid' == $evaluator_affectation_info[ 'affectation_info' ][ 'status' ] ) {
							$affected_users[] = array(
								'idUtilisateur'			=> evaluator_class::get()->element_prefix . $evaluator_affectation_info[ 'user_info' ]->id,
								'nomUtilisateur'		=> $evaluator_affectation_info[ 'user_info' ]->option[ 'user_info' ][ 'lastname' ],
								'prenomUtilisateur'	=> $evaluator_affectation_info[ 'user_info' ]->option[ 'user_info' ][ 'firstname' ],
								'dateEntretien'			=> mysql2date( 'd/m/Y H:i', $evaluator_affectation_info[ 'affectation_info' ][ 'start' ][ 'date' ], true ),
								'dureeEntretien'		=> evaluator_class::get()->get_duration( $evaluator_affectation_info[ 'affectation_info' ] ),
							);
						}
					}
				}

				$workunit_sheet_details[ 'utilisateursPresents' ] = array(
					'type'	=> 'segment',
					'value'	=> $affected_users,
				);
			}
		}

		/**	Construction de l'affichage des risques dans la fiche imprimée / Build risks display into printed sheet	*/
		$workunit_sheet_details[ 'risq80' ] = $workunit_sheet_details[ 'risq51' ] = $workunit_sheet_details[ 'risq48' ] = $workunit_sheet_details[ 'risq' ] = array( 'type' => 'segment', 'value' => array(), );
		/**	On récupère la définition des risques associés à l'unité de travail / Get definition of risks associated to workunit	*/
		$risk_list = array();

		if ( !empty( $workunit->option[ 'associated_risk' ] ) ) {
			$risk_list = risk_class::get()->index( array(
				'include' => $workunit->option[ 'associated_risk' ],
			) );
		}

		$risk_list_to_order = array();
		foreach ( $risk_list as $risk ) {
			$complete_risk = risk_class::get()->get_risk( $risk->id );
			$comment_list = '';
			if ( !empty( $complete_risk->comment ) ) :
				foreach ( $complete_risk->comment as $comment ) :
					$comment_list .= mysql2date( 'd/m/y H:i', $comment->date ) . ' : ' . $comment->content . "
";
				endforeach;
			endif;

			$risk_list_to_order[ $complete_risk->evaluation->option[ 'risk_level' ][ 'scale' ] ][] = array(
				'nomDanger'			=> $complete_risk->danger->name,
				'identifiantRisque'	=> $risk->option[ 'unique_identifier' ] . '-' . $complete_risk->evaluation->option[ 'unique_identifier' ],
				'quotationRisque'	=> $complete_risk->evaluation->option[ 'risk_level' ][ 'equivalence' ],
				'commentaireRisque'	=> $comment_list,
			);
		}
		krsort( $risk_list_to_order );

		if ( !empty( $risk_list_to_order ) ) {
			foreach ( $risk_list_to_order as $risk_level => $risk_for_export ) {
				$final_level = scale_util::get_scale( $risk_for_export[ 'niveauRisque' ] );

				$workunit_sheet_details[ 'risq' . $final_level ][ 'value' ] = $risk_for_export;
			}
		}

		/**	Call document creation function / Appel de la fonction de création du document	*/
		$document_creation_response = document_class::get()->create_document( $workunit, array( 'fiche_de_poste' ), $workunit_sheet_details );
		if ( !empty( $document_creation_response[ 'id' ] ) ) {
			$workunit->option[ 'associated_document_id' ][ 'document' ][] = $document_creation_response[ 'id' ];
			$workunit = $this->update( $workunit );
			$workunit = $this->show( $workunit->id );
		}

		return $document_creation_response;
	}

}
