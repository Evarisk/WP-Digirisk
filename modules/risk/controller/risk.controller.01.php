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
class wpdigi_risk_ctr_01 extends post_ctr_01 {

	protected $model_name   = 'wpdigi_risk_mdl_01';
	protected $post_type    = 'digi-risk';
	protected $meta_key    	= '_wpdigi_risk';

	/**	Défini la route par défaut permettant d'accèder aux sociétés depuis WP Rest API  / Define the default route for accessing to risk from WP Rest API	*/
	protected $base = 'digirisk/risk';
	protected $version = '0.1';

	public $element_prefix = 'R';

	protected $limit_risk = -1;

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	function __construct() {
		parent::__construct();

		/**	Inclusion du modèle pour les groupements / Include groups' model	*/
		include_once( WPDIGI_RISKS_PATH . '/model/risk.model.01.php' );

		/**	Création des types d'éléments pour la gestion des entreprises / Create element types for risks management	*/
		add_action( 'init', array( &$this, 'custom_post_type' ), 5 );

		/**	Définition d'un shortcode permettant d'afficher les risques associés à un élément / Define a shortcode allowing to display risk associated to a given element 	*/
		add_shortcode( 'risk', array( $this, 'risk_shortcode' ) );

		/**	Ajoute les onglets pour les unités de travail / Add tabs for workunit	*/
		add_filter( 'wpdigi_workunit_sheet_tab', array( $this, 'filter_add_sheet_tab_to_element' ), 5, 2 );
		/**	Ajoute le contenu pour les onglets des unités de travail / Add the content for workunit tabs	*/
		add_filter( 'wpdigi_workunit_sheet_content', array( $this, 'filter_display_risk_in_element' ), 10, 3 );

		/**	Ajoute les onglets pour les unités de travail / Add tabs for workunit	*/
		add_filter( 'wpdigi_group_sheet_tab', array( $this, 'filter_add_sheet_tab_to_element' ), 5, 2 );
		/**	Ajoute le contenu pour les onglets des unités de travail / Add the content for group tabs	*/
		add_filter( 'wpdigi_group_sheet_content', array( $this, 'filter_display_risk_in_element' ), 10, 3 );
	}

