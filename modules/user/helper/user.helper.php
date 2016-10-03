<?php

namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

function construct_login( $data ) {
	$data['login'] = trim( strtolower( remove_accents( sanitize_user( $data['firstname'] . $data['lastname'] ) ) ) );
	return $data;
}

function generate_password( $data ) {
	if ( empty( $data['password'] ) ) {
		$data['password'] = wp_generate_password();
	}

	return $data;
}

function get_hiring_date( $data ) {
	if ( !empty( $data ) && !empty( $data->id ) ) {
		$data_information = get_the_author_meta( 'digirisk_user_information_meta', $data->id );
		$data->hiring_date = !empty( $data_information['digi_hiring_date'] ) ? $data_information['digi_hiring_date'] : current_time( 'Y-m-d' );
	}

	return $data;
}

?>
