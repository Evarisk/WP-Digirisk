<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class group_class extends post_class {

	protected $model_name   				= '\digi\group_model';
	protected $post_type    				= 'digi-group';
	protected $meta_key    					= '_wpdigi_society';
	public $element_prefix 					= 'GP';
	protected $before_post_function = array( '\digi\construct_identifier', '\digi\convert_date' );
	protected $after_get_function = array( '\digi\get_identifier' );

	/**
	 * Constructeur
	 */
	protected function construct() {}


	/**
	 * AFFICHAGE/DISPLAY - Affichage du bouton toggle
	 */
	public function display_toggle( $list_groupment, $selected_group = null ) {
		if ( $selected_group === null ) {
			$selected_group = $list_groupment[0];
		}

		view_util::exec( 'group', 'toggle', array( 'list_groupment' => $list_groupment, 'selected_group' => $selected_group ) );
	}
	/**
	* Affiche un groupement
	*
	* @param int $group_id L'ID du groupement
	*/
	public function display( $group_id ) {
		$element = $this->show( $group_id );

		view_util::exec( 'society', 'content' );
	}

	public function display_list_item( $list_groupment, $selected_group = null ) {
		if ( $selected_group === null ) {
			$selected_group = $list_groupment[0];
		}

		view_util::exec( 'group', 'list', array( 'list_groupment' => $list_groupment, 'selected_group' => $selected_group ) );
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
