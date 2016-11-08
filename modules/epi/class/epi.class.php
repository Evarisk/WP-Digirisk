<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

class EPI_Class extends post_class {

	protected $model_name   = '\digi\epi_model';
	protected $post_type    = 'digi-epi';
	protected $meta_key    	= '_wpdigi_epi';

	/**	Défini la route par défaut permettant d'accèder aux sociétés depuis WP Rest API  / Define the default route for accessing to epi from WP Rest API	*/
	protected $base = 'digirisk/epi';
	protected $version = '0.1';

	protected $before_post_function = array( '\digi\construct_identifier' );
	protected $after_get_function = array( '\digi\get_identifier', '\digi\update_remaining_time' );
	public $element_prefix = 'EPI';

	protected $limit_epi = -1;

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	protected function construct() {
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}

	/**
	* Affiche la fenêtre principale
	*
	* @param int $society_id L'ID de la societé
	*/
	public function display( $society_id ) {
		$epi = $this->get( array( 'schema' => true ) );
		$epi = $epi[0];
		view_util::exec( 'epi', 'main', array( 'society_id' => $society_id, 'epi' => $epi ) );
	}

	/**
	 * DISPLAY - Génération de l'affichage des risques à partir d'un shortcode / Generate display for epis through shortcode
	 *
	 * @param int $society_id L'ID de la societé
	 */
	public function display_epi_list( $society_id ) {
		$society = society_class::g()->show_by_type( $society_id );

		if ( $society->id === 0 ) {
			return false;
		}

		$epi_list = epi_class::g()->get( array( 'post_parent' => $society->id ), array( false ) );

		view_util::exec( 'epi', 'list', array( 'society_id' => $society_id, 'epi_list' => $epi_list ) );
	}
}
EPI_Class::g();