	/**
	 * SETTER - Création des types d'éléments pour la gestion de l'entreprise / Create the different element for risk management
	 */
	function custom_post_type() {
		/**	Créé les sociétés: élément principal / Create risk : main element 	*/
		$labels = array(
			'name'                => __( 'Risks', 'wpdigi-i18n' ),
			'singular_name'       => __( 'Risk', 'wpdigi-i18n' ),
			'menu_name'           => __( 'Risks', 'wpdigi-i18n' ),
			'name_admin_bar'      => __( 'Risks', 'wpdigi-i18n' ),
			'parent_item_colon'   => __( 'Parent Item:', 'wpdigi-i18n' ),
			'all_items'           => __( 'Risks', 'wpdigi-i18n' ),
			'add_new_item'        => __( 'Add risk', 'wpdigi-i18n' ),
			'add_new'             => __( 'Add risk', 'wpdigi-i18n' ),
			'new_item'            => __( 'New risk', 'wpdigi-i18n' ),
			'edit_item'           => __( 'Edit risk', 'wpdigi-i18n' ),
			'update_item'         => __( 'Update risk', 'wpdigi-i18n' ),
			'view_item'           => __( 'View risk', 'wpdigi-i18n' ),
			'search_items'        => __( 'Search risk', 'wpdigi-i18n' ),
			'not_found'           => __( 'Not found', 'wpdigi-i18n' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'wpdigi-i18n' ),
		);
		$rewrite = array(
			'slug'                => '/',
			'with_front'          => true,
			'pages'               => true,
			'feeds'               => true,
		);
		$args = array(
			'label'               => __( 'Digirisk risk', 'wpdigi-i18n' ),
			'description'         => __( 'Manage risks into digirisk', 'wpdigi-i18n' ),
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
	 * DISPLAY - Génération de l'affichage des risques à partir d'un shortcode / Generate display for risks through shortcode
	 *
	 * @param array $args La liste des paramètres passées au shortcode / The parameter list passed to shortcode
	 */
	function display_risk_list( $element ) {

		if ( empty( $element ) )
			return false;

		global $wpdigi_evaluation_method_controller;

		$current_page = !empty( $_GET['current_page'] ) ? (int)$_GET['current_page'] : 1;
		$number_page = ceil( count ( $element->option['associated_risk'] ) ) / $this->limit_risk;

		$list_risk_id = $element->option['associated_risk'];
		if ( $this->limit_risk != -1 ) $list_risk_id = array_slice( $element->option['associated_risk'], ( ( $current_page - 1 ) * $this->limit_risk ), $this->limit_risk );

		/** Chargements de tous les risques pour ensuite les trier */
		$list_risk = array();
		foreach ( $list_risk_id as $risk_id ) {
			$risk_def = $this->get_risk( $risk_id );
			if ( 'publish' == $risk_def->status ) {
				$list_risk[] = $risk_def;
			}
		}

		if ( count( $list_risk ) > 1 ) {
			usort( $list_risk, function( $a, $b ) {
				if( $a->evaluation->option[ 'risk_level' ][ 'equivalence' ] == $b->evaluation->option[ 'risk_level' ][ 'equivalence' ] ) {
					return 0;
				}

				return ( $a->evaluation->option[ 'risk_level' ][ 'equivalence' ] > $b->evaluation->option[ 'risk_level' ][ 'equivalence' ] ) ? -1 : 1;
			} );
		}

		$term_evarisk_simple = get_term_by( 'slug', 'evarisk-simplified', $wpdigi_evaluation_method_controller->get_taxonomy() );

		/** Le tableau de la méthode d'évaluation evarisk */
		global $wpdigi_evaluation_method_variable_controller;
		$term_evarisk = get_term_by( 'slug', 'evarisk', $wpdigi_evaluation_method_controller->get_taxonomy() );

		if ( !empty( $term_evarisk ) ) {
			$evarisk_evaluation_method = $wpdigi_evaluation_method_controller->show( $term_evarisk->term_id );
			$list_evaluation_method_variable = array();

			if ( !empty( $evarisk_evaluation_method->option['formula'] ) ) {
				foreach ( $evarisk_evaluation_method->option['formula'] as $key => $formula ) {
					if ( $key % 2 == 0 ) {
						$list_evaluation_method_variable[] = $wpdigi_evaluation_method_variable_controller->show( $formula );
					}
				}
			}
		}

		require_once( wpdigi_utils::get_template_part( WPDIGI_RISKS_DIR, WPDIGI_RISKS_TEMPLATES_MAIN_DIR, 'simple', 'list' ) );
	}

	/**
	 * GETTER - Récupération d'un risque avec toutes les données associés déjà construite / Get a complete risk definition
	 *
	 * @param integer $id L'identifiant du risque qu'il faut récupèrer / The risk identifier to get
	 *
	 * @return object Le risque complet / The complete risk
	 */
	public function get_risk( $id ) {
		/**	Récupération du risque / Get the risk définition	*/
		if ( $id != 0 ) {
			$risk = $this->show( $id );

			/**	Récupération de la méthode associée au risque / Get associated method to risk	*/
			global $wpdigi_evaluation_method_controller;
			$risk->method = $wpdigi_evaluation_method_controller->show( $risk->taxonomy[ 'digi-method' ][ 0 ] );

			/**	Récupération du danger associé au risque / Get the danger associated to risk	*/
			global $wpdigi_danger_ctr;
			$risk->danger = $wpdigi_danger_ctr->show( $risk->taxonomy[ 'digi-danger' ][ 0 ] );

			/**	Récupération de l'évaluation courante / Get the current evalation	*/
			global $wpdigi_risk_evaluation_ctr;
			$risk->evaluation = $wpdigi_risk_evaluation_ctr->show( $risk->option[ 'current_evaluation_id' ] );

			/**	Récupération des commentaires associés au risque / Get the comment associated to risk	*/
			global $wpdigi_risk_evaluation_comment_ctr;
			$risk->comment = $wpdigi_risk_evaluation_comment_ctr->index( $id, array( 'status' => -34070, ), false);

			/**	On retourne la définition du risque complet / Return the complete risk definition	*/
			return $risk;
		}
		return null;
	}

	/**
	 * Filtrage de la définition des onglets dans les fiches d'un élément / Hook filter allowing to extend tabs into an element sheet
	 *
	 * @param array $tab_list La liste actuelle des onglets à afficher dans la fiche de l'élément / The current tab list to display into element sheet
	 *
	 * @return array Le tableau des onglets a afficher dans la fiche de l'élément avec les onglets spécifiques ajoutés / The tab array to display into element sheet with specific tabs added
	 */
	function filter_add_sheet_tab_to_element( $tab_list, $current_element ) {
		/** Définition de l'onglet permettant l'affichage des risques pour le type d'élément actuel / Define the tab allowing to display risks' tab for current element type	*/
		$tab_list = array_merge( $tab_list, array(
			$this->get_post_type() => array(
				'text'	=> __( 'Risks', 'wpdigi-i18n' ),
				'count' => count( $current_element->option[ 'associated_risk' ] ),
			),
		)	);

		return $tab_list;
	}

	/**
	 * Filtrage de l'affichage des risques dans la fiche d'un élément (unité de travail/groupement/etc) / Filter risks' display into a element sheet
	 *
	 * @param string $output Le contenu actuel a afficher, contenu que l'on va agrémenter / The current content to update before return and display
	 * @param JSon_Object $element L'élément sur le quel on se trouve et pour lequel on veut afficher les risques / Current element we are on and we want to display risks' for
	 * @param string $tab_to_display L'onglet sur lequel on se trouve actuellement défini par le filtre principal ( wpdigi-workunit-default-tab ) puis par l'ajax / Current tab we are on defined par main filter ( wpdigi-workunit-default-tab ) and then by ajax
	 *
	 * @return string Le contenu a afficher pour l'onglet et l'élément actuel / The content to display for current tab and element we are one
	 */
	function filter_display_risk_in_element( $output, $element, $tab_to_display ) {
		if ( $this->get_post_type() == $tab_to_display ) {
			ob_start();

			$this->display_risk_list( $element );
			$output .= ob_get_contents();
			ob_end_clean();
		}

		return $output;
	}

	/**
	 * Get the risk list for an element directly from database / Récupère la liste des risques pour un element dans la base de données
	 *
	 * @param Object $element The element we need to get risk list for / L'élément pour lequel il faut récupèrer la liste des risques
	 *
	 * @return WP_Query Risk list for given element / La liste des risques pour l'élément donné en paramètre
	 */
	function get_risk_list_for_element( $element ) {
		$risk_for_element = array();

		/**	Define risks list args / Définition des arguments de récupération de la liste des risques	*/
		$risk_list_args = array(
			'post_type'			=> $this->post_type,
			'post_per_pages'	=> -1,
			'post_parent'		=> $element->id,
		);
		$risk_list = new WP_Query( $risk_list_args );

		if ( $risk_list->have_posts() ) {
			$risk_id_list = array();
			foreach ( $risk_list->posts as $risk ) {
				$risk_id_list[] = $risk->ID;
			}
			$risk_for_element = $this->index( array( 'include' => $risk_id_list, ) );
		}

		return $risk_for_element;
	}

}

/**	Création de l'objet risque / Create the risk object	*/
global $wpdigi_risk_ctr;
$wpdigi_risk_ctr = new wpdigi_risk_ctr_01();
