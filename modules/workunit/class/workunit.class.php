<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class workunit_class extends post_class {
	public $element_prefix = 'UT';
	protected $before_post_function = array( '\digi\construct_identifier' );
	protected $after_get_function = array( '\digi\get_identifier' );
	protected $model_name   = '\digi\workunit_model';
	protected $post_type    = 'digi-workunit';
	protected $meta_key    	= '_wp_workunit';
	protected $base = 'digirisk/workunit';
	protected $version = '0.1';

	protected function construct() {
		/**	Création des types d'éléments pour la gestion des entreprises / Create element types for societies management	*/

		/**	Create shortcodes for elements displaying	*/
		/**	Shortcode for displaying a dropdown with all groups	*/
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
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

		view_util::exec( 'workunit', 'list', array( 'editable_identity' => false, 'workunit_selected_id' => $workunit_selected_id, 'groupment_id' => $groupment_id, 'list_workunit' => $list_workunit ) );
	}
}
