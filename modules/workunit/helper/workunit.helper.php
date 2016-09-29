<?php namespace digi;

function filter_by_affected_user_id( $data, $args ) {
	if ( !empty( $data->user_info['affected_id']['user'][$args['user_id']] ) ) {
		return $data;
	}

	return false;
}

?>
