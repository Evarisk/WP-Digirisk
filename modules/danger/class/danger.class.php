<?php
/**
 * Classe gérant les dangers
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.5.0
 * @copyright 2015-2017 Evarisk
 * @package danger
 * @subpackage class
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Classe gérant les dangers
 */
class Danger_Class extends Term_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\danger_model';

	/**
	 * La taxonomie
	 *
	 * @var string
	 */
	protected $taxonomy    	= 'digi-danger';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key    	= '_wpdigi_danger';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'digirisk/danger';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';

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
	protected $after_get_function = array( '\digi\get_identifier' );

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'D';

	/**
	 * Le constructeur
	 *
	 * @since 0.1
	 * @version 6.2.5.0
	 */
	protected function construct() {
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}

	/**
	 * Récupères le nom du danger par rapport à son ID
	 *
	 * @param integer $danger_id L'ID du danger.
	 *
	 * @return string Le nom du danger
	 *
	 * @since 0.1
	 * @version 6.2.5.0
	 */
	public function get_name_by_id( $danger_id ) {
		if (  true !== is_int( (int) $danger_id ) ) {
			return false;
		}

		$term = get_term_field( 'name', $danger_id, $this->taxonomy );

		return $term;
	}

	/**
	 * Récupères le term parent selon l'ID du danger enfant
	 *
	 * @param integer $danger_id L'ID du danger enfant.
	 *
	 * @return integer
	 *
	 * @since 0.1
	 * @version 6.2.5.0
	 */
	public function get_parent_by_id( $danger_id ) {
		if (  true !== is_int( (int) $danger_id ) ) {
			return false;
		}

		$term = get_term_field( 'parent', $danger_id, $this->taxonomy );

		return $term;
	}

}

Danger_Class::g();
