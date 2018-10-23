<?php
/**
 * Les fonctions helpers des modèles
 *
 * @package Evarisk\Plugin
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Construit l'identifiant unique d'un modèle
 *
 * @param  object $data Les données du modèle.
 * @return object       Les données du modèle avec l'identifiant
 */
function construct_identifier( $data ) {
	$model_name = get_class( $data );
	$controller_name = str_replace( 'model', 'class', $model_name );
	$controller_name = str_replace( 'Model', 'Class', $controller_name );
	$next_identifier = get_last_unique_key( $controller_name );

	if ( empty( $data->unique_key ) ) {
		$data->unique_key = (int) ( $next_identifier + 1 );
	}

	if ( empty( $data->unique_identifier ) ) {
		$data->unique_identifier = $controller_name::g()->element_prefix . ( $next_identifier + 1 );
	}

	return $data;
}

/**
 * Remplaces l'identifiant du modèle par l'identifiant personnalisé qui se trouve dans la BDD
 *
 * @since 6.0.0
 * @version 6.3.0
 *
 * @param  object $data Les données du modèle.
 * @return object       Les données du modèle avec l'identifiant personnalisé
 */
function get_identifier( $data ) {
	$data->modified_unique_identifier = '';

	$list_accronym = get_option( \eoxia001\Config_Util::$init['digirisk']->accronym_option );
	$list_accronym = json_decode( $list_accronym, true );
	if ( isset( $data->type ) ) {
		$type = str_replace( 'digi-', '\\digi\\', $data->type );
		if ( ! empty( $type ) && class_exists( $type . '_class' ) ) {
			$type .= '_class';
			$element_prefix = $type::g()->element_prefix;

			if ( ! empty( $data->unique_identifier ) && ! empty( $list_accronym[ $element_prefix ] ) ) {
				$data->modified_unique_identifier = str_replace( $element_prefix, $list_accronym[ $element_prefix ]['to'], $data->unique_identifier );
			}
		}
	}

	return $data;
}


/**
 * Convertie la date au format SQL vers le format français
 *
 * @param  object $data Les donnnées du modèle.
 * @return object       Les donnnées du modèle avec la date au format SQL
 */
function convert_date_display( $data ) {
	$data->date = ! empty( $data->date ) ? date( 'd/m/Y', strtotime( $data->date ) ) : current_time( 'd/m/Y' );

	return $data;
}

/**
 * Construit les initiales des utilisateurs
 *
 * @param  \digi\User_class $user Les données de l'utilisateur.
 * @return \digi\User_class       Les données de l'utilisateur avec les intiales
 */
function build_user_initial( $user ) {
	$initial = '';

	if ( ! empty( $user->firstname ) ) {
		$initial .= substr( $user->firstname, 0, 1 );
	}
	if ( ! empty( $user->lastname ) ) {
		$initial .= substr( $user->lastname, 0, 1 );
	}

	if ( empty( $initial ) ) {
		if ( ! empty( $user->login ) ) {
			$initial .= substr( $user->login, 0, 1 );
		}
	}

	$user->initial = $initial;

	return $user;
}

/**
 * Initialise le tableau avec les couleurs possibles pour l'utilisateur
 *
 * @param  \digi\User_class $user Les données de l'utilisateur.
 * @return \digi\User_class       Les données de l'utilisateur avec la couleur.
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

	$user->avatar_color = $avatar_color[ array_rand( $avatar_color, 1 ) ];

	return $user;
}

/**
 * Force la couleur d'un tuilisateur
 *
 * @param  User_Class $user Les données de l'utilisateur.
 * @return User_Class       Les données de l'utilisateur avec la couleur forcé.
 */
function force_avatar_color( $user ) {
	$user->avatar_color = '50a1ed';
	return $user;
}

/**
 * Renvoie la dernière clé unique selon le type de l'élement
 *
 * @since 6.3.1
 * @version 6.3.1
 *
 * @param  string $controller Le controller.
 * @return int             		L'identifiant unique
 */
function get_last_unique_key( $controller ) {
	$element_type = $controller::g()->get_post_type();
	$wp_type = $controller::g()->get_identifier_helper();
	if ( empty( $wp_type ) || empty( $element_type ) || ! is_string( $wp_type ) || ! is_string( $element_type ) ) {
		return false;
	}

	global $wpdb;
	switch ( $wp_type ) {
		case 'post':
			$query = $wpdb->prepare(
				"SELECT max( PM.meta_value + 0 )
				FROM {$wpdb->postmeta} AS PM
					INNER JOIN {$wpdb->posts} AS P ON ( P.ID = PM.post_id )
				WHERE PM.meta_key = %s
					AND P.post_type = %s", '_wpdigi_unique_key', $element_type );
		break;

		case 'comment':
			$query = $wpdb->prepare(
				"SELECT max( CM.meta_value + 0 )
				FROM {$wpdb->commentmeta} AS CM
					INNER JOIN {$wpdb->comments} AS C ON ( C.comment_ID = CM.comment_id )
				WHERE CM.meta_key = %s
					AND C.comment_type = %s", '_wpdigi_unique_key', $element_type );
		break;

		case 'user':
			$query = $wpdb->prepare(
				"SELECT max( UM.meta_value + 0 )
				FROM {$wpdb->usermeta} AS UM
				WHERE UM.meta_key = %s", '_wpdigi_unique_key' );
		break;

		case 'term':
			$query = $wpdb->prepare(
				"SELECT max( TM.meta_value + 0 )
				FROM {$wpdb->term_taxonomy} AS T
					INNER JOIN {$wpdb->termmeta} AS TM ON ( T.term_id = TM.term_id )
				WHERE TM.meta_key = %s AND T.taxonomy=%s", '_wpdigi_unique_key', $element_type );
		break;
	}

	if ( ! empty( $query ) ) {
		$last_unique_key = $wpdb->get_var( $query );
	}

	if ( empty( $last_unique_key ) ) {
		return 0;
	}

	return $last_unique_key;
}
