<?php
/**
 * Classe gérant les sociétés (groupement et unité de travail)
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.1.6
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
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
	protected $type = 'digi-society';

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
	 * Récupères les données de la société courante selon la superglobale "society_id" ou sinon récupères la première societé depuis la base de donnée.
	 *
	 * @since 7.0.0
	 * @version 7.0.0
	 *
	 * @return Society_Model|Group_Model|Workunit_Model Renvoies les données de la société courante.
	 */
	public function get_current_society() {
		$society_id = 0;

		if ( ! empty( $_REQUEST['society_id'] ) ) { // WPCS: CSRF ok.
			$society_id = (int) $_REQUEST['society_id'];
		}

		if ( 0 === $society_id ) {
			$society = self::g()->get( array(
				'posts_per_page' => 1,
			), true );
		} else {
			$society = $this->show_by_type( $society_id );
		}

		return $society;
	}

	/**
	 * Récupères l'objet par rapport à son post type
	 *
	 * @param integer $id L'ID de l'objet.
	 *
	 * @return boolean|object L'objet
	 *
	 * @since 6.0.0
	 * @version 7.0.0
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

		$model_name    = '\digi\\' . str_replace( 'digi-', '', $post_type ) . '_class';
		$establishment = $model_name::g()->get( array( 'id' => $id ), true );

		return $establishment;
	}

	/**
	 * Met à jour par rapport au post type de l'objet
	 *
	 * @param object $establishment L'objet à mêttre à jour.
	 *
	 * @return object L'objet mis à jour
	 *
	 * @since   6.0.0
	 */
	public function update_by_type( $establishment ) {
		if ( ! is_object( $establishment ) && ! is_array( $establishment ) ) {
			return false;
		}

		$type = ( is_object( $establishment ) && isset( $establishment->data['type'] ) ) ? $establishment->data['type'] : '';

		if ( empty( $type ) ) {
			return false;
		}

		$model_name = '\digi\\' . str_replace( 'digi-', '', $type ) . '_class';

		if ( '\digi\_class' === $model_name ) {
			return false;
		}

		$establishment = $model_name::g()->update( $establishment->data );
		return $establishment;
	}

	/**
	 * Récupères toutes les sociétés enfants à $society_id correspondant à $status par ordre croissant de la clé _wpdigi_unique_key.
	 *
	 * @since   7.0.0
	 *
	 * @param  integer $society_id L'ID de la société parent.
	 * @param  string  $status     Le status des sociétés enfant. Inherit par défaut.
	 * @param  boolean $recursive  True pour rendre recursive la récupération
	 * des sociétés.
	 *
	 * @return array               Un tableau contenant toutes les sociétés enfant.
	 */
	public function get_societies_in( $society_id, $status = 'inherit', $recursive = false ) {
		if ( 0 !== $society_id ) {
			$societies = $this->get( array(
				'post_parent'    => $society_id,
				'posts_per_page' => -1,
				'post_type'      => array( 'digi-group', 'digi-workunit' ),
				'post_status'    => $status,
				'meta_key'       => '_wpdigi_unique_key',
				'orderby'        => array(
					'menu_order'     => 'ASC',
					'meta_value_num' => 'ASC',
				),
			) ); // WPCS: slow query ok.
		} else {
			$societies = $this->get( array(
				'posts_per_page' => 1,
				'post_status'    => 'publish',
			) );
		}

		if ( $recursive && ! empty( $societies ) ) {
			foreach ( $societies as &$society ) {
				$society->data['childrens'] = $this->get_societies_in( $society->data['id'], 'inherit', true );
			}
		}

		return $societies;
	}

	/**
	 * Récupères l'adresse du groupement
	 *
	 * @param  mixed $society Les données de la société.
	 * @return Address_Model  L'adresse du groupement ou le schéma d'une adresse.
	 *
	 * @since   6.0.0
	 */
	public function get_address( $society ) {
		$last_address_id = 0;

		if ( ! empty( $society->data['contact']['address_id'] ) ) {
			$last_address_id = end( $society->data['contact']['address_id'] );
		}

		if ( ! empty( $last_address_id ) ) {
			$address = Address_Class::g()->get( array( 'id' => $last_address_id ), true );
		} else {
			$address = Address_Class::g()->get( array( 'schema' => true ), true );
		}

		return $address;
	}

	/**
	 * Supprimes les enfants de la société parent supprimée.
	 *
	 * @param  integer $id l'ID de la société parent supprimée.
	 */
	public function delete_child( $id ) {
		$posts = get_posts( array(
			'post_type'      => array( 'digi-group', 'digi-workunit' ),
			'post_parent'    => $id,
			'posts_per_page' => -1,
			'post_status'    => array( 'publish', 'inherit' ),
		) );

		if ( ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				$post->post_status = 'trash';

				$this->delete_child( $post->ID );

				wp_update_post( $post );
			}
		}
	}
}

Society_Class::g();
