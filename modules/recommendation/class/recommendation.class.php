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

	public $element_prefix = 'PA';

	protected $limit_recommendation = -1;

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Recommandations';

	/**
	 * Instanciation principale de l'extension / Plugin instanciation
	 */
	protected function construct() {
		parent::construct();
		/**	Définition d'un shortcode permettant d'afficher les risques associés à un élément / Define a shortcode allowing to display risk associated to a given element 	*/
		add_shortcode( 'risk', array( $this, 'risk_shortcode' ) );

		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}

	public function display( $society_id ) {
		$recommendation = $this->get( array( 'schema' => true ) );
		$recommendation = $recommendation[0];
		$index = 0;
		view_util::exec( 'recommendation', 'main', array( 'society_id' => $society_id, 'recommendation' => $recommendation, 'index' => $index ) );
	}

	public function display_recommendation_list( $society_id ) {
		$recommendation_list = recommendation_class::g()->get( array( 'post_parent' => $society_id, 'posts_per_page' => -1 ), array( '\digi\recommendation_category_term', '\digi\recommendation_term' ) );
		view_util::exec( 'recommendation', 'list', array( 'society_id' => $society_id, 'recommendation_list' => $recommendation_list ) );
	}

	public function transfert() {
		// Récupères toutes les unités de travail avec leurs recommendations
		$list_workunit = workunit_class::g()->get( array() );

		if ( !empty( $list_workunit ) ) {
		  foreach ( $list_workunit as $workunit ) {
				if ( !empty( $workunit->associated_recommendation ) ) {
				  foreach ( $workunit->associated_recommendation as $recommendation_term_id => $list_recommendation ) {
						if ( !empty( $list_recommendation ) ) {
							$recommendation_term = recommendation_term_class::g()->get( array( 'include' => array( $recommendation_term_id ) ) );
							$recommendation_term = $recommendation_term[0];

						  foreach ( $list_recommendation as $element ) {
								$recommendation_args = array(
									'status'							=> ( ( 'valid' == $element['status'] ) ? 'publish' : 'trash' ),
									'unique_key' 					=> $element['unique_key'],
									'unique_identifier' 	=> $element['unique_identifier'],
									'efficiency'					=> $element['efficiency'],
									'recommendation_type'	=> $element['type'],
									'date'								=> $element['affectation_date'],
									'date_modified'				=> $element['last_update_date'],
									'parent_id'						=> $workunit->id,
									'taxonomy' => array(
										'digi-recommendation' => array( $recommendation_term->id ),
										'digi-recommendation-category' => array( $recommendation_term->parent_id )
									)
								);

								$recommendation = recommendation_class::g()->update( $recommendation_args );

								$recommendation_comment_args = array(
									'post_id'		=> $recommendation->id,
									'date'			=> $recommendation->date,
									'author_id'	=> 0,
									'content'		=> $element['comment'],
									'status'		=> ( ( 'valid' == $element['status'] ) ? '-34070' : '-34071' ),
									'type'	=> recommendation_comment_class::g()->get_type(),
								);

								recommendation_comment_class::g()->update( $recommendation_comment_args );
						  }
						}
					}
				}
		  }
		}
		return true;
	}
}

recommendation_class::g();
