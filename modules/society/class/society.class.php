<?php
/**
 * Classe gérant les sociétés (groupement et unité de travail)
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package society
 * @subpackage class
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classe gérant les sociétés (groupement et unité de travail)
 */
class Society_Class extends \eoxia\Post_Class {
	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\digi\Society_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $post_type = 'digi-society';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_wpdigi_society';

	/**
	 * Le préfixe de l'objet dans DigiRisk
	 *
	 * @var string
	 */
	public $element_prefix = 'S';

	/**
	 * La fonction appelée automatiquement avant la création de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_post_function = array( '\digi\construct_identifier' );

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
	protected $after_get_function = array( '\digi\get_identifier', '\digi\get_full_society' );

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'society';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Sociétés';

	/**
	 * Récupères l'objet par rapport à son post type
	 *
	 * @param integer $id L'ID de l'objet.
	 *
	 * @return boolean|object L'objet
	 *
	 * @since 0.1
	 * @version 6.2.5.0
	 */
	public function show_by_type( $id ) {
		$id = (int) $id;

		if ( ! is_int( (int) $id ) ) {
			return false;
		}

		$post_type = get_post_type( $id );

		if ( ! $post_type ) {
			return false;
		}

		$model_name = '\digi\\' . str_replace( 'digi-', '', $post_type ) . '_class';
		$establishment = $model_name::g()->get( array( 'include' => array( $id ) ) );

		if ( empty( $establishment[0] ) ) {
			return false;
		}

		return $establishment[0];
	}

	/**
	 * Met à jour par rapport au post type de l'objet
	 *
	 * @param object $establishment L'objet à mêttre à jour.
	 *
	 * @return object L'objet mis à jour
	 *
	 * @since 0.1
	 * @version 6.2.5.0
	 */
	public function update_by_type( $establishment ) {
		if ( ! is_object( $establishment ) && ! is_array( $establishment ) ) {
			return false;
		}

		$type = ( is_object( $establishment ) && isset( $establishment->type ) ) ? $establishment->type : '';

		if ( empty( $type ) ) {
			$type = ( is_array( $establishment ) && ! empty( $establishment['type'] ) ) ? $establishment['type'] : '';
		}

		if ( empty( $type ) ) {
			return false;
		}

		$model_name = '\digi\\' . str_replace( 'digi-', '', $type ) . '_class';

		if ( '\digi\_class' === $model_name ) {
			return false;
		}

		$establishment = $model_name::g()->update( $establishment );
		return $establishment;
	}

	/**
	 * Récupères l'adresse du groupement
	 *
	 * @param  mixed $society Les données de la société.
	 * @return Address_Model  L'adresse du groupement ou le schéma d'une adresse.
	 *
	 * @since 0.1
	 * @version 6.2.5.0
	 */
	public function get_address( $society ) {
		$args_address = array( 'schema' => true );

		if ( ! empty( $society->contact['address_id'] ) ) {
			$args_address = array( 'comment__in' => array( max( $society->contact['address_id'] ) ) );
		}

		$address = Address_Class::g()->get( $args_address );

		return $address;
	}
}

Society_Class::g();
