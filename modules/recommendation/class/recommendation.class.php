<?php
/**
 * Les préconisations
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package recommendation
 * @subpackage class
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les préconisations
 */
class Recommendation_Class extends Post_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name   = '\digi\recommendation_model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $post_type    = 'digi-recommendation';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key    	= '_wpdigi_recommendation';

	/**
	 * La fonction appelée automatiquement avant la création de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_post_function = array( '\digi\construct_identifier' );

	/**
	 * La fonction appelée automatiquement après la récupération de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $after_get_function = array( '\digi\get_identifier', '\digi\get_full_recommendation' );

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'digirisk/recommendation';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'PA';

	/**
	 * La limite des risques a affiché par page
	 *
	 * @var integer
	 */
	protected $limit_recommendation = -1;

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Recommandations';


	/**
	 * Le constructeur
	 *
	 * @return void
	 */
	protected function construct() {
		parent::construct();
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}

	/**
	 * Charges la liste des préconisations. Et appelle le template pour les afficher.
	 * Récupères le schéma d'une préconisations pour l'entrée d'ajout d'une préconisation dans le tableau.
	 *
	 * @param  integer $society_id L'ID de la société.
	 * @return void
	 *
	 * @since 0.1
	 * @version 6.2.4.0
	 */
	public function display( $society_id ) {
		$recommendation_schema = $this->get( array( 'schema' => true ) );
		$recommendation_schema = $recommendation_schema[0];

		$recommendations = $this->get( array( 'post_parent' => $society_id ) );

		view_util::exec( 'recommendation', 'list', array( 'society_id' => $society_id, 'recommendations' => $recommendations, 'recommendation_schema' => $recommendation_schema ) );
	}

	/**
	 * Transfères les préconisations
	 *
	 * @return bool
	 *
	 * @since 6.2.1.0
	 * @version 6.2.1.0
	 */
	public function transfert() {
		// Récupères toutes les unités de travail avec leurs recommendations.
		$list_workunit = workunit_class::g()->get( array() );

		if ( ! empty( $list_workunit ) ) {
			foreach ( $list_workunit as $workunit ) {
				if ( ! empty( $workunit->associated_recommendation ) ) {
					foreach ( $workunit->associated_recommendation as $recommendation_term_id => $list_recommendation ) {
						if ( ! empty( $list_recommendation ) ) {
							$recommendation_term = recommendation_term_class::g()->get( array( 'include' => array( $recommendation_term_id ) ) );
							$recommendation_term = $recommendation_term[0];

							foreach ( $list_recommendation as $element ) {
								$recommendation_args = array(
									'status'							=> ( ( 'valid' === $element['status'] ) ? 'publish' : 'trash' ),
									'unique_key' 					=> $element['unique_key'],
									'unique_identifier' 	=> $element['unique_identifier'],
									'efficiency'					=> $element['efficiency'],
									'recommendation_type'	=> $element['type'],
									'date'								=> $element['affectation_date'],
									'date_modified'				=> $element['last_update_date'],
									'parent_id'						=> $workunit->id,
									'taxonomy' => array(
										'digi-recommendation' => array( $recommendation_term->id ),
										'digi-recommendation-category' => array( $recommendation_term->parent_id ),
									),
								);

								$recommendation = recommendation_class::g()->update( $recommendation_args );

								$recommendation_comment_args = array(
									'post_id'		=> $recommendation->id,
									'date'			=> $recommendation->date,
									'author_id'	=> 0,
									'content'		=> $element['comment'],
									'status'		=> ( ( 'valid' === $element['status'] ) ? '-34070' : '-34071' ),
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

Recommendation_Class::g();
