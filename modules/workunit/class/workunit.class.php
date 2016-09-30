<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class workunit_class extends post_class {
	public $element_prefix = 'UT';
	protected $before_post_function = array( '\digi\construct_identifier' );
	protected $after_get_function = array( '\digi\get_identifier' );
	protected $model_name   = 'workunit_model';
	protected $post_type    = 'digi-workunit';
	protected $meta_key    	= '_wp_workunit';
	protected $base = 'digirisk/workunit';
	protected $version = '0.1';

	protected function construct() {
		/**	Création des types d'éléments pour la gestion des entreprises / Create element types for societies management	*/

		/**	Create shortcodes for elements displaying	*/
		/**	Shortcode for displaying a dropdown with all groups	*/
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

	// /**
	//  * Affiche une fiche d'unité de travail à partir d'un identifiant donné / Display a work unit from given identifier
	//  *
	//  * @param integer $id L'indentifiant de l'unité de travail à afficher / The workunit identifier to display
	//  * @param string $dislay_mode Optionnal Le mode d'affichage de la fiche (simple, complète, publique, ...) / The display mode (simple, complete, public, ... )
	//  */
	// public function display( $id, $display_mode = 'simple' ) {
	// 	if ( !is_int( $id ) || !is_string( $display_mode ) ) {
	// 		return false;
	// 	}
	//
	// 	/**	Get the work unit to display	*/
	// 	$this->current_workunit = $this->show( $id );
	// 	$element_post_type = $this->get_post_type();
	//
	// 	/**	Set default tab in work unit - Allow modification throught filter	*/
	// 	$workunit_default_tab = apply_filters( 'wpdigi_workunit_default_tab', '' );
	//
	// 	/**	Display the template	*/
	// 	$path = wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'workunit', 'sheet', $display_mode );
	//
	// 	if ( $path ) {
	// 		require_once( wpdigi_utils::get_template_part( WPDIGI_STES_DIR, WPDIGI_STES_TEMPLATES_MAIN_DIR, 'workunit', 'sheet', $display_mode ) );
	// 	}
	// }

	public function display_list( $groupment_id, $workunit_selected_id = 0 ) {
		$list_workunit = workunit_class::g()->get( array( 'post_parent' => $groupment_id, 'posts_per_page' => -1 ), array( false ) );

		if ( count( $list_workunit ) > 1 ) {
			usort( $list_workunit, function( $a, $b ) {
				if( $a->unique_key == $b->unique_key ) {
					return 0;
				}
				return ( $a->unique_key < $b->unique_key ) ? -1 : 1;
			} );
		}

		view_util::exec( 'workunit', 'list', array( 'groupment_id' => $groupment_id, 'list_workunit' => $list_workunit ) );
	}
}
