<?php
/**
 * La classe gérant les causeries
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.5.0
 * @version 6.6.0
 * @copyright 2015-2018 Evarisk
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
	 * Affiches la fenêtre principale des causeries
	 *
	 * @since 6.6.0
	 * @version 6.6.0
	 *
	 * @return void
	 */
	public function display() {
		$id = ! empty( $_GET['id'] ) ? (int) $_GET['id'] : 0; // WPCS: CSRF ok.

		if ( ! empty( $id ) ) {
			Causerie_Start_Class::g()->display_single( $id );
		} else {
			\eoxia\View_Util::exec( 'digirisk', 'causerie', 'main' );
		}
	}
}

Causerie_Class::g();
