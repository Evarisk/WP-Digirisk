<?php if ( !defined( 'ABSPATH' ) ) exit;

class accident_class extends post_class {

	protected $model_name   = 'accident_model';
	protected $post_type    = 'digi-accident';
	protected $meta_key    	= '_wpdigi_accident';

	/**	Défini la route par défaut permettant d'accèder aux sociétés depuis WP Rest API  / Define the default route for accessing to accident from WP Rest API	*/
	protected $base = 'digirisk/accident';
	protected $version = '0.1';

	protected $before_post_function = array( '\digi\construct_identifier' );
	protected $after_get_function = array( '\digi\get_identifier' );
	public $element_prefix = 'AC';

	protected $limit_accident = -1;

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	protected function construct() {}

	/**
	* Affiche la fenêtre principale
	*
	* @param int $society_id L'ID de la societé
	*/
	public function display( $society_id ) {
		$accident = $this->get( array( 'schema' => true ) );
		$accident = $accident[0];
		require( ACCIDENT_VIEW_DIR . 'main.view.php' );
	}

	/**
	 * DISPLAY - Génération de l'affichage des risques à partir d'un shortcode / Generate display for accidents through shortcode
	 *
	 * @param int $society_id L'ID de la societé
	 */
	public function display_accident_list( $society_id ) {
		$society = society_class::g()->show_by_type( $society_id );

		if ( $society->id === 0 ) {
			return false;
		}

		$accident_list = accident_class::g()->get( array( 'post_parent' => $society->id ), array( 'list_risk', 'evaluation', 'list_user' ) );

		require( ACCIDENT_VIEW_DIR . 'list.view.php' );
	}
}
