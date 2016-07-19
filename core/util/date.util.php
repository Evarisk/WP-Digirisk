<?php if ( !defined( 'ABSPATH' ) ) exit;

/**
 * @author Jimmy Latour <jimmy.eoxia@gmail.com>
 * @version 1.0
 */

class date_util extends singleton_util {
	protected function construct() {}

  public function formatte_date( $date ) {
		if ( strlen( $date ) === 10 ) {
			$date .= " 00:00:00";
		}

		$date = str_replace( '/', '-', $date );
		$date = date("Y-m-d h:i:s", strtotime( $date ) );
		return $date;
	}
}
