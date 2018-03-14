<?php
/**
 * La classe gérant les accidents
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.3.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * La classe gérant les accidents
 */
class Accident_Class extends \eoxia\Post_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Accident_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $post_type = 'digi-accident';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'accident';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_accident';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'A';

	/**
	 * La fonction appelée automatiquement avant la création de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_post_function = array();

	/**
	 * La fonction appelée automatiquement avant la modification de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_put_function = array();

	/**
	 * La fonction appelée automatiquement après la récupération de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $after_get_function = array( '\digi\get_identifier', '\digi\get_full_accident' );

	/**
	 * La fonction appelée automatiquement après la création de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $after_post_function = array( '\digi\get_identifier', '\digi\get_full_accident', '\digi\accident_compile_stopping_days' );

	/**
	 * La fonction appelée automatiquement après la mise à jour de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $after_put_function = array( '\digi\get_identifier', '\digi\get_full_accident', '\digi\accident_compile_stopping_days' );

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Accidents';

	/**
	 * Affiches la fenêtre principale des accidents
	 *
	 * @since 6.3.0
	 * @version 6.3.0
	 *
	 * @param integer $society_id L'ID de la société.
	 * @return void
	 */
	public function display( $society_id ) {
		\eoxia\View_Util::exec( 'digirisk', 'accident', 'main', array() );
	}

	/**
	 * Affiches la fenêtre pour imprimer un registre d'accidents.
	 *
	 * @param integer $society_id L'ID de la société.
	 * @return void
	 */
	public function display_registre( $society_id ) {
		\eoxia\View_Util::exec( 'digirisk', 'accident', 'registre-accident/main', array() );
	}

	/**
	 * DISPLAY - Génération de l'affichage des risques à partir d'un shortcode / Generate display for accidents through shortcode
	 *
	 * @since 6.3.0
	 * @version 6.3.0
	 * @return void
	 */
	public function display_accident_list() {
		$main_society = Society_Class::g()->get( array(
			'posts_per_page' => 1,
		), true );

		$accident_schema = $this->get( array(
			'schema' => true,
		), true );

		$accidents = $this->get( array() );

		\eoxia\View_Util::exec( 'digirisk', 'accident', 'list', array(
			'main_society' => $main_society,
			'accident_schema' => $accident_schema,
			'accidents' => $accidents,
		) );
	}
}

Accident_Class::g();
