<?php

if ( !defined( 'ABSPATH' ) ) exit;

function construct_identifier( $data ) {
	$model_name = get_class( $data );
	$parent_class_name = get_parent_class( $data );
	$controller_name = str_replace( 'model', 'class', $model_name );
	$parent_controller_name = str_replace( 'model', 'class', $parent_class_name );
	$next_identifier = wpdigi_utils::get_last_unique_key( $parent_controller_name::g()->get_post_type(), $controller_name::g()->get_post_type() );
	$data->unique_key = (int)( $next_identifier + 1 );
	$data->unique_identifier = $controller_name::g()->element_prefix . ( $next_identifier + 1 );
	return $data;
}

function convert_date( $data ) {
	if ( !empty( $data ) && !empty( $data->date ) ) {
		$data->date = date( 'Y-m-d', strtotime( str_replace( '/', '-', $data->date ) ) );
	}

	return $data;
}

?>
