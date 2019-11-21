<?php
/**
 * Gestion des filtres globaux concernant les utilisateurs dans EO_Framework.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 1.0.0
 * @version 1.0.0
 * @copyright 2015-2018 Eoxia
 * @package EO_Framework\EO_Model\Filter
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gestion des filtres globaux concernant les champs de type "float" dans EO_Framework.
 */
class User_Filter {

	/**
	 * Initialisation et appel des différents filtres définis dans EO_Framework.
	 */
	public function __construct() {
		add_filter( 'eo_model_user_after_get', array( $this, 'build_user_initial' ), 5, 2 );

		add_filter( 'eo_model_user_after_put', array( $this, 'after_save_users' ), 5, 2 );
		add_filter( 'eo_model_user_after_post', array( $this, 'after_save_users' ), 5, 2 );

		add_filter( 'eo_model_user_after_get_meta', array( $this, 'after_get_meta_users' ), 5, 2 );
	}

	/**
	 * Construit les initiales des utilisateurs
	 *
	 * @since 0.1.0
	 * @version 1.0.0
	 *
	 * @param  User_class $user Les données de l'utilisateur.
	 * @return User_class       Les données de l'utilisateur avec les intiales
	 */
	function build_user_initial( $user ) {
		$initial = '';

		if ( ! empty( $user['data']['firstname'] ) ) {
			$initial .= substr( $user['data']['firstname'], 0, 1 );
		}
		if ( ! empty( $user['data']['lastname'] ) ) {
			$initial .= substr( $user['data']['lastname'], 0, 1 );
		}
		if ( empty( $initial ) ) {
			if ( ! empty( $user['data']['login'] ) ) {
				$initial .= substr( $user['data']['login'], 0, 1 );
			}
		}

		$user->data['initial'] = $initial;

		return $user;
	}

	/**
	 * Construit la couleur de fond de l'avatar.
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param  Array $user Les données de l'utilisateur.
	 *
	 * @return Array       Les données de l'utilisateur avec la couleur de fond de l'avatar.
	 */
	function build_avatar_color( $user ) {
		$avatar_color = array(
			'e9ad4f',
			'50a1ed',
			'e05353',
			'e454a2',
			'47e58e',
			'734fe9',
		);

		$user['data']['avatar_color'] = $avatar_color[ array_rand( $avatar_color, 1 ) ];

		return $user;
	}

	/**
	 * Execute des actions complémentaire après avoir mis à jour un objet de type "User"
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param User_Model $object L'objet qu'il faut "modifier".
	 * @param array      $args   Les paramètres complémentaires permettant de modifier l'objet.
	 *
	 * @return User_Model L'objet de type User "modifié" par le helper.
	 */
	function after_save_users( $object, $args ) {
		// Mise à jour des metas.
		Save_Meta_Class::g()->save_meta_data( $object, 'update_user_meta', $args['meta_key'] );

		return $object;
	}

	/**
	 * Execute des actions complémentaire après avoir récupéré les métadonnées d'un objet de type "User"
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @param User_Model $object L'objet qu'il faut "modifier".
	 * @param array      $args   Les paramètres complémentaires permettant de modifier l'objet.
	 *
	 * @return User_Model L'objet de type User "modifié" par le helper.
	 */
	function after_get_meta_users( $object, $args ) {

		if ( ! empty( $object['data'] ) ) {
			$object = array_merge( $object, (array) $object['data'] );
			unset( $object['data'] );
		}

		return $object;
	}
}

new User_Filter();
