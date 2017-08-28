<?php
/**
 * La classe gérant les accidents
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.3.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * La classe gérant les accidents
 */
class Accident_Class extends \eoxia\Post_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name   = '\digi\accident_model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $post_type    = 'digi-accident';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key    	= '_wpdigi_accident';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'AC';

	/**
	 * La fonction appelée automatiquement avant la création de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_post_function = array( '\digi\construct_identifier', '\eoxia\convert_date' );

	/**
	 * La fonction appelée automatiquement avant la modification de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_put_function = array( '\eoxia\convert_date' );

	/**
	 * La fonction appelée automatiquement après la récupération de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $after_get_function = array( '\digi\get_identifier', '\digi\convert_date_display' );


	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Accidents';

	/**
	 * Constructeur obligatoire pour Singleton_Util
	 *
	 * @since 6.3.0
	 * @version 6.3.0
	 * @return void
	 */
	protected function construct() {
		parent::construct();
	}

	/**
	 * Affiches la fenêtre principale des accidents
	 *
	 * @param  integer $society_id L'ID de la société.
	 *
	 * @since 6.3.0
	 * @version 6.3.0
	 * @return void
	 */
	public function display( $society_id ) {
		$accident_schema = $this->get( array(
			'schema' => true,
		), true );

		$accidents = $this->get( array(
			'post_parent' => $society_id,
		) );

		\eoxia\View_Util::exec( 'digirisk', 'accident', 'main', array(
			'accident_schema' => $accident_schema,
			'accidents' => $accidents,
			'society_id' => $society_id,
		) );
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

		\eoxia\View_Util::exec( 'digirisk', 'accident', 'list', array(
			'society' => $society,
			'accident_list' => $accident_list,
		) );
	}
}
