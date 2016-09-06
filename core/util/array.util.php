<?php if ( !defined( 'ABSPATH' ) ) exit;

/**
 * @author Jimmy Latour <jimmy.eoxia@gmail.com>
 * @version 1.0
 */

class array_util extends singleton_util {
	protected function construct() {}

  public function count_recursive( $array, $start = true, $match_element = array() ) {
		$count = 0;

		if ( $start ) {
			$count = count( $array );
		}

		if ( !empty( $array ) ) {
			foreach( $array as $id => $_array ) {
				if ( is_array( $_array ) ) {
					if ( is_string( $id ) && !empty( $match_element ) && in_array( $id, $match_element ) ) {
						$count += count( $_array );
					}

					$count += $this->count_recursive( $_array, false, $match_element );
				}
			}
		}

		return $count;
	}
}
