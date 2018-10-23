<?php

namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

function get_hiring_date( $data ) {
	if ( !empty( $data ) && !empty( $data->id ) ) {
		$data_information = get_the_author_meta( 'digirisk_user_information_meta', $data->id );
		$data->hiring_date = !empty( $data_information['digi_hiring_date'] ) ? $data_information['digi_hiring_date'] : current_time( 'Y-m-d' );
	}

	return $data;
}

?>
