<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

/**
 * @author Jimmy Latour <jimmy.eoxia@gmail.com>
 * @version 1.0
 */

class json_util extends singleton_util {
	protected function construct() {}

	public function open_and_decode( $path_to_json ) {
		if (!file_exists( $path_to_json ) ) {
			if ( function_exists( 'eo_log' ) ) {
				eo_log( 'digi_open_and_decode', array(
					'message' => 'Impossible d\'ouvrir le fichier json: ' . $path_to_json
				), 2 );
			}
			else {
				trigger_error( 'Impossible d\'ouvrir le fichier json: ' . $path_to_json, E_USER_ERROR );
			}
		}

		$config_content = file_get_contents( $path_to_json );

		$data = @json_decode( $config_content );

		if ( $data === null && json_last_error() !== JSON_ERROR_NONE ) {
			if ( function_exists( 'eo_log' ) ) {
				eo_log( 'digi_open_and_decode', array(
					'message' => 'Les données dans le fichier json: ' . $path_to_json . ' semble erronées'
				), 2 );
			}
			else {
				trigger_error( 'Les données dans le fichier json: ' . $path_to_json . ' semble erronées', E_USER_ERROR );
			}
		}

		if ( function_exists( 'eo_log' ) ) {
			eo_log( 'digi_open_and_decode', array(
				'message' => 'Le fichier json: ' . $path_to_json . ' sont : ' . json_encode( $data )
			), 2 );
		}

		return $data;
	}

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
