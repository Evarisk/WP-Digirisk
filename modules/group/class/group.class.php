<?php if ( !defined( 'ABSPATH' ) ) exit;

class group_class extends post_class {

	protected $model_name   				= 'group_model';
	protected $post_type    				= 'digi-group';
	protected $meta_key    					= '_wpdigi_society';
	public $element_prefix 					= 'GP';
	protected $before_post_function = array( 'construct_identifier', 'convert_date' );
	protected $after_get_function = array( 'order_risk', 'get_identifier' );

	/**
	 * Constructeur
	 */
	protected function construct() {
		add_action( 'init', array( $this, 'custom_post_type' ), 5 );
	}

	/**
	 * SETTER - Création des types d'éléments pour la gestion de l'entreprise / Create the different element for society management
	 */
	function custom_post_type() {
		/**	Créé les sociétés: élément principal / Create society : main element 	*/
		$labels = array(
			'name'                => __( 'Societies', 'digirisk' ),
			'singular_name'       => __( 'Society', 'digirisk' ),
			'menu_name'           => __( 'Societies', 'digirisk' ),
			'name_admin_bar'      => __( 'Societies', 'digirisk' ),
			'parent_item_colon'   => __( 'Parent Item:', 'digirisk' ),
			'all_items'           => __( 'Societies', 'digirisk' ),
			'add_new_item'        => __( 'Add society', 'digirisk' ),
			'add_new'             => __( 'Add society', 'digirisk' ),
			'new_item'            => __( 'New society', 'digirisk' ),
			'edit_item'           => __( 'Edit society', 'digirisk' ),
			'update_item'         => __( 'Update society', 'digirisk' ),
			'view_item'           => __( 'View society', 'digirisk' ),
			'search_items'        => __( 'Search society', 'digirisk' ),
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
			'label'               => __( 'Digirisk society', 'digirisk' ),
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
	 * AFFICHAGE/DISPLAY - Affichage du bouton toggle
	 */
	public function display_toggle( $list_groupment, $selected_group = null ) {
		if ( $selected_group === null ) {
			$selected_group = $list_groupment[0];
		}

		require ( GROUP_VIEW_DIR . '/toggle.view.php' );
	}
	/**
	* Affiche un groupement
	*
	* @param int $group_id L'ID du groupement
	*/
	public function display( $group_id ) {
		$element = $this->show( $group_id );

		require ( SOCIETY_VIEW_DIR . '/content.view.php' );
	}

	public function display_list_item( $list_groupment, $selected_group = null ) {
		if ( $selected_group === null ) {
			$selected_group = $list_groupment[0];
		}

		require ( GROUP_VIEW_DIR . '/list.view.php' );
	}
	/**
	 * Construction du tableau contenant les risques pour l'arborescence complète du premier élément demandé / Build an array with all risks for element and element's subtree
	 *
	 * @param object $element L'élément actuel dont il faut récupérer la liste des risques de manière récursive / Current element where we have to get risk list recursively
	 *
	 * @return array Les risques pour l'arborescence complète non ordonnées mais construits de façon pour l'export / Unordered risks list for complete tree, already formatted for export
	 */
	public function get_element_tree_risk( $element ) {
		// if ( !is_object( $element ) ) {
		// 	return false;
		// }

		$risks_in_tree = array();

		$risks_in_tree = $this->build_risk_list_for_export( $element );

		/**	Liste les enfants direct de l'élément / List children of current element	*/
		$group_list = group_class::g()->get( array( 'posts_per_page' => -1, 'post_parent' => $element->id, 'post_status' => array( 'publish', 'draft', ), ), false );
		foreach ( $group_list as $group ) {
			$risks_in_tree = array_merge( $risks_in_tree, $this->get_element_tree_risk( $group ) );
		}

		$work_unit_list = workunit_class::g()->get( array( 'posts_per_page' => -1, 'post_parent' => $element->id, 'post_status' => array( 'publish', 'draft', ), ), false );
		foreach ( $work_unit_list as $workunit ) {
			$risks_in_tree = array_merge( $risks_in_tree, $this->build_risk_list_for_export( $workunit ) );
		}

		return $risks_in_tree;
	}

	/**
	* Récupères les elements enfants
	*
	* @param object $element L'élement parent
	* @param string $tabulation ?
	* @param array extra_params ?
	*/
	public function get_element_sub_tree( $element, $tabulation = '', $extra_params = null ) {
		if ( !is_object( $element ) ) {
			return array();
		}

		$element_children = array();
		$element_tree = '';

		$element_children[ $element->unique_identifier ] = array( 'nomElement' => $tabulation . ' ' . $element->unique_identifier . ' - ' . $element->title, ) ;
		if ( !empty( $extra_params ) ) {
			if ( !empty( $extra_params[ 'default' ] ) ) {
				$element_children[ $element->unique_identifier ] = wp_parse_args( $extra_params[ 'default' ], $element_children[ $element->unique_identifier ] );
			}
			if ( !empty( $extra_params[ 'value' ] ) &&  array_key_exists( $element->unique_identifier, $extra_params[ 'value' ] ) ) {
				$element_children[ $element->unique_identifier ] = wp_parse_args( $extra_params[ 'value' ][ $element->unique_identifier ], $element_children[ $element->unique_identifier ] );
			}
		}
		/**	Liste les enfants direct de l'élément / List children of current element	*/
		$group_list = group_class::g()->get( array( 'posts_per_page' => -1, 'post_parent' => $element->id , 'post_status' => array( 'publish', 'draft', ), ), false );
		foreach ( $group_list as $group ) {
			$element_children = array_merge( $element_children, $this->get_element_sub_tree( $group, $tabulation . '-', $extra_params ) );
		}

		$tabulation = $tabulation . '-';
		$work_unit_list = workunit_class::g()->get( array( 'posts_per_page' => -1, 'post_parent' => $element->id, 'post_status' => array( 'publish', 'draft', ), ), false );
		foreach ( $work_unit_list as $workunit ) {
			$workunit_definition[ $workunit->unique_identifier ] = array( 'nomElement' => $tabulation . ' ' . $workunit->unique_identifier . ' - ' . $workunit->title, );

			if ( !empty( $extra_params ) ) {
				if ( !empty( $extra_params[ 'default' ] ) ) {
					$workunit_definition[ $workunit->unique_identifier ] = wp_parse_args( $extra_params[ 'default' ], $workunit_definition[ $workunit->unique_identifier ] );
				}
				if ( !empty( $extra_params[ 'value' ] ) &&  array_key_exists( $workunit->unique_identifier, $extra_params[ 'value' ] ) ) {
					$workunit_definition[ $workunit->unique_identifier ] = wp_parse_args( $extra_params[ 'value' ][ $workunit->unique_identifier ], $workunit_definition[ $workunit->unique_identifier ] );
				}
			}
			$element_children = array_merge( $element_children, $workunit_definition );
		}

		return $element_children;
	}

	/**
	* Récupères l'id des elements enfants
	*
	* @param int $element_id L'ID de l'élement parent
	* @param array $list_id La liste des ID
	*/
	public function get_element_sub_tree_id( $element_id, $list_id ) {
		$group_list = group_class::g()->get( array( 'posts_per_page' => -1, 'post_parent' => $element_id , 'post_status' => array( 'publish', 'draft', ), ), false );
		if( !empty( $group_list ) ) {
			foreach ( $group_list as $group ) {
				$list_id[] = array( 'id' => $group->id, 'workunit' => array() );
				// $list_id[count($list_id) - 1] = array();
				// $list_id[count($list_id) - 1]['workunit'] = array();
				$work_unit_list = workunit_class::g()->get( array( 'posts_per_page' => -1, 'post_parent' => $group->id, 'post_status' => array( 'publish', 'draft', ), ), false );
				foreach ( $work_unit_list as $workunit ) {
					$list_id[count($list_id) - 1]['workunit'][]['id'] = $workunit->id;
				}
				$list_id = $this->get_element_sub_tree_id( $group->id, $list_id );
			}
		}
		else {
			$work_unit_list = workunit_class::g()->get( array( 'posts_per_page' => -1, 'post_parent' => $element_id, 'post_status' => array( 'publish', 'draft', ), ), false );
			foreach ( $work_unit_list as $workunit ) {
				// $list_id[count($list_id) - 1 == -1 ? 0 : count($list_id) - 1]['workunit'][]['id'] = $workunit->id;
			}
		}


		return $list_id;
	}

	/**
	 * Construction de la liste des risques pour un élément donné / Build risks' list for a given element
	 *
	 * @param object $element La définition complète de l'élément dont il faut retourner la liste des risques / The entire element we want to get risks list for
	 *
	 * @return array La liste des risques construite pour l'export / Risks' list builded for export
	 */
	public function build_risk_list_for_export( $element ) {
		// if ( empty( $element->option[ 'associated_risk' ] ) )
		// 	return array();

		$risk_list = risk_class::g()->get( array( 'post_parent' => $element->id ), array () );
		$element_duer_details = array();
		foreach ( $risk_list as $risk ) {
			$comment_list = '';
			if ( !empty( $risk->comment ) ) :
				foreach ( $risk->comment as $comment ) :
					$comment_list .= mysql2date( 'd/m/y H:i', $comment->date ) . ' : ' . $comment->content . "
";
				endforeach;
			endif;

			$element_duer_details[] = array(
				'idElement'					=> $element->unique_identifier,
				'nomElement'				=> $element->unique_identifier. ' - ' . $element->title,
				'identifiantRisque'	=> $risk->unique_identifier . '-' . $risk->evaluation[0]->unique_identifier,
				'quotationRisque'		=> $risk->evaluation[0]->risk_level[ 'equivalence' ],
				'niveauRisque'			=> $risk->evaluation[0]->scale,
				'nomDanger'					=> $risk->danger_category[0]->danger[0]->name,
				'commentaireRisque'	=> $comment_list,
				'actionPrevention'	=> ''
			);
		}

		if ( !empty( $risk_list_to_order ) ) {
			foreach ( $risk_list_to_order as $risk_level => $risk_for_export ) {
				$final_level = !empty( evaluation_method_class::g()->list_scale[$risk_level] ) ? evaluation_method_class::g()->list_scale[$risk_level] : '';
				$element_duer_details[ 'risq' . $final_level ][ 'value' ] = $risk_for_export;
				$element_duer_details[ 'risqPA' . $final_level ][ 'value' ] = $risk_for_export;
			}
		}

		return $element_duer_details;
	}
}
