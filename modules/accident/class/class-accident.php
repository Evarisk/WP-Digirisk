<?php
/**
 * Classe gérant les accidents.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Classes
 *
 * @since     6.1.5
 */

namespace digi;

defined( 'ABSPATH' ) || exit;

/**
 * La classe gérant les accidents
 */
class Accident_Class extends Document_Class {

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
	protected $type = 'digi-accident';

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
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Accidents';

	/**
	 * Affiches la fenêtre principale des accidents
	 *
	 * @param integer $society_id L'ID de la société.
	 *
	 * @since 6.1.5
	 */
	public function display_page() {
		$this->register_search();

		\eoxia\View_Util::exec( 'digirisk', 'accident', 'main' );
	}

	public function register_search( $user_values = array(), $post_values = array() ) {
		global $eo_search;

		$args_accident_user = array(
			'type'  => 'user',
			'name'  => 'accident[victim_identity_id]',
			'icon'  => 'fa-search'
		);

		$args_accident_user = wp_parse_args( $args_accident_user, $user_values );

		$eo_search->register_search( 'accident_user', $args_accident_user );

		$args_accident_post = array(
			'type'  => 'post',
			'name'  => 'accident[parent_id]',
			'args' => array(
				'model_name' => array(
					'\digi\Group_Class',
					'\digi\Workunit_Class',
				),
				'meta_query' => array(
					'relation' => 'OR',
					array(
						'key' => '_wpdigi_unique_identifier',
						'compare' => 'LIKE',
					),
					array(
						'key' => '_wpdigi_unique_key',
						'compare' => 'LIKE',
					),
				)
			),
			'icon' => 'fa-search'
		);

		$args_accident_post = wp_parse_args( $args_accident_post, $post_values );


		$eo_search->register_search( 'accident_post', $args_accident_post );
	}

	/**
	 * Affiches la fenêtre pour imprimer un registre d'accidents.
	 *
	 * @param integer $society_id L'ID de la société.
	 */
	public function display_registre( $society_id ) {
		\eoxia\View_Util::exec( 'digirisk', 'accident', 'registre-accident/main', array() );
	}

	/**
	 * DISPLAY - Génération de l'affichage des risques à partir d'un shortcode
	 *
	 * @since 6.3.0
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
