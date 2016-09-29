<?php

namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

/**
 * @author Jimmy Latour <jimmy.eoxia@gmail.com>
 * @version 1.0
 */

class csv_util extends singleton_util {
	protected function construct() {}

  public function read_and_set_index( $csv_path, $list_index = array() ) {
		if ( empty( $csv_path ) ) {
			return false;
		}

		$data = array();
		$csv_content = file( $csv_path );
		if ( !empty( $csv_content ) ) {
			foreach ( $csv_content as $key => $line ) {
				if ( $key != 0 ) {
					$data[$key] = str_getcsv( $line );
					foreach ( $data[$key] as $i => $entry ) {
						if ( !empty( $list_index[$i]) ) {
							$data[$key][$list_index[$i]] = $entry;
						}
					}
				}
			}
		}

		return $data;
	}
}
