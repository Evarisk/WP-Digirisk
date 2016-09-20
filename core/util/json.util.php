<?php if ( !defined( 'ABSPATH' ) ) exit;

/**
 * @author Jimmy Latour <jimmy.eoxia@gmail.com>
 * @version 1.0
 */

class json_util extends singleton_util {
	protected function construct() {}

  public function decode( $json_to_decode ) {
		if ( !is_string( $json_to_decode ) ) {
			return $json_to_decode;
		}

		$json_decoded = json_decode( $json_to_decode, true );

		if ( !$json_decoded ) {
			$json_to_decode = str_replace( '\\', '', $json_to_decode );
			$json_decoded = json_decode( $json_to_decode, true );

			if ( !$json_decoded ) {
				return $json_to_decode;
			}
		}

		return $json_decoded;
	}
}
