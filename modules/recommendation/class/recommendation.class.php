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
class recommendation_class extends post_class {

	protected $model_name   = '\digi\recommendation_model';
	protected $post_type    = 'digi-recommendation';
	protected $meta_key    	= '_wpdigi_recommendation';
	protected $before_post_function = array( '\digi\construct_identifier' );
	protected $after_get_function = array( '\digi\get_identifier' );

	/**	Défini la route par défaut permettant d'accèder aux sociétés depuis WP Rest API  / Define the default route for accessing to risk from WP Rest API	*/
	protected $base = 'digirisk/recommendation';
	protected $version = '0.1';

	public $element_prefix = 'RE';

	protected $limit_recommendation = -1;

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	protected function construct() {
		/**	Définition d'un shortcode permettant d'afficher les risques associés à un élément / Define a shortcode allowing to display risk associated to a given element 	*/
		add_shortcode( 'risk', array( $this, 'risk_shortcode' ) );
	}

	public function display( $society_id ) {
		$recommendation = $this->get( array( 'schema' => true ) );
		$recommendation = $recommendation[0];
		$index = 0;
		view_util::exec( 'recommendation', 'main', array( 'society_id' => $society_id, 'recommendation' => $recommendation, 'index' => $index ) );
	}

	public function display_recommendation_list( $society_id ) {
		$recommendation_list = recommendation_class::g()->get( array( 'post_parent' => $society_id, 'posts_per_page' => -1 ) );
		
		view_util::exec( 'recommendation', 'list', array( 'society_id' => $society_id, 'recommendation_list' => $recommendation_list ) );
	}
}
