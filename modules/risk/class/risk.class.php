<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;
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
class risk_class extends post_class {

	protected $model_name   = '\digi\risk_model';
	protected $post_type    = 'digi-risk';
	protected $meta_key    	= '_wpdigi_risk';
	protected $before_post_function = array( '\digi\construct_identifier' );
	protected $after_get_function = array( '\digi\get_identifier' );

	/**	Défini la route par défaut permettant d'accèder aux sociétés depuis WP Rest API  / Define the default route for accessing to risk from WP Rest API	*/
	protected $base = 'digirisk/risk';
	protected $version = '0.1';

	public $element_prefix = 'R';

	protected $limit_risk = -1;

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	protected function construct() {
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
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}

	/**
	* Affiche la fenêtre principale
	*
	* @param int $society_id L'ID de la societé
	*/
	public function display( $society_id ) {
		$risk = $this->get( array( 'schema' => true ), array( 'comment', 'evaluation_method', 'evaluation', 'danger_category', 'danger' ) );
		$risk = $risk[0];
		view_util::exec( 'risk', 'main', array( 'society_id' => $society_id, 'risk' => $risk ) );
	}

	public function display_risk_list( $society_id ) {
		$risk_list = risk_class::g()->get( array( 'post_parent' => $society_id, 'posts_per_page' => -1 ), array( 'comment', 'evaluation_method', 'evaluation', 'danger_category', 'danger' ) );

		if ( count( $risk_list ) > 1 ) {
			usort( $risk_list, function( $a, $b ) {
				if( $a->evaluation[0]->risk_level['equivalence'] == $b->evaluation[0]->risk_level['equivalence'] ) {
					return 0;
				}
				return ( $a->evaluation[0]->risk_level['equivalence'] > $b->evaluation[0]->risk_level['equivalence'] ) ? -1 : 1;
			} );
		}

		view_util::exec( 'risk', 'list', array( 'society_id' => $society_id, 'risk_list' => $risk_list ) );
	}
}
