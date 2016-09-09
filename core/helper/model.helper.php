<?php

if ( !defined( 'ABSPATH' ) ) exit;

function construct_identifier( $data ) {
	$model_name = get_class( $data );
	$parent_class_name = get_parent_class( $data );
	$controller_name = str_replace( 'model', 'class', $model_name );
	$parent_controller_name = str_replace( 'model', 'class', $parent_class_name );
	$next_identifier = wpdigi_utils::get_last_unique_key( $parent_controller_name::g()->get_post_type(), $controller_name::g()->get_post_type() );
	if ( empty( $data->unique_key ) ) {
		$data->unique_key = (int)( $next_identifier + 1 );
	}

	if ( empty( $data->unique_identifier ) ) {
		$data->unique_identifier = $controller_name::g()->element_prefix . ( $next_identifier + 1 );
	}

	return $data;
}

function get_identifier( $data ) {
	$list_accronym = get_option( SETTING_OPTION_NAME_ACCRONYM );
	$list_accronym = json_decode( $list_accronym, true );
	$model_name = get_class( $data );
	$controller_name = str_replace( 'model', 'class', $model_name );
	$element_prefix = $controller_name::g()->element_prefix;

	if ( !empty( $data->unique_identifier ) && !empty( $list_accronym[$element_prefix] ) ) {
		$data->unique_identifier = str_replace( $element_prefix, $list_accronym[$element_prefix]['to'], $data->unique_identifier );
	}

	return $data;
}

function convert_date( $data ) {
	if ( !empty( $data ) && !empty( $data->date ) ) {
		$data->date = date( 'Y-m-d', strtotime( str_replace( '/', '-', $data->date ) ) );
	}

	return $data;
}

/**
 * Construit les initiales d'un utilisateurs donné / Build initial for a given user
 *
 * @param object $user Les données de l'utilisateur courant / Current user data
 *
 * @return string Les initiales de l'utilisateur courant / Current user initial
 */
function build_user_initial( $user ){
	$initial = '';

	if ( !empty( $user->firstname ) ) {
		$initial .= substr( $user->firstname, 0, 1 );
	}
	if ( !empty( $user->lastname ) ) {
		$initial .= substr( $user->lastname, 0, 1 );
	}

	if ( empty( $initial ) ) {
		if ( !empty( $user->login ) ) {
			$initial .= substr( $user->login, 0, 1 );
		}
	}

	$user->initial = $initial;

	return $user;
}

function build_avatar_color( $user ) {
	$avatar_color = array(
		'e9ad4f',
		'50a1ed',
		'e05353',
		'e454a2',
		'47e58e',
		'734fe9',
	);

	$user->avatar_color = $avatar_color[array_rand( $avatar_color, 1 )];

	return $user;
}

?>
