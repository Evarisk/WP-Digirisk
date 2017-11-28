<?php
/**
 * La classe gérant les causeries
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.5.0
 * @version 6.5.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * La classe gérant les causeries
 */
class Causerie_Class extends \eoxia\Post_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Causerie_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $post_type = 'digi-causerie';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'causerie';

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
	protected $meta_key = '_wpdigi_causerie';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'C';

	/**
	 * La fonction appelée automatiquement avant la création de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_post_function = array( '\digi\construct_identifier', '\digi\get_identifier' );

	/**
	 * La fonction appelée automatiquement avant la modification de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_put_function = array( '\digi\get_identifier' );

	/**
	 * La fonction appelée automatiquement après la récupération de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $after_get_function = array( '\digi\get_identifier', '\digi\get_full_causerie' );

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Causeries';

	/**
	 * Affiches la fenêtre principale des accidents
	 *
	 * @since 6.5.0
	 * @version 6.5.0
	 *
	 * @param integer $society_id L'ID de la société.
	 * @return void
	 */
	public function display( $society_id ) {
		$society = Society_Class::g()->show_by_type( $society_id );

		$causerie_schema = Causerie_Society_Class::g()->get( array(
			'schema' => true,
		), true );

		$causeries = Causerie_Society_Class::g()->get( array(
			'post_parent' => $society_id,
		) );

		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'society/main', array(
			'society_id' => $society_id,
			'society' => $society,
			'causerie_schema' => $causerie_schema,
			'causeries' => $causeries,
		) );
	}
}

Causerie_Class::g();
