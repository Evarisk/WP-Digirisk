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
	$next_identifier = common_util::get_last_unique_key( $controller_name );
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
 * @param  object $data Les données du modèle.
 * @return object       Les données du modèle avec l'identifiant personnalisé
 */
function get_identifier( $data ) {
	$list_accronym = get_option( config_util::$init['digirisk']->accronym_option );
	$list_accronym = json_decode( $list_accronym, true );
	$model_name = get_class( $data );
	$controller_name = str_replace( 'model', 'class', $model_name );
	$controller_name = str_replace( 'Model', 'Class', $controller_name );
	$element_prefix = $controller_name::g()->element_prefix;

	if ( ! empty( $data->unique_identifier ) && ! empty( $list_accronym[ $element_prefix ] ) ) {
		$data->unique_identifier = str_replace( $element_prefix, $list_accronym[ $element_prefix ]['to'], $data->unique_identifier );
	}

	return $data;
}

/**
 * Convertie la date au format français dd/mm/yy en format SQL
 *
 * @param  object $data Les donnnées du modèle.
 * @return object       Les donnnées du modèle avec la date au format SQL
 */
function convert_date( $data ) {
	if ( ! empty( $data ) && ! empty( $data->date ) ) {
		$data->date = date( 'Y-m-d', strtotime( str_replace( '/', '-', $data->date ) ) );
	}

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
