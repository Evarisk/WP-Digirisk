<?php
/**
 * Classe gérant les sociétés (groupement et unité de travail)
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.5.0
 * @copyright 2015-2017 Evarisk
 * @package society
 * @subpackage class
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Classe gérant les sociétés (groupement et unité de travail)
 */
class Society_Class extends Singleton_Util {

	/**
	 * Constructeur
	 *
	 * @since 0.1
	 * @version 6.2.5.0
	 */
	protected function construct() {}

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
